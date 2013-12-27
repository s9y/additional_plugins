/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/21
 */

@define('PLUGIN_EVENT_LIVECOMMENT_NAME', 'Vylepšené políèko komentáøù');
@define('PLUGIN_EVENT_LIVECOMMENT_DESC', 'Používá JavaScript k ukázání náhledu komentáøe a znaèkovací tlaèítka');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT', 'Zvolte zobrazovací metodu.');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_DESC', 'Metoda jQuery používá jvascriptové funkce pro vykreslení komentáøe na obrazovku, a to pøed formuláøem pro poslání komentáøe. Je rychlá a ve vìtšinì pøípadù odvede svoji práci dobøe, ale podporuje pouze nìkteré formtovací pluginy (BBCode, Textile, s9y, nl2br, markdown). 
Stará metoda používá skuteèná AJAXové volání pro naformátování náhledu komentáøe s použitím všech dostupných znaèkovacích pluginù (Wiki, Emoticons apod.). Tato metoda je nároènìjší a vkládá náhled na pøesné místo, kde bude komentáø pozdìji zobrazen.
POZOR: Šablona vzhledu, kterou používáte, musí používat obvyklá ID a tøídy v CSS, aby fungovala správnì (#serendipity_replyform_*, #serendipity_commentForm apod. v šablonì commentform.tpl).');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_JQUERY', 'jQuery (pevná poloha, rychlejší a hezèí)');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_LEGACY', 'Stará metoda (odsazená pozice, plné použití znaèkovacích pluginù)');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_NONE', 'Žádná (vypnout náhled)');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_TITLE', 'Náhled');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON', 'Formátovací tlaèítka');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_DESC', 'Umístí formátovací tlaèítka nad oblast pro vložení komentáøe.');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION', 'Animace náhledu');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION_DESC', 'Která animace se má použít z zobrazení oblasti náhledu? Vyberte "zobrazit", pokud nechcete použít animaci pro oblast náhledu.');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION_SPEED', 'Rychlost animace oblasti s náhledem');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION_SPEED_DESC', 'Napište jedno z klíèových slov "fast, "def", nebo "slow", anebo napište èíslo (které znaèí èas v ms).');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION', 'Animace formátovacích tlaèítek');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION_DESC', 'Která animace se má použít pro zobrazení formátovacích tlaèítek? Vyberte "zobrazit", pokud si nepøejete animaci pro tlaèítka.');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION_SPEED', 'Rychlost animace formátovacích tlaèítek');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION_SPEED_DESC', 'Napište jedno z klíèových slov "fast, "def" nebo "slow" nebo zadejte èíslo (které znaèí èas v ms).');
@define('PLUGIN_EVENT_LIVECOMMENT_TIMEOUT', 'Prodleva Ajaxu');
@define('PLUGIN_EVENT_LIVECOMMENT_TIMEOUT_DESC', 'Prodleva pøedtím, než jsou zobrazena tlaèítka. Volání ajaxu pak musí být kompletní. Ponechte prázdné, pokud si nejse jisti.');
@define('PLUGIN_EVENT_LIVECOMMENT_ELASTIC', 'Pružné pole pro zadání komentáøe');
@define('PLUGIN_EVENT_LIVECOMMENT_ELASTIC_DESC', 'V pøípadì potøeby mìní velikost textového pole pro zadání komentáøe.');
@define('PLUGIN_EVENT_LIVECOMMENT_BOLD', 'tuèný');
@define('PLUGIN_EVENT_LIVECOMMENT_ITALIC', 'kurzíva');
@define('PLUGIN_EVENT_LIVECOMMENT_UNDERLINE', 'podtržený');
@define('PLUGIN_EVENT_LIVECOMMENT_URL', 'odkaz');
@define('PLUGIN_EVENT_LIVECOMMENT_INLINE', 'Vnoøený JavaScript');
@define('PLUGIN_EVENT_LIVECOMMENT_INLINE_DESC', 'Pøidává promìnné JavaScriptu pøímo do HTML výstupu - zlepšuje to výkon blogu');
@define('PLUGIN_EVENT_LIVECOMMENT_PATH', 'Cesta k pluginu');
@define('PLUGIN_EVENT_LIVECOMMENT_PATH_DESC', 'Pokud je zadána HTTP cesta k pluginu, pak není urèována dynamicky, což má významný vliv na zlepšení výkonu pluginu. Pøíklad: http://www.priklad.cz/plugins/serendipity_event_livecomment/ (na konci musí být lomítko /).');