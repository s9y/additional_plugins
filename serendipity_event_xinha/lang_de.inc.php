<?php # lang_de.inc.php 1.0 2009-08-20 10:17:17 VladaAjgl $

/**
 *  @version 1.0
 *  @author Konrad Bauckmeier <kontakt@dd4kids.de>
 *  @translated 2009/08/20
 */

@define('PLUGIN_EVENT_XINHA_NAME',     'Benutze XINHA als WYSIWYG-Editor ');
@define('PLUGIN_EVENT_XINHA_DESC',     'Warnung: XINHA ist experimentell! Es wird mindestens Serendipity Version 0.9 benötigt. Nach der Installation sollte die Installationsanleitung im Konfigurationsfenster dieses Plugins gelesen werden. Ab Version 1.4 ist XINHA standardmäßig in S9Y enthalten. Dieses Plugin wird dafür nicht mehr benötigt.');
@define('PLUGIN_EVENT_XINHA_INSTALL', '<br /><br /><strong>Installationsanleitung:</strong><br />
<ul>
<li>Laden Sie XINHA von <a href="http://xinha.python-hosting.com/">http://xinha.python-hosting.com/</a></li>
<li>Entpacken Sie es in ein "XINHA"-Verzeichnis unterhalb von ' . dirname(__FILE__) . '</li>
<li>Geben Sie den relativen HTTP-Pfad zu diesem "XINHA"-Verzeichnis in die Plugin-Konfiguration ein.</li>
<li>Für einige Installationen ist der relative Pfad "plugins/serendipity_event_xinha/xinha-nightly/"</li>
<li>Überprüfen Sie, dass WYSIWYG in den "Eigenen Einstellungen" eingeschaltet ist.</li>
</ul>');