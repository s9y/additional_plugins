<?php # lang_cs.inc.php 1.0 2009-06-08 19:37:59 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/08
 */

@define('PLUGIN_EVENT_SPAMBLOCK_RBL_TITLE', 'Antispamová ochrana (RBL)');
@define('PLUGIN_EVENT_SPAMBLOCK_RBL_DESC', 'Odmítne komentáøe, které jsou zadány ze adres, které jsou vedeny v blacklistu RBL. Pozor, že tato volba mùže znemožnit posílání komentáøù uživatelùm, kteøí sedí za proxy serverem nebo kteøí používají vytáèené spojení.');
@define('PLUGIN_EVENT_SPAMBLOCK_ERROR_RBL', 'Antispamová kontrola: Vaše IP adresa je vedena jako Open Relay. Obrate se na svého poskytovatele internetového pøipojení!');
@define('PLUGIN_EVENT_SPAMBLOCK_RBLLIST', 'Který RBL server má být kontaktován?');
@define('PLUGIN_EVENT_SPAMBLOCK_RBLLIST_DESC', 'Blokuje komentáøe v závislosti na poskytnutých RBL seznamech. Vyhnìte se seznamùm s dynamickými hosty.');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_RBL', 'RBL-block');

@define('PLUGIN_EVENT_SPAMBLOCK_HONEYPOT_TITLE', 'Spam Protector (projekt Honeypot)');
@define('PLUGIN_EVENT_SPAMBLOCK_HONEYPOT_DESC', 'Odmítne komentáøe zadané z adres vyjmenovaných v blacklistu projektu Honeypot http:BL');
@define('PLUGIN_EVENT_SPAMBLOCK_HONEYPOT_KEY', 'httpBL_key');
@define('PLUGIN_EVENT_SPAMBLOCK_HONEYPOT_KEY_DESC', 'Zadejte http:BL klíè');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_HONEYPOT', 'Projekt Honeypot http:BL nalezl ');
?>
