<?php # $Id: lang_en.inc.php,v 1.1 2006/08/16 04:49:13 elf2000 Exp $

/**
 *  @version $Revision: 1.1 $
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_SIDEBAR_MOTM_NAME', 'Music of the Moment');
@define('PLUGIN_SIDEBAR_MOTM_DESC', 'Real time music status from iTunes using iTunesBlogger: http://www.ituneshacking.com/wiki/wakka.php?wakka=iTunesBloggerHomePage');
@define('PLUGIN_SIDEBAR_MOTM_NOTE_WRAP', 'Please note, this is an event plugin and must either use the Event Output Wrapper, or a custom Sidebar to show sidebar list.');
@define('PLUGIN_SIDEBAR_MOTM_NOTE_KEY', 'Update URL in iTunesBlogger should look like: %s');
@define('PLUGIN_SIDEBAR_MOTM_TITLE_DESC', 'Sidebar Title');
@define('PLUGIN_SIDEBAR_MOTM_TITLE_URL', 'Title URL');
@define('PLUGIN_SIDEBAR_MOTM_TITLE_URL_SUGGESTION', 'http://www.audioscrobbler.com/');
@define('PLUGIN_SIDEBAR_MOTM_TITLE_URL_DESC', 'Make the title a link to this url (optional).');
@define('PLUGIN_SIDEBAR_MOTM_KEY', 'Secret key');
@define('PLUGIN_SIDEBAR_MOTM_KEY_DESC', 'Secret key for Update URL in iTunesBlogger.');
@define('PLUGIN_SIDEBAR_MOTM_KEY_KEY', 'SECRET_KEY');
@define('PLUGIN_SIDEBAR_MOTM_TRACK', 'Track Style');
@define('PLUGIN_SIDEBAR_MOTM_TRACK_DESC', 'Custom Track Style');
@define('PLUGIN_SIDEBAR_MOTM_SLIDER', 'Progress Bar Style');
@define('PLUGIN_SIDEBAR_MOTM_SLIDER_DESC', 'Custom Progress Bar Style');

@define('PLUGIN_SIDEBAR_MOTM_AMAZON_ASSOC', 'Amazon Associates ID');
@define('PLUGIN_SIDEBAR_MOTM_AMAZON_ASSOC_URL', 'http://www.amazon.com/gp/browse.html/002-3907068-8680056?node=3435371');
@define('PLUGIN_SIDEBAR_MOTM_AMAZON_ASSOC_DESC', 'Amazon Associates ID.  If you are unsure, just use default.  More info here: '.PLUGIN_SIDEBAR_MOTM_AMAZON_ASSOC_URL);
@define('PLUGIN_SIDEBAR_MOTM_AMAZON_DEV', 'Amazon Developer Key');
@define('PLUGIN_SIDEBAR_MOTM_AMAZON_DEV_URL', 'https://associates.amazon.com/gp/associates/login/login.html/002-3907068-8680056');
@define('PLUGIN_SIDEBAR_MOTM_AMAZON_DEV_DESC', 'Amazon Web Services Developer Key.  If you are unsure, just use default.  More info here: '.PLUGIN_SIDEBAR_MOTM_AMAZON_DEV_URL);
@define('PLUGIN_SIDEBAR_MOTM_UPDATE_ERROR_KEY',"Wrong secret key set in iTunesBlogger update url.");

@define('PLUGIN_SIDEBAR_MOTM_IFRAME_STREAMING',"Currently Streaming:");
@define('PLUGIN_SIDEBAR_MOTM_IFRAME_RECENT',"Recently listened to:");
@define('PLUGIN_SIDEBAR_MOTM_IFRAME_CURRENT',"Currently listening to:");
@define('PLUGIN_SIDEBAR_MOTM_IFRAME_FROM',"from");

@define('PLUGIN_SIDEBAR_MOTM_ADMIN_LINK',"Manage MOTM Streams");
@define('PLUGIN_SIDEBAR_MOTM_NOTE_EXTRA', 'Extra configuration in Entries -> '.PLUGIN_SIDEBAR_MOTM_ADMIN_LINK.' in the Admin Suite.');
@define('PLUGIN_SIDEBAR_MOTM_ADMIN_ADD',"Add a stream:");
@define('PLUGIN_SIDEBAR_MOTM_ADMIN_ADD_MATCH',"String in stream name to match");
@define('PLUGIN_SIDEBAR_MOTM_ADMIN_ADD_NAME',"Stream name<br>(if empty defaults to iTunes stream name)");
@define('PLUGIN_SIDEBAR_MOTM_ADMIN_ADD_URL',"Stream URL");
@define('PLUGIN_SIDEBAR_MOTM_ADMIN_ADD_WS_NAME',"Stream website name (optional)");
@define('PLUGIN_SIDEBAR_MOTM_ADMIN_ADD_WS_URL',"Stream website url (optional)");
@define('PLUGIN_SIDEBAR_MOTM_ADMIN_ADD_SUBMIT',"Add");  
@define('PLUGIN_SIDEBAR_MOTM_ADMIN_DISPLAY',"Manage streams:");
@define('PLUGIN_SIDEBAR_MOTM_ADMIN_DISPLAY_STREAM',"Stream");
@define('PLUGIN_SIDEBAR_MOTM_ADMIN_DISPLAY_ACTION',"Action");
@define('PLUGIN_SIDEBAR_MOTM_ADMIN_DISPLAY_EDIT',"Edit");
@define('PLUGIN_SIDEBAR_MOTM_ADMIN_DISPLAY_DELETE',"Delete");
@define('PLUGIN_SIDEBAR_MOTM_ADMIN_EDIT',"Edit stream:");
@define('PLUGIN_SIDEBAR_MOTM_ADMIN_CANCEL',"Cancel");
@define('PLUGIN_SIDEBAR_MOTM_ADMIN_DELETE',"Are you sure you want to delete");

?>
