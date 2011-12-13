<?php
@define('PLUGIN_DISQUS_TITLE', 'Disqus comments');
@define('PLUGIN_DISQUS_DESC', 'Disqus.com is a webservice that allows you to manage comments, with central logins. It stores and manages comments outside of your Serendipity installation, and is embedded using JavaScript. For more information see disqus.com.');
@define('PLUGIN_DISQUS_DESC2', 'When disqus.com comments are enabled, any functionality that relies on serendipity-stored comments will no longer work, of course.

Internally, this plugin uses CSS to hide the Serendipity output for comments, trackbacks and the commentform. For that it sets "display:none" for these CSS classes:

.serendipity_comments
.serendipity_section_comments
.serendipity_section_trackbacks
.serendipity_section_commentform

If your template/theme uses other names, you need to add these classnames to your template, or hide these containers yourself.

The plugin puts the disqus output inside the Smarty variable {$entry.plugin_display_dat} AND {$entry.disqus} which you can place inside your entries.tpl template at any position within the {$entry} loop.

');
@define('PLUGIN_DISQUS_ENABLE_SINCE', 'Enable disqus.com for entries since...');
@define('PLUGIN_DISQUS_ENABLE_SINCE_DESC', 'Enter a date (Y-m-d) for which disqus comments will be enabled, so that you can preserve older comments to be shown properly.');
@define('PLUGIN_DISQUS_SHORTNAME', 'Shortname of your disqus account');
@define('PLUGIN_DISQUS_SHORTNAME_DESC', 'Enter the shortname that you registered your disqus account under.');
