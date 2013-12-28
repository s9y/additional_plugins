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
@define('PLUGIN_GUESTBOOK_HEADLINE_BLAHBLAH', 'Hlavní nadpis stránky s náv¹tìvní knihou.');
@define('PLUGIN_GUESTBOOK_TITLE', 'Náv¹tìvní kniha');
@define('PLUGIN_GUESTBOOK_TITLE_BLAHBLAH', 'Zobrazuje náv¹tìvní knihu jako stránku blogu. Vzhled je toto¾ný s ostatními stránkami.');
@define('PLUGIN_GUESTBOOK_PERMALINK', 'Stálý odkaz');
@define('PLUGIN_GUESTBOOK_PERMALINK_BLAHBLAH', 'Definuje stálý URL odkaz. (Náv¹tìvní knihu pak mù¾ete odkazovat pomocí tohoto odkazu a ne pomocí nepøehledného vnitøního odkazu, který pou¾ívá Serendipity.) Je tøeba zadat absolutní HTTP cestu, vèetnì ukonèovacího .htm nebo .html!');
@define('PLUGIN_GUESTBOOK_PAGETITLE', 'Nadpis statické stránky a URL');
@define('PLUGIN_GUESTBOOK_PAGETITLE_BLAHBLAH', 'Nadpis stránky pro modul "Statické stránky". Pozor: tento nadpis také definuje URL adresu statické stránky (index.php?serendipity[subpage]=jmeno)');
@define('PLUGIN_GUESTBOOK_FORMORDER', 'Formuláø náv¹tìvní knihy');
@define('PLUGIN_GUESTBOOK_FORMORDER_BLAHBLAH', 'Kde má být umístìn formuláø pro poslání vzkazu.');
@define('PLUGIN_GUESTBOOK_FORMORDER_TOP', 'Nahoøe');
@define('PLUGIN_GUESTBOOK_FORMORDER_BOTTOM', 'Dole');
@define('PLUGIN_GUESTBOOK_FORMORDER_POPUP', 'Vyskakovací okno');

@define('PLUGIN_GUESTBOOK_EMAILADMIN', 'Poslat mail administrátorovi?');
@define('PLUGIN_GUESTBOOK_EMAILADMIN_BLAHBLAH', 'Pokud nastaveno na "Ano", pak bude administrátor mailem upozornìn na ka¾dý nový pøíspìvek.');
@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN', 'Email administrátora');
@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN_BLAHBLAH', 'Zadejte prosím platnou emailovou adresu, na kterou mají být posílána oznámení o nových vzkazech.');
@define('PLUGIN_GUESTBOOK_SHOWEMAIL', 'Po¾adovat email u¾ivatelù?');
@define('PLUGIN_GUESTBOOK_SHOWEMAIL_BLAHBLAH', 'Má se zobrazovat pole, které ¾ádá po u¾ivateli zadání emailové adresy?');
@define('PLUGIN_GUESTBOOK_SHOWURL', 'Po¾adovat domovskou stránku?');
@define('PLUGIN_GUESTBOOK_SHOWURL_BLAHBLAH', 'Má se zobrazovat pole, které ¾ádá po u¾ivateli zadání domovské (www) stránky?');
@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA', 'Zobrazovat kryptogramy?');
@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA_BLAHBLAH', 'Mají se pøi zadávání vzkazù pou¾ívat KRYPTOGRAMY? (vy¾aduje aktivní modul Spamblock)');
@define('PLUGIN_GUESTBOOK_NUMBER', 'Poèet vzkazù na stránku');
@define('PLUGIN_GUESTBOOK_NUMBER_BLAHBLAH', 'Kolik vzkazù se má zobrazovat na jedné stránce?');
@define('PLUGIN_GUESTBOOK_WORDWRAP', 'Znakù na øádku (pro zalamování)');
@define('PLUGIN_GUESTBOOK_WORDWRAP_BLAHBLAH', 'Po kolika znacích má být vlo¾en znak nové øádky?');
@define('PLUGIN_GUESTBOOK_ERROR_DATA', 'Jméno, email ani vlastní text vzkazu nesmí být prázdné.');

@define('PLUGIN_GUESTBOOK_EMAIL', 'Emailová adresa');
@define('PLUGIN_GUESTBOOK_INTRO', 'Úvodní text (nepovinný)');
@define('PLUGIN_GUESTBOOK_MESSAGE', 'Vzkaz');
@define('PLUGIN_GUESTBOOK_SENT', 'Text který se má zobrazit po odeslání vzkazu');
@define('PLUGIN_GUESTBOOK_SENT_HTML', 'Vá¹ vzkaz byl úspì¹nì odeslán!');
@define('PLUGIN_GUESTBOOK_ERROR_HTML', 'Pøi odesílání vzkazu se objevila chyba!');
@define('PLUGIN_GUESTBOOK_ERROR_DATA', 'Jméno, email ani vlastní text vzkazu nesmí být prázdné.');
@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT', 'Formátovat jako èlánek?');
@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT_BLAHBLAH', 'Pokud je zapnuto, výstup je automaticky formátován jako bì¾ný èlánek/pøíspìvek (co se týèe barev, okrajù, atd.) (výchozí: ano)');
@define('PLUGIN_GUESTBOOK_CAPTCHAWARNING', 'Pozor, kryptogramy jsou pou¾ívány!!!');
@define('PLUGIN_GUESTBOOK_PROTECTION', 'Emailová adresa bude pøemìnìna do formátu: "u¾ivatel at email dot com"');
@define('PLUGIN_GUESTBOOK_DBDONE', 'Vzkaz do náv¹tìvní knihy byl ulo¾en!');
@define('PLUGIN_GUESTBOOK_USER_LOGGEDOFF', 'U¾ivatel se odhlásil.');
@define('PLUGIN_GUESTBOOK_USERSDATE_OF_ENTRY', 'napsal');
@define('PLUGIN_GUESTBOOK_UNKNOWN_ERROR', 'Neo¹etøená chyba! Kontaktujte prosím administrátora stránek.');
@define('PLUGIN_GUESTBOOK_TIMESTAMP_THE', ' ');
@define('PLUGIN_GUESTBOOK_ALTER_OLDTABLE_DONE', 'Databázová tabulka úspì¹nì aktualizována (ALTER).');
@define('PLUGIN_GUESTBOOK_INSTALL_NEWTABLE_DONE', 'Databázová tabulka úspì¹nì vytvoøena.');
@define('PLUGIN_GUESTBOOK_SUBMITFORM', 'Vlo¾te nový vzkaz do náv¹tìvní knihy');

@define('BODY', 'Vzkaz');
@define('SUBMIT', 'Odeslat vzkaz');
@define('REFRESH', 'Obnovte prosím stránku, pak uvidíte Vá¹ vzkaz.');

@define('GUESTBOOK_NEXTPAGE', 'dal¹í stránka');
@define('GUESTBOOK_PREVPAGE', 'pøedchozí stránka');

@define('TEXT_DELETE', 'smazat');
@define('TEXT_SAY', 'øekl');
@define('TEXT_EMAIL', 'Email');
@define('TEXT_NAME', 'Jméno');
@define('TEXT_HOMEPAGE', 'WWW stránka');
@define('TEXT_EMAILSUBJECT', 'Nový vzkaz do náv¹tìvní knihy');
@define('TEXT_EMAILTEXT',  "%s právì napsal do Tvé náv¹tìvní knihy:\n%s\n%s\n");
@define('TEXT_CONVERTBOLDUNDERLINE', 'Text mezi hvìzdièkami bude tuèný (*slovo*), mezi podtr¾ítky podtr¾ený (_slovo_).');
@define('TEXT_CONVERTSMILIES', 'Bì¾ní smajlíci jako :-) a ;-) budou nahrazeni obrázky.');
@define('TEXT_IMG_DELETEENTRY', 'Smazat vzkaz');
@define('TEXT_IMG_LASTMODIFIED', 'naposledy zmìnìno');
@define('TEXT_USERS_HOMEPAGE', 'Domovská stránka');
@define('ERROR_NAMEEMPTY', 'Zadejte prosím své jméno.');
@define('ERROR_TEXTEMPTY', 'Zadejte prosím text vzkazu.');
@define('ERROR_EMAILEMPTY', 'Zadejte prosím platnou emailovou adresu.');
@define('ERROR_DATATOSHORT', 'Vá¹ vzkaz musí mít alespoò 3, v poli pro komentáø pak 10 znakù.');
@define('ERROR_NOVALIDEMAIL', 'Va¹e emailová adresa vypadá neplatnì: ');
@define('ERROR_NOINPUT', 'Zadejte prosím jméno, emailovou adresu a vzkaz');
@define('ERROR_ISFALSECAPTCHA', 'Nesprávnì zadaný KRYPTOGRAM!');
@define('ERROR_NOCAPTCHASET', 'Nastavení KRYPTOGRAMÙ nejspí¹ není správné!');
@define('ERROR_UNKNOWN', 'Vyskytla se neo¹etøená chyba. Zkuste akci znovu, nebo kontaktujte administrátora stránky. Díky za pochopení.');
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

@define('PLUGIN_GUESTSIDE_NAME', 'Náv¹tìvní kniha - postranní blok');
@define('PLUGIN_GUESTSIDE_BLAHBLAH', 'Zobrazuje nejnovìj¹í vzkazy z náv¹tìvní knihy v bloku v postranním sloupci');
@define('PLUGIN_GUESTSIDE_TITLE', 'Nadpis bloku');
@define('PLUGIN_GUESTSIDE_TITLE_BLAHBLAH', 'Zadejte nadpis bloku se vzkazy');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL', 'Zobrazovat email');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL_BLAHBLAH', 'Mají se zobrazovat emailové adresy pøispìvatelù?');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE', 'Zobrazovat domovské stránky');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE_BLAHBLAH', 'Mají se zobrazovat domovské (www) stránky pøispìvatele?');
@define('PLUGIN_GUESTSIDE_MAXCHARS', 'Maximálnì znakù');
@define('PLUGIN_GUESTSIDE_MAXCHARS_BLAHBLAH', 'Nejvìt¹í povolená délka (poèet znakù) pøíspìveku');
@define('PLUGIN_GUESTSIDE_MAXITEMS', 'Maximálnì vzkazù');
@define('PLUGIN_GUESTSIDE_MAXITEMS_BLAHBLAH', 'Zadejte poèet vzkazù, který se má zobrazovat v bloku v postranním sloupci');
@define('PLUGIN_GUESTSIDE_NOENTRIES', 'Je¹tì nikdo nezanechal vzkaz v náv¹tìvní knize.');

// Next lines were translated on 2011/04/17

@define('PLUGIN_GUESTBOOK_DBDONE_APP', '(Jakmile bude pøíspìvek odsouhlasen, objeví se v náv¹tìvní knize.)');
@define('ERROR_DATANOTAGS', 'Pøíspìvek není platný. Nejsou povoleny html tagy nebo bbcode.');
@define('PLUGIN_GUESTBOOK_SHOWAPP', 'Schvalovat pøíspìvky?');
@define('PLUGIN_GUESTBOOK_SHOWAPP_BLAHBLAH', 'Pøíspìvky do náv¹tìvní knihy budou pøedkládany administrátorovi ke schválení pøedtím, ne¾ se zobrazí na stránce (výchozí: ne).');
@define('PLUGIN_GUESTBOOK_APP_ENTRY', 'Vá¹ pøíspìvek %s byl ulo¾en');
@define('PLUGIN_GUESTBOOK_CHECKBOXALERT', 'Za¹krtnìte políèko u pøíspìvku, který chcete schválit, zmìnit nebo vymazat.');
@define('PLUGIN_GUESTBOOK_ADMINBODY', 'Odpovìï admina');
@define('PLUGIN_GUESTBOOK_FORM_RIGHT_BBC', 'Pou¾ívejte BBcode (strong, italic, underline, strike, quotes).');
@define('PLUGIN_GUESTBOOK_AUTOMODERATE', 'Pou¾ít automatické schvalování?');
@define('PLUGIN_GUESTBOOK_AUTOMODERATE_BLAHBLAH', 'Nastavuje pøíspìvky náv¹tìvní knihy, aby byly administrátorem schvalovány pøe zobrazením. Pokud plugin SPAMBLOCK nejdøíve nastaví pøíspìvek ke schválení, hledání stop-slov v¾dy skonèí s pozitivním výsledkem (výchozí: ne).');
@define('PLUGIN_GUESTBOOK_AUTOMODERATE_ERROR', 'Vá¹ pøíspìvek byl oznaèen ke schválení administrátorem.');
@define('PLUGIN_GUESTBOOK_CONFIG_ERROR', 'Výstraha nevhodného nastavení konfiguraèního souboru! Volba náv¹tìvní knihy: "Automatické schvalování" je nastaveno na výchozí hodnotu "ne", kdy¾ je "schvalování pøíspìvkù" aktivní! Lze pou¾ít pouze jednu ze zmínìných voleb, ne souèasnì.');
@define('PLUGIN_GUESTBOOK_FILTER_ENTRYCHECKS', 'Speciální kontrola tìla pøíspìvku');
@define('PLUGIN_GUESTBOOK_FILTER_ENTRYCHECKS_BLAHBLAH', 'Vyjmenujte speciální kontroly tìla pøíspìvkù. Povoleny jsou reguálrní výrazy oddìlené støedníkem (;). Speciální znaky musíte escapovat pomocí "\". Pokud ponecháte toto pole prázdné, nebudou provádìny ¾ádné speciální kontroly!');
@define('PLUGIN_GUESTBOOK_ADMIN_NAME', 'Náv¹tìvní kniha');
@define('PLUGIN_GUESTBOOK_ADMIN_NAME_MENU', 'Náv¹tìvní kniha verze %s - Administraèní menu');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC', 'Náv¹tìvní kniha - administrace databázových tabulek pluginu');
@define('PLUGIN_GUESTBOOK_ADMIN_VIEW', 'Náv¹tìvní kniha - zobrazit pøíspìvky');
@define('PLUGIN_GUESTBOOK_ADMIN_VIEW_NORESULT', 'V náv¹tìvní knize nejsou ¾ádné schválené pøíspìvky!');
@define('PLUGIN_GUESTBOOK_ADMIN_VIEW_DESC', 'Seskupovat podle data [nejnovìj¹í nahoøe].');
@define('PLUGIN_GUESTBOOK_ADMIN_APP', 'Náv¹tìvní kniha - schvalování pøíspìvkù');
@define('PLUGIN_GUESTBOOK_ADMIN_APP_DESC', 'Seskupovat podle data [nejnovìj¹í nahoøe].');
@define('PLUGIN_GUESTBOOK_ADMIN_APP_NORESULT', '®ádné nové pøíspìvky ke schválení!');
@define('PLUGIN_GUESTBOOK_ADMIN_ERASE', 'Náv¹tìvní kniha - smazat pøíspìvky');
@define('PLUGIN_GUESTBOOK_ADMIN_ADD', 'Náv¹tìvní kniha - pøidat pøíspìvek');
@define('PLUGIN_GUESTBOOK_ADMIN_DROP_SURE', 'Urèitì chcete smazat celou databázovou tabulku náv¹tìvní knihy vèetnì v¹ech pøíspìvkù? Prosím potvrïte!');
@define('PLUGIN_GUESTBOOK_ADMIN_DROP_OK', 'Databázová tabulka %s byla úspì¹nì smazána!');
@define('PLUGIN_GUESTBOOK_ADMIN_DUMP_SELF', 'Pøed pokraèováním byste mìli pro jistotu provést mysql dump (záloha) pomocí PhpMyAdmina nebo pomocí zálohovacího odkazu vý¹e!');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP', 'Administrace databáze - záloha');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_DESC', 'zálohujte databázovou tabulku náv¹tìvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_TITLE', 'záloha hodnot z databázové tabulky');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_DONE', 'Databázová tabulka náv¹tìvní knihy byla úspì¹nì zálohována!');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT', 'Administrace databáza - vlo¾ení');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_DESC', 'vlo¾it do databázové tabulky náv¹tìvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_TITLE', 'vlo¾it hodnoty do databázové tabulky náv¹tìvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_MSG', 'Proto¾e tato operace není triviální, pou¾ijte prosím databázové administraèní nástroje jako napøíklad PhpMyAdmin pro znovu naplnìní databáze!');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE', 'Administrace databáze - vymazání');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE_DESC', 'Odstranit databázovou tabulku náv¹tìvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE_TITLE', 'Mazání databázové tabulky náv¹tìvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DELFILE_MSG', 'Databázová tabulka <u>%s</u> byla úspì¹nì vymazána');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD', 'Administrace databáze - download');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_DESC', 'Stáhnout do souboru zálohu databázové tabulky náv¹tìvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_TITLE', 'Sta¾ení zálohy databázové tabulky');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_MSG', 'Neexistuje ¾ádná záloha databázové tabulky náv¹tìvní knihy!');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_DESC', '®ádná záloha tabulky náv¹tìvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_TITLE', 'Adminsitrace - chyba');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_NOBACKUP', 'Vybraná databázová tabulka nemohla být zálohována!');

// Next lines were translated on 2013/10/26
@define('TEXT_EMAILMODERATE', "\n\nTento pøíspìvek do náv¹tìvní knihy byl nastaven, ¾e vy¾aduje schválení (%s)!");
@define('TEXT_EMAILFOOTER', "\n\nOdesláno Serendipity pluginem Guestbook.");
@define('ERROR_DATASTRIPPED', 'Aktivní bezpeènostní filtr vyhodnotil Vá¹ pøíspìvek jako neplatný. Ode¹lete prosím pøíspìvek znovu.');
@define('PLUGIN_GUESTBOOK_FILTER_ENTRYCHECKS_BYPASS', '(Pøeskoèeno pouze u¾ivatelským oprávnìním USERLEVEL_ADMIN!)');