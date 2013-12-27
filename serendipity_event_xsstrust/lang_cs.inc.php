/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/08
 */

//
//  serendipity_event_xsstrust
//
@define('PLUGIN_EVENT_XSSTRUST_NAME',     'Nástroje pro dùvìryhodnou správu více-uživatelských blogù');
@define('PLUGIN_EVENT_XSSTRUST_DESC',     'Tento plugin umožòuje upøesnit, kteøí autoøi na více-uživatelském blogu jsou dùvìryhodní a lze se spolehnout, že se nebudou pokoušet o hackování. Všichni ostatní autoøi jsou bráni jako potenciálnì nebezpeèní a nemohou vytvøátet pøíspìvky v HTML kódu.');
@define('PLUGIN_EVENT_XSSTRUST_AUTHORS',  'Dùvìryhodní autoøi');

//
//  serendipity_plugin_xsstrust
//
@define('PLUGIN_ETHICS_NAME', 'Zobrazit dùvìryhodné autory');
@define('PLUGIN_ETHICS_INTRO', 'Tento plugin zobrazuje autory se zobrazením jejich etické úrovnì, semafor má následující význam:');
@define('PLUGIN_ETHICS_REDLIGHT', 'zakázaný');
@define('PLUGIN_ETHICS_YELLOWLIGHT', 'podezøelý');
@define('PLUGIN_ETHICS_GREENLIGHT', 'v pohodì');
@define('PLUGIN_ETHICS_BLAHBLAH', 'Zobrazuje uživatele s vyobrazením jejich etické úrovnì (vyjádøenou semaforem
).Zelená znamená "'.PLUGIN_ETHICS_GREENLIGHT.'"; oranžová znamená "'.PLUGIN_ETHICS_YELLOWLIGHT.'"; a èervená znamená "'.PLUGIN_ETHICS_REDLIGHT.'". Administrátor mùže lehce mìnit tyto hodnoty u jednotlivých uživatelù.');
@define('PLUGIN_ETHICS_BASEVAL', 'Výchozí úroveò etické úrovnì autora');
@define('PLUGIN_ETHICS_BASEVAL_BLAHBLAH', 'Výchozù úroveò (1 = zelená; 2 = oranžová; 3 = èervená; pøednastaveno: 1)');

?>
