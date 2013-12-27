/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/08/14
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/06/22
 */
@define('PLUGIN_LINKTRIMMER_NAME', 'Zkracovaè adres');
@define('PLUGIN_LINKTRIMMER_DESC', 'Umo¾òuje zkrátit odkaz na Vá¹ blog, podobnì jako tøeba tr.im, tinyurl.com apod.');
@define('PLUGIN_LINKTRIMMER_ENTER', 'Zadejte URL adresu: ');
@define('PLUGIN_LINKTRIMMER_HASH', 'volitelný hash kód: ');
@define('PLUGIN_LINKTRIMMER_RESULT', 'Zkrácený výsledek: ');
@define('PLUGIN_LINKTRIMMER_ERROR', 'Odkaz nelze zkrátit. Mo¾ná se jedná o duplicitu, neplatný hash nebo databázovou chybu.');
@define('PLUGIN_LINKTRIMMER_LINKPREFIX', 'Pøedpona odkazu');
@define('PLUGIN_LINKTRIMMER_LINKPREFIX_DESC', 'Zadejte jedineènou èást URL adresy, která bude pou¾ita ve Va¹í doménì pro identifikaci zkracovaèe odkazù. Pokud napø. zadáte "I", Va¹e URL adresa bude vypadat jako http://vasBlog/l/feda [se zapnutým pøepisováním URL adres] nebo http://vasBlog/l/feda [bez URL pøepisování]');
@define('PLUGIN_LINKTRIMMER_DOMAIN', 'Doména');
@define('PLUGIN_LINKTRIMMER_DOMAIN_DESC', 'Odkaz pou¾itý jako výsledek. Mù¾ete pou¾ít pøesmìrování pomocí .htaccess na jiné doménì, kterou vlastníte. Tu zadáte zde. Pokud Va¹e Serendipity bì¾í na http://vaseDlouhaDomena.cz/serendipity, ale vlastníte taky http://kratka.cz, mù¾ete zde zadat http://kratka.cz a na http://kratka.cz umístítì soubor .htaccess, který bude v¹echno pøesmìrovávat na dlouhou doménu následovnì: RewriteRule ^(.*)$ http://vaseDlouhaDomena.cz/serendipity/$1.');

// Next lines were translated on 2013/06/22
@define('PLUGIN_LINKTRIMMER_FRONTPAGE_OPTION', 'Zobrazovat zkracovaè adres na hlavní stránce administraèní sekce?');