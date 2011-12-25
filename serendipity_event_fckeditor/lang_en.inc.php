<?php # $Id$

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_FCKEDITOR_NAME',     'Uses FCKeditor as WYSIWYG editor');
@define('PLUGIN_EVENT_FCKEDITOR_DESC',     'Utilizes the FCKeditor WYSIWYG editor. Requires Serendipity 0.9. After installation, read the installation guide in the configuration screen for this plugin.');
@define('PLUGIN_EVENT_FCKEDITOR_INSTALL', '<br /><br /><strong>Installation guide:</strong><br />
<ul>
<li>Download FCKeditor v2.1+ from http://www.fckeditor.net/</li>
<li>Extract it to a "FCKeditor" directory below ' . dirname(__FILE__) . '</li>
<li>Enter the relative HTTP path to the "FCKeditor" directory into this plugin configuration.</li>
<li>For some people the relative path is "plugins/serendipity_event_fckeditor/fckeditor/"</li>
<li>Make sure that inside your Serendipity Personal Preferences you have enabled WYSIWYG.</li>
</ul>');
@define('PLUGIN_EVENT_FCKEDITOR_CONFIG', '<br /><br /><strong>Configuration guide:</strong><br />
<ul>
<li>If you want more functionality like filemanager, table operations etc you can overwrite the fckconfig.js file in the fckeditor directory with the one supplied.</li>
<ul>
	<li>then go to serendipity_event_fckeditor/fckeditor/editor/filemanager/browser/default/connectors/php/config.php</li>
	<li>and change the variable $Config["Enabled"] = true; and change $Config["UserFilesPath"] = "/uploads/";</li>
	<li>then go to serendipity_event_fckeditor/fckeditor/editor/filemanager/upload/php/config.php</li>
	<li>and do the same as before</li>
</ul>
<li>There are 3 different skins included in FCKeditor, default, office2003 and silver. They can be configured in fckconfig.js file.</li>
	<ul><li>Just change this variable FCKConfig.SkinPath = FCKConfig.BasePath + "skins/default/" ;. replace default with office2003 or simple</li></ul>

</ul>');

?>
