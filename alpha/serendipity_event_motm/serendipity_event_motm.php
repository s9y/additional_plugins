<?php
/*
Todo:
    - Implement fadder?
*/

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_motm extends serendipity_event {
    var $title = PLUGIN_SIDEBAR_MOTM_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_SIDEBAR_MOTM_NAME);
        $propbag->add('description',   PLUGIN_SIDEBAR_MOTM_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Tys von Gaza');
        $propbag->add('version',       '1.6');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',    array(
            'external_plugin'    => true,
            'css'                => true,
            'backend_sidebar_entries'   => true,
            'backend_sidebar_admin'     => true,
            'backend_sidebar_entries_event_display_motm'    => true
        ));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
        $propbag->add('configuration', array('note0','note1','note2','title', 'title_url', 'secret_key', 'css_track', 'css_slider', 'amazon_assoc', 'amazon_dev', 'show_where', 'song_info','streams'));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'note0':
                $propbag->add('type',    'content');
                $propbag->add('default', ' - ' .PLUGIN_SIDEBAR_MOTM_NOTE_EXTRA);
                break;

            case 'note1':
                $propbag->add('type',    'content');
                $propbag->add('default', ' - ' .PLUGIN_SIDEBAR_MOTM_NOTE_WRAP);
                break;

            case 'note2':
                $propbag->add('type',    'content');
                $secret_key = $this->get_config('secret_key',FALSE);
                if (!$secret_key)
                    $secret_key = PLUGIN_SIDEBAR_MOTM_KEY_KEY;
                $propbag->add('default', ' - ' .sprintf(PLUGIN_SIDEBAR_MOTM_NOTE_KEY,$serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/motm-update&track=%t&artist=%a&album=%b&genre=%g&tracktime=%y&secret_key=' . $secret_key));
                break;

            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        TITLE);
                $propbag->add('description', PLUGIN_SIDEBAR_MOTM_TITLE_DESC);
                $propbag->add('default',     PLUGIN_SIDEBAR_MOTM_NAME);
                break;

            case 'title_url':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBAR_MOTM_TITLE_URL);
                $propbag->add('description', PLUGIN_SIDEBAR_MOTM_TITLE_URL_DESC);
                $propbag->add('default',     '');
                break;

            case 'secret_key':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBAR_MOTM_KEY);
                $propbag->add('description', PLUGIN_SIDEBAR_MOTM_KEY_DESC);
                $propbag->add('default',     '');
                break;

            case 'css_track':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBAR_MOTM_TRACK);
                $propbag->add('description', PLUGIN_SIDEBAR_MOTM_TRACK_DESC);
                $propbag->add('default','border: 1px solid black;padding: 0;background-color: white;');
                break;

            case 'css_slider':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBAR_MOTM_SLIDER);
                $propbag->add('description', PLUGIN_SIDEBAR_MOTM_SLIDER_DESC);
                $propbag->add('default','color: white;background-color: black;margin: 0;text-align: right;padding: .1em;white-space: nowrap;');
                break;

            case 'amazon_assoc':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBAR_MOTM_AMAZON_ASSOC);
                $propbag->add('description', PLUGIN_SIDEBAR_MOTM_AMAZON_ASSOC_DESC);
                $propbag->add('default','tysvongazca-20');
                break;

            case 'amazon_dev':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBAR_MOTM_AMAZON_DEV);
                $propbag->add('description', PLUGIN_SIDEBAR_MOTM_AMAZON_DEV_DESC);
                $propbag->add('default','D37FFQXOC3MRYZ');
                break;

            case 'show_where':
                $select = array('extended' => PLUGIN_ITEM_DISPLAY_EXTENDED, 'overview' => PLUGIN_ITEM_DISPLAY_OVERVIEW, 'both' => PLUGIN_ITEM_DISPLAY_BOTH);
                $propbag->add('type',        'select');
                $propbag->add('select_values', $select);
                $propbag->add('name',        PLUGIN_ITEM_DISPLAY);
                $propbag->add('description', '');
                $propbag->add('default',     'both');
                break;

            default:
                return false;
        }
        return true;
    }


    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity, $motm_server_temp;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event]))
        {
            switch($event)
            {
                case 'backend_sidebar_entries':
                    if ($serendipity['version'][0] == '1') {
                        echo '<li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=motm">'.PLUGIN_SIDEBAR_MOTM_ADMIN_LINK.'</a></li>';
                    }
                    return true;
                    break;

                case 'backend_sidebar_admin':
                    echo '<li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=motm">'.PLUGIN_SIDEBAR_MOTM_ADMIN_LINK.'</a></li>';
                    return true;
                    break;

                case 'backend_sidebar_entries_event_display_motm':
                    $this->admin();
                    return true;
                    break;

                case 'css':
                    if (!strpos($eventData,'.clearfix'))
                    {
                        ob_start();
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
                        $csscontents = ob_get_contents();
                        ob_end_clean();
                        echo $csscontents;
                    }

                    if (!strpos($eventData, '#serendipity_motm_track'))
                        echo '#serendipity_motm_track { '.$this->get_config('css_track')."}\n";
                    if (!strpos($eventData, '#serendipity_motm_slider'))
                        echo '#serendipity_motm_slider { '.$this->get_config('css_slider')."}\n";
                    break;

                case 'external_plugin':
                    $uri_parts = explode('?', str_replace('&amp;', '&', $eventData));
                    $parts     = explode('/&', $uri_parts[0]);
                    switch($parts[0]) {
                        case 'motm.js':
                            include dirname(__FILE__) . '/motm.js';
                            break;

                        case 'motm-iframe':
                            $motm_server_temp['song_info'] = $this->get_config('song_info');
                            $motm_server_temp['streams'] = $this->get_config('streams');
                            include dirname(__FILE__) . '/motm_iframe.php';
                            break;

                        case 'motm-update':
                            if ($_REQUEST['secret_key'] == $this->get_config('secret_key', 'secret'))
                            {
                                $motm_server_temp['amazon_assoc'] = $this->get_config('amazon_assoc');
                                $motm_server_temp['amazon_dev'] = $this->get_config('amazon_dev');
                                // Start buffering
                                ob_start();
                                    include dirname(__FILE__) . '/motm_update.php';
                                    $contents = ob_get_contents();
                                // Stop buffering
                                ob_end_clean();
                                echo $contents;
                                $this->set_config('song_info', $contents);
                                $this->set_config('song_url', $_SERVER['REQUEST_URI']);
                            }
                            else
                            {
                                echo PLUGIN_SIDEBAR_MOTM_UPDATE_ERROR_KEY;
                                $this->set_config('song_info', PLUGIN_SIDEBAR_MOTM_UPDATE_ERROR_KEY);
                            }
                            break;
                        default:
                            return true;
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

    function generate_content(&$title)
    {
        global $serendipity, $motm_server_temp;

        $iframe_url = $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/motm-iframe';

        $title = $this->get_config('title', $title);
        $title_url = $this->get_config('title_url');
        if ($title_url)
            $title = '<a href="'.$title_url.'">'.$title.'</a>';

        $show_where = $this->get_config('show_where', 'both');

        if ($show_where == 'extended' && (!isset($serendipity['GET']['id']) || !is_numeric($serendipity['GET']['id']))) {
            return false;
        } else if ($show_where == 'overview' && isset($serendipity['GET']['id']) && is_numeric($serendipity['GET']['id'])) {
            return false;
        }
        // include the content!
        echo "\n<div name='motm_container' id='motm_container'></div>\n";
        echo '<script type="text/javascript" language="javascript1.2">' . "\n";
        $iframe_url = $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/motm-iframe';
        echo "  var _iframe_url = '$iframe_url';\n";
        echo "</script>\n";
        echo '<script type="text/javascript" src="' . $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/motm.js"></script>' . "\n";
        echo "<iframe src='$iframe_url' width='0' height='0' name='motm_iframe' id='motm_iframe' scrolling='no' frameborder='0' marginwidth='0' marginheight='0' style='display:hidden;'></iframe>\n";
    }

    function admin()
    {
        echo "<h3>".PLUGIN_SIDEBAR_MOTM_ADMIN_LINK."</h3>\n";
        switch($_REQUEST['motm_action'])
        {
            case 'add_commit':
                $this->admin_add_commit(); $this->admin_display(); break;
            case 'edit':
                $this->admin_edit(); break;
            case 'edit_commit':
                $this->admin_edit_commit(); $this->admin_display(); break;
            case 'delete':
                $this->admin_delete(); break;
            case 'delete_commit':
                $this->admin_delete_commit(); $this->admin_display(); break;
            default:
                $this->admin_display(); break;
        }
    }
    function admin_display()
    {
        echo "<div>\n";
        echo "<form action='?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=motm' method='post'>\n";
        echo "<input type='hidden' name='motm_action' value='add_commit'>\n";
        echo "<b>".PLUGIN_SIDEBAR_MOTM_ADMIN_ADD."</b><br/>\n";
        echo "<table>\n";
        echo "<tr><td>".PLUGIN_SIDEBAR_MOTM_ADMIN_ADD_MATCH."</td><td><input class='input_textbox' type='text' name='motm_match' size='60' /></td></tr>\n";
        echo "<tr><td>".PLUGIN_SIDEBAR_MOTM_ADMIN_ADD_NAME."</td><td><input class='input_textbox' type='text' name='motm_name' size='60' /></td></tr>\n";
        echo "<tr><td>".PLUGIN_SIDEBAR_MOTM_ADMIN_ADD_URL."</td><td><input class='input_textbox' type='text' name='motm_url' size='60' /></td></tr>\n";
        echo "<tr><td>".PLUGIN_SIDEBAR_MOTM_ADMIN_ADD_WS_NAME."</td><td><input class='input_textbox' type='text' name='motm_web_name' size='60' /></td></tr>\n";
        echo "<tr><td>".PLUGIN_SIDEBAR_MOTM_ADMIN_ADD_WS_URL."</td><td><input class='input_textbox' type='text' name='motm_web_url' size='60' /></td></tr>\n";
        echo "<tr><td><input class='serendipityPrettyButton input_button' type='submit' value='".PLUGIN_SIDEBAR_MOTM_ADMIN_ADD_SUBMIT."' /></td><td></td></tr>\n";
        echo "</table>";
        echo "</div>\n";

        echo "<div>\n";
        $streams = $this->get_config('streams');
        if ($streams && count($streams = unserialize($streams)))
        {
            echo "<b>".PLUGIN_SIDEBAR_MOTM_ADMIN_DISPLAY."</b><br/>\n";
            echo "<table width='100%'><tr><th align='left'>".PLUGIN_SIDEBAR_MOTM_ADMIN_DISPLAY_STREAM."</th><th>".PLUGIN_SIDEBAR_MOTM_ADMIN_DISPLAY_ACTION."</th></tr>\n";
            for($i = 0; $i < count($streams); $i++)
            {
                $stream = $streams[$i];
                echo "<tr>\n";
                if ($stream['motm_name'])
                    echo "<td>".$stream['motm_name']."</td>\n";
                else
                    echo "<td>".$stream['motm_match']."</td>\n";
                echo "<td align='center'>";
                echo "<a href='?serendipity[adminModule]=event_display&serendipity[adminAction]=motm&motm_action=edit&motm_id=$i'>".PLUGIN_SIDEBAR_MOTM_ADMIN_DISPLAY_EDIT."</a> ";
                echo "<a href='?serendipity[adminModule]=event_display&serendipity[adminAction]=motm&motm_action=delete&motm_id=$i'>".PLUGIN_SIDEBAR_MOTM_ADMIN_DISPLAY_DELETE."</a>";
                echo "</td>\n";
                echo "</tr>\n";
            }
            echo "</table>\n";
        }
        echo "</div>\n";
    }

    function admin_add_commit()
    {
        $streams = $this->get_config('streams');
        if ($streams)
        {
             $streams = unserialize($streams);
             if (!is_array($streams))
                $streams = array();
        }
        else
            $streams = array();

        $i = count($streams);
        $streams[$i] = array('motm_match' => $_REQUEST['motm_match'], 'motm_name' => $_REQUEST['motm_name'], 'motm_url' => $_REQUEST['motm_url'], 'motm_web_name' => $_REQUEST['motm_web_name'], 'motm_web_url' => $_REQUEST['motm_web_url']);
        $this->set_config('streams',serialize($streams));
        echo '<div class="serendipityAdminMsgSuccess"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_success.png') . '" alt="" />' . sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%T')) . '<br><br>\n</div>';
    }

    function admin_edit()
    {
        $streams = unserialize($this->get_config('streams'));
        $id = $_REQUEST['motm_id'];
        echo "<div>\n";
        echo "<form action='?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=motm&motm_id=$id' method='post'>\n";
        echo "<input type='hidden' name='motm_action' value='edit_commit'>\n";
        echo "<b>".PLUGIN_SIDEBAR_MOTM_ADMIN_EDIT."</b><br/>\n";
        echo "<table>\n";
        echo "<tr><td>".PLUGIN_SIDEBAR_MOTM_ADMIN_ADD_MATCH."</td><td><input class='input_textbox' type='text' name='motm_match' size='60' value='".$streams[$id]['motm_match']."' /></td></tr>\n";
        echo "<tr><td>".PLUGIN_SIDEBAR_MOTM_ADMIN_ADD_NAME."</td><td><input class='input_textbox' type='text' name='motm_name' size='60' value='".$streams[$id]['motm_name']."' /></td></tr>\n";
        echo "<tr><td>".PLUGIN_SIDEBAR_MOTM_ADMIN_ADD_URL."</td><td><input class='input_textbox' type='text' name='motm_url' size='60' value='".$streams[$id]['motm_url']."' /></td></tr>\n";
        echo "<tr><td>".PLUGIN_SIDEBAR_MOTM_ADMIN_ADD_WS_NAME."</td><td><input class='input_textbox' type='text' name='motm_web_name' size='60' value='".$streams[$id]['motm_web_name']."' /></td></tr>\n";
        echo "<tr><td>".PLUGIN_SIDEBAR_MOTM_ADMIN_ADD_WS_URL."</td><td><input class='input_textbox' type='text' name='motm_web_url' size='60' value='".$streams[$id]['motm_web_url']."' /></td></tr>\n";
        echo "<tr><td><table><tr><td><input class='serendipityPrettyButton input_button' type='submit' value='".PLUGIN_SIDEBAR_MOTM_ADMIN_DISPLAY_EDIT."' /></form></td><td><form action='?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=motm' method='post'><input class='serendipityPrettyButton input_button' type='submit' value='".PLUGIN_SIDEBAR_MOTM_ADMIN_CANCEL."' /></form></td></td></table></td><td></td></tr>\n";
        echo "</table>";
        echo "</div>\n";
    }

    function admin_edit_commit()
    {
        $streams = unserialize($this->get_config('streams'));
        $id = $_REQUEST['motm_id'];
        $streams[$id] = array('motm_match' => $_REQUEST['motm_match'], 'motm_name' => $_REQUEST['motm_name'], 'motm_url' => $_REQUEST['motm_url'], 'motm_web_name' => $_REQUEST['motm_web_name'], 'motm_web_url' => $_REQUEST['motm_web_url']);
        $this->set_config('streams',serialize($streams));
        echo '<div class="serendipityAdminMsgSuccess"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_success.png') . '" alt="" />' . sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%T')) . '<br><br>\n</div>';
    }

    function admin_delete()
    {
        $streams = unserialize($this->get_config('streams'));
        $id = $_REQUEST['motm_id'];
        echo PLUGIN_SIDEBAR_MOTM_ADMIN_DELETE." <b>". $streams[$id]['motm_match'] ."</b>?<br>\n";
        echo "<table><tr><td><form action='?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=motm&motm_action=delete_commit&motm_id=$id' method='post'><input class='serendipityPrettyButton input_button' type='submit' value='".PLUGIN_SIDEBAR_MOTM_ADMIN_DISPLAY_DELETE."' /></form></td>\n";
        echo "<td><form action='?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=motm' method='post'><input class='serendipityPrettyButton input_button' type='submit' value='".PLUGIN_SIDEBAR_MOTM_ADMIN_CANCEL."' /></form></td></td></table>\n";
    }

    function admin_delete_commit()
    {
        $streams = unserialize($this->get_config('streams'));
        $id = $_REQUEST['motm_id'];
        array_splice($streams, $id, 1);
        $this->set_config('streams',serialize($streams));
        echo '<div class="serendipityAdminMsgSuccess"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_success.png') . '" alt="" />' . sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%T')) . '<br><br>\n</div>';
    }
}
?>
