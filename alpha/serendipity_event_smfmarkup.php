<?php # 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

@include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_smfmarkup extends serendipity_event
{
    var $title = 'SMF Markup';
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          'SMF Markup');
        $propbag->add('description',   'SMF Markup');
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('version',       '1.01');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',   array('frontend_display' => true, 'frontend_comment' => true, 'css' => true));
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
        $propbag->add('configuration', $conf_array);
    }

    function generate_content(&$title) {
        $title = $this->title;
    }


    function introspect_config_item($name, &$propbag) {
        switch($name) {
            default:
                $propbag->add('type',        'boolean');
                $propbag->add('name',        constant($name));
                $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
                $propbag->add('default', 'true');
                break;
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

    function callback($matches) {
        $alt = $align = '';
        
        if (preg_match('@align=(right|left)@imsU', $matches[1], $m)) {
            $align = $m[1];
        }
        
        if (preg_match('@alt=(.)@imsU', $matches[1], $m)) {
            $alt = $alt;
        }
        
        return '<img style="padding: 5px" src="' . $matches[2] . '" alt="' . htmlspecialchars($alt) . '" align="' . $align . '" />';

    }

    function smfcode($input) {
        $input = preg_replace_callback('@\[img(.*)\]([^\[]+)\[/img\]@imsU', array($this, 'callback'), $input);

        $input = preg_replace('@[^"\'\]\[](https?://[^\s"\'\]\[]+)[\s"\'\]\[$]@imsU', '<a href="\1">\1</a>', $input);

        $input = preg_replace('@\[flash=([0-9]+),([0-9]+)\](.+)\[/flash\]@imsU', '<br />
        <embed type="application/x-shockwave-flash" src="\3" width="\1" height="\2" play="true" loop="true" quality="high" AllowScriptAccess="never" />
        <noembed>
        <a href="\3" target="_blank">\3
        </noembed>
        ', $input);

        return $input;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_display':

                    foreach ($this->markup_elements as $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], true)) && isset($eventData[$temp['element']]) &&
                            !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                            !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];
                            $eventData[$element] = $this->smfcode($eventData[$element]);
                        }
                    }
                    return true;
                    break;

                case 'frontend_comment':
                    return true;
                    break;

                case 'css':
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
