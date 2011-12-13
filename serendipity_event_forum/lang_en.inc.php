<?php # $Id: lang_en.inc.php,v 1.11 2008/02/12 21:14:23 slothman Exp $

# (c) 2005 by Alexander 'dma147' Mieland, http://blog.linux-stats.org, <dma147@linux-stats.org>
# Contact me on IRC in #linux-stats, #archlinux, #archlinux.de, #s9y on irc.freenode.net

# english language file

/**
 *  @version $Revision: 1.11 $
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define("PLUGIN_FORUM_TITLE", "Discussion forum / phpBB comment mirroring");
@define("PLUGIN_FORUM_DESC", "Provides a complete discussion forum to your users. Can alternatively provide to mirror comments into a phpBB installation.");
@define('PLUGIN_FORUM_PAGETITLE', 'Page title');
@define('PLUGIN_FORUM_PAGETITLE_BLAHBLAH', 'title of the page');
@define('PLUGIN_FORUM_HEADLINE', 'Headline');
@define('PLUGIN_FORUM_HEADLINE_BLAHBLAH', 'The headline of the page.');
@define('PLUGIN_FORUM_PAGEURL', 'Static URL');
@define('PLUGIN_FORUM_PAGEURL_BLAHBLAH', 'Defines the URL of the page (index.php?serendipity[subpage]=name)');
@define("PLUGIN_FORUM_UPLOADDIR", "Absolute server path to upload directory");
@define("PLUGIN_FORUM_UPLOADDIR_BLAHBLAH", "default: ".$serendipity['serendipityPath'].'files');
@define("PLUGIN_FORUM_DATEFORMAT", "The format of the entry's actual date, using PHPs date() variables. (Default: \"Y/m/d\")");
@define("PLUGIN_FORUM_TIMEFORMAT", "Timeformatting");
@define("PLUGIN_FORUM_TIMEFORMAT_BLAHBLAH", "The format of the entry's actual time, using PHPs date() variables. (Default: \"h:ia\")");
@define("PLUGIN_FORUM_BGCOLOR_HEAD", "Background color of titlebar");
@define("PLUGIN_FORUM_BGCOLOR_HEAD_BLAHBLAH", "The background color of all titlebars");
@define("PLUGIN_FORUM_BGCOLOR1", "1. background color");
@define("PLUGIN_FORUM_BGCOLOR2", "2. background color");
@define("PLUGIN_FORUM_APPLY_MARKUP", "Should markup-plugins be used?");
@define("PLUGIN_FORUM_APPLY_MARKUP_BLAHBLAH", "If yes, all markup-plugins, if installed, would be used for formatting the posts (BBCodes, smilies, galleryimage, etc...)");
@define("PLUGIN_FORUM_ITEMSPERPAGE", "Items per page");
@define("PLUGIN_FORUM_ITEMSPERPAGE_BLAHBLAH", "How many items should be shown per page (threads/posts), default: 15");
@define("PLUGIN_FORUM_USE_CAPTCHAS", "Use spamblock");
@define("PLUGIN_FORUM_USE_CAPTCHAS_BLAHBLAH", "Should the spamblock plugin be used (captchas)");
@define("PLUGIN_FORUM_UNREG_NOMARKUPS", "No markups for unregistered users");
@define("PLUGIN_FORUM_UNREG_NOMARKUPS_BLAHBLAH", "Should markups only be allowed for registered users?");
@define("PLUGIN_FORUM_FILEUPLOAD_REGUSER", "Allow file-upload for registered users");
@define("PLUGIN_FORUM_FILEUPLOAD_REGUSER_BLAHBLAH", "Should the file-upload in posts be allowed for registered users?");
@define("PLUGIN_FORUM_FILEUPLOAD_GUEST", "Allow file-upload for guests");
@define("PLUGIN_FORUM_FILEUPLOAD_GUEST_BLAHBLAH", "Should the file-upload in posts be allowed for guests? (NOT recommended!!!)");
@define("PLUGIN_FORUM_HOW_MANY_FILES_IN_ONE_POST", "Maximum files in one post");
@define("PLUGIN_FORUM_HOW_MANY_FILES_IN_ONE_POST_BLAHBLAH", "How many files at all should be allowed in one post?");
@define("FORUM_HOW_MANY_FILEUPLOADS_WHEN_POSTING", "Number of simultaneous file-uploads");
@define("FORUM_HOW_MANY_FILEUPLOADS_WHEN_POSTING_BLAHBLAH", "How many files can be uploaded when writing or editing a post");
@define("FORUM_PLUGIN_HOW_MANY_FILEUPLOADS_AT_ALL", "How many file-uploads per user");
@define("FORUM_PLUGIN_HOW_MANY_FILEUPLOADS_AT_ALLBLAHBLAH", "How many file-uploads at all should be allowed per registered user? Attention: if allowing file-uploads for guests, they will be able to upload as many files they want, because this option can not check the file-uploads of guests!!!");
@define("FORUM_PLUGIN_NOTIFYMAIL_FROM", "Notify mails: From email address");
@define("FORUM_PLUGIN_NOTIFYMAIL_FROM_BLAHBLAH", "The email address from which the notify-mails should be sent (From field)");
@define("FORUM_PLUGIN_NOTIFYMAIL_NAME", "Notify mails: From name");
@define("FORUM_PLUGIN_NOTIFYMAIL_NAME_BLAHBLAH", "The name of the sender of the notify-mails (From field)");
@define("FORUM_PLUGIN_ADMIN_NOTIFY", "Admin notification");
@define("FORUM_PLUGIN_ADMIN_NOTIFY_BLAHBLAH", "Should the admin get a nofify-mail when a new topic or reply was posted?");
@define("PLUGIN_FORUM_COLORTODAY", "Color for the \"Today\" string");
@define("PLUGIN_FORUM_COLORYESTERDAY", "Color for the \"Yesterday\" string");


@define("PLUGIN_FORUM_NO_BOARDS", "No boards defined!");
@define("PLUGIN_FORUM_NO_ENTRIES", "No threads");
@define("PLUGIN_FORUM_BOARDS", "Boards");
@define("PLUGIN_FORUM_THREADS", "Threads");
@define("PLUGIN_FORUM_POSTS", "Posts");
@define("PLUGIN_FORUM_NO_POSTS", "This thread has no posts!");
@define("PLUGIN_FORUM_LASTPOST", "Last post");
@define("PLUGIN_FORUM_LASTREPLY", "Last reply");
@define("PLUGIN_FORUM_NO_THREADS", "No Threads found");
@define("PLUGIN_FORUM_THREADTITLE", "Threadtitle");
@define("PLUGIN_FORUM_POSTTITLE", "Headline");
@define("PLUGIN_FORUM_REPLIES", "Replies");
@define("PLUGIN_FORUM_VIEWS", "Views");
@define("PLUGIN_FORUM_NO_REPLIES", "No replies");
@define("PLUGIN_FORUM_AUTHOR", "Author");
@define("PLUGIN_FORUM_MESSAGE", "Message");
@define("PLUGIN_FORUM_BACKTOTOP", "Back to top");
@define("PLUGIN_FORUM_ALT_REOPEN", "Reopen this thread...");
@define("PLUGIN_FORUM_ALT_CLOSE", "Close this thread...");
@define("PLUGIN_FORUM_ALT_MOVE", "Move this thread to another board...");
@define("PLUGIN_FORUM_ALT_DELETE", "Delete this thread...");
@define("PLUGIN_FORUM_ALT_DELETE_POST", "Delete this reply...");
@define("PLUGIN_FORUM_ALT_REPLY", "Reply to this thread...");
@define("PLUGIN_FORUM_ALT_QUOTE", "Reply to this thread by quoting this post...");
@define("PLUGIN_FORUM_ALT_EDIT", "Edit your reply...");
@define("PLUGIN_FORUM_ALT_DELETE", "Delete this reply...");
@define("PLUGIN_FORUM_ALT_UNREAD", "not read before or new replies were made...");
@define("PLUGIN_FORUM_ALT_READ", "already read...");
@define("PLUGIN_FORUM_ALT_DIRECTGOTOPOST", "direct goto post...");
@define("PLUGIN_FORUM_MARKUPS", "Following markups can be used if enabled by the administrator:<br />&nbsp; - <a href=\"http://www.s9y.org/forums/faq.php?mode=bbcode\" target=\"_blank\">BBCode</a><br />&nbsp; - Smilies<br />&nbsp; - GalleryImage<br />");
@define("PLUGIN_FORUM_GUEST", "Guest");
@define("PLUGIN_FORUM_CONFIRM_DELETE_POST", "Do you really want to delete this post?");
@define("PLUGIN_FORUM_ORDER", "Reorder");
@define("PLUGIN_FORUM_BOARDNAME", "Board name");
@define("PLUGIN_FORUM_BOARDDESC", "Description");
@define("PLUGIN_FORUM_REALLY_DELETE_BOARDS", "Are you really sure, that you want to delete {num} board(s)?");
@define("PLUGIN_FORUM_REALLY_DELETE_THREAD", "Are you really sure, that you want to delete the thread");
@define("PLUGIN_FORUM_DELETE_OR_MOVE", "Should the threads be deleted or moved to another board?");
@define("PLUGIN_FORUM_WHERE_TO_MOVE", "Choose the board or delete them:");
@define("PLUGIN_FORUM_ADD_BOARD", "Add new board");
@define("PLUGIN_FORUM_PAGES", "Pages");
@define("PLUGIN_FORUM_MOVE_THREAD", "To which board do you want to move the thread");
@define("PLUGIN_FORUM_MOVE", "Move");
@define("PLUGIN_FORUM_FROM_BOARD", "from board");
@define("PLUGIN_FORUM_TO_BOARD", "to board");
@define("PLUGIN_FORUM_SUBMIT", "Submit");
@define("PLUGIN_FORUM_RESET", "Reset");
@define("PLUGIN_FORUM_REG_USER", "Registered user");
@define("PLUGIN_FORUM_POSTS", "Posts");
@define("PLUGIN_FORUM_VISITS", "Visits");
@define("PLUGIN_FORUM_UPLOAD_FILE","file upload");
@define("PLUGIN_FORUM_DOWNLOADCOUNT", "Downloads:");
@define("PLUGIN_FORUM_REST_UPLOAD_USER", "possible uploads left for the user");
@define("PLUGIN_FORUM_REST_UPLOAD_POST", "possible uploads left for this post");
@define("PLUGIN_FORUM_ANNOUNCEMENT", "Is this an announcement?");
@define("PLUGIN_FORUM_SUBSCRIBE", "Subscribe to this thread?");
@define("PLUGIN_FORUM_UNSUBSCRIBE", "Unsubscribe from this thread?");
@define("PLUGIN_FORUM_TODAY", "Today");
@define("PLUGIN_FORUM_YESTERDAY", "Yesterday");
@define("PLUGIN_FORUM_UPLOAD_OVERWRITE", "Overwrite");
@define("PLUGIN_FORUM_UPLOAD_OVERWRITE_BLAHBLAH", "Should an already existent upload be overwritten with this upload?<br />Attention: This will overwrite *all* files with the same name and which are owned by you!");

@define("PLUGIN_FORUM_ERR_MISSING_THREADTITLE", "Error: Threadtitle not provided or too short (min. 4 characters)! Entry not saved!");
@define("PLUGIN_FORUM_ERR_MISSING_MESSAGE", "Error: Threadtext not provided or too short (min. 4 characters)! Entry not saved!");
@define("PLUGIN_FORUM_ERR_THREAD_CLOSED", "Error: The thread to which you are trying to reply is closed! Entry not saved!");
@define("PLUGIN_FORUM_ERR_EDIT_NOT_ALLOWED", "Error: You are not allowed to edit this post! Entry not saved!");
@define("PLUGIN_FORUM_ERR_DELETE_NOT_ALLOWED", "Error: You are not allowed to delete this post! Entry not saved!");
@define("PLUGIN_FORUM_ERR_DOUBLE_THREAD", "Error: You have already sent this thread! Entry not saved!");
@define("PLUGIN_FORUM_ERR_DOUBLE_POST", "Error: You have already sent this reply! Entry not saved!");
@define("PLUGIN_FORUM_ERR_POST_INTERVAL", "Error: the posting interval was too short! Entry not saved!");
@define("PLUGIN_FORUM_ERR_WRONG_CAPTCHA_STRING", "Error: Wrong captcha string provided! Entry not saved!");
@define("PLUGIN_FORUM_ERR_FILE_TOO_BIG", "File too big! (not saved!)");
@define("PLUGIN_FORUM_ERR_FILE_NOT_COPIED", "File can not be copied! (reason unknown)");


// email notify
@define("PLUGIN_FORUM_EMAIL_NOTIFY_SUBJECT", "A new post was written by {postauthor} in our forum on {blogurl}!");

@define("PLUGIN_FORUM_EMAIL_NOTIFY_PART1", "Hello,

{postauthor} wrotes a new reply to the thread
\"{threadtitle}\"
in our forum on
{forumurl}.

");

@define ("PLUGIN_FORUM_EMAIL_NOTIFY_PART2", "This is, what he wrote:

----------------------------------------------------------------------
\"{replytext}\"
----------------------------------------------------------------------

");

@define ("PLUGIN_FORUM_EMAIL_NOTIFY_PART3", "You can visit this thread by clicking the following link:
{posturl}

");
@define('PLUGIN_FORUM_IMGDIR', 'Path to this plugin');
@define('PLUGIN_FORUM_IMGDIR_DESC', 'The HTTP path to where this plugin is stored. Used to output image files, for example.');


@define('PLUGIN_FORUM_PHPBB_MIRROR', 'Enable phpBB mirroring?');
@define('PLUGIN_FORUM_PHPBB_MIRROR_DESC', 'If enabled, new blog entries you post will be mirrored into a phpBB installation. Comments will then be made to the phpBB installation instead of into the serendipity blog.');

@define('FORUM_PLUGIN_PHPBB_USER', '(optional) phpBB database username');
@define('FORUM_PLUGIN_PHPBB_PW', '(optional) phpBB database password');
@define('FORUM_PLUGIN_PHPBB_NAME', '(optional) phpBB database name');
@define('FORUM_PLUGIN_PHPBB_HOST', '(optional) phpBB database server');
@define('FORUM_PLUGIN_PHPBB_PREFIX', '(optional) phpBB database table prefix');
@define('FORUM_PLUGIN_PHPBB_FORUM', '(optional) phpBB target forum ID');
@define('FORUM_PLUGIN_PHPBB_POSTER', '(optional) phpBB target poster ID');
@define('FORUM_PLUGIN_PHPBB_DISCUSS', 'Discuss this entry on the forum');

@define('FORUM_PLUGIN_NEW_THREAD', 'New thread');

/* vim: set sts=4 ts=4 expandtab : */
