<?php # $Id$

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_staticpage.php
//
@define('STATICPAGE_HEADLINE', 'Headline');
@define('STATICPAGE_HEADLINE_BLAHBLAH', 'Shows a headline above the content which is rendered as every other headline in your blog');
@define('STATICPAGE_TITLE', 'Static Pages');
@define('STATICPAGE_TITLE_BLAHBLAH', 'Shows static pages inside your blog with your blogs design and all formattings. Adds a new menu item to the admin interface.');
@define('CONTENT_BLAHBLAH', 'the content');
@define('STATICPAGE_PERMALINK', 'Permalink');
@define('STATICPAGE_PERMALINK_BLAHBLAH', 'Defines a permalink for the URL. Needs the absolute HTTP path and needs to end with .htm or .html!');
@define('STATICPAGE_PAGETITLE', 'URL shorthand name (Backwards compatibility)');
@define('STATICPAGE_ARTICLEFORMAT', 'Format as article?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH', 'if yes the output is automatically formatted as an article (colors, borders, etc.) (default: yes)');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE', 'Page title in "Format as article" mode');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH', 'Using article format, you can choose which text to display where the blog DATE shows up for an article.');
@define('STATICPAGE_SELECT', 'Select a staticpage to edit or create.');
@define('STATICPAGE_PASSWORD_NOTICE', 'This page is password protected. Please enter the appropriate password given to you: ');
@define('STATICPAGE_PARENTPAGES_NAME', 'Parentpage');
@define('STATICPAGE_PARENTPAGE_DESC', 'Select the Parent-Page');
@define('STATICPAGE_PARENTPAGE_PARENT', 'Is parent');
@define('STATICPAGE_AUTHORS_NAME', 'Author\'s Name');
@define('STATICPAGE_AUTHORS_DESC', 'This author is the owner of this page');
@define('STATICPAGE_FILENAME_NAME', 'Template (Smarty)');
@define('STATICPAGE_FILENAME_DESC', 'Enter the filename of the template which should be used for this page. That smarty file can be placed in this plugin\'s directory or into your template directory.');
@define('STATICPAGE_SHOWCHILDPAGES_NAME', 'Show childpages');
@define('STATICPAGE_SHOWCHILDPAGES_DESC', 'Show all childpages of current page as linklist.');
@define('STATICPAGE_PRECONTENT_NAME', 'Pre-content');
@define('STATICPAGE_PRECONTENT_DESC', 'Show this content before list of childpages.');
@define('STATICPAGE_CANNOTDELETE_MSG', 'Can\'t delete this page. Childpages are in the database. Please delete them first.');
@define('STATICPAGE_IS_STARTPAGE', 'Make this page the frontpage of Serendipity');
@define('STATICPAGE_IS_STARTPAGE_DESC', 'Instead of showing the default Serendipity startpage, this static page will show up. Only define one page as frontpage! If you want to link to your usual Serendipity Frontpage, you need to use "index.php?frontpage". If you want to use this feature, you need to make sure that no other permalink-plugin (like voting, guestbook) are placed before the staticpage plugin in the Serendipity Plugin Configuration Event Queue.');
@define('STATICPAGE_IS_404_PAGE', 'Set this page as 404 error page');
@define('STATICPAGE_IS_404_PAGE_DESC', 'Instead of creating a special error document you can set this page as 404 error page. Your webserver also must be configured to use this!');
@define('STATICPAGE_TOP', 'TOP');
@define('STATICPAGE_NEXT', 'Next');
@define('STATICPAGE_PREV', 'Prev');
@define('STATICPAGE_LINKNAME', 'Edit');

@define('STATICPAGE_ARTICLETYPE', 'Article type');
@define('STATICPAGE_ARTICLETYPE_DESC', 'Select the type of this staticpage.');

@define('STATICPAGE_CATEGORY_PAGEORDER', 'Page order');
@define('STATICPAGE_CATEGORY_PAGES', 'Edit pages');
@define('STATICPAGE_CATEGORY_PAGETYPES', 'Page types');
@define('STATICPAGE_CATEGORY_PAGEADD', 'Other plugins');

@define('PAGETYPES_SELECT', 'Select a page type to select.');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION', 'Description:');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC', 'Describe the page type.');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE', 'Template name:');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC', 'The name from the template. It can be in the staticpage-plugin or in the default template-directory.');
@define('STATICPAGE_ARTICLETYPE_IMAGE', 'Image path:');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC', 'The URL to the image.');

@define('STATICPAGE_SHOWNAVI', 'Include navigation');
@define('STATICPAGE_SHOWNAVI_DESC', 'Show navigation within staticpages on this page.');
@define('STATICPAGE_SHOWONNAVI', 'Include in sidebar-navigation');
@define('STATICPAGE_SHOWONNAVI_DESC', 'Show this page on the list of static pages in your sidebar.');

@define('STATICPAGE_SHOWNAVI_DEFAULT', 'Include navigation');
@define('STATICPAGE_SHOWMETA_DEFAULT_DESC', ' - Please view additional note in the staticpage form!');
@define('STATICPAGE_SHOWMETA_DEFAULT', 'Include HTML meta input fields');
@define('STATICPAGE_SHOWMETA_DEFAULT_METANOTE', 'If enabled, please hover me to see on how to change your templates index.tpl file.');
@define('STATICPAGE_DEFAULT_DESC', 'Default setting for new pages.');
@define('STATICPAGE_SHOWONNAVI_DEFAULT', 'Show page on sidebar-navigation');
@define('STATICPAGE_SHOWMARKUP_DEFAULT', 'Show markup');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT', 'Format like an article');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT', 'Show childpages');

@define('STATICPAGE_PAGEORDER_DESC', 'Here you can change the order of static pages.');
@define('STATICPAGE_PAGEADD_DESC', 'Select the plugin you want to include as link in the staticpages navigation.');
@define('STATICPAGE_PAGEADD_PLUGINS', 'The following plugins can be included in the staticpage sidebar.');

@define('STATICPAGE_PUBLISHSTATUS', 'Publish-status');
@define('STATICPAGE_PUBLISHSTATUS_DESC', 'Publish-status of this page.');

@define('STATICPAGE_SHOWTEXTORHEADLINE_NAME', 'Show headline or Prev/Next on navigation');
@define('STATICPAGE_SHOWTEXTORHEADLINE_TEXT', 'Text: Prev/Next');
@define('STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE', 'Headline');

@define('STATICPAGE_LANGUAGE', 'Language');
@define('STATICPAGE_LANGUAGE_DESC', 'Select the language of this page.');

@define('STATICPAGE_PLUGINS_INSTALLED', 'Plugin is installed');
@define('STATICPAGE_PLUGIN_AVAILABLE', 'Plugin is available, but not installed');
@define('STATICPAGE_PLUGIN_NOTAVAILABLE', 'Plugin is not available');

@define('STATICPAGE_SEARCHRESULTS', 'Found %d static pages:');

@define('LANG_ALL', 'All languages');
@define('LANG_EN', 'English');
@define('LANG_DE', 'German');
@define('LANG_DA', 'Danish');
@define('LANG_ES', 'Spanish');
@define('LANG_FR', 'French');
@define('LANG_FI', 'Finnish');
@define('LANG_CS', 'Czech (Win-1250)');
@define('LANG_CZ', 'Czech (ISO-8859-2)');
@define('LANG_NL', 'Dutch');
@define('LANG_IS', 'Icelandic');
@define('LANG_PT', 'Portuguese Brazilian');
@define('LANG_BG', 'Bulgarian');
@define('LANG_NO', 'Norwegian');
@define('LANG_RO', 'Romanian');
@define('LANG_IT', 'Italian');
@define('LANG_RU', 'Russian');
@define('LANG_FA', 'Persian');
@define('LANG_TW', 'Traditional Chinese (Big5)');
@define('LANG_TN', 'Traditional Chinese (UTF-8)');
@define('LANG_ZH', 'Simplified Chinese (GB2312)');
@define('LANG_CN', 'Simplified Chinese (UTF-8)');
@define('LANG_JA', 'Japanese');
@define('LANG_KO', 'Korean');

@define('STATICPAGE_STATUS', 'Status');

@define('STATICPAGES_CUSTOM_STRUCTURE_SHOW', 'Show Structural field options');
@define('STATICPAGES_CUSTOM_META_SHOW', 'Show optional META field entries');
@define('STATICPAGES_CUSTOM_META_TITLE', 'HTML META title element (optional)');
@define('STATICPAGES_CUSTOM_META_DESC', 'HTML META Description (optional)');
@define('STATICPAGES_CUSTOM_META_KEYS', 'HTML META Keywords (optional)');

//
//  serendipity_plugin_staticpage.php
//

@define('PLUGIN_STATICPAGELIST_NAME',                   'Static Page List');
@define('PLUGIN_STATICPAGELIST_NAME_DESC',              'This plugin displays a configurable list of the static pages.');
@define('PLUGIN_STATICPAGELIST_TITLE',                  'Title');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC',             'Enter the sidebar title to display:');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT',          'Static Pages');
@define('PLUGIN_STATICPAGELIST_LIMIT',                  'Number to Display');
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC',             'Enter the number of Static Pages to Display. 0 means, no limit.');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME',         'Show frontpagelink');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC',         'Create a link to the frontpage');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME',     'Frontpage');
@define('PLUGIN_LINKS_IMGDIR',                          'Use plugin image directory');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH',                 'Tell the URL path to use for accessing the tree structure images. The "img" subfolder needs to be in this directory, and is delivered with this plugin.');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_NAME',         'Icons or plain Text');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_DESC',         'Show tree structure or plain Text-Menu');
@define('PLUGIN_STATICPAGELIST_ICON',                   'Tree');
@define('PLUGIN_STATICPAGELIST_TEXT',                   'Plain Text');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY',            'Only show parent pages?');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY_DESC',       'If enabled, only parent pages are shown. If disabled, childpages will also be shown.');
@define('PLUGIN_STATICPAGELIST_IMG_NAME',               'Enable graphics for tree structure');

@define('STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRIES', 'Changed the URL of the moved directory in %s static pages.');
@define('STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRY', 'On Non-MySQL databases, iterating through every static page to replace the old directory URLs with new directory URLs is not possible. You will need to manually edit your static pages to fix new URLs. You can still move your old directory back to where it was, if that is too cumbersome for you.');

@define('STATICPAGE_QUICKSEARCH_DESC', 'If enabled, quicksearch results will also display hits on static pages');

@define('STATICPAGE_CATEGORYPAGE','related static-page');
@define('STATICPAGE_RELATED_CATEGORY', 'related category');
@define('STATICPAGE_RELATED_CATEGORY_DESCRIPTION', 'Fetch entries from this category and display this or a link to the category on the staticpage. Use the template "plugin_staticpage_related_category.tpl" for this feature.');

@define('STATICPAGE_ARTICLE_OVERVIEW','article overview');
@define('STATICPAGE_NEW_HEADLINES','newest headlines:');

@define('STATICPAGE_TEMPLATE','Backend template');
@define('STATICPAGE_TEMPLATE_INTERNAL','All fields');
@define('STATICPAGE_TEMPLATE_EXTERNAL', 'Simple Template');

@define('STATICPAGE_SECTION_META', 'Metadata');
@define('STATICPAGE_SECTION_BASIC', 'Basic Content');
@define('STATICPAGE_SECTION_OPT', 'Options');
@define('STATICPAGE_SECTION_STRUCT', 'Structural');

@define('PLUGIN_STATICPAGELIST_SMARTIFY', 'Smartify Sidebar list');
@define('PLUGIN_STATICPAGELIST_SMARTIFY_BLAHBLAH', 'Use smarty template file: "plugin_staticpage_sidebar.tpl" for sidebar output (allows to truncate length via smarty).');

@define('PLUGIN_STATICPAGE_PREVIEW', 'The preview of your static page has been opened in a new pop-up window. If you can not see this, please click this link: %s');

@define('STATICPAGE_SHOW_BREADCRUMB_DEFAULT', 'Show breadcrumb');
@define('STATICPAGE_SHOW_BREADCRUMB', 'Show breadcrumb');
@define('STATICPAGE_SHOW_BREADCRUMB_DESC', 'Show breadcrumb navigation on this page.');
?>