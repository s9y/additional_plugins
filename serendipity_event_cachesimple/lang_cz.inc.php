/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/04
 */

@define('PLUGIN_EVENT_CACHESIMPLE_NAME',     'Jednoduché cachování / pøedgenerování stránek');
@define('PLUGIN_EVENT_CACHESIMPLE_DESC',     '[EXPERIMENTÁLNÍ] Umo¾òuje cachování (ve smyslu pøedgenerování) stránek. Pozor: Absolutnì zru¹í ve¹keré vymo¾enosti dynamicky vytváøeného obsahu, nepracuje dobøe s pluginy, které takový obsah vytváøejí. Ale tato funkce zvy¹uje rychlost blogu, pokud nepotøebujete dynamické funkce. (Tento plugin by mìl být umístìn co nejdøíve v seznamu pluginù. Pouze nutné pluginy generující dynamický obsah, jako napø. karma, by mìly být umístìny pøed tímto pluginem.)');
@define('PLUGIN_EVENT_CACHESIMPLE_BROWSER', 'Pou¾ít zvlá¹» cache pro Internet Explorer a Mozillu?');
@define('PLUGIN_EVENT_CACHESIMPLE_KEEPFRESH', 'Vynutit obnovování èerstvé kopie na stranì klienta?');
@define('PLUGIN_EVENT_CACHESIMPLE_KEEPFRESH_DESC', 'Tím, ¾e nebude posílána hlavièka "Expires", lze klienty (prohlí¾eèe) pøinutit, aby lokálnì necachovali stránky. To pøinutí klienty ¾ádat server o stránku pøi ka¾dém pokusu o její zobrazení. Dobré prohlí¾eèe pøesto pou¾ívají nìkteér "ovìøovací" techniky pro minimalizaci datového toku mezi serverem a klientem. Tato volby zabrání problémùm typu, ¾e se komentáø nezobrazí ihned poté, co byl pøidán, ale bude to 
také zpomalovat rychlost naèítání.');

?>
