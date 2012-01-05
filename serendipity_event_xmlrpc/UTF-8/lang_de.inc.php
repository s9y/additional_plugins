<?php

@define('PLUGIN_EVENT_XMLRPC_NAME', 'Einträge via XML-RPC erstellen');
@define('PLUGIN_EVENT_XMLRPC_DESC', 'Ermöglicht Einträge via XML-RPC API zu erstellen/bearbeiten (MT, Blogger, WordPress API-Endpunkte)');
@define('PLUGIN_EVENT_XMLRPC_DEFAULTCAT', 'Standard-Kategorie');
@define('PLUGIN_EVENT_XMLRPC_DEFAULTCAT_DESC', 'Bestimmt die Standard-Kategorie für Blog-Artikel via XML-RPC, wenn der Client keine Kategorie setzt.');
@define('PLUGIN_EVENT_XMLRPC_GMT', 'GMT Zeitzone verwenden');

@define('PLUGIN_EVENT_XMLRPC_DOC_RPCLINK','<b>Zur Information:</b><br/>Dieses Blog hat eine URL, an der XML-RPC Aufrufe abgearbeitet werden. Modernere Clients können diese automatisch mit der Blog URL ermitteln, bei älteren Clients muss sie explizit angegeben werden.<br/>Deine XML-RPC URL ist: <b>%s</b><br/>');

@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG', 'Debug Log');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_DESC', 'Wenn Du daran interessiert bist, was die XML-RPC Schnittstelle empfängt und antwortet, kannst Du das Debug Log anschalten. Das Logfile wird als rpc.log im Plugin Verzeichnis angelegt.');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_NONE', 'ausgeschaltet');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_NORMAL', 'angeschaltet');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_VERBOSE', 'ausführlich');

@define('PLUGIN_EVENT_XMLRPC_WPFAKEVERSION', 'WordPress Version vortäuschen');
@define('PLUGIN_EVENT_XMLRPC_WPFAKEVERSION_DESC', 'Die XML-RPC Schnittlstelle kann auf WordPress Aufrufe reagieren. Wenn sie nach der installierten Software Version gefragt wird, antwortet sie normaler Weise mit Serendipity ' . $serendipity['version'] .'. Wenn Du hier eine Version einträgst, dann wird sie mit WordPress (angegebene Version) antworten. Einige Clients könnten auf eine minimale WordPress Version testen, eine Version wie 3.2 erscheint dann okay.');
