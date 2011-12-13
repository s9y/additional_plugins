<?php # lang_cs.inc.php 1.0 2009-06-26 18:37:13 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/26
 */

@define('PLUGIN_CATEGORYTEMPLATES_NAME', 'Vlastnosti/šablona vzhledu pro kategorie');
@define('PLUGIN_CATEGORYTEMPLATES_DESC', 'Tento plugin poskytuje přídavné vlastnosti pro kategorie a v nich obsažené příspěvky, včetně volitené šablony vzhledu, pořadí řazení, počet zobrazených příspěvků, ochranu heslem a schovávání RSS kanálu.');
@define('PLUGIN_CATEGORYTEMPLATES_SELECT', 'Zadejte prosím název adresáře se šablonou, kterou chcete použít pro tuto kategorii. Relativní cesta začíná v adresáři "templates/". Takže můžete zadat například "blue" nebo "kubrick". Můžete použít také název podadresáře, pokud jste uložili šablonu v podadresáři jiné šablony. Pak zadáváte "blue/kategorie1" nebo "blue/kategorie2".');
@define('PLUGIN_CATEGORYTEMPLATES_FETCHLIMIT', 'Příspěvky zobrazené na výchozí stránce kategorie');
@define('PLUGIN_CATEGORYTEMPLATES_PASS', 'Ochrana heslem:');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_DESC', 'Má být zapnuta ochrana kategorií heslem? Nevýhoda je, že se kvůli zaheslovanému přístupu musí provést jeden dotaz do databáze navíc a že příspěvky v kategoriích chráněných heslem se nezobrazují na výchozí stránce blogu dokud uživatel nezobrazí chráněnou kategorii.');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_USER', 'Ochrana kategorie heslem');
@define('PLUGIN_CATEGORYTEMPLATES_FIXENTRY', 'Globální nastavení kategorie příspěvku');
@define('PLUGIN_CATEGORYTEMPLATES_FIXENTRY_DESC', 'Pokud je zapnuto, kategorie příspěvku při zobrazení jediného příspěvku bude nastavena jako aktuální kategorie.');
@define('PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE', 'Pořadí šablon kategorií');
@define('PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE_DESC', 'Pokud je příspěvek přiřazen do více kategorií, tento seznam určuje, která šablona bude použita. Šablona pro kategorii, která je nejvýše, bude použita.');
@define('PLUGIN_CATEGORYTEMPLATES_NO_CUSTOMIZED_CATEGORIES', 'Žádné kategorie ještě nemají vlastní šablonu.');
@define('PLUGIN_CATEGORYTEMPLATES_HIDERSS', 'Příspěvky v této kategorii se nebudou zobrazovat v RSS kanálu');