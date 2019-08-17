<?php
define('PLUGIN_LINKTRIMMER_NAME', 'Linkverkürzung');
define('PLUGIN_LINKTRIMMER_DESC', 'Ermöglicht Linkverkürzung zur Weiterleitung in Ihrem eigenen Blog, z.B. vermittels tr.im, tinyurl.com usw.');
define('PLUGIN_LINKTRIMMER_ENTER', 'URL eingeben: ');
define('PLUGIN_LINKTRIMMER_HASH', 'Optional Hash: ');
define('PLUGIN_LINKTRIMMER_RESULT', 'Verkürztes result: ');
define('PLUGIN_LINKTRIMMER_ERROR', 'Link konnte nicht gekürzt werden. Möglicherweise handelt es sich um ein Duplikat, einen ungültigen benutzerdefinierten Hash oder einen Datenbankfehler.');
define('PLUGIN_LINKTRIMMER_LINKPREFIX', 'Link-Prefix');
define('PLUGIN_LINKTRIMMER_LINKPREFIX_DESC', 'Geben Sie einen eindeutigen URL-Teil ein, der innerhalb Ihrer Domain als Basis-URL für den Linkverkürzer verwendet wird. Wenn Sie beispielsweise "l" eingeben, sehen Ihre URLs wie folgt aus: http://yourblog/l/ feda [mit aktiviertem URL-Rewriting] oder http://yourblog/index.php?/L/feda [ohne URL-Rewriting ]. Lassen Sie das Feld niemals leer, auch wenn Sie eine separate Domain für Ihre kurzen URLs haben.');
define('PLUGIN_LINKTRIMMER_DOMAIN', 'Domain');
define('PLUGIN_LINKTRIMMER_DOMAIN_DESC', 'Der Link, der für die Ausgabe verwendet wird. Sie können die .htaccess-Umleitung jeder anderen, ihnen gehörenden Domain verwenden und diese hier eingeben. Wenn Sie Serendipity auf http://mylongdomain.com/serendipity/ installiert haben, aber auch http://short.com/ besitzen, können Sie hier http://short.com/ eingeben und innerhalb des .htaccess von short.com alles umleiten zu Ihrer langen Domain:  RewriteRule ^(.*)$ http://longdomain.com/serendipity/yourprefix/$1 (alternativ: redirectMatch 301 ^(.*)$ http://longdomain.com/serendipity/yourprefix/$1). URLs werden dann zweimal umgeleitet: von short.com zu mylongdomain.com zur ursprünglichen URL.');

define('PLUGIN_LINKTRIMMER_FRONTPAGE_OPTION', 'Linkverkürzer auf der Backend-Startseite anzeigen?');
