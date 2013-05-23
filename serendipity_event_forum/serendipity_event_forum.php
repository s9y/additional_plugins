<?php

# (c) 2005 by Alexander 'dma147' Mieland, http://blog.linux-stats.org, <dma147@linux-stats.org>
# Contact me on IRC in #linux-stats, #archlinux, #archlinux.de, #s9y on irc.freenode.net

# Adapted for PHPBB3 1-1-2008 R.van Gijn remon@relight.dtdns.net

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

include dirname(__FILE__) . '/include/functions.inc.php';

/////////////////////////////////////////////////////////////////////////////////////////////

@define( "PWD_ALLOW_NUM", ( 1 << 0 ));
@define( "PWD_ALLOW_LC",  ( 1 << 1 ));
@define( "PWD_ALLOW_UC",  ( 1 << 2 ));
@define( "PWD_ALLOW_DFLT", ( PWD_ALLOW_NUM | PWD_ALLOW_LC ));
@define( "PWD_ALLOW_ALL", ( PWD_ALLOW_NUM | PWD_ALLOW_LC  | PWD_ALLOW_UC ));

@define( "BBCODE", '<script type="text/javascript" language="JavaScript">
    document.write(\'<input type="button" class="serendipityPrettyButton input_button" name="insB" value="B" accesskey="b" style="font-weight: bold" onclick="wrapSelection(document.forms[\\\'postform\\\'][\\\'serendipity[comment]\\\'],\\\'[b]\\\',\\\'[/b]\\\')" />\');
    document.write(\'<input type="button" class="serendipityPrettyButton input_button" name="insI" value="I" accesskey="i" style="font-style: italic" onclick="wrapSelection(document.forms[\\\'postform\\\'][\\\'serendipity[comment]\\\'],\\\'[i]\\\',\\\'[/i]\\\')" />\');
    document.write(\'<input type="button" class="serendipityPrettyButton input_button" name="insU" value="U" accesskey="u" style="text-decoration: underline;" onclick="wrapSelection(document.forms[\\\'postform\\\'][\\\'serendipity[comment]\\\'],\\\'[u]\\\',\\\'[/u]\\\')" />\');
    document.write(\'<input type="button" class="serendipityPrettyButton input_button" name="insQ" value="'.QUOTE.'" accesskey="q" style="font-style: italic" onclick="wrapSelection(document.forms[\\\'postform\\\'][\\\'serendipity[comment]\\\'],\\\'[quote]\\\',\\\'[/quote]\\\')" />\');
    document.write(\'<input type="button" class="serendipityPrettyButton input_button" name="insJ" value="img" accesskey="j" onclick="wrapInsImage(document.forms[\\\'postform\\\'][\\\'serendipity[comment]\\\'])" />\');
    document.write(\'<input type="button" class="serendipityPrettyButton input_button" name="insU" value="URL" accesskey="l" onclick="wrapSelectionWithLink(document.forms[\\\'postform\\\'][\\\'serendipity[comment]\\\'])" />\');
    document.write(\'<input type="button" class="serendipityPrettyButton input_button" name="insP" value="PHP" accesskey="p" onclick="wrapSelection(document.forms[\\\'postform\\\'][\\\'serendipity[comment]\\\'],\\\'[php]\\\',\\\'[/php]\\\')" />\');
    document.write(\'<input type="button" class="serendipityPrettyButton input_button" id="insC" name="insC" value="Color" accesskey="l" onclick="wrapSelectionWithColor(document.forms[\\\'postform\\\'][\\\'serendipity[comment]\\\'])" />\');
</script>');

class serendipity_event_forum extends serendipity_event {

    var $debug;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_FORUM_TITLE);
        $propbag->add('description',   PLUGIN_FORUM_DESC);
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('version',       '0.37');
        $propbag->add('author',       'Alexander \'dma147\' Mieland, http://blog.linux-stats.org, dma147@linux-stats.org');
        $propbag->add('stackable',     false);
        $propbag->add('event_hooks',   array(
                                            'entries_header'           => true,
                                            'entry_display'           => true,
                                            'backend_sidebar_entries' => true,
                                            'backend_sidebar_entries_event_display_forum' => true,
                                            'external_plugin'          => true,
                                            'css'                     => true,
                                            'backend_save'            => true,
                                            'backend_publish'         => true,
                                            'frontend_display:html:per_entry' => true,
                                            'frontend_saveComment' => true,
                                            'fetchcomments' => true,
                                            'frontend_display' => true
                                        )
        );
        $propbag->add('configuration', array(
                                            'pagetitle',
                                            'headline',
                                            'pageurl',
                                            'phpbb_mirror',
                                            'phpbb_db_user',
                                            'phpbb_db_pw',
                                            'phpbb_db_host',
                                            'phpbb_db_name',
                                            'phpbb_db_prefix',
                                            'phpbb_forum',
                                            'phpbb_poster',
                                            'uploaddir',
                                            'imgdir',
                                            'dateformat',
                                            'timeformat',
                                            'itemsperpage',
                                            'bgcolor_head',
                                            'bgcolor1',
                                            'bgcolor2',
                                            'color_today',
                                            'color_yesterday',
                                            'use_captchas',
                                            'apply_markup',
                                            'unreg_nomarkups',
                                            'fileupload_reguser',
                                            'fileupload_guest',
                                            'max_simultaneous_fileuploads',
                                            'max_files_per_post',
                                            'max_files_per_user',
                                            'notifymail_from',
                                            'notifymail_name',
                                            'admin_notify'

                                        )
        );
        $propbag->add('groups', array('FRONTEND_FULL_MODS'));
        $this->dependencies = array('serendipity_event_entryproperties' => 'keep');
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch($name) {

           case 'pagetitle' :
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_FORUM_PAGETITLE);
                $propbag->add('description', PLUGIN_FORUM_PAGETITLE_BLAHBLAH);
                $propbag->add('default', 'Discussion forum');
                break;

            case 'headline' :
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_FORUM_HEADLINE);
                $propbag->add('description', PLUGIN_FORUM_HEADLINE_BLAHBLAH);
                $propbag->add('default', 'Your place for discussions');
                break;

            case 'pageurl' :
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_FORUM_PAGEURL);
                $propbag->add('description', PLUGIN_FORUM_PAGEURL_BLAHBLAH);
                $propbag->add('default', 'forum');
                break;

            case 'imgdir':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_FORUM_IMGDIR);
                $propbag->add('description', PLUGIN_FORUM_IMGDIR_DESC);
                $propbag->add('default', $serendipity['serendipityHTTPPath'].'plugins/serendipity_event_forum/');
                break;

            case 'uploaddir':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_FORUM_UPLOADDIR);
                $propbag->add('description', PLUGIN_FORUM_UPLOADDIR_BLAHBLAH);
                $propbag->add('default', $serendipity['serendipityPath'].'/files');
                break;

            case 'dateformat':
                $propbag->add('type', 'string');
                $propbag->add('name', GENERAL_PLUGIN_DATEFORMAT);
                $propbag->add('description', sprintf(PLUGIN_FORUM_DATEFORMAT, 'Y/m/d'));
                $propbag->add('default',     'Y/m/d');
                break;

            case 'timeformat':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_FORUM_TIMEFORMAT);
                $propbag->add('description', sprintf(PLUGIN_FORUM_TIMEFORMAT_BLAHBLAH, 'h:ia'));
                $propbag->add('default',     'h:ia');
                break;

            case 'itemsperpage':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_FORUM_ITEMSPERPAGE);
                $propbag->add('description', PLUGIN_FORUM_ITEMSPERPAGE_BLAHBLAH);
                $propbag->add('default',     15);
                break;

            case 'bgcolor_head':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_FORUM_BGCOLOR_HEAD);
                $propbag->add('description', PLUGIN_FORUM_BGCOLOR_HEAD_BLAHBLAH);
                $propbag->add('default',     '#d9d9d9');
                break;

            case 'bgcolor1':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_FORUM_BGCOLOR1);
                $propbag->add('default',     '#eaeaea');
                break;

            case 'bgcolor2':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_FORUM_BGCOLOR2);
                $propbag->add('default',     '#f2f2f2');
                break;

            case 'color_today':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_FORUM_COLORTODAY);
                $propbag->add('default',     '#ff0000');
                break;

            case 'color_yesterday':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_FORUM_COLORYESTERDAY);
                $propbag->add('default',     '#0000ff');
                break;

            case 'use_captchas':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_FORUM_USE_CAPTCHAS);
                $propbag->add('description', PLUGIN_FORUM_USE_CAPTCHAS_BLAHBLAH);
                $propbag->add('default', 'true');
                break;

            case 'apply_markup':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_FORUM_APPLY_MARKUP);
                $propbag->add('description', PLUGIN_FORUM_APPLY_MARKUP_BLAHBLAH);
                $propbag->add('default', 'true');
                break;

            case 'phpbb_mirror':
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_FORUM_PHPBB_MIRROR);
                $propbag->add('description', PLUGIN_FORUM_PHPBB_MIRROR_DESC);
                $propbag->add('select_values', array('false' => NO,
                                                    '2'     => '2.x',
                                                    '3'     => '3.x',
                                                    '4'     => 'SMF'));
                $propbag->add('default', 'false');
                break;

            case 'unreg_nomarkups':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_FORUM_UNREG_NOMARKUPS);
                $propbag->add('description', PLUGIN_FORUM_UNREG_NOMARKUPS_BLAHBLAH);
                $propbag->add('default', 'false');
                break;

            case 'fileupload_reguser':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_FORUM_FILEUPLOAD_REGUSER);
                $propbag->add('description', PLUGIN_FORUM_FILEUPLOAD_REGUSER_BLAHBLAH);
                $propbag->add('default', 'true');
                break;

            case 'fileupload_guest':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_FORUM_FILEUPLOAD_GUEST);
                $propbag->add('description', PLUGIN_FORUM_FILEUPLOAD_GUEST_BLAHBLAH);
                $propbag->add('default', 'false');
                break;

           case 'max_simultaneous_fileuploads' :
                $propbag->add('type', 'string');
                $propbag->add('name', FORUM_HOW_MANY_FILEUPLOADS_WHEN_POSTING);
                $propbag->add('description', FORUM_HOW_MANY_FILEUPLOADS_WHEN_POSTING_BLAHBLAH);
                $propbag->add('default', '1');
                break;

           case 'max_files_per_post' :
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_FORUM_HOW_MANY_FILES_IN_ONE_POST);
                $propbag->add('description', PLUGIN_FORUM_HOW_MANY_FILES_IN_ONE_POST_BLAHBLAH);
                $propbag->add('default', '3');
                break;

           case 'max_files_per_user' :
                $propbag->add('type', 'string');
                $propbag->add('name', FORUM_PLUGIN_HOW_MANY_FILEUPLOADS_AT_ALL);
                $propbag->add('description', FORUM_PLUGIN_HOW_MANY_FILEUPLOADS_AT_ALLBLAHBLAH);
                $propbag->add('default', '100');
                break;

           case 'notifymail_from' :
                $propbag->add('type', 'string');
                $propbag->add('name', FORUM_PLUGIN_NOTIFYMAIL_FROM);
                $propbag->add('description', FORUM_PLUGIN_NOTIFYMAIL_FROM_BLAHBLAH);
                $propbag->add('default', $serendipity['blogMail']);
                break;

           case 'notifymail_name' :
                $propbag->add('type', 'string');
                $propbag->add('name', FORUM_PLUGIN_NOTIFYMAIL_NAME);
                $propbag->add('description', FORUM_PLUGIN_NOTIFYMAIL_NAME_BLAHBLAH);
                $propbag->add('default', 'Forum of '.$serendipity['blogTitle']);
                break;

           case 'admin_notify' :
                $propbag->add('type', 'boolean');
                $propbag->add('name', FORUM_PLUGIN_ADMIN_NOTIFY);
                $propbag->add('description', FORUM_PLUGIN_ADMIN_NOTIFY_BLAHBLAH);
                $propbag->add('default', 'true');
                break;

           case 'phpbb_db_user':
                $propbag->add('type', 'string');
                $propbag->add('name', FORUM_PLUGIN_PHPBB_USER);
                $propbag->add('description', '');
                $propbag->add('default', '');
                break;

           case 'phpbb_db_pw':
                $propbag->add('type', 'string');
                $propbag->add('name', FORUM_PLUGIN_PHPBB_PW);
                $propbag->add('description', '');
                $propbag->add('default', '');
                break;

           case 'phpbb_db_host':
                $propbag->add('type', 'string');
                $propbag->add('name', FORUM_PLUGIN_PHPBB_HOST);
                $propbag->add('description', '');
                $propbag->add('default', '127.0.0.1');
                break;

           case 'phpbb_db_name':
                $propbag->add('type', 'string');
                $propbag->add('name', FORUM_PLUGIN_PHPBB_NAME);
                $propbag->add('description', '');
                $propbag->add('default', '');
                break;

           case 'phpbb_db_prefix':
                $propbag->add('type', 'string');
                $propbag->add('name', FORUM_PLUGIN_PHPBB_PREFIX);
                $propbag->add('description', '');
                $propbag->add('default', 'phpbb_');
                break;

           case 'phpbb_forum':
                $propbag->add('type', 'string');
                $propbag->add('name', FORUM_PLUGIN_PHPBB_FORUM);
                $propbag->add('description', '');
                $propbag->add('default', '1');
                break;

           case 'phpbb_poster':
                $propbag->add('type', 'string');
                $propbag->add('name', FORUM_PLUGIN_PHPBB_POSTER);
                $propbag->add('description', '');
                $propbag->add('default', '2');
                break;

            default:
                return false;
        }
        return true;
    }




    function show() {
        global $serendipity;

        if ($serendipity['GET']['subpage'] == $this->get_config('pageurl')) {
            if (!is_object($serendipity['smarty'])) {
                serendipity_smarty_init();
            }
            $serendipity['smarty']->assign('staticpage_pagetitle', preg_replace('@[^a-z0-9]@i', '_',$this->get_config('pagetitle')));
            $this->showForum();
        }
    }







    function setupDB() {
        global $serendipity;

        $installed = $this->get_config('forum_installed', null);


        if (empty($installed) && !defined('FORUM_UPGRADE')) {

            $q = "CREATE TABLE {$serendipity['dbPrefix']}dma_forum_boards (
                        boardid         {AUTOINCREMENT} {PRIMARY},
                        name             varchar(80) NOT NULL     default '',
                        description        varchar(250) NOT NULL     default '',
                        sortorder        int(10)        NOT NULL    default '0',
                        threads         int(10)        NOT NULL    default '0',
                        posts             int(10)     NOT NULL     default '0',
                        views             int(10)     NOT NULL     default '0',
                        flag            int(1)        NOT NULL    default '0',
                        lastauthorid     int(10)     NOT NULL     default '0',
                        lastauthorname     varchar(48)    NOT NULL    default '',
                        lastthreadid    int(10)        NOT NULL    default '0',
                        lastpostid        int(10)        NOT NULL    default '0',
                        lastposttime    int(10)        NOT NULL    default '0'
                )";
            $sql = serendipity_db_schema_import($q);

            $q = "CREATE TABLE {$serendipity['dbPrefix']}dma_forum_threads (
                        boardid         int(10)        NOT NULL     default '0',
                        threadid         {AUTOINCREMENT} {PRIMARY},
                        title             varchar(80) NOT NULL     default '',
                        replies         int(10)        NOT NULL    default '0',
                        views             int(10)     NOT NULL     default '0',
                        flag            int(1)        NOT NULL    default '0',
                        notifymails        text,
                        lastauthorid     int(10)     NOT NULL     default '0',
                        lastauthorname     varchar(48)    NOT NULL    default '',
                        lastpostid        int(10)        NOT NULL    default '0',
                        lastposttime    int(10)        NOT NULL    default '0'
                )";
            $sql = serendipity_db_schema_import($q);

            $q = "CREATE TABLE {$serendipity['dbPrefix']}dma_forum_posts (
                        threadid         int(10)        NOT NULL     default '0',
                        postid             {AUTOINCREMENT} {PRIMARY},
                        postdate        int(10)        NOT NULL    default '0',
                        title             varchar(80) NOT NULL     default '',
                        message            text,
                        flag            int(1)        NOT NULL    default '0',
                        authorid         int(10)     NOT NULL     default '0',
                        authorname         varchar(48)    NOT NULL    default '',
                        editcount         int(10)     NOT NULL     default '0'
                )";
            $sql = serendipity_db_schema_import($q);

            $q = "CREATE INDEX boardid ON {$serendipity['dbPrefix']}dma_forum_boards (boardid);";
            $sql = serendipity_db_schema_import($q);
            $q = "CREATE INDEX sortorder ON {$serendipity['dbPrefix']}dma_forum_boards (sortorder);";
            $sql = serendipity_db_schema_import($q);

            $q = "CREATE INDEX boardid ON {$serendipity['dbPrefix']}dma_forum_threads (boardid);";
            $sql = serendipity_db_schema_import($q);
            $q = "CREATE INDEX threadid ON {$serendipity['dbPrefix']}dma_forum_threads (threadid);";
            $sql = serendipity_db_schema_import($q);
            $q = "CREATE INDEX lastposttime ON {$serendipity['dbPrefix']}dma_forum_threads (lastposttime);";
            $sql = serendipity_db_schema_import($q);

            $q = "CREATE INDEX threadid ON {$serendipity['dbPrefix']}dma_forum_posts (threadid);";
            $sql = serendipity_db_schema_import($q);
            $q = "CREATE INDEX postid ON {$serendipity['dbPrefix']}dma_forum_posts (postid);";
            $sql = serendipity_db_schema_import($q);
            $q = "CREATE INDEX postdate ON {$serendipity['dbPrefix']}dma_forum_posts (postdate);";
            $sql = serendipity_db_schema_import($q);

            $now = time();

            $q = "INSERT INTO {$serendipity['dbPrefix']}dma_forum_boards (
                        name,
                        description,
                        sortorder,
                        threads,
                        posts,
                        lastauthorname,
                        lastthreadid,
                        lastpostid,
                        lastposttime
            ) VALUES (
                        'Example board',
                        'This board is only an example. You can delete or modify this in the admincenter',
                        '0',
                        '1',
                        '1',
                        'System',
                        '1',
                        '1',
                        '".$now."'
            )";
            $sql = serendipity_db_query($q);

            $q = "INSERT INTO {$serendipity['dbPrefix']}dma_forum_threads (
                        boardid,
                        title,
                        replies,
                        lastauthorname,
                        lastpostid,
                        lastposttime
            ) VALUES (
                        '1',
                        'Example thread',
                        '0',
                        'System',
                        '1',
                        '".$now."'
            )";
            $sql = serendipity_db_query($q);

            $q = "INSERT INTO {$serendipity['dbPrefix']}dma_forum_posts (
                        threadid,
                        postdate,
                        title,
                        message,
                        authorname
            ) VALUES (
                        '1',
                        '".$now."',
                        'Example post',
                        'This is the very first example post, which can be edited or deleted from the admincenter.',
                        'System'
            )";
            $sql = serendipity_db_query($q);

            $this->set_config('forum_installed', '1');
            @define('FORUM_UPGRADE', 1);
        }


        switch($installed) {
            case 1:

                //
                //
                // Update from 0.2 to 0.3
                //
                $TABLE['uploads'] = 0;
                $TABLE['users'] = 0;




                if ($serendipity['dbType'] == "postgres") {
                    $tables = serendipity_db_query("SELECT * FROM information_schema.tables WHERE table_schema='public' AND table_type='BASE TABLE'");
                } else {
                    $tables = serendipity_db_query("SHOW TABLES");
                }
                foreach ($tables AS $table) {
                    if ($table[0] == "{$serendipity['dbPrefix']}dma_forum_uploads") {
                        $TABLE['uploads'] = 1;
                    } elseif ($table[0] == "{$serendipity['dbPrefix']}dma_forum_users") {
                        $TABLE['users'] = 1;
                    }
                }
                if ($TABLE['uploads'] <= 0) {
                    $q = "CREATE TABLE {$serendipity['dbPrefix']}dma_forum_uploads (
                                postid             int(10)        NOT NULL     default '0',
                                uploadid        {AUTOINCREMENT} {PRIMARY},
                                uploaddate        int(10)        NOT NULL    default '0',
                                sysfilename        varchar(32) NOT NULL     default '',
                                realfilename    varchar(150) NOT NULL     default '',
                                dlcount            int(10)        NOT NULL    default '0'
                        )";
                    $sql = serendipity_db_schema_import($q);
                    $q = "CREATE INDEX postid ON {$serendipity['dbPrefix']}dma_forum_uploads (postid);";
                    $sql = serendipity_db_schema_import($q);
                    $q = "CREATE INDEX uploadid ON {$serendipity['dbPrefix']}dma_forum_uploads (uploadid);";
                    $sql = serendipity_db_schema_import($q);
                    $q = "CREATE INDEX realfilename ON {$serendipity['dbPrefix']}dma_forum_uploads (realfilename);";
                    $sql = serendipity_db_schema_import($q);
                }
                if ($TABLE['users'] <= 0) {
                    $q = "CREATE TABLE {$serendipity['dbPrefix']}dma_forum_users (
                                authorid        int(10)        NOT NULL    default '0',
                                posts            int(10)        NOT NULL    default '0',
                                visits            int(10)        NOT NULL    default '0',
                                lastvisit        int(10)        NOT NULL    default '0',
                                lastpost        int(10)        NOT NULL    default '0',
                                uploadids        text
                        )";
                    $sql = serendipity_db_schema_import($q);
                    $q = "CREATE INDEX authorid ON {$serendipity['dbPrefix']}dma_forum_users (authorid);";
                    $sql = serendipity_db_schema_import($q);
                }

                //
                //
                // Update from 0.3 to 0.4
                //

                $FIELD['authorid'] = 0;
                $FIELD['filesize'] = 0;
                $FIELD['announce'] = 0;
                if ($serendipity['dbType'] == "postgres") {
                    $fields = serendipity_db_query("SELECT column_name FROM information_schema.columns WHERE table_name = '".$serendipity['dbPrefix']."dma_forum_uploads';");
                } else {
                    $fields = serendipity_db_query("SHOW COLUMNS FROM {$serendipity['dbPrefix']}dma_forum_uploads");
                }
                foreach ($fields AS $field) {
                    if ($field[0] == "authorid") {
                        $FIELD['authorid'] = 1;
                    } elseif ($field[0] == "filesize") {
                        $FIELD['filesize'] = 1;
                    }
                }
                if ($serendipity['dbType'] == "postgres") {
                    $fields = serendipity_db_query("SELECT column_name FROM information_schema.columns WHERE table_name = '".$serendipity['dbPrefix']."dma_forum_threads';");
                } else {
                    $fields = serendipity_db_query("SHOW COLUMNS FROM {$serendipity['dbPrefix']}dma_forum_threads");
                }
                foreach ($fields AS $field) {
                    if ($field[0] == "announce") {
                        $FIELD['announce'] = 1;
                    }
                }
                if ($FIELD['authorid'] <= 0) {
                    $q = "CREATE TABLE {$serendipity['dbPrefix']}dma_forum_uploads_tmp (
                                postid          int(10)     NOT NULL    default '0',
                                uploadid        {AUTOINCREMENT} {PRIMARY},
                                uploaddate      int(10)     NOT NULL    default '0',
                                sysfilename     varchar(32) NOT NULL    default '',
                                realfilename    varchar(150) NOT NULL   default '',
                                dlcount         int(10)     NOT NULL    default '0'
                        )";
                    $sql = serendipity_db_schema_import($q);
                    $q = "INSERT INTO {$serendipity['dbPrefix']}dma_forum_uploads_tmp
                                 (postid, uploadid, uploaddate, sysfilename, realfilename, dlcount)
                          SELECT postid, uploadid, uploaddate, sysfilename, realfilename, dlcount FROM {$serendipity['dbPrefix']}dma_forum_uploads;";
                    $sql = serendipity_db_schema_import($q);
                    $q = "DROP TABLE {$serendipity['dbPrefix']}dma_forum_uploads;";
                    $sql = serendipity_db_schema_import($q);
                    $q = "CREATE TABLE {$serendipity['dbPrefix']}dma_forum_uploads (
                                postid          int(10)     NOT NULL    default '0',
                                uploadid        {AUTOINCREMENT} {PRIMARY},
                                authorid        int(10)     NOT NULL    default '0',
                                uploaddate      int(10)     NOT NULL    default '0',
                                sysfilename     varchar(32) NOT NULL    default '',
                                realfilename    varchar(150) NOT NULL   default '',
                                dlcount         int(10)     NOT NULL    default '0'
                        )";
                    $sql = serendipity_db_schema_import($q);
                    $q = "INSERT INTO {$serendipity['dbPrefix']}dma_forum_uploads
                                 (postid, uploadid, authorid, uploaddate, sysfilename, realfilename, dlcount)
                          SELECT postid, uploadid, authorid, uploaddate, sysfilename, realfilename, dlcount FROM {$serendipity['dbPrefix']}dma_forum_uploads_tmp;";
                    $sql = serendipity_db_schema_import($q);
                    $q = "DROP TABLE {$serendipity['dbPrefix']}dma_forum_uploads_tmp;";
                    $sql = serendipity_db_schema_import($q);
                    $q = "CREATE INDEX authorid ON {$serendipity['dbPrefix']}dma_forum_uploads (authorid);";
                    $sql = serendipity_db_schema_import($q);
                }
                if ($FIELD['filesize'] <= 0) {
                    $q = "CREATE TABLE {$serendipity['dbPrefix']}dma_forum_uploads_tmp (
                                postid          int(10)     NOT NULL    default '0',
                                uploadid        {AUTOINCREMENT} {PRIMARY},
                                authorid        int(10)     NOT NULL    default '0',
                                uploaddate      int(10)     NOT NULL    default '0',
                                sysfilename     varchar(32) NOT NULL    default '',
                                realfilename    varchar(150) NOT NULL   default '',
                                dlcount         int(10)     NOT NULL    default '0'
                        )";
                    $sql = serendipity_db_schema_import($q);
                    $q = "INSERT INTO {$serendipity['dbPrefix']}dma_forum_uploads_tmp
                                 (postid, uploadid, authorid, uploaddate, sysfilename, realfilename, dlcount)
                          SELECT postid, uploadid, authorid, uploaddate, sysfilename, realfilename, dlcount FROM {$serendipity['dbPrefix']}dma_forum_uploads;";
                    $sql = serendipity_db_schema_import($q);
                    $q = "DROP TABLE {$serendipity['dbPrefix']}dma_forum_uploads;";
                    $sql = serendipity_db_schema_import($q);
                    $q = "CREATE TABLE {$serendipity['dbPrefix']}dma_forum_uploads (
                                postid          int(10)     NOT NULL    default '0',
                                uploadid        {AUTOINCREMENT} {PRIMARY},
                                authorid        int(10)     NOT NULL    default '0',
                                uploaddate      int(10)     NOT NULL    default '0',
                                filesize        int(10)     NOT NULL    default '0',
                                sysfilename     varchar(32) NOT NULL    default '',
                                realfilename    varchar(150) NOT NULL   default '',
                                dlcount         int(10)     NOT NULL    default '0'
                        )";
                    $sql = serendipity_db_schema_import($q);
                    $q = "INSERT INTO {$serendipity['dbPrefix']}dma_forum_uploads
                                 (postid, uploadid, authorid, uploaddate, filesize, sysfilename, realfilename, dlcount)
                          SELECT postid, uploadid, authorid, uploaddate, filesize, sysfilename, realfilename, dlcount FROM {$serendipity['dbPrefix']}dma_forum_uploads_tmp;";
                    $sql = serendipity_db_schema_import($q);
                    $q = "DROP TABLE {$serendipity['dbPrefix']}dma_forum_uploads_tmp;";
                    $sql = serendipity_db_schema_import($q);
                }
                if ($FIELD['announce'] <= 0) {
                    $q = "CREATE TABLE {$serendipity['dbPrefix']}dma_forum_threads_tmp (
                            boardid         int(10)     NOT NULL    default '0',
                            threadid        {AUTOINCREMENT} {PRIMARY},
                            title           varchar(80) NOT NULL    default '',
                            replies         int(10)     NOT NULL    default '0',
                            views           int(10)     NOT NULL    default '0',
                            flag            int(1)      NOT NULL    default '0',
                            notifymails     text,
                            lastauthorid    int(10)     NOT NULL    default '0',
                            lastauthorname  varchar(48) NOT NULL    default '',
                            lastpostid      int(10)     NOT NULL    default '0',
                            lastposttime    int(10)     NOT NULL    default '0'
                        )";
                    $sql = serendipity_db_schema_import($q);
                    $q = "INSERT INTO {$serendipity['dbPrefix']}dma_forum_threads_tmp
                                 (boardid, threadid, title, replies, views, flag, notifymails, lastauthorid, lastauthorname, lastpostid, lastposttime)
                          SELECT boardid, threadid, title, replies, views, flag, notifymails, lastauthorid, lastauthorname, lastpostid, lastposttime FROM {$serendipity['dbPrefix']}dma_forum_threads;";
                    $sql = serendipity_db_schema_import($q);
                    $q = "DROP TABLE {$serendipity['dbPrefix']}dma_forum_threads;";
                    $sql = serendipity_db_schema_import($q);
                    $q = "CREATE TABLE {$serendipity['dbPrefix']}dma_forum_threads (
                            boardid         int(10)     NOT NULL    default '0',
                            threadid        {AUTOINCREMENT} {PRIMARY},
                            title           varchar(80) NOT NULL    default '',
                            replies         int(10)     NOT NULL    default '0',
                            views           int(10)     NOT NULL    default '0',
                            flag            int(1)      NOT NULL    default '0',
                            announce        int(1)      NOT NULL    default '0',
                            notifymails     text,
                            lastauthorid    int(10)     NOT NULL    default '0',
                            lastauthorname  varchar(48) NOT NULL    default '',
                            lastpostid      int(10)     NOT NULL    default '0',
                            lastposttime    int(10)     NOT NULL    default '0'
                        )";
                    $sql = serendipity_db_schema_import($q);
                    $q = "INSERT INTO {$serendipity['dbPrefix']}dma_forum_threads
                                 (boardid, threadid, title, replies, views, flag, announce, notifymails, lastauthorid, lastauthorname, lastpostid, lastposttime)
                          SELECT boardid, threadid, title, replies, views, flag, announce, notifymails, lastauthorid, lastauthorname, lastpostid, lastposttime FROM {$serendipity['dbPrefix']}dma_forum_threads_tmp;";
                    $sql = serendipity_db_schema_import($q);
                    $q = "DROP TABLE {$serendipity['dbPrefix']}dma_forum_threads_tmp;";
                    $sql = serendipity_db_schema_import($q);
                    $q = "CREATE INDEX announce ON {$serendipity['dbPrefix']}dma_forum_threads (announce);";
                    $sql = serendipity_db_schema_import($q);
                }


                 //
                //
                // Update from 0.4 to 0.5
                //

                $FIELD['notifymails'] = 0;
                if ($serendipity['dbType'] == "postgres") {
                    $fields = serendipity_db_query("SELECT column_name FROM information_schema.columns WHERE table_name = '".$serendipity['dbPrefix']."dma_forum_threads';");
                } else {
                    $fields = serendipity_db_query("SHOW COLUMNS FROM {$serendipity['dbPrefix']}dma_forum_threads");
                }
                foreach ($fields AS $field) {
                    if ($field[0] == "notifymails") {
                        $FIELD['notifymails'] = 1;
                    }
                }
                if ($FIELD['notifymails'] <= 0) {
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}dma_forum_threads ADD notifymails text AFTER flag;";
                    $sql = serendipity_db_schema_import($q);
                }

                $this->set_config('forum_installed', '2');
                break;
        }
    }




    function uninstall(&$propbag) {
        global $serendipity;

        serendipity_db_query("DROP TABLE {$serendipity['dbPrefix']}dma_forum_boards");
        serendipity_db_query("DROP TABLE {$serendipity['dbPrefix']}dma_forum_threads");
        serendipity_db_query("DROP TABLE {$serendipity['dbPrefix']}dma_forum_posts");

        $sql = "SELECT sysfilename FROM {$serendipity['dbPrefix']}dma_forum_uploads";
        $uploads = serendipity_db_query($sql);
        if (is_array($uploads) && count($uploads) >= 1) {
            foreach ($uploads AS $upload) {
                @unlink($this->get_config('uploaddir')."/".$file);
            }
        }
        serendipity_db_query("DROP TABLE {$serendipity['dbPrefix']}dma_forum_uploads");
        serendipity_db_query("DROP TABLE {$serendipity['dbPrefix']}dma_forum_users");

        $this->set_config('forum_db_built', NULL);
        @define('FORUM_UPGRADE_DONE', false);

    }


    function DMA_forum_getRelPath() {
        global $serendipity;
        static $path = null;

        if ($path === null) {
            $path = $this->get_config('imgdir');
        }

        return $path;
    }

    function showForum() {
        global $serendipity;
        if (!headers_sent()) {
            header('HTTP/1.0 200');
            header('Status: 200 OK');
        }
        $ERRORMSG = "";

        $THREAD_UNREAD_ANNOUNCEMENT = "<img src=\"".$this->DMA_forum_getRelPath()."/img/thread_unread_announce.png\" width=\"20\" height=\"20\" border=\"0\" alt=\"".PLUGIN_FORUM_ALT_READ."\" title=\"".PLUGIN_FORUM_ALT_READ."\" />";
        $THREAD_READ_ANNOUNCEMENT = "<img src=\"".$this->DMA_forum_getRelPath()."/img/thread_read_announce.png\" width=\"20\" height=\"20\" border=\"0\" alt=\"".PLUGIN_FORUM_ALT_READ."\" title=\"".PLUGIN_FORUM_ALT_READ."\" />";

        $THREAD_UNREAD = "<img src=\"".$this->DMA_forum_getRelPath()."/img/thread_unread.png\" width=\"20\" height=\"18\" border=\"0\" alt=\"".PLUGIN_FORUM_ALT_UNREAD."\" title=\"".PLUGIN_FORUM_ALT_UNREAD."\" />";
        $THREAD_HUGE_UNREAD = "<img src=\"".$this->DMA_forum_getRelPath()."/img/thread_huge_unread.png\" width=\"20\" height=\"18\" border=\"0\" alt=\"".PLUGIN_FORUM_ALT_UNREAD."\" title=\"".PLUGIN_FORUM_ALT_UNREAD."\" />";
        $THREAD_READ = "<img src=\"".$this->DMA_forum_getRelPath()."/img/thread_read.png\" width=\"20\" height=\"18\" border=\"0\" alt=\"".PLUGIN_FORUM_ALT_READ."\" title=\"".PLUGIN_FORUM_ALT_READ."\" />";
        $THREAD_HUGE_READ = "<img src=\"".$this->DMA_forum_getRelPath()."/img/thread_huge_read.png\" width=\"20\" height=\"18\" border=\"0\" alt=\"".PLUGIN_FORUM_ALT_READ."\" title=\"".PLUGIN_FORUM_ALT_READ."\" />";
        $DEL_FILE_BUTTON = "<img src=\"".serendipity_getTemplateFile('admin/img/delete.png')."\" width=\"18\" height=\"18\" border=\"0\" alt=\"".DELETE."\" title=\"".DELETE."\" />";


        if (!isset($_SESSION['forum_visited']) || intval($_SESSION['forum_visited']) <= 0) {
            if (serendipity_userLoggedIn()) {
                $sql = "SELECT visits, lastvisit FROM {$serendipity['dbPrefix']}dma_forum_users WHERE authorid = '".intval($serendipity['authorid'])."'";
                $visits = serendipity_db_query($sql);
                if (is_array($visits) && count($visits) >= 1) {
                    $q = "UPDATE {$serendipity['dbPrefix']}dma_forum_users SET visits = visits+1, lastvisit = '".time()."' WHERE authorid = '".intval($serendipity['authorid'])."'";
                    serendipity_db_query($q);
                } else {
                    $q = "INSERT INTO {$serendipity['dbPrefix']}dma_forum_users (authorid, visits, lastvisit) VALUES ('".intval($serendipity['authorid'])."', '1', '".time()."')";
                    serendipity_db_query($q);
                }
                $_SESSION['forum_visited'] = 1;
            }
        }





        if (is_array($_COOKIE) && trim($_COOKIE['s9yread']) != "") {
            $READARRAY = unserialize(stripslashes(trim($_COOKIE['s9yread'])));
        } else {
            $READARRAY = array();
        }

        // POST part
        if (isset($serendipity['POST']['action']) && trim($serendipity['POST']['action']) == "reply") {
            if (!isset($serendipity['POST']['authorname']) || trim($serendipity['POST']['authorname']) == "") {
                if (serendipity_userLoggedIn()) {
                    $serendipity['POST']['authorname'] = $serendipity['serendipityUser'];
                } else {
                    $serendipity['POST']['authorname'] = PLUGIN_FORUM_GUEST;
                }
            }


            if ($this->get_config('use_captchas')) {
                // Fake call to spamblock and other comment plugins.
                $ca = array(
                    'id'                => 0,
                    'allow_comments'    => 'true',
                    'moderate_comments' => false,
                    'last_modified'     => 1,
                    'timestamp'         => 1
                );

                $commentInfo = array(
                    'type' => 'NORMAL',
                    'source' => 'commentform',
                    'name' => $serendipity['POST']['authorname'],
                    'url' => '',
                    'comment' => $serendipity['POST']['comment'],
                    'email' => ''
                );
                serendipity_plugin_api::hook_event('frontend_saveComment', $ca, $commentInfo);
            } else {
                $ca['allow_comments'] = true;
            }
            if ($ca['allow_comments'] === false) {
                $ERRORMSG = PLUGIN_FORUM_ERR_WRONG_CAPTCHA_STRING;
            } else {

                $serendipity['POST']['title'] = trim($serendipity['POST']['title']);

                $serendipity['POST']['comment'] = trim($serendipity['POST']['comment']);

                $serendipity['POST']['authorname'] = trim($serendipity['POST']['authorname']);

                if (!isset($serendipity['POST']['comment']) || strlen(trim($serendipity['POST']['comment'])) <= 3) {
                    $ERRORMSG = PLUGIN_FORUM_ERR_MISSING_MESSAGE;
                } else {
                    $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_threads WHERE threadid='".intval($serendipity['POST']['threadid'])."'";
                    $thread = serendipity_db_query($sql);
                    if ($thread[0]['flag'] == 1) {
                        $ERRORMSG = PLUGIN_FORUM_ERR_THREAD_CLOSED;
                    } else {
                        if (trim($serendipity['POST']['comment']) == $_SESSION['lastposttext']) {
                            $ERRORMSG = PLUGIN_FORUM_ERR_DOUBLE_POST;
                        } elseif($_SESSION['lastposttime'] >= (time()-10)) {
                            $ERRORMSG = PLUGIN_FORUM_ERR_POST_INTERVAL;
                        } else {
                            $now = time();
                            $postid = DMA_forum_InsertReply(intval($serendipity['POST']['boardid']), intval($serendipity['POST']['threadid']), intval($serendipity['POST']['replyto']), trim($serendipity['POST']['authorname']), trim($serendipity['POST']['title']), trim($serendipity['POST']['comment']), $this->get_config('itemsperpage'), $this->get_config('notifymail_from'), $this->get_config('notifymail_name'), $this->get_config('pageurl'), $this->get_config('admin_notify'));
                            if ((serendipity_userLoggedIn() && $this->get_config('fileupload_reguser')) || ($this->get_config('fileupload_guest'))) {
                                DMA_forum_uploadFiles($postid, $this->get_config('uploaddir'));
                                if ($this->SUCCESS <= 0) {

                                    if (count($this->UPLOAD_TOOBIG) >= 1) {
                                        $ERRORMSG = PLUGIN_FORUM_ERR_FILE_TOO_BIG;
                                    } elseif (count($this->UPLOAD_NOTCOPIED) >= 1) {
                                        $ERRORMSG = PLUGIN_FORUM_ERR_FILE_NOT_COPIED;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if (serendipity_userLoggedIn()) {
                $POST_AUTHORNAME = $serendipity['serendipityUser'];
            } else {
                $POST_AUTHORNAME = trim($serendipity['POST']['authorname']);
            }
            $POST_TITLE = trim($serendipity['POST']['title']);
            $POST_MESSAGE = trim($serendipity['POST']['comment']);
            if (isset($ERRORMSG) && trim($ERRORMSG) != "") {
                $_GET['boardid'] = intval($serendipity['POST']['boardid']);
                $_GET['threadid'] = intval($serendipity['POST']['threadid']);
                $_GET['replyto'] = intval($serendipity['POST']['replyto']);
                $_GET['quote'] = 0;
            }
        } elseif (isset($serendipity['POST']['action']) && trim($serendipity['POST']['action']) == "edit") {
            if (!isset($serendipity['POST']['authorname']) || trim($serendipity['POST']['authorname']) == "") {
                if (serendipity_userLoggedIn()) {
                    $serendipity['POST']['authorname'] = $serendipity['serendipityUser'];
                } else {
                    $serendipity['POST']['authorname'] = PLUGIN_FORUM_GUEST;
                }
            }
            $serendipity['POST']['title'] = trim($serendipity['POST']['title']);

            $serendipity['POST']['comment'] = trim($serendipity['POST']['comment']);

            $serendipity['POST']['authorname'] = trim($serendipity['POST']['authorname']);

            if (!isset($serendipity['POST']['comment']) || strlen(trim($serendipity['POST']['comment'])) <= 3) {
                $ERRORMSG = PLUGIN_FORUM_ERR_MISSING_MESSAGE;
            } else {
                $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_posts WHERE postid='".intval($serendipity['POST']['edit'])."'";
                $post = serendipity_db_query($sql);
                if (serendipity_userLoggedIn() && (($serendipity['serendipityUser'] == $post[0]['authorname'] && $serendipity['authorid'] == $post[0]['authorid']) || $serendipity['serendipityUserlevel'] == 255)) {
                    if (serendipity_userLoggedIn() && $serendipity['serendipityUserlevel'] == USERLEVEL_ADMIN) {
                        if (isset($serendipity['POST']['announcement']) && intval($serendipity['POST']['announcement']) == 1) {
                            $announce = 1;
                        } else {
                            $announce = 0;
                        }
                    } else {
                        $announce = 0;
                    }
                    DMA_forum_EditReply(intval($serendipity['POST']['boardid']), intval($serendipity['POST']['threadid']), intval($serendipity['POST']['edit']), trim($serendipity['POST']['authorname']), trim($serendipity['POST']['title']), trim($serendipity['POST']['comment']), intval($serendipity['POST']['page']), $announce);
                    if ((serendipity_userLoggedIn() && $this->get_config('fileupload_reguser')) || ($this->get_config('fileupload_guest'))) {
                        DMA_forum_uploadFiles(intval($serendipity['POST']['edit']), $this->get_config('uploaddir'));
                        if ($this->SUCCESS <= 0) {

                            if (count($this->UPLOAD_TOOBIG) >= 1) {
                                $ERRORMSG = PLUGIN_FORUM_ERR_FILE_TOO_BIG;
                            } elseif (count($this->UPLOAD_NOTCOPIED) >= 1) {
                                $ERRORMSG = PLUGIN_FORUM_ERR_FILE_NOT_COPIED;
                            }
                        }
                    }
                } else {
                    $ERRORMSG = PLUGIN_FORUM_ERR_EDIT_NOT_ALLOWED;
                }
            }
            if (serendipity_userLoggedIn()) {
                $POST_AUTHORNAME = $serendipity['serendipityUser'];
            } else {
                $POST_AUTHORNAME = trim($serendipity['POST']['authorname']);
            }
            $POST_TITLE = trim($serendipity['POST']['title']);
            $POST_MESSAGE = trim($serendipity['POST']['comment']);
            if (isset($ERRORMSG) && trim($ERRORMSG) != "") {
                $_GET['boardid'] = intval($serendipity['POST']['boardid']);
                $_GET['threadid'] = intval($serendipity['POST']['threadid']);
                $_GET['edit'] = intval($serendipity['POST']['edit']);
            }
        } elseif (isset($serendipity['POST']['action']) && trim($serendipity['POST']['action']) == "delete") {
            if (!isset($serendipity['POST']['no']) || trim($serendipity['POST']['no']) == "") {
                if (!isset($serendipity['serendipityUserlevel']) || $serendipity['serendipityUserlevel'] != 255) {
                    $ERRORMSG = PLUGIN_FORUM_ERR_DELETE_NOT_ALLOWED;
                } else {
                    DMA_forum_DeletePost(intval($serendipity['POST']['boardid']), intval($serendipity['POST']['threadid']), intval($serendipity['POST']['delete']), intval($serendipity['POST']['page']), $this->get_config('uploaddir'), $this->get_config('itemsperpage'));
                }
            }
            if (isset($ERRORMSG) && trim($ERRORMSG) != "") {
                $_GET['boardid'] = intval($serendipity['POST']['boardid']);
                $_GET['threadid'] = intval($serendipity['POST']['threadid']);
            }
        } elseif (isset($serendipity['POST']['action']) && trim($serendipity['POST']['action']) == "newthread") {
            if (!isset($serendipity['POST']['authorname']) || trim($serendipity['POST']['authorname']) == "") {
                if (serendipity_userLoggedIn()) {
                    $serendipity['POST']['authorname'] = $serendipity['serendipityUser'];
                } else {
                    $serendipity['POST']['authorname'] = PLUGIN_FORUM_GUEST;
                }
            }
            if ($this->get_config('use_captchas')) {
                // Fake call to spamblock and other comment plugins.
                $ca = array(
                    'id'                => 0,
                    'allow_comments'    => 'true',
                    'moderate_comments' => false,
                    'last_modified'     => 1,
                    'timestamp'         => 1
                );

                $commentInfo = array(
                    'type' => 'NORMAL',
                    'source' => 'commentform',
                    'name' => $serendipity['POST']['authorname'],
                    'url' => '',
                    'comment' => $serendipity['POST']['comment'],
                    'email' => ''
                );
                serendipity_plugin_api::hook_event('frontend_saveComment', $ca, $commentInfo);
            } else {
                $ca['allow_comments'] = true;
            }
            if ($ca['allow_comments'] === false) {
                $ERRORMSG = PLUGIN_FORUM_ERR_WRONG_CAPTCHA_STRING;
            } else {
                $serendipity['POST']['title'] = trim($serendipity['POST']['title']);

                $serendipity['POST']['comment'] = trim($serendipity['POST']['comment']);

                $serendipity['POST']['authorname'] = trim($serendipity['POST']['authorname']);

                if (!isset($serendipity['POST']['title']) || strlen(trim($serendipity['POST']['title'])) <= 3) {
                    $ERRORMSG = PLUGIN_FORUM_ERR_MISSING_THREADTITLE;
                } elseif (!isset($serendipity['POST']['comment']) || strlen(trim($serendipity['POST']['comment'])) <= 3) {
                    $ERRORMSG = PLUGIN_FORUM_ERR_MISSING_MESSAGE;
                } else {
                    if (trim($serendipity['POST']['comment']) == $_SESSION['lastthreadtext']) {
                        $ERRORMSG = PLUGIN_FORUM_ERR_DOUBLE_THREAD;
                    } elseif($_SESSION['lastposttime'] >= (time()-10)) {
                        $ERRORMSG = PLUGIN_FORUM_ERR_POST_INTERVAL;
                    } else {
                        $now = time();

                        if (serendipity_userLoggedIn() && $serendipity['serendipityUserlevel'] == USERLEVEL_ADMIN) {
                            if (isset($serendipity['POST']['announcement']) && intval($serendipity['POST']['announcement']) == 1) {
                                $announce = 1;
                            } else {
                                $announce = 0;
                            }
                        } else {
                            $announce = 0;
                        }

                        $postid = DMA_forum_InsertThread(intval($serendipity['POST']['boardid']), trim($serendipity['POST']['authorname']), trim($serendipity['POST']['title']), trim($serendipity['POST']['comment']), $announce, $this->get_config('notifymail_from'), $this->get_config('notifymail_name'), $this->get_config('pageurl'), $this->get_config('admin_notify'));


                        if ((serendipity_userLoggedIn() && $this->get_config('fileupload_reguser')) || ($this->get_config('fileupload_guest'))) {
                            DMA_forum_uploadFiles($postid, $this->get_config('uploaddir'));
                            if ($this->SUCCESS <= 0) {

                                if (count($this->UPLOAD_TOOBIG) >= 1) {
                                    $ERRORMSG = PLUGIN_FORUM_ERR_FILE_TOO_BIG;
                                } elseif (count($this->UPLOAD_NOTCOPIED) >= 1) {
                                    $ERRORMSG = PLUGIN_FORUM_ERR_FILE_NOT_COPIED;
                                }
                            }
                        }
                    }
                }
            }
            if (serendipity_userLoggedIn()) {
                $POST_AUTHORNAME = $serendipity['serendipityUser'];
            } else {
                $POST_AUTHORNAME = trim($serendipity['POST']['authorname']);
            }
            $POST_TITLE = trim($serendipity['POST']['title']);
            $POST_MESSAGE = trim($serendipity['POST']['comment']);
            if (isset($ERRORMSG) && trim($ERRORMSG) != "") {
                $_GET['boardid'] = intval($serendipity['POST']['boardid']);
                $_GET['action'] = "newthread";
            } else {
                $_GET['boardid'] = intval($serendipity['POST']['boardid']);
                unset($_GET['action']);
            }
        }





        // GET part
        if ((isset($_GET['replyto']) && !isset($_GET['edit']) && !isset($_GET['delete'])) && (isset($_GET['boardid']) && intval($_GET['boardid']) >= 1) && (isset($_GET['threadid']) && intval($_GET['threadid']) >= 1)) {
            // replyform
            $filename = 'templates/replyform.tpl';
            if (!is_object($serendipity['smarty']))
                serendipity_smarty_init();
            if (isset($ERRORMSG) && trim($ERRORMSG) != "") {
                $serendipity['smarty']->assign('ERRORMSG', $ERRORMSG);
            }
            if (isset($_GET['quote']) && intval($_GET['quote']) >= 1) {
                $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_posts WHERE postid='".intval($_GET['replyto'])."'";
                $post = serendipity_db_query($sql);
            }
            if (!isset($POST_MESSAGE) || trim($POST_MESSAGE) == "") {
                if (isset($_GET['quote']) && intval($_GET['quote']) >= 1) {
                    $POST_MESSAGE = "[quote=".stripslashes($post[0]['authorname'])."]".stripslashes($post[0]['message'])."[/quote]\n\n";
                }
            }
            if (!isset($POST_TITLE) || trim($POST_TITLE) == "") {
                if (isset($_GET['quote']) && intval($_GET['quote']) >= 1) {
                    $POST_TITLE = "Re: ".stripslashes($post[0]['title']);
                }
            }
            if (serendipity_userLoggedIn()) {
                $POST_AUTHORNAME = $serendipity['serendipityUser'];
            }
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_threads WHERE threadid='".intval($_GET['threadid'])."'";
            $thread = serendipity_db_query($sql);
            $serendipity['smarty']->assign(
                array(
                    'pagetitle'            =>    $this->get_config('pagetitle'),
                    'headline'            =>    $this->get_config('headline'),
                    'threadtitle'        =>    htmlspecialchars(stripslashes(trim($thread[0]['title']))),
                    'bgcolor2'            =>    $this->get_config('bgcolor2'),
                    'ACTUALURL'            =>    $serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($_GET['threadid']),
                    'boardid'            =>    intval($_GET['boardid']),
                    'threadid'            =>    intval($_GET['threadid']),
                    'replyto'            =>    intval($_GET['replyto']),
                    'relpath'           =>  $this->DMA_forum_getRelPath(),
                    'POST_AUTHORNAME'    =>    htmlspecialchars($POST_AUTHORNAME),
                    'POST_TITLE'        =>    htmlspecialchars($POST_TITLE),
                    'POST_MESSAGE'        =>    htmlspecialchars($POST_MESSAGE),
                )
            );
            $serendipity['smarty']->assign('bbcode', BBCODE);
            if ((serendipity_userLoggedIn() && $this->get_config('fileupload_reguser')) || ($this->get_config('fileupload_guest'))) {
                $upload_max_filesize = ini_get('upload_max_filesize');
                $upload_max_filesize = preg_replace('/M/', '000000', $upload_max_filesize);
                $MAX_FILE_SIZE = intval($upload_max_filesize);
                $MAX_SIZE_PER_FILE = ($MAX_FILE_SIZE / 1000000)." MB";

                $max_possible = intval($this->get_config('max_simultaneous_fileuploads'));
                if ($max_possible >= intval($this->get_config('max_files_per_post'))) {
                    $max_possible = intval($this->get_config('max_files_per_post'));
                }
                if (serendipity_userLoggedIn()) {
                    $authorid = intval($serendipity['authorid']);
                } else {
                    $authorid = 0;
                }
                $sql = "SELECT COUNT(*) FROM {$serendipity['dbPrefix']}dma_forum_uploads WHERE authorid = '".$authorid."'";
                $uploadnum = serendipity_db_query($sql);
                $uploaduserrest = (intval($this->get_config('max_files_per_user')) - intval($uploadnum[0][0]));
                if ($max_possible >= $uploaduserrest) {
                    $max_possible = $uploaduserrest;
                }

                $uploads = array();
                for ($x=0;$x<$max_possible;$x++) {
                    $uploads[] = ($x+1);
                }
                $serendipity['smarty']->assign(
                    array(
                        'uploadform'        =>  true,
                        'MAX_FILE_SIZE'     =>  $MAX_FILE_SIZE,
                        'MAX_SIZE_PER_FILE' =>  $MAX_SIZE_PER_FILE,
                        'uploads'           =>  $uploads,
                        'uploads_post_left' =>  intval($this->get_config('max_files_per_post')),
                        'uploads_user_left' =>  $uploaduserrest
                    )
                );
            }

            if ($this->get_config('use_captchas')) {
                $serendipity['smarty']->assign('commentform_entry', array('timestamp' => 1));
            }
        } elseif ((!isset($_GET['replyto']) && isset($_GET['edit']) && !isset($_GET['delete'])) && (isset($_GET['boardid']) && intval($_GET['boardid']) >= 1) && (isset($_GET['threadid']) && intval($_GET['threadid']) >= 1)) {
            // editform
            $filename = 'templates/editform.tpl';
            if (!is_object($serendipity['smarty']))
                serendipity_smarty_init();
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_threads WHERE threadid='".intval($_GET['threadid'])."'";
            $thread = serendipity_db_query($sql);
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_posts WHERE postid='".intval($_GET['edit'])."'";
            $post = serendipity_db_query($sql);
            if (serendipity_userLoggedIn() && (($serendipity['serendipityUser'] == $post[0]['authorname'] && $serendipity['authorid'] == $post[0]['authorid']) || $serendipity['serendipityUserlevel'] == 255)) {
                $serendipity['smarty']->assign('CANEDIT', true);
            } else {
                $ERRORMSG = PLUGIN_FORUM_ERR_EDIT_NOT_ALLOWED;
            }
            if (isset($ERRORMSG) && trim($ERRORMSG) != "") {
                $serendipity['smarty']->assign('ERRORMSG', $ERRORMSG);
            }
            $serendipity['smarty']->assign(
                array(
                    'pagetitle'            =>    $this->get_config('pagetitle'),
                    'headline'            =>    $this->get_config('headline'),
                    'threadtitle'        =>    htmlspecialchars(stripslashes(trim($thread[0]['title']))),
                    'bgcolor2'            =>    $this->get_config('bgcolor2'),
                    'ACTUALURL'            =>    $serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($_GET['threadid'])."&amp;page=".intval($_GET['page']),
                    'boardid'            =>    intval($_GET['boardid']),
                    'threadid'            =>    intval($_GET['threadid']),
                    'relpath'           =>  $this->DMA_forum_getRelPath(),
                    'page'              =>  intval($_GET['page']),
                    'edit'                =>    intval($_GET['edit']),
                    'POST_AUTHORNAME'    =>    htmlspecialchars(stripslashes(trim($post[0]['authorname']))),
                    'POST_TITLE'        =>    htmlspecialchars(stripslashes(trim($post[0]['title']))),
                    'POST_MESSAGE'        =>    htmlspecialchars(stripslashes(trim($post[0]['message'])))
                )
            );
            $serendipity['smarty']->assign('bbcode', BBCODE);
            if (serendipity_userLoggedIn() && $serendipity['serendipityUserlevel'] == USERLEVEL_ADMIN) {
                $serendipity['smarty']->assign('announcement', true);
                if (intval($thread[0]['announce']) == 1) {
                    $serendipity['smarty']->assign('checked', " checked");
                } else {
                    $serendipity['smarty']->assign('checked', "");
                }
            }
            if ((serendipity_userLoggedIn() && $this->get_config('fileupload_reguser')) || ($this->get_config('fileupload_guest'))) {
                $upload_max_filesize = ini_get('upload_max_filesize');
                $upload_max_filesize = preg_replace('/M/', '000000', $upload_max_filesize);
                $MAX_FILE_SIZE = intval($upload_max_filesize);
                $MAX_SIZE_PER_FILE = ($MAX_FILE_SIZE / 1000000)." MB";

                $max_possible = intval($this->get_config('max_simultaneous_fileuploads'));
                if ($max_possible >= intval($this->get_config('max_files_per_post'))) {
                    $max_possible = intval($this->get_config('max_files_per_post'));
                }
                if (serendipity_userLoggedIn()) {
                    $authorid = intval($serendipity['authorid']);
                } else {
                    $authorid = 0;
                }
                $sql = "SELECT COUNT(*) FROM {$serendipity['dbPrefix']}dma_forum_uploads WHERE authorid = '".$authorid."'";
                $uploadnum = serendipity_db_query($sql);
                $uploaduserrest = (intval($this->get_config('max_files_per_user')) - intval($uploadnum[0][0]));
                if ($max_possible >= $uploaduserrest) {
                    $max_possible = $uploaduserrest;
                }

                $sql = "SELECT COUNT(*) FROM {$serendipity['dbPrefix']}dma_forum_uploads WHERE postid = '".intval($_GET['edit'])."'";
                $postuploadnum = serendipity_db_query($sql);
                $uploadpostrest = (intval($this->get_config('max_files_per_post')) - intval($postuploadnum[0][0]));
                if ($max_possible >= $uploadpostrest) {
                    $max_possible = $uploadpostrest;
                }

                $uploads = array();
                for ($x=0;$x<$max_possible;$x++) {
                    $uploads[] = ($x+1);
                }
                $serendipity['smarty']->assign(
                    array(
                        'uploadform'        =>  true,
                        'MAX_FILE_SIZE'     =>  $MAX_FILE_SIZE,
                        'MAX_SIZE_PER_FILE' =>  $MAX_SIZE_PER_FILE,
                        'uploads'           =>  $uploads,
                        'uploads_post_left' =>  $uploadpostrest,
                        'uploads_user_left' =>  $uploaduserrest
                    )
                );
            }
        } elseif ((!isset($_GET['replyto']) && !isset($_GET['edit']) && isset($_GET['delete'])) && (isset($_GET['boardid']) && intval($_GET['boardid']) >= 1) && (isset($_GET['threadid']) && intval($_GET['threadid']) >= 1)) {
            // deleteform
            $filename = 'templates/deleteform.tpl';
            if (!is_object($serendipity['smarty']))
                serendipity_smarty_init();
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_threads WHERE threadid='".intval($_GET['threadid'])."'";
            $thread = serendipity_db_query($sql);
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_posts WHERE postid='".intval($_GET['delete'])."'";
            $post = serendipity_db_query($sql);
            if (serendipity_userLoggedIn() && $serendipity['serendipityUserlevel'] == 255) {
                $serendipity['smarty']->assign('CANDELETE', true);
            } else {
                $ERRORMSG = PLUGIN_FORUM_ERR_DELETE_NOT_ALLOWED;
            }
            if (isset($ERRORMSG) && trim($ERRORMSG) != "") {
                $serendipity['smarty']->assign('ERRORMSG', $ERRORMSG);
            }
            if ($this->get_config('apply_markup')) {
                $temp_array = array('body' => htmlspecialchars(stripslashes(trim($post[0]['message']))));
                serendipity_plugin_api::hook_event('frontend_display', $temp_array);
                $post['message'] = trim($temp_array['body']);
            } else {
                $post['message'] = nl2br(htmlspecialchars(stripslashes(trim($post[0]['message']))));
            }
            $serendipity['smarty']->assign(
                array(
                    'pagetitle'            =>    $this->get_config('pagetitle'),
                    'headline'            =>    $this->get_config('headline'),
                    'threadtitle'        =>    htmlspecialchars(stripslashes(trim($thread[0]['title']))),
                    'bgcolor1'            =>    $this->get_config('bgcolor1'),
                    'bgcolor2'            =>    $this->get_config('bgcolor2'),
                    'ACTUALURL'            =>    $serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($_GET['threadid'])."&amp;page=".intval($_GET['page']),
                    'boardid'            =>    intval($_GET['boardid']),
                    'threadid'            =>    intval($_GET['threadid']),
                    'page'              =>  intval($_GET['page']),
                    'delete'            =>    intval($_GET['delete']),
                    'POST_AUTHORNAME'    =>    htmlspecialchars(stripslashes(trim($post[0]['authorname']))),
                    'POST_DATE'            =>    date($this->get_config('dateformat')." ".$this->get_config('timeformat'), $post[0]['postdate']),
                    'POST_TITLE'        =>    htmlspecialchars(stripslashes(trim($post[0]['title']))),
                    'POST_MESSAGE'        =>    $post['message'],
                    'relpath'            =>    $this->DMA_forum_getRelPath()
                )
            );
        } elseif (isset($_GET['action']) && trim($_GET['action']) == "close") {
            $sql = "UPDATE {$serendipity['dbPrefix']}dma_forum_threads SET
                            flag = '1'
                    WHERE    threadid = '".intval($_GET['threadid'])."'";
            serendipity_db_query($sql);
        } elseif (isset($_GET['action']) && trim($_GET['action']) == "reopen") {
            $sql = "UPDATE {$serendipity['dbPrefix']}dma_forum_threads SET
                            flag = '0'
                    WHERE    threadid = '".intval($_GET['threadid'])."'";
            serendipity_db_query($sql);
        }



        if (isset($_GET['delfile']) && intval($_GET['delfile']) >= 1) {
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_uploads WHERE uploadid = '".intval($_GET['delfile'])."'";
            $upload = serendipity_db_query($sql);
            if (serendipity_userLoggedIn() && (($serendipity['serendipityUserlevel'] == USERLEVEL_ADMIN) || (intval($upload[0]['authorid']) == intval($serendipity['authorid'])))) {
                @unlink($this->get_config('uploaddir')."/".$upload[0]['sysfilename']);
                $q = "DELETE FROM {$serendipity['dbPrefix']}dma_forum_uploads WHERE uploadid = '".intval($_GET['delfile'])."'";
                $sql = serendipity_db_query($q);
            }
        }



        if ((isset($_GET['subscribe']) && intval($_GET['subscribe']) == 1) && isset($_GET['threadid'])) {
            if (serendipity_userLoggedIn()) {
                $sql = "SELECT notifymails FROM {$serendipity['dbPrefix']}dma_forum_threads WHERE threadid='".intval($_GET['threadid'])."'";
                $notifymails = serendipity_db_query($sql);
                if (trim($thread[0]['notifymails']) != "") {
                    $NOTIFYARRAY = unserialize(stripslashes(trim($thread[0]['notifymails'])));
                } else {
                    $NOTIFYARRAY = array();
                }
                $NOTIFYARRAY[] = trim($serendipity['email']);
                $updatearray = trim(serialize($NOTIFYARRAY));
                $sql = "UPDATE {$serendipity['dbPrefix']}dma_forum_threads SET notifymails = '".$updatearray."' WHERE threadid='".intval($_GET['threadid'])."'";
                serendipity_db_query($sql);
            }
        } elseif ((isset($_GET['unsubscribe']) && intval($_GET['unsubscribe']) == 1) && isset($_GET['threadid'])) {
            if (serendipity_userLoggedIn()) {
                $sql = "SELECT notifymails FROM {$serendipity['dbPrefix']}dma_forum_threads WHERE threadid='".intval($_GET['threadid'])."'";
                $notifymails = serendipity_db_query($sql);
                if (trim($thread[0]['notifymails']) != "") {
                    $NOTIFYARRAY = unserialize(stripslashes(trim($thread[0]['notifymails'])));
                } else {
                    $NOTIFYARRAY = array();
                }
                $newarray = DMA_forum_array_remove($NOTIFYARRAY, trim($serendipity['email']));
                if (count($newarray) <= 0) {
                    $updatearray = "";
                } else {
                    $updatearray = trim(serialize($NOTIFYARRAY));
                }
                $sql = "UPDATE {$serendipity['dbPrefix']}dma_forum_threads SET notifymails = '".$updatearray."' WHERE threadid='".intval($_GET['threadid'])."'";
                serendipity_db_query($sql);
            }
        }



        /** Jahr des getrigen Tages */
        $yesterday_year = intval(date("Y", (time()-86400)));
        /** Monat des getrigen Tages */
        $yesterday_month = intval(date("n", (time()-86400)));
        /** Tageszahl des getrigen Tages */
        $yesterday_day = intval(date("j", (time()-86400)));
        /** Letzter Timestamp des getrigen Tages (23:59:59 Uhr) */
        $yesterday_lasttstamp = mktime(23,59,59,$yesterday_month,$yesterday_day,$yesterday_year);
        /** Erster Timestamp des getrigen Tages (00:00:00 Uhr) */
        $yesterday_firsttstamp = mktime(0,0,0,$yesterday_month,$yesterday_day,$yesterday_year);


        if ((!isset($_GET['boardid']) || intval($_GET['boardid']) <= 0) && (!isset($_GET['replyto']) && !isset($_GET['edit']) && !isset($_GET['delete']) && !isset($_GET['quote']))) {
            // BOARDLIST
            $filename = 'templates/boardlist.tpl';
            if (!is_object($serendipity['smarty']))
                serendipity_smarty_init();
            $serendipity['smarty']->assign('pagetitle', $this->get_config('pagetitle'));
            $serendipity['smarty']->assign('headline', $this->get_config('headline'));
            $BOARDLIST = "";
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_boards ORDER BY sortorder";
            $boards = serendipity_db_query($sql);
            $mainpage_link = "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."\">".$this->get_config('pagetitle')."</a>";
            $serendipity['smarty']->assign('MAINPAGE', $mainpage_link);
            if (is_array($boards) && count($boards) >= 1) {
                $serendipity['smarty']->assign('bgcolor_head', $this->get_config('bgcolor_head'));
                for ($a=0,$b=count($boards);$a<$b;$a++) {
                    if (intval($boards[$a]['threads']) >= 1) {

                        if (intval($boards[$a]['lastposttime']) >= (intval($yesterday_lasttstamp)+1)) {
                            $lastpost = "<span style=\"color:".$this->get_config('color_today').";font-weight:bolder\">".PLUGIN_FORUM_TODAY." ".date($this->get_config('timeformat'), $boards[$a]['lastposttime'])."</span><br />";
                        } elseif ((intval($boards[$a]['lastposttime']) <= intval($yesterday_lasttstamp)) && (intval($boards[$a]['lastposttime']) >= intval($yesterday_firsttstamp))) {
                            $lastpost = "<span style=\"color:".$this->get_config('color_yesterday')."\">".PLUGIN_FORUM_YESTERDAY." ".date($this->get_config('timeformat'), $boards[$a]['lastposttime'])."</span><br />";
                        } else {
                            $lastpost = date($this->get_config('dateformat')." ".$this->get_config('timeformat'), $boards[$a]['lastposttime'])."<br />";
                        }

                        $lastpost .= htmlspecialchars(stripslashes($boards[$a]['lastauthorname']))." ";
                        $sql = "SELECT COUNT(*) FROM {$serendipity['dbPrefix']}dma_forum_posts WHERE threadid='".intval($boards[$a]['lastthreadid'])."'";
                        $postnum = serendipity_db_query($sql);
                        $page = ceil(intval($postnum[0][0]) / intval($this->get_config('itemsperpage')));
                        $lastpost .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($boards[$a]['boardid'])."&amp;threadid=".intval($boards[$a]['lastthreadid'])."&amp;page=".$page."#".intval($boards[$a]['lastpostid'])."\"><img src=\"".$this->DMA_forum_getRelPath()."/img/icon_latest_reply.gif\" width=\"18\" height=\"9\" border=\"0\" alt=\"".PLUGIN_FORUM_ALT_DIRECTGOTOPOST."\" title=\"".PLUGIN_FORUM_ALT_DIRECTGOTOPOST."\" /></a>";
                        $boards[$a]['lastpost'] = $lastpost;
                    } else {
                        $boards[$a]['lastpost'] = PLUGIN_FORUM_NO_ENTRIES;
                    }
                    if ($thiscolor == $this->get_config('bgcolor2')) { $thiscolor = $this->get_config('bgcolor1'); } else { $thiscolor = $this->get_config('bgcolor2'); }
                    $boards[$a]['color'] = $thiscolor;
                    $boards[$a]['name'] = htmlspecialchars($boards[$a]['name']);
                    $temp_array = array('body' => htmlspecialchars(trim(stripslashes($boards[$a]['description']))));
                    serendipity_plugin_api::hook_event('frontend_display', $temp_array);
                    $boards[$a]['description'] = trim($temp_array['body']);



                }
                $serendipity['smarty']->assign(
                    array(
                        'pagetitle'         =>  $this->get_config('pagetitle'),
                        'headline'          =>  $this->get_config('headline'),
                        'pageurl'           =>  $this->get_config('pageurl'),
                        'boards'            =>  $boards
                    )
                );
            } else {
                $noboards .= PLUGIN_FORUM_NO_BOARDS;
                $serendipity['smarty']->assign('noboards', $noboards);
            }
        } elseif (((intval($_GET['boardid']) >= 1) && (!isset($_GET['threadid']) || intval($_GET['threadid']) <= 0)) && (!isset($_GET['replyto']) && !isset($_GET['edit']) && !isset($_GET['delete']) && !isset($_GET['quote']))) {
            // New thread
            if (isset($_GET['action']) && trim($_GET['action']) == "newthread") {
                $filename = 'templates/newthread.tpl';
                if (!is_object($serendipity['smarty']))
                    serendipity_smarty_init();
                $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_boards WHERE boardid='".intval($_GET['boardid'])."'";
                $board = serendipity_db_query($sql);
                if (serendipity_userLoggedIn()) {
                    $POST_AUTHORNAME = $serendipity['serendipityUser'];
                }
                if (isset($ERRORMSG) && trim($ERRORMSG) != "") {
                    $serendipity['smarty']->assign('ERRORMSG', $ERRORMSG);
                }

                $serendipity['smarty']->assign('bbcode', BBCODE);

                $serendipity['smarty']->assign(
                    array(
                        'pagetitle'            =>    $this->get_config('pagetitle'),
                        'headline'            =>    $this->get_config('headline'),
                        'bgcolor2'            =>    $this->get_config('bgcolor2'),
                        'ACTUALURL'            =>    $serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid']),
                        'boardid'            =>    intval($_GET['boardid']),
                        'POST_AUTHORNAME'    =>    htmlspecialchars($POST_AUTHORNAME),
                        'POST_TITLE'        =>    htmlspecialchars($POST_TITLE),
                        'POST_MESSAGE'        =>    htmlspecialchars($POST_MESSAGE),
                        'relpath'            =>    $this->DMA_forum_getRelPath(),
                        'newthreadurl'        =>    $serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;action=newthread&amp;boardid=".intval($_GET['boardid']),
                        'boardname'            =>    htmlspecialchars(stripslashes(trim($board[0]['name'])))
                    )
                );


                if (serendipity_userLoggedIn() && $serendipity['serendipityUserlevel'] == USERLEVEL_ADMIN) {
                    $serendipity['smarty']->assign('announcement', true);
                }


                if ((serendipity_userLoggedIn() && $this->get_config('fileupload_reguser')) || ($this->get_config('fileupload_guest'))) {
                    $upload_max_filesize = ini_get('upload_max_filesize');
                    $upload_max_filesize = preg_replace('/M/', '000000', $upload_max_filesize);
                    $MAX_FILE_SIZE = intval($upload_max_filesize);
                    $MAX_SIZE_PER_FILE = ($MAX_FILE_SIZE / 1000000)." MB";

                    $max_possible = intval($this->get_config('max_simultaneous_fileuploads'));
                    if ($max_possible >= intval($this->get_config('max_files_per_post'))) {
                        $max_possible = intval($this->get_config('max_files_per_post'));
                    }
                    if (serendipity_userLoggedIn()) {
                        $authorid = intval($serendipity['authorid']);
                    } else {
                        $authorid = 0;
                    }
                    $sql = "SELECT COUNT(*) FROM {$serendipity['dbPrefix']}dma_forum_uploads WHERE authorid = '".$authorid."'";
                    $uploadnum = serendipity_db_query($sql);
                    $uploaduserrest = (intval($this->get_config('max_files_per_user')) - intval($uploadnum[0][0]));
                    if ($max_possible >= $uploaduserrest) {
                        $max_possible = $uploaduserrest;
                    }

                    $uploads = array();
                    for ($x=0;$x<$max_possible;$x++) {
                        $uploads[] = ($x+1);
                    }
                    $serendipity['smarty']->assign(
                        array(
                            'uploadform'        =>  true,
                            'MAX_FILE_SIZE'     =>  $MAX_FILE_SIZE,
                            'MAX_SIZE_PER_FILE' =>  $MAX_SIZE_PER_FILE,
                            'uploads'           =>  $uploads,
                            'uploads_post_left' =>  intval($this->get_config('max_files_per_post')),
                            'uploads_user_left' =>  $uploaduserrest
                        )
                    );
                }
                if ($this->get_config('use_captchas')) {
                    $serendipity['smarty']->assign('commentform_entry', array('timestamp' => 1));
                }
            } else {
                // THREADLIST
                $filename = 'templates/threadlist.tpl';
                if (!is_object($serendipity['smarty']))
                    serendipity_smarty_init();
                $serendipity['smarty']->assign('pagetitle', $this->get_config('pagetitle'));
                $serendipity['smarty']->assign('headline', $this->get_config('headline'));
                $serendipity['smarty']->assign('relpath', $this->DMA_forum_getRelPath());
                $serendipity['smarty']->assign('newthreadurl', $serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;action=newthread&amp;boardid=".intval($_GET['boardid']));
                $THREADLIST = "";
                $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_boards WHERE boardid='".intval($_GET['boardid'])."'";
                $board = serendipity_db_query($sql);
                // paging
                if (isset($_GET['page']) && intval($_GET['page']) >= 1) {
                    $page = intval($_GET['page']);
                } else {
                    $page = 1;
                }
                $postnum = intval($board[0]['threads']);
                $maxpages = ceil($postnum / intval($this->get_config('itemsperpage')));
                if ($maxpages >= 2) {
                    if (!isset($page) OR trim($page) == "" OR $page <= 0) {
                        $page = 1;
                    }
                    if ($page > $maxpages) {
                        $page = $maxpages;
                    }
                    $multiplicator = (($page * intval($this->get_config('itemsperpage'))) - intval($this->get_config('itemsperpage')));

                    if (!isset($page) OR $page == 1) {
                        $LIMIT = serendipity_db_limit(0, intval($this->get_config('itemsperpage')));
                    } else {
                        $LIMIT = serendipity_db_limit($multiplicator, intval($this->get_config('itemsperpage')));
                    }
                    $LIMIT = serendipity_db_limit_sql($LIMIT);
                    $paging = "";
                    if ($page > 1) {
                        $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;page=1\">1</a>&nbsp;";
                        $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;page=".($page - 10)."\">&lt;&lt;</a>&nbsp;";
                        $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;page=".($page - 1)."\">&lt;</a>&nbsp;&nbsp;";
                    } elseif ($page == 1) {
                        $paging .= "[&nbsp;1&nbsp;]&nbsp;";
                    }
                    if ($maxpages >= 2) {
                        for ($b=($page-5);$b<=($page+5);$b++) {
                            if ($b > 1 AND $b < $maxpages) {
                                if ($b == $page) {
                                    $paging .= "[&nbsp;".$b."&nbsp;]&nbsp;";
                                } elseif ($b >= ($maxpages)) {
                                } else {
                                    $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;page=".$b."\">".$b."</a>&nbsp;";
                                }
                            }
                        }
                    }
                    if ($page < $maxpages) {
                        $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;page=".($page + 1)."\">&gt;</a>&nbsp;";
                        $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;page=".($page + 10)."\">&gt;&gt;</a>&nbsp;";
                        $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;page=".$maxpages."\">".$maxpages."</a>&nbsp;";
                    } elseif ($page == $maxpages AND $page != 1) {
                        $paging .= "[&nbsp;".$maxpages."&nbsp;]";
                    }
                    if (isset($paging) && trim($paging) != "") {
                        $serendipity['smarty']->assign('paging', $paging);
                    }
                } else {
                    $LIMIT = "";
                }
                $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_threads WHERE boardid='".intval($_GET['boardid'])."' ORDER BY announce DESC, lastposttime DESC".$LIMIT;
                $threads = serendipity_db_query($sql);
                $mainpage_link = "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."\">".$this->get_config('pagetitle')."</a>";
                $threadlist_link = "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."\">".htmlspecialchars($board[0]['name'])."</a>";
                $serendipity['smarty']->assign('MAINPAGE', $mainpage_link);
                $serendipity['smarty']->assign('THREADLIST', $threadlist_link);
                if (is_array($threads) && count($threads) >= 1) {
                    $serendipity['smarty']->assign('bgcolor_head', $this->get_config('bgcolor_head'));
                    for ($a=0,$b=count($threads);$a<$b;$a++) {
                        if (intval($threads[$a]['lastpostid']) >= 1) {

                            if (intval($threads[$a]['lastposttime']) >= (intval($yesterday_lasttstamp)+1)) {
                                $lastpost = "<span style=\"color:".$this->get_config('color_today').";font-weight:bolder\">".PLUGIN_FORUM_TODAY." ".date($this->get_config('timeformat'), $threads[$a]['lastposttime'])."</span><br />";
                            } elseif ((intval($threads[$a]['lastposttime']) <= intval($yesterday_lasttstamp)) && (intval($threads[$a]['lastposttime']) >= intval($yesterday_firsttstamp))) {
                                $lastpost = "<span style=\"color:".$this->get_config('color_yesterday')."\">".PLUGIN_FORUM_YESTERDAY." ".date($this->get_config('timeformat'), $threads[$a]['lastposttime'])."</span><br />";
                            } else {
                                $lastpost = date($this->get_config('dateformat')." ".$this->get_config('timeformat'), $threads[$a]['lastposttime'])."<br />";
                            }

                            $lastpost .= htmlspecialchars(stripslashes($threads[$a]['lastauthorname']))." ";
                            $sql = "SELECT COUNT(*) FROM {$serendipity['dbPrefix']}dma_forum_posts WHERE threadid='".intval($threads[$a]['threadid'])."'";
                            $postnum = serendipity_db_query($sql);
                            $page = ceil(intval($postnum[0][0]) / intval($this->get_config('itemsperpage')));
                            $lastpost .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($threads[$a]['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=".$page."#".intval($threads[$a]['lastpostid'])."\"><img src=\"".$this->DMA_forum_getRelPath()."/img/icon_latest_reply.gif\" width=\"18\" height=\"9\" border=\"0\" alt=\"".PLUGIN_FORUM_ALT_DIRECTGOTOPOST."\" title=\"".PLUGIN_FORUM_ALT_DIRECTGOTOPOST."\" /></a>";
                        } else {
                            $lastpost = PLUGIN_FORUM_NO_REPLIES;
                        }
                        $threads[$a]['lastpost'] = $lastpost;
                        if ($thiscolor == $this->get_config('bgcolor2')) { $thiscolor = $this->get_config('bgcolor1'); } else { $thiscolor = $this->get_config('bgcolor2'); }
                        $threads[$a]['color'] = $thiscolor;
                        $threads[$a]['title'] = htmlspecialchars($threads[$a]['title']);

                        if ((intval($threads[$a]['announce']) == 1) && (intval($threads[($a+1)]['announce']) != 1)) {
                            $threads[$a]['trenner'] = true;
                        } else {
                            $threads[$a]['trenner'] = false;
                        }

                        if (intval($threads[$a]['announce']) == 1) {
                            $threads[$a]['icon'] = $THREAD_UNREAD_ANNOUNCEMENT;
                            if (isset($READARRAY[intval($threads[$a]['threadid'])]) && intval($READARRAY[intval($threads[$a]['threadid'])]) >= intval($threads[$a]['lastposttime'])) {
                                $threads[$a]['icon'] = $THREAD_READ_ANNOUNCEMENT;
                            }
                        } else {
                            if (intval($threads[$a]['replies']) >= 15) {
                                $threads[$a]['icon'] = $THREAD_HUGE_UNREAD;
                            } else {
                                $threads[$a]['icon'] = $THREAD_UNREAD;
                            }
                            if (isset($READARRAY[intval($threads[$a]['threadid'])]) && intval($READARRAY[intval($threads[$a]['threadid'])]) >= intval($threads[$a]['lastposttime'])) {
                                if (intval($threads[$a]['replies']) >= 15) {
                                    $threads[$a]['icon'] = $THREAD_HUGE_READ;
                                } else {
                                    $threads[$a]['icon'] = $THREAD_READ;
                                }
                            }
                        }




                        $paging = "";
                        $sql = "SELECT COUNT(*) FROM {$serendipity['dbPrefix']}dma_forum_posts WHERE threadid='".intval($threads[$a]['threadid'])."'";
                        $postnum = serendipity_db_query($sql);
                        $maxpages = ceil(intval($postnum[0][0]) / intval($this->get_config('itemsperpage')));
                        if ($maxpages >= 2) {
                            $paging = PLUGIN_FORUM_PAGES.": ";
                            if ($maxpages <= 10) {
                                $pages = "";
                                for ($c=0;$c<$maxpages;$c++) {
                                    if ($pages != "") {
                                        $pages .= ",&nbsp;";
                                    }
                                    $pages .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=".($c+1)."\">".($c+1)."</a>";
                                }
                                $paging .= $pages;
                            } elseif ($maxpages <= 20) {
                                $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=1\">1</a>,&nbsp;";
                                $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=2\">2</a>,&nbsp;";
                                $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=3\">3</a>,&nbsp;";
                                $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=4\">4</a>,&nbsp;";
                                $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=5\">5</a>";
                                $paging .= "... <a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=10\">10</a>";
                                $paging .= "... <a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=".$maxpages."\">".$maxpages."</a>";
                            } elseif ($maxpages <= 50) {
                                $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=1\">1</a>,&nbsp;";
                                $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=2\">2</a>,&nbsp;";
                                $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=3\">3</a>,&nbsp;";
                                $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=4\">4</a>";
                                $paging .= "... <a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=10\">10</a>";
                                $paging .= "... <a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=20\">20</a>";
                                $paging .= "... <a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=".$maxpages."\">".$maxpages."</a>";
                            } else {
                                $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=1\">1</a>,&nbsp;";
                                $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=2\">2</a>,&nbsp;";
                                $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=3\">3</a>";
                                $paging .= "... <a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=10\">10</a>";
                                $paging .= "... <a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=20\">20</a>";
                                $paging .= "... <a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=50\">50</a>";
                                $paging .= "... <a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($threads[$a]['threadid'])."&amp;page=".$maxpages."\">".$maxpages."</a>";
                            }
                        }
                        if ($paging != "") {
                            $threads[$a]['paging'] = $paging;
                        }
                    }
                    $serendipity['smarty']->assign(
                        array(
                            'pagetitle'         =>  $this->get_config('pagetitle'),
                            'headline'          =>  $this->get_config('headline'),
                            'pageurl'           =>  $this->get_config('pageurl'),
                            'threads'           =>  $threads
                        )
                    );
                } else {
                    $nothreads .= PLUGIN_FORUM_NO_THREADS;
                    $serendipity['smarty']->assign('nothreads', $nothreads);
                }
            }
        } elseif (((intval($_GET['boardid']) >= 1) && (intval($_GET['threadid']) >= 1)) && (!isset($_GET['replyto']) && !isset($_GET['edit']) && !isset($_GET['delete']) && !isset($_GET['quote']))) {
            // POSTS
            $filename = 'templates/postlist.tpl';
            if (!is_object($serendipity['smarty']))
                serendipity_smarty_init();
            $serendipity['smarty']->assign('pagetitle', $this->get_config('pagetitle'));
            $serendipity['smarty']->assign('headline', $this->get_config('headline'));
            if (isset($ERRORMSG) && trim($ERRORMSG) != "") {
                $serendipity['smarty']->assign('ERRORMSG', $ERRORMSG);
            }
            $q = "UPDATE {$serendipity['dbPrefix']}dma_forum_threads SET views = views+1 WHERE threadid = '".intval($_GET['threadid'])."'";
            serendipity_db_query($q);
            // Set the cookie for threadicon (read/unread)
            $cookie = array('setthreadcookie' => intval($_GET['threadid']));
            serendipity_plugin_api::hook_event('external_plugin', $cookie);
            $POSTLIST = "";
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_boards WHERE boardid='".intval($_GET['boardid'])."'";
            $board = serendipity_db_query($sql);
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_threads WHERE threadid='".intval($_GET['threadid'])."'";
            $thread = serendipity_db_query($sql);
            $mainpage_link = "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."\">".$this->get_config('pagetitle')."</a>";
            $threadlist_link = "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."\">".htmlspecialchars($board[0]['name'])."</a>";
            $posts_link = "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($thread[0]['threadid'])."\">".htmlspecialchars($thread[0]['title'])."</a>";
            $serendipity['smarty']->assign('MAINPAGE', $mainpage_link);
            $serendipity['smarty']->assign('THREADLIST', $threadlist_link);
            $serendipity['smarty']->assign('POSTS', $posts_link);
            // paging
            if (isset($_GET['page']) && intval($_GET['page']) >= 1) {
                $page = intval($_GET['page']);
            } else {
                $page = 1;
            }
            $postnum = (intval($thread[0]['replies'])+1);
            $maxpages = ceil($postnum / intval($this->get_config('itemsperpage')));
            if ($maxpages >= 2) {
                if (!isset($page) OR trim($page) == "" OR $page <= 0) {
                    $page = 1;
                }
                if ($page > $maxpages) {
                    $page = $maxpages;
                }
                $multiplicator = (($page * intval($this->get_config('itemsperpage'))) - intval($this->get_config('itemsperpage')));

                if (!isset($page) OR $page == 1) {
                    $LIMIT = serendipity_db_limit(0, intval($this->get_config('itemsperpage')));
                } else {
                    $LIMIT = serendipity_db_limit($multiplicator, intval($this->get_config('itemsperpage')));
                }
                $LIMIT = serendipity_db_limit_sql($LIMIT);
                $paging = "";
                if ($page > 1) {
                    $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($thread[0]['threadid'])."&amp;page=1\">1</a>&nbsp;";
                    $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($thread[0]['threadid'])."&amp;page=".($page - 10)."\">&lt;&lt;</a>&nbsp;";
                    $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($thread[0]['threadid'])."&amp;page=".($page - 1)."\">&lt;</a>&nbsp;&nbsp;";
                } elseif ($page == 1) {
                    $paging .= "[&nbsp;1&nbsp;]&nbsp;";
                }
                if ($maxpages >= 2) {
                    for ($b=($page-5);$b<=($page+5);$b++) {
                        if ($b > 1 AND $b < $maxpages) {
                            if ($b == $page) {
                                $paging .= "[&nbsp;".$b."&nbsp;]&nbsp;";
                            } elseif ($b >= ($maxpages)) {
                            } else {
                                $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($thread[0]['threadid'])."&amp;page=".$b."\">".$b."</a>&nbsp;";
                            }
                        }
                    }
                }
                if ($page < $maxpages) {
                    $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($thread[0]['threadid'])."&amp;page=".($page + 1)."\">&gt;</a>&nbsp;";
                    $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($thread[0]['threadid'])."&amp;page=".($page + 10)."\">&gt;&gt;</a>&nbsp;";
                    $paging .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($thread[0]['threadid'])."&amp;page=".$maxpages."\">".$maxpages."</a>&nbsp;";
                } elseif ($page == $maxpages AND $page != 1) {
                    $paging .= "[&nbsp;".$maxpages."&nbsp;]";
                }
                if (isset($paging) && trim($paging) != "") {
                    $serendipity['smarty']->assign('paging', $paging);
                }
            } else {
                $LIMIT = "";
            }
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_posts WHERE threadid='".intval($_GET['threadid'])."' ORDER BY postdate ASC".$LIMIT;
            $posts = serendipity_db_query($sql);

            if (is_array($posts) && count($posts) >= 1) {
                $serendipity['smarty']->assign('threadtitle', htmlspecialchars($thread[0]['title']));
                $serendipity['smarty']->assign('bgcolor_head', $this->get_config('bgcolor_head'));

                for ($a=0,$b=count($posts);$a<$b;$a++) {
                    if ($thiscolor == $this->get_config('bgcolor2')) { $thiscolor = $this->get_config('bgcolor1'); } else { $thiscolor = $this->get_config('bgcolor2'); }
                    $posts[$a]['color'] = $thiscolor;

                    if ($this->get_config('apply_markup')) {
                        if ($this->get_config('unreg_nomarkups') && (!isset($posts[$a]['authorid']) || intval($posts[$a]['authorid']) <= 0)) {
                            $posts[$a]['message'] = nl2br(htmlspecialchars(trim(stripslashes($posts[$a]['message']))));
                        } else {
                            $temp_array = array('body' => htmlspecialchars(trim(stripslashes($posts[$a]['message']))));
                            serendipity_plugin_api::hook_event('frontend_display', $temp_array);
                            $posts[$a]['message'] = trim($temp_array['body']);
                        }
                    } else {
                        $posts[$a]['message'] = nl2br(htmlspecialchars(trim(stripslashes($posts[$a]['message']))));
                    }




                    unset($email);
                    unset($gravatar_array);
                    unset($posts[$a]['gravatar']);
                    $authorid = intval(trim($posts[$a]['authorid']));
                    if ($authorid >= 1) {


                        $sql = "SELECT email FROM {$serendipity['dbPrefix']}authors WHERE authorid = '".$authorid."'";
                        $email = serendipity_db_query($sql);



                        $gravatar_array = array(
                                            'comment'   => "",
                                            'email'     => trim($email[0][0])
                        );
                        serendipity_plugin_api::hook_event('frontend_display', $gravatar_array);
                        if (isset($gravatar_array['comment']) && trim($gravatar_array['comment']) != "") {
                            $posts[$a]['gravatar'] = $gravatar_array['comment'];
                        }
                    }






                    $POSTBUTTONS = "";
                    if ($thread[0]['flag'] != 1) {
                        $POSTBUTTONS = "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($_GET['threadid'])."&amp;replyto=".$posts[$a]['postid']."&amp;quote=0\"><img src=\"".$this->DMA_forum_getRelPath()."/img/reply.png\" width=\"60\" height=\"18\" border=\"0\" alt=\"".PLUGIN_FORUM_ALT_REPLY."\" title=\"".PLUGIN_FORUM_ALT_REPLY."\" /></a> &nbsp; ";
                        $POSTBUTTONS .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($_GET['threadid'])."&amp;replyto=".$posts[$a]['postid']."&amp;quote=1\"><img src=\"".$this->DMA_forum_getRelPath()."/img/quote.png\" width=\"60\" height=\"18\" border=\"0\" alt=\"".PLUGIN_FORUM_ALT_QUOTE."\" title=\"".PLUGIN_FORUM_ALT_QUOTE."\" /></a> &nbsp; ";
                    }
                    if (serendipity_userLoggedIn() && (($serendipity['serendipityUser'] == $posts[$a]['authorname'] && $serendipity['authorid'] == $posts[$a]['authorid']) || $serendipity['serendipityUserlevel'] == 255)) {
                        $POSTBUTTONS .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($_GET['threadid'])."&amp;page=".$page."&amp;edit=".$posts[$a]['postid']."\"><img src=\"".$this->DMA_forum_getRelPath()."/img/edit.png\" width=\"60\" height=\"18\" border=\"0\" alt=\"".PLUGIN_FORUM_ALT_EDIT."\" title=\"".PLUGIN_FORUM_ALT_EDIT."\" /></a> &nbsp; ";
                    }
                    if (serendipity_userLoggedIn() && $serendipity['serendipityUserlevel'] == 255) {
                        $POSTBUTTONS .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($_GET['threadid'])."&amp;page=".$page."&amp;delete=".$posts[$a]['postid']."\"><img src=\"".$this->DMA_forum_getRelPath()."/img/delete.png\" width=\"60\" height=\"18\" border=\"0\" alt=\"".PLUGIN_FORUM_ALT_DELETE_POST."\" title=\"".PLUGIN_FORUM_ALT_DELETE_POST."\" /></a> &nbsp; ";
                    }
                    $posts[$a]['postbuttons'] = $POSTBUTTONS;

                    $AUTHORDETAILS = "";
                    if (isset($posts[$a]['authorid']) && intval($posts[$a]['authorid']) >= 1) {
                        $AUTHORDETAILS .= "<b>".PLUGIN_FORUM_REG_USER."</b><br />";
                        $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_users WHERE authorid = '".intval($posts[$a]['authorid'])."'";
                        $userdetails = serendipity_db_query($sql);
                        if (is_array($userdetails) && count($userdetails) >= 1) {
                            $AUTHORDETAILS .= PLUGIN_FORUM_POSTS.": ".intval($userdetails[0]['posts'])."<br />";
                            $AUTHORDETAILS .= PLUGIN_FORUM_VISITS.": ".intval($userdetails[0]['visits'])."<br />";
                        } else {
                            $AUTHORDETAILS .= PLUGIN_FORUM_POSTS.": 0<br />";
                            $AUTHORDETAILS .= PLUGIN_FORUM_VISITS.": 0<br />";
                        }
                    }

                    $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_uploads WHERE postid = '".$posts[$a]['postid']."'";
                    $uploads = serendipity_db_query($sql);
                    if (is_array($uploads) && count($uploads) >= 1) {
                        $posts[$a]['uploads'] = true;
                        for($y=0,$z=count($uploads);$y<$z;$y++) {
                            $filesize = DMA_forum_calcFilesize($uploads[$y]['filesize']);
                            $mime = DMA_forum_getMime(htmlspecialchars(basename($uploads[$y]['realfilename'])), $this->DMA_forum_getRelPath());
                            $fileicon = "<img src=\"".$mime['ICON']."\" width=\"18\" height=\"20\" border=\"0\" />";
                            $content_type = $mime['TYPE'];

                            $posts[$a]['upload'][$y]['filename'] = "<a href=\"".$serendipity['baseURL'] . ($serendipity['rewrite'] == "none" ? $serendipity['indexFile'] . "?/" : "") . "plugin/forumdl_".intval($uploads[$y]['uploadid'])."\">".htmlspecialchars(basename($uploads[$y]['realfilename']))."</a>";





                            $posts[$a]['upload'][$y]['filesize'] = $filesize;
                            $posts[$a]['upload'][$y]['fileicon'] = $fileicon;
                            $posts[$a]['upload'][$y]['filetype'] = $content_type;
                            $posts[$a]['upload'][$y]['dlcount'] = intval($uploads[$y]['dlcount']);
                            if (serendipity_userLoggedIn() && (($serendipity['serendipityUserlevel'] == USERLEVEL_ADMIN) || (intval($uploads[$y]['authorid']) == intval($serendipity['authorid'])))) {
                                $posts[$a]['upload'][$y]['delbutton'] = "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($_GET['threadid'])."&amp;page=".$page."&amp;delfile=".intval($uploads[$y]['uploadid'])."#".intval($posts[$a]['postid'])."\">".$DEL_FILE_BUTTON."</a>";
                            }
                        }
                    } else {
                        $posts[$a]['uploads'] = false;
                    }

                    $posts[$a]['authordetails'] = $AUTHORDETAILS;
                    $posts[$a]['title'] = htmlspecialchars($posts[$a]['title']);
                    $posts[$a]['authorname'] = htmlspecialchars($posts[$a]['authorname']);
                    if (intval($posts[$a]['postdate']) >= (intval($yesterday_lasttstamp)+1)) {
                        $posts[$a]['postdate'] = "<span style=\"color:".$this->get_config('color_today').";font-weight:bolder\">".PLUGIN_FORUM_TODAY." ".date($this->get_config('timeformat'), $posts[$a]['postdate'])."</span>";

                    } elseif ((intval($posts[$a]['postdate']) <= intval($yesterday_lasttstamp)) && (intval($posts[$a]['postdate']) >= intval($yesterday_firsttstamp))) {
                        $posts[$a]['postdate'] = "<span style=\"color:".$this->get_config('color_yesterday')."\">".PLUGIN_FORUM_YESTERDAY." ".date($this->get_config('timeformat'), $posts[$a]['postdate'])."</span>";

                    } else {
                        $posts[$a]['postdate'] = date($this->get_config('dateformat')." ".$this->get_config('timeformat'), $posts[$a]['postdate']);
                    }
                }


                if (serendipity_userLoggedIn()) {
                    if (trim($thread[0]['notifymails']) != "") {
                        $NOTIFYARRAY = unserialize(stripslashes(trim($thread[0]['notifymails'])));
                    } else {
                        $NOTIFYARRAY = array();
                    }
                    if (in_array($serendipity['email'], $NOTIFYARRAY)) {
                        $serendipity['smarty']->assign('notify', 2);
                    } else {
                        $serendipity['smarty']->assign('notify', 1);
                    }
                    $subscribeurl = $serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($_GET['threadid'])."&amp;page=".$page."&amp;subscribe=1";
                    $unsubscribeurl = $serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($_GET['threadid'])."&amp;page=".$page."&amp;unsubscribe=1";
                    $serendipity['smarty']->assign('subscribeurl', $subscribeurl);
                    $serendipity['smarty']->assign('unsubscribeurl', $unsubscribeurl);
                }



                $serendipity['smarty']->assign(
                    array(
                        'pagetitle'         =>  $this->get_config('pagetitle'),
                        'headline'          =>  $this->get_config('headline'),
                        'pageurl'           =>  $this->get_config('pageurl'),
                        'posts'             =>  $posts
                    )
                );
            } else {
                $noposts = PLUGIN_FORUM_NO_POSTS;
                $serendipity['smarty']->assign('noposts', $noposts);
            }

            // Display thread buttons regardless of number of posts
            $THREADBUTTONS = "";
            if (serendipity_userLoggedIn() && $serendipity['serendipityUserlevel'] == 255) {
                    if ($thread[0]['flag'] == 1) {
                            $THREADBUTTONS .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($_GET['threadid'])."&amp;action=reopen\"><img src=\"".$this->DMA_forum_getRelPath()."/img/reopen.png\" width=\"60\" height=\"18\" border=\"0\" alt=\"".PLUGIN_FORUM_ALT_REOPEN."\" title=\"".PLUGIN_FORUM_ALT_REOPEN."\" /></a> &nbsp; ";
                    } else {
                            $THREADBUTTONS .= "<a href=\"".$serendipity['baseURL']."index.php?serendipity[subpage]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($_GET['threadid'])."&amp;action=close\"><img src=\"".$this->DMA_forum_getRelPath()."/img/close.png\" width=\"60\" height=\"18\" border=\"0\" alt=\"".PLUGIN_FORUM_ALT_CLOSE."\" title=\"".PLUGIN_FORUM_ALT_CLOSE."\" /></a> &nbsp; ";
                    }
                    $THREADBUTTONS .= "<a href=\"".$serendipity['baseURL']."serendipity_admin.php?serendipity[adminModule]=event_display&serendipity[adminAction]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($_GET['threadid'])."&amp;action=move\"><img src=\"".$this->DMA_forum_getRelPath()."/img/move.png\" width=\"60\" height=\"18\" border=\"0\" alt=\"".PLUGIN_FORUM_ALT_MOVE."\" title=\"".PLUGIN_FORUM_ALT_MOVE."\" /></a> &nbsp; ";
                    $THREADBUTTONS .= "<a href=\"".$serendipity['baseURL']."serendipity_admin.php?serendipity[adminModule]=event_display&serendipity[adminAction]=".$this->get_config('pageurl')."&amp;boardid=".intval($_GET['boardid'])."&amp;threadid=".intval($_GET['threadid'])."&amp;action=delete\"><img src=\"".$this->DMA_forum_getRelPath()."/img/delete.png\" width=\"60\" height=\"18\" border=\"0\" alt=\"".PLUGIN_FORUM_ALT_DELETE."\" title=\"".PLUGIN_FORUM_ALT_DELETE."\" /></a>";
            }
            $serendipity['smarty']->assign('THREADBUTTONS', $THREADBUTTONS);
        }

        $filename = $filename;
        $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
        if (!$tfile || $tfile == $filename) {
            $tfile = dirname(__FILE__) . '/' . $filename;
        }
        $inclusion = $serendipity['smarty']->security_settings[INCLUDE_ANY];
        $serendipity['smarty']->security_settings[INCLUDE_ANY] = true;
        $content = $serendipity['smarty']->fetch('file:'. $tfile);
        $serendipity['smarty']->security_settings[INCLUDE_ANY] = $inclusion;
        echo $content;
    }





    function forumAdmin() {
        global $serendipity;
        if (!headers_sent()) {
            header('HTTP/1.0 200');
            header('Status: 200 OK');
        }
        $adminurl = $serendipity['baseURL']."serendipity_admin.php?serendipity[adminModule]=event_display&serendipity[adminAction]=".$this->get_config('pageurl');
        $up     = "<img src=\"".$serendipity['baseURL']."templates/default/admin/img/uparrow.png\" width=\"16\" height=\"16\" border=\"0\" />";
        $down     = "<img src=\"".$serendipity['baseURL']."templates/default/admin/img/downarrow.png\" width=\"16\" height=\"16\" border=\"0\" />";
        $ERRORMSG = "";
        $OUTPUT = "";
        $OUTPUT .= "<h2>".PLUGIN_FORUM_TITLE."</h2>\n";
        $OUTPUT .= PLUGIN_FORUM_DESC."<br /><br />\n";


        // POST part
        if (isset($serendipity['POST']['action']) && (trim($serendipity['POST']['action']) == "delete" && (is_array($serendipity['POST']['delboard']) || trim($serendipity['POST']['s_delboard']) != ""))) {
            // Delete boards
            if (!isset($serendipity['POST']['s_delboard']) || trim($serendipity['POST']['s_delboard']) == "") {
                $delboards = $serendipity['POST']['delboard'];
                $OUTPUT .= "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">
                    <form action=\"?\" name=\"boardsdeleteform\" method=\"POST\">
                        <div>
                            <input type=\"hidden\" name=\"serendipity[adminModule]\" value=\"event_display\" />
                            <input type=\"hidden\" name=\"serendipity[adminAction]\" value=\"".$this->get_config('pageurl')."\" />
                            <input type=\"hidden\" name=\"serendipity[action]\" value=\"delete\" />
                            <input type=\"hidden\" name=\"serendipity[s_delboard]\" value=\"".addslashes(str_replace("\"", "M", trim(serialize($delboards))))."\" />
                        </div>
                    <tr style=\"background-color: ".$this->get_config('bgcolor2').";\">
                        <td align=\"center\"><b>".str_replace("{num}", count($delboards), PLUGIN_FORUM_REALLY_DELETE_BOARDS)."</b></td>
                    </tr>
                    <tr style=\"background-color: ".$this->get_config('bgcolor2').";\">
                        <td align=\"center\">".PLUGIN_FORUM_DELETE_OR_MOVE."<br />".PLUGIN_FORUM_WHERE_TO_MOVE."<br />
                            <select name=\"serendipity[moveto]\">
                                <option value=\"delete\" selected> ---------- ".DELETE." ---------- </option>\n";
                                $WHERE = "";
                                foreach($delboards AS $id) {
                                    if ($WHERE != "") {
                                        $WHERE .= " AND ";
                                    }
                                    $WHERE .= "boardid != '".$id."'";
                                }
                                $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_boards WHERE ".$WHERE." ORDER BY sortorder";
                                $boards = serendipity_db_query($sql);
                                if (is_array($boards) && count($boards) >= 1) {
                                    foreach($boards AS $board) {
                                        $OUTPUT .= "<option value=\"".intval($board['boardid'])."\">".trim(stripslashes($board['name']))."</option>\n";
                                    }
                                }
                $OUTPUT .= "    </select>
                        </td>
                    </tr>
                    <tr height=\"60\" style=\"background-color: ".$this->get_config('bgcolor1').";\">
                        <td align=\"center\">
                            <input type=\"image\" src=\"".$this->DMA_forum_getRelPath()."/img/yes.png\" style=\"width: 60px;\" width=\"60\" name=\"serendipity[yes]\" value=\"".YES."\" /> &nbsp;
                            <input type=\"image\" src=\"".$this->DMA_forum_getRelPath()."/img/no.png\" style=\"width: 60px;\" width=\"60\" name=\"serendipity[no]\" value=\"".NO."\" />
                        </td>
                    </tr>
                    </form>
                </table>\n";
            } elseif(trim($serendipity['POST']['s_delboard']) != "" && isset($serendipity['POST']['yes']) && $serendipity['POST']['yes'] != "") {
                $delboards = unserialize(str_replace("M", "\"", trim(stripslashes($serendipity['POST']['s_delboard']))));
                DMA_forum_DeleteBoards($delboards, $serendipity['POST']['moveto'], $this->get_config('uploaddir'));
            }
        } elseif (isset($serendipity['POST']['action']) && trim($serendipity['POST']['action']) == "edit" && intval($serendipity['POST']['boardid']) >= 1) {
            // EDIT boards
            $boardid = intval($serendipity['POST']['boardid']);
            $sql = "UPDATE {$serendipity['dbPrefix']}dma_forum_boards SET
                            name = '".serendipity_db_escape_string(trim($serendipity['POST']['name']))."',
                            description = '".serendipity_db_escape_string(trim($serendipity['POST']['description']))."'
                    WHERE   boardid = '".$boardid."'";
            serendipity_db_query($sql);
        } elseif (isset($serendipity['POST']['action']) && trim($serendipity['POST']['action']) == "new") {
            // Add NEW board
            $LIMIT = serendipity_db_limit(0, 1);
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_boards ORDER BY sortorder DESC LIMIT ".$LIMIT;
            $lastsort = serendipity_db_query($sql);
            if (!is_array($lastsort) || !isset($lastsort[0]['sortorder'])) {
                $newsort = 0;
            } else {
                $newsort = intval($lastsort[0]['sortorder']) + 1;
            }
            $sql = "INSERT INTO {$serendipity['dbPrefix']}dma_forum_boards (
                            name,
                            description,
                            sortorder
                ) VALUES (
                            '".serendipity_db_escape_string(trim($serendipity['POST']['name']))."',
                            '".serendipity_db_escape_string(trim($serendipity['POST']['description']))."',
                            '".$newsort."'
                )";
            serendipity_db_query($sql);
        } elseif (isset($serendipity['POST']['action']) && trim($serendipity['POST']['action']) == "move") {
            // move thread
            $sql = "UPDATE {$serendipity['dbPrefix']}dma_forum_threads SET
                            boardid = '".intval($serendipity['POST']['moveto'])."'
                    WHERE   threadid = '".intval($serendipity['POST']['threadid'])."'";
            serendipity_db_query($sql);
            DMA_forum_CheckLastProperties(intval($serendipity['POST']['boardid']));
            DMA_forum_CheckLastProperties(intval($serendipity['POST']['moveto']));
        } elseif (isset($serendipity['POST']['action']) && trim($serendipity['POST']['action']) == "delete" && trim($serendipity['POST']['yes']) != "") {
            // delete thread
            $sql = "DELETE FROM {$serendipity['dbPrefix']}dma_forum_threads
                    WHERE   threadid = '".intval($serendipity['POST']['threadid'])."'";
            serendipity_db_query($sql);
            $q = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_posts WHERE threadid = '".intval($serendipity['POST']['threadid'])."'";
            $posts = serendipity_db_query($q);
            if (is_array($posts) && count($posts) >= 1) {
                foreach ($posts AS $post) {
                    $q = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_uploads WHERE postid = '".intval($post['postid'])."'";
                    $uploads = serendipity_db_query($q);
                    if (is_array($uploads) && count($uploads) >= 1) {
                        foreach ($uploads AS $upload) {
                            @unlink($this->get_config('uploaddir')."/".$upload['sysfilename']);
                        }
                        $q = "DELETE FROM {$serendipity['dbPrefix']}dma_forum_uploads WHERE postid = '".intval($post['postid'])."'";
                        $sql = serendipity_db_query($q);
                    }
                }
                $sql = "DELETE FROM {$serendipity['dbPrefix']}dma_forum_posts WHERE threadid = '".intval($serendipity['POST']['threadid'])."'";
                serendipity_db_query($sql);
            }
            DMA_forum_CheckLastProperties(intval($serendipity['POST']['boardid']));
        }












        // GET part
        if (isset($_GET['action']) && (trim($_GET['action']) == "down" || trim($_GET['action']) == "up")) {
            //  Reorder the boards
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_boards ORDER BY sortorder";
            $boards = serendipity_db_query($sql);
            $idx_to_move = -1;
            for($idx = 0; $idx < count($boards); $idx++) {
                $boards[$idx]['sortorder'] = $idx;
                if ($boards[$idx]['boardid'] == intval($_GET['boardid'])) {
                    $idx_to_move = $idx;
                }
            }
            if ($idx_to_move >= 0 && ((trim($_GET['action']) == 'down' && $idx_to_move < (count($boards)-1)) || (trim($_GET['action']) == 'up' && $idx_to_move > 0))) {
                $tmp = $boards[$idx_to_move]['sortorder'];
                $boards[$idx_to_move]['sortorder'] = (int)$boards[$idx_to_move + (trim($_GET['action']) == 'down' ? 1 : -1)]['sortorder'];
                $boards[$idx_to_move + (trim($_GET['action']) == 'down' ? 1 : -1)]['sortorder'] = (int)$tmp;
                foreach($boards as $board) {
                    $key = intval($board['boardid']);
                    serendipity_db_query("UPDATE {$serendipity['dbPrefix']}dma_forum_boards SET sortorder = {$board['sortorder']} WHERE boardid='$key'");
                }
            }
            $_GET['action'] = "";
        } elseif (isset($_GET['action']) && trim($_GET['action']) == "edit") {
            // Edit board
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_boards WHERE boardid = '".intval($_GET['boardid'])."'";
            $board = serendipity_db_query($sql);
            $OUTPUT .= "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">
                <form action=\"?\" name=\"boardseditform\" method=\"POST\">
                    <div>
                        <input type=\"hidden\" name=\"serendipity[adminModule]\" value=\"event_display\" />
                        <input type=\"hidden\" name=\"serendipity[adminAction]\" value=\"".$this->get_config('pageurl')."\" />
                        <input type=\"hidden\" name=\"serendipity[action]\" value=\"edit\" />
                        <input type=\"hidden\" name=\"serendipity[boardid]\" value=\"".intval($_GET['boardid'])."\" />
                    </div>
                <tr style=\"background-color: ".$this->get_config('bgcolor2').";\">
                    <td width=\"130\"><b>".PLUGIN_FORUM_BOARDNAME."</b></td><td><input class=\"input_textbox\" style=\"width: 100%;\" width=\"100%\" type=\"text\" name=\"serendipity[name]\" value=\"".stripslashes(trim($board[0]['name']))."\" /></td>
                </tr>
                <tr style=\"background-color: ".$this->get_config('bgcolor1').";\">
                    <td width=\"130\"><b>".PLUGIN_FORUM_BOARDDESC."</b></td><td><textarea style=\"width: 100%;\" rows=\"3\" width=\"100%\" name=\"serendipity[description]\">".stripslashes(trim($board[0]['description']))."</textarea></td>
                </tr>
                <tr style=\"background-color: ".$this->get_config('bgcolor2').";\">
                    <td colspan=\"2\" align=\"center\"><input class=\"serendipityPrettyButton input_button\" type=\"submit\" name=\"serendipity[submit]\" value=\"".PLUGIN_FORUM_SUBMIT."\" /></td>
                </tr>
                </form>
            </table>\n";
        } elseif (isset($_GET['action']) && trim($_GET['action']) == "new") {
            // Add NEW board
            $OUTPUT .= "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">
                <form action=\"?\" name=\"boardnewform\" method=\"POST\">
                    <div>
                        <input type=\"hidden\" name=\"serendipity[adminModule]\" value=\"event_display\" />
                        <input type=\"hidden\" name=\"serendipity[adminAction]\" value=\"".$this->get_config('pageurl')."\" />
                        <input type=\"hidden\" name=\"serendipity[action]\" value=\"new\" />
                    </div>
                <tr style=\"background-color: ".$this->get_config('bgcolor2').";\">
                    <td width=\"130\"><b>".PLUGIN_FORUM_BOARDNAME."</b></td><td><input class=\"input_textbox\" style=\"width: 100%;\" width=\"100%\" type=\"text\" name=\"serendipity[name]\" value=\"\" /></td>
                </tr>
                <tr style=\"background-color: ".$this->get_config('bgcolor1').";\">
                    <td width=\"130\"><b>".PLUGIN_FORUM_BOARDDESC."</b></td><td><textarea style=\"width: 100%;\" rows=\"3\" width=\"100%\" name=\"serendipity[description]\"></textarea></td>
                </tr>
                <tr style=\"background-color: ".$this->get_config('bgcolor2').";\">
                    <td colspan=\"2\" align=\"center\"><input class=\"serendipityPrettyButton input_button\" type=\"submit\" name=\"serendipity[submit]\" value=\"".PLUGIN_FORUM_SUBMIT."\" /></td>
                </tr>
                </form>
            </table>\n";
        } elseif (isset($_GET['action']) && trim($_GET['action']) == "move") {
            // Move thread
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_threads WHERE threadid = '".intval($_GET['threadid'])."'";
            $thisthread = serendipity_db_query($sql);
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_boards WHERE boardid = '".intval($_GET['boardid'])."'";
            $thisboard = serendipity_db_query($sql);
            $OUTPUT .= "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">
                <form action=\"?\" name=\"movethreadform\" method=\"POST\">
                    <div>
                        <input type=\"hidden\" name=\"serendipity[adminModule]\" value=\"event_display\" />
                        <input type=\"hidden\" name=\"serendipity[adminAction]\" value=\"".$this->get_config('pageurl')."\" />
                        <input type=\"hidden\" name=\"serendipity[action]\" value=\"move\" />
                        <input type=\"hidden\" name=\"serendipity[boardid]\" value=\"".intval($_GET['boardid'])."\" />
                        <input type=\"hidden\" name=\"serendipity[threadid]\" value=\"".intval($_GET['threadid'])."\" />
                    </div>
                <tr style=\"background-color: ".$this->get_config('bgcolor2').";\">
                    <td align=\"center\"><b>".PLUGIN_FORUM_MOVE_THREAD."</b><br />&quot;".stripslashes(trim($thisthread[0]['title']))."&quot;<br />
                    ".PLUGIN_FORUM_FROM_BOARD." &quot;".$thisboard[0]['name']."&quot; ".PLUGIN_FORUM_TO_BOARD.":</td>
                </tr>
                <tr style=\"background-color: ".$this->get_config('bgcolor2').";\">
                    <td align=\"center\"><select name=\"serendipity[moveto]\">\n";
                            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_boards WHERE boardid != '".intval($_GET['boardid'])."' ORDER BY sortorder";
                            $boards = serendipity_db_query($sql);
                            if (is_array($boards) && count($boards) >= 1) {
                                foreach($boards AS $board) {
                                    $OUTPUT .= "<option value=\"".intval($board['boardid'])."\">".trim(stripslashes($board['name']))."</option>\n";
                                }
                            }
            $OUTPUT .= "    </select>
                    </td>
                </tr>
                <tr height=\"60\" style=\"background-color: ".$this->get_config('bgcolor1').";\">
                    <td align=\"center\">
                        <input class=\"serendipityPrettyButton input_button\" type=\"submit\"  name=\"serendipity[submit]\" value=\"".PLUGIN_FORUM_MOVE."\" /> &nbsp;
                    </td>
                </tr>
                </form>
            </table>\n";
        } elseif (isset($_GET['action']) && trim($_GET['action']) == "delete") {
            // delete thread
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_threads WHERE threadid = '".intval($_GET['threadid'])."'";
            $thisthread = serendipity_db_query($sql);
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_boards WHERE boardid = '".intval($_GET['boardid'])."'";
            $thisboard = serendipity_db_query($sql);
            $OUTPUT .= "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">
                <form action=\"?\" name=\"threaddeleteform\" method=\"POST\">
                    <div>
                        <input type=\"hidden\" name=\"serendipity[adminModule]\" value=\"event_display\" />
                        <input type=\"hidden\" name=\"serendipity[adminAction]\" value=\"".$this->get_config('pageurl')."\" />
                        <input type=\"hidden\" name=\"serendipity[action]\" value=\"delete\" />
                        <input type=\"hidden\" name=\"serendipity[boardid]\" value=\"".intval($_GET['boardid'])."\" />
                        <input type=\"hidden\" name=\"serendipity[threadid]\" value=\"".intval($_GET['threadid'])."\" />
                    </div>
                <tr style=\"background-color: ".$this->get_config('bgcolor2').";\">
                    <td align=\"center\"><b>".PLUGIN_FORUM_REALLY_DELETE_THREAD."</b><br />&quot;".stripslashes(trim($thisthread[0]['title']))."&quot;</td>
                </tr>
                <tr height=\"60\" style=\"background-color: ".$this->get_config('bgcolor1').";\">
                    <td align=\"center\">
                        <input type=\"image\" src=\"".$this->DMA_forum_getRelPath()."/img/yes.png\" style=\"width: 60px;\" width=\"60\" name=\"serendipity[yes]\" value=\"1".YES."\" /> &nbsp;
                        <input type=\"image\" src=\"".$this->DMA_forum_getRelPath()."/img/no.png\" style=\"width: 60px;\" width=\"60\" name=\"serendipity[no]\" value=\"".NO."\" />
                    </td>
                </tr>
                </form>
            </table>\n";
        }

        /*
        echo "<pre>";
        print_r($serendipity);
        echo "</pre>";
        */

        unset($_GET);
        unset($_POST);
        if (!isset($_GET['action']) || trim($_GET['action']) == "") {
            // Main Admin page (Boardlist)
            unset($boards);
            unset($board);
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_boards ORDER BY sortorder";
            $boards = serendipity_db_query($sql);
            $num = count($boards);
            $OUTPUT .= "<div align=\"right\"><b>[ <a href=\"".$adminurl."&amp;action=new\">".PLUGIN_FORUM_ADD_BOARD."</a> ]</b></div><br />\n";
            $OUTPUT .= "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">\n";
            if (is_array($boards) && $num >= 1) {
                $OUTPUT .= "<tr style=\"background-color: ".$this->get_config('bgcolor_head').";\">\n";
                $OUTPUT .= "<td width=\"18\">&nbsp;</td>\n";
                $OUTPUT .= "<td><b>".PLUGIN_FORUM_BOARDS."</b></td>\n";
                $OUTPUT .= "<td width=\"60\" align=\"right\"><b>".PLUGIN_FORUM_THREADS."</b></td>\n";
                $OUTPUT .= "<td width=\"60\" align=\"right\"><b>".PLUGIN_FORUM_POSTS."</b></td>\n";
                $OUTPUT .= "<td width=\"60\"><b>".PLUGIN_FORUM_ORDER."</b></td>\n";
                $OUTPUT .= "</tr>\n";
                $OUTPUT .= "    <form action=\"?\" name=\"boardsdeleteform\" method=\"POST\">\n";
                $OUTPUT .= "        <div>\n";
                $OUTPUT .= "            <input type=\"hidden\" name=\"serendipity[adminModule]\" value=\"event_display\" />\n";
                $OUTPUT .= "            <input type=\"hidden\" name=\"serendipity[adminAction]\" value=\"".$this->get_config('pageurl')."\" />\n";
                $OUTPUT .= "            <input type=\"hidden\" name=\"serendipity[action]\" value=\"delete\" />\n";
                $OUTPUT .= "        </div>\n";
                foreach($boards AS $board) {
                    if ($thiscolor == $this->get_config('bgcolor2')) { $thiscolor = $this->get_config('bgcolor1'); } else { $thiscolor = $this->get_config('bgcolor2'); }
                    $OUTPUT .= "<tr style=\"background-color: ".$thiscolor.";\">\n";
                    $OUTPUT .= "<td width=\"18\"><input class=\"input_checkbox\" type=\"checkbox\" name=\"serendipity[delboard][]\" value=\"".intval($board['boardid'])."\" /></td>\n";
                    $OUTPUT .= "<td><a href=\"".$adminurl."&amp;action=edit&amp;boardid=".intval($board['boardid'])."\"><b>".$board['name']."</b></a></td>\n";
                    $OUTPUT .= "<td width=\"60\" align=\"right\">".intval($board['threads'])."</td>\n";
                    $OUTPUT .= "<td width=\"60\" align=\"right\">".intval($board['posts'])."</td>\n";
                    $OUTPUT .= "<td width=\"60\" align=\"center\">\n";
                    if ($num <= 1) {
                        $OUTPUT .= "&nbsp;\n";
                    } elseif ($num >= 2 && intval($board['sortorder']) == 0) {
                        $OUTPUT .= "<a href=\"".$adminurl."&amp;action=down&amp;boardid=".intval($board['boardid'])."\">".$down."</a>\n";
                    } elseif ($num >= 2 && (intval($board['sortorder']) >= 1 && intval($board['sortorder']) <= ($num-2))) {
                        $OUTPUT .= "<a href=\"".$adminurl."&amp;action=up&amp;boardid=".intval($board['boardid'])."\">".$up."</a>&nbsp&nbsp;\n";
                        $OUTPUT .= "<a href=\"".$adminurl."&amp;action=down&amp;boardid=".intval($board['boardid'])."\">".$down."</a>\n";
                    } elseif ($num >= 2 && intval($board['sortorder']) == ($num-1)) {
                        $OUTPUT .= "<a href=\"".$adminurl."&amp;action=up&amp;boardid=".intval($board['boardid'])."\">".$up."</a>&nbsp&nbsp;\n";
                    }
                    $OUTPUT .= "</td>\n";
                    $OUTPUT .= "</tr>\n";
                }
                $OUTPUT .= "<tr style=\"background-color: ".$this->get_config('bgcolor_head').";\">\n";
                $OUTPUT .= "<td colspan=\"5\"><input class=\"serendipityPrettyButton input_button\" type=\"submit\" name=\"serendipity[submit]\" value=\"".DELETE."\" /></td>\n";
                $OUTPUT .= "</tr>\n";
                $OUTPUT .= "</form>\n";
            } else {
                $OUTPUT .= "<tr><td><div align=\"center\"><b>".PLUGIN_FORUM_NO_BOARDS."</b></div></td></tr>\n";
            }
            $OUTPUT .= "</table>\n";
        }
        echo $OUTPUT;
    }







    function generate_content(&$title) {
        global $serendipity;
        if (!headers_sent()) {
            header('HTTP/1.0 200');
            header('Status: 200 OK');
        }
        $title = PLUGIN_FORUM_TITLE.' ('.$this->get_config('pageurl').')';
        if ($serendipity['GET']['subpage'] == $this->get_config('pageurl')) {
            $serendipity['head_title'] = $this->get_config('pagetitle');
            $serendipity['head_subtitle'] = $this->get_config('headline');
        }
    }

    function install() {
        $this->setupDB();
    }

    function logMSG($msg, $forceOutput = false) {
        global $serendipity;
        $debug = false;
        
        if (empty($msg)) {
            return false;
        }

        $fp = @fopen($serendipity['serendipityPath'] . '/templates_c/forum.log', 'a');
        if ($fp) {
            fwrite($fp, $_SERVER['REQUEST_URI'] . "\n" . date('d.m.Y H:i') . ': ' . $msg . "\n");
            fclose($fp);
        }

        if ($forceOutput) {
            echo $msg;
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        static $phpbb_mirror = null;

        if ($phpbb_mirror == null) {
            $phpbb_mirror = $this->get_config('phpbb_mirror');
            if ((int)$phpbb_mirror === 4) {
                $phpbb_mirror = 4;
            } elseif ((int)$phpbb_mirror === 3) {
                $phpbb_mirror = 3;
            } elseif ((int)$phpbb_mirror === 2) {
                $phpbb_mirror = 2;
            } elseif (serendipity_db_bool($phpbb_mirror)) {
                $phpbb_mirror = 2;
            } else {
                $phpbb_mirror = false;
            }
        }

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {


                case 'entries_header' :
                    $this->show();
                    return true;
                    break;



                case 'entry_display' :
                    if (($serendipity['GET']['subpage'] == $this->get_config('pageurl'))) {
                        if (is_array($eventData)) {
                            $eventData['clean_page'] = true;
                        } else {
                            $eventData = array ('clean_page' => true);
                        }
                    }
                    return true;
                    break;



                case 'backend_sidebar_entries':
                    $this->setupDB();
                    if ($serendipity['serendipityUserlevel'] < USERLEVEL_ADMIN) {
                        break;
                    } else {
                    ?>
                    <li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=forum"><?php echo PLUGIN_FORUM_TITLE; ?></a></li>
                    <?php
                    }
                    break;



                case 'backend_sidebar_entries_event_display_forum':
                    if ($serendipity['serendipityUserlevel'] < USERLEVEL_ADMIN) {
                        break;
                    } else {
                        $this->forumAdmin();
                    }
                    break;


                case 'external_plugin':
                    if (isset($eventData['setthreadcookie']) && intval($eventData['setthreadcookie']) >= 1) {
                        $threadid = intval($eventData['setthreadcookie']);
                        if (is_array($_COOKIE) && trim($_COOKIE['s9yread']) != "") {
                            $READARRAY = unserialize(stripslashes(trim($_COOKIE['s9yread'])));
                        } else {
                            $READARRAY = array();
                        }
                        $READARRAY[$threadid] = time();
                        $READCOOKIE = addslashes(trim(serialize($READARRAY)));
                        setcookie("s9yread", "$READCOOKIE", time()+31536000, "/");
                    }

                    $theUri = (string)str_replace('&amp;', '&', $eventData);
                    $uri_parts = explode('?', $theUri);

                    // Try to get reguest parameters from eventData name
                    if (!empty($uri_parts[1])) {
                        $reqs = explode('&', $uri_parts[1]);
                        foreach($reqs AS $id => $req) {
                            $val = explode('=', $req);
                            if (empty($_REQUEST[$val[0]])) {
                                $_REQUEST[$val[0]] = $val[1];
                            }
                        }
                    }


                    $parts     = explode('_', $uri_parts[0]);
                    if (!empty($parts[1])) {
                        $param     = (int) $parts[1];
                    } else {
                        $param     = null;
                    }

                    switch($parts[0]) {
                        case 'forumdl':

                            $fileid = intval($parts[1]);

                            serendipity_db_query("UPDATE {$serendipity['dbPrefix']}dma_forum_uploads SET dlcount = dlcount+1 WHERE uploadid = ".$fileid);

                            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_uploads WHERE uploadid = ".$fileid;
                            $file = serendipity_db_query($sql);
                            $mime = DMA_forum_getMime(basename($file[0]['realfilename']), $this->DMA_forum_getRelPath());
                            $contenttype = $mime['TYPE'];


                            $filename = basename($file[0]['realfilename']);
                            $path = $this->get_config('uploaddir');
                            $sysname = basename($file[0]['sysfilename']);
                            $filesize = $file[0]['filesize'];

                            if (function_exists("getallheaders")) {
                                $headers = getallheaders();
                            }

                            if (substr($headers["Range"], 0, 6) == "bytes=") {
                                header("HTTP/1.1 206 Partial Content");
                                header("Content-Type: $contenttype");
                                header("Content-Disposition: attachment; filename=".$filename);
                                header("Accept-Ranges: bytes");
                                header("Connection: close");
                                $bytes = explode("=",$headers["Range"]);
                                $bytes = $bytes[1];
                                if (preg_match("@^-([0-9]+)@", $bytes, $bytes_len)) {
                                    $bytes_len = $bytes_len[1];
                                    $bytes_start = $filesize - $bytes_len;
                                    $bytes_end = $filesize - 1;
                                    header("Content-Length: ".$bytes_len);
                                } elseif (preg_match("@([0-9]+)-$@", $bytes, $bytes_start)) {
                                    $bytes_start = $bytes_start[1];
                                    $bytes_end = $filesize - 1;
                                    $bytes_len = $filesize - $bytes_start;
                                    header("Content-Length: $bytes_len");
                                } elseif (preg_match("@^([0-9]+)-([0-9]+)$@", $bytes, $bytes_pos))
                                    {
                                    $bytes_start = $bytes_pos[0];
                                    $bytes_end = $bytes_pos[1];
                                    if ($bytes_start < 0 || $bytes_start > ($filesize - 1)) {
                                        $bytes_start = 0;
                                    }
                                    if ($bytes_end < $bytes_start || $bytes_end > ($filesize - 1)) {
                                        $bytes_end = $filesize - 1;
                                    }
                                    $bytes_len = $bytes_end - $bytes_start + 1;
                                    header("Content-Length: $bytes_len");
                                } else {
                                    $bytes_start = 0;
                                    $bytes_end = $filesize - 1;
                                    $bytes_len = $bytes_end - $bytes_start + 1;
                                    header("Content-Length: $bytes_len");
                                }
                                header("Content-Range: bytes $bytes_start-$bytes_end/".$filesize);
                                $fp = fopen($path."/".$sysname,"rb");
                                fseek($fp, $bytes_start);
                                $contents = fread ($fp, $bytes_len );
                                fclose($fp);
                                echo $contents;
                            } else {
                                $fp = fopen($path."/".$sysname,"rb");
                                $contents = fread ($fp, $filesize);
                                fclose($fp);
                                header("Content-Type: $contenttype");
                                header("Content-Disposition: attachment; filename=".$filename);
                                header("Accept-Ranges: bytes");
                                header("Content-Length: " . strlen($contents));
                                header("Connection: close");
                                echo $contents;
                            }

                            break;
                    }

                    return true;
                    break;


                case 'backend_save':
                case 'backend_publish':
                    if (!$phpbb_mirror) {
                        #$this->logMSG('Forum mirroring is disabled');
                        return false;
                    }

                    $con = mysql_connect($this->get_config('phpbb_db_host'), $this->get_config('phpbb_db_user'), $this->get_config('phpbb_db_pw'));
                    if (!$con) {
                        $this->logMSG('Could not connect to database');
                        return false;
                    }

                    if (!mysql_select_db($this->get_config('phpbb_db_name'), $con)) {
                        $this->logMSG('Could not select database');
                        return false;
                    }

                    if (mysql_error() != '') {
                        $this->logMSG(mysql_error(), true);
                        return false;
                    }

                    mysql_query("SET NAMES " . SQL_CHARSET);

                    $prefix = $this->get_config('phpbb_db_prefix');
                    $fid    = (int)$this->get_config('phpbb_forum');
                    $topic_poster = (int)$this->get_config('phpbb_poster');
                    
                    if ($phpbb_mirror == 4) {
                        $tp = mysql_query("SELECT realName AS username FROM {$prefix}members WHERE ID_MEMBER = $topic_poster");
                    } else {
                        $tp = mysql_query("SELECT username FROM {$prefix}users WHERE user_id = $topic_poster");
                    }
                    if (mysql_num_rows($tp) > 0) {
                        $topic_poster_data = mysql_fetch_array($tp, MYSQL_ASSOC);
                    }
                    

                    if ($event == 'backend_save') {
                        $r = serendipity_db_query("SELECT value, property
                                                     FROM {$serendipity['dbPrefix']}entryproperties
                                                    WHERE entryid = " . (int)$eventData['id'] . "
                                                      AND (property = 'phpbb_topic' OR property = 'phpbb_post')", false, 'assoc', false, 'property');

                        if (empty($r['phpbb_post']['value']) || empty($r['phpbb_topic']['value'])) {
                            #$this->logMSG('Could not get phpbb reference for entry ' . $eventData['id']);
                            return false;
                        }

                        if ($phpbb_mirror == 4) {
                        } else {
                            mysql_query("UPDATE {$prefix}topics
                                            SET topic_title = '" . serendipity_db_escape_string($eventData['title']) . "'
                                          WHERE topic_id = " . (int)$r['phpbb_topic']['value'], $con);
                        }
                        $this->logMSG(mysql_error(), true);

                        if ($phpbb_mirror == 4) {
                            mysql_query("UPDATE {$prefix}messages
                                            SET subject = '" . serendipity_db_escape_string($eventData['title']) . "',
                                                body    = '" . serendipity_db_escape_string($eventData['body'] . $eventData['extended']) . "',
                                                modifiedTime = '" . time() . "',
                                                posterTime = '" . time() . "'
                                          WHERE ID_MSG = " . (int)$r['phpbb_post']['value'], $con);
                        } elseif ($phpbb_mirror == 3) {
                            mysql_query("UPDATE {$prefix}posts
                                            SET post_subject = '" . serendipity_db_escape_string($eventData['title']) . "',
                                                post_text    = '" . serendipity_db_escape_string($eventData['body'] . $eventData['extended']) . "',
                                                topic_last_post_time = '" . time() . "'
                                          WHERE post_id = " . (int)$r['phpbb_post']['value'], $con);
                        } else {
                            mysql_query("UPDATE {$prefix}posts_text
                                            SET post_subject = '" . serendipity_db_escape_string($eventData['title']) . "',
                                                post_text    = '" . serendipity_db_escape_string($eventData['body'] . $eventData['extended']) . "'
                                          WHERE post_id = " . (int)$r['phpbb_post']['value'], $con);
                        }              
                        $this->logMSG(mysql_error(), true);

                        return true;
                    }

                    if ($phpbb_mirror == 4) {
                        mysql_query("INSERT INTO {$prefix}topics (ID_BOARD, ID_FIRST_MSG, ID_LAST_MSG, ID_MEMBER_STARTED, ID_MEMBER_UPDATED)
                                          VALUES ($fid, $topic_poster, $topic_poster, $topic_poster, $topic_poster)", $con);
                    } elseif ($phpbb_mirror == 3) {
                        mysql_query("INSERT INTO {$prefix}topics (forum_id, topic_title, topic_poster, topic_time, topic_first_post_id, topic_last_post_id, topic_first_poster_name, topic_last_post_time, topic_last_poster_id)
                                          VALUES ($fid, '" . serendipity_db_escape_string($eventData['title']) . "', $topic_poster, UNIX_TIMESTAMP(NOW()), $topic_poster, $topic_poster, '" . serendipity_db_escape_string($topic_poster_data['username']) . "', '" . time() . "', $topic_poster)", $con);
                    } else {
                        mysql_query("INSERT INTO {$prefix}topics (forum_id, topic_title, topic_poster, topic_time, topic_first_post_id, topic_last_post_id)
                                          VALUES ($fid, '" . serendipity_db_escape_string($eventData['title']) . "', $topic_poster, UNIX_TIMESTAMP(NOW()), 0, 0)", $con);
                    }
                    $this->logMSG(mysql_error(), true);
                    $topic_id = mysql_insert_id($con);

                    if ($phpbb_mirror == 4) {
                        mysql_query("INSERT INTO {$prefix}messages (ID_TOPIC, ID_BOARD, posterTime, ID_MEMBER, subject, posterName, posterEmail, posterIP, modifiedTime, body)
                                          VALUES ($topic_id, $fid, UNIX_TIMESTAMP(NOW()), $topic_poster, '" . serendipity_db_escape_string($eventData['title']) . "', '" . serendipity_db_escape_string($eventData['author']) . "', '" . serendipity_db_escape_string($eventData['email']) . "', '" . $_SERVER['REMOTE_ADDR'] . "', 0, '" . serendipity_db_escape_string($eventData['body'] . $eventData['extended']) . "')", $con);
                        $this->logMSG(mysql_error(), true);
                        $post_id = mysql_insert_id($con);
                    } elseif ($phpbb_mirror == 3) {
                        mysql_query("INSERT INTO {$prefix}posts (topic_id, forum_id, poster_id, post_time, post_username, post_subject, post_text)
                                          VALUES ($topic_id, $fid, $topic_poster, UNIX_TIMESTAMP(NOW()), '" . serendipity_db_escape_string($eventData['author']) . "', '" . serendipity_db_escape_string($eventData['title']) . "', '" . serendipity_db_escape_string($eventData['body'] . $eventData['extended']) . "')", $con);
                        $this->logMSG(mysql_error(), true);
                        $post_id = mysql_insert_id($con);
                    } else {
                        mysql_query("INSERT INTO {$prefix}posts (topic_id, forum_id, poster_id, post_time, post_username)
                                          VALUES ($topic_id, $fid, $topic_poster, UNIX_TIMESTAMP(NOW()), '" . serendipity_db_escape_string($eventData['author']) . "')", $con);
                        $this->logMSG(mysql_error(), true);
                        $post_id = mysql_insert_id($con);

                        mysql_query("INSERT INTO {$prefix}posts_text (post_id, post_subject, post_text)
                                          VALUES ($post_id, '" . serendipity_db_escape_string($eventData['title']) . "', '" . serendipity_db_escape_string($eventData['body'] . $eventData['extended']) . "')", $con);
                        $this->logMSG(mysql_error(), true);
                    }    

                    if ($phpbb_mirror == 4) {
                        mysql_query("UPDATE {$prefix}topics
                                        SET ID_FIRST_MSG = $post_id,
                                            ID_LAST_MSG  = $post_id
                                      WHERE ID_TOPIC = $topic_id", $con);
                    } else {
                        mysql_query("UPDATE {$prefix}topics
                                        SET topic_first_post_id = $post_id,
                                            topic_last_post_id  = $post_id
                                      WHERE topic_id = $topic_id", $con);
                    }
                    $this->logMSG(mysql_error(), true);

                    if ($phpbb_mirror == 4) {
                        mysql_query("UPDATE {$prefix}boards
                                                 SET numPosts    = numPosts + 1,
                                                     numTopics   = numTopics + 1,
                                                     ID_LAST_MSG = $post_id
                                               WHERE ID_BOARD = $fid", $con);
                    } else {
                        mysql_query("UPDATE {$prefix}forums
                                                 SET forum_posts        = forum_posts + 1,
                                                     forum_topics       = forum_topics + 1,
                                                     forum_last_post_id = $post_id
                                               WHERE forum_id = $fid", $con);
                    }
                    $this->logMSG(mysql_error(), true);

                    if ($phpbb_mirror == 4) {
                        $v = mysql_query("SELECT variable, value FROM {$prefix}settings WHERE variable = 'smileys_url'", $con);
                        $this->logMsg(mysql_error(), true);
                        #$this->logMSG('Fetching config values from phpBB Board');
                        while ($row = mysql_fetch_array($v, MYSQL_ASSOC)) {
                            $conf[$row['variable']] = $row['value'];
                            #$this->logMSG('Got config values from phpBB: ' . print_r($row, true));
                        }
                        $url = str_replace('/Smileys', '/index.php?topic=' . $topic_id . '.0', $conf['smileys_url']);
                    } else {
                        #$this->logMSG('Fetching config values from phpBB Board');
                        while ($row = mysql_fetch_array($v, MYSQL_ASSOC)) {
                            $conf[$row['config_name']] = $row['config_value'];
                            #$this->logMSG('Got config values from phpBB: ' . print_r($row, true));
                        }
                        $url = "http://{$conf['server_name']}{$conf['script_path']}/viewtopic.php?p=$post_id";
                    }
                    serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value)
                                               VALUES (" . (int)$eventData['id'] . ", 'phpbb_topic', $topic_id)");
                    serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value)
                                               VALUES (" . (int)$eventData['id'] . ", 'phpbb_post', $post_id)");
                    serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value)
                                               VALUES (" . (int)$eventData['id'] . ", 'phpbb_url', '" . $url . "')");

                    return true;

                case 'frontend_saveComment':
                    if (!$phpbb_mirror) {
                        return true;
                    }

                    if (!$eventData['allow_comments']) {
                        return true;
                    }

                    $r = serendipity_db_query("SELECT value, property
                                                 FROM {$serendipity['dbPrefix']}entryproperties
                                                WHERE entryid = " . (int)$eventData['id'] . "
                                                  AND (property = 'phpbb_topic' OR property = 'phpbb_post' OR property = 'phpbb_url')", false, 'assoc', false, 'property');

                    if (empty($r['phpbb_post']['value']) || empty($r['phpbb_topic']['value'])) {
                        #$this->logMSG('Could not get phpBB properties for storing a comment');
                        return false;
                    }

                    $con = mysql_connect($this->get_config('phpbb_db_host'), $this->get_config('phpbb_db_user'), $this->get_config('phpbb_db_pw'));
                    if (!$con) {
                        $this->logMSG('Could not get phpBB properties for storing a comment: DB credentials');
                        return false;
                    }

                    if (!mysql_select_db($this->get_config('phpbb_db_name'), $con)) {
                        $this->logMSG('Could not get phpBB properties for storing a comment: DB name');
                        return false;
                    }

                    if (mysql_error() != '') {
                        $this->logMSG(mysql_error(), true);
                        return false;
                    }

                    mysql_query("SET NAMES " . SQL_CHARSET);

                    $prefix = $this->get_config('phpbb_db_prefix');
                    $fid    = (int)$this->get_config('phpbb_forum');
                    $topic_poster = (int)$this->get_config('phpbb_poster');
                    $topic_id = $r['phpbb_topic']['value'];
                    $phpbb_url = $r['phpbb_url']['value'];

                    if ($phpbb_mirror == 4) {
                        mysql_query("INSERT INTO {$prefix}messages (ID_TOPIC, ID_BOARD, posterTime, ID_MEMBER, subject, posterName, posterEmail, posterIP, modifiedTime, body)
                                          VALUES ($topic_id, $fid, UNIX_TIMESTAMP(NOW()), 0, '" . serendipity_db_escape_string($addData['title']) . "', '" . serendipity_db_escape_string($addData['name']) . "', '" . serendipity_db_escape_string($addData['email']) . "', '" . $_SERVER['REMOTE_ADDR'] . "', 0, '" . serendipity_db_escape_string($addData['comment']) . "')", $con);
                        $this->logMSG(mysql_error(), true);
                        $post_id = mysql_insert_id($con);
                    } elseif ($phpbb_mirror == 3) {
                        $q1 = "INSERT INTO {$prefix}posts (topic_id, forum_id, post_time, post_username, poster_id, post_subject, post_text)
                                          VALUES ($topic_id, $fid, UNIX_TIMESTAMP(NOW()), '" . strip_tags(serendipity_db_escape_string($addData['name'])) . "', 1, '" . strip_tags(serendipity_db_escape_string($addData['title'])) . "', '" . strip_tags(serendipity_db_escape_string($addData['comment'])) . "')";
                        mysql_query($q1, $con);
                        $this->logMSG(mysql_error(), true);
                        $post_id = mysql_insert_id($con);
                    } else {
                        $q1 = "INSERT INTO {$prefix}posts (topic_id, forum_id, post_time, post_username, poster_id)
                                          VALUES ($topic_id, $fid, UNIX_TIMESTAMP(NOW()), '" . strip_tags(serendipity_db_escape_string($addData['name'])) . "', -1)";
                        mysql_query($q1, $con);
                        $this->logMSG(mysql_error(), true);
                        $post_id = mysql_insert_id($con);
    
                        $q2 = "INSERT INTO {$prefix}posts_text (post_id, post_subject, post_text)
                                          VALUES ($post_id, '" . strip_tags(serendipity_db_escape_string($addData['title'])) . "', '" . strip_tags(serendipity_db_escape_string($addData['comment'])) . "')";
                        mysql_query($q2, $con);
                        $this->logMSG(mysql_error(), true);
                    }

                    if ($phpbb_mirror == 4) {
                        $q3 = "UPDATE {$prefix}topics 
                                  SET numReplies = numReplies + 1, 
                                      ID_MEMBER_UPDATED = 0, 
                                      ID_LAST_MSG = $post_id 
                                WHERE ID_TOPIC = $topic_id";
                    } elseif ($phpbb_mirror == 3) {
                        $q3 = "UPDATE {$prefix}topics SET topic_replies = topic_replies + 1, topic_replies_real = topic_replies_real + 1, topic_last_poster_id = 1, topic_last_poster_name = '" . strip_tags(serendipity_db_escape_string($addData['name'])) . "', topic_last_post_id = $post_id WHERE topic_id = $topic_id";
                    } else {
                        $q3 = "UPDATE {$prefix}topics SET topic_replies = topic_replies + 1, topic_last_post_id = $post_id WHERE topic_id = $topic_id";
                    }
                    mysql_query($q3, $con);
                    $this->logMSG(mysql_error(), true);

                    if ($phpbb_mirror == 4) {
                        $q4 = "UPDATE {$prefix}boards SET numPosts = numPosts + 1, ID_LAST_MSG = $post_id WHERE ID_BOARD = $fid";
                    } else {
                        $q4 = "UPDATE {$prefix}forums SET forum_posts = forum_posts + 1, forum_last_post_id = $post_id WHERE forum_id = $fid";
                    }
                    mysql_query($q4, $con);
                    $this->logMSG(mysql_error(), true);

                    $c = serendipity_db_query("SELECT comments FROM {$serendipity['dbPrefix']}entries WHERE id = " . (int)$eventData['id'], true, 'assoc');

                    if ($c['comments'] < 1) {
                        serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}comments (entry_id, title, url, type, status, subscribed)
                                                   VALUES (" . (int)$eventData['id'] . ", 'phpbb_mirror', '" . serendipity_db_escape_string($phpbb_url) . "', 'NORMAL', 'approved', 'false')");
                    }
                    serendipity_db_query("UPDATE {$serendipity['dbPrefix']}entries SET comments = comments + 1 WHERE id = " . (int)$eventData['id']);
                    header('Status: 302 Found');
                    header('Location: ' . $phpbb_url);
                    exit;

                    return true;

                case 'frontend_display:html:per_entry':
                    if (!$phpbb_mirror) {
                        return true;
                    }

                    #$this->logMSG('PHPBB Entry #' . $eventData['id'] . ': ' . print_r($eventData['properties'], true));
                    $eventData['display_dat'] .= $eventData['phpbb_discuss'] = '<a class="phpbb_link" href="' . $eventData['properties']['phpbb_url'] . '">' . FORUM_PLUGIN_PHPBB_DISCUSS . '</a>';
                    break;
                    
                case 'frontend_display':
                    if (!$phpbb_mirror || !is_array($eventData['properties']) || !isset($eventData['comments'])) {
                        return true;
                    }

                    if ($eventData['comments'] < 1) {
                        $con = mysql_connect($this->get_config('phpbb_db_host'), $this->get_config('phpbb_db_user'), $this->get_config('phpbb_db_pw'));
                        if (!$con) {
                            return false;
                        }
    
                        mysql_select_db($this->get_config('phpbb_db_name'), $con);

                        mysql_query("SET NAMES " . SQL_CHARSET);

                        $prefix = $this->get_config('phpbb_db_prefix');
                        $basepost_id = $eventData['properties']['phpbb_post'];
                        $topic_id = $eventData['properties']['phpbb_topic'];
                        $phpbb_url = $eventData['properties']['phpbb_url'];
                        
                        if ($phpbb_mirror == 4) {
                            $pq = "SELECT count(m.ID_MSG) AS postcount
                                                       FROM {$prefix}messages AS m
                                                      WHERE m.ID_TOPIC = $topic_id
                                                        AND m.ID_MSG != $basepost_id
                                                   GROUP BY m.ID_TOPIC
                                                      LIMIT 1";
                        } else {
                            $pq = "SELECT count(p.post_id) AS postcount
                                                       FROM {$prefix}posts AS p
                                                      WHERE p.topic_id = $topic_id
                                                        AND p.post_id != $basepost_id
                                                   GROUP BY p.topic_id
                                                      LIMIT 1";
                        }
                        $comments = mysql_query($pq, $con);
                        if ($comments) {
                            $crows = mysql_fetch_array($comments, MYSQL_ASSOC);
                            if ($crows['postcount'] > 0) {
                                $eventData['comments'] = $crows['postcount'];
                            }
                        }
                    }

                    return true;

                case 'fetchcomments':
                    if (!$phpbb_mirror || !is_array($eventData)) {
                        return true;
                    }

                    foreach($eventData AS $idx => $comment) {
                        if ($comment['ctitle'] == 'phpbb_mirror') {
                            $entryid = $comment['entryid'];
                            $entry = $comment;
                            unset($eventData[$idx]);
                        }
                    }
                    
                    if (empty($entryid) && isset($addData['id'])) {
                        $entryid = $addData['id'];
                    }

                    if (empty($entryid)) {
                        return false;
                    }

                    $con = mysql_connect($this->get_config('phpbb_db_host'), $this->get_config('phpbb_db_user'), $this->get_config('phpbb_db_pw'));
                    if (!$con) {
                        return false;
                    }

                    mysql_select_db($this->get_config('phpbb_db_name'), $con);

                    if (mysql_error() != '') {
                        $this->logMSG(mysql_error(), true);
                        return false;
                    }
                    
                    mysql_query("SET NAMES " . SQL_CHARSET);


                    $r = serendipity_db_query("SELECT value, property
                                                 FROM {$serendipity['dbPrefix']}entryproperties
                                                WHERE entryid = " . (int)$entryid . "
                                                  AND (property = 'phpbb_topic' OR property = 'phpbb_post' OR property = 'phpbb_url')", false, 'assoc', false, 'property');

                    if (empty($r['phpbb_post']['value']) || empty($r['phpbb_topic']['value'])) {
                        return false;
                    }

                    $prefix = $this->get_config('phpbb_db_prefix');
                    $basepost_id = $r['phpbb_post']['value'];
                    $topic_id = $r['phpbb_topic']['value'];
                    $phpbb_url = $r['phpbb_url']['value'];

                    if ($phpbb_mirror == 4) {
                        $comments = mysql_query("SELECT p.ID_MSG AS id,
                                                        p.ID_MSG AS commentid,
                                                        0 AS parent_id,
                                                        p.posterTime AS timestamp,
                                                        p.subject AS ctitle,
                                                        p.body AS body,
                                                        'NORMAL' as type,
                                                        0 AS subscribed,
                                                        
                                                        IF(m.realName != '', m.realName, p.posterName) AS author
    
                                                   FROM {$prefix}messages AS p

                                        LEFT OUTER JOIN {$prefix}members AS m
                                                     ON m.ID_MEMBER = p.ID_MEMBER

                                                  WHERE p.ID_TOPIC = $topic_id
                                                    AND p.ID_MSG != $basepost_id
                                               ORDER BY p.posterTime ASC", $con);
                                               echo mysql_error();
                    } elseif ($phpbb_mirror == 3) {
                        $comments = mysql_query("SELECT p.post_id AS id,
                                                        p.post_id AS commentid,
                                                        0 AS parent_id,
                                                        p.post_time AS timestamp,
                                                        p.post_subject AS ctitle,
                                                        p.post_text AS body,
                                                        'NORMAL' as type,
                                                        0 AS subscribed,
                                                        p.post_username AS author
    
                                                   FROM {$prefix}posts AS p
                                                  WHERE p.topic_id = $topic_id
                                                    AND p.post_id != $basepost_id
                                               ORDER BY p.post_time ASC", $con);
                    } else {
                        $comments = mysql_query("SELECT p.post_id AS id,
                                                        p.post_id AS commentid,
                                                        0 AS parent_id,
                                                        p.post_time AS timestamp,
                                                        pt.post_subject AS ctitle,
                                                        pt.post_text AS body,
                                                        'NORMAL' as type,
                                                        0 AS subscribed,
                                                        p.post_username AS author
    
                                                   FROM {$prefix}posts AS p
                                                   JOIN {$prefix}posts_text AS pt
                                                     ON p.post_id = pt.post_id
                                                  WHERE p.topic_id = $topic_id
                                                    AND p.post_id != $basepost_id
                                               ORDER BY p.post_time ASC", $con);
                    }
                    $this->logMSG(mysql_error(), true);
                    $return = $eventData;
                    if (mysql_num_rows($comments) < 1) {
                        return false;
                    }

                    while($row = mysql_fetch_array($comments, MYSQL_ASSOC)) {
                        $row['title'] = $entry['title'];
                        $row['entrytimestamp'] = $entry['entrytimestamp'];
                        $row['entryid'] = $row['entry_id'] = $entryid;
                        $row['authorid'] = $entry['authorid'];

                        $return[] = $row;
                    }
                    $eventData = $return;
                    
                    serendipity_db_Query("UPDATE {$serendipity['dbPrefix']}entries SET comments = " . count($eventData) . " WHERE id = " . (int)$entryid);
                    return true;

                case 'css':
                    if (strpos($eventData, '.forum-') !== false) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        return true;
                    }
?>
.forum-filebox {
    font: normal 12px Courier, Courier New, fixed;
    background-color: #fffde0;
    color: #000000;
    border: 1px dashed;
    border-color: #888888;
    margin: 10px auto;
    padding: 5px;
}
<?php
                    return true;
                    break;


            }
        }

        return true;
    }


}

/* vim: set sts=4 ts=4 expandtab : */
?>
