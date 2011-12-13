<?php # $Id: serendipity_event_openid.php,v 1.1 2007/08/17 13:21:46 garvinhicking Exp $

include_once dirname(__FILE__) . '/common.inc.php';


class serendipity_event_openid extends serendipity_event
{
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',        PLUGIN_OPENID_NAME);
        $propbag->add('description', PLUGIN_OPENID_DESC);
        $propbag->add('stackable',   false);
        $propbag->add('author',      'Rob Richards');
        $propbag->add('version',     '0.2');
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
            'frontend_header'           => true
        ));

        $propbag->add('configuration', array(
            'storage_path',
            'server',
            'delegate',
            'xrds_location'
        ));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'storage_path':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_OPENID_STORE_PATH);
                $propbag->add('description', PLUGIN_OPENID_STORE_PATH_DESC);
                $propbag->add('default',     '/tmp/_php_consumer_test');
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

                case 'frontend_header':
                    $server = $this->get_config('server');
                    $openidurl = $this->get_config('delegate');
                    $xrdsloc = $this->get_config('xrds_location');
                    if (! empty($server) && (! empty($openidurl) || ! empty($xrdsloc))) {
                        /* Make sure linefeeds exist otherwise OpenID does not always work correctly */
                        echo "\n";
                        echo '<link rel="openid.server" href="'.$server.'" />	'."\n";
                        if (! empty($openidurl)) {
                            echo '<link rel="openid.delegate" href="'.$openidurl.'" />	'."\n";
                        }
                        if (! empty($xrdsloc)) {
                            echo '<meta http-equiv="X-XRDS-Location" content="'.$xrdsloc.'" />	'."\n";
                        }
                    }

                case 'backend_login_page':
                    $hidden = array('action'=>'admin');
                    $eventData['header'] .= '<div align="center"><p>Logon using your OpenID<br />'.
                         serendipity_common_openid::loginform('serendipity_admin.php', $hidden, NULL).
                         '</p><br /></div>';
                    break;

                case 'backend_login':
                    if ($eventData) {
                        return true;
                    }
                    if ($_SESSION['serendipityAuthedUser'] == true) {
                        $eventData = serendipity_common_openid::reauth_openid();
                        if (! empty($serendipity['POST']['openid_url']) && ! empty($serendipity['POST']['openidflag'])) {
                            /* Check that openid isn't already associated with another login */
                            $tmpRet = serendipity_common_openid::redir_openidserver($serendipity['POST']['openid_url'], $this->get_config('storage_path'), 3);

                            /* If updating an OpenID it is not a real login attempt */
                            if (($tmpRet === false) && (($serendipity['GET']['openidflag']==3) || ($serendipity['POST']['openidflag']==3))) {
                                return;
                            }
                            $eventData = $tmpRet;
                        } else {
                            $eventData = serendipity_common_openid::reauth_openid();
                        }
                    } else if (! empty($serendipity['GET']['openidflag']) && ($serendipity['GET']['openidflag']==1)) {
                        $eventData = serendipity_common_openid::authenticate_openid($_GET, $this->get_config('storage_path'));
                    } else if (! empty($serendipity['POST']['openid_url']) && ! empty($serendipity['POST']['action'])) {
                        $eventData = serendipity_common_openid::redir_openidserver($serendipity['POST']['openid_url'], $this->get_config('storage_path'), 1);
                    }
                    return;

                case 'backend_sidebar_entries_event_display_profiles':
                    if (($_SESSION['serendipityAuthedUser'] == true)) {
                        if (! empty($serendipity['GET']['openidflag']) && ($serendipity['GET']['openidflag']==3)) {
                            if ($checkRet = serendipity_common_openid::authenticate_openid($_GET, $this->get_config('storage_path'), true)) {
                                if (serendipity_common_openid::updateOpenID($checkRet['openID'], $serendipity['authorid'])) {
                                    echo '<strong>' . htmlspecialchars(PLUGIN_OPENID_UPDATE_SUCCESS) . '</strong><br /><br />';
                                } else {
                                    echo '<strong>' . htmlspecialchars(PLUGIN_OPENID_UPDATE_FAIL) . '</strong><br /><br />';
                                }
                            } else {
                                echo '<strong>' . htmlspecialchars(PLUGIN_OPENID_INVALID_RESPONSE) . '</strong><br /><br />';
                            }
                        } elseif (! empty($serendipity['POST']['openidflag']) && ($serendipity['POST']['openidflag']==3)) {
                            echo '<strong>' . htmlspecialchars(PLUGIN_OPENID_INVALID_RESPONSE) . '</strong><br /><br />';
                        }
                    }
                    echo '<form action="?" method="post">';
                    echo '<input type="hidden" name="serendipity[adminModule]" value="event_display" />';
                    echo '<input type="hidden" name="serendipity[adminAction]" value="profiles" />';
                    echo '<input type="hidden" name="serendipity[openidflag]" value="3" />';
                    echo '<div>';
                    echo '<strong>' . htmlspecialchars(PLUGIN_EVENT_OPENID_SELECT) . '</strong><br /><br />';
                    echo 'OpenID URL: <input type="text" size="50" name="serendipity[openid_url]" value="'. serendipity_common_openid::getOpenID($serendipity['authorid']) .'" />';
                    echo ' <input type="submit" name="submit" value="' . EDIT . '" />';
                    echo '</div><br /><hr /></form>';
                    return true;
                default:
                    return false;
            }
        } else {
            return false;
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
