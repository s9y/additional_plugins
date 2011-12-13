<?php # lang_cs.inc.php 1.0 2009-06-08 19:33:40 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/08
 */

//
//  serendipity_event_xsstrust
//
@define('PLUGIN_EVENT_XSSTRUST_NAME',     'Nástroje pro důvěryhodnou správu více-uživatelských blogů');
@define('PLUGIN_EVENT_XSSTRUST_DESC',     'Tento plugin umožňuje upřesnit, kteří autoři na více-uživatelském blogu jsou důvěryhodní a lze se spolehnout, že se nebudou pokoušet o hackování. Všichni ostatní autoři jsou bráni jako potenciálně nebezpeční a nemohou vytvřátet příspěvky v HTML kódu.');
@define('PLUGIN_EVENT_XSSTRUST_AUTHORS',  'Důvěryhodní autoři');

//
//  serendipity_plugin_xsstrust
//
@define('PLUGIN_ETHICS_NAME', 'Zobrazit důvěryhodné autory');
@define('PLUGIN_ETHICS_INTRO', 'Tento plugin zobrazuje autory se zobrazením jejich etické úrovně, semafor má následující význam:');
@define('PLUGIN_ETHICS_REDLIGHT', 'zakázaný');
@define('PLUGIN_ETHICS_YELLOWLIGHT', 'podezřelý');
@define('PLUGIN_ETHICS_GREENLIGHT', 'v pohodě');
@define('PLUGIN_ETHICS_BLAHBLAH', 'Zobrazuje uživatele s vyobrazením jejich etické úrovně (vyjádřenou semaforem
).Zelená znamená "'.PLUGIN_ETHICS_GREENLIGHT.'"; oranžová znamená "'.PLUGIN_ETHICS_YELLOWLIGHT.'"; a červená znamená "'.PLUGIN_ETHICS_REDLIGHT.'". Administrátor může lehce měnit tyto hodnoty u jednotlivých uživatelů.');
@define('PLUGIN_ETHICS_BASEVAL', 'Výchozí úroveň etické úrovně autora');
@define('PLUGIN_ETHICS_BASEVAL_BLAHBLAH', 'Výchozů úroveň (1 = zelená; 2 = oranžová; 3 = červená; přednastaveno: 1)');

?>
