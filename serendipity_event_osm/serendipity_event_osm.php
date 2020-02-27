<?php
	if (IN_serendipity !== true) {
		die ("Don't hack!");
	}

	@serendipity_plugin_api::load_language(dirname(__FILE__));

	class serendipity_event_osm extends serendipity_event
	{
		function introspect(&$propbag)
		{
			$propbag->add('name', PLUGIN_EVENT_OSM_NAME);
			$propbag->add('description', PLUGIN_EVENT_OSM_DESCRIPTION);
			$propbag->add('copyright', 'GPL');
			$propbag->add('configuration', array('title', 'category_id', 'path', 'height', 'latitude', 'longitude', 'zoom'));
			$propbag->add('event_hooks', array('entries_header' => true));
			$propbag->add('author', 'Martin Sewelies');
			$propbag->add('version', '0.1');
			$propbag->add('requirements', array(
				'serendipity' => '2.3'
			));
			$propbag->add('stackable', true);
			$propbag->add('groups', array('FRONTEND_ENTRY_RELATED'));
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
			}
			return [];
		}

		function event_hook($event, &$bag, &$eventData, $addData = null)
		{
			if ($event == 'entries_header') {
				if ($this->get_config('category_id') === '0' || in_array($this->get_config('category_id'), $this->get_page_categories())) {
					echo '    <div class="map" data-category="'.$this->get_config('category_id', '').'" data-path="'.$this->get_config('path', '').'" data-latitude="'.$this->get_config('latitude', 51.48165).'" data-longitude="'.$this->get_config('longitude', 7.21648).'" data-zoom="'.$this->get_config('zoom', 15).'" style="height: '.$this->get_config('height', '463px').'"></div>'.PHP_EOL;
				}
			}
		}

		function get_selectable_categories()
		{
			$categories = array(0 => ALL_CATEGORIES);
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
			switch($name) {
				case 'title':
					$propbag->add('type',        'string');
					$propbag->add('name',        TITLE);
					$propbag->add('description', TITLE . PLUGIN_PAGE_NUGGET_NOSHOW);
					$propbag->add('default',     PLUGIN_EVENT_OSM_NAME);
					break;
				case 'category_id':
					$propbag->add('type',          'select');
					$propbag->add('name',          PLUGIN_EVENT_OSM_CATEGORY);
					$propbag->add('description',   PLUGIN_EVENT_OSM_CATEGORY_DESCRIPTION);
					$propbag->add('select_values', $this->get_selectable_categories());
					$propbag->add('default',       '0');
					break;
				case 'path':
					$propbag->add('type',        'string');
					$propbag->add('name',        PLUGIN_EVENT_OSM_PATH);
					$propbag->add('description', PLUGIN_EVENT_OSM_PATH_DESC);
					$propbag->add('default',     '');
					break;
				case 'height':
					$propbag->add('type',        'string');
					$propbag->add('name',        PLUGIN_EVENT_OSM_HEIGHT);
					$propbag->add('description', PLUGIN_EVENT_OSM_HEIGHT_DESC);
					$propbag->add('default',     '463px');
					break;
				case 'latitude':
					$propbag->add('type',        'string');
					$propbag->add('name',        PLUGIN_EVENT_OSM_LAT);
					$propbag->add('description', PLUGIN_EVENT_OSM_LAT_DESC);
					$propbag->add('default',     '51.48165');
					break;
				case 'longitude':
					$propbag->add('type',        'string');
					$propbag->add('name',        PLUGIN_EVENT_OSM_LONG);
					$propbag->add('description', PLUGIN_EVENT_OSM_LONG_DESC);
					$propbag->add('default',     '7.21648');
					break;
				case 'zoom':
					$propbag->add('type',        'string');
					$propbag->add('name',        PLUGIN_EVENT_OSM_ZOOM);
					$propbag->add('description', PLUGIN_EVENT_OSM_ZOOM_DESC);
					$propbag->add('default',     '15');
					break;
				default:
					return false;
			}
			return true;
		}
	}
?>
