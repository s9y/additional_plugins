/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/14
 */@define('PLUGIN_EVENT_SMTPMAIL_NAME', 'SMTP Mail');
@define('PLUGIN_EVENT_SMTPMAIL_DESC', 'Pou¾ití SMTP serveru pro odesílání po¹ty');
@define('PLUGIN_EVENT_SMTPMAIL_SMTP_SERVER', 'SMTP server');
@define('PLUGIN_EVENT_SMTPMAIL_SMTP_SERVER_DESC', 'Adresa, na které se nalézá SMTP server, pøes který se mají odesílat maily.');
@define('PLUGIN_EVENT_SMTPMAIL_SMTP_PORT', 'Port SMTP serveru');
@define('PLUGIN_EVENT_SMTPMAIL_SMTP_PORT_DESC', '(Výchozí: 25)');
@define('PLUGIN_EVENT_SMTPMAIL_POP3_SERVER', 'POP3 server');
@define('PLUGIN_EVENT_SMTPMAIL_POP3_SERVER_DESC', 'Nastavení je vy¾adováno pouze pokud Vá¹ mailový server vy¾aduje funkci "POP3 before SMTP".');
@define('PLUGIN_EVENT_SMTPMAIL_POP3_PORT', 'Port POP3 serveru');
@define('PLUGIN_EVENT_SMTPMAIL_POP3_PORT_DESC', 'Nastavení je vy¾adováno pouze pokud Vá¹ mailový server vy¾aduje funkci "POP3 before SMTP". (Výchozí hodnota: 110)');
@define('PLUGIN_EVENT_SMTPMAIL_AUTH', 'Metoda pøihlá¹ení');
@define('PLUGIN_EVENT_SMTPMAIL_AUTH_DESC', '');
@define('PLUGIN_EVENT_SMTPMAIL_SECURE', 'Pou¾ít zabezpeèené pøipojení');
@define('PLUGIN_EVENT_SMTPMAIL_SECURE_DESC', 'Nìkteré SMTP servery vy¾adují pøipojení zabezpeèeným (¹ifrovaným) pøipojením.');
@define('PLUGIN_EVENT_SMTPMAIL_USER', 'U¾ivatelské jméno');
@define('PLUGIN_EVENT_SMTPMAIL_USER_DESC', '');
@define('PLUGIN_EVENT_SMTPMAIL_PASSWD', 'Heslo');
@define('PLUGIN_EVENT_SMTPMAIL_PASSWD_DESC', '');
?>