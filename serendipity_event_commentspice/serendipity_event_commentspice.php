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
require_once dirname(__FILE__) . '/DbSpice.class.php';
require_once dirname(__FILE__) . '/json/json.php4.include.php';

@define('PLUGIN_EVENT_COMMENTSPICE_DEBUG', TRUE);

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
//            'frontend_header' => true,
            'frontend_footer' => true,
            'frontend_comment' => true,
            'frontend_display' => true,
            'frontend_saveComment_finish' => true,
            'backend_deletecomment' => true,
            'external_plugin'  => true,
        ));
        $propbag->add('groups', array('FRONTEND_VIEWS'));
        $propbag->add('configuration', array('twitterinput','announcerss','plugin_path'));
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENT_EMOTICONCHOOSER_TITLE;
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;
        switch($name) {
            case 'twitterinput':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT);
                $propbag->add('description', '');
                $propbag->add('default',     true);
                return true;
                break;
            case 'announcerss':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS);
                $propbag->add('description', '');
                $propbag->add('default',     false);
                return true;
                break;
                
            case 'plugin_path':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_COMMENTSPICE_PATH);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_PATH_DESC);
                $propbag->add('default', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_commentspice/');
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
                        case 'commentspicefrss':
                            if (!serendipity_db_bool($this->get_config('announcerss', false))) break;
                            $this->readRss();
                            break;
                    }
                    break;
                case 'frontend_saveComment_finish' :
                    $this->commentSaved($eventData, $addData);
                    break;
                //case 'frontend_header':
                case 'frontend_footer':
                    $this->printHeader();
                    break;
                case 'frontend_display':        
                    $this->printTwitterLink($eventData, $addData);
                    break;
                case 'frontend_comment':
                    $this->printCommentEditExtras($eventData, $addData);
                    break;
                case 'backend_deletecomment' :
                    $this->commentDeleted($eventData, $addData);
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
        DbSpice::install($this);
    }
    function cleanup() {
        DbSpice::install($this);
    }
    function printHeader() {
        global $serendipity;
        
        if (serendipity_db_bool($this->get_config('announcerss',false)))
        {

            $path = $this->path = $this->get_config('plugin_path', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_commentspice/');
    
            echo "
<script>
    var comentspice_fetchrss = '{$serendipity['baseURL']}index.php?/plugin/commentspicefrss';
    var s9yCharset = '".LANG_CHARSET."';
    </script>
<script type=\"text/javascript\" src=\"{$path}frontend_commentspice.js\"></script>
";
        }
    }
    function commentSaved($eventData, $addData) {
        global $serendipity;
        
        if ("NORMAL" == $addData['type']) { // only supported for normal comments
            $result = DbSpice::saveCommentSpice($addData['comment_cid'], $serendipity['POST']['twitter']);
            // Remember twitter name value into cookie, if user ordered to, else clear cookie
            if (isset($serendipity['POST']['remember'])) {
                serendipity_rememberCommentDetails(array ('twitter' => $serendipity['POST']['twitter']));
            }
            else {
                serendipity_forgetCommentDetails(array('twitter'));
            }
        }
    }
    function readRss() {
        $comment_url = $_REQUEST ['coment_url'];
        //echo "Angekommen im Plugin. url=$comment_url";
        $articles = array();
        for ($i = 1; $i <= 3; $i++) {
            $article = array();
            $article['title'] = "Test $i";
            $article['url'] = "$comment_url/$i";
            $articles[] = $article;
        }
        echo json_encode($articles);
    }
    
    function commentDeleted($eventData, $addData) {
        $this->log('commentDeleted');
        $this->log(print_r($eventData, true));
        $this->log(print_r($addData, true));
        $reult = DbSpice::deleteCommentSpice($addData['cid']);
        $this->log("delete result: $reult");
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
        $spice = DbSpice::loadCommentSpice($eventData['id']);
        if (!is_array($spice)) {
            return true;
        }
        $twittername = $spice['twittername'];
        $eventData['comment'] = '<a href="https://twitter.com/#!/' . $twittername . '" class="commentspice_twitterlink" target="_blank"><img src="' . $serendipity['baseURL'] . 'index.php?/plugin/spicetwittersmall.png" alt="Read on twitter: "> ' . $twittername . '</a><br/>' . $eventData['comment'];
        
    }
    function printCommentEditExtras(&$eventData, &$addData) {
        global $serendipity;
        
        $tag_comment_spice = '<br/>(<i>comment spice experimental</i>)';
        if (serendipity_db_bool($this->get_config('twitterinput', true))) {
            if (isset($serendipity['COOKIE']['twitter'])) $twittername = $serendipity['COOKIE']['twitter'];
            else  $twittername = '';
            echo '<div id="serendipity_commentspice_twitter">';
            echo '<input style="background: url(' . $serendipity['baseURL'] . 'index.php?/plugin/spicetwittersmall.png) left no-repeat; padding-left: 1.5em; max-width: 18.5em" type="text" id="serendipity_commentform_twitter" name="serendipity[twitter]" placeholder="your twittername" value="' . $twittername . '"/>';
            echo '</div>';
        }
        if (serendipity_db_bool($this->get_config('announcerss', false))) {
            echo '<div id="serendipity_commentspice_rss" style="display:none;">';
            echo '<label for="serendipity_commentform_rss">Promote one of your rescent articles: </label><br/><select id="serendipity_commentform_rss" name="serendipity[rss]"></select>';
            echo '</div>';
        }
        if (serendipity_db_bool($this->get_config('twitterinput', true))) {
            echo '<div  id="serendipity_commentspice_twitter_desc" class="serendipity_commentDirection serendipity_comment_spice">';
            echo 'If you enter your <b>twitter name</b>, your timeline will get linked to your comment.' . $tag_comment_spice;
            echo '</div>';
        }
        if (serendipity_db_bool($this->get_config('announcerss', true))) {
            echo '<div  id="serendipity_commentspice_rss_desc" class="serendipity_commentDirection serendipity_comment_spice">';
            echo '<b>Promote one of your rescent articles</b><br/>This blog allows you to announce one of your recent blog articles with your comment. Please enter your the corresponding URL as homepage and a selection box will pop up letting you choose an article.' .$tag_comment_spice;
            echo '</div>';
        }
    }
    
    function log($message){
        if (!PLUGIN_EVENT_COMMENTSPICE_DEBUG) return;
        $fp = fopen(dirname(__FILE__) . '/spice.log','a');
        fwrite($fp, date('Y.m.d H:i:s') . " - " . $message . "\n");
        fflush($fp);
        fclose($fp);
    }
    
}