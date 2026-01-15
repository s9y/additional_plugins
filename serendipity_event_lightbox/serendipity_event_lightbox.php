<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Load possible language files.
@serendipity_plugin_api::load_language(dirname(__FILE__));

// Subst Plugin for Serendipity
// 01/2006 by Thomas Nesges <thomas@tnt-computer.de>
// 12/2006 by Andy Hopkins - Added Greybox functionality <andy.hopkins@gmail.com>
// 01/2026 by Jeremy Glastetter - Added PhotoSwipe (no jQuery dependency) <jmglastetter@live.com>
class serendipity_event_lightbox extends serendipity_event
{

    var $title = PLUGIN_EVENT_LIGHTBOX_NAME;
    var $markup_elements;

    // Remembers, if an image link was found in the article. If not found, nor CSS nor JS will be added to the blog header.
    var $foundImageLink = false;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',           PLUGIN_EVENT_LIGHTBOX_NAME);
        $propbag->add('description',    PLUGIN_EVENT_LIGHTBOX_DESC);
        $propbag->add('author',         'Thomas Nesges, Andy Hopkins, Lokesh Dhakar, Cody Lindley, Stephan Manske, Grischa Brockhaus, Ian, Jeremy Glastetter');
        $propbag->add('version',        '3.0.0');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0',
            'php'         => '5.3.0'
        ));
        $propbag->add('event_hooks',     array('frontend_display' => true, 'css' => true, 'frontend_header' => true, 'frontend_footer' => true ));
        $propbag->add('stackable',       false);
        $propbag->add('groups',          array('IMAGES'));
        $propbag->add('cachable_events', array('frontend_display' => true));

        $this->markup_elements = array(
            array('name' => 'ENTRY_BODY', 'element' => 'body'),
            array('name' => 'EXTENDED_BODY', 'element' => 'extended'),
            array('name' => 'COMMENT', 'element' => 'comment'),
            array('name' => 'HTML_NUGGET', 'element' => 'html_nugget')
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

    function generate_content(&$title)
    {
        $title = PLUGIN_EVENT_LIGHTBOX_NAME;
    }

    function introspect_config_item($name, &$propbag)
    {
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
                $propbag->add('select_values',  array('photoswipe' => 'PhotoSwipe (No jQuery)', 'colorbox' => 'ColorBox', 'lightbox2jq' => 'Lightbox 2 jQuery', 'magnific' => 'Magnific-Popup'));
                $propbag->add('default',        'photoswipe');
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

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
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
                if ($type == 'photoswipe') {
                    $regex = '/<a([^>]+)href=(["\'])([^"\']+\.(?:jpe?g|gif|png))(["\'])/i';
                    $sub   = '<a$1href=$2$3$4 data-pswp-src=$2$3$4 class="pswp-enabled"';
                } elseif ($type == 'lightbox2jq') {
                    $regex = '/<a([^>]+)(href=(["\'])[^"\']*\.(jpe?g|gif|png)["\'])/i';
                    $sub   = '<a $1 rel=$3lightbox$3 $2';
                } elseif ($type == 'colorbox') {
                    $regex = '/<a([^>]+)(href=(["\'])[^"\']*\.(jpe?g|gif|png)["\'])/i';
                    $sub   = '<a $1 rel=$3singlebox$3 $2';
                } elseif ($type == 'magnific') {
                    $regex = '/<a([^>]+)(href=(["\'])[^"\']*\.(jpe?g|gif|png)["\'])/i';
                    $sub   = '<a rel=$3onemagnificPopup$3 $1 $2';
                }
            }

            switch($event) {

                case 'frontend_header':
                    $headcss = true;
                case 'frontend_footer':
                    $check_imagesidebar = serendipity_plugin_api::enum_plugins('*', false, 'serendipity_plugin_imagesidebar');
                    $cisb = (is_array($check_imagesidebar) && $check_imagesidebar[0]['placement'] != 'hide') ? $check_imagesidebar : null;

                    if (true === (serendipity_db_bool($this->get_config('header_optimization', 'false')) && $this->foundImageLink === false && empty($cisb))) {
                        break;
                    }
                    echo "\n";
                    
                    if ($type == 'photoswipe') {
                        if (isset($headcss) && $headcss) {
                            echo '    <link rel="stylesheet" type="text/css" href="' . $pluginDir . '/photoswipe/photoswipe.css" />' . "\n";
                            echo '    <style type="text/css">
                                .pswp { --pswp-icon-color: #fff; }
                                /* NEW: Prevent stretching, add corners, and force high-res visibility */
                                .pswp__img { object-fit: contain !important; border-radius: 1rem !important; }
                                /* NEW: Force high contrast on UI buttons and counter */
                                .pswp__button, .pswp__counter { opacity: 1 !important; color: #fff !important; }
                                .pswp__icn-shadow { display: none !important; }
                                /* NEW: Wide-format caption bar styles */
                                .pswp__custom-caption {
                                    background: rgba(0, 0, 0, 0.75);
                                    color: #fff;
                                    font-size: 16px;
                                    line-height: 1.5;
                                    text-align: center;
                                    position: absolute;
                                    left: 50%;
                                    bottom: 20px; 
                                    transform: translateX(-50%);
                                    z-index: 1000;
                                    width: 90%; 
                                    max-width: 900px;
                                    padding: 12px 20px;
                                    border-radius: 10px;
                                    box-sizing: border-box;
                                }
                                .pswp__custom-caption:empty { display: none; }
                            </style>' . "\n";
                        } else {
                            echo '
<script type="module">
import PhotoSwipeLightbox from "' . $pluginDir . '/photoswipe/photoswipe-lightbox.esm.js";
import PhotoSwipe from "' . $pluginDir . '/photoswipe/photoswipe.esm.js";

const lightbox = new PhotoSwipeLightbox({
    gallery: "body",
    children: "a.pswp-enabled",
    pswpModule: PhotoSwipe,
    // NEW: Extra bottom padding to keep image clear of the caption bar
    padding: { top: 20, bottom: 100, left: 20, right: 20 }
});

lightbox.addFilter("itemData", (itemData) => {
    const linkEl = itemData.element;
    if (linkEl) {
        itemData.src = linkEl.getAttribute("href");
        itemData.title = linkEl.getAttribute("title");
        // NEW: Detect thumbnail aspect ratio to prevent jumpy opening animations
        const imgEl = linkEl.querySelector("img");
        if (imgEl && imgEl.naturalWidth) {
            const ratio = imgEl.naturalWidth / imgEl.naturalHeight;
            itemData.w = 1200; 
            itemData.h = 1200 / ratio; 
        }
    }
    return itemData;
});

// NEW: Dynamically update true dimensions once the full image has loaded
lightbox.on("gettingData", (e) => {
    const { data } = e;
    const img = new Image();
    img.onload = () => {
        data.w = img.naturalWidth;
        data.h = img.naturalHeight;
        if (lightbox.pswp) lightbox.pswp.currSlide.updateSize(true);
    };
    img.src = data.src;
});

// NEW: Register the custom caption element to the Root interface layer
lightbox.on("uiRegister", function() {
    lightbox.pswp.ui.registerElement({
        name: "custom-caption",
        order: 9,
        tagName: "div",
        appendTo: "root", 
        onInit: (el, pswp) => {
            pswp.on("change", () => {
                const curr = pswp.currSlide;
                el.innerHTML = curr.data.element ? curr.data.element.getAttribute("title") : "";
            });
        }
    });
});
lightbox.init();
</script>' . "\n";
                        }
                    }
                    elseif ($type == 'colorbox') {
                        if (isset($headcss) && $headcss) {
                            echo '    <link rel="stylesheet" type="text/css" href="' . $pluginDir . '/colorbox/colorboxScreens.css" />' . "\n";
                            echo '    <link rel="stylesheet" type="text/css" href="' . $pluginDir . '/colorbox/colorbox.css" />' . "\n";
                        } else {
                            echo '    <script type="text/javascript" src="' . $pluginDir . '/colorbox/jquery.colorbox-min.js" charset="utf-8"></script>' . "\n";
                            echo '    <script type="text/javascript" src="' . $pluginDir . '/colorbox/jquery.colorbox.init.js" charset="utf-8"></script>' . "\n";
                        }
                    }
                    elseif ($type == 'lightbox2jq') {
                            if (isset($headcss) && $headcss) {
                                echo '    <link rel="stylesheet" type="text/css" href="' . $pluginDir . '/lightbox2-jquery/css/lightbox.css" />' . "\n";
                            } else {
                            echo '    <script type="text/javascript"> jQuery(document).ready(function(){ jQuery(\'a[rel^="lightbox"]\').removeAttr("onclick"); }); </script>' . "\n";
                            echo '    <script type="text/javascript" src="' . $pluginDir . '/lightbox2-jquery/js/lightbox.min.js" charset="utf-8"></script>' . "\n";
                        }
                    }
                    elseif ($type == 'magnific') {
                        if (isset($headcss) && $headcss) {
                            echo '    <link rel="stylesheet" type="text/css" href="' . $pluginDir . '/magnific-popup/magnific-popup.css" />' . "\n";
                        } else {
                            echo '    <script type="text/javascript" src="' . $pluginDir . '/magnific-popup/jquery.magnific-popup.min.js" charset="utf-8"></script>' . "\n";
                            echo '    <script type="text/javascript" src="' . $pluginDir . '/magnific-popup/jquery.magnific-popup.init.js" charset="utf-8"></script>' . "\n";
                        }
                    }
                    break;

                case 'css':
                    echo '
/* serendipity_event_lightbox start */
.serendipity_image_link, .pswp-enabled {
    display: inline-block;
}
/* serendipity_event_lightbox end */
';
                    break;

                case 'frontend_display':
                    if (!isset($eventData['id'])) { $eventData['id'] = 0; }
                    if ($type == 'photoswipe') {
                        $sub = '<a$1href=$2$3$4 data-pswp-src=$2$3$4 class="pswp-enabled"';
                    } elseif ($type == 'lightbox2jq') {
                        if ($navigate == 'entry') { $sub = '<a $1 rel=$3lightbox[' . $eventData['id'] . ']$3 $2'; } 
                        elseif ($navigate == 'page') { $sub = '<a $1 rel=$3lightbox[]$3 $2'; }
                    } elseif ($type == 'colorbox') {
                        if ($navigate == 'entry') { $sub = '<a rel=$3colorbox[' . $eventData['id'] . ']$3 $1 $2'; } 
                        elseif ($navigate == 'page') { $sub = '<a rel=$3colorbox[]$3 $1 $2'; }
                    } elseif ($type == 'magnific') {
                        if ($navigate == 'entry') { $sub = '<a rel=$3magnificPopup[' . $eventData['id'] . ']$3 $1 $2'; } 
                        elseif ($navigate == 'page') { $sub = '<a rel=$3magnificPopup[]$3 $1 $2'; }
                    }

                    foreach ($this->markup_elements as $temp) {
                        if (isset($eventData[$temp['element']]) && serendipity_db_bool($this->get_config($temp['name'], 'true')) &&
                                !(isset($eventData['properties']['ep_disable_markup_' . $this->instance]) && $eventData['properties']['ep_disable_markup_' . $this->instance]) &&
                                !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];
                            $replacement_count = 0;
                            $eventData[$element] = preg_replace($regex, $sub, $eventData[$element], -1,  $replacement_count);
                            if ($replacement_count > 0) { $this->foundImageLink = true; }
                        }
                    }
                    break;

                default:
                    return false;
            }
            return true;
        } else {
            return false;
        }
    }

    function install() { serendipity_plugin_api::hook_event('backend_cache_entries', $this->title); }
    function uninstall(&$propbag) { serendipity_plugin_api::hook_event('backend_cache_purge', $this->title); }
    function example() {}
    private function empty_dir($dir) {}
}
?>