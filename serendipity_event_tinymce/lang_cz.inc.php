<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/26
 */

@define('PLUGIN_EVENT_TINYMCE_NAME',            'TinyMCE jako WYSIWYG editor');
@define('PLUGIN_EVENT_TINYMCE_DESC',            'Pou¾ije TiniMCE WYSIWYG editor pro psaní pøíspìvkù. Vy¾aduje Serendipity 0.9 nebo novìj¹í. Po instalaci si pøeètìte instalaèního prùvodce v nastavení tohoto pluginu.');
@define('PLUGIN_EVENT_TINYMCE_ARTICLE_ONLY',    'Pou¾ít pouze v pøíspìvcích');
@define('PLUGIN_EVENT_TINYMCE_ARTICLE_ONLY_DESC','Pokud je zapnuto, TinyMCE bude pou¾ito pouze k úpravám pøíspìvku, nebude pou¾ito v ostatních pluginech.');
@define('PLUGIN_EVENT_TINYMCE_IMANAGER',        'Zapnout pou¾ití nástroje iManager?');
@define('PLUGIN_EVENT_TINYMCE_IMANAGER_DESC',   'iManager je pru¾ný nástroj pro správu obrázkù (vy¾aduje knihovnu GD). Podívejte se na http://www.j-cons.com/ a pøeètìte si tam instalaèní pøíruèku, s její pomocí dokonèete instalaci nástroje.');
@define('PLUGIN_EVENT_TINYMCE_PLUGINS',         'Pøídavné pluginy pro TinyMCE');
@define('PLUGIN_EVENT_TINYMCE_PLUGINS_DESC',    'Napi¹te jména adresáøù (oddìlená èárkou). Adresáøe musí být v adresáøi pluginu TinyMCE. Pozornì ètìte dokumentaci ke ka¾démuu z pluginù pro TinyMCE. Seznam pluginù dodávaných s TinyMCE najdete na stránce: http://wiki.moxiecode.com/index.php/TinyMCE:Plugins');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS1',        'Tlaèítková li¹ta 1');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS1_DESC',   'Zadejte tlaèítka, která mají být viditelný v první tlaèítkové li¹tì. Mezera znamená oddìlovaè v li¹tì, pokud sma¾ete obsah, bude nata¾ena výchozí li¹ta TinyMCE. Tlaèítka, která lze pou¾ít, jsou zobrazena na http://wiki.moxiecode.com/index.php/TinyMCE:Control_reference');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS2',        'Tlaèítková li¹ta 2');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS2_DESC',   'Zadejte tlaèítka, která mají být viditelný v druhé tlaèítkové li¹tì.');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS3',        'Tlaèítková li¹ta 3');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS3_DESC',   'Zadejte tlaèítka, která mají být viditelný v tøetí tlaèítkové li¹tì.');
@define('PLUGIN_EVENT_TINYMCE_SPELLING',        'Kontrola pravopisu v Mozille');
@define('PLUGIN_EVENT_TINYMCE_SPELLING_DESC',   'TinyMCE umí vyu¾ívat kontrolu pravopisu ve Firefoxu.');
@define('PLUGIN_EVENT_TINYMCE_RELURLS',         'Pøevést na relativní URL adresy');
@define('PLUGIN_EVENT_TINYMCE_RELURLS_DESC',    'TinyMCE umí pøevádìt místní URL adresy do relativního formátu. Tedy z adresy "http://vas.blog.cz/test.html" se stane "/test.html". Relativní URL adresy jsou dùle¾ité, pokud plánujete dìlat zmìny v blogu, nebo pokud chcete k blogu pøistupovat z rùzných domén. Na druhou stranu relativní adresy mohou nìkde pùsobit problémy.');
@define('PLUGIN_EVENT_TINYMCE_VFYHTML',         'Kontrolovat HTML');
@define('PLUGIN_EVENT_TINYMCE_VFYHTML_DESC',    'TinyMCE se pokou¹í transformovat zadaný èlánek na pokud mo¾no validní HTML kód. Sma¾e tagy, které nejsou souèástí HTML specifikace. Napø. kódy z YouTube èasto podle této specifikace nejsou a jsou tudí¾ smazány bìhem ulo¾ení èlánku. Tato volba mù¾e toto chování vypnout nebo zapnout.');
@define('PLUGIN_EVENT_TINYMCE_CLEANUP',         'Vyèistit kód');
@define('PLUGIN_EVENT_TINYMCE_CLEANUP_DESC',    'TinyMCE èistí kód pøíspìvku pøi otevírání a ukládání. Pokud tuto volbu vypnete, TinyMCE se HTML kódu ani nedotkne, ale zùstane na Vás zkontrolovat, jestli je kód validní. Vypnutí volby [' . PLUGIN_EVENT_TINYMCE_VFYHTML . '] je ve vìt¹inì pøípadù lep¹í øe¹ení.');
@define('PLUGIN_EVENT_TINYMCE_HTTPREL',         'Relativní HTTP cesta pluginu');
@define('PLUGIN_EVENT_TINYMCE_HTTPREL_DESC',    'Definuje HTTP cestu k pluginu relativnì ke koøenu serveru. Pokud jste nezmìnili strukturu permalinkù pro tento plugin a pokud Vá¹ blog nebì¾í na serveru v podadresáøi, pak by mìlo dobøe fungovat výchozí nastavení.');
@define('PLUGIN_EVENT_TINYMCE_INSTALL',         '<br /><br /><strong>Instalaèní pøíruèka:</strong><br />
<ul>
<li><a href="http://tinymce.moxiecode.com/download.php" target="_blank">Stáhnìte TinyMCE, TinyMCE compressor</a> (Pouze TinyMCE 2.0 nebo novìj¹í).</li>
<li><b>TinyMCE</b>: Rozbalte do adresáøe "tinymce" v adresáøi ' . dirname(__FILE__) . '.</li>
<li>TinyMCE compressor rozbalte do adresáøe "tinymce/jscripts/tiny_mce/" v adresáøi ' . dirname(__FILE__) . ' (Pouze TinyMCE 2.0 nebo novìj¹í).</li>
<li>Mù¾ete stáhnout iManager, ale není to poviné (vy¾aduje PHP knihovnu GD):
<ul>
<li>Rozbalte iManager do adresáøe "tinymce/jscripts/tiny_mce/plugins/imanager"</li>
<li>Upravte konfiguraèní soubor "tinymce/jscripts/tiny_mce/plugins/imanager/config/config.inc.php"</li>
<li>Nastavte hodnoty pro $cfg["ilibs"] a $cfg["ilibs_dir"]. Zadejte následující relativní HTTP cestu k adresáøi pro sta¾ené soubory Serendipity: "' . $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . '"</li>
<li>Ujistìte se, ¾e adresáøe imanager/scripts/phpThumb/cache a imanager/temp mají nastavená práva zápisu (777)</li>
</ul>
</li>
<li>V nastavení pluginu TinyMCE zadejte relativní HTTP cestu k adresáøi pluginu.</li>
<li>Ujistìte se, ¾e jste v Osobním nastavení Serendipity povolili pou¾ití WYSIWYG editoru.</li>
</ul>');

?>
