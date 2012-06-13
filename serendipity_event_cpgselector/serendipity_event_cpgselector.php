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

global $CPG;

@define('CPG_EVENT','cpgselector');

@require_once('cpgselector.inc.php');

class serendipity_event_cpgselector extends serendipity_event
{

	var $title = PLUGIN_CPG_NAME;

	function introspect(&$propbag)
	{
		global $serendipity;

		$propbag->add('name',          PLUGIN_CPG_NAME);
		$propbag->add('description',   PLUGIN_CPG_DESC);

        $propbag->add('stackable',     false);
        $propbag->add('author',        'Matthew Maude (modified by Jim Davies)');
        $propbag->add('version',       '2.07');
        $propbag->add('requirements',  array('serendipity' => '0.8'));

		$propbag->add('configuration', array('server', 'database', 'prefix', 'user', 'password', 'path', 'button', 'usenormal', 'maxwidth', 'maxheight'));

		$propbag->add('event_hooks', array('backend_entry_toolbar_body' => true, 'backend_entry_toolbar_extended' => true, 'external_plugin' => true));
        $propbag->add('groups', array('BACKEND_EDITOR', 'IMAGES'));

		return true;

	}

	function introspect_config_item($name, &$propbag){

		switch($name) {

		case 'server':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPG_SERVER_NAME);
			$propbag->add('description', PLUGIN_CPG_SERVER_DESC);
			$propbag->add('default', 'localhost');
			break;

		case 'database':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPG_DB_NAME);
			$propbag->add('description', PLUGIN_CPG_DB_DESC);
			$propbag->add('default', 'coppermine');
			break;

		case 'prefix':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPG_PREFIX_NAME);
			$propbag->add('description', PLUGIN_CPG_PREFIX_DESC);
			$propbag->add('default', 'cpg132_');
			break;

		case 'user':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPG_USER_NAME);
			$propbag->add('description', PLUGIN_CPG_USER_DESC);
			$propbag->add('default', '');
			break;

		case 'password':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPG_PASSWORD_NAME);
			$propbag->add('description', PLUGIN_CPG_PASSWORD_DESC);
			$propbag->add('default', '');
			break;

		case 'path':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPG_URL_NAME);
			$propbag->add('description', PLUGIN_CPG_URL_DESC);
			$propbag->add('default', 'http://www.mygallery.com/');
			break;

		case 'button':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPG_LABEL_NAME);
			$propbag->add('description', PLUGIN_CPG_LABEL_DESC);
			$propbag->add('default', 'Gallery');
			break;

		case 'usenormal':
			$propbag->add('type', 'boolean');
			$propbag->add('name', PLUGIN_CPG_NORMAL_NAME);
			$propbag->add('description', PLUGIN_CPG_NORMAL_DESC);
			$propbag->add('default', 'true');
			break;

		case 'maxwidth':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPG_MAXWIDTH_NAME);
			$propbag->add('description', PLUGIN_CPG_MAXWIDTH_DESC);
			$propbag->add('default', '0');
			break;

		case 'maxheight':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPG_MAXHEIGHT_NAME);
			$propbag->add('description', PLUGIN_CPG_MAXHEIGHT_DESC);
			$propbag->add('default', '0');
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
		global $CPG;

		$hooks = &$bag->get('event_hooks');

		$button_title = $this->get_config('button');

		if (isset($hooks[$event])){

			$link = $serendipity['indexFile'] . '?/plugin/cpgselector&amp;';
			if ($event == 'backend_entry_toolbar_body'){

				echo '<input type="button" name="insImage" value="' . $button_title . '" class="serendipityPrettyButton input_button" onclick="window.open(\'' . $link . 'textarea=body\', \'ImageSel\', \'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1\');" />';

			} elseif ($event == 'backend_entry_toolbar_extended'){

				echo '<input type="button" name="insImage" value="' . $button_title . '" class="serendipityPrettyButton input_button" onclick="window.open(\'' . $link . 'textarea=extended\', \'ImageSel\', \'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1\');" />';

			} elseif ($event == 'external_plugin' && substr($eventData,0,strlen(CPG_EVENT)) == CPG_EVENT){

				parse_str(substr($eventData,strlen(CPG_EVENT),strlen($eventData)),$CPG['get']);

				$path = $this->get_config('path');
				if (!preg_match('/\/$/',$path)) $path .= '/';

				$CPG['server'] = $this->get_config('server');
				$CPG['database'] = $this->get_config('database');
				$CPG['prefix'] = $this->get_config('prefix');
				$CPG['user'] = $this->get_config('user');
				$CPG['password'] = $this->get_config('password');
				$CPG['path'] = $path;
				$CPG['usenormal'] = $this->get_config('usenormal');
				$CPG['maxheight'] = $this->get_config('maxheight');
				$CPG['maxwidth'] = $this->get_config('maxwidth');

				cpg_window();

			}

		} else return false;

		return true;

	}

}

?>
