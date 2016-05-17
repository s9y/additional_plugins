<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Load possible language files.
@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_smartymarkup extends serendipity_event
{
    var $title     = PLUGIN_EVENT_SMARTYMARKUP_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_SMARTYMARKUP_NAME);
        $propbag->add('description',   PLUGIN_EVENT_SMARTYMARKUP_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('version',       '1.14');
        $propbag->add('requirements',  array(
            'serendipity' => '1.7',
            'smarty'      => '3.1.0',
            'php'         => '5.2.0'
        ));
        $propbag->add('groups', array('MARKUP'));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks', array('frontend_display' => true));

        if (!defined('STATICPAGE')) {
            @define('STATICPAGE', 'Staticpage');
        }

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
            ),
            array(
              'name'     => 'STATICPAGE',
              'element'  => 'staticpage',
            )
        );

        $conf_array = array();
        foreach($this->markup_elements as $element) {
            $conf_array[] = $element['name'];
        }
        $propbag->add('configuration', $conf_array);
    }

    function install()
    {
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function uninstall(&$propbag)
    {
        serendipity_plugin_api::hook_event('backend_cache_purge', $this->title);
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag)
    {
        $propbag->add('type',        'boolean');
        $propbag->add('name',        constant($name));
        $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)) . ($name == 'COMMENT' ? PLUGIN_EVENT_SMARTYMARKUP_WARN : ''));
        $propbag->add('default',     ($name == 'COMMENT' ? 'false' : 'true'));
        return true;
    }

    function smarty_resource_smartymarkupplugin_template($tpl_name, &$tpl_source)
    {
        global $serendipity;

        // return the template content via referenced argument 
        $tpl_source = $serendipity['plugindata']['smartymarkupplugin'];

        // test
        #$tpl_source = '{assign var="foo" value="bar"}{$foo|escape:"html"}'; 

        // return success state 
        return true;
    }

    function smarty_resource_smartymarkupplugin_timestamp($tpl_name, &$tpl_timestamp)
    {
        global $serendipity;

        $tpl_timestamp = crc32($serendipity['plugindata']['smartymarkupplugin']);
        return true;
    }

    function smarty_resource_smartymarkupplugin_secure($tpl_name)
    {
        return true;
    }

    function smarty_resource_smartymarkupplugin_trusted($tpl_name)
    {
    }

    function smartymarkup($input, &$eventData)
    {
        global $serendipity;

        if (!isset($serendipity['smarty'])) {
            serendipity_smarty_init();
        }

        if (!isset($serendipity['plugindata']['smartymarkupplugin'])) {
            $serendipity['smarty']->registerResource("smartymarkupplugin", array(
                                       array( $this, "smarty_resource_smartymarkupplugin_template" ),
                                       array( $this, "smarty_resource_smartymarkupplugin_timestamp" ),
                                       array( $this, "smarty_resource_smartymarkupplugin_secure" ),
                                       array( $this, "smarty_resource_smartymarkupplugin_trusted" )));
        }

        $serendipity['plugindata']['smartymarkupplugin'] =& $input;
        $serendipity['smarty']->assign('smartymarkup_eventData', $eventData);

        // avoid non existing or empty template fetch calls
        if (isset($serendipity['plugindata']['smartymarkupplugin']) && !empty($serendipity['plugindata']['smartymarkupplugin'])) {
            return $serendipity['smarty']->fetch('smartymarkupplugin:' . crc32($serendipity['plugindata']['smartymarkupplugin']));
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData=null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {

                case 'frontend_display':

                    if ($_GET['serendipity']['is_iframe'] == 'true' && $_GET['serendipity']['iframe_mode'] == 'save') {
                        // Due to strange errors passing by with an unregistered function at this point,
                        // eg. giving a 'Fatal error:  Call to undefined function staticpage_display()',
                        // we disable this in Serendipity iframe preview saving mode.
                        // $serendipity['GET'] is not available too
                        // This also disables the preview on saving, which is not a need and might confuse here
                        return;
                    }

                    foreach ($this->markup_elements as $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], true)) && isset($eventData[$temp['element']]) &&
                            !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                            !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance]))
                        {

                            if (isset($eventData['ctitle']) && $temp['element'] == 'body') {
                                // s9y doesn't properly distinct between BODY and COMMENT fields and could be executed for both.
                                // Skip this case. If comment-smarty markup should be enabled, it will be handled by the 'comment'
                                // element case.
                                continue;
                            }

                            if (isset($eventData['staticpage']) && $temp['element'] == 'body') {
                                // Skip applying markup to a staticpage content, because
                                // it's already done for the "staticpage" element instead
                                // of "body".
                                continue;
                            }
                            // This matches CKEDITOR codesnippet and Googles prettyprint highlight markup
                            // ToDo: enhance to match only when it finds {$foo} and {word_boundary patterns ...} in it
                            $regex = '/(<(pre|code)\s+[^>]*?class\s*?=\s*?["|\'].*?(prettyprint|language-).*?["|\'].*?>)(.*?)(<\/(code|pre)>)/si';
                            if (isset($eventData['body']) && preg_match($regex, $eventData['body']) ||
                                isset($eventData['extended']) && preg_match($regex, $eventData['extended']) ||
                                isset($eventData['staticpage']) && preg_match($regex, $eventData['staticpage'])) {
                                // Skip parsing when entry has code highlighter blocks,
                                // which are show-code only, set by CKEDITOR codesnippet plugin.
                                // This should work for other highlighters too,
                                // since this pattern is a common usage for marking syntax code.
                                // Do not use both in entries: Smarty parsing and Coding Blocks with Smarty!
                                // Default to skip are code highlighter blocks.
                                continue;
                            }
                            if (isset($eventData['body']) && preg_match('@\[\[\{\$@', $eventData['body']) ||
                                isset($eventData['extended']) && preg_match('@\[\[\{\$@', $eventData['extended']) ||
                                isset($eventData['staticpage']) && preg_match('@\[\[\{\$@', $eventData['staticpage'])) {
                                // Do not parse content with WP-Smarty like executors eg [[{$foo}]]
                                // set by a possible future plugin...
                                continue;
                            }
                            if (isset($eventData['body']) && preg_match('@{{!@', $eventData['body']) ||
                                isset($eventData['extended']) && preg_match('@{{!@', $eventData['extended']) ||
                                isset($eventData['staticpage']) && preg_match('@{{!@', $eventData['staticpage'])) {
                                // Do not parse content with multilanguage tags
                                // set by the multilingual plugin.
                                // Do not use both in entries: Smarty parsing and multilingual tags!
                                // Default to skip is tag multilingual.
                                continue;
                            }

                            $element = $temp['element'];
                            try {
                                $eventData[$element] = $this->smartymarkup($eventData[$element], $eventData);
                            } catch (Exception $e) {
                                echo '<span class="msg-error"><span class="icon-attention-circled"></span> ' . ERROR_SOMETHING . ': '.$e->getMessage() . "</span>\n";
                            }
                            if ($element == 'staticpage') {
                                $eventData['markup_staticpage'] = true;
                            }
                        }
                    }
                    break;

                default:
                    return false;
            }
            return true;
        } else {
            return false;
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>