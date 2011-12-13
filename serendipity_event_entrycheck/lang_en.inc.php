<?php # $Id: lang_en.inc.php,v 1.5 2006/08/18 19:36:12 garvinhicking Exp $

/**
 *  @version $Revision: 1.5 $
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_ENTRYCHECK_TITLE', 'Rules for publishing');
@define('PLUGIN_EVENT_ENTRYCHECK_DESC', 'Applies some checks before an entry is published');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES', 'Do not allow empty categories');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_DESC', 'If set to "true", an entry must have at least one category association.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_WARNING', 'It is not allowed to publish an entry without a category association. Please set the appropriate association and save again!');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE', 'Do not allow empty titles');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_DESC', 'If set to "true", an entry must not have an empty title.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_WARNING', 'It is not allowed to publish an entry without assigning a title. Please enter a title for the entry and save again!');
@define('PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT', 'Set a default category');
@define('PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT_DESC', 'If the user left the category association empty, you can set the used default category here.');

@define('PLUGIN_EVENT_ENTRYCHECK_LOCKED', 'This entry was locked for editing by %s on %s');
@define('PLUGIN_EVENT_ENTRYCHECK_UNLOCK', 'Unlock Entry');
@define('PLUGIN_EVENT_ENTRYCHECK_LOCK_WARNING', 'This entry is locked and can only be saved by the lock owner, unless you unlock the entry.');
@define('PLUGIN_EVENT_ENTRYCHECK_LOCKING', 'Enable entry locks?');
?>
