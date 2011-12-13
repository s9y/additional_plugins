<?php # lang_de.inc.php 1.0 2011-11-22 10:10:53 VladaAjgl $

/**
 *  @version 1.0
 *  @author Konrad Bauckmeier <yourmail@example.com>
 *  @translated 2011/11/22
 */
        @define('PLUGIN_AGGREGATOR_TITLE', 'RSS Aggregator');
        @define('PLUGIN_AGGREGATOR_DESC', 'Aggregiert Einträge von mehreren RSS Feeds ("Planet"). WICHTIGER HINWEIS: Die Aktualisierung des Aggregators muss derzeit noch manuell via Crontab aufgerufen werden. Rufen Sie im gewünschten Abstand per cronjob o.ä. folgende URL auf: ' . $serendipity['baseURL'] . 'index.php?/plugin/aggregator');
        @define('PLUGIN_AGGREGATOR_FEEDNAME', 'Feed Name');
        @define('PLUGIN_AGGREGATOR_FEEDNAME_DESC', 'Name des RSS-Feeds');
        @define('PLUGIN_AGGREGATOR_FEEDURI', 'Feed URI');
        @define('PLUGIN_AGGREGATOR_FEEDURI_DESC', 'Die Adresse des RSS-Feeds');
        @define('PLUGIN_AGGREGATOR_HTMLURI', 'Homepage URI');
        @define('PLUGIN_AGGREGATOR_HTMLURI_DESC', 'Die HTML-Adresse des Feeds');
        @define('PLUGIN_AGGREGATOR_CATEGORIES', 'Kategorien');
        
        @define('PLUGIN_AGGREGATOR_FEEDLIST', 'Dies ist die Liste der verfügbaren RSS-Feeds. Sie können entweder die Feeds manuell und einzeln eintragen, oder eine ganze OPML-Datei importieren. Feeds können gelöscht werden indem der Name oder die URL auf eine leere Zeichenkette gesetzt wird. Neue Feeds können im letzten Eintrag der Tabelle erstellt werden.');
        @define('PLUGIN_AGGREGATOR_FEEDUPDATE', 'Letzte Aktualisierung');
        @define('PLUGIN_AGGREGATOR_FEED_MISSINGDATA', 'Sie müssen einen Feednamen und die URL angeben.');
        @define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST', 'OPML-Datei importieren');
        @define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST_DESC', 'URL zur OPML-Datei, die importiert werden soll. Bestehende Feed-Subscriptions werden dadurch gelöscht und durch die neu importierten Subscriptions ersetzt. Falls die Option "Kategorien importieren" angewählt wurde, wird beim Import auch die Kategorie-Struktur des OPMLs übernommen und Blog-Kategorien angelegt.');
        @define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST_BUTTON', 'OPML-Datei importieren!');
        @define('PLUGIN_AGGREGATOR_IMPORTCATEGORIES', 'Kategorien importieren');
        @define('PLUGIN_AGGREGATOR_IMPORTCATEGORIES2', 'Jeden Feed in seine eigene Kategorie einfügen');
        @define('PLUGIN_AGGREGATOR_CATEGORYSKIPPED', 'Überspringe Kategorie "%s" da sie bereits besteht.');

        @define('PLUGIN_AGGREGATOR_EXPIRE', 'Artikel entfernen');
        @define('PLUGIN_AGGREGATOR_EXPIRE_BLAHBLAH', 'Alte Artikel werden nach n Tagen aus der Datenbank entfernt (0 = Nie).');
        @define('PLUGIN_AGGREGATOR_EXPIRE_MD5', 'Prüfsummen entfernen');
        @define('PLUGIN_AGGREGATOR_EXPIRE_MD5_BLAHBLAH', 'Prüfsummen werden verwendet, um Artikel ohne Datum wieder zu erkennen. Nach wieviel Tagen sollen die Prüfsummen aus der Datenbank entfernt werden? (90 = empfohlen, 0 = Nie).');
        @define('PLUGIN_AGGREGATOR_DELETEDEPENDENCIES', 'Nicht mehr verkettete Einträge löschen');
        @define('PLUGIN_AGGREGATOR_DELETEDEPENDENCIES_DESC', 'Wenn ein Abonnement beendet wird und diese Option aktiv ist, werden alle zugehörigen Artikel dieses Feeds gelöscht.');
        @define('PLUGIN_AGGREGATOR_DEBUG', 'Debugging-Output');
        @define('PLUGIN_AGGREGATOR_DEBUG_BLAHBLAH', 'Debugging Output im Logbuch einschalten?');
        @define('PLUGIN_AGGREGATOR_IGNORE_UPDATES', 'Aktualisierungen ignorieren');
        @define('PLUGIN_AGGREGATOR_CHOOSE_ENGINE', 'RSS Parser wählen');
        @define('PLUGIN_AGGREGATOR_CHOOSE_ENGINE_DESC', 'Onyx ist ein BSD-lizensierter Parser, der aber kein ATOM unterstützt. MagpieRSS ist ein GPL-lizensierter Parser, der dafür Atom und mehr Formate parst. SimplePie ist modern, wird aktiv entwickelt, und funktioniert');

@define('PLUGIN_AGGREGATOR_MATCH_EXPRESSION', 'Filter-Ausdruck');
@define('PLUGIN_AGGREGATOR_MATCH_EXPRESSION_DESC', 'Hier kann ein regulärer Ausdruck eingetragen werden, der auf jeden Feed-Artikel (Titel und Inhalt) angewandt wird, und diesen nur einfügt wenn das Muster zutrifft. Wenn der Filter leer gelassen wird, wird kein Filtervergleich durchgeführt. Mehrere reguläre Ausdrücke können durch das ~ Zeichen (Tilde) getrennt werden, und werden ODER-kombiniert.');

// Next lines were translated on 2011/11/22
@define('PLUGIN_AGGREGATOR_EXPORTFEEDLIST', 'Exportiere OPML Feedliste');
@define('PLUGIN_AGGREGATOR_EXPORTFEEDLIST_BUTTON', 'Exportiere OPML!');
@define('PLUGIN_AGGREGATOR_IGNORE_UPDATES_DESC', 'Nachträglich geänderten Artikeltexte ignorieren und nicht neu einspielen?');
@define('PLUGIN_AGGREGATOR_CRONJOB', 'Dieses Plugin wird vom Serendipity Cronjob Plugin unterstützt. Für zeitgesteuerte Ausführung bitte dieses installieren!');
@define('PLUGIN_AGGREGATOR_PUBLISH', 'Speichere aggregierte Einträge als...');
@define('PLUGIN_AGGREGATOR_MARKUP_DISABLE', 'Deaktiviere Formatierungs-Plugins für aggregierte Einträge');
@define('PLUGIN_AGGREGATOR_MARKUP_DISABLE_DESC', 'Markiere die Formatierungs-Plugins, welche nicht auf aggregierte Einträge angewandt werden sollen.');
@define('PLUGIN_AGGREGATOR_FEEDICON', 'Feed Icon URL');