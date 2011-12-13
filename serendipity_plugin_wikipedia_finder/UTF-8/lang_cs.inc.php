<?php # lang_cs.inc.php 1.0 2009-05-06 21:53:44 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/06
 */

@define('PLUGIN_WIKIPEDIAFINDER_TITLE',                     'Hledání na wikipedii');
@define('PLUGIN_WIKIPEDIAFINDER_DESC',                      'Vyber pojem (slovo nebo větu) a klikněte na ikonu. Pojem bude vyhledán na Wikipedii.');
@define('PLUGIN_WIKIPEDIAFINDER_PROMPT',                    'Zadejte pojem (slovo nebo větu), který má být vyhledán na Wikipedii.');        
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TITLE',                'Nadpis');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TITLE_DESC',           'Nadpis postranního bloku');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_SITE',                 'Stránka Wikipedie');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_SITE_DESC' ,           'URL Wikipedie, která má být použita pro vyhledávání.');
@define('PLUGIN_WIKIPEDIAFINDER_SITE' ,                     'http://en.wikipedia.org');        
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR',                'Barva pozadí šablony');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR_DESC' ,          'Je pozadí šablony světlé nebo tmavé? Nezbytné pro grafický výběr Wikipedie.');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR_DARK' ,          'Tmavé pozadí');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR_LIGHT' ,         'Světlé pozadí');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TARGET',               'Cílové okno');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW',             'Název okna, které otevírá Javacsript');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TARGET_DESC' ,         'Pokud má být Wikipedia otevřená v novém okně, zde můžete zadat jméno tohoto nově otevřeného okna (např. "wikipedia"). Toto nastavení přepisuje "' . PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW .'".');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_DESC',        'Pomocí Javascriptu může být otevřeno nové okno, které bude obsahovat Wikipedii. Výhoda je, že lze řídit výšku a šířku nového okna. Pokud je vybrané "Ano", pak toto nastavení přepíše "' . PLUGIN_WIKIPEDIAFINDER_PROP_TARGET . '".');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_HEIGHT',      'Javascript: Výška okna');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_HEIGHT_DESC', 'Výška nově otevřeného okna s Wikipedií. Použije se pouze pokud je vybráno "'.PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW .'".');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_WIDTH',       'Javascript: Šířka okna');
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_WIDTH_DESC',  'Šířka nově otevřeného okna s Wikipedií. Použije se pouze pokud je vybráno "'.PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW .'".');

?>
