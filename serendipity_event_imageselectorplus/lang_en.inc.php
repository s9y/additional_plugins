<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Revised by
 */

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_NAME', 'Extended options for media manager');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_DESC', 'Allows extended options for inserting images from the media manager [Serendipity >= 0.9]');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET', 'Target for this link');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_JS', 'Popup window (via JavaScript, adaptive size)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_ENTRY', 'Isolated Entry');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_BLANK', 'Popup window (via target=_blank)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG', 'QuickBlog');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG_DESC', 'If you enter at least a title in the following fields, the image will be posted as a new blog entry immediately. The design can be edited via the quickblog.tpl file.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_MAXWIDTH', 'Maximum width of thumbnail (discards height)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_MAXHEIGHT', 'Maximum height of thumbnail (discards width)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_AUTORESIZE', 'Dynamically resize images based on width and height attributes');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_AUTORESIZE_DESC', 'Automatically send resized versions of your images to the client based on the width and/or height attributes specified in the IMG tag. This can make your life easier and decrease download times but decreases server-side performance. (Note: Aspect ratios are maintained).');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES', 'ZIP archives unzipping');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_BLABLAH', 'Unzip uploaded ZIP archives? - Preset value for form on the images upload page.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_DESC', 'Unzip uploaded ZIP archives?');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_OK', 'ZIP archive succesfully unzipped');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FAILED', 'ZIP archive failed to unzip');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_IMAGE_FROM_ARCHIVE', 'Image from zip archive');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_ADD_TO_DB', 'added to database');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_JHEAD', 'Use jhead to obtain EXIF data');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_JHEAD_DESC', 'Override the default behaviour and use external calls to jhead to obtain EXIF data. Choose this option only if jhead is installed and can be executed.');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_IMAGE_SIZE_DESC', 'Changing this default $serendipity[\'thumbSize\'] to another value, will add an additional and resized copy of that image to the MediaLibrary. This instance is then used as the preview thumbnail image in your frontend blog entry, linking to the origin image.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_ASOBJECT', 'Non-image object?');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_THUMBRESIZE_DESC', 'Default setting to both MAX values is 0, which is used as a fallback! Changing these values will overwrite $serendipity[\'thumbSize\'], defined in the blogs global "Configuration" - "Image Conversion Settings"! If you want to influence the MediaLibrary thumb size creation, change either the global "Image Conversion Settings" or use either this "max-width" OR "max-height" setting only, for landscape/portrait ratios. Setting both to the same value here, has the same effect.');
