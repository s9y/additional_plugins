<?php # lang_cz.inc.php 1.2 2011-01-08 10:46:23 VladaAjgl $

/**
 *  @version 1.2
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/14
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/02/06
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/01/08
 */

@define('PLUGIN_EVENT_SITEMAP_TITLE', 'Generátor mapy stránek pro vyhledávaèe');
@define('PLUGIN_EVENT_SITEMAP_DESC',  'Vytváøí soubor sitemap.xml.gz, který pou¾ívají nejrùznìj¹í webové vyhledávaèe (Google, MSN, Yahoo nebo Ask)');
@define('PLUGIN_EVENT_SITEMAP_FAILEDOPEN', 'Nelze otevøít soubor pro zápis.');
@define('PLUGIN_EVENT_SITEMAP_REPORT', 'Oznamovat zmìny mapy');
@define('PLUGIN_EVENT_SITEMAP_REPORT_DESC', 'Oznamovat aktualizace mapy stránek následujícím vyhledávacím slu¾bám.');
@define('PLUGIN_EVENT_SITEMAP_REPORT_ERROR', 'Nepodaøilo se ohlásit aktualizaci mapy stránek na %s: %s<br />');
@define('PLUGIN_EVENT_SITEMAP_REPORT_OK', 'Mapa stránek poslána na %s.<br />');
@define('PLUGIN_EVENT_SITEMAP_REPORT_MANUAL','Mapa stránek nebyla poslána na %s, udìlejte to ruènì teï náv¹tìvou <a href="%s">tohoto odkazu</a>.<br/>');
@define('PLUGIN_EVENT_SITEMAP_ROBOTS_TXT', 'Mù¾ete ji také pøidat do souboru "robots.txt", viz. <a href="http://googlewebmastercentral.blogspot.com/2007/04/whats-new-with-sitemapsorg.html">podrobnosti k robots.txt</a>.<br/>');
@define('PLUGIN_EVENT_SITEMAP_URL', 'Seznam URL adres pro oznámení (ping)');
@define('PLUGIN_EVENT_SITEMAP_URL_DESC', 'URL adresy pro oznámení (pingbacks) (%s bude nahrazeno URL adresou mapy stránek, více adres oddìlujte pomocí \';\' (støedník), pokud potøebujete zadat znak støedníku ; napi¹te \'%3B\').');
@define('PLUGIN_EVENT_SITEMAP_ADDFEEDS', 'Pøidat kanál s novinkami');
@define('PLUGIN_EVENT_SITEMAP_ADDFEEDS_DESC', 'Do mapy stránek zahrne i RSS kanály (RSS 0.9, 1.0, 2.0, Atom a kategorie).');
@define('PLUGIN_EVENT_SITEMAP_UNKNOWN_SERVICE', 'neznámý');
@define('PLUGIN_EVENT_SITEMAP_PERMALINK_WARNING', 'Varování: pro správné vygenerování mapy stránek je tøeba umístit plugin "permalink" (stálé odkazy) <b>pøed</b> plugin "mapa stránek".');
@define('PLUGIN_EVENT_SITEMAP_GZIP_SITEMAP', 'Gzipovat soubor sitemap.xml (komprese)');
@define('PLUGIN_EVENT_SITEMAP_GZIP_SITEMAP_DESC', 'Protokol pro mapy stránek umo¾òuje komprimovat soubor pomocí gzipu pro sní¾ení objemu datového pøenosu. Pokud pozorujete problémy s pluginem, mù¾ete zkusit vypnout tuto volbu. (Poznámka: pokud Va¹e instalace PHP nepodporuje gzip funkce, plugin automaticky bude tvoøit nekomprimovaný soubor. Tedy obecnì není potøeba tuto volbu ruènì vypínat.)');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD', 'Typy URL pro pøidání');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_DESC', 'Zadejte typy URL adres, které mají být zahrnuty do mapy stránek.');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_FEEDS', 'Kanály');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_CATEGORIES', 'Kategorie');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_AUTHORS', 'Autoøi');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_PERMALINKS', 'Stálé odkazy (permalinky)');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_ARCHIVES', 'Archivy');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_STATIC', 'Statické stránky');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_TAGS', 'Stránky s tagy');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM', 'Vlastní (XML tìlo)');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM_DESC', 'Zde zadejte text ve formátu XML, který chcete pøidat na konec vygenerovaného souboru s mapou stránek. Pomocí této volby mù¾ete ruènì pøidat KML soubory nebo napøíklad odkazy. Zkontrolujte, ¾e to, co zde zadáte, odpovídá standardu XML.');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM2', 'Vlastní (XML hlavièka/jmenný prostor)');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM2_DESC', 'Zde mù¾ete zadat libovolný text v XML formátu, který bude pøidán do hlavièky (nahoru) vygenerovaného souboru s mapou stránek, pøímo do XML elementu "urlset". Zkontrolujte, ¾e to, co zde zadáte, odpovídá standardu XML.');
@define('PLUGIN_EVENT_SITEMAP_NEWS', 'Zapnout obsah GoogleNews');

// Next lines were translated on 2010/02/06

@define('PLUGIN_EVENT_SITEMAP_GNEWS_NAME', 'Nadpis pro obsah GoogleNews');
@define('PLUGIN_EVENT_SITEMAP_GNEWS_NAME_DESC', 'Zadejte nadpis pro obsah GoogleNows');
@define('PLUGIN_EVENT_SITEMAP_PUBLIC', 'Veøejný');
@define('PLUGIN_EVENT_SITEMAP_SUBSCRIPTION', 'Zápis/pøedplatné (placený obsah)');
@define('PLUGIN_EVENT_SITEMAP_REGISTRATION', 'Registrace (obsah zdarma, registrace vy¾adována)');
@define('PLUGIN_EVENT_SITEMAP_PRESS', 'Tisková zpráva');
@define('PLUGIN_EVENT_SITEMAP_SATIRE', 'Satira');
@define('PLUGIN_EVENT_SITEMAP_BLOG', 'Blog');
@define('PLUGIN_EVENT_SITEMAP_OPED', 'Názor autora');
@define('PLUGIN_EVENT_SITEMAP_OPINION', 'Názor ostatních');
@define('PLUGIN_EVENT_SITEMAP_USERGENERATED', 'U¾ivatelsky vytvoøený obsah');
@define('PLUGIN_EVENT_SITEMAP_GNEWS_SUBSCRIPTION', 'GoogleNews: typ obsahu');
@define('PLUGIN_EVENT_SITEMAP_GNEWS_SUBSCRIPTION_DESC', '');
@define('PLUGIN_EVENT_SITEMAP_GENRES', 'GoogleNews: ®ánry');
@define('PLUGIN_EVENT_SITEMAP_GENRES_DESC', 'V souèasnosti se tyto ¾ánry projeví u v¹ech pøíspìvkù. Tak¾e byste mìli vybrat ¾ánr, který se hodí na vìt¹inu pøíspìvkù v blogu. Aby se tato volba stala závislou na jednotlivých pøíspìvcích, musíte k pøíspìvkùm pøidat u¾ivatelské pole (CustomProperty) pojmenované "gnews_genre", které mù¾e obsahovat ¾ánry jako textové øetìzce oddìlené èárkou.');
@define('PLUGIN_EVENT_SITEMAP_NONE', '®ádný ¾ánr');

// Next lines were translated on 2011/01/08
@define('PLUGIN_EVENT_SITEMAP_NEWS_SINGLE', 'Slouèit mapu stránek GoogleNews (Novinky Google) s normální mapou stránek?');
@define('PLUGIN_EVENT_SITEMAP_NEWS_SINGLE_DESC', 'Toto nastavení se uplatní pouze pokud jste povolili obsah novinek Google (GoogleNews). Pokud je zapnuto, normální soubor sitemap.xml bude obsahovat znaèky z GoogleNews. Pokud je vypnuto, pak bude data formátovaná podle GoogleNews obsahovat pouze soubor news_sitemap.xml. Pokud máte více ne¾ podporovaných 1000 èlánkù na blogu, musíte tuto volbu vypnout, abyste nemátli GoogleSpiders va¹í normální mapou stránek.');