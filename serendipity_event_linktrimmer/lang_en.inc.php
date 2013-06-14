<?php
define('PLUGIN_LINKTRIMMER_NAME', 'Linktrimmer');
define('PLUGIN_LINKTRIMMER_DESC', 'Allows you to truncate any link for redirection on your own blog, like tr.im, tinyurl.com etc.');
define('PLUGIN_LINKTRIMMER_ENTER', 'Enter URL: ');
define('PLUGIN_LINKTRIMMER_HASH', 'optional hash: ');
define('PLUGIN_LINKTRIMMER_RESULT', 'Shortened result: ');
define('PLUGIN_LINKTRIMMER_ERROR', 'Link could not be trimmed. Might be a duplicate, invalid custom hash, or database error.');
define('PLUGIN_LINKTRIMMER_LINKPREFIX', 'Link prefix');
define('PLUGIN_LINKTRIMMER_LINKPREFIX_DESC', 'Enter a unique URL portion that will be used on your domain to identify the base of the linktrimmer. If you enter "l" for example, your URLs will look like http://yourblog/l/feda [with URL-Rewriting enabled] or http://yourblog/index.php?/l/feda [without URL-Rewriting]. Never leave  empty, even if you have a separate domain for your short url.');
define('PLUGIN_LINKTRIMMER_DOMAIN', 'Domain');
define('PLUGIN_LINKTRIMMER_DOMAIN_DESC', 'The link that is used for the output. You could use .htaccess redirection of any other domain you own and enter that here. If you have Serendipity on http://mylongdomain.com/serendipity/ but also own http://short.com/ you could enter http://short.com/ here, and inside the .htaccess of short.com redirect everything to your longdomain: RewriteRule ^(.*)$ http://longdomain.com/serendipity/yourprefix/$1 (alternativly: redirectMatch 301 ^(.*)$ http://longdomain.com/serendipity/yourprefix/$1). URLs are then redirected twice: from your short.com to mylongdomain.com to the original URL.');

define('PLUGIN_LINKTRIMMER_FRONTPAGE_OPTION', 'Show linktrimmer on backend frontpage?');
