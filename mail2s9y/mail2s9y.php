#!/usr/local/bin/php
<?php
#
# mail2s9y.php, 0.7
# -----------------
#
# Seperate PHP-Script to allow email blogging.
# REQUIRES: PHP CLI-binary, Linux/Cygwin(?), local Mail installation.
#
# Contributed by Sebastian Nohn <sebastian@nohn.net>, Gijs van Tulder <gvtulder@gmx.net>
# Implemented by the Garvin Hicking <me@supergarv.de> of the s9y group (www.s9y.org)
#
#
# Changes:
# --------
#
# 0.7 (2005-05-30): Needs Serendipity >= 0.7 now to properly import categories
# 0.6 (2004-04-13): Update with patches from amonthera (related to lowercasing attributes)
# 0.5 (2004-02-20): An security update by Alex Copeland, who pointed out that images could be uploaded without authentication.
# 0.4 (2004-01-19): Another update from Bjoern Schotte, who added interactivity to s9y. It will now mail back to ask for a category for the item.
# 0.3 (2004-01-13):
#                   Automatic URL replacement (translates http://... and other common protocols into hyperlinks). Thanks to Bjoern Schotte for the patch!
#                   Made Login modes working for s9y 0.5-CVS again
# 0.2 (2003-12-02): Beautified code
# 0.1 (2003-12-01): 3 different authentication methods are now available (security issues)
#                   Resets any cookie/session variables to block webrequests to this page
#
# To get this to work, do the following:
# --------------------------------------
#
# 1. Possibly adjust the first line of this script to point to your PHP CLI-binary. Put the package
#    PEAR-Package Mail_Mime (http://pear.php.net/get/Mail_Mime) into your s9y/bundled-libs folder, so
#    that you have an existing s9y/bundled-libs/Mail/mimeDecode.php file.
#
# 2. Make your local MTA recognize an E-Mail adress to be responsible for s9y. In most setups,
#    just add the following line to your "/etc/aliases" file:
#
#    s9y: "|/path/to/mail2s9y.php [username] [password]"
#
#    The name 's9y' refers to the email account you chose to use for your local mail server.
#    Of course, change the path to something valid.
#
#    If you use the 'cmdline' authentication method (configuration see below) you have to provide
#    the [username] and [password] credentials to your s9y-installation. If
#    password-security is important to you, use a .procmail forwarding rule and set appropriate
#    file permissions to your .procmail file (0600). However, the preferred authentication method
#    is 'mailbody' and should be used to disallow anybody to mail a blog entry to your special
#    email account, if ever exposed to the public.
#
#    If you don't know how to setup an account or adjust the line above to a .procmail rule,
#    you most probably don't want to use this script at all.
#
# 3. Adjust the variable $params['s9ypath'] below to point to your s9y installation.
#
# 4. MAKE SURE, that your mail-account user is in the same group as the owner of the file
#    'serendipity_config_local.inc.php'! Otherwise, your configuration can't be read.
#    Usually, the file belongs to the webserver, so if you don't want to stick the user into
#    the same group, you have to change the ownership of the file to your target user. Bear
#    in mind, that the original permission ('ug+rwx') are updated any time you make changes to
#    your s9y-setup.
#
# 5. Write an E-Mail to your chose local address. The subject will be the title for your entry,
#    the body your text and possible attachments will be uploaded to your s9y directory structure.
#
#
# Also make sure that...
# ----------------------
#
# * Preferably your E-Mail blog-message should contain no unwanted
#   linebreaks after the usual 70 char limit. If your E-Mail client does
#   that to you, try to configure it not to; otherwise this may result
#   in an ugly HTML display in your blog, and/or broken HTML tags you could
#   have posted
#
# * If you use automatic URL rewriting (which transforms http://, ftp://,
#   ...) links into valid HTML, please take care that this url is without
#   any special characters (brackets, punctuation characters, ...), or else
#   you may get those characters included in the auto-guessed URL.
#
# * If you use Sendmail versions above 8.12, it requires you to create
#   a symbolic link in /etc/smrsh or /etc/mail/smrsh pointing to the
#   mail2s9y.php script to allow sendmail permissions to execute the script
#   from an /etc/mail/aliases entry (thanks to Thomas Brown for pointing
#   this out!)
#
# * Feedback is appreciated! If anything doesn't work, please post your
#   problems to either the s9y-support forums/mailinglists or mail the
#   author personally.

// ---------------------------------------------------
// CONFIGURATION                                     -
// ---------------------------------------------------
$params = array(
            's9ypath'        => '/home/superdbl/cvs/serendipity/',
            # PATH to your s9y installation

            'auth'           => 'mailsubject',
            # How will you pass your username/password? Possible values are:
            #
            # 'mailbody'   : The username/password is extracted from the first line of the body of the mail
            #                and has to be formatted like: "(username:password)<linebreak>Usual body here..."
            #                (the '(' and ')' characters are required!)
            #
            # 'mailsubject': The username/password is extracted from the subject and has to be formatted
            #                like: "(username:password)Usual Subject here..."
            #                (the '(' and ')' characters are required!)
            #
            # 'cmdline':     The username/password is provided in your /etc/aliases file (see point 2 from the
            #                documentation above). In other setups/cases, just pass username as first and password
            #                as the second commandline option to mail2s9y.phps

            'logfile'        => '/var/vpopmail/domains/supergarv.de/mail2s9y/mail2s9y.log',
            # If you want to log every received email, set the path to where a logfile shall be written. Remeber that
            # it needs to be writeable.

            'include_bodies' => TRUE,
            'decode_bodies'  => TRUE,
            'decode_headers' => TRUE,
            # MIMEDecode settings

            'category'       => '',
            # If you want to have your postings sorted to a special s9y category, insert the id of that category here.
            # If left empty, mail2s9y will mail you back to ask in which category to put your category.
            # REMEMBER TO PUT YOUR USERNAME/PASSWORD BACK IN THE RESPONSE MAIL, DEPENDING ON YOUR AUTH-METHOD!

            'nl2br'          => false,
            # Use nl2br() in order to get newlines from mail translated to br tags.

            'allow_comments' => 'true',
            # If you want to disallow entries coming from your E-Mails to be commentable, set this to 'false'

            'input'          => ''
            # Initialization
);
// ---------------------------------------------------

$inc = @ini_get('include_path');
@ini_set('include_path', $params['s9ypath'] . ':.:' . $params['s9ypath'] . 'bundled-libs/');

// Constants
@define('MAIL2S9Y_AUTHENTICATION_FAILED', 'Authentication failed using %s.');
@define('MAIL2S9Y_AUTHENTICATION_GRANTED', 'Authentication granted using %s');
@define('MAIL2S9Y_MAILINFO', 'Mail received from "%s", subject "%s". %d bytes in the article, %d images provided.');
@define('MAIL2S9Y_POSTING_FAILED', 'Posting failed');
@define('MAIL2S9Y_POSTING_SUCCEEDED', 'Posting succeeded');
@define('MAIL2S9Y_ALREADY_BLOGGED', "Error: The following images have already been blogged:\n\n%s");
@define('MAIL2S9Y_CATSELECTOR_BEGIN', 'BEGIN catselector');
@define('MAIL2S9Y_CATSELECTOR_END', 'END catselector');

// Safety: Reset any session to not post anything when viewed from the web
unset($_SESSION); unset($HTTP_SESSION_VARS);
unset($_GET); unset($HTTP_GET_VARS);
unset($_POST); unset($HTTP_POST_VARS);
unset($_REQUEST); unset($HTTP_REQUEST_VARS);
unset($_COOKIE); unset($HTTP_COOKIE_VARS);
unset($serendipity);

// Custom functions
function is_categorizer($body) {
    if (!preg_match('=^.*#([0-9]+) ' . ENTRY_SAVED . '.*$=msiU', $body, $entryidmatch)) {
        return false;
    }

    if (preg_match('=^.*\-\-\- ' . MAIL2S9Y_CATSELECTOR_BEGIN . ' \-\-\-\n(.*)\-\-\- ' . MAIL2S9Y_CATSELECTOR_END . ' \-\-\-.*$=msiU', $body, $matches)) {
        if (preg_match('=^.*\[X\] (.{0,3}[0-9]{1,4}) (.*)\n.*$=msiU', $matches[1], $matches)) {
            $GLOBALS['entryid'] = $entryidmatch[1];
            return $matches[1];
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function url_replace($str) {
    $pattern = '#(^|[^\"=]{1})(http://|https://|ftp://|mailto:|news:)([^\s<>]+)([\s\n<>]|$)#sim';
    $str = preg_replace($pattern, "\\1<a href=\"\\2\\3\">\\2\\3</a>\\4", $str);

    return $str;
}

// S9y hook
chdir($params['s9ypath']);
if (file_exists('./serendipity_config_local.inc.php')) {
    include('serendipity_config.inc.php');
}

if ($params['auth'] == 'cmdline') {
    $serendipity['POST']['user'] = &$argv[1];
    $serendipity['POST']['pass'] = &$argv[2];
}

// PEAR hook
require_once('bundled-libs/Mail/mimeDecode.php');

// Read the eMail from stdin
$fd = fopen('php://stdin', 'r');
while (!feof($fd)) {
    $input .= fread($fd, 1024);
}
fclose($fd);

$log = false;
if ($params['logfile'] != '') {
    $log = @fopen($params['logfile'], 'a');
    if (!is_resource($log)) {
        unset($log);
        function logger($msg) {
            return true;
        }
    } else {
        function logger($msg) {
            global $log;
            fwrite($log, date('[Y-m-d H:i] ') . $msg . "\n");
        }
    }
}

$params['input']    = &$input;

// Decode Mail
$structure = Mail_mimeDecode::decode($params);

// Subject
$subject   = $structure->headers['subject'];

// From
$from      = $structure->headers['from'];

// Recipient
$to        = $structure->headers['to'];

$post       = 0;
$falsefile  = '';
$images     = 0;
$writefiles = array();

// Is it a multipart-message?
if(is_array($structure->parts)) {
    foreach ($structure->parts as $part) {
        if (strtolower($part->ctype_primary) == 'text') {
            // Body
            $body = &$part->body;
        }

        if (strtolower($part->ctype_primary) == 'image') {
            // Image
            $image     = $params['s9ypath']      . 'uploads/' . $part->d_parameters['filename'];
            $url_image = $serendipity['BaseURL'] . 'uploads/' . $part->d_parameters['filename'];

            // Does this Image already exist?
            if (file_exists($image)) {
                $falsefile .= "$image\n";
                $post++;
            } else {
                $writefiles[] = array('image' => $image, 'data' => $part->body);
                $body .= '<br /><img src="' . $url_image . '" alt="' . $subject . '"><br />';
                $images++;
            }
        }
    }
} else {
    // No multipart-message, so this is the body:
    $body = &$structure->body;
}

if ($params['auth'] == 'mailbody') {
    preg_match('@^\(([^:]*):(.*)\)@', $body, $matches);
    $body = trim(preg_replace('@^\(' . preg_quote($matches[1]) . ':' . preg_quote($matches[2]) . '\)@', '', $body));
    $serendipity['POST']['user'] = $matches[1];
    $serendipity['POST']['pass'] = $matches[2];
} elseif ($params['auth'] == 'mailsubject') {
    preg_match('@^\(([^:]*):(.*)\)@', $subject, $matches);
    $subject = trim(preg_replace('@^\(' . preg_quote($matches[1]) . ':' . preg_quote($matches[2]) . '\)@', '', $subject));
    $serendipity['POST']['user'] = $matches[1];
    $serendipity['POST']['pass'] = $matches[2];
}

$serendipity['POST']['auto'] = 'true';
if (serendipity_userLoggedIn() || (function_exists('serendipity_login') && serendipity_login())) {
    logger(sprintf(MAIL2S9Y_AUTHENTICATION_GRANTED, $params['auth']));
} else {
    logger(sprintf(MAIL2S9Y_AUTHENTICATION_FAILED, $params['auth']));
    die(sprintf(MAIL2S9Y_AUTHENTICATION_FAILED, $params['auth']));
    mail($from, MAIL2S9Y_POSTING_FAILED, sprintf(MAIL2S9Y_AUTHENTICATION_FAILED, $params['auth']));
}

if (count($writefiles) > 0) {
    foreach($writefiles AS $idx => $filearray) {
        $fd = fopen($filearray['image'], 'w');
        fwrite($fd, $filearray['data']);
        fclose($fd);
    }
}

logger(sprintf(MAIL2S9Y_MAILINFO, $from, $subject, strlen($body), $images));

if ($post > 0) {
    $msg = sprintf(MAIL2S9Y_ALREADY_BLOGGED, $falsefile);
    echo $msg;
    mail($from, MAIL2S9Y_POSTING_FAILED, $msg);
    logger($msg);
} else  {
    logger($body);
    $newbody = url_replace($body);
    if (isset($params['nl2br']) && $params['nl2br']) {
        $newbody = nl2br($newbody);
    }
    logger($body);

    $entry = array(
               'id'             => '',
               'title'          => $subject,
               'timestamp'      => '',
               'body'           => $newbody,
               'extended'       => '',
               'categories'     => array($params['category']),
               'isdraft'        => 'false',
               'allow_comments' => $params['allow_comments']
    );

    $cats = '';
    if (!$cats = is_categorizer($body)) {
        $res = serendipity_updertEntry($entry);
    } else {
        $res = array();
    }

    if (is_string($res)) {
        echo MAIL2S9Y_POSTING_FAILED . ': ' . $res;
        mail($from, MAIL2S9Y_POSTING_FAILED, $res);
        logger(MAIL2S9Y_POSTING_FAILED . ': ' . $res);
    } else {
        $catupdated = false;
        if (!$cats) {
            $msg = '#' . $res . ' ' . ENTRY_SAVED;
        } else {
            serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entrycat WHERE entryid={$entryid}");
            $r = serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}entrycat (entryid, categoryid) VALUES ({$entryid}, {$cats})");

            if (!$r) {
                $msg = MAIL2S9Y_POSTING_FAILED;
            } else {
                $msg = CATEGORY_SAVED;
            }
            $catupdated = true;
        }

        /**
         * mail categories.
         */

        if (empty($params['category']) && !$cats && !$catupdated) {
            $subj = "Re: " . $subject;
            $msg .= "\n\n";
            $msg .= "--- " . MAIL2S9Y_CATSELECTOR_BEGIN . " ---\n\n";
            $c = serendipity_fetchCategories();
            foreach ($c as $v) {
                $msg .= sprintf("[] %4d %s\n", $v['categoryid'], $v['category_name']);
            }
            $msg .= "\n--- " . MAIL2S9Y_CATSELECTOR_END . " ---\n";
        } elseif (empty($params['category'])) {
            $subj = CATEGORY_SAVED;
        } else {
            $subj = MAIL2S9Y_POSTING_SUCCEEDED;
        }

        mail($from, $subj, $msg, "From: " . $to);
        logger($msg);
    }
}

if ($log) fclose($log);
?>