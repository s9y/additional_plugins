<?php # lang_cs.inc.php 1.1 2010-12-25 22:56:45 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/04
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/12/25
 */

@define('PLUGIN_EVENT_MOBILE_OUTPUT_NAME', 'Markup: Výstup na mobil');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_DESC', 'Tento plugin se stará o vytvoření kódu optimalizovaného pro mobilní telefony (tzv. XHTML MP), pokud zjistí, že stránku prohlíží prohlížeč pro mobily. Plugin je speciálně optimalizován pro iPhone a iPod Touch. Plugin také mění velikost obrázků, aby se přizpůsobily velikosti displeje.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_ENABLE_PLUGIN_NAME', 'Povolit plugin');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_ENABLE_PLUGIN_DESC', 'Povoluje optimalizace výstupního HTML pro mobilní telefony');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_MOBILE_TEMPLATE_NAME', 'Šablona pro mobily');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_MOBILE_TEMPLATE_DESC', 'Jméno šablony vzhledu pro mobilní telefony. Výchozí je "xhtml_mp", která je distribuována s pluginem.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_IPHONE_TEMPLATE_NAME', 'šablona vzhledu pro iPohne');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_IPHONE_TEMPLATE_DESC', 'Jméno šablony vzhledu pro iPhony. Výchozí je "iphone,app", která je distribuována společně s pluginem.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_IMAGES_NAME', 'Zobrazovat obrázky');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_IMAGES_DESC', 'Zobrazovat obrázky v příspěvcích');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_SCALE_IMAGE_WIDTH_NAME', 'Maximální šířka obrázku');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SCALE_IMAGE_WIDTH_DESC', 'Změní velikost obrázku na šířku X pixelů. Nastavte 0 pro zakázání změny velikosti obrázků. Vyžaduje knihovnu GD!');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_NAME', 'Přesměrování (redirect)');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_DESC', 'Přesměrovává mobilní prohlížeče na jinou webovou adresu (viz. níže)');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_URL_NAME', 'Cíl přesměrování');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_URL_DESC', 'Přesměrovat mobilní prohlížeče na tuto adresu (např. "m.vasblog.com"). Může to být jiný host, kde běží stejná instance Serendipity, např. z důvodů optimalizace na vyhledávání (SEO).');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_STICKY_HOST_NAME', 'Mobilní host');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_STICKY_HOST_DESC', 'Tento host bude vždycky vracet výstup pro mobily. Nechte prázdné pro zakázání.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_WURFL_NAME', 'Použít WURFL');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_WURFL_DESC', 'Pokud je tato volba zapnutá, velikost všech obrázků bude upravena tak, aby přesně seděly na velikost displeje mobilního zařízení. Při této funkci je použitá optimalizovaná verze WURFL UAP (http://wurfl.sourceforge.net/). Nejnovější verze souboru "wurfl.xml" je na http://c.seo-mobile.de/. Tento soubor je ale stále dost velký, proto je cachován. Cachování spotřebovává kolem 50MB na disku. Pokud stáhnete nový soubor "wurfl.xml", zadejte v prohlížeči '.$serendipity['baseURL'].'plugins/serendipity_event_mobile_output/wurfl/update_cache.php pro vytvoření cache. Tato funkce používá výše uvedení nastavení "Maximální šířka obrázku" jako nouzovou hodnotu, pokud se nepodaří zjistit velikost displeje. Tato funkce může zvýšit zátěž serveru! DŮLEŽITÉ: webserver musí mít právo zápisu v adresáři "wurfl/data/" kvůli cachi!');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_CATEGORIES_NAME', 'Zobrazovat kategorie');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_CATEGORIES_DESC', 'Zobrazit všechny kategorie v navigační patičce a přidej funkci přístupového tlačítka. Pokud existuje více než 9 kategorií, s přístupovým tlačítkem bude asociováno pouze prvních 9.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_TAGS_NAME', 'Odstranit HTML tagy');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_TAGS_DESC', 'Čárkami oddělený seznam tagů, které se mají odstraňovat, např. script, object, embed, ...');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_ATTRIBUTES_NAME', 'Odstranit HTML atributy');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_ATTRIBUTES_DESC', 'Čárkami oddělený seznam atributů, které se mají odstranit, např. onclick, onmouseover, style');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REWRITE_WIKIPEDIA_NAME', 'Přepsat odkazy Wikipedie');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REWRITE_WIKIPEDIA_DESC', 'Přepisuje odkaz směřující na Wikipedii tak, aby směřovaly na stejné heslo na mobilní Wikipedii (http://wikipedia.7val.com/)');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_DEBUG_PASSWORD_NAME', 'Ladicí heslo');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_DEBUG_PASSWORD_DESC', 'Zadejte heslo, po jehož zadání budou zobrazeny ladicí zprávy. Ty zborazíte přidáním ?mpDebug=HESLO k URL adrese blogu');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_NAVIGATION', 'Navigace');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_NAME', 'Vytvořit mapu stránek pro mobily');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_DESC', 'Vytváří soubor mobile_sitemap.xml(.gz) v kořenovém adresáři Serendipity pro vyhledávací roboty jako je Google, Ask.com apod.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_NAME', 'Oznamovat aktualizace');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_DESC', 'Oznamovat aktualizace níže zadaným službám');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_URL_NAME', 'Seznam URL pro oznámení');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_URL_DESC', 'URL adresy pro posílání oznámení o aktualizacích (%s je nahrazeno URL adresou na soubor s mapou stránek, více služeb oddělujte středníkem ";", pokud potřebujete zadat středník do URL adresy, použijte "%3B").');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_GZIP_NAME', 'Gzipovat soubor s mapou mobile_sitemap.xml');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_GZIP_DESC', 'Protokol pro mobilní mapu stránek podporuje gzipované soubory pro změnšení datového toku. Pokud při použití této funkce narazíte na problémy, můžete ji zkusit vypnout. (Pozn. Pokud Vaše instalace PHP nepodporuje funkce gzip, plugin bude automaticky tvořit nezipovanou mapu stránek. Tedy obecně není nutné tuto volbu vypínat.)');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_PERMALINK_WARNING', 'Varování: pro vygenerování správné mapy stránek musíte mít v nastavení pluginů plugin "permalink" umístěný před pluginem "Sitemap".');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_FAILEDOPEN', 'Nelze otevřít soubor pro psaní.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_UNKNOWN_HOST', 'Cíl oznámení o aktualizaci nenalezen.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_ERROR', 'Nepodařilo se ohlásit aktualizaci na %s: %s<br/>');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_OK', 'Aktualizovaná mapa stránek odeslána na %s.<br/>');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_MANUAL','Pokud se nepodařilo zapsat mapu stránek na %s, udělejte to teď návštěvou <a href="%s">tohoto odkazu</a>.');

// Next lines were translated on 2010/12/25
@define('PLUGIN_EVENT_MOBILE_OUTPUT_ANDROID_TEMPLATE_NAME', 'Šablona pro Androidy');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_ANDROID_TEMPLATE_DESC', 'Název šablony pro telefony Android. Výchozí je "android,app", která je součástí pluginu.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SMALLTEASER_NAME', 'Malé ochutnávky');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SMALLTEASER_DESC', 'Pokud je zapnuto, bude v přehledu příspěvků zobrazen pouze první odstavec příspěvku. Opačně je zobrazeno celé tělo bez rozšířené textové části jako obvykle.');