<?php # lang_cs.inc.php 1.0 2009-05-12 22:47:10 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/12
 */

@define('PLUGIN_SOCIALBOOKMARKS_N', 'Sociální záložky');
@define('PLUGIN_SOCIALBOOKMARKS_D', 'Plugin zobrazuje záložky z webových záložkovcích služeb (jako del.icio.us, ma.gnolia, furl.net, linkroll nebo Mister Wong) pomocí jejich RSS kanálu.');
@define('PLUGIN_SOCIALBOOKMARKS_TITLE_N', 'Nadpis');
@define('PLUGIN_SOCIALBOOKMARKS_TITLE_D', 'Nadpis zobrazený v záhlaví postranního bloku. Pokud necháte prázdné, bude se zobrazovat název služby.');
@define('PLUGIN_SOCIALBOOKMARKS_SOCIALBOOKMARKSSERVICE_N', 'Služba');
@define('PLUGIN_SOCIALBOOKMARKS_SOCIALBOOKMARKSSERVICE_D', 'Kterou záložkovací službu používáte?');
@define('PLUGIN_SOCIALBOOKMARKS_USERNAME_N', 'Uživatelské jméno');
@define('PLUGIN_SOCIALBOOKMARKS_USERNAME_D', 'Uživatelské jméno registrované na zvoleném záložkovacím serveru.');
@define('PLUGIN_SOCIALBOOKMARKS_DISPLAYNUMBER_N', 'Počet záložek');
@define('PLUGIN_SOCIALBOOKMARKS_DISPLAYNUMBER_D', 'Kolik záložek se má zobrazovat? (výchozí: maximální velikost RSS kanálu, tedy 30)');
@define('PLUGIN_SOCIALBOOKMARKS_CACHETIME_N', 'Kdy aktulizovat RSS kanál?');
@define('PLUGIN_SOCIALBOOKMARKS_CACHETIME_D', 'Obsah RSS kanálu je uchováván v cachi a je obnovován, pouze pokud je obsah cache starší než X hodin (výchozí: 1).');
@define('PLUGIN_SOCIALBOOKMARKS_MORELINK_N', 'Zobrazovat odkaz "více"?');
@define('PLUGIN_SOCIALBOOKMARKS_MORELINK_D', 'Zobrazuje odkaz na Vaši stránku na serveru se záložkami.');
@define('PLUGIN_SOCIALBOOKMARKS_MORELINK', 'Více');
@define('PLUGIN_SOCIALBOOKMARKS_DISPLAYTAGS_N', 'Zobrazovat tagy?');
@define('PLUGIN_SOCIALBOOKMARKS_DISPLAYTAGS_D', 'Pokud jste připsali tagy (klíčová slova) k záložkám, můžete je zobrazit. Kliknutím na tag je Váš blog prohledán a vypíší se příspěvky, které obsahují stejný tag. (podporováno pouze službami del.icio.us, ma.gnolia.com a furl.net).');
@define('PLUGIN_SOCIALBOOKMARKS_DISPLAYTHUMBS_N', 'Zobrazit náhledy?');
@define('PLUGIN_SOCIALBOOKMARKS_DISPLAYTHUMBS_D', 'Některé záložkovací služby (v současnosti pouze ma.gnolia) poskytují v RSS kanálu i malé náhledy zazáložkovaných stránek. Pokud chcete, tyto obrázky mohou být zobrazeny místo názvů záložek.');
@define('PLUGIN_SOCIALBOOKMARKS_ADDPARAMS_N', 'Další parametry pro funkci "My tag cloud (del.icio.us)" (mrak tagů)');
@define('PLUGIN_SOCIALBOOKMARKS_ADDPARAMS_D', 'Toto nastavení se uplatní pouze v javascriptové funkci tagroll u del.icio.us. Pro více informací, jak přizpůsobit mrak tagů (tag cloud), se obraťte na nápovědu k tagrollu na del.icio.us (http://del.icio.us/help/tagrolls).');
@define('PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_N', 'Typ RSS kanálu');
@define('PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_D', 'Vyberte z různých typů RSS tagů se záložkami.');
@define('PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_USR_RECENT', 'Nejnovější záložky');
@define('PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_GEN_RECENT', 'Nejnovější záložky všech uživatelů');
@define('PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_GEN_POPULAR', 'Nejoblíbenější záložky');
@define('PLUGIN_SOCIALBOOKMARKS_EXPLAIN', '<h3>K čemu slouží tento plugin záložek?</h3><p>Hlavním účelem sociálních záložek je jednoduché třídění a přístup k webovým stránkám, které uživatel již navštívil nebo hodlá navštívit, aniž by si musel pamatovat jejich URL adresu a aniž by se musel spoléhat na jiný software. Nověji se sdílené záložky staly pro mnoho uživatelů způsobem, jak se dozvědět o nových stránkách, o kterých by se jinak třeba nedozvěděli. Sdílené záložky představují také způsob, jak mít své záložky stále při ruce, aniž by byl uživatel závislý na jednom počítači.</p><p>S pomocí tohoto pluginu můžete na svém blogu jednoduše zobrazit své záložky, tedy záložky, které jste uložili na některou z podporovaných webových záložkovacích služeb.</p>');
?>