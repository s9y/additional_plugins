<?php # 

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_CACHESIMPLE_NAME',     'Simple Cached/Pregenerated Pages');
@define('PLUGIN_EVENT_CACHESIMPLE_DESC',     '[EXPERIMENTAL] Allows to cache/pregenerate pages. Note: Destroys dynamic capabilites and may not interoperate well with dynamic plugins. But it\'s faster, if you don\'t depend on realtime dynamics.  (This plugin should be placed as early as possible in the event queue list. Only dynamic plugins like the karmavoting should be positioned before this plugin.)');
@define('PLUGIN_EVENT_CACHESIMPLE_BROWSER', 'Use seperate IE/Mozilla caches?');
@define('PLUGIN_EVENT_CACHESIMPLE_KEEPFRESH', 'Force clients to maintain fresh copy?');
@define('PLUGIN_EVENT_CACHESIMPLE_KEEPFRESH_DESC', 'By not sending a "Expires" header we can force clients not to cache the webpage locally.  This will force clients to make new request from the server each time the page is accessed.  If clients are respectful they will still use "Validation" techniques to minimize transfers of full pages.  The prevents problems where comments do not show up after a client has posted them, but will result in slower access.');

?>
