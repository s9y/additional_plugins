<?php # $Id$

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_INCLUDEENTRY_NAME',     'Markup: Include entry data/templates/blocks');
@define('PLUGIN_EVENT_INCLUDEENTRY_DESC',     'Allows you to add HTML-style tags to your entry that includes parts of other entrys. Use this markup: [s9y-include-entry:XXX:YYY]. Replace XXX with the target entryid and YYY with the target field name (i.e. "body", "title", "extended", ...). You can also use the new menu functions to maintain templates and blocks that can get inserted in between your entries.');
@define('PLUGIN_EVENT_INCLUDEENTRY_BLOCKS',   'Template-Blocks');
@define('PLUGIN_EVENT_INCLUDEENTRY_DBVERSION', '1.0');
@define('PLUGIN_EVENT_INCLUDEENTRY_FILENAME_NAME', 'Template (Smarty)');
@define('PLUGIN_EVENT_INCLUDEENTRY_FILENAME_DESC', 'Enter the filename of the template which should be used for this page. That smarty file can be placed in this plugin\'s directory or into your template directory.');
@define('STATICBLOCK_SELECT_TEMPLATES', 'Select Template');
@define('STATICBLOCK_SELECT_BLOCKS', 'Select Block');
@define('STATICBLOCK_EDIT_TEMPLATES', 'Edit Template');
@define('STATICBLOCK_EDIT_BLOCKS', 'Edit Block');
@define('STATICBLOCK_USE', 'Use Template');
@define('STATICBLOCK_ATTACH', 'Attach a static Block:');

@define('STATICBLOCK_RANDOMIZE', 'Show random blocks');
@define('STATICBLOCK_RANDOMIZE_DESC', 'If enabled, blocks will be randomly inserted after your entries.');
@define('STATICBLOCK_FIRST_SHOW', 'First entry');
@define('STATICBLOCK_FIRST_SHOW_DESC', 'Enter the amount of articles after which the random block insertion begins. "1" will insert random blocks after the first entry, "2" after the second entry and so on.');
@define('STATICBLOCK_SHOW_SKIP', 'Skip entries');
@define('STATICBLOCK_SHOW_SKIP_DESC', 'Enter the number after which blocks should be randomized again. "1" will show a block after each entry, "2" only after every second entry.');

@define('STATICBLOCK_SHOW_MULTI', 'Allow multiple blocks');
@define('STATICBLOCK_SHOW_MULTI_DESC', 'If you have attached a block to an entry, shall the randomizing function still be able to attach a second block to the end of the entry? If set to "No", each entry will have no more than one block.');

?>
