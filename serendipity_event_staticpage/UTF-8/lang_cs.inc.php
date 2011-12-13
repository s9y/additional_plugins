<?php # lang_cs.inc.php 1.4 2011-06-30 20:07:24 VladaAjgl $

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
@define('STATICPAGE_HEADLINE_BLAHBLAH',		'Tento text je uvedený jako nadpis statické stránky, zobrazený stejně jako nadpisy běžných příspěvků');
@define('STATICPAGE_TITLE',		'Statické stránky');
@define('STATICPAGE_TITLE_BLAHBLAH',		'Zobrazuje v blogu statické stránky se stejným designem jako mají běžné přspěvky. Přidá nové menu do adminstrátorského rozhraní.');
@define('CONTENT_BLAHBLAH',		'zde vepište obsah stránky');
@define('STATICPAGE_PERMALINK',		'Stálý odkaz');
@define('STATICPAGE_PERMALINK_BLAHBLAH',		'Definuje adresu stálého odkazu (permalink), pod kterou je stránka zobrazitelná. Musí být ve fromátu absolutní adresy a musí končit .htm nebo .html!');
@define('STATICPAGE_PAGETITLE',		'Zkrácená URL adresa (kvůli zpětné kompatibilitě, v novějších verzích ignorujte)');
@define('STATICPAGE_ARTICLEFORMAT',		'Formátovat jako článek?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH',		'Pokud je nastaveno na ANO, článek je automaticky formátován jako běžný příspěvek (barvy, okraje, apod.) (Standardně: ANO)');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE',		'Nadpis stránka v módu "Formátovat jako článek"');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH',		'Pokud pro statickou stránku použijete stejný formát jako pro běžné příspěvky, tento nadpis se zobrazí na místě, kde se u normálních příspěvků zobrazuje DATUM.');
@define('STATICPAGE_SELECT',		'Upravit nebo vytvořit statickou stránku - vyber v menu');
@define('STATICPAGE_PASSWORD_NOTICE',		'Tato stránka je zaheslována. Zadej prosím správné heslo:');
@define('STATICPAGE_PARENTPAGES_NAME',		'Rodičovská stránka');
@define('STATICPAGE_PARENTPAGE_DESC',		'Vyber nadřazenou - rodičovskou stránku');
@define('STATICPAGE_PARENTPAGE_PARENT',		'Toto je rodičovská stránka');
@define('STATICPAGE_AUTHORS_NAME',		'Jméno autora');
@define('STATICPAGE_AUTHORS_DESC',		'Tento autor je vlastníkem této statické stránky');
@define('STATICPAGE_FILENAME_NAME',		'Šablona (Smarty)');
@define('STATICPAGE_FILENAME_DESC',		'Vlož jméno souboru šablony, která má být použita k zobrazení stránky. Tento soubor může být umístěný buď v adresáři /plugins/serendipity_event_staticpage nebo v adresáři Vaší šablony.');
@define('STATICPAGE_SHOWCHILDPAGES_NAME',		'Zobraz děti (podřazené stránky)');
@define('STATICPAGE_SHOWCHILDPAGES_DESC',		'Zobrazí seznam odkazů na všechny podřazené stránky = děti, které mají tuto stránku nastavenou jako rodiče.');
@define('STATICPAGE_PRECONTENT_NAME',		'Úvod');
@define('STATICPAGE_PRECONTENT_DESC',		'Tento blok se zobrazí před seznamem podřazených článek.');
@define('STATICPAGE_CANNOTDELETE_MSG',		'Není možné vymazat tuto stránku. V databázi byly nalezeny podřazené stránky. Nejdříve musíte smazat je.');
@define('STATICPAGE_IS_STARTPAGE',		'Udělej z této strany hlavní stranu Serendipity');
@define('STATICPAGE_IS_STARTPAGE_DESC',		'Pokud je nastaveno, tato strana se zobrazí místo standardní úvodní strany Serendipity. Lze zadat pouze jednu stránku jako úvodní! Pokud pak chcete zobrazit původní úvodní stránku, použijte odkaz "index.php?frontpage". Pokud chcete použít tuto vlastnost modulu statické stránky, musíte ho v seznamu pluginů přemístit před všechny ostatní pluginy zobrazující statické stránky (jako hlasování nebo kniha hostů).');
@define('STATICPAGE_TOP',		'Hlavní stránka blogu');
@define('STATICPAGE_NEXT',		'Další');
@define('STATICPAGE_PREV',		'Předchozí');
@define('STATICPAGE_LINKNAME',		'Upravit');

@define('STATICPAGE_ARTICLETYPE',		'Typ stránky');
@define('STATICPAGE_ARTICLETYPE_DESC',		'Vyberte typ této statické stránky.');

@define('STATICPAGE_CATEGORY_PAGEORDER',		'Pořadí stránek');
@define('STATICPAGE_CATEGORY_PAGES',		'Úprava stránek');
@define('STATICPAGE_CATEGORY_PAGETYPES',		'Typy stránek');
@define('STATICPAGE_CATEGORY_PAGEADD',		'Ostatní pluginy');

@define('PAGETYPES_SELECT',		'Vyber typ stránky k úpravám');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION',		'Název:');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC',		'Název typu stránky.');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE',		'Šablona:');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC',		'Jméno souboru šablony. Soubor může být umístěn v adresáři pluginy "statické stránky" nebo v adresáři Vaší šablony.');
@define('STATICPAGE_ARTICLETYPE_IMAGE',		'Cesta k obrázku:');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC',		'Zadejte URL adresu obrázku.');

@define('STATICPAGE_SHOWNAVI',		'Vložit navigaci');
@define('STATICPAGE_SHOWNAVI_DESC',		'Zobrazí navigační lištu s odkazy na další statické stránky v této statické stránce.');
@define('STATICPAGE_SHOWONNAVI',		'Vložit postranní navigaci');
@define('STATICPAGE_SHOWONNAVI_DESC',		'Zobrazí tuto stránku na seznamu statických stránek v postranním panelu.');

@define('STATICPAGE_SHOWNAVI_DEFAULT',		'Vložit navigaci');
@define('STATICPAGE_DEFAULT_DESC',		'Standardní nastavení pro nové stránky.');
@define('STATICPAGE_SHOWONNAVI_DEFAULT',		'Zobrazit stránku v postranní navigaci');
@define('STATICPAGE_SHOWMARKUP_DEFAULT',		'Použít značkování');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT',		'Formátovat jako běžný článek');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT',		'Zobrazit děti (podřazené stránky)');

@define('STATICPAGE_PAGEORDER_DESC',		'Tady můžete změnit pořadí statických stránek.');
@define('STATICPAGE_PAGEADD_DESC',		'Vyberte pluginy, na které chcete zobrazi odkaz v navigaci statických stránek.');
@define('STATICPAGE_PAGEADD_PLUGINS',		'Následující pluginy mohou být vloženy do navigace statických stránek v postranním sloupci.');

@define('STATICPAGE_PUBLISHSTATUS',		'Publikovat');
@define('STATICPAGE_PUBLISHSTATUS_DESC',		'Typ uložení stránky - zveřejnit/koncept');

@define('STATICPAGE_SHOWTEXTORHEADLINE_NAME',		'Zobrazit v navigaci text "předchozí/další" nebo názvy předchozí a další stránky?');
@define('STATICPAGE_SHOWTEXTORHEADLINE_TEXT',		'Předchozí/Další');
@define('STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE',		'Názvy stránek');

@define('STATICPAGE_LANGUAGE',		'Jazyk');
@define('STATICPAGE_LANGUAGE_DESC',		'Vyberte jazyk této stránky');

@define('STATICPAGE_PLUGINS_INSTALLED',		'Plugin je nainstalován');
@define('STATICPAGE_PLUGIN_AVAILABLE',		'Plugin je k dispozici, ale není nainstalován.');
@define('STATICPAGE_PLUGIN_NOTAVAILABLE',		'Plugin není k dispozici');

@define('STATICPAGE_SEARCHRESULTS',		'Počet nalezených statických stránek - %d:');

@define('LANG_ALL',		'Všechny jazyky');
@define('LANG_EN',		'Angličtina');
@define('LANG_DE',		'Němčina');
@define('LANG_DA',		'Dánština');
@define('LANG_ES',		'Španělština');
@define('LANG_FR',		'Francouzština');
@define('LANG_FI',		'Finština');
@define('LANG_CS',		'Čeština (Win-1250)');
@define('LANG_CZ',		'Čeština (ISO-8859-2)');
@define('LANG_NL',		'Holandština');
@define('LANG_IS',		'Islandština');
@define('LANG_PT',		'Brazilská portugalština');
@define('LANG_BG',		'Bulharština');
@define('LANG_NO',		'Norština');
@define('LANG_RO',		'Rumunština');
@define('LANG_IT',		'Italština');
@define('LANG_RU',		'Ruština');
@define('LANG_FA',		'Perština');
@define('LANG_TW',		'Tradiční Čínština (Big5)');
@define('LANG_TN',		'Tradiční Čínština (UTF-8)');
@define('LANG_ZH',		'Zjednodušená Čínština (GB2312)');
@define('LANG_CN',		'Zjednodušená Čínština (UTF-8)');
@define('LANG_JA',		'Japonština');
@define('LANG_KO',		'Korejština');

@define('STATICPAGE_STATUS',		'Stav');

//
//  serendipity_plugin_staticpage.php
//

@define('PLUGIN_STATICPAGELIST_NAME',		'Seznam statických stránek');
@define('PLUGIN_STATICPAGELIST_NAME_DESC',		'Tento plugin zobrazuje nastavitelný seznam stálých (statických) stránek.');
@define('PLUGIN_STATICPAGELIST_TITLE',		'Nadpis');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC',		'Nadpis bloku v postranním panelu:');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT',		'Stálé stránky');
@define('PLUGIN_STATICPAGELIST_LIMIT',		'Počet stránek k zobrazení');
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC',		'Zadej maximální počet stránek, které se zobrazí najednou. 0 znamená bez omezení.');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME',		'Zobrazit odkaz na hlavní srtánku');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC',		'Zobrazí odkaz na hlavní stránku');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME',		'Hlavní stránka');
@define('PLUGIN_LINKS_IMGDIR',		'Adresář s obrázky');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH',		'Zadej URL adresu adresáře, kde se nachází obrázky zobrazené ve stromu. V tomto adresáři se musí nacházet podadresář "img".');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_NAME',		'Ikony nebo čistý text');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_DESC',		'Zobrazit menu jako strom s ikonami nebo jako čistý text');
@define('PLUGIN_STATICPAGELIST_ICON',		'Strom - ikony');
@define('PLUGIN_STATICPAGELIST_TEXT',		'Čistý text');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY',		'Zobrazit pouze rodičovské stránky?');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY_DESC',		'Pokud je zaponuto, jsou zobrazeny pouze rodičovské stránky. Jinak budou zobrazeny i podřazené stránky.');
@define('PLUGIN_STATICPAGELIST_IMG_NAME',		'Povolit grafiku pro strom');

@define('STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRIES',		'Změněna URL adresa přesunutého adresáře v %s statických stránkách.');
@define('STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRY',		'V jiných databázích než je MySQL není možné iterativní prohledávání všech statických stránek a nahrazení názvů starých adresářů názvy nových adresářů. Budete muset provést tuto operaci ručně. Stále můžete přesunout starý adresář zpět tam, kde byl původně, pokud se vám do ručních změn nechce.');

@define('STATICPAGE_QUICKSEARCH_DESC',		'Pokud je povoleno, rychlé vyhledávání prohledá také statické stránky.');

@define('STATICPAGE_CATEGORYPAGE',		'Příbuzná statická stránka');
@define('STATICPAGE_RELATED_CATEGORY',		'Příbuzná kategorie');
@define('STATICPAGE_RELATED_CATEGORY_DESCRIPTION',		'Zobrazte příspěvky z této kategorie a nebo zobrazte odkazy na ně ve statické stránce. Pro úpravu vzhledu seznamu příspěvků upravte šablonu "plugin_staticpage_related_category.tpl".');

@define('STATICPAGE_ARTICLE_OVERVIEW',		'Přehled článků:');
@define('STATICPAGE_NEW_HEADLINES',		'Nejnovější články:');

@define('STATICPAGE_TEMPLATE',		'Šablona pro pozadí');
@define('STATICPAGE_TEMPLATE_INTERNAL',		'Všechna pole');
@define('STATICPAGE_TEMPLATE_EXTERNAL',		'Jednoduchá šablona');

@define('STATICPAGE_SECTION_META',		'Metadata');
@define('STATICPAGE_SECTION_BASIC',		'Základní obsah');
@define('STATICPAGE_SECTION_OPT',		'Volby');
@define('STATICPAGE_SECTION_STRUCT',		'Struktura');

// Next lines were translated on 2011/03/09

@define('STATICPAGE_IS_404_PAGE',		'Nastavit tuto stránku jako chybovou stránku 404');
@define('STATICPAGE_IS_404_PAGE_DESC',		'Místo vytváření zvláštního chybového dokumentu můžete nastavit tuto stránku jako chybovou stránku 404. Webserver musí toto nastavení umožňovat!');

// Next lines were translated on 2011/06/30
@define('PLUGIN_STATICPAGELIST_SMARTIFY',		'Postranní seznam pomocí Smarty');
@define('PLUGIN_STATICPAGELIST_SMARTIFY_BLAHBLAH',		'Použijte šablonu Smarty: "plugin_staticpage_sidebar.tpl" pro zadání výstupu do postranního sloupce (umožňuje zkrátit délku pomocí funkcí Smarty).');