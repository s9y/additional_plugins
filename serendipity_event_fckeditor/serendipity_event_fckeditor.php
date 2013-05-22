<?php # $Id$

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_fckeditor extends serendipity_event
{
    var $title = PLUGIN_EVENT_FCKEDITOR_NAME;
    var $is_init = false;

    function example() {
        echo PLUGIN_EVENT_FCKEDITOR_UPDATE;
        echo PLUGIN_EVENT_FCKEDITOR_INSTALL;
        echo PLUGIN_EVENT_FCKEDITOR_CONFIG;
    }

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_FCKEDITOR_NAME);
        $propbag->add('description',   PLUGIN_EVENT_FCKEDITOR_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Ziyad Saeed, Garvin Hicking, Ian');
        $propbag->add('version',       '0.8');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('event_hooks',   array(
            'backend_wysiwyg'        => true,
            'backend_wysiwyg_finish' => true
        ));
        $propbag->add('configuration', array('path', 'fckeditor_plugins'));
        $propbag->add('groups', array('BACKEND_EDITOR'));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'path':
                $propbag->add('type', 'string');
                $propbag->add('name', INSTALL_RELPATH);
                $propbag->add('description', '');
                $propbag->add('default', str_replace(strtolower($serendipity['serendipityPath']), '', str_replace('\\', '/',  strtolower(dirname(__FILE__))) . '/fckeditor/'));
                break;

            default:
                    return false;
        }
        return true;
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_wysiwyg':
                    $eventData['skip'] = true;
                    if (preg_match('@^nugget@i', $eventData['item'])) {
                        $this->event_hook('backend_wysiwyg_finish', $bag, $eventData);
                    }
                    return true;
                    break;

                case 'backend_wysiwyg_finish':
                    $path = htmlspecialchars($this->get_config('path'));
                    if ($this->init) {
                        return true;
                    }
?>

<script language="javascript" type="text/javascript" src="<?php echo $path; ?>fckeditor.js"></script>
<script type="text/javascript">
        function fck_addLoadEvent(func) {
          var oldonload = window.onload;
          if (typeof window.onload != 'function') {
            window.onload = func;
          } else {
            window.onload = function() {
              oldonload();
              func();
            }
          }
        }

        function fck_init() {
            if (document.getElementById('serendipity[body]')) {
                var oFCKeditor_bd = new FCKeditor('serendipity[body]');
                oFCKeditor_bd.BasePath = '<?php echo $path; ?>';
                oFCKeditor_bd.ToolbarSet = 'Default';
                oFCKeditor_bd.Height = 400;
                oFCKeditor_bd.ReplaceTextarea();
            }

            if (document.getElementById('serendipity[extended]')) {
                var oFCKeditor_ext = new FCKeditor('serendipity[extended]');
                oFCKeditor_ext.BasePath = '<?php echo $path; ?>';
                oFCKeditor_ext.ToolbarSet = 'Default';
                oFCKeditor_ext.Height = 400;
                oFCKeditor_ext.ReplaceTextarea();
            }
        }

        var oFCKeditor_nuggets = [];
        function Spawnnuggets(item) {
            if (document.getElementById('nuggets' + item)) {
                el = document.getElementById('nuggets' + item);
                el.id = el.name;
                fckid = el.id;

                oFCKeditor_nuggets[item] = new FCKeditor(fckid);
                oFCKeditor_nuggets[item].BasePath = '<?php echo $path; ?>';
                oFCKeditor_nuggets[item].ToolbarSet = 'Default';
                oFCKeditor_nuggets[item].Height = 400;
                oFCKeditor_nuggets[item].ReplaceTextarea();
            }
        }

        fck_addLoadEvent(fck_init);

</script>
<?php

                    $this->init = true;
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
