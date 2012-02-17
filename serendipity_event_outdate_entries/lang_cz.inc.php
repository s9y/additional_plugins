<?php # lang_cz.inc.php 1.0 2009-02-17 18:53:19 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/17
 */

@define('PLUGIN_EVENT_OUTDATE',		'Schovat/smazat staré pøíspìvky');
@define('PLUGIN_EVENT_OUTDATE_DESC',		'Pro nepøihlá¹ené ètenáøe schová v¹echny pøíspìvky star¹í ne¾ nastavený èas, tyto pøíspìvky jsou viditelné pouze pøihlá¹eným u¾ivatelùm/autorùm.');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT',		'Kdy mají být pøíspìvky schovány?');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_DESC',		'Zadejte dobu, po jejím¾ uplynutí od vydání bude pøíspìvek schován. (ve dnech, 0 pro deaktivaci volby)');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY',		'Kdy mají být pøíspìvky "odlepeny"?');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY_DESC',		'Zadejte dobu, po jejím¾ uplynutí od vydání bude pøíspìveku zru¹en pøíznak "pøilepený". (ve dnech, 0 pro deaktivaci volby)');

@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY',		'Pøídavné pole "Datum expirace"');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY_FIELD',		'Pokud pou¾íváte pøídavný modul "Roz¹íøené vlastnosti pøíspìvkù", mù¾ete definovat pøídavné pole, do kterého zadáte datum, kdy pøíspìvku vypr¹í platnost. Datum musí mít formát RRRR-MM-DD. Tento plugin najde toto datum vypr¹ení platnosti a nastaví pøíspìvek jako KONCEPT, tak¾e zmizí ze zobrazení pøíspìvkù. Zde zadejte název pøídavného pole (napøíklad "DatumExpirace").');
