<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

// Subst Plugin for Serendipity
// 01/2006 by Thomas Nesges <thomas@tnt-computer.de>
// 12/2006  Andy Hopkins Added Greybox functionality. <andy.hopkins@gmail.com>
class serendipity_event_lightbox extends serendipity_event {

    var $title = PLUGIN_EVENT_LIGHTBOX_NAME;

    // Remembers, if an image link was found in the article. If not found, nor CSS nor JS will be added to the blog header.
    var $foundImageLink = false;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',           PLUGIN_EVENT_LIGHTBOX_NAME);
        $propbag->add('description',    PLUGIN_EVENT_LIGHTBOX_DESC);
        $propbag->add('author',         'Thomas Nesges, Andy Hopkins, Lokesh Dhakar, Cody Lindley, Stephan Manske, Grischa Brockhaus, Ian');
        $propbag->add('version',        '2.0.2');
        $propbag->add('requirements',  array(
            'serendipity' => '1.6',
            'php'         => '5.3.0'
        ));
        $propbag->add('event_hooks',     array('frontend_display' => true, 'frontend_header' => true, 'frontend_footer' => true ));
        $propbag->add('stackable',       false);
        $propbag->add('groups',          array('IMAGES'));
        $propbag->add('cachable_events', array('frontend_display' => true));

        $this->markup_elements = array(
            array(
              'name'     => 'ENTRY_BODY',
              'element'  => 'body',
            ),
            array(
              'name'     => 'EXTENDED_BODY',
              'element'  => 'extended',
            ),
            array(
              'name'     => 'COMMENT',
              'element'  => 'comment',
            ),
            array(
              'name'     => 'HTML_NUGGET',
              'element'  => 'html_nugget',
            )
        );

        $conf_array   = array();
        $conf_array[] = 'type';
        $conf_array[] = 'path';
        $conf_array[] = 'header_optimization';
        $conf_array[] = 'navigate_one_entry_only';
        $conf_array[] = 'init_js';
        foreach($this->markup_elements as $element) {
            $conf_array[] = $element['name'];
        }

        $propbag->add('configuration', $conf_array);
    }


    function generate_content(&$title) {
        $title = PLUGIN_EVENT_LIGHTBOX_NAME;
    }


    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch($name) {
            case 'navigate_one_entry_only':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_LIGHTBOX_GALLERY);
                $propbag->add('description',    '');
                $propbag->add('select_values',  array('none' => PLUGIN_EVENT_LIGHTBOX_GALLERY_NONE, 'entry' => PLUGIN_EVENT_LIGHTBOX_GALLERY_ENTRY, 'page' => PLUGIN_EVENT_LIGHTBOX_GALLERY_PAGE));
                $propbag->add('default',        'none');
                break;

            case 'type':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_LIGHTBOX_TYPE);
                $propbag->add('description',    '');
                $propbag->add('select_values',  array('colorbox' => 'ColorBox', 'lightbox2jq' => 'Lightbox 2 jQuery', 'magnific' => 'Magnific-Popup', 'prettyPhoto' => 'prettyPhoto'));
                $propbag->add('default',        'lightbox2jq');
                break;

            case 'path':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_LIGHTBOX_PATH);
                $propbag->add('description',    PLUGIN_EVENT_LIGHTBOX_PATH_DESC);
                $propbag->add('default',        $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_lightbox');
                break;

            case 'init_js':
                $propbag->add('type',           'text');
                $propbag->add('name',           PLUGIN_EVENT_LIGHTBOX_INIT_JS);
                $propbag->add('description',    PLUGIN_EVENT_LIGHTBOX_INIT_JS_DESC);
                $propbag->add('default',        '');
                break;

            case 'header_optimization':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION);
                $propbag->add('description',    PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION_DESC);
                $propbag->add('default',        'false');
                break;

            default:
                $propbag->add('type',           'boolean');
                $propbag->add('name',           defined($name) ? constant($name) : $name);
                $propbag->add('description',    sprintf(APPLY_MARKUP_TO, defined($name) ? constant($name) : $name));
                $propbag->add('default',        'true');
                break;

        }
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;
        static $regex     = null;
        static $sub       = null;
        static $navigate  = null;
        static $pluginDir = null;
        static $type      = null;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            if ($pluginDir === null) {
                $pluginDir = $this->get_config('path');
            }

            if ($type === null) {
                $type = $this->get_config('type');
            }

            if ($navigate === null) {
                $navigate = $this->get_config('navigate_one_entry_only');
            }

            if ($regex == null) {
                if ($type == 'lightbox2jq') {
                    $regex = '/<a([^>]+)(href=(["\'])[^"\']*\.(jpe?g|gif|png)["\'])/i';
                    $sub   = '<a $1 rel=$3lightbox$3 $2';
                } elseif ($type == 'prettyPhoto') {
                    $regex = '/<a([^>]+)(href=(["\'])[^"\']*\.(jpe?g|gif|png)["\'])/i';
                    $sub   = '<a rel=$3prettyPhoto$3 $1 $2';
                } elseif ($type == 'colorbox') {
                    $regex = '/<a([^>]+)(href=(["\'])[^"\']*\.(jpe?g|gif|png)["\'])/i';
                    $sub   = '<a $1 rel=$3singlebox$3 $2';
                } elseif ($type == 'magnific') {
                    $regex = '/<a([^>]+)(href=(["\'])[^"\']*\.(jpe?g|gif|png)["\'])/i';
                    $sub   = '<a rel=$3onemagnificPopup$3 $1 $2';
                }// do not use 'class' here as identifier, whenever possible, since this conflicts/not validates with $1 'class'es
            }

            switch($event) {
                case 'frontend_header':
                    $headcss = true;
                case 'frontend_footer':

                    // If no imagelink was processed, don't add css or js files to the header! (configurable optimization)
                    if (serendipity_db_bool($this->get_config('header_optimization', false)) && !$this->foundImageLink) {
                        return true;
                    }
                    echo "\n";
                    // ColorBox code (https://github.com/jackmoore/colorbox) - init with :visible to ensure to not show hidden elements via hideafter function in imageselectorplus ranges
                    if ($type == 'colorbox') {
                        if ($headcss) {
                            echo '    <link rel="stylesheet" type="text/css" href="' . $pluginDir . '/fixchrome.css" />' . "\n";
                            echo '    <link rel="stylesheet" type="text/css" href="' . $pluginDir . '/colorbox/colorbox.css" />' . "\n";
                        } else {
                            if (!class_exists('serendipity_event_jquery') && !$serendipity['capabilities']['jquery']) {
                                echo '    <script type="text/javascript" src="' . $pluginDir . '/jquery-1.11.1.min.js" charset="utf-8"></script>' . "\n";
                            }
                            echo '    <script type="text/javascript" src="' . $pluginDir . '/colorbox/jquery.colorbox-min.js" charset="utf-8"></script>' . "\n";
                            echo '    <script type="text/javascript" src="' . $pluginDir . '/colorbox/jquery.colorbox.init.js" charset="utf-8"></script>' . "\n";
                        }
                    }
                    // LightBox2 jQuery based - http://lokeshdhakar.com/projects/lightbox2/ - this lightbox does not allow to show :visible anchors only - it shows and counts all gallery images, if set to view galleries
                    elseif ($type == 'lightbox2jq') {
                        if ($headcss) {
                            echo '    <link rel="stylesheet" type="text/css" href="' . $pluginDir . '/lightbox2-jquery/css/lightbox.css" />' . "\n";
                        } else {
                            if (!class_exists('serendipity_event_jquery') && !$serendipity['capabilities']['jquery']) {
                                echo '    <script type="text/javascript" src="' . $pluginDir . '/jquery-1.11.1.min.js" charset="utf-8"></script>' . "\n";
                            }
                            // remove anchors possible onclick handler
                            echo '    <script type="text/javascript"> jQuery(document).ready(function(){ jQuery(\'a[rel^="lightbox"]\').removeAttr("onclick"); }); </script>' . "\n";
                            echo '    <script type="text/javascript" src="' . $pluginDir . '/lightbox2-jquery/js/lightbox.min.js" charset="utf-8"></script>' . "\n";
                        }
                    }
                    // Magnific-Popup code (https://github.com/dimsemenov/Magnific-Popup) - init with :visible to ensure to not show hidden elements via hideafter function in imageselectorplus ranges
                    elseif ($type == 'magnific') {
                        if ($headcss) {
                            echo '    <link rel="stylesheet" type="text/css" href="' . $pluginDir . '/fixchrome.css" />' . "\n";
                            echo '    <link rel="stylesheet" type="text/css" href="' . $pluginDir . '/magnific-popup/magnific-popup.css" />' . "\n";
                        } else {
                            if (!class_exists('serendipity_event_jquery') && !$serendipity['capabilities']['jquery']) {
                                echo '    <script type="text/javascript" src="' . $pluginDir . '/jquery-1.11.1.min.js" charset="utf-8"></script>' . "\n";
                            }
                            echo '    <script type="text/javascript" src="' . $pluginDir . '/magnific-popup/jquery.magnific-popup.min.js" charset="utf-8"></script>' . "\n";
                            echo '    <script type="text/javascript" src="' . $pluginDir . '/magnific-popup/jquery.magnific-popup.init.js" charset="utf-8"></script>' . "\n";
                        }
                    }
                    // PrettyPhoto code - http://www.no-margin-for-errors.com/projects/prettyPhoto/ - init with :visible to ensure to not show hidden elements via hideafter function in imageselectorplus ranges
                    elseif ($type == 'prettyPhoto') {
                        if ($headcss) {
                            echo '    <link rel="stylesheet" type="text/css" href="' . $pluginDir . '/fixchrome.css" />' . "\n";
                            echo '    <link rel="stylesheet" type="text/css" href="' . $pluginDir . '/prettyphoto/css/prettyPhoto.css" />' . "\n";
                            echo '    <link rel="stylesheet" type="text/css" href="' . $pluginDir . '/prettyphoto/css/prettyPhotoScreens.css" />' . "\n";
                        } else {
                            if (!class_exists('serendipity_event_jquery') && !$serendipity['capabilities']['jquery']) {
                                echo '    <script type="text/javascript" src="' . $pluginDir . '/jquery-1.11.1.min.js" charset="utf-8"></script>' . "\n";
                            }
                            // remove anchors possible onclick handler
                            echo '    <script type="text/javascript">jQuery(document).ready(function(){ jQuery(\'a[rel^="prettyPhoto"]\').removeAttr("onclick"); }); </script>' . "\n";
                            echo '    <script type="text/javascript" src="' . $pluginDir . '/prettyphoto/js/jquery.prettyPhoto.min.js" charset="utf-8"></script>' . "\n";
                            echo '    <script type="text/javascript">jQuery(document).ready(function(){ jQuery(\'a:visible[rel^="prettyPhoto"]\').prettyPhoto(' . $this->get_config('init_js') . '); }); </script>' . "\n";
                        }
                    }
                    return true;
                    break;

                case 'frontend_display':

                    if ($type == 'lightbox2jq') {
                        if ($navigate == 'entry') {
                            $sub   = '<a $1 rel=$3lightbox[' . $eventData['id'] . ']$3 $2';
                        } elseif ($navigate == 'page') {
                            $sub   = '<a $1 rel=$3lightbox[]$3 $2';
                        }
                    } elseif ($type == 'prettyPhoto') {
                        if ($navigate == 'entry') {
                            $sub   = '<a rel=$3prettyPhoto[' . $eventData['id'] . ']$3 $1 $2';
                        } elseif ($navigate == 'page') {
                            $sub   = '<a rel=$3prettyPhoto[]$3 $1 $2';
                        }
                    } elseif ($type == 'colorbox') {
                        if ($navigate == 'entry') {
                            $sub   = '<a rel=$3colorbox[' . $eventData['id'] . ']$3 $1 $2';
                        } elseif ($navigate == 'page') {
                            $sub   = '<a rel=$3colorbox[]$3 $1 $2';
                        }
                    } elseif ($type == 'magnific') {
                        if ($navigate == 'entry') {
                            $sub   = '<a rel=$3magnificPopup[' . $eventData['id'] . ']$3 $1 $2';
                        } elseif ($navigate == 'page') {
                            $sub   = '<a rel=$3magnificPopup[]$3 $1 $2';
                        }
                    }

                    foreach ($this->markup_elements as $temp) {
                        if (isset($eventData[$temp['element']]) && serendipity_db_bool($this->get_config($temp['name'], true)) &&
                                !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                                !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];

                            $replacement_count = 0;
                            $eventData[$element] = preg_replace($regex, $sub, $eventData[$element], -1,  $replacement_count);

                            // Remember if an image link was found
                            if ($replacement_count > 0) {
                                $this->foundImageLink = true;
                            }
                        }
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

    function install() {
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function uninstall(&$propbag) {
        serendipity_plugin_api::hook_event('backend_cache_purge', $this->title);
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function example() {
        // remove old lightbox script directory
        if (is_file(dirname(__FILE__) . '/lightbox/lightbox.js')) {
            $this->empty_dir(dirname(__FILE__) . '/lightbox');
            @rmdir(dirname(__FILE__) . '/lightbox');
        }
        // remove old lightbox2 script directory
        if (is_file(dirname(__FILE__) . '/lightbox2/lightbox2.js')) {
            $this->empty_dir(dirname(__FILE__) . '/lightbox2');
            @rmdir(dirname(__FILE__) . '/lightbox2');
        }
        // remove old lightbox plus script directory
        if (is_file(dirname(__FILE__) . '/lightbox_plus/lightbox_plus.js')) {
            $this->empty_dir(dirname(__FILE__) . '/lightbox_plus');
            @rmdir(dirname(__FILE__) . '/lightbox_plus');
        }
        // remove old thickbox script directory
        if (is_file(dirname(__FILE__) . '/thickbox/thickbox.js')) {
            $this->empty_dir(dirname(__FILE__) . '/thickbox');
            @rmdir(dirname(__FILE__) . '/thickbox');
        }
        // remove old graybox script directory
        if (is_file(dirname(__FILE__) . '/graybox/gb_scripts.js')) {
            $this->empty_dir(dirname(__FILE__) . '/graybox');
            @rmdir(dirname(__FILE__) . '/graybox');
            @unlink(dirname(__FILE__) . '/graycode_samples.txt');
        }
        // remove old greybox script directory
        if (is_file(dirname(__FILE__) . '/greybox/gb_scripts.js')) {
            $this->empty_dir(dirname(__FILE__) . '/greybox');
            @rmdir(dirname(__FILE__) . '/greybox');
        }
    }

    /**
     * empty a directory using the Standard PHP Library (SPL) iterator
     * @access    private
     * @param   string directory
     */
    private function empty_dir($dir) {
        if (!is_dir($dir)) return;
        try {
            $_dir = new RecursiveDirectoryIterator($dir);
            // NOTE: UnexpectedValueException thrown for PHP >= 5.3
            } catch (Exception $e) {
                return;
            }
        $iterator = new RecursiveIteratorIterator($_dir, RecursiveIteratorIterator::CHILD_FIRST);
        //$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                @unlink($file->__toString());
            } else {
                @rmdir($file->__toString());
            }
        }
        @rmdir(dir);
    }

}
