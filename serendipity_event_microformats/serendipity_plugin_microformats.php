<?php
/*
    Microformats Sidebar Display
*/

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

class serendipity_plugin_microformats extends serendipity_plugin
{
    var $title = PLUGIN_MICROFORMATS_TITLE_N;

    var $timezones  = array('-1200' => '-12 (IDLW)',
                            '-1100' => '-11 (NT)',
                            '-1000' => '-10 (HST)',
                            '-0900' => '-9 (AKST)',
                            '-0800' => '-8 (PST/AKDT)',
                            '-0700' => '-7 (MST/PDT)',
                            '-0600' => '-6 (CST/MDT)',
                            '-0500' => '-5 (EST/CDT)',
                            '-0400' => '-4 (AST/EDT)',
                            '-0345' => '-3:45',
                            '-0330' => '-3:30',
                            '-0300' => '-3 (ADT)',
                            '-0200' => '-2 (AT)',
                            '-0100' => '-1 (WAT)',
                            'Z' => '+0 (GMT/UTC)',
                            '+0100' => '+1 (CET/BST/IST/WEST)',
                            '+0200' => '+2 (EET/CEST)',
                            '+0300' => '+3 (MSK/EEST)',
                            '+0330' => '+3:30 (Iran)',
                            '+0400' => '+4 (ZP4/MSD)',
                            '+0430' => '+4:30 (Afghanistan)',
                            '+0500' => '+5 (ZP5)',
                            '+0530' => '+5:30 (India)',
                            '+0600' => '+6 (ZP6)',
                            '+0630' => '+6:30 (Myanmar)',
                            '+0700' => '+7 (WAST)',
                            '+0800' => '+8 (WST)',
                            '+0900' => '+9 (JST)',
                            '+0930' => '+9:30 (Central Australia)',
                            '+1000' => '+10 (AEST)',
                            '+1100' => '+11 (AEST [summer])',
                            '+1200' => '+12 (NZST/IDLE)');

    function introspect(&$propbag)
    {
        global $serendipity;

        $this->title = $this->get_config('display_title', $this->title);

        $propbag->add('name',          $this->title);
        $propbag->add('description',   PLUGIN_MICROFORMATS_TITLE_D);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Matthias Gutjahr');
        $propbag->add('version',       '0.24');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_FEATURES'));
        $propbag->add('configuration', array('display_title', 'sort', 'purge', 'include_entries', 'icondisplay', 'timezone', 'eventlist_XML', 'explain'));
        $this->dependencies = array('serendipity_event_microformats' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'display_title':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_MICROFORMATS_DISPLAY_N);
                $propbag->add('description', PLUGIN_MICROFORMATS_DISPLAY_D);
                $propbag->add('default', PLUGIN_MICROFORMATS_TITLE_N);
                break;
            case 'sort':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_MICROFORMATS_SORT_N);
                $propbag->add('description', PLUGIN_MICROFORMATS_SORT_D);
                $propbag->add('default', true);
                break;
            case 'purge':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_MICROFORMATS_PURGE_N);
                $propbag->add('description', PLUGIN_MICROFORMATS_PURGE_D);
                $propbag->add('default', '1');
                break;
            case 'include_entries':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_MICROFORMATS_ENTRIES_N);
                $propbag->add('description', PLUGIN_MICROFORMATS_ENTRIES_D);
                $propbag->add('default', true);
                break;
            case 'icondisplay':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_MICROFORMATS_ICONDISPLAY_N);
                $propbag->add('description', PLUGIN_MICROFORMATS_ICONDISPLAY_D);
                $propbag->add('default', true);
                break;
            case 'timezone':
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_MICROFORMATS_TIMEZONE_N);
                $propbag->add('description', PLUGIN_MICROFORMATS_TIMEZONE_D);
                $propbag->add('select_values', $this->timezones);
                $propbag->add('default', 'Z');
                break;
            case 'eventlist_XML':
                $propbag->add('type', 'text');
                $propbag->add('name', PLUGIN_MICROFORMATS_EVENTLIST_XML_N);
                $propbag->add('description', PLUGIN_MICROFORMATS_EVENTLIST_XML_D);
                $propbag->add('default', '<events><event summary="Football World Cup 2010" location="South Africa" url="http://www.fifa.com/de/worldcup/index/0,3360,WF2010,00.html?comp=WF&amp;year=2010" dtstart="20100611T1930" dtend="20100711T2000" description="Africa\'s Calling" /></events>');
                break;
            case 'explain':
                $propbag->add('type', 'content');
                $propbag->add('default', PLUGIN_MICROFORMATS_EVENTLIST_XML_EXPLAIN);
                break;
            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        global $serendipity;

        $plugin_dir = basename(dirname(__FILE__));
        if (($title = $this->get_config('display_title')) == '') {
            $title = $this->title;
        }

        if ($this->get_config('eventlist_XML') != '') {
            $xml = xml_parser_create('ISO-8859-1');
            $linkxml = $this->get_config('eventlist_XML');
            xml_parse_into_struct($xml, $linkxml, $struct, $index);
            xml_parser_free($xml);

            $i = 0;
            foreach ($struct as $k => $v) {
                if (is_array($v['attributes'])
                && isset($v['attributes']['SUMMARY'])
                && isset($v['attributes']['DTSTART'])) {
                    $event[$i++] = $v['attributes'];
                }
            }
            $mapping = array(   'mf_hCalendar_summary'  => 'SUMMARY',
                                'mf_hCalendar_location' => 'LOCATION',
                                'mf_hCalendar_url'      => 'URL',
                                'mf_hCalendar_startdate'=> 'DTSTART',
                                'mf_hCalendar_enddate'  => 'DTEND',
                                'mf_hCalendar_desc'     => 'DESC');
            if ($this->get_config('include_entries') === true) {
                $query = 'SELECT * FROM ' . $serendipity['dbPrefix'] . 'entryproperties WHERE property LIKE \'mf_hCalendar_%\' AND entryid IN (SELECT entryid FROM ' . $serendipity['dbPrefix'] . 'entryproperties WHERE property = \'mf_hCalendar_startdate\' AND value > (' . time() . ($this->get_config('purge') !== false ? ' - ' . 86400 * intval($this->get_config('purge')) : ' ') . '))';
                $result = serendipity_db_query($query, false, 'assoc');
                $counter = count($event)-1;
                if (is_array($result)) {
                    foreach ($result as $k => $v) {
                        if ($v['property'] == 'mf_hCalendar_startdate' || $v['property'] == 'mf_hCalendar_enddate') {
                            $ev[$v['entryid']][$mapping[$v['property']]] = date('Ymd\THm', $v['value']);
                        } else {
                            $ev[$v['entryid']][$mapping[$v['property']]] = utf8_decode($v['value']);
                        }
                    }
                    foreach ($ev as $k => $v) {
                        $event[] = $ev[$k];
                    }
                }
            }

            if ($this->get_config('purge') > 0 && is_array($event)) {
                foreach ($event as $k => $v) {
                    if (strtotime($v['DTSTART'] . $this->get_config('timezone')) < (time() - 86400 * intval($this->get_config('purge')))) {
                        unset($event[$k]);
                    }
                }
            }
            if ($this->get_config('sort') !== false && is_array($event) && count($event) > 1) {
                foreach ($event as $k => $v) {
                    $dtstart_sort[$k]  = $v['DTSTART'];
                }
                array_multisort($dtstart_sort, SORT_ASC, $event);
            }
            if (is_array($event)) {
                foreach ($event as $v) {
                    // das muss noch ausgearbeitet werden:
                    //$dtstart = explode('+', $v['DTSTART']);
                    $dtstart = str_replace('T', ' ', $v['DTSTART']);
                    $v['DTSTART'] .= $this->get_config('timezone');
                    echo '<div class="vevent" style="margin-bottom:1em;">';
                    echo '<p class="summary" style="font-weight:bold;margin:0;padding:0;color:#DDD">' . htmlentities($v['SUMMARY'], ENT_COMPAT, LANG_CHARSET) . '</p>';
                    echo '<p style="margin:0;padding:0 0 0 18px;background:url(' . $serendipity['baseURL'] . 'plugins/serendipity_event_microformats/img/house_12.png) 0 0 no-repeat;"><a href="' . $v['URL'] . '" class="url location" style="color:#70191B;">' . htmlentities($v['LOCATION'], ENT_COMPAT, LANG_CHARSET) . '</a></p>';
                    echo '<p style="margin:0;padding:0 0 0 18px;background:url(' . $serendipity['baseURL'] . 'plugins/serendipity_event_microformats/img/clock_12.png) 0 0 no-repeat;"><abbr class="dtstart" title="' . $v['DTSTART'] . '" style="color:#70191B;">' . date('d.m.Y, H:i', strtotime($dtstart)) . ' Uhr</abbr><!-- &mdash; <abbr class="dtend" title="' . $v['DTEND'] . '">' . date('d.m.Y H:i', strtotime($v['DTEND'])) . ' Uhr</abbr>--></p>';
                    /* LATER if (isset($v['DESC'])) {
                        echo '<p class="description" style="margin:0 0 0 3px;padding:0;">' . $v['DESC'] . '</p>';
                    }*/
                    echo '</div>';
                }
            }
        }

        if ($this->get_config('icondisplay', true)) {
            echo '<div style="text-align:right;"><a href="http://microformats.org/wiki/hcalendar" title="hCalendar microformat enabled"><img src="' . $serendipity['baseURL'] . 'plugins/' . $plugin_dir . '/img/icon-hcalendar.png" width=29" height="18" alt="hCalendar" style="border:none;" /></a></div>';
        }
    }
}