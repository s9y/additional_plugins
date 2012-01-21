<?php
@define('PLUGIN_EVENT_COMMENTSPICE_TITLE', 'Comment Spice');
@define('PLUGIN_EVENT_COMMENTSPICE_DESC',  'Würze Deinen Kommentarbereich mit Extras wie einem Twitterlink oder einem Link auf den letzten Artikel des Kommentators.');

@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT', 'Erlaube Kommentatoren, ihren Twitternamen anzugeben');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_DESC', 'Hiermit erlaubst Du einem Kommentator, mit ihrem Kommentar auch ihren Twitternamen anzugeben. Wenn er dies tut, so wird seine Twitter Timeline mit seinem Kommentar verlinkt.');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_NOFOLLOW', 'Twitterlink auf nofollow setzen');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_NOFOLLOW_DESC', 'Wenn der Twitterlink auf nofollow gesetzt wird, werden Suchmaschinen ihn ignorieren. Dies macht die Eingabe für manuelle Kommentarspammer uninteressant, gibt aber weniger Kudos an den echten Kommentator.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS', 'Erlaube Kommentatoren, einen ihrer Artikel zu bewerben');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_DESC', 'Wenn der Kommentator eine Homepage eingegeben hat, wird CommentSpice die URL nach einem RSS feed durchsuchen. Wenn einer gefunden wurde, kann der Kommentator einen seiner Artikel aussuchen, der dann mit seinem Kommentar beworben wird.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_NOFOLLOW', 'Artikel Bewerbung auf nofollow setzen');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_NOFOLLOW_DESC', 'Wenn die Artikel Bewerbung auf nofollow gesetzt wird, werden Suchmaschinen ihn ignorieren. Dies macht die Eingabe für manuelle Kommentarspammer uninteressant, gibt aber weniger Kudos an den echten Kommentator.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT', 'Maximale Artikel Anzahl, aus der beworben werden darf');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT_DESC', 'Wie viele seiner neuesten Artikel sollen dem Kommentator maximal zu Auswahl vorgelegt werden?');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_CACHEMIN', 'Cache Minuten für Artikel Informationen');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_CACHEMIN_DESC', 'Wie viele Minuten sollen die Information für Artikel zwischen gespeichert werden? Ein bis zwei Stunden (60-120 Minuten) erscheint sinnvoll. Ein Wert von 0 schaltet den Cache aus.');
@define('PLUGIN_EVENT_COMMENTSPICE_PATH', 'Plugin Pfad');
@define('PLUGIN_EVENT_COMMENTSPICE_PATH_DESC', 'In normalen Installationen ist der Default die korrekte Einstellung.');

@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER', 'Auf Twitter lesen');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_FOOTER', 'Wenn Du Deinen <b>Twitter Namen</b> eingibst wird Deine Timeline in Deinem Kommentar verlinkt.');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_PLACEHOLDER', 'Dein Twittername');

@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_CHOOSE', '- Bewirb einen Deiner letzten Artikel -');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_RESCENT', '%s schrieb auch');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_FOOTER', '<b>Bewirb einen Deiner letzten Artikel</b><br/>Dieses Blog erlaubt Dir mit Deinem Kommentar einen Deiner letzten Artikel zu bewerben. Bitte gib Deine Blog URL als Homepage ein, dann wird eine Auswahl erscheinen, in der Du einen Artikel auswählen kannst.'); 
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_CORRUPTED', 'Entschuldigung, bei der Übergabe "Deines letzten Artikels" ist etwas schief gegangen.');
