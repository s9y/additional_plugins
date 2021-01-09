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

class serendipity_event_communityrating extends serendipity_event
{
    var $services;
    var $title = PLUGIN_EVENT_COMMUNITYRATING_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_COMMUNITYRATING_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_COMMUNITYRATING_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Lewe Zipfel');
        $propbag->add('version',       '1.12.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',    array(
            'backend_publish'                                   => true,
            'backend_save'                                      => true,
            'backend_display'                                   => true,
            'entry_display'                                     => true,
            'external_plugin'                                   => true,
            'frontend_rss'                                      => true,
            'frontend_fetchentries'                             => true
        ));
        $propbag->add('groups', array('BACKEND_EDITOR'));
        $propbag->add('configuration', array('types'));
        $this->dependencies = array('serendipity_event_entryproperties' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'types':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_COMMUNITYRATING_TYPES);
                $propbag->add('description', '');
                $propbag->add('default',     PLUGIN_EVENT_COMMUNITYRATING_TYPES_DEFAULT);
                break;
        }
        return true;
    }

    function smarty_init() {
        global $serendipity;
        if (!isset($this->smarty_init)) {
            include_once dirname(__FILE__) . '/smarty.inc.php';
            if (isset($serendipity['smarty'])) {
                $serendipity['smarty']->register_function('communityrating_show', 'communityrating_serendipity_show');
                $this->smarty_init = true;
            }
        }
    }
    function generate_content(&$title) {
        $title = $this->title;
    }

    function &getSupportedProperties() {
        static $supported_properties = null;

        if ($supported_properties === null) {
            $_supported_properties = explode(',', $this->get_config('types'));
            $supported_properties = array();
            foreach($_supported_properties AS $idx => $prop) {
                $prop = trim($prop);
                $supported_properties[$prop] = $prop;
                $supported_properties[$prop . '_id'] = '';
                $supported_properties[$prop . '_rating'] = '';
            }
        }

        return $supported_properties;
    }

    function addProperties(&$properties, &$eventData) {
        global $serendipity;
        // Get existing data
        $property = serendipity_fetchEntryProperties($eventData['id']);
        $supported_properties =& $this->getSupportedProperties();
        foreach($supported_properties AS $prop_key => $_pkey) {
            if (!preg_match('@_(id|rating)$@', $prop_key)) {
                continue;
            }

            $prop_val = (isset($properties[$prop_key]) ? $properties[$prop_key] : null);
            $prop_key = 'cr_' . $prop_key;

            if (is_array($prop_val)) {
                $prop_val = ";" . implode(';', $prop_val) . ";";
            }

            $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = " . (int)$eventData['id'] . " AND property = '" . serendipity_db_escape_string($prop_key) . "'";
            serendipity_db_query($q);

            if (!empty($prop_val)) {
                $q = "INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value) VALUES (" . (int)$eventData['id'] . ", '" . serendipity_db_escape_string($prop_key) . "', '" . serendipity_db_escape_string($prop_val) . "')";
                serendipity_db_query($q);
            }
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_display':
                    $props =& $this->getSupportedProperties();
?>
                    <fieldset style="margin: 5px">
                        <legend><?php echo PLUGIN_EVENT_COMMUNITYRATING_TITLE; ?></legend>
<?php
                    foreach($props AS $prop => $prop_val) {
                        if (preg_match('@_(id|rating)$@', $prop)) {
                            continue;
                        }

                        $vals = array('id'     => '',
                                      'rating' => '');
                        foreach($vals AS $vidx => $val) {
                            if (isset($eventData['properties']['cr_' . $prop . '_' . $vidx])) {
                                $vals[$vidx] = $eventData['properties']['cr_' . $prop . '_' . $vidx];
                            } elseif (isset($serendipity['POST']['properties'][$prop . '_' . $vidx])) {
                                $vals[$vidx] = $serendipity['POST']['properties'][$prop . '_' . $vidx];
                            } else {
                                $vals[$vidx] = '';
                            }
                        }
?>
                        <strong><?php echo $prop; ?>:</strong><br />
                            <label title="<?php echo PLUGIN_EVENT_COMMUNITYRATING_ID; ?>" for="properties_rating_id"><?php echo PLUGIN_EVENT_COMMUNITYRATING_ID; ?></label>: <input class="input_textbox" id="properties_rating_id" type="text" name="serendipity[properties][<?php echo $prop . '_id'; ?>]" value="<?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($vals['id']) : htmlspecialchars($vals['id'], ENT_COMPAT, LANG_CHARSET)); ?>" size="10" />
                            <label title="<?php echo PLUGIN_EVENT_COMMUNITYRATING_RATING; ?>" for="properties_rating_points"><?php echo PLUGIN_EVENT_COMMUNITYRATING_RATING; ?></label>: <input class="input_textbox" id="properties_rating_points" type="text" name="serendipity[properties][<?php echo $prop . '_rating'; ?>]" value="<?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($vals['rating']) : htmlspecialchars($vals['rating'], ENT_COMPAT, LANG_CHARSET)); ?>" size="2" />
                            <br />
<?php
                    }
?>
                    </fieldset>
<?php
                    return true;
                    break;

                case 'backend_publish':
                case 'backend_save':
                    if (!isset($serendipity['POST']['properties']) || !is_array($serendipity['POST']['properties']) || !isset($eventData['id'])) {
                        return true;
                    }

                    $this->addProperties($serendipity['POST']['properties'], $eventData);

                    return true;
                    break;


                case 'entry_display':
                    $this->smarty_init();

                    // PH: This is done after Garvins suggestion to patchup $eventData in case an entry
                    //     is in the process of being created. This must be done for the extended properties
                    //     to be applied in the preview.
                    if (is_array($serendipity['POST']['properties']) && count($serendipity['POST']['properties']) > 0){
                        $parr = array();
                        $supported_properties =& $this->getSupportedProperties();
                        foreach($supported_properties AS $prop_key => $prop_val) {
                            if (isset($serendipity['POST']['properties'][$prop_key]))
                                $eventData[0]['properties']['cr_' . $prop_key] = $serendipity['POST']['properties'][$prop_key];
                        }
                    }
                    break;

                case 'frontend_fetchentries':
                case 'frontend_rss':
                    $this->smarty_init();
                    break;

                case 'external_plugin':
                    $params = explode('_', $eventData);
                    if ($params[0] == 'communityrating') {
                        $type = serendipity_db_escape_string($params[1]);
                        $id   = serendipity_db_escape_string($params[2]);

                        if ($id == 'all') {
                            $sql = "SELECT e.title, e.timestamp, p1.property, p1.entryid, p2.value, p1.value AS backupvalue
                                   FROM {$serendipity['dbPrefix']}entryproperties AS p1
                        LEFT OUTER JOIN {$serendipity['dbPrefix']}entryproperties AS p2
                                     ON (p2.entryid = p1.entryid AND p2.property = 'cr_{$type}_rating')
                        LEFT OUTER JOIN {$serendipity['dbPrefix']}entries AS e
                                     ON p2.entryid = e.id
                                  WHERE (p1.property = 'cr_{$type}_id')
                                     OR (p1.property LIKE 'cr_{$type}_rating:%')
                               ORDER BY p2.value DESC";
                        } else {
                            $sql = "SELECT e.title, e.timestamp, p1.property, p1.entryid, p2.value, p1.value AS backupvalue
                                   FROM {$serendipity['dbPrefix']}entryproperties AS p1
                        LEFT OUTER JOIN {$serendipity['dbPrefix']}entryproperties AS p2
                                     ON (p2.entryid = p1.entryid AND p2.property = 'cr_{$type}_rating')
                        LEFT OUTER JOIN {$serendipity['dbPrefix']}entries AS e
                                     ON p2.entryid = e.id
                                  WHERE (p1.property = 'cr_{$type}_id' AND p1.value = '{$id}')
                                     OR (p1.property = 'cr_{$type}_rating:{$id}')
                               ORDER BY p2.value DESC
                                  LIMIT 1";
                        }

                        $rows = serendipity_db_query($sql, false, 'assoc');

                        header('HTTP/1.0 200');
                        header('Status: 200 OK');
                        header('Content-Type: text/xml');
                        echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
                        echo '<communityratings>' . "\n";
                        if (is_array($rows)) {
                            foreach($rows AS $row) {
                                if ($id == 'all') {
                                    if (preg_match('@:(.*)$@', $row['property'], $match)) {
                                        $cid = $match[1];
                                    } else {
                                        $cid = $row['backupvalue'];
                                    }
                                } else {
                                    $cid = $id;
                                }

                                echo '<communityrating>' . "\n";
                                echo '<id>' .  serendipity_utf8_encode($cid) . '</id>' . "\n";
                                if (empty($row['value'])) {
                                    $row['value'] = $row['backupvalue'];
                                }

                                echo '<rating>' . serendipity_utf8_encode($row['value']) . '</rating>' . "\n";

                                if ($row['entryid'] > 0) {
                                    echo '<url>' . serendipity_utf8_encode(serendipity_archiveURL($row['entryid'], $row['title'], 'baseURL', true, array('timestamp' => $row['timestamp']))) . '</url>' . "\n";
                                }
                                echo '</communityrating>' . "\n";
                            }
                        }
                        echo '</communityratings>' . "\n";
                    }

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
