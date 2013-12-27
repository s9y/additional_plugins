/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/08
 */

@define('PLUGIN_EVENT_SPAMBLOCK_RBL_TITLE', 'Antispamová ochrana (RBL)');
@define('PLUGIN_EVENT_SPAMBLOCK_RBL_DESC', 'Odmítne komentáře, které jsou zadány ze adres, které jsou vedeny v blacklistu RBL. Pozor, že tato volba může znemožnit posílání komentářů uživatelům, kteří sedí za proxy serverem nebo kteří používají vytáčené spojení.');
@define('PLUGIN_EVENT_SPAMBLOCK_ERROR_RBL', 'Antispamová kontrola: Vaše IP adresa je vedena jako Open Relay. Obraťte se na svého poskytovatele internetového připojení!');
@define('PLUGIN_EVENT_SPAMBLOCK_RBLLIST', 'Který RBL server má být kontaktován?');
@define('PLUGIN_EVENT_SPAMBLOCK_RBLLIST_DESC', 'Blokuje komentáře v závislosti na poskytnutých RBL seznamech. Vyhněte se seznamům s dynamickými hosty.');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_RBL', 'RBL-block');

@define('PLUGIN_EVENT_SPAMBLOCK_HONEYPOT_TITLE', 'Spam Protector (projekt Honeypot)');
@define('PLUGIN_EVENT_SPAMBLOCK_HONEYPOT_DESC', 'Odmítne komentáře zadané z adres vyjmenovaných v blacklistu projektu Honeypot http:BL');
@define('PLUGIN_EVENT_SPAMBLOCK_HONEYPOT_KEY', 'httpBL_key');
@define('PLUGIN_EVENT_SPAMBLOCK_HONEYPOT_KEY_DESC', 'Zadejte http:BL klíč');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_HONEYPOT', 'Projekt Honeypot http:BL nalezl ');
?>
