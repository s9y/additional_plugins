<?php # $Id$

/**
* @version $Revision$
* @author Translator Name <yourmail@example.com>
* EN-Revision: Revision of lang_en.inc.php
*/

@define('PLUGIN_EVENT_CKEDITOR_NAME', 'CKEditor');
@define('PLUGIN_EVENT_CKEDITOR_DESC', 'Nutzt CKEditor als den Standard WYSIWYG Editor. Dieser ist zur Zeit der state-of-the-art Editor im Internet. Benutzung: Empfohlen! Nach der Installation, lies die Plugin Konfigurations Seite für weitere Informationen.');
@define('PLUGIN_EVENT_CKEDITOR_REVISION_TITLE', '<h3>Das Plugin enthält:</h3>');
@define('PLUGIN_EVENT_CKEDITOR_INSTALL', '<h2>Installation</h2>
<ol style="line-height: 1.6">
<li>Gebe den relativen HTTP Pfad des <em>"ckeditor"</em> Verzeichnisses in die Plugin Konfiguration ein.
    <div><strong>Note:</strong> bei den allermeisten Installationen, ist dieser Pfad <em>"plugins/serendipity_event_ckeditor/ckeditor/"</em></div>
</li>
<li>Gebe den vollen HTTP Pfad des S9y <em>"plugins"</em> Verzeichnisses (mit endendem "/" slash) in die Plugin Konfiguration ein.
    <div><strong>Note:</strong> bei den allermeisten Installationen, ist dieser Pfad <em>"' . $serendipity['serendipityHTTPPath'] . 'plugins/"</em></div>
</li>
<li>Um anderen Plugins Zugriff auf das Plugin oder dessen Hook zu gewähren, plaziere das (CKEditor) Plugin nahe dem Ende deiner Pluginliste.</li>
<li>Versichere dich, dass der WYSIWYG Modus in den "Persönlichen Einstellungen" eingeschaltet ist.</li>
</ol>

<h3>Manuelle Erweiterungen mit CKEDITOR Plugins</h3>
<ol style="line-height: 1.6">
<li>Definiere manuell hinzugefügte Plugins (analog zu { name: \'mediaembed\' },) in ckeditor/config.js, in die <em>CKEDITOR.config.toolbarGroups = [...]</em> Definition in der serendipity_event_ckeditor.php Datei.</li>
<li>Außerdem füge den neuen Pluginnamen (analog zu mediaembed) zu beiden Vorkommen der <em>CKEDITOR.config.extraPlugins = \'...,...\'</em> Definitionen in der serendipity_event_ckeditor.php Datei hinzu.</li>
</ol>

<h3>Upgrading</h3>
<p>Dieses Plugin wird von Zeit zu Zeit selber Updates via Spartacus bereitstellen.<hr>
Wenn jemals ein manuelles oder persönliches Update des mitgelieferten CKEditor Paketes benötigt wird (*), bitte:
<ol style="line-height: 1.6">
<li><a href="http://ckeditor.com/download" target="_blank">Download CKEditor</a></li>
<li>Extrahiere in: <em>' . dirname(__FILE__) . '</em> (dies sollte das <em>"ckeditor"</em> Sub-Verzeichnis automatisch erstellen)</li>
</ol>
(*) <em><strong>Note:</strong> Dies wird die KCFinder\'s Integration überschreiben, die am unteren Ende der ckeditor/config.js Datei zu finden ist: <a style="border:0; text-decoration: none;" href="#" onClick="showConfig(\'el1\'); return false" title="auf-/einklappen"><img src="'.serendipity_getTemplateFile('img/plus.png').'" id="optionel1" alt="+/-" border="0">&nbsp;auf-/einklappen</a></em>
<div id="el1" style="margin-top: 0.5em; border: 1px solid #BBB;background-color: #EEE; padding: 0.5em">
<pre>
/* KCFinder integration - 2013-05-04 */
CKEDITOR.editorConfig = function(config) {
   config.filebrowserBrowseUrl = CKEDITOR_BASEPATH + \'../kcfinder/browse.php?type=files\';
   config.filebrowserImageBrowseUrl = CKEDITOR_BASEPATH + \'../kcfinder/browse.php?type=images\';
   config.filebrowserFlashBrowseUrl = CKEDITOR_BASEPATH + \'../kcfinder/browse.php?type=flash\';
   config.filebrowserUploadUrl = CKEDITOR_BASEPATH + \'../kcfinder/upload.php?type=files\';
   config.filebrowserImageUploadUrl = CKEDITOR_BASEPATH + \'../kcfinder/upload.php?type=images\';
   config.filebrowserFlashUploadUrl = CKEDITOR_BASEPATH + \'../kcfinder/upload.php?type=flash\';
};
</pre>
</div><script type="text/javascript" language="JavaScript">document.getElementById("el1").style.display = "none";</script>
</p>');
@define('PLUGIN_EVENT_CKEDITOR_CONFIG', '');
@define('PLUGIN_EVENT_CKEDITOR_INSTALL_PLUGPATH', 'HTTP Pfad des S9y Plugins Verzeichnisses');
@define('PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION', 'Stelle Advanced-Content-Filter (ACF) ab');
@define('PLUGIN_EVENT_CKEDITOR_TBLB_OPTION', 'Nutze den (default) 2-Zeiler toolbar-group Umbruch');

?>