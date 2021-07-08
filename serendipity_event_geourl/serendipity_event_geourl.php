<?php # 

// GeoURL Plugin for Serendipity
//
// 2005/03 by Thomas Nesges
//            thomas@tnt-computer.de
//            http://blog.thomasnesges.de
//
// You can find your Latitude/Longitude coordinates via maporama
// (http://www.maporama.com/) or one of the other ressources mentioned
// on http://geourl.org/resources.html


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_geourl extends serendipity_event {

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_GEOURL_NAME);
        $propbag->add('event_hooks',   array('frontend_header' => true));
        $propbag->add('configuration', array('lat', 'long'));
        $propbag->add('description',   PLUGIN_EVENT_GEOURL_DESC);
        $propbag->add('version',       '1.4.2');
        $propbag->add('groups', array('BACKEND_METAINFORMATION'));
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'lat':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_GEOURL_LAT);
                $propbag->add('description', PLUGIN_EVENT_GEOURL_LAT_DESC);
                $propbag->add('default',     '');
                break;
            case 'long':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_GEOURL_LONG);
                $propbag->add('description', PLUGIN_EVENT_GEOURL_LONG_DESC);
                $propbag->add('default',     '');
                break;
        }

        return true;
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENT_GEOURL_NAME;
    }


    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;
        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_header':
                    $lat  = $this->get_config('lat');
                    $long = $this->get_config('long');
                    print "\n" . '    <meta name="ICBM" content="' . $lat . ', ' . $long . '" />' . "\n";
                    print '    <meta name="geo.position" content="' . $lat . ';' . $long . '" />' . "\n";
                    print '    <meta name="DC.title" content="' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($serendipity['blogTitle']) : htmlspecialchars($serendipity['blogTitle'], ENT_COMPAT, LANG_CHARSET)) . '" />' . "\n";
                    return true;
                    break;

              default:
                return false;
            }
        } else {
            return false;
        }
    }

    function cleanup() {
        global $serendipity;
        echo '<div class="serendipity_msg_notice">';
        if($this->get_config('lat') && $this->get_config('long')) {
            // Try to get the URL
            $geourl = "http://geourl.org/ping/?p=" . $serendipity['baseURL'];

            if (function_exists('serendipity_request_url')) {
                $data = serendipity_request_url($geourl);
                if (empty($data)) {
                    printf(REMOTE_FILE_NOT_FOUND, $geourl);
                } else {
                    echo PLUGIN_EVENT_GEOURL_PINGED;
                }
            } else {
                include_once S9Y_PEAR_PATH . 'HTTP/Request.php';
                $req = new HTTP_Request($geourl);
                if (PEAR::isError($req->sendRequest($geourl))) {
                    printf(REMOTE_FILE_NOT_FOUND, $geourl);
                } else {
                    echo PLUGIN_EVENT_GEOURL_PINGED;
                }
            }
        } else {
            echo PLUGIN_EVENT_GEOURL_NOLATLONG;
        }
        echo '</div>';
    }

}
