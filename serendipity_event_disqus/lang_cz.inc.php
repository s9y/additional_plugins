/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2011/06/19
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/06/22
 */
@define('PLUGIN_DISQUS_TITLE', 'Komentáøe Disqus');
@define('PLUGIN_DISQUS_DESC', 'Disqus.com je webová slu¾ba pro správu komentáøù. Ukládá a spravuje komentáøe vnì instalace serendipity a je do blogu vkládána pomocí JavaScriptu. Pro více informací pøejdìte na www.disqus.com.');
@define('PLUGIN_DISQUS_DESC2', 'Kdy¾ jsou zapnuté komentáøe disqus, pak pøirozenì nefungují vestavìné funkce serendipity tıkající se komentáøù.

Vnitønì tento plugin pou¾ívá CSS ke skrytí komentáøù, formuláøù a odezev serendipity. Nastavuje vlastnost "display:none" pro následující tøídy CSS:

.serendipity_comments
.serendipity_section_comments
.serendipity_section_trackbacks
.serendipity_section_commentform

Pokud va¹e ¹ablona/styl vzhledu pou¾ívá jiné názvy, musíte tyto názvy pøidat do názvù tøíd va¹í ¹ablony, a nebo musíte schovat komentáøe sami.

Plugin umístí vıstup komentáøù disqus do promìnné Smarty {$entry.plugin_display_dat} A {$entry.disqus}, které mù¾ete umístit do ¹ablony entries.tpl na libovolné místo ve smyèce {$entry}.
');
@define('PLUGIN_DISQUS_ENABLE_SINCE', 'Povolit disqus.com pro pøíspìvky od...');
@define('PLUGIN_DISQUS_ENABLE_SINCE_DESC', 'Zadejte datum (R-m-d), po kterém se budou zobrazovat komentáøe disqus místo vestavìnıch komentáøù serendipity. Star¹í komentáøe se budou zobrazovat správnì z databáze serendipity.');
@define('PLUGIN_DISQUS_SHORTNAME', 'Krátkı název úètu disqus');
@define('PLUGIN_DISQUS_SHORTNAME_DESC', 'Zadejte krátkı název (shortname), které jste si zaregistrovali pod úètem disqus.');

// Next lines were translated on 2012/06/22
@define('PLUGIN_DISQUS_FOOTERCOMMENTLINK', 'Nechat nastavit DISQUS poèet komentáøù v patièce');
@define('PLUGIN_DISQUS_FOOTERCOMMENTLINK_DESC', 'Proto¾e poèet komentáøù k pøíspìvku obecnì není známı, tento plugin vkládá do patièky pouze text "Komentáøe" místo správného "N komentáøù". Mù¾ete nechat DISQUS, aby tento text správnì nahrazoval, ale v nìkterıch ¹ablonách se to nemusí zobrazovat korektnì. Pak zde mù¾ete dynamické nahrazení poètu komentáøù vypnout.');
@define('PLUGIN_DISQUS_HIDE_COMMENTCSS', 'Skrıt css komentáøù');
@define('PLUGIN_DISQUS_HIDE_COMMENTCSS_DESC', 'Pokud jsou komentáøe disqus.com nainstalovány a zapnuty, ¾ádná z funkcí, která závisí na interních komentáøích seerendipity nebude fungovat. Tento plugin internì pou¾ívá CSS styly ke skrytí komentáøù Serendipity a formuláøe pro jejich vlo¾ení. Dìje se tak prostım nastavením vlastnosti "display:none" pro pøíslu¹né CSS tøídy. Zadejte zde prosím CSS tøídy, které pou¾íváte ve va¹í ¹ablonì k zobrazení komentáøù a formuláøe pro jejich vlo¾ení. Vıchozí nastavení bude fungovat na vìt¹inì ¹ablon (stylù vzhledu).');