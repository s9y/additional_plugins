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
//12/2006  Andy Hopkins Added Greybox functionality. <andy.hopkins@gmail.com>
class serendipity_event_lightbox extends serendipity_event {

    var $title = PLUGIN_EVENT_LIGHTBOX_NAME;
    
    // Remembers, if an image link was found in the article. If not found, nor CSS nor JS will be added to the blog header.
    var $foundImageLink = false;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',           PLUGIN_EVENT_LIGHTBOX_NAME);
        $propbag->add('description',    PLUGIN_EVENT_LIGHTBOX_DESC);
        $propbag->add('author',         'Thomas Nesges, Andy Hopkins, Lokesh Dhakar, Cody Lindley, Stephan Manske, Grischa Brockhaus');
        $propbag->add('version',        '1.9.8');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',    array('frontend_display' => true, 'frontend_header' => true ));
        $propbag->add('stackable',      false);
        $propbag->add('groups',         array('IMAGES'));
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

        $conf_array = array();
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
                $propbag->add('select_values',  array('lightbox2' => 'Lightbox 2', 'lightbox' => 'Lightbox 1', 'lightbox_plus' => 'Lightbox plus', 'prettyPhoto' => 'prettyPhoto', 'thickbox' => 'Thickbox', 'greybox'=> 'Greybox'));
                $propbag->add('default',        'lightbox');
                break;

            case 'path':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_LIGHTBOX_PATH);
                $propbag->add('description',    PLUGIN_EVENT_LIGHTBOX_PATH_DESC);
                $propbag->add('default',        str_replace('//', '/', $serendipity['serendipityHTTPPath'] . preg_replace('@^.*(/plugins.*)@', '$1', dirname(__FILE__))));
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
        static $regex = null;
        static $sub   = null;
        static $navigate = null;
        static $pluginDir = null;
        static $type      = null;

        $hooks     = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            if ($pluginDir === null) {
                $pluginDir = $this->get_config('path');
            }
            
            if ($type === null) {
                $type      = $this->get_config('type');
            }

            if ($navigate === null) {
                $navigate  = $this->get_config('navigate_one_entry_only');
            }
                    
            if ($regex == null) {
                if ($type == 'lightbox' || $type == 'lightbox_plus' || $type == 'lightbox2') {
                    $regex = '/<a([^>]+)(href=(["\'])[^"\']*\.(jpe?g|gif|png)["\'])/i';
                    $sub   = '<a $1 rel=$3lightbox$3 $2';
                } elseif ($type == 'prettyPhoto') {
                    $regex = '/<a([^>]+)(href=(["\'])[^"\']*\.(jpe?g|gif|png)["\'])/i';
                    $sub   = '<a rel=$3prettyPhoto$3 $1 $2';
                } elseif ($type == 'thickbox') {
                    $regex = '/<a([^>]+)(href=(["\'])[^"\']*\.(jpe?g|gif|png)["\'])/i';
                    $sub   = '<a class=$3thickbox$3 $1 $2';
                } elseif ($type == 'graybox' || $type == 'greybox') {
                   $regex = '/<a([^>]+)(href=(["\'])[^"\']*\.(jpe?g|gif|png)["\'])/i';
                   $sub   = '<a $1 rel=$3gb_image[]$3 $2';
                }
            }



            switch($event) {
                case 'frontend_header':

                    // If no imagelink was processed, don't add css or js files to the header! (configurable optimization)
                    if (serendipity_db_bool($this->get_config('header_optimization', false)) && !$this->foundImageLink) {
                        return true;
                    }

                    if ($type == 'lightbox') {
    					echo '<script type="text/javascript">var lightbox_path = "' . $pluginDir . '/lightbox";</script>' . "\n";
                        echo '<script type="text/javascript" src="' . $pluginDir . '/lightbox/lightbox.js"></script>' . "\n";
                        echo '<link rel="stylesheet" type="text/css" href="' . $pluginDir.  '/lightbox/lightbox.css" />' . "\n";
                    } 
					// Lightbox Plus code
					elseif ($type == 'lightbox_plus') {
    					echo '<script type="text/javascript">var lightbox_path = "' . $pluginDir . '/lightbox_plus";</script>' . "\n";
                        echo '<script type="text/javascript" src="' . $pluginDir . '/lightbox_plus/spica.js"></script>' . "\n";
                        echo '<script type="text/javascript" src="' . $pluginDir . '/lightbox_plus/lightbox_plus.js"></script>' . "\n";
                        echo '<link rel="stylesheet" type="text/css" href="' . $pluginDir.  '/lightbox_plus/lightbox_plus.css" />' . "\n";
                    } 
					// Light Box 2 code
					elseif ($type == 'lightbox2') {
    					echo '<script type="text/javascript">var lightbox_path = "' . $pluginDir . '/lightbox2";</script>' . "\n";
                        echo '<script type="text/javascript" src="' . $pluginDir . '/lightbox2/prototype.js"></script>' . "\n";
                        echo '<script type="text/javascript" src="' . $pluginDir . '/lightbox2/scriptaculous.js?load=effects,builder"></script>' . "\n";
                        echo '<script type="text/javascript" src="' . $pluginDir . '/lightbox2/lightbox2.js"></script>' . "\n";
                        echo '<link rel="stylesheet" type="text/css" href="' . $pluginDir.  '/lightbox2/lightbox2.css" />' . "\n";
                    } 
					// prettyPhoto code
					elseif ($type == 'prettyPhoto') {
    					echo '<script type="text/javascript">var prettyphoto_path = "' . $pluginDir . '/prettyphoto";</script>' . "\n";
    			if (!class_exists('serendipity_event_jquery')) echo '<script type="text/javascript" src="' . $pluginDir . '/prettyphoto/js/jquery-1.6.1.min.js"></script>' . "\n";
                        echo '<script type="text/javascript" src="' . $pluginDir . '/prettyphoto/js/jquery.prettyPhoto.js"></script>' . "\n";
                        echo '<link rel="stylesheet" type="text/css" href="' . $pluginDir.  '/prettyphoto/css/prettyPhoto.css" />' . "\n";
                        echo '<script type="text/javascript" charset="utf-8">jQuery(document).ready(function(){ jQuery("a[rel^=\'prettyPhoto\']").prettyPhoto(' . $this->get_config('init_js') . ');});</script>' . "\n";
                    } 
					// Thick Box code http://jquery.com/demo/thickbox/
					elseif ($type == 'thickbox') {
    					echo '<script type="text/javascript">var thickbox_path = "' . $pluginDir . '/thickbox";</script>' . "\n";
    			    	echo '<link rel="stylesheet" type="text/css" href="' . $pluginDir . '/thickbox/thickbox.css" />' . "\n";
    					echo '<script type="text/javascript">var thickbox_path = "'.$serendipity['baseURL']  . $pluginDir . '/thickbox";</script>' . "\n"; 
                        echo '<script type="text/javascript" src="' . $pluginDir . '/thickbox/thickbox_jquery.js"></script>' . "\n";
    					echo '<script type="text/javascript" src="' . $pluginDir . '/thickbox/thickbox.js"></script>' . "\n";
                    }
					// Greybox Code http://orangoo.com/labs/GreyBox/
					elseif ($type == 'graybox' || $type == 'greybox') {
    			    	echo '<script type="text/javascript"> var GB_ROOT_DIR = "'. $pluginDir.'/greybox/";</script>' . "\n";
						echo '<script type="text/javascript" src="' . $pluginDir.'/greybox/AJS.js"></script>' . "\n";
						echo '<script type="text/javascript" src="'. $pluginDir.'/greybox/AJS_fx.js"></script>';
						echo '<script type="text/javascript" src="'. $pluginDir.'/greybox/gb_scripts.js"></script>' . "\n";
						echo '<link href="'. $pluginDir.'/greybox/gb_styles.css" rel="stylesheet" type="text/css"/>' . "\n";
					}
                    return true;
                    break;

                case 'frontend_display':

                    if ($type == 'lightbox_plus' || $type == 'lightbox2') {
                        if ($navigate == 'entry') {
                            $sub   = '<a $1 rel=$3lightbox[lightbox_group_entry_' . $eventData['id'] . ']$3 $2';
                        } elseif ($navigate == 'page') {
                            $sub   = '<a $1 rel=$3lightbox[lightbox_group_entry]$3 $2';
                        }
                    } elseif ($type == 'prettyPhoto') {
                        if ($navigate == 'entry') {
                            $sub   = '<a rel=$3prettyPhoto[' . $eventData['id'] . ']$3 $1 $2';
                        } elseif ($navigate == 'page') {
                            $sub   = '<a rel=$3prettyPhoto[]$3 $1 $2';
                        }
                    } elseif ($type == 'thickbox') {
                        if ($navigate == 'entry') {
                            $sub   = '<a class=$3thickbox$3 rel=$3thickbox_group_entry_' . $eventData['id'] . '$3 $1 $2';
                        } elseif ($navigate == 'page') {
                            $sub   = '<a class=$3thickbox$3 rel=$3thickbox_group_entry$3 $1 $2';
                        }
                    } elseif ($type == 'graybox' || $type == 'greybox') {
                        if ($navigate == 'entry') {
                            $sub   = '<a $1 rel=$3gb_imageset[greybox_group_entry_' . $eventData['id'] . ']$3 $2';
                        } elseif ($navigate == 'page') {
                            $sub   = '<a $1 rel=$3gb_imageset[greybox_group_entry]$3 $2';
                        }
                    }
        
                    foreach ($this->markup_elements as $temp) {
                        if (isset($eventData[$temp['element']]) && serendipity_db_bool($this->get_config($temp['name'], true)) &&
                                !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                                !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];

                            // preg_replace with replacement counter is available only from PHP 5.1 on
                            if (version_compare(PHP_VERSION, '5.1', '>=')) {
                                $replacement_count = 0;
                                $eventData[$element] = preg_replace($regex, $sub, $eventData[$element], -1,  $replacement_count);
                                
                                // Remember if an image link was found
                                if ($replacement_count>0) {
                                    $this->foundImageLink = true;
                                }
                            }
                            else {
                                $oldEventData = $eventData[$element];
                                $eventData[$element] = preg_replace($regex, $sub, $eventData[$element]);
                                
                                // Remember if an image link was found by checking, if something was changed
                                if ($oldEventData!=$eventData[$element]) {
                                    $this->foundImageLink = true;
                                }
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
}
