<?php # lang_cz.inc.php 1.4 2011-06-30 20:07:23 VladaAjgl $

/**
 *  @version 1.4
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Translated on 2007/11/30
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/15
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/03/09
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/06/30
 */

//
//  serendipity_event_staticpage.php
//

@define('STATICPAGE_HEADLINE',		'Nadpis');
@define('STATICPAGE_HEADLINE_BLAHBLAH',		'Tento text je uvedený jako nadpis statické stránky, zobrazený stejnì jako nadpisy bì¾ných pøíspìvkù');
@define('STATICPAGE_TITLE',		'Statické stránky');
@define('STATICPAGE_TITLE_BLAHBLAH',		'Zobrazuje v blogu statické stránky se stejným designem jako mají bì¾né pøspìvky. Pøidá nové menu do adminstrátorského rozhraní.');
@define('CONTENT_BLAHBLAH',		'zde vepi¹te obsah stránky');
@define('STATICPAGE_PERMALINK',		'Stálý odkaz');
@define('STATICPAGE_PERMALINK_BLAHBLAH',		'Definuje adresu stálého odkazu (permalink), pod kterou je stránka zobrazitelná. Musí být ve fromátu absolutní adresy a musí konèit .htm nebo .html!');
@define('STATICPAGE_PAGETITLE',		'Zkrácená URL adresa (kvùli zpìtné kompatibilitì, v novìj¹ích verzích ignorujte)');
@define('STATICPAGE_ARTICLEFORMAT',		'Formátovat jako èlánek?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH',		'Pokud je nastaveno na ANO, èlánek je automaticky formátován jako bì¾ný pøíspìvek (barvy, okraje, apod.) (Standardnì: ANO)');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE',		'Nadpis stránka v módu "Formátovat jako èlánek"');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH',		'Pokud pro statickou stránku pou¾ijete stejný formát jako pro bì¾né pøíspìvky, tento nadpis se zobrazí na místì, kde se u normálních pøíspìvkù zobrazuje DATUM.');
@define('STATICPAGE_SELECT',		'Upravit nebo vytvoøit statickou stránku - vyber v menu');
@define('STATICPAGE_PASSWORD_NOTICE',		'Tato stránka je zaheslována. Zadej prosím správné heslo:');
@define('STATICPAGE_PARENTPAGES_NAME',		'Rodièovská stránka');
@define('STATICPAGE_PARENTPAGE_DESC',		'Vyber nadøazenou - rodièovskou stránku');
@define('STATICPAGE_PARENTPAGE_PARENT',		'Toto je rodièovská stránka');
@define('STATICPAGE_AUTHORS_NAME',		'Jméno autora');
@define('STATICPAGE_AUTHORS_DESC',		'Tento autor je vlastníkem této statické stránky');
@define('STATICPAGE_FILENAME_NAME',		'©ablona (Smarty)');
@define('STATICPAGE_FILENAME_DESC',		'Vlo¾ jméno souboru ¹ablony, která má být pou¾ita k zobrazení stránky. Tento soubor mù¾e být umístìný buï v adresáøi /plugins/serendipity_event_staticpage nebo v adresáøi Va¹í ¹ablony.');
@define('STATICPAGE_SHOWCHILDPAGES_NAME',		'Zobraz dìti (podøazené stránky)');
@define('STATICPAGE_SHOWCHILDPAGES_DESC',		'Zobrazí seznam odkazù na v¹echny podøazené stránky = dìti, které mají tuto stránku nastavenou jako rodièe.');
@define('STATICPAGE_PRECONTENT_NAME',		'Úvod');
@define('STATICPAGE_PRECONTENT_DESC',		'Tento blok se zobrazí pøed seznamem podøazených èlánek.');
@define('STATICPAGE_CANNOTDELETE_MSG',		'Není mo¾né vymazat tuto stránku. V databázi byly nalezeny podøazené stránky. Nejdøíve musíte smazat je.');
@define('STATICPAGE_IS_STARTPAGE',		'Udìlej z této strany hlavní stranu Serendipity');
@define('STATICPAGE_IS_STARTPAGE_DESC',		'Pokud je nastaveno, tato strana se zobrazí místo standardní úvodní strany Serendipity. Lze zadat pouze jednu stránku jako úvodní! Pokud pak chcete zobrazit pùvodní úvodní stránku, pou¾ijte odkaz "index.php?frontpage". Pokud chcete pou¾ít tuto vlastnost modulu statické stránky, musíte ho v seznamu pluginù pøemístit pøed v¹echny ostatní pluginy zobrazující statické stránky (jako hlasování nebo kniha hostù).');
@define('STATICPAGE_TOP',		'Hlavní stránka blogu');
@define('STATICPAGE_NEXT',		'Dal¹í');
@define('STATICPAGE_PREV',		'Pøedchozí');
@define('STATICPAGE_LINKNAME',		'Upravit');

@define('STATICPAGE_ARTICLETYPE',		'Typ stránky');
@define('STATICPAGE_ARTICLETYPE_DESC',		'Vyberte typ této statické stránky.');

@define('STATICPAGE_CATEGORY_PAGEORDER',		'Poøadí stránek');
@define('STATICPAGE_CATEGORY_PAGES',		'Úprava stránek');
@define('STATICPAGE_CATEGORY_PAGETYPES',		'Typy stránek');
@define('STATICPAGE_CATEGORY_PAGEADD',		'Ostatní pluginy');

@define('PAGETYPES_SELECT',		'Vyber typ stránky k úpravám');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION',		'Název:');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC',		'Název typu stránky.');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE',		'©ablona:');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC',		'Jméno souboru ¹ablony. Soubor mù¾e být umístìn v adresáøi pluginy "statické stránky" nebo v adresáøi Va¹í ¹ablony.');
@define('STATICPAGE_ARTICLETYPE_IMAGE',		'Cesta k obrázku:');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC',		'Zadejte URL adresu obrázku.');

@define('STATICPAGE_SHOWNAVI',		'Vlo¾it navigaci');
@define('STATICPAGE_SHOWNAVI_DESC',		'Zobrazí navigaèní li¹tu s odkazy na dal¹í statické stránky v této statické stránce.');
@define('STATICPAGE_SHOWONNAVI',		'Vlo¾it postranní navigaci');
@define('STATICPAGE_SHOWONNAVI_DESC',		'Zobrazí tuto stránku na seznamu statických stránek v postranním panelu.');

@define('STATICPAGE_SHOWNAVI_DEFAULT',		'Vlo¾it navigaci');
@define('STATICPAGE_DEFAULT_DESC',		'Standardní nastavení pro nové stránky.');
@define('STATICPAGE_SHOWONNAVI_DEFAULT',		'Zobrazit stránku v postranní navigaci');
@define('STATICPAGE_SHOWMARKUP_DEFAULT',		'Pou¾ít znaèkování');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT',		'Formátovat jako bì¾ný èlánek');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT',		'Zobrazit dìti (podøazené stránky)');

@define('STATICPAGE_PAGEORDER_DESC',		'Tady mù¾ete zmìnit poøadí statických stránek.');
@define('STATICPAGE_PAGEADD_DESC',		'Vyberte pluginy, na které chcete zobrazi odkaz v navigaci statických stránek.');
@define('STATICPAGE_PAGEADD_PLUGINS',		'Následující pluginy mohou být vlo¾eny do navigace statických stránek v postranním sloupci.');

@define('STATICPAGE_PUBLISHSTATUS',		'Publikovat');
@define('STATICPAGE_PUBLISHSTATUS_DESC',		'Typ ulo¾ení stránky - zveøejnit/koncept');

@define('STATICPAGE_SHOWTEXTORHEADLINE_NAME',		'Zobrazit v navigaci text "pøedchozí/dal¹í" nebo názvy pøedchozí a dal¹í stránky?');
@define('STATICPAGE_SHOWTEXTORHEADLINE_TEXT',		'Pøedchozí/Dal¹í');
@define('STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE',		'Názvy stránek');

@define('STATICPAGE_LANGUAGE',		'Jazyk');
@define('STATICPAGE_LANGUAGE_DESC',		'Vyberte jazyk této stránky');

@define('STATICPAGE_PLUGINS_INSTALLED',		'Plugin je nainstalován');
@define('STATICPAGE_PLUGIN_AVAILABLE',		'Plugin je k dispozici, ale není nainstalován.');
@define('STATICPAGE_PLUGIN_NOTAVAILABLE',		'Plugin není k dispozici');

@define('STATICPAGE_SEARCHRESULTS',		'Poèet nalezených statických stránek - %d:');

@define('LANG_ALL',		'V¹echny jazyky');
@define('LANG_EN',		'Angliètina');
@define('LANG_DE',		'Nìmèina');
@define('LANG_DA',		'Dán¹tina');
@define('LANG_ES',		'©panìl¹tina');
@define('LANG_FR',		'Francouz¹tina');
@define('LANG_FI',		'Fin¹tina');
@define('LANG_CS',		'Èe¹tina (Win-1250)');
@define('LANG_CZ',		'Èe¹tina (ISO-8859-2)');
@define('LANG_NL',		'Holand¹tina');
@define('LANG_IS',		'Island¹tina');
@define('LANG_PT',		'Brazilská portugal¹tina');
@define('LANG_BG',		'Bulhar¹tina');
@define('LANG_NO',		'Nor¹tina');
@define('LANG_RO',		'Rumun¹tina');
@define('LANG_IT',		'Ital¹tina');
@define('LANG_RU',		'Ru¹tina');
@define('LANG_FA',		'Per¹tina');
@define('LANG_TW',		'Tradièní Èín¹tina (Big5)');
@define('LANG_TN',		'Tradièní Èín¹tina (UTF-8)');
@define('LANG_ZH',		'Zjednodu¹ená Èín¹tina (GB2312)');
@define('LANG_CN',		'Zjednodu¹ená Èín¹tina (UTF-8)');
@define('LANG_JA',		'Japon¹tina');
@define('LANG_KO',		'Korej¹tina');

@define('STATICPAGE_STATUS',		'Stav');

//
//  serendipity_plugin_staticpage.php
//

@define('PLUGIN_STATICPAGELIST_NAME',		'Seznam statických stránek');
@define('PLUGIN_STATICPAGELIST_NAME_DESC',		'Tento plugin zobrazuje nastavitelný seznam stálých (statických) stránek.');
@define('PLUGIN_STATICPAGELIST_TITLE',		'Nadpis');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC',		'Nadpis bloku v postranním panelu:');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT',		'Stálé stránky');
@define('PLUGIN_STATICPAGELIST_LIMIT',		'Poèet stránek k zobrazení');
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC',		'Zadej maximální poèet stránek, které se zobrazí najednou. 0 znamená bez omezení.');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME',		'Zobrazit odkaz na hlavní srtánku');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC',		'Zobrazí odkaz na hlavní stránku');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME',		'Hlavní stránka');
@define('PLUGIN_LINKS_IMGDIR',		'Adresáø s obrázky');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH',		'Zadej URL adresu adresáøe, kde se nachází obrázky zobrazené ve stromu. V tomto adresáøi se musí nacházet podadresáø "img".');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_NAME',		'Ikony nebo èistý text');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_DESC',		'Zobrazit menu jako strom s ikonami nebo jako èistý text');
@define('PLUGIN_STATICPAGELIST_ICON',		'Strom - ikony');
@define('PLUGIN_STATICPAGELIST_TEXT',		'Èistý text');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY',		'Zobrazit pouze rodièovské stránky?');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY_DESC',		'Pokud je zaponuto, jsou zobrazeny pouze rodièovské stránky. Jinak budou zobrazeny i podøazené stránky.');
@define('PLUGIN_STATICPAGELIST_IMG_NAME',		'Povolit grafiku pro strom');

@define('STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRIES',		'Zmìnìna URL adresa pøesunutého adresáøe v %s statických stránkách.');
@define('STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRY',		'V jiných databázích ne¾ je MySQL není mo¾né iterativní prohledávání v¹ech statických stránek a nahrazení názvù starých adresáøù názvy nových adresáøù. Budete muset provést tuto operaci ruènì. Stále mù¾ete pøesunout starý adresáø zpìt tam, kde byl pùvodnì, pokud se vám do ruèních zmìn nechce.');

@define('STATICPAGE_QUICKSEARCH_DESC',		'Pokud je povoleno, rychlé vyhledávání prohledá také statické stránky.');

@define('STATICPAGE_CATEGORYPAGE',		'Pøíbuzná statická stránka');
@define('STATICPAGE_RELATED_CATEGORY',		'Pøíbuzná kategorie');
@define('STATICPAGE_RELATED_CATEGORY_DESCRIPTION',		'Zobrazte pøíspìvky z této kategorie a nebo zobrazte odkazy na nì ve statické stránce. Pro úpravu vzhledu seznamu pøíspìvkù upravte ¹ablonu "plugin_staticpage_related_category.tpl".');

@define('STATICPAGE_ARTICLE_OVERVIEW',		'Pøehled èlánkù:');
@define('STATICPAGE_NEW_HEADLINES',		'Nejnovìj¹í èlánky:');

@define('STATICPAGE_TEMPLATE',		'©ablona pro pozadí');
@define('STATICPAGE_TEMPLATE_INTERNAL',		'V¹echna pole');
@define('STATICPAGE_TEMPLATE_EXTERNAL',		'Jednoduchá ¹ablona');

@define('STATICPAGE_SECTION_META',		'Metadata');
@define('STATICPAGE_SECTION_BASIC',		'Základní obsah');
@define('STATICPAGE_SECTION_OPT',		'Volby');
@define('STATICPAGE_SECTION_STRUCT',		'Struktura');

// Next lines were translated on 2011/03/09

@define('STATICPAGE_IS_404_PAGE',		'Nastavit tuto stránku jako chybovou stránku 404');
@define('STATICPAGE_IS_404_PAGE_DESC',		'Místo vytváøení zvlá¹tního chybového dokumentu mù¾ete nastavit tuto stránku jako chybovou stránku 404. Webserver musí toto nastavení umo¾òovat!');

// Next lines were translated on 2011/06/30
@define('PLUGIN_STATICPAGELIST_SMARTIFY',		'Postranní seznam pomocí Smarty');
@define('PLUGIN_STATICPAGELIST_SMARTIFY_BLAHBLAH',		'Pou¾ijte ¹ablonu Smarty: "plugin_staticpage_sidebar.tpl" pro zadání výstupu do postranního sloupce (umo¾òuje zkrátit délku pomocí funkcí Smarty).');