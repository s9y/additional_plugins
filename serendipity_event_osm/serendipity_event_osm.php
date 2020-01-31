<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_osm extends serendipity_event
{
    var $title = HEAD_OSM_TITLE;

    function introspect(&$propbag)
    {
        $propbag->add('name',          HEAD_OSM_TITLE);
        $propbag->add('description',   HEAD_OSM_DESCRIPTION);
        $propbag->add('copyright', 'GPL');
        $propbag->add('configuration', array('height', 'latitude', 'longitude', 'zoom'));
        $propbag->add('event_hooks', array('frontend_header' => true, 'entries_header' => true));
        $propbag->add('author', 'Martin Sewelies');
        $propbag->add('version', '0.1');
        $propbag->add('requirements', array(
            'serendipity' => '2.3'
        ));
        $propbag->add('stackable', true);
        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED'));
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;
        if ($event == 'frontend_header') {
            echo '    <link rel="stylesheet" href="'.$this->getFile('ol.css', 'serendipityHTTPPath').'" type="text/css">'.PHP_EOL;
            echo '    <link rel="stylesheet" href="'.$this->getFile('osm.css', 'serendipityHTTPPath').'" type="text/css">'.PHP_EOL;
            echo '    <script src="'.$this->getFile('ol.js', 'serendipityHTTPPath').'"></script>'.PHP_EOL;
            echo '    <script src="'.$this->getFile('osm.js', 'serendipityHTTPPath').'"></script>'.PHP_EOL;
        } else if ($event == 'entries_header') {
            echo '    <div id="map" style="height: '.$this->get_config('height', '463px').'" data-latitude="'.$this->get_config('latitude', 51.48165).'" data-longitude="'.$this->get_config('longitude', 7.21648).'" data-zoom="'.$this->get_config('zoom', 15).'"></div>'.PHP_EOL;
            echo '    <div id="popup" class="ol-popup"></div>'.PHP_EOL;
        }
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'height':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_OSM_HEIGHT);
                $propbag->add('description', PLUGIN_EVENT_OSM_HEIGHT_DESC);
                $propbag->add('default',     '463px');
                break;
            case 'latitude':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_OSM_LAT);
                $propbag->add('description', PLUGIN_EVENT_OSM_LAT_DESC);
                $propbag->add('default',     '51.48165');
                break;
            case 'longitude':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_OSM_LONG);
                $propbag->add('description', PLUGIN_EVENT_OSM_LONG_DESC);
                $propbag->add('default',     '7.21648');
                break;
            case 'zoom':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_OSM_ZOOM);
                $propbag->add('description', PLUGIN_EVENT_OSM_ZOOM_DESC);
                $propbag->add('default',     '15');
                break;
            default:
                return false;
        }
        return true;
    }
}

?>
