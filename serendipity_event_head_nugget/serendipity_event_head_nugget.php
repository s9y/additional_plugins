<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_head_nugget extends serendipity_event
 {
    var $title = HEAD_NUGGET_TITLE;

    function introspect(&$propbag)
    {
        $propbag->add('name',          HEAD_NUGGET_TITLE);
        $propbag->add('description',   HEAD_NUGGET_HOLDS_A_BLAHBLAH);
        $propbag->add('configuration', array(
                                        'content'
                                       )
        );
        $propbag->add('event_hooks', array('frontend_header' => true));
        $propbag->add('author', 'Jannis Hermanns');
        $propbag->add('version', '1.5');
        $propbag->add('requirements',  array(
            'serendipity' => '1.6',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('stackable', true);
        $propbag->add('groups', array('BACKEND_METAINFORMATION'));
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        if ($event == 'frontend_header') {
            echo $this->get_config('content');
        }
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'content':
                $propbag->add('type',        'text');
                $propbag->add('name',        CONTENT);
                $propbag->add('description', THE_NUGGET);
                $propbag->add('default',     '');
                break;

            default:
                return false;
        }
        return true;
    }

}

?>