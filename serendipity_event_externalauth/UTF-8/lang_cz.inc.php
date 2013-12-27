/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/17
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/17
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/06/19
 */

@define('PLUGIN_EVENT_EXTERNALAUTH_TITLE',		'Externí ověřování/sledování uživatelů (LDAP)');
@define('PLUGIN_EVENT_EXTERNALAUTH_DESC',		'Umožňuje použít vnější zdroj pro zjišťování správnosti přihlašovacích údajů. Přihlašovací jména jsou cachována v Serendipity databázi. Tento plugin umí také sledovat přihlášení do Serendipity.');
@define('PLUGIN_EVENT_EXTERNALAUTH_SOURCE',		'Vnější zdroj autentifikace');
@define('PLUGIN_EVENT_EXTERNALAUTH_SOURCE_DESC',		'Vyberte vnější zdroj přihlašovacích dat');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL',		'Výchozí uživatelská úroveň');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_DESC',		'Jaká je výchozí uživatelská úroveň pro nového externího uživatele, pokud nemá definovanou uživatelskou úroveň?');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ATTR',		'Atribut uživatelské úrovně');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ATTR_DESC',		'Jaký atribut obsahuje informaci o uživatelské úrovni pro nového externího uživatele?');
@define('PLUGIN_EVENT_EXTERNALAUTH_HOST',		'Autentifikační host');
@define('PLUGIN_EVENT_EXTERNALAUTH_HOST_DESC',		'Zadejte umístění/adresu autentifikačního serveru');
@define('PLUGIN_EVENT_EXTERNALAUTH_PORT',		'Autentifikační port');
@define('PLUGIN_EVENT_EXTERNALAUTH_PORT_DESC',		'Zadejte port autentifikačního serveru. Prázdná hodnota znamená standardní port.');
@define('PLUGIN_EVENT_EXTERNALAUTH_RDN',		'Autentifikační řetězec');
@define('PLUGIN_EVENT_EXTERNALAUTH_RDN_DESC',		'Řetězec použitý pro autentifikaci. %1 bude nahrazeno uživatelským jménem, %2 heslem, %3 heslem zakódovaným v MD5. I pokud je nastaven "Řetězec pro nalezení uživatele", tato hodnota musí obsahovat základní DN pro vykonání dotazu.');
@define('PLUGIN_EVENT_EXTERNALAUTH_FIRSTLOGIN',		'Provést pouze jednou za sezení');
@define('PLUGIN_EVENT_EXTERNALAUTH_FIRSTLOGIN_DESC',		'Má se vnější autentifikace uživatele použít pouze na začátku sezení (session), nebo při každém požadavku. ANO znamená vyšší výkon, NE znamená vyšší bezpečnost.');
@define('PLUGIN_EVENT_EXTERNALAUTH_BIND_USER',		'LDAP DN jméno použité k připojení (bind)');
@define('PLUGIN_EVENT_EXTERNALAUTH_BIND_USER_DESC',		'Pokud Váš LDAP nelze volně prohlížet a je třeba provést přihlášení před vykonáním dotazů, toto je uživatelský účet pro prvotní přihlášení. V LDAP syntaxi například: CN=s9yldapuser,CN=Users,DC=ilog,DC=com');
@define('PLUGIN_EVENT_EXTERNALAUTH_BIND_PASSWORD',		'Heslo pro LDAP DN jméno použité pro připojení (bind)');
@define('PLUGIN_EVENT_EXTERNALAUTH_BIND_PASSWORD_DESC',		'Heslo pro přihlášení k LDAPu');
@define('PLUGIN_EVENT_EXTERNALAUTH_QUERY',		'Dotaz pro nalezení uživatele');
@define('PLUGIN_EVENT_EXTERNALAUTH_QUERY_DESC',		'Dotaz, pomocí něhož bude nalezen uživatel. Pro LDAP to může být například (objectclass=*) nebo (&(objectcategory=person)(objectclass=user)(sAMAccountName=%1)). %1 bude nahrazeno uživatelským jménem, %2 heslem, %3 heslem zakódovaným pomocí MD5. Hledání proběhne v oblasti zadané "Autentifikačním řetězcem", například: DC=s9y,DC=org. Pokud je ponecháno prázdné, bude proveden jednoduchý dotaz pomocí "Autentifikačního řetězce".');

@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_CHIEF',		'Šéf');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_EDITOR',		'Autor');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ADMIN',		'Administrátor');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_DENY',		'Přístup odepřen');

@define('PLUGIN_EVENT_EXTERNALAUTH_ENABLE_LDAP',		'Povolit přihášení přes LDAP?');
@define('PLUGIN_EVENT_EXTERNALAUTH_ENABLE_LOGGING',		'Povolit logování přístupů?');

@define('PLUGIN_EVENT_EXTERNALAUTH_USER_WYSIWYG',		'Povolit WYSIWYG editor jako výchozí?');
@define('PLUGIN_EVENT_EXTERNALAUTH_USER_WYSIWYG_DESC',		'Nové uživatelské účty budou vytvořeny s přednastavenou volbou "Používat WYSIWYG editor"?');

// Next lines were translated on 2011/06/19
@define('PLUGIN_EVENT_EXTERNALAUTH_FAIL2BAN',		'Logovací soubor fail2ban');
@define('PLUGIN_EVENT_EXTERNALAUTH_FAIL2BAN_DESC',		'(Vyžaduje Serendipity &gt;= 1.6) Tento plugin umí zapsat logovací soubor kompatibilní s formátem fail2ban, pokud je zaznamenán neúspěšný pokus o přihlášení. Pokud chcete zapnout tuto vlastnost, zadejte plnou cestu k souboru včetně cesty (např. "/var/log/fail2ban_s9y.log"). Možná budete chtít zahrnout tento soubor do rotace systémových logů.');