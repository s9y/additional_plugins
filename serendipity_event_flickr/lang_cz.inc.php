<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/14
 */

@define('PLUGIN_EVENT_FLICKR_NAME', 'Import z Flickru');
@define('PLUGIN_EVENT_FLICKR_DESC', 'Importuje obrázky z flickr.com do knihovny médií');
@define('PLUGIN_EVENT_FLICKR_APIKEY', 'API klíè');
@define('PLUGIN_EVENT_FLICKR_APIKEY_INVALID', 'Klíè má 32 znakù a obsahuje pouze èíslice a písmenka [a-f] (klíè je v ¹estnáctkové èíselné soustavì)');
@define('PLUGIN_EVENT_FLICKR_APIKEY_DESC', 'API klíè z http://www.flickr.com/services/api/');
@define('PLUGIN_EVENT_FLICKR_IMPORT', 'Importovat obrázky ze slu¾by Flickr.com');
@define('PLUGIN_EVENT_FLICKR_IMPORT2', 'Importovat obrázky ze slu¾by Flickr.com (krok 2)');
@define('PLUGIN_EVENT_FLICKR_TAGS', 'Tagy');
@define('PLUGIN_EVENT_FLICKR_KEYWORDS', 'Klíèová slova');

@define('PLUGIN_EVENT_FLICKR_IMPORT_BLAHBLAH', 'Plugin umí importovat pouze fotky oznaèené jako "veøejné" ("public"). Pamatujte na to, ¾e k fotkám existují jistá (autorská) práva.');
@define('PLUGIN_EVENT_FLICKR_INSTALL', '<strong>/!\</strong> U nìkterých poskytovatelù internetového pøipojení není mo¾né zmìnit cestu "include path" pomocí php funkce ini_set() (napø. slu¾ba Free.fr). Tento plugin pak zhavaruje, proto¾e nemù¾e najít nìkteré tøídy.<br /><br />V takovém pøípadì máte nejspí¹e na svém webovém úètu zvlá¹tní prostor, kam mù¾ete nahrát vlastní php skripty (na podrobnosti se ptejte poskytovatele internetového pøipojení). Na Free.fr napø. jednodu¹e vytvoøíte adresáø "include" v koøenovém adresáøi Va¹eho úètu. Pak zkopírujete v¹echno z podadresáøe phpFlickr/PEAR (podadresáø tohoto pluginu) do zmínìného "include" adresáøe.');