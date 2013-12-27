/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/14
 */

@define('PLUGIN_EVENT_FLICKR_NAME', 'Import z Flickru');
@define('PLUGIN_EVENT_FLICKR_DESC', 'Importuje obrázky z flickr.com do knihovny médií');
@define('PLUGIN_EVENT_FLICKR_APIKEY', 'API klíč');
@define('PLUGIN_EVENT_FLICKR_APIKEY_INVALID', 'Klíč má 32 znaků a obsahuje pouze číslice a písmenka [a-f] (klíč je v šestnáctkové číselné soustavě)');
@define('PLUGIN_EVENT_FLICKR_APIKEY_DESC', 'API klíč z http://www.flickr.com/services/api/');
@define('PLUGIN_EVENT_FLICKR_IMPORT', 'Importovat obrázky ze služby Flickr.com');
@define('PLUGIN_EVENT_FLICKR_IMPORT2', 'Importovat obrázky ze služby Flickr.com (krok 2)');
@define('PLUGIN_EVENT_FLICKR_TAGS', 'Tagy');
@define('PLUGIN_EVENT_FLICKR_KEYWORDS', 'Klíčová slova');

@define('PLUGIN_EVENT_FLICKR_IMPORT_BLAHBLAH', 'Plugin umí importovat pouze fotky označené jako "veřejné" ("public"). Pamatujte na to, že k fotkám existují jistá (autorská) práva.');
@define('PLUGIN_EVENT_FLICKR_INSTALL', '<strong>/!\</strong> U některých poskytovatelů internetového připojení není možné změnit cestu "include path" pomocí php funkce ini_set() (např. služba Free.fr). Tento plugin pak zhavaruje, protože nemůže najít některé třídy.<br /><br />V takovém případě máte nejspíše na svém webovém účtu zvláštní prostor, kam můžete nahrát vlastní php skripty (na podrobnosti se ptejte poskytovatele internetového připojení). Na Free.fr např. jednoduše vytvoříte adresář "include" v kořenovém adresáři Vašeho účtu. Pak zkopírujete všechno z podadresáře phpFlickr/PEAR (podadresář tohoto pluginu) do zmíněného "include" adresáře.');