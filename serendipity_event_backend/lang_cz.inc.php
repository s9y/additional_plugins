<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/01
 */

@define('PLUGIN_BACKEND_TITLE', 'Zobrazování pøíspìvkù pomocí JavaScriptu');
@define('PLUGIN_BACKEND_DESC', 'Poskytuje Javascriptový výstup nejnovìj¹ích èlánkù pro jejich vlo¾ení do cizích, externích stránek. (Pøeètìte si soubor README v adresáøi pluginu!)');
@define('PLUGIN_BACKEND_BACKENDURL', 'Backend URL');
@define('PLUGIN_BACKEND_BACKENDURL_BLAHBLAH', 'Url adresa backendu, která bude volána z cizích stránek (http://vas.blog.cz/' . ($serendipity['rewrite'] == "none" ? $serendipity['indexFile'] . "?/" : "") . 'plugin/[BACKEND_URL]).');

?>
