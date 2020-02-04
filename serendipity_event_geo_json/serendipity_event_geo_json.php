<?php
	if (IN_serendipity !== true) {
		die ("Don't hack!");
	}

	@serendipity_plugin_api::load_language(dirname(__FILE__));

	class serendipity_event_geo_json extends serendipity_event
	{
		function introspect(&$propbag)
		{
			$propbag->add('name', PLUGIN_EVENT_GEO_JSON_NAME);
			$propbag->add('description', PLUGIN_EVENT_GEO_JSON_DESCRIPTION);
			$propbag->add('copyright', 'GPL');
			$propbag->add('event_hooks', array('frontend_header' => true));
			$propbag->add('author', 'Martin Sewelies');
			$propbag->add('version', '0.1');
			$propbag->add('requirements', array('serendipity' => '2.3'));
			$propbag->add('stackable', false);
			$propbag->add('groups', array('FRONTEND_FEATURES'));
		}

		function generate_content(&$title)
		{
			$title = PLUGIN_EVENT_GEO_JSON_NAME;
		}

		function get_geo_json()
		{
			global $serendipity;

			$tt = serendipity_db_query(
				"SELECT e.title, p.permalink, e.timestamp, LENGTH(e.body) AS size, a.realname, e2.value AS lat, e1.value AS lng
				FROM {$serendipity['dbPrefix']}entries e
				JOIN {$serendipity['dbPrefix']}entryproperties e1 ON (e1.entryid = e.id AND e1.property='geo_long')
				JOIN {$serendipity['dbPrefix']}entryproperties e2 ON (e2.entryid = e.id AND e2.property='geo_lat')
				LEFT JOIN {$serendipity['dbPrefix']}permalinks p ON (p.entry_id = e.id AND p.type='entry')
				LEFT JOIN {$serendipity['dbPrefix']}authors a ON (a.authorid = e.authorid)
				WHERE e.isdraft = 'false'
				ORDER BY p.permalink"
			);

			$entries = [];
			if (is_array($tt)) {
				foreach ($tt as $t) {
					$entries[] = [
						'title' => $t['title'],
						'url' => $serendipity['serendipityHTTPPath'].$t['permalink'],
						'date' => (int)$t['timestamp'],
						'size' => (int)$t['size'],
						'author' => $t['realname'],
						'pos' => [(double)$t['lat'], (double)$t['lng']]
					];
				}
			}

			$tt = serendipity_db_query(
				"SELECT i.realname, i.path, IFNULL(m.value, i.date) AS date, i.size
				FROM {$serendipity['dbPrefix']}images i
				LEFT JOIN {$serendipity['dbPrefix']}mediaproperties m ON (
					m.mediaid = i.id AND m.property='DATE' AND m.property_group = 'base_property' AND property_subgroup = ''
				)
				WHERE i.extension = 'gpx'
				ORDER BY i.path, i.realname"
			);

			$uploads = [];
			if (is_array($tt)) {
				foreach ($tt as $t) {
					$uploads[] = [
						'title' => $t['realname'],
						'url' => $serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$t['path'].$t['realname'],
						'date' => (int)$t['date'],
						'size' => (int)$t['size']
					];
				}
			}

			$object = [
				'entries' => $entries,
				'uploads' => $uploads
			];
			return json_encode($object, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		}

		function event_hook($event, &$bag, &$eventData, $addData = null)
		{
			if ($event == 'frontend_header') {
            echo '    <script>const geo = '.$this->get_geo_json().';</script>'.PHP_EOL;
			}
		}

		function introspect_config_item($name, &$propbag)
		{
			return true;
		}
	}
?>
