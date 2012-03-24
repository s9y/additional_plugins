<?php # $Id$

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}
include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_browserid extends serendipity_event
{
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',        PLUGIN_BROWSERID_NAME);
        $propbag->add('description', PLUGIN_BROWSERID_DESC);
        $propbag->add('stackable',   false);
        $propbag->add('author',      'Grischa Brockhaus');
        $propbag->add('version',     '0.1');
        $propbag->add('requirements',  array(
            'serendipity' => '1.6',
            'smarty'      => '2.6.7',
            'php'         => '5.1.3'
        ));
        $propbag->add('groups', array('BACKEND_USERMANAGEMENT'));
        $propbag->add('event_hooks', array(
            'backend_login'             => true,
            'backend_login_page'        => true,
            'external_plugin'			=> true,
        ));

        $propbag->add('configuration', array(
            'plugin_desc',
        ));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'plugin_desc':
                $propbag->add('type',        'content');
                $propbag->add('default',     PLUGIN_BROWSERID_DESCRIPTION);
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
                case 'external_plugin':
                    if ($eventData=="serendipity_event_browserid.js") {
                        header('Content-Type: text/javascript');
                        echo file_get_contents(dirname(__FILE__). '/serendipity_event_browserid.js');
                    }
                    else if ($eventData=="browserid_signin.png") {
                        header('Content-Type: image/png');
                        echo file_get_contents(dirname(__FILE__). '/browserid_signin.png');
                    }
                    break;
                    
                case 'backend_login_page':
                    $this->print_loginpage($eventData);
                    break;

                case 'backend_login':
                    if ($eventData) {
                        return true;
                    }
                    return;

                default:
                    return false;
            }
        } else {
            return false;
        }
    }

    function print_loginpage(&$eventData) {
        global $serendipity;
        
        $hidden = array('action'=>'admin');
        $bid_title = "Sign-in with BrowserID";
        $local_js = $serendipity['baseURL'] . 'index.php?/plugin/serendipity_event_browserid.js';
        $local_signin_img = $serendipity['baseURL'] . 'index.php?/plugin/browserid_signin.png';
        
        $eventData['header'] .=
        "\n<!-- browserid start -->\n" .
        '<script src="https://browserid.org/include.js" type="text/javascript"></script>' . "\n" . 
        '<script src="' . $local_js . '" type="text/javascript"></script>' . "\n" . 
        '<div align="center"><p>'.
		'<a href="#" id="browserid" title="' . $bid_title . '"><img src="' . $local_signin_img . '" alt="' . $bid_title . '" title="' . $bid_title . '"></a>'.
    	'</p></div>' .
        "\n<!-- browserid end -->\n";
    }
}

/* vim: set sts=4 ts=4 expandtab : */
