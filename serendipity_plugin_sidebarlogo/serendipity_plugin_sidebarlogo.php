<?php # $Id $
/* Contributed by Adam Krause (http://www.pigslipstick.com/), Oliver Gerlach (http://www.stumblingpilgrim.net/) */


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

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
            $propbag->add('version',       '0.3');
            $propbag->add('requirements',  array('serendipity' => '0.9',
                                                 'smarty'      => '2.6.7',
                                                 'php'         => '4.1.0'
                                                 ));

            $propbag->add('configuration', array('title',
                                                 'image',
                                                 'imagewidth',
                                                 'imageheight',
                                                 'imagetext',
                                                 'description',
                                                 'imagestyle',
                                                 'descriptionstyle',
                                                 ));
            $propbag->add('groups',        array('FRONTEND_FEATURES'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name)
        {

            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_TITLE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_TITLE_DESC);
                $propbag->add('default',     'My Logo');
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

            case 'imagetext':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_IMAGETEXT);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_IMAGETEXT_DESC);
                $propbag->add('default',     PLUGIN_SIDEBARLOGO_IMAGETEXT_MISSING);
                break;

            case 'description':
                $propbag->add('type',        'text');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_DESCRIPTION);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_DESCRIPTION_DESC);
                $propbag->add('default',     'Your text here.\n<div style="clear:left;"></div>');
                break;

            case 'imagestyle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_IMAGESTYLE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_IMAGESTYLE_DESC);
                $propbag->add('default',     '.serendipity_imageComment_left');
                break;

            case 'descriptionstyle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_DESCRIPTIONSTYLE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_DESCRIPTIONSTYLE_DESC);
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

        $title              = $this->get_config('title');
        $image              = $this->get_config('image');
        $imagewidth         = $this->get_config('imagewidth');
        $imageheight        = $this->get_config('imageheight');
        $imagetext          = $this->get_config('imagetext');
        $description        = $this->get_config('description');
        $imagestyle         = $this->get_config('imagestyle');
        $descriptionstyle   = $this->get_config('descriptionstyle');
        
        // prepare for output
        if ($imagewidth != "")
        {
            $iwidth = "width='".$imagewidth."'";
        }
        
        if ($imageheight != "")
        {
            $iheight = "height='".$imageheight."'";
        }
        
        $imagestyle = $this->generate_style_attribute($imagestyle);
        $descriptionstyle = $this->generate_style_attribute($descriptionstyle);
        
        // output
        if ($image != "")
        {
            echo "<img ".$iwidth." ".$iheight." src='".$image."' alt='".$imagetext."' ".$imagestyle."/>";
        }
        
        if ( $descriptionstyle != "" )
            echo "<div ".$descriptionstyle.">\n";
            
        echo $description."\n";
        
        if ( $descriptionstyle != "" )
            echo "</div>\n";
    }

    function generate_style_attribute(&$stylestring)
    {
       if ( $stylestring != "" )
       {
           if ( $stylestring[0] == "." )
	       return "class='".substr($stylestring,1)."'";
	   else if ( $stylestring[0] == "#" )
	       return "id='".substr($stylestring,1)."'";
	   else
	       return "style='".$stylestring."'";
	  return "";
       }
       else
           return "";
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>