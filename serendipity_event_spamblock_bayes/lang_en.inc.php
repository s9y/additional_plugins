<?php

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME',     'Spamblock (Bayes)');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_DESC',     'Detects Spam via an algorithmus which learns.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_HAM',      'Valid');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAM',     'Spam');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_AUTOLEARN',     'Learn');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_AUTOLEARN_DESC',     'Comments strongly regarded as spam are learnt again as spam. That way, slight modifications are caught automatically.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGFILE',     'Logfile location');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGFILE_DESC',     'Information about rejected/moderated posts can be written to a logfile. Set this to an empty string if you want to disable logging.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE',     'Choose logging method');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_DESC',     'Logging of rejected comments can be done in Database or to a plaintext file.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_FILE', 'File (see "logfile" option below)');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_DB', 'Database');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_NONE', 'No Logging');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_REASON', 'Caught by the Bayes-Plugin');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_ERROR', 'Rejected as spam.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MODERATE', 'Regarded as spam, will be moderated.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RATING_EXPLANATION', 'Spamrating of the Spamblock-Bayes-Plugin.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_DELETE', 'Delete comment and mark as spam');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_APPROVE', 'Approve comment and mark as valid');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_PATH', 'Plugin Path');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_PATH_DESC', 'If a path is entered he is no longer determined dynamically, improving performance considerable. Example: http://www.example.com/plugins/serendipity_event_spamblock_bayes/ (note the / at the end).');
@define('PLUGIN_EVENT_SPAMBLOCK_METHOD', 'Spam Treatment');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_MODERATE', 'Custom Moderation');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_MODERATE_DESC', 'Only if option "Spam Treatment" is "Custom": moderate at a rating of? (in %)');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_BLOCK', 'Custom Rejection');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_BLOCK_DESC', 'Only if option "Spam Treatment" is "Custom": reject at a rating of? (in %)');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_MODERATE', 'Moderate');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_BLOCK', 'Reject');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_CUSTOM', 'Custom');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAMBUTTON', 'Mark  as spam');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_HAMBUTTON', 'Mark as valid');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_LEARN', 'Learn');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_DATABASE', 'Database');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_RECYCLER', 'Recycler');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_IMPORT', 'Import');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_CREATEDB', 'Create Database');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LEARNOLD', 'Learn from comments');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_ERASEDB', 'Erase Database');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_SAVEDVALUES', 'Rated comments');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU', 'Menu');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_DESC', 'Link the extended menu in the adminarea.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DESC', 'Shall blocked comments be saved in the recycler?');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_EMPTY', 'Empty Recycler');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RESTORE', 'Restore');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_ANALYSIS', 'Analysis');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DELETE', 'Recyler: Bypass');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DELETE_DESC', 'Comments with a rating equal or higher this value will not be thrown into the recycler, they will be deleted. Example: 98');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IGNORE', 'Ignore');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IGNORE_DESC', 'Parts of comments to be ignored. Possible values: ip, referer, author, body, email, url. Beispiel: "ip, referer".');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_EXPORTDB', 'Export Database');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IMPORTDB', 'Import Database');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IMPORT_EXPLANATION', 'Import a previously generated CSV-file. The included characteristics of spam and comments will become a part of your database.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_EXPLANATION', 'You can import the spam-database of another blog. Register, and other blogs will learn from you spam-database.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA', 'Online Import');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_IMPORT', 'Import');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_REGISTER', 'Add this blog');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_REMOVE', 'Remove this blog');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RATING', 'Rating');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_EMPTY_ALL', 'Recycler: Empty Complete');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_EMPTY_ALL_DESC', 'When emptying the recycler, delete all comments, not only the ones on the current page.');
?>
