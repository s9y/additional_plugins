<?php

@define('PLUGIN_EVENT_XMLRPC_NAME', 'Einträge via XML-RPC erstellen');
@define('PLUGIN_EVENT_XMLRPC_DESC', 'Ermöglicht Einträge via XML-RPC API zu erstellen/bearbeiten (MT, Blogger, WordPress API-Endpunkte)');
@define('PLUGIN_EVENT_XMLRPC_DEFAULTCAT', 'Standard-Kategorie');
@define('PLUGIN_EVENT_XMLRPC_DEFAULTCAT_DESC', 'Bestimmt die Standard-Kategorie für Blog-Artikel via XML-RPC, wenn der Client keine Kategorie setzt.');
@define('PLUGIN_EVENT_XMLRPC_GMT', 'GMT Zeitzone verwenden');

@define('PLUGIN_EVENT_XMLRPC_DOC_RPCLINK','<b>Zur Information:</b><br/>Dieses Blog hat eine URL, an der XML-RPC Aufrufe abgearbeitet werden. Modernere Clients können diese automatisch mit der Blog URL ermitteln, bei älteren Clients muss sie explizit angegeben werden.<br/>Deine XML-RPC URL ist: <b>%s</b><br/>');

@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG', 'Debug Log');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_DESC', 'Wenn Du daran interessiert bist, was die XML-RPC Schnittstelle empfängt und antwortet, kannst Du das Debug Log anschalten. Das Logfile wird als rpc.log im Plugin Verzeichnis angelegt.'); // Die \'debug\' Einstellung ist nur zum Auffinden von Problemen geeignet, sie produziert Antworten, mit denen ein Client nicht umgehen kann. Also bitte nicht in einem Live System einschalten!');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_NONE', 'ausgeschaltet');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_NORMAL', 'angeschaltet');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_VERBOSE', 'debug: Nicht für Clients!');

@define('PLUGIN_EVENT_XMLRPC_WPFAKEVERSION', 'WordPress Version vortäuschen');
@define('PLUGIN_EVENT_XMLRPC_WPFAKEVERSION_DESC', 'Die XML-RPC Schnittlstelle kann auf WordPress Aufrufe reagieren. Wenn sie nach der installierten Software Version gefragt wird, antwortet sie normaler Weise mit Serendipity ' . $serendipity['version'] .'. Wenn Du hier eine Version einträgst, dann wird sie mit WordPress (angegebene Version) antworten. Einige Clients könnten auf eine minimale WordPress Version testen, eine Version wie 3.2 erscheint dann okay.');
@define('PLUGIN_EVENT_XMLRPC_HTMLCONVERT', 'Text Artikel nach HTML konvertieren');
@define('PLUGIN_EVENT_XMLRPC_HTMLCONVERT_DESC', 'Das Plugin versucht zu erkennen, ob Artikel als reine Texte oder als HTML übermittelt werden. Bei reinem Text wird es Zeilenumbrüche in HTML umwandeln. Wenn Du z.B: ein Textile oder das NL2BR Plugin für Artikel benutzt, solltest Du diese Option ausschalten.');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR', 'Benutze Login als Kommentar Autor');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_DESC', 'Manche Clients speichern Kommentare mit einem generischen Autorennamen wie \'from WordPress\'. Wenn diese Option eingeschaltet ist, so wird immer der Name des eingeloggten Benutzers als Autor genommen.');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_DEFAULT', 'Autor nicht verändern');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_LOGIN', 'Loginname als Autor');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_REALNAME', 'Realname als Autor');
@define('PLUGIN_EVENT_XMLRPC_UPLOADDIR', 'Upload Verzeichnis');
@define('PLUGIN_EVENT_XMLRPC_UPLOADDIR_DESC', 'In welches Medienverzeichnis sollen Medien (wie Bilder und Videos) hoch geladen werden, die der Client schickt?');

@define('PLUGIN_EVENT_XMLRPC_EVENT_SPAM_HEADER', 	'<h3>SPAM an AntiSpam Plugins signalisieren</h3>
Das Plugin kann SPAM und HAM Signale an AntiSpam Plugins senden.<br/>
Dies wird von dem AntiSpam Plugin (das dies unterstützt) genauso abgearbeitet, als ob in der Admin Oberfläche die Knöpfe Ham oder Spam gedrückt wurden.<br/>
Da allerdings manche Clients keinen eigenen Spam Knopf anbieten, sondern nur Moderieren und Freischalten, kann man hier einstellen, wann diese Signale verschickt werden sollen.<br/>
Bei einem Client ohne separatem Spam Knopf will man das Signal z.B. schicken, wenn man einen Kommentar moderiert.');
@define('PLUGIN_EVENT_XMLRPC_EVENT_SPAM', 			'Kommentar wurde als SPAM markiert');
@define('PLUGIN_EVENT_XMLRPC_EVENT_SPAM_DESC',		'Der Client hat den Kommentar als SPAM markiert');
@define('PLUGIN_EVENT_XMLRPC_EVENT_APPROVED',   	'Kommentar wurde frei geschaltet');
@define('PLUGIN_EVENT_XMLRPC_EVENT_APPROVED_DESC',	'Im Client wurde der Kommentar frei geschaltet');
@define('PLUGIN_EVENT_XMLRPC_EVENT_PENDING', 		'Kommentar wurde moderiert');
@define('PLUGIN_EVENT_XMLRPC_EVENT_PENDING_DESC',	'Im Client wurde der Kommentar moderiert');
@define('PLUGIN_EVENT_XMLRPC_EVENTVALUE_NONE', 	    'Nichts im SPAM Zusammenhang');
@define('PLUGIN_EVENT_XMLRPC_EVENTVALUE_SPAM', 	    'Signalisiere als SPAM');
@define('PLUGIN_EVENT_XMLRPC_EVENTVALUE_HAM', 	    'Signalisiere als HAM');
