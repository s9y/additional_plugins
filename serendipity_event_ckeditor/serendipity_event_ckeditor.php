<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

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
     * Access property forceZipInstall
     * @access protected
     * @var bool
     */
    protected $forceZipInstall = false;

    /**
     * Access property cke_zipfile
     * @access protected
     * @var string
     */
    protected $cke_zipfile = 'ckeditor_4.3.3.0_standard-plus.zip';

    /**
     * Access property checkUpdateVersion
     * Verify release package versions - do update on upgrades!
     * @var array
     */
    protected $checkUpdateVersion = array('ckeditor:4.3.3.0', 'kcfinder:2.52-2');

    /**
     * Access property revisionPackage
     * Note revisions of ckeditor, kcfinder and plugin additions to lang files
     * @var array
     */
    protected $revisionPackage = array('CKEditor 4.3.3 (revision 7841b02, standard package, 2014-02-22)',
                                       'KCFinder 2.52-dev (http://kcfinder.sunhater.com/ git package, 2013-05-04)',
                                       'CKEditor-Plugin: mediaembed, v. 0.5+ (https://github.com/frozeman/MediaEmbed, 2013-09-12)',
                                       'CKEditor-Plugin: pbckcode, v. 1.1.0 (https://github.com/prbaron/PBCKCode, 2013-09-06)',
                                       'CKEditor-Plugin: procurator, v. 1.3 (Serendipity placeholder Plugin, 2014-02-11)',
                                       'CKEditor-Plugin: cheatsheet, v. 1.0 (Serendipity CKE-Cheatsheet Plugin, 2014-02-09)',
                                       'CKEditor-CustomConfig, cke_config.js, v. 1.6, 2014-02-11',
                                       'CKEditor-ExtraPlugins, cke_plugin.js, v. 1.3, 2014-02-11',
                                       'Prettify: JS & CSS files, v. "current", (http://code.google.com/p/google-code-prettify/, 2013-03-04)');


    function install() {
        global $serendipity;

        if (!$serendipity['serendipityUserlevel'] >= USERLEVEL_ADMIN) {
            return false;
        }
        // do we already have it?
        if (!$this->forceZipInstall && is_dir($this->cke_dir) && is_file($this->cke_dir . '/ckeditor.js')) {
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
        // make sure the new versions are set to last_ckeditor_version and last_kcfinder_version
        $this->updateTableZip();
        return true;
    }

    function uninstall(&$propbag) {
        // todo? uninstall old instances which may be in there, caused by a duplicating bug using installer fallback without right instance in 2.3.2 for one day online
    }

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_CKEDITOR_NAME);
        $propbag->add('description',   PLUGIN_EVENT_CKEDITOR_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Rustam Abdullaev, Ian');
        $propbag->add('version',       '3.3.0'); // is CKEDITOR Series 4 (hidden) - revision .3.3 - and appended plugin revision .0
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
            'external_plugin'                        => true,
            'backend_plugins_update'                 => true,
            'backend_media_path_exclude_directories' => true,
            'backend_wysiwyg'                        => true,
            'backend_wysiwyg_finish'                 => true
        ));
        $propbag->add('configuration', array('path', 'plugpath', 'codebutton', 'prettify', 'kcfinder', 'acf_off', 'toolbar_break', 'force_install'));
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

            case 'kcfinder':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_KCFINDER_OPTION);
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_KCFINDER_OPTION_BLAHBLAH);
                $propbag->add('default', 'false');
                break;

            case 'acf_off':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION);
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION_BLAHBLAH);
                $propbag->add('default', 'false');
                break;

            case 'toolbar_break':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_TOOLBAR_OPTION);
                $propbag->add('description', '');
                $propbag->add('default', 'true');
                break;

            case 'force_install':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_FORCEINSTALL_OPTION);
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_FORCEINSTALL_OPTION_BLAHBLAH . $this->cke_zipfile);
                $propbag->add('default', 'false');
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

        if (serendipity_db_bool($this->get_config('force_install'))) {
            $this->forceZipInstall = true;
            $this->install();
            $this->forceZipInstall = false;
            $this->set_config('force_install', 'false');
            // forceZipInstall forces to surround the checkUpdate function, thus we set config database table to keep track
            $this->updateTableZip();
            echo '<p class="msg_success"><span class="icon-ok"></span><strong>Force deflate done:</strong> Please reload this page <a href="'.$serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=plugins&serendipity[plugin_to_conf]='.urlencode($this->instance).'" target="_self">here</a>!</p>';
        }

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
                    echo '<p class="msg_notice"><span class="icon-attention"></span> <strong>Check Plugin Update Message:</strong> NO CONFIG SET OR NO MATCH -> config_set: "last_'.$parts[0].'_version:'. $parts[1].'"</p>';
                    break;
                case '3':
                    echo '<p class="msg_success"><span class="icon-ok"></span> <strong>Installer Update Message:</strong> Check Update found false, no unpack needed. Plugin upgrade successfully done <strong>or</strong> has been triggered to be checked by an other Spartacus Plugin update!</p>';
                    break;
                case '2':
                    echo '<p class="msg_success"><span class="icon-ok"></span> <strong>Installer Message:</strong> Extracting the zip to ' . $this->cke_path . ' directory done!</p>';
                    break;
                case '1':
                    echo '<p class="msg_error"><span class="icon-error"></span> <strong>Installer Error[1]:</strong> Extracting the zip to ' . $this->cke_path . ' directory failed!<br>Please extract ' . $this->cke_zipfile . ' by hand.</p>';
                    break;
                case '0':
                    echo '<p class="msg_error"><span class="icon-error"></span> <strong>Installer Error[0]:</strong> Due to a writing permission error, extracting the zip to ' . $this->cke_path . ' directory failed!<br>Please set "/plugins" or "/plugins/serendipity_event_ckeditor" directory and files correct writing permissions and extract ' . $this->cke_zipfile . ' by hand or try again and <u>remove(!)</u> this plugin from your plugin list and install it again.</p>';
                    break;
            }
            $this->set_config('installer', ''); // can't use serendipity_plugin_api::remove_plugin_value($this->instance, array('installer')); here, since it delivers the wrong instance
        }
        #echo $installer[0] . ' - ' . $this->instance; // this debug message on the other hand will do well, if all went through w/o install() returning false
        echo PLUGIN_EVENT_CKEDITOR_INSTALL;
        echo PLUGIN_EVENT_CKEDITOR_CONFIG;
    }

    /**
     * Set config database table to keep track to zip updates
     * @access    private
     */
    private function updateTableZip() {
        foreach(array_values($this->checkUpdateVersion) AS $package) {
            $match = explode(':', $package);
            $this->set_config('last_'.$match[0].'_version', $match[1]);
        }
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
                $this->set_config('last_'.$match[0].'_version', $match[1]); // redundant, since now done for both in updateTableZip, but leave here until new is proofed
                $doupdate = true;
                break; // this is possibly needed to force install upgrade routines
            }
        }
        return $doupdate ? true : false;
    }

    /**
     * empty a directory using the Standard PHP Library (SPL) iterator
     * @access    private
     * @param   string directory
     */
    private function empty_dir($dir) {
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
            @rmdir(dirname(__FILE__) . '/kcfinder/.thumbs');
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {

                case 'frontend_footer':
                    // set prettify.css and prettify.js in frontend footer by plugin option (too much overhead to split this into head css and food js!)
                    if ($this->get_config('prettify')) {
                        $plugingpath = htmlspecialchars($this->get_config('plugpath'));
?>
    <link rel="stylesheet" type="text/css" href="<?php echo $plugingpath . 'serendipity_event_ckeditor/prettify.css'; ?>" />
    <script language="javascript" type="text/javascript" src="<?php echo $plugingpath . 'serendipity_event_ckeditor/prettify.js'; ?>"></script>
    <script>
    jQuery(function($){
        // launch the prettify code
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
                        $acf_off = serendipity_db_bool($this->get_config('acf_off')) ? 'true' : 'false'; // need this, to be passed correctly as boolean true/false to custom cke_config.js
                        $kcfd_on = serendipity_db_bool($this->get_config('kcfinder')) ? 'true' : 'false'; // same here
                        $pbck_on = serendipity_db_bool($this->get_config('codebutton')) ? 'true' : 'false'; // same here for cke_plugins.js
                        if(!isset($_COOKIE['KCFINDER_uploadurl']) || empty($_COOKIE['KCFINDER_uploadurl'])) {
                            setcookie('KCFINDER_uploadurl', serialize($serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath']), time()+60*60*24*30, $serendipity['serendipityHTTPPath'], $_SERVER['HTTP_HOST'], false);
                            // Google Chrome browser does not set  cookies for domain "localhost" or other dotless hostnames. $_SERVER['HTTP_HOST'] must be NULL explicitely. Also do not use httponly parameter.
                            if(!isset($_COOKIE['KCFINDER_uploadurl']) || empty($_COOKIE['KCFINDER_uploadurl'])) {
                                setcookie('KCFINDER_uploadurl', serialize($serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath']), time()+60*60*24*30, $serendipity['serendipityHTTPPath'], NULL, false);
                                //setcookie($AUTH_COOKIE_NAME, $cookie_value, time() + cookie_expiration(),  $BASE_DIRECTORY,  null,  false,  true);
                                //this solved, Chrome still has some follow-up errors, not easy to solve. Please do not use Chrome with KCFINDER for domain "localhost" and similar local dotless named servers
                            }
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
        CONFIG_ACF_OFF       = <?php echo $acf_off; ?>;
        CONFIG_PBCK_ON       = <?php echo $pbck_on; ?>;
        CONFIG_KCFD_ON       = <?php echo $kcfd_on; ?>;
        CONFIG_TOOLBAR_BREAK = <?php echo (serendipity_db_bool($this->get_config('toolbar_break'))) ? "'/'" : "''"; ?>;
    </script>
    <script language="javascript" type="text/javascript" src="<?php echo $serendipity['serendipityHTTPPath'] . $relpath; ?>ckeditor.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo $plgpath . 'serendipity_event_ckeditor/'; ?>cke_plugin.js"></script>
<?php
                    } // add to backend header end
                    break;


                case 'css_backend':
?>
/* CKE styles start ----------------------------------------------------------------- */

<?php
                    // do not use in 2.0 versions
                    if ($serendipity['version'][0] == '1') {
                        echo file_get_contents(dirname(__FILE__) . '/cke_olds9y.css');
                    }
                    if (!strpos($eventData, '.cke_config_block')) {
                        echo file_get_contents(dirname(__FILE__) . '/cke_backend.css');
                    }

?>
/* CKE styles end ----------------------------------------------------------------- */

<?php
                    break;


                case 'external_plugin':
                    switch($eventData) {
                        case 'triggerckeinstall':
                            if ($this->install()) {
                                header('Location: ' . $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=plugins&serendipity[plugin_to_conf]='.urlencode($this->instance));
                            } else {
                                header('Location: ' . $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=plugins&serendipity[adminAction]=addnew&serendipity[only_group]=UPGRADE&serendipity[type]=event');
                            }
                    }
                    break;


                case 'backend_plugins_update':
                    // Make sure a Spartacus update really falls down to plugins config, for the need to deflate the zip, if necessary.
                    // This needs a *real* new HTTP request! Using plugin_to_conf:instance (see above) would not do here!!
                    // A request to ...&serendipity[install_plugin]=serendipity_event_ckeditor would force a deflate, but would install another plugin instance!
                    header('Location: ' . $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/triggerckeinstall');
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
                            $jebtnarr = (isset($eventData['buttons']) && (is_array($eventData['buttons']) && !empty($eventData['buttons']))) ? json_encode($eventData['buttons']) : 'null';
?>

<script type="text/javascript">
    if (window.Spawnnuggets) Spawnnuggets('<?php echo $eventData['item']; ?>', 'entryforms<?php echo $eventData['jsname']; ?>', <?php echo $jebtnarr; ?>);
</script>
<?php 
                        }
                    }
                    return true;
                    break;


                case 'backend_wysiwyg_finish':
                    // Run once only, save ressources
                    // This should better move into a future(!) 'backend_footer' hook, to not happen for every of any multiple textareas!
                    // but there $eventData['item'] isn't availabale yet...
                    if (isset($eventData['item']) && !empty($eventData['item'])) {
                        if (isset($eventData['buttons']) && (is_array($eventData['buttons']) && !empty($eventData['buttons']))) {
?>
    <script type="text/javascript">
        // send eventData as json encoded array into the javascript stream, which can be pulled by 'backend_header' hooks global Spawnnuggets() nugget function
        jsEventData = <?php echo json_encode($eventData['buttons']); ?>;
    </script>
<?php 
                        }
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