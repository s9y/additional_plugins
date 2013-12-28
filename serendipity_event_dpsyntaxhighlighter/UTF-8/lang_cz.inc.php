<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/31
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/03/06
 */

@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_NAME', 'Zvýrazňovač syntaxe dp.SyntaxHighlighter');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_DESC', 'Tento plugin je JavaScriptový zvýrazňovač syntaxe založený na stejnojmeném kódu Alexe Gorbačeva.'
       .'Tento plugin zatěžuje server méně než GeSHi a vkládá méně značek do HTML kódu. Představuje čistější, odlehčenější alternativu ke GeSHi. '
       .'Plugin vyžaduje použití šablony vzhledu, který podporuje následující hooky: frontend_header, frontend_footer (a volitelně také backend_preview pro'
       .'zobrazování i v administrační sekci).');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_PATH', 'Cesta ke skriptům');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_PATH_DESC', 'Zadejte plnou HTTP cestu (všechno po názvu Vaší domény), která vede do adresáře s tímto pluginem.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_THEME', 'Vyberte téma (šablonu vzhledu)');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_THEME_DESC', 'Vyberte téma (šablonu vzhledu, styl) pro zvýraznění syntaxe, která se nejlépe hodí k Vašemu blogu.');