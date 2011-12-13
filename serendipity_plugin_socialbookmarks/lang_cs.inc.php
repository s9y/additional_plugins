<?php # lang_cs.inc.php 1.0 2009-05-12 22:47:10 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/12
 */

@define('PLUGIN_SOCIALBOOKMARKS_N', 'Sociální záloky');
@define('PLUGIN_SOCIALBOOKMARKS_D', 'Plugin zobrazuje záloky z webovıch zálokovcích slueb (jako del.icio.us, ma.gnolia, furl.net, linkroll nebo Mister Wong) pomocí jejich RSS kanálu.');
@define('PLUGIN_SOCIALBOOKMARKS_TITLE_N', 'Nadpis');
@define('PLUGIN_SOCIALBOOKMARKS_TITLE_D', 'Nadpis zobrazenı v záhlaví postranního bloku. Pokud necháte prázdné, bude se zobrazovat název sluby.');
@define('PLUGIN_SOCIALBOOKMARKS_SOCIALBOOKMARKSSERVICE_N', 'Sluba');
@define('PLUGIN_SOCIALBOOKMARKS_SOCIALBOOKMARKSSERVICE_D', 'Kterou zálokovací slubu pouíváte?');
@define('PLUGIN_SOCIALBOOKMARKS_USERNAME_N', 'Uivatelské jméno');
@define('PLUGIN_SOCIALBOOKMARKS_USERNAME_D', 'Uivatelské jméno registrované na zvoleném zálokovacím serveru.');
@define('PLUGIN_SOCIALBOOKMARKS_DISPLAYNUMBER_N', 'Poèet záloek');
@define('PLUGIN_SOCIALBOOKMARKS_DISPLAYNUMBER_D', 'Kolik záloek se má zobrazovat? (vıchozí: maximální velikost RSS kanálu, tedy 30)');
@define('PLUGIN_SOCIALBOOKMARKS_CACHETIME_N', 'Kdy aktulizovat RSS kanál?');
@define('PLUGIN_SOCIALBOOKMARKS_CACHETIME_D', 'Obsah RSS kanálu je uchováván v cachi a je obnovován, pouze pokud je obsah cache starší ne X hodin (vıchozí: 1).');
@define('PLUGIN_SOCIALBOOKMARKS_MORELINK_N', 'Zobrazovat odkaz "více"?');
@define('PLUGIN_SOCIALBOOKMARKS_MORELINK_D', 'Zobrazuje odkaz na Vaši stránku na serveru se zálokami.');
@define('PLUGIN_SOCIALBOOKMARKS_MORELINK', 'Více');
@define('PLUGIN_SOCIALBOOKMARKS_DISPLAYTAGS_N', 'Zobrazovat tagy?');
@define('PLUGIN_SOCIALBOOKMARKS_DISPLAYTAGS_D', 'Pokud jste pøipsali tagy (klíèová slova) k zálokám, mùete je zobrazit. Kliknutím na tag je Váš blog prohledán a vypíší se pøíspìvky, které obsahují stejnı tag. (podporováno pouze slubami del.icio.us, ma.gnolia.com a furl.net).');
@define('PLUGIN_SOCIALBOOKMARKS_DISPLAYTHUMBS_N', 'Zobrazit náhledy?');
@define('PLUGIN_SOCIALBOOKMARKS_DISPLAYTHUMBS_D', 'Nìkteré zálokovací sluby (v souèasnosti pouze ma.gnolia) poskytují v RSS kanálu i malé náhledy zazálokovanıch stránek. Pokud chcete, tyto obrázky mohou bıt zobrazeny místo názvù záloek.');
@define('PLUGIN_SOCIALBOOKMARKS_ADDPARAMS_N', 'Další parametry pro funkci "My tag cloud (del.icio.us)" (mrak tagù)');
@define('PLUGIN_SOCIALBOOKMARKS_ADDPARAMS_D', 'Toto nastavení se uplatní pouze v javascriptové funkci tagroll u del.icio.us. Pro více informací, jak pøizpùsobit mrak tagù (tag cloud), se obrate na nápovìdu k tagrollu na del.icio.us (http://del.icio.us/help/tagrolls).');
@define('PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_N', 'Typ RSS kanálu');
@define('PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_D', 'Vyberte z rùznıch typù RSS tagù se zálokami.');
@define('PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_USR_RECENT', 'Nejnovìjší záloky');
@define('PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_GEN_RECENT', 'Nejnovìjší záloky všech uivatelù');
@define('PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_GEN_POPULAR', 'Nejoblíbenìjší záloky');
@define('PLUGIN_SOCIALBOOKMARKS_EXPLAIN', '<h3>K èemu slouí tento plugin záloek?</h3><p>Hlavním úèelem sociálních záloek je jednoduché tøídìní a pøístup k webovım stránkám, které uivatel ji navštívil nebo hodlá navštívit, ani by si musel pamatovat jejich URL adresu a ani by se musel spoléhat na jinı software. Novìji se sdílené záloky staly pro mnoho uivatelù zpùsobem, jak se dozvìdìt o novıch stránkách, o kterıch by se jinak tøeba nedozvìdìli. Sdílené záloky pøedstavují také zpùsob, jak mít své záloky stále pøi ruce, ani by byl uivatel závislı na jednom poèítaèi.</p><p>S pomocí tohoto pluginu mùete na svém blogu jednoduše zobrazit své záloky, tedy záloky, které jste uloili na nìkterou z podporovanıch webovıch zálokovacích slueb.</p>');
?>