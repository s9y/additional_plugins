/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/26
 */

@define('PLUGIN_EVENT_AUTOSAVE_TITLE', 'Automatické ukládání');
@define('PLUGIN_EVENT_AUTOSAVE_DESC', 'Bìhem psaní pøíspìvkù je ukládá');
@define('PLUGIN_EVENT_AUTOSAVE_STARTING', 'Automatické ukládání zaèalo...');
@define('PLUGIN_EVENT_AUTOSAVE_INTERVAL', 'Interval');
@define('PLUGIN_EVENT_AUTOSAVE_INTERVAL_DESC', 'Èas v sekundách mezi dvìma pokusy o ulo¾ení (0 vypne automatické ukládání)');
@define('PLUGIN_EVENT_AUTOSAVE_INTERVAL_ERROR', 'Èasový interval musí být celé èíslo');
@define('PLUGIN_EVENT_AUTOSAVE_HTTPATH', 'Relativní HTTP cesta');
@define('PLUGIN_EVENT_AUTOSAVE_HTTPATH_DESC', 'Relativní HTTP cesta k adresáøi pluginu bez úvodních a ukonèujících lomítek (nejspí¹e to bude "plugins/serendipity_event_autosave")');
@define('PLUGIN_EVENT_AUTOSAVE_HTTPATH_ERROR', 'Chyba autosave.');
@define('PLUGIN_EVENT_AUTOSAVE_AJAX_ERROR', 'Ajaxové volání se nezdaøilo!');
@define('PLUGIN_EVENT_AUTOSAVE_SAVE_ERROR', '/!\ automatické ulo¾ení se nezdaøilo:-(');
@define('PLUGIN_EVENT_AUTOSAVE_SAVED', 'Pøíspìvek úspì¹nì ulo¾en :-)');
@define('PLUGIN_EVENT_AUTOSAVE_ACTIVATED', 'Automatické ukládání aktivní (kliknìte pro ruèní ulo¾ení nebo vyèkejte na uplynutí nastaveného èasu)');
@define('PLUGIN_EVENT_AUTOSAVE_ACTIVATING', 'Funkce Autosave se nahrává...');
@define('PLUGIN_EVENT_AUTOSAVE_INIT_FAILED', 'Automatické ukládání není správnì inicializováno a nebude pracovat');
@define('PLUGIN_EVENT_AUTOSAVE_RECOVER', 'Pøíspìvek má automaticky ulo¾ená data, pravdìpodobnì je budete chtít obnovit kliknutím sem');
@define('PLUGIN_EVENT_AUTOSAVE_RECOVER_FAILED', 'Obnova automaticky ulo¾ené kopie selhala');
@define('PLUGIN_EVENT_AUTOSAVE_BAD_SHADOW', 'Poskytnutý ID identifikátor automatické kopie se neshoduje s ID identifikátorem automatického ulo¾ení v pøíspìvku');
@define('PLUGIN_EVENT_AUTOSAVE_RESTORING', 'Obnova automaticky ulo¾ené verze...');
@define('PLUGIN_EVENT_AUTOSAVE_RESTORED', 'Pøíspìvek byl úspì¹nì obnoven z automatické kopie');
@define('PLUGIN_EVENT_AUTOSAVE_BAD_RESPONSE', 'Nerozpoznaná odpovìï AJAXu');
@define('PLUGIN_EVENT_AUTOSAVE_UNSUPPORTED_EDITOR', 'Grrr! Vá¹ WYSIWYG editor je¹tì není podporován :-(');
@define('PLUGIN_EVENT_AUTOSAVE_CONFIRM', 'Opravdu chcete obnovit automaticky ulo¾ená data?');
?>
