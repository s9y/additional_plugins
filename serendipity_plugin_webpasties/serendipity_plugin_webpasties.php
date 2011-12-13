<?php

    /* Serendipity Sidebar Plugin for WebPasties
     * @author Jabrwock <jabrwock@gmail.com>
     * Mar 02, 2006
     * Version 0.1 */

// Probe for a language include with constants. Still include defines later on, if some constants were missing

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';

if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

@define('PLUGIN_WEBPASTIES_URL', 'http://www.webpasties.com/pastie.php');

class serendipity_plugin_webpasties extends serendipity_plugin {

    var $title = PLUGIN_WEBPASTIES_NAME;

    function introspect(&$propbag)
    {
        $this->title = $this->get_config('title', $this->title);
        $propbag->add('name',           PLUGIN_WEBPASTIES_NAME);
        $propbag->add('description',    PLUGIN_WEBPASTIES_DESC);
        $propbag->add('stackable',      true);
        $propbag->add('author',         'Jabrwock');
        $propbag->add('version',        '0.2');
        $propbag->add('configuration',  array('title','mode', 'mid', 'id'));
        $propbag->add('groups',         array('FRONTEND_EXTERNAL_SERVICES'));
        $propbag->add('requirements',   array(
            'serendipity'   => '0.9.1',
            'php'           => '4.1.0'
        ));
        $this->protected = TRUE;
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'title':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_WEBPASTIES_TITLE);
                $propbag->add('description',    PLUGIN_WEBPASTIES_TITLE_DESC);
                $propbag->add('default',        '');
                $propbag->add('validate',       'words');
                $propbag->add('validate_error', PLUGIN_WEBPASTIES_TITLE_ERR);
                break;
            case 'mode':
                $select_mode = array(
                    'scroll'    => PLUGIN_WEBPASTIES_MODE_SCROLL,
                    'poll'      => PLUGIN_WEBPASTIES_MODE_POLL,
                    'cal'       => PLUGIN_WEBPASTIES_MODE_CAL,
                    'im'        => PLUGIN_WEBPASTIES_MODE_IM
                );
                $propbag->add('type',           'select');
                $propbag->add('select_values',  $select_mode);
                $propbag->add('name',           PLUGIN_WEBPASTIES_MODE);
                $propbag->add('description',    PLUGIN_WEBPASTIES_MODE_DESC);
                $propbag->add('default',        'scroll');
                break;
            case 'mid':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_WEBPASTIES_MID);
                $propbag->add('description',    PLUGIN_WEBPASTIES_MID_DESC);
                $propbag->add('default',        '');
                $propbag->add('validate',       'number');
                $propbag->add('validate_error', PLUGIN_WEBPASTIES_MID_ERR);
                break;
            case 'id':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_WEBPASTIES_ID);
                $propbag->add('description',    PLUGIN_WEBPASTIES_ID_DESC);
                $propbag->add('default',        '');
                $propbag->add('validate',       'number');
                $propbag->add('validate_error', PLUGIN_WEBPASTIES_ID_ERR);
                break;
            default:
                return false;
                break;
        }
        return true;
    }

    function generate_content(&$title)
    {
        echo '<h3>'. $this->get_config('title', '') .'</h3>';

        switch($this->get_config('mode', 'scroll'))
        {
            case 'scroll':
                $type = 's';
                break;
            case 'poll':
                $type = 'p';
                break;
            case 'cal':
                $type = 'c';
                break;
            case 'im':
                $type = 'i';
                break;
            default:
                break;
        }
        echo '<script language="JavaScript" type="text/javascript" src="'. PLUGIN_WEBPASTIES_URL .'?mode='. $this->get_config('mode', 'scroll') .'&amp;'. $type .'id='. $this->get_config('id', '') .'&amp;mid='. $this->get_config('mid', '') .'"></script>';
    }

    function example()
    {
        return PLUGIN_WEBPASTIES_EXAMPLE . '<p>&lt;script language="JavaScript" type="text/javascript" src="http://www.webpasties.com/pastie.php?<b>mode=scroll</b>&amp;s<b>id=6383</b>&amp;<b>mid=38</b>"&gt;&lt;/script&gt;';
    }
}

/* vim: set sts=4 ts=4 expandtab: */
