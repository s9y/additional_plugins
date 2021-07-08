<?php # 

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_tooltips extends serendipity_event
{
    var $title = PLUGIN_EVENT_TOOLTIPS_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_TOOLTIPS_NAME);
        $propbag->add('description',   PLUGIN_EVENT_TOOLTIPS_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Enrico Stahn');
        $propbag->add('version',       '1.6');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',   array(
            'frontend_header' => true,
            'frontend_footer' => true,
            'frontend_display' => true));
        $propbag->add('groups',   array('BACKEND_EDITOR', 'MARKUP'));

        $this->markup_elements = array(
            array(
              'name'     => 'ENTRY_BODY',
              'element'  => 'body',
            ),
            array(
              'name'     => 'EXTENDED_BODY',
              'element'  => 'extended',
            ),
            array(
              'name'     => 'COMMENT',
              'element'  => 'comment',
            ),
            array(
              'name'     => 'HTML_NUGGET',
              'element'  => 'html_nugget',
            )
        );
        $conf_array = array();
        foreach($this->markup_elements as $element) {
            $conf_array[] = $element['name'];
        }
        $conf_array[] = 'seperator';
        $conf_array[] = 'replacewithtag';
        $conf_array[] = 'fullimages';
        $conf_array[] = 'tooltipstag';
        $conf_array[] = 'cleanup';
        $conf_array[] = 'seperator';
        $conf_array[] = 'bgcolor';
        $conf_array[] = 'fgcolor';
        $conf_array[] = 'textcolor';
        $propbag->add('configuration', $conf_array);
    }

    function introspect_config_item($name, &$propbag) {
        switch ($name) {
            case 'fullimages' :
                $propbag->add('name', PLUGIN_EVENT_TOOLTIPS_FULLIMAGES_NAME);
                $propbag->add('type', 'boolean');
                $propbag->add('description', PLUGIN_EVENT_TOOLTIPS_FULLIMAGES_DESC);
                $propbag->add('default', 'true');
                break;
            case 'replacewithtag' :
                $propbag->add('name', PLUGIN_EVENT_TOOLTIPS_REPLACEWITHTAG_NAME);
                $propbag->add('type', 'select');
                $propbag->add('description', PLUGIN_EVENT_TOOLTIPS_REPLACEWITHTAG_DESC);
                $propbag->add('default', 'a');
                $propbag->add('select_values', array('a' => PLUGIN_EVENT_TOOLTIPS_REPLACEWITHTAG_A, 'acronym' => PLUGIN_EVENT_TOOLTIPS_REPLACEWITHTAG_ACRONYM));
                 break;
            case 'tooltipstag' :
                $propbag->add('name', PLUGIN_EVENT_TOOLTIPS_TOOLTIPSTAG_NAME);
                $propbag->add('type', 'boolean');
                $propbag->add('description', PLUGIN_EVENT_TOOLTIPS_TOOLTIPSTAG_DESC);
                $propbag->add('default', 'true');
                break;
            case 'cleanup' :
                $propbag->add('name', PLUGIN_EVENT_TOOLTIPS_CLEANUP_NAME);
                $propbag->add('type', 'boolean');
                $propbag->add('description', PLUGIN_EVENT_TOOLTIPS_CLEANUP_DESC);
                $propbag->add('default', 'true');
                break;
            case 'bgcolor' :
                $propbag->add('name', PLUGIN_EVENT_TOOLTIPS_BGCOLOR_NAME);
                $propbag->add('type', 'string');
                $propbag->add('description', PLUGIN_EVENT_TOOLTIPS_BGCOLOR_DESC);
                $propbag->add('default', '#000000');
                break;
            case 'fgcolor' :
                $propbag->add('name', PLUGIN_EVENT_TOOLTIPS_FGCOLOR_NAME);
                $propbag->add('type', 'string');
                $propbag->add('description', PLUGIN_EVENT_TOOLTIPS_FGCOLOR_DESC);
                $propbag->add('default', '#eeeeee');
                break;
            case 'textcolor' :
                $propbag->add('name', PLUGIN_EVENT_TOOLTIPS_TEXTCOLOR_NAME);
                $propbag->add('type', 'string');
                $propbag->add('description', PLUGIN_EVENT_TOOLTIPS_TEXTCOLOR_DESC);
                $propbag->add('default', '#000000');
                break;
            case 'seperator' :
                $propbag->add('name', $name);
                $propbag->add('type', 'seperator');
                $propbag->add('description', '');
                $propbag->add('default', 'false');
                 break;
            default :
                $propbag->add('name',        constant($name));
                $propbag->add('type',        'boolean');
                $propbag->add('default',     'true');
                $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
        }
        return true;
    }

    function install() {
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function uninstall(&$propbag) {
        serendipity_plugin_api::hook_event('backend_cache_purge', $this->title);
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function overlibconfig()
    {
        $cfgitems = array('bgcolor', 'fgcolor', 'textcolor');

        $cfg = '<script type="text/javascript">'."\n";
        $cfg.= '<!--'."\n";

        for ($i = 0, $iMax = count($cfgitems); $i < $iMax; $i++) {
            $value = $this->get_config($cfgitems[$i]);

            if (empty($value)) {
                continue;
            }

            $cfg.= 'var ol_'.$cfgitems[$i].'=\''.$value.'\';'."\n";
        }

        $cfg.= '//-->';
        $cfg.= '</script>';

        return $cfg;
    }

    function config_fullimages($element)
    {
        global $serendipity;

        // Search all thumbnails with links
        preg_match_all('/<'.$this->get_config('replacewithtag').'.*?>.*?<img.*?src=["|\'].*?\.'.preg_quote($serendipity['thumbSuffix']).'\..*?>.*?<\/'.$this->get_config('replacewithtag').'>/i', $element, $matches);

        if (isset($matches[0])) {
            for ($i = 0, $iMax = count($matches[0]); $i < $iMax; $i++) {
                // dont touch links that have an onmouseover or onmouseout attribute
                // and add tooltips to all other links
                if (preg_match('/<'.$this->get_config('replacewithtag').'.*?(onmouseover=|onmouseout=).*?>/i', $matches[0][$i])) {
                    $result = preg_replace_callback('/(<'.$this->get_config('replacewithtag').'.*?>.*?<img.*?src=["|\'].*?\.'.preg_quote($serendipity['thumbSuffix']).'\..*?)(["|\'])(.*?>)/i', 'tooltips_replace1', $matches[0][$i]);
                } else {
                    $result = preg_replace_callback('/(<'.$this->get_config('replacewithtag').'.*?)(>.*?<img.*?src=["|\'])(.*?\.'.preg_quote($serendipity['thumbSuffix']).'\..*?)(["|\'])(.*?>)/i', 'tooltips_replace2', $matches[0][$i]);
                }
                $element = str_replace($matches[0][$i], $result, $element);
            }
        }

        // Search all thumbnails without links
        preg_match_all('/<img.*?src=["|\'].*?\.'.preg_quote($serendipity['thumbSuffix']).'\..*?["|\'].*?>/i', $element, $matches);
        $GLOBALS['s9y_tooltips_replacewithtag'] = $this->get_config('replacewithtag');

        if (isset($matches[0])) {
            for ($i = 0, $iMax = count($matches[0]); $i < $iMax; $i++) {
                if (preg_match('/s9y-tooltips-haslink="yes"/i', $matches[0][$i])) {
                    continue;
                }
                $searchRegexp = '/(<img.*?src=["|\'])(.*?\.'.preg_quote($serendipity['thumbSuffix']).'\..*?)(["|\'].*?>)/i';
                $result = preg_replace_callback($searchRegexp, 'tooltips_replace3', $matches[0][$i]);
                $element = str_replace($matches[0][$i], $result, $element);
            }
        }

        return $element;
    }

    // config: size width, height ... could be auto
    // config: remove title attribute link tag
    function config_tooltipstag($element)
    {
        global $serendipity;

        preg_match_all('/<'.$this->get_config('replacewithtag').'.*?>?.*?\[s9y-tooltips .*?\].*?\[\/s9y-tooltips\].*?<\/'.$this->get_config('replacewithtag').'>/i', $element, $matches);

        if (isset($matches[0])) {
            for ($i = 0, $iMax = count($matches[0]); $i < $iMax; $i++) {
                // dont touch links that have an onmouseover or onmouseout attribute
                // and add tooltips to all other links
                if (preg_match('/<'.$this->get_config('replacewithtag').'.*?(onmouseover=|onmouseout=).*?>/i', $matches[0][$i])) {
                    $result = preg_replace_callback('/(<'.$this->get_config('replacewithtag').'.*?>.*?\[s9y-tooltips .*?)(\])/i', 'tooltips_replace4', $matches[0][$i]);
                } else {
                    $result = preg_replace_callback('/(<'.$this->get_config('replacewithtag').'.*?)(>.*?)\[s9y-tooltips (.*?)\](.*?)\[\/s9y-tooltips\]/i','tooltips_replace5', $matches[0][$i]);
                }
                $element = str_replace($matches[0][$i], $result, $element);
            }
        }

        preg_match_all('/\[s9y-tooltips .*?\].*?\[\/s9y-tooltips\]/i', $element, $matches);

        if (isset($matches[0])) {
            for ($i = 0, $iMax = count($matches[0]); $i < $iMax; $i++) {
                if (preg_match('/s9y-tooltips-haslink="yes"/i', $matches[0][$i])) {
                    continue;
                }

                $GLOBALS['s9y_tooltips_replacewithtag'] = $this->get_config('replacewithtag');

                if (preg_match('/\[s9y-tooltips .*?s9y-tooltips-replacewithtag\="(.*?)".*?\]/i', $matches[0][$i], $rwtmatches) && isset($rwtmatches[1])) {
                    $GLOBALS['s9y_tooltips_replacewithtag'] = $rwtmatches[1];
                }

                $searchRegexp = '/\[s9y-tooltips (.*?)\](.*?)\[\/s9y-tooltips\]/i';
                $result = preg_replace_callback($searchRegexp, 'tooltips_replace6', $matches[0][$i]);
                $element = str_replace($matches[0][$i], $result, $element);
            }
        }
        return $element;
    }

    function s9ytooltips_cleanup($element)
    {
        // remove uninterpreted tags
        $element = preg_replace_callback('/\[s9y-tooltips .*?\](.*?)\[\/s9y-tooltips\]/i', 'tooltips_replace7', $element);

        // remove s9y-tooltips attributes
        $element = preg_replace('/s9y-tooltips-.*?=".*?"/i', '', $element);

        return $element;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;
        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_header':
                    echo $this->overlibconfig();
                    echo '<script type="text/javascript" src="'.$serendipity['serendipityHTTPPath'].'plugins/serendipity_event_tooltips/overlib/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>';
                    break;
                case 'frontend_footer':
                    echo '<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>';
                    break;
                case 'frontend_display':
                    foreach ($this->markup_elements as $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], true)) && isset($eventData[$temp['element']]) &&
                            !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                            !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = &$eventData[$temp['element']];

                            if (serendipity_db_bool($this->get_config('fullimages', true))) {
                                $element = $this->config_fullimages($element);
                            }
                            if (serendipity_db_bool($this->get_config('tooltipstag', true))) {
                                $element = $this->config_tooltipstag($element);
                            }

                            if (serendipity_db_bool($this->get_config('cleanup', true))) {
                                $element = $this->s9ytooltips_cleanup($element);
                            }
                        }
                    }
                    return true;
                    break;

              default:
                return false;
            }
        } else {
            return false;
        }
    }

}

// GH: I don't think this really works properly, it previously used the "e" preg_replace modifier and was a mess to begin with ;-)
function tooltips_replace1($matches) {
    return stripslashes($matches[1]) . stripslashes($matches[2]) . ' s9y-tooltips-haslink=\"yes\" s9y-tooltips-hastooltip=\"no\" '.stripslashes($matches[3]);
}

function tooltips_replace2($matches) {
    global $serendipity;
    return stripslashes($matches[1]) . ' onmouseover=\"return overlib(\'<img src='.str_replace(preg_quote($serendipity['thumbSuffix']), '', $matches[3]) .'>\', WIDTH, 1, HEIGHT, 1);\" onmouseout=\"return nd();\" ' . stripslashes($matches[2]) . stripslashes($matches[3]) . stripslashes($matches[4]) . ' s9y-tooltips-haslink=\"yes\" s9y-tooltips-hastooltip=\"yes\" ' . stripslashes($matches[5]);
}

function tooltips_replace3($matches) {
     return "<" . $GLOBALS['s9y_tooltips_replacewithtag'] . ' href=\"javascript:void(0);\" onmouseover=\"return overlib(\'<img src='.str_replace(preg_quote($serendipity['thumbSuffix']), '', $matches[2]) . '>\', WIDTH, 1, HEIGHT, 1);\" onmouseout=\"return nd();\">' . stripslashes($matches[1]) . stripslashes($matches[2]) . stripslashes($matches[3]).'</' . $GLOBALS['s9y_tooltips_replacewithtag'] . '>';
}

function tooltips_replace4($matches) {
    return stripslashes($matches[1]) . ' s9y-tooltips-haslink=\"yes\" s9y-tooltips-hastooltip=\"no\" ' . stripslashes($matches[2]) . stripslashes($matches[3]);
}

function tooltips_replace5($matches) {
     return stripslashes($matches[1]) . ' onmouseover=\"return overlib(\'' . $matches[3] . '\', WIDTH, 1, HEIGHT, 1);\" onmouseout=\"return nd();\" s9y-tooltips-haslink=\"yes\" s9y-tooltips-hastooltip=\"yes\" '.stripslashes($matches[2]) . stripslashes($matches[4]);
}

function tooltips_replace6($matches) {
    return "<".$GLOBALS['s9y_tooltips_replacewithtag']." href=\"javascript:void(0);\" onmouseover=\"return overlib('" . stripslashes($matches[1]) . "');\" onmouseout=\"return nd();\">" . stripslashes($matches[2]) . "</".$GLOBALS['s9y_tooltips_replacewithtag'].">";
}

function tooltips_replace7($matches) {
    return stripslashes($matches[1]);
}


/* vim: set sts=4 ts=4 expandtab : */
