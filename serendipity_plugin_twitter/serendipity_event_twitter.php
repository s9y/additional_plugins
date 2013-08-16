<?php 

// Contributed by Grischa Brockhaus <s9ycoder@brockha.us>

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

include dirname(__FILE__) . '/plugin_version.inc.php';

require_once dirname(__FILE__) . '/classes/Twitter.php';
require_once dirname(__FILE__) . '/classes/TwitterOAuthApi.php';
require_once dirname(__FILE__) . '/classes/RedirectCheck.php';
require_once dirname(__FILE__) . '/classes/UrlShortener.php';
require_once dirname(__FILE__) . '/classes/TwitterPluginDbAccess.php';
require_once dirname(__FILE__) . '/classes/TwitterPluginFileAccess.php';
require_once dirname(__FILE__) . '/classes/twitter_entry_defs.include.php';

// writes a debug log into templates_c
@define('PLUGIN_TWITTER_DEBUG', FALSE);

// Consumer settings for the S9Y webapp
@define('PLUGIN_TWITTER_OAUTH_TWITTER_CONSUMERKEY', 'ScXsM6UiDU1nDl8u6tacrw');
@define('PLUGIN_TWITTER_OAUTH_TWITTER_CONSUMERSECRET', '8zR0TKHKNN6gTq8iGP12zRz5P39OPB1nLbLTkHY');

class serendipity_event_twitter extends serendipity_plugin {

    var $supported_services = array(
            'raw'         => "uncompressed",
            '7ax.de'      => "7ax.de",
            'bitly'       => "bit.ly",
            'piratly'     => "pirat.ly",
            'jmp'         => "j.mp",
            'tinyurl'     => "tinyurl.com",
            'isgd'        => "is.gd",
            'twurl'       => "twurl.nl",
            'delivr'      => "delivr.com",
            'linktrimmer' => 'Linktrimmer Plugin',
        );

    function introspect(&$propbag)
    {
        global $serendipity;
        
        $propbag->add('name',          PLUGIN_EVENT_TWITTER_NAME);
        $propbag->add('description',   PLUGIN_EVENT_TWITTER_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Grischa Brockhaus, Peter Heimann');
        //$propbag->add('website',       'http://board.s9y.org');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '5.1.0'
        ));
        $propbag->add('version',       PLUGIN_TWITTER_VERSION);
        $propbag->add('groups', array('FRONTEND_VIEWS'));
        $propbag->add('event_hooks', array(
            'entry_display'             => true,
            'external_plugin'           => true,
            'backend_header'            => true,
            'backend_display'           => true, // Extended attributes
            'backend_publish'           => true, // An entry was puplished (was draft before or saved from the scratch).
            'backend_frontpage_display' => true,
            'backend_sidebar_entries'   => true,
            'backend_sidebar_entries_event_display_tweeter' => true,
            'backend_delete_entry'      => true,
            'css'                       => true,
            'frontend_footer'           => true,
            'frontend_saveComment'      => true, // Set moderation if needed.
            ));

        $configuration = array();
        
        if (class_exists('serendipity_event_twittertweeter')) {
            $configuration[] = "tweeter_warning";
        }
        $configuration[] = "config_tab";
        
        $config_announce = array(
                    'announce_articles_title', 'announce_articles', 'announce_via_accounts', 
                    'announce_format', 'announce_with_tags', 'anounce_url_service', 'announce_articles_default_no',
                    'announce_bitly_description', 'announce_bitly_login','announce_bitly_apikey','announce_piratly_description', 'announce_piratly_apikey' 
                 );

        $config_twitter = array(
                    'twitter_title', 'id_count', 'id_title', 'id_service', 'twittername', 'twitterpwd','twitteroa_sign_in','twitteroa_consumer_key','twitteroa_consumer_secret'
                 );
        if (is_numeric($this->get_config('id_count',1))) {
            $idcount = $this->get_config('id_count',1);
        }
        else {
            $idcount = 1;
        }
        for ($idx=2; $idx<=$idcount; $idx++) {
            $config_twitter[] = 'id_title' . $idx;
            $config_twitter[] = 'id_service' . $idx;
            $config_twitter[] = 'twittername' . $idx;
            $config_twitter[] = 'twitterpwd' . $idx;
            $config_twitter[] = 'twitteroa_sign_in' . $idx;
        }

        $config_tweeter = array(
                    'tweeter_title', 'tweeter_show', 'tweeter_history', 'tweeter_history_count', 'tweeter_timeline'
                 );
        $config_tweetback = array(
                    'tweetback_title', 'do_tweetbacks',
                    'twitter_api', 'twitter_generic_acc', 
                    'tweetback_type', 'tweetback_moderate', 'ignore_tweetbacks_by_name', 'tweetback_url',  
                    'tweetback_check_freq'
                 );
                 

        $config_tweetthis = array(
                    'tweetthis_title', 'do_tweetthis', 'do_identicathis', 'tweetthis_format', 'tweetthis_button',
                    'tweetthis_newwindow', 'tweetthis_smartify', 'show_shorturl'
                 );


        $config_general = array(
                    'general_title', 'plugin_rel_url', 'general_oa_consumerdesc', 'general_oa_consumerkey', 'general_oa_consumersecret'
                 );
        
        switch ($_GET['plugintab']) {
            case 'announce':
                $configuration = array_merge($configuration, 
                    $config_announce
                );
                break;
            case 'tweeter':
                $configuration = array_merge($configuration, 
                    $config_tweeter
                );
                break;
            case 'tweetback':
                $configuration = array_merge($configuration, 
                    $config_tweetback
                );
                break;
            case 'tweetthis':
                $configuration = array_merge($configuration, 
                    $config_tweetthis
                );
                break;
            case 'global':
                $configuration = array_merge($configuration, 
                    $config_general
                );
                break;
            case 'all':
                $configuration = array_merge($configuration, 
                    $config_twitter,
                    $config_tweeter,
                    $config_announce,
                    $config_tweetback,
                    $config_general
                );
                break;
            case 'identities':
            default:
                $configuration = array_merge($configuration, 
                    $config_twitter
                );
        }
        
        $propbag->add('configuration', $configuration);
        
    }

    function handleConfig($name, &$propbag, $idx = '') {
        global $serendipity;
        switch($name) {
            case 'twitteroa_consumer_secret':
                if (!$this->get_config('id_service' . $idx) OR $this->get_config('id_service' . $idx) == "twitter") {
                    $u  = $this->get_config('twittername' . $idx);
                    $kd = $this->get_config('twitteroa_key_' . $idx . $u);
                    $td = $this->get_config('twitteroa_token_' . $idx . $u);

                    if (!empty($kd) && !empty($td)) {
                        // OAuth token and key is setup.
                    } else {
                        $propbag->add('type',           'string');
                        $propbag->add('name',           PLUGIN_EVENT_TWITTER_CONSUMER_SECRET);
                        $propbag->add('description',    PLUGIN_EVENT_TWITTER_CONSUMER_KEY_DESC);
                    }
                }
                break;

            case 'twitteroa_consumer_key':                                        
                if (!$this->get_config('id_service' . $idx) OR $this->get_config('id_service' . $idx) == "twitter") {
                    
                    $u  = $this->get_config('twittername' . $idx);
                    $kd = $this->get_config('twitteroa_key_' . $idx . $u);
                    $td = $this->get_config('twitteroa_token_' . $idx . $u);

                    if (!empty($kd) && !empty($td)) {
                        // OAuth token and key is setup.
                    } else {
                        $propbag->add('type',           'string');
                        $propbag->add('name',           PLUGIN_EVENT_TWITTER_CONSUMER_KEY);
                        $propbag->add('description',    PLUGIN_EVENT_TWITTER_CONSUMER_KEY_DESC);
                    }
                }
                break;
                
            case 'twitteroa_sign_in':
                if (!$this->get_config('id_service' . $idx) OR $this->get_config('id_service' . $idx) == "twitter") {
                    $u  = $this->get_config('twittername' . $idx);
                    $kd = $this->get_config('twitteroa_key_' . $idx . $u);
                    $td = $this->get_config('twitteroa_token_' . $idx . $u);

                    $csecret = $this->get_config('twitteroa_consumer_secret' . $idx);
                    $ckey = $this->get_config('twitteroa_consumer_key' . $idx);
                    // Use s9y consumer stuff, if old plugin versions did not set this up already 
                    if (empty($ckey) || empty($csecret)) {
                        $consumer = $this->twitteroa_global_consumersettings();
                        $csecret  = $consumer['secret'];
                        $ckey     = $consumer['key'];
                        $this->set_config('twitteroa_consumer_secret' . $idx, $csecret);
                        $this->set_config('twitteroa_consumer_key' . $idx, $ckey);
                    }
                    
                    if (!empty($kd) && !empty($td)) {
                        // OAuth token and key is setup: Delete connection
                        $linkdel = $serendipity['baseURL'] . $serendipity['indexFile'] . '?/' . TwitterPluginFileAccess::get_permaplugin_path() . '/twitteroa-del=' . $idx;
                        $propbag->add('type', 'content');
                        $propbag->add('default', PLUGIN_EVENT_TWITTER_VERBINDUNG_OK . ' <a padding-left: 30px;" href="' . $linkdel . '" target="_blank" onclick="window.open(\''.$linkdel.'\',\'\',\'width=800,height=400\'); return false">'.PLUGIN_EVENT_TWITTER_VERBINDUNG_DEL.'</a>');
                    } else {
                        // OAuth not yet setup, but we have consumer key/secret: Login and connect application
                        $url = $serendipity['baseURL'] . $serendipity['indexFile'] . '?/' . TwitterPluginFileAccess::get_permaplugin_path() . '/twitteroa-redirect=' . $idx;
                        $propbag->add('type', 'content');
                        $propbag->add('default', PLUGIN_EVENT_TWITTER_SIGN_IN.'
                        <p><div style="width: 151px;
                            height: 24px; line-height: 24px;
                            background: url(\'' . $this->get_config('plugin_rel_url') . '/img/signin.png\') no-repeat;">
                            <a style="color: #fff; padding-left: 30px;" href="' . $url . '" target="_blank" onclick="window.open(\''.$url.'\',\'\',\'width=800,height=550\'); return false">' . PLUGIN_EVENT_TWITTER_SIGNIN . '</a></div></p>');
                    }
                }
                break;
        }

        return true;
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        $tb_use_url = array(
            'status'    => PLUGIN_EVENT_TWITTER_TB_USE_URL_STATUS,
            'profile'   => PLUGIN_EVENT_TWITTER_TB_USE_URL_PROFILE,
            'weburl'    => PLUGIN_EVENT_TWITTER_TB_USE_URL_WEBURL
        );

        $id_services = array(
            'twitter'   => PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_TWITTER,
            'identica'  => PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_IDENTICA,
        );

        // Get actual idetntifier count
        if (is_numeric($this->get_config('id_count',1))) {
            $identitycount = $this->get_config('id_count',1);
        }
        else {
            $identitycount = 1;
        }

        switch($name) {
            case 'tweeter_warning':
                $propbag->add('type',           'content');
                $propbag->add('default',        PLUGIN_EVENT_TWITTER_TWEETER_WARNING);
                break;

            case 'config_tab':
                $config_tabs = array(
                    'identities'  => PLUGIN_EVENT_TWITTER_CFGTAB_IDENTITIES,
                    'tweetback' => PLUGIN_EVENT_TWITTER_CFGTAB_TWEETBACK,
                    'announce'  => PLUGIN_EVENT_TWITTER_CFGTAB_ANNOUNCE,
                    'tweeter'   => PLUGIN_EVENT_TWITTER_CFGTAB_TWEETER,
                    'tweetthis' => PLUGIN_EVENT_TWITTER_CFGTAB_TWEETTHIS,
                    'global'    => PLUGIN_EVENT_TWITTER_CFGTAB_GLOBAL,
                    'all'       => PLUGIN_EVENT_TWITTER_CFGTAB_ALL,
                );

                $actConfigUrl = $this->curPageURL();
                $querypar = "plugintab";
                $htmltabline = PLUGIN_EVENT_TWITTER_CFGTAB ;

                foreach ($config_tabs as $tabkey => $tabvalue) {
                    $tablink = $actConfigUrl;
                    if (strpos($actConfigUrl, "&$querypar=") === FALSE) {
                        $tablink = $actConfigUrl . "&$querypar=$tabkey";
                    }
                    else {
                        $tablink = preg_replace('@' . $querypar . '=.*@',"$querypar=$tabkey",$actConfigUrl);
                    }
                    $htmltabline .= ' [<a href="' . $tablink . '" class="serendipity_pluginconfig_tab">'. $tabvalue .'</a>] ';
                }
                $propbag->add('type',           'content');
                $propbag->add('default',        $htmltabline);
                break;

// Identities

            case 'twitter_title':
                $propbag->add('type',           'content');
                $propbag->add('default',        '<h3>' . PLUGIN_EVENT_TWITTER_IDENTITIES . '</h3>');
                break;

            case 'id_count':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_ACCOUNT_IDCOUNT);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_ACCOUNT_IDCOUNT_DESC);
                $propbag->add('default',        1);
                break;

            case 'id_title':
                $propbag->add('type',           'content');
                $propbag->add('default',        '<h3>' . PLUGIN_EVENT_TWITTER_IDENTITY . ' (1)</h3>');
                break;

            case 'id_service':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_DESC);
                $propbag->add('select_values',  $id_services);
                $propbag->add('default',        'twitter');
                break;

            case 'twittername':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_ACCOUNT_NAME);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_ACCOUNT_NAME_DESC);
                break;

            case 'twitterpwd':

                if (!$this->get_config('id_service') OR $this->get_config('id_service') == "identica") {
                    $propbag->add('type',           'string');
                    $propbag->add('name',           PLUGIN_EVENT_TWITTER_ACCOUNT_PWD);
                    $propbag->add('description',    PLUGIN_EVENT_TWITTER_ACCOUNT_PWD_DESC);
                    $propbag->add('input_type',     'password');
                }
                break;

            case 'twitteroa_consumer_key':
                $this->handleConfig('twitteroa_consumer_key', $propbag);
                break;

            case 'twitteroa_consumer_secret':
                $this->handleConfig('twitteroa_consumer_secret', $propbag);
                break;

            case 'twitteroa_sign_in':
                $this->handleConfig('twitteroa_sign_in', $propbag);
                break;

// Backend Client

            case 'tweeter_title':
                $propbag->add('type',           'content');
                $propbag->add('default',        '<h3>' . PLUGIN_EVENT_TWITTER_TWEETER_TITLE . '<h3>');
                break;

            case 'tweeter_show':
                $tweetershow = array(
                    'frontpage' => PLUGIN_EVENT_TWITTER_TWEETER_SHOW_FRONTPAGE,
                    'sidebar'   => PLUGIN_EVENT_TWITTER_TWEETER_SHOW_SIDEBAR,
                    'disable'   => PLUGIN_EVENT_TWITTER_TWEETER_SHOW_DISABLE
                );

                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_TWEETER_SHOW);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_TWEETER_SHOW_DESC);
                $propbag->add('select_values',  $tweetershow);
                $propbag->add('default',        'disable');
                break;

            case 'tweeter_timeline':
                $tb_statuses = array(
                    'public_timeline'     => 'public_timeline',
                    'home_timeline'       => 'home_timeline',
                    'friends_timeline'    => 'friends_timeline',
                    'user_timeline'       => 'user_timeline',
                    'mentions'            => 'mentions',
                    'retweeted_by_me'     => 'retweeted_by_me',
                    'retweeted_to_me'     => 'retweeted_to_me',
                    'retweets_of_me'      => 'retweets_of_me',
                    );

                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_TIMELINE);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_TIMELINE_DESC);
                $propbag->add('select_values',  $tb_statuses);
                $propbag->add('default',        'home_timeline');
                break;

            case 'tweeter_history':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_TWEETER_HISTORY);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_DESC);
                $propbag->add('default',        false);
                break;

            case 'tweeter_history_count':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_COUNT);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_COUNT_DESC);
                $propbag->add('default',        '10');
                break;

// Article announcement

            case 'announce_articles_title':
                $propbag->add('type',           'content');
                $propbag->add('default',        '<h3>' . PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_TITLE . '</h3>');
                break;

            case 'announce_articles':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_DESC);
                $propbag->add('default',        false);
                break;

            case 'announce_articles_default_no':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_NO);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_NO_DESC);
                $propbag->add('default',        false);
                break;

            case 'announce_via_accounts':
                $propbag->add('type',           'multiselect');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_ANNOUNCE_ACCOUNTS);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_ANNOUNCE_ACCOUNTS_DESC);
                $propbag->add('select_values',  $this->load_identities());
                $propbag->add('default',        '0');
                break;

            case 'announce_format':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_ANNOUNCE_FORMAT);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_ANNOUNCE_FORMAT_DESC);
                $propbag->add('default',        $this->get_default_announceformat());
                break;

            case 'announce_with_tags':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_ANNOUNCE_WITHTTAGS);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_ANNOUNCE_WITHTTAGS_DESC);
                $propbag->add('default',        false);
                break;

            case 'anounce_url_service':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_ANNOUNCE_SERVICE);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_ANNOUNCE_SERVICE_DESC);
                $propbag->add('select_values',  $this->supported_services);
                $propbag->add('default',        '7ax.de');
                break;

            case 'announce_bitly_description':
                $propbag->add('type',           'content');
                $propbag->add('default',        PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYDESC);
                break;

            case 'announce_bitly_login':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYLOGIN);
                $propbag->add('default',        'bitlyapidemo');
                break;

            case 'announce_bitly_apikey':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYAPIKEY);
                $propbag->add('default',        'R_0da49e0a9118ff35f52f629d2d71bf07');
                break;

            case 'announce_piratly_description':
                $propbag->add('type',           'content');
                $propbag->add('default',        PLUGIN_EVENT_TWITTER_ANNOUNCE_PIRATLYDESC);
                break;

            case 'announce_piratly_apikey':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_ANNOUNCE_PIRATLYAPIKEY);
                $propbag->add('default',        '0');
                break;

            // Tweetbacks 
            case 'twitter_api' :
                $apis = array(
                    'api10'      => PLUGIN_EVENT_TWITTER_API_10,
                    'api11'      => PLUGIN_EVENT_TWITTER_API_11,
                );
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_API_TYPE);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_API_TYPE_DESC);
                $propbag->add('select_values',  $apis);
                $propbag->add('default',        'api10');
                break;

            case 'twitter_generic_acc':
                $propbag->add('name',         PLUGIN_TWITTER_OAUTHACC);
                $propbag->add('description',  PLUGIN_TWITTER_OAUTHACC_DESC);
                $propbag->add('type',         'select');
                $propbag->add('select_values', serendipity_event_twitter::getTwitterOauths());
                $propbag->add('default',      '1');
                break;

            case 'tweetback_title':
                $propbag->add('type',           'content');
                $propbag->add('default',        '<h3>' . PLUGIN_EVENT_TWITTER_TWEETBACKS_TITLE . '</h3>');
                break;

            case 'do_tweetbacks':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_DO_TWEETBACKS);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_DO_TWEETBACKS_DESC);
                $propbag->add('default',        false);
                break;

            case 'tweetback_type':
                $tb_types = array(
                    'TRACKBACK' => PLUGIN_EVENT_TWITTER_TB_TYPE_TRACKBACK,
                    'NORMAL'    => PLUGIN_EVENT_TWITTER_TB_TYPE_COMMENT,
                );

                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_TB_TYPE);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_TB_TYPE_DESC);
                $propbag->add('select_values',  $tb_types);
                $propbag->add('default',        'TRACKBACK');
                break;

            case 'tweetback_moderate':
                $tb_types = array(
                    'save'      => PLUGIN_EVENT_TWITTER_TB_MODERATE_DEFAULT,
                    'pending'   => REQUIRES_REVIEW,
                    //'confirm'   => REQUIRES_REVIEW,
                    'approved'  => APPROVE_COMMENT,
                );

                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_TB_MODERATE);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_TB_MODERATE_DESC);
                $propbag->add('select_values',  $tb_types);
                $propbag->add('default',        'approved');
                break;

            case 'ignore_tweetbacks_by_name':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_IGNORE_TWEETBACKS_BYNAME);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_IGNORE_TWEETBACKS_BYNAME_DESC);
                $propbag->add('default',        $this->get_config('twittername'));
                break;

            case 'tweetback_url':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_TB_USE_URL);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_TB_USE_URL_DESC);
                $propbag->add('select_values',  $tb_use_url);
                $propbag->add('default',        'status');
                break;

            case 'tweetback_check_freq':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_TWEETBACK_CHECK_FREQ);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_TWEETBACK_CHECK_FREQ_DESC);
                $propbag->add('default',        '30');
                break;

// Tweet this
            case 'tweetthis_title':
                $propbag->add('type',           'content');
                $propbag->add('default',        '<h3>' . PLUGIN_EVENT_TWITTER_TWEETTHIS_TITLE . '</h3>');
                break;

            case 'do_tweetthis':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_DO_TWEETTHIS);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_DO_TWEETTHIS_DESC);
                $propbag->add('default',        false);
                break;

            case 'do_identicathis':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_DO_IDENTICATHIS);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_DO_IDENTICATHIS_DESC);
                $propbag->add('default',        false);
                break;

            case 'tweetthis_format':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_DESC);
                $propbag->add('default',        '#title# #link#');
                break;

            case 'tweetthis_button':
                $propbag->add('type', 'radio');
                $propbag->add('name',         PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON);
                $propbag->add('description',  PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_DESC);
                $propbag->add('radio',        array(
                    'value' => array('black', 'white'),
                    'desc'  => array(PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_BLACK, PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_WHITE)
                    ));
                $propbag->add('default', 'black');
                break;

            case 'tweetthis_newwindow':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_TWEETTHIS_NEWWINDOW);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_TWEETTHIS_NEWWINDOW_DESC);
                $propbag->add('default',        false);
                break;

            case 'tweetthis_smartify':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_TWEETTHIS_SMARTIFY);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_TWEETTHIS_SMARTIFY_DESC);
                $propbag->add('default',        false);
                break;

            case 'show_shorturl':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_SHOW_SHORTURL);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_SHOW_SHORTURL_DESC);
                $propbag->add('default',        false);
                break;

// General

            case 'general_title':
                $propbag->add('type',           'content');
                $propbag->add('default',        '<h3>' . PLUGIN_EVENT_TWITTER_GENERAL_TITLE . '</h3>');
                break;

            case 'plugin_rel_url':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_PLUGIN_EVENT_REL_URL);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_PLUGIN_EVENT_REL_URL_DESC);
                $propbag->add('default',        str_replace('//', '/', $serendipity['serendipityHTTPPath'] . preg_replace('@^.*(/plugins.*)@', '$1', dirname(__FILE__))));
                break;

            case 'general_oa_consumerdesc':
                $propbag->add('type',           'content');
                $propbag->add('default',        PLUGIN_EVENT_TWITTER_GENERALCONSUMER);
                break;

            case 'general_oa_consumerkey':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_CONSUMER_KEY);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_CONSUMER_KEY_DESC);
                $propbag->add('default',        '');
                break;

            case 'general_oa_consumersecret':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_TWITTER_CONSUMER_SECRET);
                $propbag->add('description',    PLUGIN_EVENT_TWITTER_CONSUMER_KEY_DESC);
                $propbag->add('default',        '');
                break;

        }


        // Process all extra identities:
        for ($idx=2; $idx<=$identitycount; $idx++) {
            switch($name) {
                case 'id_title'. $idx:
                    $propbag->add('type',           'content');
                    $propbag->add('default',        '<h3>' . PLUGIN_EVENT_TWITTER_IDENTITY . " ($idx)</h3>");
                    break;

                case 'id_service'. $idx:
                    $propbag->add('type',           'select');
                    $propbag->add('name',           PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE);
                    $propbag->add('description',    PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_DESC);
                    $propbag->add('select_values',  $id_services);
                    $propbag->add('default',        'twitter');
                    break;

                case 'twittername'. $idx:
                    $propbag->add('type',           'string');
                    $propbag->add('name',           PLUGIN_EVENT_TWITTER_ACCOUNT_NAME);
                    $propbag->add('description',    PLUGIN_EVENT_TWITTER_ACCOUNT_NAME_DESC);
                    break;

                case 'twitterpwd'. $idx:
                    if (!$this->get_config('id_service'. $idx) OR $this->get_config('id_service'. $idx) == "identica"){
                        $propbag->add('type',           'string');
                        $propbag->add('name',           PLUGIN_EVENT_TWITTER_ACCOUNT_PWD);
                        $propbag->add('description',    PLUGIN_EVENT_TWITTER_ACCOUNT_PWD_DESC);
                        $propbag->add('input_type',     'password');
                    }
                    break;

                case 'twitteroa_consumer_key'. $idx:
                    $this->handleConfig('twitteroa_consumer_key', $propbag, $idx);
                    break;

                case 'twitteroa_consumer_secret'. $idx:
                    $this->handleConfig('twitteroa_consumer_secret', $propbag, $idx);
                    break;

                case 'twitteroa_sign_in'. $idx:
                    $this->handleConfig('twitteroa_sign_in', $propbag, $idx);
                    break;
            }
        }

        return true;
    }

    function get_default_announceformat() {
        // Compatiblity to old versions:
        $default_prefix = $this->get_config('anounce_prefix'); //'blog update: ';
        if (!empty($default_prefix)) {
            $default_prefix = trim($default_prefix) . ' ';
        }
        else {
            $default_prefix = 'blog update: ';
        }

        $format = $default_prefix . '#title# #link#';
        
        if (serendipity_db_bool($this->get_config('announce_with_all_tags',false))) {
            $format .= ' #tags#';
        }
        return $format;
    }

    function get_urlshortener() {
        $urlshortener = new UrlShortener();
        $bitlylogin = $this->get_config('announce_bitly_login');
        $bitlyapikey = $this->get_config('announce_bitly_apikey');
        $piratlyapikey = $this->get_config('announce_piratly_apikey','0');
        $this->log("blogin:" .  $bitlylogin . " bapi: " . $bitlyapikey);
        $urlshortener->setBitlyLogin($bitlylogin, $bitlyapikey);
        $this->log("slogin:" .  $urlshortener->bitly_login . " sapi: " . $urlshortener->bitly_apikey);
        $urlshortener->setPiratlyToken($piratlyapikey);
        return $urlshortener;
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENT_TWITTER_NAME;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;
        static $cache = null;
        static $method = null;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'css':
                    if (strpos($eventData, '#twitter_update_list')) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        return true;
                    }
                    $this->addToCSS($eventData);
                    return true;
                    break;

                case 'backend_header':
                    $this->add_backend_header_parts();
                    return true;

                case 'backend_publish':
                    // If signaled, we don't want to announce, don't do it!
                    if (isset($serendipity['POST']['properties']['microblogging_dontannounce'])) {
                        return true;
                    }
                    // eventData is the entry here
                    return $this->twitter_published_entry($eventData);
                    break;

                case 'backend_delete_entry':
                    $this->entry_deleted((int)$eventData);
                    return true;
                    break;

                case 'external_plugin':
                    $parts = explode('_',$eventData);
                    $command = $parts[0];
                    if ($command== 'cacheplugintwitter') {
                        $next_check = (int)$this->updateTwitterTimelineCache($parts);
                        $this->show_img(dirname(__FILE__) . '/img/pixel.png', (int)$next_check);
                        return true;
                    }
                    $parts = explode('=',$eventData);
                    $command = $parts[0];
                    $fparts = explode('&', $parts[1]);
                    if ($command=="tweetback") {
                        if (!$_SESSION['serendipityAuthedUser']) {
                            echo "DON'T HACK!<br>";
                            return true;
                        }
                        $article_url = preg_replace('@^tweetback=@','',$eventData);

                        $article_url=$this->urldecode($article_url);
                        if (empty($article_url)) {
                            echo "Dont hack!";
                        }

                        $shorturls  = $this->create_short_urls($article_url);

                        $entries = $entries = $this->search($article_url, null);
                        if (is_array($entries)) {
                            $this->debug_entries($entries, $article_url, $shorturls);
                        }
                        else {
                            echo "<p><b>ERROR</b> while fetching search results for URL $article_url<br/>Might be a Twitter Overload.<br/>Try again later</p>";
                        }
                        return true;
                    }
                    else if ($command=="gtweetback.png") {
                        $nextcheck = $this->check_tweetbacks_global();
                        if (empty($nextcheck)) $nextcheck = time() + (30 * 60); // Default for hackers 
                        $this->show_img(dirname(__FILE__) . '/img/pixel.png', $nextcheck, 'image/png');
                        return true;
                    }
                    else if ($command == "twitteroa-del") {
                        $this->twitteroalog($command);

                        // Remove current twitter OAuth key and token to allow to re-connect
                        if (!serendipity_userLoggedIn()) {
                            die ("Don't hack!");
                        }
                        $idx = $fparts[0];

                        // Remove access tokens
                        $u  = $this->get_config('twittername' . $idx);
                        $kd = $this->set_config('twitteroa_key_' . $idx . $u, '');
                        $td = $this->set_config('twitteroa_token_' . $idx . $u, '');

                        // Remove old application, so it will change to the s9y app next time:
                        $csecret = $this->set_config('twitteroa_consumer_secret' . $idx, '');
                        $ckey = $this->set_config('twitteroa_consumer_key' . $idx, '');

                        serendipity_die('<div align="center">
                        <h1>' . PLUGIN_EVENT_TWITTER_VERBINDUNG_DEL_OK . '</h1>
                        <a href="javascript:window.close()">' . PLUGIN_EVENT_TWITTER_CLOSEWINDOW . '</a>
                        </div>');

                        return true;
                    }
                    else if ($command == "twitteroa-redirect") {
                        $this->twitteroalog($command);

                        if (!serendipity_userLoggedIn()) {
                            die ("Don't hack!");
                        }
                        $idx = $fparts[0];

                        $u  = $this->get_config('twittername' . $idx);
                        $kd = $this->get_config('twitteroa_key_' . $idx .$u);
                        $td = $this->get_config('twitteroa_token_' . $idx . $u);
                        $ckey = $this->get_config('twitteroa_consumer_key' . $idx);
                        $csecret = $this->get_config('twitteroa_consumer_secret' . $idx);

                        require_once(dirname(__FILE__) . '/twitteroauth/twitteroauth.php');

                        $twittername = $u;
                        $callbackurl = $serendipity['baseURL'] . $serendipity['indexFile'] . '?/' . TwitterPluginFileAccess::get_permaplugin_path() . '/twitteroa-callback=' . $idx
                                     . "&twittername=" . $twittername;

                        define('CONSUMER_KEY',  $ckey);
                        define('CONSUMER_SECRET', $csecret);
                        define('OAUTH_CALLBACK', $callbackurl);

                        /* Build TwitterOAuth object with client credentials. */
                        $connection = new TwitterOAuth($ckey, $csecret);

                        /* Get temporary credentials. */
                        $request_token = $connection->getRequestToken(OAUTH_CALLBACK);

                        /* Save temporary credentials to session. */
                        $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
                        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

                        /* If last connection failed don't display authorization link. */
                        switch ($connection->http_code) {
                            case 200:
                                /* Build authorize URL and redirect user to Twitter. */
                                $url = $connection->getAuthorizeURL($token);
                                header('Location: ' . $url);
                                exit;
                            break;
                            default:
                                serendipity_die('<div align="center">
                                <h1>' . PLUGIN_EVENT_TWITTER_VERBINDUNG_ERROR . '</h1>
                                <div align="left"><pre>' . print_r($connection, true) . '</pre>
                                <pre>' . print_r($request_token, true) . '</pre>
                                <pre>' . print_r($_SESSION, true) . '</pre>
                                <pre>' . print_r($_REQUEST, true) . '</pre></div>
                                <a href="javascript:window.close()">' . PLUGIN_EVENT_TWITTER_CLOSEWINDOW . '</a>
                                </div>');
                        }
                        return true;

                    }
                    else if ($command == "twitteroa-callback") {
                        $this->twitteroalog($command);

                        if (!serendipity_userLoggedIn()) {
                            die ("Don't hack!");
                        }
                        $idx = $fparts[0];

                        $u  = $this->get_config('twittername' . $idx);
                        $kd = $this->get_config('twitteroa_key_' . $idx .$u);
                        $td = $this->get_config('twitteroa_token_' . $idx . $u);
                        $ckey = $this->get_config('twitteroa_consumer_key' . $idx);
                        $csecret = $this->get_config('twitteroa_consumer_secret' . $idx);

                        require_once(dirname(__FILE__) . '/twitteroauth/twitteroauth.php');
                        define('CONSUMER_KEY', $ckey);
                        define('CONSUMER_SECRET', $csecret);

                        /* If the oauth_token is old redirect to the connect page. */
                        if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
                            $_SESSION['oauth_status'] = 'oldtoken';
                            $url = $serendipity['baseURL'] . $serendipity['indexFile'] . '?/' . TwitterPluginFileAccess::get_permaplugin_path() . '/twitteroa-redirect=' . $idx;
                            header('Location: ' . $url);
                            exit;
                        }

                        /* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
                        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

                        /* Request access tokens from twitter */
                        $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
                        $this->set_config('twitteroa_key_' . $idx . $u, $access_token['oauth_token']);
                        $this->set_config('twitteroa_token_' . $idx . $u, $access_token['oauth_token_secret']);

                        /* Remove no longer needed request tokens */
                        unset($_SESSION['oauth_token']);
                        unset($_SESSION['oauth_token_secret']);

                        /* If HTTP response is 200 continue otherwise send to connect page to retry */
                        if (200 == $connection->http_code) {
                            serendipity_die('<div align="center">
                            <h1>' . PLUGIN_EVENT_TWITTER_VERBINDUNG_OK . '</h1>
                            <a href="javascript:window.close()">' . PLUGIN_EVENT_TWITTER_CLOSEWINDOW . '</a>
                            </div>');
                        } else {
                            serendipity_die('<div align="center">
                            <h1>' . PLUGIN_EVENT_TWITTER_VERBINDUNG_ERROR . '</h1>
                            <pre>' . print_r($connection, true) . '</pre>
                            <pre>' . print_r($access_token, true) . '</pre>
                            <pre>' . print_r($_SESSION, true) . '</pre>
                            <pre>' . print_r($_REQUEST, true) . '</pre>
                            <a href="javascript:window.close()">' . PLUGIN_EVENT_TWITTER_CLOSEWINDOW . '</a>
                            </div>');
                        }

                        return true;
                    }
                    return false;
                    break;

                case 'entry_display':
                    $this->display_entry($eventData, $addData);
                    return true;

                case 'backend_frontpage_display':
                    if ($this->get_config('tweeter_show', 'disable') == 'frontpage') {
                        $this->display_twitter_client(false);
                    }
                    return true;

                case 'backend_sidebar_entries':
                    if ($this->get_config('tweeter_show', 'disable') == 'sidebar') {
                    ?>
                    <li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=tweeter"><?php echo PLUGIN_EVENT_TWITTER_TWEETER_SIDEBARTITLE; ?></a></li>
                    <?php
                    }
                    return true;

                case 'backend_sidebar_entries_event_display_tweeter':
                    $this->display_twitter_client(true);
                    return true;

                case 'frontend_footer':
                    $this->display_frontend_footer();
                    return true;

                case 'frontend_saveComment':
                    $this->hook_saveComment($eventData, $addData);
                    return true;

                case 'backend_display':
                    if (!serendipity_db_bool($this->get_config('announce_articles'))) {
                        return true;
                    }

                    if (isset($serendipity['POST']['properties']['microblogging_tagList'])) {
                        $tagList = $serendipity['POST']['properties']['microblogging_tagList'];
                    } else {
                        $tagList = '';
                    }
                    if (isset($serendipity['POST']['properties']['microblogging_dontannounce'])) {
                        $checked_dontannounce = "checked='checked'";
                    } else {
                        $checked_dontannounce = '';
                    }

                    if (serendipity_db_bool($this->get_config('announce_articles_default_no'))) {
                        $checked_dontannounce = "checked='checked'";
                    }
?>
                    <fieldset style="margin: 5px">
                        <a name="microbloggingAnchor"></a>
                        <legend><?php echo PLUGIN_EVENT_TWITTER_NAME; ?></legend>
                        <div class="entryproperties_microblogging_dontannounce">
                        <input id="properties_microblogging_dontannounce" class="input_checkbox" type="checkbox" name="serendipity[properties][microblogging_dontannounce]" <?php echo $checked_dontannounce; ?>/>
                        <label for="properties_microblogging_dontannounce" title="<?php echo PLUGIN_EVENT_TWITTER_BACKEND_DONTANNOUNCE; ?>"> <?php echo PLUGIN_EVENT_TWITTER_BACKEND_DONTANNOUNCE; ?>  </label>
                        </div>
                        <label for="serendipity[properties][microblogging_tagList]" title="<?php echo PLUGIN_EVENT_TWITTER_NAME; ?>">
                            <?php echo PLUGIN_EVENT_TWITTER_BACKEND_ENTERDESC; ?></label><br/>
                        <input type="text" name="serendipity[properties][microblogging_tagList]" id="properties_microblogging_tagList" class="wickEnabled input_textbox" value="<?php echo htmlspecialchars($tagList); ?>" style="width: 100%" />
                    </fieldset>
<?php
                    return true;
            }
        }

    }

    static function twitteroalog($cmd) {
        static $debug = false;
        global $serendipity;

        if ($debug) {
            $fp = fopen($serendipity['serendipityPath'] . PATH_SMARTY_COMPILE . "/twitteroa.log", 'a');
            fwrite($fp, date('d.m.Y H:i') . ' - ' . $cmd . ' - ' . $_SERVER['REMOTE_ADDR'] . "\n");
            fwrite($fp, print_r($_SERVER, true) . "\n\n");
            fwrite($fp, print_r($_REQUEST, true) . "\n\n");
            fwrite($fp, print_r($_SESSION, true) . "\n\n");
            fclose($fp);
        }
        return true;
    }

    function cleanup() {
        global $serendipity;

        TwitterPluginDbAccess::install($this);

        // Save highest twitter id of all ids saved for single articles  
        $highest_id_single = TwitterPluginDbAccess::find_highest_twitterid();
        if ($this->get_config('highest_id_global','0')<$highest_id_single) {
            $this->set_config('highest_id_global', TwitterPluginDbAccess::find_highest_twitterid());
        }

        // patch old config
        if ('default' == $this->get_config('tweetback_moderate')) {
            $this->set_config('tweetback_moderate','approved');
        }

        if ('snipr' == $this->get_config('anounce_url_service')) {
            $this->set_config('7ax');
        }

        $this->check_tweetbacks_global(true);
    }

    function install() {
        TwitterPluginDbAccess::install($this);
    }

    function addToCSS(&$eventData) {
        $eventData .= '
/* plugin twitter */
#twitter_update_list {
    list-style: none;
    padding-left: 0;
}
a.twitter_update_time {
    display: block;
    padding-bottom: 5px;
}
';
    }

    function add_backend_header_parts() {
        $cssfilename = TwitterPluginFileAccess::get_file_from_template('tweeter/serendipity_event_twitter_tweeter.css', $this->get_config('plugin_rel_url'));
        echo '<link rel="stylesheet" type="text/css" href="' . $cssfilename.  '" />' . "\n";
        $jsfilename =  $this->get_config('plugin_rel_url') . '/tweeter/serendipity_event_twitter_tweeter.js';
        echo '<script type="text/javascript" src="' . $jsfilename . '"></script>' . "\n";
    }

    function display_frontend_footer() {
        global $serendipity;

        if (!serendipity_db_bool($this->get_config('do_tweetbacks',false))) return false;

        $pluginurl = $serendipity['baseURL'] . $serendipity['indexFile'] . '?/' . TwitterPluginFileAccess::get_permaplugin_path();
        // add pixel doing tweetback check to each visible entry footer
        $tweetbackpng_url = $pluginurl . '/gtweetback.png';

        echo '<img src="' . $tweetbackpng_url . '" width="1" height="1" class="serendipity_tweetback_check" alt="tweetbackcheck"/>';
    }

    /**
     * Entry deleted event fetched. Delete all data, not needed anymore.
     */
    function entry_deleted($entryId) {
        TwitterPluginDbAccess::entry_deleted($entryId);
    }

    function check_tweetbacks_save_comment($article_id, $entry, $comment_type, $strip_tags = false) {
        $commentInfo = array();
        $commentInfo['title']   = $entry[TWITTER_SEARCHRESULT_REALNAME] . " via Twitter";
        $commentInfo['name']    = $entry[TWITTER_SEARCHRESULT_REALNAME];
        $commentInfo['url']     = $this->comment_url($entry);
        $commentInfo['email']   = $entry[TWITTER_SEARCHRESULT_EMAIL];
        $comment = $entry[TWITTER_SEARCHRESULT_TWEET];
        if ($strip_tags) {
            $comment = strip_tags($comment);
        }
        if (LANG_CHARSET!='UTF-8' && function_exists("mb_convert_encoding")) {
            $comment = mb_convert_encoding($comment, LANG_CHARSET);
        }
        $commentInfo['comment'] = $comment;
        $commentInfo['time']    = strtotime($entry[TWITTER_SEARCHRESULT_PUBDATE]);
        $commentInfo['source']  = 'tweetback';

        $this->log("Tweetback save: title=[" . $commentInfo['title'] ."], comment=[" . $commentInfo['comment'] . "] articleid=[$article_id]");

        // patch old config
        if ('default' == $this->get_config('tweetback_moderate')) {
            $this->set_config('tweetback_moderate','approved');
        }

        $comment_moderation = $this->get_config('tweetback_moderate','approved');
        if ('save'==$comment_moderation) {
            // save comment starts spam plugin. This might intervent the saving, but we don't want that here.
            // If we have more than 1 tweetback, at least the min posting freq for one IP will hit.
            return serendipity_saveComment($article_id, $commentInfo, $comment_type, 'tweetback');
        }
        else {
            $ca = array();
            $this->hook_saveComment($ca, $commentInfo);
            return serendipity_insertComment($article_id, $commentInfo, $comment_type, 'tweetback', $ca);
        }
    }

    function hook_saveComment(&$ca, &$commentInfo) {
        // is this our comment to be saved?
        if (empty($commentInfo) || $commentInfo['source']!='tweetback') return;

        $comment_moderation = $this->get_config('tweetback_moderate','approved');
        if ('save'!=$comment_moderation) {
            $commentInfo['status'] = $comment_moderation;
            if ('pending' == $comment_moderation) {
                $ca['moderate_comments'] = true;
            }
            else if ('approved' == $comment_moderation) {
                $ca['moderate_comments'] = false;
            }
            else if ('default' == $comment_moderation) { // this is an old configuration
                $ca['moderate_comments'] = false;
            }
        }
        $this->log("hook_saveComment end");
    }

    function check_tweetbacks_global($complete = false) {
        global $serendipity;

        $this->log("Check global");

        if (!serendipity_db_bool($this->get_config('do_tweetbacks'))) return false;

        $lastcheck = $this->get_config('last_check_global');
        $check_freq = $this->get_config('tweetback_check_freq',30);
        if (!is_numeric($check_freq) || $check_freq < 5) {
            $check_freq = 5;
        }
        $check_freq = $check_freq * 60; // we need seconds 
        if (!$complete && !empty($lastcheck)  && (time() - $lastcheck) < $check_freq){
            // Search already done.
            return $lastcheck + $check_freq;
        }

        // TODO: This file sema is blocking! wtf?!
        if (!($fp=TwitterPluginFileAccess::get_lock(0))) {
            $this->log("Sema is blocking.");
            return time() + $check_freq; // someone else ist processing the global check
        }

        $baseUrl = $serendipity['baseURL'];
        $permalinkRegex = '@('  . $baseUrl . '.*'. serendipity_makePermalinkRegex($serendipity['permalinkStructure'], 'entry') . ')/?@i';
        if ($complete) {
            $old_since_id ='0';
        }
        else {
            $old_since_id = $this->get_config('highest_id_global');
        }
        $this->log("old_since_id [$old_since_id]");

        $comment_type = $this->get_config('tweetback_type','TRACKBACK');
        $ignore_names = explode(',', $this->get_config('ignore_tweetbacks_by_name', $this->get_config('twittername')));

        $search_since_id = "0";
        if (!empty($old_since_id)) {
            $search_since_id = $old_since_id;
        }

        // Start searching
        $idx = $this->get_config('twitter_generic_acc', '1');
        if ($idx == '1') {
            $idx = '';
        }
        $connection = $this->twitteroa_connect($idx);
        $twitterapi = new TwitterOAuthApi($connection);
        $twittersearch = $this->generate_domain_url(false) . "&since_id=".$search_since_id;
        $entries = $twitterapi->search($twittersearch);

        if (is_array($entries) && !empty($entries) ) {

            // reverse the entries to get oldest first!
            $entries = array_reverse( $entries, true );

            $redirCheck = new RedirectCheck();

            $validated_entries = array();
            foreach ($entries as $entry) {
                $writer = $entry[TWITTER_SEARCHRESULT_LOGIN];

                // First check if the tweets autor should be ignored:
                $ignore = false;
                foreach( $ignore_names as $ignore_name) {
                    $ignore = strtoupper(trim($ignore_name)) == strtoupper($writer);
                    if ($ignore) break;
                }
                if ($ignore) continue;

                // Check wether this tweet is blog article related:
                $tweetmatches = false;

                // Check all expanded urls:
                if (!empty($entry[TWITTER_SEARCHRESULT_URL_ARRAY])) {
                    foreach ($entry[TWITTER_SEARCHRESULT_URL_ARRAY] as $url) {
                        $url = $redirCheck->get_final_url($url);
                        $tweetmatches = preg_match($permalinkRegex, $url, $matches);
                        if ($tweetmatches) break; // Found it!
                    }
                }
                // If no URL matches, try the tweet itself:
                if (!$tweetmatches) {
                    $tweet = $entry[TWITTER_SEARCHRESULT_TWEET];
                    !$tweetmatches = preg_match($permalinkRegex, $tweet, $matches);
                }
                // If we found a match, add it to the validated entries
                if ($tweetmatches) {
                    $this->log("Tweet matches!");
                    $match = array('id' => $matches[2], 'entry' => $entry);
                    $validated_entries[] = $match;
                }
            }
        } //is array $entries end

        // Save all comments and evaluate highest ids:
        $highest_ids = array();
        if (is_array($validated_entries) && !empty($validated_entries) ) {
            foreach ($validated_entries as $valid) {
                $comment_saved = false;
                $article_id = $valid['id'];
                $entry = $valid['entry'];
                $test_highest_id = null;
                if (!empty($highest_ids[$article_id])) {
                    $test_highest_id = $highest_ids[$article_id]['high_id'];
                }
                if (empty($test_highest_id)) {
                    // load old highest id of the article
                    $last_info = TwitterPluginDbAccess::load_tweetback_info($article_id, $this);
                    $test_highest_id = empty($last_info)?null:$last_info['lasttweetid'];
                    $highest_ids[$article_id] = array('high_id' => $test_highest_id, 'last_info' => $last_info);
                }
                if (empty($highest_ids[$article_id]['last_info']) || empty($highest_ids[$article_id]['last_info']['lasttweetid']) || "{$entry[TWITTER_SEARCHRESULT_ID]}">$highest_ids[$article_id]['last_info']['lasttweetid']) {
                    if ($complete) { // This is called from admin interface
                        echo "<div class='serendipityAdminMsgSuccess'>Found new tweetback for article $article_id: tweetid: {$entry[TWITTER_SEARCHRESULT_ID]}</div><br/>";
                    }
                    $this->check_tweetbacks_save_comment($article_id, $entry, $comment_type, true);
                    $comment_saved = true;
                }
                // Remember highest id, if saved and highest id is higher than old one.
                if ($comment_saved && (empty($test_highest_id) || "{$entry[TWITTER_SEARCHRESULT_ID]}" > "$test_highest_id")) {
                    $highest_ids[$article_id]['high_id'] = "{$entry[TWITTER_SEARCHRESULT_ID]}";
                }
            }
        } // is array $validated_entries end

        $global_highest_id = $this->get_config('highest_id_global');
        if (empty($global_highest_id)) $global_highest_id = '0';
        if (is_array($highest_ids) && !empty($highest_ids) ) {
            // Save highest ids:
            foreach( $highest_ids as $article_id => $highest_id_array ) {
                // remember globaly
                if (!empty($highest_id_array['high_id']) && $highest_id_array['high_id'] > $global_highest_id) {
                    $global_highest_id = $highest_id_array['high_id'];
                }
                // save per article
                if (empty($highest_id_array['last_info']) || $highest_id_array['high_id']>$highest_id_array['last_info']['lasttweetid']) {
                    TwitterPluginDbAccess::save_highest_id($article_id, $highest_id_array['high_id'], $highest_id_array['last_info']);
                }
            }
        } // is array $highest_ids end

        $lastcheck = time();
        $this->set_config('last_check_global', $lastcheck);
        $this->set_config('highest_id_global', $global_highest_id);

        TwitterPluginFileAccess::free_lock(0);
        return $lastcheck + $check_freq;
    }

    function search($article_url, $old_since_id) {
        if ($this->get_config('twitter_api', 'api10') == 'api10') {
            $entries = Twitter::search_multiple($article_url, $old_since_id);
        }
        else {
            $idx = $this->get_config('twitter_generic_acc', '1');
            if ($idx=='1') $idx = '';
            $connection = $this->twitteroa_connect($idx);
            $entries = TwitterOAuthApi::search_multiple($connection, $article_url, $old_since_id);
        }

        return array_reverse  ( $entries, true );
    }

    function comment_url($entry) {
        $use_url_kind = $this->get_config('tweetback_url','status');

        switch ($use_url_kind) {
            case 'profile':
                $comment_url = $entry[TWITTER_SEARCHRESULT_URL_AUTOR];
                break;
            case 'weburl':
                $api = new Twitter();
                $user = $api->userinfo($entry[TWITTER_SEARCHRESULT_LOGIN]);
                if (!empty($user) && !empty($user->url)) {
                    $comment_url = $user->url;
                }
                else {
                    $comment_url = $entry[TWITTER_SEARCHRESULT_URL_TWEET];
                }
                break;
            default: // status
                $comment_url = $entry[TWITTER_SEARCHRESULT_URL_TWEET];

        }
        return $comment_url;
    }

    function create_update_from_entry($entry, $announce_format, $checkUrlLen = false) {
        global $serendipity;

        $entryurl = $this->generate_article_url($entry);

        $short_url = $this->default_shorturl($entryurl);

        // Check for real URL length after twitter shortened it:
        if ($checkUrlLen) {
            $this->twitter_check_config();
            if (substr($short_url,0,5) == 'https') {
                $url_len = $this->get_config('twitter_config_https_len');
            }
            else {
                $url_len = $this->get_config('twitter_config_http_len');
            }
        }
        if (empty($url_len)) $url_len = strlen($short_url); // Fallback, if we were not able to detect it

        $url_placeholder = "#";
        for ($i=1; $i<$url_len-2;$i++) {
            $url_placeholder .= $i;
        }
        $url_placeholder .= "#";

        $author = !empty($entry['author'])?$entry['author']:$serendipity['serendipityRealname'];
        $announce_format = str_replace(
            array('#author#','#autor#','#link#'), 
            array($author,$author,$url_placeholder),
            $announce_format);

        $title = $entry['title'];
        $tags_marker = '#tags#';
        $announce_format_notags = trim(str_replace($tags_marker,'',$announce_format));

        // Check for tags:
        $tagsnotused = array();
        if (serendipity_db_bool($this->get_config('announce_with_tags',false)) && !empty($serendipity['POST']['properties']) && !(empty($serendipity['POST']['properties']['freetag_tagList']) && empty($serendipity['POST']['properties']['microblogging_tagList'])) && strlen($announce_format_notags)<140) {
            $taglist = '';
            if (!empty($serendipity['POST']['properties']['microblogging_tagList'])) {
                $taglist = $serendipity['POST']['properties']['microblogging_tagList'];
            }
            else if (!empty($serendipity['POST']['properties']['freetag_tagList'])) {
                $taglist = $serendipity['POST']['properties']['freetag_tagList'];
            }
            if (!empty($taglist)) {
                $tags = explode(',',$taglist);
                foreach ($tags as $tag) {
                    $tag = trim($tag);
                    $tag = str_replace(" ","_",$tag); // make tags more twitter alike
                    $test = str_replace('#title#',$title,$announce_format_notags);
                    $len = strlen($title);
                    if (strlen($test) < 140) { // still capacity
                        $title = preg_replace('@(^|\s)(' . $tag . '($|\s))@i'," #$2",$title);
                        if (strlen($title) == $len) $tagsnotused[] = $tag;
                    }
                    else {
                        $tagsnotused[] = $tag;
                    }
                }
            }
        }

        $update = str_replace('#title#',$title,$announce_format);

        // Fill up with not used tags
        if (strstr($announce_format,$tags_marker)) {
            $added = false;
            foreach ($tagsnotused as $tag) {
                $test = str_replace($tags_marker,'#' . $tag . ' ' . $tags_marker,$update);
                if (strlen($test) <142 + strlen($tags_marker)) {
                    $update = $test;
                    $added = true;
                }
            }

            // remove tags marker now
            $update = trim(str_replace(array(' ' . $tags_marker,$tags_marker),'',$update));
        }

        // Now fill in shorturl, if needed
        $update = str_replace($url_placeholder, $short_url, $update);

        // Change encoding of update to UTF-8
        if (LANG_CHARSET!='UTF-8' && function_exists("mb_convert_encoding")) {
            $update = mb_convert_encoding($update, 'UTF-8', LANG_CHARSET);
        }

        return $update;
    }

    function twitter_check_config() {
        $last_config_check = $this->get_config("twitter_last_config_check", 0);
        $now = time();
        $daybefore = $now - (24 * 60 * 60); // One day in seconds
        if (empty($last_config_check) || $last_config_check<$daybefore) {
            $api = new Twitter();
            $config = $api->get_twitter_config();
            if (!empty($config)) {
                $max_http = $config->short_url_length;
                $max_https = $config->short_url_length_https;
                $this->set_config('twitter_last_config_check', $now);
                $this->set_config('twitter_config_http_len', $max_http);
                $this->set_config('twitter_config_https_len', $max_https);
            }
        }
    }

    function twitter_published_entry( $entry ) {
        global $serendipity;

        if (!serendipity_db_bool($this->get_config('announce_articles'))) return false;

        // Do not announce future entries!
        if (empty($entry['timestamp']) || time()<$entry['timestamp']) return false;

        $announce_account_list = explode('^',$this->get_config('announce_via_accounts'));
        if (count($announce_account_list)==0) return true;

        $announce_format = trim($this->get_config('announce_format', $this->get_default_announceformat()));

        $updates = array();
        echo "<ul>";
        foreach ($announce_account_list as $announce_account) {
            $suffix = empty($announce_account)?'':(int)$announce_account+1;
            $account_name = $this->get_config('twittername'.$suffix,'');
            $account_pwd = $this->get_config('twitterpwd'.$suffix,'');
            $account_type = $this->get_config('id_service'.$suffix,'twitter');

            // For twitter we need a special update generation
            if (empty($updates[$account_type])) {
                $update = $this->create_update_from_entry($entry, $announce_format, 'twitter'==$account_type);
                $updates[$account_type] = $update;
            }
            else {
                $update = $updates[$account_type];
            }

            // If the GeoTag Plugin is installed, it will hand over some geodata
            $geo_lat = $serendipity['POST']['properties']['geo_lat'];
            $geo_long = $serendipity['POST']['properties']['geo_long'];

            $this->twitter_published_entry_to_account($suffix, $account_name, $account_pwd, $account_type, $update, $geo_lat, $geo_long);
        }

        echo "</ul>";
        return true;
    }

    function twitteroa_connect($idx = '') {
        require_once(dirname(__FILE__).'/twitteroauth/twitteroauth.php');

        $u  = $this->get_config('twittername' . $idx);
        $kd = $oauth_token        = $this->get_config('twitteroa_key_' . $idx .$u);
        $td = $oauth_token_secret = $this->get_config('twitteroa_token_' . $idx . $u);
        $ckey = $consumer_key       = $this->get_config('twitteroa_consumer_key' . $idx);
        $csecret = $consumer_secret    = $this->get_config('twitteroa_consumer_secret' . $idx);

        /* Create a TwitterOauth object with consumer/user tokens. */
        $connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
        return $connection;
    }

    function twitter_published_entry_to_account($account_index, $account_name, $account_pwd, $account_type, $update, $geo_lat = NULL, $geo_long = NULL ) {
        if ($account_type == "identica"){
            $api = new Twitter($account_type=='identica');
            $status = $api->update($account_name, $account_pwd, $update, $geo_lat, $geo_long);
        } else {
            $connection = $this->twitteroa_connect($account_index);
            $api = new TwitterOAuthApi($connection);
            $status = $api->update($update, $geo_lat, $geo_long);
        }

        // Information about status update
        echo "<li>$account_type update for $account_name: [" . mb_convert_encoding($update, LANG_CHARSET) . "]";
        if (!empty($geo_lat) && !empty($geo_long)) {
            echo ", Geo: lat=$geo_lat / long=$geo_long";
        }
        echo "</li>";
        if (PLUGIN_TWITTER_DEBUG) {
            echo "<li>Status $status</li>";
        }

    }
    
    function twitteroa_global_consumersettings() {
        // Return local client setup with fallback to the s9y client
        $result = array();
        $result['key']    =$this->get_config('general_oa_consumerkey', PLUGIN_TWITTER_OAUTH_TWITTER_CONSUMERKEY);
        $result['secret'] =$this->get_config('general_oa_consumersecret', PLUGIN_TWITTER_OAUTH_TWITTER_CONSUMERSECRET);
        return $result;
    }

    function default_shorturl( $url ) {
        $default = $this->get_config('anounce_url_service','7ax.de');
        $shorturls = TwitterPluginDbAccess::load_short_urls( $url, array($default) );
        if (!empty($shorturls[$default])) return $shorturls[$default];

        $shorturls = array();
        $shorter = $this->get_urlshortener();
        $shorter->put_shorturl($this->get_config('anounce_url_service','7ax.de'), $url, $shorturls);
        if (!empty($shorturls[$this->get_config('anounce_url_service','7ax.de')])) {
            TwitterPluginDbAccess::save_short_urls( $url, $shorturls);
            return $shorturls[$this->get_config('anounce_url_service','7ax.de')];
        }
        else {
            return $url;
        }
    }

    /**
     * adds tweetthis, dentthis and "check tweetbacks" (if logged in) to footer 
     */
    function display_entry(&$eventData, $addData) {
        global $serendipity;

        if ($addData['preview']) return false;

        $do_tweetbacks = serendipity_db_bool($this->get_config('do_tweetbacks',false));
        $do_tweetthis  = serendipity_db_bool($this->get_config('do_tweetthis',false));
        $do_identicathis  = serendipity_db_bool($this->get_config('do_identicathis',false));
        $do_smartify  = serendipity_db_bool($this->get_config('tweetthis_smartify',false));
        $show_shorturl = serendipity_db_bool($this->get_config('show_shorturl',false));

        //if (!$do_tweetbacks && !$do_tweetthis && !$do_identicathis) return false;

        if (!is_array($eventData)) return false;

        $pluginurl = $serendipity['baseURL'] . $serendipity['indexFile'] . '?/' . TwitterPluginFileAccess::get_permaplugin_path();

        if ($do_tweetthis || $do_identicathis) {
            $tweetthis_format = $this->get_config('tweetthis_format','#title# #link#');
            $tweetthis_button = $this->get_config('tweetthis_button','black');

            $tweetthis_target = '';
            if (serendipity_db_bool($this->get_config('tweetthis_newwindow',false))) {
                $tweetthis_target = ' target="_blank"';
            }
        }

        $event_index = 0;
        foreach ($eventData as $entry) {

            // Test for nonsense data (or static pages)
            if (!isset($entry['id']) || !is_numeric($entry['id']) || (int)$entry['id']<1) {
                continue;
            }

            $entryurl = $this->generate_article_url($entry);
            // Show tweetback check link only logged in users
            //if ($do_tweetbacks && $_SESSION['serendipityAuthedUser'] && $addData['extended']) {
            if ($_SESSION['serendipityAuthedUser'] && $addData['extended']) {
                $checkurl = $pluginurl. '/tweetback=' . $this->urlencode($entryurl);
                $tweetback_check_msg = '<div class="serendipity_tweetback_check"><a target="_blank" href="' . $checkurl . '">check tweetbacks</a></div>';
                $eventData[$event_index]['add_footer'] .= $tweetback_check_msg;
            }

            // add shorturl to entryfooter
            if ($show_shorturl) {
                $shorturl = $this->default_shorturl($entryurl);
                $onclick = htmlspecialchars(PLUGIN_EVENT_TWITTER_SHORTURL_ON_CLICK);
                if ($do_smartify) { // emit smarty tag only
                    $eventData[$event_index]['url_shorturl'] = $shorturl;
                }
                else {
                    $eventData[$event_index]['add_footer'] .= '<div class="serendipity_shorturl_link"><a class="serendipity_shorturl_link" rel="nofollow" title="' . $onclick . '" href="'. $shorturl . '" onclick="alert(\'' . $onclick . '\');return false">' . PLUGIN_EVENT_TWITTER_SHORTURL_TITLE . '</a></div>';
                }
            }
        
            if ($do_tweetthis || $do_identicathis) {

                $update = $update = $this->create_update_from_entry($eventData[$event_index], $tweetthis_format);

                if ($do_tweetthis) {
                    $url_tweetthis = 'http://twitter.com/intent/tweet?text=' . urlencode($update) ;
                    if ($do_smartify) { // emit smarty tag only
                        $eventData[$event_index]['url_tweetthis'] = $url_tweetthis;
                    }
                    else {
                        // http://twitter.com/home/?status=Tweet+This%2C+a+WordPress+Plugin+for+Twitter+http://richardxthripp.thripp.com/?p=646
                        $button_url =  $this->get_config('plugin_rel_url') . '/img/tt-micro-' . $this->get_config('tweetthis_button','black') . '.png';
                        $tweetthis = '<a class="serendipity_tweetthis_img" href="' . $url_tweetthis . '"' . $tweetthis_target . '><img src="' . $button_url . '" alt="'. PLUGIN_EVENT_TWITTER_TWEETTHIS_TITLE .'" /></a>';
                        $eventData[$event_index]['add_footer'] .= $tweetthis;
                    }
                }
                if ($do_identicathis) {
                    $url_dentthis = 'http://identi.ca/notice/new?status_textarea=' . urlencode($update);
                    if ($do_smartify) { // emit smarty tag only
                        $eventData[$event_index]['url_dentthis'] = $url_dentthis;
                    }
                    else {
                        // http://twitter.com/home/?status=Tweet+This%2C+a+WordPress+Plugin+for+Twitter+http://richardxthripp.thripp.com/?p=646
                        $button_url =  $this->get_config('plugin_rel_url') . '/img/it-micro-' . $this->get_config('tweetthis_button','black') . '.png';
                        $tweetthis = '<a class="serendipity_tweetthis_img" href="' . $url_dentthis . '"' . $tweetthis_target . '><img src="' . $button_url . '" alt="'. PLUGIN_EVENT_TWITTER_TWEETTHIS_TITLE .'" /></a>';
                        $eventData[$event_index]['add_footer'] .= $tweetthis;
                    }
                }
            }
            $event_index++;
        }

    }

    function generate_article_url( $entry ) {
        global $serendipity;
        $urlparts = @parse_url($serendipity['baseURL']);
        $server = $urlparts['scheme'] . '://' . $urlparts['host'];
        if (!empty($urlparts['port'])) $server = $server . ':' . $urlparts['port'];

        $relurl = serendipity_archiveURL($entry['id'], $entry['title'], 'serendipityHTTPPath', true, array('timestamp' => $entry['timestamp']));

        return $server . $relurl;
    }

    function generate_domain_url($addScheme = true) {
        global $serendipity;
        $urlparts = @parse_url($serendipity['baseURL']);
        $server = ($addScheme?$urlparts['scheme'] . '://':"") . $urlparts['host'];
        $this->log("server= " . $server);
        return $server;
    }

    function create_short_urls( $article_url ) {

        $selected_services = array('raw');

        // preload shorturls, we have fetched before
        $shorturls = TwitterPluginDbAccess::load_short_urls( $article_url, $selected_services );

        // remember already known shorturls
        $loaded_shorturls = $shorturls;
        $shorter = $this->get_urlshortener();

        foreach ($selected_services as $service) {
            $shorter->put_shorturl($service, $article_url, $shorturls);
        }

        TwitterPluginDbAccess::save_short_urls( $article_url, $shorturls, $loaded_shorturls );

        return $shorturls;
    }

    /**
     * Return binary response for an image
     */
    function show_img($filename, $nextcheck=null, $mime_type='image/png') {

        if (empty($nextcheck)) $nextcheck = time() + (30*60); // try again in 30min, if nothing was specified.

        header("Content-type: $mime_type");
        header("Date: " . date("D, d M Y H:i:s T"));
        header("Cache-Control: public, max-age=" . ((int)$nextcheck - time()) , true);
        header("Pragma:", true);

        $expires_txt = date("D, d M Y H:i:s T",(int)$nextcheck);

        $fp   = @fopen($filename, "rb");
        if ($fp) {
            header('X-TweetBackPng: Found');
            $filemtime = filemtime($filename);
            header("Content-Length: ". filesize($filename), true);
            header("Last-Modified: " . date("D, d M Y H:i:s T", $filemtime), true);
            header("Expires: $expires_txt". true);
            fpassthru($fp);
            fclose($fp);
        }
        else {
            header('X-TweetBackPng: No-Image');
            header("Content-Length: 0", true);
            header("Last-Modified: " . date("D, d M Y H:i:s T"), true);
            header("Expires: $expires_txt". true);
        }
        return true;
    }

    /**
     * Returns a URL encoded and signed variable.
     */
    function urlencode($url) {
        $hash = md5($this->instance_id . $url);
        # return $hash . str_replace ('_', '%5F', urlencode($url));
        return $hash . base64_encode($url);//changed by Ruben
    }

    function urldecode($url) {
        $hash     = substr($url, 0, 32);
        # $real_url = urldecode(substr($url, 32));
        $real_url = base64_decode(substr($url, 32));//changed by Ruben

        if ($hash == md5($this->instance_id . $real_url)) {
            // Valid hash was found.
            return $real_url;
        } else {
            // Invalid hash.
            return '';
        }
    }

    function debug_entries($entries, $article_url, $shorturls) {
        // Newst first
        $entries = array_reverse( $entries );

        echo "<h1>Tweetbacks Statistics</h1>";
        echo "URL: $article_url<br>";
        echo "<h2>Short URLs searched</h2>";
        echo "<ul>";
        foreach ($shorturls as $short_url) {
            echo "<li>$short_url</li>";
        }
        echo "</ul>";

        echo "<h2>Tweets found</h2>";
        echo "Found " . count($entries) . " tweets.<br>";
        echo "<ul>";
        foreach($entries as $entry) {
            $comment_url = $this->comment_url($entry);
            echo "<li>";
            //echo "<b>twitter search</b>: " . $entry[TWITTER_SEARCHRESULT_URL_QUERY] . "<br/>";

            if (!empty($entry[TWITTER_SEARCHRESULT_URL_IMG])) {
                echo '<img src="' .$entry[TWITTER_SEARCHRESULT_URL_IMG] .'" widht="48" height="48" alt="' . $entry[TWITTER_SEARCHRESULT_REALNAME] .'" title="' . $entry[TWITTER_SEARCHRESULT_REALNAME] . '" /><br/>';
            }
            echo '<a href="' . $entry[TWITTER_SEARCHRESULT_URL_AUTOR] . '">' . $entry[TWITTER_SEARCHRESULT_LOGIN] .'</a><br/>';
            echo $entry[TWITTER_SEARCHRESULT_TWEET] . '<br/>';
            echo 'RT:' . $entry[TWITTER_SEARCHRESULT_RETWEET] . ' ';
            echo '<a href="' . $entry[TWITTER_SEARCHRESULT_URL_TWEET] . '">ID:' . $entry[TWITTER_SEARCHRESULT_ID] . '</a><br/>';
            echo '<a href="' . $comment_url . '">comment url in blog</a><br/>';
            echo 'Time:' . $entry[TWITTER_SEARCHRESULT_PUBDATE] . ',  ' . strtotime($entry[TWITTER_SEARCHRESULT_PUBDATE]);
            echo "</li>";
        }
        echo "</ul>";
    }

    function updateTwitterTimelineCache($parts){
        global $serendipity;
        require_once S9Y_PEAR_PATH . 'HTTP/Request.php';

        if (count($parts)<5) return time() + (60 * 60); // params corrupted next try allowed one minute later 

        // Do we need to do OAuth?
        if (count($parts)>6) {
            $idx_twitter = $parts[5];
            $idxmd5 = $parts[6];
            $idxmd5_test = md5(serendipity_event_twitter::pluginSecret() . "_{$idx_twitter}");
            if ($idxmd5_test != $idxmd5) { // Seems to be a hack!
                return time() + (60 * 60); // params corrupted next try allowed one minute later
            }
        }
        $show_rt = false;
        if (count($parts)>7) {
            $features = $parts[7];
            $show_rt  = (strpos($features, 'r')!==false);
        }

        $cachetime    = (int)$parts[4];

        $service      = $parts[1];
        $username     = str_replace('!', '_', $parts[2]);
        $cache_user   = md5($service) . md5($username);
        $cachefile    = $serendipity['serendipityPath'] . PATH_SMARTY_COMPILE . "/twitterresult.$cache_user.json";
        $nextcheck    = time() + (int)$cachetime;

        if (file_exists($cachefile)) {
            $nextcheck = filemtime($cachefile) + $cachetime;
        }

        if (!file_exists($cachefile) || filemtime($cachefile) < (time()-$cachetime)) {
            $number = str_replace("!","_",$parts[3]);

            $error=200; // Default is: All OK

            if (!empty($idx_twitter)) {
                $search_twitter_uri = 'http://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $username . '&count=' . $number . '&trim_user=true';
                if (!$show_rt) $search_twitter_uri .= '&include_rts=false';
                if ($idx_twitter=='1') $idx_twitter=''; // First cfg is saved with empty suffix!
                $connection = $this->twitteroa_connect($idx_twitter);
                $connection->decode_json = false;
                $response = $connection->get($search_twitter_uri);
            }
            else {
                if ($service == 'identi.ca')
                {
                    $followme_url = 'http://identi.ca/' . $username;
                    $status_url = 'http://identi.ca/notice/';
                    $JSONcallback = 'identicaCallback2';

                    $service_url = 'http://identi.ca/api';
                    $search_twitter_uri = $service_url . '/statuses/user_timeline/' . $username . '.json?count=' . $number;
                }
                else
                {
                    $followme_url = 'http://twitter.com/' . $username;
                    $service_url = 'http://twitter.com';
                    $status_url = 'http://twitter.com/' . $username . '/statuses/';
                    $JSONcallback = 'twitterCallback2';
                    $search_twitter_uri = 'http://api.twitter.com/1/statuses/user_timeline.json?screen_name=' . $username . '&count=' . $number;
                }

                serendipity_request_start();
                $req = new HTTP_Request($search_twitter_uri);
                $req->sendRequest();
                $response = trim($req->getResponseBody());
                $error = $req->getResponseCode();
                serendipity_request_end();
            }

            $this->log("error: {$error}");
            if ($error==200 && !empty($response)) {
                $this->log("Writing response into cache.");
                $fp = fopen($cachefile, 'w');
                fwrite($fp, serialize($response));
                fflush($fp);
                fclose($fp);
                $nextcheck = time() + (int)$cachetime;
                $this->log("Writing response into cache. DONE");
            }
        }
        return $nextcheck;
    }

    function curPageURL() {
        return $_SERVER["REQUEST_URI"];
    }

    function log($message){
        if (!PLUGIN_TWITTER_DEBUG) return;
        $fp = fopen(TwitterPluginFileAccess::get_cache_prefix() . '.log','a');
        fwrite($fp, date('Y.m.d H:i:s') . " - " . $message . "\n");
        fflush($fp);
        fclose($fp);
    }
    
    function load_timeline() {
        $status_timeline = array(
            "public_timeline", 
            "home_timeline", 
            "friends_timeline", 
            "user_timeline",
            "mentions",
            "retweeted_by_me",
            "retweeted_to_me",
            "retweets_of_me");
        return $status_timeline;
    }

    function load_identities() {
        $idcount = $this->get_config('id_count',1);
        if (!is_numeric($idcount)) $idcount = 1;
        $identities = array();
        $identities[] = $this->get_config('id_service','twitter') . ': ' . $this->get_config('twittername');
        
        for ($idx=2; $idx<=$idcount; $idx++) {
            $identities[] = $this->get_config('id_service'. $idx,'twitter') . ': ' . $this->get_config('twittername'. $idx);
        }
        return $identities;
    }
    
    function display_twitter_client($tweeter_in_sidbar = false) {
        $identities             = $this->load_identities();
        $status_timeline     = $this->load_timeline();
        $tweeter_has_timeline = ($this->get_config('tweeter_history', false) === true);
        
        if ($_POST['tweeter_timeline']){
            $pstatus_timeline = $_POST['tweeter_timeline'];
        } else {
            $pstatus_timeline = $this->get_config('tweeter_timeline');
        }

        // Always remember last set identity            
        $val_identitiy = $_POST['tweeter_account'];
        $acc_number = '';
        if (empty($val_identitiy) || $val_identitiy==0) {
            $account_name = $this->get_config('twittername','');
            $account_pwd = $this->get_config('twitterpwd','');
            $account_type = $this->get_config('id_service','twitter');
        }
        else {
            $acc_number = (int)$val_identitiy + 1;
            $account_name = $this->get_config('twittername' . $acc_number,'');
            $account_pwd = $this->get_config('twitterpwd' . $acc_number,'');
            $account_type = $this->get_config('id_service' . $acc_number,'twitter');
        }

        // Display client
        if($this->get_config('tweeter_show', 'disable') != 'disable'){
            if (isset($_POST['tweeter_submit'])) {
                if(isset($_POST['tweet'], $_POST['shorturl'])){
                    if($_POST['shorturl'] !== 'http://' && !empty($_POST['shorturl'])){
                        $val_short = $this->default_shorturl($_POST['shorturl']);

                        if($val_short == $_POST['shorturl']){
                            $val_short = 'ERROR';
                        }

                        $val_tweet = $_POST['tweet'] . $val_short;
                        $val_short = '';

                    }
                    elseif(!empty($_POST['tweet'])){
                        $update = $_POST['tweet'];
                        // Change encoding of update to UTF-8
                        if (LANG_CHARSET!='UTF-8' && function_exists("mb_convert_encoding")) {
                            $update = mb_convert_encoding($update, 'UTF-8', LANG_CHARSET);
                        }

                        if ($account_type == "identica"){
                            $api = new Twitter($account_type=='identica');
                            $twit = $api->update( $account_name, $account_pwd, $update );
                        } else {
                            $connection = $this->twitteroa_connect($acc_number);
                            $api = new TwitterOAuthApi($connection);
                            $status = $api->update($update);
                            $twit = true;
                        }

                        if ($twit === true){
                            $notice = PLUGIN_EVENT_TWITTER_TWEETER_STORED;
                        }
                        else{
                            $val_tweet = $_POST['tweet'];
                            $notice = PLUGIN_EVENT_TWITTER_TWEETER_STOREFAIL . $twit;
                        }
                    }
                }
            }
            elseif (isset($_POST['tweeter_change_identity'])) {
                $val_tweet = $_POST['tweet'];
                $val_short = $_POST['shorturl'];
            }

            // Create strings of twitter URL length:
            $this->twitter_check_config();
            $http_length_str = str_repeat("=", $this->get_config('twitter_config_http_len'));
            $https_length_str = str_repeat("=", $this->get_config('twitter_config_https_len'));

            // Hide shorten url input, if no url shorter is used!
            if ('raw' == $this->get_config('anounce_url_service','7ax.de')) {
                echo "<style type=\"text/css\">div#serendipity_admin_tweeter_shorturl {display: none;}</style>";
                @define('PLUGIN_EVENT_TWITTER_TWEETER_SHORTEN_OR_UPDATE',  PLUGIN_EVENT_TWITTER_TWEETER_UPDATE);
            }
            else {
                @define('PLUGIN_EVENT_TWITTER_TWEETER_SHORTEN_OR_UPDATE',  PLUGIN_EVENT_TWITTER_TWEETER_SHORTEN . ' / ' . PLUGIN_EVENT_TWITTER_TWEETER_UPDATE);
            }
            // Display the form
            include dirname(__FILE__) . '/tweeter/tweeter_client.inc.php';

        }
        else {
            return true; // if disabled, don't display anything else!
        }

        // Display history
        if($tweeter_has_timeline){
            if ($account_type == "identica"){
                $count = $this->get_config('tweeter_history_count', 10);
                $api = new Twitter($account_type=='identica');
                $statuses = $api->timeline( $account_name, $account_pwd, $count );
            } else {
                require_once(dirname(__FILE__).'/twitteroauth/twitteroauth.php');
                if ($_POST['tweeter_timeline']){
                    $get_connection = "statuses/".$_POST['tweeter_timeline'];
                } else {
                    $get_connection = "statuses/".$this->get_config('tweeter_timeline');
                }

                $connection = $this->twitteroa_connect($acc_number);
                $statuses     = $connection->get($get_connection);
                $http_code    = $connection->http_code;
                $api = new Twitter($account_type=='identica');
            }

            $buffer = '';
            if (!is_array($statuses)) {
                if (empty($statuses)) {
                    $buffer = '<li><strong>Result from Twitter was empty.</strong><br/>Perhaps down for maintenance?</li>';
                }
                elseif (is_object($statuses)) {
                    if (!empty($statuses->error)) {
                        $buffer = '<li><strong>' .  $statuses->error . '</strong></li>';
                    }
                    else {
                    $buffer = '<li><strong>Reported an unknown error</strong></li>';
                    }
                }
                else {
                    print_r($statuses);
                    $buffer = '<li><strong>Twitter reported http error ' .  $statuses . '</strong></li>';
                }
            }
            else {
                if ($account_type == "twitter"){
                    if ($_POST['tweeter_timeline']){
                        $buffer .= "<h2>".PLUGIN_EVENT_TWITTER_TIMELINE.": ".$_POST['tweeter_timeline']."</h2>";
                    } else {
                        $buffer .= "<h2>".PLUGIN_EVENT_TWITTER_TIMELINE.": ".$this->get_config('tweeter_timeline')."</h2>";
                    }
                }

                foreach($statuses as $status){
                    // Setup links inside of the text
                    $status->text = $api->replace_links_in_status($status->text);

                    // Change encoding to blog encoding
                    if (LANG_CHARSET!='UTF-8' && function_exists("mb_convert_encoding")) {
                        $status->text = mb_convert_encoding($status->text, LANG_CHARSET, 'UTF-8');
                    }
                    if (strtoupper($account_name)!=strtoupper($status->user->screen_name)) {
                        $reply_link = '<a href="javascript:tweeter_reply(\'' . $status->user->screen_name . '\');" title="' . PLUGIN_EVENT_TWITTER_TWEETER_REPLY . '">@</a>';
                        $direct_link = '<a href="javascript:tweeter_dm(\'' . $status->user->screen_name . '\');" title="' . PLUGIN_EVENT_TWITTER_TWEETER_DM . '">DM</a>';
                        $retweet_link = '<a href="javascript:tweeter_retweet(\'' . $status->user->screen_name . '\', \'' . str_replace('"','#quot2;',str_replace("'",'#quot1;',strip_tags($status->text))) . '\');" title="' . PLUGIN_EVENT_TWITTER_TWEETER_RETWEET . '">RT</a>';
                    }
                    else {
                        $reply_link = '';
                        $direct_link = '';
                        $retweet_link = '';
                    }

                    // Twitter delivers the complete status ID in an extra field! 
                    $status_id = $account_type=='identica'?$status->id:$status->id_str;
                    // Add each status formatted to a html buffer
                    $buffer .= '<li class="tweeter_line">
                                    <div class="tweeter_profile_img">
                                        <img src="'.$status->user->profile_image_url.'" width="48" height="48" alt="" title="' . $status->user->screen_name . '"/>
                                    </div
                                    <div  class="tweeter_profile_text">
                                        <a href="' . $api->get_base_url() .$status->user->screen_name.'">'.$status->user->screen_name.'</a> '.$status->text.'
                                    </div>
                                    <div  class="tweeter_profile_links">
                                        <a href="' . $api->get_status_url($status->user->screen_name,  $status_id) . '">'.Twitter::create_status_ago_string($status->created_at).'</a> from ' . $status->source . ' ' . $reply_link . ' ' . $direct_link . ' ' . $retweet_link . '
                                    </div>
                                </li>';
                }
            }

            // Display the history
            include dirname(__FILE__) . '/tweeter/tweeter_history.inc.php';
            $return = true;
        }
    }

    // We generate a secret only known by the blog admit.
    // We use the directory of this plugin md5'd
    static function pluginSecret() {
        return md5(dirname(__FILE__));
    }

    static function getTwitterOauths() {
        $idcount = serendipity_event_twitter::get_config_event('id_count');
        if (empty($idcount)) {
            return array();
        }
        $twitter_oauths = array();
        for ($idx=1; $idx<=$idcount; $idx++) {
            $suffix = $idx==1?'':$idx;
            $service = serendipity_event_twitter::get_config_event('id_service' . $suffix);
            if ($service == "twitter") {
                $oautKey = serendipity_event_twitter::get_config_event('twitteroa_consumer_secret' . $suffix);
                if (!empty($oautKey)) {
                    $twitter_oauths[$idx] = serendipity_event_twitter::get_config_event('twittername' . $suffix);
                }
            }
        }
        return $twitter_oauths;
    }

    static function get_config_event($name, $defaultvalue = null) {
        global $serendipity;
        
        $db_event_search = "serendipity_event_twitter:%/" . $name;
        $r = serendipity_db_query("SELECT value FROM {$serendipity['dbPrefix']}config WHERE name like '" . $db_event_search . "' LIMIT 1", true);
        if (is_array($r)) {
            return $r[0];
        } else {
            return $defaultvalue;
        }

    }
}
