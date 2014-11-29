<?php # 

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_unstrip_tags extends serendipity_event
{
    var $title = PLUGIN_EVENT_UNSTRIP_NAME;
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_UNSTRIP_NAME);
        $propbag->add('description',   PLUGIN_EVENT_UNSTRIP_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('version',       '1.03.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('MARKUP'));
        $propbag->add('event_hooks',   array('frontend_display' => true, 'frontend_comment' => true));
    }

    function generate_content(&$title) {
        $title = $this->title;
    }
    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_display':

                    if (isset($eventData ['comment']) && !empty($eventData['body'])) {
                        $eventData['comment'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($eventData['body']) : htmlspecialchars($eventData['body'], ENT_COMPAT, LANG_CHARSET));
                    }
                    return true;
                    break;

                case 'frontend_comment':
                    echo '<div class="serendipity_commentDirection serendipity_comment_unstrip_tags">' . PLUGIN_EVENT_UNSTRIP_TRANSFORM . '</div>';
                    return true;
                    break;

                default:
                  return false;
            }
        } else {
            return false;
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>
