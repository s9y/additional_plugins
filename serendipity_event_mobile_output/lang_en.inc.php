<?php # 

/**
 *  @version $Revision$
 *  @author Pelle Boese <p.boese@gmail.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_MOBILE_OUTPUT_NAME', 'Markup: Mobile Output');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_DESC', 'This plugin handles mobile devices and outputs optimized XHTML MP markup if it detects a mobile browser and a specially optimized site for iPhone and iPod Touch. It also scales images to fit the display size.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_ENABLE_PLUGIN_NAME', 'Enable Plugin');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_ENABLE_PLUGIN_DESC', 'Enable the mobile output plugin for your blog');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_MOBILE_TEMPLATE_NAME', 'Mobile template');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_MOBILE_TEMPLATE_DESC', 'The name of the template for mobile output. Default is "xhtml_mp" which comes with the plugin.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_IPHONE_TEMPLATE_NAME', 'iPhone template');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_IPHONE_TEMPLATE_DESC', 'The name of the template for iPhonoes. Default is "iphone,app" which comes with the plugin.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_IMAGES_NAME', 'Display Images');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_IMAGES_DESC', 'Display Images within entries');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_SCALE_IMAGE_WIDTH_NAME', 'Maximum image width');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SCALE_IMAGE_WIDTH_DESC', 'Scale images to X pixels width. Set to 0 to disable. Requires GD!');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_NAME', 'Redirect');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_DESC', 'Redirect mobile devices to another host (see below)');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_URL_NAME', 'Redirect host');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_URL_DESC', 'Redirect mobile devices to a specific host (e.g. "m.yourblog.com"). Can be another host with the same serendipity instance running, e.g. for SEO purposes.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_STICKY_HOST_NAME', 'Mobile host');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_STICKY_HOST_DESC', 'This host will always return the mobilized version. Leave empty to disable.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_WURFL_NAME', 'Use WURFL');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_WURFL_DESC', 'With this option enabled all images are scaled down to perfectly fit the screen of any mobile device. This uses an optimized version of the WURFL UAP (http://wurfl.sourceforge.net/). An up to date version of the optimized wurfl.xml file can be found at http://c.seo-mobile.de/. This file is still quite big and thus we\'re caching it. The cache consumes about 50mb of disk space. If you downloaded a new wurfl.xml, point your browser to '.$serendipity['baseURL'].'plugins/serendipity_event_mobile_output/wurfl/update_cache.php to recreate the cache. This option uses the maximum image width set above as fallback. Might generate some load on high traffic sites! IMPORTANT: the folder "wurfl/data/" must be writable for the webserver in order to create the cache!');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_CATEGORIES_NAME', 'Display categories');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_CATEGORIES_DESC', 'Show all categories within the footer navigation and add accesskey functionality. If more than 9 categories exist, only the first 9 will get an accesskey attribute.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_TAGS_NAME', 'Remove HTML tags');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_TAGS_DESC', 'A comma seperated list of tags to remove, e.g. script,object,embed...');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_ATTRIBUTES_NAME', 'Remove HTML attributes');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_ATTRIBUTES_DESC', 'A comma seperated list of attributes to remove, e.g. onclick,onmouseover,style');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REWRITE_WIKIPEDIA_NAME', 'Rewrite Wikipedia links');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REWRITE_WIKIPEDIA_DESC', 'Rewrite links to wikipedia.org to the mobile version created by Sevenval AG (http://wikipedia.7val.com/)');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_DEBUG_PASSWORD_NAME', 'Debug password');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_DEBUG_PASSWORD_DESC', 'Set a password required to enable the debug output of the plugin. Enable by appending ?mpDebug=PASSWORD to your blog\'s URL');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_NAVIGATION', 'Navigation');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_NAME', 'Create a mobile sitemap');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_DESC', 'Creates mobile_sitemap.xml(.gz) in the serendipity base directory for search engines like Google, Ask.com etc.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_NAME', 'Report updates');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_DESC', 'Report updates to the services defined below');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_URL_NAME', 'Ping URL-list');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_URL_DESC', 'URLs for pingbacks (%s is replaced with the sitemap-URL, seperate multiple entries with \';\' (semicolon), if you need to enter a ; use \'%3B\').');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_GZIP_NAME', 'Gzip the mobile_sitemap.xml');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_GZIP_DESC', 'The sitemap-protocol supports gziped files to save bandwith. If you\'re experiencing problems, you can try to turn this off. (Note: If your PHP doesn\'t support gzip the plugin will create an unzipped file automagically until you get a PHP with gzip-enabled. So generally you don\'t need to turn this off)');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_PERMALINK_WARNING', 'Warning: to get a correct sitemap you have to place the permalink-plugin before the sitemap-plug in your configuration.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_FAILEDOPEN', 'Could not open the outfile for writing.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_UNKNOWN_HOST', 'Pingback-Host not found.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_ERROR', 'Could not report update to %s: %s<br/>');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_OK', 'Sent sitemap update to %s.<br/>');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_MANUAL','If you have not submited your sitemap to %s, do it now with visiting <a href="%s">this link</a>.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_ANDROID_TEMPLATE_NAME','Android template');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_ANDROID_TEMPLATE_DESC','The name of the template for Android phones. Default is "android,app" which comes with the plugin.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SMALLTEASER_NAME','Small teasers');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SMALLTEASER_DESC','If switched on only the first paragraph of an article will be shown in the article overview, else the the body wthout extended body (as normal).');