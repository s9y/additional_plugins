<?php # 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_kubrickheader extends serendipity_event {
    var $title = PLUGIN_EVENT_KUBRICKHEADER_NAME;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('style',         PLUGIN_EVENT_KUBRICKHEADER_STYLE);
        $propbag->add('name',          PLUGIN_EVENT_KUBRICKHEADER_NAME);
        $propbag->add('description',   PLUGIN_EVENT_KUBRICKHEADER_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Sebastian Mayeres, Jude Anthony');
        $propbag->add('version',       '1.5');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',   array('css' => true));
        $propbag->add('configuration', array('img','style', 'default_position'));
        $propbag->add('groups', array('IMAGES'));
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'img':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_KUBRICKHEADER_IMAGE);
                $propbag->add('description', PLUGIN_EVENT_KUBRICKHEADER_IMAGE_DESC);
                $propbag->add('default',     '/http-path/to/image.jpg');
                break;

            case 'style':
                $propbag->add('type',          'radio');
                $propbag->add('name',          PLUGIN_EVENT_KUBRICKHEADER_STYLE_DESC);
                $propbag->add('description',   PLUGIN_EVENT_KUBRICKHEADER_STYLE_DESC_BLAH);
                $propbag->add('radio',         array(
                    'value' => array('DEFAULT', 'KUBRICK', 'JOSHUA'),
                    'desc'  => array(PLUGIN_EVENT_KUBRICKHEADER_DEFAULT,
                                     PLUGIN_EVENT_KUBRICKHEADER_KUBRICK,
                                     PLUGIN_EVENT_KUBRICKHEADER_JOSHUA)
                ));
                $propbag->add('radio_per_row', '1');
                $propbag->add('default', 'DEFAULT');
                break;
            case 'default_position':
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_EVENT_KUBRICKHEADER_DEFAULT_POSITION);
                $propbag->add('description', PLUGIN_EVENT_KUBRICKHEADER_DEFAULT_POSITION_DESC);
                $select = array(
                    'top left'      => PLUGIN_EVENT_KUBRICKHEADER_DEFAULT_POSITION_TOPLEFT,
                    'top center'    => PLUGIN_EVENT_KUBRICKHEADER_DEFAULT_POSITION_TOPCENTER,
                    'top right'     => PLUGIN_EVENT_KUBRICKHEADER_DEFAULT_POSITION_TOPRIGHT,
                    'center left'   => PLUGIN_EVENT_KUBRICKHEADER_DEFAULT_POSITION_CENTERLEFT,
                    'center center' => PLUGIN_EVENT_KUBRICKHEADER_DEFAULT_POSITION_CENTERCENTER,
                    'center right'  => PLUGIN_EVENT_KUBRICKHEADER_DEFAULT_POSITION_CENTERRIGHT,
                    'bottom left'   => PLUGIN_EVENT_KUBRICKHEADER_DEFAULT_POSITION_BOTTOMLEFT,
                    'bottom center' => PLUGIN_EVENT_KUBRICKHEADER_DEFAULT_POSITION_BOTTOMCENTER,
                    'bottom right'  => PLUGIN_EVENT_KUBRICKHEADER_DEFAULT_POSITION_BOTTOMRIGHT
                );
                $propbag->add('select_values', $select);
                $propbag->add('default', PLUGIN_EVENT_KUBRICKHEADER_DEFAULT_POSITION_TOPRIGHT);
                break;
            case 'default_replace_text':
                // Not used yet, because I can't get the image height.
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_KUBRICKHEADER_DEFAULT_REPLACE_TEXT);
                $propbag->add('description', PLUGIN_EVENT_KUBRICKHEADER_DEFAULT_REPLACE_TEXT_DESC);
                $propbag->add('default', false);
                break;


        }
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'css':
                    $style = $this->get_config('style');
                    $img = $this->get_config('img');
                    $pimg = $_SERVER['DOCUMENT_ROOT'] . $img;
                    if (substr($pimg, -1) == '/' && is_dir($pimg)) {
                        $files = array();
                        if ($d = opendir($pimg)) {
                            while (($file = readdir($d)) !== false) {
                                if (preg_match('@(\.jpe?g|\.png|\.gif)$@i', $file) && !preg_match('@' . preg_quote($serendipity['thumbSuffix']) . '@i', $file)) {
                                    $files[] = $file;
                                }
                            }
                        }

                        if (count($files) > 0) {
                            shuffle($files);
                            $img = $img . $files[0];
                        }
                    }

                    if($style == 'JOSHUA') {
                        $eventData .= '#serendipity_banner { background: url("' . $img . '") no-repeat bottom center; }';
                        return true;
                        break;
                    } else if ($style == 'DEFAULT') {
                        $pos = $this->get_config('default_position', 'top right');
                        $eventData .= '#serendipity_banner{' . "\n" .
                          '  background-image: url("' . $img . '");' . "\n" .
                          '  background-repeat: no-repeat;' . "\n" .
                          '  background-position: ' . $pos . ';' . "\n";
                         // Replacement doesn't work yet; I'd have to replace
                         // the H1 or H2, and make it at least the image height
                         $replace = $this->get_config('default_replace_text', false);
                         if ($replace) {
                           $eventData .= '  text_indent: -5000px;' . "\n";
                         }
                         $eventData .= '}';
                    } else {
                        $eventData .= '#header { background: url("' . $img . '") no-repeat bottom center; }';
                        return true;
                        break;
                    }
            }
        }

        return false;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
