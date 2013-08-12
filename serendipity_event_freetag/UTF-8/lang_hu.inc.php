<?php # 

/**
 *  @version $Revision$
 *  @author Norbert Mocsnik <norbert@mocsnik.hu>
 *  EN-Revision: 1.15
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', 'Bejegyzések címkézése');
@define('PLUGIN_EVENT_FREETAG_DESC', 'Címkék megadását teszi lehetővé tetszőleges kombinációban');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', 'Adj meg tetszőleges számú címkét, vesszővel (,) elválasztva');
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
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', 'Művelet');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', 'Átnevezés');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', 'Felosztás');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', 'Törlés');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', 'Törölni kívánod a következő címkét: %s?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'use a comma to seperate tags:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', 'Címke felhő mutatása a kapcsolódó címkékkel?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER', 'X-FreeTag-HTTP fejlécek küldése');
//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'Címkézett bejegyzések listázása');
@define('PLUGIN_FREETAG_BLAHBLAH', 'Kilistázza a meglévő címkéket');
@define('PLUGIN_FREETAG_NEWLINE', 'Soremelés minden címke után?');
@define('PLUGIN_FREETAG_XML', 'XML-ikonok megjelenítése?');
@define('PLUGIN_FREETAG_SCALE','Címke betűméret nyújtás/zsugorítás népszerűség alapján (a Technorati-hoz és a flickr-hez hasonlóan)?');
@define('PLUGIN_FREETAG_UPGRADE1_2','%d db címke frissítése a %d. bejegyzéshez: ');
@define('PLUGIN_FREETAG_MAX_TAGS', 'Mennyi címkét mutassunk?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'Mennyi előfordulás felett jelenjenek meg a címkék?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'Minimum betűméret% a címkefelhőben');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'Maximum betűméret% a címkefelhőben');

@define('PLUGIN_FREETAG_META_KEYWORDS', 'HTML forrásba ágyazandó meta kulcsszavak száma (0: letiltás)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Kapcsolódó bejegyzések címkék alapján:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED','Mutassuk a címke alapján kapcsolódó bejegyzéseket?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT','Mennyi kapcsolódó bejegyzést mutassunk?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', 'Címkék mutatása a láblécben?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', 'Ha engedélyezett, az egyes bejegyzéshez rendelt címkék a láblécben jelennek meg. Kikapcsolt állapotban a címkék a bejegyzés Részletesebb Törzsében jelennek meg.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', 'Kisbetűs címkék használata');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS', 'Kapcsolódó címkék');
@define('PLUGIN_EVENT_FREETAG_TAGLINK', 'Címkelink');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG', 'Létrehozzuk a címkéket minden hozzárendelt kategória alapján?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC', 'Bekapcsolt állapotában minden kategória címke formájában is hozzárendelődik a bejegyzéshez. Az összes meglévő bejegyzés konvertálását az Adminisztrációs Készlet Címkék kezelése menüpontjában lehet megtenni.');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS', 'Meglévő bejegyzések minden hozzárendelt kategóriáinák konvertálása címkékké');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY', '#%d (%s) bejegyzés konvertált kategóriái: %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG', 'Minden kategóriát címkékké konvertáltunk.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS', 'Automatizált kulcsszavak');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC', 'Minden címkéhez megadhatók kulcsszavak (vesszővel elválasztva). Amikor ezeket a kulcsszavakat használjuk a bejegyzések szövegében, a megfelelő címke hozzárendelődik a bejegyzéshez. Túl sok automatizált kulcsszó megnövelheti a bejegyzések elmentésével töltött időt!');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD', 'Megtaláltuk a következő kulcsszót: <strong>%s</strong>, a következő címkét automatikusan a bejegyzéshez rendeljük: <strong><em>%s</em></strong><br />');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO', '%d-%d bejegyzések lekérése');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL', ' (összesen %d bejegyzés)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT', 'Következő köteg bejegyzés lekérése...');
@define('PLUGIN_EVENT_FREETAG_REBUILD', 'Minden automatizált kulcsszó újragenerálása');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC', 'Figyelmeztetés: Ez a funkció minden egyes bejegyzést külön-külön betölt és újra elment. Ez eltart egy ideig és előfordulhat, hogy megsérülnek a meglévő bejegyzések. Ajánlott előbb egy biztonsági másolat készítése az adatbázisról! Kattints a "Mégsem" gombra a művelet megszakításához!');

@define('PLUGIN_EVENT_FREETAG_ORDER_TAGNAME', 'Címkenév');
@define('PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT', 'Címke előfordulások száma');