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
        $propbag->add('version',       '0.3');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8'
        ));
        $propbag->add('event_hooks',   array('plugin_dashboard_updater' => true,
                                             'backend_sidebar_entries_event_display_update' => true));
        $propbag->add('groups', array('BACKEND_FEATURES'));
        $this->dependencies = array('serendipity_event_dashboard' => 'hold');
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
                    $update = $this->fetchUpdate($nv);
                    if (! empty($update)) {
                        if ($this->verifyUpdate($update, $nv)) {
                            if ($this->checkWritePermissions($update)) {
                                $unpacked = $this->unpackUpdate($nv);
                                if ($unpacked) {
                                    if ($this->checkIntegrity($nv)) {
                                        $copied = $this->copyUpdate($nv);
                                        if ($copied) {
                                            $this->cleanTemplatesC();
                                            $this->doUpdate();
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

    function fetchUpdate($version) {
        global $serendipity;
        $url = "http://prdownloads.sourceforge.net/php-blog/serendipity-$version.zip?download";
        $update  = $serendipity ['serendipityPath'] . 'templates_c/' . "serendipity-$version.zip";
        $done = copy($url, $update ); 
        if (! $done) {
            //try it again with curl if copy was forbidden
            if (function_exists('curl_init')) {
                $out = fopen($file, 'wb');
                $ch = curl_init(); 
                        
                curl_setopt($ch, CURLOPT_FILE, $out); 
                curl_setopt($ch, CURLOPT_HEADER, 0); 
                curl_setopt($ch, CURLOPT_URL, $update); 
                            
                $success = curl_exec($ch);
                if (!$success) {
                    echo '<p class="serendipityAdminMsgError">Downloading update failed</p>';
                    return;
                }
                
            } 
        }
        return $update;
    }

    #compare the md5 of downloaded archive with the md5 posted
    #on the downloadpage
    function verifyUpdate($update, $version) {
        $updatePage = $this->getPage("http://www.s9y.org/12.html");
        #grep the checksum
        $url = "http://prdownloads.sourceforge.net/php-blog/serendipity-$version.zip?download";
        $downloadLink = substr($updatePage, strpos($updatePage, $url), 200);
        $found = array();
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

    #unpack the update to templates_c
    function unpackUpdate($version) {
        global $serendipity;
        $update = $serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version.zip";
        $updateDir = $serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version/";
        $zip = new ZipArchive;
        if ($zip->open($update) === true) {
            #1.get all filenames apart from the root 'serendipity'
            $i=1;
            $files = array();
            $name = $zip->getNameIndex($i);
            while (!empty($name)) {
                $files[] = $name;
                $name = $zip->getNameIndex($i);
                $i+=1;
            }
            #2.extraxt all files to temp
            $zip->extractTo($updateDir);
            $zip->close();
        } else {
            return false;
        }
        return true;
    }

    #copy the update from templates_c over the existing files
    function copyUpdate($version) {
        global $serendipity;
        $update = $serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version.zip";
        $updateDir = $serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version/";
        $zip = new ZipArchive;
        if ($zip->open($update) === true) {
            #1.get all filenames apart from the root 'serendipity'
            $i=1;
            $files = array();
            $name = $zip->getNameIndex($i);
            while (!empty($name)) {
                $files[] = $name;
                $name = $zip->getNameIndex($i);
                $i+=1;
            }
            $zip->close();
            #2. copy them over
            foreach ($files as $file) {
                $target = $serendipity['serendipityPath'] . substr($file, 12);
                if (is_dir($updateDir .$file)) {
                    if (!file_exists($target)) {
                        $success = mkdir($target);
                    } else {
                        $success = true;
                    }
                } else {
                    $success = copy($updateDir . $file, $target);
                }
                if (! $success) {
                    echo "Error copying file to $target";
                    return false;
                }
            }
            
        } else {
            return false;
        }
        return true;
    }

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

    function checkIntegrity($version) {
        global $serendipity;
        $updateDir = $serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version/";
        $checksumFile = $updateDir . "serendipity/checksums.inc.php";
        include_once $checksumFile;
        $checksums = $serendipity['checksums_1.5.5'];
        foreach ($checksums as $file => $checksum) {
            $check = serendipity_FTPChecksum($updateDir . "serendipity/" . $file);
            if ($checksum != $check) {
                return false;
            }
        }
        return true;
    }

    function showChecksumErrors($version) {
        global $serendipity;
        $updateDir = $serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version/";
        $checksumFile = $updateDir . "serendipity/checksums.inc.php";
        include_once $checksumFile;
        $checksums = $serendipity['checksums_1.5.5'];
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

    #visit the rootpage to start the updater
    function doUpdate() {
        global $serendipity;
        echo '<meta http-equiv="REFRESH" content="0;url="'.$serendipity ['serendipityHTTPPath'].'" />';
    }

    #delete all cache-files in cache templates_c to prevent
    #display-errors after update
    function cleanTemplatesC() {
        global $serendipity;
        foreach (glob($serendipity['serendipityPath'] . "templates_c/*") as $file) {
            unlink($file);
        }
    }

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
