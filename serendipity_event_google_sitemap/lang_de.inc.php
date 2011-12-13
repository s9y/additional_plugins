<?php # $Id: lang_de.inc.php,v 1.12 2009/12/30 10:30:37 garvinhicking Exp $

/**
 *  @version $Revision: 1.12 $
 *  @author Boris
 *  EN-Revision: 1.7
 */

@define('PLUGIN_EVENT_SITEMAP_TITLE', 'Suchmaschinen-Sitemap Generator');
@define('PLUGIN_EVENT_SITEMAP_DESC',  'Erstellt eine sitemap.xml.gz für verschiedene Suchmaschinen-Crawler (Google, MSN, Yahoo und Ask).');
@define('PLUGIN_EVENT_SITEMAP_FAILEDOPEN', 'Sitemap Ausgabedatei konnte nicht geschrieben werden.');
@define('PLUGIN_EVENT_SITEMAP_REPORT', 'Updates melden');
@define('PLUGIN_EVENT_SITEMAP_REPORT_DESC', 'Updates der Sitemap an die unten definierten Dienste melden');
@define('PLUGIN_EVENT_SITEMAP_REPORT_ERROR', 'Konnte Update nicht an %s melden: %s');
@define('PLUGIN_EVENT_SITEMAP_REPORT_OK', 'Sitemap Update an %s gemeldet.<br/>');
@define('PLUGIN_EVENT_SITEMAP_REPORT_MANUAL','Wenn die Sitemap noch nicht an %s gemeldet wurde, dann kann es mit <a href="%s">diesem Link</a> getan werden.<br/>');
@define('PLUGIN_EVENT_SITEMAP_ROBOTS_TXT', 'Alternativ kann sie auch <a href="http://googlewebmastercentral-de.blogspot.com/2007/04/was-gibts-neues-bei-sitemapsorg.html">in die robots.txt eingefügt werden</a>.<br/>');
@define('PLUGIN_EVENT_SITEMAP_URL', 'URL-Liste für Pings');
@define('PLUGIN_EVENT_SITEMAP_URL_DESC', 'URLs für Pingbacks (%s wird durch URL zur Sitemap ersetzt, verschiedene Einträge werden mit \';\' (Semicolon) getrennt, fall nötig muss ein Semicolon durch \'%3B\' ersetzt werden).');
@define('PLUGIN_EVENT_SITEMAP_URL_DESC', 'URL for pingbacks (%s is replaced with the sitemap-URL, seperate multiple entries with \';\' (semicolon), if you need to enter a ; use \'%3B\').');
@define('PLUGIN_EVENT_SITEMAP_ADDFEEDS', 'Newsfeeds hinzufügen');
@define('PLUGIN_EVENT_SITEMAP_ADDFEEDS_DESC', 'Füge die URLs der Newsfeeds (RSS 0.9, 1.0, 2.0, Atom und Kategorien) zur Sitemap.');
@define('PLUGIN_EVENT_SITEMAP_UNKNOWN_SERVICE', 'unbekannt');
@define('PLUGIN_EVENT_SITEMAP_PERMALINK_WARNING', 'Warnung: Zum Erstellen einer korrekten Sitemap muss das Permalinkplugin in der Konfiguration <b>vor</b> dem sitemap-plugin platziert werden');
@define('PLUGIN_EVENT_SITEMAP_GZIP_SITEMAP', 'Die sitemap.xml mit gzip packen');
@define('PLUGIN_EVENT_SITEMAP_GZIP_SITEMAP_DESC', 'Das sitemap-Protokoll unterstützt gepackte Dateien um Bandbreite zu sparen. Wenn die erstellte Datei Probleme macht kann es helfen diese Option zu deaktivieren. (Aber: Wenn das PHP auf diesem Rechner kein gzip unterstützt, wird automatisch eine ungepackte Version erstellt, solange bis ein PHP mit aktiviertem gzip vorhanden ist. Es ist also im Allgemeinen nicht nötig diese Option zu deaktivieren)');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD', 'URL-Typen');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_DESC', 'Definiert die URL-Typen, die zur Sitemap hinzugefügt werden sollen.');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_FEEDS', 'Feeds');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_CATEGORIES', 'Kategorien');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_AUTHORS', 'Autoren');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_PERMALINKS', 'Permalinks');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_ARCHIVES', 'Archiv');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_STATIC', 'Statische Seiten');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_TAGS', 'Tag-Seiten');

@define('PLUGIN_EVENT_SITEMAP_CUSTOM', 'Manueller Zusatzinhalt (zur Einbindung im XML)');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM_DESC', 'Hier kann beliebiger XML-Inhalt eingebunden werden, der am Ende des erzeugten XML angehangen wird. Es können also z.B. KML-Dateien oder ähnliches referenziert werden. Stellen Sie sicher, dass der XML-Code validiert!');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM2', 'Manueller Zusatzuinhalt (zur Einbindung im XML-Kopf/Namespace)');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM2_DESC', 'Hier kann beliebiger XML-Inhalt eingebunden werden, der im Kopf/Anfang der erzeugten Sitemap-Datei erscheint, innerhalb des urlset-Tags. Dieser XML-Code muss validierbar sein.');
@define('PLUGIN_EVENT_SITEMAP_NEWS', 'GoogleNews-Format einbetten');
@define('PLUGIN_EVENT_SITEMAP_GNEWS_NAME', 'Titel für GoogleNews-Inhalt');
@define('PLUGIN_EVENT_SITEMAP_GNEWS_NAME_DESC', '');

@define('PLUGIN_EVENT_SITEMAP_PUBLIC', 'Öffentlich (Public)');
@define('PLUGIN_EVENT_SITEMAP_SUBSCRIPTION', 'Abonnement (Subscription, bezahlter Inhalt)');
@define('PLUGIN_EVENT_SITEMAP_REGISTRATION', 'Registrierung (Freier Inhalt, Registration erforderlich)');
@define('PLUGIN_EVENT_SITEMAP_PRESS', 'Pressemeldung (Press release)');
@define('PLUGIN_EVENT_SITEMAP_SATIRE', 'Satire');
@define('PLUGIN_EVENT_SITEMAP_BLOG', 'Blog');
@define('PLUGIN_EVENT_SITEMAP_OPED', 'Editorial (OpEd)');
@define('PLUGIN_EVENT_SITEMAP_OPINION', 'Lesermeinung (Opinion)');
@define('PLUGIN_EVENT_SITEMAP_USERGENERATED', 'Leserinhalte (User-generated content)');

@define('PLUGIN_EVENT_SITEMAP_GNEWS_SUBSCRIPTION', 'GoogleNews: Inhaltsklassifizierung');
@define('PLUGIN_EVENT_SITEMAP_GNEWS_SUBSCRIPTION_DESC', '');
@define('PLUGIN_EVENT_SITEMAP_GENRES', 'GoogleNews: Kategorien');
@define('PLUGIN_EVENT_SITEMAP_GENRES_DESC', 'Die hier gewählten Kategorien gelten für alle Blog-Einträge. Sie sollten daher eine Kategorie wählen, die auf alle Einträge passt. Um die Option auf Eintrags-Ebene festzulegen, müssen Sie ein CustomProperty-Feld namens "gnews_genre" anlegen, in diesem Feld können Sie eine kommagetrennte Liste von Kategorien eintragen.');
@define('PLUGIN_EVENT_SITEMAP_NONE', 'Keine Kategorie');
