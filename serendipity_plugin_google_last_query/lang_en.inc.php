<?php # $Id$

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_GOOGLE_LAST_QUERY_TITLE',                   "Last Search (Google, Yahoo, Bing, Scroogle)");
@define('PLUGIN_GOOGLE_LAST_QUERY_DESC',                    "Shows searched word of the last Google, Yahoo, Bing or Scoogle search, that lead to this blog.");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_TITLE',              "Title");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_TITLE_DESC',         "Title shown at the sidebar");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_COUNT',              "Count");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_COUNT_DESC',         "How much searches should be shown?");

@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_VISITORTABLE',       "Use visitor table");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_VISITORTABLE_DESC',  "Normaly the referrers table is used. This table doesn't hold all references but only references leading to the blog a couple of times. The visitor table holds all visitors. If you use this table, the google searches will be shown immidiatly, if used. But watch out: The visitors Table is filled by the statistics plugin and only if the option for visitor tracking is enabled.");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_NEWWINDOW',          "Open link in new window");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_NEWWINDOW_DESC',     "The searched words are linked to the related ggogle search. Do you want to have it opened in a new window?");

@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_HTTPREL',            "Relativ HTTP path of the plugin");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_HTTPREL_DESC',       "This defines the HTTP path of the plugin relative to the base server url. If you didn't change the permalink structure for plugins and your blog is not running in a subdirectory of the server, you are fine with the default setting.");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_ICONS',         "Show icons");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_ICONS_DESC',    "Show icons for each result representing the search engine.");

@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_TIME',          "Show query time");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_TIME_DESC',     "If enabled, the execution time of the query will be shown as mouseover the search entry.");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_AUTHONLY',      "Show auth. users only");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_AUTHONLY_DESC', "If enabled, the plugin will only display something, if the visitor is logged in.");

@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_STATS',         "Show search engine stats");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_STATS_DESC',    "If enabled it will display how many queries are routed to the blog per search engine the last X days.");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_STATDAYS',           "Statistic days");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_STATDAYS_DESC',      "These are the days back, the search engine stats are calculated. Don't choose a too big value, the bigger the value, the slower the plugin's display.");

@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_ENTRIES',       "Show searches");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_ENTRIES_DESC',  "If disabled, no search queries will be shown (only stats, if enabled)");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_CACHEMINS',          "Cache minutes");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_CACHEMINS_DESC',     "Querying stats and searches should be cached. Specify the time in mins after the view is recalculated (0 = cache off)");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_ENGINES',            "Searchengines");
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_ENGINES_DESC',       "Mark all searchengines, you want the plugin to evaluate. The more you mark, the more time the calculation will consume of course.");
