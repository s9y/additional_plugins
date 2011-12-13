<?php # lang_cz.inc.php 1.0 2009-02-18 14:31:18 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/18
 */

@define('PLUGIN_ADDUSER_NAME',		'Samoregistrace nových u¾ivatelù');
@define('PLUGIN_ADDUSER_DESC',		'Umo¾òuje náv¹tìvníkùm webu vytvoøit si vlastní u¾ivatelský úèet. Dohromady s pluginem událostí (index.php?serendipity[subpage]=adduser) mù¾ete urèit, jestli komentáøe mohou posílat pouze registrovaní u¾ivatelé.');
@define('PLUGIN_ADDUSER_INSTRUCTIONS',		'Dal¹í pokyny');
@define('PLUGIN_ADDUSER_INSTRUCTIONS_DESC',		'Zde pøidejte pokyny, které se mají objevit vedle formuláøe pro vytvoøení u¾ivatelského úètu.');
@define('PLUGIN_ADDUSER_INSTRUCTIONS_DEFAULT',		'Zde se mù¾ete zaregistrovat do blogu jako nový u¾ivatel. Jednodu¹e zadejte svá data, potvrïte formuláø a øiïte se dal¹ími pokyny, které Vám pøijdou mailem.');
@define('PLUGIN_ADDUSER_USERLEVEL',		'Výchozí u¾ivatelská úroveò');
@define('PLUGIN_ADDUSER_USERLEVEL_DESC',		'Jakou u¾ivatelskou úroveò (oprávnìní) má mít nový u¾ivatel');
@define('PLUGIN_ADDUSER_USERLEVEL_CHIEF',		'Autor');
@define('PLUGIN_ADDUSER_USERLEVEL_EDITOR',		'Redaktor');
@define('PLUGIN_ADDUSER_USERLEVEL_ADMIN',		'Administrátor');
@define('PLUGIN_ADDUSER_USERLEVEL_DENY',		'Pøístup odepøen');
@define('PLUGIN_SIDEBAR_LOGIN',		'Zobrazit pøihla¹ovací formuláø v postranním sloupci?');
@define('PLUGIN_SIDEBAR_LOGIN_DESC',		'Pokud je povoleno, v postranním sloupci se budou zobrazovat blok s pøihla¹ovacím formuláøem. Pokud je zakázáno, budou se muset u¾ivatelé registrovat pomocí zvlá¹tní stránky v odpovídajícím pluginu událostí.');

@define('PLUGIN_ADDUSER_EXISTS',		'Omlouváme se, jméno "%s" u¾ nìkdo jiný pou¾ívá. Vyberte si prosím jiné.');
@define('PLUGIN_ADDUSER_MISSING',		'Musíte vyplnit v¹echna pole, aby Vám mohl být vytvoøen nový úèet.');
@define('PLUGIN_ADDUSER_SENTMAIL',		'Vá¹ úèet byl vytvoøen. Bìhem nìkolika okam¾ikù byste mìli obdr¾et email se souhrnem nejdùle¾itìj¹ích informací.');
@define('PLUGIN_ADDUSER_WRONG_ACTIVATION',		'Nesprávná aktivaèní URL adresa!');

@define('PLUGIN_ADDUSER_MAIL_SUBJECT',		'Nový u¾ivatelský úèet byl vytvoøen');
@define('PLUGIN_ADDUSER_MAIL_BODY',		"Nový u¾ivatelský úèet %s byl právì vytvoøen na blogu %s. Pro aktivaci toho úètu prosím kliknìte na následující odkaz:\n\n%s\n\nPoté se mù¾ete pøihlásit pomocí døíve zadaného jména a hesla. Tento email byl poslán jak novému u¾ivateli, tak provozovateli blogu.");
@define('PLUGIN_ADDUSER_SUCCEED',		'Úèet byl úspì¹nì aktivován. Nyní se mù¾ete pøihlásit do administrátorské sekce blogu. odkaz na pøihla¹ovací stránku je uveden v aktivaèním emailu.');
@define('PLUGIN_ADDUSER_FAILED',		'Úèet nemohl být aktivován. Neopsali jste ¹patnì URL adresu z aktivaèního emailu?');

@define('PLUGIN_ADDUSER_REGISTERED_ONLY',		'Komentáøe smí posílat pouze registrovaní u¾ivatelé?');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_DESC',		'Pokud je povoleno, komentáøe k pøíspìvkùm mohou posílat pouze registrovaní a pøihlá¹ení u¾ivatelé.');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_REASON',		'Komentáøe mohou posílat pouze registrovaní u¾ivatelé. <a href="%s">Zalo¾te si úèet</a> a pak se <a href="%s">pøihla¹te do blogu</a>. Vá¹ prohlí¾eè musí podporovat cookies.');

@define('PLUGIN_ADDUSER_SERENDIPITY09',		'Tato volba vy¾aduje Serendipity 0.9 nebo vy¹¹í.');
@define('PLUGIN_ADDUSER_STRAIGHT',		'Okam¾ité vlo¾ení?');
@define('PLUGIN_ADDUSER_STRAIGHT_DESC',		'Pokud je povoleno, u¾ivatel bude okam¾itì po registraci vlo¾en jako aktivovaný autor. Tato volba je doporuèena pouze na serverech, kde není pøítomen mailserver. Toto nastavení mù¾e být lehce zneu¾ito spamery. Zapnìte jen pokud dobøe víte, co dìláte!');

@define('PLUGIN_ADDUSER_REGISTERED_CHECK',		'Ochrana pøed fal¹ováním identity');
@define('PLUGIN_ADDUSER_REGISTERED_CHECK_DESC',		'Pokud je povoleno, u¾ivatelská jména zaregistrovaných autorù mohou pou¾ívat pouze tito autoøi, navíc musí být pod tímto jménem pøihlá¹eni.');
@define('PLUGIN_ADDUSER_REGISTERED_CHECK_REASON',		'Jméno, které jste zadali, patøí jinému u¾ivateli registrovanému na tomto blogu. <a href="%s" %s>Pøihla¹te se prosím</a>, abyste mohli poslat pøíspìvek pod Va¹ím jménem. Pokud nemáte zaregistrovaný úèet pod vý¹e uvedeným jménem, pou¾ijte prosím jiné jméno.');

@define('PLUGIN_ADDUSER_ADMINAPPROVE',		'Registrovaní u¾ivatelé musí mít potvrzení administrátora?');
@define('PLUGIN_ADDUSER_ADMINAPPROVE_DESC',		'Pokud je zapnuto, administrátor musí nového u¾ivatele nejdøíve potvrdit, teprve pak mu bude odeslán aktivaèní email.');
@define('PLUGIN_ADDUSER_SENTMAIL_APPROVE',		'Vá¹ úèet by vytvoøen. Poté, co Vá¹ úèet schválí administrátor, Vám bude zaslán email se souhrnem dùle¾itých informací.');
@define('PLUGIN_ADDUSER_SENTMAIL_APPROVE_ADMIN',		'Úèet byl potvrzen, u¾ivateli byl zaslán email s údaji o jeho úètu.');
@define('PLUGIN_ADDUSER_MAIL_SUBJECT_APPROVE',		'[Potvrzení vy¾adováno] Nový u¾ivatelský úèet byl vytvoøen');
@define('PLUGIN_ADDUSER_MAIL_BODY_APPROVE',		"Nový u¾ivatelský úèet se jménem %s byl vytvoøen na blogu %s. Pro potvrzení úètu, a aby si mohl u¾ivatel úèet aktivovat, kliknìte na následující odkaz:\n\n%s\n\nPoté, co tak uèiníte, nový u¾ivatel obdr¾í aktivaèní email s nezbytnými informacemi pro pøihlá¹ení.");

@define('PLUGIN_ADDUSER_CAPTCHA',		'Pou¾ít kryptogramy');
@define('PLUGIN_ADDUSER_CAPTCHA_DESC',		'Vy¾aduje nainstalovaný plugin událostí "spamblock".');

@define('PLUGIN_ADDUSER_ANTISPAM',		'Nepro¹li jste protispamovým testem. Prosím zkontrolujte, jestli jste správnì opsali KRYPTOGRAM.');
