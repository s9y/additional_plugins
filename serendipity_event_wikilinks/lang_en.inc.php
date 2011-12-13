<?php # $Id: lang_en.inc.php,v 1.5 2007/07/09 11:07:52 brockhaus Exp $

/**
 *  @version $Revision: 1.5 $
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_WIKILINKS_NAME', 'Free Wiki links for your entries');
@define('PLUGIN_EVENT_WIKILINKS_DESC', 'You can specify new/existing links to your blog entries via [[title]], link to staticpages via ((title)) and link to both via {{title}}.');
@define('PLUGIN_EVENT_WIKILINKS_IMGPATH', 'Path to images');
@define('PLUGIN_EVENT_WIKILINKS_IMGPATH_DESC', 'Enter the path to where the wikilink edit icons are located.');

@define('PLUGIN_EVENT_WIKILINKS_EDIT_INTERNAL', 'Edit blog entry');
@define('PLUGIN_EVENT_WIKILINKS_EDIT_STATICPAGE', 'Edit staticpage');
@define('PLUGIN_EVENT_WIKILINKS_CREATE_INTERNAL', 'Create blog entry');
@define('PLUGIN_EVENT_WIKILINKS_CREATE_STATICPAGE', 'Create staticpage');

@define('PLUGIN_EVENT_WIKILINKS_LINKENTRY', 'Link to entry');
@define('PLUGIN_EVENT_WIKILINKS_LINKENTRY_DESC', 'Please choose the entry you would like to link to.');

@define('PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_NAME', 'Create links to drafts?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_DESC', 'Should links to entries be created, even if they are still at draft state?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_NAME', 'Create links to future entries?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_DESK', 'Should links to entries be created, even if they are still dated in the future?');
