<?php # $Id$

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_FACEBOOK_NAME',               'Facebook (Experimental!)');
@define('PLUGIN_EVENT_FACEBOOK_DESC',               'Imports comments made on facebook postings (like through RSS Graffiti) back into the blog. Also embeds Facebook OpenGraph Meta-Tags into the blog. Note that adding "like"-Buttons to blog entries is achieved via the serendipity_event_findmore plugin! ');

@define('PLUGIN_EVENT_FACEBOOK_HOWTO', 'Comments are imported to blogentries by matching the URL of the facebook link (they need to be public!) to your blog, and the configured hostname of Serendipity (baseURL) is used for this lookup. This plugin can be executed through the cronjob plugin, or through manual cronjobs (i.e. wget) via your blog (index.php?/plugin/facebookcomments).');

@define('PLUGIN_EVENT_FACEBOOK_MODERATE',           'Should facebook comments be moderated by default?');

@define('PLUGIN_EVENT_FACEBOOK_USERS', 'Facebook username(s)');
@define('PLUGIN_EVENT_FACEBOOK_USERS_DESC', 'Enter the facebook username or ID that is connected to your blog and that should be fetched. Remember that only public accounts/stories/comments can be retrieved via the Facebook Graph API. Multiple usernames/IDs can be seperated by ",".');

@define('PLUGIN_EVENT_FACEBOOK_VIA', 'Which string to add to facebook comments?');

@define('PLUGIN_EVENT_FACEBOOK_LIMIT', 'How many graph API items to fetch');
@define('PLUGIN_EVENT_FACEBOOK_LIMIT_DESC', 'Defines how many items the Facebook API Request should return. Usually the last 25 items should be sufficient, if you have a high-traffic facebook wall you might want to raise the limit. The higher the limit, the longer checking the graph API will take.');

@define('PLUGIN_AGGREGATOR_CRONJOB', 'This plugin supports the Serendipity Cronjob plugin. Go and install it if you want scheduled execution.');
