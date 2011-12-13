<?php # lang_cs.inc.php 1.3 2011-09-22 15:16:25 VladaAjgl $

/**
 *  @version 1.3
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/16
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/03/05
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/06/30
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/09/22
 */

@define('PLUGIN_FINDMORE_NAME', 'Zobrazuje odkazy jako Digg, Technorati, del.icio.us apod. vztažené k příspěvku.');
@define('PLUGIN_FINDMORE_DESCRIPTION', 'Můžete vložit/odstranit další webové služby pomocí souboru šablony "plugin_findmore.tpl". Pamatujte, že pokud chcete ušetřit pár drahocených bodů za výkon blogu, můžete stejného efektu dosáhnout také vložením HTML/JavaScript snipletu do souboru šablony entries.tpl namísto používání tohoto pluginu!');

@define('PLUGIN_FINDMORE_PATH_NAME', 'Relativní cesta k obrázkům Findmore');
@define('PLUGIN_FINDMORE_PATH_DESC', 'Zadejte relativní cestu, kde máte uloženy obrázky pro jednotlivé webové služby. Obvykle je zde zadán adresář pluginu!');

@define('PLUGIN_FINDMORE_DIGGCOUNT_DISPLAY_NAME', 'Zobrazit odkaz DiggCount');
@define('PLUGIN_FINDMORE_DIGGCOUNT_DISPLAY_DESC', 'Zobrazí odkaz DiggCount.');

@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_NAME', 'Umístění odkazu DiggCount');
@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_DESC', 'Určete, kde se má odkaz DiggCount nacházet.');

@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_BEFORE-ENTRY', 'Před příspěvkem');
@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_AFTER-ENTRY', 'Za příspěvkem');
@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_AFTER-FINDMORE', 'Za odkazy Findmore');

@define('PLUGIN_EVENT_FINDMORE_DISABLED_SERVICES', 'Vypnuté služby');
@define('PLUGIN_EVENT_FINDMORE_DISABLED_SERVICES_DESC', 'Vyberte, které služby se NEMAJÍ zobrazovat. Více hodnot vyberete klikáním se stisknutou klávesou Ctrl.');

@define('PLUGIN_FINDMORE_EXTENDEDONLY', 'Pouze rozšířená textová část');
@define('PLUGIN_FINDMORE_EXTENDEDONLY_BLAHBLAH', 'Zobrazovat záložky komunitních serverů pouze při zobrazení celého článku i s rozšířenou textovou částí?');

// Next lines were translated on 2011/03/05

@define('PLUGIN_EVENT_FINDMORE_LAZYLOAD', 'Povolit bezpečné sledování (pro Facebookové "Líbí se mi")');
@define('PLUGIN_EVENT_FINDMORE_LAZYLOAD_DESC', 'Pokud je povoleno, všechny odkazy na cizí služby (jako Facebook) budou nataženy pouze když na ně uživatel klikne. To je důležité zejména v zemích jako Německo, kde sledování bez svolení uživatele je zakázáno. Vyžaduje javascript.');
@define('PLUGIN_EVENT_FINDMORE_LAZYLOAD_TEXT', 'Text pro bezpečnost sledování');
@define('PLUGIN_EVENT_FINDMORE_LAZYLOAD_TEXT_DESC', 'Zadejte text, který informuje uživatele, že má potvrdit sledování, aby bylo možné natáhnout služby třetích stran (jak Facebook). Může obsahovat i HTML kód.');

// Next lines were translated on 2011/06/30

@define('PLUGIN_FINDMORE_SPREADLY_EMAILS', '(Spread.ly) Registrované E-Maily');
@define('PLUGIN_FINDMORE_SPREADLY_EMAILS_DESC', 'Pokud je zapnuta volba spreadly.com, můžete asociovat/podepsat váš blog pomocí účtu spreadly.com. Pro toto podepsání zadejte emailovou adresu(adresy), kterou jste zaregistrovali na spreadly.com (více adres oddělte novým řádkem, tedy každá adresa má vlastní řádek). Více informací najdete na <a href="http://spreadly.com">spreadly.com</a>!');
@define('PLUGIN_FINDMORE_SPREADLY', '(Spread.ly) Povolit rozšířené, sociální funkce?');
@define('PLUGIN_FINDMORE_SPREADLY_DESC', 'Pokud je povoleno, do blogu je vložen iframe, který obsahuje a zobrazuje dodatečná data. Pokud je volba vypnuta, je zobrazeno statické tlačítko (obrázek).');