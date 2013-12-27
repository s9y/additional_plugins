/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Revision-date: 2008/01/27 17:35:00
 *  Revision-author: Vladimír Ajgl <vlada@ajgl.cz>  
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/06/30
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/08/15
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/01/10
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/06/22
 */

//
//  serendipity_event_geotag.php
//

@define('PLUGIN_EVENT_GEOTAG_TITLE',            'Geotag');
@define('PLUGIN_EVENT_GEOTAG_DESC',             'Umoòuje pøidat k pøíspìvku zemìpisné souøadnice - geotag');
@define('PLUGIN_EVENT_GEOTAG_LONG',             'Zemìpisná délka');
@define('PLUGIN_EVENT_GEOTAG_LONG_DESC',        'Zemìpisná délka støedu mapy pøi editaci pøíspìvku - mapa pro zadávání souøadnic. Uplatní se pouze pokud v pøíspìvku ji nejsou zadány souøadnice. Pokud jsou zadány, je mapa vystøedìna na zadanou souøadnici.');
@define('PLUGIN_EVENT_GEOTAG_LAT',              'Zemìpisná šíøka');
@define('PLUGIN_EVENT_GEOTAG_LAT_DESC',         'Zemìpisná šíøka støedu mapy pøi editaci pøíspìvku - mapa pro zadávání souøadnic. Uplatní se pouze pokud v pøíspìvku ji nejsou zadány souøadnice. Pokud jsou zadány, je mapa vystøedìna na zadanou souøadnici.');
@define('PLUGIN_EVENT_GEOTAG_ZOOM',             'Zoom');
@define('PLUGIN_EVENT_GEOTAG_ZOOM_DESC',        'Pøiblíení mapy pøi editaci pøíspìvku - mapa pro zadávání souøadnic.');
@define('PLUGIN_EVENT_GEOTAG_FRONTEND_LABEL',   'Souøadnice');
@define('PLUGIN_EVENT_GEOTAG_MAP_URL',          'URL mapy');
@define('PLUGIN_EVENT_GEOTAG_MAP_DESC',         'Upøesnìte podrobnı link do mapy, napøíklad http://local.google.com/maps?q=%GEO_LAT%,%GEO_LONG%+(%TITLE%)&spn=0.1,0.1&t=h');
@define('PLUGIN_EVENT_GEOTAG_API_KEY',          'Google Maps API key');
@define('PLUGIN_EVENT_GEOTAG_API_KEY_DESC',     'Získejte ho na adrese http://www.google.com/apis/maps/signup.html. Ponechte prázdné, pokud nechcete pouívát Google Maps location picker.');

//
//  serendipity_plugin_geotag.php
//

@define('PLUGIN_GEOTAG_GMAP_NAME',              "Geotag Google Map");
@define('PLUGIN_GEOTAG_GMAP_NAME_DESC',         "Tento plugin zobrazuje souøadnice u osouøadnicovanıch pøíspìvkù v mapách na Googlu");
@define('PLUGIN_GEOTAG_GMAP_TITLE',             "Nadpis");
@define('PLUGIN_GEOTAG_GMAP_TITLE_DESC',        "Vlote nadpis postraního panelu:");
@define('PLUGIN_GEOTAG_GMAP_TITLE_DEFAULT',     "GMap");
@define('PLUGIN_GEOTAG_GMAP_KEY',               "Google Maps API Key");
@define('PLUGIN_GEOTAG_GMAP_KEY_DESC',          "Získejte jej na http://www.google.com/apis/maps/signup.html zadáním koøenové adresy vašeho blogu:");
@define('PLUGIN_GEOTAG_GMAP_WIDTH',             "Šíøka");
@define('PLUGIN_GEOTAG_GMAP_WIDTH_DESC',        "(vıchozí = 220).");
@define('PLUGIN_GEOTAG_GMAP_HEIGHT',            "Vıška");
@define('PLUGIN_GEOTAG_GMAP_HEIGHT_DESC',       "(vıchozí = 150).");
@define('PLUGIN_GEOTAG_GMAP_ZOOM',              "Velikost zoomu");
@define('PLUGIN_GEOTAG_GMAP_ZOOM_DESC',         "(0-8) Pøi 0 je vidìt celı svìt, vìtší èísla pro bliší pohled.");
@define('PLUGIN_GEOTAG_GMAP_LONGITUDE',         "Zemìpisná délka");
@define('PLUGIN_GEOTAG_GMAP_LONGITUDE_DESC',    "Zemìpisná délka støedu mapy");
@define('PLUGIN_GEOTAG_GMAP_LATITUDE',         	"Zemìpisná šíøka");
@define('PLUGIN_GEOTAG_GMAP_LATITUDE_DESC',    	"Zemìpisná šíøka støedu mapy");
@define('PLUGIN_GEOTAG_GMAP_TYPE',              "Typ mapy");
@define('PLUGIN_GEOTAG_GMAP_TYPE_DESC',         "Satelitní, Mapa nebo Hybridní");
@define('PLUGIN_GEOTAG_GMAP_SATELLITE',         "Satelitní");
@define('PLUGIN_GEOTAG_GMAP_MAP',               "Mapa");
@define('PLUGIN_GEOTAG_GMAP_HYBRID',            "Hybridní");
@define('PLUGIN_GEOTAG_GMAP_RSSURL',               "RSS2 URL");
@define('PLUGIN_GEOTAG_GMAP_RSSURL_DESC',          "Pro volbu získávání geodat z RSS kanálu: URL na geotagovanı RSS2 kanál. Mùete pouít jednotlivou kategorii, nebo pøipojit vše - all=1.");

@define('PLUGIN_GEOTAG_GMAP_DATABASE',              'databáze');
@define('PLUGIN_GEOTAG_GMAP_GEODATA_SOURCE',        'Zdroj geodat');
@define('PLUGIN_GEOTAG_GMAP_GEODATA_SOURCE_DESC',   'Vyberte, odkud se mají získávat geodata. "RSS" znamená, e javacsript bude naèítat rss kanál, kterı specifikujete ve volbì níe, z nìj pak bude vysosávat souøadnice. "Databáze" znamená, e se budou naèítat z databáze. RSS kanál je obecnìjší a sníí zatíení pøístupu do databáze díky monosti cachování, ale pokud máte rozsáhlı blog, mùe uivateli napoprvé trvat dlouhou dobu, ne se stáhne kompletní RSS kanál.');
@define('PLUGIN_GEOTAG_GMAP_CATEGORY_DESC',         'Pro volbu získávání geodat z databáze: Zde mùete omezit zobrazování souøadnic na pøíspìvky z jediné kategorie.');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE',           'najít adresu');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_TYPE_ADDRESS','Napište adresu...');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_MSG_PROGRESS','Snaím se najít souøadnice...');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_NOT_FOUND', 'nenalezeno:-(');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_OK',        'OK');

// Next lines were translated on 2012/01/10

@define('PLUGIN_EVENT_GEOTAG_WARNING_GEOURL_PLUGIN','VAROVÁNÍ: nalezen plugin GeoUrl. Odinstalujte ho prosím, je zastaralı a dále neudrovanı.<br/>Všechny jeho funkce jsou zajištìny i pluginem GeoTag. Plugin GeoTag je podrobnìjší, umí toho víc.');
@define('PLUGIN_EVENT_GEOTAG_HEADER_EDITOR',    'Nastavení editoru pøíspìvku');
@define('PLUGIN_EVENT_GEOTAG_HEADER_FOOTER',    'Nastavení patièky pøíspìvku');
@define('PLUGIN_EVENT_GEOTAG_HEADER_FOOTER_LIST','Nastavení patièky pøíspìvku (v pøehledu pøíspìvkù)');
@define('PLUGIN_EVENT_GEOTAG_HEADER_FOOTER_SINGLE','Nastavení patièky pøíspìvku (pøi zobrazení jediného pøíspìvku)');
@define('PLUGIN_EVENT_GEOTAG_HEADER_HDRTAG',    'HTML hlavièka GeoTagu');
@define('PLUGIN_EVENT_GEOTAG_HEADER_HDRTAG_DESC','Tento plugin pøidává <a href="http://en.wikipedia.org/wiki/Geotag#HTML_pages" target="_blank">geourl meta tagy</a> do HTML hlavièky stránky. Tak umoòuje ostatním snadno zjistit zemìpisné souøadnice èlánku nebo blogu.');
@define('PLUGIN_EVENT_GEOTAG_SERVICE_DESC',     'Chcete vytvoøit mapu do patièky stránky pomocí Google Map nebo pomocí Openstreetmap?');
@define('PLUGIN_EVENT_GEOTAG_EDITOR_AUTOFILL',  'Automaticky vyplòovat polohu v editoru');
@define('PLUGIN_EVENT_GEOTAG_EDITOR_AUTOFILL_DESC','To se pokusí automaticky zjistit Vaši aktuální polohu pøi psaní pøíspìvku a zjišenou hodnotu pøedvyplní do políèka polohy. (Pouze pokud tuto funkci podporuje prohlíeè.)');
@define('PLUGIN_EVENT_GEOTAG_MAP_LINK_BLANK',   'Otevøít odkazy z mapy v novém oknì');
@define('PLUGIN_EVENT_GEOTAG_MAP_LINK_BLANK_DESC','Pøi kliknutí na polohu je otevøená google mapa. Má se zobrazovat v novém oknì prohlíeèe?');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE',       'Zobrazovat polohu jako mapu');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_DESC',  'Místo zobrazování nicneøíkajících èíselnıch zemìpisnıch souøadnic mùete v patièce pøíspìvku zobrazit malou mapku.');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_HEIGHT','Vıška mapy');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_HEIGHT_DESC','Vıška mapy v patièce');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_WIDTH', 'Šíøka mapy');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_WIDTH_DESC','Šíøka mapy v patièce');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_ZOOM',  'Zoom mapy');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_ZOOM_DESC','Zoom faktor pro mapu v patièce. Èím vìtší èíslo, tím podrobnìjší mapa bude.');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_TITLE', 'Zobrazovat polohu pøíspìvku');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE','Google: Velikost mapovıch køíkù');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_DESC','Mapa umoòuje pouít rùznou velikost znaèkovacích køíkù. V závislosti na velikosti mapy byste se mìli vybrat velikost, která Vám nejvíc vyhovuje.');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_TINY','Mròavé');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_SMALL','Malé');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_MID','Støední');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_NORMAL','Normální');
@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LAT','Zemìpsiná šíøka blogu');
@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LAT_DESC','Zadejte zemìpsinou šíøku blogu. Bude pouita u pøíspìvkù, které nemají pøiøazenou vlastní polohu, a u pøehledu pøíspìvkù. Ponechte prázdné pokud nechcete tyto stránky oznaèovat souøadnicemi.');
@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LONG','Zemìpisná délka blogu');
@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LONG_DESC','Zadejte zemìpsinou délku blogu. Bude pouita u pøíspìvkù, které nemají pøiøazenou vlastní polohu, a u pøehledu pøíspìvkù. Ponechte prázdné pokud nechcete tyto stránky oznaèovat souøadnicemi.');
@define('PLUGIN_EVENT_GEOTAG_GEOURL_PINGED',    'Sluba GeoURL úspìšnì kontaktována pro získání novıch souøadnic. Navštivte <a href="http://geourl.org/near/?p='.$serendipity['baseURL'].'">Vaše sousedy</a>!');
@define('PLUGIN_GEOTAG_GMAP_TERRAIN',           'Povrch');
@define('PLUGIN_GEOTAG_SERVICE',                'Mapová sluba');
@define('PLUGIN_GEOTAG_SERVICE_DESC',           'Jako mapovı podklad mùete pouít buï mapy Googlu nebo Openstreetmap');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_GET_CODE',  'vaše aktuální poloha');

// Next lines were translated on 2012/06/22
@define('PLUGIN_EVENT_CLEAR_LOCATION',           'Smazat polohu');