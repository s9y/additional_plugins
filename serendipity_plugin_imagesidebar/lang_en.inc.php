<?php

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_NAME', 'Unified Sidebar Image Display');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DESC', 'Offers the ability to display images in the sidebar.  The source of the images is configurable.  The plugin is able to connect to a Menalto Gallery installs "random" url, access a Coppermine database directory (MySql only), connect to the web service Zooomr (http://beta.zooomr.com/home) or access images in the Serendipity Media Library.');

@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_NAME','Image Source');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_DESC','Please choose a source for your images from the drop down.');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_NONE','No selection made');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_MENALTO','Menalto Gallery Url');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_COPPERMINE','Coppermine Database');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_MEDIALIB','Media Library');

@define('PLUGIN_GALLERYRANDOMBLOCK_NAME',           'Gallery Random Photo Block');
@define('PLUGIN_GALLERYRANDOMBLOCK_DESC',           'Adds a reference to a Gallery Random Block script (see http://gallery.menalto.com for details on this script)');
@define('PLUGIN_GALLERYRANDOMBLOCK_URL_NAME',       'Directory of Gallery installation');
@define('PLUGIN_GALLERYRANDOMBLOCK_URL_DESC',       'Enter the virtual path to your gallery installation');
@define('PLUGIN_GALLERYRANDOMBLOCK_NUMREPEAT_NAME', 'Number of Random Photos');
@define('PLUGIN_GALLERYRANDOMBLOCK_NUMREPEAT_DESC', 'Enter the number of random photos to show in this block.');
@define('PLUGIN_GALLERYRANDOMBLOCK_FILE_NAME',      'Filename of the embedded script (Only used for Gallery 1.x versions!)');
@define('PLUGIN_GALLERYRANDOMBLOCK_VERSION',        'Which version of Gallery are you using?');
@define('PLUGIN_GALLERYRANDOMBLOCK_ERROR_CONNECT',  'ERROR: URL could not be opened. the gallery cannot be embedded here');
@define('PLUGIN_GALLERYRANDOMBLOCK_ERROR_HTTP',     'ERROR: The HTTP server returned the error or the warning(result:%d).');@define('PLUGIN_GALLERYRANDOMBLOCK_ITEMID',         'Album ID to show');
@define('PLUGIN_GALLERYRANDOMBLOCK_ITEMID_DESC',    'Empty value shows all albums, only applies to Gallery 2.x versions.');
@define('PLUGIN_GALLERYRANDOMBLOCK_G2DISPLAYTYPE',  'Picture to display.');
@define('PLUGIN_GALLERYRANDOMBLOCK_G2DISPLAYTYPE_RAND',    'Random');
@define('PLUGIN_GALLERYRANDOMBLOCK_G2DISPLAYTYPE_RENCENT', 'Recent');
@define('PLUGIN_GALLERYRANDOMBLOCK_G2DISPLAYTYPE_VIEWED',  'Most Viewed');
@define('PLUGIN_GALLERYRANDOMBLOCK_G2DISPLAYTYPE_SPECIFIC','Specific');
@define('PLUGIN_GALLERYRANDOMBLOCK_SINGLE_ITEMID',         'ID of the specific image to display.');
@define('PLUGIN_GALLERYRANDOMBLOCK_SINGLE_ITEMID_DESC',    '');
@define('PLUGIN_GALLERYRANDOMBLOCK_MAXSIZE','Maximium Width of Image.');
@define('PLUGIN_GALLERYRANDOMBLOCK_MAXSIZE_DESC','This will set the image to a specific width.  Unfortunately, this setting causes the large image to be downloaded and then rescaled to the required size.  Leave blank to use the standard Gallery thumbnail.');
@define('PLUGIN_GALLERYRANDOMBLOCK_LINKTARGET','Link Target');
@define('PLUGIN_GALLERYRANDOMBLOCK_LINKTARGET_DESC','Sets the links "target" option.  Leave blank to leave unset. A good setting might be "_blank".');
@define('PLUGIN_GALLERYRANDOMBLOCK_SHOWDETAIL','Which details should be displayed.');
@define('PLUGIN_GALLERYRANDOMBLOCK_SHOWDETAIL_DESC','Tell the plugin which details to display.  This must be a comma seperated list of keywords.  Available keywords are "title, date, views, owner, heading".  To display no information use the keyword "none".');



@define('PLUGIN_CPGS_NAME',     'Coppermine Thumbnails');
@define('PLUGIN_CPGS_DESC',     'Display thumbnails from a Coppermine gallery in the sidebar');
@define('PLUGIN_CPGS_SERVER_NAME','Server');
@define('PLUGIN_CPGS_SERVER_DESC','SQL server');
@define('PLUGIN_CPGS_DB_NAME',	'Database');
@define('PLUGIN_CPGS_DB_DESC',	'SQL database');
@define('PLUGIN_CPGS_PREFIX_NAME','Prefix');
@define('PLUGIN_CPGS_PREFIX_DESC','Database table prefix');
@define('PLUGIN_CPGS_USER_NAME','Username');
@define('PLUGIN_CPGS_USER_DESC','Database user name');
@define('PLUGIN_CPGS_PASSWORD_NAME',	'Password');
@define('PLUGIN_CPGS_PASSWORD_DESC',	'Database password');
@define('PLUGIN_CPGS_URL_NAME',	'URL');
@define('PLUGIN_CPGS_URL_DESC',	'Gallery URL');
@define('PLUGIN_CPGS_TYPE_NAME','Type');
@define('PLUGIN_CPGS_TYPE_DESC','Which images to display');
@define('PLUGIN_CPGS_TITLE_NAME','Title');
@define('PLUGIN_CPGS_TITLE_DESC','Sidebar item title');
@define('PLUGIN_CPGS_ALBUM_NAME','Album Link');
@define('PLUGIN_CPGS_ALBUM_DESC','Include a link to the pictures album below the thumbnail');
@define('PLUGIN_CPGS_GALLLINK_NAME',	'Gallery Link URL');
@define('PLUGIN_CPGS_GALLLINK_DESC',	'URL for the link below the thumbnails (empty for no link)');
@define('PLUGIN_CPGS_GALLNAME_NAME',	'Gallery Name');
@define('PLUGIN_CPGS_GALLNAME_DESC',	'Text for the gallery link');
@define('PLUGIN_CPGS_COUNT_NAME','Thumbnails');
@define('PLUGIN_CPGS_COUNT_DESC','Number of thumbnails to display');
@define('PLUGIN_CPGS_SIZE_NAME','Size');
@define('PLUGIN_CPGS_SIZE_DESC','Maximum thumbnail size');
@define('PLUGIN_CPGS_THUMB_NAME','Resolve Non-Images');
@define('PLUGIN_CPGS_THUMB_DESC','Attempt to find a Coppermine default thumbnail for non-images (e.g. videos)');
@define('PLUGIN_CPGS_FILTER_NAME','Album Filter');
@define('PLUGIN_CPGS_FILTER_DESC','Album id filter');
@define('PLUGIN_CPGS_RECENT',	'Most Recent');
@define('PLUGIN_CPGS_POPULAR',	'Most Viewed');
@define('PLUGIN_CPGS_RANDOM',	'Random Images');

@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NAME', 'Media library sidebar display');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DESC', 'Display a random image from the Media library in the sidebar. (Note, it does not distingish images from other file types)');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DIRECTORY_NAME', 'Pick a default directory');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DIRECTORY_DESC', 'Pick the default directory you would like the plugin to be restricted to');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_IMAGESTRICT_NAME', 'Output images strictly');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_IMAGESTRICT_DESC', 'If set to “yes” the plugin will only display pictures in the current directory. If set to "no" the plugin will output all pictures in all subdirecteries.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_NAME', 'Behavior of image link');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_DESC', '"In Page" links to the image.  "Pop Up" will open the image in a new, sized window. "Url" allows you to define a specific, static url as the destination.  "Gallery" will link the image to the permalink view of the usergallery plugin (if installed).');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_INPAGE', 'In Page');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_POPUP', 'Pop Up');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_URL', 'Url');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_GALLERY', 'Gallery');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_ENTRY', 'Try to link to related entry');

@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_WIDTH_NAME', 'Image width');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_WIDTH_DESC', 'Set a fixed image width.  If the width is set to "0" the plugin will output "width:100%"');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_URL_NAME', 'Enter URL');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_URL_DESC', 'Enter the static URL you would like to link to. (example: \'http://www.s9y.org\')');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_GALPERM_NAME', 'Enter the permalink or subpage');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_GALPERM_DESC', 'This value should match the value set in the gallery plugin.  Note, if url rewriting is turned off you must use the subpage.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_INTRO', 'Enter any text (or html) you would like placed before the picture');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_SUMMERY', 'Enter any text (or html) you would like appended to the picture');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_ROTATETIME_NAME', 'Rotate image time');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_ROTATETIME_DESC', 'How often would you like the image to rotate, in minutes, from the hour.  If set to "0" the image will rotate every refresh');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NUMIMAGES_NAME', 'Number of images to display');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NUMIMAGES_DESC', 'Enter the number of images you would like displayed.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKS_NAME', 'Limit output to only hotlinked images');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKS_DESC', 'This option limits the sidebar output to only images which are hotlinks in the Media Library.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKBASE_NAME', 'Hotlink limiting keyword');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKBASE_DESC', 'This option takes a single keyword (no spaces) and limits the output to anything containing that word.  For example, if you have hotlinks from a variety of sources, but only want to display those from a single host you could put "host.com" in this field.');


@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_ZOOOMR', 'Zooomr Plugin');
@define('PLUGIN_ZOOOMR_DESC', 'Display the most recent pictures of any Zooomr Feed');
@define('PLUGIN_ZOOOMR_FEEDURL', 'Feed-URL');
@define('PLUGIN_ZOOOMR_FEEDDESC', 'URL of your Zooomr feed');
@define('PLUGIN_ZOOOMR_IMGCOUNT', 'Images');
@define('PLUGIN_ZOOOMR_IMGCOUNTDESC', 'Number of Images to show');
@define('PLUGIN_ZOOOMR_DLINK','Direct Image-Link');
@define('PLUGIN_ZOOOMR_DLINKDESC','Link directly to big version of the image');
@define('PLUGIN_ZOOOMR_LOGO','Show Zooomr Logo');
@define('PLUGIN_ZOOOMR_IMGWIDTH','Thumbnail width');

@define('PLUGIN_CPGS_GROUP_NAME', 'Usergroup');
@define('PLUGIN_CPGS_GROUP_DESC', 'Coppermine allows to define visibility of images restricted to certain usergroups. If you want this plugin to only fetch specific images, enter the usergroup this plugin shall act as in this field. "Everybody" means that all group permissions are ignored.');

@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LIGHTBOX_NAME', 'Use with installed Lightbox plugin.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LIGHTBOX_DESC', 'Please insert a html attribute eg <rel="lightbox"> (without <>) for lightbox usage. This will be appended to the image anchor. This works for select option "Behavior of image link" -> "In Page" only. Use with care.');


?>