<?php # 

include_once dirname(__FILE__) . '/common.inc.php';


class serendipity_event_openid extends serendipity_event
{
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',        PLUGIN_OPENID_NAME);
        $propbag->add('description', PLUGIN_OPENID_DESC);
        $propbag->add('stackable',   false);
        $propbag->add('author',      'Grischa Brockhaus, Rob Richards');
        $propbag->add('version',     '1.2.1');
        $propbag->add('requirements',  array(
            'serendipity' => '1.2',
            'smarty'      => '2.6.7',
            'php'         => '5.1.3'
        ));
        $propbag->add('groups', array('BACKEND_USERMANAGEMENT'));
        $propbag->add('event_hooks', array(
            'backend_login'             => true,
            'backend_login_page'        => true,
            'backend_sidebar_entries_event_display_profiles' => true,
            'frontend_header'           => true,
            'external_plugin'			=> true
        ));

        $propbag->add('configuration', array(
            'plugin_desc',
            'select_authors',
            'delegation_desc',
            'server',
            'delegate',
            'xrds_location',
            'openid_version'
        ));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'plugin_desc':
                $propbag->add('type',        'content');
                $propbag->add('default',     PLUGIN_OPENID_DESCRIPTION);
                break;
            case 'select_authors':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_OPENID_LOGIN_USERS);
                $propbag->add('description', PLUGIN_OPENID_LOGIN_USERS_DESC);
                $propbag->add('default',     'true');
                break;
            case 'delegation_desc':
                $propbag->add('type',        'content');
                $propbag->add('default',     PLUGIN_OPENID_DELEGATION_DESCRIPTION);
                break;
            case 'server':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_OPENID_SERVER);
                $propbag->add('description', PLUGIN_OPENID_SERVER_DESC);
                $propbag->add('default',     '');
                break;
            case 'delegate':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_OPENID_DELEGATE);
                $propbag->add('description', PLUGIN_OPENID_DELEGATE_DESC);
                $propbag->add('default',     '');
                break;
            case 'xrds_location':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_OPENID_XRDS_LOC);
                $propbag->add('description', PLUGIN_OPENID_XRDS_LOC_DESC);
                $propbag->add('default',     '');
                break;
            case 'openid_version':
                $id_services = array(
                    'both'    => PLUGIN_OPENID_VERSION_SUPPORTED_BOTH,
                    'v2'      => PLUGIN_OPENID_VERSION_SUPPORTED_V2,
                    'v1'      => PLUGIN_OPENID_VERSION_SUPPORTED_V1,
                );
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_OPENID_VERSION_SUPPORTED);
                $propbag->add('description',    PLUGIN_OPENID_VERSION_SUPPORTED_DESC);
                $propbag->add('select_values',  $id_services);
                $propbag->add('default',  'both');
                break;
            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        $title = PLUGIN_OPENID_NAME;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;
        static $login_url = null;

        if ($login_url === null) {
            $login_url = $serendipity['baseURL'] . $serendipity['indexFile'] . '?/plugin/loginbox';
        }

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {

                case 'external_plugin' :
                    if ($eventData=="openid.png") {
                        header('Content-Type: image/png');
                        echo file_get_contents(dirname(__FILE__). '/img/openid.png');
                    }
                    elseif ($eventData=="oid_google.png") {
                        header('Content-Type: image/png');
                        echo file_get_contents(dirname(__FILE__). '/img/google.png');
                    }
                    elseif ($eventData=="oids_google.png") {
                        header('Content-Type: image/png');
                        echo file_get_contents(dirname(__FILE__). '/img/google_small.png');
                    }
                    elseif ($eventData=="oid_yahoo.png") {
                        header('Content-Type: image/png');
                        echo file_get_contents(dirname(__FILE__). '/img/yahoo.png');
                    }
                    elseif ($eventData=="oids_yahoo.png") {
                        header('Content-Type: image/png');
                        echo file_get_contents(dirname(__FILE__). '/img/yahoo_small.png');
                    }
                    elseif ($eventData=="oid_aol.png") {
                        header('Content-Type: image/png');
                        echo file_get_contents(dirname(__FILE__). '/img/aol.png');
                    }
                    elseif ($eventData=="oids_aol.png") {
                        header('Content-Type: image/png');
                        echo file_get_contents(dirname(__FILE__). '/img/aol_small.png');
                    }
                    break;
                case 'frontend_header':
                    $this->print_header();
                    break;

                case 'backend_login_page':
                    $hidden = array('action'=>'admin');
                    $useAutorSelector = $this->get_config('select_authors',true);
                    $eventData['header'] .= '<br/><div align="center">'.
                         serendipity_common_openid::loginform('serendipity_admin.php', $hidden, $useAutorSelector).
                         '</div>';
                    break;

                case 'backend_login':
                    return $this->do_login($eventData);
                                        
                case 'backend_sidebar_entries_event_display_profiles':
                    $this->print_sidebar();
                    return true;
                default:
                    return false;
            }
        } else {
            return false;
        }
    }
    
    function do_login(&$eventData) {
        global $serendipity;
        
        $inOpenIdChange = !empty($serendipity['POST']['openidflag']) && ($serendipity['POST']['openidflag']==3);
        if ($eventData && !$inOpenIdChange) { // Eventdata holds "isAuthentificated". So if she is, let her in.
            return true;
        }
        
        $openidurl = NULL;
        if (!empty($serendipity['POST']['openid_url'])) {
            $openidurl = $serendipity['POST']['openid_url'];
        }
        elseif (isset($_POST['openIDLoginGoogle_x']) || isset($_POST['openIDLoginGoogle_y'])) { // If the Google Button was pressed
            $openidurl = "https://www.google.com/accounts/o8/id";
        }
        elseif (isset($_POST['openIDLoginYahoo_x']) || isset($_POST['openIDLoginYahoo_y'])) { // If the Google Button was pressed
            $openidurl = "https://me.yahoo.com";
        }
        elseif (isset($_POST['openIDLoginAol_x']) || isset($_POST['openIDLoginAol_y'])) { // If the Google Button was pressed
            $openidurl = "https://www.aol.com";
        }
        
        if ($_SESSION['serendipityAuthedUser'] == true) {
            $eventData = serendipity_common_openid::reauth_openid();
            if (!empty($openidurl) && !empty($serendipity['POST']['openidflag'])) {
                /* Check that openid isn't already associated with another login */
                $tmpRet = serendipity_common_openid::redir_openidserver($openidurl, $this->get_consumertest_path(), 3);

                /* If updating an OpenID it is not a real login attempt */
                if (($tmpRet === false) && (($serendipity['GET']['openidflag']==3) || ($serendipity['POST']['openidflag']==3))) {
                    return;
                }
                $eventData = $tmpRet;
            } elseif (!empty($serendipity['POST']['openidflag'])) {
                $eventData = serendipity_common_openid::reauth_openid();
            }
        } else if (! empty($serendipity['GET']['openidflag']) && ($serendipity['GET']['openidflag']==1)) {
            $eventData = serendipity_common_openid::authenticate_openid($_GET, $this->get_consumertest_path());
        } else if (! empty($openidurl) && ! empty($serendipity['POST']['action'])) {
            $eventData = serendipity_common_openid::redir_openidserver($openidurl, $this->get_consumertest_path(), 1);
        }
        return $eventData;
    }
    
    function print_header() {
        $server = $this->get_config('server');
        $openidurl = $this->get_config('delegate');
        $xrdsloc = $this->get_config('xrds_location');
        if (! empty($server) && (! empty($openidurl) || ! empty($xrdsloc))) {
            $supported_version = $this->get_config('openid_version', 'both');
            if ('v1'==$supported_version) {
                $rel_oserver = "openid.server";
                $rel_odelegate = "openid.delegate";
            }
            elseif ('v2'==$supported_version) {
                $rel_oserver = "openid2.provider";
                $rel_odelegate = "openid2.local_id";
            }
            else {
                $rel_oserver = "openid.server openid2.provider";
                $rel_odelegate = "openid.delegate openid2.local_id";
            }
            /* Make sure linefeeds exist otherwise OpenID does not always work correctly */
            echo "\n";
            echo '<link rel="' . $rel_oserver .'" href="'.$server.'" />	'."\n";
            if (! empty($openidurl)) {
                echo '<link rel="' . $rel_odelegate .'" href="'.$openidurl.'" />	'."\n";
            }
            if (! empty($xrdsloc)) {
                echo '<meta http-equiv="X-XRDS-Location" content="'.$xrdsloc.'" />	'."\n";
            }
        }
    }
    
    function print_sidebar() {
        global $serendipity;
        
        if (($_SESSION['serendipityAuthedUser'] == true)) {
            if (! empty($serendipity['GET']['openidflag']) && ($serendipity['GET']['openidflag']==3)) {
                if ($checkRet = serendipity_common_openid::authenticate_openid($_GET, $this->get_consumertest_path(), true)) {
                    if (serendipity_common_openid::updateOpenID($checkRet['openID'], $serendipity['authorid'])) {
                        echo '<strong>' . (function_exists('serendipity_specialchars') ? serendipity_specialchars(PLUGIN_OPENID_UPDATE_SUCCESS) : htmlspecialchars(PLUGIN_OPENID_UPDATE_SUCCESS, ENT_COMPAT, LANG_CHARSET)) . '</strong><br /><br />';
                    } else {
                        echo '<strong>' . (function_exists('serendipity_specialchars') ? serendipity_specialchars(PLUGIN_OPENID_UPDATE_FAIL) : htmlspecialchars(PLUGIN_OPENID_UPDATE_FAIL, ENT_COMPAT, LANG_CHARSET)) . '</strong><br /><br />';
                    }
                } else {
                    echo '<strong>' . (function_exists('serendipity_specialchars') ? serendipity_specialchars(PLUGIN_OPENID_INVALID_RESPONSE) : htmlspecialchars(PLUGIN_OPENID_INVALID_RESPONSE, ENT_COMPAT, LANG_CHARSET)) . '</strong><br /><br />';
                }
                // Job done.
                unset($serendipity['GET']['openidflag']);
            } elseif (! empty($serendipity['POST']['openidflag']) && ($serendipity['POST']['openidflag']==3)) {
                echo '<strong>' . (function_exists('serendipity_specialchars') ? serendipity_specialchars(PLUGIN_OPENID_INVALID_RESPONSE) : htmlspecialchars(PLUGIN_OPENID_INVALID_RESPONSE, ENT_COMPAT, LANG_CHARSET)) . '</strong><br /><br />';
            }
        }
        $imgopenid = $serendipity['baseURL'] . 'index.php?/plugin/openid.png';
        $imggoogle = $serendipity['baseURL'] . 'index.php?/plugin/oids_google.png';
        $imgyahoo = $serendipity['baseURL'] . 'index.php?/plugin/oids_yahoo.png';
        $imgaol = $serendipity['baseURL'] . 'index.php?/plugin/oids_aol.png';
        
        echo '<div>';
        echo '<strong>' . (function_exists('serendipity_specialchars') ? serendipity_specialchars(PLUGIN_EVENT_OPENID_SELECT) : htmlspecialchars(PLUGIN_EVENT_OPENID_SELECT, ENT_COMPAT, LANG_CHARSET)) . '</strong><br /><br />';
        
        // To allow ENTER in the input line we have to create two forms:
        
        echo '<form action="?" method="post">';
        echo '<input type="hidden" name="serendipity[adminModule]" value="event_display" />';
        echo '<input type="hidden" name="serendipity[adminAction]" value="profiles" />';
        echo '<input type="hidden" name="serendipity[openidflag]" value="3" />';
        echo '<img src="' . $imgopenid . '" alt="OpenID URL"> <input type="text" size="50" name="serendipity[openid_url]" value="'. serendipity_common_openid::getOpenID($serendipity['authorid']) .'" />';
        echo ' <input type="submit" name="submit" value="' . EDIT . '" placeholder="' . PLUGIN_OPENID_LOGIN_INPUT . '"/>';
        echo '</form>';
        echo '<form action="?" method="post">';
        echo '<input type="hidden" name="serendipity[adminModule]" value="event_display" />';
        echo '<input type="hidden" name="serendipity[adminAction]" value="profiles" />';
        echo '<input type="hidden" name="serendipity[openidflag]" value="3" />';
        echo '<input name="openIDLoginGoogle" type="image" src="' . $imggoogle . '" alt="' . PLUGIN_OPENID_SET_GOOGLE_OID .'" title="'. PLUGIN_OPENID_SET_GOOGLE_OID .'"/> ';
        echo '<input name="openIDLoginYahoo" type="image" src="' . $imgyahoo . '" alt="' . PLUGIN_OPENID_SET_YAHOO_OID .'" title="'. PLUGIN_OPENID_SET_YAHOO_OID .'"/> ';
        echo '<input name="openIDLoginAol" type="image" src="' . $imgaol . '" alt="' . PLUGIN_OPENID_SET_AOL_OID .'" title="'. PLUGIN_OPENID_SET_AOL_OID .'"/> ';
        echo '</form>';
        
        echo '</div><br /><hr />';
    }
    
    function get_consumertest_path() {
        global $serendipity;
        
        return $serendipity['serendipityPath'] . PATH_SMARTY_COMPILE . '/_php_consumer_test';
    }
}

/* vim: set sts=4 ts=4 expandtab : */
