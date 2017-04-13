<?php # 

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  DE-Revision: Revision of lang_de.inc.php
 */

@define('PLUGIN_EVENT_TINYMCE_NAME',            'TinyMCE als WYSIWYG Editor benutzen');
@define('PLUGIN_EVENT_TINYMCE_DESC',            'Es wird Serendipity ab Version 0.9 benötigt. Bitte lesen Sie nach der Installation die weitere Installationsbeschreibung in der Plugin Konfiguration.');
@define('PLUGIN_EVENT_TINYMCE_ARTICLE_ONLY',    'Nur in Artikeln');
@define('PLUGIN_EVENT_TINYMCE_ARTICLE_ONLY_DESC','Wenn angeschaltet, dann wrd TinyMCE nur in Artikeln als Editor verwendet, nicht z.B. in Plugins.');
@define('PLUGIN_EVENT_TINYMCE_IMANAGER',        'iManager Tool benutzen?');
@define('PLUGIN_EVENT_TINYMCE_IMANAGER_DESC',   'iManager ist eine umfangreiche Erweiterung für die Medienverwaltung in TinyMCE. Es benötigt die GD Bibliotheken. Auf http://www.j-cons.com/ können Sie mehr über das Tool und seine Installation lesen.');
@define('PLUGIN_EVENT_TINYMCE_PLUGINS',         'Zusätzliche TinyMCE Plugins');
@define('PLUGIN_EVENT_TINYMCE_PLUGINS_DESC',    'Hier müssen die Namen der Verzeichnisse (innerhalb des TinyMCE plugin Verzeichnisses) der Plugins eingetragen werden, die in TinyMCE geladen werden sollen. Bitte lesen Sie auch die Dokumentationen der entsprechenden Plugins in den Unterverzeichnissen. Welche Plugins mit TinyMCE ausgeliefert wurden, können Sie hier nachlesen: http://wiki.moxiecode.com/index.php/TinyMCE:Plugins');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS1',        'Knopfleiste 1');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS1_DESC',   'Definieren Sie hier die Knöpfe, die sie in der 1. Leiste sehen wollen. Ein Leerzeichen definiert eine leere Leiste, wenn sie die Eingabe leer lassen, wird sie wieder mit den Plugin Defaults geladen. Welche Knöpfe aktuell von TinyMCE unterstützt werden, können Sie hier nachlesen: http://wiki.moxiecode.com/index.php/TinyMCE:Control_reference');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS2',        'Knopfleiste 2');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS2_DESC',   'Definieren Sie hier die Knöpfe, die sie in der 2. Leiste sehen wollen.');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS3',        'Knopfleiste 3');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS3_DESC',   'Definieren Sie hier die Knöpfe, die sie in der 3. Leiste sehen wollen.');
@define('PLUGIN_EVENT_TINYMCE_SPELLING',        'Mozilla Rechtschreibhilfe');
@define('PLUGIN_EVENT_TINYMCE_SPELLING_DESC',   'TinyMCE erlaubt, die Rechtschreibhilfe des Firefox in den Editor einzubinden.');
@define('PLUGIN_EVENT_TINYMCE_RELURLS',         'Relative URLs erzeugen');
@define('PLUGIN_EVENT_TINYMCE_RELURLS_DESC',    'TinyMCE kann lokale URLs in relative URLs konvertieren. Aus "http://deinblog.de/test.html" wird dann "/test.html". Die relativen URLs sind z.B. wichtig, falls sich die Blog Domain einmal ändern sollten, können aber evtl. in machen Blogs Probleme bereiten.');
@define('PLUGIN_EVENT_TINYMCE_VFYHTML',         'HTML verifizieren / korrigieren');
@define('PLUGIN_EVENT_TINYMCE_VFYHTML_DESC',    'TinyMCE überprüft normaler Weise den Code eines Artikels auf korrektes HTML. Dabei löscht er Tags, die ihm nicht als HMTL erscheinen. So verschwindet z.B. gerne YouTube Code nach dem Speichern des Artikels. Hier kann diese Korrektur ausgeschaltet werden.');
@define('PLUGIN_EVENT_TINYMCE_CLEANUP',         'Code säubern');
@define('PLUGIN_EVENT_TINYMCE_CLEANUP_DESC',    'TinyMCE säubert beim laden und speichern von Artikeln den Code. Wird diese Fähigkeit abgeschaltet, so bleibt der HMTL Code von TinyMCE unangetastet, allerdings müssen Sie dann selbst dafür sorgen. dass ihr Code funktioniert. Die Option [' . PLUGIN_EVENT_TINYMCE_VFYHTML . '] abzuschalten ist in den meisten Fällen die bessere Lösung.');
@define('PLUGIN_EVENT_TINYMCE_HTTPREL',         'Relativer HTTP Pfad des Plugins');
@define('PLUGIN_EVENT_TINYMCE_HTTPREL_DESC',    'Hier können Sie angeben, wie ihr relativer Pfad zu dem Plugin bezogen auf die Basis Adresse lautet. Wenn Sie die Permalink Struktur für Plugins nicht geändert haben und wenn ihr Blog nicht in einem Unterverzeichnis installiert ist, können Sie die Vorgabe so belassen.');
@define('PLUGIN_EVENT_TINYMCE_INSTALL',         '<br /><br /><strong>Installations Anweisungen:</strong><br />
<ul>
<li>Bitte <a href="http://tinymce.moxiecode.com/download.php" target="_blank">laden Sie TinyMCE und den TinyMCE Compressor</a> (Nur ab TinyMCE 2.0) von der Webseite .</li>
<li><b>TinyMCE</b>: Entpacken Sie das Verzeichnis "tinymce" in dem Archiv in das Pluginverzeichnis serendipity_event_tinymce.</li>
<li><b>TinyMCE compressor</b>: Entpacken Sie den Inhalt in das Verzeichnis "tinymce/jscripts/tiny_mce/" unterhalb des Pluginverzeichnisses serendipity_event_tinymce (Nur ab TinyMCE 2.0).</li>
<li>Da sie die deutsche Sprache verwenden, müssen Sie diese in TinyMCE installieren, da diese nicht mit TinyMCE ausgeliefert wird:
<ul>
<li><a href="http://tinymce.moxiecode.com/language.php" target="_blank">Weitere Sprachen können Sie hier herunter laden</a></li>
<li>Entpacken Sie das Spracharchiv und kopieren Sie die entstandene Verzeichnisstruktur in das tinymce Verzeichnis unterhalb des Pluginverzeichnisses.</li>
</ul>
</li>
<li>Optional können Sie noch den iManger laden und installieren (PHP GD Support wird benötigt):
<ul>
<li>Entpacken Sie den iManager in das Verzeichnis "tinymce/jscripts/tiny_mce/plugins/imanager"</li>
<li>Editieren Sie die Datei "tinymce/jscripts/tiny_mce/plugins/imanager/config/config.inc.php"</li>
<li>Passen Sie die Werte für $cfg["ilibs"] und $cfg["ilibs_dir"] an. Tragen Sie hier ihren relativen HTTP Pfad zum Serendipity Upload Verzeichnis ein: "' . $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . '"</li>
<li>Stellen Sie sicher, dass die Verzeichnisse imanager/scripts/phpThumb/cache und imanager/temp ausreichend konfigurierte Rechte besitzen (777)</li>
</ul>
</li>
<li>Geben Sie den relativen HTTP Pfad zu dem Plugin Verzeichnis in der Konfiguration an.</li>
<li>Stellen Sie sicher, dass in Ihren persönlichen Einstellungen das Benutzen des WYSIWYG Editors eingeschaltet ist.</li>
</ul>');

?>
