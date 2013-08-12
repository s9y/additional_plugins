<?php # 

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_GETID3', 'getID3() support for fetching media properties');
@define('PLUGIN_GETID3_DESC', 'Uses the getID3() library to fetch extended media properties for movies/audio files. getID3() itself is not distributed with this plugin.');
@define('PLUGIN_GETID3_INSTALL', 'getID3() itself is not distributed with this plugin, so you need to download those files manually from http://getid3.org/. Extract the files into your serendipity_event_getid3 or (preferred) bundled-libs directory.');

@define('PLUGIN_GETID3_INSTALL_DESC', 
'<h3>Installation</h3>' .
'<p>The getID3() library itself is not distributed with this plugin, so you need to download those files manually from' .
'<a href="http://getid3.org/" target="_blank">getid3.org</a>. <b>Only version 1.x is supported!</b></p>' .
'<p>You will find a subdirectory getid3 inside of the distribution archive. Please copy this directory into the Serendipity directory "bundled-libs".</p>');

@define('PLUGIN_GETID3_LIBNOTFOUND',    'GetID3 was neither found in the bundled-lib nor the plugin directory!'); 
@define('PLUGIN_GETID3_LIBFOUNDBUNDLED','GetID3 was found in the bundled-libs subdirectory.'); 
@define('PLUGIN_GETID3_LIBFOUNDPLUGIN', 'GetID3 was found in the plugin directory.'); 
?>