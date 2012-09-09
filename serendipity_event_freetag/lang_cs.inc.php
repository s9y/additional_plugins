<?php # lang_cs.inc.php 1.6 2012-05-13 14:14:41 VladaAjgl $

/**
 *  @version 1.6
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/17
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/08/25
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/11/29
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/04/12
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/01/11
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/07/05
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/05/13
 */

//
//  serendipity_event_freetag.php
//

@define('PLUGIN_EVENT_FREETAG_TITLE',		'Klíèová slova ');
@define('PLUGIN_EVENT_FREETAG_DESC',		'Umožòuje libovolné pøidávání klíèových slov k pøíspìvkùm');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC',		'Vložte libovolné množství klíèových slov, která se k èlánku vztahují. Oddìlujte èárkou (,)');
@define('PLUGIN_EVENT_FREETAG_LIST',		'Klíèová slova tohoto pøíspìvku: %s');
@define('PLUGIN_EVENT_FREETAG_USING',		'Pøíspìvky oznaèené %s');
@define('PLUGIN_EVENT_FREETAG_SUBTAG',		'Klíèová slova pøíbuzná ke slovu %s');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED',		'Žádná pøíbuzná klíèová slova');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS',		'Všechna definovaná klíèová slova');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS',		'Správa klíèových slov');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL',		'Správa všech klíèových slov');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF',		'Správa \'koncových\' klíèových slov');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED',		'Vypsat pøíspìvky bez klíèových slov');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED',		'Vypsat pøíspìvky s \'koncovými\' klíèovými slovy');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE',		'Žádné pøíspìvky bez klíèových slov!');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG',		'Klíèové slovo');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT',		'Váha');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS',		'Akce');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME',		'Pøejmenuvat');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT',		'Rozdìlit');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE',		'Smazat');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE',		'Opravdu chcete smazat klíèové slovo %s?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT',		'použijte èárku pro oddìlení slov:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD',		'Zobrazit množinu pøíbuzných klíèových slov?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER',		'Posílat HTTP hlavièku X-FreeTag');
@define('PLUGIN_EVENT_FREETAG_ADMIN_TAGLIST',		'Zobrazit seznam všech tagù pøi úpravách pøíspìvkù');
@define('PLUGIN_EVENT_FREETAG_ADMIN_FTAYT',		'Aktivovat \'Hledání-tagù-bìhem-psaní\'');

//
//  serendipity_plugin_freetag.php
//

@define('PLUGIN_FREETAG_NAME',		'Zobrazit pøíspìvky s klíèovými slovy');
@define('PLUGIN_FREETAG_BLAHBLAH',		'Zobrazí seznam existujících klíèových slov');
@define('PLUGIN_FREETAG_NEWLINE',		'Nová øádka za každým klíèovým slovem?');
@define('PLUGIN_FREETAG_XML',		'Zobrazovat XML ikony?');
@define('PLUGIN_FREETAG_SCALE',		'Mìnit velikost fontu klíèového slova podle jeho oblíbenosti (jako je to na Technorati nebo Flickru)?');
@define('PLUGIN_FREETAG_UPGRADE1_2',		'Aktualizace %d klíèových slov pro pøíspìvek è.%d');
@define('PLUGIN_FREETAG_MAX_TAGS',		'Kolik klíèových slov zobrazovat?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT',		'Kolikrát se musí klíèové slovo vyskytnout, aby bylo zobrazeno?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN',		'Nejmenší velikost fontu písma v % pøi zobrazení množiny klíèových slov');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX',		'Nejvìtší velikost fontu písma v % pøi zobrazení množiny klíèových slov');

@define('PLUGIN_EVENT_FREETAG_USE_FLASH',		'Používat Flash k zborazení množiny klíèových slov?');
@define('PLUGIN_EVENT_FREETAG_FLASH_TAG_COLOR',		'Flash - barva slov (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_FLASH_TRANSPARENT',		'Flash - prùhledné pozadí?');
@define('PLUGIN_EVENT_FREETAG_FLASH_BG_COLOR',		'Flash - barva pozadí (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_FLASH_WIDTH',		'Flash - šíøka');
@define('PLUGIN_EVENT_FREETAG_FLASH_SPEED',		'Flash - rychlost pohybu množiny klíèových slov');

@define('PLUGIN_FREETAG_META_KEYWORDS',		'Poèet klíèových slov, která mají být vložena do "meta keywords" tagu v hlavièce zdrojového HTML kódu (0: zakázat generování meta tagu)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES',		'Pøíbuzné pøípìvky podle klíèových slov:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED',		'Zobrazovat pøíbuzné pøíspìvky podle klíèových slov?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT',		'Kolik pøíbuzných pøíspìvkù má být zobrazeno?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER',		'Zobrazovat klíèová slova v patièce?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC',		'Pokud je povoleno, klíèová slova se budou zobrazovat v patièce stránky. Pokud je zakázáno, klíèová slova budou vložena do pøíspìvku.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS',		'Slova malými písmeny');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS',		'Pøíbuzná klíèová slova');
@define('PLUGIN_EVENT_FREETAG_TAGLINK',		'Odkaz na klíèové slovo');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG',		'Vytvoøit klíèová slova pøo všechny pøiøazené kategorie?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC',		'Pokud je povoleno, názvy všech kategorií, do kterých je pøíspìvek zaøazen, budou pøidány jako klíèová slova. Mùžete nastavit pøiøazení názvù kategorií jako klíèových slov pro všechny již existující pøíspìvky pomocí menu "Správa klíèových slov" v Administrativní sekci.');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE',		'Šablona postranního sloupce');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE_DESCRIPTION',		'Pokud je nastaveno, je šablona použita k vykreslení postranního sloupce s klíèovými slovy. V šablonì je pøístupná promìnná <tags>, ta obsahuje seznam tagù ve formátu <tagName> => array(href => <tagLink>, count => <tagCount>)');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS',		'Pøevést pøiøazené kategorie všech pøíspìvkù na klíèová slova');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY',		'Byly pøevedeny kategorie pøíspìvku è.%d (%s): %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG',		'Ze jmen všech kategorií byla vytvoøena klíèová slova.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS',		'Automatická klíèová slova');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC',		'Zde mùžete pøiøadit ke každému klíèovéu slovu libovolné množství obecných slov (oddìlujte èárkou ","). Kdykoliv se tato obecná slova vyskytnou v pøíspìvku, jim odpovídající klíèové slovo bude automaticky pøiøazeno k pøíspìvku. Mìjte na pamìti, že mnoho automatických slov mùže významnì zvýšit èas ukládání pøíspìvku.');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD',		'Nalezeno slovo <strong>%s</strong>, klíèové slovo <strong><em>%s</em></strong> bylo automaticky pøiøazeno.<br />');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO',		'Zobrazení pøíspìvkù %d až %d');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL',		' (celkem %d pøíspìvkù)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT',		'Zobrazování další dávky pøíspìvkù...');
@define('PLUGIN_EVENT_FREETAG_REBUILD',		'Znovupøiøazení všech automatických slov');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC',		'VAROVÁNÍ: Tato funkce pøiøadí a znovu uloží každý z pøíspìvkù. Bude to dlouho trvat a dokonce to mùže ponièit nìkteré z pøíspìvkù. Vøele se doporuèuje nejdøíve zálohovat databázi! Kliknìte na "Zrušit" pro pøerušení akce.');

@define('PLUGIN_EVENT_FREETAG_ORDER_TAGNAME',		'Klíèové slovo');
@define('PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT',		'Poèet klíèových slov');

@define('PLUGIN_EVENT_FREETAG_TECHNORATI_TAGLINK',		'Technorati odkazy');
@define('PLUGIN_EVENT_FREETAG_TECHNORATI_TAGLINK_DESC',		'Pøidá odkazy na klíèová slova z Technorati za klíèová slova v patièce stránky. Kliknutí na nì zobrazí podobné èlánky z jiných blogù nalezených na Technorati.');

@define('PLUGIN_EVENT_FREETAG_TECHNORATI_TAGLINK_IMG',		'Technorati obrázky');

@define('PLUGIN_EVENT_FREETAG_XMLIMAGE',		'XML obrázek - cesta relativní k umístìní šablon');

@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC2',		'Pokud nastaveno na "Smarty", pak bude ve smarty vytvoøena promìnná ($entry.freetag), kterou mùžete umístit kamkoliv do šablonového souboru entries.tpl.');

// Next lines were translated on 2009/11/29

@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY',		'Rozšíøené Smarty');
@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY_DESC',		'Generovat oddìlené promìnné Smarty pro pozdìjší použití v šablonách. Toto nastavení je nadøazené jiným nastavením. Pøíklad použití naleznete v Readme.');

// Next lines were translated on 2010/04/12

@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG',		'Vytváøet tagy z automatických klíèových slov?');
@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG_DESC',		'Pokud je povoleno, pak bude pøíspìvek provìøen na pøítomnost automatických klíèových slov a budou mu následnì pøidány odpovídající automatické tagy. Tato slova mùžete zadat pod položkou menu "Správa klíèových slov" v administraèní sekci.');

// Next lines were translated on 2011/01/11

@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP',		'Vyèistit namapování tagù k pøíspìvkùm');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_INFO',		'Následující seznam obsahuje tagy, které jsou pøiøazeny k neexistujícím pøíspìvkùm. Kliknìte na &quot;Vyèistit&quot; pro odstranìní tìchto nadbyteèných pøiøazení.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_NOTHING',		'Nebyly nalezeny žádné tagy, které by byly pøiøazeny k neexistujícím pøíspìvkùm. Není tedy co èistit.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_LOOKUP_ERROR',		'Tagy pøiøazeny k neexistujícícm pøíspìvkùm nemohly být nalezeny, protože došlo k chybì.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_PERFORM',		'Vyèistit');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_ENTRIES',		'ID èísla ovlivnìných pøíspìvkù');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_SUCCESSFUL',		'Všechna pøebyteèná pøiøazení byla úspìšnì odstranìna.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_FAILED',		'Odstraòování pøebyteèných pøiøazení se nezdaøilo.');

// Next lines were translated on 2011/07/05

@define('PLUGIN_EVENT_FREETAG_COLLATION',		'Porovnání (MySQL) databáze pro sloupec entrytags.tag (automatická-detekce)');

// Next lines were translated on 2012/05/13
@define('PLUGIN_EVENT_FREETAG_KILL',		'Pokud je zaškrtnuto, budou smazány všechny tagy pøiøazené k tomuto pøíspìvku.');