<?php

/**
 *  @version 
 *  @author Translator Kami Petersen <kami@gueststars.net>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', 'Etikettering av artiklar');
@define('PLUGIN_EVENT_FREETAG_DESC', 'Medger fri etikettering av artiklar');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', 'Mata in de etiketter som passar. Flera etiketter separeras med komma (,)');
@define('PLUGIN_EVENT_FREETAG_LIST', 'Etiketter på denna artikel: %s');
@define('PLUGIN_EVENT_FREETAG_USING', 'Artiklar med etiketterna %s');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', 'Etiketter relaterade till etiketten %s');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED','Inga relaterade etiketter.');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', 'Alla etiketter');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', 'Hantera etiketter');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', 'Hantera alla etiketter');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', 'Hantera \'udda\' etiketter');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', 'Lista oetiketterade artiklar');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', 'Lista \'udda\' artiklar');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', 'Inga oetiketterade artiklar!');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', 'Etikett');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', 'Vikt');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', 'Handling');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', 'Byt namn');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', 'Dela');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', 'Ta bort');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', 'Vill du verkligen ta bort etiketten %s?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'använd komma för att separera etiketter:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', 'Visa etikettmoln för relaterade etiketter?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER', 'Skicka X-FreeTag-HTTP-Headers');
@define('PLUGIN_EVENT_FREETAG_ADMIN_TAGLIST', 'Visa klickbar lista med alla etiketter vid inmatning av artikel');
@define('PLUGIN_EVENT_FREETAG_ADMIN_FTAYT', 'Aktivera Hitta-etiketter-medan-du-skriver');

//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'Visa artiklar med etiketter');
@define('PLUGIN_FREETAG_BLAHBLAH', 'Visar en lista med existerande etiketter på artiklar');
@define('PLUGIN_FREETAG_NEWLINE', 'Radmatning efter varje etikett?');
@define('PLUGIN_FREETAG_XML', 'Visa XML-ikoner?');
@define('PLUGIN_FREETAG_SCALE','Skala storleken på etiketter efter popularitet (som Technorati, flickr)?');
@define('PLUGIN_FREETAG_UPGRADE1_2','Uppgraderar %d etiketter för artikel nummer: %d');
@define('PLUGIN_FREETAG_MAX_TAGS', 'Hur många etiketter skall visas?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'Hur många förekomster måste en etikett ha för att visas?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'Storlek i % på minsta etikett i etikettmoln');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'Storlek i % på största etikett i etikettmoln');

@define('PLUGIN_FREETAG_META_KEYWORDS', 'Antal meta-nyckelord att bädda in i HTML-källkoden (0: deaktiverad)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Artiklar med relaterade etiketter:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED','Visa artiklar med relaterade etiketter?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT','Hur många relaterade artiklar skall visas?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', 'Visa etiketter i artikelfoten?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', 'Om ja, kommer etiketterna att visas i artikelns sidfot. Om nej, kommer etiketterna att visas i innehållet/det utökade innehållet i dina artiklar.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', 'Gemena etiketter');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS', 'Relaterade etiketter');
@define('PLUGIN_EVENT_FREETAG_TAGLINK', 'Etikettlänk');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG', 'Skapa etiketter för alla motsvarande kategorier?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC', 'Om ja, kommer alla kategorier som en artikel tillhör att adderas som etiketter på din artikel. Du kan ställa in alla kategoriassociationer för dina befintliga artiklar under "Hantera etiketter" i menyn i administrationsgränssnittet.');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS', 'Konvertera alla tilldelade kategorier för befintliga artiklar till etiketter.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY', 'Konverterade kategorier för artikel #%d (%s): %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG', 'Alla kategorier som konverterats till etiketter.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS', 'Automatiserade nyckelord');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC', 'Du kan tilldela nyckelord (separerade med ",") till varje etikett. Varje gång du använder dessa nyckelord i texten i dina artiklar kommer den motsvarande etiketten att tilldelas din artikel. Notera att många automatiserade nyckelord kan öka tiden det tar att spara en artikel.');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD', 'Hittade nyckelord <strong>%s</strong>, etikett <strong><em>%s</em></strong> automatiskt tilldelad.<br />');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO', 'Hämtar artiklarna %d till %d');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL', ' (totalt %d artiklar)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT', 'Hämtar nästa uppsättning artiklar...');
@define('PLUGIN_EVENT_FREETAG_REBUILD', 'Omvärderar alla automatiserade nyckelord');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC', 'Varning: Denna funktion kommer att hämta och spara om samtliga dina artiklar. Detta kommer att ta en stund, och det kan till och med skada befintliga artiklar. Du rekommenderas att säkerhetskopiera din databas först! Tryck på "AVBRYT" för att hindra denna handling.');

@define('PLUGIN_EVENT_FREETAG_ORDER_TAGNAME', 'Etikettnamn');
@define('PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT', 'Etikettantal');

@define('PLUGIN_EVENT_FREETAG_XMLIMAGE',    'XML-bild relativt till mallsökvägen');