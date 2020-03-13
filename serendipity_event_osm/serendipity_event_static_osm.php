<?php
	if (IN_serendipity !== true) {
		die ("Don't hack!");
	}

	@serendipity_plugin_api::load_language(dirname(__FILE__));
	include dirname(__FILE__) . '/plugin_version.inc.php';

	class serendipity_event_static_osm extends serendipity_event
	{
		function introspect(&$propbag)
		{
			$propbag->add('name', PLUGIN_EVENT_STATIC_OSM_NAME);
			$propbag->add('description', PLUGIN_EVENT_STATIC_OSM_DESCRIPTION);
			$propbag->add('copyright', 'GPL');
			$propbag->add('event_hooks', array('frontend_header' => true));
			$propbag->add('author', PLUGIN_EVENT_OSM_AUTHOR);
			$propbag->add('version', PLUGIN_EVENT_OSM_VERSION);
			$propbag->add('requirements', array(
				'serendipity' => '2.3'
			));
			$propbag->add('stackable', false);
			$propbag->add('groups', array('FRONTEND_ENTRY_RELATED'));
		}

		function generate_content(&$title)
		{
			$title = PLUGIN_EVENT_STATIC_OSM_NAME;
		}

		function event_hook($event, &$bag, &$eventData, $addData = null)
		{
			global $serendipity;
			if ($event == 'frontend_header') {
				echo '    <link rel="stylesheet" href="'.$this->getFile('ressources/ol.css', 'serendipityHTTPPath').'" type="text/css" />'.PHP_EOL;
				echo '    <link rel="stylesheet" href="'.$this->getFile('ressources/osm.css', 'serendipityHTTPPath').'" type="text/css" />'.PHP_EOL;
				echo '    <script src="'.$this->getFile('ressources/ol.js', 'serendipityHTTPPath').'"></script>'.PHP_EOL;
				echo '    <script src="'.$this->getFile('ressources/osm.js', 'serendipityHTTPPath').'"></script>'.PHP_EOL;
			}
		}

		function introspect_config_item($name, &$propbag)
		{
			return true;
		}
	}
?>
