<?php # 

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_FORGOTPASSWORD_NAME', 'Forgot Password');
@define('PLUGIN_EVENT_FORGOTPASSWORD_DESC', 'Change the password for selected user');
@define('PLUGIN_EVENT_FORGOTPASSWORD_LOST_PASSWORD', 'Forgot Password?');
@define('PLUGIN_EVENT_FORGOTPASSWORD_ENTER_USERNAME', 'Enter username of forgotten account here');
@define('PLUGIN_EVENT_FORGOTPASSWORD_ENTER_PASSWORD', 'Enter your desired password');
@define('PLUGIN_EVENT_FORGOTPASSWORD_SEND_EMAIL', 'Send Email');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SUBJECT', 'Forgot Password');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_BODY', "Someone (maybe yourself) wants to reset your weblog account password,\nif you want to reset your password, click on the following link:\n");
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_DB_ERROR', 'Cannot connect to Database');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_CANNOT_SEND', "Cannot send email, this could be because of bad SMTP configuration in php.ini<br />\nor because you didn't declare a valid email address in your profile.");
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SENT', 'Email sent successfully, check your mailbox');
@define('PLUGIN_EVENT_FORGOTPASSWORD_CHANGE_PASSWORD', 'Change Password');
@define('PLUGIN_EVENT_FORGOTPASSWORD_PASSWORD_CHANGED', 'Password changed successfully');
@define('PLUGIN_EVENT_FORGOTPASSWORD_USER_NOT_EXIST', 'Desired username does not exist in the Database, go back and try again');

@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAIL', 'Send a mail notice, when a user tries to change password without a mail address?');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAILTXT', 'Content of mail notification');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAILTXT_DEFAULT', 'User "%s" tried to login, but no mail address is assigned. Please create a new password and contact this user manually.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER', 'Error message if no mail address exists.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_DEFAULT', 'No mail address has been configured for that author. A new password cannot be sent.');

?>
