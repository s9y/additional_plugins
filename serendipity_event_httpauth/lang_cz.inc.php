<?php # lang_cz.inc.php 1.0 2009-06-21 19:37:07 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/21
 */

@define('PLUGIN_HTTPAUTH_NAME', 'HTTP autentifikace');
@define('PLUGIN_HTTPAUTH_BLAHBLAH', 'Ovìøuje u¾ivatele pomocí HTTP auth s pou¾itím jejich serendipity pøihla¹ovacích dat.');

@define('PLUGIN_HTTPAUTH_REMOTEUSER', 'Povolit REMOTE_USER autentifikace?');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_DESC', 'Pokud je povoleno, u¾ivatelé mohou být autentifikováni pomocí serveru IIS/Apache. Ty budou ukládat centrální serverovou promìnnou REMOTE_USER se jménem pøihlá¹eného u¾ivatele a Serendipity se pak mù¾e pøihlásit pomocí tohoto u¾ivatelského jména. Pokud umo¾níte tuto volbu, mìjte na pamìti, ¾e vá¹ vlastní autentifikaèní systém musí zaruèovat, ¾e se pøihlásí pouze k tomu oprávnìní u¾ivatelé, proto¾e tato volba pøemos»uje pøihla¹ovací systém Serendipity!');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_WILDCARD', 'Povolit wildcard autentifikaci?');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_WILDCARD_DESC', 'Tato volba se pou¾ije pouze pokud je zapnuta autentifikace pomocí REMOTE_USER. Pokud je toto nastavení pou¾ito, pak ka¾dý REMOTE_USER, který není v databázi serendipity, bude pøihlá¹en jako výchozí u¾ivatel. To znamená, ¾e pokud se u¾ivatel pøihlásí jako "Pepan", ale v Serendipity ¾ádný takový úèet neexistuje, pak bude u¾ivatel pøihlá¹en jako "Náv¹tìvník".');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_AUTHORID', 'Wildcard autentifikace: ID autora');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_AUTHORID_DESC', 'Zadejte ID autora, pod kterým bude pøihlá¹en ka¾á "wildcard" pøihlá¹ený u¾ivatel.');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_USERLEVEL', 'Wildcard autentifikace: Oprávnìní');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_USERLEVEL_DESC', 'Zadejte oprávnìní, kterými bude disponovat u¾ivatele pøihlá¹ený jako "wildacard".');
@define('PLUGIN_HTTPAUTH_FRONTEND', 'Vy¾adovat autentifikaci pro frontend');
@define('PLUGIN_HTTPAUTH_FRONTEND_DESC', 'Má být autentifikaèní rutina vy¾adována u¾ pro frontend blogu? Pokud ano, pak je pøístup k blogu nemo¾ný bez pøhlá¹ení. Pokud volba není zapnuta, pak je pøihá¹ení vy¾adováno pouze pro pøístup do backendu (zadní - admnistrátorské èásti) blogu. Mìjte na pamìti, ¾e pøihlá¹ení do administraèní sekce je mo¾né a¾ od verze Serendipity 0.9-beta2!');

?>
