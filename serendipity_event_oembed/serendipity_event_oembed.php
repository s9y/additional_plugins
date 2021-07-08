<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

require_once dirname(__FILE__) . '/oembed/config.php';    // autoload oembed classes and config
require_once dirname(__FILE__) . '/OEmbedDatabase.php';
require_once dirname(__FILE__) . '/OEmbedTemplater.php';
require_once dirname(__FILE__) . '/oembed/ProviderList.php';

@define('OEMBED_USE_CURL',TRUE);

class serendipity_event_oembed extends serendipity_event
{
    var $title = PLUGIN_EVENT_OEMBED_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_OEMBED_NAME);
        $propbag->add('description',   PLUGIN_EVENT_OEMBED_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Grischa Brockhaus');
        $propbag->add('version',       '1.20');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '5.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
        $propbag->add('event_hooks',    array(
            'frontend_display'  => true,
            'css'               => true,
        ));
        $configuration = $configuration = array('info','maxwidth','maxheight','generic_service','embedly_apikey', 'audioboo_player');
        $configuration[] = 'supported'; // always last
        $propbag->add('configuration', $configuration);

        $propbag->add('legal',    array(
            'services' => array(
                'oEmbed' => array(
                    'url'  => '#',
                    'desc' => 'oEmbed providers will receive visitor metadata (IP, User Agent, etc) when embedded content is loaded'
                ),
            ),
            'frontend' => array(
                'oEmbed providers will receive visitor metadata (IP, User Agent, etc) when embedded content is loaded'
            ),
            'backend' => array(
            ),
            'cookies' => array(
                'oEmbed providers might set cookies for tracking purposes of embedded content'
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => true,
            'transmits_user_input'  => true
        ));

    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'info':
                $propbag->add('type',           'content');
                $propbag->add('default',        sprintf(PLUGIN_EVENT_OEMBED_INFO, ProviderList::ul_providernames(true)));
                break;
            case 'maxwidth':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_OEMBED_MAXWIDTH);
                $propbag->add('description',    PLUGIN_EVENT_OEMBED_MAXWIDTH_DESC);
                $propbag->add('default',        '');
                break;
            case 'maxheight':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_OEMBED_MAXHEIGHT);
                $propbag->add('description',    PLUGIN_EVENT_OEMBED_MAXHEIGHT_DESC);
                $propbag->add('default',        '');
                break;
            case 'generic_service':
                $generic_services = array (
                    'none'       => PLUGIN_EVENT_OEMBED_SERVICE_NONE,
                    'embedly'    => PLUGIN_EVENT_OEMBED_SERVICE_EMBEDLY,
                );
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_OEMBED_GENERIC_SERVICE);
                $propbag->add('description',    PLUGIN_EVENT_OEMBED_GENERIC_SERVICE_DESC);
                $propbag->add('select_values',  $generic_services);
                $propbag->add('default',        'none');
                break;
            case 'audioboo_player':
                $player_boo = array (
                    'standard'       => PLUGIN_EVENT_OEMBED_PLAYER_BOO_STANDARD,
                    'fullfeatured'   => PLUGIN_EVENT_OEMBED_PLAYER_BOO_FULLFEATURED,
                );
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_OEMBED_PLAYER_BOO);
                $propbag->add('description',    PLUGIN_EVENT_OEMBED_PLAYER_BOO_DESC);
                $propbag->add('select_values',  $player_boo);
                $propbag->add('default',        'standard');
                break;
            case 'embedly_apikey':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_OEMBED_EMBEDLY_APIKEY);
                $propbag->add('description',    PLUGIN_EVENT_OEMBED_EMBEDLY_APIKEY_DESC);
                $propbag->add('default',        '');
                break;
            case 'supported':
                $propbag->add('type',           'content');
                $propbag->add('default',        sprintf(PLUGIN_EVENT_OEMBED_SUPPORTED, ProviderList::ul_providernames(true)));
                break;
        }
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) { 
        global $serendipity;
        
        static $simplePatterns = null;
        
        if ($simplePatterns==null) {
            $simplePatterns = array(
                //'simpleTweet' => '@\(tweet\s+(\S*)\)@Usi',
                'simpleTweet' => '@\[(?:e|embed)\s+(.*)\]@Usi',
            );
        }
        
        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_display':
                    if (isset($eventData['body']) && isset($eventData['extended'])) {
                        $this->update_entry($eventData, $simplePatterns, 'body');
                        $this->update_entry($eventData, $simplePatterns, 'extended');
                    }
                    return true;
                case 'css':
                    if (strpos($eventData, '.serendipity_oembed')) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        // (doesn't work with templates like BP or 2k11 as the user css is loaded from a seperate file)
                        return true;
                    }
?>
.serendipity_oembed_video {
    position: relative;
    padding-top: 25px;
    padding-bottom: 67.5%;
    height: 0;
    margin-bottom: 16px;
    overflow: hidden;
}

.serendipity_oembed_video iframe,
.serendipity_oembed_video object {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
<?php
                    return true;
            }
        }
        
        return true;
        
    }

    function update_entry(&$eventData, &$patterns, $dateType) {
        if (!empty($eventData[$dateType])) {
            $eventData[$dateType] = preg_replace_callback(
                $patterns['simpleTweet'],
                array( $this, "oembedRewriteCallback"),
                $eventData[$dateType]);
        }
    }
    
    function oembedRewriteCallback($match) {
        $url = $match[1];
        $maxwidth = $this->get_config('maxwidth','');
        $maxheight = $this->get_config('maxheight','');
        $obj = $this->expand($url, $maxwidth, $maxheight);
        return OEmbedTemplater::fetchTemplate('oembed.tpl',$obj, $url);
    }
    
    /**
     * This method can be used by other plugins. It will expand an URL to an oembed object (or null if not supported).
     * @param string $url The url to be expanded
     * @param string $maxwidth Maximum width of returned object (if service supports this). May be left empty
     * @param string $maxheight Maximum height of returned object (if service supports this). May be left empty
     * @return OEmbed or null
     */
    function expand($url, $maxwidth=null, $maxheight=null) {
        $obj = OEmbedDatabase::load_oembed($url);
        if (empty($obj)) {
            $config = array('audioboo_tpl' => $this->get_config('audioboo_player', 'wordpress'));
            $manager = ProviderManager::getInstance($maxwidth,$maxheight,$config);
            try {
                $obj=$manager->provide($url,"object");
                if (isset($obj)) {
                    if (!empty($obj->error)) $obj=null; 
                }
                if (!isset($obj)) {
                    $obj = $this->expand_by_general_provider($url,$maxwidth,$maxheight);
                    if (isset($obj)) {
                        if (!empty($obj->error)) $obj=null; 
                    }
                }
                if (isset($obj)) {
                    $obj = OEmbedDatabase::save_oembed($url,$obj);
                }
            }
            catch (ErrorException $e) {
                // Timeout in most cases
                //return $e;
                //print_r($e);
            }
        }
        return $obj;
    }
    
    function expand_by_general_provider($url, $maxwidth=null, $maxheight=null) {
        $provider = $this->get_config('generic_service', 'none');
        $manager = null;
        if ('embedly' == $provider) {
            $apikey = $this->get_config('embedly_apikey', '');
            if (!empty($apikey)) {
                require_once dirname(__FILE__) . '/oembed/EmbedlyProvider.class.php';
                $manager = new EmbedlyProvider($url, $apikey, $maxwidth, $maxheight);
            } 
        }
        
        if (isset($manager)) {
            try {
                $obj = $manager->provide($url,'object');
                if (isset($obj)) {
                    if (!empty($obj->error)) $obj=null; 
                }
                return $obj;
            } catch (Exception $e) {
                return null;
            }
        }
        else {
            return null;
        }
    }
    
    function cleanup_html( $str ) {
        // Clear unicode stuff 
        $str=str_ireplace("\u003C","<",$str);
        $str=str_ireplace("\u003E",">",$str);
        // Clear CDATA Trash.
        $str = preg_replace("@^<!\[CDATA\[(.*)]]>$@", '$1', $str);
        $str = preg_replace("@^<!\[CDATA\[(.*)$@", '$1', $str);
        $str = preg_replace("@(.*)]]>$@", '$1', $str);
        return $str;
    }
    function cleanup() {
        OEmbedDatabase::install($this);
        OEmbedDatabase::clear_cache();
        echo '<div class="serendipityAdminMsgSuccess">Cleared oembed cache.</div>';
    }
    function install() {
        OEmbedDatabase::install($this);
    }
    
}
