<?php # lang_cz.inc.php 1.1 2010-03-06 22:06:13 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/31
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/03/06
 */

@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_NAME', 'Zvýrazòovaè syntaxe dp.SyntaxHighlighter');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_DESC', 'Tento plugin je JavaScriptový zvýrazòovaè syntaxe zalo¾ený na stejnojmeném kódu Alexe Gorbaèeva.'
       .'Tento plugin zatì¾uje server ménì ne¾ GeSHi a vkládá ménì znaèek do HTML kódu. Pøedstavuje èistìj¹í, odlehèenìj¹í alternativu ke GeSHi. '
       .'Plugin vy¾aduje pou¾ití ¹ablony vzhledu, který podporuje následující hooky: frontend_header, frontend_footer (a volitelnì také backend_preview pro'
       .'zobrazování i v administraèní sekci).');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_PATH', 'Cesta ke skriptùm');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_PATH_DESC', 'Zadejte plnou HTTP cestu (v¹echno po názvu Va¹í domény), která vede do adresáøe s tímto pluginem.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_THEME', 'Vyberte téma (¹ablonu vzhledu)');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_THEME_DESC', 'Vyberte téma (¹ablonu vzhledu, styl) pro zvýraznìní syntaxe, která se nejlépe hodí k Va¹emu blogu.');