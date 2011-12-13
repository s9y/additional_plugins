<?php # $Id: lang_en.inc.php,v 1.7 2010/12/03 12:54:17 garvinhicking Exp $

/**
 *  @version $Revision: 1.7 $
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_AGGREGATOR_TITLE', 'RSS Aggregator');
@define('PLUGIN_AGGREGATOR_DESC', 'Display entries from multiple RSS feeds ("Planet"). IMPORTANT NOTE: Updating and "feeding" your Aggregator must currently still happen manually via Cronjobs or similar. Call this URL with your custom timing interval: ' . $serendipity['baseURL'] . 'index.php?/plugin/aggregator');
@define('PLUGIN_AGGREGATOR_FEEDNAME', 'Feed name');
@define('PLUGIN_AGGREGATOR_FEEDNAME_DESC', 'Name of this feed.');
@define('PLUGIN_AGGREGATOR_FEEDURI', 'Feed URI');
@define('PLUGIN_AGGREGATOR_FEEDURI_DESC', 'The address of the feed.');
@define('PLUGIN_AGGREGATOR_HTMLURI', 'Homepage URI');
@define('PLUGIN_AGGREGATOR_HTMLURI_DESC', 'The HTML address of the feed.');
@define('PLUGIN_AGGREGATOR_CATEGORIES', 'Categories');

@define('PLUGIN_AGGREGATOR_FEEDLIST', 'This is your list of available feeds. You can either enter the feeds manually one by and and press on the "GO" button, or you can import a whole OPML file. Feeds can be deleted by setting an empty Feedname or empty Feed URL. New feeds can be inserted in the last row of the table.');
@define('PLUGIN_AGGREGATOR_FEEDUPDATE', 'Last update');
@define('PLUGIN_AGGREGATOR_FEED_MISSINGDATA', 'You must specify a feedname and URL.');
@define('PLUGIN_AGGREGATOR_EXPORTFEEDLIST', 'Export OPML feedlist');
@define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST', 'Import OPML feedlist');
@define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST_DESC', 'Enter URL to OPML file to import feedlist (existing feed subscriptions will be CANCELLED and overwritten by the imported subscriptions!). If you check the option "Import Categories", the process will import the category structure from the OPML to your blog.');
@define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST_BUTTON', 'Import OPML!');
@define('PLUGIN_AGGREGATOR_EXPORTFEEDLIST_BUTTON', 'Export OPML!');
@define('PLUGIN_AGGREGATOR_IMPORTCATEGORIES', 'Import Categories');
@define('PLUGIN_AGGREGATOR_IMPORTCATEGORIES2', 'Put each Feed in its own category');
@define('PLUGIN_AGGREGATOR_CATEGORYSKIPPED', 'Skipping creating Category "%s", it already exists.');

@define('PLUGIN_AGGREGATOR_EXPIRE', 'Expire content');
@define('PLUGIN_AGGREGATOR_EXPIRE_BLAHBLAH', 'Content will expire from the database after n days (0 = no expire).');
@define('PLUGIN_AGGREGATOR_EXPIRE_MD5', 'Expire checksums');
@define('PLUGIN_AGGREGATOR_EXPIRE_MD5_BLAHBLAH', 'Checksums are being used to check articles without dates against duplicates. After how many days shall the checksums expire? (90 = recommended, 0 = Never).');
@define('PLUGIN_AGGREGATOR_DELETEDEPENDENCIES', 'Remove dependent entries?');
@define('PLUGIN_AGGREGATOR_DELETEDEPENDENCIES_DESC', 'When a Feed is unsubscribed and this option is enabled, all associated entries to this feed are erased.');
@define('PLUGIN_AGGREGATOR_DEBUG', 'Debug Output');
@define('PLUGIN_AGGREGATOR_DEBUG_BLAHBLAH', 'Enable debug output in log?');
@define('PLUGIN_AGGREGATOR_IGNORE_UPDATES', 'Ignore updates?');
@define('PLUGIN_AGGREGATOR_IGNORE_UPDATES_DESC', 'If an article text changes later on, shall we ignore that update?');
@define('PLUGIN_AGGREGATOR_CHOOSE_ENGINE', 'Choose RSS parser');
@define('PLUGIN_AGGREGATOR_CHOOSE_ENGINE_DESC', 'Onyx ist BSD-licensed, but does not support ATOM feeds. MagpieRSS is GPL-licensed, but does support Atom feeds and more features. SimplePie is modern, maintained, BSD licensed.');
@define('PLUGIN_AGGREGATOR_CRONJOB', 'This plugin supports the Serendipity Cronjob plugin. Go and install it if you want scheduled execution.');
@define('PLUGIN_AGGREGATOR_MATCH_EXPRESSION', 'Filter Expression');
@define('PLUGIN_AGGREGATOR_MATCH_EXPRESSION_DESC', 'Here you can enter a regular expression that will be matched on a feed entry (body and title) and only insert that entry, if the pattern matches. If left empty, no matching is done. Multiple expressions can be seperated by the ~ (tilde) character and are OR-combined.');

@define('PLUGIN_AGGREGATOR_PUBLISH', 'Save aggregated entries as...');
@define('PLUGIN_AGGREGATOR_MARKUP_DISABLE', 'Disable markup plugins for aggregated entries.');
@define('PLUGIN_AGGREGATOR_MARKUP_DISABLE_DESC', 'Highlight the markup plugins you want not to be applied to aggregated entries.');

@define('PLUGIN_AGGREGATOR_FEEDICON', 'Feed Icon URL');
