<?php # lang_cs.inc.php 1.2 2012-09-09 20:18:05 VladaAjgl $

/**
 *  @version 1.2
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2010/05/22
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/07/09
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/09/09
 */
@define('PLUGIN_FLATTR_NAME', 'Flattr');
@define('PLUGIN_FLATTR_DESC', 'Flattr je platforma pro sociální mikroplatby, která umožňuje zobrazit oblibu věcí, které máte rádi. Tento plugin vkládá do příspěvků a RSS kanálů známky "Flattr" (Flattr Badges). U každého příspěvku můžete jednotlivě zadat volby flattru. Pokud tak neučiníte, použije se globální nastavení.');

@define('PLUGIN_FLATTR_USER', 'Uživatelské ID (požádejte o něj na www.falttr.com)');

@define('PLUGIN_FLATTR_PLACEMENT_FOOTER', 'Patička příspěvku');
@define('PLUGIN_FLATTR_PLACEMENT_SMARTY', 'Proměnná smarty {$entry.flattr}, pro šablonu entries.tpl');
@define('PLUGIN_FLATTR_PLACEMENT', 'Kam umístit známku Flattr (Flattr Badge)');

@define('PLUGIN_FLATTR_BUTTON', 'Styl známky Flattr ("výchozí" nebo "kompaktní")');
@define('PLUGIN_FLATTR_CATS', 'Kategorie příspěvku Flattr');
@define('PLUGIN_FLATTR_LANG', 'Jazyk příspěvku Flattr');
@define('PLUGIN_FLATTR_DSC', 'Popis příspěvku Flattr (výchozí je tělo příspěvku)');
@define('PLUGIN_FLATTR_TAG', 'Tagy příspěvku flattr (výchozí hodnota je přebíraná z pluginu freetag, pokud ho používáte)');

@define('PLUGIN_FLATTR_ACTIVE', 'Povolit Flattr');

// Next lines were translated on 2011/07/09

@define('PLUGIN_FLATTR_BUTTON_DESC', 'Pokud zadáte cokoliv jiného než "výchozí" nebo "kompaktní", tento text bude použite pro statické tlačítko. Můžete zde zadat například "Klikněte zde pro Flattr".');

// Next lines were translated on 2012/09/09
@define('PLUGIN_FLATTR_POPOUT', 'Zobrazovat popup okno během pohybu myši nad tlačítkem Flattr');
@define('PLUGIN_FLATTR_ADD_TO_FEED', 'Přidat tlačítko "Flattr" do kanálů RSS/ATOM?');