<?php #

// serendipity_event_sidebarhide

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_sidebarhider extends serendipity_event
{
    var $title = PLUGIN_SIDEBAR_HIDER_NAME;
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_SIDEBAR_HIDER_NAME);
        $propbag->add('description',   PLUGIN_SIDEBAR_HIDER_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Tys von Gaza, Garvin Hicking');
        $propbag->add('version',       '1.25');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',    array(
            'external_plugin'    => true,
            'frontend_header'    => true,
            'css'                => true,
            'backend_sidebar_entries'   => true,
            'backend_sidebar_admin'     => true,
            'backend_sidebar_entries_event_display_sidebarhider'    => true,
            'frontend_generate_plugins' => true
        ));
        $propbag->add('groups', array('BACKEND_TEMPLATES'));
        $propbag->add('configuration', array('enable', 'style_sidebar_hidden','style_title_hidden','style_link','html_link_visible','html_link_hidden','plugin_list'));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'enable':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_SIDEBAR_HIDER_NAME);
                $propbag->add('description', '');
                $propbag->add('default',     true);
                break;

            case 'style_sidebar_hidden':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBAR_HIDER_STYLE_SIDEBAR);
                $propbag->add('description', PLUGIN_SIDEBAR_HIDER_STYLE_SIDEBAR_DESC);
                $propbag->add('default',     '');
                break;

            case 'style_title_hidden':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBAR_HIDER_STYLE_TITLE);
                $propbag->add('description', PLUGIN_SIDEBAR_HIDER_STYLE_TITLE_DESC);
                $propbag->add('default',     '');
                break;

            case 'style_link':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBAR_HIDER_STYLE_LINK);
                $propbag->add('description', PLUGIN_SIDEBAR_HIDER_STYLE_LINK_DESC);
                $propbag->add('default','text-decoration:none;float:right;margin-right:3px;');
                break;

            case 'html_link_visible':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBAR_HIDER_LINK_VISIBLE);
                $propbag->add('description', PLUGIN_SIDEBAR_HIDER_LINK_VISIBLE_DESC);
                $propbag->add('default','-');
                break;

            case 'html_link_hidden':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBAR_HIDER_LINK_HIDDEN);
                $propbag->add('description', PLUGIN_SIDEBAR_HIDER_LINK_HIDDEN_DESC);
                $propbag->add('default','+');
                break;

            default:
                return false;
        }
        return true;
    }


    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        $enabled = serendipity_db_bool($this->get_config('enable'));

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_generate_plugins': // This is the event that actually displays the plugins on your blog
                    $plugins =& $eventData;

                    $view_list = unserialize($this->get_config('view_list'));
                    if (!is_array($view_list)) {
                        $view_list = array();
                    }

                    $category_viewlist = unserialize($this->get_config('category_view_list'));
                    if (!is_array($category_viewlist)) {
                        $category_viewlist = array();
                    }

                    $usergroups_viewlist = unserialize($this->get_config('usergroups_view_list'));
                    if (!is_array($usergroups_viewlist)) {
                        $usergroups_viewlist = array();
                        $mygroups            = array();
                    } else {
                        $mygroups = serendipity_getGroups($serendipity['authorid']);
                    }

                    foreach ($plugins as $idx => $plugin_data) {
                        // First eliminate plugins that don't fit the member restrictions
                        if ($view_list[$plugin_data['name']] == 'member' && !$_SESSION['serendipityAuthedUser']) {
                            unset($plugins[$idx]);
                        } elseif (is_numeric($view_list[$plugin_data['name']]) && $serendipity['authorid'] != $view_list[$plugin_data['name']]) {
                            unset($plugins[$idx]);
                        } // if $view_list[plugin_name] is "everyone", we don't need to hide it. (--JAM: 2005-10-18)

                        // Now eliminate remaining plugins that don't fit the category restrictions (--JAM: 2005-10-18; was else for above)
                        if (isset($plugins[$idx]) ) {
                            if ($category_viewlist[$plugin_data['name']] != '') { //--JAM: 2005-10-18 allows non-numeric category specifiers
                                $selected = @explode(',', $category_viewlist[$plugin_data['name']]);
                                // Some category restrictions were specified.  Do we meet the restrictions?
                                if (isset($serendipity['GET']['category']) && !in_array($serendipity['GET']['category'], $selected)) {
                                    // We're in a category, and it's not in the selected list
                                    unset($plugins[$idx]);
                                } else if (isset($serendipity['GET']['id']) && isset($GLOBALS['entry']) && isset($GLOBALS['entry'][0]['categories'])) {
                                    $found = false;
                                    foreach($GLOBALS['entry'][0]['categories'] AS $cid => $cat) {
                                        if (in_array($cat['categoryid'], $selected)) {
                                            $found = true;
                                            break;
                                        }
                                    }

                                    if (!$found) {
                                        unset($plugins[$idx]);
                                    }
                                } else if (!isset($serendipity['GET']['category']) && !in_array(PLUGIN_SIDEBAR_HIDER_FRONTPAGE_ID, $selected)) {
                                    // (--JAM: 2005-10-18)
                                    // We're on the front/overview page, it's not in the selected list
                                    unset($plugins[$idx]);
                                }
                            }

                            if ($usergroups_viewlist[$plugin_data['name']] != '') {
                                $selected = @explode(',', $usergroups_viewlist[$plugin_data['name']]);

                                // Check if any of the allowed groups are inside the array $mygroup which contains the valid groups of the current author
                                $found = false;
                                foreach($mygroups AS $mygroup) {
                                    if ($found) continue;
                                    if (in_array($mygroup['id'], $selected)) {
                                        $found = true;
                                    }
                                }

                                if (!$found) {
                                    unset($plugins[$idx]);
                                }
                            }
                        }
                    }

                    return true;
                    break;

                case 'backend_sidebar_entries':
                    if ($serendipity['version'][0] == '1') {
                        echo '<li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=sidebarhider">'.PLUGIN_SIDEBAR_HIDER_ADMINLINK.'</a></li>';
                    }
                    return true;
                    break;

                case 'backend_sidebar_admin':
                    echo '<li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=sidebarhider">'.PLUGIN_SIDEBAR_HIDER_ADMINLINK.'</a></li>';
                    return true;
                    break;

                case 'backend_sidebar_entries_event_display_sidebarhider':
                    if (!$_REQUEST['sbh_action']) {
                        $this->admin_display();
                    } else if ($_REQUEST['sbh_action'] == 'save') {
                        $this->admin_save();
                        $this->admin_display();
                    }
                    return true;
                    break;


                case 'css':
                    if (!$enabled) {
                        return true;
                    }

                    if (!strpos($eventData,'.clearfix')) {
?>
                            .clearfix:after {
                                content: ".";
                                display: block;
                                height: 0;
                                clear: both;
                                visibility: hidden;
                            }
                            .clearfix {display: inline-table;}
                            /* Hides from IE-mac \*/
                            * html .clearfix {height: 1%;}
                            .clearfix {display: block;}
                            /* End hide from IE-mac */
<?php
                    }

                    if (!strpos($eventData, '.serendipitySideBarLink')) {
                        echo ".serendipitySideBarLink { " . $this->get_config('style_link') . "}\n";
                    }
                    break;

                case 'frontend_header':
                    if ($enabled && (!$serendipity['embed'] || $serendipity['embed'] === 'false' || $serendipity['embed'] === false)) {
                        // set up the java script
                        $style_sidebar_hidden = str_replace("'","\'",$this->get_config('style_sidebar_hidden'));
                        $style_title_hidden   = str_replace("'","\'",$this->get_config('style_title_hidden'));
                        $html_link_visible    = str_replace("'","\'",$this->get_config('html_link_visible'));
                        $html_link_hidden     = str_replace("'","\'",$this->get_config('html_link_hidden'));
                        $plugin_list          = unserialize($this->get_config('plugin_list'));

                        if (!$plugin_list) {
                            $plugin_list = array(array(), array());
                        }

                        if (count($plugin_list) < 2) {
                            $pa = "[[],";
                        } else {
                            $pa = "[";
                        }

                        foreach ($plugin_list as $key=>$side) {
                            $pa .= "[";
                            $pa .= implode(",", $side);
                            if ($key) {
                                $pa .= "]";
                            } else {
                                $pa .= "],";
                            }
                        }
                        $pa .= "]";

                        echo "\n";
                        echo '<script type="text/javascript">' . "\n";
                        echo "  var _sideBarVisibility = $pa;\n";
                        echo "  var _html_link_visible = '$html_link_visible';\n";
                        echo "  var _html_link_hidden = '$html_link_hidden';\n";
                        echo "</script>\n";
                        echo '<script type="text/javascript" src="' . $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/sidebarhider.js"></script>' . "\n";

                        // setup the CSS, this has to go after the big css is loaded to override some classes
                        echo "<style type='text/css'>\n";
                        echo "<!--\n";
                        echo ".serendipitySideBarItemHidden    { " . $this->get_config('style_sidebar_hidden') . "}\n";
                        echo "div.serendipitySideBarItemHidden { " . $this->get_config('style_sidebar_hidden') . "}\n";
                        echo ".serendipitySideBarTitleHidden   { " . $this->get_config('style_title_hidden') . "}\n";
                        echo "-->\n";
                        echo "</style>";

                    }
                    break;

                case 'external_plugin':
                    $uri_parts = explode('?', str_replace('&amp;', '&', $eventData));

                    // Try to get request parameters from eventData name
                    if (!empty($uri_parts[1])) {
                        $reqs = explode('&', $uri_parts[1]);
                        foreach($reqs AS $id => $req) {
                            $val = explode('=', $req);
                            if (empty($_REQUEST[$val[0]])) {
                                $_REQUEST[$val[0]] = $val[1];
                            }
                        }
                    }

                    $parts     = explode('[/&]', $uri_parts[0]);
                    if (!empty($parts[1])) {
                        $param     = (int) $parts[1];
                    } else {
                        $param     = null;
                    }

                    switch($parts[0]) {
                        case 'sidebarhider.js':
                            include dirname(__FILE__) . '/sidebarhider.js';
                            break;
                    }
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

    function admin_display() {
        global $serendipity;
        global $template_vars;
        $plugin_list = unserialize($this->get_config('plugin_list'));
        serendipity_smarty_init();

        $template_option = $serendipity['smarty']->get_template_vars('template_option');

        if (isset($template_vars['sidebars'])) {
            $sidebars = explode(',', $template_vars['sidebars']);
        } elseif (isset($serendipity['sidebars'])) {
            $sidebars = $serendipity['sidebars'];
        } elseif (isset($template_option['sidebars'])) {
            $sidebars = explode(',', $template_option['sidebars']);
        } else {
            $sidebars = array('left', 'hide', 'right');
        }

        $opts = array();
?>
            <form action="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=sidebarhider" method="post">
            <input type="hidden" name="sbh_action" value="save">
            <link rel="stylesheet" type="text/css" href="<?php echo serendipity_rewriteURL('serendipity.css');?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo serendipity_rewriteURL('serendipity_admin.css');?>" />
            <h3><?php echo PLUGIN_SIDEBAR_HIDER_CONF;?></h3>
            <div><?php echo PLUGIN_SIDEBAR_HIDER_CONF_DESC;?></div>
            <br />
            <input class="serendipityPrettyButton input_button" type="submit" name="submit" value="<?php echo SAVE_CHANGES_TO_LAYOUT;?>" /><br /><br />

            <table id="mainpane">
                <tr>
<?php
        foreach($sidebars AS $sidebar) {
            $plugins = serendipity_plugin_api::enum_plugins($sidebar);

            $up = strtoupper($sidebar);
            if ($sidebar == 'hide') {
                $opts[$sidebar] = HIDDEN;
            } elseif (defined('SIDEBAR_' . $up)) {
                $opts[$sidebar] = constant('SIDEBAR_' . $up);
            } elseif (defined($up)) {
                $opts[$sidebar] = constant($up);
            } else {
                $opts[$sidebar] = $up;
            }

            if ($sidebar == 'left') {
                $pside = 0;
            } elseif ($sidebar == 'right') {
                $pside = 1;
            } else {
                $pside = $sidebar;
            }

            echo '<td valign="top"><strong>' . $opts[$sidebar] . '</strong><br />';
            if (is_array($plugins)) {
                $this->admin_print_sidebar($plugins, $pside, $plugin_list);
            }
            echo '</td>' . "\n";
        }
?>
            </tr>
            </table>
            </form>
        <?php }

    function admin_print_sidebar(&$sidebar, $side, $plugin_list) {
        global $serendipity;

        $i = 0;
        $viewlist            = unserialize($this->get_config('view_list'));
        $category_viewlist   = unserialize($this->get_config('category_view_list'));
        $usergroups_viewlist = unserialize($this->get_config('usergroups_view_list'));
        $mygroups            = serendipity_getGroups($serendipity['authorid']);

        $enabled = serendipity_db_bool($this->get_config('enable'));
        foreach ($sidebar as $plugin_data) {
            $plugin =& serendipity_plugin_api::load_plugin($plugin_data['name'], $plugin_data['authorid'], $plugin_data['path']);
            if (is_object($plugin)) {
                $checked        = "";
                $checked_member = "";
                $checked_myself = "";
                $checked_everyone = "";

                if ($plugin_list[$side] && !$plugin_list[$side][$i]) {
                    $checked = "checked='checked'";
                }


                if ($viewlist[$plugin->instance] == 'member') {
                    $checked_member = "checked='checked'";
                } elseif ($viewlist[$plugin->instance] == 'myself' || $viewlist[$plugin->instance] == $serendipity['authorid']) {
                    $checked_myself = "checked='checked'";
                } elseif ($viewlist[$plugin->instance] == 'everyone') {
                    $checked_everyone = "checked='checked'";
                } else {
                    $checked_everyone = "checked='checked'";
                }

                $title = '';

                ob_start();
                $show_plugin = $plugin->generate_content($title);
                $content = ob_get_contents();
                ob_end_clean();

                if (empty($title)) {
                    $title = $plugin->get_config('backend_title');
                }

                echo "<div class='serendipitySideBarItem' style='margin-top:10px;margin-bottom:20px;'>\n";
                echo "<h3 class='serendipitySideBarTitle'>$title</h3>\n";
                echo "<div class='serendipitySideBarContent'><table>";
                if ($enabled) {
                    echo "<tr>\n";
                    echo "<td>".PLUGIN_SIDEBAR_HIDER_CONF_HIDDEN."</td>\n";
                    echo "<td><input class='input_checkbox' type='checkbox' name='plugin_".$side."_".$i."' $checked /></td>\n";
                    echo "</tr>";
                }

                //--JAM: 2005-10-18 Added "everyone" value to clear members and myself values
                echo "<tr>\n";
                echo "<td>".PLUGIN_SIDEBAR_HIDER_CONF_EVERYONE."</td>\n";
                echo "<td><input class='input_radio' type='radio' name='plugin_view[" . base64_encode($plugin->instance) . "]' value='everyone' $checked_everyone /></td>\n";
                echo "</tr>";

                echo "<tr>\n";
                echo "<td>".PLUGIN_SIDEBAR_HIDER_CONF_MEMBERS."</td>\n";
                echo "<td><input class='input_radio' type='radio' name='plugin_view[" . base64_encode($plugin->instance) . "]' value='member' $checked_member /></td>\n";
                echo "</tr>";

                echo "<tr>\n";
                echo "<td>".PLUGIN_SIDEBAR_HIDER_CONF_MYSELF."</td>\n";
                echo "<td><input class='input_radio' type='radio' name='plugin_view[" . base64_encode($plugin->instance) . "]' value='myself' $checked_myself /></td>\n";
                echo "</tr>";

                echo "<tr>\n";
                echo "<td colspan='2'>".GROUP."<br >\n";
                echo "<select name='plugin_usergroups_view[" . base64_encode($plugin->instance) . "][]' multiple='multiple'>\n";
                $selected_groups = explode(',', $usergroups_viewlist[$plugin->instance]);
                foreach($mygroups AS $group) {
                    if ('USERLEVEL_' == substr($group['confvalue'], 0, 10)) {
                        $group['name'] = constant($group['confvalue']);
                    }
?>
                    <option value="<?php echo $group['id']; ?>" <?php echo (in_array($group['id'], $selected_groups) ? 'selected="selected"' : ''); ?>><?php echo htmlspecialchars($group['name']); ?></option>
<?php
                }
                echo "</select></td>\n";
                echo "</tr>";

                echo "<tr>\n";
                echo "<td colspan='2'>".PLUGIN_SIDEBAR_HIDER_CONF_CATEGORIES."<br />\n";
                echo "\n";
                $selected = explode(',', $category_viewlist[$plugin->instance]);
                echo "<select name='plugin_category_view[" . base64_encode($plugin->instance) . "][]' multiple='multiple'>\n";
                // --JAM: 2005-10-18: The front page selection goes on the top
                echo '<option value="" ' . (in_array('', $selected) ? 'selected="selected"' : '') . '>' . htmlspecialchars(ALL_CATEGORIES) . '</option>' . "\n";
                echo '<option value="' . PLUGIN_SIDEBAR_HIDER_FRONTPAGE_ID . '" ' . (in_array(PLUGIN_SIDEBAR_HIDER_FRONTPAGE_ID, $selected) ? 'selected="selected"' : '') . '>' . htmlspecialchars(PLUGIN_SIDEBAR_HIDER_FRONTPAGE_DESC) . '</option>' . "\n";
                // Now add regular categories to the selection list
                $cats = serendipity_fetchCategories();
                if (is_array($cats)) {
                    $cats = serendipity_walkRecursive($cats, 'categoryid', 'parentid', VIEWMODE_THREADED);
                    foreach($cats as $cat) {
                        echo '<option value="' . $cat['categoryid'] . '" ' . (in_array($cat['categoryid'], $selected) ? 'selected="selected"' : '') . '>' . str_repeat('&nbsp;', $cat['depth']) . htmlspecialchars($cat['category_name']) . '</option>' . "\n";
                    }
                }

                echo "</select></td>\n";
                echo "</tr>";

                echo "</table></div>\n";
                echo "</div>\n";
            } else {
                echo ERROR . ': ' . $plugin_data['name'] . '<br />';
            }
            $i++;
        }
    }

    function admin_save() {
        global $serendipity;
        global $template_vars;

        serendipity_smarty_init();

        if (isset($template_vars['sidebars'])) {
            $sidebars = explode(',', $template_vars['sidebars']);
        } elseif (isset($serendipity['sidebars'])) {
            $sidebars = $serendipity['sidebars'];
        } else {
            $sidebars = array('left', 'hide', 'right');
        }

        $plugin_list          = array();
        $view_list            = array();
        $category_view_list   = array();
        $usergroups_view_list = array();

        foreach($sidebars AS $sidebar) {
            $plugins = serendipity_plugin_api::enum_plugins($sidebar);
            $i = 0;
            if (is_array($plugins)) {
                if ($sidebar == 'left') {
                    $pside = 0;
                } elseif ($sidebar == 'right') {
                    $pside = 1;
                } else {
                    $pside = $sidebar;
                }

                foreach ($plugins as $plugin) {
                    if (isset($_REQUEST['plugin_' . $pside . '_'.$i])) {
                        $plugin_list[$pside][$i] = 0;
                    } else {
                        $plugin_list[$pside][$i] = 1;
                    }
                    $i++;
                }
            }
        }

        $this->set_config('plugin_list', serialize($plugin_list));

        foreach((array)$_REQUEST['plugin_view'] AS $instance => $prop) {
            if ($prop == 'myself') {
                $view_list[base64_decode($instance)] = $serendipity['authorid'];
            } elseif ($prop == 'member') {
                $view_list[base64_decode($instance)] = 'member';
            } elseif ($prop == 'everyone') { //--JAM: 2005-10-18
                $view_list[base64_decode($instance)] = 'everyone';
            }
        }

        $this->set_config('view_list', serialize($view_list));

        foreach((array)$_REQUEST['plugin_category_view'] AS $instance => $prop) {
            $category_view_list[base64_decode($instance)] = implode(',', $prop);
        }

        $this->set_config('category_view_list', serialize($category_view_list));

        foreach((array)$_REQUEST['plugin_usergroups_view'] AS $instance => $prop) {
            $usergroups_view_list[base64_decode($instance)] = implode(',', $prop);
        }

        $this->set_config('usergroups_view_list', serialize($usergroups_view_list));

        echo '<div class="serendipityAdminMsgSuccess"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_success.png') . '" alt="" />' . sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%T')) . "<br /><br />\n</div>";
    }
}
