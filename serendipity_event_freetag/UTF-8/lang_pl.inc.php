<?php # 

/**
 *  @version $Revision$
 *  Kostas CoSTa Brzezinski <costa@kofeina.net>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', 'Tagowanie wpisów');
@define('PLUGIN_EVENT_FREETAG_DESC', 'Umożliwia dowolne tagowanie wpisów');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', 'Wprowadź dowolne pasujące tagi. Rozdzielaj tagi przecinkami (,).');
@define('PLUGIN_EVENT_FREETAG_LIST', 'Tagi dla tego wpisu: %s');
@define('PLUGIN_EVENT_FREETAG_USING', 'Wpisy otagowane jako %s');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', 'Tagi powiązane z tagiem %s');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED', 'Brak powiązanych tagów.');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', 'Wszystkie zdefiniowane tagi');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', 'Zarządzaj tagami');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', 'Zarządzaj wszystkimi tagami');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', 'Zarządzaj tagami \'Leaf\' (pojedynczymi)');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', 'Lista nieotagowanych wpisów');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', 'Lista wpisów z tagami \'Leaf\'');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', 'Nie ma nieotagowanych wpisów!');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', 'Tag');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', 'Waga');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', 'Akcja');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', 'Zmień nazwę');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', 'Rozdziel');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', 'Usuń');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', 'Na pewno chcesz usunąć tag %s?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'użyj przecinka by rozdzielić tagi:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', 'Pokazać tag cloud (chmurę tagów) do powiązanych wpisów?');

//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'Tagi');
@define('PLUGIN_FREETAG_BLAHBLAH', 'Pokazuje listę tagów zdefiniowanych dla wpisów');
@define('PLUGIN_FREETAG_NEWLINE', 'Przejście do nowej linii po każdym tagu?');
@define('PLUGIN_FREETAG_XML', 'Pokazywać ikony XML?');
@define('PLUGIN_FREETAG_SCALE', 'Skalować rozmiar czcionki w zależności od popularności taga (jak w serwisach Technorati czy flickr)?');
@define('PLUGIN_FREETAG_UPGRADE1_2', 'Poprawiono %d tagów dla wpisu numer: %d');
@define('PLUGIN_FREETAG_MAX_TAGS', 'Jak wiele tagów ma być pokazywanych?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'Jak wiele razy musi wystąpić dany tag, by był pokazywany na liście?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'Minimalny rozmiar czcionki w procentach (%) w chmurze tagów (tag cloud)');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'Maksymalny rozmiar czcionki w procentach (%) w chmurze tagów (tag cloud)');

@define('PLUGIN_FREETAG_META_KEYWORDS', 'Ilość słów kluczowych meta umieszczanych w źródle HTML (0: wyłączenie opcji)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Powiązane wpisy wedlug tagów:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED', 'Wyświetlać wpisy powiązane według tagów?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT', 'Jak wiele powiązanych wpisów ma być pokazywanych?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', 'Pokazywać tagi w stopce wpisu?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', 'Jeśli opcja jest włączona, tagi będą pokazywane w stopce wpisu. Jeśli opcja będzie wyłączona, tagi zostaną umieszczone w treści (na samym dole) wpisu lub rozszerzonej treści wpisu.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', 'Pokaż tagi tylko małymi literami');

