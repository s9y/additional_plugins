<?php # lang_cz.inc.php 1.3 2009-02-23 17:21:29 VladaAjgl $

/**
 *  @version 1.3
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Translated on 2007/11/30
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/15
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/23
 */

//
//  serendipity_event_linklist.php
//
@define('PLUGIN_LINKLIST_TITLE',		'Link List');
@define('PLUGIN_LINKLIST_DESC',		'Správce odkazů (linků) - V bočním panelu zobrazuje vaše oblíbené odkazy.');
@define('PLUGIN_LINKLIST_LINK',		'Odkaz (Link)');
@define('PLUGIN_LINKLIST_LINK_NAME',		'Jméno');
@define('PLUGIN_LINKLIST_ADMINLINK',		'Odkazy (LinkList)');
@define('PLUGIN_LINKLIST_ORDER',		'Seřaď odkazy podle:');
@define('PLUGIN_LINKLIST_ORDER_DESC',		'Vyber kritérium, podle kterého se mají řadit odkazy při zobrazování.');
@define('PLUGIN_LINKLIST_ORDER_NUM_ORDER',		'Pořadí zadané uživatelem (tebou)');
@define('PLUGIN_LINKLIST_ORDER_DATE_ACS',		'Datum (Od nejstaršího po nejnovější)');
@define('PLUGIN_LINKLIST_ORDER_DATE_DESC',		'Datum (Od nejnovějšího po nejstarší)');
@define('PLUGIN_LINKLIST_ORDER_CATEGORY',		'Kategorie');
@define('PLUGIN_LINKLIST_ORDER_ALPHA',		'Abecedně');
@define('PLUGIN_LINKLIST_LINKS',		'Správa odkazů');
@define('PLUGIN_LINKLIST_NOLINKS',		'Žádné odkazy nejsou zadány');
@define('PLUGIN_LINKLIST_CATEGORY',		'Použít kategorie');
@define('PLUGIN_LINKLIST_CATEGORYDESC',		'Použít kategorie při seskupování odkazů.');
@define('PLUGIN_LINKLIST_ADDLINK',		'Přidat odkaz');
@define('PLUGIN_LINKLIST_LINK_EXAMPLE',		'Příklad správného odkazu: http://www.s9y.org nebo http://www.s9y.org/forums/');
@define('PLUGIN_LINKLIST_EDITLINK',		'Upravit odkaz');
@define('PLUGIN_LINKLIST_LINKDESC',		'Popis odkazu');
@define('PLUGIN_LINKLIST_CATEGORY_NAME',		'Systém kategorií:');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DESC',		'Můžete si vybrat, který systém kategorií chcete použít. Jestli stejné kategorie, jako u příspěvků, nebo nezávislé kategorie definované v tomto pluginu.');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_CUSTOM',		'Vlastní');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DEFAULT',		'Standardní - z blogu');
@define('PLUGIN_LINKLIST_ADD_CAT',		'Přidat kategorii');
@define('PLUGIN_LINKLIST_CAT_NAME',		'Název kategorie');
@define('PLUGIN_LINKLIST_PARENT_CATEGORY',		'Nadřazená (rodičovská) kategorie');
@define('PLUGIN_LINKLIST_ADMINCAT',		'Správa kategorií');
@define('PLUGIN_LINKLIST_CACHE_NAME',		'Cachovat postranní sloupec');
@define('PLUGIN_LINKLIST_CACHE_DESC',		'Cachování postranního sloupce zvyšuje rychlost stránek. Cache je obnovována pouze při vkládání odkazů přes administrativní rozhraní. Není obnovována při ručním zadávání pomocí xml.');
@define('PLUGIN_LINKLIST_ENABLED_NAME',		'Povolit');
@define('PLUGIN_LINKLIST_ENABLED_DESC',		'Povolit tento zásuvný modul.');
@define('PLUGIN_LINKLIST_DELETE_WARN',		'Pokud smažete kategorii, všechny odkazy v ní obsažené budou přesunuty do kořenové kategorie.');

//
//  serendipity_plugin_linklist.php
//
@define('PLUGIN_LINKS_NAME',		'Link List');
@define('PLUGIN_LINKS_BLAHBLAH',		'Správce odkazů (linků) - V bočním panelu zobrazuje vaše oblíbené odkazy.');
@define('PLUGIN_LINKS_TITLE',		'Nadpis');
@define('PLUGIN_LINKS_TITLE_BLAHBLAH',		'Nadpis celého panelu odkazů v postranním sloupci');
@define('PLUGIN_LINKS_TOP_LEVEL',		'Text nejvyšší úrovně');
@define('PLUGIN_LINKS_TOP_LEVEL_BLAHBLAH',		'Zadejte text, který se má zobrazit jako popis hlavní kategorie stromu odkazů. Pole můžete též nechat prázdné.');
@define('PLUGIN_LINKS_DIRECTXML',		'Vložit XML přímo');
@define('PLUGIN_LINKS_DIRECTXML_BLAHBLAH',		'Odkazy můžete vložit přímo pomocí ručního zadání XML struktury. (zadávání přes administrátorské rozhraní pak nebude možné)');
@define('PLUGIN_LINKS_LINKS',		'Odkazy');
@define('PLUGIN_LINKS_LINKS_BLAHBLAH',		'Používá se XML!!! - pro zadání adresáře (kategorie) použijte strukturu "<dir name="dirname"> a uzavřete pomocí </dir> - jednotlivé odkazy zadávejte jako "<link name="linkname" link="http://link.com/" />');
@define('PLUGIN_LINKS_OPENALL',		'Text "Otevři všechny"');
@define('PLUGIN_LINKS_OPENALL_BLAHBLAH',		'Zadej text, který se má zobrazit u přepínače "Otevři všechny" nad seznamem odkazů');
@define('PLUGIN_LINKS_OPENALL_DEFAULT',		'Otevři všechny');
@define('PLUGIN_LINKS_CLOSEALL',		'Zavři všechny');
@define('PLUGIN_LINKS_CLOSEALL_BLAHBLAH',		'Zadej text, který se má zobrazit u přepínače "Zavři všechny" nad seznamem odkazů');
@define('PLUGIN_LINKS_CLOSEALL_DEFAULT',		'Zavři všechny');
@define('PLUGIN_LINKS_SHOW',		'Zobrazit přepínače "Otevři všechny" a "Zavři všechny" ');
@define('PLUGIN_LINKS_SHOW_BLAHBLAH',		'Chceš zobrazit přepínače "Otevři všechny" a "Zavři všechny" u stromu odkazů?');
@define('PLUGIN_LINKS_LOCATION',		'Poloha přepínačů "Otevři/Zavři všechny"');
@define('PLUGIN_LINKS_LOCATION_BLAHBLAH',		'Kde se mají zobrazit přepínače "Otevři všechny" a "Zavři všechny"?');
@define('PLUGIN_LINKS_LOCATION_TOP',		'Nahoře');
@define('PLUGIN_LINKS_LOCATION_BOTTOM',		'Dole');
@define('PLUGIN_LINKS_SELECTION',		'Použít zvýrazňování výběru');
@define('PLUGIN_LINKS_SELECTION_BLAHBLAH',		'Pokud je nastaveno na ANO, právě navštívené odkazy jsou zvýrazňovány.');
@define('PLUGIN_LINKS_COOKIE',		'Použít cookies');
@define('PLUGIN_LINKS_COOKIE_BLAHBLAH',		'Pokud je nastaveno na ANO, strom odkazů používá cookies k tomu, aby si pamatoval svůj aktuální stav (které kategorie jsou otevřené a které zavřené).');
@define('PLUGIN_LINKS_LINE',		'Vykreslit čáry');
@define('PLUGIN_LINKS_LINE_BLAHBLAH',		'Pokud nastaveno na ANO, strom odkazů je vykreslen s čárami spojující sousedící položky a kategorie.');
@define('PLUGIN_LINKS_ICON',		'Použít ikony');
@define('PLUGIN_LINKS_ICON_BLAHBLAH',		'Pokud nastaveno na ANO, strom odkazů je vykreslen s použitím ikon pro odakzy a kategorie.');
@define('PLUGIN_LINKS_STATUS',		'Zobrazovat text ve status řádku');
@define('PLUGIN_LINKS_STATUS_BLAHBLAH',		'Pokud nastaveno na ANO, zobrazuje ve status řádku místo adresy název odkazu.');
@define('PLUGIN_LINKS_CLOSELEVEL',		'Zavírat stejnou úroveň');
@define('PLUGIN_LINKS_CLOSELEVEL_BLAHBLAH',		'Pokud nastaveno na ANO, je možné rozkliknout pouze jednu kategorii ve stromu odkazů. Přepínače "Zavřít/otevřít všechny" při zaškrtnutí této volby nefungují.');
@define('PLUGIN_LINKS_TARGET',		'Cíl - Target');
@define('PLUGIN_LINKS_TARGET_BLAHBLAH',		'Cíl - Target pro zobrazování odkazů, možné hodnoty jsou "_blank", "_self", "_top", "_parent" nebo jakékoliv jméno rámu');
@define('PLUGIN_LINKS_IMGDIR',		'Obrázky z adresáře v pluginu');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH',		'Pokud je nastaveno na ANO, plugin bude hledat obrázky pro odkazy/kategorie ve svém podadresáři. Pokud je nastaveno na NE, plugin se bude odkazovat do adresáře "/templates/default/img/". Nastavení volby na NE je nezbytné pro sdílené instalace, ale obrázky musíte přesunout do oadresáře šablony ručně.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME',		'Strom kategorií otevřen nebo zavřen.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_DESC',		'Při použití řazení odkazů podle "Kategorie", bude strom kategorií přednastaven jako otevřený/zavřený, pokud se nenajde nastavní o jeho stavu.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_CLOSED',		'Zavřený');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_OPEN',		'Otevřený');
@define('PLUGIN_LINKLIST_OUTSTYLE_DTREE',		'dtree');
@define('PLUGIN_LINKLIST_OUTSTYLE_CSS',		'CSS List');
@define('PLUGIN_LINKLIST_ORDER_OUTSTYLE_SIMP_CSS',		'Simple CSS');
@define('PLUGIN_LINKS_OUTSTYLE',		'Vyber styl zobrazení odkazovníku (LinkListu)');
@define('PLUGIN_LINKS_OUTSTYLE_BLAHBLAH',		'Vyber styl zobrazení odkazovníku (LinkListu).  "Dtree" zobrazuje strom pomocí javascriptu. "CSS list" použivá ostylované tagy div a jednoduchý javascript, ovšem neumožňuje všechny volby jako Dtree. "Simple CSS" zobrazí jednoduchý odkazovník formátovaný pouze pomocí CSS stylů. Pamatujte, že Dtree není průchozí pro vyhledávací roboty. ');
@define('PLUGIN_LINKS_CALLMARKUP',		'Používat značkování?');
@define('PLUGIN_LINKS_CALLMARKUP_BLAHBLAH',		'Zda používat značkování na odkazovník. Tato volba použije všechna značkování, která jsou obecně používána na vložený HTML kód.');
@define('PLUGIN_LINKS_USEDESC',		'Použít zadaný popis');
@define('PLUGIN_LINKS_USEDESC_BLAHBLAH',		'Použít popis pro titulek odkazu, pokud je přítomen.');
@define('PLUGIN_LINKS_PREPEND',		'Zadej jakýkoliv text. Zobrazí se před seznamem odkazů.');
@define('PLUGIN_LINKS_APPEND',		'Zadej jakýkoliv text. Zobrazí se za seznamem odkazů.');
