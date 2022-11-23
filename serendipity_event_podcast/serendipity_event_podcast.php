<?php # 

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


@serendipity_plugin_api::load_language(dirname(__FILE__));

include_once dirname(__FILE__) . '/podcast_player.php';

@define("SERENDIPITY_EVENT_PODCAST_VERSION", "1.37.7");

class serendipity_event_podcast extends serendipity_event {
/**
The Serendipity Podcasting Plugin

@author Hannes Gassert <hannes@mediagonal.ch>
@package serendipity
@version 
class serendipity_event_podcast extends serendipity_event{
**/
    var $title = PLUGIN_PODCAST_NAME;

    // Array of extensions => shorttype  filled by configuration
    var $supportedFiletypes = null;
    // Array of shorttype => player filled by configuration
    var $supportedPlayers   = null;
    
    // Array of fileurls replaced with player code
    var $playerUrlsAdded = array();
    
    // Enable debug messages?
    var $debug = false;
        
    /**
    @access public
    */
    function introspect(&$propbag)
    {

        $events =  array(
            'frontend_display:rss-1.0:per_entry' => true,
            'frontend_display:rss-2.0:per_entry' => true,
            'frontend_display:rss-1.0:namespace' => true,
            'frontend_display:rss-2.0:namespace' => true,
            'frontend_display'  => true,
            'frontend_header'   => true,
            'css' => true
        );

        $propbag->add('name', PLUGIN_PODCAST_NAME);
        $propbag->add('description', PLUGIN_PODCAST_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('license', 'GPL');

        $propbag->add('cachable_events', $events);
        $propbag->add('event_hooks', $events);
        $propbag->add('configuration', array(
            'info', 
            
            'easy', 
            'use_player', 
            'automatic_size', 
            'width', 
            'height', 
            'align', 
            'firstmedia_only', 
            'nopodcasting_class',
            'epheader', 
            'extendet_enclosure_attributes', 
            'extendet_enclosure_position', 
            'ep_automatic_size', 
            'ep_align', 
            'ep_asure_enc', 
            
            'mergemulti',
            'downloadlink',
            
            'expert', 
            
            'itunes_meta',
            
            /* players */
            'extflow', 
            'extflow_player', 

            'extquicktime', 
            'extquicktime_player', 

            'extwinmedia', 
            'extwinmedia_player', 

            'extflash', 
            'extflash_player', 

            'extxspf', 
            'extxspf_player', 

            'extaudio', 
            'extaudio_player', 

            'exthtml5_audio', 
            'exthtml5_audio_player', 
            
            'exthtml5_video', 
            'exthtml5_video_player', 

            /* exotic options */
            'use_cache', 
            'plugin_http_path'
        ));

        $propbag->add('author', 'Grischa Brockhaus, Hannes Gassert, Garvin Hicking');
        $propbag->add('version', SERENDIPITY_EVENT_PODCAST_VERSION);
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('BACKEND_EDITOR'));
    }

    /**
    @access public
    */
    function introspect_config_item($name, &$propbag)    {
        global $serendipity;
        switch($name) {
            case 'info':
                $propbag->add('type',           'content');
                $propbag->add('default',        nl2br((function_exists('serendipity_specialchars') ? serendipity_specialchars(PLUGIN_PODCAST_USAGE) : htmlspecialchars(PLUGIN_PODCAST_USAGE, ENT_COMPAT, LANG_CHARSET)) . "\n" . PLUGIN_PODCAST_USAGE_RSS));
                break;

            case 'easy':
                $propbag->add('type',           'content');
                $propbag->add('default',        nl2br(PLUGIN_PODCAST_EASY));
                break;

            case 'expert':
                $propbag->add('type',           'content');
                $propbag->add('default',        nl2br(PLUGIN_PODCAST_EXPERT . "\n" . PLUGIN_PODCAST_EXPERT_HINT));
                break;

            case 'epheader':
                $propbag->add('type',           'content');
                $propbag->add('default',        nl2br(PLUGIN_PODCAST_EXTATTRSETTINGS));
                break;

            case 'seperator':
                $propbag->add('type',           'seperator');
                break;

            case 'use_player':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_PODCAST_USEPLAYER);
                $propbag->add('description',    '');
                $propbag->add('default',        'true');
                break;

            case 'automatic_size':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_PODCAST_AUTOSIZE);
                $propbag->add('description',    PLUGIN_PODCAST_AUTOSIZE_DESC);
                $propbag->add('default',        'false');
                break;

            case 'mergemulti':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_PODCAST_MERGEMULTI);
                $propbag->add('description',    '');
                $propbag->add('default',        'true');
                break;

            case 'downloadlink':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_PODCAST_DOWNLOADLINK);
                $propbag->add('description',    PLUGIN_PODCAST_DOWNLOADLINK_DESC);
                $propbag->add('default',        'true');
                break;

            case 'ep_automatic_size':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_PODCAST_AUTOSIZE);
                $propbag->add('description',    PLUGIN_PODCAST_AUTOSIZE_DESC);
                $propbag->add('default',        'false');
                break;

            case 'width':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_PODCAST_WIDTH);
                $propbag->add('description',    PLUGIN_PODCAST_WIDTH_DESC);
                $propbag->add('default',        '200');
                break;

            case 'height':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_PODCAST_HEIGHT);
                $propbag->add('description',    PLUGIN_PODCAST_HEIGHT_DESC);
                $propbag->add('default',        '200');
                break;
                
            case 'align':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_PODCAST_ALIGN);
                $propbag->add('description',    PLUGIN_PODCAST_ALIGN_DESC);
                $propbag->add('select_values',  $this->GetAlignOptionsArray());
                $propbag->add('default',        'left');
                break;
            case 'nopodcasting_class':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_PODCAST_NOPODCASTING_CLASS);
                $propbag->add('description',    PLUGIN_PODCAST_NOPODCASTING_CLASS_DESC);
                $propbag->add('default',        'nopodcast');
                break;
                
            case 'firstmedia_only':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_PODCAST_FIRSTMEDIAONLY);
                $propbag->add('description',    PLUGIN_PODCAST_FIRSTMEDIAONLY_DESC);
                $propbag->add('default',        'false');
                break;

            case 'ep_align':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_PODCAST_ALIGN);
                $propbag->add('description',    PLUGIN_PODCAST_ALIGN_DESC);
                $propbag->add('select_values',  $this->GetAlignOptionsArray());
                $propbag->add('default',        'center');
                break;

            case 'extendet_enclosure_attributes':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_PODCAST_EXTATTR);
                $propbag->add('description',    PLUGIN_PODCAST_EXTATTR_DESC);
                $propbag->add('default',        'Podcast,Video');
                break;

            case 'extendet_enclosure_position':
                $positions = array(
                    'none'          => PLUGIN_PODCAST_EXTPOS_NONE,
                    'body_top'      => PLUGIN_PODCAST_EXTPOS_BT,
                    'body_botton'   => PLUGIN_PODCAST_EXTPOS_BB,
                    'ext_top'       => PLUGIN_PODCAST_EXTPOS_ET,
                    'ext_botton'    => PLUGIN_PODCAST_EXTPOS_EB,
                );
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_PODCAST_EXTPOS);
                $propbag->add('description',    PLUGIN_PODCAST_EXTPOS_DESC);
                $propbag->add('select_values',  $positions);
                $propbag->add('default',        'none');
                break;

            case 'ep_asure_enc':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_PODCAST_ASURE_FEEDENC);
                $propbag->add('description',    PLUGIN_PODCAST_ASURE_FEEDEENC_DESC);
                $propbag->add('default',        'true');
                break;

            /* PLAYERS */
            case 'extflow':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_PODCAST_FLOWEXT);
                $propbag->add('description',    PLUGIN_PODCAST_FLOWEXT_DESC);
                $propbag->add('default',        PLUGIN_PODCAST_FLOWEXT_DEFAULT);
                break;

            case 'exthtml5_audio':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_PODCAST_HTML5_AUDIO);
                $propbag->add('description',    PLUGIN_PODCAST_HTML5_AUDIO_DESC);
                $propbag->add('default',        PLUGIN_PODCAST_HTML5_AUDIO_DEFAULT);
                break;

            case 'exthtml5_video':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_PODCAST_HTML5_VIDEO);
                $propbag->add('description',    PLUGIN_PODCAST_HTML5_VIDEO_DESC);
                $propbag->add('default',        PLUGIN_PODCAST_HTML5_VIDEO_DEFAULT);
                break;

            case 'extquicktime':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_PODCAST_QTEXT);
                $propbag->add('description',    PLUGIN_PODCAST_QTEXT_DESC);
                $propbag->add('default',        PLUGIN_PODCAST_QTEXT_DEFAULT);
                break;

            case 'extwinmedia':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_PODCAST_WMEXT);
                $propbag->add('description',    PLUGIN_PODCAST_WMEXT_DESC);
                $propbag->add('default',        PLUGIN_PODCAST_WMEXT_DEFAULT);
                break;

            case 'extflash':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_PODCAST_MFEXT);
                $propbag->add('description',    PLUGIN_PODCAST_MFEXT_DESC);
                $propbag->add('default',        PLUGIN_PODCAST_MFEXT_DEFAULT);
                break;

            case 'extxspf':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_PODCAST_XSPFEXT);
                $propbag->add('description',    PLUGIN_PODCAST_XSPFEXT_DESC);
                $propbag->add('default',        PLUGIN_PODCAST_XSPFEXT_DEFAULT);
                break;

            case 'extaudio':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_PODCAST_AUEXT);
                $propbag->add('description',    PLUGIN_PODCAST_AUEXT_DESC);
                $propbag->add('default',        PLUGIN_PODCAST_AUEXT_DEFAULT);
                break;



            case 'extflow_player':
                $propbag->add('type',           'text');
                $propbag->add('name',           PLUGIN_PODCAST_FLOWEXT_HTML);
                $propbag->add('description',    '');
                $propbag->add('default',        PLUGIN_PODCAST_FLOWPLAYER);
                break;

            case 'exthtml5_audio_player':
                $propbag->add('type',           'text');
                $propbag->add('name',           PLUGIN_PODCAST_HTML5_AUDIO_HTML);
                $propbag->add('description',    '');
                $propbag->add('default',        PLUGIN_PODCAST_HTML5_AUDIOPLAYER);
                break;

            case 'exthtml5_video_player':
                $propbag->add('type',           'text');
                $propbag->add('name',           PLUGIN_PODCAST_HTML5_VIDEO_HTML);
                $propbag->add('description',    '');
                $propbag->add('default',       PLUGIN_PODCAST_HTML5_VIDEOPLAYER);
                break;

            case 'extquicktime_player':
                $propbag->add('type',           'text');
                $propbag->add('name',           PLUGIN_PODCAST_QTEXT_HTML);
                $propbag->add('description',    '');
                $propbag->add('default',        PLUGIN_PODCAST_QUICKTIMEPLAYER);
                break;

            case 'extwinmedia_player':
                $propbag->add('type',           'text');
                $propbag->add('name',           PLUGIN_PODCAST_WMEXT_HTML);
                $propbag->add('description',    '');
                $propbag->add('default',        PLUGIN_PODCAST_WMPLAYER);
                break;

            case 'extflash_player':
                $propbag->add('type',           'text');
                $propbag->add('name',           PLUGIN_PODCAST_MFEXT_HTML);
                $propbag->add('description',    '');
                $propbag->add('default',        PLUGIN_PODCAST_FLASHPLAYER);
                break;

            case 'extxspf_player':
                $propbag->add('type',           'text');
                $propbag->add('name',           PLUGIN_PODCAST_XSPFEXT_HTML);
                $propbag->add('description',    '');
                $propbag->add('default',        PLUGIN_PODCAST_XSPFPLAYER);
                break;

            case 'extaudio_player':
                $propbag->add('type',           'text');
                $propbag->add('name',           PLUGIN_PODCAST_AUEXT_HTML);
                $propbag->add('description',    '');
                $propbag->add('default',        PLUGIN_PODCAST_MP3PLAYER);
                break;


            /* exotic */
            case 'use_cache':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_PODCAST_USECACHE);
                $propbag->add('description',    PLUGIN_PODCAST_USECACHE_DESC);
                $propbag->add('default',        'true');
                break;

            case 'itunes_meta':
                $propbag->add('type',           'text');
                $propbag->add('name',           PLUGIN_PODCAST_ITUNES);
                $propbag->add('description',    PLUGIN_PODCAST_ITUNES_DESC);
                $propbag->add('default',        " 

<itunes:subtitle>" . (function_exists('serendipity_specialchars') ? serendipity_specialchars($serendipity['blogTitle']) : htmlspecialchars($serendipity['blogTitle'], ENT_COMPAT, LANG_CHARSET)) . "</itunes:subtitle>
<itunes:author>" . (function_exists('serendipity_specialchars') ? serendipity_specialchars($serendipity['blogTitle']) : htmlspecialchars($serendipity['blogTitle'], ENT_COMPAT, LANG_CHARSET)) . "</itunes:author>
<itunes:summary>" . (function_exists('serendipity_specialchars') ? serendipity_specialchars($serendipity['blogDescription']) : htmlspecialchars($serendipity['blogDescription'], ENT_COMPAT, LANG_CHARSET)) . "</itunes:summary>
<itunes:image href=\"" . $serendipity['baseURL'] . "itunes.jpg\" />
<itunes:category text=\"Technology\" />                
                ");
                break;

            case 'plugin_http_path':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_PODCAST_HTTPREL);
                $propbag->add('description', PLUGIN_PODCAST_HTTPREL_DESC);
                $propbag->add('default', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_podcast');
                break;

        }

        return true;
    }
    
    function iTunify(&$eventData) {
        if (! array_key_exists('per_entry_display_dat', $eventData)) {
            $eventData['per_entry_display_dat'] = '';
        }
        $eventData['per_entry_display_dat'] .= '<itunes:author>' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($eventData['author']) : htmlspecialchars($eventData['author'], ENT_COMPAT, LANG_CHARSET)) . '</itunes:author>' . "\n";
        $eventData['per_entry_display_dat'] .= '<itunes:subtitle>' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($eventData['title']) : htmlspecialchars($eventData['title'], ENT_COMPAT, LANG_CHARSET)) . '</itunes:subtitle>' . "\n";
        $eventData['per_entry_display_dat'] .= '<itunes:summary>' . (function_exists('serendipity_specialchars') ? serendipity_specialchars(strip_tags($eventData['feed_body'])) : htmlspecialchars(strip_tags($eventData['feed_body']), ENT_COMPAT, LANG_CHARSET)) . '</itunes:summary>' . "\n";
    }

    /**
    @access public
    */
    function event_hook($event, &$bag, &$eventData, $addData = null){
        global $serendipity;
        static $use_player = null;
        static $firstmedia_only = null;
        static $patterns = null;
        
        $this->log("EventHook: " . $event);
        
        $this->InitializeSupportedFiletypes();
        
        if ($patterns == null) {
            //yes indeed, we wont find links like "download.php?file=rock.mp3&foo=bar"
            $patterns = array(
                //'mediaLinkPattern'      => '@href\s*=\s*(\'|")([^>]+\.(' . implode('|', array_keys($this->supportedFiletypes)) . '))\1@Usie',

                'playerRewritePattern'  => '@<a\s+[^>]*?href\s*=\s*(\'|")([^\'"]+\.('
                                           . implode('|', array_keys($this->supportedFiletypes))
                                           . '))\1[^>]*?>.*?</a>@si', //won't match nested tags, like <a .. <b>.. </b></a>. but that's ugly anyway.

                'embeddedObjectPattern' => '@<embed[^>]*?src="([^"]*?)"[^>]*?>@Usi',
                'podcastLinkPattern'    => '@\[podcast:\s*(href\s*=\s*)?((&quot;|\'|")(.+)(&quot;|\'|"))(\s+mediaType\s*=\s*(.+))?\]@Usi'
            );
        }
        
        if ($use_player === null) {
            $use_player = serendipity_db_bool($this->get_config('use_player', 'true'));
        }
        if ($firstmedia_only === null) {
            $firstmedia_only = serendipity_db_bool($this->get_config('firstmedia_only', 'false'));
        }

        switch ($event) {
            //////////////////////// Add Javascript for JW FLV Player ////////////////////////
            case 'frontend_header':
            case 'backend_header':
                echo '<script type="text/javascript" src="' . $this->GetPluginHttpPath() . '/player/flowplayer/example/flowplayer-3.2.6.min.js"></script>' . "\n";
                $this->log("Init\n--------------------------------------------------------------------------------------\n");
            break; 

            //////////////////////// RSS Entries ////////////////////////
            case 'frontend_display:rss-2.0:per_entry':
            case 'frontend_display:rss-1.0:per_entry':
            case 'frontend_display:atom-1.0:per_entry': 
                
                $this->log("Feed creation");
                $addedEnclosures[] = "enclosures";
                
                // Search for all embedded objects and make the RSS enclosured.
                // RSS only displays body always. In fullview, body contains body + extended here.
                // In "small" view only embed the media beeing part of the small view. 
                // In short: body only always!
                $matchSource = $eventData['body'];
                
                // Remove our own players first, they are matched using $eventData['podcastUrlsRewrittenByPlayerCode']
                $this->log("Removing podcast players");
                $eventData['feed_body'] = preg_replace(
                        '@<!-- podcastplayerstart -->.*?<!-- podcastplayerend -->@si',
                        '',
                        $eventData['feed_body']);
                
                // urls rewritten by player code
                $this->log("Matching URLs set by extended attributes. Isset=" . isset($eventData['podcastUrlsRewrittenByPlayerCode']));
                if (isset($eventData['podcastUrlsRewrittenByPlayerCode']) && is_array($eventData['podcastUrlsRewrittenByPlayerCode'])) {
                    $this->log("Matching URLs set by extended attributes: FOUND");
                    $urlsRewwrittenByPlayerCode = $eventData['podcastUrlsRewrittenByPlayerCode'];
                    foreach ($urlsRewwrittenByPlayerCode as $url) {
                        $fileInfo   = $this->GetFileInfo($url);
                        $type       = $fileInfo['mime'];
                        $enclosure = $this->GetEnclosure($event, $url, $type, $fileInfo['length'], $fileInfo['md5']);
                        
                        if (!empty($enclosure)) {
                            $this->iTunify($eventData, $enclosure);
                            if (empty($addedEnclosures[$enclosure])) {
                                $eventData['display_dat'] .= $enclosure;
                                if ($firstmedia_only) return true;
                            }
                            $addedEnclosures[$enclosure] = 1;
                        }
                    }
                }

                // match the Embed-Syntax added manualy by user
                $this->log("Matching embeddedObjectPattern");
                if (preg_match_all($patterns['embeddedObjectPattern'], $matchSource, $matches)) {
                    for ($i = 0, $maxi = count($matches[1]); $i < $maxi; $i++){
                        $url        = $matches[1][$i];
                        $fileInfo   = $this->GetFileInfo($url);
                        $type       = $fileInfo['mime'];
                        $enclosure = $this->GetEnclosure($event, $url, $type, $fileInfo['length'], $fileInfo['md5']);

                        if (!empty($enclosure)) {
                            $this->iTunify($eventData, $enclosure);
                            if (empty($addedEnclosures[$enclosure])) {
                                $eventData['display_dat'] .= $enclosure;
                                if ($firstmedia_only) return true;
                            }
                            $addedEnclosures[$enclosure] = 1;
                        }
                    }
                }
                
                // Match the old style [podcast] syntax as well
                $this->log("Matching podcastLinkPattern");
                if (preg_match_all($patterns['podcastLinkPattern'], $matchSource, $matches)) {
                    for ($i = 0, $maxi = count($matches[1]); $i < $maxi; $i++){
                        $url        = $matches[4][$i];
                        $fileInfo   = $this->GetFileInfo($url);
                        if (!empty($matches[7][$i])) {
                            $type   = $matches[7][$i];
                        } else {
                            $type   = $fileInfo['mime'];
                        }
                        $enclosure = $this->GetEnclosure($event, $url, $type, $fileInfo['length'], $fileInfo['md5']);

                        if (!empty($enclosure)) {
                            $this->iTunify($eventData, $enclosure);
                            if (empty($addedEnclosures[$enclosure])) {
                                $eventData['display_dat'] .= $enclosure;
                                if ($firstmedia_only) return true;
                            }
                            $addedEnclosures[$enclosure] = 1;
                        }
                    }
                }
                
                // Last, also match the '<a href>' style, if "use_player" is disabled and thus no <embed> might exist.
                $this->log("Matching playerRewritePattern");
                $nopodcasting_class = $this->get_config('nopodcasting_class','nopodcast');
                if (!empty($nopodcasting_class)) {
                    $classPattern = '@class\s*=\s*(\'|")\s*' . $nopodcasting_class . '\s*(\'|")+@si';
                }
                
                if (!$use_player && preg_match_all($patterns['playerRewritePattern'], $matchSource, $matches)) {
                    for ($i = 0, $maxi = count($matches[1]); $i < $maxi; $i++){
                        $complete   = $matches[0];
                        if (!empty($nopodcasting_class) && is_string($complete) && preg_match($classPattern, $complete)) {
                            $this->log("NoPodcasting class found!");
                            continue;
                        }
                        else {
                            $this->log("NoPodcasting class not found! [" . $classPattern . "]");
                        }
                        $url        = $matches[2][$i];
                        $fileInfo   = $this->GetFileInfo($url);
                        $type       = $fileInfo['mime'];
                        $enclosure	= $this->GetEnclosure($event, $url, $type, $fileInfo['length'], $fileInfo['md5']);

                        if (!empty($enclosure)) {
                            $this->iTunify($eventData, $enclosure);
                            if (empty($addedEnclosures[$enclosure])) {
                                $eventData['display_dat'] .= $enclosure;
                                if ($firstmedia_only) return true;
                            }
                            $addedEnclosures[$enclosure] = 1;
                        }
                    }
                }
                
                
                // Check, if podcasts are added via the extended article attribute and make it enclosured if not already embedded, too:
                if (serendipity_db_bool($this->get_config('ep_asure_enc', 'true'))) {
                    $extended_attributes = explode(',',$this->get_config('extendet_enclosure_attributes','Podcast,Video'));
                    
                    foreach ($extended_attributes as $eattr) {
                        $this->log("EP: " . trim($eattr));
                        $eattr = "ep_" . trim($eattr);
                        if (!empty($eattr) && !empty($eventData['properties'][$eattr])) {
                            $fileInfo = $this->GetFileInfo($eventData['properties'][$eattr]);
                            $type       = $fileInfo['mime'];
                            $fileUrl = str_replace(' ','%20',$eventData['properties'][$eattr]);
                            $enclosure = $this->GetEnclosure($event, $this->GetHostUrl() . (function_exists('serendipity_specialchars') ? serendipity_specialchars($fileUrl) : htmlspecialchars($fileUrl, ENT_COMPAT, LANG_CHARSET)), $type, $fileInfo['length'], $fileInfo['md5']);
                            
                            if (!empty($enclosure)) {
                                $this->iTunify($eventData, $enclosure);
                                if (empty($addedEnclosures[$enclosure])) {
                                    $eventData['display_dat'] .= $enclosure;
                                    if ($firstmedia_only) return true;
                                }
                                $addedEnclosures[$enclosure] = 1;
                            }
                        }
                    }
                }
                
                // A RSS feet doesn't need the object tags (they are embedded now). So remove them:
                $eventData['feed_body'] = preg_replace(
                        '@<object .*?</object>@si',
                        '',
                        $eventData['feed_body']);
                
                // Purely embedded objects are RSS enclosured now too, so we can remove them if still there:
                $eventData['feed_body'] = preg_replace(
                        '@<embed .*?</embed>@si',
                        '',
                        $eventData['feed_body']);
                 
                return true;
                
            case 'css':
                if (!strpos($eventData, '.podcastplayer')) {
                    echo '.podcastplayer { display: block; }' . "\n";
                    echo '.podcastdownload { display: block; }' . "\n";
                }
                return true;
            
            

            //////////////////////// RSS 1 NS /////////////////////////////
            case 'frontend_display:rss-1.0:namespace':

                $eventData['display_dat'] .= "   xmlns:enc='http://purl.oclc.org/net/rss_2.0/enc#'\n";
                $eventData['display_dat'] .= "   xmlns:podcast='http://ipodder.sourceforge.net/docs/podcast.html'\n";
                $eventData['display_dat'] .= "   xmlns:atom=\"http://www.w3.org/2005/Atom\"\n";
                $eventData['display_dat'] .= "   xmlns:sc=\"http://podlove.org/simple-chapters\"\n";

                return true;

            //////////////////////// RSS 2 NS///// ////////////////////////
            case 'frontend_display:rss-2.0:namespace':

                $eventData['display_dat'] .= "   xmlns:itunes=\"http://www.itunes.com/dtds/podcast-1.0.dtd\"\n";
                $eventData['display_dat'] .= "   xmlns:atom=\"http://www.w3.org/2005/Atom\"\n";
                $eventData['display_dat'] .= "   xmlns:sc=\"http://podlove.org/simple-chapters\"\n";

                
                if (version_compare(preg_replace('@[^0-9\.]@', '', $serendipity['version']), '1.6', '<')) {
                } else {
                  $eventData['channel_dat'] .= $this->get_config('itunes_meta');
                }
                //$eventData['display_dat'] .= "   xmlns:podcast='http://ipodder.sourceforge.net/docs/podcast.html'\n";
                return true;

            //////////////////////// HTML Entry /////////////////////////
            case 'frontend_display':
                
                if (!isset($eventData['body']) && !isset($eventData['extended'])) {
                    // Do not use player HTML for user comments, html nuggets, static pages etc.
                    return false;
                    break;
                }
                
                if (isset($eventData['properties']['ep_disable_markup'. $this->instance]) || isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                    // Do not use player HTML, when the extended properties plugin disables this markup plugin.
                    return false;
                    break;
                }
                
                // Reset URL list replaced by players
                $this->playerUrlsAdded = array();
                
                // First replace old style [podcast] syntax always, even without player replacement
                if (is_array($eventData)) {
                    if (preg_match($patterns['podcastLinkPattern'],$eventData['body'])) {
                        $eventData['body'] .= '<!-- old podcast style found -->';
                    }
                    $eventData['body'] = preg_replace(
                        $patterns['podcastLinkPattern'],
                        '<a href="\4">\4</a>',
                        $eventData['body']);

                    $eventData['extended'] = preg_replace(
                        $patterns['podcastLinkPattern'],
                        '<a href="\4">\4</a>',
                        $eventData['extended']);
                }
                
                // Now replace all links to mediafiles with the configured players: 
                if ($use_player && is_array($eventData)) {
                    $eventData['body'] = preg_replace_callback(
                        $patterns['playerRewritePattern'],
                        array( $this, "playerRewriteCallBack"),
                        $eventData['body']);

                    $eventData['extended'] = preg_replace_callback(
                        $patterns['playerRewritePattern'],
                        array( $this, "playerRewriteCallBack"),
                        $eventData['extended']);
                }
                

                // Check, if podcasts are added via the extended article attribute and add them to the article, if configured:
                if ($this->get_config('extendet_enclosure_position','never')!='never') {
                    $extended_attributes = explode(',',$this->get_config('extendet_enclosure_attributes','Podcast,Video'));
                    $extra_links = '';
                    foreach ($extended_attributes as $eattr) {
                        $eattr = "ep_" . trim($eattr);
                        $ep_align= $this->get_config('ep_align','center');
                        if (!empty($eattr) && !empty($eventData['properties'][$eattr])) {
                            $fileUrl = $this->GetHostUrl() . $eventData['properties'][$eattr];

                            $this->log("found input in $eattr: {$eventData['properties'][$eattr]}");
                            $this->log("fileurl in $eattr: $fileUrl");
                            
                            $fileInfo = $this->GetFileInfo($eventData['properties'][$eattr]);

                            $this->log("filinfo: " . print_r($fileInfo, true));

                            // Produce player code
                            if ($use_player) { 
                                if (serendipity_db_bool($this->get_config('ep_automatic_size', 'false'))) {
                                    $player = $this->GetPlayerByExt($fileInfo['extension'], $fileUrl, $fileInfo['width'],$fileInfo['height'], $ep_align, $fileInfo['mime']);
                                } else {
                                    $player = $this->GetPlayerByExt($fileInfo['extension'], $fileUrl, null, null, $ep_align, $fileInfo['mime']);
                                }
                            } else {
                                $player = '<a href="' . $fileUrl . '">' . basename($eventData['properties'][$eattr]) . '</a>';
                            } 
                            
                            $extra_links .= $player;
                        }
                    }
                    if (!empty($extra_links)) {
                        switch ($this->get_config('extendet_enclosure_position','never')) {
                            case 'body_top':
                                $eventData['body'] = $extra_links . $eventData['body'];
                                break;
                            case 'body_botton':
                                $eventData['body'] = $eventData['body'] . $extra_links;
                                break;
                            case 'ext_top':
                                $eventData['extended'] = $extra_links . $eventData['extended'];
                                break;
                            case 'ext_botton':
                                $eventData['extended'] = $eventData['extended'] . $extra_links;
                                break;
                            
                        }
                    }
                }

                // Remember media urls rewritten by player code for RSS feed.
                if (count($this->playerUrlsAdded)>0) {
                    $eventData['podcastUrlsRewrittenByPlayerCode'] = $this->playerUrlsAdded;
                }
                
                $this->cleanup_html5($eventData['body']);
                $this->cleanup_html5($eventData['extended']);
                
                break;

            default:
                return true;
        }
    }
    
    function cleanup_html5(&$input) {
        global $serendipity;
        static $mergemulti = null;
        
        if ($mergemulti === null) {
            $mergemulti = serendipity_db_bool($this->get_config('mergemulti'));
        }
        
        if ($mergemulti) {
            $pat = '@(<audio[^>]*>)(.+)(</audio>)@imsU';
            $aparts = array();
            if (preg_match_all($pat, $input, $m)) {
                $is_first = true;
                foreach($m[2] AS $idx => $part) {
                    $aparts[] = $part;
                    if (!$is_first) {
                        $input = str_replace($m[0][$idx], '', $input);
                    }
                    $is_first = false;
                }
                $input = preg_replace($pat, '\1 ' . implode("\n", $aparts) . ' \3', $input); 
            }

            $pat = '@(<video[^>]*>)(.+)(</video>)@imsU';
            $aparts = array();
            if (preg_match_all($pat, $input, $m)) {
                $is_first = true;
                foreach($m[2] AS $idx => $part) {
                    $aparts[] = $part;
                    if (!$is_first) {
                        $input = str_replace($m[0][$idx], '', $input);
                    }
                    $is_first = false;
                }
                $input = preg_replace($pat, '\1 ' . implode("\n", $aparts) . ' \3', $input); 
            }
        }
    }
    
    function playerRewriteCallBack($treffer) {
        global $serendipity;
        $this->log('playerRewriteCallBack: treffer=' . print_r($treffer,true));
        
        // Check for nopodcasting class
        $nopodcasting_class = $this->get_config('nopodcasting_class','nopodcast');
        if (!empty($nopodcasting_class)) {
            $classPattern = '@class\s*=\s*(\'|")\s*' . $nopodcasting_class . '\s*(\'|")+@si';
            if (preg_match($classPattern , $treffer[0])) return $treffer[0];
        }
        
        $fileUrl = $serendipity['baseURL']  . $treffer[2];
        if (serendipity_db_bool($this->get_config('automatic_size', 'false'))) {
            $fileInfo = $this->GetFileInfo($treffer[2]);
            return $this->GetPlayerByExt(strtolower($treffer[3]),$treffer[2], $fileInfo['width'], $fileInfo['height'], null, $fileInfo['mime']);
        } else {
            $fileInfo = $this->GetFileInfo($treffer[2]);
            return $this->GetPlayerByExt(strtolower($treffer[3]),$treffer[2], null, null, null, $fileInfo['mime']);
        }
    }
    
    /**
     * Produces an array for the podcast aligning configuration
     */
    function GetAlignOptionsArray() {
        return array(
            'left'      => PLUGIN_PODCAST_ALIGN_LEFT,
            'right'     => PLUGIN_PODCAST_ALIGN_RIGHT,
            'center'    => PLUGIN_PODCAST_ALIGN_CENTER,
            'noalign'   => PLUGIN_PODCAST_ALIGN_NONE,
        );

    }

    /**
     * Returns the Host including http(s)://
     */
    function GetHostUrl() {
        return (strtolower($_SERVER['HTTPS']) == 'on' ? 'https://' : 'http://') .  $_SERVER['HTTP_HOST'];
    }
    
    /**
     * Returns HTTP path of the podcast plugin
     */
    function GetPluginHttpPath() {
        return $this->get_config('plugin_http_path');
    }
    
    function getFileMime($ext, $fallback = '') {
        $this->log("getFileMime: $ext, $fallback");

        switch(strtolower($ext)) {
            case 'm4a':
                return 'audio/mp4';
            case 'm4v':
                return 'video/mp4';
            case 'ogg':
                return 'audio/ogg';
            case 'ogv':
                return 'video/ogg';
        }
        
        // fallback
        if (!empty($fallback)) return $fallback;
        
        return 'audio/' . $ext;
    }
    
    /**
     * Calculates infos on the given file and returns an array containing these infos
     */
    function GetFileInfo($url) {
        global $serendipity;

        $this->log("GetFileInfo for $url");
        
        $fileInfo = array();

        //caching metadata
        $cacheOptions = array(
            'lifeTime'               => '2592000',
            'automaticSerialization' => true,
            'cacheDir' => $serendipity['serendipityPath'] . 'templates_c/'
        );

        if (serendipity_db_bool($this->get_config('use_cache', 'true'))) {
            $this->log("GetFileInfo: Trying cached infos");

            //md5 for not having strange characters in that id..
            $cacheId = md5($url) . '.2';

            include_once(S9Y_PEAR_PATH . "Cache/Lite.php");

            $cache = new Cache_Lite($cacheOptions);
            if ($fileInfo = $cache->get($cacheId)){
                $this->log("GetFileInfo: Cached infos found in file $cacheId");
                //return directly on cache hit
                return $fileInfo;
            }
        }

        //cache miss! -> get data, store it in cache and return.

        // translate pontential relative url to absolute url
        if (preg_match('@https?://@', $url)) $absolute_url = $url;
        else $absolute_url = $this->GetHostUrl() . $url;
        
        if ($this->debug) $fileInfo['absolute_url'] = $absolute_url;
        
        // Now remove configured base URL
        $rel_path = str_replace($serendipity['baseURL'], "", $absolute_url);

        if ($this->debug) $fileInfo['rel_path'] = $rel_path;
        
        // do we have a local file here?
        //$localMediaFile = $serendipity['serendipityPath'] . $urlParts['path'];
        $localMediaFile = $serendipity['serendipityPath'] . $rel_path;

        $fileInfo['localMediaFile'] = $localMediaFile;

        $this->log("Absolute_url: $absolute_url - Relative: $localMediaFile");
        
        // Remember extension of file
        list($sName, $fileInfo['extension']) = serendipity_parseFileName($localMediaFile);
        
        if (file_exists($localMediaFile)) {
            $this->log("GetFileInfo: Local file exists");
            $fileInfo['length'] = filesize($localMediaFile);
            $fileInfo['md5'] = md5_file($localMediaFile);
            $this->GetID3Infos($localMediaFile, $fileInfo);
            $this->log(print_r($fileInfo,true));
            // Set default
            $fileInfo['mime'] = $this->getFileMime($fileInfo['extension'], $fileInfo['mime']);
        } 

        /*
        If not local: we have a problem :)
        We don't want to download an external file.
        First we have the problem of allow_url_fopen probably
        being disabled and then we can't load the entire file
        into memory, it would be too big anyway in most cases.
        So best we can do is trying to see if we can send a HTTP HEAD
        request and get the size that way (and MD5, if possible). Let's see if this works:
        */
        elseif (preg_match('@https?://@', $url)){

            $this->Log("Execute HTTP_Request for $url");

            if (function_exists('serendipity_request_url')) {
                $data = serendipity_request_url($url, 'HEAD');
                $header = $serendipity['last_http_request']['header'];
                $fileInfo['length'] = intval($header['content-length']);
                $fileInfo['md5']    = $header['content-md5']; //will return false if not present
                $fileInfo['mime']   = $header['content-type'];
                $this->Log("Filling MIME with HTTP Header: " . print_r($fileInfo, true));
            } else {
                include_once(S9Y_PEAR_PATH . 'HTTP/Request.php');
                if (function_exists('serendipity_request_start')) {
                    serendipity_request_start();
                }

                $http = new HTTP_Request($url);
                $http->setMethod(HTTP_REQUEST_METHOD_HEAD);

                if (!PEAR::isError($http->sendRequest(false))){
                    $fileInfo['length'] = intval($http->getResponseHeader('content-length'));
                    $fileInfo['md5']    = $http->getResponseHeader('content-md5'); //will return false if not present
                    $fileInfo['mime']   = $http->getResponseHeader('content-type');
                    $this->Log("Filling MIME with HTTP Header: " . print_r($fileInfo, true));
                }

                if (function_exists('serendipity_request_end')) {
                    serendipity_request_end();
                }
            }
        } else { // Not found locally and no URL
            $fileInfo['notfound'] = true;
        }
        
        if (serendipity_db_bool($this->get_config('use_cache', 'true'))) {
            $cache->save($fileInfo , $cacheId);
        }

        return $fileInfo;
    }

    function absolve($url) {
        global $serendipity;

        if (!preg_match('@^https*://@', $url)) {
            if ($url[0] == '/') {
                $url = $this->GetHostUrl() . $url;
            } else {
                $url = $this->getHostUrl() . $serendipity['serendipityHTTPPath'] . $url;
            }
        }
        
        return $url;
    }

    /**
     * Creates an enclosure tag for different feed types 
     */
    function GetEnclosure($event, $url, $type, $length = null, $md5 = null) {
        $url = str_replace(array('&',' '),array('&amp;','%20'),$url);
        $url = $this->absolve($url);
        
        preg_match('@^.*\.([^\.]+)$@imsU', $url, $ext);
        
        if (isset($_REQUEST['podcast_format'])) {
            $allowed = explode(',', $_REQUEST['podcast_format']);
            $is_allowed = false;
            foreach($allowed AS $allowed_ext) {
                if ($allowed_ext == $ext[1]) {
                    $is_allowed = true;
                }
            }
            
            if (!$is_allowed) {
                return false;
            }
        }

        switch($event) {
            case 'frontend_display:rss-2.0:per_entry':
                $enclosureAttrs = 'url="' . $url . '" type="' . $type . '" ';

                if (isset($length) && $length !== false && $length !== 0){
                    $enclosureAttrs .= "length='{$length}' ";
                }

                return "\n\t<enclosure $enclosureAttrs/>";

            case 'frontend_display:rss-1.0:per_entry':
                $enclosureElts = "<enc:url>$url</enc:url><enc:type>$type</enc:type>";

                // check due to HTTP_Request possibly returning false
                if (isset($length) && ($length !== false) && ($length !== 0)){
                    $enclosureElts .= "<enc:length>$length</enc:length>";
                }

                if (isset($md5) && ($md5 !== false)){
                    $enclosureElts .= "<podcast:enclosure_protection md5='{$md5}' />\n";
                }

                return "\n\t<enc:enclosure><enc:Enclosure>$enclosureElts</enc:Enclosure></enc:enclosure>";

            case 'frontend_display:atom-1.0:per_entry':
                return '<link rel="enclosure">'.$url.'</link>';
        }
    }


    /**
     * Determines the Mimetype using the getid3 functionality
     */
    function GetID3Infos($filename, &$fileInfoArray) {
        // Set default fileinformation:
        $fileInfoArray['mime'] = serendipity_guessMime($fileInfoArray['extension']);

        $this->log("GetID3Infos, Guessed mime: " . $fileInfoArray['mime']);
        $fileInfoArray['width']     = 0;
        $fileInfoArray['height']    = 0;

        // Try to find the getid3 library in the plugins bundled-libs first:
        if (file_exists(dirname(__FILE__) . '/player/james-heinrich/getid3/getid3/')) {
            @define('GETID3_INCLUDEPATH', dirname(__FILE__) . '/player/james-heinrich/getid3/getid3/');
        } elseif (file_exists(S9Y_INCLUDE_PATH . '/bundled-libs/getid3/getid3.lib.php')) {
            $this->log("GetID3Infos: include path " . S9Y_INCLUDE_PATH . '/bundled-libs/getid3/');
            @define('GETID3_INCLUDEPATH', S9Y_INCLUDE_PATH . '/bundled-libs/getid3/');
        } else if (file_exists(dirname(__FILE__) . '/getid3/getid3.lib.php')) {
            $this->log("GetID3Infos: include path " . dirname(__FILE__) . '/getid3/');
            @define('GETID3_INCLUDEPATH', dirname(__FILE__) . '/getid3/');
        } else {
            $this->log("GetID3Infos: GetID3 not found!");
            return false;
        }

        // include getID3() library (can be in a different directory if full path is specified)
        $this->log("GetID3Infos: including " . GETID3_INCLUDEPATH . 'getid3.php');
        require_once(GETID3_INCLUDEPATH . 'getid3.php');
        // Initialize getID3 engine
        $getID3 = new getID3;
        if (file_exists($filename)) {
            $id3 =$getID3->analyze($filename);
            getid3_lib::CopyTagsToComments($id3);
            if (isset($id3['error'])) {
                $fileInfoArray['id3error'] = $id3['error']; 
            } else {
                $this->log("ID3: " . print_r($id3,true));
                $mimeType                   = $id3['mime_type'];
                $fileInfoArray['mime']      = $mimeType;
                $fileInfoArray['width']     = $id3['video']['resolution_x'];
                $fileInfoArray['height']    = $id3['video']['resolution_y'];

                // Hack: ID3 gets wrong dimension on FLV files. Try to get another entry
                if ((int)$fileInfoArray['width']<1 && (int)$fileInfoArray['height']<1 && isset($id3['meta']['onMetaData']['height']) && isset($id3['meta']['onMetaData']['width'])) {
                    $fileInfoArray['width']     = $id3['meta']['onMetaData']['width'];
                    $fileInfoArray['height']    = $id3['meta']['onMetaData']['height'];
                }
            }
            
        } else {
            $fileInfoArray['mime'] 		= 'error/filenotfound';
            $this->log("File $filename not found");
        } 
    }
    
    /**
     * Evaluates a player by an extension. Returns the complete HTML code
     * 
     */
    function GetPlayerByExt($ext, $filename, $valwidth = null, $valheight = null, $valalign = null, $mime = null){
        static $downloadlink = null;
        
        if ($downloadlink === null) {
            $downloadlink = serendipity_db_bool($this->get_config('downloadlink'));
        }
        
        $this->playerUrlsAdded[] = $filename;
        
        $this->InitializeSupportedPlayers();
        if(!isset($this->supportedFiletypes[$ext])){
            return "\n<!-- unknown fileext: $ext ". count($this->supportedFiletypes) ." -->";
        }
        $short = $this->supportedFiletypes[$ext];
        
        if (!isset($this->supportedPlayers[$short])){
            return "<!-- no player for: " . $short. " -->";
        }
        $player = $this->supportedPlayers[$short];

        // Configure Player:
        // Add Height for controls
        if (isset($valheight) && $valheight >0) {
            if ($short == 'w') $valheight = $valheight + 43;
            else if ($short == 'q') $valheight = $valheight + 16;
            else if ($short == 'v') $valheight = $valheight + 20;
        }

        // Replace align, width and height attributes in players
        $width  = 'width="'  . ( isset($valwidth)  && $valwidth  > 0 ? $valwidth  : $this->get_config('width',  '200') ) . '"';
        $height = 'height="' . ( isset($valheight) && $valheight > 0 ? $valheight : $this->get_config('height', '200') ) . '"';
        $intwidth  = ( isset($valwidth)  && $valwidth  > 0 ? $valwidth  : $this->get_config('width',  '200') ) ;
        $intheight = ( isset($valheight) && $valheight > 0 ? $valheight : $this->get_config('height', '200') ) ;
        if ((isset($valalign))) {
            $align = ($valalign!='noalign'?'align="' . $valalign . '"':'');
        } else if  ($this->get_config('align','left') != 'noalign') {
            $align = 'align="' . $this->get_config('align', 'left') . '"';
        } else {
            $align = '';
        }
        
        $filename = str_replace(array(' '),array('%20'),$filename);
        $filename = $this->absolve($filename);
        $filename_noext = preg_replace('@\.'. $ext .'$@is','',$filename);
        
        if ($mime == null) {
            $mime = $this->getFileMime($ext);
        }
        
        $result = str_replace(
            array(
                '#url#', 
                '#url_noext#', 
                '#filename#', 
                '#htmlid#',
                '#width#', 
                '#height#', 
                '#intwidth#', 
                '#intheight#', 
                '#align#',
                '#plugin#',
                '#mime#'
            ), 
            
            array(
                $filename, 
                $filename_noext, 
                basename($filename), 
                md5($filename),
                $width, 
                $height, 
                $intwidth, 
                $intheight, 
                $align, 
                $this->GetPluginHttpPath(),
                $mime
            ), 
            $player
             );

        if ($downloadlink) {
            $result .= "\n<a href=\"" . $filename . "\" class=\"podcastdownload\">" . basename($filename) . "</a>\n";
        }
        
        return '<!-- podcastplayerstart -->' . $result . '<!-- podcastplayerend -->';
    }

    /**
     * Initializes the array holding extension -> playertype
     */
    function InitializeSupportedFiletypes() {

        if (!isset($this->supportedFiletypes)) {
            $this->supportedFiletypes = array();
            $qtexts     = explode(',', $this->get_config('extquicktime' ,PLUGIN_PODCAST_QTEXT_DEFAULT));
            $wmexts     = explode(',', $this->get_config('extwinmedia'  ,PLUGIN_PODCAST_WMEXT_DEFAULT));
            $flexts     = explode(',', $this->get_config('extflash'     ,PLUGIN_PODCAST_MFEXT_DEFAULT));
            $mp3exts    = explode(',', $this->get_config('extaudio'     ,PLUGIN_PODCAST_AUEXT_DEFAULT));
            $xspfexts   = explode(',', $this->get_config('extxspf'      ,PLUGIN_PODCAST_XSPFEXT_DEFAULT));
            $flvexts    = explode(',', $this->get_config('extflow'      ,PLUGIN_PODCAST_FLOWEXT_DEFAULT));
            $a5exts     = explode(',', $this->get_config('exthtml5_audio',PLUGIN_PODCAST_HTML5_AUDIO_DEFAULT));
            $v5exts     = explode(',', $this->get_config('exthtml5_video',PLUGIN_PODCAST_HTML5_VIDEO_DEFAULT));

            foreach($qtexts as $ext){
                $this->supportedFiletypes[trim($ext)] = 'q'; 
            }
            foreach($wmexts as $ext){
                $this->supportedFiletypes[trim($ext)] = 'w'; 
            }
            foreach($flexts as $ext){
                $this->supportedFiletypes[trim($ext)] = 'f'; 
            }
            foreach($mp3exts as $ext){
                $this->supportedFiletypes[trim($ext)] = 'm'; 
            }
            foreach($xspfexts as $ext){
                $this->supportedFiletypes[trim($ext)] = 'x'; 
            }
            foreach($flvexts as $ext){
                $this->supportedFiletypes[trim($ext)] = 'v'; 
            }
            foreach($a5exts as $ext){
                $this->supportedFiletypes[trim($ext)] = 'a5'; 
            }
            foreach($v5exts as $ext){
                $this->supportedFiletypes[trim($ext)] = 'v5'; 
            }

        }
    }
    
    /**
     * Initializes the array holding playertype -> player HTML code
     */
    function InitializeSupportedPlayers(){

        if (!isset($this->supportedPlayers)){
            $this->supportedPlayers = array(
                'q'  => $this->get_config('extquicktime_player', PLUGIN_PODCAST_QUICKTIMEPLAYER),
                'w'  => $this->get_config('extwinmedia_player', PLUGIN_PODCAST_WMPLAYER),
                'f'  => $this->get_config('extflash_player', PLUGIN_PODCAST_FLASHPLAYER),
                'x'  => $this->get_config('extxspf_player', PLUGIN_PODCAST_XSPFPLAYER),
                'm'  => $this->get_config('extaudio_player', PLUGIN_PODCAST_MP3PLAYER),
                'v'  => $this->get_config('extflow_player', PLUGIN_PODCAST_FLOWPLAYER),
                'a5' => $this->get_config('exthtml5_audio_player', PLUGIN_PODCAST_HTML5_AUDIOPLAYER),
                'v5' => $this->get_config('exthtml5_video_player', PLUGIN_PODCAST_HTML5_VIDEOPLAYER),
            );
        }
    }
    function log($message){
        global $serendipity;
        
        if (!$this->debug) return;
        $fp = fopen($serendipity['serendipityPath'] . PATH_SMARTY_COMPILE . '/serendipity_event_podcast' . '.log','a');
        fwrite($fp, date("d.m.Y H:i") . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['REMOTE_ADDR'] . " - " . $message . "\n");
        fclose($fp);
    }
    
}
