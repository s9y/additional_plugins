<?php # lang_cz.inc.php 1.5 2011-07-05 15:07:04 VladaAjgl $

/**
 *  @version 1.5
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
 */

//
//  serendipity_event_freetag.php
//

@define('PLUGIN_EVENT_FREETAG_TITLE',		'Klíčová slova ');
@define('PLUGIN_EVENT_FREETAG_DESC',		'Umožňuje libovolné přidávání klíčových slov k příspěvkům');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC',		'Vložte libovolné množství klíčových slov, která se k článku vztahují. Oddělujte čárkou (,)');
@define('PLUGIN_EVENT_FREETAG_LIST',		'Klíčová slova tohoto příspěvku: %s');
@define('PLUGIN_EVENT_FREETAG_USING',		'Příspěvky označené %s');
@define('PLUGIN_EVENT_FREETAG_SUBTAG',		'Klíčová slova příbuzná ke slovu %s');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED',		'Žádná příbuzná klíčová slova');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS',		'Všechna definovaná klíčová slova');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS',		'Správa klíčových slov');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL',		'Správa všech klíčových slov');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF',		'Správa \'koncových\' klíčových slov');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED',		'Vypsat příspěvky bez klíčových slov');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED',		'Vypsat příspěvky s \'koncovými\' klíčovými slovy');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE',		'Žádné příspěvky bez klíčových slov!');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG',		'Klíčové slovo');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT',		'Váha');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS',		'Akce');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME',		'Přejmenuvat');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT',		'Rozdělit');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE',		'Smazat');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE',		'Opravdu chcete smazat klíčové slovo %s?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT',		'použijte čárku pro oddělení slov:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD',		'Zobrazit množinu příbuzných klíčových slov?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER',		'Posílat HTTP hlavičku X-FreeTag');
@define('PLUGIN_EVENT_FREETAG_ADMIN_TAGLIST',		'Zobrazit seznam všech tagů při úpravách příspěvků');
@define('PLUGIN_EVENT_FREETAG_ADMIN_FTAYT',		'Aktivovat \'Hledání-tagů-během-psaní\'');

//
//  serendipity_plugin_freetag.php
//

@define('PLUGIN_FREETAG_NAME',		'Zobrazit příspěvky s klíčovými slovy');
@define('PLUGIN_FREETAG_BLAHBLAH',		'Zobrazí seznam existujících klíčových slov');
@define('PLUGIN_FREETAG_NEWLINE',		'Nová řádka za každým klíčovým slovem?');
@define('PLUGIN_FREETAG_XML',		'Zobrazovat XML ikony?');
@define('PLUGIN_FREETAG_SCALE',		'Měnit velikost fontu klíčového slova podle jeho oblíbenosti (jako je to na Technorati nebo Flickru)?');
@define('PLUGIN_FREETAG_UPGRADE1_2',		'Aktualizace %d klíčových slov pro příspěvek č.%d');
@define('PLUGIN_FREETAG_MAX_TAGS',		'Kolik klíčových slov zobrazovat?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT',		'Kolikrát se musí klíčové slovo vyskytnout, aby bylo zobrazeno?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN',		'Nejmenší velikost fontu písma v % při zobrazení množiny klíčových slov');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX',		'Největší velikost fontu písma v % při zobrazení množiny klíčových slov');

@define('PLUGIN_EVENT_FREETAG_USE_FLASH',		'Používat Flash k zborazení množiny klíčových slov?');
@define('PLUGIN_EVENT_FREETAG_FLASH_TAG_COLOR',		'Flash - barva slov (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_FLASH_TRANSPARENT',		'Flash - průhledné pozadí?');
@define('PLUGIN_EVENT_FREETAG_FLASH_BG_COLOR',		'Flash - barva pozadí (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_FLASH_WIDTH',		'Flash - šířka');
@define('PLUGIN_EVENT_FREETAG_FLASH_SPEED',		'Flash - rychlost pohybu množiny klíčových slov');

@define('PLUGIN_FREETAG_META_KEYWORDS',		'Počet klíčových slov, která mají být vložena do "meta keywords" tagu v hlavičce zdrojového HTML kódu (0: zakázat generování meta tagu)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES',		'Příbuzné přípěvky podle klíčových slov:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED',		'Zobrazovat příbuzné příspěvky podle klíčových slov?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT',		'Kolik příbuzných příspěvků má být zobrazeno?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER',		'Zobrazovat klíčová slova v patičce?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC',		'Pokud je povoleno, klíčová slova se budou zobrazovat v patičce stránky. Pokud je zakázáno, klíčová slova budou vložena do příspěvku.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS',		'Slova malými písmeny');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS',		'Příbuzná klíčová slova');
@define('PLUGIN_EVENT_FREETAG_TAGLINK',		'Odkaz na klíčové slovo');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG',		'Vytvořit klíčová slova přo všechny přiřazené kategorie?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC',		'Pokud je povoleno, názvy všech kategorií, do kterých je příspěvek zařazen, budou přidány jako klíčová slova. Můžete nastavit přiřazení názvů kategorií jako klíčových slov pro všechny již existující příspěvky pomocí menu "Správa klíčových slov" v Administrativní sekci.');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE',		'Šablona postranního sloupce');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE_DESCRIPTION',		'Pokud je nastaveno, je šablona použita k vykreslení postranního sloupce s klíčovými slovy. V šabloně je přístupná proměnná <tags>, ta obsahuje seznam tagů ve formátu <tagName> => array(href => <tagLink>, count => <tagCount>)');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS',		'Převést přiřazené kategorie všech příspěvků na klíčová slova');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY',		'Byly převedeny kategorie příspěvku č.%d (%s): %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG',		'Ze jmen všech kategorií byla vytvořena klíčová slova.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS',		'Automatická klíčová slova');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC',		'Zde můžete přiřadit ke každému klíčovéu slovu libovolné množství obecných slov (oddělujte čárkou ","). Kdykoliv se tato obecná slova vyskytnou v příspěvku, jim odpovídající klíčové slovo bude automaticky přiřazeno k příspěvku. Mějte na paměti, že mnoho automatických slov může významně zvýšit čas ukládání příspěvku.');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD',		'Nalezeno slovo <strong>%s</strong>, klíčové slovo <strong><em>%s</em></strong> bylo automaticky přiřazeno.<br />');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO',		'Zobrazení příspěvků %d až %d');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL',		' (celkem %d příspěvků)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT',		'Zobrazování další dávky příspěvků...');
@define('PLUGIN_EVENT_FREETAG_REBUILD',		'Znovupřiřazení všech automatických slov');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC',		'VAROVÁNÍ: Tato funkce přiřadí a znovu uloží každý z příspěvků. Bude to dlouho trvat a dokonce to může poničit některé z příspěvků. Vřele se doporučuje nejdříve zálohovat databázi! Klikněte na "Zrušit" pro přerušení akce.');

@define('PLUGIN_EVENT_FREETAG_ORDER_TAGNAME',		'Klíčové slovo');
@define('PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT',		'Počet klíčových slov');

@define('PLUGIN_EVENT_FREETAG_TECHNORATI_TAGLINK',		'Technorati odkazy');
@define('PLUGIN_EVENT_FREETAG_TECHNORATI_TAGLINK_DESC',		'Přidá odkazy na klíčová slova z Technorati za klíčová slova v patičce stránky. Kliknutí na ně zobrazí podobné články z jiných blogů nalezených na Technorati.');

@define('PLUGIN_EVENT_FREETAG_TECHNORATI_TAGLINK_IMG',		'Technorati obrázky');

@define('PLUGIN_EVENT_FREETAG_XMLIMAGE',		'XML obrázek - cesta relativní k umístění šablon');

@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC2',		'Pokud nastaveno na "Smarty", pak bude ve smarty vytvořena proměnná ($entry.freetag), kterou můžete umístit kamkoliv do šablonového souboru entries.tpl.');

// Next lines were translated on 2009/11/29

@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY',		'Rozšířené Smarty');
@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY_DESC',		'Generovat oddělené proměnné Smarty pro pozdější použití v šablonách. Toto nastavení je nadřazené jiným nastavením. Příklad použití naleznete v Readme.');

// Next lines were translated on 2010/04/12

@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG',		'Vytvářet tagy z automatických klíčových slov?');
@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG_DESC',		'Pokud je povoleno, pak bude příspěvek prověřen na přítomnost automatických klíčových slov a budou mu následně přidány odpovídající automatické tagy. Tato slova můžete zadat pod položkou menu "Správa klíčových slov" v administrační sekci.');

// Next lines were translated on 2011/01/11

@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP',		'Vyčistit namapování tagů k příspěvkům');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_INFO',		'Následující seznam obsahuje tagy, které jsou přiřazeny k neexistujícím příspěvkům. Klikněte na &quot;Vyčistit&quot; pro odstranění těchto nadbytečných přiřazení.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_NOTHING',		'Nebyly nalezeny žádné tagy, které by byly přiřazeny k neexistujícím příspěvkům. Není tedy co čistit.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_LOOKUP_ERROR',		'Tagy přiřazeny k neexistujícícm příspěvkům nemohly být nalezeny, protože došlo k chybě.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_PERFORM',		'Vyčistit');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_ENTRIES',		'ID čísla ovlivněných příspěvků');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_SUCCESSFUL',		'Všechna přebytečná přiřazení byla úspěšně odstraněna.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_FAILED',		'Odstraňování přebytečných přiřazení se nezdařilo.');

// Next lines were translated on 2011/07/05
@define('PLUGIN_EVENT_FREETAG_COLLATION',		'Porovnání (MySQL) databáze pro sloupec entrytags.tag (automatická-detekce)');