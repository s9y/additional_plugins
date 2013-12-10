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

class serendipity_event_outdate_entries extends serendipity_event {
    var $title = PLUGIN_EVENT_OUTDATE;
    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name', PLUGIN_EVENT_OUTDATE);
        $propbag->add('description', PLUGIN_EVENT_OUTDATE_DESC);
        $propbag->add('event_hooks',  array('entries_header' => true, 'entry_display' => true));
        $propbag->add('configuration', array('timeout', 'timeout_sticky', 'timeout_custom'));
        $propbag->add('author', 'Garvin Hicking');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED'));
        $propbag->add('version', '1.6');
        $propbag->add('stackable', false);
        $this->dependencies = array('serendipity_event_entryproperties' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'timeout':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_OUTDATE_TIMEOUT);
                $propbag->add('description', PLUGIN_EVENT_OUTDATE_TIMEOUT_DESC);
                $propbag->add('default',     31);
                break;

            case 'timeout_sticky':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY);
                $propbag->add('description', PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY_DESC);
                $propbag->add('default',     31);
                break;

            case 'timeout_custom':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY_FIELD);
                $propbag->add('description', PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY_FIELD_DESC);
                $propbag->add('default',     '');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENT_OUTDATE;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'entry_display':
                    if ($this->get_config('timeout') > 0) {
                        $sql = "SELECT id, ep.value AS access
                                  FROM {$serendipity['dbPrefix']}entries
                                    AS e
                       LEFT OUTER JOIN {$serendipity['dbPrefix']}entryproperties
                                    AS ep
                                    ON (ep.entryid = e.id AND ep.property = 'ep_access')
                                 WHERE (ep.property IS NULL OR ep.value = 'public')
                                   AND e.timestamp < " . (time() - ($this->get_config('timeout') * 24 * 60 * 60));

                        $rows = serendipity_db_query($sql);
                        if (is_array($rows)) {
                            foreach($rows AS $idx => $row) {
                                if (!empty($row['access'])) {
                                    serendipity_db_query("UPDATE {$serendipity['dbPrefix']}entryproperties SET value = 'member' WHERE entryid = " . (int)$row['id'] . " AND property = 'ep_access'");
                                } else {
                                    serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value) VALUES (" . $row['id'] . ", 'ep_access', 'member')");
                                }
                            }
                        }
                    }

                    $timeout_custom = $this->get_config('timeout_custom');
                    if (!empty($timeout_custom)) {
                        $sql = "SELECT id, ep.value AS access
                                  FROM {$serendipity['dbPrefix']}entries
                                    AS e
                                  JOIN {$serendipity['dbPrefix']}entryproperties
                                    AS ep
                                    ON ep.entryid = e.id
                                 WHERE e.isdraft = 'false'
                                   AND ep.property = 'ep_" . $timeout_custom . "' 
                                   AND ep.value != ''
                                   AND UNIX_TIMESTAMP(ep.value) < " . time();

                        $rows = serendipity_db_query($sql);
                        if (is_array($rows)) {
                            foreach($rows AS $idx => $row) {
                                serendipity_db_query("UPDATE {$serendipity['dbPrefix']}entries SET isdraft = 'true' WHERE id = " . (int)$row['id']);
                            }
                        }
                    }

                    if ($this->get_config('timeout_sticky') > 0) {
                        $sql = "SELECT id, ep.value AS sticky
                                  FROM {$serendipity['dbPrefix']}entries
                                    AS e
                       LEFT OUTER JOIN {$serendipity['dbPrefix']}entryproperties
                                    AS ep
                                    ON ep.entryid = e.id
                                 WHERE (ep.property = 'ep_is_sticky')
                                   AND e.timestamp < " . (time() - ($this->get_config('timeout_sticky') * 24 * 60 * 60));

                        $rows = serendipity_db_query($sql);
                        if (is_array($rows)) {
                            foreach($rows AS $idx => $row) {
                                if (!empty($row['sticky'])) {
                                    serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE property = 'ep_is_sticky' AND entryid = " . (int)$row['id']);
                                }
                            }
                        }
                    }
                    return true;
                    break;

                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
    }
}
/* vim: set sts=4 ts=4 expandtab : */
