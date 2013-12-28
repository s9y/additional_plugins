<?php

/**
 *  @file lang_cs.inc.php 1.1 2011-04-17 14:21:59 VladaAjgl
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/20
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/04/17
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/10/26
 */

@define('PLUGIN_GUESTBOOK_HEADLINE', 'Hlavní nadpis');
@define('PLUGIN_GUESTBOOK_HEADLINE_BLAHBLAH', 'Hlavní nadpis stránky s návštìvní knihou.');
@define('PLUGIN_GUESTBOOK_TITLE', 'Návštìvní kniha');
@define('PLUGIN_GUESTBOOK_TITLE_BLAHBLAH', 'Zobrazuje návštìvní knihu jako stránku blogu. Vzhled je totožný s ostatními stránkami.');
@define('PLUGIN_GUESTBOOK_PERMALINK', 'Stálý odkaz');
@define('PLUGIN_GUESTBOOK_PERMALINK_BLAHBLAH', 'Definuje stálý URL odkaz. (Návštìvní knihu pak mùžete odkazovat pomocí tohoto odkazu a ne pomocí nepøehledného vnitøního odkazu, který používá Serendipity.) Je tøeba zadat absolutní HTTP cestu, vèetnì ukonèovacího .htm nebo .html!');
@define('PLUGIN_GUESTBOOK_PAGETITLE', 'Nadpis statické stránky a URL');
@define('PLUGIN_GUESTBOOK_PAGETITLE_BLAHBLAH', 'Nadpis stránky pro modul "Statické stránky". Pozor: tento nadpis také definuje URL adresu statické stránky (index.php?serendipity[subpage]=jmeno)');
@define('PLUGIN_GUESTBOOK_FORMORDER', 'Formuláø návštìvní knihy');
@define('PLUGIN_GUESTBOOK_FORMORDER_BLAHBLAH', 'Kde má být umístìn formuláø pro poslání vzkazu.');
@define('PLUGIN_GUESTBOOK_FORMORDER_TOP', 'Nahoøe');
@define('PLUGIN_GUESTBOOK_FORMORDER_BOTTOM', 'Dole');
@define('PLUGIN_GUESTBOOK_FORMORDER_POPUP', 'Vyskakovací okno');

@define('PLUGIN_GUESTBOOK_EMAILADMIN', 'Poslat mail administrátorovi?');
@define('PLUGIN_GUESTBOOK_EMAILADMIN_BLAHBLAH', 'Pokud nastaveno na "Ano", pak bude administrátor mailem upozornìn na každý nový pøíspìvek.');
@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN', 'Email administrátora');
@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN_BLAHBLAH', 'Zadejte prosím platnou emailovou adresu, na kterou mají být posílána oznámení o nových vzkazech.');
@define('PLUGIN_GUESTBOOK_SHOWEMAIL', 'Požadovat email uživatelù?');
@define('PLUGIN_GUESTBOOK_SHOWEMAIL_BLAHBLAH', 'Má se zobrazovat pole, které žádá po uživateli zadání emailové adresy?');
@define('PLUGIN_GUESTBOOK_SHOWURL', 'Požadovat domovskou stránku?');
@define('PLUGIN_GUESTBOOK_SHOWURL_BLAHBLAH', 'Má se zobrazovat pole, které žádá po uživateli zadání domovské (www) stránky?');
@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA', 'Zobrazovat kryptogramy?');
@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA_BLAHBLAH', 'Mají se pøi zadávání vzkazù používat KRYPTOGRAMY? (vyžaduje aktivní modul Spamblock)');
@define('PLUGIN_GUESTBOOK_NUMBER', 'Poèet vzkazù na stránku');
@define('PLUGIN_GUESTBOOK_NUMBER_BLAHBLAH', 'Kolik vzkazù se má zobrazovat na jedné stránce?');
@define('PLUGIN_GUESTBOOK_WORDWRAP', 'Znakù na øádku (pro zalamování)');
@define('PLUGIN_GUESTBOOK_WORDWRAP_BLAHBLAH', 'Po kolika znacích má být vložen znak nové øádky?');
@define('PLUGIN_GUESTBOOK_ERROR_DATA', 'Jméno, email ani vlastní text vzkazu nesmí být prázdné.');

@define('PLUGIN_GUESTBOOK_EMAIL', 'Emailová adresa');
@define('PLUGIN_GUESTBOOK_INTRO', 'Úvodní text (nepovinný)');
@define('PLUGIN_GUESTBOOK_MESSAGE', 'Vzkaz');
@define('PLUGIN_GUESTBOOK_SENT', 'Text který se má zobrazit po odeslání vzkazu');
@define('PLUGIN_GUESTBOOK_SENT_HTML', 'Váš vzkaz byl úspìšnì odeslán!');
@define('PLUGIN_GUESTBOOK_ERROR_HTML', 'Pøi odesílání vzkazu se objevila chyba!');
@define('PLUGIN_GUESTBOOK_ERROR_DATA', 'Jméno, email ani vlastní text vzkazu nesmí být prázdné.');
@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT', 'Formátovat jako èlánek?');
@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT_BLAHBLAH', 'Pokud je zapnuto, výstup je automaticky formátován jako bìžný èlánek/pøíspìvek (co se týèe barev, okrajù, atd.) (výchozí: ano)');
@define('PLUGIN_GUESTBOOK_CAPTCHAWARNING', 'Pozor, kryptogramy jsou používány!!!');
@define('PLUGIN_GUESTBOOK_PROTECTION', 'Emailová adresa bude pøemìnìna do formátu: "uživatel at email dot com"');
@define('PLUGIN_GUESTBOOK_DBDONE', 'Vzkaz do návštìvní knihy byl uložen!');
@define('PLUGIN_GUESTBOOK_USER_LOGGEDOFF', 'Uživatel se odhlásil.');
@define('PLUGIN_GUESTBOOK_USERSDATE_OF_ENTRY', 'napsal');
@define('PLUGIN_GUESTBOOK_UNKNOWN_ERROR', 'Neošetøená chyba! Kontaktujte prosím administrátora stránek.');
@define('PLUGIN_GUESTBOOK_TIMESTAMP_THE', ' ');
@define('PLUGIN_GUESTBOOK_ALTER_OLDTABLE_DONE', 'Databázová tabulka úspìšnì aktualizována (ALTER).');
@define('PLUGIN_GUESTBOOK_INSTALL_NEWTABLE_DONE', 'Databázová tabulka úspìšnì vytvoøena.');
@define('PLUGIN_GUESTBOOK_SUBMITFORM', 'Vložte nový vzkaz do návštìvní knihy');

@define('BODY', 'Vzkaz');
@define('SUBMIT', 'Odeslat vzkaz');
@define('REFRESH', 'Obnovte prosím stránku, pak uvidíte Váš vzkaz.');

@define('GUESTBOOK_NEXTPAGE', 'další stránka');
@define('GUESTBOOK_PREVPAGE', 'pøedchozí stránka');

@define('TEXT_DELETE', 'smazat');
@define('TEXT_SAY', 'øekl');
@define('TEXT_EMAIL', 'Email');
@define('TEXT_NAME', 'Jméno');
@define('TEXT_HOMEPAGE', 'WWW stránka');
@define('TEXT_EMAILSUBJECT', 'Nový vzkaz do návštìvní knihy');
@define('TEXT_EMAILTEXT',  "%s právì napsal do Tvé návštìvní knihy:\n%s\n%s\n");
@define('TEXT_CONVERTBOLDUNDERLINE', 'Text mezi hvìzdièkami bude tuèný (*slovo*), mezi podtržítky podtržený (_slovo_).');
@define('TEXT_CONVERTSMILIES', 'Bìžní smajlíci jako :-) a ;-) budou nahrazeni obrázky.');
@define('TEXT_IMG_DELETEENTRY', 'Smazat vzkaz');
@define('TEXT_IMG_LASTMODIFIED', 'naposledy zmìnìno');
@define('TEXT_USERS_HOMEPAGE', 'Domovská stránka');
@define('ERROR_NAMEEMPTY', 'Zadejte prosím své jméno.');
@define('ERROR_TEXTEMPTY', 'Zadejte prosím text vzkazu.');
@define('ERROR_EMAILEMPTY', 'Zadejte prosím platnou emailovou adresu.');
@define('ERROR_DATATOSHORT', 'Váš vzkaz musí mít alespoò 3, v poli pro komentáø pak 10 znakù.');
@define('ERROR_NOVALIDEMAIL', 'Vaše emailová adresa vypadá neplatnì: ');
@define('ERROR_NOINPUT', 'Zadejte prosím jméno, emailovou adresu a vzkaz');
@define('ERROR_ISFALSECAPTCHA', 'Nesprávnì zadaný KRYPTOGRAM!');
@define('ERROR_NOCAPTCHASET', 'Nastavení KRYPTOGRAMÙ nejspíš není správné!');
@define('ERROR_UNKNOWN', 'Vyskytla se neošetøená chyba. Zkuste akci znovu, nebo kontaktujte administrátora stránky. Díky za pochopení.');
@define('ERROR_OCCURRED', 'Vyskytly se chyby:');

@define('THANKS_FOR_ENTRY', 'Podìkování za vzkaz:');
@define('WINDOW_CLOSE', 'Zavøít okno');
@define('QUESTION_DELETE', 'Opravdu si pøejete smazat vzkaz od %s?');

@define('PAGINATOR_TO', 'Do');
@define('PAGINATOR_FIRST', 'První');
@define('PAGINATOR_PREVIOUS', 'Pøedchozí');
@define('PAGINATOR_NEXT', 'Následující');
@define('PAGINATOR_LAST', 'Poslední');
@define('PAGINATOR_PAGE', 'Stránka.');
@define('PAGINATOR_RANGE', ' do ');
@define('PAGINATOR_OFFSET', ', celkem ');
@define('PAGINATOR_ENTRIES', ' vzkazù. ');

//
//  serendipity_plugin_guestbook.php
//

@define('PLUGIN_GUESTSIDE_NAME', 'Návštìvní kniha - postranní blok');
@define('PLUGIN_GUESTSIDE_BLAHBLAH', 'Zobrazuje nejnovìjší vzkazy z návštìvní knihy v bloku v postranním sloupci');
@define('PLUGIN_GUESTSIDE_TITLE', 'Nadpis bloku');
@define('PLUGIN_GUESTSIDE_TITLE_BLAHBLAH', 'Zadejte nadpis bloku se vzkazy');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL', 'Zobrazovat email');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL_BLAHBLAH', 'Mají se zobrazovat emailové adresy pøispìvatelù?');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE', 'Zobrazovat domovské stránky');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE_BLAHBLAH', 'Mají se zobrazovat domovské (www) stránky pøispìvatele?');
@define('PLUGIN_GUESTSIDE_MAXCHARS', 'Maximálnì znakù');
@define('PLUGIN_GUESTSIDE_MAXCHARS_BLAHBLAH', 'Nejvìtší povolená délka (poèet znakù) pøíspìveku');
@define('PLUGIN_GUESTSIDE_MAXITEMS', 'Maximálnì vzkazù');
@define('PLUGIN_GUESTSIDE_MAXITEMS_BLAHBLAH', 'Zadejte poèet vzkazù, který se má zobrazovat v bloku v postranním sloupci');
@define('PLUGIN_GUESTSIDE_NOENTRIES', 'Ještì nikdo nezanechal vzkaz v návštìvní knize.');

// Next lines were translated on 2011/04/17

@define('PLUGIN_GUESTBOOK_DBDONE_APP', '(Jakmile bude pøíspìvek odsouhlasen, objeví se v návštìvní knize.)');
@define('ERROR_DATANOTAGS', 'Pøíspìvek není platný. Nejsou povoleny html tagy nebo bbcode.');
@define('PLUGIN_GUESTBOOK_SHOWAPP', 'Schvalovat pøíspìvky?');
@define('PLUGIN_GUESTBOOK_SHOWAPP_BLAHBLAH', 'Pøíspìvky do návštìvní knihy budou pøedkládany administrátorovi ke schválení pøedtím, než se zobrazí na stránce (výchozí: ne).');
@define('PLUGIN_GUESTBOOK_APP_ENTRY', 'Váš pøíspìvek %s byl uložen');
@define('PLUGIN_GUESTBOOK_CHECKBOXALERT', 'Zaškrtnìte políèko u pøíspìvku, který chcete schválit, zmìnit nebo vymazat.');
@define('PLUGIN_GUESTBOOK_ADMINBODY', 'Odpovìï admina');
@define('PLUGIN_GUESTBOOK_FORM_RIGHT_BBC', 'Používejte BBcode (strong, italic, underline, strike, quotes).');
@define('PLUGIN_GUESTBOOK_AUTOMODERATE', 'Použít automatické schvalování?');
@define('PLUGIN_GUESTBOOK_AUTOMODERATE_BLAHBLAH', 'Nastavuje pøíspìvky návštìvní knihy, aby byly administrátorem schvalovány pøe zobrazením. Pokud plugin SPAMBLOCK nejdøíve nastaví pøíspìvek ke schválení, hledání stop-slov vždy skonèí s pozitivním výsledkem (výchozí: ne).');
@define('PLUGIN_GUESTBOOK_AUTOMODERATE_ERROR', 'Váš pøíspìvek byl oznaèen ke schválení administrátorem.');
@define('PLUGIN_GUESTBOOK_CONFIG_ERROR', 'Výstraha nevhodného nastavení konfiguraèního souboru! Volba návštìvní knihy: "Automatické schvalování" je nastaveno na výchozí hodnotu "ne", když je "schvalování pøíspìvkù" aktivní! Lze použít pouze jednu ze zmínìných voleb, ne souèasnì.');
@define('PLUGIN_GUESTBOOK_FILTER_ENTRYCHECKS', 'Speciální kontrola tìla pøíspìvku');
@define('PLUGIN_GUESTBOOK_FILTER_ENTRYCHECKS_BLAHBLAH', 'Vyjmenujte speciální kontroly tìla pøíspìvkù. Povoleny jsou reguálrní výrazy oddìlené støedníkem (;). Speciální znaky musíte escapovat pomocí "\". Pokud ponecháte toto pole prázdné, nebudou provádìny žádné speciální kontroly!');
@define('PLUGIN_GUESTBOOK_ADMIN_NAME', 'Návštìvní kniha');
@define('PLUGIN_GUESTBOOK_ADMIN_NAME_MENU', 'Návštìvní kniha verze %s - Administraèní menu');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC', 'Návštìvní kniha - administrace databázových tabulek pluginu');
@define('PLUGIN_GUESTBOOK_ADMIN_VIEW', 'Návštìvní kniha - zobrazit pøíspìvky');
@define('PLUGIN_GUESTBOOK_ADMIN_VIEW_NORESULT', 'V návštìvní knize nejsou žádné schválené pøíspìvky!');
@define('PLUGIN_GUESTBOOK_ADMIN_VIEW_DESC', 'Seskupovat podle data [nejnovìjší nahoøe].');
@define('PLUGIN_GUESTBOOK_ADMIN_APP', 'Návštìvní kniha - schvalování pøíspìvkù');
@define('PLUGIN_GUESTBOOK_ADMIN_APP_DESC', 'Seskupovat podle data [nejnovìjší nahoøe].');
@define('PLUGIN_GUESTBOOK_ADMIN_APP_NORESULT', 'Žádné nové pøíspìvky ke schválení!');
@define('PLUGIN_GUESTBOOK_ADMIN_ERASE', 'Návštìvní kniha - smazat pøíspìvky');
@define('PLUGIN_GUESTBOOK_ADMIN_ADD', 'Návštìvní kniha - pøidat pøíspìvek');
@define('PLUGIN_GUESTBOOK_ADMIN_DROP_SURE', 'Urèitì chcete smazat celou databázovou tabulku návštìvní knihy vèetnì všech pøíspìvkù? Prosím potvrïte!');
@define('PLUGIN_GUESTBOOK_ADMIN_DROP_OK', 'Databázová tabulka %s byla úspìšnì smazána!');
@define('PLUGIN_GUESTBOOK_ADMIN_DUMP_SELF', 'Pøed pokraèováním byste mìli pro jistotu provést mysql dump (záloha) pomocí PhpMyAdmina nebo pomocí zálohovacího odkazu výše!');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP', 'Administrace databáze - záloha');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_DESC', 'zálohujte databázovou tabulku návštìvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_TITLE', 'záloha hodnot z databázové tabulky');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_DONE', 'Databázová tabulka návštìvní knihy byla úspìšnì zálohována!');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT', 'Administrace databáza - vložení');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_DESC', 'vložit do databázové tabulky návštìvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_TITLE', 'vložit hodnoty do databázové tabulky návštìvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_MSG', 'Protože tato operace není triviální, použijte prosím databázové administraèní nástroje jako napøíklad PhpMyAdmin pro znovu naplnìní databáze!');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE', 'Administrace databáze - vymazání');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE_DESC', 'Odstranit databázovou tabulku návštìvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE_TITLE', 'Mazání databázové tabulky návštìvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DELFILE_MSG', 'Databázová tabulka <u>%s</u> byla úspìšnì vymazána');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD', 'Administrace databáze - download');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_DESC', 'Stáhnout do souboru zálohu databázové tabulky návštìvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_TITLE', 'Stažení zálohy databázové tabulky');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_MSG', 'Neexistuje žádná záloha databázové tabulky návštìvní knihy!');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_DESC', 'Žádná záloha tabulky návštìvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_TITLE', 'Adminsitrace - chyba');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_NOBACKUP', 'Vybraná databázová tabulka nemohla být zálohována!');

// Next lines were translated on 2013/10/26
@define('TEXT_EMAILMODERATE', "\n\nTento pøíspìvek do návštìvní knihy byl nastaven, že vyžaduje schválení (%s)!");
@define('TEXT_EMAILFOOTER', "\n\nOdesláno Serendipity pluginem Guestbook.");
@define('ERROR_DATASTRIPPED', 'Aktivní bezpeènostní filtr vyhodnotil Váš pøíspìvek jako neplatný. Odešlete prosím pøíspìvek znovu.');
@define('PLUGIN_GUESTBOOK_FILTER_ENTRYCHECKS_BYPASS', '(Pøeskoèeno pouze uživatelským oprávnìním USERLEVEL_ADMIN!)');