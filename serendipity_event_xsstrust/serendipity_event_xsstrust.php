<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_xsstrust extends serendipity_event
{
    var $title = PLUGIN_EVENT_XSSTRUST_NAME;
    var $protected = true;
    var $trusted_authors = null;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_XSSTRUST_NAME);
        $propbag->add('description',   PLUGIN_EVENT_XSSTRUST_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '0.7.1');
        $propbag->add('event_hooks', array(
            'frontend_display' => true,
            'backend_media_check' => true,
            'backend_entry_presave' => true,
            ));
        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED', 'BACKEND_USERMANAGEMENT', 'MARKUP'));

        $propbag->add('configuration', array('trusted_authors', 'htmlpurifier'));

        $this->init_trusted();
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function getAuthors() {
        global $serendipity;

        $html = '<strong>' . PLUGIN_EVENT_XSSTRUST_AUTHORS . '</strong><br />';

        $users = (array)serendipity_fetchUsers();
        $valid =& $this->trusted_authors;

        $html .= '<select name="serendipity[plugin][trusted_authors][]" multiple="true">';
        foreach($users as $user) {
            $html .= '<option value="' . $user['authorid'] . '" ' . (isset($valid[$user['authorid']]) ? 'selected="selected"' : '') . '>' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($user['realname']) : htmlspecialchars($user['realname'], ENT_COMPAT, LANG_CHARSET)) . '</option>' . "\n";
        }

        $html .= '</select>';

        return $html;
    }

    /* Fetches a configuration value for this plugin */
    function get_config($name, $defaultvalue = null, $empty = true) {
        $_res = serendipity_get_config_var($this->instance . '/' . $name, '', $empty);

        if (is_null($_res)) {
            // A protected plugin by a specific owner may not have its values stored in $serendipity
            // because of the special authorid. To display such contents, we need to fetch it
            // seperately from the DB.
            $_res = serendipity_get_user_config_var($this->instance . '/' . $name, null, '');
        }

        if (is_null($_res)) {
            return '';
        }

        return $_res;
    }

    function init_trusted() {
        $ta = (array)explode(',', $this->get_config('trusted_authors'));
        $this->trusted_authors = array();

        foreach($ta AS $taidx => $authorid) {
            $this->trusted_authors[$authorid] = true;
        }
    }

    function set_config($name, $value, $implodekey = '^') {
        $fname = $this->instance . '/' . $name;

        if (is_array($value)) {
            $dbval = implode(',', $value);
        } else {
            $dbval = $value;
        }

        $_POST['serendipity']['plugin'][$name] = $dbval;

        $set = serendipity_set_config_var($fname, $dbval);
        $this->init_trusted();
        return $set;
    }


    function introspect_config_item($name, &$propbag) {
        switch ($name) {

            case 'trusted_authors':
                $propbag->add('type',          'content');
                $propbag->add('default',   $this->getAuthors());
                break;

            case 'htmlpurifier':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_XSSTRUST_HTMLPURIFIER);
                $propbag->add('description', PLUGIN_XSSTRUST_HTMLPURIFIER_DESC);
                $propbag->add('default', false);
                break;

            default:
                return false;
                break;
        }
        return true;
    }

    function recursive_purify(&$element, &$purifier) {
        if (is_array($element)) {
            foreach($element AS &$new_element) {
                $this->recursive_purify($new_element, $purifier);
            }
        } else {
            $element = $purifier->purify($element);
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_entry_presave':
                    if (serendipity_db_bool($this->get_config('htmlpurifier')) && !isset($this->trusted_authors[$serendipity['authorid']])) {
                        require_once dirname(__FILE__) . '/htmlpurifier-4.6.0-standalone/HTMLPurifier.standalone.php';
                        $config = HTMLPurifier_Config::createDefault();
                        $config->set('Cache.SerializerPath', $serendipity['serendipityPath'] . PATH_SMARTY_COMPILE);
                        $config->set('Core.Encoding', LANG_CHARSET);
                        $config->set('CSS.AllowImportant', true);
                        $purifier = new HTMLPurifier($config);

                        // We purify ALL THE STRINGS11!!!! [because custom entry properties etc. should not be allowed to have invalid markup]
                        $this->recursive_purify($eventData, $purifier);
                    }
                    break;

                case 'backend_media_check':
                    // Do not allow active files
                    $plug = preg_match('@\.(html?|js)$@i', $addData);
                    if ($plug) {
                        $eventData = true;
                    }
                    break;

                case 'frontend_display':
                    if (!isset($this->trusted_authors[$eventData['authorid']]) && !serendipity_db_bool($this->get_config('htmlpurifier'))) {
                        // Not trusted.
                        #$eventData['title']    = htmlspecialchars($eventData['title']);
                        $eventData['body']     = (function_exists('serendipity_specialchars') ? serendipity_specialchars($eventData['body']) : htmlspecialchars($eventData['body'], ENT_COMPAT, LANG_CHARSET));
                        $eventData['extended'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($eventData['extended']) : htmlspecialchars($eventData['extended'], ENT_COMPAT, LANG_CHARSET));
                    } else {
                        // Trusted.
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