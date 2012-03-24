<?php # lang_cs.inc.php 1.0 2009-07-16 20:05:10 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/16
 */@define('PLUGIN_OPENID_NAME',     'Pøihlašování pomocí OpenID');
@define('PLUGIN_OPENID_DESC',     'Umožòuje autorùm pøihlásit se pomocí OpenID.');

@define('PLUGIN_OPENID_EXISTS', 'S tímto OpenID už jste se zaregistrovali.');
@define('PLUGIN_OPENID_WRONG_ACTIVATION', 'Nesprávná aktivaèní URL adresa!');

@define('PLUGIN_EVENT_OPENID_SELECT', 'OpenID svázané s tímto úètem');

@define('PLUGIN_OPENID_SERVER', 'OpenID server');
@define('PLUGIN_OPENID_SERVER_DESC', 'OpenID server pro použití delegáta (vyžaduje naplnìné OpenID delegáty)');

@define('PLUGIN_OPENID_DELEGATE', 'OpenID delegát');
@define('PLUGIN_OPENID_DELEGATE_DESC', 'OpenID delegát (vyžaduje naplnìný OpenID server)');

@define('PLUGIN_OPENID_XRDS_LOC', 'Umístìní OpenID XRDS');
@define('PLUGIN_OPENID_XRDS_LOC_DESC', 'URL adresa pro umístìní XRDS dokumentù (vyžaduje naplnìný OpenID server)');

@define('PLUGIN_OPENID_UPDATE_SUCCESS', 'OpenID server byl aktualizován');
@define('PLUGIN_OPENID_UPDATE_FAIL', 'Pøi aktualizaci OpenID serveru se vyskytla chyba');
@define('PLUGIN_OPENID_INVALID_RESPONSE', 'Bylo zadáno nesprávné OpenID');
?>