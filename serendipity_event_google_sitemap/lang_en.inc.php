<?php # 

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_SITEMAP_TITLE', 'Sitemap Generator (for Crawlers)');
@define('PLUGIN_EVENT_SITEMAP_DESC',  'Creates a sitemap.xml.gz, which can be used by miscellaneous Web-Crawlers. (Google, MSN, Yahoo and Ask)');
@define('PLUGIN_EVENT_SITEMAP_FAILEDOPEN', 'Could not open the outfile for writing.');
@define('PLUGIN_EVENT_SITEMAP_REPORT', 'Report sitemap');
@define('PLUGIN_EVENT_SITEMAP_REPORT_DESC', 'Report sitemap updates to the services defined below.');
@define('PLUGIN_EVENT_SITEMAP_REPORT_ERROR', 'Could not report sitemap to %s: %s<br/>');
@define('PLUGIN_EVENT_SITEMAP_REPORT_OK', 'Sent sitemap sitemap to %s.<br/>');
@define('PLUGIN_EVENT_SITEMAP_REPORT_MANUAL','If you have not submited your sitemap to %s, do it now with visiting <a href="%s">this link</a>.<br/>');
@define('PLUGIN_EVENT_SITEMAP_ROBOTS_TXT', 'You can also add it to your robots.txt, see <a href="http://googlewebmastercentral.blogspot.com/2007/04/whats-new-with-sitemapsorg.html">here</a> for details.<br/>');
@define('PLUGIN_EVENT_SITEMAP_URL', 'Ping URL-list');
@define('PLUGIN_EVENT_SITEMAP_URL_DESC', 'URLs for pingbacks (%s is replaced with the sitemap-URL, seperate multiple entries with \';\' (semicolon), if you need to enter a ; use \'%3B\').');
@define('PLUGIN_EVENT_SITEMAP_ADDFEEDS', 'Add newsfeeds');
@define('PLUGIN_EVENT_SITEMAP_ADDFEEDS_DESC', 'Adds the URLs of the newsfeeds (RSS 0.9, 1.0, 2.0, Atom and Categories) to your sitemap.');
@define('PLUGIN_EVENT_SITEMAP_UNKNOWN_SERVICE', 'unknown');
@define('PLUGIN_EVENT_SITEMAP_PERMALINK_WARNING', 'Warning: to get a correct sitemap you have to place the permalink-plugin <b>before</b> the sitemap-plug in your configuration.');
@define('PLUGIN_EVENT_SITEMAP_GZIP_SITEMAP', 'Gzip the sitemap.xml');
@define('PLUGIN_EVENT_SITEMAP_GZIP_SITEMAP_DESC', 'The sitemap-protocol supports gziped files to save bandwith. If you\'re experiencing problems, you can try to turn this off. (Note: If your PHP doesn\'t support gzip the plugin will create an unzipped file automagically until you get a PHP with gzip-enabled. So generally you don\'t need to turn this off)');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD', 'URL-types to add');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_DESC', 'Defines the types of URLs that should be included in your sitemap.');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_FEEDS', 'Feeds');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_CATEGORIES', 'Categories');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_AUTHORS', 'Authors');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_PERMALINKS', 'Permalinks');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_ARCHIVES', 'Archives');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_STATIC', 'Static Pages');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_TAGS', 'Tags Pages');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM', 'Custom content (XML body)');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM_DESC', 'Here you can enter any XML-style content that you want to add to the bottom of the generated sitemap. You can manually add KML files or manual links, for example. Make sure your input is XML valid.');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM2', 'Custom content (XML head/namespace)');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM2_DESC', 'Here you can enter any XML-style content that you want to add to the head (top) of the generated sitemap, just inside the urlset XML element. Make sure your input is XML valid.');
@define('PLUGIN_EVENT_SITEMAP_NEWS', 'Enable GoogleNews content');
@define('PLUGIN_EVENT_SITEMAP_GNEWS_NAME', 'Title for GoogleNews content');
@define('PLUGIN_EVENT_SITEMAP_GNEWS_NAME_DESC', '');

@define('PLUGIN_EVENT_SITEMAP_PUBLIC', 'Public');
@define('PLUGIN_EVENT_SITEMAP_SUBSCRIPTION', 'Subscription (Paid content)');
@define('PLUGIN_EVENT_SITEMAP_REGISTRATION', 'Registration (Free content, Registration required)');
@define('PLUGIN_EVENT_SITEMAP_PRESS', 'Press release');
@define('PLUGIN_EVENT_SITEMAP_SATIRE', 'Satire');
@define('PLUGIN_EVENT_SITEMAP_BLOG', 'Blog');
@define('PLUGIN_EVENT_SITEMAP_OPED', 'Editor\'s Opinion');
@define('PLUGIN_EVENT_SITEMAP_OPINION', 'Other\'s Opinion');
@define('PLUGIN_EVENT_SITEMAP_USERGENERATED', 'User-generated content');

@define('PLUGIN_EVENT_SITEMAP_GNEWS_SUBSCRIPTION', 'GoogleNews: Subscription type');
@define('PLUGIN_EVENT_SITEMAP_GNEWS_SUBSCRIPTION_DESC', '');
@define('PLUGIN_EVENT_SITEMAP_GENRES', 'GoogleNews: Genres');
@define('PLUGIN_EVENT_SITEMAP_GENRES_DESC', 'Currently, these genres apply to all blog entries. So you should pick a genre that usually fits all your blog entries. To make this option be per-entry based, you need to add a CustomProperty field to your blog entries called "gnews_genre", which can contain a commaseparated string.');
@define('PLUGIN_EVENT_SITEMAP_NONE', 'No genre');

@define('PLUGIN_EVENT_SITEMAP_NEWS_SINGLE', 'Merge GoogleNews sitemap with normal sitemap?');
@define('PLUGIN_EVENT_SITEMAP_NEWS_SINGLE_DESC', 'This option only applies if you have enabled GoogleNews content. If enabled, the normal sitemap.xml file will contain GoogleNews markup. When disabled, only the news_sitemap.xml file will contain GoogleNews formatted data. If you have more than then allowed 1000 blog articles, you must disable this option to not confuse the GoogleSpiders with your "normal" sitemap.');
