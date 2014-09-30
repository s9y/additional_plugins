<?php # 

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_USERGALLERY_TITLE', 'Gallery Display');
@define('PLUGIN_EVENT_USERGALLERY_DESC', 'Allows anonymous users to view Serendipity media gallery');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_TWO', '2');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_THREE', '3');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_FOUR', '4');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_FIVE', '5');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_DESC', 'Number of columns to show in gallery view');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_NAME', 'Number of columns');
@define('PLUGIN_EVENT_USERGALLERY_PERMALINK_NAME', 'Permalink for gallery view');
@define('PLUGIN_EVENT_USERGALLERY_PERMALINK_DESC', 'Enter a unique permalink you would like to use for the gallery');
@define('PLUGIN_EVENT_USERGALLERY_SUBNAME_NAME', 'Subpage name for gallery view');
@define('PLUGIN_EVENT_USERGALLERY_SUBNAME_DESC', 'Enter a unique subpage name you would like to use for the gallery (gallery will be available at index.php?serendipity[subpage]=subname)');
@define('PLUGIN_EVENT_USERGALLERY_DIRECTORY_NAME', 'Pick a default directory');
@define('PLUGIN_EVENT_USERGALLERY_DIRECTORY_DESC', 'Pick the default directory you would like the gallery to be restricted to');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_NAME', 'Choose the gallery style');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_DESC', '"Media library" allows folder navigation and searchs, while "Thumbnail page" give a thumbnail display of all images under a folder and opens the images in a new window');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_SERENDIPITY', 'Media library');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_THUMBPAGE', 'Thumbnail page');
@define('PLUGIN_EVENT_USERGALLERY_PRETTY_NAME', 'Display name');
@define('PLUGIN_EVENT_USERGALLERY_PRETTY_DESC', 'Pick the name you would like for the gallery title');
@define('PLUGIN_EVENT_USERGALLERY_INTRO', 'Introductory Text (optional)');
@define('PLUGIN_EVENT_USERGALLERY_FIXED_WIDTH', 'Fixed image size in gallery view');
@define('PLUGIN_EVENT_USERGALLERY_FIXED_DESC', 'Sets the image height and width to a fixed proportion when viewing the gallery page.  Set to zero to use standard thumbnail.');
@define('PLUGIN_EVENT_USERGALLERY_FILESIZE', 'Filesize');
@define('PLUGIN_EVENT_USERGALLERY_FILENAME', 'Filename');
@define('PLUGIN_EVENT_USERGALLERY_DIMENSION', 'Dimension');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_NAME', 'Display Single Image');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_DESC', 'You may either have images displayed scaled to fit on a seperate page (with adaptive pop-up for large images), or in an adaptive pop-up directly from the gallery page.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_INPAGE', 'Scaled to fit');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_POPUP', 'Adaptive pop-up');
@define('PLUGIN_EVENT_USERGALLERY_DIRLIST_NAME', 'Show a directory listing');
@define('PLUGIN_EVENT_USERGALLERY_DIRLIST_DESC', 'If set to "yes" the gallery will display a listing of all directories contained in your default directory.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESTRICT_NAME', 'Output images strictly');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESTRICT_DESC', 'If set to "yes" the gallery will only display pictures in the current directory. If set to "no" the gallery will output all pictures in all subdirectories.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_NAME', 'Order of images');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_DESC', 'Pick the order your would like images output.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_NAMEACS', 'Name (Ascending)');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_NAMEDESC', 'Name (Descending)');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_DATEACS', 'Date (Ascending)');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_DATEDESC', 'Date (Descending)');
@define('PLUGIN_EVENT_USERGALLERY_DISPLAYDIR_NAME', 'Display the whole directory tree');
@define('PLUGIN_EVENT_USERGALLERY_DISPLAYDIR_DESC', 'If set to "yes" the gallery will display the whole directory tree on each page.  If set to "no" the the gallery will display a directory list of only subfolders. (This behavior is also dependent on the template used to display the gallery.)');
@define('PLUGIN_EVENT_USERGALLERY_1SUBLVL_NAME','Only show one directory level lower');
@define('PLUGIN_EVENT_USERGALLERY_1SUBLVL_DESC','This will limit the directory output to only show one directory level below the current, and will summerize the number of pictures in all directories under the next level. This is not available if you are using the full directory tree.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESPERPAGE_NAME', 'Images per page');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESPERPAGE_DESC', 'Set the number of images to display per page.  If set to "0" pagination will be turned off.');
@define('PLUGIN_EVENT_USERGALLERY_PREVIOUS', 'previous');
@define('PLUGIN_EVENT_USERGALLERY_NEXT', 'next');
@define('PLUGIN_EVENT_USERGALLERY_UPONELEVEL', 'Up one level');
@define('PLUGIN_EVENT_USERGALLERY_BACK', 'Back');
@define('PLUGIN_EVENT_USERGALLERY_FRONTPAGE_NAME', 'Make this page the frontpage of Serendipity');
@define('PLUGIN_EVENT_USERGALLERY_FRONTPAGE_DESC', 'Instead of showing the default Serendipity startpage, the Gallery will show up. If you want to link to your usual Serendipity Frontpage, you need to use "index.php?frontpage". If you want to use this feature, you need to make sure that no other permalink-plugin (like voting, guestbook) are placed before the User Gallery plugin in the Serendipity Plugin Configuration Event Queue.');

//Exif data tags
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_SHOW_NAME', 'Show exif tags?');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_SHOW_DESC', 'Exif tags are additional information fields about the image. These are automatically generated, if available, from the image. Please note; NOT all cameras support this feature it\'s very likely it\'s not supported. Cameras older than 4 year will more than likely not support Exif data.');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_CAMERA', 'Supported cameras: Agfa, Canon, Casio, Epson, Fujifilm, Konica Minolta, Kyocera, Nikon, Olympus, Panasonic, Pentax, Ricoh, Sony.');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_NAME', 'Exif data');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_DESC', 'In the list below are all available options. Your specific camera may skip one or two variables as not every variable is supported on each camera.');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_ADDITIONALDATA', 'Additional Information');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_NOADDITIONALDATA', 'No additional data available.');

@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED', 'RSS-Feed image dimensions');
@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_DESC', 'This plugin offers a RSS-Feed with the latest pictures of your blog. You can call it like any other RSS-Feed of your blog, like with this URL: %s. The URL-Variable "gallery=true" is important to indicate that gallery pictures should be shown. You can us the URL-variable "limit=XX" to indicate the number of items you want - otherwise the default for RSS entries is used. The URL-variable "picdir=XXX" can indicate a specific directory you want to display. Using "hide_title=true" you can hide the filename titles from the RSS-Feed, and using "feed_width=XXX" you can specify an optional size of the target images (only supported since Serendipity 1.1). Enter the largest dimension (width or height in pixels) that should be used for the images in your feeds.');

@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_LINKONLY', 'Only show linked images in RSS-Feed?');
@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_LINKONLY_DESC', 'If enabled, only images which are linked in your entries will be shown in the RSS feeds.');

@define('USERGALLERY_SEE_FULLSIZED', 'Click image to see fullsized');
@define('USERGALLERY_DOWNLOAD_HERE', 'To download, click here!');
@define('USERGALLERY_LINKED_ENTRIES', 'Entries using this image:');
@define('USERGALLERY_LINKED_STATICPAGES', 'Static Pages using this image:');
@define('PLUGIN_EVENT_USERGALLERY_SHOW_LINKED_ENTRY', 'Show links to entries where an image is referenced?');
@define('PLUGIN_EVENT_USERGALLERY_DIRTAB_NAME','Subdirectory spacing in tree');
@define('PLUGIN_EVENT_USERGALLERY_DIRTAB_DESC','Number of pixels to tab subdirectories in directory view.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGE_WIDTH_NAME','Max. image width in page.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGE_WIDTH_DESC','Maximum width an image can be when displayed using "scaled to fit".  A setting of "0" means images are displayed full size.');

//Media properties
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_SHOW_NAME', 'Show Media Properties');
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_SHOW_DESC', 'Show the media properties assigned to individual items in the Media Library?');
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_NAME', 'Media properties list');
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_DESC', 'This is a list of media properties and the name you would like to show for each property on the page.  The format of the list is: "ITEM1:Item1;ITEM2:Item2", where each property is separated by semicolons, with the name of the property (as listed in the Configuration settings) first, a colon, and then the name to be displayed.');

//Several constants used in the template
@define('PLUGIN_EVENT_USERGALLERY_IMAGES', 'images');
@define('PLUGIN_EVENT_USERGALLERY_PAGINATION', 'Page %s of %s, totaling %s images');

@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_BODY', 'Use original blog entry for the picture in RSS-Feed?');
@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_BODY_DESC', 'If enabled, an image of the mediadatabase that has been linked within an blog entry will have the original blog entry\'s body within the RSS feed, instead of (by default) having a simple link to the blog article and the original image location.');

@define('PLUGIN_EVENT_USERGALLERY_SHOWLIGHTBOX_NAME', 'Use lightbox output');
@define('PLUGIN_EVENT_USERGALLERY_SHOWLIGHTBOX_DESC', 'Needs the lightbox-plugin installed and upper option "Display Single Image" set to "Scaled to fit"!');
@define('PLUGIN_EVENT_USERGALLERY_LIGHTBOXTYPE_NAME', 'Lightbox-type as selected in lightbox-plugin');

