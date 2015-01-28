<?php

/**
 *  @file UTF-8/lang_de.inc.php 1.4.11 2014-11-26 Ian
 *  @version 1.4.11
 *  @author Translator Name <yourmail@example.com>
 *  DE-Revision: Revision of UTF-8/lang_de.inc.php
 */

@define('PLUGIN_EVENT_CKEDITOR_NAME', 'CKEditor');
@define('PLUGIN_EVENT_CKEDITOR_DESC', 'Nutzt CKEditor als Standard WYSIWYG Editor. Benutzung für JS-Editoren: Empfohlen! Nach der Installation, lies die Plugin Konfigurations Seite für weitere Informationen.');
@define('PLUGIN_EVENT_CKEDITOR_REVISION_TITLE', '<h3>Das Plugin enthält:</h3>');
@define('PLUGIN_EVENT_CKEDITOR_INSTALL', '<h2>Installation</h2>
<p class="msg_notice">
    <span class="icon-attention"></span> <strong>Abhängigkeiten:</strong> Deaktiviere body, extended und nugget parsing global im <strong>NL2BR</strong> Plugin, <strong>oder</strong> per entry über das entryproperties event plugin <strong>und/oder</strong> für statische Seiten über die Entry "Textformatierungs" Option!
</p>
<ol style="line-height: 1.6">
    <li>Um anderen Plugins Zugriff auf das Plugin oder dessen Hook zu gewähren, plaziere das (CKEditor) Plugin nahe dem Ende deiner Pluginliste.</li>
    <li>Versichere dich, dass der WYSIWYG Modus in den "Eigenen Einstellungen" eingeschaltet ist.</li>
</ol>
<div class="cke_config_block msg_dialogue">
    <h3>Manuelle Erweiterungen mit anderen CKEDITOR Plugins</h3>
    <ol style="line-height: 1.6">
        <li>Definiere manuell hinzugefügte Plugins (analog zu <em>{ name: \'mediaembed\' },</em>) in der custom cke_config.js, in der <em>CKEDITOR.config.toolbarGroups = [...]</em> Definition.</li>
        <li>Außerdem füge den neuen Pluginnamen (analog zu mediaembed) der <em>var extraPluginList = \'...\'</em> Definition in der cke_plugin.js Datei hinzu.</li>
    </ol>

    <h3>Upgrading</h3>
    <p>Dieses Plugin wird zeitnah selber Updates via Spartacus bereitstellen.</p>
    <p>Es ist nicht zu raten, ein eigenes customized CKEDITOR release zu erstellen und herunterzuladen, da dies zu unerwünschten Nebenwirkungen in der Einbindung führt.</p>
</div>');
@define('PLUGIN_EVENT_CKEDITOR_CONFIG', '');
@define('PLUGIN_EVENT_CKEDITOR_INSTALL_PLUGPATH', 'HTTP Pfad des S9y Plugins Verzeichnisses');
@define('PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION', 'Stelle Advanced-Content-Filter (ACF) ab?');
@define('PLUGIN_EVENT_CKEDITOR_TOOLBAR_OPTION', 'Nutze den (default) 2-Zeiler toolbar-group Umbruch?');

@define('PLUGIN_EVENT_CKEDITOR_CODEBUTTON_OPTION', 'Nutze "code toolbar button"?');
@define('PLUGIN_EVENT_CKEDITOR_PRETTIFY_OPTION', 'Nutze zusätzliches code prettify css/js im Frontend?');
@define('PLUGIN_EVENT_CKEDITOR_PRETTIFY_OPTION_DESC', 'Nur für Upgrader! Rückwärtskompatibilität für alte Blog Einträge mit Code-Blöcken.');
@define('PLUGIN_EVENT_CKEDITOR_OPTION_DESC', 'Normalerweise: ');

@define('PLUGIN_EVENT_CKEDITOR_FORCEINSTALL_OPTION', 'Entpacke Zip Datei (im Notfall)');
@define('PLUGIN_EVENT_CKEDITOR_FORCEINSTALL_OPTION_DESC', 'Nur bei upgrade Fehlern: Entpacke augenblicklich das mitgelieferte ');

@define('PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION_DESC', 'Dieser CKEDITOR "Housekeeper" Filter erlaubt nur bestimmtes Markup. Normalerweise ist dies gut und sollte als Einstellung erhalten bleiben, da es bereits eingebaute Workarounds für auffälliges Markup, zB. "iframe" Video-Media via den "Embed Media"-Knopf, oder "audio" und "andere Serendipity" tags via "Quellcode"-Anzeige, gibt. Bitte lese dazu auch: "http://docs.ckeditor.com/?_escaped_fragment_=/guide/dev_advanced_content_filter#!/guide/dev_advanced_content_filter".');

@define('PLUGIN_EVENT_CKEDITOR_SETTOOLBAR_OPTION', 'Wähle voreingestellte Toolbars');

@define('PLUGIN_EVENT_CKEDITOR_CKEIBN_OPTION', 'Stelle den eingebauen Bildbutton ab?');
@define('PLUGIN_EVENT_CKEDITOR_CKEIBN_OPTION_DESC', 'Dieser CKE eigene Toolbar Button folgt seinen eigenen Regeln für Stylings und Markup! Wir empfehlen daher nur den Serendipity Medien Datenbank Button zu nutzen, da dieser spezialisiert auf die Nöte dieses Blogsystem eingeht. Erlaube mit "Nein" und nutze auf eigenes Risiko.');

