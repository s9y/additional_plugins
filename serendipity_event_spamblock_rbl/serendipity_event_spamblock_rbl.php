<?php # 

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


@serendipity_plugin_api::load_language(dirname(__FILE__));

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
        $propbag->add('version',       '1.5.2');
        $propbag->add('event_hooks',    array(
            'frontend_saveComment' => true
        ));
        $propbag->add('configuration', array(
            'rbllist',
            'httpBL_key'));
        $propbag->add('groups', array('ANTISPAM'));

        $propbag->add('legal',    array(
            'services' => array(
                'httpbl.org' => array(
                    'url'  => '#',
                    'desc' => 'Checks submitted comment URLs through the HTTPBL'
                ),
            ),
            'frontend' => array(
                'Comment URLs are checked by the HTTPBL, entered URLs and the visitors IP are passed through that service',
            ),
            'backend' => array(
            ),
            'cookies' => array(
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => true,
            'transmits_user_input'  => true
        ));

    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {

            case 'rbllist':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_RBLLIST);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_RBLLIST_DESC);
                // old - as not good for comment spam (indigoxela)
                // $propbag->add('default', 'sbl-xbl.spamhaus.org, bl.spamcop.net');
                $propbag->add('default', 'list.blogspambl.com');
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

                        if (!isset($serendipity['csuccess'])) {
                            $serendipity['csuccess'] = 'true';
                        }

                        // Check for IP listed in RBL
                        require_once (defined('S9Y_PEAR_PATH') ? S9Y_PEAR_PATH : 'bundled-libs/') . 'Net/DNSBL.php';
                        $dnsbl = new Net_DNSBL();
                        $remoteIP = $_SERVER['REMOTE_ADDR'];

                        $dnsbl->setBlacklists(explode(',', $this->get_config('rbllist')));
                        if ($dnsbl->isListed($remoteIP)) {
                            $eventData = array('allow_comments' => false);
                            // old - but missing $dnsbl->getTxt() function in delivered old DNSBL.php
                            //$serendipity['messagestack']['comments'][] = PLUGIN_EVENT_SPAMBLOCK_ERROR_RBL . ' ('.implode(', ', $dnsbl->getTxt($remoteIP)).')';
                            $serendipity['messagestack']['comments'][] = PLUGIN_EVENT_SPAMBLOCK_ERROR_RBL . ' ('.$remoteIP.')';
                            return false;
                        }

                        // Check for IP listed in http:BL
                        require_once ('httpbl.php');
                        $honeypot_apikey = $this->get_config('httpBL_key');

                        if (!empty($honeypot_apikey) ) {

                            $h=new http_bl($honeypot_apikey);

                            // known spammer
// DEBUG                    $remoteIP = '206.51.226.106';
                            // A quick tip for testing: change $remoteIP = '$_SERVER['REMOTE_ADDR']; on line 89 to e.g.
                            // $remoteIP = '109.200.6.202'; // Comments should get rejected as this ip is on both blacklists right now.
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
