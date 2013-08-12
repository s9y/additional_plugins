<?php # 

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('S9YPOT_NAME', 'PHPOpenTracker');
@define('S9YPOT_CID', 'PHPOpenTracker Client ID');
@define('S9YPOT_CID_DESC', 'Use this ID to log accesses');
@define('S9YPOT_PATH', 'Path to PHPOpenTracker');
@define('S9YPOT_PATH_DESC', 'Absolute path of your PHPOpenTracker installation. Omit trailing slash. Leave empty when you would like to use a web bug.');
@define('S9YPOT_FNAME', 'PHPOpenTracker file name');
@define('S9YPOT_FNAME_DESC', 'Default settings should be OK.');
@define('S9YPOT_DESC', 'Logs accesses to the blog using PHPOpenTracker. Requires installed phpOpenTracker, please see readme.txt for further information.');

@define('S9YPOT_BUGFNAME', 'Web bug URL');
@define('S9YPOT_BUGFNAME_DESC', 'URL pointing to phpOpenTracker\'s web bug pseudo image file');
@define('S9YPOT_BUGDEFAULT_FNAME', '');

@define('S9YPOT_BUGURL_ERROR', "Web bug path must be a complete http url");
@define('S9YPOT_CID_ERROR', "Client ID must be all-numeric.");
@define('S9YPOT_PATH_ERROR', "Path must be absolute and must not have trailing slash.");
@define('S9YPOT_FNAME_ERROR', "File does not exist at the given location.");

@define('S9YPOT_ERR_RESET', "Settings have been reset to defaults. Reload page to see defaults. Logging has been disabled until you save working config values.");

?>
