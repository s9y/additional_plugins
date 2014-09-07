<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  DE-Revision: Revision of lang_de.inc.php
 *  Revised by "nogat" 2014/08/22
 */

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_NAME', 'Erweiterte Optionen für Bildauswahl');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_DESC', 'Ermöglicht erweiterte Optionen beim Einfügen von Bildern aus der Mediendatenbank.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET', 'Ziel des Links');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_JS', 'Popup (via JavaScript, angepasste Größe)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_ENTRY', 'Isolierter Eintrag');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_BLANK', 'Popup (via target=_blank)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG', 'QuickBlog');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG_DESC', 'Wenn Sie bei den folgenden Feldern mindestens einen Titel eintragen, wird das Bild sofort als neuer Blog-Artikel eingestellt. Das Ausgabedesign kann über die Datei quickblog.tpl eingestellt werden.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_MAXWIDTH', 'Maximale Breite des Miniaturbildes (verwirft die Höhenangabe)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_MAXHEIGHT', 'Maximale Höhe des Miniaturbildes (verwirft die Breitenangabe)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_AUTORESIZE', 'Ändert die Bildgröße anhand der Breiten - und Höhenangabe');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_AUTORESIZE_DESC', 'Sendet automatische Größen Ihrer Bilder an den Browser, basierend auf der Breiten/Höhenangabe des IMG-Tag. Dies kann Ihr Leben erleichtern, außerdem die Downloadzeiten verringern und die Serverseitige Performance verbessern. (Hinweis: Die Seitenverhältnisse bleiben erhalten)');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES', 'ZIP-Archive entpackt');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_BLABLAH', 'Hochgeladene ZIP-Archive entpacken? - Vorgabe für das Formular auf der Bilder-Upload-Seite.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_DESC', 'Hochgeladene ZIP-Archive entpacken?');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_OK', 'ZIP-Archive erfolgreich entpackt!');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FAILED', 'Fehler beim entpacken der ZIP-Archive!');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_IMAGE_FROM_ARCHIVE', 'Bild aus einem ZIP-Archive');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_ADD_TO_DB', 'zur Datenbank hinzugefügt');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_JHEAD', 'jhead nutzen, um EXIF-Daten zu erhalten');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_JHEAD_DESC', 'Überschreibt das Standardverhalten und benutzt externe Funktionen (Calls), um per jhead EXIF-Daten zu erhalten. Nutzen Sie diese Option nur, wenn jhead installiert ist und auch ausgeführt werden kann!');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_IMAGE_SIZE_DESC', 'Wenn Sie die voreingestellte $serendipity[\'thumbSize\'] Größe hier ändern, wird ein zusätzliches Bild in der genannten Größe in der Mediendatenbank erstellt. Dies Image Instanz wird dann im Frontend als Bildvorschau mit entsprechendem Link zum Original Bild in ihrem Blogeintrag benutzt.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_ASOBJECT', 'Objekt-Type ist kein Bild?');

