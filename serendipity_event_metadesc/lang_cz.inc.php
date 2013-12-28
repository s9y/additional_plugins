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
@define('PLUGIN_METADESC_DESC', 'Zadejte HTML meta tagy pro klíèová slova nebo popis blogu. Také mù¾ete zadávat rùzný titulek pro jednotlivé stránky blogu a výchozí hodnotu pro klíèová slova/popis pro stránky se zobrazenm více pøíspìvkù (výchozí stránka, pøehledy kategorií).');
@define('PLUGIN_METADESC_FORM', 'Pokud ponecháte tato políèka prázdná, pak bude prvních 120 znakù pøíspìvku pou¾ito jako popis (meta description). Pokud nepùjdou vygenerovat klíèová slova na základì HTML tagù pro klíèová slova, budou pou¾ita výchozí klíèová slova (meta keywords).<br /><br />Doporuèení pro psaní popisu (meta description)<sup>*</sup>: 20 a¾ 30 slov, nejvý¹e 120 a¾ 180 znakù vèetnì mezer.<br />Doporuèení pro klíèová slova (meta keywords)<sup>*</sup>: 15 a¾ 20 nejvýsti¾nìj¹ích slov vyskytujících se v pøíspìvku.');
@define('PLUGIN_METADESC_DESCRIPTION', 'META-Description:');
@define('PLUGIN_METADESC_KEYWORDS', 'META-Keywords:');
@define('PLUGIN_METADESC_HEADTITLE_DESC', 'Tag TITLE v hlavièce HTML kódu mù¾e být pøizpùsoben pomocí následujícího pole. Pokud ponecháte pole prázdné, nadpis bude vygenerován podle ¹ablony, co¾ je obvykle "Nadpis pøíspìvku - nadpis blogu".   <br /><br />Doporuèení<sup>*</sup>: 3 a¾ 9 slov, nanejvý¹ 64 znakù vèetnì mezer, nejdùle¾itìj¹í slova jako první.');
@define('PLUGIN_METADESC_HEADTITLE', 'Tag TITLE v HTML kódu stránky');
@define('PLUGIN_METADESC_LENGTH', 'Délka');
@define('PLUGIN_METADESC_WORDS', 'slov');
@define('PLUGIN_METADESC_CHARACTERS', 'znakù');
@define('PLUGIN_METADESC_STRINGLENGTH_DISCLAIMER', 'Poèet slov a znakù v doporuèení je pouze doporuèení, mù¾ete napsat libovolnì dlouhý text.');
@define('PLUGIN_METADESC_TAGNAMES', 'HTML tagy pro generování klíèových slov');
@define('PLUGIN_METADESC_TAGNAMES_DESC', 'Zadejte seznam HTML tagù, které obsahují klíèová slova a ve kterých mají být klíèová slova hledána. Jednotlivé tagy oddìlujte èárkou.');
@define('PLUGIN_METADESC_DEFAULT_DESCRIPTION', 'Výchozí HTML meta description');
@define('PLUGIN_METADESC_DEFAULT_DESCRIPTION_DESC', 'Zadejte výchozí hodnotu pro popis stránky (meta description), který se pou¾ije na pøehledových stranách. Tj. tam, kde je zobrazeno více pøíspìvkù najednou.');
@define('PLUGIN_METADESC_DEFAULT_KEYWORDS', 'Výchozí HTML meta keywords');
@define('PLUGIN_METADESC_DEFAULT_KEYWORDS_DESC', 'Zadejte seznam èárkou oddìlených klíèových slov, které se mají pou¾ít na stránkách, které zobrazují více pøíspìvkù.');

// Next lines were translated on 2011/01/11

@define('PLUGIN_METADESC_ESCAPE', 'Escapovat HTML entity');

// Next lines were translated on 2011/01/20
@define('PLUGIN_METADESC_ESCAPE_DESC', 'Nahradit øídící znaky jazyka HTML v popisu meta-description nebo v klíèových slovech pomocí odpovídajících HTML entit. K nahrazení se pou¾ívá funkce htmlspecialchars().');