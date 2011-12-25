<?php # $Id$

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}
include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_typoquote extends serendipity_event
{
    var $title = PLUGIN_EVENT_QUOTES_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_QUOTES_NAME);
        $propbag->add('description',   PLUGIN_EVENT_QUOTES_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Jonathan Spalink and Matthew Groeninger');
        $propbag->add('version',       '1.4');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('groups', array('MARKUP'));
        $propbag->add('event_hooks',   array('frontend_display' => true));

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

        $conf_array[] = 'SMARTYPANTS_INSTEAD';

        $propbag->add('configuration', $conf_array);
    }

    function install() {
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function uninstall() {
        serendipity_plugin_api::hook_event('backend_cache_purge', $this->title);
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
        case 'ENTRY_BODY':
        case 'EXTENDED_BODY':
        case 'COMMENT':
        case 'HTML_NUGGET':
            $propbag->add('type',        'boolean');
            $propbag->add('name',        constant($name));
            $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
            $propbag->add('default', 'true');
            return true;
            break;

        case 'SMARTYPANTS_INSTEAD':
            $propbag->add('type', 'boolean');
            $propbag->add('name', PLUGIN_EVENT_QUOTES_SMARTYPANTS_NAME);
            $propbag->add('description', PLUGIN_EVENT_QUOTES_SMARTYPANTS_DESC);
            $propbag->add('default', false);
            return true;
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

                if($this->get_config('SMARTYPANTS_INSTEAD', false)) {
                    include_once  dirname(__FILE__) . '/smartypants.php';
                    foreach ($this->markup_elements as $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], true)) && !empty($eventData[$temp['element']]) &&
                            !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                            !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];
                            $eventData[$element] = SmartyPants($eventData[$element]);
                        }
                    }
                } else {
                    foreach ($this->markup_elements as $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], true)) && isset($eventData[$temp['element']]) &&
                                !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                                !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];
     
                            # First find all the tags... We want to keep straight quotes in them.
                            # So we remember all the tags, and replace them temporarily
                            preg_match_all("/<[^>]*>/", $eventData[$element], $matches);
                            $count = count($matches[0]);
                            for($i = 0; $i < $count; $i++) {
                                $temp = $matches[0][$i];
                                $new  = "<!-- tag number $i -->";
                                $eventData[$element] = str_replace($temp, $new, $eventData[$element]);
                            }
   
                            # Now we perform our replacements...  All sets of quotes turned smart, then single quotes are dealt with...
                            $eventData[$element] = preg_replace("/\"(.*?)\"/",         "&#8220;\\1&#8221;", $eventData[$element]);
                            $eventData[$element] = preg_replace("/&quot;(.*?)&quot;/", "&#8220;\\1&#8221;", $eventData[$element]);
                            $eventData[$element] = preg_replace("/(?<! )' /",          "&#8217; ",          $eventData[$element]);
                            $eventData[$element] = preg_replace("/(?<! )'(?! )/",      "&#8217;",           $eventData[$element]);
                            $eventData[$element] = preg_replace("/ '(?! )/",           " &#8216;",          $eventData[$element]);

                            #Finally we add the tags back into the body of our entry.
                            for($i = 0; $i < $count; $i++) {
                                $tag_body = $matches[0][$i];
                                $old      = "<!-- tag number $i -->";
                                $eventData[$element] = str_replace($old, $tag_body, $eventData[$element]);
                            }
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

/* vim: set sts=4 ts=4 expandtab : */
?>