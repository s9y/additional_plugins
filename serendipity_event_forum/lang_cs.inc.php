<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/15
 */

@define('PLUGIN_FORUM_TITLE', 'Diskusní fórum / zrcadlení phpBB fóra');
@define('PLUGIN_FORUM_DESC', 'Poskytuje kompletní diskusní fórum. Alternativì umožòuje pøístup do diskusního fóra phpBB.');
@define('PLUGIN_FORUM_PAGETITLE', 'Titulek stránky');
@define('PLUGIN_FORUM_PAGETITLE_BLAHBLAH', 'TItule stránky s diskusním fórem, tj. informace v horním pruhu okna prohlížeèe');
@define('PLUGIN_FORUM_HEADLINE', 'Nadpis');
@define('PLUGIN_FORUM_HEADLINE_BLAHBLAH', 'Hlavní nadpis stránky s fórem');
@define('PLUGIN_FORUM_PAGEURL', 'Statická URL adresa');
@define('PLUGIN_FORUM_PAGEURL_BLAHBLAH', 'Definujte statickou URL adresu, pod kterou bude fórum dostupné (index.php?serendipity[subpage]={zde zadané jméno})');
@define('PLUGIN_FORUM_UPLOADDIR', 'Absolutní cesta vzhledem ke koøenovému adresáøi serveru do adresáøe s nahranými soubory (upload)');
@define('PLUGIN_FORUM_UPLOADDIR_BLAHBLAH', 'výchozí: '. $serendipity['serendipityPath'].'files');
@define('PLUGIN_FORUM_DATEFORMAT', 'Formát data zobrazovaného u pøíspìvkù, lze použít libovolný formát platný pro PHP funkci date(). (Výchozí: "Y/m/d")');
@define('PLUGIN_FORUM_TIMEFORMAT', 'Formátování èasu');
@define('PLUGIN_FORUM_TIMEFORMAT_BLAHBLAH', 'Formát èasu zobrazovaného u pøíspìvkù, lze použít libovolný formát platný pro PHP funkci date(). (Výchozí: "h:ia")');
@define('PLUGIN_FORUM_BGCOLOR_HEAD', 'Barva pozadí pro pruh s titulkem');
@define('PLUGIN_FORUM_BGCOLOR_HEAD_BLAHBLAH', 'Barva pozadí všech titulkových pruhù');
@define('PLUGIN_FORUM_BGCOLOR1', '1. barva pozadí');
@define('PLUGIN_FORUM_BGCOLOR2', '2. barva pozadí');
@define('PLUGIN_FORUM_APPLY_MARKUP', 'Mají se ve fóru používat znaèkovací pluginy?');
@define('PLUGIN_FORUM_APPLY_MARKUP_BLAHBLAH', 'Pokud "Ano", pak se všechny použité znaèkovací pluginy (BBCode, smajlíci, galleryimage, atd.) budou používat i v pøíspìvcích na fóru.');
@define('PLUGIN_FORUM_ITEMSPERPAGE', 'Poèet položek na stránce');
@define('PLUGIN_FORUM_ITEMSPERPAGE_BLAHBLAH', 'Kolik položek (vláken/pøíspìvkù) se má zobrazovat na stránce. (Výchozí: 15)');
@define('PLUGIN_FORUM_USE_CAPTCHAS', 'Používat plugin Spamblock');
@define('PLUGIN_FORUM_USE_CAPTCHAS_BLAHBLAH', 'Má se použít plugin Spamblock i ve fóru? (tj. kryptogramy pøi odesílání pøíspìvku)');
@define('PLUGIN_FORUM_UNREG_NOMARKUPS', 'Zakázat používání znaèkovacích pluginù nepøihlášeným uživatelùm');
@define('PLUGIN_FORUM_UNREG_NOMARKUPS_BLAHBLAH', 'Má být používání znaèkovacích pluginù umožnìno pouze registrovaným pøispìvatelùm?');
@define('PLUGIN_FORUM_FILEUPLOAD_REGUSER', 'Povolit nahrávání souborù všem registrovaným uživatelùm.');
@define('PLUGIN_FORUM_FILEUPLOAD_REGUSER_BLAHBLAH', 'Má se registrovaným uživatelùm povolit nahrávání souborù?');
@define('PLUGIN_FORUM_FILEUPLOAD_GUEST', 'Povolit nahrávání souborù nepøihlášeným návštìvníkùm');
@define('PLUGIN_FORUM_FILEUPLOAD_GUEST_BLAHBLAH', 'Má se nahrávání povolit i nepøihlášeným návštìvníkùm? (dùraznì NEdoporuèeno!!!)');
@define('PLUGIN_FORUM_HOW_MANY_FILES_IN_ONE_POST', 'Maximální poøet souborù u jednoho pøíspìvku');
@define('PLUGIN_FORUM_HOW_MANY_FILES_IN_ONE_POST_BLAHBLAH', 'Jaké nejvyšší množství souborù lze pøiložit k jednomu pøíspìvku ve fóru?');
@define('FORUM_HOW_MANY_FILEUPLOADS_WHEN_POSTING', 'Poèet souèasných uploadù');
@define('FORUM_HOW_MANY_FILEUPLOADS_WHEN_POSTING_BLAHBLAH', 'Kolik souborù je možné nahrát (uploadovat) pøi psaní nebo editaci pøíspìvku?');
@define('FORUM_PLUGIN_HOW_MANY_FILEUPLOADS_AT_ALL', 'Kolik nahraných souborù (uploadù) na uživatele?');
@define('FORUM_PLUGIN_HOW_MANY_FILEUPLOADS_AT_ALLBLAHBLAH', 'Kolik souborù celkem mùže nahrát jeden uživatel? Pozor: pokud povolíte nahrávání souborù i nepøihlášeným uživatelùm, ti budou moci nahrát kolik souborù chtìjí, protože tato volba nedokáže ohlídat množství souborù nahraných nepøihlášenými uživateli!!!');
@define('FORUM_PLUGIN_NOTIFYMAIL_FROM', 'Maily s oznámeními: odesílatel');
@define('FORUM_PLUGIN_NOTIFYMAIL_FROM_BLAHBLAH', 'Mailová adresa, která bude v mailech s oznámeními z fóra uvedena jako odesílatel.');
@define('FORUM_PLUGIN_NOTIFYMAIL_NAME', 'Maily s oznámeními: Jméno odesílatele');
@define('FORUM_PLUGIN_NOTIFYMAIL_NAME_BLAHBLAH', 'Jméno odesílatele mailù s oznámením');
@define('FORUM_PLUGIN_ADMIN_NOTIFY', 'Oznámení pro administrátora');
@define('FORUM_PLUGIN_ADMIN_NOTIFY_BLAHBLAH', 'Má se administrátorovi blogu poslat mailem oznámení, pokud je poslán nový pøíspìvek nebo odpovìï?');
@define('PLUGIN_FORUM_COLORTODAY', 'Barva nápisu "Dnes"');
@define('PLUGIN_FORUM_COLORYESTERDAY', 'Barva nápisu "Vèera"');


@define('PLUGIN_FORUM_NO_BOARDS', 'Žádná fóra nebyla ještì založena!');
@define('PLUGIN_FORUM_NO_ENTRIES', 'Fórum neobsahuje žádná diskuzní vlákna');
@define('PLUGIN_FORUM_BOARDS', 'Diskuzní fóra');
@define('PLUGIN_FORUM_THREADS', 'Diskuzní vlákna');
@define('PLUGIN_FORUM_POSTS', 'Pøíspìvky');
@define('PLUGIN_FORUM_NO_POSTS', 'Toto diskuzní vlákno zatím neobsahuje pøíspìvky!');
@define('PLUGIN_FORUM_LASTPOST', 'Nejnovìjší pøíspìvek');
@define('PLUGIN_FORUM_LASTREPLY', 'Nejnovìjší odpovìï');
@define('PLUGIN_FORUM_NO_THREADS', 'Nebyla nalezena žádná diskuzní vlákna');
@define('PLUGIN_FORUM_THREADTITLE', 'Nadpis diskuzního vlákna');
@define('PLUGIN_FORUM_POSTTITLE', 'Nadpis');
@define('PLUGIN_FORUM_REPLIES', 'Odpovìdi');
@define('PLUGIN_FORUM_VIEWS', 'Zobrazení');
@define('PLUGIN_FORUM_NO_REPLIES', 'Žádné odpovìdi');
@define('PLUGIN_FORUM_AUTHOR', 'Autor');
@define('PLUGIN_FORUM_MESSAGE', 'Zpráva');
@define('PLUGIN_FORUM_BACKTOTOP', 'Zpìt nahoru');
@define('PLUGIN_FORUM_ALT_REOPEN', 'Znovu otevøít vlákno...');
@define('PLUGIN_FORUM_ALT_CLOSE', 'Zavøít vlákno...');
@define('PLUGIN_FORUM_ALT_MOVE', 'Pøesunout toto diskuzní vlákno di jiného diskuzního fóra...');
@define('PLUGIN_FORUM_ALT_DELETE', 'Smazat pøíspìvek...');
@define('PLUGIN_FORUM_ALT_DELETE_POST', 'Vymaže tento pøíspìvek z fóra...');
@define('PLUGIN_FORUM_ALT_REPLY', 'Odpovìdìt v tomto vláknu...');
@define('PLUGIN_FORUM_ALT_QUOTE', 'Odpovìdìt v tomto vláknu s citací tohoto pøíspìvku...');
@define('PLUGIN_FORUM_ALT_EDIT', 'Editovat pøíspìvek...');
@define('PLUGIN_FORUM_ALT_DELETE', 'Smazat pøíspìvek...');
@define('PLUGIN_FORUM_ALT_UNREAD', 'ještì nebylo pøeèteno nebo pøibyly nové odpovìdi...');
@define('PLUGIN_FORUM_ALT_READ', 'již pøeèteno...');
@define('PLUGIN_FORUM_ALT_DIRECTGOTOPOST', 'pøejít pøímo na pøíspìvek...');
@define('PLUGIN_FORUM_MARKUPS', 'Následující znaèkovací jazyky mohou být použity, pokud je administrátor povolil: <br />&nbsp; - <a href=\"http://www.s9y.org/forums/faq.php?mode=bbcode\" target=\"_blank\">BBCode</a><br />&nbsp; - Smajlíci<br />&nbsp; - GalleryImage<br />');
@define('PLUGIN_FORUM_GUEST', 'Host');
@define('PLUGIN_FORUM_CONFIRM_DELETE_POST', 'Opravdu chcete smazat tento pøíspìvek?');
@define('PLUGIN_FORUM_ORDER', 'Seøadit');
@define('PLUGIN_FORUM_BOARDNAME', 'Jméno fóra');
@define('PLUGIN_FORUM_BOARDDESC', 'Popis');
@define('PLUGIN_FORUM_REALLY_DELETE_BOARDS', 'Opravdu chcete smazat {num} diskuzních fór?');
@define('PLUGIN_FORUM_REALLY_DELETE_THREAD', 'Opravdu chcete smazat diskuzní vlákno?');
@define('PLUGIN_FORUM_DELETE_OR_MOVE', 'Mají se diskuzní vlákna smazat nebo pøesunout do jiného fóra?');
@define('PLUGIN_FORUM_WHERE_TO_MOVE', 'Vyberte diskuzní fórum nebo je smažte:');
@define('PLUGIN_FORUM_ADD_BOARD', 'Pøidat nové fórum');
@define('PLUGIN_FORUM_PAGES', 'Stránky');
@define('PLUGIN_FORUM_MOVE_THREAD', 'Do kterého fóra chcete pøesunout diskuzní vlákno?');
@define('PLUGIN_FORUM_MOVE', 'Pøesun');
@define('PLUGIN_FORUM_FROM_BOARD', 'z fóra');
@define('PLUGIN_FORUM_TO_BOARD', 'do fóra');
@define('PLUGIN_FORUM_SUBMIT', 'Potvrdit');
@define('PLUGIN_FORUM_RESET', 'Zrušit');
@define('PLUGIN_FORUM_REG_USER', 'Registrovaný uživatel');
@define('PLUGIN_FORUM_POSTS', 'Pøíspìvky');
@define('PLUGIN_FORUM_VISITS', 'Návštìvy');
@define('PLUGIN_FORUM_UPLOAD_FILE','nahrání souboru');
@define('PLUGIN_FORUM_DOWNLOADCOUNT', 'Soubory ke stažení:');
@define('PLUGIN_FORUM_REST_UPLOAD_USER', 'souborù lze ještì nahrát');
@define('PLUGIN_FORUM_REST_UPLOAD_POST', 'souborù lze ještì nahrát do tohoto pøíspìvku');
@define('PLUGIN_FORUM_ANNOUNCEMENT', 'Je pøíspìvek oznámením?');
@define('PLUGIN_FORUM_SUBSCRIBE', 'Pøihlásit se k odbìru vlákna?');
@define('PLUGIN_FORUM_UNSUBSCRIBE', 'Odhlásit se z vlákna?');
@define('PLUGIN_FORUM_TODAY', 'Dnes');
@define('PLUGIN_FORUM_YESTERDAY', 'Vèera');
@define('PLUGIN_FORUM_UPLOAD_OVERWRITE', 'Pøepsat');
@define('PLUGIN_FORUM_UPLOAD_OVERWRITE_BLAHBLAH', 'Mají se všechny již nahrané soubory pøepsat novì nahranými soubory?<br />Pozor: Toto pøepíše *opravdu všechny* vaše soubory se stejným jménem!');

@define('PLUGIN_FORUM_ERR_MISSING_THREADTITLE', 'Chyba: Nadpis vlákna nebyl zadán nebo je pøíliš krátký (alespoò 4 znaky)! Pøíspìvek nebyl vložen!');
@define('PLUGIN_FORUM_ERR_MISSING_MESSAGE', 'Chyba: Text vlákna nebyl zadán nebo je pøíliš krátký (minimálnì 4 znaky)! Pøíspìvek nebyl vložen!');
@define('PLUGIN_FORUM_ERR_THREAD_CLOSED', 'Chyba: Diskuzní vlákno bylo uzavøeno! Pøíspìvek nebyl vložen!');
@define('PLUGIN_FORUM_ERR_EDIT_NOT_ALLOWED', 'Chyba: Nemáte oprávnìní mìnit tento pøíspìvek! Pøíspìvek nebyl zmìnìn!');
@define('PLUGIN_FORUM_ERR_DELETE_NOT_ALLOWED', 'Chyba: Nemáte oprávnìní smazat pøíspìvek! Pøíspìvek byl ponechán!');
@define('PLUGIN_FORUM_ERR_DOUBLE_THREAD', 'Chyba: Vlákno již bylo jednou založeno! Pøíspìvek nebyl vložen!');
@define('PLUGIN_FORUM_ERR_DOUBLE_POST', 'Chyba: Tuto odpovìï jste již odeslali! Pøíspìvek nebyl vložen!');
@define('PLUGIN_FORUM_ERR_POST_INTERVAL', 'Chyba: Pøíliš krátký interval mezi dvìma pøíspìvky! Pøíspìvek nebyl vložen!');
@define('PLUGIN_FORUM_ERR_WRONG_CAPTCHA_STRING', 'Chyba: Nesprávný kryptogram! Pøíspìvek nebyl vložen!');
@define('PLUGIN_FORUM_ERR_FILE_TOO_BIG', 'Soubor je pøíliš velký! Nebyl uložen!');
@define('PLUGIN_FORUM_ERR_FILE_NOT_COPIED', 'Soubor se nepodaøilo zkopírovat! (z neupøesnìného dùvodu)');


// email notify
@define('PLUGIN_FORUM_EMAIL_NOTIFY_SUBJECT', 'Na fóru na {blogurl} pøibyl nový pøíspìvek od autora  {postauthor}!');

@define('PLUGIN_FORUM_EMAIL_NOTIFY_PART1', 'Ahoj,

{postauthor} reagoval na diskuzi ve vláknì
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
@define('PLUGIN_FORUM_IMGDIR_DESC', 'HTTP cesta k místu, kde je uložen tento plugin. Používá se napø. pro výstup obrázkù.');


@define('PLUGIN_FORUM_PHPBB_MIRROR', 'Povolit zdrcadlení phpBB?');
@define('PLUGIN_FORUM_PHPBB_MIRROR_DESC', 'Pokud je povoleno, nové pøíspìvky (èlánky) na blogu budou pøesmìrovány do nastaveného phpBB fóra. Komentáøe k pøíspìvkùm (èlánkùm) pak budou pøesmìrovány do phpBB fóra  nebudou ukládány zde na tomto blogu Serendipity.');

@define('FORUM_PLUGIN_PHPBB_USER', '(volitelné) phpBB - pøihlašovací jméno k databázi');
@define('FORUM_PLUGIN_PHPBB_PW', '(volitelné) phpBB - heslo k databázi');
@define('FORUM_PLUGIN_PHPBB_NAME', '(volitelné) phpBB - jméno databáze');
@define('FORUM_PLUGIN_PHPBB_HOST', '(volitelné) phpBB - server s databází');
@define('FORUM_PLUGIN_PHPBB_PREFIX', '(volitelné) phpBB - pøedpona databázových tabulek (prefix)');
@define('FORUM_PLUGIN_PHPBB_FORUM', '(volitelné) phpBB - ID identifikátor fóra (diskuzní skupiny), kam budou nové èlánky
 pøesmìrovány');
@define('FORUM_PLUGIN_PHPBB_POSTER', '(volitelné) phpBB - poster ID');
@define('FORUM_PLUGIN_PHPBB_DISCUSS', 'Diskutujte o tomto pøíspìvku na fóru');

@define('FORUM_PLUGIN_NEW_THREAD', 'Nové vlákno');

/* vim: set sts=4 ts=4 expandtab : */