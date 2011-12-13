<?php # lang_cs.inc.php 1.0 2009-05-06 21:53:44 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/06
 */

@define('PLUGIN_WIKIPEDIAFINDER_TITLE',                     'Hledání na wikipedii');
@define('PLUGIN_WIKIPEDIAFINDER_DESC',                      'Vyber pojem (slovo nebo vìtu) a kliknìte na ikonu. Pojem bude vyhledán na Wikipedii.');
@define('PLUGIN_WIKIPEDIAFINDER_PROMPT',                    'Zadejte pojem (slovo nebo vìtu), který má být vyhledán na Wikipedii.');        
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TITLE',                'Nadpis');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TITLE_DESC',           'Nadpis postranního bloku');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_SITE',                 'Stránka Wikipedie');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_SITE_DESC' ,           'URL Wikipedie, která má být použita pro vyhledávání.');
@define('PLUGIN_WIKIPEDIAFINDER_SITE' ,                     'http://en.wikipedia.org');        
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR',                'Barva pozadí šablony');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR_DESC' ,          'Je pozadí šablony svìtlé nebo tmavé? Nezbytné pro grafický výbìr Wikipedie.');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR_DARK' ,          'Tmavé pozadí');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR_LIGHT' ,         'Svìtlé pozadí');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TARGET',               'Cílové okno');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW',             'Název okna, které otevírá Javacsript');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TARGET_DESC' ,         'Pokud má být Wikipedia otevøená v novém oknì, zde mùžete zadat jméno tohoto novì otevøeného okna (napø. "wikipedia"). Toto nastavení pøepisuje "' . PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW .'".');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_DESC',        'Pomocí Javascriptu mùže být otevøeno nové okno, které bude obsahovat Wikipedii. Výhoda je, že lze øídit výšku a šíøku nového okna. Pokud je vybrané "Ano", pak toto nastavení pøepíše "' . PLUGIN_WIKIPEDIAFINDER_PROP_TARGET . '".');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_HEIGHT',      'Javascript: Výška okna');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_HEIGHT_DESC', 'Výška novì otevøeného okna s Wikipedií. Použije se pouze pokud je vybráno "'.PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW .'".');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_WIDTH',       'Javascript: Šíøka okna');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_WIDTH_DESC',  'Šíøka novì otevøeného okna s Wikipedií. Použije se pouze pokud je vybráno "'.PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW .'".');

?>
