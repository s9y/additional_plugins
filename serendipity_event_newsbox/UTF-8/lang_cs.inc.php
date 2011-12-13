<?php # lang_cs.inc.php 1.0 2009-07-14 19:58:10 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/14
 */

@define('PLUGIN_EVENT_NEWSBOX_TITLE', 'Blok s novinkami');
@define('PLUGIN_EVENT_NEWSBOX_DESC', 'Seskupte příspěvky z jedné kategorie na výchozí stránce blogu do jednoho bloku místo obvyklého výpisu příspěvků. Podporuje vnořené bloky s novinkami.');
@define('PLUGIN_EVENT_NEWSBOX_TITLEFIELD', 'Nadpis');
@define('PLUGIN_EVENT_NEWSBOX_TITLEFIELD_DESC', 'Nadpis zobrazující se u tohoto bloku s novinkami');
@define('PLUGIN_EVENT_NEWSBOX_DEFAULT_TITLE', 'Novinky');
@define('PLUGIN_EVENT_NEWSBOX_CONTENTTYPE', 'Co se bude zobrazovat v tomto bloku s novinkami?');
@define('PLUGIN_EVENT_NEWSBOX_CONTENTTYPE_DESC', 'Tento blok s novinkami může obsahovat kategorie nebo jiné bloky s novinkami.');
@define('PLUGIN_EVENT_NEWSBOX_NEWSCATS', 'Které kategorie bude obsahovat tento blok?');
@define('PLUGIN_EVENT_NEWSBOX_NEWSCATS_DESC', 'Pokud se rozhodnete, že má blok obsahovat kategorie, můžete je zde vybrat. Můžete vybrat více kategorií najednou. Příspěvky z těchto kategorií se nebudou zobrazovat ve výpisu příspěvků na výchozí straně, nýbrž v tomto bloku.');
@define('PLUGIN_EVENT_NEWSBOX_NUMENTRIES', 'Počet příspěvků');
@define('PLUGIN_EVENT_NEWSBOX_NUMENTRIES_DESC', 'Pokud tento blok obsahuje kategorie, zadejte zde maximální počet příspěvků, kteér se budou v bloku zobrazovat.');
@define('PLUGIN_EVENT_NEWSBOX_PLACEMENT', 'Umístění');
@define('PLUGIN_EVENT_NEWSBOX_PLACEMENT_DESC', 'Kde bude blok s novinkami umístěn? Blok můžete umístit na začátek nebo na konec seznamu příspěvků, do hlavičky stránky, do patičky, do jiného bloku s novinkami a nebo ho skrýt. Skryté bloky se nikde nezobrazují. Bloky, které obsahují samy sebe se také nikdy nezobraí. V šablonách/stylech vzhledu, které nepodporují bloky s novinkami, se mohou bloky zobrazovat ošklivě, pokud nejsou zobrazeny nad ostatními příspěvky.');
@define('PLUGIN_EVENT_NEWSBOX_PLACEMENT_PAGE_TOP', 'Záhlaví stránky');
@define('PLUGIN_EVENT_NEWSBOX_PLACEMENT_ENTRY_TOP', 'Před příspěvky');
@define('PLUGIN_EVENT_NEWSBOX_PLACEMENT_ENTRY_BOTTOM', 'Za příspěvky');
@define('PLUGIN_EVENT_NEWSBOX_PLACEMENT_PAGE_BOTTOM', 'Patička stránky');
@define('PLUGIN_EVENT_NEWSBOX_PLACEMENT_HIDDEN', '*SKRYTÝ*');

?>
