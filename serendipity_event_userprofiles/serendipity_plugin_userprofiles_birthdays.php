<?php # $Id$


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_plugin_userprofiles_birthdays extends serendipity_plugin {

    function introspect(&$propbag) {
        $propbag->add('name',        PLUGIN_USERPROFILES_BIRTHDAYSNAME);
        $propbag->add('description', PLUGIN_USERPROFILES_BIRTHDAYSNAME_DESCRIPTION);
        $propbag->add('author',      'Falk Doering');
        $propbag->add('stackable',   false);
        $propbag->add('version',     '0.3');
        $propbag->add('configuration', array('title', 'number'));
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups',       array('FRONTEND_VIEWS'));
        $this->dependencies = array('serendipity_event_userprofiles' => 'keep');
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_USERPROFILES_BIRTHDAYTITLE);
                $propbag->add('description', PLUGIN_USERPROFILES_BIRTHDAYTITLE_DESCRIPTION);
                $propbag->add('default',     PLUGIN_USERPROFILES_BIRTHDAYTITLE_DEFAULT);
                break;

            case 'number':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_USERPROFILES_BIRTHDAYNUMBERS);
                $propbag->add('description', '');
                $propbag->add('default',     '');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        global $serendipity;

        $title = $this->get_config('title');

        echo $this->displayBirthdayList();
    }

    function date_diff_days($start_date, $end_date)
    {

        if (date('dm', $start_date) == date('dm', $end_date)) {
            return 0;
        }
        if ($start_date < $end_date) {
            $res = ($start_date - $end_date);
        } else {
            $res = ($end_date - $start_date);
        }

        return (date('z', $res) + 1);
    }

    function displayBirthdayList() {
        global $serendipity;

        $userlist = serendipity_fetchUsers();
        $birthdays = $this->getBirthdays();

        foreach ($userlist as $user) {
            if (isset($birthdays[$user['authorid']])) {
                $res = $this->date_diff_days(time(), $birthdays[$user['authorid']]);
                $bdays[$res][] = array(
                    'name' => $user['realname'],
                    'date' => date("d.m.", $birthdays[$user['authorid']])
                );
            }
        }
        ksort($bdays);
        $max_running = (int)$this->get_config('number');
        $running = 0;
        foreach ($bdays as $key =>$bday) {
            if ($key > 0 && $max_running > 0 && $running > $max_running) {
                continue;
            }
            if ($key == 0) {
                echo '<strong>'.PLUGIN_USERPROFILES_BIRTHDAYTODAY.'</strong>';
            } else {
                echo '<strong>'.sprintf(PLUGIN_USERPROFILES_BIRTHDAYIN, $key).'</strong>';
            }
            echo '<div>';
            for ($i = 0, $ii = count($bday); $i < $ii; $i++) {
                if (strlen($content)) {
                    $content .= '<br />';
                }
                $content .= $bday[$i]['name'].' '.$bday[$i]['date'];
            }
            echo $content;
            echo '</div>';
            $content = '';
            $running++;
        }

    }

    function getBirthdays()
    {
        global $serendipity;

        $q = 'SELECT authorid, value
                FROM '.$serendipity['dbPrefix'].'profiles
               WHERE property = \'birthday\'';

        $res = serendipity_db_query($q, false, 'assoc');
        foreach ($res as $b) {
            $ret[$b['authorid']] = $b['value'];
        }
        return $ret;
    }

}
?>