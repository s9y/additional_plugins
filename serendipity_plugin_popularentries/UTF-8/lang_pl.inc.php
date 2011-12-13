<?php # $Id: lang_pl.inc.php,v 1.1 2007/05/30 08:47:32 garvinhicking Exp $

/**
 *  @version $Revision: 1.1 $
 *  @author Kostas CoSTa Brzezinski (costa@kofeina.net)
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_POPULARENTRIES_TITLE', 'Popularne wpisy');
@define('PLUGIN_POPULARENTRIES_BLAHBLAH', 'Pokazuje tytuły i ilość komentarzy najpopularniejszych wpisów.');
@define('PLUGIN_POPULARENTRIES_NUMBER', 'Ilość wpisów');
@define('PLUGIN_POPULARENTRIES_NUMBER_BLAHBLAH', 'Jak wiele tytułów wpisów ma być pokazanych? (Standardowo: 10)');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM', 'Pomiń wspisy ze strony startowej');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM_DESC', 'Tylko ostatnie wpisy poza tymi wyświetlonymi na stronie głównej będą pokazane. (Standardowo: ostatnie ' . $serendipity['fetchLimit'] . ' będzie pominięte)');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM_RADIO_ALL', 'Pokaż wszystkie');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM_RADIO_POPULAR', 'Pomiń wpisy ze strony startowej');
@define('PLUGIN_POPULARENTRIES_SORTBY', 'Sortuj wpisy po:');
@define('PLUGIN_POPULARENTRIES_SORTBY_COMMENTS', 'ilości komentarzy');
@define('PLUGIN_POPULARENTRIES_SORTBY_VISITS', 'największej ilości wizyt [wymaga wtyczki Karma]');
@define('PLUGIN_POPULARENTRIES_SORTBY_LOWVISITS', 'najmniejszej ilości wizyt [wymaga wtyczki Karma]');
@define('PLUGIN_POPULARENTRIES_SORTBY_KARMAVOTES', 'karmie [wymaga wtyczki Karma]');
@define('PLUGIN_POPULARENTRIES_SORTBY_EXITS', 'wyjściach (top-exits) [wymaga wtyczki Track Exits]');

?>
