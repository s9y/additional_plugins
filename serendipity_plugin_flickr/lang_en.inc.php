<?php

@define('PLUGIN_SIDEBAR_FLICKR', 'flickr Photostream');
@define('PLUGIN_SIDEBAR_FLICKR_DESC', 'Display the latest photos from flickr Photostreams.');
@define('PLUGIN_EVENT_FLICKRCSS', 'flickr Photostream CSS');
@define('PLUGIN_EVENT_FLICKRCSS_DESC', 'This plugin is an extension to the flickr Photostream sidebar plugin and adds style information (CSS).');

@define('PLUGIN_SIDEBAR_FLICKR_TITLE_TITLE', 'Title');
@define('PLUGIN_SIDEBAR_FLICKR_TITLE_BLAHBLAH', 'Title of this sidebar item. May be empty');
@define('PLUGIN_SIDEBAR_FLICKR_USER_TITLE', 'flickr account');
@define('PLUGIN_SIDEBAR_FLICKR_USER_BLAHBLAH', 'Username or email');

@define('PLUGIN_SIDEBAR_FLICKR_IMG_SQUARE', 'Square');
@define('PLUGIN_SIDEBAR_FLICKR_IMG_THUMBNAIL', 'Thumbnail');
@define('PLUGIN_SIDEBAR_FLICKR_IMG_SMALL', 'Small');
@define('PLUGIN_SIDEBAR_FLICKR_IMG_MEDIUM', 'Medium');
@define('PLUGIN_SIDEBAR_FLICKR_IMG_LARGE', 'Large');
@define('PLUGIN_SIDEBAR_FLICKR_IMG_ORIGINAL', 'Original');

@define('PLUGIN_SIDEBAR_FLICKR_LIGHTBOX_TITLE', 'Lightbox display');
@define('PLUGIN_SIDEBAR_FLICKR_LIGHTBOX_BLAHBLAH', 'To use the Lightbox plugin for flickrShow images, enter the associated "rel" tags. Works only if the image link is set to JPG. Default: lightbox[lightbox_group_entry_flickr]');

@define('PLUGIN_SIDEBAR_FLICKR_SRCIMG_TITLE', 'Thumbnail size');
@define('PLUGIN_SIDEBAR_FLICKR_TGTIMG_TITLE', 'Size of the linked image');

@define('PLUGIN_SIDEBAR_FLICKR_SHOWDATE', 'Show image date');
@define('PLUGIN_SIDEBAR_FLICKR_SHOWTITLE', 'Show image title');

@define('PLUGIN_SIDEBAR_FLICKR_TGTLINK_TITLE', 'Image link');
@define('PLUGIN_SIDEBAR_FLICKR_TGTLINK_JPG', 'JPG');
@define('PLUGIN_SIDEBAR_FLICKR_TGTLINK_FLICKR', 'flickr');

@define('PLUGIN_SIDEBAR_FLICKR_NUM_TITLE', 'Number of pictures to show');
@define('PLUGIN_SIDEBAR_FLICKR_NUM_BLAHBLAH', 'Min: 1, Max: 500');

@define('PLUGIN_SIDEBAR_FLICKR_APIKEY_TITLE', 'FLICKR API Key');
@define('PLUGIN_SIDEBAR_FLICKR_APIKEY_BLAHBLAH', 'In order to use this plugin you a flickr Services API Key (http://www.flickr.com/services/api/key.gne).');

@define('PLUGIN_SIDEBAR_FLICKR_APISECRET_TITLE', 'FLICKR API Secret');
@define('PLUGIN_SIDEBAR_FLICKR_APISECRET_DESC', 'The secret key is optional and allows for secure transmission of your data. You can get/configure the key via your Flickr profile page.');

@define('PLUGIN_SIDEBAR_FLICKR_CACHE_TITLE', 'Cache timeout');
@define('PLUGIN_SIDEBAR_FLICKR_CACHE_DESC', 'The time between scanning for new images in seconds. Default: 3600 seconds = 1 hour.');

@define('PLUGIN_SIDEBAR_FLICKR_SHOWRSS', 'Show RSS link');
@define('PLUGIN_SIDEBAR_FLICKR_SHOWPHOTOSTREAM', 'show flickr Photostream link');

@define('PLUGIN_SIDEBAR_FLICKR_LINK_SHOWRSS', 'flickr RSS Stream');
@define('PLUGIN_SIDEBAR_FLICKR_LINK_PHOTOSTREAM', 'flickr Photostream');

@define('PLUGIN_SIDEBAR_FLICKR_NUMBEROFCHOICES', 'Number of selected images');		//added 110730 by artodeto
@define('PLUGIN_SIDEBAR_FLICKR_USECHOICES','Randomize selected images?');			//added 110730 by artodeto

/* Errors */
@define('PLUGIN_SIDEBAR_FLICKR_ERROR_WRONGUSER', 'The flickr Account does not exist or the API key ist wrong.');
@define('PLUGIN_SIDEBAR_FLICKR_ERROR_NOIMG', 'No images available.');
?>
