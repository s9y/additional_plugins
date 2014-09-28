<?php

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', 'Freie Artikel-Tags');
@define('PLUGIN_EVENT_FREETAG_DESC', 'Erlaubt das freie Tagging von Artikeln');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', 'Bitte alle zutreffenden Tags angeben. Mehrere zutreffende Tags mit Komma (,) trennen');
@define('PLUGIN_EVENT_FREETAG_LIST', 'Tags für diesen Artikel: %s');
@define('PLUGIN_EVENT_FREETAG_USING', 'Artikel mit Tag %s');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', 'Verwandte Tags zu Tag %s');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED','Keine verwandten Tags gefunden.');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', 'Alle festgelegten Tags');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', 'Tags verwalten');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', 'Alle Tags verwalten');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', '\'Verwaiste\' Tags verwalten');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', 'Einträge ohne Tags anzeigen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', 'Einträge mit \'verwaisten\' Tags anzeigen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP', 'Eintrag-Tag-Zuordnungen bereinigen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_INFO', 'In der nachfolgenden Auflistung sind Tags aufgeführt, die mit nicht existierenden Einträgen verknüpft sind. Klicken Sie auf &quot;Bereinigen&quot;, um diese nicht benötigten Verknüpfungen zu entfernen.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_NOTHING', 'Es wurden keine Tags gefunden, die mit nicht existieren Einträgen verknüpft sind. Daher ist keine Bereinigung erforderlich.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_LOOKUP_ERROR', 'Es konnten keine Tags, die mit nicht existierenden Einträgen verknüpft sind, gefunden werden, da ein Fehler aufgetreten ist.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_PERFORM', 'Bereinigen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_ENTRIES', 'IDs der betroffenen Einträge');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_SUCCESSFUL', 'Alle nicht benötigten Verknüpfungen wurden erfolgreich entfernt.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_FAILED', 'Die Entfernung nicht benötigter Verknüpfungen konnte nicht durchgeführt werden.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', 'Keine Einträge ohne Tags gefunden!');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', 'Tag');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', 'Häufigkeit');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', 'Funktionen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', 'Umbenennen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', 'Aufteilen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', 'Löschen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', 'Tag %s wirklich löschen?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'Tags mit einem Komma trennen:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', 'Zeige Wolke mit verwandten Tags an?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER', 'Sende X-FreeTag-HTTP-Header');
@define('PLUGIN_EVENT_FREETAG_ADMIN_TAGLIST', 'Klickbare Liste aller schon vorhandenen Tags beim Schreiben eines Eintrags anzeigen');
@define('PLUGIN_EVENT_FREETAG_ADMIN_FTAYT', 'Zeige Tag-Vorschläge bei der Eingabe');

//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'Getaggte Artikel');
@define('PLUGIN_FREETAG_BLAHBLAH', 'Zeigt alle vorhandenen Tags');
@define('PLUGIN_FREETAG_NEWLINE', 'Zeilenumbruch nach jedem Tag?');
@define('PLUGIN_FREETAG_XML', 'XML-Icons anzeigen?');
@define('PLUGIN_FREETAG_SCALE', 'Schriftgröße des Font-Tags je nach Popularität vergrößern (wie Technorati, flickr)?');
@define('PLUGIN_FREETAG_UPGRADE1_2','Aktualisiere %d Tags zu Eintrag %d');
@define('PLUGIN_FREETAG_MAX_TAGS', 'Wieviele Tags sollen angezeigt werden?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'Wie oft muss ein Tag vorkommen, damit er angezeigt wird?');

//
// later on additions
//
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'Minimale Schriftgröße eines Tags in der Wolke in %');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'Maximale Schriftgröße eines Tags in der Wolke in %');

@define('PLUGIN_EVENT_FREETAG_USE_FLASH', 'verwende Flash um die Tag-Wolke anzuzeigen?');
@define('PLUGIN_EVENT_FREETAG_FLASH_TAG_COLOR', 'Flash Tag Wolke: Schriftfarbe (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_FLASH_TRANSPARENT', 'Flash Tag Wolke: Hintergrund transparent?');
@define('PLUGIN_EVENT_FREETAG_FLASH_BG_COLOR', 'Flash Tag Wolke: Hintergrund-Farbe (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_FLASH_WIDTH', 'Flash Tag-Wolke: Breite');
@define('PLUGIN_EVENT_FREETAG_FLASH_SPEED', 'Flash Tag-Wolke: Anzeige Geschwindigkeit');


@define('PLUGIN_FREETAG_META_KEYWORDS', 'Anzahl der Stichwörter, die in die Meta-Angaben des HTML-Codes eingesetzt werden sollen (0: abgeschaltet)');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE', 'Template für Seitenleiste');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE_DESCRIPTION', 'Wenn ein Template angegeben ist, wird es benutzt um de Seitenleiste anzuzeigen. Im Template wird eine Variable <tags> zu Verfügung gestellt, die ein Liste von Einträgen im folgenden Format enthält: <tagName> => array(href = <tagLink>, count => <tagCount>)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Artikel mit ähnlichen Themen:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED','Zeige Artikel mit ähnlichen Themen an?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT','Wieviele Artikel mit ähnlichen Themen sollen angezeigt werden?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', 'Zeige die Tags in der Fußzeile an?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', 'Falls eingeschaltet, werden die Tags in der Fußzeile des Eintrags angezeigt. Wenn abgeschaltet, werden die Tags innerhalb des Textkörpers/erweiterten Teils des Artikels angezeigt.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', 'Tags in Kleinbuchstaben umwandeln');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS', 'Verwandte Tags');
@define('PLUGIN_EVENT_FREETAG_TAGLINK', 'Taglink');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG', 'Erstelle Tags für zugewiesene Kategorien?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC', 'Falls aktiviert, werden alle Kategorien eines Eintrags als Tags zugewiesen. Alle bestehende Kategoriezuweisungen können über die Tag-Verwaltung in Tags konvertiert werden.');
@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG', 'Erstelle Tags durch automatische Schlüsselwörter?');
@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG_DESC', 'Falls aktiviert, wird der Eintrag daraufhin geprüft, ob darin automatische Schlüsselwörter enthalten sind. Gegebenenfalls werden die entsprechenden Tags zugewiesen. Die Schlüsselwörter können über die Tag-Verwaltung festgelegt werden.');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS', 'Alle zugewiesenen Kategorien bestehender Artikel zu Tags konvertieren');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY', 'Kategorien von Artikel #%d (%s) konvertiert zu: %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG', 'Alle Kategorien wurden zu Tags konvertiert.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS', 'Automatische Schlüsselwörter');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC', 'Sie können Schlüsselwörter (mit "," getrennt) für jedes Tag zuweisen. Immer wenn eines dieser Schlüsselwörter im Text gefunden wird, wird der zugehörige Tag automatisch dem Eintrag zugewiesen. Achten Sie darauf, dass sehr viele automatische Schlüsselwörter beim Speichern eines Artikels längere Zeit beanspruchen können.');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD', 'Schlüsselwort <strong>%s</strong> gefunden, Tag <strong><em>%s</em></strong> automatisch zugewiesen.<br />');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO', 'Lese Einträge %d bis %d');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL', ' (gesamt %d Einträge)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT', 'Hole nächste Runde von Einträgen...');
@define('PLUGIN_EVENT_FREETAG_REBUILD', 'Automatische Schlüsselwörter neu parsen');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC', 'Warnung: Diese Funktion wird jeden einzelnen Blogeintrag einlesen und neu speichern. Das wird zum einen etwas dauern, und zum anderen besteht die Gefahr, dass ihre Einträge verändert werden könnten. Daher empfehlen wir, vorher ein Datenbank-Backup zu erstellen. Klicken Sie auf "Abbrechen", um diese Aktion abzubrechen.');

@define('PLUGIN_EVENT_FREETAG_ORDER_TAGNAME', 'Tag-Name');
@define('PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT', 'Tag-Anzahl');

@define('PLUGIN_EVENT_FREETAG_TECHNORATI_TAGLINK', 'Technorati Tag Links');
@define('PLUGIN_EVENT_FREETAG_TECHNORATI_TAGLINK_DESC', 'Fügt Links auf Technorati Tags hinzu. Wenn auf diese Links geklickt wird, so wird eine Liste von ähnlichen Einträgen in weiteren Blogs angezeigt, die in Technorati zu dem entsprechenden Tag gespeichert wurden.');

@define('PLUGIN_EVENT_FREETAG_TECHNORATI_TAGLINK_IMG', 'Technorati Tag Bild');

@define('PLUGIN_EVENT_FREETAG_XMLIMAGE', 'XML Bild relativ zum Template Verzeichnis');

@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC2', 'Wenn auf "Smarty" gestellt wird, dann wird eine smarty Variable {$entry.freetag} generiert, die an beliebiger Stelle in der entries.tpl Vorlagendatei eingefügt werden kann.');

@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY', 'Erweiteres Smarty');
@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY_DESC', 'Nutze statt der HTML-Ausgabe, ob nun direkt oder per Smarty, verschiedene Smartyvariablen, die im Template zusammgefügt werden können. Dies überschreibt alle anderen diesbezüglichen Einstellungen. Ein Beispiel für die Nutzung findet sich im Readme.');
@define('PLUGIN_EVENT_FREETAG_KILL', 'Wenn aktiviert werden alle zugehörigen Tags gelöscht.');

@define('PLUGIN_EVENT_FREETAG_TAGLINK_DESC', 'Eine mögliche Änderung des Taglinks wäre "plugin/taglist/" anstelle von "plugin/tag/" zu schreiben. Dies wäre das Kommando, um jeden Taglink als Liste, anstelle von bereits geöffneten Artikeln, auszugeben. Man kann aber ebenso manuell für bestimmte Taglinks den "/taglist" tag an einen bereits existierenden Taglink (zB. "/plugin/tag/deine/tags/taglist") anhängen. In beiden Fällen ist "taglist" fortan ein reserviertes Kommando und kann nicht mehr als normales Tagwort verwendet werden. Für beide Möglichkeiten ist eine eigenhändig eingebaute Code-Änderung nötig, so wie in der Dokumentation für die "tag-as-list" Option beschrieben wird.');

@define('PLUGIN_EVENT_FREETAG_TAGSASLIST', 'Erlaube "tags-as-list" = ungeöffnete Artikel');
@define('PLUGIN_EVENT_FREETAG_TAGSASLIST_DESC', 'In der Plugin-Dokumentation ist zu lesen, wie die existierende templates entries.tpl Datei für die Listenanzeige der Taglink-Ausgabe im Code geändert werden muss.');

