/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2011/04/17
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/21
 */

@define('PLUGIN_EVENT_FACEBOOK_NAME',               'Facebook (experimentální!)');
@define('PLUGIN_EVENT_FACEBOOK_DESC',               'Importuje do blogu komentáøe u pøíspìvkù na facebooku (pomocí RSS Graffiti). Také do blogu vloí facebookové OpenGraph Meta-Tagy. Pamatujte, e pøidání talèítka "Líbí se mi" k pøíspìvkùm blogu je zajišováno pluginem serendipity_event_findmore!');

@define('PLUGIN_EVENT_FACEBOOK_HOWTO', 'Komentáøe jsou importovány k pøíspìvkùm blogu pøiøazením URL adresy odkazu na facebook (odkazy musí bıt veøejné!), pro toto zpìtné volání je pouita nastavená adresa Serendipity blogu (koøenová URL). Tento plugin mùe bıt spuštìn pomocí pluginu cronjob, nebo pomocí ruèního volání cronu (napø. wget) pøes blog (index.php?/plugin/facebookcomments).');

@define('PLUGIN_EVENT_FACEBOOK_MODERATE',           'Mají bıt komentáøe z facebooku schvalovány?');

@define('PLUGIN_EVENT_FACEBOOK_USERS', 'Uivatelské jméno (jména) na facebooku');
@define('PLUGIN_EVENT_FACEBOOK_USERS_DESC', 'Zadejte vaše uivatelské jméno nebo ID k facebooku, které má bıt spøaené s blogem. Pamatujte, e pouze veøejné úèty/pøíspìvky/komentáøe mohou bıt získány pomocí Facebook Graph API. Více uivatelskıch jmen/ID mùe bıt vloeno pomocí oddìlovaèe "," (èárka).');

@define('PLUGIN_EVENT_FACEBOOK_VIA', 'Kterı øetìzec se má pøidávat k facebookovım komentáøùm?');

@define('PLUGIN_EVENT_FACEBOOK_LIMIT', 'Kolik graph API poloek se má stahovat');
@define('PLUGIN_EVENT_FACEBOOK_LIMIT_DESC', 'Zadejte, kolik poloek má vracet Facebook API request. Obvykle staèí posledních 25 poloek. Pokud máte èasto aktualizovanı facebookovı úèet, moná budete chtít zvìtšit limit. Èím vìtší limit bude, tím déle bude trvat aktualizace pomocí graph API.');

@define('PLUGIN_AGGREGATOR_CRONJOB', 'Tento plugin vyuívá Serendipity plugin Cronjob. Nainstalujte jej, pokud potøebujete vyuívat pravidelnì opakované aktualizace.');