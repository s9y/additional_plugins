<?php # 

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_LIGHTBOX_NAME', 'Lightbox/Thickbox JS/Greybox');
@define('PLUGIN_EVENT_LIGHTBOX_DESC', 'Lightbox JS is a simple, unobtrusive script used to to overlay images on the current page. It\'s a snap to setup and works on all modern browsers. Lightbox pops up images, while Thickbox can also display HTML popup links. Both scripts work like this: They search through your entries, and replace every \'a href="XXX"\' link and then replace that link to use the internal display. So if you want your thumbnail images to popup large, you need to insert your images as links to the large version. Using thickbox, you can put a \'class="thickbox"\' attribute into your \'a href\' links so that they will popup in a window.');
@define('PLUGIN_EVENT_LIGHTBOX_TYPE', 'Select the script to pretty-format your links/images');
@define('PLUGIN_EVENT_LIGHTBOX_PATH', 'Path to the scripts');
@define('PLUGIN_EVENT_LIGHTBOX_PATH_DESC', 'Enter the full HTTP path (everything after your domain name) that leads to this plugin\'s directory.');

@define('PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION',       'JavaScript Load optimization');
@define('PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION_DESC',  'Switching this option on will load Lightbox\' JavaScript and CSS only, if an image is shown on the current page. This will shorten the page loading time noticeable. At some blogs it was reported to not loading the script always. For these users the optimization can be switched off loading the scripts always again.');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY',  'Create Gallery');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_NONE', 'No gallery');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_ENTRY', 'Gallery with photos of the entry');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_PAGE', 'Gallery with photos of the page');

@define('PLUGIN_EVENT_LIGHTBOX_INIT_JS', 'Initial JavaScript configuration object');
@define('PLUGIN_EVENT_LIGHTBOX_INIT_JS_DESC', 'Some lightbox types (like prettyPhoto) allow to pass custom configuration objects, so you can enter "{social_tools: false}" for example.');
