<?php # 

/**
 *  @version 
 *  @author Kostas CoSTa Brzezinski <costa@kofeina.net>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_linklist.php
//
@define('PLUGIN_LINKLIST_TITLE', 'Lista linków');
@define('PLUGIN_LINKLIST_DESC', 'Manadżer linków - pokazuje Twoje ulubione linki w Panelu bocznym.');
@define('PLUGIN_LINKLIST_LINK', 'Link');
@define('PLUGIN_LINKLIST_LINK_NAME', 'Nazwa');
@define('PLUGIN_LINKLIST_ADMINLINK', 'Zarządzaj linkami');
@define('PLUGIN_LINKLIST_ORDER', 'Sortowanie linków');
@define('PLUGIN_LINKLIST_ORDER_DESC', 'Wybierz metodę sortowania wyświetlanych linków');
@define('PLUGIN_LINKLIST_ORDER_NUM_ORDER', 'Własna metoda');
@define('PLUGIN_LINKLIST_ORDER_DATE_ACS', 'Według daty (starsze do nowszych)');
@define('PLUGIN_LINKLIST_ORDER_DATE_DESC', 'Według daty (nowsze do starszych)');
@define('PLUGIN_LINKLIST_ORDER_CATEGORY', 'Kategoriami');
@define('PLUGIN_LINKLIST_ORDER_ALPHA', 'Alfabetycznie');
@define('PLUGIN_LINKLIST_LINKS', 'Zarządzaj linkami');
@define('PLUGIN_LINKLIST_NOLINKS', 'Brak linków na liście');
@define('PLUGIN_LINKLIST_CATEGORY', 'Używaj kategorii');
@define('PLUGIN_LINKLIST_CATEGORYDESC','Uzywaj kategorii by organizować swoje linki');
@define('PLUGIN_LINKLIST_ADDLINK','Dodaj linka');
@define('PLUGIN_LINKLIST_LINK_EXAMPLE','Przykład: http://www.s9y.org lub http://www.s9y.org/forums/');
@define('PLUGIN_LINKLIST_EDITLINK','Edytuj linka');
@define('PLUGIN_LINKLIST_LINKDESC','Opis linka');
@define('PLUGIN_LINKLIST_CATEGORY_NAME','Używać którego systemu kategorii:');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DESC','Możesz wybrać, jaki system kategorii ma być wykorzystywany. System kategorii bloga (Domyślny), czy też dostarczany i zawiadywany przez wtyczkę (Własny).');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_CUSTOM','Własny');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DEFAULT','Domyślny');
@define('PLUGIN_LINKLIST_ADD_CAT','Zarządzaj kategoriami');
@define('PLUGIN_LINKLIST_CAT_NAME','Nazwa kategorii');
@define('PLUGIN_LINKLIST_PARENT_CATEGORY','Kategoria nadrzędna');
@define('PLUGIN_LINKLIST_ADMINCAT','Podgląd i zarządzanie kategoriami');
@define('PLUGIN_LINKLIST_CACHE_NAME','Buforowanie linków');
@define('PLUGIN_LINKLIST_CACHE_DESC','Buforowanie listy linków skutkuje wzrostem wydajności strony. Bufor jest aktualizowany przy modyfikacji listy linków z poziomu Panelu administracyjnego.');
@define('PLUGIN_LINKLIST_ENABLED_NAME','Włącz');
@define('PLUGIN_LINKLIST_ENABLED_DESC','Włącz wtyczkę');
@define('PLUGIN_LINKLIST_DELETE_WARN','Kiedy kategoria jest usuwana, wszystkie linki do niej przynależne zostaną przeniesione do kategorii głównej drzewa linków.');

//
//  serendipity_plugin_linklist.php
//
@define('PLUGIN_LINKS_NAME', 'Lista linków');
@define('PLUGIN_LINKS_BLAHBLAH', 'Manadżer linków - pokazuje Twoje ulubione linki w Panelu bocznym.');
@define('PLUGIN_LINKS_TITLE', 'Tytuł');
@define('PLUGIN_LINKS_TITLE_BLAHBLAH', 'Wprowadź tytuł/nazwę sekcji z linkami (będzie widoczna w Panelu bocznym)');
@define('PLUGIN_LINKS_TOP_LEVEL', 'Tekst początkowy');
@define('PLUGIN_LINKS_TOP_LEVEL_BLAHBLAH', 'Wprowadź dowolny tekst, jaki ma być pokazywany przed listą linków (można to pole pozostawić puste)');
@define('PLUGIN_LINKS_DIRECTXML', 'Wprowadzaj XML bezpośrednio');
@define('PLUGIN_LINKS_DIRECTXML_BLAHBLAH', 'Możesz wprowadzać dane XML bezpośrednio (samodzielnie) lub użyć strony web zarządzającej linkami');
@define('PLUGIN_LINKS_LINKS', 'Linki');
@define('PLUGIN_LINKS_LINKS_BLAHBLAH', 'używaj XML! - dla katalogów użyj składni "<dir name="dirname"> i zamykaj używając </dir> - dla linków używaj składni "<link name="nazwa linku" link="http://link.com/" />');
@define('PLUGIN_LINKS_OPENALL', 'Otwórz wszystkie');
@define('PLUGIN_LINKS_OPENALL_BLAHBLAH', 'Wprowadź tekst dla linku "Otwórz wszystkie"');
@define('PLUGIN_LINKS_OPENALL_DEFAULT', 'Otwórz wszystkie');
@define('PLUGIN_LINKS_CLOSEALL', 'Zamknij wszystkie');
@define('PLUGIN_LINKS_CLOSEALL_BLAHBLAH', 'Wprowadź tekst dla linku "Zamknij wszystkie"');
@define('PLUGIN_LINKS_CLOSEALL_DEFAULT', 'Zamknij wszystkie');
@define('PLUGIN_LINKS_SHOW', 'Pokazuj linki "Otwórz wszystkie" i "Zamknij wszystkie"');
@define('PLUGIN_LINKS_SHOW_BLAHBLAH', 'Czy chcesz umieścić w Panelu bocznym linki do "Otwórz wszystkie" i "Zamknij wszystkie"?');
@define('PLUGIN_LINKS_LOCATION', 'Lokalizacja linków "Otwórz wszystkie" i "Zamknij wszystkie"');
@define('PLUGIN_LINKS_LOCATION_BLAHBLAH', 'Gdzie linki "Otwórz wszystkie" i "Zamknij wszystkie" mają być umieszczone? Nad czy pod listą linków?');
@define('PLUGIN_LINKS_LOCATION_TOP', 'Nad');
@define('PLUGIN_LINKS_LOCATION_BOTTOM', 'Pod');
@define('PLUGIN_LINKS_SELECTION', 'Używaj selekcji');
@define('PLUGIN_LINKS_SELECTION_BLAHBLAH', 'Jeśli zaznaczysz "Tak", gałęzie drzewa linków mogą być zaznaczane (podświetlane)');
@define('PLUGIN_LINKS_COOKIE', 'Używaj cookies (ciasteczek)');
@define('PLUGIN_LINKS_COOKIE_BLAHBLAH', 'Jeśli zaznaczysz "Tak", drzewo linków będzie używało cookies (ciasteczek) do zapamiętania swojego stanu');
@define('PLUGIN_LINKS_LINE', 'Używaj linii');
@define('PLUGIN_LINKS_LINE_BLAHBLAH', 'Jeśli zaznaczysz "Tak", drzewo linków będzie rysowane przy pomocy linii');
@define('PLUGIN_LINKS_ICON', 'Używaj ikon');
@define('PLUGIN_LINKS_ICON_BLAHBLAH', 'Jeśli zaznaczysz "Tak", drzewo linków będzie rysowane przy pomocy ikon');
@define('PLUGIN_LINKS_STATUS', 'Używaj tekstu w panelu statusu przeglądarki');
@define('PLUGIN_LINKS_STATUS_BLAHBLAH', 'Jeśli zaznaczysz "Tak", nazwy gałęzi drzewa będą pokazywane w panelu statusu przeglądarki zamiast adresu URL');
@define('PLUGIN_LINKS_CLOSELEVEL', 'Zamknij ten sam poziom');
@define('PLUGIN_LINKS_CLOSELEVEL_BLAHBLAH', 'Jeśli zaznaczysz "Tak", tylko jedna gałąź drzewa linków może być otwarta w danym momencie. Linki "Otwórz wszystkie" i "Zamknij wszystkie" nie działają kiedy to ustawienie jest włączone.');
@define('PLUGIN_LINKS_TARGET', 'Cel');
@define('PLUGIN_LINKS_TARGET_BLAHBLAH', 'Docelowe miejsce dla linków - może być zdefioniowane jako "_blank", "_self", "_top", "_parent" lub możesz wprowadzić nazwę ramki (frame)');
@define('PLUGIN_LINKS_IMGDIR', 'Uzyj katalogu wtyczki, w nim znajdują się odpowiednie obrazki');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH', 'Jeśli zaznaczysz "Tak", wtyczka założy, że potrzebne jej do prawidłowego wyświetlania obrazki znajdują się w katalogu wtyczki. Jeśli zaznaczysz "Nie", wtyczka jako katalog obrazków wskaże katalog "/templates/default/img/". Wyłączenie ściezki do obrazków jest wymagane przy współdzielonych instalacjach lecz wymaga także ręcznego przeniesienia obrazków do odpowiedniego katalogu.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME', 'Drzewo kategorii otwarte czy zamknięte?');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_DESC', 'Przy używaniu sortowania Kategoriami możesz ustawić czy wszystkie gałęzie drzewa linków będą standardowo otwarte czy zamknięte');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_CLOSED', 'Zamknięte');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_OPEN', 'Otwarte');
@define('PLUGIN_LINKLIST_OUTSTYLE_DTREE', 'dtree');
@define('PLUGIN_LINKLIST_OUTSTYLE_CSS', 'Lista CSS');
@define('PLUGIN_LINKLIST_ORDER_OUTSTYLE_SIMP_CSS', 'Prosty CSS');
@define('PLUGIN_LINKS_OUTSTYLE', 'Wybierz styl wyświetlania dla listy linków');
@define('PLUGIN_LINKS_OUTSTYLE_BLAHBLAH', 'Wybierz styl wyświetlania dla listy linków. Dtree używa javascriptu do tworzenia drzewa linków (skrypt działa we wszystkich popularnych przeglądarkach). Lista CSS używa divów i prostego javascriptu dla stworzenia efektu uzyskiwanego przez zastosowanie Dtree ale nie jest tak zaawansowany jak Dtree. Prosty CSS to metoda najlepsza jeśli chcesz by wyszukiwarki parsowały linki umieszczone na Twojej stronie. Prosty CSS wyświetli kontrolowaną przez CSS listę. UWAGA! Metody z użyciem Dtree zazwyczaj NIE umozliwiają wyszukiwarkom interentowym na parsowanie wyświetlanych przez nie linków.');
?>
