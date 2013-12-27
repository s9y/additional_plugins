/<?php

/**
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

@define('PLUGIN_FINDMORE_NAME', 'Zobrazuje odkazy jako Digg, Technorati, del.icio.us apod. vzta¾ené k pøíspìvku.');
@define('PLUGIN_FINDMORE_DESCRIPTION', 'Mù¾ete vlo¾it/odstranit dal¹í webové slu¾by pomocí souboru ¹ablony "plugin_findmore.tpl". Pamatujte, ¾e pokud chcete u¹etøit pár drahocených bodù za výkon blogu, mù¾ete stejného efektu dosáhnout také vlo¾ením HTML/JavaScript snipletu do souboru ¹ablony entries.tpl namísto pou¾ívání tohoto pluginu!');

@define('PLUGIN_FINDMORE_PATH_NAME', 'Relativní cesta k obrázkùm Findmore');
@define('PLUGIN_FINDMORE_PATH_DESC', 'Zadejte relativní cestu, kde máte ulo¾eny obrázky pro jednotlivé webové slu¾by. Obvykle je zde zadán adresáø pluginu!');

@define('PLUGIN_FINDMORE_DIGGCOUNT_DISPLAY_NAME', 'Zobrazit odkaz DiggCount');
@define('PLUGIN_FINDMORE_DIGGCOUNT_DISPLAY_DESC', 'Zobrazí odkaz DiggCount.');

@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_NAME', 'Umístìní odkazu DiggCount');
@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_DESC', 'Urèete, kde se má odkaz DiggCount nacházet.');

@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_BEFORE-ENTRY', 'Pøed pøíspìvkem');
@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_AFTER-ENTRY', 'Za pøíspìvkem');
@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_AFTER-FINDMORE', 'Za odkazy Findmore');

@define('PLUGIN_EVENT_FINDMORE_DISABLED_SERVICES', 'Vypnuté slu¾by');
@define('PLUGIN_EVENT_FINDMORE_DISABLED_SERVICES_DESC', 'Vyberte, které slu¾by se NEMAJÍ zobrazovat. Více hodnot vyberete klikáním se stisknutou klávesou Ctrl.');

@define('PLUGIN_FINDMORE_EXTENDEDONLY', 'Pouze roz¹íøená textová èást');
@define('PLUGIN_FINDMORE_EXTENDEDONLY_BLAHBLAH', 'Zobrazovat zálo¾ky komunitních serverù pouze pøi zobrazení celého èlánku i s roz¹íøenou textovou èástí?');

// Next lines were translated on 2011/03/05

@define('PLUGIN_EVENT_FINDMORE_LAZYLOAD', 'Povolit bezpeèné sledování (pro Facebookové "Líbí se mi")');
@define('PLUGIN_EVENT_FINDMORE_LAZYLOAD_DESC', 'Pokud je povoleno, v¹echny odkazy na cizí slu¾by (jako Facebook) budou nata¾eny pouze kdy¾ na nì u¾ivatel klikne. To je dùle¾ité zejména v zemích jako Nìmecko, kde sledování bez svolení u¾ivatele je zakázáno. Vy¾aduje javascript.');
@define('PLUGIN_EVENT_FINDMORE_LAZYLOAD_TEXT', 'Text pro bezpeènost sledování');
@define('PLUGIN_EVENT_FINDMORE_LAZYLOAD_TEXT_DESC', 'Zadejte text, který informuje u¾ivatele, ¾e má potvrdit sledování, aby bylo mo¾né natáhnout slu¾by tøetích stran (jak Facebook). Mù¾e obsahovat i HTML kód.');

// Next lines were translated on 2011/06/30

@define('PLUGIN_FINDMORE_SPREADLY_EMAILS', '(Spread.ly) Registrované E-Maily');
@define('PLUGIN_FINDMORE_SPREADLY_EMAILS_DESC', 'Pokud je zapnuta volba spreadly.com, mù¾ete asociovat/podepsat vá¹ blog pomocí úètu spreadly.com. Pro toto podepsání zadejte emailovou adresu(adresy), kterou jste zaregistrovali na spreadly.com (více adres oddìlte novým øádkem, tedy ka¾dá adresa má vlastní øádek). Více informací najdete na <a href="http://spreadly.com">spreadly.com</a>!');
@define('PLUGIN_FINDMORE_SPREADLY', '(Spread.ly) Povolit roz¹íøené, sociální funkce?');
@define('PLUGIN_FINDMORE_SPREADLY_DESC', 'Pokud je povoleno, do blogu je vlo¾en iframe, který obsahuje a zobrazuje dodateèná data. Pokud je volba vypnuta, je zobrazeno statické tlaèítko (obrázek).');

// Next lines were translated on 2012/01/08
@define('PLUGIN_EVENT_FINDMORE_LAZYLOAD_TEXT_EXAMPLE', 'Fale¹né tlaèítko. Kliknìte na nìj, aby se natáhlo skuteèné tlaèítko.');