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
            $propbag->add('version',       '0.4');
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
                                                 'sitename',
                                                 'sitenamestyle',
                                                 'sitetag',
                                                 'sitetagstyle',
                                                 'contact',
                                                 'contactstyle',
                                                 'copyright',
                                                 'copyrightstyle',
                                                 'sequence',
                                                 ));
            $propbag->add('groups',        array('FRONTEND_FEATURES'));
            $propbag->add('config_groups', array(
                        PLUGIN_SIDEBARLOGO_GROUP_MOREOPTIONS => array(
                        'sitename',
                        'sitetag',
                        'contact',
                        'copyright',
                        'sequence'
                    ),
                        PLUGIN_SIDEBARLOGO_GROUP_STYLES => array(
                        'imagestyle',
                        'descriptionstyle',
                        'sitenamestyle',
                        'sitetagstyle',
                        'contactstyle',
                        'copyrightstyle',
                    )
            ));
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
                $propbag->add('default',     PLUGIN_SIDEBARLOGO_DEFAULT_DESCRIPTION);
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

            case 'sitename':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_SITENAME);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_SITENAME_DESC);
                $propbag->add('default',     '');
                break;

            case 'sitenamestyle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_SITENAMESTYLE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_SITENAMESTYLE_DESC);
                $propbag->add('default',     'text-align: center; font-size: 120%; font-weight: bold; text-decoration: none;');
                break;

            case 'sitetag':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_SITETAG);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_SITETAG_DESC);
                $propbag->add('default',     '');
                break;

            case 'sitetagstyle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_SITETAGSTYLE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_SITETAGSTYLE_DESC);
                $propbag->add('default',     'text-align: center; font-size: 105%; font-weight: bold; text-decoration: none;');
                break;

            case 'contact':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_CONTACT);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_CONTACT_DESC);
                $propbag->add('default',     '');
                break;

            case 'contactstyle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_CONTACTSTYLE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_CONTACTSTYLE_DESC);
                $propbag->add('default',     'text-align: right; font-size: 100%; font-weight: normal; text-decoration: none;');
                break;

            case 'copyright':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_COPYRIGHT);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_COPYRIGHT_DESC);
                $propbag->add('default',     '');
                break;

            case 'copyrightstyle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_COPYRIGHTSTYLE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_COPYRIGHTSTYLE_DESC);
                $propbag->add('default',     'text-align: right; font-size: 80%; font-weight: normal; text-decoration: overline underline;');
                break;

            case 'delimiterstyle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_DELIMITERSTYLE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_DELIMITERSTYLE_DESC);
                $propbag->add('default',     'clear:left;');
                break;

            case 'sequence':
                $propbag->add('var',         'category_sequence');
                $propbag->add('type',        'sequence');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_SEQUENCE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_SEQUENCE_DESC);
                $propbag->add('checkable', true);
                $propbag->add('values',      array('sitename'    => array('display' => PLUGIN_SIDEBARLOGO_SITENAME),
                                                   'sitetag'     => array('display' => PLUGIN_SIDEBARLOGO_SITETAG),
                                                   'image'       => array('display' => PLUGIN_SIDEBARLOGO_IMAGE),
                                                   'description' => array('display' => PLUGIN_SIDEBARLOGO_DESCRIPTION),
                                                   'delimiter'   => array('display' => PLUGIN_SIDEBARLOGO_DELIMITER),
                                                   'contact'     => array('display' => PLUGIN_SIDEBARLOGO_CONTACT),
                                                   'copyright'   => array('display' => PLUGIN_SIDEBARLOGO_COPYRIGHT)
                                                   ));
                $propbag->add('default',     'image,description,delimiter');
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
        $sitename           = $this->get_config('sitename');
        $sitenamestyle      = $this->get_config('sitenamestyle');
        $sitetag            = $this->get_config('sitetag');
        $sitetagstyle       = $this->get_config('sitetagstyle');
        $contact            = $this->get_config('contact');
        $contactstyle       = $this->get_config('contactstyle');
        $copyright          = $this->get_config('copyright');
        $copyrightstyle     = $this->get_config('copyrightstyle');
        $copyrightstyle     = $this->get_config('delimiterstyle');
        $sequence           = $this->get_config('sequence');
        
        // prepare for output
        $sequence           = explode(",", $sequence);

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
        $sitenamestyle = $this->generate_style_attribute($sitenamestyle);
        $sitetagstyle = $this->generate_style_attribute($sitetagstyle);
        $contactstyle = $this->generate_style_attribute($contactstyle);
        $copyrightstyle = $this->generate_style_attribute($copyrightstyle);
        $delimiterstyle = $this->generate_style_attribute($delimiterstyle);
        
        // output
        foreach( $sequence as $val )
        {
            switch( $val )
            {
                case 'image':
                    if ($image != "")
                        echo "<img ".$iwidth." ".$iheight." src='".$image."' alt='".$imagetext."' ".$imagestyle."/>";
                    break;

                case 'description':
                    if ( $descriptionstyle != "" )
                        echo "<div ".$descriptionstyle.">\n";
            
                    echo $description."\n";
        
                    if ( $descriptionstyle != "" )
                        echo "</div>\n";
                    break;

                case 'delimiter':
                    echo "<div ".$delimiterstyle."></div>";
                    break;

                case 'sitename':
                    echo "<div ".$sitenamestyle.">\n";         
                    echo $sitename."\n";
                    echo "</div>\n";
                    break;

                case 'sitetag':
                    echo "<div ".$sitetagstyle.">\n";         
                    echo $sitetag."\n";
                    echo "</div>\n";
                    break;

                case 'contact':
                    echo "<div ".$contactstyle.">\n";         
                    echo $contact."\n";
                    echo "</div>\n";
                    break;

                case 'copyright':
                    echo "<div ".$copyrightstyle.">\n";         
                    echo $copyright."\n";
                    echo "</div>\n";
                    break;
            }
	}
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