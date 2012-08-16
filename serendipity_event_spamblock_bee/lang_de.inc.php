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

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SECTION_LOGGING', 'Dateien und Logging');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SECTION_ADVANCED', 'Fortgeschrittene Captcha-Konfiguration');

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

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_DEFAULT', 'Standard');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_JSON', 'JSON');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_SMARTY', 'Smarty');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_SMARTY_ENC', 'Smarty + Verschlüsselung');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QT_MATH', 'Rechenaufgaben');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QT_CUSTOM', 'Eigene Fragen');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DESC', 'Fortgeschrittene Konfigurationsoptionen für das verstecke Captcha. Wenn dieses nicht aktiviert ist, kann dieser Abschnitt getrost übersprungen werden.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWER_RETRIEVAL', 'Methode für Abfrage der Antwort');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWER_RETRIEVAL_DESC', 'Wähle hier aus, wie die korrekte Antwort abgefragt werden soll. Bei Auswahl von "JSON" kann ein Ajax-Request an index.php/plugin/spamblockbeecaptcha abgesetzt werden, um die richtige Antwort zu erhalten. Die Auswahl "Smarty" wird die Antwort über die Smarty-Variable {$beeCaptchaAnswer} bereitstellen, während "Standard" den Wert in der Seite hartkodiert. ACHTUNG: ist "Smarty" ausgewählt, wird keinerlei zusätzliches CSS oder JavaScript eingebunden. Das Captcha-Feld muss also selbst befüllt und versteckt werden. "Smarty + Verschlüsselung" ist dasselbe wie "Smarty" mit dem Unterschied, dass die {$beeCaptchaAnswer} mit einer simplen XOR-Verschlüsselung verschleiert wurde. Der Entschlüsselungs-Key steht in der Variablen {$beeCaptchaScrambleKey}.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTION_TYPE', 'Art der Frage');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTION_TYPE_DESC', 'Spamschutz Biene kann automatisch simple Rechenaufgaben generieren. Es können aber auch eigene Fragen und Antworten angegeben werden. Wähle aus, was du bevorzugst.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTIONS', 'Eigene Fragen');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DEFAULT_QUESTIONS', "Frage1\nFrage2");
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTIONS_DESC', 'Wenn du eigene Fragen verwenden möchtest, gib diese hier an. Schreibe dabei eine Frage pro Zeile. Bevor der Benutzer das Formular absenden kann, muss er eine zufällig aus der Liste gewählte Frage beantworten.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWERS', 'Antworten auf die Fragen');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWERS_DESC', 'Dieses Feld enthält die korrekten Antworten auf die oben angegebenen Fragen. Gib pro Zeile eine Antwort an in derselben Reihenfolge, die auch die Fragen haben. Fragen, für die es keine Antworten gibt, werden ignoriert. Groß- und Kleinschreibung spielt keine Rolle (d.h. "Antwort" ist dasselbe wie "antwort".');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DEFAULT_ANSWERS', "Antwort1\nAntwort2");
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_USE_REGEXP', 'Reguläre Ausdrücke benutzen');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_USE_REGEXP_DESC', 'Gibt an, ob Perl-kompatible reguläre Ausdrücke (PCREs) für die Antworten verwendet werden sollen. Diese können dazu benutzt werden, mehrere Varianten einer Antwort zuzulassen. Jeder Antwortzeile sollte dabei dem Muster /pattern/:Antwort entsprechen. ACHTUNG: Aktiviere diese Option nur, wenn du weißt, was du tust. Ein ungültiger regulärer Ausdruck wird Validitäts-Prüfungen fehlschlagen lassen und könnte dein Blog in wenigen Fällen einer sogenannten Denial-of-Service-Attacke aussetzen. Antworten länger als 1000 Zeichen werden abgewiesen, wenn reguläre Ausdrücke eingeschaltet sind.');

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

@define('PLUGIN_SPAMBLOCK_BEE_TITLE', 'Spam Report');
@define('PLUGIN_SPAMBLOCK_BEE_DESC', 'Stellt eine Statistik dar über Kommentar Spam Einträge, wenn Deine AntiSpam Plugins in die spamblocklog Tabelle loggen.');
@define('PLUGIN_SPAMBLOCK_BEE_DAYS', 'Anzuzeigende Tage');
@define('PLUGIN_SPAMBLOCK_BEE_DAYS_DESC', 'Der Report wird für die letzten X Tage erstellt. Hier kannst Du mehrere Tage Komma separiert einstellen, für die jeweils ein Report dargestellt werden soll.');
@define('PLUGIN_SPAMBLOCK_BEE_DBSEARCHES', 'Datenbank Suchen');
@define('PLUGIN_SPAMBLOCK_BEE_DBSEARCHES_DESC', 'Dieses plugin durchsucht die spamblocklog Tabelle. Hier kannst Du Suchen für Deine AntiSpam Maßnamen einstellen, über die gezählt werden soll. In jede Zeile kommt eine Einstellung, Format ist DeinNameFürAntiSpamArt:DbSuche. Beispiel: "BayesPlugin:%Bayes%" wird alle Einträge zählen, die "Bayes" irgendwo in ihrem Titel haben und sie als "BayesPlugin" im Report darstellen.');
@define('PLUGIN_SPAMBLOCK_BEE_LOGGEDIN', 'Nur für eingeloggte Benutzer');
@define('PLUGIN_SPAMBLOCK_BEE_LOGGEDIN_DESC', 'Wenn Du dies anschaltest, dann können nur eingeloggte Benutzer des Blogs die Statistik in der Seitenleiste sehen.');
@define('PLUGIN_SPAMBLOCK_BEE_CACHEMINS', 'Reporting Cache');
@define('PLUGIN_SPAMBLOCK_BEE_CACHEMINS_DESC', 'Das Erzeugen des Reports erzeugt Last auf er Datenbank, deshalb sollte der Report gecache werden. Hier wird eingestellt, wie viele Minuten mindestens gewartet werden soll, bevor ein neuer Report erstellt wird.');
