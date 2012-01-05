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

class serendipity_event_commentspice extends serendipity_event
{
    var $title = PLUGIN_EVENT_COMMENTSPICE_TITLE;
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_COMMENTSPICE_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_COMMENTSPICE_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Grischa Brockhaus');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '0.1');
        $propbag->add('event_hooks',    array(
            'frontend_comment' => true,
            'external_plugin'  => true,
        ));
        $propbag->add('groups', array('FRONTEND_VIEWS'));
        $propbag->add('configuration', array('twitterinput'));
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENT_EMOTICONCHOOSER_TITLE;
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'twitterinput':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT);
                $propbag->add('description', '');
                $propbag->add('default',     true);
                return true;
                break;
        }
        return false;
    }
    
    function event_hook($event, &$bag, &$eventData) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {
                case 'external_plugin':
                    switch($eventData) {
                        case 'spicetwitter.png':
                            header('Content-Type: image/png');
                            echo file_get_contents(dirname(__FILE__). '/img/twitter.png');
                            break;
                    }
                    return true;
                    break;
                case 'frontend_comment':
                    if (!serendipity_db_bool($this->get_config('twitterinput', true))) {
                        break;
                    }
                    echo '<div id="serendipity_commentspice_twitter">';
                    echo '<input type="text" id="serendipity_commentform_twitter" name="serendipity[twitter]" placeholder="your twittername" />';
                    echo '&nbsp;<label for="serendipity_commentform_twitter"><img src="' . $serendipity['baseURL'] . 'index.php?/plugin/spicetwitter.png" alt="Twitter"></label>';
                    echo '</div>';
                    echo '<br/><div  id="serendipity_commentspice_twitter_desc" class="serendipity_commentDirection serendipity_comment_spice">';
                    echo 'If you enter your <b>twitter name</b> here, your timeline will get linked to your comment. (<i>experimental comment spice</i>)';
                    echo '</div>';
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