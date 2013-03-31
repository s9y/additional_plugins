<?php # lang_cs.inc.php 1.1 2013-03-13 16:16:41 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/18
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/03/13
 */

@define('PLUGIN_ADDUSER_NAME',		'Samoregistrace nových uživatelů');
@define('PLUGIN_ADDUSER_DESC',		'Umožňuje návštěvníkům webu vytvořit si vlastní uživatelský účet. Dohromady s pluginem událostí (index.php?serendipity[subpage]=adduser) můžete určit, jestli komentáře mohou posílat pouze registrovaní uživatelé.');
@define('PLUGIN_ADDUSER_INSTRUCTIONS',		'Další pokyny');
@define('PLUGIN_ADDUSER_INSTRUCTIONS_DESC',		'Zde přidejte pokyny, které se mají objevit vedle formuláře pro vytvoření uživatelského účtu.');
@define('PLUGIN_ADDUSER_INSTRUCTIONS_DEFAULT',		'Zde se můžete zaregistrovat do blogu jako nový uživatel. Jednoduše zadejte svá data, potvrďte formulář a řiďte se dalšími pokyny, které Vám přijdou mailem.');
@define('PLUGIN_ADDUSER_USERLEVEL',		'Výchozí uživatelská úroveň');
@define('PLUGIN_ADDUSER_USERLEVEL_DESC',		'Jakou uživatelskou úroveň (oprávnění) má mít nový uživatel');
@define('PLUGIN_ADDUSER_USERLEVEL_CHIEF',		'Autor');
@define('PLUGIN_ADDUSER_USERLEVEL_EDITOR',		'Redaktor');
@define('PLUGIN_ADDUSER_USERLEVEL_ADMIN',		'Administrátor');
@define('PLUGIN_ADDUSER_USERLEVEL_DENY',		'Přístup odepřen');
@define('PLUGIN_SIDEBAR_LOGIN',		'Zobrazit přihlašovací formulář v postranním sloupci?');
@define('PLUGIN_SIDEBAR_LOGIN_DESC',		'Pokud je povoleno, v postranním sloupci se budou zobrazovat blok s přihlašovacím formulářem. Pokud je zakázáno, budou se muset uživatelé registrovat pomocí zvláštní stránky v odpovídajícím pluginu událostí.');

@define('PLUGIN_ADDUSER_EXISTS',		'Omlouváme se, jméno "%s" už někdo jiný používá. Vyberte si prosím jiné.');
@define('PLUGIN_ADDUSER_MISSING',		'Musíte vyplnit všechna pole, aby Vám mohl být vytvořen nový účet.');
@define('PLUGIN_ADDUSER_SENTMAIL',		'Váš účet byl vytvořen. Během několika okamžiků byste měli obdržet email se souhrnem nejdůležitějších informací.');
@define('PLUGIN_ADDUSER_WRONG_ACTIVATION',		'Nesprávná aktivační URL adresa!');

@define('PLUGIN_ADDUSER_MAIL_SUBJECT',		'Nový uživatelský účet byl vytvořen');
@define('PLUGIN_ADDUSER_MAIL_BODY',		"Nový uživatelský účet %s byl právě vytvořen na blogu %s. Pro aktivaci toho účtu prosím klikněte na následující odkaz:\n\n%s\n\nPoté se můžete přihlásit pomocí dříve zadaného jména a hesla. Tento email byl poslán jak novému uživateli, tak provozovateli blogu.");
@define('PLUGIN_ADDUSER_SUCCEED',		'Účet byl úspěšně aktivován. Nyní se můžete přihlásit do administrátorské sekce blogu. odkaz na přihlašovací stránku je uveden v aktivačním emailu.');
@define('PLUGIN_ADDUSER_FAILED',		'Účet nemohl být aktivován. Neopsali jste špatně URL adresu z aktivačního emailu?');

@define('PLUGIN_ADDUSER_REGISTERED_ONLY',		'Komentáře smí posílat pouze registrovaní uživatelé?');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_DESC',		'Pokud je povoleno, komentáře k příspěvkům mohou posílat pouze registrovaní a přihlášení uživatelé.');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_REASON',		'Komentáře mohou posílat pouze registrovaní uživatelé. <a href="%s">Založte si účet</a> a pak se <a href="%s">přihlašte do blogu</a>. Váš prohlížeč musí podporovat cookies.');

@define('PLUGIN_ADDUSER_SERENDIPITY09',		'Tato volba vyžaduje Serendipity 0.9 nebo vyšší.');
@define('PLUGIN_ADDUSER_STRAIGHT',		'Okamžité vložení?');
@define('PLUGIN_ADDUSER_STRAIGHT_DESC',		'Pokud je povoleno, uživatel bude okamžitě po registraci vložen jako aktivovaný autor. Tato volba je doporučena pouze na serverech, kde není přítomen mailserver. Toto nastavení může být lehce zneužito spamery. Zapněte jen pokud dobře víte, co děláte!');

@define('PLUGIN_ADDUSER_REGISTERED_CHECK',		'Ochrana před falšováním identity');
@define('PLUGIN_ADDUSER_REGISTERED_CHECK_DESC',		'Pokud je povoleno, uživatelská jména zaregistrovaných autorů mohou používat pouze tito autoři, navíc musí být pod tímto jménem přihlášeni.');
@define('PLUGIN_ADDUSER_REGISTERED_CHECK_REASON',		'Jméno, které jste zadali, patří jinému uživateli registrovanému na tomto blogu. <a href="%s" %s>Přihlašte se prosím</a>, abyste mohli poslat příspěvek pod Vaším jménem. Pokud nemáte zaregistrovaný účet pod výše uvedeným jménem, použijte prosím jiné jméno.');

@define('PLUGIN_ADDUSER_ADMINAPPROVE',		'Registrovaní uživatelé musí mít potvrzení administrátora?');
@define('PLUGIN_ADDUSER_ADMINAPPROVE_DESC',		'Pokud je zapnuto, administrátor musí nového uživatele nejdříve potvrdit, teprve pak mu bude odeslán aktivační email.');
@define('PLUGIN_ADDUSER_SENTMAIL_APPROVE',		'Váš účet by vytvořen. Poté, co Váš účet schválí administrátor, Vám bude zaslán email se souhrnem důležitých informací.');
@define('PLUGIN_ADDUSER_SENTMAIL_APPROVE_ADMIN',		'Účet byl potvrzen, uživateli byl zaslán email s údaji o jeho účtu.');
@define('PLUGIN_ADDUSER_MAIL_SUBJECT_APPROVE',		'[Potvrzení vyžadováno] Nový uživatelský účet byl vytvořen');
@define('PLUGIN_ADDUSER_MAIL_BODY_APPROVE',		"Nový uživatelský účet se jménem %s byl vytvořen na blogu %s. Pro potvrzení účtu, a aby si mohl uživatel účet aktivovat, klikněte na následující odkaz:\n\n%s\n\nPoté, co tak učiníte, nový uživatel obdrží aktivační email s nezbytnými informacemi pro přihlášení.");

@define('PLUGIN_ADDUSER_CAPTCHA',		'Použít kryptogramy');
@define('PLUGIN_ADDUSER_CAPTCHA_DESC',		'Vyžaduje nainstalovaný plugin událostí "spamblock".');

@define('PLUGIN_ADDUSER_ANTISPAM',		'Neprošli jste protispamovým testem. Prosím zkontrolujte, jestli jste správně opsali KRYPTOGRAM.');

// Next lines were translated on 2013/03/13
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_GROUP',		'Přídavná funkce: Pouze registrovaní uživatelé z této skupiny smí přidávat komentáře?');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_GROUP_DESC',		'Abyste toto mohli použít, musíte zároveň povolit volbu "Komentáře smí posílat pouze registrovaní uživatelé". Pokud je tato volba zapnutá, pak mohou posílat komentáře pouze uživatelé ze specifické skupiny uživatelů a musí k tomu být přihlášeni.');