<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/05
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/12/25
 */

@define('PLUGIN_AGGREGATOR_TITLE', 'RSS agregátor');
@define('PLUGIN_AGGREGATOR_DESC', 'Zobrazuje zprávy z mnoha RSS kanálù. DÙLEŽITÁ POZNÁMKA: Aktualizace a "krmení" agregátoru je v souèasnosti nutno dìlat ruènì pomocí Cronjobs nebo podobnì. Volejte následující adresu v libovolných èasových intervalech: ' . $serendipity['baseURL'] . 'index.php?/plugin/aggregator');
@define('PLUGIN_AGGREGATOR_FEEDNAME', 'Název RSS kanálu');
@define('PLUGIN_AGGREGATOR_FEEDNAME_DESC', 'Zobrazovaný název RSS kanálu.');
@define('PLUGIN_AGGREGATOR_FEEDURI', 'URI adresa RSS kanálu');
@define('PLUGIN_AGGREGATOR_FEEDURI_DESC', 'Adresa RSS kanálu.');
@define('PLUGIN_AGGREGATOR_HTMLURI', 'Domovská stránka - URI adresa');
@define('PLUGIN_AGGREGATOR_HTMLURI_DESC', 'HTML adresa kanálu.');
@define('PLUGIN_AGGREGATOR_CATEGORIES', 'Kategorie');

@define('PLUGIN_AGGREGATOR_FEEDLIST', 'Toto je seznam použitelných kanálù. Jednotilvé kanály mùžete zadat ruènì a stisknout tlaèítko "GO" ("Provést"), nebo mùžete importovat celý OPML soubor. Kanály mohou být smazány zadáním prázdné hodnoty do názvuv nebo URL adresy kanálu. Nové kanály mohou být pøidány jako poslední øádka tabulky.');
@define('PLUGIN_AGGREGATOR_FEEDUPDATE', 'Poslední aktualizace');
@define('PLUGIN_AGGREGATOR_FEED_MISSINGDATA', 'Musíte zadat jméno a URL adresu RSS kanálu.');
@define('PLUGIN_AGGREGATOR_EXPORTFEEDLIST', 'Exportovat OPML seznam RSS kanálù');
@define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST', 'Importovat OPML seznam RSS kanálù');
@define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST_DESC', 'Zadejte URL adresu k OPML soubor (souèasné nastavení RSS kanálù bude ZRUŠENO a pøepsáno importovanými kanály!). Pokud zaškrtnete vobu "Import kategorií", bude z OMPL souboru do blogu importována i struktura kategorií.');
@define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST_BUTTON', 'Importovat OPML!');
@define('PLUGIN_AGGREGATOR_EXPORTFEEDLIST_BUTTON', 'Exportovat OPML!');
@define('PLUGIN_AGGREGATOR_IMPORTCATEGORIES', 'Importovat kategorie');
@define('PLUGIN_AGGREGATOR_IMPORTCATEGORIES2', 'Zaøadit každý RSS kanál do vlastní kategorie');
@define('PLUGIN_AGGREGATOR_CATEGORYSKIPPED', 'Pøeskakuji vytváøení kategorie "%s", protože už existuje.');

@define('PLUGIN_AGGREGATOR_EXPIRE', 'Vypršení platnosti obsahu');
@define('PLUGIN_AGGREGATOR_EXPIRE_BLAHBLAH', 'Platnost obsahu v databázi vyprší po uplynutí n dní (0 = žádné vypršení platnosti).');
@define('PLUGIN_AGGREGATOR_EXPIRE_MD5', 'Kontrolní souèty pro expiraci');
@define('PLUGIN_AGGREGATOR_EXPIRE_MD5_BLAHBLAH', 'Kontrolní sumy se používají ke kontrole èlánkù bez data na duplikáty. Po kolika dnech mají kontrolní souèty vypršet? (90 = doporuèená hodnota, 0 = nikdy).');
@define('PLUGIN_AGGREGATOR_DELETEDEPENDENCIES', 'Odstranit závislé pøíspìvky?');
@define('PLUGIN_AGGREGATOR_DELETEDEPENDENCIES_DESC', 'Pokud odhlásíte (smažete) kanál a tato volba je zapnuta, všechny pøíspìvky svázané s tímto kanálem budou smazány.');
@define('PLUGIN_AGGREGATOR_DEBUG', 'Ladicí výpisy');
@define('PLUGIN_AGGREGATOR_DEBUG_BLAHBLAH', 'Zapnout zapisování ladicích výpisù do souboru?');
@define('PLUGIN_AGGREGATOR_IGNORE_UPDATES', 'Ignorovat aktualizace?');
@define('PLUGIN_AGGREGATOR_IGNORE_UPDATES_DESC', 'Pokud se text èlánku zmìní pozdìji po vydání, má se tato aktualizace ignorovat?');
@define('PLUGIN_AGGREGATOR_CHOOSE_ENGINE', 'Vybrat RSS parser');
@define('PLUGIN_AGGREGATOR_CHOOSE_ENGINE_DESC', 'Onys je distribuován pod BSD licencí, ale nepodporuje kanály typu ATOM. MagpieRSS je licencováno pod GPL licencí, ale nepodporuje formát ATOM a další funkce.');
@define('PLUGIN_AGGREGATOR_CRONJOB', 'Tento plugin využívá Serendipity plugin Cronjob. Nainstalujte jej, pokud potøebujete využívat pravidelnì opakované aktualizace.');
@define('PLUGIN_AGGREGATOR_MATCH_EXPRESSION', 'Filtr');
@define('PLUGIN_AGGREGATOR_MATCH_EXPRESSION_DESC', 'Zde lze zadat regulární výraz, kterým se bude porovnávat obsah pøíspìvku (nadpis a tìlo) a tento pøíspìvek se vloží do bogu, pouze pokud obsahuje zde zadaný vzor. Pokud je ponecháno prázdné, žádné porovnávání se neprovádí. Více výrazù mùže být oddìleno znakem ~ (vlnovka = tilda) a jsou kombinovány podle logiky OR (nebo = pokud èlánek obsahuje alespoò jeden z výrazù, je pøijat).');

@define('PLUGIN_AGGREGATOR_PUBLISH', 'Uložit agregované pøíspìvky jako...');
@define('PLUGIN_AGGREGATOR_MARKUP_DISABLE', 'Zakázat znaèkovací pluginy pro pøíspìvky vyrobené pomocí agregátoru.');
@define('PLUGIN_AGGREGATOR_MARKUP_DISABLE_DESC', 'Oznaète znaèkovací pluginy, které nemají být používány v agregovaných pøíspìvcích.');

// Next lines were translated on 2010/12/25
@define('PLUGIN_AGGREGATOR_FEEDICON', 'URL adresa ikony kanálu');