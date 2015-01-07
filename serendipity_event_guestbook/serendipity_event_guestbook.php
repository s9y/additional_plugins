<?php

/**
 * serendipity_event_guestbook.php, v.3.53 - 2014-12-29
 */

//error_reporting(E_ALL);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_guestbook extends serendipity_event {

    var $title = PLUGIN_GUESTBOOK_TITLE;
    var $filter_defaults;

    /**
     * Declare Serendipity backend properties.
     *
     * @param serendipity_property_bag $propbag
     */
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
                        'backend_sidebar_admin_appearance' => true,
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
                        'maxitems',
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
        $propbag->add('author',       'Ian');
        $propbag->add('version',      '3.54');
        $propbag->add('requirements', array(
                        'serendipity' => '1.7.0',
                        'smarty'      => '3.1.0',
                        'php'         => '5.2.0'
                    ));
        $propbag->add('stackable', false);
        $propbag->add('groups', array('FRONTEND_FEATURES', 'BACKEND_FEATURES'));

        $this->filter_defaults = array('words'   => '\[link(.*?)\];http://');
    }


    /**
     * serendipity_plugin::example method
     *
     */
    function example() {
        return "\n<ul>\n    <li class=\"msg_notice\"><strong>Note to v. 3.53:</strong> If have, please update copied guestbook tpl files in your template!</li>\n    <li class=\"msg_notice\"><strong>Note to v. 3.50:</strong> A possible TABLE COLUMN order change for long time users, may need you to backup your database in Guestbooks DB Administration panel again!</li>\n</ul>\n\n";
    }


    /**
     * serendipity_plugin::cleanup method
     *
     * @return boolean
     */
    function cleanup() {
        global $serendipity;

        // check possible config mismatch setting
        if (serendipity_db_bool($this->get_config('showapp')) === true && serendipity_db_bool($this->get_config('automoderate')) === true) {
            $this->set_config('automoderate', false);
            echo '<div class="msg_error"><span class="icon-attention-circled"></span> ' . PLUGIN_GUESTBOOK_CONFIG_ERROR . '</div>';
            return false;
        }
        // Cleanup. Remove all empty configs on SAVECONF-Submit.
        serendipity_plugin_api::remove_plugin_value($this->instance, array('sessionlock', 'timelock', 'version', 'targetmail', 'pageurl', 'dynamic_fields', 'dynamic_fields_desc', 'formpopup', 'getdynfield', 'showdynfield'));

        return true;
    }


    /**
     * serendipity_plugin::install method
     *
     */
    function install() {
        $this->createTable();
    }


    /**
     * Create table install
     *
     */
    function createTable() {
        global $serendipity;

        $q = "CREATE TABLE IF NOT EXISTS {$serendipity['dbPrefix']}guestbook (
                        id {AUTOINCREMENT} {PRIMARY},
                        ip varchar(45) default NULL,
                        name varchar(100),
                        homepage varchar(100),
                        email varchar(100),
                        body text,
                        approved int(1) default 1,
                        timestamp int(10) {UNSIGNED} NULL) {UTF_8}";

        serendipity_db_schema_import($q);
    }


    /**
     * Upgrade Alter Table
     *
     * @param  string version
     */
   function alter_db($db_config_version) {
        global $serendipity;
        if ($db_config_version == '1.0') {
            $q = "ALTER TABLE {$serendipity['dbPrefix']}guestbook CHANGE name name varchar(100)";
            serendipity_db_schema_import($q);
            $q = "DELETE FROM {$serendipity['dbPrefix']}config WHERE name LIKE '%serendipity_event_guestbook%/sessionlock' AND name LIKE '%serendipity_event_guestbook%/timelock'";
            serendipity_db_schema_import($q);
        }
        if ($db_config_version == '2.0') {
            $q = "ALTER TABLE {$serendipity['dbPrefix']}guestbook ADD COLUMN approved int(1) AFTER body DEFAULT 1";
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
        if ($db_config_version == '3.0') {
            $q = "ALTER TABLE {$serendipity['dbPrefix']}guestbook CHANGE COLUMN ip ip VARCHAR(45)";
            serendipity_db_schema_import($q);
        }
        // table order placement to make sure for db administration tasks
        if ($db_config_version == '4') {
            $q = "ALTER TABLE {$serendipity['dbPrefix']}guestbook CHANGE COLUMN timestamp timestamp int(10) AFTER approved";
            serendipity_db_schema_import($q);
        }
    }


    /**
     * serendipity_plugin::uninstall method
     *
     * @return boolean
     */
    function uninstall(&$propbag) {
        global $serendipity;

        if (isset($serendipity['guestbookdroptable']) === true) {
            $q   = "DROP TABLE IF EXISTS {$serendipity['dbPrefix']}guestbook";
            if (serendipity_db_schema_import($q)) return true;
        } else {
            $adminpath = $_SERVER['PHP_SELF'].'?serendipity[adminModule]=event_display&serendipity[adminAction]=guestbook&serendipity[guestbookcategory]=';
            $this->backend_guestbook_questionaire(PLUGIN_GUESTBOOK_ADMIN_DROP_SURE . '<br>' . PLUGIN_GUESTBOOK_ADMIN_DUMP_SELF, $adminpath, 'gbdb', 'droptable');
            return false;
        }
    }


    /**
     * This function is a s9y plugin standard starter
     * sets $serendipity['GET']['subpage']
     *
     * @return boolean
     */
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


    /**
     * serendipity_plugin::generate_content
     * This function is used for sidebar plugins only
     *
     * @param string $title is somehow important to indicate the title of a plugin in the plugin configuration manager.
     */
    function generate_content(&$title) {
        $title = PLUGIN_GUESTBOOK_TITLE.' (' . $this->get_config('pagetitle') . ')'; // do we need to set this to headline now?
    }


    /**
     * Generate backend configuration fields
     *
     * @param string $name field name
     * @param serendipity_property_bag $propbag properties
     * @return boolean
     */
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
                                                    'value' => array('top', 'bottom'),
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

            case 'maxitems':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_GUESTBOOK_NUMBER . ' (Backend)');
                $propbag->add('description', PLUGIN_GUESTBOOK_NUMBER_BLAHBLAH);
                $propbag->add('default', '15');
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
                $propbag->add('description', PLUGIN_GUESTBOOK_FILTER_ENTRYCHECKS_BLAHBLAH . ' ' . PLUGIN_GUESTBOOK_FILTER_ENTRYCHECKS_BYPASS);
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


    /**
     * Try to make email address printing safe (protect from spammers)
     *
     * @param  string   $string   entry email checks
     * @return string
     */
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


    /**
     * Check if email is valid
     *
     * @param  string   $string   entry email checks
     * @return mixed    string/boolean
     */
     function is_valid_email($postmail) {
        // Email needs to match this pattern to be a good email address
        if (!empty($postmail)) {
            return (preg_match(
                ":^([-!#\$%&'*+./0-9=?A-Z^_`a-z{|}~ ])+" .    // the user name
                "@" .                                        // the ubiquitous at-sign
                "([-!#\$%&'*+/0-9=?A-Z^_`a-z{|}~ ]+\\.)+" . // host, sub-, and domain names
                "[a-zA-Z]{2,6}\$:i",                         // top-level domain (TLD)
                trim($postmail)));                            // get rid of trailing whitespace
        } else return false;
    }


    /**
     * Check POST string if guestbooks content filter found something to strip
     * Adds match to $serendipity['messagestack']['comments'] array, if not in admin group
     *
     * @param  string   $string   mostly entry body checks
     * @return boolean
     */
    function strip_input($string) {
        global $serendipity;

        $stripped     = strip_tags($string);
        $filter_bodys = explode(';', $this->get_config('entrychecks'));
        // filter string checks if not in admin group
        if (is_array($filter_bodys) && $serendipity['serendipityUserlevel'] < USERLEVEL_ADMIN) {
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
     * guestbook wrapper for htmlspecialchars charset switch with PHP 5.4
     *
     * @access public
     * @return string
     */
    public static function html_specialchars($string, $flags = null, $encoding = LANG_CHARSET, $double_encode = true) {
        if ($flags == null) {
            if (defined('ENT_HTML401')) {
                // Added with PHP 5.4.x
                $flags = ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE;
            } else {
                // For PHP < 5.4 compatibility
                $flags = ENT_COMPAT;
            }
        }
        if ($encoding == 'LANG_CHARSET') {
            $encoding = 'UTF-8'; // fallback
        }

        return htmlspecialchars($string, $flags, $encoding, $double_encode);
    }


    /**
     * Strip and secure $serendipity['POST'] by keys and define modified array var if value has changed
     * No need for trim(strip_tags()) here, while this changes length and is further on done on output separately!
     *
     * @param  mixed    $parr    array or string depending on $single
     * @param  array    $keys    array of keys only
     * @param  boolean  $single  loop array or return string
     * @param  boolean  $compare allow is stripped by key note
     * @return mixed    array $serendipity['POST'] or single string
     */
    function strip_security($parr = null, $keys = null, $single = false, $compare = true) {
        $authenticated_user = serendipity_userLoggedIn() ? true : false;
        if ($single) {
            return $authenticated_user ? $this->html_specialchars($parr) : $this->html_specialchars(strip_tags($parr));
        } else { // POST data input check
            foreach ($parr AS $k => $v) {
                if (in_array($k, $keys)) {
                    $valuelength = strlen($v);
                    #$parrsec[$k] = $authenticated_user ? $this->html_specialchars($v) : $this->html_specialchars(strip_tags($v));//dont store entities
                    $parrsec[$k] = $authenticated_user ? $v : strip_tags($v);
                    if (!$authenticated_user && $compare && ($valuelength != strlen($parrsec[$k]))) {
                        $parrsec['stripped'] = true;
                        $parrsec['stripped-by-key'] = $k;
                    }
                } else $parrsec[$k] = $v;
            }
            return $parrsec;
        }
    }


    /**
     * BBCode replacements
     * old preg_replace had issues with whitespaces
     *
     * @param  string   $string   entry comment replacements
     * @return string
     */
    function text_pattern_bbc($text) {
        $pattern     = array('[b]', '[/b]', '[u]', '[/u]', '[i]', '[/i]', '[s]', '[/s]', '[q]', '[/q]', '[ac]', '[/ac]');
        $replacement = array('<strong>', '</strong>', '<u>', '</u>', '<em>', '</em>', '<del>', '</del>', '<q>', '</q>', '<br /><span class="guestbook_admin_comment"><blockquote cite="#"><p>', '</p></blockquote></span>');
        return str_replace($pattern, $replacement, $text);
    }


    /**
     * BBCode reverse
     *
     * @param  string   $string   entry comment replacements
     * @return string
     */
    public static function bbc_reverse($text) {
        $pattern = '|[[\/]*?[^\[\]]*?]|si';
        $replace = '';
        return preg_replace($pattern, $replace, $text);
    }


    /**
     * Cut string between two other strings
     *
     * @param  string  $str  given string
     * @param  string  $from left string for cutting
     * @param  string  $to   right string for cutting
     * @return string  cut part
     */
    function cut_string($str, $from, $to){
        $start = strpos($str,$from) + strlen($from);
        if (strpos($str,$from) === false) return false;
        $length = strpos($str,$to,$start) - $start;
        if (strpos($str,$to,$start) === false) return false;
        return substr($str,$start,$length);
    }


    /**
     * Set frontend pagination to global var
     *
     * @param  int      $c      counted entries
     * @param  boolean  $ap     approved yes/no = 1/0
     * @param  string   $pname  frontend Url with ? or & depending mod_rewrite settings
     * @param  int      $maxpp  max entries per page
     * @return array    $entries
     */
    function frontend_guestbook_paginator($c, $ap, $pname, $maxpp) {
        global $serendipity;

        if (isset($serendipity['GET']['guestbooklimit'])) {
            $paginator = (int)$serendipity['GET']['guestbooklimit'];
        } else {
            $paginator = 1;
        }

        if (!isset($maxpp) && !is_numeric($maxpp)) $maxpp = 15;
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

        if (is_array($entries)) {
            $serendipity['guestbook']['paginator'] = '';
            $serendipity['guestbook']['paginator'] .= '<div class="frontend_guestbook_paginator">';

            if ($paginator == 1) {
                $serendipity['guestbook']['paginator'] .= '<span class="frontend_guestbook_paginator_left"> FIRST | PREVIOUS </span>'."\n";
            } else {
                $prevpage = $paginator-1;
                $serendipity['guestbook']['paginator'] .= '<span class="frontend_guestbook_paginator_left">';
                $serendipity['guestbook']['paginator'] .= ' <a href="'.$pname.'serendipity[guestbooklimit]=1"><input type="button" class="serendipityPrettyButton input_button" name="FIRST" value="' . PAGINATOR_FIRST . '" /></a> | '."\n";
                $serendipity['guestbook']['paginator'] .= ' <a href="'.$pname.'serendipity[guestbooklimit]='.$prevpage.'"><input type="button" class="serendipityPrettyButton input_button" name="PREVIOUS" value="' . PAGINATOR_PREVIOUS . ' " /></a> '."\n";
                $serendipity['guestbook']['paginator'] .= '</span>';
            }

            $serendipity['guestbook']['paginator'] .= '<span class="frontend_guestbook_paginator_center">  ( ' . PAGINATOR_PAGE . ' ' . $paginator . ' ' . PAGINATOR_OFFSET . ' ' . $lastpage . ' ) </span>'."\n";

            if ($paginator == $lastpage) {
                $serendipity['guestbook']['paginator'] .= '<span class="frontend_guestbook_paginator_right"> NEXT | LAST </span>'."\n";
            } else {
                $nextpage = $paginator+1;
                $serendipity['guestbook']['paginator'] .= '<span class="frontend_guestbook_paginator_right">';
                $serendipity['guestbook']['paginator'] .= ' <a href="'.$pname.'serendipity[guestbooklimit]='.$nextpage.'"><input type="button" class="serendipityPrettyButton input_button" name="NEXT" value="' . PAGINATOR_NEXT . '" /></a> | '."\n";
                $serendipity['guestbook']['paginator'] .= ' <a href="'.$pname.'serendipity[guestbooklimit]='.$lastpage.'"><input type="button" class="serendipityPrettyButton input_button" name="LAST" value="' . PAGINATOR_LAST . '" /></a> '."\n";
                $serendipity['guestbook']['paginator'] .= '</span>';
            }

            $serendipity['guestbook']['paginator'] .= '</div>';
            $serendipity['guestbook']['paginator'] .= "\n";
        }
        return is_array($entries) ? $entries : false;
    } // function frontend paginator end


    /**
     * Generate entries checks
     *
     * @param array  $entries       given string
     * @param string $is_guestbook_ url create url
     * @param int    $wordwrap      linebreak
     * @param bool   $backend_escape
     * @return array $entries for output
     */
    function generate_EntriesArray($entries, $is_guestbook_url, $wordwrap, $backend_escape = false) {
        global $serendipity;

        // this assigns db entries output to guestbooks smarty entries.tpl
        if (is_array($entries)) {
            foreach($entries AS $i => $entry) {
                // entry items
                $entry['email']         = $this->strip_security($this->safeEmail($entry['email']), null, true);
                $entry['name']          = $this->strip_security($entry['name'], null, true);
                $entry['homepage']      = !empty($entry['homepage']) && strpos($entry['homepage'],'http://') !== 0 && strpos($entry['homepage'],'https://') !== 0
                                        ? 'http://' . $this->strip_security($entry['homepage'], null, true)
                                        : $this->strip_security($entry['homepage'], null, true);
                $entry['pluginpath']    = $serendipity['serendipityHTTPPath'] . $serendipity['guestbook']['pluginpath'];
                $entry['timestamp']     = strftime($this->get_config('dateformat'), (int)$entry['timestamp']); // mysql would use SELECT *, FROM_UNIXTIME(timestamp) AS ts FROM `s9y_guestbook`

                $entry['page']          = $is_guestbook_url . (($serendipity['rewrite'] == 'rewrite') ? '?' : '&') . 'noclean=true&serendipity[adminAction]=guestbookdelete&serendipity[page]=' . (int)$serendipity['GET']['page'] . '&serendipity[gbid]=' . $entry['id'];

                // authenticated user admincomment is not escaped - do not wordwrap this part (since it could cause undetermined string errors, etc)
                $placeholder_ac         = '[[$ac]]';
                $replace_ac             = $this->cut_string($entry['body'], '[ac]', '[/ac]');
                $stripped_body          = $this->strip_security($entry['body'], null, true);
                $search_ac              = $this->cut_string($stripped_body, '[ac]', '[/ac]');
                $entry['body']          = str_replace($search_ac, $placeholder_ac, $stripped_body);

                if (serendipity_db_bool($this->get_config('markup'))) {
                    // parse  $entry['text'] through hook events standard formatting and smilies
                    $markup             = array('body' => $entry['body']);
                    serendipity_plugin_api::hook_event('frontend_display', $markup, 'body');
                    $entry['body']      = wordwrap($markup['body'], $wordwrap, "\n", 1);
                } else {
                    $entry['bodywrap']  = wordwrap($entry['body'], $wordwrap, "\n", 1);
                    $entry['body']      = nl2br($entry['bodywrap']);
                }
                if ($backend_escape) {
                    $replace_ac = $this->html_specialchars($replace_ac); // do not allow in backend, eg unescaped scripts
                }
                $entry['body']          = str_replace($placeholder_ac, $replace_ac, $entry['body']);
                $entry['body']          = $this->text_pattern_bbc($entry['body']);

                $entries[$i]            = $entry;
            }
        }
        return is_array($entries) ? $entries : false;
    }

    /**
     * Insert guestbook entry into database and send mail
     *
     * @param  int       $id
     * @param  string    $ip
     * @param  string    $name
     * @param  string    $url
     * @param  string    $email
     * @param  string    $body
     * @param  int       $app    approved
     * @param  int       $ts     timestamp
     * @param  boolean   $old    Insert/Replace
     * @return boolean
     */
    function insertEntriesDB($id=false, $ip=false, $name, $url, $email, $body, $app=false, $ts=false, $old=false) {
        global $serendipity;

        // make php to current unix timestamp to insert into db
        $ip    = isset($ip)  ? $ip   : serendipity_db_escape_string($_SERVER['REMOTE_ADDR']);
        $app   = isset($app) ? (int)$app  : (serendipity_db_bool($this->get_config('showapp')) ? 0 : 1);
        $ts    = isset($ts)  ? $ts   : time();

        $name  = serendipity_db_escape_string(substr($name, 0, 29));
        $url   = serendipity_db_escape_string(substr($url, 0, 99));
        $email = serendipity_db_escape_string(substr($email, 0, 99));
        $body  = serendipity_db_escape_string($body);

        if ($old === false) {
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
            // if set, send an Email to the Admin $serendipity['email']
            if (!serendipity_db_bool($this->get_config('emailadmin'))) {
                return false;
            } elseif (!$this->get_config('targetmail') || $this->get_config('targetmail') != '') {
                $headers[] = 'X-SentBy: Serendipity Guestbook';
                $headers[] = 'X-Priority: 2';           // prevent sent emails
                $headers[] = 'X-MSmail-Priority: high'; // treated as junk mails
                $body = str_replace(array('\r\n','\n'), "\n", $body); // without search = single and replace = double quotes, this won't work!!!
                // does $serendipity['csuccess'] ever return to be moderate?
                if (serendipity_db_bool($this->get_config('showapp')) === false && ($app == 0 || $serendipity['csuccess'] == 'moderate')) { $body = $body . sprintf(TEXT_EMAILMODERATE, $serendipity['moderate_reason']); }
                return @serendipity_sendMail($this->get_config('targetmail'), TEXT_EMAILSUBJECT, sprintf(TEXT_EMAILTEXT,$name, $body, TEXT_EMAILFOOTER), $email, $headers, $name);
            }
            return true;
        }
    }


    /**
     * Guestbook entries count db
     *
     * @param  int   $ap   approved
     * @return mixed boolean/int
     */
    function countEntriesDB($ap) {
        global $serendipity;

        $whe = (serendipity_db_bool($this->get_config('showapp')) || serendipity_db_bool($this->get_config('automoderate'))) ? "WHERE approved=$ap" : '';

        // count guestbook entries to make entries paging
        $sql = "SELECT count(*) AS counter FROM {$serendipity['dbPrefix']}guestbook $whe";
        $maxres = serendipity_db_query($sql, true);

        return is_array($maxres) ? $maxres : false;
    }


    /**
     * Guestbook Select entries
     *
     * @param  int   $cp   limit from
     * @param  int   $rp   limit to
     * @param  int   $ap   approved
     * @return mixed boolean/array $entries
     */
    function getEntriesDB($cp, $rp, $ap) {
        global $serendipity;

        $whe = (serendipity_db_bool($this->get_config('showapp')) || serendipity_db_bool($this->get_config('automoderate'))) ? "WHERE approved=$ap" : '';

        // generate guestbook entries and send them to entries template
        $sql = "SELECT * FROM {$serendipity['dbPrefix']}guestbook $whe ORDER BY timestamp DESC ";
        $entries = serendipity_db_query($sql . serendipity_db_limit_sql(
                                        serendipity_db_limit(
                                            $cp * $rp, $rp
                                        )
                                    ), false, 'assoc'
                                );
        return is_array($entries) ? $entries : false;
    }


    /**
     * Guestbook form submit POST checks, validate & insert into db
     *
     * @return boolean on error
     */
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
        $authenticated_user = serendipity_userLoggedIn() ? true : false;
        $gb_automoderate    = serendipity_db_bool($this->get_config('automoderate'), false);

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

        if (!$serendipity['POST']['email'] || !$serendipity['POST']['name'] || !$serendipity['POST']['comment']) {
            array_push($messages, ERROR_NOINPUT);
            return false;
        }

        // do not allow non logged-in manual BBCode in comments
        if (!$authenticated_user) {
            $serendipity['POST']['comment'] = $this->bbc_reverse($serendipity['POST']['comment']);
        }

        // find Spamblock global set force auto moderation
        if ($hit = preg_grep("|/forcemoderation_treat|i", array_keys($serendipity))) {
            $forcemoderate = array_values($hit);
        }
        // if force moderate is set to moderate, advice security to not support 'stripped' or 'stripped-by-key' POST mark
        // this does only happen true, if not automoderate is set in both plugins and strip tags really removed some tags.
        if (isset($serendipity[$forcemoderate[0]]) == 'moderate' && $gb_automoderate === true) {
            $serendipity['POST'] = $this->strip_security($serendipity['POST'], array('name', 'email', 'comment', 'admincomment', 'url'), false, false);
        } else {
            $serendipity['POST'] = $this->strip_security($serendipity['POST'], array('name', 'email', 'comment', 'admincomment', 'url'));
        }

        if ($serendipity['POST']['stripped'] === true) {
            array_push($messages, ERROR_OCCURRED . '<br>' . ERROR_DATASTRIPPED);
            return false;
        }

        // Fake call to spamblock and other comment plugins, if not in backend.
        $ca = array(
                    'id'                    => 0,
                    'allow_comments'        => true,
/*                    'moderate_comments'     => true, dont use here, while it overrides spamblock option setting */
                    'last_modified'         => time(),
                    'timestamp'             => strtotime("-8 day" ,time()) // remember captchas_ttl using 7 days as normal setting, just 10 sec. throws Moderation after X days
                    );

        if (!is_numeric($_POST['guestbook']['id'])) {
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

        // listen to Spamblock Plugin and do some specific guestbook checks, if captcha and entry were allowed
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

            if (strlen(trim($serendipity['POST']['name'])) < 3 || strlen(trim($serendipity['POST']['comment'])) < 10) {
                array_push($messages, ERROR_DATATOSHORT);
            } else {
                $valid['data_length'] = TRUE;
            }

            if ($this->strip_input($serendipity['POST']['comment']) === false) {
                array_push($messages, ERROR_DATANOTAGS . ' ' . $serendipity['messagestack']['comments'][0]);
                if (!empty($serendipity['messagestack']['comments'][0])) {
                    unset($serendipity['messagestack']['comments']);
                }
            }

            if (isset($serendipity['POST']['email']) && !empty($serendipity['POST']['email']) && trim($serendipity['POST']['email']) != '') {
                if (!$this->is_valid_email($serendipity['POST']['email'])) {
                    array_push($messages, ERROR_NOVALIDEMAIL . ' <span class="gb_msgred">' . $this->html_specialchars($serendipity['POST']['email']) . '</span>');
                } else {
                    $valid['data_email'] = TRUE;
                }
            }

            if (isset($serendipity['POST']['captcha']) && !empty($serendipity['POST']['captcha'])) {
                if (serendipity_db_bool($ca['allow_comments']) === true || strtolower($serendipity['POST']['captcha']) == strtolower($_SESSION['spamblock']['captcha'])) {
                    $valid['captcha'] = TRUE;
                } elseif (!$authenticated_user) {
                    if ($serendipity['csuccess'] != 'moderate') {
                        array_push($messages, ERROR_ISFALSECAPTCHA);
                    }/* else {
                        array_push($messages, $serendipity['moderate_reason'] . PLUGIN_GUESTBOOK_AUTOMODERATE_ERROR . PLUGIN_GUESTBOOK_DBDONE_APP);
                    }*/
                }
            }

            // Captcha checking - if set to FALSE in guestbook config and spamblock plugin catchas is set to no, follow db insert procedure
            if (!serendipity_db_bool($this->get_config('showcaptcha'))) {
                if (!isset($_SESSION['spamblock']['captcha']) || !isset($serendipity['POST']['captcha']) || strtolower($serendipity['POST']['captcha']) != strtolower($_SESSION['spamblock']['captcha'])) {
                    $valid['captcha'] = TRUE;
                }
            }

            if ($authenticated_user && $_SESSION['serendipityAuthedUser'] === true) {
                $valid['captcha']      = TRUE;
                $valid['data_length']  = TRUE;
                $valid['data_email']   = TRUE;
            }

            // spamblock allows comments end
        } else {
            // drop entry back to form - beware 'allow_comments' return value is empty, not false, if false
            array_push($messages,  PLUGIN_GUESTBOOK_MESSAGE . ': ' . PLUGIN_GUESTBOOK_ERROR_DATA);
        }
        // set valid messages to true, if no errors occured
        $valid['message'] = (count($messages) < 1) ? TRUE : FALSE;

        // no errors and messages
        if ($valid['message'] === true) {
            // set var, if not set by backend form
            if (!is_numeric($_POST['guestbook']['approved'])) $_POST['guestbook']['approved'] = '';
            if (is_numeric($_POST['guestbook']['id'])) $_POST['guestbook']['approved'] = 1;

            /***
               allow the spamblock wordfilter plugin to set an entry as non-approved,
               accordingly to stopwords and content filter set to 'moderation' in spamblock plugin.
               extends new auto-moderate option setting to true in guestbooks config
             ***/
            // keep this for future finetuning via SPAMBLOCK plugin
            if (array_key_exists('moderate_comments', $ca)) {

                if (serendipity_db_bool($ca['moderate_comments']) === true && $gb_automoderate === true) {
                    // set entries to get approved in backend, before they can appear in frontent
                    $_POST['guestbook']['approved'] = 0;
                }
            }
        }

        // write new entry into database, if input is valid
        if (!empty($serendipity['POST']['guestbookform']) && $valid['captcha'] === true && $valid['data_length'] === true
                                                          && $valid['data_email'] === true && $valid['message'] === true) {

            $admincomment = (!empty($serendipity['POST']['admincomment'])) ? '[ac] ' . $serendipity['POST']['admincomment'] . ' [/ac]' : '';
            $acapp        = ($authenticated_user && $_SESSION['serendipityAuthedUser'] === true) ? 1 : NULL;
            $acapp        = is_numeric($_POST['guestbook']['approved']) ? $_POST['guestbook']['approved'] : $acapp;

            if (is_numeric($_POST['guestbook']['id'])) {
                // update validated form values into db
                $this->insertEntriesDB($_POST['guestbook']['id'], $_POST['guestbook']['ip'], $serendipity['POST']['name'], $serendipity['POST']['url'], $serendipity['POST']['email'], $serendipity['POST']['comment'].$admincomment, $_POST['guestbook']['approved'], $_POST['guestbook']['timestamp'], true);
            } else {
                // insert validated form values into db
                $this->insertEntriesDB(NULL, NULL, $serendipity['POST']['name'], $serendipity['POST']['url'], $serendipity['POST']['email'], $serendipity['POST']['comment'], $acapp, NULL, false);
            }

            // claim insertEntriesDB is true
            $showapp    = serendipity_db_bool($this->get_config('showapp'));
            $showapptxt = ($showapp && !$authenticated_user) ? ' ' . PLUGIN_GUESTBOOK_DBDONE_APP : '';

            if (!$authenticated_user) {
                // be strict here, since it could be null also
                if (($showapp === false && $acapp === 0) || $serendipity['csuccess'] == 'moderate') {
                    if (isset($serendipity[$forcemoderate[0]]) == 'moderate') {
                        $showapptxt = '<br>' . $serendipity['moderate_reason'] . '<br>' . PLUGIN_GUESTBOOK_AUTOMODERATE_ERROR . PLUGIN_GUESTBOOK_DBDONE_APP;
                    }
                }
            }

            array_push($messages, PLUGIN_GUESTBOOK_MESSAGE . ': ' . PLUGIN_GUESTBOOK_DBDONE . $showapptxt);
            // flag global meassage header to have successfully checked and safed the entry
            $serendipity['guestbook_message_header'] = true;

            // reset post values
            unset($serendipity['POST']);
            unset($_POST);

            // set startpage back to 1
            $serendipity['GET']['page'] = 1;

            if ($serendipity['guestbook_message_header'] === false) {
                array_push($messages, PLUGIN_GUESTBOOK_UNKNOWN_ERROR);
                return false;
            }
        }
    } // checkSubmit() validate & insert into db end


    /**
     * Guestbook create output page assignment and fetch template file
     *
     * @return boolean on error
     */
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

            // case export mysql dump file - and send to external_plugin hook
            if ($_POST['guestbook']['bedownload']) {
                $url = $_POST['guestbook']['bedownload'];
                if ($url) header('Location: http://' . $_SERVER['HTTP_HOST'] . $url);
            }

            // Carl and Don wanted to access the staticpage_pagetitle
            $_ENV['staticpage_pagetitle'] = preg_replace('@[^a-z0-9]@i', '_',$this->get_config('pagetitle'));
            $_ENV['staticpage_headline']  = $this->get_config('headline');
            $_ENV['staticpage_formorder'] = $this->get_config('formorder');
            $serendipity['smarty']->assign(
              array(
                  'staticpage_headline'  => $_ENV['staticpage_headline'],
                  'staticpage_pagetitle' => $_ENV['staticpage_pagetitle'],
                  'staticpage_formorder' => $_ENV['staticpage_formorder']
              )
            );

            if (isset($serendipity['POST']['guestbookform']) == true) {
                // check form vars
                $this->checkSubmit();

                if (count($messages) < 1 && $serendipity['guestbook_message_header'] === false) {
                    array_push($messages, PLUGIN_GUESTBOOK_MESSAGE . ': ' . ERROR_UNKNOWN . '<br>' . ERROR_NOCAPTCHASET);
                }
            }

            // generate frontend admin header section - if user logged in and action == delete entry
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

            // call the form page output function
            $this->generate_EntriesPage();
            $this->generate_FormPage();

            // get the guestbook entries template file
            echo $this->parseTemplate('plugin_guestbook_entries.tpl');
        }
    } // generate_Page end


    /**
     * Guestbook create form page assignment and fetch template file
     *
     */
    function generate_FormPage() {

        global $serendipity;
        global $messages;

        if (serendipity_db_bool($this->get_config('showemail'))) {
            $serendipity['smarty']->assign('is_show_mail', true);
        }

        if (serendipity_db_bool($this->get_config('showpage'))) {
            $serendipity['smarty']->assign('is_show_url', true);
        }

        // assign form array entries to smarty
        $serendipity['smarty']->assign(
                array(
                    'plugin_guestbook_articleformat'   => (serendipity_db_bool($this->get_config('markup')) ? true : false),
                    'plugin_guestbook_intro'           => $this->get_config('intro'),
                    'plugin_guestbook_sent'            => $this->get_config('sent', PLUGIN_GUESTBOOK_SENT_HTML),
                    'plugin_guestbook_action'          => $serendipity['baseURL'] . $serendipity['indexFile'],
                    'plugin_guestbook_sname'           => $this->html_specialchars($serendipity['GET']['subpage']),
                    'plugin_guestbook_name'            => $this->html_specialchars(strip_tags($serendipity['POST']['name'])),
                    'plugin_guestbook_email'           => $this->html_specialchars(strip_tags($serendipity['POST']['email'])),
                    'plugin_guestbook_emailprotect'    => PLUGIN_GUESTBOOK_PROTECTION,
                    'plugin_guestbook_url'             => $this->html_specialchars(strip_tags($serendipity['POST']['url'])),
                    'plugin_guestbook_comment'         => $this->html_specialchars(strip_tags($serendipity['POST']['comment'])),
                    'plugin_guestbook_messagestack'    => $serendipity['messagestack']['comments'],
                    'plugin_guestbook_entry'           => array('timestamp' => 1)
                )
        );

        // get the form page template file
        $conform =  $this->parseTemplate('plugin_guestbook_form.tpl');
        $serendipity['smarty']->assign('GUESTBOOK_FORM', $conform);

    } // generate_FormPage() end


    /**
     * Guestbook generate entries page assignment
     *
     * @param  int   $ap   approved
     *
     */
    function generate_EntriesPage($ap=1) {

        global $serendipity;
        global $messages;

        if (!is_array($messages)) {
            $messages = array();
        }

        // max entries per page
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

        // if entry send is ok OR user just views guestbook entries :: run SQL
        if ($serendipity['guestbook_message_header'] === true || empty($serendipity['POST']['guestbookform'])) {

            // count db entries as array: [$maxres]
            $maxres = $this->countEntriesDB($ap);

            $url = $is_guestbook_url . (($serendipity['rewrite'] == 'rewrite') ? '?' : '&');
            // generate $entries array and frontend pagination
            $entries = is_array($maxres) ? $this->frontend_guestbook_paginator($maxres[0], $ap, $url, $max_entries) : false;

            // this assigns $entries and paging output to plugin_guestbooks_entries.tpl
            $serendipity['smarty']->assign(array(
                'guestbook_entry_paging'         => true,
                'guestbook_userLoggedIn'         => false, // keep var for old user templates
                'guestbook_paging'               => $serendipity['guestbook']['paginator']
            ));
        }

        $serendipity['smarty']->assign('is_guestbook_url', $is_guestbook_url);

        // this assigns db entries output to guestbooks frontend smarty array: [$entries] in plugin_guestbook_entries.tpl
        $entries = $this->generate_EntriesArray($entries, $is_guestbook_url, $wordwrap);

        // Output all possible messages and errors
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
            // assign entries array and good messages array to smarty - beware just using smarty {entries}, it is used by default!
            $serendipity['smarty']->assign(
                    array(
                        'guestbook_messages'    => $messages,
                        'guestbook_entries'     => $entries
                    )
            );
        } else {
            // assign bad messages array to smarty
            $serendipity['smarty']->assign(
                    array(
                        'guestbook_messages'     => $messages
                    )
            );
        }
    } // function generate_EntriesPage() end


    /**
     * Hook for Serendipity events, initialize plug-in features
     *
     * @param  string                   $event
     * @param  serendipity_property_bag $bag
     * @param  array                    $eventData
     * @param  array                    $addData
     * @return boolean
     */
    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        $serendipity['plugin_guestbook_version'] = &$bag->get('version');

        // set global plugin path setting, to avoid different pluginpath '/plugins/' as plugins serendipity vars
        if (!isset($serendipity['guestbook']['pluginpath'])) {
            $pluginpath = pathinfo(dirname(__FILE__));
            $serendipity['guestbook']['pluginpath'] = basename(rtrim($pluginpath['dirname'], '/')) . '/serendipity_event_guestbook/';
        }

        if (isset($hooks[$event])) {

            switch($event) {

                case 'frontend_configure':

                    // checking if db tables exists, otherwise install them
                    $cur = '';
                    $old = $this->get_config('version', '', false);

                    if ($old == '1.0') $cur = $old;

                    if (empty($cur) && ( !empty($old) || ($old == '' && $old != false) )) {
                        $cur = '2.0';
                    } else {
                        $cur = $this->get_config('dbversion');
                    }
                    if ($cur == '1.0') {
                        $this->alter_db($cur);
                        $this->set_config('dbversion', '2.0');
                    } elseif ($cur == '2.0') {
                        $this->alter_db($cur);
                        $this->set_config('dbversion', '3.0');
                        $this->cleanup();
                    } elseif ($cur == '3.0') {
                        $this->alter_db($cur);
                        $this->set_config('dbversion', '4');
                    } elseif ($cur == '4') {
                        $this->alter_db($cur);
                        $this->set_config('dbversion', '5');
                    } elseif ($cur == '5') {
                        continue;
                    } else {
                        $this->install();
                        $this->set_config('dbversion', '5');
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
                        $serendipity['head_subtitle'] = $this->html_specialchars($serendipity['blogTitle']);
                    }

                    break;

                case 'entry_display':
                    if ($this->selected()) {
                        // This is important to not display an entry list!
                        if (is_array($eventData)) {
                                $eventData['clean_page'] = true;
                        } else {
                            $eventData = array('clean_page' => true);
                        }
                    }

                    return true;
                    break;

                case 'entries_header':
                    // this one really rolls up output: check form submit, generate entries and form
                    $this->generate_Page();

                    return true;
                    break;

                case 'external_plugin':
                    // [0]=guestbookdlsql; [1]=filename;
                    $gb['export'] = explode('/', $eventData);

                    if ($gb['export'][0] == 'guestbookdlsql') {
                        $file = file_get_contents ($serendipity['serendipityPath'] . 'templates_c/guestbook/'.$gb['export'][1]);
                        echo $file;
                        header('Status: 302 Found');
                        header('Content-Type: application/octet-stream; charset=UTF-8'); // text/plain to see as file in browser
                        header('Content-Disposition: inline; filename='.$gb['export'][1]);
                    }
                    break;

                // put here all you css stuff you need for frontend guestbook pages
                case 'css':

                    if (stristr($eventData, '#guestbook_wrapper')) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        return true;
                    }

                    $tfile = serendipity_getTemplateFile('style_guestbook_frontend.css', 'serendipityPath');
                    if ($tfile) {
                        $search       = array('{TEMPLATE_PATH}', '{PLUGIN_PATH}');
                        $replace      = array('templates/' . $serendipity['defaultTemplate'] . '/', $serendipity['guestbook']['pluginpath']);
                        $tfilecontent = str_replace($search, $replace, @file_get_contents($tfile));
                    }

                    if (!$tfile || $tfile == 'style_guestbook_frontend.css') {
                        $tfile        = dirname(__FILE__) . '/style_guestbook_frontend.css';
                        $search       = array('{TEMPLATE_PATH}', '{PLUGIN_PATH}');
                        $tfilecontent = str_replace($search, $serendipity['guestbook']['pluginpath'], @file_get_contents($tfile));
                    }
                    if (!empty($tfilecontent)) $this->cssEventData($eventData, $tfilecontent);

                    return true;
                    break;

                case 'backend_sidebar_entries':
                    // forbid sidebar link if user is not in admin group level
                    if ($serendipity['serendipityUserlevel'] < USERLEVEL_ADMIN) {
                        return false;
                    }
                    if ($serendipity['version'][0] < '2') {
                        echo "\n".'<li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=guestbook">' . PLUGIN_GUESTBOOK_ADMIN_NAME . '</a></li>'."\n";
                    }

                    return true;
                    break;

                case 'backend_sidebar_admin_appearance':
                    // forbid sidebar link if user is not in admin group level
                    if ($serendipity['serendipityUserlevel'] < USERLEVEL_ADMIN) {
                        return false;
                    }
                    if ($serendipity['version'][0] >= '2') {
                        echo "\n".'<li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=guestbook">' . PLUGIN_GUESTBOOK_ADMIN_NAME . '</a></li>'."\n";
                    }

                    return true;
                    break;

                case 'backend_sidebar_entries_event_display_guestbook':

                    // forbid entry access if user is not in admin group level
                    if ($serendipity['serendipityUserlevel'] < USERLEVEL_ADMIN) {
                        return false;
                    }
                    // show backend administration menu
                    $this->gbadminpanel();

                    return true;
                    break;

                // put here all you css stuff you need for the backend of guestbook pages
                case 'css_backend':

                    if (stristr($eventData, '#wrapGB')) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        return true;
                    }
                    $tfile = serendipity_getTemplateFile('style_guestbook_backend.css', 'serendipityPath');
                    if ($tfile) {
                        $search       = array('{TEMPLATE_PATH}', '{PLUGIN_PATH}');
                        $replace      = array('templates/' . $serendipity['defaultTemplate'] . '/', $serendipity['guestbook']['pluginpath']);
                        $tfilecontent = str_replace($search, $replace, @file_get_contents($tfile));
                    }

                    if ( (!$tfile || $tfile == 'style_guestbook_backend.css') && !$tfilecontent) {
                        $tfile        = dirname(__FILE__) . '/style_guestbook_backend.css';
                        $search       = array('{TEMPLATE_PATH}', '{PLUGIN_PATH}');
                        $tfilecontent = str_replace($search, $serendipity['guestbook']['pluginpath'], @file_get_contents($tfile));
                    }
                    // overwrite Serendipity 1.7 .serendipityAdminContent span !important
                    if ($serendipity['version'][0] < '2') {
?>
#wrapGB .gb_entryhead span {color: #CCDDE7 !important;}
#wrapGB .gb_entrybody span {color: #222 !important;}
#wrapGB .msg_error,
#wrapGB .msg_success,
#wrapGB .msg_notice,
#wrapGB .msg_hint {
    display: block;
    margin: 1.5em 0;
    padding: .5em;
}
#wrapGB .msg_error {
    background: #f2dede;
    border: 1px solid #e4b9b9;
    color: #b94a48;
}
#wrapGB .msg_success {
    background: #dff0d8;
    border: 1px solid #c1e2b3;
    color: #468847;
}
#wrapGB .msg_notice {
    background: #fcf8e3;
    border: 1px solid #fbeed5;
    color: #c09853;
}
#wrapGB .msg_hint {
    background: #eee;
    border: 1px solid #aaa;
    color: #777;
}
<?php
                    }
                    // add replaced css content to the end of serendipity_admin.css
                    if (!empty($tfilecontent)) $this->cssEventData($eventData, $tfilecontent);

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

    /**
     * Add front- and backend css to serendipity(_admin).css
     *
     * @param  array   $eventData
     * @param  array   $addData
     *
     */
    function cssEventData(&$eventData, &$becss) {
        $eventData .= $becss;
    }


    /**
     * Main admin backend function
     *
     * switch to selected navigation parts of $serendipity['GET']['guestbookcategory']
     * parts: view, add, approve, admin panel
     *
     */
    function gbadminpanel() {
        global $serendipity;
        global $messages;

        if (!is_object($serendipity['smarty'])) {
            serendipity_smarty_init();
        }

        $moderate   = (serendipity_db_bool($this->get_config('showapp')) || serendipity_db_bool($this->get_config('automoderate'))) ? true : false;
        $gbcat      = !empty($serendipity['GET']['guestbookcategory']) ? $serendipity['GET']['guestbookcategory'] : $serendipity['POST']['guestbookcategory'];

        if (!isset($serendipity['POST']['guestbookadmin'])) {
            $serendipity['smarty']->assign(
                array(
                    'gb_liva'     => (!isset($serendipity['GET']['guestbookcategory']) || $serendipity['GET']['guestbookcategory'] == 'gbview') ? ' id="active"' : '',
                    'gb_liapa'    => ($serendipity['GET']['guestbookcategory'] == 'gbapp' || $serendipity['POST']['guestbook_category'] == 'gbapp') ? ' id="active"' : '',
                    'gb_liada'    => (($serendipity['GET']['guestbookcategory'] == 'gbadd' || $serendipity['POST']['guestbookcategory'] == 'gbadd') && $serendipity['POST']['guestbook_category'] != 'gbapp') ? ' id="active"' : '',
                    'gb_lida'     => $serendipity['GET']['guestbookcategory'] == 'gbdb' ? ' id="active"' : '',
                    'gb_moderate' => $moderate,
                    'gb_isnav'    => true
                )
            );
        }

        // assign form array entries to smarty
        $serendipity['smarty']->assign(
                array(
                    'plugin_guestbook_backend_path'    => $_SERVER['PHP_SELF'] . '?serendipity[adminModule]=event_display&serendipity[adminAction]=guestbook&serendipity[guestbookcategory]=gbadd',
                    'is_guestbook_admin_noapp'         => true
                )
        );

        // check for REQUESTS, approve, re-edit, remove from database table
        switch($gbcat) {

            case 'gbview':
            default:
                $serendipity['smarty']->assign('gb_view', true);

                // view all approved(1) entries in a table
                $ve = $this->backend_guestbook_view(1, 'gbview');

                if ($ve === false) $serendipity['smarty']->assign('is_gbadmin_noviewresult', true);
                break;

            case 'gbapp':
                if ($moderate === true) {
                    $serendipity['smarty']->assign('gb_app', true);
                    // view all unapproved(0) entries in a table
                    $this->backend_guestbook_moderate();
                }
                break;

            case 'gbadd':
                $entry = $this->backend_request_checks();

                if (!isset($serendipity['guestbook_message_header']) && isset($serendipity['POST']['guestbookform']) !== true) {
                    $serendipity['smarty']->assign('gb_add', true);
                }

                if (isset($serendipity['POST']['guestbookform']) === true) {
                    // set a guestbook backend header to submit without frontend checks
                    $serendipity['guestbook_backend_header'] = true;
                    // check form vars
                    $this->checkSubmit();
                }

                if ($serendipity['guestbook_message_header'] === true) {
                    if (count($messages) < 1 && $serendipity['guestbook_message_header'] === false) {
                        array_push($messages, PLUGIN_GUESTBOOK_MESSAGE . ': ' . ERROR_UNKNOWN . '<br>' . ERROR_NOCAPTCHASET);
                    }
                    $error_occured = ($serendipity['guestbook_message_header'] === true) ? THANKS_FOR_ENTRY : ERROR_OCCURRED;

                    if ($moderate === true && $serendipity['POST']['guestbook_category'] == 'gbapp') {

                        $serendipity['smarty']->assign(array('gb_gbadd_approve' => true, 'msg_header' => $error_occured, 'guestbook_messages' => $messages));

                        // came from moderation table view and goes back
                        $this->backend_guestbook_moderate();

                    } else {

                        $serendipity['smarty']->assign(array('gb_gbadd_view' => true, 'msg_header' => $error_occured, 'guestbook_messages' => $messages));

                        // view all approved entries in a table
                        $ve = $this->backend_guestbook_view(1, 'gbview');

                        if ($ve === false) $serendipity['smarty']->assign('is_gbadmin_noviewresult', true);

                    }

                } else {
                    // fallback to new ENTRY FORM, since there was an error - no need to escape
                   if ($serendipity['guestbook_message_header'] === false ) {
                        foreach($serendipity['POST'] as $sk => $sv) {
                            $entry[$sk] = $sv;
                        }
                        foreach($_POST['guestbook'] as $gk => $gv) {
                            $entry[$gk] = $gv;
                        }
                        $entry['body'] = $entry['comment'];
                        $serendipity['smarty']->assign(array('gb_gbadd_add' => true, 'msg_header' => $error_occured, 'guestbook_messages' => $messages));
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

                    // assign form array entries to smarty
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

                    // get the guestbook entries template file
                    echo $this->parseTemplate('plugin_guestbook_backend_form.tpl');

                }

                break;

            case 'gbdb':

                $serendipity['smarty']->assign('gb_db', true);

                // check if table exists, so there is nothing to do, except some insert stuff :: result is a single row array
                if (is_string($this->check_isdb())) {
                    $serendipity['smarty']->assign('is_gbadmin_nodbcdb', true);
                } else {
                    // add event form
                    $this->backend_guestbook_dbclean();
                }

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

    } // gbadminpanel() end


    /**
     * Fake call to check if database is set and ready
     *
     * @return mixed string/array
     */
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
     * Get sql results and assign them to smarty
     *
     * @param  int     $ap    approved yes/no = 1/0
     * @param  string  $cat   serendipity[guestbookcategory]
     * @return boolean is_arrray($entries)
     */
    function backend_guestbook_view($ap, $cat) {
        global $serendipity;
        global $messages;

        $count = $this->countEntriesDB($ap); // approved=1

        if (is_array($count)) {
            $result = $this->backend_guestbook_paginator($count[0], $ap, $cat);
        }

        if (!is_numeric($wordwrap)) {
            $wordwrap = 50;
        }

        if (isset($result['paginator'])) {
            // slice and save last element of $result
            $paginator = array_pop($result);
        }

        // this assigns db entries output to guestbooks backend smarty array: {$entries}
        $entries = $this->generate_EntriesArray($result, $_SERVER['PHP_SELF'], $this->get_config('wordwrap'), true);

        // assign entries array and good messages array to smarty - do not use smarty {entries}, since used by s9y core
        $serendipity['smarty']->assign(
                array(
                    'guestbook_messages'        => $messages,
                    'guestbook_entries'         => $entries,
                    'guestbook_paginator'       => $paginator,
                    'guestbook_message_header'  => $serendipity['guestbook_message_header']
                )
        );

        // get the guestbook entries template file
        echo $this->parseTemplate('plugin_guestbook_backend_entries.tpl');

        return is_array($entries) ? true : false;
    }


    /**
     * Main backend function to generate moderation table view
     *
     */
    function backend_guestbook_moderate() {
        global $serendipity;

        // assign form array entries to smarty
        $serendipity['smarty']->assign('is_guestbook_admin_noapp', false);

        // view all unapproved(0) entries in a table
        $va = $this->backend_guestbook_view(0, 'gbapp');

        if ($va === false) $serendipity['smarty']->assign('is_gbadmin_noappresult', true);
    }


    /**
     * Main backend function navigation number 4
     * plugins panel administration
     * switch into dump, insert, erase, download
     *
     * @return boolean
     */
    function backend_guestbook_dbclean() {
        global $serendipity;

        $adminpath = $_SERVER['PHP_SELF'] . '?serendipity[adminModule]=event_display&serendipity[adminAction]=guestbook&serendipity[guestbookcategory]=gbdb';
        $dbclean   = !empty($serendipity['GET']['guestbookdbclean']) ? $serendipity['GET']['guestbookdbclean'] : 'start';

        // check if table exists, so there is nothing to do except some insert stuff :: result is a single row array
        if (is_string($this->check_isdb()) && $dbclean != 'dbinsert' && $dbclean != 'dbicallog') $dbclean = 'dbnixda';

        if (!empty($dbclean)) {
            switch($dbclean) {
                case 'dbdump':
                    if ($this->backend_guestbook_backup()) {
                        $serendipity['smarty']->assign('is_guestbook_admin_backup', true);
                    } else {
                        $serendipity['smarty']->assign('is_guestbook_admin_backup', false);
                    }
                    break;

                case 'dbinsert':
                    $serendipity['smarty']->assign('is_guestbook_admin_insert', true);
                    break;

                case 'dberase':
                    $serendipity['smarty']->assign('is_guestbook_admin_erase', true);
                    $isTable = $this->uninstall($bag) ? true : false; // ok, questionaire
                    // give back ok
                    if (isset($serendipity['guestbookdroptable']) === true && $isTable) {
                        $serendipity['smarty']->assign(array('is_guestbook_admin_erase_msg' => true, 'plugin_gb_dbc_message' => sprintf(PLUGIN_GUESTBOOK_ADMIN_DROP_OK, $serendipity['dbPrefix'].'guestbook')));
                    }
                    break;

                case 'dbdownload':
                    $serendipity['smarty']->assign('is_guestbook_admin_download', true);
                    if (is_dir('templates_c/guestbook')) {
                        $str = $this->backend_read_backup_dir('templates_c/guestbook/', $adminpath.'&serendipity[guestbookdbclean]=dbdelfile&serendipity[guestbookdbcleanfilename]=');
                        $serendipity['smarty']->assign(array('is_guestbook_admin_download_msg' => true, 'gb_read_backup_dir' => $str));
                    } else {
                        $serendipity['smarty']->assign('is_guestbook_admin_download_msg', false);
                    }
                    break;

                case 'dbinsfile':
                    $insfile = false;
                    if (isset($serendipity['GET']['guestbookdbinsertfilename'])) {
                        $old = getcwd(); // Save the current directory
                        @chdir('templates_c/guestbook/');
                        if (is_file($serendipity['GET']['guestbookdbinsertfilename'])) {
                            @unlink($serendipity['GET']['guestbookdbinsertfilename']);
                        }
                        @chdir($old); // Restore the old working directory
                        $serendipity['smarty']->assign(array('is_guestbook_admin_insfile_msg' => true, 'plugin_gb_dbc_message' => sprintf(PLUGIN_GUESTBOOK_ADMIN_DBC_DELFILE_MSG, $serendipity['GET']['guestbookdbcleanfilename'])));
                    }
                    break;

                case 'dbdelfile':
                    $delfile = false;
                    if (isset($serendipity['GET']['guestbookdbcleanfilename'])) {
                        $old = getcwd(); // Save the current directory
                        @chdir('templates_c/guestbook/');
                        if (is_file($serendipity['GET']['guestbookdbcleanfilename'])) {
                            @unlink($serendipity['GET']['guestbookdbcleanfilename']);
                        }
                        @chdir($old); // Restore the old working directory
                        $serendipity['smarty']->assign(array('is_guestbook_admin_delfile_msg' => true, 'plugin_gb_dbc_message' => sprintf(PLUGIN_GUESTBOOK_ADMIN_DBC_DELFILE_MSG, $serendipity['GET']['guestbookdbcleanfilename'])));
                    }
                    break;

                case 'dbnixda':
                    $serendipity['smarty']->assign('is_guestbook_admin_dbempty', true);
                    break;

                default:
                    break;

            }
        }
        // assign form array entries to smarty
        $serendipity['smarty']->assign(
                        array(
                            'plugin_gb_dump'      => @$serendipity['GET']['guestbookdbclean'] == 'dbdump' ? ' id="active"' : '',
                            'plugin_gb_insert'    => @$serendipity['GET']['guestbookdbclean'] == 'dbinsert' ? ' id="active"' : '',
                            'plugin_gb_erase'     => @$serendipity['GET']['guestbookdbclean'] == 'dberase' ? ' id="active"' : '',
                            'plugin_gb_download'  => @$serendipity['GET']['guestbookdbclean'] == 'dbdownload' ? ' id="active"' : '',
                            'plugin_gb_adminpath' => $adminpath,
                            'plugin_gb_ilogerror' => $serendipity['guestbook']['ilogerror'],
                            'plugin_gb_dropmsg'   => $serendipity['guestbookdroptable']
                        )
        );

        // get the guestbook db administration template file
        echo $this->parseTemplate('plugin_guestbook_backend_dbc.tpl');

    } // backend_guestbook_dbclean() end


    /**
     * Read the sqldump backup directory - function scanDir() >= php5
     *
     * @param  string $dpath      relative path
     * @param  string $delpath    url path
     */
    function backend_read_backup_dir($dpath, $delpath) {
        global $serendipity;
        $dir = array_slice(@scanDir($dpath), 2);
        $url = $serendipity['serendipityHTTPPath'] . 'plugin/guestbookdlsql/';
        if (is_array($dir) && !empty($dir)) {
            $str = '<table width="100%">';
            foreach ($dir as $e) {
                $str .= '<tr><td align="left"><a href="'.$url.$e.'">';
                $str .= $e.'</a></td> <td align="right" class="gb_button"><a href="'.$delpath.$e.'"><input type="submit" class="input_button state_cancel" name="erase file" value=" ' . TEXT_DELETE . ' "></a></td></tr>'."\n";
            }
            $str .= '</table>';
            return $str;
        }
    }


    /**
     * Create prettified questionaire buttons string
     *
     * @param  string text   - the question text string
     * @param  string url    - the url string to pass
     * @param  string addno  - the add to url string in case of no proceed
     * @param  string addyes - the add to url string in case of YES
     * @return string
     */
    function backend_guestbook_questionaire($text, $url, $addno, $addyes) {
        global $serendipity;
        if (!is_object($serendipity['smarty'])) {
            serendipity_smarty_init();
        }

        $serendipity['smarty']->assign(
                        array(
                            'is_plugin_gb_questionaire'     => true,
                            'plugin_gb_questionaire_text'   => $text,
                            'plugin_gb_questionaire_url'    => $url,
                            'plugin_gb_questionaire_addno'  => $addno,
                            'plugin_gb_questionaire_addyes' => $addyes
                        )
        );
        return;
    }


    /**
     * Guestbook backup table and dir/file voodoo
     *
     * @return boolean
     */
    function backend_guestbook_backup() {
        global $serendipity;

        set_time_limit(360);

        $date = date('Y-m-d_H-i-s');
        $directory = "guestbook";
        if (!is_dir('templates_c/' . $directory)) {
            @mkdir('templates_c/' . $directory, 0777);
        }
        $file = $serendipity['serendipityPath'] . 'templates_c/guestbook/'.$date.'_guestbook.sql';
        $fp   = fopen($file, 'w');
        if ($fp) {
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
     * Create backend entries paginator
     *
     * @param  int      $c   = count entries
     * @param  int      $ap  = approved yes/no = 1/0
     * @param  string   $cat = serendipity[guestbookcategory]
     *
     * @return mixed array/boolean $result
     */
    function backend_guestbook_paginator($c, $ap, $cat) {
        global $serendipity;

        if (isset($serendipity['POST']['guestbooklimit'])) $serendipity['GET']['guestbooklimit'] = $serendipity['POST']['guestbooklimit'];
        if (isset($serendipity['GET']['guestbooklimit'])) {
            $paginator = $serendipity['GET']['guestbooklimit'];
        } else {
            $paginator = 1;
        }
        // max rows per page
        $rows_per_page = $this->get_config('maxitems');

        if (!is_numeric($rows_per_page)) {
            $rows_per_page = 15;
        }

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

        ob_start();

        if (is_array($result)) {
            if ($paginator == 1) {
                echo '<span class="gb_paginator_left"> FIRST | PREVIOUS </span>'."\n";
            } else {
                $prevpage = $paginator-1;
                echo '<span class="gb_paginator_left">';
                echo ' <a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=guestbook&amp;serendipity[guestbookcategory]='.$cat.'&amp;serendipity[guestbooklimit]=1"><input type="button" class="input_button" name="FIRST" value=" &laquo;&laquo; FIRST "></a> | '."\n";
                echo ' <a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=guestbook&amp;serendipity[guestbookcategory]='.$cat.'&amp;serendipity[guestbooklimit]='.$prevpage.'"><input type="button" class="input_button" name="PREVIOUS" value=" &laquo; PREVIOUS "></a> '."\n";
                echo '</span>';
            }

            echo '<span class="gb_paginator_center">  ( Page '.$paginator.' of '.$lastpage.' ) </span>'."\n";

            if ($paginator == $lastpage) {
                echo '<span class="gb_paginator_right"> NEXT | LAST </span>'."\n";
            } else {
                $nextpage = $paginator+1;
                echo '<span class="gb_paginator_right">';
                echo ' <a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=guestbook&amp;serendipity[guestbookcategory]='.$cat.'&amp;serendipity[guestbooklimit]='.$nextpage.'"><input type="button" class="input_button" name="NEXT" value=" NEXT &raquo; "></a> | '."\n";
                echo ' <a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=guestbook&amp;serendipity[guestbookcategory]='.$cat.'&amp;serendipity[guestbooklimit]='.$lastpage.'"><input type="button" class="input_button" name="LAST" value=" LAST &raquo;&raquo; "></a> '."\n";
                echo '</span>';
            }
        }

        $result['paginator'] = ob_get_contents();
        ob_end_clean();

        return is_array($result) ? $result : false;
    } // function backend paginator end


    /**
     * set global $serendipity['guestbook_message_header'] to true in case of approve or erase entry
     *
     * @return array $entry to re-edit and change
     */
    function backend_request_checks() {
        global $serendipity;
        global $messages;

        if (!is_array($messages)) {
            $messages = array();
        }

        $id = (int)$_POST['guestbook']['id'];

        // approve events
        if ( ( isset($_POST['Approve_Selected']) || isset($_POST['Approve_Selected_x']) || isset($_POST['Approve_Selected_y']) ) && isset($id)) {

            $sql = "UPDATE {$serendipity['dbPrefix']}guestbook SET approved=1 WHERE id=$id";
            $result = serendipity_db_query($sql, true, 'both', true);

            if ($result) {
                array_push($messages, sprintf(PLUGIN_GUESTBOOK_APP_ENTRY, $id));
                $serendipity['guestbook_message_header'] = true;
            }
        }

        // reject events
        if ( ( isset($_POST['Reject_Selected']) || isset($_POST['Reject_Selected_x']) || isset($_POST['Reject_Selected_y']) ) && isset($id)) {

            $sql = "DELETE FROM {$serendipity['dbPrefix']}guestbook WHERE id=$id";
            $result = serendipity_db_query($sql, true, 'both', true);

            if ($result) {
                array_push($messages, sprintf(RIP_ENTRY, $id));
                $serendipity['guestbook_message_header'] = true;
            }
        }

        // an authenticated logged-in user tries to change an anapproved event via app form
        if ( ( isset($_POST['Change_Selected']) || isset($_POST['Change_Selected_x']) || isset($_POST['Change_Selected_y']) ) && isset($id)) {

            // select a specific entry by id
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}guestbook WHERE id=$id";
            // show single entry to re-edit :: result is a single row array
            $entry = serendipity_db_query($sql, true, 'assoc', true);
        }

        // an authenticated logged-in user tries to change a single entry
        if (isset($entry) && is_array($entry)) return $entry;
    }

}

/* vim: set sts=4 ts=4 expandtab : */
