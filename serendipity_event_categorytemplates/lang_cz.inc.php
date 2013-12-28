<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/26
 */

@define('PLUGIN_CATEGORYTEMPLATES_NAME', 'Vlastnosti/¹ablona vzhledu pro kategorie');
@define('PLUGIN_CATEGORYTEMPLATES_DESC', 'Tento plugin poskytuje pøídavné vlastnosti pro kategorie a v nich obsa¾ené pøíspìvky, vèetnì volitené ¹ablony vzhledu, poøadí øazení, poèet zobrazených pøíspìvkù, ochranu heslem a schovávání RSS kanálu.');
@define('PLUGIN_CATEGORYTEMPLATES_SELECT', 'Zadejte prosím název adresáøe se ¹ablonou, kterou chcete pou¾ít pro tuto kategorii. Relativní cesta zaèíná v adresáøi "templates/". Tak¾e mù¾ete zadat napøíklad "blue" nebo "kubrick". Mù¾ete pou¾ít také název podadresáøe, pokud jste ulo¾ili ¹ablonu v podadresáøi jiné ¹ablony. Pak zadáváte "blue/kategorie1" nebo "blue/kategorie2".');
@define('PLUGIN_CATEGORYTEMPLATES_FETCHLIMIT', 'Pøíspìvky zobrazené na výchozí stránce kategorie');
@define('PLUGIN_CATEGORYTEMPLATES_PASS', 'Ochrana heslem:');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_DESC', 'Má být zapnuta ochrana kategorií heslem? Nevýhoda je, ¾e se kvùli zaheslovanému pøístupu musí provést jeden dotaz do databáze navíc a ¾e pøíspìvky v kategoriích chránìných heslem se nezobrazují na výchozí stránce blogu dokud u¾ivatel nezobrazí chránìnou kategorii.');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_USER', 'Ochrana kategorie heslem');
@define('PLUGIN_CATEGORYTEMPLATES_FIXENTRY', 'Globální nastavení kategorie pøíspìvku');
@define('PLUGIN_CATEGORYTEMPLATES_FIXENTRY_DESC', 'Pokud je zapnuto, kategorie pøíspìvku pøi zobrazení jediného pøíspìvku bude nastavena jako aktuální kategorie.');
@define('PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE', 'Poøadí ¹ablon kategorií');
@define('PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE_DESC', 'Pokud je pøíspìvek pøiøazen do více kategorií, tento seznam urèuje, která ¹ablona bude pou¾ita. ©ablona pro kategorii, která je nejvý¹e, bude pou¾ita.');
@define('PLUGIN_CATEGORYTEMPLATES_NO_CUSTOMIZED_CATEGORIES', '®ádné kategorie je¹tì nemají vlastní ¹ablonu.');
@define('PLUGIN_CATEGORYTEMPLATES_HIDERSS', 'Pøíspìvky v této kategorii se nebudou zobrazovat v RSS kanálu');