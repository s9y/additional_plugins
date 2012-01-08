<?php # lang_cs.inc.php 1.5 2010-11-26 18:34:41 VladaAjgl $

/**
 *  @version 1.5
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
 */

@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME',     'Spamblock (Bayes)');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_DESC',     'Detekce spamu pomocí adaptivního algoritmu, který se dokáže sám učit.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_HAM',      'V pořádku');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAM',     'Spam');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_AUTOLEARN',     'Učit se');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_AUTOLEARN_DESC',     'Komentáře, který velmi pravděpodobně obsahují spam jsou použity k učení pro detekci dalšího spamu. Tímto způsobem se algoritmus automaticky lehce učí.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGFILE',     'Umístění logu');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGFILE_DESC',     'Oznámení o zamítnutých/schvalovaných příspěvcích mohou být zapisovány do logu. Pokud chcete vypnout logování, zadejte prázdný řetězec.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE',     'Vyberte metodu logování');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_DESC',     'Logování odmítnutých komentářů může probíhat buď do databáze nebo do textového souboru.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_FILE', 'Soubor (viz "Umístění logu" níže)');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_DB', 'Databáze');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_NONE', 'Nelogovat');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_REASON', 'Odchyceno pluginem Bayes');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_ERROR', 'Odmítnuto jako spam.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MODERATE', 'Pravděpodobně se jedná o spam. Příspěvek byl předložen ke schválení.');

// Next lines were translated on 2009/12/29

@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RATING_EXPLANATION',     'Riziko spamu podle pluginu Spambock-Bayes.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_DELETE',     'Smazat komentář a označit jako spam');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_APPROVE',     'Odsouhlasit komentář a označit jako platný');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_PATH',     'Cesta k pluginu');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_PATH_DESC',     'Pokud je zde cesta zadána, není nadále rozpoznávána dynamicky. To má významný vliv na výkon pluginu. Příklad: http://www.priklad.cz/plugins/serendipity_event_spamblock_bayes/ (na konci musí být lomítko "/" ).');

// Next lines were translated on 2010/03/07

@define('PLUGIN_EVENT_SPAMBLOCK_METHOD',     'Zacházení se spamem');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_MODERATE',     'Vlastní schvalování');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_MODERATE_DESC',     'Při vlastním módu schvalovat při hodnocení větším než? (v %)');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_BLOCK',     'Vlastní odmítnutí');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_BLOCK_DESC',     'Při vlastním módu odmítnout při hodnocení vyšším než? (v %)');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_MODERATE',     'Schvalovat');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_BLOCK',     'Odmítnout');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_CUSTOM',     'Vlastní nastavení');

// Next lines were translated on 2010/04/24

@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAMBUTTON',     'Označit vybrané komentáře jako spam');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_LEARN',     'Učit se');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_DATABASE',     'Databáze');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_RECYCLER',     'Koš');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_CREATEDB',     'Vytvořit databázi');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LEARNOLD',     'Učit se ze starších');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_ERASEDB',     'Vymazat databázi');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_SAVEDVALUES',     'Hodnocené komentáře');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU',     'Menu');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_DESC',     'Odkaz na rozšířené menu v administrační sekci.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DESC',     'Mají se zablokované komentáře ukládat do koše?');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_EMPTY',     'Vyprázdnit koš');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RESTORE',     'Obnovit');

// Next lines were translated on 2010/09/12

@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_HAMBUTTON',     'Ozačit jako platné');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_ANALYSIS',     'Analýza');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DELETE',     'Přemostění koše');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DELETE_DESC',     'Komentáře s hodnocením větším nebo rovném než je tato hodnota nebudou zahozeny do koše, nýbrž rovnou smazány. Příklad: 98');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IGNORE',     'Ignorovat');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IGNORE_DESC',     'Zadejte pole komentáře, které budou ignorovány. Možné hodnoty: ip, referer, author, body, email, url. Příklad: "ip, referer".');

// Next lines were translated on 2010/11/26
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_EXPORTDB',     'Export databáze');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IMPORTDB',     'Import databáze');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IMPORT_EXPLANATION',     'Iportovat dříve vygenerovaný CSV soubory. Načtená data filtru budou přidána do databáze.');