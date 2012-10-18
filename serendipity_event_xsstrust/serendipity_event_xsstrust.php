<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

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
        $propbag->add('version',       '0.5');
        $propbag->add('event_hooks', array(
            'frontend_display' => true,
            'backend_media_check' => true));
        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED', 'BACKEND_USERMANAGEMENT', 'MARKUP'));

        $propbag->add('configuration', array('trusted_authors'));

        $ta = (array)explode(',', $this->get_config('trusted_authors'));
        $this->trusted_authors = array();

        foreach($ta AS $authorid) {
            $this->trusted_authors[$authorid] = true;
        }
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function getAuthors() {
        global $serendipity;

        $html = '<strong>' . PLUGIN_EVENT_XSSTRUST_AUTHORS . '</strong><br />';

        $html .= '<select name="serendipity[plugin][trusted_authors][]" multiple="true">';

        $users = (array)serendipity_fetchUsers();
        $valid =& $this->trusted_authors;
        foreach($users as $user) {
            $html .= '<option value="' . $user['authorid'] . '" ' . ($user['authorid'] == $serendipity['authorid'] || isset($valid[$user['authorid']]) ? 'selected="selected"' : '') . '>' . htmlspecialchars($user['realname']) . '</option>' . "\n";
        }

        $html .= '</select>';

        return $html;
    }

    /* Fetches a configuration value for this plugin */
    function get_config($name, $defaultvalue = null, $empty = true)
    {
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

    function introspect_config_item($name, &$propbag) {
        switch ($name) {

            case 'trusted_authors':
                $propbag->add('type',          'content');
                $propbag->add('default',   $this->getAuthors());
                break;

            default:
                return false;
                break;
        }
        return true;
    }

    function set_config($name, $value)
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

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_media_check':
                    // Do not allow active files
                    $plug = preg_match('@\.(html?|js)$@i', $addData);
                    if ($plug) {
                        $eventData = true;
                    }
                    break;

                case 'frontend_display':
                    if (!isset($this->trusted_authors[$eventData['authorid']])) {
                        // Not trusted.
                        #$eventData['title']    = htmlspecialchars($eventData['title']);
                        $eventData['body']     = htmlspecialchars($eventData['body']);
                        $eventData['extended'] = htmlspecialchars($eventData['extended']);
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