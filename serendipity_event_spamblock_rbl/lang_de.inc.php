<?php # $Id$

        @define('PLUGIN_EVENT_SPAMBLOCK_RBL_TITLE', 'Spamschutz (RBL)');
        @define('PLUGIN_EVENT_SPAMBLOCK_RBL_DESC', 'Blockiert SPAM Anhand von IP-Blacklists. Wird diese Option aktiviert, werden Kommentare abgewiesen die von IPs stammen, die in einer RBL/Blacklist geführt werden. Die Aktivierung hiervon kann Dial-Up oder Proxy-User betreffen!');
        @define('PLUGIN_EVENT_SPAMBLOCK_ERROR_RBL', 'Spamschutz: Ihre IP ist als Open Relay geführt, daher wird Ihr Kommentar abgewiesen. Kontaktieren Sie Ihren Provider!');
        @define('PLUGIN_EVENT_SPAMBLOCK_RBLLIST', 'Welche RBLs sollen verwendet werden');
        @define('PLUGIN_EVENT_SPAMBLOCK_RBLLIST_DESC', 'Eine Liste von zu verwendenden RBLs. Listen mit dynamischen Hosts sollten vermieden werden.');
        @define('PLUGIN_EVENT_SPAMBLOCK_REASON_RBL', 'RBL-Block');
