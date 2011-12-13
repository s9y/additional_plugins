<?php # lang_cz.inc.php 1.0 2009-06-04 20:00:35 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/04
 */

@define('PLUGIN_EVENT_TEXTLINKADS_TITLE', 'Vložené reklamy (TextLinkAds.com, vlastní)');
@define('PLUGIN_EVENT_TEXTLINKADS_DESC', 'Vkládá reklamy do blogu.');
@define('PLUGIN_EVENT_TEXTLINKADS_INFO', '<p>Je třeba upravit soubory šablon *.tpl a zadat, kam mají být vkládány reklamy, jinak se na blogu reklamy neobjeví. Použijte následující kód šablonovacího systému Smarty pro vložení reklam TextLinkAd.com: {serendipity_hookPlugin hook="external_service_tla" hookAll="true"}. Pokud chcete použít vlastní metodu pro vložení textových reklam, použijte tuto funkci Smarty následovně:</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="X:Y"}</p>
<p>V kódu výše nahraďte "X" jménem podadresáře (relativí cesta vzhledem k adresáři s pluginy - obvykle "plugins/"), kde umístíte jednotlivé reklamy. Plugin pak v pravidelných intervalech daných parametrem "Y" ("weekly", "daily", "hourly", "half-hour", "per-call") projede adresář a náhodně vybere jeden z přítomných *.html souborů a zobrazí jeho obsah jako reklamu.</p>
<p>Například, máte podadresáře "hlavicky" a "paticky". V podadresáři "hlavicky" máte soubory "hezka.html", "vtipna.html" a "obrovska.html". V podadresáři "paticky" jsou sobory "obrovska.html" a "hrozna.html". Pak pozměníte šablonu index.tpl tak, že nahoru vložíte:</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="hlavicky:daily"}</p>
<p>a do části s patičkou vložíte následující:</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="paticky:weekly"}</p>
<p>Když pak budete prohlížet blog, uvidíte na místech vložení kódu reklamy, které se budou měnit se zadanou frekvencí. Do HTML souborů můžete vložit libovolný HTML kód (např. libovolný JavaScrip, GoogleAdSense, apod.)');
@define('PLUGIN_EVENT_TEXTLINKADS_HTMLID', '(Pouze TextLinkAds) CSS ID identifikátor HTML tagu, který obsahuje textové reklamy');
@define('PLUGIN_EVENT_TEXTLINKADS_XMLFILENAME', '(Pouze TextLinkAds) Jméno lokálního souboru, pdo ukládání textových odkazů');