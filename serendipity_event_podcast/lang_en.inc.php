<?php # $Id$

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_PODCAST_NAME',             'Easy Podcasting Plugin');
@define('PLUGIN_PODCAST_DESC',             'Adds "podcasting" capabilities hinzu (RSS enclosure, Video/Sound-Player)');
@define('PLUGIN_PODCAST_EASY',             '<br/><h3>Simple settings:</h3>');
@define('PLUGIN_PODCAST_USEPLAYER',        'Show Player');
@define('PLUGIN_PODCAST_USEPLAYER_DESC',   'Should HTML code for playing podcasts be generated instead of just having the link to the mediafile??');
@define('PLUGIN_PODCAST_AUTOSIZE',         'Adjust players size');
@define('PLUGIN_PODCAST_AUTOSIZE_DESC',    'Tries to detect the size of a video and adjusts the dimension of the player. The width and height settings will be ignored then.');
@define('PLUGIN_PODCAST_WIDTH',            'Width');
@define('PLUGIN_PODCAST_WIDTH_DESC',       'Width of the player to be shown.');
@define('PLUGIN_PODCAST_HEIGHT',           'Height');
@define('PLUGIN_PODCAST_HEIGHT_DESC',      'Height of the player to be shown.');
@define('PLUGIN_PODCAST_ALIGN',            'Alignment');
@define('PLUGIN_PODCAST_ALIGN_DESC',       'Alignment of the player inside of the text.');
@define('PLUGIN_PODCAST_ALIGN_LEFT',       'left');
@define('PLUGIN_PODCAST_ALIGN_RIGHT',      'right');
@define('PLUGIN_PODCAST_ALIGN_CENTER',     'centered');
@define('PLUGIN_PODCAST_ALIGN_NONE',       'nothing');
@define('PLUGIN_PODCAST_FIRSTMEDIAONLY',   'Embed first media only as RSS enclosure');
@define('PLUGIN_PODCAST_FIRSTMEDIAONLY_DESC',   'The RSS specification supports only one enclosure per entry. If this option is enabled, the RSS specification is respected and only the first media file found will be enclosured into the RSS feed.');

@define('PLUGIN_PODCAST_EXTATTRSETTINGS',  '<br/><h3>Podcasting using extended article attributes:</h3>');
@define('PLUGIN_PODCAST_EXTATTR',          'Extended article attributes');
@define('PLUGIN_PODCAST_EXTATTR_DESC',     'You can define, what extended atributes should be interpreted as media file attachments and therfor be added as enclosure to RSS feeds. This has to be a comma seperated list of attribute names. The plugin "Extended article attributes" is needed for this to work.');

@define('PLUGIN_PODCAST_EXTPOS',           'Position of media files found in ext. article attr.');
@define('PLUGIN_PODCAST_EXTPOS_DESC',      'Define how media files found in extended article attributes should be embeded into the article.');
@define('PLUGIN_PODCAST_EXTPOS_NONE',      'Don\'t embed into article');
@define('PLUGIN_PODCAST_EXTPOS_BT',        'Top of the article');
@define('PLUGIN_PODCAST_EXTPOS_BB',        'Below the article');
@define('PLUGIN_PODCAST_EXTPOS_ET',        'Top of ext. article');
@define('PLUGIN_PODCAST_EXTPOS_EB',        'Below of ext. article');

@define('PLUGIN_PODCAST_EXPERT',           '<br/><h3>Expert settings:</h3>');
@define('PLUGIN_PODCAST_EXPERT_HINT',      'HINT: You can customize ANY player with the HTML markup, so you can create a list of your own player variants depending on filetype! Remember that if you once saved the plugin configuration, the static markup will always be used <strong>instead</strong> of what the plugin provides through the <strong>podcast_player.php</strong> file. If you ever want to reset your settings to the default, simply delete all content in the markup textarea and save the plugin.

');

@define('PLUGIN_PODCAST_QTEXT',            'Quicktime extensions');
@define('PLUGIN_PODCAST_QTEXT_DESC',       'Extensions the Quicktimeplayer is able to play.');
@define('PLUGIN_PODCAST_QTEXT_HTML',       'Quicktime player markup');

@define('PLUGIN_PODCAST_WMEXT',            'WindowsMediaPlayer extensions');
@define('PLUGIN_PODCAST_WMEXT_DESC',       'Extensions the Windows Media Player is able to play.');
@define('PLUGIN_PODCAST_WMEXT_HTML',       'Windows Media Player markup');

@define('PLUGIN_PODCAST_MFEXT',            'Flash extensions');
@define('PLUGIN_PODCAST_MFEXT_DESC',       'Extensions the Flash player is able to play.');
@define('PLUGIN_PODCAST_MFEXT_HTML',       'Flash player markup');

@define('PLUGIN_PODCAST_XSPFEXT',          'XSPF flashplayer audio extensions');
@define('PLUGIN_PODCAST_XSPFEXT_DESC',     'Audio extensions the XSFP flashplayer is able to play. Normaly this is only MP3 and XSPF');
@define('PLUGIN_PODCAST_XSPFEXT_HTML',     'XSPF markup');

@define('PLUGIN_PODCAST_AUEXT',            'Quicktime miniplayer audio extensions');
@define('PLUGIN_PODCAST_AUEXT_DESC',       'Audio extensions the quicktime miniplayer is able to play.');
@define('PLUGIN_PODCAST_AUEXT_HTML',       'Quicktime markup.');

@define('PLUGIN_PODCAST_FLVEXT',           'FLV player extensions');
@define('PLUGIN_PODCAST_FLVEXT_DESC',      'Extensions the FLV player is able to play. FLV is a video format supported by Flash players. The benefit of this format is it\'s plattform independance. Normal video formats can be converted by free of cost tools (PC http://www.rivavx.com/index.php?id=483&L=0 und Mac http://www.versiontracker.com/dyn/moreinfo/macosx/15473).');

@define('PLUGIN_PODCAST_FLOWEXT',           'Flowplayer extensions');
@define('PLUGIN_PODCAST_FLOWEXT_DESC',      'Extensions the Flowplayer is able to play. FLV is a video format supported by Flash players. See more on www.flowplayer.org.');
@define('PLUGIN_PODCAST_FLOWEXT_HTML',      'Flowplayer markup');

@define('PLUGIN_PODCAST_HTML5_AUDIO',           'HTML5 audio extensions');
@define('PLUGIN_PODCAST_HTML5_AUDIO_DESC',      'Modern browsers support HTML5 player widgets, native to the browser.');
@define('PLUGIN_PODCAST_HTML5_AUDIO_HTML',      'HTML5 audio markup');

@define('PLUGIN_PODCAST_HTML5_VIDEO',           'HTML5 video extensions');
@define('PLUGIN_PODCAST_HTML5_VIDEO_DESC',      'Modern browsers support HTML5 player widgets, native to the browser.');
@define('PLUGIN_PODCAST_HTML5_VIDEO_HTML',      'HTML5 video markup');

@define('PLUGIN_PODCAST_USECACHE',         'Caching');
@define('PLUGIN_PODCAST_USECACHE_DESC',    'Should caching be enabled for remembering informations about the detected podcasts? With caching media files have to analyzed only once.(Recommended!)');
@define('PLUGIN_PODCAST_JS_OPTIMIZATION',  'JavaScript optimization');
@define('PLUGIN_PODCAST_JS_OPTIMIZATION_DESC','If switched on, extra javascripts are only added to the page if needed. I your entries are cached, this option HAS to be switched off!');

@define('PLUGIN_PODCAST_ASURE_FEEDENC',  	'Ensure feed enclosure');
@define('PLUGIN_PODCAST_ASURE_FEEDEENC_DESC',  'Ensure media is added as "enclosure" to the feed even if not shown in the entry');

@define('PLUGIN_PODCAST_HTTPREL',          'Relativ HTTP path of the plugin');
@define('PLUGIN_PODCAST_HTTPREL_DESC',     'This defines the HTTP path of the plugin relative to the base server url. If you didn\'t change the permalink structure for plugins and your blog is not running in a subdirectory of the server, you are fine with the default setting.');

@define('PLUGIN_PODCAST_USAGE', 
'Scans entries for links showing to media files (Video, Audio) and replaces them with HTML code displaying a player for the media file. This makes it easy creating player objects in the article by just inserting a media file like a video from the media database into the article.
Additional to that the plugin adds the media files to the RSS feed in this way a RSS reader can interpret them as podcasts. (Keyword: Enclosure Tags).');

@define('PLUGIN_PODCAST_USAGE_RSS', '
To get RSS feeds of only specific filetypes, you can access/advertise a feed with a URL like http://' . $serendipity['baseURL'] . '/rss.php?version=2.0&podcast_format=ogg.
This will only put files with an "ogg" extension inside a feed. You can specify multiple formats separated by ",".
'); 

@define('PLUGIN_PODCAST_INSTALL_DESC', 
'<h3>Installation</h3>' .
'<p>The plugin uses the getID3() library that can\'t be shiped with this plugin. You have to download the getid3 archive on your own at ' .
'<a href="http://getid3.org/" target="_blank">getid3.org</a>. <b>Only the 1.x version is supported!</b></p>' .
'<p>Insinde of that archive you will find a subdirectory called getid3. This subdirectory has to be copied into the "bundled-libs" directory of Serenddipity.</p>');
@define('PLUGIN_PODCAST_INSTALL_FLV_DESC', 
'<h3>FLV Player</h3>' .
'<p>The plugin uses the JW-FLV Player to play back FLV video files. Because of different licenses this free player is not bundled with this Plugin, so you <a href="http://www.jeroenwijering.com/?item=Flash_Video_Player" target="_blank">have to download it here</a>.<br />' .
'In the archive you\'ll find the files flvplayer.swf and swfobject.js. Plesae copy them into the subdirectory player of this plugin. If the archive only contains "mediaplayer.*" files, please rename them to "flvplayer.*"</p>');

@define('PLUGIN_PODCAST_ITUNES', 'iTunes XML markup');
@define('PLUGIN_PODCAST_ITUNES_DESC', 'Enter the XML that is put into your RSS-Feed to be shown within iTunes. Requires Serendipity 1.6 and above to work.');

@define('PLUGIN_PODCAST_MERGEMULTI', 'Merge multiple HTML5 player elements');
@define('PLUGIN_PODCAST_DOWNLOADLINK', 'Always add download link');
@define('PLUGIN_PODCAST_DOWNLOADLINK_DESC', 'If disabled, you can add your own customized downloadlink within the player\'s markup.');
