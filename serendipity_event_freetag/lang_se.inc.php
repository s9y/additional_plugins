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
@define('PLUGIN_EVENT_FREETAG_LIST', 'Etiketter p� denna artikel: %s');
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
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'anv�nd komma f�r att separera etiketter:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', 'Visa etikettmoln f�r relaterade etiketter?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER', 'Skicka X-FreeTag-HTTP-Headers');
@define('PLUGIN_EVENT_FREETAG_ADMIN_TAGLIST', 'Visa klickbar lista med alla etiketter vid inmatning av artikel');
@define('PLUGIN_EVENT_FREETAG_ADMIN_FTAYT', 'Aktivera Hitta-etiketter-medan-du-skriver');

//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'Visa artiklar med etiketter');
@define('PLUGIN_FREETAG_BLAHBLAH', 'Visar en lista med existerande etiketter p� artiklar');
@define('PLUGIN_FREETAG_NEWLINE', 'Radmatning efter varje etikett?');
@define('PLUGIN_FREETAG_XML', 'Visa XML-ikoner?');
@define('PLUGIN_FREETAG_SCALE','Skala storleken p� etiketter efter popularitet (som Technorati, flickr)?');
@define('PLUGIN_FREETAG_UPGRADE1_2','Uppgraderar %d etiketter f�r artikel nummer: %d');
@define('PLUGIN_FREETAG_MAX_TAGS', 'Hur m�nga etiketter skall visas?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'Hur m�nga f�rekomster m�ste en etikett ha f�r att visas?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'Storlek i % p� minsta etikett i etikettmoln');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'Storlek i % p� st�rsta etikett i etikettmoln');

@define('PLUGIN_FREETAG_META_KEYWORDS', 'Antal meta-nyckelord att b�dda in i HTML-k�llkoden (0: deaktiverad)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Artiklar med relaterade etiketter:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED','Visa artiklar med relaterade etiketter?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT','Hur m�nga relaterade artiklar skall visas?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', 'Visa etiketter i artikelfoten?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', 'Om ja, kommer etiketterna att visas i artikelns sidfot. Om nej, kommer etiketterna att visas i inneh�llet/det ut�kade inneh�llet i dina artiklar.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', 'Gemena etiketter');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS', 'Relaterade etiketter');
@define('PLUGIN_EVENT_FREETAG_TAGLINK', 'Etikettl�nk');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG', 'Skapa etiketter f�r alla motsvarande kategorier?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC', 'Om ja, kommer alla kategorier som en artikel tillh�r att adderas som etiketter p� din artikel. Du kan st�lla in alla kategoriassociationer f�r dina befintliga artiklar under "Hantera etiketter" i menyn i administrationsgr�nssnittet.');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS', 'Konvertera alla tilldelade kategorier f�r befintliga artiklar till etiketter.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY', 'Konverterade kategorier f�r artikel #%d (%s): %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG', 'Alla kategorier som konverterats till etiketter.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS', 'Automatiserade nyckelord');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC', 'Du kan tilldela nyckelord (separerade med ",") till varje etikett. Varje g�ng du anv�nder dessa nyckelord i texten i dina artiklar kommer den motsvarande etiketten att tilldelas din artikel. Notera att m�nga automatiserade nyckelord kan �ka tiden det tar att spara en artikel.');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD', 'Hittade nyckelord <strong>%s</strong>, etikett <strong><em>%s</em></strong> automatiskt tilldelad.<br />');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO', 'H�mtar artiklarna %d till %d');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL', ' (totalt %d artiklar)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT', 'H�mtar n�sta upps�ttning artiklar...');
@define('PLUGIN_EVENT_FREETAG_REBUILD', 'Omv�rderar alla automatiserade nyckelord');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC', 'Varning: Denna funktion kommer att h�mta och spara om samtliga dina artiklar. Detta kommer att ta en stund, och det kan till och med skada befintliga artiklar. Du rekommenderas att s�kerhetskopiera din databas f�rst! Tryck p� "AVBRYT" f�r att hindra denna handling.');

@define('PLUGIN_EVENT_FREETAG_ORDER_TAGNAME', 'Etikettnamn');
@define('PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT', 'Etikettantal');

@define('PLUGIN_EVENT_FREETAG_XMLIMAGE',    'XML-bild relativt till malls�kv�gen');