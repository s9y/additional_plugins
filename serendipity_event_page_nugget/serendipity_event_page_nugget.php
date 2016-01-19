<?php #

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_page_nugget extends serendipity_event
{
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_PAGE_NUGGET_NAME);
        $propbag->add('description',   PLUGIN_PAGE_NUGGET_DESC);
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Wesley Hwang-Chung');
        $propbag->add('version',       '1.13');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED'));
        $propbag->add('event_hooks',   array('frontend_header' => true,
                                             'entries_header' => true,
                                             'entry_display' => true,
                                             'entries_footer' => true,
                                             'frontend_footer' => true,
                                             'frontend_display' => true));
        $propbag->add('configuration', array('title', 'placement', 'language', 'content', 'content_plain', 'markup', 'show_where'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {

            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        TITLE);
                $propbag->add('description', TITLE_FOR_NUGGET . PLUGIN_PAGE_NUGGET_NOSHOW);
                $propbag->add('default',     '');
                break;

			case 'placement':
				$select = array('head' => PLUGIN_PAGE_NUGGET_HEAD,
				                'top' => PLUGIN_PAGE_NUGGET_TOP,
				                'art_foot' => PLUGIN_PAGE_NUGGET_ART_FOOT,
				                'bottom' => PLUGIN_PAGE_NUGGET_BOTTOM,
				                'foot' => PLUGIN_PAGE_NUGGET_FOOT,
                                'rss' => PLUGIN_PAGE_NUGGET_RSS);
				$propbag->add('type',        'select');
				$propbag->add('select_values', $select);
				$propbag->add('name',        PLUGIN_PAGE_NUGGET_PLACE);
				$propbag->add('default',     'top');
				break;

        	case 'language':
        		$select = array('all' => PLUGIN_PAGE_NUGGET_ALL,
        			'en' => 'English',
        			'de' => 'German',
        			'da' => 'Danish',
        			'es' => 'Spanish',
        			'fr' => 'French',
        			'fi' => 'Finnish',
        			'cs' => 'Czech (Win-1250)',
        			'cz' => 'Czech (ISO-8859-2)',
        			'nl' => 'Dutch',
        			'is' => 'Icelandic',
        			'se' => 'Swedish',
        			'pt' => 'Portuguese Brazilian',
        			'pt_PT' => 'Portuguese European',
        			'bg' => 'Bulgarian',
        			'hu' => 'Hungarian',
        			'no' => 'Norwegian',
        			'ro' => 'Romanian',
        			'it' => 'Italian',
        			'ru' => 'Russian',
        			'fa' => 'Persian',
        			'tw' => 'Traditional Chinese (Big5)',
        			'tn' => 'Traditional Chinese (UTF-8)',
        			'zh' => 'Simplified Chinese (GB2312)',
        			'cn' => 'Simplified Chinese (UTF-8)',
        			'ja' => 'Japanese',
        			'ko' => 'Korean');
                $propbag->add('type',        'select');
                $propbag->add('select_values', $select);
                $propbag->add('name',        PLUGIN_PAGE_NUGGET_LANG);
                $propbag->add('default',     'all');
        		break;

            case 'content':
                $propbag->add('type',        'html');
                $propbag->add('name',        CONTENT);
                $propbag->add('description', THE_NUGGET);
                $propbag->add('default',     '');
                break;

            case 'content_plain':
                $propbag->add('type',        'text');
                $propbag->add('name',        CONTENT);
                $propbag->add('description', PLUGIN_PAGE_NUGGET_CONTENT);
                $propbag->add('default',     '');
                break;

            case 'markup':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        DO_MARKUP);
                $propbag->add('description', PLUGIN_PAGE_NUGGET_MARKUP_NO . DO_MARKUP_DESCRIPTION);
                $propbag->add('default',     'true');
                break;

            case 'show_where':
                $select = array('extended' => PLUGIN_ITEM_DISPLAY_EXTENDED, 'overview' => PLUGIN_ITEM_DISPLAY_OVERVIEW, 'both' => PLUGIN_ITEM_DISPLAY_BOTH);
                $propbag->add('type',        'select');
                $propbag->add('select_values', $select);
                $propbag->add('name',        PLUGIN_ITEM_DISPLAY);
                $propbag->add('default',     'both');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        $title = $this->get_config('title');
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        $placement = $this->get_config('placement', 'top');
        $language = $this->get_config('language', 'all');
        $show_where = $this->get_config('show_where', 'both');

		// if the language doesn't match, do not display
		if ($language != 'all' && $serendipity['lang'] != $language) return false;

        // RSS-Feed special case
        if ($event == 'frontend_display' && $addData['from'] == 'functions_entries:printEntries_rss') {
            if ($placement == 'rss') {
                if ($this->get_config('markup', 'true') == 'true' && $event != 'frontend_header') {
                    $entry = array('html_nugget' => $this->get_config('content'));
                    serendipity_plugin_api::hook_event('frontend_display', $entry);
                    $eventData['body'] .= $entry['html_nugget'] . $this->get_config('content_plain');
                } else {
                    $eventData['body'] .= $this->get_config('content') . $this->get_config('content_plain');
                }
            }

            return true;
        }

		// where to show
		if ($show_where == 'extended' && (!isset($serendipity['GET']['id']) || !is_numeric($serendipity['GET']['id']))) {
			return false;
		} else if ($show_where == 'overview' && isset($serendipity['GET']['id']) && is_numeric($serendipity['GET']['id'])) {
			return false;
		}

		if (($placement == 'head' && $event == 'frontend_header') ||
			($placement == 'top' && $event == 'entries_header') ||
			($placement == 'bottom' && $event == 'entries_footer') ||
			($placement == 'foot' && $event == 'frontend_footer')){
			// entries_footer hook location workaround: get out of the 'serendipity_entryFooter' class
			if ($event == 'entries_footer') echo '</div><div>';
			// if not for HEAD, apply markup?
			if ($this->get_config('markup', 'true') == 'true' && $event != 'frontend_header') {
				$entry = array('html_nugget' => $this->get_config('content'));
				serendipity_plugin_api::hook_event('frontend_display', $entry);
				echo $entry['html_nugget'] .  $this->get_config('content_plain');
			} else {
				echo $this->get_config('content') . $this->get_config('content_plain');
			}
			return true;
		} elseif ($placement == 'art_foot' && $event == 'entry_display'){
			if (!is_array($eventData)) return false;
			$elements = count($eventData);
			for ($i = 0; $i < $elements; $i++) {
				if ($this->get_config('markup', 'true') == 'true') {
					$entry = array('html_nugget' => $this->get_config('content'));
					serendipity_plugin_api::hook_event('frontend_display', $entry);
					$eventData[$i]['add_footer'] .= sprintf('</div>' . $entry['html_nugget'] . $this->get_config('content_plain') . '<div>');
				} else {
					$eventData[$i]['add_footer'] .= sprintf('</div>' . $this->get_config('content') . $this->get_config('content_plain') . '<div>');
				}
			}
        } else {
            return false;
		}
    }
}
