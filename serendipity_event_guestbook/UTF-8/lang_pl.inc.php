<?php # $Id: erendipity_event_guestbook.php, langfile(pl) v1.0 2007-05-21 16:10:54 utak3r


	@define('PLUGIN_GUESTBOOK_HEADLINE', 'Nagłówek');
	@define('PLUGIN_GUESTBOOK_HEADLINE_BLAHBLAH', 'Nagłówek strony.');
	@define('PLUGIN_GUESTBOOK_TITLE', 'Księga gości');
	@define('PLUGIN_GUESTBOOK_TITLE_BLAHBLAH', 'Pokazuje księgę gości w ramach twojego blogu, stosując normalny jego wygląd.');
	@define('PLUGIN_GUESTBOOK_PERMALINK', 'Permalink');
	@define('PLUGIN_GUESTBOOK_PERMALINK_BLAHBLAH', 'Definiuje permalink. Musi być ścieżką absolutną HTTP i kończyć się .htm lub .html!');
	@define('PLUGIN_GUESTBOOK_PAGETITLE', 'Nazwa strony');
	@define('PLUGIN_GUESTBOOK_PAGETITLE_BLAHBLAH', 'Nazwa strony');
	@define('PLUGIN_GUESTBOOK_PAGEURL', 'Statyczny URL');
	@define('PLUGIN_GUESTBOOK_PAGEURL_BLAHBLAH', 'Definiuje URL strony (index.php?serendipity[subpage]=name)');

	@define('PLUGIN_GUESTBOOK_SESSIONLOCK', 'Blokada sesji');
	@define('PLUGIN_GUESTBOOK_SESSIONLOCK_BLAHBLAH', 'Jeśli aktywne, możliwy tylko jeden wpis na sesję (użytkownika).');
	@define('PLUGIN_GUESTBOOK_TIMELOCK', 'Blokada czasu');
	@define('PLUGIN_GUESTBOOK_TIMELOCK_BLAHBLAH', 'Po ilu sekundach użytkownik może zrobić kolejny wpis. Przydatne, jeśli chcesz uniknąć podwójnych wpisów przez np. podwójne kliknięcia, ewentualnie zwalczyć roboty spamowe.');

	@define('PLUGIN_GUESTBOOK_EMAILADMIN', 'Wyślij e-maila do administratora');
	@define('PLUGIN_GUESTBOOK_EMAILADMIN_BLAHBLAH', 'Jeśli zaznaczone, administrator dostaje maila po każdym wpisie.');
	@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN', 'E-mail administratora');
	@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN_BLAHBLAH', 'Proszę podać prawidłowy adres e-mail, jeśli chcesz otrzymywać powiadomienia o wpisach.');
	@define('PLUGIN_GUESTBOOK_SHOWEMAIL', 'Pytać użytkownika o e-mail?');
	@define('PLUGIN_GUESTBOOK_SHOWEMAIL_BLAHBLAH', 'Czy chcesz pole na e-mail użytkownika?');
	@define('PLUGIN_GUESTBOOK_SHOWURL', 'Pytać o stronę użytkownika?');
	@define('PLUGIN_GUESTBOOK_SHOWURL_BLAHBLAH', 'Czy chcesz pole na stronę domową użytkownika?');
	@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA', 'Pokazywać obrazki Captcha?');
	@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA_BLAHBLAH', 'Czy chcesz używać obrazków Captcha (wymaga uruchomionej wtyczki Spamblock)');
	@define('PLUGIN_GUESTBOOK_NUMBER', 'Wpisów na stronę');
	@define('PLUGIN_GUESTBOOK_NUMBER_BLAHBLAH', 'Ile wpisów ma się wyświetlać na stronę?');
	@define('PLUGIN_GUESTBOOK_WORDWRAP', 'Znaków na linię (zawijanie)');
	@define('PLUGIN_GUESTBOOK_WORDWRAP_BLAHBLAH', 'Po ilu znakach ma być wstawiony znak nowej linii?');
	@define('PLUGIN_GUESTBOOK_ERROR_DATA', 'Wystąpił błąd podczas przetwarzania');

	@define('PLUGIN_GUESTBOOK_EMAIL', 'Adres e-mail');
	@define('PLUGIN_GUESTBOOK_INTRO', 'Tekst wstępny (opcjonalny)');
	@define('PLUGIN_GUESTBOOK_MESSAGE', 'Wiadomość');
	@define('PLUGIN_GUESTBOOK_SENT', 'Tekst po wysłaniu wiadomości');
	@define('PLUGIN_GUESTBOOK_SENT_HTML', 'Twoja wiadomość została pomyślnie wysłana!');
	@define('PLUGIN_GUESTBOOK_ERROR_HTML', 'Podczas wysyłania wiadomości wystąpił błąd!');
	@define('PLUGIN_GUESTBOOK_ERROR_DATA', 'Ksywka, e-mail i treść nie mogą być puste.');
	@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT', 'Formatować jak artykuł?');
	@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT_BLAHBLAH', 'Jeśli zaznaczone, treść jest automatycznie formatowana jak artykuł (kolory, ramki itp.) (domyślnie: tak)');
	@define('PLUGIN_GUESTBOOK_CAPTCHAWARNING', '');
	@define('PLUGIN_GUESTBOOK_PROTECTION', 'E-mail będzie przekonwertowany do postaci: użytkownik at email dot com');
	@define('PLUGIN_GUESTBOOK_DBDONE', 'Wpis do książki zapisany!');
	@define('PLUGIN_GUESTBOOK_USER_LOGGEDOFF', 'Użytkownik się wylogował.');
	@define('PLUGIN_GUESTBOOK_USERSDATE_OF_ENTRY', 'napisał(a)');
	@define('PLUGIN_GUESTBOOK_UNKNOWN_ERROR', 'Nieznany błąd! Proszę skontaktować się z administratorem witryny');
	@define('PLUGIN_GUESTBOOK_TIMESTAMP_THE', '');
	@define('PLUGIN_GUESTBOOK_ALTER_OLDTABLE_DONE', 'Tabela bazy pomyślnie zmieniona.');
	@define('PLUGIN_GUESTBOOK_INSTALL_NEWTABLE_DONE', 'Tabela bazy pomyślnie zainstalowana.');

	@define('BODY', 'Wpis');
	@define('SUBMIT', 'Wyślij wpis');

	@define('GUESTBOOK_NEXTPAGE', 'nast. strona');
	@define('GUESTBOOK_PREVPAGE', 'poprz. strona');


	@define('TEXT_DELETE', 'usuń');
	@define('TEXT_SAY', 'powiedział');
	@define('TEXT_EMAIL', 'E-mail');
	@define('TEXT_NAME', 'Ksywka');
	@define('TEXT_HOMEPAGE', 'Strona domowa');
	@define('TEXT_EMAILSUBJECT', 'Nowy wpis');
	@define('TEXT_EMAILTEXT', "%s właśnie wpisał do twojej książki gości:\n%s");
	@define('TEXT_CONVERTBOLDUNDERLINE', 'Zamknięcie tekstu w znakach gwiazdki spowoduje jego wytłuszczenie (*tekst*), podkreślenia są tworzone przez zastosowanie _tekst_.');
	@define('TEXT_CONVERTSMILIES', 'Standardowe emotikony jak :-) lub ;-) będą zmieniane na ich graficzną wersję.');
	@define('TEXT_IMG_DELETEENTRY', 'Usuń wpis');
	@define('TEXT_IMG_LASTMODIFIED', 'ostatnio modyfikowane');
	@define('TEXT_USERS_HOMEPAGE', 'Strona domowa gościa');

	@define('ERROR_TIMELOCK', 'Proszę poczekać przynajmniej %s sekund przed ponownym wpisem!');
	@define('ERROR_NAMEEMPTY', 'Proszę podać swoją ksywkę.');
	@define('ERROR_TEXTEMPTY', 'Proszę wprowadzić tekst.');
	@define('ERROR_EMAILEMPTY', 'Proszę podać prawidłowy adres e-mail.');
	@define('ERROR_DATATOSHORT', 'Twój wpis powinien mieć przynajmniej 3, a w polu komentarza 10 znaków.');
	@define('ERROR_NOVALIDEMAIL', 'Twój adres e-mail wygląda na nieprawidłowy: ');
	@define('ERROR_COLOR_START', '<span style="color: #ff0000"> ');
	@define('ERROR_COLOR_END', ' </span>');
	@define('ERROR_NOINPUT', 'Proszę podać swoją ksywkę, adres e-mail i treść wpisu');
	@define('ERROR_ISFALSECAPTCHA', 'Kod z obrazka CAPTCHAS nie pasuje!');
	@define('ERROR_NOCAPTCHASET', 'Ogólne ustawienia CAPTCHA nie mogą być poprawnie skonfigurowane!');
	@define('ERROR_UNKNOWN', 'Wystąpił nieznany błąd. Proszę spróbować ponownie lub poinformować administratora tej witryny. Dziękuję!');
	@define('ERROR_OCCURRED', 'Wystąpiły pewne błędy:');
	@define('ERROR_IS_MARKED_SPAM', 'Twój wpis został oznaczony jako spam. Proszę poprawić swój wpis, lub skontaktować się z administratorem!');

	@define('THANKS_FOR_ENTRY', 'Twój wpis do książki:');
	@define('QUESTION_DELETE', 'Na prawdę chcesz usunąć wpis %s ?');
	@define('MARK_SPAM', 'Czy ten wpis ma być oznaczony jako SPAM?');

	@define('PAGINATOR_TO', 'Do');
	@define('PAGINATOR_FIRST', 'Pierwsza');
	@define('PAGINATOR_PREVIOUS', 'Poprzednia');
	@define('PAGINATOR_NEXT', 'Następna');
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
