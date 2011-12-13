<?php # $Id: lang_en.inc.php,v 1.1 2005/11/18 07:36:08 elf2000 Exp $

/**
 *  @version $Revision: 1.1 $
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define("PLUGIN_BACKEND_TITLE", "Show entries via JavaScript");
@define("PLUGIN_BACKEND_DESC", "Provides javascript output of recent entries for inclusion on other, extern websites. (see the README in the plugins directory!)");
@define('PLUGIN_BACKEND_BACKENDURL', 'Backend URL');
@define('PLUGIN_BACKEND_BACKENDURL_BLAHBLAH', 'The URL to the backend when called from an extern website (http://your.blog.com/' . ($serendipity['rewrite'] == "none" ? $serendipity['indexFile'] . "?/" : "") . 'plugin/[BACKEND_URL]).');

?>
