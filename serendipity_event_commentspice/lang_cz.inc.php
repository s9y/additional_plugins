<?php # lang_cz.inc.php 1.0 2013-04-05 14:19:08 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2013/04/05
 */
@define('PLUGIN_EVENT_COMMENTSPICE_TITLE', 'Komentáøové koøení');
@define('PLUGIN_EVENT_COMMENTSPICE_DESC',  'Okoøeòte formuláø pro zadání komentáøù pomocí twitteru komentujícího, odkazem na poslední èlánek nebo pravidly pro ne-sledování.');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_HINTBEE', '<strong>UPOZORNÌNÍ K AKTUALIZACI!</strong>: Antispamová ochrana vytahující se ke komntáøùm byla pøesunuta do samostatného pluginu "Spamblock Bee". Pokud tedy chcete pou¾ít Honeypot, který zde byl døíve implementován, nainstalujte si prosím tento nový plugin.');

@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_TWITTERNAME', 'Twitterové jméno');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_ANNOUNC_RSS', 'Oznamovat poslední pøíspìvky');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_GENERAL', 'Obecná nastavení');

@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT', 'Povolí komentujícím pøidat ke komentáøi jejich twitterové jméno');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_DESC', 'Pokud je povoleno, komentující mohou zadat své twitterové jméno, po kterým bude odkaz na jejich twitterovou èasovou osu.');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_NOFOLLOW', 'Nastavit "nofollow" pro twitter');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_NOFOLLOW_DESC', 'Pokud je nastavené nesledování, vyhledávaèe budou ignorovat odkaz na èasovou osu na twitteru. To bude ménì zajímavé pro ruèní komentáøové spamery, ale nedá to vyhledávaèùm odkaz na skuteèné komentátory.');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET', 'Zobrazit twitter followme widget');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_DESC', 'Pokud je tato volba zapnuta, bude se místo vlastního textu zobrazovat pìkný originální twitterovský widget "followme". Aèkoliv to bude vypadat hezky, zpomalí to vykreslování stránky, proto¾e musí být naèten pro ka¾dý komentáø. Pokud je vkládání followme øe¹eno pomocí smarty, bude se tato volba pøepínat podle toho, jestli $comment.spice_twitter_followme nìco obsahuje nebo ne.');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_COUNT',  'Zobrazovat poèet followerù');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_COUNT_DESC',    'Pokud je zapnuto, widget bude zobrazovat poèet followerù komentujícího.');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_DARK',          'Tmavé pozadí widgetu');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_DARK_DESC',     'Pokud Vá¹ styl vzhledu pou¾ívá tmavé pozadí, je zøejmì dobrý nápad toto zapnout.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS', 'Povolit komentujícím oznamování nedávných pøíspìvkù');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_DESC', 'Kdy¾ komentující zadá svoji domovskou stránku, pugin comment spice zkontroluje RSS kanál na této stránce. Pokud existuje, mù¾e komentující vybrat jeden z nedávných èlánkù, který bude inzerován spoleènì s jeho komentáøem.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_NOFOLLOW', 'Nastavit odkazy na nedávné èlánky jako "nofollow"');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_NOFOLLOW_DESC', 'Pokud je nastavené nesledování, vyhledávaèe budou ignorovat odkaz na nedávné pøíspìvky. To bude ménì zajímavé pro ruèní komentáøové spamery, ale nedá to vyhledávaèùm odkaz na skuteèné komentátory.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT', 'Maximální poèet inzerovaných èlánkù');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT_DESC', 'Kolik nedávných èlánkù mù¾e komentující maximálnì inzerovat se svým komentáøem?');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_ONCEONLY', 'Inzerovat nedávný èlánek pouze jednou na jedné stránce blogu');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_ONCEONLY_DESC', 'Tato volba umo¾òuje komentujícímu inzerovat ka¾dý svùj èlánek na stránce blogu pouze jednou. (U prvního komentáøe si mù¾e vybrat v¹echny èlánky, u druhého v¹echny kromì tìch, které inzeroval u prvního komentáøe atd.)');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_CACHEMIN', 'Poèet minut mezi obnovením cache s nedávnými èlánky');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_CACHEMIN_DESC', 'V jakém èasovém intervalu má CommentSpice obnovovat informace o nedávných èláncích? Nenastavujte zde pøíli¹ vysokou hodinu, jinak se nové èlánky budou objevovat se zpo¾dìním. Jedna a¾ dvì hodiny (60-120min) je dobrá hodnota. Zadáním 0 vypnete cachování.');

@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_RULES', 'Pravidla');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTCOUNT', 'Minimální poèet komentáøù nutný pro povolení komentáøových extra funkcí');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTCOUNT_DESC', 'Zadejte poèet komentáøù, které musí komentující vlo¾it pøedtím, ne¾ se mu povolí CommentSpice. 0 znamená: povolit komukoliv.');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTLENGTH', 'MInimální délka komentáøe nutná pro povolení komentáøových extra funkcí');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTLENGTH_DESC', 'Zadejte délku komentáøe nutnou k zapnutí CommentSpice. 0 znamená: povolit pro komentáøe libovolné délky.');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTCOUNT', 'Minimální poèet komentáøù nutný pro povolení follow odkazù');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTCOUNT_DESC', 'Zadejte poèet komentáøù, které musí komentující vlo¾it pøedtím, ne¾ mù¾e pou¾ít follow (sledované) odkazy. 0 znamená: povolit komukoliv.');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTLENGTH', 'MInimální délka komentáøe nutná pro povolení follow odkazù');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTLENGTH_DESC', 'Zadejte délku komentáøe nutnou k zapnutí follow (sledovaných) odkazù. 0 znamená: povolit pro komentáøe libovolné délky.');
@define('PLUGIN_EVENT_COMMENTSPICE_ENABLED', 'povoleno');
@define('PLUGIN_EVENT_COMMENTSPICE_DISABED', 'zakázáno');
@define('PLUGIN_EVENT_COMMENTSPICE_RULES', 'pou¾ít pravidla');

@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_TWITTER', 'Smartifikovat zobrazování twitter jména');
@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_TWITTER_DESC', 'Pokud je zapnuto, CommentSpice nebude generovat HTML kód pro zobrazení odkazu na twitter, resp. widgetu, ale v¹e potøebné vlo¾í do promìnných Smarty. Aby se pak nìco zobrazovalo, musíte pøidat odpovídající obsah do ¹ablony comments.tpl. Dostupné promìnné jsou $comment.spice_twitter_name (twitter jméno, kontrolujte, jsetli není prázdné), $comment.spice_twitter_url (url adresa na èasovou osu twitter), $comment.spice_twitter_nofollow (nastavení nofollow pro odkazy na twitter), $comment.spice_twitter_icon_html (html vytváøející twitterovou ikonu), $comment.spice_twitter_followme (html zobrazující followme widget).');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_TWITTER', '©ablona formuláøe pro zadání komentáøù upravena pro zadání twitteru');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_TWITTER_DESC', 'Zapnìte tuto volbu, pokud jste upravovali ¹ablonu commentform.tpl, aby obsahovala políèko pro zadání twitteru na vámi zvoleném místì. V adresáøi pluginu najdete pøíklady, jak na to.');
@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_RSS', 'Smartifikovat zobrazení èlánkù');
@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_RSS_DESC', 'Pokud je zapnuto, CommentSpice nebude generovat HTML kód pro zobrazení nedávných pøíspìvkù, ale v¹e potøebné vlo¾í do promìnných Smarty. Aby se pak nìco zobrazovalo, musíte pøidat odpovídající obsah do ¹ablony comments.tpl. Dostupné promìnné jsou $comment.spice_article_name (nadpisy èlánkù, kontrolujte, jestli vùbec nìco obsahují). $comment.spice_article_url (url adresa èlánkù), $comment.spice_article_nofollow (nastavení nofollow pro nedávné èlánky), $comment.spice_article_prefix (pøedpona v jazyku ètenáøe).');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_RSS', '©ablona formuláøe pro zadání komentáøù upravena políèkem pro výbìr èlánkù');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_RSS_DESC', 'Zapnìte tuto volbu, pokud jste upravovali ¹ablonu commentform.tpl, aby obsahovala políèko pro výbìr nedávných èlánkù. V adresáøi pluginu najdete pøíklady, jak na to.');
@define('PLUGIN_EVENT_COMMENTSPICE_STYLE_RSS', 'Styl oznámení o nedávných èláncích');
@define('PLUGIN_EVENT_COMMENTSPICE_STYLE_RSS_DESC', 'Plugin vykreslí políèko pro výbìr èlánkù èernì s pìknou ikonou apod. Pokud se vám to tak nelíbí, mù¾ete toto zobrazování vypnout a ostylovat si políèko sami pomocí vlastní ¹ablony.');

@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK', 'Vlo¾it obsah pingbackovaných èlánkù');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_DESC', 'Pokud nìjaký cizí blog po¹le tomu va¹emu pingback, je známá pouze URL adresa cizího èlánku. Serendipity umí stáhnout i obsah cizího èlánku a zobrazit ho, jak to znáte z odezev (trackback). Jenom z výkonostních dùvodù to Serendipit nedìlá jako výchozí nastavení. Pomocí této volby umo¾níte pluginu ulo¾it nastavení do serendipity_config_local.inc.php. Pokud hodnotu nemù¾ete zmìnit, pak jste u¾ v minulosti museli zmínìné nastavení pøepsat. V takovém pøípadì byste mìli vymazat va¹e ruèní nastavení ze souboru serendipity_config_local.inc.php, aby zmìny mohl provádìt tento plugin.');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_LEAVE_ON', 'Ponechat: stahovat obsah');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_LEAVE_OFF', 'Ponechat: nestahovat obsah');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_FETCH', 'Zmìnit na: stahovat obsah');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_DONTFETCH', 'Zmìnit na: nestahovat obsah');

@define('PLUGIN_EVENT_COMMENTSPICE_PATH', 'Cesta k pluginùm');
@define('PLUGIN_EVENT_COMMENTSPICE_PATH_DESC', 'V bì¾ných instalacích je výchozí hodnota správnì');

@define('PLUGIN_EVENT_COMMENTSPICE_EXPERTSETTINGS', 'Zobrazit pokroèilá nastavení');
@define('PLUGIN_EVENT_COMMENTSPICE_STANDARDSETTINGS', 'Zobrazit základní nastavení');

@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER', 'Èíst na Twitteru');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_FOOTER', 'Pokud zadáte <b>twitterové jméno</b>, ke komentáøi bude pøidán odkaz na Va¹i èasovou osu z twitteru.');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_PLACEHOLDER', 'twittername nebo jmeno@identi.ca');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_LABEL', 'Twitter');

@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_LABEL', 'Inzerovat nedávné èlánky');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_CHOOSE', '- vyberte èlánek -');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_RECENT', '% pí¹e o');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_FOOTER', '<b>Inzerujte nedávné èlánky</b><br/>Tento blog vám umo¾òuje spoleènì s Va¹ím komentáøem inzerovat i nìkterý z posledních èlánkù na Va¹em blogu. Jako domovksou stránku zadejte pøíslu¹nou URL adresu Va¹eho blogu a objeví se políèko, ze kterého mù¾ete vybrat nedávné èlánky. (potøeba mít zapnutý Javascript)');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_CORRUPTED', 'Je mi líto, nepodaøilo se mi stáhnout Va¹e "nedávné èlánky"...');

@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_BOO','Audio komentáøe pomocí audioboo.fm');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_BOO_DESC','Pokud máte podcastovací blog, mo¾ná chcete umo¾nit u¾ivatelùm vkládat i audio komentáøe, tzv. boo audios (mini podcasty) umístìné na <a href="http://audioboo.fm" target="_blank">audioboo.fm</a>.');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_ALLOW','Povolit boo audio komentáøe');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_ALLOW_DESC','Zapnìte, pokud chcete povolit audio boo komentáøe. Pod políèkem pro vlo¾ení komentáøe se objeví políèko pro vlo¾ení a nahrání (beta funkce!) audio boo komentáøù.');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_MODERATE','Schvalovat audio boo komentáøe');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_MODERATE_DESC','Zapnìte, pokud mají audio boo komentáøe podléhat schvalování pøed zveøejnìním.');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_FOOTER','Tento blog Vám umo¾òuje vlo¾it audio boo komentáøe pomocí <a href="http://audioboo.fm/profile" target="_blank">audioboo.fm</a>. <a href="http://audioboo.fm/boos/new" target="_blank">Nahrajte nový komentáø</a> a zadejte odkaz do políèka audio boo.');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_PLACEHOLDER', 'http://audioboo.fm/boos/123456-nadpis');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_WRONG', 'Je mi líto, toto nevypadá jako boo URL (http://audioboo.fm/boos/12345-nadpis)');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_MODERATED', 'Audio boo komentáøe podléhají schválení pøed zveøejnìním, prosíme o trpìlivost.');

@define('PLUGIN_EVENT_COMMENTSPICE_REQUIREMENTS', 'Po¾adavky');
@define('PLUGIN_EVENT_COMMENTSPICE_REQUIREMENTS_COMMENTCOUNT', '%s napsaných komentáøù');
@define('PLUGIN_EVENT_COMMENTSPICE_REQUIREMENTS_COMMENTLEN', 'nejménì %s znakù v komentáøi');