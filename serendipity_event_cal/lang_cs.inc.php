<?php # lang_cs.inc.php 1.4 2011-03-05 13:09:01 VladaAjgl $

/**
 *  @version 1.4
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
    @define('PLUGIN_EVENTCAL_TITLE', 'Kalendáø akcí');
    @define('PLUGIN_EVENTCAL_TITLE_BLAHBLAH', 'Zobrazuje kalendáø akcí jako samostatnou stránku v blogu. Design stránky zùstává stejný jako u zbytku blogu.');
    @define('PLUGIN_EVENTCAL_PERMALINK', 'Stálý odkaz');
    @define('PLUGIN_EVENTCAL_PERMALINK_BLAHBLAH', 'Zadejte stálý odkaz, stálou URL adresu stránky s kalendáøem akcí. Musí být absolutní HTTP cesta a musí konèit .htm nebo .html!');
    @define('PLUGIN_EVENTCAL_PAGETITLE', 'Název statické stránky & její URL');
    @define('PLUGIN_EVENTCAL_PAGETITLE_BLAHBLAH', 'Název statické stránky. Pozor: název také definuje URL adresu této stránky (index.php?serendipity[subpage]=zde_zadany_nazev)');
    @define('PLUGIN_EVENTCAL_ARTICLEFORMAT', 'Formátovat jako pøíspìvek?');
    @define('PLUGIN_EVENTCAL_ARTICLEFORMAT_BLAHBLAH', 'Pokud zadáte "ano", stránka bude automaticky zformátována stejnì jako bìžné pøíspìvky. (Výchozí: ano)');
    @define('PLUGIN_EVENTCAL_SHOWCAPTCHA', 'Zobrazovat kryptogramy?');
    @define('PLUGIN_EVENTCAL_SHOWCAPTCHA_BLAHBLAH', 'Mají se používat kryptogramy (captchas - vyžaduje nainstalovaný a aktivovaný plugin Spamblock)');
    @define('PLUGIN_EVENTCAL_NEXTPAGE', 'další strana');
    @define('PLUGIN_EVENTCAL_PREVPAGE', 'pøedchozí strana');
    @define('PLUGIN_EVENTCAL_TEXT_DELETE', 'smazat');
    @define('PLUGIN_EVENTCAL_TEXT_SAY', 'øekl');
    @define('PLUGIN_EVENTCAL_TEXT_EMAIL', 'Email');
    @define('PLUGIN_EVENTCAL_TEXT_NAME', 'Jméno');
    @define('PLUGIN_EVENTCAL_TEXT_EACH', 'Každý');
    @define('PLUGIN_EVENTCAL_TEXT_TO', 'pro');
    @define('PLUGIN_EVENTCAL_TEXT_CW', 'CW-');
    
    @define('PLUGIN_EVENTCAL_HALLO_ADMIN', 'Dobrý den uživateli: %s ( %s )<br />');
    @define('PLUGIN_EVENTCAL_INSERT_DONE_BLAHBLAH', 'Díky za Váš pøíspìvek èíslo ID = %d.');
    @define('PLUGIN_EVENTCAL_INSERT_DONE_EVALUATE', 'Pøedtím než Váš pøíspìvek schválí administrátor, naleznete jej v èásti: "Neschválené akce".');
    @define('PLUGIN_EVENTCAL_REJECT_DONE_BLAHBLAH', 'Úpìšnì jste vymazali pøíspìvek èíslo ID = %s z databáze.');
    @define('PLUGIN_EVENTCAL_APPROVE_DONE_BLAHBLAH', 'Pøíspìvek èíslo ID = %d byl úspìšnì schválen.');
    
    @define('CAL_EVENT_PLEASECORRECT', 'Opravte prosím.');
    @define('CAL_EVENT_SHORTTITLE', 'Vložte prosím krátký název pro tuto akci!');
    @define('CAL_EVENT_EVENTDESC', 'Zadejte prosím plný popis akce!');
    @define('CAL_EVENT_APPBY', 'Musíte zadat token autora (sig) pro potvrzení akce!');
    @define('CAL_EVENT_START_DATE', 'Nesprávný zaèátek akce!');
    @define('CAL_EVENT_START_DATE_HISTORY', 'Nesprávné datum akce! Zadávání probìhlých akcí je podporováno pouze na uplynulých 31 dní!');
    @define('CAL_EVENT_END_DATE', 'Nesprávný konec akce!');
    @define('CAL_EVENT_REAL_START_DATE', 'Datum zaèátku akce musí být platný den daného mìsíce (%s)!');
    @define('CAL_EVENT_REAL_END_DATE', 'Datum konce akce musí být platný den daného mìsíce (%s) a musí být za datem zaèátku!');
    @define('CAL_EVENT_REAL_MONTHLY_DATE', 'Hodnota opakování pro mìsíèní akce nemùže být "Týdnì"!');
    @define('CAL_EVENT_IDENTICAL_DATE', 'Akce má stejné datum zaèátku a konce!');
    @define('CAL_EVENT_ORDER_DATE', 'Zadaná sekvence akce není platná!');
    @define('CAL_EVENT_WEEKLY_DATE', 'Správná hodnota má být: "Týdnì" a vybraný "Den v týdnu".');
    
    @define('CAL_EVENT_FORM_DAY_FIRST', 'První');
    @define('CAL_EVENT_FORM_DAY_SECOND', 'Druhý');
    @define('CAL_EVENT_FORM_DAY_THIRD', 'Tøetí');
    @define('CAL_EVENT_FORM_DAY_FOURTH', 'Ètvrtý');
    @define('CAL_EVENT_FORM_DAY_LAST', 'Poslední');
    @define('CAL_EVENT_FORM_DAY_SECONDLAST', 'Pøedposlední');
    @define('CAL_EVENT_FORM_DAY_THIRDLAST', 'Pøed-pøedposlední');
    @define('CAL_EVENT_FORM_DAY_EACH', 'Týdnì');
    
    @define('CAL_EVENT_FORM_RIGHT_SHORTMAX', 'max. 16 znakù!');
    @define('CAL_EVENT_FORM_RIGHT_URLDESC', 'Buï ');
    @define('CAL_EVENT_FORM_RIGHT_URL', 'http://www.domena.cz');
    @define('CAL_EVENT_FORM_RIGHT_MAIL', 'mailto:vas@email.cz');
    @define('CAL_EVENT_FORM_RIGHT_OR', 'nebo');
    @define('CAL_EVENT_FORM_RIGHT_DETAILDESC', '<b>Nezapomìòte</b>, prosím, zadat do tohoto pole pøesný èas akce.');
    @define('CAL_EVENT_FORM_RIGHT_BBC', 'Použít BBcode (tuèné, kurzíva, podtržení, pøeškrtnutí).');
    @define('CAL_EVENT_FORM_RIGHT_SINGLE', 'Pouze jeden den');
    @define('CAL_EVENT_FORM_RIGHT_SINGLE_NOEND', 'není tøeba zadávat datum konce');
    @define('CAL_EVENT_FORM_RIGHT_MULTI', 'Vícedenní akce');
    @define('CAL_EVENT_FORM_RIGHT_RECUR', 'Opakování');
    @define('CAL_EVENT_FORM_RIGHT_RECUR_MONTH', 'každý mìsíc');
    @define('CAL_EVENT_FORM_RIGHT_RECUR_WEEK', 'každý týden');

    @define('CAL_EVENT_FORM_BUTTON_ADD_EVENT', 'Vložte akci');
    @define('CAL_EVENT_FORM_BUTTON_APPROVE_EVENT', 'Neschválené akce');
    @define('CAL_EVENT_FORM_BUTTON_CLOSE', 'Zavøít formuláø');
    @define('CAL_EVENT_FORM_BUTTON_FREETABLE', 'vyèistit stará data (starší než 1 mìsíc) a pøeskládat tabulku');
    @define('CAL_EVENT_FORM_BUTTON_LOGOFF', 'odhlásit');
    @define('CAL_EVENT_FORM_BUTTON_MARK', 'oznaèit/odznaèit všechny');
    @define('CAL_EVENT_FORM_BUTTON_OPEN', 'Otevøít formuláø');
    @define('CAL_EVENT_FORM_BUTTON_REJECT_SED', 'Vymazat pøíspìvek schválené akce');
    @define('CAL_EVENT_FORM_BUTTON_EDIT_SED', 'Zmìnit pøíspìvek schválené akce');
    @define('CAL_EVENT_FORM_BUTTON_SUBMIT', '&raquo; Poslat pøíspìvek &laquo;');
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
    @define('CAL_EVENT_FORM_LEFT_SINGLE', '<u>Zaèátek</u> - datum');
    @define('CAL_EVENT_FORM_LEFT_MULTI', '<u>Konec</u> - datum');
    @define('CAL_EVENT_FORM_LEFT_RECUR', 'Opakování');
    @define('CAL_EVENT_FORM_LEFT_SPAM', 'Bezpeènost');

    @define('CAL_EVENT_DB_ERROR_ONE', 'V databázové tabulce kalendáøe akcí (eventcal) se vyskytla chyba:');
    @define('CAL_EVENT_DB_ERROR_TWO', 'Nelze se spojit s databází!');
    @define('CAL_EVENT_USER_LOGINFIRST', 'Pro pokraèování procesu se musíte pøihlásit pomocí platného úètu na blogu. Pokud ho máte, pøihlašte se do administraèní sekce blogu.');
    @define('CAL_EVENT_USER_LOGINFIRST', 'Pro pokraèování procesu se musíte pøihlásit pomocí platného úètu na blogu. Pokud ho máte, pøihlašte se do administraèní sekce blogu.');
    @define('CAL_EVENT_USER_VALIDATION', 'Uživatelské jméno nebo heslo není správné.');
    @define('CAL_EVENT_USER_LOGGEDOFF', 'Vaše seance vypršela nebo jste se odhlásili. Pro administraci kalendáøe akcí se musíte znovu pøihlásit do blogu.');
    @define('CAL_EVENT_USER_FREETABLE', 'Data starší než 1 mìsíc byla úspìšnì smazána a databázová tabulka pøeskládána.');
    @define('CAL_EVENT_USER_FREE_SURE', 'Opravdu chcete rekonstruovat databázovou tabulku kalendáøe akcí?');
    @define('CAL_EVENT_USER_NOPERMISSION', 'Nemáte dostateèná oprávnìní k pokraèování!');
    @define('CAL_EVENT_CHGSELECTED_ARRAY', 'Pokud chcete zmìnit jeden pøíspìvek, odznaète prosím ostatní.');
    @define('CAL_EVENT_CHECKBOXALERT', 'Zaškrtnìte ètvereèek u pøíspìvku, který chcete ohodnotit, zmìnit nebo smazat.');
    @define('CAL_EVENT_TODAY', 'DNES');

    @define('PLUGIN_EVENTCAL_CAL', ' Vykreslit kalendáø ');
    @define('PLUGIN_EVENTCAL_ADD', ' Vykreslit add ');
    @define('PLUGIN_EVENTCAL_APP', ' Vykreslit app ');

// Next lines were translated on 2009/11/29

@define('CAL_EVENT_FALSECAPTCHA', 'Kryptogram u Vašeho pøíspìvku se neshoduje!');

// Next lines were translated on 2010/02/14

@define('PLUGIN_EVENTCAL_SHOWINTRO', 'Úvodní text (volitelný)');
@define('PLUGIN_EVENTCAL_SHOWINTRO_BLAHBLAH', 'Text, který se zobrazuje pøed pøíspìvky. (HTML povoleno)');
@define('PLUGIN_EVENTCAL_SHOWICAL', 'Exportovat iCal kanál?');
@define('PLUGIN_EVENTCAL_SHOWICAL_BLAHBLAH', 'Pokud ano, bude povolen export iCal jako mìsíèní pøehled a nebo jako jednotlivé události pomocí tlaèítek.');
@define('PLUGIN_EVENTCAL_ICAL_LOG', 'Pøihlášení pro stažení iCal?');
@define('PLUGIN_EVENTCAL_ICAL_LOG_BLAHBLAH', 'Urèuje, jestli iCal exporty budou zaznamenány do logu a zda-li se má posílat oznámení administrátorovi. [potøeba zada emailovou adresu]');
@define('PLUGIN_EVENTCAL_ICAL_LOG_EMAIL', 'Administrátorská emailová adresa (v závislosti na nastavení \'pøihlášení nastavené na ano\' a/nebo \'iCal URL\')');
@define('PLUGIN_EVENTCAL_ICAL_LOG_EMAIL_BLAHBLAH', 'Vaše emailová adresa, na kterou se budou posílat oznámení o iCa exportech.');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL', 'Export iCal URL adresa?');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_BLAH', 'Nastavte, jak bude exportován vybraný iCal soubor.');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_BLAHBLAH', 'Stažení, uživatelský požadavek webcal-push, email (na administrátorskou adresu, která musí být níže nastavena) nebo všechny tøi. V tom pøípadì si uživatel vybere, který se mu hodí nejvíce.');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_NO', 'žádný ics soubor');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_DL', 'ics stažení');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_WEBCAL', 'ics pomocí webcal://');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_MAIL', 'ics pøes email');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_USER', 'uživatel rozhodne');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_EXPORT', 'uživateli');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_INTERN', 'administrátorovi');
@define('PLUGIN_EVENTCAL_TEXT_INTERVAL', 'Interval');
@define('PLUGIN_EVENTCAL_TEXT_BIWEEK', 'ètrnáct dní');
@define('PLUGIN_EVENTCAL_TEXT_YEARLY', 'rok');
@define('PLUGIN_EVENTCAL_SENDMAIL_BLAHBLAH', 'iCal soubor byl úpìšnì odeslán!');
@define('PLUGIN_EVENTCAL_SENDMAIL_ERROR', 'Pøi odesílání emailu se vyskytla chyba!');
@define('CAL_EVENT_START_RECUR', 'Poèáteèní datum &raquo; <u>%s</u> &laquo; první výskyt!');
@define('CAL_EVENT_FORM_RIGHT_RECURSTRICT1', 'Pozor:');
@define('CAL_EVENT_FORM_RIGHT_RECURSTRICT2', 'pøísnì podle prvního dne u všech opakujících se událostí!');
@define('CAL_EVENT_FORM_RIGHT_RECUR_BIWEEK', 'každý druhý týden');
@define('CAL_EVENT_FORM_RIGHT_RECUR_YEAR', 'každý rok');
@define('CAL_EVENT_FORM_RIGHT_HELP_SINGLE', 'Jednotlivá událost. \'Koneèné datum\' ani žádná další informace není potøeba!');
@define('CAL_EVENT_FORM_RIGHT_HELP_MULTI', 'Multi-událost: Zobrazovat mìsíènì. Vyžaduje \'Poèáteèní datum\' a \'Koncové datum\'.');
@define('CAL_EVENT_FORM_RIGHT_HELP_WEEK', 'Týdenní událost. Urèitì je potøeba nastavit. \'vždy zapnuto\', \'Týdnì\' a a \'Den v týdnu\'. Zobrazuje každý kalendáøní týden v mìsíci. Vyžaduje \'Poèáteèní datum\' a \'koncové datum\'.');
@define('CAL_EVENT_FORM_RIGHT_HELP_BIWEEK', 'Ètrnáctidenní událost. Urèitì je tøeba zadat: \'vždy zapnuto\', \'Týdnì\' a \'Den v týdnu\'. Zobrazuje se každý druhý kalendáøní týden v mìsíci. Vyžaduje \'Poèáteèní datum\' a \'Koncové datum\'.');
@define('CAL_EVENT_FORM_RIGHT_HELP_MONTH', 'Mìsíèní událost. Urèitì je tøeba zadat: \'vždy zapnuto\', \'ntý Den\' a \'Den v týdnu\'. Zobrazuje se každý mìsíc. Vyžaduje \'Poèáteèní datum\' a \'Koncové datum\'.');
@define('CAL_EVENT_FORM_RIGHT_HELP_YEAR', 'Roèní událost. Zobrazuje se roènì od \'Poèáteèního data\'. Nepotøebuje \'Koncové datum\' ani žádné další nastavení!');
@define('CAL_EVENT_FORM_BUTTON_HELP_ICALM', 'Stažení událostí iCal ze v souèasném mìsíci vèetnì všech opakujících se událostí z minulosti i budoucnosti.');

// Next lines were translated on 2010/03/06

@define('PLUGIN_EVENTCAL_ADMIN_NAME', 'Kalendáø událostí');
@define('PLUGIN_EVENTCAL_ADMIN_NAME_MENU', 'Kalendáø událostí  ver.%s - Administrátorské menu');
@define('PLUGIN_EVENTCAL_ADMIN_DBC', 'Kalendáø událostí - Administrace pluginu');
@define('PLUGIN_EVENTCAL_ADMIN_VIEW', 'Kalendáø událostí - Zobrazit schválené události');
@define('PLUGIN_EVENTCAL_ADMIN_VIEW_DESC', 'Seskupeno podle typu - jednotlivá, vícedenní, opakující se, týdenní, roèní.');
@define('PLUGIN_EVENTCAL_ADMIN_APP', 'Kalendáø událostí - Zobrazit neschválené události');
@define('PLUGIN_EVENTCAL_ADMIN_APP_DESC', 'Seskupit podle Poèáteèního data [nejnovìjší nahoøe].');
@define('PLUGIN_EVENTCAL_ADMIN_ERASE', 'Kalendáø událostí - Vymazat události');
@define('PLUGIN_EVENTCAL_ADMIN_LOG', 'Kalendáø událostí - iCal Log');
@define('PLUGIN_EVENTCAL_ADMIN_LOG_ERROR', 'POZOR: Pøi zapisování iCal logovacího souboru se vyskytla chyba. Zkontrolujte, co je špatnì (má adresáø a soubor nastavená práva pro zápis?)!');
@define('PLUGIN_EVENTCAL_ADMIN_ADD', 'Kalendáø událostí - Vložení nové události');
@define('PLUGIN_EVENTCAL_ADMIN_NORESULT', 'Žádné události neèekají na %s!');
@define('PLUGIN_EVENTCAL_ADMIN_NORESULT_APP', 'schválení');
@define('PLUGIN_EVENTCAL_ADMIN_NORESULT_DROP', 'vymazání');
@define('PLUGIN_EVENTCAL_ADMIN_NORESULT_FREE', 'vyèištìní');
@define('PLUGIN_EVENTCAL_ADMIN_FREE_SURE', 'Urèitì chcete odstranit staré události z databázové tabulky událostí?');
@define('PLUGIN_EVENTCAL_ADMIN_CLEAN_SURE', 'Urèitì chcete nastavit novou hodnotu autoincrementu (id) pro všechna data v databázové tabulce kalendáøe událostí?');
@define('PLUGIN_EVENTCAL_ADMIN_CLEAN_SURE_ADD', '<u>Upozornìní:</u> Mùže to mít negativní dopady na cachovaná data ve vyhledávaèích a podobných službách mimo Váš blog!');
@define('PLUGIN_EVENTCAL_ADMIN_DROP_SURE', 'Urèitì chcete smazat celou tabulku kalendáøe událostí vèetnì všch dat? Potvrïte prosím zde!');
@define('PLUGIN_EVENTCAL_ADMIN_DROP_OK', 'Vaše %s databázová tabulka byla úspašnì vymazána!');
@define('PLUGIN_EVENTCAL_ADMIN_DUMP_SELF', 'Pøed pokraèováním byste mìli pro jistotu udìlat mysql dump pomocí PhpMyAdmina!');
@define('PLUGIN_EVENTCAL_ADMIN_ICAL_EMAILLINK', 'Stáhnìte všechny schválené události jako ics soubor pomocí emailu na administrátorskou adresu, pokud je nastavená v konfiguraci tohoto pluginu! Ujistìte se, že je zadaná!');
@define('PLUGIN_EVENTCAL_ADMIN_ICAL_DOWNLINK', 'Stáhnout všechny schválené události jako ics soubor!');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_TITLE', 'Používejte prosím tento administraèní panel opatrnì.');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_TITLE_DESC', 'Nìkteré odkazy mohou být v pøíštích verzích vylepšeny!');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DUMP', 'Administrace - dump');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DUMP_DESC', 'zálohujte tabulky kalendáøe akcí z databáze');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DUMP_TITLE', 'zálohujte (dump výpis) data z databáze kalendáøe akcí');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DUMP_MSG', 'Protože to není jednoduchá akce, použijte prosím administrátorské nástroje jako PhpMyAdmin k dumpu dat!');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INSERT', 'Administrace - vložení');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INSERT_DESC', 'vložení dat do databázové tabulky kalendáøe akcí');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INSERT_TITLE', 'vložení hodnot do databáze kalendáøe akcí');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INSERT_MSG', 'Protože to není jednoduchá operace, použijte prosím administraèní nástroje jako PhpMyAdmin pro znovu naplnìní databáze!');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ERASE', 'Administrace - vymazání');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ERASE_DESC', 'odstranit tabulky kalendáøe akcí z databáze');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ERASE_TITLE', 'vymazat databázi kalendáøe akcí');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DELOLD', 'Administrace - èištìní');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DELOLD_DESC', 'odstranit události starší než 1 mìsíc z databázové tabulky kalendáøe akcí');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DELOLD_TITLE', 'smazat data starší než 1 mìsíc z databázové tabulky');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DELOLD_MSG', 'Z databázové tabulky jste odstranili %d starých událostí starších než 30 dní.');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INCREMENT', 'Administrace - increment');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INCREMENT_DESC', 'Nastavte nové autoincrement id identifikátory v databázové tabulce kalendáøe akcí');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INCREMENT_TITLE', 'nastavit nové autoincrement id v databázové tabulce');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INCREMENT_MSG', 'Restrukturalizovali jste databázovou tabulku s %d zbývajícími hodnotami.');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ICALALL', 'Administrace - iCal');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ICALALL_DESC', 'pošlete všechny události jako iCal soubor administrátorovi - pomocí emailu, pokud je zadán v nastavení, jinak pomocí downloadu');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ICALALL_TITLE', 'poslat iCal pomocí emailu, nebo stáhnout');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ILOG', 'Administrace - iLog');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ILOG_DESC', 'zobrazit iLog souboru exportu pomocí iCal, pokud je');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ILOG_TITLE', 'zobrazit logovací soubor iCal exportu');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ILOG_MSG', 'Soubor iLog neexistuje!');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_NIXDA_DESC', 'v databázi není žádná tabulka kalendáøe akcí');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_NIXDA_TITLE', 'Administrace - chyba');

// Next lines were translated on 2011/03/05
@define('PLUGIN_EVENTCAL_ADMIN_ORDERBY_DESC', 'Seskupeno podle typu akce (èasové znaèky) sestupnì.');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DUMP_DONE', 'Databáze kalendáøe akcí byla úspìšnì zálohována!');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DELFILE_MSG', 'Soubor zálohy databázové tabulky <u>%s</u> úspìšnì vymazán');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DOWNLOAD', 'Administrace - management');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DOWNLOAD_DESC', 'Stažení a vymazání záloh databázové tabulky kalendáøe akcí');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DOWNLOAD_MSG', 'V adresáøi "templates_c" není žádný adresáø "eventcal".');