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

class serendipity_event_stalkerbuster extends serendipity_event {
    var $title = PLUGIN_STALKERBUSTER;

    function introspect(&$propbag) {
        global $serendipity;

        $this->title = $this->get_config('title', $this->title);
        $propbag->add('name',          PLUGIN_STALKERBUSTER);
        $propbag->add('description',   PLUGIN_STALKERBUSTER_DESC);
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('version',       '1.0');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('configuration', array(
            'mail',
            'cname'
        ));
        $propbag->add('event_hooks',    array(
            'frontend_configure' => true,
            'backend_sendmail' => true
        ));

    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch($name) {
            case 'mail':
                $propbag->add('name', 'E-Mail');
                $propbag->add('description', '');
                $propbag->add('type', 'string');
                $propbag->add('default', $serendipity['blogMail']);
                break;

            case 'cname':
                $propbag->add('name', 'Cookiename');
                $propbag->add('description', '');
                $propbag->add('type', 'string');
                $propbag->add('default', 'PHPSESSIDSB');
                break;
        }
    }

    function event_hook($event, &$bag, &$eventData) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_sendmail':
                    $eventData['message'] .= "\n" . 'StalkerBuster:' . $_COOKIE['serendipity'][$this->get_config('cname')] . "\n";
                    return true;

                case 'frontend_configure':
                    if (!isset($_COOKIE['serendipity'][$this->get_config('cname')])) {
                        serendipity_setCookie($this->get_config('cname'), uniqid('sb', true));
                    }
                    
                    $bl = @file_get_contents($serendipity['serendipityPath'] . '/stalkerbuster.php');
                    if (preg_match('@' . preg_quote($_COOKIE['serendipity'][$this->get_config('cname')]) . '@imsU', $bl)) {
                        mail($this->get_config('mail'), 'StalkerBuster', print_r($_REQUEST, true) . "\n" . print_r($_SERVER, true) . "\n");
                        header('HTTP/1.0 404 Not found');
                        header('Status: 404 Not found');
                        echo 'HTTP/1.0 404 Not found';
                        exit;
                    }
                    return true;
                    break;
            }
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>