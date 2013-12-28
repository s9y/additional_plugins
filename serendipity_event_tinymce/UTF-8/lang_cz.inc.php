<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/26
 */

@define('PLUGIN_EVENT_TINYMCE_NAME',            'TinyMCE jako WYSIWYG editor');
@define('PLUGIN_EVENT_TINYMCE_DESC',            'Použije TiniMCE WYSIWYG editor pro psaní příspěvků. Vyžaduje Serendipity 0.9 nebo novější. Po instalaci si přečtěte instalačního průvodce v nastavení tohoto pluginu.');
@define('PLUGIN_EVENT_TINYMCE_ARTICLE_ONLY',    'Použít pouze v příspěvcích');
@define('PLUGIN_EVENT_TINYMCE_ARTICLE_ONLY_DESC','Pokud je zapnuto, TinyMCE bude použito pouze k úpravám příspěvku, nebude použito v ostatních pluginech.');
@define('PLUGIN_EVENT_TINYMCE_IMANAGER',        'Zapnout použití nástroje iManager?');
@define('PLUGIN_EVENT_TINYMCE_IMANAGER_DESC',   'iManager je pružný nástroj pro správu obrázků (vyžaduje knihovnu GD). Podívejte se na http://www.j-cons.com/ a přečtěte si tam instalační příručku, s její pomocí dokončete instalaci nástroje.');
@define('PLUGIN_EVENT_TINYMCE_PLUGINS',         'Přídavné pluginy pro TinyMCE');
@define('PLUGIN_EVENT_TINYMCE_PLUGINS_DESC',    'Napište jména adresářů (oddělená čárkou). Adresáře musí být v adresáři pluginu TinyMCE. Pozorně čtěte dokumentaci ke každémuu z pluginů pro TinyMCE. Seznam pluginů dodávaných s TinyMCE najdete na stránce: http://wiki.moxiecode.com/index.php/TinyMCE:Plugins');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS1',        'Tlačítková lišta 1');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS1_DESC',   'Zadejte tlačítka, která mají být viditelný v první tlačítkové liště. Mezera znamená oddělovač v liště, pokud smažete obsah, bude natažena výchozí lišta TinyMCE. Tlačítka, která lze použít, jsou zobrazena na http://wiki.moxiecode.com/index.php/TinyMCE:Control_reference');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS2',        'Tlačítková lišta 2');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS2_DESC',   'Zadejte tlačítka, která mají být viditelný v druhé tlačítkové liště.');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS3',        'Tlačítková lišta 3');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS3_DESC',   'Zadejte tlačítka, která mají být viditelný v třetí tlačítkové liště.');
@define('PLUGIN_EVENT_TINYMCE_SPELLING',        'Kontrola pravopisu v Mozille');
@define('PLUGIN_EVENT_TINYMCE_SPELLING_DESC',   'TinyMCE umí využívat kontrolu pravopisu ve Firefoxu.');
@define('PLUGIN_EVENT_TINYMCE_RELURLS',         'Převést na relativní URL adresy');
@define('PLUGIN_EVENT_TINYMCE_RELURLS_DESC',    'TinyMCE umí převádět místní URL adresy do relativního formátu. Tedy z adresy "http://vas.blog.cz/test.html" se stane "/test.html". Relativní URL adresy jsou důležité, pokud plánujete dělat změny v blogu, nebo pokud chcete k blogu přistupovat z různých domén. Na druhou stranu relativní adresy mohou někde působit problémy.');
@define('PLUGIN_EVENT_TINYMCE_VFYHTML',         'Kontrolovat HTML');
@define('PLUGIN_EVENT_TINYMCE_VFYHTML_DESC',    'TinyMCE se pokouší transformovat zadaný článek na pokud možno validní HTML kód. Smaže tagy, které nejsou součástí HTML specifikace. Např. kódy z YouTube často podle této specifikace nejsou a jsou tudíž smazány během uložení článku. Tato volba může toto chování vypnout nebo zapnout.');
@define('PLUGIN_EVENT_TINYMCE_CLEANUP',         'Vyčistit kód');
@define('PLUGIN_EVENT_TINYMCE_CLEANUP_DESC',    'TinyMCE čistí kód příspěvku při otevírání a ukládání. Pokud tuto volbu vypnete, TinyMCE se HTML kódu ani nedotkne, ale zůstane na Vás zkontrolovat, jestli je kód validní. Vypnutí volby [' . PLUGIN_EVENT_TINYMCE_VFYHTML . '] je ve většině případů lepší řešení.');
@define('PLUGIN_EVENT_TINYMCE_HTTPREL',         'Relativní HTTP cesta pluginu');
@define('PLUGIN_EVENT_TINYMCE_HTTPREL_DESC',    'Definuje HTTP cestu k pluginu relativně ke kořenu serveru. Pokud jste nezměnili strukturu permalinků pro tento plugin a pokud Váš blog neběží na serveru v podadresáři, pak by mělo dobře fungovat výchozí nastavení.');
@define('PLUGIN_EVENT_TINYMCE_INSTALL',         '<br /><br /><strong>Instalační příručka:</strong><br />
<ul>
<li><a href="http://tinymce.moxiecode.com/download.php" target="_blank">Stáhněte TinyMCE, TinyMCE compressor</a> (Pouze TinyMCE 2.0 nebo novější).</li>
<li><b>TinyMCE</b>: Rozbalte do adresáře "tinymce" v adresáři ' . dirname(__FILE__) . '.</li>
<li>TinyMCE compressor rozbalte do adresáře "tinymce/jscripts/tiny_mce/" v adresáři ' . dirname(__FILE__) . ' (Pouze TinyMCE 2.0 nebo novější).</li>
<li>Můžete stáhnout iManager, ale není to poviné (vyžaduje PHP knihovnu GD):
<ul>
<li>Rozbalte iManager do adresáře "tinymce/jscripts/tiny_mce/plugins/imanager"</li>
<li>Upravte konfigurační soubor "tinymce/jscripts/tiny_mce/plugins/imanager/config/config.inc.php"</li>
<li>Nastavte hodnoty pro $cfg["ilibs"] a $cfg["ilibs_dir"]. Zadejte následující relativní HTTP cestu k adresáři pro stažené soubory Serendipity: "' . $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . '"</li>
<li>Ujistěte se, že adresáře imanager/scripts/phpThumb/cache a imanager/temp mají nastavená práva zápisu (777)</li>
</ul>
</li>
<li>V nastavení pluginu TinyMCE zadejte relativní HTTP cestu k adresáři pluginu.</li>
<li>Ujistěte se, že jste v Osobním nastavení Serendipity povolili použití WYSIWYG editoru.</li>
</ul>');

?>
