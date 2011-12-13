<?php # lang_cs.inc.php 1.0 2009-05-22 19:59:33 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/22
 */

@define('PLUGIN_EVENT_XINHA_NAME',     'Použít XINHA jako WYSIWYG editor');
@define('PLUGIN_EVENT_XINHA_DESC',     'Pozor! Xinha je experimentální! Používá XINHA WYSIWYG editor. Vyžaduje Serendipity 0.9 nebo vyšší. Po nainstalování pluginu si pøeètìte prùvodce instalací na konfiguraèní stránce pluginu.');
@define('PLUGIN_EVENT_XINHA_INSTALL', '<br /><br /><strong>Prùvodce instalací:</strong><br />
<ul>
<li>Stáhnìte editor XINHA z http://xinha.python-hosting.com/</li>
<li>Rozbalte editor "XINHA" v adresáøi ' . dirname(__FILE__) . '</li>
<li>Zadejte v konfiguraèní stránce tohoto pluginu relativní HTTP cestu k adresáøi, do kterého uložíte editor "XINHA".</li>
<li>Relativní cesta mùže být napø. "plugins/serendipity_event_xinha/xinha-nightly/"</li>
<li>Ujistìte se, že jste v nastavení Serendipity zaškrtli používání WYSIWYG editorù.</li>
</ul>');

?>
