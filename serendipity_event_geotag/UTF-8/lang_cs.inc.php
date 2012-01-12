<?php # lang_cs.inc.php 1.6 2012-01-10 21:17:17 VladaAjgl $

/**
 *  @version 1.6
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

// Next lines were translated on 2012/01/10
@define('PLUGIN_EVENT_GEOTAG_WARNING_GEOURL_PLUGIN','VAROVÁNÍ: nalezen plugin GeoUrl. Odinstalujte ho prosím, je zastaralý a dále neudržovaný.<br/>Všechny jeho funkce jsou zajištěny i pluginem GeoTag. Plugin GeoTag je podrobnější, umí toho víc.');
@define('PLUGIN_EVENT_GEOTAG_HEADER_EDITOR',    'Nastavení editoru příspěvku');
@define('PLUGIN_EVENT_GEOTAG_HEADER_FOOTER',    'Nastavení patičky příspěvku');
@define('PLUGIN_EVENT_GEOTAG_HEADER_FOOTER_LIST','Nastavení patičky příspěvku (v přehledu příspěvků)');
@define('PLUGIN_EVENT_GEOTAG_HEADER_FOOTER_SINGLE','Nastavení patičky příspěvku (při zobrazení jediného příspěvku)');
@define('PLUGIN_EVENT_GEOTAG_HEADER_HDRTAG',    'HTML hlavička GeoTagu');
@define('PLUGIN_EVENT_GEOTAG_HEADER_HDRTAG_DESC','Tento plugin přidává <a href="http://en.wikipedia.org/wiki/Geotag#HTML_pages" target="_blank">geourl meta tagy</a> do HTML hlavičky stránky. Tak umožňuje ostatním snadno zjistit zeměpisné souřadnice článku nebo blogu.');
@define('PLUGIN_EVENT_GEOTAG_SERVICE_DESC',     'Chcete vytvořit mapu do patičky stránky pomocí Google Map nebo pomocí Openstreetmap?');
@define('PLUGIN_EVENT_GEOTAG_EDITOR_AUTOFILL',  'Automaticky vyplňovat polohu v editoru');
@define('PLUGIN_EVENT_GEOTAG_EDITOR_AUTOFILL_DESC','To se pokusí automaticky zjistit Vaši aktuální polohu při psaní příspěvku a zjišťenou hodnotu předvyplní do políčka polohy. (Pouze pokud tuto funkci podporuje prohlížeč.)');
@define('PLUGIN_EVENT_GEOTAG_MAP_LINK_BLANK',   'Otevřít odkazy z mapy v novém okně');
@define('PLUGIN_EVENT_GEOTAG_MAP_LINK_BLANK_DESC','Při kliknutí na polohu je otevřená google mapa. Má se zobrazovat v novém okně prohlížeče?');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE',       'Zobrazovat polohu jako mapu');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_DESC',  'Místo zobrazování nicneříkajících číselných zeměpisných souřadnic můžete v patičce příspěvku zobrazit malou mapku.');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_HEIGHT','Výška mapy');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_HEIGHT_DESC','Výška mapy v patičce');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_WIDTH', 'Šířka mapy');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_WIDTH_DESC','Šířka mapy v patičce');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_ZOOM',  'Zoom mapy');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_ZOOM_DESC','Zoom faktor pro mapu v patičce. Čím větší číslo, tím podrobnější mapa bude.');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_TITLE', 'Zobrazovat polohu příspěvku');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE','Google: Velikost mapových křížků');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_DESC','Mapa umožňuje použít různou velikost značkovacích křížků. V závislosti na velikosti mapy byste se měli vybrat velikost, která Vám nejvíc vyhovuje.');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_TINY','Mrňavé');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_SMALL','Malé');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_MID','Střední');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_NORMAL','Normální');
@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LAT','Zeměpsiná šířka blogu');
@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LAT_DESC','Zadejte zeměpsinou šířku blogu. Bude použita u příspěvků, které nemají přiřazenou vlastní polohu, a u přehledu příspěvků. Ponechte prázdné pokud nechcete tyto stránky označovat souřadnicemi.');
@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LONG','Zeměpisná délka blogu');
@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LONG_DESC','Zadejte zeměpsinou délku blogu. Bude použita u příspěvků, které nemají přiřazenou vlastní polohu, a u přehledu příspěvků. Ponechte prázdné pokud nechcete tyto stránky označovat souřadnicemi.');
@define('PLUGIN_EVENT_GEOTAG_GEOURL_PINGED',    'Služba GeoURL úspěšně kontaktována pro získání nových souřadnic. Navštivte <a href="http://geourl.org/near/?p='.$serendipity['baseURL'].'">Vaše sousedy</a>!');
@define('PLUGIN_GEOTAG_GMAP_TERRAIN',           'Povrch');
@define('PLUGIN_GEOTAG_SERVICE',                'Mapová služba');
@define('PLUGIN_GEOTAG_SERVICE_DESC',           'Jako mapový podklad můžete použít buď mapy Googlu nebo Openstreetmap');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_GET_CODE',  'vaše aktuální poloha');