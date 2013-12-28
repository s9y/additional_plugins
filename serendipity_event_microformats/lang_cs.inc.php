<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/08
 */

@define('PLUGIN_EVENT_MICROFORMATS_TITLE', 'Mikroformáty');
@define('PLUGIN_EVENT_MICROFORMATS_DESC', 'Tento plugin poskytuje jednoduché publikování pøehledù (nebo událostí); podporuje pøíslušné mikroformáty.');

@define('PLUGIN_EVENT_MICROFORMATS_TYPES', 'Typ pøíspìvku');
@define('PLUGIN_EVENT_MICROFORMATS_TYPES_DESC', 'Který typ pøíspìvkù chcete publikovat, tzn. pøehledy nebo události?');

@define('PLUGIN_EVENT_MICROFORMATS_TYPES_HREVIEW', 'Pøehledy');
@define('PLUGIN_EVENT_MICROFORMATS_TYPES_HCALENDAR', 'Události');

@define('PLUGIN_EVENT_MICROFORMATS_ID', 'ID');
@define('PLUGIN_EVENT_MICROFORMATS_RATING', 'Hodnocení');

@define('PLUGIN_EVENT_MICROFORMATS_SB_SUBNODE', 'Pøidat uzel');
@define('PLUGIN_EVENT_MICROFORMATS_SB_SUBNODE_DESC', 'Pokud je k pøíspìvku pøidán uzel, služby, které používají strukturované blogování, ho mohou pøeèíst; ale XHTML kód nemusí být správnì vykreslen.');

@define('PLUGIN_MICROFORMATS_TITLE_N', 'Nadcházející události');
@define('PLUGIN_MICROFORMATS_TITLE_D', 'Zobrazit nejbližší a doporuèené události v postranním sloupci a použít na nì mikroformat hCalendar.');

@define('PLUGIN_MICROFORMATS_DISPLAY_N', 'Hlavièka postranního sloupce');
@define('PLUGIN_MICROFORMATS_DISPLAY_D', 'To je to, co se zobrazí jako nadpis bloku v postranním sloupci');

@define('PLUGIN_MICROFORMATS_SORT_N', 'Tøídit události podle data');
@define('PLUGIN_MICROFORMATS_SORT_D', 'Pokud je "Ano", pak budou události tøídìny podle data konání. Jinak se budou zobrazovat v poøadí, v jakém byly zadány.');

@define('PLUGIN_MICROFORMATS_PURGE_N', 'Odstranit události, které už probìhly');
@define('PLUGIN_MICROFORMATS_PURGE_D', 'Události, které jsou starší než X dní od aktuálního data, budou odstranìny ze seznamu. Ponechte prázdné, pokud nechcete mazat události.');

@define('PLUGIN_MICROFORMATS_ENTRIES_N', 'Vèetnì událostí z pøíspìvkù');
@define('PLUGIN_MICROFORMATS_ENTRIES_D', 'Pokud použijete mikroformát hCalendar v pøíspìvcích, mùžete je také zobrazit v postranním sloupci.');

@define('PLUGIN_MICROFORMATS_ICONDISPLAY_N', 'Zobrazit CAL ikonu');
@define('PLUGIN_MICROFORMATS_ICONDISPLAY_D', 'Zobrazit èervenou CAL ikonu pod seznamem událostí.');

@define('PLUGIN_MICROFORMATS_TIMEZONE_N', 'Èasové pásmo');
@define('PLUGIN_MICROFORMATS_TIMEZONE_D', 'Èasové pásmo událostí (nejpravdìpodobnìji èasové pásmo blogu).');

@define('PLUGIN_MICROFORMATS_EVENTLIST_XML_N', 'Seznam událostí');
@define('PLUGIN_MICROFORMATS_EVENTLIST_XML_D', 'Použijte prosím správné XML formátování (viz. níže). Musíte zadat pøinejmenším "summary" (shrnutí nebo popis) a "dtstart" (datum poèátku).');

@define('PLUGIN_EVENT_MICROFORMATS_BEST_N', 'Maximum bodù');
@define('PLUGIN_EVENT_MICROFORMATS_BEST_D', '');

@define('PLUGIN_EVENT_MICROFORMATS_STEP_N', 'Krokù');
@define('PLUGIN_EVENT_MICROFORMATS_STEP_D', '');

@define('PLUGIN_EVENT_MICROFORMATS_PATH_N', 'Cesta ke skriptùm');
@define('PLUGIN_EVENT_MICROFORMATS_PATH_D', 'Zadejte plnou HTTP cestu (všechno po doménovém jménu), která vede do adresáøe tohoto pluginu (napø. /serendipity/plugins/serendipity_event_microformats).');

@define('PLUGIN_MICROFORMATS_EVENTLIST_XML_EXPLAIN', 'V souladu s definicí mikroformátu hCalendar (28.01.2007), tìlo pøíspìvku je definováno následovnì: <p><code>&lt;events&gt;<br/>&lt;event summary="Mistrovství svìta ve fotbale 2010" location="Jihoafrická republika" url="http://www.fifa.com/de/worldcup/index/0,3360,WF2010,00.html?comp=WF&year=2010" dtstart="20100611T1930" dtend="20100711T2000" description="Africká výzva" /&gt;<br/>&lt;/events&gt;</code></p><p>Podívejte se také na <a href="http://blog.sperr-objekt.de/pages/microformats.html">dokumentaci</a>, která by už mìla být napsána.</p>');