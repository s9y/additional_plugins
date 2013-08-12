<?php # 

/**
 *  @version $Revision$
 *  @author Kostas CoSTa Brzezinski <costa@kofeina.net>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_staticpage.php
//
@define('STATICPAGE_HEADLINE', 'Nag³ówek');
@define('STATICPAGE_HEADLINE_BLAHBLAH', 'Pokazuje nag³ówek nad zawarto¶ci± Strony statycznej, taki sam jak w normalnych wpisach');
@define('STATICPAGE_TITLE', 'Strony statyczne');
@define('STATICPAGE_TITLE_BLAHBLAH', 'Pokazuje Strony statyczne w Twoim blogu tak, jak pokazywane s± wszystkie inne wpisy (z zachowaniem formatowania i layoutu). Dodaje now± zak³adkê w menu w Panelu administracyjnym.');
@define('CONTENT_BLAHBLAH', 'Zawarto¶æ');
@define('STATICPAGE_PERMALINK', 'Permalink');
@define('STATICPAGE_PERMALINK_BLAHBLAH', 'Definiuje permalinka dla URLa. Wymaga absolutnej ¶cie¿ki HTTP i musi koñczyæ siê rozszerzeniem .htm lub .html!');
@define('STATICPAGE_PAGETITLE', 'Krótka nazwa URLa (kompatybilno¶æ wsteczna)');
@define('STATICPAGE_ARTICLEFORMAT', 'Formatowaæ jak wpis?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH', 'Je¶li tak, zawarto¶æ Strony statycznej jest formatowana jak ka¿dy inny wpis (kolory, ramki itd.) (domy¶lnie: tak)');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE', 'Tytu³ strony w trybie "Formatowaæ jak wpis"');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH', 'U¿ywaj±c formatowania jak ka¿dy inny wpis, mo¿esz zdecydowaæ jaki tekst wpisaæ w miejscu, w którym zazwyczaj pokazuje siê data wpisu');
@define('STATICPAGE_SELECT', 'Wybierz Stronê statyczn± do edycji lub stworzenia');
@define('STATICPAGE_PASSWORD_NOTICE', 'Ta strona jest chroniona has³em. Proszê, wpisz prawid³owe has³o, które zosta³o Ci przekazane:');
@define('STATICPAGE_PARENTPAGES_NAME', 'Strona nadrzêdna');
@define('STATICPAGE_PARENTPAGE_DESC', 'wybierz stronê nadrzêdn±');
@define('STATICPAGE_PARENTPAGE_PARENT', 'Jest nadrzêdna');
@define('STATICPAGE_AUTHORS_NAME', 'Imiê autora');
@define('STATICPAGE_AUTHORS_DESC', 'Ten autor jest w³a¶cicielem tej strony');
@define('STATICPAGE_FILENAME_NAME', 'Schemat (Smarty)');
@define('STATICPAGE_FILENAME_DESC', 'Wpisz nazwe pliku/katalogu Schematu, który ma byæ u¿yty dla tej strony. Ten plik/katalog mo¿e znajdowaæ siê w katalogu wtyczki Strony statyczne lub w katalogu Schematu, z którego korzystasz.');
@define('STATICPAGE_SHOWCHILDPAGES_NAME', 'Pokazuj strony potomne');
@define('STATICPAGE_SHOWCHILDPAGES_DESC', 'Poka¿ wszystkie strony potomne jako spis linków');
@define('STATICPAGE_PRECONTENT_NAME', 'Tre¶æ poprzedzaj±ca');
@define('STATICPAGE_PRECONTENT_DESC', 'Poka¿ tê tre¶æ przed list± stron potomnych');
@define('STATICPAGE_CANNOTDELETE_MSG', 'Nie mogê usun±æ tej strony. W bazie znajduj± siê strony potomne dla tej strony, proszê je wpierw usun±æ.');
@define('STATICPAGE_IS_STARTPAGE', 'Ustaw tê stronê jako strone g³ów± Twojej strony');
@define('STATICPAGE_IS_STARTPAGE_DESC', 'Je¶li ustawisz tê stronê jako stronê g³ówn± swojego serwisu, zamiast zwyczajowej strony startowej Serendipity poka¿e tê stronê jako stronê startow± Twojej witryny. Tylko jedna strona mo¿e byæ stron± startow±! Je¶li chcesz linkowaæ do standardowej strony startowej, musisz u¿yæ konstrukcji "index.php?frontpage". Je¶li chcesz u¿ywaæ tej funcji, upewnij siê, ¿e ¿adne inne wtyczki wspieraj±ce mechanizm permalinków (np. G³osowanie, Ksiêga go¶ci) nie znajduj± siê przed wtyczk± Strony statyczne w Kolejce wtyczek Serendipity (upewnij siê, ¿e wtyczka jest wy¿ej (czyli znajduje siê wcze¶niej w kolejce zadañ wykonywanych przez silnik strony) od innych wtyczek korzystaj±cych z permalinków).');
@define('STATICPAGE_TOP', 'Do góry');
@define('STATICPAGE_NEXT', 'Nastêpny');
@define('STATICPAGE_PREV', 'Poprzedni');
@define('STATICPAGE_LINKNAME', 'Edycja');

@define('STATICPAGE_ARTICLETYPE', 'Typ wpisu');
@define('STATICPAGE_ARTICLETYPE_DESC', 'Wybierz typ Strony statycznej');

@define('STATICPAGE_CATEGORY_PAGEORDER', 'Kolejno¶æ stron');
@define('STATICPAGE_CATEGORY_PAGES', 'Edytuj strony');
@define('STATICPAGE_CATEGORY_PAGETYPES', 'Typy stron');
@define('STATICPAGE_CATEGORY_PAGEADD', 'Inne wtyczki');

@define('PAGETYPES_SELECT', 'Wybierz typ strony');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION', 'Opis:');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC', 'Opisz ten typ strony');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE', 'Nazwa schematu:');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC', 'Nazwa Schematu. Schemat mo¿e znajdowaæ siê w katalogu wtyczki Strony statyczne lub w domy¶lnym katalogu ze Schematami.');
@define('STATICPAGE_ARTICLETYPE_IMAGE', '¦cie¿ka do obrazka:');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC', 'URL do obrazka');

@define('STATICPAGE_SHOWNAVI', 'Poka¿ nawigacjê');
@define('STATICPAGE_SHOWNAVI_DESC', 'Poka¿ pasek nawigacyjny na tej stronie');
@define('STATICPAGE_SHOWONNAVI', 'Poka¿ w menu nawigacyjnym w Panelu bocznym');
@define('STATICPAGE_SHOWONNAVI_DESC', 'Poka¿ tê stronê w menu nawigacyjnym (o ile takowe jest w³±czone), które bêdzie siê pokazywa³o w Panelu bocznym (bêd± tam zawarte tylko Strony statyczne)');

@define('STATICPAGE_SHOWNAVI_DEFAULT', 'Poka¿ nawigacjê');
@define('STATICPAGE_DEFAULT_DESC', 'Domy¶lne ustawienie dla nowych stron');
@define('STATICPAGE_SHOWONNAVI_DEFAULT', 'Poka¿ w menu nawigacyjnym w Panelu bocznym');
@define('STATICPAGE_SHOWMARKUP_DEFAULT', 'Poka¿ Markup');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT', 'Formatuj jak wpis');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT', 'Poka¿ strony potomne');

@define('STATICPAGE_PAGEORDER_DESC', 'Tu mo¿esz zmieniæ kolejno¶æ Stron statycznych');
@define('STATICPAGE_PAGEADD_DESC', 'Wybierz wtyczkê, któr± chcesz umie¶ciæ jako link w menu nawigacyjnym Stron statycznych.');
@define('STATICPAGE_PAGEADD_PLUGINS', 'Nastêpuj±ce wtyczki mog± byæ umieszczone w w menu nawigacyjnym w Panelu bocznym:');

@define('STATICPAGE_PUBLISHSTATUS', 'Status publikacji');
@define('STATICPAGE_PUBLISHSTATUS_DESC', 'Status publikacji tej strony');
@define('STATICPAGE_PUBLISHSTATUS_DRAFT', 'Szkic');
@define('STATICPAGE_PUBLISHSTATUS_PUBLISHED', 'Publikacja');

@define('STATICPAGE_SHOWTEXTORHEADLINE_NAME', 'Poka¿ nag³ówek lub Poprzedni/Nastêpny w pasku nawigacyjnym');
@define('STATICPAGE_SHOWTEXTORHEADLINE_DESC', '');
@define('STATICPAGE_SHOWTEXTORHEADLINE_TEXT', 'Tekst: Poprzedni/Nastêpny');
@define('STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE', 'Nag³ówek');

@define('STATICPAGE_LANGUAGE', 'Jêzyk');
@define('STATICPAGE_LANGUAGE_DESC', 'wybierz jêzyk tej strony');

@define('STATICPAGE_PLUGINS_INSTALLED', 'wtyczka jest zainstalowana');
@define('STATICPAGE_PLUGIN_AVAILABLE', 'Wtyczka jest dostêpna lecz nie zainstalowana');
@define('STATICPAGE_PLUGIN_NOTAVAILABLE', 'wtyczka jest niedostêpna');

@define('STATICPAGE_SEARCHRESULTS', 'Znaleziono %d Stron statycznych:');

@define('LANG_ALL', 'Wszystkie jêzyki');
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
@define('PLUGIN_STATICPAGELIST_NAME_DESC', 'Ta wtyczka pokazuje konfigurowaln± listê Stron statycznych (menu). Wymaga wtyczki Strony statyczne w wersji minimum 1.22.');
@define('PLUGIN_STATICPAGELIST_TITLE', 'Tytu³');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC', 'Wpisz tytu³ pozycji w Panelu bocznym, w której uka¿± siê linki menu do Stron statycznych');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT', 'Strony statyczne');
@define('PLUGIN_STATICPAGELIST_LIMIT', 'Ilo¶æ pokazywanych stron');
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC', 'Wpisz ilo¶æ pokazywanych stron statycznych w menu. 0 oznacza brak limitów.');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME',	'Poka¿ link do strony g³ównej');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC', 'Czy w menu ma byc pokazany link do strony g³ównej?');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME', 'Strona g³ówna');
@define('PLUGIN_LINKS_IMGDIR', 'Uzyj katalogu wtyczki, w nim znajduj± siê odpowiednie obrazki');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH', 'Podaj ¶cie¿kê URL, której wtyczka ma u¿ywaæ przy szukaniu obrazków wizualizuj±cych uk³ad menu. Podkatalog "img" musi znajdowaæ siê w miejscu wskazywanym przez ¶cie¿kê. Taki podkatalog znajduje siê w katalogu wtyczki Strony statyczne. W razie w±tpliwo¶ci pozostaw domy¶lne ustawienie.');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_NAME', 'Ikony czy czysty tekst');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_DESC', 'Pokazywaæ strukturê menu graficznie czy w formie czystego tekstu?');
@define('PLUGIN_STATICPAGELIST_ICON', 'graficznie');
@define('PLUGIN_STATICPAGELIST_TEXT', 'czysty tekst');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY', 'Pokazywaæ tylko strony nadrzêdne?');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY_DESC', 'Je¶li opcja zostanie w³±czona, w strukturze menu pojawi± siê tylko strony oznaczone jako "nadrzêdne". Wy³±czenie opcji poka¿e tak¿e strony "potomne" w strukturze menu.');
@define('PLUGIN_STATICPAGELIST_IMG_NAME', 'W³±czyæ graficzn± reprezentacjê struktury menu');

?>
