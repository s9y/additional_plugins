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
        $propbag->add('version',       '1.10');

        $propbag->add('event_hooks',    array(
            'entry_display' => true,
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

        $propbag->add('legal',    array(
            'services' => array(
                'twitter' => array(
                    'url'  => 'https://www.twitter.com/',
                    'desc' => 'Transmits comment data and metadata to twitter.'
                ),
                'identica' => array(
                    'url'  => 'http://www.identi.ca',
                    'desc' => 'Transmits comment data and metadata to identica.'
                ),
                'audio/boo' => array(
                    'url'  => 'http://boo.fm',
                    'desc' => 'Transmits comment data and metadata to boo.fm / audioboo.fm.'
                ),
                'rss' => array(
                    'url'  => '#',
                    'desc' => 'Transmits comment data and metadata to RSS'
                ),
            ),
            'frontend' => array(
                'Various webservices can be enabled to provide widget functionality for enhancing user comments',
                'Comment data and metadata may be transferred to the configured service providers'
            ),
            'backend' => array(
            ),
            'cookies' => array(
                '"Remember me" functionality can be offered when commenting with specific service providers'
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => true,
            'transmits_user_input'  => true
        ));
        $config_bee = array();
        if (!class_exists('serendipity_event_spamblock_bee')) { // Only do that, if spamblock is not installed.
            $config_bee[] = 'hint_bee';
        }
        
        $config_switchexpert = array('expert_switch');
        $config_twitter = array('title_twitter','twitterinput','followme_widget', 'followme_widget_counter','followme_widget_dark');
        $config_twitter_expert = array('twitterinput_nofollow','smartifytwitter','inputpatched_twitter');
        $config_announce = array('title_announcerss', 'announcerss', 'announcerssmax', 'announceonce', 'style_inputrss');
        $config_announce_expert = array('announcersscachemin','announcerss_nofollow','smartifyannouncerss','inputpatched_rss');
        
        $config_rules = array('title_rules', 'rule_extras_commentcount', 'rule_extras_commentlength');
        $config_rules_extra = array('rule_dofollow_commentcount', 'rule_dofollow_commentlength');
        
        $config_boo = array('title_boo','allow_boo','moderate_boo');
        
        $config_general = array('title_general');
        if (function_exists('fetchPingbackData') && $this->isLocalConfigWritable()) {
            $config_general[] = 'fetchPingback';
        }
        $config_general[] = 'custom_text';
        $config_general_expert = array('plugin_path');
        
        $open_expert_setting = isset($_GET['pluginexpert']);
        if ($open_expert_setting) {
            $configuration = array_merge($config_bee, $config_switchexpert,$config_twitter, $config_twitter_expert, $config_announce, $config_announce_expert, $config_boo, $config_rules, $config_rules_extra, $config_general, $config_general_expert);
        }
        else {
            $configuration = array_merge($config_bee, $config_switchexpert,$config_twitter, $config_announce, $config_rules, $config_general);
        }
        $propbag->add('configuration', $configuration );
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENT_COMMENTSPICE_TITLE;
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;
        
        $yesnorules = array(
            "enabled" => PLUGIN_EVENT_COMMENTSPICE_ENABLED,
            "disabled" => PLUGIN_EVENT_COMMENTSPICE_DISABED,
            "rules" => PLUGIN_EVENT_COMMENTSPICE_RULES,
        );
        switch($name) {
            case 'expert_switch':
                $actConfigUrl = $_SERVER["REQUEST_URI"];
                $querypar = "&pluginexpert";
                if (strpos($actConfigUrl, $querypar) === FALSE) {
                    $tablink = $actConfigUrl . $querypar;
                    $tabvalue = PLUGIN_EVENT_COMMENTSPICE_EXPERTSETTINGS;
                }
                else {
                    $tablink = str_replace($querypar, '', $actConfigUrl);
                    $tabvalue = PLUGIN_EVENT_COMMENTSPICE_STANDARDSETTINGS;
                }
                $htmlswitchline .= '<img src="' . $serendipity['baseURL'] . 'index.php?/plugin/commentspice.png" style="float:right"> [<a href="' . $tablink . '" class="serendipity_pluginconfig_tab">'. $tabvalue .'</a>] ';

                $propbag->add('type',           'content');
                $propbag->add('default',        $htmlswitchline);
                break;

            case 'title_twitter':
                $propbag->add('type', 'content');
                $propbag->add('default',   '<h3>' . PLUGIN_EVENT_COMMENTSPICE_CONFIG_TWITTERNAME .'</h3>');
                break;
            case 'twitterinput':
                $propbag->add('type',       'select');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_DESC);
                $propbag->add('select_values', $yesnorules);
                $propbag->add('default',     'enabled');
                break;
            case 'twitterinput_nofollow':
                $propbag->add('type',       'select');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_NOFOLLOW);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_NOFOLLOW_DESC);
                $propbag->add('select_values', $yesnorules);
                $propbag->add('default',     'enabled');
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

            case 'title_announcerss':
                $propbag->add('type', 'content');
                $propbag->add('default',   '<br/><h3>' . PLUGIN_EVENT_COMMENTSPICE_CONFIG_ANNOUNC_RSS .'</h3>');
                break;
            case 'announcerss':
                $propbag->add('type',       'select');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_DESC);
                $propbag->add('select_values', $yesnorules);
                $propbag->add('default',     'disabled');
                break;
            case 'announcerss_nofollow':
                $propbag->add('type',       'select');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_NOFOLLOW);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_NOFOLLOW_DESC);
                $propbag->add('select_values', $yesnorules);
                $propbag->add('default',     'disabled');
                break;
            case 'announcerssmax':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT_DESC);
                $propbag->add('default',     3);
                break;
            case 'announceonce':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_ONCEONLY);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_ONCEONLY_DESC);
                $propbag->add('default',     true);
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
            case 'style_inputrss':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_STYLE_RSS);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_STYLE_RSS_DESC);
                $propbag->add('default',     true);
                break;
            case 'inputpatched_twitter':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_TWITTER);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_TWITTER_DESC);
                $propbag->add('default',     false);
                break;
            case 'inputpatched_rss':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_RSS);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_RSS_DESC);
                $propbag->add('default',     false);
                break;
                
            case 'title_boo':
                $propbag->add('type', 'content');
                $propbag->add('default',   '<br/><h3>' . PLUGIN_EVENT_COMMENTSPICE_CONFIG_BOO .'</h3>' . PLUGIN_EVENT_COMMENTSPICE_CONFIG_BOO_DESC);
                break;
            case 'allow_boo':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_BOO_ALLOW);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_BOO_ALLOW_DESC);
                $propbag->add('default',     false);
                break;
            case 'moderate_boo':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_BOO_MODERATE);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_BOO_MODERATE_DESC);
                $propbag->add('default',     true);
                break;

            case 'title_rules':
                $propbag->add('type', 'content');
                $propbag->add('default',   '<br/><h3>' . PLUGIN_EVENT_COMMENTSPICE_CONFIG_RULES .'</h3>');
                break;
            case 'rule_extras_commentcount':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTCOUNT);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTCOUNT_DESC);
                $propbag->add('default', 0);
                break;
            case 'rule_extras_commentlength':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTLENGTH);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTLENGTH_DESC);
                $propbag->add('default', 0);
                break;
            case 'rule_dofollow_commentcount':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTCOUNT);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTCOUNT_DESC);
                $propbag->add('default', 0);
                break;
            case 'rule_dofollow_commentlength':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTLENGTH);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTLENGTH_DESC);
                $propbag->add('default', 0);
                break;
                
            case 'title_general':
                $propbag->add('type', 'content');
                $propbag->add('default',   '<br/><h3>' . PLUGIN_EVENT_COMMENTSPICE_CONFIG_GENERAL .'</h3>');
                break;
            case 'plugin_path':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_COMMENTSPICE_PATH);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_PATH_DESC);
                $propbag->add('default', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_commentspice/');
                break;
            case 'fetchPingback':
                $fetchPingbackValues = array (
                    'none' => $serendipity['pingbackFetchPage']?PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_LEAVE_ON:PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_LEAVE_OFF,
                );
                if ($serendipity['pingbackFetchPage']) $fetchPingbackValues['false'] = PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_DONTFETCH;
                else  $fetchPingbackValues['true'] = PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_FETCH;
                $propbag->add('type',       'select');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK);
                $propbag->add('description', PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_DESC);
                $propbag->add('select_values', $fetchPingbackValues);
                $propbag->add('default',     'none');
                break;

            case 'hint_bee':
                $propbag->add('type', 'content');
                $propbag->add('default',   PLUGIN_EVENT_COMMENTSPICE_CONFIG_HINTBEE );
                break;

            case 'custom_text':
                $propbag->add('type',        'html');
                $propbag->add('name',        PLUGIN_EVENT_COMMENTSPICE_CONFIG_CUSTOMTEXT);
                $propbag->add('description', '');
                $propbag->add('default',     '');
                break;

            default:
                return false;
        }
        return true;
    }
    
    function event_hook($event, &$bag, &$eventData, $addData = null) {
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
                        case 'spiceicoidentica.png':
                            header('Content-Type: image/png');
                            echo file_get_contents(dirname(__FILE__). '/img/identica_icon.png');
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
                            if ('disabled' == $this->get_config('announcerss', 'disabled')) {
                                echo "DISABLED!";
                                break;
                            }
                            $this->readRss();
                            break;
                        case 'audioboo.png':
                            header('Content-Type: image/png');
                            echo file_get_contents(dirname(__FILE__). '/img/audioboo.png');
                            break;
                        case 'spiceicorecord.png':
                            header('Content-Type: image/png');
                            echo file_get_contents(dirname(__FILE__). '/img/microphone.png');
                            break;
                    }
                    break;
                case 'entry_display':
                    $this->spiceEntry($eventData, $addData);
                    break;
                case 'frontend_saveComment':
                    $result = $this->checkComment($eventData, $addData);
                    return $result;
                    break;
                case 'frontend_saveComment_finish' :
                    $this->commentSaved($eventData, $addData);
                    break;
                case 'frontend_footer':
                    // Comment header code only if in single article mode
                    if (!empty($eventData['GET']['id'])) {
                        $this->printHeader($eventData);
                    }
                    break;
                case 'frontend_display':        
                    if (isset($serendipity['POST']['preview'])) {
                        $this->rememberInputs();
                    }
                    $this->spiceComment($eventData, $addData, isset($serendipity['POST']['preview']));
                    break;
                case 'frontend_comment':
                    $this->printCommentEditExtras($eventData, $addData);
                    break;
                case 'backend_deletecomment' :
                    $this->commentDeleted($eventData, $addData);
                    break;
                case 'css':
                    $this->printCss($eventData, $addData);
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
        global $serendipity;
        
        DbSpice::install($this);
        $announcerssmax = $this->get_config('announcerssmax',3);
        if (!is_numeric($announcerssmax)) {
            $this->set_config('announcerssmax',3);
        }
        $announcersscachemin = $this->get_config('announcersscachemin',90);
        if (!is_numeric($announcersscachemin)) {
            $this->set_config('announcersscachemin',90);
        }
        
        // Asure numeric inputs for rule settings
        $config_rules = array('rule_extras_commentcount','rule_extras_commentlength', 'rule_dofollow_commentcount', 'rule_dofollow_commentlength');
        foreach($config_rules as $config_rule) {
            $check = $this->get_config($config_rule,0);
            if (!is_numeric($check)) {
                $this->set_config($check,0);
            }
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
        
        // Clean up old configurations:
        serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}config where name like 'serendipity_event_commentspice:%required_fields';");
        serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}config where name like 'serendipity_event_commentspice:%do_honeypod';");
        serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}config where name like 'serendipity_event_commentspice:%do_honeypot';");
        serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}config where name like 'serendipity_event_commentspice:%spamlogtype';");
        serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}config where name like 'serendipity_event_commentspice:%spamlogfile';");
    }
    
    function printHeader($eventData) {
        global $serendipity;
        
        if ($this->get_config('announcerss','disabled')!='disabled')
        {

            $path = $this->path = $this->get_config('plugin_path', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_commentspice/');
            $announce_changedby_email = ('rules' == $this->get_config('announcerss', 'disabled') && $this->get_config('rule_extras_commentcount',0))?'true':'false';
            echo "
<script>
    var comentspice_fetchrss = '{$serendipity['baseURL']}index.php?/plugin/commentspicefrss';
    var comentspice_fetchrss_emailchanges = $announce_changedby_email;
    var comentspice_entryid = " . $eventData['GET']['id'] .";
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
            
            // I save no matter what the rules say, it wont display later.
            $twittername = ltrim(trim($serendipity['POST']['twitter']),'@');
            $boourl = $serendipity['POST']['boo'];
            if (isset($serendipity['POST']['promorss']) && !empty($serendipity['POST']['promorss'])) {
                $promorss = $serendipity['POST']['promorss'];
                $parts = explode("\n", $promorss);
                $promo_hash = trim($parts[0]);
                $promo_name = trim($parts[1]);
                $promo_url = trim($parts[2]);
                if (!$this->hashString($promo_name.$promo_url) == $promo_hash) return false;
                
            }
            $result = DbSpice::saveCommentSpice($addData['comment_cid'], $twittername, $promo_name, $promo_url, $boourl);
            $this->rememberInputs();
        }
        return true;
    }
    
    function checkRules($email, $comment, $checkCommentLength=true, $checknofollow=false) {
        $rule_twitter = $this->get_config('twitterinput', 'enabled');
        $rule_announce= $this->get_config('announcerss', 'disabled');
        $rule_twitter_nofollow = $this->get_config('twitterinput_nofollow', 'enabled');
        $rule_announce_nofollow = $this->get_config('announcerss_nofollow', 'disabled');
        $this->log("anf:$rule_announce_nofollow, tnf:$rule_twitter_nofollow");
        
        $result = array();
        $result['allow_twitter'] = $rule_twitter!='disabled';
        $result['allow_announce'] = $rule_announce!='disabled';
        $result['nofollow_twitter'] = $rule_twitter_nofollow=='enabled';
        $result['nofollow_announce'] = $rule_announce_nofollow=='enabled';
        
        $result['allow_boo'] = true;
        
        $commentcount = -1;
        if ('rules' == $rule_announce || 'rules' == $rule_twitter) {
            // Check for comment length
            if ($checkCommentLength) {
                $rule_commentlenght = (int)$this->get_config('rule_extras_commentlength',0);
                $commentlen = empty($comment)?0:strlen($comment);
                $comment_enough = $commentlen>= $rule_commentlenght;
                if ('rules' == $rule_twitter) $result['allow_twitter'] = $result['allow_twitter'] &&  $comment_enough;
                if ('rules' == $rule_announce) $result['allow_announce'] = $result['allow_announce'] &&  $comment_enough;
                
            }

            // Check for comment count
            $rule_commentcount = (int)$this->get_config('rule_extras_commentcount',0);
            if ($rule_commentcount>0) {
                $commentcount = DbSpice::countComments($email);
                $more_comments = (int)$commentcount >= $rule_commentcount;
                if ('rules' == $rule_twitter) $result['allow_twitter'] = $result['allow_twitter'] &&  $more_comments;
                if ('rules' == $rule_announce) $result['allow_announce'] = $result['allow_announce'] &&  $more_comments;
            }
        }
        
        if ($checknofollow && ('rules' == $rule_announce_nofollow || 'rules' == $rule_twitter_nofollow)) {
            // Check for comment length
            if ($checkCommentLength) {
                $rule_commentlenght = (int)$this->get_config('rule_dofollow_commentlength',0);
                $commentlen = empty($comment)?0:strlen($comment);
                $comment_enough = $commentlen>= $rule_commentlenght;
                $this->log("checkCommentLenght. len:$commentlen, rulen:$rule_commentlenght - enough:$comment_enough");
                if ('rules' == $rule_twitter_nofollow) $result['nofollow_twitter'] = $result['nofollow_twitter'] ||  !$comment_enough;
                if ('rules' == $rule_announce_nofollow) $result['nofollow_announce'] = $result['nofollow_announce'] || !$comment_enough;
                
            }

            // Check for comment count
            $rule_commentcount = (int)$this->get_config('rule_dofollow_commentcount',0);
            if ($rule_commentcount>0) {
                $commentcount = ($commentcount==-1?DbSpice::countComments($email):$commentcount);
                $more_comments = (int)$commentcount >= $rule_commentcount;
                $this->log("checkCommentCount. cnt:$commentcount, rucnt:$rule_commentcount - more:$more_comments");
                if ('rules' == $rule_twitter_nofollow) $result['nofollow_twitter'] = $result['nofollow_twitter'] ||  !$more_comments;
                if ('rules' == $rule_announce_nofollow) $result['nofollow_announce'] = $result['nofollow_announce'] ||  !$more_comments;
            }
        }
        $this->log("checkRules($email,$comment,$checkCommentLength,$checknofollow): " . print_r($result,true));
        return $result;
    }
    
    function rememberInputs() {
        global $serendipity;
        // Remember twitter name value into cookie, if user ordered to, else clear cookie
        if (isset($serendipity['POST']['remember'])) {
            // Remember twitter name, remove leading @ if found
            serendipity_rememberCommentDetails(array ('twitter' => ltrim(trim($serendipity['POST']['twitter']),'@')));
        }
        else {
            serendipity_forgetCommentDetails(array('twitter'));
        }
    }
    function checkComment(&$eventData, &$addData) {
        global $serendipity;
        
        if ("NORMAL" == $addData['type']) { // only supported for normal comments
            $this->rememberInputs();

            // Check, if promoted URL is still valid (unmodified) 
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
            
            // Check, if an boo URL was set and if it seems to be valid:
            if (isset($serendipity['POST']['boo']) && !empty($serendipity['POST']['boo'])) {
                $boourl = $serendipity['POST']['boo'];
                $isBoo = preg_match('@^https?://(audio)?boo.fm/boos/@',$boourl);
                //$isBoo = (strpos($boourl, 'http://audioboo.fm/boos/') === 0 || (strpos($boourl, 'https://audioboo.fm/boos/') === 0));
                if ($isBoo) {
                    $test = str_ireplace('https;//', 'http://', $boourl);                    
                    $test = str_replace('http://audioboo.fm/boos/', '', $test);       
                    $test = str_replace('http://boo.fm/boos/', '', $test);       
                    $testfields = explode('/', $test);
                    $isBoo = count($testfields) == 1;
                    if ($isBoo) {
                        $testfields = explode('-', $test);
                        $isBoo = is_numeric($testfields[0]);
                    }
                }
                if (!$isBoo) {
                    $eventData = array ('allow_comments' => false);
                    $serendipity ['messagestack'] ['comments'] [] = PLUGIN_EVENT_COMMENTSPICE_BOO_WRONG;
                    return false;
                }
                if (serendipity_db_bool($this->get_config('moderate_boo',true))) {
                    $eventData['moderate_comments'] = true;
                    $serendipity['csuccess']        = 'moderate';
                    $serendipity['moderate_reason'] = sprintf(PLUGIN_EVENT_COMMENTSPICE_BOO_MODERATED);
                }
            }
            
        }
        return true;
    }
    function readRss() {
        global $serendipity;
        
        $comment_url = $_REQUEST ['coment_url'];
        $this->log("readRss for $comment_url");
        $comment_email = $_REQUEST ['coment_email'];
        $this->log("email=$comment_email");
        $entryId = $_REQUEST ['entryid'];
        $this->log("entryid=$entryId");
        
        $result= array("url"=>$comment_url, "email"=>$comment_email, "articles"=>array());
        
        if (empty($comment_url)) {
            echo json_encode($result);
            return;
        }
        
        $allow = $this->checkRules($comment_email, null, false);
        if (!$allow['allow_announce']) {
            $this->log("Announce not allowed by email. result: " . print_r($result,TRUE));
            echo json_encode($result);
            return;
        }
                
        // First try to read from cache
        $result = $this->cacheReadRss($comment_url);
        if (empty($result)) {
            $result = $this->readRssRemote($comment_url);
            $this->log("Fetched array: " . print_r($result, true));
            if (!empty($result) && $result['articles']) $this->cacheWriteRss($comment_url, $result);
        }
        $result['email'] = $comment_email;
        if (empty($result) || !$result['articles'] || count($result['articles'])==0) {
            echo json_encode($result);
            return;
        }
        
        // If per article each remote article should be announced only once, filter the result
        if (serendipity_db_bool($this->get_config('announceonce', true))) {
            // filter
            $entrySpices = DbSpice::loadCommentSpiceByEntry($entryId);
            if (is_array($entrySpices)) {
                $urlHash = array();
                foreach($entrySpices as $entrySpice) {
                    $urlHash[$entrySpice['promo_url']] = "used";
                }
                // Now that we have all urls of this article, remove matching urls from rss.
                if (count($urlHash)>0) {
                    $newArticles = array();
                    foreach ($result['articles'] as $article) {
                        if (empty($urlHash[$article['nohashUrl']])) {
                            $newArticles[] = $article;
                        }
                    }
                    $result['articles'] = $newArticles;
                }
            }
        }
        
        // Add Chooser to the array, if something's to choose
        if (count($result['articles'])>0) {
            $article = array();
            $article['title'] = PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_CHOOSE;
            $article['url'] = "";
            $result['articles'] = array_merge(array($article), $result['articles']);
        }
        
        echo json_encode($result);
    }
    function readRssRemote($url) {
        $this->log("Fetchig remote rss from: " . $url);
        
        if (function_exists('serendipity_request_url')) {
            $data = serendipity_request_url($url);
            if (empty($data)) return false;
        } else {

            require_once (defined('S9Y_PEAR_PATH') ? S9Y_PEAR_PATH : S9Y_INCLUDE_PATH . 'bundled-libs/') . 'HTTP/Request.php';
            $req = new HTTP_Request($url, array('allowRedirects' => true, 'maxRedirects' => 3));
            if (PEAR::isError($req->sendRequest()) || $req->getResponseCode() != '200') {
                $this->log("Error reading $url");
                return;
            } 
            # Fetch html content:
            $data = $req->getResponseBody();
        }
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
        
        $itemCount = 0;
        $maxItems = $announcerssmax = $this->get_config('announcerssmax',3);
        // Iterate the items
        while ($item = $rss->getNextItem()) {
            if ($itemCount>=$maxItems) break;
            $article = array();
            $article['title'] = $item['title'];
            $hash = $this->hashString($item['title'].$item['link']);
            $article['url'] = $hash . "\n" . $item['title'] . "\n" . $item['link'];
            $article['nohashUrl'] = $item['link'];
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
    
    function spiceComment(&$eventData, $addData, $preview = FALSE) {
        global $serendipity;
        
        if (!isset($eventData['comment'])) {
            return true;                            
        }
        // Called from sidebar:
        if ($addData['from'] == 'serendipity_plugin_comments:generate_content') {
            return true;
        }
        if ($preview && empty($eventData['id'])) {
            // Fetch "spice" from form elements
            $spice = array();
            $spice['commentid'] = -1;
            $spice['twittername'] = $serendipity['POST']['twitter'];
            $spice['boo'] = $serendipity['POST']['boo'];
            
            // Get the input w/o checking if it's modified: We are in preview!
            $promorss = $serendipity['POST']['promorss'];
            $parts = explode("\n", $promorss);
            $promo_hash = trim($parts[0]);
            $promo_name = trim($parts[1]);
            $promo_url = trim($parts[2]);
            $spice['promo_name'] = $promo_name;
            $spice['promo_url'] = $promo_url;
        }
        else {
            $spice = DbSpice::loadCommentSpice($eventData['id']);
        }
        if (!is_array($spice)) {
            return true;
        }
        $allow = $this->checkRules($eventData['email'], $eventData['comment'], true, true);
        if ($allow['allow_twitter']) {
            $smartify = serendipity_db_bool($this->get_config('smartifytwitter', false));
            $twittername = $spice['twittername'];
            if (!empty($twittername)) {
                $twitternameparts = explode('@', $twittername);
                $statusnet = is_array($twitternameparts) && count($twitternameparts)==2;
                if ($statusnet) {
                    $twittername = $twitternameparts[0];
                    $timeline_url = "http://" . $twitternameparts[1] . "/" . $twittername; 
                    $twitter_icon_html = '<img src="' . $serendipity['baseURL'] . 'index.php?/plugin/spiceicoidentica.png" alt="' . PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER . ': ">';
                    $followme_widget = '';
                }
                else {
                    $timeline_url = 'https://twitter.com/#!/' . $twittername;
                    $twitter_icon_html = '<img src="' . $serendipity['baseURL'] . 'index.php?/plugin/spiceicotwitter.png" alt="' . PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER . ': ">';
                    $followme_widget = $this->createFollowMeWidget($twittername, $timeline_url_nofollow);
                }
                $timeline_url_nofollow = $allow['nofollow_twitter'];
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
        }
        
        if ($allow['allow_boo'] && $spice['boo']) {
            $booPlayer = '<iframe class="commentspice_booplayer" allowtransparency="allowtransparency" cellspacing="0" frameborder="0" hspace="0" marginheight="0" marginwidth="0" scrolling="no" vspace="0" src="' . $spice['boo'] . '/embed" title="Audioboo player"></iframe>';
            $eventData['comment'] .= $booPlayer;
        }
        if ($allow['allow_announce'] && $spice['promo_name'] && $spice['promo_url']) {
            $spice_article_prefix = sprintf(PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_RECENT, $eventData['author']); 
            $spice_article_name = $spice['promo_name'];
            $spice_article_url = $spice['promo_url'];
            $spice_article_nofollow = $allow['nofollow_announce']; 
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
    function spiceEntry(&$eventData, $addData) {
        global $serendipity;
        if (!$addData['extended']) return; // Only single articles
        
        $patched_input_twitter = serendipity_db_bool($this->get_config('inputpatched_twitter', false));
        $patched_input_rss = serendipity_db_bool($this->get_config('inputpatched_rss', false));
        if (!$patched_input_twitter && !$patched_input_rss) return;
        
        if (isset($eventData) && is_array($eventData)) {
		    // Get the first entry an add stuff
		    foreach($eventData as $event) {
	            $smarty_spice = array();
	            if ($patched_input_twitter) {
	                if (isset($serendipity['COOKIE']['twitter'])) $twittername = $serendipity['COOKIE']['twitter'];
                    else  $twittername = '';
		            $smarty_spice['inputtwitter'] = $this->get_config('twitterinput','disabled')!='disabled';
		            $smarty_spice['inputtwitterlabel'] = PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_LABEL;
		            $smarty_spice['inputtwittervalue'] = $twittername;
		            $smarty_spice['inputtwitterplaceholder'] = PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_PLACEHOLDER;
	            }
	            if ($patched_input_rss) {
		            $smarty_spice['inputarticlelabel'] = PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_LABEL;
	                $smarty_spice['inputarticle'] = $this->get_config('announcerss','disabled')!='disabled';
	            }
	            if (count($smarty_spice)) {
	                $serendipity['smarty']->assign('spice', $smarty_spice);
	            }
		        break;
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
        if (!is_array($addData) || !$addData['type']=='twitter') return;
        
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
        
        // Check for non entry pages like contact form:
        if (empty($eventData) || empty($eventData['id'])) return;
        
        // Don't put extras on admin menu. They are not working there:
        if (isset($eventData['GET']['action']) && $eventData['GET']['action']=='admin') return;
        
        $config_twitter = $this->get_config('twitterinput','enabled');
        $config_announce =$this->get_config('announcerss','disabled');
        $do_twitter = $config_twitter!='disabled';
        $do_announce = $config_announce!='disabled';
        $do_boo = serendipity_db_bool($this->get_config('allow_boo',false));
        $styleInputRss = serendipity_db_bool($this->get_config('style_inputrss',true));
        

        if ($do_twitter) {
            if (isset($serendipity['COOKIE']['remember']) && isset($serendipity['COOKIE']['twitter'])) {
                $twittername = $serendipity['COOKIE']['twitter'];
            }
            else  $twittername = '';
            if (!serendipity_db_bool($this->get_config('inputpatched_twitter', false))) {
                echo '<div id="serendipity_commentspice_twitter" class="form_field">' . "\n";
                echo '<label for="serendipity_commentform_twitter">' . PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_LABEL . '</label>' . "\n";
                echo '<input class="commentspice_twitter_input" type="text" id="serendipity_commentform_twitter" name="serendipity[twitter]" placeholder="' . PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_PLACEHOLDER . '" value="' . $twittername . '"/>' . "\n";
                echo '</div>' . "\n";
            }
        }
        if ($do_announce && !serendipity_db_bool($this->get_config('inputpatched_rss', false))) {
            echo '<div id="serendipity_commentspice_rss" class="form_tarea spicehidden">' . "\n";
            echo '<label for="serendipity_commentform_rss">' . PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_LABEL . '</label>' . "\n";
            echo '<select ' . ($styleInputRss?'class="commentspice_rss_input" ':'') . 'id="serendipity_commentform_rss" name="serendipity[promorss]"></select>' . "\n"; //  style="max-width: 20em; width: 100%"
            echo '</div>' . "\n";
        }
        if ($do_boo) {
            echo '<div  id="serendipity_commentspice_boo_desc" class="serendipity_commentDirection serendipity_comment_spice">' . "\n";
            echo '<a href="http://audioboo.fm/profile" target="_blank"><img src="' . $serendipity['baseURL'] . 'index.php?/plugin/audioboo.png" class="commentspice_ico" title="Audioboo.com"></a>' . "\n";
            echo PLUGIN_EVENT_COMMENTSPICE_BOO_FOOTER . '<br/>' . "\n";
            echo '<a href="http://audioboo.fm/boos/new" target="_blank"><img src="' . $serendipity['baseURL'] . 'index.php?/plugin/spiceicorecord.png" class="commentspice_ico" title="create a boo" alt="record" onClick="window.open(\'http://audioboo.fm/boos/new\',\'recordboo\',\'width=600,height=300\');return false;"></a>' . "\n";
            echo '<input class="commentspice_boo_input" type="url" id="serendipity_commentform_boo" name="serendipity[boo]" placeholder="' . PLUGIN_EVENT_COMMENTSPICE_BOO_PLACEHOLDER . '" value=""/>' . "\n";
            echo '</div>' . "\n";
        }
        if ($do_twitter) {
            echo '<div  id="serendipity_commentspice_twitter_desc" class="commentspice_description serendipity_commentDirection serendipity_comment_spice">' . "\n";
            //echo '<img src="' . $serendipity['baseURL'] . 'index.php?/plugin/commentspice.png" class="commentspice_ico" title="' . PLUGIN_EVENT_COMMENTSPICE_TITLE . '">' . "\n";
            echo PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_FOOTER;
            $requirements = $this->createRequirementsString($config_twitter);
            if (!empty($requirements)) echo "<br/>$requirements";
            echo '</div>' . "\n";
        }
        if ($do_announce) {
            echo '<div  id="serendipity_commentspice_rss_desc" class="commentspice_description serendipity_commentDirection serendipity_comment_spice ">' . "\n";
//            echo '<img src="' . $serendipity['baseURL'] . 'index.php?/plugin/commentspice.png" class="commentspice_ico" title="' . PLUGIN_EVENT_COMMENTSPICE_TITLE . '">' . "\n";
            echo PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_FOOTER;
            $requirements = $this->createRequirementsString($config_announce);
            if (!empty($requirements)) echo "<br/>$requirements";
            echo '</div>' . "\n";
        }
        $custom_text = $this->get_config('custom_text');
        if (!empty($custom_text)) {
            echo '<div  id="serendipity_commentspice_customtext_desc" class="commentspice_description serendipity_commentDirection serendipity_comment_spice">' . "\n";
            echo $custom_text;
            echo '</div>' . "\n";
        }
        
    }
    
    function createRequirementsString($rule_config_value) {
        $requirements = '';
        if ('rules'==$rule_config_value) {
            $rule_commentlenght = (int)$this->get_config('rule_extras_commentlength',0);
            $rule_commentcount = (int)$this->get_config('rule_extras_commentcount',0);
            $requirements = "<em>(" .PLUGIN_EVENT_COMMENTSPICE_REQUIREMENTS . ": ";
            if ($rule_commentcount) {
                $requirements .= sprintf(PLUGIN_EVENT_COMMENTSPICE_REQUIREMENTS_COMMENTCOUNT,$rule_commentcount);
            }
            if ($rule_commentlenght && $rule_commentcount) {
                $requirements .= ", ";
            }
            if ($rule_commentlenght) {
                $requirements .= sprintf(PLUGIN_EVENT_COMMENTSPICE_REQUIREMENTS_COMMENTLEN,$rule_commentlenght);
            }
            $requirements .= ")</em>";
        }
        return $requirements;
    }
    
    function printCss(&$eventData, &$addData) {
        global $serendipity;

        // Hide and reveal classes by @yellowled used be the RSS chooser:
?>
.spicehidden {
    border: 0;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
}
.spicerevealed {
    clip: auto;
    height: auto;
    margin: 0;
    overflow: visible;
    position: static;
    width: auto;
}
<?php 
        if (!(strpos($eventData, '.commentspice_booplayer'))) {
?>
.commentspice_booplayer {
margin: 0px; padding: 0px; border: none; display: block; max-width: 100%; width: 1000px; height: 145px;
}
<?php
        }
        if (!(strpos($eventData, '.commentspice_ico_boo'))) {
?>
.commentspice_ico_boo {
	float:right;
	margin-right:0px;
	margin-left:10px;
}
<?php
        }
        if (!(strpos($eventData, '.commentspice_ico'))) {
?>
.commentspice_ico {
	float:right;
	margin-right:0px;
	margin-left:10px;
}
<?php
        }
        if (!(strpos($eventData, '.commentspice_description'))) {
?>
.commentspice_description {
	background-image: url("<?php echo $serendipity['baseURL'] . 'index.php?/plugin/commentspice.png'; ?>");
    background-repeat: no-repeat;
    background-position: right top;
}
<?php
        }
        if (!(strpos($eventData, '.commentspice_boo_input'))) {
?>
.commentspice_boo_input {
	max-width: 100%;
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
        $styleInputRss = serendipity_db_bool($this->get_config('style_inputrss',true));
        if ($styleInputRss && !(strpos($eventData, '.commentspice_rss_input'))) {
?>
#serendipity_commentspice_rss {
    max-width: 100%;
}
.commentspice_rss_input {
    max-width: 100%;
    min-width: 30.6em;
 	background: url('<?php echo $serendipity['baseURL']; ?>index.php?/plugin/spiceicorss.png') no-repeat left #444444;
 	overflow: hidden;
    border: 0.1em solid #000000;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    color: #FFFFFF;
	padding-left: 1.5em;
<?php if (!serendipity_db_bool($this->get_config('inputpatched_rss', false))) { ?>
	margin-bottom: 1em;
<?php } ?>
}
select.commentspice_rss_input option {
 	background: #444444;
	padding-left: 1.5em;
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
    
    function saveFetchPingbackDataConfig($fetchPingback) {
        global $serendipity;
        
        if (is_writeable($serendipity['serendipityPath'] . 'serendipity_config_local.inc.php')) {
            $privateVariables = array('pingbackFetchPage' => $fetchPingback);
            serendipity_updateLocalConfig($serendipity['dbName'], $serendipity['dbPrefix'], $serendipity['dbHost'], $serendipity['dbUser'], $serendipity['dbPass'], $serendipity['dbType'], $serendipity['dbPersistent'], $privateVariables);
        }
        else {
            echo "serendipity_config_local.inc.php is not writeable for plugins";
        }
    }
    
    function isLocalConfigWritable() {
        global $serendipity;
        $file = $serendipity['serendipityPath'] . 'serendipity_config_local.inc.php';
        return !file_exists($file) || is_writeable($file);
    }
    
    function set_config($name, $value, $implodekey = '^') {
        global $serendipity;
        
        if ($name == 'fetchPingback') {
            if ('none' != $value) {
                // This will be updated later, so save it in memory, too:
                $serendipity['pingbackFetchPage'] = serendipity_db_bool($value);
                // now make the config persistant.
                $this->saveFetchPingbackDataConfig($serendipity['pingbackFetchPage']);
            }
        }
        else {
            parent::set_config($name, $value, $implodekey);
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
