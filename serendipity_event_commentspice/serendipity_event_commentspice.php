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

@define('PLUGIN_EVENT_COMMENTSPICE_DEBUG', FALSE);

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
        $propbag->add('version',       '1.0');
        $propbag->add('event_hooks',    array(
            'frontend_footer' => true,
            'frontend_comment' => true,
            'frontend_display' => true,
            'frontend_saveComment' => true,
        	'frontend_saveComment_finish' => true,
            'backend_deletecomment' => true,
            'external_plugin'  => true,
            'css'				=> true,
            'avatar_fetch_userinfos' => true,
        ));
        $propbag->add('groups', array('FRONTEND_VIEWS'));
        $config = array('title_twitter','twitterinput','twitterinput_nofollow',
        	'followme_widget', 'followme_widget_counter','followme_widget_dark','smartifytwitter',
        	'title_announcerss', 'announcerss', 'announcerssmax','announcersscachemin','announcerss_nofollow','smartifyannouncerss',
        	'title_general');
        if (!$serendipity['pingbackFetchPage'] && function_exists('fetchPingbackData')) {
            $config[] = 'fetchPingback';
        }
        $config[] = 'plugin_path';
        $propbag->add('configuration', $config );
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
                break;
            case 'twitterinput_nofollow':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_NOFOLLOW);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_NOFOLLOW_DESC);
                $propbag->add('default',     true);
                break;
            case 'followme_widget':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_DESC);
                $propbag->add('default', false);
                break;
            case 'followme_widget_counter':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_COUNT);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_COUNT_DESC);
                $propbag->add('default', false);
                break;
            case 'followme_widget_dark':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_DARK);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_DARK_DESC);
                $propbag->add('default', false);
                break;
            case 'announcerss':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_DESC);
                $propbag->add('default',     false);
                break;
            case 'announcerss_nofollow':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_NOFOLLOW);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_NOFOLLOW_DESC);
                $propbag->add('default',     false);
                break;
            case 'announcerssmax':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT_DESC);
                $propbag->add('default',     3);
                break;
            case 'announcersscachemin':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_CACHEMIN);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_CACHEMIN_DESC);
                $propbag->add('default',     90);
                break;
            case 'smartifytwitter':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_TWITTER);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_TWITTER_DESC);
                $propbag->add('default',     false);
                break;
            case 'smartifyannouncerss':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_RSS);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_RSS_DESC);
                $propbag->add('default',     false);
                break;
            case 'plugin_path':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_COMMENTSPICE_PATH);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_PATH_DESC);
                $propbag->add('default', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_commentspice/');
                break;
            case 'title_announcerss':
                $propbag->add('type', 'content');
                $propbag->add('default',   '<h3>' . PLUGIN_EVENT_COMMENTSPICE_CONFIG_ANNOUNC_RSS .'</h3>');
                break;
            case 'title_twitter':
                $propbag->add('type', 'content');
                $propbag->add('default',   '<h3>' . PLUGIN_EVENT_COMMENTSPICE_CONFIG_TWITTERNAME .'</h3>');
                break;
            case 'title_general':
                $propbag->add('type', 'content');
                $propbag->add('default',   '<h3>' . PLUGIN_EVENT_COMMENTSPICE_CONFIG_GENERAL .'</h3>');
                break;
            case 'fetchPingback':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_DESC);
                $propbag->add('default',     $serendipity['pingbackFetchPage']);
                return true;
                break;
            default:
                return false;
        }
        return true;
    }
    
    function event_hook($event, &$bag, &$eventData, &$addData) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {
                case 'external_plugin':
                    switch($eventData) {
                        case 'spiceicotwitter.png':
                            header('Content-Type: image/png');
                            echo file_get_contents(dirname(__FILE__). '/img/twitter_icon.png');
                            break;
                        case 'spiceicorss.png':
                            header('Content-Type: image/png');
                            echo file_get_contents(dirname(__FILE__). '/img/rss_icon.png');
                            break;
                        case 'commentspice.png':
                            header('Content-Type: image/png');
                            echo file_get_contents(dirname(__FILE__). '/img/commentspice.png');
                            break;
                        case 'commentspicefrss':
                            if (!serendipity_db_bool($this->get_config('announcerss', false))) break;
                            $this->readRss();
                            break;
                    }
                    break;
                case 'frontend_saveComment':
                    $result = $this->checkComment($eventData, $addData);
                    $this->log("after checkComment: " . print_r($eventData, true) . "\n" . print_r($addData,TRUE));
                    return $result;
                    break;
                case 'frontend_saveComment_finish' :
                    $this->commentSaved($eventData, $addData);
                    break;
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
                case 'css':
                    $this->writeCss($eventData, $addData);
                    break;
                case 'avatar_fetch_userinfos':
                    $this->log("caught avatar_fetch_userinfos");
                    $this->handleAvatar($eventData, $addData);
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
        $announcerssmax = $this->get_config('announcerssmax',3);
        if (!is_numeric($announcerssmax)) {
            $this->set_config('announcerssmax',3);
        }
        $announcersscachemin = $this->get_config('announcersscachemin',90);
        if (!is_numeric($announcersscachemin)) {
            $this->set_config('announcersscachemin',90);
        }
        // clear cache
        $cacheDir = dirname($this->cacheRssFilename("doesntmatter"));
        if (is_dir($cacheDir) && $handle = opendir($cacheDir)) {
            while (false !== ($file = readdir($handle))) {
                $filename = $cacheDir . '/' . $file;
                if (!is_dir($filename)) {
                    unlink($filename);
                }
            }
        }
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
        if (serendipity_db_bool($this->get_config('followme_widget', false))) {
            echo '<script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>' . "\n";
        }
    }
    function commentSaved($eventData, $addData) {
        global $serendipity;
        
        $this->log("commentSaved: " . print_r($eventData, true) . "\n" . print_r($addData,TRUE));
        
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
        elseif ("PINGBACK" == $addData['type']) {
            if (!$serendipity['pingbackFetchPage']) { // Only fetch if S9Y does not already.
                if (serendipity_db_bool($this->get_config('fetchPingback', false))) {
                    $serendipity['pingbackFetchPage'] = true;
                    $serendipity['pingbackFetchPageMaxLength'] = 200;
                    fetchPingbackData($addData); // method declared in functions_trackbacks.php
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

        // First try to read from cache
        $result = $this->cacheReadRss($comment_url);
        if (empty($result)) {
            $result = $this->readRssRemote($comment_url);
            $this->log("Fetched array: " . print_r($result, true));
            if (!empty($result) && $result['articles']) $this->cacheWriteRss($comment_url, $result);
        }
        if (empty($result) || !$result['articles'] || count($result['articles'])==0) return;
        
        echo json_encode($result);
    }
    function readRssRemote($url) {
        $this->log("Fetchig remote rss from: " . $url);
        
        require_once (defined('S9Y_PEAR_PATH') ? S9Y_PEAR_PATH : S9Y_INCLUDE_PATH . 'bundled-libs/') . 'HTTP/Request.php';
        $req = new HTTP_Request($url, array('allowRedirects' => true, 'maxRedirects' => 3));
        if (PEAR::isError($req->sendRequest()) || $req->getResponseCode() != '200') {
            $this->log("Error reading $url");
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
        $maxItems = $announcerssmax = $this->get_config('announcerssmax',3);
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
        $result['articles'] = $articles;
        $result['url'] = $url;
        return $result;
    }
    function cacheReadRss($url) {
        $filename = $this->cacheRssFilename($url);
        $cachemin = $this->get_config('announcersscachemin',90);
        if ($cachemin == 0) return null;
        $this->log("Reading " . $filename);
        if (file_exists($filename) && (time() - filemtime($filename))< $cachemin * 60) {
            $fp = fopen($filename, 'rb');
            $result = unserialize(fread($fp, filesize($filename)));
            fclose($fp);
            return $result;
        }
        return null;
    }
    function cacheWriteRss($url, $array_struct) {
        $cachemin = $this->get_config('announcersscachemin',90);
        if ($cachemin == 0) return; // cache switched off
        $filename = $this->cacheRssFilename($url);
        $cache_dir= dirname($filename);
        @mkdir($cache_dir);
        $this->log("Writing " . $filename);
        $fp = fopen($filename, 'wb');
        fwrite($fp,serialize($array_struct));
        fclose($fp);
    }
    function cacheRssFilename($url) {
        global $serendipity;
        $url_md5=md5($url);
        return $serendipity['serendipityPath'] . '/' . PATH_SMARTY_COMPILE . '/commentspice/rss_' . $url_md5;
    }
    
    function commentDeleted($eventData, $addData) {
        $result = DbSpice::deleteCommentSpice($addData['cid']);
    }
    
    function spiceComment(&$eventData, &$addData) {
        global $serendipity;
        
        if (!isset($eventData['comment'])) {
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
        if (serendipity_db_bool($this->get_config('twitterinput', true))) {
            $smartify = serendipity_db_bool($this->get_config('smartifytwitter', false));
            $twittername = $spice['twittername'];
            $timeline_url = 'https://twitter.com/#!/' . $twittername;
            $timeline_url_nofollow = serendipity_db_bool($this->get_config('twitterinput_nofollow', true));
            $twitter_icon_html = '<img src="' . $serendipity['baseURL'] . 'index.php?/plugin/spiceicotwitter.png" alt="' . PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER . ': ">';
            $followme_widget = $this->createFollowMeWidget($twittername, $timeline_url_nofollow);
            if ($smartify) {
                $eventData['spice_twitter_name'] = $twittername;
                $eventData['spice_twitter_url'] = $timeline_url;
                $eventData['spice_twitter_nofollow'] = $timeline_url_nofollow;
                $eventData['spice_twitter_icon_html'] = $twitter_icon_html;
                $eventData['spice_twitter_followme'] = $followme_widget;
            }
            else {
                if (serendipity_db_bool($this->get_config('followme_widget', false))) {
                    $eventData['comment'] = $followme_widget . '<br/>' . $eventData['comment'];
                }
                else {
                    $eventData['comment'] = '<a href="' . $timeline_url . '" class="commentspice_twitterlink" target="_blank"' . ($timeline_url_nofollow?' rel="nofollow"':'') . '>' . $twitter_icon_html .  ' ' . $twittername . '</a>' . '<br/>' . $eventData['comment'];
                }
            }
        }
        if ($spice['promo_name'] && $spice['promo_url']) {
            $spice_article_prefix = sprintf(PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_RESCENT, $eventData['author']); 
            $spice_article_name = $spice['promo_name'];
            $spice_article_url = $spice['promo_url'];
            $spice_article_nofollow = serendipity_db_bool($this->get_config('announcerss_nofollow', false)); 
            $smartify = serendipity_db_bool($this->get_config('smartifyannouncerss', false));
            if ($smartify) {
                $eventData['spice_article_prefix'] = $spice_article_prefix;
                $eventData['spice_article_name'] = $spice_article_name;
                $eventData['spice_article_url'] = $spice_article_url;
                $eventData['spice_article_nofollow'] = $spice_article_nofollow;
            }
            else {
                $eventData['comment'] .= "<p class=\"commentspice_announce_article\">" . $spice_article_prefix . ": <a href=\"$spice_article_url\" target=\"_blank\"" . ($spice_article_nofollow?' rel="nofollow"':'') . ">$spice_article_name</a></p>";
            }
        }
        
    }
    function createFollowMeWidget($wittername, $timeline_url_nofollow) {
        if (serendipity_db_bool($this->get_config('followme_widget', false))) {
            $extra_style = '';
            if (serendipity_db_bool($this->get_config('followme_widget_dark', false))) {
                $extra_style .= ' data-button="grey" data-text-color="#FFFFFF" data-link-color="#00AEFF"';
            }
            if (!serendipity_db_bool($this->get_config('followme_widget_counter', false))) {
                $extra_style .= '  data-show-count="false"';
            }
            return '<a href="https://twitter.com/' . $wittername . '" class="twitter-follow-button"' . $extra_style . ($timeline_url_nofollow?' rel="nofollow"':'') . '>Follow @' . $wittername . '</a>';
        }
        return "";
    }
    function handleAvatar(&$eventData, &$addData) {
        $this->log("avatar_hook. " . print_r($eventData,true) .  "\n" . print_r($addData, true));
        
        // We support twitter only
        if (!is_array($addData) || !$addData['type']==twitter) return;
        
        // Check for valid input
        if (!is_array($eventData) || !$eventData['cid']) return;
        
        // Add twitter infos to metadata. Twitter is detected by URL, so produce an URL
        $spice = DbSpice::loadCommentSpice($eventData['cid']);
        if (!is_array($spice)) return;
        
        if (!empty($spice['twittername'])) {
            $eventData['url'] = 'http://twitter.com/' . $spice['twittername'];
            $this->log("avatar_hook filled. " . print_r($eventData,true) .  "\n" . print_r($addData, true));
        }
    }
    
    function printCommentEditExtras(&$eventData, &$addData) {
        global $serendipity;
        
        if (serendipity_db_bool($this->get_config('twitterinput', true))) {
            if (isset($serendipity['COOKIE']['twitter'])) $twittername = $serendipity['COOKIE']['twitter'];
            else  $twittername = '';
            echo '<div id="serendipity_commentspice_twitter">';
            echo '<input class="commentspice_twitter_input" type="text" id="serendipity_commentform_twitter" name="serendipity[twitter]" placeholder="' . PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_PLACEHOLDER . '" value="' . $twittername . '"/>';
            echo '</div>';
        }
        if (serendipity_db_bool($this->get_config('announcerss', false))) {
            echo '<div id="serendipity_commentspice_rss" style="display:none;">';
            echo '<select class="commentspice_rss_input" id="serendipity_commentform_rss" name="serendipity[promorss]"></select>'; //  style="max-width: 20em; width: 100%"
            echo '</div>';
        }
        if (serendipity_db_bool($this->get_config('twitterinput', true))) {
            echo '<div  id="serendipity_commentspice_twitter_desc" class="serendipity_commentDirection serendipity_comment_spice">';
            echo '<img src="' . $serendipity['baseURL'] . 'index.php?/plugin/commentspice.png" class="commentspice_ico" title="' . PLUGIN_EVENT_COMMENTSPICE_TITLE . '">';
            echo PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_FOOTER;
            echo '</div>';
        }
        if (serendipity_db_bool($this->get_config('announcerss', false))) {
            echo '<div  id="serendipity_commentspice_rss_desc" class="serendipity_commentDirection serendipity_comment_spice">';
            echo '<img src="' . $serendipity['baseURL'] . 'index.php?/plugin/commentspice.png" class="commentspice_ico" title="' . PLUGIN_EVENT_COMMENTSPICE_TITLE . '">';
            echo PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_FOOTER;
            echo '</div>';
        }
    }
    
    function writeCss(&$eventData, &$addData) {
        global $serendipity;
        if (!(strpos($eventData, '.commentspice_ico'))) {
?>
.commentspice_ico {
	float:right;
	margin-right:0px;
	margin-left:10px;
}
<?php
        }
        if (!(strpos($eventData, '.commentspice_twitter_input'))) {
?>
.commentspice_twitter_input {
	background: url('<?php echo $serendipity['baseURL']; ?>index.php?/plugin/spiceicotwitter.png') left no-repeat;
	padding-left: 1.5em;
	max-width: 18.5em;
	margin-bottom: 1em;
}
<?php
        }
        if (!(strpos($eventData, '.commentspice_rss_input'))) {
?>
.commentspice_rss_input {
    max-width: 22em;
    min-width: 13.5em;
    width: 100%;
 	background: url('<?php echo $serendipity['baseURL']; ?>index.php?/plugin/spiceicorss.png') no-repeat left #444444;
 	overflow: hidden;
    border: 0.1em solid #000000;
    border-radius: 3px 3px 3px 3px;
    color: #FFFFFF;
	padding-left: 1.5em;
	margin-bottom: 1em;
}
<?php
        }
        if (!(strpos($eventData, '.commentspice_announce_article'))) {
?>
.commentspice_announce_article {
	padding-top: 1em;
	margin-bottom: 0em;
	font-size: smaller;
	text-align: center;
}
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
        if (!PLUGIN_EVENT_COMMENTSPICE_DEBUG) return;
        $fp = fopen(dirname(__FILE__) . '/spice.log','a');
        fwrite($fp, date('Y.m.d H:i:s') . " - " . $message . "\n");
        fflush($fp);
        fclose($fp);
    }
    
}
