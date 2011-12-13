<?php # lang_de.inc.php 1.2 2011-11-22 17:22:01 VladaAjgl $

/**
 *  @version 1.2
 *  @author Translator Matthias Gutjahr <mattsches@gmail.com>
 *  DE-Revision: Revision of lang_de.inc.php
 *  @author Konrad Bauckmeier <yourmail@example.com>
 *  @revisionDate 2011/11/22
 */

@define('PLUGIN_EVENT_MICROFORMATS_TITLE', 'Microformats');
@define('PLUGIN_EVENT_MICROFORMATS_DESC', 'Dieses Plugin ermöglicht es, auf einfache Weise Rezensionen zu veröffentlichen und Veranstaltungen anzukündigen: Es unterstützt die jeweiligen Mikroformate.');

@define('PLUGIN_EVENT_MICROFORMATS_TYPES', 'Art des Eintrags');
@define('PLUGIN_EVENT_MICROFORMATS_TYPES_DESC', 'Was möchten Sie tun: Eine Rezension schreiben oder einen Termin ankündigen?');

@define('PLUGIN_EVENT_MICROFORMATS_TYPES_HREVIEW', 'Rezension');
@define('PLUGIN_EVENT_MICROFORMATS_TYPES_HCALENDAR', 'Termin');

@define('PLUGIN_EVENT_MICROFORMATS_ID', 'ID');
@define('PLUGIN_EVENT_MICROFORMATS_RATING', 'Bewertung');

@define('PLUGIN_EVENT_MICROFORMATS_SB_SUBNODE', 'Subnode hinzufügen');
@define('PLUGIN_EVENT_MICROFORMATS_SB_SUBNODE_DESC', 'Wenn dem Eintrag eine so genannte Subnode hinzugefügt wird, können Dienste, die structured blogging unterstützen, diese lesen; möglicherweise wird dadurch aber der XHTML-Code invalide.');

@define('PLUGIN_MICROFORMATS_TITLE_N', 'Kommende Termine');
@define('PLUGIN_MICROFORMATS_TITLE_D', 'Anzeige kommender Termine in der Sidebar, ausgezeichnet mit dem hCalendar-Microformat');

@define('PLUGIN_MICROFORMATS_DISPLAY_N', 'Überschrift in der Sidebar');
@define('PLUGIN_MICROFORMATS_DISPLAY_D', 'Der hier eingegebene Text wird als Überschrift in der Sidebar des Blogs angezeigt');

@define('PLUGIN_MICROFORMATS_SORT_N', 'Termine aufsteigend sortieren');
@define('PLUGIN_MICROFORMATS_SORT_D', 'Termine können automatisch aufsteigend sortiert werden oder in der eingegebenen Reihenfolge belassen werden.');

@define('PLUGIN_MICROFORMATS_PURGE_N', 'Vergangene Termine entfernen');
@define('PLUGIN_MICROFORMATS_PURGE_D', 'Termine, die mehr als x Tage in der Vergangenheit liegen, werden nicht angezeigt. Sollen sie doch angezeigt werden, Feld bitte leer lassen.');

@define('PLUGIN_MICROFORMATS_ENTRIES_N', 'Termine aus den Blogeinträgen bercksichtigen');
@define('PLUGIN_MICROFORMATS_ENTRIES_D', 'Termine, die in den Blogeinträgen mit dem hCalendar-Microformat ausgezeichnet sind, können ebenfalls in der Sidebar angezeigt werden.');

@define('PLUGIN_MICROFORMATS_ICONDISPLAY_N', 'Anzeige des CAL-Icons');
@define('PLUGIN_MICROFORMATS_ICONDISPLAY_D', 'Legt fest, ob unterhalb der Veranstaltungen ein rotes CAL-Icon als Hinweis auf die verwendeten Mikroformate angezeigt werden soll');

@define('PLUGIN_MICROFORMATS_TIMEZONE_N', 'Zeitzone');
@define('PLUGIN_MICROFORMATS_TIMEZONE_D', 'Zeitzone für die Termine (meist die Zeitzone des Blog bzw. die eigene Zeitzone).');

@define('PLUGIN_MICROFORMATS_EVENTLIST_XML_N', 'Liste der Veranstaltungen');
@define('PLUGIN_MICROFORMATS_EVENTLIST_XML_D', 'Bitte XML-Format beachten (siehe unten). Mindestend "summary" und "dtstart" mssen definiert sein.');

@define('PLUGIN_EVENT_MICROFORMATS_BEST_N', 'Maximale Punktzahl');
@define('PLUGIN_EVENT_MICROFORMATS_BEST_D', 'Bitte hier die maximale Punktzahl für einen Review eingeben, z.B. 5.0 (Dezimalpunkt beachten!)');

@define('PLUGIN_EVENT_MICROFORMATS_STEP_N', 'Punktabstände');
@define('PLUGIN_EVENT_MICROFORMATS_STEP_D', 'In welchen Schritten soll bewertet werden?');

@define('PLUGIN_MICROFORMATS_EVENTLIST_XML_EXPLAIN', 'Angelehnt an die Definition des hCalendar-Formats (Stand: 28.01.2007) wird ein Event-Eintrag folgendermaßen definiert: <p><code>&lt;events&gt;<br/>&lt;event summary="Football Worldcup 2010" location="South Africa" url="http://www.fifa.com/de/worldcup/index/0,3360,WF2010,00.html?comp=WF&year=2010" dtstart="20100611T1930" dtend="20100711T2000" description="Africa\'s Calling" /&gt;<br/>&lt;/events&gt;</code></p><p>Eine ausführliche <a href="http://blog.sperr-objekt.de/pages/microformats.html">Dokumentation</a> befindet sich unter im Aufbau</p>');

// Next lines were translated on 2011/11/22
@define('PLUGIN_EVENT_MICROFORMATS_PATH_N', 'Pfad zu den Scipts');
@define('PLUGIN_EVENT_MICROFORMATS_PATH_D', 'Geben Sie den vollen HTTP-Pfad an (alles nach dem Doman-Namen), der zu diesem Plugin-Verzeichnis führt (Beispiel: /serendipity/plugins/serendipity_event_microformats).');