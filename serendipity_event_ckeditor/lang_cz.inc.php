<?php # lang_cz.inc.php 1.0 2013-06-22 11:15:15 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2013/06/22
 */
@define('PLUGIN_EVENT_CKEDITOR_NAME', 'CKEditor');
@define('PLUGIN_EVENT_CKEDITOR_DESC', 'Pou¾ívá CKEditor jako výchozí WYSIWYG editor. Tento editor je aktuálním state-of-art. Pou¾ití: Doporuèeno! Po instalaci pøejdìte na stránku s nastavením tohoto pluginu a ètìte dal¹í instrukce.');
@define('PLUGIN_EVENT_CKEDITOR_INSTALL', '<h2>Instalace</h2>
<ol style="line-height: 1.6">
<li>V nastavení pluginu zadejte relativní HTTP cestu k adresáøi <em>"ckeditor"</em>.
    <div><strong>Poznámka:</strong> ve vìt¹inì instalací je tato cesta <em>"plugins/serendipity_event_ckeditor/ckeditor/"</em></div>
</li>
<li>V nastavení pluginu zadejte plnou HTTP cestu k serendipity adresáøi <em>"plugins"</em> (vèetnì ukonèujícího lomítka).
    <div><strong>Poznámka:</strong> ve vìt¹inì instalací je tato cesta <em>"' . $serendipity['serendipityHTTPPath'] . 'plugins/"</em></div>
</li>
<li>Abyste umo¾nili ostatním u¾ivatelùm pou¾ití CKEditoru, umístìte tento plugin (CKEditor) blízko konce seznamu pluginù.</li>
<li>Ujistìte se, ¾e máte v osobním nastavení zapnuto pou¾ití WYSIWYG módu.</li>
</ol>
<h3>Plugin obsahuje</h3>
<ul>
<li>CKEditor 4.1.2 (revize d6f1e0e, standardní balíèek, 2013-06-10)</li>
<li>KCFinder 2.52-dev (git package, 2013-05-04)</li>
</ul>

<h3>Aktualizace</h3>
<p>Tento plugin bude èas od èasu umo¾òovat aktualizace pomocí pluginu Spartacus.<hr>
Pokud vùbec nìkdy budete potøebovat ruènì aktualizovat dodané CKEditor balíèky na vlastní balíèky (*), pak prosím:
<ol style="line-height: 1.6">
<li><a href="http://ckeditor.com/download" target="_blank">stáhnìte CKEditor</a></li>
<li>Rozbalte jej do: <em>' . dirname(__FILE__) . '</em> (mìl by být vytvoøen podadresáø <em>"ckeditor"</em>)</li>
</ol>
(*) <em><strong>Poznámka:</strong> Toto vypnete (pøepí¹e) integraci KCFinderu pøidanou na konec souboru ckeditor/config.js: <a style="border:0; text-decoration: none;" href="#" onClick="showConfig(\'el1\'); return false" title="TOGGLE_OPTION"><img src="'.serendipity_getTemplateFile('img/plus.png').'" id="optionel1" alt="+/-" border="0">&nbsp;TOGGLE_OPTION</a></em>
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
@define('PLUGIN_EVENT_CKEDITOR_INSTALL_PLUGPATH', 'HTTP cesta do serendipity dresáøe s pluginy');
@define('PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION', 'Vypnout "Pokroèilé fitrlování obsahu" (tzv. ACF = Advanced-Content-Filter)');
@define('PLUGIN_EVENT_CKEDITOR_TBLB_OPTION', 'Pou¾ít výchozí dvouøádkové zobrazení nástrojové li¹ty');