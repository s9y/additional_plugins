<?php
@define('PLUGIN_IMPORT_EXPORT_TITLE', 'Liberty Inc. Shipping - Import/Export your Goods! [ALPHA]');

class serendipity_event_importexport extends serendipity_event {
    var $title = PLUGIN_IMPORT_EXPORT_TITLE;
    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name', PLUGIN_IMPORT_EXPORT_TITLE);
        $propbag->add('description', '');
        $propbag->add('event_hooks',  array('backend_display' => true));
        $propbag->add('author', 'Garvin Hicking');
        $propbag->add('version', '1.0');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.0.0'
        ));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
        $propbag->add('stackable', false);
    }

    function generate_content(&$title) {
        $title = PLUGIN_IMPORT_EXPORT_TITLE;
    }

    function export_items($table, $primary_key, $ref_key, $primary_key_value) {
        global $serendipity;

        $result = serendipity_db_Query("SELECT * FROM {$serendipity['dbPrefix']}{$table} WHERE $ref_key = $primary_key_value", false, 'assoc');
        foreach ($result AS $row) {
            $row[$ref_key] = '@last';
            if ($primary_key !== null) {
                unset($row[$primary_key]);
            }
            
            foreach($row AS $key => $val) {
                if ($val != '@last') {
                    $row[$key] = "'" . serendipity_db_escape_string($val) . "'";
                }
            }
            echo "INSERT INTO {$serendipity['dbPrefix']}{$table} (" . implode(', ', array_keys($row)) . ") VALUES (" . implode(', ', $row) . ");\n";
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_display':
                    echo '<fieldset><legend>' . PLUGIN_IMPORT_EXPORT_TITLE . '</legend>';
                    
                    if (!isset($eventData['id'])) {
                        echo 'You can only export entries that are already saved';
                        return true;
                    }

                    echo 'Use this SQL query to import the entry you are currently viewing into a seperate MySQL-Database:' . "<br />\n";
                    echo '<textarea style="width: 100%; height: 200px">';
                    $this->export_items('entries', 'id', 'id', $eventData['id']);
                    echo "SELECT @last:=LAST_INSERT_ID();\n";
                    
                    $this->export_items('references',     'id',  'entry_id', $eventData['id']);
                    $this->export_items('entryproperties', null, 'entryid',  $eventData['id']);
                    $this->export_items('entrycat',        null, 'entryid',  $eventData['id']);
                    $this->export_items('comments',        'id', 'entry_id', $eventData['id']);

                    echo '</textarea>';
                    echo '</fieldset>';
                    
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