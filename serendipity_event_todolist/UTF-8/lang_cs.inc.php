<?php # lang_cs.inc.php 1.0 2009-05-24 09:29:24 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/24
 */

@define('PLUGIN_EVENT_TODOLIST_TITLE', 'Seznam úkolů / ToDo list / projektové řízení');
@define('PLUGIN_EVENT_TODOLIST_DESC', 'Správa seznamu projektů/úkolů a jejich splnění v procentech');
@define('PLUGIN_EVENT_TODOLIST_PROJECT', 'Projekt');
@define('PLUGIN_EVENT_TODOLIST_PROJECT_NAME', 'Název');
@define('PLUGIN_EVENT_TODOLIST_HIDDEN', 'Skrytý');
@define('PLUGIN_EVENT_TODOLIST_PERCENTDONE', '% hotovo');
@define('PLUGIN_EVENT_TODOLIST_BLOGENTRY', 'Příspěvek blogu');
@define('PLUGIN_EVENT_TODOLIST_ADMINPROJECT', 'Správa projektů');
@define('PLUGIN_EVENT_TODOLIST_ORDER', 'Řazení podle:');
@define('PLUGIN_EVENT_TODOLIST_ORDER_DESC', 'Vyberte, jak řadit výpis projektů.');
@define('PLUGIN_EVENT_TODOLIST_ORDER_NUM_ORDER', 'Vlastní řazení');
@define('PLUGIN_EVENT_TODOLIST_ORDER_DATE_ACS', 'Datum (od nejstarších po nejnovější)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_DATE_DESC', 'Datum (od nejnovějších po nejstarší)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_PROGRESS_ASC', 'Vývoj (od nejméně hotových, po kompletní)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_PROGRESS_DESC', 'Vývoj (od kompletních po nejméně hotové)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_CATEGORY', 'Podle kategorií');
@define('PLUGIN_EVENT_TODOLIST_ORDER_JSCATEGORY', 'Podle kategorií, použít Javascript');
@define('PLUGIN_EVENT_TODOLIST_ORDER_ALPHA', 'Abecedně');
@define('PLUGIN_EVENT_TODOLIST_PROJECTS', 'Správa projektů');
@define('PLUGIN_EVENT_TODOLIST_NOPROJECTS', 'Žádné projekty v seznamu');
@define('PLUGIN_EVENT_TODOLIST_TITLEDESC','Nadpis postranního bloku v blogu.');
@define('PLUGIN_EVENT_TODOLIST_COLOR1', 'Barva vnitřku');
@define('PLUGIN_EVENT_TODOLIST_COLOR2', 'Barva vnějšku');
@define('PLUGIN_EVENT_TODOLIST_COLORCONFIG', 'Výchozí barva ukazatele vývoje');
@define('PLUGIN_EVENT_TODOLIST_COLORCONFIGDESC', 'Vyberte výchozí barvu pro ukazatel stupně vývoje projektu. Barvy můžete přidávat nebo měnit na stránce "Správa barev". Nastavení se projeví pouze pokud máte instalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_BACKGROUNDCOLOR', 'Barva pozadí ukazatele vývoje');
@define('PLUGIN_EVENT_TODOLIST_BACKGROUNDCOLORDESC', 'Zadejte 6-ti cifernou hexadecimální hodnotu. Např FFFFFF je bílá. Nastavení se projeví pouze pokud máte nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_WHITETEXTBORDER', 'Bílý obrys písma');
@define('PLUGIN_EVENT_TODOLIST_WHITETEXTBORDERDESC', 'Pokud používáte tmavé pozadí a text se na nich ztrácí, možná zlepšíte čitelnost nastavením bílého okraje písma.');
@define('PLUGIN_EVENT_TODOLIST_OUTSIDETEXT', 'Text mimo ukazatel vývoje.');
@define('PLUGIN_EVENT_TODOLIST_OUTSIDETEXTDESC', 'Tato volba nastavuje výpis vývoje projektu v procentech vpravo od ukazatele vývoje, místo výchozího prostředku ukazatele.');
@define('PLUGIN_EVENT_TODOLIST_BARLENGTH', 'Délka ukazatele vývoje');
@define('PLUGIN_EVENT_TODOLIST_BARLENGTHDESC', 'Délka v pixelech. Nastavení se používá na ukazatele vyjma řazení podle kategorií. Toto nastavení vyžaduje nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_BARHEIGHT', 'Výška ukazatele vývoje');
@define('PLUGIN_EVENT_TODOLIST_BARHEIGHTDESC', 'Výška v pixelech. Toto nastavení vyžaduje nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_FONTSIZE', 'Velikost fontu písma');
@define('PLUGIN_EVENT_TODOLIST_FONTSIZEDESC', 'Velikost v pixelech. Toto nastavení vyžaduje nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_FONT', 'Font');
@define('PLUGIN_EVENT_TODOLIST_FONTDESC', 'Zadejte název fontu použitého pro text v ukazateli vývoje. Do adresáře '.dirname(__FILE__).'/fonts/ můžete přidat další vlastní fonty. Musejí být typu TrueType. Toto nastavení vyžaduje nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_CATBARLENGTH', 'Délka ukazatele vývoje (pro řazení podle kategorií)');
@define('PLUGIN_EVENT_TODOLIST_CATBARLENGTHDESC', 'Délka ukazatele vývoje pro případ, kdy jsou projekty řazené podle kategorií. Pravděpodobně budete chtít v tomto případě kratší ukazatel, protože nějaké místo sebere zobrazení kategorií. Toto nastavení vyžaduje nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_CACHEIMAGE', 'Cachovat vygenerovanou grafiku');
@define('PLUGIN_EVENT_TODOLIST_CACHEIMAGEDESC', 'Cachovat kopie všech vytvořených ukazatelů vývoje. Příznivě ovlivňuje dobu načítání stránky a snižuje zátěž serveru. Toto nastavení vyžaduje nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_NUMENTRIES', 'Počet zobrazených příspěvků blogu');
@define('PLUGIN_EVENT_TODOLIST_NUMENTRIESDESC', 'Zobrazit tento počet nejnovějších příspěvků při výběru příspěvku blogu z ukazatele vývoje.');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY', 'Používat kategorie');
@define('PLUGIN_EVENT_TODOLIST_CATEGORYDESC','Používat kategorie k řazení a třídění projektů.');
@define('PLUGIN_EVENT_TODOLIST_ADDPROJECT','Přidat projekt');
@define('PLUGIN_EVENT_TODOLIST_EDITPROJECT','Upravit projekt');
@define('PLUGIN_EVENT_TODOLIST_PERCENTAGECOMPLETE','Stupeň vývoje projektu v procentech');
@define('PLUGIN_EVENT_TODOLIST_PROJECTDESC','Popis projektu');
@define('PLUGIN_EVENT_TODOLIST_DEFAULT_NOTE','Pamatujte, že toto je plugin událostí a k tomu, aby se jeho výstup objevil v postranním sloupci musíte použít plugin Event Output Wrapper nebo jiný postraní plugin, který dokáže zobrazit jeho obsah.');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME','Použitý systém kategorií:');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_DESC','Můžete si vybrat, jestli chcete použít stejný systém kategorií, jaký mají příspěvky blogu, nebo vlastní oddělený systém kategorií.');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_CUSTOM','Vlastní');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_DEFAULT','Výchozí (z blogu)');
@define('PLUGIN_EVENT_TODOLIST_CATDB_WARNING','Nastavili jste použití vlastního systému kategorií, ale databázová tabulka s kategoriemi ještě neexistuje. Klikněte sem a tabulka bude vytvořena.');
@define('PLUGIN_EVENT_TODOLIST_ADD_CAT','Správa kategorií');
@define('PLUGIN_EVENT_TODOLIST_ADD_COLOR','Přidat barvu');
@define('PLUGIN_EVENT_TODOLIST_MANAGE_COLORS','Správa barev');
@define('PLUGIN_EVENT_TODOLIST_CAT_NAME','Název kategorie');
@define('PLUGIN_EVENT_TODOLIST_PARENT_CATEGORY','Rodič = nadřazená kategorie');
@define('PLUGIN_EVENT_TODOLIST_ADMINCAT','Správa kategorií');
@define('PLUGIN_EVENT_TODOLIST_CACHE_NAME','Cachovat postranní sloupec');
@define('PLUGIN_EVENT_TODOLIST_CACHE_DESC','Cachování postranního sloupce zvyšuje rychlost načítání blogu.');
@define('PLUGIN_EVENT_TODOLIST_NOGDLIB', 'Vypadá to, že nemáte nainstalovanou knihovnu PHP GD. Statické obrázky vývoje jsou předpřipravené po 5%, takže výsledky splnění projektu budou zaokrouhleny na nejbližších 5%.');
@define('PLUGIN_EVENT_TODOLIST_ADDCOLOR_NAME', 'Název barvy (použitý v rozbalovacích nabídkách pro výběr barvy)');
@define('PLUGIN_EVENT_TODOLIST_ADDCOLOR_COLOR1', 'Barva vnitřku ukazatele vývoje (hexadecimální hodnota jako apř. ff3333). Pro vnitřek ukazatele doporučujeme světlejší barvy.');
@define('PLUGIN_EVENT_TODOLIST_ADDCOLOR_COLOR2', 'Barva vnějšku ukazatele vývoje  (hexadecimální hodnota jako apř. ff3333)');
@define('PLUGIN_EVENT_TODOLIST_COLOR', 'Barva');
@define('PLUGIN_EVENT_TODOLIST_SAMPLE', 'Ukázka');
@define('PLUGIN_EVENT_TODOLIST_COLORWHEEL', 'Barevné kolo');
@define('PLUGIN_EVENT_TODOLIST_COLORWHEEL_INSTRUCTIONS', 'Pohybujte se s myší nad barevným kolem nebo čtvercem sytosti pro zobrazení náhledu barvy. Kliknutím vyberete barvu. Kopírujte (Ctrl-C) a vložte (Ctrl-V) šestimístný kód barvy do políčka pro barvu.');

?>
