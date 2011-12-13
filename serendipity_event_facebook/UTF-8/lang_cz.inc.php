<?php # lang_cz.inc.php 1.0 2011-04-17 14:10:45 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2011/04/17
 */

@define('PLUGIN_EVENT_FACEBOOK_NAME',               'Facebook (experimentální!)');
@define('PLUGIN_EVENT_FACEBOOK_DESC',               'Importuje do blogu komentáře u příspěvků na facebooku (pomocí RSS Graffiti). Také do blogu vloží facebookové OpenGraph Meta-Tagy. Pamatujte, že přidání talčítka "Líbí se mi" k příspěvkům blogu je zajišťováno pluginem serendipity_event_findmore!');

@define('PLUGIN_EVENT_FACEBOOK_HOWTO', 'Komentáře jsou importovány k příspěvkům blogu přiřazením URL adresy odkazu na facebook (odkazí musí být veřejné!), pro toto zpětné volání je použita nastavená adresa Serendipity blogu (kořenová URL). Tento plugin nemůže být spuštěn pomocí pluginu cronjob, ani pomocí ručního volání cronu (např. wget) přes blog (index.php?/plugin/facebookcomments).');

@define('PLUGIN_EVENT_FACEBOOK_MODERATE',           'Mají být komentáře z facebooku schvalovány?');

@define('PLUGIN_EVENT_FACEBOOK_USERS', 'Uživatelské jméno (jména) na facebooku');
@define('PLUGIN_EVENT_FACEBOOK_USERS_DESC', 'Zadejte vaše uživatelské jméno nebo ID k facebooku, které má být spřažené s blogem. Pamatujte, že pouze veřejné účty/příspěvky/komentáře mohou být získány pomocí Facebook Graph API. Více uživatelských jmen/ID může být vloženo pomocí oddělovače "," (čárka).');

@define('PLUGIN_EVENT_FACEBOOK_VIA', 'Který řetězec se má přiávat k facebookovým komentářům?');

@define('PLUGIN_EVENT_FACEBOOK_LIMIT', 'Kolik graph API položek se má stahovat');
@define('PLUGIN_EVENT_FACEBOOK_LIMIT_DESC', 'Zadejte, kolik položek má vracet Facebook API request. Obvykle stačí posledních 25 položek. Pokud máte často aktualizovaný facebookový účet, možná budete chtít zvětšit limit. Čím větší limit bude, tím déle bude trvat aktualizace pomocí graph API.');

@define('PLUGIN_AGGREGATOR_CRONJOB', 'Tento plugin využívá Serendipity plugin Cronjob. Nainstalujte jej, pokud potřebujete využívat pravidelně opakované aktualizace.');