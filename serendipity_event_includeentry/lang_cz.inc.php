<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/07
 */

@define('PLUGIN_EVENT_INCLUDEENTRY_NAME',     'Markup: Vlo¾ení pøíspìvku/¹ablony/bloku');
@define('PLUGIN_EVENT_INCLUDEENTRY_DESC',     'Umo¾òuje pøidat do pøíspìvku tagy, které zajistí vlo¾ení èást jiného pøíspìvku. Pou¾ijte tuto znaèku: [s9y-include-entry:XXX:YYY]. Nahraïte XXX èíslem ID odkazovaného pøíspìvku a YYY nahraïte názvem pole pøíspìvku, které chcete vlo¾it (napø. "body", "title", "extended", ...). Také mù¾ete vyu¾ít nové funkce menu pro správu ¹ablon a blokù, které je mo¾no vlo¾it mezi pøíspìvky.');
@define('PLUGIN_EVENT_INCLUDEENTRY_BLOCKS',   'Bloky ¹ablon');
@define('PLUGIN_EVENT_INCLUDEENTRY_DBVERSION', '1.0');
@define('PLUGIN_EVENT_INCLUDEENTRY_FILENAME_NAME', '©ablona (Smarty)');
@define('PLUGIN_EVENT_INCLUDEENTRY_FILENAME_DESC', 'Zadejte jméno souboru ¹ablony, která se má pou¾ít pro tuto stránku. ©ablona smarty mù¾e být umístìna v adresáøi tohoto pluginu nebo v adresáøi Va¹í ¹ablony.');
@define('STATICBLOCK_SELECT_TEMPLATES', 'Vyberte ¹ablonu');
@define('STATICBLOCK_SELECT_BLOCKS', 'Vyberte blok');
@define('STATICBLOCK_EDIT_TEMPLATES', 'Upravit ¹ablonu');
@define('STATICBLOCK_EDIT_BLOCKS', 'Upravit blok');
@define('STATICBLOCK_USE', 'Pou¾ít ¹ablonu');
@define('STATICBLOCK_ATTACH', 'Pøidat statický blok: ');

@define('STATICBLOCK_RANDOMIZE', 'Zobrazovat náhodné bloky');
@define('STATICBLOCK_RANDOMIZE_DESC', 'Pokud je zapnuto, bloky budou náhodnì vlo¾eny za pøíspìvky.');
@define('STATICBLOCK_FIRST_SHOW', 'První pøíspìvek');
@define('STATICBLOCK_FIRST_SHOW_DESC', 'Zadejte poèet pøíspìvkù, po kterých zaènou být vkládány náhodné bloky. "1" vlo¾í náhodný blok za první pøíspìvek, "2" za druhý atp.');
@define('STATICBLOCK_SHOW_SKIP', 'Pøeskoèit pøíspìvky');
@define('STATICBLOCK_SHOW_SKIP_DESC', 'Zadejte poèet pøíspìvkù, po kterých se má znovu vøadit náhodný blok. "1" bude zobrazovat náhodný blok po ka¾dém pøíspìvku, "2" pouze po ka¾dých dvou pøíspìvcích.');

@define('STATICBLOCK_SHOW_MULTI', 'Povolit vícenásobné bloky');
@define('STATICBLOCK_SHOW_MULTI_DESC', 'Pokud vlo¾íte blok do pøíspìvku, má pøesto funkce náhodné vkládání blokù vkládat bloky po pøíspìvku? Pokud je nastaveno "Ne", ka¾dý pøíspìvek nebude obsahovat více ne¾ jeden náhodný blok.');

?>
