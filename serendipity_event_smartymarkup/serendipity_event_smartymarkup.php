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

function smarty_resource_smartymarkupplugin_template($tpl_name, &$tpl_source, &$smarty) {
    global $serendipity;

    $tpl_source = $serendipity['PLUGINDATA']['smartymarkupplugin'];
    return true;
}

function smarty_resource_smartymarkupplugin_timestamp($tpl_name, &$tpl_timestamp, &$smarty) {
    global $serendipity;

    $tpl_timestamp = crc32($serendipity['PLUGINDATA']['smartymarkupplugin']);
    return true;
}

function smarty_resource_smartymarkupplugin_secure($tpl_name, &$smarty) {
    return true;
}

function smarty_resource_smartymarkupplugin_trusted($tpl_name, &$smarty) {
}

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
        $propbag->add('version',       '1.10');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('MARKUP'));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',   array('frontend_display' => true));

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
        $propbag->add('type',        'boolean');
        $propbag->add('name',        constant($name));
        $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)) . ($name == 'COMMENT' ? PLUGIN_EVENT_SMARTYMARKUP_WARN : ''));
        $propbag->add('default', ($name == 'COMMENT' ? 'false' : 'true'));
        return true;
    }

    function smarty_resource_smartymarkupplugin_template($tpl_name, &$tpl_source, $smarty) {
        global $serendipity;

        // return the template content via referenced argument 
        $tpl_source = $serendipity['PLUGINDATA']['smartymarkupplugin'];

        // test
        #$tpl_source = '{assign var="foo" value="bar"}{$foo|escape:"html"}'; 

        // return success state 
        return true;
    }

    function smarty_resource_smartymarkupplugin_timestamp($tpl_name, &$tpl_timestamp, $smarty) {
        global $serendipity;

        $tpl_timestamp = crc32($serendipity['PLUGINDATA']['smartymarkupplugin']);
        return true;
    }

    function smarty_resource_smartymarkupplugin_secure($tpl_name, $smarty) {
        return true;
    }

    function smarty_resource_smartymarkupplugin_trusted($tpl_name, $smarty) {
    }

    function smartymarkup($input, &$eventData) {
        global $serendipity;

        if (!isset($serendipity['smarty'])) {
            serendipity_smarty_init();
        }

        if (!isset($serendipity['PLUGINDATA']['smartymarkupplugin'])) {
            if( !defined('Smarty::SMARTY_VERSION') ) {
                $serendipity['smarty']->register_resource("smartymarkupplugin", array(
                                       "smarty_resource_smartymarkupplugin_template",
                                       "smarty_resource_smartymarkupplugin_timestamp",
                                       "smarty_resource_smartymarkupplugin_secure",
                                       "smarty_resource_smartymarkupplugin_trusted"));
            } else {
                // Smarty 3.1 >=
                $serendipity['smarty']->registerResource("smartymarkupplugin", array(
                                       array( $this, "smarty_resource_smartymarkupplugin_template" ),
                                       array( $this, "smarty_resource_smartymarkupplugin_timestamp" ),
                                       array( $this, "smarty_resource_smartymarkupplugin_secure" ),
                                       array( $this, "smarty_resource_smartymarkupplugin_trusted" )));
            }
        }

        $serendipity['PLUGINDATA']['smartymarkupplugin'] =& $input;
        $serendipity['smarty']->assign('smartymarkup_eventData', $eventData);

        // avoid non existing or empty template fetch calls
        if(isset($serendipity['PLUGINDATA']['smartymarkupplugin']) && !empty($serendipity['PLUGINDATA']['smartymarkupplugin'])) {
            return $serendipity['smarty']->fetch('smartymarkupplugin:' . crc32($serendipity['PLUGINDATA']['smartymarkupplugin']));
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData=null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
              case 'frontend_display':

                foreach ($this->markup_elements as $temp) {
                    if (serendipity_db_bool($this->get_config($temp['name'], true)) && isset($eventData[$temp['element']]) &&
                            !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                            !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {

                        if (isset($eventData['ctitle']) && $temp['element'] == 'body') {
                            // s9y doesn't properly distinct between BODY and COMMENT fields and could be executed for both.
                            // Skip this case. If comment-smarty markup should be enabled, it will be handled by the 'comment'
                            // element case.
                            continue;
                        }
                        
                        if (isset($eventData['staticpage']) && $temp['element'] == 'body') {
                            // Skip applying markup to a staticpage content, because
                            // it's already done for the "staticpage" element instead
                            // of "body"
                            continue;
                        }

                        $element = $temp['element'];
                        $eventData[$element] = $this->smartymarkup($eventData[$element], $eventData);
                        if ($element == 'staticpage') {
                            $eventData['markup_staticpage'] = true;
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