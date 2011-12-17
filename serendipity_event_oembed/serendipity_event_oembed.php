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
        $propbag->add('version',       '0.01');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '5.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
        $propbag->add('event_hooks',    array(
            'frontend_display'  => true,
        ));
        $configuration = $configuration = array('info','maxwidth','maxheight');
        $propbag->add('configuration', $configuration);
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
        }
        return true;
    }

    function event_hook($event, &$bag, &$eventData) {
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
            $manager = ProviderManager::getInstance($maxwidth,$maxheight);
            try {
                $obj=$manager->provide($url,"object");
                if (isset($obj)) {
                    $obj = OEmbedDatabase::save_oembed($url,$obj);
                }
            }
            catch (ErrorException $e) {
                // Timeout in most cases
                //return $e;
            }
        }
        return $obj;
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