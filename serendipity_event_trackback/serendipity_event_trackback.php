<?php # $Id: serendipity_event_trackback.php,v 1.22 2011/04/01 12:59:03 garvinhicking Exp $

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_trackback extends serendipity_event
{
    var $title = PLUGIN_EVENT_MTRACKBACK_TITLETITLE;
    var $cache = array();

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_MTRACKBACK_TITLETITLE);
        $propbag->add('description',   PLUGIN_EVENT_MTRACKBACK_TITLEDESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Malte Paskuda');
        $propbag->add('version',       '1.13');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',    array(
            'backend_display' => true,
            'backend_trackbacks' => true,
            'backend_trackback_check' => true,
            'backend_http_request' => true,
            'genpage' => true,
            'backend_publish' => true,
            'backend_save' => true
        ));
        $propbag->add('configuration', array('disable_trackall', 'trackown', 'delayed_trackbacks', 'host', 'port', 'user', 'password'));
        $propbag->add('groups', array('BACKEND_EDITOR'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'trackown':
                 $propbag->add('type',        'boolean');
                 $propbag->add('name',        PLUGIN_EVENT_MTRACKBACK_TITLETRACKOWN);
                 $propbag->add('default',     true);
                 break;

            case 'disable_trackall':
                 $propbag->add('type',        'boolean');
                 $propbag->add('name',        PLUGIN_EVENT_MTRACKBACK_TITLETRACKALL);
                 $propbag->add('default',     false);
                 break;

            case 'delayed_trackbacks':
                 $propbag->add('type',        'boolean');
                 $propbag->add('name',        PLUGIN_EVENT_MTRACKBACK_DELAYED_TRACKBACKS_NAME);
                 $propbag->add('description', PLUGIN_EVENT_MTRACKBACK_DELAYED_TRACKBACKS_DESC);
                 $propbag->add('default',     true);
                 break;


            case 'host':
                 $propbag->add('type',        'string');
                 $propbag->add('name',        'Proxy Host');
                 $propbag->add('default',     '');
                 break;

            case 'port':
                 $propbag->add('type',        'string');
                 $propbag->add('name',        'Proxy Port');
                 $propbag->add('default',     '');
                 break;

            case 'user':
                 $propbag->add('type',        'string');
                 $propbag->add('name',        'Proxy User');
                 $propbag->add('default',     '');
                 break;

            case 'password':
                 $propbag->add('type',        'string');
                 $propbag->add('name',        'Proxy Password');
                 $propbag->add('default',     '');
                 break;
        }
        return true;
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENT_MTRACKBACK_TITLETITLE;
    }

    function install() {
        $this->setupDB();
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            
            switch($event) {
                case 'backend_http_request':
                    // Setup a Proxy?
                    $host = $this->get_config('host');
                    if (!empty($host)) {
                        $eventData['proxy_host'] = $host;
                        $eventData['proxy_port'] = $this->get_config('port');
                        $eventData['proxy_user'] = $this->get_config('user');
                        $eventData['proxy_pass'] = $this->get_config('password');
                    }

                    return true;
                    break;

                case 'backend_trackbacks':
                    if (!isset($serendipity['POST']['enable_trackback']) && serendipity_db_bool($this->get_config('disable_trackall'))) {
                        $serendipity['noautodiscovery'] = true;
                    } elseif ($serendipity['POST']['enable_trackback'] == 'off') {
                        $serendipity['noautodiscovery'] = true;
                    } else {
                        if ($serendipity['POST']['enable_trackback'] == 'selective') {
                            // Clear TB URLs from the entry, start afresh from the textarea input.
                            $eventData = array();
                        }

                        if (!empty($serendipity['POST']['additional_trackbacks'])) {
                            $trackbackURLs = preg_split('@[ \s]+@', trim($serendipity['POST']['additional_trackbacks']));
                            foreach($trackbackURLs AS $trackbackURL) {
                                $trackbackURL = trim($trackbackURL);
                                if (!in_array($trackbackURL, $eventData)) {
                                    $eventData[] = $trackbackURL;
                                    $this->cache[$trackbackURL] = 'plugin';
                                }
                            }
                        }

                        // Shall URLs be removed that point to your own blog?
                        if (!serendipity_db_bool($this->get_config('trackown'))) {
                            foreach($eventData as $idx => $url) {
                                if (preg_match('@' . preg_quote($serendipity['baseURL'], '@') . '@i', $url)) {
                                    unset($eventData[$idx]);
                                }
                            }
                        }
                    }

                    return true;
                    break;

                case 'backend_trackback_check':
                    $checklock = '';
                    if (isset($this->cache[$addData])) {
                        $eventData[2] = $addData;
                        $eventData['skipValidate'] = true;
                    }

                    return true;
                    break;

                case 'backend_display':
                    $trackbackURLs = array();
                    if (isset($eventData['id']) && $eventData['id'] > 0) {
                        $urls = serendipity_db_query("SELECT link FROM {$serendipity['dbPrefix']}references WHERE entry_id = '". (int)$eventData['id'] ."'");
                        if (is_array($urls)) {
                            foreach($urls AS $row) {
                                $trackbackURLs[] = htmlspecialchars($row['link']);
                            }
                        }
                    }

                    if (isset($serendipity['POST']['additional_trackbacks'])) {
                        $additional_urls = preg_split('@[ \s]+@', trim($serendipity['POST']['additional_trackbacks']));
                        foreach($additional_urls AS $additional_url) {
                            $additional_url = trim($additional_url);
                            if (!in_array($additional_url, $trackbackURLs)) {
                                $trackbackURLs[] = htmlspecialchars($additional_url);
                            }
                        }
                    }

                    if (!isset($serendipity['POST']['enable_trackback'])) {
                        if (serendipity_db_bool($this->get_config('disable_trackall'))) {
                            $serendipity['POST']['enable_trackback'] = 'off';
                        } else {
                            $serendipity['POST']['enable_trackback'] = 'on';
                        }
                    }
?>
                    <fieldset style="margin: 5px">
                        <legend><?php echo PLUGIN_EVENT_MTRACKBACK_TITLETITLE; ?></legend>
                            <input class="input_radio" type="radio" id="checkbox_enable_trackback_1" <?php echo ($serendipity['POST']['enable_trackback'] == 'on'        ? 'checked="checked"' : ''); ?> name="serendipity[enable_trackback]" value="on" /><label for="checkbox_enable_trackback_1"><?php echo ACTIVATE_AUTODISCOVERY; ?></label><br />
                            <input class="input_radio" type="radio" id="checkbox_enable_trackback_2" <?php echo ($serendipity['POST']['enable_trackback'] == 'off'       ? 'checked="checked"' : ''); ?> name="serendipity[enable_trackback]" value="off" /><label for="checkbox_enable_trackback_2"><?php echo PLUGIN_EVENT_MTRACKBACK_TITLETRACKALL; ?></label><br />
                            <input class="input_radio" type="radio" id="checkbox_enable_trackback_3" <?php echo ($serendipity['POST']['enable_trackback'] == 'selective' ? 'checked="checked"' : ''); ?> name="serendipity[enable_trackback]" value="selective" /><label for="checkbox_enable_trackback_3"><?php echo PLUGIN_EVENT_MTRACKBACK_TITLETRACKSEL; ?></label><br />

                            <br />
                            <label for="input_additional_trackbacks"><?php echo PLUGIN_EVENT_MTRACKBACK_TITLEADDITIONAL; ?></label><br />
                                <textarea rows="5" cols="50" id="input_additional_trackbacks" name="serendipity[additional_trackbacks]"><?php echo trim(implode("\n", $trackbackURLs)); ?></textarea>
                    </fieldset>
<?php
                    return true;
                    break;

                case 'backend_save':
                case 'backend_publish':
                    if (!serendipity_db_bool($entry['isdraft'])
                        &&
                            $eventData['timestamp'] >= serendipity_serverOffsetHour()
                        &&
                            serendipity_db_bool($this->get_config('delayed_trackbacks', true))
                        ) {
                        #trackbacks couldn't get generated, so store this entry
                        $this->delay($eventData['id'], $eventData['timestamp']);
                        
                    }
                    return true;
                    break;
                case 'genpage':
                    #don't check on every page
                    $try = mt_rand(1, 10);
                    if ($try == 1 && serendipity_db_bool($this->get_config('delayed_trackbacks', true))) {
                        $this->generateDelayed();
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

     #store id of an entry and wanted release-timestamp 
    function delay($id, $timestamp) {
        global $serendipity;
        $this->upgradeCheck();
        $this->removeDelayed($id);
        $sql = "INSERT INTO
                    {$serendipity['dbPrefix']}delayed_trackbacks (id, timestamp)
                VALUES
                    ({$id}, {$timestamp})";
        serendipity_db_query($sql);
    }

    #generate trackbacks for entries which now are shown
    function generateDelayed() {
        global $serendipity;
        $this->upgradeCheck();
        
        $sql = "SELECT id, timestamp
                FROM
                    {$serendipity['dbPrefix']}delayed_trackbacks";
        $entries = serendipity_db_query($sql);

        if  (!empty($entries[0])) {
            foreach ($entries as $entry) {
                if ($entry['timestamp'] <= serendipity_serverOffsetHour()) {
                    include_once S9Y_INCLUDE_PATH . 'include/functions_trackbacks.inc.php';
                    
                    $stored_entry = serendipity_fetchEntry('id', $entry['id'], 1, 1);
                    
                    if (isset($_SESSION['serendipityRightPublish'])) {
                        $oldPublighRights = $_SESSION['serendipityRightPublish'];
                    } else {
                        $oldPublighRights = 'unset';
                    }
                    $_SESSION['serendipityRightPublish'] = true;
                    #remove unnatural entry-data which let the update fail
                    if (isset($stored_entry['loginname'])) {
                        unset($stored_entry['loginname']);
                    }
                    if (isset($stored_entry['email'])) {
                        unset($stored_entry['email']);
                    }
                    
                    ob_start();
                    serendipity_updertEntry($stored_entry);
                    ob_end_clean();

                    if ($oldPublighRights == 'unset') {
                        unset($_SESSION['serendipityRightPublish']);
                    } else {
                        $_SESSION['serendipityRightPublish'] = $oldPublighRights;
                    }
                    #the trackbacks are now generated
                    $this->removeDelayed($entry['id']);
                }
            }
        }
    }

    #remove delayed entry from further use
    function removeDelayed($id) {
        global $serendipity;
        $sql = "DELETE FROM
                 {$serendipity['dbPrefix']}delayed_trackbacks
                 WHERE id={$id}";
        serendipity_db_query($sql);
    }

    function setupDB() {
	    global $serendipity;
		$sql = "CREATE TABLE {$serendipity['dbPrefix']}delayed_trackbacks (
id int(11) NOT NULL ,
timestamp int(10) {UNSIGNED}
PRIMARY KEY (id)
)";
		serendipity_db_schema_import ( $sql );
    }

    function upgradeCheck() {
        $db_upgrade = serendipity_db_bool($this->get_config('db_upgrade', false));
        if ($db_upgrade == false || $db_upgrade === null) {
            $this->setupDB();
            $this->set_config('db_upgrade', true);
        }
    }
    
}

/* vim: set sts=4 ts=4 expandtab : */
