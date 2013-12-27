/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/27
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/09/12
 */

@define('PLUGIN_EVENT_FORGOTPASSWORD_NAME', 'Zapomenuté heslo');
@define('PLUGIN_EVENT_FORGOTPASSWORD_DESC', 'Vybranému uivateli umoòuje zmìnit heslo.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_LOST_PASSWORD', 'Zapomenuté heslo?');
@define('PLUGIN_EVENT_FORGOTPASSWORD_ENTER_USERNAME', 'Zadejte pøihlašovací jméno k úètu se zapomenutım heslem');
@define('PLUGIN_EVENT_FORGOTPASSWORD_ENTER_PASSWORD', 'Zadejte nové heslo');
@define('PLUGIN_EVENT_FORGOTPASSWORD_SEND_EMAIL', 'Poslat email');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SUBJECT', 'Zapomenuté heslo');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_BODY', 'Nìkdo (pravdìpodobnì ty sám) chce zmìnit heslo pro pøístup do blogu.'."\n".'pokud chcete zmìnit heslo, kliknìte na následující odkaz:'."\n");
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_DB_ERROR', 'Nezdaøilo se pøipojení do databáze');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_CANNOT_SEND', 'Nepodaøilo se poslat mail, pravdìpodobnì kvùli chybnému nastavení SMPT serveru v php.ini</br>'."\n".'nebo protoe jste ve svém uivatelském profilu nezadali platnou emailovou adresu.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SENT', 'Email úspìšnì odeslán. Zkontrolujte svoji mailovou schránku.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_CHANGE_PASSWORD', 'Zmìnit heslo');
@define('PLUGIN_EVENT_FORGOTPASSWORD_PASSWORD_CHANGED', 'Heslo úspìšnì zmìnìno');
@define('PLUGIN_EVENT_FORGOTPASSWORD_USER_NOT_EXIST', 'Zadané uivatelské jméno v databázi není. Vrate se a zkuste to znovu.');

// Next lines were translated on 2010/09/12
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAIL', 'Poslat oznámení mailem, kdy se uivatel pokusí zmìnit heslo bez zadání mailové adresy?');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAILTXT', 'Obsah oznamovacího mailu');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAILTXT_DEFAULT', 'Uivatel "%s" se pokusil pøihlásit, ale nezadal emailovou adresu. Vytvoøte prosím nové heslo a kontaktujte uivatele.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER', 'Chybová zpráva, pokud neexistuje emailová adresa.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_DEFAULT', 'Pro uivatele nebyla zadána ádná emailová adresa. Nové heslo nemohlo bıt posláno mailem.');