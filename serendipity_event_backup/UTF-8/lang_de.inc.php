<?php #

/**
 *  @version
 *  @author Thomas Hochstein <thh@inter.net>
 */

@define("PLUGIN_BACKUP_TITLE", "Backup-Interface");
@define("PLUGIN_BACKUP_DESC", "Bietet die Möglichkeit, automatisch Backups von Ihren Serendipity - den Datenbanktabellen, der gesamten Datenbank und den Dateien - zu erstellen. Derzeit werden nur MySQL(i)-Datenbanken unterstützt. WARNUNG: Dieses Plugin funktioniert nicht gut mit großen Datenbanken oder Verzeichnissen.");
@define("PLUGIN_BACKUP_ABSPATH_BACKUPDIR", "Absoluter Pfad zum Backupverzeichnis");
@define("PLUGIN_BACKUP_ABSPATH_BACKUPDIR_BLAHBLAH", "Dieses Verzeichnis sollte sich außerhalb des Stammverzeichnisses (document_root) Ihrer Website befinden. Es muss für den Webserver vorhanden und beschreibbar sein!");

@define("PLUGIN_BACKUP_NOT_FOUND", "Backup nicht gefunden");
@define("PLUGIN_BACKUP_SQL_RECOVERED", "SQL-Backup wiederhergestellt");
@define("PLUGIN_BACKUP_AUTO_SQL_BACKUP_STARTED", "Automatisches SQL-Backup gestartet");
@define("PLUGIN_BACKUP_AUTO_SQL_BACKUP_STOPPED", "Automatisches SQL-Backup gestoppt");
@define("PLUGIN_BACKUP_AUTO_SQL_DELETE_STARTED", "Automatische SQL-Löschung gestartet");
@define("PLUGIN_BACKUP_AUTO_SQL_DELETE_STOPPED", "Automatische SQL-Löschung gestoppt");
@define("PLUGIN_BACKUP_SQL_SAVED", "Aktuelles SQL-Backup gespeichert");
@define("PLUGIN_BACKUP_HTML_RECOVERED", "HTML-Backup wiederhergestellt");
@define("PLUGIN_BACKUP_AUTO_HTML_BACKUP_STARTED", "Automatisches HTML-Backup gestartet");
@define("PLUGIN_BACKUP_AUTO_HTML_BACKUP_STOPPED", "Automatisches HTML-Backup gestoppt");
@define("PLUGIN_BACKUP_AUTO_HTML_DELETE_STARTED", "Automatische HTML-Löschung gestartet");
@define("PLUGIN_BACKUP_AUTO_HTML_DELETE_STOPPED", "Automatische HTML-Löschung gestoppt");
@define("PLUGIN_BACKUP_HTML_SAVED", "Aktuelles HTML-Backup gespeichert");
@define("PLUGIN_BACKUP_PLEASE_CHOOSE", "Bitte auswählen");
@define("PLUGIN_BACKUP_STRUCT_AND_DATA", "Datenbankstruktur und Daten");
@define("PLUGIN_BACKUP_ONLY_STRUCT", "Nur Datenbankstruktur");
@define("PLUGIN_BACKUP_ONLY_DATA", "Nur Daten");
@define("PLUGIN_BACKUP_WITH_DROP_TABLE", "Mit 'drop table'");
@define("PLUGIN_BACKUP_ZIPPED", "gzippt");
@define("PLUGIN_BACKUP_WHOLE_DATABASE", "Gesamte Datenbank");
@define("PLUGIN_BACKUP_START_BACKUP", "Backup starten");
@define("PLUGIN_BACKUP_MINUTES", "Minuten");
@define("PLUGIN_BACKUP_HOUR", "Stunde");
@define("PLUGIN_BACKUP_HOURS", "Stunden");
@define("PLUGIN_BACKUP_DAYS", "Tage");
@define("PLUGIN_BACKUP_WEEKS", "Wochen");
@define("PLUGIN_BACKUP_EVERY", "jede");
@define("PLUGIN_BACKUP_MONTHS", "Monate");
@define("PLUGIN_BACKUP_AUTO_BACKUP", "Automatisches Backup");
@define("PLUGIN_BACKUP_ACTIVATE_AUTO_BACKUP", "Automatisches Backup aktivieren");
@define("PLUGIN_BACKUP_TIME_BET_BACKUPS", "Zeitspanne zwischen Backups");
@define("PLUGIN_BACKUP_DEL_OLD_BACKUPS", "Alte Backups löschen");
@define("PLUGIN_BACKUP_ACTIVATE_AUTO_DELETE", "Automatisches Löschen alter Backups aktivieren");
@define("PLUGIN_BACKUP_OLDER_THAN", "Backups älter als");
@define("PLUGIN_BACKUP_WILL_BE_DELETED", "werden gelöscht werden");
@define("PLUGIN_BACKUP_FILENAME", "Dateiname");
@define("PLUGIN_BACKUP_FILESIZE", "Dateigröße");
@define("PLUGIN_BACKUP_DATE", "Datum");
@define("PLUGIN_BACKUP_OPTION", "Option");
@define("PLUGIN_BACKUP_RECOVER", "Wiederherstellung");
@define("PLUGIN_BACKUP_RECOVER_THIS", "Datenbank wiederherstellen mit diesem Backup...");
@define("PLUGIN_BACKUP_DELETE", "Löschen");
@define("PLUGIN_BACKUP_DELETE_MARK", "Zum Löschen markieren");
@define("PLUGIN_BACKUP_NO_BACKUPS", "Keine Backups");
@define("PLUGIN_BACKUP_WHOLE_BLOG", "Gesamtes Serendipity");
@define("PLUGIN_BACKUP_SQL_BACKUP", "SQL-Backup");
@define("PLUGIN_BACKUP_HTML_BACKUP", "HTML-Backup");
@define("PLUGIN_BACKUP_LABEL_TABLES", "Datenbanktabellen für das Backup auswählen");
@define("PLUGIN_BACKUP_LABEL_DATA", "Datenbankstruktur und/oder Daten");
@define("PLUGIN_BACKUP_LABEL_DIRS", "Verzeichnisse für das Backup auswählen");
@define("PLUGIN_BACKUP_LABEL_BACKUPS", "Verfügbare Backups");

?>
