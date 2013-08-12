<?php # 

/**
 *  @version $Revision$
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Translated on 2007/11/24
 */

@define('PLUGIN_EVENT_GEOURL_NAME',      'GeoURL'); 
@define('PLUGIN_EVENT_GEOURL_DESC',      'GeoURL vkládá informace o zeměpisné poloze URL blogu. Více informací na http://geourl.org/'); 
@define('PLUGIN_EVENT_GEOURL_LAT',       'Zeměpisná šířka'); 
@define('PLUGIN_EVENT_GEOURL_LAT_DESC',  'Zeměpisná šířka místa, kde je provozován blog, nebo kterého místa se týká. Zadávejte v desetinné formě (např. 50.0515)'); 
@define('PLUGIN_EVENT_GEOURL_LONG',      'Zeměpisná délka'); 
@define('PLUGIN_EVENT_GEOURL_LONG_DESC', 'Zeměpisná délka místa, kde je provozován blog, nebo kterého místa se týká. Zadávejte v desetinné formě (např. 6.6209)'); 
@define('PLUGIN_EVENT_GEOURL_PINGED',    'Služba GeoURL úspěšně kontaktována, nové souřadnice zadány. Navštivte <a href="http://geourl.org/near/?p='.$serendipity['baseURL'].'">své sousedy</a>!');
@define('PLUGIN_EVENT_GEOURL_NOLATLONG', 'Zeměpisná délka a šířka musí bát zadaná v desetinném formátu. Vaše souřadnice naleznete pomocí <a href="http://www.maporama.com">maporamy</a> nebo <a href="http://geourl.org/resources.html">dalších zdrojů</a>.');

?>
