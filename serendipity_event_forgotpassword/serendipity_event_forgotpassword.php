<?php # $Id$


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_forgotpassword extends serendipity_event
{
    var $title = PLUGIN_EVENT_FORGOTPASSWORD_NAME;

    function introspect(&$propbag)
    {
        $propbag->add('name',          PLUGIN_EVENT_FORGOTPASSWORD_NAME);
        $propbag->add('description',   PLUGIN_EVENT_FORGOTPASSWORD_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Omid Mottaghi');
        $propbag->add('version',       '0.11');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9.1',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',   array('backend_login_page' => true));
        
        $propbag->add('configuration', array('nomailinfo', 'nomailadd', 'nomailtxt'));
        $propbag->add('groups', array('BACKEND_FEATURES'));
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'nomailinfo':
                $propbag->add('type',        'text');
                $propbag->add('name',        PLUGIN_EVENT_FORGOTPASSWORD_MAILER);
                $propbag->add('description', '');
                $propbag->add('default',     PLUGIN_EVENT_FORGOTPASSWORD_MAILER_DEFAULT);
                break;

            case 'nomailtxt':
                $propbag->add('type',        'text');
                $propbag->add('name',        PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAILTXT);
                $propbag->add('description', '');
                $propbag->add('default',     PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAILTXT_DEFAULT);
                break;

            case 'nomailadd':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAIL);
                $propbag->add('description', '');
                $propbag->add('default',     '');
                break;
        }
        return true;
    }

    function event_hook($event, &$bag, &$eventData) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_login_page':

                    // first LINK
                    if (!isset($_GET['forgotpassword']) && !isset($_GET['username']) && !isset($_POST['username'])) {
                        $eventData['footer'] = '
                        <table cellspacing="10" cellpadding="0" border="0" align="center">
                            <tr>
                                <td colspan="2" align="right"><a href="?forgotpassword=1">'.PLUGIN_EVENT_FORGOTPASSWORD_LOST_PASSWORD.'</a></td>
                            </tr>
                        </table>';
                        return true;
                    // first FORM
                    } elseif (!isset($_POST['username']) && !isset($_GET['uid'])) {
                        $eventData['footer'] = '
                        <form action="serendipity_admin.php" method="post">
                            <table cellspacing="10" cellpadding="0" border="0" align="center">
                                <tr>
                                    <td colspan="2" align="right">'.PLUGIN_EVENT_FORGOTPASSWORD_ENTER_USERNAME.'</td>
                                </tr>

                                <tr>
                                    <td>'.USERNAME.'</td>
                                    <td><input class="input_textbox" type="text" name="username" /></td>
                                </tr>

                                <tr>
                                    <td colspan="2" align="right"><input type="submit" name="forgot" value="'.PLUGIN_EVENT_FORGOTPASSWORD_SEND_EMAIL.'" class="serendipityPrettyButton input_button" /></td>
                                </tr>
                            </table>
                        </form>';
                        return true;
                    // submitted FORM (send an email to user and show a simple page)
                    } elseif (!isset($_POST['uid']) && isset($_POST['username'])) {
                        $q   = 'SELECT email, authorid FROM '.$serendipity['dbPrefix'].'authors where username = \''.serendipity_db_escape_string($_POST['username']).'\'';
                        $sql = serendipity_db_query($q);
                        if (!is_array($sql) || count($sql) < 1) {
                            $eventData['footer'] = '<div class="serendipityAdminMsgError"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png') . '" alt="" />' . PLUGIN_EVENT_FORGOTPASSWORD_USER_NOT_EXIST . '</div>';
                            return true;
                        }

                        if ($sql && is_array($sql)) {
                            
                            if (empty($sql[0]['email'])) {
                                $eventData['footer'] = '<div class="serendipityAdminMsgError"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png') . '" alt="" />' . $this->get_config('nomailinfo') . '</div>';
                                
                                if ($this->get_config('nomailadd') != '') {
                                    $sent = serendipity_sendMail($this->get_config('nomailadd'), PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SUBJECT, sprintf($this->get_config('nomailtxt'), $_POST['username']), NULL);
                                }
                                return true;
                            }
                            $res = $sql[0];
                            $email = $res['email'];
                            $authorid = $res['authorid'];

                            $md5 = md5(uniqid(time()));

                            $q = 'INSERT INTO '.$serendipity['dbPrefix'].'forgotpassword VALUES (\''.$md5.'\', \''.$authorid.'\')';
                            $sql = serendipity_db_query($q);

                            if(!$sql){
                                $eventData['footer'] = '
                                <table cellspacing="10" cellpadding="0" border="0" align="center">
                                    <tr>
                                        <td colspan="2" align="right">'.PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_DB_ERROR.'</td>
                                    </tr>
                                </table>';
                                return true;
                            }

                            $sent = serendipity_sendMail($email, PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SUBJECT, PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_BODY.$serendipity['baseURL'].'serendipity_admin.php?username='.$authorid.'&uid='.$md5, NULL);
                            if ($sent) {
                                $eventData['footer'] = '
                                <table cellspacing="10" cellpadding="0" border="0" align="center">
                                    <tr>
                                        <td colspan="2" align="right">'.PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SENT.'</td>
                                    </tr>
                                </table>';
                            } else {
                                $eventData['footer'] = '
                                <table cellspacing="10" cellpadding="0" border="0" align="center">
                                    <tr>
                                        <td colspan="2" align="right">'.PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_CANNOT_SEND.'</td>
                                    </tr>
                                </table>';
                            }
                            return true;
                        } else {
                            $eventData['footer'] = '
                            <table cellspacing="10" cellpadding="0" border="0" align="center">
                                <tr>
                                    <td colspan="2" align="right">'.PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_DB_ERROR.'</td>
                                </tr>
                            </table>';
                            return true;
                        }
                    // clicked link in user email
                    } elseif (isset($_GET['uid']) && isset($_GET['username']) && !isset($_POST['password'])){
                        $eventData['footer'] = '
                        <form action="serendipity_admin.php" method="post">
                            <table cellspacing="10" cellpadding="0" border="0" align="center">
                                <tr>
                                    <td colspan="2" align="right">'.PLUGIN_EVENT_FORGOTPASSWORD_ENTER_PASSWORD.'</td>
                                </tr>

                                <tr>
                                    <td>'.PASSWORD.'</td>
                                    <td><input class="input_textbox" type="password" name="password" />
                                        <input type="hidden" name="username" value="'.htmlspecialchars($_GET['username']).'" />
                                        <input type="hidden" name="uid" value="'.htmlspecialchars($_GET['uid']).'" /></td>
                                </tr>

                                <tr>
                                    <td colspan="2" align="right"><input type="submit" name="forgot" value="'.PLUGIN_EVENT_FORGOTPASSWORD_CHANGE_PASSWORD.'" class="serendipityPrettyButton input_button" /></td>
                                </tr>
                            </table>
                        </form>';
                        return true;
                    // changed password page
                    } elseif (isset($_POST['uid']) && isset($_POST['username']) && isset($_POST['password'])){
                        $q = 'SELECT * FROM '.$serendipity['dbPrefix'].'forgotpassword where authorid = \''.serendipity_db_escape_string($_POST['username']).'\' and uid = \''.serendipity_db_escape_string($_POST['uid']).'\'';
                        $sql = serendipity_db_query($q);

                        if ($sql && is_array($sql)) {
                            $res = $sql[0];
                            $authorid = $res['authorid'];


                            if (function_exists('serendipity_hash')) {
                                $password = serendipity_hash($_POST['password']);
    
                                $q = 'UPDATE '.$serendipity['dbPrefix'].'authors SET hashtype=1, password=\''.$password.'\' where authorid = \''.serendipity_db_escape_string($_POST['username']).'\'';
                            } else {
                                $password = md5($_POST['password']);
    
                                $q = 'UPDATE '.$serendipity['dbPrefix'].'authors SET password=\''.$password.'\' where authorid = \''.serendipity_db_escape_string($_POST['username']).'\'';
                            }
                            $sql = serendipity_db_query($q);

                            if (!$sql){
                                $eventData['footer'] = '
                                <table cellspacing="10" cellpadding="0" border="0" align="center">
                                    <tr>
                                        <td colspan="2" align="right">'.PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_DB_ERROR.'</td>
                                    </tr>
                                </table>';
                                return true;
                            }

                            $q = 'DELETE FROM '.$serendipity['dbPrefix'].'forgotpassword where authorid = \''.serendipity_db_escape_string($_POST['username']).'\'';
                            $sql = serendipity_db_query($q);

                            $eventData['footer'] = '
                            <table cellspacing="10" cellpadding="0" border="0" align="center">
                                <tr>
                                    <td colspan="2" align="right">'.PLUGIN_EVENT_FORGOTPASSWORD_PASSWORD_CHANGED.'</td>
                                </tr>
                            </table>';
                            return true;
                        } else {
                            $eventData['footer'] = '
                            <table cellspacing="10" cellpadding="0" border="0" align="center">
                                <tr>
                                    <td colspan="2" align="right">'.PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_DB_ERROR.'</td>
                                </tr>
                            </table>';
                            return true;
                    }
                }
                break;

                default:
                    return false;
            }
        } else {
            return false;
        }
        return false;
    }

    function install() {
    global $serendipity;

    //create table xxxx_forgotpassword
        $q = "CREATE TABLE {$serendipity['dbPrefix']}forgotpassword (
    uid varchar(32) not null,
    authorid int(11) not null
        )";
        serendipity_db_schema_import($q);
    }

    function uninstall(){
    global $serendipity;

    // Drop tables
        $q = "DROP TABLE ".$serendipity['dbPrefix']."forgotpassword";
        serendipity_db_schema_import($q);
    }
}

/* vim: set sts=4 ts=4 expandtab : */
