<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_autoupdate extends serendipity_event {
    var $title = PLUGIN_EVENT_AUTOUPDATE_NAME;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_AUTOUPDATE_NAME);
        $propbag->add('description',   PLUGIN_EVENT_AUTOUPDATE_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'onli, Ian');
        $propbag->add('version',       '1.1.9');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'php'         => '5.2'
        ));
        $propbag->add(
            'event_hooks',
            array(
                'plugin_dashboard_updater' => true,
                'backend_sidebar_entries_event_display_update' => true,
                'backend_sidebar_entries_event_display_update_no_integrity_checks' => true,
            )
        );
        $propbag->add('configuration', array(
            'disable_integrity_checks',
        ));
        $propbag->add('groups', array('BACKEND_FEATURES'));
        if ($serendipity['version'][0] < 2) {
            $this->dependencies   = array('serendipity_event_dashboard' => 'keep');
        }
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function install() {
        global $serendipity;

        if (!$serendipity['serendipityUserlevel'] >= USERLEVEL_ADMIN) {
            return false;
        }
    }

    /**
     * @param string $name
     * @param serendipity_property_bag $propbag
     * @return bool
     */
    function introspect_config_item($name, &$propbag)
    {
        switch ($name) {
            case 'disable_integrity_checks':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_AUTOUPDATE_DISABLE_INTEGRITY_CHECKS);
                $propbag->add('description', PLUGIN_EVENT_AUTOUPDATE_DISABLE_INTEGRITY_CHECKS_DESC);
                $propbag->add('default', false);
                break;
            default:
                return false;
        }

        return true;
    }

    /**
     * flush progress or error messages
     */
    function show_message($message='', $pname='', $next='') {

        if (!empty($pname)) {
            // Total processes
            $total = 3;

            ob_implicit_flush(1);

            // fake processing loop
            for ($i=1; $i<=$total; $i++) {
                // Calculate the percentation
                $percent = intval($i/$total * 100)."%";

                // Javascript for updating the progress bar and information
                echo '
<script type="text/javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#ddd;\">&nbsp;</div>";
    document.getElementById("information").innerHTML="'.$percent.' processed.";
</script>';

                //this is for the buffer achieve the minimum size in order to flush data
                echo str_repeat(' ',1024*64); // need to keep here since this also flushes the progress bar on fastCGI

                // Send output to browser immediately
                ob_flush();
                flush();

                // Sleep one second so we can see the delay
                 sleep(1);
            }
            $wait = strstr($pname, 'Function') ? ' Please wait ... Processing: '.$next.' ...' : ''; // no tags allowed here
            // Tell user that the process is completed
            echo '<script type="text/javascript">document.getElementById("information").innerHTML="'.$pname.' completed!'.$wait.'"</script>';
        }

        echo "$message\n";
        $levels = ob_get_level();
        for ($i=0; $i<$levels; $i++) {
            ob_end_flush();
        }
        ob_flush();
        flush();
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'plugin_dashboard_updater':
                        $eventData = '<form action="?serendipity[adminModule]=event_display&serendipity[adminAction]=update" method="POST">
                        <input type="hidden" name="serendipity[newVersion]" value="'.$addData.'" />
                        ' . ($serendipity['version'][0] > 1 ? '<button type="submit">'.PLUGIN_EVENT_AUTOUPDATE_UPDATEBUTTON.'</button>' : '<input type="submit" value="'.PLUGIN_EVENT_AUTOUPDATE_UPDATEBUTTON.'" />') . '
                        </form>';
                    return true;
                    break;

                case 'backend_sidebar_entries_event_display_update_no_integrity_checks':
                    $this->set_config('disable_integrity_checks', true);
                    // `break` statement intentionally omitted!
                case 'backend_sidebar_entries_event_display_update':
                    if (!(serendipity_checkPermission('siteConfiguration') || serendipity_checkPermission('blogConfiguration'))) {
                        return;
                    }
                    if (!extension_loaded('zip')) {
                        trigger_error(' ZIP extension has not been compiled or loaded in php.', E_USER_WARNING);
                        return;
                    }
                    @ini_set('max_execution_time', 210); // 180 + (21+9 gui happenings)
                    #@ini_set('memory_limit', '-1'); // extending memory_limit may be prevented by suhosin extension. 
                    /*
                       As long scripts are not running within safe_mode they are free to change the memory_limit to whatever value they want. 
                       Suhosin changes this fact and disallows setting the memory_limit to a value greater than the one the script started with, 
                       when this option is left at 0. A value greater than 0 means that Suhosin will disallows scripts setting the memory_limit 
                       to a value above this configured hard limit. This is for example usefull if you want to run the script normaly with a limit 
                       of 16M but image processing scripts may raise it to 20M. 
                       Edit /etc/php5/conf.d/suhosin.ini and add e.g. suhosin.memory_limit = 512M ...
                    */
                    $self_info = sprintf(USER_SELF_INFO, (function_exists('serendipity_specialchars') ? serendipity_specialchars($serendipity['serendipityUser']) : htmlspecialchars($serendipity['serendipityUser'], ENT_COMPAT, LANG_CHARSET)), $serendipity['permissionLevels'][$serendipity['serendipityUserlevel']]);
                    $lang_char = LANG_CHARSET;
                    $ad_suite  = SERENDIPITY_ADMIN_SUITE;
                    $css_upd   = file_get_contents(dirname(__FILE__) . '/upgrade.min.css');
                    $nv        = (function_exists('serendipity_specialchars') ? serendipity_specialchars($_REQUEST['serendipity']['newVersion']) : htmlspecialchars($_REQUEST['serendipity']['newVersion'], ENT_COMPAT, LANG_CHARSET)); // reduce to POST only?
                    $logmsg    = '';
                    echo <<<EOS
<!DOCTYPE html>
<html>
    <head>
        <base target="_self"/>
        <title>Startpage - {$ad_suite}</title>
        <meta http-equiv="Content-Type" content="text/html; charset={$lang_char}">
        <style type="text/css">
{$css_upd}
        </style>
    </head>

    <body id="serendipity_admin_page">

    <header id="top">
        <div class="clearfix">
            <div id="banner">
                <h1>{$ad_suite}</h1>
                <span class="block_level">{$self_info}</span>
            </div>
            <nav id="user_menu">
                <h2 class="visuallyhidden">User menu</h2> 

                <ul>
                    <li><a class="icon_link" href="serendipity_admin.php" title="Startpage"><span class="icon-home" aria-hidden="true"></span><span class="visuallyhidden"> Startpage</span></a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div id="main" class="clearfix">
        <div id="serendipity_updater" class="clearfix">
            <header>
                <h2>Serendipity Auto-Upgrade Processor</h2>
                <!-- Progress bar holder -->
                <div id="progress" style="width:500px;border:1px solid #ccc;"></div>
                <!-- Progress information -->
                <div id="information" style="width"></div>
                <div id="loader"><span></span><span></span><span></span></div>
            </header>
            <article>
EOS;

                    $this->show_message('<p class="msg_notice"><span class="icon-attention" aria-hidden="true"></span>Download, verify, check, unzip, copy, remove temporary stuff for Serendipity Update: ' . $_REQUEST['serendipity']['newVersion'] . ' may take a little while...<br>Please don\'t get nervous and do not close this page while in progress!</p><hr>');
                    $this->show_message('<p class="msg_notice" style="font-size: small;color: #999;"><span class="icon-attention" aria-hidden="true"></span>Please note: If this page ever stops with an error message during procession, you can normally just RELOAD your browser [by keyboard shortcut] to get another run. This does not do any harm to a continued upgrade.</p>');
                    $this->show_message('<p class="msg_notice"><span class="icon-attention" aria-hidden="true"></span>PHP max execution time set to 210 seconds</p>');
                    $start = microtime(true);
                    if (false === ($update = $this->fetchUpdate($nv))) {
                        $this->close_page(true);
                    }
                    usleep(3);
                    $time = microtime(true) - $start;
                    $logmsg .= $lmsg = sprintf("In %0.4d seconds run fcn fetchUpdate()...\n", $time); // print in readable format 1.2345
                    $this->show_message('<p class="msg_run"><span class="icon-clock" aria-hidden="true"></span><em>'.$lmsg.'</em></p>', 'Function fetch update', 'verify the update pack');
                    if (!empty($update)) {
                        $start = microtime(true);
                        if ($this->verifyUpdate($update, $nv)) {
                            usleep(3);
                            $time = microtime(true) - $start;
                            $logmsg .= $lmsg = sprintf("In %0.4d seconds run fcn verifyUpdate()...\n", $time); // print in readable format 1.2345
                            $this->show_message('<p class="msg_run"><span class="icon-clock" aria-hidden="true"></span><em>'.$lmsg.'</em></p>', 'Function verify update', 'checking write permissions');
                            $start = microtime(true);
                            if ($this->checkWritePermissions($update)) {
                                usleep(3);
                                $time = microtime(true) - $start;
                                $logmsg .= $lmsg = sprintf("In %0.4d seconds run fcn checkWritePermissions()...\n", $time); // print in readable format 1.2345
                                $this->show_message('<p class="msg_run"><span class="icon-clock" aria-hidden="true"></span><em>'.$lmsg.'</em></p>', 'Function check write permissions', 'unpacking the update');
                                $start = microtime(true);
                                $unpacked = $this->unpackUpdate($nv);
                                usleep(3);
                                $time = microtime(true) - $start;
                                $logmsg .= $lmsg = sprintf("In %0.4d seconds run fcn unpackUpdate()...\n", $time); // print in readable format 1.2345
                                $this->show_message('<p class="msg_run"><span class="icon-clock" aria-hidden="true"></span><em>'.$lmsg.'</em></p>', 'Function unpack update', 'checking integrity');
                                if ($unpacked) {
                                    $start = microtime(true);
                                    $disableIntegrityChecks = $this->get_config('disable_integrity_checks', false);
                                    if ($disableIntegrityChecks !== false || $this->checkIntegrity($nv)) {
                                        usleep(3);
                                        $time = microtime(true) - $start;
                                        if ($disableIntegrityChecks !== false) {
                                            $this->set_config('disable_integrity_checks', false); //reset config
                                            $logmsg .= $lmsg = "fcn checkIntegrity() skipped...\nReset 'disable_integrity_checks' to false\n";
                                        } else {
                                            $logmsg .= $lmsg = sprintf("In %0.4d seconds run fcn checkIntegrity()...\n", $time); // print in readable format 1.2345
                                        }
                                        $this->show_message('<p class="msg_run"><span class="icon-clock" aria-hidden="true"></span><em>'.$lmsg.'</em></p>', 'Function check integrity', 'finally copy update');
                                        $start = microtime(true);
                                        $copied = $this->copyUpdate($nv);
                                        usleep(3);
                                        $time = microtime(true) - $start;
                                        $logmsg .= $lmsg = sprintf("In %0.4d seconds run fcn copyUpdate()...\n", $time); // print in readable format 1.2345
                                        $this->show_message('<p class="msg_run"><span class="icon-clock" aria-hidden="true"></span><em>'.$lmsg.'</em></p>', 'Function copy update', 'cleaning up temporary directory');
                                        if ($copied) {
                                            $start = microtime(true);
                                            if (true === $this->cleanTemplatesC($nv, true) ) {
                                                $this->show_message('<p class="msg_success"><span class="icon-ok" aria-hidden="true"></span>Cleanup download temp done!</p>');
                                            }
                                            usleep(3);
                                            $time = microtime(true) - $start;
                                            $logmsg .= $lmsg = sprintf("In %0.4d seconds run fcn cleanTemplatesC()...\n", $time); // print in readable format 1.2345
                                            $this->show_message('<p class="msg_run"><span class="icon-clock" aria-hidden="true"></span><em>'.$lmsg.'</em></p>', 'Function cleanup templates_c', 'finish processing unit');
                                            sleep(2);
                                            echo '<script type="text/javascript">var el = document.getElementById("loader"); el.style.display = "none";</script>';
                                            sleep(2);
                                            $this->show_message('<p class="msg_notice"><span class="icon-attention" aria-hidden="true"></span><a href="'.$serendipity['serendipityHTTPPath'].'">click to start Serendipity Installer here</a>!</p>');
                                            sleep(1);
                                            $this->doUpdate();//$logmsg
                                        } else {
                                             $this->show_message('<p class="msg_error"><span class="icon-error" aria-hidden="true"></span>Copying the files for the update failed</p>');
                                        }
                                     } else {
                                        $this->showChecksumErrors($nv);
                                        echo sprintf(
                                            '<form action="?serendipity[adminModule]=event_display&serendipity[adminAction]=update_no_integrity_checks" method="POST"><input type="hidden" name="serendipity[newVersion]" value="%s"/>%s</form>',
                                            $nv,
                                            $serendipity['version'][0] > 1 ? '<button type="submit">'.PLUGIN_EVENT_AUTOUPDATE_RETRY_NO_INTEGRITY_CHECKS_BUTTON.'</button>' : '<input type="submit" value="'.PLUGIN_EVENT_AUTOUPDATE_RETRY_NO_INTEGRITY_CHECKS_BUTTON.'" />'
                                        );
                                    }
                                } else {
                                    $this->show_message('<p class="msg_error"><span class="icon-error" aria-hidden="true"></span>Unpacking the update failed</p>');
                                    if (true === $this->cleanTemplatesC($nv, false)) {
                                        $this->show_message('<p class="msg_success"><span class="icon-ok" aria-hidden="true"></span>Cleaning up the failed unpack directory!</p>');
                                    }
                                    $this->show_message('<p class="msg_notice"><span class="icon-attention" aria-hidden="true"></span>Please reload this page by F5 to have another try upgrading your Blog successfully!</p>');
                                }
                                
                            } else {
                               $this->showNotWriteable($update);
                               echo '<form action="?serendipity[adminModule]=event_display&serendipity[adminAction]=update" method="POST">
                                    <input type="hidden" name="serendipity[newVersion]" value="'.$nv.'" />
                                    <input type="submit" value="'.PLUGIN_EVENT_AUTOUPDATE_UPDATEBUTTON.'" />
                                    </form>';
                            }
                        }
                    }
                    $this->close_page(true);

                    return true;
                    break;

                default:
                    return false;
            }
        } else {
            return false;
        }
    }

    /**
     * fetch the zip file from server
     * @param string $version Version
     * @return mixed updatepath/bool
     */
    function fetchUpdate($version) {
        global $serendipity;
        $url     = (string)"https://github.com/s9y/Serendipity/releases/download/$version/serendipity-$version.zip";
        if (strpos($version, 'beta') !== FALSE) {
            $url = (string)"https://github.com/s9y/Serendipity/archive/$version.zip";
        }
        $update  = (string)$serendipity ['serendipityPath'] . 'templates_c/' . "serendipity-$version.zip";
        
        // do we already have it and is it eventually broken?
        if (file_exists($update)) {
            $zip = new ZipArchive;
            $res = $zip->open($update);
            if ($res === TRUE) {
                $done = true;
            } else {
                $this->show_message('<p class="msg_error"><span class="icon-error" aria-hidden="true"></span>Existing Zip file Error, Code:' . $res. '. The autoupdater will try to download again...');
                @unlink($update);
                sleep(1);
                $done = @copy($url, $update) ? true : false;
                sleep(1);
            }
            $zip->close();
        } else {
            $done = @copy($url, $update) ? true : false;
            sleep(1);
        }

        if (!$done) {
            //try it again with curl if copy was forbidden
            if (function_exists('curl_init')) {
                $out = @fopen($update, 'wb');
                $ch  = @curl_init();

                @curl_setopt($ch, CURLOPT_FILE, $out);
                @curl_setopt($ch, CURLOPT_HEADER, 0);
                @curl_setopt($ch, CURLOPT_URL, $url);
                            
                $success = @curl_exec($ch);
                if (!$success) {
                    $this->show_message('<p class="msg_error"><span class="icon-error" aria-hidden="true"></span>Downloading update failed (curl installed, but failed). Does '. $url .' exist?</p>');
                    return false;
                }
            } else {
                $this->show_message('<p class="msg_error"><span class="icon-error" aria-hidden="true"></span>Downloading update failed (copy failed, curl not available). Does '. $url .' exist?</p>');
                return false;
            }
        }
        $this->show_message('<p class="msg_success"><span class="icon-ok" aria-hidden="true"></span>Fetch download to templates_c done</p>');
        return $update;
    }

    /**
     * compare the md5 of downloaded archive with the md5 posted on the downloadpage
     * @param   string updatePath
     * @param   string version
     * @return  boolean
     */
    function verifyUpdate($update, $version) {
        $url          = (string)"https://github.com/s9y/Serendipity/releases/download/$version/serendipity-$version.zip";
        $updatePage   = (string)$this->getPage("https://github.com/s9y/Serendipity/releases/tag/$version");
        $found        = array();
        // grep the checksum
        preg_match("/\(MD5: (.*)\)/", $updatePage, $found);
        $checksum = $found[1];
        $this->show_message('<p class="msg_notice"><span class="icon-attention" aria-hidden="true"></span>Checking MD5 zip file checksum: ' . $checksum . '</p>');
        $check = md5_file($update);
        if (strpos($version, 'beta') !== FALSE) {
            return true;
        }
        if ($check == $checksum) {
            return true;
        } else {
            $this->show_message('<p class="msg_error"><span class="icon-error" aria-hidden="true"></span>Error. Could not verify the update.</p>');
            return false;
        }
    }

    /**
     * get file content of updatePage
     * @param   string url
     * @return  page content
     */
    function getPage($url) {
        $page = file_get_contents($url);
        if (empty($page)) {
            //try it again with curl if fopen was forbidden
            if (function_exists('curl_init')) {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, "20");
                $page = curl_exec($ch);
                curl_close($ch);
            } 
        }
        return $page;
    }

    /**
     * unpack the update to templates_c
     * @param   string version
     * @return  boolean
     */
    function unpackUpdate($version) {
        global $serendipity;

        $update    = (string)$serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version.zip";
        $updateDir = (string)$serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version/";

        // do we already have it?
        if (is_dir($updateDir) && is_file($updateDir . '/serendipity/README.markdown') && is_file($updateDir . '/serendipity/checksums.inc.php')) {
            return true;
        }
        $zip = new ZipArchive;

        if ($zip->open($update) === true) {
            // 1.get all filenames apart from the root 'serendipity'
            $i=1;
            $files = array();
            $name = $zip->getNameIndex($i);
            while (!empty($name)) {
                $files[] = $name;
                $name = $zip->getNameIndex($i);
                $i+=1;
            }
            // 2.extraxt all files to temp
            $zip->extractTo($updateDir);
            $this->show_message('<p class="msg_success"><span class="icon-ok" aria-hidden="true"></span>Extracting the zip in templates_c done</p>');
            $zip->close();
        } else {
            return false;
        }
        return true;
    }

    /**
     * copy the update from templates_c over the existing files
     * @param   string version
     * @return  boolean
     */
    function copyUpdate($version) {
        global $serendipity;

        $update    = (string)$serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version.zip";
        $updateDir = (string)$serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version/";

        $zip = new ZipArchive;

        if ($zip->open($update) === true) {
            // 1.get all filenames apart from the root 'serendipity'
            $i=1;
            $files = array();
            $name = $zip->getNameIndex($i);
            while ( !empty($name) ) {
                $files[] = $name;
                $name = $zip->getNameIndex($i);
                $i+=1;
            }
            $zip->close();
            // 2. copy them over
            foreach ($files as $file) {
                $target = $serendipity['serendipityPath'] . preg_replace('/[^\/]*/', '', $file, 1); # removes leading Serendipity[beta…]
                if (is_dir($updateDir .$file)) {
                    if (!file_exists($target)) {
                        $success = mkdir($target);
                    } else {
                        $success = true;
                    }
                } else {
                    $success = @copy($updateDir . $file, $target);
                }
                if (!$success) {
                    $this->show_message('<p class="msg_error"><span class="icon-error" aria-hidden="true"></span>Error copying file '. $updateDir . $file .' to '. $target .'</p>');
                    return false;
                }
            }
            
        } else {
            return false;
        }
        return true;
    }

    /**
     * check write permissions
     * @param   string updatePath
     * @return  boolean
     */
    function checkWritePermissions($update) {
        global $serendipity;

        $zip = new ZipArchive;

        if ($zip->open($update) === true) {
            $i=0;
            $files = array();
            $name = $zip->getNameIndex($i);
            while (!empty($name)) {
                $files[] = $name;
                $name = $zip->getNameIndex($i);
                $i+=1;
            }
            $zip->close();
            foreach ($files as $file) {
                $target = $serendipity['serendipityPath'] . substr($file, 12);
                if ((!is_writable($target)) && file_exists($target)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * show not writable
     * @param   string updatePath
     * @return  error
     */
    function showNotWriteable($update) {
        global $serendipity;

        $zip = new ZipArchive;

        if ($zip->open($update) === true) {
            $i=0;
            $files = array();
            $name = $zip->getNameIndex($i);
            while (!empty($name)) {
                $files[] = $name;
                $name = $zip->getNameIndex($i);
                $i+=1;
            }
            $zip->close();

            $notWritable = array();

            foreach ($files as $file) {
                $target = $serendipity['serendipityPath'] . substr($file, 12);
                if ((!is_writable($target)) && file_exists($target)) {
                    $notWriteable[] = $target;
                }
            }
        }
        ob_start();
        echo '<p class="msg_error"><span class="icon-error" aria-hidden="true"></span>Unpacking the update failed, because following files were not writeable:</p>';
        echo "<ul>";
        foreach  ($notWriteable as $file) {
            echo "<li>$file</li>";
        }
        echo "</ul>";
        $write_error = ob_get_contents();
        ob_end_clean();
        $this->show_message($write_error);
    }

    /**
     * checks updates checksum file array with updates realfiles
     * @param   string version
     * @return  boolean
     */
    function checkIntegrity($version) {
        global $serendipity;

        $updateDir    = (string)$serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version/";
        $checksumFile = (string)$updateDir . "serendipity/checksums.inc.php";

        if (strpos($version, 'beta') !== FALSE) {
            return true;
        }
        include_once $checksumFile;

        $checksums = $serendipity['checksums_' . $version];

        foreach ($checksums as $file => $checksum) {
            $check = serendipity_FTPChecksum($updateDir . "serendipity/" . $file);
            if ($checksum != $check) {
                return false;
            }
        }
        return true;
    }

    /**
     * checks updates checksum file array with updates realfiles
     * @param   string version
     * @return  error
     */
    function showChecksumErrors($version) {
        global $serendipity;

        $updateDir    = (string)$serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version/";
        $checksumFile = (string)$updateDir . "serendipity/checksums.inc.php";

        include_once $checksumFile;

        $checksums = $serendipity['checksums_' . $version];
        $errors    = array();

        foreach ($checksums as $file => $checksum) {
            $check = serendipity_FTPChecksum($updateDir . "serendipity/" . $file);
            if ($checksum != $check) {
                $errors[] = $updateDir . "serendipity/" . $file;
            }
        }
        ob_start();
        echo '<p class="msg_error"><span class="icon-error" aria-hidden="true"></span>Updating failed, because the integrity-test for the following files failed:</p>';
        echo "<ul>";
        foreach ($errors as $file) {
            echo "<li>$file</li>";
        }
        echo "</ul>";
        $integrity_error = ob_get_contents();
        ob_end_clean();
        $this->show_message($integrity_error);
    }

    /**
     * close the autoupdate progress page
     * @param   bool 007 title ;-)
     */
    function close_page($terminate = false) {
        echo <<<EOS
            </article>
        </div>
    </div>
EOS;
        if ($terminate) {
            echo <<<EOS
    </body>
</html>
EOS;
        }
        if ($terminate) die();
    }

    /**
     * visit the rootpage to manually start the update installer process
     * @param   string update messages
     * @return  refresh page
     */
    function doUpdate() {
        global $serendipity;

        $msg = "Autoupdate successfully done!\\nWe now refresh to Serendipity Installer!\\n"; // escape for js
        $this->show_message('<p class="msg_success"><span class="icon-ok" aria-hidden="true"></span>Autoupdate successfully done - refresh to Serendipity Installer</p>', 'Autoupdate');
        $this->close_page();

        // this is working for me.... is it for you?
        if (die('<script type="text/javascript">alert("'.$msg.'"); window.location = "'.$serendipity['serendipityHTTPPath'].'";</script>'."\n    </body>\n</html>")) {
            return;
        } else {
            if (!headers_sent()) {
                if (header('Location: http://' . $_SERVER['HTTP_HOST'] . $serendipity['serendipityHTTPPath'])) exit;
            } else {
                echo '<script type="text/javascript">';
                echo '    window.location.href="' . $serendipity['serendipityHTTPPath'] . '"';
                echo '</script>'."\n";
                echo '<noscript>';
                echo '    <meta http-equiv="refresh" content="0;url=' . $serendipity['serendipityHTTPPath'] . '" />';
                echo '</noscript>';
                exit;
            }
        }
    }

    /**
     * empty a directory using the Standard PHP Library (SPL) iterator
     * @param   string directory
     */
    function empty_dir($dir) {
        if (!is_dir($dir)) return;
        try {
            $_dir = new RecursiveDirectoryIterator($dir);
            // NOTE: UnexpectedValueException thrown for PHP >= 5.3
            } catch (Exception $e) {
                return;
            }
        $iterator = new RecursiveIteratorIterator($_dir, RecursiveIteratorIterator::CHILD_FIRST);
        //$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                unlink($file->__toString());
            } else {
                @rmdir($file->__toString());
            }
        }
    }

    /**
     * delete all cache-files in cache templates_c to prevent display-errors after update
     * @param   string version
     * @return  boolean
     */
    function cleanTemplatesC($version, $finish) {
        global $serendipity;
        $zip    = (string)$serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version.zip";
        $zipDir = (string)$serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version";

        // leave rm zip untouched here as not causing any errors
        #unlink($zip);// if (unlink($zip)) { else error note?
        #$this->show_message('<p class="msg_success"><span class="icon-ok" aria-hidden="true"></span>Removing the zip file in templates_c done</p>');

        // As trying to remove a directory that php is still using, we use open/closedir($handle) to be sure
        if ($handle = opendir($zipDir)) {
            $this->empty_dir($zipDir);
            $this->show_message('<p class="msg_success"><span class="icon-ok" aria-hidden="true"></span>Removing all files in '.$zipDir.' done</p>');
            closedir($handle);
        }
        if (rmdir($zipDir)) {
            $this->show_message('<p class="msg_success"><span class="icon-ok" aria-hidden="true"></span>Removing the empty directory: '.$zipDir.' done</p>');
        } else {
            $this->show_message('<p class="msg_error"><span class="icon-error" aria-hidden="true"></span>Removing the empty directory: '.$zipDir.' failed!</p>');
        }
        // We clear all compiles smarty template files in templates_c which only leaves the page we are on: /serendipity/templates/default/admin/index.tpl
        if ($finish) {
            // We have to reduce this call() = all tpl files, to clear the blogs template only, to not have the following automated recompile, force the servers memory
            // to get exhausted, when using serendipity_event_gravatar plugin, which can eat up some MB...
            if (method_exists($serendipity['smarty'], 'clearCompiledTemplate')) { // SMARTY 3
                if ($serendipity['smarty']->clearCompiledTemplate(null, $serendipity['template'])) {
                    return true;
                }
            }
            if (method_exists($serendipity['smarty'], 'clear_compiled_tpl')) { // SMARTY 2
                if ($serendipity['smarty']->clear_compiled_tpl(null, $serendipity['template'])) {
                    return true;
                }
            }
        }
    }

    /**
     * debug
     * @param   string msg
     */
    function debugMsg($msg) {
        global $serendipity;

        $this->debug_fp = @fopen ( $serendipity ['serendipityPath'] . 'templates_c/autoupdate.log', 'a' );
        if (!$this->debug_fp) {
            return false;
        }

        if (empty($msg)) {
            fwrite ( $this->debug_fp, "failure \n" );
        } else {
            fwrite ( $this->debug_fp, print_r ( $msg, true ) );
        }
        fclose ( $this->debug_fp );
    }

}

/* vim: set sts=4 ts=4 expandtab : */
