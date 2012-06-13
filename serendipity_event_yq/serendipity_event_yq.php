<?php # $Id$

/* Y!Q Related Search Plugin */


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

if(strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE')) $GLOBALS['IE']=true; else $GLOBALS['IE']=false;


class serendipity_event_yq extends serendipity_event {
    var $title = PLUGIN_EVENT_YQ_NAME;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_YQ_NAME);
        $propbag->add('description',   PLUGIN_EVENT_YQ_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Rasmus Lerdorf');
        $propbag->add('version',       '1.2');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',    array(
			'frontend_display:html:per_entry' => true,
            'frontend_header' => true
        ));
		$propbag->add('configuration', array('results', 'context_length', 'add_context'));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
    }

	function introspect_config_item($name, &$propbag) {
		switch($name) {
			case 'results':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_YQ_RESULTS);
                $propbag->add('description', PLUGIN_EVENT_YQ_RESULTS_DESC);
                $propbag->add('default', '5');
                break;
			case 'context_length':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_YQ_CONTEXT_LENGTH);
                $propbag->add('description', PLUGIN_EVENT_YQ_CONTEXT_LENGTH_DESC);
                $propbag->add('default', '5');
                break;
			case 'add_context':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_YQ_ADD_CONTEXT);
                $propbag->add('description', PLUGIN_EVENT_YQ_ADD_CONTEXT_DESC);
                $propbag->add('default', '');
                break;
		}
		return true;
	}

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity, $IE;
		static $hookno = 0;

		$hookno++;
        $hooks  = &$bag->get('event_hooks');
		$results = $this->get_config('results');
		$context_length = $this->get_config('context_length');
		$add_context = htmlentities($this->get_config('add_context'));
        $links  = array();

        if (isset($hooks[$event])) {
            switch($event) {
				case 'frontend_header':
					echo '<script language="javascript" src="http://yq.search.yahoo.com/javascript/yq.js"></script>'."\n";
					break;

				case 'frontend_display:html:per_entry':
					$title = htmlentities($eventData['title']);
					$tmp = strip_tags($eventData['body']);
					$tmp = wordwrap($tmp, 80, '<>');
					$tmp = explode('<>', $tmp);
					$tmp = array_slice($tmp, 0, $context_length); /* should be $context_length here */
					$context = str_replace('"','',trim(implode(" ", $tmp)));
					$pos = strlen(strrchr($context, '.'));
					if($pos < strlen($context)) $context = substr($context, 0, -($pos-1));
					$body = &$eventData['body'];
					$last_word = substr(strrchr($context, ' '),1);
					$last_word = preg_quote($last_word,'/');
					if($IE) {
						$st_off = "";
						$js_on  = "document.getElementById('myyq$hookno').style.background='#FFFDE6'";
						$js_off = "document.getElementById('myyq$hookno').style.background='#FFFFFF'";
					} else {
						$st_off = "border: 1px solid #FFFFFF;";
						$js_on  = "document.getElementById('myyq$hookno').style.border='1px dashed #ccc'";
						$js_on .= ";document.getElementById('myyq$hookno').style.background='#FFFDE6'";
						$js_off = "document.getElementById('myyq$hookno').style.border='1px solid #FFFFFF'";
						$js_off.= ";document.getElementById('myyq$hookno').style.background='#FFFFFF'";
					}
					$blurb = <<<EOC
<div id="myyq$hookno" class="yqcontext" style="$st_off">
<form class="yq" action="http://yq.search.yahoo.com/search" method="post">
<input type="hidden" name="YSTResultsMax" value="$results" />
<input type="hidden" name="context" value="$title $add_context $context" />
<div class="yqact" onMouseOver="$js_on" onMouseOut="$js_off">
<input class="yqbt" style="width: 10em;" type="submit" value="Related Search" onclick="return activateYQ(this)" />
</div></form>
EOC;
					$len = strlen($context)-strlen($last_word);
					$body = preg_replace('/(.*'.$last_word.')/','\1</div>', $body, 1);
					$body = $blurb . $body;
					return true;
					break;

                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
    }
}
/* vim: set sts=4 ts=4 expandtab : */
?>
