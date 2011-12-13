<?php # lang_cz.inc.php 1.0 2009-08-14 20:11:04 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/08/14
 */

@define('PLUGIN_POPULARENTRIES_TITLE', 'Oblíbené příspěvky');
@define('PLUGIN_POPULARENTRIES_BLAHBLAH', 'Zobrazuje nadpisy a počet komentářů nejoblíbenějších příspěvků. Oblíbenost je počítána na základě množství komentářů.');
@define('PLUGIN_POPULARENTRIES_NUMBER', 'Počet příspěvků');
@define('PLUGIN_POPULARENTRIES_NUMBER_BLAHBLAH', 'Kolik příspěvků má být zobrazeno? (výchozí: 10)');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM', 'Přeskočit příspěvky z úvodní strany');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM_DESC', 'Z nejnovějších příspěvků budou zobrazovány pouze ty, které nejsou na úvodní stránce blogu. (výchozí: ' . $serendipity['fetchLimit'] . ' nejnovějších příspěvků bude přeskočeno)');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM_RADIO_ALL', 'Zobrazit vše');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM_RADIO_POPULAR', 'Přeskočit příspěvky z úvodní strany');
@define('PLUGIN_POPULARENTRIES_SORTBY', 'Řadit příspěvky podle:');
@define('PLUGIN_POPULARENTRIES_SORTBY_COMMENTS', 'počtu komentářů');
@define('PLUGIN_POPULARENTRIES_SORTBY_COMMENTORS', 'počtu komentujících osob');
@define('PLUGIN_POPULARENTRIES_SORTBY_VISITS', 'největšího počtu návštěv [vyžaduje nainstalovaný plugin "karma"]');
@define('PLUGIN_POPULARENTRIES_SORTBY_LOWVISITS', 'nejmenšího počtu návštěv [vyžaduje nainstalovaný plugin "karma"]');
@define('PLUGIN_POPULARENTRIES_SORTBY_KARMAVOTES', 'karmy [vyžaduje nainstalovaný plugin "karma"]');
@define('PLUGIN_POPULARENTRIES_SORTBY_EXITS', 'počtu odkazů [vyžaduje nainstalovaný plugin "Sledování odkazů (Track Exits)"]');
@define('PLUGIN_POPULARENTRIES_SORTBY_COMMENTORS_FILTER', 'Filtrování komentujících osob');
@define('PLUGIN_POPULARENTRIES_SORTBY_COMMENTORS_FILTER_DESC', 'Čárkami oddělený seznam (bez mezer) jmen koemntujících osob, které budou odfiltrovány při řazení podle počtu komentujících osob.');