<?php # 

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_XINHA_NAME',     'Uses XINHA as WYSIWYG editor');
@define('PLUGIN_EVENT_XINHA_DESC',     'Warning! Xinha is experimental. Utilizes the XINHA WYSIWYG editor. Requires Serendipity 0.9. After installation, read the installation guide in the configuration screen for this plugin.');
@define('PLUGIN_EVENT_XINHA_INSTALL', '<br /><br /><strong>Installation guide:</strong><br />
<ul>
<li>Download XINHA from http://trac.xinha.org/wiki/DownloadsPage</li>
<li>Extract it to a "xinha-nightly" directory below ' . dirname(__FILE__) . '</li>
<li>Enter the relative HTTP path to the "xinha-nightly" directory into this plugin configuration.</li>
<li>For most people the relative path is "plugins/serendipity_event_xinha/xinha-nightly/"</li>
<li>Make sure that inside your Serendipity Personal Preferences you have enabled WYSIWYG.</li>
</ul>');

?>
