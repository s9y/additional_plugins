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
        $propbag->add('author',        'onli');
        $propbag->add('version',       '0.4');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'php'         => '5.1'
        ));
        $propbag->add('event_hooks',   array('plugin_dashboard_updater' => true,
                                             'backend_sidebar_entries_event_display_update' => true));
        $propbag->add('groups', array('BACKEND_FEATURES'));
        $this->dependencies = array('serendipity_event_dashboard' => 'keep');
    }

    function generate_content(&$title) {
        $title = $this->title;
    }


    /*function introspect_config_item($name, &$propbag) {
        
    }*/


    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'plugin_dashboard_updater':
                        $eventData = '<form action="?serendipity[adminModule]=event_display&serendipity[adminAction]=update" method="POST">
                        <input type="hidden" name="serendipity[newVersion]" value="'.$addData.'" />
                        <input type="submit" value="'.PLUGIN_EVENT_AUTOUPDATE_UPDATEBUTTON.'" />
                        </form>';
                    return true;
                    break;

                case 'backend_sidebar_entries_event_display_update':
                    if (! (serendipity_checkPermission('siteConfiguration') || serendipity_checkPermission('blogConfiguration'))) {
                        return;
                    }
                    $nv = $_REQUEST['serendipity']['newVersion'];
                    ini_set('max_execution_time', 180);
                    #ini_set('memory_limit', '-1'); // extending memory_limit may be prevented by suhosin extension. 
                    /*
                       As long scripts are not running within safe_mode they are free to change the memory_limit to whatever value they want. 
                       Suhosin changes this fact and disallows setting the memory_limit to a value greater than the one the script started with, 
                       when this option is left at 0. A value greater than 0 means that Suhosin will disallows scripts setting the memory_limit 
                       to a value above this configured hard limit. This is for example usefull if you want to run the script normaly with a limit 
                       of 16M but image processing scripts may raise it to 20M. 
                       Edit /etc/php5/conf.d/suhosin.ini and add e.g. suhosin.memory_limit = 512M ...
                    */
                    echo '<script type="text/javascript">console.log("Max execution time set to 180 seconds");</script>'."\n";
                    $logmsg = '';
                    $start = microtime(true);
                    $update = $this->fetchUpdate($nv);
                    usleep(1);
                    $time = microtime(true) - $start;
                    $logmsg .= sprintf("In %0.4d seconds run fcn fetchUpdate()\n", $time); // print in readable format 1.2345
                    if (! empty($update)) {
                        $start = microtime(true);
                        if ($this->verifyUpdate($update, $nv)) {
                            usleep(1);
                            $time = microtime(true) - $start;
                            $logmsg .= sprintf("In %0.4d seconds run fcn verifyUpdate()\n", $time);
                            $start = microtime(true);
                            if ($this->checkWritePermissions($update)) {
                                usleep(1);
                                $time = microtime(true) - $start;
                                $logmsg .= sprintf("In %0.4d seconds run fcn checkWritePermissions()\n", $time);
                                $start = microtime(true);
                                $unpacked = $this->unpackUpdate($nv);
                                usleep(1);
                                $time = microtime(true) - $start;
                                $logmsg .= sprintf("In %0.4d seconds run fcn unpackUpdate()\n", $time);
                                if ($unpacked) {
                                    $start = microtime(true);
                                    if ($this->checkIntegrity($nv)) {
                                        usleep(1);
                                        $time = microtime(true) - $start;
                                        $logmsg .= sprintf("In %0.4d seconds run fcn checkIntegrity()\n", $time);
                                        $start = microtime(true);
                                        $copied = $this->copyUpdate($nv);
                                        usleep(1);
                                        $time = microtime(true) - $start;
                                        $logmsg .= sprintf("In %0.4d seconds run fcn copyUpdate()\n", $time);
                                        if ($copied) {
                                            $start = microtime(true);
                                            if (true === $this->cleanTemplatesC($nv) ) {
                                                echo '<script type="text/javascript">console.log("Cleanup download temp done!");</script>'."\n";
                                            }
                                            usleep(1);
                                            $time = microtime(true) - $start;
                                            $logmsg .= sprintf("In %0.4d seconds run fcn cleanTemplatesC()\n", $time);
                                            $this->doUpdate($logmsg);
                                        } else {
                                             echo '<p class="serendipityAdminMsgError">Copying the files for the update failed</p>';
                                        }
                                     } else {
                                        $this->showChecksumErrors($nv);
                                        echo '<form action="?serendipity[adminModule]=event_display&serendipity[adminAction]=update" method="POST">
                                             <input type="hidden" name="serendipity[newVersion]" value="'.$nv.'" />
                                             <input type="submit" value="'.PLUGIN_EVENT_AUTOUPDATE_UPDATEBUTTON.'" />
                                             </form>';
                                    }
                                } else {
                                    echo '<p class="serendipityAdminMsgError">Unpacking the update failed</p>';
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
     * @param   string version
     * @return  string updatepath
     */
    function fetchUpdate($version) {
        global $serendipity;
        $url     = (string)"http://prdownloads.sourceforge.net/php-blog/serendipity-$version.zip?download";
        $update  = (string)$serendipity ['serendipityPath'] . 'templates_c/' . "serendipity-$version.zip";
        // do we already have it?
        $done = !file_exists($update) ? @copy($url, $update ) : true;
        if (! $done) {
            //try it again with curl if copy was forbidden
            if (function_exists('curl_init')) {
                $out = @fopen($file, 'wb');
                $ch = @curl_init();
                        
                @curl_setopt($ch, CURLOPT_FILE, $out);
                @curl_setopt($ch, CURLOPT_HEADER, 0);
                @curl_setopt($ch, CURLOPT_URL, $update);
                            
                $success = @curl_exec($ch);
                if ( !$success ) {
                    echo '<p class="serendipityAdminMsgError">Downloading update failed</p>';
                    return;
                }
                
            } 
        }
        echo '<script type="text/javascript">console.log("Fetch download to templates_c done");</script>'."\n";
        return $update;
    }

    /**
     * compare the md5 of downloaded archive with the md5 posted on the downloadpage
     * @param   string updatePath
     * @param   string version
     * @return  boolean
     */
    function verifyUpdate($update, $version) {
        $url        = (string)"http://prdownloads.sourceforge.net/php-blog/serendipity-$version.zip?download";
        $updatePage = (string)$this->getPage("http://www.s9y.org/12.html");
        $downloadLink = substr($updatePage, strpos($updatePage, $url), 200);
        $found = array();
        // grep the checksum
        preg_match("/\(MD5: (.*)\)/", $downloadLink, $found);
        $checksum = $found[1];
        $check = md5_file($update);
        if ($check == $checksum) {
            return true;
        } else {
            echo '<p class="serendipityAdminMsgError">Error. Could not verify the update.</p>';
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
        if ( empty($page) ) {
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
        if (is_dir($updateDir) && is_file($updateDir . '/serendipity/README.markdown')) {
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
            echo '<script type="text/javascript">console.log("Extracting the zip in templates_c done");</script>'."\n";
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
                $target = $serendipity['serendipityPath'] . substr($file, 12);
                if (is_dir($updateDir .$file)) {
                    if (!file_exists($target)) {
                        $success = mkdir($target);
                    } else {
                        $success = true;
                    }
                } else {
                    $success = @copy($updateDir . $file, $target);
                }
                if ( !$success ) {
                    echo "Error copying file to $target";
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
            
            foreach ($files as $file) {
                $target = $serendipity['serendipityPath'] . substr($file, 12);
                if ( (! is_writable($target)) && file_exists($target) ) {
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

            $notWritable = array();
            
            foreach ($files as $file) {
                $target = $serendipity['serendipityPath'] . substr($file, 12);
                if ((! is_writable($target)) && file_exists($target) ) {
                    $notWriteable[] = $target;
                }
            }
        }
        echo '<p class="serendipityAdminMsgError">Unpacking the update failed, because following files were not writeable:</p>';
        echo "<ul>";
        foreach  ($notWriteable as $file) {
            echo "<li>$file</li>";
        }
        echo "</ul>";
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
        $errors = array();
        foreach ($checksums as $file => $checksum) {
            $check = serendipity_FTPChecksum($updateDir . "serendipity/" . $file);
            if ($checksum != $check) {
                $errors[] = $updateDir . "serendipity/" . $file;
            }
        }
        echo '<p class="serendipityAdminMsgError">Updating failed, because the integrity-test for the following files failed:</p>';
        echo "<ul>";
        foreach ($errors as $file) {
            echo "<li>$file</li>";
        }
        echo "</ul>";
    }

    /**
     * visit the rootpage to manually start the update process
     * @param   string update messages
     * @return  refresh page
     */
    function doUpdate($alertprogress) {
        global $serendipity;
        echo '<script type="text/javascript">console.log("Update done - refresh to serendipityHTTPPath");</script>'."\n";
        $msg = "Update successfully done!\n\n$alertprogress\nWe now refresh to serendipityHTTPPath!";
        #echo "<script type='text/javascript'>alert('".mysql_real_escape_string($msg)."'); window.location = '".$serendipity['serendipityHTTPPath']."';</script>\n";

        // Well, trying to find some small stop/proceed/exit execution... I came up with this. 
        // And it is working for me.... is it for you?
        if(die("<script type='text/javascript'>alert('".mysql_real_escape_string($msg)."'); window.location = '".$serendipity['serendipityHTTPPath']."';</script>\n")) {
            return;
        } else {
            /*  This msg popup before refresh e.g. looks like:

                Update successfully done!

                In 0 seconds run fcn fetchUpdate()
                In 0 seconds run fcn verifyUpdate()
                In 3 seconds run fcn checkWritePermissions()
                In 17 seconds run fcn unpackUpdate()
                In 7 seconds run fcn checkIntegrity()
                In 28 seconds run fcn copyUpdate()
                In 9 seconds run fcn cleanTemplatesC()

                - We now refresh to serendipityHTTPPath
            */
            /*
                ToDo: make this happen in realtime via a JS GUI?
                ToDo: optimize copyUpdate time?
            */
            if(!headers_sent()) {
                if(header('Location: http://' . $_SERVER['HTTP_HOST'] . $serendipity['serendipityHTTPPath'])) exit;
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
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                unlink($file->__toString());
            } else {
                rmdir($file->__toString());
            }
        }
    }

    /**
     * delete all cache-files in cache templates_c to prevent display-errors after update
     * @param   string version
     * @return  boolean
     */
    function cleanTemplatesC($version) {
        global $serendipity;
        $zip    = (string)$serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version.zip";
        $zipDir = (string)$serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version";
        // leave rm zip untouched here as not causing any errors
        #unlink($zip);
        #echo '<script type="text/javascript">console.log("Removing the zip file in templates_c done");</script>'."\n";

        // As trying to remove a directory that php is still using, we use open/closedir($handle) to be sure
        if( $handle = opendir($zipDir) ) {
            $this->empty_dir($zipDir);
            echo '<script type="text/javascript">console.log("Removing all files in '.$zipDir.' done");</script>'."\n";
            closedir($handle);
        }
        rmdir($zipDir);
        echo '<script type="text/javascript">console.log("Removing the empty directory: '.$zipDir.' done");</script>'."\n";

        /* We clear all compiles smarty template files in templates_c which only leaves the page we are on: /serendipity/templates/default/admin/index.tpl */
        if(method_exists($serendipity['smarty'], 'clearCompiledTemplate')) { // SMARTY 3
            if($serendipity['smarty']->clearCompiledTemplate()) {
                return true;
            }
        }
        if(method_exists($serendipity['smarty'], 'clear_compiled_tpl')) { // SMARTY 2
            if($serendipity['smarty']->clear_compiled_tpl()) {
                return true;
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
        if (! $this->debug_fp) {
            return false;
        }

        if (empty ( $msg )) {
            fwrite ( $this->debug_fp, "failure \n" );
        } else {
            fwrite ( $this->debug_fp, print_r ( $msg, true ) );
        }
        fclose ( $this->debug_fp );
    }

}

/* vim: set sts=4 ts=4 expandtab : */
