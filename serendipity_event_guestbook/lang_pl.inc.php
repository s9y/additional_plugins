<?php # 

/**
 *  @version 
 *  @file serendipity_event_guestbook.php, langfile(pl) v1.0 2007-05-21 16:10:54 utak3r
 *  @author utak3r
 *  EN-Revision: 
 */

@define('PLUGIN_GUESTBOOK_HEADLINE', 'Nag³ówek');
@define('PLUGIN_GUESTBOOK_HEADLINE_BLAHBLAH', 'Nag³ówek strony.');
@define('PLUGIN_GUESTBOOK_TITLE', 'Ksiêga go¶ci');
@define('PLUGIN_GUESTBOOK_TITLE_BLAHBLAH', 'Pokazuje ksiêgê go¶ci w ramach twojego blogu, stosuj±c normalny jego wygl±d.');
@define('PLUGIN_GUESTBOOK_PERMALINK', 'Permalink');
@define('PLUGIN_GUESTBOOK_PERMALINK_BLAHBLAH', 'Definiuje permalink. Musi byæ ¶cie¿k± absolutn± HTTP i koñczyæ siê .htm lub .html!');
@define('PLUGIN_GUESTBOOK_PAGETITLE', 'Nazwa strony');
@define('PLUGIN_GUESTBOOK_PAGETITLE_BLAHBLAH', 'Nazwa strony');
@define('PLUGIN_GUESTBOOK_PAGEURL', 'Statyczny URL');
@define('PLUGIN_GUESTBOOK_PAGEURL_BLAHBLAH', 'Definiuje URL strony (index.php?serendipity[subpage]=name)');

@define('PLUGIN_GUESTBOOK_SESSIONLOCK', 'Blokada sesji');
@define('PLUGIN_GUESTBOOK_SESSIONLOCK_BLAHBLAH', 'Je¶li aktywne, mo¿liwy tylko jeden wpis na sesjê (u¿ytkownika).');
@define('PLUGIN_GUESTBOOK_TIMELOCK', 'Blokada czasu');
@define('PLUGIN_GUESTBOOK_TIMELOCK_BLAHBLAH', 'Po ilu sekundach u¿ytkownik mo¿e zrobiæ kolejny wpis. Przydatne, je¶li chcesz unikn±æ podwójnych wpisów przez np. podwójne klikniêcia, ewentualnie zwalczyæ roboty spamowe.');

@define('PLUGIN_GUESTBOOK_EMAILADMIN', 'Wy¶lij e-maila do administratora');
@define('PLUGIN_GUESTBOOK_EMAILADMIN_BLAHBLAH', 'Je¶li zaznaczone, administrator dostaje maila po ka¿dym wpisie.');
@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN', 'E-mail administratora');
@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN_BLAHBLAH', 'Proszê podaæ prawid³owy adres e-mail, je¶li chcesz otrzymywaæ powiadomienia o wpisach.');
@define('PLUGIN_GUESTBOOK_SHOWEMAIL', 'Pytaæ u¿ytkownika o e-mail?');
@define('PLUGIN_GUESTBOOK_SHOWEMAIL_BLAHBLAH', 'Czy chcesz pole na e-mail u¿ytkownika?');
@define('PLUGIN_GUESTBOOK_SHOWURL', 'Pytaæ o stronê u¿ytkownika?');
@define('PLUGIN_GUESTBOOK_SHOWURL_BLAHBLAH', 'Czy chcesz pole na stronê domow± u¿ytkownika?');
@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA', 'Pokazywaæ obrazki Captcha?');
@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA_BLAHBLAH', 'Czy chcesz u¿ywaæ obrazków Captcha (wymaga uruchomionej wtyczki Spamblock)');
@define('PLUGIN_GUESTBOOK_NUMBER', 'Wpisów na stronê');
@define('PLUGIN_GUESTBOOK_NUMBER_BLAHBLAH', 'Ile wpisów ma siê wy¶wietlaæ na stronê?');
@define('PLUGIN_GUESTBOOK_WORDWRAP', 'Znaków na liniê (zawijanie)');
@define('PLUGIN_GUESTBOOK_WORDWRAP_BLAHBLAH', 'Po ilu znakach ma byæ wstawiony znak nowej linii?');
@define('PLUGIN_GUESTBOOK_ERROR_DATA', 'Wyst±pi³ b³±d podczas przetwarzania');

@define('PLUGIN_GUESTBOOK_EMAIL', 'Adres e-mail');
@define('PLUGIN_GUESTBOOK_INTRO', 'Tekst wstêpny (opcjonalny)');
@define('PLUGIN_GUESTBOOK_MESSAGE', 'Wiadomo¶æ');
@define('PLUGIN_GUESTBOOK_SENT', 'Tekst po wys³aniu wiadomo¶ci');
@define('PLUGIN_GUESTBOOK_SENT_HTML', 'Twoja wiadomo¶æ zosta³a pomy¶lnie wys³ana!');
@define('PLUGIN_GUESTBOOK_ERROR_HTML', 'Podczas wysy³ania wiadomo¶ci wyst±pi³ b³±d!');
@define('PLUGIN_GUESTBOOK_ERROR_DATA', 'Ksywka, e-mail i tre¶æ nie mog± byæ puste.');
@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT', 'Formatowaæ jak artyku³?');
@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT_BLAHBLAH', 'Je¶li zaznaczone, tre¶æ jest automatycznie formatowana jak artyku³ (kolory, ramki itp.) (domy¶lnie: tak)');
@define('PLUGIN_GUESTBOOK_CAPTCHAWARNING', '');
@define('PLUGIN_GUESTBOOK_PROTECTION', 'E-mail bêdzie przekonwertowany do postaci: u¿ytkownik at email dot com');
@define('PLUGIN_GUESTBOOK_DBDONE', 'Wpis do ksi±¿ki zapisany!');
@define('PLUGIN_GUESTBOOK_USER_LOGGEDOFF', 'U¿ytkownik siê wylogowa³.');
@define('PLUGIN_GUESTBOOK_USERSDATE_OF_ENTRY', 'napisa³(a)');
@define('PLUGIN_GUESTBOOK_UNKNOWN_ERROR', 'Nieznany b³±d! Proszê skontaktowaæ siê z administratorem witryny');
@define('PLUGIN_GUESTBOOK_TIMESTAMP_THE', '');
@define('PLUGIN_GUESTBOOK_ALTER_OLDTABLE_DONE', 'Tabela bazy pomy¶lnie zmieniona.');
@define('PLUGIN_GUESTBOOK_INSTALL_NEWTABLE_DONE', 'Tabela bazy pomy¶lnie zainstalowana.');

@define('BODY', 'Wpis');
@define('SUBMIT', 'Wy¶lij wpis');

@define('GUESTBOOK_NEXTPAGE', 'nast. strona');
@define('GUESTBOOK_PREVPAGE', 'poprz. strona');

@define('TEXT_DELETE', 'usuñ');
@define('TEXT_SAY', 'powiedzia³');
@define('TEXT_EMAIL', 'E-mail');
@define('TEXT_NAME', 'Ksywka');
@define('TEXT_HOMEPAGE', 'Strona domowa');
@define('TEXT_EMAILSUBJECT', 'Nowy wpis');
@define('TEXT_EMAILTEXT', "%s w³a¶nie wpisa³ do twojej ksi±¿ki go¶ci:\n%s\n%s\n");
@define('TEXT_CONVERTBOLDUNDERLINE', 'Zamkniêcie tekstu w znakach gwiazdki spowoduje jego wyt³uszczenie (*tekst*), podkre¶lenia s± tworzone przez zastosowanie _tekst_.');
@define('TEXT_CONVERTSMILIES', 'Standardowe emotikony jak :-) lub ;-) bêd± zmieniane na ich graficzn± wersjê.');
@define('TEXT_IMG_DELETEENTRY', 'Usuñ wpis');
@define('TEXT_IMG_LASTMODIFIED', 'ostatnio modyfikowane');
@define('TEXT_USERS_HOMEPAGE', 'Strona domowa go¶cia');

@define('ERROR_TIMELOCK', 'Proszê poczekaæ przynajmniej %s sekund przed ponownym wpisem!');
@define('ERROR_NAMEEMPTY', 'Proszê podac swoj± ksywkê.');
@define('ERROR_TEXTEMPTY', 'Proszê wprowadziæ tekst.');
@define('ERROR_EMAILEMPTY', 'Proszê podac prawid³owy adres e-mail.');
@define('ERROR_DATATOSHORT', 'Twój wpis powinien mieæ przynajmniej 3, a w polu komentarza 10 znaków.');
@define('ERROR_NOVALIDEMAIL', 'Twój adres e-mail wygl±da na nieprawid³owy: ');
@define('ERROR_COLOR_START', '<span style="color: #ff0000"> ');
@define('ERROR_COLOR_END', ' </span>');
@define('ERROR_NOINPUT', 'Proszê podaæ swoj± ksywkê, adres e-mail i tre¶æ wpisu');
@define('ERROR_ISFALSECAPTCHA', 'Kod z obrazka CAPTCHAS nie pasuje!');
@define('ERROR_NOCAPTCHASET', 'Ogólne ustawienia CAPTCHA nie mog± byæ poprawnie skonfigurowane!');
@define('ERROR_UNKNOWN', 'Wyst±pi³ nieznany b³±d. Proszê spróbowaæ ponownie lub poinformowaæ administratora tej witryny. Dziêkujê!');
@define('ERROR_OCCURRED', 'Wyst±pi³y pewne b³êdy:');
@define('ERROR_IS_MARKED_SPAM', 'Twój wpis zostal oznaczony jako spam. Proszê poprawiæ swój wpis, lub skontaktowaæ siê z administratorem!');

@define('THANKS_FOR_ENTRY', 'Twój wpis do ksi±¿ki:');
@define('QUESTION_DELETE', 'Na prawdê chcesz usun±æ wpis %s ?');
@define('MARK_SPAM', 'Czy ten wpis ma byæ oznaczony jako SPAM?');

@define('PAGINATOR_TO', 'Do');
@define('PAGINATOR_FIRST', 'Pierwsza');
@define('PAGINATOR_PREVIOUS', 'Poprzednia');
@define('PAGINATOR_NEXT', 'Nastêpna');
@define('PAGINATOR_LAST', 'Ostatnia');
@define('PAGINATOR_PAGE', 'Strona.');
@define('PAGINATOR_RANGE', ' do ');
@define('PAGINATOR_OFFSET', ', razem ');
@define('PAGINATOR_ENTRIES', ' wpisów. ');

//
//  serendipity_plugin_guestbook.php
//
@define('PLUGIN_GUESTSIDE_NAME', 'Guestbook Sidebar');
@define('PLUGIN_GUESTSIDE_BLAHBLAH', 'Display the latest guestbook items in the sidebar');
@define('PLUGIN_GUESTSIDE_TITLE', 'Item Title');
@define('PLUGIN_GUESTSIDE_TITLE_BLAHBLAH', 'Set the title for the plugin');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL', 'Show e-mail');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL_BLAHBLAH', 'Should the e-mail address of the writer be displayed?');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE', 'Show homepage');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE_BLAHBLAH', 'Should the homepage of the writer be displayed?');
@define('PLUGIN_GUESTSIDE_MAXCHARS', 'Max. characters');
@define('PLUGIN_GUESTSIDE_MAXCHARS_BLAHBLAH', 'The content length in characters');
@define('PLUGIN_GUESTSIDE_MAXITEMS', 'Max. items');
@define('PLUGIN_GUESTSIDE_MAXITEMS_BLAHBLAH', 'Set the number of items to be displayed');

