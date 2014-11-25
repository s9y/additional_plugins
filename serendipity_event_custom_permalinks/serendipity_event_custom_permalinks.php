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

class serendipity_event_custom_permalinks extends serendipity_event {
    var $ids = array();

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name', PLUGIN_EVENT_CUSTOM_PERMALINKS);
        $propbag->add('description', PLUGIN_EVENT_CUSTOM_PERMALINKS_DESC);
        $propbag->add('event_hooks',  array(
                                        'genpage'                           => true,
                                        'backend_publish'                   => true,
                                        'entry_display'                     => true,
                                        'backend_save'                      => true,
                                        'frontend_display:html:per_entry'   => true,
                                        'backend_display'                   => true));

        $propbag->add('author', 'Garvin Hicking');
        $propbag->add('version', '1.14.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('stackable', false);
        $propbag->add('groups', array('BACKEND_EDITOR'));
    }

    function show($id) {
        global $serendipity;

        $id = (int)$id;

        if (!headers_sent()) {
            header('HTTP/1.0 200');
            header('Status: 200 OK');
        }

        serendipity_track_referrer($id);
        $GLOBALS['track_referer'] = false;

        $_GET['serendipity']['action'] = 'read';
        $_GET['serendipity']['id']     = $id;
        
        $serendipity['plugindata']['smartyvars']['view'] = $serendipity['view'] = 'entry';

        $title = serendipity_db_query("SELECT title FROM {$serendipity['dbPrefix']}entries WHERE id=$id", true);
        $serendipity['head_title']    = $title[0];
        $serendipity['head_subtitle'] = $serendipity['blogTitle'];
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENT_CUSTOM_PERMALINKS;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'genpage':
                    $args = implode('/', serendipity_getUriArguments($eventData, true));
                    if ($serendipity['rewrite'] != 'none') {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $args;
                    } else {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/' . $args;
                    }

                    $myi = strpos($nice_url, '?');
                    if ($myi != 0 && $serendipity['rewrite'] != 'none') {
                        $nice_url2 = substr($nice_url, $myi+1);
                    }

                    $myi = strpos($nice_url, '?');
                    if ($myi != 0 && $serendipity['rewrite'] != 'none') {
                        $nice_url = substr($nice_url, 0, $myi);
                    }

                    $myi = strpos($nice_url, '&');
                    if ($myi != 0 && $serendipity['rewrite'] != 'none') {
                        $nice_url = substr($nice_url, 0, $myi);
                    }

                    $myi = strpos($nice_url2, '&');
                    if ($myi != 0 && $serendipity['rewrite'] != 'none') {
                        $nice_url2 = substr($nice_url2, 0, $myi);
                    }

                    $query = "SELECT entryid FROM {$serendipity['dbPrefix']}entryproperties WHERE property = 'permalink'
                                     AND value IN ('" . serendipity_db_escape_string($nice_url) . "', '/" . serendipity_db_escape_string($nice_url) . "',
                                                   '" . serendipity_db_escape_string($nice_url2) . "', '/" . serendipity_db_escape_string($nice_url2) . "')";

                    $retid = serendipity_db_query($query);
                    if (is_array($retid) && !empty($retid[0]['entryid'])) {
                        $this->show($retid[0]['entryid']);
                    }

                    break;

                case 'entry_display':
                    $ids = array();
                    if (!is_array($eventData)) {
                        return true;
                    }

                    foreach ($eventData AS $entry) {
                        $ids[] = $entry['id'];
                    }

                    $query = "SELECT entryid,value FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid IN (" . implode(', ', $ids) . ") AND property = 'permalink'";
                    $retval = serendipity_db_query($query);
                    if (is_array($retval)) {
                    foreach((array)$retval AS $pl) {
                        $this->ids[$pl['entryid']] = $pl['value'];
                    }
                    }

                    break;

                case 'frontend_display:html:per_entry':
                    if (isset($this->ids[$eventData['id']]) && stristr($this->ids[$eventData['id']], '/' . UNKNOWN) === FALSE) {
                        $eventData['link'] =  $this->ids[$eventData['id']];
                        $urldata = parse_url($serendipity['baseURL']);
                        $eventData['rdf_ident'] = $urldata['scheme'] . '://' . $urldata['host'] . $this->ids[$eventData['id']];
                    }
                    break;

                case 'backend_display':
                    $permalink = !empty($serendipity['POST']['permalink']) ? $serendipity['POST']['permalink'] : '';

                    if (!empty($eventData['id']) && empty($permalink)) {
                        $query = "SELECT value FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = '" . $eventData['id'] . "' AND property = 'permalink'";
                        $retval = serendipity_db_query($query);
                        if (is_array($retval) && !empty($retval[0]['value'])) {
                            $permalink = $retval[0]['value'];
                        }
                    }

                    $title = $eventData['title'];
                    if (empty($title)) {
                        $title = UNKNOWN;
                    }

                    if (empty($permalink)) {
                        $permalink = $serendipity['rewrite'] != 'none'
                                   ? $serendipity['serendipityHTTPPath'] . 'permalink/' . serendipity_makeFilename($title) . '.html'
                                   : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/permalink/' . serendipity_makeFilename($title) . '.html';
                    }
?>
                    <fieldset style="margin: 5px">
                        <legend><?php echo PLUGIN_EVENT_CUSTOM_PERMALINKS_PL; ?></legend>
                            <div><?php echo PLUGIN_EVENT_CUSTOM_PERMALINKS_PL_DESC; ?><br /><br /></div>
                            <label for="permalink" title="<?php echo htmlentities(PLUGIN_EVENT_CUSTOM_PERMALINKS_PL); ?>"><?php echo PLUGIN_EVENT_CUSTOM_PERMALINKS_PL; ?>:</label> <input class="input_textbox" type="text" style="width: 60%" name="serendipity[permalink]" id="permalink" value="<?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($permalink) : htmlspecialchars($permalink, ENT_COMPAT, LANG_CHARSET)); ?>" />
                    </fieldset>
<?php
                    return true;
                    break;

                case 'backend_publish':
                case 'backend_save':
                    if (!isset($serendipity['POST']['permalink']) || !isset($eventData['id'])) {
                        return true;
                    }

                    serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = '" . $eventData['id'] . "' AND property = 'permalink'");
                    serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, value, property) VALUES ('" . $eventData['id'] . "', '" . serendipity_db_escape_string($serendipity['POST']['permalink']) . "', 'permalink')");

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
