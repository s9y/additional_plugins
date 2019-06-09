<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_vgwort extends serendipity_event {
    var $title = PLUGIN_EVENT_VGWORT_NAME;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_VGWORT_NAME);
        $propbag->add('description',   PLUGIN_EVENT_VGWORT_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Malte Paskuda');
        $propbag->add('version',       '0.3.2');
        $propbag->add('requirements',  array(
            'serendipity' => '2.2.1'
        ));
        $propbag->add('event_hooks',   array('external_plugin' => true,
                                             'backend_maintenance' => true,
                                             'backend_publish' => true,
                                             'backend_save' => true,
                                             'backend_view_entry' => true,
                                             'frontend_display:html:per_entry' => true,
                                             'frontend_display:rss-2.0:per_entry' => true,
                                             'frontend_display:atom-1.0:per_entry' => true,
                                             'frontend_fetchentries' => true,
                                             
                                            ));
        $propbag->add('groups', array('MARKUP'));
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function install() {
        $this->setupDB();
    }

    function setupDB() {
        global $serendipity;
        $sql = "CREATE TABLE  IF NOT EXISTS {$serendipity['dbPrefix']}vgwort (
                    entry_id INTEGER,
                    counter_public VARCHAR(32) UNIQUE NOT NULL,
                    counter_private VARCHAR(32) UNIQUE NOT NULL);";
        serendipity_db_schema_import($sql);
    }

    /**
     * Return the length of entry with the given id after stripping it of HTML and newlines.
     * */
    function entryLength($id) {
        $entry = serendipity_fetchEntry('id', $id);
        $entry = serendipity_printEntries(array($entry), 1, false, 'ENTRIES', "return");
        // printentries returns the formatted entry in a datetime array, which we need to query to get the entry itself
        $entry = array_values($entry)[0]['entries'][0];
        $fullEntry = $entry['body'];
        if (! empty($entry['extended'])) {
            $fullEntry += $entry['extended'];
        }
        
        $rawEntry = strip_tags($fullEntry);
        $rawEntry = trim(preg_replace('/\s+/', ' ', $rawEntry));
        return mb_strlen($rawEntry);
    }

    /**
     * Import the Zählmarken stored in the given CSV. Store them in the database, with an entry id if there are available entries (=that are long enough)
     * */
    function import($csv) {
        // NOTE: We should use one of the included CSV functions. But they don't work with the format the csv file has currently
        $csv = explode(";Zählmarke für HTML Texte;Zählmarke für HTML Texte - SSL (https://...);Zählmarke für Dokumente (erlaubte Formate: PDF, ePub);Zählmarke für Dokumente (erlaubte Formate: PDF, ePub) - SSL (https://...)", $csv);
        $entries = $this->markableEntries();
        foreach ($csv as $csvline) {
            // we have to remvoe newlines here, because the CSV currently contains newlines where there should be none,
            // which trips up the selection via array indexes selection below
            $csvline = str_replace(array("\n", "\r"), '', $csvline);
            $csvline = explode(';', $csvline);
            if (strpos($csvline[1], 'img') !== false) {
                preg_match('@.*/na/(.*?)"@', $csvline[1], $counterPublic);
                $counterPublic = $counterPublic[1];
                $counterPrivate = $csvline[6];
                $entryId = array_pop($entries);
                $this->storeCounter($entryId, $counterPublic, $counterPrivate);
            }
        }
    }

    /**
     * Return array of up to 100 ids of entries long enough to get a Zählmarke and not already marked
     * */
    function markableEntries() {
        global $serendipity;
        $ids = [];
        $sql = "SELECT id from {$serendipity['dbPrefix']}entries
                LEFT OUTER JOIN {$serendipity['dbPrefix']}vgwort
                ON {$serendipity['dbPrefix']}entries.id = {$serendipity['dbPrefix']}vgwort.entry_id
                WHERE {$serendipity['dbPrefix']}vgwort.entry_id IS NULL;";
        $results = serendipity_db_query($sql);
        foreach($results as $result) {
            if ($this->entryLength($result['id']) > 1800) {
                $ids[] = $result['id'];
                if (count($ids) == 100) {
                    break;
                }
            }
        }
        return $ids;
    }

    /**
     * Store a new triple of entry_id, public and private counter
     * */
    function storeCounter($entry_id, $public, $private) {
        global $serendipity;
        $sql = "INSERT INTO {$serendipity['dbPrefix']}vgwort(entry_id, counter_public, counter_private)
                VALUES(" . (int)$entry_id . ", '" . serendipity_db_escape_string($public) . "', '" . serendipity_db_escape_string($private) . "')";
        return serendipity_db_query($sql);
    }

    /**
     * Set entry_id of public and private counter to given $entry_id
     * */
    function updateCounter($entry_id, $public, $private) {
        global $serendipity;
        $sql = "UPDATE {$serendipity['dbPrefix']}vgwort SET entry_id = " . (int)$entry_id . " 
                WHERE counter_public = '" . serendipity_db_escape_string($public) . "' AND counter_private = '" . serendipity_db_escape_string($private) . "'";
        return serendipity_db_query($sql);
    }

    /**
     * Return an array of unused public and private Zählmarken
     * */
    function unused() {
        return $this->getCounter(0);
    }

    function getCounter($entry_id) {
        global $serendipity;
        $sql = "SELECT counter_public, counter_private FROM {$serendipity['dbPrefix']}vgwort
                WHERE entry_id = " . (int) $entry_id;
        return serendipity_db_query($sql, false);
    }

    /**
     * If entry is long enough and not already marked, assign one of the unused Zählmarken
     * */
    function assignUnusedCounter($entry_id) {
        if ($this->isMarkable($entry_id)) {
            $unused = $this->unused();
            if (is_array($unused)) {
                $counter = array_pop($unused);
                $this->updateCounter($entry_id, $counter['counter_public'], $counter['counter_private']);
            }
        }
    }

    /**
     * Return true if entry is not already marked and long enough
     * */
    function isMarkable($entry_id) {
        global $serendipity;
        $sql = "SELECT * FROM {$serendipity['dbPrefix']}vgwort WHERE entry_id = " . (int)$entry_id;
        $result = serendipity_db_query($sql);
        if (! is_array($result)) {
            return $this->entryLength($entry_id) > 1800;
        }
        return false;
    }


    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'external_plugin':
                    switch ($eventData) {
                        case 'vgwortImport':
                            $csv = iconv("ISO-8859-1", "UTF-8", file_get_contents($_FILES['csv']['tmp_name']));
                            $this->import($csv);

                            $redirect= '<meta http-equiv="REFRESH" content="0;url=';
                            $url = 'serendipity_admin.php?serendipity[adminModule]=maintenance">';
                            echo $redirect . $url;
                            
                            return true;
                            break;
    
                    default:    
                        return false;
                    }
                    return true;
                    break;
                    
                case 'backend_publish':
                case 'backend_save':
                    $this->assignUnusedCounter($eventData['id']);
                    
                    return true;
                    break;

                case 'backend_maintenance':
                    if (!is_object($serendipity['smarty'])) {
                        serendipity_smarty_init();
                    }

                    $unused = $this->unused();
                    if (is_array($unused)) {
                        $unused = count($unused);
                    } else {
                        $unused = 0;
                    }
                    
                    $serendipity['smarty']->assign('unused', $unused);
                    echo $this->parseTemplate('vgwortMenu.tpl');
                    return true;
                    break;
                    
                case 'backend_view_entry':
                    $counter = $this->getCounter($eventData['id'])[0];
                    $eventData['info_more'] = '<section class="vgwort">
                        <span>Length: ' . $this->entryLength($eventData['id']) . '</span>';

                    if (is_array($counter) && $counter['counter_public']) {
                        $eventData['info_more'] .='<span>Zählmarke: ' . $counter['counter_public'] . '</span>
                        <span>Identifikationscode: ' . $counter['counter_private'] . '</span>';
                    }
                        
                    $eventData['info_more'] .= '</section>';
                    return true;
                    break;
                    
                case 'frontend_display:rss-2.0:per_entry':
                case 'frontend_display:atom-1.0:per_entry':
                    $counter = $this->getCounter($eventData['id']);
                    if (is_array($counter)) {
                        $counter = $counter[0];
                    } else {
                        return false;
                    }
                    if ($counter['counter_public']) {
                        // the entry has a Zählmarke, but we have to make sure it is also shown completely
                        if ((empty($eventData['extended'])) || $serendipity['feedFull'] == 1) {
                            $eventData['feed_body'] .= '<img src="https://ssl-vg03.met.vgwort.de/na/' . $counter['counter_public'] . '" width="1" height="1" alt="">';
                        }
                    }

                    return true;
                    break;
                    
                case 'frontend_display:html:per_entry':
                    $counter = $this->getCounter($eventData['id']);
                    if (is_array($counter)) {
                        $counter = $counter[0];
                    } else {
                        return false;
                    }
                    if ($counter['counter_public']) {
                        // the entry has a Zählmarke, but we have to make sure it is also shown completely
                        if ((! $eventData['has_extended']) || ($serendipity['GET']['action'] == 'read' && is_int($serendipity['GET']['id']))) {
                            $eventData['display_dat'] .= '<img src="https://ssl-vg03.met.vgwort.de/na/' . $counter['counter_public'] . '" width="1" height="1" alt="">';
                        }
                    }
                    return true;
                    break;
                case 'frontend_fetchentries':
                    if ((defined('IN_serendipity_admin') && IN_serendipity_admin === true) && (! empty($serendipity['GET']['filter']['body']))) {
                        $join = " LEFT OUTER JOIN {$serendipity['dbPrefix']}vgwort
                                ON e.id = {$serendipity['dbPrefix']}vgwort.entry_id ";
                        $term = serendipity_db_escape_string($serendipity['GET']['filter']['body']);
                        $filter = " OR counter_public LIKE '%$term%' OR counter_private LIKE '%$term%' ";
                        $eventData['joins'] .= $join;
                        $eventData['and'] .= $filter;
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