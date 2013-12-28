<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/31
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/03/06
 */

@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_NAME', 'Zvýrazòovaè syntaxe dp.SyntaxHighlighter');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_DESC', 'Tento plugin je JavaScriptový zvýrazòovaè syntaxe založený na stejnojmeném kódu Alexe Gorbaèeva.'
       .'Tento plugin zatìžuje server ménì než GeSHi a vkládá ménì znaèek do HTML kódu. Pøedstavuje èistìjší, odlehèenìjší alternativu ke GeSHi. '
       .'Plugin vyžaduje použití šablony vzhledu, který podporuje následující hooky: frontend_header, frontend_footer (a volitelnì také backend_preview pro'
       .'zobrazování i v administraèní sekci).');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_PATH', 'Cesta ke skriptùm');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_PATH_DESC', 'Zadejte plnou HTTP cestu (všechno po názvu Vaší domény), která vede do adresáøe s tímto pluginem.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_THEME', 'Vyberte téma (šablonu vzhledu)');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_THEME_DESC', 'Vyberte téma (šablonu vzhledu, styl) pro zvýraznìní syntaxe, která se nejlépe hodí k Vašemu blogu.');