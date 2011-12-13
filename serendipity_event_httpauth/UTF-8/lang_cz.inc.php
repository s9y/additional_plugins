<?php # lang_cz.inc.php 1.0 2009-06-21 19:37:07 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/21
 */

@define('PLUGIN_HTTPAUTH_NAME', 'HTTP autentifikace');
@define('PLUGIN_HTTPAUTH_BLAHBLAH', 'Ověřuje uživatele pomocí HTTP auth s použitím jejich serendipity přihlašovacích dat.');

@define('PLUGIN_HTTPAUTH_REMOTEUSER', 'Povolit REMOTE_USER autentifikace?');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_DESC', 'Pokud je povoleno, uživatelé mohou být autentifikováni pomocí serveru IIS/Apache. Ty budou ukládat centrální serverovou proměnnou REMOTE_USER se jménem přihlášeného uživatele a Serendipity se pak může přihlásit pomocí tohoto uživatelského jména. Pokud umožníte tuto volbu, mějte na paměti, že váš vlastní autentifikační systém musí zaručovat, že se přihlásí pouze k tomu oprávnění uživatelé, protože tato volba přemosťuje přihlašovací systém Serendipity!');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_WILDCARD', 'Povolit wildcard autentifikaci?');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_WILDCARD_DESC', 'Tato volba se použije pouze pokud je zapnuta autentifikace pomocí REMOTE_USER. Pokud je toto nastavení použito, pak každý REMOTE_USER, který není v databázi serendipity, bude přihlášen jako výchozí uživatel. To znamená, že pokud se uživatel přihlásí jako "Pepan", ale v Serendipity žádný takový účet neexistuje, pak bude uživatel přihlášen jako "Návštěvník".');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_AUTHORID', 'Wildcard autentifikace: ID autora');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_AUTHORID_DESC', 'Zadejte ID autora, pod kterým bude přihlášen kažá "wildcard" přihlášený uživatel.');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_USERLEVEL', 'Wildcard autentifikace: Oprávnění');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_USERLEVEL_DESC', 'Zadejte oprávnění, kterými bude disponovat uživatele přihlášený jako "wildacard".');
@define('PLUGIN_HTTPAUTH_FRONTEND', 'Vyžadovat autentifikaci pro frontend');
@define('PLUGIN_HTTPAUTH_FRONTEND_DESC', 'Má být autentifikační rutina vyžadována už pro frontend blogu? Pokud ano, pak je přístup k blogu nemožný bez přhlášení. Pokud volba není zapnuta, pak je přihášení vyžadováno pouze pro přístup do backendu (zadní - admnistrátorské části) blogu. Mějte na paměti, že přihlášení do administrační sekce je možné až od verze Serendipity 0.9-beta2!');

?>
