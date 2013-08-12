<?php # 

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_OUTDATE', 'Hide/delete entries for non-registered users after a specific timespan');
@define('PLUGIN_EVENT_OUTDATE_DESC', 'Hides all entries which are older than a specified age, so that they are only visible for registered users/authors.');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT', 'When shall entries be hidden?');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_DESC', 'Enter the maximum age of an entry (number of days) after which an entry is hidden. 0 to deactivate.');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY', 'When shall entries be un-stickified?');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY_DESC', 'Enter the maximum age of an entry (number of days) after which an entry is unstickified. 0 to deactivate.');

@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY', 'Custom Field expiry date');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY_FIELD', 'If you are using the plugin "Extended properties for entries" you can define a custom field where you enter the date when an entry shall expire. That date should be formatted using a timestamp like YYYY-MM-DD. This plugin will look for this expiry date and will set the entry to DRAFT so that it is hidden from the frontend. Enter the fieldname of the custom field (like "ExpiryDate") here.');
