<?php # $Id$

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_FLICKR_NAME', 'Import from Flickr');
@define('PLUGIN_EVENT_FLICKR_DESC', 'Import images from flickr.com into the media library');
@define('PLUGIN_EVENT_FLICKR_APIKEY', 'API key');
@define('PLUGIN_EVENT_FLICKR_APIKEY_INVALID', 'The key must be 32 characters long and should only contains digits and [a-f]');
@define('PLUGIN_EVENT_FLICKR_APIKEY_DESC', 'API key from http://www.flickr.com/services/api/');
@define('PLUGIN_EVENT_FLICKR_IMPORT', 'Import images from Flickr.com');
@define('PLUGIN_EVENT_FLICKR_IMPORT2', 'Import images from Flickr.com (step 2)');
@define('PLUGIN_EVENT_FLICKR_TAGS', 'Tags');
@define('PLUGIN_EVENT_FLICKR_KEYWORDS', 'Keywords');

@define('PLUGIN_EVENT_FLICKR_IMPORT_BLAHBLAH', 'Plugin can only fetch "public" photos from Flickr.com. /!\ Be careful with (copy)rights');
@define('PLUGIN_EVENT_FLICKR_INSTALL', '<strong>/!\</strong> With some ISP\'s account, it is impossible to change the include path with an ini_set() instruction (Free.fr for example). The plugin will then fail to run since it can\'t instanciate some classes.<br /><br />In that case, you probably have a special place in your account to put common php files (ask your ISP). On Free.fr, just create a directory called \'include\' in the root directory of your account. Then copy anything in the phpFlickr/PEAR subdir of the plugin to that directory.');