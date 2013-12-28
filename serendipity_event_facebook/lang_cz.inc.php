<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2011/04/17
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/21
 */

@define('PLUGIN_EVENT_FACEBOOK_NAME',               'Facebook (experimentální!)');
@define('PLUGIN_EVENT_FACEBOOK_DESC',               'Importuje do blogu komentáøe u pøíspìvkù na facebooku (pomocí RSS Graffiti). Také do blogu vlo¾í facebookové OpenGraph Meta-Tagy. Pamatujte, ¾e pøidání talèítka "Líbí se mi" k pøíspìvkùm blogu je zaji¹»ováno pluginem serendipity_event_findmore!');

@define('PLUGIN_EVENT_FACEBOOK_HOWTO', 'Komentáøe jsou importovány k pøíspìvkùm blogu pøiøazením URL adresy odkazu na facebook (odkazy musí být veøejné!), pro toto zpìtné volání je pou¾ita nastavená adresa Serendipity blogu (koøenová URL). Tento plugin mù¾e být spu¹tìn pomocí pluginu cronjob, nebo pomocí ruèního volání cronu (napø. wget) pøes blog (index.php?/plugin/facebookcomments).');

@define('PLUGIN_EVENT_FACEBOOK_MODERATE',           'Mají být komentáøe z facebooku schvalovány?');

@define('PLUGIN_EVENT_FACEBOOK_USERS', 'U¾ivatelské jméno (jména) na facebooku');
@define('PLUGIN_EVENT_FACEBOOK_USERS_DESC', 'Zadejte va¹e u¾ivatelské jméno nebo ID k facebooku, které má být spøa¾ené s blogem. Pamatujte, ¾e pouze veøejné úèty/pøíspìvky/komentáøe mohou být získány pomocí Facebook Graph API. Více u¾ivatelských jmen/ID mù¾e být vlo¾eno pomocí oddìlovaèe "," (èárka).');

@define('PLUGIN_EVENT_FACEBOOK_VIA', 'Který øetìzec se má pøidávat k facebookovým komentáøùm?');

@define('PLUGIN_EVENT_FACEBOOK_LIMIT', 'Kolik graph API polo¾ek se má stahovat');
@define('PLUGIN_EVENT_FACEBOOK_LIMIT_DESC', 'Zadejte, kolik polo¾ek má vracet Facebook API request. Obvykle staèí posledních 25 polo¾ek. Pokud máte èasto aktualizovaný facebookový úèet, mo¾ná budete chtít zvìt¹it limit. Èím vìt¹í limit bude, tím déle bude trvat aktualizace pomocí graph API.');

@define('PLUGIN_AGGREGATOR_CRONJOB', 'Tento plugin vyu¾ívá Serendipity plugin Cronjob. Nainstalujte jej, pokud potøebujete vyu¾ívat pravidelnì opakované aktualizace.');