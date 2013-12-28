<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/14
 */@define('PLUGIN_EVENT_SMTPMAIL_NAME', 'SMTP Mail');
@define('PLUGIN_EVENT_SMTPMAIL_DESC', 'Použití SMTP serveru pro odesílání pošty');
@define('PLUGIN_EVENT_SMTPMAIL_SMTP_SERVER', 'SMTP server');
@define('PLUGIN_EVENT_SMTPMAIL_SMTP_SERVER_DESC', 'Adresa, na které se nalézá SMTP server, přes který se mají odesílat maily.');
@define('PLUGIN_EVENT_SMTPMAIL_SMTP_PORT', 'Port SMTP serveru');
@define('PLUGIN_EVENT_SMTPMAIL_SMTP_PORT_DESC', '(Výchozí: 25)');
@define('PLUGIN_EVENT_SMTPMAIL_POP3_SERVER', 'POP3 server');
@define('PLUGIN_EVENT_SMTPMAIL_POP3_SERVER_DESC', 'Nastavení je vyžadováno pouze pokud Váš mailový server vyžaduje funkci "POP3 before SMTP".');
@define('PLUGIN_EVENT_SMTPMAIL_POP3_PORT', 'Port POP3 serveru');
@define('PLUGIN_EVENT_SMTPMAIL_POP3_PORT_DESC', 'Nastavení je vyžadováno pouze pokud Váš mailový server vyžaduje funkci "POP3 before SMTP". (Výchozí hodnota: 110)');
@define('PLUGIN_EVENT_SMTPMAIL_AUTH', 'Metoda přihlášení');
@define('PLUGIN_EVENT_SMTPMAIL_AUTH_DESC', '');
@define('PLUGIN_EVENT_SMTPMAIL_SECURE', 'Použít zabezpečené připojení');
@define('PLUGIN_EVENT_SMTPMAIL_SECURE_DESC', 'Některé SMTP servery vyžadují připojení zabezpečeným (šifrovaným) připojením.');
@define('PLUGIN_EVENT_SMTPMAIL_USER', 'Uživatelské jméno');
@define('PLUGIN_EVENT_SMTPMAIL_USER_DESC', '');
@define('PLUGIN_EVENT_SMTPMAIL_PASSWD', 'Heslo');
@define('PLUGIN_EVENT_SMTPMAIL_PASSWD_DESC', '');
?>