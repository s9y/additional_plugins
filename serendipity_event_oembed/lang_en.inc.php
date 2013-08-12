<?php # 

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_OEMBED_NAME',      'oEmbed Plugin');
@define('PLUGIN_EVENT_OEMBED_DESC',      'oEmbed is a format for allowing an embedded representation of a URL on your blog. It allows blog articles to display embedded content (such as tweets, photos or videos) when a user posts a link to that resource, without having to parse the resource directly.');

@define('PLUGIN_EVENT_OEMBED_MAXWIDTH',      'Max width of replacements');
@define('PLUGIN_EVENT_OEMBED_MAXWIDTH_DESC', 'This is the max width the service should produce when providing a replacement. Not all services supports this but most.');
@define('PLUGIN_EVENT_OEMBED_MAXHEIGHT',     'Max height of replacements');
@define('PLUGIN_EVENT_OEMBED_MAXHEIGHT_DESC','This is the max height the service should produce when providing a replacement. Not all services supports this but most.');

@define('PLUGIN_EVENT_OEMBED_GENERIC_SERVICE',   'Generic oEmbed provider');
@define('PLUGIN_EVENT_OEMBED_GENERIC_SERVICE_DESC','If the plugin is not able to resolve an URL because it is unknown yet, you may let it fall back to a "generic provider". These services implements oEmbed for a huge amount of services not having oEmbed. You have two choices: oohembed.com, a former free service bought by embedly and with a very limited API rate now. embed.ly is a very well maintained service for many oEmbed services (see http://embed.ly/providers), but it needs an API key to be used.');
@define('PLUGIN_EVENT_OEMBED_SERVICE_NONE',      'No generic provider');
@define('PLUGIN_EVENT_OEMBED_SERVICE_OOHEMBED',  'oohembed (free but limited)');
@define('PLUGIN_EVENT_OEMBED_SERVICE_EMBEDLY',   'embed.ly (apikey needed)');
@define('PLUGIN_EVENT_OEMBED_EMBEDLY_APIKEY',     'embed.ly API key');
@define('PLUGIN_EVENT_OEMBED_EMBEDLY_APIKEY_DESC','embed.ly needs an API key to be used. The free account allows 10k calls per month atm, what should be enough even for heavy used blogs, as the results are cached localy and fetched only once per URL. You can register for your free account at http://app.embed.ly/pricing/free');

@define('PLUGIN_EVENT_OEMBED_INFO',      '<h3>oEmbed Plugin</h3>' .
'<p>'.
'This plugin expands URLs to pages of known services to a representation of that URL. It shows i.e. the video for a youtube URL or the image instead of a flickr URL.<br/>' .
'The syntax of this plugin is <b>[embed <i>link</i>]</b> (or <b>[e <i>link</i>]</b> if you like it shorter).<br/>'.
'If the link is not supported by the plugin at the moment, it will replace the URL by a link pointing to that URL.<br/>'.
'</p><p>'.
'Please put this plugin at the top of your plugins list, so no other plugin can change this syntax (by adding a href i.e.)'.
'</p>');

@define('PLUGIN_EVENT_OEMBED_SUPPORTED',      '<p>'.
'The plugin supports representations of the following link types without the need of the generic fallback:%s'.
'</p>');

// new entries 2012-02-03
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO',              'Audioboo player');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_DESC',     	   'Audioboo supports 3 different players (see http://audioboo.fm/boos/649785-ein-erster-testboo.embed?labs=1). Choose the one you like most.');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_STANDARD',     'standard player');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_FULLFEATURED', 'full-featured (requires JavaScript)');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_WORDPRESS',    'wordpress.com player (requires Flash)');
