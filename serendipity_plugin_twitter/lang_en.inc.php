<?php 
@define('PLUGIN_TWITTER_TITLE',                         'Twitter Timeline');
@define('PLUGIN_TWITTER_DESC',                          'Show your current Twitter entries');
@define('PLUGIN_TWITTER_NUMBER',                        'Number of entries');
@define('PLUGIN_TWITTER_NUMBER_DESC',                   'How many entries should be displayed? (Default: 10)');
@define('PLUGIN_TWITTER_TOALL_ONLY',                    'No replies');
@define('PLUGIN_TWITTER_TOALL_ONLY_DESC',               'If enabled, no tweet will be shown starting with @. This will show Retweets i.e. (PHP version only)');
@define('PLUGIN_TWITTER_FILTER_ALL',                    'No user tweets');
@define('PLUGIN_TWITTER_FILTER_ALL_DESC',               'If enabled, no tweet will be shown containing a @. (PHP version only)');
@define('PLUGIN_TWITTER_SERVICE',                       'Service');
@define('PLUGIN_TWITTER_SERVICE_DESC',                  'Choose your microblogging service');
@define('PLUGIN_TWITTER_USERNAME',                      'Username');
@define('PLUGIN_TWITTER_USERNAME_DESC',                 'The username you use to log into twitter or indenti.ca.');
@define('PLUGIN_TWITTER_SHOWFORMAT',                    'Output format');
@define('PLUGIN_TWITTER_SHOWFORMAT_DESC',               'You can choose between Javascript and PHP to show your entries at the Frontend. Watch out: JS won\'t work with mutiple versions of this plugin on one page. You have to use the PHP version if you want a setup like this.');
@define('PLUGIN_TWITTER_SHOWFORMAT_RADIO_JAVASCRIPT',   'Javascript');
@define('PLUGIN_TWITTER_SHOWFORMAT_RADIO_PHP',          'PHP');

@define('PLUGIN_TWITTER_CACHETIME',                     'How long to cache data (only for PHP output format)');
@define('PLUGIN_TWITTER_CACHETIME_DESC',                'To prevent transfering too much data from and to twitter, you can cache the result. Enter the amount of seconds until the plugin shall try to reach Twitter again.');
@define('PLUGIN_TWITTER_BACKUP',                        'Backup your tweets? (Experimental, Twitter only)');
@define('PLUGIN_TWITTER_BACKUP_DESC',                   'If enabled, this plugin will download your latest tweets daily and save them to a local database table (' . $serendipity['dbPrefix'] . 'tweets) for backup purposes.');

@define('PLUGIN_TWITTER_LINKTEXT',                      'Tweet links text');
@define('PLUGIN_TWITTER_LINKTEXT_DESC',                 'Links found in tweets are replaced by a clickable HTML link. Here the text of the link is configured. Entering $1 here will use the link itself as the link text (the same, twitter does it).');

@define('PLUGIN_TWITTER_FOLLOWME_LINK',                 'Follow me link');
@define('PLUGIN_TWITTER_FOLLOWME_LINK_DESC',            'Adds a "follow me" link below the timeline');
@define('PLUGIN_TWITTER_FOLLOWME_LINK_TEXT',            'Follow me');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET',               'Twitter followme widget');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DESC',          'If this plugin displays a twitter timeline you can enable twitters followme widget supporting current follower count and more. Ignored, if you are displaying identi.ca.');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_COUNT',         'Twitter followme widget follower count');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_COUNT_DESC',    'If enabled, the widget will dispaly your current follower count.');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DARK',          'Twitter followme widget on dark background');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DARK_DESC',     'If your template has a dark background, you should enable this.');

@define('PLUGIN_TWITTER_USE_TIME_AGO',                  'Use Time Ago');
@define('PLUGIN_TWITTER_USE_TIME_AGO_DESC',             'If enabled, the time of the status will be dispayed as time gone since creation time (like twitter itself does it), else the configured dateformat will be used');

@define('PLUGIN_TWITTER_PROBLEM_TWITTER_ACCESS',        'Problem, accessing twitter at the moment. <br/>Please reload later..');

// Twitter Event Plugin 
@define('PLUGIN_EVENT_TWITTER_NAME',                    'Microblogging (Twitter,Identica)');
@define('PLUGIN_EVENT_TWITTER_DESC',                    'Adds a twitter/identica client to the admininistration interface, searches for tweetbacks and announces new articles to a microblogging account.');

@define('PLUGIN_EVENT_TWITTER_ACCOUNT_NAME',            'Accountname');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_NAME_DESC',       'The account name for the backend client and announcing articles.');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_PWD',             'Account password');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_PWD_DESC',        'The account password for the backend client and announcing articles.');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_TITLE', 'Article Announcement');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES',       'Announce articles');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_DESC',  'If enabled, the plugin will announce published articles to twitter or Identica acounts.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_WITHTTAGS',      'Announce with tags');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_WITHTTAGS_DESC', 'If the Free Tag plugin is installed, the Announcer will search for tags in the title of the article. If found, they will be marked as twitter tags. You always may add #tags# to your announce format. This will be filled with all tags not added to the title (this means: all tags if this option is not enabled).');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_SERVICE',        'Anounce url shortener');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_SERVICE_DESC',   'Service to use, when shortening links while announcing an article. 7ax.de or tinyurl.com is recommended, as they are the only known service yet that are reliable while checking for tweetbacks.');

@define('PLUGIN_EVENT_TWITTER_TWEETBACKS_TITLE',        'Tweetbacks');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETBACKS',           'Check for Tweetbacks');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETBACKS_DESC',      'If enabled, the plugin will try to find tweetbacks to articles and will add a "check feedback" below the extended article, if the visor is logged into the blog.');
@define('PLUGIN_EVENT_TWITTER_IGNORE_MYTWEETBACKS',     'Ignore my tweets');
@define('PLUGIN_EVENT_TWITTER_IGNORE_MYTWEETBACKS_DESC','If you don\'t want to echo your own tweets as tweetbacks, enable this. Else in example the announcements will be echoed as tweetback.');

@define('PLUGIN_EVENT_TWITTER_TWEETBACK_CHECK_FREQ',    'Tweetback Check Frequency');
@define('PLUGIN_EVENT_TWITTER_TWEETBACK_CHECK_FREQ_DESC','The frequency between two twitter checks in minuts. (has to be 5min at least)');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE',                 'Tweetback type');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_DESC',            'Serendipity doesn\'t support tweetbacks itself. So they have to be saved as trackbacks or normal comments. As they are from the outer world, they are some kind of trackbacks, but looking at the content, they are more like comments. Decide, as what you want the tweetbacks to be saved.');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_TRACKBACK',       'Trackback');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_COMMENT',         'Comment');

@define('PLUGIN_EVENT_TWITTER_TWEETER_TITLE',           'Microblogging Client');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SIDEBARTITLE',    'Tweeter');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW',            'Enable microblogging client');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_DESC',       'This wil enable the tweeter at the admin\'s frontpage, as a sidebar entry or disables it.');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_FRONTPAGE',  'Frontpage');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_SIDEBAR',    'Sidebar');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_DISABLE',    'Disable');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY',         'Show timeline');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_DESC',    'Shows your timeline below the update imput.');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_COUNT',   'Timeline count');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_COUNT_DESC','Ammount of history entries to be loaded into the frontpage');

@define('PLUGIN_EVENT_TWITTER_TWEETER_FORM',            'Enter your tweet:');
@define('PLUGIN_EVENT_TWITTER_TWEETER_CHARSLEFT',       'chars left');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHORTEN',         'Shorten URL');
@define('PLUGIN_EVENT_TWITTER_TWEETER_STORED',          'Tweet stored ');
@define('PLUGIN_EVENT_TWITTER_TWEETER_STOREFAIL',       'Tweet couldn\'t be stored! Twitter error: ');

@define('PLUGIN_EVENT_TWITTER_GENERAL_TITLE',           'General');
@define('PLUGIN_EVENT_TWITTER_PLUGIN_EVENT_REL_URL',    'Plugin rel. path');
@define('PLUGIN_EVENT_TWITTER_PLUGIN_EVENT_REL_URL_DESC', 'Enter the full HTTP path (everything after your domain name) that leads to this plugin\'s directory.');

@define('PLUGIN_EVENT_TWITTER_TWEETER_WARNING',         '<p class="serendipityAdminMsgError">' .
                '<img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png'). '" alt="" />' .
                'WARNING: Found an installed TwitterTweeter plugin.</p>' .
                '<p class="serendipityAdminMsgError">This plugin is a merge of TwitterTweeter the old official S9Y twitter plugin and extends both. You should deinstall the tweeter plugin now.</p>');

@define('PLUGIN_EVENT_TWITTER_TB_USE_URL',              'Tweetback URL');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_DESC',         'What to save as URL for the tweetback? You have 3 options. Status: the url the the tweet causing the tweetback, Profile: the users twitter profile or WebURL: the url the user defined as his Web URL in his twitter profile');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_STATUS',       'Status');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_PROFILE',      'User Profile');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_WEBURL',       'Web URL');

@define('PLUGIN_EVENT_TWITTER_IDENTITIES',              'Identities');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_IDCOUNT',         'Number of Accounts');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_IDCOUNT_DESC',    'After saving this, the configuration will give you inputs for the number of accounts. Perhaps you have to save it twice, to see the inputs.');
@define('PLUGIN_EVENT_TWITTER_IDENTITY',                'Indentity');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE',         'Account Service');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_DESC',    'Specify, if this is a twitter or identi.ca account');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_TWITTER', 'twitter');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_IDENTICA','identica');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ACCOUNTS',       'Anounce accounts');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ACCOUNTS_DESC',  'Select the accounts to be used for article announcements');

// Configuration Tabs:
@define('PLUGIN_EVENT_TWITTER_CFGTAB',                  'Configuration tabs: ');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_IDENTITIES',       'Identities');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_ANNOUNCE',         'Article announcement');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETER',          'Microblogging Client');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETBACK',        'Tweetbacks');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_GLOBAL',           'Globals');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_ALL',              'ALL');

@define('PLUGIN_EVENT_TWITTER_TWEETER_REPLY',           'Reply to writer');
@define('PLUGIN_EVENT_TWITTER_TWEETER_RETWEET',         'Retweet this');
@define('PLUGIN_EVENT_TWITTER_TWEETER_DM',              'Direct Message. (Works only, if the user is following)');

@define('PLUGIN_EVENT_TWITTER_IGNORE_TWEETBACKS_BYNAME','Ignore Tweetbacks from');
@define('PLUGIN_EVENT_TWITTER_IGNORE_TWEETBACKS_BYNAME_DESC','A komma seperated list of twitter accounts you don\'t want to receive tweetbacks from.');

@define('PLUGIN_TWITTER_EVENT_NOT_INSTALLED',           '<p class="serendipityAdminMsgError">' .
                '<img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png'). '" alt="" />' .
                'WARNING: The "' . PLUGIN_EVENT_TWITTER_NAME . '" event plugin was not installed yet!</p>' .
                '<p class="serendipityAdminMsgError">This is no error but the main part of the twitter/identica functionality is covered by the microblogging (twitter/identica) event plugin.<br/>You should install that, too, if you want to enable the complete microblogging support.<br/>The event plugin will emit some nice CSS for the sidebar plugin, too.</p>');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_FORMAT',         'Announce format');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_FORMAT_DESC',    'Define the format of your announcement. You should use placeholders. #title#: replaced with article title (and matching tags); #link#: link to your article; #author#: Author of the article; #tags#: tags that are left.');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYDESC',    	'<h3>bitly username and API key</h3><b>bit.ly</b> and <b>j.mp</b> short urls need a bit.ly login and an API key. If you use none of them you won\'t need this.<br/>The default key is not working most of the times, as it is a demo key and it\'s ratio is exceeded. If you have a bit.ly account, you should enter your own.<br/><a href="http://bitly.com/a/your_api_key/" target="_blank">You will find it here</a>.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYLOGIN',    	'bit.ly username');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYAPIKEY',	'bit.ly API key');

@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETTHIS',        'Tweet This!');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_TITLE',         'Tweet This!');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETTHIS',            'Enable Tweet This!');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETTHIS_DESC',       'Enabling this will show a "Tweet This!" button in the footer of your article.');
@define('PLUGIN_EVENT_TWITTER_DO_IDENTICATHIS',         'Enable Identica This!');
@define('PLUGIN_EVENT_TWITTER_DO_IDENTICATHIS_DESC',    'Enabling this will show a "Identica This!" button in the footer of your article.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT',        'Tweet This! format');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_DESC',   'Define the format of a visitor tweet. You should use placeholders. #title#: replaced with article title (and matching tags); #link#: link to your article; #author#: Author of the article; #tags#: tags that are left.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON', 'Button style');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_DESC', 'There are two different button styles at the moment.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_BLACK', 'black');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_WHITE', 'white');

@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_NEWWINDOW',     'TweetThis in new window');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_NEWWINDOW_DESC','If enabled, twitter and identica will be loaded in a new window instead of replacing the actual blog window.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_SMARTIFY',      'Smartify TweetThis functionality');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_SMARTIFY_DESC', 'If enabled the plugin won\'t add a button by itself. Instead it will emit smarty variables: entry.url_tweetthis, entry.url_dentthis and entry.url_shorturl for each entry to be used in your template. These are only the URLs so you are able to create textlinks only in example or place a big tweetthis button in the head of your entry.');

@define('PLUGIN_EVENT_TWITTER_BACKEND_DONTANNOUNCE',    'Do *not* announce this article using microblogging services');
@define('PLUGIN_EVENT_TWITTER_BACKEND_ENTERDESC',       'Enter any tags that apply. Seperate multiple tags with a comma (,). If something is entered here, free tag tags are ignored while announcing!');

@define('PLUGIN_EVENT_TWITTER_TB_MODERATE',             'Tweetback moderation');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE_DESC',        'How to handle catched tweetbacks? You may use the global comments configuration, moderate them or auto-approve them.');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE_DEFAULT',     'Use global configuration (including antispam plugin!)');

@define('PLUGIN_EVENT_TWITTER_SHORTURL_TITLE',          'Short URL for this article');
@define('PLUGIN_EVENT_TWITTER_SHORTURL_ON_CLICK',       'This link is not meant to be clicked. It contains the short URL for this entry. You can use this URL as a short form for a link tho this article for use in twitter in example. To copy the link, right click and select "Copy Shortcut" in Internet Explorer or "Copy Link Location" in Mozilla.');

@define('PLUGIN_EVENT_TWITTER_SHOW_SHORTURL',           'Show short URL for each article');
@define('PLUGIN_EVENT_TWITTER_SHOW_SHORTURL_DESC',      'Will show the drefault short URL in the footer of each article. If TwwetThis smartifying is enabled, each entry will get the variable entry.url_shorturl instead.');

// oauth
@define('PLUGIN_EVENT_TWITTER_CONSUMER_KEY',            'Consumer key');
@define('PLUGIN_EVENT_TWITTER_CONSUMER_KEY_DESC',       'The "consumer key" and "consumer secret" you get from Twitter after you  created for your block a Twitter application.');
@define('PLUGIN_EVENT_TWITTER_CONSUMER_SECRET',         'Consumer secret');
@define('PLUGIN_EVENT_TWITTER_SIGN_IN',                 'Click on the button below and allow Twitter to connect.<br/>
<p><a style="color:red;">WARNING!</a><br/>
You have to be logged out or logged in with the <b>matching twitter account</b> at Twitter!<br/>
<a href="#" onclick="window.open(\'http://twitter.com\',\'\',\'width=1000,height=400\'); return false">Please affirm this before connecting</a>.</p>');
@define('PLUGIN_EVENT_TWITTER_TIMELINE',                'Status Timeline');
@define('PLUGIN_EVENT_TWITTER_TIMELINE_DESC',           '');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_OK',           'Connected');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_DEL',          'Delete link');

@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_DEL_OK',        'Twitter OAuth token removed');
@define('PLUGIN_EVENT_TWITTER_CLOSEWINDOW',              'Close window');
@define('PLUGIN_EVENT_TWITTER_REGISTER',                 'Register');
@define('PLUGIN_EVENT_TWITTER_SIGNIN',                   'Connect');
@define('PLUGIN_EVENT_TWITTER_CALLBACKURL',              'Call Back URL (enter in twitter)');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_ERROR',         'Twitter Callback Error');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_NO', 'By default, disable checkbox for announcing an article');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_NO_DESC', 'Enabled means, a new blog entry must explicitly be published to a microservice. Disabled means, by default an entry will get published to the microservice.');

@define('PLUGIN_EVENT_TWITTER_GENERALCONSUMER',        '<h3>Your own twitter client</h3>Per default the plugin uses a twitter client named \'s9y\'. You may <a href="https://dev.twitter.com/apps" target="_blank">register your own client</a> and setup the consumer key and secret of your client here if you like.');

@define('PLUGIN_TWITTER_FILTER_RT',                    	'Filter native retweets');
@define('PLUGIN_TWITTER_FILTER_RT_DESC',               	'Should native retweets be filtered? (only for Twitter API 1.1, API 1.0 will always filter)');
@define('PLUGIN_TWITTER_API11',                    		'Use OAuth Twitter API 1.1');
@define('PLUGIN_TWITTER_API11_DESC',               		'Twitter API 1.0 is depreciated and will be closed 2013. So you should switch to API 1.1. But this requires to configure at least one OAuth connection in the main microblogging plugin. If you find some accout in the selector below, you already have done this.');
@define('PLUGIN_TWITTER_OAUTHACC',                    	'OAuth acc to be used by this plugin');
@define('PLUGIN_TWITTER_OAUTHACC_DESC',               	'The new OAuth Twitter API needs to be called using an OAuthorized twitter acc. This acc will be used for rate limiting, too. You may use any acc owned by you, an acc never used anywhere else for example in order to have a seperate rate limit for this plugin.');

@define('PLUGIN_EVENT_TWITTER_API_TYPE',                 'Twitter API Version');
@define('PLUGIN_EVENT_TWITTER_API_TYPE_DESC',            'Twitter API 1.0 is depreciated and will be closed 2013. So you should switch to API 1.1. But this requires to configure at least one OAuth connection (in the identities settings).');
@define('PLUGIN_EVENT_TWITTER_API_10',                   'API 1.0 [depreciated]');
@define('PLUGIN_EVENT_TWITTER_API_11',                   'API 1.1 OAuth');


