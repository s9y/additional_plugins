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

class serendipity_event_head_nugget extends serendipity_event {
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
        $propbag->add('version', '1.3');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('stackable', true);
        $propbag->add('groups', array('BACKEND_METAINFORMATION'));
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        if ($event == 'frontend_header') echo $this->get_config('content');
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'content':
                $propbag->add('type',        'html');
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
