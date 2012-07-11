<?php

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_TITLE', 'Spamschutz Biene (Honeypot, Verstecktes Captcha)');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_DESC',  'Implementiert Kommentar AntiSpam Maßnahmen, die einfach zu konfigurieren aber sehr effektiv sind.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_EXTRA_DESC',  '<strong>Installationshinweis</strong>: Es ist recht wichtig, dieses Plugin an die Spitze Deiner Plugin Liste zu verschieben, weil es dann am effektivsten arbeiten kann.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_PATH', 'Plugin Pfad');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_PATH_DESC', 'In normalen Installationen ist der Default die korrekte Einstellung.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS', 'Pflichtfelder beim Kommentieren');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS_DESC', 'Geben Sie die Liste von Pflichtfeldern bei der Abgabe eines Kommentars ein. Mehrere Felder können mit "," getrennt werden. Verfügbare Felder sind: name, email, url, replyTo, comment');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REASON_REQUIRED_FIELD', 'Sie haben das Feld "%s" nicht ausgefüllt!');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_TITLE', 'Kommentare abweisen, die als Text nur den Artikeltitel enthalten');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_TITLE_DESC', 'Einige Kommentar SpamBots wollen nur einen Link absetzen und füllen den Kommentar einfach mit dem, was im Seitentitel gefunden wird. Dies würde kein normaler Kommentator tun, somit ist es sicher, diese Option einzuschalten.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_SAMEBODY', 'Kommentare abweisen, die einen bereits gespeicherten Text haben');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_SAMEBODY_DESC', 'Dies wird Kommentare abweisen, die einen Text haben, der im System bereits gespeichert wurde. Z.B. wenn ein Kommentator nach einer Kommentar Speicherung die Seite erneut lädt. Solche Kommentare können sicher abgewiesen werden.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_ERROR_BODY', 'Antispam Maßnahme: Ungültiger Kommentar.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT', 'Honeypot einsetzen');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT_DESC', 'Ein "Honeypot" ist ein verstecktes Kommentar Feld, das leer gelasen werden soll. Da Bots aber dazu tendieren, alle vorgefundenen Felder auszufüllen, ist dies ein einfacher und unkritischer Weg, viele der Bots auszusperren. Um den Honeypot besonders effektiv zu machen, setze die Spamschutz Biene als erstes AntiSpam plugin in Deiner Liste ein.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_WARN_HONEPOT', 'Du willst mir nicht wirklich Deine Nummer geben, oder? ;)');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HCAPTCHA', 'Versteckte Captchas');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HCAPTCHA_DESC', 'Hiermit wird ein Captcha erzeugt, das für Menschen sehr einfach zu lösen ist, aber nicht für Bots. Wenn der Kommentator Javascript angeschaltet hat, wird das Captcha sogar automatisch gelöst und versteckt. Da Bots kein Javascript unterstützen, ist dies eine weitere Falle für Bots, die für normale Benutzer unsichtbar ist.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_ERROR_HCAPTCHA', 'Antispam Maßnahme: Falsches Captcha.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE', 'Spam Log Typ');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DESC', 'Wohin sollen Kommentare, die von der Spamschutz Biene gefunden wurden, geloggt werden?');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_NONE', 'Nicht loggen');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_FILE', 'Textdatei');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DATABASE', 'Spamlog Datenbank Tabelle');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE', 'Logdatei');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE_DESC', 'Wohin soll das Textfile für die Logs gespeichert werden?');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_OFF', 'Ausgeschaltet');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_MODERATE', 'Kommentare moderieren');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_REJECT', 'Kommentare abweisen');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_0', 'Null');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_1', 'Eins');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_2', 'Zwei');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_3', 'Drei');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_4', 'Vier');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_5', 'Fünf');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_6', 'Sechs');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_7', 'Sieben');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_8', 'Acht');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_9', 'Neun');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_10', 'Zehn');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_PLUS', 'plus');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_MINUS', 'minus');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_QUEST', 'Was ist');
