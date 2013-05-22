<?php # $Id$

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_FCKEDITOR_NAME',     'Uses FCKeditor as WYSIWYG editor');
@define('PLUGIN_EVENT_FCKEDITOR_DESC',     'Utilizes the FCKeditor WYSIWYG editor. Note: This is the old, but still developed version, of the famous new CKEditor package. This plugin does not support other Serendipity Plugin "hook-in buttons"! After installation, read the installation guide in the configuration screen for this plugin.');
@define('PLUGIN_EVENT_FCKEDITOR_UPDATE',   '<h2>Upgrade Guide:</h2>
<ul style="line-height: 1.6">
<li>To update this Plugin from a version prior v.0.8 and some already installed FCKeditor version 2.x beneath v.2.6(.10), backup your custom settings (if any) and purge the old <em style="color: #777">fckeditor/</em> directory. Then follow the "Installation Guide".</li>
</ul>');
@define('PLUGIN_EVENT_FCKEDITOR_INSTALL',   '<h2>Installation Guide:</h2>
<ul style="line-height: 1.6">
<li><strong>Download</strong> FCKeditor v2.6.10+ from <a href="http://sourceforge.net/projects/fckeditor/" target="_blank">sourceforge.net/projects/fckeditor/</a></li>
<li><strong>Extract</strong> it to an automatic set <em style="color: #777">"fckeditor"</em> directory below<br><em style="color: #777">' . dirname(__FILE__) . '</em></li>
<li><strong>Enter</strong> the relative HTTP path to the <em style="color: #777">"fckeditor"</em> directory into this plugins configuration.<br>For most people the relative path is here <em style="color: #777">"plugins/serendipity_event_fckeditor/fckeditor/"</em></li>
<li><strong>Enable</strong> the WYSIWYG-Mode inside your Serendipity Personal Preferences</li>
</ul>');
@define('PLUGIN_EVENT_FCKEDITOR_CONFIG',   '<h2>Configuration Guide:</h2>
<ul style="line-height: 1.6">
<li>If you want more functionality like filemanager, table operations etc, <span style="text-decoration: line-through; color: #777 !important">you can overwrite the fckconfig.js file in the fckeditor directory with the one supplied.</span> [Note: Do not do this any more, if not in great distress. This last was for the previous versions.]</li>
<ul>
	<li>then go to <em style="color: #777">serendipity_event_fckeditor/fckeditor/editor/filemanager/connectors/php/config.php</em></li>
	<li>and change the variable <strong>$Config["Enabled"]</strong> to <em style="color: #777">true</em> and change <strong>$Config["UserFilesPath"]</strong> to <em style="color: #777">"/uploads/"</em>, which is the blogs relative path to Serendipity uploads directory and also <strong>$Config[\'UserFilesAbsolutePath\']</strong> to <em style="color: #777">"/var/www/.?./uploads/"</em>, which is the same target, but needs the full relative system path.</li>
	<li><u>Note:</u> The both path directives need the real path names on system (not the already lowersized Blogurls Browser Address)!</li>
</ul>
<li>There are 3 different skins included in FCKeditor, default, office2003 and silver. They can be configured in fckeditor/fckconfig.js file.</li>
	<ul><li>Change the variable <strong>FCKConfig.SkinPath = FCKConfig.BasePath + "skins/default/" ;</strong> and replace <em style="color: #777">default</em> with <em style="color: #777">office2003</em> or <em style="color: #777">simple</em></li></ul>
</ul>');

?>
