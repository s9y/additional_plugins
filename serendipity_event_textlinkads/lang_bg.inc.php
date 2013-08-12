<?php # 

/**
 *  @version 
 *  @author Ivan Cenov <JWalker@hotmail.bg>
 *  EN-Revision: 1.3
 */

@define('PLUGIN_EVENT_TEXTLINKADS_TITLE', 'TextLinkAds.com Ad');
@define('PLUGIN_EVENT_TEXTLINKADS_DESC', 'Вгражда рекламни банери в страниците на блога.');
@define('PLUGIN_EVENT_TEXTLINKADS_INFO', '<p>Редактирайте Smarty .tpl файла на вашия шаблон за да укажете къде да бъде разположен банера, иначе той не би се появил на сайта. Използвайте този Smarty код, зада сложите банера: {serendipity_hookPlugin hook="external_service_tla" hookAll="true"}. Ако искате да използвате специфичен метод за показване, можете да ползвате следното Smarty повикване:</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="X:Y"}</p>
<p>Заменете "X" с името на поддиректорията (относително базовата директория на приставките), където желаете the Ad-Snippets да се появят. Приставката ще обхожда тази поддиректория със зададена честота Y ("седмично", "дневно", "на все час", "на всеки половин час", "при всяко повикване") и ще избира по случаен начин .html файл.</p>
<p> Например, имате поддиректория "headers" и "footers". В "headers" се намират файловете "nice.html", "nifty.html" и "great.html". В "footers" се намират "great.html" и "awesome.html". Редактирайте вашият файл index.tpl и поставете следния код най-отгоре (в секция "top"):</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="headers:daily"}</p>
<p>Също така, поставете следния код в секция "footer":</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="footers:weekly"}</p>
<p>След като се обърнете към блога, ще видите съдържанието на случайно избран .html файл вмъкнат в съдържанието му. Той ще бъде променен след изтичане на зададения период (седмица, ден, час ...). В HTML файловете можете да слагате HTML код, какъвто желаете, също и JavaScript, GoogleAdSense и т.н.');
@define('PLUGIN_EVENT_TEXTLINKADS_HTMLID', 'CSS ID на HTML елемента с вашите реклами');
@define('PLUGIN_EVENT_TEXTLINKADS_XMLFILENAME', 'Локално име на файл, където да се запише връзката');
