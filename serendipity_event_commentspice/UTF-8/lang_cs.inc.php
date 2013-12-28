<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2013/04/05
 */
@define('PLUGIN_EVENT_COMMENTSPICE_TITLE', 'Komentářové koření');
@define('PLUGIN_EVENT_COMMENTSPICE_DESC',  'Okořeňte formulář pro zadání komentářů pomocí twitteru komentujícího, odkazem na poslední článek nebo pravidly pro ne-sledování.');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_HINTBEE', '<strong>UPOZORNĚNÍ K AKTUALIZACI!</strong>: Antispamová ochrana vytahující se ke komntářům byla přesunuta do samostatného pluginu "Spamblock Bee". Pokud tedy chcete použít Honeypot, který zde byl dříve implementován, nainstalujte si prosím tento nový plugin.');

@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_TWITTERNAME', 'Twitterové jméno');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_ANNOUNC_RSS', 'Oznamovat poslední příspěvky');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_GENERAL', 'Obecná nastavení');

@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT', 'Povolí komentujícím přidat ke komentáři jejich twitterové jméno');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_DESC', 'Pokud je povoleno, komentující mohou zadat své twitterové jméno, po kterým bude odkaz na jejich twitterovou časovou osu.');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_NOFOLLOW', 'Nastavit "nofollow" pro twitter');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_NOFOLLOW_DESC', 'Pokud je nastavené nesledování, vyhledávače budou ignorovat odkaz na časovou osu na twitteru. To bude méně zajímavé pro ruční komentářové spamery, ale nedá to vyhledávačům odkaz na skutečné komentátory.');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET', 'Zobrazit twitter followme widget');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_DESC', 'Pokud je tato volba zapnuta, bude se místo vlastního textu zobrazovat pěkný originální twitterovský widget "followme". Ačkoliv to bude vypadat hezky, zpomalí to vykreslování stránky, protože musí být načten pro každý komentář. Pokud je vkládání followme řešeno pomocí smarty, bude se tato volba přepínat podle toho, jestli $comment.spice_twitter_followme něco obsahuje nebo ne.');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_COUNT',  'Zobrazovat počet followerů');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_COUNT_DESC',    'Pokud je zapnuto, widget bude zobrazovat počet followerů komentujícího.');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_DARK',          'Tmavé pozadí widgetu');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_DARK_DESC',     'Pokud Váš styl vzhledu používá tmavé pozadí, je zřejmě dobrý nápad toto zapnout.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS', 'Povolit komentujícím oznamování nedávných příspěvků');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_DESC', 'Když komentující zadá svoji domovskou stránku, pugin comment spice zkontroluje RSS kanál na této stránce. Pokud existuje, může komentující vybrat jeden z nedávných článků, který bude inzerován společně s jeho komentářem.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_NOFOLLOW', 'Nastavit odkazy na nedávné články jako "nofollow"');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_NOFOLLOW_DESC', 'Pokud je nastavené nesledování, vyhledávače budou ignorovat odkaz na nedávné příspěvky. To bude méně zajímavé pro ruční komentářové spamery, ale nedá to vyhledávačům odkaz na skutečné komentátory.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT', 'Maximální počet inzerovaných článků');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT_DESC', 'Kolik nedávných článků může komentující maximálně inzerovat se svým komentářem?');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_ONCEONLY', 'Inzerovat nedávný článek pouze jednou na jedné stránce blogu');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_ONCEONLY_DESC', 'Tato volba umožňuje komentujícímu inzerovat každý svůj článek na stránce blogu pouze jednou. (U prvního komentáře si může vybrat všechny články, u druhého všechny kromě těch, které inzeroval u prvního komentáře atd.)');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_CACHEMIN', 'Počet minut mezi obnovením cache s nedávnými články');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_CACHEMIN_DESC', 'V jakém časovém intervalu má CommentSpice obnovovat informace o nedávných článcích? Nenastavujte zde příliš vysokou hodinu, jinak se nové články budou objevovat se zpožděním. Jedna až dvě hodiny (60-120min) je dobrá hodnota. Zadáním 0 vypnete cachování.');

@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_RULES', 'Pravidla');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTCOUNT', 'Minimální počet komentářů nutný pro povolení komentářových extra funkcí');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTCOUNT_DESC', 'Zadejte počet komentářů, které musí komentující vložit předtím, než se mu povolí CommentSpice. 0 znamená: povolit komukoliv.');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTLENGTH', 'MInimální délka komentáře nutná pro povolení komentářových extra funkcí');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTLENGTH_DESC', 'Zadejte délku komentáře nutnou k zapnutí CommentSpice. 0 znamená: povolit pro komentáře libovolné délky.');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTCOUNT', 'Minimální počet komentářů nutný pro povolení follow odkazů');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTCOUNT_DESC', 'Zadejte počet komentářů, které musí komentující vložit předtím, než může použít follow (sledované) odkazy. 0 znamená: povolit komukoliv.');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTLENGTH', 'MInimální délka komentáře nutná pro povolení follow odkazů');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTLENGTH_DESC', 'Zadejte délku komentáře nutnou k zapnutí follow (sledovaných) odkazů. 0 znamená: povolit pro komentáře libovolné délky.');
@define('PLUGIN_EVENT_COMMENTSPICE_ENABLED', 'povoleno');
@define('PLUGIN_EVENT_COMMENTSPICE_DISABED', 'zakázáno');
@define('PLUGIN_EVENT_COMMENTSPICE_RULES', 'použít pravidla');

@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_TWITTER', 'Smartifikovat zobrazování twitter jména');
@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_TWITTER_DESC', 'Pokud je zapnuto, CommentSpice nebude generovat HTML kód pro zobrazení odkazu na twitter, resp. widgetu, ale vše potřebné vloží do proměnných Smarty. Aby se pak něco zobrazovalo, musíte přidat odpovídající obsah do šablony comments.tpl. Dostupné proměnné jsou $comment.spice_twitter_name (twitter jméno, kontrolujte, jsetli není prázdné), $comment.spice_twitter_url (url adresa na časovou osu twitter), $comment.spice_twitter_nofollow (nastavení nofollow pro odkazy na twitter), $comment.spice_twitter_icon_html (html vytvářející twitterovou ikonu), $comment.spice_twitter_followme (html zobrazující followme widget).');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_TWITTER', 'Šablona formuláře pro zadání komentářů upravena pro zadání twitteru');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_TWITTER_DESC', 'Zapněte tuto volbu, pokud jste upravovali šablonu commentform.tpl, aby obsahovala políčko pro zadání twitteru na vámi zvoleném místě. V adresáři pluginu najdete příklady, jak na to.');
@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_RSS', 'Smartifikovat zobrazení článků');
@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_RSS_DESC', 'Pokud je zapnuto, CommentSpice nebude generovat HTML kód pro zobrazení nedávných příspěvků, ale vše potřebné vloží do proměnných Smarty. Aby se pak něco zobrazovalo, musíte přidat odpovídající obsah do šablony comments.tpl. Dostupné proměnné jsou $comment.spice_article_name (nadpisy článků, kontrolujte, jestli vůbec něco obsahují). $comment.spice_article_url (url adresa článků), $comment.spice_article_nofollow (nastavení nofollow pro nedávné články), $comment.spice_article_prefix (předpona v jazyku čtenáře).');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_RSS', 'Šablona formuláře pro zadání komentářů upravena políčkem pro výběr článků');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_RSS_DESC', 'Zapněte tuto volbu, pokud jste upravovali šablonu commentform.tpl, aby obsahovala políčko pro výběr nedávných článků. V adresáři pluginu najdete příklady, jak na to.');
@define('PLUGIN_EVENT_COMMENTSPICE_STYLE_RSS', 'Styl oznámení o nedávných článcích');
@define('PLUGIN_EVENT_COMMENTSPICE_STYLE_RSS_DESC', 'Plugin vykreslí políčko pro výběr článků černě s pěknou ikonou apod. Pokud se vám to tak nelíbí, můžete toto zobrazování vypnout a ostylovat si políčko sami pomocí vlastní šablony.');

@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK', 'Vložit obsah pingbackovaných článků');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_DESC', 'Pokud nějaký cizí blog pošle tomu vašemu pingback, je známá pouze URL adresa cizího článku. Serendipity umí stáhnout i obsah cizího článku a zobrazit ho, jak to znáte z odezev (trackback). Jenom z výkonostních důvodů to Serendipit nedělá jako výchozí nastavení. Pomocí této volby umožníte pluginu uložit nastavení do serendipity_config_local.inc.php. Pokud hodnotu nemůžete změnit, pak jste už v minulosti museli zmíněné nastavení přepsat. V takovém případě byste měli vymazat vaše ruční nastavení ze souboru serendipity_config_local.inc.php, aby změny mohl provádět tento plugin.');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_LEAVE_ON', 'Ponechat: stahovat obsah');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_LEAVE_OFF', 'Ponechat: nestahovat obsah');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_FETCH', 'Změnit na: stahovat obsah');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_DONTFETCH', 'Změnit na: nestahovat obsah');

@define('PLUGIN_EVENT_COMMENTSPICE_PATH', 'Cesta k pluginům');
@define('PLUGIN_EVENT_COMMENTSPICE_PATH_DESC', 'V běžných instalacích je výchozí hodnota správně');

@define('PLUGIN_EVENT_COMMENTSPICE_EXPERTSETTINGS', 'Zobrazit pokročilá nastavení');
@define('PLUGIN_EVENT_COMMENTSPICE_STANDARDSETTINGS', 'Zobrazit základní nastavení');

@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER', 'Číst na Twitteru');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_FOOTER', 'Pokud zadáte <b>twitterové jméno</b>, ke komentáři bude přidán odkaz na Vaši časovou osu z twitteru.');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_PLACEHOLDER', 'twittername nebo jmeno@identi.ca');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_LABEL', 'Twitter');

@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_LABEL', 'Inzerovat nedávné články');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_CHOOSE', '- vyberte článek -');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_RECENT', '% píše o');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_FOOTER', '<b>Inzerujte nedávné články</b><br/>Tento blog vám umožňuje společně s Vaším komentářem inzerovat i některý z posledních článků na Vašem blogu. Jako domovksou stránku zadejte příslušnou URL adresu Vašeho blogu a objeví se políčko, ze kterého můžete vybrat nedávné články. (potřeba mít zapnutý Javascript)');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_CORRUPTED', 'Je mi líto, nepodařilo se mi stáhnout Vaše "nedávné články"...');

@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_BOO','Audio komentáře pomocí audioboo.fm');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_BOO_DESC','Pokud máte podcastovací blog, možná chcete umožnit uživatelům vkládat i audio komentáře, tzv. boo audios (mini podcasty) umístěné na <a href="http://audioboo.fm" target="_blank">audioboo.fm</a>.');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_ALLOW','Povolit boo audio komentáře');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_ALLOW_DESC','Zapněte, pokud chcete povolit audio boo komentáře. Pod políčkem pro vložení komentáře se objeví políčko pro vložení a nahrání (beta funkce!) audio boo komentářů.');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_MODERATE','Schvalovat audio boo komentáře');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_MODERATE_DESC','Zapněte, pokud mají audio boo komentáře podléhat schvalování před zveřejněním.');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_FOOTER','Tento blog Vám umožňuje vložit audio boo komentáře pomocí <a href="http://audioboo.fm/profile" target="_blank">audioboo.fm</a>. <a href="http://audioboo.fm/boos/new" target="_blank">Nahrajte nový komentář</a> a zadejte odkaz do políčka audio boo.');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_PLACEHOLDER', 'http://audioboo.fm/boos/123456-nadpis');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_WRONG', 'Je mi líto, toto nevypadá jako boo URL (http://audioboo.fm/boos/12345-nadpis)');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_MODERATED', 'Audio boo komentáře podléhají schválení před zveřejněním, prosíme o trpělivost.');

@define('PLUGIN_EVENT_COMMENTSPICE_REQUIREMENTS', 'Požadavky');
@define('PLUGIN_EVENT_COMMENTSPICE_REQUIREMENTS_COMMENTCOUNT', '%s napsaných komentářů');
@define('PLUGIN_EVENT_COMMENTSPICE_REQUIREMENTS_COMMENTLEN', 'nejméně %s znaků v komentáři');