<?php # $Id$

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_AUTOSAVE_TITLE', 'Autosave entries');
@define('PLUGIN_EVENT_AUTOSAVE_DESC', 'Saves entries in background while editing');
@define('PLUGIN_EVENT_AUTOSAVE_STARTING', 'Auto-saving starting ...');
@define('PLUGIN_EVENT_AUTOSAVE_INTERVAL', 'Interval');
@define('PLUGIN_EVENT_AUTOSAVE_INTERVAL_DESC', 'Time in seconds between 2 saves (use 0 to disable)');
@define('PLUGIN_EVENT_AUTOSAVE_INTERVAL_ERROR', 'Time interval must be an integer value');
@define('PLUGIN_EVENT_AUTOSAVE_HTTPATH', 'Relative HTTP path');
@define('PLUGIN_EVENT_AUTOSAVE_HTTPATH_DESC', 'The relative URI to the plugin\'s installation without leading or trailing slashes (probably "plugins/serendipity_event_autosave")');
@define('PLUGIN_EVENT_AUTOSAVE_HTTPATH_ERROR', '');
@define('PLUGIN_EVENT_AUTOSAVE_AJAX_ERROR', 'The ajax call failed !');
@define('PLUGIN_EVENT_AUTOSAVE_SAVE_ERROR', '/!\ auto-save failed ;-(');
@define('PLUGIN_EVENT_AUTOSAVE_SAVED', 'entry has been saved successfully :-)');
@define('PLUGIN_EVENT_AUTOSAVE_ACTIVATED', 'Autosave is active (click me to save manually or wait configured time)');
@define('PLUGIN_EVENT_AUTOSAVE_ACTIVATING', 'Autosave is loading ...');
@define('PLUGIN_EVENT_AUTOSAVE_INIT_FAILED', 'Autosave is not properly initialized and won\'t be available');
@define('PLUGIN_EVENT_AUTOSAVE_RECOVER', 'Entry has autosaved-data, consider recovering by clicking here');
@define('PLUGIN_EVENT_AUTOSAVE_RECOVER_FAILED', 'Recovering of shadow copy failed');
@define('PLUGIN_EVENT_AUTOSAVE_BAD_SHADOW', 'The given id of the shadow copy do not match the entry\'s autosave id');
@define('PLUGIN_EVENT_AUTOSAVE_RESTORING', 'Auto-saving restoring ...');
@define('PLUGIN_EVENT_AUTOSAVE_RESTORED', 'Entry has been successfully restored from shadow copy');
@define('PLUGIN_EVENT_AUTOSAVE_BAD_RESPONSE', 'Unrecognized ajax response');
@define('PLUGIN_EVENT_AUTOSAVE_UNSUPPORTED_EDITOR', 'Arggg! your wysiwyg editor is not yet supported :-(');
@define('PLUGIN_EVENT_AUTOSAVE_CONFIRM', 'You\'re about to recover from autosaved data. Continue ?');
?>
