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

class serendipity_plugin_google_quicksearch extends serendipity_plugin {
    var $title = PLUGIN_GOOGLE_QS_NAME;

    function introspect(&$propbag)
    {
        $this->title = $this->get_config('title', $this->title);
        $propbag->add('name',          PLUGIN_GOOGLE_QS_GOOGLE . ' ' . QUICKSEARCH);
        $propbag->add('description',   SEARCH_FOR_ENTRY . ' (' . PLUGIN_GOOGLE_QS_GOOGLE . ')');
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Wesley Hwang-Chung');
        $propbag->add('version',       '1.5');
        $propbag->add('configuration', array('submit', 'adsense', 'background', 'text', 'border', 'title_s', 'faint_text', 'url', 'logo_background', 'visited_url', 'logo_place', 'logo_url', 'logo_height', 'logo_width'));
	$propbag->add('groups',        array('FRONTEND_EXTERNAL_SERVICES'));
        $this->protected = TRUE; // If set to TRUE, only allows the owner of the plugin to modify its configuration
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {

            case 'submit':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_GOOGLE_QS_SUBMIT);
                $propbag->add('default',     'false');
                break;

            case 'adsense':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GOOGLE_QS_ADSENSE);
                $propbag->add('description', PLUGIN_GOOGLE_QS_ADSENSE_DESC);
                $propbag->add('default',     '');
                break;

            case 'background':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GOOGLE_QS_BACKGROUND);
                $propbag->add('default',     'FFFFFF');
                break;

            case 'text':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GOOGLE_QS_TEXT);
                $propbag->add('default',     '000000');
                break;

            case 'border':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GOOGLE_QS_BORDER);
                $propbag->add('default',     '336699');
                break;

            case 'title_s':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GOOGLE_QS_TITLE);
                $propbag->add('default',     '0000FF');
                break;

            case 'faint_text':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GOOGLE_QS_FAINT_TEXT);
                $propbag->add('default',     '0000FF');
                break;

            case 'url':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GOOGLE_QS_URL);
                $propbag->add('default',     '008000');
                break;

            case 'logo_background':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GOOGLE_QS_LOGO_BACKGROUND);
                $propbag->add('default',     '336699');
                break;

            case 'visited_url':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GOOGLE_QS_VISITED_URL);
                $propbag->add('default',     '663399');
                break;

        	case 'logo_place':
        		$select = array('0' => PLUGIN_GOOGLE_QS_ABOVE, '1' => PLUGIN_GOOGLE_QS_LEFT);
                $propbag->add('type',        'select');
                $propbag->add('select_values', $select);
                $propbag->add('name',        PLUGIN_GOOGLE_QS_LOGO_PLACE);
                $propbag->add('default',     '0');
        		break;

            case 'logo_url':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GOOGLE_QS_LOGO_URL);
                $propbag->add('default',     '');
                break;

            case 'logo_height':
                $propbag->add('type',        'string');
                $propbag->add('name',        SORT_ORDER_HEIGHT);
                $propbag->add('default',     '');
                break;

            case 'logo_width':
                $propbag->add('type',        'string');
                $propbag->add('name',        SORT_ORDER_WIDTH);
                $propbag->add('default',     '');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        global $serendipity;

        $title = $this->title;

        /* Buffering the differences between s9y and Google language options */
        $language = $serendipity['lang'];
        $adsense = $this->get_config('adsense', '');
        switch ($language) {
            case 'zh':
            case 'cn':
                $language = 'zh-cn';
                break;
            case 'tw':
            case 'tn':
                $language = 'zh-tw';
                break;
            case 'cz':
                $language = 'cs';
                break;
            case 'is':
            case 'bg':
            case 'ro':
            case 'fa':
                $language = 'en';
                break;
        }
        /* Output search box */
        echo '<form method="get" action="http://www.google.com/custom" target="_top">';
        echo '<input type="hidden" name="domains" value="' . $serendipity['baseURL'] . '" />';
        echo '<input type="hidden" name="sitesearch" value="' . $serendipity['baseURL'] . '" />';
        echo '<input size="13" type="text" name="q" maxlength="255" value="" />';
        echo '<input type="hidden" name="client" value="' . $adsense . '" />';
        echo '<input type="hidden" name="forid" value="1" />';
        echo '<input type="hidden" name="ie" value="' . LANG_CHARSET . '" />';
        echo '<input type="hidden" name="oe" value="' . LANG_CHARSET . '" />';
        echo '<input type="hidden" name="cof" value="GALT:#' . $this->get_config('url', '008000') . ';DIV:#' . $this->get_config('border', '336699') . ';VLC:' . $this->get_config('visited_url', '663399') . ';AH:center;BGC:' . $this->get_config('background', 'FFFFFF') . ';LBGC:' . $this->get_config('logo_background', '336699') . ';ALC:' . $this->get_config('title_s', '0000FF') . ';LC:' . $this->get_config('title_s', '0000FF') . ';T:' . $this->get_config('text', '000000') . ';GFNT:' . $this->get_config('faint_text', '0000FF') . ';GIMP:' . $this->get_config('faint_text', '0000FF') . ';LH:' . $this->get_config('logo_height', '') . ';LW:' . $this->get_config('logo_width', '') . ';L:' . $this->get_config('logo_url', '') . ';';
        /* Only if AdSense ID is present... */
        if ($adsense != '') {
            echo 'S:' . $serendipity['baseURL'] . ';LP:' . $this->get_config('logo_place', '0') . ';FORID:1;GL:1;';
        }
        echo '" />';
        echo '<input type="hidden" name="hl" value="' . $language . '" />';
        if ($this->get_config('submit', 'false') == 'true') {
            echo '<input type="submit" name="submit" value="' . GO . '" size="4" />';
        }
        echo '</form>';
    }
}

?>
