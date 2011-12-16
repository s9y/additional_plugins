<?php # $Id: lang_en.inc.php,v 1.1 2006/08/16 04:49:12 elf2000 Exp $

/**
 *  @version $Revision: 1.1 $
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_OEMBED_NAME',      'oEmbed Plugin');
@define('PLUGIN_EVENT_OEMBED_DESC',      'oEmbed is a format for allowing an embedded representation of a URL on your blog. It allows blog articles to display embedded content (such as tweets, photos or videos) when a user posts a link to that resource, without having to parse the resource directly.');
/*
@define('PLUGIN_EVENT_OEMBED_EXPAND_TWEETBACKS',      'Expand tweetbacks');
@define('PLUGIN_EVENT_OEMBED_EXPAND_TWEETBACKS_DESC',      'If enabled the plugin will detect tweetbacks and set their content to the oEmbed content delivered from twitter.');
*/
@define('PLUGIN_EVENT_OEMBED_INFO',      '<h3>oEmbed Plugin</h3>' .
'<p>'.
'This plugin expands URLs to pages of known services to a representation of that URL. It shows i.e. the video for a youtube URL or the image instead of a flickr URL.<br/>' .
'The syntax for this plugin is <b>[embed <i>link</i>]</b>. If the link is not supported by the plugin at the moment, it will replace the URL by a link pointing to that URL.<br/>'.
'</p><p>'.
'Please put this plugin at the top of your plugins list, so no other plugin can change this syntax (by adding a href i.e.)'.
'</p><p>'.
'The plugin supports representations of the following link types:%s'.
'</p>');
