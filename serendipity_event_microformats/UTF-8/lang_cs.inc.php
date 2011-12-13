<?php # lang_cs.inc.php 1.0 2009-06-08 19:21:24 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/08
 */

@define('PLUGIN_EVENT_MICROFORMATS_TITLE', 'Mikroformáty');
@define('PLUGIN_EVENT_MICROFORMATS_DESC', 'Tento plugin poskytuje jednoduché publikování přehledů (nebo událostí); podporuje příslušné mikroformáty.');

@define('PLUGIN_EVENT_MICROFORMATS_TYPES', 'Typ příspěvku');
@define('PLUGIN_EVENT_MICROFORMATS_TYPES_DESC', 'Který typ příspěvků chcete publikovat, tzn. přehledy nebo události?');

@define('PLUGIN_EVENT_MICROFORMATS_TYPES_HREVIEW', 'Přehledy');
@define('PLUGIN_EVENT_MICROFORMATS_TYPES_HCALENDAR', 'Události');

@define('PLUGIN_EVENT_MICROFORMATS_ID', 'ID');
@define('PLUGIN_EVENT_MICROFORMATS_RATING', 'Hodnocení');

@define('PLUGIN_EVENT_MICROFORMATS_SB_SUBNODE', 'Přidat uzel');
@define('PLUGIN_EVENT_MICROFORMATS_SB_SUBNODE_DESC', 'Pokud je k příspěvku přidán uzel, služby, které používají strukturované blogování, ho mohou přečíst; ale XHTML kód nemusí být správně vykreslen.');

@define('PLUGIN_MICROFORMATS_TITLE_N', 'Nadcházející události');
@define('PLUGIN_MICROFORMATS_TITLE_D', 'Zobrazit nejbližší a doporučené události v postranním sloupci a použít na ně mikroformat hCalendar.');

@define('PLUGIN_MICROFORMATS_DISPLAY_N', 'Hlavička postranního sloupce');
@define('PLUGIN_MICROFORMATS_DISPLAY_D', 'To je to, co se zobrazí jako nadpis bloku v postranním sloupci');

@define('PLUGIN_MICROFORMATS_SORT_N', 'Třídit události podle data');
@define('PLUGIN_MICROFORMATS_SORT_D', 'Pokud je "Ano", pak budou události tříděny podle data konání. Jinak se budou zobrazovat v pořadí, v jakém byly zadány.');

@define('PLUGIN_MICROFORMATS_PURGE_N', 'Odstranit události, které už proběhly');
@define('PLUGIN_MICROFORMATS_PURGE_D', 'Události, které jsou starší než X dní od aktuálního data, budou odstraněny ze seznamu. Ponechte prázdné, pokud nechcete mazat události.');

@define('PLUGIN_MICROFORMATS_ENTRIES_N', 'Včetně událostí z příspěvků');
@define('PLUGIN_MICROFORMATS_ENTRIES_D', 'Pokud použijete mikroformát hCalendar v příspěvcích, můžete je také zobrazit v postranním sloupci.');

@define('PLUGIN_MICROFORMATS_ICONDISPLAY_N', 'Zobrazit CAL ikonu');
@define('PLUGIN_MICROFORMATS_ICONDISPLAY_D', 'Zobrazit červenou CAL ikonu pod seznamem událostí.');

@define('PLUGIN_MICROFORMATS_TIMEZONE_N', 'Časové pásmo');
@define('PLUGIN_MICROFORMATS_TIMEZONE_D', 'Časové pásmo událostí (nejpravděpodobněji časové pásmo blogu).');

@define('PLUGIN_MICROFORMATS_EVENTLIST_XML_N', 'Seznam událostí');
@define('PLUGIN_MICROFORMATS_EVENTLIST_XML_D', 'Použijte prosím správné XML formátování (viz. níže). Musíte zadat přinejmenším "summary" (shrnutí nebo popis) a "dtstart" (datum počátku).');

@define('PLUGIN_EVENT_MICROFORMATS_BEST_N', 'Maximum bodů');
@define('PLUGIN_EVENT_MICROFORMATS_BEST_D', '');

@define('PLUGIN_EVENT_MICROFORMATS_STEP_N', 'Kroků');
@define('PLUGIN_EVENT_MICROFORMATS_STEP_D', '');

@define('PLUGIN_EVENT_MICROFORMATS_PATH_N', 'Cesta ke skriptům');
@define('PLUGIN_EVENT_MICROFORMATS_PATH_D', 'Zadejte plnou HTTP cestu (všechno po doménovém jménu), která vede do adresáře tohoto pluginu (např. /serendipity/plugins/serendipity_event_microformats).');

@define('PLUGIN_MICROFORMATS_EVENTLIST_XML_EXPLAIN', 'V souladu s definicí mikroformátu hCalendar (28.01.2007), tělo příspěvku je definováno následovně: <p><code>&lt;events&gt;<br/>&lt;event summary="Mistrovství světa ve fotbale 2010" location="Jihoafrická republika" url="http://www.fifa.com/de/worldcup/index/0,3360,WF2010,00.html?comp=WF&year=2010" dtstart="20100611T1930" dtend="20100711T2000" description="Africká výzva" /&gt;<br/>&lt;/events&gt;</code></p><p>Podívejte se také na <a href="http://blog.sperr-objekt.de/pages/microformats.html">dokumentaci</a>, která by už měla být napsána.</p>');