<?php # 

/** We reuse most of that code and language constants, so include this before we
    do anything else */
include_once $serendipity['serendipityPath'] . 'plugins/serendipity_plugin_remoterss/serendipity_plugin_remoterss.php';

// Probe for a language include with constants. Still include defines later on, if some constants were missing

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_backendrss extends serendipity_event
{
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_BACKENDRSS_NAME);
        $propbag->add('description',   PLUGIN_EVENT_BACKENDRSS_DESC);
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Sebastian Nohn');
        $propbag->add('version',       '1.4.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',    array(
            'backend_frontpage_display' => true
        ));
        $propbag->add('groups', array('BACKEND_FEATURES'));

        $propbag->add('configuration', array('number', 'title', 'rssuri', 'charset', 'target', 'cachetime'));
        $this->dependencies = array();
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'charset':
                $propbag->add('type', 'radio');
                $propbag->add('name', CHARSET);
                $propbag->add('description', CHARSET);
                $propbag->add('default', 'native');

                $charsets = array();
                if (LANG_CHARSET != 'UTF-8') {
                    $charsets['value'][] = $charsets['desc'][] = 'UTF-8';
                }
                if (LANG_CHARSET != 'ISO-8859-1') {
                    $charsets['value'][] = $charsets['desc'][] = 'ISO-8859-1';
                }

                $charsets['value'][] = 'native';
                $charsets['desc'][]  = LANG_CHARSET;
                $propbag->add('radio', $charsets);
                break;

            case 'number':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_REMOTERSS_NUMBER);
                $propbag->add('description', PLUGIN_REMOTERSS_NUMBER_BLAHBLAH);
                $propbag->add('default', '0');
                break;

            case 'dateformat':
                $propbag->add('type', 'string');
                $propbag->add('name', GENERAL_PLUGIN_DATEFORMAT);
                $propbag->add('description', sprintf(GENERAL_PLUGIN_DATEFORMAT_BLAHBLAH, '%A, %B %e. %Y'));
                $propbag->add('default', '%A, %B %e. %Y');
                break;

            case 'title':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_REMOTERSS_SIDEBARTITLE);
                $propbag->add('description', PLUGIN_REMOTERSS_SIDEBARTITLE_BLAHBLAH);
                $propbag->add('default', '');
                break;

            case 'rssuri':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_REMOTERSS_RSSURI);
                $propbag->add('description', PLUGIN_REMOTERSS_RSSURI_BLAHBLAH);
                $propbag->add('default', '');
                break;

            case 'target':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_REMOTERSS_RSSTARGET);
                $propbag->add('description', PLUGIN_REMOTERSS_RSSTARGET_BLAHBLAH);
                $propbag->add('default', '_blank');
                break;

            case 'cachetime':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_REMOTERSS_CACHETIME);
                $propbag->add('description', PLUGIN_REMOTERSS_CACHETIME_BLAHBLAH);
                $propbag->add('default', 10800);
                break;

            case 'displaydate':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_REMOTERSS_DISPLAYDATE);
                $propbag->add('description', PLUGIN_REMOTERSS_BLAHBLAH);
                $propbag->add('default', 'true');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_frontpage_display':

		    $number       = $this->get_config('number');
		    $title        = $this->get_config('title');
		    $rssuri       = $this->get_config('rssuri');
		    $target       = $this->get_config('target');
		    $cachetime    = $this->get_config('cachetime');

		    echo '<h3>'.$title.'</h3>';

		    if (!$number || !is_numeric($number) || $number < 1) {
		       $showAll = true;
		    } else {
		       $showAll = false;
		    }

		    if (!$target || strlen($target) < 1) {
		       $target = '_blank';
		    }

		    if (!$cachetime || !is_numeric($cachetime)) {
		       $cachetime = 10800; // 3 hours in seconds
		    }

		    if (trim($rssuri)) {
		       $feedcache = $serendipity['serendipityPath'] . 'archives/remoterss_cache_' . preg_replace('@[^a-z0-9]*@i', '', $rssuri) . '.dat';
		    if (!file_exists($feedcache) || filesize($feedcache) == 0 || filemtime($feedcache) < (time() - $cachetime)) {

		       require_once 'bundled-libs/Onyx/RSS.php';
		       $c = new Onyx_RSS();
		       $c->parse($rssuri);

		       $i = 0;
		       $content = '<ul>';
		       while (($showAll || ($i < $number)) && ($item = $c->getNextItem())) {
		          if (empty($item['title'])) {
                             continue;
                          }
			  $content .= '<li><a href="' . $this->decode($item['link']) . '" target="'.$target.'">';
			  $content .= $this->decode($item['title']) . '</a></li>';
                          ++$i;
		       }
		       $content .= '</ul>';

		       $fp = @fopen($feedcache, 'w');
		       if ($fp) {
                          fwrite($fp, $content);
                          fclose($fp);
                       } else {
                          echo '<!-- Cache failed to ' . $feedcache . ' in ' . getcwd() . ' -->';
                       }

		    } else {
		       $content = file_get_contents($feedcache);
		    }

		    echo $content;
		 } else {
		    echo PLUGIN_REMOTERSS_NOURI;
		 }
                    break;

                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
    }

    function decode($string) {
        switch($this->get_config('charset', 'native')) {
            case 'native':
                return $string;

            case 'ISO-8859-1':
                if (function_exists('iconv')) {
                    return iconv('ISO-8859-1', LANG_CHARSET, $string);
                } elseif (function_exists('recode')) {
                    return recode('iso-8859-1..' . LANG_CHARSET, $string);
                } else {
                    return $string;
                }

            case 'UTF-8':
            default:
                return utf8_decode($string);
        }
    }


}

/* vim: set sts=4 ts=4 expandtab : */
?>