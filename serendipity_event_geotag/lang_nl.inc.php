<?php # 

/**
 *  @version $Revision$
 *  @author Translator Name <zoran@kovacevic.nl>
 *  NL-Revision: Revision of lang_nl.inc.php
 */

//
//  serendipity_event_geotag.php
//
@define('PLUGIN_EVENT_GEOTAG_TITLE', 'Geotag');
@define('PLUGIN_EVENT_GEOTAG_DESC', 'Maakt het mogelijk om items te voorzien van geografische locatie: geotag');
@define('PLUGIN_EVENT_GEOTAG_LONG', 'Longitude');
@define('PLUGIN_EVENT_GEOTAG_LAT', 'Latitude');
@define('PLUGIN_EVENT_GEOTAG_FRONTEND_LABEL', 'Geotagged');
@define('PLUGIN_EVENT_GEOTAG_MAP_URL', 'Map URL');
@define('PLUGIN_EVENT_GEOTAG_MAP_DESC', 'Specificeer een deeplink naar een map, b.v. http://local.google.com/maps?q=%GEO_LAT%,%GEO_LONG%+(%TITLE%)&spn=0.1,0.1&t=h');
@define('PLUGIN_EVENT_GEOTAG_API_KEY', 'Google Maps API key');
@define('PLUGIN_EVENT_GEOTAG_API_KEY_DESC', 'Genereer een key op http://www.google.com/apis/maps/signup.html. Dit veld kun je leeglaten indien je niet gebruik wilt maken van een GMaps locatie bepaler.');

//
//  serendipity_plugin_geotag.php
//
@define('PLUGIN_GEOTAG_GMAP_NAME',              "Geotag Google Map");
@define('PLUGIN_GEOTAG_GMAP_NAME_DESC',         "Deze plugin toont een Google Map met de geotagged items");
@define('PLUGIN_GEOTAG_GMAP_TITLE',             "Titel");
@define('PLUGIN_GEOTAG_GMAP_TITLE_DESC',        "Voer de titel in welke in de sidebar getoond wordt");
@define('PLUGIN_GEOTAG_GMAP_TITLE_DEFAULT',     "GMap");
@define('PLUGIN_GEOTAG_GMAP_KEY',               "Google Maps API Key");
@define('PLUGIN_GEOTAG_GMAP_KEY_DESC',          "Genereer een key op http://www.google.com/apis/maps/signup.html met de basis URL:");
@define('PLUGIN_GEOTAG_GMAP_WIDTH',             "Breedte");
@define('PLUGIN_GEOTAG_GMAP_WIDTH_DESC',        "(standaard = 220).");
@define('PLUGIN_GEOTAG_GMAP_HEIGHT',            "Hoogte");
@define('PLUGIN_GEOTAG_GMAP_HEIGHT_DESC',       "(standaard = 150).");
@define('PLUGIN_GEOTAG_GMAP_ZOOM',              "Zoom niveau");
@define('PLUGIN_GEOTAG_GMAP_ZOOM_DESC',         "(9-17) Gebruik 17 voor de wereld, kleinere getallen voor een ingezoomde view.");
@define('PLUGIN_GEOTAG_GMAP_RSSURL',               "RSS2 URL");
@define('PLUGIN_GEOTAG_GMAP_RSSURL_DESC',          "Voer de URL in naar een geotagged RSS2 feed. Je kunt natuurlijk ook verwijzen naar een categorie, of all=1 aan de URL toevoegen om alle items te tonen.");
?>