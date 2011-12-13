<?php # lang_de.inc.php 1.0 2009-08-20 10:08:32 VladaAjgl $

/**
 *  @version 1.0
 *  @author Konrad Bauckmeier <kontakt@dd4kids.de>
 *  @translated 2009/08/20
 */
        @define('PLUGIN_EVENT_CACHESIMPLE_NAME',     'Einfache Cached/Pregenerated Seiten');
        @define('PLUGIN_EVENT_CACHESIMPLE_DESC',     '[EXPERIMENTELL] Ermöglicht es, vollständige Seiten zu cachen. Hinweis: Zerstört so ziemlich alle dynamischen Optionen des Frontends und arbeitet höchstvermutlich nicht gut mit dynamischen Plugins zusammen. Dafür ist es schnell, wenn man nicht auf Echtzeit-Dynamik angewiesen ist. (Dieses Plugin sollte also so früh wie möglich in der Event-Plugin-Liste positioniert werden. Nur Dynamische Plugins wie Karmavoting sollten vor diesem Plugin ausgeführt werden.)');

// Next lines were translated on 2009/08/20
@define('PLUGIN_EVENT_CACHESIMPLE_BROWSER',     'Benutze getrennte IE/Mozilla Caches');
@define('PLUGIN_EVENT_CACHESIMPLE_KEEPFRESH',     'Zwinge Clients zum Neuabruf');
@define('PLUGIN_EVENT_CACHESIMPLE_KEEPFRESH_DESC',     'Indem kein "Expires- Header gesedet wird, werden Clients angewiesen, die Webseite nicht lokal zwischenzuspeichern. Dadurch ist der Client gezwungen, die Seite bei jedem Aufruf neu abzurufen. Dies verhindert Probleme, wenn Kommentare nach dem Absenden nicht auftauchen, aber resultiert in geringeren Zugriffszeiten. (Einige Clients nutzen zusätzlich interne Gültigkeitsprüfungen, um das Übertragungsvolumen zu minimieren.) ');