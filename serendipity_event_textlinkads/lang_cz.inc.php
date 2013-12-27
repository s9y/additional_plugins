/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/04
 */

@define('PLUGIN_EVENT_TEXTLINKADS_TITLE', 'Vlo¾ené reklamy (TextLinkAds.com, vlastní)');
@define('PLUGIN_EVENT_TEXTLINKADS_DESC', 'Vkládá reklamy do blogu.');
@define('PLUGIN_EVENT_TEXTLINKADS_INFO', '<p>Je tøeba upravit soubory ¹ablon *.tpl a zadat, kam mají být vkládány reklamy, jinak se na blogu reklamy neobjeví. Pou¾ijte následující kód ¹ablonovacího systému Smarty pro vlo¾ení reklam TextLinkAd.com: {serendipity_hookPlugin hook="external_service_tla" hookAll="true"}. Pokud chcete pou¾ít vlastní metodu pro vlo¾ení textových reklam, pou¾ijte tuto funkci Smarty následovnì:</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="X:Y"}</p>
<p>V kódu vý¹e nahraïte "X" jménem podadresáøe (relativí cesta vzhledem k adresáøi s pluginy - obvykle "plugins/"), kde umístíte jednotlivé reklamy. Plugin pak v pravidelných intervalech daných parametrem "Y" ("weekly", "daily", "hourly", "half-hour", "per-call") projede adresáø a náhodnì vybere jeden z pøítomných *.html souborù a zobrazí jeho obsah jako reklamu.</p>
<p>Napøíklad, máte podadresáøe "hlavicky" a "paticky". V podadresáøi "hlavicky" máte soubory "hezka.html", "vtipna.html" a "obrovska.html". V podadresáøi "paticky" jsou sobory "obrovska.html" a "hrozna.html". Pak pozmìníte ¹ablonu index.tpl tak, ¾e nahoru vlo¾íte:</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="hlavicky:daily"}</p>
<p>a do èásti s patièkou vlo¾íte následující:</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="paticky:weekly"}</p>
<p>Kdy¾ pak budete prohlí¾et blog, uvidíte na místech vlo¾ení kódu reklamy, které se budou mìnit se zadanou frekvencí. Do HTML souborù mù¾ete vlo¾it libovolný HTML kód (napø. libovolný JavaScrip, GoogleAdSense, apod.)');
@define('PLUGIN_EVENT_TEXTLINKADS_HTMLID', '(Pouze TextLinkAds) CSS ID identifikátor HTML tagu, který obsahuje textové reklamy');
@define('PLUGIN_EVENT_TEXTLINKADS_XMLFILENAME', '(Pouze TextLinkAds) Jméno lokálního souboru, pdo ukládání textových odkazù');