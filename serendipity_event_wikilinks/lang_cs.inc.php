/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/26
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/01/12
 */

@define('PLUGIN_EVENT_WIKILINKS_NAME', 'Wiki odkazy v pøíspìvcích');
@define('PLUGIN_EVENT_WIKILINKS_DESC', 'V pøíspìvcích mùžete zadat odkazy na existující/nové pøíspìvky pomocí [[nadpis pøíspìvku]], na statické stránky pomocí ((nadpis stránky)) a na obojí pomocí {{nadpis}}.');
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
@define('PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_DESK', 'Mají se vytváøet odkazy na pøíspìvky, jejichž datum vydání je v budoucnosti?');

// Next lines were translated on 2012/01/12
@define('PLUGIN_EVENT_WIKILINKS_REFMATCH_NAME', 'Vzor pro odchytávání referencí');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCH_DESC', 'Zde mùžete zadat vzor, podle kterého budou odchytávány reference pøi procházení textu. Plugin sesbírá tyto reference, uloží je do databáze a vypíše je pod pøíspìvkem. Mùžete také použít smarty tag {$entry.properties.references} pro umístìní tohoto bloku na libovolné místo ve vaší šablonì. Vzor je možné zadávat jako regulární výraz, nezapomeòte escapovat speciální znaky. Výchozí vzor vypadá složitì, protože používá pojmenované pod-vzory, ale zato mùže být jednoduše použit jako:<ref name="xxx">yyy</ref>, kde xxx je nepovinné jméno reference (viz níže) a yyy je vlastní text reference, kde yyy mùže být libovolné HTML nebo jiný znaèkovací jazyk.');
@define('PLUGIN_EVENT_WIKILINKS_REFDOC', '<strong>Znovu-používání referencí</strong><br /><br />Pokud chcete použít reference na více místech, je výhodné specifikovat je pouze jednou a pak už jen znovu-používat. Napøíkad pokud napíšete následující text:<br />
<div style="border: 1px solid black; padding: 4px">
Serendipity&lt;ref&gt;&lt;a href="http://www.s9y.org"&gt;Serendipity Weblog&lt;/a&gt; - Serendipity mùže být také použito v dalších významech, ajko napøíklad film nebo taneèník ve filmu, nebo film o filmovém taneèníkovi.</ref> se mùže vyskytovat na mnoha místech.
</div>
<br/><br />
Protože budete mluvit o Serendipity na vašem blogu urèitì na mnoha místech, mìli byste vytvoøit referenci, která funguje pøidáním atributu <em>name</em> attribute do tagu &lt;ref&gt; a bude vypadat následovnì:
<div style="border: 1px solid black; padding: 4px">
Serendipity&lt;ref name="Serendipity"&gt;&lt;a href="http://www.s9y.org"&gt;Serendipity Weblog&lt;/a&gt; Serendipity mùže být také použito v dalších významech, ajko napøíklad film nebo taneèník ve filmu, nebo film o filmovém taneèníkovi.</ref> a mùže se vyskytovat na mnoha místech.</pre>
</div>
<br/><br />
Toto staèí vložit pouze na prvním místì výskytu reference. Kdykoliv budete chtít použít tu samou referenci, staèí napsat jednoduše:
<div style="border: 1px solid black; padding: 4px">
Serendipity&lt;ref name="Serendipity"&gt;&lt;/ref&gt;
</div>
<br /><br />
To se postará o vložení existující pojmenované reference z databáze. Pamatujte, že musíte použít &lt;ref&gt;...&lt;/ref&gt; zápis, &lt;ref.../&gt; není podporováno kvùli syntaxi regulárního výrazu.
');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET_NAME', 'Formát nahrazené reference');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET_DESC', 'Zde mùžete zadat, jak bude odchycená reference nahrazena, obvykle èíselným odkazem do seznamu referencí. {count} (èíslo) a {text} jsou zástupné promìnné pro èíslo a celý text reference. {refname} odpovídá nepovinnému jménu reference.');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET2_NAME', 'Formát seznamu referencí');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET2_DESC', 'Mùžete zadat, jak se budou odchycené reference zobrazovat v seznamu referencí. Pokud je nastaveno na "-", pak se seznam referencí nebude vypisovat. To je užiteèné, pokud chcete seznam referencí zobrazovat sami pomocí smarty!');
@define('PLUGIN_EVENT_WIKILINKS_MAINT', 'Zachovat index reference');
@define('PLUGIN_EVENT_WIKILINKS_MAINT_DESC', 'Zde mùžete upravit uložené reference. Pamatujte, že když upravíte pùvodní pøíspìvek, ve kterém byla reference, tak text v pøíspìvku má vždy pøednost pøed vším, co zadáte tady. Pokud èasto upravujete starší pøíspìvky, mìli byste radìji upravovat text referencí uvntø pøíspìvkù a ne zde.');
@define('PLUGIN_EVENT_WIKILINKS_DB_REFNAME', 'Název reference');
@define('PLUGIN_EVENT_WIKILINKS_DB_REF', 'Obsah reference');
@define('PLUGIN_EVENT_WIKILINKS_DB_ENTRYDID', 'Zadáno v:');