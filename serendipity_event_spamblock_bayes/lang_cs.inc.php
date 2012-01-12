<?php # lang_cs.inc.php 1.6 2012-01-11 23:24:56 VladaAjgl $

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
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_DESC',     'Detekce spamu pomocí adaptivního algoritmu, který se dokáže sám uèit.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_HAM',      'V poøádku');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAM',     'Spam');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_AUTOLEARN',     'Uèit se');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_AUTOLEARN_DESC',     'Komentáøe, který velmi pravdìpodobnì obsahují spam jsou použity k uèení pro detekci dalšího spamu. Tímto zpùsobem se algoritmus automaticky lehce uèí.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGFILE',     'Umístìní logu');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGFILE_DESC',     'Oznámení o zamítnutých/schvalovaných pøíspìvcích mohou být zapisovány do logu. Pokud chcete vypnout logování, zadejte prázdný øetìzec.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE',     'Vyberte metodu logování');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_DESC',     'Logování odmítnutých komentáøù mùže probíhat buï do databáze nebo do textového souboru.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_FILE', 'Soubor (viz "Umístìní logu" níže)');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_DB', 'Databáze');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_NONE', 'Nelogovat');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_REASON', 'Odchyceno pluginem Bayes');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_ERROR', 'Odmítnuto jako spam.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MODERATE', 'Pravdìpodobnì se jedná o spam. Pøíspìvek byl pøedložen ke schválení.');

// Next lines were translated on 2009/12/29

@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RATING_EXPLANATION',     'Riziko spamu podle pluginu Spambock-Bayes.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_DELETE',     'Smazat komentáø a oznaèit jako spam');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_APPROVE',     'Odsouhlasit komentáø a oznaèit jako platný');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_PATH',     'Cesta k pluginu');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_PATH_DESC',     'Pokud je zde cesta zadána, není nadále rozpoznávána dynamicky. To má významný vliv na výkon pluginu. Pøíklad: http://www.priklad.cz/plugins/serendipity_event_spamblock_bayes/ (na konci musí být lomítko "/" ).');

// Next lines were translated on 2010/03/07

@define('PLUGIN_EVENT_SPAMBLOCK_METHOD',     'Zacházení se spamem');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_MODERATE',     'Vlastní schvalování');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_MODERATE_DESC',     'Pøi vlastním módu schvalovat pøi hodnocení vìtším než? (v %)');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_BLOCK',     'Vlastní odmítnutí');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_BLOCK_DESC',     'Pøi vlastním módu odmítnout pøi hodnocení vyšším než? (v %)');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_MODERATE',     'Schvalovat');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_BLOCK',     'Odmítnout');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_CUSTOM',     'Vlastní nastavení');

// Next lines were translated on 2010/04/24

@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAMBUTTON',     'Oznaèit vybrané komentáøe jako spam');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_LEARN',     'Uèit se');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_DATABASE',     'Databáze');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_RECYCLER',     'Koš');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_CREATEDB',     'Vytvoøit databázi');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LEARNOLD',     'Uèit se ze starších');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_ERASEDB',     'Vymazat databázi');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_SAVEDVALUES',     'Hodnocené komentáøe');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU',     'Menu');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_DESC',     'Odkaz na rozšíøené menu v administraèní sekci.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DESC',     'Mají se zablokované komentáøe ukládat do koše?');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_EMPTY',     'Vyprázdnit koš');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RESTORE',     'Obnovit');

// Next lines were translated on 2010/09/12

@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_HAMBUTTON',     'Ozaèit jako platné');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_ANALYSIS',     'Analýza');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DELETE',     'Pøemostìní koše');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DELETE_DESC',     'Komentáøe s hodnocením vìtším nebo rovném než je tato hodnota nebudou zahozeny do koše, nýbrž rovnou smazány. Pøíklad: 98');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IGNORE',     'Ignorovat');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IGNORE_DESC',     'Zadejte pole komentáøe, které budou ignorovány. Možné hodnoty: ip, referer, author, body, email, url. Pøíklad: "ip, referer".');

// Next lines were translated on 2010/11/26

@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_EXPORTDB',     'Export databáze');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IMPORTDB',     'Import databáze');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IMPORT_EXPLANATION',     'Iportovat døíve vygenerovaný CSV soubory. Naètená data filtru budou pøidána do databáze.');

// Next lines were translated on 2012/01/11
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_IMPORT',     'Import');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_EXPLANATION',     'Mùžete importovat databázi spamu z jiného blogu. Zaregistrujte se a ostatní blogy se budou uèit z vaší databáze spamu.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA',     'Online Import');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_IMPORT',     'Import');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_REGISTER',     'Pøidat tento blog');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_REMOVE',     'Odstranit tento blog');