<?php # lang_cs.inc.php 1.0 2009-06-14 10:48:58 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/14
 */

@define('PLUGIN_EVENT_FLICKR_NAME', 'Import z Flickru');
@define('PLUGIN_EVENT_FLICKR_DESC', 'Importuje obrázky z flickr.com do knihovny médií');
@define('PLUGIN_EVENT_FLICKR_APIKEY', 'API klíè');
@define('PLUGIN_EVENT_FLICKR_APIKEY_INVALID', 'Klíè má 32 znakù a obsahuje pouze èíslice a písmenka [a-f] (klíè je v šestnáctkové èíselné soustavì)');
@define('PLUGIN_EVENT_FLICKR_APIKEY_DESC', 'API klíè z http://www.flickr.com/services/api/');
@define('PLUGIN_EVENT_FLICKR_IMPORT', 'Importovat obrázky ze služby Flickr.com');
@define('PLUGIN_EVENT_FLICKR_IMPORT2', 'Importovat obrázky ze služby Flickr.com (krok 2)');
@define('PLUGIN_EVENT_FLICKR_TAGS', 'Tagy');
@define('PLUGIN_EVENT_FLICKR_KEYWORDS', 'Klíèová slova');

@define('PLUGIN_EVENT_FLICKR_IMPORT_BLAHBLAH', 'Plugin umí importovat pouze fotky oznaèené jako "veøejné" ("public"). Pamatujte na to, že k fotkám existují jistá (autorská) práva.');
@define('PLUGIN_EVENT_FLICKR_INSTALL', '<strong>/!\</strong> U nìkterých poskytovatelù internetového pøipojení není možné zmìnit cestu "include path" pomocí php funkce ini_set() (napø. služba Free.fr). Tento plugin pak zhavaruje, protože nemùže najít nìkteré tøídy.<br /><br />V takovém pøípadì máte nejspíše na svém webovém úètu zvláštní prostor, kam mùžete nahrát vlastní php skripty (na podrobnosti se ptejte poskytovatele internetového pøipojení). Na Free.fr napø. jednoduše vytvoøíte adresáø "include" v koøenovém adresáøi Vašeho úètu. Pak zkopírujete všechno z podadresáøe phpFlickr/PEAR (podadresáø tohoto pluginu) do zmínìného "include" adresáøe.');