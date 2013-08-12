<?php # 

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_XMLRPC_NAME', 'Post via XML-RPC');
@define('PLUGIN_EVENT_XMLRPC_DESC', 'Allows to post/edit entries via the XML-RPC API (MT, Blogger, WordPress Endpoints)');
@define('PLUGIN_EVENT_XMLRPC_GMT', 'Use GMT time format');
@define('PLUGIN_EVENT_XMLRPC_DEFAULTCAT', 'Default category');
@define('PLUGIN_EVENT_XMLRPC_DEFAULTCAT_DESC', 'Specify the default category, when your blogging client specifies none.');

@define('PLUGIN_EVENT_XMLRPC_DOC_RPCLINK','<b>For your information:</b><br/>This blog has an URL where XMLRPC calls are handled. More modern clients are able to detect this RPC URL automatically from your blog URL, but for some older clients you have to tell them the RPC URL explicitly.<br/>Your XML-RPC URL is: <b>%s</b><br/>');

@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG', 'Debug log');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_DESC', 'If you are interested in what the XML-RPC interface is receiving and responding, switch on the debug log. The logfile is written as rpc.log in the plugins directory.'); // "debug" will produce output not readable by clients! It\'s only for debugging problems, so please don\'t use it in production environment.');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_NONE', 'disabled');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_NORMAL', 'enabled');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_VERBOSE', 'debug: Don\'t use for clients!');

@define('PLUGIN_EVENT_XMLRPC_WPFAKEVERSION', 'Fake WordPress version');
@define('PLUGIN_EVENT_XMLRPC_WPFAKEVERSION_DESC', 'This XML-RPC interface is able to respond to WordPress type calls. Normally, if asked for the software used, it answers with Serendipity ' . $serendipity['version'] .'. But if you enter a version here, it will response as WordPress (version entered). Some clients might check, if the WP version is high enough, so a version like 3.2 would be okay here.');
@define('PLUGIN_EVENT_XMLRPC_HTMLCONVERT', 'Convert plaintext articles to HTML');
@define('PLUGIN_EVENT_XMLRPC_HTMLCONVERT_DESC', 'The plugin tries to detect plain text delivered as article body and if detected converts its linefeeds to HTML. If you use plugins like the textile or nl2br textformats for articles you should disable this.');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR', 'Comments author from login');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_DESC', 'Some clients post a comment with a generic author name like \'from WordPress\'. If this option is enabled, the author name will always be the name of the logged in user.');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_DEFAULT', 'Don\'t patch author');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_LOGIN', 'Use login name as author');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_REALNAME', 'Use real name as author');
@define('PLUGIN_EVENT_XMLRPC_UPLOADDIR', 'Upload directory');
@define('PLUGIN_EVENT_XMLRPC_UPLOADDIR_DESC', 'If the clients uploads medias (i.e. images and videos) in what medialibrary directory should they be stored?');

@define('PLUGIN_EVENT_XMLRPC_EVENT_SPAM_HEADER', 	'<h3>Signal SPAM to AntiSpam plugins</h3>
This plugin is able to signal HAM and SPAM to AntiSpam plugins supporting these signals in order to make them react on it (learning i.e.).<br/>
Compare it with the Spam/Ham buttons in your comments list. 
The signals will be the same, as if you push these buttons in the admin interface.<br/>
As some clients don\'t have a seperate spam button but only approve and moderate, you are able to configure when these signals are emitted.<br/>
If you client doesn\'t support the Spam signal, you may want to signal SPAM everytime you moderate a comment.');
@define('PLUGIN_EVENT_XMLRPC_EVENT_SPAM', 			'Comment marked as SPAM');
@define('PLUGIN_EVENT_XMLRPC_EVENT_SPAM_DESC',		'The client marked the comment as SPAM');
@define('PLUGIN_EVENT_XMLRPC_EVENT_APPROVED',   	'Comment was approved');
@define('PLUGIN_EVENT_XMLRPC_EVENT_APPROVED_DESC',	'The client marked the comment as approved');
@define('PLUGIN_EVENT_XMLRPC_EVENT_PENDING', 		'Comment was moderated');
@define('PLUGIN_EVENT_XMLRPC_EVENT_PENDING_DESC',	'The client marked the comment as moderated');
@define('PLUGIN_EVENT_XMLRPC_EVENTVALUE_NONE', 	    'Do nothing SPAM related.');
@define('PLUGIN_EVENT_XMLRPC_EVENTVALUE_SPAM', 	    'Signal as SPAM.');
@define('PLUGIN_EVENT_XMLRPC_EVENTVALUE_HAM', 	    'Signal as HAM.');
