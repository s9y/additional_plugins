<?php # lang_cz.inc.php 1.6 2012-01-11 23:24:56 VladaAjgl $

/**
 *  @version 1.6
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/11/07
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/12/29
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/03/07
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/04/24
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/09/12
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/11/26
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/01/11
 */

@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME',     'Spamblock (Bayes)');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_DESC',     'Detekce spamu pomocí adaptivního algoritmu, který se doká¾e sám uèit.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_HAM',      'V poøádku');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAM',     'Spam');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_AUTOLEARN',     'Uèit se');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_AUTOLEARN_DESC',     'Komentáøe, který velmi pravdìpodobnì obsahují spam jsou pou¾ity k uèení pro detekci dal¹ího spamu. Tímto zpùsobem se algoritmus automaticky lehce uèí.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGFILE',     'Umístìní logu');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGFILE_DESC',     'Oznámení o zamítnutých/schvalovaných pøíspìvcích mohou být zapisovány do logu. Pokud chcete vypnout logování, zadejte prázdný øetìzec.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE',     'Vyberte metodu logování');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_DESC',     'Logování odmítnutých komentáøù mù¾e probíhat buï do databáze nebo do textového souboru.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_FILE', 'Soubor (viz "Umístìní logu" ní¾e)');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_DB', 'Databáze');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_NONE', 'Nelogovat');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_REASON', 'Odchyceno pluginem Bayes');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_ERROR', 'Odmítnuto jako spam.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MODERATE', 'Pravdìpodobnì se jedná o spam. Pøíspìvek byl pøedlo¾en ke schválení.');

// Next lines were translated on 2009/12/29

@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RATING_EXPLANATION',     'Riziko spamu podle pluginu Spambock-Bayes.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_DELETE',     'Smazat komentáø a oznaèit jako spam');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_APPROVE',     'Odsouhlasit komentáø a oznaèit jako platný');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_PATH',     'Cesta k pluginu');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_PATH_DESC',     'Pokud je zde cesta zadána, není nadále rozpoznávána dynamicky. To má významný vliv na výkon pluginu. Pøíklad: http://www.priklad.cz/plugins/serendipity_event_spamblock_bayes/ (na konci musí být lomítko "/" ).');

// Next lines were translated on 2010/03/07

@define('PLUGIN_EVENT_SPAMBLOCK_METHOD',     'Zacházení se spamem');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_MODERATE',     'Vlastní schvalování');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_MODERATE_DESC',     'Pøi vlastním módu schvalovat pøi hodnocení vìt¹ím ne¾? (v %)');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_BLOCK',     'Vlastní odmítnutí');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_BLOCK_DESC',     'Pøi vlastním módu odmítnout pøi hodnocení vy¹¹ím ne¾? (v %)');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_MODERATE',     'Schvalovat');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_BLOCK',     'Odmítnout');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_CUSTOM',     'Vlastní nastavení');

// Next lines were translated on 2010/04/24

@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAMBUTTON',     'Oznaèit vybrané komentáøe jako spam');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_LEARN',     'Uèit se');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_DATABASE',     'Databáze');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_RECYCLER',     'Ko¹');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_CREATEDB',     'Vytvoøit databázi');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LEARNOLD',     'Uèit se ze star¹ích');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_ERASEDB',     'Vymazat databázi');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_SAVEDVALUES',     'Hodnocené komentáøe');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU',     'Menu');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_DESC',     'Odkaz na roz¹íøené menu v administraèní sekci.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DESC',     'Mají se zablokované komentáøe ukládat do ko¹e?');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_EMPTY',     'Vyprázdnit ko¹');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RESTORE',     'Obnovit');

// Next lines were translated on 2010/09/12

@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_HAMBUTTON',     'Ozaèit jako platné');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_ANALYSIS',     'Analýza');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DELETE',     'Pøemostìní ko¹e');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DELETE_DESC',     'Komentáøe s hodnocením vìt¹ím nebo rovném ne¾ je tato hodnota nebudou zahozeny do ko¹e, nýbr¾ rovnou smazány. Pøíklad: 98');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IGNORE',     'Ignorovat');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IGNORE_DESC',     'Zadejte pole komentáøe, které budou ignorovány. Mo¾né hodnoty: ip, referer, author, body, email, url. Pøíklad: "ip, referer".');

// Next lines were translated on 2010/11/26

@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_EXPORTDB',     'Export databáze');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IMPORTDB',     'Import databáze');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IMPORT_EXPLANATION',     'Iportovat døíve vygenerovaný CSV soubory. Naètená data filtru budou pøidána do databáze.');

// Next lines were translated on 2012/01/11
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_IMPORT',     'Import');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_EXPLANATION',     'Mù¾ete importovat databázi spamu z jiného blogu. Zaregistrujte se a ostatní blogy se budou uèit z va¹í databáze spamu.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA',     'Online Import');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_IMPORT',     'Import');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_REGISTER',     'Pøidat tento blog');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_REMOVE',     'Odstranit tento blog');