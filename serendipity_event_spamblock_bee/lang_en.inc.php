<?php

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_TITLE', 'Spamblock Bee (Honeypot, Hidden Captcha)');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_DESC',  'Implements simple comment antispam mechanisms, that are easy to configure but very effective.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_EXTRA_DESC',  '<strong>Installation hint</strong>: It is important that you put this plugin at the start of your plugin list. It will be most effective then.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_PATH', 'Plugins path');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_PATH_DESC', 'In normal installations the default is correct.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS', 'Required comment fields when commenting');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS_DESC', 'Enter a list of required fields that need to be filled when a user comments. Seperate multiple fields with a ",". Available keys are: name, email, url, replyTo, comment');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REASON_REQUIRED_FIELD', 'You did not specify the %s field!');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_TITLE', 'Reject comments which only contain the entry title');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_TITLE_DESC', 'Some comment spam bots want to set a link only and produce comment content by reproducing what is found at the pages title only. No normal user would do that, so it is save to switch this option on.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_SAMEBODY', 'Reject comments which body already existing');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_SAMEBODY_DESC', 'This will prevent comments already existing on this blog. I.e. if the user presses reload after saving the comment. These comments can savely be rejected.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_ERROR_BODY', 'Spam Prevention: Invalid message.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT', 'Use Honeypot');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT_DESC', 'A "Honeypot" is a hidden comment form field that should be left empty but as most SPAM bots do fill any field found it is an easy way to detect automatic commenting. There is no risk to switch it on, but high benefit! In order to make the honeypot more effective put the Spamblock Bee at top of any anti spam plugin.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HCAPTCHA', 'Use hidden captchas');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HCAPTCHA_DESC', 'This produces a captcha, that is very simple to solve for humans (but not that easy for bots). If the user has Javascript enabled, it will even be answered automatically and hidden. As bots don\'t know Javascript, this is another nice trap for bots but invisible for normal commenters.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_ERROR_HCAPTCHA', 'Spam Prevention: Wrong Captcha.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE', 'Spam log type');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DESC', 'Where do you want to log spam found by Spamblock Bee?');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_NONE', 'Don\'t log');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_FILE', 'Text logfile');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DATABASE', 'Spamlog database table');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE', 'Logfile');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE_DESC', 'Where to save the logfile if used for logging?');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_OFF', 'Switched off');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_MODERATE', 'Moderate comments');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_REJECT', 'Reject comments');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_0', 'zero');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_1', 'one');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_2', 'two');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_3', 'three');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_4', 'four');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_5', 'five');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_6', 'six');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_7', 'seven');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_8', 'eight');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_9', 'nine');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_10', 'ten');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_PLUS', 'plus');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_MINUS', 'minus');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_QUEST', 'What is');
