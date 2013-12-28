<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/14
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/02/06
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/01/08
 */

@define('PLUGIN_EVENT_SITEMAP_TITLE', 'Generátor mapy stránek pro vyhledávače');
@define('PLUGIN_EVENT_SITEMAP_DESC',  'Vytváří soubor sitemap.xml.gz, který používají nejrůznější webové vyhledávače (Google, MSN, Yahoo nebo Ask)');
@define('PLUGIN_EVENT_SITEMAP_FAILEDOPEN', 'Nelze otevřít soubor pro zápis.');
@define('PLUGIN_EVENT_SITEMAP_REPORT', 'Oznamovat změny mapy');
@define('PLUGIN_EVENT_SITEMAP_REPORT_DESC', 'Oznamovat aktualizace mapy stránek následujícím vyhledávacím službám.');
@define('PLUGIN_EVENT_SITEMAP_REPORT_ERROR', 'Nepodařilo se ohlásit aktualizaci mapy stránek na %s: %s<br />');
@define('PLUGIN_EVENT_SITEMAP_REPORT_OK', 'Mapa stránek poslána na %s.<br />');
@define('PLUGIN_EVENT_SITEMAP_REPORT_MANUAL','Mapa stránek nebyla poslána na %s, udělejte to ručně teď návštěvou <a href="%s">tohoto odkazu</a>.<br/>');
@define('PLUGIN_EVENT_SITEMAP_ROBOTS_TXT', 'Můžete ji také přidat do souboru "robots.txt", viz. <a href="http://googlewebmastercentral.blogspot.com/2007/04/whats-new-with-sitemapsorg.html">podrobnosti k robots.txt</a>.<br/>');
@define('PLUGIN_EVENT_SITEMAP_URL', 'Seznam URL adres pro oznámení (ping)');
@define('PLUGIN_EVENT_SITEMAP_URL_DESC', 'URL adresy pro oznámení (pingbacks) (%s bude nahrazeno URL adresou mapy stránek, více adres oddělujte pomocí \';\' (středník), pokud potřebujete zadat znak středníku ; napište \'%3B\').');
@define('PLUGIN_EVENT_SITEMAP_ADDFEEDS', 'Přidat kanál s novinkami');
@define('PLUGIN_EVENT_SITEMAP_ADDFEEDS_DESC', 'Do mapy stránek zahrne i RSS kanály (RSS 0.9, 1.0, 2.0, Atom a kategorie).');
@define('PLUGIN_EVENT_SITEMAP_UNKNOWN_SERVICE', 'neznámý');
@define('PLUGIN_EVENT_SITEMAP_PERMALINK_WARNING', 'Varování: pro správné vygenerování mapy stránek je třeba umístit plugin "permalink" (stálé odkazy) <b>před</b> plugin "mapa stránek".');
@define('PLUGIN_EVENT_SITEMAP_GZIP_SITEMAP', 'Gzipovat soubor sitemap.xml (komprese)');
@define('PLUGIN_EVENT_SITEMAP_GZIP_SITEMAP_DESC', 'Protokol pro mapy stránek umožňuje komprimovat soubor pomocí gzipu pro snížení objemu datového přenosu. Pokud pozorujete problémy s pluginem, můžete zkusit vypnout tuto volbu. (Poznámka: pokud Vaše instalace PHP nepodporuje gzip funkce, plugin automaticky bude tvořit nekomprimovaný soubor. Tedy obecně není potřeba tuto volbu ručně vypínat.)');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD', 'Typy URL pro přidání');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_DESC', 'Zadejte typy URL adres, které mají být zahrnuty do mapy stránek.');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_FEEDS', 'Kanály');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_CATEGORIES', 'Kategorie');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_AUTHORS', 'Autoři');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_PERMALINKS', 'Stálé odkazy (permalinky)');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_ARCHIVES', 'Archivy');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_STATIC', 'Statické stránky');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_TAGS', 'Stránky s tagy');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM', 'Vlastní (XML tělo)');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM_DESC', 'Zde zadejte text ve formátu XML, který chcete přidat na konec vygenerovaného souboru s mapou stránek. Pomocí této volby můžete ručně přidat KML soubory nebo například odkazy. Zkontrolujte, že to, co zde zadáte, odpovídá standardu XML.');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM2', 'Vlastní (XML hlavička/jmenný prostor)');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM2_DESC', 'Zde můžete zadat libovolný text v XML formátu, který bude přidán do hlavičky (nahoru) vygenerovaného souboru s mapou stránek, přímo do XML elementu "urlset". Zkontrolujte, že to, co zde zadáte, odpovídá standardu XML.');
@define('PLUGIN_EVENT_SITEMAP_NEWS', 'Zapnout obsah GoogleNews');

// Next lines were translated on 2010/02/06

@define('PLUGIN_EVENT_SITEMAP_GNEWS_NAME', 'Nadpis pro obsah GoogleNews');
@define('PLUGIN_EVENT_SITEMAP_GNEWS_NAME_DESC', 'Zadejte nadpis pro obsah GoogleNows');
@define('PLUGIN_EVENT_SITEMAP_PUBLIC', 'Veřejný');
@define('PLUGIN_EVENT_SITEMAP_SUBSCRIPTION', 'Zápis/předplatné (placený obsah)');
@define('PLUGIN_EVENT_SITEMAP_REGISTRATION', 'Registrace (obsah zdarma, registrace vyžadována)');
@define('PLUGIN_EVENT_SITEMAP_PRESS', 'Tisková zpráva');
@define('PLUGIN_EVENT_SITEMAP_SATIRE', 'Satira');
@define('PLUGIN_EVENT_SITEMAP_BLOG', 'Blog');
@define('PLUGIN_EVENT_SITEMAP_OPED', 'Názor autora');
@define('PLUGIN_EVENT_SITEMAP_OPINION', 'Názor ostatních');
@define('PLUGIN_EVENT_SITEMAP_USERGENERATED', 'Uživatelsky vytvořený obsah');
@define('PLUGIN_EVENT_SITEMAP_GNEWS_SUBSCRIPTION', 'GoogleNews: typ obsahu');
@define('PLUGIN_EVENT_SITEMAP_GNEWS_SUBSCRIPTION_DESC', '');
@define('PLUGIN_EVENT_SITEMAP_GENRES', 'GoogleNews: Žánry');
@define('PLUGIN_EVENT_SITEMAP_GENRES_DESC', 'V současnosti se tyto žánry projeví u všech příspěvků. Takže byste měli vybrat žánr, který se hodí na většinu příspěvků v blogu. Aby se tato volba stala závislou na jednotlivých příspěvcích, musíte k příspěvkům přidat uživatelské pole (CustomProperty) pojmenované "gnews_genre", které může obsahovat žánry jako textové řetězce oddělené čárkou.');
@define('PLUGIN_EVENT_SITEMAP_NONE', 'Žádný žánr');

// Next lines were translated on 2011/01/08
@define('PLUGIN_EVENT_SITEMAP_NEWS_SINGLE', 'Sloučit mapu stránek GoogleNews (Novinky Google) s normální mapou stránek?');
@define('PLUGIN_EVENT_SITEMAP_NEWS_SINGLE_DESC', 'Toto nastavení se uplatní pouze pokud jste povolili obsah novinek Google (GoogleNews). Pokud je zapnuto, normální soubor sitemap.xml bude obsahovat značky z GoogleNews. Pokud je vypnuto, pak bude data formátovaná podle GoogleNews obsahovat pouze soubor news_sitemap.xml. Pokud máte více než podporovaných 1000 článků na blogu, musíte tuto volbu vypnout, abyste nemátli GoogleSpiders vaší normální mapou stránek.');