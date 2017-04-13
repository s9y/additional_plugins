<?php # 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

@define('PLUGIN_LAYOUT_LINKMARKUP_VERSION', '1.0');

class serendipity_event_layout_linkmarkup extends serendipity_event
{
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_LAYOUT_LINKMARKUP_NAME);
        $propbag->add('description',   PLUGIN_LAYOUT_LINKMARKUP_BLAHBLAH);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Sebastian Nohn');
        $propbag->add('version',       '1.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',   array('css' => true));
        $propbag->add('groups', array('BACKEND_TEMPLATES'));
        $propbag->add('configuration', array('visited_image_url'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'visited_image_url':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_LAYOUT_LINKMARKUP_VISITEDIMAGE);
                $propbag->add('description', '');
                $propbag->add('default', 'plugins/serendipity_event_layout_linkmarkup/visited.png');
                break;

            default:
                    return false;
        }
        return true;
    }



    function generate_content(&$title)
    {
        $title       = $this->title;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'css':
?>

.serendipity_entry_body a:visited { background-image:	 url("<?php echo $this->get_config('visited_image_url') ?>");
				    background-repeat:	 no-repeat;
				    background-position: right center;
				    padding-right:	 11px; }

<?php
                    return true;
                    break;
                default:
                    return false;
            }
        } else {
            return false;
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>
