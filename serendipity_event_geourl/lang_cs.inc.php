<?php # $Id$

/**
 *  @version $Revision$
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Translated on 2007/11/24
 */

@define('PLUGIN_EVENT_GEOURL_NAME',      'GeoURL'); 
@define('PLUGIN_EVENT_GEOURL_DESC',      'GeoURL vkládá informace o zemìpisné poloze URL blogu. Více informací na http://geourl.org/'); 
@define('PLUGIN_EVENT_GEOURL_LAT',       'Zemìpisná šíøka'); 
@define('PLUGIN_EVENT_GEOURL_LAT_DESC',  'Zemìpisná šíøka místa, kde je provozován blog, nebo kterého místa se týká. Zadávejte v desetinné formì (napø. 50.0515)'); 
@define('PLUGIN_EVENT_GEOURL_LONG',      'Zemìpisná délka'); 
@define('PLUGIN_EVENT_GEOURL_LONG_DESC', 'Zemìpisná délka místa, kde je provozován blog, nebo kterého místa se týká. Zadávejte v desetinné formì (napø. 6.6209)'); 
@define('PLUGIN_EVENT_GEOURL_PINGED',    'Služba GeoURL úspìšnì kontaktována, nové souøadnice zadány. Navštivte <a href="http://geourl.org/near/?p='.$serendipity['baseURL'].'">své sousedy</a>!');
@define('PLUGIN_EVENT_GEOURL_NOLATLONG', 'Zemìpisná délka a šíøka musí bát zadaná v desetinném formátu. Vaše souøadnice naleznete pomocí <a href="http://www.maporama.com">maporamy</a> nebo <a href="http://geourl.org/resources.html">dalších zdrojù</a>.');

?>
