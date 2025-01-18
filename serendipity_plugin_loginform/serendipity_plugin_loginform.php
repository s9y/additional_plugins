<?php # 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_loginform extends serendipity_plugin {
    function introspect(&$propbag)
    {
        $propbag->add('name',          PLUGIN_LOGINFORM_NAME);
        $propbag->add('description',   PLUGIN_LOGINFORM_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Neil Dudman');
        $propbag->add('version',       '1.09.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('configuration', array('title', 'login_url', 'logout_url'));
        $propbag->add('groups', array('FRONTEND_FEATURES'));

        // Register (multiple) dependencies. KEY is the name of the depending plugin. VALUE is a mode of either 'remove' or 'keep'.
        // If the mode 'remove' is set, removing the plugin results in a removal of the depending plugin. 'Keep' meens to
        // not touch the depending plugin.
        $this->dependencies = array('serendipity_event_loginform' => 'remove');
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        TITLE);
                $propbag->add('description', TITLE);
                $propbag->add('default',     '');
                break;
            case 'login_url':
                $propbag->add('type',        'string');
                $propbag->add('name',        LOGINURL_NAME);
                $propbag->add('description', LOGINURL_DESC);
                $propbag->add('default',     '');
                break;
    	    case 'logout_url':
                $propbag->add('type',        'string');
                $propbag->add('name',        LOGOUTURL_NAME);
                $propbag->add('description', LOGOUTURL_DESC);
                $propbag->add('default',     '');
                break;
            default:
                    return false;
        }
        return true;
    }

    function generate_content(&$title) {
        global $serendipity;

        $title = $this->get_config('title', $title);
        $login_url = $this->get_config('login_url');
        $logout_url = $this->get_config('logout_url');

        if ($login_url == "") {
            $login_url = serendipity_currentURL();
        }
        
        if ($logout_url == "") {
            $logout_url = serendipity_currentURL();
        }

        if (isset($serendipity['POST']['action']) && !isset($serendipity['POST']['logout']) && !serendipity_userLoggedIn()) {
            echo '<div class="serendipity_center serendipity_msg_important">' . WRONG_USERNAME_OR_PASSWORD . '</div>';
        } elseif (serendipity_userLoggedIn()) {
            echo '<div class="serendipity_center">' . WELCOME_BACK . ' ' . $_SESSION['serendipityUser'] . '</div>';
            echo '<form id="loginform" action="' . $logout_url . '" method="post">';
            echo '<input type="hidden" name="serendipity[logout]" value="true" />';
            echo '<input type="submit" name="serendipity[action]" value="' . LOGOUT . ' &gt;" />';

            $show_entry = false;
            $show_media = false;
            if (function_exists('serendipity_checkPermission')) {
                if (serendipity_checkPermission('adminEntries')) {
                    $show_entry = true;
                }

                if (serendipity_checkPermission('adminImages') && serendipity_checkPermission('adminImagesAdd')) {
                    $show_media = true;
                }
            } elseif (!$serendipity['no_create']) {
                $show_entry = true;
                $show_media = true;
            }


            if ($show_entry) {
                echo '<div class="loginform_link_entry"><a href="' . $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=entries&amp;serendipity[adminAction]=new">' . NEW_ENTRY . '</a></div>';
            }

            if ($show_media) {
                echo '<div class="loginform_link_media"><a href="' . $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=media&amp;serendipity[adminAction]=addSelect">' . ADD_MEDIA . '</a></div>';
            }

            echo '</form>';
            return true;
        }
        // Logout is performed in bundled event plugin!

        echo '<form id="loginform" action="' . $login_url . '" method="post">';
        echo '<fieldset id="loginform_userdata" style="border: none;">';
        echo '<label for="username">' . USERNAME . '</label>';
        echo '<input id="username" type="text" name="serendipity[user]" value="" />';
        echo '<label for="s9ypassw">' . PASSWORD . '</label>';
        echo '<input id="s9ypassw" type="password" name="serendipity[pass]" value="" />';
        echo '</fieldset>';
        echo '<fieldset id="loginform_login" style="border: none;">';
        echo '<input id="autologin" type="checkbox" name="serendipity[auto]" /><label for="autologin"> ' . AUTOMATIC_LOGIN . '</label>';
        echo '<input type="submit" id="loginform_submit" name="serendipity[action]" value="' . LOGIN . ' &gt;" />';
        echo '</fieldset>';
        echo '</form>';

        if (class_exists('serendipity_event_forgotpassword')) {
            echo '<div class="forgot_password"><a href="' . $serendipity['baseURL'] . '/serendipity_admin.php?forgotpassword=1">' . PLUGIN_EVENT_FORGOTPASSWORD_LOST_PASSWORD . '</a></div>';
        }

        return true;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
