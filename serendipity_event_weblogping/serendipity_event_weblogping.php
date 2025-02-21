<?php

if (IN_serendipity !== true) { die ("Don't hack!"); }

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_weblogping extends serendipity_event
{
    var $services;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_WEBLOGPING_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_WEBLOGPING_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Serendipity Team');
        $propbag->add('version',       '1.10');
        $propbag->add('requirements',  array(
            'serendipity' => '2.4',
            'php'         => '7.4.0'
        ));
        $propbag->add('event_hooks',    array(
            'frontend_display' => true,
            'backend_display' => true,
            'backend_publish' => true,
            'backend_save' => true,
            'external_plugin' => true,
            'genpage' => true
        ));
        $propbag->add('groups', array('BACKEND_EDITOR'));

        $servicesdb = array();
        $servicesdb_file = dirname(__FILE__) . '/servicesdb_' . $serendipity['lang'] . '.inc.php';
        if (!file_exists($servicesdb_file)) {
            $servicesdb_file = dirname(__FILE__) . '/servicesdb_en.inc.php';
        }
        include $servicesdb_file;
        $this->services =& $servicesdb;


        $manual_services = explode(',', $this->get_config('manual_services'));
        if (is_array($manual_services)) {
            foreach($manual_services AS $ms_index => $ms_name) {
                if (!empty($ms_name)) {
                    $is_extended = ($ms_name[0] == '*');
                    $ms_name = trim($ms_name, '*');

                    $this->services[] = array(
                                          'name'     => $ms_name,
                                          'host'     => parse_url($ms_name, PHP_URL_HOST),
                                          'path'     => (parse_url($ms_name, PHP_URL_PATH) ?? '/'),
                                          'extended' => $is_extended
                    );
                }
            }
        }

        $conf_array = array();
        foreach($this->services AS $key => $service) {
            $conf_array[] = $service['name'];
        }

        $conf_array[] = 'manual_services';

        $propbag->add('configuration', $conf_array);
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'manual_services':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_WEBLOGPING_CUSTOM);
                $propbag->add('description', PLUGIN_EVENT_WEBLOGPING_CUSTOM_BLAHBLA);
                $propbag->add('default', '');
                break;

            default:
                $propbag->add('type',        'boolean');
                $propbag->add('name',        $name);
                $propbag->add('description', sprintf(PLUGIN_EVENT_WEBLOGPING_PING, $name));
                $propbag->add('default', 'false');
        }
        return true;
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENT_WEBLOGPING_TITLE;
    }

    function install() {
        $this->setupDB();
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_display':
?>
                    <fieldset class="entryproperties">
                        <span class="wrap_legend"><legend><?php echo PLUGIN_EVENT_WEBLOGPING_PING; ?></legend></span>
                        <div class="ping_services">
<?php
                    $noneclick = '';
                    foreach($this->services AS $index => $service) {
                        // Detect if the current checkbox needs to be saved. We use the field chk_timestamp to see,
                        // if the form has already been submitted and individual changes shall be preserved
                        $selected = (($serendipity['POST']['chk_timestamp'] && $serendipity['POST']['announce_entries_' . $service['name']]) || (!isset($serendipity['POST']['chk_timestamp']) && $this->get_config($service['name']) == 'true') ? 'checked="checked"' : '');

                        $noneclick .= 'document.getElementById(\'serendipity[announce_entries_' . $service['name'] . ']\').checked = false; ';
                        $onclick   = '';
                        if (!empty($service['supersedes'])) {
                            $onclick    = 'onclick="';
                            $supersedes = $service['supersedes'];
                            foreach($supersedes AS $sid => $servicename) {
                                $onclick .= 'document.getElementById(\'serendipity[announce_entries_' . $servicename . ']\').checked = false; ';
                            }
                            $onclick    .= '"';
                        }

                        $title    = sprintf(PLUGIN_EVENT_WEBLOGPING_SENDINGPING, $service['name'])
                                  . (!empty($service['supersedes']) ?  ' ' . sprintf(PLUGIN_EVENT_WEBLOGPING_SUPERSEDES, implode(',', $service['supersedes'])) : '');
?>
                            <div class="form_check">
                                <input <?php echo $onclick; ?> type="checkbox" name="serendipity[announce_entries_<?php echo $service['name']; ?>]" id="serendipity[announce_entries_<?php echo $service['name']; ?>]" value="true" <?php echo $selected; ?>>
                                <label title="<?php echo $title; ?>" for="serendipity[announce_entries_<?php echo $service['name']; ?>]"><?php echo $service['name']; ?></label>
                            </div>
<?php
    }
?>
                            <div class="form_check">
                                <input onclick="<?php echo $noneclick; ?>" type="checkbox" value="none" id="serendipity[announce_entries_none]">
                                <label title="<?php echo NONE; ?>" for="serendipity[announce_entries_none]"><?php echo NONE; ?></label>
                            </div>
                        </div>
                    </fieldset>
<?php
                    return true;
                    break;

                case 'backend_save':
                case 'backend_publish':
                    if (!class_exists('XML_RPC_Base')) {
                        include_once(S9Y_PEAR_PATH . "XML/RPC.php");
                    }

                    // First cycle through list of services to remove superseding services which may have been checked
                    foreach ($this->services AS $index => $service) {
                        if (!empty($service['supersedes']) && isset($serendipity['POST']['announce_entries_' . $service['name']])) {
                            $supersedes = $service['supersedes'];
                            foreach($supersedes AS $sid => $servicename) {
                                // A service has been checked that is superseded by another checked meta-service. Remove that service from the list of services to be ping'd
                                unset($serendipity['POST']['announce_entries_' . $servicename]);
                            }
                        }
                    }
                    foreach ($this->services AS $index => $service) {
                        if (isset($serendipity['POST']['announce_entries_' . $service['name']]) || (defined('SERENDIPITY_IS_XMLRPC') && serendipity_db_bool($this->get_config($service['name'])))) {
                            if (!defined('SERENDIPITY_IS_XMLRPC') || defined('SERENDIPITY_XMLRPC_VERBOSE')) {
                                printf(PLUGIN_EVENT_WEBLOGPING_SENDINGPING . '...', $service['host']);
                            }
                            flush();

                            # XXX append $serendipity['indexFile'] to baseURL?
                            $args = array(
                              new XML_RPC_Value(
                                $serendipity['blogTitle'],
                                'string'
                              ),
                              new XML_RPC_Value(
                                $serendipity['baseURL'],
                                'string'
                              )
                            );

                            if ($service['extended']) {
                                # the checkUrl: for when the main page is not really the main page
                                $args[] = new XML_RPC_Value(
                                  '',
                                  'string'
                                );

                                # the rssUrl
                                $args[] = new XML_RPC_Value(
                                  $serendipity['baseURL'] . 'rss.php?version=2.0',
                                  'string'
                                );
                            }

                            $message = new XML_RPC_Message(
                              $service['extended'] ? 'weblogUpdates.extendedPing' : 'weblogUpdates.ping',
                              $args
                            );

                            $client = new XML_RPC_Client(
                              trim($service['path']),
                              trim($service['host'])
                            );

                            # 15 second timeout may not be long enough for weblogs.com
                            $message->createPayload();
                            if (strtoupper(LANG_CHARSET) != 'UTF-8') {
                                $payload = utf8_encode($message->payload);
                            } else {
                                $payload = $message->payload;
                            }
                            
                            if (function_exists('serendipity_request_url')) {
                                if (!serendipity_db_bool($eventData['isdraft']) &&
                                    $eventData['timestamp'] >= serendipity_serverOffsetHour()
                                    ) {
                                    # Entry will be not be published yet, so send the ping later
                                    $this->delay($eventData['id'], "https://".$service['host'].$service['path'], $payload, $eventData['timestamp']);
                                    echo "Ping scheduled";
                                    continue;
                                } else {
                                    # Remove a potentially already scheduled ping
                                    $this->removeDelayed($eventData['id'], "https://".$service['host'].$service['path']);
                                    $http_response = serendipity_request_url("https://".$service['host'].$service['path'], 'POST', 'text/xml', $payload, null, 'weblogping');
                                }
                            } else {
                                echo "Unable to ping";
                                return false;
                            }
                            
                            if ($http_response == 'success' && $serendipity['last_http_request']['responseCode'] == 200) {
                                // Some ping services, like the uberblogr webring, do not send an
                                // xmlrpc response
                                $out = PLUGIN_EVENT_WEBLOGPING_SEND_SUCCESS . "<br />";
                                if (!defined('SERENDIPITY_IS_XMLRPC') || defined('SERENDIPITY_XMLRPC_VERBOSE')) {
                                    echo $out;
                                }
                                continue;
                            }
                            
                            if ($http_response == 'warning') {
                                $out = sprintf(PLUGIN_EVENT_WEBLOGPING_SEND_FAILURE . "<br />", 'Unknown Warning as response');
                                if (!defined('SERENDIPITY_IS_XMLRPC') || defined('SERENDIPITY_XMLRPC_VERBOSE')) {
                                    echo $out;
                                }
                                continue;
                            }

                            $xmlrpc_result = $message->parseResponse($http_response);
                            if ($xmlrpc_result->faultCode()) {
                                $out = sprintf(PLUGIN_EVENT_WEBLOGPING_SEND_FAILURE . "<br />", (function_exists('serendipity_specialchars') ? serendipity_specialchars($xmlrpc_result->faultString()) : htmlspecialchars($xmlrpc_result->faultString(), ENT_COMPAT, LANG_CHARSET)));
                            } else {
                                $out = PLUGIN_EVENT_WEBLOGPING_SEND_SUCCESS . "<br />";
                            }

                            if (!defined('SERENDIPITY_IS_XMLRPC') || defined('SERENDIPITY_XMLRPC_VERBOSE')) {
                                echo $out;
                            }
                        }
                    }

                    return true;
                    break;

                case 'external_plugin':
                    if ($eventData == 'xmlrpc_ping') {
                        echo "XMLRPC START\n";
                        @define('SERENDIPITY_IS_XMLRPC', true);
                        @define('SERENDIPITY_XMLRPC_VERBOSE', true);
                        $this->event_hook('backend_publish', $bag, $eventData);
                        echo "XMLRPC DONE\n";
                    }
                    return true;

                case 'genpage':
                    # Do not check on every page
                    $try = mt_rand(1, 10);
                    if ($try == 1) {
                        $this->generateDelayed();
                    }
                    break;

                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
    }

    # Store for each entry the ping target, payload and timestamp of release
    function delay($entry_id, $target, $payload, $timestamp) {
        global $serendipity;
        $this->upgradeCheck();
        $this->removeDelayed($entry_id, $target);
        $sql = "INSERT INTO
                    {$serendipity['dbPrefix']}delayed_weblogpings (entry_id, target, payload, timestamp)
                VALUES
                    (" . serendipity_db_escape_string($entry_id) .', "' . serendipity_db_escape_string($target) . '", "' . serendipity_db_escape_string($payload) . '", ' . serendipity_db_escape_string($timestamp) . ')';
        serendipity_db_query($sql);
    }

    
    # Send the pings for entries which now are shown
    function generateDelayed() {
        global $serendipity;
        $this->upgradeCheck();

        $sql = "SELECT entry_id, target, payload, timestamp
                FROM
                    {$serendipity['dbPrefix']}delayed_weblogpings";
        $pings = serendipity_db_query($sql);

        if (is_array($pings) && !empty($pings)) {
            foreach ($pings as $ping) {
                if ($ping['timestamp'] <= serendipity_serverOffsetHour()) {
                    serendipity_request_url($ping['target'], 'POST', 'text/xml', $ping['payload'], null, 'weblogping');
                    
                    # the pings are now sent
                    $this->removeDelayed($ping['entry_id'], $ping['target']);
                }
            }
        }
    }

    # Remove delayed ping from further use
    function removeDelayed($entry_id, $target) {
        global $serendipity;
        $sql = "DELETE FROM {$serendipity['dbPrefix']}delayed_weblogpings
                      WHERE entry_id= " . serendipity_db_escape_string($entry_id) . ' AND target="' .serendipity_db_escape_string($target) . '"';
        serendipity_db_query($sql);
    }

     function setupDB() {
        global $serendipity;

        $sql = "CREATE TABLE IF NOT EXISTS  {$serendipity['dbPrefix']}delayed_weblogpings (
                entry_id int(11) NOT NULL,
                target VARCHAR(200) NOT NULL,
                payload {TEXT} NOT NULL,
                timestamp int(10) {UNSIGNED},
                PRIMARY KEY(entry_id, target)
                )";
        serendipity_db_schema_import($sql);
    }

    function upgradeCheck() {
        $db_upgrade = $this->get_config('db_upgrade', '');
        if ($db_upgrade != 1) {
            $this->setupDB();
            $this->set_config('db_upgrade', 1);
        }
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>
