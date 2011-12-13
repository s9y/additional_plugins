<?php # $Id: serendipity_event_glossary.php,v 1.3 2005/06/14 Rob Antonishen
/* By Rob Antonishen */
/* Copied in chunks from the s9y markup plugin */
/* and the Highlight Search Queries plugin by Tom Sommer */
/* Change log:
   v1.3: Added support for appending a superscripted [?] versus highlighting
         Added support for markup of only the first instance of the term
         removed the "no decoration" flag from the default css
         made consistant with new probe for language include
*/


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_glossary extends serendipity_event
{
    var $title = PLUGIN_EVENT_GLOSSARY_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_GLOSSARY_NAME);
        $propbag->add('description',   PLUGIN_EVENT_GLOSSARY_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author', 'Rob Antonishen');
        $propbag->add('version', '1.6');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('groups', array('MARKUP'));
        $propbag->add('event_hooks',   array('frontend_display' => true, 'css' => true));

        /* standard markup elements, except comments */
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
              'name'     => 'HTML_NUGGET',
              'element'  => 'html_nugget',
            )
        );

        $conf_array = array();

        /* Add the plugin specific ones at the top */
        $conf_array[] = 'separator';
        $conf_array[] = 'type';
        $conf_array[] = 'markall';
        $conf_array[] = 'list';
        foreach($this->markup_elements as $element) {
            $conf_array[] = $element['name'];
        }

        $propbag->add('configuration', $conf_array);
    }

    function install() {
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function uninstall() {
        serendipity_plugin_api::hook_event('backend_cache_purge', $this->title);
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    /* the standard thing */
    function generate_content(&$title) {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'separator':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_GLOSSARY_SEP);
                $propbag->add('description', PLUGIN_EVENT_GLOSSARY_SEP_BLAHBLAH);
                $propbag->add('default',     ':');
                break;

            case 'list':
                $propbag->add('type',        'text');
                $propbag->add('name',        PLUGIN_EVENT_GLOSSARY_LIST);
                $propbag->add('description', PLUGIN_EVENT_GLOSSARY_LIST_BLAHBLAH);
                $propbag->add('default',     "xyzzy:Test Abbreviation\nplugin:Something that plugs in");
                break;

            case 'type':
                $propbag->add('type',          'radio');
                $propbag->add('name',          PLUGIN_EVENT_GLOSSARY_TYPE);
                $propbag->add('description',   PLUGIN_EVENT_GLOSSARY_TYPE_BLAHBLAH);
                $propbag->add('radio',         array(
                    'value' => array('HILITE', 'APPEND'),
                    'desc'  => array(PLUGIN_EVENT_GLOSSARY_TYPE_HILITE, PLUGIN_EVENT_GLOSSARY_TYPE_APPEND)
                ));
                $propbag->add('radio_per_row', '1');
                $propbag->add('default', 'HILITE');
                break;

            case 'markall':
                $propbag->add('type','boolean');
                $propbag->add('name', PLUGIN_EVENT_GLOSSARY_MARKALL);
                $propbag->add('description', PLUGIN_EVENT_GLOSSARY_MARKALL_BLAHBLAH);
                $propbag->add('default', 'false');
                break;

            default:
                $propbag->add('type',        'boolean');
                $propbag->add('name',        constant($name));
                $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
                $propbag->add('default', 'true');
                break;
        }

        return true;
    }


    function event_hook($event, &$bag, &$eventData) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_display':

                    /* Parse the glossary list into two arrays and clean up*/
                    $terms = array();

                    $lines = explode("\n", $this->get_config('list'));

                    foreach($lines as $line) {
		    	$temp = explode($this->get_config('separator',':'), $line);
   	                $s = trim($temp[0]);
   	                $r = trim($temp[1]);
   	                if ((strlen($s) > 0) && ctype_alnum($s) && (strlen($r) > 0)){
   	                    $terms[] = array($s,htmlspecialchars($r));
   	                }
		    }

                    /* go through markup elements and call the markup function if there are terms*/
                    if (count($terms) > 0) {
                        foreach ($this->markup_elements as $temp) {
                            if (serendipity_db_bool($this->get_config($temp['name'], true)) && isset($eventData[$temp['element']]) &&
                            !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                            !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                                $element = $temp['element'];
                                $eventData[$element] = $this->_glossary_markup($eventData[$element], $terms);
                            }
                        }
                    }
                    return true;
                    break;

                case 'css':

                    /* If the user hasn't added a CSS Class called serendipity_glossaryMarkup, we add a pretty one for him */
                    if ( strstr($eventData, '.serendipity_glossaryMarkup') === false ) {
                        $eventData .= "\n";
                        $eventData .= '.serendipity_glossaryMarkup {' . "\n";
                        $eventData .= '    color: #9F141A;' . "\n";
                        $eventData .= '    cursor: help;' . "\n";
                        $eventData .= '}' . "\n";
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

    function _glossary_markup($text,$glossarylist) {

        foreach ($glossarylist as $glossaryitem) {
            /* If the data contains HTML tags, we have to be careful not to break URIs and use a more complex preg */
            if ( preg_match('/\<.+\>/', $text) ) {
                $_pattern =  '/(?!<.*?)(\b'. preg_quote($glossaryitem[0], '/') .'\b)(?![^<>]*?>)/m';
            } else {
                $_pattern = '/(\b'. preg_quote($glossaryitem[0], '/') .'\b)/m';
            }

            if (serendipity_db_bool($this->get_config('markall',false))) {
                if ($this->get_config('type')=='HILITE') {
                    $text = preg_replace($_pattern, '<span title="' . $glossaryitem[1] . '" class="serendipity_glossaryMarkup">$1</span>', $text);
                } else { /* 'APPEND' */
                    $text = preg_replace($_pattern, '$1<sup><span title="' . $glossaryitem[1] . '" class="serendipity_glossaryMarkup">[?]</span></sup>', $text);
                }
            } else {
                if ($this->get_config('type')=='HILITE') {
                    $text = preg_replace($_pattern, '<span title="' . $glossaryitem[1] . '" class="serendipity_glossaryMarkup">$1</span>', $text, 1);
                } else { /* 'APPEND' */
                    $text = preg_replace($_pattern, '$1<sup><span title="' . $glossaryitem[1] . '" class="serendipity_glossaryMarkup">[?]</span></sup>', $text, 1);
                }
            }
        }
        return $text;

    }


}

/* vim: set sts=4 ts=4 expandtab : */
?>
