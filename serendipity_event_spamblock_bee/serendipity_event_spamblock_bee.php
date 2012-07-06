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

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_DEBUG', FALSE);

class serendipity_event_spamblock_bee extends serendipity_event
{
    var $title = PLUGIN_EVENT_SPAMBLOCK_BEE_TITLE;
    
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_SPAMBLOCK_BEE_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_SPAMBLOCK_BEE_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Grischa Brockhaus');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '1.00');
        $propbag->add('event_hooks',    array(
            'frontend_comment' => true,
            'frontend_saveComment' => true,
            'css'				=> true,
        ));
        $propbag->add('groups', array('ANTISPAM'));
        
        $configuration = array('header_desc','do_honeypot', 'spamlogtype', 'spamlogfile', );
        if (!class_exists('serendipity_event_spamblock')) { // Only do that, if spamblock is not installed.
            $configuration[] = 'required_fields';
        }
        $configuration[] = 'plugin_path';
        
        $propbag->add('configuration', $configuration );
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENT_SPAMBLOCK_BEE_TITLE;
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;
        
        switch($name) {
            case 'header_desc': 
                $propbag->add('type', 'content');
                $propbag->add('default',   PLUGIN_EVENT_SPAMBLOCK_BEE_EXTRA_DESC);
                break;
                break;
            case 'do_honeypot':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT_DESC);
                $propbag->add('default',     true);
                break;
            case 'spamlogtype':
                $logtypevalues = array (
                    'none' => PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_NONE,
                    'file' => PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_FILE,
                    'db' => PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DATABASE,
                );
                $propbag->add('type',       'select');
                $propbag->add('name',        PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DESC);
                $propbag->add('select_values', $logtypevalues);
                $propbag->add('default',     'none');
                break;
            case 'spamlogfile':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE_DESC);
                $propbag->add('default', $serendipity['serendipityPath'] . 'spamblock.log');
                break;
            case 'required_fields':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS_DESC);
                $propbag->add('default', '');
                break;
                
            case 'plugin_path':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_BEE_PATH);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BEE_PATH_DESC);
                $propbag->add('default', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_spamblock_bee/');
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
                case 'frontend_saveComment':
                    $result = $this->checkComment($eventData, $addData);
                    return $result;
                    break;
                case 'frontend_comment':
                    $this->printCommentEditExtras($eventData, $addData);
                    break;
                case 'css':
                    $this->printCss($eventData, $addData);
                    break;
                default:
                    return false;
                    break;
            }
            return true;
        } else {
            return false;
        }
    }
    function install() {
    }
    function cleanup() {
    }
    
    function checkComment(&$eventData, &$addData) {
        global $serendipity;
        
        if ("NORMAL" == $addData['type']) { // only supported for normal comments
            // Check for honeypot:
            $do_honepot = serendipity_db_bool($this->get_config('do_honeypot',true));
            if ($do_honepot && (!empty($serendipity['POST']['phone']) || $serendipity['POST']['phone']=='0') ) {
                $logfile = $this->get_config('spamlogfile', $serendipity['serendipityPath'] . 'spamblock.log');
                $this->spamlog($logfile, $eventData['id'], 'REJECTED', $serendipity['POST']['phone'], $addData);
                $eventData = array('allow_comments' => false);
                return false;
            }
            
            // Check, if all required fields are set, but only if spamblock is not installed.
            if (!class_exists('serendipity_event_spamblock')) {
                $required_fields = $this->get_config('required_fields', '');
                if (!empty($required_fields)) {
                    $required_field_list = explode(',', $required_fields);
                    foreach($required_field_list as $required_field) {
                        $required_field = trim($required_field);
                        if (empty($addData[$required_field])) {
                            $this->log($logfile, $eventData['id'], 'REJECTED', PLUGIN_EVENT_SPAMBLOCK_BEE_REASON_REQUIRED_FIELD, $addData);
                            $eventData = array('allow_comments' => false);
                            $serendipity['messagestack']['comments'][] = sprintf(PLUGIN_EVENT_SPAMBLOCK_BEE_REASON_REQUIRED_FIELD, $required_field);
                            return false;
                        }
                    }
                }
            }
        }            
        return true;
    }

    function printCommentEditExtras(&$eventData, &$addData) {
        global $serendipity;

        // Don't put extras on admin menu. They are not working there:
        if (isset($eventData['GET']['action']) && $eventData['GET']['action']=='admin') return;
        
        // Honeypot
        if (serendipity_db_bool($this->get_config('do_honeypot',true))) {
            echo '<div id="serendipity_comment_phone" class="serendipity_commentDirection comment_phone_input" >' . "\n";
            echo '<label for="serendipity_commentform_phone">Phone*</label>' . "\n";
            echo '<input class="comment_phone_input" type="text" id="serendipity_commentform_phone" name="serendipity[phone]" value="" placeholder="You don\'t want to give me your number, do you? ;)"/>' . "\n";
            echo "</div>\n";
        }
    }
    
    function printCss(&$eventData, &$addData) {
        global $serendipity;

        if (!(strpos($eventData, '.comment_phone_input'))) {
?>
.comment_phone_input {
	max-width: 100%;
}
/*
	display:none;
	visibility:hidden;
*/
<?php
        }
    }
    
    function hashString( $what ) {
        $installation_secret = $this->get_config('installation_secret');
        if (empty($installation_secret)) {
            $installation_secret = md5(date('l jS \of F Y h:i:s A'));
            $this->set_config('installation_secret', $installation_secret);
        }
        return md5($installation_secret . ':' . $what);
    }
    
    function log($message){
        if (!PLUGIN_EVENT_SPAMBLOCK_BEE_DEBUG) return;
        $fp = fopen(dirname(__FILE__) . '/spambee.log','a');
        fwrite($fp, date('Y.m.d H:i:s') . " - " . $message . "\n");
        fflush($fp);
        fclose($fp);
    }
    
	function spamlog($logfile, $id, $switch, $reason, $addData) {
        global $serendipity;
        $method = $this->get_config('spamlogtype', 'none');
        if (empty($logfile)) $logfile = dirname(__FILE__) . '/spambee.log';
        
        switch($method) {
            case 'file':
            	$reason = "Honeypot=$reason";
                if (empty($logfile)) {
                    return;
                }
				if (strpos($logfile, '%') !== false) {
					$logfile = strftime($logfile);
				}

                $fp = @fopen($logfile, 'a+');
                if (!is_resource($fp)) {
                    return;
                }
                fwrite($fp, sprintf(
                    '[%s] - [%s: %s] - [#%s, Name "%s", E-Mail "%s", URL "%s", User-Agent "%s", IP %s] - [%s]' . "\n",
                    date('Y-m-d H:i:s', serendipity_serverOffsetHour()),
                    $switch,
                    $reason,
                    $id,
                    str_replace("\n", ' ', $addData['name']),
                    str_replace("\n", ' ', $addData['email']),
                    str_replace("\n", ' ', $addData['url']),
                    str_replace("\n", ' ', $_SERVER['HTTP_USER_AGENT']),
                    $_SERVER['REMOTE_ADDR'],
                    str_replace("\n", ' ', $addData['comment'])
                ));

                fclose($fp);
                break;

            case 'none':
                return;
                break;

            case 'db':
            default:
                $reason = "SpamBee Honeypot: " . serendipity_db_escape_string($reason);
                $q = sprintf("INSERT INTO {$serendipity['dbPrefix']}spamblocklog
                                          (timestamp, type, reason, entry_id, author, email, url,  useragent, ip,   referer, body)
                                   VALUES (%d,        '%s',  '%s',  '%s',     '%s',   '%s',  '%s', '%s',      '%s', '%s',    '%s')",

                           serendipity_serverOffsetHour(),
                           serendipity_db_escape_string($switch),
                           serendipity_db_escape_string($reason),
                           serendipity_db_escape_string($id),
                           serendipity_db_escape_string($addData['name']),
                           serendipity_db_escape_string($addData['email']),
                           serendipity_db_escape_string($addData['url']),
                           substr(serendipity_db_escape_string($_SERVER['HTTP_USER_AGENT']), 0, 255),
                           serendipity_db_escape_string($_SERVER['REMOTE_ADDR']),
                           substr(serendipity_db_escape_string(isset($_SESSION['HTTP_REFERER']) ? $_SESSION['HTTP_REFERER'] : $_SERVER['HTTP_REFERER']), 0, 255),
                           serendipity_db_escape_string($addData['comment'])
                );

                serendipity_db_schema_import($q);
                break;
        }
    }    
}
