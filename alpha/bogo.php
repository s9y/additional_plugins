<?php
class serendipity_event_spamblock_bogo extends serendipity_event {
    function introspect(&$propbag) {
        global $serendipity;

        $this->title = 'Bogobogo';

        $propbag->add('name',          $this->title);
        $propbag->add('version',       '0.1');
        $propbag->add('event_hooks',    array('frontend_saveComment' => true));
        $propbag->add('groups', array('ANTISPAM'));
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function bogo(&$comment) {
        $f = '/tmp/bogo.log';
        $fp = fopen($f, 'w');
        flock($fp, LOCK_EX);
        fwrite($fp, $comment['name'] . "\n" . $comment['url'] . "\n" . $comment['comment'] . "\n");
        fclose($fp);
        $return = `bogofilter -v -H < $f`;
        if (preg_match('@X-Bogosity: Spam@imsU', $return)) {
            return true;
        }
        
        return false;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_saveComment':
                    if (!is_array($eventData) || serendipity_db_bool($eventData['allow_comments'])) {
                        $serendipity['csuccess'] = 'true';
                        if ($this->bogo($addData)) {
                            $eventData = array('allow_comments' => false);
                            $serendipity['messagestack']['comments'][] = PLUGIN_EVENT_SPAMBLOCK_ERROR_RBL . ' ('.implode(', ', $dnsbl->getTxt($remoteIP)).')';
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
