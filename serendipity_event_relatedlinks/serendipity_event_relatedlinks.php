<?php # 

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_relatedlinks extends serendipity_event
{
    var $title = PLUGIN_EVENT_RELATEDLINKS_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_RELATEDLINKS_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_RELATEDLINKS_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '1.8.3');
        $propbag->add('event_hooks',    array(
            'frontend_display:html:per_entry'                   => true,
            'backend_publish'                                   => true,
            'backend_save'                                      => true,
            'frontend_display_relatedlinks'                     => true,
            'backend_display'                                   => true
        ));
        $propbag->add('configuration', array('showmethod', 'explodechar'));
        $this->dependencies = array('serendipity_event_entryproperties' => 'keep');
        $propbag->add('groups', array('BACKEND_EDITOR'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'showmethod':
                $propbag->add('type',        'radio');
                $propbag->add('name',        PLUGIN_EVENT_RELATEDLINKS_POSITION);
                $propbag->add('description', PLUGIN_EVENT_RELATEDLINKS_POSITION_DESC);
                $propbag->add('radio',       array(
                    'value' => array('footer', 'body', 'smarty'),
                    'desc'  => array(PLUGIN_EVENT_RELATEDLINKS_POSITION_FOOTER, PLUGIN_EVENT_RELATEDLINKS_POSITION_BODY, PLUGIN_EVENT_RELATEDLINKS_POSITION_SMARTY)
                ));
                $propbag->add('default', 'footer');
                $propbag->add('radio_per_row',1);
                return true;
                break;

            case 'explodechar':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR);
                $propbag->add('description', PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR_DESC);
                $propbag->add('default', '=');
                return true;
                break;
        }

        return false;
    }

    function generate_content(&$title) {
        global $serendipity;

        $title = $this->title;
    }

    function getLinks($id) {
        global $serendipity;

        $q = "SELECT value FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = ". (int)$id . " AND property = 'post_relatedentries'";
        $result = serendipity_db_query($q, true);

        if (is_array($result)) {
            return $result['value'];
        } else {
            return false;
        }
    }

    function showRelatedLinks($CustomHook, &$eventData, $addData) {
        global $serendipity;

        if (!$eventData['is_extended'] && !$serendipity['GET']['id'] && !$CustomHook) {
            return false;
        }

        $content =& $eventData['properties']['relatedentries'];

        if (empty($content) || $content === 1 || $content === "1") {
            return false;
        }

        if ($CustomHook) {
            $serendipity['smarty']->assign('RELATEDLINKS', $content);
            return $content;
        }

        switch($this->get_config('showmethod')) {
            default:
            case 'footer':
                $eventData['display_dat'] .= $content;
                return true;
                break;

            case 'body':
                $eventData['exflag']       = 1;
                $eventData['has_extended'] = 1;
                $eventData['is_extended'] = 1;
                $eventData['extended']     .= $content;
                return true;
                break;

            case 'smarty':
                return $content;
                break;
        }

        return false;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {

                case 'backend_publish':
                case 'backend_save':
                    if (!isset($serendipity['POST']['properties']) || !is_array($serendipity['POST']['properties']) || !isset($eventData['id'])) {
                        return true;
                    }

                    $links      = (array)explode("\n", str_replace("\r", '', $serendipity['POST']['properties']['relatedentries']));

                    $html_links = array();
                    foreach ($links AS $link) {
                        if (empty($link)) {
                            continue;
                        }

                        $parts = explode($this->get_config('explodechar', '='), $link);
                        if (empty($parts[1])) {
                            $parts[1] = $parts[0];
                        }

                        $html_links[] = array(
                            'url'   => $parts[0],
                            'title' => (function_exists('serendipity_specialchars') ? serendipity_specialchars($parts[1]) : htmlspecialchars($parts[1], ENT_COMPAT, LANG_CHARSET))
                        );
                    }

                    serendipity_smarty_init();
                    $serendipity['smarty']->assign(
                        array(
                            'plugin_relatedentries_html_intro' => PLUGIN_EVENT_RELATEDLINKS_LIST,
                            'plugin_relatedentries_links'      => $html_links,
                        )
                    );

                    $tfile = serendipity_getTemplateFile('plugin_relatedlinks.tpl', 'serendipityPath');
                    if (!$tfile) {
                        $tfile = dirname(__FILE__) . '/plugin_relatedlinks.tpl';
                    }
                    $inclusion = $serendipity['smarty']->security_settings['INCLUDE_ANY'];
                    $serendipity['smarty']->security_settings['INCLUDE_ANY'] = true;
                    $content = $serendipity['smarty']->fetch('file:'. $tfile);
                    if (count($html_links) < 1) {
                        $content = true;
                    }

                    $serendipity['smarty']->security_settings['INCLUDE_ANY'] = $inclusion;

                    if (!empty($content)) {
                        $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = ". (int)$eventData['id'] . " AND (property = 'relatedentries' OR property = 'post_relatedentries')";
                        serendipity_db_query($q);
                        $q = "INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value) VALUES (" . (int)$eventData['id'] . ", 'relatedentries', '" . serendipity_db_escape_string($content) . "')";
                        serendipity_db_query($q);
                        $q = "INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value) VALUES (" . (int)$eventData['id'] . ", 'post_relatedentries', '" . serendipity_db_escape_string($serendipity['POST']['properties']['relatedentries']) . "')";
                        serendipity_db_query($q);
                    }

                    return true;
                    break;

                case 'backend_display':
                    if (isset($serendipity['POST']['properties']['relatedentries'])) {
                        $links = $serendipity['POST']['properties']['relatedentries'];
                    } else if (isset($eventData['id'])) {
                        $links = $this->getLinks($eventData['id']);
                    } else {
                        $links = '';
                    }

?>
                    <fieldset style="margin: 5px">
                        <legend><?php echo PLUGIN_EVENT_RELATEDLINKS_TITLE; ?></legend>
                        <label for="serendipity[properties][relatedentries]" title="<?php echo PLUGIN_EVENT_RELATEDLINKS_TITLE; ?>">
                            <?php echo PLUGIN_EVENT_RELATEDLINKS_ENTERDESC; ?>:</label><br />
                        <textarea name="serendipity[properties][relatedentries]" style="width: 90%; height: 100px" id="properties_relatedentries"><?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($links) : htmlspecialchars($links, ENT_COMPAT, LANG_CHARSET)); ?></textarea>
                    </fieldset>
<?php
                    return true;
                    break;


                case 'frontend_display:html:per_entry':
                    $this->showRelatedLinks(false, $eventData, $addData);
                    return true;
                    break;

                case 'frontend_display_relatedlinks':
                    $this->showRelatedLinks(true, $eventData, $addData);
                    return true;
                    break;

                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>
