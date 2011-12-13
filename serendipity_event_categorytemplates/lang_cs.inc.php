<?php # lang_cs.inc.php 1.0 2009-06-26 18:37:13 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/26
 */

@define('PLUGIN_CATEGORYTEMPLATES_NAME', 'Vlastnosti/šablona vzhledu pro kategorie');
@define('PLUGIN_CATEGORYTEMPLATES_DESC', 'Tento plugin poskytuje pøídavné vlastnosti pro kategorie a v nich obsažené pøíspìvky, vèetnì volitené šablony vzhledu, poøadí øazení, poèet zobrazených pøíspìvkù, ochranu heslem a schovávání RSS kanálu.');
@define('PLUGIN_CATEGORYTEMPLATES_SELECT', 'Zadejte prosím název adresáøe se šablonou, kterou chcete použít pro tuto kategorii. Relativní cesta zaèíná v adresáøi "templates/". Takže mùžete zadat napøíklad "blue" nebo "kubrick". Mùžete použít také název podadresáøe, pokud jste uložili šablonu v podadresáøi jiné šablony. Pak zadáváte "blue/kategorie1" nebo "blue/kategorie2".');
@define('PLUGIN_CATEGORYTEMPLATES_FETCHLIMIT', 'Pøíspìvky zobrazené na výchozí stránce kategorie');
@define('PLUGIN_CATEGORYTEMPLATES_PASS', 'Ochrana heslem:');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_DESC', 'Má být zapnuta ochrana kategorií heslem? Nevýhoda je, že se kvùli zaheslovanému pøístupu musí provést jeden dotaz do databáze navíc a že pøíspìvky v kategoriích chránìných heslem se nezobrazují na výchozí stránce blogu dokud uživatel nezobrazí chránìnou kategorii.');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_USER', 'Ochrana kategorie heslem');
@define('PLUGIN_CATEGORYTEMPLATES_FIXENTRY', 'Globální nastavení kategorie pøíspìvku');
@define('PLUGIN_CATEGORYTEMPLATES_FIXENTRY_DESC', 'Pokud je zapnuto, kategorie pøíspìvku pøi zobrazení jediného pøíspìvku bude nastavena jako aktuální kategorie.');
@define('PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE', 'Poøadí šablon kategorií');
@define('PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE_DESC', 'Pokud je pøíspìvek pøiøazen do více kategorií, tento seznam urèuje, která šablona bude použita. Šablona pro kategorii, která je nejvýše, bude použita.');
@define('PLUGIN_CATEGORYTEMPLATES_NO_CUSTOMIZED_CATEGORIES', 'Žádné kategorie ještì nemají vlastní šablonu.');
@define('PLUGIN_CATEGORYTEMPLATES_HIDERSS', 'Pøíspìvky v této kategorii se nebudou zobrazovat v RSS kanálu');