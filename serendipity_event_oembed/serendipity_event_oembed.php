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
require_once dirname(__FILE__) . '/oembed/config.php'; // autoload oembed classes
require_once dirname(__FILE__) . '/OEmbedDatabase.php';


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
                $propbag->add('default',        "Info");
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
            $eventData['body'] = preg_replace_callback(
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
                    OEmbedDatabase::save_oembed($url,$obj);
                }
            }
            catch (ErrorException $e) {
                print "Loading online url ex $e ..\n";
                // Timeout in most cases
                return $e;
            }
        }
	    if (!empty($obj)) {
	        if ($obj->type == 'rich') 
	            $html = $obj->html;
	        elseif ($obj->type == 'video') 
	            $html = $obj->html;
	        elseif ($obj->type == 'photo') {
	            $html = '<img src="' . $obj->url . '" title="' .$obj->title  . '" alt="' .$obj->title . '"/>';
	        }
	    }
	    else {
        	$html = '<a href="' . $match[1] . '">' . $match[1] . '</a>';
	    }
	    return '<span class="serendipity_oembed">' . $html . '</span>';
    }
    
    function cleanup() {
        OEmbedDatabase::install($this);
    }
    function install() {
        OEmbedDatabase::install($this);
    }
    
}