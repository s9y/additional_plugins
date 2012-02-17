<?php # lang_cs.inc.php 1.4 2012-01-08 18:49:49 VladaAjgl $

/**
 *  @version 1.4
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/16
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/03/05
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/06/30
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/09/22
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/01/08
 */

@define('PLUGIN_FINDMORE_NAME', 'Zobrazuje odkazy jako Digg, Technorati, del.icio.us apod. vztažené k pøíspìvku.');
@define('PLUGIN_FINDMORE_DESCRIPTION', 'Mùžete vložit/odstranit další webové služby pomocí souboru šablony "plugin_findmore.tpl". Pamatujte, že pokud chcete ušetøit pár drahocených bodù za výkon blogu, mùžete stejného efektu dosáhnout také vložením HTML/JavaScript snipletu do souboru šablony entries.tpl namísto používání tohoto pluginu!');

@define('PLUGIN_FINDMORE_PATH_NAME', 'Relativní cesta k obrázkùm Findmore');
@define('PLUGIN_FINDMORE_PATH_DESC', 'Zadejte relativní cestu, kde máte uloženy obrázky pro jednotlivé webové služby. Obvykle je zde zadán adresáø pluginu!');

@define('PLUGIN_FINDMORE_DIGGCOUNT_DISPLAY_NAME', 'Zobrazit odkaz DiggCount');
@define('PLUGIN_FINDMORE_DIGGCOUNT_DISPLAY_DESC', 'Zobrazí odkaz DiggCount.');

@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_NAME', 'Umístìní odkazu DiggCount');
@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_DESC', 'Urèete, kde se má odkaz DiggCount nacházet.');

@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_BEFORE-ENTRY', 'Pøed pøíspìvkem');
@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_AFTER-ENTRY', 'Za pøíspìvkem');
@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_AFTER-FINDMORE', 'Za odkazy Findmore');

@define('PLUGIN_EVENT_FINDMORE_DISABLED_SERVICES', 'Vypnuté služby');
@define('PLUGIN_EVENT_FINDMORE_DISABLED_SERVICES_DESC', 'Vyberte, které služby se NEMAJÍ zobrazovat. Více hodnot vyberete klikáním se stisknutou klávesou Ctrl.');

@define('PLUGIN_FINDMORE_EXTENDEDONLY', 'Pouze rozšíøená textová èást');
@define('PLUGIN_FINDMORE_EXTENDEDONLY_BLAHBLAH', 'Zobrazovat záložky komunitních serverù pouze pøi zobrazení celého èlánku i s rozšíøenou textovou èástí?');

// Next lines were translated on 2011/03/05

@define('PLUGIN_EVENT_FINDMORE_LAZYLOAD', 'Povolit bezpeèné sledování (pro Facebookové "Líbí se mi")');
@define('PLUGIN_EVENT_FINDMORE_LAZYLOAD_DESC', 'Pokud je povoleno, všechny odkazy na cizí služby (jako Facebook) budou nataženy pouze když na nì uživatel klikne. To je dùležité zejména v zemích jako Nìmecko, kde sledování bez svolení uživatele je zakázáno. Vyžaduje javascript.');
@define('PLUGIN_EVENT_FINDMORE_LAZYLOAD_TEXT', 'Text pro bezpeènost sledování');
@define('PLUGIN_EVENT_FINDMORE_LAZYLOAD_TEXT_DESC', 'Zadejte text, který informuje uživatele, že má potvrdit sledování, aby bylo možné natáhnout služby tøetích stran (jak Facebook). Mùže obsahovat i HTML kód.');

// Next lines were translated on 2011/06/30

@define('PLUGIN_FINDMORE_SPREADLY_EMAILS', '(Spread.ly) Registrované E-Maily');
@define('PLUGIN_FINDMORE_SPREADLY_EMAILS_DESC', 'Pokud je zapnuta volba spreadly.com, mùžete asociovat/podepsat váš blog pomocí úètu spreadly.com. Pro toto podepsání zadejte emailovou adresu(adresy), kterou jste zaregistrovali na spreadly.com (více adres oddìlte novým øádkem, tedy každá adresa má vlastní øádek). Více informací najdete na <a href="http://spreadly.com">spreadly.com</a>!');
@define('PLUGIN_FINDMORE_SPREADLY', '(Spread.ly) Povolit rozšíøené, sociální funkce?');
@define('PLUGIN_FINDMORE_SPREADLY_DESC', 'Pokud je povoleno, do blogu je vložen iframe, který obsahuje a zobrazuje dodateèná data. Pokud je volba vypnuta, je zobrazeno statické tlaèítko (obrázek).');

// Next lines were translated on 2012/01/08
@define('PLUGIN_EVENT_FINDMORE_LAZYLOAD_TEXT_EXAMPLE', 'Falešné tlaèítko. Kliknìte na nìj, aby se natáhlo skuteèné tlaèítko.');