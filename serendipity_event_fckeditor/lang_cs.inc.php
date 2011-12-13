<?php # lang_cs.inc.php 1.0 2009-05-25 22:20:33 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/25
 */

@define('PLUGIN_EVENT_FCKEDITOR_NAME',     'Použití FCKeditoru jako WYSIWYG editoru');
@define('PLUGIN_EVENT_FCKEDITOR_DESC',     'Používá FCKeditor jako WYSIWYG editor. Vyžaduje Serendipity 0.9 nebo vyšší. Po instalaci si pøeètìte instalaèního prùvodce na stránce s nastavením pluginu.');
@define('PLUGIN_EVENT_FCKEDITOR_INSTALL', '<br /><br /><strong>Instalaèní prùvodce:</strong><br />
<ul>
<li>Stáhnìte FCKeditor v2.1 nebo vyšší z http://www.fckeditor.net/</li>
<li>Rozbalte do podadresáøe "FCKeditor" v adresáøi ' . dirname(__FILE__) . '</li>
<li>Zadejte zde do nastavení pluginu relativní cestuk adresáøi "FCKeditor".</li>
<li>Vìtšinou je tato cesta "plugins/serendipity_event_fckeditor/fckeditor/"</li>
<li>Ujistìte se, že jste v Nastavení Serendipity povolili použití WYSIWYG editoru.</li>
</ul>');
@define('PLUGIN_EVENT_FCKEDITOR_CONFIG', '<br /><br /><strong>Prùvodce nastavením pluginu:</strong><br />
<ul>
<li>Pokud požadujete od editoru více funkcí, jako je napøíklad správce souborù nebo operace s tabulkami, pøepište konfiguraèní soubor fckconfig.js file v adresáøi fckeditor nìkterým pøiloženým.</li>
<ul>
	<li>pak jdìte na serendipity_event_fckeditor/fckeditor/editor/filemanager/browser/default/connectors/php/config.php</li>
	<li>a zmìòte nastavení následovnì $Config["Enabled"] = true; a $Config["UserFilesPath"] = "/uploads/";</li>
	<li>pak naleznìte serendipity_event_fckeditor/fckeditor/editor/filemanager/upload/php/config.php</li>
	<li>a zopakujte zmìnu parametrù nastavení</li>
</ul>
<li>V FCKeditoru jsou 3 rùzné šablony vzhledu - výchozí, office2003 a silver. Ty se dají nastavit v souboru fckconfig.js.</li>
	<ul><li>Jednoduše pøepište promìnnou FCKConfig.SkinPath = FCKConfig.BasePath + "skins/default/" ;. nahraïte office2003 nebo silver</li></ul>

</ul>');

?>
