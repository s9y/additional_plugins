<?php # $Id$

/**
 *  @version $Revision$
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: 1.4
 */

@define('PLUGIN_POPULARENTRIES_TITLE', 'Популярни статии');
@define('PLUGIN_POPULARENTRIES_BLAHBLAH', 'Показва заглавията и броя на коментарите на най-популярните статии. Популярността се изчислява според броя на коментарите към статиите.');
@define('PLUGIN_POPULARENTRIES_NUMBER', 'Брой статии');
@define('PLUGIN_POPULARENTRIES_NUMBER_BLAHBLAH', 'Брой на статиите, чиито заглавия да се показват. (По подразбиране: 10)');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM', 'Прескачане на показаните статии');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM_DESC', 'Заглавията на статиите, които са изведени в блога ще бъдат пропуснати. (По подразбиране последните ' . $serendipity['fetchLimit'] . ' ще бъдат прескочени.)');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM_RADIO_ALL', 'Всички');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM_RADIO_POPULAR', 'Прескачане');
@define('PLUGIN_POPULARENTRIES_SORTBY', 'Сортиране на статиите:');
@define('PLUGIN_POPULARENTRIES_SORTBY_COMMENTS', 'коментари');
@define('PLUGIN_POPULARENTRIES_SORTBY_VISITS', 'най-много посещения [изисква приставка \'карма\']');
@define('PLUGIN_POPULARENTRIES_SORTBY_LOWVISITS', 'най-малко посещения [изисква приставка \'карма\']');
@define('PLUGIN_POPULARENTRIES_SORTBY_KARMAVOTES', 'карма [изисква приставка \'карма\']');
@define('PLUGIN_POPULARENTRIES_SORTBY_EXITS', 'изход към външни връзки [изисква приставка Track Exits]');
