<?php

/**
 *  @version 1.2
 *  @file lang_cs.inc.php 1.1 2013-06-22 11:15:21 VladaAjgl
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2013/06/22
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/10/26
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

<h3>Aktualizace</h3>
<p>Tento plugin bude èas od èasu umo¾òovat aktualizace pomocí pluginu Spartacus.<hr>
Pokud vùbec nìkdy budete potøebovat ruènì aktualizovat dodané CKEditor balíèky na vlastní balíèky (*), pak prosím:
<ol style="line-height: 1.6">
<li><a href="http://ckeditor.com/download" target="_blank">stáhnìte CKEditor</a></li>
<li>Rozbalte jej do: <em>' . dirname(__FILE__) . '</em> (mìl by být vytvoøen podadresáø <em>"ckeditor"</em>)</li>
</ol>
</p>');
@define('PLUGIN_EVENT_CKEDITOR_CONFIG', '');
@define('PLUGIN_EVENT_CKEDITOR_INSTALL_PLUGPATH', 'HTTP cesta do serendipity dresáøe s pluginy');
@define('PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION', 'Vypnout "Pokroèilé fitrlování obsahu" (tzv. ACF = Advanced-Content-Filter)');
@define('PLUGIN_EVENT_CKEDITOR_TBLB_OPTION', 'Pou¾ít výchozí dvouøádkové zobrazení nástrojové li¹ty');

// Next lines were translated on 2013/10/26
@define('PLUGIN_EVENT_CKEDITOR_REVISION_TITLE', '<h3>Tento plugin zahrnuje:</h3>');