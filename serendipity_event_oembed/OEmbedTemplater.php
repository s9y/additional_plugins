<?php
class OEmbedTemplater {

	/* get the right template (s9y template path, then plugin path) and expand it */
    static function fetchTemplate($filename, $oembed, $url) { 
        global $serendipity;

        if (!is_object($serendipity['smarty']))
            serendipity_smarty_init();
        
        // Declare the oembed to smarty
        $serendipity['smarty']->assign('oembedurl',$url);
        $serendipity['smarty']->assign('oembed',(array)$oembed);
        $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
        if (!$tfile || $filename == $tfile) { 
            $tfile = dirname(__FILE__) . '/' . $filename;
        }
        
        $inclusion = $serendipity['smarty']->security_settings[@INCLUDE_ANY];
        $serendipity['smarty']->security_settings[@INCLUDE_ANY] = true;

        if (version_compare($serendipity['version'], '1.7-alpha1')>=0) {
            $serendipity['smarty']->disableSecurity();
        }
        /* in earlier versions this is not needed.
        else {
            $serendipity['smarty']->security = false;
        }
        */

        // be smarty 3 compat including the serendipity_smarty class wrappers ->fetch and ->display methods and remove changed parameter number 4
        $content = @$serendipity['smarty']->fetch('file:'. $tfile);//, false
        
        $serendipity['smarty']->security_settings[@INCLUDE_ANY] = $inclusion;
        
        return $content;
    }
}