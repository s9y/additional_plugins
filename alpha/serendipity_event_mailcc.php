<?php # $Id$

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

class serendipity_event_mailcc extends serendipity_event
{
    var $title = 'Adds CC to all sent emails';

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          'Adds CC to all sent emails');
        $propbag->add('description',   '(Notice: Make sure that the all of your authors have the option to receiv comment notification emails activated, or else no mails will be created that can be CCed');
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('version',       '1.01');
        $propbag->add('requirements',  array('serendipity' => '0.8','smarty'      => '2.6.7','php'         => '4.1.0'
        ));
        $propbag->add('groups', array('BACKEND_FEATURES'));
        $propbag->add('event_hooks',   array('backend_sendmail' => true));
        $propbag->add('configuration', array('cc'));
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'cc':
            $propbag->add('type',        'string');
            $propbag->add('name',        'E-Mail address to CC');
            $propbag->add('description', '');
            $propbag->add('default',     'nobody@example.com');
            break;
        }
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;
        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_sendmail':
                    $eventData['headers'][] = 'CC: ' . $this->get_config('cc');
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
