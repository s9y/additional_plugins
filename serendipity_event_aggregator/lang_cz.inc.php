/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/05
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/12/25
 */

@define('PLUGIN_AGGREGATOR_TITLE', 'RSS agregátor');
@define('PLUGIN_AGGREGATOR_DESC', 'Zobrazuje zprávy z mnoha RSS kanálù. DÙLE®ITÁ POZNÁMKA: Aktualizace a "krmení" agregátoru je v souèasnosti nutno dìlat ruènì pomocí Cronjobs nebo podobnì. Volejte následující adresu v libovolných èasových intervalech: ' . $serendipity['baseURL'] . 'index.php?/plugin/aggregator');
@define('PLUGIN_AGGREGATOR_FEEDNAME', 'Název RSS kanálu');
@define('PLUGIN_AGGREGATOR_FEEDNAME_DESC', 'Zobrazovaný název RSS kanálu.');
@define('PLUGIN_AGGREGATOR_FEEDURI', 'URI adresa RSS kanálu');
@define('PLUGIN_AGGREGATOR_FEEDURI_DESC', 'Adresa RSS kanálu.');
@define('PLUGIN_AGGREGATOR_HTMLURI', 'Domovská stránka - URI adresa');
@define('PLUGIN_AGGREGATOR_HTMLURI_DESC', 'HTML adresa kanálu.');
@define('PLUGIN_AGGREGATOR_CATEGORIES', 'Kategorie');

@define('PLUGIN_AGGREGATOR_FEEDLIST', 'Toto je seznam pou¾itelných kanálù. Jednotilvé kanály mù¾ete zadat ruènì a stisknout tlaèítko "GO" ("Provést"), nebo mù¾ete importovat celý OPML soubor. Kanály mohou být smazány zadáním prázdné hodnoty do názvuv nebo URL adresy kanálu. Nové kanály mohou být pøidány jako poslední øádka tabulky.');
@define('PLUGIN_AGGREGATOR_FEEDUPDATE', 'Poslední aktualizace');
@define('PLUGIN_AGGREGATOR_FEED_MISSINGDATA', 'Musíte zadat jméno a URL adresu RSS kanálu.');
@define('PLUGIN_AGGREGATOR_EXPORTFEEDLIST', 'Exportovat OPML seznam RSS kanálù');
@define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST', 'Importovat OPML seznam RSS kanálù');
@define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST_DESC', 'Zadejte URL adresu k OPML soubor (souèasné nastavení RSS kanálù bude ZRU©ENO a pøepsáno importovanými kanály!). Pokud za¹krtnete vobu "Import kategorií", bude z OMPL souboru do blogu importována i struktura kategorií.');
@define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST_BUTTON', 'Importovat OPML!');
@define('PLUGIN_AGGREGATOR_EXPORTFEEDLIST_BUTTON', 'Exportovat OPML!');
@define('PLUGIN_AGGREGATOR_IMPORTCATEGORIES', 'Importovat kategorie');
@define('PLUGIN_AGGREGATOR_IMPORTCATEGORIES2', 'Zaøadit ka¾dý RSS kanál do vlastní kategorie');
@define('PLUGIN_AGGREGATOR_CATEGORYSKIPPED', 'Pøeskakuji vytváøení kategorie "%s", proto¾e u¾ existuje.');

@define('PLUGIN_AGGREGATOR_EXPIRE', 'Vypr¹ení platnosti obsahu');
@define('PLUGIN_AGGREGATOR_EXPIRE_BLAHBLAH', 'Platnost obsahu v databázi vypr¹í po uplynutí n dní (0 = ¾ádné vypr¹ení platnosti).');
@define('PLUGIN_AGGREGATOR_EXPIRE_MD5', 'Kontrolní souèty pro expiraci');
@define('PLUGIN_AGGREGATOR_EXPIRE_MD5_BLAHBLAH', 'Kontrolní sumy se pou¾ívají ke kontrole èlánkù bez data na duplikáty. Po kolika dnech mají kontrolní souèty vypr¹et? (90 = doporuèená hodnota, 0 = nikdy).');
@define('PLUGIN_AGGREGATOR_DELETEDEPENDENCIES', 'Odstranit závislé pøíspìvky?');
@define('PLUGIN_AGGREGATOR_DELETEDEPENDENCIES_DESC', 'Pokud odhlásíte (sma¾ete) kanál a tato volba je zapnuta, v¹echny pøíspìvky svázané s tímto kanálem budou smazány.');
@define('PLUGIN_AGGREGATOR_DEBUG', 'Ladicí výpisy');
@define('PLUGIN_AGGREGATOR_DEBUG_BLAHBLAH', 'Zapnout zapisování ladicích výpisù do souboru?');
@define('PLUGIN_AGGREGATOR_IGNORE_UPDATES', 'Ignorovat aktualizace?');
@define('PLUGIN_AGGREGATOR_IGNORE_UPDATES_DESC', 'Pokud se text èlánku zmìní pozdìji po vydání, má se tato aktualizace ignorovat?');
@define('PLUGIN_AGGREGATOR_CHOOSE_ENGINE', 'Vybrat RSS parser');
@define('PLUGIN_AGGREGATOR_CHOOSE_ENGINE_DESC', 'Onys je distribuován pod BSD licencí, ale nepodporuje kanály typu ATOM. MagpieRSS je licencováno pod GPL licencí, ale nepodporuje formát ATOM a dal¹í funkce.');
@define('PLUGIN_AGGREGATOR_CRONJOB', 'Tento plugin vyu¾ívá Serendipity plugin Cronjob. Nainstalujte jej, pokud potøebujete vyu¾ívat pravidelnì opakované aktualizace.');
@define('PLUGIN_AGGREGATOR_MATCH_EXPRESSION', 'Filtr');
@define('PLUGIN_AGGREGATOR_MATCH_EXPRESSION_DESC', 'Zde lze zadat regulární výraz, kterým se bude porovnávat obsah pøíspìvku (nadpis a tìlo) a tento pøíspìvek se vlo¾í do bogu, pouze pokud obsahuje zde zadaný vzor. Pokud je ponecháno prázdné, ¾ádné porovnávání se neprovádí. Více výrazù mù¾e být oddìleno znakem ~ (vlnovka = tilda) a jsou kombinovány podle logiky OR (nebo = pokud èlánek obsahuje alespoò jeden z výrazù, je pøijat).');

@define('PLUGIN_AGGREGATOR_PUBLISH', 'Ulo¾it agregované pøíspìvky jako...');
@define('PLUGIN_AGGREGATOR_MARKUP_DISABLE', 'Zakázat znaèkovací pluginy pro pøíspìvky vyrobené pomocí agregátoru.');
@define('PLUGIN_AGGREGATOR_MARKUP_DISABLE_DESC', 'Oznaète znaèkovací pluginy, které nemají být pou¾ívány v agregovaných pøíspìvcích.');

// Next lines were translated on 2010/12/25
@define('PLUGIN_AGGREGATOR_FEEDICON', 'URL adresa ikony kanálu');