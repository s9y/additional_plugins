<?php # 

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_SOCIALBOOKMARKS_N', 'Social Bookmarks Plugin');
@define('PLUGIN_SOCIALBOOKMARKS_D', 'A plugin to display bookmarks from a social bookmark service (del.icio.us, ma.gnolia, furl.net, linkroll, Mister Wong) via an RSS feed.');
@define('PLUGIN_SOCIALBOOKMARKS_TITLE_N', 'Title');
@define('PLUGIN_SOCIALBOOKMARKS_TITLE_D', 'Heading that will be displayed in the blog\'s sidebar (leave empty to display service name).');
@define('PLUGIN_SOCIALBOOKMARKS_SOCIALBOOKMARKSSERVICE_N', 'Service');
@define('PLUGIN_SOCIALBOOKMARKS_SOCIALBOOKMARKSSERVICE_D', 'Which social bookmark service to use.');
@define('PLUGIN_SOCIALBOOKMARKS_USERNAME_N', 'Username');
@define('PLUGIN_SOCIALBOOKMARKS_USERNAME_D', 'Your user name for the selected social bookmarks service.');
@define('PLUGIN_SOCIALBOOKMARKS_DISPLAYNUMBER_N', 'Number of post to display');
@define('PLUGIN_SOCIALBOOKMARKS_DISPLAYNUMBER_D', 'How many bookmarks should be displayed? (Maxium feed size is the default, 30).');
@define('PLUGIN_SOCIALBOOKMARKS_CACHETIME_N', 'When to update the feed?');
@define('PLUGIN_SOCIALBOOKMARKS_CACHETIME_D', 'The contents of a feed are stored in a cache that will be updated as soon as it is older than X hours (Default: 1).');
@define('PLUGIN_SOCIALBOOKMARKS_MORELINK_N', 'Display "more"-link?');
@define('PLUGIN_SOCIALBOOKMARKS_MORELINK_D', 'Display a link to your social bookmark page.');
@define('PLUGIN_SOCIALBOOKMARKS_MORELINK', 'More');
@define('PLUGIN_SOCIALBOOKMARKS_DISPLAYTAGS_N', 'Display tags?');
@define('PLUGIN_SOCIALBOOKMARKS_DISPLAYTAGS_D', 'If you tagged your bookmarks with keywords, you can show them here. By clicking on a tag, your blog is searched for posts with the same tag. (Supported only by del.icio.us, ma.gnolia.com, furl.net).');
@define('PLUGIN_SOCIALBOOKMARKS_DISPLAYTHUMBS_N', 'Display thumbnails?');
@define('PLUGIN_SOCIALBOOKMARKS_DISPLAYTHUMBS_D', 'Some bookmark services (as of now only ma.gnolia) include small thumbnails of the bookmarked webpages in their feed. If you want, these images can be displayed instead of the bookmarks\' names');
@define('PLUGIN_SOCIALBOOKMARKS_ADDPARAMS_N', 'Additional parameters for feature "My tag cloud (del.icio.us)"');
@define('PLUGIN_SOCIALBOOKMARKS_ADDPARAMS_D', 'These settings only apply to del.icio.us\' javascript tagroll function. For more information on how to customize the appearance of your tag cloud, please consult the del.icio.us tagrool help (http://del.icio.us/help/tagrolls).');
@define('PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_N', 'Type of feed');
@define('PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_D', 'Choose from different flavors of bookmark feeds.');
@define('PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_USR_RECENT', 'My most recent bookmarks');
@define('PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_GEN_RECENT', 'Everyone\'s most recent bookmarks');
@define('PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_GEN_POPULAR', 'Most popular bookmarks');
@define('PLUGIN_SOCIALBOOKMARKS_EXPLAIN', '<h3>What is this social bookmarks plugin about?</h3><p>The primary purpose of bookmarks is to easily catalog and access web pages that the web browser user has visited or plans to visit, without having to remember the page URLs or rely on other computer programs. More recently, however, with the advent of social bookmarking, bookmarks have become a means for users sharing similar interests to locate new websites that they might not have otherwise heard of, or to store their bookmarks in such a way that they are not tied to one specific computer.</p><p>With the help of this plugin, you can easily display your bookmarks - bookmarks you recently saved to one of the supported social bookmark services - in your blog.</p>');
?>