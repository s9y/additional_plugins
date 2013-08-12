<?php # 

/*
TODO:
    - fake cronjob integration?
*/

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_facebook extends serendipity_event {
    var $title = PLUGIN_EVENT_FACEBOOK_NAME;
    var $debug = false;
    
    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_FACEBOOK_NAME);
        $propbag->add('description',   PLUGIN_EVENT_FACEBOOK_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '0.4');
        $propbag->add('groups', array('FRONTEND_VIEWS'));
        $propbag->add('event_hooks', array(
            'frontend_display' => true,
            'external_plugin'  => true,
            'cronjob' => true,
            'frontend_header' => true

        ));
        
        $propbag->add('configuration', array('facebook_users', 'facebook_moderate', 'limit', 'via', 'cronjob'));
    }

    function tableCreated($table = 'facebook')  {
        global $serendipity;

        $q = "select count(*) from {$serendipity['dbPrefix']}" . $table;
        $row = serendipity_db_query($q, true, 'num');

        if (!is_numeric($row[0])) {        // if the response we got back was an SQL error.. :P
            return false;
        } else {
            return true;
        }
    }

    function install() {
        global $serendipity;

        if (!$this->tableCreated('facebook')) {
            $q = "CREATE TABLE {$serendipity['dbPrefix']}facebook (
                    entryid int(10) not null,
                    base_url varchar(255),
                    resolved_url varchar(255)
                  )";

            $result = serendipity_db_schema_import($q);

            serendipity_db_schema_import("CREATE INDEX fbindex ON {$serendipity['dbPrefix']}facebook (base_url)");
        }
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;
        
        switch($name) {
            
            case 'facebook_users':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_FACEBOOK_USERS);
                $propbag->add('description', '');
                $propbag->add('default',     '');
                break;

            case 'cronjob':
                if (class_exists('serendipity_event_cronjob')) {
                    $propbag->add('type',        'select');
                    $propbag->add('name',        PLUGIN_EVENT_CRONJOB_CHOOSE);
                    $propbag->add('description', '');
                    $propbag->add('default',     'daily');
                    $propbag->add('select_values', serendipity_event_cronjob::getValues());
                } else {
                    $propbag->add('type', 'content');
                    $propbag->add('default', PLUGIN_AGGREGATOR_CRONJOB);
                }
                break;

            case 'limit':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_FACEBOOK_LIMIT);
                $propbag->add('description', PLUGIN_EVENT_FACEBOOK_LIMIT_DESC);
                $propbag->add('default',     '25');
                break;

            case 'via':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_FACEBOOK_VIA);
                $propbag->add('description', '');
                $propbag->add('default',     ' (via facebook)');
                break;

            case 'facebook_moderate':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FACEBOOK_MODERATE);
                $propbag->add('description', '');
                $propbag->add('default',     false);
                break;
        }

        return true;
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENT_FACEBOOK_NAME;
    }
    
    function example() {
        echo '<br />' . PLUGIN_EVENT_FACEBOOK_HOWTO;
    }
    
    function addcomment($entry_id, $user, $post_id, &$comment) {
        global $serendipity;

        $oldses = $_SESSION['HTTP_REFERER'];
        $_SESSION['HTTP_REFERER'] = 'facebook';

        // Circumvent captchas here so that comments can be saved.
        $_SESSION['spamblock']['captcha'] = $serendipity['POST']['captcha'] = 'abc';
        $serendipity['POST']['token'] = md5(session_id());
        
        $commentInfo = array();
        $commentInfo['name']    = $comment->from->name . $this->get_config('via');
        $commentInfo['url']     = 'http://www.facebook.com/' . $user . '?v=wall&story_fbid=' . $post_id;
        $commentInfo['email']   = $comment->from->id . '@example.com';
        $tcomment = $comment->message;
        if ($strip_tags) {
            $tcomment = strip_tags($tcomment);
        }

        $commentInfo['comment'] = $tcomment;
        $commentInfo['time']    = strtotime($comment->created_time);
        $commentInfo['source']  = 'facebook';
        $commentInfo['title']   = 'facebook_' . $comment->id;
        
        if (serendipity_db_bool($this->get_config('facebook_moderate'))) {
            $status = 'pending';
        } else {
            $status = 'approved';
        }
        
        foreach($commentInfo AS $key => $val) {
            $commentInfo[$key] = $this->decode($val);
        }
        
        serendipity_saveComment($entry_id, $commentInfo, 'NORMAL', 'facebook');
        $_SESSION['HTTP_REFERER'] = $oldses;
    }

    function linkmatch($link) {
        global $serendipity;
        static $my_base = null;
        
        $b = $serendipity['baseURL'];
        
        // We strip out the http:// part, to allow easier https/http matching
        if ($my_base === null) {
            $my_base = preg_replace('@(https?://|www.)@i', '', $b);
        }
        
        $my_link = preg_replace('@(https?://|www)@i', '', $link);
        
        // Check if our link is contained inside the foreign link
        if (stristr($my_link, $my_base)) {
            if ($this->debug) $my_link . " is contained in " . $my_base . "\n";
            
            $check_link = str_replace($my_base, $serendipity['serendipityHTTPPath'], $my_link);

            if ($this->debug) echo "Permalinkcheck for: $check_link\n";
            preg_match(PAT_PERMALINK, $check_link, $matches);
            $id = serendipity_searchPermalink($serendipity['permalinkStructure'], $check_link, (!empty($matches[2]) ? $matches[2] : $matches[1]), 'entry');

            return $id;
        }

        if ($this->debug) echo $my_link . " is NOT contained in " . $my_base . "\n";
        
        return false;
    }
    
    function &decode($string) {
        if (LANG_CHARSET == 'ISO-8859-1') {
            return utf8_decode($string);
        }

        return $string;
    }

    function fetchFacebook() {
        global $serendipity;
        $this->install();
        
        if ($this->debug) {
            $fp = fopen('/tmp/facebook.log', 'a');
            fwrite($fp, date('d.m.Y  H:i') . 'Facebook run');
            fclose($fp);
        }
        
        header('Content-Type: text/plain; charset=' . LANG_CHARSET);
        
        require_once S9Y_PEAR_PATH . 'HTTP/Request.php';
        
        $users = explode(',', $this->get_config('facebook_users'));
        foreach($users AS $user) {
            $user = trim($user);
            if (empty($user)) continue;

            $url = 'http://graph.facebook.com/' . $user . '/posts?limit=' . $this->get_config('limit');

            serendipity_request_start();
            $req = new HTTP_Request($url, array('allowRedirects' => true, 'maxRedirects' => 3));
            // code 200: OK, code 30x: REDIRECTION
            if (PEAR::isError($req->sendRequest()) || !preg_match('/200/', $req->getResponseCode())) {
                if ($this->debug) echo "Request failed. (" . $req->getResponseCode() . ")";
                serendipity_request_end();
                continue;
            } else {
                $data = $req->getResponseBody();
                serendipity_request_end();
                $fb   = json_decode($data);
                #print_r($fb);
                
                foreach($fb->data AS $idx => $fb_item) {
                    #if ($fb_item->
                    
                    // Check each Graph API item. If it's an empty link or the link points to facebook,
                    // we cannot read it. Also, the URL might not directly point to our own blog postings
                    // to match up, so we need to follow the HTTP request to see if Location: redirects
                    // take place to our final link.
                    if ($fb_item->type != 'link' || empty($fb_item->link) || preg_match('@/www.facebook.com/@i', $fb_item->link)) {
                        continue;
                    }
                    
                    // Skip some links that we can be sure are not to be requested
                    if (preg_match('@/(www\.)?(facebook.com|foursquare.com)/@i', $fb_item->link)) continue;
                    
                    if ($this->debug) echo "\nRequesting Link " . $fb_item->link . "\n";

                    // Check if we already have metadata about this link.
                    $meta = serendipity_db_query("SELECT entryid, resolved_url FROM {$serendipity['dbPrefix']}facebook WHERE base_url = '" . serendipity_db_escape_string($fb_item->link) . "'");
                    if ($meta[0]['resolved_url'] != '') {
                        // YES, link is stored.

                        if ($this->debug) echo "(Metadata exists)\n";
                        // Check if stored link is no blog entry of ours.
                        if ((int)$meta[0]['entryid'] == 0) continue;
                        
                        $entry_id = $meta[0]['entryid'];

                        if ($this->debug) echo "(Resolved to: $entry_id)\n";
                    } else {
                        // NO, link not yet stored. Request final location.
                        if ($this->debug) echo "(No metadata yet)\n";

                        serendipity_request_start();
                        $subreq = new HTTP_Request($fb_item->link, array('allowRedirects' => true, 'maxRedirects' => 3));
                        $ret = $subreq->sendRequest();
                        serendipity_request_end();
                        
                        $check_url = $subreq->_url->url;
                        
                        $entry_id = $this->linkmatch($check_url);
                        
                        if ($this->debug) echo "(Resolved to: $entry_id)\n";
                        
                        serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}facebook 
                          (entryid, base_url, resolved_url)
                        VALUES 
                          (" . (int)$entry_id . ", '" . serendipity_db_escape_string($fb_item->link) . "', '" . serendipity_db_escape_string($check_url) . "')");
                    
                        // Check if stored link is no blog entry of ours
                        if (empty($entry_id)) continue;
                    }

                    list($user_id, $post_id) = explode('_', $fb_item->id);
                    
                    // The comments inside the main API graph may not contain everything, so fetch each comment uniquely.
                    $curl = 'http://graph.facebook.com/' . $fb_item->id . '/comments';
                    if ($this->debug) echo $curl . "\n";

                    serendipity_request_start();
                    $subreq = new HTTP_Request($curl, array('allowRedirects' => true, 'maxRedirects' => 3));
                    $ret    = $subreq->sendRequest();
                    $cdata  = $subreq->getResponseBody();
                    serendipity_request_end();

                    $cfb   = json_decode($cdata);
                    #print_r($cfb);

                    // Iterate existing comments.
                    foreach($cfb->data AS $dataidx => $comment) {
                        // Check if comment is already saved.
                        $c = serendipity_db_query("SELECT id
                                                     FROM {$serendipity['dbPrefix']}comments 
                                                    WHERE entry_id = " . (int)$entry_id . " 
                                                      AND title    = 'facebook_" . $comment->id . "'");
                        if ($c[0]['id'] > 0) {
                            if ($this->debug) echo "Comment already fetched.\n";
                            continue;
                        }
                        
                        $this->addComment($entry_id, $user, $post_id, $comment);
                        if ($this->debug) echo "comment added.\n";
                    }
                }
            }
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;
        
        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                
                case 'cronjob':
                    if ($this->get_config('cronjob') == $eventData) {
                        serendipity_event_cronjob::log('Facebook', 'plugin');
                        $this->fetchFacebook();
                    }
                    return true;
                    break;

                case 'external_plugin':
                    $parts      = explode('_', $eventData);
                    
                    if ($parts[0] == 'facebookcomments') {
                        $this->fetchFacebook();
                    }

                    return true;
                    break;

                case 'frontend_header':
                    if (!isset($GLOBALS['entry'][0])) return true;

                    // Taken from: http://developers.facebook.com/docs/opengraph/
                    echo '<!--serendipity_event_facebook-->' . "\n";
                    echo '<meta property="og:title" content="' . htmlspecialchars($GLOBALS['entry'][0]['title']) . '" />' . "\n";
                    echo '<meta property="og:description" content="' . substr(strip_tags($GLOBALS['entry'][0]['body']), 0, 200) . '..." />' . "\n";

                    echo '<meta property="og:type" content="article" />' . "\n";
                    echo '<meta property="og:site_name" content="' . $serendipity['blogTitle'] . '" />' . "\n";

                    echo '<meta property="og:url" content="http' . ($_SERVER['HTTPS'] ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . htmlspecialchars($_SERVER['REQUEST_URI']) . '" />' . "\n";
                    
                    if (preg_match('@<img.*src=["\'](.+)["\']@imsU', $GLOBALS['entry'][0]['body'] . $GLOBALS['entry'][0]['extended'], $im)) {
                        echo '<meta property="og:image" content="' . $im[1] . '" />' . "\n";
                    }

                    return true;
                    break;

                // Print out image html for the user avatar into the frontend_display 
                case 'frontend_display':        
                    if (!isset($eventData['comment'])) {
                        return true;                            
                    }

                    // Add facebook avatar to $eventData['comment']
                    if (preg_match('@^facebook_@i', $eventData['ctitle']) && preg_match('@^(.*)\@@i', $eventData['email'], $fbid)) {
                        $eventData['comment'] = '
                        <div class="facebook_avatar serendipity_image_left">
                          <img src="https://graph.facebook.com/' . $fbid[1] . '/picture?type=square" alt="Facebook" />
                        </div><div class="facebook_comment">' . $eventData['comment'] . '</div>';
                        $eventData['comment_class'] .= ' facebook_avatar ';
                    }

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
