<?php # lang_cs.inc.php 1.0 2009-06-21 19:15:06 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/21
 */

@define('PLUGIN_EVENT_LIVECOMMENT_NAME', 'Vylepšené políčko komentářů');
@define('PLUGIN_EVENT_LIVECOMMENT_DESC', 'Používá JavaScript k ukázání náhledu komentáře a značkovací tlačítka');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT', 'Zvolte zobrazovací metodu.');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_DESC', 'Metoda jQuery používá jvascriptové funkce pro vykreslení komentáře na obrazovku, a to před formulářem pro poslání komentáře. Je rychlá a ve většině případů odvede svoji práci dobře, ale podporuje pouze některé formtovací pluginy (BBCode, Textile, s9y, nl2br, markdown). 
Stará metoda používá skutečná AJAXové volání pro naformátování náhledu komentáře s použitím všech dostupných značkovacích pluginů (Wiki, Emoticons apod.). Tato metoda je náročnější a vkládá náhled na přesné místo, kde bude komentář později zobrazen.
POZOR: Šablona vzhledu, kterou používáte, musí používat obvyklá ID a třídy v CSS, aby fungovala správně (#serendipity_replyform_*, #serendipity_commentForm apod. v šabloně commentform.tpl).');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_JQUERY', 'jQuery (pevná poloha, rychlejší a hezčí)');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_LEGACY', 'Stará metoda (odsazená pozice, plné použití značkovacích pluginů)');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_NONE', 'Žádná (vypnout náhled)');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_TITLE', 'Náhled');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON', 'Formátovací tlačítka');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_DESC', 'Umístí formátovací tlačítka nad oblast pro vložení komentáře.');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION', 'Animace náhledu');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION_DESC', 'Která animace se má použít z zobrazení oblasti náhledu? Vyberte "zobrazit", pokud nechcete použít animaci pro oblast náhledu.');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION_SPEED', 'Rychlost animace oblasti s náhledem');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION_SPEED_DESC', 'Napište jedno z klíčových slov "fast, "def", nebo "slow", anebo napište číslo (které značí čas v ms).');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION', 'Animace formátovacích tlačítek');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION_DESC', 'Která animace se má použít pro zobrazení formátovacích tlačítek? Vyberte "zobrazit", pokud si nepřejete animaci pro tlačítka.');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION_SPEED', 'Rychlost animace formátovacích tlačítek');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION_SPEED_DESC', 'Napište jedno z klíčových slov "fast, "def" nebo "slow" nebo zadejte číslo (které značí čas v ms).');
@define('PLUGIN_EVENT_LIVECOMMENT_TIMEOUT', 'Prodleva Ajaxu');
@define('PLUGIN_EVENT_LIVECOMMENT_TIMEOUT_DESC', 'Prodleva předtím, než jsou zobrazena tlačítka. Volání ajaxu pak musí být kompletní. Ponechte prázdné, pokud si nejse jisti.');
@define('PLUGIN_EVENT_LIVECOMMENT_ELASTIC', 'Pružné pole pro zadání komentáře');
@define('PLUGIN_EVENT_LIVECOMMENT_ELASTIC_DESC', 'V případě potřeby mění velikost textového pole pro zadání komentáře.');
@define('PLUGIN_EVENT_LIVECOMMENT_BOLD', 'tučný');
@define('PLUGIN_EVENT_LIVECOMMENT_ITALIC', 'kurzíva');
@define('PLUGIN_EVENT_LIVECOMMENT_UNDERLINE', 'podtržený');
@define('PLUGIN_EVENT_LIVECOMMENT_URL', 'odkaz');
@define('PLUGIN_EVENT_LIVECOMMENT_INLINE', 'Vnořený JavaScript');
@define('PLUGIN_EVENT_LIVECOMMENT_INLINE_DESC', 'Přidává proměnné JavaScriptu přímo do HTML výstupu - zlepšuje to výkon blogu');
@define('PLUGIN_EVENT_LIVECOMMENT_PATH', 'Cesta k pluginu');
@define('PLUGIN_EVENT_LIVECOMMENT_PATH_DESC', 'Pokud je zadána HTTP cesta k pluginu, pak není určována dynamicky, což má významný vliv na zlepšení výkonu pluginu. Příklad: http://www.priklad.cz/plugins/serendipity_event_livecomment/ (na konci musí být lomítko /).');