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

 /**
  * Class member instance attribute values
  * Members must be initialized with a constant expression (like a string constant, numeric literal, etc), not a dynamic expression!
  **/
if (!defined('CKEDITOR_DIRNAME_PLUGIN_PATH')) define('CKEDITOR_DIRNAME_PLUGIN_PATH', dirname(__FILE__));
if (!defined('CKEDITOR_DIRNAME_CKEDITOR_PATH')) define('CKEDITOR_DIRNAME_CKEDITOR_PATH', dirname(__FILE__) . '/ckeditor');

class serendipity_event_ckeditor extends serendipity_event
{
    /**
     * Access property title
     * Since already used in class serendipity_event extends serendipity_plugin this needs to be public
     * @access public
     * @var string
     */
    public     $title = PLUGIN_EVENT_CKEDITOR_NAME;

    /**
     * Access property cke_path
     * @access protected
     * @var string
     */
    protected  $cke_path = CKEDITOR_DIRNAME_PLUGIN_PATH;

    /**
     * Access property cke_dir
     * @access protected
     * @var string
     */
    protected  $cke_dir = CKEDITOR_DIRNAME_CKEDITOR_PATH;

    /**
     * Access property cke_zipfile
     * @access protected
     * @var string
     */
    protected  $cke_zipfile = 'ckeditor_4.1.1_standard-plus.zip';

    /**
     * Access property checkUpdateVersion
     * Verify release package versions - do update on upgrades!
     * @var array
     */
    protected  $checkUpdateVersion = array('ckeditor:4.1.1', 'kcfinder:2.52-2');


    function install() {
        global $serendipity;

        if (!$serendipity['serendipityUserlevel'] >= USERLEVEL_ADMIN) {
            return false;
        }
        // do we already have it?
        if (is_dir($this->cke_dir) && is_file($this->cke_dir . '/ckeditor.js')) {
            // this is running while getting a new Plugin version
            if ($this->CheckUpdate()) {
                $this->set_config('installer', '4-'.date('Ymd-H:i:s')); // this is a faked debug notice, since falldown is extract true with case 0, 1 or 2
            } else {
                $this->set_config('installer', '3-'.date('Ymd-H:i:s')); // this will happen, if no further extract is necessary in case of an update
                return true;
            }
        }

        if (is_writable($this->cke_path)) {
            $zip = new ZipArchive;
            if ($zip->open($this->cke_path . '/' . $this->cke_zipfile) === true) {
                $zip->extractTo($this->cke_path);
                $zip->close();
                $this->set_config('installer', '2-'.date('Ymd-H:i:s')); // returned by string[0], which is better than substr in this case
            } else {
                $this->set_config('installer', '1-'.date('Ymd-H:i:s'));
                return false;
            }
        } else {
            $this->set_config('installer', '0-'.date('Ymd-H:i:s')); // do it again, Sam
            return false;
        }
        return true;
    }

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_CKEDITOR_NAME);
        $propbag->add('description',   PLUGIN_EVENT_CKEDITOR_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Rustam Abdullaev, Ian');
        $propbag->add('version',       '1.1.2');
        $propbag->add('copyright',     'GPL & LGPL License');
        $propbag->add('requirements',  array(
            'serendipity' => '1.7',
            'smarty'      => '3.1.13',
            'php'         => '5.2.6'
        ));

        $propbag->add('event_hooks',   array(
            'backend_header'                         => true,
            'css_backend'                            => true,
            'backend_media_path_exclude_directories' => true,
            'backend_wysiwyg'                        => true,
            'backend_wysiwyg_finish'                 => true
        ));
        $propbag->add('configuration', array('path', 'plugpath', 'toolbar_break'));
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
                $propbag->add('default', 'plugins/serendipity_event_ckeditor/ckeditor/');
                break;

            case 'plugpath':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_INSTALL_PLUGPATH);
                $propbag->add('description', '');
                $propbag->add('default', $serendipity['serendipityHTTPPath'] . 'plugins/');
                break;

            case 'toolbar_break':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_TBLB_OPTION);
                $propbag->add('description', '');
                $propbag->add('default', 'true');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function example() {

        $installer = $this->get_config('installer'); // Can't use method return value in write context in '' with substr(), get_config() and isset()
        $parts     = explode(':', $this->checkUpdateVersion[0]); // this is ckeditor only

        if( isset($installer) && !empty($installer) ) {
            switch ($installer[0]) {
                case '4': // this won't happen, since case 2 is true - just a fake
                    echo '<p class="msg_notice"><span class="icon-info-circle"></span><strong>Check Plugin Update Message:</strong> NO CONFIG SET OR NO MATCH -> config_set: "last_'.$parts[0].'_version:'. $parts[1].'"</p>';
                    break;
                case '3':
                    echo '<p class="msg_success"><span class="icon-ok-circle"></span><strong>Installer Update Message:</strong> Check Update found false, no unpack needed. Plugin upgrade successfully done!</p>';
                    break;
                case '2':
                    echo '<p class="msg_success"><span class="icon-ok-circle"></span><strong>Installer Message:</strong> Extracting the zip to ' . $this->cke_path . ' directory done!</p>';
                    break;
                case '1':
                    echo '<p class="msg_error"><span class="icon-attention-circle"></span><strong>Installer Error[1]:</strong> Extracting the zip to ' . $this->cke_path . ' directory failed!<br>Please extract ' . $this->cke_zipfile . ' by hand.</p>';
                    break;
                case '0':
                    echo '<p class="msg_error"><span class="icon-attention-circle"></span><strong>Installer Error[0]:</strong> Due to a writing permission error, extracting the zip to ' . $this->cke_path . ' directory failed!<br>Please set "/plugins" or "/plugins/serendipity_event_ckeditor" directory and files correct writing permissions and extract ' . $this->cke_zipfile . ' by hand or try again and <u>remove(!)</u> this plugin from your plugin list and install it again.</p>';
                    break;
            }
            $this->set_config('installer', ''); // can't use serendipity_plugin_api::remove_plugin_value($this->instance, array('installer')); here, since it delivers the wrong instance
        }
        #echo $installer[0] . ' - ' . $this->instance; // this debug message on the other hand will do well, if all went through w/o install() returning false
        echo PLUGIN_EVENT_CKEDITOR_INSTALL;
        echo PLUGIN_EVENT_CKEDITOR_CONFIG;
    }

    /**
     * Check update versions and create config values
     * @access    private
     * @return    boolean
     */
    private function CheckUpdate() {

        $doupdate = false;

        foreach(array_values($this->checkUpdateVersion) AS $package) {
            // always set and extract if not match
            if( preg_match('/^' . $package . ':(.+$)/', $line, $match) ) {
                if ($this->get_config('last_'.$match[0].'_version') == $match[1]){
                    $doupdate = false;
                } else {
                    $this->set_config('last_'.$match[0].'_version', $match[1]);
                    $doupdate = true;
                }
            }
        }
        return $doupdate ? true : false;
    }

    /**
     * empty a directory using the Standard PHP Library (SPL) iterator
     * @param   string directory
     */
    function empty_dir($dir) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                @unlink($file->__toString());
            } else {
                @rmdir($file->__toString());
            }
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_header':
                    if (isset($serendipity['wysiwyg']) && $serendipity['wysiwyg'] && isset($eventData)) {
                        $relpath = htmlspecialchars($this->get_config('path'));
                        $plgpath = htmlspecialchars($this->get_config('plugpath'));
                        if(!isset($_COOKIE['KCFINDER_uploadurl']) || empty($_COOKIE['KCFINDER_uploadurl'])) {
                            setcookie('KCFINDER_uploadurl', serialize($serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath']), time()+60*60*24*30, $serendipity['serendipityHTTPPath'], $_SERVER['HTTP_HOST'], false);
                        }
?>

    <script type="text/javascript">
        CKEDITOR_BASEPATH   = '<?php echo $relpath; ?>';
        CKEDITOR_PLUGPATH   = '<?php echo $plgpath; ?>';
        KCFINDER_UPLOADPATH = '<?php echo $serendipity['serendipityHTTPPath'] . $serendipity['uploadPath'] ?>';
    </script>
    <script language="javascript" type="text/javascript" src="<?php echo $relpath; ?>ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.config['skin'] = 'moono';
        CKEDITOR.config['height'] = 400;
        CKEDITOR.config.removePlugins = 'flash,iframe';
        CKEDITOR.config.removeButtons = 'Styles';
        CKEDITOR.config.toolbarGroups = [
            { name: 'styles' },
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph', groups: [ 'list', /*'indent', */'blocks', 'align', 'bidi' ] },
            { name: 'links' },
            { name: 'insert' },
<?php if(serendipity_db_bool($this->get_config('toolbar_break'))) echo "            '/',\n"; ?>
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
            { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
            { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
            { name: 'others' },
            { name: 'tools' },
            { name: 'about' }
        ];
    </script>

<?php
                    } // add to backend header end
                    break;

                case 'css_backend': // do not use in 2.0 versions
                    if( $serendipity['version'][0] == '1' ) {
?>
/* BACKEND MESSAGES
   ----------------------------------------------------------------- */
.msg_error,
.msg_success,
.msg_notice,
.msg_dialogue {
    display:block;
    margin: 1.5em 0;
    padding: 10px;
}

.msg_error {
    background: #f2dede;
    border: 1px solid #e4b9b9;
    color: #b94a48;
}

.msg_success {
    background: #dff0d8;
    border: 1px solid #c1e2b3;
    color: #468847;
}

.msg_notice {
    background: #fcf8e3;
    border: 1px solid #f7ecb5;
    color: #c09853;
}

.msg_dialogue {
    background: #eee;
    border: 1px solid #aaa;
    color: #777;
}
<?php
                    }
                    break;

                case 'backend_media_path_exclude_directories':
                    $eventData[".thumbs"] = true;
                    return true;
                    break;

                case 'backend_wysiwyg':
                    $eventData['skip'] = true; // this skips htmlarea drop-in

                    if (preg_match('@^nugget@i', $eventData['item'])) {
                        $this->event_hook('backend_wysiwyg_finish', $bag, $eventData);
                    } else {
?>

    <script type="text/javascript">
        CKEDITOR.replace('<?php echo $eventData['item']; ?>', {});
<?php 
        if (isset($eventData) && (is_array($eventData['buttons']) && !empty($eventData['buttons']))) { 
?>
        CKEDITOR.config.extraPlugins = 'entryforms<?php echo $eventData['jsname']; ?>';
        CKEDITOR.plugins.add('entryforms<?php echo $eventData['jsname']; ?>', {
            init: function(editor) {
<?php 
            foreach ($eventData['buttons'] as $button) { 
?>
                editor.addCommand( '<?php echo $button['id']; ?>', {
                    exec: function( editor ) {
                        <?php echo str_replace(array('function() { ',' }'), '', $button['javascript']); ?>;
                    }
                });
                editor.ui.addButton('<?php echo $button['id']; ?>', {
                    label:    '<?php echo $button['name']; ?>',
                    title:    '<?php echo $button['name']; ?>',
                    icon:     '<?php echo serendipity_rewriteURL('plugins/'.$button['img_path']); ?>',
                    iconName: '<?php echo $button['id']; ?>',
                    command:  '<?php echo $button['id']; ?>'
                });
<?php 
            } // close foreach
?>
            }
        });
<?php 
        } // close isset $eventData
?>
    </script>
<?php 
                    }
                    return true;
                    break;

                case 'backend_wysiwyg_finish':
?>

    <script type="text/javascript">
        CKEDITOR.on( 'instanceReady', function( event ) {
            event.editor.on( 'focus', function() {
                //console.log( 'focused', this );
                isinstance = this;
            });
        });

        function Spawnnuggets(item) {
            if (document.getElementById('nuggets' + item)) {
                CKEDITOR.replace('nuggets' + item, {
                    // Reset toolbar Groups settings
                    // toolbarGroups: null
                });
<?php
    if (isset($eventData) && (is_array($eventData['buttons']) && !empty($eventData['buttons']))) {
?>
                CKEDITOR.config.extraPlugins = 'nuggets' + item;
                CKEDITOR.plugins.add('nuggets' + item, {
                    init: function(editor) {
<?php
        foreach ($eventData['buttons'] as $button) {
?>
                        editor.addCommand( '<?php echo $button['id']; ?>', {
                            exec: function( editor ) {
                                <?php echo str_replace(array('function() { ',' }'), '', $button['javascript']); ?>;
                            }
                        });
                        editor.ui.addButton('<?php echo $button['id']; ?>', {
                            label:    '<?php echo $button['name']; ?>',
                            title:    '<?php echo $button['name']; ?>',
                            icon:     '<?php echo serendipity_rewriteURL('plugins/'.$button['img_path']); ?>',
                            iconName: '<?php echo $button['id']; ?>',
                            command:  '<?php echo $button['id']; ?>'
                        });
<?php
        } // close foreach 
?>
                    }
                });
<?php
    } // close isset $eventData
?>
            }
        }

        function serendipity_imageSelector_addToBody (str, textarea) {
            var oEditor = isinstance; // WHOW this was easy...!!!!
            //console.log(oEditor);
            if (oEditor.mode == "wysiwyg") {
                oEditor.insertHtml(str);
            } 
        }
    </script>
<?php
                    // kcfinder has a fallback media library mode if not properly loaded, or an other error occurs - get rid of it by default!
                    if( is_file(dirname(__FILE__) . '/kcfinder/.htaccess') ) {
                        @unlink(dirname(__FILE__) . '/kcfinder/.htaccess');
                        $this->empty_dir(dirname(__FILE__) . '/kcfinder/.thumbs');
                        if (!is_dir(dirname(__FILE__) . '/kcfinder/.thumbs')) @rmdir(dirname(__FILE__) . '/kcfinder/.thumbs');
                    }

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

?>