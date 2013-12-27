/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/04
 */

@define('PLUGIN_EVENT_CACHESIMPLE_NAME',     'Jednoduché cachování / pøedgenerování stránek');
@define('PLUGIN_EVENT_CACHESIMPLE_DESC',     '[EXPERIMENTÁLNÍ] Umožòuje cachování (ve smyslu pøedgenerování) stránek. Pozor: Absolutnì zruší veškeré vymoženosti dynamicky vytváøeného obsahu, nepracuje dobøe s pluginy, které takový obsah vytváøejí. Ale tato funkce zvyšuje rychlost blogu, pokud nepotøebujete dynamické funkce. (Tento plugin by mìl být umístìn co nejdøíve v seznamu pluginù. Pouze nutné pluginy generující dynamický obsah, jako napø. karma, by mìly být umístìny pøed tímto pluginem.)');
@define('PLUGIN_EVENT_CACHESIMPLE_BROWSER', 'Použít zvláš cache pro Internet Explorer a Mozillu?');
@define('PLUGIN_EVENT_CACHESIMPLE_KEEPFRESH', 'Vynutit obnovování èerstvé kopie na stranì klienta?');
@define('PLUGIN_EVENT_CACHESIMPLE_KEEPFRESH_DESC', 'Tím, že nebude posílána hlavièka "Expires", lze klienty (prohlížeèe) pøinutit, aby lokálnì necachovali stránky. To pøinutí klienty žádat server o stránku pøi každém pokusu o její zobrazení. Dobré prohlížeèe pøesto používají nìkteér "ovìøovací" techniky pro minimalizaci datového toku mezi serverem a klientem. Tato volby zabrání problémùm typu, že se komentáø nezobrazí ihned poté, co byl pøidán, ale bude to 
také zpomalovat rychlost naèítání.');

?>
