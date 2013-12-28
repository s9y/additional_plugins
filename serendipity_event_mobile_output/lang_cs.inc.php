<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/04
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/12/25
 */

@define('PLUGIN_EVENT_MOBILE_OUTPUT_NAME', 'Markup: Výstup na mobil');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_DESC', 'Tento plugin se stará o vytvoøení kódu optimalizovaného pro mobilní telefony (tzv. XHTML MP), pokud zjistí, že stránku prohlíží prohlížeè pro mobily. Plugin je speciálnì optimalizován pro iPhone a iPod Touch. Plugin také mìní velikost obrázkù, aby se pøizpùsobily velikosti displeje.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_ENABLE_PLUGIN_NAME', 'Povolit plugin');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_ENABLE_PLUGIN_DESC', 'Povoluje optimalizace výstupního HTML pro mobilní telefony');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_MOBILE_TEMPLATE_NAME', 'Šablona pro mobily');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_MOBILE_TEMPLATE_DESC', 'Jméno šablony vzhledu pro mobilní telefony. Výchozí je "xhtml_mp", která je distribuována s pluginem.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_IPHONE_TEMPLATE_NAME', 'šablona vzhledu pro iPohne');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_IPHONE_TEMPLATE_DESC', 'Jméno šablony vzhledu pro iPhony. Výchozí je "iphone,app", která je distribuována spoleènì s pluginem.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_IMAGES_NAME', 'Zobrazovat obrázky');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_IMAGES_DESC', 'Zobrazovat obrázky v pøíspìvcích');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_SCALE_IMAGE_WIDTH_NAME', 'Maximální šíøka obrázku');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SCALE_IMAGE_WIDTH_DESC', 'Zmìní velikost obrázku na šíøku X pixelù. Nastavte 0 pro zakázání zmìny velikosti obrázkù. Vyžaduje knihovnu GD!');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_NAME', 'Pøesmìrování (redirect)');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_DESC', 'Pøesmìrovává mobilní prohlížeèe na jinou webovou adresu (viz. níže)');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_URL_NAME', 'Cíl pøesmìrování');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_URL_DESC', 'Pøesmìrovat mobilní prohlížeèe na tuto adresu (napø. "m.vasblog.com"). Mùže to být jiný host, kde bìží stejná instance Serendipity, napø. z dùvodù optimalizace na vyhledávání (SEO).');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_STICKY_HOST_NAME', 'Mobilní host');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_STICKY_HOST_DESC', 'Tento host bude vždycky vracet výstup pro mobily. Nechte prázdné pro zakázání.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_WURFL_NAME', 'Použít WURFL');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_WURFL_DESC', 'Pokud je tato volba zapnutá, velikost všech obrázkù bude upravena tak, aby pøesnì sedìly na velikost displeje mobilního zaøízení. Pøi této funkci je použitá optimalizovaná verze WURFL UAP (http://wurfl.sourceforge.net/). Nejnovìjší verze souboru "wurfl.xml" je na http://c.seo-mobile.de/. Tento soubor je ale stále dost velký, proto je cachován. Cachování spotøebovává kolem 50MB na disku. Pokud stáhnete nový soubor "wurfl.xml", zadejte v prohlížeèi '.$serendipity['baseURL'].'plugins/serendipity_event_mobile_output/wurfl/update_cache.php pro vytvoøení cache. Tato funkce používá výše uvedení nastavení "Maximální šíøka obrázku" jako nouzovou hodnotu, pokud se nepodaøí zjistit velikost displeje. Tato funkce mùže zvýšit zátìž serveru! DÙLEŽITÉ: webserver musí mít právo zápisu v adresáøi "wurfl/data/" kvùli cachi!');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_CATEGORIES_NAME', 'Zobrazovat kategorie');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_CATEGORIES_DESC', 'Zobrazit všechny kategorie v navigaèní patièce a pøidej funkci pøístupového tlaèítka. Pokud existuje více než 9 kategorií, s pøístupovým tlaèítkem bude asociováno pouze prvních 9.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_TAGS_NAME', 'Odstranit HTML tagy');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_TAGS_DESC', 'Èárkami oddìlený seznam tagù, které se mají odstraòovat, napø. script, object, embed, ...');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_ATTRIBUTES_NAME', 'Odstranit HTML atributy');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_ATTRIBUTES_DESC', 'Èárkami oddìlený seznam atributù, které se mají odstranit, napø. onclick, onmouseover, style');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REWRITE_WIKIPEDIA_NAME', 'Pøepsat odkazy Wikipedie');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REWRITE_WIKIPEDIA_DESC', 'Pøepisuje odkaz smìøující na Wikipedii tak, aby smìøovaly na stejné heslo na mobilní Wikipedii (http://wikipedia.7val.com/)');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_DEBUG_PASSWORD_NAME', 'Ladicí heslo');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_DEBUG_PASSWORD_DESC', 'Zadejte heslo, po jehož zadání budou zobrazeny ladicí zprávy. Ty zborazíte pøidáním ?mpDebug=HESLO k URL adrese blogu');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_NAVIGATION', 'Navigace');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_NAME', 'Vytvoøit mapu stránek pro mobily');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_DESC', 'Vytváøí soubor mobile_sitemap.xml(.gz) v koøenovém adresáøi Serendipity pro vyhledávací roboty jako je Google, Ask.com apod.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_NAME', 'Oznamovat aktualizace');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_DESC', 'Oznamovat aktualizace níže zadaným službám');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_URL_NAME', 'Seznam URL pro oznámení');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_URL_DESC', 'URL adresy pro posílání oznámení o aktualizacích (%s je nahrazeno URL adresou na soubor s mapou stránek, více služeb oddìlujte støedníkem ";", pokud potøebujete zadat støedník do URL adresy, použijte "%3B").');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_GZIP_NAME', 'Gzipovat soubor s mapou mobile_sitemap.xml');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_GZIP_DESC', 'Protokol pro mobilní mapu stránek podporuje gzipované soubory pro zmìnšení datového toku. Pokud pøi použití této funkce narazíte na problémy, mùžete ji zkusit vypnout. (Pozn. Pokud Vaše instalace PHP nepodporuje funkce gzip, plugin bude automaticky tvoøit nezipovanou mapu stránek. Tedy obecnì není nutné tuto volbu vypínat.)');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_PERMALINK_WARNING', 'Varování: pro vygenerování správné mapy stránek musíte mít v nastavení pluginù plugin "permalink" umístìný pøed pluginem "Sitemap".');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_FAILEDOPEN', 'Nelze otevøít soubor pro psaní.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_UNKNOWN_HOST', 'Cíl oznámení o aktualizaci nenalezen.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_ERROR', 'Nepodaøilo se ohlásit aktualizaci na %s: %s<br/>');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_OK', 'Aktualizovaná mapa stránek odeslána na %s.<br/>');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_MANUAL','Pokud se nepodaøilo zapsat mapu stránek na %s, udìlejte to teï návštìvou <a href="%s">tohoto odkazu</a>.');

// Next lines were translated on 2010/12/25
@define('PLUGIN_EVENT_MOBILE_OUTPUT_ANDROID_TEMPLATE_NAME', 'Šablona pro Androidy');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_ANDROID_TEMPLATE_DESC', 'Název šablony pro telefony Android. Výchozí je "android,app", která je souèástí pluginu.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SMALLTEASER_NAME', 'Malé ochutnávky');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SMALLTEASER_DESC', 'Pokud je zapnuto, bude v pøehledu pøíspìvkù zobrazen pouze první odstavec pøíspìvku. Opaènì je zobrazeno celé tìlo bez rozšíøené textové èásti jako obvykle.');