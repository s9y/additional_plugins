<?php # $Id$

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_de.inc.php
 */

@define('PLUGIN_EVENT_FORGOTPASSWORD_NAME', 'Passwort vergessen');
@define('PLUGIN_EVENT_FORGOTPASSWORD_DESC', 'Ändere das Passwort für ausgewählten Benutzer');
@define('PLUGIN_EVENT_FORGOTPASSWORD_LOST_PASSWORD', 'Passwort vergessen?');
@define('PLUGIN_EVENT_FORGOTPASSWORD_ENTER_USERNAME', 'Name des vergessenen Login');
@define('PLUGIN_EVENT_FORGOTPASSWORD_ENTER_PASSWORD', 'Eingabe Neues Passwort');
@define('PLUGIN_EVENT_FORGOTPASSWORD_SEND_EMAIL', 'Sende E-Mail');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SUBJECT', 'Passwort vergessen');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_BODY', "Jemand (vielleicht Sie selbst) möchte das Passwort für Ihr Weblog-Konto ändern,\nwenn dies bestätigt werden soll bitte auf den folgenden Link klicken:\n");
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_DB_ERROR', 'Keine Verbindung zur Datenbank herstellbar');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_CANNOT_SEND', "Kein E-Mailversand, dies könnte an einer fehlerhaften SMTP-Konfiguration in php.ini<br />\nliegen, oder durch die Fehlerhafte Angabe der E-Mail-Adresse im Benutzerprofil.");
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SENT', 'E-Mail erfolgreich versendet');
@define('PLUGIN_EVENT_FORGOTPASSWORD_CHANGE_PASSWORD', 'Ändere Passwort');
@define('PLUGIN_EVENT_FORGOTPASSWORD_PASSWORD_CHANGED', 'Änderung des Passwortes erfolgreich');
@define('PLUGIN_EVENT_FORGOTPASSWORD_USER_NOT_EXIST', 'Gewählter Benutzername existiert nicht in der Datenbank, bitte zurück und erneut versuchen');
