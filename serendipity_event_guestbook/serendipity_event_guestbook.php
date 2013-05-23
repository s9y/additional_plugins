<?php # $Id$
// serendipity_event_guestbook.php, v.3.31 - 2012-09-14 ian

//error_reporting(E_ALL);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

/* Probe for a language include with constants. Still include defines later on, if some constants were missing */
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_guestbook extends serendipity_event {

    var $title = PLUGIN_GUESTBOOK_TITLE;
    var $filter_defaults;
    
    function introspect(&$propbag) {

        global $serendipity;

        $propbag->add('name',         PLUGIN_GUESTBOOK_TITLE);
        $propbag->add('description',  PLUGIN_GUESTBOOK_TITLE_BLAHBLAH);
        $propbag->add('event_hooks',  array (
                        'frontend_configure' => true,
                        'entries_header'     => true,
                        'external_plugin'    => true,
                        'genpage'            => true,
                        'backend_sidebar_entries'   => true,
                        'backend_sidebar_entries_event_display_guestbook'  => true,
                        'css'                => true,
                        'css_backend'        => true,
                        'entry_display'      => true
                    ));
        $propbag->add('configuration', array(
                        'permalink',
                        'pagetitle',
                        'headline',
                        'intro',
                        'formorder',
                        'numberitems',
                        'wordwrap',
                        'markup',
                        'emailadmin',
                        'targetmail',
                        'showemail',
                        'showcaptcha',
                        'showpage',
                        'showapp',
                        'automoderate',
                        'entrychecks',
                        'dateformat'
                    ));
        $propbag->add('author',       'Ian (Timbalu)');
        $propbag->add('version',      '3.32');
        $propbag->add('requirements', array(
                        'serendipity' => '0.7',
                        'smarty'      => '2.6.7',
                        'php'         => '5.0.0'
                    ));
        $propbag->add('stackable', false);
        $propbag->add('groups', array('FRONTEND_FEATURES', 'BACKEND_FEATURES'));
        
        $this->filter_defaults = array('words'   => '\[link(.*?)\];http://');
    }

    function cleanup() {
        global $serendipity;
    
        /* check possible config mismatch setting */
        if ( serendipity_db_bool($this->get_config('showapp')) === true && serendipity_db_bool($this->get_config('automoderate')) === true ) { 
            $this->set_config('automoderate', false);
            echo '<div class="serendipityAdminMsgError"><img class="backend_attention" src="' . $serendipity['serendipityHTTPPath'] . 'templates/default/admin/img/admin_msg_note.png" alt="" />';
            echo PLUGIN_GUESTBOOK_CONFIG_ERROR . '</div>';
            return false;
        }
        // Cleanup. Remove all empty configs on SAVECONF-Submit.
        serendipity_plugin_api::remove_plugin_value($this->instance, array('sessionlock', 'timelock', 'version', 'targetmail', 'pageurl', 'dynamic_fields', 'dynamic_fields_desc', 'formpopup', 'getdynfield', 'showdynfield'));

        return true;
    }

    function install() {
        $this->createTable();
    }

    /* event hook:::guestbook table install */
    function createTable() {
        global $serendipity;

        $q = "CREATE TABLE IF NOT EXISTS {$serendipity['dbPrefix']}guestbook (
                        id {AUTOINCREMENT} {PRIMARY},
                        ip varchar(15) default NULL,
                        name varchar(100),
                        homepage varchar(100),
                        email varchar(100),
                        body text, 
                        approved int(1) default 1,
                        timestamp int(10) {UNSIGNED} NULL) {UTF_8}";
    
        serendipity_db_schema_import($q);
    }

    function alter_db($db_config_version) { 
        global $serendipity;
        if ($db_config_version == '1.0') { 
            $q = "ALTER TABLE {$serendipity['dbPrefix']}guestbook CHANGE name name varchar(100)";
            serendipity_db_schema_import($q);
            $q = "DELETE FROM {$serendipity['dbPrefix']}config WHERE name LIKE '%serendipity_event_guestbook%/sessionlock' AND name LIKE '%serendipity_event_guestbook%/timelock'";
            serendipity_db_schema_import($q);
        } 
        if ($db_config_version == '2.0') { 
            $q = "ALTER TABLE {$serendipity['dbPrefix']}guestbook ADD COLUMN approved int(1) DEFAULT 1";
            serendipity_db_schema_import($q);
            $q = "DELETE FROM {$serendipity['dbPrefix']}config WHERE name LIKE '%serendipity_event_guestbook%/version'";
            serendipity_db_schema_import($q);
            $q = "DELETE FROM {$serendipity['dbPrefix']}config WHERE name LIKE '%serendipity_event_guestbook%/dynamic_fields'";
            serendipity_db_schema_import($q);
            $q = "DELETE FROM {$serendipity['dbPrefix']}config WHERE name LIKE '%serendipity_event_guestbook%/dynamic_fields_desc'";
            serendipity_db_schema_import($q);
            $q = "DELETE FROM {$serendipity['dbPrefix']}config WHERE name LIKE '%serendipity_event_guestbook%/formpopup'";
            serendipity_db_schema_import($q);
            $q = "DELETE FROM {$serendipity['dbPrefix']}config WHERE name LIKE '%serendipity_event_guestbook%/getdynfield'";
            serendipity_db_schema_import($q);
            $q = "DELETE FROM {$serendipity['dbPrefix']}config WHERE name LIKE '%serendipity_event_guestbook%/pageurl'";
            serendipity_db_schema_import($q);
            $q = "DELETE FROM {$serendipity['dbPrefix']}config WHERE name LIKE '%serendipity_event_guestbook%/showdynfield'";
            serendipity_db_schema_import($q);
            $q   = "DROP TABLE IF EXISTS {$serendipity['dbPrefix']}guestbook_dyn";
            serendipity_db_schema_import($q);                
        } 
    }
    
    /* event hook::guestbook table uninstall */
    function uninstall(&$propbag) {
        global $serendipity;
        
        if(isset($serendipity['guestbookdroptable']) === true) { 
            $q   = "DROP TABLE IF EXISTS {$serendipity['dbPrefix']}guestbook";
            if(serendipity_db_schema_import($q)) return true;                
        } else { 
            $adminpath = $_SERVER['PHP_SELF'].'?serendipity[adminModule]=event_display&serendipity[adminAction]=guestbook&serendipity[guestbookcategory]=';
            echo $this->backend_guestbook_questionaire(PLUGIN_GUESTBOOK_ADMIN_DROP_SURE . '<br />' . PLUGIN_GUESTBOOK_ADMIN_DUMP_SELF, $adminpath, 'gbdb', 'droptable');
            return false;
        } 
    }
    
    /* guestbook config items::$propbag->add('configuration') */
    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch ($name) {
           case 'permalink':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_GUESTBOOK_PERMALINK);
                $propbag->add('description', PLUGIN_GUESTBOOK_PERMALINK_BLAHBLAH);
                $propbag->add('default', $serendipity['rewrite'] != 'none'
                    ? $serendipity['serendipityHTTPPath'] . 'pages/guestbook.html'
                    : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/pages/guestbook.html');
                break;

            case 'pagetitle':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_GUESTBOOK_PAGETITLE);
                $propbag->add('description', PLUGIN_GUESTBOOK_PAGETITLE_BLAHBLAH);
                $propbag->add('default', 'guestbook');
                break;

            case 'headline':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_GUESTBOOK_HEADLINE);
                $propbag->add('description', PLUGIN_GUESTBOOK_HEADLINE_BLAHBLAH);
                $propbag->add('default', PLUGIN_GUESTBOOK_TITLE);
                break;

            case 'intro':
                $propbag->add('type', ($serendipity['wysiwyg'] === true ? 'html' : 'text'));
                $propbag->add('rows', 3);
                $propbag->add('name',        PLUGIN_GUESTBOOK_INTRO);
                $propbag->add('description', '');
                $propbag->add('default',     '');
                break;

            case 'formorder':
                $propbag->add('type',           'radio');
                $propbag->add('name',           PLUGIN_GUESTBOOK_FORMORDER);
                $propbag->add('description',    PLUGIN_GUESTBOOK_FORMORDER_BLAHBLAH);
                $propbag->add('radio',          array(
                                                    'value' => array('top', 'bottom'/*, 'popup'*/),
                                                    'desc'  => array(PLUGIN_GUESTBOOK_FORMORDER_TOP, PLUGIN_GUESTBOOK_FORMORDER_BOTTOM, PLUGIN_GUESTBOOK_FORMORDER_POPUP)
                                                ));
                $propbag->add('default',        'top');
                break;

            case 'numberitems':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_GUESTBOOK_NUMBER);
                $propbag->add('description', PLUGIN_GUESTBOOK_NUMBER_BLAHBLAH);
                $propbag->add('default', '10');
                break;

            case 'wordwrap':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_GUESTBOOK_WORDWRAP);
                $propbag->add('description', PLUGIN_GUESTBOOK_WORDWRAP_BLAHBLAH);
                $propbag->add('default', '120');
                break;

            case 'markup':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_GUESTBOOK_ARTICLEFORMAT);
                $propbag->add('description', PLUGIN_GUESTBOOK_ARTICLEFORMAT_BLAHBLAH);
                $propbag->add('default', 'true');
                break;

            case 'emailadmin':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_GUESTBOOK_EMAILADMIN);
                $propbag->add('description', PLUGIN_GUESTBOOK_EMAILADMIN_BLAHBLAH);
                $propbag->add('default', 'false');
                break;

            case 'targetmail':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_GUESTBOOK_TARGETMAILADMIN);
                $propbag->add('description', PLUGIN_GUESTBOOK_TARGETMAILADMIN_BLAHBLAH);
                $propbag->add('default', '');
                break;

            case 'showpage':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_GUESTBOOK_SHOWURL);
                $propbag->add('description', PLUGIN_GUESTBOOK_SHOWURL_BLAHBLAH);
                $propbag->add('default', 'false');
                break;

            case 'showemail':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_GUESTBOOK_SHOWEMAIL);
                $propbag->add('description', PLUGIN_GUESTBOOK_SHOWEMAIL_BLAHBLAH);
                $propbag->add('default', 'true');
                break;

            case 'showcaptcha':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_GUESTBOOK_SHOWCAPTCHA);
                $propbag->add('description', PLUGIN_GUESTBOOK_SHOWCAPTCHA_BLAHBLAH);
                $propbag->add('default', 'true');
                break;

            case 'showapp':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_GUESTBOOK_SHOWAPP);
                $propbag->add('description', PLUGIN_GUESTBOOK_SHOWAPP_BLAHBLAH);
                $propbag->add('default', 'false');
                break;
            
            case 'automoderate':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_GUESTBOOK_AUTOMODERATE);
                $propbag->add('description', PLUGIN_GUESTBOOK_AUTOMODERATE_BLAHBLAH);
                $propbag->add('default', 'false');
                break;
            
            case 'entrychecks':
                $propbag->add('type', 'text');
                $propbag->add('rows', 2);
                $propbag->add('name', PLUGIN_GUESTBOOK_FILTER_ENTRYCHECKS);
                $propbag->add('description', PLUGIN_GUESTBOOK_FILTER_ENTRYCHECKS_BLAHBLAH);
                $propbag->add('default', $this->filter_defaults['words']);
                break;
            
            case 'dateformat':
                $propbag->add('type', 'string');
                $propbag->add('name', GENERAL_PLUGIN_DATEFORMAT);
                $propbag->add('description', sprintf(GENERAL_PLUGIN_DATEFORMAT_BLAHBLAH, '%a, %m.%m.%Y %H:%M'));
                $propbag->add('default', '%a, %d.%m.%Y %H:%M');
                break;

            default:
                return false;

        }
        return true;
    }
    
    /* Try to make email address printing safe (protect from spammers) */
    function safeEmail($email) {
         global $serendipity;
         static $hide_email = null;
         
         if ($hide_email === null) {
             $hm = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}config WHERE name LIKE '%/hide_email'", true, 'assoc');
             if (is_array($hm) && isset($hm['value'])) {
                 $hide_email = serendipity_db_bool($hm['value']);
             } else {
                 $hide_email = false;
             }
         }
         
         if ($hide_email && serendipity_userLoggedIn()) return 'nospam@example.com';
         
         return str_replace(array('@', '.'), array(' at ', ' dot '), $email);
    }

    /* check if email is valid */
     function is_valid_email($postmail) { 
        // Email needs to match this pattern to be a good email address
        if (!empty($postmail)) { 
            return (preg_match(
                ":^([-!#\$%&'*+./0-9=?A-Z^_`a-z{|}~ ])+" .    // the user name
                "@" .                                        // the ubiquitous at-sign
                "([-!#\$%&'*+/0-9=?A-Z^_`a-z{|}~ ]+\\.)+" . // host, sub-, and domain names
                "[a-zA-Z]{2,6}\$:i",                         // top-level domain (TLD)
                trim($postmail)));                            // get rid of trailing whitespace
        } else
            return false;
    }
    
    /* return false, if content filter found something to strip */
    function strip_input($string) {
        global $serendipity;
        
        $stripped = strip_tags($string);
        // Filter Content
        $filter_bodys = explode(';', $this->get_config('entrychecks', $this->filter_defaults['words']));
        // filter body checks if not admin [serendipityUserlevel] => 255 && [serendipityAuthedUser] => 1
        // @ToDo: is there a need to make this accessible to admin group?
        if (is_array($filter_bodys) && (!serendipity_userLoggedIn() && !$_SESSION['serendipityAuthedUser'] === true && !$_SESSION['serendipityUserlevel'] == '255')) {
            foreach($filter_bodys AS $filter_body) {
                $filter_body = trim($filter_body);
                if (empty($filter_body)) {
                    continue;
                }
                if (preg_match('@(' . $filter_body . ')@i', $stripped, $wordmatch)) {
                    $serendipity['messagestack']['comments'][] = PLUGIN_EVENT_SPAMBLOCK_FILTER_WORDS . ': ' . $wordmatch[1];
                    return false;
                }
            }
        } else { 
            return true;
        }
    }

    /**
     * @param  $c   = count entries
     * @param  $ap  = approved yes/no = 1/0
     * @param  $pname = frontend Url with ? or & depending mod_rewrite settings
     * @param  $maxpp = max entries per page
     * 
     * @return entries array
     */
    function frontend_guestbook_paginator($c, $ap, $pname, $maxpp, $orderby) { 
        global $serendipity;
        
        if (isset($serendipity['GET']['guestbooklimit'])) { 
            $paginator = (int)$serendipity['GET']['guestbooklimit'];
        } else { 
            $paginator = 1;
        }
        if(!isset($maxpp) && !is_numeric($maxpp)) $maxpp = 15;
        $lastpage = ceil($c/$maxpp);
        
        $paginator = (int)$paginator;
        if ($paginator > $lastpage) { 
            $paginator = $lastpage;
        }
        if ($paginator < 1) { 
            $paginator = 1;
        }
        
        $cp = ($paginator - 1);
        $rp = $maxpp;
        $entries = $this->getEntriesDB($cp, $rp, $ap);
        
        if(is_array($entries)) { 
            $serendipity['guestbook']['paginator'] = '';
            $serendipity['guestbook']['paginator'] .= '<div class="frontend_guestbook_paginator">';
            
            if ($paginator == 1) { 
                $serendipity['guestbook']['paginator'] .= '<span class="frontend_guestbook_paginator_left"> FIRST | PREVIOUS </span>'."\n";
            } else { 
                $prevpage = $paginator-1;
                $serendipity['guestbook']['paginator'] .= '<span class="frontend_guestbook_paginator_left">';
                $serendipity['guestbook']['paginator'] .= ' <a href="'.$pname.'serendipity[guestbooklimit]=1"><input type="button" class="serendipityPrettyButton" name="FIRST" value="' . PAGINATOR_FIRST . '" /></a> | '."\n";
                $serendipity['guestbook']['paginator'] .= ' <a href="'.$pname.'serendipity[guestbooklimit]='.$prevpage.'"><input type="button" class="serendipityPrettyButton" name="PREVIOUS" value="' . PAGINATOR_PREVIOUS . ' " /></a> '."\n";
                $serendipity['guestbook']['paginator'] .= '</span>';
            }

            $serendipity['guestbook']['paginator'] .= '<span class="frontend_guestbook_paginator_center">  ( ' . PAGINATOR_PAGE . ' ' . $paginator . ' ' . PAGINATOR_OFFSET . ' ' . $lastpage . ' ) </span>'."\n";

            if ($paginator == $lastpage) { 
                $serendipity['guestbook']['paginator'] .= '<span class="frontend_guestbook_paginator_right"> NEXT | LAST </span>'."\n";
            } else { 
                $nextpage = $paginator+1;
                $serendipity['guestbook']['paginator'] .= '<span class="frontend_guestbook_paginator_right">';
                $serendipity['guestbook']['paginator'] .= ' <a href="'.$pname.'serendipity[guestbooklimit]='.$nextpage.'"><input type="button" class="serendipityPrettyButton" name="NEXT" value="' . PAGINATOR_NEXT . '" /></a> | '."\n";
                $serendipity['guestbook']['paginator'] .= ' <a href="'.$pname.'serendipity[guestbooklimit]='.$lastpage.'"><input type="button" class="serendipityPrettyButton" name="LAST" value="' . PAGINATOR_LAST . '" /></a> '."\n";
                $serendipity['guestbook']['paginator'] .= '</span>';
            } 
            
            $serendipity['guestbook']['paginator'] .= '</div>';
            $serendipity['guestbook']['paginator'] .= "\n";
        }
        return is_array($entries) ? $entries : false;
    } // function frontend paginator end


    /* this function is a s9y plugin standard starter. */
    function selected() {
        global $serendipity;

        if (!empty($serendipity['POST']['subpage'])) {
            $serendipity['GET']['subpage'] = $serendipity['POST']['subpage'];
        }

        if ($serendipity['GET']['subpage'] == $this->get_config('pagetitle') ||
            preg_match('@^' . preg_quote($this->get_config('permalink')) . '@i', $serendipity['GET']['subpage'])) {
            return true;
        }

        return false;
    }

    /* BBCode replacements */
    function text_pattern_bbc($text) { 
        $patterns = array(
            "/\[b\](.*?)\[\/b\]/",
            "/\[u\](.*?)\[\/u\]/",
            "/\[i\](.*?)\[\/i\]/",
            "/\[s\](.*?)\[\/s\]/",
            "/\[q\](.*?)\[\/q\]/",
            "/\[ac\](.*?)\[\/ac\]/"
        );
        $replacements = array(
            "<strong>\\1</strong>",
            "<u>\\1</u>",
            "<em>\\1</em>",
            "<del>\\1</del>",
            "<q>\\1</q>",
            "<br /><span class='guestbook_admin_comment'><blockquote cite='#'><p>\\1</p></blockquote></span>"
        );
        return preg_replace($patterns, $replacements, $text);
    }

    /* get the right template path - as default in template folder or the fallback plugin folder */
    function fetchTemplatePath($filename) { 
        global $serendipity;
        $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
        if (!$tfile || $filename == $tfile) { 
            $tfile = dirname(__FILE__) . '/' . $filename;
        }
        $inclusion = $serendipity['smarty']->security_settings[@INCLUDE_ANY];
        $serendipity['smarty']->security_settings[@INCLUDE_ANY] = true;
        $content = $serendipity['smarty']->fetch('file:'. $tfile);
        $serendipity['smarty']->security_settings[@INCLUDE_ANY] = $inclusion;
        return $content;
    }

    /* This function is used for sidebar plugins only - the $title variable is somehow important to indicate the title of a plugin in the plugin configuration manager. */
    /* do we need to set this to headline now? */
    function generate_content(&$title) {
        $title = PLUGIN_GUESTBOOK_TITLE.' (' . $this->get_config('pagetitle') . ')';
    }
    
    function generate_EntriesArray($entries, $is_guestbook_url, $wordwrap) { 
        global $serendipity;
    
        /* this assigns db entries output to guestbooks smarty entries.tpl */
        if (is_array($entries)) {
            foreach($entries AS $i => $entry) {
                /* entry items */
                $entry['email']               = $this->safeEmail($entry['email']);
                $entry['name']                = $entry['name'];
                $entry['homepage']            = !empty($entry['homepage']) && strpos($entry['homepage'],'http://') !== 0 && strpos($entry['homepage'],'https://') !== 0
                                              ? 'http://' . $entry['homepage']
                                              : $entry['homepage'];
                $entry['pluginpath']          = $serendipity['serendipityHTTPPath'] . $serendipity['guestbook']['pluginpath'];
                $entry['timestamp']           = strftime($this->get_config('dateformat'), (int)$entry['timestamp']); // mysql would use SELECT *, FROM_UNIXTIME(timestamp) AS ts FROM `s9y_guestbook`

                $entry['page']                = $is_guestbook_url . (($serendipity['rewrite'] == 'rewrite') ? '?' : '&') . 'noclean=true&serendipity[adminAction]=guestbookdelete&serendipity[page]=' . (int)$serendipity['GET']['page'] . '&serendipity[gbid]=' . $entry['id'];
                

                if (serendipity_db_bool($this->get_config('markup'))) {
                    /* parse  $entry['text'] through hook events standard formatting and smilies */
                    $markup = array('body' => $entry['body']);
                    serendipity_plugin_api::hook_event('frontend_display', $markup, 'body');
                    $entry['body']             = wordwrap($markup['body'], $wordwrap, "\n", 1);
                } else {
                    $entry['bodywrap']         = wordwrap($entry['body'], $wordwrap, "\n", 1);
                    $entry['body']             = nl2br($entry['bodywrap']);
                }
                $entry['body']                = $this->text_pattern_bbc($entry['body']);
                /* if there are whitespaces (*) in admin comment quotes [q]*, function text_pattern_bbc [ac] and [q] had no effect [ToDo: tweak text_pattern_bbc()] */
                $entry['body'] = str_replace( 
                                        array("[ac]", "[/ac]", "[q]", "[/q]"), 
                                        array('<br /><span class="guestbook_admin_comment"><blockquote cite="#"><p>', '</p></blockquote></span>', '<q>', '</q>'), 
                                        $entry['body']
                                    );

                $entries[$i] = $entry;
            }
        }
        return is_array($entries) ? $entries : false;
    }

    /* guestbook entries into db */
    function insertEntriesDB($id=false, $ip=false, $name, $url, $email, $body, $app=false, $ts=false, $chen=false) {
        global $serendipity;

        /* make php to current unix timestamp to insert into db */
        $ip    = isset($ip)  ? $ip   : serendipity_db_escape_string($_SERVER['REMOTE_ADDR']);
        $app   = isset($app) ? (int)$app  : (serendipity_db_bool($this->get_config('showapp')) ? 0 : 1);
        $ts    = isset($ts)  ? $ts   : time();
        
        $name  = serendipity_db_escape_string(substr($name, 0, 29));
        $url   = serendipity_db_escape_string(substr($homepage, 0, 99));
        $email = serendipity_db_escape_string(substr($email, 0, 99));
        $body  = serendipity_db_escape_string($body);

        if($chen === false) { 
            // normal setting
            $sql = sprintf("INSERT
                    INTO %sguestbook ( ip, name, homepage, email, body, approved, timestamp )
                    VALUES          ( '%s', '%s', '%s', '%s', '%s', %s,  %s)",
                        $serendipity['dbPrefix'], $ip, $name, $url, $email, $body, $app, $ts
                    );
        } else { 
            // replace settings
            $sql = "REPLACE {$serendipity['dbPrefix']}guestbook SET id=$id, ip='$ip', name='$name', homepage='$url', email='$email', body='$body', approved='$app', timestamp='$ts'";
        }

        $dbdone = serendipity_db_query($sql, true, 'both', true);

        if ($dbdone) {
            /* if set, send an Email to the Admin $serendipity['email'] */
            if (!serendipity_db_bool($this->get_config('emailadmin'))) {
                return false;
            } elseif (!$this->get_config('targetmail') || $this->get_config('targetmail') != '') {
                return @serendipity_sendMail($this->get_config('targetmail'), TEXT_EMAILSUBJECT, sprintf(TEXT_EMAILTEXT,$name, $body), $email);
            }
            return true;
        }
    }


    /* guestbook entries count db */
    function countEntriesDB($ap) {
        global $serendipity;

        $whe = (serendipity_db_bool($this->get_config('showapp')) || serendipity_db_bool($this->get_config('automoderate'))) ? "WHERE approved=$ap" : '';

        /* count guestbook entries to make entries paging */
        $sql = "SELECT count(*) AS counter FROM {$serendipity['dbPrefix']}guestbook $whe";
        $maxres = serendipity_db_query($sql, true);

        return is_array($maxres) ? $maxres : false;
    }


    /* guestbook entries get db */
    function getEntriesDB($cp, $rp, $ap) {
        global $serendipity;
        
        $whe = (serendipity_db_bool($this->get_config('showapp')) || serendipity_db_bool($this->get_config('automoderate'))) ? "WHERE approved=$ap" : '';

        /* generate guestbook entries and send them to entries template */
        $sql = "SELECT * FROM {$serendipity['dbPrefix']}guestbook $whe ORDER BY timestamp DESC ";
        $entries = serendipity_db_query($sql . serendipity_db_limit_sql(
                                        serendipity_db_limit(
                                            $cp * $rp, $rp
                                        )
                                    )
                                );
        return is_array($entries) ? $entries : false;
    }


    /* guestbook form post checks */
    function checkSubmit() {
        global $serendipity;
        global $messages;

        if (!is_array($messages)) {
            $messages = array();
        }

        $valid['captcha']     = FALSE;
        $valid['data_length'] = FALSE;
        $valid['data_email']  = FALSE;
        $valid['message']     = FALSE;
        $serendipity['guestbook_message_header'] = FALSE;

        if (empty($serendipity['POST']['guestbookform'])) {
            return false;
        }

        if (!isset($serendipity['POST']['email']) || empty($serendipity['POST']['email'])) {
            $serendipity['POST']['email'] = 'nospam@example.com';
        }
    
        if (empty($serendipity['POST']['name']) && empty($serendipity['POST']['email']) && empty($serendipity['POST']['comment'])) {
            array_push($messages,  PLUGIN_GUESTBOOK_MESSAGE . ': ' . PLUGIN_GUESTBOOK_ERROR_DATA . ' - ' . ERROR_NOINPUT);
            return false;
        }

        if ( (!$serendipity['POST']['email']) || (!$serendipity['POST']['name']) || (!$serendipity['POST']['comment']) ) {
            array_push($messages, ERROR_NOINPUT);
            return false;
        }

        /* Fake call to spamblock and other comment plugins, if not in backend. */      
        $ca = array(
                    'id'                    => 0,
                    'allow_comments'        => true,
/*                    'moderate_comments'     => true, dont use here, while it overrides spamblock option setting */
                    'last_modified'         => time(),
                    'timestamp'             => strtotime("-8 day" ,time()) /* remember captchas_ttl using 7 days as normal setting, just 10 sec. throws Moderation after X days */
                    );
        
        if(!is_numeric($_POST['guestbook']['id'])) {
            $commentInfo = array(      
                    'type'        => 'NORMAL',
                    'source'      => 'guestbookform',
                    'name'        => $serendipity['POST']['name'],
                    'email'       => $serendipity['POST']['email'],
                    'url'         => $serendipity['POST']['url'],
                    'comment'     => $serendipity['POST']['comment']
                    );
           
            serendipity_plugin_api::hook_event('frontend_saveComment', $ca, $commentInfo);
        } // End of fake call.
        
        /* listen to Spamblock Plugin and do some specific guestbook checks, if captchas and entry were alowed */
        if (serendipity_db_bool($ca['allow_comments']) === true) { 
        
            if (trim($serendipity['POST']['name']) == '') {
                array_push($messages, ERROR_NAMEEMPTY);
            }

            if (isset($serendipity['POST']['url'])) {
                $serendipity['POST']['url'] = trim($serendipity['POST']['url']);
            }

            if (trim($serendipity['POST']['comment']) == '') {
                array_push($messages, ERROR_TEXTEMPTY);
            }

            if (trim($serendipity['POST']['email']) == '') {
                array_push($messages, ERROR_EMAILEMPTY);
            }

            if ( (strlen(trim($serendipity['POST']['name'])) < 3) || (strlen(trim($serendipity['POST']['comment'])) < 10) ) {
                array_push($messages, ERROR_DATATOSHORT);
            } else {
                $valid['data_length'] = TRUE;
            }

            if( $this->strip_input($serendipity['POST']['comment']) === false ) {
                array_push($messages, ERROR_DATANOTAGS . ' ' . $serendipity['messagestack']['comments'][0]);
                if(!empty($serendipity['messagestack']['comments'][0])) { 
                    unset($serendipity['messagestack']['comments']);
                }
            }
        
            if (isset($serendipity['POST']['email']) && !empty($serendipity['POST']['email']) && trim($serendipity['POST']['email']) != '') {
                if ( !$this->is_valid_email($serendipity['POST']['email']) ) {
                    array_push($messages, ERROR_NOVALIDEMAIL . ' <span class="guestbook_error_red">' . htmlspecialchars($serendipity['POST']['email']) . '</span>');
                } else {
                    $valid['data_email'] = TRUE;
                }
            }

            if (isset($serendipity['POST']['captcha']) && !empty($serendipity['POST']['captcha'])) {
                if (serendipity_db_bool($ca['allow_comments']) === true || strtolower($serendipity['POST']['captcha']) == strtolower($_SESSION['spamblock']['captcha'])) {
                    $valid['captcha'] = TRUE;
                } elseif (!serendipity_userLoggedIn()) {
                    if ($serendipity['csuccess'] != 'moderate') {
                        array_push($messages, ERROR_ISFALSECAPTCHA);
                    } /*else {
                        array_push($messages, $serendipity['moderate_reason'] . PLUGIN_GUESTBOOK_AUTOMODERATE_ERROR . PLUGIN_GUESTBOOK_DBDONE_APP);
                    }*/
                }
            }

            /* Captcha checking - if set to FALSE in guestbook config and spamblock plugin catchas is set to no, follow db insert procedure */
            if (!serendipity_db_bool($this->get_config('showcaptcha'))) {
                if (!isset($_SESSION['spamblock']['captcha']) || !isset($serendipity['POST']['captcha']) || strtolower($serendipity['POST']['captcha']) != strtolower($_SESSION['spamblock']['captcha'])) {
                    $valid['captcha'] = TRUE;
                }
            } 

            if (serendipity_userLoggedIn() && $_SESSION['serendipityAuthedUser'] === true) {
                $valid['captcha']      = TRUE;
                $valid['data_length']  = TRUE;
                $valid['data_email']   = TRUE;
            }

            // spamblock allows comments end
        } else { 
            /* drop entry back to form - beware 'allow_comments' return value is empty, not false, if false */
            array_push($messages,  PLUGIN_GUESTBOOK_MESSAGE . ': ' . PLUGIN_GUESTBOOK_ERROR_DATA);      
        }
        // set valid messages to true, if no errors occured
        $valid['message'] = (count($messages) < 1) ? TRUE : FALSE;

        // no errors and messages
        if ( $valid['message'] === true ) { 
            // set var, if not set by backend form
            if ( !is_numeric($_POST['guestbook']['approved']) ) $_POST['guestbook']['approved'] = '';
            if ( is_numeric($_POST['guestbook']['id']) ) $_POST['guestbook']['approved'] = 1;
            
            /* allow the spamblock wordfilter plugin to set an entry as non-approved, 
               accordingly to stopwords and content filter set to 'moderation' in spamblock plugin. 
               extends new auto-moderate option setting to true in guestbooks config */
            /* keep this for future finetuning via SPAMBLOCK plugin */
            if (array_key_exists('moderate_comments', $ca) ) { 
            
                if (serendipity_db_bool($ca['moderate_comments']) === true && serendipity_db_bool($this->get_config('automoderate')) === true) { 
                    // set entries to get approved in backend, before they can appear in frontent
                    $_POST['guestbook']['approved'] = 0; 
                }
            }
        }

        /* write new entry into database, if input is valid */
        if ( !empty($serendipity['POST']['guestbookform']) 
                                                && $valid['captcha'] === true
                                                && $valid['data_length'] === true
                                                && $valid['data_email'] === true
                                                && $valid['message'] === true) {

            $admincomment = (!empty($serendipity['POST']['admincomment'])) ? '[ac] ' . $serendipity['POST']['admincomment'] . ' [/ac]' : '';
            $acapp        = (serendipity_userLoggedIn() && $_SESSION['serendipityAuthedUser'] === true) ? 1 : NULL;
            $acapp        = is_numeric($_POST['guestbook']['approved']) ? $_POST['guestbook']['approved'] : $acapp;
            
            if(is_numeric($_POST['guestbook']['id'])) { 
                /* update validated form values into db */
                $this->insertEntriesDB($_POST['guestbook']['id'], $_POST['guestbook']['ip'], $serendipity['POST']['name'], $serendipity['POST']['url'], $serendipity['POST']['email'], $serendipity['POST']['comment'].$admincomment, $_POST['guestbook']['approved'], $_POST['guestbook']['timestamp'], true);
            } else { 
                /* insert validated form values into db */
                $this->insertEntriesDB(NULL, NULL, $serendipity['POST']['name'], $serendipity['POST']['url'], $serendipity['POST']['email'], $serendipity['POST']['comment'], $acapp, NULL, false);
            }

            /* reset post values */
            unset($serendipity['POST']);

            if (!is_array($messages)) { 
                $messages = array();
            }

            /* claim insertEntriesDB is true */
            $showapptxt = (serendipity_db_bool($this->get_config('showapp')) && !serendipity_userLoggedIn()) ? ' ' . PLUGIN_GUESTBOOK_DBDONE_APP : '';
            if ($serendipity['csuccess'] == 'moderate') {
                $showapptxt = '<br />' . $serendipity['moderate_reason'] . '<br />' . PLUGIN_GUESTBOOK_AUTOMODERATE_ERROR . PLUGIN_GUESTBOOK_DBDONE_APP;
            }
            array_push($messages, PLUGIN_GUESTBOOK_MESSAGE . ': ' . PLUGIN_GUESTBOOK_DBDONE . $showapptxt );
            $serendipity['guestbook_message_header'] = true;

            /* set startpage back to 1 */
            $serendipity['GET']['page'] = 1;

            if ($serendipity['guestbook_message_header'] === false) {
                array_push($messages, PLUGIN_GUESTBOOK_UNKNOWN_ERROR);
                return false;
            }
            // validate & insert into db end
        }
    }

    /* make guestbook output page */
    function generate_Page() {
        global $serendipity;
        global $messages;

        if ($this->selected()) {
            if (!is_array($messages)) {
                $messages = array();
            }

            if (!headers_sent()) {
                header('HTTP/1.0 200');
                header('Status: 200 OK');
            }

            /* case export mysql dump file - and send to external_plugin hook */
            if($_POST['guestbook']['bedownload']) { 
                $url = $_POST['guestbook']['bedownload'];
                if($url) header('Location: http://' . $_SERVER['HTTP_HOST'] . $url);
            }

            /* Carl wanted the staticpage_pagetitle - see s9y-1.1 new hemingway theme index.tpl {$staticpage_pagetitle} */
            $serendipity['smarty']->assign(
              array(
                  'staticpage_headline'  => $this->get_config('headline'),
                  'staticpage_pagetitle' => preg_replace('@[^a-z0-9]@i', '_',$this->get_config('pagetitle')),
                  'staticpage_formorder' => $this->get_config('formorder')
              )    
            );

            if (isset($serendipity['POST']['guestbookform']) == true) {
                /* check form vars */
                $this->checkSubmit();
        
                if (count($messages) < 1 && $serendipity['guestbook_message_header'] === false) {
                    array_push($messages, PLUGIN_GUESTBOOK_MESSAGE . ': ' . ERROR_UNKNOWN . '<br />' . ERROR_NOCAPTCHASET);
                }
            }
        
            /* generate frontend admin header section - if user logged in and action == delete entry */
            if (!empty ($serendipity['GET']['adminAction']) && $_SESSION['serendipityAuthedUser'] === true) {
                // use permalink generally instead of subpage
                $is_guestbook_url  = ($serendipity['rewrite'] != 'errordocs') ? $this->get_config('permalink') : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?serendipity[subpage]=' . $this->get_config('pagetitle');
                
                switch($serendipity['GET']['adminAction']) {
                    case 'guestbookdelete':
                        $serendipity['smarty']->assign(
                                array(
                                    'admin_delete'        => true,
                                    'admin_url'           => $is_guestbook_url . (($serendipity['rewrite'] == 'rewrite') ? '?' : '&') . 'serendipity[page]=' . (int)$serendipity['GET']['page'],
                                    'admin_target'        => $is_guestbook_url . (($serendipity['rewrite'] == 'rewrite') ? '?' : '&') . 'serendipity[adminAction]=doDelete&serendipity[page]=' . (int)$serendipity['GET']['page'] . '&serendipity[gbid]=' . (int)$serendipity['GET']['gbid'],
                                    'delete_sure'         => sprintf(DELETE_SURE, (int)$serendipity['GET']['gbid'])
                                )
                        );
                        break;

                    case 'doDelete':
                        $sql = sprintf("DELETE from %sguestbook WHERE id = %s", $serendipity['dbPrefix'], (int)$serendipity['GET']['gbid']);
                        serendipity_db_query($sql);
                    
                        $url = $is_guestbook_url . (($serendipity['rewrite'] == 'rewrite') ? '?' : '&') . 'serendipity[page]=' . (int)$serendipity['GET']['page'] . '&serendipity[ripped]=' . (int)$serendipity['GET']['gbid'] . '#ripped';
                        header('Status: 302 Found');
                        header('Location: ' . $url);
                        exit;
                        break;

                    default:
                        return false;
                        break;
                }
            }

            if ((int)$serendipity['GET']['ripped']) { 
                $serendipity['smarty']->assign(
                    array(
                        'admin_dodelete'   => true,
                        'rip_entry'        => sprintf(RIP_ENTRY, (int)$serendipity['GET']['ripped'])
                    )
                );
            }
            
            /* call the form page output function */
            $this->generate_EntriesPage();
            $this->generate_FormPage();

            /* get the guestbook entries template file */
            echo $this->fetchTemplatePath('plugin_guestbook_entries.tpl');
        }
    } // generate_Page end

    /* make guestbook form */
    function generate_FormPage() {

        global $serendipity;
        global $messages;

        if (serendipity_db_bool($this->get_config('showemail'))) {
            $serendipity['smarty']->assign('is_show_mail', true);
        }

        if (serendipity_db_bool($this->get_config('showpage'))) {
            $serendipity['smarty']->assign('is_show_url', true);
        }

   
        /* assign form array entries to smarty */
        $serendipity['smarty']->assign(
                array(
                    'plugin_guestbook_articleformat'   => (serendipity_db_bool($this->get_config('markup')) ? true : false),
                    'plugin_guestbook_intro'           => $this->get_config('intro'),
                    'plugin_guestbook_sent'            => $this->get_config('sent', PLUGIN_GUESTBOOK_SENT_HTML),
                    'plugin_guestbook_action'          => $serendipity['baseURL'] . $serendipity['indexFile'],
                    'plugin_guestbook_sname'           => htmlspecialchars($serendipity['GET']['subpage']),
                    'plugin_guestbook_name'            => htmlspecialchars(strip_tags($serendipity['POST']['name'])),
                    'plugin_guestbook_email'           => htmlspecialchars(strip_tags($serendipity['POST']['email'])),
                    'plugin_guestbook_emailprotect'    => PLUGIN_GUESTBOOK_PROTECTION,
                    'plugin_guestbook_url'             => htmlspecialchars(strip_tags($serendipity['POST']['url'])),
                    'plugin_guestbook_comment'         => htmlspecialchars(strip_tags($serendipity['POST']['comment'])),
                    'plugin_guestbook_messagestack'    => $serendipity['messagestack']['comments'],
                    'plugin_guestbook_entry'           => array('timestamp' => 1)
                )
        );

        /* get the form page template file */
        $conform =  $this->fetchTemplatePath('plugin_guestbook_form.tpl');
        $serendipity['smarty']->assign('GUESTBOOK_FORM', $conform);
        // generate_FormPage() end
    }


    /* make guestbook entries */
    function generate_EntriesPage($ap=1) {

        global $serendipity;
        global $messages;

        if (!is_array($messages)) {
            $messages = array();
        }

        /* max entries per page */
        $max_entries = $this->get_config('numberitems');

        if (!is_numeric($max_entries)) {
            $max_entries = 5;
        }

        $wordwrap = $this->get_config('wordwrap');

        if (!is_numeric($wordwrap)) {
            $wordwrap = 50;
        }

        // use permalink generally instead of subpage
        $is_guestbook_url  = ($serendipity['rewrite'] != 'errordocs') ? $this->get_config('permalink') : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?serendipity[subpage]=' . $this->get_config('pagetitle');
        
        /* if entry send is ok OR user just views guestbook entries :: run SQL */
        if ($serendipity['guestbook_message_header'] === true || empty($serendipity['POST']['guestbookform'])) {

            /* count db entries as array: [$maxres] */
            $maxres = $this->countEntriesDB($ap);
            
            $url = $is_guestbook_url . (($serendipity['rewrite'] == 'rewrite') ? '?' : '&');
            /* generate $entries array and frontend pagination */
            $entries = is_array($maxres) ? $this->frontend_guestbook_paginator($maxres[0], $ap, $url, $max_entries, 'timestamp ASC') : false;

            /* this assigns $entries and paging output to plugin_guestbooks_entries.tpl */
            $serendipity['smarty']->assign(array(
                'guestbook_entry_paging'         => true,
                'guestbook_userLoggedIn'         => false, /* keep var for old user templates */
                'guestbook_paging'               => $serendipity['guestbook']['paginator']
            ));
        } 
        
        $serendipity['smarty']->assign('is_guestbook_url', $is_guestbook_url);
        
        /* this assigns db entries output to guestbooks smarty array: [$entries] in entries.tpl */
        $entries = $this->generate_EntriesArray($entries, $is_guestbook_url, $wordwrap);
    
        /* Output all possible messages and errors */
        if (is_array($messages) && count($messages) > 0) {
            $serendipity['smarty']->assign(
                    array(
                        'is_guestbook_message'     => true,
                        'error_occured'            => ERROR_OCCURRED
                    )
            );

            if ($serendipity['guestbook_message_header'] === true) {
                $serendipity['smarty']->assign(
                    array(
                        'is_guestbook_message'     => true,
                        'error_occured'            => THANKS_FOR_ENTRY
                    )
                );
            }
        }

        if ($serendipity['guestbook_message_header'] === true || empty($serendipity['POST']['guestbookform'])) {
            /* assign entries array and good messages array to smarty - beware just using smarty {entries} it is used by default */
            $serendipity['smarty']->assign(
                    array(
                        'guestbook_messages'    => $messages,
                        'guestbook_entries'     => $entries
                    )
            );
        } else {
            /* assign bad messages array to smarty */
            $serendipity['smarty']->assign(
                    array(
                        'guestbook_messages'     => $messages
                    )
            );
        }
    } /* function generate_EntriesPage() end */


    /* event hook items::$propbag->add('event_hooks') */
    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        $serendipity['plugin_guestbook_version'] = &$bag->get('version');
        
        /* set global plugin path setting, to avoid different pluginpath '/plugins/' as plugins serendipity vars */
        if(!isset($serendipity['guestbook']['pluginpath'])) { 
            $pluginpath = pathinfo(dirname(__FILE__));
            $serendipity['guestbook']['pluginpath'] = basename(rtrim($pluginpath['dirname'], '/')) . '/serendipity_event_guestbook/';
        }

        if (isset ($hooks[$event])) {

            switch ($event) {

                case 'frontend_configure':
        
                    /* checking if db tables exists, otherwise install them */
                    $cur = '';
                    $old = $this->get_config('version', '', false);
                    
                    if($old == '1.0') $cur = $old;
                    
                    if( empty($cur) && ( !empty($old) ||($old == '' && $old != false) ) ) { 
                        $cur = '2.0';
                    } else { 
                        $cur = $this->get_config('dbversion');
                    }
                    if($cur == '1.0') { 
                        $this->alter_db($cur);
                        $this->set_config('dbversion', '2.0');
                    } elseif($cur == '2.0') { 
                        $this->alter_db($cur);
                        $this->set_config('dbversion', '3.0');
                        $this->cleanup();
                    } elseif($cur == '3.0') { 
                        continue;
                    } else { 
                        $this->install();
                        $this->set_config('dbversion', '3.0');
                    }
                    break;

                case 'genpage':
                    $args = implode('/', serendipity_getUriArguments($eventData, true));
                    if ($serendipity['rewrite'] != 'none') {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $args;
                    } else {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/' . $args;
                    }

                    if (empty($serendipity['GET']['subpage'])) {
                        $serendipity['GET']['subpage'] = $nice_url;
                    }
                    
                    if ($this->selected()) {
                        $serendipity['head_title']    = $this->get_config('headline');
                        $serendipity['head_subtitle'] = htmlspecialchars($serendipity['blogTitle']);
                    }

                    break;

                case 'entry_display':
                    if ($this->selected()) { 
                        /* This is important to not display an entry list! */
                        if (is_array($eventData)) {
                                $eventData['clean_page'] = true; 
                        } else {
                            $eventData = array('clean_page' => true);
                        }
                    }

                    if (version_compare($serendipity['version'], '0.7.1', '<=')) {
                        $this->generate_Page();
                    }

                    return true;
                    break;

                case 'entries_header':
                    /* this one really rolls up output: check form submit, generate entries and form */
                    $this->generate_Page();
    
                    return true;
                    break;

                case 'external_plugin':
                    // [0]=guestbookdlsql; [1]=filename;
                    $gb['export'] = explode('/', $eventData); 
                    
                    if($gb['export'][0] == 'guestbookdlsql') { 
                        $file = file_get_contents ($serendipity['serendipityPath'] . 'templates_c/guestbook/'.$gb['export'][1]);
                        echo $file;
                        header('Status: 302 Found');
                        header('Content-Type: application/octet-stream; charset=UTF-8'); // text/plain to see as file in browser
                        header('Content-Disposition: inline; filename='.$gb['export'][1]);
                    }
                    break;
                    
                /* put here all you css stuff you need for frontend guestbook pages */
                case 'css':
                    
                    if (stristr($eventData, '#guestbook_wrapper')) { 
                        // class exists in CSS, so a user has customized it and we don't need default
                        return true;
                    }
                    
                    $tfile = serendipity_getTemplateFile('style_guestbook_frontend.css', 'serendipityPath');
                    if($tfile) { 
                        $search       = array('{TEMPLATE_PATH}', '{PLUGIN_PATH}');
                        $replace      = array('templates/' . $serendipity['defaultTemplate'] . '/', $serendipity['guestbook']['pluginpath']);
                        $tfilecontent = str_replace($search, $replace, @file_get_contents($tfile));
                    }
                    
                    if (!$tfile || $tfile == 'style_guestbook_frontend.css') { 
                        $tfile        = dirname(__FILE__) . '/style_guestbook_frontend.css';
                        $search       = array('{TEMPLATE_PATH}', '{PLUGIN_PATH}');
                        $tfilecontent = str_replace($search, $serendipity['guestbook']['pluginpath'], @file_get_contents($tfile));
                    }
                    if(!empty($tfilecontent)) $this->cssEventData($eventData, $tfilecontent);

                    return true;
                    break;
                
                case 'backend_sidebar_entries':
                    
                    // forbid sidebar link if user is not in admin group level
                    if ($serendipity['serendipityUserlevel'] < USERLEVEL_ADMIN) {
                        return false;
                    }
                    echo '<li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=guestbook">' . PLUGIN_GUESTBOOK_ADMIN_NAME . '</a></li>';
                    
                    return true;
                    break;

                case 'backend_sidebar_entries_event_display_guestbook':
                    
                    // forbid entry access if user is not in admin group level
                    if ($serendipity['serendipityUserlevel'] < USERLEVEL_ADMIN) {
                        return false;
                    }
                    /* show backend administration menu */
                    $this->backend_guestbook_menu();
                    
                    return true;
                    break;

                /* put here all you css stuff you need for the backend of guestbook pages */
                case 'css_backend':
                    
                    if (stristr($eventData, '#backend_guestbook_wrapper')) { 
                        // class exists in CSS, so a user has customized it and we don't need default
                        return true;
                    }
                    $tfile = serendipity_getTemplateFile('style_guestbook_backend.css', 'serendipityPath');
                    if($tfile) { 
                        $search       = array('{TEMPLATE_PATH}', '{PLUGIN_PATH}');
                        $replace      = array('templates/' . $serendipity['defaultTemplate'] . '/', $serendipity['guestbook']['pluginpath']);
                        $tfilecontent = str_replace($search, $replace, @file_get_contents($tfile));
                    }
                    
                    if ( (!$tfile || $tfile == 'style_guestbook_backend.css') && !$tfilecontent ) { 
                        $tfile        = dirname(__FILE__) . '/style_guestbook_backend.css';
                        $search       = array('{TEMPLATE_PATH}', '{PLUGIN_PATH}');
                        $tfilecontent = str_replace($search, $serendipity['guestbook']['pluginpath'], @file_get_contents($tfile));
                    }
                    
                    // add replaced css content to the end of serendipity_admin.css
                    if(!empty($tfilecontent)) $this->cssEventData($eventData, $tfilecontent);

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

    /***************************************************
     * Backend administration functions
     **************************************************/
     
    /* add front- and backend css to serendipity(_admin).css */
    function cssEventData(&$eventData, &$becss) { 
        $eventData .= $becss;
    }

    /**
     * main admin backend function
     * 
     * switch to selected navigation parts of $serendipity['GET']['guestbookcategory']
     * parts: view, add, approve, admin panel
     *
     **/
    function backend_guestbook_menu() { 
        global $serendipity;
        global $messages;
        
        if (!is_object($serendipity['smarty'])) { 
            serendipity_smarty_init(); // if not set to avoid member function assign() on a non-object error, start Smarty templating
        }
        
        $moderate   = ( serendipity_db_bool($this->get_config('showapp')) || serendipity_db_bool($this->get_config('automoderate')) ) ? true : false;
        $attention  = '<img class="backend_attention" src="' . $serendipity['serendipityHTTPPath'] . 'templates/default/admin/img/admin_msg_note.png" alt="" />';
        $gbcat      = !empty($serendipity['GET']['guestbookcategory']) ? $serendipity['GET']['guestbookcategory'] : $serendipity['POST']['guestbookcategory'];
        
        echo "\n<div id='backend_guestbook_wrapper'>\n\n";
        
        echo '<div class="backend_guestbook_menu"><h3>'. sprintf(PLUGIN_GUESTBOOK_ADMIN_NAME_MENU,  $serendipity['plugin_guestbook_version']) .'</h3></div>'."\n";

        if (!isset($serendipity['POST']['guestbookadmin'])) { 
            echo '
<div class="backend_guestbook_nav">
<ul>
<li '.(@$serendipity['GET']['guestbookcategory'] == 'gbview' ? 'id="active"' : '').'><a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=guestbook&amp;serendipity[guestbookcategory]=gbview">'.PLUGIN_GUESTBOOK_ADMIN_VIEW.'</a></li>
';
            if ($moderate === true) { 
            echo '
<li '.((@$serendipity['GET']['guestbookcategory'] == 'gbapp' || @$serendipity['POST']['guestbook_category'] == 'gbapp') ? 'id="active"' : '').'><a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=guestbook&amp;serendipity[guestbookcategory]=gbapp">'.PLUGIN_GUESTBOOK_ADMIN_APP.'</a></li>
';
            } 
            echo '
<li '.(((@$serendipity['GET']['guestbookcategory'] == 'gbadd' || @$serendipity['POST']['guestbookcategory'] == 'gbadd') && @$serendipity['POST']['guestbook_category'] != 'gbapp') ? 'id="active"' : '').'><a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=guestbook&amp;serendipity[guestbookcategory]=gbadd">'.PLUGIN_GUESTBOOK_ADMIN_ADD.'</a></li>
<li '.(@$serendipity['GET']['guestbookcategory'] == 'gbdb' ? 'id="active"' : '').'><a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=guestbook&amp;serendipity[guestbookcategory]=gbdb">'.PLUGIN_GUESTBOOK_ADMIN_DBC.'</a></li>
</ul>
</div>
            '."\n";
        }
        
        /* assign form array entries to smarty */
        $serendipity['smarty']->assign(
                array(
                    'plugin_guestbook_backend_path'    => $_SERVER['PHP_SELF'] . '?serendipity[adminModule]=event_display&serendipity[adminAction]=guestbook&serendipity[guestbookcategory]=gbadd',
                    'is_guestbook_admin_noapp'         => true
                )
        );
        
        /* check for REQUESTS, approve, re-edit, remove from database table */
        switch($gbcat) { 
        
            case 'gbview':
            default:
            
                echo '<div class="backend_guestbook_head"><h2>' . PLUGIN_GUESTBOOK_ADMIN_VIEW . '</h2> ' . PLUGIN_GUESTBOOK_ADMIN_VIEW_DESC . '</div><br />'."\n";
                
                /* view all approved(1) entries in a table */
                $ve = $this->backend_guestbook_view(1, 'gbview');
                
                if($ve === false) echo '<div class="backend_guestbook_dbclean_title"></div><div class="backend_guestbook_dbclean_error"><h3>' . $attention . PLUGIN_GUESTBOOK_ADMIN_VIEW_NORESULT . "</h3></div>\n"; 
                
                break;

            case 'gbapp':

                if ( $moderate === true ) { 

                    echo '<div class="backend_guestbook_head"><h2>' . PLUGIN_GUESTBOOK_ADMIN_APP . '</h2> ' . PLUGIN_GUESTBOOK_ADMIN_APP_DESC . '</div><br />'."\n";
                    
                    /* view all unapproved(0) entries in a table */
                    $this->backend_guestbook_moderate($attention);
                    
                }

                break;

            case 'gbadd':

                $entry = $this->backend_request_checks();
                
                if( !isset($serendipity['guestbook_message_header']) && isset($serendipity['POST']['guestbookform']) !== true) { 
                    echo '<div class="backend_guestbook_head"><h2>' . PLUGIN_GUESTBOOK_ADMIN_ADD . '</h2></div><br />'."\n";
                }
                
                if (isset($serendipity['POST']['guestbookform']) === true ) {
                    // set a guestbook backend header to submit without frontend checks
                    $serendipity['guestbook_backend_header'] = true;
                    /* check form vars */
                    $this->checkSubmit();
                }
                
                if( $serendipity['guestbook_message_header'] === true ) {                
                    if (count($messages) < 1 && $serendipity['guestbook_message_header'] === false) {
                        array_push($messages, PLUGIN_GUESTBOOK_MESSAGE . ': ' . ERROR_UNKNOWN . '<br />' . ERROR_NOCAPTCHASET);
                    }
                    $error_occured = ($serendipity['guestbook_message_header'] === true) ? THANKS_FOR_ENTRY : ERROR_OCCURRED;
                    
                    if ( $moderate === true  && $serendipity['POST']['guestbook_category'] == 'gbapp') { 
                        
                        echo '<div class="backend_guestbook_head"><h2>' . PLUGIN_GUESTBOOK_ADMIN_APP . '</h2> ' . PLUGIN_GUESTBOOK_ADMIN_APP_DESC . '</div><br />'."\n";
                        
                        echo '<div class="backend_guestbook_noresult backend_guestbook_dbclean_error"><h3>' . $attention . " " . $error_occured . "</h3>\n<ul>\n";
                        foreach ($messages AS $msg) echo "<li class='guestbook_errors'>$msg</li>\n";
                        echo "</ul>\n</div>\n"; 
                        
                        /* came from moderation table view and go back */
                        $this->backend_guestbook_moderate($attention);
                    
                    } else { 
                
                        echo '<div class="backend_guestbook_head"><h2>' . PLUGIN_GUESTBOOK_ADMIN_VIEW . '</h2> ' . PLUGIN_GUESTBOOK_ADMIN_VIEW_DESC . '</div><br />'."\n";
                        
                        echo '<div class="backend_guestbook_noresult backend_guestbook_dbclean_error"><h3>' . $attention . " " . $error_occured . "</h3>\n<ul>\n";
                        foreach ($messages AS $msg) echo "<li class='guestbook_errors'>$msg</li>\n";
                        echo "</ul>\n</div>\n"; 
                        
                        /* view all approved entries in a table */
                        $ve = $this->backend_guestbook_view(1, 'gbview');
                        
                        if($ve === false) echo '<div class="backend_guestbook_dbclean_title"></div><div class="backend_guestbook_dbclean_error"><h3>' . $attention . PLUGIN_GUESTBOOK_ADMIN_VIEW_NORESULT . "</h3></div>\n"; 
                        
                    }
               
                } else {
                    // fallback to new entry form, since there was an error
                    if( $serendipity['guestbook_message_header'] === false ) { 
                        foreach($serendipity['POST'] as $sk=>$sv) { 
                            $entry[$sk] = $sv;
                        }
                        foreach($_POST['guestbook'] as $gk=>$gv) { 
                            $entry[$gk] = $gv;
                        }
                        $entry['body'] = $entry['comment'];
                        echo '<div class="backend_guestbook_head"><h2>' . PLUGIN_GUESTBOOK_ADMIN_ADD . '</h2></div><br />'."\n";
                        echo '<div class="backend_guestbook_noresult backend_guestbook_dbclean_error"><h3>' . $attention . " " . ERROR_OCCURRED . "</h3>\n<ul>\n";
                        foreach ($messages AS $msg) echo "<li class='guestbook_errors'>$msg</li>\n";
                        echo "</ul>\n</div>\n"; 
                    }
                    if (serendipity_db_bool($this->get_config('showemail'))) {
                        $serendipity['smarty']->assign('is_show_mail', true);
                    }
                    
                    if (serendipity_db_bool($this->get_config('showpage'))) {
                        $serendipity['smarty']->assign('is_show_url', true);
                    }
                
                    // extract entry bodys admincomment to var
                    preg_match_all("/\[ac\](.*?)\[\/ac\]/", $entry['body'], $match);
                    $entry['acbody'] = $match[1][0];
                    $entry['body']   = preg_replace("/\[ac\](.*?)\[\/ac\]/","", $entry['body']);
                    
                    /* assign form array entries to smarty */
                    $serendipity['smarty']->assign(
                        array(
                            'plugin_guestbook_sent'            => $this->get_config('sent', PLUGIN_GUESTBOOK_SENT_HTML),
                            'plugin_guestbook_id'              => $entry['id'],
                            'plugin_guestbook_ip'              => $entry['ip'],
                            'plugin_guestbook_app'             => $entry['approved'],
                            'plugin_guestbook_ts'              => $entry['timestamp'],
                            'plugin_guestbook_name'            => $entry['name'],
                            'plugin_guestbook_email'           => $entry['email'],
                            'plugin_guestbook_url'             => $entry['homepage'],
                            'plugin_guestbook_comment'         => trim($entry['body']),
                            'plugin_guestbook_ac_comment'      => isset($entry['admincomment']) ? trim($entry['admincomment']) : trim($entry['acbody']),
                            'guestbook_messages'               => $messages,
                            'plugin_guestbook_messagestack'    => $serendipity['messagestack']['comments']
                        )
                    );
                    
                    /* get the guestbook entries template file */
                    echo $this->fetchTemplatePath('plugin_guestbook_backend_form.tpl');
                    
                }    
                    
                break;

            case 'gbdb':

                echo '<div class="backend_guestbook_head"><h2>' . PLUGIN_GUESTBOOK_ADMIN_DBC . '</h2></div><br />'."\n";
                
                /* check if table exists, so there is nothing to do, except some insert stuff :: result is a single row array */
                if( is_string($this->check_isdb()) ) { 
                    echo '<div class="backend_guestbook_noresult backend_guestbook_dbclean_error"><h3>' . $attention . PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_DESC . '!</h3></div>'; 
                } else { 
                    /* add event form */
                    $this->backend_guestbook_dbclean();
                }
                
                echo "\n\n</div> <!-- // backend_guestbook_wrapper end -->\n\n";
                
                return true;
                break;
                
            case 'droptable':
                
                $serendipity['guestbookdroptable'] = true;
                $this->uninstall($bag);
                
                $serendipity['GET']['guestbookdbclean'] = 'dberase';
                $this->backend_guestbook_dbclean($reqbuild['month'], $reqbuild['year']);
                
                return true;
                break;
        }
        echo "\n\n</div> <!-- // backend_guestbook_wrapper end -->\n\n";
    }
    
    /**
     * @return string or array if db is set
     **/
    function check_isdb() { 
        global $serendipity;
        
        if ($serendipity['dbType'] == 'mysql') { 
            return serendipity_db_query("SHOW TABLES LIKE '{$serendipity['dbPrefix']}eventcal'", true, 'num', true);
        } else { 
            $sql = "SELECT count(id) FROM {$serendipity['dbPrefix']}guestbook";
            return count(serendipity_db_query($sql, true, 'num', true)) > 0;
        }
    }

    /**
     * get sql results and assign them to smarty
     * 
     * @param  $ap  = approved yes/no = 1/0
     * @param  $cat = serendipity[guestbookcategory]
     * 
     * @return (true/false)
     **/
    function backend_guestbook_view($ap, $cat) { 
        global $serendipity;
        global $messages;
        
        $count = $this->countEntriesDB($ap); // approved=1
        
        if(is_array($count)) { 
            $result = $this->backend_guestbook_paginator($count[0], $ap, $cat, 'timestamp ASC');
        } 
        
        if (!is_numeric($wordwrap)) {
            $wordwrap = 50;
        }
        
        /* this assigns db entries output to guestbooks smarty array: [$entries] in entries.tpl */
        $entries = $this->generate_EntriesArray($result, $_SERVER['PHP_SELF'], $this->get_config('wordwrap'));
        
        /* assign entries array and good messages array to smarty - beware just using smarty {entries}, it is used by s9y core */
        $serendipity['smarty']->assign(
                array(
                    'guestbook_messages'    => $messages,
                    'guestbook_entries'     => $entries
                )
        );
        
        /* get the guestbook entries template file */
        echo $this->fetchTemplatePath('plugin_guestbook_backend_entries.tpl');
        
        return is_array($entries) ? true : false;
    }
    
    
    /**
     * main backend function to generate moderation table view
     */
    function backend_guestbook_moderate(&$attention) { 
        global $serendipity;
        
        /* assign form array entries to smarty */
        $serendipity['smarty']->assign('is_guestbook_admin_noapp', false);
                    
        /* view all unapproved(0) entries in a table */
        $va = $this->backend_guestbook_view(0, 'gbapp'); 
                    
        if($va === false) echo '<div class="backend_guestbook_dbclean_title"></div><div class="backend_guestbook_dbclean_error"><h3>' . $attention . PLUGIN_GUESTBOOK_ADMIN_APP_NORESULT . "</h3></div>\n"; 
    }
    
    
    /**
     * main backend function navigation number 4
     * plugins panel administration
     * switch into dump, insert, erase, download 
     *
     */
    function backend_guestbook_dbclean() { 
        global $serendipity;
        
        if(isset($serendipity['guestbookdroptable']) === true) { 
            echo '<div class="backend_guestbook_head"><h2>' . PLUGIN_GUESTBOOK_ADMIN_ERASE . '</h2></div><br />'."\n";
        }
        $adminpath = $_SERVER['PHP_SELF'] . '?serendipity[adminModule]=event_display&serendipity[adminAction]=guestbook&serendipity[guestbookcategory]=gbdb';
        $dbclean   = !empty($serendipity['GET']['guestbookdbclean']) ? $serendipity['GET']['guestbookdbclean'] : 'start';
        $attention = '<img class="backend_attention" src="' . $serendipity['serendipityHTTPPath'] . 'templates/default/admin/img/admin_msg_note.png" alt="" />';
        
        echo '<div class="backend_guestbook_dbclean_title"></div>'."\n";
        echo '<div class="backend_guestbook_dbclean_menu">'."\n";
        echo '  <ul class="backend_guestbook_dbclean_menu">'."\n";
        echo '    <li class="backend_guestbook_dbclean_menu" '.(@$serendipity['GET']['guestbookdbclean'] == 'dbdump' ? 'id="active"' : '').'><a href="'.$adminpath.'&serendipity[guestbookdbclean]=dbdump">'.PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP.'</a> <span class="backend_guestbook_right">[ <b class="guestbook_reiter guestbook_reiter_dim">'.PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_DESC.'</b> ]</span></li>'."\n";
        echo '    <li class="backend_guestbook_dbclean_menu" '.(@$serendipity['GET']['guestbookdbclean'] == 'dbinsert' ? 'id="active"' : '').'><a href="'.$adminpath.'&serendipity[guestbookdbclean]=dbinsert">'.PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT.'</a> <span class="backend_guestbook_right">[ <b class="guestbook_reiter guestbook_reiter_dim">'.PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_DESC.'</b> ]</span></li>'."\n";
        echo '    <li class="backend_guestbook_dbclean_menu" '.(@$serendipity['GET']['guestbookdbclean'] == 'dberase' ? 'id="active"' : '').'><a href="'.$adminpath.'&serendipity[guestbookdbclean]=dberase">'.PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE.'</a> <span class="backend_guestbook_right">[ <b class="guestbook_reiter guestbook_reiter_dim">'.PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE_DESC.'</b> ]</span></li>'."\n";
        echo '    <li class="backend_guestbook_dbclean_menu" '.(@$serendipity['GET']['guestbookdbclean'] == 'dbdownload' ? 'id="active"' : '').'><a href="'.$adminpath.'&serendipity[guestbookdbclean]=dbdownload">'.PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD.'</a> <span class="backend_guestbook_right">[ <b class="guestbook_reiter guestbook_reiter_dim">'.PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_DESC.'</b> ]</span></li>'."\n";
        echo '  </ul>'."\n";
        echo '</div>'."\n";
        
        if(isset($serendipity['guestbook']['ilogerror']) === true) echo '<div class="backend_guestbook_noresult backend_guestbook_dbclean_error"><h3>' . $attention . PLUGIN_GUESTBOOK_ADMIN_LOG_ERROR . '</h3></div>';
        
        /* check if table exists, so there is nothing to do except some insert stuff :: result is a single row array */
        if( is_string($this->check_isdb()) && $dbclean != 'dbinsert' && $dbclean != 'dbicallog' ) $dbclean = 'dbnixda';
        
        if(!empty($dbclean)) { 
            switch($dbclean) { 
                case 'dbdump':
                    
                    if($this->backend_guestbook_backup()) { 
                        echo '<div class="backend_guestbook_dbclean_innercat"><h3>' . strtoupper(PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_TITLE) . '</h3></div>'."\n";
                        echo '<div class="backend_guestbook_dbclean_error"><h3>' . $attention . PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_DONE . "</h3></div>\n"; 
                    } else { 
                        echo '<div class="backend_guestbook_noresult backend_guestbook_dbclean_error"><h3>' . $attention . PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_NOBACKUP . '</h3></div>'; 
                    }

                    return true;
                    break;
                    
                case 'dbinsert':
                    echo '<div class="backend_guestbook_dbclean_innercat"><h3>' . strtoupper(PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_TITLE) . '</h3></div>'."\n";
                    echo $this->backend_guestbook_smsg() . PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_MSG . $this->backend_guestbook_emsg();
                    
                    return true;
                    break;
                    
                case 'dberase':
                    
                    echo '<div class="backend_guestbook_dbclean_innercat"><h3>' . strtoupper(PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE_TITLE) . '</h3></div>';
                    $isTable =  $this->uninstall($bag) ? true : false; // ok, questionaire
                    
                    // give back ok
                    if(isset($serendipity['guestbookdroptable']) === true && $isTable) { 
                        echo '<div class="serendipity_center guestbook_tpl_message">'."\n";
                        echo '    <div class="serendipity_center serendipity_msg_notice">'."\n";
                        echo '        <div class="guestbook_tpl_message_inner">'."\n";
                        echo sprintf(PLUGIN_GUESTBOOK_ADMIN_DROP_OK, $serendipity['dbPrefix'].'guestbook');
                        echo '        </div>'."\n";
                        echo '    </div>'."\n";
                        echo '</div>'."\n";
                    } 
                    
                    return true;
                    break;
                    
                case 'dbdownload':
                    
                    echo '<div class="backend_guestbook_dbclean_innercat"><h3>' . strtoupper(PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_TITLE) . '</h3></div>';
                    
                    if (is_dir('templates_c/guestbook')) { 
                        
                        echo "<div class='backend_guestbook_dbclean_innertitle'>templates_c/guestbook/ <b><u>backup files</u></b></div>\n";// - to download use right click::save target as
                        echo "<div class='backend_guestbook_dbclean_object'>\n";
                        $this->backend_read_backup_dir('templates_c/guestbook/', $adminpath.'&serendipity[guestbookdbclean]=dbdelfile&serendipity[guestbookdbcleanfilename]=');
                        echo "</div>\n";
                        
                    } else { 
                        echo '<div class="backend_guestbook_dbclean_error"><h3>' . $attention . PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_MSG . "</h3></div>\n"; 
                    }


                    return true;
                    break;
                    
                case 'dbinsfile':
                    
                    $insfile = false;
                    if(isset($serendipity['GET']['guestbookdbinsertfilename'])) { 
                            $old = getcwd(); // Save the current directory
                            chdir('templates_c/guestbook/');
                            if(is_file($serendipity['GET']['guestbookdbinsertfilename'])) { 
                                unlink($serendipity['GET']['guestbookdbinsertfilename']);
                            }
                            chdir($old); // Restore the old working directory   
                            echo '<div class="backend_guestbook_dbclean_error"><h3>' . $attention . sprintf(PLUGIN_GUESTBOOK_ADMIN_DBC_DELFILE_MSG, $serendipity['GET']['guestbookdbcleanfilename']) . '!</h3></div>'; 
                    }
                    
                    return true;
                    break;
                    
                case 'dbdelfile':
                    
                    $delfile = false;
                    if(isset($serendipity['GET']['guestbookdbcleanfilename'])) { 
                            $old = getcwd(); // Save the current directory
                            chdir('templates_c/guestbook/');
                            if(is_file($serendipity['GET']['guestbookdbcleanfilename'])) { 
                                unlink($serendipity['GET']['guestbookdbcleanfilename']);
                            }
                            chdir($old); // Restore the old working directory   
                            echo '<div class="backend_guestbook_dbclean_error"><h3>' . $attention . sprintf(PLUGIN_GUESTBOOK_ADMIN_DBC_DELFILE_MSG, $serendipity['GET']['guestbookdbcleanfilename']) . '!</h3></div>'; 
                    }
                    
                    return true;
                    break;
                    
                case 'dbnixda':
                    
                    echo '<div class="backend_guestbook_dbclean_innercat"><h3>' . strtoupper(PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_TITLE) . '</h3></div>';
                    echo '<div class="backend_guestbook_dbclean_error"><h3>' . $attention . PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_DESC . '!</h3></div>'; 
                    
                    return true;
                    break;
                    
                default:
                    return false;
                    break;
                    
            }
        }
    }


    /**
     * read the sqldump backup directory - function scanDir() >= php5
     **/
    function backend_read_backup_dir($dpath, $delpath) { 
        global $serendipity;
        $dir = array_slice(scanDir($dpath), 2);
        $url = $serendipity['serendipityHTTPPath'] . 'plugin/guestbookdlsql/';
        echo '<table width="100%">';
        foreach ($dir as $e) { 
            echo '<tr><td align="left"><a href="'.$url.$e.'">';
            echo $e.'</a></td> <td align="right"><a href="'.$delpath.$e.'"><input type="button" class="serendipityPrettyButton" name="erase file" value=" ' . TEXT_DELETE . ' " /></a></td></tr>'."\n";
        }
        echo '</table>';
    }
    
    /**
     * 
     * @param  string text   - the question text string
     * @param  string url    - the url string to pass
     * @param  string addno  - the add to url string in case of no proceed
     * @param  string addyes - the add to url string in case of YES
     * @return string
     */
    function backend_guestbook_questionaire($text, $url, $addno, $addyes) { 
        global $serendipity;
        
        return $str = $this->backend_guestbook_smsg() . $text . '<br /><br />
        <a href="'.$url.$addno.'" class="serendipityPrettyButton">' . NOT_REALLY . '</a>
        <img src="' . $serendipity['serendipityHTTPPath'] . $serendipity['templatePath'] . 'default/img/blank.png" alt="blank" width="10" height="1" />
        <a href="'.$url.$addyes.'" class="serendipityPrettyButton">' . DUMP_IT . '</a><br /><br />
        ' . $this->backend_guestbook_emsg();
    }
        
    /**
     * 
     * @return string start html
     */
    function backend_guestbook_smsg() { 
        return $str = "<div class='serendipity_center guestbook_tpl_message'>\n    <div class='guestbook_tpl_message_inner'>\n";
    }
        
    /**
     * 
     * @return string end html
     */
    function backend_guestbook_emsg() { 
        return $str = "   </div>\n</div>\n";
    }
        
    /**
     * @return boolean backup true/false
     */
    function backend_guestbook_backup() { 
        global $serendipity;

        set_time_limit(360);
        
        $date = date('Y-m-d_H-i-s');
        $directory = "guestbook";
        if (!is_dir('templates_c/' . $directory)) {
            mkdir('templates_c/' . $directory, 0777); 
        } 
        $file = $serendipity['serendipityPath'] . 'templates_c/guestbook/'.$date.'_guestbook.sql';
        $fp   = fopen($file, 'w'); 
        if($fp) { 
            $create = serendipity_db_query("SHOW CREATE TABLE {$serendipity['dbPrefix']}guestbook", true, 'num', true);
            if (is_array($create)) { 
                $create[1] .= ";";
                $tablesyntax = str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $create[1]);
                $line = str_replace("\n", "", $tablesyntax);
                fwrite($fp, $line."\n");
                $data = mysql_query("SELECT * FROM {$serendipity['dbPrefix']}guestbook");
                $num = mysql_num_fields($data);
                while ($row = mysql_fetch_array($data)){
                    $line = "INSERT INTO {$serendipity['dbPrefix']}guestbook VALUES(";
                    for ($i=1; $i<=$num; $i++) {
                        $line .= "'".mysql_real_escape_string($row[$i-1])."', ";
                    }
                    $line = substr($line,0,-2);
                    fwrite($fp, $line.");\n");
                }
            }
            fclose($fp);
            return true;
        } else return false;
    }
    
    
    /**
     * @param  $c   = count entries
     * @param  $ap  = approved yes/no = 1/0
     * @param  $cat = serendipity[guestbookcategory]
     * 
     * @return result array
     */
    function backend_guestbook_paginator($c, $ap, $cat, $orderby) { 
        global $serendipity;
        
        if (isset($serendipity['GET']['guestbooklimit'])) { 
            $paginator = $serendipity['GET']['guestbooklimit'];
        } else { 
            $paginator = 1;
        }
        $rows_per_page = 15;
        $lastpage      = ceil($c/$rows_per_page);

        $paginator = (int)$paginator;
        if ($paginator > $lastpage) { 
            $paginator = $lastpage;
        }
        if ($paginator < 1) { 
            $paginator = 1;
        }
        
        $cp = ($paginator - 1);
        $rp = $rows_per_page;
        $result = $this->getEntriesDB($cp, $rp, $ap);
        
        if(is_array($result)) { 
            if( $serendipity['guestbook_message_header'] !== true ) echo '<div class="backend_guestbook_noresult"></div>';
            echo "\n\n";
            echo '<div class="backend_guestbook_paginator">';
            
            if ($paginator == 1) { 
                echo '<span class="backend_guestbook_paginator_left"> FIRST | PREVIOUS </span>'."\n";
            } else { 
                $prevpage = $paginator-1;
                echo '<span class="backend_guestbook_paginator_left">';
                echo ' <a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=guestbook&amp;serendipity[guestbookcategory]='.$cat.'&amp;serendipity[guestbooklimit]=1"><input type="button" class="serendipityPrettyButton" name="FIRST" value=" &laquo;&laquo; FIRST " /></a> | '."\n";
                echo ' <a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=guestbook&amp;serendipity[guestbookcategory]='.$cat.'&amp;serendipity[guestbooklimit]='.$prevpage.'"><input type="button" class="serendipityPrettyButton" name="PREVIOUS" value=" &laquo; PREVIOUS " /></a> '."\n";
                echo '</span>';
            }

            echo '<span class="backend_guestbook_paginator_center">  ( Page '.$paginator.' of '.$lastpage.' ) </span>'."\n";

            if ($paginator == $lastpage) { 
                echo '<span class="backend_guestbook_paginator_right"> NEXT | LAST </span>'."\n";
            } else { 
                $nextpage = $paginator+1;
                echo '<span class="backend_guestbook_paginator_right">';
                echo ' <a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=guestbook&amp;serendipity[guestbookcategory]='.$cat.'&amp;serendipity[guestbooklimit]='.$nextpage.'"><input type="button" class="serendipityPrettyButton" name="NEXT" value=" NEXT &raquo; " /></a> | '."\n";
                echo ' <a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=guestbook&amp;serendipity[guestbookcategory]='.$cat.'&amp;serendipity[guestbooklimit]='.$lastpage.'"><input type="button" class="serendipityPrettyButton" name="LAST" value=" LAST &raquo;&raquo; " /></a> '."\n";
                echo '</span>';
            } 
            
            echo '</div>';
            echo "\n";
        }
        return is_array($result) ? $result : false;
    } // function backend paginator end

    /**
     * set global $serendipity['guestbook_message_header'] to true in case of approve or erase entry
     * return entry array to re-edit and change
     **/
    function backend_request_checks() { 
        global $serendipity;
        global $messages;
        
        if (!is_array($messages)) {
            $messages = array();
        }

        $id = $_POST['guestbook']['id'];
        
        /* approve events */
        if( (isset($_POST['Approve_Selected']) || isset($_POST['Approve_Selected_x']) || isset($_POST['Approve_Selected_y'])) && isset($id)) { 

            $sql = "UPDATE {$serendipity['dbPrefix']}guestbook SET approved=1 WHERE id=$id";
            $result = serendipity_db_query($sql, true, 'both', true);
            
            if($result) { 
                array_push($messages, sprintf(PLUGIN_GUESTBOOK_APP_ENTRY, $id));
                $serendipity['guestbook_message_header'] = true;
            }
        }
                
        /* reject events */
        if( (isset($_POST['Reject_Selected']) || isset($_POST['Reject_Selected_x']) || isset($_POST['Reject_Selected_y'])) && isset($id)) { 
            
            $sql = "DELETE FROM {$serendipity['dbPrefix']}guestbook WHERE id=$id";
            $result = serendipity_db_query($sql, true, 'both', true);
            
            if($result) { 
                array_push($messages, sprintf(RIP_ENTRY, $id));
                $serendipity['guestbook_message_header'] = true;
            } 
        }
                
        /* an authenticated logged-in user tries to change an anapproved event via app form */
        if( ( isset($_POST['Change_Selected']) || isset($_POST['Change_Selected_x']) || isset($_POST['Change_Selected_y']) ) && isset($id)) {  
        
            // select a specific entry by id 
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}guestbook WHERE id=$id";
            // show single entry to re-edit :: result is a single row array
            $entry = serendipity_db_query($sql, true, 'assoc', true);
        } 
        
        /* an authenticated logged-in user tries to change a single entry */
        if( isset($entry) && is_array($entry) ) return $entry;
    }
    
}
/* vim: set sts=4 ts=4 expandtab : */
