<?php # lang_cs.inc.php 1.0 2009-05-15 19:00:31 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/15
 */

@define('PLUGIN_FORUM_TITLE', 'Diskusní fórum / zrcadlení phpBB fóra');
@define('PLUGIN_FORUM_DESC', 'Poskytuje kompletní diskusní fórum. Alternativě umožňuje přístup do diskusního fóra phpBB.');
@define('PLUGIN_FORUM_PAGETITLE', 'Titulek stránky');
@define('PLUGIN_FORUM_PAGETITLE_BLAHBLAH', 'TItule stránky s diskusním fórem, tj. informace v horním pruhu okna prohlížeče');
@define('PLUGIN_FORUM_HEADLINE', 'Nadpis');
@define('PLUGIN_FORUM_HEADLINE_BLAHBLAH', 'Hlavní nadpis stránky s fórem');
@define('PLUGIN_FORUM_PAGEURL', 'Statická URL adresa');
@define('PLUGIN_FORUM_PAGEURL_BLAHBLAH', 'Definujte statickou URL adresu, pod kterou bude fórum dostupné (index.php?serendipity[subpage]={zde zadané jméno})');
@define('PLUGIN_FORUM_UPLOADDIR', 'Absolutní cesta vzhledem ke kořenovému adresáři serveru do adresáře s nahranými soubory (upload)');
@define('PLUGIN_FORUM_UPLOADDIR_BLAHBLAH', 'výchozí: '. $serendipity['serendipityPath'].'files');
@define('PLUGIN_FORUM_DATEFORMAT', 'Formát data zobrazovaného u příspěvků, lze použít libovolný formát platný pro PHP funkci date(). (Výchozí: "Y/m/d")');
@define('PLUGIN_FORUM_TIMEFORMAT', 'Formátování času');
@define('PLUGIN_FORUM_TIMEFORMAT_BLAHBLAH', 'Formát času zobrazovaného u příspěvků, lze použít libovolný formát platný pro PHP funkci date(). (Výchozí: "h:ia")');
@define('PLUGIN_FORUM_BGCOLOR_HEAD', 'Barva pozadí pro pruh s titulkem');
@define('PLUGIN_FORUM_BGCOLOR_HEAD_BLAHBLAH', 'Barva pozadí všech titulkových pruhů');
@define('PLUGIN_FORUM_BGCOLOR1', '1. barva pozadí');
@define('PLUGIN_FORUM_BGCOLOR2', '2. barva pozadí');
@define('PLUGIN_FORUM_APPLY_MARKUP', 'Mají se ve fóru používat značkovací pluginy?');
@define('PLUGIN_FORUM_APPLY_MARKUP_BLAHBLAH', 'Pokud "Ano", pak se všechny použité značkovací pluginy (BBCode, smajlíci, galleryimage, atd.) budou používat i v příspěvcích na fóru.');
@define('PLUGIN_FORUM_ITEMSPERPAGE', 'Počet položek na stránce');
@define('PLUGIN_FORUM_ITEMSPERPAGE_BLAHBLAH', 'Kolik položek (vláken/příspěvků) se má zobrazovat na stránce. (Výchozí: 15)');
@define('PLUGIN_FORUM_USE_CAPTCHAS', 'Používat plugin Spamblock');
@define('PLUGIN_FORUM_USE_CAPTCHAS_BLAHBLAH', 'Má se použít plugin Spamblock i ve fóru? (tj. kryptogramy při odesílání příspěvku)');
@define('PLUGIN_FORUM_UNREG_NOMARKUPS', 'Zakázat používání značkovacích pluginů nepřihlášeným uživatelům');
@define('PLUGIN_FORUM_UNREG_NOMARKUPS_BLAHBLAH', 'Má být používání značkovacích pluginů umožněno pouze registrovaným přispěvatelům?');
@define('PLUGIN_FORUM_FILEUPLOAD_REGUSER', 'Povolit nahrávání souborů všem registrovaným uživatelům.');
@define('PLUGIN_FORUM_FILEUPLOAD_REGUSER_BLAHBLAH', 'Má se registrovaným uživatelům povolit nahrávání souborů?');
@define('PLUGIN_FORUM_FILEUPLOAD_GUEST', 'Povolit nahrávání souborů nepřihlášeným návštěvníkům');
@define('PLUGIN_FORUM_FILEUPLOAD_GUEST_BLAHBLAH', 'Má se nahrávání povolit i nepřihlášeným návštěvníkům? (důrazně NEdoporučeno!!!)');
@define('PLUGIN_FORUM_HOW_MANY_FILES_IN_ONE_POST', 'Maximální pořet souborů u jednoho příspěvku');
@define('PLUGIN_FORUM_HOW_MANY_FILES_IN_ONE_POST_BLAHBLAH', 'Jaké nejvyšší množství souborů lze přiložit k jednomu příspěvku ve fóru?');
@define('FORUM_HOW_MANY_FILEUPLOADS_WHEN_POSTING', 'Počet současných uploadů');
@define('FORUM_HOW_MANY_FILEUPLOADS_WHEN_POSTING_BLAHBLAH', 'Kolik souborů je možné nahrát (uploadovat) při psaní nebo editaci příspěvku?');
@define('FORUM_PLUGIN_HOW_MANY_FILEUPLOADS_AT_ALL', 'Kolik nahraných souborů (uploadů) na uživatele?');
@define('FORUM_PLUGIN_HOW_MANY_FILEUPLOADS_AT_ALLBLAHBLAH', 'Kolik souborů celkem může nahrát jeden uživatel? Pozor: pokud povolíte nahrávání souborů i nepřihlášeným uživatelům, ti budou moci nahrát kolik souborů chtějí, protože tato volba nedokáže ohlídat množství souborů nahraných nepřihlášenými uživateli!!!');
@define('FORUM_PLUGIN_NOTIFYMAIL_FROM', 'Maily s oznámeními: odesílatel');
@define('FORUM_PLUGIN_NOTIFYMAIL_FROM_BLAHBLAH', 'Mailová adresa, která bude v mailech s oznámeními z fóra uvedena jako odesílatel.');
@define('FORUM_PLUGIN_NOTIFYMAIL_NAME', 'Maily s oznámeními: Jméno odesílatele');
@define('FORUM_PLUGIN_NOTIFYMAIL_NAME_BLAHBLAH', 'Jméno odesílatele mailů s oznámením');
@define('FORUM_PLUGIN_ADMIN_NOTIFY', 'Oznámení pro administrátora');
@define('FORUM_PLUGIN_ADMIN_NOTIFY_BLAHBLAH', 'Má se administrátorovi blogu poslat mailem oznámení, pokud je poslán nový příspěvek nebo odpověď?');
@define('PLUGIN_FORUM_COLORTODAY', 'Barva nápisu "Dnes"');
@define('PLUGIN_FORUM_COLORYESTERDAY', 'Barva nápisu "Včera"');


@define('PLUGIN_FORUM_NO_BOARDS', 'Žádná fóra nebyla ještě založena!');
@define('PLUGIN_FORUM_NO_ENTRIES', 'Fórum neobsahuje žádná diskuzní vlákna');
@define('PLUGIN_FORUM_BOARDS', 'Diskuzní fóra');
@define('PLUGIN_FORUM_THREADS', 'Diskuzní vlákna');
@define('PLUGIN_FORUM_POSTS', 'Příspěvky');
@define('PLUGIN_FORUM_NO_POSTS', 'Toto diskuzní vlákno zatím neobsahuje příspěvky!');
@define('PLUGIN_FORUM_LASTPOST', 'Nejnovější příspěvek');
@define('PLUGIN_FORUM_LASTREPLY', 'Nejnovější odpověď');
@define('PLUGIN_FORUM_NO_THREADS', 'Nebyla nalezena žádná diskuzní vlákna');
@define('PLUGIN_FORUM_THREADTITLE', 'Nadpis diskuzního vlákna');
@define('PLUGIN_FORUM_POSTTITLE', 'Nadpis');
@define('PLUGIN_FORUM_REPLIES', 'Odpovědi');
@define('PLUGIN_FORUM_VIEWS', 'Zobrazení');
@define('PLUGIN_FORUM_NO_REPLIES', 'Žádné odpovědi');
@define('PLUGIN_FORUM_AUTHOR', 'Autor');
@define('PLUGIN_FORUM_MESSAGE', 'Zpráva');
@define('PLUGIN_FORUM_BACKTOTOP', 'Zpět nahoru');
@define('PLUGIN_FORUM_ALT_REOPEN', 'Znovu otevřít vlákno...');
@define('PLUGIN_FORUM_ALT_CLOSE', 'Zavřít vlákno...');
@define('PLUGIN_FORUM_ALT_MOVE', 'Přesunout toto diskuzní vlákno di jiného diskuzního fóra...');
@define('PLUGIN_FORUM_ALT_DELETE', 'Smazat příspěvek...');
@define('PLUGIN_FORUM_ALT_DELETE_POST', 'Vymaže tento příspěvek z fóra...');
@define('PLUGIN_FORUM_ALT_REPLY', 'Odpovědět v tomto vláknu...');
@define('PLUGIN_FORUM_ALT_QUOTE', 'Odpovědět v tomto vláknu s citací tohoto příspěvku...');
@define('PLUGIN_FORUM_ALT_EDIT', 'Editovat příspěvek...');
@define('PLUGIN_FORUM_ALT_DELETE', 'Smazat příspěvek...');
@define('PLUGIN_FORUM_ALT_UNREAD', 'ještě nebylo přečteno nebo přibyly nové odpovědi...');
@define('PLUGIN_FORUM_ALT_READ', 'již přečteno...');
@define('PLUGIN_FORUM_ALT_DIRECTGOTOPOST', 'přejít přímo na příspěvek...');
@define('PLUGIN_FORUM_MARKUPS', 'Následující značkovací jazyky mohou být použity, pokud je administrátor povolil: <br />&nbsp; - <a href=\"http://www.s9y.org/forums/faq.php?mode=bbcode\" target=\"_blank\">BBCode</a><br />&nbsp; - Smajlíci<br />&nbsp; - GalleryImage<br />');
@define('PLUGIN_FORUM_GUEST', 'Host');
@define('PLUGIN_FORUM_CONFIRM_DELETE_POST', 'Opravdu chcete smazat tento příspěvek?');
@define('PLUGIN_FORUM_ORDER', 'Seřadit');
@define('PLUGIN_FORUM_BOARDNAME', 'Jméno fóra');
@define('PLUGIN_FORUM_BOARDDESC', 'Popis');
@define('PLUGIN_FORUM_REALLY_DELETE_BOARDS', 'Opravdu chcete smazat {num} diskuzních fór?');
@define('PLUGIN_FORUM_REALLY_DELETE_THREAD', 'Opravdu chcete smazat diskuzní vlákno?');
@define('PLUGIN_FORUM_DELETE_OR_MOVE', 'Mají se diskuzní vlákna smazat nebo přesunout do jiného fóra?');
@define('PLUGIN_FORUM_WHERE_TO_MOVE', 'Vyberte diskuzní fórum nebo je smažte:');
@define('PLUGIN_FORUM_ADD_BOARD', 'Přidat nové fórum');
@define('PLUGIN_FORUM_PAGES', 'Stránky');
@define('PLUGIN_FORUM_MOVE_THREAD', 'Do kterého fóra chcete přesunout diskuzní vlákno?');
@define('PLUGIN_FORUM_MOVE', 'Přesun');
@define('PLUGIN_FORUM_FROM_BOARD', 'z fóra');
@define('PLUGIN_FORUM_TO_BOARD', 'do fóra');
@define('PLUGIN_FORUM_SUBMIT', 'Potvrdit');
@define('PLUGIN_FORUM_RESET', 'Zrušit');
@define('PLUGIN_FORUM_REG_USER', 'Registrovaný uživatel');
@define('PLUGIN_FORUM_POSTS', 'Příspěvky');
@define('PLUGIN_FORUM_VISITS', 'Návštěvy');
@define('PLUGIN_FORUM_UPLOAD_FILE','nahrání souboru');
@define('PLUGIN_FORUM_DOWNLOADCOUNT', 'Soubory ke stažení:');
@define('PLUGIN_FORUM_REST_UPLOAD_USER', 'souborů lze ještě nahrát');
@define('PLUGIN_FORUM_REST_UPLOAD_POST', 'souborů lze ještě nahrát do tohoto příspěvku');
@define('PLUGIN_FORUM_ANNOUNCEMENT', 'Je příspěvek oznámením?');
@define('PLUGIN_FORUM_SUBSCRIBE', 'Přihlásit se k odběru vlákna?');
@define('PLUGIN_FORUM_UNSUBSCRIBE', 'Odhlásit se z vlákna?');
@define('PLUGIN_FORUM_TODAY', 'Dnes');
@define('PLUGIN_FORUM_YESTERDAY', 'Včera');
@define('PLUGIN_FORUM_UPLOAD_OVERWRITE', 'Přepsat');
@define('PLUGIN_FORUM_UPLOAD_OVERWRITE_BLAHBLAH', 'Mají se všechny již nahrané soubory přepsat nově nahranými soubory?<br />Pozor: Toto přepíše *opravdu všechny* vaše soubory se stejným jménem!');

@define('PLUGIN_FORUM_ERR_MISSING_THREADTITLE', 'Chyba: Nadpis vlákna nebyl zadán nebo je příliš krátký (alespoň 4 znaky)! Příspěvek nebyl vložen!');
@define('PLUGIN_FORUM_ERR_MISSING_MESSAGE', 'Chyba: Text vlákna nebyl zadán nebo je příliš krátký (minimálně 4 znaky)! Příspěvek nebyl vložen!');
@define('PLUGIN_FORUM_ERR_THREAD_CLOSED', 'Chyba: Diskuzní vlákno bylo uzavřeno! Příspěvek nebyl vložen!');
@define('PLUGIN_FORUM_ERR_EDIT_NOT_ALLOWED', 'Chyba: Nemáte oprávnění měnit tento příspěvek! Příspěvek nebyl změněn!');
@define('PLUGIN_FORUM_ERR_DELETE_NOT_ALLOWED', 'Chyba: Nemáte oprávnění smazat příspěvek! Příspěvek byl ponechán!');
@define('PLUGIN_FORUM_ERR_DOUBLE_THREAD', 'Chyba: Vlákno již bylo jednou založeno! Příspěvek nebyl vložen!');
@define('PLUGIN_FORUM_ERR_DOUBLE_POST', 'Chyba: Tuto odpověď jste již odeslali! Příspěvek nebyl vložen!');
@define('PLUGIN_FORUM_ERR_POST_INTERVAL', 'Chyba: Příliš krátký interval mezi dvěma příspěvky! Příspěvek nebyl vložen!');
@define('PLUGIN_FORUM_ERR_WRONG_CAPTCHA_STRING', 'Chyba: Nesprávný kryptogram! Příspěvek nebyl vložen!');
@define('PLUGIN_FORUM_ERR_FILE_TOO_BIG', 'Soubor je příliš velký! Nebyl uložen!');
@define('PLUGIN_FORUM_ERR_FILE_NOT_COPIED', 'Soubor se nepodařilo zkopírovat! (z neupřesněného důvodu)');


// email notify
@define('PLUGIN_FORUM_EMAIL_NOTIFY_SUBJECT', 'Na fóru na {blogurl} přibyl nový příspěvek od autora  {postauthor}!');

@define('PLUGIN_FORUM_EMAIL_NOTIFY_PART1', 'Ahoj,

{postauthor} reagoval na diskuzi ve vlákně
"{threadtitle}"
na diskuzním fóru na
{forumurl}.

');

@define('PLUGIN_FORUM_EMAIL_NOTIFY_PART2', 'Zde je text jeho reakce:

----------------------------------------------------------------------
"{replytext}"
----------------------------------------------------------------------

');

@define('PLUGIN_FORUM_EMAIL_NOTIFY_PART3', 'Navštivte diskuzní vlákno kliknutím na následující odkaz:
{posturl}

');
@define('PLUGIN_FORUM_IMGDIR', 'Cesta k tomuto pluginu');
@define('PLUGIN_FORUM_IMGDIR_DESC', 'HTTP cesta k místu, kde je uložen tento plugin. Používá se např. pro výstup obrázků.');


@define('PLUGIN_FORUM_PHPBB_MIRROR', 'Povolit zdrcadlení phpBB?');
@define('PLUGIN_FORUM_PHPBB_MIRROR_DESC', 'Pokud je povoleno, nové příspěvky (články) na blogu budou přesměrovány do nastaveného phpBB fóra. Komentáře k příspěvkům (článkům) pak budou přesměrovány do phpBB fóra  nebudou ukládány zde na tomto blogu Serendipity.');

@define('FORUM_PLUGIN_PHPBB_USER', '(volitelné) phpBB - přihlašovací jméno k databázi');
@define('FORUM_PLUGIN_PHPBB_PW', '(volitelné) phpBB - heslo k databázi');
@define('FORUM_PLUGIN_PHPBB_NAME', '(volitelné) phpBB - jméno databáze');
@define('FORUM_PLUGIN_PHPBB_HOST', '(volitelné) phpBB - server s databází');
@define('FORUM_PLUGIN_PHPBB_PREFIX', '(volitelné) phpBB - předpona databázových tabulek (prefix)');
@define('FORUM_PLUGIN_PHPBB_FORUM', '(volitelné) phpBB - ID identifikátor fóra (diskuzní skupiny), kam budou nové články
 přesměrovány');
@define('FORUM_PLUGIN_PHPBB_POSTER', '(volitelné) phpBB - poster ID');
@define('FORUM_PLUGIN_PHPBB_DISCUSS', 'Diskutujte o tomto příspěvku na fóru');

@define('FORUM_PLUGIN_NEW_THREAD', 'Nové vlákno');

/* vim: set sts=4 ts=4 expandtab : */