<?php # lang_cz.inc.php 1.1 2011-04-17 14:21:59 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/20
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/04/17
 */
@define('PLUGIN_GUESTBOOK_HEADLINE',		'Hlavní nadpis');
@define('PLUGIN_GUESTBOOK_HEADLINE_BLAHBLAH',		'Hlavní nadpis stránky s návštěvní knihou.');
@define('PLUGIN_GUESTBOOK_TITLE',		'Návštěvní kniha');
@define('PLUGIN_GUESTBOOK_TITLE_BLAHBLAH',		'Zobrazuje návštěvní knihu jako stránku blogu. Vzhled je totožný s ostatními stránkami.');
@define('PLUGIN_GUESTBOOK_PERMALINK',		'Stálý odkaz');
@define('PLUGIN_GUESTBOOK_PERMALINK_BLAHBLAH',		'Definuje stálý URL odkaz. (Návštěvní knihu pak můžete odkazovat pomocí tohoto odkazu a ne pomocí nepřehledného vnitřního odkazu, který používá Serendipity.) Je třeba zadat absolutní HTTP cestu, včetně ukončovacího .htm nebo .html!');
@define('PLUGIN_GUESTBOOK_PAGETITLE',		'Nadpis statické stránky a URL');
@define('PLUGIN_GUESTBOOK_PAGETITLE_BLAHBLAH',		'Nadpis stránky pro modul "Statické stránky". Pozor: tento nadpis také definuje URL adresu statické stránky (index.php?serendipity[subpage]=jmeno)');
@define('PLUGIN_GUESTBOOK_FORMORDER',		'Formulář návštěvní knihy');
@define('PLUGIN_GUESTBOOK_FORMORDER_BLAHBLAH',		'Kde má být umístěn formulář pro poslání vzkazu.');
@define('PLUGIN_GUESTBOOK_FORMORDER_TOP',		'Nahoře');
@define('PLUGIN_GUESTBOOK_FORMORDER_BOTTOM',		'Dole');
@define('PLUGIN_GUESTBOOK_FORMORDER_POPUP',		'Vyskakovací okno');

@define('PLUGIN_GUESTBOOK_EMAILADMIN',		'Poslat mail administrátorovi?');
@define('PLUGIN_GUESTBOOK_EMAILADMIN_BLAHBLAH',		'Pokud nastaveno na "Ano", pak bude administrátor mailem upozorněn na každý nový příspěvek.');
@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN',		'Email administrátora');
@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN_BLAHBLAH',		'Zadejte prosím platnou emailovou adresu, na kterou mají být posílána oznámení o nových vzkazech.');
@define('PLUGIN_GUESTBOOK_SHOWEMAIL',		'Požadovat email uživatelů?');
@define('PLUGIN_GUESTBOOK_SHOWEMAIL_BLAHBLAH',		'Má se zobrazovat pole, které žádá po uživateli zadání emailové adresy?');
@define('PLUGIN_GUESTBOOK_SHOWURL',		'Požadovat domovskou stránku?');
@define('PLUGIN_GUESTBOOK_SHOWURL_BLAHBLAH',		'Má se zobrazovat pole, které žádá po uživateli zadání domovské (www) stránky?');
@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA',		'Zobrazovat kryptogramy?');
@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA_BLAHBLAH',		'Mají se při zadávání vzkazů používat KRYPTOGRAMY? (vyžaduje aktivní modul Spamblock)');
@define('PLUGIN_GUESTBOOK_NUMBER',		'Počet vzkazů na stránku');
@define('PLUGIN_GUESTBOOK_NUMBER_BLAHBLAH',		'Kolik vzkazů se má zobrazovat na jedné stránce?');
@define('PLUGIN_GUESTBOOK_WORDWRAP',		'Znaků na řádku (pro zalamování)');
@define('PLUGIN_GUESTBOOK_WORDWRAP_BLAHBLAH',		'Po kolika znacích má být vložen znak nové řádky?');
@define('PLUGIN_GUESTBOOK_ERROR_DATA',		'Jméno, email ani vlastní text vzkazu nesmí být prázdné.');

@define('PLUGIN_GUESTBOOK_EMAIL',		'Emailová adresa');
@define('PLUGIN_GUESTBOOK_INTRO',		'Úvodní text (nepovinný)');
@define('PLUGIN_GUESTBOOK_MESSAGE',		'Vzkaz');
@define('PLUGIN_GUESTBOOK_SENT',		'Text který se má zobrazit po odeslání vzkazu');
@define('PLUGIN_GUESTBOOK_SENT_HTML',		'Váš vzkaz byl úspěšně odeslán!');
@define('PLUGIN_GUESTBOOK_ERROR_HTML',		'Při odesílání vzkazu se objevila chyba!');
@define('PLUGIN_GUESTBOOK_ERROR_DATA',		'Jméno, email ani vlastní text vzkazu nesmí být prázdné.');
@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT',		'Formátovat jako článek?');
@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT_BLAHBLAH',		'Pokud je zapnuto, výstup je automaticky formátován jako běžný článek/příspěvek (co se týče barev, okrajů, atd.) (výchozí: ano)');
@define('PLUGIN_GUESTBOOK_CAPTCHAWARNING',		'Pozor, kryptogramy jsou používány!!!');
@define('PLUGIN_GUESTBOOK_PROTECTION',		'Emailová adresa bude přeměněna do formátu: "uživatel at email dot com"');
@define('PLUGIN_GUESTBOOK_DBDONE',		'Vzkaz do návštěvní knihy byl uložen!');
@define('PLUGIN_GUESTBOOK_USER_LOGGEDOFF',		'Uživatel se odhlásil.');
@define('PLUGIN_GUESTBOOK_USERSDATE_OF_ENTRY',		'napsal');
@define('PLUGIN_GUESTBOOK_UNKNOWN_ERROR',		'Neošetřená chyba! Kontaktujte prosím administrátora stránek.');
@define('PLUGIN_GUESTBOOK_TIMESTAMP_THE',		' ');
@define('PLUGIN_GUESTBOOK_ALTER_OLDTABLE_DONE',		'Databázová tabulka úspěšně aktualizována (ALTER).');
@define('PLUGIN_GUESTBOOK_INSTALL_NEWTABLE_DONE',		'Databázová tabulka úspěšně vytvořena.');
@define('PLUGIN_GUESTBOOK_SUBMITFORM',		'Vložte nový vzkaz do návštěvní knihy');

@define('BODY',		'Vzkaz');
@define('SUBMIT',		'Odeslat vzkaz');
@define('REFRESH',		'Obnovte prosím stránku, pak uvidíte Váš vzkaz.');

@define('GUESTBOOK_NEXTPAGE',		'další stránka');
@define('GUESTBOOK_PREVPAGE',		'předchozí stránka');

@define('TEXT_DELETE',		'smazat');
@define('TEXT_SAY',		'řekl');
@define('TEXT_EMAIL',		'Email');
@define('TEXT_NAME',		'Jméno');
@define('TEXT_HOMEPAGE',		'WWW stránka');
@define('TEXT_EMAILSUBJECT',		'Nový vzkaz do návštěvní knihy');
@define('TEXT_EMAILTEXT',		"%s právě napsal do Tvé návštěvní knihy:\n%s");
@define('TEXT_CONVERTBOLDUNDERLINE',		'Text mezi hvězdičkami bude tučný (*slovo*), mezi podtržítky podtržený (_slovo_).');
@define('TEXT_CONVERTSMILIES',		'Běžní smajlíci jako :-) a ;-) budou nahrazeni obrázky.');
@define('TEXT_IMG_DELETEENTRY',		'Smazat vzkaz');
@define('TEXT_IMG_LASTMODIFIED',		'naposledy změněno');
@define('TEXT_USERS_HOMEPAGE',		'Domovská stránka');
@define('ERROR_NAMEEMPTY',		'Zadejte prosím své jméno.');
@define('ERROR_TEXTEMPTY',		'Zadejte prosím text vzkazu.');
@define('ERROR_EMAILEMPTY',		'Zadejte prosím platnou emailovou adresu.');
@define('ERROR_DATATOSHORT',		'Váš vzkaz musí mít alespoň 3, v poli pro komentář pak 10 znaků.');
@define('ERROR_NOVALIDEMAIL',		'Vaše emailová adresa vypadá neplatně: ');
@define('ERROR_NOINPUT',		'Zadejte prosím jméno, emailovou adresu a vzkaz');
@define('ERROR_ISFALSECAPTCHA',		'Nesprávně zadaný KRYPTOGRAM!');
@define('ERROR_NOCAPTCHASET',		'Nastavení KRYPTOGRAMŮ nejspíš není správné!');
@define('ERROR_UNKNOWN',		'Vyskytla se neošetřená chyba. Zkuste akci znovu, nebo kontaktujte administrátora stránky. Díky za pochopení.');
@define('ERROR_OCCURRED',		'Vyskytly se chyby:');

@define('THANKS_FOR_ENTRY',		'Poděkování za vzkaz:');
@define('WINDOW_CLOSE',		'Zavřít okno');
@define('QUESTION_DELETE',		'Opravdu si přejete smazat vzkaz od %s?');

@define('PAGINATOR_TO',		'Do');
@define('PAGINATOR_FIRST',		'První');
@define('PAGINATOR_PREVIOUS',		'Předchozí');
@define('PAGINATOR_NEXT',		'Následující');
@define('PAGINATOR_LAST',		'Poslední');
@define('PAGINATOR_PAGE',		'Stránka.');
@define('PAGINATOR_RANGE',		' do ');
@define('PAGINATOR_OFFSET',		', celkem ');
@define('PAGINATOR_ENTRIES',		' vzkazů. ');

//
//  serendipity_plugin_guestbook.php
//
@define('PLUGIN_GUESTSIDE_NAME',		'Návštěvní kniha - postranní blok');
@define('PLUGIN_GUESTSIDE_BLAHBLAH',		'Zobrazuje nejnovější vzkazy z návštěvní knihy v bloku v postranním sloupci');
@define('PLUGIN_GUESTSIDE_TITLE',		'Nadpis bloku');
@define('PLUGIN_GUESTSIDE_TITLE_BLAHBLAH',		'Zadejte nadpis bloku se vzkazy');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL',		'Zobrazovat email');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL_BLAHBLAH',		'Mají se zobrazovat emailové adresy přispěvatelů?');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE',		'Zobrazovat domovské stránky');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE_BLAHBLAH',		'Mají se zobrazovat domovské (www) stránky přispěvatele?');
@define('PLUGIN_GUESTSIDE_MAXCHARS',		'Maximálně znaků');
@define('PLUGIN_GUESTSIDE_MAXCHARS_BLAHBLAH',		'Největší povolená délka (počet znaků) příspěveku');
@define('PLUGIN_GUESTSIDE_MAXITEMS',		'Maximálně vzkazů');
@define('PLUGIN_GUESTSIDE_MAXITEMS_BLAHBLAH',		'Zadejte počet vzkazů, který se má zobrazovat v bloku v postranním sloupci');
@define('PLUGIN_GUESTSIDE_NOENTRIES',		'Ještě nikdo nezanechal vzkaz v návštěvní knize.');

// Next lines were translated on 2011/04/17
@define('PLUGIN_GUESTBOOK_DBDONE_APP',		'(Jakmile bude příspěvek odsouhlasen, objeví se v návštěvní knize.)');
@define('ERROR_DATANOTAGS',		'Příspěvek není platný. Nejsou povoleny html tagy nebo bbcode.');
@define('PLUGIN_GUESTBOOK_SHOWAPP',		'Schvalovat příspěvky?');
@define('PLUGIN_GUESTBOOK_SHOWAPP_BLAHBLAH',		'Příspěvky do návštěvní knihy budou předkládany administrátorovi ke schválení předtím, než se zobrazí na stránce (výchozí: ne).');
@define('PLUGIN_GUESTBOOK_APP_ENTRY',		'Váš příspěvek %s byl uložen');
@define('PLUGIN_GUESTBOOK_CHECKBOXALERT',		'Zaškrtněte políčko u příspěvku, který chcete schválit, změnit nebo vymazat.');
@define('PLUGIN_GUESTBOOK_ADMINBODY',		'Odpověď admina');
@define('PLUGIN_GUESTBOOK_FORM_RIGHT_BBC',		'Používejte BBcode (strong, italic, underline, strike, quotes).');
@define('PLUGIN_GUESTBOOK_AUTOMODERATE',		'Použít automatické schvalování?');
@define('PLUGIN_GUESTBOOK_AUTOMODERATE_BLAHBLAH',		'Nastavuje příspěvky návštěvní knihy, aby byly administrátorem schvalovány pře zobrazením. Pokud plugin SPAMBLOCK nejdříve nastaví příspěvek ke schválení, hledání stop-slov vždy skončí s pozitivním výsledkem (výchozí: ne).');
@define('PLUGIN_GUESTBOOK_AUTOMODERATE_ERROR',		'Váš příspěvek byl označen ke schválení administrátorem.');
@define('PLUGIN_GUESTBOOK_CONFIG_ERROR',		'Výstraha nevhodného nastavení konfiguračního souboru! Volba návštěvní knihy: "Automatické schvalování" je nastaveno na výchozí hodnotu "ne", když je "schvalování příspěvků" aktivní! Lze použít pouze jednu ze zmíněných voleb, ne současně.');
@define('PLUGIN_GUESTBOOK_FILTER_ENTRYCHECKS',		'Speciální kontrola těla příspěvku');
@define('PLUGIN_GUESTBOOK_FILTER_ENTRYCHECKS_BLAHBLAH',		'Vyjmenujte speciální kontroly těla příspěvků. Povoleny jsou reguálrní výrazy oddělené středníkem (;). Speciální znaky musíte escapovat pomocí "\". Pokud ponecháte toto pole prázdné, nebudou prováděny žádné speciální kontroly!');
@define('PLUGIN_GUESTBOOK_ADMIN_NAME',		'Návštěvní kniha');
@define('PLUGIN_GUESTBOOK_ADMIN_NAME_MENU',		'Návštěvní kniha verze %s - Administrační menu');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC',		'Návštěvní kniha - administrace databázových tabulek pluginu');
@define('PLUGIN_GUESTBOOK_ADMIN_VIEW',		'Návštěvní kniha - zobrazit příspěvky');
@define('PLUGIN_GUESTBOOK_ADMIN_VIEW_NORESULT',		'V návštěvní knize nejsou žádné schválené příspěvky!');
@define('PLUGIN_GUESTBOOK_ADMIN_VIEW_DESC',		'Seskupovat podle data [nejnovější nahoře].');
@define('PLUGIN_GUESTBOOK_ADMIN_APP',		'Návštěvní kniha - schvalování příspěvků');
@define('PLUGIN_GUESTBOOK_ADMIN_APP_DESC',		'Seskupovat podle data [nejnovější nahoře].');
@define('PLUGIN_GUESTBOOK_ADMIN_APP_NORESULT',		'Žádné nové příspěvky ke schválení!');
@define('PLUGIN_GUESTBOOK_ADMIN_ERASE',		'Návštěvní kniha - smazat příspěvky');
@define('PLUGIN_GUESTBOOK_ADMIN_ADD',		'Návštěvní kniha - přidat příspěvek');
@define('PLUGIN_GUESTBOOK_ADMIN_DROP_SURE',		'Určitě chcete smazat celou databázovou tabulku návštěvní knihy včetně všech příspěvků? Prosím potvrďte!');
@define('PLUGIN_GUESTBOOK_ADMIN_DROP_OK',		'Databázová tabulka %s byla úspěšně smazána!');
@define('PLUGIN_GUESTBOOK_ADMIN_DUMP_SELF',		'Před pokračováním byste měli pro jistotu provést mysql dump (záloha) pomocí PhpMyAdmina nebo pomocí zálohovacího odkazu výše!');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP',		'Administrace databáze - záloha');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_DESC',		'zálohujte databázovou tabulku návštěvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_TITLE',		'záloha hodnot z databázové tabulky');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_DONE',		'Databázová tabulka návštěvní knihy byla úspěšně zálohována!');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT',		'Administrace databáza - vložení');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_DESC',		'vložit do databázové tabulky návštěvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_TITLE',		'vložit hodnoty do databázové tabulky návštěvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_MSG',		'Protože tato operace není triviální, použijte prosím databázové administrační nástroje jako například PhpMyAdmin pro znovu naplnění databáze!');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE',		'Administrace databáze - vymazání');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE_DESC',		'Odstranit databázovou tabulku návštěvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE_TITLE',		'Mazání databázové tabulky návštěvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DELFILE_MSG',		'Databázová tabulka <u>%s</u> byla úspěšně vymazána');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD',		'Administrace databáze - download');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_DESC',		'Stáhnout do souboru zálohu databázové tabulky návštěvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_TITLE',		'Stažení zálohy databázové tabulky');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_MSG',		'Neexistuje žádná záloha databázové tabulky návštěvní knihy!');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_DESC',		'Žádná záloha tabulky návštěvní knihy');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_TITLE',		'Adminsitrace - chyba');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_NOBACKUP',		'Vybraná databázová tabulka nemohla být zálohována!');