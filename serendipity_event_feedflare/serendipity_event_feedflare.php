<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}
    
// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_feedflare extends serendipity_event
{

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_FEEDFLARE_NAME);
        $propbag->add('description',   PLUGIN_EVENT_FEEDFLARE_BLAHBLAH);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Jim Davies');
        $propbag->add('version',       '1.3');
        $propbag->add('license',       'Creative Commons Attribution-NonCommercial-ShareAlike 2.5 License');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('configuration', array('feedburnerid'));
        $propbag->add('event_hooks', array('entry_display' => true));
        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED'));
    }

	function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'feedburnerid':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_FEEDFLARE_FEEDBURNER_ID);
                $propbag->add('description', PLUGIN_EVENT_FEEDFLARE_FEEDBURNER_ID_DESC);
                $propbag->add('default', '');
                return true;
                break;
        }

        return false;
    }
	
    function generate_content(&$title)
    {
        $title       = PLUGIN_EVENT_FEEDFLARE_NAME;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'entry_display':
                    if (!is_array($eventData)) return false;
                    $elements = count($eventData);
                    for ($i = 0; $i < $elements; $i++) {
                        if (empty($eventData[$i]['body'])) continue;
                        $eventData[$i]['add_footer'] .= '<script src="http://feeds.feedburner.com/~s/' . $this->get_config('feedburnerid', '') . '?i=' . serendipity_archiveURL($eventData[$i]['id'], $eventData[$i]['title'], 'baseURL', true, array('timestamp' => $entry['timestamp'])) . '" type="text/javascript" charset="utf-8"></script>';
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
