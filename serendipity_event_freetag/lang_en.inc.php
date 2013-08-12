<?php # 

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', 'Tagging of entries');
@define('PLUGIN_EVENT_FREETAG_DESC', 'Allows freestyle tagging of entries');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', 'Enter any tags that apply. Seperate multiple tags with a comma (,)');
@define('PLUGIN_EVENT_FREETAG_LIST', 'Defined tags for this entry: %s');
@define('PLUGIN_EVENT_FREETAG_USING', 'Entries tagged as %s');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', 'Tags related to tag %s');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED','No related tags.');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', 'All defined Tags');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', 'Manage Tags');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', 'Manage All Tags');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', 'Manage \'Leaf\' Tags');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', 'List Untagged Entries');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', 'List \'Leaf\' Tagged Entries');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP', 'Cleanup entry-to-tag mappings');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_INFO', 'The following list contains tags non-existent entries are assigned to. Please click on &quot;Cleanup&quot; to remove these unnecessary assignments.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_NOTHING', 'No Tags assigned to non-existent entries could be found. Therefor there is nothing to clean up.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_LOOKUP_ERROR', 'Tags assigned to non-existent entries could be found, because an error occured.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_PERFORM', 'Cleanup');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_ENTRIES', 'IDs of affected entries');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_SUCCESSFUL', 'All unnecessary assignments have successfully been removed.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_FAILED', 'Removing unnecessary assignments failed.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', 'No Untagged entries!');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', 'Tag');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', 'Weight');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', 'Action');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', 'Rename');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', 'Split');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', 'Delete');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', 'Do you really want to delete the %s tag?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'use a comma to seperate tags:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', 'Show tag cloud to related tags?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER', 'Send X-FreeTag-HTTP-Headers');
@define('PLUGIN_EVENT_FREETAG_ADMIN_TAGLIST', 'Show clickable list of all tags when writing an entry');
@define('PLUGIN_EVENT_FREETAG_ADMIN_FTAYT', 'Activate Find-tags-as-you-type');

//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'Show tagged entries');
@define('PLUGIN_FREETAG_BLAHBLAH', 'Shows a list of existing tags for entries');
@define('PLUGIN_FREETAG_NEWLINE', 'Linefeed after each Tag?');
@define('PLUGIN_FREETAG_XML', 'Show XML-icons?');
@define('PLUGIN_FREETAG_SCALE','Scale tag font size depending on popularity (like Technorati, flickr)?');
@define('PLUGIN_FREETAG_UPGRADE1_2','Upgrading %d tags for entry number: %d');
@define('PLUGIN_FREETAG_MAX_TAGS', 'How many tags should be shown?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'How many occurences must a tag have in order to be shown?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'Minimum font size % of tag in tag cloud');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'Maximum font size % of tag in tag cloud');

@define('PLUGIN_EVENT_FREETAG_USE_FLASH', 'Use Flash to display the tag cloud?');
@define('PLUGIN_EVENT_FREETAG_FLASH_TAG_COLOR', 'Flash tag color (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_FLASH_TRANSPARENT', 'Make flash tag cloud background transparent?');
@define('PLUGIN_EVENT_FREETAG_FLASH_BG_COLOR', 'Flash tag cloud background color (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_FLASH_WIDTH', 'Flash tag cloud width');
@define('PLUGIN_EVENT_FREETAG_FLASH_SPEED', 'Flash tag cloud motion speed');


@define('PLUGIN_FREETAG_META_KEYWORDS', 'Number of meta keywords to embed in HTML source (0: disabled)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Related entries by tags:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED','Display related entries by tags?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT','How many related entries should be dislayed?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', 'Show tags in footer?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', 'If enabled, the tags will be shown in the footer of an entry. If disabled, the tags will be put inside the body/extended part of your entries.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', 'Lowercase tags');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS', 'Related tags');
@define('PLUGIN_EVENT_FREETAG_TAGLINK', 'Taglink');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG', 'Create tags for all associated categories?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC', 'If enabled, all categories that an entry is assigned to will be added as tags to your entry. You can set all category associations of all your existing entries within the "Manage Tags" menu of your Administration Suite.');
@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG', 'Create tags from automatted keywords?');
@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG_DESC', 'If enabled, the entry will be checked if it contains any of the automatted keywords and the corresponding tags will be added. You can set the keywords within the "Manage Tags" menu of your Administration Suite.');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE', 'Sidebar template');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE_DESCRIPTION', 'If set the template is used to render the tag sidebar. In the template there is a variable <tags> available which contains the list of tags in the format <tagName> => array(href => <tagLink>, count => <tagCount>)');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS', 'Convert all assigned categories of existing entries to tags');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY', 'Converted categories of entry #%d (%s): %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG', 'All categories converted to tags.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS', 'Automatted keywords');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC', 'You can assign keywords (separated by ",") for each tag. Whenever you use those keywords in the text of your entries, the corresponding tag is assigned to your entry. Note that many automatted keywords may increase the time taken for saving an entry.');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD', 'Found keyword <strong>%s</strong>, tag <strong><em>%s</em></strong> assigned automatically.<br />');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO', 'Fetching entries %d to %d');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL', ' (totalling %d entries)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT', 'Fetching next batch of entries...');
@define('PLUGIN_EVENT_FREETAG_REBUILD', 'Reparse all automatted keywords');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC', 'Warning: This function will fetch and re-save every single one of your entries. This will take some time, and it might even damage existing articles. It is suggested you first backup your database! Click on "CANCEL" to abort this action.');

@define('PLUGIN_EVENT_FREETAG_ORDER_TAGNAME', 'Tag name');
@define('PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT', 'Tag count');

@define('PLUGIN_EVENT_FREETAG_TECHNORATI_TAGLINK',      'Technorati tag links');
@define('PLUGIN_EVENT_FREETAG_TECHNORATI_TAGLINK_DESC', 'Adds technorati tag links behind the tags in the entry footer. Clicking them will show similair articles in other blogs found on technorati.');

@define('PLUGIN_EVENT_FREETAG_TECHNORATI_TAGLINK_IMG',      'Technorati tag image');

@define('PLUGIN_EVENT_FREETAG_XMLIMAGE',    'XML image relative to template path');

@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC2', 'If set to "Smarty", then a smarty variable {$entry.freetag} will be created that you can place anywhere in your entries.tpl template file.');

@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY', 'Extended Smarty');
@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY_DESC', 'Emit seperate Smarty-variables for later use in a template. This will override the other settings. An example for later use can be found in the Readme.');

@define('PLUGIN_EVENT_FREETAG_COLLATION', '(MySQL) Database collation for the entrytags.tag column (auto-detected)');
@define('PLUGIN_EVENT_FREETAG_KILL', 'When checked, all assigned tags to this entry will be removed.');
