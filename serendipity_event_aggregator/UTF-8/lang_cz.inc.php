<?php # lang_cz.inc.php 1.1 2010-12-25 22:54:41 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/05
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/12/25
 */

@define('PLUGIN_AGGREGATOR_TITLE', 'RSS agregátor');
@define('PLUGIN_AGGREGATOR_DESC', 'Zobrazuje zprávy z mnoha RSS kanálů. DŮLEŽITÁ POZNÁMKA: Aktualizace a "krmení" agregátoru je v současnosti nutno dělat ručně pomocí Cronjobs nebo podobně. Volejte následující adresu v libovolných časových intervalech: ' . $serendipity['baseURL'] . 'index.php?/plugin/aggregator');
@define('PLUGIN_AGGREGATOR_FEEDNAME', 'Název RSS kanálu');
@define('PLUGIN_AGGREGATOR_FEEDNAME_DESC', 'Zobrazovaný název RSS kanálu.');
@define('PLUGIN_AGGREGATOR_FEEDURI', 'URI adresa RSS kanálu');
@define('PLUGIN_AGGREGATOR_FEEDURI_DESC', 'Adresa RSS kanálu.');
@define('PLUGIN_AGGREGATOR_HTMLURI', 'Domovská stránka - URI adresa');
@define('PLUGIN_AGGREGATOR_HTMLURI_DESC', 'HTML adresa kanálu.');
@define('PLUGIN_AGGREGATOR_CATEGORIES', 'Kategorie');

@define('PLUGIN_AGGREGATOR_FEEDLIST', 'Toto je seznam použitelných kanálů. Jednotilvé kanály můžete zadat ručně a stisknout tlačítko "GO" ("Provést"), nebo můžete importovat celý OPML soubor. Kanály mohou být smazány zadáním prázdné hodnoty do názvuv nebo URL adresy kanálu. Nové kanály mohou být přidány jako poslední řádka tabulky.');
@define('PLUGIN_AGGREGATOR_FEEDUPDATE', 'Poslední aktualizace');
@define('PLUGIN_AGGREGATOR_FEED_MISSINGDATA', 'Musíte zadat jméno a URL adresu RSS kanálu.');
@define('PLUGIN_AGGREGATOR_EXPORTFEEDLIST', 'Exportovat OPML seznam RSS kanálů');
@define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST', 'Importovat OPML seznam RSS kanálů');
@define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST_DESC', 'Zadejte URL adresu k OPML soubor (současné nastavení RSS kanálů bude ZRUŠENO a přepsáno importovanými kanály!). Pokud zaškrtnete vobu "Import kategorií", bude z OMPL souboru do blogu importována i struktura kategorií.');
@define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST_BUTTON', 'Importovat OPML!');
@define('PLUGIN_AGGREGATOR_EXPORTFEEDLIST_BUTTON', 'Exportovat OPML!');
@define('PLUGIN_AGGREGATOR_IMPORTCATEGORIES', 'Importovat kategorie');
@define('PLUGIN_AGGREGATOR_IMPORTCATEGORIES2', 'Zařadit každý RSS kanál do vlastní kategorie');
@define('PLUGIN_AGGREGATOR_CATEGORYSKIPPED', 'Přeskakuji vytváření kategorie "%s", protože už existuje.');

@define('PLUGIN_AGGREGATOR_EXPIRE', 'Vypršení platnosti obsahu');
@define('PLUGIN_AGGREGATOR_EXPIRE_BLAHBLAH', 'Platnost obsahu v databázi vyprší po uplynutí n dní (0 = žádné vypršení platnosti).');
@define('PLUGIN_AGGREGATOR_EXPIRE_MD5', 'Kontrolní součty pro expiraci');
@define('PLUGIN_AGGREGATOR_EXPIRE_MD5_BLAHBLAH', 'Kontrolní sumy se používají ke kontrole článků bez data na duplikáty. Po kolika dnech mají kontrolní součty vypršet? (90 = doporučená hodnota, 0 = nikdy).');
@define('PLUGIN_AGGREGATOR_DELETEDEPENDENCIES', 'Odstranit závislé příspěvky?');
@define('PLUGIN_AGGREGATOR_DELETEDEPENDENCIES_DESC', 'Pokud odhlásíte (smažete) kanál a tato volba je zapnuta, všechny příspěvky svázané s tímto kanálem budou smazány.');
@define('PLUGIN_AGGREGATOR_DEBUG', 'Ladicí výpisy');
@define('PLUGIN_AGGREGATOR_DEBUG_BLAHBLAH', 'Zapnout zapisování ladicích výpisů do souboru?');
@define('PLUGIN_AGGREGATOR_IGNORE_UPDATES', 'Ignorovat aktualizace?');
@define('PLUGIN_AGGREGATOR_IGNORE_UPDATES_DESC', 'Pokud se text článku změní později po vydání, má se tato aktualizace ignorovat?');
@define('PLUGIN_AGGREGATOR_CHOOSE_ENGINE', 'Vybrat RSS parser');
@define('PLUGIN_AGGREGATOR_CHOOSE_ENGINE_DESC', 'Onys je distribuován pod BSD licencí, ale nepodporuje kanály typu ATOM. MagpieRSS je licencováno pod GPL licencí, ale nepodporuje formát ATOM a další funkce.');
@define('PLUGIN_AGGREGATOR_CRONJOB', 'Tento plugin využívá Serendipity plugin Cronjob. Nainstalujte jej, pokud potřebujete využívat pravidelně opakované aktualizace.');
@define('PLUGIN_AGGREGATOR_MATCH_EXPRESSION', 'Filtr');
@define('PLUGIN_AGGREGATOR_MATCH_EXPRESSION_DESC', 'Zde lze zadat regulární výraz, kterým se bude porovnávat obsah příspěvku (nadpis a tělo) a tento příspěvek se vloží do bogu, pouze pokud obsahuje zde zadaný vzor. Pokud je ponecháno prázdné, žádné porovnávání se neprovádí. Více výrazů může být odděleno znakem ~ (vlnovka = tilda) a jsou kombinovány podle logiky OR (nebo = pokud článek obsahuje alespoň jeden z výrazů, je přijat).');

@define('PLUGIN_AGGREGATOR_PUBLISH', 'Uložit agregované příspěvky jako...');
@define('PLUGIN_AGGREGATOR_MARKUP_DISABLE', 'Zakázat značkovací pluginy pro příspěvky vyrobené pomocí agregátoru.');
@define('PLUGIN_AGGREGATOR_MARKUP_DISABLE_DESC', 'Označte značkovací pluginy, které nemají být používány v agregovaných příspěvcích.');

// Next lines were translated on 2010/12/25
@define('PLUGIN_AGGREGATOR_FEEDICON', 'URL adresa ikony kanálu');