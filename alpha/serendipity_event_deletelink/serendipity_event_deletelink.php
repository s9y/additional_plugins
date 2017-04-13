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

class serendipity_event_deletelink extends serendipity_event
{

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_DELETELINK_NAME);
        $propbag->add('description',   PLUGIN_EVENT_DELETELINK_BLAHBLAH);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Cameron MacFarland, Brett Profitt');
        $propbag->add('version',       '1.6');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('event_hooks', array('entry_display' => true));
        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED'));
    }

    function generate_content(&$title)
    {
        $title       = PLUGIN_EVENT_DELETELINK_NAME;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'entry_display':
                    if (!is_array($eventData)) return false;
                    $elements = count($eventData);
                    for ($i = 0; $i < $elements; $i++) {
                        if (empty($eventData[$i]['body'])) continue;
                        # see if we want the edit link.  (Only in extended mode)
                        /* Disable because Serendipity 0.8 delivers this.
                        if ($addData['extended']) {
                            if ($_SESSION['serendipityAuthedUser'] === true && ($_SESSION['serendipityUserlevel'] >= USERLEVEL_CHIEF || $_SESSION['serendipityAuthorid'] == $eventData[$i]['authorid'])) {
                                $eventData[$i]['add_footer'] .= ' | ';
                                $eventData[$i]['add_footer'] .= '<a href="' . $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[action]=admin&amp;serendipity[adminModule]=entries&amp;serendipity[adminAction]=edit&amp;serendipity[id]=' . $eventData[$i]['id'] . '">';
                                $eventData[$i]['add_footer'] .= EDIT;
                                $eventData[$i]['add_footer'] .= '</a>';
                            }
                        }
                        */

                        if ($_SESSION['serendipityAuthedUser'] === true && ($_SESSION['serendipityUserlevel'] >= USERLEVEL_CHIEF || $_SESSION['serendipityAuthorid'] == $eventData[$i]['authorid'])) {
                            if (!isset($eventData[$i]['add_footer'])) {
                                $eventData[$i]['add_footer'] = '';
                            }
                            $eventData[$i]['add_footer'] .= ' | ';
                            $eventData[$i]['add_footer'] .= '<a href="' . $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[action]=admin&amp;serendipity[adminModule]=entries&amp;serendipity[adminAction]=delete&amp;serendipity[id]=' . $eventData[$i]['id'] . '&amp;' . serendipity_setFormToken('url') . '">';
                            $eventData[$i]['add_footer'] .= DELETE;
                            $eventData[$i]['add_footer'] .= '</a>';
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