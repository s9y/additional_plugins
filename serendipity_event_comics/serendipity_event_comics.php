<?php # 
//* s9y Comics Plug-in  by Wesley Hwang-Chung *//
//* http://tool-box.info | wesley96@gmail.com *//


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_comics extends serendipity_event {
	var $title = PLUGIN_COMICS_NAME;

	function introspect(&$propbag) {
		global $serendipity;

		$this->title = $this->get_config('title', $this->title);
		$propbag->add('name',          PLUGIN_COMICS_NAME);
		$propbag->add('description',   PLUGIN_COMICS_DESC);
		$propbag->add('stackable',     false);
		$propbag->add('author',        'Wesley Hwang-Chung');
		$propbag->add('version',       '1.5.1');
		$propbag->add('requirements',  array(
			'serendipity' => '0.8',
			'smarty'      => '2.6.7',
			'php'         => '4.1.0'
		));
		$propbag->add('groups', array('FRONTEND_ENTRY_RELATED'));
		$propbag->add('event_hooks',   array('css' => true, 'entries_header' => true, 'entry_display' => true, 'frontend_fetchentries' => true));
		$propbag->add('configuration', array('category', 'show_title', 'raw', 'hide'));
	}

	function introspect_config_item($name, &$propbag) {
		global $serendipity;
		switch($name) {
			case 'category':
				$raw_cat = serendipity_fetchCategories();
				$raw_cat = serendipity_walkRecursive($raw_cat, 'categoryid', 'parentid', VIEWMODE_THREADED);
				$categories = array('' => NONE);
				if (is_array($raw_cat)) {
					foreach ($raw_cat as $cat) {
						$categories[$cat['categoryid']] = str_repeat('-', $cat['depth']) . $cat['category_name'];
					}
				}
				$propbag->add('type',         'select');
				$propbag->add('name',         PLUGIN_COMICS_CAT);
				$propbag->add('description',  PLUGIN_COMICS_CAT_DESC);
				$propbag->add('select_values', $categories);
				$propbag->add('default',     '');
				break;

			case 'show_title':
				$propbag->add('type',        'boolean');
				$propbag->add('name',        PLUGIN_COMICS_TITLE);
				$propbag->add('description', PLUGIN_COMICS_TITLE_DESC);
				$propbag->add('default',     'true');
				break;

			case 'raw':
				$propbag->add('type',        'boolean');
				$propbag->add('name',        PLUGIN_COMICS_RAW);
				$propbag->add('description', PLUGIN_COMICS_RAW_DESC);
				$propbag->add('default',     'true');
				break;

			case 'hide':
				$propbag->add('type',        'boolean');
				$propbag->add('name',        PLUGIN_COMICS_HIDE);
				$propbag->add('description', PLUGIN_COMICS_HIDE_DESC);
				$propbag->add('default',     'true');
				break;

			default:
				return false;
		}
		return true;
	}

    function timeOffset($timestamp) {
        if (function_exists('serendipity_serverOffsetHour')) {
            return serendipity_serverOffsetHour($timestamp, true);
        }

        return $timestamp;
    }

	function makeQlink($resultset, $label) {
		if (is_array($resultset) && is_numeric($resultset[0]['id'])) {
			$link = '<a href="' . serendipity_archiveURL($resultset[0]['id'], $resultset[0]['title'], 'baseURL', true, array('timestamp' => $resultset[0]['timestamp'])) . '">' . $label . '</a>';
			return $link;
		}
		return false;
	}

	function jumplinks($id, $cat) {
		global $serendipity;
		$links       = array();
		$cond        = array();

		$currentTimeSQL = serendipity_db_query("SELECT timestamp FROM {$serendipity['dbPrefix']}entries WHERE id = " . (int)$id, true);
		$cond['joins'] = " INNER JOIN {$serendipity['dbPrefix']}entrycat ON e.id = {$serendipity['dbPrefix']}entrycat.entryid ";
		if (is_array($currentTimeSQL)) {
			$cond['compare'] = "e.timestamp [%1] " . $currentTimeSQL['timestamp'];
		} else {
			$cond['compare'] = "e.id [%1] " . (int) $id;
		}

		$cond['and'] = " AND e.isdraft = 'false' AND e.timestamp <= " . $this->timeOffset(time());
		if ($cat != '') $cond['and'] .= " AND {$serendipity['dbPrefix']}entrycat.categoryid = {$cat}";
		serendipity_plugin_api::hook_event('frontend_fetchentry', $cond);

		$querystring = "SELECT
							e.id, e.title, e.timestamp
						FROM
							{$serendipity['dbPrefix']}entries e
							{$cond['joins']}
						WHERE
							{$cond['compare']}
							{$cond['and']}
						ORDER BY e.timestamp [%2]
						LIMIT  1";

		$firsID = serendipity_db_query(str_replace(array('[%1]', '[%2]'), array('<', 'ASC'), $querystring));
		$prevID = serendipity_db_query(str_replace(array('[%1]', '[%2]'), array('<', 'DESC'), $querystring));
		$nextID = serendipity_db_query(str_replace(array('[%1]', '[%2]'), array('>', 'ASC'), $querystring));
		$lastID = serendipity_db_query(str_replace(array('[%1]', '[%2]'), array('>', 'DESC'), $querystring));
		if ($link = $this->makeQlink($firsID, '&lt;&lt; ' . PLUGIN_COMICS_FIRST)) $links[] = $link;
		if ($link = $this->makeQlink($prevID, '&lt; ' . PREVIOUS)) $links[] = $link;
		if ($link = $this->makeQlink($nextID, NEXT . ' &gt;')) $links[] = $link;
		if ($link = $this->makeQlink($lastID, PLUGIN_COMICS_LAST . ' &gt;&gt;')) $links[] = $link;
		$jumplink = '<div class="serendipity_comics">' . implode('&nbsp;&nbsp;', $links) . '</div>';
		return $jumplink;
	}

	function generate_content(&$title)
	{
		$title = $this->title;
	}

	function event_hook($event, &$bag, &$eventData, $addData = null) {
		global $serendipity;

		$hooks = &$bag->get('event_hooks');
		$comic_cat = $this->get_config('category', '');
		$show_t = $this->get_config('show_title', 'true');
		$show_raw = $this->get_config('raw', 'true');
		$hide_fp = $this->get_config('hide', 'true');

		if ($event == 'css') {
			if (stristr('.serendipity_comics', $addData)) {
				// class exists in CSS, so a user has customized it and we don't need default
				return true;
			}
?>
.serendipity_comics {
	font-size: 15px;
	font-weight: bold;
    text-align: center;
    margin-top: 5px;
    margin-bottom: 10px;
    margin-left: auto;
    margin-right: auto;
    border: 0px;
    display: block;
}
<?php
			return true;
		}
		elseif ($event == 'entries_header' || $event == 'frontend_fetchentries') {
			// determine location and show on the front page only
			$geturi = serendipity_getUriArguments($GLOBALS['uri']);
			if (!isset($geturi[0]) && !isset($serendipity['GET']['id']) && !isset($serendipity['GET']['category']) && $comic_cat) {
				$comic = serendipity_db_query("SELECT e.id, e.title, e.timestamp, e.body
					FROM {$serendipity['dbPrefix']}entries e
					INNER JOIN {$serendipity['dbPrefix']}entrycat
						ON e.id = {$serendipity['dbPrefix']}entrycat.entryid
					WHERE e.isdraft =  'false'
						AND e.timestamp <= " . $this->timeOffset(time()) . "
						AND {$serendipity['dbPrefix']}entrycat.categoryid = {$comic_cat}
					ORDER BY e.timestamp DESC
					LIMIT 1");
				if ($event == 'entries_header' && $serendipity['GET']['page'] == '1') {
					if ($show_t == 'true') {
						echo '<h4 class="serendipity_title"><a href="' . serendipity_archiveURL($comic[0]['id'], $comic[0]['title'], 'baseURL', true, array('timestamp' => $comic[0]['timestamp'])) . '">';
						echo PLUGIN_COMICS_LATEST . (function_exists('serendipity_specialchars') ? serendipity_specialchars(serendipity_strftime(DATE_FORMAT_ENTRY, $comic['0']['timestamp'])) : htmlspecialchars(serendipity_strftime(DATE_FORMAT_ENTRY, $comic['0']['timestamp']), ENT_COMPAT, LANG_CHARSET)) . '</a></h4>';
					}
					if ($show_raw == 'true') {
						echo $comic['0']['body'];
					} else {
						echo '<div class="serendipity_entry"><div class="serendipity_entry_body">';
						$entry = array('html_nugget' => $comic['0']['body']);
						serendipity_plugin_api::hook_event('frontend_display', $entry);
						echo $entry['html_nugget'];
						echo '</div></div>';
					}
					echo $this->jumplinks($comic['0']['id'], $comic_cat);
				}
				// Prevent showing of other comics in the front page
				elseif ($event == 'frontend_fetchentries' && !$serendipity['GET']['page'] && !isset($serendipity['GET']['adminModule'])) {
					if ($hide_fp == 'true') {
						$cond = " INNER JOIN {$serendipity['dbPrefix']}entrycat ON e.id = {$serendipity['dbPrefix']}entrycat.entryid ";
						if (empty($eventData['joins'])) {
							$eventData['joins'] = $cond;
						} else {
							$eventData['joins'] .= $cond;
						}
						$cond = "{$serendipity['dbPrefix']}entrycat.categoryid != {$comic_cat}";
					}
					else {
						$cond = "e.id != {$comic['0']['id']}";
					}
					if (empty($eventData['and'])) {
						$eventData['and'] = " WHERE $cond ";
					} else {
						$eventData['and'] .= " AND $cond ";
					}
				}
			}
			return true;
		}
		// Places the navigation links in the entry view
		elseif ($event == 'entry_display' && isset($serendipity['GET']['id']) && $comic_cat) {
			$thiscat = serendipity_fetchEntryCategories($serendipity['GET']['id']);
			if ($thiscat['0']['0'] == $comic_cat) {
				$elements = count($eventData);
				for ($i = 0; $i < $elements; $i++) {
					unset($eventData[$i]['properties']['ep_cache_extended']);
					$eventData[$i]['exflag'] = 1;
					$eventData[$i]['extended'] .= sprintf($this->jumplinks($serendipity['GET']['id'], $comic_cat));
				}
			}
			return true;
		}
		else {
			return false;
		}
	}
}

?>
