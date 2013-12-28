<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/16
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/05/13
 */
@define('PLUGIN_OPENID_NAME',     'Přihlašování pomocí OpenID');
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

// Next lines were translated on 2012/05/13
@define('PLUGIN_OPENID_DESCRIPTION', '<h3>Použití OpenID k přihlášení do blogu</h3>' .
'<p>Tento plugin nevyžaduje žádné nastavení, abyste se mohli přihlásit do blogu pomocí OpenID (OpenID je samonastavovací)</p>' .
'<p>Nicméně uživatelé, kteří chtějí použít OpenID k přihlášení, musejí mít nastavenou OpenID URL adresu, pomocí které se chtějí přihlašovat. ' . 
'Tedy pokud chcete využívat OpenID k přihlašování, jděte na vaši <a href="serendipity_admin.php?serendipity[adminModule]=personal">profilovou stránku Serendipity</a> a nastavte si OpenID URL (dole na stránce).</p>' .
'<p>Také tam najdete tlačítka pro účty <b>Google</b>, <b>Yahoo</b> a <b>Aol</b>. Tyto služby jsou také poskytovateli OpenID a tlačítka vám pomohou nastavit je.<br/>' .
'Můžete ale nastavit <b>pouze jedno OpenID spojení pro jeden uživatelský účet</b>.</p>');
@define('PLUGIN_OPENID_DELEGATION_DESCRIPTION', '<h3>Nastavení přesměrování OpenID (nepovinné)</h3>' .
'<p>Pokud chcete použít blog jako poskytovatele OpenID URL k přihlašování k jiným webovým službám, které podporují OpenID, můžete zde nastavit přesměrování z vašeho blogu na službu, kde je uloženo vaše ID.<br/>' .
'Tento plugin přidá některé informace do HTML kódu vašeho blogu, který bude informovat služby, kde hledat vaše ID, pokud bude váš blog dotazován na OpenID.</p>' .
'<p>Nastavení přesměrování je zcela nepovinné a není potřeba k přihlášení do blogu pomocí OpenID.</p>');
@define('PLUGIN_OPENID_LOGIN_USERS', 'Přihlášování z výběru uživatelů');
@define('PLUGIN_OPENID_LOGIN_USERS_DESC', 'Poté, co si autoři blogu nastaví jejich OpenID, můžou si pro přihlášení vybrat své jméno ze seznamu autorů a tím se přihlásit.
Ačkoliv je to velmi poholdný způsob přihlašování, má to nevýhodu, že zobrazujete všem návštěvníkům jména všech vašich autorů.
Obyčejně to není problém, protože jsou jména zobrazována i u příspěvků.
Ale pokud se vám to nelíbí, můžete zde tuto vlastnost vypnout. Pak se bude zobrazovat obyčejné políčko pro zadání OpenID URL.');
@define('PLUGIN_OPENID_VERSION_SUPPORTED', 'Verze OpenID');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_DESC', 'Verze, kterou podporuje váš poskytovatel OpenID. Obvykle je v pořádku volba "obě", ale pokud víte, že váš poskytovatel podporuje pouze verzi 1, nebo pouze verzi 2, nastavte to právě zde.');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_V1', 'Pouze OpenID verze 1');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_V2', 'Pouze OpenID verze 2');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_BOTH', 'Obě dvě verze OpenID');
@define('PLUGIN_OPENID_LOGIN_INPUT', 'Přihlášení pomocí OpenID');
@define('PLUGIN_OPENID_LOGIN_WITH_GOOGLE', 'Přihlášení pomocí účtu Google');
@define('PLUGIN_OPENID_SET_GOOGLE_OID', 'Nastavte váš účet Google jako OpenID');
@define('PLUGIN_OPENID_LOGIN_WITH_YAHOO', 'Přihlášení pomocí účtu Yahoo');
@define('PLUGIN_OPENID_SET_YAHOO_OID', 'Nastavte váš účet Yahoo jako OpenID');
@define('PLUGIN_OPENID_LOGIN_WITH_AOL', 'Přihlášení pomocí účtu Aol');
@define('PLUGIN_OPENID_SET_AOL_OID', 'Nastavte váš účet Aol jako OpenID');
@define('PLUGIN_OPENID_LOGIN_NOOPENID', 'V současnosti nemá žádný z autorů nastavené přihlášení pomocí OpenID.<br/>
Pokud se chcete přihlašovat pomocí OpenID, nastavte prosím nejdříve patřičně váš uživatelský účet.<br/>Díky.');