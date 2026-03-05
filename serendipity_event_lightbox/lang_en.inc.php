<?php

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_LIGHTBOX_NAME', 'Lightbox for entry images');
@define('PLUGIN_EVENT_LIGHTBOX_DESC', 'Lightboxes are unobtrusive scripts used to show images in an overlay when clicked. It\'s a snap to setup and works with all modern browsers. All lightboxes pop-up images instead of showing them directly. This plugin searches through your entries, and replaces every image \'a href="XXX"\' link to use the new display method. So if you want your thumbnail images to popup large, you need to insert your images as links to the large version. To display also hidden set images by display:none, use lightbox2. Those scripts do not only support images, they may also have support for ajax, videos, flash, YouTube, iFrame, inline, or modal boxes. This Plugin uses them for images only, but you can add other content types manually to your entries and start the chosen lightbox as described in their online documentaries.');
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
@define('PLUGIN_EVENT_LIGHTBOX_INIT_JS_DESC', 'Some lightbox types allow to pass custom configuration objects, so you can enter "{social_tools: false}" for example.');


