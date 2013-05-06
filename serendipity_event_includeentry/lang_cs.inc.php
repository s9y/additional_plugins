<?php # lang_cs.inc.php 1.1 2013-05-05 12:45:54 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/07
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/05/05
 */

@define('PLUGIN_EVENT_INCLUDEENTRY_NAME',     'Markup: Vložení pøíspìvku/šablony/bloku');
@define('PLUGIN_EVENT_INCLUDEENTRY_DESC',     'Umožòuje pøidat do pøíspìvku tagy, které zajistí vložení èásti jiného pøíspìvku. Použijte tuto znaèku: [s9y-include-entry:XXX:YYY]. Nahraïte XXX èíslem ID odkazovaného pøíspìvku a YYY nahraïte názvem pole pøíspìvku, které chcete vložit (napø. "body", "title", "extended", ...). Také mùžete využít nové funkce menu pro správu šablon a blokù, které je možno vložit mezi pøíspìvky.');
@define('PLUGIN_EVENT_INCLUDEENTRY_BLOCKS',   'Bloky šablon');
@define('PLUGIN_EVENT_INCLUDEENTRY_DBVERSION', '1.0');
@define('PLUGIN_EVENT_INCLUDEENTRY_FILENAME_NAME', 'Šablona (Smarty)');
@define('PLUGIN_EVENT_INCLUDEENTRY_FILENAME_DESC', 'Zadejte jméno souboru šablony, která se má použít pro tuto stránku. Šablona smarty mùže být umístìna v adresáøi tohoto pluginu nebo v adresáøi Vaší šablony.');
@define('STATICBLOCK_SELECT_TEMPLATES', 'Vyberte šablonu');
@define('STATICBLOCK_SELECT_BLOCKS', 'Vyberte blok');
@define('STATICBLOCK_EDIT_TEMPLATES', 'Upravit šablonu');
@define('STATICBLOCK_EDIT_BLOCKS', 'Upravit blok');
@define('STATICBLOCK_USE', 'Použít šablonu');
@define('STATICBLOCK_ATTACH', 'Pøidat statický blok: ');

@define('STATICBLOCK_RANDOMIZE', 'Zobrazovat náhodné bloky');
@define('STATICBLOCK_RANDOMIZE_DESC', 'Pokud je zapnuto, bloky budou náhodnì vloženy za pøíspìvky.');
@define('STATICBLOCK_FIRST_SHOW', 'První pøíspìvek');
@define('STATICBLOCK_FIRST_SHOW_DESC', 'Zadejte poèet pøíspìvkù, po kterých zaènou být vkládány náhodné bloky. "1" vloží náhodný blok za první pøíspìvek, "2" za druhý atp.');
@define('STATICBLOCK_SHOW_SKIP', 'Pøeskoèit pøíspìvky');
@define('STATICBLOCK_SHOW_SKIP_DESC', 'Zadejte poèet pøíspìvkù, po kterých se má znovu vøadit náhodný blok. "1" bude zobrazovat náhodný blok po každém pøíspìvku, "2" pouze po každých dvou pøíspìvcích.');

@define('STATICBLOCK_SHOW_MULTI', 'Povolit vícenásobné bloky');
@define('STATICBLOCK_SHOW_MULTI_DESC', 'Pokud vložíte blok do pøíspìvku, má pøesto funkce náhodné vkládání blokù vkládat bloky po pøíspìvku? Pokud je nastaveno "Ne", každý pøíspìvek nebude obsahovat více než jeden náhodný blok.');