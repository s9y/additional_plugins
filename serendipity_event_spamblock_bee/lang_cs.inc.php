<?php # lang_cs.inc.php 1.0 2013-03-31 16:22:10 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2013/03/31
 */
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_TITLE', 'Spamblock Bee (Honeypot, Skrytá Captcha)');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_DESC',  'Implementuje jednoduché ale velmi úèinné antispamové algoritmy.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_EXTRA_DESC',  '<strong>Tip k instalaci</strong>: Je dùležité umístit tento plugin na zaèátek seznamu pluginù. Pak bude nejefektivnìjší.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_PATH', 'Cesta k pluginùm');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_PATH_DESC', 'V bìžných instalacích je výchozí nastavení správnì.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS', 'Povinná políèka komentáøù');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS_DESC', 'Zadejte seznam políèek, která musejí být komentujícím povinnì vyplnìna. Jednotlivá políèka oddìlujte èárkou ",". Použít mùžete: name, email, url, replyTo, comment');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REASON_REQUIRED_FIELD', 'Nevyplnil jsi políèko %s!');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_TITLE', 'Odmítnout komentáøe, které obsahují pouze nadpis pøíspìvku');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_TITLE_DESC', 'Nìkteré spamboty se snaží pouze vložit odkaz a vytváøejí obsah komentáøe pouze podle toho, co najdou v titulku stránky. Žádný živý ètenáø to nìdìlá, je tedy bezpeèné tuto volbu zapnout.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_SAMEBODY', 'Odmítnout komentáøe, jejichž text už existuje');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_SAMEBODY_DESC', 'To zamezí vícenásobnému vložení téhož komentáøe, tøeba když ètenáø stiskne "reload" po vložení komentáøe. Tyto duplicity mohou být bezpeènì odmítnuté.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_ERROR_BODY', 'Spamová ochrana: Neplatná zpráva.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SECTION_LOGGING', 'Soubory a logování');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SECTION_ADVANCED', 'Pokroèilé nastavení kryptogramù Captcha');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT', 'Použít Honeypot');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT_DESC', '"Honeypot" (v doslovném pøekladu "hrnec s medem") je skryté políèko komentáøe, které by tudíž mìlo zùstat vždy prázdné. Ale protože spamboty vplòují èasto všechna políèka, která najdou, je toto jednoduchý zpùsob, jak je odhalit. (Tímto je necháte "sednout na lep") Zapnutí této volby nepøedstavuje vùbec žádné riziko pro bìžné uživatele, ale úèinnost proti spambotùm pøedstavuje velkou výhodu! Aby byl Honeypot co nejfektivnìjší, umístìte ho pøed ostatní antispamové pluginy.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_WARN_HONEPOT', 'Nechceš mi dát svoje èíslo, že? ;)');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HCAPTCHA', 'Použít skryté kryptogramy');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HCAPTCHA_DESC', 'Toto nastavení vyrobí kryt´ptogram, který dokážou živí lidé lehce vyøešit, ale ne tak spampoty. Pokud má ètenáø zapnutý Javascript, odpovìï bude vyplnìna automaticky a skryta. A protože spampoty èasto Javacript neumí, je to další pìkná past, která je ale skryta pøed živými ètenáøi.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_ERROR_HCAPTCHA', 'Spamová ochrana: Špatný kryptogram (Captcha).');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE', 'Typ spam logu');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DESC', 'Kam se mají zapisovat logy o spamu nalezeném pluginem Spamblock Bee?');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_NONE', 'Nelogovat');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_FILE', 'Textový soubor');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DATABASE', 'Databázová tabulka');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE', 'Logovací soubor');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE_DESC', 'Kam uložit logovací soubor, pokud je použit pro logování spamu?');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_OFF', 'Vypnuto');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_MODERATE', 'Schvalovat komentáøe');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_REJECT', 'Odmítnout komentáøe');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_DEFAULT', 'Výchozí');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_JSON', 'JSON');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_SMARTY', 'Smarty');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_SMARTY_ENC', 'Smarty + šifrování');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QT_MATH', 'Matematické rovnice');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QT_CUSTOM', 'Libovolné otázky');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DESC', 'Pokroèilé nastavení pro skryté kryptogramy. Pokud jsou vypnuty, mùžete tuto èást nastavení v klidu ignorovat.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWER_RETRIEVAL', 'Zpùsob získání odpovìdi');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWER_RETRIEVAL_DESC', 'Vyberte si, jak se má získat správná odpovìï na kryptogram. Pokud vyberete "JSON", pak se budou posílat Ajaxové požadavky na index.php/plugin/spamblockbeecaptcha. "Smarty" poskytne odpovìï pomocí promìnné Smarty {$beeCaptchaAnswer}, zatímco "Výchozí" ji natvrdo vepíše do stránky. POZNÁMKA: Pokud je vybráno "Smarty", nebude do stránky vloženo žádné další CSS nebo JavaScript. Musíte se sami postarat o správné vyplnìní políèka a jeho skrytí. "Smarty + šifrování" je v principu stejné nastavení jako "Smarty" s tím rozdílem, že odpovìï uložená v {$beeCaptchaAnswer} je zašifrovaná jednoduchou XOR šifrou. Promìnná {$beeCaptchaScrambleKey} obsahuje dešifrovací klíè.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTION_TYPE', 'Typ otázky');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTION_TYPE_DESC', 'Spamblock Bee umí automaticky vytváøet jednoduché matematické problémy, nebo si mùžete zadat vlastní sadu otázek a odpovìdí. Vyberte si možnost, která vám více vyhovuje.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTIONS', 'Vlastní otázky');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DEFAULT_QUESTIONS', "Otázka1\nOtázka2");
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTIONS_DESC', 'Pokud chcete pro kryptogramy použít vlastní otázky, zapištì je sem. Pište jednu otázku na jednu øádku. Pøedtím než mùže ètenáø poslat komentáø, bude muset zodpovìdìt jednu náhodnì vybranou otázku.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWERS', 'Odpovìdi na vlastní otázky');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWERS_DESC', 'Toto políèko obsahuje správné odpovìdi na otázky zadané výše. Pište jednu odpovìï na jednu øádku ve stejném poøadí jako otázky. Otázky, které nemají odpovìï, budou ignorovány. Všechny odpovìdi nerozlišují velikost písmen (tedy "odpovìï" je to samé, co "OdpovìÏ").');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DEFAULT_ANSWERS', "Odpovìï1\nOdpovìï2");
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_USE_REGEXP', 'Použít regulární výrazy');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_USE_REGEXP_DESC', 'Mají se odpovìdi vyhodnocovat jako regulární výrazy (PCRE = Perl compatible regular expressions)? Tato metoda mùže být použita pro zadání více správných odpovìdí k jedné otázce. Každá øádka s odpovìdí by mìla být ve tvaru /pattern/:answer. POZNÁMKA: Povolte tuto možnost, jen pokud opravdu víte, co dìláte. Vyplnìní špatného regulárního výrazu má za následek selhání kontroly odpovìdi a v nìkterých øídkých pøípadech Vás mùže i vystavit tzv. útoku Denial of Service! Odpovìdi delší než 1000 znakù budou odmítnuty, pokud je zapnuto ovìøování pomocí regulárních výrazù.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_0', 'nula');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_1', 'jedna');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_2', 'dva');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_3', 'tøi');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_4', 'ètyøi');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_5', 'pìt');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_6', 'šest');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_7', 'sedm');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_8', 'osm');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_9', 'devìt');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_10', 'deset');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_PLUS', 'plus');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_MINUS', 'mínus');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_QUEST', 'Kolik je');

@define('PLUGIN_SPAMBLOCK_BEE_TITLE', 'Spam report');
@define('PLUGIN_SPAMBLOCK_BEE_DESC', 'Vypíše statistiku o komentáøovém spamu, pokud plugin ukládá logy do databáze.');
@define('PLUGIN_SPAMBLOCK_BEE_DAYS', 'Zobrazit dny');
@define('PLUGIN_SPAMBLOCK_BEE_DAYS_DESC', 'Mùžete si nechat vypsat report o událostech, které se staly bìhem posledních X dní. Mùžete nastavit více než jeden den, jednotlivé dny oddìlujte èárkou.');
@define('PLUGIN_SPAMBLOCK_BEE_DBSEARCHES', 'Databázové vyhledávání');
@define('PLUGIN_SPAMBLOCK_BEE_DBSEARCHES_DESC', 'Tento plugin prochází databázovou tabulku "spamblocklog", ze které vytváøí report. Mùžete zde zadat rùzná vyhledávání, která chcete provést. Jedna øádka je jedno vyhledávání. Øádka by mìla vypadat "VášNázevVyhledávání:VyhledávanýØetìzec". Mùžete použít zástupný znak %. Napøíklad "BayesPlugin:%Bayes%" spoèítá všechny pøíspìvky, které mají text "Bayes" kdekoliv v nadpisu, a vypíše je v postranním sloupci jako "BayesPlugin".');
@define('PLUGIN_SPAMBLOCK_BEE_LOGGEDIN', 'Pouze pro pøihlášené uživatele');
@define('PLUGIN_SPAMBLOCK_BEE_LOGGEDIN_DESC', 'Pokud je zapnuto, postranní sloupec bude viditelný pouze pøihlášeným uživatelùm (autorùm) Vašeho blogu.');
@define('PLUGIN_SPAMBLOCK_BEE_CACHEMINS', 'Cachovat report');
@define('PLUGIN_SPAMBLOCK_BEE_CACHEMINS_DESC', 'Vytváøení reportu zatìžuje databázi, takže byste ho nemìli vytváøet pøi každém naètení stránky, ale report by mìl být cachován. Zde nastavíte èas mezi jednotlivými aktualizacemi reportu.');
@define('PLUGIN_SPAMBLOCK_BEE_TODAY', 'Dnes:');
@define('PLUGIN_SPAMBLOCK_BEE_LAST_X_DAYS', 'Posledních %d dní:');