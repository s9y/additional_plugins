<?php # lang_cs.inc.php 1.1 2012-02-04 09:54:28 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2012/01/11
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/02/04
 */

@define('PLUGIN_EVENT_OEMBED_NAME',      'oEmbed');
@define('PLUGIN_EVENT_OEMBED_DESC',      'oEmbed je formát, který umožòuje vkládat do blogu jiné stránky z internetu. Umožòuje zobrazovat v pøíspìvcích vložený obsah (jako tweety, fotky nebo videa), když autor pøíspìvku napíše odkaz na zdroj obsahu, aniž by bylo potøeba pøímo parsovat cílovou stránku.');

@define('PLUGIN_EVENT_OEMBED_MAXWIDTH',      'Maximální šíøka vloženého objektu');
@define('PLUGIN_EVENT_OEMBED_MAXWIDTH_DESC', 'Toto je maximální šíøka vloženého obsahu. Ne všechny služby pro vkládání obsahu toto nastavení podporují, ale vìtšina ano.');
@define('PLUGIN_EVENT_OEMBED_MAXHEIGHT',     'Maximální výška vloženého objektu');
@define('PLUGIN_EVENT_OEMBED_MAXHEIGHT_DESC','Toto je maximální výška vloženého obsahu. Ne všechny služby pro vkládání obsahu toto nastavení podporují, ale vìtšina ano.');

@define('PLUGIN_EVENT_OEMBED_GENERIC_SERVICE',   'Obecný poskytovatel oEmbed');
@define('PLUGIN_EVENT_OEMBED_GENERIC_SERVICE_DESC','Pokud plugin není schopen rozluštit URL, protože ji ještì nezná, mùže ji zpracovat "obecným poskytovatelem". Tyto služby implementují oEmbed pro velký poèet služeb, které nemají oEmbed. Na výbìr jsou dvì možnosti: oohembed.com (døíve bezplatná služba koupená firmou Embedly a s velmi omezeným API) nebo embed.ly (dobøe spravovaná a udržovaná služba pro mnoho oEmbed služeb, viz http://embed.ly/providers, ale k použití je tøeba získat API klíè.');
@define('PLUGIN_EVENT_OEMBED_SERVICE_NONE',      'Žádný obecný poskytovatel');
@define('PLUGIN_EVENT_OEMBED_SERVICE_OOHEMBED',  'oohembed (zdarma, ale omezený)');
@define('PLUGIN_EVENT_OEMBED_SERVICE_EMBEDLY',   'embed.ly (potøeba API klíè)');
@define('PLUGIN_EVENT_OEMBED_EMBEDLY_APIKEY',     'embed.ly API klíè');
@define('PLUGIN_EVENT_OEMBED_EMBEDLY_APIKEY_DESC','abyste mohli používat embed.ly, potøebujete API klíè. Úèet zdarma umožòuje 10000 použití za mìsíc, což by mìlo staèit i pro silnì vytížené blogy, protože výsledky jsou lokálnì cachovány a vkládány pouze jedenkrát na URL. Úèet zdarma mùžete zaregistrovat na http://app.embed.ly/pricing/free');

@define('PLUGIN_EVENT_OEMBED_INFO',      '<h3>Plugin oEmbed</h3>' .
'<p>'.
'Tento plugin zobarzuje místo zadané URL adresy její reprezentaci pro známé webové služby. Napøíklad když zadáte odkaz na youtube, nezobrazí odkaz na youtube, nýbrž rovnou odkazované video. Místo odkazu na flickr zobrazuje rovnou obrázek.<br/>' .
'Syntaxe pro použití tohoto pluginu je <b>[embed <i>odkaz</i>]</b> (nebo <b>[e <i>odkaz</i>]</b> pokud máte radši zkratky).<br/>'.
'Pokud služba (adresa) není pluginem v souèasnosti podporována, bude zobrazen pouze klikatelný odkaz.<br/>'.
'</p><p>'.
'Zaøaïte prosím tento plugin na zaèátek seznamu pluginù, aby zadaný odkaz nemohl být zmìnìn jiným pluginem (napø. pøidáním href)'.
'</p>');

@define('PLUGIN_EVENT_OEMBED_SUPPORTED',      '<p>'.
'Plugin podporuje následující reprezentace odkazù, aniž by bylo potøeba nastavovat obecný fallback:%s'.
'</p>');

// Next lines were translated on 2012/02/04
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO', 'Pøehrávaè Audioboo');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_DESC', 'Audioboo podporuje 3 rùzné pøehrávaèe (viz http://audioboo.fm/boos/649785-ein-erster-testboo.embed?labs=1). Vyberte si, který se vám nejvíce líbí.');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_STANDARD', 'standardní');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_FULLFEATURED', 'plná výbava (vyžaduje JavaScript)');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_WORDPRESS', 'pøehrávaè wordpress.com (vyžaduje Flash)');