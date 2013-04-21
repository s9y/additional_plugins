<?php # lang_cs.inc.php 1.3 2013-04-21 12:09:00 VladaAjgl $

/**
 *  @version 1.3
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Translated on 2007/11/30
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/15
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/21
 */

//
//  serendipity_event_linklist.php
//

@define('PLUGIN_LINKLIST_TITLE',		'Link List');
@define('PLUGIN_LINKLIST_DESC',		'Správce odkazù (linkù) - V boèním panelu zobrazuje vaše oblíbené odkazy.');
@define('PLUGIN_LINKLIST_LINK',		'Odkaz (Link)');
@define('PLUGIN_LINKLIST_LINK_NAME',		'Jméno');
@define('PLUGIN_LINKLIST_ADMINLINK',		'Odkazy (LinkList)');
@define('PLUGIN_LINKLIST_ORDER',		'Seøaï odkazy podle:');
@define('PLUGIN_LINKLIST_ORDER_DESC',		'Vyber kritérium, podle kterého se mají øadit odkazy pøi zobrazování.');
@define('PLUGIN_LINKLIST_ORDER_NUM_ORDER',		'Poøadí zadané uživatelem (tebou)');
@define('PLUGIN_LINKLIST_ORDER_DATE_ACS',		'Datum (Od nejstaršího po nejnovìjší)');
@define('PLUGIN_LINKLIST_ORDER_DATE_DESC',		'Datum (Od nejnovìjšího po nejstarší)');
@define('PLUGIN_LINKLIST_ORDER_CATEGORY',		'Kategorie');
@define('PLUGIN_LINKLIST_ORDER_ALPHA',		'Abecednì');
@define('PLUGIN_LINKLIST_LINKS',		'Správa odkazù');
@define('PLUGIN_LINKLIST_NOLINKS',		'Žádné odkazy nejsou zadány');
@define('PLUGIN_LINKLIST_CATEGORY',		'Použít kategorie');
@define('PLUGIN_LINKLIST_CATEGORYDESC',		'Použít kategorie pøi seskupování odkazù.');
@define('PLUGIN_LINKLIST_ADDLINK',		'Pøidat odkaz');
@define('PLUGIN_LINKLIST_LINK_EXAMPLE',		'Pøíklad správného odkazu: http://www.s9y.org nebo http://www.s9y.org/forums/');
@define('PLUGIN_LINKLIST_EDITLINK',		'Upravit odkaz');
@define('PLUGIN_LINKLIST_LINKDESC',		'Popis odkazu');
@define('PLUGIN_LINKLIST_CATEGORY_NAME',		'Systém kategorií:');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DESC',		'Mùžete si vybrat, který systém kategorií chcete použít. Jestli stejné kategorie, jako u pøíspìvkù, nebo nezávislé kategorie definované v tomto pluginu.');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_CUSTOM',		'Vlastní');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DEFAULT',		'Standardní - z blogu');
@define('PLUGIN_LINKLIST_ADD_CAT',		'Pøidat kategorii');
@define('PLUGIN_LINKLIST_CAT_NAME',		'Název kategorie');
@define('PLUGIN_LINKLIST_PARENT_CATEGORY',		'Nadøazená (rodièovská) kategorie');
@define('PLUGIN_LINKLIST_ADMINCAT',		'Správa kategorií');
@define('PLUGIN_LINKLIST_CACHE_NAME',		'Cachovat postranní sloupec');
@define('PLUGIN_LINKLIST_CACHE_DESC',		'Cachování postranního sloupce zvyšuje rychlost stránek. Cache je obnovována pouze pøi vkládání odkazù pøes administrativní rozhraní. Není obnovována pøi ruèním zadávání pomocí xml.');
@define('PLUGIN_LINKLIST_ENABLED_NAME',		'Povolit');
@define('PLUGIN_LINKLIST_ENABLED_DESC',		'Povolit tento zásuvný modul.');
@define('PLUGIN_LINKLIST_DELETE_WARN',		'Pokud smažete kategorii, všechny odkazy v ní obsažené budou pøesunuty do koøenové kategorie.');

//
//  serendipity_plugin_linklist.php
//

@define('PLUGIN_LINKS_NAME',		'Link List');
@define('PLUGIN_LINKS_BLAHBLAH',		'Správce odkazù (linkù) - V boèním panelu zobrazuje vaše oblíbené odkazy.');
@define('PLUGIN_LINKS_TITLE',		'Nadpis');
@define('PLUGIN_LINKS_TITLE_BLAHBLAH',		'Nadpis celého panelu odkazù v postranním sloupci');
@define('PLUGIN_LINKS_TOP_LEVEL',		'Text nejvyšší úrovnì');
@define('PLUGIN_LINKS_TOP_LEVEL_BLAHBLAH',		'Zadejte text, který se má zobrazit jako popis hlavní kategorie stromu odkazù. Pole mùžete též nechat prázdné.');
@define('PLUGIN_LINKS_DIRECTXML',		'Vložit XML pøímo');
@define('PLUGIN_LINKS_DIRECTXML_BLAHBLAH',		'Odkazy mùžete vložit pøímo pomocí ruèního zadání XML struktury. (zadávání pøes administrátorské rozhraní pak nebude možné)');
@define('PLUGIN_LINKS_LINKS',		'Odkazy');
@define('PLUGIN_LINKS_LINKS_BLAHBLAH',		'Používá se XML!!! - pro zadání adresáøe (kategorie) použijte strukturu "<dir name="dirname"> a uzavøete pomocí </dir> - jednotlivé odkazy zadávejte jako "<link name="linkname" link="http://link.com/" />');
@define('PLUGIN_LINKS_OPENALL',		'Text "Otevøi všechny"');
@define('PLUGIN_LINKS_OPENALL_BLAHBLAH',		'Zadej text, který se má zobrazit u pøepínaèe "Otevøi všechny" nad seznamem odkazù');
@define('PLUGIN_LINKS_OPENALL_DEFAULT',		'Otevøi všechny');
@define('PLUGIN_LINKS_CLOSEALL',		'Zavøi všechny');
@define('PLUGIN_LINKS_CLOSEALL_BLAHBLAH',		'Zadej text, který se má zobrazit u pøepínaèe "Zavøi všechny" nad seznamem odkazù');
@define('PLUGIN_LINKS_CLOSEALL_DEFAULT',		'Zavøi všechny');
@define('PLUGIN_LINKS_SHOW',		'Zobrazit pøepínaèe "Otevøi všechny" a "Zavøi všechny" ');
@define('PLUGIN_LINKS_SHOW_BLAHBLAH',		'Chceš zobrazit pøepínaèe "Otevøi všechny" a "Zavøi všechny" u stromu odkazù?');
@define('PLUGIN_LINKS_LOCATION',		'Poloha pøepínaèù "Otevøi/Zavøi všechny"');
@define('PLUGIN_LINKS_LOCATION_BLAHBLAH',		'Kde se mají zobrazit pøepínaèe "Otevøi všechny" a "Zavøi všechny"?');
@define('PLUGIN_LINKS_LOCATION_TOP',		'Nahoøe');
@define('PLUGIN_LINKS_LOCATION_BOTTOM',		'Dole');
@define('PLUGIN_LINKS_SELECTION',		'Použít zvýrazòování výbìru');
@define('PLUGIN_LINKS_SELECTION_BLAHBLAH',		'Pokud je nastaveno na ANO, právì navštívené odkazy jsou zvýrazòovány.');
@define('PLUGIN_LINKS_COOKIE',		'Použít cookies');
@define('PLUGIN_LINKS_COOKIE_BLAHBLAH',		'Pokud je nastaveno na ANO, strom odkazù používá cookies k tomu, aby si pamatoval svùj aktuální stav (které kategorie jsou otevøené a které zavøené).');
@define('PLUGIN_LINKS_LINE',		'Vykreslit èáry');
@define('PLUGIN_LINKS_LINE_BLAHBLAH',		'Pokud nastaveno na ANO, strom odkazù je vykreslen s èárami spojující sousedící položky a kategorie.');
@define('PLUGIN_LINKS_ICON',		'Použít ikony');
@define('PLUGIN_LINKS_ICON_BLAHBLAH',		'Pokud nastaveno na ANO, strom odkazù je vykreslen s použitím ikon pro odakzy a kategorie.');
@define('PLUGIN_LINKS_STATUS',		'Zobrazovat text ve status øádku');
@define('PLUGIN_LINKS_STATUS_BLAHBLAH',		'Pokud nastaveno na ANO, zobrazuje ve status øádku místo adresy název odkazu.');
@define('PLUGIN_LINKS_CLOSELEVEL',		'Zavírat stejnou úroveò');
@define('PLUGIN_LINKS_CLOSELEVEL_BLAHBLAH',		'Pokud nastaveno na ANO, je možné rozkliknout pouze jednu kategorii ve stromu odkazù. Pøepínaèe "Zavøít/otevøít všechny" pøi zaškrtnutí této volby nefungují.');
@define('PLUGIN_LINKS_TARGET',		'Cíl - Target');
@define('PLUGIN_LINKS_TARGET_BLAHBLAH',		'Cíl - Target pro zobrazování odkazù, možné hodnoty jsou "_blank", "_self", "_top", "_parent" nebo jakékoliv jméno rámu');
@define('PLUGIN_LINKS_IMGDIR',		'Obrázky z adresáøe v pluginu');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH',		'Pokud je nastaveno na ANO, plugin bude hledat obrázky pro odkazy/kategorie ve svém podadresáøi. Pokud je nastaveno na NE, plugin se bude odkazovat do adresáøe "/templates/default/img/". Nastavení volby na NE je nezbytné pro sdílené instalace, ale obrázky musíte pøesunout do adresáøe šablony ruènì.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME',		'Strom kategorií otevøen nebo zavøen.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_DESC',		'Pøi použití øazení odkazù podle "Kategorie", bude strom kategorií pøednastaven jako otevøený/zavøený, pokud se nenajde nastavení o jeho stavu.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_CLOSED',		'Zavøený');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_OPEN',		'Otevøený');
@define('PLUGIN_LINKLIST_OUTSTYLE_DTREE',		'dtree');
@define('PLUGIN_LINKLIST_OUTSTYLE_CSS',		'CSS List');
@define('PLUGIN_LINKLIST_ORDER_OUTSTYLE_SIMP_CSS',		'Simple CSS');
@define('PLUGIN_LINKS_OUTSTYLE',		'Vyber styl zobrazení odkazovníku (LinkListu)');
@define('PLUGIN_LINKS_OUTSTYLE_BLAHBLAH',		'Vyber styl zobrazení odkazovníku (LinkListu).  "Dtree" zobrazuje strom pomocí javascriptu. "CSS list" použivá ostylované tagy div a jednoduchý javascript, ovšem neumožòuje všechny volby jako Dtree. "Simple CSS" zobrazí jednoduchý odkazovník formátovaný pouze pomocí CSS stylù. Pamatujte, že Dtree není prùchozí pro vyhledávací roboty. ');
@define('PLUGIN_LINKS_CALLMARKUP',		'Používat znaèkování?');
@define('PLUGIN_LINKS_CALLMARKUP_BLAHBLAH',		'Zda používat znaèkování na odkazovník. Tato volba použije všechna znaèkování, která jsou obecnì používána na vložený HTML kód.');
@define('PLUGIN_LINKS_USEDESC',		'Použít zadaný popis');
@define('PLUGIN_LINKS_USEDESC_BLAHBLAH',		'Použít popis pro titulek odkazu, pokud je pøítomen.');
@define('PLUGIN_LINKS_PREPEND',		'Zadej jakýkoliv text. Zobrazí se pøed seznamem odkazù.');
@define('PLUGIN_LINKS_APPEND',		'Zadej jakýkoliv text. Zobrazí se za seznamem odkazù.');