<?php # lang_cs.inc.php 1.1 2009-08-26 20:49:30 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/22
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/08/26
 */

@define('PLUGIN_EVENT_GESHI_NAME',		'Markup: GeSHi');
@define('PLUGIN_EVENT_GESHI_DESC',		'Barevné zvýrazňování syntaxe počítačových jazyků. Použití tagů: [geshi lang=nazev_jazyku [,ln={y|n}]]programový kód[/geshi]');
@define('PLUGIN_EVENT_GESHI_TRANSFORM',		'Pro vložení zdrojového kódu můžete použít tag <b>[geshi lang=nazev_jazyku [,ln={y|n}]] [/geshi]</b>');
@define('PLUGIN_EVENT_GESHI_VERSION',		'03');
@define('PLUGIN_EVENT_GESHI_PATHTOGESHI',		'Cesta k GeSHi');
@define('PLUGIN_EVENT_GESHI_PATHTOGESHI_DESC',		'Cesta k instalaci balíčku GeSHi, relativně ke kořenovému adresáři Serendipity');
@define('PLUGIN_EVENT_GESHI_SHOWLINENUMBERS',		'Číslování řádků?');
@define('PLUGIN_EVENT_GESHI_SHOWLINENUMBERS_DESC',		'Mají se standardně zobrazovat čísla řádků?');