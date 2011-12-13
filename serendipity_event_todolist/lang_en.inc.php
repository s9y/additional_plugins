<?php # $Id: lang_en.inc.php,v 1.2 2005/11/16 08:41:50 elf2000 Exp $

/**
 *  @version $Revision: 1.2 $
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_TODOLIST_TITLE', 'ToDo/Project-List');
@define('PLUGIN_EVENT_TODOLIST_DESC', 'Maintain a list of projects and their percentage completion.');
@define('PLUGIN_EVENT_TODOLIST_PROJECT', 'Project');
@define('PLUGIN_EVENT_TODOLIST_PROJECT_NAME', 'Name');
@define('PLUGIN_EVENT_TODOLIST_HIDDEN', 'Hide');
@define('PLUGIN_EVENT_TODOLIST_PERCENTDONE', '% Done');
@define('PLUGIN_EVENT_TODOLIST_BLOGENTRY', 'Blog Entry');
@define('PLUGIN_EVENT_TODOLIST_ADMINPROJECT', 'Manage Projects');
@define('PLUGIN_EVENT_TODOLIST_ORDER', 'Order projects by:');
@define('PLUGIN_EVENT_TODOLIST_ORDER_DESC', 'Choose how to order the projects for display.');
@define('PLUGIN_EVENT_TODOLIST_ORDER_NUM_ORDER', 'Custom');
@define('PLUGIN_EVENT_TODOLIST_ORDER_DATE_ACS', 'Date (Oldest to Newest)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_DATE_DESC', 'Date (Newest to Oldest)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_PROGRESS_ASC', 'Progress (least complete at top)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_PROGRESS_DESC', 'Progress (most complete at top)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_CATEGORY', 'Categorically');
@define('PLUGIN_EVENT_TODOLIST_ORDER_JSCATEGORY', 'Categorically, with Javascript');
@define('PLUGIN_EVENT_TODOLIST_ORDER_ALPHA', 'Alphabetically');
@define('PLUGIN_EVENT_TODOLIST_PROJECTS', 'Manage Projects');
@define('PLUGIN_EVENT_TODOLIST_NOPROJECTS', 'No PROJECTS in List');
@define('PLUGIN_EVENT_TODOLIST_TITLEDESC','The title of the plugin. The value is passed to sidebar wrapper.');
@define('PLUGIN_EVENT_TODOLIST_COLOR1', 'Inside Color');
@define('PLUGIN_EVENT_TODOLIST_COLOR2', 'Outside Color');
@define('PLUGIN_EVENT_TODOLIST_COLORCONFIG', 'Default progress bar color');
@define('PLUGIN_EVENT_TODOLIST_COLORCONFIGDESC', 'Pick default color of progress bars.  You can add to or modify these colors from the "Manage Colors" page.  This will only be effective if you have the PHP GD libraries installed.');
@define('PLUGIN_EVENT_TODOLIST_BACKGROUNDCOLOR', 'Background color of progress bar');
@define('PLUGIN_EVENT_TODOLIST_BACKGROUNDCOLORDESC', 'Enter a 6 digit hexadecimal color code for the background of the progress bars.  Use FFFFFF for white.  This will only be effective if you have the PHP GD libraries installed.');
@define('PLUGIN_EVENT_TODOLIST_WHITETEXTBORDER', 'Outline text in white');
@define('PLUGIN_EVENT_TODOLIST_WHITETEXTBORDERDESC', 'You may want to outline the text of the progress bar in white if your color bars are dark and obscure the text.');
@define('PLUGIN_EVENT_TODOLIST_OUTSIDETEXT', 'Place text outside of progress bar.');
@define('PLUGIN_EVENT_TODOLIST_OUTSIDETEXTDESC', 'This option will write the progress percentage to the right of the progress bar instead of in the middle of the progress bar.');
@define('PLUGIN_EVENT_TODOLIST_BARLENGTH', 'Length of Progress Bar');
@define('PLUGIN_EVENT_TODOLIST_BARLENGTHDESC', 'Length of progress bar in pixels when the bars are not sorted categorically.  This option requires the GD libraries.');
@define('PLUGIN_EVENT_TODOLIST_BARHEIGHT', 'Height of Progress Bar');
@define('PLUGIN_EVENT_TODOLIST_BARHEIGHTDESC', 'Height of progress bar in pixels.  This option requires the GD libraries.');
@define('PLUGIN_EVENT_TODOLIST_FONTSIZE', 'Font size');
@define('PLUGIN_EVENT_TODOLIST_FONTSIZEDESC', 'Font size in pixels.  This option requires the GD libraries.');
@define('PLUGIN_EVENT_TODOLIST_FONT', 'Font');
@define('PLUGIN_EVENT_TODOLIST_FONTDESC', 'Pick a font for the progress bar text.  You can add additional fonts in the '.dirname(__FILE__).'/fonts/ directory.  The fonts must be TrueType fonts.  This option requires the GD libraries.');
@define('PLUGIN_EVENT_TODOLIST_CATBARLENGTH', 'Length of Progress Bar (categorical sort)');
@define('PLUGIN_EVENT_TODOLIST_CATBARLENGTHDESC', 'Length of progress bar in pixels when the bars are sorted categorically.  You may want this to be shorter because of the room taken up by hierarchical categories.  This option requires the GD libraries.');
@define('PLUGIN_EVENT_TODOLIST_CACHEIMAGE', 'Cache generated graphics');
@define('PLUGIN_EVENT_TODOLIST_CACHEIMAGEDESC', 'Cache a copy of all generated progress bar graphics and serve them up statically.  This will result in faster load times for clients, and reduced load on your server.  This option requires the GD libraries.');
@define('PLUGIN_EVENT_TODOLIST_NUMENTRIES', 'Number of blog entries to display');
@define('PLUGIN_EVENT_TODOLIST_NUMENTRIESDESC', 'Show this many recent blog entries when selecting a blog entry to link to from a given project progress bar.');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY', 'Use categories');
@define('PLUGIN_EVENT_TODOLIST_CATEGORYDESC','Use categories to organize projects.');
@define('PLUGIN_EVENT_TODOLIST_ADDPROJECT','Add a Project');
@define('PLUGIN_EVENT_TODOLIST_EDITPROJECT','Edit a Project');
@define('PLUGIN_EVENT_TODOLIST_PERCENTAGECOMPLETE','Percentage of Project Completed');
@define('PLUGIN_EVENT_TODOLIST_PROJECTDESC','Description of Project');
@define('PLUGIN_EVENT_TODOLIST_DEFAULT_NOTE','Please note, this is an event plugin and must either use the Event Output Wrapper, or a custom Sidebar to show sidebar list.');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME','Category system to use:');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_DESC','You can choose to use the blog category system, or the custom categories provided with this plugin.');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_CUSTOM','Custom');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_DEFAULT','Default');
@define('PLUGIN_EVENT_TODOLIST_CATDB_WARNING','You are configured to use custom categories, but the category database does not exist. Please click here to create the database.');
@define('PLUGIN_EVENT_TODOLIST_ADD_CAT','Manage categories');
@define('PLUGIN_EVENT_TODOLIST_ADD_COLOR','Add a Color');
@define('PLUGIN_EVENT_TODOLIST_MANAGE_COLORS','Manage Colors');
@define('PLUGIN_EVENT_TODOLIST_CAT_NAME','Category Name');
@define('PLUGIN_EVENT_TODOLIST_PARENT_CATEGORY','Parent Category');
@define('PLUGIN_EVENT_TODOLIST_ADMINCAT','Administer Categories');
@define('PLUGIN_EVENT_TODOLIST_CACHE_NAME','Cache sidebar');
@define('PLUGIN_EVENT_TODOLIST_CACHE_DESC','Caching the sidebar results increases the speed of your page.');
@define('PLUGIN_EVENT_TODOLIST_NOGDLIB', 'It appears that you do not have the PHP GD libraries installed.  Static images have been provided on the 5% marks, so completion rates will be rounded down to the nearest 5% mark.');
@define('PLUGIN_EVENT_TODOLIST_ADDCOLOR_NAME', 'Color name (used in dropdown boxes)');
@define('PLUGIN_EVENT_TODOLIST_ADDCOLOR_COLOR1', 'Color of inside of bar (hex color like ff3333).  You might prefer a lighter color for the inside of the bar.');
@define('PLUGIN_EVENT_TODOLIST_ADDCOLOR_COLOR2', 'Color of outside of bar (hex color like ff3333)');
@define('PLUGIN_EVENT_TODOLIST_COLOR', 'Color');
@define('PLUGIN_EVENT_TODOLIST_SAMPLE', 'Sample');
@define('PLUGIN_EVENT_TODOLIST_COLORWHEEL', 'Color Wheel');
@define('PLUGIN_EVENT_TODOLIST_COLORWHEEL_INSTRUCTIONS', 'Hover over the color wheel or hue square to view colors.  Click to choose a color.  Copy and Paste six digit color codes into color manager fields.');

?>
