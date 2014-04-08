<?php # 

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_thumbnails extends serendipity_event {
    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name', THUMBPAGE_TITLE);
        $propbag->add('description', THUMBPAGE_TITLE_BLAHBLAH);
        $propbag->add('event_hooks',  array(
            'entries_header' => true,
            'entry_display' => true));
        $propbag->add('configuration', array('number'));
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Cameron MacFarland');
        $propbag->add('version', '1.4');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('IMAGES'));
        $this->dependencies = array('serendipity_plugin_photoblog' => 'remove',
                                    'serendipity_event_photoblog' => 'keep');
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'number':
                $propbag->add('type',           'string');
                $propbag->add('name',           THUMBPAGE_NUMBER);
                $propbag->add('description',    THUMBPAGE_NUMBER_BLAHBLAH);
                $propbag->add('default',        5);
                break;

            default:
                return false;
        }
        return true;
    }

    function getPhoto($entryid) {
        global $serendipity;
        $q = "SELECT * FROM {$serendipity['dbPrefix']}photoblog WHERE entryid=" . (int)$entryid;
        $row = serendipity_db_query($q, true);

        if (!isset($row) || !is_array($row)) {
            $row = null;
        }

        return $row;
    }

    function show() {
        global $serendipity;

        if ($serendipity['GET']['page'] == 'thumbs') {
            $title = '';
            if (!is_object($serendipity['smarty'])) {
                serendipity_smarty_init();
            }
            $_ENV['staticpage_pagetitle'] = 'thumbs';
            $serendipity['smarty']->assign('staticpage_pagetitle', 'thumbs');
            $this->generate_content($title);
        }
    }

    function generate_content(&$title) {
        global $serendipity;

        $title = THUMBPAGE_TITLE;

        if ($serendipity['GET']['page'] != 'thumbs') {
            return true;
        }

        if (!headers_sent()) {
            header('HTTP/1.0 200');
            header('Status: 200 OK');
        }

        $entries = serendipity_db_query("SELECT id,
                                                title,
                                                timestamp
                                           FROM {$serendipity['dbPrefix']}entries
                                          WHERE isdraft = 'false'
                                       ORDER BY timestamp DESC");

        if (isset($entries) && is_array($entries)) {
            $count = 0;
            echo '<table><tr>';
            foreach ($entries as $k => $entry) {
                echo '<td align="center">';
                $entryLink = serendipity_archiveURL(
                               $entry['id'],
                               $entry['title'],
                               'serendipityHTTPPath',
                               true,
                               array('timestamp' => $entry['timestamp'])
                            );
                $photo = $this->getPhoto($entry['id']);
                if (isset($photo)) {
                    $file = serendipity_fetchImageFromDatabase($photo['photoid']);
                    $imgsrc= $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $file['path'] . $file['name'] . '.' . $file['thumbnail_name'] .'.'. $file['extension'];
                    $thumbbasename = $file['path'] . $file['name'] . '.' . $file['thumbnail_name'] . '.' . $file['extension'];
                    $thumbName     = $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $thumbbasename;
                    $thumbsize     = @getimagesize($serendipity['serendipityPath'] . $serendipity['uploadPath'] . $thumbbasename);
                }

                echo '<a href="' . $entryLink . '" title="' . htmlspecialchars($entry['title']) . '">';
                if (isset($photo)) {
                    echo '<img style="margin:5px;" src="' . $imgsrc . '" width=' . $thumbsize[0] . ' height=' . $thumbsize[1];
                    if (isset($id) && ($id == $entry['id'])) {
                        echo ' border=4';
                    }
                    echo ' />';
                } else {
                    if (isset($id) && ($id == $entry['id'])) {
                        echo '<b>';
                    }
                    echo $entry['title'];
                    if (isset($id) && ($id == $entry['id'])) {
                        echo '</b>';
                    }
                }
                echo '</a></td>';
                if ($count++ >= $this->get_config('number')-1)
                {
                    $count = 0;
                    echo "</tr><tr>";
                }
            }
            echo "</tr></table>";
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
        switch($event) {
            case 'entry_display':
                if ($serendipity['GET']['page'] == 'thumbs') {
                    if (is_array($eventData)) {
                        $eventData['clean_page'] = true; // This is important to not display an entry list!
                    } else {
                        $eventData = array('clean_page' => true);
                    }
                }

                if (version_compare($serendipity['version'], '0.7.1', '<=')) {
                    $this->show();
                }

                return true;
                break;

            case 'entries_header':
                $this->show();

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
