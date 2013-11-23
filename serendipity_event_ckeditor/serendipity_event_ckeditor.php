<?php # 

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
    public    $title = PLUGIN_EVENT_CKEDITOR_NAME;

    /**
     * Access property cke_path
     * @access protected
     * @var string
     */
    protected $cke_path = CKEDITOR_DIRNAME_PLUGIN_PATH;

    /**
     * Access property cke_dir
     * @access protected
     * @var string
     */
    protected $cke_dir = CKEDITOR_DIRNAME_CKEDITOR_PATH;

    /**
     * Access property cke_zipfile
     * @access protected
     * @var string
     */
    protected $cke_zipfile = 'ckeditor_4.2.3_standard-plus.zip';

    /**
     * Access property checkUpdateVersion
     * Verify release package versions - do update on upgrades!
     * @var array
     */
    protected $checkUpdateVersion = array('ckeditor:4.2.3', 'kcfinder:2.52-2');

    /**
     * Access property revisionPackage
     * Note revisions of ckeditor, kcfinder and plugin additions to lang files
     * @var array
     */
    protected $revisionPackage = array('CKEditor 4.2.3 (revision a8bf556, standard package, 2013-11-14)',
                                       'KCFinder 2.52-dev (http://kcfinder.sunhater.com/ git package, 2013-05-04)',
                                       'CKEditor-Plugin: mediaembed, v. 0.5+ (https://github.com/frozeman/MediaEmbed, 2013-09-12)',
                                       'CKEditor-Plugin: pbckcode, v. 1.1.0 (https://github.com/prbaron/PBCKCode, 2013-09-06)',
                                       'CKEditor-Plugin: procurator, v. 1.0 (Serendipity placeholder Plugin, 2013-09-26)');


    function install() {
        global $serendipity;

        if (!$serendipity['serendipityUserlevel'] >= USERLEVEL_ADMIN) {
            return false;
        }
        // do we already have it?
        if (is_dir($this->cke_dir) && is_file($this->cke_dir . '/ckeditor.js')) {
            // this is running while getting a new Plugin version
            if ($this->checkUpdate()) {
                $this->set_config('installer', '4-'.date('Ymd-H:i:s')); // this is a faked debug notice, since falldown is extract true with case 0, 1 or 2
            } else {
                $this->set_config('installer', '3-'.date('Ymd-H:i:s')); // this will happen, if no further extract is necessary in case of an update
                return;
            }
        }

        if (!extension_loaded('zip')) {
            trigger_error(' ZIP extension has not been compiled or loaded in php.', E_USER_WARNING);
            return;
        }

        if (is_writable($this->cke_path)) {
            $zip = new ZipArchive;
            if ($zip->open($this->cke_path . '/' . $this->cke_zipfile) === true) {
                $zip->extractTo($this->cke_path);
                $zip->close();
                $this->set_config('installer', '2-'.date('Ymd-H:i:s')); // returned by string[0], which is better than substr in this case
                // Check to remove every old ckeditor_(*)_standard-plus.zip files
                foreach (glob($this->cke_path . '/*.zip') as $filename) {
                    if($this->cke_path . '/' . $this->cke_zipfile != $filename) {
                        @unlink($filename);
                        $is_update = true;
                    }
                }
                if ($is_update) {
                    // purge removed files for upgraders to ckeditor v. 4.2 only
                    @unlink($this->cke_path . '/ckeditor/build_config.js');
                    @unlink($this->cke_path . '/ckeditor/skins/moono/images/mini.png');
                }
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
        $propbag->add('version',       '2.3.0'); // is CKEDITOR Series 4 (hidden) - revision .2.3 - and appended serendipity_event_ckeditor revision .0
        $propbag->add('copyright',     'GPL or LGPL License');
        $propbag->add('requirements',  array(
            'serendipity' => '1.7',
            'smarty'      => '3.1.13',
            'php'         => '5.2.6'
        ));

        $propbag->add('event_hooks',   array(
            'frontend_footer'                        => true,
            'backend_header'                         => true,
            'css_backend'                            => true,
            'backend_plugins_update'                 => true,
            'backend_media_path_exclude_directories' => true,
            'backend_wysiwyg'                        => true,
            'backend_wysiwyg_finish'                 => true
        ));
        $propbag->add('configuration', array('path', 'plugpath', 'codebutton', 'prettify', 'acf_off', 'toolbar_break'));
        $propbag->add('groups', array('BACKEND_EDITOR'));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'path':
                $propbag->add('type', 'string');
                $propbag->add('name', INSTALL_RELPATH);
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_OPTION_BLAHBLAH . '"plugins/serendipity_event_ckeditor/ckeditor/"');
                $propbag->add('default', 'plugins/serendipity_event_ckeditor/ckeditor/');
                break;

            case 'plugpath':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_INSTALL_PLUGPATH);
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_OPTION_BLAHBLAH . '"' . $serendipity['serendipityHTTPPath'] . 'plugins/"');
                $propbag->add('default', $serendipity['serendipityHTTPPath'] . 'plugins/');
                break;

            case 'codebutton':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_CODEBUTTON_OPTION);
                $propbag->add('description', '');
                $propbag->add('default', 'false');
                break;

            case 'prettify':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_PRETTIFY_OPTION);
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_PRETTIFY_OPTION_BLAHBLAH);
                $propbag->add('default', 'false');
                break;

            case 'acf_off':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION);
                $propbag->add('description', 'http://ckeditor.com/blog/Integrating-Plugins-with-Advanced-Content-Filter');
                $propbag->add('default', 'false');
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

        echo PLUGIN_EVENT_CKEDITOR_REVISION_TITLE;
        echo "\n<ul>\n";
        // hook this as a scalar value into this plugins lang files (would be needed by adding this to a constant)
        foreach( $this->revisionPackage AS $revision ) {
            echo '    <li>' . $revision . "</li>\n";
        }
        echo "</ul>\n\n";

        if( isset($installer) && !empty($installer) ) {
            switch ($installer[0]) {
                case '4': // this won't happen, since case 2 is true - just a fake
                    echo '<p class="msg_notice"><span class="icon-info-circle"></span><strong>Check Plugin Update Message:</strong> NO CONFIG SET OR NO MATCH -> config_set: "last_'.$parts[0].'_version:'. $parts[1].'"</p>';
                    break;
                case '3':
                    echo '<p class="msg_success"><span class="icon-ok-circle"></span><strong>Installer Update Message:</strong> Check Update found false, no unpack needed. Plugin upgrade successfully done <strong>or</strong> has been triggered to be checked by an other Spartacus Plugin update!</p>';
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
     * Check update versions to perform unzip and create config values
     * @access    private
     * @return    boolean
     */
    private function checkUpdate() {

        $doupdate = false;

        foreach(array_values($this->checkUpdateVersion) AS $package) {
            $match = explode(':', $package);
            // always set and extract if not match
            if ($this->get_config('last_'.$match[0].'_version') == $match[1]) {
                $doupdate = false;
            } else {
                $this->set_config('last_'.$match[0].'_version', $match[1]);
                $doupdate = true;
                break; // this is possibly needed to force install upgrade routines
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

    /**
     * Check and purge KCFinder Error fallback files to avoid errors
     * @access    private
     */
    private function checkFallback() {
        // kcfinder has a fallback media library mode if not properly loaded, or an other error occurs - get rid of it by default, since it stops image browser executing!
        // this is only executed once for the finish hook with entryforms - but sadly twice for staticpages forms
        if( is_file(dirname(__FILE__) . '/kcfinder/.htaccess') ) {
            @unlink(dirname(__FILE__) . '/kcfinder/.htaccess');
            $this->empty_dir(dirname(__FILE__) . '/kcfinder/.thumbs');
            if (!is_dir(dirname(__FILE__) . '/kcfinder/.thumbs')) @rmdir(dirname(__FILE__) . '/kcfinder/.thumbs');
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_footer':
                    // set prettify.css and prettify.js in frontend by plugin option
                    if ($this->get_config('prettify')) {
?>
    <link rel="stylesheet" type="text/css" href="<?php echo $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_ckeditor/prettify.css'; ?>" />
<?php
                    }
                    if ($this->get_config('codebutton')) {
?>
    <script language="javascript" type="text/javascript" src="<?php echo $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_ckeditor/prettify.js'; ?>"></script>
    <script>
    jQuery(function($){
        // relaunch the prettify code
        prettyPrint();
    });
    </script>
<?php
                    }
                    break;


                case 'backend_header':
                    if (isset($serendipity['wysiwyg']) && $serendipity['wysiwyg'] && isset($eventData)) {
                        $relpath = htmlspecialchars($this->get_config('path'));
                        $plgpath = htmlspecialchars($this->get_config('plugpath'));
                        $acfoff  = serendipity_db_bool($this->get_config('acf_off')) ? 'true' : 'false'; // need this, to be passed correctly as boolean true/false to custom config.js
                        if(!isset($_COOKIE['KCFINDER_uploadurl']) || empty($_COOKIE['KCFINDER_uploadurl'])) {
                            setcookie('KCFINDER_uploadurl', serialize($serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath']), time()+60*60*24*30, $serendipity['serendipityHTTPPath'], $_SERVER['HTTP_HOST'], false);
                        }
    /* set some global vars */
    /* bind ckeditor */
    /* build specific dynamic plugins and set custom config (cke_config.js) */
?>

    <script type="text/javascript">
        CKEDITOR_BASEPATH    = '<?php echo $relpath; ?>';
        CKEDITOR_PLUGPATH    = '<?php echo $plgpath; ?>';
        CKEDITOR_MLIMGPATH   = '<?php echo $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_ckeditor/img/mls9y.png'; ?>';
        KCFINDER_UPLOADPATH  = '<?php echo $serendipity['serendipityHTTPPath'] . $serendipity['uploadPath'] ?>';
        S9Y_BASEURL          = '<?php echo $serendipity['defaultBaseURL']; ?>';
        CONFIG_ACF_OFF       = <?php echo $acfoff; ?>;
        CONFIG_TOOLBAR_BREAK = <?php echo (serendipity_db_bool($this->get_config('toolbar_break'))) ? "'/'" : "''"; ?>;
    </script>
    <script language="javascript" type="text/javascript" src="<?php echo $serendipity['serendipityHTTPPath'] . $relpath; ?>ckeditor.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo $plgpath . 'serendipity_event_ckeditor/'; ?>cke_plugin.js"></script>
<?php
                    } // add to backend header end
                    break;


                case 'css_backend': // do not use in 2.0 versions
                    if ($serendipity['version'][0] == '1') {
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


                case 'backend_plugins_update':
                    if ($this->install() === true) {
                        // make sure a spartacus update really falls down to plugins config, when an update deflating zip has returned true
                        echo '<script type="text/javascript">location.href = \'' . $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=plugins&serendipity[plugin_to_conf]=serendipity_event_ckeditor\';</script>';
                        die();
                    }
                    break;


                case 'backend_media_path_exclude_directories':
                    $eventData[".thumbs"] = true;
                    return true;
                    break;


                case 'backend_wysiwyg':
                    $eventData['skip'] = true; // this skips htmlarea drop-in

                    if (preg_match('@^nugget@i', $eventData['item'])) {
                        // switch to finisher, in case of nuggets
                        $this->event_hook('backend_wysiwyg_finish', $bag, $eventData);
                    } else {
                        // this builds both textareas of entry forms only
                        if (isset($eventData['item']) && !empty($eventData['item'])) {
?>

<script type="text/javascript">
<?php
                            if (isset($eventData['buttons']) && (is_array($eventData['buttons']) && !empty($eventData['buttons']))) {
?>
    if (window.Spawnnuggets) Spawnnuggets('<?php echo $eventData['item']; ?>', 'entryforms<?php echo $eventData['jsname']; ?>', <?php echo json_encode($eventData['buttons']); ?>);
<?php
                            } else {
?>
    if (window.Spawnnuggets) Spawnnuggets('<?php echo $eventData['item']; ?>', 'entryforms<?php echo $eventData['jsname']; ?>', null);
<?php
                            }
                        }
?>
</script>
<?php 
                    }
                    return true;
                    break;


                case 'backend_wysiwyg_finish':
                    // Run once only, save ressources
                    // This should better move into a future(!) 'backend_footer' hook, to not happen for every of any multiple textareas!
                    // but there $eventData['item'] isn't availabale yet...
                    if (isset($eventData['item']) && !empty($eventData['item'])) {
?>
    <script type="text/javascript">
<?php
    if (isset($eventData['buttons']) && (is_array($eventData['buttons']) && !empty($eventData['buttons']))) {
?>
        // send eventData as json encoded array into the javascript stream, which can be pulled by 'backend_header' hooks global Spawnnuggets() nugget function
        jsEventData = <?php echo json_encode($eventData['buttons']); ?>;
<?php
    }
?>
    </script>
<?php 
                    } // end isset $eventData['item']

                    $this->checkFallback();

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