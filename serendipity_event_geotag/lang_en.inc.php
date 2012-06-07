<?php # $Id$

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_geotag.php
//
@define('PLUGIN_EVENT_GEOTAG_WARNING_GEOURL_PLUGIN', 'WARNING: GeoUrl plugin detected. Please deinstall it, as it is obsolete now.<br/>All the functionality it implements is done by the GeoTag plugin, too. The GeoTag plugin is even more detailed.');

@define('PLUGIN_EVENT_GEOTAG_HEADER_EDITOR', 'Article Editor Settings');
@define('PLUGIN_EVENT_GEOTAG_HEADER_FOOTER', 'Article Footer Settings');
@define('PLUGIN_EVENT_GEOTAG_HEADER_FOOTER_LIST', 'Article Footer Settings (List view)');
@define('PLUGIN_EVENT_GEOTAG_HEADER_FOOTER_SINGLE', 'Article Footer Settings (single article)');
@define('PLUGIN_EVENT_GEOTAG_HEADER_HDRTAG', 'Geotagging HTML Header');
@define('PLUGIN_EVENT_GEOTAG_HEADER_HDRTAG_DESC', 'The plugin adds <a href="http://en.wikipedia.org/wiki/Geotag#HTML_pages" target="_blank">geourl meta tags</a> into your HTML header to let others identify easily the geocoordinates of your article or blog.');

@define('PLUGIN_EVENT_GEOTAG_TITLE', 'Geotag');
@define('PLUGIN_EVENT_GEOTAG_DESC', 'Allows entries to be geotagged with coordinates');
@define('PLUGIN_EVENT_GEOTAG_LONG', 'Longitude');
@define('PLUGIN_EVENT_GEOTAG_LONG_DESC', 'Longitude of the center of the map (entry editing), if the geodata are not set in the entry.');
@define('PLUGIN_EVENT_GEOTAG_LAT', 'Latitude');
@define('PLUGIN_EVENT_GEOTAG_LAT_DESC', 'Latitude of the center of the map (entry editing), if the geodata are not set in the entry.');
@define('PLUGIN_EVENT_GEOTAG_ZOOM', 'Zoom');
@define('PLUGIN_EVENT_GEOTAG_ZOOM_DESC', 'Zoom of the map (entry editing). The higher the number the more details you will see.');
@define('PLUGIN_EVENT_GEOTAG_FRONTEND_LABEL', 'Geotagged');
@define('PLUGIN_EVENT_GEOTAG_MAP_URL', 'Map URL');
@define('PLUGIN_EVENT_GEOTAG_MAP_DESC', 'Please specify a deeplink to a map.<br/><b>Google</b>: http://local.google.com/maps?q=%GEO_LAT%,%GEO_LONG%+(%TITLE%)&spn=0.1,0.1&t=m&z=15<br/><b>OSM</b>: http://www.openstreetmap.org/?mlat=%GEO_LAT%&mlon=%GEO_LONG%&zoom=15&layers=M');
@define('PLUGIN_EVENT_GEOTAG_API_KEY', 'Google Maps API key');
@define('PLUGIN_EVENT_GEOTAG_API_KEY_DESC', 'Get it at http://www.google.com/apis/maps/signup.html. Leave empty if you don\'t want to use a GMaps location picker.');
@define('PLUGIN_EVENT_GEOTAG_SERVICE_DESC',     "Do you want to create the footer map images using Google Map or Openstreetmap?");

@define('PLUGIN_EVENT_GEOTAG_EDITOR_AUTOFILL', 'Autofill position into editor');
@define('PLUGIN_EVENT_GEOTAG_EDITOR_AUTOFILL_DESC', 'This will try to autodetec your current location when editing and add the result into the input fields. (Only if your browser supports this)');
@define('PLUGIN_EVENT_GEOTAG_MAP_LINK_BLANK', 'Open map link in new window');
@define('PLUGIN_EVENT_GEOTAG_MAP_LINK_BLANK_DESC', 'When clicking on the position a google map is opened. Should it be displayed in a new window?');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE', 'Show position as map');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_DESC', 'Instead of showing cryptic geo coords you may display a small map of the articles location in the article footer.');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_HEIGHT', 'Map Height');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_HEIGHT_DESC', 'The height of your footer map.');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_WIDTH', 'Map Width');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_WIDTH_DESC', 'The width of your footer map.');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_ZOOM', 'Map zoom');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_ZOOM_DESC', 'The zoom factor of the entries footer map. The higher the number the more details you will see.');

@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_TITLE', 'View location of article');

@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE',		'Google: Map Marker Size');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_DESC',	'The map supports different sizes for markers. Depending on the map size you should use the one that matches best.');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_TINY',	'Tiny');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_SMALL',	'Small');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_MID',	'Mid Size');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_NORMAL',	'Normal');

@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LAT', 'Latitude of your blog');
@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LAT_DESC', 'Enter the latitude of your blog. It will be used, if the article is not geotagged or an article list is displayed. Leave empty, if you don\'t want to geotag these pages.');
@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LONG', 'Longitude of your blog');
@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LONG_DESC', 'Enter the longitude of your blog. It will be used, if the article is not geotagged or an article list is displayed. Leave empty, if you don\'t want to geotag these pages.');

@define('PLUGIN_EVENT_GEOTAG_GEOURL_PINGED',    'GeoURL Service pinged succesfully for the new coordinates. Visit <a href="http://geourl.org/near/?p='.$serendipity['baseURL'].'">your neighbours</a>!');

//
//  serendipity_plugin_geotag.php
//
@define('PLUGIN_GEOTAG_GMAP_NAME',              "Geotag Google/OSM Map");
@define('PLUGIN_GEOTAG_GMAP_NAME_DESC',         "This plugin displays a Google Map or Openstreetmap with geotagged entries");
@define('PLUGIN_GEOTAG_GMAP_TITLE',             "Title");
@define('PLUGIN_GEOTAG_GMAP_TITLE_DESC',        "Enter the Sidebar Title to display:");
@define('PLUGIN_GEOTAG_GMAP_TITLE_DEFAULT',     "Geotagged Map");
@define('PLUGIN_GEOTAG_GMAP_KEY',               "Google Maps API Key (version 3)");
@define('PLUGIN_GEOTAG_GMAP_KEY_DESC',          "Get one following the directions at http://code.google.com/apis/maps/documentation/javascript/tutorial.html#Obtaining_Key and using your blog root URL:");
@define('PLUGIN_GEOTAG_GMAP_WIDTH',             "Width");
@define('PLUGIN_GEOTAG_GMAP_WIDTH_DESC',        "(default = 220).");
@define('PLUGIN_GEOTAG_GMAP_HEIGHT',            "Height");
@define('PLUGIN_GEOTAG_GMAP_HEIGHT_DESC',       "(default = 150).");
@define('PLUGIN_GEOTAG_GMAP_ZOOM',              "Zoom Level");
@define('PLUGIN_GEOTAG_GMAP_ZOOM_DESC',         "(Google: 0-21; OSM: 0-18) Suggested 0 for World View, bigger numbers for zoomed View.");
@define('PLUGIN_GEOTAG_GMAP_LONGITUDE',         "Longitude");
@define('PLUGIN_GEOTAG_GMAP_LONGITUDE_DESC',    "Longitude the map is centered at");
@define('PLUGIN_GEOTAG_GMAP_LATITUDE',         	"Latitude");
@define('PLUGIN_GEOTAG_GMAP_LATITUDE_DESC',    	"Latitude the map is centered at");
@define('PLUGIN_GEOTAG_GMAP_TYPE',              "Type of Map");
@define('PLUGIN_GEOTAG_GMAP_TYPE_DESC',         "Satelliteview, Streetmap, Hybrid, or Terrain");
@define('PLUGIN_GEOTAG_GMAP_SATELLITE',         "Satellite");
@define('PLUGIN_GEOTAG_GMAP_MAP',               "Map");
@define('PLUGIN_GEOTAG_GMAP_HYBRID',            "Hybrid");
@define('PLUGIN_GEOTAG_GMAP_TERRAIN',           "Terrain");
@define('PLUGIN_GEOTAG_GMAP_RSSURL',               "RSS2 URL");
@define('PLUGIN_GEOTAG_GMAP_RSSURL_DESC',          "For getting the geodata from RSS feed: The URL to the geotagged RSS2 feed. You might use a category, or append all=1.");

@define('PLUGIN_GEOTAG_GMAP_DATABASE',              'database');
@define('PLUGIN_GEOTAG_GMAP_GEODATA_SOURCE',        'Geodata source');
@define('PLUGIN_GEOTAG_GMAP_GEODATA_SOURCE_DESC',   'Select a source from which to fetch geodata. In case of "RSS" javascript will read complete RSS feed and pick the geodata from it. In case of "Database" these data will be read from serendipity database. RSS channel has a more general usage, it can save access to the database (due to caching), but if you have a large blog, it can take much time for visitor of your blog to download whole RSS feed.');
@define('PLUGIN_GEOTAG_GMAP_CATEGORY_DESC',         'For getting the geodata from database: Here you can restrict to show the locations only for entries from one category.');

@define('PLUGIN_GEOTAG_SERVICE',                "Map service");
@define('PLUGIN_GEOTAG_SERVICE_DESC',           "You can use maps from Google or Openstreetmap");

//
// Editor
//
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_GET_CODE',      "get current position");
@define('PLUGIN_GEOTAG_GMAP_GEOCODE',           	"find address");
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_TYPE_ADDRESS',  "Type address...");
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_MSG_PROGRESS',  "Trying to find the coordinates...");
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_NOT_FOUND',     "not found");
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_OK',        	"OK");
@define('PLUGIN_EVENT_CLEAR_LOCATION',        		"Clear location");
