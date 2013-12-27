/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2013/03/31
 */
@define('PLUGIN_EVENT_PROXY_REALIP_NAME', 'Proxy Real-IP');
@define('PLUGIN_EVENT_PROXY_REALIP_DESC', 'Nastaví správnou návštìvnickou IP adresu pro ètenáøe, kteøí používají Proxy webserver. Mìl by být prvním pluginem v seznamu pluginù.');
@define('PLUGIN_EVENT_PROXY_REALIP_VAR', 'Promìnná s IP adresou');
@define('PLUGIN_EVENT_PROXY_REALIP_VAR_DESC', 'Název promìnné, která obsahuje správnou IP adresu. napø. $_SERVER[\'X-FORWARDED-FOR\']');