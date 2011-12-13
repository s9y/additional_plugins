<?php # lang_cz.inc.php 1.0 2009-06-08 19:33:40 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/08
 */

//
//  serendipity_event_xsstrust
//
@define('PLUGIN_EVENT_XSSTRUST_NAME',     'Nástroje pro dùvìryhodnou správu více-u¾ivatelských blogù');
@define('PLUGIN_EVENT_XSSTRUST_DESC',     'Tento plugin umo¾òuje upøesnit, kteøí autoøi na více-u¾ivatelském blogu jsou dùvìryhodní a lze se spolehnout, ¾e se nebudou pokou¹et o hackování. V¹ichni ostatní autoøi jsou bráni jako potenciálnì nebezpeèní a nemohou vytvøátet pøíspìvky v HTML kódu.');
@define('PLUGIN_EVENT_XSSTRUST_AUTHORS',  'Dùvìryhodní autoøi');

//
//  serendipity_plugin_xsstrust
//
@define('PLUGIN_ETHICS_NAME', 'Zobrazit dùvìryhodné autory');
@define('PLUGIN_ETHICS_INTRO', 'Tento plugin zobrazuje autory se zobrazením jejich etické úrovnì, semafor má následující význam:');
@define('PLUGIN_ETHICS_REDLIGHT', 'zakázaný');
@define('PLUGIN_ETHICS_YELLOWLIGHT', 'podezøelý');
@define('PLUGIN_ETHICS_GREENLIGHT', 'v pohodì');
@define('PLUGIN_ETHICS_BLAHBLAH', 'Zobrazuje u¾ivatele s vyobrazením jejich etické úrovnì (vyjádøenou semaforem
).Zelená znamená "'.PLUGIN_ETHICS_GREENLIGHT.'"; oran¾ová znamená "'.PLUGIN_ETHICS_YELLOWLIGHT.'"; a èervená znamená "'.PLUGIN_ETHICS_REDLIGHT.'". Administrátor mù¾e lehce mìnit tyto hodnoty u jednotlivých u¾ivatelù.');
@define('PLUGIN_ETHICS_BASEVAL', 'Výchozí úroveò etické úrovnì autora');
@define('PLUGIN_ETHICS_BASEVAL_BLAHBLAH', 'Výchozù úroveò (1 = zelená; 2 = oran¾ová; 3 = èervená; pøednastaveno: 1)');

?>
