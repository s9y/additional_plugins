<?php # lang_cz.inc.php 1.3 2011-08-04 20:43:33 VladaAjgl $

/**
 *  @version 1.3
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/07
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/09/23
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/11/21
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/08/04
 */

@define('PLUGIN_AMAZON_TITLE',              'Doporučení Amazon');
@define('PLUGIN_AMAZON_DESC',               'Doporučené produkty z Amazon v rámci partnerského programu Amazon');
@define('PLUGIN_AMAZON_PROP_TITLE',         'Nadpis');
@define('PLUGIN_AMAZON_PROP_TITLE_DESC',    'Nadpis bloku s doporučeními Amazon');
@define('PLUGIN_AMAZON_ASIN',               'Seznam ASIN');
@define('PLUGIN_AMAZON_ASIN_DESC',          'Seznam ASIN (oddělené čárkou), které chcete doporučovat');
@define('PLUGIN_AMAZON_ASIN_CNT',           'Kolik produktů se má zobrazovat?');

// Next lines were translated on 2009/09/23

@define('PLUGIN_AMAZON_NEW_WINDOW',         'Otvírat odkazy v novém okně');
@define('PLUGIN_AMAZON_SMALL_MED',          'Velikost zobrazených náhledů');
@define('PLUGIN_AMAZON_SMALL',              'Malé');
@define('PLUGIN_AMAZON_MEDIUM',             'Střední');
@define('PLUGIN_AMAZON_LARGE',              'Velké');
@define('PLUGIN_AMAZON_SIDEBAR_CACHE',      'Čas cachování');
@define('PLUGIN_AMAZON_SIDEBAR_CACHE_DESC', 'Počet minut na cachování výstupu pluginu. Požadavky na Amazon jsou cachovány po 24 hodinách, zatímco zobrazený text je cachován po 60 minutách. Toto nastavení umožňuje lehké zvýšení výkonu tím, že se nebude aktualizovat výstup podle serveru Amazon během doby cachování. Vypněte cachování nastavením "0".');
@define('PLUGIN_AMAZON_SERVER',             'Výchozí server');
@define('PLUGIN_AMAZON_SERVER_DESC',        'Server Amazon, který hodláte použít');
@define('PLUGIN_AMAZON_GERMANY',            'Německo');
@define('PLUGIN_AMAZON_JAPAN',              'Japonsko');
@define('PLUGIN_AMAZON_UK',                 'Velká Británie');
@define('PLUGIN_AMAZON_US',                 'USA');
@define('PLUGIN_AMAZON_CA',                 'Kanada');
@define('PLUGIN_AMAZON_FR',                 'Francie');
@define('PLUGIN_AMAZON_DEPENDS_ON',         'Tento plugin závisí na pluginu událostí <a href="http://spartacus.s9y.org/index.php?mode=bygroups_event_en#group_BACKEND_EDITOR" >Amazon Media Button</a>. Nainstaujte prosím zmíněný plugin a nastavte ho pro připojení k Amazonu.');

// Next lines were translated on 2011/08/04
@define('PLUGIN_AMAZON_TRACK_GOOGLE',       'Sledování kliků pomocí Google Analytics');
@define('DESC_PLUGIN_AMAZON_TRACK_GOOGLE',  'Vyžaduje nainstalovaný plugin Google Analytics.');