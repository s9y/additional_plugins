<?php # 

/**
 *  @version 
 *  @author Translator Andy Blank <andy.blank@gmx.net>
 *  DE-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_RECAPTCHA_TITLE', 'Recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_DESC', 'Recaptcha für die Kommentar-Funktion von Artikeln aktivieren (Sie müssen einen Schlüssel anfordern)');

@define('PLUGIN_EVENT_RECAPTCHA_HIDE', 'Recaptchas für Autoren deaktieren');
@define('PLUGIN_EVENT_RECAPTCHA_HIDE_DESC', 'Autoren der folgenden Benutzergruppen soll es erlaubt sein, Kommentare zu veröffentlichen, ohne ein Recaptcha einzugeben.');


@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA', 'Recaptcha aktivieren');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_DESC', 'Wenn diese Funktion aktiviert ist, wird ein Recaptcha generiert. Diese spezielle Art von Capchas helfen Bücher zu digitalisieren. Weitere Informationen finden Sie unter http://www.recaptcha.net. Statt der Eingabe der angezeigten Buchstaben, kann sich der Benutzer auch alternativ eine Nachricht anhören, und die gehörten Nummern eigeben. Wenn kein Captcha geniert wird, kann es sein das der Recapcha-Server nicht erreichbar ist.');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_STYLE', 'Stil der Recapchas welcher genutzt wird');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_STYLE_DESC', 'Rot, weiss oder schwarz-glasig. Dies funktioniert nur, wenn Javascirpt aktiviert ist.');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PUB', 'Geben Sie den öffentlicher Schlüssel für Recaptcha ein');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PUB_DESC', 'Öffentliches Schlüsselpar für die Kommunikation mit dem recaptcha.net Server. Ein öffentliches/privates Schlüsselpaar kann unter http://www.recaptcha.net/api/getkey angefordert werden.');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PRIV', 'Geben Sie den privaten Schlüssel für Recaptcha ein');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PRIV_DESC', 'Privates Schlüsselpar für die Kommunikation mit derm recaptcha.net Server. Ein öffentliches/privates Schlüsselpaar kann unter http://www.recaptcha.net/api/getkey angefordert werden.');

@define('PLUGIN_EVENT_RECAPTCHA_CAPTCHAS_TTL', 'Anzahl Tage nach der die Eingabe von Recaptchas erzwungen wird');
@define('PLUGIN_EVENT_RECAPTCHA_CAPTCHAS_TTL_DESC', 'Recaptchas können abhängig vom Alter des Artikels erzwungen werden. Hier kann die Anzahl der Tage eingegeben werden, nach der die korrekte Eingabe eines Recaptchas notwendig wird. Ist dieser Wert 0, werden Recaptchas immer angezeigt.');


@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE', 'Wählen Sie die Log-Methode');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_DESC', 'Das loggen von zurückgewiesenen Kommentaren kann mittels Datenbank oder (Text)Datei realisiert werden');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_FILE', 'Datei (siehe Logdatei)');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_DB', 'Datenbank');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_NONE', 'Kein Loggen');

@define('PLUGIN_EVENT_RECAPTCHA_LOGFILE', 'Speicherort der Logdatei');
@define('PLUGIN_EVENT_RECAPTCHA_LOGFILE_DESC', 'Informationen über zurückgewiesene/moderierte Kommentare können in eine Logdatei geschrieben werden. Um das Loggen zu deaktivieren, kann für diesen Wert eine leere Zeichenkette eingegeben werden.');

@define('PLUGIN_EVENT_RECAPTCHA_ERROR_CAPTCHAS', 'Sie haben keine gültige Zeichenkette in die Spam-Schutz Box eingegeben. Bitten betrachten Sie das angezeigte Bild an und geben Sie die entsprechenden Werte ein.');
@define('PLUGIN_EVENT_RECAPTCHA_ERROR_RECAPTCHA', 'Sie haben keinen öffentlichen/privaten Schlüssel in der Recapcha-Konfiguration eingegeben. Es werden keine  Recaptchas verwendet. Wenn Sie Recaptchas nutzen wollen, geben Sie bitte die entsprechenden Schlüssel im Konfigurations-Bereich des Recaptcha-Plugins ein oder verwenden Sie die herkömlichen Captchas.');

@define('PLUGIN_EVENT_RECAPTCHA_INFO1', 'Ein Recaptcha ist eine spezielle Art von  <a href="http://de.wikipedia.com/wiki/Captcha">Captcha</a>. Der Benutzer muss zwei Worte erkennen: Eines um Spam zu verhindern, dass andere um die Digitalisierung von Büchern zu unterstützen. Sehbehinderte Menschen können sich auch ein akustisches Recaptcha anhören. Weitere Informationen finden Sie unter <a href="http://www.recaptcha.net">www.recaptcha.net</a>.<br/>Bitte beachten Sie, wenn sie Recaptcha nutzen wollen, dass Sie sich bei der genannten Webseite registrieren müssen. Einen Schlüssel können Sie <a href="http://www.recaptcha.net/api/getkey?app=serendipity&domain=');
@define('PLUGIN_EVENT_RECAPTCHA_INFO2', '">hier</a> anfordern. <br/> Bitte beachten Sie auch, dass dieses Plugin jedes mal Anfragen an den recaptcha.net Server sendet. Dies kann den Ladevorgang der Artikel verlangsamen. Wenn ein Timeout auftritt, wird kein Recaptcha angezeigt');

