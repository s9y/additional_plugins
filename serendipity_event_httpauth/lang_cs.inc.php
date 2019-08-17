<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/21
 */

@define('PLUGIN_HTTPAUTH_NAME', 'HTTP autentifikace');
@define('PLUGIN_HTTPAUTH_BLAHBLAH', 'Ovìøuje uživatele pomocí HTTP auth s použitím jejich serendipity pøihlašovacích dat.');

@define('PLUGIN_HTTPAUTH_REMOTEUSER', 'Povolit REMOTE_USER autentifikace?');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_DESC', 'Pokud je povoleno, uživatelé mohou být autentifikováni pomocí serveru IIS/Apache. Ty budou ukládat centrální serverovou promìnnou REMOTE_USER se jménem pøihlášeného uživatele a Serendipity se pak mùže pøihlásit pomocí tohoto uživatelského jména. Pokud umožníte tuto volbu, mìjte na pamìti, že váš vlastní autentifikaèní systém musí zaruèovat, že se pøihlásí pouze k tomu oprávnìní uživatelé, protože tato volba pøemosuje pøihlašovací systém Serendipity!');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_WILDCARD', 'Povolit wildcard autentifikaci?');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_WILDCARD_DESC', 'Tato volba se použije pouze pokud je zapnuta autentifikace pomocí REMOTE_USER. Pokud je toto nastavení použito, pak každý REMOTE_USER, který není v databázi serendipity, bude pøihlášen jako výchozí uživatel. To znamená, že pokud se uživatel pøihlásí jako "Pepan", ale v Serendipity žádný takový úèet neexistuje, pak bude uživatel pøihlášen jako "Návštìvník".');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_AUTHORID', 'Wildcard autentifikace: ID autora');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_AUTHORID_DESC', 'Zadejte ID autora, pod kterým bude pøihlášen kažá "wildcard" pøihlášený uživatel.');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_USERLEVEL', 'Wildcard autentifikace: Oprávnìní');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_USERLEVEL_DESC', 'Zadejte oprávnìní, kterými bude disponovat uživatele pøihlášený jako "wildacard".');
@define('PLUGIN_HTTPAUTH_FRONTEND', 'Vyžadovat autentifikaci pro frontend');
@define('PLUGIN_HTTPAUTH_FRONTEND_DESC', 'Má být autentifikaèní rutina vyžadována už pro frontend blogu? Pokud ano, pak je pøístup k blogu nemožný bez pøhlášení. Pokud volba není zapnuta, pak je pøihášení vyžadováno pouze pro pøístup do backendu (zadní - admnistrátorské èásti) blogu.');

?>
