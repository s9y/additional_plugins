<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/17
 */

@define('PLUGIN_EVENT_OUTDATE',		'Schovat/smazat staré pøíspìvky');
@define('PLUGIN_EVENT_OUTDATE_DESC',		'Pro nepøihlášené ètenáøe schová všechny pøíspìvky starší než nastavený èas, tyto pøíspìvky jsou viditelné pouze pøihlášeným uživatelùm/autorùm.');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT',		'Kdy mají být pøíspìvky schovány?');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_DESC',		'Zadejte dobu, po jejímž uplynutí od vydání bude pøíspìvek schován. (ve dnech, 0 pro deaktivaci volby)');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY',		'Kdy mají být pøíspìvky "odlepeny"?');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY_DESC',		'Zadejte dobu, po jejímž uplynutí od vydání bude pøíspìveku zrušen pøíznak "pøilepený". (ve dnech, 0 pro deaktivaci volby)');

@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY',		'Pøídavné pole "Datum expirace"');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY_FIELD',		'Pokud používáte pøídavný modul "Rozšíøené vlastnosti pøíspìvkù", mùžete definovat pøídavné pole, do kterého zadáte datum, kdy pøíspìvku vyprší platnost. Datum musí mít formát RRRR-MM-DD. Tento plugin najde toto datum vypršení platnosti a nastaví pøíspìvek jako KONCEPT, takže zmizí ze zobrazení pøíspìvkù. Zde zadejte název pøídavného pole (napøíklad "DatumExpirace").');
