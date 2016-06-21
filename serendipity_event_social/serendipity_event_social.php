<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_social extends serendipity_event {
    var $title = PLUGIN_EVENT_SOCIAL_NAME;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_SOCIAL_NAME);
        $propbag->add('description',   PLUGIN_EVENT_SOCIAL_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'onli, Matthias Mees');
        $propbag->add('version',       '0.3');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0'
        ));
        $propbag->add('event_hooks',   array('frontend_display:html:per_entry' => true,
                                       'css' => true,
                                       'frontend_footer' => true));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));

        $propbag->add('configuration', array('services', 'theme', 'overview'));
    }

    function generate_content(&$title) {
        $title = $this->title;
    }


    function introspect_config_item($name, &$propbag) {
        global $serendipity;
        switch($name) {
            case 'services':
                $propbag->add('type',           'multiselect');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_SERVICES);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_SERVICES_DESC);
                $propbag->add('default',        'twitter^facebook^googleplus');
                $propbag->add('select_values',  array('twitter' => 'twitter', 'facebook' => 'facebook', 'googleplus' => 'googleplus', 'linkedin' => 'linkedin', 'pinterest' => 'pinterest', 'xing' => 'xing', 'whatsapp' => 'whatsapp', 'mail' => 'mail', 'info' => 'info', 'addthis' => 'addthis', 'tumblr' => 'tumblr', 'flattr' => 'flattr', 'diaspora' => 'diaspora', 'reddit' => 'reddit', 'stumbleupon' => 'stumbleupon', 'threema' => 'threema'));
                break;
            case 'theme':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_THEME);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_THEME_DESC);
                $propbag->add('select_values',  array('standard' => PLUGIN_EVENT_SOCIAL_THEME_STD, 'white' => PLUGIN_EVENT_SOCIAL_THEME_WHITE, 'grey' => PLUGIN_EVENT_SOCIAL_THEME_GREY));
                $propbag->add('default',        'standard');
                break;
            case 'overview':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_OVERVIEW);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_OVERVIEW_DESC);
                $propbag->add('default',        true);
        }
        return true;
    }


    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_display:html:per_entry':
                    if ($serendipity['view'] != 'entry' && ! serendipity_db_bool($this->get_config('overview', true))) {
                        // We are in overview mode and the user opted to not show the button
                        return true;
                    }
                    $services = $this->get_config('services');
                    $services = "&quot;" . str_replace("^", "&quot;,&quot;", $services) . "&quot";
                    $theme = $this->get_config('theme');
                    $eventData['display_dat'] = '<div class="shariff" data-url="' . $eventData['rdf_ident'] .'" data-services="[' . $services . ']" data-theme="' . $theme . '" data-mail-url="mailto:foo@example.org"></div>';
                    break;
                case 'css':
                    $eventData .= file_get_contents(dirname(__FILE__) . '/shariff.complete.css');
                    break;
                case 'frontend_footer':
                    // this script should go into the JS hook, but it has to be at the bottom to work, and the js hook places it at the top
                    echo '<script src="' . $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_social/shariff.min.js' . '"></script>';
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
