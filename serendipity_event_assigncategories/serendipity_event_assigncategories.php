<?php #

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_assigncategories extends serendipity_event
{
    var $title = PLUGIN_ASSIGNCATEGORIES_NAME;
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_ASSIGNCATEGORIES_NAME);
        $propbag->add('description',   PLUGIN_ASSIGNCATEGORIES_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Matthias Mees');
        $propbag->add('version',       '1.4.2');
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
                        if ($serendipity['version'][0] == '1') {
                            echo '<li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=assigncategories">' . PLUGIN_ASSIGNCATEGORIES_NAME . '</a></li>';
                        } else {
                            echo '<li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=assigncategories">' . PLUGIN_ASSIGNCATEGORIES_NAME . '</a></li>';
                        }
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

        if ($serendipity['version'][0] == '1') {
            echo '<div class="serendipityAdminMsgSuccess"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_success.png') . '" alt="" />'. CATEGORY_SAVED .'</div>';
        } else {
            echo '<span class="msg_success"><span class="icon-ok-circled" aria-hidden="true"></span> '. CATEGORY_SAVED .'</span>';
        }
    }

    function showAssignment() {
        global $serendipity;

        if (!$this->check()) {
            return false;
        }

        if ($serendipity['version'][0] == '2') {
            echo '<h2>' . PLUGIN_ASSIGNCATEGORIES_NAME . '</h2>';
        }

        $entries = $this->getAllEntries();

        if (!empty($serendipity['POST']['submit'])) {
            $this->updateCategories($entries);
        }

        echo '<form action="?" method="post">' . "\n";
        echo '<input type="hidden" name="serendipity[adminModule]" value="event_display" />' . "\n";
        echo '<input type="hidden" name="serendipity[adminAction]" value="assigncategories" />' . "\n";

        $cats = serendipity_fetchCategories('all');

        if ($serendipity['version'][0] == '1') {
            echo '<table>';
            foreach ($cats as $cat_data) {
                echo '<tr>' . "\n";
                echo '<td valign="top"><strong>' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($cat_data['category_name']) : htmlspecialchars($cat_data['category_name'], ENT_COMPAT, LANG_CHARSET)) . '</strong></td>' . "\n";
                echo '<td><select size="5" name="serendipity[assigncat][' . $cat_data['categoryid'] . '][]" multiple="true">' . "\n";
                if (is_array($entries) && !empty($entries)) {
                    foreach($entries AS $entryid => $entry) {
                        echo '<option value="' . $entryid . '" ' . (in_array($cat_data['categoryid'], (array)$entry['categories']) ? 'selected="selected"' : '') . '>' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($entry['title']) : htmlspecialchars($entry['title'], ENT_COMPAT, LANG_CHARSET)) . '</option>' . "\n";
                    }
                }
                echo '</select></td>' . "\n";
                echo '</tr>' . "\n";
            }

            echo '</table>' . "\n";

            echo '<input class="serendipityPrettyButton input_button" type="submit" name="serendipity[submit]" value="' . GO . '" />';
        } else {
            foreach ($cats as $cat_data) {
                echo '<div class="form_multiselect">';
                echo '<label for="serendipity_assigncat_'  . $cat_data['categoryid'] . '" class="block_level">' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($cat_data['category_name']) : htmlspecialchars($cat_data['category_name'], ENT_COMPAT, LANG_CHARSET)) . '</label>';
                echo '<select id="serendipity_assigncat_'  . $cat_data['categoryid'] . '" size="5" name="serendipity[assigncat][' . $cat_data['categoryid'] . '][]" multiple="true">';
                if (is_array($entries) && !empty($entries)) {
                    foreach($entries AS $entryid => $entry) {
                        echo '<option value="' . $entryid . '" ' . (in_array($cat_data['categoryid'], (array)$entry['categories']) ? 'selected="selected"' : '') . '>' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($entry['title']) : htmlspecialchars($entry['title'], ENT_COMPAT, LANG_CHARSET)) . '</option>';
                    }
                }
                echo '</select></div>';
            }

            echo '<div class="form_buttons"><input type="submit" name="serendipity[submit]" value="' . SAVE . '"></div>';
        }
        echo '</form>';
    }
}
?>