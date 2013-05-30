<?php # $Id$

/**
* @version $Revision$
* @author Translator Name <yourmail@example.com>
* EN-Revision: Revision of lang_en.inc.php
*/
@define('PLUGIN_EVENT_CKEDITOR_NAME', 'CKEditor');
@define('PLUGIN_EVENT_CKEDITOR_DESC', 'Uses CKEditor as the default WYSIWYG editor. This currently is the state-of-the-art Editor itself. Usage: Recommended! After installation, go to the configuration screen of this plugin for further instructions.');
@define('PLUGIN_EVENT_CKEDITOR_INSTALL', '<h2>Installation</h2>
<ol style="line-height: 1.6">
<li>Enter the relative HTTP path to the <em>"ckeditor"</em> directory in plugin configuration.
    <div><strong>Note:</strong> in most installations, this path is <em>"plugins/serendipity_event_ckeditor/ckeditor/"</em></div>
</li>
<li>Enter the full HTTP path to s9y <em>"plugins"</em> directory (with trailing slash) in plugin configuration.
    <div><strong>Note:</strong> in most installations, this path is <em>"' . $serendipity['serendipityHTTPPath'] . 'plugins/"</em></div>
</li>
<li>To allow other plugins to use or hook into the editor, place this (CKEditor) plugin near the end of your plugin list.</li>
<li>Make sure to enable WYSIWYG mode in your personal preferences.</li>
</ol>
<h3>Plugin includes</h3>
<ul>
<li>CKEditor 4.1.1 (revision 5a2a7e3, standard package, 2013-05-01)</li>
<li>KCFinder 2.52-dev (git package, 2013-05-04)</li>
</ul>

<h3>Upgrading</h3>
<p>This Plugin will provide Updates via Spartacus from time to time.<hr>
If you - in follow - ever need to manually upgrade the delivered CKEditor package to a personal package (*), please:
<ol style="line-height: 1.6">
<li><a href="http://ckeditor.com/download" target="_blank">Download CKEditor</a></li>
<li>Extract to: <em>' . dirname(__FILE__) . '</em> (should create <em>"ckeditor"</em> subdirectory)</li>
</ol>
(*) <em><strong>Note:</strong> This will disable (overwrite) the KCFinder\'s integration added to the end of ckeditor/config.js file: <a style="border:0; text-decoration: none;" href="#" onClick="showConfig(\'el1\'); return false" title="TOGGLE_OPTION"><img src="'.serendipity_getTemplateFile('img/plus.png').'" id="optionel1" alt="+/-" border="0">&nbsp;TOGGLE_OPTION</a></em>
<div id="el1" style="margin-top: 0.5em; border: 1px solid #BBB;background-color: #EEE; padding: 0.5em">
<pre>
/* KCFinder integration - 2013-05-04 */
CKEDITOR.editorConfig = function(config) {
   config.filebrowserBrowseUrl = CKEDITOR_BASEPATH + \'../kcfinder/browse.php?type=files\';
   config.filebrowserImageBrowseUrl = CKEDITOR_BASEPATH + \'../kcfinder/browse.php?type=images\';
   config.filebrowserFlashBrowseUrl = CKEDITOR_BASEPATH + \'../kcfinder/browse.php?type=flash\';
   config.filebrowserUploadUrl = CKEDITOR_BASEPATH + \'../kcfinder/upload.php?type=files\';
   config.filebrowserImageUploadUrl = CKEDITOR_BASEPATH + \'../kcfinder/upload.php?type=images\';
   config.filebrowserFlashUploadUrl = CKEDITOR_BASEPATH + \'../kcfinder/upload.php?type=flash\';
};
</pre>
</div><script type="text/javascript" language="JavaScript">document.getElementById("el1").style.display = "none";</script>
</p>');
@define('PLUGIN_EVENT_CKEDITOR_CONFIG', '');
@define('PLUGIN_EVENT_CKEDITOR_INSTALL_PLUGPATH', 'HTTP path to s9y plugins directory');
@define('PLUGIN_EVENT_CKEDITOR_TBLB_OPTION', 'Use default 2-liner toolbar-group linebreak');

?>