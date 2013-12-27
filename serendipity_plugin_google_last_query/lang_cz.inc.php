/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/03/14
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/06/14
 */

@define('PLUGIN_GOOGLE_LAST_QUERY_TITLE',		'Poslední vyhledávání (Google, Yahoo, Bing, Croogle)');
@define('PLUGIN_GOOGLE_LAST_QUERY_DESC',		'Zobrazuje slova, která byla v poslední dobì vyhledávánavna tomto blogu (pomocí Googlu, Yahoo, Bingu nebo Scrooglu).');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_TITLE',		'Nadpis');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_TITLE_DESC',		'Nadpis postranního bloku');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_COUNT',		'Poèet');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_COUNT_DESC',		'Kolik vyhledávaných slov má být zobrazováno?');

@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_VISITORTABLE',		'Pou¾ít tabulku náv¹tìvníkù');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_VISITORTABLE_DESC',		'Obvykle je pou¾itá tabulka odkazovaèù. Tato tabulka neuchovává v¹echny odkazy, nýbr¾ odkazy vedoucí na blog vícekrát. Tabulka náv¹tìvníkù obsahuje v¹echny náv¹tìvníky. Pokud pou¾ijete tuto tabulku, vyhledávání z Googlu budou zobrazeny okam¾itì. Ale pozor:  Tabulka náv¹tìvníkù ja vyplòována pluginem "Statistiky", a navíc jen pouze tehdy, pokud je v nìm povolena volba sledování náv¹tìvníkù.');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_NEWWINDOW',		'Otevøít odkaz v novém oknì');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_NEWWINDOW_DESC',		'Vyhledávaná slova jsou zobrazena jako odkaz na pøíslu¹nou stránku Googlu s výsledky vyhledávání. Má se tento odkaz zobrazovat v novém oknì?');

// Next lines were translated on 2009/06/14
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_HTTPREL',		'Relativní HTTP cesta tohoto pluginu');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_HTTPREL_DESC',		'Tato volba definuje HTTP cestu relativnì ke koøenové adrese serveru. Pokud jste nemìnili strukturu stálých odkazù (permalinkù) a Vá¹ blog nebì¾í v podadresáøi serveru, pak by mìlo fungovat výchozí nastavení.');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_ICONS',		'Zobrazovat ikony');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_ICONS_DESC',		'Zobrazovat ikony pou¾itého vyhledávaèe pro ka¾dý výsledek.');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_TIME',		'Zobrazovat èas zpracování dotazu');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_TIME_DESC',		'Pokud je povoleno, pak se pøi najetí my¹i na výsledek vyhledávání zobrazí èas, který zabrao jeho zpracování.');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_AUTHONLY',		'Zobrazovat pouze pøihlá¹eným u¾ivatelùm');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_AUTHONLY_DESC',		'Pokud je povoleno, plugin se bude zobrazovat pouze pøihlá¹eným u¾ivatelùm.');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_STATS',		'Statistiky vyhledávaèù');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_STATS_DESC',		'Pokud je povoleno, bude zobrazovat, kolik vyhledávaných øetìzcù vede na blog z kterého vyhledávaèe bìhem posledních X dní');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_STATDAYS',		'Dny pro statistiku');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_STATDAYS_DESC',		'To je poèet dní nazpìt, který se bude poèítat do statistiky. Nezadávejte pøíli¹ velkou hodnotu. Èím vy¹¹í hodnota, tím pomalej¹í plugin je.');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_ENTRIES',		'Zobrazit hledané øetìzce');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_ENTRIES_DESC',		'Pokud je zakázáno, nebudou se zobrazovat hledané øetìzce (zobrazovat se budou pouze souhrnné statistiky)');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_CACHEMINS',		'Cachování v minutách');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_CACHEMINS_DESC',		'Statistiky vyhledávaných øetìzcù a vyhledávaèù mohou být cachovány. Zadejte èas v minutách, po kterém budou obnovovány (0 = cachování vypnuto)');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_ENGINES',		'Vyhledávaèe');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_ENGINES_DESC',		'Oznaète v¹echny vyhledávaèe, které má plugin vyhodnocovat. Èím více jich oznaèíte, tím del¹í èas bude samozøejmì pluginu trvat jejich zpracování.');