<?php # 

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_RECAPTCHA_TITLE', 'Recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_DESC', 'Enabling a recaptcha for commenting articles (You need to apply for a key)');

@define('PLUGIN_EVENT_RECAPTCHA_HIDE', 'Disable Recaptchas for Authors');
@define('PLUGIN_EVENT_RECAPTCHA_HIDE_DESC', 'You can allow authors in the following usergroups to post comments and have recaptcha disabled for them');


@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA', 'Use Recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_DESC', 'If set, a recaptcha will be generated. This is a special kind of captcha, that will help digitize books. See http://www.recaptcha.net for more details. Instead of entering the displayed letters, the user can alternatively listen to a message and type the numbers that were played. If no captcha is generated, the recaptcha server might be down.');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_STYLE', 'Which style to use for recaptcha.');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_STYLE_DESC', 'Chose one of the available styles: red, white, blackglass. This only works with javascript enabled.');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PUB', 'Public key for recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PUB_DESC', 'Provide a public key pair for communicating with the recaptcha.net site. You can request a public/private key pair at http://www.recaptcha.net/api/getkey');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PRIV', 'Private key for recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PRIV_DESC', 'Provide a private key pair for communicating with the recaptcha.net site. You can request a public/private key pair at http://www.recaptcha.net/api/getkey');

@define('PLUGIN_EVENT_RECAPTCHA_CAPTCHAS_TTL', 'Force captchas after how many days');
@define('PLUGIN_EVENT_RECAPTCHA_CAPTCHAS_TTL_DESC', 'Captchas can be enforced depending on the age of your articles. Enter the amount of days after which entering a correct captcha is necessary. If set to 0, captchas will always be used.');


@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE', 'Choose logging method');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_DESC', 'Logging of rejected comments can be done in Database or to a plaintext file');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_FILE', 'File (see "logfile" option below)');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_DB', 'Database');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_NONE', 'No Logging');

@define('PLUGIN_EVENT_RECAPTCHA_LOGFILE', 'Logfile location');
@define('PLUGIN_EVENT_RECAPTCHA_LOGFILE_DESC', 'Information about rejected/moderated posts can be written to a logfile. Set this to an empty string if you want to disable logging.');

@define('PLUGIN_EVENT_RECAPTCHA_ERROR_CAPTCHAS', 'You did not enter the correct string displayed in the spam-prevention image box. Please look at the image and enter the values displayed there.');
@define('PLUGIN_EVENT_RECAPTCHA_ERROR_RECAPTCHA', 'You did not enter a public/private key for the recaptcha setup. No Captchas will be used. If you want to use Recaptchas, please enter the keys in the configuration section of the captcha plugin or switch to traditional Captchas.');

@define('PLUGIN_EVENT_RECAPTCHA_INFO1', 'A Recaptcha is a special <a href="http://en.wikipedia.com/wiki/Captcha">captcha</a>. The user will have to recognize 2 words, one as a challenge-response to prevent spam, and a second one to help digitizing books. Additionally visually impaired people may switch to an acoustic captcha. For more info, you might want to look at the website <a href="http://www.recaptcha.net">www.recaptcha.net</a>.<br/>Please note, that in order to use this plugin you\'ll have to register at this website. You can apply for a key <a href="http://www.recaptcha.net/api/getkey?app=serendipity&domain=');
@define('PLUGIN_EVENT_RECAPTCHA_INFO2', '">here</a>. <br/> Please also note, that this plugin in will query the recaptcha.net server every time and might therefore slow down the loading of the articles and in case of a timeout, no captcha will be displayed.');
