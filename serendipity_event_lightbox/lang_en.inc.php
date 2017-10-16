<?php

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_LIGHTBOX_NAME', 'Lightbox for entry images');
@define('PLUGIN_EVENT_LIGHTBOX_DESC', 'Lightbox JS is a simple, unobtrusive script used to overlay images on the current page. It\'s a snap to setup and works with all modern browsers. All lightboxes pop-up images. This plugin searches through your entries, and replaces every image \'a href="XXX"\' link to use the internal display. So if you want your thumbnail images to popup large, you need to insert your images as links to the large version. To display also hidden set images by display:none, use lightbox2. These lightbox scripts are all jQuery based. They do not only support image types, they may also add support for ajax, videos, flash, YouTube, iFrame, inline, or modal boxes. This Plugin uses them for image lightboxes only, but you can easily add other content types manually to your entries and start the chosen lightbox as described in their online documentaries.');
@define('PLUGIN_EVENT_LIGHTBOX_TYPE', 'Select the script to pretty-format your links/images');
@define('PLUGIN_EVENT_LIGHTBOX_PATH', 'Path to the scripts');
@define('PLUGIN_EVENT_LIGHTBOX_PATH_DESC', 'Enter the full HTTP path (everything after your domain name) that leads to this plugin\'s directory.');

@define('PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION', 'JavaScript Load optimization');
@define('PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION_DESC', 'By default, Lightbox\'s JavaScript and CSS will be loaded all-the-time. Setting this to "Yes" will load it only when needed (because there rellay are images on the current page).  This may be a great way to shorten the page loading time and increase your site\'s speed.');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY', 'Create Gallery');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_NONE', 'Single image only');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_ENTRY', 'Gallery with photos of the entry');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_PAGE', 'Gallery with photos of the page');

@define('PLUGIN_EVENT_LIGHTBOX_INIT_JS', 'Initial JavaScript configuration object');
@define('PLUGIN_EVENT_LIGHTBOX_INIT_JS_DESC', 'Some lightbox types allow to pass custom configuration objects, so you can enter "{social_tools: false}" for example. Currently works with prettyPhoto only.');


