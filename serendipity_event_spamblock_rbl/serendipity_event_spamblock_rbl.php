<?php # $Id: serendipity_event_spamblock_rbl.php,v 1.10 2008/05/29 17:58:44 garvinhicking Exp $

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_spamblock_rbl extends serendipity_event
{
var $filter_defaults;

    function introspect(&$propbag)
    {
        global $serendipity;

        $this->title = PLUGIN_EVENT_SPAMBLOCK_RBL_TITLE;

        $propbag->add('name',          PLUGIN_EVENT_SPAMBLOCK_RBL_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_SPAMBLOCK_RBL_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Sebastian Nohn');
        $propbag->add('requirements',  array(
            'serendipity' => '1.2',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '1.3');
        $propbag->add('event_hooks',    array(
            'frontend_saveComment' => true
        ));
        $propbag->add('configuration', array(
			'rbllist',
            'httpBL_key'));
        $propbag->add('groups', array('ANTISPAM'));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {

            case 'rbllist':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_RBLLIST);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_RBLLIST_DESC);
                $propbag->add('default', 'sbl-xbl.spamhaus.org, bl.spamcop.net');
                break;
            case 'httpBL_key':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_HONEYPOT_KEY);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_HONEYPOT_KEY_DESC);
                $propbag->add('default', '');
                break;
			default:
                return false;
        }

        return true;
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {
                case 'frontend_saveComment':
                    if (!is_array($eventData) || serendipity_db_bool($eventData['allow_comments'])) {

                        $serendipity['csuccess'] = 'true';

	                // Check for IP listed in RBL
					require_once (defined('S9Y_PEAR_PATH') ? S9Y_PEAR_PATH : 'bundled-libs/') . 'Net/DNSBL.php';
					$dnsbl = new Net_DNSBL();
					$remoteIP = $_SERVER['REMOTE_ADDR'];

					$dnsbl->setBlacklists(explode(',', $this->get_config('rbllist')));
					if ($dnsbl->isListed($remoteIP)) {
					  $eventData = array('allow_comments' => false);
					  $serendipity['messagestack']['comments'][] = PLUGIN_EVENT_SPAMBLOCK_ERROR_RBL . ' ('.implode(', ', $dnsbl->getTxt($remoteIP)).')';
					  return false;
					}
					
					// Check for IP listed in http:BL
					require_once ('httpbl.php');
					$honeypot_apikey = $this->get_config('httpBL_key');

					if (!empty($honeypot_apikey) ) {
				
						$h=new http_bl($honeypot_apikey);
						
						// known spammer
// DEBUG					$remoteIP = '206.51.226.106';	
						$r=$h->query($remoteIP);
			
						if ($r==2) {
							$eventData = array('allow_comments' => false);
							$reason = PLUGIN_EVENT_SPAMBLOCK_REASON_HONEYPOT . $h->type_txt .' ['.$h->type_num .'] with a score of '. $h->score . ', last seen since '. $h->days . ' days';
							$serendipity['messagestack']['comments'][] = $reason;
						}
						return false;
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
?>
