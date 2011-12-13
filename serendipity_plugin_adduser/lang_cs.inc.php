<?php # lang_cs.inc.php 1.0 2009-02-18 14:31:18 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/18
 */

@define('PLUGIN_ADDUSER_NAME',		'Samoregistrace nových uživatelù');
@define('PLUGIN_ADDUSER_DESC',		'Umožòuje návštìvníkùm webu vytvoøit si vlastní uživatelský úèet. Dohromady s pluginem událostí (index.php?serendipity[subpage]=adduser) mùžete urèit, jestli komentáøe mohou posílat pouze registrovaní uživatelé.');
@define('PLUGIN_ADDUSER_INSTRUCTIONS',		'Další pokyny');
@define('PLUGIN_ADDUSER_INSTRUCTIONS_DESC',		'Zde pøidejte pokyny, které se mají objevit vedle formuláøe pro vytvoøení uživatelského úètu.');
@define('PLUGIN_ADDUSER_INSTRUCTIONS_DEFAULT',		'Zde se mùžete zaregistrovat do blogu jako nový uživatel. Jednoduše zadejte svá data, potvrïte formuláø a øiïte se dalšími pokyny, které Vám pøijdou mailem.');
@define('PLUGIN_ADDUSER_USERLEVEL',		'Výchozí uživatelská úroveò');
@define('PLUGIN_ADDUSER_USERLEVEL_DESC',		'Jakou uživatelskou úroveò (oprávnìní) má mít nový uživatel');
@define('PLUGIN_ADDUSER_USERLEVEL_CHIEF',		'Autor');
@define('PLUGIN_ADDUSER_USERLEVEL_EDITOR',		'Redaktor');
@define('PLUGIN_ADDUSER_USERLEVEL_ADMIN',		'Administrátor');
@define('PLUGIN_ADDUSER_USERLEVEL_DENY',		'Pøístup odepøen');
@define('PLUGIN_SIDEBAR_LOGIN',		'Zobrazit pøihlašovací formuláø v postranním sloupci?');
@define('PLUGIN_SIDEBAR_LOGIN_DESC',		'Pokud je povoleno, v postranním sloupci se budou zobrazovat blok s pøihlašovacím formuláøem. Pokud je zakázáno, budou se muset uživatelé registrovat pomocí zvláštní stránky v odpovídajícím pluginu událostí.');

@define('PLUGIN_ADDUSER_EXISTS',		'Omlouváme se, jméno "%s" už nìkdo jiný používá. Vyberte si prosím jiné.');
@define('PLUGIN_ADDUSER_MISSING',		'Musíte vyplnit všechna pole, aby Vám mohl být vytvoøen nový úèet.');
@define('PLUGIN_ADDUSER_SENTMAIL',		'Váš úèet byl vytvoøen. Bìhem nìkolika okamžikù byste mìli obdržet email se souhrnem nejdùležitìjších informací.');
@define('PLUGIN_ADDUSER_WRONG_ACTIVATION',		'Nesprávná aktivaèní URL adresa!');

@define('PLUGIN_ADDUSER_MAIL_SUBJECT',		'Nový uživatelský úèet byl vytvoøen');
@define('PLUGIN_ADDUSER_MAIL_BODY',		"Nový uživatelský úèet %s byl právì vytvoøen na blogu %s. Pro aktivaci toho úètu prosím kliknìte na následující odkaz:\n\n%s\n\nPoté se mùžete pøihlásit pomocí døíve zadaného jména a hesla. Tento email byl poslán jak novému uživateli, tak provozovateli blogu.");
@define('PLUGIN_ADDUSER_SUCCEED',		'Úèet byl úspìšnì aktivován. Nyní se mùžete pøihlásit do administrátorské sekce blogu. odkaz na pøihlašovací stránku je uveden v aktivaèním emailu.');
@define('PLUGIN_ADDUSER_FAILED',		'Úèet nemohl být aktivován. Neopsali jste špatnì URL adresu z aktivaèního emailu?');

@define('PLUGIN_ADDUSER_REGISTERED_ONLY',		'Komentáøe smí posílat pouze registrovaní uživatelé?');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_DESC',		'Pokud je povoleno, komentáøe k pøíspìvkùm mohou posílat pouze registrovaní a pøihlášení uživatelé.');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_REASON',		'Komentáøe mohou posílat pouze registrovaní uživatelé. <a href="%s">Založte si úèet</a> a pak se <a href="%s">pøihlašte do blogu</a>. Váš prohlížeè musí podporovat cookies.');

@define('PLUGIN_ADDUSER_SERENDIPITY09',		'Tato volba vyžaduje Serendipity 0.9 nebo vyšší.');
@define('PLUGIN_ADDUSER_STRAIGHT',		'Okamžité vložení?');
@define('PLUGIN_ADDUSER_STRAIGHT_DESC',		'Pokud je povoleno, uživatel bude okamžitì po registraci vložen jako aktivovaný autor. Tato volba je doporuèena pouze na serverech, kde není pøítomen mailserver. Toto nastavení mùže být lehce zneužito spamery. Zapnìte jen pokud dobøe víte, co dìláte!');

@define('PLUGIN_ADDUSER_REGISTERED_CHECK',		'Ochrana pøed falšováním identity');
@define('PLUGIN_ADDUSER_REGISTERED_CHECK_DESC',		'Pokud je povoleno, uživatelská jména zaregistrovaných autorù mohou používat pouze tito autoøi, navíc musí být pod tímto jménem pøihlášeni.');
@define('PLUGIN_ADDUSER_REGISTERED_CHECK_REASON',		'Jméno, které jste zadali, patøí jinému uživateli registrovanému na tomto blogu. <a href="%s" %s>Pøihlašte se prosím</a>, abyste mohli poslat pøíspìvek pod Vaším jménem. Pokud nemáte zaregistrovaný úèet pod výše uvedeným jménem, použijte prosím jiné jméno.');

@define('PLUGIN_ADDUSER_ADMINAPPROVE',		'Registrovaní uživatelé musí mít potvrzení administrátora?');
@define('PLUGIN_ADDUSER_ADMINAPPROVE_DESC',		'Pokud je zapnuto, administrátor musí nového uživatele nejdøíve potvrdit, teprve pak mu bude odeslán aktivaèní email.');
@define('PLUGIN_ADDUSER_SENTMAIL_APPROVE',		'Váš úèet by vytvoøen. Poté, co Váš úèet schválí administrátor, Vám bude zaslán email se souhrnem dùležitých informací.');
@define('PLUGIN_ADDUSER_SENTMAIL_APPROVE_ADMIN',		'Úèet byl potvrzen, uživateli byl zaslán email s údaji o jeho úètu.');
@define('PLUGIN_ADDUSER_MAIL_SUBJECT_APPROVE',		'[Potvrzení vyžadováno] Nový uživatelský úèet byl vytvoøen');
@define('PLUGIN_ADDUSER_MAIL_BODY_APPROVE',		"Nový uživatelský úèet se jménem %s byl vytvoøen na blogu %s. Pro potvrzení úètu, a aby si mohl uživatel úèet aktivovat, kliknìte na následující odkaz:\n\n%s\n\nPoté, co tak uèiníte, nový uživatel obdrží aktivaèní email s nezbytnými informacemi pro pøihlášení.");

@define('PLUGIN_ADDUSER_CAPTCHA',		'Použít kryptogramy');
@define('PLUGIN_ADDUSER_CAPTCHA_DESC',		'Vyžaduje nainstalovaný plugin událostí "spamblock".');

@define('PLUGIN_ADDUSER_ANTISPAM',		'Neprošli jste protispamovým testem. Prosím zkontrolujte, jestli jste správnì opsali KRYPTOGRAM.');
