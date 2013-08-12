<?php # 

/**
 *  @version 
 *  @author Ivo Jansch <ivo@ibuildings.nl>
 *  NL-Revision: Revision of lang_nl.inc.php
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', 'Taggen van bijdragen');
@define('PLUGIN_EVENT_FREETAG_DESC', 'Maakt het mogelijk om bijdragen van tags te voorzien');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', 'Vul relevante tags in, meerdere tags kunnen met een komma worden gescheiden (,)');
@define('PLUGIN_EVENT_FREETAG_LIST', 'Tags voor deze bijdrage: %s');
@define('PLUGIN_EVENT_FREETAG_USING', 'Bijdragen met tag %s');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', 'Tags gerelateerd aan tag %s');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED','Geen gerelateerde tags.');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', 'Alle tags');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', 'Beheer tags');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', 'Beheer alle tags');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', 'Beheer \'leaf\' tags');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', 'Laat niet-getagde bijdragen zien');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', 'Laat \'leaf\' getagde bijdragen zien');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', 'Geen niet-getagde bijdragen!');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', 'Tag');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', 'Gewicht');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', 'Actie');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', 'Hernoem');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', 'Splits');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', 'Verwijder');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', 'Weet je zeker dat je de %s tag wil verwijderen?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'gebruik een komma om tags te scheiden:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', 'Toon tag cloud met gerelateerde tags?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER', 'Stuur X-FreeTag-HTTP-Headers?');
//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'Toon getagde bijdragen');
@define('PLUGIN_FREETAG_BLAHBLAH', 'Toon een "tag cloud" van gebruikte tags');
@define('PLUGIN_FREETAG_NEWLINE', 'Linefeed na elke tag?');
@define('PLUGIN_FREETAG_XML', 'Toon XML-icoon?');
@define('PLUGIN_FREETAG_SCALE','Lettergrootte obv populariteit (zoals Technorati, flickr)?');
@define('PLUGIN_FREETAG_UPGRADE1_2','Bijwerken van %d tags voor bijdrage: %d');
@define('PLUGIN_FREETAG_MAX_TAGS', 'Hoeveel tags maximaal tonen?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'Hoevaak moet een tag gebruikt zijn om getoond te worden?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'Minimaal font percentage van tag in tag cloud?');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'Maximaal font percentage van tag in tag cloud?');

@define('PLUGIN_FREETAG_META_KEYWORDS', 'Hoeveel meta keywords in HTML source invoegen? (0: uitgeschakeld)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Gerelateerde bijdragen op basis van tags:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED','Toon gerelateerde bijdragen obv tags?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT','Hoeveel gerelateerde bijdragen tonen?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', 'Tags in footer weergeven?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', 'Wanneer aktief, worden de tags in de footer van een bijdrage weergegeven. Wanneer niet aktief, worden de tags in de verkorte/uitgebreide bijdrage geplaatst.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', 'Tags altijd in kleine letters?');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS', 'Gerelateerde tags');
@define('PLUGIN_EVENT_FREETAG_TAGLINK', 'Taglink:');
