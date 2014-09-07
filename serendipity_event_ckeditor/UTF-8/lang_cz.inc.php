<?php # lang_cz.inc.php 1.2 2013-10-26 13:46:03 VladaAjgl $

/**
 *  @version 1.2
 *  @file lang_cs.inc.php 1.1 2013-06-22 11:15:21 VladaAjgl
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2013/06/22
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/10/26
 */

@define('PLUGIN_EVENT_CKEDITOR_NAME', 'CKEditor');
@define('PLUGIN_EVENT_CKEDITOR_DESC', 'Používá CKEditor jako výchozí WYSIWYG editor. Tento editor je aktuálním state-of-art. Použití: Doporučeno! Po instalaci přejděte na stránku s nastavením tohoto pluginu a čtěte další instrukce.');
@define('PLUGIN_EVENT_CKEDITOR_INSTALL', '<h2>Instalace</h2>
<ol style="line-height: 1.6">
<li>V nastavení pluginu zadejte relativní HTTP cestu k adresáři <em>"ckeditor"</em>.
    <div><strong>Poznámka:</strong> ve většině instalací je tato cesta <em>"plugins/serendipity_event_ckeditor/ckeditor/"</em></div>
</li>
<li>V nastavení pluginu zadejte plnou HTTP cestu k serendipity adresáři <em>"plugins"</em> (včetně ukončujícího lomítka).
    <div><strong>Poznámka:</strong> ve většině instalací je tato cesta <em>"' . $serendipity['serendipityHTTPPath'] . 'plugins/"</em></div>
</li>
<li>Abyste umožnili ostatním uživatelům použití CKEditoru, umístěte tento plugin (CKEditor) blízko konce seznamu pluginů.</li>
<li>Ujistěte se, že máte v osobním nastavení zapnuto použití WYSIWYG módu.</li>
</ol>

<h3>Aktualizace</h3>
<p>Tento plugin bude čas od času umožňovat aktualizace pomocí pluginu Spartacus.<hr>
Pokud vůbec někdy budete potřebovat ručně aktualizovat dodané CKEditor balíčky na vlastní balíčky (*), pak prosím:
<ol style="line-height: 1.6">
<li><a href="http://ckeditor.com/download" target="_blank">stáhněte CKEditor</a></li>
<li>Rozbalte jej do: <em>' . dirname(__FILE__) . '</em> (měl by být vytvořen podadresář <em>"ckeditor"</em>)</li>
</ol>
</p>');
@define('PLUGIN_EVENT_CKEDITOR_CONFIG', '');
@define('PLUGIN_EVENT_CKEDITOR_INSTALL_PLUGPATH', 'HTTP cesta do serendipity dresáře s pluginy');
@define('PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION', 'Vypnout "Pokročilé fitrlování obsahu" (tzv. ACF = Advanced-Content-Filter)');
@define('PLUGIN_EVENT_CKEDITOR_TBLB_OPTION', 'Použít výchozí dvouřádkové zobrazení nástrojové lišty');

// Next lines were translated on 2013/10/26
@define('PLUGIN_EVENT_CKEDITOR_REVISION_TITLE', '<h3>Tento plugin zahrnuje:</h3>');