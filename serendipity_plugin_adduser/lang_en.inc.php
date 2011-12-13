<?php # $Id: lang_en.inc.php,v 1.5 2008/06/08 09:44:23 garvinhicking Exp $

/**
 *  @version $Revision: 1.5 $
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_ADDUSER_NAME',     'User Self-Registration');
@define('PLUGIN_ADDUSER_DESC',     'Allows blog visitors to create their own author account. Together with the Event-plugin (index.php?serendipity[subpage]=adduser) you can choose whether only registered users may post comments.');
@define('PLUGIN_ADDUSER_INSTRUCTIONS', 'Additional instructions');
@define('PLUGIN_ADDUSER_INSTRUCTIONS_DESC', 'Add extra instructions which shall appear in the creation form');
@define('PLUGIN_ADDUSER_INSTRUCTIONS_DEFAULT', 'Here you can register yourself as an author for this blog. Just enter your data, submit the form and receive further instructions via mail.');
@define('PLUGIN_ADDUSER_USERLEVEL', 'Default userlevel');
@define('PLUGIN_ADDUSER_USERLEVEL_DESC', 'Which is the default userlevel for a new user');
@define('PLUGIN_ADDUSER_USERLEVEL_CHIEF', 'Chief');
@define('PLUGIN_ADDUSER_USERLEVEL_EDITOR', 'Editor');
@define('PLUGIN_ADDUSER_USERLEVEL_ADMIN', 'Administrator');
@define('PLUGIN_ADDUSER_USERLEVEL_DENY', 'Deny Access');
@define('PLUGIN_SIDEBAR_LOGIN', 'Show sidebar login box?');
@define('PLUGIN_SIDEBAR_LOGIN_DESC', 'If enabled, a login box will be shown in the sidebar. If disabled you will need your users to register via a special page setup in the corresponding event plugin.');

@define('PLUGIN_ADDUSER_EXISTS', 'Sorry, the username "%s" is already taken. Please choose another name.');
@define('PLUGIN_ADDUSER_MISSING', 'You must fill in all the fields to apply for an author account.');
@define('PLUGIN_ADDUSER_SENTMAIL', 'Your account has been created. You should receive an E-Mail with all the necessary information shortly.');
@define('PLUGIN_ADDUSER_WRONG_ACTIVATION', 'Invalid activation URL!');

@define('PLUGIN_ADDUSER_MAIL_SUBJECT', 'A new author account has been created');
@define('PLUGIN_ADDUSER_MAIL_BODY', "An author account has just been created for %s on the blog %s. To activate this account, click here:\n\n%s\n\nAfter you have clicked there, logging in is possible with the submitted password. This E-Mail has been sent to the owner of the blog as well as the new author.");
@define('PLUGIN_ADDUSER_SUCCEED', 'The account has been successfully enabled. You can now log in to the administative panel of this blog, the link to there is contained in your activation email.');
@define('PLUGIN_ADDUSER_FAILED', 'The account could not be enabled. Maybe you copied the wrong URL from your activation email?');

@define('PLUGIN_ADDUSER_REGISTERED_ONLY', 'Only registered users may post comments?');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_DESC', 'If enabled, only registered users may post comments to your entries and need to be logged in to do so.');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_REASON', 'Only registered users may post comments here. Get your own account <a href="%s">here</a> and then <a href="%s">log into this blog</a>. Your browser must support cookies.');

@define('PLUGIN_ADDUSER_SERENDIPITY09', 'Serendipity 0.9 is required for this option.');
@define('PLUGIN_ADDUSER_STRAIGHT', 'Straight insert?');
@define('PLUGIN_ADDUSER_STRAIGHT_DESC', 'If enabled, a user will immediately be recorded as valid co-author. This is only recommended in setups where no mailserver is available. This feature can easily be abused by spammers. Only turn it on if you know what you are doing!');

@define('PLUGIN_ADDUSER_REGISTERED_CHECK', 'Prevent identity faking');
@define('PLUGIN_ADDUSER_REGISTERED_CHECK_DESC', 'If enabled, the usernames registered by authors on your blog can only be used by those logged in users.');
@define('PLUGIN_ADDUSER_REGISTERED_CHECK_REASON', 'The username you entered is only available to registered authors of this blog. Please <a href="%s" %s>login</a> to post a comment with that username. If you are not a registered author, please use a different username.');

@define('PLUGIN_ADDUSER_ADMINAPPROVE', 'Registered users need admin approval?');
@define('PLUGIN_ADDUSER_ADMINAPPROVE_DESC', 'If enabled, administrators will first need to approve new users before they receive an email.');
@define('PLUGIN_ADDUSER_SENTMAIL_APPROVE', 'Your account has been created. You should receive an E-Mail with all the necessary information after an Administrator has reviewed your request.');
@define('PLUGIN_ADDUSER_SENTMAIL_APPROVE_ADMIN', 'The account has been confirmed, the correspondig user will receive his account information.');
@define('PLUGIN_ADDUSER_MAIL_SUBJECT_APPROVE', '[Approval required] A new author account has been created');
@define('PLUGIN_ADDUSER_MAIL_BODY_APPROVE', "An author account has just been created for %s on the blog %s. To allow the user to activate his account, click here:\n\n%s\n\nAfter you have clicked there, the author will receive an email allowing him to login with his password.");

@define('PLUGIN_ADDUSER_CAPTCHA', 'Use Captchas');
@define('PLUGIN_ADDUSER_CAPTCHA_DESC', 'Requires installed spamblock event plugin.');

@define('PLUGIN_ADDUSER_ANTISPAM', 'You did not pass the anti-spam tests. Please check if you entered the CAPTCHA correctly.');
