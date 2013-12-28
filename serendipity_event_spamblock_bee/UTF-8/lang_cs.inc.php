<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2013/03/31
 */
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_TITLE', 'Spamblock Bee (Honeypot, Skrytá Captcha)');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_DESC',  'Implementuje jednoduché ale velmi účinné antispamové algoritmy.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_EXTRA_DESC',  '<strong>Tip k instalaci</strong>: Je důležité umístit tento plugin na začátek seznamu pluginů. Pak bude nejefektivnější.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_PATH', 'Cesta k pluginům');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_PATH_DESC', 'V běžných instalacích je výchozí nastavení správně.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS', 'Povinná políčka komentářů');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS_DESC', 'Zadejte seznam políček, která musejí být komentujícím povinně vyplněna. Jednotlivá políčka oddělujte čárkou ",". Použít můžete: name, email, url, replyTo, comment');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REASON_REQUIRED_FIELD', 'Nevyplnil jsi políčko %s!');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_TITLE', 'Odmítnout komentáře, které obsahují pouze nadpis příspěvku');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_TITLE_DESC', 'Některé spamboty se snaží pouze vložit odkaz a vytvářejí obsah komentáře pouze podle toho, co najdou v titulku stránky. Žádný živý čtenář to nědělá, je tedy bezpečné tuto volbu zapnout.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_SAMEBODY', 'Odmítnout komentáře, jejichž text už existuje');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_SAMEBODY_DESC', 'To zamezí vícenásobnému vložení téhož komentáře, třeba když čtenář stiskne "reload" po vložení komentáře. Tyto duplicity mohou být bezpečně odmítnuté.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_ERROR_BODY', 'Spamová ochrana: Neplatná zpráva.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SECTION_LOGGING', 'Soubory a logování');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SECTION_ADVANCED', 'Pokročilé nastavení kryptogramů Captcha');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT', 'Použít Honeypot');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT_DESC', '"Honeypot" (v doslovném překladu "hrnec s medem") je skryté políčko komentáře, které by tudíž mělo zůstat vždy prázdné. Ale protože spamboty vplňují často všechna políčka, která najdou, je toto jednoduchý způsob, jak je odhalit. (Tímto je necháte "sednout na lep") Zapnutí této volby nepředstavuje vůbec žádné riziko pro běžné uživatele, ale účinnost proti spambotům představuje velkou výhodu! Aby byl Honeypot co nejfektivnější, umístěte ho před ostatní antispamové pluginy.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_WARN_HONEPOT', 'Nechceš mi dát svoje číslo, že? ;)');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HCAPTCHA', 'Použít skryté kryptogramy');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HCAPTCHA_DESC', 'Toto nastavení vyrobí kryt´ptogram, který dokážou živí lidé lehce vyřešit, ale ne tak spampoty. Pokud má čtenář zapnutý Javascript, odpověď bude vyplněna automaticky a skryta. A protože spampoty často Javacript neumí, je to další pěkná past, která je ale skryta před živými čtenáři.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_ERROR_HCAPTCHA', 'Spamová ochrana: Špatný kryptogram (Captcha).');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE', 'Typ spam logu');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DESC', 'Kam se mají zapisovat logy o spamu nalezeném pluginem Spamblock Bee?');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_NONE', 'Nelogovat');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_FILE', 'Textový soubor');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DATABASE', 'Databázová tabulka');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE', 'Logovací soubor');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE_DESC', 'Kam uložit logovací soubor, pokud je použit pro logování spamu?');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_OFF', 'Vypnuto');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_MODERATE', 'Schvalovat komentáře');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_REJECT', 'Odmítnout komentáře');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_DEFAULT', 'Výchozí');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_JSON', 'JSON');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_SMARTY', 'Smarty');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_SMARTY_ENC', 'Smarty + šifrování');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QT_MATH', 'Matematické rovnice');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QT_CUSTOM', 'Libovolné otázky');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DESC', 'Pokročilé nastavení pro skryté kryptogramy. Pokud jsou vypnuty, můžete tuto část nastavení v klidu ignorovat.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWER_RETRIEVAL', 'Způsob získání odpovědi');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWER_RETRIEVAL_DESC', 'Vyberte si, jak se má získat správná odpověď na kryptogram. Pokud vyberete "JSON", pak se budou posílat Ajaxové požadavky na index.php/plugin/spamblockbeecaptcha. "Smarty" poskytne odpověď pomocí proměnné Smarty {$beeCaptchaAnswer}, zatímco "Výchozí" ji natvrdo vepíše do stránky. POZNÁMKA: Pokud je vybráno "Smarty", nebude do stránky vloženo žádné další CSS nebo JavaScript. Musíte se sami postarat o správné vyplnění políčka a jeho skrytí. "Smarty + šifrování" je v principu stejné nastavení jako "Smarty" s tím rozdílem, že odpověď uložená v {$beeCaptchaAnswer} je zašifrovaná jednoduchou XOR šifrou. Proměnná {$beeCaptchaScrambleKey} obsahuje dešifrovací klíč.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTION_TYPE', 'Typ otázky');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTION_TYPE_DESC', 'Spamblock Bee umí automaticky vytvářet jednoduché matematické problémy, nebo si můžete zadat vlastní sadu otázek a odpovědí. Vyberte si možnost, která vám více vyhovuje.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTIONS', 'Vlastní otázky');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DEFAULT_QUESTIONS', "Otázka1\nOtázka2");
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTIONS_DESC', 'Pokud chcete pro kryptogramy použít vlastní otázky, zapiště je sem. Pište jednu otázku na jednu řádku. Předtím než může čtenář poslat komentář, bude muset zodpovědět jednu náhodně vybranou otázku.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWERS', 'Odpovědi na vlastní otázky');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWERS_DESC', 'Toto políčko obsahuje správné odpovědi na otázky zadané výše. Pište jednu odpověď na jednu řádku ve stejném pořadí jako otázky. Otázky, které nemají odpověď, budou ignorovány. Všechny odpovědi nerozlišují velikost písmen (tedy "odpověď" je to samé, co "OdpověĎ").');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DEFAULT_ANSWERS', "Odpověď1\nOdpověď2");
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_USE_REGEXP', 'Použít regulární výrazy');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_USE_REGEXP_DESC', 'Mají se odpovědi vyhodnocovat jako regulární výrazy (PCRE = Perl compatible regular expressions)? Tato metoda může být použita pro zadání více správných odpovědí k jedné otázce. Každá řádka s odpovědí by měla být ve tvaru /pattern/:answer. POZNÁMKA: Povolte tuto možnost, jen pokud opravdu víte, co děláte. Vyplnění špatného regulárního výrazu má za následek selhání kontroly odpovědi a v některých řídkých případech Vás může i vystavit tzv. útoku Denial of Service! Odpovědi delší než 1000 znaků budou odmítnuty, pokud je zapnuto ověřování pomocí regulárních výrazů.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_0', 'nula');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_1', 'jedna');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_2', 'dva');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_3', 'tři');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_4', 'čtyři');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_5', 'pět');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_6', 'šest');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_7', 'sedm');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_8', 'osm');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_9', 'devět');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_10', 'deset');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_PLUS', 'plus');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_MINUS', 'mínus');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_QUEST', 'Kolik je');

@define('PLUGIN_SPAMBLOCK_BEE_TITLE', 'Spam report');
@define('PLUGIN_SPAMBLOCK_BEE_DESC', 'Vypíše statistiku o komentářovém spamu, pokud plugin ukládá logy do databáze.');
@define('PLUGIN_SPAMBLOCK_BEE_DAYS', 'Zobrazit dny');
@define('PLUGIN_SPAMBLOCK_BEE_DAYS_DESC', 'Můžete si nechat vypsat report o událostech, které se staly během posledních X dní. Můžete nastavit více než jeden den, jednotlivé dny oddělujte čárkou.');
@define('PLUGIN_SPAMBLOCK_BEE_DBSEARCHES', 'Databázové vyhledávání');
@define('PLUGIN_SPAMBLOCK_BEE_DBSEARCHES_DESC', 'Tento plugin prochází databázovou tabulku "spamblocklog", ze které vytváří report. Můžete zde zadat různá vyhledávání, která chcete provést. Jedna řádka je jedno vyhledávání. Řádka by měla vypadat "VášNázevVyhledávání:VyhledávanýŘetězec". Můžete použít zástupný znak %. Například "BayesPlugin:%Bayes%" spočítá všechny příspěvky, které mají text "Bayes" kdekoliv v nadpisu, a vypíše je v postranním sloupci jako "BayesPlugin".');
@define('PLUGIN_SPAMBLOCK_BEE_LOGGEDIN', 'Pouze pro přihlášené uživatele');
@define('PLUGIN_SPAMBLOCK_BEE_LOGGEDIN_DESC', 'Pokud je zapnuto, postranní sloupec bude viditelný pouze přihlášeným uživatelům (autorům) Vašeho blogu.');
@define('PLUGIN_SPAMBLOCK_BEE_CACHEMINS', 'Cachovat report');
@define('PLUGIN_SPAMBLOCK_BEE_CACHEMINS_DESC', 'Vytváření reportu zatěžuje databázi, takže byste ho neměli vytvářet při každém načtení stránky, ale report by měl být cachován. Zde nastavíte čas mezi jednotlivými aktualizacemi reportu.');
@define('PLUGIN_SPAMBLOCK_BEE_TODAY', 'Dnes:');
@define('PLUGIN_SPAMBLOCK_BEE_LAST_X_DAYS', 'Posledních %d dní:');