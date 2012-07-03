<?php

@define('PLUGIN_EVENT_COMMENTSPICE_TITLE', 'Comment Spice');
@define('PLUGIN_EVENT_COMMENTSPICE_DESC',  'Würze Deinen Kommentarbereich mit Extras wie einem Twitterlink oder einem Link auf den letzten Artikel des Kommentators. Implementiert auch einige AntiSpam Routinen wie einen "Honeypot" und nofollow nach bestimmten Regeln.');

@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_TWITTERNAME', 'Twittername');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_ANNOUNC_RSS', 'Artikel bewerben');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_GENERAL', 'Generelle Einstellungen');

@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT', 'Erlaube Kommentatoren, ihren Twitternamen anzugeben');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_DESC', 'Hiermit erlaubst Du einem Kommentator, mit ihrem Kommentar auch ihren Twitternamen anzugeben. Wenn er dies tut, so wird seine Twitter Timeline mit seinem Kommentar verlinkt.');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_NOFOLLOW', 'Twitterlink auf nofollow setzen');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_NOFOLLOW_DESC', 'Wenn der Twitterlink auf nofollow gesetzt wird, werden Suchmaschinen ihn ignorieren. Dies macht die Eingabe für manuelle Kommentarspammer uninteressant, gibt aber weniger Kudos an den echten Kommentator.');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET', 'Erstelle Twitter Followme Widget');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_DESC', 'Wenn angeschaltet, wird das Followme Widget von Twitter in den Kommentaren angezeigt anstatt des eigenen Outputs. Das sieht recht gut aus, verlangsamt aber das Rendern der Kommentarliste, da es pro Kommentar nachgeladen werden muss. Wenn das Plugin smartifiziert ist, stellt das ein, ob $comment.spice_twitter_followme Inhalt hat oder nicht.');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_COUNT',  'Twitter Followme Widget Follower Anzahl');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_COUNT_DESC',    'Soll das Widget die aktuelle Anzahl der Follower des Kommentators anzeigen?');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_DARK',          'Twitter Followme Widget auf dunklem Hintergrund');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_DARK_DESC',     'Wenn Dein Template dunkel ist, so solltest Du diese Option einschalten.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS', 'Erlaube Kommentatoren, einen ihrer Artikel zu bewerben');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_DESC', 'Wenn der Kommentator eine Homepage eingegeben hat, wird CommentSpice die URL nach einem RSS feed durchsuchen. Wenn einer gefunden wurde, kann der Kommentator einen seiner Artikel aussuchen, der dann mit seinem Kommentar beworben wird.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_NOFOLLOW', 'Artikel Bewerbung auf nofollow setzen');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_NOFOLLOW_DESC', 'Wenn die Artikel Bewerbung auf nofollow gesetzt wird, werden Suchmaschinen ihn ignorieren. Dies macht die Eingabe für manuelle Kommentarspammer uninteressant, gibt aber weniger Kudos an den echten Kommentator.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT', 'Maximale Artikel Anzahl, aus der beworben werden darf');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT_DESC', 'Wie viele seiner neuesten Artikel sollen dem Kommentator maximal zu Auswahl vorgelegt werden?');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_CACHEMIN', 'Cache Minuten für Artikel Informationen');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_CACHEMIN_DESC', 'Wie viele Minuten sollen die Information für Artikel zwischen gespeichert werden? Ein bis zwei Stunden (60-120 Minuten) erscheint sinnvoll. Ein Wert von 0 schaltet den Cache aus.');

@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_RULES', 'Regeln');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTCOUNT', 'Minimale Anzahl an Kommentaren für Spice Extras');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTCOUNT_DESC', 'Minimale Anzahl von Kommentaren, die der Kommentator geschrieben haben muss, damit er die Extras benutzen darf. 0 bedeutet: Erlaube es allen.');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTLENGTH', 'Minimale Kommentarlänge für Spice Extras');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTLENGTH_DESC', 'Minimale Kommentarlänge, damit der Kommentator die Extras benutzen darf. 0 bedeutet: Kommentarlänge egal.');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTCOUNT', 'Minimale Anzahl an Kommentaren, um dofollow Links frei zu schalten');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTCOUNT_DESC', 'Minimale Anzahl von Kommentaren, die der Kommentator geschrieben haben muss, um dofollow Links frei zu schalten. 0 bedeutet: Immer frei schalten.');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTLENGTH', 'Minimale Kommentarlänge, um dofollow Links frei zu schalten');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTLENGTH_DESC', 'Minimale Kommentarlänge, um dofollow Links frei zu schalten. 0 bedeutet: Kommentarlänge egal.');
@define('PLUGIN_EVENT_COMMENTSPICE_ENABLED', 'angeschaltet');
@define('PLUGIN_EVENT_COMMENTSPICE_DISABED', 'ausgeschaltet');
@define('PLUGIN_EVENT_COMMENTSPICE_RULES', 'Regeln verwenden');

@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_TWITTER', 'Twittername Ausgabe smartifizieren');
@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_TWITTER_DESC', 'Wenn angeschaltet, wird CommentSpice keinen Code für den Twitterlink darstellen sondern wird benötigte Informationen in den Smarty Hash stecken. Damit das funktioniert, muss die comments.tpl angepasst werden. Verfügbare Variablen sind $comment.spice_twitter_name (Twittername, sollte auf Vorhandensein gecheckt werden), $comment.spice_twitter_url (URL der Twitter Timeline), $comment.spice_twitter_nofollow (Nofollow Einstllung für Twitterlinks), $comment.spice_twitter_icon_html (HTML, das das twitter icon darstellt), $comment.spice_twitter_followme (HTML, das das followme widget darstellt).');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_TWITTER', 'Kommentareditor Template wurde für Twittereingabe gepatched.');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_TWITTER_DESC', 'Wenn Dein commentform.tpl bereits gepatched wurde, um die Twitter Eingabe darzustellen, dann kannst Du diese Option einschalten. Ich habe dem Plugin Beispiel Templates beigefügt.');
@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_RSS', 'Artikelbewerbung smartifizieren');
@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_RSS_DESC', 'Wenn angeschaltet, wird CommentSpice keinen Code für die Artikelbewerbung darstellen sondern wird benötigte Informationen in den Smarty Hash stecken. Damit das funktioniert, muss die comments.tpl angepasst werden. Verfügbare Variablen sind $comment.spice_article_name (Name des Artikel, sollte auf Vorhandensein gecheckt werden). $comment.spice_article_url (Artikel URL), $comment.spice_article_nofollow (Nofollow Einstellung für Artikelbewerbung), $comment.spice_article_prefix (Prefix in der Sprache des Besuchers).');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_RSS', 'Kommentareditor Template wurde für Artikel Auswahl gepatched.');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_RSS_DESC', 'Wenn Dein commentform.tpl bereits gepatched wurde, um die Artikel Auswahl darzustellen, dann kannst Du diese Option einschalten. Ich habe dem Plugin Beispiel Templates beigefügt.');

@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK', 'Inhalt von Pingback Artikeln abholen');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_DESC', 'Wenn ein anderes Blog ein Pingback auf einen Artikel dieses Blogs schickt, ist nur die URL des fremden Artikels bekannt. Serendipity kann jedoch den Inhalt des fremden Artikels abholen und darstellen, so wie es von Trackbacks bekannt ist. Aus Performance Gründen tut Serendipity dies jedoch nicht per default. Hiermit kann eine Einstellung in die serendipity_config_local.inc.php geschrieben werden, die Serendipity dazu veranlasst, den Inhalt abzuholen. Wenn der Wert hier unverändert bleibt, dann wurde die Einstellung bereits manuell vorgenommen und überschreibt die Einstellung des Plugins. In dem Fall muss der manuelle Eintrag aus der serendipity_config_local.inc.php wieder entfernt werden, wenn die Einstellung mit diesem Plugin verändert werden soll.');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_LEAVE_ON', 'Behalte: Inhalt abholen');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_LEAVE_OFF', 'Behalte: Inhalt nicht abholen');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_FETCH', 'Setze auf: Inhalt abholen');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_DONTFETCH', 'Setze auf: Inhalt nicht abholen');

@define('PLUGIN_EVENT_COMMENTSPICE_PATH', 'Plugin Pfad');
@define('PLUGIN_EVENT_COMMENTSPICE_PATH_DESC', 'In normalen Installationen ist der Default die korrekte Einstellung.');
@define('PLUGIN_EVENT_COMMENTSPICE_REQUIRED_FIELDS', 'Pflichtfelder');
@define('PLUGIN_EVENT_COMMENTSPICE_REQUIRED_FIELDS_DESC', 'Geben Sie die Liste von Pflichtfeldern bei der Abgabe eines Kommentars ein. Mehrere Felder können mit "," getrennt werden. Verfügbare Felder sind: name, email, url, replyTo, comment');
@define('PLUGIN_EVENT_COMMENTSPICE_REASON_REQUIRED_FIELD', 'Sie haben das Feld "%s" nicht ausgefüllt!');

@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_SPAM', 'Anti Spam');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_SPAM_HONEYPOT', 'Honeypot einsetzen');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_SPAM_HONEYPOT_DESC', 'Ein "Honeypot" ist ein verstecktes Kommentar Feld, das leer gelasen werden soll. Da Bots aber dazu tendieren, alle vorgefundenen Felder auszufüllen, ist dies ein einfacher und unkritischer Weg, viele der Bots auszusperren. Um den Honeypot besonders effektiv zu machen, setze CommentSpice als erstes AntiSpam plugin in Deiner Liste ein.');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_SPAM_LOGTYPE', 'Spam Log Typ');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_SPAM_LOGTYPE_DESC', 'Wohin sollen Kommentare, die von CommentSpice gefunden wurden, geloggt werden?');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_SPAM_LOGTYPE_NONE', 'Nicht loggen');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_SPAM_LOGTYPE_FILE', 'Textdatei');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_SPAM_LOGTYPE_DATABASE', 'Spamlog Datenbank Tabelle');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_SPAM_LOGFILE', 'Logdatei');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_SPAM_LOGFILE_DESC', 'Wohin soll das Textfile für die Logs gespeichert werden?');

@define('PLUGIN_EVENT_COMMENTSPICE_EXPERTSETTINGS', 'Erweiterte Einstellungen anzeigen');
@define('PLUGIN_EVENT_COMMENTSPICE_STANDARDSETTINGS', 'Grundeinstellungen anzeigen');

@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER', 'Auf Twitter lesen');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_FOOTER', 'Wenn Du Deinen <b>Twitter Namen</b> eingibst wird Deine Timeline in Deinem Kommentar verlinkt.');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_PLACEHOLDER', 'Twittername oder name@identi.ca');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_LABEL', 'Twitter');

@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_LABEL', 'Bewirb einen Deiner Artikel');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_CHOOSE', '- Bewirb einen Deiner letzten Artikel -');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_RECENT', '%s schrieb auch');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_FOOTER', '<b>Bewirb einen Deiner letzten Artikel</b><br/>Dieses Blog erlaubt Dir mit Deinem Kommentar einen Deiner letzten Artikel zu bewerben. Bitte gib Deine Blog URL als Homepage ein, dann wird eine Auswahl erscheinen, in der Du einen Artikel auswählen kannst.'); 
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_CORRUPTED', 'Entschuldigung, bei der Übergabe "Deines letzten Artikels" ist etwas schief gegangen.');

@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_BOO','Audio Kommentare mittels audioboo.fm');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_BOO_DESC','Wenn Du z.B. ein Podcasting Blog hast, möchtest Du vielleicht Deinen Hörern erlauben, per Boo Audio (Mini Podcasts) zu kommentieren, die auf <a href="http://audioboo.fm" target="_blank">audioboo.fm</a> gehostet werden.');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_ALLOW','Erlaube Boo Kommentare');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_ALLOW_DESC','Schalte dies ein, wenn Du Deinen Lesern/Hörern Boo Audio Kommentare erlauben möchtest. Unterhalb des Kommentar Editors wird ein Feld erscheinen, in dem ein Boo eingetragen und (beta!) aufgenommen werden kann.');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_MODERATE','Moderiere Boo Kommentare');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_MODERATE_DESC','Schalte dies ein, wenn Audio Boos moderiert werden sollen.');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_FOOTER','Dieses Blog erlaubt Dir, Audio Kommentare über <a href="http://audioboo.fm/profile" target="_blank">audioboo.fm</a> hinzuzufügen. <a href="http://audioboo.fm/boos/new" target="_blank">Erstelle einen neuen Boo</a> und gib hier den Link auf die Seite Deines Boos ein.');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_PLACEHOLDER', 'http://audioboo.fm/boos/123456-title');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_WRONG', 'Tut mir leid, das scheint keine boo URL zu sein (http://audioboo.fm/boos/12345-title)');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_MODERATED', 'Boo Audio Kommentare werden vorerst moderiert, bitte habe etwas Geduld.');

@define('PLUGIN_EVENT_COMMENTSPICE_REQUIREMENTS', 'Bedingung');
@define('PLUGIN_EVENT_COMMENTSPICE_REQUIREMENTS_COMMENTCOUNT', '%s Kommentare geschrieben');
@define('PLUGIN_EVENT_COMMENTSPICE_REQUIREMENTS_COMMENTLEN', '%s Buchstaben in diesem Kommentar');
