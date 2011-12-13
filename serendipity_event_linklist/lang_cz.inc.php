<?php # lang_cz.inc.php 1.2 2009-02-15 21:20:33 VladaAjgl $

/**
 *  @version 1.2
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Translated on 2007/11/30
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/15
 */

//
//  serendipity_event_linklist.php
//
@define('PLUGIN_LINKLIST_TITLE',		'Link List');
@define('PLUGIN_LINKLIST_DESC',		'Správce odkazù (linkù) - V boèním panelu zobrazuje va¹e oblíbené odkazy.');
@define('PLUGIN_LINKLIST_LINK',		'Odkaz (Link)');
@define('PLUGIN_LINKLIST_LINK_NAME',		'Jméno');
@define('PLUGIN_LINKLIST_ADMINLINK',		'Odkazy (LinkList)');
@define('PLUGIN_LINKLIST_ORDER',		'Seøaï odkazy podle:');
@define('PLUGIN_LINKLIST_ORDER_DESC',		'Vyber kritérium, podle kterého se mají øadit odkazy pøi zobrazování.');
@define('PLUGIN_LINKLIST_ORDER_NUM_ORDER',		'Poøadí zadané u¾ivatelem (tebou)');
@define('PLUGIN_LINKLIST_ORDER_DATE_ACS',		'Datum (Od nejstar¹ího po nejnovìj¹í)');
@define('PLUGIN_LINKLIST_ORDER_DATE_DESC',		'Datum (Od nejnovìj¹ího po nejstar¹í)');
@define('PLUGIN_LINKLIST_ORDER_CATEGORY',		'Kategorie');
@define('PLUGIN_LINKLIST_ORDER_ALPHA',		'Abecednì');
@define('PLUGIN_LINKLIST_LINKS',		'Správa odkazù');
@define('PLUGIN_LINKLIST_NOLINKS',		'®ádné odkazy nejsou zadány');
@define('PLUGIN_LINKLIST_CATEGORY',		'Pou¾ít kategorie');
@define('PLUGIN_LINKLIST_CATEGORYDESC',		'Pou¾ít kategorie pøi seskupování odkazù.');
@define('PLUGIN_LINKLIST_ADDLINK',		'Pøidat odkaz');
@define('PLUGIN_LINKLIST_LINK_EXAMPLE',		'Pøíklad správného odkazu: http://www.s9y.org nebo http://www.s9y.org/forums/');
@define('PLUGIN_LINKLIST_EDITLINK',		'Upravit odkaz');
@define('PLUGIN_LINKLIST_LINKDESC',		'Popis odkazu');
@define('PLUGIN_LINKLIST_CATEGORY_NAME',		'Systém kategorií:');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DESC',		'Mù¾ete si vybrat, který systém kategorií chcete pou¾ít. Jestli stejné kategorie, jako u pøíspìvkù, nebo nezávislé kategorie definované v tomto pluginu.');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_CUSTOM',		'Vlastní');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DEFAULT',		'Standardní - z blogu');
@define('PLUGIN_LINKLIST_ADD_CAT',		'Pøidat kategorii');
@define('PLUGIN_LINKLIST_CAT_NAME',		'Název kategorie');
@define('PLUGIN_LINKLIST_PARENT_CATEGORY',		'Nadøazená (rodièovská) kategorie');
@define('PLUGIN_LINKLIST_ADMINCAT',		'Správa kategorií');
@define('PLUGIN_LINKLIST_CACHE_NAME',		'Cachovat postranní sloupec');
@define('PLUGIN_LINKLIST_CACHE_DESC',		'Cachování postranního sloupce zvy¹uje rychlost stránek. Cache je obnovována pouze pøi vkládání odkazù pøes administrativní rozhraní. Není obnovována pøi ruèním zadávání pomocí xml.');
@define('PLUGIN_LINKLIST_ENABLED_NAME',		'Povolit');
@define('PLUGIN_LINKLIST_ENABLED_DESC',		'Povolit tento zásuvný modul.');
@define('PLUGIN_LINKLIST_DELETE_WARN',		'Pokud sma¾ete kategorii, v¹echny odkazy v ní obsa¾ené budou pøesunuty do koøenové kategorie.');

//
//  serendipity_plugin_linklist.php
//
@define('PLUGIN_LINKS_NAME',		'Link List');
@define('PLUGIN_LINKS_BLAHBLAH',		'Správce odkazù (linkù) - V boèním panelu zobrazuje va¹e oblíbené odkazy.');
@define('PLUGIN_LINKS_TITLE',		'Nadpis');
@define('PLUGIN_LINKS_TITLE_BLAHBLAH',		'Nadpis celého panelu odkazù v postranním sloupci');
@define('PLUGIN_LINKS_TOP_LEVEL',		'Text nejvy¹¹í úrovnì');
@define('PLUGIN_LINKS_TOP_LEVEL_BLAHBLAH',		'Zadejte text, který se má zobrazit jako popis hlavní kategorie stromu odkazù. Pole mù¾ete té¾ nechat prázdné.');
@define('PLUGIN_LINKS_DIRECTXML',		'Vlo¾it XML pøímo');
@define('PLUGIN_LINKS_DIRECTXML_BLAHBLAH',		'Odkazy mù¾ete vlo¾it pøímo pomocí ruèního zadání XML struktury. (zadávání pøes administrátorské rozhraní pak nebude mo¾né)');
@define('PLUGIN_LINKS_LINKS',		'Odkazy');
@define('PLUGIN_LINKS_LINKS_BLAHBLAH',		'Pou¾ívá se XML!!! - pro zadání adresáøe (kategorie) pou¾ijte strukturu "<dir name="dirname"> a uzavøete pomocí </dir> - jednotlivé odkazy zadávejte jako "<link name="linkname" link="http://link.com/" />');
@define('PLUGIN_LINKS_OPENALL',		'Text "Otevøi v¹echny"');
@define('PLUGIN_LINKS_OPENALL_BLAHBLAH',		'Zadej text, který se má zobrazit u pøepínaèe "Otevøi v¹echny" nad seznamem odkazù');
@define('PLUGIN_LINKS_OPENALL_DEFAULT',		'Otevøi v¹echny');
@define('PLUGIN_LINKS_CLOSEALL',		'Zavøi v¹echny');
@define('PLUGIN_LINKS_CLOSEALL_BLAHBLAH',		'Zadej text, který se má zobrazit u pøepínaèe "Zavøi v¹echny" nad seznamem odkazù');
@define('PLUGIN_LINKS_CLOSEALL_DEFAULT',		'Zavøi v¹echny');
@define('PLUGIN_LINKS_SHOW',		'Zobrazit pøepínaèe "Otevøi v¹echny" a "Zavøi v¹echny" ');
@define('PLUGIN_LINKS_SHOW_BLAHBLAH',		'Chce¹ zobrazit pøepínaèe "Otevøi v¹echny" a "Zavøi v¹echny" u stromu odkazù?');
@define('PLUGIN_LINKS_LOCATION',		'Poloha pøepínaèù "Otevøi/Zavøi v¹echny"');
@define('PLUGIN_LINKS_LOCATION_BLAHBLAH',		'Kde se mají zobrazit pøepínaèe "Otevøi v¹echny" a "Zavøi v¹echny"?');
@define('PLUGIN_LINKS_LOCATION_TOP',		'Nahoøe');
@define('PLUGIN_LINKS_LOCATION_BOTTOM',		'Dole');
@define('PLUGIN_LINKS_SELECTION',		'Pou¾ít zvýrazòování výbìru');
@define('PLUGIN_LINKS_SELECTION_BLAHBLAH',		'Pokud je nastaveno na ANO, právì nav¹tívené odkazy jsou zvýrazòovány.');
@define('PLUGIN_LINKS_COOKIE',		'Pou¾ít cookies');
@define('PLUGIN_LINKS_COOKIE_BLAHBLAH',		'Pokud je nastaveno na ANO, strom odkazù pou¾ívá cookies k tomu, aby si pamatoval svùj aktuální stav (které kategorie jsou otevøené a které zavøené).');
@define('PLUGIN_LINKS_LINE',		'Vykreslit èáry');
@define('PLUGIN_LINKS_LINE_BLAHBLAH',		'Pokud nastaveno na ANO, strom odkazù je vykreslen s èárami spojující sousedící polo¾ky a kategorie.');
@define('PLUGIN_LINKS_ICON',		'Pou¾ít ikony');
@define('PLUGIN_LINKS_ICON_BLAHBLAH',		'Pokud nastaveno na ANO, strom odkazù je vykreslen s pou¾itím ikon pro odakzy a kategorie.');
@define('PLUGIN_LINKS_STATUS',		'Zobrazovat text ve status øádku');
@define('PLUGIN_LINKS_STATUS_BLAHBLAH',		'Pokud nastaveno na ANO, zobrazuje ve status øádku místo adresy název odkazu.');
@define('PLUGIN_LINKS_CLOSELEVEL',		'Zavírat stejnou úroveò');
@define('PLUGIN_LINKS_CLOSELEVEL_BLAHBLAH',		'Pokud nastaveno na ANO, je mo¾né rozkliknout pouze jednu kategorii ve stromu odkazù. Pøepínaèe "Zavøít/otevøít v¹echny" pøi za¹krtnutí této volby nefungují.');
@define('PLUGIN_LINKS_TARGET',		'Cíl - Target');
@define('PLUGIN_LINKS_TARGET_BLAHBLAH',		'Cíl - Target pro zobrazování odkazù, mo¾né hodnoty jsou "_blank", "_self", "_top", "_parent" nebo jakékoliv jméno rámu');
@define('PLUGIN_LINKS_IMGDIR',		'Obrázky z adresáøe v pluginu');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH',		'Pokud je nastaveno na ANO, plugin bude hledat obrázky pro odkazy/kategorie ve svém podadresáøi. Pokud je nastaveno na NE, plugin se bude odkazovat do adresáøe "/templates/default/img/". Nastavení volby na NE je nezbytné pro sdílené instalace, ale obrázky musíte pøesunout do oadresáøe ¹ablony ruènì.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME',		'Strom kategorií otevøen nebo zavøen.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_DESC',		'Pøi pou¾ití øazení odkazù podle "Kategorie", bude strom kategorií pøednastaven jako otevøený/zavøený, pokud se nenajde nastavní o jeho stavu.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_CLOSED',		'Zavøený');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_OPEN',		'Otevøený');
@define('PLUGIN_LINKLIST_OUTSTYLE_DTREE',		'dtree');
@define('PLUGIN_LINKLIST_OUTSTYLE_CSS',		'CSS List');
@define('PLUGIN_LINKLIST_ORDER_OUTSTYLE_SIMP_CSS',		'Simple CSS');
@define('PLUGIN_LINKS_OUTSTYLE',		'Vyber styl zobrazení odkazovníku (LinkListu)');
@define('PLUGIN_LINKS_OUTSTYLE_BLAHBLAH',		'Vyber styl zobrazení odkazovníku (LinkListu).  "Dtree" zobrazuje strom pomocí javascriptu. "CSS list" pou¾ivá ostylované tagy div a jednoduchý javascript, ov¹em neumo¾òuje v¹echny volby jako Dtree. "Simple CSS" zobrazí jednoduchý odkazovník formátovaný pouze pomocí CSS stylù. Pamatujte, ¾e Dtree není prùchozí pro vyhledávací roboty. ');
@define('PLUGIN_LINKS_CALLMARKUP',		'Pou¾ívat znaèkování?');
@define('PLUGIN_LINKS_CALLMARKUP_BLAHBLAH',		'Zda pou¾ívat znaèkování na odkazovník. Tato volba pou¾ije v¹echna znaèkování, která jsou obecnì pou¾ívána na vlo¾ený HTML kód.');
@define('PLUGIN_LINKS_USEDESC',		'Pou¾ít zadaný popis');
@define('PLUGIN_LINKS_USEDESC_BLAHBLAH',		'Pou¾ít popis pro titulek odkazu, pokud je pøítomen.');
@define('PLUGIN_LINKS_PREPEND',		'Zadej jakýkoliv text. Zobrazí se pøed seznamem odkazù.');
@define('PLUGIN_LINKS_APPEND',		'Zadej jakýkoliv text. Zobrazí se za seznamem odkazù.');
