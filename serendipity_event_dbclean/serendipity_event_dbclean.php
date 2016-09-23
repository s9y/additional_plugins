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

class serendipity_event_dbclean extends serendipity_event {
    var $title = PLUGIN_EVENT_DBCLEAN_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_DBCLEAN_NAME);
        $propbag->add('description',   PLUGIN_EVENT_DBCLEAN_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Malte Paskuda, Matthias Mees');
        $propbag->add('version',       '0.2.9');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8'
        ));
        $propbag->add('event_hooks',   array(
                                    'backend_sidebar_admin'  => true,
                                    'backend_sidebar_entries_event_display_dbclean'  => true,
                                    'external_plugin' => true,
                                    'css_backend' => true,
                                    'cronjob' => true
            )
            );
        $propbag->add('groups', array('BACKEND_FEATURES'));
        $propbag->add('configuration', array('cronjob', 'days'));
    }

    function generate_content(&$title) {
        $title = $this->title;
    }


    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'cronjob':
                if (class_exists('serendipity_event_cronjob')) {
                    $propbag->add('type',        'select');
                    $propbag->add('name',        PLUGIN_EVENT_DBCLEAN_CRONJOB);
                    $propbag->add('description', '');
                    $propbag->add('default',     'daily');
                    $propbag->add('select_values', serendipity_event_cronjob::getValues());
                }
                break;

            case 'days':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_DBCLEAN_MENU_KEEP . ' (' . DAYS . ')');
                $propbag->add('description', '');
                $propbag->add('default',     '30');
                break;

            default:
                return false;
        }
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;
        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'cronjob':
                    if ($this->get_config('cronjob') == $eventData) {
                        serendipity_event_cronjob::log('DBClean', 'plugin');

                        $days = (int)$this->get_config('days');
                        if ($days > 0) {
                            $this->cleanDB('cronjoblog', $days);
                            $this->cleanDB('spamblocklog', $days);
                            $this->cleanDB('spamblock_htaccess', $days);
                            $this->cleanDB('visitors', $days);
                            $this->cleanDB('referrers', $days);
                            $this->cleanDB('exits', $days);
                        }
                    }
                    return true;
                    break;

                case 'external_plugin':

                    switch ($eventData) {
                        case 'dbclean':
                            if (! (serendipity_checkPermission('siteConfiguration') || serendipity_checkPermission('blogConfiguration'))) {
                                return;
                            }
                            $days = $_REQUEST['days'];
                            if (is_numeric($days)) {
                                if (isset($_REQUEST['cronjoblog'])) {
                                    $this->cleanDB('cronjoblog', $days);
                                }
                                if (isset($_REQUEST['spamblocklog'])) {
                                    $this->cleanDB('spamblocklog', $days);
                                }
                                if (isset($_REQUEST['spamblock_htaccess'])) {
                                    $this->cleanDB('spamblock_htaccess', $days);
                                }
                                if (isset($_REQUEST['visitors'])) {
                                    $this->cleanDB('visitors', $days);
                                }
                                if (isset($_REQUEST['referrers'])) {
                                    $this->cleanDB('referrers', $days);
                                }
                                if (isset($_REQUEST['exits'])) {
                                    $this->cleanDB('exits', $days);
                                }
                            }
                            #redirect the user back to the menu
                            echo '<meta http-equiv="REFRESH" content="0;url=serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=dbclean">';
                            return true;
                            break;
                        }
                        return true;
                        break;

                case 'backend_sidebar_admin':
                    if ($serendipity['version'][0] == '1') {
                        echo '<li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=dbclean">' .PLUGIN_EVENT_DBCLEAN_NAME .'</a></li>';
                    } else {
                        echo '<li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=dbclean">' .PLUGIN_EVENT_DBCLEAN_NAME .'</a></li>';
                    }
                    return true;
                    break;


                case 'backend_sidebar_entries_event_display_dbclean':
                    $this->displayMenu();

                    return true;
                    break;

                case 'css_backend':
                    if ($serendipity['version'][0] > 1) {
?>

#dbcleanTable {
    border: 1px solid #aaa;
    border-bottom: 0 none;
    width: 100%;
}

#dbcleanTable thead tr {
    background-color: #eee;
}

#dbcleanTable tr {
    border-bottom: 1px solid #aaa;
}

#dbcleanTable th,
#dbcleanTable td {
    padding: .125em .25em;
}

<?php
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

    function cleanDB($table, $days) {
        global $serendipity;
        set_time_limit(0);
        if($table=='visitors') {
            $sql = "DELETE
                FROM {$serendipity['dbPrefix']}visitors
                WHERE unix_timestamp(concat(day,' ',time)) <" . (time() - ($days*24*60*60));
            serendipity_db_query($sql);
        } else if ($table =='referrers') {
             $sql = "DELETE
                    FROM {$serendipity['dbPrefix']}$table
                    WHERE day <" . (time() - ($days*24*60*60));
            serendipity_db_query($sql);
        } else if ($table =='exits') {
             $sql = "DELETE
                    FROM {$serendipity['dbPrefix']}$table
                    WHERE day < '" . date( 'Y-m-d', (time() - ($days*24*60*60))) ."'";
            serendipity_db_query($sql);
        } else {
            $sql = "DELETE
                    FROM {$serendipity['dbPrefix']}$table
                    WHERE timestamp < " . (time() - ($days*24*60*60));
            serendipity_db_query($sql);
        }

        switch($serendipity['dbType']) {
            case 'sqlite':
            case 'sqlite3':
            case 'sqlite3oo':
            case 'pdo-sqlite':
                $sql = "VACUUM";
                serendipity_db_query($sql);
                break;

            case 'pdo-postgres':
            case 'postgres':
                $sql = "VACUUM";
                serendipity_db_query($sql);
                break;

            case 'mysql':
            case 'mysqli':
                $sql = "OPTIMIZE TABLE
                        {$serendipity['dbPrefix']}$table";
                serendipity_db_query($sql);
                break;
        }

    }

    function displayMenu() {
        global $serendipity;
        if ($serendipity['version'][0] == '1') {
            echo '<style>#dbcleanTable { width: 100%; text-align: center; } #dbcleanTable th { text-align: center; }</style>';
        }

        echo '<h2>' . PLUGIN_EVENT_DBCLEAN_NAME_MENU . '</h2>';

        echo '<form action="'.$serendipity ['baseURL'] . 'index.php?/plugin/dbclean' .'" method="post">';
        if ($serendipity['version'][0] == '1') {
            echo PLUGIN_EVENT_DBCLEAN_MENU_KEEP . ' <input type="text" name="days" value="' . $this->get_config('days') . '" size="3" maxlength="3" /> ' . DAYS;
        } else {
            echo '<div class="form_field">';
            echo '<label for="dbcleanup_days">' . PLUGIN_EVENT_DBCLEAN_MENU_KEEP . ' (' . DAYS . ')' . '</label>';
            echo ' <input id="dbcleanup_days" type="text" name="days" value="' . $this->get_config('days') . '" size="3" maxlength="3">';
            echo '</div>';
        }

        echo '<table id="dbcleanTable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>' . DELETE . '</th>';
        echo '<th>' . PLUGIN_EVENT_DBCLEAN_TABLE . '</th>';
        echo '<th>' . ENTRIES . '</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        echo '<tr>';
        echo '<td><input class="input_checkbox" type="checkbox" name="spamblocklog"  value="spamblocklog"  checked="checked" tabindex="1" /></td>';
        echo '<td>spamblocklog</td>';
        echo '<td>' . $this->countElements('spamblocklog') . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td><input class="input_checkbox" type="checkbox" name="spamblock_htaccess"  value="spamblock_htaccess"  checked="checked" tabindex="1" /></td>';
        echo '<td>spamblock_htaccess</td>';
        echo '<td>' . $this->countElements('spamblock_htaccess') . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td><input class="input_checkbox" type="checkbox" name="visitors"  value="visitors"  checked="checked" tabindex="1" /></td>';
        echo '<td>visitors</td>';
        echo '<td>' . $this->countElements('visitors') . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td><input class="input_checkbox" type="checkbox" name="referrers"  value="referrers"  checked="checked" tabindex="1" /></td>';
        echo '<td>referrers</td>';
        echo '<td>' . $this->countElements('referrers') . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td><input class="input_checkbox" type="checkbox" name="exits"  value="exits"  checked="checked" tabindex="1" /></td>';
        echo '<td>exits</td>';
        echo '<td>' . $this->countElements('exits') . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td><input class="input_checkbox" type="checkbox" name="cronjoblog"  value="cronjoblog"  checked="checked" tabindex="1" /></td>';
        echo '<td>cronjoblog</td>';
        echo '<td>' . $this->countElements('cronjoblog') . '</td>';
        echo '</tr>';
        echo '</table>';
        if ($serendipity['version'][0] == '1') {
            echo '<input type="submit" value="' . GO . '" tabindex="2" />';
        } else {
            echo '<div class="form_buttons"><input class="state_cancel" type="submit" value="' . DELETE . '"></div>';
        }
        echo '</form>';
    }

    function countElements($table, $timespan=false) {
        global $serendipity;
        if (! $timespan) {
            $sql = "SELECT COUNT(*)
                    FROM {$serendipity['dbPrefix']}$table";
        } else {
            if ($table=='visitors') {
                $sql = "SELECT COUNT(*)
                    FROM {$serendipity['dbPrefix']}visitors
                    WHERE unix_timestamp(concat(day,' ',time)) < $timespan";
            } else if ($table =='referrers') {
                $sql = "SELECT COUNT(*)
                        FROM {$serendipity['dbPrefix']}$table
                        WHERE day < $timespan";
            } else {
                $sql = "SELECT COUNT(*)
                        FROM {$serendipity['dbPrefix']}$table
                        WHERE timestamp < $timespan";
            }
        }
        $count = serendipity_db_query($sql);
        if(is_array($count)) {
            if (is_array($count[0])) {
                return $count[0][0];
            }
        }
        return 0;
    }

    function debugMsg($msg) {
		global $serendipity;

		$this->debug_fp = @fopen ( $serendipity ['serendipityPath'] . 'templates_c/dbclean.log', 'a' );
		if (! $this->debug_fp) {
			return false;
		}

		if (empty ( $msg )) {
			fwrite ( $this->debug_fp, "failure \n" );
		} else {
			fwrite ( $this->debug_fp, print_r ( $msg, true ) );
		}
		fclose ( $this->debug_fp );
	}

}

/* vim: set sts=4 ts=4 expandtab : */
?>