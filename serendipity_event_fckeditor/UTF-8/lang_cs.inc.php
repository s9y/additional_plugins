<?php # lang_cs.inc.php 1.0 2009-05-25 22:20:33 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/25
 */

@define('PLUGIN_EVENT_FCKEDITOR_NAME',     'Použití FCKeditoru jako WYSIWYG editoru');
@define('PLUGIN_EVENT_FCKEDITOR_DESC',     'Používá FCKeditor jako WYSIWYG editor. Vyžaduje Serendipity 0.9 nebo vyšší. Po instalaci si přečtěte instalačního průvodce na stránce s nastavením pluginu.');
@define('PLUGIN_EVENT_FCKEDITOR_INSTALL', '<br /><br /><strong>Instalační průvodce:</strong><br />
<ul>
<li>Stáhněte FCKeditor v2.1 nebo vyšší z http://www.fckeditor.net/</li>
<li>Rozbalte do podadresáře "FCKeditor" v adresáři ' . dirname(__FILE__) . '</li>
<li>Zadejte zde do nastavení pluginu relativní cestuk adresáři "FCKeditor".</li>
<li>Většinou je tato cesta "plugins/serendipity_event_fckeditor/fckeditor/"</li>
<li>Ujistěte se, že jste v Nastavení Serendipity povolili použití WYSIWYG editoru.</li>
</ul>');
@define('PLUGIN_EVENT_FCKEDITOR_CONFIG', '<br /><br /><strong>Průvodce nastavením pluginu:</strong><br />
<ul>
<li>Pokud požadujete od editoru více funkcí, jako je například správce souborů nebo operace s tabulkami, přepište konfigurační soubor fckconfig.js file v adresáři fckeditor některým přiloženým.</li>
<ul>
	<li>pak jděte na serendipity_event_fckeditor/fckeditor/editor/filemanager/browser/default/connectors/php/config.php</li>
	<li>a změňte nastavení následovně $Config["Enabled"] = true; a $Config["UserFilesPath"] = "/uploads/";</li>
	<li>pak nalezněte serendipity_event_fckeditor/fckeditor/editor/filemanager/upload/php/config.php</li>
	<li>a zopakujte změnu parametrů nastavení</li>
</ul>
<li>V FCKeditoru jsou 3 různé šablony vzhledu - výchozí, office2003 a silver. Ty se dají nastavit v souboru fckconfig.js.</li>
	<ul><li>Jednoduše přepište proměnnou FCKConfig.SkinPath = FCKConfig.BasePath + "skins/default/" ;. nahraďte office2003 nebo silver</li></ul>

</ul>');

?>
