<?php 
// Contributed by Damian Luszczymak <info@daim-city.de>

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

include dirname(__FILE__) . '/plugin_version.inc.php';

require_once dirname(__FILE__) . '/classes/Twitter.php';

include dirname(__FILE__) . '/classes/json.php4.include.php';

class serendipity_plugin_twitter extends serendipity_plugin {
    var $title = PLUGIN_TWITTER_TITLE;
    var $debug = false;

    function introspect(&$propbag) {
        $this->title = $this->get_config('title', $this->title);

        $propbag->add('name',          PLUGIN_TWITTER_TITLE);
        $propbag->add('description',   PLUGIN_TWITTER_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Grischa Brockhaus, Damian Luszczymak, Garvin Hicking');
        //$propbag->add('website',       'http://board.s9y.org');
        $propbag->add('version',       PLUGIN_TWITTER_VERSION);
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '5.1.0'
        ));
        
        $configuration =  
            array('title', 'number', 'service', 'username', 'showformat', 'toall_only', 'filter_all_user', 
            'use_time_ago', 'dateformat', 'linktext',  
            'followme_link', 'followme_widget', 'followme_widget_counter','followme_widget_dark',
            'cachetime', 'backup');

        if (!class_exists('serendipity_event_twitter')) {
            $configuration = array_merge($configuration, array('event_not_installed'));
        }

        $propbag->add('configuration', $configuration); 
        $propbag->add('groups', array('FRONTEND_VIEWS'));
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch($name) {
            case 'event_not_installed':
                $propbag->add('type',           'content');
                $propbag->add('default',        PLUGIN_TWITTER_EVENT_NOT_INSTALLED);
                break;
                break;

            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        TITLE);
                $propbag->add('description', TITLE_FOR_NUGGET);
                $propbag->add('default',     PLUGIN_TWITTER_TITLE);
                break;

            case 'service':
                $propbag->add('type', 'radio');
                $propbag->add('name',         PLUGIN_TWITTER_SERVICE);
                $propbag->add('description',  PLUGIN_TWITTER_SERVICE_DESC);
                $propbag->add('radio',        array(
                    'value' => array('twitter.com', 'identi.ca'),
                    'desc'  => array('Twitter.com', 'identi.ca')
                    ));
                $propbag->add('default', 'twitter.com');
                break;
            
            case 'username':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_TWITTER_USERNAME);
                $propbag->add('description', PLUGIN_TWITTER_USERNAME_DESC); 
                $propbag->add('default', 'username');
                break;

            case 'number':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_TWITTER_NUMBER);
                $propbag->add('description', PLUGIN_TWITTER_NUMBER_DESC);
                $propbag->add('default', 10);
                break;
            
            case 'toall_only': // filter only tweets starting with @
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_TWITTER_TOALL_ONLY);
                $propbag->add('description', PLUGIN_TWITTER_TOALL_ONLY_DESC);
                $propbag->add('default', false);
                break;
            
            case 'filter_all_user': // filter tweets containing @
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_TWITTER_FILTER_ALL);
                $propbag->add('description', PLUGIN_TWITTER_FILTER_ALL_DESC);
                $propbag->add('default', false);
                break;
            
            case 'followme_link':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_TWITTER_FOLLOWME_LINK);
                $propbag->add('description', PLUGIN_TWITTER_FOLLOWME_LINK_DESC);
                $propbag->add('default', false);
                break;
            case 'followme_widget':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_TWITTER_FOLLOWME_WIDGET);
                $propbag->add('description', PLUGIN_TWITTER_FOLLOWME_WIDGET_DESC);
                $propbag->add('default', false);
                break;
            case 'followme_widget_counter':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_TWITTER_FOLLOWME_WIDGET_COUNT);
                $propbag->add('description', PLUGIN_TWITTER_FOLLOWME_WIDGET_COUNT_DESC);
                $propbag->add('default', true);
                break;
            case 'followme_widget_dark':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_TWITTER_FOLLOWME_WIDGET_DARK);
                $propbag->add('description', PLUGIN_TWITTER_FOLLOWME_WIDGET_DARK_DESC);
                $propbag->add('default', false);
                break;
            
            case 'use_time_ago':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_TWITTER_USE_TIME_AGO);
                $propbag->add('description', PLUGIN_TWITTER_USE_TIME_AGO_DESC);
                $propbag->add('default', 'false');
                break;

            case 'dateformat':
                $propbag->add('type', 'string');
                $propbag->add('name', GENERAL_PLUGIN_DATEFORMAT);
                $propbag->add('description', sprintf(GENERAL_PLUGIN_DATEFORMAT_BLAHBLAH, '%A, %B %e %Y'));
                $propbag->add('default', '%A, %B %e %Y');
                break;
            
            case 'linktext':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_TWITTER_LINKTEXT);
                $propbag->add('description', PLUGIN_TWITTER_LINKTEXT_DESC);
                $propbag->add('default', 'link');
                break;
            
            case 'cachetime':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_TWITTER_CACHETIME);
                $propbag->add('description', PLUGIN_TWITTER_CACHETIME_DESC);
                $propbag->add('default', '300');
                break;

            case 'showformat':
                $propbag->add('type', 'radio');
                $propbag->add('name', PLUGIN_TWITTER_SHOWFORMAT);
                $propbag->add('description', PLUGIN_TWITTER_SHOWFORMAT_DESC);
                $propbag->add('radio',  array(
                    'value' => array('javascript', 'PHP'),
                    'desc'  => array(PLUGIN_TWITTER_SHOWFORMAT_RADIO_JAVASCRIPT, PLUGIN_TWITTER_SHOWFORMAT_RADIO_PHP)
                    ));
                $propbag->add('default', 'javascript');
                break;            

            case 'backup':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_TWITTER_BACKUP);
                $propbag->add('description', PLUGIN_TWITTER_BACKUP_DESC);
                $propbag->add('default', 'false');
                break;

            default:
                return false;
        }
        return true;
    }

    function cleanup() {
        global $serendipity;

        $service        = $this->get_config('service', 'twitter.com');
        $username       = $this->get_config('username');

        // If followme widget is set, disable linḱ
        if ($service=='twitter.com' && serendipity_db_bool($this->get_config('followme_widget'))) {
            $this->set_config('followme_link', FALSE);
        }
        $cache_user = md5($service) . md5($username);
        $cachefile = $serendipity['serendipityPath'] . PATH_SMARTY_COMPILE . "/twitterresult.$cache_user.json";

        // Remove Cachefile
        @unlink($cachefile);
    }
    
    function output($out) {
        if (LANG_CHARSET == 'UTF-8') {
            echo $out;
        } else {
            echo utf8_decode($out);
        }
    }

    function generate_content(&$title) {
        global $serendipity;

        $number         = $this->get_config('number');
        $service        = $this->get_config('service', 'twitter.com');
        $username       = $this->get_config('username');
        $dateformat     = $this->get_config('dateformat');
        $title          = $this->get_config('title', $this->title);
        $showformat     = $this->get_config('showformat');
        $cachetime      = (int)$this->get_config('cachetime', 300);
        
        if (!is_numeric($number)) {
            $number = 10;
        }
        
        if ($service == 'identi.ca')
        {
            $followme_url = 'http://identi.ca/' . $username;
            $service_url = 'http://identi.ca/api';
            $status_url = 'http://identi.ca/notice/';
            //$JSONcallback = 'identicaCallback2';
            $JSONcallback = 'twitterCallback2'; // We call the twitter widget. It is working with identi.ca too, but the callback name is twitter!
            $api = new Twitter(true);
        }
        else
        {
            $followme_url = 'http://twitter.com/' . $username;
            $service_url = 'http://twitter.com';
            $status_url = 'http://twitter.com/' . $username . '/statuses/';
            $JSONcallback = 'twitterCallback2';
            $api = new Twitter(false);
        }

        if (!$dateformat || strlen($dateformat) < 1) {
            $dateformat = '%A, %B %e %Y';
        }

        if ($showformat == 'PHP') {

            $cache_user = md5($service) . md5($username);
            $cachefile = $serendipity['serendipityPath'] . PATH_SMARTY_COMPILE . "/twitterresult.$cache_user.json";

            // If the Event Plugin is not installed, we have to fill the cachefile on our own..
            // To immidiately display a result, the file_exists check is added.
            if (!class_exists('serendipity_event_twitter') || !file_exists($cachefile)) {
                $this->updateTwitterTimelineCache($cachefile);
            }
            
            // Get xml from cache:
            if (file_exists($cachefile)) {
                $xml = json_decode(unserialize(file_get_contents($cachefile)));
            }

            $str_output = array();
            
            // now process it:
            $str_output[] = '<ul id="twitter_update_list">';
            $odd_css = 'odd';
            if (!is_array($xml)) {
                if (!empty($xml->error)) {
                    $msg = $xml->error;
                }
                else {
                    $msg = PLUGIN_TWITTER_PROBLEM_TWITTER_ACCESS;
                }
                $str_output[] = "<li>$msg</li>";
            }
            else {
                if ($number>0) {
                    $counter = 0;
                    $toall_only = serendipity_db_bool($this->get_config('toall_only', false));
                    $filter_all_user = serendipity_db_bool($this->get_config('filter_all_user', false));
                    
                    foreach ($xml as $key => $value) {
                        // Change encoding of update to Visitors language
                        if (LANG_CHARSET!='UTF-8' && function_exists("mb_convert_encoding")) {
                            $status->text = mb_convert_encoding($status->text, LANG_CHARSET, 'auto');
                        }
                        $showit = true;
                        if ($filter_all_user && preg_match('/@/',$value->text)) $showit=false;
                        else if ($toall_only && preg_match('/^@/',$value->text)) $showit=false;
                        if ($showit) {
                            $str_output[] = '<li class="twitter_update_' . $odd_css . '"><span> ' . $status->text = $api->replace_links_in_status($value->text, $this->get_config('linktext','link'), 'twitter_update_link', 'twitter_user') . '</span><a class="twitter_update_time" href="' . $status_url . $value->id_str . '">' . $this->makeDate($value->created_at,$dateformat) . '</a></li>';
                            $odd_css = $odd_css=='odd'?'even':'odd';
                            $counter++;
                        }
                        if ($counter>=$number) break;
                    }
                }
            }
            $str_output[] = '</ul>';
            // Display only, if we have something meaningful:
            if (count($str_output)>2) {
                $output = implode('', $str_output);
                $this->output($output);
            }
            
        } else {
            echo '<ul id="twitter_update_list"><li style="display: none"></li></ul>' . "\n";            
            echo '<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>' . "\n";
            echo '<script type="text/javascript" src="' . $service_url . '/statuses/user_timeline/' . $username . '.json?callback=' . $JSONcallback . '&amp;count=' . $number . '"></script>';
        }  
        if (serendipity_db_bool($this->get_config('followme_link', false))) {
            echo '<p id="twitter_follow_me"><a href="' . $followme_url . '" class="twitter_follow_me">' . PLUGIN_TWITTER_FOLLOWME_LINK_TEXT . '</a></p>' . "\n";            
        }
        if ($service == 'twitter.com' && serendipity_db_bool($this->get_config('followme_widget', false))) {
            $extra_style = '';
            if (serendipity_db_bool($this->get_config('followme_widget_dark', false))) {
                $extra_style .= ' data-button="grey" data-text-color="#FFFFFF" data-link-color="#00AEFF"';
            }
            if (!serendipity_db_bool($this->get_config('followme_widget_counter', true))) {
                $extra_style .= '  data-show-count="false"';
            }
            echo '<a href="https://twitter.com/'.$username.'" class="twitter-follow-button"'.$extra_style.'">Follow @'.$username.'</a><script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>';
        }
        
        if ($showformat == 'PHP') {
            // If the twitter event plugin is installed, too, save cache file in background.
            // When twitter is blocking, the blog isn't when using this background caching.
            // Background caching is done by a external plugin call, that is executed by the event plugin            
            if (class_exists('serendipity_event_twitter')) {
                // add png that reloads the cache:            
                $pluginurl = $serendipity['baseURL'] . $serendipity['indexFile'] . '?/' . $this->getPermaPluginPath();
                $png_url = $pluginurl . '/cacheplugintwitter' .$this->cache_img_link_pars();
                echo '<img src="' . $png_url . '" width="1" height="1" alt="" class="twitter_plugin_cache_png" style="float:right;"/>';
            }

            
        }
        
        if (serendipity_db_bool($this->get_config('backup')) && $service == 'twitter.com') {
            $last_backup = $this->get_config('last_backup', 0);
            if (date('Ymd') == date('Ymd', $last_backup)) {
                return true;
            }

            $this->checkTable();
            $this->makeBackup($username, $last_backup);
        }
    }
    
    function cache_img_link_pars() {
        $service        = $this->get_config('service');
        $username       = str_replace("_","!",  $this->get_config('username'));
        $number         = $this->get_config('number');
        if (serendipity_db_bool($this->get_config('toall_only', false))) {
            $number = 50; // Fetch many in the hope, that there are enough globals with it.
        }
        $cachetime      = $this->get_config('cachetime', 300);
        return "_{$service}_{$username}_{$number}_{$cachetime}";
    }
    
    function updateTwitterTimelineCache($cachefile){
        global $serendipity;
        $cachetime      = (int)$this->get_config('cachetime', 300);

        if (!file_exists($cachefile) || filemtime($cachefile) < (time()-$cachetime)) {
            require_once S9Y_PEAR_PATH . 'HTTP/Request.php';
    
            $service        = $this->get_config('service');
            $username       = $this->get_config('username');
            $number         = $this->get_config('number');
            if (serendipity_db_bool($this->get_config('toall_only', false))) {
                $number = 50; // Fetch many in the hope, that there are enough globals with it.
            }
    
            if ($service == 'identi.ca')
            {
                $followme_url = 'http://identi.ca/' . $username;
                $service_url = 'http://identi.ca/api';
                $status_url = 'http://identi.ca/notice/';
            }
            else
            {
                $followme_url = 'http://twitter.com/' . $username;
                $service_url = 'http://twitter.com';
                $status_url = 'http://twitter.com/' . $username . '/statuses/';
            }

            $search_twitter_uri = $service_url . '/statuses/user_timeline/' . $username . '.json?count=' . $number;
            serendipity_request_start();
            $req = new HTTP_Request($search_twitter_uri);
            $req->sendRequest();
            $response = trim($req->getResponseBody());
            $error = $req->getResponseCode();
            serendipity_request_end();

            if ($error==200 &&!empty($response)) {
                $fp = fopen($cachefile, 'w');
                fwrite($fp, serialize($response));
                fflush($fp);
                fclose($fp);
            }
        }
    }
    
    /**
     * Return binary response for an image
     */
    function show_img($filename, $mime_type='image/png') {
        header("Content-type: $mime_type");
        header("Date: " . date("D, d M Y H:i:s T"));
        
        $fp   = @fopen($filename, "rb");
        if ($fp) {
            header('X-TwitterPluginPng: Found');
            $filemtime = filemtime($filename);
            header("Content-Length: ". filesize($filename), true);
            header("Last-Modified: " . date("D, d M Y H:i:s T", $filemtime), true);
            fpassthru($fp);
            fclose($fp);
        }
        else {
            header('X-TwitterPluginPng: No-Image');
            header("Content-Length: 0", true);
            header("Last-Modified: " . date("D, d M Y H:i:s T"), true);
        }
        return true;
    }

    function checkTable() {
        global $serendipity;

        
        $q = "CREATE TABLE IF NOT EXISTS {$serendipity['dbPrefix']}tweets (
            id bigint(11) {PRIMARY},
            tweetdate int(11),
            tweet longtext,
            username varchar(255),
            reply_to_status int(11),
            reply_to_user int(11),
            source varchar(255)
            
        );";
        
        serendipity_db_schema_import($q);
        
        $db_version = $this->get_config("db_version");
        
        // Convert tweet id to bigint!
        if (empty($db_version)) {
            $q = "ALTER TABLE {$serendipity['dbPrefix']}tweets CHANGE id id bigint(11)";
            serendipity_db_schema_import($q);
        }
        $this->set_config("db_version",1);

        
        
    }
    
    function debugOut($string) {
        global $serendipity;
        $fp = fopen($serendipity['serendipityPath'] . PATH_SMARTY_COMPILE . '/twitter.log', 'a');
        fwrite($fp, date('Y-m-d H:i') . ' ' . $string . "\n");
        fclose($fp);
        
        echo $string . "<br />\n";
    }

    function twitterGet($url) {
        global $serendipity;

        $page         = 1; // Twitter starts with page 1!
        $has_more     = true;
        $last_tweetid = 0;
        $failsafe     = 50; // Maximum of pages. I don't think it should ever get this high.
        
        while ($has_more) {
            if ($this->debug) $this->debugOut("Getting {$url}{$page}.");

            $out = file_get_contents($url . $page);
            $page++;
            $current_count = 0;
            if (empty($out) || $page > $failsafe) {
                if ($this->debug) $this->debugOut("No more results! (Failsafe?)");
                $has_more = false;
            }

            $data = json_decode($out);
            if (!is_array($data)) {
                if ($this->debug) $this->debugOut("No result set.");
            } else {
                foreach($data AS $twitter_obj) {
                    if (!is_object($twitter_obj) || empty($twitter_obj->id)) continue;
                    $current_count++;

                    $twitter_db = array(
                        'id'                => $twitter_obj->id,
                        'tweetdate'         => strtotime($twitter_obj->created_at),
                        'tweet'             => $twitter_obj->text,
                        'reply_to_status'   => $twitter_obj->in_reply_to_status_id,
                        'reply_to_user'     => $twitter_obj->in_reply_to_user_id,
                        'username'          => $twitter_obj->user->name,
                        'source'            => $twitter_obj->source
                    );

                    if ($last_tweetid == 0) {
                        $last_tweetid = $twitter_obj->id;
                    }
                    $db_result = serendipity_db_insert('tweets', $twitter_db);
                    
                    if ($this->debug) $this->debugOut("Got #$current_count: " . substr($twitter_obj->text, 0, 15) . " dbresult:$db_result");
                }
            }

            if ($current_count < 100) {
                if ($this->debug) $this->debugOut("No more pages.");
                $has_more = false;
            }
        }
        
        if ($this->debug) $this->debugOut("Storing last tweet: {$last_tweetid}");
        if ($last_tweetid > 0) {
            $this->set_config('last_tweetid', $last_tweetid);
        }
    }

    function makeBackup($username, $last_backup) {
        global $serendipity;

        $this->set_config('last_backup', time());

        if ($last_backup < 1) {
            // First time backup. Grab everything we can get.
            $this->twitterGet('http://twitter.com/statuses/user_timeline/' . $username . '.json?count=100&page=');
        } else {
            $this->twitterGet('http://twitter.com/statuses/user_timeline/' . $username . '.json?count=100&since_id=' . $this->get_config('last_tweetid') . '&page=');
        }
    }

    function makeDate($created_at,$dateformat) {
        if (serendipity_db_bool($this->get_config('use_time_ago'))) {
            return Twitter::create_status_ago_string($created_at);
        }
        
        $old_date = explode(" ", $created_at);
        $old_time = explode(":", $old_date[3]);
        
        switch($old_date[1]) {
            case 'Jan': $old_date[1]=1; break;
            case 'Feb': $old_date[1]=2; break;
            case 'Mar': $old_date[1]=3; break;
            case 'Apr': $old_date[1]=4; break;
            case 'May': $old_date[1]=5; break;
            case 'Jun': $old_date[1]=6; break;
            case 'Jul': $old_date[1]=7; break;
            case 'Aug': $old_date[1]=8; break;
            case 'Sep': $old_date[1]=9; break;
            case 'Oct': $old_date[1]=10; break;
            case 'Nov': $old_date[1]=11; break;
            case 'Dec': $old_date[1]=12; break;
        }

        $timestamp = mktime($old_time[0],$old_time[1],$old_time[2],$old_date[1],$old_date[2],$old_date[5]);
        
        if (LANG_CHARSET == 'UTF-8') {
            return serendipity_strftime($dateformat, $timestamp);
        } else {
            return utf8_encode(serendipity_strftime($dateformat, $timestamp));
        }
    }

    function getPermaPluginPath() {
        global $serendipity;

        // Get configured plugin path:         
        $pluginPath = 'plugin';
        if (isset($serendipity['permalinkPluginPath'])){
            $pluginPath = $serendipity['permalinkPluginPath'];
        }
        
        return $pluginPath;
        
    }

}
