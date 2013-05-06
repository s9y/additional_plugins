<?php # lang_cz.inc.php 1.7 2013-05-05 10:47:30 VladaAjgl $

/**
 *  @version 1.7
 *  @author VladimĂ­r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/08/08
 *  @author VladimĂ­r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/08/15
 *  @author VladimĂ­r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/08/25
 *  @author VladimĂ­r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/09/28
 *  @author VladimĂ­r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/03/09
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/01/11
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/03/31
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/05/05
 */
@define('PLUGIN_TWITTER_TITLE',                         'Twitter');
@define('PLUGIN_TWITTER_DESC',                          'Zobrazuje Vaše nejnovější příspěvky z Twitteru');
@define('PLUGIN_TWITTER_NUMBER',                        'Počet příspěvků');
@define('PLUGIN_TWITTER_NUMBER_DESC',                   'Kolik příspěvků z Twitteru má být zobrazeno? (Výchozí: 10)');
@define('PLUGIN_TWITTER_TOALL_ONLY',                    'Pouze tweety adresované všem');
@define('PLUGIN_TWITTER_TOALL_ONLY_DESC',               'Pokud je zapnuto, nebudou se zobrazovat tweety, které obsahují zavináč "@" (pouze v PHP verzi)');
@define('PLUGIN_TWITTER_SERVICE',                       'Služba');
@define('PLUGIN_TWITTER_SERVICE_DESC',                  'Vyberte mikroblogovací službu, kterou používáte');
@define('PLUGIN_TWITTER_USERNAME',                      'Uživatelské jméno');
@define('PLUGIN_TWITTER_USERNAME_DESC',                 'Pokud máte adresu http://www.twitter.com/ptak_jarabak, pak je Vaše uživatelské jméno ptak_jarabak. Můžete použít i přihlašovací jméno k indenti.ca.');
@define('PLUGIN_TWITTER_SHOWFORMAT',                    'Výstupní formát');
@define('PLUGIN_TWITTER_SHOWFORMAT_DESC',               'Můžete si vybrat mezi Javascriptem a PHP. Týká se vlastního zobrazení příspěvků v postranním bloku na blogu. Pozor! - JavaScript nebude fungovat s více instancemi pluginu na jedné stránce. Musíte použít PHP verzi, pokud ho tak chcete nastavit.');
@define('PLUGIN_TWITTER_SHOWFORMAT_RADIO_JAVASCRIPT',   'Javascript');
@define('PLUGIN_TWITTER_SHOWFORMAT_RADIO_PHP',          'PHP');

@define('PLUGIN_TWITTER_CACHETIME',                     'Jak dlouho cachovat data (pouze pro PHP formát)');
@define('PLUGIN_TWITTER_CACHETIME_DESC',                'Aby se zamezilo příliš velkému a zbytečnému přenášení dat mezi blogem a Twitterem, mohou se výsledky z Twitteru ukládat do cache. Zde zadejte v sekundách dobu, po které se bude aktualizovat obsah cache podle Twitteru.');
@define('PLUGIN_TWITTER_BACKUP',                        'Zálohovat Tweety? (experimentální funkce, pouze Twitter)');
@define('PLUGIN_TWITTER_BACKUP_DESC',                   'Pokud je povoleno, plugin bude denně stahovat tweety a zálohovat je v databázi blogu (tabulka ' . $serendipity['dbPrefix'] . 'tweets). Vyžaduje PHP5.');

@define('PLUGIN_TWITTER_LINKTEXT',                      'Text odkazů ve tweetech');
@define('PLUGIN_TWITTER_LINKTEXT_DESC',                 'Odkazy nalezené v Tweetech jsou nahrazeny kliknutelným HTML odkazem. Zde nastavte text odkazu. Hodnota $1 bude nahrazena samotným odkazem tak, jak to dělá Twitter.');
@define('PLUGIN_TWITTER_FOLLOWME_LINK',                 'Odkaz "Sledování"');
@define('PLUGIN_TWITTER_FOLLOWME_LINK_DESC',            'Přidává odkaz "sledování" pod časovou osu');
@define('PLUGIN_TWITTER_FOLLOWME_LINK_TEXT',            'Sledování');
@define('PLUGIN_TWITTER_USE_TIME_AGO',                  'Použít pohled zpět v čase');
@define('PLUGIN_TWITTER_USE_TIME_AGO_DESC',             'Pokud je zapnuto, pak bude čas statutu zobrazen jako čas, který uplynul od zadání statutu (tak jak to dělá samotný twitter), jinak bude použít nastavitelný formát data.');

@define('PLUGIN_TWITTER_PROBLEM_TWITTER_ACCESS',        'Problém při přístupu na Twitter. <br />Počkejte chvilku a obnovte stránku...');

// Twitter Event Plugin 

@define('PLUGIN_EVENT_TWITTER_NAME',                    'Mikroblogování (Twitter, Identica)');
@define('PLUGIN_EVENT_TWITTER_DESC',                    'Přidává klienta Twitter/Identica do administrační sekce a stahuje nové tweety a oznámuje nové články na účtu mikroblogu.');

@define('PLUGIN_EVENT_TWITTER_ACCOUNT_NAME',            'Jméno účtu');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_NAME_DESC',       'Jméno účtu, kterým se bude klient na pozadí přihlašovat k mikroblogu.');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_PWD',             'Heslo k účtu');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_PWD_DESC',        'Heslo účtu, kterým se bude klient na pozadí přihlašovat k mikroblogu.');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_TITLE', 'Oznámování článků');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES',       'Oznamovat nové články');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_DESC',  'Pokud je zapnuto, plugin bude oznamovat nové na blogu publikované příspěvky na službě Twitter nebo Identica.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_WITHTTAGS',      'Oznámit s tagy');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_WITHTTAGS_DESC', 'Pokud je nainstalován plugin Free Tag (Klíčová slova), oznamovač článků prohledá nadpis příspěvku, jestli neobsahuje tagy. Pokud nějaký nalezne, budou tyto tagy označené jako tagy twitteru. Vždy můžete přidat tagy ručně pomocí #tags#. Tyto budou naplněny všemi tagy, které ještě nebyly nalezeny v nadpisu příspěvku. To znamená všechny zde zadané tagy budou přidány, pokud volba automatického hledání tagů není zapnuta.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_SERVICE',        'Oznámit URL zkracovač');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_SERVICE_DESC',   'Služba, která má být použita pro zkrácení odkazů při oznamování příspěvku. Doporučené jsou 7ax.de nebo tinyurl.com, protože to jsou zatím jediné známé služby, které fungují společně s tweetbacks.');

@define('PLUGIN_EVENT_TWITTER_TWEETBACKS_TITLE',        'Tweetbacks');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETBACKS',           'Zjišťovat Tweetbacky');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETBACKS_DESC',      'Pokud je zapnuto, plugin se pokusí najít tweetbacky (odezvy twitteru) na články a přidá volbu "zkontrolovat odezvy twitteru" pod rozšířené tělo příspěvku, pokud je návštěvník přihlášený do blogu.');
@define('PLUGIN_EVENT_TWITTER_IGNORE_MYTWEETBACKS',     'Ignorovat moje Tweety');
@define('PLUGIN_EVENT_TWITTER_IGNORE_MYTWEETBACKS_DESC','Pokud nechcete zobrazovat vlastní tweety jako tweetbacky, zapněte tuto volbu. V opačném případě budou oznámení zobrazována jako tweetbacky.');

@define('PLUGIN_EVENT_TWITTER_TWEETBACK_CHECK_FREQ',    'Frekvence kontroly tweetbacků');
@define('PLUGIN_EVENT_TWITTER_TWEETBACK_CHECK_FREQ_DESC','Čas v minutách mezi dvěma kontrolami twitteru. (musí být alespoň 5 minut)');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE',                 'Typ tweetbacku');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_DESC',            'Serendipity nepodporuje sama o sobě tweetbacky. Takže ty musejí být uloženy jako odezvy nebo normální komentáře. Protože přicházejí z vně blogu, jsou jistým type odezvy, ale podle obsahu by patřily spíš mezi komentáře. Rozhodněte sami, jak se mají tweetbacky ukládat.');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_TRACKBACK',       'Odezva');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_COMMENT',         'Komentář');

@define('PLUGIN_EVENT_TWITTER_TWEETER_TITLE',           'Mikroblogovací klient');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SIDEBARTITLE',    'Tweeter');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW',            'Zapnout mikroblogovacího klienta');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_DESC',       'Zapnte tweeter na hlavní stránce administrační sekce, jako postranní sloupec a nebo ho vypne.');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_FRONTPAGE',  'Hlavní stránka');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_SIDEBAR',    'Postranní sloupec');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_DISABLE',    'Vypnout');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY',         'Zobrazit časovou osu');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_DESC',    'Zobrazuje časovou osu s články pod aktualizovaným výpisem.');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_COUNT',   'Délka časové osy');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_COUNT_DESC','Kolik nejnovějších příspěvků  se má zobrazovat na hlavní straně?');

@define('PLUGIN_EVENT_TWITTER_TWEETER_FORM',            'Zadejte tweet:');
@define('PLUGIN_EVENT_TWITTER_TWEETER_CHARSLEFT',       'znaků vlevo');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHORTEN',         'Zkracovat URL adresy');
@define('PLUGIN_EVENT_TWITTER_TWEETER_STORED',          'Tweet uložen ');
@define('PLUGIN_EVENT_TWITTER_TWEETER_STOREFAIL',       'Tweet nemohl být uložen! Chyba Twitteru: ');

@define('PLUGIN_EVENT_TWITTER_GENERAL_TITLE',           'Obecná');
@define('PLUGIN_EVENT_TWITTER_PLUGIN_EVENT_REL_URL',    'Plugin rel. path');
@define('PLUGIN_EVENT_TWITTER_PLUGIN_EVENT_REL_URL_DESC', 'Zadejte celou HTTP cestu (všechno, co následuje po Vašem doménovém jméně), které vede do adresáře s pluginem.');

@define('PLUGIN_EVENT_TWITTER_TWEETER_WARNING',         '<p class="serendipityAdminMsgError">' .
                '<img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png'). '" alt="" />' .
                'UPOZORNĚNÍ: Nalezen nainstalovaný plugin TwitterTweeter.</p>' .
                '<p class="serendipityAdminMsgError">Tento plugin je sloučením pluginu TwitterTweeter a oficiálního starého serendipity pluginu twitter, navíc oba dva pluginy rozšiřuje.Měli byste odinstalovat všechny předchozí pluginy.</p>');

@define('PLUGIN_EVENT_TWITTER_TB_USE_URL',              'URL Tweetbacku');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_DESC',         'Co uložit jako URL adresu tweetbacku? Máte 3 možnosti. Status: url tweetu, který je tweetbackem, Profil: adresa profilu uživatele twitteru nebo WebURL: adresa zadaná uživatelem twitteru v jeho profilu jako Web URL');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_STATUS',       'Status');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_PROFILE',      'Profil');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_WEBURL',       'Web URL');

@define('PLUGIN_EVENT_TWITTER_IDENTITIES',              'Identity');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_IDCOUNT',         'Počet účtů');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_IDCOUNT_DESC',    'Po uložení tohoto nastavení se na této stránce nastavení objeví políčka pro nastavení zde zadaného počtu účtů. Možná budete muset nastavení uložit dvakrát, abyste příslušná zadávací políčka viděli.');
@define('PLUGIN_EVENT_TWITTER_IDENTITY',                'Identita');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE',         'Jméno služby');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_DESC',    'Zadejte, zda je tento účet na twitteru nebo na identi.ca');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_TWITTER', 'twitter');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_IDENTICA','identica');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ACCOUNTS',       'Oznamovací účty');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ACCOUNTS_DESC',  'Vyberte účty, na které se mají oznamovat nové příspěvky');

// Configuration Tabs:

@define('PLUGIN_EVENT_TWITTER_CFGTAB',                  'Konfigurační záložky:');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_IDENTITIES',       'Identity');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_ANNOUNCE',         'Oznamování článků');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETER',          'Mikroblogovací klient');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETBACK',        'Tweetbacky');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_GLOBAL',           'Obecné');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_ALL',              'Všechno');

@define('PLUGIN_EVENT_TWITTER_TWEETER_REPLY',           'Odpovědět pisateli');
@define('PLUGIN_EVENT_TWITTER_TWEETER_RETWEET',         'Retweetovat');
@define('PLUGIN_EVENT_TWITTER_TWEETER_DM',              'Přímá zpráva (Pracuje pouze pokud Vás uživatel sleduje)');

@define('PLUGIN_EVENT_TWITTER_IGNORE_TWEETBACKS_BYNAME','Ignorovat tweetbacky z');
@define('PLUGIN_EVENT_TWITTER_IGNORE_TWEETBACKS_BYNAME_DESC','Čárkami oddělený seznam účtů twitteru, ze kterých nechcete přijímat tweetbacky.');

@define('PLUGIN_TWITTER_EVENT_NOT_INSTALLED',           '<p class="serendipityAdminMsgError">' .
                '<img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png'). '" alt="" />' .
                'VAROVÁNÍ: Plugin událostí pro mikroblogování (twitter/identica) ještě nebyl nainstalován!</p>' .
                '<p class="serendipityAdminMsgError">Hlavní část funkcí twitter/identica je zabezpečována pluginem událostí mikroblogování. Pokud chcete plnou funkčnost pluginu, měli byste ho také nainstalovat
.</p>');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_FORMAT',         'Formát oznámení');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_FORMAT_DESC',    'Zadejte vlastní formát oznamovacích zpráv. Můžete použít následující proměnné. title#: bude nahrazen nadpisem příspěvku (a odpovídajícími tagy); #link#: odkaz na příspěvek; #author#: Autor příspěvku; #tags#: zbývající tagy.');

@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETTHIS',        'Twittni to!');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_TITLE',         'Twittni to!');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETTHIS',            'Povolit "Twittni to!"');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETTHIS_DESC',       'Zapnutí této funkce zobrazí tlačítko "Twittni to!" v patičce příspěvku.');
@define('PLUGIN_EVENT_TWITTER_DO_IDENTICATHIS',         'Zapnout Identica');
@define('PLUGIN_EVENT_TWITTER_DO_IDENTICATHIS_DESC',    'Zapnutí této funkce zobrazí tlačítko "Identica" v patičce příspěvku.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT',        'Formát "Twittni to!"');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_DESC',   'Zadejte formát pro tweety návštěvníků. Měli byste použít následující proměnné. title#: bude nahrazen nadpisem příspěvku (a odpovídajícími tagy); #link#: odkaz na příspěvek; #author#: Autor příspěvku; #tags#: zbývající tagy.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON', 'Styl tlačítek');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_DESC', 'V současnosti je možno vybrat mezi dvěma styly twittovacího tlačítka.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_BLACK', 'černé');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_WHITE', 'bílé');

@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_NEWWINDOW',     '"Twittni to!" v novém okně');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_NEWWINDOW_DESC','Pokud je zapnuto, twitter a identica se natáhnou v novém okně, v aktuálním okně tedy zůstane stále zobrazený blog.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_SMARTIFY',      'Smartyfizce funkce "Twittni to!"');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_SMARTIFY_DESC', 'Pokud je zapnuto, plugin nebude přidávat tlačítko sám o sobě. Místo toho přidá do smarty dvě proměnné: entry.url_tweetthis a entry.url_dentthis. Ty pak lze použít v šabloně. Tyto proměnné obsahují pouze URL adresy, takže můžete vytvořit vlastní text pro tlačítko "Twittni to!", nebo tlačítko umístit například do záhlaví článku.');

@define('PLUGIN_EVENT_TWITTER_BACKEND_DONTANNOUNCE',    'NEoznamovat tento příspěvek pomocí mikroblogovacích služeb');
@define('PLUGIN_EVENT_TWITTER_BACKEND_ENTERDESC',       'Zadejte libovolné tagy, které souvisí s příspěvkem. Více tagů oddělujte čárkou (,). Pokud je zde něco zadáno, tagy pluginu freetag jsou při oznamování ignorovány!');

// Next lines were translated on 2009/08/15

@define('PLUGIN_TWITTER_FILTER_ALL',                    'Žádné uživatelské tweety');
@define('PLUGIN_TWITTER_FILTER_ALL_DESC',               'Pokud je volba zapnuta, nebudou se zobrazovat tweety obsahující @. (pouze v PHP verzi)');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE',             'Schvalování tweetbacků');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE_DESC',        'Jak pracovat s přijatými tweetbacky? Můžete použít obecné nastavení pro komentáře, schvalovat je, nebo je vždy povolit.');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE_DEFAULT',     'Použít obecné nastavení komentářů');

// Next lines were translated on 2009/08/25

@define('PLUGIN_EVENT_TWITTER_SHORTURL_TITLE',          'Zobrazit URL adresu pro tento článek');
@define('PLUGIN_EVENT_TWITTER_SHORTURL_ON_CLICK',       'Tento odkaz není klikací. Obsahuje zkrácenou URL adresu k tomuto příspěvku. Tuto URL adresu můžete použít jako odkaz na tento článek, například v twitteru. Odkaz zkopírujete tak, že kliknete pravým tlačítkem a vyberete "Zkopírovat odkaz" v Internet Exploreru, nebo "Kopírovat adresu odkazu" v Mozille.');
@define('PLUGIN_EVENT_TWITTER_SHOW_SHORTURL',           'Zobrzit krátkou URL adresu pro každý příspěvek');
@define('PLUGIN_EVENT_TWITTER_SHOW_SHORTURL_DESC',      'Bude zobrazovat výchozí krátkou URL v patičce každého článku. Pokud je zapnutá funkce smarty TweetThis, každý příspěvek bude obsahovat proměnnou entry.url_shorturl, která se dá libovolně využít ve smarty šabloně.');

// Next lines were translated on 2010/09/28

@define('PLUGIN_EVENT_TWITTER_CONSUMER_KEY',            'Klíč zákazníka (Consumer key)');
@define('PLUGIN_EVENT_TWITTER_CONSUMER_KEY_DESC',       '"Zákaznický klíč" a "zákaznické heslo" obdržíte od Twitteru poté, co pro svůj blok vytvoříte aplikaci Twitteru.');
@define('PLUGIN_EVENT_TWITTER_CONSUMER_SECRET',         'Zákaznické heslo');
@define('PLUGIN_EVENT_TWITTER_TIMELINE',                'Časová osa statutu');
@define('PLUGIN_EVENT_TWITTER_TIMELINE_DESC',           '');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_OK',           'Připojeno');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_DEL',          'Smazat odkaz');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_DEL_OK',       'Twitter OAuth token odstraněn');
@define('PLUGIN_EVENT_TWITTER_CLOSEWINDOW',             'Zavřít okno');
@define('PLUGIN_EVENT_TWITTER_REGISTER',                'Registrovat');
@define('PLUGIN_EVENT_TWITTER_CALLBACKURL',             'Zpětná URL adresa (zadejte ve Twitteru)');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_ERROR',        'Chyba zpětného volání Twitteru');

// Next lines were translated on 2011/03/09

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_NO',    'Pro oznamování příspěvku je ve výchozím nastavení checkbox odškrtnut');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_NO_DESC','Povolení znamená, že nový příspěvek na blogu musí být výslovně odeslán do twiteru. Vypnutí (výchozí hodnota) znamená, že příspěvek bude do twiteru odeslán automaticky.');

// Next lines were translated on 2012/01/11

@define('PLUGIN_EVENT_TWITTER_SIGN_IN',                 'Klikněte na tlačítko níže a připojte Twitter.<br/>
<p><a style="color:red;">VAROVÁNÍ!</a><br/>
Musíte se přihlásit nebo odhlásit s <b>odpovídajícím účtem Twitteru</b>!<br/>
<a href="#" onclick="window.open(\'http://twitter.com\',\'\',\'width=1000,height=400\'); return false">Potvrďte prosím před připojením</a>.</p>');
@define('PLUGIN_EVENT_TWITTER_SIGNIN',                  'Přihlásit');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET',               'Widget sledování Twitteru');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DESC',          'Pokud plugin zobrazuje časovou osu, můžete povolit widget twitteru pro zobrazování aktuálního počtu followerů a další. Nastavení je ignorováno, pokud zobrazujete z identi.ca.');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_COUNT',         'Počet followerů ve widgetu');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_COUNT_DESC',    'Pokud je povoleno, widget zobrazuje počet followerů.');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DARK',          'Widget sledování Twitter na tmavém pozadí');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DARK_DESC',     'Pokud Vaše šablona používá tmavé pozadí, měli byste toto povolit.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYDESC',      '<h3>uživatelské jméno bit.ly a API klíč</h3><b>bit.ly</b> a <b>j.mp</b> zkracovače URL adres potřebují přihlašovací jméno k bit.ly a API klíč. Pokud ani jeden z těchto zkracovačů nepoužíváte, neměli byste je potřebovat.<br/>Výchozí klíč většinou nefunguje, protože je to demo klíč a jeho kvóta je pravidelně přečerpána. Pokud máte účet na bit.ly account, měli byste zadat vlastní přihlašovací údaje.<br/><a href="http://bitly.com/a/your_api_key/" target="_blank">Najdete je tady</a>.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYLOGIN',     'Uživatelské jméno bit.ly');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYAPIKEY',    'bit.ly API klíč');
@define('PLUGIN_EVENT_TWITTER_GENERALCONSUMER',         '<h3>Vlastní twitter klient</h3>Ve výchozím nastavení používá plugin klienta \'s9y\'. Můžete si <a href="https://dev.twitter.com/apps" target="_blank">zaregistrovat vlastního klienta</a> a nastavit consumer klíč a heslo vašeho klienta.');

// Next lines were translated on 2013/03/31

@define('PLUGIN_EVENT_TWITTER_TWEETER_UPDATE',           'Update');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_PIRATLYDESC',     '<h3>pirat.ly API token</h3>Pro zkrácené odkaz <b>pirat.ly</b> můžete <a href="http://pirat.ly/account" target="_blank">získat API token tím, že se zdarma registrujete na službě piratly</a>. Použitím tohoto API tokenu při oznamování Vašich příspěvků můžete prohlížet počty prokliků buď pomocí webového rozhraní nebo na zařízení s Androidem pomocí <a href="http://pirat.ly/shortenerrr" target="_blank">aplikace Shortenerrr</a>.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_PIRATLYAPIKEY',   'Váš osobní piratly API token');
@define('PLUGIN_TWITTER_FILTER_RT',                      'FIltrovat nativní retweety');
@define('PLUGIN_TWITTER_FILTER_RT_DESC',                 'Mají se filtrovat nativní retweety? (pouze pro Twitter API 1.1; API 1.0 filtruje vždy)');
@define('PLUGIN_TWITTER_API11',                          'Použít OAuth Twitter API 1.1');
@define('PLUGIN_TWITTER_API11_DESC',                     'Twitter API 1.0 je zastaralé a během roku 2013 bude úplně zrušeno. Měli byste se tedy přepnout na API 1.1. Nicméně to vyžaduje, abyste nastavili alespoň jedno OAuth propojení v hlavním mikroblogovacím pluginu. Pokud v políčku níže najdete nějaký účet, už jste to udělali.');
@define('PLUGIN_TWITTER_OAUTHACC',                       'OAuth účet, který se má použít tímto pluginem');
@define('PLUGIN_TWITTER_OAUTHACC_DESC',                  'Nové OAuth Twitter API je třeba volat pomocí OAuthorzied Twitter účtu. Tento účet bude také použit pro omezení přístupu. Můžete použít libovolný účet, který vlastníte, třeba účet, který nikde jinde nepoužíváte, například abyste měli pro tento plugin samostatný limit přístupu.');
@define('PLUGIN_EVENT_TWITTER_API_TYPE',                 'Verze Twitter API');
@define('PLUGIN_EVENT_TWITTER_API_TYPE_DESC',            'Twitter API 1.0 je zastaralé a během roku 2013 bude úplně zrušeno. Měli byste se tedy přepnout na API 1.1. Nicméně to vyžaduje, abyste nastavili alespoň jedno OAuth propojení (nastavení identity/uživatele)');
@define('PLUGIN_EVENT_TWITTER_API_10',                   'API 1.0 [zastaralé]');
@define('PLUGIN_EVENT_TWITTER_API_11',                   'API 1.1 OAuth');