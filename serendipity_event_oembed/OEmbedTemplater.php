<?php
class OEmbedTemplater {
        /* get the right template path - as default in template folder or the fallback plugin folder */
    function fetchTemplate($filename, $oembed, $url) { 
        global $serendipity;

        // Declare the oembed to smarty
        $serendipity['smarty']->assign('oembedurl',$url);
        $serendipity['smarty']->assign('oembed',(array)$oembed);
        $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
        if (!$tfile || $filename == $tfile) { 
            $tfile = dirname(__FILE__) . '/' . $filename;
        }
        $inclusion = $serendipity['smarty']->security_settings[@INCLUDE_ANY];
        $serendipity['smarty']->security_settings[@INCLUDE_ANY] = true;
        // be smarty 3 compat including the serendipity_smarty class wrappers ->fetch and ->display methods and remove changed parameter number 4
        $content = $serendipity['smarty']->fetch('file:'. $tfile);//, false
        $serendipity['smarty']->security_settings[@INCLUDE_ANY] = $inclusion;
        return $content;
    }
}