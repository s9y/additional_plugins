<?php # 

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_mycalendar extends serendipity_plugin {
    function introspect(&$propbag)
    {
        $propbag->add('name',          PLUGIN_MYCALENDAR_SIDE_NAME);
        $propbag->add('description',   PLUGIN_MYCALENDAR_SIDE_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Markus Gerstel');
        $propbag->add('version',       '0.13.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_FEATURES'));
        $propbag->add('configuration', array('title', 'items', 'datefm', 'datefm2', 'showtime', 'autoprune', 'countdown', 'skipfirst', 'rss'));

        // Register (multiple) dependencies. KEY is the name of the depending plugin. VALUE is a mode of either 'remove' or 'keep'.
        // If the mode 'remove' is set, removing the plugin results in a removal of the depending plugin. 'Keep' meens to
        // not touch the depending plugin.
        $this->dependencies = array('serendipity_event_mycalendar' => 'remove');
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch($name) {
            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        TITLE);
                $propbag->add('description', TITLE);
                $propbag->add('default',     '');
                break;

            case 'items':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_MYCALENDAR_SIDE_ITEMS);
                $propbag->add('description', PLUGIN_MYCALENDAR_SIDE_ITEMS_DESC);
                $propbag->add('default',     5);
                break;

            case 'datefm':
                $propbag->add('type',        'string');
                $propbag->add('name',        GENERAL_PLUGIN_DATEFORMAT . ' (' . PLUGIN_MYCALENDAR_EVENTDATE . ')');
                $propbag->add('description', sprintf(GENERAL_PLUGIN_DATEFORMAT_BLAHBLAH, '%d.%m'));
                $propbag->add('default',     '%d.%m');
                break;

            case 'rss':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_MYCALENDAR_RSS);
                $propbag->add('description', $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/mycalendar.rss');
                $propbag->add('default',     'true');
                break;

            case 'datefm2':
                $propbag->add('type',        'string');
                $propbag->add('name',        GENERAL_PLUGIN_DATEFORMAT . ' (' . PLUGIN_MYCALENDAR_EVENTDATE2 . ')');
                $propbag->add('description', sprintf(GENERAL_PLUGIN_DATEFORMAT_BLAHBLAH, '%d.%m'));
                $propbag->add('default',     '%d.%m');
                break;

            case 'showtime':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_MYCALENDAR_SIDE_SHOWTIME);
                $propbag->add('description', PLUGIN_MYCALENDAR_SIDE_SHOWTIME_DESC);
                $propbag->add('default',     2);
                break;

            case 'autoprune':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_MYCALENDAR_SIDE_PRUNE);
                $propbag->add('description', PLUGIN_MYCALENDAR_SIDE_PRUNE_DESC);
                $propbag->add('default',     false);
                break;

            case 'countdown':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_MYCALENDAR_SIDE_COUNTDOWN);
                $propbag->add('description', PLUGIN_MYCALENDAR_SIDE_COUNTDOWN_DESC);
                $propbag->add('default',     true);
                break;

            case 'skipfirst':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_MYCALENDAR_SIDE_SKIPFIRSTFUTURE);
                $propbag->add('description', '');
                $propbag->add('default',     true);
                break;

            default:
                    return false;
        }
        return true;
    }

    function generate_content(&$title, $returnRaw = false) {
        global $serendipity;

        $title     = $this->get_config('title', $title);
        $autoprune = serendipity_db_bool($this->get_config('autoprune', false));
        $countdown = serendipity_db_bool($this->get_config('countdown', false));
        $showtime  = 1 + (int)$this->get_config('showtime', 2);
        $skipfirst = serendipity_db_bool($this->get_config('skipfirst', true));
        $datefm    = $this->get_config('datefm');
        $datefm2   = $this->get_config('datefm2');

        $ts      = time();
        $timeout = $ts - 60*60*24*$showtime;

        if ($autoprune) {
            $filter = "";
        } else {
            $filter = "WHERE eventdate2 > " . $timeout;
        }

        $items = serendipity_db_query("SELECT * from {$serendipity['dbPrefix']}mycalendar " . $filter . " ORDER BY eventdate LIMIT " . $this->get_config('items', 5));
        if (!is_array($items)) {
            return true;
        }

        $olddays = 0;
        foreach($items AS $item) {
            $cont = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['eventname']) : htmlspecialchars($item['eventname'], ENT_COMPAT, LANG_CHARSET));
            if (!empty($item['eventurl'])) {
                if (!empty($item['eventurltitle'])) {
                    $ltitle = $item['eventurltitle'];
                } else {
                    $ltitle = $item['eventname'];
                }
                $cont = '<a href="' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['eventurl']) : htmlspecialchars($item['eventurl'], ENT_COMPAT, LANG_CHARSET)) . '" title="' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($ltitle) : htmlspecialchars($ltitle, ENT_COMPAT, LANG_CHARSET)) . '">' . $cont . '</a>';
            }

            $daystostart = ceil(($item['eventdate'] - $ts) / 86400);

            if (empty($item['eventdate2'])) {
                $daystoend = $daystostart;
            } else {
                $daystoend = ceil(($item['eventdate2'] - $ts) / 86400);
            }

            if ($daystoend > -$showtime) {
                $_dayout = serendipity_strftime($datefm, $item['eventdate'], false);
                $dayout = $_dayout;
                if (!empty($item['eventdate2']) && $item['eventdate'] != $item['eventdate2'] && trim($datefm2) != '') {
                    $dayout .= '<span class="s9y_mc_date2"> - ' . serendipity_strftime($datefm2, $item['eventdate2'], false) . '</span>';
                }
                $cont = '<span class="s9y_mc_date">' . $dayout . '</span>'
                        . ' - <span class="s9y_mc_c">' . $cont . '</span>';

                if ($daystostart > 0 and ($olddays > 0 || !$skipfirst)) {
                    # An entry is in the future only if is in the future and it
                    # is not the first future entry
                    $cont = '<div class="s9y_mc s9y_mc_future">' . $cont;
                    if ($countdown) {
                        $cont .= '<span class="s9y_mc_day"> (' . $daystostart . ' ' . DAYS . ')</span>';
                    }
                    $cont .= '</div>';
                } elseif ($daystoend >= 0 and $olddays <= 0) {
                    # An entry is current, if it is the first future entry
                    $cont = '<div class="s9y_mc s9y_mc_current">' . $cont . '</div>';
                } else {
                    # Everything else is old
                    $cont = '<div class="s9y_mc s9y_mc_past">' . $cont . '</div>';
                }

                if ($returnRaw) {
                    $returnRawItems[] = array(
                        'date'    => date('r', $item['eventdate']),
                        'content' => $cont,
                        'title'   => $item['eventname'],
                        'url'     => (!empty($item['eventurl']) ? $item['eventurl'] : $serendipity['baseURL'])
                    );
                } else {
                    echo "$cont\n";
                }
            } elseif ($autoprune) {
                serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}mycalendar WHERE eventdate2 < ". $timeout);
                $autoprune = false;
            }
            $olddays = $daystostart;
        }

        if ($returnRaw) {
            return $returnRawItems;
        }

        if (serendipity_db_bool($this->get_config('rss'))) {
            $url = $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/mycalendar.rss';
            echo '<a class="serendipity_xml_icon rsslink" href="' . $url . '" title="RSS"><img src="' . serendipity_getTemplateFile('img/xml.gif') . '" alt="XML" style="border: 0px" /></a>';
        }

        return true;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
