<?php # $Id$

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_autotitle extends serendipity_event
{
    var $title = PLUGIN_EVENT_AUTOTITLE_NAME;
    var $cache = null;
    var $cache_group = 'serendipity_autotitle';
    var $cache_key = '';

    var $page_charset;

    function introspect(&$propbag)
    {
        global $serendipity;
        

        $propbag->add('name',          PLUGIN_EVENT_AUTOTITLE_NAME);
        $propbag->add('description',   PLUGIN_EVENT_AUTOTITLE_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Malte Paskuda');
        $propbag->add('version',       '0.1.10');
        $propbag->add('requirements',  array(
            'php'         => '4.1.0'
        ));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',   array('frontend_display' => true));
        $propbag->add('groups', array('MARKUP'));

        $this->markup_elements = array(
            array(
              'name'     => 'ENTRY_BODY',
              'element'  => 'body',
            ),
            array(
              'name'     => 'EXTENDED_BODY',
              'element'  => 'extended',
            ),
            array(
              'name'     => 'COMMENT',
              'element'  => 'comment',
            ),
            array(
              'name'     => 'HTML_NUGGET',
              'element'  => 'html_nugget',
            )
        );

        $conf_array = array('fetchlimit');
        foreach($this->markup_elements as $element) {
            $conf_array[] = $element['name'];
        }
        $propbag->add('configuration', $conf_array);
    }

    function install() {
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function uninstall(&$propbag) {
        serendipity_plugin_api::hook_event('backend_cache_purge', $this->title);
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'fetchlimit':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_AUTOTITLE_FETCHLIMIT);
                $propbag->add('description', PLUGIN_EVENT_AUTOTITLE_FETCHLIMIT_DESC);
                $propbag->add('default', '4');
                break;

            default:
                $propbag->add('type',        'boolean');
                $propbag->add('name',        constant($name));
                $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
                $propbag->add('default', 'true');
        }
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
              case 'frontend_display':
                foreach ($this->markup_elements as $temp) {
                    if (serendipity_db_bool($this->get_config($temp['name'], true)) && isset($eventData[$temp['element']]) &&
                            !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                            !in_array($this->instance, (array)$serendipity['POST']['properties']['disable_markups'])) {

                        @include_once 'Cache/Lite.php';

                        if (!class_exists('Cache_Lite')) {
                            $this->debugMsg('Cache_Lite not available.');
                            return false;
                        }

                        $options = array(
                            'cacheDir' => $serendipity['serendipityPath'] . 'templates_c/',
                            'lifeTime' => 604800, //one week
                            'hashedDirectoryLevel' => 2,
                            'automaticCleaningFactor' => 200
                        );

                        $this->cache = new Cache_Lite($options);

                        $element = $temp['element'];
                        $eventData[$element] = $this->autotitle($eventData[$element]);
                    }
                }
                return true;
                break;

              default:
                return false;
            }

        } else {
            return false;
        }
    }

    /**
     *  Get the title-tag of every linked site
     *  */
    function autotitle($text) {
        global $serendipity;

        //get all links
        preg_match_all('|<a (.*?)\">|is', $text, $links);
        //links could exist twice in links-array
        $links = array_unique($links[1]);
        $offset = 0;
        
        while (true) {
            preg_match('|<a (.*?)\">|is', $text, $links, 
                            PREG_OFFSET_CAPTURE, $offset);

            if (empty($links[0])) {
                break;
            } else {
                $link = $links[1][0];
                $offset = $links[1][1] + 1;
            }

            //ignore this link if title already set
            if (strpos($link, 'title=') !== false) {
                continue;
            }
            
            //if href is alone, last " is missing
            if (substr($link, strlen($link), 1) != '"') {
                $link = $link .'"';
            }
            //grab the real url
            preg_match('|href="([^\"]*?)"|is', $link, $url);
            $url = $url[1];
            
            //prepare cache:
        	$this->cache->_setFileName($url, $this->cache_group);
            //check cache:
            $title = $this->get_cached_title($url);
            if ($title === false) {
            	//$page = a maximum of the first 4kb of the linked site
                $page = $this->getPage($url);
                //fetch everything between <title>, only one is allowed
                preg_match('|<title>([^<]*?)</title>|is', $page, $title);
                $page_charset = $this->getCharset($page);

                //we need smarty to get our own charset :/
                if (!is_object($serendipity['smarty'])) {
                    serendipity_smarty_init();
                }
                $own_charset = $serendipity['smarty']->get_template_vars('head_charset');

                //remove newlines to prevent issues with inserted brs by nl2br or textile
                //1. Standardize line endings:
	            //   DOS to Unix and Mac to Unix
                $title = str_replace(array("\r\n", "\r"), "\n", $title[1]);
                //2. remove nl, also \t because it looks like crap
                $title = str_replace(array("\n", "\t"), '', $title);
                
                //escape and convert to prevent encoding-errors
                $title = htmlspecialchars(
                        iconv("$page_charset", "$own_charset//TRANSLIT", $title)
                        , ENT_COMPAT, $own_charset, false);
                
                $this->cache_title($url, $title);
            }
            //insert title in links
            $titled_link = "$link title=\"$title\"";
            //strip text in two parts at the linkposition so str_replace
            //wont insert the link which have a title, but have this link
            //as a part (e.g. <a href=".*">, <a href=".*" class="x">
            $firstPart = substr($text, 0, $offset-5);
            $secondPart = substr($text, $offset-5);
            $secondPart = str_replace("<a $link", "<a $titled_link", $secondPart);
            $text =  $firstPart . $secondPart;
            
         }
         return $text;
    }

    function getPage($url) {
        $fetchlimit = $this->get_config('fetchlimit', 4);
        if(is_int($fetchlimit)) {
            $fetchlimit = $fetchlimit * 1024;
        } else {
            $fetchlimit = 4096;
        }
        $page = @file_get_contents($url, 0, null, -1, $fetchlimit);
        if (empty($page)) {
            //try it again with curl if fopen was forbidden
            if (function_exists('curl_init')) {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_RANGE, "0-$fetchlimits");
                //the range isn't properly working. So the timeout shall hinder the worst
                //that's why curl is not the default
                curl_setopt($ch, CURLOPT_TIMEOUT, "20");
                $page = curl_exec($ch);
                curl_close($ch);
            } 
        }
        return $page;
    }

    function getCharset($page) {
        preg_match( '@<meta\s+http-equiv="Content-Type"\s+content="([\w/]+)(;\s+charset=([^\s"]+))?@i',
    $page, $matches );
        if (isset($matches[3])) {
            return $matches[3];
        } else {
            return 'UTF-8';
        }
    }

    function get_cached_title($url) {
    	return $this->cache->get($url, $this->cache_group);
    }

    function cache_title($url, $title) {
        return $this->cache->save($title, $url, $this->cache_group);
    }

    function debugMsg($msg) {
		global $serendipity;
		
		$this->debug_fp = @fopen ( $serendipity ['serendipityPath'] . 'templates_c/autotitle.log', 'a' );
		if (! $this->debug_fp) {
			return false;
		}
		
		if (empty ( $msg )) {
			fwrite ( $this->debug_fp, "failure \n" );
		} else {
			fwrite ( $this->debug_fp, print_r ( $msg, true ) );
		}
		fclose ( $this->debug_fp );
	}
}

/* vim: set sts=4 ts=4 expandtab : */
