<?php
if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_dsgvo_gpdr extends serendipity_event
{
    var $title = PLUGIN_EVENT_DSGVO_GPDR_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_DSGVO_GPDR_NAME);
        $propbag->add('description',   PLUGIN_EVENT_DSGVO_GPDR_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Serendipity Team');
        $propbag->add('version', '1.0');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0',
            'smarty'      => '2.6.7',
            'php'         => '5.3.3'
        ));
        $propbag->add('groups', array('FRONTEND_FEATURES', 'BACKEND_FEATURES'));
        $propbag->add('event_hooks',
            array(
                'frontend_saveComment'  => true,
                'frontend_comment'      => true,
                'entries_header'        => true,
                'entry_display'         => true,
                'genpage'               => true,
                'frontend_footer'       => true,
                'css'                   => true

            )
        );

        $propbag->add('configuration', array('commentform_checkbox', 'commentform_text', 'gpdr_url', 'gpdr_info', 'gpdr_content', 'show_in_footer', 'show_in_footer_text', 'cookie_consent', 'cookie_consent_text', 'cookie_consent_path'));
        $propbag->add('config_groups', array(
            PLUGIN_EVENT_DSGVO_GPDR_MENU => array('gpdr_url', 'gpdr_info', 'gpdr_content'),
            PLUGIN_EVENT_DSGVO_GPDR_COOKIE_MENU => array('cookie_consent', 'cookie_consent_text', 'cookie_consent_path')
        ));
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'gpdr_url':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GPDR_URL);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GPDR_URL_DESC);
                $propbag->add('default',     '');
                break;

            case 'gpdr_content':
                $propbag->add('type',        'html');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GPDR_STATEMENT);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GPDR_STATEMENT_DESC);
                $propbag->add('default',     "");
                break;

            case 'commentform_text':
                $propbag->add('type',        'html');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GPDR_COMMENTFORM_TEXT);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GPDR_COMMENTFORM_TEXT_DESC);
                $propbag->add('default',     PLUGIN_EVENT_DSGVO_GPDR_COMMENTFORM_TEXT_DEFAULT);
                break;

            case 'commentform_checkbox':
                $propbag->add('type','boolean');
                $propbag->add('name', PLUGIN_EVENT_DSGVO_GPDR_COMMENTFORM_CHECKBOX);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GPDR_COMMENTFORM_CHECKBOX_DESC);
                $propbag->add('default', 'true');
                break;

            case 'show_in_footer':
                $propbag->add('type','boolean');
                $propbag->add('name', PLUGIN_EVENT_DSGVO_GPDR_SHOW_IN_FOOTER);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GPDR_SHOW_IN_FOOTER_DESC);
                $propbag->add('default', 'true');
                break;

            case 'show_in_footer_text':
                $propbag->add('type',        'html');
                $propbag->add('name', PLUGIN_EVENT_DSGVO_GPDR_SHOW_IN_FOOTER_TEXT);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GPDR_SHOW_IN_FOOTER_TEXT_DESC);
                $propbag->add('default',     PLUGIN_EVENT_DSGVO_GPDR_SHOW_IN_FOOTER_TEXT_DEFAULT);
                break;

            case 'gpdr_info':
                $propbag->add('type',        'content');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GPDR_INFO);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GPDR_INFO_DESC);
                $propbag->add('default',     $this->inspect_gpdr());
                break;

            case 'cookie_consent':
                $propbag->add('type','boolean');
                $propbag->add('name', PLUGIN_EVENT_DSGVO_GPDR_COOKIE_CONSENT);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GPDR_COOKIE_CONSENT_DESC);
                $propbag->add('default', 'true');
                break;

            case 'cookie_consent_text':
                $propbag->add('type',        'text');
                $propbag->add('name', PLUGIN_EVENT_DSGVO_GPDR_COOKIE_CONSENT_TEXT);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GPDR_COOKIE_CONSENT_TEXT_DESC);
                $propbag->add('default',     PLUGIN_EVENT_DSGVO_GPDR_COOKIE_CONSENT_TEXT_DEFAULT);
                break;

            case 'cookie_consent_path':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GPDR_COOKIE_CONSENT_PATH);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GPDR_COOKIE_CONSENT_PATH_DESC);
                $propbag->add('default',     $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_dsgvo_gpdr/');
                break;

        }

        return true;
    }

    function inspect_gpdr() {
        $out = PLUGIN_EVENT_DSGVO_GPDR_SERENDIPITY_CORE;

        $classes = serendipity_plugin_api::enum_plugins();
        foreach ($classes as $class_data) {
            $pluginFile =  serendipity_plugin_api::probePlugin($class_data['name'], $class_data['classname'], $class_data['pluginPath']);
            $plugin     =& serendipity_plugin_api::getPluginInfo($pluginFile, $class_data);

            if (is_object($plugin)) {
                // Object is returned when a plugin could not be cached.
                $bag = new serendipity_property_bag;
                $plugin->introspect($bag);

                $legal = $bag->get('legal');
                if (is_array($legal)) {
                    $out .= '<h3>' . $class_data['classname'] . '</h3>';

                    if (is_array($legal['services']) && count($legal['services']) > 0) {
                        $out .= '<h4>Web services / Third Party</h4>';
                        $out .= '<ul>';
                        foreach($legal['services'] AS $servicename => $servicedata) {
                            $out .= '<li><a href="' . $servicedata['url'] . '">' . $servicename . '</a>: ' . $servicedata['desc'] . '</li>';
                        }
                        $out .= '</ul>';
                    }

                    if (is_array($legal['frontend']) && count($legal['frontend']) > 0) {
                        $out .= '<h4>Frontend</h4>';
                        $out .= '<ul>';
                        foreach($legal['frontend'] AS $servicename => $servicedata) {
                            $out .= '<li>' . $servicedata . '</li>';
                        }
                        $out .= '</ul>';
                    }

                    if (is_array($legal['backend']) && count($legal['backend']) > 0) {
                        $out .= '<h4>Backend</h4>';
                        $out .= '<ul>';
                        foreach($legal['backend'] AS $servicename => $servicedata) {
                            $out .= '<li>' . $servicedata . '</li>';
                        }
                        $out .= '</ul>';
                    }

                    if (is_array($legal['cookies']) && count($legal['cookies']) > 0) {
                        $out .= '<h4>Cookies</h4>';
                        $out .= '<ul>';
                        foreach($legal['cookies'] AS $servicename => $servicedata) {
                            $out .= '<li>' . $servicedata . '</li>';
                        }
                        $out .= '</ul>';
                    }

                    if (is_array($legal['sessiondata']) && count($legal['sessiondata']) > 0) {
                        $out .= '<h4>Session data</h4>';
                        $out .= '<ul>';
                        foreach($legal['sessiondata'] AS $servicename => $servicedata) {
                            $out .= '<li>' . $servicedata . '</li>';
                        }
                        $out .= '</ul>';
                    }

                    $out .= '<h4>Attributes</h4>';
                    $out .= '<ul>';
                    if ($legal['stores_user_input']) {
                        $out .= '<li>Stores user data</li>';
                    } else {
                        $out .= '<li>Does not store user data (or not specified)</li>';
                    }

                    if ($legal['stores_ip']) {
                        $out .= '<li>Stores IP data</li>';
                    } else {
                        $out .= '<li>Does not store IP data (or not specified)</li>';
                    }

                    if ($legal['uses_ip']) {
                        $out .= '<li>Operates on IP data</li>';
                    } else {
                        $out .= '<li>Does not operate on IP data (or not specified)</li>';
                    }

                    if ($legal['transmits_user_input']) {
                        $out .= '<li>Transmits user input to services / third parties</li>';
                    } else {
                        $out .= '<li>Does not transmit user input to services / third parties (or not specified)</li>';
                    }

                    $out .= '</ul>';
                }
            }

        }

        return $out;
    }

    function parseText($text) {
        global $serendipity;

        $url = $this->get_config('gpdr_url');
        if (empty($url)) {
            $url = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?serendipity[subpage]=dsgvo_gpdr_privacy';
        }
        $text = str_replace('%gpdr_url%', $url, $text);
        return $text;
    }

    function isActive() {
        global $serendipity;

        if ($serendipity['GET']['subpage'] == 'dsgvo_gpdr_privacy') {
            return true;
        }

        return false;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_saveComment':
                    if (serendipity_db_bool($this->get_config('commentform_checkbox'))) {
                        if ($addData['type'] == 'NORMAL') {
                            // Only act to comments. Trackbacks are an API so we cannot add checks there.
                            if (empty($serendipity['POST']['accept_privacy'])) {
                                $eventData = array('allow_comments' => false);
                                $serendipity['messagestack']['comments'][] = PLUGIN_EVENT_DSGVO_GPDR_COMMENTFORM_ERROR;
                                return false;
                            }
                        }
                    }
                    return true;
                    break;

                case 'frontend_comment':
                    if (serendipity_db_bool($this->get_config('commentform_checkbox'))) {
?>
                        <fieldset class="form_toolbar dsgvo_gpdr_comment">
                            <div class="form_box">
                                <input id="checkbox_dsgvo_gpdr" name="serendipity[accept_privacy]" value="1" type="checkbox" <?php echo ($serendipity['POST']['accept_privacy'] == 1 ? 'checked="checked"' : ''); ?>><label for="checkbox_dsgvo_gpdr"><?php echo $this->parseText($this->get_config('commentform_text')); ?></label>
                            </div>
                        </fieldset>
<?php
                    }
                    return true;
                    break;

                case 'genpage':
                    if ($this->isActive()) {
                        $serendipity['is_staticpage'] = true;
                    }
                    return true;
                    break;

                case 'entry_display':
                    if ($this->isActive()) {
                        if (is_array($eventData)) {
                            $eventData['clean_page'] = true; // This is important to not display an entry list!
                        } else {
                            $eventData = array('clean_page' => true);
                        }
                    }

                    return true;
                    break;

                case 'entries_header':
                    if ($this->isActive()) {
                        serendipity_header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
                        serendipity_header('Status: 200 OK');

                        $statement = $this->get_config('gpdr_content');

                        if (empty($statement)) {
                            $statement = '<div class="dsgvo_gpdr_statement_error">' . PLUGIN_EVENT_DSGVO_GPDR_STATEMENT_ERROR . '</div>';
                        }

                        echo '<div class="dsgvo_gpdr_statement">' . $statement . '</div>';
                    }
                    return true;
                    break;

                case 'frontend_footer':
                    if (serendipity_db_bool($this->get_config('show_in_footer'))) {
                        echo '<div class="dsgvo_gpdr_footer">' . $this->parseText($this->get_config('show_in_footer_text')) . '</div>';
                    }

                    if (serendipity_db_bool($this->get_config('cookie_consent'))) {
?>
                        <link rel="stylesheet" type="text/css" href="<?php echo $this->get_config('cookie_consent_path'); ?>/cookieconsent.min.css" />
                        <script type="text/javascript" src="<?php echo $this->get_config('cookie_consent_path'); ?>cookieconsent.min.js"></script>
<?php
                        echo $this->parseText($this->get_config('cookie_consent_text'));
                    }
                    return true;
                    break;
                    
                case 'css':
                    if (!strpos($eventData, '.dsgvo_gpdr')) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        echo file_get_contents(dirname(__FILE__) . '/style.css');
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
