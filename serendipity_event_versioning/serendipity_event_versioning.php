<?php # 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_versioning extends serendipity_event {
    var $title = VERSIONING_TITLE;
    var $cache = array();

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name', VERSIONING_TITLE);
        $propbag->add('description', VERSIONING_DESC);
        $propbag->add('event_hooks', array(
            'backend_publish'           => true,
            'backend_save'              => true,
            'backend_display'           => true,
            'backend_entry_updertEntry' => true,
            'backend_entry_presave'     => true,
            'backend_entryform'         => true,
            'backend_entry_iframe'      => true,
            'entry_display'             => true
        ));

        $propbag->add('author', 'Garvin Hicking');
        $propbag->add('version', '0.11.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('stackable', false);
        $propbag->add('groups', array('BACKEND_EDITOR', 'BACKEND_FEATURES'));
        $propbag->add('configuration', array('public','version_date'));
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch ($name) {
            case 'public':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           VERSIONING_PUBLIC);
                $propbag->add('description',    '');
                $propbag->add('default',        false);
                break;
				
			case 'version_date':
                $propbag->add('type',           'radio');
                $propbag->add('name',           VERSIONING_DATE_FORMAT);
                $propbag->add('var',    		'version_date_format');
                $propbag->add('radio_per_row',	2);
				$propbag->add('radio',			array('value' => array('long','short'),
														'desc' => array(VERSIONING_DATE_LONG,VERSIONING_DATE_SHORT)));
                break;

            default:
                return false;
        }
        return true;
    }

    function setupDB() {
        global $serendipity;

        $built = $this->get_config('db_built', null);
        $fresh = false;
        if ((empty($built)) && (!defined('VERSIONING_UPGRADE_DONE'))) {
            serendipity_db_schema_import("CREATE TABLE {$serendipity['dbPrefix']}versioning (
                    id {AUTOINCREMENT} {PRIMARY},
                    entry_id int(11) default '0',
                    version int(4) default '1',
                    body text,
                    extended text,
                    version_date int(11) default '0',
                    version_author int(4) default '0'
            )");

            $this->set_config('db_built', '1');
            @define('VERSIONING_UPGRADE_DONE', true);
        }
    }

    function generate_content(&$title) {
        $title = VERSIONING_TITLE;
    }

    function install() {
        $this->setupDB();
    }

    function &getVersions($entry = null, $selected = null) {
        global $serendipity;

        $versions = array();
        if (empty($entry)) {
            return $versions;
        }

        $versions = serendipity_db_query("SELECT v.id,
                                                 v.version,
                                                 a.realname,
                                                 v.version_date
                                            FROM {$serendipity['dbPrefix']}versioning AS v
                                 LEFT OUTER JOIN {$serendipity['dbPrefix']}authors AS a
                                              ON a.authorid = v.version_author
                                           WHERE v.entry_id = " . (int)$entry . "
                                        ORDER BY v.version DESC");
        return $versions;
    }

    function &getCurrent($entry) {
        global $serendipity;

        $q       = "SELECT max(v.version) AS maxVer,
                           v.id,
                           a.realname,
                           v.version_date
                      FROM {$serendipity['dbPrefix']}versioning AS v
           LEFT OUTER JOIN {$serendipity['dbPrefix']}authors AS a
                        ON a.authorid = v.version_author
                     WHERE entry_id = " . (int)$entry . "
                  GROUP BY v.entry_id, v.id, a.realname, v.version_date
                  ORDER BY v.version DESC";
        $maxVer  = serendipity_db_query($q, true, 'assoc');
        if (is_string($maxVer)) {
            echo 'Error: ' . $maxVer . '. Postgresql is driving me nuts.<br />';
        }
        return $maxVer;
    }

    function &getVersion($entry, $version = null, $version_col = 'v.version') {
        global $serendipity;

        if ($version == null) {
            $maxVer  =& $this->getCurrent($entry);
            $version = $maxVer['maxVer'];
        }

        $q     = "SELECT v.id,
                                              v.body,
                                              v.extended,
                                              v.version,
                                              v.entry_id,
                                              a.realname,
                                              v.version_date
                                         FROM {$serendipity['dbPrefix']}versioning AS v
                              LEFT OUTER JOIN {$serendipity['dbPrefix']}authors AS a
                                           ON a.authorid = v.version_author
                                        WHERE v.entry_id = " . (int)$entry . "
                                          AND $version_col  = " . (int)$version . "
                                        LIMIT 1";

        $entry = serendipity_db_query($q, true, 'assoc');
        return $entry;
    }

    function storeVersion(&$entry, &$newEntry, $cache = array()) {
        global $serendipity;

        if (!isset($cache['body'])) {
            $cache['body']     = $newEntry['body'];
            $cache['extended'] = $newEntry['extended'];
        }

        serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}versioning
                                          (entry_id, version, body, extended, version_date, version_author)
                                   VALUES
                                           (" . (int)$newEntry['id'] . ",
                                            " . ($entry['version']+1) . ",
                                            '" . serendipity_db_escape_string($cache['body']) . "',
                                            '" . serendipity_db_escape_string($cache['extended']) . "',
                                            " . time() . ",
                                            " . (int)$serendipity['authorid'] . ")");
    }

    function recoverVersion(&$entry, $version) {
        global $serendipity;

        $recovery = $this->getVersion($entry['id'], $version, 'v.id');

        $entry['body']     = $recovery['body'];
        $entry['extended'] = $recovery['extended'];

        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
			switch($this->get_config('version_date')) {
				case 'long':
					$date_time_format = DATE_FORMAT_ENTRY;
					break;
				case 'short':
					$date_time_format = DATE_FORMAT_SHORT;
					break;
				default:
					$date_time_format = DATE_FORMAT_SHORT;
					break;
			}
			
            switch ($event) {
                case 'backend_entry_updertEntry':
                    $this->cache['body']     = $addData['body'];
                    $this->cache['extended'] = $addData['extended'];

                    if ($serendipity['POST']['versioning'] > 0 && !empty($serendipity['POST']['versioning_change']) && !empty($addData['id'])) {
                        $eventData[] = sprintf(VERSIONING_REVISION_CONTROL, (int)$serendipity['POST']['versioning']);
                    }

                    break;

                case 'backend_entry_iframe':
                    // Serendipity 1.0: Prevent iframe creation.
                    if ($serendipity['POST']['versioning'] > 0 && !empty($serendipity['POST']['versioning_change'])) {
                        $eventData = false;
                    }
                    break;

                case 'backend_entry_presave':
                    break;

                case 'backend_entryform':
                    // Should we restore a version?
                    if ($serendipity['POST']['versioning'] > 0 && !empty($serendipity['POST']['versioning_change']) && !empty($eventData['id'])) {
                        $this->recoverVersion($eventData, $serendipity['POST']['versioning']);
                    }

                    break;

                case 'entry_display':
                    if (!is_array($eventData)) {
                        return false;
                    }

                    if (serendipity_db_bool($this->get_config('public')) && $addData['extended']) {
                        if ($serendipity['GET']['version_selected'] > 0) {
                            $this->recoverVersion($eventData[0], (int)$serendipity['GET']['version_selected']);
                        }

                        $versions = &$this->getVersions($eventData[0]['id']);
                        if (count($versions) < 1 || empty($versions[0])) {
                            return true;
                        }

                        $msg = '<div class="serendipity_versioningInfo">' . VERSIONING_TITLE . ':<br />%s</div>';
                        $html = '<ul>';
                        foreach($versions AS $version) {
                            $html .= '<li><a href="' . $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?' . serendipity_archiveURL($eventData[0]['id'], 'revision' . $version['version'], 'serendipityHTTPPath', false) . '&amp;serendipity[version_selected]=' . $version['id'] . '">' . (function_exists('serendipity_specialchars') ? serendipity_specialchars(sprintf(VERSIONING_REVISION, $version['version'], serendipity_strftime($date_time_format, $version['version_date'], true), $version['realname'])) : htmlspecialchars(sprintf(VERSIONING_REVISION, $version['version'], serendipity_strftime($date_time_format, $version['version_date'], true), $version['realname']), ENT_COMPAT, LANG_CHARSET)) . '</a></li>';
                        }
                        $html .= '</ul>';

                        $eventData[0]['add_footer'] .= sprintf($msg, $html);
                        unset($eventData[0]['properties']['ep_cache_body']);
                        unset($eventData[0]['properties']['ep_cache_extended']);
                    }
                    return true;
                    break;

                case 'backend_save':
                case 'backend_publish':
                    $this->setupDB();

                    if (empty($eventData['id'])) {
                        return true;
                    }

                    // Get the last version
                    $entry = &$this->getVersion($eventData['id']);
                    if ($entry['body'] != $this->cache['body'] ||
                        $entry['extended'] != $this->cache['extended']) {

                        $this->storeVersion($entry, $eventData, $this->cache);
                    }

                    break;

                case 'backend_display':
                    $versions = &$this->getVersions($eventData['id'], $serendipity['POST']['versioning']);
                    if (count($versions) < 1) {
                        return true;
                    }
?>
                    <fieldset style="margin: 5px">
                        <legend><?php echo VERSIONING_TITLE; ?></legend>
                        <div>
                            <select name="serendipity[versioning]">
<?php
                    foreach($versions AS $version) {
                        $text = htmlspecialchars(sprintf(VERSIONING_REVISION,
                                    $version['version'],
                                    serendipity_strftime($date_time_format, $version['version_date'], true),
                                    $version['realname']));

                        echo '<option value="' . $version['id'] . '" ' . ($serendipity['POST']['versioning'] == $version['id'] ? 'selected="selected"' : '') . '>' . $text . '</option>' . "\n";
                    }
?>
                            </select>
                            <input class="serendipityPrettyButton input_button" type="submit" name="serendipity[versioning_change]" value="<?php echo VERSIONING_CHANGE; ?>" onclick="return confirm('<?php echo str_replace("'", "\'", (function_exists('serendipity_specialchars') ? serendipity_specialchars(VERSIONING_CHANGE_WARNING) : htmlspecialchars(VERSIONING_CHANGE_WARNING, ENT_COMPAT, LANG_CHARSET)));
                             ?>');" />
                        </div>
                    </fieldset>
<?php
                default:
                    return false;
            }
            return true;
        }
        return false;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
