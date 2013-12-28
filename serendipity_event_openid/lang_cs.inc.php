<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/16
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/05/13
 */
@define('PLUGIN_OPENID_NAME',     'Pøihlašování pomocí OpenID');
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

// Next lines were translated on 2012/05/13
@define('PLUGIN_OPENID_DESCRIPTION', '<h3>Použití OpenID k pøihlášení do blogu</h3>' .
'<p>Tento plugin nevyžaduje žádné nastavení, abyste se mohli pøihlásit do blogu pomocí OpenID (OpenID je samonastavovací)</p>' .
'<p>Nicménì uživatelé, kteøí chtìjí použít OpenID k pøihlášení, musejí mít nastavenou OpenID URL adresu, pomocí které se chtìjí pøihlašovat. ' . 
'Tedy pokud chcete využívat OpenID k pøihlašování, jdìte na vaši <a href="serendipity_admin.php?serendipity[adminModule]=personal">profilovou stránku Serendipity</a> a nastavte si OpenID URL (dole na stránce).</p>' .
'<p>Také tam najdete tlaèítka pro úèty <b>Google</b>, <b>Yahoo</b> a <b>Aol</b>. Tyto služby jsou také poskytovateli OpenID a tlaèítka vám pomohou nastavit je.<br/>' .
'Mùžete ale nastavit <b>pouze jedno OpenID spojení pro jeden uživatelský úèet</b>.</p>');
@define('PLUGIN_OPENID_DELEGATION_DESCRIPTION', '<h3>Nastavení pøesmìrování OpenID (nepovinné)</h3>' .
'<p>Pokud chcete použít blog jako poskytovatele OpenID URL k pøihlašování k jiným webovým službám, které podporují OpenID, mùžete zde nastavit pøesmìrování z vašeho blogu na službu, kde je uloženo vaše ID.<br/>' .
'Tento plugin pøidá nìkteré informace do HTML kódu vašeho blogu, který bude informovat služby, kde hledat vaše ID, pokud bude váš blog dotazován na OpenID.</p>' .
'<p>Nastavení pøesmìrování je zcela nepovinné a není potøeba k pøihlášení do blogu pomocí OpenID.</p>');
@define('PLUGIN_OPENID_LOGIN_USERS', 'Pøihlášování z výbìru uživatelù');
@define('PLUGIN_OPENID_LOGIN_USERS_DESC', 'Poté, co si autoøi blogu nastaví jejich OpenID, mùžou si pro pøihlášení vybrat své jméno ze seznamu autorù a tím se pøihlásit.
Aèkoliv je to velmi poholdný zpùsob pøihlašování, má to nevýhodu, že zobrazujete všem návštìvníkùm jména všech vašich autorù.
Obyèejnì to není problém, protože jsou jména zobrazována i u pøíspìvkù.
Ale pokud se vám to nelíbí, mùžete zde tuto vlastnost vypnout. Pak se bude zobrazovat obyèejné políèko pro zadání OpenID URL.');
@define('PLUGIN_OPENID_VERSION_SUPPORTED', 'Verze OpenID');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_DESC', 'Verze, kterou podporuje váš poskytovatel OpenID. Obvykle je v poøádku volba "obì", ale pokud víte, že váš poskytovatel podporuje pouze verzi 1, nebo pouze verzi 2, nastavte to právì zde.');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_V1', 'Pouze OpenID verze 1');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_V2', 'Pouze OpenID verze 2');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_BOTH', 'Obì dvì verze OpenID');
@define('PLUGIN_OPENID_LOGIN_INPUT', 'Pøihlášení pomocí OpenID');
@define('PLUGIN_OPENID_LOGIN_WITH_GOOGLE', 'Pøihlášení pomocí úètu Google');
@define('PLUGIN_OPENID_SET_GOOGLE_OID', 'Nastavte váš úèet Google jako OpenID');
@define('PLUGIN_OPENID_LOGIN_WITH_YAHOO', 'Pøihlášení pomocí úètu Yahoo');
@define('PLUGIN_OPENID_SET_YAHOO_OID', 'Nastavte váš úèet Yahoo jako OpenID');
@define('PLUGIN_OPENID_LOGIN_WITH_AOL', 'Pøihlášení pomocí úètu Aol');
@define('PLUGIN_OPENID_SET_AOL_OID', 'Nastavte váš úèet Aol jako OpenID');
@define('PLUGIN_OPENID_LOGIN_NOOPENID', 'V souèasnosti nemá žádný z autorù nastavené pøihlášení pomocí OpenID.<br/>
Pokud se chcete pøihlašovat pomocí OpenID, nastavte prosím nejdøíve patøiènì váš uživatelský úèet.<br/>Díky.');