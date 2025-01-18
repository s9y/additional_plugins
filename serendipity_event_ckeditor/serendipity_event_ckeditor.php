<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

/**
 * Class member instance attribute values
 * Members must be initialized with a constant expression (like a string constant, numeric literal, etc), not a dynamic expression!
 */
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
    public $title = PLUGIN_EVENT_CKEDITOR_NAME;

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
    protected $cke_zipfile = 'ckeditor_4.5.10.3-plus.zip';

    /**
     * Access property checkUpdateVersion
     * Is zip file version and is independent from plugin version string
     * Verify release package versions - do update on upgrades!
     * @var array
     */
    protected $checkUpdateVersion = array('ckeditor:4.5.10.3');

    /**
     * Access property revisionPackage
     * Note revisions of ckeditor and plugin additions to lang files
     * @var array
     */
    protected $revisionPackage = array('CKEditor 4.5.10 (revision b47abaf, full package, 2016-07-13)',
                                       'CKEditor-Plugin: mediaembed, v. 0.6+ (https://github.com/frozeman/MediaEmbed, 2014-03-13)',
                                       'CKEditor-Plugin: manually added codesnippet, fakeobjects, lineutils and widget plugins, 2016-07-20)',
                                       'CKEditor-Plugin: procurator, v. 1.6 (Serendipity placeholder Plugin, 2016-01-01)',
                                       'CKEditor-Plugin: cheatsheet, v. 1.2 (Serendipity CKE-Cheatsheet Plugin, 2016-08-15)',
                                       'CKEditor-S9yCustomConfig, cke_config.js, v. 2.5, 2016-01-01',
                                       'CKEditor-S9yCustomPlugins, cke_plugin.js, v. 1.10, 2015-12-19',
                                       'CKEditor-S9yAddOn, fresh highlight.pack.js file v. 9.5.0 and github styles in highlight.css, (https://highlightjs.org/) 2016-06-28',
                                       'Prettify: JS & CSS files, v. "current", (http://code.google.com/p/google-code-prettify/, 2013-03-04)');


    function install()
    {
        global $serendipity;

        if (!$serendipity['serendipityUserlevel'] >= USERLEVEL_ADMIN) {
            return false;
        }
        // do we already have it?
        if (!$this->forceZipInstall && is_dir($this->cke_dir) && is_file($this->cke_dir . '/ckeditor.js')) {
            // this is running while getting a new Plugin version
            if ($this->checkUpdate()) {
                $this->set_config('installer', '4-'.date('Ymd-H:i:s')); // this is a faked debug notice, since falldown is extract true with case 0, 1 or 2
                // continue
            } else {
                $this->set_config('installer', '3-'.date('Ymd-H:i:s')); // this will happen, if no further extract is necessary in case of an update - follow install or upgrade routines
                return false;
            }
        }

        if (!extension_loaded('zip')) {
            trigger_error(' ZIP extension has not been compiled or loaded in PHP.', E_USER_WARNING);
            return;
        }

        if (is_writable($this->cke_path)) {
            $zip = new ZipArchive;
            if ($zip->open($this->cke_path . '/' . $this->cke_zipfile) === true) {
                $zip->extractTo($this->cke_path);
                $zip->close();
                $this->set_config('installer', '2-'.date('Ymd-H:i:s')); // returned by string[0], which is better than substr in this case
                // Check to remove every old ckeditor_(*)-plus.zip files - checked by partial string "-plus"
                foreach (glob($this->cke_path . '/*.zip') AS $filename) {
                    if ($this->cke_path . '/' . $this->cke_zipfile != $filename && (false !== strpos($filename, '-plus')) ) {
                        @unlink($filename);
                        $is_update = true;
                    }
                }
                if ($is_update) {
                    // purge removed files for upgraders to ckeditor v. 4.2 only
                    @unlink($this->cke_path . '/ckeditor/build_config.js');
                    @unlink($this->cke_path . '/ckeditor/skins/moono/images/mini.png');
                    // purge  removed files for upgraders to ckeditor >= v. 4.4.4 only
                    @unlink($this->cke_path . '/UTF-8/documentation_cz.html');
                    @unlink($this->cke_path . '/UTF-8/lang_en.inc.php');
                    @unlink($this->cke_path . '/UTF-8/documentation_cs.html');
                    // purge accidently added Thumbs.db file with 4.5.8.0/1 throwing errors on unzip
                    @unlink($this->cke_path . '/ckeditor/plugins/codesnippet/icons/hidpi/Thumbs.db');
                    @unlink($this->cke_path . '/ckeditor/plugins/procurator/images/Thumbs.db');
                }
                // remove widget/dev samples directory
                if (is_file(dirname(__FILE__) . '/ckeditor/plugins/widget/dev/console.js')) {
                    $this->empty_dir(dirname(__FILE__) . '/ckeditor/widget/dev');
                    @rmdir(dirname(__FILE__) . '/ckeditor/widget/dev');
                }
                // remove lineutils/dev samples directory
                if (is_file(dirname(__FILE__) . '/ckeditor/plugins/lineutils/dev/dnd.html')) {
                    $this->empty_dir(dirname(__FILE__) . '/ckeditor/lineutils/dev');
                    @rmdir(dirname(__FILE__) . '/ckeditor/lineutils/dev');
                }
                // remove usused placeholder plugin
                if (is_file(dirname(__FILE__) . '/ckeditor/plugins/placeholder/plugin.js')) {
                    $this->empty_dir(dirname(__FILE__) . '/ckeditor/plugins/placeholder');
                    @rmdir(dirname(__FILE__) . '/ckeditor/plugins/placeholder');
                }
                // remove code button plugin pbckcode
                if (is_file(dirname(__FILE__) . '/ckeditor/plugins/pbckcode/plugin.js')) {
                    $this->empty_dir(dirname(__FILE__) . '/ckeditor/plugins/pbckcode');
                    @rmdir(dirname(__FILE__) . '/ckeditor/plugins/pbckcode');
                }
                // remove kcfinder instance
                if (is_file(dirname(__FILE__) . '/kcfinder/config.php')) {
                    $this->empty_dir(dirname(__FILE__) . '/kcfinder');
                    @rmdir(dirname(__FILE__) . '/kcfinder');
                    unset($_COOKIE['KCFINDER_uploadurl']);
                    unset($_COOKIE['KCFINDER_displaySettings']);
                    unset($_COOKIE['KCFINDER_showname']);
                    unset($_COOKIE['KCFINDER_showsize']);
                    unset($_COOKIE['KCFINDER_showtime']);
                    unset($_COOKIE['KCFINDER_order']);
                    unset($_COOKIE['KCFINDER_orderDesc']);
                    unset($_COOKIE['KCFINDER_view']);
                }
                // extracted, continue to set this version into config
            } else {
                $this->set_config('installer', '1-'.date('Ymd-H:i:s'));
                return false;
            }
        } else {
            $this->set_config('installer', '0-'.date('Ymd-H:i:s')); // do it again, Sam
            return false;
        }
        // Extraction found true, add the new version string to configs last_ckeditor_version
        $this->updateConfig();
        return true;
    }

    function uninstall(&$propbag)
    {
        // todo? uninstall old instances which may be in there, caused by a duplicating bug using installer fallback without right instance, in 2.3.2 (was for one day online only)
    }

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_CKEDITOR_NAME);
        $propbag->add('description',   PLUGIN_EVENT_CKEDITOR_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Rustam Abdullaev, Ian');
        $propbag->add('version',       '4.5.10.6'); // is CKEDITOR Series 4.5.10 - and appended plugin revision .5
        $propbag->add('copyright',     'GPL or LGPL License');
        $propbag->add('requirements',  array(
            'serendipity' => '1.7',
            'smarty'      => '3.1.13',
            'php'         => '5.2.6'
        ));

        $propbag->add('event_hooks',   array(
            'frontend_header'                        => true,
            'frontend_footer'                        => true,
            'backend_header'                         => true,
            'css'                                    => true,
            'css_backend'                            => true,
            'external_plugin'                        => true,
            'backend_plugins_update'                 => true,
            'backend_media_path_exclude_directories' => true,
            'backend_wysiwyg'                        => true,
            'backend_wysiwyg_finish'                 => true
        ));
        $propbag->add('configuration', array('path', 'plugpath', 'codebutton', 'prettify', 'acf_off', 'toolbar', 'ibn_off', 'toolbar_break', 'force_install', 'timestamp'));
        $propbag->add('groups', array('BACKEND_EDITOR'));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'path':
                $propbag->add('type', 'string');
                $propbag->add('name', INSTALL_RELPATH);
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_OPTION_DESC . '"plugins/serendipity_event_ckeditor/ckeditor/"');
                $propbag->add('default', 'plugins/serendipity_event_ckeditor/ckeditor/');
                break;

            case 'plugpath':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_INSTALL_PLUGPATH);
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_OPTION_DESC . '"' . $serendipity['serendipityHTTPPath'] . 'plugins/"');
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
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_PRETTIFY_OPTION_DESC);
                $propbag->add('default', 'false');
                break;

            case 'acf_off':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION);
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION_DESC);
                $propbag->add('default', 'false');
                break;

            case 'toolbar':
                $select = array();
                $select["Standard"] = 'STANDARD';
                $select["Basic"]    = 'BASIC';
                $select["Full"]     = 'FULL';
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_SETTOOLBAR_OPTION);
                $propbag->add('description', '');
                $propbag->add('select_values', $select);
                $propbag->add('default', 'Standard');
                break;

            case 'ibn_off':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_CKEIBN_OPTION);
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_CKEIBN_OPTION_DESC);
                $propbag->add('default', 'true');
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
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_FORCEINSTALL_OPTION_DESC . $this->cke_zipfile);
                $propbag->add('default', 'false');
                break;

            case 'timestamp':
                $propbag->add('type', 'hidden');
                $propbag->add('value', time());
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function example()
    {
        $s = '';
        if (serendipity_db_bool($this->get_config('force_install'))) {
            $this->forceZipInstall = true;
            $this->install();
            $this->forceZipInstall = false;
            $this->set_config('force_install', 'false');
            // forceZipInstall forces to surround the checkUpdate function, thus we set config database table to keep track
            $this->updateConfig();
            $s .= '<p class="msg_success"><span class="icon-ok" aria-hidden="true"></span><strong>Force deflate done:</strong> Please reload this page <a href="'.$serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=plugins&serendipity[plugin_to_conf]='.urlencode($this->instance).'" target="_self">here</a>!</p>';
        }

        $installer = $this->get_config('installer'); // Can't use method return value in write context in '' with substr(), get_config() and isset()
        $parts     = explode(':', $this->checkUpdateVersion[0]); // this is ckeditor only

        $s .= PLUGIN_EVENT_CKEDITOR_REVISION_TITLE;
        $s .= "\n<ul>\n";
        // hook this as a scalar value into this plugins lang files (would be needed by adding this to a constant)
        foreach( $this->revisionPackage AS $revision ) {
            $s .= '    <li>' . $revision . "</li>\n";
        }
        $s .= "</ul>\n\n";

        if (!empty($installer)) {
            switch ($installer[0]) {
                case '4': // this won't happen, since case 2 is true - just a fake
                    $s .= '<p class="msg_notice"><span class="icon-attention" aria-hidden="true"></span> <strong>Check Plugin Update Message:</strong> NO CONFIG SET OR NO MATCH -> config_set: "last_'.$parts[0].'_version:'. $parts[1].'"</p>';
                    break;
                case '3':
                    $s .= '<p class="msg_success"><span class="icon-ok" aria-hidden="true"></span> <strong>Installer Update Message:</strong> Check Update found false, no unpack needed. Plugin upgrade successfully done <strong>or</strong> has been triggered to be checked by an other Spartacus Plugin update!</p>';
                    break;
                case '2':
                    $s .= '<p class="msg_success"><span class="icon-ok" aria-hidden="true"></span> <strong>Installer Message:</strong> Extracting the zip to ' . $this->cke_path . ' directory done!</p>';
                    break;
                case '1':
                    $s .= '<p class="msg_error"><span class="icon-error" aria-hidden="true"></span> <strong>Installer Error[1]:</strong> Extracting the zip to ' . $this->cke_path . ' directory failed!<br>Please extract ' . $this->cke_zipfile . ' by hand.</p>';
                    break;
                case '0':
                    $s .= '<p class="msg_error"><span class="icon-error" aria-hidden="true"></span> <strong>Installer Error[0]:</strong> Due to a writing permission error, extracting the zip to ' . $this->cke_path . ' directory failed!<br>Please set "/plugins" or "/plugins/serendipity_event_ckeditor" directory and files correct writing permissions and extract ' . $this->cke_zipfile . ' by hand or try again and <u>remove(!)</u> this plugin from your plugin list and install it again.</p>';
                    break;
            }
            $this->set_config('installer', ''); // can't use serendipity_plugin_api::remove_plugin_value($this->instance, array('installer')); here, since it delivers the wrong instance
        }
        #echo $installer[0] . ' - ' . $this->instance; // this debug message on the other hand will do well, if all went through w/o install() returning false
        $s .= PLUGIN_EVENT_CKEDITOR_INSTALL;
        $s .= PLUGIN_EVENT_CKEDITOR_CONFIG;
        $s .= PLUGIN_EVENT_CKEDITOR_SCAYT;
        return $s;
    }

    /**
     * Downgrade of version to keep plugin version track with CKE versioning for upcoming next major upgrades!
     * This method is temporary only!
     * @see updateConfig()
     * @see checkUpdate()
     */
    private function temporaryDowngrade($newVersion, $oldVersion)
    {
        global $serendipity;

        $thisclass = serendipity_db_escape_string('serendipity_event_ckeditor');
        $row = serendipity_db_query("SELECT version FROM {$serendipity['dbPrefix']}pluginlist
                                      WHERE plugin_class = '" . $thisclass . "'
                                        AND pluginlocation = 'local'
                                      LIMIT 1", true, 'assoc');

        $versions = array($oldVersion, $newVersion); // keep prior and current versions false check
        if (in_array($row['version'], $versions)) {
            return false;
        }

        serendipity_db_query("UPDATE {$serendipity['dbPrefix']}pluginlist
                                 SET version      = '" . serendipity_db_escape_string($oldVersion) . "'
                               WHERE plugin_class = '" . $thisclass . "'
                                 AND pluginlocation = 'local'");
        serendipity_db_query("UPDATE {$serendipity['dbPrefix']}pluginlist
                                 SET upgrade_version = '" . serendipity_db_escape_string($newVersion) . "'
                               WHERE plugin_class    = '" . $thisclass . "'
                                 AND pluginlocation = 'local'");
    }

    /**
     * Set config database table to keep track to zip update versions
     * @access    private
     */
    private function updateConfig()
    {
        #$this->temporaryDowngrade('4.5.10.3', '4.5.10.2'); // was temporary used for the harmonization of plugin and lib versions
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
    private function checkUpdate()
    {
        #$this->temporaryDowngrade('4.5.10.3', '4.5.10.2'); // was temporary used for the harmonization of plugin and lib versions
        $doupdate = false;
        foreach(array_values($this->checkUpdateVersion) AS $package) {
            $match = explode(':', $package);
            // always set and extract if not match
            if ($this->get_config('last_'.$match[0].'_version') == $match[1]) {
                $doupdate = false;
            } else {
                $doupdate = true;
                break; // this is probably needed to force install upgrade routines
            }
        }
        return $doupdate;
    }

    /**
     * empty a directory using the Standard PHP Library (SPL) iterator
     * @access    private
     * @param   string directory
     */
    private function empty_dir($dir)
    {
        if (!is_dir($dir)) return;
        try {
            $_dir = new RecursiveDirectoryIterator($dir);
            // NOTE: UnexpectedValueException thrown for PHP >= 5.3
            } catch (Exception $e) {
                return;
            }
        $iterator = new RecursiveIteratorIterator($_dir, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($iterator AS $file) {
            if ($file->isFile()) {
                @unlink($file->__toString());
            } else {
                @rmdir($file->__toString());
            }
        }
        @rmdir(dir);
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {

                case 'frontend_header':
                    $headcss = true;
                case 'frontend_footer':
                    // set prettify.css and prettify.js in frontend footer by plugin option (too much overhead to split this into head css and food js!)
                    if (serendipity_db_bool($this->get_config('codebutton', false))) {
                        $plugingpath = function_exists('serendipity_specialchars') ? serendipity_specialchars($this->get_config('plugpath')) : htmlspecialchars($this->get_config('plugpath'), ENT_COMPAT, LANG_CHARSET);
if ($headcss) {
?>
    <link rel="stylesheet" href="<?php echo $plugingpath . 'serendipity_event_ckeditor/highlight.css'; ?>" />
<?php
} else {
?>
    <script src="<?php echo $plugingpath . 'serendipity_event_ckeditor/highlight.pack.js'; ?>"></script>
    <script>
    jQuery(function($){
        // launch the codesnippet highlight
        hljs.initHighlightingOnLoad();
    });
    </script>
<?php
}
                        if (serendipity_db_bool($this->get_config('prettify', false))) {
if ($headcss) {
?>
    <link rel="stylesheet" type="text/css" href="<?php echo $plugingpath . 'serendipity_event_ckeditor/prettify.css'; ?>" />
<?php
} else {
?>
    <script type="text/javascript" src="<?php echo $plugingpath . 'serendipity_event_ckeditor/prettify.js'; ?>"></script>
    <script>
    jQuery(function($){
        // launch the prettify code
        prettyPrint();
    });
    </script>
<?php
}
                        }
                    }
                    break;

                case 'backend_header':
                    if (isset($serendipity['wysiwyg']) && $serendipity['wysiwyg'] && isset($eventData) && !isset($_GET['serendipity']['iframe_mode'])) {
                        // Check, if Serendipity 2.1 changed WYSIWYG_LANG constant already is defined,
                        // which changed 2-letter or "**-utf" marked langs eg. "en" to "en_US", using the POSIX underscore standard,
                        // else workaround using DATE_LOCALES.
                        if (defined('DATE_LOCALES') && (false !== strpos('_', WYSIWYG_LANG))) {
                            // scayt available langs are ('en_US', 'en_GB', 'pt_BR', 'da_DK', 'nl_NL', 'en_CA', 'fi_FI', 'fr_FR', 'fr_CA', 'de_DE', 'el_GR', 'it_IT', 'la_VA', 'nb_NO', 'pt_PT', 'es_ES', 'sv_SE');
                            $locale  = explode(',', DATE_LOCALES); // get the current defined locales as array
                            $special = array('Arabic', 'bulgarian', 'pl.UTF-8', 'tw'); // special lang exceptions which have them at last position
                            if (in_array($locale[0], $special)) {
                                $slocale = @strtok(end($locale), "."); // strtok dot fixes 'ar_SA.windows-1256'
                                @reset($locale);
                            }
                            $_locale = trim(isset($slocale) ? $slocale : $locale[0]); // set the current lang locale as string
                            if (!empty($_locale)) {
                                $flocale = explode('.', $_locale); // $flocale array is the first defined 4-letter lang locale, eg "de_DE".
                                if ($flocale[0] == 'nl_BE') $flocale[0] = 'nl_NL'; // case locale Nederlands / Belgium set back to Dutch (Netherlands)
                                if ($flocale[0] == 'sv_SV') $flocale[0] = 'sv_SE'; // case Swedish set back to Swedish (Sweden)
                            }
                        }
                        $relpath = function_exists('serendipity_specialchars') ? serendipity_specialchars($this->get_config('path')) : htmlspecialchars($this->get_config('path'), ENT_COMPAT, LANG_CHARSET);
                        $plgpath = function_exists('serendipity_specialchars') ? serendipity_specialchars($this->get_config('plugpath')) : htmlspecialchars($this->get_config('plugpath'), ENT_COMPAT, LANG_CHARSET);
                        $acf_off = serendipity_db_bool($this->get_config('acf_off', 'false')) ? 'true' : 'false';    // need this, to be passed correctly as boolean true/false to custom cke_config.js
                        $code_on = serendipity_db_bool($this->get_config('codebutton', 'false')) ? 'true' : 'false'; // same here for cke_plugins.js
                        $uats_on = $serendipity['use_autosave'] ? 'true' : 'false';                                  // dito
                        $toolbar = $this->get_config('toolbar', 'Standard');
                        $time    = $this->get_config('timestamp', time());
                        $slang   = (isset($flocale) && !empty($flocale[0]) ? $flocale[0] : WYSIWYG_LANG); // set scayt locales 4-letter POSIX lang or fall back
                        $lang    = $slang ? $slang : 'en_US'; // use new WYSIWYG_LANG, or the workaround locale, or fall back to default
                        $lang    = str_replace('_', '-', $lang); // change to IETF standard unicode language tag, using a dash
                        /*
                            Define some global CKEDITOR plugin startup vars
                            Include the ckeditor
                            Build dynamic plugins and set the custom config (cke_config.js)
                            Sadly this can not hook into js_backend hook in 2.0, since that is cached to lazyload
                        */
?>

    <script type="text/javascript">
        CKEDITOR_BASEPATH       = '<?php echo $relpath; ?>';
        CKEDITOR_PLUGPATH       = '<?php echo $plgpath; ?>';
        S9Y_VERSION_NEW         = <?php echo $serendipity['version'][0] < 2 ? 'false' : 'true'; ?>;
        CKECONFIG_ACF_OFF       = <?php echo $acf_off; ?>;
        CKECONFIG_CODE_ON       = <?php echo $code_on; ?>;
        CKECONFIG_LANG          = '<?php echo $lang; ?>'; // as IETF
        CKECONFIG_SLANG         = '<?php echo $slang; ?>'; // as POSIX
        CKECONFIG_TOOLBAR       = '<?php echo $toolbar; ?>';
        CKECONFIG_TOOLBAR_BREAK = <?php echo serendipity_db_bool($this->get_config('toolbar_break', 'false')) ? "'/'" : "''"; ?>;
        CKECONFIG_FORCE_LOAD    = <?php echo $time; ?>;
        CKECONFIG_USEAUTOSAVE   = <?php echo $uats_on; ?>;
    </script>
    <script type="text/javascript" src="<?php echo $serendipity['serendipityHTTPPath'] . $relpath; ?>ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo $plgpath . 'serendipity_event_ckeditor/'; ?>cke_plugin.js"></script>
<?php
                        // sadly this can't be pushed into streamed css, since that is cached to lazyload.
                        if ($toolbar == 'Basic') {
                            if ($serendipity['version'][0] < 2) {
?>
    <link rel="stylesheet" href="<?php echo $plgpath . 'serendipity_event_ckeditor/'; ?>basic_toolbar1.css" />
<?php
                            } else {
?>
    <link rel="stylesheet" href="<?php echo $plgpath . 'serendipity_event_ckeditor/'; ?>basic_toolbar2.css" />
<?php
                            }
                        } else { // case other toolbars
                            if (false === serendipity_db_bool($this->get_config('ibn_off', 'true')) ) {
?>
    <link rel="stylesheet" href="<?php echo $plgpath . 'serendipity_event_ckeditor/'; ?>cke_ibn.css" />
<?php
                            }
                        }
                    }
                    break;

                case 'css':
                    if (serendipity_db_bool($this->get_config('codebutton', false))) {

/* moved to highlight.css to prepend streamed css first (keep note!)

CKEDITOR CODESNIPPET PLUGIN
pre {
    word-wrap: inherit; fixes chrome issue
}
pre code {
    white-space: pre;
    overflow-x: auto;
}
.hljs {
    border-left: 5px solid #DDD;
}
*/
                        if (serendipity_db_bool($this->get_config('prettify', false))) {
                            ob_start();
?>

/* CKEDITOR PLUGIN PBCKCODE PRETTY PRINT */

.prettyprint {
    padding: 8px;
    background-color: #f7f7f9;
    border: 1px solid #e1e1e8;
}
.prettyprint.linenums {
    -webkit-box-shadow: inset 40px 0 0 #fbfbfc, inset 41px 0 0 #ececf0;
       -moz-box-shadow: inset 40px 0 0 #fbfbfc, inset 41px 0 0 #ececf0;
            box-shadow: inset 40px 0 0 #fbfbfc, inset 41px 0 0 #ececf0;
}
.content ol {
    margin: 0px 0px 1em 2em;
}

<?php
    if ($serendipity['template'] == 'bulletproof') {
?>

.serendipity_entry ol.linenums {
    padding-left: 40px;
}

<?php
    }
?>

ol.linenums li {
    padding-left: 1em;
    color: #bebec5;
    line-height: 1.6;
    text-shadow: 0 1px 0 #fff;
}


<?php
                            $ckeplugin_frontpage_css = ob_get_contents();
                            ob_end_clean();

                            $eventData .= $ckeplugin_frontpage_css; // append CSS
                        }
                    }
                    break;

                case 'css_backend':

                    // do not use in 2.0 versions
                    if ($serendipity['version'][0] < 2) {
                        $eventData .= @file_get_contents(dirname(__FILE__) . '/cke_olds9y.css');
                    }
                    if (strpos($eventData, '.cke_config_block') === false) {
                        $eventData .= @file_get_contents(dirname(__FILE__) . '/cke_backend.css');
                    }
                    break;

                case 'external_plugin':
                    if ($eventData == 'triggerckeinstall') {
                        if ($this->install()) {
                            header('Location: ' . $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=plugins&serendipity[plugin_to_conf]='.urlencode($this->instance));
                        } else {
                            header('Location: ' . $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=plugins&serendipity[plugin_to_conf]='.urlencode($this->instance));
                        }
                    }
                    break;

                case 'backend_plugins_update':
                    if ($eventData == 'serendipity_event_ckeditor' && !$serendipity['ajax']) {
                    // @TODO: This is is really messed up. Probably much better to perform a HTTP_Request to perform an action. Text below needs to be reworked, that all makes no sense to me.
                    
                        // Make sure a Spartacus update really falls down into this plugins config.
                        // In case of using the UPDATE ALL 1-click ajax-upgrader, this redirection is disabled and you have to force the extraction yourself in the config.
                        // This needs a *REAL* new HTTP request! Using plugin_to_conf:instance (see above) would not do here!!
                        // A request to ...&serendipity[install_plugin]=serendipity_event_ckeditor would force a deflate, but would install another plugin instance!
                        header('Location: ' . $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/triggerckeinstall');
                        // This runtime breakage will reset all other plugins waiting to UPGRADE back to their current version in table pluginlist.
                        // After this, the updater has to wait for a new read of the xml file(s) and to set pending plugins with setPluginInfo() method for versions and timestamp again.
                        // This is not what we want here! So we nuke the blog-servers xml file in templates_c to later on continue with pending plugin updates.
                        // Spartacus has to be prepared to set this global var. All other users probably have to wait up to 12h+.
                        //#@unlink($serendipity['spartacus_cachedXMLfile']);
                        //#die(); // now exit the runtime UPGRADE task executor, which forces to really halt into this->install() check redirector!
                    }
                    break;

                case 'backend_media_path_exclude_directories':
                    $eventData[".thumbs"] = true;
                    break;

                case 'backend_wysiwyg':
                    $eventData['skip'] = true; // this skips htmlarea drop-in

                    if (preg_match('@^nugget@i', $eventData['item'])) {
                        // switch to finisher, in case of nuggets
                        $this->event_hook('backend_wysiwyg_finish', $bag, $eventData);
                    } else {
                        if (serendipity_db_bool($this->get_config('codebutton'))) {
                            // for case using customized toolbars, else it falls back to toolbar Group where 'others' is automatically added
                            $bid = array();
                            if (isset($eventData['buttons']) && (is_array($eventData['buttons']) && !empty($eventData['buttons']))) foreach ($eventData['buttons'] AS $bt) { $bid[] = $bt['id']; }
                            $addB = implode(",", $bid);
                            $addB = str_replace(',','","',$addB);
                        }
                        // this builds both textareas of entry forms only
                        if (isset($eventData['item']) && !empty($eventData['item'])) {
                            $jebtnarr = (isset($eventData['buttons']) && (is_array($eventData['buttons']) && !empty($eventData['buttons']))) ? json_encode($eventData['buttons']) : 'null';
?>
<script type="text/javascript">
    if (typeof s9ypluginbuttons !== 'undefined') s9ypluginbuttons.push("<?php echo $addB; ?>");
    if (window.Spawnnuggets) Spawnnuggets('<?php echo $eventData['item']; ?>', 'entryforms<?php echo $eventData['jsname']; ?>', <?php echo $jebtnarr; ?>);
</script>
<?php 
                        }
                    }
                    break;

                case 'backend_wysiwyg_finish':
                    // Run once only, save ressources
                    // This should better move into a future(!) 'backend_footer' hook, to not happen for every of any multiple textareas!
                    // but there $eventData['item'] isn't available yet...
                    if (isset($eventData['item']) && !empty($eventData['item'])) {
                        if (isset($eventData['buttons']) && (is_array($eventData['buttons']) && !empty($eventData['buttons']))) {
                            // send eventData as json encoded array into the javascript stream, which can be pulled by 'backend_header' hooks global Spawnnuggets() nugget function
?>
    <script type="text/javascript">
        jsEventData = <?php echo json_encode($eventData['buttons']); ?>;
    </script>
<?php
                        }
                    }
                    break;

                default:
                    return false;

            }
            return true;
        } else {
            return false;
        }
    }

}

?>