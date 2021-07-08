<?php # 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_loginform extends serendipity_event
{
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',        PLUGIN_EVENT_LOGINFORM_NAME);
        $propbag->add('description', PLUGIN_EVENT_LOGINFORM_DESC);
        $propbag->add('stackable',   false);
        $propbag->add('author',      'Garvin Hicking');
        $propbag->add('version',     '1.04');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks', array('frontend_configure' => true));
        $propbag->add('groups', array('FRONTEND_FEATURES'));

        // Register (multiple) dependencies. KEY is the name of the depending plugin. VALUE is a mode of either 'remove' or 'keep'.
        // If the mode 'remove' is set, removing the plugin results in a removal of the depending plugin. 'Keep' meens to
        // not touch the depending plugin.
        $this->dependencies = array('serendipity_plugin_loginform' => 'remove');

        $propbag->add('configuration', array('logout_url'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {            
	    case 'logout_url':
            $propbag->add('type',        'string');
            $propbag->add('name',        LOGOUTURL_NAME);
            $propbag->add('description', LOGOUTURL_DESC);
            $propbag->add('default',     '');
            break;

            default:
                    return false;
        }
        return true;
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENT_LOGINFORM_NAME;	
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

 	$logout_url = $this->get_config('logout_url');

        if (isset($hooks[$event])) {
            switch($event) {
              case 'frontend_configure':

                if (isset($serendipity['POST']['action']) && isset($serendipity['POST']['user']) && isset($serendipity['POST']['pass'])) {
                    serendipity_login();
                } elseif (isset($serendipity['POST']['action']) && isset($serendipity['POST']['logout'])) {
                    serendipity_logout();
                    header('Status: 302 Found');
                    if ($logout_url != "")  {
                        header("Location: $logout_url");
                    } else {
                        header("Location: {$serendipity['baseURL']}{$serendipity['indexFile']}");
                    }
                    exit;
                }

                return true;
                break;

              default:
                return false;
            }

        } else {
            return false;
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>