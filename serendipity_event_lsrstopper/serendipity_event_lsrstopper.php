<?php

@serendipity_plugin_api::load_language(dirname(__FILE__));

/**
 * Class serendipity_event_lsrstopper
 *
 * @author Matthias Gutjahr <mattsches@gmail.com>
 */
class serendipity_event_lsrstopper extends serendipity_event
{
    /**
     * @const string
     */
    const PREPEND_URL = 'http://leistungsschutzrecht-stoppen.d-64.org/blacklisted/?url=';

    /**
     * @const int
     */
    const CACHE_TTL = 86400; // 1 day

    /**
     * @var string
     */
    public $title = PLUGIN_EVENT_LSRSTOPPER_NAME;

    /**
     * @var array
     */
    protected $markupElements;

    /**
     * @param serendipity_property_bag $propbag
     * @return void
     */
    public function introspect(&$propbag)
    {
        $propbag->add('name',          PLUGIN_EVENT_LSRSTOPPER_NAME);
        $propbag->add('description',   PLUGIN_EVENT_LSRSTOPPER_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Matthias Gutjahr');
        $propbag->add('version',       '0.3');
        $propbag->add('requirements',  array(
            'serendipity' => '1.6',
            'smarty'      => '2.6.7',
            'php'         => '5.2'
        ));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',   array('frontend_display' => true, 'frontend_comment' => true));
        $propbag->add('groups', array('MARKUP'));
        $this->markupElements = array(
            array(
              'name'     => 'ENTRY_BODY',
              'element'  => 'body',
            ),
            array(
              'name'     => 'EXTENDED_BODY',
              'element'  => 'extended',
            ),
        );
        $confArray = array(
            'use_blacklist',
            'blacklist_url',
        );
        foreach($this->markupElements as $element) {
            $confArray[] = $element['name'];
        }
        $propbag->add('configuration', $confArray);
    }

    /**
     * @param string $title
     * @return void
     */
    public function generate_content(&$title)
    {
        $title = $this->title;
    }

    /**
     * @param string $name
     * @param serendipity_property_bag $propbag
     * @return bool
     */
    public function introspect_config_item($name, &$propbag)
    {
        switch ($name) {
            case 'use_blacklist':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_LSRSTOPPER_USE_BLACKLIST_NAME);
                $propbag->add('description', PLUGIN_EVENT_LSRSTOPPER_USE_BLACKLIST_DESC);
                $propbag->add('default',     'true');
                break;
            case 'blacklist_url':
                $propbag->add('type',        'hidden');
                $propbag->add('name',        'blacklist_url');
                $propbag->add('description', 'blacklist_url');
                $propbag->add('default',     'http://leistungsschutzrecht-stoppen.d-64.org/blacklist.txt');
                break;
            default:
                $propbag->add('type',        'boolean');
                $propbag->add('name',        constant($name));
                $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
                $propbag->add('default',     'true');
                break;
        }
        return true;
    }

    /**
     * @param string $event
     * @param serendipity_property_bag $bag
     * @param array $eventData
     * @param null $addData
     * @return bool
     */
    public function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        if (!class_exists("simple_html_dom") || !function_exists("str_get_html")) {
            require_once dirname(__FILE__) . '/libs/simple_html_dom.php';
        }
        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_display':
                    $blacklist = $this->getBlacklist();
                    foreach ($this->markupElements as $temp) {
                        $element = $temp['element'];
                        if ($blacklist === null) {
                            $eventData[$element] = $this->getDnsBlacklisted($eventData[$element]);
                        } else {
                            $eventData[$element] = $this->d64_lsr_check($blacklist, $eventData[$element]);
                        }
                    }
                    return true;
                    break;
                default:
                    return false;
            }
        }
        return false;
    }

    /**
     * Gets the current blacklist from a remote server.
     *
     * @return mixed|null|string
     */
    protected function getBlacklist()
    {
        if ($this->get_config('use_blacklist') == false) {
            return null;
        }
        if (!$this->isUrl($this->get_config('blacklist_url')) && file_exists($this->get_config('blacklist_url'))) {
            // local file
            $blacklist = file_get_contents($this->get_config('blacklist_url'));
            return $blacklist;
        }
        $blacklist = $this->readCache();
        if ($blacklist === null) {
            require_once (defined('S9Y_PEAR_PATH') ? S9Y_PEAR_PATH : S9Y_INCLUDE_PATH . 'bundled-libs/') . 'HTTP/Request.php';
            $req = new HTTP_Request($this->get_config('blacklist_url'), array('allowRedirects' => true, 'maxRedirects' => 3));
            if (PEAR::isError($req->sendRequest()) || $req->getResponseCode() != '200') {
                return null;
            }
            $blacklist = $req->getResponseBody();
            $this->writeCache($blacklist);
        }
        return $blacklist;
    }

    /**
     * Check if blacklisted via DNS, see http://dentaku.wazong.de/2013/03/01/lsrdnsbl/
     *
     * @param string $string
     * @return mixed
     */
    protected function getDnsBlacklisted($string)
    {
        $dom = str_get_html($string);
        foreach ($dom->find('a') as $element) {
            if (filter_var($element->href, FILTER_VALIDATE_URL) == false || substr($element->href, 0, 4) != 'http') {
                continue;
            }
            $parts = parse_url($element->href);
            $domain = $parts['host'];
            if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $matches)) {
                $domain = $matches['domain'];
            }
            $ip = gethostbyname(strtolower($domain) . '.lsrbl.wazong.de');
            if (substr($ip, -1) == '2') {
                $element->href = self::PREPEND_URL . base64_encode($element->href);
            }
        }
        return $dom->save();
    }

    /**
     * Reads the blacklist from the cache.
     *
     * @return null|string
     */
    protected function readCache()
    {
        $filename = $this->getCacheFilename($this->get_config('blacklist_url'));
        if (file_exists($filename) && (time() - filemtime($filename)) < self::CACHE_TTL) {
            $fp = fopen($filename, 'rb');
            $result = fread($fp, filesize($filename));
            fclose($fp);
            return $result;
        }
        return null;
    }

    /**
     * Writes the blacklist to the cache.
     *
     * @param $blacklist
     */
    protected function writeCache($blacklist)
    {
        $filename = $this->getCacheFilename($this->get_config('blacklist_url'));
        $cache_dir = dirname($filename);
        if (!is_dir($cache_dir)) {
            mkdir($cache_dir);
        }
        $fp = fopen($filename, 'wb');
        fwrite($fp, $blacklist);
        fclose($fp);
    }

    /**
     * Gets the path to the cache file.
     *
     * @param $url
     * @return string
     */
    protected function getCacheFilename($url)
    {
        global $serendipity;
        return $serendipity['serendipityPath'] . '/' . PATH_SMARTY_COMPILE . '/lsrstopper/' . md5($url);
    }

    /**
     * Searches the entry body for links to evil media and replaces them ;-)
     * @see https://github.com/gglnx/d64-lsr-stopper
     *
     * @param string $list
     * @param string $string
     * @return string
     */
    protected function d64_lsr_check($list, $string)
    {
        $blacklist = new stdClass();
        $blacklist->sites = array_filter(array_map('trim', explode(",", $list)));
        $blacklist->sites = array_filter(array_map('trim', $blacklist->sites));
    	if (!is_array($blacklist->sites) || count($blacklist->sites) == 0) {
            return $string;
        }
    	$dom = str_get_html($string);
    	$regex = "^(" . implode( "|", $blacklist->sites ) . ")^";
    	foreach ($dom->find('a') as $element) {
    		if (filter_var($element->href, FILTER_VALIDATE_URL) == false || substr($element->href, 0, 4) != 'http') {
    			continue;
            }
    		$parts = parse_url($element->href);
    		if (preg_match( $regex, strtolower($parts["host"]))) {
    			$element->href = self::PREPEND_URL . base64_encode($element->href);
            }
        }
    	return $dom->save();
    }

    /**
     * Test if a string is a valid URL
     *
     * @param string $url
     * @return boolean
     */
    protected function isUrl($url)
    {
    	return filter_var($url, FILTER_VALIDATE_URL);
    }
}
