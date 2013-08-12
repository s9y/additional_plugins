<?php # 

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_mycalendar extends serendipity_event {

    var $debug;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_MYCALENDAR_TITLE);
        $propbag->add('description',   PLUGIN_MYCALENDAR_DESC);
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('version',       '0.16');
        $propbag->add('author',        'Garvin Hicking, Markus Gerstel, Grischa Brockhaus');
        $propbag->add('stackable',     false);
        $propbag->add('event_hooks',   array(
                                            'backend_sidebar_entries' => true,
                                            'backend_sidebar_entries_event_display_mycalendar' => true,
                                            'frontend_calendar' => true,
                                            'external_plugin' => true
                                        )
        );
        $this->dependencies = array('serendipity_plugin_mycalendar' => 'remove');
        $propbag->add('groups', array('FRONTEND_FEATURES'));
    }

    function setupDB() {
        global $serendipity;

        if (serendipity_db_bool($this->get_config('db_built4', false))) {
            return true;
        }

        if (serendipity_db_bool($this->get_config('db_built3', false))) {
            $sql = "UPDATE {$serendipity['dbPrefix']}mycalendar SET eventdate2 = eventdate WHERE (eventdate2 = 0) OR eventdate2 IS NULL;";
            serendipity_db_schema_import($sql);
            $this->set_config('db_built4', 'true');
            return true;
        }

        if (serendipity_db_bool($this->get_config('db_built2', false))) {
            $sql = "ALTER TABLE {$serendipity['dbPrefix']}mycalendar ADD eventdate2 int(10) {UNSIGNED} default null;";
            serendipity_db_schema_import($sql);
            $this->set_config('db_built3', 'true');
            return true;
        }

        if (serendipity_db_bool($this->get_config('db_built', false))) {
            $sql = "ALTER TABLE {$serendipity['dbPrefix']}mycalendar ADD eventurltitle varchar(255) default null;";
            serendipity_db_schema_import($sql);
            $this->set_config('db_built2', 'true');
            return true;
        }

        $sql = "CREATE TABLE {$serendipity['dbPrefix']}mycalendar (
                      eventid {AUTOINCREMENT} {PRIMARY},
                      eventname     varchar(255) NOT NULL default '',
                      eventurl      varchar(255) NOT NULL default '',
                      eventurltitle varchar(255) NOT NULL default '',
                      eventdate     int(10) {UNSIGNED} default null,
                      eventdate2    int(10) {UNSIGNED} default null,
                      eventcategory varchar(255) NOT NULL default '',
                      eventtype     varchar(255) NOT NULL default ''
                    );";

        serendipity_db_schema_import($sql);
        $this->set_config('db_built4', 'true');
    }

    function &getevents() {
        global $serendipity;

        $this->setupDB();

        $sql = "SELECT *
                  FROM {$serendipity['dbPrefix']}mycalendar
              ORDER BY eventdate";

        $items = serendipity_db_query($sql);
        if (!is_array($items)) {
            $empty = array();
            return $empty;
        } else {
            return $items;
        }
    }

    function get_month_events(&$eventData, $addData) {
        global $serendipity;

        if (!isset($addData['TS']) || !isset($addData['EndTS'])) return;

        $this->setupDB();

        $sql = "SELECT *
                  FROM {$serendipity['dbPrefix']}mycalendar
                 WHERE (eventdate >= '" . serendipity_db_escape_string($addData['TS']) . "')
                   AND (eventdate < '" . serendipity_db_escape_string($addData['EndTS']) . "')
              ORDER BY eventdate";

        $items = serendipity_db_query($sql);

        if (is_array($items)) {
            foreach($items as $event) {
                $day = date('j', $event['eventdate']);
                $day2 = date('j', $event['eventdate2']);
                
                for ($theday=$day; $theday<=$day2; $theday++) {
	                if (!isset($eventData[$theday])) {
	                    $eventData[$theday] = array(
	                        'Class'  => 's9y_mc_event',
	                        'Title'  => $event['eventname'],
	                        'Extended' => array(
	                            'Link'   => $event['eventurl'],
	                            'Active' => ($event['eventurl'] != ''))
	                    );
	                } else {
	                    $eventData[$theday]['Title'] .= "; " . $event['eventname'];
	                }
                }
            }
        }
    }

    function createevents() {
        global $serendipity;

        $this->setupDB();

        $events = $this->getevents();

        foreach($serendipity['POST']['event'] AS $idx => $array) {
            $array['eventdate']  = mktime(0, 0, 0, $array['month'], $array['day'], $array['year']);
            $array['eventdate2'] = mktime(0, 0, 0, $array['month2'], $array['day2'], $array['year2']);

            if (empty($idx)) {
                if (empty($array['eventurl']) && empty($array['eventname'])) {
                    continue;
                } elseif (empty($array['eventname'])) {
                    echo '<div class="serendipityAdminMsgError"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png') . '" alt="" />' . PLUGIN_MYCALENDAR_EVENT_MISSINGDATA . '</div>';
                } else {
                    $this->insertevent($array);
                }
            } elseif (is_numeric($idx)) {
                if (empty($array['eventurl']) && empty($array['eventname'])) {
                    $this->deleteevent($idx, $array);
                } else {
                    $this->updateevent($idx, $array);
                }
            }
        }
    }

    function updateevent($idx, &$array) {
        global $serendipity;

        if (!serendipity_checkFormToken()) {
            return false;
        }

        $q = "UPDATE {$serendipity['dbPrefix']}mycalendar
                 SET eventname     = '" . serendipity_db_escape_string($array['eventname']) . "',
                     eventurl      = '" . serendipity_db_escape_string($array['eventurl']) . "',
                     eventurltitle = '" . serendipity_db_escape_string($array['eventurltitle']) . "',
                     eventdate     = '" . serendipity_db_escape_string($array['eventdate']) . "',
                     eventdate2    = '" . serendipity_db_escape_string($array['eventdate2']) . "'
               WHERE eventid       = " . (int)$idx;

        return serendipity_db_query($q);
    }

    function deleteevent($idx, &$array) {
        global $serendipity;

        if (!serendipity_checkFormToken()) {
            return false;
        }


        $q = "DELETE FROM {$serendipity['dbPrefix']}mycalendar
                    WHERE eventid = " . (int)$idx;

        return serendipity_db_query($q);
    }

    function insertevent(&$array) {
        global $serendipity;

        if (!serendipity_checkFormToken()) {
            return false;
        }


        return serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}mycalendar
                                                 (eventname, eventurl, eventurltitle, eventdate, eventdate2)
                                          VALUES ('" . serendipity_db_escape_string($array['eventname']) . "','" . serendipity_db_escape_string($array['eventurl']) . "','" . serendipity_db_escape_string($array['eventurltitle']) . "','" . serendipity_db_escape_string($array['eventdate']) . "','" . serendipity_db_escape_string($array['eventdate2']) . "')");

    }

    function getDropdown($name, $id, $values, $selected, $useCounter = false, $onChange = '') {
        $html = '<select name="serendipity[event][' . $id . '][' . $name . ']"';
        if ($onChange != '') {
            $html .= ' onchange="'. $onChange .'"';
        };
        $html .= '>';
        $count = 0;
        $found = false;
        foreach($values AS $value) {
            $count++;
            $i = $useCounter ? $count : $value;
            if ($i == $selected) {
                $found = true;
            }
            $html .= '<option value="' . $i . '" ' . ($i == $selected ? ' selected="selected"' : '') . '>' . htmlspecialchars($value) . '</option>' . "\n";
        }

        if (!$found) {
            $html .= '<option value=""></option>' . "\n";
            $html .= '<option value="' . $selected . '" selected="selected">' . htmlspecialchars($selected) . '</option>' . "\n";
        }

        $html .= '</select>';
        return $html;
    }

    function showevents() {
        global $serendipity;

        if (!empty($serendipity['POST']['mycalendarAction']) || !empty($serendipity['POST']['event'])) {
            $this->createevents();
        }

        $events = $this->getevents();
        $events[] = array(
            'eventid'       => 0,
            'eventname'     => '',
            'eventurl'      => '',
            'eventurltitle' => '',
            'eventdate'     => time(),
            'eventdate2'    => time()
        );

        echo '<h2>' . PLUGIN_MYCALENDAR_TITLE . '</h2>';
        echo PLUGIN_MYCALENDAR_DESC . '<br /><br />';
        echo PLUGIN_MYCALENDAR_EVENTLIST . '<br /><br />';

        echo '
            <script type="text/javascript">
            function removeEvent(id) {
                document.getElementById(\'eventname_\' + id).value = \'\';
                document.getElementById(\'eventurl_\' + id).value = \'\';
                document.getElementById(\'eventaction\').value = \'GO\';
                document.getElementById(\'eventform\').submit();
            }
            isOneDayEvent = new Array();
            function changeDate(id) {
                if (isOneDayEvent[id]) {
                    document.getElementsByName(\'serendipity[event][\' + id + \'][day2]\')[0].selectedIndex =
                        document.getElementsByName(\'serendipity[event][\' + id + \'][day]\')[0].selectedIndex;
                    document.getElementsByName(\'serendipity[event][\' + id + \'][month2]\')[0].selectedIndex =
                        document.getElementsByName(\'serendipity[event][\' + id + \'][month]\')[0].selectedIndex;
                    document.getElementsByName(\'serendipity[event][\' + id + \'][year2]\')[0].selectedIndex =
                        document.getElementsByName(\'serendipity[event][\' + id + \'][year]\')[0].selectedIndex;
                }
            }
            function changeDate2(id) {
                isOneDayEvent[id] = false;
            }
            </script>

            <form id="eventform" action="?" method="post">';
        echo serendipity_setFormToken();

        echo '<div>
                <input type="hidden" name="serendipity[adminModule]" value="event_display" />
                <input type="hidden" name="serendipity[adminAction]" value="mycalendar" />
            </div>
            <table align="center" width="100%" cellpadding="10" cellspacing="0">
                <tr>
                    <th>#</th>
                    <th>' . PLUGIN_MYCALENDAR_EVENTNAME . '</th>
                    <th>' . PLUGIN_MYCALENDAR_EVENTURI . '</th>
                    <th>' . PLUGIN_MYCALENDAR_EVENTDATE . '</th>
                    <th>' . PLUGIN_MYCALENDAR_EVENTDATE2 . '</th>
                </tr>';

        foreach($events AS $idx => $event) {
            $even  = ($idx % 2 ? 'even' : 'uneven');
            $year  = date('Y', $event['eventdate']);
            $month = date('m', $event['eventdate']);
            $day   = date('d', $event['eventdate']);

            $year2  = date('Y', $event['eventdate2']);
            $month2 = date('m', $event['eventdate2']);
            $day2   = date('d', $event['eventdate2']);

            echo "<tr style='padding: 10px;' class='serendipity_admin_list_item serendipity_admin_list_item_$even'>\n";
            echo "  <td><em>$idx</em></td>\n";
            echo "  <td><input class='input_textbox' id='eventname_{$event['eventid']}' type='text' name=\"serendipity[event][{$event['eventid']}][eventname]\" value=\"" . htmlspecialchars($event['eventname']) . "\" /></td>\n";
            echo "  <td><input class='input_textbox' id='eventurl_{$event['eventid']}' style='width: 100%' type='text' name=\"serendipity[event][{$event['eventid']}][eventurl]\" value=\"" . htmlspecialchars($event['eventurl']) . "\" /></td>\n";
            echo "  <td>";
            echo $this->getDropdown('day', $event['eventid'], range(1, 31), $day, false, 'changeDate('. $event['eventid'] .')') . ".";
            echo $this->getDropdown('month', $event['eventid'], range(1, 12), $month, false, 'changeDate('. $event['eventid'] .')') . ".";
            echo $this->getDropdown('year', $event['eventid'], range(date('Y'), date('Y')+2), $year, false, 'changeDate('. $event['eventid'] .')');
            if ($event['eventdate'] < time()-86400) {
                echo ' <a href="#" onclick="javascript:removeEvent(\'' . $event['eventid'] . '\');"><img src="' . serendipity_getTemplateFile('admin/img/delete.png') . '" alt="' . DELETE . '" border="0" /></a>';
            }
            echo "  </td>\n";
            echo "  <td>";
            echo $this->getDropdown('day2', $event['eventid'], range(1, 31), $day2, false, 'changeDate2('. $event['eventid'] .')') . ".";
            echo $this->getDropdown('month2', $event['eventid'], range(1, 12), $month2, false, 'changeDate2('. $event['eventid'] .')') . ".";
            echo $this->getDropdown('year2', $event['eventid'], range(date('Y'), date('Y')+2), $year2, false, 'changeDate2('. $event['eventid'] .')');

            echo '<script type="text/javascript">';
            if ($event['eventdate'] == $event['eventdate2']) {
                echo "isOneDayEvent[{$event['eventid']}] = true;";
            } else {
                echo "isOneDayEvent[{$event['eventid']}] = false;";
            }
            echo "</script>";

            echo "  </td>\n";
            echo "</tr>\n";

            echo "<tr style='padding: 10px;' class='serendipity_admin_list_item serendipity_admin_list_item_$even'>\n";
            echo "  <td>&nbsp;</td>\n";
            echo "  <td>" . PLUGIN_MYCALENDAR_EVENTURI_TITLE . ": </td>\n";
            echo "  <td colspan='3'><input class='input_textbox' style='width: 100%' type='text' name=\"serendipity[event][{$event['eventid']}][eventurltitle]\" value=\"" . htmlspecialchars($event['eventurltitle']) . "\" /></td>\n";
            echo "</tr>\n";
        }

        echo '
                <tr>
                    <td colspan="4"><br />
                        <input class="serendipityPrettyButton input_button" type="submit" id="eventaction" name="serendipity[mycalendarAction]" value="' . GO . '" />
                    </td>
                </tr>
              </table>
              </form>';
    }

    function generate_content(&$title) {
        $title = PLUGIN_MYCALENDAR_TITLE;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_sidebar_entries':
?>
                    <li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=mycalendar"><?php echo PLUGIN_MYCALENDAR_TITLE; ?></a></li>
<?php

                    break;

                case 'backend_sidebar_entries_event_display_mycalendar':
                    $this->showevents();
                    break;

                case 'external_plugin':
                    if ($eventData == 'mycalendar.rss') {
                        $plugins = serendipity_plugin_api::enum_plugins('*', false, 'serendipity_plugin_mycalendar', null);
                        if (!is_array($plugins)) {
                            return;
                        }

                        foreach ($plugins as $plugin_data) {
                            $plugin =& serendipity_plugin_api::load_plugin($plugin_data['name'], $plugin_data['authorid'], $plugin_data['path']);
                        }

                        if (!is_object($plugin)) {
                            return;
                        }

                        $items = $plugin->generate_content($eventData, true);
                        header('Content-Type: text/xml; charset=UTF-8');
                        echo '<?xml version="1.0" encoding="utf-8" ?>' . "\n";
?>
<rss version="2.0"
   xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
   xmlns:admin="http://webns.net/mvcb/"
   xmlns:dc="http://purl.org/dc/elements/1.1/"
   xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
   xmlns:wfw="http://wellformedweb.org/CommentAPI/"
   xmlns:content="http://purl.org/rss/1.0/modules/content/"
   >
<channel>
    <title><?php echo $serendipity['blogTitle'] . ' - ' . PLUGIN_MYCALENDAR_TITLE; ?></title>
    <link><?php echo $serendipity['baseURL']; ?></link>
    <description><?php echo PLUGIN_MYCALENDAR_SIDE_NAME; ?></description>
    <generator>Serendipity - http://www.s9y.org/</generator>
<?php
                        foreach($items AS $item) {
?>
<item>
    <title><?php echo serendipity_utf8_encode(htmlspecialchars($item['title'])); ?></title>
    <link><?php echo serendipity_utf8_encode(htmlspecialchars($item['url'])); ?></link>
    <author><?php echo $serendipity['blogTitle']; ?></author>
    <content:encoded>
    <?php echo serendipity_utf8_encode(htmlspecialchars($item['content'])); ?>
    </content:encoded>
    <pubDate><?php echo $item['date']; ?></pubDate>
    <guid isPermaLink="false"><?php echo serendipity_utf8_encode(htmlspecialchars($item['url'])); ?></guid>
</item>
<?php
                        }
?>
</channel>
</rss>
<?php
                    }
                    break;

                case 'frontend_calendar':
                    $this->get_month_events($eventData, $addData);
                    break;
            }
        }

        return true;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
