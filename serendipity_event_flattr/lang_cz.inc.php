<?php # lang_cz.inc.php 1.3 2013-04-10 19:08:49 VladaAjgl $

/**
 *  @version 1.3
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
@define('PLUGIN_FLATTR_DESC', 'Flattr je platforma pro sociální mikroplatby, která ètenáøi umo¾òuje ocenit drobným pøíspìvkem obsah, který se mu líbí. Tento plugin vkládá do pøíspìvkù a RSS kanálù tlaèítka "Flattr" (tzv. Flattr Badges). U ka¾dého pøíspìvku mù¾ete jednotlivì zadat nastavení Flattru. Pokud tak neuèiníte, pou¾ije se globální nastavení.');

@define('PLUGIN_FLATTR_USER', 'U¾ivatelské ID (pokud vám jako ID nefunguje u¾ivatelské jméno pro Flattr, po¾ádejte o nìj na www.flattr.com)');

@define('PLUGIN_FLATTR_PLACEMENT_FOOTER', 'Patièka pøíspìvku');
@define('PLUGIN_FLATTR_PLACEMENT_SMARTY', 'Promìnná Smarty {$entry.flattr}, pro ¹ablonu entries.tpl');
@define('PLUGIN_FLATTR_PLACEMENT', 'Kam umístit tlaèítko Flattr');

@define('PLUGIN_FLATTR_BUTTON', 'Styl tlaèítka Flattr ("default" nebo "compact")');
@define('PLUGIN_FLATTR_CATS', 'Kategorie pøíspìvku pro Flattr');
@define('PLUGIN_FLATTR_LANG', 'Jazyk pøíspìvku pro Flattr');
@define('PLUGIN_FLATTR_DSC', 'Popis pøíspìvku pro Flattr (jako výchozí hodnota je pou¾it text pøíspìvku)');
@define('PLUGIN_FLATTR_TAG', 'Tagy pro Flattr (výchozí hodnota je pøebíraná z pluginu freetag, pokud ho pou¾íváte)');

@define('PLUGIN_FLATTR_ACTIVE', 'Povolit Flattr');

// Next lines were translated on 2011/07/09

@define('PLUGIN_FLATTR_BUTTON_DESC', 'Pokud zadáte cokoliv jiného ne¾ "default" (výchozí vzhled) nebo "compact" (kompaktní vzhled), bude zde zadaný text pou¾it pro statické tlaèítko. Mù¾ete zde zadat napøíklad "Kliknìte zde pro Flattr".');

// Next lines were translated on 2012/09/09

@define('PLUGIN_FLATTR_POPOUT', 'Zobrazovat popup okno bìhem pohybu my¹i nad tlaèítkem Flattr');
@define('PLUGIN_FLATTR_ADD_TO_FEED', 'Pøidat tlaèítko Flattr do kanálu RSS/ATOM?');