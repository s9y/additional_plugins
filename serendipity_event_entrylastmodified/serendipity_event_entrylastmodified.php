<?php # 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_entrylastmodified extends serendipity_event {
    var $title = PLUGIN_EVENT_ENTRYLASTMODIFIED_NAME;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_ENTRYLASTMODIFIED_NAME);
        $propbag->add('description',   PLUGIN_EVENT_ENTRYLASTMODIFIED_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('version',       '1.9');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',   array('entry_display' => true));
        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED'));
        $propbag->add('configuration', array('notmodified', 'position'));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;
        switch($name) {
            case 'position':
                $propbag->add('type','radio');
                $propbag->add('name',PLUGIN_EVENT_ENTRYLASTMODIFIED_POSITION);
                $propbag->add('description',PLUGIN_EVENT_ENTRYLASTMODIFIED_POSITION_DESC);
                $propbag->add('radio',array(
                    'value' => array('left','center','right'),
                    'desc' => array(PLUGIN_EVENT_ENTRYLASTMODIFIED_LEFT,PLUGIN_EVENT_ENTRYLASTMODIFIED_CENTER,PLUGIN_EVENT_ENTRYLASTMODIFIED_RIGHT)
                ));
                $propbag->add('default','right');

// languages for which options per row are 2, add your language if appropriate
                $per_row_2 = array(1 => 'bg');
// languages for which options per row are 3, add your language if appropriate
                $per_row_3 = array(1 => 'en');

                $lang = $serendipity['lang'];
                if (in_array($lang,$per_row_2) == true)
                    $per_row = 2;
                else if (in_array($lang,$per_row_3) == true)
                    $per_row = 3;
                else
                    $per_row = 1;    // by default one option per row - for languages with very long words
                unset($per_row_2, $per_row_3);

                $propbag->add('radio_per_row', $per_row);
                break;
            case 'notmodified':
                $propbag->add('type','boolean');
                $propbag->add('name',PLUGIN_EVENT_ENTRYLASTMODIFIED_SHOWNOTMODIFIED);
                $propbag->add('description',PLUGIN_EVENT_ENTRYLASTMODIFIED_SHOWNOTMODIFIED_DESC);
                $propbag->add('default','true');
                break;
            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        $notmodified = $this->get_config('notmodified');
        $position = $this->get_config('position');

// %1 = position, %2 = the message itself, %3 = last_modified timestamp
        $format_string_mod = '<div class="entry_last_modified" style="text-align: %s">%s %s</div>';
// %1 = position, %2 = the message itself
        $format_string_nomod = '<div class="entry_last_modified" style="text-align: %s">%s</div>';

        if (isset($hooks[$event])) {
            switch($event) {
                case 'entry_display':
                    if (!isset($eventData[0])) continue;
                    $extended_key = &$this->getFieldReference('extended', $eventData);
                    if ($addData['extended'] || $addData['preview']) {
                        $eventData[0]['exflag'] = 1;
                        if ($eventData[0]['timestamp'] != $eventData[0]['last_modified']) {
                            $lm = sprintf($format_string_mod, $position, PLUGIN_EVENT_ENTRYLASTMODIFIED_HTML, serendipity_formatTime(DATE_FORMAT_SHORT, $eventData[0]['last_modified']));
                            $eventData[0]['add_footer'] .= $lm;
                            $eventData[0]['string_last_modified'] .= $lm;
                        } elseif ($notmodified == true && PLUGIN_EVENT_ENTRYLASTMODIFIED_NOTMODIFIED != '') {
                            $lm = sprintf($format_string_nomod, $position, PLUGIN_EVENT_ENTRYLASTMODIFIED_NOTMODIFIED);
                            $eventData[0]['add_footer'] .= $lm;
                            $eventData[0]['string_last_modified'] .= $lm;

                        }
                    } elseif (is_array($eventData)) {
                        $elements = count($eventData);
                        for ($i = 0; $i < $elements; $i++) {
                            if (!isset($eventData[$i]['add_footer'])) {
                                $eventData[$i]['add_footer'] = '';
                            }
                            if ($eventData[$i]['timestamp'] != $eventData[$i]['last_modified']) {
                                $lm = sprintf($format_string_mod, $position, PLUGIN_EVENT_ENTRYLASTMODIFIED_HTML, serendipity_formatTime(DATE_FORMAT_SHORT, $eventData[$i]['last_modified']));
                                $eventData[$i]['add_footer'] .= $lm;
                                $eventData[$i]['string_last_modified'] .= $lm;
                            } elseif ($notmodified == true && PLUGIN_EVENT_ENTRYLASTMODIFIED_NOTMODIFIED != '') {
                                $lm = sprintf($format_string_nomod, $position, PLUGIN_EVENT_ENTRYLASTMODIFIED_NOTMODIFIED);
                                $eventData[$i]['add_footer'] .= $lm;
                                $eventData[$i]['string_last_modified'] .= $lm;
                            }
                        }
                    }
                    return true;
                    break;
            }
        }

        return false;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>