<?php
	if (IN_serendipity !== true) {
		die ("Don't hack!");
	}

	@serendipity_plugin_api::load_language(dirname(__FILE__));
	include dirname(__FILE__) . '/plugin_version.inc.php';

	class serendipity_event_osm extends serendipity_event
	{
		function introspect(&$propbag)
		{
			$propbag->add('name', PLUGIN_EVENT_OSM_NAME);
			$propbag->add('description', PLUGIN_EVENT_OSM_DESCRIPTION);
			$propbag->add('copyright', 'GPL');
			$propbag->add('configuration', array('title', 'category_id', 'path', 'height', 'latitude', 'longitude', 'zoom'));
			$propbag->add('event_hooks', array('entries_header' => true));
			$propbag->add('author', PLUGIN_EVENT_OSM_AUTHOR);
			$propbag->add('version', PLUGIN_EVENT_OSM_VERSION);
			$propbag->add('requirements', array(
				'php' => '7.0.0',
				'serendipity' => '2.3'
			));
			$propbag->add('stackable', true);
			$propbag->add('groups', array('FRONTEND_ENTRY_RELATED'));
			$this->dependencies = array(
				'serendipity_event_geo_json' => 'keep'
			);
		}

		function generate_content(&$title)
		{
			$title = $this->get_config('title');
		}

		function get_page_categories()
		{
			global $serendipity;
			$vars = $serendipity['smarty']->get_template_vars();
			switch ($vars['view']) {
				case 'entry':
					return array_map(function($x) {
						return $x['categoryid'];
					}, $vars['entry']['categories']);
				case 'categories':
					return $serendipity['POST']['multiCat'] ?? [$vars['category']];
				case 'plugin':
				case 'start':
					return $vars['staticpage_related_category_id'] !== '0'
						? [$vars['staticpage_related_category_id']]
						: [];
			}
			return [];
		}

		function event_hook($event, &$bag, &$eventData, $addData = null)
		{
			if ($event == 'entries_header') {
				$category_id = $this->get_config('category_id', 'any');
				$page_categories = $this->get_page_categories();
				if (
					$category_id === 'any'
					||
					($category_id === 'without' && empty($page_categories))
					||
					in_array($category_id, $page_categories)
				) {
					echo '    <div class="map" data-category="' . $category_id
						. '" data-path="' . addslashes($this->get_config('path', ''))
						. '" data-latitude="' . ((float)$this->get_config('latitude', 51.48165))
						. '" data-longitude="' . ((float)$this->get_config('longitude', 7.21648))
						. '" data-zoom="' . ((int)$this->get_config('zoom', 15))
						. '" style="height: ' . addslashes($this->get_config('height', '463px'))
						. '"></div>'.PHP_EOL;
				}
			}
		}

		function get_selectable_categories()
		{
			$categories = array('without' => PLUGIN_EVENT_OSM_CATEGORY_WITHOUT, 'any' => PLUGIN_EVENT_OSM_CATEGORY_ANY);
			$cats = serendipity_fetchCategories();
			if (is_array($cats)) {
				$cats = serendipity_walkRecursive($cats, 'categoryid', 'parentid', VIEWMODE_THREADED);
				foreach($cats as $cat) {
					$categories[$cat['categoryid']] = str_repeat('   ', $cat['depth']) . $cat['category_name'];
				}
			}
			return $categories;
		}

		function introspect_config_item($name, &$propbag)
		{
			global $serendipity;
			switch($name) {
				case 'title':
					$propbag->add('type',        'string');
					$propbag->add('name',        TITLE);
					$propbag->add('description', TITLE . ' (' . PLUGIN_EVENT_OSM_NOT_SHOWN . ')');
					$propbag->add('default',     PLUGIN_EVENT_OSM_NAME);
					break;
				case 'category_id':
					$propbag->add('type',          'select');
					$propbag->add('name',          PLUGIN_EVENT_OSM_CATEGORY);
					$propbag->add('description',   PLUGIN_EVENT_OSM_CATEGORY_DESCRIPTION);
					$propbag->add('select_values', $this->get_selectable_categories());
					$propbag->add('default',       'without');
					break;
				case 'path':
					$propbag->add('type',        'text');
					$propbag->add('name',        PLUGIN_EVENT_OSM_PATH);
					$propbag->add('description', PLUGIN_EVENT_OSM_PATH_DESCRIPTION);
					$propbag->add('default',     $serendipity['serendipityHTTPPath'] . $serendipity['uploadPath']);
					break;
				case 'height':
					$propbag->add('type',        'string');
					$propbag->add('name',        PLUGIN_EVENT_OSM_HEIGHT);
					$propbag->add('description', PLUGIN_EVENT_OSM_HEIGHT_DESCRIPTION);
					$propbag->add('default',     '463px');
					break;
				case 'latitude':
					$propbag->add('type',        'string');
					$propbag->add('name',        PLUGIN_EVENT_OSM_LAT);
					$propbag->add('description', PLUGIN_EVENT_OSM_LAT_DESCRIPTION);
					$propbag->add('default',     '51.48165');
					break;
				case 'longitude':
					$propbag->add('type',        'string');
					$propbag->add('name',        PLUGIN_EVENT_OSM_LONG);
					$propbag->add('description', PLUGIN_EVENT_OSM_LONG_DESCRIPTION);
					$propbag->add('default',     '7.21648');
					break;
				case 'zoom':
					$propbag->add('type',        'string');
					$propbag->add('name',        PLUGIN_EVENT_OSM_ZOOM);
					$propbag->add('description', PLUGIN_EVENT_OSM_ZOOM_DESCRIPTION);
					$propbag->add('default',     '15');
					break;
				default:
					return false;
			}
			return true;
		}
	}
?>
