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
        $propbag->add('author',        'Malte Paskuda');
        $propbag->add('version',       '0.2.3');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8'
        ));
        $propbag->add('event_hooks',   array(
                                    'backend_sidebar_admin'  => true,
                                    'backend_sidebar_entries_event_display_dbclean'  => true,
                                    'external_plugin' => true
            )
            );
        $propbag->add('groups', array('BACKEND_FEATURES'));
    }

    function generate_content(&$title) {
        $title = $this->title;
    }


    /*function introspect_config_item($name, &$propbag) {
        
    }*/


    function event_hook($event, &$bag, &$eventData) {
        global $serendipity;
        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'external_plugin':
                    
                    switch ($eventData) {
                        case 'dbclean':
                            if (! (serendipity_checkPermission('siteConfiguration') || serendipity_checkPermission('blogConfiguration'))) {
                                return;
                            }
                            $days = $_REQUEST['days'];
                            if (is_numeric($days)) {
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
                        echo '<li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks">
                            <a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=dbclean">
                                ' .PLUGIN_EVENT_DBCLEAN_NAME .'
                            </a>
                        </li>';
                    return true;
                    break;


                case 'backend_sidebar_entries_event_display_dbclean':
                    $this->displayMenu();

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
        echo '<style>
        #dbcleanTable {
            width: 100%;
            text-align: center;
        }
        </style>

        <h2>'. PLUGIN_EVENT_DBCLEAN_NAME_MENU .'</h2>

        <form action="'.$serendipity ['baseURL'] . 'index.php?/plugin/dbclean' .'" method="post">
        ' .PLUGIN_EVENT_DBCLEAN_MENU_KEEP .' <input type="string" name="days" value="30" size="3" maxlength="3" /> '.DAYS.'.
        <table id="dbcleanTable">
            <thead>
                <td>
                '.DELETE.'
                </td>
                <td>
                '. PLUGIN_EVENT_DBCLEAN_TABLE .'
                </td>
                <td>
                '. ENTRIES .'
                </td>
            </thead>
            <tr>
                <td>
                <input class="input_checkbox" type="checkbox" name="spamblocklog"  value="spamblocklog"  checked="checked" tabindex="1" />
                </td>
                <td>
                spamblocklog
                </td>
                <td>
                '.$this->countElements('spamblocklog').'
                </td>
            </tr>
             <tr>
                <td>
                <input class="input_checkbox" type="checkbox" name="spamblock_htaccess"  value="spamblock_htaccess"  checked="checked" tabindex="1" />
                </td>
                <td>
                spamblock_htaccess
                </td>
                <td>
                '.$this->countElements('spamblock_htaccess').'
                </td>
            </tr>
             <tr>
                <td>
                <input class="input_checkbox" type="checkbox" name="visitors"  value="visitors"  checked="checked" tabindex="1" />
                </td>
                <td>
                visitors
                </td>
                <td>
                '.$this->countElements('visitors').'
                </td>
            </tr>
            <tr>
                <td>
                <input class="input_checkbox" type="checkbox" name="referrers"  value="referrers"  checked="checked" tabindex="1" />
                </td>
                <td>
                referrers
                </td>
                <td>
                '.$this->countElements('referrers').'
                </td>
            </tr>
            <tr>
                <td>
                <input class="input_checkbox" type="checkbox" name="exits"  value="exits"  checked="checked" tabindex="1" />
                </td>
                <td>
                exits
                </td>
                <td>
                '.$this->countElements('exits').'
                </td>
            </tr>
        </table>
        <input type="submit" value="'. GO .'" tabindex="2" />
        </form>';
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
