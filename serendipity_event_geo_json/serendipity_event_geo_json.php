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
			$propbag->add('requirements', ['serendipity' => '2.3']);
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

		function get_articles() {
			global $serendipity;
			$timestamp = serendipity_db_time();
			$showFutureEntries = serendipity_db_bool($serendipity['showFutureEntries']);
			$articles = [];
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
			) as $article) {
				$articles[$article['id']] = [
					'title' => $article['title'],
					'url' => $article['timestamp'] <= $timestamp || $showFutureEntries
						? $serendipity['serendipityHTTPPath'] . $article['permalink']
						: null,
					'date' => intval($article['timestamp']),
					'size' => intval($article['size']),
					'author' => $article['realname'],
					'location' => [floatval($article['lat']), floatval($article['lng'])],
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
			) as $articleCategory) {
				$articles[$articleCategory['entryid']]['categories'][] = intval($articleCategory['categoryid']);
			}
			return array_values($articles);
		}

		function get_tracks() {
			global $serendipity;
			return array_map(function($track) {
				global $serendipity;
				return [
					'title' => $track['realname'],
					'url' => $serendipity['serendipityHTTPPath'] . $serendipity['uploadPath'] . $track['path'] . $track['realname'],
					'date' => intval($track['date']),
					'size' => intval($track['size'])
				];
			}, $this->simple_query(
				"SELECT i.realname, i.path, IFNULL(m.value, i.date) AS date, i.size
				FROM {$serendipity['dbPrefix']}images i
				LEFT JOIN {$serendipity['dbPrefix']}mediaproperties m ON (
					m.mediaid = i.id AND m.property='DATE' AND m.property_group = 'base_property' AND property_subgroup = ''
				)
				WHERE i.extension = 'gpx'
				ORDER BY i.path",
				false, 'assoc'
			));
		}

		function get_geo_json() {
			return json_encode([
				'articles' => $this->get_articles(),
				'tracks' => $this->get_tracks()
			], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		}

		function event_hook($event, &$bag, &$eventData, $addData = null)
		{
			if ($event == 'frontend_header') {
				echo '    <script>const geo = ' . $this->get_geo_json() . ';</script>' . PHP_EOL;
			}
		}

		function introspect_config_item($name, &$propbag)
		{
			return true;
		}
	}
?>
