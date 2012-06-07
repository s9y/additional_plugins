<?php
@define('PLUGIN_DISQUS_TITLE', 'Disqus comments');
@define('PLUGIN_DISQUS_DESC', 'Disqus.com is a webservice that allows you to manage comments, with central logins. It stores and manages comments outside of your Serendipity installation, and is embedded using JavaScript. For more information see disqus.com.');
@define('PLUGIN_DISQUS_DESC2', '
The plugin puts the disqus output inside the Smarty variable {$entry.plugin_display_dat} AND {$entry.disqus} which you can place inside your entries.tpl template at any position within the {$entry} loop.

If the entry displayed has DISQUS support already, the variable {$entry.has_disqus} is true.

');
@define('PLUGIN_DISQUS_ENABLE_SINCE', 'Enable disqus.com for entries since...');
@define('PLUGIN_DISQUS_ENABLE_SINCE_DESC', 'Enter a date (Y-m-d) for which disqus comments will be enabled, so that you can preserve older comments to be shown properly.');
@define('PLUGIN_DISQUS_SHORTNAME', 'Shortname of your disqus blog account');
@define('PLUGIN_DISQUS_SHORTNAME_DESC', 'Enter the shortname of this blog you registered under your disqus account.');
@define('PLUGIN_DISQUS_FOOTERCOMMENTLINK', 'Let DISQUS set comment count in footer');
@define('PLUGIN_DISQUS_FOOTERCOMMENTLINK_DESC', 'As the comment count is not known, this plugin will put "Comments" only instead of "N comments" into the footer. You can have DISQUS replace this with the correct count, but some templates might not display that correctly so you can disable the dynamic DISQUS replacement here.');
@define('PLUGIN_DISQUS_HIDE_COMMENTCSS', 'Hide comment css');
@define('PLUGIN_DISQUS_HIDE_COMMENTCSS_DESC', 'When disqus.com comments are enabled, any functionality that relies on serendipity-stored comments will no longer work, of course. Internally, this plugin uses CSS to hide the Serendipity output for comments and the commentform. For that it sets "display:none" for these CSS classes. Please enter the classes used in your template styling your comment area and comment form. The default should work on most templates.');