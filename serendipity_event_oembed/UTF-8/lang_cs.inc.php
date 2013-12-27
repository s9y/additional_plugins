/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2012/01/11
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/02/04
 */

@define('PLUGIN_EVENT_OEMBED_NAME',      'oEmbed');
@define('PLUGIN_EVENT_OEMBED_DESC',      'oEmbed je formát, který umožňuje vkládat do blogu jiné stránky z internetu. Umožňuje zobrazovat v příspěvcích vložený obsah (jako tweety, fotky nebo videa), když autor příspěvku napíše odkaz na zdroj obsahu, aniž by bylo potřeba přímo parsovat cílovou stránku.');

@define('PLUGIN_EVENT_OEMBED_MAXWIDTH',      'Maximální šířka vloženého objektu');
@define('PLUGIN_EVENT_OEMBED_MAXWIDTH_DESC', 'Toto je maximální šířka vloženého obsahu. Ne všechny služby pro vkládání obsahu toto nastavení podporují, ale většina ano.');
@define('PLUGIN_EVENT_OEMBED_MAXHEIGHT',     'Maximální výška vloženého objektu');
@define('PLUGIN_EVENT_OEMBED_MAXHEIGHT_DESC','Toto je maximální výška vloženého obsahu. Ne všechny služby pro vkládání obsahu toto nastavení podporují, ale většina ano.');

@define('PLUGIN_EVENT_OEMBED_GENERIC_SERVICE',   'Obecný poskytovatel oEmbed');
@define('PLUGIN_EVENT_OEMBED_GENERIC_SERVICE_DESC','Pokud plugin není schopen rozluštit URL, protože ji ještě nezná, může ji zpracovat "obecným poskytovatelem". Tyto služby implementují oEmbed pro velký počet služeb, které nemají oEmbed. Na výběr jsou dvě možnosti: oohembed.com (dříve bezplatná služba koupená firmou Embedly a s velmi omezeným API) nebo embed.ly (dobře spravovaná a udržovaná služba pro mnoho oEmbed služeb, viz http://embed.ly/providers, ale k použití je třeba získat API klíč.');
@define('PLUGIN_EVENT_OEMBED_SERVICE_NONE',      'Žádný obecný poskytovatel');
@define('PLUGIN_EVENT_OEMBED_SERVICE_OOHEMBED',  'oohembed (zdarma, ale omezený)');
@define('PLUGIN_EVENT_OEMBED_SERVICE_EMBEDLY',   'embed.ly (potřeba API klíč)');
@define('PLUGIN_EVENT_OEMBED_EMBEDLY_APIKEY',     'embed.ly API klíč');
@define('PLUGIN_EVENT_OEMBED_EMBEDLY_APIKEY_DESC','abyste mohli používat embed.ly, potřebujete API klíč. Účet zdarma umožňuje 10000 použití za měsíc, což by mělo stačit i pro silně vytížené blogy, protože výsledky jsou lokálně cachovány a vkládány pouze jedenkrát na URL. Účet zdarma můžete zaregistrovat na http://app.embed.ly/pricing/free');

@define('PLUGIN_EVENT_OEMBED_INFO',      '<h3>Plugin oEmbed</h3>' .
'<p>'.
'Tento plugin zobarzuje místo zadané URL adresy její reprezentaci pro známé webové služby. Například když zadáte odkaz na youtube, nezobrazí odkaz na youtube, nýbrž rovnou odkazované video. Místo odkazu na flickr zobrazuje rovnou obrázek.<br/>' .
'Syntaxe pro použití tohoto pluginu je <b>[embed <i>odkaz</i>]</b> (nebo <b>[e <i>odkaz</i>]</b> pokud máte radši zkratky).<br/>'.
'Pokud služba (adresa) není pluginem v současnosti podporována, bude zobrazen pouze klikatelný odkaz.<br/>'.
'</p><p>'.
'Zařaďte prosím tento plugin na začátek seznamu pluginů, aby zadaný odkaz nemohl být změněn jiným pluginem (např. přidáním href)'.
'</p>');

@define('PLUGIN_EVENT_OEMBED_SUPPORTED',      '<p>'.
'Plugin podporuje následující reprezentace odkazů, aniž by bylo potřeba nastavovat obecný fallback:%s'.
'</p>');

// Next lines were translated on 2012/02/04
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO', 'Přehrávač Audioboo');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_DESC', 'Audioboo podporuje 3 různé přehrávače (viz http://audioboo.fm/boos/649785-ein-erster-testboo.embed?labs=1). Vyberte si, který se vám nejvíce líbí.');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_STANDARD', 'standardní');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_FULLFEATURED', 'plná výbava (vyžaduje JavaScript)');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_WORDPRESS', 'přehrávač wordpress.com (vyžaduje Flash)');