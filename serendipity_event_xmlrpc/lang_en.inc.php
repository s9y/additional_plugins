<?php # $Id$

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
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_DESC', 'If you are interested in what the XML-RPC interface is receiving and responding, switch on the debug log. The logfile is written as rpc.log in the plugins directory.');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_NONE', 'disabled');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_NORMAL', 'enabled');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_VERBOSE', 'verbose');

@define('PLUGIN_EVENT_XMLRPC_WPFAKEVERSION', 'Fake WordPress version');
@define('PLUGIN_EVENT_XMLRPC_WPFAKEVERSION_DESC', 'This XML-RPC interface is able to respond to WordPress type calls. Normally, if asked for the software used, it answers with Serendipity ' . $serendipity['version'] .'. But if you enter a version here, it will response as WordPress (version entered). Some clients might check, if the WP version is high enough, so a version like 3.2 would be okay here.');
