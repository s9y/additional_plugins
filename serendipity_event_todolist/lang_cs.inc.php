<?php # lang_cs.inc.php 1.0 2009-05-24 09:29:24 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/24
 */

@define('PLUGIN_EVENT_TODOLIST_TITLE', 'Seznam úkolù / ToDo list / projektové øízení');
@define('PLUGIN_EVENT_TODOLIST_DESC', 'Správa seznamu projektù/úkolù a jejich splnìní v procentech');
@define('PLUGIN_EVENT_TODOLIST_PROJECT', 'Projekt');
@define('PLUGIN_EVENT_TODOLIST_PROJECT_NAME', 'Název');
@define('PLUGIN_EVENT_TODOLIST_HIDDEN', 'Skrytý');
@define('PLUGIN_EVENT_TODOLIST_PERCENTDONE', '% hotovo');
@define('PLUGIN_EVENT_TODOLIST_BLOGENTRY', 'Pøíspìvek blogu');
@define('PLUGIN_EVENT_TODOLIST_ADMINPROJECT', 'Správa projektù');
@define('PLUGIN_EVENT_TODOLIST_ORDER', 'Øazení podle:');
@define('PLUGIN_EVENT_TODOLIST_ORDER_DESC', 'Vyberte, jak øadit výpis projektù.');
@define('PLUGIN_EVENT_TODOLIST_ORDER_NUM_ORDER', 'Vlastní øazení');
@define('PLUGIN_EVENT_TODOLIST_ORDER_DATE_ACS', 'Datum (od nejstarších po nejnovìjší)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_DATE_DESC', 'Datum (od nejnovìjších po nejstarší)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_PROGRESS_ASC', 'Vývoj (od nejménì hotových, po kompletní)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_PROGRESS_DESC', 'Vývoj (od kompletních po nejménì hotové)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_CATEGORY', 'Podle kategorií');
@define('PLUGIN_EVENT_TODOLIST_ORDER_JSCATEGORY', 'Podle kategorií, použít Javascript');
@define('PLUGIN_EVENT_TODOLIST_ORDER_ALPHA', 'Abecednì');
@define('PLUGIN_EVENT_TODOLIST_PROJECTS', 'Správa projektù');
@define('PLUGIN_EVENT_TODOLIST_NOPROJECTS', 'Žádné projekty v seznamu');
@define('PLUGIN_EVENT_TODOLIST_TITLEDESC','Nadpis postranního bloku v blogu.');
@define('PLUGIN_EVENT_TODOLIST_COLOR1', 'Barva vnitøku');
@define('PLUGIN_EVENT_TODOLIST_COLOR2', 'Barva vnìjšku');
@define('PLUGIN_EVENT_TODOLIST_COLORCONFIG', 'Výchozí barva ukazatele vývoje');
@define('PLUGIN_EVENT_TODOLIST_COLORCONFIGDESC', 'Vyberte výchozí barvu pro ukazatel stupnì vývoje projektu. Barvy mùžete pøidávat nebo mìnit na stránce "Správa barev". Nastavení se projeví pouze pokud máte instalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_BACKGROUNDCOLOR', 'Barva pozadí ukazatele vývoje');
@define('PLUGIN_EVENT_TODOLIST_BACKGROUNDCOLORDESC', 'Zadejte 6-ti cifernou hexadecimální hodnotu. Napø FFFFFF je bílá. Nastavení se projeví pouze pokud máte nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_WHITETEXTBORDER', 'Bílý obrys písma');
@define('PLUGIN_EVENT_TODOLIST_WHITETEXTBORDERDESC', 'Pokud používáte tmavé pozadí a text se na nich ztrácí, možná zlepšíte èitelnost nastavením bílého okraje písma.');
@define('PLUGIN_EVENT_TODOLIST_OUTSIDETEXT', 'Text mimo ukazatel vývoje.');
@define('PLUGIN_EVENT_TODOLIST_OUTSIDETEXTDESC', 'Tato volba nastavuje výpis vývoje projektu v procentech vpravo od ukazatele vývoje, místo výchozího prostøedku ukazatele.');
@define('PLUGIN_EVENT_TODOLIST_BARLENGTH', 'Délka ukazatele vývoje');
@define('PLUGIN_EVENT_TODOLIST_BARLENGTHDESC', 'Délka v pixelech. Nastavení se používá na ukazatele vyjma øazení podle kategorií. Toto nastavení vyžaduje nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_BARHEIGHT', 'Výška ukazatele vývoje');
@define('PLUGIN_EVENT_TODOLIST_BARHEIGHTDESC', 'Výška v pixelech. Toto nastavení vyžaduje nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_FONTSIZE', 'Velikost fontu písma');
@define('PLUGIN_EVENT_TODOLIST_FONTSIZEDESC', 'Velikost v pixelech. Toto nastavení vyžaduje nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_FONT', 'Font');
@define('PLUGIN_EVENT_TODOLIST_FONTDESC', 'Zadejte název fontu použitého pro text v ukazateli vývoje. Do adresáøe '.dirname(__FILE__).'/fonts/ mùžete pøidat další vlastní fonty. Musejí být typu TrueType. Toto nastavení vyžaduje nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_CATBARLENGTH', 'Délka ukazatele vývoje (pro øazení podle kategorií)');
@define('PLUGIN_EVENT_TODOLIST_CATBARLENGTHDESC', 'Délka ukazatele vývoje pro pøípad, kdy jsou projekty øazené podle kategorií. Pravdìpodobnì budete chtít v tomto pøípadì kratší ukazatel, protože nìjaké místo sebere zobrazení kategorií. Toto nastavení vyžaduje nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_CACHEIMAGE', 'Cachovat vygenerovanou grafiku');
@define('PLUGIN_EVENT_TODOLIST_CACHEIMAGEDESC', 'Cachovat kopie všech vytvoøených ukazatelù vývoje. Pøíznivì ovlivòuje dobu naèítání stránky a snižuje zátìž serveru. Toto nastavení vyžaduje nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_NUMENTRIES', 'Poèet zobrazených pøíspìvkù blogu');
@define('PLUGIN_EVENT_TODOLIST_NUMENTRIESDESC', 'Zobrazit tento poèet nejnovìjších pøíspìvkù pøi výbìru pøíspìvku blogu z ukazatele vývoje.');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY', 'Používat kategorie');
@define('PLUGIN_EVENT_TODOLIST_CATEGORYDESC','Používat kategorie k øazení a tøídìní projektù.');
@define('PLUGIN_EVENT_TODOLIST_ADDPROJECT','Pøidat projekt');
@define('PLUGIN_EVENT_TODOLIST_EDITPROJECT','Upravit projekt');
@define('PLUGIN_EVENT_TODOLIST_PERCENTAGECOMPLETE','Stupeò vývoje projektu v procentech');
@define('PLUGIN_EVENT_TODOLIST_PROJECTDESC','Popis projektu');
@define('PLUGIN_EVENT_TODOLIST_DEFAULT_NOTE','Pamatujte, že toto je plugin událostí a k tomu, aby se jeho výstup objevil v postranním sloupci musíte použít plugin Event Output Wrapper nebo jiný postraní plugin, který dokáže zobrazit jeho obsah.');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME','Použitý systém kategorií:');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_DESC','Mùžete si vybrat, jestli chcete použít stejný systém kategorií, jaký mají pøíspìvky blogu, nebo vlastní oddìlený systém kategorií.');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_CUSTOM','Vlastní');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_DEFAULT','Výchozí (z blogu)');
@define('PLUGIN_EVENT_TODOLIST_CATDB_WARNING','Nastavili jste použití vlastního systému kategorií, ale databázová tabulka s kategoriemi ještì neexistuje. Kliknìte sem a tabulka bude vytvoøena.');
@define('PLUGIN_EVENT_TODOLIST_ADD_CAT','Správa kategorií');
@define('PLUGIN_EVENT_TODOLIST_ADD_COLOR','Pøidat barvu');
@define('PLUGIN_EVENT_TODOLIST_MANAGE_COLORS','Správa barev');
@define('PLUGIN_EVENT_TODOLIST_CAT_NAME','Název kategorie');
@define('PLUGIN_EVENT_TODOLIST_PARENT_CATEGORY','Rodiè = nadøazená kategorie');
@define('PLUGIN_EVENT_TODOLIST_ADMINCAT','Správa kategorií');
@define('PLUGIN_EVENT_TODOLIST_CACHE_NAME','Cachovat postranní sloupec');
@define('PLUGIN_EVENT_TODOLIST_CACHE_DESC','Cachování postranního sloupce zvyšuje rychlost naèítání blogu.');
@define('PLUGIN_EVENT_TODOLIST_NOGDLIB', 'Vypadá to, že nemáte nainstalovanou knihovnu PHP GD. Statické obrázky vývoje jsou pøedpøipravené po 5%, takže výsledky splnìní projektu budou zaokrouhleny na nejbližších 5%.');
@define('PLUGIN_EVENT_TODOLIST_ADDCOLOR_NAME', 'Název barvy (použitý v rozbalovacích nabídkách pro výbìr barvy)');
@define('PLUGIN_EVENT_TODOLIST_ADDCOLOR_COLOR1', 'Barva vnitøku ukazatele vývoje (hexadecimální hodnota jako apø. ff3333). Pro vnitøek ukazatele doporuèujeme svìtlejší barvy.');
@define('PLUGIN_EVENT_TODOLIST_ADDCOLOR_COLOR2', 'Barva vnìjšku ukazatele vývoje  (hexadecimální hodnota jako apø. ff3333)');
@define('PLUGIN_EVENT_TODOLIST_COLOR', 'Barva');
@define('PLUGIN_EVENT_TODOLIST_SAMPLE', 'Ukázka');
@define('PLUGIN_EVENT_TODOLIST_COLORWHEEL', 'Barevné kolo');
@define('PLUGIN_EVENT_TODOLIST_COLORWHEEL_INSTRUCTIONS', 'Pohybujte se s myší nad barevným kolem nebo ètvercem sytosti pro zobrazení náhledu barvy. Kliknutím vyberete barvu. Kopírujte (Ctrl-C) a vložte (Ctrl-V) šestimístný kód barvy do políèka pro barvu.');

?>
