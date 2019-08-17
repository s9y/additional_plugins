<?php # 

/**
 *  @version 
 *  @author Thomas Hochstein <thh@inter.net>
 */

@define('PLUGIN_EVENT_CRONJOB_NAME', 'Cronjob-Planer');
@define('PLUGIN_EVENT_CRONJOB_DESC', 'Dieses Plugin führt andere Plugins, die regelmäßig bestimmte Aufgaben ausführen sollen, in bestimmten Zeitabständen aus. Einzelheiten finden Sie in der Konfiguration dieses Plugins.');
@define('PLUGIN_EVENT_CRONJOB_DETAILS', 'Dieses Plugin stellt neue Plugin-API-Hooks (cronjob_5min, cronjob_30min, cronjob_1h, cronjob_12h, cronjob_daily, cronjob_weekly, cronjob_monthly) bereit, die andere Plugins verwenden können. HINWEIS: Die Ausführung von Cronjobs erfordert Seitenabrufe; wenn niemand Ihre Seite besucht, können keine Cronjobs ausgeführt werden. Wenn Sie einen eigenen Server haben, der Cronjobs ausführen kann, sollten folgenden Eintrag zu ihrer Crontab hinzufügen: <br /><br />5 * * * wget http://yourblog/index.php?Serendipity[cronjob]=all<br /><br /> und hier im Plugin dann die Ausführung von besucherbasierten Cronjobs deaktivieren.');
@define('PLUGIN_EVENT_CRONJOB_VISITOR', 'Besucherbasierte Cronjobs?');
@define('PLUGIN_EVENT_CRONJOB_VISITOR_DESC', 'Wenn diese Option aktiviert ist, werden Cronjobs von Ihren Besuchern ausgeführt. Dazu wird ein unsichtbares Bild ausgegeben, das (durch Aufruf von index.php?Serendipity[cronjob]=true) die Cronjob-Funktionalität übernimmt. Für Benutzer, die keine benutzerdefinierten Cronjobs auf ihrem Server hinzufügen können, ist dies die einzige Möglichkeit, regelmäßige Ereignisse auf dem Webserver auszuführen. Sie sollten beachten, dass Cronjobs nur bei Seitenaufrufen ausgeführt werden und daher gewählte Zeitspanne zwischen Cronjobs nur einen Mindestwert angibt; es kann 3 Stunden dauern, bis der stündliche Cronjob ausgeführt wird, wenn erst nach 3 Stunden der erste Besucher kommt.');
@define('PLUGIN_EVENT_CRONJOB_LOG', 'Letzte Cronjob-Ereignisse');
@define('PLUGIN_EVENT_CRONJOB_CHOOSE', 'Wann ausführen?');
