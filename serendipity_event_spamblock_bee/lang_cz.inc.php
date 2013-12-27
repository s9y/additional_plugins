/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2013/03/31
 */
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_TITLE', 'Spamblock Bee (Honeypot, Skrytá Captcha)');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_DESC',  'Implementuje jednoduché ale velmi úèinné antispamové algoritmy.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_EXTRA_DESC',  '<strong>Tip k instalaci</strong>: Je dùle¾ité umístit tento plugin na zaèátek seznamu pluginù. Pak bude nejefektivnìj¹í.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_PATH', 'Cesta k pluginùm');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_PATH_DESC', 'V bì¾ných instalacích je výchozí nastavení správnì.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS', 'Povinná políèka komentáøù');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS_DESC', 'Zadejte seznam políèek, která musejí být komentujícím povinnì vyplnìna. Jednotlivá políèka oddìlujte èárkou ",". Pou¾ít mù¾ete: name, email, url, replyTo, comment');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REASON_REQUIRED_FIELD', 'Nevyplnil jsi políèko %s!');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_TITLE', 'Odmítnout komentáøe, které obsahují pouze nadpis pøíspìvku');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_TITLE_DESC', 'Nìkteré spamboty se sna¾í pouze vlo¾it odkaz a vytváøejí obsah komentáøe pouze podle toho, co najdou v titulku stránky. ®ádný ¾ivý ètenáø to nìdìlá, je tedy bezpeèné tuto volbu zapnout.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_SAMEBODY', 'Odmítnout komentáøe, jejich¾ text u¾ existuje');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_SAMEBODY_DESC', 'To zamezí vícenásobnému vlo¾ení tého¾ komentáøe, tøeba kdy¾ ètenáø stiskne "reload" po vlo¾ení komentáøe. Tyto duplicity mohou být bezpeènì odmítnuté.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_ERROR_BODY', 'Spamová ochrana: Neplatná zpráva.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SECTION_LOGGING', 'Soubory a logování');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SECTION_ADVANCED', 'Pokroèilé nastavení kryptogramù Captcha');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT', 'Pou¾ít Honeypot');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT_DESC', '"Honeypot" (v doslovném pøekladu "hrnec s medem") je skryté políèko komentáøe, které by tudí¾ mìlo zùstat v¾dy prázdné. Ale proto¾e spamboty vplòují èasto v¹echna políèka, která najdou, je toto jednoduchý zpùsob, jak je odhalit. (Tímto je necháte "sednout na lep") Zapnutí této volby nepøedstavuje vùbec ¾ádné riziko pro bì¾né u¾ivatele, ale úèinnost proti spambotùm pøedstavuje velkou výhodu! Aby byl Honeypot co nejfektivnìj¹í, umístìte ho pøed ostatní antispamové pluginy.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_WARN_HONEPOT', 'Nechce¹ mi dát svoje èíslo, ¾e? ;)');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HCAPTCHA', 'Pou¾ít skryté kryptogramy');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HCAPTCHA_DESC', 'Toto nastavení vyrobí kryt´ptogram, který doká¾ou ¾iví lidé lehce vyøe¹it, ale ne tak spampoty. Pokud má ètenáø zapnutý Javascript, odpovìï bude vyplnìna automaticky a skryta. A proto¾e spampoty èasto Javacript neumí, je to dal¹í pìkná past, která je ale skryta pøed ¾ivými ètenáøi.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_ERROR_HCAPTCHA', 'Spamová ochrana: ©patný kryptogram (Captcha).');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE', 'Typ spam logu');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DESC', 'Kam se mají zapisovat logy o spamu nalezeném pluginem Spamblock Bee?');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_NONE', 'Nelogovat');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_FILE', 'Textový soubor');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DATABASE', 'Databázová tabulka');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE', 'Logovací soubor');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE_DESC', 'Kam ulo¾it logovací soubor, pokud je pou¾it pro logování spamu?');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_OFF', 'Vypnuto');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_MODERATE', 'Schvalovat komentáøe');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_REJECT', 'Odmítnout komentáøe');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_DEFAULT', 'Výchozí');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_JSON', 'JSON');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_SMARTY', 'Smarty');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_SMARTY_ENC', 'Smarty + ¹ifrování');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QT_MATH', 'Matematické rovnice');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QT_CUSTOM', 'Libovolné otázky');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DESC', 'Pokroèilé nastavení pro skryté kryptogramy. Pokud jsou vypnuty, mù¾ete tuto èást nastavení v klidu ignorovat.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWER_RETRIEVAL', 'Zpùsob získání odpovìdi');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWER_RETRIEVAL_DESC', 'Vyberte si, jak se má získat správná odpovìï na kryptogram. Pokud vyberete "JSON", pak se budou posílat Ajaxové po¾adavky na index.php/plugin/spamblockbeecaptcha. "Smarty" poskytne odpovìï pomocí promìnné Smarty {$beeCaptchaAnswer}, zatímco "Výchozí" ji natvrdo vepí¹e do stránky. POZNÁMKA: Pokud je vybráno "Smarty", nebude do stránky vlo¾eno ¾ádné dal¹í CSS nebo JavaScript. Musíte se sami postarat o správné vyplnìní políèka a jeho skrytí. "Smarty + ¹ifrování" je v principu stejné nastavení jako "Smarty" s tím rozdílem, ¾e odpovìï ulo¾ená v {$beeCaptchaAnswer} je za¹ifrovaná jednoduchou XOR ¹ifrou. Promìnná {$beeCaptchaScrambleKey} obsahuje de¹ifrovací klíè.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTION_TYPE', 'Typ otázky');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTION_TYPE_DESC', 'Spamblock Bee umí automaticky vytváøet jednoduché matematické problémy, nebo si mù¾ete zadat vlastní sadu otázek a odpovìdí. Vyberte si mo¾nost, která vám více vyhovuje.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTIONS', 'Vlastní otázky');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DEFAULT_QUESTIONS', "Otázka1\nOtázka2");
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTIONS_DESC', 'Pokud chcete pro kryptogramy pou¾ít vlastní otázky, zapi¹tì je sem. Pi¹te jednu otázku na jednu øádku. Pøedtím ne¾ mù¾e ètenáø poslat komentáø, bude muset zodpovìdìt jednu náhodnì vybranou otázku.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWERS', 'Odpovìdi na vlastní otázky');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWERS_DESC', 'Toto políèko obsahuje správné odpovìdi na otázky zadané vý¹e. Pi¹te jednu odpovìï na jednu øádku ve stejném poøadí jako otázky. Otázky, které nemají odpovìï, budou ignorovány. V¹echny odpovìdi nerozli¹ují velikost písmen (tedy "odpovìï" je to samé, co "OdpovìÏ").');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DEFAULT_ANSWERS', "Odpovìï1\nOdpovìï2");
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_USE_REGEXP', 'Pou¾ít regulární výrazy');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_USE_REGEXP_DESC', 'Mají se odpovìdi vyhodnocovat jako regulární výrazy (PCRE = Perl compatible regular expressions)? Tato metoda mù¾e být pou¾ita pro zadání více správných odpovìdí k jedné otázce. Ka¾dá øádka s odpovìdí by mìla být ve tvaru /pattern/:answer. POZNÁMKA: Povolte tuto mo¾nost, jen pokud opravdu víte, co dìláte. Vyplnìní ¹patného regulárního výrazu má za následek selhání kontroly odpovìdi a v nìkterých øídkých pøípadech Vás mù¾e i vystavit tzv. útoku Denial of Service! Odpovìdi del¹í ne¾ 1000 znakù budou odmítnuty, pokud je zapnuto ovìøování pomocí regulárních výrazù.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_0', 'nula');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_1', 'jedna');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_2', 'dva');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_3', 'tøi');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_4', 'ètyøi');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_5', 'pìt');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_6', '¹est');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_7', 'sedm');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_8', 'osm');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_9', 'devìt');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_10', 'deset');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_PLUS', 'plus');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_MINUS', 'mínus');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_QUEST', 'Kolik je');

@define('PLUGIN_SPAMBLOCK_BEE_TITLE', 'Spam report');
@define('PLUGIN_SPAMBLOCK_BEE_DESC', 'Vypí¹e statistiku o komentáøovém spamu, pokud plugin ukládá logy do databáze.');
@define('PLUGIN_SPAMBLOCK_BEE_DAYS', 'Zobrazit dny');
@define('PLUGIN_SPAMBLOCK_BEE_DAYS_DESC', 'Mù¾ete si nechat vypsat report o událostech, které se staly bìhem posledních X dní. Mù¾ete nastavit více ne¾ jeden den, jednotlivé dny oddìlujte èárkou.');
@define('PLUGIN_SPAMBLOCK_BEE_DBSEARCHES', 'Databázové vyhledávání');
@define('PLUGIN_SPAMBLOCK_BEE_DBSEARCHES_DESC', 'Tento plugin prochází databázovou tabulku "spamblocklog", ze které vytváøí report. Mù¾ete zde zadat rùzná vyhledávání, která chcete provést. Jedna øádka je jedno vyhledávání. Øádka by mìla vypadat "Vá¹NázevVyhledávání:VyhledávanýØetìzec". Mù¾ete pou¾ít zástupný znak %. Napøíklad "BayesPlugin:%Bayes%" spoèítá v¹echny pøíspìvky, které mají text "Bayes" kdekoliv v nadpisu, a vypí¹e je v postranním sloupci jako "BayesPlugin".');
@define('PLUGIN_SPAMBLOCK_BEE_LOGGEDIN', 'Pouze pro pøihlá¹ené u¾ivatele');
@define('PLUGIN_SPAMBLOCK_BEE_LOGGEDIN_DESC', 'Pokud je zapnuto, postranní sloupec bude viditelný pouze pøihlá¹eným u¾ivatelùm (autorùm) Va¹eho blogu.');
@define('PLUGIN_SPAMBLOCK_BEE_CACHEMINS', 'Cachovat report');
@define('PLUGIN_SPAMBLOCK_BEE_CACHEMINS_DESC', 'Vytváøení reportu zatì¾uje databázi, tak¾e byste ho nemìli vytváøet pøi ka¾dém naètení stránky, ale report by mìl být cachován. Zde nastavíte èas mezi jednotlivými aktualizacemi reportu.');
@define('PLUGIN_SPAMBLOCK_BEE_TODAY', 'Dnes:');
@define('PLUGIN_SPAMBLOCK_BEE_LAST_X_DAYS', 'Posledních %d dní:');