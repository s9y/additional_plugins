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
            'frontend_saveComment' => true,
        	'frontend_saveComment_finish' => true,
            'backend_deletecomment' => true,
            'external_plugin'  => true,
        ));
        $propbag->add('groups', array('FRONTEND_VIEWS'));
        $propbag->add('configuration', array('twitterinput','twitterinput_nofollow', 'announcerss', 'announcerss_nofollow','plugin_path'));
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
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_DESC);
                $propbag->add('default',     true);
                return true;
                break;
            case 'twitterinput_nofollow':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_NOFOLLOW);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_NOFOLLOW_DESC);
                $propbag->add('default',     true);
                return true;
                break;
            case 'announcerss':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_DESC);
                $propbag->add('default',     false);
                return true;
                break;
            case 'announcerss_nofollow':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_NOFOLLOW);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_NOFOLLOW_DESC);
                $propbag->add('default',     false);
                return true;
                break;
            case 'announcerssmax':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT_DESC);
                $propbag->add('default',     false);
                return true;
                
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
                case 'frontend_saveComment':
                    return $this->checkComment($eventData, $addData);
                    break;
                case 'frontend_saveComment_finish' :
                    $this->commentSaved($eventData, $addData);
                    break;
                //case 'frontend_header':
                case 'frontend_footer':
                    $this->printHeader();
                    break;
                case 'frontend_display':        
                    $this->spiceComment($eventData, $addData);
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
            $promo_name = null;
            $promo_url = null;
            if (isset($serendipity['POST']['promorss']) && !empty($serendipity['POST']['promorss'])) {
                $promorss = $serendipity['POST']['promorss'];
                $parts = explode("\n", $promorss);
                $promo_hash = trim($parts[0]);
                $promo_name = trim($parts[1]);
                $promo_url = trim($parts[2]);
                if (!$this->hashString($promo_name.$promo_url) == $promo_hash) return false;
                
            }
            $result = DbSpice::saveCommentSpice($addData['comment_cid'], $serendipity['POST']['twitter'], $promo_name, $promo_url);
            $this->rememberInputs();
        }
        return true;
    }
    function rememberInputs() {
        global $serendipity;
        // Remember twitter name value into cookie, if user ordered to, else clear cookie
        if (isset($serendipity['POST']['remember'])) {
            serendipity_rememberCommentDetails(array ('twitter' => $serendipity['POST']['twitter']));
        }
        else {
            serendipity_forgetCommentDetails(array('twitter'));
        }
    }
    function checkComment(&$eventData, &$addData) {
        global $serendipity;
        
        if ("NORMAL" == $addData['type']) { // only supported for normal comments
            $this->rememberInputs();
            
            $promo_name = null;
            $promo_url = null;
            if (isset($serendipity['POST']['promorss']) && !empty($serendipity['POST']['promorss'])) {
                $promorss = $serendipity['POST']['promorss'];
                $parts = explode("\n", $promorss);
                $promo_hash = trim($parts[0]);
                $promo_name = trim($parts[1]);
                $promo_url = trim($parts[2]);
                if ($this->hashString($promo_name.$promo_url) != $promo_hash) {
                    $eventData = array ('allow_comments' => false);
                    $serendipity ['messagestack'] ['comments'] [] = PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_CORRUPTED;
                    return false;
                }
            }
        }
        return true;
    }
    function readRss() {
        global $serendipity;
        
        $comment_url = $_REQUEST ['coment_url'];
        $this->log("readRss for $comment_url");
        if (empty($comment_url)) return;

        require_once (defined('S9Y_PEAR_PATH') ? S9Y_PEAR_PATH : S9Y_INCLUDE_PATH . 'bundled-libs/') . 'HTTP/Request.php';
        $req = new HTTP_Request($comment_url, array('allowRedirects' => true, 'maxRedirects' => 3));
        if (PEAR::isError($req->sendRequest()) || $req->getResponseCode() != '200') {
            $this->log("Error reading $comment_url");
            return;
        } 
        # Fetch html content:
        $data = $req->getResponseBody();
        $this->log("Have data!");
        
        // Check if page defines a RSS link
        $matches = array();
        if (preg_match('@<link[^>]*? type="application/rss\+xml"[^>]*? href="([^"]*?)"@Usi', $data, $matches)) {
            $this->log("rss link found, matches: " . print_r($matches[1],TRUE));
            $rssUrl = $matches[1];
        }
        else {
            $this->log("rss link not found");
            return;
            
        }

        // Now fetch the RSS feed:
        require_once (defined('S9Y_PEAR_PATH') ? S9Y_PEAR_PATH : S9Y_INCLUDE_PATH . 'bundled-libs/') . 'Onyx/RSS.php';
                        # test multiple likely charsets
        $charsets = array( "utf-8", "ISO-8859-1");
        $retry = false;
        foreach ($charsets as $ch) {
            if ($retry) $this->log("Retrying charset $ch");
            $retry = true;
            $rss = new Onyx_RSS($ch);
            # does it parse? if so, all is fine...
            if ($rss->parse($rssUrl))
            break;
        }
        
        $articles = array();
        $article = array();
        $article['title'] = PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_CHOOSE;
        $article['url'] = "";
        $articles[] = $article;
        
        $itemCount = 0;
        $maxItems = 3;
        // Iterate the items
        while ($item = $rss->getNextItem()) {
            if ($itemCount>=$maxItems) break;
            $article = array();
            $article['title'] = $item['title'];
            $hash = $this->hashString($item['title'].$item['link']);
            $article['url'] = $hash . "\n" . $item['title'] . "\n" . $item['link'];
            $articles[] = $article;
            $itemCount++;
        }
        if ($itemCount==0) return;
        
        echo json_encode($articles);
    }
    
    function commentDeleted($eventData, $addData) {
        $this->log('commentDeleted');
        $this->log(print_r($eventData, true));
        $this->log(print_r($addData, true));
        $reult = DbSpice::deleteCommentSpice($addData['cid']);
        $this->log("delete result: $reult");
    }
    
    function spiceComment(&$eventData, &$addData) {
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
        $eventData['comment'] = '<a href="https://twitter.com/#!/' . $twittername . '" class="commentspice_twitterlink" target="_blank"' . ($this->get_config('twitterinput_nofollow', true)?' rel="nofollow"':'') . '><img src="' . $serendipity['baseURL'] . 'index.php?/plugin/spicetwittersmall.png" alt="' . PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER . ': "> ' . $twittername . '</a><br/>' . $eventData['comment'];
        if ($spice['promo_name'] && $spice['promo_url']) {
            $eventData['comment'] .= "<p class=\"spice_resentpost\" style=\"padding-top: 1em; margin-bottom: 0em\">" . sprintf(PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_RESCENT, $eventData['author']) . ": <a href=\"{$spice['promo_url']}\" target=\"_blank\"" . ($this->get_config('announcerss_nofollow', false)?' rel="nofollow"':'') . ">{$spice['promo_name']}</a></p>";
        }
        
    }
    function printCommentEditExtras(&$eventData, &$addData) {
        global $serendipity;
        
        $tag_comment_spice = '<br/>(<i>' . PLUGIN_EVENT_COMMENTSPICE_EXPERIMENTAL . '</i>)';
        if (serendipity_db_bool($this->get_config('twitterinput', true))) {
            if (isset($serendipity['COOKIE']['twitter'])) $twittername = $serendipity['COOKIE']['twitter'];
            else  $twittername = '';
            echo '<div id="serendipity_commentspice_twitter">';
            echo '<input style="background: url(' . $serendipity['baseURL'] . 'index.php?/plugin/spicetwittersmall.png) left no-repeat; padding-left: 1.5em; max-width: 18.5em" type="text" id="serendipity_commentform_twitter" name="serendipity[twitter]" placeholder="your twittername" value="' . $twittername . '"/>';
            echo '</div>';
        }
        if (serendipity_db_bool($this->get_config('announcerss', false))) {
            echo '<div id="serendipity_commentspice_rss" style="display:none;">';
            echo '<select id="serendipity_commentform_rss" name="serendipity[promorss]"></select>'; //  style="max-width: 20em; width: 100%"
            echo '</div>';
        }
        if (serendipity_db_bool($this->get_config('twitterinput', true))) {
            echo '<div  id="serendipity_commentspice_twitter_desc" class="serendipity_commentDirection serendipity_comment_spice">';
            echo PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_FOOTER . $tag_comment_spice;
            echo '</div>';
        }
        if (serendipity_db_bool($this->get_config('announcerss', false))) {
            echo '<div  id="serendipity_commentspice_rss_desc" class="serendipity_commentDirection serendipity_comment_spice">';
            echo PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_FOOTER .$tag_comment_spice;
            echo '</div>';
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
        if (!PLUGIN_EVENT_COMMENTSPICE_DEBUG) return;
        $fp = fopen(dirname(__FILE__) . '/spice.log','a');
        fwrite($fp, date('Y.m.d H:i:s') . " - " . $message . "\n");
        fflush($fp);
        fclose($fp);
    }
    
}