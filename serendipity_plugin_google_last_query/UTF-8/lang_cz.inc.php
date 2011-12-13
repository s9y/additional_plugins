<?php # lang_cz.inc.php 1.1 2009-06-14 11:03:38 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/03/14
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/06/14
 */

@define('PLUGIN_GOOGLE_LAST_QUERY_TITLE',		'Poslední vyhledávání (Google, Yahoo, Bing, Croogle)');
@define('PLUGIN_GOOGLE_LAST_QUERY_DESC',		'Zobrazuje slova, která byla v poslední době vyhledávánavna tomto blogu (pomocí Googlu, Yahoo, Bingu nebo Scrooglu).');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_TITLE',		'Nadpis');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_TITLE_DESC',		'Nadpis postranního bloku');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_COUNT',		'Počet');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_COUNT_DESC',		'Kolik vyhledávaných slov má být zobrazováno?');

@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_VISITORTABLE',		'Použít tabulku návštěvníků');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_VISITORTABLE_DESC',		'Obvykle je použitá tabulka odkazovačů. Tato tabulka neuchovává všechny odkazy, nýbrž odkazy vedoucí na blog vícekrát. Tabulka návštěvníků obsahuje všechny návštěvníky. Pokud použijete tuto tabulku, vyhledávání z Googlu budou zobrazeny okamžitě. Ale pozor:  Tabulka návštěvníků ja vyplňována pluginem "Statistiky", a navíc jen pouze tehdy, pokud je v něm povolena volba sledování návštěvníků.');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_NEWWINDOW',		'Otevřít odkaz v novém okně');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_NEWWINDOW_DESC',		'Vyhledávaná slova jsou zobrazena jako odkaz na příslušnou stránku Googlu s výsledky vyhledávání. Má se tento odkaz zobrazovat v novém okně?');

// Next lines were translated on 2009/06/14
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_HTTPREL',		'Relativní HTTP cesta tohoto pluginu');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_HTTPREL_DESC',		'Tato volba definuje HTTP cestu relativně ke kořenové adrese serveru. Pokud jste neměnili strukturu stálých odkazů (permalinků) a Váš blog neběží v podadresáři serveru, pak by mělo fungovat výchozí nastavení.');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_ICONS',		'Zobrazovat ikony');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_ICONS_DESC',		'Zobrazovat ikony použitého vyhledávače pro každý výsledek.');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_TIME',		'Zobrazovat čas zpracování dotazu');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_TIME_DESC',		'Pokud je povoleno, pak se při najetí myši na výsledek vyhledávání zobrazí čas, který zabrao jeho zpracování.');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_AUTHONLY',		'Zobrazovat pouze přihlášeným uživatelům');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_AUTHONLY_DESC',		'Pokud je povoleno, plugin se bude zobrazovat pouze přihlášeným uživatelům.');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_STATS',		'Statistiky vyhledávačů');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_STATS_DESC',		'Pokud je povoleno, bude zobrazovat, kolik vyhledávaných řetězců vede na blog z kterého vyhledávače během posledních X dní');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_STATDAYS',		'Dny pro statistiku');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_STATDAYS_DESC',		'To je počet dní nazpět, který se bude počítat do statistiky. Nezadávejte příliš velkou hodnotu. Čím vyšší hodnota, tím pomalejší plugin je.');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_ENTRIES',		'Zobrazit hledané řetězce');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_ENTRIES_DESC',		'Pokud je zakázáno, nebudou se zobrazovat hledané řetězce (zobrazovat se budou pouze souhrnné statistiky)');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_CACHEMINS',		'Cachování v minutách');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_CACHEMINS_DESC',		'Statistiky vyhledávaných řetězců a vyhledávačů mohou být cachovány. Zadejte čas v minutách, po kterém budou obnovovány (0 = cachování vypnuto)');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_ENGINES',		'Vyhledávače');
@define('PLUGIN_GOOGLE_LAST_QUERY_PROP_ENGINES_DESC',		'Označte všechny vyhledávače, které má plugin vyhodnocovat. Čím více jich označíte, tím delší čas bude samozřejmě pluginu trvat jejich zpracování.');