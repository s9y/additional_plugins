<?php # $Id$


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_wordwrap extends serendipity_event
{
    var $title = PLUGIN_EVENT_WORDWRAP_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_WORDWRAP_NAME);
        $propbag->add('description',   PLUGIN_EVENT_WORDWRAP_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('version',       '1.03');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',   array('frontend_display' => true));
        $propbag->add('groups', array('MARKUP'));

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
        $conf_array[] = 'length';
        $conf_array[] = 'char';
        $conf_array[] = 'hardbreak';
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
            case 'char':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_WORDWRAP_CHAR);
                $propbag->add('description', '');
                $propbag->add('default',     '\n');
                return true;

            case 'length':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_WORDWRAP_CHARS);
                $propbag->add('description', '');
                $propbag->add('default',     '120');
                return true;

            case 'hardbreak':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_WORDWRAP_HARDBREAK);
                $propbag->add('description', '');
                $propbag->add('default',     false);
                return true;

            default:
                $propbag->add('type',        'boolean');
                $propbag->add('name',        constant($name));
                $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
                $propbag->add('default', 'true');
                return true;
        }
    }

    function event_hook($event, &$bag, &$eventData) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
              case 'frontend_display':

                $char = str_replace(
                    array(
                        '\n',
                        '\r',
                        '\t'
                    ),

                    array(
                        "\n",
                        "\r",
                        "\t"
                    ),

                    $this->get_config('char')
                );

                foreach ($this->markup_elements as $temp) {
                    if (serendipity_db_bool($this->get_config($temp['name'], true)) && isset($eventData[$temp['element']]) &&
                            !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                            !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                        $element = $temp['element'];
                        $eventData[$element] = wordwrap($eventData[$element], $this->get_config('length'), $char, $this->get_config('hardbreak'));
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
