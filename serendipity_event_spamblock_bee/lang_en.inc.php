<?php

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_TITLE', 'Spamblock Bee (Honeypot)');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_DESC',  'Implements simple comment antispam mechanisms, that are easy to configure but very effective (Honeypot).');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_EXTRA_DESC',  '<strong>Installation hint</strong>: It is important that you put this plugin at the start of your plugin list. It will be most effective then.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_PATH', 'Plugins path');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_PATH_DESC', 'In normal installations the default is correct.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS', 'Required comment fields when commenting');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS_DESC', 'Enter a list of required fields that need to be filled when a user comments. Seperate multiple fields with a ",". Available keys are: name, email, url, replyTo, comment');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REASON_REQUIRED_FIELD', 'You did not specify the %s field!');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT', 'Use Honeypot');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT_DESC', 'A "Honeypot" is a hidden comment form field that should be left empty but as most SPAM bots do fill any field found it is an easy way to detect automatic commenting. There is no risk to switch it on, but high benefit! In order to make the honeypot more effective put the Spamblock Bee at top of any anti spam plugin.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE', 'Spam log type');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DESC', 'Where do you want to log spam found by Spamblock Bee?');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_NONE', 'Don\'t log');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_FILE', 'Text logfile');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DATABASE', 'Spamlog database table');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE', 'Logfile');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE_DESC', 'Where to save the logfile if used for logging?');
