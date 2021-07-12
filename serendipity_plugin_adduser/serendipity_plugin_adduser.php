<?php # 

include_once dirname(__FILE__) . '/common.inc.php';

class serendipity_plugin_adduser extends serendipity_plugin {
    var $title = PLUGIN_ADDUSER_NAME;
    var $usergroups = array();

    function introspect(&$propbag)
    {
        $propbag->add('name',          PLUGIN_ADDUSER_NAME);
        $propbag->add('description',   PLUGIN_ADDUSER_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('version',       '2.40.2');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('BACKEND_USERMANAGEMENT'));
        $propbag->add('configuration', array(
            'title',
            'instructions',
            'userlevel',
            'usergroups',
            'sidebar_login',
            'straight_insert',
            'approve',
            'use_captcha',

            # Default settings.
            'default_label',
            'no_create',
            'right_publish',
            'wysiwyg',
            'simpleFilters',
            'enableBackendPopup',
            'moderateCommentsDefault',
            'allowCommentsDefault',
            'showMediaToolbar',
            'use_autosave'
            )
        );
        $this->dependencies = array('serendipity_event_adduser' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'userlevel':
                $propbag->add('type',        'select');
                $propbag->add('name',        PLUGIN_ADDUSER_USERLEVEL);
                $propbag->add('description', PLUGIN_ADDUSER_USERLEVEL_DESC);
                $propbag->add('default',     USERLEVEL_EDITOR);
                $propbag->add('select_values', array(
                                                USERLEVEL_ADMIN  => PLUGIN_ADDUSER_USERLEVEL_ADMIN,
                                                USERLEVEL_CHIEF  => PLUGIN_ADDUSER_USERLEVEL_CHIEF,
                                                USERLEVEL_EDITOR => PLUGIN_ADDUSER_USERLEVEL_EDITOR,
                                                -1               => PLUGIN_ADDUSER_USERLEVEL_DENY
                ));
                break;

            case 'usergroups':
                $propbag->add('type',      'content');
                $propbag->add('default',   $this->getGroups());
                return true;
                break;

            case 'no_create':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        USERCONF_CREATE);
                $propbag->add('description', USERCONF_CREATE_DESC);
                $propbag->add('default',     false);
                break;

            case 'right_publish':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        USERCONF_ALLOWPUBLISH);
                $propbag->add('description', USERCONF_ALLOWPUBLISH_DESC);
                $propbag->add('default',     1);
                break;

            case 'straight_insert':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_ADDUSER_STRAIGHT);
                $propbag->add('description', PLUGIN_ADDUSER_STRAIGHT_DESC);
                $propbag->add('default',     false);
                break;

            case 'approve':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_ADDUSER_ADMINAPPROVE);
                $propbag->add('description', PLUGIN_ADDUSER_ADMINAPPROVE_DESC);
                $propbag->add('default',     false);
                break;

            case 'instructions':
                $propbag->add('type',        'html');
                $propbag->add('name',        PLUGIN_ADDUSER_INSTRUCTIONS);
                $propbag->add('description', PLUGIN_ADDUSER_INSTRUCTIONS_DESC);
                $propbag->add('default',     PLUGIN_ADDUSER_INSTRUCTIONS_DEFAULT);
                break;

            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        TITLE);
                $propbag->add('description', TITLE);
                $propbag->add('default',     PLUGIN_ADDUSER_NAME);
                break;

            case 'sidebar_login':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_SIDEBAR_LOGIN);
                $propbag->add('description', PLUGIN_SIDEBAR_LOGIN_DESC);
                $propbag->add('default',     true);
                break;

            case 'use_captcha':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_ADDUSER_CAPTCHA);
                $propbag->add('description', PLUGIN_ADDUSER_CAPTCHA_DESC);
                $propbag->add('default',     false);
                break;


            case 'default_label':
                $propbag->add('type',        'content');
                $propbag->add('default',     PLUGIN_ADDUSER_DEFAULTSETTINGS);
                break;

            case 'wysiwyg':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        INSTALL_WYSIWYG);
                $propbag->add('description', INSTALL_WYSIWYG_DESC);
                $propbag->add('default',     false);
                break;

            case 'simpleFilters':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        SIMPLE_FILTERS);
                $propbag->add('description', SIMPLE_FILTERS_DESC);
                $propbag->add('default',     true);
                break;

            case 'enableBackendPopup':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        INSTALL_BACKENDPOPUP);
                $propbag->add('description', INSTALL_BACKENDPOPUP_DESC);
                $propbag->add('default',     false);
                break;

            case 'moderateCommentsDefault':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        COMMENTS_MODERATE);
                $propbag->add('description', '');
                $propbag->add('default',     false);
                break;

            case 'allowCommentsDefault':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        COMMENTS_ENABLE);
                $propbag->add('description', '');
                $propbag->add('default',     true);
                break;

            case 'showMediaToolbar':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        SHOW_MEDIA_TOOLBAR);
                $propbag->add('description', '');
                $propbag->add('default',     false);
                break;

            case 'use_autosave':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        CONF_USE_AUTOSAVE);
                $propbag->add('description', CONF_USE_AUTOSAVE_DESC);
                $propbag->add('default',     true);
                break;

            default:
                    return false;
        }
        return true;
    }

    function set_config($name, $value, $implodekey = '^')
    {
        $fname = $this->instance . '/' . $name;

        if (is_array($value)) {
            $dbval = implode(',', $value);
        } else {
            $dbval = $value;
        }

        $_POST['serendipity']['plugin'][$name] = $dbval;

        return serendipity_set_config_var($fname, $dbval);
    }

    function &getGroups() {
        global $serendipity;

        if (!function_exists('serendipity_getAllGroups')) {
            $str = PLUGIN_ADDUSER_SERENDIPITY09;
            return $str;
        }

        $groups = serendipity_getAllGroups();

        $html = '<strong>' . USERCONF_GROUPS . '</strong><br />';

        if (is_array($serendipity['POST']['plugin']['usergroups'])) {
            $valid = $this->usergroups = array();
            foreach ($serendipity['POST']['plugin']['usergroups'] AS $idx => $id) {
                $valid[$id] = $id;
                $this->usergroups[$id] = $id;
            }
        } else {
            $valid =& $this->usergroups;
        }

        $html .= '<select name="serendipity[plugin][usergroups][]" multiple="true" size="5">';
        if (is_array($groups)) {
            foreach($groups AS $group) {
                $html .= '<option value="'. $group['id'] .'"'. (isset($valid[$group['id']]) ? ' selected="selected"' : '') .'>'. (function_exists('serendipity_specialchars') ? serendipity_specialchars($group['name']) : htmlspecialchars($group['name'], ENT_COMPAT, LANG_CHARSET)) .'</option>' . "\n";
            }
        }

        $html .= '</select>';

        return $html;
    }

    function generate_content(&$title) {
        global $serendipity;
        $title = $this->get_config('title');

        if (!serendipity_db_bool($this->get_config('sidebar_login', true))) {
            // Disable sidebar; Fallback to Event-Plugin.
            return false;
        }
        
        if (serendipity_userLoggedIn()) {
            return false;
        }

        $ug = (array)explode(',', $this->get_config('usergroups', false));

        foreach($ug AS $cid) {
            if ($cid === false || empty($cid)) {
                continue;
            }
            $this->usergroups[$cid] = $cid;
        }

        $url = serendipity_currentURL();
        $username = substr($serendipity['POST']['adduser_user'], 0, 40);
        $password = substr($serendipity['POST']['adduser_pass'], 0, 32);
        $email    = $serendipity['POST']['adduser_email'];

        echo '<div style="padding-left: 4px; padding-right: 10px"><a id="adduser"></a>';

        if (!serendipity_common_adduser::adduser($username, $password, $email, $this->get_config('userlevel', USERLEVEL_EDITOR), $this->usergroups, serendipity_db_bool($this->get_config('no_create', false)), serendipity_db_bool($this->get_config('right_publish', true)), serendipity_db_bool($this->get_config('straight_insert', false)), serendipity_db_bool($this->get_config('approve', false)), serendipity_db_bool($this->get_config('use_captcha', false)))) {
            serendipity_common_adduser::loginform($url, array(), $this->get_config('instructions'), $username, $password, $email, serendipity_db_bool($this->get_config('use_captcha', false)));
        }

        echo '</div>';

        return true;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
