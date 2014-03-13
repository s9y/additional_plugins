<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/22
 */

@define('PLUGIN_EVENT_XINHA_NAME',     'Pou¾ít XINHA jako WYSIWYG editor');
@define('PLUGIN_EVENT_XINHA_DESC',     'Pozor! Xinha je experimentální! Pou¾ívá XINHA WYSIWYG editor. Vy¾aduje Serendipity 0.9 nebo vy¹¹í. Po nainstalování pluginu si pøeètìte prùvodce instalací na konfiguraèní stránce pluginu.');
@define('PLUGIN_EVENT_XINHA_INSTALL', '<br /><br /><strong>Prùvodce instalací:</strong><br />
<ul>
<li>Stáhnìte editor XINHA z http://trac.xinha.org/wiki/DownloadsPage</li>
<li>Rozbalte editor "xinha-nightly" v adresáøi ' . dirname(__FILE__) . '</li>
<li>Zadejte v konfiguraèní stránce tohoto pluginu relativní HTTP cestu k adresáøi, do kterého ulo¾íte editor "xinha-nightly".</li>
<li>Relativní cesta mù¾e být napø. "plugins/serendipity_event_xinha/xinha-nightly/"</li>
<li>Ujistìte se, ¾e jste v nastavení Serendipity za¹krtli pou¾ívání WYSIWYG editorù.</li>
</ul>');

?>
