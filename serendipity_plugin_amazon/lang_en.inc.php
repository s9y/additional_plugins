<?php # 

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_AMAZON_TITLE',              "Amazon Recommendations");
@define('PLUGIN_AMAZON_DESC',               "Recommend Products at Amazon within the Amazon-Partnerprogram");
@define('PLUGIN_AMAZON_PROP_TITLE',         "Title");
@define('PLUGIN_AMAZON_PROP_TITLE_DESC',    "Title to display in the Sidebar");
@define('PLUGIN_AMAZON_NEW_WINDOW',         "Open links in new windows");
@define('PLUGIN_AMAZON_TRACK_GOOGLE',       "Track Clicks using Google Analytics");
@define('DESC_PLUGIN_AMAZON_TRACK_GOOGLE',  "Google Analytics Plugin needed.");
@define('PLUGIN_AMAZON_SMALL_MED',          "Thumbnail size to display");
@define('PLUGIN_AMAZON_SMALL',              "Small");
@define('PLUGIN_AMAZON_MEDIUM',             "Medium");
@define('PLUGIN_AMAZON_LARGE',              "Large");
@define('PLUGIN_AMAZON_SIDEBAR_CACHE',      "Cache time");
@define('PLUGIN_AMAZON_SIDEBAR_CACHE_DESC', "Number of minutes to cache the entire plugin output.  Amazon requests are cached for 24 hours, while the display text for each item is cached for 60 minutes.  This setting allows a small increase in performance by not randomizing output for the duration of the cache time.  Set to '0' for no cache.");
@define('PLUGIN_AMAZON_ASIN',               "ASIN-List");
@define('PLUGIN_AMAZON_ASIN_DESC',          "Comma-separated List of ASIN you'd like to recommend. The Amazon button returns a form ASIN-TYPE but this is not required for basic functionality.");
@define('PLUGIN_AMAZON_ASIN_CNT',           "How many articles to display?");
@define('PLUGIN_AMAZON_SERVER', 'Default Server');
@define('PLUGIN_AMAZON_SERVER_DESC', 'Amazon server you wish to use for localization');
@define('PLUGIN_AMAZON_GERMANY', 'Germany');
@define('PLUGIN_AMAZON_JAPAN', 'Japan');
@define('PLUGIN_AMAZON_UK', 'United Kingdom');
@define('PLUGIN_AMAZON_US', 'United States');
@define('PLUGIN_AMAZON_CA', 'Canada');
@define('PLUGIN_AMAZON_FR', 'France');
@define('PLUGIN_AMAZON_DEPENDS_ON', 'This plugin now depends on the <a href="http://spartacus.s9y.org/index.php?mode=bygroups_event_en#group_BACKEND_EDITOR" >Amazon Media Button</a> event plugin.  Please install the plugin and configure it to connect to Amazon.');
?>
