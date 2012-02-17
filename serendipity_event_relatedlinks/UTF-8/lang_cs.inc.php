<?php # lang_cs.inc.php 0.2 2009-02-23 17:23:05 VladaAjgl $

/**
 *  @version 0.2
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/15
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/23
 */

@define('PLUGIN_EVENT_RELATEDLINKS_TITLE',		'Odkazy na podobné príspevky/stránky');
@define('PLUGIN_EVENT_RELATEDLINKS_DESC',		'Vložte odkazy na podobné príspevky/stránky. K lepšímu prizpusobení výstupu mužete upravit Smarty šablonu "plugin_relatedlinks.tpl". Tento modul zobrazuje data pouze v detailním zobrazení príspevku.');
@define('PLUGIN_EVENT_RELATEDLINKS_ENTERDESC',		'Vložte odkazy, které chcete zobrazit. Jedno URL (žádné HTML) na rádku (tzn. oddelené koncem rádky). Chcete-li vložit popis, použijte tento formát: http://priklad.cz/odkaz.html=Nejaký odkaz. Vše za znakem "=" bude použito jako popis. Pokud není popis vložen, zobrazí se místo nej samotná adresa (URL).');
@define('PLUGIN_EVENT_RELATEDLINKS_LIST',		'Podobné príspevky/stránky:');

@define('PLUGIN_EVENT_RELATEDLINKS_POSITION',		'Umístení odkazu na podobné stránky');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_DESC',		'Pridat seznam odkazu do zápatí príspevku nebo použít Smarty šablony? Pokud aktivujete Smarty šablony, budete muset do své šablony entries.tpl do foreach cyklu, kde je nastaveno $entry (tzn. tam, kde se zobrazují komentáre rozšírená verze príspevku) pridat: {serendipity_hookPlugin hook="frontend_display_relatedlinks" data=$entry hookAll="true"}{$RELATEDLINKS}');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_FOOTER',		'Umístit v zápatí príspevku');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_BODY',		'Umístit v tele príspevku');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_SMARTY',		'Použít Smarty');

@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR',		'Znak pro oddělení odkazů');
@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR_DESC',		'Zadejte znak, který bude oddělovat URL adresy a popisky. Buďte opatrní při jeho výběru, nesmí existovat ani v URL ani v popisku. Vhodný znak je třeba "|".');

