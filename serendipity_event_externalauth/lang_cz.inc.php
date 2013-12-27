/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/17
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/17
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/06/19
 */

@define('PLUGIN_EVENT_EXTERNALAUTH_TITLE',		'Externí ovìøování/sledování u¾ivatelù (LDAP)');
@define('PLUGIN_EVENT_EXTERNALAUTH_DESC',		'Umo¾òuje pou¾ít vnìj¹í zdroj pro zji¹»ování správnosti pøihla¹ovacích údajù. Pøihla¹ovací jména jsou cachována v Serendipity databázi. Tento plugin umí také sledovat pøihlá¹ení do Serendipity.');
@define('PLUGIN_EVENT_EXTERNALAUTH_SOURCE',		'Vnìj¹í zdroj autentifikace');
@define('PLUGIN_EVENT_EXTERNALAUTH_SOURCE_DESC',		'Vyberte vnìj¹í zdroj pøihla¹ovacích dat');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL',		'Výchozí u¾ivatelská úroveò');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_DESC',		'Jaká je výchozí u¾ivatelská úroveò pro nového externího u¾ivatele, pokud nemá definovanou u¾ivatelskou úroveò?');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ATTR',		'Atribut u¾ivatelské úrovnì');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ATTR_DESC',		'Jaký atribut obsahuje informaci o u¾ivatelské úrovni pro nového externího u¾ivatele?');
@define('PLUGIN_EVENT_EXTERNALAUTH_HOST',		'Autentifikaèní host');
@define('PLUGIN_EVENT_EXTERNALAUTH_HOST_DESC',		'Zadejte umístìní/adresu autentifikaèního serveru');
@define('PLUGIN_EVENT_EXTERNALAUTH_PORT',		'Autentifikaèní port');
@define('PLUGIN_EVENT_EXTERNALAUTH_PORT_DESC',		'Zadejte port autentifikaèního serveru. Prázdná hodnota znamená standardní port.');
@define('PLUGIN_EVENT_EXTERNALAUTH_RDN',		'Autentifikaèní øetìzec');
@define('PLUGIN_EVENT_EXTERNALAUTH_RDN_DESC',		'Øetìzec pou¾itý pro autentifikaci. %1 bude nahrazeno u¾ivatelským jménem, %2 heslem, %3 heslem zakódovaným v MD5. I pokud je nastaven "Øetìzec pro nalezení u¾ivatele", tato hodnota musí obsahovat základní DN pro vykonání dotazu.');
@define('PLUGIN_EVENT_EXTERNALAUTH_FIRSTLOGIN',		'Provést pouze jednou za sezení');
@define('PLUGIN_EVENT_EXTERNALAUTH_FIRSTLOGIN_DESC',		'Má se vnìj¹í autentifikace u¾ivatele pou¾ít pouze na zaèátku sezení (session), nebo pøi ka¾dém po¾adavku. ANO znamená vy¹¹í výkon, NE znamená vy¹¹í bezpeènost.');
@define('PLUGIN_EVENT_EXTERNALAUTH_BIND_USER',		'LDAP DN jméno pou¾ité k pøipojení (bind)');
@define('PLUGIN_EVENT_EXTERNALAUTH_BIND_USER_DESC',		'Pokud Vá¹ LDAP nelze volnì prohlí¾et a je tøeba provést pøihlá¹ení pøed vykonáním dotazù, toto je u¾ivatelský úèet pro prvotní pøihlá¹ení. V LDAP syntaxi napøíklad: CN=s9yldapuser,CN=Users,DC=ilog,DC=com');
@define('PLUGIN_EVENT_EXTERNALAUTH_BIND_PASSWORD',		'Heslo pro LDAP DN jméno pou¾ité pro pøipojení (bind)');
@define('PLUGIN_EVENT_EXTERNALAUTH_BIND_PASSWORD_DESC',		'Heslo pro pøihlá¹ení k LDAPu');
@define('PLUGIN_EVENT_EXTERNALAUTH_QUERY',		'Dotaz pro nalezení u¾ivatele');
@define('PLUGIN_EVENT_EXTERNALAUTH_QUERY_DESC',		'Dotaz, pomocí nìho¾ bude nalezen u¾ivatel. Pro LDAP to mù¾e být napøíklad (objectclass=*) nebo (&(objectcategory=person)(objectclass=user)(sAMAccountName=%1)). %1 bude nahrazeno u¾ivatelským jménem, %2 heslem, %3 heslem zakódovaným pomocí MD5. Hledání probìhne v oblasti zadané "Autentifikaèním øetìzcem", napøíklad: DC=s9y,DC=org. Pokud je ponecháno prázdné, bude proveden jednoduchý dotaz pomocí "Autentifikaèního øetìzce".');

@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_CHIEF',		'©éf');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_EDITOR',		'Autor');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ADMIN',		'Administrátor');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_DENY',		'Pøístup odepøen');

@define('PLUGIN_EVENT_EXTERNALAUTH_ENABLE_LDAP',		'Povolit pøihá¹ení pøes LDAP?');
@define('PLUGIN_EVENT_EXTERNALAUTH_ENABLE_LOGGING',		'Povolit logování pøístupù?');

@define('PLUGIN_EVENT_EXTERNALAUTH_USER_WYSIWYG',		'Povolit WYSIWYG editor jako výchozí?');
@define('PLUGIN_EVENT_EXTERNALAUTH_USER_WYSIWYG_DESC',		'Nové u¾ivatelské úèty budou vytvoøeny s pøednastavenou volbou "Pou¾ívat WYSIWYG editor"?');

// Next lines were translated on 2011/06/19
@define('PLUGIN_EVENT_EXTERNALAUTH_FAIL2BAN',		'Logovací soubor fail2ban');
@define('PLUGIN_EVENT_EXTERNALAUTH_FAIL2BAN_DESC',		'(Vy¾aduje Serendipity &gt;= 1.6) Tento plugin umí zapsat logovací soubor kompatibilní s formátem fail2ban, pokud je zaznamenán neúspì¹ný pokus o pøihlá¹ení. Pokud chcete zapnout tuto vlastnost, zadejte plnou cestu k souboru vèetnì cesty (napø. "/var/log/fail2ban_s9y.log"). Mo¾ná budete chtít zahrnout tento soubor do rotace systémových logù.');