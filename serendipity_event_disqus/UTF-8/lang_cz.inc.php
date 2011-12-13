<?php # lang_cz.inc.php 1.0 2011-06-19 09:27:10 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2011/06/19
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