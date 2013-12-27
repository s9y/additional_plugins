/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/27
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/09/12
 */

@define('PLUGIN_EVENT_FORGOTPASSWORD_NAME', 'Zapomenuté heslo');
@define('PLUGIN_EVENT_FORGOTPASSWORD_DESC', 'Vybranému uživateli umožňuje změnit heslo.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_LOST_PASSWORD', 'Zapomenuté heslo?');
@define('PLUGIN_EVENT_FORGOTPASSWORD_ENTER_USERNAME', 'Zadejte přihlašovací jméno k účtu se zapomenutým heslem');
@define('PLUGIN_EVENT_FORGOTPASSWORD_ENTER_PASSWORD', 'Zadejte nové heslo');
@define('PLUGIN_EVENT_FORGOTPASSWORD_SEND_EMAIL', 'Poslat email');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SUBJECT', 'Zapomenuté heslo');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_BODY', 'Někdo (pravděpodobně ty sám) chce změnit heslo pro přístup do blogu.'."\n".'pokud chcete změnit heslo, klikněte na následující odkaz:'."\n");
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_DB_ERROR', 'Nezdařilo se připojení do databáze');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_CANNOT_SEND', 'Nepodařilo se poslat mail, pravděpodobně kvůli chybnému nastavení SMPT serveru v php.ini</br>'."\n".'nebo protože jste ve svém uživatelském profilu nezadali platnou emailovou adresu.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SENT', 'Email úspěšně odeslán. Zkontrolujte svoji mailovou schránku.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_CHANGE_PASSWORD', 'Změnit heslo');
@define('PLUGIN_EVENT_FORGOTPASSWORD_PASSWORD_CHANGED', 'Heslo úspěšně změněno');
@define('PLUGIN_EVENT_FORGOTPASSWORD_USER_NOT_EXIST', 'Zadané uživatelské jméno v databázi není. Vraťte se a zkuste to znovu.');

// Next lines were translated on 2010/09/12
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAIL', 'Poslat oznámení mailem, když se uživatel pokusí změnit heslo bez zadání mailové adresy?');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAILTXT', 'Obsah oznamovacího mailu');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAILTXT_DEFAULT', 'Uživatel "%s" se pokusil přihlásit, ale nezadal emailovou adresu. Vytvořte prosím nové heslo a kontaktujte uživatele.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER', 'Chybová zpráva, pokud neexistuje emailová adresa.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_DEFAULT', 'Pro uživatele nebyla zadána žádná emailová adresa. Nové heslo nemohlo být posláno mailem.');