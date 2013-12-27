/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2011/06/19
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/06/22
 */
@define('PLUGIN_DISQUS_TITLE', 'Komentáře Disqus');
@define('PLUGIN_DISQUS_DESC', 'Disqus.com je webová služba pro správu komentářů. Ukládá a spravuje komentáře vně instalace serendipity a je do blogu vkládána pomocí JavaScriptu. Pro více informací přejděte na www.disqus.com.');
@define('PLUGIN_DISQUS_DESC2', 'Když jsou zapnuté komentáře disqus, pak přirozeně nefungují vestavěné funkce serendipity týkající se komentářů.

Vnitřně tento plugin používá CSS ke skrytí komentářů, formulářů a odezev serendipity. Nastavuje vlastnost "display:none" pro následující třídy CSS:

.serendipity_comments
.serendipity_section_comments
.serendipity_section_trackbacks
.serendipity_section_commentform

Pokud vaše šablona/styl vzhledu používá jiné názvy, musíte tyto názvy přidat do názvů tříd vaší šablony, a nebo musíte schovat komentáře sami.

Plugin umístí výstup komentářů disqus do proměnné Smarty {$entry.plugin_display_dat} A {$entry.disqus}, které můžete umístit do šablony entries.tpl na libovolné místo ve smyčce {$entry}.
');
@define('PLUGIN_DISQUS_ENABLE_SINCE', 'Povolit disqus.com pro příspěvky od...');
@define('PLUGIN_DISQUS_ENABLE_SINCE_DESC', 'Zadejte datum (R-m-d), po kterém se budou zobrazovat komentáře disqus místo vestavěných komentářů serendipity. Starší komentáře se budou zobrazovat správně z databáze serendipity.');
@define('PLUGIN_DISQUS_SHORTNAME', 'Krátký název účtu disqus');
@define('PLUGIN_DISQUS_SHORTNAME_DESC', 'Zadejte krátký název (shortname), které jste si zaregistrovali pod účtem disqus.');

// Next lines were translated on 2012/06/22
@define('PLUGIN_DISQUS_FOOTERCOMMENTLINK', 'Nechat nastavit DISQUS počet komentářů v patičce');
@define('PLUGIN_DISQUS_FOOTERCOMMENTLINK_DESC', 'Protože počet komentářů k příspěvku obecně není známý, tento plugin vkládá do patičky pouze text "Komentáře" místo správného "N komentářů". Můžete nechat DISQUS, aby tento text správně nahrazoval, ale v některých šablonách se to nemusí zobrazovat korektně. Pak zde můžete dynamické nahrazení počtu komentářů vypnout.');
@define('PLUGIN_DISQUS_HIDE_COMMENTCSS', 'Skrýt css komentářů');
@define('PLUGIN_DISQUS_HIDE_COMMENTCSS_DESC', 'Pokud jsou komentáře disqus.com nainstalovány a zapnuty, žádná z funkcí, která závisí na interních komentářích seerendipity nebude fungovat. Tento plugin interně používá CSS styly ke skrytí komentářů Serendipity a formuláře pro jejich vložení. Děje se tak prostým nastavením vlastnosti "display:none" pro příslušné CSS třídy. Zadejte zde prosím CSS třídy, které používáte ve vaší šabloně k zobrazení komentářů a formuláře pro jejich vložení. Výchozí nastavení bude fungovat na většině šablon (stylů vzhledu).');