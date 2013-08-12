<?php # 

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_de.inc.php
 */

@define('PLUGIN_EVENT_AUTOSAVE_TITLE', 'Einträge automatisch sichern');
@define('PLUGIN_EVENT_AUTOSAVE_DESC', 'Sichert Einträge beim Schreiben automatisch im Hintergrund');
@define('PLUGIN_EVENT_AUTOSAVE_STARTING', 'Autosicherung gestartet ...');
@define('PLUGIN_EVENT_AUTOSAVE_INTERVAL', 'Interval');
@define('PLUGIN_EVENT_AUTOSAVE_INTERVAL_DESC', 'Zeit in Sekunden zwischen zwei Sicherungen (0 zum abschalten)');
@define('PLUGIN_EVENT_AUTOSAVE_INTERVAL_ERROR', 'Das Zeitinterval muss integer sein, ohne Punkt und Komma');
@define('PLUGIN_EVENT_AUTOSAVE_HTTPATH', 'relativer Http-Pfad');
@define('PLUGIN_EVENT_AUTOSAVE_HTTPATH_DESC', 'Der relative Pfad zur Plugininstallation ohne führenden Slash oder Anführungszeichen (etwa plugins/serendipity_event_autosave)');
@define('PLUGIN_EVENT_AUTOSAVE_HTTPATH_ERROR', '');
@define('PLUGIN_EVENT_AUTOSAVE_AJAX_ERROR', 'Der ajax Aufruf ist fehlgeschlagen !');
@define('PLUGIN_EVENT_AUTOSAVE_SAVE_ERROR', '/!\ Autosicherung ist fehlgeschlagen ;-(');
@define('PLUGIN_EVENT_AUTOSAVE_SAVED', 'Eintrag erfogreich gesichert :-)');
@define('PLUGIN_EVENT_AUTOSAVE_ACTIVATED', 'Autosicherung ist aktiv (hier klicken um per Hand zu sichern oder die eingestellte Zeit abwarten)');
@define('PLUGIN_EVENT_AUTOSAVE_ACTIVATING', 'Autosicherung wird geladen ...');
@define('PLUGIN_EVENT_AUTOSAVE_INIT_FAILED', 'Autosicherung ist nicht initialisiert und nicht verfügbar');
@define('PLUGIN_EVENT_AUTOSAVE_RECOVER', 'Der Eintrag hat Sicherungsdaten, zur Wiederherstellung hier klicken');
@define('PLUGIN_EVENT_AUTOSAVE_RECOVER_FAILED', 'Die Wiederherstellung der Schattenkopie ist fehlgeschlagen');
@define('PLUGIN_EVENT_AUTOSAVE_BAD_SHADOW', 'Die ID der Schattenkopie passt nicht zur ID des Autosicherungseintrages');
@define('PLUGIN_EVENT_AUTOSAVE_RESTORING', 'Autosicherung wiederhergestellt ...');
@define('PLUGIN_EVENT_AUTOSAVE_RESTORED', 'Der Beitrag wurde erfolgreich aus der Schattenkopie wiederhergestellt');
@define('PLUGIN_EVENT_AUTOSAVE_BAD_RESPONSE', 'Unzulässiger ajax Aufruf');
@define('PLUGIN_EVENT_AUTOSAVE_UNSUPPORTED_EDITOR', 'Upps! Ihr wysiwyg editor wird nicht unterstützt :-(');
@define('PLUGIN_EVENT_AUTOSAVE_CONFIRM', 'Sie sind dabei Daten aus der Autosicherung wiederherzustellen, Fortfahren?');
?>
