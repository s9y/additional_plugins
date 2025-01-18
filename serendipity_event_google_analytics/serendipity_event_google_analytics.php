<?php
if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_google_analytics extends serendipity_event
{
    var $title = PLUGIN_EVENT_GOOGLE_ANALYTICS_NAME;

    // Docs:
    // - Install Google Tag Manager for web pages: https://developers.google.com/tag-platform/tag-manager/web
    // - [GA4] Enhanced measurement events: https://support.google.com/analytics/answer/9216061
    // - The data layer: https://developers.google.com/tag-platform/tag-manager/web/datalayer

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_NAME);
        $propbag->add('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_DESC);
        $propbag->add('stackable', false);
        $propbag->add('author', 'Jari Turkia, kleinerChemiker');
        $propbag->add('version', '2.0.1');
        $propbag->add('requirements', array('serendipity' => '2.4', 'smarty' => '3.1.0', 'php' => '8.0.0'));
        $propbag->add('groups', array('STATISTICS'));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks', array(
            'frontend_header' => true,
            'frontend_display' => true
        ));

        # Base values
        $conf_array = array();
        $conf_array[] = 'analytics_measurement_id';
        $conf_array[] = 'analytics_track_external';

        # Blog entry element parts for external tracking
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
            )
        );
        foreach($this->markup_elements as $element) {
            $conf_array[] = $element['name'];
        }

        $propbag->add('configuration', $conf_array);
    }

    function introspect_config_item($name, &$propbag)
    {
        switch ($name) {
            case 'analytics_measurement_id' :
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_STREAM_NUMBER);
                $propbag->add('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_STREAM_NUMBER_DESC);
                $propbag->add('validate', '/^G-[0-9A-Z]+$/');
                $propbag->add('default', '');
                break;

            case 'analytics_track_external' :
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_EXTERNAL);
                $propbag->add('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_EXTERNAL_DESC);
                $propbag->add('default', 'true');
                break;

            default :
                $propbag->add('type', 'boolean');
                $propbag->add('name', sprintf(PLUGIN_EVENT_GOOGLE_ANALYTICS_APPLY_TRACKING_TO, constant($name)));
                $propbag->add('description', sprintf(PLUGIN_EVENT_GOOGLE_ANALYTICS_APPLY_TRACKING_TO_DESC, constant($name)));
                $propbag->add('default', 'true');
        }
        return true;
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

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;
        static $analytics_track_external = null;
        static $usergroup = false;
        $hooks = &$bag->get('event_hooks');

        if ($analytics_track_external === null) {
            $analytics_track_external = serendipity_db_bool($this->get_config('analytics_track_external', true));
        }

        if (!isset($hooks[$event])) {
            return false;
        }

        $acctNro = $this->get_config('analytics_measurement_id');
        if (!isset($acctNro) || !$acctNro) {
            return false;
        }

        switch ($event) {
            case 'frontend_header' :
                if (!isset($serendipity['authorid']) || $serendipity['authorid'] === null) {
                    print <<<EOT
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async="" src="https://www.googletagmanager.com/gtag/js?id={$acctNro}"></script>
<script>
(([w, dataLayerName, streamId] = [window, 'dataLayer', '{$acctNro}']) => {
    w[dataLayerName] = w[dataLayerName] || [];
    function gtag() {
        w[dataLayerName].push(arguments);
    }
    gtag('js', new Date());
    gtag('config', streamId);
})()
</script>
EOT;
                }

                return true;

            case 'frontend_display' :
                if (isset($serendipity['authorid']) && $serendipity['authorid'] && $usergroup !== false) {
                    return true;
                }
                if (!$analytics_track_external) {
                    return true;
                }

                foreach ($this->markup_elements as $element) {
                    $elementEnabled = serendipity_db_bool($this->get_config($element['name'], true));
                    $elementHasData = isset($eventData[$element['element']]);
                    $markupDisabledConfig = isset($eventData['properties']['ep_disable_markup_' . $this->instance]) && $eventData['properties']['ep_disable_markup_' . $this->instance];
                    $markupDisabledPost = isset($serendipity['POST']['properties']['disable_markup_' . $this->instance]);
                    if ($elementEnabled && $elementHasData &&
                        !$markupDisabledConfig && !$markupDisabledPost) {
                        $element = $element['element'];
                        $eventData[$element] = preg_replace_callback(
                            "#<a\\s+(.*)href\\s*=\\s*[\"|'](http://|https://|)([^\"']*)[\"|']([^>]*)>#isUm",
                            array($this, 'analytics_tracker_callback'),
                            $eventData[$element]
                        );
                    }
                }
                return true;

            default:
                return false;
        } // end switch ($event) {
    }

    /**
     * matches:
     * 0 = entire regexp match
     * 1 = anything between "<a" and "href"
     * 2 = scheme
     * 3 = address
     * 4 = anything after "href" and ">"
     */
    function analytics_tracker_callback($matches)
    {
        $parsed_url = parse_url($matches[2].$matches[3]);

        // Skip tracking for local URLs without scheme, or unknown scheme.
        if (!isset($parsed_url["scheme"]))
            return $matches[0];
        if (!in_array($parsed_url["scheme"], array("http", "https")))
            return $matches[0];

        // Note: Assume, there is no second onclick-event in substr($matches[0], 2)
        return '<a onclick="_gaq.push([\'_trackPageview\', \'/extlink/' .
            (function_exists('serendipity_specialchars') ? serendipity_specialchars($matches[3]) : htmlspecialchars($matches[3], ENT_COMPAT, LANG_CHARSET)) .
            '\']);" ' . substr($matches[0], 2);
    }

} // end class serendipity_event_google_analytics_v4
