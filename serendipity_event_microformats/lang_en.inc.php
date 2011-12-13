<?php # $Id: lang_en.inc.php,v 1.3 2008/06/17 18:01:31 slothman Exp $

/**
 *  @version $Revision: 1.3 $
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_MICROFORMATS_TITLE', 'Microformats');
@define('PLUGIN_EVENT_MICROFORMATS_DESC', 'This plugin provides an easy way to publish reviews (or events); it supports the respective microformats.');

@define('PLUGIN_EVENT_MICROFORMATS_TYPES', 'Type of entry');
@define('PLUGIN_EVENT_MICROFORMATS_TYPES_DESC', 'What kind of entry do you want to publish, e.g. review, event?');

@define('PLUGIN_EVENT_MICROFORMATS_TYPES_HREVIEW', 'Review');
@define('PLUGIN_EVENT_MICROFORMATS_TYPES_HCALENDAR', 'Event');

@define('PLUGIN_EVENT_MICROFORMATS_ID', 'ID');
@define('PLUGIN_EVENT_MICROFORMATS_RATING', 'Rating');

@define('PLUGIN_EVENT_MICROFORMATS_SB_SUBNODE', 'Add subnode');
@define('PLUGIN_EVENT_MICROFORMATS_SB_SUBNODE_DESC', 'If a subnode is added to your entry, services that use structured blogging can read this; but your XHTML may be rendered invalid.');

@define('PLUGIN_MICROFORMATS_TITLE_N', 'Upcoming Events');
@define('PLUGIN_MICROFORMATS_TITLE_D', 'Display upcoming and recommended events in the sidebar and apply the hCalendar microformat to them.');

@define('PLUGIN_MICROFORMATS_DISPLAY_N', 'Sidebar Header');
@define('PLUGIN_MICROFORMATS_DISPLAY_D', 'This is the header of the sidebar block');

@define('PLUGIN_MICROFORMATS_SORT_N', 'Sort events by date');
@define('PLUGIN_MICROFORMATS_SORT_D', 'If set to yes, events will be sorted by date; otherwise the list will be displayed like you entered it.');

@define('PLUGIN_MICROFORMATS_PURGE_N', 'Remove events in the past');
@define('PLUGIN_MICROFORMATS_PURGE_D', 'Events that are over for more than x days will be removed from the list. Leave empty if you still want to display them.');

@define('PLUGIN_MICROFORMATS_ENTRIES_N', 'Include events from blog entries');
@define('PLUGIN_MICROFORMATS_ENTRIES_D', 'If you applied the hCalendar microformat to events in your blog postings, you can also display them in the sidebar.');

@define('PLUGIN_MICROFORMATS_ICONDISPLAY_N', 'Display CAL icon');
@define('PLUGIN_MICROFORMATS_ICONDISPLAY_D', 'Display a red CAL-Icon below the list of events.');

@define('PLUGIN_MICROFORMATS_TIMEZONE_N', 'Time zone');
@define('PLUGIN_MICROFORMATS_TIMEZONE_D', 'Time zone of the events (most probably the time zone of your blog, i.e. your own time zone).');

@define('PLUGIN_MICROFORMATS_EVENTLIST_XML_N', 'List of events');
@define('PLUGIN_MICROFORMATS_EVENTLIST_XML_D', 'Please use correct XML format (see below). You need to define at least "summary" and "dtstart".');

@define('PLUGIN_EVENT_MICROFORMATS_BEST_N', 'Maximum points');
@define('PLUGIN_EVENT_MICROFORMATS_BEST_D', '');

@define('PLUGIN_EVENT_MICROFORMATS_STEP_N', 'Steps');
@define('PLUGIN_EVENT_MICROFORMATS_STEP_D', '');

@define('PLUGIN_EVENT_MICROFORMATS_PATH_N', 'Path to the scripts');
@define('PLUGIN_EVENT_MICROFORMATS_PATH_D', 'Enter the full HTTP path (everything after your domain name) that leads to this plugin\'s directory (example: /serendipity/plugins/serendipity_event_microformats).');

@define('PLUGIN_MICROFORMATS_EVENTLIST_XML_EXPLAIN', 'According to the definition of the hCalendar microformat (28.01.2007) a event entry is defined as follows: <p><code>&lt;events&gt;<br/>&lt;event summary="Football Worldcup 2010" location="South Africa" url="http://www.fifa.com/de/worldcup/index/0,3360,WF2010,00.html?comp=WF&year=2010" dtstart="20100611T1930" dtend="20100711T2000" description="Africa\'s Calling" /&gt;<br/>&lt;/events&gt;</code></p><p>You can also take a look at the <a href="http://blog.sperr-objekt.de/pages/microformats.html">documentation</a> that is currently in the process of being written.</p>');
