<?php # 

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_SPAMBLOCK_RBL_TITLE', 'Spam Protector (RBL)');
@define('PLUGIN_EVENT_SPAMBLOCK_RBL_DESC', 'Will reject comments made from hosts which are listed in RBLs. Pay attention that this may affect proxy-users or dial-up users.');
@define('PLUGIN_EVENT_SPAMBLOCK_ERROR_RBL', 'Spam Protection: Your IP is listed as Open Relay. Contact your ISP!');
@define('PLUGIN_EVENT_SPAMBLOCK_RBLLIST', 'Which RBLs should be contacted');
@define('PLUGIN_EVENT_SPAMBLOCK_RBLLIST_DESC', 'Blocks comments based on provided RBL lists. Avoid lists with dynamic hosts.');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_RBL', 'RBL-block');

@define('PLUGIN_EVENT_SPAMBLOCK_HONEYPOT_TITLE', 'Spam Protector (Project Honeypot)');
@define('PLUGIN_EVENT_SPAMBLOCK_HONEYPOT_DESC', 'Will reject comments made from hosts which are listed in the Project Honeypot http:BL');
@define('PLUGIN_EVENT_SPAMBLOCK_HONEYPOT_KEY', 'httpBL_key');
@define('PLUGIN_EVENT_SPAMBLOCK_HONEYPOT_KEY_DESC', 'Enter you http:BL key');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_HONEYPOT', 'Project Honeypot http:BL found a ');
?>
