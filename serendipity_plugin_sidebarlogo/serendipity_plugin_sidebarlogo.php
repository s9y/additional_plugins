<?php # $Id $

/* Contributed by Adam Krause (http://www.pigslipstick.com/) */


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';
//include dirname(__FILE__) . '/sidebar_logo_style.css.php';

@define('PLUGIN_SIDEBARLOGO_STYLE_CODE', '
<style type="text/css">
#sblsitename {
    text-align: center;
    font-size: 120%;
    font-weight: bold;
    text-decoration: none;
}
#sblsitetag {
    text-align: center;
    font-size: 105%;
    font-weight: bold;
    text-decoration: none;
}
#sblimage {
    text-align: center;
    border: 0px solid red;
}
#sbldescription {
    text-align: justify;
    font-size: 100%;
    font-weight: normal;
    text-decoration: none;
}
#sblcontact {
    text-align: right;
    font-size: 100%;
    font-weight: normal;
    text-decoration: none;
}
#sblcopyright {
    text-align: right;
    font-size: 80%;
    font-weight: normal;
    text-decoration: overline underline;
}
/*********** NOTES ************
1. Suggest setting style attribute "display: none;"
   on SideBar Logo elements that are left blank to
   reduce empty space on the panel.
************ NOTES ***********/
</style>

');

class serendipity_plugin_sidebarlogo extends serendipity_plugin
{
    var $title = PLUGIN_SIDEBARLOGO_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

            $propbag->add('name',          PLUGIN_SIDEBARLOGO_NAME);
            $propbag->add('description',   PLUGIN_SIDEBARLOGO_DESC);
            $propbag->add('stackable',     true);
            $propbag->add('author',        PLUGIN_SIDEBARLOGO_AUTH);
            $propbag->add('version',       '0.0.2');
            $propbag->add('requirements',  array('serendipity' => '0.9',
                                                 'smarty'      => '2.6.7',
                                                 'php'         => '4.1.0'
                                                 ));

            $propbag->add('configuration', array('title',
                                                 'sitename',
                                                 'sitetag',
                                                 'image',
                                                 'imagewidth',
                                                 'imageheight',
                                                 'description',
                                                 'contact',
                                                 'copyright',
                                                 'style',
                                                 'sequence'
                                                 ));
            $propbag->add('groups',        array('FRONTEND_FEATURES'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {

            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_TITLE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_TITLE_DESC);
                $propbag->add('default',     'My Logo');
                break;

            case 'sitename':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_SITENAME);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_SITENAME_DESC);
                $propbag->add('default',     '');
                break;

            case 'sitetag':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_SITETAG);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_SITETAG_DESC);
                $propbag->add('default',     '');
                break;

            case 'image':
                $propbag->add('type',        'media');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_IMAGE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_IMAGE_DESC);
                $propbag->add('default',     '');
                break;

            case 'imagewidth':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_IMAGEWIDTH);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_IMAGEWIDTH_DESC);
                $propbag->add('default',     '');
                break;

            case 'imageheight':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_IMAGEHEIGHT);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_IMAGEHEIGHT_DESC);
                $propbag->add('default',     '');
                break;

            case 'description':
                $propbag->add('type',        'text');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_DESCRIPTION);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_DESCRIPTION_DESC);
                $propbag->add('default',     '');
                break;

            case 'contact':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_CONTACT);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_CONTACT_DESC);
                $propbag->add('default',     '');
                break;

            case 'copyright':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_COPYRIGHT);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_COPYRIGHT_DESC);
                $propbag->add('default',     '');
                break;

            case 'style':
                $propbag->add('type',        'html');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_STYLE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_STYLE_DESC);
                $propbag->add('default',     PLUGIN_SIDEBARLOGO_STYLE_CODE);
                break;

            case 'sequence':
                $propbag->add('var',         'category_sequence');
                $propbag->add('type',        'sequence');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_SEQUENCE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_SEQUENCE_DESC);
                $propbag->add('values',      array('sitename'    => array('display' => PLUGIN_SIDEBARLOGO_SITENAME),
                                                   'sitetag'     => array('display' => PLUGIN_SIDEBARLOGO_SITETAG),
                                                   'image'       => array('display' => PLUGIN_SIDEBARLOGO_IMAGE),
                                                   'description' => array('display' => PLUGIN_SIDEBARLOGO_DESCRIPTION),
                                                   'contact'     => array('display' => PLUGIN_SIDEBARLOGO_CONTACT),
                                                   'copyright'   => array('display' => PLUGIN_SIDEBARLOGO_COPYRIGHT)
                                                   ));
                break;

            default:
                return false;
        }
    return true;
    }

    function generate_content(&$title)
    {
        global $serendipity;

        $title          = $this->get_config('title');
        $sitename       = $this->get_config('sitename');
        $sitetag        = $this->get_config('sitetag');
        $image          = $this->get_config('image');
        $imagewidth     = $this->get_config('imagewidth');
        $imageheight    = $this->get_config('imageheight');
        $description    = $this->get_config('description');
        $contact        = $this->get_config('contact');
        $copyright      = $this->get_config('copyright');
        $style          = $this->get_config('style');
        $sequence       = $this->get_config('sequence');
        $sequence       = explode(",", $sequence);

        if ($imagewidth != "") {
            $iwidth = "width='$imagewidth'";
        }
        if ($imageheight != "") {
            $iheight = "height='$imageheight'";
        }

    echo $style;
    echo "<div style='margin: 0px; padding: 0px; text-align: left;'>";
    foreach($sequence as $val) {
        switch($val) {
            case 'sitename':
                echo "<div id='sblsitename'>".$sitename."</div>";
                break;

            case 'sitetag':
                echo "<div id='sblsitetag'>".$sitetag."</div>";
                break;

            case 'image':
                echo "<div id='sblimage'><img $iwidth $iheight src=".$image." /></div>";
                break;

            case 'description':
                echo "<div id='sbldescription'>".$description."</div>";
                break;

            case 'contact':
                echo "<div id='sblcontact'>".$contact."</div>";
                break;

            case 'copyright':
                echo "<div id='sblcopyright'>".$copyright."</div>";
                break;
        }
    }
    echo "</div>";

    }
}

/* vim: set sts=4 ts=4 expandtab : */
