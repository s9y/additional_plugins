<?php # lang_cz.inc.php 1.0 2012-01-11 23:23:15 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2012/01/11
 */

@define('PLUGIN_EVENT_OEMBED_NAME',      'oEmbed');
@define('PLUGIN_EVENT_OEMBED_DESC',      'oEmbed je formát, který umo¾òuje vkládat do blogu jiné stránky z internetu. Umo¾òuje zobrazovat v pøíspìvcích vlo¾ený obsah (jako tweety, fotky nebo videa), kdy¾ autor pøíspìvku napí¹e odkaz na zdroj obsahu, ani¾ by bylo potøeba pøímo parsovat cílovou stránku.');

@define('PLUGIN_EVENT_OEMBED_MAXWIDTH',      'Maximální ¹íøka vlo¾eného objektu');
@define('PLUGIN_EVENT_OEMBED_MAXWIDTH_DESC', 'Toto je maximální ¹íøka vlo¾eného obsahu. Ne v¹echny slu¾by pro vkládání obsahu toto nastavení podporují, ale vìt¹ina ano.');
@define('PLUGIN_EVENT_OEMBED_MAXHEIGHT',     'Maximální vý¹ka vlo¾eného objektu');
@define('PLUGIN_EVENT_OEMBED_MAXHEIGHT_DESC','Toto je maximální vý¹ka vlo¾eného obsahu. Ne v¹echny slu¾by pro vkládání obsahu toto nastavení podporují, ale vìt¹ina ano.');

@define('PLUGIN_EVENT_OEMBED_GENERIC_SERVICE',   'Obecný poskytovatel oEmbed');
@define('PLUGIN_EVENT_OEMBED_GENERIC_SERVICE_DESC','Pokud plugin není schopen rozlu¹tit URL, proto¾e ji je¹tì nezná, mù¾e ji zpracovat "obecným poskytovatelem". Tyto slu¾by implementují oEmbed pro velký poèet slu¾eb, které nemají oEmbed. Na výbìr jsou dvì mo¾nosti: oohembed.com (døíve bezplatná slu¾ba koupená firmou Embedly a s velmi omezeným API) nebo embed.ly (dobøe spravovaná a udr¾ovaná slu¾ba pro mnoho oEmbed slu¾eb, viz http://embed.ly/providers, ale k pou¾ití je tøeba získat API klíè.');
@define('PLUGIN_EVENT_OEMBED_SERVICE_NONE',      '®ádný obecný poskytovatel');
@define('PLUGIN_EVENT_OEMBED_SERVICE_OOHEMBED',  'oohembed (zdarma, ale omezený)');
@define('PLUGIN_EVENT_OEMBED_SERVICE_EMBEDLY',   'embed.ly (potøeba API klíè)');
@define('PLUGIN_EVENT_OEMBED_EMBEDLY_APIKEY',     'embed.ly API klíè');
@define('PLUGIN_EVENT_OEMBED_EMBEDLY_APIKEY_DESC','abyste mohli pou¾ívat embed.ly, potøebujete API klíè. Úèet zdarma umo¾òuje 10000 pou¾ití za mìsíc, co¾ by mìlo staèit i pro silnì vytí¾ené blogy, proto¾e výsledky jsou lokálnì cachovány a vkládány pouze jedenkrát na URL. Úèet zdarma mù¾ete zaregistrovat na http://app.embed.ly/pricing/free');

@define('PLUGIN_EVENT_OEMBED_INFO',      '<h3>Plugin oEmbed</h3>' .
'<p>'.
'Tento plugin zobarzuje místo zadané URL adresy její reprezentaci pro známé webové slu¾by. Napøíklad kdy¾ zadáte odkaz na youtube, nezobrazí odkaz na youtube, nýbr¾ rovnou odkazované video. Místo odkazu na flickr zobrazuje rovnou obrázek.<br/>' .
'Syntaxe pro pou¾ití tohoto pluginu je <b>[embed <i>odkaz</i>]</b> (nebo <b>[e <i>odkaz</i>]</b> pokud máte rad¹i zkratky).<br/>'.
'Pokud slu¾ba (adresa) není pluginem v souèasnosti podporována, bude zobrazen pouze klikatelný odkaz.<br/>'.
'</p><p>'.
'Zaøaïte prosím tento plugin na zaèátek seznamu pluginù, aby zadaný odkaz nemohl být zmìnìn jiným pluginem (napø. pøidáním href)'.
'</p>');

@define('PLUGIN_EVENT_OEMBED_SUPPORTED',      '<p>'.
'Plugin podporuje následující reprezentace odkazù, ani¾ by bylo potøeba nastavovat obecný fallback:%s'.
'</p>');