<?php
// POPfetcher -- Fetches and publishes email and attachments
//  from a POP3 email account (includes cell phone support for moblogging)
// Author: Jason Levitt  fredb86@users.sourceforge.net

require_once('class.pop3.php');
require_once('class.mimedecode.php');
require_once('sprintpcs.php');
require_once('cingular.php');
require_once('verizon.php');
require_once('tmobile.php');
require_once('o2.php');

// Default values
define('POPFETCHER_VERSION',  '1.42');       // This version of Popfetcher
define('DEFAULT_ADMINMENU',   'true');       // True if run as sidebar plugin. False if external plugin.
define('DEFAULT_HIDENAME',    'popfetcher'); // User should set this to something unguessable
define('DEFAULT_MAILSERVER',  '');
define('DEFAULT_MAILUSER',    '');
define('DEFAULT_MAILPASS',    '');
define('DEFAULT_DIR',         '');           // Leave blank for default top-level uploads directory
define('DEFAULT_PORT',        '110');        // POP mail port
define('DEFAULT_TIMEOUT',     '30');         // How many seconds to try to connect
define('DEFAULT_DELETEFLAG',  'true');       // True if msgs are deleted from mbox after retrieval
define('DEFAULT_STRIPTAGS',   'false');      // True if msgs get stripped before writing to database
define('DEFAULT_APOPFLAG',    'false');      // True if APOP login is desired
define('DEFAULT_BLOGFLAG',    'true');       // True if entire message is published as blog entry
define('DEFAULT_PUBLISHFLAG', 'false');      // False if message is published as draft
define('DEFAULT_CATEGORY',    '');           // Default publishing category -- blank means no category

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

require_once(dirname(__FILE__). '/lang_en.inc.php');

class serendipity_event_popfetcher extends serendipity_event
{

    var $title = PLUGIN_MF_NAME;

    function introspect(&$propbag) {
        $propbag->add('name',         PLUGIN_MF);
        $propbag->add('description',  PLUGIN_MF_DESC);
        $propbag->add('stackable',    false);
        $propbag->add('author',       'Jason Levitt');
        $propbag->add('version',      POPFETCHER_VERSION);
        $propbag->add('requirements', array(
            'serendipity' => '0.8',
            'php' => '4.1.0'
        ));

        $propbag->add('event_hooks',   array(
            'external_plugin'                                  => true,
            'backend_sidebar_entries'                          => true,
            'backend_sidebar_entries_event_display_popfetcher' => true,
            'cronjob'                                          => true
        ));
        $propbag->add('groups', array('BACKEND_FEATURES'));
        $propbag->add('configuration', array('cronjob', 'adminmenu', 'hidename', 'author', 'mailserver', 'mailuser', 'mailpass', 'onlyfrom', 'category', 'maildir', 'subfolder', 'blogflag', 'plaintext_is_body', 'plaintext_use_extended', 'textpref', 'adflag', 'striptext', 'striptagsflag', 'splittext', 'usetext', 'publishflag', 'default_moderate', 'default_comments', 'thumbnail_view',
        'usedate', 
        'deleteflag', 'apopflag', 'mailport', 'timeout', 'debug'));
    }
    
    function introspect_config_item($name, &$propbag) {

        switch($name) {
            case 'usedate':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_MF_USEDATE);
                $propbag->add('description', '');
                $propbag->add('default',     false);
                break;

            case 'subfolder':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_MF_SUBFOLDER);
                $propbag->add('description', '');
                $propbag->add('default',     true);
                break;

            case 'debug':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_MF_DEBUG);
                $propbag->add('description', '');
                $propbag->add('default',     false);
                break;

            case 'author':
                $propbag->add('type',        'select');
                $propbag->add('name',        AUTHOR);
                $propbag->add('description', MF_AUTHOR_DESC);
                $propbag->add('default',     '');
                $users = serendipity_fetchUsers();
                $vals  = array();
                $vals['empty'] = MF_MYSELF;
                foreach($users AS $user) {
                    $vals[$user['authorid']] = $user['realname'];
                }
                $vals['byemail'] = 'Lookup by email';
                $propbag->add('select_values', $vals);
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
                    $propbag->add('default', PLUGIN_MF_CRONJOB);
                }
                break;

            case 'plaintext_is_body':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        MF_TEXTBODY);
                $propbag->add('description', MF_TEXTBODY_DESC);
                $propbag->add('default',     true);
                break;

            case 'plaintext_use_extended':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        MF_TEXTBODY_FIRST);
                $propbag->add('description', MF_TEXTBODY_FIRST_DESC);
                $propbag->add('default',     true);
                break;

            case 'onlyfrom':
                $propbag->add('type',       'string');
                $propbag->add('name',       PLUGIN_MF_ONLYFROM);
                $propbag->add('description',PLUGIN_MF_ONLYFROM_DESC);
                $propbag->add('default',    '');
                break;

            case 'adminmenu':
                $propbag->add('type',        'radio');
                $propbag->add('name',        PLUGIN_MF_AM);
                $propbag->add('description', PLUGIN_MF_AM_DESC);
                $propbag->add('radio',       array(
                    'value' => array('true', 'false'),
                    'desc'  => array(INTERNAL_MF, EXTERNAL_MF)
                ));
                $propbag->add('default',     DEFAULT_ADMINMENU);
                break;

            case 'textpref':
                $propbag->add('type',        'radio');
                $propbag->add('name',        PLUGIN_MF_TEXTPREF);
                $propbag->add('description', PLUGIN_MF_TEXTPREF_DESC);
                $propbag->add('radio',       array(
                    'value' => array('both', 'html', 'text'),
                    'desc'  => array(PLUGIN_MF_TEXTPREF_BOTH, PLUGIN_MF_TEXTPREF_HTML, PLUGIN_MF_TEXTPREF_PLAIN)
                ));
                $propbag->add('default',     'both');
                break;

            case 'hidename':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_MF_HN);
                $propbag->add('description', PLUGIN_MF_HN_DESC);
                $propbag->add('default',     DEFAULT_HIDENAME);
                break;

            case 'striptext':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_MF_STRIPTEXT);
                $propbag->add('description', PLUGIN_MF_STRIPTEXT_DESC);
                $propbag->add('default',     '');
                break;

            case 'splittext':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_MF_SPLITTEXT);
                $propbag->add('description', PLUGIN_MF_SPLITTEXT_DESC);
                $propbag->add('default',     '');
                break;

            case 'usetext':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_MF_USETEXT);
                $propbag->add('description', PLUGIN_MF_USETEXT_DESC);
                $propbag->add('default',     '');
                break;

            case 'mailserver':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_MF_MS);
                $propbag->add('description', PLUGIN_MF_MS_DESC);
                $propbag->add('default',     DEFAULT_MAILSERVER);
                break;

            case 'mailuser':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_MF_MU);
                $propbag->add('description', PLUGIN_MF_MU_DESC);
                $propbag->add('default',     DEFAULT_MAILUSER);
                break;

            case 'mailpass':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_MF_MP);
                $propbag->add('description', PLUGIN_MF_MP_DESC);
                $propbag->add('default',     DEFAULT_MAILPASS);
                break;

            case 'category':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_MF_CAT);
                $propbag->add('description', PLUGIN_MF_CAT_DESC);
                $propbag->add('default',     DEFAULT_CATEGORY );
                break;

            case 'maildir':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_MF_MD);
                $propbag->add('description', PLUGIN_MF_MD_DESC);
                $propbag->add('default',     DEFAULT_DIR);
                break;

            case 'mailport':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_MF_PP);
                $propbag->add('description', PLUGIN_MF_PP_DESC);
                $propbag->add('default',     DEFAULT_PORT);
                break;

            case 'timeout':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_MF_TO);
                $propbag->add('description', PLUGIN_MF_TO_DESC);
                $propbag->add('default',     DEFAULT_TIMEOUT);
                break;

            case 'deleteflag':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_MF_DF);
                $propbag->add('description', PLUGIN_MF_DF_DESC);
                $propbag->add('default',     DEFAULT_DELETEFLAG);
                break;

            case 'blogflag':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_MF_BF);
                $propbag->add('description', PLUGIN_MF_BF_DESC);
                $propbag->add('default',     DEFAULT_BLOGFLAG);
                break;

            case 'striptagsflag':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_MF_STRIPTAGS);
                $propbag->add('description', PLUGIN_MF_STRIPTAGS_DESC);
                $propbag->add('default',     DEFAULT_STRIPTAGS);
                break;

            case 'publishflag':
                $propbag->add('type',        'radio');
                $propbag->add('name',        PLUGIN_MF_PF);
                $propbag->add('description', PLUGIN_MF_PF_DESC);
                $propbag->add('radio',       array(
                    'value' => array('true', 'false'),
                    'desc'  => array(PUBLISH_MF, DRAFT_MF)
                ));
                $propbag->add('default',     DEFAULT_PUBLISHFLAG);
                break;

            case 'apopflag':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_MF_AF);
                $propbag->add('description', PLUGIN_MF_AF_DESC);
                $propbag->add('default',     DEFAULT_APOPFLAG);
                break;

            case 'adflag':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_MF_ADDFLAG);
                $propbag->add('description', PLUGIN_MF_ADDFLAG_DESC);
                $propbag->add('default',     true);
                break;

            case 'default_comments':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        COMMENTS_ENABLE);
                $propbag->add('description', '');
                $propbag->add('default',     true);
                break;

            case 'default_moderate':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        COMMENTS_MODERATE);
                $propbag->add('description', '');
                $propbag->add('default',     false);
                break;
            case 'thumbnail_view':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        THUMBNAIL_VIEW);
                $propbag->add('description', THUMBNAIL_VIEW_DESC);
                $propbag->add('default',     true);
                break;

            default:
                return false;
        }
        return true;
    }

    function out($msg) {
        global $serendipity;
        static $debug = null;
        
        if ($debug === null) {
            $debug = serendipity_db_bool($this->get_config('debug'));
        }
        
        if ($debug) {
            $fp = @fopen($serendipity['serendipityPath'] . '/uploads/popfetcher-' . date('Y-m') . '.log', 'a');
        }
        
        if ($fp) {
            fwrite($fp, date('Y-m-d H:i') . ': ' . $msg . "\n");
            fclose($fp);
        }
        
        echo $msg;
    }

    function generate_content(&$title) {
        $title = PLUGIN_MF_NAME;
    }

    function workComment($id, $commentInfo, $type = 'NORMAL', $source = 'internal') {
        global $serendipity;

        $query = "SELECT id, allow_comments, moderate_comments, last_modified, timestamp, title FROM {$serendipity['dbPrefix']}entries WHERE id = '". (int)$id ."'";
        $ca    = serendipity_db_query($query, true);
    
        $commentInfo['type'] = $type;
        $commentInfo['source'] = $source;
        // serendipity_plugin_api::hook_event('frontend_saveComment', $ca, $commentInfo);
        if (!is_array($ca) || serendipity_db_bool($ca['allow_comments'])) {
            $title         = serendipity_db_escape_string(isset($commentInfo['title']) ? $commentInfo['title'] : '');
            $comments      = $commentInfo['comment'];
            $ip            = serendipity_db_escape_string(isset($commentInfo['ip']) ? $commentInfo['ip'] : $_SERVER['REMOTE_ADDR']);
            $commentsFixed = serendipity_db_escape_string($commentInfo['comment']);
            $name          = serendipity_db_escape_string($commentInfo['name']);
            $url           = serendipity_db_escape_string($commentInfo['url']);
            $email         = serendipity_db_escape_string($commentInfo['email']);
            $parentid      = (isset($commentInfo['parent_id']) && is_numeric($commentInfo['parent_id'])) ? $commentInfo['parent_id'] : 0;
            $status        = serendipity_db_escape_string(isset($commentInfo['status']) ? $commentInfo['status'] : (serendipity_db_bool($ca['moderate_comments']) ? 'pending' : 'approved'));
            $t             = serendipity_db_escape_string(isset($commentInfo['time']) ? $commentInfo['time'] : time());
            $referer       = substr((isset($_SESSION['HTTP_REFERER']) ? serendipity_db_escape_string($_SESSION['HTTP_REFERER']) : ''), 0, 200);
    
            $query = "SELECT a.email, e.title, a.mail_comments, a.mail_trackbacks
                     FROM {$serendipity['dbPrefix']}entries e, {$serendipity['dbPrefix']}authors a
                     WHERE e.id  = '". (int)$id ."'
                       AND e.isdraft = 'false'
                       AND e.authorid = a.authorid";
            if (!serendipity_db_bool($serendipity['showFutureEntries'])) {
                $query .= " AND e.timestamp <= " . serendipity_db_time();
    
            }
    
            $row = serendipity_db_query($query, true); // Get info on author/entry
            if (!is_array($row) || empty($id)) {
                // No associated entry found.
                return false;
            }
    
            if (isset($commentInfo['subscribe'])) {
                $subscribe = 'true';
            } else {
                $subscribe = 'false';
            }
    
            $query  = "INSERT INTO {$serendipity['dbPrefix']}comments (entry_id, parent_id, ip, author, email, url, body, type, timestamp, title, subscribed, status, referer)";
            $query .= " VALUES ('". (int)$id ."', '$parentid', '$ip', '$name', '$email', '$url', '$commentsFixed', '$type', '$t', '$title', '$subscribe', '$status', '$referer')";
    
            serendipity_db_query($query);
            $cid = serendipity_db_insert_id('comments', 'id');
    
            // Send mail to the author if he chose to receive these mails, or if the comment is awaiting moderation
            if (serendipity_db_bool($ca['moderate_comments'])
                || ($type == 'NORMAL' && serendipity_db_bool($row['mail_comments']))
                || ($type == 'TRACKBACK' && serendipity_db_bool($row['mail_trackbacks']))) {
                serendipity_sendComment($cid, $row['email'], $name, $email, $url, $id, $row['title'], $comments, $type, serendipity_db_bool($ca['moderate_comments']));
            }
    
            serendipity_approveComment($cid, $id, true);

            serendipity_purgeEntry($id, $t);
            return $cid;
        } else {
            return false;
        }
    }

    function nl2br_callback($matches) {
        return str_replace(array("\n", "\r"), array(" ", " "), $matches[0]);
    }

    function stripsubject($subject) {
        $s = preg_replace('@((Re|Aw|Wg)\^*[0-9]*\s*:\s*)+@imsU', '', $subject);
        $s = trim($s);
        return $s;
    }

    function workEntry($subject, &$msgbody, $authorid, &$postex, &$cid, &$s) {
        global $serendipity;
        
        $striptagsflag = serendipity_db_bool($this->get_config('striptagsflag'));
        $publishflag   = serendipity_db_bool($this->get_config('publishflag'));
        $splittext     = $this->get_config('splittext', '');
        $usetext       = $this->get_config('usetext', '');

        $entry             = array();
        $entry['isdraft']  = ($publishflag) ? 'false' : 'true';

        $catid = $cid['categoryid'];
        if (preg_match('@\[(.+)\]@imsU', $subject, $match)) {
            // We found a "[CATEGORY]" assignment. Let's check if this category exists.
            $parts = explode(';', $match[1]);
            foreach($parts AS $part) {
                $cat = serendipity_fetchCategoryInfo(null, $part);
                if (is_array($cat) && $cat['categoryid'] > 0) {
                    // Valid category found.
                    if (!is_array($catid)) {
                        $catid = array();
                    }

                    $catid[] = $cat['categoryid'];
                }
            }
            $subject = trim(str_replace('[' . $match[1] . ']', '', $subject));
        }

        $entry['title']    = $subject;
        $entry['body']     = $msgbody;
        
        #echo "Entry: <pre>" . $entry['body'] . "</pre>";
        
        if ($striptagsflag) {
            $entry['body'] = strip_tags($entry['body']);
        }

        $entry['authorid'] = $authorid;
        if (count($postex) > 0) {
            $entry['exflag'] = true;
            $entry['extended'] = implode("<br />\n", $postex);
        }

        if (!empty($catid)) {
            if (is_array($catid)) {
                $entry['categories'] = $catid;
            } else {
                $entry['categories'][0] = $catid;
            }
        }

        $entry['allow_comments']    = serendipity_db_bool($this->get_config('default_comments', true));
        $entry['moderate_comments'] = serendipity_db_bool($this->get_config('default_moderate', false));;

        if (!empty($usetext)) {
            // Only match the text we specified.
            $this->captureText($usetext, $entry['body']);
            $this->captureText($usetext, $entry['extended']);
        }

        if (!empty($splittext))  {
            // First combine all text into one, then split it by the magic split string,
            // and then divide up the portions.
            $parts = explode($splittext, $entry['body'] . $entry['extended']);
            $entry['body'] = $parts[0];
            unset($parts[0]);
            $entry['extended'] = implode($splittext, $parts);
        }

        $this->stripText($entry['body']);
        $this->stripText($entry['extended']);
        
        if (serendipity_db_bool($this->get_config('usedate'))) {
            $entry['timestamp'] = strtotime($s->headers['date']);
        }
        
        // Fix up Spaces in between HTML tags so that nl2br does not catch them.
        $entry['body']     = preg_replace_callback('@<(([^>]*)[\n\r]([^>]*))>@imsU', array($this, 'nl2br_callback'), $entry['body']);
        $entry['extended'] = preg_replace_callback('@<(([^>]*)[\n\r]([^>]*))>@imsU', array($this, 'nl2br_callback'), $entry['extended']);
        
        $entry['body']     = preg_replace_callback('@<(embed|object)[^>]*>(.*)</(embed|object)>@imsU', array($this, 'nl2br_callback'), $entry['body']);
        $entry['extended'] = preg_replace_callback('@<(embed|object)[^>]*>(.*)</(embed|object)>@imsU', array($this, 'nl2br_callback'), $entry['extended']);

        // REPLY-Mode detected. Store as a comment, not an entry.
        if (preg_match('@^(Re|Aw)\^*[0-9]*\s*:\s*(.*)$@imsU', $subject, $subjmatch)) {

            $comment = array();
            $users   = serendipity_fetchUsers($authorid);
            $user    = $users[0];
            $comment['comment']   = $entry['body'] . $entry['extended'];
            
            // Comments do not support HTML. Try to replace as much as possible to BBCode syntax.
            $comment['comment'] = str_replace(
                array(
                    '<b>',
                    '<strong>',
                    '<em>',
                    '<i>',

                    '</b>',
                    '</strong>',
                    '</em>',
                    '</i>',

                    '<br>',
                    '<br/>',
                    '<br />',

                    '->',
                    '<-',
                    '>>',
                    '<<',
                    '=>',
                    '<='
                    
                ),
                
                array(
                    '[b]',
                    '[b]',
                    '[i]',
                    '[i]',

                    '[/b]',
                    '[/b]',
                    '[/i]',
                    '[/i]',
                    
                    '',
                    '',
                    '',
                    
                    '-&gt;',
                    '&lt;-',
                    '&gt;&gt;',
                    '&lt;&lt;',
                    '=&gt;',
                    '&lt;='
                ),
                
                $comment['comment']
            );
            $comment['comment'] = preg_replace('@<img[^>]+src=["\'](.+)["\'][^>]*>@imsU', '[img]\1[/img]', $comment['comment']);
            $comment['comment'] = preg_replace('@<a[^>]+href=["\'](.+)["\'][^>]*>(.+)</a>@imsU', '[url=\1]\2[/url]', $comment['comment']);
            $comment['comment'] = preg_replace('@<([^>]+)>@imsU', '(\1)', $comment['comment']);
                                    
            $comment['name']      = $user['realname'];
            $entrysubject = $this->stripsubject($subjmatch[2]);
            
            $entry = serendipity_db_query("SELECT * 
                                             FROM {$serendipity['dbPrefix']}entries 
                                            WHERE title LIKE '%" . serendipity_db_escape_string($entrysubject) . "%'
                                         ORDER BY timestamp DESC");
            $this->out('<br />' . PLUGIN_MF_REPLY . ' (' . $entrysubject . ', #' . $entry[0]['id'] . ')');

            if (!is_array($entry)) {
                $this->out('<br />' . PLUGIN_MF_REPLY_ERROR1);
            } elseif ($scret = $this->workComment($entry[0]['id'], $comment, 'NORMAL')) {
                $this->out('<br />' . MF_MSG15 . ': #' . $entry[0]['id'] . '/' . $scret);
            } else {
                $this->out('<br />' . PLUGIN_MF_REPLY_ERROR2 . "<br />\n" . var_dump($scret));
            }
            
        } else {
            $id = serendipity_updertEntry($entry);
            $this->out('<br />' . MF_MSG15 . ': ' . $id);
        }

        return $entry;
    }

    function captureText($delim, &$text) {
        $delim = trim($delim);
        if (empty($delim)) {
            return true;
        }

        if (preg_match('@' . preg_quote($delim) . '(.+)' . preg_quote($delim) . '@imsU', $text, $match)) {
            $text = $match[1];
        }
        return true;
    }

    function stripText(&$text) {
        static $stext = null;

        if ($stext === null) {
            $stext = $this->get_config('striptext');
        }

        if (!empty($stext)) {
            $parts = explode($stext, $text);
            if (is_array($parts) && count($parts) > 1) {
                // All other parts are marked as junk.
                $text = $parts[0];
            }
        }
        
        // preg_replace('@<
        // preg_replace('@<(object|embed|img|param)[^>]*>(.*)

        return true;
    }

    function decode($string, $charset) {
        if ($charset == 'us-ascii') {
            $charset = 'iso-8859-1';
        }

        // If charset matches our current one, do nothing.
        if (strtolower($charset) == strtolower(LANG_CHARSET)) {
            return $string;
        }

        // ICONV recoding.
        if (function_exists('iconv')) {
            return iconv($charset, LANG_CHARSET . '//IGNORE', $string);
        }
        
        // RECODE recoding
        if (function_exists('recode_string')) {
            return recode_string($charset . '..' . LANG_CHARSET, $string);
        }

        if (strtolower($charset) == 'utf-8' && strtolower(LANG_CHARSET) != strtolower($charset)) {
            #echo 'UTF8_decode(' . $charset . ', ' . LANG_CHARSET . ')<br />';
            return utf8_decode($string);
        } elseif (strtolower(LANG_CHARSET) == 'utf-8' && strtolower($charset) != 'utf-8') {
            #echo 'UTF8_encode(' . $charset . ', ' . LANG_CHARSET . ')<br />';
            return utf8_encode($string);
        } else {
            // We can't deal with it.
            #echo 'none(' . $charset . ', ' . LANG_CHARSET . ')<br />';
            return $string;
        }

    }

    function cleanEmail($email) {
        return preg_replace('/^[^<]*<([^>]*)>.*$/','$1',$email);
    }
    
    function handleImage($p, &$debug, &$debug_file, &$tmobileflag, &$adflag, &$dirpath, &$list_virus, &$list_ignore, &$plaintext_is_body_flag,
        &$firsttext,
        &$plaintext_use_extended_flag,
        &$postex,
        &$postbody,
        &$dupcount,
        &$maildir,
        &$authorid,
        &$list_imagetype,
        &$list_imageext,
        &$subject) {
        global $serendipity;

        if ($debug_file !== null || $debug) {
            $this->out( "<br />\nRecognized inline attachment.<br />\n");
        }

        // If no filename is present, give it the name file.time().txt
        if (isset($p->d_parameters['filename'])) {
            $filename = $p->d_parameters['filename'];
            //Skip Tmobile junk pix
            if ($tmobileflag && $adflag and ( $filename == 'dottedLine_350.gif' || $filename == 'dottedLine_600.gif' || $filename == 'spacer.gif' || $filename == 'masthead.jpg' || $filename == 'audio.gif' || $filename == 'video.gif')) {
                continue;
            }
        } elseif (isset($p->ctype_parameters['name'])) {
            $filename = $p->ctype_parameters['name'];
        } elseif (isset($p->ctype_secondary)) {
            $filename = 'file' . time() . '.' . $p->ctype_secondary;
        } else {
            $filename = 'file' . time() . '.txt';
        }

        // Use makeFilename to get rid of spaces and other oddities
        $filename = serendipity_makeFilename($filename);

        // if no file extension exists, add default .txt file extension
        if (!strrpos($filename, ".")) {
            $filename = $filename . 'txt';
        }

        if ($debug_file !== null || $debug) {
            $this->out( "<br />\nStoring attachment as $filename<br />\n");
        }

        $this->out( '<br />' . MF_MSG8 . $filename );
        $fullname = $dirpath . $filename;
        // Extract file extension and file name for various processing
        $ext  = substr(strrchr($filename, "."), 0);
        $name = substr($filename, 0, strrpos($filename, "."));

        // Skip message and all attachments if possible virus found
        $lext = strtolower($ext);
        if (in_array($lext, $list_virus)) {
            $output = MF_MSG19. ': ' . $filename;
            $this->out( '<br />' . $output . '<br />');
            continue 2;
        }

        if (in_array($lext, $list_ignore)) {
            $this->out( '<br />' . MF_MSG20 . '<br />');
            continue;
        }

        if ($p->ctype_primary == 'text' && $p->ctype_secondary == 'plain' && $plaintext_is_body_flag) {
            $bodytext = trim($this->decode($p->body, $p->ctype_parameters['charset']));

            if (empty($bodytext)) {
                $this->out( '<br />' . MF_MSG20 . '<br />');
                continue;
            }

            if ($firsttext && $plaintext_use_extended_flag) {
                $postex[]   = '<p>' . $bodytext . '</p>';
            } else {
                $postbody[] = '<p>' . $bodytext . '</p>';
                $firsttext  = true;
            }

            // Do not save plaintext attachments if selected to use them as body
            if ($debug_file !== null || $debug) {
                $this->out( "Discarding saving plaintext attachment.<br />\n");
            }

            continue;
        }

        // Check for duplicate filename. Give dup file name file.time().dup.ext
        if (is_file($fullname)) {
            $this->out( '<br />' . MF_MSG14.$filename . "<br />");
            $name     = $name . time() . $dupcount . 'dup';
            $filename = $name . $ext;
            $fullname = $dirpath . $filename;
            $dupcount++;
        }

        $fp = fopen($fullname, 'w');
        if (!$fp) {
            $this->out( '<br />' . MF_ERROR5 . $fullname);
            return true;
        }

        fwrite($fp, $p->body);
        fclose($fp);
        $info = @getimagesize($fullname);

        if ($o2flag && is_array($info) && $adflag && $info[0] == '74' && $info[1] == '31') {
            // Seem this is the O2 logo. We don't like it. Kill it. Take no prisoners.
            @unlink($fullname);
            continue;
        }

        serendipity_makeThumbnail($filename, $maildir, false);
        serendipity_insertImageInDatabase($filename, $maildir, $authorid , NULL);
        $thumbname = $name . '.' . $serendipity['thumbSuffix'] . $ext;

        $ltype = strtolower($p->ctype_secondary);
        // Make sure images are displayed
        // $this->out( "Now we have to put the image into the Text <br />\n");
        // Do we want to have a thumbnail or full picture? thumbnail_view
        
        if (in_array($ltype, $list_imagetype) OR in_array($ext, $list_imageext)) {
            // We have an image here!
            if (!serendipity_db_bool($this->get_config('thumbnail_view', true))) {
                $displayed_file = $filename;
                $displayed_class = "full_popfetcherimage";
            } else {
                $displayed_file = $thumbname;
                $displayed_class = "popfetcherimage";
            }
            $attfile = $serendipity['serendipityHTTPPath'].$serendipity['uploadHTTPPath'].$maildir.$filename;
            $attlink = '<a class="'. $displayed_class .'" href="' . $attfile . '" target="_blank"><img src="'.$serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$maildir.$displayed_file.'" alt="'.htmlspecialchars($this->stripsubject($subject)).'" /></a>';
            
            if ($this->inline_picture($p->headers['content-id'], $postbody, $postex, $attfile, $attlink)) {
                return true;
            }

        } else {
            $attlink = '<a class="popfetcherfile"  href="' . $serendipity['serendipityHTTPPath'].$serendipity['uploadHTTPPath'].$maildir.$filename.'" target="_blank">'.$filename.'</a>';
        }
        
        // Inline pictures to match the structure of the mail
        if ($plaintext_is_body_flag) {
            // Only the first image is embedded in body, or if no extended entry is used
            if (!$firstattachment || !$plaintext_use_extended_flag) {
                if ($debug_file !== null || $debug) {
                    $this->out( "Saving attachment to postbody.<br />\n");
                }
                $postbody[] = $attlink;
            } else {
                if ($debug_file !== null || $debug) {
                    $this->out( "Saving attachment to postex.<br />\n");
                }
                $postex[]   = $attlink;
                $firsttext = true;
            }
        } else {
            if ($debug_file !== null || $debug) {
                $this->out( "Saving attachment seperately.<br />\n");
            }
            // Standard attachment mode
            $postattach[] = $attlink;
        }

        $firstattachment = true;
        $this->out( '<br />'.MF_MSG13.$filename . '<br />');

    }
    

    function inline_picture($cid, &$postbody, &$postex, $local_cid, $local_cid_link = '') {
        global $serendipity;
        static $inline_count = 0;
        
        $inline_count++;
        
        $cid = str_replace(array('<', '>'), array('', ''), $cid);
        
        if ($this->debug) {
        	$this->out('<br />Scanning for inlinepic: ' . $cid . ' (and [attach:' . $inline_count . '])<br />');
        }

        $has_match = false;
        foreach($postbody AS $idx => $pb) {
            if (stristr($pb, 'cid:' . $cid)) {
				if ($this->debug) {
					$this->out('<br />Match on body, replace with: ' . $local_cid . '<br />');
				}
                $has_match = true;
                $postbody[$idx] = str_replace('cid:' . $cid, $local_cid, $pb);
            } elseif (stristr($pb, '[attach:' . $inline_count . ']')) {
				if ($this->debug) {
					$this->out('<br />attach-Match on body, replace with: ' . $local_cid . '<br />');
				}
                $has_match = true;
                $postbody[$idx] = str_replace('[attach:' . $inline_count . ']', $local_cid_link, $pb);
            }
        }
            
        foreach($postex AS $idx => $pb) {
            if (stristr($pb, 'cid:' . $cid)) {
				if ($this->debug) {
					$this->out('<br />Match on extended body, replace with: ' . $local_cid . '<br />');
				}
                $has_match = true;
                $postex[$idx] = str_replace('cid:' . $cid, $local_cid, $pb);
            } elseif (stristr($pb, '[attach:' . $inline_count . ']')) {
				if ($this->debug) {
					$this->out('<br />attach-Match on extended body, replace with: ' . $local_cid . '<br />');
				}
                $has_match = true;
                $postex[$idx] = str_replace('[attach:' . $inline_count . ']', $local_cid_link, $pb);
            }
        }

        if ($this->debug) {
          $this->out('Inlinepic result: ' . ($has_match ? 'true' : 'false') . '<br />');
        }
	return $has_match;
    }

    function workPopfetcher(&$eventData) {
        global $serendipity;
        static $debug = null;
        
        if ($debug === null) {
            $debug = $this->debug = serendipity_db_bool($this->get_config('debug'));
        }

        // updertEntry() will not function unless this is set:
        $serendipity['POST']['properties']['fake'] = 'fake';
        $_SESSION['serendipityRightPublish'] = true;

        $this->out('<h3>' . PLUGIN_MF_NAME . ' v' . POPFETCHER_VERSION . ' @ ' . date("D M j G:i:s T Y") . '</h3>');

        $debug_file    = null; // DEVELOPERS: If set to a filename, you can bypass fetching POP and use a file instead.
        if ($debug_file != null) {
        	$this->debug = true;
        }

        $authorid = $this->get_config('author');

        if (empty($authorid) || $authorid == 'empty') {
            $authorid      = (isset($serendipity['authorid'])) ? $serendipity['authorid'] : 1;
        }
		
        $mailserver    = trim($this->get_config('mailserver'));
        $mailport      = $this->get_config('mailport');
        $mailuser      = trim($this->get_config('mailuser'));
        $mailpass      = trim($this->get_config('mailpass'));
        $timeout       = $this->get_config('timeout');
        $deleteflag    = serendipity_db_bool($this->get_config('deleteflag'));
        $apopflag      = serendipity_db_bool($this->get_config('apopflag'));
        $blogflag      = serendipity_db_bool($this->get_config('blogflag'));
        $striptagsflag = serendipity_db_bool($this->get_config('striptagsflag'));
        $publishflag   = serendipity_db_bool($this->get_config('publishflag'));
        $onlyfrom      = $this->get_config('onlyfrom', '');
        $maildir       = trim($this->get_config('maildir'));
        $category      = trim($this->get_config('category'));
        $adflag        = serendipity_db_bool($this->get_config('adflag'));

        $plaintext_is_body_flag      = serendipity_db_bool($this->get_config('plaintext_is_body'));
        $plaintext_use_extended_flag = serendipity_db_bool($this->get_config('plaintext_use_extended'));

        $list_virus     = array('.pif', '.vbs', '.scr', '.bat', '.com', '.exe');
        $list_imagetype = array('jpg', 'jpeg', 'gif', 'png', 'x-png', 'pjpeg');
        $list_imageext  = array('.gif', '.jpg', '.png', '.jpeg');
        $list_ignore    = array('.smil');

        $output  = '';
        $dirpath = $serendipity['serendipityPath'] . $serendipity['uploadPath'] . $maildir;
        
        $dupcount = 0;

        // Upload directory must end with a slash character
        if (strrchr($dirpath, '/') != '/'){
            $output = MF_ERROR7;
            $this->out( '<br />'.$output.'<br />');
            return true;
        }

        // Upload directory must be writable
        if (!is_writable($dirpath)){
            $output = MF_ERROR6;
            $this->out('<br />'.$output.'<br />');
            return true;
        }
        
        if (serendipity_db_bool($this->get_config('subfolder'))) {
            $dirpath = $dirpath . '/' . date('Y');
            if (!is_dir($dirpath)) {
                mkdir($dirpath);
            }
    
            $dirpath = $dirpath . '/' . date('m') . '/';
            if (!is_dir($dirpath)) {
                mkdir($dirpath);
            }
            
            $maildir .= date('Y') . '/' . date('m') . '/';
        }
        $maildir = str_replace('//', '/', $maildir);

        // Category (if specified) must exist
        if (!empty($category)){
            $cid = serendipity_fetchCategoryInfo(null, $category);
            if ($cid == false) {
                $output = MF_ERROR8;
                $this->out( '<br />'.$output.'<br />');
                return true;
            }
        }

        if ($debug_file === null) {
            // Create new instance of POP3 connection
            $pop3 = new POP3($mailserver, $timeout);

            // Attempt to connect to mail server
            if (!$pop3->connect($mailserver, $mailport)) {
                $output = MF_ERROR1.': '.$pop3->ERROR;
                $this->out( '<br />'.$output.'<br />');
                return true;
            }

            // Try APOP login if requested, otherwise, regular login
            if ($apopflag) {
                $Count = $pop3->apop($mailuser, $mailpass);
            } else {
                $Count = $pop3->login($mailuser, $mailpass);
            }

            // Check for error retrieving number of msgs in mailbox
            if (($Count === false) or ($Count == -1)) {
                $output = MF_ERROR2.': '.$pop3->ERROR;
                $this->out( '<br />'.$output.'<br />');
                return true;
            }

            // If no msgs in mailbox, exit
            if ($Count == 0) {
                $output=MF_MSG1;
                $this->out( '<br />'.$output.'<br />');
                return true;
            }

            // Get the list of email msgs
            $msglist = $pop3->uidl();

            // Check for error in getting list of email msgs
            if (!is_array($msglist)) {
                $output = MF_ERROR3.': '.$pop3->ERROR;
                $this->out( '<br />'.$output.'<br />');
                $pop3->quit();
                return true;
            }
        } else {
            // Developer debug switch which reads from a file and not a POP3 connection.
            $dfiles = explode(':', $debug_file);
            $Count = count($dfiles);
        }
        $Message = array();

        // ************************
        // Fetch each email msg and attachments and put it into the $Message array
        // ************************

        for ($i=1; $i <= $Count; $i++) {

            // Messages are numbered starting with '1', not '0'
            if ($debug_file === null) {
                $MessArray = $pop3->get($i);
            } else {
                $MessArray = file($dfiles[$i-1]);
            }

            // Should have an array. If not, there was an error
            if ( (!$MessArray) or (gettype($MessArray) != "array")) {
                $output = MF_ERROR4.': '.$pop3->ERROR;
                $this->out( '<br />'.$output.'<br />');
                $pop3->quit();
                return true;
            }

            // Extract the msg from MessArray and store it in Message
            $Message[$i-1]='';
            while (list($lineNum, $line) = each ($MessArray)) {
                $Message[$i-1] .= $line;
            }

            // Delete the msg
            if ($deleteflag && $debug_file === null) {
                $pop3->delete($i);
            }
        }

        if ($debug_file === null) {
            // Close the connection to the mail server
            $pop3->quit();
        }

        // ************************
        // Message processing section starts here
        // ************************

        $this->out( '<br />'.MF_MSG2.': '.$Count.'<br />');

        if ($deleteflag) {
            $this->out( MF_MSG11.'<br />');
        } else {
            $this->out( MF_MSG12.'<br />');
        }

        $params['include_bodies'] = true;
        $params['decode_bodies']  = true;
        $params['decode_headers'] = true;

        // Process each email msg
        foreach ($Message as $M) {

            $decode = new mimeDecode($M);
            #$this->out(print_r($M, true));
            
            $s = $decode->decode($params);
            
            #$this->out(print_r($s, true));

            if ($debug_file !== null) {
                // DEBUG Struct
                // echo '<pre>';
                // print_r($s);
				// echo '</pre>';
            }

            if ($s == null) {
                $this->out('<br />'.MF_ERROR9);
                return true;
            }

            $date    = (isset($s->headers['date']))    ? $s->headers['date']    : MF_MSG3;
            $from    = (isset($s->headers['from']))    ? $s->headers['from']    : MF_MSG4;
            if (!empty($onlyfrom) && trim($from) != trim($onlyfrom)) {
                $this->out('<br />'.sprintf(MF_ERROR_ONLYFROM, '"' . htmlspecialchars($from) . '"', '"' . htmlspecialchars($onlyfrom) . '"'));
                continue;
            }

            if (strtolower($s->ctype_parameters['charset']) == 'us-ascii' || empty($s->ctype_parameters['charset'])) {
                $s->ctype_parameters['charset'] = 'ISO-8859-1';
            }
            $subject = $this->decode(isset($s->headers['subject']) ? $s->headers['subject'] : MF_MSG17, $s->ctype_parameters['charset']);
            #$subject = $this->decode(isset($s->headers['subject']) ? $s->headers['subject'] : MF_MSG17, $s->ctype_parameters['charset']);
            #$subject = isset($s->headers['subject']) ? $s->headers['subject'] : MF_MSG17;

            $this->out( '<hr />');
            $this->out( MF_MSG5  . $date . '<br />');
            $this->out( MF_MSG6  . htmlspecialchars($from) . '<br />');
            $this->out( MF_MSG16 . $subject . '<br />');

            // Find the author associated with the from address and
            // set them as the author of the post.
            $useAuthor = null;
            if ($authorid == 'byemail') {
                // We don't have tons of authors .. like two so this isn't a problem
                // If I wanted this to be "production" quality, I would have to add
                // a new s9y function that let you retrieve an author given an email address
                // I suppose I could go with a convention that the base name of the 
                // email address had to be the author's name too.  Lookup by name is
                // supported by s9y.
                $auths = serendipity_fetchUsers();
                $vals  = array();
                $clean = strtolower($this->cleanEmail($from));
                foreach($auths AS $auth) {
                    if (isset($auth['email']) && strtolower($auth['email']) == $clean) {
                        $useAuthor = $auth['authorid'];
                        break;       	
                    }
                }

                if (is_null($useAuthor)) {
                    $this->out( '<br />'.sprintf(MF_ERROR_NOAUTHOR, '"' . htmlspecialchars($clean) . '"'));
                    continue;
                }
            } else {
                $useAuthor = $authorid;
            }
            
            $postattach       = array();
            $postbody         = array();
            $postex           = array();
            $verizonflag      = false;
            $tmobileflag      = false;
            $firstattachment  = false;
            $firsttext        = false;
            $o2flag           = stristr($from, 'mms.o2online.de') !== FALSE;

            // A mail message with attachments is a series of "parts"
            if ((isset($s->parts)) and (is_array($s->parts))) {
                if ($debug_file !== null || $debug) $this->out( '<pre>' . print_r($s->parts, true) . '</pre>');
                
                $textpref = $this->get_config('textpref');
                if ($textpref != 'both') {
                    $has_html = false;
                    $has_text = false;
                    $parts_html = array();
                    $parts_text = array();

                    foreach($s->parts AS $idx => $p) {
                        if ($p->ctype_primary == 'text' && $p->ctype_secondary == 'html') {
                            if ($debug_file !== null || $debug) {
                                $this->out( "This part is text/html.<br />\n");
                            }

                            $has_html = true;
                            $parts_html[] = $idx;
                        } elseif ($p->ctype_primary == 'text' && $p->ctype_secondary == 'plain') {
                            if ($debug_file !== null || $debug) {
                                $this->out( "This part is text/plain.<br />\n");
                            }

                            $has_text = true;
                            $parts_text[] = $idx;
                        }
                    }
                    
                    if ($debug_file !== null || $debug) {
                        $this->out( "Preference is: $textpref.<br />\n");
                    }

                    if ($textpref == 'text' && $has_html) {
                        if ($debug_file !== null || $debug) {
                            $this->out( "Preference is text/plain.<br />\n");
                        }

                        foreach($parts_html AS $pidx) {
                            if ($debug_file !== null || $debug) {
                                $this->out( "Stripping HTML part $pidx, because preference is plaintext.<br />\n");
                            }
                            unset($s->parts[$pidx]);
                        }
                    }

                    if ($textpref == 'html' && $has_text) {
                        if ($debug_file !== null || $debug) {
                            $this->out( "Preference is text/html.<br />\n");
                        }

                        foreach($parts_text AS $pidx) {
                            if ($debug_file !== null || $debug) {
                                $this->out( "Stripping text part $pidx, because preference is html.<br />\n");
                            }
                            unset($s->parts[$pidx]);
                        }
                    }
                }

                foreach($s->parts as $p) {

                    if ($debug_file !== null || $debug) {
                        $this->out( "Analyzing mail:<br />
                        Disposition: {$p->disposition}<br />
                        Body: " . (isset($p->body) ? 'Set' : 'Not Set') . "<br />
                        Primary CType: {$p->ctype_primary}<br />
                        Secondary CType: {$p->ctype_secondary}<br />
                        Filename: {$p->d_parameters[filename]}
                        .<br />\n");
                    }

                    // Handle msgs with attachments and messages with images that are inlined
                    if (( isset($p->disposition) AND $p->disposition == 'attachment' AND isset($p->body) )
                          OR
                        ( isset($p->disposition) AND $p->disposition == 'inline' AND isset($p->body) AND $p->ctype_primary == 'image')
                          OR
                        ( !empty($p->body) AND $p->ctype_primary == 'image') ) {

                        $this->handleImage($p, $debug, $debug_file, $tmobileflag, $adflag, $dirpath, $list_virus, $list_ignore, $plaintext_is_body_flag,
        $firsttext,
        $plaintext_use_extended_flag,
        $postex,
        $postbody,
        $dupcount,
        $maildir,
        $authorid,
        $list_imagetype,
        $list_imageext,
        $subject);
                    } elseif ((strtolower($p->ctype_primary) == 'text') and (isset($p->body))) {

                        if ($debug_file !== null || $debug) {
                            $this->out( "<br />\nRecognized text part.<br />\n");
                        }

                        if (trim($subject) == SPRINTPCS_IDENT_PICTURE) {
                            $p->body= sprintpcs_pictureshare($maildir, $p->body, $authorid);
                            if (strstr($p->body, ERROR_CHECK)) {
                                $this->out( '<br />'.$p->body);
                                return true;
                            }
                        }

                        if (trim($subject) == SPRINTPCS_IDENT_ALBUM) {
                            $p->body= sprintpcs_albumshare($maildir, $p->body, $authorid);
                            if (strstr($p->body, ERROR_CHECK)) {
                                $this->out( '<br />'.$p->body);
                                return true;
                            }
                        }

                        if (trim($subject) == SPRINTPCS_IDENT_VIDEO) {
                            $p->body= sprintpcs_videoshare($maildir, $p->body, $authorid);
                            if (strstr($p->body, ERROR_CHECK)) {
                                $this->out( '<br />'.$p->body);
                                return true;
                            }
                        }

                        if (stristr($subject, CINGULAR_IDENT_PICTURE)) {
                            $p->body= cingular_photo($maildir, $p->body);
                            if (strstr($p->body, ERROR_CHECK)) {
                                $this->out( '<br />'.$p->body);
                                return true;
                            }
                        }

                        if (stristr($p->body, VERIZON_IDENT_PICTURE)) {
                            $p->body= verizon_photo($maildir, $p->body);
                            $verizonflag=true;
                            if (strstr($p->body, ERROR_CHECK)) {
                                $this->out( '<br />'.$p->body);
                                return true;
                            }
                        }
                        
                        // Because text and HTML attachments get inlined
                        // sometimes (notably Hotmail),
                        // we want to collect them all and attach them to the
                        // regular msg body
                        $bodytext = trim($this->decode($p->body, $p->ctype_parameters['charset']));
                        if (empty($bodytext)) {
                            continue;
                        }
                        
                        // Strip evil HTML
                        if (preg_match('@<body[^>]*>(.+)</body>@imsU', $bodytext, $m)) {
                            if ($debug_file !== null || $debug) {
                                $this->out( "Reduced HTML text.<br />\n");
                            }
                           
                            $bodytext = $m[1];
                        }

                        if ($adflag && preg_match('@T\-Mobile MMS@', $bodytext) && preg_match('@http://www\.T\-Mobile\.(de|nl|com)/mms@', $bodytext)) {
                            if ($debug_file !== null || $debug) {
                                $this->out( "<br />\nSkipping T-Mobile ad.<br />\n");
                            }
                            continue;
                        }

                        if ($firsttext && $plaintext_use_extended_flag) {
                            $postex[]   = $bodytext;
                        } else {
                            $postbody[] = $bodytext;
                            $firsttext  = true;
                        }
                    } elseif (is_array($p->parts)) {

                        if ($debug_file !== null || $debug) {
                            $this->out( "<br />\nRecognized text/multipart.<br />\n");
                        }

                        if ($textpref != 'both') {
                            $has_html = false;
                            $has_text = false;
                            $parts_html = array();
                            $parts_text = array();
        
                            foreach($p->parts AS $idx => $subp) {
                                if ($subp->ctype_primary == 'text' && $subp->ctype_secondary == 'html') {
                                    $has_html = true;
                                    $parts_html[] = $idx;
                                } elseif ($subp->ctype_primary == 'text' && $subp->ctype_secondary == 'plain') {
                                    $has_text = true;
                                    $parts_text[] = $idx;
                                }
                            }
                            
                            if ($textpref == 'text' && $has_html) {
                                foreach($parts_html AS $pidx) {
                                    if ($debug_file !== null || $debug) {
                                        $this->out( "Stripping HTML part $pidx, because preference is plaintext.<br />\n");
                                    }
                                    unset($p->parts[$pidx]);
                                }
                            }
        
                            if ($textpref == 'html' && $has_text) {
                                foreach($parts_text AS $pidx) {
                                    if ($debug_file !== null || $debug) {
                                        $this->out( "Stripping text part $pidx, because preference is html.<br />\n");
                                    }
                                    unset($p->parts[$pidx]);
                                }
                            }
                        }

                        foreach($p->parts AS $subpart) {
                            if ($subpart->ctype_primary == 'text' && $subpart->ctype_secondary == 'html' && $o2flag) {
                                $bodytext = trim($this->decode(popfetcher_provider_o2::getBody($subpart->body), $subpart->ctype_parameters['charset']));

                                if (empty($bodytext)) {
                                    continue;
                                }

                                if ($firsttext && $plaintext_use_extended_flag) {
                                    $postex[]   = $bodytext;
                                } else {
                                    $postbody[] = $bodytext;
                                    $firsttext  = true;
                                }
                            } elseif ($subpart->ctype_primary == 'text') {
                                $bodytext = trim($this->decode($subpart->body, $subpart->ctype_parameters['charset']));
                                if (preg_match('@<body[^>]*>(.+)</body>@imsU', $bodytext, $m)) {
                                    if ($debug_file !== null || $debug) {
                                        $this->out( "Reduced HTML text.<br />\n");
                                    }
                                   
                                    $bodytext = $m[1];
                                }

                                if ($firsttext && $plaintext_use_extended_flag) {
                                    $postex[]   = $bodytext;
                                } else {
                                    $postbody[] = $bodytext;
                                    $firsttext  = true;
                                }
                            } elseif ($subpart->ctype_primary == 'image') {
                                // Handle inline multipart images
                                $this->handleImage($subpart, $debug, $debug_file, $tmobileflag, $adflag, $dirpath, $list_virus, $list_ignore, $plaintext_is_body_flag,
                                    $firsttext,
                                    $plaintext_use_extended_flag,
                                    $postex,
                                    $postbody,
                                    $dupcount,
                                    $maildir,
                                    $authorid,
                                    $list_imagetype,
                                    $list_imageext,
                                    $subject);
                            }

                        }
                    } else {

                        if ($debug_file !== null || $debug) {
                            $this->out( "<br />\nRecognized unknown part.<br />\n");
                        }

                        if ($p->disposition == 'inline' && isset($p->d_parameters['filename'])) {
                            // Use makeFilename to get rid of spaces and other oddities
                            $filename = serendipity_makeFilename($p->d_parameters['filename']);
                            // if no file extension exists, add default .txt file extension
                            if (!strrpos($filename, ".")) {
                                $filename = $filename . 'txt';
                            }

                            if ($debug_file !== null || $debug) {
                                $this->out( "<br />\nStoring attachment as $filename<br />\n");
                            }

                            $this->out( '<br />' . MF_MSG8 . $filename);
                            $fullname = $dirpath . $filename;
                            // Extract file extension and file name for various processing
                            $ext  = substr(strrchr($filename, "."), 0);
                            $name = substr($filename, 0, strrpos($filename, "."));

                            // Skip message and all attachments if possible virus found
                            $lext = strtolower($ext);
                            if (in_array($lext, $list_virus)) {
                                $output = MF_MSG19. ': ' . $filename;
                                $this->out( '<br />' . $output . '<br />');
                                continue 2;
                            }

                            if (in_array($lext, $list_ignore)) {
                                $this->out( '<br />' . MF_MSG20 . '<br />');
                                continue;
                            }

                            // Check for duplicate filename. Give dup file name file.time().dup.ext
                            if (is_file($fullname)) {
                                $this->out( '<br />' . MF_MSG14.$filename);
                                $name     = $name . time() . $dupcount . 'dup';
                                $filename = $name . $ext;
                                $fullname = $dirpath . $filename;
                                $dupcount++;
                            }

                            $fp = fopen($fullname, 'w');
                            if (!$fp) {
                                $this->out( '<br />' . MF_ERROR5 . $fullname);
                                return true;
                            }

                            fwrite($fp, $p->body);
                            fclose($fp);
                            serendipity_insertImageInDatabase($filename, $maildir, $authorid , NULL);
                            $attlink = '<a class="popfetcherfile"  href="' . $serendipity['serendipityHTTPPath'].$serendipity['uploadHTTPPath'].$maildir.$filename.'" target="_blank">'.$filename.'</a>';

                            // Inline pictures to match the structure of the mail
                            if ($plaintext_is_body_flag) {
                                // Only the first image is embedded in body, or if no extended entry is used
                                if (!$firstattachment || !$plaintext_use_extended_flag) {
                                    $postbody[] = $attlink;
                                } else {
                                    $postex[]   = $attlink;
                                    $firsttext  = true;
                                }
                            } else {
                                // Standard attachment mode
                                $postattach[] = $attlink;
                            }

                            $firstattachment = true;
                            $this->out( '<br />'.MF_MSG13.$filename);
                        }

                        $this->out( '<br />' . MF_MSG9);
                        // Tmobile sends a weird nested text and html
                        // sub-attachment (at least the nokia does)
                        if ((isset($s->headers['x-operator'])) and strtolower($s->headers['x-operator']) == TMOBILE_IDENT_PICTURE) {
                            $p->body     = tmobile_photo($maildir, $p->body);
                            $tmobileflag = true;
                            if (strstr($p->body, ERROR_CHECK)) {
                                $this->out( '<br />'.$p->body);
                                return true;
                            }
                        }
                    }
                }

                if ($blogflag) {
                    if ( trim($subject) == SPRINTPCS_IDENT_ALBUM || trim($subject) == SPRINTPCS_IDENT_PICTURE || trim($subject) == SPRINTPCS_IDENT_VIDEO || stristr($subject, CINGULAR_IDENT_PICTURE) || ($verizonflag and ($subject == MF_MSG17)) || ($tmobileflag and ($subject == MF_MSG17))) {
                        $time    = strtotime($s->headers['date']);
                        $stamp   = ($time == -1) ?  date("l, F j, Y, g:ia") : date("l, F j, Y, g:ia", $time);
                        $subject = MF_MSG23.$stamp;
                    }
                    
                    $msgbody = implode("<br />\n",  $postbody);
                    $msgbody .= implode("<br />\n", $postattach);

                    //New draft post
                    $entry = $this->workEntry($subject, $msgbody, $useAuthor, $postex, $cid, $s);
                }
            } elseif ((strtolower($s->ctype_primary) == 'text')) {
                // Email msg with no attachments
                if ($blogflag) {
                    if (trim($subject) == SPRINTPCS_IDENT_ALBUM || trim($subject) == SPRINTPCS_IDENT_PICTURE || trim($subject) == SPRINTPCS_IDENT_VIDEO || stristr($subject, CINGULAR_IDENT_PICTURE) || (stristr($s->body, VERIZON_IDENT_PICTURE) and ($subject == MF_MSG17)) || ($tmobileflag and ($subject == MF_MSG17)) ) {
                        $time    = strtotime($s->headers['date']);
                        $stamp   = ($time == -1) ?  date("l, F j, Y, g:ia") : date("l, F j, Y, g:ia", $time);
                        $subject = MF_MSG23.$stamp;
                    }

                    $bodytext = trim($this->decode($s->body, $s->ctype_parameters['charset']));
                    $entry = $this->workEntry($subject, $bodytext, $useAuthor, $postex, $cid, $s);
                } else {
                    $this->out( '<br />' . MF_MSG20);
                }
            } else {
                $this->out( '<br />' . MF_MSG10 . '<br />');
            }
        }
        echo '<br /><hr />';
    }

    function event_hook($event, &$bag, &$eventData) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            // Find out if we run this plugin externally or from the admin menu
            $adminmenu = $this->get_config('adminmenu');

            switch($event) {
                case 'backend_sidebar_entries':
                    if (!$adminmenu) return false;
                    echo '<li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=popfetcher">'.PLUGIN_MF_NAME.'</a></li>';
                    break;

                case 'external_plugin':
                    if ($adminmenu) return false;
                    $hidename = $this->get_config('hidename');
                    $events = explode('_', $eventData);
                    if ($events[0] != trim($hidename)) return false;

                case 'backend_sidebar_entries_event_display_popfetcher':
                    $this->workPopfetcher($eventData);
                    return true;
                    break;

                case 'cronjob':
                    if ($this->get_config('cronjob') == $eventData) {
                        serendipity_event_cronjob::log('Popfetcher', 'plugin');
                        $this->workPopfetcher($eventData);
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
?>