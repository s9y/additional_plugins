<?php

@define('PLUGIN_EVENT_COMMENTSPICE_TITLE', 'Comment Spice');
@define('PLUGIN_EVENT_COMMENTSPICE_DESC',  'Spice up your comments area with goodies like commenters twitter or last posted article link.');

@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_TWITTERNAME', 'Twittername');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_ANNOUNC_RSS', 'Announce recent posts');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_GENERAL', 'General Settings');

@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT', 'Allow commentors to add their twitter name');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_DESC', 'If you enable this, commenters are allowed to enter their twitter names and their twitter timeline will be linked to the comment.');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_NOFOLLOW', 'Set twitter link nofollow');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_NOFOLLOW_DESC', 'If set to nofollow search engines will ignore the twitter timeline link. It will make it less interesting for manual comment spammers but won\'t give search engine kudos to the real commenter.');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET', 'Display twitter followme widget');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_DESC', 'If enabled this will emit the nice looking follow me widget by twitter instead of the own created output. As this may looks nicer, it will slow down the comment rendering, as it has to be loaded for each comment. If smartified, this will switch, if $comment.spice_twitter_followme has content or not.');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_COUNT',  'Twitter followme widget follower count');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_COUNT_DESC',    'If enabled, the widget will dispaly the current follower count of the commentor.');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_DARK',          'Twitter followme widget on dark background');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_DARK_DESC',     'If your template has a dark background, you should enable this.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS', 'Allow commentors to announce recent posts');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_DESC', 'When the commentor adds a homepage, comment spice will check for a RSS feed on that page. If so, the commentor can choose one of his rescents posts to be announced with his comment.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_NOFOLLOW', 'Set recent post link nofollow');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_NOFOLLOW_DESC', 'If set to nofollow search engines will ignore the recent post link. It will make it less interesting for manual comment spammers but won\'t give search engine kudos to the real commenter.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT', 'Maximum article count for announcing');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT_DESC', 'How many rescent posts should be loaded at maximum the user can announce?');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_CACHEMIN', 'Minutes to cache fetched article results');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_CACHEMIN_DESC', 'How many minutes CommentSpice should cache fetched article informations? Don\'t set this too high, as new articles will pop up late. one to two hours (60-120min) seems to be a good value. Setting this to zero will switch off the cache.');

@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_RULES', 'Rules');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTCOUNT', 'Minimal comment count to allow spice extras');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTCOUNT_DESC', 'Assing the minimal comment count a commentor must have written before comment spices are enabled. 0 means: Allow to anybody.');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTLENGTH', 'Minimal comment length to allow spice extras');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTLENGTH_DESC', 'Assing the minimal length of a comment before comment spices are enabled. 0 means: Any comment length.');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTCOUNT', 'Minimal comment count to allow dofollow links');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTCOUNT_DESC', 'Assing the minimal comment count a commentor must have written before dofollow links are allowed. 0 means: Allow to anybody.');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTLENGTH', 'Minimal comment length to allow dofollow links');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTLENGTH_DESC', 'Assing the minimal length of a comment for allowing dofollow links. 0 means: Any comment length.');
@define('PLUGIN_EVENT_COMMENTSPICE_ENABLED', 'enabled');
@define('PLUGIN_EVENT_COMMENTSPICE_DISABED', 'disabled');
@define('PLUGIN_EVENT_COMMENTSPICE_RULES', 'use rules');

@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_TWITTER', 'Smartify twittername output');
@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_TWITTER_DESC', 'If switched on, CommentSpice won\'t emit code for the commentors twittername but will put all needed infos to the smarty hash. For this to work you have to add new smarty content to your comments.tpl. Available variables are $comment.spice_twitter_name (the twitter name, check if empty), $comment.spice_twitter_url (url of the users timeline), $comment.spice_twitter_nofollow (nofollow configured for twitterlinks), $comment.spice_twitter_icon_html (html producing the twitter icon), $comment.spice_twitter_followme (html for the followme widget).');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_TWITTER', 'Comment editor template patched for twitter input');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_TWITTER_DESC', 'Switch on this option, if you have patched your commentform.tpl file to have its own twitter input (and want to use this patch). I have added examples on how to do that inside of the plugins folder.');
@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_RSS', 'Smartify article output');
@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_RSS_DESC', 'If switched on, CommentSpice won\'t emit code for the announced post but will put all needed infos to the smarty hash. For this to work you have to add new smarty content to your comments.tpl. Available variables are $comment.spice_article_name (articles title, check if empty). $comment.spice_article_url (articles url), $comment.spice_article_nofollow (nofollow configured for article links), $comment.spice_article_prefix (prefix in language of visitor).');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_RSS', 'Comment editor template patched for article selector');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_RSS_DESC', 'Switch on this option, if you have patched your commentform.tpl file to have its own article selector (and want to use this patch). I have added examples on how to do that inside of the plugins folder.');

@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK', 'Fetch content of pingback articles');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_DESC', 'If another blog sends a pingback to one of your articles, only the URL of the foreign article is known. Serendipity is able to fetch the content of the foreign article and displays it like it is known from trackbacks. But for performance reasons Serendipity does not by default. With this option you can let the plugin save a config into your serendipity_config_local.inc.php ordering Serendipity to fetch the content. If you can not change the value, you have done that manualy already overwriting the setting here. In this case you should remove your manual change from serendipity_config_local.inc.php in order to be able to change this setting with this plugin.');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_LEAVE_ON', 'Leave as: fetch content');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_LEAVE_OFF', 'Leave as: don\'t fetch content');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_FETCH', 'Change to: fetch content');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_DONTFETCH', 'Change to: don\'t fetch content');

@define('PLUGIN_EVENT_COMMENTSPICE_PATH', 'Plugins path');
@define('PLUGIN_EVENT_COMMENTSPICE_PATH_DESC', 'In normal installations the default is correct.');
@define('PLUGIN_EVENT_COMMENTSPICE_REQUIRED_FIELDS', 'Required comment fields');
@define('PLUGIN_EVENT_COMMENTSPICE_REQUIRED_FIELDS_DESC', 'Enter a list of required fields that need to be filled when a user comments. Seperate multiple fields with a ",". Available keys are: name, email, url, replyTo, comment');
@define('PLUGIN_EVENT_COMMENTSPICE_REASON_REQUIRED_FIELD', 'You did not specify the %s field!');

@define('PLUGIN_EVENT_COMMENTSPICE_EXPERTSETTINGS', 'Show advanced settings');
@define('PLUGIN_EVENT_COMMENTSPICE_STANDARDSETTINGS', 'Show basic settings');

@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER', 'Read on twitter');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_FOOTER', 'If you enter your <b>twitter name</b>, your timeline will get linked to your comment.');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_PLACEHOLDER', 'your twittername');

@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_CHOOSE', '- Promote one of your rescent articles -');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_RESCENT', '%s wrote about');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_FOOTER', '<b>Promote one of your rescent articles</b><br/>This blog allows you to announce one of your recent blog articles with your comment. Please enter your the corresponding URL as homepage and a selection box will pop up letting you choose an article.');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_CORRUPTED', 'Sorry, unable to verify your "recent post" datas..');

@define('PLUGIN_EVENT_COMMENTSPICE_REQUIREMENTS', 'Requirements');
@define('PLUGIN_EVENT_COMMENTSPICE_REQUIREMENTS_COMMENTCOUNT', '%s comments written');
@define('PLUGIN_EVENT_COMMENTSPICE_REQUIREMENTS_COMMENTLEN', 'this comment %s letters at least');
