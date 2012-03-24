<?php # lang_cz.inc.php 1.0 2009-07-16 20:05:10 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/16
 */@define('PLUGIN_OPENID_NAME',     'Přihlašování pomocí OpenID');
@define('PLUGIN_OPENID_DESC',     'Umožňuje autorům přihlásit se pomocí OpenID.');

@define('PLUGIN_OPENID_EXISTS', 'S tímto OpenID už jste se zaregistrovali.');
@define('PLUGIN_OPENID_WRONG_ACTIVATION', 'Nesprávná aktivační URL adresa!');

@define('PLUGIN_EVENT_OPENID_SELECT', 'OpenID svázané s tímto účtem');

@define('PLUGIN_OPENID_SERVER', 'OpenID server');
@define('PLUGIN_OPENID_SERVER_DESC', 'OpenID server pro použití delegáta (vyžaduje naplněné OpenID delegáty)');

@define('PLUGIN_OPENID_DELEGATE', 'OpenID delegát');
@define('PLUGIN_OPENID_DELEGATE_DESC', 'OpenID delegát (vyžaduje naplněný OpenID server)');

@define('PLUGIN_OPENID_XRDS_LOC', 'Umístění OpenID XRDS');
@define('PLUGIN_OPENID_XRDS_LOC_DESC', 'URL adresa pro umístění XRDS dokumentů (vyžaduje naplněný OpenID server)');

@define('PLUGIN_OPENID_UPDATE_SUCCESS', 'OpenID server byl aktualizován');
@define('PLUGIN_OPENID_UPDATE_FAIL', 'Při aktualizaci OpenID serveru se vyskytla chyba');
@define('PLUGIN_OPENID_INVALID_RESPONSE', 'Bylo zadáno nesprávné OpenID');
?>