<?php # 

/**
 *  @file UTF-8/lang_de.inc.php 1.4.2 2013-10-24 Ian
 *  @version 1.4.2
 *  @author Translator Name <yourmail@example.com>
 *  DE-Revision: Revision of lang_de.inc.php
 */

@define('PLUGIN_EVENT_CKEDITOR_NAME', 'CKEditor');
@define('PLUGIN_EVENT_CKEDITOR_DESC', 'Nutzt CKEditor als den Standard WYSIWYG Editor. Dieser ist zur Zeit der state-of-the-art Editor im Internet. Benutzung: Empfohlen! Nach der Installation, lies die Plugin Konfigurations Seite f�r weitere Informationen.');
@define('PLUGIN_EVENT_CKEDITOR_REVISION_TITLE', '<h3>Das Plugin enth�lt:</h3>');
@define('PLUGIN_EVENT_CKEDITOR_INSTALL', '<h2>Installation</h2>
<ol style="line-height: 1.6">
<li>Um anderen Plugins Zugriff auf das Plugin oder dessen Hook zu gew�hren, plaziere das (CKEditor) Plugin nahe dem Ende deiner Pluginliste.</li>
<li>Versichere dich, dass der WYSIWYG Modus in den "Pers�nlichen Einstellungen" eingeschaltet ist.</li>
</ol>

<h3>Manuelle Erweiterungen mit anderen CKEDITOR Plugins</h3>
<ol style="line-height: 1.6">
<li>Definiere manuell hinzugef�gte Plugins (analog zu <em>{ name: \'mediaembed\' },</em>) in der custom cke_config.js, in der <em>CKEDITOR.config.toolbarGroups = [...]</em> Definition.</li>
<li>Au�erdem f�ge den neuen Pluginnamen (analog zu mediaembed) der <em>var extraPluginList = \'...\'</em> Definition in der cke_plugin.js Datei hinzu.</li>
</ol>

<h3>Upgrading</h3>
<p>Dieses Plugin wird von Zeit zu Zeit selber Updates via Spartacus bereitstellen.<hr>
Wenn jemals ein manuelles oder pers�nliches Update des mitgelieferten CKEditor Paketes ben�tigt wird:
<ol style="line-height: 1.6">
<li><a href="http://ckeditor.com/download" target="_blank">Download CKEditor</a></li>
<li>Extrahiere nach: <em>' . realpath(dirname(__FILE__) . '/..') . '</em> (dies sollte das <em>"ckeditor"</em> Sub-Verzeichnis automatisch erstellen)</li>
</ol>
</p>');
@define('PLUGIN_EVENT_CKEDITOR_CONFIG', '');
@define('PLUGIN_EVENT_CKEDITOR_INSTALL_PLUGPATH', 'HTTP Pfad des S9y Plugins Verzeichnisses');
@define('PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION', 'Stelle Advanced-Content-Filter (ACF) ab?');
@define('PLUGIN_EVENT_CKEDITOR_TBLB_OPTION', 'Nutze den (default) 2-Zeiler toolbar-group Umbruch?');

@define('PLUGIN_EVENT_CKEDITOR_CODEBUTTON_OPTION', 'Nutze "code toolbar button"?');
@define('PLUGIN_EVENT_CKEDITOR_PRETTIFY_OPTION', 'Nutze "prettify code" im Frontend?');
@define('PLUGIN_EVENT_CKEDITOR_PRETTIFY_OPTION_BLAHBLAH', 'Erweitert "code toolbar button" Option, um lokal geladene prettify.js und prettify.ccs Dateien (code by Google) im Frontend.');
@define('PLUGIN_EVENT_CKEDITOR_OPTION_BLAHBLAH', 'Normalerweise: ');
