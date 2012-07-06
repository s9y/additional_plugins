<?php

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_TITLE', 'Spamschutz Biene (Honeypot)');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_DESC',  'Implementiert Kommentar AntiSpam Maßnahmen, die einfach zu konfigurieren aber sehr effektiv sind (Honeypot).');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_EXTRA_DESC',  '<strong>Installationshinweis</strong>: Es ist recht wichtig, dieses Plugin an die Spitze Deiner Plugin Liste zu verschieben, weil es dann am effektivsten arbeiten kann.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_PATH', 'Plugin Pfad');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_PATH_DESC', 'In normalen Installationen ist der Default die korrekte Einstellung.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS', 'Pflichtfelder beim Kommentieren');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS_DESC', 'Geben Sie die Liste von Pflichtfeldern bei der Abgabe eines Kommentars ein. Mehrere Felder können mit "," getrennt werden. Verfügbare Felder sind: name, email, url, replyTo, comment');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REASON_REQUIRED_FIELD', 'Sie haben das Feld "%s" nicht ausgefüllt!');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT', 'Honeypot einsetzen');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT_DESC', 'Ein "Honeypot" ist ein verstecktes Kommentar Feld, das leer gelasen werden soll. Da Bots aber dazu tendieren, alle vorgefundenen Felder auszufüllen, ist dies ein einfacher und unkritischer Weg, viele der Bots auszusperren. Um den Honeypot besonders effektiv zu machen, setze die Spamschutz Biene als erstes AntiSpam plugin in Deiner Liste ein.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE', 'Spam Log Typ');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DESC', 'Wohin sollen Kommentare, die von der Spamschutz Biene gefunden wurden, geloggt werden?');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_NONE', 'Nicht loggen');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_FILE', 'Textdatei');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DATABASE', 'Spamlog Datenbank Tabelle');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE', 'Logdatei');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE_DESC', 'Wohin soll das Textfile für die Logs gespeichert werden?');
