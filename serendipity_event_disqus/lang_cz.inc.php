<?php # lang_cz.inc.php 1.0 2011-06-19 09:27:10 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2011/06/19
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