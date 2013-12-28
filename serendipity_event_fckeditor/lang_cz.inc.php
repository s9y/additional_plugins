<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/25
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/06/22
 */

@define('PLUGIN_EVENT_FCKEDITOR_NAME',     'Pou¾ití FCKeditoru jako WYSIWYG editoru');
/* temporary diabled as changed in <en> lang file. Sorry Vladi!
@define('PLUGIN_EVENT_FCKEDITOR_DESC',     'Pou¾ívá FCKeditor jako WYSIWYG editor. Vy¾aduje Serendipity 0.9 nebo vy¹¹í. Po instalaci si pøeètìte instalaèního prùvodce na stránce s nastavením pluginu.');
@define('PLUGIN_EVENT_FCKEDITOR_INSTALL', '<br /><br /><strong>Instalaèní prùvodce:</strong><br />
<ul>
<li>Stáhnìte FCKeditor v2.6.10+ nebo vy¹¹í z http://sourceforge.net/projects/fckeditor/</li>
<li>Rozbalte do podadresáøe "FCKeditor" v adresáøi ' . dirname(__FILE__) . '</li>
<li>Zadejte zde do nastavení pluginu relativní cestuk adresáøi "FCKeditor".</li>
<li>Vìt¹inou je tato cesta "plugins/serendipity_event_fckeditor/fckeditor/"</li>
<li>Ujistìte se, ¾e jste v Nastavení Serendipity povolili pou¾ití WYSIWYG editoru.</li>
</ul>');
@define('PLUGIN_EVENT_FCKEDITOR_CONFIG', '<br /><br /><strong>Prùvodce nastavením pluginu:</strong><br />
<ul>
<li>Pokud po¾adujete od editoru více funkcí, jako je napøíklad správce souborù nebo operace s tabulkami, pøepi¹te konfiguraèní soubor fckconfig.js file v adresáøi fckeditor nìkterým pøilo¾eným.</li>
<ul>
	<li>pak jdìte na serendipity_event_fckeditor/fckeditor/editor/filemanager/browser/default/connectors/php/config.php</li>
	<li>a zmìòte nastavení následovnì $Config["Enabled"] = true; a $Config["UserFilesPath"] = "/uploads/";</li>
	<li>pak naleznìte serendipity_event_fckeditor/fckeditor/editor/filemanager/upload/php/config.php</li>
	<li>a zopakujte zmìnu parametrù nastavení</li>
</ul>
<li>V FCKeditoru jsou 3 rùzné ¹ablony vzhledu - výchozí, office2003 a silver. Ty se dají nastavit v souboru fckconfig.js.</li>
	<ul><li>Jednodu¹e pøepi¹te promìnnou FCKConfig.SkinPath = FCKConfig.BasePath + "skins/default/" ;. nahraïte office2003 nebo silver</li></ul>

</ul>');
*/

// Next lines were translated on 2013/06/22
@define('PLUGIN_EVENT_FCKEDITOR_DESC',     'Pou¾ívá FCKeditor jako WYSIWYG editor. Vy¾aduje Serendipity 0.9 nebo vy¹¹í. Po instalaci si pøeètìte instalaèního prùvodce na stránce s nastavením pluginu.');
@define('PLUGIN_EVENT_FCKEDITOR_UPDATE',     '<h2>Návod na aktualizaci:</h2>
<ul style="line-height: 1.6">
<li>Pro aktualizaci tohoto pluginu z verze men¹í ne¾ v.0.8 a nìkterých FCKeditorù verze 2.x mezi verzemi v.2.6 a 2.10, zálohujte svoje nastavení (pokud jste si nìjaké pøizpùsobovali) a sma¾te obsah starého adresáøe <em style="color: #777">fckeditor/</em>. Pak následujte instrukce z  "Instalaèního prùvodce".</li>
</ul>');
@define('PLUGIN_EVENT_FCKEDITOR_INSTALL',     '<br /><br /><strong>Instalaèní prùvodce:</strong><br />
<ul>
<li>Stáhnìte FCKeditor v2.1 nebo vy¹¹í z http://www.fckeditor.net/</li>
<li>Rozbalte do podadresáøe "FCKeditor" v adresáøi ' . dirname(__FILE__) . '</li>
<li>Zadejte zde do nastavení pluginu relativní cestuk adresáøi "FCKeditor".</li>
<li>Vìt¹inou je tato cesta "plugins/serendipity_event_fckeditor/fckeditor/"</li>
<li>Ujistìte se, ¾e jste v Nastavení Serendipity povolili pou¾ití WYSIWYG editoru.</li>
</ul>');
@define('PLUGIN_EVENT_FCKEDITOR_CONFIG',     '<br /><br /><strong>Prùvodce nastavením pluginu:</strong><br />
<ul>
<li>Pokud po¾adujete od editoru více funkcí, jako je napøíklad správce souborù nebo operace s tabulkami, pøepi¹te konfiguraèní soubor fckconfig.js file v adresáøi fckeditor nìkterým pøilo¾eným.</li>
<ul>
	<li>pak jdìte na serendipity_event_fckeditor/fckeditor/editor/filemanager/browser/default/connectors/php/config.php</li>
	<li>a zmìòte nastavení následovnì $Config["Enabled"] = true; a $Config["UserFilesPath"] = "/uploads/";</li>
	<li>pak naleznìte serendipity_event_fckeditor/fckeditor/editor/filemanager/upload/php/config.php</li>
	<li>a zopakujte zmìnu parametrù nastavení</li>
</ul>
<li>V FCKeditoru jsou 3 rùzné ¹ablony vzhledu - výchozí, office2003 a silver. Ty se dají nastavit v souboru fckconfig.js.</li>
	<ul><li>Jednodu¹e pøepi¹te promìnnou FCKConfig.SkinPath = FCKConfig.BasePath + "skins/default/" ;. nahraïte office2003 nebo silver</li></ul>

</ul>');