<?php
if (IN_serendipity !== true) {
	die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname (__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists ($probelang)) {
	include $probelang;
}

include dirname (__FILE__) . '/lang_en.inc.php';

class serendipity_event_google_analytics extends serendipity_event {
	var $title = PLUGIN_EVENT_GOOGLE_ANALYTICS_NAME;
	
	function introspect(&$propbag) {
		global $serendipity;
		
		$propbag->add ('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_NAME);
		$propbag->add ('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_DESC);
		$propbag->add ('stackable', false);
		$propbag->add ('author', '<a href="http://blog.kleinerChemiker.net/" target="_blank">kleinerChemiker</a>');
		$propbag->add ('version', '1.3.0');
		$propbag->add ('requirements', array ('serendipity' => '0.8', 'smarty' => '2.6.7', 'php' => '4.1.0' ));
		$propbag->add ('groups', array ('STATISTICS' ));
		$propbag->add ('cachable_events', array ('frontend_display' => true ));
		$propbag->add ('event_hooks', array ('frontend_header' => true, 'frontend_display' => true ));
		
		$this->markup_elements = array (array ('name' => 'ENTRY_BODY', 'element' => 'body' ), array ('name' => 'EXTENDED_BODY', 'element' => 'extended' ), array ('name' => 'COMMENT', 'element' => 'comment' ), array ('name' => 'HTML_NUGGET', 'element' => 'html_nugget' ) );
		
		$conf_array = array ();
		$conf_array[] = 'analytics_account_number';
		$conf_array[] = 'analytics_track_adsense';
		$conf_array[] = 'analytics_anonymizeIp';
		$conf_array[] = 'analytics_track_external';
		$conf_array[] = 'analytics_track_downloads';
		$conf_array[] = 'analytics_download_extensions';
		$conf_array[] = 'analytics_internal_hosts';
		$conf_array[] = 'analytics_exclude_groups';
		
		foreach ( $this->markup_elements as $element ) {
			$conf_array[] = $element['name'];
		}
		$propbag->add ('configuration', $conf_array);
	}
	
	function introspect_config_item($name, &$propbag) {
		switch ($name) {
			case 'analytics_account_number' :
				$propbag->add ('type', 'string');
				$propbag->add ('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_ACCOUNT_NUMBER);
				$propbag->add ('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_ACCOUNT_NUMBER_DESC);
				$propbag->add ('validate', '/^[0-9]+-[0-9]+$/');
				$propbag->add ('default', '');
				break;
			case 'analytics_track_adsense' :
				$propbag->add ('type', 'boolean');
				$propbag->add ('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_ADSENSE);
				$propbag->add ('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_ADSENSE_DESC);
				$propbag->add ('default', 'false');
				break;
			case 'analytics_anonymizeIp' :
				$propbag->add ('type', 'boolean');
				$propbag->add ('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_ANONYMIZEIP);
				$propbag->add ('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_ANONYMIZEIP_DESC);
				$propbag->add ('default', 'false');
				break;
			case 'analytics_track_external' :
				$propbag->add ('type', 'boolean');
				$propbag->add ('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_EXTERNAL);
				$propbag->add ('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_EXTERNAL_DESC);
				$propbag->add ('default', 'true');
				break;
			case 'analytics_internal_hosts' :
				$propbag->add ('type', 'text');
				$propbag->add ('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_INTERNAL_HOSTS);
				$propbag->add ('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_INTERNAL_HOSTS_DESC);
				$propbag->add ('default', $_SERVER['HTTP_HOST']);
				break;
			case 'analytics_track_downloads' :
				$propbag->add ('type', 'boolean');
				$propbag->add ('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_DOWNLOADS);
				$propbag->add ('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_DOWNLOADS_DESC);
				$propbag->add ('default', 'true');
				break;
			case 'analytics_download_extensions' :
				$propbag->add ('type', 'string');
				$propbag->add ('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_DOWNLOAD_EXTENSIONS);
				$propbag->add ('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_DOWNLOAD_EXTENSIONS_DESC);
				$propbag->add ('default', 'zip,rar');
				break;
			case 'analytics_exclude_groups' :
				$_groups = & serendipity_getAllGroups ();
				if (is_array ($_groups)) {
					foreach ( $_groups as $group ) {
						$groups[$group['confkey']] = $group['confvalue'];
					}
					$propbag->add ('type', 'multiselect');
					$propbag->add ('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_EXCLUDE_GROUPS);
					$propbag->add ('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_EXCLUDE_GROUPS_DESC);
					$propbag->add ('select_size', 5);
					$propbag->add ('select_values', $groups);
				}
				break;
			default :
				$propbag->add ('type', 'boolean');
				$propbag->add ('name', constant ($name));
				$propbag->add ('description', sprintf (APPLY_MARKUP_TO, constant ($name)));
				$propbag->add ('default', 'true');
		}
		return true;
	}
	
	function generate_content(&$title) {
		$title = $this->get_config ('title');
	}
	
	function install() {
		serendipity_plugin_api::hook_event ('backend_cache_entries', $this->title);
	}
	
    function uninstall(&$propbag) {
	    serendipity_plugin_api::hook_event ('backend_cache_purge', $this->title);
		serendipity_plugin_api::hook_event ('backend_cache_entries', $this->title);
	}
	
	function trim_value(&$value) {
		$value = trim ($value);
	}
	
	function in_array_loop($array1, $array2) {
		if (is_array ($array1)) {
			foreach ( $array1 as $array ) {
				if (in_array ($array, $array2)) {
					return true;
				}
			}
		}
		return false;
	}
	
	function analytics_tracker_callback($matches) {
		static $internal_hosts = null;
		static $download_extensions = null;
		static $analytics_track_external = null;
		static $analytics_track_downloads = null;
		
		if ($internal_hosts === null) {
			$internal_hosts = explode ("\n", $this->get_config ('analytics_internal_hosts'));
			array_walk ($internal_hosts, array ($this, 'trim_value' ));
		}
		
		if ($download_extensions === null) {
			$download_extensions = explode (",", $this->get_config ('analytics_download_extensions'));
			array_walk ($download_extensions, array ($this, 'trim_value' ));
		}
		
		if ($analytics_track_external === null) {
			$analytics_track_external = serendipity_db_bool ($this->get_config ('analytics_track_external', true));
		}

		if ($analytics_track_downloads === null) {
			$analytics_track_downloads = serendipity_db_bool ($this->get_config ('analytics_track_downloads', true));
		}
		
		if (substr ($matches[3], 0, 4) == 'http') {
			$host = parse_url ('http://' . $matches[4]);
			preg_match ('/\.([a-z0-9]+)$/i', $host['path'], $extension);
			if (!in_array ($host['host'], $internal_hosts) && $analytics_track_external) {
				return '<a onclick="_gaq.push([\'_trackPageview\', \'/extlink/' . htmlspecialchars ($matches[4]) . '\']);" ' . substr ($matches[0], 2);
			} elseif (in_array ($host['host'], $internal_hosts) && in_array ($extension[1], $download_extensions) && $analytics_track_downloads) {
				return '<a onclick="_gaq.push([\'_trackPageview\', \'/download' . htmlspecialchars ($host['path']) . '\']);" ' . substr ($matches[0], 2);
			} else {
				return $matches[0];
			}
		} else {
			while ( substr ($matches[4], 0, 1) == '/' ) {
				$matches[4] = substr ($matches[4], 1);
			}
			$host = parse_url ('http://www.example.com/' . $matches[4]);
			preg_match ('/\.([a-z0-9]+)$/i', $host['path'], $extension);
			if (in_array ($extension[1], $download_extensions)) {
				return '<a onclick="_gaq.push([\'_trackPageview\', \'/download' . htmlspecialchars ($host['path']) . '\']);" ' . substr ($matches[0], 2);
			} else {
				return $matches[0];
			}
		}
	}
	
	function event_hook($event, &$bag, &$eventData, $addData = null) {
		global $serendipity;
		static $analytics_anonymizeIp = null;
		static $analytics_track_adsense = null;
		static $analytics_track_external = null;
		static $analytics_track_downloads = null;
		static $analytics_exclude_groups = null;
		static $usergroup = false;
		$hooks = &$bag->get ('event_hooks');
		
		if ($analytics_anonymizeIp === null) {
			$analytics_anonymizeIp = serendipity_db_bool ($this->get_config ('analytics_anonymizeIp', false));
		}

		if ($analytics_track_adsense === null) {
			$analytics_track_adsense = serendipity_db_bool ($this->get_config ('analytics_track_adsense', false));
		}

		if ($analytics_track_downloads === null) {
			$analytics_track_downloads = serendipity_db_bool ($this->get_config ('analytics_track_downloads', true));
		}
		
		if ($analytics_track_external === null) {
			$analytics_track_external = serendipity_db_bool ($this->get_config ('analytics_track_external', true));
		}
		
		if ($analytics_exclude_groups === null) {
			$analytics_exclude_groups = explode ("^", $this->get_config ('analytics_exclude_groups', true));
			if (!empty ($analytics_exclude_groups)) {
				$_groups = serendipity_getGroups ($serendipity['authorid']);
				if (is_array ($_groups)) {
					foreach ( $_groups as $group ) {
						$usergroup[] = $group['id'];
					}
				} else {
					$usergroup = false;
				}
			} else {
				$usergroup = false;
			}
		}
		if (isset ($hooks[$event])) {
			switch ($event) {
				case 'frontend_header' :
					$analytics_anonymizeIp ? $analytics_anonymizeIp_code = "_gaq.push(['_gat._anonymizeIp']);\r  " : $analytics_anonymizeIp_code = '';
					$analytics_track_adsense ? $analytics_track_adsense_code = "\r<script type=\"text/javascript\">\rwindow.google_analytics_uacct = \"UA-" . $this->get_config ('analytics_account_number') . "\";\r</script>\r" : $analytics_track_adsense_code = '';
					if ($serendipity['authorid'] === null || !$this->in_array_loop ($usergroup, $analytics_exclude_groups)) {
						echo $analytics_track_adsense_code;
						echo '
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \'UA-' . $this->get_config ('analytics_account_number') . '\']);
  ' . $analytics_anonymizeIp_code . '_gaq.push([\'_trackPageview\']);

  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    (document.getElementsByTagName(\'head\')[0] || document.getElementsByTagName(\'body\')[0]).appendChild(ga);
  })();
</script>';
					}
					
					return true;
					break;
				
				case 'frontend_display' :
					if ($serendipity['authorid'] && $usergroup !== false && $this->in_array_loop ($usergroup, $analytics_exclude_groups)) {
						return true;
					}
					
					foreach ( $this->markup_elements as $temp ) {
						if (serendipity_db_bool ($this->get_config ($temp['name'], true)) && isset ($eventData[$temp['element']]) && !$eventData['properties']['ep_disable_markup_' . $this->instance] && !isset ($serendipity['POST']['properties']['disable_markup_' . $this->instance]) && ($analytics_track_downloads || $analytics_track_external)) {
							$element = $temp['element'];
							$eventData[$element] = preg_replace_callback ("#<a (.*)href=(\"|')(http://|https://|)([^\"']+)(\"|')([^>]*)>#isUm", array ($this, 'analytics_tracker_callback' ), $eventData[$element]);
						}
					}
					return true;
					break;
				
				default :
					return false;
			}
		} else {
			return false;
		}
	}
}

