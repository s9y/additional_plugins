<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/16
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/01/11
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/01/20
 */

@define('PLUGIN_METADESC_NAME', 'HTML META tagy');
@define('PLUGIN_METADESC_DESC', 'Zadejte HTML meta tagy pro klíčová slova nebo popis blogu. Také můžete zadávat různý titulek pro jednotlivé stránky blogu a výchozí hodnotu pro klíčová slova/popis pro stránky se zobrazenm více příspěvků (výchozí stránka, přehledy kategorií).');
@define('PLUGIN_METADESC_FORM', 'Pokud ponecháte tato políčka prázdná, pak bude prvních 120 znaků příspěvku použito jako popis (meta description). Pokud nepůjdou vygenerovat klíčová slova na základě HTML tagů pro klíčová slova, budou použita výchozí klíčová slova (meta keywords).<br /><br />Doporučení pro psaní popisu (meta description)<sup>*</sup>: 20 až 30 slov, nejvýše 120 až 180 znaků včetně mezer.<br />Doporučení pro klíčová slova (meta keywords)<sup>*</sup>: 15 až 20 nejvýstižnějších slov vyskytujících se v příspěvku.');
@define('PLUGIN_METADESC_DESCRIPTION', 'META-Description:');
@define('PLUGIN_METADESC_KEYWORDS', 'META-Keywords:');
@define('PLUGIN_METADESC_HEADTITLE_DESC', 'Tag TITLE v hlavičce HTML kódu může být přizpůsoben pomocí následujícího pole. Pokud ponecháte pole prázdné, nadpis bude vygenerován podle šablony, což je obvykle "Nadpis příspěvku - nadpis blogu".   <br /><br />Doporučení<sup>*</sup>: 3 až 9 slov, nanejvýš 64 znaků včetně mezer, nejdůležitější slova jako první.');
@define('PLUGIN_METADESC_HEADTITLE', 'Tag TITLE v HTML kódu stránky');
@define('PLUGIN_METADESC_LENGTH', 'Délka');
@define('PLUGIN_METADESC_WORDS', 'slov');
@define('PLUGIN_METADESC_CHARACTERS', 'znaků');
@define('PLUGIN_METADESC_STRINGLENGTH_DISCLAIMER', 'Počet slov a znaků v doporučení je pouze doporučení, můžete napsat libovolně dlouhý text.');
@define('PLUGIN_METADESC_TAGNAMES', 'HTML tagy pro generování klíčových slov');
@define('PLUGIN_METADESC_TAGNAMES_DESC', 'Zadejte seznam HTML tagů, které obsahují klíčová slova a ve kterých mají být klíčová slova hledána. Jednotlivé tagy oddělujte čárkou.');
@define('PLUGIN_METADESC_DEFAULT_DESCRIPTION', 'Výchozí HTML meta description');
@define('PLUGIN_METADESC_DEFAULT_DESCRIPTION_DESC', 'Zadejte výchozí hodnotu pro popis stránky (meta description), který se použije na přehledových stranách. Tj. tam, kde je zobrazeno více příspěvků najednou.');
@define('PLUGIN_METADESC_DEFAULT_KEYWORDS', 'Výchozí HTML meta keywords');
@define('PLUGIN_METADESC_DEFAULT_KEYWORDS_DESC', 'Zadejte seznam čárkou oddělených klíčových slov, které se mají použít na stránkách, které zobrazují více příspěvků.');

// Next lines were translated on 2011/01/11

@define('PLUGIN_METADESC_ESCAPE', 'Escapovat HTML entity');

// Next lines were translated on 2011/01/20
@define('PLUGIN_METADESC_ESCAPE_DESC', 'Nahradit řídící znaky jazyka HTML v popisu meta-description nebo v klíčových slovech pomocí odpovídajících HTML entit. K nahrazení se používá funkce htmlspecialchars().');