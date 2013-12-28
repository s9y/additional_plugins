<?php

/**
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/15
 */

@define('PLUGIN_EVENT_RELATEDLINKS_TITLE',		'Odkazy na podobné príspevky/stránky');
@define('PLUGIN_EVENT_RELATEDLINKS_DESC',		'Vlo¾te odkazy na podobné príspevky/stránky. K lep¹ímu prizpusobení výstupu mu¾ete upravit Smarty ¹ablonu "plugin_relatedlinks.tpl". Tento modul zobrazuje data pouze v detailním zobrazení príspevku.');
@define('PLUGIN_EVENT_RELATEDLINKS_ENTERDESC',		'Vlo¾te odkazy, které chcete zobrazit. Jedno URL (¾ádné HTML) na rádku (tzn. oddelené koncem rádky). Chcete-li vlo¾it popis, pou¾ijte tento formát: http://priklad.cz/odkaz.html=Nejaký odkaz. V¹e za znakem "=" bude pou¾ito jako popis. Pokud není popis vlo¾en, zobrazí se místo nej samotná adresa (URL).');
@define('PLUGIN_EVENT_RELATEDLINKS_LIST',		'Podobné príspevky/stránky:');

@define('PLUGIN_EVENT_RELATEDLINKS_POSITION',		'Umístení odkazu na podobné stránky');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_DESC',		'Pridat seznam odkazu do zápatí príspevku nebo pou¾ít Smarty ¹ablony? Pokud aktivujete Smarty ¹ablony, budete muset do své ¹ablony entries.tpl do foreach cyklu, kde je nastaveno $entry (tzn. tam, kde se zobrazují komentáre roz¹írená verze príspevku) pridat: {serendipity_hookPlugin hook="frontend_display_relatedlinks" data=$entry hookAll="true"}{$RELATEDLINKS}');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_FOOTER',		'Umístit v zápatí príspevku');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_BODY',		'Umístit v tele príspevku');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_SMARTY',		'Pou¾ít Smarty');

@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR',		'Znak pro oddìlení odkazù');
@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR_DESC',		'Zadejte znak, který bude oddìlovat URL adresy a popisky. Buïte opatrní pøi jeho výbìru, nesmí existovat ani v URL ani v popisku. Vhodný znak je tøeba "|".');

