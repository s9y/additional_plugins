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

class serendipity_event_assigncategories extends serendipity_event
{
    var $title = PLUGIN_ASSIGNCATEGORIES_NAME;
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_ASSIGNCATEGORIES_NAME);
        $propbag->add('description',   PLUGIN_ASSIGNCATEGORIES_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('version',       '1.2');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',    array(
            'backend_sidebar_entries'   => true,
            'backend_sidebar_entries_event_display_assigncategories'    => true,
            'frontend_generate_plugins' => true
        ));
        $propbag->add('groups', array('BACKEND_FEATURES'));
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_sidebar_entries':
                    if ($this->check()) {
                        echo '<li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=assigncategories">' . PLUGIN_ASSIGNCATEGORIES_NAME . '</a></li>';
                    }
                    return true;
                    break;

                case 'backend_sidebar_entries_event_display_assigncategories':
                    $this->showAssignment();
                    return true;
                    break;

                default:
                    return true;
                    break;
            }
        } else {
            return false;
        }
    }

    function &getAllEntries() {
        global $serendipity;

        $rows = serendipity_db_query("SELECT e.id, e.title, c.categoryid
                                        FROM {$serendipity['dbPrefix']}entries AS e
                             LEFT OUTER JOIN {$serendipity['dbPrefix']}entrycat AS ec
                                          ON e.id = ec.entryid
                             LEFT OUTER JOIN {$serendipity['dbPrefix']}category AS c
                                          ON ec.categoryid = c.categoryid
                                    ORDER BY e.title ASC");
        $entries = array();
        foreach($rows AS $row) {
            $entries[$row['id']]['title'] = $row['title'];
            if (!empty($row['categoryid'])) {
                $entries[$row['id']]['categories'][] = $row['categoryid'];
            }
        }

        return $entries;
    }

    function check() {
        global $serendipity;

        if (function_exists('serendipity_checkPermission')) {
            return serendipity_checkPermission('adminCategories');
        } elseif ($serendipity['serendipityUserlevel'] < USERLEVEL_CHIEF) {
            return false;
        } else {
            return true;
        }
    }

    function updateCategories(&$entries) {
        global $serendipity;

        foreach($entries AS $entryid => $entry) {
            $entries[$entryid]['categories'] = array();
        }

        foreach($serendipity['POST']['assigncat'] AS $categoryid => $entrylist) {
            serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entrycat WHERE categoryid = " . (int)$categoryid);
            foreach($entrylist AS $entry) {
                serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}entrycat (entryid, categoryid) VALUES (" . (int)$entry . ", " . (int)$categoryid . ")");
                $entries[$entry]['categories'][] = $categoryid;
            }
        }

        echo '<div class="serendipityAdminMsgSuccess"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_success.png') . '" alt="" />'. CATEGORY_SAVED .'</div>';
    }

    function showAssignment() {
        global $serendipity;

        if (!$this->check()) {
            return false;
        }

        $entries = $this->getAllEntries();

        if (!empty($serendipity['POST']['submit'])) {
            $this->updateCategories($entries);
        }

        echo '<form action="?" method="post">' . "\n";
        echo '<input type="hidden" name="serendipity[adminModule]" value="event_display" />' . "\n";
        echo '<input type="hidden" name="serendipity[adminAction]" value="assigncategories" />' . "\n";

        echo '<table>';

        $cats = serendipity_fetchCategories('all');
        foreach ($cats as $cat_data) {
            echo '<tr>' . "\n";
            echo '<td valign="top"><strong>' . htmlspecialchars($cat_data['category_name']) . '</strong></td>' . "\n";
            echo '<td><select size="5" name="serendipity[assigncat][' . $cat_data['categoryid'] . '][]" multiple="true">' . "\n";
            foreach($entries AS $entryid => $entry) {
                echo '<option value="' . $entryid . '" ' . (in_array($cat_data['categoryid'], $entry['categories']) ? 'selected="selected"' : '') . '>' . htmlspecialchars($entry['title']) . '</option>' . "\n";
            }
            echo '</select></td>' . "\n";
            echo '</tr>' . "\n";
        }

        echo '</table>' . "\n";

        echo '<input class="serendipityPrettyButton input_button" type="submit" name="serendipity[submit]" value="' . GO . '" />';
        echo '</form>';
    }
}
?>