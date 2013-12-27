/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/16
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/05/13
 */
@define('PLUGIN_OPENID_NAME',     'Pøihla¹ování pomocí OpenID');
@define('PLUGIN_OPENID_DESC',     'Umo¾òuje autorùm pøihlásit se pomocí OpenID.');

@define('PLUGIN_OPENID_EXISTS', 'S tímto OpenID u¾ jste se zaregistrovali.');
@define('PLUGIN_OPENID_WRONG_ACTIVATION', 'Nesprávná aktivaèní URL adresa!');

@define('PLUGIN_EVENT_OPENID_SELECT', 'OpenID svázané s tímto úètem');

@define('PLUGIN_OPENID_SERVER', 'OpenID server');
@define('PLUGIN_OPENID_SERVER_DESC', 'OpenID server pro pou¾ití delegáta (vy¾aduje naplnìné OpenID delegáty)');

@define('PLUGIN_OPENID_DELEGATE', 'OpenID delegát');
@define('PLUGIN_OPENID_DELEGATE_DESC', 'OpenID delegát (vy¾aduje naplnìný OpenID server)');

@define('PLUGIN_OPENID_XRDS_LOC', 'Umístìní OpenID XRDS');
@define('PLUGIN_OPENID_XRDS_LOC_DESC', 'URL adresa pro umístìní XRDS dokumentù (vy¾aduje naplnìný OpenID server)');

@define('PLUGIN_OPENID_UPDATE_SUCCESS', 'OpenID server byl aktualizován');
@define('PLUGIN_OPENID_UPDATE_FAIL', 'Pøi aktualizaci OpenID serveru se vyskytla chyba');
@define('PLUGIN_OPENID_INVALID_RESPONSE', 'Bylo zadáno nesprávné OpenID');

// Next lines were translated on 2012/05/13
@define('PLUGIN_OPENID_DESCRIPTION', '<h3>Pou¾ití OpenID k pøihlá¹ení do blogu</h3>' .
'<p>Tento plugin nevy¾aduje ¾ádné nastavení, abyste se mohli pøihlásit do blogu pomocí OpenID (OpenID je samonastavovací)</p>' .
'<p>Nicménì u¾ivatelé, kteøí chtìjí pou¾ít OpenID k pøihlá¹ení, musejí mít nastavenou OpenID URL adresu, pomocí které se chtìjí pøihla¹ovat. ' . 
'Tedy pokud chcete vyu¾ívat OpenID k pøihla¹ování, jdìte na va¹i <a href="serendipity_admin.php?serendipity[adminModule]=personal">profilovou stránku Serendipity</a> a nastavte si OpenID URL (dole na stránce).</p>' .
'<p>Také tam najdete tlaèítka pro úèty <b>Google</b>, <b>Yahoo</b> a <b>Aol</b>. Tyto slu¾by jsou také poskytovateli OpenID a tlaèítka vám pomohou nastavit je.<br/>' .
'Mù¾ete ale nastavit <b>pouze jedno OpenID spojení pro jeden u¾ivatelský úèet</b>.</p>');
@define('PLUGIN_OPENID_DELEGATION_DESCRIPTION', '<h3>Nastavení pøesmìrování OpenID (nepovinné)</h3>' .
'<p>Pokud chcete pou¾ít blog jako poskytovatele OpenID URL k pøihla¹ování k jiným webovým slu¾bám, které podporují OpenID, mù¾ete zde nastavit pøesmìrování z va¹eho blogu na slu¾bu, kde je ulo¾eno va¹e ID.<br/>' .
'Tento plugin pøidá nìkteré informace do HTML kódu va¹eho blogu, který bude informovat slu¾by, kde hledat va¹e ID, pokud bude vá¹ blog dotazován na OpenID.</p>' .
'<p>Nastavení pøesmìrování je zcela nepovinné a není potøeba k pøihlá¹ení do blogu pomocí OpenID.</p>');
@define('PLUGIN_OPENID_LOGIN_USERS', 'Pøihlá¹ování z výbìru u¾ivatelù');
@define('PLUGIN_OPENID_LOGIN_USERS_DESC', 'Poté, co si autoøi blogu nastaví jejich OpenID, mù¾ou si pro pøihlá¹ení vybrat své jméno ze seznamu autorù a tím se pøihlásit.
Aèkoliv je to velmi poholdný zpùsob pøihla¹ování, má to nevýhodu, ¾e zobrazujete v¹em náv¹tìvníkùm jména v¹ech va¹ich autorù.
Obyèejnì to není problém, proto¾e jsou jména zobrazována i u pøíspìvkù.
Ale pokud se vám to nelíbí, mù¾ete zde tuto vlastnost vypnout. Pak se bude zobrazovat obyèejné políèko pro zadání OpenID URL.');
@define('PLUGIN_OPENID_VERSION_SUPPORTED', 'Verze OpenID');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_DESC', 'Verze, kterou podporuje vá¹ poskytovatel OpenID. Obvykle je v poøádku volba "obì", ale pokud víte, ¾e vá¹ poskytovatel podporuje pouze verzi 1, nebo pouze verzi 2, nastavte to právì zde.');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_V1', 'Pouze OpenID verze 1');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_V2', 'Pouze OpenID verze 2');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_BOTH', 'Obì dvì verze OpenID');
@define('PLUGIN_OPENID_LOGIN_INPUT', 'Pøihlá¹ení pomocí OpenID');
@define('PLUGIN_OPENID_LOGIN_WITH_GOOGLE', 'Pøihlá¹ení pomocí úètu Google');
@define('PLUGIN_OPENID_SET_GOOGLE_OID', 'Nastavte vá¹ úèet Google jako OpenID');
@define('PLUGIN_OPENID_LOGIN_WITH_YAHOO', 'Pøihlá¹ení pomocí úètu Yahoo');
@define('PLUGIN_OPENID_SET_YAHOO_OID', 'Nastavte vá¹ úèet Yahoo jako OpenID');
@define('PLUGIN_OPENID_LOGIN_WITH_AOL', 'Pøihlá¹ení pomocí úètu Aol');
@define('PLUGIN_OPENID_SET_AOL_OID', 'Nastavte vá¹ úèet Aol jako OpenID');
@define('PLUGIN_OPENID_LOGIN_NOOPENID', 'V souèasnosti nemá ¾ádný z autorù nastavené pøihlá¹ení pomocí OpenID.<br/>
Pokud se chcete pøihla¹ovat pomocí OpenID, nastavte prosím nejdøíve patøiènì vá¹ u¾ivatelský úèet.<br/>Díky.');