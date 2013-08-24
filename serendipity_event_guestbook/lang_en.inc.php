<?php #

/**
 *  @version 3.41
 *  @file serendipity_event_guestbook.php, langfile(en) v.3.41 - 2013-08-24 Ian
 *  @translated 
 *  @author Ian
 *  @revisionDate 2013-08-24
 */

@define('PLUGIN_GUESTBOOK_HEADLINE', 'Headline');
@define('PLUGIN_GUESTBOOK_HEADLINE_BLAHBLAH', 'The headline of the page.');
@define('PLUGIN_GUESTBOOK_TITLE', 'Guestbook');
@define('PLUGIN_GUESTBOOK_TITLE_BLAHBLAH', 'Shows a guestbook inside your blog with your normal blog design.');
@define('PLUGIN_GUESTBOOK_PERMALINK', 'Permalink');
@define('PLUGIN_GUESTBOOK_PERMALINK_BLAHBLAH', 'Defines a permalink for the URL. Needs the absolute HTTP path and needs to end with .htm or .html!');
@define('PLUGIN_GUESTBOOK_PAGETITLE', 'Static Pagetitle & URL');
@define('PLUGIN_GUESTBOOK_PAGETITLE_BLAHBLAH', 'Staticpage title of page. Attention: this also defines the URL of the page (index.php?serendipity[subpage]=name)');

@define('PLUGIN_GUESTBOOK_FORMORDER', 'Guestbook form');
@define('PLUGIN_GUESTBOOK_FORMORDER_BLAHBLAH', 'Choose where to place the guestbook form.');
@define('PLUGIN_GUESTBOOK_FORMORDER_TOP', 'Top');
@define('PLUGIN_GUESTBOOK_FORMORDER_BOTTOM', 'Bottom');
@define('PLUGIN_GUESTBOOK_FORMORDER_POPUP', 'Popup');

@define('PLUGIN_GUESTBOOK_EMAILADMIN', 'Send e-mail to admin');
@define('PLUGIN_GUESTBOOK_EMAILADMIN_BLAHBLAH', 'If true, the admin gets an e-mail for each new entry.');
@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN', 'E-mail of admin');
@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN_BLAHBLAH', 'Please insert a valid e-mail if you want to receive e-mail notifications.');
@define('PLUGIN_GUESTBOOK_SHOWEMAIL', 'Ask for user\'s e-mail?');
@define('PLUGIN_GUESTBOOK_SHOWEMAIL_BLAHBLAH', 'Do you want a field for the e-mail of the user?');
@define('PLUGIN_GUESTBOOK_SHOWURL', 'Ask for user\'s homepage?');
@define('PLUGIN_GUESTBOOK_SHOWURL_BLAHBLAH', 'Do you want a field for the homepage of the user?');
@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA', 'Show Captchas?');
@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA_BLAHBLAH', 'Do you want to use CAPTCHAS (requires Spamblock plugin activated)');
@define('PLUGIN_GUESTBOOK_NUMBER', 'Entries per page');
@define('PLUGIN_GUESTBOOK_NUMBER_BLAHBLAH', 'How many entries do you want to display per page?');
@define('PLUGIN_GUESTBOOK_WORDWRAP', 'Characters per line (Wordwrap)');
@define('PLUGIN_GUESTBOOK_WORDWRAP_BLAHBLAH', 'After how many characters shall a new line be inserted?');
@define('PLUGIN_GUESTBOOK_ERROR_DATA', 'An error occurred during processing');

@define('PLUGIN_GUESTBOOK_EMAIL', 'E-mail address');
@define('PLUGIN_GUESTBOOK_INTRO', 'Introductory Text (optional)');
@define('PLUGIN_GUESTBOOK_MESSAGE', 'Message');
@define('PLUGIN_GUESTBOOK_SENT', 'Text after message has been sent');
@define('PLUGIN_GUESTBOOK_SENT_HTML', 'Your message has been successfully mailed!');
@define('PLUGIN_GUESTBOOK_ERROR_HTML', 'An error occured while posting the message!');
@define('PLUGIN_GUESTBOOK_ERROR_DATA', 'Name, e-Mail and your message must not be an empty string.');
@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT', 'Format as article?');
@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT_BLAHBLAH', 'If enabled, the output is automatically formatted as an article (colors, borders, etc.) (default: yes)');
@define('PLUGIN_GUESTBOOK_CAPTCHAWARNING', '');
@define('PLUGIN_GUESTBOOK_PROTECTION', 'E-mail will be converted like this: user at email dot com');
@define('PLUGIN_GUESTBOOK_DBDONE', 'Guestbook entry saved!');
@define('PLUGIN_GUESTBOOK_DBDONE_APP', '(As soon as it gets approved, it will show up in guestbook.)');
@define('PLUGIN_GUESTBOOK_USER_LOGGEDOFF', 'User has logged of.');
@define('PLUGIN_GUESTBOOK_USERSDATE_OF_ENTRY', 'wrote');
@define('PLUGIN_GUESTBOOK_UNKNOWN_ERROR', 'Unknown error! Please contact admin of this site');
@define('PLUGIN_GUESTBOOK_TIMESTAMP_THE', 'the');
@define('PLUGIN_GUESTBOOK_ALTER_OLDTABLE_DONE', 'Database table successfully ALTERed.');
@define('PLUGIN_GUESTBOOK_INSTALL_NEWTABLE_DONE', 'Database table successfully installed.');
@define('PLUGIN_GUESTBOOK_SUBMITFORM', 'Create new guestbook entry');

@define('BODY', 'Entry');
@define('SUBMIT', 'Submit entry');
@define('REFRESH', 'Please refresh your original page to see your new entry.');

@define('GUESTBOOK_NEXTPAGE', 'next page');
@define('GUESTBOOK_PREVPAGE', 'prev page');

@define('TEXT_DELETE', 'delete');
@define('TEXT_SAY', 'said');
@define('TEXT_EMAIL', 'E-mail');
@define('TEXT_NAME', 'Name');
@define('TEXT_HOMEPAGE', 'Homepage');
@define('TEXT_EMAILSUBJECT', 'New guestbook entry');
@define('TEXT_CONVERTBOLDUNDERLINE', 'Enclosing asterisks marks text as bold (*word*), underscore are made via _word_.');
@define('TEXT_CONVERTSMILIES', 'Standard emoticons like :-) and ;-) are converted to images.');
@define('TEXT_IMG_DELETEENTRY', 'Delete entry');
@define('TEXT_IMG_LASTMODIFIED', 'last modified');
@define('TEXT_USERS_HOMEPAGE', 'Guests Homepage');

@define('ERROR_NAMEEMPTY', 'Please insert your name.');
@define('ERROR_TEXTEMPTY', 'Please insert a text.');
@define('ERROR_EMAILEMPTY', 'Please insert a valid e-mail.');
@define('ERROR_DATATOSHORT', 'Your entry should have at least 3, in the comment field at least 10 characters.');
@define('ERROR_NOVALIDEMAIL', 'Your e-mail address appears to be invalid: ');
@define('ERROR_NOINPUT', 'Please enter your name, e-mail address and a comment');
@define('ERROR_ISFALSECAPTCHA', 'The CAPTCHAS of your entry did not match!');
@define('ERROR_NOCAPTCHASET', 'The general CAPTCHA config settings may not be correctly configured!');
@define('ERROR_UNKNOWN', 'An unknown error occured. Please try again or inform the webmaster of this site. Thank you!');
@define('ERROR_OCCURRED', 'There are some errors:');

@define('THANKS_FOR_ENTRY', 'Your guestbook submission:');
@define('WINDOW_CLOSE', 'Close window');
@define('QUESTION_DELETE', 'Do you really want to delete the entry of %s ?');

@define('PAGINATOR_TO', 'To');
@define('PAGINATOR_FIRST', 'First');
@define('PAGINATOR_PREVIOUS', 'Previous');
@define('PAGINATOR_NEXT', 'Next');
@define('PAGINATOR_LAST', 'Last');
@define('PAGINATOR_PAGE', 'Page');
@define('PAGINATOR_RANGE', ' to ');
@define('PAGINATOR_OFFSET', ' of ');
@define('PAGINATOR_ENTRIES', ' entries. ');

/* config v.3.20 additions */
@define('PLUGIN_GUESTBOOK_SHOWAPP', 'Approve entries?');
@define('PLUGIN_GUESTBOOK_SHOWAPP_BLAHBLAH', 'Set guestbook entries generally to be verified by admin before shown in frontend (default: false).');
@define('PLUGIN_GUESTBOOK_APP_ENTRY', 'Your entry %s has been saved');
@define('PLUGIN_GUESTBOOK_CHECKBOXALERT', 'Please check the checkbox of the entry you want to evaluate, change or erase.');
@define('PLUGIN_GUESTBOOK_ADMINBODY', 'Admins answer');
@define('PLUGIN_GUESTBOOK_FORM_RIGHT_BBC', 'Use plain BBcode (strong, italic, unterline, strike, quotes).');
/* config v.3.25 additions */
@define('PLUGIN_GUESTBOOK_AUTOMODERATE', 'Use auto moderate?');
@define('PLUGIN_GUESTBOOK_AUTOMODERATE_BLAHBLAH', 'Set guestbook single entries to be verified by admin before shown in frontend, if the SPAMBLOCK-plugin sets these entries to be moderated first, finding stopword matches (default: false). The guestbook content evaluation will still return captcha checking, if any spam check evaluates true. This differs from normal spamblock behaviour! General- and concurrent Auto-Moderation are not possible!');
@define('PLUGIN_GUESTBOOK_AUTOMODERATE_ERROR', 'Your entry has been classified as auto-moderated. ');
@define('PLUGIN_GUESTBOOK_CONFIG_ERROR', 'Config missmatch alert! Guestbook Option: "Spamblock Auto-Moderation" is set back to false, while showapp is active! Just use one of them, please.');
/* config v.3.26 additions */
@define('PLUGIN_GUESTBOOK_FILTER_ENTRYCHECKS', 'Special body checks');
@define('PLUGIN_GUESTBOOK_FILTER_ENTRYCHECKS_BLAHBLAH', 'List individual guestbook entry body checks. Regular Expressions are allowed, separate strings by semicolons (;). You have to escape special chars with "\". If you leave this field empty, no special checks are done.');
/* config v.3.40 additions */
@define('TEXT_EMAILMODERATE', "\n\nThis guestbook entry was set to moderate (%s)!");
@define('TEXT_EMAILFOOTER', "\n\nSent by Serendipity Guestbook Plugin.");
@define('TEXT_EMAILTEXT', "%s just wrote to your guestbook:\n%s\n%s\n");
@define('ERROR_DATASTRIPPED', 'An active security-filter consists your entry is unvalid. Please send the already cleared entry again.');
@define('ERROR_DATANOTAGS', 'An active plugin-wordfilter consists your entry is unvalid.');
/* config v.3.41 additions */
@define('PLUGIN_GUESTBOOK_FILTER_ENTRYCHECKS_BYPASS', '(Bypassed by USERLEVEL_ADMIN only!)');

/* Backend main constants */
@define('PLUGIN_GUESTBOOK_ADMIN_NAME', 'Guestbook');
@define('PLUGIN_GUESTBOOK_ADMIN_NAME_MENU', 'Guestbook  v.%s - Backend Administration Menu');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC', 'Guestbook - Plugin DB Administration');
@define('PLUGIN_GUESTBOOK_ADMIN_VIEW', 'Guestbook - View entries');
@define('PLUGIN_GUESTBOOK_ADMIN_VIEW_NORESULT', 'There are no approved entries in the guestbook!');
@define('PLUGIN_GUESTBOOK_ADMIN_VIEW_DESC', 'Grouped by date [ youngest above ].');
@define('PLUGIN_GUESTBOOK_ADMIN_APP', 'Guestbook - approve entries');
@define('PLUGIN_GUESTBOOK_ADMIN_APP_DESC', 'Grouped by date [ youngest above ].');
@define('PLUGIN_GUESTBOOK_ADMIN_APP_NORESULT', 'There are no entries to be approved!');
@define('PLUGIN_GUESTBOOK_ADMIN_ERASE', 'Guestbook - Erase entries');
@define('PLUGIN_GUESTBOOK_ADMIN_ADD', 'Guestbook - Add entries');
@define('PLUGIN_GUESTBOOK_ADMIN_DROP_SURE', 'Do you really want to erase the guestbook database table with all data completly? Please confirm here!');
@define('PLUGIN_GUESTBOOK_ADMIN_DROP_OK', 'Your %s database table was successful erased!');
@define('PLUGIN_GUESTBOOK_ADMIN_DUMP_SELF', 'Before continuing you should for sure make a mysql dump via PhpMyAdmin or via the above backup link!');
/* backend database (dbc) administration constants */
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP', 'DB Administration - dump');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_DESC', 'backup your guestbook table from database');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_TITLE', 'dump guestbook table values');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_DONE', 'Your guestbook database table has been backuped successfully!');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT', 'DB Administration - insert');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_DESC', 'insert into guestbook table in database');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_TITLE', 'insert guestbook db values');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_MSG', 'Since this is not trivial, please use admin tools like phpMyAdmin to re-fill the database!');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE', 'DB Administration - erase');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE_DESC', 'Remove the guestbook database table');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE_TITLE', 'Erase guestbook table');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DELFILE_MSG', 'Database table sql file <u>%s</u> erased successfully');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD', 'DB Administration - download');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_DESC', 'Download the guestbook database table dumps');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_TITLE', 'Download guestbook table dumps');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_MSG', 'There is no guestbook database table backup!');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_DESC', 'There is no guestbook database table');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_TITLE', 'Administration - error');
@define('PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_NOBACKUP', 'The selected database table could not be dumped!');

//
//  serendipity_plugin_guestbook.php
//
@define('PLUGIN_GUESTSIDE_NAME', 'Guestbook Sidebar');
@define('PLUGIN_GUESTSIDE_BLAHBLAH', 'Display the latest guestbook items in the sidebar');
@define('PLUGIN_GUESTSIDE_TITLE', 'Item Title');
@define('PLUGIN_GUESTSIDE_TITLE_BLAHBLAH', 'Set the title for the plugin');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL', 'Show e-mail');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL_BLAHBLAH', 'Should the e-mail address of the writer be displayed?');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE', 'Show homepage');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE_BLAHBLAH', 'Should the homepage of the writer be displayed?');
@define('PLUGIN_GUESTSIDE_MAXCHARS', 'Max. characters');
@define('PLUGIN_GUESTSIDE_MAXCHARS_BLAHBLAH', 'The content length in characters');
@define('PLUGIN_GUESTSIDE_MAXITEMS', 'Max. items');
@define('PLUGIN_GUESTSIDE_MAXITEMS_BLAHBLAH', 'Set the number of items to be displayed');
@define('PLUGIN_GUESTSIDE_NOENTRIES', 'No guestbook entries available.');

