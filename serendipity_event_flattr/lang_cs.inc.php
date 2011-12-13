<?php # lang_cs.inc.php 1.1 2011-07-09 12:17:39 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2010/05/22
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/07/09
 */
@define('PLUGIN_FLATTR_NAME', 'Flattr');
@define('PLUGIN_FLATTR_DESC', 'Flattr je platforma pro sociální mikroplatby, která umožòuje zobrazit oblibu vìcí, které máte rádi. Tento plugin vkládá do pøíspìvkù a RSS kanálù známky "Flattr" (Flattr Badges). U každého pøíspìvku mùžete jednotlivì zadat volby flattru. Pokud tak neuèiníte, použije se globální nastavení.');

@define('PLUGIN_FLATTR_USER', 'Uživatelské ID (požádejte o nìj na www.falttr.com)');

@define('PLUGIN_FLATTR_PLACEMENT_FOOTER', 'Patièka pøíspìvku');
@define('PLUGIN_FLATTR_PLACEMENT_SMARTY', 'Promìnná smarty {$entry.flattr}, pro šablonu entries.tpl');
@define('PLUGIN_FLATTR_PLACEMENT', 'Kam umístit známku Flattr (Flattr Badge)');

@define('PLUGIN_FLATTR_BUTTON', 'Styl známky Flattr ("výchozí" nebo "kompaktní")');
@define('PLUGIN_FLATTR_CATS', 'Kategorie pøíspìvku Flattr');
@define('PLUGIN_FLATTR_LANG', 'Jazyk pøíspìvku Flattr');
@define('PLUGIN_FLATTR_DSC', 'Popis pøíspìvku Flattr (výchozí je tìlo pøíspìvku)');
@define('PLUGIN_FLATTR_TAG', 'Tagy pøíspìvku flattr (výchozí hodnota je pøebíraná z pluginu freetag, pokud ho používáte)');

@define('PLUGIN_FLATTR_ACTIVE', 'Povolit Flattr');

// Next lines were translated on 2011/07/09
@define('PLUGIN_FLATTR_BUTTON_DESC', 'Pokud zadáte cokoliv jiného než "výchozí" nebo "kompaktní", tento text bude použite pro statické tlaèítko. Mùžete zde zadat napøíklad "Kliknìte zde pro Flattr".');