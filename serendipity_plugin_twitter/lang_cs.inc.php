<?php

/**
 *  @author VladimÃ­r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/08/08
 *  @author VladimÃ­r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/08/15
 *  @author VladimÃ­r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/08/25
 *  @author VladimÃ­r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/09/28
 *  @author VladimÃ­r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/03/09
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/01/11
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/03/31
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/10/26
 */
@define('PLUGIN_TWITTER_TITLE',                         'Twitter');
@define('PLUGIN_TWITTER_DESC',                          'Zobrazuje Vaše nejnovìjší pøíspìvky na Twitteru');
@define('PLUGIN_TWITTER_NUMBER',                        'Poèet pøíspìvkù');
@define('PLUGIN_TWITTER_NUMBER_DESC',                   'Kolik pøíspìvkù z Twitteru má bıt zobrazeno? (Vıchozí: 10)');
@define('PLUGIN_TWITTER_TOALL_ONLY',                    'Pouze tweety adresované všem');
@define('PLUGIN_TWITTER_TOALL_ONLY_DESC',               'Pokud je zapnuto, nebudou se zobrazovat tweety, které obsahují zavináè "@" (pouze v PHP verzi)');
@define('PLUGIN_TWITTER_SERVICE',                       'Sluba');
@define('PLUGIN_TWITTER_SERVICE_DESC',                  'Vyberte mikroblogovací slubu, kterou pouíváte');
@define('PLUGIN_TWITTER_USERNAME',                      'Uivatelské jméno');
@define('PLUGIN_TWITTER_USERNAME_DESC',                 'Pokud máte adresu http://www.twitter.com/ptak_jarabak, pak je Vaše uivatelské jméno ptak_jarabak. Mùete pouít i pøihlašovací jméno k indenti.ca.');
@define('PLUGIN_TWITTER_SHOWFORMAT',                    'Vıstupní formát');
@define('PLUGIN_TWITTER_SHOWFORMAT_DESC',               'Mùete si vybrat mezi Javascriptem a PHP. Tıká se vlastního zobrazení pøíspìvkù v postranním bloku na blogu. Pozor! - JavaScript nebude fungovat s více instancemi pluginu na jedné stránce. Musíte pouít PHP verzi, pokud ho tak chcete nastavit.');
@define('PLUGIN_TWITTER_SHOWFORMAT_RADIO_JAVASCRIPT',   'Javascript');
@define('PLUGIN_TWITTER_SHOWFORMAT_RADIO_PHP',          'PHP');

@define('PLUGIN_TWITTER_CACHETIME',                     'Jak dlouho cachovat data (pouze pro PHP formát)');
@define('PLUGIN_TWITTER_CACHETIME_DESC',                'Aby se zamezilo pøíliš velkému a zbyteènému pøenášení dat mezi blogem a Twitterem, mohou se vısledky z Twitteru ukládat do cache. Zde zadejte v sekundách dobu, po které se bude aktualizovat obsah cache podle Twitteru.');
@define('PLUGIN_TWITTER_BACKUP',                        'Zálohovat Tweety? (experimentální funkce, pouze Twitter)');
@define('PLUGIN_TWITTER_BACKUP_DESC',                   'Pokud je povoleno, plugin bude dennì stahovat tweety a zálohovat je v databázi blogu (tabulka ' . $serendipity['dbPrefix'] . 'tweets). Vyaduje PHP5.');

@define('PLUGIN_TWITTER_LINKTEXT',                      'Text odkazù ve tweetech');
@define('PLUGIN_TWITTER_LINKTEXT_DESC',                 'Odkazy nalezené v Tweetech jsou nahrazeny kliknutelnım HTML odkazem. Zde nastavte text odkazu. Hodnota $1 bude nahrazena samotnım odkazem tak, jak to dìlá Twitter.');
@define('PLUGIN_TWITTER_FOLLOWME_LINK',                 'Odkaz "Sledování"');
@define('PLUGIN_TWITTER_FOLLOWME_LINK_DESC',            'Pøidává odkaz "sledování" pod èasovou osu');
@define('PLUGIN_TWITTER_FOLLOWME_LINK_TEXT',            'Sledování');
@define('PLUGIN_TWITTER_USE_TIME_AGO',                  'Pouít pohled zpìt v èase');
@define('PLUGIN_TWITTER_USE_TIME_AGO_DESC',             'Pokud je zapnuto, pak bude èas statutu zobrazen jako èas, kterı uplynul od zadání statutu (tak jak to dìlá samotnı twitter), jinak bude pouít nastavitelnı formát data.');

@define('PLUGIN_TWITTER_PROBLEM_TWITTER_ACCESS',        'Problém pøi pøístupu na Twitter. <br />Poèkejte chvilku a obnovte stránku...');

// Twitter Event Plugin 

@define('PLUGIN_EVENT_TWITTER_NAME',                    'Mikroblogování (Twitter, Identica)');
@define('PLUGIN_EVENT_TWITTER_DESC',                    'Pøidává klienta Twitter/Identica do administraèní sekce a stahuje nové tweety a oznámuje nové èlánky na úètu mikroblogu.');

@define('PLUGIN_EVENT_TWITTER_ACCOUNT_NAME',            'Jméno úètu');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_NAME_DESC',       'Jméno úètu, kterım se bude klient na pozadí pøihlašovat k mikroblogu.');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_PWD',             'Heslo k úètu');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_PWD_DESC',        'Heslo úètu, kterım se bude klient na pozadí pøihlašovat k mikroblogu.');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_TITLE', 'Oznámování èlánkù');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES',       'Oznamovat nové èlánky');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_DESC',  'Pokud je zapnuto, plugin bude oznamovat nové na blogu publikované pøíspìvky na slubì Twitter nebo Identica.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_WITHTTAGS',      'Oznámit s tagy');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_WITHTTAGS_DESC', 'Pokud je nainstalován plugin Free Tag (Klíèová slova), oznamovaè èlánkù prohledá nadpis pøíspìvku, jestli neobsahuje tagy. Pokud nìjakı nalezne, budou tyto tagy oznaèené jako tagy twitteru. Vdy mùete pøidat tagy ruènì pomocí #tags#. Tyto budou naplnìny všemi tagy, které ještì nebyly nalezeny v nadpisu pøíspìvku. To znamená všechny zde zadané tagy budou pøidány, pokud volba automatického hledání tagù není zapnuta.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_SERVICE',        'Oznámit URL zkracovaè');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_SERVICE_DESC',   'Sluba, která má bıt pouita pro zkrácení odkazù pøi oznamování pøíspìvku. Doporuèené jsou 7ax.de nebo tinyurl.com, protoe to jsou zatím jediné známé sluby, které fungují spoleènì s tweetbacks.');

@define('PLUGIN_EVENT_TWITTER_TWEETBACKS_TITLE',        'Tweetbacks');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETBACKS',           'Zjišovat Tweetbacky');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETBACKS_DESC',      'Pokud je zapnuto, plugin se pokusí najít tweetbacky (odezvy twitteru) na èlánky a pøidá volbu "zkontrolovat odezvy twitteru" pod rozšíøené tìlo pøíspìvku, pokud je návštìvník pøihlášenı do blogu.');
@define('PLUGIN_EVENT_TWITTER_IGNORE_MYTWEETBACKS',     'Ignorovat moje Tweety');
@define('PLUGIN_EVENT_TWITTER_IGNORE_MYTWEETBACKS_DESC','Pokud nechcete zobrazovat vlastní tweety jako tweetbacky, zapnìte tuto volbu. V opaèném pøípadì budou oznámení zobrazována jako tweetbacky.');

@define('PLUGIN_EVENT_TWITTER_TWEETBACK_CHECK_FREQ',    'Frekvence kontroly tweetbackù');
@define('PLUGIN_EVENT_TWITTER_TWEETBACK_CHECK_FREQ_DESC','Èas v minutách mezi dvìma kontrolami twitteru. (musí bıt alespoò 5 minut)');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE',                 'Typ tweetbacku');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_DESC',            'Serendipity nepodporuje sama o sobì tweetbacky. Take ty musejí bıt uloeny jako odezvy nebo normální komentáøe. Protoe pøicházejí z vnì blogu, jsou jistım type odezvy, ale podle obsahu by patøily spíš mezi komentáøe. Rozhodnìte sami, jak se mají tweetbacky ukládat.');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_TRACKBACK',       'Odezva');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_COMMENT',         'Komentáø');

@define('PLUGIN_EVENT_TWITTER_TWEETER_TITLE',           'Mikroblogovací klient');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SIDEBARTITLE',    'Tweeter');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW',            'Zapnout mikroblogovacího klienta');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_DESC',       'Zapnte tweeter na hlavní stránce administraèní sekce, jako postranní sloupec a nebo ho vypne.');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_FRONTPAGE',  'Hlavní stránka');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_SIDEBAR',    'Postranní sloupec');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_DISABLE',    'Vypnout');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY',         'Zobrazit èasovou osu');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_DESC',    'Zobrazuje èasovou osu s èlánky pod aktualizovanım vıpisem.');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_COUNT',   'Délka èasové osy');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_COUNT_DESC','Kolik nejnovìjších pøíspìvkù  se má zobrazovat na hlavní stranì?');

@define('PLUGIN_EVENT_TWITTER_TWEETER_FORM',            'Zadejte tweet:');
@define('PLUGIN_EVENT_TWITTER_TWEETER_CHARSLEFT',       'znakù vlevo');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHORTEN',         'Zkracovat URL adresy');
@define('PLUGIN_EVENT_TWITTER_TWEETER_STORED',          'Tweet uloen ');
@define('PLUGIN_EVENT_TWITTER_TWEETER_STOREFAIL',       'Tweet nemohl bıt uloen! Chyba Twitteru: ');

@define('PLUGIN_EVENT_TWITTER_GENERAL_TITLE',           'Obecná');
@define('PLUGIN_EVENT_TWITTER_PLUGIN_EVENT_REL_URL',    'Plugin rel. path');
@define('PLUGIN_EVENT_TWITTER_PLUGIN_EVENT_REL_URL_DESC', 'Zadejte celou HTTP cestu (všechno, co následuje po Vašem doménovém jménì), které vede do adresáøe s pluginem.');

@define('PLUGIN_EVENT_TWITTER_TWEETER_WARNING',         '<p class="serendipityAdminMsgError">' .
                '<img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png'). '" alt="" />' .
                'UPOZORNÌNÍ: Nalezen nainstalovanı plugin TwitterTweeter.</p>' .
                '<p class="serendipityAdminMsgError">Tento plugin je slouèením pluginu TwitterTweeter a oficiálního starého serendipity pluginu twitter, navíc oba dva pluginy rozšiøuje.Mìli byste odinstalovat všechny pøedchozí pluginy.</p>');

@define('PLUGIN_EVENT_TWITTER_TB_USE_URL',              'URL Tweetbacku');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_DESC',         'Co uloit jako URL adresu tweetbacku? Máte 3 monosti. Status: url tweetu, kterı je tweetbackem, Profil: adresa profilu uivatele twitteru nebo WebURL: adresa zadaná uivatelem twitteru v jeho profilu jako Web URL');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_STATUS',       'Status');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_PROFILE',      'Profil');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_WEBURL',       'Web URL');

@define('PLUGIN_EVENT_TWITTER_IDENTITIES',              'Identity');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_IDCOUNT',         'Poèet úètù');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_IDCOUNT_DESC',    'Po uloení tohoto nastavení se na této stránce nastavení objeví políèka pro nastavení zde zadaného poètu úètù. Moná budete muset nastavení uloit dvakrát, abyste pøíslušná zadávací políèka vidìli.');
@define('PLUGIN_EVENT_TWITTER_IDENTITY',                'Identita');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE',         'Jméno sluby');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_DESC',    'Zadejte, zda je tento úèet na twitteru nebo na identi.ca');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_TWITTER', 'twitter');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_IDENTICA','identica');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ACCOUNTS',       'Oznamovací úèty');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ACCOUNTS_DESC',  'Vyberte úèty, na které se mají oznamovat nové pøíspìvky');

// Configuration Tabs:

@define('PLUGIN_EVENT_TWITTER_CFGTAB',                  'Konfiguraèní záloky:');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_IDENTITIES',       'Identity');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_ANNOUNCE',         'Oznamování èlánkù');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETER',          'Mikroblogovací klient');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETBACK',        'Tweetbacky');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_GLOBAL',           'Obecné');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_ALL',              'Všechno');

@define('PLUGIN_EVENT_TWITTER_TWEETER_REPLY',           'Odpovìdìt pisateli');
@define('PLUGIN_EVENT_TWITTER_TWEETER_RETWEET',         'Retweetovat');
@define('PLUGIN_EVENT_TWITTER_TWEETER_DM',              'Pøímá zpráva (Pracuje pouze pokud Vás uivatel sleduje)');

@define('PLUGIN_EVENT_TWITTER_IGNORE_TWEETBACKS_BYNAME','Ignorovat tweetbacky z');
@define('PLUGIN_EVENT_TWITTER_IGNORE_TWEETBACKS_BYNAME_DESC','Èárkami oddìlenı seznam úètù twitteru, ze kterıch nechcete pøijímat tweetbacky.');

@define('PLUGIN_TWITTER_EVENT_NOT_INSTALLED',           '<p class="serendipityAdminMsgError">' .
                '<img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png'). '" alt="" />' .
                'VAROVÁNÍ: Plugin událostí pro mikroblogování (twitter/identica) ještì nebyl nainstalován!</p>' .
                '<p class="serendipityAdminMsgError">Hlavní èást funkcí twitter/identica je zabezpeèována pluginem událostí mikroblogování. Pokud chcete plnou funkènost pluginu, mìli byste ho také nainstalovat
.</p>');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_FORMAT',         'Formát oznámení');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_FORMAT_DESC',    'Zadejte vlastní formát oznamovacích zpráv. Mùete pouít následující promìnné. title#: bude nahrazen nadpisem pøíspìvku (a odpovídajícími tagy); #link#: odkaz na pøíspìvek; #author#: Autor pøíspìvku; #tags#: zbıvající tagy.');

@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETTHIS',        'Twittni to!');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_TITLE',         'Twittni to!');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETTHIS',            'Povolit "Twittni to!"');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETTHIS_DESC',       'Zapnutí této funkce zobrazí tlaèítko "Twittni to!" v patièce pøíspìvku.');
@define('PLUGIN_EVENT_TWITTER_DO_IDENTICATHIS',         'Zapnout Identica');
@define('PLUGIN_EVENT_TWITTER_DO_IDENTICATHIS_DESC',    'Zapnutí této funkce zobrazí tlaèítko "Identica" v patièce pøíspìvku.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT',        'Formát "Twittni to!"');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_DESC',   'Zadejte formát pro tweety návštìvníkù. Mìli byste pouít následující promìnné. title#: bude nahrazen nadpisem pøíspìvku (a odpovídajícími tagy); #link#: odkaz na pøíspìvek; #author#: Autor pøíspìvku; #tags#: zbıvající tagy.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON', 'Styl tlaèítek');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_DESC', 'V souèasnosti je mono vybrat mezi dvìma styly twittovacího tlaèítka.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_BLACK', 'èerné');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_WHITE', 'bílé');

@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_NEWWINDOW',     '"Twittni to!" v novém oknì');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_NEWWINDOW_DESC','Pokud je zapnuto, twitter a identica se natáhnou v novém oknì, v aktuálním oknì tedy zùstane stále zobrazenı blog.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_SMARTIFY',      'Smartyfizce funkce "Twittni to!"');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_SMARTIFY_DESC', 'Pokud je zapnuto, plugin nebude pøidávat tlaèítko sám o sobì. Místo toho pøidá do smarty dvì promìnné: entry.url_tweetthis a entry.url_dentthis. Ty pak lze pouít v šablonì. Tyto promìnné obsahují pouze URL adresy, take mùete vytvoøit vlastní text pro tlaèítko "Twittni to!", nebo tlaèítko umístit napøíklad do záhlaví èlánku.');

@define('PLUGIN_EVENT_TWITTER_BACKEND_DONTANNOUNCE',    'NEoznamovat tento pøíspìvek pomocí mikroblogovacích slueb');
@define('PLUGIN_EVENT_TWITTER_BACKEND_ENTERDESC',       'Zadejte libovolné tagy, které souvisí s pøíspìvkem. Více tagù oddìlujte èárkou (,). Pokud je zde nìco zadáno, tagy pluginu freetag jsou pøi oznamování ignorovány!');

// Next lines were translated on 2009/08/15

@define('PLUGIN_TWITTER_FILTER_ALL',                    'ádné uivatelské tweety');
@define('PLUGIN_TWITTER_FILTER_ALL_DESC',               'Pokud je volba zapnuta, nebudou se zobrazovat tweety obsahující @. (pouze v PHP verzi)');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE',             'Schvalování tweetbackù');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE_DESC',        'Jak pracovat s pøijatımi tweetbacky? Mùete pouít obecné nastavení pro komentáøe, schvalovat je, nebo je vdy povolit.');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE_DEFAULT',     'Pouít obecné nastavení komentáøù');

// Next lines were translated on 2009/08/25

@define('PLUGIN_EVENT_TWITTER_SHORTURL_TITLE',          'Zobrazit URL adresu pro tento èlánek');
@define('PLUGIN_EVENT_TWITTER_SHORTURL_ON_CLICK',       'Tento odkaz není klikací. Obsahuje zkrácenou URL adresu k tomuto pøíspìvku. Tuto URL adresu mùete pouít jako odkaz na tento èlánek, napøíklad v twitteru. Odkaz zkopírujete tak, e kliknete pravım tlaèítkem a vyberete "Zkopírovat odkaz" v Internet Exploreru, nebo "Kopírovat adresu odkazu" v Mozille.');
@define('PLUGIN_EVENT_TWITTER_SHOW_SHORTURL',           'Zobrzit krátkou URL adresu pro kadı pøíspìvek');
@define('PLUGIN_EVENT_TWITTER_SHOW_SHORTURL_DESC',      'Bude zobrazovat vıchozí krátkou URL v patièce kadého èlánku. Pokud je zapnutá funkce smarty TweetThis, kadı pøíspìvek bude obsahovat promìnnou entry.url_shorturl, která se dá libovolnì vyuít ve smarty šablonì.');

// Next lines were translated on 2010/09/28

@define('PLUGIN_EVENT_TWITTER_CONSUMER_KEY',            'Klíè zákazníka (Consumer key)');
@define('PLUGIN_EVENT_TWITTER_CONSUMER_KEY_DESC',       '"Zákaznickı klíè" a "zákaznické heslo" obdríte od Twitteru poté, co pro svùj blok vytvoøíte aplikaci Twitteru.');
@define('PLUGIN_EVENT_TWITTER_CONSUMER_SECRET',         'Zákaznické heslo');
@define('PLUGIN_EVENT_TWITTER_TIMELINE',                'Èasová osa statutu');
@define('PLUGIN_EVENT_TWITTER_TIMELINE_DESC',           '');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_OK',           'Pøipojeno');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_DEL',          'Smazat odkaz');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_DEL_OK',       'Twitter OAuth token odstranìn');
@define('PLUGIN_EVENT_TWITTER_CLOSEWINDOW',             'Zavøít okno');
@define('PLUGIN_EVENT_TWITTER_REGISTER',                'Registrovat');
@define('PLUGIN_EVENT_TWITTER_CALLBACKURL',             'Zpìtná URL adresa (zadejte ve Twitteru)');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_ERROR',        'Chyba zpìtného volání Twitteru');

// Next lines were translated on 2011/03/09

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_NO',    'Pro oznamování pøíspìvku je ve vıchozím nastavení checkbox odškrtnut');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_NO_DESC','Povolení znamená, e novı pøíspìvek na blogu musí bıt vıslovnì odeslán do twiteru. Vypnutí (vıchozí hodnota) znamená, e pøíspìvek bude do twiteru odeslán automaticky.');

// Next lines were translated on 2012/01/11

@define('PLUGIN_EVENT_TWITTER_SIGN_IN',                 'Kliknìte na tlaèítko níe a pøipojte Twitter.<br/>
<p><a style="color:red;">VAROVÁNÍ!</a><br/>
Musíte se pøihlásit nebo odhlásit s <b>odpovídajícím úètem Twitteru</b>!<br/>
<a href="#" onclick="window.open(\'http://twitter.com\',\'\',\'width=1000,height=400\'); return false">Potvrïte prosím pøed pøipojením</a>.</p>');
@define('PLUGIN_EVENT_TWITTER_SIGNIN',                  'Pøihlásit');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET',               'Widget sledování Twitteru');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DESC',          'Pokud plugin zobrazuje èasovou osu, mùete povolit widget twitteru pro zobrazování aktuálního poètu followerù a další. Nastavení je ignorováno, pokud zobrazujete z identi.ca.');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_COUNT',         'Poèet followerù ve widgetu');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_COUNT_DESC',    'Pokud je povoleno, widget zobrazuje poèet followerù.');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DARK',          'Widget sledování Twitter na tmavém pozadí');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DARK_DESC',     'Pokud Vaše šablona pouívá tmavé pozadí, mìli byste toto povolit.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYDESC',      '<h3>uivatelské jméno bit.ly a API klíè</h3><b>bit.ly</b> a <b>j.mp</b> zkracovaèe URL adres potøebují pøihlašovací jméno k bit.ly a API klíè. Pokud ani jeden z tìchto zkracovaèù nepouíváte, nemìli byste je potøebovat.<br/>Vıchozí klíè vìtšinou nefunguje, protoe je to demo klíè a jeho kvóta je pravidelnì pøeèerpána. Pokud máte úèet na bit.ly account, mìli byste zadat vlastní pøihlašovací údaje.<br/><a href="http://bitly.com/a/your_api_key/" target="_blank">Najdete je tady</a>.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYLOGIN',     'Uivatelské jméno bit.ly');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYAPIKEY',    'bit.ly API klíè');
@define('PLUGIN_EVENT_TWITTER_GENERALCONSUMER',         '<h3>Vlastní twitter klient</h3>Ve vıchozím nastavení pouívá plugin klienta \'s9y\'. Mùete si <a href="https://dev.twitter.com/apps" target="_blank">zaregistrovat vlastního klienta</a> a nastavit consumer klíè a heslo vašeho klienta.');

// Next lines were translated on 2013/03/31

@define('PLUGIN_EVENT_TWITTER_TWEETER_UPDATE',           'Update');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_PIRATLYDESC',     '<h3>pirat.ly API token</h3>Pro zkrácené odkaz <b>pirat.ly</b> mùete <a href="http://pirat.ly/account" target="_blank">získat API token tím, e se zdarma registrujete na slubì piratly</a>. Pouitím tohoto API tokenu pøi oznamování Vašich pøíspìvkù mùete prohlíet poèty proklikù buï pomocí webového rozhraní nebo na zaøízení s Androidem pomocí <a href="http://pirat.ly/shortenerrr" target="_blank">aplikace Shortenerrr</a>.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_PIRATLYAPIKEY',   'Váš osobní piratly API token');
@define('PLUGIN_TWITTER_FILTER_RT',                      'FIltrovat nativní retweety');
@define('PLUGIN_TWITTER_FILTER_RT_DESC',                 'Mají se filtrovat nativní retweety? (pouze pro Twitter API 1.1; API 1.0 filtruje vdy)');
@define('PLUGIN_TWITTER_API11',                          'Pouít OAuth Twitter API 1.1');
@define('PLUGIN_TWITTER_API11_DESC',                     'Twitter API 1.0 je zastaralé a bìhem roku 2013 bude úplnì zrušeno. Mìli byste se tedy pøepnout na API 1.1. Nicménì to vyaduje, abyste nastavili alespoò jedno OAuth propojení v hlavním mikroblogovacím pluginu. Pokud v políèku níe najdete nìjakı úèet, u jste to udìlali.');
@define('PLUGIN_TWITTER_OAUTHACC',                       'OAuth úèet, kterı se má pouít tímto pluginem');
@define('PLUGIN_TWITTER_OAUTHACC_DESC',                  'Nové OAuth Twitter API je tøeba volat pomocí OAuthorzied Twitter úètu. Tento úèet bude také pouit pro omezení pøístupu. Mùete pouít libovolnı úèet, kterı vlastníte, tøeba úèet, kterı nikde jinde nepouíváte, napøíklad abyste mìli pro tento plugin samostatnı limit pøístupu.');
@define('PLUGIN_EVENT_TWITTER_API_TYPE',                 'Verze Twitter API');
@define('PLUGIN_EVENT_TWITTER_API_TYPE_DESC',            'Twitter API 1.0 je zastaralé a bìhem roku 2013 bude úplnì zrušeno. Mìli byste se tedy pøepnout na API 1.1. Nicménì to vyaduje, abyste nastavili alespoò jedno OAuth propojení (nastavení identity/uivatele)');
@define('PLUGIN_EVENT_TWITTER_API_10',                   'API 1.0 [zastaralé]');
@define('PLUGIN_EVENT_TWITTER_API_11',                   'API 1.1 OAuth');

// Next lines were translated on 2013/10/26
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_YOURLSDESC',      '<h3>Yourls doména a API klíè</h3>Zkracovaè adres <b>yourls</b> vlastní nastavení a API klíè. Pokud ádné nemáte, nebudete toto nastavení potøebovat.<br/>Vıchozí klíè není funkèní<br/><a href="http://yourls.org/" target="_blank">Pøeètìte si o zkracovaèi URL adres yourls</a>. Nepouívejte prosím bez <a href="https://bitbucket.org/laceous/yourls-concurrency-fix" target="_blank">opravy konfliktù</a> pluginu YOURIS.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_YOURLSURL',       'Vaše Yourls doména');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_YOURLSAPIKEY',    'Yourls API klíè');