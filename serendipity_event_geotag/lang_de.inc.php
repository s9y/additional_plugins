<?php # 

/**
 *  @version $Revision$
 *  @author Holger Mitterwald <murgul@sourceforge.net>
 *  EN-Revision: Revision of lang_de.inc.php
 */

//
//  serendipity_event_geotag.php
//
@define('PLUGIN_EVENT_GEOTAG_WARNING_GEOURL_PLUGIN', 'ACHTUNG: Das GeoUrl Plugin wurde erkannt. Bitte deinstalliere dieses, es ist obsolet.<br/>Die Funktionen, die es implementiert, sind auch im GeoTag Plugin enthalten. Das GeoTag Plugin ist sogar detailierter.');

@define('PLUGIN_EVENT_GEOTAG_HEADER_EDITOR', 'Einstellungen: Artikel Editor');
@define('PLUGIN_EVENT_GEOTAG_HEADER_FOOTER', 'Einstellungen: Artikel Footer');
@define('PLUGIN_EVENT_GEOTAG_HEADER_FOOTER_LIST', 	'Einstellungen: Artikel Footer (Listenansicht)');
@define('PLUGIN_EVENT_GEOTAG_HEADER_FOOTER_SINGLE', 'Einstellungen: Artikel Footer (Einzelartikel)');
@define('PLUGIN_EVENT_GEOTAG_HEADER_HDRTAG', 'Geotagging im HTML Kopfbereich');
@define('PLUGIN_EVENT_GEOTAG_HEADER_HDRTAG_DESC', 'Das Plugin fügt <a href="http://de.wikipedia.org/wiki/Geotag" target="_blank">Geourl MetaTags</a> in den HTML Kopf ein, damit andere es leichter haben, die Geokoordinaten eines Artikels oder des Blogs auszulesen.');

@define('PLUGIN_EVENT_GEOTAG_TITLE', 'Geotag');
@define('PLUGIN_EVENT_GEOTAG_DESC', 'Erlaubt Einträge mit Geokoordinaten zu versehen');
@define('PLUGIN_EVENT_GEOTAG_LONG', 'Längengrad');
@define('PLUGIN_EVENT_GEOTAG_LONG_DESC', 'Längengrad, auf dem die Editor Karte mittig gesetzt werden soll, wenn noch keine Geodaten im Eintrag gesetzt sind.');
@define('PLUGIN_EVENT_GEOTAG_LAT', 'Breitengrad');
@define('PLUGIN_EVENT_GEOTAG_LAT_DESC', 'Breitengrad, auf dem die Editor Karte mittig gesetzt werden soll, wenn noch keine Geodaten im Eintrag gesetzt sind.');
@define('PLUGIN_EVENT_GEOTAG_ZOOM', 'Zoom');
@define('PLUGIN_EVENT_GEOTAG_ZOOM_DESC', 'Zoom Stufe der Editor Karte. Je größer die Zahl, desto mehr Details sind zu sehen.');
@define('PLUGIN_EVENT_GEOTAG_FRONTEND_LABEL', 'Geotagged');
@define('PLUGIN_EVENT_GEOTAG_MAP_URL', 'Karten URL');
@define('PLUGIN_EVENT_GEOTAG_MAP_DESC', 'Bitte direkten Link zu einer Karte angeben.<br/><b>Google</b>: http://local.google.com/maps?q=%GEO_LAT%,%GEO_LONG%+(%TITLE%)&spn=0.1,0.1&t=m&z=15<br/><b>OSM</b>: http://www.openstreetmap.org/?mlat=%GEO_LAT%&mlon=%GEO_LONG%&zoom=15&layers=M');
@define('PLUGIN_EVENT_GEOTAG_API_KEY', 'Google Maps API key');
@define('PLUGIN_EVENT_GEOTAG_API_KEY_DESC', 'Anfordern unter http://www.google.com/apis/maps/signup.html. Bitte freilassen, wenn Sie keinen GMaps location picker verwenden möchten.');
@define('PLUGIN_EVENT_GEOTAG_SERVICE_DESC',     "Möchtest Du die Footer Karte mit Google Maps oder Openstreetmap erzeugen?");

@define('PLUGIN_EVENT_GEOTAG_EDITOR_AUTOFILL', 'Automatisch Editor Position befüllen');
@define('PLUGIN_EVENT_GEOTAG_EDITOR_AUTOFILL_DESC', 'Hiermit wird versucht, Deine aktuelle Position automatisch zu erkennen und in den Editor einzutragen. Funktioniert nur mit Browsern, die das unterstützen.');
@define('PLUGIN_EVENT_GEOTAG_MAP_LINK_BLANK', 'Karte in neuem Fenster öffnen');
@define('PLUGIN_EVENT_GEOTAG_MAP_LINK_BLANK_DESC', 'Wenn auf die Position geklickt wird, so wird eine Karte angezeigt. Soll diese in einem neuen Fenster geöffnet werden?');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE', 'Position als Karte anzeigen');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_DESC', 'Anstatt die Position im Artikel Footer als cryptische Geo Koordinaten anzuzeigen, kann eine kleine Karte erzeugt werden.');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_HEIGHT', 'Karten Höhe');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_HEIGHT_DESC', 'Die Höhe der Karte, die im Footer erzeugt werden soll.');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_WIDTH', 'Karten Breite');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_WIDTH_DESC', 'Die Breite der Karte, die im Footer erzeugt werden soll.');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_ZOOM', 'Karten Zoom');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_ZOOM_DESC', 'Zoom Stufe der Karte im Artikel Footer. Je größer die Zahl, desto mehr Details sind zu sehen.');

@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_TITLE', 'Postion des Artikels anzeigen');

@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE',		'Google: Größe der Kartenmarkierung');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_DESC',	'Die Karten unterstützt unterschiedliche Markierungsgrößen. Je nach gewählter Kartengröße sollte hier etwas passendes ausgewählt werden.');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_TINY',	'Winzig');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_SMALL',	'Klein');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_MID',	'Mittel');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_NORMAL',	'Normal');

@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LAT', 'Breitengrad Deines Blogs');
@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LAT_DESC', 'Bitte den Breitengrad Deines Blogs eintragen. Dieser wird benutzt, wenn der dargestellte Artikel nicht geotagged ist oder die Artikel Liste dargestellt wird. Leer lassen, wenn Du in diesen Fällen keinen Eintrag im HTML Kopf haben möchtest.');
@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LONG', 'Längengrad Deines Blogs');
@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LONG_DESC', 'Bitte den Längengrad Deines Blogs eintragen. Dieser wird benutzt, wenn der dargestellte Artikel nicht geotagged ist oder die Artikel Liste dargestellt wird. Leer lassen, wenn Du in diesen Fällen keinen Eintrag im HTML Kopf haben möchtest.');

@define('PLUGIN_EVENT_GEOTAG_GEOURL_PINGED',    'GeoURL Service erfolgreich über die neuen Koordinaten benachrichtigt. Besuche <a href="http://geourl.org/near/?p='.$serendipity['baseURL'].'">deine Nachbarn</a>!');
//
//  serendipity_plugin_geotag.php
//
@define('PLUGIN_GEOTAG_GMAP_NAME',              "Geotag Google/OSM Map");
@define('PLUGIN_GEOTAG_GMAP_NAME_DESC',         "Dieses Plugin zeigt eine Google Map oder Openstreetmap mit geocodierten Einträgen an.");
@define('PLUGIN_GEOTAG_GMAP_TITLE',             "Titel");
@define('PLUGIN_GEOTAG_GMAP_TITLE_DESC',        "Bitte Sidebar Titel angeben:");
@define('PLUGIN_GEOTAG_GMAP_TITLE_DEFAULT',     "GMap");
@define('PLUGIN_GEOTAG_GMAP_KEY',               "Google Maps API Key (Version 3)");
@define('PLUGIN_GEOTAG_GMAP_KEY_DESC',          "Anfordern wie unter http://code.google.com/apis/maps/documentation/javascript/tutorial.html#Obtaining_Key beschrieben mit der Basis-URL des Blogs.");
@define('PLUGIN_GEOTAG_GMAP_WIDTH',             "Breite");
@define('PLUGIN_GEOTAG_GMAP_WIDTH_DESC',        "(default = 220).");
@define('PLUGIN_GEOTAG_GMAP_HEIGHT',            "Höhe");
@define('PLUGIN_GEOTAG_GMAP_HEIGHT_DESC',       "(default = 150).");
@define('PLUGIN_GEOTAG_GMAP_ZOOM',              "Zoom Level");
@define('PLUGIN_GEOTAG_GMAP_ZOOM_DESC',         "(Google, 0.21; OSM: 0-18) Empfohlen: 1 für Weltweit, größere Zahlen für verkleinerte Darstellung");
@define('PLUGIN_GEOTAG_GMAP_LONGITUDE',         "Längengrad");
@define('PLUGIN_GEOTAG_GMAP_LONGITUDE_DESC',    "Längengrad, auf den die Karte zentriert wird");
@define('PLUGIN_GEOTAG_GMAP_LATITUDE',         	"Breitengrad");
@define('PLUGIN_GEOTAG_GMAP_LATITUDE_DESC',    	"Breitengrad, auf den die Karte zentriert wird");
@define('PLUGIN_GEOTAG_GMAP_TYPE',              "Kartentyp");
@define('PLUGIN_GEOTAG_GMAP_TYPE_DESC',         "Satellitenansicht, Straßenkarte, Hybrid oder Terrain");
@define('PLUGIN_GEOTAG_GMAP_SATELLITE',         "Satellit");
@define('PLUGIN_GEOTAG_GMAP_MAP',               "Karte");
@define('PLUGIN_GEOTAG_GMAP_HYBRID',            "Hybrid");
@define('PLUGIN_GEOTAG_GMAP_TERRAIN',           "Terrain");
@define('PLUGIN_GEOTAG_GMAP_RSSURL',            "RSS2 URL");
@define('PLUGIN_GEOTAG_GMAP_RSSURL_DESC',       "Die URL zum geocodierten RSS2-Feed. Sie können eine Kategorie verwenden oder alle mit \'1\'.");

@define('PLUGIN_GEOTAG_GMAP_DATABASE',              'Datenbank');
@define('PLUGIN_GEOTAG_GMAP_GEODATA_SOURCE',        'Geodata-Quelle');
@define('PLUGIN_GEOTAG_GMAP_GEODATA_SOURCE_DESC',   'Quelle auswählen, aus der die Geodaten bezogen werden sollen. Im Fall von "RSS" wird JavaScript den kompletten RSS Feed lesen und Geodaten daraus sammeln. Mit "Datenbank" werden diese Daten aus der Serendipity Datenbank gelesen. RSS ist mehr generell, es kann den Datenbank Zugriff reduzieren (durch Caching), aber wenn Du ein großes Blog hast, kann es für Besucher lange Zeit benötigen, bis die Daten gesammelt wurden.');
@define('PLUGIN_GEOTAG_GMAP_CATEGORY_DESC',         'Wenn die Geodaten aus der Datenbank bezogen werden, kannst Du hier auf eine Kategorie begrenzen, aus der Positionen von Artikeln dargestellt werden sollen.');

@define('PLUGIN_GEOTAG_SERVICE',                "Kartendienst");
@define('PLUGIN_GEOTAG_SERVICE_DESC',           "Sie können Karten von Google Maps oder Openstreetmap verwenden.");

//
// Editor
//
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_GET_CODE',      "Aktuelle Position");
@define('PLUGIN_GEOTAG_GMAP_GEOCODE',           	"Adresse finden");
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_TYPE_ADDRESS',  "Adresse eingeben...");
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_MSG_PROGRESS',  "Versuche, die Koordinaten zu ermitteln...");
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_NOT_FOUND',     "nicht gefunden");
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_OK',        	"OK");
@define('PLUGIN_EVENT_CLEAR_LOCATION',        		"Koordinaten löschen");
