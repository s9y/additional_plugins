<?php
/*
 * Created on 26.06.2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
class TwitterPluginFileAccess {

    static function get_file_from_template( $filename, $plugin_rel_url ) {
        $filenamebase = basename($filename);
        $tfile = serendipity_getTemplateFile($filenamebase, 'serendipityPath');
        if (!$tfile || $tfile == $filenamebase) {
            return $plugin_rel_url . '/' .$filename;
        }
        else {
            return $tfile;
        }
    }

    static function get_permaplugin_path() {
        global $serendipity;

        // Get configured plugin path:         
        $pluginPath = 'plugin';
        if (isset($serendipity['permalinkPluginPath'])){
            $pluginPath = $serendipity['permalinkPluginPath'];
        }
        
        return $pluginPath;
        
    }

    /**
     * Returns the s9y cache directory
     */
    static function get_cache_prefix(){
        global $serendipity;
        return $serendipity['serendipityPath'] . PATH_SMARTY_COMPILE . '/serendipity_event_twitter';
    }
    
    static function get_lock($lock, $maxlock_sec=300) {
        $lockfname = TwitterPluginFileAccess::get_cache_prefix() . "_$lock.lock";
        if(file_exists($lockfname) && ((time() - filemtime($lockfname)) < $maxlock_sec)) {
            // The resource is locked. You can either move on to next tasks or wait and check periodically in a loop
            return false;
        } else {
            @touch($lockfname);
            return true; 
        }
    }        

    static function free_lock($lock) {
        $lockfname = TwitterPluginFileAccess::get_cache_prefix() . "_$lock.lock";
        @unlink($lockfname); // Release the lock
    }        


} 
?>
