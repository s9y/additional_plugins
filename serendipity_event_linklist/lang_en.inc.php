<?php # $Id: lang_en.inc.php,v 1.9 2008/03/06 04:33:00 mgroeninger Exp $

/**
 *  @version $Revision: 1.9 $
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_linklist.php
//
@define('PLUGIN_LINKLIST_TITLE', 'Link List');
@define('PLUGIN_LINKLIST_DESC', 'Links manager - Shows your favorite links in the sidebar.');
@define('PLUGIN_LINKLIST_LINK', 'Link');
@define('PLUGIN_LINKLIST_LINK_NAME', 'Name');
@define('PLUGIN_LINKLIST_ADMINLINK', 'Manage Links');
@define('PLUGIN_LINKLIST_ORDER', 'Order links by:');
@define('PLUGIN_LINKLIST_ORDER_DESC', 'Choose how to order the links for display.');
@define('PLUGIN_LINKLIST_ORDER_NUM_ORDER', 'Custom');
@define('PLUGIN_LINKLIST_ORDER_DATE_ACS', 'Date (Oldest to Newest)');
@define('PLUGIN_LINKLIST_ORDER_DATE_DESC', 'Date (Newest to Oldest)');
@define('PLUGIN_LINKLIST_ORDER_CATEGORY', 'Categorically');
@define('PLUGIN_LINKLIST_ORDER_ALPHA', 'Alphabetically');
@define('PLUGIN_LINKLIST_LINKS', 'Manage Links');
@define('PLUGIN_LINKLIST_NOLINKS', 'No Links in List');
@define('PLUGIN_LINKLIST_CATEGORY', 'Use categories');
@define('PLUGIN_LINKLIST_CATEGORYDESC','Use categories to organize links.');
@define('PLUGIN_LINKLIST_ADDLINK','Add a Link');
@define('PLUGIN_LINKLIST_LINK_EXAMPLE','Example: http://www.s9y.org or http://www.s9y.org/forums/');
@define('PLUGIN_LINKLIST_EDITLINK','Edit a Link');
@define('PLUGIN_LINKLIST_LINKDESC','Description of Link');
@define('PLUGIN_LINKLIST_CATEGORY_NAME','Category system to use:');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DESC','You can choose to use the blog category system, or the custom categories provided with this plugin.');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_CUSTOM','Custom');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DEFAULT','Default');
@define('PLUGIN_LINKLIST_ADD_CAT','Manage categories');
@define('PLUGIN_LINKLIST_CAT_NAME','Category Name');
@define('PLUGIN_LINKLIST_PARENT_CATEGORY','Parent Category');
@define('PLUGIN_LINKLIST_ADMINCAT','Administer Categories');
@define('PLUGIN_LINKLIST_CACHE_NAME','Cache sidebar');
@define('PLUGIN_LINKLIST_CACHE_DESC','Caching the sidebar results increases the speed of your page.  To clear cache for troubleshooting purposes turn it off and then back on.');
@define('PLUGIN_LINKLIST_ENABLED_NAME','Enabled');
@define('PLUGIN_LINKLIST_ENABLED_DESC','Enable the plugin.');
@define('PLUGIN_LINKLIST_DELETE_WARN','When a category is deleted all its entries will be moved to the root category.');

//
//  serendipity_plugin_linklist.php
//
@define('PLUGIN_LINKS_NAME', 'Link List');
@define('PLUGIN_LINKS_BLAHBLAH', 'Links manager - Shows your favorite links in the sidebar.');
@define('PLUGIN_LINKS_TITLE', 'Title');
@define('PLUGIN_LINKS_TITLE_BLAHBLAH', 'Type title of links here');
@define('PLUGIN_LINKS_TOP_LEVEL', 'Top Level Text');
@define('PLUGIN_LINKS_TOP_LEVEL_BLAHBLAH', 'Type any text you wish to appear on the top level here (it may be left blank)');
@define('PLUGIN_LINKS_DIRECTXML', 'Enter XML directly');
@define('PLUGIN_LINKS_DIRECTXML_BLAHBLAH', 'You may enter xml data directly or use a webpage to manage links');
@define('PLUGIN_LINKS_LINKS', 'Links');
@define('PLUGIN_LINKS_LINKS_BLAHBLAH', 'use XML!! - for directories use "<dir name="dirname"> and close with </dir> - for links use "<link name="linkname" link="http://link.com/" />');
@define('PLUGIN_LINKS_OPENALL', 'Open All text');
@define('PLUGIN_LINKS_OPENALL_BLAHBLAH', 'Enter the string for "Open All" link');
@define('PLUGIN_LINKS_OPENALL_DEFAULT', 'Open All');
@define('PLUGIN_LINKS_CLOSEALL', 'Close All text');
@define('PLUGIN_LINKS_CLOSEALL_BLAHBLAH', 'Enter the string for "Close All" link');
@define('PLUGIN_LINKS_CLOSEALL_DEFAULT', 'Close All');
@define('PLUGIN_LINKS_SHOW', 'Show Open and Close links');
@define('PLUGIN_LINKS_SHOW_BLAHBLAH', 'Do you want to see "open all" and "close all" links?');
@define('PLUGIN_LINKS_LOCATION', 'Location of Open and Close links');
@define('PLUGIN_LINKS_LOCATION_BLAHBLAH', 'Location of "open all" and "close all" links');
@define('PLUGIN_LINKS_LOCATION_TOP', 'Top');
@define('PLUGIN_LINKS_LOCATION_BOTTOM', 'Bottom');
@define('PLUGIN_LINKS_SELECTION', 'Use selection');
@define('PLUGIN_LINKS_SELECTION_BLAHBLAH', 'If you say TRUE, nodes can be selected(highlighted)');
@define('PLUGIN_LINKS_COOKIE', 'Use cookies');
@define('PLUGIN_LINKS_COOKIE_BLAHBLAH', 'If you say TRUE, the tree uses cookies to remember it\'s state');
@define('PLUGIN_LINKS_LINE', 'Use lines');
@define('PLUGIN_LINKS_LINE_BLAHBLAH', 'If you say TRUE, tree is drawn with lines');
@define('PLUGIN_LINKS_ICON', 'Use icons');
@define('PLUGIN_LINKS_ICON_BLAHBLAH', 'If you say TRUE, tree is drawn with icons');
@define('PLUGIN_LINKS_STATUS', 'Use status text');
@define('PLUGIN_LINKS_STATUS_BLAHBLAH', 'If you say TRUE, displays node names in the statusbar instead of the url');
@define('PLUGIN_LINKS_CLOSELEVEL', 'Close same level');
@define('PLUGIN_LINKS_CLOSELEVEL_BLAHBLAH', 'If you say TRUE, only one node within a parent can be expanded at the same time. "open all" and "close all" do not work when this is enabled');
@define('PLUGIN_LINKS_TARGET', 'Target');
@define('PLUGIN_LINKS_TARGET_BLAHBLAH', 'Target for the links - could be "_blank", "_self", "_top", "_parent" or name of a frame');
@define('PLUGIN_LINKS_IMGDIR', 'Use plugin image directory');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH', 'If set to "yes" the plugin will assume images will be in the plugins folder. If set to "no" the plugin will point image paths to "/templates/default/img/". Turning plugin image path off is necessary for shared installs, but will require the images be moved manually');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME', 'Category tree open or closed');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_DESC', 'When using the "categorical" order by, the links will default to which ever option is selected');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_CLOSED', 'Closed');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_OPEN', 'Open');
@define('PLUGIN_LINKLIST_OUTSTYLE_DTREE', 'dtree');
@define('PLUGIN_LINKLIST_OUTSTYLE_CSS', 'CSS List');
@define('PLUGIN_LINKLIST_ORDER_OUTSTYLE_SIMP_CSS', 'Simple CSS');
@define('PLUGIN_LINKS_OUTSTYLE', 'Choose the output style for the linklist');
@define('PLUGIN_LINKS_OUTSTYLE_BLAHBLAH', 'Choose the output style for the linklist.  Dtree output uses javascript to render a cross-browser tree view.  CSS list uses CSS divs and a simple javascript to replicate the dtree view, but does not support all the features of dtree.  Simple CSS will output a simple CSS controlled list, which enables tight control over the presentation of links.  Note that dtree is not typically parsable by search engines.');
@define('PLUGIN_LINKS_CALLMARKUP', 'Apply markup?');
@define('PLUGIN_LINKS_CALLMARKUP_BLAHBLAH', 'Choose to apply markup to the linklist output.  This will apply all markup which is applied to HTML Nugget.');
@define('PLUGIN_LINKS_USEDESC','Use the given description');
@define('PLUGIN_LINKS_USEDESC_BLAHBLAH','Use the description for the link title if it is available.');
@define('PLUGIN_LINKS_PREPEND','Enter any text to be shown before the list of links.');
@define('PLUGIN_LINKS_APPEND','Enter any text to be shown after the list of links.');
?>
