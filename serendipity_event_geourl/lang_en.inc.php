<?php # $Id: lang_en.inc.php,v 1.1 2005/11/18 07:36:08 elf2000 Exp $

/**
 *  @version $Revision: 1.1 $
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_GEOURL_NAME',      'GeoURL'); 
@define('PLUGIN_EVENT_GEOURL_DESC',      'GeoURL allocates URLs to locations. More Information at http://geourl.org/'); 
@define('PLUGIN_EVENT_GEOURL_LAT',       'Latitude'); 
@define('PLUGIN_EVENT_GEOURL_LAT_DESC',  'The latitude to the location where the Blog is kept or the Blog is about in decimal notation (eg 50.0515)'); 
@define('PLUGIN_EVENT_GEOURL_LONG',      'Longituge'); 
@define('PLUGIN_EVENT_GEOURL_LONG_DESC', 'The longitude to the location where the Blog is kept or the Blog is about in decimal notation (eg 6.6209)'); 
@define('PLUGIN_EVENT_GEOURL_PINGED',    'GeoURL Service pinged succesfully for the new coordinates. Visit <a href="http://geourl.org/near/?p='.$serendipity['baseURL'].'">your neighbours</a>!');
@define('PLUGIN_EVENT_GEOURL_NOLATLONG', 'Latitude and Longitude have to be given in decimal notation. Your coordinates my be found via <a href="http://www.maporama.com">maporama</a> or an <a href="http://geourl.org/resources.html">other ressource</a>.');

?>
