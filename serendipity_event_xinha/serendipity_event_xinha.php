<?php # $Id: serendipity_event_xinha.php,v 1.10 2008/03/09 05:46:38 brockhaus Exp $


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_xinha extends serendipity_event
{
    var $title = PLUGIN_EVENT_XINHA_NAME;

    function example() {
        echo PLUGIN_EVENT_XINHA_INSTALL;
    }

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_XINHA_NAME);
        $propbag->add('description',   PLUGIN_EVENT_XINHA_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Ziyad Saeed, Garvin Hicking');
        $propbag->add('version',       '0.6');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('event_hooks',   array(
            'backend_wysiwyg'         => true,
            'backend_wysiwyg_finish'  => true,
            'backend_wysiwyg_nuggets' => true
        ));
        $propbag->add('configuration', array('path', 'xinha_plugins', 'imanager'));
        $propbag->add('groups', array('BACKEND_EDITOR'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'path':
                $propbag->add('type', 'string');
                $propbag->add('name', INSTALL_RELPATH);
                $propbag->add('description', '');
                $propbag->add('default', str_replace($serendipity['serendipityPath'], '', dirname(__FILE__) . '/xinha-nightly/'));
                break;

            case 'imanager':
                $propbag->add('type', 'boolean');
                $propbag->add('name', 'iManager');
                $propbag->add('description', '');
                $propbag->add('default', false);

            default:
                    return false;
        }
        return true;
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function jsaddslashes($s) {
        $o="";
        $l=strlen($s);
        for($i=0;$i<$l;$i++) {
            $c=$s[$i];
            switch($c) {
                case '<': $o.='\\x3C'; break;
                case '>': $o.='\\x3E'; break;
                case '\'': $o.='\\\''; break;
                case '\\': $o.='\\\\'; break;
                case '"':  $o.='\\"'; break;
                case "\n": $o.='\\n'; break;
                case "\r": $o.='\\r'; break;
                default: $o.=$c;
            }
        }

        return $o;
    }

    function event_hook($event, &$bag, &$eventData) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_wysiwyg':
                    $eventData['skip'] = true;
                    return true;
                    break;

                case 'backend_wysiwyg_nuggets':
                case 'backend_wysiwyg_finish':
                    $path = $this->get_config('path');
?>
<!--Xinha Stuff Starts-->
<script type="text/javascript">
    _editor_url  = "<?php echo $path; ?>"  //Xinha path
    _editor_lang = "en";      // And the language we need to use in the editor.
  </script>

  <!-- Load up the actual editor core -->
  <script language="javascript" type="text/javascript" src="<?php echo $path; ?>htmlarea.js"></script>

  <script type="text/javascript">
    xinha_editors = null;
    xinha_init    = null;
    xinha_config  = null;
    xinha_plugins = null;

    // This contains the names of textareas we will make into Xinha editors
    xinha_init = xinha_init ? xinha_init : function()
    {
      /** STEP 1 ***************************************************************
       * First, what are the plugins you will be using in the editors on this
       * page.  List all the plugins you will need, even if not all the editors
       * will use all the plugins.
       ************************************************************************/
     xinha_plugins = xinha_plugins ? xinha_plugins :
      [
       'Abbreviation',
       'CharacterMap',
       'CharCounter',
       'ContextMenu',
       'DoubleClick',
       'EditTag',
       <?php echo (serendipity_db_bool($this->get_config('imanager')) ? "'imanager',\n" : ""); ?>
       'Equation',
       'EnterParagraphs',
       'FindReplace',
       'FullScreen',
       'ImageManager',
       'InsertAnchor',
       'InsertSmiley',
       'InsertWords',
       'Linker',
       'ListType',
       'QuickTag',
       'SuperClean',
       'TableOperations',
       'Stylist'
      ];

             // THIS BIT OF JAVASCRIPT LOADS THE PLUGINS, NO TOUCHING  :)
             if(!HTMLArea.loadPlugins(xinha_plugins, xinha_init)) return;

      /** STEP 2 ***************************************************************
       * Now, what are the names of the textareas you will be turning into
       * editors?
       ************************************************************************/

      xinha_check_editors = xinha_editors ? xinha_editors :
      [
<?php
                    // We need to also turn any HTML nuggets we might face!
                    $fields = array();
                    $fields['body']     = 'serendipity[body]';
                    $fields['extended'] = 'serendipity[extended]';
                    if (is_array($eventData) && is_array($eventData['nuggets'])) {
                        foreach($eventData['nuggets'] AS $nuggetid) {
                            $fields["nuggets$nuggetid"] = "nuggets$nuggetid";
                        }
                        $eventData['skip_nuggets'] = true;
                    }

                    foreach($fields AS $field) {
                        echo "\t\t'$field',\n";
                    }
?>
      ];


      // Now check if all supplied editor fields really exist.
      xinha_editors = [];
      xi = 0;
      for (i = 0; i < xinha_check_editors.length; i++) {
        if (document.getElementById(xinha_check_editors[i])) {
            xinha_editors[xi] = xinha_check_editors[i];
            xi = xi + 1;
        }
      }

      /** STEP 3 ***************************************************************
       * We create a default configuration to be used by all the editors.
       * If you wish to configure some of the editors differently this will be
       * done in step 5.
       *
       * If you want to modify the default config you might do something like this.
       *
       *   xinha_config = new HTMLArea.Config();
       *   xinha_config.width  = '640px';
       *   xinha_config.height = '420px';
       *
       *************************************************************************/

       xinha_config = xinha_config ? xinha_config() : new HTMLArea.Config();
       xinha_config.height = '420px';

       <?php
        @session_start();
        $IMConfig = array();
        $IMConfig['images_dir'] = $serendipity['serendipityPath'] . $serendipity['uploadPath'];
        $IMConfig['images_url'] = $serendipity['baseURL'] . $serendipity['uploadHTTPPath'];
        $IMConfig = serialize($IMConfig);
        if(!isset($_SESSION['Xinha:ImageManager'])) {
            $_SESSION['Xinha:ImageManager'] = uniqid('secret_');
        }
?>
       if (xinha_config.ImageManager) {
           xinha_config.ImageManager.backend_config = '<?php echo $this->jsaddslashes($IMConfig)?>';
           xinha_config.ImageManager.backend_config_hash = '<?php echo sha1($IMConfig . $_SESSION['Xinha:ImageManager'])?>';
       }

       xinha_config.registerButton('image_selector', 'Manage Images', 'htmlarea/images/ed_s9yimage.gif', false,
            function(editor, id) {
                window.open('serendipity_admin_image_selector.php?serendipity[textarea]=body', 'ImageSel', 'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1');
                editorref = xinha_editors['serendipity[body]'];
            }
        );

        xinha_config.toolbar = [
    ["popupeditor"],
    ["separator","formatblock","fontname","fontsize","bold","italic","underline","strikethrough"],
    ["separator","forecolor","hilitecolor","textindicator"],
    ["separator","subscript","superscript"],
    ["linebreak","separator","justifyleft","justifycenter","justifyright","justifyfull"],
    ["separator","insertorderedlist","insertunorderedlist","outdent","indent"],
    ["separator","insertimage","image_selector","inserthorizontalrule","createlink","inserttable"],
    ["separator","undo","redo","selectall"], (HTMLArea.is_gecko ? [] : ["cut","copy","paste","overwrite","saveas"]),
    ["separator","killword","removeformat","toggleborders","lefttoright", "righttoleft","separator","htmlmode","about"]
  ];

      /** STEP 4 ***************************************************************
       * We first create editors for the textareas.
       *
       * You can do this in two ways, either
       *
       *   xinha_editors   = HTMLArea.makeEditors(xinha_editors, xinha_config, xinha_plugins);
       *
       * if you want all the editor objects to use the same set of plugins, OR;
       *
       *   xinha_editors = HTMLArea.makeEditors(xinha_editors, xinha_config);
       *   xinha_editors['myTextArea'].registerPlugins(['Stylist','FullScreen']);
       *   xinha_editors['anotherOne'].registerPlugins(['CSS','SuperClean']);
       *
       * if you want to use a different set of plugins for one or more of the
       * editors.
       ************************************************************************/

       xinha_editors   = HTMLArea.makeEditors(xinha_editors, xinha_config, xinha_plugins);
	   //Add Manage Images fuctionality from s9y's default htmlarea3
<?php
                    foreach($fields AS $fid => $field) {
?>
       if (document.getElementById('<?php echo $field; ?>')) {
           xinha_editors['<?php echo $field; ?>'].config.registerButton('image_selector', 'Manage Images', 'htmlarea/images/ed_s9yimage.gif', false,
                function(editor, id) {
                    window.open('serendipity_admin_image_selector.php?serendipity[textarea]=<?php echo $fid; ?>', 'ImageSel', 'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1');
                    editorref = xinha_editors['<?php echo $field; ?>'];
                }
            );
        }
<?php
                    }
?>

      /** STEP 5 ***************************************************************
       * If you want to change the configuration variables of any of the
       * editors,  this is the place to do that, for example you might want to
       * change the width and height of one of the editors, like this...
       *
       *   xinha_editors.myTextArea.config.width  = '640px';
       *   xinha_editors.myTextArea.config.height = '480px';
       *
       ************************************************************************/
       //just uncomment if u want different heights
	   //xinha_editors['serendipity[body]'].config.height = '200px';
	   //xinha_editors['serendipity[extended]'].config.height = '400px';

      /** STEP 6 ***************************************************************
       * Finally we "start" the editors, this turns the textareas into
       * Xinha editors.
       ************************************************************************/

      HTMLArea.startEditors(xinha_editors);
    }

    window.onload = xinha_init;
  </script>
  <!--Xinha Stuff Ends-->
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
