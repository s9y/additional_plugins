<?php

/**
 *  @version 
 *  @author Kostas CoSTa Brzezinski <costa@kofeina.net>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_linklist.php
//
@define('PLUGIN_LINKLIST_TITLE', 'Lista linków');
@define('PLUGIN_LINKLIST_DESC', 'Manad¿er linków - pokazuje Twoje ulubione linki w Panelu bocznym.');
@define('PLUGIN_LINKLIST_LINK', 'Link');
@define('PLUGIN_LINKLIST_LINK_NAME', 'Nazwa');
@define('PLUGIN_LINKLIST_ADMINLINK', 'Zarz±dzaj linkami');
@define('PLUGIN_LINKLIST_ORDER', 'Sortowanie linków');
@define('PLUGIN_LINKLIST_ORDER_DESC', 'Wybierz metodê sortowania wy¶wietlanych linków');
@define('PLUGIN_LINKLIST_ORDER_NUM_ORDER', 'W³asna metoda');
@define('PLUGIN_LINKLIST_ORDER_DATE_ACS', 'Wed³ug daty (starsze do nowszych)');
@define('PLUGIN_LINKLIST_ORDER_DATE_DESC', 'Wed³ug daty (nowsze do starszych)');
@define('PLUGIN_LINKLIST_ORDER_CATEGORY', 'Kategoriami');
@define('PLUGIN_LINKLIST_ORDER_ALPHA', 'Alfabetycznie');
@define('PLUGIN_LINKLIST_LINKS', 'Zarz±dzaj linkami');
@define('PLUGIN_LINKLIST_NOLINKS', 'Brak linków na li¶cie');
@define('PLUGIN_LINKLIST_CATEGORY', 'U¿ywaj kategorii');
@define('PLUGIN_LINKLIST_CATEGORYDESC', 'Uzywaj kategorii by organizowaæ swoje linki');
@define('PLUGIN_LINKLIST_ADDLINK', 'Dodaj linka');
@define('PLUGIN_LINKLIST_LINK_EXAMPLE', 'Przyk³ad: http://www.s9y.org lub http://www.s9y.org/forums/');
@define('PLUGIN_LINKLIST_EDITLINK', 'Edytuj linka');
@define('PLUGIN_LINKLIST_LINKDESC', 'Opis linka');
@define('PLUGIN_LINKLIST_CATEGORY_NAME', 'U¿ywaæ którego systemu kategorii:');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DESC', 'Mo¿esz wybraæ, jaki system kategorii ma byæ wykorzystywany. System kategorii bloga (Domy¶lny), czy te¿ dostarczany i zawiadywany przez wtyczkê (W³asny).');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_CUSTOM', 'W³asny');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DEFAULT', 'Domy¶lny');
@define('PLUGIN_LINKLIST_ADD_CAT', 'Zarz±dzaj kategoriami');
@define('PLUGIN_LINKLIST_CAT_NAME', 'Nazwa kategorii');
@define('PLUGIN_LINKLIST_PARENT_CATEGORY', 'Kategoria nadrzêdna');
@define('PLUGIN_LINKLIST_ADMINCAT', 'Podgl±d i zarz±dzanie kategoriami');
@define('PLUGIN_LINKLIST_CACHE_NAME', 'Buforowanie linków');
@define('PLUGIN_LINKLIST_CACHE_DESC', 'Buforowanie listy linków skutkuje wzrostem wydajno¶ci strony. Bufor jest aktualizowany przy modyfikacji listy linków z poziomu Panelu administracyjnego.');
@define('PLUGIN_LINKLIST_ENABLED_NAME', 'W³±cz');
@define('PLUGIN_LINKLIST_ENABLED_DESC', 'W³±cz wtyczkê');
@define('PLUGIN_LINKLIST_DELETE_WARN', 'Kiedy kategoria jest usuwana, wszystkie linki do niej przynale¿ne zostan± przeniesione do kategorii g³ównej drzewa linków.');

//
//  serendipity_plugin_linklist.php
//
@define('PLUGIN_LINKS_NAME', 'Lista linków');
@define('PLUGIN_LINKS_BLAHBLAH', 'Manad¿er linków - pokazuje Twoje ulubione linki w Panelu bocznym.');
@define('PLUGIN_LINKS_TITLE', 'Tytu³');
@define('PLUGIN_LINKS_TITLE_BLAHBLAH', 'Wprowad¼ tytu³/nazwê sekcji z linkami (bêdzie widoczna w Panelu bocznym)');
@define('PLUGIN_LINKS_TOP_LEVEL', 'Tekst pocz±tkowy');
@define('PLUGIN_LINKS_TOP_LEVEL_BLAHBLAH', 'Wprowad¼ dowolny tekst, jaki ma byæ pokazywany przed list± linków (mo¿na to pole pozostawiæ puste)');
@define('PLUGIN_LINKS_DIRECTXML', 'Wprowadzaj XML bezpo¶rednio');
@define('PLUGIN_LINKS_DIRECTXML_BLAHBLAH', 'Mo¿esz wprowadzaæ dane XML bezpo¶rednio (samodzielnie) lub u¿yæ strony web zarz±dzaj±cej linkami');
@define('PLUGIN_LINKS_LINKS', 'Linki');
@define('PLUGIN_LINKS_LINKS_BLAHBLAH', 'u¿ywaj XML! - dla katalogów u¿yj sk³adni "<dir name="dirname"> i zamykaj u¿ywaj±c </dir> - dla linków u¿ywaj sk³adni "<link name="nazwa linku" link="http://link.com/" />');
@define('PLUGIN_LINKS_OPENALL', 'Otwórz wszystkie');
@define('PLUGIN_LINKS_OPENALL_BLAHBLAH', 'Wprowad¼ tekst dla linku "Otwórz wszystkie"');
@define('PLUGIN_LINKS_OPENALL_DEFAULT', 'Otwórz wszystkie');
@define('PLUGIN_LINKS_CLOSEALL', 'Zamknij wszystkie');
@define('PLUGIN_LINKS_CLOSEALL_BLAHBLAH', 'Wprowad¼ tekst dla linku "Zamknij wszystkie"');
@define('PLUGIN_LINKS_CLOSEALL_DEFAULT', 'Zamknij wszystkie');
@define('PLUGIN_LINKS_SHOW', 'Pokazuj linki "Otwórz wszystkie" i "Zamknij wszystkie"');
@define('PLUGIN_LINKS_SHOW_BLAHBLAH', 'Czy chcesz umie¶ciæ w Panelu bocznym linki do "Otwórz wszystkie" i "Zamknij wszystkie"?');
@define('PLUGIN_LINKS_LOCATION', 'Lokalizacja linków "Otwórz wszystkie" i "Zamknij wszystkie"');
@define('PLUGIN_LINKS_LOCATION_BLAHBLAH', 'Gdzie linki "Otwórz wszystkie" i "Zamknij wszystkie" maj± byæ umieszczone? Nad czy pod list± linków?');
@define('PLUGIN_LINKS_LOCATION_TOP', 'Nad');
@define('PLUGIN_LINKS_LOCATION_BOTTOM', 'Pod');
@define('PLUGIN_LINKS_SELECTION', 'U¿ywaj selekcji');
@define('PLUGIN_LINKS_SELECTION_BLAHBLAH', 'Je¶li zaznaczysz "Tak", ga³êzie drzewa linków mog± byæ zaznaczane (pod¶wietlane)');
@define('PLUGIN_LINKS_COOKIE', 'U¿ywaj cookies (ciasteczek)');
@define('PLUGIN_LINKS_COOKIE_BLAHBLAH', 'Je¶li zaznaczysz "Tak", drzewo linków bêdzie u¿ywa³o cookies (ciasteczek) do zapamiêtania swojego stanu');
@define('PLUGIN_LINKS_LINE', 'U¿ywaj linii');
@define('PLUGIN_LINKS_LINE_BLAHBLAH', 'Je¶li zaznaczysz "Tak", drzewo linków bêdzie rysowane przy pomocy linii');
@define('PLUGIN_LINKS_ICON', 'U¿ywaj ikon');
@define('PLUGIN_LINKS_ICON_BLAHBLAH', 'Je¶li zaznaczysz "Tak", drzewo linków bêdzie rysowane przy pomocy ikon');
@define('PLUGIN_LINKS_STATUS', 'U¿ywaj tekstu w panelu statusu przegl±darki');
@define('PLUGIN_LINKS_STATUS_BLAHBLAH', 'Je¶li zaznaczysz "Tak", nazwy ga³êzi drzewa bêd± pokazywane w panelu statusu przegl±darki zamiast adresu URL');
@define('PLUGIN_LINKS_CLOSELEVEL', 'Zamknij ten sam poziom');
@define('PLUGIN_LINKS_CLOSELEVEL_BLAHBLAH', 'Je¶li zaznaczysz "Tak", tylko jedna ga³±¼ drzewa linków mo¿e byæ otwarta w danym momencie. Linki "Otwórz wszystkie" i "Zamknij wszystkie" nie dzia³aj± kiedy to ustawienie jest w³±czone.');
@define('PLUGIN_LINKS_TARGET', 'Cel');
@define('PLUGIN_LINKS_TARGET_BLAHBLAH', 'Docelowe miejsce dla linków - mo¿e byæ zdefioniowane jako "_blank", "_self", "_top", "_parent" lub mo¿esz wprowadziæ nazwê ramki (frame)');
@define('PLUGIN_LINKS_IMGDIR', 'Uzyj katalogu wtyczki, w nim znajduj± siê odpowiednie obrazki');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH', 'Je¶li zaznaczysz "Tak", wtyczka za³o¿y, ¿e potrzebne jej do prawid³owego wy¶wietlania obrazki znajduj± siê w katalogu wtyczki. Je¶li zaznaczysz "Nie", wtyczka jako katalog obrazków wska¿e katalog "/templates/default/img/". Wy³±czenie ¶ciezki do obrazków jest wymagane przy wspó³dzielonych instalacjach lecz wymaga tak¿e rêcznego przeniesienia obrazków do odpowiedniego katalogu.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME', 'Drzewo kategorii otwarte czy zamkniête?');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_DESC', 'Przy u¿ywaniu sortowania Kategoriami mo¿esz ustawiæ czy wszystkie ga³êzie drzewa linków bêd± standardowo otwarte czy zamkniête');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_CLOSED', 'Zamkniête');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_OPEN', 'Otwarte');
@define('PLUGIN_LINKLIST_OUTSTYLE_DTREE', 'dtree');
@define('PLUGIN_LINKLIST_OUTSTYLE_CSS', 'Lista CSS');
@define('PLUGIN_LINKLIST_ORDER_OUTSTYLE_SIMP_CSS', 'Prosty CSS');
@define('PLUGIN_LINKS_OUTSTYLE', 'Wybierz styl wy¶wietlania dla listy linków');
@define('PLUGIN_LINKS_OUTSTYLE_BLAHBLAH', 'Wybierz styl wy¶wietlania dla listy linków. Dtree u¿ywa javascriptu do tworzenia drzewa linków (skrypt dzia³a we wszystkich popularnych przegl±darkach). Lista CSS u¿ywa divów i prostego javascriptu dla stworzenia efektu uzyskiwanego przez zastosowanie Dtree ale nie jest tak zaawansowany jak Dtree. Prosty CSS to metoda najlepsza je¶li chcesz by wyszukiwarki parsowa³y linki umieszczone na Twojej stronie. Prosty CSS wy¶wietli kontrolowan± przez CSS listê. UWAGA! Metody z u¿yciem Dtree zazwyczaj NIE umozliwiaj± wyszukiwarkom interentowym na parsowanie wy¶wietlanych przez nie linków.');

