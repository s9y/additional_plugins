<?php # 

/**
 *  @version 
 *  @author Kostas CoSTa Brzezinski <costa@kofeina.net>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_staticpage.php
//
@define('STATICPAGE_HEADLINE', 'Nagłówek');
@define('STATICPAGE_HEADLINE_BLAHBLAH', 'Pokazuje nagłówek nad zawartością Strony statycznej, taki sam jak w normalnych wpisach');
@define('STATICPAGE_TITLE', 'Strony statyczne');
@define('STATICPAGE_TITLE_BLAHBLAH', 'Pokazuje Strony statyczne w Twoim blogu tak, jak pokazywane są wszystkie inne wpisy (z zachowaniem formatowania i layoutu). Dodaje nową zakładkę w menu w Panelu administracyjnym.');
@define('CONTENT_BLAHBLAH', 'Zawartość');
@define('STATICPAGE_PERMALINK', 'Permalink');
@define('STATICPAGE_PERMALINK_BLAHBLAH', 'Definiuje permalinka dla URLa. Wymaga absolutnej ścieżki HTTP i musi kończyć się rozszerzeniem .htm lub .html!');
@define('STATICPAGE_PAGETITLE', 'Krótka nazwa URLa (kompatybilność wsteczna)');
@define('STATICPAGE_ARTICLEFORMAT', 'Formatować jak wpis?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH', 'Jeśli tak, zawartość Strony statycznej jest formatowana jak każdy inny wpis (kolory, ramki itd.) (domyślnie: tak)');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE', 'Tytuł strony w trybie "Formatować jak wpis"');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH', 'Używając formatowania jak każdy inny wpis, możesz zdecydować jaki tekst wpisać w miejscu, w którym zazwyczaj pokazuje się data wpisu');
@define('STATICPAGE_SELECT', 'Wybierz Stronę statyczną do edycji lub stworzenia');
@define('STATICPAGE_PASSWORD_NOTICE', 'Ta strona jest chroniona hasłem. Proszę, wpisz prawidłowe hasło, które zostało Ci przekazane:');
@define('STATICPAGE_PARENTPAGES_NAME', 'Strona nadrzędna');
@define('STATICPAGE_PARENTPAGE_DESC', 'wybierz stronę nadrzędną');
@define('STATICPAGE_PARENTPAGE_PARENT', 'Jest nadrzędna');
@define('STATICPAGE_AUTHORS_NAME', 'Imię autora');
@define('STATICPAGE_AUTHORS_DESC', 'Ten autor jest właścicielem tej strony');
@define('STATICPAGE_FILENAME_NAME', 'Schemat (Smarty)');
@define('STATICPAGE_FILENAME_DESC', 'Wpisz nazwe pliku/katalogu Schematu, który ma być użyty dla tej strony. Ten plik/katalog może znajdować się w katalogu wtyczki Strony statyczne lub w katalogu Schematu, z którego korzystasz.');
@define('STATICPAGE_SHOWCHILDPAGES_NAME', 'Pokazuj strony potomne');
@define('STATICPAGE_SHOWCHILDPAGES_DESC', 'Pokaż wszystkie strony potomne jako spis linków');
@define('STATICPAGE_PRECONTENT_NAME', 'Treść poprzedzająca');
@define('STATICPAGE_PRECONTENT_DESC', 'Pokaż tę treść przed listą stron potomnych');
@define('STATICPAGE_CANNOTDELETE_MSG', 'Nie mogę usunąć tej strony. W bazie znajdują się strony potomne dla tej strony, proszę je wpierw usunąć.');
@define('STATICPAGE_IS_STARTPAGE', 'Ustaw tę stronę jako strone główą Twojej strony');
@define('STATICPAGE_IS_STARTPAGE_DESC', 'Jeśli ustawisz tę stronę jako stronę główną swojego serwisu, zamiast zwyczajowej strony startowej Serendipity pokaże tę stronę jako stronę startową Twojej witryny. Tylko jedna strona może być stroną startową! Jeśli chcesz linkować do standardowej strony startowej, musisz użyć konstrukcji "index.php?frontpage". Jeśli chcesz używać tej funcji, upewnij się, że żadne inne wtyczki wspierające mechanizm permalinków (np. Głosowanie, Księga gości) nie znajdują się przed wtyczką Strony statyczne w Kolejce wtyczek Serendipity (upewnij się, że wtyczka jest wyżej (czyli znajduje się wcześniej w kolejce zadań wykonywanych przez silnik strony) od innych wtyczek korzystających z permalinków).');
@define('STATICPAGE_TOP', 'Do góry');
@define('STATICPAGE_NEXT', 'Następny');
@define('STATICPAGE_PREV', 'Poprzedni');
@define('STATICPAGE_LINKNAME', 'Edycja');

@define('STATICPAGE_ARTICLETYPE', 'Typ wpisu');
@define('STATICPAGE_ARTICLETYPE_DESC', 'Wybierz typ Strony statycznej');

@define('STATICPAGE_CATEGORY_PAGEORDER', 'Kolejność stron');
@define('STATICPAGE_CATEGORY_PAGES', 'Edytuj strony');
@define('STATICPAGE_CATEGORY_PAGETYPES', 'Typy stron');
@define('STATICPAGE_CATEGORY_PAGEADD', 'Inne wtyczki');

@define('PAGETYPES_SELECT', 'Wybierz typ strony');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION', 'Opis:');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC', 'Opisz ten typ strony');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE', 'Nazwa schematu:');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC', 'Nazwa Schematu. Schemat może znajdować się w katalogu wtyczki Strony statyczne lub w domyślnym katalogu ze Schematami.');
@define('STATICPAGE_ARTICLETYPE_IMAGE', 'Ścieżka do obrazka:');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC', 'URL do obrazka');

@define('STATICPAGE_SHOWNAVI', 'Pokaż nawigację');
@define('STATICPAGE_SHOWNAVI_DESC', 'Pokaż pasek nawigacyjny na tej stronie');
@define('STATICPAGE_SHOWONNAVI', 'Pokaż w menu nawigacyjnym w Panelu bocznym');
@define('STATICPAGE_SHOWONNAVI_DESC', 'Pokaż tę stronę w menu nawigacyjnym (o ile takowe jest włączone), które będzie się pokazywało w Panelu bocznym (będą tam zawarte tylko Strony statyczne)');

@define('STATICPAGE_SHOWNAVI_DEFAULT', 'Pokaż nawigację');
@define('STATICPAGE_DEFAULT_DESC', 'Domyślne ustawienie dla nowych stron');
@define('STATICPAGE_SHOWONNAVI_DEFAULT', 'Pokaż w menu nawigacyjnym w Panelu bocznym');
@define('STATICPAGE_SHOWMARKUP_DEFAULT', 'Pokaż Markup');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT', 'Formatuj jak wpis');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT', 'Pokaż strony potomne');

@define('STATICPAGE_PAGEORDER_DESC', 'Tu możesz zmienić kolejność Stron statycznych');
@define('STATICPAGE_PAGEADD_DESC', 'Wybierz wtyczkę, którą chcesz umieścić jako link w menu nawigacyjnym Stron statycznych.');
@define('STATICPAGE_PAGEADD_PLUGINS', 'Następujące wtyczki mogą być umieszczone w w menu nawigacyjnym w Panelu bocznym:');

@define('STATICPAGE_PUBLISHSTATUS', 'Status publikacji');
@define('STATICPAGE_PUBLISHSTATUS_DESC', 'Status publikacji tej strony');
@define('STATICPAGE_PUBLISHSTATUS_DRAFT', 'Szkic');
@define('STATICPAGE_PUBLISHSTATUS_PUBLISHED', 'Publikacja');

@define('STATICPAGE_SHOWTEXTORHEADLINE_NAME', 'Pokaż nagłówek lub Poprzedni/Następny w pasku nawigacyjnym');
@define('STATICPAGE_SHOWTEXTORHEADLINE_DESC', '');
@define('STATICPAGE_SHOWTEXTORHEADLINE_TEXT', 'Tekst: Poprzedni/Następny');
@define('STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE', 'Nagłówek');

@define('STATICPAGE_LANGUAGE', 'Język');
@define('STATICPAGE_LANGUAGE_DESC', 'wybierz język tej strony');

@define('STATICPAGE_PLUGINS_INSTALLED', 'wtyczka jest zainstalowana');
@define('STATICPAGE_PLUGIN_AVAILABLE', 'Wtyczka jest dostępna lecz nie zainstalowana');
@define('STATICPAGE_PLUGIN_NOTAVAILABLE', 'wtyczka jest niedostępna');

@define('STATICPAGE_SEARCHRESULTS', 'Znaleziono %d Stron statycznych:');

@define('LANG_ALL', 'Wszystkie języki');
@define('LANG_EN', 'English');
@define('LANG_DE', 'German');
@define('LANG_DA', 'Danish');
@define('LANG_ES', 'Spanish');
@define('LANG_FR', 'French');
@define('LANG_FI', 'Finnish');
@define('LANG_CS', 'Czech (Win-1250)');
@define('LANG_CZ', 'Czech (ISO-8859-2)');
@define('LANG_NL', 'Dutch');
@define('LANG_IS', 'Icelandic');
@define('LANG_PT', 'Portuguese Brazilian');
@define('LANG_BG', 'Bulgarian');
@define('LANG_NO', 'Norwegian');
@define('LANG_RO', 'Romanian');
@define('LANG_IT', 'Italian');
@define('LANG_RU', 'Russian');
@define('LANG_FA', 'Persian');
@define('LANG_TW', 'Traditional Chinese (Big5)');
@define('LANG_TN', 'Traditional Chinese (UTF-8)');
@define('LANG_ZH', 'Simplified Chinese (GB2312)');
@define('LANG_CN', 'Simplified Chinese (UTF-8)');
@define('LANG_JA', 'Japanese');
@define('LANG_KO', 'Korean');
@define('LANG_PL', 'Polish');

@define('STATICPAGE_STATUS', 'Status');

//
//  serendipity_plugin_staticpage.php
//

@define('PLUGIN_STATICPAGELIST_NAME', 'Lista Stron statycznych');
@define('PLUGIN_STATICPAGELIST_NAME_DESC', 'Ta wtyczka pokazuje konfigurowalną listę Stron statycznych (menu). Wymaga wtyczki Strony statyczne w wersji minimum 1.22.');
@define('PLUGIN_STATICPAGELIST_TITLE', 'Tytuł');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC', 'Wpisz tytuł pozycji w Panelu bocznym, w której ukażą się linki menu do Stron statycznych');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT', 'Strony statyczne');
@define('PLUGIN_STATICPAGELIST_LIMIT', 'Ilość pokazywanych stron');
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC', 'Wpisz ilość pokazywanych stron statycznych w menu. 0 oznacza brak limitów.');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME',	'Pokaż link do strony głównej');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC', 'Czy w menu ma byc pokazany link do strony głównej?');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME', 'Strona główna');
@define('PLUGIN_LINKS_IMGDIR', 'Uzyj katalogu wtyczki, w nim znajdują się odpowiednie obrazki');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH', 'Podaj ścieżkę URL, której wtyczka ma używać przy szukaniu obrazków wizualizujących układ menu. Podkatalog "img" musi znajdować się w miejscu wskazywanym przez ścieżkę. Taki podkatalog znajduje się w katalogu wtyczki Strony statyczne. W razie wątpliwości pozostaw domyślne ustawienie.');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_NAME', 'Ikony czy czysty tekst');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_DESC', 'Pokazywać strukturę menu graficznie czy w formie czystego tekstu?');
@define('PLUGIN_STATICPAGELIST_ICON', 'graficznie');
@define('PLUGIN_STATICPAGELIST_TEXT', 'czysty tekst');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY', 'Pokazywać tylko strony nadrzędne?');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY_DESC', 'Jeśli opcja zostanie włączona, w strukturze menu pojawią się tylko strony oznaczone jako "nadrzędne". Wyłączenie opcji pokaże także strony "potomne" w strukturze menu.');
@define('PLUGIN_STATICPAGELIST_IMG_NAME', 'Włączyć graficzną reprezentację struktury menu');

?>
