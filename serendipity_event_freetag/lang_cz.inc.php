<?php

/**
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
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/20
 */

//
//  serendipity_event_freetag.php
//

@define('PLUGIN_EVENT_FREETAG_TITLE',		'Klíèová slova');
@define('PLUGIN_EVENT_FREETAG_DESC',		'Umo¾òuje libovolné pøidávání klíèových slov k pøíspìvkùm');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC',		'Vlo¾te libovolné mno¾ství klíèových slov, která se k èlánku vztahují. Oddìlujte èárkou (,)');
@define('PLUGIN_EVENT_FREETAG_LIST',		'Klíèová slova tohoto pøíspìvku: %s');
@define('PLUGIN_EVENT_FREETAG_USING',		'Pøíspìvky oznaèené %s');
@define('PLUGIN_EVENT_FREETAG_SUBTAG',		'Klíèová slova pøíbuzná ke slovu %s');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED',		'®ádná pøíbuzná klíèová slova');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS',		'V¹echna definovaná klíèová slova');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS',		'Správa klíèových slov');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL',		'Správa v¹ech klíèových slov');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF',		'Správa \'koncových\' klíèových slov');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED',		'Vypsat pøíspìvky bez klíèových slov');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED',		'Vypsat pøíspìvky s \'koncovými\' klíèovými slovy');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE',		'®ádné pøíspìvky bez klíèových slov!');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG',		'Klíèové slovo');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT',		'Váha');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS',		'Akce');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME',		'Pøejmenuvat');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT',		'Rozdìlit');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE',		'Smazat');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE',		'Opravdu chcete smazat klíèové slovo %s?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT',		'pou¾ijte èárku pro oddìlení slov:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD',		'Zobrazit mno¾inu pøíbuzných klíèových slov?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER',		'Posílat HTTP hlavièku X-FreeTag');
@define('PLUGIN_EVENT_FREETAG_ADMIN_TAGLIST',		'Zobrazit seznam v¹ech tagù pøi úpravách pøíspìvkù');
@define('PLUGIN_EVENT_FREETAG_ADMIN_FTAYT',		'Aktivovat \'Hledání-tagù-bìhem-psaní\'');

//
//  serendipity_plugin_freetag.php
//

@define('PLUGIN_FREETAG_NAME',		'Zobrazit pøíspìvky s klíèovými slovy');
@define('PLUGIN_FREETAG_BLAHBLAH',		'Zobrazí seznam existujících klíèových slov');
@define('PLUGIN_FREETAG_NEWLINE',		'Nová øádka za ka¾dým klíèovým slovem?');
@define('PLUGIN_FREETAG_XML',		'Zobrazovat XML ikony?');
@define('PLUGIN_FREETAG_SCALE',		'Mìnit velikost fontu klíèového slova podle jeho oblíbenosti (jako je to na Technorati nebo Flickru)?');
@define('PLUGIN_FREETAG_UPGRADE1_2',		'Aktualizace %d klíèových slov pro pøíspìvek è.%d');
@define('PLUGIN_FREETAG_MAX_TAGS',		'Kolik klíèových slov zobrazovat?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT',		'Kolikrát se musí klíèové slovo vyskytnout, aby bylo zobrazeno?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN',		'Nejmen¹í velikost fontu písma v % pøi zobrazení mno¾iny klíèových slov');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX',		'Nejvìt¹í velikost fontu písma v % pøi zobrazení mno¾iny klíèových slov');

@define('PLUGIN_EVENT_FREETAG_USE_FLASH',		'Pou¾ívat Flash k zborazení mno¾iny klíèových slov?');
@define('PLUGIN_EVENT_FREETAG_FLASH_TAG_COLOR',		'Flash - barva slov (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_FLASH_TRANSPARENT',		'Flash - prùhledné pozadí?');
@define('PLUGIN_EVENT_FREETAG_FLASH_BG_COLOR',		'Flash - barva pozadí (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_FLASH_WIDTH',		'Flash - ¹íøka');
@define('PLUGIN_EVENT_FREETAG_FLASH_SPEED',		'Flash - rychlost pohybu mno¾iny klíèových slov');

@define('PLUGIN_FREETAG_META_KEYWORDS',		'Poèet klíèových slov, která mají být vlo¾ena do "meta keywords" tagu v hlavièce zdrojového HTML kódu (0: zakázat generování meta tagu)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES',		'Pøíbuzné pøípìvky podle klíèových slov:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED',		'Zobrazovat pøíbuzné pøíspìvky podle klíèových slov?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT',		'Kolik pøíbuzných pøíspìvkù má být zobrazeno?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER',		'Zobrazovat klíèová slova v patièce?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC',		'Pokud je povoleno, klíèová slova se budou zobrazovat v patièce stránky. Pokud je zakázáno, klíèová slova budou vlo¾ena do pøíspìvku.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS',		'Slova malými písmeny');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS',		'Pøíbuzná klíèová slova');
@define('PLUGIN_EVENT_FREETAG_TAGLINK',		'Odkaz na klíèové slovo');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG',		'Vytvoøit klíèová slova pøo v¹echny pøiøazené kategorie?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC',		'Pokud je povoleno, názvy v¹ech kategorií, do kterých je pøíspìvek zaøazen, budou pøidány jako klíèová slova. Mù¾ete nastavit pøiøazení názvù kategorií jako klíèových slov pro v¹echny ji¾ existující pøíspìvky pomocí menu "Správa klíèových slov" v Administrativní sekci.');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE',		'©ablona postranního sloupce');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE_DESCRIPTION',		'Pokud je nastaveno, je ¹ablona pou¾ita k vykreslení postranního sloupce s klíèovými slovy. V ¹ablonì je pøístupná promìnná <tags>, ta obsahuje seznam tagù ve formátu <tagName> => array(href => <tagLink>, count => <tagCount>)');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS',		'Pøevést pøiøazené kategorie v¹ech pøíspìvkù na klíèová slova');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY',		'Byly pøevedeny kategorie pøíspìvku è.%d (%s): %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG',		'Ze jmen v¹ech kategorií byla vytvoøena klíèová slova.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS',		'Automatická klíèová slova');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC',		'Zde mù¾ete pøiøadit ke ka¾dému klíèovéu slovu libovolné mno¾ství obecných slov (oddìlujte èárkou ","). Kdykoliv se tato obecná slova vyskytnou v pøíspìvku, jim odpovídající klíèové slovo bude automaticky pøiøazeno k pøíspìvku. Mìjte na pamìti, ¾e mnoho automatických slov mù¾e významnì zvý¹it èas ukládání pøíspìvku.');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD',		'Nalezeno slovo <strong>%s</strong>, klíèové slovo <strong><em>%s</em></strong> bylo automaticky pøiøazeno.<br />');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO',		'Zobrazení pøíspìvkù %d a¾ %d');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL',		' (celkem %d pøíspìvkù)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT',		'Zobrazování dal¹í dávky pøíspìvkù...');
@define('PLUGIN_EVENT_FREETAG_REBUILD',		'Znovupøiøazení v¹ech automatických slov');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC',		'VAROVÁNÍ: Tato funkce pøiøadí a znovu ulo¾í ka¾dý z pøíspìvkù. Bude to dlouho trvat a dokonce to mù¾e ponièit nìkteré z pøíspìvkù. Vøele se doporuèuje nejdøíve zálohovat databázi! Kliknìte na "Zru¹it" pro pøeru¹ení akce.');

@define('PLUGIN_EVENT_FREETAG_ORDER_TAGNAME',		'Klíèové slovo');
@define('PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT',		'Poèet klíèových slov');

@define('PLUGIN_EVENT_FREETAG_XMLIMAGE',		'XML obrázek - cesta relativní k umístìní ¹ablon');

@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC2',		'Pokud nastaveno na "Smarty", pak bude ve smarty vytvoøena promìnná ($entry.freetag), kterou mù¾ete umístit kamkoliv do ¹ablonového souboru entries.tpl.');

// Next lines were translated on 2009/11/29

@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY',		'Roz¹íøené Smarty');
@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY_DESC',		'Generovat oddìlené promìnné Smarty pro pozdìj¹í pou¾ití v ¹ablonách. Toto nastavení je nadøazené jiným nastavením. Pøíklad pou¾ití naleznete v Readme.');

// Next lines were translated on 2010/04/12

@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG',		'Vytváøet tagy z automatických klíèových slov?');
@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG_DESC',		'Pokud je povoleno, pak bude pøíspìvek provìøen na pøítomnost automatických klíèových slov a budou mu následnì pøidány odpovídající automatické tagy. Tato slova mù¾ete zadat pod polo¾kou menu "Správa klíèových slov" v administraèní sekci.');

// Next lines were translated on 2011/01/11

@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP',		'Vyèistit namapování tagù k pøíspìvkùm');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_INFO',		'Následující seznam obsahuje tagy, které jsou pøiøazeny k neexistujícím pøíspìvkùm. Kliknìte na &quot;Vyèistit&quot; pro odstranìní tìchto nadbyteèných pøiøazení.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_NOTHING',		'Nebyly nalezeny ¾ádné tagy, které by byly pøiøazeny k neexistujícím pøíspìvkùm. Není tedy co èistit.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_LOOKUP_ERROR',		'Tagy pøiøazeny k neexistujícícm pøíspìvkùm nemohly být nalezeny, proto¾e do¹lo k chybì.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_PERFORM',		'Vyèistit');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_ENTRIES',		'ID èísla ovlivnìných pøíspìvkù');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_SUCCESSFUL',		'V¹echna pøebyteèná pøiøazení byla úspì¹nì odstranìna.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_FAILED',		'Odstraòování pøebyteèných pøiøazení se nezdaøilo.');

// Next lines were translated on 2011/07/05

@define('PLUGIN_EVENT_FREETAG_COLLATION',		'Porovnání (MySQL) databáze pro sloupec entrytags.tag (automatická-detekce)');

// Next lines were translated on 2012/05/13

@define('PLUGIN_EVENT_FREETAG_KILL',		'Pokud je za¹krtnuto, budou smazány v¹echny tagy pøiøazené k tomuto pøíspìvku.');