<?php # lang_cs.inc.php 1.1 2010-09-28 09:02:21 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/27
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/09/28
 */
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_NAME', 'Google Analytics');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_DESC', 'Tento plugin přidává vašemu blogu rošířené funkce Google Analytics jako je například sledování odkazů nebo stažených souborů.');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_ACCOUNT_NUMBER', 'Číslo účtu Google Analytics');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_ACCOUNT_NUMBER_DESC', 'Číslo vašeho účtu Google Analytics. Zadávejte část xxxx-x z řetězce _uacct="UA-xxxx-x";');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_DOWNLOADS', 'Sledovat stažené soubory?');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_DOWNLOADS_DESC', '');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_EXTERNAL', 'Sledovat odchozí odkazy?');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_EXTERNAL_DESC', '');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_DOWNLOAD_EXTENSIONS', 'Které stažené soubory se mají sledovat?');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_DOWNLOAD_EXTENSIONS_DESC', 'Seznam přípon sledovaných souborů. Jednotlivé přípony jsou oddělené čárkou.');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_INTERNAL_HOSTS', 'Domény, které přistupují k blogu.');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_INTERNAL_HOSTS_DESC', 'Jedna doména na řádce (www.priklad.cz).');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_EXCLUDE_GROUPS', 'Které skupiny uživatelů nemají být sledovány?');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_EXCLUDE_GROUPS_DESC', 'Vyberte skupiny ze seznamu.');

// Next lines were translated on 2010/09/28
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_ANONYMIZEIP', 'Anonymní IP');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_ANONYMIZEIP_DESC', 'Oznamovat nástroji Google Analytics, aby znemožnil jednoznačnou identifikaci pomocí IP adresy zasílané sledovanými objekty tím, že odstraní poslední oktet z IP adresy ještě před tím, než ji uloží do databáze. Mějte na paměti, že tato akce trochu sníží přesnost určení geografické polohy návštěvníků.');