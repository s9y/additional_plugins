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
@define('PLUGIN_EVENT_FREETAG_DESC', 'Umo¿liwia dowolne tagowanie wpisów');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', 'Wprowad¼ dowolne pasuj±ce tagi. Rozdzielaj tagi przecinkami (,).');
@define('PLUGIN_EVENT_FREETAG_LIST', 'Tagi dla tego wpisu: %s');
@define('PLUGIN_EVENT_FREETAG_USING', 'Wpisy otagowane jako %s');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', 'Tagi powi±zane z tagiem %s');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED', 'Brak powi±zanych tagów.');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', 'Wszystkie zdefiniowane tagi');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', 'Zarz±dzaj tagami');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', 'Zarz±dzaj wszystkimi tagami');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', 'Zarz±dzaj tagami \'Leaf\' (pojedynczymi)');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', 'Lista nieotagowanych wpisów');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', 'Lista wpisów z tagami \'Leaf\'');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', 'Nie ma nieotagowanych wpisów!');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', 'Tag');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', 'Waga');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', 'Akcja');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', 'Zmieñ nazwê');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', 'Rozdziel');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', 'Usuñ');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', 'Na pewno chcesz usun±æ tag %s?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'u¿yj przecinka by rozdzieliæ tagi:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', 'Pokazaæ tag cloud (chmurê tagów) do powi±zanych wpisów?');

//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'Tagi');
@define('PLUGIN_FREETAG_BLAHBLAH', 'Pokazuje listê tagów zdefiniowanych dla wpisów');
@define('PLUGIN_FREETAG_NEWLINE', 'Przej¶cie do nowej linii po ka¿dym tagu?');
@define('PLUGIN_FREETAG_XML', 'Pokazywaæ ikony XML?');
@define('PLUGIN_FREETAG_SCALE', 'Skalowaæ rozmiar czcionki w zale¿no¶ci od popularno¶ci taga (jak w serwisach Technorati czy flickr)?');
@define('PLUGIN_FREETAG_UPGRADE1_2', 'Poprawiono %d tagów dla wpisu numer: %d');
@define('PLUGIN_FREETAG_MAX_TAGS', 'Jak wiele tagów ma byæ pokazywanych?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'Jak wiele razy musi wyst±piæ dany tag, by by³ pokazywany na li¶cie?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'Minimalny rozmiar czcionki w procentach (%) w chmurze tagów (tag cloud)');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'Maksymalny rozmiar czcionki w procentach (%) w chmurze tagów (tag cloud)');

@define('PLUGIN_FREETAG_META_KEYWORDS', 'Ilo¶æ s³ów kluczowych meta umieszczanych w ¼ródle HTML (0: wy³±czenie opcji)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Powi±zane wpisy wedlug tagów:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED', 'Wy¶wietlaæ wpisy powi±zane wed³ug tagów?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT', 'Jak wiele powi±zanych wpisów ma byæ pokazywanych?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', 'Pokazywaæ tagi w stopce wpisu?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', 'Je¶li opcja jest w³±czona, tagi bêd± pokazywane w stopce wpisu. Je¶li opcja bêdzie wy³±czona, tagi zostan± umieszczone w tre¶ci (na samym dole) wpisu lub rozszerzonej tre¶ci wpisu.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', 'Poka¿ tagi tylko ma³ymi literami');

