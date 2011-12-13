<?php # lang_cs.inc.php 1.0 2009-06-04 20:00:35 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/04
 */

@define('PLUGIN_EVENT_TEXTLINKADS_TITLE', 'Vložené reklamy (TextLinkAds.com, vlastní)');
@define('PLUGIN_EVENT_TEXTLINKADS_DESC', 'Vkládá reklamy do blogu.');
@define('PLUGIN_EVENT_TEXTLINKADS_INFO', '<p>Je tøeba upravit soubory šablon *.tpl a zadat, kam mají být vkládány reklamy, jinak se na blogu reklamy neobjeví. Použijte následující kód šablonovacího systému Smarty pro vložení reklam TextLinkAd.com: {serendipity_hookPlugin hook="external_service_tla" hookAll="true"}. Pokud chcete použít vlastní metodu pro vložení textových reklam, použijte tuto funkci Smarty následovnì:</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="X:Y"}</p>
<p>V kódu výše nahraïte "X" jménem podadresáøe (relativí cesta vzhledem k adresáøi s pluginy - obvykle "plugins/"), kde umístíte jednotlivé reklamy. Plugin pak v pravidelných intervalech daných parametrem "Y" ("weekly", "daily", "hourly", "half-hour", "per-call") projede adresáø a náhodnì vybere jeden z pøítomných *.html souborù a zobrazí jeho obsah jako reklamu.</p>
<p>Napøíklad, máte podadresáøe "hlavicky" a "paticky". V podadresáøi "hlavicky" máte soubory "hezka.html", "vtipna.html" a "obrovska.html". V podadresáøi "paticky" jsou sobory "obrovska.html" a "hrozna.html". Pak pozmìníte šablonu index.tpl tak, že nahoru vložíte:</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="hlavicky:daily"}</p>
<p>a do èásti s patièkou vložíte následující:</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="paticky:weekly"}</p>
<p>Když pak budete prohlížet blog, uvidíte na místech vložení kódu reklamy, které se budou mìnit se zadanou frekvencí. Do HTML souborù mùžete vložit libovolný HTML kód (napø. libovolný JavaScrip, GoogleAdSense, apod.)');
@define('PLUGIN_EVENT_TEXTLINKADS_HTMLID', '(Pouze TextLinkAds) CSS ID identifikátor HTML tagu, který obsahuje textové reklamy');
@define('PLUGIN_EVENT_TEXTLINKADS_XMLFILENAME', '(Pouze TextLinkAds) Jméno lokálního souboru, pdo ukládání textových odkazù');