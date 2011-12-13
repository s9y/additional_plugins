<?php # $Id: lang_de.inc.php,v 1.3 2010/12/05 11:45:18 brockhaus Exp $

/**
 *  @version $Revision: 1.3 $
 *  @author Pelle Boese <p.boese@gmail.com>
 *  EN-Revision: Revision of lang_de.inc.php
 */

@define('PLUGIN_EVENT_MOBILE_OUTPUT_NAME', 'Markup: Mobile Ausgabe');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_DESC', 'Dieses Plugin erkennt automatisch mobile Endgeraete und gibt optimiertes XHTML MP fuer diese aus. Fuer das Apple iPhone und den iPod Touch wird eine speziell angepasste Seite ausgegeben. Weiterhin werden Bilder automatisch passend skaliert.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_ENABLE_PLUGIN_NAME', 'Plugin aktivieren');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_ENABLE_PLUGIN_DESC', 'Dieses Plugin aktivieren');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_MOBILE_TEMPLATE_NAME', 'Mobiles Template');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_MOBILE_TEMPLATE_DESC', 'Das Template, das fuer die mobile Ausgabe genutzt wird. Das mitgelieferte Standard-Template ist "xhtml_mp".');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_IPHONE_TEMPLATE_NAME', 'iPhone Template');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_IPHONE_TEMPLATE_DESC', 'Das Template, das fuer die iPhone Ausgabe genutzt wird. Das mitgelieferte Standard-Template ist "iphone.app".');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_IMAGES_NAME', 'Bilder anzeigen');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_IMAGES_DESC', 'Bilder in Eintraegen anzeigen');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_SCALE_IMAGE_WIDTH_NAME', 'Maximale Bildbreite');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SCALE_IMAGE_WIDTH_DESC', 'Zu breite Bilder auf X Pixel breite verkleinern. Auf 0 setzen zum deaktivieren. Benoetigt GD!');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_NAME', 'Weiterleitung');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_DESC', 'Mobile Endgeraete auf einen anderen Host umleiten (siehe unten)');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_URL_NAME', 'Weiterleitungs-Host');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_URL_DESC', 'Mobile Endgeraete auf einen bestimmten Host weiterleiten (z.B. "m.yourblog.com"). Es darf auch ein Host auf dem die Selbe Serendipity-Instanz laeuft angegeben werden.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_STICKY_HOST_NAME', 'Mobiler Host');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_STICKY_HOST_DESC', 'Auf diesem Host ist die mobile Ausgabe immer aktiv. Zum deaktivieren nichts eintragen.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_WURFL_NAME', 'WURFL benutzen');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_WURFL_DESC', 'Mit dieser Option werden alle Bilder automatisch auf die Perfekte Breite fuer das jeweilige Endgeraet verkleinert. Es wird eine optimierte Version des WURFL UAP (http://wurfl.sourceforge.net/) genutzt. Eine aktuelle Version gibt es unter http://c.seo-mobile.de/. Da die optimierte Variante immernoch recht gross ist, wird sie gecacht, dieser Cache benoetigt ca. 50mb. Wenn Du eine neue Version von wurfl.xml heruntergeladen hast, ruf folgende URL in deinem Browser auf, um den Cache zu aktualisieren: '.$serendipity['baseURL'].'plugins/serendipity_event_mobile_output/wurfl/update_cache.php. Diese Option nutzt die maximale Bildbreite als Fallback. Auf Seiten mit sehr viel Traffic kann diese Option viel CPU-Zeit benoetigen! ACHTUNG: Der Ordner "wurfl/data/" im Plugin-Verzeichnis muss fuer den Webserver schreibbar sein um den Cache zu generieren!');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_CATEGORIES_NAME', 'Kategorien anzeigen');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_CATEGORIES_DESC', 'Die Liste der Kategorien in der Footer-Navigation anzeigen und mit Accesskeys versehen. Sind mehr als 9 Kategorien vorhanden, werden die uebrigen ohne Accesskey angezeigt.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_TAGS_NAME', 'HTML-Tags entfernen');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_TAGS_DESC', 'Eine kommagetrennte Liste von HTML-Tags, die aus den Eintraegen entfernt werden, z.B. script,object,embed...');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_ATTRIBUTES_NAME', 'HTML-Attribute entfernen');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_ATTRIBUTES_DESC', 'Eine kommagetrennte Liste von HTML-Attributen, die aus den Eintraegen entfernt werden, z.B. onclick,onmouseover,style');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REWRITE_WIKIPEDIA_NAME', 'Wikipedia Links umschreiben');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REWRITE_WIKIPEDIA_DESC', 'Links auf wikipedia.org auf die mobile Variante der Sevenval AG umschreiben (http://wikipedia.7val.com/)');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_DEBUG_PASSWORD_NAME', 'Debug-Passwort');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_DEBUG_PASSWORD_DESC', 'Dieses Passwort wird benoetigt, um den Debug-Modus des Blog zu aktivieren. Dies geschieht, indem man ?mpDebug=PASSWORT an die URL des Blogs anhaengt.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_NAVIGATION', 'Navigation');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_NAME', 'Mobile Sitemap erstellen');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_DESC', 'Erstellt eine mobile_sitemap.xml(.gz) fuer verschiedene Suchmaschinen-Crawler (Google, MSN, Yahoo und Ask)');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_NAME', 'Updates melden');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_DESC', 'Updates der Sitemap an die unten definierten Dienste melden');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_URL_NAME', 'URL-Liste fuer Pings');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_URL_DESC', 'URLs fuer Pingbacks (%s wird durch URL zur Sitemap ersetzt, verschiedene Eintraege werden mit \';\' (Semicolon) getrennt, fall noetig muss ein Semicolon durch \'%3B\' ersetzt werden).');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_GZIP_NAME', 'Die mobile_sitemap.xml mit gzip packen');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_GZIP_DESC', 'Das sitemap-Protokoll unterstuetzt gepackte Dateien um Bandbreite zu sparen. Wenn die erstellte Datei Probleme macht kann es helfen diese Option zu deaktivieren. (Aber: Wenn das PHP auf diesem Rechner kein gzip unterstuetzt, wird automatisch eine ungepackte Version erstellt, solange bis ein PHP mit aktiviertem gzip vorhanden ist. Es ist also im Allgemeinen nicht noetig diese Option zu deaktivieren)');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_PERMALINK_WARNING', 'Warnung: Zum Erstellen einer korrekten Sitemap muss das Permalinkplugin in der Konfiguration vor dem sitemap-plugin platziert werden');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_FAILEDOPEN', 'Sitemap-Ausgabedatei konnte nicht geschrieben werden.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_UNKNOWN_HOST', 'Pingback-Host nicht gefunden.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_ERROR', 'Konnte Update nicht an %s melden: %s');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_OK', 'Sitemap Update an %s gemeldet.<br/>');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_MANUAL','Wenn die Sitemap noch nicht an %s gemeldet wurde, dann kann es mit <a href="%s">diesem Link</a> getan werden');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_ANDROID_TEMPLATE_NAME','Android Template');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_ANDROID_TEMPLATE_DESC','Das Template, das fuer die Android Ausgabe genutzt wird. Das mitgelieferte Standard-Template ist "android.app".');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SMALLTEASER_NAME','Kleine Teaser');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SMALLTEASER_DESC','Wenn angeschaltet, wird nur der erste Absatz eines Artikels in der Uebersicht angezeigt. Ansonsten der Artikel ohne den erweiterten Teil (wie gewohnt).');