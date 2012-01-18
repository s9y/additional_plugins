<?php
@define('PLUGIN_EVENT_COMMENTSPICE_TITLE', 'Comment Spice');
@define('PLUGIN_EVENT_COMMENTSPICE_DESC',  'Spice up your comments area with goodies like commenters twitter or last posted article link.');
@define('PLUGIN_EVENT_COMMENTSPICE_EXPERIMENTAL', 'comment spice experimental');

@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT', 'Allow commentors to add their twitter name');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_DESC', 'If you enable this, commenters are allowed to enter their twitter names and their twitter timeline will be linked to the comment.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS', 'Allow commentors to announce recent posts');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_DESC', 'When the commentor adds a homepage, comment spice will check for a RSS feed on that page. If so, the commentor can choose one of his rescents posts to be announced with his comment.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT', 'Maximum article count for announcing');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT_DESC', 'How many rescent posts should be loaded at maximum the user can announce?');
@define('PLUGIN_EVENT_COMMENTSPICE_PATH', 'Plugins path');
@define('PLUGIN_EVENT_COMMENTSPICE_PATH_DESC', 'In normal installations the default is correct.');

@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER', 'Read on twitter');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_FOOTER', 'If you enter your <b>twitter name</b>, your timeline will get linked to your comment.');

@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_CHOOSE', '- Promote one of your rescent articles -');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_RESCENT', 'Recent post');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_FOOTER', '<b>Promote one of your rescent articles</b><br/>This blog allows you to announce one of your recent blog articles with your comment. Please enter your the corresponding URL as homepage and a selection box will pop up letting you choose an article.');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_CORRUPTED', 'Sorry, unable to verify your "recent post" datas..');
