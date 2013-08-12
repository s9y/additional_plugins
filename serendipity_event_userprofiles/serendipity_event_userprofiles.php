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

class serendipity_event_userprofiles extends serendipity_event {

    var $title = PLUGIN_EVENT_USERPROFILES_TITLE;

    var $properties = array(
        'city'       => array('desc' => PLUGIN_EVENT_USERPROFILES_CITY,
                            'type' => 'string'),
        'street'     => array('desc' => PLUGIN_EVENT_USERPROFILES_STREET,
                            'type' => 'string'),
        'country'    => array('desc' => PLUGIN_EVENT_USERPROFILES_COUNTRY,
                            'type' => 'string'),
        'url'        => array('desc' => PLUGIN_EVENT_USERPROFILES_URL,
                            'type' => 'string'),
        'occupation' => array('desc' => PLUGIN_EVENT_USERPROFILES_OCCUPATION,
                            'type' => 'string'),
        'hobbies'    => array('desc' => PLUGIN_EVENT_USERPROFILES_HOBBIES,
                            'type' => 'html'),
        'yahoo'      => array('desc' => PLUGIN_EVENT_USERPROFILES_YAHOO,
                            'type' => 'string'),
        'aim'        => array('desc' => PLUGIN_EVENT_USERPROFILES_AIM,
                            'type' => 'string'),
        'jabber'     => array('desc' => PLUGIN_EVENT_USERPROFILES_JABBER,
                            'type' => 'string'),
        'icq'        => array('desc' => PLUGIN_EVENT_USERPROFILES_ICQ,
                            'type' => 'string'),
        'msn'        => array('desc' => PLUGIN_EVENT_USERPROFILES_MSN,
                            'type' => 'string'),
        'skype'      => array('desc' => PLUGIN_EVENT_USERPROFILES_SKYPE,
                            'type' => 'string'),
        'birthday'    => array('desc' => PLUGIN_EVENT_USERPROFILES_BIRTHDAY,
                            'type' => 'date')
    );

    var $option_properties = array(
        'show_email' => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWEMAIL,
                            'type' => 'boolean'),
        'show_city'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWCITY,
                            'type' => 'boolean'),
        'show_street' => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWSTREET,
                            'type' => 'boolean'),
        'show_country'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWCOUNTRY,
                            'type' => 'boolean'),
        'show_url'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWURL,
                            'type' => 'boolean'),
        'show_occupation'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWOCCUPATION,
                            'type' => 'boolean'),
        'show_hobbies'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWHOBBIES,
                            'type' => 'boolean'),
        'show_yahoo'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWYAHOO,
                            'type' => 'boolean'),
        'show_aim'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWAIM,
                            'type' => 'boolean'),
        'show_jabber'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWJABBER,
                            'type' => 'boolean'),
        'show_icq'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWICQ,
                            'type' => 'boolean'),
        'show_msn'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWMSN,
                            'type' => 'boolean'),
        'show_skype' => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWSKYPE,
                            'type' => 'boolean'),
        'show_birthday' => array('desc' => PLUGIN_EVENT_USERPROFILES_BIRTHDAY,
                            'type' => 'boolean')

    );

    var $found_images = array();

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',        PLUGIN_EVENT_USERPROFILES_TITLE);
        $propbag->add('description', PLUGIN_EVENT_USERPROFILES_DESC);
        $propbag->add('event_hooks', array(
            'backend_sidebar_entries_event_display_profiles'  => true,
            'backend_sidebar_admin' => true,
            'frontend_display' => true,
            'entries_header' => true,
            'css' => true,
            'frontend_display_cache' => true,
            'entry_display' => true, 
            'genpage' => true
        ));
        $propbag->add('author', 'Garvin Hicking, Falk Doering');
        $propbag->add('version', '0.27');
        $propbag->add('requirements', array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('stackable', false);
        $propbag->add('groups', array('BACKEND_USERMANAGEMENT','BACKEND_TEMPLATES'));
        $propbag->add('scrambles_true_content', true);
        $propbag->add('configuration', array('extension','authorpic','gravatar','gravatar_size','gravatar_default','gravatar_rating','commentcount'));

    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'authorpic':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_AUTHORPIC_ENABLED);
                $propbag->add('description', PLUGIN_EVENT_AUTHORPIC_ENABLED_DESC);
                $propbag->add('default', true);
                break;

            case 'extension':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_AUTHORPIC_EXTENSION);
                $propbag->add('description', PLUGIN_EVENT_AUTHORPIC_EXTENSION_BLAHBLAH);
                $propbag->add('default', 'jpg');
                break;

            case 'gravatar':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_USERPROFILES_GRAVATAR);
                $propbag->add('description', PLUGIN_USERPROFILES_GRAVATAR_DESC);
                $propbag->add('default', false);
                break;

            case 'gravatar_size':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_USERPROFILES_GRAVATAR_SIZE);
                $propbag->add('description', PLUGIN_USERPROFILES_GRAVATAR_SIZE_DESC);
                $propbag->add('default', "80");
                break;

            case 'gravatar_rating':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_USERPROFILES_GRAVATAR_RATING);
                $propbag->add('description', PLUGIN_USERPROFILES_GRAVATAR_RATING_DESC);
                $propbag->add('default', "R");
                break;

            case 'gravatar_default':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_USERPROFILES_GRAVATAR_DEFAULT);
                $propbag->add('description', PLUGIN_USERPROFILES_GRAVATAR_DEFAULT_DESC);
                $propbag->add('default', "");
                break;

            case 'commentcount':
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT);
                $propbag->add('description', PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_BLAHBLAH);
                $propbag->add('select_values', array(
                                                'off'     => NONE,
                                                'append'  => PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_APPEND,
                                                'prepend' => PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_PREPEND,
                                                'smarty'  => PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_SMARTY)
                                             );
                $propbag->add('default', 'append');
                break;

            default:
                    return false;
        }
        return true;
    }

    function &getLocalProperties() {
        return array(
            'realname' => array('desc' => USERCONF_REALNAME,
                                'type' => 'string'),
            'username' => array('desc' => USERCONF_USERNAME,
                                'type' => 'string'),
            'email'    => array('desc' => USERCONF_EMAIL,
                                'type' => 'string')
        );
    }

    function getShow($type, $user) {
        global $serendipity;

        $q = "SELECT value FROM {$serendipity['dbPrefix']}profiles WHERE authorid = '{$user}' AND property = '{$type}'";
        $sql = serendipity_db_query($q);
        return (is_array($sql)) ? $sql[0]['value'] : "false";
    }

    function checkUser(&$user) {
        global $serendipity;

        return ($user['userlevel'] < $serendipity['serendipityUserlevel'] || $user['authorid'] == $serendipity['authorid'] || $serendipity['serendipityUserlevel'] >= USERLEVEL_ADMIN);
    }

    function showUsers() {
        global $serendipity;

        if(!empty($serendipity['POST']['submitProfile'])) {
            echo '<div class="serendipityAdminMsgSuccess">' . DONE . ': ' . sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%H:%M:%S')) . '</div>';
        }

        if(!empty($serendipity['POST']['submitProfileOptions'])) {
            echo '<div class="serendipityAdminMsgSuccess">' . DONE . ': ' . sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%H:%M:%S')) . '</div>';
        }

        if(!empty($serendipity['POST']['createVcard'])) {
            if ($this->createVCard($serendipity['POST']['profileUser'])) {
                echo '<div class="serendipityAdminMsgSuccess">'. DONE . ': ' . sprintf(PLUGIN_EVENT_USERPROFILES_VCARDCREATED_AT, serendipity_strftime('%H:%M:%S')) . '</div>';
                echo '<div class="serendipityAdminMsgNote"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_note.png') . '" alt="" />'. IMPORT_NOTES . ': '. PLUGIN_EVENT_USERPROFILES_VCARDCREATED_NOTE . '</div>';
            }
            else {
                echo '<div class="serendipityAdminMsgError"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png') . '" alt="" />'. ERROR . ': ' . PLUGIN_EVENT_USERPROFILES_VCARDNOTCREATED . '</div>';
            }
        }

        echo '<form action="?" method="post">';
        echo '<input type="hidden" name="serendipity[adminModule]" value="event_display" />';
        echo '<input type="hidden" name="serendipity[adminAction]" value="profiles" />';
        echo '<div>';
        echo '<strong>' . htmlspecialchars(PLUGIN_EVENT_USERPROFILES_SELECT) . '</strong><br /><br />';
        echo USER . ' <select name="serendipity[profileUser]">';
        $users = serendipity_fetchUsers();
        foreach($users as $user) {
                echo '<option value="' . $user['authorid'] . '" ' . (((empty($serendipity['POST']['profileUser']) && ($serendipity['authorid'] == $user['authorid'])) || ($serendipity['POST']['profileUser'] == $user['authorid'])) ? 'selected="selected"' : '') . '>' . htmlspecialchars($user['realname']) . '</option>';
        }
        echo '</select>';
        echo ' <input class="serendipityPrettyButton input_button" type="submit" name="serendipity[viewUser]" value="'. VIEW .'" />';
        if ($this->checkUser($user)) {
            echo ' <input class="serendipityPrettyButton input_button" type="submit" name="submit" value="' . EDIT . '" />';
            echo ' <input class="serendipityPrettyButton input_button" type="submit" name="serendipity[editOptions]" value="'. ADVANCED_OPTIONS .'" />';
            ## very very bad the next line (show only when edit the local_properties)
            if (!empty($serendipity['POST']['profileUser']) && empty($serendipity['POST']['editOptions']) && empty($serendipity['POST']['viewUser'])) {
                echo ' <input class="serendipityPrettyButton input_button" type="submit" name="serendipity[createVcard]" value="' . PLUGIN_EVENT_USERPROFILES_VCARD . '" />';
            }
        }
        echo '</div><br /><hr />';

        if (!empty($serendipity['POST']['profileUser'])) {
            $user = serendipity_fetchUsers($serendipity['POST']['profileUser']);
            if ($this->checkUser($user[0])) {
                if (!empty($serendipity['POST']['viewUser']) && $serendipity['POST']['profileUser'] != $serendipity['authorid']) {
                    $this->showUser($user[0]);
                } elseif (!empty($serendipity['POST']['editOptions']) || !empty($serendipity['POST']['submitProfileOptions'])) {
                    $this->editOptions($user[0]);
                } else {
                    $this->editUser($user[0]);
                }
            } else {
                $this->showUser($user[0]);
            }
        } else {
            $user = serendipity_fetchUsers($serendipity['authorid']);
            $this->editUser($user[0]);
        }

    }

    function show() {
        global $serendipity;

        if ($this->selected()) {
            if (!headers_sent()) {
                header('HTTP/1.0 200');
                header('Status: 200 OK');
            }

            if (!is_object($serendipity['smarty'])) {
                serendipity_smarty_init();
            }

            $members =& serendipity_db_query("SELECT g.name     AS groupname,
                                                     COUNT(e.id) AS posts,
                                                     a.*
                                                FROM {$serendipity['dbPrefix']}authorgroups AS ag
                                     LEFT OUTER JOIN {$serendipity['dbPrefix']}groups AS g
                                                  ON g.id = ag.groupid
                                     LEFT OUTER JOIN {$serendipity['dbPrefix']}authors AS a
                                                  ON ag.authorid = a.authorid
                                     LEFT OUTER JOIN {$serendipity['dbPrefix']}entries AS e
                                                  ON e.authorid = a.authorid
                                               WHERE ag.groupid = " . (int)$serendipity['GET']['groupid'] . "
                                            GROUP BY a.authorid", false, 'assoc');

            $group = serendipity_fetchGroup((int)$serendipity['GET']['groupid']);
            if ('USERLEVEL_' == substr($group['name'], 0, 10)) {
                $group['name'] = constant($group['name']);
            }

            $serendipity['smarty']->assign(array(
                'staticpage_pagetitle' => 'userprofiles',
                'userprofile_groups'   => serendipity_getAllGroups(),
                'selected_group'       => (int)$serendipity['GET']['groupid'],
                'selected_group_data'  => $group,
                'selected_members'     => $members
            ));
            
            $tfile = serendipity_getTemplateFile('plugin_groupmembers.tpl', 'serendipityPath');
            if (!$tfile) {
                $tfile = dirname(__FILE__) . '/plugin_groupmembers.tpl';
            }
            $inclusion = $serendipity['smarty']->security_settings[INCLUDE_ANY];
            $serendipity['smarty']->security_settings[INCLUDE_ANY] = true;
            $content = $serendipity['smarty']->fetch('file:'. $tfile);
            $serendipity['smarty']->security_settings[INCLUDE_ANY] = $inclusion;

            echo $content;
        }
    }

    function selected() {
        global $serendipity;

        if ($serendipity['GET']['subpage'] == 'userprofiles') {
            return true;
        }

        return false;
    }

    /**
    *
    * View local properties from user
    *
    * @access private
    *
    * @param array $user  The Userproperties to show
    *
    */

    function showUser(&$user) {
        global $serendipity;

        echo '<table border="0" cellspacing="0" cellpadding="3" width="100%">';
        $local_properties =& $this->getLocalProperties();
        foreach($local_properties as $property => $info) {
            echo '<tr><td>'.$info['desc'].'</td><td>'.$user[$property].'</td></tr>';
        }
        echo '</table>';
    }

    function showCol($property, &$info, &$user) {
        echo '<tr>';
        echo '  <td>' . $info['desc'] . '</td>';
        echo '  <td>';
        switch($info['type']) {
            case 'html':
                echo '<textarea cols="80" rows="10" name="serendipity[profile' . $property . ']">' . htmlspecialchars($user[$property]) . "</textarea>\n";
                break;

            case 'boolean':
                $s = $this->getShow($property, $user['authorid']);
                echo sprintf(PLUGIN_EVENT_USERPROFILES_ILINK . "\n", $property . "true", ((serendipity_db_bool($s)) ? "checked='checked'" : ""), $property, "true", YES);
                echo sprintf(PLUGIN_EVENT_USERPROFILES_LABEL . "\n", $property . "true", YES);
                echo sprintf(PLUGIN_EVENT_USERPROFILES_ILINK . "\n", $property . "false", ((serendipity_db_bool($s)) ? "" : "checked='checked'"), $property, "false", NO);
                echo sprintf(PLUGIN_EVENT_USERPROFILES_LABEL . "\n", $property . "false", NO);
                break;

            case 'date':
                ?> <input class="input_textbox" type="text" name="serendipity[profile<?php echo $property; ?>_day]" value="<?php echo date("d", $user[$property]); ?>" size="2" maxlength="2" />.
                   <input class="input_textbox" type="text" name="serendipity[profile<?php echo $property; ?>_month]" value="<?php echo date("m", $user[$property]); ?>" size="2" maxlength="2" />.
                   <input class="input_textbox" type="text" name="serendipity[profile<?php echo $property; ?>_year]" value="<?php echo date("Y", $user[$property]); ?>" size="4" maxlength="4" />
                <?php
                break;

            case 'string':
            default:
                echo '<input class="input_textbox" type="text" name="serendipity[profile' . $property . ']" value="' . htmlspecialchars($user[$property]) . '" />';
        }
        echo '  </td>';
        echo '</tr>';
    }

    /**
    *
    * edit properties from user
    *
    * @access private
    *
    * @param array $user  The Userproperties to edit
    *
    */

    function editUser(&$user) {
        global $serendipity;

        if (isset($serendipity['POST']['submitProfile']) && isset($serendipity['POST']['profilebirthday_day']) && isset($serendipity['POST']['profilebirthday_month']) && isset($serendipity['POST']['profilebirthday_year'])) {
            if ($re = checkdate($serendipity['POST']['profilebirthday_month'], $serendipity['POST']['profilebirthday_day'], $serendipity['POST']['profilebirthday_year'])) {
                $serendipity['POST']['profilebirthday'] = mktime(0, 0, 0, $serendipity['POST']['profilebirthday_month'], $serendipity['POST']['profilebirthday_day'], $serendipity['POST']['profilebirthday_year']);
            }
            unset($serendipity['POST']['profilebirthday_month'], $serendipity['POST']['profilebirthday_day'], $serendipity['POST']['profilebirthday_year']);
        }

        echo '<table border="0" cellspacing="0" cellpadding="3" width="100%">';
        $local_properties =& $this->getLocalProperties();

        foreach($local_properties as $property => $info) {
            if (isset($serendipity['POST']['submitProfile']) && isset($serendipity['POST']['profile' . $property])) {
                $user[$property] = $serendipity['POST']['profile' . $property];
                serendipity_set_user_var($property, $user[$property], $user['authorid'], false);
            }

            $this->showCol($property, $info, $user);
        }

        $profile =& $this->getConfigVars($user['authorid']);

        foreach($this->properties as $property => $info) {
            if (isset($serendipity['POST']['submitProfile']) && isset($serendipity['POST']['profile' . $property])) {
                $user[$property]    = $serendipity['POST']['profile' . $property];
                $this->updateConfigVar($property, $profile, $user[$property], $user['authorid']);
                $profile[$property] = $user[$property];
            } else {
                $user[$property] = $profile[$property];
            }

            $this->showCol($property, $info, $user);
        }

        echo '</table>';
        echo '<input class="serendipityPrettyButton input_button" type="submit" name="serendipity[submitProfile]" value="' . SAVE . '" />';

    }

    function editOptions(&$user) {
        global $serendipity;

        echo '<table border="0" cellspacing="0" cellpadding="3" width="100%">';
        $profile =& $this->getConfigVars($user['authorid']);

        foreach($this->option_properties as $property => $info) {
            if (isset($serendipity['POST']['submitProfileOptions']) && isset($serendipity['POST']['profile' . $property])) {
                $user[$property]    = $serendipity['POST']['profile' . $property];
                $this->updateConfigVar($property, $profile, $user[$property], $user['authorid']);
                $profile[$property] = $user[$property];
            } else {
                $user[$property] = $profile[$property];
            }

            $this->showCol($property, $info, $user);
        }
        echo '</table>';
        echo '<input class="serendipityPrettyButton input_button" type="submit" name="serendipity[submitProfileOptions]" value="' . SAVE . '" />';

    }

    function &getConfigVars($authorid) {
        global $serendipity;

        $rows = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}profiles WHERE authorid = " . (int)$authorid);
        if (!is_array($rows)) {
            $empty = array();
            return $empty;
        }

        $profile = array();
        foreach($rows as $idx => $row) {
            $profile[$row['property']] = $row['value'];
        }

        return $profile;
    }

    function updateConfigVar($property, &$profile, $newvalue, $authorid) {
        global $serendipity;

        if (!isset($profile[$property])) {
            return serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}profiles (authorid, property, value) VALUES ('" . (int)$authorid . "', '" . serendipity_db_escape_string($property) . "', '" . serendipity_db_escape_string($newvalue) . "')");
        } else {
            return serendipity_db_query("UPDATE {$serendipity['dbPrefix']}profiles SET value = '" . serendipity_db_escape_string($newvalue) . "' WHERE property = '" . serendipity_db_escape_string($property) . "' AND authorid = " . (int)$authorid);
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'css':
                    if (strpos($eventData, '.serendipityAuthorProfile')) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        return true;
                    }
?>
.serendipityAuthorProfile {
    border: 1px solid #909090;
    width: 300px;
    margin-top: 5px;
    margin-bottom: 5px;
    margin-left: auto;
    margin-right: auto;
    padding: 10px;
}

.serendipityAuthorProfile dt {
    margin-top: 5px;
    font-weight: bold;
}

.serendipityAuthorProfile dd {
    margin-bottom: 5px;
}
.serendipity_authorpic {
    float: right;
    margin: 5px;
    border: 0px;
    display: block;
}

.serendipity_commentcount {
    float: right;
}
<?php
                    return true;
                    break;

                case 'entries_header':
                    if (!empty($serendipity['GET']['viewAuthor'])) {
                        $tfile = serendipity_getTemplateFile('plugin_userprofile.tpl', 'serendipityPath');
                        if (!$tfile) {
                            $tfile = dirname(__FILE__) . '/plugin_userprofile.tpl';
                        }
                        $inclusion = $serendipity['smarty']->security_settings[INCLUDE_ANY];
                        $serendipity['smarty']->security_settings[INCLUDE_ANY] = true;
                        $profile = $this->getConfigVars($serendipity['GET']['viewAuthor']);
                        $local_properties =& $this->getLocalProperties();
                        foreach($local_properties as $property => $info) {
                            $profile[$property] = $GLOBALS['uInfo'][0][$property];
                        }

                        $properties = array();
                        $properties = array_merge($this->properties, $this->option_properties);

                        $entry = array('body' => $profile['hobbies']);
                        serendipity_plugin_api::hook_event('frontend_display', $entry);
                        $profile['hobbies'] = $entry['body'];

                        $serendipity['smarty']->assign('userProfile', $profile);
                        $serendipity['smarty']->assign('userProfileProperties', $properties);
                        $serendipity['smarty']->assign('userProfileLocalProperties', $local_properties);
                        $serendipity['smarty']->assign('userProfileTitle', PLUGIN_EVENT_USERPROFILES_SHOW);

                        $content = $serendipity['smarty']->fetch('file:'. $tfile);
                        $serendipity['smarty']->security_settings[INCLUDE_ANY] = $inclusion;

                        echo $content;
                    }

                    $this->show();

                    break;

                case 'backend_sidebar_entries_event_display_profiles':
                    $this->checkSchema();
                    $this->showUsers();
                    return true;
                    break;

                case 'backend_sidebar_admin':
                    echo '<li class="serendipitySideBarMenuLink serendipitySideBarMenuUserManagement"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=profiles">' . PLUGIN_EVENT_USERPROFILES_TITLE . '</a></li>';
                    return true;
                    break;

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

                    if (version_compare($serendipity['version'], '0.7.1', '<=')) {
                        $this->show();
                    }

                    return true;
                    break;

                case 'frontend_display':
                    if ($bag->get('scrambles_true_content') && is_array($addData) && isset($addData['no_scramble'])) {
                        return true;
                    }

                case 'frontend_display_cache':
                    $this->showCommentcount($eventData);
                    if (!serendipity_db_bool($this->get_config('authorpic'))) {
                        return true;
                    }

                    if (empty($eventData['author'])) {
                        $tmp = serendipity_fetchAuthor($eventData['authorid']);
                        $author = $tmp[0]['realname'];
                    } else {
                        $author = $eventData['author'];
                    }

                    $authorname = $author;

                    if (isset($GLOBALS['i18n_filename_to'])) {
                        $author = str_replace($GLOBALS['i18n_filename_from'], $GLOBALS['i18n_filename_to'], $author);
                    }

                    if (serendipity_db_bool($this->get_config('gravatar'))) {
                        $img = 'http://www.gravatar.com/avatar.php?'
                                . 'default=' . $this->get_config('gravatar_default','80')
                                . '&amp;gravatar_id=' . md5($eventData['email'])
                                . '&amp;size=' . $this->get_config('gravatar_size','80')
                                . '&amp;border=&amp;rating=' . $this->get_config('gravatar_rating','R');
                        $this->found_images[$author] = '<div class="serendipity_authorpic"><img src="' . $img . '" alt="' . AUTHOR . '" title="' . htmlspecialchars($authorname) . '" /><br /><span>' . htmlspecialchars($authorname) . '</span></div>';
                        $eventData['body'] = $this->found_images[$author] . $eventData['body'];
                    } elseif (isset($this->found_images[$author])) {
                        // Author image was already found previously. Display it.
                        $eventData['body'] = $this->found_images[$author] . $eventData['body'];
                    } elseif ($img = serendipity_getTemplateFile('img/' . preg_replace('@[^a-z0-9]@i', '_', $author) . '.' . $this->get_config('extension'))) {
                        // Author image exists, save it in cache and display it.
                        $this->found_images[$author] = '<div class="serendipity_authorpic"><img src="' . $img . '" alt="' . AUTHOR . '" title="' . htmlspecialchars($authorname) . '" /><br /><span>' .htmlspecialchars($authorname) . '</span></div>';
                        $eventData['body'] = $this->found_images[$author] . $eventData['body'];
                    } else {
                         // No image found, do not try again in next article.
                        $this->found_images[$author] = '';
                    }
                    
                    // Assign smarty variable {$entry.authorpic}
                    $eventData['authorpic'] = $this->found_images[$author];

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

    function showCommentcount(&$eventData) {
        global $serendipity;
        static $commentcount = null;
        static $db_commentcount = null;

        if ($commentcount === null) {
            $commentcount = $this->get_config('commentcount');
        }

        if (!isset($eventData['comment']) || $commentcount == 'off') {
            return false;
        }

        if ($db_commentcount === null) {
            $dbc = serendipity_db_query("SELECT count(c.id) AS counter, c.author
                                    FROM {$serendipity['dbPrefix']}comments AS c
                                   WHERE c.entry_id = " . (int)$eventData['entry_id'] . "
                                GROUP BY c.author");
            $db_commentcount = array();
            if (is_array($dbc)) {
                foreach($dbc AS $row) {
                    $db_commentcount[$row['author']] = $row['counter'];
                }
            }
        }

        $c = $db_commentcount[$eventData['author']];
        $html_commentcount = '<div class="serendipity_commentcount">';
        if ($c == 1) {
            $html_commentcount .= COMMENT . ' (1)';
        } else {
            $html_commentcount .= COMMENTS . ' (' . $c . ')';
        }
        $html_commentcount .= '</div>';

        if ($commentcount == 'append') {
            $eventData['comment'] .= $html_commentcount;
        } elseif ($commentcount == 'prepend') {
            $eventData['comment'] = $html_commentcount . $eventData['comment'];
        }

        $eventData['plugin_commentcount'] = $html_commentcount;

        return true;
    }

    /**
    *
    * Create a vcard from user
    *
    * @access private
    *
    * @param int $authorid  The UserID to build the vcard
    *
    * @return bool
    *
    */

    function createVCard($authorid) {
        global $serendipity;

        include 'Contact_Vcard_Build.php';

        if(!class_exists('Contact_Vcard_Build')) {
            return false;
        }

        $authorres = $this->getConfigVars($authorid);
        $name = explode(" ", $serendipity['POST']['profilerealname']);
        $city = explode(" ", $serendipity['POST']['profilecity']);

        $vcard = new Contact_Vcard_Build();
        $vcard->setFormattedName($serendipity['POST']['profilerealname']);
        $vcard->setName($name[1], $name[0], "", "", "");
        $vcard->addEmail($serendipity['POST']['profileemail']);
        $vcard->addParam('TYPE', 'WORK');
        $vcard->addParam('TYPE', 'PREF');
        $vcard->addAddress(
            "",
            "",
            $serendipity['POST']['profilestreet'],
            $city[1],
            "",
            $city[0],
            $serendipity['POST']['profilecountry']
        );
        $vcard->addParam('TYPE', 'WORK');
        $vcard->setURL($serendipity['POST']['profileurl']);

        $card = $serendipity['serendipityPath'].$serendipity['uploadPath'].
            serendipity_makeFilename($serendipity['POST']['profilerealname']).".vcf";

        if(!$fp = @fopen($card,"w")) {
            return false;
        }

        fwrite($fp, $vcard->fetch());
        fclose($fp);
        $q = 'SELECT id
                FROM '.$serendipity['dbPrefix'].'images
               WHERE name = \''.serendipity_makeFilename($serendipity['POST']['profilerealname']).'\'
                 AND extension = \'vcf\'';
        $res = serendipity_db_query($q, true, 'assoc');
        if(!is_array($res)) {
            serendipity_insertImageInDatabase(basename($card),'');
        }

        return true;

    }

    function checkSchema() {
        global $serendipity;

        switch($this->get_config('dbversion')){
            case '':
                $q   = "CREATE TABLE {$serendipity['dbPrefix']}profiles (
                        authorid int(11) default '0',
                        property varchar(255) not null,
                        value text
                        );";
                $sql = serendipity_db_schema_import($q);

                $q   = "CREATE INDEX userprofile_idx ON {$serendipity['dbPrefix']}profiles (authorid);";
                $sql = serendipity_db_schema_import($q);

                $q   = "CREATE UNIQUE INDEX userprofile_uidx ON {$serendipity['dbPrefix']}profiles (authorid, property);";
                $sql = serendipity_db_schema_import($q);
                break;
        }
        $this->set_config('dbversion', PLUGIN_EVENT_USERPROFILES_DBVERSION);

    }

    function install() {
        global $serendipity;

        $this->checkSchema();
    }
}

/* vim: set sts=4 ts=4 expandtab : */
