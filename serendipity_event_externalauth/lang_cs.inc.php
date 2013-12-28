<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/17
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/17
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/06/19
 */

@define('PLUGIN_EVENT_EXTERNALAUTH_TITLE',		'Externí ovìøování/sledování uivatelù (LDAP)');
@define('PLUGIN_EVENT_EXTERNALAUTH_DESC',		'Umoòuje pouít vnìjší zdroj pro zjišování správnosti pøihlašovacích údajù. Pøihlašovací jména jsou cachována v Serendipity databázi. Tento plugin umí také sledovat pøihlášení do Serendipity.');
@define('PLUGIN_EVENT_EXTERNALAUTH_SOURCE',		'Vnìjší zdroj autentifikace');
@define('PLUGIN_EVENT_EXTERNALAUTH_SOURCE_DESC',		'Vyberte vnìjší zdroj pøihlašovacích dat');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL',		'Vıchozí uivatelská úroveò');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_DESC',		'Jaká je vıchozí uivatelská úroveò pro nového externího uivatele, pokud nemá definovanou uivatelskou úroveò?');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ATTR',		'Atribut uivatelské úrovnì');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ATTR_DESC',		'Jakı atribut obsahuje informaci o uivatelské úrovni pro nového externího uivatele?');
@define('PLUGIN_EVENT_EXTERNALAUTH_HOST',		'Autentifikaèní host');
@define('PLUGIN_EVENT_EXTERNALAUTH_HOST_DESC',		'Zadejte umístìní/adresu autentifikaèního serveru');
@define('PLUGIN_EVENT_EXTERNALAUTH_PORT',		'Autentifikaèní port');
@define('PLUGIN_EVENT_EXTERNALAUTH_PORT_DESC',		'Zadejte port autentifikaèního serveru. Prázdná hodnota znamená standardní port.');
@define('PLUGIN_EVENT_EXTERNALAUTH_RDN',		'Autentifikaèní øetìzec');
@define('PLUGIN_EVENT_EXTERNALAUTH_RDN_DESC',		'Øetìzec pouitı pro autentifikaci. %1 bude nahrazeno uivatelskım jménem, %2 heslem, %3 heslem zakódovanım v MD5. I pokud je nastaven "Øetìzec pro nalezení uivatele", tato hodnota musí obsahovat základní DN pro vykonání dotazu.');
@define('PLUGIN_EVENT_EXTERNALAUTH_FIRSTLOGIN',		'Provést pouze jednou za sezení');
@define('PLUGIN_EVENT_EXTERNALAUTH_FIRSTLOGIN_DESC',		'Má se vnìjší autentifikace uivatele pouít pouze na zaèátku sezení (session), nebo pøi kadém poadavku. ANO znamená vyšší vıkon, NE znamená vyšší bezpeènost.');
@define('PLUGIN_EVENT_EXTERNALAUTH_BIND_USER',		'LDAP DN jméno pouité k pøipojení (bind)');
@define('PLUGIN_EVENT_EXTERNALAUTH_BIND_USER_DESC',		'Pokud Váš LDAP nelze volnì prohlíet a je tøeba provést pøihlášení pøed vykonáním dotazù, toto je uivatelskı úèet pro prvotní pøihlášení. V LDAP syntaxi napøíklad: CN=s9yldapuser,CN=Users,DC=ilog,DC=com');
@define('PLUGIN_EVENT_EXTERNALAUTH_BIND_PASSWORD',		'Heslo pro LDAP DN jméno pouité pro pøipojení (bind)');
@define('PLUGIN_EVENT_EXTERNALAUTH_BIND_PASSWORD_DESC',		'Heslo pro pøihlášení k LDAPu');
@define('PLUGIN_EVENT_EXTERNALAUTH_QUERY',		'Dotaz pro nalezení uivatele');
@define('PLUGIN_EVENT_EXTERNALAUTH_QUERY_DESC',		'Dotaz, pomocí nìho bude nalezen uivatel. Pro LDAP to mùe bıt napøíklad (objectclass=*) nebo (&(objectcategory=person)(objectclass=user)(sAMAccountName=%1)). %1 bude nahrazeno uivatelskım jménem, %2 heslem, %3 heslem zakódovanım pomocí MD5. Hledání probìhne v oblasti zadané "Autentifikaèním øetìzcem", napøíklad: DC=s9y,DC=org. Pokud je ponecháno prázdné, bude proveden jednoduchı dotaz pomocí "Autentifikaèního øetìzce".');

@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_CHIEF',		'Šéf');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_EDITOR',		'Autor');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ADMIN',		'Administrátor');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_DENY',		'Pøístup odepøen');

@define('PLUGIN_EVENT_EXTERNALAUTH_ENABLE_LDAP',		'Povolit pøihášení pøes LDAP?');
@define('PLUGIN_EVENT_EXTERNALAUTH_ENABLE_LOGGING',		'Povolit logování pøístupù?');

@define('PLUGIN_EVENT_EXTERNALAUTH_USER_WYSIWYG',		'Povolit WYSIWYG editor jako vıchozí?');
@define('PLUGIN_EVENT_EXTERNALAUTH_USER_WYSIWYG_DESC',		'Nové uivatelské úèty budou vytvoøeny s pøednastavenou volbou "Pouívat WYSIWYG editor"?');

// Next lines were translated on 2011/06/19
@define('PLUGIN_EVENT_EXTERNALAUTH_FAIL2BAN',		'Logovací soubor fail2ban');
@define('PLUGIN_EVENT_EXTERNALAUTH_FAIL2BAN_DESC',		'(Vyaduje Serendipity &gt;= 1.6) Tento plugin umí zapsat logovací soubor kompatibilní s formátem fail2ban, pokud je zaznamenán neúspìšnı pokus o pøihlášení. Pokud chcete zapnout tuto vlastnost, zadejte plnou cestu k souboru vèetnì cesty (napø. "/var/log/fail2ban_s9y.log"). Moná budete chtít zahrnout tento soubor do rotace systémovıch logù.');