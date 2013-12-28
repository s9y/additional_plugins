<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/11/21
 */

@define('PLUGIN_PRETTIFY_NAME', 'Prettify pro Serendipity');
@define('PLUGIN_PRETTIFY_DESC', 'Použít skript Prettify pro vybroušení obsahu mezi tagy &lt;PRE&gt; pro jednoduché zvýrazňování syntaxe.');
@define('PLUGIN_PRETTIFY_AUTH', 'Adam Krause');
@define('PLUGIN_PRETTIFY_JSPATH', 'Cesta k prettify.js');
@define('PLUGIN_PRETTIFY_JSPATH_DESC', 'Zadejte cestu ze základního adresáře Serendipity ke skriptu prettify.js');
@define('PLUGIN_PRETTIFY_CSSPATH', 'Cesta k prettify.css');
@define('PLUGIN_PRETTIFY_CSSPATH_DESC', 'Zadejte cestu ze základního adresáře Serendipity k souboru prettify.css');
@define('PLUGIN_PRETTIFY_GENERICPRE', 'Jak má Prettify zvýrazňovat syntaxi uvnitř &lt;PRE&gt; tagu?');
@define('PLUGIN_PRETTIFY_GENERICPRE_DESC', 'Použít obecná pravidla zvýraznění syntaxe na všechen obsah uvnitř &lt;PRE&gt; tagu bez ohledu na upřesnění jazyka ve tříde (class) tagu?');
@define('PLUGIN_PRETTIFY_GENERICPRE_TRUE', 'Obecný');
@define('PLUGIN_PRETTIFY_GENERICPRE_FALSE', 'Podle jazyka');
@define('PLUGIN_PRETTIFY_GENERICCODE', 'Jak má Prettify zvýrazňovat syntaxi uvnitř &lt;CODE&gt; tagu?');
@define('PLUGIN_PRETTIFY_GENERICCODE_DESC', 'Použít obecná pravidla zvýraznění syntaxe na všechen obsah uvnitř &lt;CODE&gt; tagu bez ohledu na upřesnění jazyka ve tříde (class) tagu?');
@define('PLUGIN_PRETTIFY_GENERICCODE_TRUE', 'Obecný');
@define('PLUGIN_PRETTIFY_GENERICCODE_FALSE', 'Podle jazyka');
@define('PLUGIN_PRETTIFY_CONVERTANGLE', 'Poskytnout tlačítko v editoru na konverzi špičatých závorek');
@define('PLUGIN_PRETTIFY_CONVERTANGLE_DESC', 'Objeví se pouze ve standardním (ne-WYSIWYG) editoru. Vyberte blok PRE/CODE a klikněte na tlačítko. Závorky se zakódují. WYSIWYG editory kódují ostré závorky automaticky.');
@define('PLUGIN_PRETTIFY_CONVERTANGLE_TRUE', 'Ano');
@define('PLUGIN_PRETTIFY_CONVERTANGLE_FALSE', 'Ne');