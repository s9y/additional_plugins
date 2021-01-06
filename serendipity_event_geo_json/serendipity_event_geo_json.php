<?php
	if (IN_serendipity !== true) {
		die ("Don't hack!");
	}

	@serendipity_plugin_api::load_language(dirname(__FILE__));
	include dirname(__FILE__) . '/plugin_version.inc.php';

	class serendipity_event_geo_json extends serendipity_event
	{
		function introspect(&$propbag)
		{
			$propbag->add('name', PLUGIN_EVENT_GEO_JSON_NAME);
			$propbag->add('description', PLUGIN_EVENT_GEO_JSON_DESCRIPTION);
			$propbag->add('copyright', 'GPL');
			$propbag->add('event_hooks', array('frontend_header' => true));
			$propbag->add('author', PLUGIN_EVENT_GEO_JSON_AUTHOR);
			$propbag->add('version', PLUGIN_EVENT_GEO_JSON_VERSION);
			$propbag->add('requirements', array('serendipity' => '2.3'));
			$propbag->add('stackable', false);
			$propbag->add('groups', array('FRONTEND_FEATURES'));
		}

		function generate_content(&$title)
		{
			$title = PLUGIN_EVENT_GEO_JSON_NAME;
		}

		function simple_query($sql) {
			$rows = serendipity_db_query($sql, false, 'assoc');
			return is_array($rows) ? $rows : [];
		}

		function get_entries() {
			global $serendipity;
			$entries = [];
			foreach ($this->simple_query(
				"SELECT e.id, e.title, p.permalink, e.timestamp, LENGTH(e.body) AS size, a.realname, eplat.value AS lat, eplng.value AS lng
				FROM {$serendipity['dbPrefix']}entries e
				JOIN {$serendipity['dbPrefix']}entryproperties eplat ON (eplat.entryid = e.id AND eplat.property = 'geo_lat')
				JOIN {$serendipity['dbPrefix']}entryproperties eplng ON (eplng.entryid = e.id AND eplng.property = 'geo_long')
				JOIN {$serendipity['dbPrefix']}permalinks p ON (p.entry_id = e.id AND p.type = 'entry')
				JOIN {$serendipity['dbPrefix']}authors a ON a.authorid = e.authorid
				WHERE e.isdraft = 'false'
				ORDER BY e.timestamp",
				false, 'assoc'
			) as $row) {
				$entries[$row['id']] = [
					'title' => $row['title'],
					'url' => serendipity_db_bool($serendipity['showFutureEntries']) || $row['timestamp'] <= serendipity_db_time()
						? $serendipity['serendipityHTTPPath'].$row['permalink']
						: null,
					'date' => intval($row['timestamp']),
					'size' => intval($row['size']),
					'author' => $row['realname'],
					'pos' => [floatval($row['lat']), floatval($row['lng'])],
					'categories' => []
				];
			}
			foreach ($this->simple_query(
				"SELECT ec.entryid, ec.categoryid
				FROM {$serendipity['dbPrefix']}entrycat ec
				JOIN {$serendipity['dbPrefix']}entries e ON e.id = ec.entryid
				JOIN {$serendipity['dbPrefix']}entryproperties eplat ON (eplat.entryid = ec.entryid AND eplat.property = 'geo_lat')
				JOIN {$serendipity['dbPrefix']}entryproperties eplng ON (eplng.entryid = ec.entryid AND eplng.property = 'geo_long')
				WHERE e.isdraft = 'false'"
			) as $row) {
				$entries[$row['entryid']]['categories'][] = intval($row['categoryid']);
			}
			return array_values($entries);
		}

		function get_uploads() {
			global $serendipity;
			return array_map(function($row) {
				global $serendipity;
				return [
					'title' => $row['realname'],
					'url' => $serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$row['path'].$row['realname'],
					'date' => intval($row['date']),
					'size' => intval($row['size'])
				];
			}, $this->simple_query(
				"SELECT i.realname, i.path, IFNULL(m.value, i.date) AS date, i.size
				FROM {$serendipity['dbPrefix']}images i
				LEFT JOIN {$serendipity['dbPrefix']}mediaproperties m ON (
					m.mediaid = i.id AND m.property='DATE' AND m.property_group = 'base_property' AND property_subgroup = ''
				)
				WHERE i.extension = 'gpx'
				ORDER BY i.path, i.realname",
				false, 'assoc'
			));
		}

		function get_geo_json()
		{
			return json_encode([
				'entries' => $this->get_entries(),
				'uploads' => $this->get_uploads()
			], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
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
