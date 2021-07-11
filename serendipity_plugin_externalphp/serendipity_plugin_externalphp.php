<?php /*  */

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_externalphp extends serendipity_plugin {
    var $title = PLUGIN_EXTERNALPHP_TITLE;
    function introspect(&$propbag) {
        global $serendipity;

        $title = $this->get_config('title');
        if ($title != PLUGIN_EXTERNALPHP_TITLE) {
            $desc = '(' . $title . ') ';
        } else {
            $desc = '';
        }
        $desc .= PLUGIN_EXTERNALPHP_TITLE_BLAHBLAH;

        $propbag->add('name', PLUGIN_EXTERNALPHP_TITLE);
        $propbag->add('description', PLUGIN_EXTERNALPHP_TITLE_BLAHBLAH);
        $propbag->add('configuration', array('title', 'include', 'markup'));
        $propbag->add('author', 'Garvin Hicking');
        $propbag->add('version', '1.1.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
        $propbag->add('stackable', true);
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        TITLE);
                $propbag->add('description', TITLE_FOR_NUGGET);
                $propbag->add('default',     PLUGIN_EXTERNALPHP_TITLE);
                break;
                                                                                                        
            case 'include':
                // THIS IS AN EVIL EVIL PLUGIN.
                if ($serendipity['serendipityUserlevel'] < USERLEVEL_ADMIN) {
                    return false;
                }

                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EXTERNALPHP_INCLUDE);
                $propbag->add('description', PLUGIN_EXTERNALPHP_INCLUDE_DESC);
                $propbag->add('default',     $serendipity['serendipityPath'] . 'include/your_php.inc.php');
                break;

            case 'markup':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        DO_MARKUP);
                $propbag->add('description', DO_MARKUP_DESCRIPTION);
                $propbag->add('default',     'false');
                break;

            default:
                return false;
        }
        return true;
    }

    function show() {
        global $serendipity;

            $include_file = realpath($this->get_config('include'));
            ob_start();
            include $include_file;
            $content = ob_get_contents();
            ob_end_clean();

            if (serendipity_db_bool($this->get_config('markup'))) {
                $entry = array('body' => $content);
                serendipity_plugin_api::hook_event('frontend_display', $entry);
                echo $entry['body'];
            } else {
                echo $content;
            }
    }

    function generate_content(&$title) {
        $title = $this->get_config('title', $this->title);
        $this->show();
    }
}
/* vim: set sts=4 ts=4 expandtab : */