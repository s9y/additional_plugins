<?php # lang_cs.inc.php 1.0 2009-06-21 19:22:14 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/21
 */

@define('PLUGIN_EVENT_STARTCAT_NAME', 'Kategorie na výchozí stránce');
@define('PLUGIN_EVENT_STARTCAT_DESC', 'Umožòuje zobrazovat na výchozí stránce blogu pøíspìvky pouze z jedné kategorie');
@define('PLUGIN_EVENT_STARTCAT_CATEGORY_NAME', 'Výchozí kategorie');
@define('PLUGIN_EVENT_STARTCAT_CATEGORY_DESC', 'Vyberte kategorii, která se bude zobrazovat na výchozí stránce blogu.');
@define('PLUGIN_EVENT_STARTCAT_HIDECATEGORY_NAME', 'Výchozí skrytá galerie');
@define('PLUGIN_EVENT_STARTCAT_HIDECATEGORY_DESC', 'Vyberte kategorii, který má být na výchozí stránce schována (použije se pouze pokud nejsou vybrána žádné "výchozí kategorie"). Tato volba vyžaduje alespoò Serendipity 1.0-alpha1.');
@define('PLUGIN_EVENT_STARTCAT_MULTICATEGORY_NAME', 'Více výchozích kategorií');
@define('PLUGIN_EVENT_STARTCAT_MULTICATEGORY_DESC', 'Pokud chcete na výchozí stránce blogu zobrazit více kategorií, zadjte zde jejich ID identifikátory oddìlené støedníkem ";". ID kategorie zjistíte v administraèní sekci, pokud nalistujete seznam kategorií a podržíte chvilku myš nad názvem kategorie. Tato volba pøepíše ruèní výbìr kategorií výše.');
@define('PLUGIN_EVENT_STARTCAT_MULTIHIDECATEGORY_NAME', 'Více výchozích skrytých kategorií');
@define('PLUGIN_EVENT_STARTCAT_MULTIHIDECATEGORY_DESC', 'Pokud chcete z výchozí stránky blogu skrýt více kategorií, zadejte zde ID identifikátory tìchto kategorií oddìlené støedníkem ";". Tato volba pøepíše ruèní výbìr kategorií viz výše. Tato volba vyžaduje alespoò Serendipity 1.0-alpha1.');
@define('PLUGIN_EVENT_STARTCAT_REMEMBERCAT_NAME', 'Umožnit návštìvníkùm zapamatovat si vybranou kategorii?');
@define('PLUGIN_EVENT_STARTCAT_REMEMBERCAT_DESC', 'Pokud je povoleno, pak se kategorie, kterou návštìvník blogu vybere, uloží do cookie a z ní se naète pøi další návštìvì.');