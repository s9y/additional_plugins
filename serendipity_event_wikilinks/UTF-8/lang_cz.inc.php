<?php # lang_cz.inc.php 1.1 2012-01-12 22:20:02 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/26
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/01/12
 */

@define('PLUGIN_EVENT_WIKILINKS_NAME', 'Wiki odkazy v příspěvcích');
@define('PLUGIN_EVENT_WIKILINKS_DESC', 'V příspěvcích můžete zadat odkazy na existující/nové příspěvky pomocí [[nadpis příspěvku]], na statické stránky pomocí ((nadpis stránky)) a na obojí pomocí {{nadpis}}.');
@define('PLUGIN_EVENT_WIKILINKS_IMGPATH', 'Cesta k obrázkům');
@define('PLUGIN_EVENT_WIKILINKS_IMGPATH_DESC', 'Zadejte cestu, na které jsou umístěny ikony wiki odkazů.');

@define('PLUGIN_EVENT_WIKILINKS_EDIT_INTERNAL', 'Upravit příspěvek');
@define('PLUGIN_EVENT_WIKILINKS_EDIT_STATICPAGE', 'Upravit statickou stránku');
@define('PLUGIN_EVENT_WIKILINKS_CREATE_INTERNAL', 'Vytvořit příspěvek');
@define('PLUGIN_EVENT_WIKILINKS_CREATE_STATICPAGE', 'Vytvořit statickou stránku');

@define('PLUGIN_EVENT_WIKILINKS_LINKENTRY', 'Odkaz na příspěvek');
@define('PLUGIN_EVENT_WIKILINKS_LINKENTRY_DESC', 'Vyberte příspěvek, na který chcete odkazovat.');

@define('PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_NAME', 'Vytvořit odkazy na koncepty?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_DESC', 'Mají se tvořit odkazy na příspěvky, které jsou ve stavu "koncept"?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_NAME', 'Vytvářet odkazy na budoucí příspěvky?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_DESK', 'Mají se vytvářet odkazy na příspěvky, jejichž datum vydání je v budoucnosti?');

// Next lines were translated on 2012/01/12
@define('PLUGIN_EVENT_WIKILINKS_REFMATCH_NAME', 'Vzor pro odchytávání referencí');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCH_DESC', 'Zde můžete zadat vzor, podle kterého budou odchytávány reference při procházení textu. Plugin sesbírá tyto reference, uloží je do databáze a vypíše je pod příspěvkem. Můžete také použít smarty tag {$entry.properties.references} pro umístění tohoto bloku na libovolné místo ve vaší šabloně. Vzor je možné zadávat jako regulární výraz, nezapomeňte escapovat speciální znaky. Výchozí vzor vypadá složitě, protože používá pojmenované pod-vzory, ale zato může být jednoduše použit jako:<ref name="xxx">yyy</ref>, kde xxx je nepovinné jméno reference (viz níže) a yyy je vlastní text reference, kde yyy může být libovolné HTML nebo jiný značkovací jazyk.');
@define('PLUGIN_EVENT_WIKILINKS_REFDOC', '<strong>Znovu-používání referencí</strong><br /><br />Pokud chcete použít reference na více místech, je výhodné specifikovat je pouze jednou a pak už jen znovu-používat. Napříkad pokud napíšete následující text:<br />
<div style="border: 1px solid black; padding: 4px">
Serendipity&lt;ref&gt;&lt;a href="http://www.s9y.org"&gt;Serendipity Weblog&lt;/a&gt; - Serendipity může být také použito v dalších významech, ajko například film nebo tanečník ve filmu, nebo film o filmovém tanečníkovi.</ref> se může vyskytovat na mnoha místech.
</div>
<br/><br />
Protože budete mluvit o Serendipity na vašem blogu určitě na mnoha místech, měli byste vytvořit referenci, která funguje přidáním atributu <em>name</em> attribute do tagu &lt;ref&gt; a bude vypadat následovně:
<div style="border: 1px solid black; padding: 4px">
Serendipity&lt;ref name="Serendipity"&gt;&lt;a href="http://www.s9y.org"&gt;Serendipity Weblog&lt;/a&gt; Serendipity může být také použito v dalších významech, ajko například film nebo tanečník ve filmu, nebo film o filmovém tanečníkovi.</ref> a může se vyskytovat na mnoha místech.</pre>
</div>
<br/><br />
Toto stačí vložit pouze na prvním místě výskytu reference. Kdykoliv budete chtít použít tu samou referenci, stačí napsat jednoduše:
<div style="border: 1px solid black; padding: 4px">
Serendipity&lt;ref name="Serendipity"&gt;&lt;/ref&gt;
</div>
<br /><br />
To se postará o vložení existující pojmenované reference z databáze. Pamatujte, že musíte použít &lt;ref&gt;...&lt;/ref&gt; zápis, &lt;ref.../&gt; není podporováno kvůli syntaxi regulárního výrazu.
');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET_NAME', 'Formát nahrazené reference');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET_DESC', 'Zde můžete zadat, jak bude odchycená reference nahrazena, obvykle číselným odkazem do seznamu referencí. {count} (číslo) a {text} jsou zástupné proměnné pro číslo a celý text reference. {refname} odpovídá nepovinnému jménu reference.');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET2_NAME', 'Formát seznamu referencí');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET2_DESC', 'Můžete zadat, jak se budou odchycené reference zobrazovat v seznamu referencí. Pokud je nastaveno na "-", pak se seznam referencí nebude vypisovat. To je užitečné, pokud chcete seznam referencí zobrazovat sami pomocí smarty!');
@define('PLUGIN_EVENT_WIKILINKS_MAINT', 'Zachovat index reference');
@define('PLUGIN_EVENT_WIKILINKS_MAINT_DESC', 'Zde můžete upravit uložené reference. Pamatujte, že když upravíte původní příspěvek, ve kterém byla reference, tak text v příspěvku má vždy přednost před vším, co zadáte tady. Pokud často upravujete starší příspěvky, měli byste raději upravovat text referencí uvntř příspěvků a ne zde.');
@define('PLUGIN_EVENT_WIKILINKS_DB_REFNAME', 'Název reference');
@define('PLUGIN_EVENT_WIKILINKS_DB_REF', 'Obsah reference');
@define('PLUGIN_EVENT_WIKILINKS_DB_ENTRYDID', 'Zadáno v:');