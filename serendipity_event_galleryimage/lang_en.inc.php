<?php # 

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_GALLERYIMAGE_NAME',     'Markup: Gallery Image');
@define('PLUGIN_EVENT_GALLERYIMAGE_DESC',     'Inserts a Gallery album or image using markup text.');
@define('PLUGIN_EVENT_GALLERYIMAGE_GALLERY_BASE',     'URL of Gallery');
@define('PLUGIN_EVENT_GALLERYIMAGE_GALLERY_BASE_BLAHBLAH',     'The base Gallery installation URL for album links.');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_BASE',     'URL of the Gallery album directory');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_BASE_BLAHBLAH',     'The album URL for <img> tags. (for Gallery 2.x this is used to get the imagesizes correctly!)');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXPOPUPSIZE',     'Maximum dimension for popup window.');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXPOPUPSIZE_BLAHBLAH',     'Horizontal or vertical, default is 640.');      
@define('PLUGIN_EVENT_GALLERYIMAGE_VERSION',        'Which version of Gallery are you using?');

@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXTHUMBSIZE',     'Maximum dimension for thumbnailed pictures (Only used for Gallery 2.x versions!)');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXTHUMBSIZE_BLAHBLAH',     'Horizontal or vertical, default is 120.');      
@define("PLUGIN_EVENT_GALLERYIMAGE_ALBUM_ABS", "Absolute album-path (Only used for Gallery 2.x versions!)");
@define("PLUGIN_EVENT_GALLERYIMAGE_ALBUM_ABS_BLAHBLAH", "The absolute server-path to the album directory. The ./tmp directory in this album directory has to be writeable for the webserver!");
@define("PLUGIN_EVENT_GALLERYIMAGE_GALLERY_ABS", "Absolute gallery-path (Only used for Gallery 2.x versions!)");
@define("PLUGIN_EVENT_GALLERYIMAGE_GALLERY_ABS_BLAHBLAH", "The absolute server-path to the gallery directory.");

?>
