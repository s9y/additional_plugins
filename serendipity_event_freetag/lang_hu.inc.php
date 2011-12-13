<?php # $Id: lang_hu.inc.php,v 1.1 2007/03/25 21:48:56 norbertmocsnik Exp $

/**
 *  @version $Revision: 1.1 $
 *  @author Norbert Mocsnik <norbert@mocsnik.hu>
 *  EN-Revision: 1.15
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', 'Bejegyzések címkézése');
@define('PLUGIN_EVENT_FREETAG_DESC', 'Címkék megadását teszi lehetõvé tetszõleges kombinációban');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', 'Adj meg tetszõleges számú címkét, vesszõvel (,) elválasztva');
@define('PLUGIN_EVENT_FREETAG_LIST', 'Címkék: %s');
@define('PLUGIN_EVENT_FREETAG_USING', 'Bejegyzések %s címkével');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', '%s címke kapcsolódó címkéi');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED','Nincsenek kapcsolódó címkék.');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', 'Összes címke');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', 'Címkék kezelése');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', 'Minden címke kezelése');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', 'Egyedi címkék kezelése');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', 'Bejegyzések címke nélkül');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', 'Egyedi címkés bejegyzések');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', 'Nincsenek címkézetlen bejegyzések.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', 'Címke');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', 'Súly');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', 'Mûvelet');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', 'Átnevezés');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', 'Felosztás');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', 'Törlés');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', 'Törölni kívánod a következõ címkét: %s?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'use a comma to seperate tags:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', 'Címke felhõ mutatása a kapcsolódó címkékkel?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER', 'X-FreeTag-HTTP fejlécek küldése');
//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'Címkézett bejegyzések listázása');
@define('PLUGIN_FREETAG_BLAHBLAH', 'Kilistázza a meglévõ címkéket');
@define('PLUGIN_FREETAG_NEWLINE', 'Soremelés minden címke után?');
@define('PLUGIN_FREETAG_XML', 'XML-ikonok megjelenítése?');
@define('PLUGIN_FREETAG_SCALE','Címke betûméret nyújtás/zsugorítás népszerûség alapján (a Technorati-hoz és a flickr-hez hasonlóan)?');
@define('PLUGIN_FREETAG_UPGRADE1_2','%d db címke frissítése a %d. bejegyzéshez: ');
@define('PLUGIN_FREETAG_MAX_TAGS', 'Mennyi címkét mutassunk?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'Mennyi elõfordulás felett jelenjenek meg a címkék?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'Minimum betûméret% a címkefelhõben');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'Maximum betûméret% a címkefelhõben');

@define('PLUGIN_FREETAG_META_KEYWORDS', 'HTML forrásba ágyazandó meta kulcsszavak száma (0: letiltás)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Kapcsolódó bejegyzések címkék alapján:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED','Mutassuk a címke alapján kapcsolódó bejegyzéseket?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT','Mennyi kapcsolódó bejegyzést mutassunk?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', 'Címkék mutatása a láblécben?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', 'Ha engedélyezett, az egyes bejegyzéshez rendelt címkék a láblécben jelennek meg. Kikapcsolt állapotban a címkék a bejegyzés Részletesebb Törzsében jelennek meg.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', 'Kisbetûs címkék használata');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS', 'Kapcsolódó címkék');
@define('PLUGIN_EVENT_FREETAG_TAGLINK', 'Címkelink');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG', 'Létrehozzuk a címkéket minden hozzárendelt kategória alapján?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC', 'Bekapcsolt állapotában minden kategória címke formájában is hozzárendelõdik a bejegyzéshez. Az összes meglévõ bejegyzés konvertálását az Adminisztrációs Készlet Címkék kezelése menüpontjában lehet megtenni.');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS', 'Meglévõ bejegyzések minden hozzárendelt kategóriáinák konvertálása címkékké');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY', '#%d (%s) bejegyzés konvertált kategóriái: %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG', 'Minden kategóriát címkékké konvertáltunk.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS', 'Automatizált kulcsszavak');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC', 'Minden címkéhez megadhatók kulcsszavak (vesszõvel elválasztva). Amikor ezeket a kulcsszavakat használjuk a bejegyzések szövegében, a megfelelõ címke hozzárendelõdik a bejegyzéshez. Túl sok automatizált kulcsszó megnövelheti a bejegyzések elmentésével töltött idõt!');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD', 'Megtaláltuk a következõ kulcsszót: <strong>%s</strong>, a következõ címkét automatikusan a bejegyzéshez rendeljük: <strong><em>%s</em></strong><br />');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO', '%d-%d bejegyzések lekérése');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL', ' (összesen %d bejegyzés)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT', 'Következõ köteg bejegyzés lekérése...');
@define('PLUGIN_EVENT_FREETAG_REBUILD', 'Minden automatizált kulcsszó újragenerálása');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC', 'Figyelmeztetés: Ez a funkció minden egyes bejegyzést külön-külön betölt és újra elment. Ez eltart egy ideig és elõfordulhat, hogy megsérülnek a meglévõ bejegyzések. Ajánlott elõbb egy biztonsági másolat készítése az adatbázisról! Kattints a "Mégsem" gombra a mûvelet megszakításához!');

@define('PLUGIN_EVENT_FREETAG_ORDER_TAGNAME', 'Címkenév');
@define('PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT', 'Címke elõfordulások száma');