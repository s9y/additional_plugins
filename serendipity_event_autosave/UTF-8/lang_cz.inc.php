<?php # lang_cz.inc.php 1.0 2009-06-26 18:26:22 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/26
 */

@define('PLUGIN_EVENT_AUTOSAVE_TITLE', 'Automatické ukládání');
@define('PLUGIN_EVENT_AUTOSAVE_DESC', 'Během psaní příspěvků je ukládá');
@define('PLUGIN_EVENT_AUTOSAVE_STARTING', 'Automatické ukládání začalo...');
@define('PLUGIN_EVENT_AUTOSAVE_INTERVAL', 'Interval');
@define('PLUGIN_EVENT_AUTOSAVE_INTERVAL_DESC', 'Čas v sekundách mezi dvěma pokusy o uložení (0 vypne automatické ukládání)');
@define('PLUGIN_EVENT_AUTOSAVE_INTERVAL_ERROR', 'Časový interval musí být celé číslo');
@define('PLUGIN_EVENT_AUTOSAVE_HTTPATH', 'Relativní HTTP cesta');
@define('PLUGIN_EVENT_AUTOSAVE_HTTPATH_DESC', 'Relativní HTTP cesta k adresáři pluginu bez úvodních a ukončujících lomítek (nejspíše to bude "plugins/serendipity_event_autosave")');
@define('PLUGIN_EVENT_AUTOSAVE_HTTPATH_ERROR', 'Chyba autosave.');
@define('PLUGIN_EVENT_AUTOSAVE_AJAX_ERROR', 'Ajaxové volání se nezdařilo!');
@define('PLUGIN_EVENT_AUTOSAVE_SAVE_ERROR', '/!\ automatické uložení se nezdařilo:-(');
@define('PLUGIN_EVENT_AUTOSAVE_SAVED', 'Příspěvek úspěšně uložen :-)');
@define('PLUGIN_EVENT_AUTOSAVE_ACTIVATED', 'Automatické ukládání aktivní (klikněte pro ruční uložení nebo vyčkejte na uplynutí nastaveného času)');
@define('PLUGIN_EVENT_AUTOSAVE_ACTIVATING', 'Funkce Autosave se nahrává...');
@define('PLUGIN_EVENT_AUTOSAVE_INIT_FAILED', 'Automatické ukládání není správně inicializováno a nebude pracovat');
@define('PLUGIN_EVENT_AUTOSAVE_RECOVER', 'Příspěvek má automaticky uložená data, pravděpodobně je budete chtít obnovit kliknutím sem');
@define('PLUGIN_EVENT_AUTOSAVE_RECOVER_FAILED', 'Obnova automaticky uložené kopie selhala');
@define('PLUGIN_EVENT_AUTOSAVE_BAD_SHADOW', 'Poskytnutý ID identifikátor automatické kopie se neshoduje s ID identifikátorem automatického uložení v příspěvku');
@define('PLUGIN_EVENT_AUTOSAVE_RESTORING', 'Obnova automaticky uložené verze...');
@define('PLUGIN_EVENT_AUTOSAVE_RESTORED', 'Příspěvek byl úspěšně obnoven z automatické kopie');
@define('PLUGIN_EVENT_AUTOSAVE_BAD_RESPONSE', 'Nerozpoznaná odpověď AJAXu');
@define('PLUGIN_EVENT_AUTOSAVE_UNSUPPORTED_EDITOR', 'Grrr! Váš WYSIWYG editor ještě není podporován :-(');
@define('PLUGIN_EVENT_AUTOSAVE_CONFIRM', 'Opravdu chcete obnovit automaticky uložená data?');
?>
