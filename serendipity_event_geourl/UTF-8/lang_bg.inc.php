<?php # 

/**
 *  @version $Revision$
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: Revision of 1.1
 */

@define('PLUGIN_EVENT_GEOURL_NAME',      'GeoURL'); 
@define('PLUGIN_EVENT_GEOURL_DESC',      'GeoURL асоциира URL на блога с географски координати. Повече информация има на http://geourl.org/'); 
@define('PLUGIN_EVENT_GEOURL_LAT',       'Географска ширина'); 
@define('PLUGIN_EVENT_GEOURL_LAT_DESC',  'Географската ширина на мястото, където се намира вашият блог (например 50.0515)'); 
@define('PLUGIN_EVENT_GEOURL_LONG',      'Географска дължина'); 
@define('PLUGIN_EVENT_GEOURL_LONG_DESC', 'Географската дължина на мястото, където се намира вашият блог (например 6.6209)'); 
@define('PLUGIN_EVENT_GEOURL_PINGED',    'GeoURL потвърди вашите координати. Посетете <a href="http://geourl.org/near/?p='.$serendipity['baseURL'].'">вашите съседи</a>!');
@define('PLUGIN_EVENT_GEOURL_NOLATLONG', 'Географската ширина и дължина трябва да бъдат дадени в десетичен вид. Можете да намерите вашите координати чрез <a href="http://www.maporama.com">maporama</a> или някой <a href="http://geourl.org/resources.html">друг ресурс</a>.');
