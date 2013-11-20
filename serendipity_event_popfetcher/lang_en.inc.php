<?php
// English Language definitions
// Author: Jason Levitt
// Email: fredb86@users.sourceforge.net

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_MF_NAME', 'POPfetcher');
@define('PLUGIN_MF', 'POPfetcher');
@define('PLUGIN_MF_DESC', 'Fetches and publishes email and attachments from a POP3 email account (with special cell phone support)');
@define('PLUGIN_MF_AM', 'Plugin Type');
@define('PLUGIN_MF_AM_DESC', 'If set to Internal, you can only launch POPfetcher from your admin menu. If set to External, you can only launch POPfetcher externally (typically from a cron job). Default is Internal.');
@define('PLUGIN_MF_HN', 'External Launch Name');
@define('PLUGIN_MF_HN_DESC', 'This is the name used to launch your plugin externally. Set this to some unguessable string to keep villains from running this plugin. Underscores are not allowed. If Plugin Type is set to Internal, this has no effect. Default value is popfetcher.');
@define('PLUGIN_MF_MS', 'Mail Server');
@define('PLUGIN_MF_MS_DESC', 'The domain name of your POP3 mail server, e.g. yourdomain.com');
@define('PLUGIN_MF_MD', 'Upload Directory');
@define('PLUGIN_MF_MD_DESC', 'Decoded attachments will be placed in this directory. Default is your top-level uploads directory (leave it blank). If you enter a directory, make sure you end it with a "/". Example: MyVacation/ ');
@define('PLUGIN_MF_PP', 'POP3 port');
@define('PLUGIN_MF_PP_DESC', 'POP3 service port. If set to 995, POP3 over SSL will be attempted. Default is 110.');
@define('PLUGIN_MF_MU', 'Username');
@define('PLUGIN_MF_MU_DESC', 'Your POP3 login user name');
@define('PLUGIN_MF_CAT', 'Category');
@define('PLUGIN_MF_CAT_DESC', 'Blog category to publish under. Default is no category (leave blank)');
@define('PLUGIN_MF_MP', 'Password');
@define('PLUGIN_MF_MP_DESC', 'Your POP3 password');
@define('PLUGIN_MF_TO', 'Timeout');
@define('PLUGIN_MF_TO_DESC', 'Number of seconds to attempt connection to mail server. Default is 30 seconds.');
@define('PLUGIN_MF_DF', 'Delete flag');
@define('PLUGIN_MF_PF_DESC', 'If Publish, blog entries are posted as live published entries. If Draft, entries are marked as draft entries. Default is draft. (This flag is ignored if Blog flag is set to no).');
@define('PLUGIN_MF_PF', 'Publish flag');
@define('PLUGIN_MF_BF_DESC', 'If yes, attachments are decoded, moved to the image manager, appended to the message text of your email and posted as a blog entry. If no, the attachments are decoded and moved to the image manager and the rest of the message is discarded.');
@define('PLUGIN_MF_BF', 'Blog flag');
@define('PLUGIN_MF_DF_DESC', 'If yes, mail is deleted from server after it is fetched. Usually set to yes unless you are testing things.');
@define('PLUGIN_MF_AF', 'APOP flag');
@define('PLUGIN_MF_AF_DESC', 'If yes, an APOP login will be attempted. Default is no.');
@define('ERROR_CHECK', 'ERROR:');
@define('INTERNAL_MF', 'Internal');
@define('EXTERNAL_MF', 'External');
@define('PUBLISH_MF', 'Publish');
@define('DRAFT_MF', 'Draft');
@define('MF_ERROR1', 'ERROR: could not connect to mail server');
@define('MF_ERROR2', 'ERROR: could not login to mail server');
@define('MF_ERROR3', 'ERROR: could not get UIDL info from the mail box. It probably does not support UIDL');
@define('MF_ERROR4', 'ERROR: error ocurred while fetching msg from your mail box');
@define('MF_ERROR5', 'ERROR: could not create file: ');
@define('MF_ERROR6', 'ERROR: your upload directory is not writable. Go to your plugin settings and change it.');
@define('MF_ERROR7', 'ERROR: your upload directory path must end with a slash "/". Go to your plugin settings and change it.');
@define('MF_ERROR8', 'ERROR: the blog category you specified does not exist.');
@define('MF_ERROR9', 'ERROR: mimeDecode failed because your message had an invalid MIME format.');
@define('MF_ERROR10', 'ERROR: Could not find the SprintPCS Picture/Video Share URL.');
@define('MF_ERROR11', 'ERROR: Failed to fetch the SprintPCS Picture/Video URL.');
@define('MF_ERROR13', 'ERROR: Fopen failed trying to open new picture/video file');
@define('MF_ERROR14', 'ERROR: Could not open new file for SprintPCS sound memo');
@define('MF_MSG1', 'You have no messages in your mailbox');
@define('MF_MSG2', 'Number of messages extracted from your mailbox');
@define('MF_MSG3', '[No date header found]');
@define('MF_MSG4', '[No from header found]');
@define('MF_MSG5', 'Date: ');
@define('MF_MSG6', 'From: ');
@define('MF_MSG7', 'MESSAGE DATA');
@define('MF_MSG8', 'MESSAGE PART -- Found attachment named: ');
@define('MF_MSG9', 'MESSAGE PART -- Message found but no attachment body');
@define('MF_MSG10', 'No attachments or message body found in this message');
@define('MF_MSG11', 'All messages deleted from your mailbox');
@define('MF_MSG12', 'All messages are still in your mailbox');
@define('MF_MSG13', 'Wrote attachment into file named: ');
@define('MF_MSG14', 'Attachment name already exists. Modifying file name for attachment named: ');
@define('MF_MSG15', 'Published new blog entry with id');
@define('MF_MSG16', 'Subject: ');
@define('MF_MSG17', '[No subject header found]');
@define('MF_MSG18', 'Click for full size image');
@define('MF_MSG19', 'Possible virus decoded. Skipping msg because a risky attachment name was found');
@define('MF_MSG20', 'Skipped msg with no attachments');
@define('MF_MSG21', 'Sound Memo');
@define('MF_MSG22', 'Click for your video');
@define('MF_MSG23', 'Cell Phone @ ');
@define('MF_TEXTBODY', 'Use plaintext attachments as entry body?');
@define('MF_TEXTBODY_DESC', 'If activated, all plaintext attachments of a mail will be used as the body of your entry. If not activated, all text attachments will be saved as text attachments and only linked in your entry');
@define('MF_TEXTBODY_FIRST', 'First text attachment is entry body, the rest extended');
@define('MF_TEXTBODY_FIRST_DESC', 'Only used if plaintext attachments are treated as entry body (see above). If activated, only the first plaintext attachment will be used as the entry body, all other contained text attachments will be put into the extended part of your entry');
@define('MF_MYSELF', 'Current author');
@define('MF_AUTHOR_DESC', 'Specify the author, to which the popfetcher entries should be assigned');
@define('PLUGIN_MF_STRIPTAGS', 'Strip HTML Tags from message');
@define('PLUGIN_MF_STRIPTAGS_DESC', 'Strip HTML Tags from message');

@define('PLUGIN_MF_ADDFLAG', 'Strip advertisements?');
@define('PLUGIN_MF_ADDFLAG_DESC', 'Should popfetcher try to strip advertisement graphics and text from the message? Currently this filter only affects O2 and T-Mobile.');

@define('PLUGIN_MF_STRIPTEXT', 'Strip text after special string');
@define('PLUGIN_MF_STRIPTEXT_DESC', 'If you want to cut advertisement or other texts, you can specify a "magic string" sequence here. All text after this special string is removed from your posting.');

@define('PLUGIN_MF_ONLYFROM', 'Restrict e-mail sender');
@define('PLUGIN_MF_ONLYFROM_DESC', 'If you only want to allow a certain e-mail address to send mails, you can enter it here. If you leave this field empty, all mails received for your configured account are stored in the blog.');
@define('MF_ERROR_ONLYFROM', 'E-mail address %s is not the same as configured restriction to %s. Ignoring mail.');
@define('MF_ERROR_NOAUTHOR', 'No author with email address %s.  Skipping email.');

@define('PLUGIN_MF_SPLITTEXT', 'Define a string which separates body/extended parts');
@define('PLUGIN_MF_SPLITTEXT_DESC', 'If you want to use a special string which separates the body and the extended body text in your emails, enter that string here. Serendipity will look for the occurence of that string, and put everything before that string in the body part, and everything after the string in the extended section. Be sure to use a unique string that does not occur as usual text, like "xxx-SPLIT-xxx". If you leave this option empty, the email will be computed as usual - but if you configure a magic string here, some of the other options will be overridden!');

@define('PLUGIN_MF_USETEXT', 'Define a string which indicates the text to capture');
@define('PLUGIN_MF_USETEXT_DESC', 'If you want to only match a partial text of your mail to include it, you can specify a magic text here. You will then need to place this magic text inside your E-Mail to indicate that everything between the magic words is captured. Be sure to use a unique string that does not occur as usual text, like "xxx-BLOG-xxx".');
@define('PLUGIN_MF_CRONJOB', 'This plugin supports the Serendipity Cronjob plugin. Go and install it if you want scheduled execution.');

@define('PLUGIN_MF_TEXTPREF', 'Text preference');
@define('PLUGIN_MF_TEXTPREF_DESC', 'Some devices send mails that contain your input in both plaintext and HTML, so that you would usually get duplicate texts. With this option you can indicate which text type you want to prefer.');
@define('PLUGIN_MF_TEXTPREF_BOTH', 'Both');
@define('PLUGIN_MF_TEXTPREF_HTML', 'HTML');
@define('PLUGIN_MF_TEXTPREF_PLAIN', 'Plain Text');

@define('PLUGIN_MF_USEDATE', 'Prefer date of the incoming E-Mail instead of arrival time');
@define('PLUGIN_MF_REPLY', 'Detected comment/reply instead of blog entry.');
@define('PLUGIN_MF_REPLY_ERROR1', 'Could not find an entry matching the email\'s subject. Mail not saved.');
@define('PLUGIN_MF_REPLY_ERROR2', 'Could not save comment.');

@define('PLUGIN_MF_SUBFOLDER', 'Save attachments in subdirectories like 2010/02/ for chronological order?');
@define('PLUGIN_MF_DEBUG', 'Save debugging messages to uploads/popfetcher-YYYY-MM.log?');

@define('THUMBNAIL_VIEW', 'View Thumbnail in Entry Body');
@define('THUMBNAIL_VIEW_DESC', 'If you want to have a thumbnail view of your attached pictures in the entries body. If set to "no", the full picture will be displayed.');

@define('PLUGIN_MF_DEBUGMAIL', 'For developers: You can enter a filename (including path) here to a EML file to debug popfetcher with such file');

