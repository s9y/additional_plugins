/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2013/03/31
 */
@define('PLUGIN_EVENT_PROXY_REALIP_NAME', 'Proxy Real-IP');
@define('PLUGIN_EVENT_PROXY_REALIP_DESC', 'Nastaví správnou návštěvnickou IP adresu pro čtenáře, kteří používají Proxy webserver. Měl by být prvním pluginem v seznamu pluginů.');
@define('PLUGIN_EVENT_PROXY_REALIP_VAR', 'Proměnná s IP adresou');
@define('PLUGIN_EVENT_PROXY_REALIP_VAR_DESC', 'Název proměnné, která obsahuje správnou IP adresu. např. $_SERVER[\'X-FORWARDED-FOR\']');