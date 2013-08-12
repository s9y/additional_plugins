<?php # 

require_once S9Y_PEAR_PATH . 'HTTP/Request.php';


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_plugin_gallery_menalto_random extends serendipity_plugin {
    var $title = PLUGIN_GALLERYRANDOMBLOCK_NAME;

    function introspect(&$propbag)
    {
        $this->title = $this->get_config('title', $this->title);

        $propbag->add('name',          PLUGIN_GALLERYRANDOMBLOCK_NAME);
        $propbag->add('description',   PLUGIN_GALLERYRANDOMBLOCK_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Andrew Brown, Tadashi Jokagi');
        $propbag->add('version',       '1.8');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('IMAGES'));
        $propbag->add('configuration', array('title', 'path', 'file', 'repeat', 'gversion'));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        TITLE);
                $propbag->add('description', TITLE);
                $propbag->add('default',     '');
                break;

            case 'itemId':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GALLERYRANDOMBLOCK_ITEMID);
                $propbag->add('description', PLUGIN_GALLERYRANDOMBLOCK_ITEMID_DESC);
                $propbag->add('default',     '');
                break;

            case 'path':
                if ((int)$serendipity['serendipityUserlevel'] < (int)USERLEVEL_ADMIN) {
                    return false;
                }
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GALLERYRANDOMBLOCK_URL_NAME);
                $propbag->add('description', PLUGIN_GALLERYRANDOMBLOCK_URL_DESC);
                $propbag->add('default',     $serendipity['baseURL'] . '/gallery/');
                break;

            case 'file':
                if ((int)$serendipity['serendipityUserlevel'] < (int)USERLEVEL_ADMIN) {
                    return false;
                }

                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GALLERYRANDOMBLOCK_FILE_NAME);
                $propbag->add('description', '');
                $propbag->add('default',     'block-random.php');
                break;

            case 'repeat':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GALLERYRANDOMBLOCK_NUMREPEAT_NAME);
                $propbag->add('description', PLUGIN_GALLERYRANDOMBLOCK_NUMREPEAT_DESC);
                $propbag->add('default',     '1');
                break;

            case 'gversion':
                $propbag->add('type',        'select');
                $propbag->add('name',        PLUGIN_GALLERYRANDOMBLOCK_VERSION);
                $propbag->add('description', '');
                $propbag->add('default',     1);
                $propbag->add('select_values', array(
                                                1  => '1.x',
                                                2  => '2.x'
                ));

                break;

            default:
                    return false;
        }
        return true;
    }

    function generate_content(&$title) {
        global $serendipity;

        $title = $this->get_config('title');
        $path  = $this->get_config('path');
        $file  = $this->get_config('file');
        $repeat = $this->get_config('repeat');

        if (!is_numeric($repeat)) {
            $repeat = 1;
        }

        if ($path != "") {
            if (substr($path,-1) != '/') {
                $path .= '/';
            }

            if ((int)$this->get_config('gversion') === 2) {
                $file = 'main.php?g2_view=imageblock:External&g2_blocks=randomImage&g2_itemFrame=none';
                $gid  = $this->get_config('itemId');
                if ($gid > 0) {
                    $file .='&g2_itemId=' . $gid;
                }
            }

            if (empty($file)) {
                $file = 'block-random.php';
            }

            for ($i=1; $i <= $repeat; $i++) {

                $options = array();
                $req = new HTTP_Request($path.$file,$options);
                $req_result = $req->sendRequest();
                if ( PEAR::isError( $req_result)) {
                    echo PLUGIN_GALLERYRANDOMBLOCK_ERROR_CONNECT . "<br />\n";
                } else {
                    $res_code = $req->getResponseCode();
                    if ($res_code != "200") {
                        printf( PLUGIN_GALLERYRANDOMBLOCK_ERROR_HTTP . "<br />\n", $res_code);
                    } else {
                        echo $req->getResponseBody();
                    }
                }
                if ($i < $repeat) {
                    echo '<hr />';
                }
            }
        }
    }
}
/* vim: set sts=4 ts=4 expandtab : */
?>
