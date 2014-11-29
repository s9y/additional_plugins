<?php

include_once dirname(__FILE__) . '/common.inc.php';

class serendipity_event_pollbox extends serendipity_event {
    var $poll = array();

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name', PLUGIN_POLL_TITLE);
        $propbag->add('description', PLUGIN_POLL_TITLE_BLAHBLAH);
        $propbag->add('event_hooks',  array(
            'backend_sidebar_entries_event_display_poll'  => true,
            'backend_sidebar_entries' => true,
            'entries_header' => true,
            'entry_display' => true,
            'genpage' => true));

        $propbag->add('configuration', array('permalink', "articleformat", "pagetitle", "articleformattitle"));
        $propbag->add('author', 'Garvin Hicking, Matthias Mees');
        $propbag->add('groups', array('STATISTICS'));
        $propbag->add('version', '2.14.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('stackable', false);
        $this->dependencies = array('serendipity_plugin_pollbox' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'permalink':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_POLL_PERMALINK);
                $propbag->add('description', PLUGIN_POLL_PERMALINK_BLAHBLAH);
                $propbag->add('default',     $serendipity['rewrite'] != 'none'
                                             ? $serendipity['serendipityHTTPPath'] . 'pages/poll.html'
                                             : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/pages/poll.html');
                break;

            case 'pagetitle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_POLL_PAGETITLE);
                $propbag->add('description', '');
                $propbag->add('default',     PLUGIN_POLL_TITLE);
                break;

            case 'articleformat':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_POLL_ARTICLEFORMAT);
                $propbag->add('description', PLUGIN_POLL_ARTICLEFORMAT_BLAHBLAH);
                $propbag->add('default',     'true');
                break;

            case 'articleformattitle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_POLL_ARTICLEFORMAT_PAGETITLE);
                $propbag->add('description', PLUGIN_POLL_ARTICLEFORMAT_PAGETITLE_BLAHBLAH);
                $propbag->add('default',     $serendipity['blogTitle'] . ' :: ' . $this->pagetitle);
                break;

            default:
                return false;
        }
        return true;
    }

    function setupDB() {
        global $serendipity;


        $built = $this->get_config('db_built', null);
        if (empty($built) && !defined('PLUGIN_POLL_UPGRADE_DONE')) {
            serendipity_db_schema_import("CREATE TABLE {$serendipity['dbPrefix']}polls (
              id {AUTOINCREMENT} {PRIMARY},
              title varchar(255) not null default '',
              content text,
              active int(1) default '1',
              votes int(4) default '0',
              timestamp int(10) {UNSIGNED} default null);");

            serendipity_db_schema_import("CREATE TABLE {$serendipity['dbPrefix']}polls_options (
              id {AUTOINCREMENT} {PRIMARY},
              pollid int(10) {UNSIGNED},
              title varchar(255) not null default '',
              votes int(4) default '0',
              timestamp int(10) {UNSIGNED} default null);");

            serendipity_db_schema_import("CREATE INDEX pollidx ON {PREFIX}polls_options (pollid);");
            $this->set_config('db_built', '1');
            @define('PLUGIN_POLL_UPGRADE_DONE', true); // No further static pages may be called!
        }
    }

    function &get_polldata($key, $default = null) {
        if (isset($this->poll[$key])) {
            return $this->poll[$key];
        } else {
            return $default;
        }
    }

    function show() {
        global $serendipity;

        if ($this->selected()) {
            if (!headers_sent()) {
                header('HTTP/1.0 200');
                header('Status: 200');
            }
            if (!is_object($serendipity['smarty'])) {
                serendipity_smarty_init();
            }
            $_ENV['staticpage_pagetitle'] = preg_replace('@[^a-z0-9]@i', '_',$this->get_config('pagetitle'));
            $serendipity['smarty']->assign('staticpage_pagetitle', $_ENV['staticpage_pagetitle']);

            echo '<div class="serendipity_poll">';
            if (serendipity_db_bool($this->get_config('articleformat'))) {
                echo '<div class="serendipity_Entry_Date">
                         <h3 class="serendipity_date">' . $this->get_config('articleformattitle') . '</h3>';
            }

            echo '<h4 class="serendipity_title"><a href="#">' . $this->get_polldata('title') . '</a></h4>';

            if (serendipity_db_bool($this->get_config('articleformat'))) {
                echo '<div class="serendipity_entry"><div class="serendipity_entry_body">';
            }

            echo '<div class="serendipity_poll_body">';
            if (isset($serendipity['GET']['voteId'])) {
                serendipity_common_pollbox::poll($serendipity['GET']['voteId']);
            } else {
                serendipity_common_pollbox::poll();
            }
            echo '</div>';

            echo '<br /><div class="serendipity_poll_archive">';
            PLUGIN_POLL_ARCHIVE . '<br />';
            $polls =& $this->fetchPolls();
            if (is_array($polls)) {
                foreach($polls AS $poll) {
                    echo '<a href="' . $serendipity['baseURL'] . $serendipity['indexFile'] . '?serendipity[subpage]=' . $this->get_config('pagetitle') . '&amp;serendipity[voteId]=' . $poll['id'] . '">' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($poll['title']) : htmlspecialchars($poll['title'], ENT_COMPAT, LANG_CHARSET)) . '</a>, ' . serendipity_strftime(DATE_FORMAT_ENTRY, $poll['timestamp']) . '<br />';
                }
            }
            echo '</div>';

            if (serendipity_db_bool($this->get_config('articleformat'))) {
                echo '</div></div></div>';
            }
            echo '</div>';
        }
    }

    function selected() {
        global $serendipity;

        if ($serendipity['GET']['subpage'] == 'votearchive' || $serendipity['GET']['subpage'] == $this->get_config('permalink') || $serendipity['GET']['subpage'] == $this->get_config('pagetitle')) {
            return true;
        }

        return false;
    }


    function fetchPolls() {
        global $serendipity;

        return serendipity_db_query("SELECT title, active, timestamp, id FROM {$serendipity['dbPrefix']}polls ORDER BY timestamp DESC");
    }

    function insertPoll() {
        global $serendipity;

        $now = time();
        $q = serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}polls (
                                    title, active, timestamp
                                     ) VALUES (
                                    '" . serendipity_db_escape_string($serendipity['POST']['currentPoll']['title']) . "',
                                    0,
                                    '" . $now . "')");
        if ($q) {
            return serendipity_db_insert_id('polls', 'id');
        }
    }

    function updatePoll($id) {
        global $serendipity;

        $q = serendipity_db_query("UPDATE {$serendipity['dbPrefix']}polls
                                      SET title = '" . serendipity_db_escape_string($serendipity['POST']['currentPoll']['title']) . "'
                                    WHERE id    = " . (int)$id);
        return $q;
    }

    function addOption($pollid, $data) {
        global $serendipity;

        $q = serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}polls_options (
                                    pollid, title, votes
                                    ) VALUES (
                                    " . (int)$pollid . ",
                                    '" . serendipity_db_escape_string($data['title']) . "',
                                    0)");
        return $q;
    }

    function deleteOption($optid) {
        global $serendipity;

        return serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}polls_options WHERE id = " . (int)$optid);
    }

    function updateOptions($pollid, $data) {
        global $serendipity;

        foreach($data AS $optid => $values) {
            if (empty($values['title'])) {
                $this->deleteOption($optid);
            } else {
                serendipity_db_query("UPDATE {$serendipity['dbPrefix']}polls_options
                                         SET title = '" . serendipity_db_escape_string($values['title']) . "'
                                       WHERE id    = " . (int)$optid);
            }
        }
    }

    function showBackend() {
        global $serendipity;

        if ($serendipity['POST']['pollSave'] || $serendipity['POST']['pollOptionAdd'] || is_array($serendipity['POST']['pollOptionRemove'])) {
            $serendipity['POST']['pollSubmit'] = true;

            if ($serendipity['POST']['poll'] == '__new') {
                $serendipity['POST']['poll'] = $this->insertPoll();
            } else {
                $this->updatePoll($serendipity['POST']['poll']);
                $this->updateOptions($serendipity['POST']['poll'], $serendipity['POST']['pollOptions']);
            }
        }

        if ($serendipity['POST']['pollOptionAdd']) {
            $serendipity['POST']['pollSubmit'] = true;
            $this->addOption($serendipity['POST']['poll'], $serendipity['POST']['pollNewOption']);
        }

        if (is_array($serendipity['POST']['pollOptionRemove'])) {
            $serendipity['POST']['pollSubmit'] = true;
            foreach($serendipity['POST']['pollOptionRemove'] AS $optid => $optval) {
                $this->deleteOption($optid);
            }
        }

        if ($serendipity['POST']['poll'] != '__new') {
            $this->poll = serendipity_common_pollbox::fetchPoll($serendipity['POST']['poll']);
        }

        if ($serendipity['version'][0] == '2') {
            echo '<h2>' . PLUGIN_POLL_SELECT . '</h2>';
        }

        if (!empty($serendipity['POST']['pollDelete']) && $serendipity['POST']['poll'] != '__new') {
            serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}polls WHERE id = " . (int)$serendipity['POST']['poll']);
            serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}polls_options WHERE pollid = " . (int)$serendipity['POST']['poll']);
            if ($serendipity['version'][0] == '1') {
?>
    <div class="serendipityAdminMsgSuccess"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="<?php echo serendipity_getTemplateFile('admin/img/admin_msg_success.png'); ?>" alt="" /><?php echo DONE .': '. sprintf(RIP_ENTRY, (int)$serendipity['POST']['poll']); ?></div>
<?php
            } else {
?>
    <span class="msg_success"><span class="icon-ok-circled"></span> <?php echo DONE .': '. sprintf(RIP_ENTRY, (int)$serendipity['POST']['poll']); ?></span>
<?php
            }
        }

        if (!empty($serendipity['POST']['pollActivate']) && $serendipity['POST']['poll'] != '__new') {
            serendipity_db_query("UPDATE {$serendipity['dbPrefix']}polls SET active = 0");
            serendipity_db_query("UPDATE {$serendipity['dbPrefix']}polls SET active = 1 WHERE id = " . (int)$serendipity['POST']['poll']);
        }

        echo '<form action="serendipity_admin.php" method="post" id="serendipity_poll_form">';
        echo '<div>';
        echo '  <input type="hidden" name="serendipity[adminModule]" value="event_display" />';
        echo '  <input type="hidden" name="serendipity[adminAction]" value="poll" />';
        echo '</div>';
        if ($serendipity['version'][0] == '1') {
            echo '<div>';
        } else {
            echo '<div class="form_select">';
        }
        if ($serendipity['version'][0] == '1') {
            echo '<strong>' . PLUGIN_POLL_SELECT . '</strong><br /><br />';
        }
        echo '<select name="serendipity[poll]">';
        echo ' <option value="__new">' . NEW_ENTRY . '</option>';
        echo ' <option value="__new">-----------------</option>';
        $polls =& $this->fetchPolls();
        if (is_array($polls)) {
            foreach($polls AS $poll) {
                echo ' <option value="' . $poll['id'] . '" ' . ($serendipity['POST']['poll'] == $poll['id'] ? 'selected="selected"' : '') . '>';
                echo ($poll['active'] == 1 ? '*' : '') . (function_exists('serendipity_specialchars') ? serendipity_specialchars($poll['title']) : htmlspecialchars($poll['title'], ENT_COMPAT, LANG_CHARSET)) . ' (' . serendipity_strftime('%d.%m.%Y', $poll['timestamp']) . ')</option>';
            }
        }
        if ($serendipity['version'][0] == '1') {
            echo '</select> <input class="serendipityPrettyButton input_button" type="submit" name="serendipity[pollSubmit]" value="' . GO . '" />';
            echo ' <strong>-' . WORD_OR . '-</strong> <input class="serendipityPrettyButton input_button" type="submit" name="serendipity[pollDelete]" value="' . DELETE . '" />';
            echo ' <strong>-' . WORD_OR . '-</strong> <input class="serendipityPrettyButton input_button" type="submit" name="serendipity[pollActivate]" value="' . PLUGIN_POLL_ACTIVATE . '" />';
        } else {
            echo '</select>';
            echo ' <input type="submit" name="serendipity[pollSubmit]" value="' . EDIT . '">';
            echo ' <input class="state_cancel" type="submit" name="serendipity[pollDelete]" value="' . DELETE . '">';
            echo ' <input type="submit" name="serendipity[pollActivate]" value="' . PLUGIN_POLL_ACTIVATE . '">';
        }
        echo '</div>';

        if ($serendipity['POST']['pollSubmit']) {
            if ($serendipity['version'][0] == '1') {
                echo '<div>';
            } else {
                echo '<div class="clearfix">';
            }
                $this->showForm();
                echo '</div>';
        }

        echo '</form>';
    }

    function showForm() {
        global $serendipity;

        if ($serendipity['version'][0] == '1') {
            echo '<br /><hr /><br />';
            echo TITLE . ' <input class="input_textbox" type="text" name="serendipity[currentPoll][title]" value="' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($this->poll['title']) : htmlspecialchars($this->poll['title'], ENT_COMPAT, LANG_CHARSET)) . '" />';
        } else {
            echo '<div class="form_field">';
            echo '<label for="serendipity_current_poll_title" class="block_level">' . TITLE . '</label>';
            echo '<input id="serendipity_current_poll_title" type="text" name="serendipity[currentPoll][title]" value="' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($this->poll['title']) : htmlspecialchars($this->poll['title'], ENT_COMPAT, LANG_CHARSET)) . '">';
            echo '</div>';
        }

        if ($serendipity['version'][0] == '1') {
            echo '<br /><br /><table>';
            echo '<tr><th>' . TITLE . '</th>';
            echo '<th>&nbsp;</th>';
            echo '<th>&nbsp;</th>';
            echo '</tr>';

            foreach((array)$this->poll['options'] AS $optid => $option) {
                echo '<tr>';
                echo '<td><input class="input_textbox" type="text" name="serendipity[pollOptions][' . $optid . '][title]" value="' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($option['title']) : htmlspecialchars($option['title'], ENT_COMPAT, LANG_CHARSET)) . '" /></td>';
                echo '<td><input class="serendipityPrettyButton input_button" type="submit" name="serendipity[pollOptionRemove][' . $optid . ']" value="' . DELETE . '" /></td>';
                echo '<td>' . (int)$option['votes'] . ' ' . PLUGIN_POLL_VOTES . '</td>';
                echo '</tr>';
            }

            echo '<tr>';
            echo '<td><input class="input_textbox" type="text" name="serendipity[pollNewOption][title]" value="" /></td>';
            echo '<td colspan="2"><input class="serendipityPrettyButton input_button" type="submit" name="serendipity[pollOptionAdd]" value="' . PLUGIN_POLL_ADD . '" /></td>';
            echo '</tr>';
            echo '</table>';
        } else {
            echo '<h3>' . CREATE . '</h3>';
            echo '<ol class="plainList">';
            foreach((array)$this->poll['options'] AS $optid => $option) {
                echo '<li><div class="form_select">';
                echo '<label for="serendipity_polloption_' . $optid . '" class="block_level">' . TITLE . '</label>';
                echo ' <input id="serendipity_polloption_' . $optid . '" type="text" name="serendipity[pollOptions][' . $optid . '][title]" value="' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($option['title']) : htmlspecialchars($option['title'], ENT_COMPAT, LANG_CHARSET)) . '">';
                echo ' <input class="state_cancel" type="submit" name="serendipity[pollOptionRemove][' . $optid . ']" value="' . DELETE . '">';
                echo ' <span>' . (int)$option['votes'] . ' ' . PLUGIN_POLL_VOTES . '</span>';
                echo '</div></li>';
            }
                echo '<li><div class="form_select">';
                echo '<label for="serendipity_poll_newoption" class="block_level">' . TITLE . '</label>';
                echo ' <input id="serendipity_poll_newoption" type="text" name="serendipity[pollNewOption][title]" value="">';
                echo ' <input type="submit" name="serendipity[pollOptionAdd]" value="' . PLUGIN_POLL_ADD . '">';
                echo '</div></li>';
            echo '</ol>';
        }

        if ($serendipity['version'][0] == '1') {
            echo ' <input class="serendipityPrettyButton input_button" type="submit" name="serendipity[pollSave]" value="' . SAVE . '" />';
        } else {
            echo '<div class="form_buttons">';
            echo ' <input type="submit" name="serendipity[pollSave]" value="' . SAVE . '">';
            echo '</div>';
        }
    }

    function generate_content(&$title) {
        $title = PLUGIN_POLL_TITLE;
    }

    function install() {
        $this->setupDB();
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

                    if (empty($serendipity['GET']['subpage'])) {
                        $serendipity['GET']['subpage'] = $nice_url;
                    }
                    break;

                case 'entry_display':
                    if ($this->selected()) {
                        if (is_array($eventData)) {
                            $eventData['clean_page'] = true; // This is important to not display an entry list!
                        } else {
                            $eventData = array('clean_page' => true);
                        }
                    }

                    return true;
                    break;

                case 'backend_sidebar_entries':
                    if ($serendipity['serendipityUserlevel'] >= USERLEVEL_CHIEF) {
                        if ($serendipity['version'][0] == '1') {
                            echo '<li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=poll">' . PLUGIN_POLL_TITLE . '</a></li>';
                        } else {
                            echo '<li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=poll">' . PLUGIN_POLL_TITLE . '</a></li>';
                        }
                    }
                    return true;
                    break;

                case 'backend_sidebar_entries_event_display_poll':
                    $this->showBackend();
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
