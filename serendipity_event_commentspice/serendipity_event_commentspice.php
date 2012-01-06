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
            'frontend_display' => true,
            'frontend_saveComment_finish' => true,
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
    
    function event_hook($event, &$bag, &$eventData, &$addData) {
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
                        case 'spicetwittersmall.png':
                            header('Content-Type: image/png');
                            echo file_get_contents(dirname(__FILE__). '/img/twitter_small.png');
                            break;
                    }
                    return true;
                    break;
                case 'frontend_saveComment_finish' :
                    // Remember twitter name value into cookie, if user ordered to, else clear cookie
                    if (isset($serendipity['POST']['remember'])) {
                        serendipity_rememberCommentDetails(array ('twitter' => $serendipity['POST']['twitter']));
                    }
                    else {
                        serendipity_forgetCommentDetails(array('twitter'));
                    }
                    return true;
                    break;
                case 'frontend_display':        
                    $this->printTwitterLink($eventData, $addData);

                    return true;
                    break;
                case 'frontend_comment':
                    $this->printTwitterInput($eventData, $addData);
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
    function printTwitterLink(&$eventData, &$addData) {
        global $serendipity;
        
        if (!isset($eventData['comment']) || !serendipity_db_bool($this->get_config('twitterinput', true))) {
            return true;                            
        }
        // Called from sidbar:
        if ($addData['from'] == 'serendipity_plugin_comments:generate_content') {
            return true;
        }
        
        if (isset($serendipity['COOKIE']['twitter'])) {
            $twittername = $serendipity['COOKIE']['twitter'];
            $eventData['comment'] = '<a href="https://twitter.com/#!/' . $twittername . '" class="commentspice_twitterlink" target="_blank"><img src="' . $serendipity['baseURL'] . 'index.php?/plugin/spicetwittersmall.png" alt="Read on twitter: "> ' . $twittername . '</a><br/>' . $eventData['comment'];
        }
        
    }
    function printTwitterInput(&$eventData, &$addData) {
        global $serendipity;
        
        if (!serendipity_db_bool($this->get_config('twitterinput', true))) {
            return;
        }
        if (isset($serendipity['COOKIE']['twitter'])) $twittername = $serendipity['COOKIE']['twitter'];
        else  $twittername = '';
        echo '<div id="serendipity_commentspice_twitter">';
        echo '<input type="text" id="serendipity_commentform_twitter" name="serendipity[twitter]" placeholder="your twittername" value="' . $twittername . '"/>';
        echo '&nbsp;<label for="serendipity_commentform_twitter"><img src="' . $serendipity['baseURL'] . 'index.php?/plugin/spicetwitter.png" alt="Twitter"></label>';
        echo '</div>';
        echo '<br/><div  id="serendipity_commentspice_twitter_desc" class="serendipity_commentDirection serendipity_comment_spice">';
        echo 'If you enter your <b>twitter name</b>, your timeline will get linked to your comment. (<i>comment spice experimental</i>)';
        echo '</div>';
    }
}