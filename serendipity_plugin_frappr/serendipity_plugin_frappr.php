<?php

    /* Serendipity Sidebar Plugin for Frappr (FRiends mAPPER)
     * @author Jabrwock jabrwock@gmail.com
     * Mar 02, 2006
     * Version 0.1 */


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
        include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

@define('PLUGIN_FRAPPR_URL', 'http://www.frappr.com/');
@define('PLUGIN_FRAPPR_SCRIPT', PLUGIN_FRAPPR_URL . 'ajax/widgets.js');

class serendipity_plugin_frappr extends serendipity_plugin {

    var $title = PLUGIN_FRAPPR_NAME;

    function introspect(&$propbag)
    {
        $this->title = $this->get_config('title', $this->title);
        $propbag->add('name',           PLUGIN_FRAPPR_NAME);
        $propbag->add('description',    PLUGIN_FRAPPR_DESC);
        $propbag->add('stackable',      true);
        $propbag->add('author',         'Jabrwock');
        $propbag->add('version',        '0.2');
        $propbag->add('configuration',  array('image', 'ad', 'alt', 'group', 'recent', 'gid', 'orientation', 'length'));
        $propbag->add('groups',         array('FRONTEND_EXTERNAL_SERVICES'));
        $this->protected = TRUE; // only allows the owner to configure
        $propbag->add('requirements',  array(
            'serendipity' => '0.9.1',
            'php'         => '4.1.0'
        ));

    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'group':
                $propbag->add('type',       'string');
                $propbag->add('name',       PLUGIN_FRAPPR_GROUP);
                $propbag->add('description',PLUGIN_FRAPPR_GROUP_DESC);
                $propbag->add('default',    '');
                $propbag->add('validate',   'string');
                $propbag->add('validate_error',PLUGIN_FRAPPR_GROUP_ERR);
                break;
            case 'image':
                $select_link_type = array ('0' => 'Image', '1' => 'Link');
                $propbag->add('type',       'select');
                $propbag->add('select_values', $select_link_type);
                $propbag->add('name',       PLUGIN_FRAPPR_IMAGE);
                $propbag->add('default',    '0');
                break;
            case 'ad':
                $propbag->add('type',       'string');
                $propbag->add('name',       PLUGIN_FRAPPR_AD);
                $propbag->add('description',PLUGIN_FRAPPR_AD_DESC);
                $propbag->add('default',    'http://www.frappr.com/i/frapper_sticker.gif');
                $propbag->add('validate',   'url');
                $propbag->add('validate_error',PLUGIN_FRAPPR_AD_ERR);
                break;
            case 'alt':
                $propbag->add('type',       'string');
                $propbag->add('name',       PLUGIN_FRAPPR_ALT);
                $propbag->add('description',PLUGIN_FRAPPR_ALT_DESC);
                $propbag->add('default',    'Check out our Frappr!');
                $propbag->add('validate',   'words');
                $propbag->add('validate_error',PLUGIN_FRAPPR_ALT_ERR);
                break;
            case 'recent':
                $propbag->add('type',       'boolean');
                $propbag->add('name',       PLUGIN_FRAPPR_RECENT);
                $propbag->add('default',    'false');
                break;
            case 'gid':
                $propbag->add('type',       'string');
                $propbag->add('name',       PLUGIN_FRAPPR_GID);
                $propbag->add('description',PLUGIN_FRAPPR_GID_DESC);
                $propbag->add('default',    '');
                $propbag->add('validate',   'number');
                $propbag->add('validate_error',PLUGIN_FRAPPR_GID_ERR);
                break;
            case 'orientation':
                $select_orientation = array('0' => 'tall', '1' => 'wide');
                $propbag->add('type',       'select');
                $propbag->add('select_values', $select_orientation);
                $propbag->add('name',       PLUGIN_FRAPPR_ORIENTATION);
                $propbag->add('description',PLUGIN_FRAPPR_ORIENTATION_DESC);
                $propbag->add('default',    '0');
                break;
            case 'length':
                $propbag->add('type',       'string');
                $propbag->add('name',       PLUGIN_FRAPPR_LENGTH);
                $propbag->add('description',PLUGIN_FRAPPR_LENGTH_DESC);
                $propbag->add('default',    '400');
                $propbag->add('validate',   'number');
                $propbag->add('validate_error',PLUGIN_FRAPPR_LENGTH_ERR);
                break;
            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        global $serendipity;

        $language = $serendipity['lang'];
        $frappr_url = PLUGIN_FRAPPR_URL;

        /* Output */
        $frappr_link = '<a href="'. $frappr_url . $this->get_config('group', '') .'">';
        if ($this->get_config('image', '0') == 0) {
            $frappr_link = $frappr_link . '<img src="'. $this->get_config('ad', 'http://www.frappr.com/i/frapper_sticker.gif') .'" style="border: 0px" alt="'. $this->get_config('alt', 'Check out our Frappr!') .'" title="'. $this->get_config('alt','Check out our Frappr!') .'" />';
        }
        else
        {
            $frappr_link = $frappr_link . $this->get_config('alt', 'Check out our Frappr!');
        }
        $frappr_link = $frappr_link . '</a><p>';
        echo $frappr_link;
        /* Show recent frappr avatars if selected */
        if ($this->get_config('recent', 'false') == true)
        {
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<script type="text/javascript">';
            echo 'var frappr_photo_length = '. $this->get_config('length', '400') .';';
            if ($this->get_config('orientation', '0') == 0)
            {
                echo 'var frappr_photo_orientation = "tall";';
            }
            else
            {
                echo 'var frappr_photo_orientation = "wide";';
            }
            echo 'var frappr_host = "'. $frappr_url .'";var gid = '. $this->get_config('gid', '') .';</script>';
            echo '<script src="'. PLUGIN_FRAPPR_SCRIPT .'" type="text/javascript"></script>';
        }

    }

}
    /* vim: set sts=4 ts=4 expandtab: */
