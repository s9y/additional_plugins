<?php # lang_cs.inc.php 1.0 2009-06-04 20:07:09 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/04
 */

@define('PLUGIN_EVENT_CACHESIMPLE_NAME',     'Jednoduché cachování / předgenerování stránek');
@define('PLUGIN_EVENT_CACHESIMPLE_DESC',     '[EXPERIMENTÁLNÍ] Umožňuje cachování (ve smyslu předgenerování) stránek. Pozor: Absolutně zruší veškeré vymoženosti dynamicky vytvářeného obsahu, nepracuje dobře s pluginy, které takový obsah vytvářejí. Ale tato funkce zvyšuje rychlost blogu, pokud nepotřebujete dynamické funkce. (Tento plugin by měl být umístěn co nejdříve v seznamu pluginů. Pouze nutné pluginy generující dynamický obsah, jako např. karma, by měly být umístěny před tímto pluginem.)');
@define('PLUGIN_EVENT_CACHESIMPLE_BROWSER', 'Použít zvlášť cache pro Internet Explorer a Mozillu?');
@define('PLUGIN_EVENT_CACHESIMPLE_KEEPFRESH', 'Vynutit obnovování čerstvé kopie na straně klienta?');
@define('PLUGIN_EVENT_CACHESIMPLE_KEEPFRESH_DESC', 'Tím, že nebude posílána hlavička "Expires", lze klienty (prohlížeče) přinutit, aby lokálně necachovali stránky. To přinutí klienty žádat server o stránku při každém pokusu o její zobrazení. Dobré prohlížeče přesto používají někteér "ověřovací" techniky pro minimalizaci datového toku mezi serverem a klientem. Tato volby zabrání problémům typu, že se komentář nezobrazí ihned poté, co byl přidán, ale bude to 
také zpomalovat rychlost načítání.');

?>
