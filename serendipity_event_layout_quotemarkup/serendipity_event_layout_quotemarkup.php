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

@define('PLUGIN_LAYOUT_QUOTEMARKUP_VERSION', '1.0');

class serendipity_event_layout_quotemarkup extends serendipity_event
{
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_LAYOUT_QUOTEMARKUP_NAME);
        $propbag->add('description',   PLUGIN_LAYOUT_QUOTEMARKUP_BLAHBLAH);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Sebastian Nohn');
        $propbag->add('version',       '1.1');
        $propbag->add('event_hooks',   array('css' => true));
        $propbag->add('groups', array('BACKEND_TEMPLATES'));
        $propbag->add('configuration', array('image_url', 'border_type'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'image_url':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_LAYOUT_QUOTEMARKUP_IMAGE);
                $propbag->add('description', PLUGIN_LAYOUT_QUOTEMARKUP_IMAGE_BLAHBLAH);
                $propbag->add('default', 'templates/idea/img/quote.gif');
                break;

            case 'border_type':
                $propbag->add('type', 'radio');
                $propbag->add('name', PLUGIN_LAYOUT_QUOTEMARKUP_BORDERTYPE);
                $propbag->add('description', PLUGIN_EVENT_QUOTEMARKUP_BORDERTYPE_BLAHBLAH);
                $propbag->add('default', 'dotted');
                $propbag->add('radio',
                    array(
                    'value' => array(
                     'dotted',
                     'solid',
                     'double',
                     'grooved',
                     'dashed',
                     'inset',
                     'outset',
                     'ridged',
                     'none'),
                    'desc'  => array(
                     PLUGIN_LAYOUT_QUOTEMARKUP_BORDERTYPE_DOTTED,
                     PLUGIN_LAYOUT_QUOTEMARKUP_BORDERTYPE_SOLID,
                     PLUGIN_LAYOUT_QUOTEMARKUP_BORDERTYPE_DOUBLE,
                     PLUGIN_LAYOUT_QUOTEMARKUP_BORDERTYPE_GROOVED,
                     PLUGIN_LAYOUT_QUOTEMARKUP_BORDERTYPE_DASHED,
                     PLUGIN_LAYOUT_QUOTEMARKUP_BORDERTYPE_INSET,
                     PLUGIN_LAYOUT_QUOTEMARKUP_BORDERTYPE_OUTSET,
                     PLUGIN_LAYOUT_QUOTEMARKUP_BORDERTYPE_RIDGED,
                     PLUGIN_LAYOUT_QUOTEMARKUP_BORDERTYPE_NONE
                     )
                ));
                $propbag->add('radio_per_row', '1');

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

blockquote                        { background-image:    url("<?php echo $this->get_config('image_url') ?>");
                    background-repeat:   no-repeat;
                    background-position: left top;
                    border:      1px <?php echo $this->get_config('border_type') ?> black;
                    padding:         0.2em; }

q                 { border:      1px <?php echo $this->get_config('border_type') ?> black; }

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