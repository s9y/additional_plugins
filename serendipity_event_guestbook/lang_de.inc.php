<?php #

/**
 *  @version 3.40
 *  @file serendipity_event_guestbook.php, langfile(de) v.3.40 - 2013-08-21 Ian
 *  @translated 
 *  @author Ian
 *  @revisionDate 2013-08-21
 */

@define('PLUGIN_GUESTBOOK_HEADLINE', 'Überschrift');
@define('PLUGIN_GUESTBOOK_HEADLINE_BLAHBLAH', 'Was für eine Überschrift soll die Seite haben?');
@define('PLUGIN_GUESTBOOK_TITLE', 'Gästebuch');
@define('PLUGIN_GUESTBOOK_TITLE_BLAHBLAH', 'Zeigt ein Gästebuch innerhalb des Blogs mit dem gewählten Design und allen Formatierungen an.');
@define('PLUGIN_GUESTBOOK_PERMALINK', 'Permalink');
@define('PLUGIN_GUESTBOOK_PERMALINK_BLAHBLAH', 'Gibt den Permalink der Gästebuch-Seite an. Dieser muss eine absolute Pfadangabe vom HTTP-Root ab sein und die Dateiendung .htm oder .html besitzen!');
@define('PLUGIN_GUESTBOOK_PAGETITLE', 'Seitentitel');
@define('PLUGIN_GUESTBOOK_PAGETITLE_BLAHBLAH', 'Titel der Seite. Achtung: ohne Sonderzeichen, da auch für die Adresszeile a la (index.php?serendipity[subpage]=name) benutzt.');

@define('PLUGIN_GUESTBOOK_FORMORDER', 'Gästebuch-Formular');
@define('PLUGIN_GUESTBOOK_FORMORDER_BLAHBLAH', 'Wählen Sie, wo das Gästebuch-Formular angezeigt werden soll.');
@define('PLUGIN_GUESTBOOK_FORMORDER_TOP', 'Oben');
@define('PLUGIN_GUESTBOOK_FORMORDER_BOTTOM', 'Unten');

@define('PLUGIN_GUESTBOOK_EMAILADMIN_BLAHBLAH', 'Soll der Administrator bei jedem neuen Eintrag eine E-Mail bekommen?');
@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN', 'E-Mailadresse des Admin');
@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN_BLAHBLAH', 'Bitte eine gültige E-Mailadresse eintragen. Wenn "E-Mail Admin" aktiviert, dann wird diese Adresse über jeden neuen Eintrag per Mail informiert.');
@define('PLUGIN_GUESTBOOK_SHOWE-Mail', 'E-Mailadresse des Users?');
@define('PLUGIN_GUESTBOOK_SHOWE-Mail_BLAHBLAH', 'Soll ein Feld für die E-Mailadresse des Users angezeigt werden?');
@define('PLUGIN_GUESTBOOK_SHOWURL', 'Homepage des Users?');
@define('PLUGIN_GUESTBOOK_SHOWURL_BLAHBLAH', 'Soll ein Feld für die Homepage des Users angezeigt werden?');
@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA', 'Captcha-Schutz aktivieren?');
@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA_BLAHBLAH', 'Soll das Gästebuch den Captcha-Schutz benutzen? Dies setzt ein aktiviertes Spamblock-Plugin voraus!');
@define('PLUGIN_GUESTBOOK_NUMBER', 'Einträge pro Seite');
@define('PLUGIN_GUESTBOOK_NUMBER_BLAHBLAH', 'Wieviele Einträge sollen pro Seite dargestellt werden?');
@define('PLUGIN_GUESTBOOK_WORDWRAP', 'Anzahl der Zeichen pro Zeile');
@define('PLUGIN_GUESTBOOK_WORDWRAP_BLAHBLAH', 'Nach wievielen Zeichen soll ein automatischer Zeilenumbruch erfolgen.');
@define('PLUGIN_GUESTBOOK_ERROR_DATA', 'Fehler bei der Verarbeitung des Gästebuch-Eintrages!');
@define('PLUGIN_GUESTBOOK_SHOWEMAIL', 'E-Mail-Adresse des Users?');
@define('PLUGIN_GUESTBOOK_SHOWEMAIL_BLAHBLAH', 'Soll die E-Mail-Adresse des Besuchers abgefragt werden?');

@define('PLUGIN_GUESTBOOK_INTRO', 'Einführungstext (optional)');
@define('PLUGIN_GUESTBOOK_MESSAGE', 'Nachricht');
@define('PLUGIN_GUESTBOOK_SENT', 'Dargestellter Text nach Übermittlung der Nachricht.');
@define('PLUGIN_GUESTBOOK_SENT_HTML', 'Ihre Nachricht wurde erfolgreich verschickt!!');
@define('PLUGIN_GUESTBOOK_ERROR_HTML', 'Ein Fehler trat bei der Übermittlung der E-Mail auf. Eventuell ist ihre E-Mail Adresse ungültig oder der Server ist spazieren gegangen.');
@define('PLUGIN_GUESTBOOK_ERROR_DATA', 'Name, E-Mail und ihre Nachricht dürfen nicht leer gelassen werden.');
@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT', 'Als Artikel formatieren?');
@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT_BLAHBLAH', 'Legt fest ob die Ausgabe automatisch wie ein Artikel formatiert werden soll (Farben, Ränder, etc.) (Standard: ja)');
@define('PLUGIN_GUESTBOOK_CAPTCHAWARNING', '');
@define('PLUGIN_GUESTBOOK_PROTECTION', 'E-Mailadressen werden im Gästebuch verschlüsselt dargestellt');
@define('PLUGIN_GUESTBOOK_DBDONE', 'Gästebucheintrag hinzugefügt!');
@define('PLUGIN_GUESTBOOK_DBDONE_APP', '(Sobald der Eintrag freigegeben ist, wird er im Gästebuch erscheinen.)');
@define('PLUGIN_GUESTBOOK_USER_LOGGEDOFF', 'Benutzer wurde ausgeloggt');
@define('PLUGIN_GUESTBOOK_USERSDATE_OF_ENTRY', 'schrieb am');
@define('PLUGIN_GUESTBOOK_UNKNOWN_ERROR', 'Unbekannter Fehler! Bitte kontaktieren Sie den Administrator dieser Seiten');
@define('PLUGIN_GUESTBOOK_TIMESTAMP_THE', 'dem');
@define('PLUGIN_GUESTBOOK_ALTER_OLDTABLE_DONE', 'Datenbank-Tabelle wurde erfolgreich geändert.');
@define('PLUGIN_GUESTBOOK_INSTALL_NEWTABLE_DONE', 'Datenbank-Tabelle wurde erfolgreich erstellt.');
@define('PLUGIN_GUESTBOOK_SUBMITFORM', 'Neuer Gästebucheintrag');

@define('BODY', 'Anzeige');
@define('SUBMIT', 'Eintrag abschicken');
@define('REFRESH', 'Sie müssen diese Seite neu laden, um den neu erstellten Eintrag zu sehen.');

@define('GUESTBOOK_NEXTPAGE', 'nächste Seite');
@define('GUESTBOOK_PREVPAGE', 'vorherige Seite');

@define('TEXT_DELETE', 'löschen');
@define('TEXT_SAY', 'schrieb');
@define('TEXT_EMAIL', 'E-Mail');
@define('TEXT_NAME', 'Name');
@define('TEXT_HOMEPAGE', 'Homepage');
@define('TEXT_BODY', 'Eintrag');
@define('TEXT_EMAILSUBJECT', 'Neuer Gaestebuch Eintrag');//this is email
@define('TEXT_EMAILTEXT', "%s hat gerade folgendes in das Gästebuch geschrieben:\n%s\n%s\n");
@define('TEXT_CONVERTBOLDUNDERLINE', 'Umschließende Sterne heben ein Wort hervor (*wort*), per _wort_ kann ein Wort unterstrichen werden.');
@define('TEXT_CONVERTSMILIES', 'Standard-Text Smilies wie :-) und ;-) werden zu Bildern konvertiert.');
@define('TEXT_IMG_DELETEENTRY', 'Eintrag löschen');
@define('TEXT_IMG_LASTMODIFIED', 'zuletzt modifiziert');
@define('TEXT_USERS_HOMEPAGE', 'Homepage');

@define('ERROR_NAMEEMPTY', 'Bitte geben Sie einen Namen an.');
@define('ERROR_TEXTEMPTY', 'Bitte geben Sie einen Text an.');
@define('ERROR_EMAILEMPTY', 'Bitte geben Sie eine gültige E-Mail an.');
@define('ERROR_DATATOSHORT', 'Ihre Eingabe sollte mindestens 3, im Textfeld 10 Zeichen lang sein.');
@define('ERROR_DATASTRIPPED', 'Ein aktiver Security-Filter hat ihren Eintrag als ungültig eingestuft. Senden Sie die bereinigte Version erneut.');
@define('ERROR_DATANOTAGS', 'Ihre Nachricht wurde durch einen aktiven Plugin-Wortfilter als ungültig eingestuft.');
@define('ERROR_NOVALIDEMAIL', 'Ihre E-Mailadresse scheint nicht gültig zu sein: ');
@define('ERROR_NOINPUT', 'Bitte füllen Sie immer Name, E-Mail und Kommentar aus');
@define('ERROR_ISFALSECAPTCHA', 'Die Spamschutz-Grafik-Zeichen stimmen nicht überein!');
@define('ERROR_NOCAPTCHASET', 'Die generellen CAPTCHA Spamschutz Einstellungen sind möglicherweise nicht korrekt konfiguriert!');
@define('ERROR_UNKNOWN', 'Ein unbekannter Fehler ist aufgetreten. Bitte beenden Sie die Anwendung und benachrichtigen Sie unseren Webmaster. Danke!');
@define('ERROR_OCCURRED', 'Folgende Fehler traten auf:');

@define('THANKS_FOR_ENTRY', 'Gästebuch-Eintrag:');
@define('WINDOW_CLOSE', 'Fenster schließen');
@define('QUESTION_DELETE', 'Soll der Eintrag von %s wirklich gelöscht werden?');

@define('PAGINATOR_TO', 'Zur');
@define('PAGINATOR_FIRST', 'Ersten');
@define('PAGINATOR_PREVIOUS', 'Vorhergehenden');
@define('PAGINATOR_NEXT', 'Nächsten');
@define('PAGINATOR_LAST', 'Letzten');
@define('PAGINATOR_PAGE', 'Seite');
@define('PAGINATOR_RANGE', ' bis ');
@define('PAGINATOR_OFFSET', ' von ');
@define('PAGINATOR_ENTRIES', ' Einträgen. ');

/* config v.3.20 additions */
@define('PLUGIN_GUESTBOOK_SHOWAPP', 'Einträge bestätigen?');
@define('PLUGIN_GUESTBOOK_SHOWAPP_BLAHBLAH', 'Die Einträge in das Gästebuch müssen generell erst durch den Admin bestätigt werden, bevor sie im Gästebuch angezeigt werden (default: false).');
@define('PLUGIN_GUESTBOOK_APP_ENTRY', 'Der Eintrag %s wurde gespeichert');
@define('PLUGIN_GUESTBOOK_CHECKBOXALERT', 'Wenn Sie einen unveröffentlichten Eintrag freigeben, ändern oder löschen wollen, müssen Sie die Checkbox des Eintrags vorher aktivieren.');
@define('PLUGIN_GUESTBOOK_ADMINBODY', 'Admins Antwort');
@define('PLUGIN_GUESTBOOK_FORM_RIGHT_BBC', 'Einfache BBcode Maskierung (Fett, Kursiv, Unter-, Durchgestrichen, Quotes).');
/* config v.3.25 additions */
@define('PLUGIN_GUESTBOOK_AUTOMODERATE', 'Nutze Auto-Moderation?');
@define('PLUGIN_GUESTBOOK_AUTOMODERATE_BLAHBLAH', 'Einzelne Einträge in das Gästebuch müssen erst durch den Admin im Backend bestätigt werden, bevor sie im Gästebuch angezeigt werden, wenn das SPAMBLOCK-Plugin diese Einträge, durch aufgetretende Stopwörter, als zu moderieren einstuft (default: false). Die Gästebuch eigene Eintrags-Validation wird zusätzlich, abhängig von der gewählten Captcha Option, immer Captcha Checks durchführen, wenn das Spamblock Plugin Einträge als "moderieren" einstuft. Dies ist ein geändertes Verhalten gegenüber dem normalen Spamblock Check! Generelle- und gleichzeitige Auto-Moderation sind nicht möglich!');
@define('PLUGIN_GUESTBOOK_AUTOMODERATE_ERROR', 'Ihr Beitrag wurde als auto-moderiert eingestuft. ');
@define('PLUGIN_GUESTBOOK_CONFIG_ERROR', 'Konfigurations Fehler! Gästebuch Option: "Spamblock Auto-Moderation" wurde zurückgesetzt, weil die Gästebuch Option \'moderieren\' aktiv geschaltet war! Benutzen sie bitte nur eine dieser Optionen.');
/* config v.3.26 additions */
@define('PLUGIN_GUESTBOOK_FILTER_ENTRYCHECKS', 'Spezial Body Checks');
@define('PLUGIN_GUESTBOOK_FILTER_ENTRYCHECKS_BLAHBLAH', 'Liste Gästebuch eigene, individuelle Eintrags Body Checks. Reguläre Ausdrücke sind erlaubt, Zeichenketten durch Semikolon (;) zu trennen. Sonderzeichen sind durch "\" zu escapen. Wenn sie dies Feld leer lassen, werden keine Spezial-Checks vorgenommen.');

/* Backend main constants */
@define('PLUGIN_GUESTBOOK_ADMIN_NAME', 'Gästebuch');
@define('PLUGIN_GUESTBOOK_ADMIN_NAME_MENU', 'Gästebuch  v.%s - Backend Administration Menu');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC', 'Gästebuch - Plugin DB Administration');
@define('PLUGIN_GUESTBOOK_ADMIN_VIEW', 'Gästebuch - Einträge ansehen');
@define('PLUGIN_GUESTBOOK_ADMIN_VIEW_NORESULT', 'Es liegen keine freigegebenen Einträge im Gästebuch vor!');
@define('PLUGIN_GUESTBOOK_ADMIN_VIEW_DESC', 'Sortiert nach Datum des Eintrags [ jüngster oben ].');
@define('PLUGIN_GUESTBOOK_ADMIN_APP', 'Gästebuch - Einträge bestätigen');
@define('PLUGIN_GUESTBOOK_ADMIN_APP_DESC', 'Sortiert nach Datum des Eintrags [ jüngster oben ].');
@define('PLUGIN_GUESTBOOK_ADMIN_APP_NORESULT', 'Es liegen keine Einträge zum Bestätigen vor!');
@define('PLUGIN_GUESTBOOK_ADMIN_ERASE', 'Gästebuch - Einträge löschen');
@define('PLUGIN_GUESTBOOK_ADMIN_ADD', 'Gästebuch - Einträge eintragen');
@define('PLUGIN_GUESTBOOK_ADMIN_DROP_SURE', 'Wollen Sie die guestbook Tabelle mit allen Daten wirklich vollständig löschen? Bitte bestätigen Sie dies hier!');
@define('PLUGIN_GUESTBOOK_ADMIN_DROP_OK', 'Ihre Datenbank %s wurde erfolgreich gelöscht!');
@define('PLUGIN_GUESTBOOK_ADMIN_DUMP_SELF', 'Vor der Ausführung sollten Sie sich zur Sicherheit via PhpMyAdmin oder via den obigen Backup Link einen mysql_dump ihrer Daten anlegen!');
/* backend database (dbc) administration constants */
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP', 'DB Administration - sichern');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_DESC', 'Backup der guestbook Datenbanktabelle');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_TITLE', 'Sichern der guestbook Datenbank Inhalte');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_DONE', 'Ihre Gästebuch Datenbank Tabelle wurde erfolgreich gesichert!');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT', 'DB Administration - eintragen');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_DESC', 'Eintrag in die guestbook Datenbanktabelle');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_TITLE', 'Erstellen einer Datenbanktabelle');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_MSG', 'Das Einfügen eines Datenbank Backups ist nicht trivial. Benutzen sie bitte Werkzeuge wie PhpMyAdmin um ihre Daten in die Datenbank zu übernehmen!');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE', 'DB Administration - löschen');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE_DESC', 'Löschen der guestbook Datenbanktabelle');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE_TITLE', 'Tabelle lÖschen'); /* *_title = upper_case */
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DELFILE_MSG', 'Datenbank SQL Datei <u>%s</u> erfolgreich gelöscht');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD', 'DB Administration - download');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_DESC', 'Download der letzten Datenbank Sicherung');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_TITLE', 'Herunterladen der Datenbank Sicherungen');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_MSG', 'Es existiert kein Datenbank Backup');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_DESC', 'Es ist keine guestbook Datenbanktabelle vorhanden.');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_TITLE', 'Administration - error');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_NOBACKUP', 'Die angeforderte Datenbanktabelle konnte nicht gesichert werden!');

//
//  serendipity_plugin_guestbook.php
//
@define('PLUGIN_GUESTSIDE_NAME', 'Gästebuch-Seitenleiste');
@define('PLUGIN_GUESTSIDE_BLAHBLAH', 'Zeige die letzten Einträge des Gästebuchs');
@define('PLUGIN_GUESTSIDE_TITLE', 'Titel');
@define('PLUGIN_GUESTSIDE_TITLE_BLAHBLAH', 'Geben Sie den Titel für die Sidebar an.');
@define('PLUGIN_GUESTSIDE_SHOWE-Mail', 'Zeige E-Mail');
@define('PLUGIN_GUESTSIDE_SHOWE-Mail_BLAHBLAH', 'Soll die E-Mailadresse der Absender gezeigt werden?');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE', 'Zeige Homepage');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE_BLAHBLAH', 'Soll die Homepage der Absender gezeigt worden?');
@define('PLUGIN_GUESTSIDE_MAXCHARS', 'Max. Buchstaben');
@define('PLUGIN_GUESTSIDE_MAXCHARS_BLAHBLAH', 'Die Länge der Eintrag in Buchstaben');
@define('PLUGIN_GUESTSIDE_MAXITEMS', 'Max. Einträge');
@define('PLUGIN_GUESTSIDE_MAXITEMS_BLAHBLAH', 'Die Anzahl der Einträge, die gezeigt werden sollen');

