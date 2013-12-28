<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2010/05/22
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/07/09
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/09/09
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/10
 */
@define('PLUGIN_FLATTR_NAME', 'Flattr');
@define('PLUGIN_FLATTR_DESC', 'Flattr je platforma pro sociální mikroplatby, která čtenáři umožňuje ocenit drobným příspěvkem obsah, který se mu líbí. Tento plugin vkládá do příspěvků a RSS kanálů tlačítka "Flattr" (tzv. Flattr Badges). U každého příspěvku můžete jednotlivě zadat nastavení Flattru. Pokud tak neučiníte, použije se globální nastavení.');

@define('PLUGIN_FLATTR_USER', 'Uživatelské ID (pokud vám jako ID nefunguje uživatelské jméno pro Flattr, požádejte o něj na www.flattr.com)');

@define('PLUGIN_FLATTR_PLACEMENT_FOOTER', 'Patička příspěvku');
@define('PLUGIN_FLATTR_PLACEMENT_SMARTY', 'Proměnná Smarty {$entry.flattr}, pro šablonu entries.tpl');
@define('PLUGIN_FLATTR_PLACEMENT', 'Kam umístit tlačítko Flattr');

@define('PLUGIN_FLATTR_BUTTON', 'Styl tlačítka Flattr ("default" nebo "compact")');
@define('PLUGIN_FLATTR_CATS', 'Kategorie příspěvku pro Flattr');
@define('PLUGIN_FLATTR_LANG', 'Jazyk příspěvku pro Flattr');
@define('PLUGIN_FLATTR_DSC', 'Popis příspěvku pro Flattr (jako výchozí hodnota je použit text příspěvku)');
@define('PLUGIN_FLATTR_TAG', 'Tagy pro Flattr (výchozí hodnota je přebíraná z pluginu freetag, pokud ho používáte)');

@define('PLUGIN_FLATTR_ACTIVE', 'Povolit Flattr');

// Next lines were translated on 2011/07/09

@define('PLUGIN_FLATTR_BUTTON_DESC', 'Pokud zadáte cokoliv jiného než "default" (výchozí vzhled) nebo "compact" (kompaktní vzhled), bude zde zadaný text použit pro statické tlačítko. Můžete zde zadat například "Klikněte zde pro Flattr".');

// Next lines were translated on 2012/09/09

@define('PLUGIN_FLATTR_POPOUT', 'Zobrazovat popup okno během pohybu myši nad tlačítkem Flattr');
@define('PLUGIN_FLATTR_ADD_TO_FEED', 'Přidat tlačítko Flattr do kanálu RSS/ATOM?');