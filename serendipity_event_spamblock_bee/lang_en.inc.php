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

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SECTION_LOGGING', 'Files and Logging');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SECTION_ADVANCED', 'Advanced Captcha Configuration');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT', 'Use Honeypot');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT_DESC', 'A "Honeypot" is a hidden comment form field that should be left empty but as most SPAM bots do fill any field found it is an easy way to detect automatic commenting. There is no risk to switch it on, but high benefit! In order to make the honeypot more effective put the Spamblock Bee at top of any anti spam plugin.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_WARN_HONEPOT', 'You don\'t want to give me your number, do you? ;)');
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

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_DEFAULT', 'Default');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_JSON', 'JSON');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_SMARTY', 'Smarty');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_SMARTY_ENC', 'Smarty + Encryption');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QT_MATH', 'Math problems');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QT_CUSTOM', 'Custom questions');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DESC', 'Advanced configuration options for the hidden Captcha. If the captcha is disabled, you can safely ignore this section.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWER_RETRIEVAL', 'Answer retrieval method');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWER_RETRIEVAL_DESC', 'Select how you want to retrieve to correct answer to the Captcha. If you select "JSON", you can send an Ajax request to index.php/plugin/spamblockbeecaptcha to get the answer. "Smarty" will provide the answer through the Smarty variable {$beeCaptchaAnswer}, whereas "Default" will hard code it into the page. NOTE: If "Smarty" is selected, no additional CSS or JavaScript will be included. You have to fill and hide the Captcha field yourself. "Smarty + Encryption" is the same as "Smarty" with the difference that the answer in {$beeCaptchaAnswer} is scrambled with a simple XOR cipher. The variable {$beeCaptchaScrambleKey} contains the decryption key.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTION_TYPE', 'Type of question');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTION_TYPE_DESC', 'Spamblock Bee can automatically generate simple math problems for you or you can create your own questions and answers. Select which one you prefer');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTIONS', 'Custom questions');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DEFAULT_QUESTIONS', "Question1\nQuestion2");
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTIONS_DESC', 'If you want to use custom questions for you Captcha, you can specify them here. Write down one question per line. Before the user can submit the form, he has to answer one randomly selected question from the list.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWERS', 'Answers to custom questions');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWERS_DESC', 'This field contains the correct answers for the questions specified above. Write down one answer per line in the same order as the corresponding questions. Questions that don\'t have a valid answer will be ignored. All answers are case-insensitive (i.e. "Answer" is the same as "answer").');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DEFAULT_ANSWERS', "Answer1\nAnswer2");
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_USE_REGEXP', 'Use regular expressions');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_USE_REGEXP_DESC', "Whether to interpret the answers given above as Perl compatible regular expressions (PCREs). This can be used to allow several variants of an answer. Each answer line should follow the rule /pattern/:answer. NOTE: Only enable this if you know what you\'re doing. Filling in bad regular expressions causes validity checks to fail and in some rare cases might expose yourself to a so called Denial of Service attack! Answers longer than 1000 characters will be rejected when regular expression matching is on.");

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

@define('PLUGIN_SPAMBLOCK_BEE_TITLE', 'Spam Report');
@define('PLUGIN_SPAMBLOCK_BEE_DESC', 'Prints out a statistic about your comment spam if your antispam plugins report to the DB.');
