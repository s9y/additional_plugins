<?php # lang_cz.inc.php 1.5 2009-08-15 10:21:49 VladaAjgl $

/**
 *  @version 1.5
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Revision-date: 2008/01/27 17:35:00
 *  Revision-author: Vladimír Ajgl <vlada@ajgl.cz>  
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/06/30
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/08/15
 */

//
//  serendipity_event_geotag.php
//

@define('PLUGIN_EVENT_GEOTAG_TITLE',            'Geotag');
@define('PLUGIN_EVENT_GEOTAG_DESC',             'Umo¾òuje pøidat k pøíspìvku zemìpisné souøadnice - geotag');
@define('PLUGIN_EVENT_GEOTAG_LONG',             'Zemìpisná délka');
@define('PLUGIN_EVENT_GEOTAG_LONG_DESC',        'Zemìpisná délka støedu mapy pøi editaci pøíspìvku - mapa pro zadávání souøadnic. Uplatní se pouze pokud v pøíspìvku ji¾ nejsou zadány souøadnice. Pokud jsou zadány, je mapa vystøedìna na zadanou souøadnici.');
@define('PLUGIN_EVENT_GEOTAG_LAT',              'Zemìpisná ¹íøka');
@define('PLUGIN_EVENT_GEOTAG_LAT_DESC',         'Zemìpisná ¹íøka støedu mapy pøi editaci pøíspìvku - mapa pro zadávání souøadnic. Uplatní se pouze pokud v pøíspìvku ji¾ nejsou zadány souøadnice. Pokud jsou zadány, je mapa vystøedìna na zadanou souøadnici.');
@define('PLUGIN_EVENT_GEOTAG_ZOOM',             'Zoom');
@define('PLUGIN_EVENT_GEOTAG_ZOOM_DESC',        'Pøiblí¾ení mapy pøi editaci pøíspìvku - mapa pro zadávání souøadnic.');
@define('PLUGIN_EVENT_GEOTAG_FRONTEND_LABEL',   'Souøadnice');
@define('PLUGIN_EVENT_GEOTAG_MAP_URL',          'URL mapy');
@define('PLUGIN_EVENT_GEOTAG_MAP_DESC',         'Upøesnìte podrobný link do mapy, napøíklad http://local.google.com/maps?q=%GEO_LAT%,%GEO_LONG%+(%TITLE%)&spn=0.1,0.1&t=h');
@define('PLUGIN_EVENT_GEOTAG_API_KEY',          'Google Maps API key');
@define('PLUGIN_EVENT_GEOTAG_API_KEY_DESC',     'Získejte ho na adrese http://www.google.com/apis/maps/signup.html. Ponechte prázdné, pokud nechcete pou¾ívát Google Maps location picker.');

//
//  serendipity_plugin_geotag.php
//

@define('PLUGIN_GEOTAG_GMAP_NAME',              "Geotag Google Map");
@define('PLUGIN_GEOTAG_GMAP_NAME_DESC',         "Tento plugin zobrazuje souøadnice u osouøadnicovaných pøíspìvkù v mapách na Googlu");
@define('PLUGIN_GEOTAG_GMAP_TITLE',             "Nadpis");
@define('PLUGIN_GEOTAG_GMAP_TITLE_DESC',        "Vlo¾te nadpis postraního panelu:");
@define('PLUGIN_GEOTAG_GMAP_TITLE_DEFAULT',     "GMap");
@define('PLUGIN_GEOTAG_GMAP_KEY',               "Google Maps API Key");
@define('PLUGIN_GEOTAG_GMAP_KEY_DESC',          "Získejte jej na http://www.google.com/apis/maps/signup.html zadáním koøenové adresy va¹eho blogu:");
@define('PLUGIN_GEOTAG_GMAP_WIDTH',             "©íøka");
@define('PLUGIN_GEOTAG_GMAP_WIDTH_DESC',        "(výchozí = 220).");
@define('PLUGIN_GEOTAG_GMAP_HEIGHT',            "Vý¹ka");
@define('PLUGIN_GEOTAG_GMAP_HEIGHT_DESC',       "(výchozí = 150).");
@define('PLUGIN_GEOTAG_GMAP_ZOOM',              "Velikost zoomu");
@define('PLUGIN_GEOTAG_GMAP_ZOOM_DESC',         "(0-8) Pøi 0 je vidìt celý svìt, vìt¹í èísla pro bli¾¹í pohled.");
@define('PLUGIN_GEOTAG_GMAP_LONGITUDE',         "Zemìpisná délka");
@define('PLUGIN_GEOTAG_GMAP_LONGITUDE_DESC',    "Zemìpisná délka støedu mapy");
@define('PLUGIN_GEOTAG_GMAP_LATITUDE',         	"Zemìpisná ¹íøka");
@define('PLUGIN_GEOTAG_GMAP_LATITUDE_DESC',    	"Zemìpisná ¹íøka støedu mapy");
@define('PLUGIN_GEOTAG_GMAP_TYPE',              "Typ mapy");
@define('PLUGIN_GEOTAG_GMAP_TYPE_DESC',         "Satelitní, Mapa nebo Hybridní");
@define('PLUGIN_GEOTAG_GMAP_SATELLITE',         "Satelitní");
@define('PLUGIN_GEOTAG_GMAP_MAP',               "Mapa");
@define('PLUGIN_GEOTAG_GMAP_HYBRID',            "Hybridní");
@define('PLUGIN_GEOTAG_GMAP_RSSURL',               "RSS2 URL");
@define('PLUGIN_GEOTAG_GMAP_RSSURL_DESC',          "Pro volbu získávání geodat z RSS kanálu: URL na geotagovaný RSS2 kanál. Mù¾ete pou¾ít jednotlivou kategorii, nebo pøipojit v¹e - all=1.");

@define('PLUGIN_GEOTAG_GMAP_DATABASE',              'databáze');
@define('PLUGIN_GEOTAG_GMAP_GEODATA_SOURCE',        'Zdroj geodat');
@define('PLUGIN_GEOTAG_GMAP_GEODATA_SOURCE_DESC',   'Vyberte, odkud se mají získávat geodata. "RSS" znamená, ¾e javacsript bude naèítat rss kanál, který specifikujete ve volbì ní¾e, z nìj pak bude vysosávat souøadnice. "Databáze" znamená, ¾e se budou naèítat z databáze. RSS kanál je obecnìj¹í a sní¾í zatí¾ení pøístupu do databáze díky mo¾nosti cachování, ale pokud máte rozsáhlý blog, mù¾e u¾ivateli napoprvé trvat dlouhou dobu, ne¾ se stáhne kompletní RSS kanál.');
@define('PLUGIN_GEOTAG_GMAP_CATEGORY_DESC',         'Pro volbu získávání geodat z databáze: Zde mù¾ete omezit zobrazování souøadnic na pøíspìvky z jediné kategorie.');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE',           'najít adresu');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_TYPE_ADDRESS','Napi¹te adresu...');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_MSG_PROGRESS','Sna¾ím se najít souøadnice...');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_NOT_FOUND', 'nenalezeno:-(');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_OK',        'OK');