<?php

/**
 *  @version 1.0
 *  @author Konrad Bauckmeier <yourmail@example.com>
 *  @translated 2011/11/22
 */
@define('PLUGIN_DOWNLOADMANAGER_TITLE', 'Downloadmanager');
@define('PLUGIN_DOWNLOADMANAGER_DESC', 'Stellt einen kompletten Downloadmanager zur Verfügung. Bei Deinstallation werden alle zugehörigen Tabellen gelöscht!');
@define('PLUGIN_DOWNLOADMANAGER_PAGETITLE', 'Seitentitel');
@define('PLUGIN_DOWNLOADMANAGER_PAGETITLE_BLAHBLAH', 'Titel der Seite');
@define('PLUGIN_DOWNLOADMANAGER_HEADLINE', 'Kopfzeile');
@define('PLUGIN_DOWNLOADMANAGER_HEADLINE_BLAHBLAH', 'Die Kopfzeile/Beschreibung der Seite');
@define('PLUGIN_DOWNLOADMANAGER_PAGEURL', 'Statische URL');
@define('PLUGIN_DOWNLOADMANAGER_PAGEURL_BLAHBLAH', 'Definiere hier den Namen der statischen URL (index.php?serendipity[subpage]=NAME)');
@define('PLUGIN_DOWNLOADMANAGER_PERMALINK', 'Permalink');
@define('PLUGIN_DOWNLOADMANAGER_PERMALINK_BLAHBLAH', 'Gibt den Permalink der statischen Download-Seite an, der sehr viel kürzer sein kann als die statische URL. Der Permalink muss eine absolute Pfadangabe vom HTTP-Root sein und die Dateiendung .htm oder .html besitzen. (Default ist "%s")');
@define('PLUGIN_DOWNLOADMANAGER_ABSINCOMINGPATH', 'Pfad zu \'incoming\'');
@define('PLUGIN_DOWNLOADMANAGER_ABSINCOMINGPATH_BLAHBLAH', 'Voller, absoluter Pfad zum \'incoming\' Verzeichnis in welches man Dateien per FTP hochladen kann, um sie in den Downloadmanager zu importieren. (Zum Beispiel, wenn die Datei zu gross für den PHP-HTTP-Upload ist.)');
@define('PLUGIN_DOWNLOADMANAGER_ABSDOWNLOADPATH', 'Pfad zum \'download\' Verzeichnis');
@define('PLUGIN_DOWNLOADMANAGER_ABSDOWNLOADPATH_BLAHBLAH', 'Voller und absoluter Pfad zum Download-Verzeichnis, in welchem die Dateien gespeichert werden.');
@define('PLUGIN_DOWNLOADMANAGER_HTTPPATH', 'Pfad zum Downloadmanager Verzeichnis');
@define('PLUGIN_DOWNLOADMANAGER_HTTPPATH_BLAHBLAH', 'Absoluter Pfad zum Plugin-Verzeichnis, in welchem der Downloadmanager installiert ist (üblicherweise \'/plugins/serendipity_event_downloadmanager\').');
@define('PLUGIN_DOWNLOADMANAGER_DATEFORMAT', 'Format der Datumsanzeigen. Es werden die Variablen der PHP-Funktion date() verwendet (Default: \'Y/m/d, h:ia\')');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILEDATE', 'Datei-Datum anzeigen');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILEDATE_BLAHBLAH', 'Soll das Datum einer Datei in der Dateiliste angezeigt werden?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILENAME', 'Dateinamen anzeigen');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILENAME_BLAHBLAH', 'Soll der Name einer Datei in der Dateiliste angezeigt werden?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILESIZE', 'Dateigröße anzeigen');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILESIZE_BLAHBLAH', 'Soll die Größe einer Datei in der Dateiliste angezeigt werden?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWDOWNLOADS', 'Anzahl der Datei-Downloads');
@define('PLUGIN_DOWNLOADMANAGER_SHOWDOWNLOADS_BLAHBLAH', 'Soll die Anzahl der bisherigen Download einer Datei in der Dateiliste angezeigt werden?');
@define('PLUGIN_DOWNLOADMANAGER_FILENAME_FIELD', 'Bezeichnung des Dateinamen-Felds');
@define('PLUGIN_DOWNLOADMANAGER_FILENAME_FIELD_BLAHBLAH', 'Eintragen eines beliebigen Namens für das Dateinamen-Feld in der Dateiliste');
@define('PLUGIN_DOWNLOADMANAGER_FILESIZE_FIELD', 'Bezeichnung des Dateigröße-Felds');
@define('PLUGIN_DOWNLOADMANAGER_FILESIZE_FIELD_BLAHBLAH', 'Eintragen eines beliebigen Namens für das Dateigröße-Feld in der Dateiliste');
@define('PLUGIN_DOWNLOADMANAGER_FILEDATE_FIELD', 'Bezeichnung des Dateidatum-Felds');
@define('PLUGIN_DOWNLOADMANAGER_FILEDATE_FIELD_BLAHBLAH', 'Eintragen eines beliebigen Namens für das Dateidatum-Feld in der Dateiliste');
@define('PLUGIN_DOWNLOADMANAGER_DLS_FIELD', 'Bezeichnung des \'Anzahl bisheriger Downloads\'-Felds');
@define('PLUGIN_DOWNLOADMANAGER_DLS_FIELD_BLAHBLAH', 'Eintragen eines beliebigen Namens für das \'Anzahl bisheriger Downloads\'-Feld in der Dateiliste');
@define('PLUGIN_DOWNLOADMANAGER_ICONWIDTH', 'Icon Breite');
@define('PLUGIN_DOWNLOADMANAGER_ICONWIDTHBLAH', 'Breite der Dateiicons in der Dateiliste');
@define('PLUGIN_DOWNLOADMANAGER_ICONHEIGHT', 'Icon Höhe');
@define('PLUGIN_DOWNLOADMANAGER_ICONHEIGHT_BLAHBLAH', 'Höhe der Dateiicons in der Dateiliste');
@define('PLUGIN_DOWNLOADMANAGER_SHOWHIDDEN_REGISTERED', 'Versteckte Kategorien für registrierte User zeigen?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWHIDDEN_REGISTERED_BLAHBLAH', 'Sollen versteckte Kategorien für registrierte und eingeloggte User sichtbar sein?');

@define('PLUGIN_DOWNLOADMANAGER_NO_CATS_FOUND', 'Keine Kategorien gefunden!');
@define('PLUGIN_DOWNLOADMANAGER_CATEGORIES', 'Kategorien');
@define('PLUGIN_DOWNLOADMANAGER_SUBCATEGORIES', 'Unter-Kategorien');
@define('PLUGIN_DOWNLOADMANAGER_CATEGORY', 'Kategorie');
@define('PLUGIN_DOWNLOADMANAGER_NUMBER_OF_DOWNLOADS', '# Dateien');
@define('PLUGIN_DOWNLOADMANAGER_CATNAME', 'Kategorie-Name:');
@define('PLUGIN_DOWNLOADMANAGER_SUBCAT_OF', 'Unter-Kategorie von:');
@define('PLUGIN_DOWNLOADMANAGER_ADD_CAT', 'Neue Kategorie erstellen');
@define('PLUGIN_DOWNLOADMANAGER_DEL_FILE', 'Diese Datei löschen...');
@define('PLUGIN_DOWNLOADMANAGER_DEL_CAT', 'Diese Kategorie löschen (Und alle darin enthaltenen Dateien!)...');
@define('PLUGIN_DOWNLOADMANAGER_DEL_CAT_NOT_ALLOWD', 'Löschen nicht erlaubt! Kategorie hat Unter-Kategorien');
@define('PLUGIN_DOWNLOADMANAGER_DELETE_NOT_ALLOWED', 'Diese Kategorie kann nicht gelöscht werden, da sie mindestens eine Unter-Kategorie enthält!');
@define('PLUGIN_DOWNLOADMANAGER_CAT_NOT_FOUND', 'Kategorie nicht gefunden!');
@define('PLUGIN_DOWNLOADMANAGER_DLS_IN_THIS_CAT', 'Dateien in dieser Kategorie');
@define('PLUGIN_DOWNLOADMANAGER_BACK', 'Zurück');
@define('PLUGIN_DOWNLOADMANAGER_FILENAME', 'Dateiname');
@define('PLUGIN_DOWNLOADMANAGER_FILESIZE', 'Dateigröße');
@define('PLUGIN_DOWNLOADMANAGER_FILEDATE', 'Datum');
@define('PLUGIN_DOWNLOADMANAGER_NUM_DOWNLOADS', 'dls');
@define('PLUGIN_DOWNLOADMANAGER_NUM_DOWNLOADS_BLAH', 'Anzahl der Downloads');
@define('PLUGIN_DOWNLOADMANAGER_IMPORT_FILE', 'Importieren von dieser Datei in die aktuelle Kategorie...');
@define('PLUGIN_DOWNLOADMANAGER_COPY_NOT_ALLOWED', 'Konnte Datei nicht in das Download-Verzeichnis kopieren!<br />Dies kann zB. passieren, wenn das encoding nicht stimmt. oder wenn der SAFE_MODE aktiviert ist<br />Bitte SAFE_MODE in der php.ini deaktivieren!');
@define('PLUGIN_DOWNLOADMANAGER_DELETE_IN_INCOMING_NOT_ALLOWED', 'Konnte die Datei im Import-Verzeichnis nicht löschen, da keine Schreibberechtigung bestand.<br />Bitte Berechtigungen ändern!');
@define('PLUGIN_DOWNLOADMANAGER_DELETE_IN_DOWNLOADDIR_NOT_ALLOWED', 'Konnte die Datei im Download-Verzeichnis nicht löschen, da keine Schreibberechtigung bestand.<br />Bitte Berechtigungen ändern!');
/*@define('PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE', 'incoming Verzeichnis:');*/
@define('PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE_BLAHBLAH', 'Dieses Verzeichnis "%s"
<ul>
    <li>ermöglicht den Import von per FTP hochgeladenen Dateien in die aktuelle Kategorie "<strong>%s</strong>"</li>
    <li>fungiert als ein temporäres(!) Zwischenverzeichnis für zu verschiebene oder gelöschte Dateien und</li>
    <li>erlaubt die vollständige Löschung aller hier befindlichen Dateien (über das blaue Trash Symbol).</li>
    <li>Um Dateien längerfristig zu verstecken nutzen Sie das Stamm-Verzeichnis. Siehe DLM Help Box.</li>
</ul>');
@define('PLUGIN_DOWNLOADMANAGER_THIS_FILE', 'Gewählte Datei');
@define('PLUGIN_DOWNLOADMANAGER_EDIT_FILE', 'Diese Datei ändern');
@define('PLUGIN_DOWNLOADMANAGER_MOVE_TO_CAT', 'Diese Datei verschieben nach');
@define('PLUGIN_DOWNLOADMANAGER_EDIT_FILE_DESC', 'Dateibeschreibung');
@define('PLUGIN_DOWNLOADMANAGER_FILE_EDITED', 'Datei erfolgreich gespeichert!');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_FILE', 'Diese Datei herunterladen');
@define('PLUGIN_DOWNLOADMANAGER_UPLOAD_FILE', 'Dateien hochladen');
@define('PLUGIN_DOWNLOADMANAGER_FILE', 'Datei');
@define('PLUGIN_DOWNLOADMANAGER_UPLOAD_NOT_ALLOWED', 'Datei-Upload ist nicht erlaubt<br />Bitte in der php.ini aktivieren (file_uploads)!');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_OCCOURED', 'Es sind Fehler beim Upload aufgetreten!');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_NOTCOPIED', 'Diese Dateien konnten nicht kopiert werden:');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_TOOBIG', 'Diese Dateien waren zu groß:');
@define('PLUGIN_DOWNLOADMANAGER_NO_FILES_UPLOADED', 'Keine hochgeladenen Dateien gefunden!');
@define('PLUGIN_DOWNLOADMANAGER_MEDIA_LIBRARY', 'Dateien aus der Mediendatenbank');
@define('PLUGIN_DOWNLOADMANAGER_MEDIA_LIBRARY_BLAHBLAH', 'Hier können bereits hochgeladene Dateien aus der Mediendatenbank in den Downloadmanager importiert werden. Diese Dateien werden nicht verschoben, sondern nur kopiert!<br />Aktuelles Verzeichnis: ');
@define('PLUGIN_DOWNLOADMANAGER_HIDE_TREE', 'Diese Kategorie und alle Unterkategorien verstecken...');
@define('PLUGIN_DOWNLOADMANAGER_UNHIDE_TREE', 'Diese Kategorie und alle Unterkategorien wieder zeigen...');
@define('PLUGIN_DOWNLOADMANAGER_OPEN_CAT', 'Klicken um die Kategorie zu öffnen um Dateien hochzuladen oder zu modifizieren...');

@define('PLUGIN_DOWNLOADMANAGER_SHOWDESC_INLIST',       'Dateibeschreibungen in der Dateiliste');
@define('PLUGIN_DOWNLOADMANAGER_SHOWDESC_INLIST_DESC',  'Wenn Sie eine kompakte Liste wollen, so schalten Sie dies aus. Wenn Sie dem Benutzer viele Informationen geben wollen, schalten Sie diese Option an.');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST',       'Dateien direkt in der Dateiliste herunter laden');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_DESC',  'Normalerweise wird dem Besucher immer eine Informationsseite angezeigt, bevor er die Datei herunter laden kann. Hier können Sie einstellen, dass man bei einem Klick auf das Icon, den Namen oder beides direkt den Download startet.');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_NO',    'Immer Infoseite anzeigen');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_ICON',  'Download über Icon');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_NAME',  'Download über Dateiname');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_BOTH',  'Download über beides');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING',          'Neue Versionen von existierenden Dateien sollen..');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_DESC',     'Wenn Sie eine Datei hoch geladen haben, die bereits existiert, soll ein neuer Eintrag für diese Datei erzeugt werden oder soll der alte Eintrag mit den neuen Datei Informationen erneuert werden?');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_INSERT',   'neue Einträge erzeugen');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_UPDATE',   'alte Einträge erneuern');

/* changed with 0.22 and up - uncommented above */
@define('PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE', 'income ftp/trash Verzeichnis:');

/* newly shipped with 0.22 and up */
@define('PLUGIN_DOWNLOADMANAGER_BACKEND_TITLE', 'Downloadmanager v.%s - Backend Admin Menü');
@define('PLUGIN_DOWNLOADMANAGER_INTRO', 'Einführungstext (optional)');
@define('PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY', 'Allgemein: Zeige Data nur registrierten Benutzern');
@define('PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY_BLAHBLAH', 'Sollen die Kategorien und Downloads im Frontend nur registrierten und eingeloggten Benutzern dieses Blogs zur Verfügung stehen?');
@define('PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY_ERROR', 'Die Downloads stehen nur registrierten Benutzern dieses Blogs zur Verfügung!');
@define('PLUGIN_DOWNLOADMANAGER_ROOTLEVEL_TITLE', 'Dateien auf der Rootebene (versteckt im Frontend!)');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_UPGRADE_NOTCOPIED', 'Entschuldigung! Ein Fehler trat während des upgrade Prozesses auf. Die Dateien aus<br /><em>%s</em><br />konnten nicht nach<br /><em>%s</em><br />verschoben werden.<br /><br />Bitte verschieben Sie sie manuell und drücken sie <a class="backend_error_link" href="%s">diesen Link</a>, um das Plugin darüber zu informieren!<br />Löschen Sie die alten Verzeichnisse ebenfalls manuell.<br />');
#@define('PLUGIN_DOWNLOADMANAGER_ALLFILES_COPIED_NEWDIR', 'Da Sie das Downloadmanager Plugin auf v.0.24 hochgestuft haben, wurden alle alten Dateien in das neue \'/.dlm/files\' und \'/.dlm/ftpin\' Verzeichnis im Serendipity \'/archives\' Verzeichnis verschoben, um Konflikte mit dem alten Pfad zu vermeiden.<br /><br />Die Config Einstellungen wurden auf die neuen Pfade angepasst und sind künftig nicht mehr veränderbar.<br />Löschen Sie die alten Verzeichnisse manuell.<br />');
#@define('PLUGIN_DOWNLOADMANAGER_ALLFILES_COPY_NEWDIR_REMEMBER', 'Sie haben dem Plugin erfolgreich mitgeteilt, nur noch die neuen Pfade zu akzeptieren.<br /><br />Bitte denken Sie daran, ihre Dateien manuell in das neue \'archives/.dlm/files\' und \'archives/.dlm/ftpin\' Verzeichnis zu verschieben!<br />Löschen Sie die alten Verzeichnisse ebenfalls manuell.<br />');
@define('PLUGIN_DOWNLOADMANAGER_BUTTON_MARK', 'alle markieren / unmarkieren');
@define('PLUGIN_DOWNLOADMANAGER_BUTTON_MARK_TITLE', 'markierte löschen nach ftp/trash');
@define('PLUGIN_DOWNLOADMANAGER_BUTTON_MOVE_TITLE', 'markierte in Kategorie verschieben');
@define('PLUGIN_DOWNLOADMANAGER_CLEAR_TRASH', 'Lösche alle Dateien im ftp/trash Verzeichnis');
@define('PLUGIN_DOWNLOADMANAGER_NO_TRASH', 'Kein Müll im ftp/trash Verzeichnis');
@define('PLUGIN_DOWNLOADMANAGER_EDIT_FILE_RENAME', 'Datei umbenennen in');
/* HELPTIP_CF = category folder; HELPTIP_IF = incoming folder; HELPTIP_FF = file folder; HELPTIP_MF = s9y media library folder; */
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_CF_START', 'Start: Erstellen Sie eine Kategorie, um Dateien hochzuladen.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_CF_CHANGE', 'Kategorie Name im Feld selbst ändern / <em>Enter</em>');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_VIEW', 'Um das ftp/trash Verzeichnis zu sehen, wählen sie einen Subordner von root.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_MULTI', 'Alle Dateien im ftp/trash Verzeichnis werden sofort gelöscht!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_SINGLE', 'Alle Löschungen über den aktiven roten Button werden sofort gelöscht!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_ERASE', 'Alle markierten und gelöschten (x) Dateien, werden in das ftp/trash Verzeichnis <b>verschoben</b>,<br />&nbsp;&nbsp;&nbsp;um das versehentliche Löschen vieler Dateien zu vermeiden!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_KEEP', 'Dateien behalten, aber nicht im Frontend zeigen? Verschieben Sie sie in den root Ordner,<br />&nbsp;&nbsp;&nbsp;oder erstellen Sie einen verstecken Subordner! Beachten Sie, dass es 2 Config Einstellungen<br />&nbsp;&nbsp;&nbsp;bezüglich registrierter und eingeloggter Benutzer des Blog im Frontend gibt.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_CHANGE', 'Datei Name ändern auf der Datei-Link Sub-Seite.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_LFTP', 'Laden Sie Dateien per FTP in den /serendipity/archives/.dlm/ftpin Ordner.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_TRASH', 'Nutzen Sie die blauen Trashboxen, um das ftp/trash Verzeichnis nach beendeter Arbeit zu leeren!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_MOVE', 'Nutzen Sie das ftp/trash Verzeichnis, um mehrere Dateien zwischen Ordnern zu verschieben!<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. Senden Sie über <b>markieren</b> <em>und</em> <b>löschen</b> mehrere Dateien in das ftp/trash Verzeichnis;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. In den Kategorien, wählen Sie einen anderen Subordner;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. Öffnen Sie das ftp/trash Verzeichnis, <b>markieren</b> <em>und</em> <b>verschieben</b> Sie die Dateien.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_DESC', 'Bei der Deinstallation dieses Plugins werden alle zugehörigen Tabellen gelöscht!');
/*
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_VIEW', '');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_VIEW', '');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_VIEW', '');
*/

// Next lines were translated on 2011/11/22
@define('PLUGIN_DOWNLOADMANAGER_BACK_ROOT', 'Wurzel-Kategorie');
@define('PLUGIN_DOWNLOADMANAGER_BACK_CURRENT', 'Aktuelle Kategorie');

