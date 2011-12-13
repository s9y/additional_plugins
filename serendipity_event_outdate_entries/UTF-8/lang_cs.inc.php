<?php # lang_cs.inc.php 1.1 2009-02-23 17:22:38 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/17
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/23
 */

@define('PLUGIN_EVENT_OUTDATE',		'Schovat/smazat staré příspěvky');
@define('PLUGIN_EVENT_OUTDATE_DESC',		'Pro nepřihlášené čtenáře schová všechny příspěvky starší než nastavený čas, tyto příspěvky jsou viditelné pouze přihlášeným uživatelům/autorům.');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT',		'Kdy mají být příspěvky schovány?');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_DESC',		'Zadejte dobu, po jejímž uplynutí od vydání bude příspěvek schován. (ve dnech, 0 pro deaktivaci volby)');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY',		'Kdy mají být příspěvky "odlepeny"?');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY_DESC',		'Zadejte dobu, po jejímž uplynutí od vydání bude příspěveku zrušen příznak "přilepený". (ve dnech, 0 pro deaktivaci volby)');

@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY',		'Přídavné pole "Datum expirace"');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY_FIELD',		'Pokud používáte přídavný modul "Rozšířené vlastnosti příspěvků", můžete definovat přídavné pole, do kterého zadáte datum, kdy příspěvku vyprší platnost. Datum musí mít formát RRRR-MM-DD. Tento plugin najde toto datum vypršení platnosti a nastaví příspěvek jako KONCEPT, takže zmizí ze zobrazení příspěvků. Zde zadejte název přídavného pole (například "DatumExpirace").');
