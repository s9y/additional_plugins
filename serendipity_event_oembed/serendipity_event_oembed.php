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
//            'backend_publish'   => true,    // An entry was puplished (was draft before or saved from the scratch).
//            'backend_save'      => true,    // An entry was saved.
            'frontend_display'  => true,
        ));

        $propbag->add('configuration', array('info'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'info':
                $propbag->add('type',           'content');
                $propbag->add('default',        sprintf(PLUGIN_EVENT_OEMBED_INFO, ProviderList::ul_providernames(true)));
                break;
        }
    }

    function event_hook($event, &$bag, &$eventData) {
        global $serendipity;
        
        static $simplePatterns = null;
        
        if ($simplePatterns==null) {
            $simplePatterns = array(
                //'simpleTweet' => '@\(tweet\s+(\S*)\)@Usi',
                'simpleTweet' => '@\[(?:e|embed|tweet)\s+(.*)\]@Usi',
            );
        }
        
        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_display':
                case 'backend_publish':
                case 'backend_save':
                    if (!isset($eventData['body']) && !isset($eventData['extended'])) {
                        // Do not use for user comments, html nuggets, static pages etc.
                        return false;
                        break;
                    }
                    $this->update_entry($eventData, $simplePatterns);
                    return true;
            }
        }
        
        return true;
        
    }

    function update_entry(&$eventData, &$patterns) {
        if (!empty($eventData['body'])) {
            $eventData['body'] = preg_replace_callback(
                $patterns['simpleTweet'],
                array( $this, "oembedRewriteCallback"),
                $eventData['body']);
        }
        if (!empty($eventData['extended'])) {
            $eventData['extended'] = preg_replace_callback(
                $patterns['simpleTweet'],
                array( $this, "oembedRewriteCallback"),
                $eventData['extended']);
        }
    }
    
    function oembedRewriteCallback($match) {
        $url = $match[1];
        $obj = OEmbedDatabase::load_oembed($url);
        $html = '';
        if (empty($obj)) {
            $manager = ProviderManager::getInstance();
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
        return OEmbedTemplater::fetchTemplate('oembed.tpl',$obj, $url);
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
    }
    function install() {
        OEmbedDatabase::install($this);
    }
    
}