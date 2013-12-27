/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/11/21
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/11/29
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/02/14
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/03/07
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/03/05
 */

    @define('PLUGIN_EVENTCAL_HEADLINE', 'Nadpis');
    @define('PLUGIN_EVENTCAL_HEADLINE_BLAHBLAH', 'Nadpis stránky');
    @define('PLUGIN_EVENTCAL_TITLE', 'Kalendář akcí');
    @define('PLUGIN_EVENTCAL_TITLE_BLAHBLAH', 'Zobrazuje kalendář akcí jako samostatnou stránku v blogu. Design stránky zůstává stejný jako u zbytku blogu.');
    @define('PLUGIN_EVENTCAL_PERMALINK', 'Stálý odkaz');
    @define('PLUGIN_EVENTCAL_PERMALINK_BLAHBLAH', 'Zadejte stálý odkaz, stálou URL adresu stránky s kalendářem akcí. Musí být absolutní HTTP cesta a musí končit .htm nebo .html!');
    @define('PLUGIN_EVENTCAL_PAGETITLE', 'Název statické stránky & její URL');
    @define('PLUGIN_EVENTCAL_PAGETITLE_BLAHBLAH', 'Název statické stránky. Pozor: název také definuje URL adresu této stránky (index.php?serendipity[subpage]=zde_zadany_nazev)');
    @define('PLUGIN_EVENTCAL_ARTICLEFORMAT', 'Formátovat jako příspěvek?');
    @define('PLUGIN_EVENTCAL_ARTICLEFORMAT_BLAHBLAH', 'Pokud zadáte "ano", stránka bude automaticky zformátována stejně jako běžné příspěvky. (Výchozí: ano)');
    @define('PLUGIN_EVENTCAL_SHOWCAPTCHA', 'Zobrazovat kryptogramy?');
    @define('PLUGIN_EVENTCAL_SHOWCAPTCHA_BLAHBLAH', 'Mají se používat kryptogramy (captchas - vyžaduje nainstalovaný a aktivovaný plugin Spamblock)');
    @define('PLUGIN_EVENTCAL_NEXTPAGE', 'další strana');
    @define('PLUGIN_EVENTCAL_PREVPAGE', 'předchozí strana');
    @define('PLUGIN_EVENTCAL_TEXT_DELETE', 'smazat');
    @define('PLUGIN_EVENTCAL_TEXT_SAY', 'řekl');
    @define('PLUGIN_EVENTCAL_TEXT_EMAIL', 'Email');
    @define('PLUGIN_EVENTCAL_TEXT_NAME', 'Jméno');
    @define('PLUGIN_EVENTCAL_TEXT_EACH', 'Každý');
    @define('PLUGIN_EVENTCAL_TEXT_TO', 'pro');
    @define('PLUGIN_EVENTCAL_TEXT_CW', 'CW-');
    
    @define('PLUGIN_EVENTCAL_HALLO_ADMIN', 'Dobrý den uživateli: %s ( %s )<br />');
    @define('PLUGIN_EVENTCAL_INSERT_DONE_BLAHBLAH', 'Díky za Váš příspěvek číslo ID = %d.');
    @define('PLUGIN_EVENTCAL_INSERT_DONE_EVALUATE', 'Předtím než Váš příspěvek schválí administrátor, naleznete jej v části: "Neschválené akce".');
    @define('PLUGIN_EVENTCAL_REJECT_DONE_BLAHBLAH', 'Úpěšně jste vymazali příspěvek číslo ID = %s z databáze.');
    @define('PLUGIN_EVENTCAL_APPROVE_DONE_BLAHBLAH', 'Příspěvek číslo ID = %d byl úspěšně schválen.');
    
    @define('CAL_EVENT_PLEASECORRECT', 'Opravte prosím.');
    @define('CAL_EVENT_SHORTTITLE', 'Vložte prosím krátký název pro tuto akci!');
    @define('CAL_EVENT_EVENTDESC', 'Zadejte prosím plný popis akce!');
    @define('CAL_EVENT_APPBY', 'Musíte zadat token autora (sig) pro potvrzení akce!');
    @define('CAL_EVENT_START_DATE', 'Nesprávný začátek akce!');
    @define('CAL_EVENT_START_DATE_HISTORY', 'Nesprávné datum akce! Zadávání proběhlých akcí je podporováno pouze na uplynulých 31 dní!');
    @define('CAL_EVENT_END_DATE', 'Nesprávný konec akce!');
    @define('CAL_EVENT_REAL_START_DATE', 'Datum začátku akce musí být platný den daného měsíce (%s)!');
    @define('CAL_EVENT_REAL_END_DATE', 'Datum konce akce musí být platný den daného měsíce (%s) a musí být za datem začátku!');
    @define('CAL_EVENT_REAL_MONTHLY_DATE', 'Hodnota opakování pro měsíční akce nemůže být "Týdně"!');
    @define('CAL_EVENT_IDENTICAL_DATE', 'Akce má stejné datum začátku a konce!');
    @define('CAL_EVENT_ORDER_DATE', 'Zadaná sekvence akce není platná!');
    @define('CAL_EVENT_WEEKLY_DATE', 'Správná hodnota má být: "Týdně" a vybraný "Den v týdnu".');
    
    @define('CAL_EVENT_FORM_DAY_FIRST', 'První');
    @define('CAL_EVENT_FORM_DAY_SECOND', 'Druhý');
    @define('CAL_EVENT_FORM_DAY_THIRD', 'Třetí');
    @define('CAL_EVENT_FORM_DAY_FOURTH', 'Čtvrtý');
    @define('CAL_EVENT_FORM_DAY_LAST', 'Poslední');
    @define('CAL_EVENT_FORM_DAY_SECONDLAST', 'Předposlední');
    @define('CAL_EVENT_FORM_DAY_THIRDLAST', 'Před-předposlední');
    @define('CAL_EVENT_FORM_DAY_EACH', 'Týdně');
    
    @define('CAL_EVENT_FORM_RIGHT_SHORTMAX', 'max. 16 znaků!');
    @define('CAL_EVENT_FORM_RIGHT_URLDESC', 'Buď ');
    @define('CAL_EVENT_FORM_RIGHT_URL', 'http://www.domena.cz');
    @define('CAL_EVENT_FORM_RIGHT_MAIL', 'mailto:vas@email.cz');
    @define('CAL_EVENT_FORM_RIGHT_OR', 'nebo');
    @define('CAL_EVENT_FORM_RIGHT_DETAILDESC', '<b>Nezapoměňte</b>, prosím, zadat do tohoto pole přesný čas akce.');
    @define('CAL_EVENT_FORM_RIGHT_BBC', 'Použít BBcode (tučné, kurzíva, podtržení, přeškrtnutí).');
    @define('CAL_EVENT_FORM_RIGHT_SINGLE', 'Pouze jeden den');
    @define('CAL_EVENT_FORM_RIGHT_SINGLE_NOEND', 'není třeba zadávat datum konce');
    @define('CAL_EVENT_FORM_RIGHT_MULTI', 'Vícedenní akce');
    @define('CAL_EVENT_FORM_RIGHT_RECUR', 'Opakování');
    @define('CAL_EVENT_FORM_RIGHT_RECUR_MONTH', 'každý měsíc');
    @define('CAL_EVENT_FORM_RIGHT_RECUR_WEEK', 'každý týden');

    @define('CAL_EVENT_FORM_BUTTON_ADD_EVENT', 'Vložte akci');
    @define('CAL_EVENT_FORM_BUTTON_APPROVE_EVENT', 'Neschválené akce');
    @define('CAL_EVENT_FORM_BUTTON_CLOSE', 'Zavřít formulář');
    @define('CAL_EVENT_FORM_BUTTON_FREETABLE', 'vyčistit stará data (starší než 1 měsíc) a přeskládat tabulku');
    @define('CAL_EVENT_FORM_BUTTON_LOGOFF', 'odhlásit');
    @define('CAL_EVENT_FORM_BUTTON_MARK', 'označit/odznačit všechny');
    @define('CAL_EVENT_FORM_BUTTON_OPEN', 'Otevřít formulář');
    @define('CAL_EVENT_FORM_BUTTON_REJECT_SED', 'Vymazat příspěvek schválené akce');
    @define('CAL_EVENT_FORM_BUTTON_EDIT_SED', 'Změnit příspěvek schválené akce');
    @define('CAL_EVENT_FORM_BUTTON_SUBMIT', '&raquo; Poslat příspěvek &laquo;');
    @define('CAL_EVENT_FORM_BUTTON_TOAPPROVE', 'akce/akcí');
    
    @define('CAL_EVENT_FORM_TITLE_DATE', 'datum');
    @define('CAL_EVENT_FORM_TITLE_TITLE', 'nadpis');
    @define('CAL_EVENT_FORM_TITLE_DESC', 'popis');
    @define('CAL_EVENT_FORM_TITLE_URL', 'url');
    @define('CAL_EVENT_FORM_TITLE_OK', 'ok');
    @define('CAL_EVENT_FORM_TITLE_EDIT', 'upravit');
    @define('CAL_EVENT_FORM_TITLE_DEL', 'smazat');
    
    @define('CAL_EVENT_FORM_LEFT_AUTHOR', '<u>Autor</u>');
    @define('CAL_EVENT_FORM_LEFT_TITLE', '<u>Krátký</u> nadpis');
    @define('CAL_EVENT_FORM_LEFT_LINK', 'Webová stránka nebo email');
    @define('CAL_EVENT_FORM_LEFT_DESC', '<u>Plný</u> popis');
    @define('CAL_EVENT_FORM_LEFT_SINGLE', '<u>Začátek</u> - datum');
    @define('CAL_EVENT_FORM_LEFT_MULTI', '<u>Konec</u> - datum');
    @define('CAL_EVENT_FORM_LEFT_RECUR', 'Opakování');
    @define('CAL_EVENT_FORM_LEFT_SPAM', 'Bezpečnost');

    @define('CAL_EVENT_DB_ERROR_ONE', 'V databázové tabulce kalendáře akcí (eventcal) se vyskytla chyba:');
    @define('CAL_EVENT_DB_ERROR_TWO', 'Nelze se spojit s databází!');
    @define('CAL_EVENT_USER_LOGINFIRST', 'Pro pokračování procesu se musíte přihlásit pomocí platného účtu na blogu. Pokud ho máte, přihlašte se do administrační sekce blogu.');
    @define('CAL_EVENT_USER_LOGINFIRST', 'Pro pokračování procesu se musíte přihlásit pomocí platného účtu na blogu. Pokud ho máte, přihlašte se do administrační sekce blogu.');
    @define('CAL_EVENT_USER_VALIDATION', 'Uživatelské jméno nebo heslo není správné.');
    @define('CAL_EVENT_USER_LOGGEDOFF', 'Vaše seance vypršela nebo jste se odhlásili. Pro administraci kalendáře akcí se musíte znovu přihlásit do blogu.');
    @define('CAL_EVENT_USER_FREETABLE', 'Data starší než 1 měsíc byla úspěšně smazána a databázová tabulka přeskládána.');
    @define('CAL_EVENT_USER_FREE_SURE', 'Opravdu chcete rekonstruovat databázovou tabulku kalendáře akcí?');
    @define('CAL_EVENT_USER_NOPERMISSION', 'Nemáte dostatečná oprávnění k pokračování!');
    @define('CAL_EVENT_CHGSELECTED_ARRAY', 'Pokud chcete změnit jeden příspěvek, odznačte prosím ostatní.');
    @define('CAL_EVENT_CHECKBOXALERT', 'Zaškrtněte čtvereček u příspěvku, který chcete ohodnotit, změnit nebo smazat.');
    @define('CAL_EVENT_TODAY', 'DNES');

    @define('PLUGIN_EVENTCAL_CAL', ' Vykreslit kalendář ');
    @define('PLUGIN_EVENTCAL_ADD', ' Vykreslit add ');
    @define('PLUGIN_EVENTCAL_APP', ' Vykreslit app ');

// Next lines were translated on 2009/11/29

@define('CAL_EVENT_FALSECAPTCHA', 'Kryptogram u Vašeho příspěvku se neshoduje!');

// Next lines were translated on 2010/02/14

@define('PLUGIN_EVENTCAL_SHOWINTRO', 'Úvodní text (volitelný)');
@define('PLUGIN_EVENTCAL_SHOWINTRO_BLAHBLAH', 'Text, který se zobrazuje před příspěvky. (HTML povoleno)');
@define('PLUGIN_EVENTCAL_SHOWICAL', 'Exportovat iCal kanál?');
@define('PLUGIN_EVENTCAL_SHOWICAL_BLAHBLAH', 'Pokud ano, bude povolen export iCal jako měsíční přehled a nebo jako jednotlivé události pomocí tlačítek.');
@define('PLUGIN_EVENTCAL_ICAL_LOG', 'Přihlášení pro stažení iCal?');
@define('PLUGIN_EVENTCAL_ICAL_LOG_BLAHBLAH', 'Určuje, jestli iCal exporty budou zaznamenány do logu a zda-li se má posílat oznámení administrátorovi. [potřeba zada emailovou adresu]');
@define('PLUGIN_EVENTCAL_ICAL_LOG_EMAIL', 'Administrátorská emailová adresa (v závislosti na nastavení \'přihlášení nastavené na ano\' a/nebo \'iCal URL\')');
@define('PLUGIN_EVENTCAL_ICAL_LOG_EMAIL_BLAHBLAH', 'Vaše emailová adresa, na kterou se budou posílat oznámení o iCa exportech.');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL', 'Export iCal URL adresa?');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_BLAH', 'Nastavte, jak bude exportován vybraný iCal soubor.');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_BLAHBLAH', 'Stažení, uživatelský požadavek webcal-push, email (na administrátorskou adresu, která musí být níže nastavena) nebo všechny tři. V tom případě si uživatel vybere, který se mu hodí nejvíce.');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_NO', 'žádný ics soubor');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_DL', 'ics stažení');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_WEBCAL', 'ics pomocí webcal://');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_MAIL', 'ics přes email');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_USER', 'uživatel rozhodne');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_EXPORT', 'uživateli');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_INTERN', 'administrátorovi');
@define('PLUGIN_EVENTCAL_TEXT_INTERVAL', 'Interval');
@define('PLUGIN_EVENTCAL_TEXT_BIWEEK', 'čtrnáct dní');
@define('PLUGIN_EVENTCAL_TEXT_YEARLY', 'rok');
@define('PLUGIN_EVENTCAL_SENDMAIL_BLAHBLAH', 'iCal soubor byl úpěšně odeslán!');
@define('PLUGIN_EVENTCAL_SENDMAIL_ERROR', 'Při odesílání emailu se vyskytla chyba!');
@define('CAL_EVENT_START_RECUR', 'Počáteční datum &raquo; <u>%s</u> &laquo; první výskyt!');
@define('CAL_EVENT_FORM_RIGHT_RECURSTRICT1', 'Pozor:');
@define('CAL_EVENT_FORM_RIGHT_RECURSTRICT2', 'přísně podle prvního dne u všech opakujících se událostí!');
@define('CAL_EVENT_FORM_RIGHT_RECUR_BIWEEK', 'každý druhý týden');
@define('CAL_EVENT_FORM_RIGHT_RECUR_YEAR', 'každý rok');
@define('CAL_EVENT_FORM_RIGHT_HELP_SINGLE', 'Jednotlivá událost. \'Konečné datum\' ani žádná další informace není potřeba!');
@define('CAL_EVENT_FORM_RIGHT_HELP_MULTI', 'Multi-událost: Zobrazovat měsíčně. Vyžaduje \'Počáteční datum\' a \'Koncové datum\'.');
@define('CAL_EVENT_FORM_RIGHT_HELP_WEEK', 'Týdenní událost. Určitě je potřeba nastavit. \'vždy zapnuto\', \'Týdně\' a a \'Den v týdnu\'. Zobrazuje každý kalendářní týden v měsíci. Vyžaduje \'Počáteční datum\' a \'koncové datum\'.');
@define('CAL_EVENT_FORM_RIGHT_HELP_BIWEEK', 'Čtrnáctidenní událost. Určitě je třeba zadat: \'vždy zapnuto\', \'Týdně\' a \'Den v týdnu\'. Zobrazuje se každý druhý kalendářní týden v měsíci. Vyžaduje \'Počáteční datum\' a \'Koncové datum\'.');
@define('CAL_EVENT_FORM_RIGHT_HELP_MONTH', 'Měsíční událost. Určitě je třeba zadat: \'vždy zapnuto\', \'ntý Den\' a \'Den v týdnu\'. Zobrazuje se každý měsíc. Vyžaduje \'Počáteční datum\' a \'Koncové datum\'.');
@define('CAL_EVENT_FORM_RIGHT_HELP_YEAR', 'Roční událost. Zobrazuje se ročně od \'Počátečního data\'. Nepotřebuje \'Koncové datum\' ani žádné další nastavení!');
@define('CAL_EVENT_FORM_BUTTON_HELP_ICALM', 'Stažení událostí iCal ze v současném měsíci včetně všech opakujících se událostí z minulosti i budoucnosti.');

// Next lines were translated on 2010/03/06

@define('PLUGIN_EVENTCAL_ADMIN_NAME', 'Kalendář událostí');
@define('PLUGIN_EVENTCAL_ADMIN_NAME_MENU', 'Kalendář událostí  ver.%s - Administrátorské menu');
@define('PLUGIN_EVENTCAL_ADMIN_DBC', 'Kalendář událostí - Administrace pluginu');
@define('PLUGIN_EVENTCAL_ADMIN_VIEW', 'Kalendář událostí - Zobrazit schválené události');
@define('PLUGIN_EVENTCAL_ADMIN_VIEW_DESC', 'Seskupeno podle typu - jednotlivá, vícedenní, opakující se, týdenní, roční.');
@define('PLUGIN_EVENTCAL_ADMIN_APP', 'Kalendář událostí - Zobrazit neschválené události');
@define('PLUGIN_EVENTCAL_ADMIN_APP_DESC', 'Seskupit podle Počátečního data [nejnovější nahoře].');
@define('PLUGIN_EVENTCAL_ADMIN_ERASE', 'Kalendář událostí - Vymazat události');
@define('PLUGIN_EVENTCAL_ADMIN_LOG', 'Kalendář událostí - iCal Log');
@define('PLUGIN_EVENTCAL_ADMIN_LOG_ERROR', 'POZOR: Při zapisování iCal logovacího souboru se vyskytla chyba. Zkontrolujte, co je špatně (má adresář a soubor nastavená práva pro zápis?)!');
@define('PLUGIN_EVENTCAL_ADMIN_ADD', 'Kalendář událostí - Vložení nové události');
@define('PLUGIN_EVENTCAL_ADMIN_NORESULT', 'Žádné události nečekají na %s!');
@define('PLUGIN_EVENTCAL_ADMIN_NORESULT_APP', 'schválení');
@define('PLUGIN_EVENTCAL_ADMIN_NORESULT_DROP', 'vymazání');
@define('PLUGIN_EVENTCAL_ADMIN_NORESULT_FREE', 'vyčištění');
@define('PLUGIN_EVENTCAL_ADMIN_FREE_SURE', 'Určitě chcete odstranit staré události z databázové tabulky událostí?');
@define('PLUGIN_EVENTCAL_ADMIN_CLEAN_SURE', 'Určitě chcete nastavit novou hodnotu autoincrementu (id) pro všechna data v databázové tabulce kalendáře událostí?');
@define('PLUGIN_EVENTCAL_ADMIN_CLEAN_SURE_ADD', '<u>Upozornění:</u> Může to mít negativní dopady na cachovaná data ve vyhledávačích a podobných službách mimo Váš blog!');
@define('PLUGIN_EVENTCAL_ADMIN_DROP_SURE', 'Určitě chcete smazat celou tabulku kalendáře událostí včetně všch dat? Potvrďte prosím zde!');
@define('PLUGIN_EVENTCAL_ADMIN_DROP_OK', 'Vaše %s databázová tabulka byla úspašně vymazána!');
@define('PLUGIN_EVENTCAL_ADMIN_DUMP_SELF', 'Před pokračováním byste měli pro jistotu udělat mysql dump pomocí PhpMyAdmina!');
@define('PLUGIN_EVENTCAL_ADMIN_ICAL_EMAILLINK', 'Stáhněte všechny schválené události jako ics soubor pomocí emailu na administrátorskou adresu, pokud je nastavená v konfiguraci tohoto pluginu! Ujistěte se, že je zadaná!');
@define('PLUGIN_EVENTCAL_ADMIN_ICAL_DOWNLINK', 'Stáhnout všechny schválené události jako ics soubor!');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_TITLE', 'Používejte prosím tento administrační panel opatrně.');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_TITLE_DESC', 'Některé odkazy mohou být v příštích verzích vylepšeny!');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DUMP', 'Administrace - dump');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DUMP_DESC', 'zálohujte tabulky kalendáře akcí z databáze');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DUMP_TITLE', 'zálohujte (dump výpis) data z databáze kalendáře akcí');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DUMP_MSG', 'Protože to není jednoduchá akce, použijte prosím administrátorské nástroje jako PhpMyAdmin k dumpu dat!');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INSERT', 'Administrace - vložení');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INSERT_DESC', 'vložení dat do databázové tabulky kalendáře akcí');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INSERT_TITLE', 'vložení hodnot do databáze kalendáře akcí');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INSERT_MSG', 'Protože to není jednoduchá operace, použijte prosím administrační nástroje jako PhpMyAdmin pro znovu naplnění databáze!');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ERASE', 'Administrace - vymazání');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ERASE_DESC', 'odstranit tabulky kalendáře akcí z databáze');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ERASE_TITLE', 'vymazat databázi kalendáře akcí');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DELOLD', 'Administrace - čištění');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DELOLD_DESC', 'odstranit události starší než 1 měsíc z databázové tabulky kalendáře akcí');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DELOLD_TITLE', 'smazat data starší než 1 měsíc z databázové tabulky');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DELOLD_MSG', 'Z databázové tabulky jste odstranili %d starých událostí starších než 30 dní.');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INCREMENT', 'Administrace - increment');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INCREMENT_DESC', 'Nastavte nové autoincrement id identifikátory v databázové tabulce kalendáře akcí');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INCREMENT_TITLE', 'nastavit nové autoincrement id v databázové tabulce');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INCREMENT_MSG', 'Restrukturalizovali jste databázovou tabulku s %d zbývajícími hodnotami.');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ICALALL', 'Administrace - iCal');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ICALALL_DESC', 'pošlete všechny události jako iCal soubor administrátorovi - pomocí emailu, pokud je zadán v nastavení, jinak pomocí downloadu');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ICALALL_TITLE', 'poslat iCal pomocí emailu, nebo stáhnout');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ILOG', 'Administrace - iLog');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ILOG_DESC', 'zobrazit iLog souboru exportu pomocí iCal, pokud je');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ILOG_TITLE', 'zobrazit logovací soubor iCal exportu');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ILOG_MSG', 'Soubor iLog neexistuje!');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_NIXDA_DESC', 'v databázi není žádná tabulka kalendáře akcí');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_NIXDA_TITLE', 'Administrace - chyba');

// Next lines were translated on 2011/03/05
@define('PLUGIN_EVENTCAL_ADMIN_ORDERBY_DESC', 'Seskupeno podle typu akce (časové značky) sestupně.');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DUMP_DONE', 'Databáze kalendáře akcí byla úspěšně zálohována!');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DELFILE_MSG', 'Soubor zálohy databázové tabulky <u>%s</u> úspěšně vymazán');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DOWNLOAD', 'Administrace - management');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DOWNLOAD_DESC', 'Stažení a vymazání záloh databázové tabulky kalendáře akcí');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DOWNLOAD_MSG', 'V adresáři "templates_c" není žádný adresář "eventcal".');