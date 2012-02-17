<?php # lang_cz.inc.php 1.1 2012-01-12 22:20:02 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/26
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/01/12
 */

@define('PLUGIN_EVENT_WIKILINKS_NAME', 'Wiki odkazy v pøíspìvcích');
@define('PLUGIN_EVENT_WIKILINKS_DESC', 'V pøíspìvcích mù¾ete zadat odkazy na existující/nové pøíspìvky pomocí [[nadpis pøíspìvku]], na statické stránky pomocí ((nadpis stránky)) a na obojí pomocí {{nadpis}}.');
@define('PLUGIN_EVENT_WIKILINKS_IMGPATH', 'Cesta k obrázkùm');
@define('PLUGIN_EVENT_WIKILINKS_IMGPATH_DESC', 'Zadejte cestu, na které jsou umístìny ikony wiki odkazù.');

@define('PLUGIN_EVENT_WIKILINKS_EDIT_INTERNAL', 'Upravit pøíspìvek');
@define('PLUGIN_EVENT_WIKILINKS_EDIT_STATICPAGE', 'Upravit statickou stránku');
@define('PLUGIN_EVENT_WIKILINKS_CREATE_INTERNAL', 'Vytvoøit pøíspìvek');
@define('PLUGIN_EVENT_WIKILINKS_CREATE_STATICPAGE', 'Vytvoøit statickou stránku');

@define('PLUGIN_EVENT_WIKILINKS_LINKENTRY', 'Odkaz na pøíspìvek');
@define('PLUGIN_EVENT_WIKILINKS_LINKENTRY_DESC', 'Vyberte pøíspìvek, na který chcete odkazovat.');

@define('PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_NAME', 'Vytvoøit odkazy na koncepty?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_DESC', 'Mají se tvoøit odkazy na pøíspìvky, které jsou ve stavu "koncept"?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_NAME', 'Vytváøet odkazy na budoucí pøíspìvky?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_DESK', 'Mají se vytváøet odkazy na pøíspìvky, jejich¾ datum vydání je v budoucnosti?');

// Next lines were translated on 2012/01/12
@define('PLUGIN_EVENT_WIKILINKS_REFMATCH_NAME', 'Vzor pro odchytávání referencí');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCH_DESC', 'Zde mù¾ete zadat vzor, podle kterého budou odchytávány reference pøi procházení textu. Plugin sesbírá tyto reference, ulo¾í je do databáze a vypí¹e je pod pøíspìvkem. Mù¾ete také pou¾ít smarty tag {$entry.properties.references} pro umístìní tohoto bloku na libovolné místo ve va¹í ¹ablonì. Vzor je mo¾né zadávat jako regulární výraz, nezapomeòte escapovat speciální znaky. Výchozí vzor vypadá slo¾itì, proto¾e pou¾ívá pojmenované pod-vzory, ale zato mù¾e být jednodu¹e pou¾it jako:<ref name="xxx">yyy</ref>, kde xxx je nepovinné jméno reference (viz ní¾e) a yyy je vlastní text reference, kde yyy mù¾e být libovolné HTML nebo jiný znaèkovací jazyk.');
@define('PLUGIN_EVENT_WIKILINKS_REFDOC', '<strong>Znovu-pou¾ívání referencí</strong><br /><br />Pokud chcete pou¾ít reference na více místech, je výhodné specifikovat je pouze jednou a pak u¾ jen znovu-pou¾ívat. Napøíkad pokud napí¹ete následující text:<br />
<div style="border: 1px solid black; padding: 4px">
Serendipity&lt;ref&gt;&lt;a href="http://www.s9y.org"&gt;Serendipity Weblog&lt;/a&gt; - Serendipity mù¾e být také pou¾ito v dal¹ích významech, ajko napøíklad film nebo taneèník ve filmu, nebo film o filmovém taneèníkovi.</ref> se mù¾e vyskytovat na mnoha místech.
</div>
<br/><br />
Proto¾e budete mluvit o Serendipity na va¹em blogu urèitì na mnoha místech, mìli byste vytvoøit referenci, která funguje pøidáním atributu <em>name</em> attribute do tagu &lt;ref&gt; a bude vypadat následovnì:
<div style="border: 1px solid black; padding: 4px">
Serendipity&lt;ref name="Serendipity"&gt;&lt;a href="http://www.s9y.org"&gt;Serendipity Weblog&lt;/a&gt; Serendipity mù¾e být také pou¾ito v dal¹ích významech, ajko napøíklad film nebo taneèník ve filmu, nebo film o filmovém taneèníkovi.</ref> a mù¾e se vyskytovat na mnoha místech.</pre>
</div>
<br/><br />
Toto staèí vlo¾it pouze na prvním místì výskytu reference. Kdykoliv budete chtít pou¾ít tu samou referenci, staèí napsat jednodu¹e:
<div style="border: 1px solid black; padding: 4px">
Serendipity&lt;ref name="Serendipity"&gt;&lt;/ref&gt;
</div>
<br /><br />
To se postará o vlo¾ení existující pojmenované reference z databáze. Pamatujte, ¾e musíte pou¾ít &lt;ref&gt;...&lt;/ref&gt; zápis, &lt;ref.../&gt; není podporováno kvùli syntaxi regulárního výrazu.
');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET_NAME', 'Formát nahrazené reference');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET_DESC', 'Zde mù¾ete zadat, jak bude odchycená reference nahrazena, obvykle èíselným odkazem do seznamu referencí. {count} (èíslo) a {text} jsou zástupné promìnné pro èíslo a celý text reference. {refname} odpovídá nepovinnému jménu reference.');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET2_NAME', 'Formát seznamu referencí');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET2_DESC', 'Mù¾ete zadat, jak se budou odchycené reference zobrazovat v seznamu referencí. Pokud je nastaveno na "-", pak se seznam referencí nebude vypisovat. To je u¾iteèné, pokud chcete seznam referencí zobrazovat sami pomocí smarty!');
@define('PLUGIN_EVENT_WIKILINKS_MAINT', 'Zachovat index reference');
@define('PLUGIN_EVENT_WIKILINKS_MAINT_DESC', 'Zde mù¾ete upravit ulo¾ené reference. Pamatujte, ¾e kdy¾ upravíte pùvodní pøíspìvek, ve kterém byla reference, tak text v pøíspìvku má v¾dy pøednost pøed v¹ím, co zadáte tady. Pokud èasto upravujete star¹í pøíspìvky, mìli byste radìji upravovat text referencí uvntø pøíspìvkù a ne zde.');
@define('PLUGIN_EVENT_WIKILINKS_DB_REFNAME', 'Název reference');
@define('PLUGIN_EVENT_WIKILINKS_DB_REF', 'Obsah reference');
@define('PLUGIN_EVENT_WIKILINKS_DB_ENTRYDID', 'Zadáno v:');