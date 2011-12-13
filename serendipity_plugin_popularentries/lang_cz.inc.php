<?php # lang_cz.inc.php 1.0 2009-08-14 20:11:04 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/08/14
 */

@define('PLUGIN_POPULARENTRIES_TITLE', 'Oblíbené pøíspìvky');
@define('PLUGIN_POPULARENTRIES_BLAHBLAH', 'Zobrazuje nadpisy a poèet komentáøù nejoblíbenìj¹ích pøíspìvkù. Oblíbenost je poèítána na základì mno¾ství komentáøù.');
@define('PLUGIN_POPULARENTRIES_NUMBER', 'Poèet pøíspìvkù');
@define('PLUGIN_POPULARENTRIES_NUMBER_BLAHBLAH', 'Kolik pøíspìvkù má být zobrazeno? (výchozí: 10)');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM', 'Pøeskoèit pøíspìvky z úvodní strany');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM_DESC', 'Z nejnovìj¹ích pøíspìvkù budou zobrazovány pouze ty, které nejsou na úvodní stránce blogu. (výchozí: ' . $serendipity['fetchLimit'] . ' nejnovìj¹ích pøíspìvkù bude pøeskoèeno)');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM_RADIO_ALL', 'Zobrazit v¹e');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM_RADIO_POPULAR', 'Pøeskoèit pøíspìvky z úvodní strany');
@define('PLUGIN_POPULARENTRIES_SORTBY', 'Øadit pøíspìvky podle:');
@define('PLUGIN_POPULARENTRIES_SORTBY_COMMENTS', 'poètu komentáøù');
@define('PLUGIN_POPULARENTRIES_SORTBY_COMMENTORS', 'poètu komentujících osob');
@define('PLUGIN_POPULARENTRIES_SORTBY_VISITS', 'nejvìt¹ího poètu náv¹tìv [vy¾aduje nainstalovaný plugin "karma"]');
@define('PLUGIN_POPULARENTRIES_SORTBY_LOWVISITS', 'nejmen¹ího poètu náv¹tìv [vy¾aduje nainstalovaný plugin "karma"]');
@define('PLUGIN_POPULARENTRIES_SORTBY_KARMAVOTES', 'karmy [vy¾aduje nainstalovaný plugin "karma"]');
@define('PLUGIN_POPULARENTRIES_SORTBY_EXITS', 'poètu odkazù [vy¾aduje nainstalovaný plugin "Sledování odkazù (Track Exits)"]');
@define('PLUGIN_POPULARENTRIES_SORTBY_COMMENTORS_FILTER', 'Filtrování komentujících osob');
@define('PLUGIN_POPULARENTRIES_SORTBY_COMMENTORS_FILTER_DESC', 'Èárkami oddìlený seznam (bez mezer) jmen koemntujících osob, které budou odfiltrovány pøi øazení podle poètu komentujících osob.');