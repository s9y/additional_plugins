<?php # 

/**
 *  @version 
 *  @author Thomas Hochstein <thh@inter.net>
 */

@define('PLUGIN_EVENT_FACEBOOK_NAME', 'Facebook (Experimentell!)');
@define('PLUGIN_EVENT_FACEBOOK_DESC', 'Importiert Kommentare von Facebook-Posts (vergleichbar RSS-Graffiti) zurück in den Blog. Bettet auch Facebook-OpenGraph-Meta-Tags in den Blog ein.');

@define('PLUGIN_EVENT_FACEBOOK_HOWTO', 'Kommentare werden in Blogeinträge importiert, indem die URL des Facebook-Links (der öffentlich sein muss!) mit dem Blogbeitrag verglichen wird. Für diese Suche wird der konfigurierte Hostname von Serendipity (baseURL) verwendet. Dieses Plugin kann über das Cronjob-Plugin oder über manuelle Cronjobs (d.h. wget) über index.php?/plugin/facebookcomments ausgeführt werden.');

@define('PLUGIN_EVENT_FACEBOOK_MODERATE', 'Sollten Facebook-Kommentare standardmäßig moderiert werden?');

@define('PLUGIN_EVENT_FACEBOOK_USERS', 'Facebook-Benutzername(n)');
@define('PLUGIN_EVENT_FACEBOOK_USERS_DESC', 'Geben Sie den Facebook-Benutzernamen oder die ID ein, der/die mit Ihrem Blog verbunden ist und abgerufen werden soll. Denken Sie daran, dass nur öffentliche Accounts/Storys/Kommentare über die Facebook-Graph-API abgerufen werden können. Mehrere Benutzernamen / IDs können durch "," getrennt werden.');

@define('PLUGIN_EVENT_FACEBOOK_VIA', 'Welchen Text zu Facebook-Kommentaren hinzufügen?');

@define('PLUGIN_EVENT_FACEBOOK_LIMIT', 'Wie viele Graph-API-Einträge abrufen?');
@define('PLUGIN_EVENT_FACEBOOK_LIMIT_DESC', 'Legt fest, wie viele Elemente die Facebook-API-Anfrage zurückgeben soll. Normalerweise sollten die letzten 25 Elemente ausreiche;, wenn Sie eine stark frequentierte Facebook-Pinnwand haben, möchten Sie möglicherweise das Limit erhöhen (oder häufiger einen Abruf ausführen). Je höher der Grenzwert, desto länger dauert die Überprüfung der Graph-API.');

@define('PLUGIN_AGGREGATOR_CRONJOB', 'Dieses Plugin unterstützt das Serendipity-Cronjob-Plugin. Installieren Sie es, wenn Sie eine zeitgesteuerte Ausführung wünschen.');
