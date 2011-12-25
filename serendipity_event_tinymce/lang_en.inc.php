<?php # $Id$

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_TINYMCE_NAME',            'Uses TinyMCE as WYSIWYG editor');
@define('PLUGIN_EVENT_TINYMCE_DESC',            'Utilizes the TinyMCE WYSIWYG editor. Requires Serendipity 0.9 or later. After installation, read the installation guide in the configuration screen for this plugin.');
@define('PLUGIN_EVENT_TINYMCE_ARTICLE_ONLY',    'Use in articles only');
@define('PLUGIN_EVENT_TINYMCE_ARTICLE_ONLY_DESC','If switched on, TinyMCE will only inserted as article editor, not as editor in plugins.');
@define('PLUGIN_EVENT_TINYMCE_IMANAGER',        'Enable use of the iManager tool?');
@define('PLUGIN_EVENT_TINYMCE_IMANAGER_DESC',   'iManager is a flexible tool for image mainteance (requires GD). See http://www.j-cons.com/ and read the supplied installation documents to complete the installation of that tool.');
@define('PLUGIN_EVENT_TINYMCE_PLUGINS',         'Additional TinyMCE plugins.');
@define('PLUGIN_EVENT_TINYMCE_PLUGINS_DESC',    'Supply the names of the directories (separated by commas) within the TinyMCE plugins directory for installation. (Be sure to read the supplied installation documents to complete the installation of each tool). What plugins were delivered with TinyMCE can be read here: http://wiki.moxiecode.com/index.php/TinyMCE:Plugins');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS1',        'Buttonbar 1');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS1_DESC',   'Define the buttons you want to see in buttonbar 1. A space defines an empty bar, an empty input reloads the default plugin defintion again. Buttons supported by TinyMCE are shown here: http://wiki.moxiecode.com/index.php/TinyMCE:Control_reference');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS2',        'Buttonbar 2');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS2_DESC',   'Define the buttons you want to see in buttonbar 2.');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS3',        'Buttonbar 3');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS3_DESC',   'Define the buttons you want to see in buttonbar 3.');
@define('PLUGIN_EVENT_TINYMCE_SPELLING',        'Mozilla spellchecking');
@define('PLUGIN_EVENT_TINYMCE_SPELLING_DESC',   'TinyMCE is able to integrate the spellchecking of Firefox.');
@define('PLUGIN_EVENT_TINYMCE_RELURLS',         'Convert to relative URLs');
@define('PLUGIN_EVENT_TINYMCE_RELURLS_DESC',    'TinyMCE converts local URLs to relative URLs by default. "http://yourblog.com/test.html" will become "/test.html". Relative URLs are important in case the domain of your blog changes (or your blog is accessed by more than one domain). But relative URLs could produce problems in some blogs.');
@define('PLUGIN_EVENT_TINYMCE_VFYHTML',         'Veryfy HTML');
@define('PLUGIN_EVENT_TINYMCE_VFYHTML_DESC',    'TinyMCE tries to transform the article code into valid HTML code. It will delete tags, that are not part of the HTML specification. I.e complete YouTube codes are often deleted after loading or saving an article. This option switches on and off this behavior.');
@define('PLUGIN_EVENT_TINYMCE_CLEANUP',         'Clean up code');
@define('PLUGIN_EVENT_TINYMCE_CLEANUP_DESC',    'TinyMCE cleans up the article code while loading and saving. If you disable this option, the HTML code of your article stays untouched by TinyMCE, but you have to check the code on your own to be valid. Switching off the option [' . PLUGIN_EVENT_TINYMCE_VFYHTML . '] is the better solution in most cases.');
@define('PLUGIN_EVENT_TINYMCE_HTTPREL',         'Relativ HTTP path of the plugin');
@define('PLUGIN_EVENT_TINYMCE_HTTPREL_DESC',    'This defines the HTTP path of the plugin relative to the base server url. If you didn\'t change the permalink structure for plugins and your blog is not running in a subdirectory of the server, you are fine with the default setting.');
@define('PLUGIN_EVENT_TINYMCE_INSTALL',         '<br /><br /><strong>Installation guide:</strong><br />
<ul>
<li><a href="http://tinymce.moxiecode.com/download.php" target="_blank">Download TinyMCE, TinyMCE compressor</a> (Only TinyMCE 2.0 or later).</li>
<li><b>TinyMCE</b>: Extract to a "tinymce" directory below ' . dirname(__FILE__) . '.</li>
<li>TinyMCE compressor extract to a "tinymce/jscripts/tiny_mce/" directory below ' . dirname(__FILE__) . ' (Only TinyMCE 2.0 or later).</li>
<li>Optionally download iManager (requires PHP GD support):
<ul>
<li>Extract iManager to a "tinymce/jscripts/tiny_mce/plugins/imanager" directory</li>
<li>Edit the "tinymce/jscripts/tiny_mce/plugins/imanager/config/config.inc.php" file</li>
<li>Adjust the values for $cfg["ilibs"] and $cfg["ilibs_dir"]. Fill in your relative HTTP path to your Serendipity Upload directory: "' . $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . '"</li>
<li>Make sure the paths imanager/scripts/phpThumb/cache and imanager/temp have sufficient write privileges (777)</li>
</ul>
</li>
<li>Enter the relative HTTP path to the plugin directory into this plugin configuration.</li>
<li>Make sure that inside your Serendipity Personal Preferences you have enabled WYSIWYG.</li>
</ul>');

?>
