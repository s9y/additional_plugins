<?php # lang_cs.inc.php 1.0 2009-08-14 21:06:50 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/08/14
 */@define('PLUGIN_LINKTRIMMER_NAME', 'Zkracovač adres');
@define('PLUGIN_LINKTRIMMER_DESC', 'Umožňuje zkrátit odkaz na Váš blog, podobně jako třeba tr.im, tinyurl.com apod.');
@define('PLUGIN_LINKTRIMMER_ENTER', 'Zadejte URL adresu: ');
@define('PLUGIN_LINKTRIMMER_HASH', 'volitelný hash kód: ');
@define('PLUGIN_LINKTRIMMER_RESULT', 'Zkrácený výsledek: ');
@define('PLUGIN_LINKTRIMMER_ERROR', 'Odkaz nelze zkrátit. Možná se jedná o duplicitu, neplatný hash nebo databázovou chybu.');
@define('PLUGIN_LINKTRIMMER_LINKPREFIX', 'Předpona odkazu');
@define('PLUGIN_LINKTRIMMER_LINKPREFIX_DESC', 'Zadejte jedinečnou část URL adresy, která bude použita ve Vaší doméně pro identifikaci zkracovače odkazů. Pokud např. zadáte "I", Vaše URL adresa bude vypadat jako http://vasBlog/l/feda [se zapnutým přepisováním URL adres] nebo http://vasBlog/l/feda [bez URL přepisování]');
@define('PLUGIN_LINKTRIMMER_DOMAIN', 'Doména');
@define('PLUGIN_LINKTRIMMER_DOMAIN_DESC', 'Odkaz použitý jako výsledek. Můžete použít přesměrování pomocí .htaccess na jiné doméně, kterou vlastníte. Tu zadáte zde. Pokud Vaše Serendipity běží na http://vaseDlouhaDomena.cz/serendipity, ale vlastníte taky http://kratka.cz, můžete zde zadat http://kratka.cz a na http://kratka.cz umístítě soubor .htaccess, který bude všechno přesměrovávat na dlouhou doménu následovně: RewriteRule ^(.*)$ http://vaseDlouhaDomena.cz/serendipity/$1.');