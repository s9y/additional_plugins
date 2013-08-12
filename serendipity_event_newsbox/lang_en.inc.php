<?php # 

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_NEWSBOX_TITLE', 'Newsbox');
@define('PLUGIN_EVENT_NEWSBOX_DESC', 'Group a category\'s entries in a frontpage box instead of the usual article listing.  Supports nested newsboxes.');
@define('PLUGIN_EVENT_NEWSBOX_TITLEFIELD', 'Title');
@define('PLUGIN_EVENT_NEWSBOX_TITLEFIELD_DESC', 'Enter a title to be displayed for this newsbox');
@define('PLUGIN_EVENT_NEWSBOX_DEFAULT_TITLE', 'News');
@define('PLUGIN_EVENT_NEWSBOX_CONTENTTYPE', 'What goes in this newsbox?');
@define('PLUGIN_EVENT_NEWSBOX_CONTENTTYPE_DESC', 'This newsbox may contain categories or other newsboxes.  Not both.');
@define('PLUGIN_EVENT_NEWSBOX_NEWSCATS', 'Which categories will this newsbox contain?');
@define('PLUGIN_EVENT_NEWSBOX_NEWSCATS_DESC', 'If you decided this newsbox should contain categories, you can select them here.  You may select multiple categories.  Their entries will be removed from the entry listing, and added to this newsbox.');
@define('PLUGIN_EVENT_NEWSBOX_NUMENTRIES', 'Number of Entries');
@define('PLUGIN_EVENT_NEWSBOX_NUMENTRIES_DESC', 'If you decided this newsbox should contain categories, you should enter the maximum number of entries to show here.');
@define('PLUGIN_EVENT_NEWSBOX_PLACEMENT', 'Placement');
@define('PLUGIN_EVENT_NEWSBOX_PLACEMENT_DESC', 'Where will this newsbox be placed?  You may place the newsbox at the top or bottom of the entries, in the page header, in the page footer, in another newsbox, or hidden altogether.  Hidden newsboxes do not display at all.  Containers that contain themselves never display, either.  In templates that don\'t understand newsboxes, this CSS can look ugly if the newsbox is placed anywhere other than the top of the entries.');
@define('PLUGIN_EVENT_NEWSBOX_PLACEMENT_PAGE_TOP', 'In page header');
@define('PLUGIN_EVENT_NEWSBOX_PLACEMENT_ENTRY_TOP', 'Top of entries');
@define('PLUGIN_EVENT_NEWSBOX_PLACEMENT_ENTRY_BOTTOM', 'Bottom of entries');
@define('PLUGIN_EVENT_NEWSBOX_PLACEMENT_PAGE_BOTTOM', 'In page footer');
@define('PLUGIN_EVENT_NEWSBOX_PLACEMENT_HIDDEN', '*HIDDEN*');

?>
