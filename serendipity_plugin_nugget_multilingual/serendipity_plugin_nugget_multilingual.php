<?php # $Id: serendipity_plugin_nugget_multilingual.php,v 1.8 2006/12/01 09:00:55 garvinhicking Exp $


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_plugin_nugget_multilingual extends serendipity_plugin {
    var $title = PLUGIN_NUGGET_MULTI_NAME;

    function introspect(&$propbag)
    {
        $this->title = $this->get_config('title', $this->title);
        $propbag->add('name',          PLUGIN_NUGGET_MULTI_NAME);
        $propbag->add('description',   PLUGIN_NUGGET_MULTI_DESC);
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Wesley Hwang-Chung');
        $propbag->add('version',       '1.6');
        $propbag->add('configuration', array('language', 'title', 'content', 'markup', 'show_where'));
        $propbag->add('groups',        array('FRONTEND_VIEWS'));

        $this->protected = TRUE; // If set to TRUE, only allows the owner of the plugin to modify its configuration
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {

        	case 'language':
        		$select = array('all' => PLUGIN_NUGGET_MULTI_ALL,
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
                $propbag->add('name',        PLUGIN_NUGGET_MULTI_LANG);
                $propbag->add('default',     'all');
        		break;

            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        TITLE);
                $propbag->add('description', TITLE_FOR_NUGGET);
                $propbag->add('default',     '');
                break;

            case 'content':
                $propbag->add('type',        'html');
                $propbag->add('name',        CONTENT);
                $propbag->add('description', THE_NUGGET);
                $propbag->add('default',     '');
                break;

            case 'markup':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        DO_MARKUP);
                $propbag->add('description', DO_MARKUP_DESCRIPTION);
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
        global $serendipity;

        $title = $this->get_config('title');
        $language = $this->get_config('language', 'all');
        $show_where = $this->get_config('show_where', 'both');
		// if the language doesn't match, do not display
		if ($language != 'all' && $serendipity['lang'] != $language) return false;
		// where to show
        if ($show_where == 'extended' && (!isset($serendipity['GET']['id']) || !is_numeric($serendipity['GET']['id']))) {
            return false;
        } else if ($show_where == 'overview' && isset($serendipity['GET']['id']) && is_numeric($serendipity['GET']['id'])) {
            return false;
        }
		// apply markup?
        if ($this->get_config('markup', 'true') == 'true') {
            $entry = array('html_nugget' => $this->get_config('content'));
            serendipity_plugin_api::hook_event('frontend_display', $entry);
            echo $entry['html_nugget'];
        } else {
            echo $this->get_config('content');
        }

        if (serendipity_userLoggedIn()) {
            $is_plugin_owner    = ($this->serendipity_owner == $serendipity['authorid'] || serendipity_checkPermission('adminPluginsMaintainOthers'));

            if ($is_plugin_owner) {
                echo '<div class="serendipity_edit_nugget"><a href="' . $serendipity['baseURL'] . '/serendipity_admin.php?serendipity[adminModule]=plugins&amp;serendipity[plugin_to_conf]=' . htmlentities($this->instance) . '">' . EDIT . '</a></div>';
            }
        }
    }
}

?>
