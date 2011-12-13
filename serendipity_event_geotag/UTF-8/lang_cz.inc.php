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
@define('PLUGIN_EVENT_GEOTAG_DESC',             'Umožňuje přidat k příspěvku zeměpisné souřadnice - geotag');
@define('PLUGIN_EVENT_GEOTAG_LONG',             'Zeměpisná délka');
@define('PLUGIN_EVENT_GEOTAG_LONG_DESC',        'Zeměpisná délka středu mapy při editaci příspěvku - mapa pro zadávání souřadnic. Uplatní se pouze pokud v příspěvku již nejsou zadány souřadnice. Pokud jsou zadány, je mapa vystředěna na zadanou souřadnici.');
@define('PLUGIN_EVENT_GEOTAG_LAT',              'Zeměpisná šířka');
@define('PLUGIN_EVENT_GEOTAG_LAT_DESC',         'Zeměpisná šířka středu mapy při editaci příspěvku - mapa pro zadávání souřadnic. Uplatní se pouze pokud v příspěvku již nejsou zadány souřadnice. Pokud jsou zadány, je mapa vystředěna na zadanou souřadnici.');
@define('PLUGIN_EVENT_GEOTAG_ZOOM',             'Zoom');
@define('PLUGIN_EVENT_GEOTAG_ZOOM_DESC',        'Přiblížení mapy při editaci příspěvku - mapa pro zadávání souřadnic.');
@define('PLUGIN_EVENT_GEOTAG_FRONTEND_LABEL',   'Souřadnice');
@define('PLUGIN_EVENT_GEOTAG_MAP_URL',          'URL mapy');
@define('PLUGIN_EVENT_GEOTAG_MAP_DESC',         'Upřesněte podrobný link do mapy, například http://local.google.com/maps?q=%GEO_LAT%,%GEO_LONG%+(%TITLE%)&spn=0.1,0.1&t=h');
@define('PLUGIN_EVENT_GEOTAG_API_KEY',          'Google Maps API key');
@define('PLUGIN_EVENT_GEOTAG_API_KEY_DESC',     'Získejte ho na adrese http://www.google.com/apis/maps/signup.html. Ponechte prázdné, pokud nechcete používát Google Maps location picker.');

//
//  serendipity_plugin_geotag.php
//

@define('PLUGIN_GEOTAG_GMAP_NAME',              "Geotag Google Map");
@define('PLUGIN_GEOTAG_GMAP_NAME_DESC',         "Tento plugin zobrazuje souřadnice u osouřadnicovaných příspěvků v mapách na Googlu");
@define('PLUGIN_GEOTAG_GMAP_TITLE',             "Nadpis");
@define('PLUGIN_GEOTAG_GMAP_TITLE_DESC',        "Vložte nadpis postraního panelu:");
@define('PLUGIN_GEOTAG_GMAP_TITLE_DEFAULT',     "GMap");
@define('PLUGIN_GEOTAG_GMAP_KEY',               "Google Maps API Key");
@define('PLUGIN_GEOTAG_GMAP_KEY_DESC',          "Získejte jej na http://www.google.com/apis/maps/signup.html zadáním kořenové adresy vašeho blogu:");
@define('PLUGIN_GEOTAG_GMAP_WIDTH',             "Šířka");
@define('PLUGIN_GEOTAG_GMAP_WIDTH_DESC',        "(výchozí = 220).");
@define('PLUGIN_GEOTAG_GMAP_HEIGHT',            "Výška");
@define('PLUGIN_GEOTAG_GMAP_HEIGHT_DESC',       "(výchozí = 150).");
@define('PLUGIN_GEOTAG_GMAP_ZOOM',              "Velikost zoomu");
@define('PLUGIN_GEOTAG_GMAP_ZOOM_DESC',         "(0-8) Při 0 je vidět celý svět, větší čísla pro bližší pohled.");
@define('PLUGIN_GEOTAG_GMAP_LONGITUDE',         "Zeměpisná délka");
@define('PLUGIN_GEOTAG_GMAP_LONGITUDE_DESC',    "Zeměpisná délka středu mapy");
@define('PLUGIN_GEOTAG_GMAP_LATITUDE',         	"Zeměpisná šířka");
@define('PLUGIN_GEOTAG_GMAP_LATITUDE_DESC',    	"Zeměpisná šířka středu mapy");
@define('PLUGIN_GEOTAG_GMAP_TYPE',              "Typ mapy");
@define('PLUGIN_GEOTAG_GMAP_TYPE_DESC',         "Satelitní, Mapa nebo Hybridní");
@define('PLUGIN_GEOTAG_GMAP_SATELLITE',         "Satelitní");
@define('PLUGIN_GEOTAG_GMAP_MAP',               "Mapa");
@define('PLUGIN_GEOTAG_GMAP_HYBRID',            "Hybridní");
@define('PLUGIN_GEOTAG_GMAP_RSSURL',               "RSS2 URL");
@define('PLUGIN_GEOTAG_GMAP_RSSURL_DESC',          "Pro volbu získávání geodat z RSS kanálu: URL na geotagovaný RSS2 kanál. Můžete použít jednotlivou kategorii, nebo připojit vše - all=1.");

@define('PLUGIN_GEOTAG_GMAP_DATABASE',              'databáze');
@define('PLUGIN_GEOTAG_GMAP_GEODATA_SOURCE',        'Zdroj geodat');
@define('PLUGIN_GEOTAG_GMAP_GEODATA_SOURCE_DESC',   'Vyberte, odkud se mají získávat geodata. "RSS" znamená, že javacsript bude načítat rss kanál, který specifikujete ve volbě níže, z něj pak bude vysosávat souřadnice. "Databáze" znamená, že se budou načítat z databáze. RSS kanál je obecnější a sníží zatížení přístupu do databáze díky možnosti cachování, ale pokud máte rozsáhlý blog, může uživateli napoprvé trvat dlouhou dobu, než se stáhne kompletní RSS kanál.');
@define('PLUGIN_GEOTAG_GMAP_CATEGORY_DESC',         'Pro volbu získávání geodat z databáze: Zde můžete omezit zobrazování souřadnic na příspěvky z jediné kategorie.');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE',           'najít adresu');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_TYPE_ADDRESS','Napište adresu...');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_MSG_PROGRESS','Snažím se najít souřadnice...');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_NOT_FOUND', 'nenalezeno:-(');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_OK',        'OK');