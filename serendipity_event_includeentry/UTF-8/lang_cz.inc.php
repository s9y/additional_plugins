<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/07
 */

@define('PLUGIN_EVENT_INCLUDEENTRY_NAME',     'Markup: Vložení příspěvku/šablony/bloku');
@define('PLUGIN_EVENT_INCLUDEENTRY_DESC',     'Umožňuje přidat do příspěvku tagy, které zajistí vložení část jiného příspěvku. Použijte tuto značku: [s9y-include-entry:XXX:YYY]. Nahraďte XXX číslem ID odkazovaného příspěvku a YYY nahraďte názvem pole příspěvku, které chcete vložit (např. "body", "title", "extended", ...). Také můžete využít nové funkce menu pro správu šablon a bloků, které je možno vložit mezi příspěvky.');
@define('PLUGIN_EVENT_INCLUDEENTRY_BLOCKS',   'Bloky šablon');
@define('PLUGIN_EVENT_INCLUDEENTRY_DBVERSION', '1.0');
@define('PLUGIN_EVENT_INCLUDEENTRY_FILENAME_NAME', 'Šablona (Smarty)');
@define('PLUGIN_EVENT_INCLUDEENTRY_FILENAME_DESC', 'Zadejte jméno souboru šablony, která se má použít pro tuto stránku. Šablona smarty může být umístěna v adresáři tohoto pluginu nebo v adresáři Vaší šablony.');
@define('STATICBLOCK_SELECT_TEMPLATES', 'Vyberte šablonu');
@define('STATICBLOCK_SELECT_BLOCKS', 'Vyberte blok');
@define('STATICBLOCK_EDIT_TEMPLATES', 'Upravit šablonu');
@define('STATICBLOCK_EDIT_BLOCKS', 'Upravit blok');
@define('STATICBLOCK_USE', 'Použít šablonu');
@define('STATICBLOCK_ATTACH', 'Přidat statický blok: ');

@define('STATICBLOCK_RANDOMIZE', 'Zobrazovat náhodné bloky');
@define('STATICBLOCK_RANDOMIZE_DESC', 'Pokud je zapnuto, bloky budou náhodně vloženy za příspěvky.');
@define('STATICBLOCK_FIRST_SHOW', 'První příspěvek');
@define('STATICBLOCK_FIRST_SHOW_DESC', 'Zadejte počet příspěvků, po kterých začnou být vkládány náhodné bloky. "1" vloží náhodný blok za první příspěvek, "2" za druhý atp.');
@define('STATICBLOCK_SHOW_SKIP', 'Přeskočit příspěvky');
@define('STATICBLOCK_SHOW_SKIP_DESC', 'Zadejte počet příspěvků, po kterých se má znovu vřadit náhodný blok. "1" bude zobrazovat náhodný blok po každém příspěvku, "2" pouze po každých dvou příspěvcích.');

@define('STATICBLOCK_SHOW_MULTI', 'Povolit vícenásobné bloky');
@define('STATICBLOCK_SHOW_MULTI_DESC', 'Pokud vložíte blok do příspěvku, má přesto funkce náhodné vkládání bloků vkládat bloky po příspěvku? Pokud je nastaveno "Ne", každý příspěvek nebude obsahovat více než jeden náhodný blok.');

?>
