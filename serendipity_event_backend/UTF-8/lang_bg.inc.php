<?php # $Id$

/**
 *  @version $Revision$
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: 1.1
 */

@define('PLUGIN_BACKEND_TITLE', 'Показва статии от блога чрез JavaScript');
@define('PLUGIN_BACKEND_DESC', 'Тази приставка извежда статии от блога през JavaScript, така че те могат да бъдат включвани в други, външни сайтове. (Вижте файл README в директорията на приставката.)');
@define('PLUGIN_BACKEND_BACKENDURL', 'URL');
@define('PLUGIN_BACKEND_BACKENDURL_BLAHBLAH', 'Този URL се използва от външните сайтове за достъп до вашия блог. \'URL\' се заменя с това, което въведете тук. Евентуалните параметри се записват след URL, например: ' . $serendipity['baseURL'] . ($serendipity['rewrite'] == "none" ? $serendipity['indexFile'] . "?/" : "") . 'plugin/URL?details=1&category=mycat');
