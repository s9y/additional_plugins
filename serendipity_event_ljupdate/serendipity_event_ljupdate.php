<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_ljupdate extends serendipity_event
{
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name', PLUGIN_LJUPDATE_TITLE);
        $propbag->add('description', PLUGIN_LJUPDATE_DESCRIPTION);
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('author', 'Kaustubh Srikanth, Ivan Makhonin');
        $propbag->add('version', '1.13.3');


        $propbag->add('event_hooks',    array(
                            'backend_display' => true,
                            'backend_save' => true,
                            'backend_publish' => true,
                            'backend_delete_entry' => true
        ));

        $propbag->add('stackable', true);
        $propbag->add('configuration', array(
            'target',
            'ljserver',
            'ljusername',
            'ljpass',
            'ljcuttext',
            'category',
            'def_nocomments'
        ));
        $propbag->add('groups', array('BACKEND_EDITOR'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'category':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_LJUPDATE_CATEGORY);
                $propbag->add('description', PLUGIN_LJUPDATE_CATEGORY_DESC);
                $propbag->add('default',     '');
                break;

            case 'ljserver':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_LJUPDATE_SERVER);
                $propbag->add('description', PLUGIN_LJUPDATE_SERVER_DESC);
                break;

            case 'target':
                $propbag->add('type', 'select');
                $propbag->add('name', 'LiveUpdate/MySpace/Serendipity?');
                $propbag->add('description', '');
                $propbag->add('select_values', array('lj' => 'LiveJournal', 'myspace' => 'MySpace', 's9y' => 'Serendipity'));
                $propbag->add('default', 'lj');
                break;

            case 'ljusername':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_LJUPDATE_USERNAME);
                $propbag->add('description', PLUGIN_LJUPDATE_USERNAME_DESC);
                break;

            case 'ljpass':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_LJUPDATE_PASSWORD);
                $propbag->add('description', PLUGIN_LJUPDATE_PASSWORD_DESC);
                break;

            case 'ljcuttext':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_LJUPDATE_CUT);
                $propbag->add('description', PLUGIN_LJUPDATE_CUT_DESC);
                break;

            case 'def_nocomments':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_LJUPDATE_COMMENTS);
                $propbag->add('description', PLUGIN_LJUPDATE_COMMENTS);
                break;
        }
        return true;

    }

    function generate_content(&$title) {
        $title = PLUGIN_LJUPDATE_TITLE;
    }

    function check_lj_entries() {
        global $serendipity;

        if (!is_array(serendipity_db_query("SELECT id FROM {$serendipity['dbPrefix']}lj_entries LIMIT 1", true, 'both', false, false, false, true))) {
            serendipity_db_schema_import("CREATE TABLE {$serendipity['dbPrefix']}lj_entries (
              entry_id int default null,
              itemid int default null,
              current_mood varchar(255) default null,
              current_music varchar(255) default null,
              picture_keyword varchar(255) default null,
              security varchar(255) default null,
              opt_nocomments varchar(255) default null
            );");
        }
    }

    function lj_update($eventData, $delete = '') {
        global $serendipity;

        $this->check_lj_entries();

        $rec_exists = false;
        $itemid = 0;
        $rec = serendipity_db_query("SELECT itemid FROM {$serendipity['dbPrefix']}lj_entries where entry_id=" . (int)$eventData['id'], true);
        if (is_array($rec)) {
            $itemid = $rec['itemid'];
            $rec_exests = true;
        }

        if ($delete == 'delete' && $itemid == 0) return;

        echo "Update LiveJournal...<br />\n";

        if ($delete == 'delete') {
            serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}lj_entries where entry_id=" . (int)$eventData['id']);
        } else
        if ($rec_exists) {
            serendipity_db_update('lj_entries', 
                array('entry_id' => round($eventData['id'])),
                array(
                    'itemid' => $itemid,
                    'current_mood' => $serendipity['POST']['ljmood'],
                    'current_music' => $serendipity['POST']['ljmusic'],
                    'picture_keyword' => $serendipity['POST']['ljuserpic'],
                    'security' => $serendipity['POST']['ljsecurity'],
                    'opt_nocomments' => $serendipity['POST']['ljcomment']
                )
            );
        } else {
            serendipity_db_insert('lj_entries',
                array(
                    'entry_id' => (int)$eventData['id'],
                    'itemid' => $itemid,
                    'current_mood' => $serendipity['POST']['ljmood'],
                    'current_music' => $serendipity['POST']['ljmusic'],
                    'picture_keyword' => $serendipity['POST']['ljuserpic'],
                    'security' => $serendipity['POST']['ljsecurity'],
                    'opt_nocomments' => $serendipity['POST']['ljcomment']
                )
            );
        }

        $event = $eventData['body'];
        if ($eventData['extended']) {
            $event .= "<br /><br /><lj-cut text='" . $this->get_config('ljcuttext') . "'>\n" . $eventData['extended'] . "</lj-cut>";
        }

        if ($serendipity['POST']['ljcomment'] == 1) {
            $commentlink  = serendipity_archiveURL($eventData['id'], $eventData['title'], 'baseURL', true, array('timestamp' => $eventData['timestamp']));
            $event .= "<br /><a style=\"text-align: right\" href=\"$commentlink#comments\">" . PLUGIN_LJUPDATE_READCOMMENTS . "</a>";
        } else {
            $serendipity['POST']['ljcomment'] = 0;
        }

        if (empty($serendipity['POST']['ljsecurity'])) {
            $serendipity['POST']['ljsecurity'] = 'public';
        }

        //Make LJ Entries not doublespaced
        $event = str_replace("\n", "", $event);
        //Replace relative with absolute URLs
        $event = preg_replace('@(href|src)=("|\')(' . preg_quote($serendipity['serendipityHTTPPath']) . ')(.*)("|\')(.*)>@imsU', '\1=\2' . $serendipity['baseURL'] . '\4\2\6>', $event);

        $t = serendipity_serverOffsetHour($eventData['timestamp']);

        $params['username']       = new XML_RPC_Value($this->get_config('ljusername'), 'string');
        $params['hpassword']      = new XML_RPC_Value(md5($this->get_config('ljpass')), 'string');

        if ($itemid != 0) {
            $params['itemid']     = new XML_RPC_Value($itemid, 'string');
        }

        if ($delete == 'delete') {
            $params['event']      = new XML_RPC_Value('', 'string');
            $params['subject']    = new XML_RPC_Value('', 'string');
            $params['year']       = new XML_RPC_Value('', 'string');
            $params['mon']        = new XML_RPC_Value('', 'string');
            $params['day']        = new XML_RPC_Value('', 'string');
            $params['hour']       = new XML_RPC_Value('', 'string');
            $params['min']        = new XML_RPC_Value('', 'string');
        } else {
            $params['event']          = new XML_RPC_Value($event, 'string');
            $params['subject']        = new XML_RPC_Value($eventData['title'], 'string');
            $params['year']           = new XML_RPC_Value(date('Y', $t), 'string');
            $params['mon']            = new XML_RPC_Value(date('m', $t), 'string');
            $params['day']            = new XML_RPC_Value(date('d', $t), 'string');
            $params['hour']           = new XML_RPC_Value(date('H', $t), 'string');
            $params['min']            = new XML_RPC_Value(date('i', $t), 'string');
            $params['security']       = new XML_RPC_Value($serendipity['POST']['ljsecurity'],'string');
            if ($serendipity['POST']['ljsecurity'] == 'usemask') {
                $params['allowmask']  = new XML_RPC_Value(1,'string');
            }
            $props['current_mood']    = new XML_RPC_Value($serendipity['POST']['ljmood'], 'string');
            $props['current_music']   = new XML_RPC_Value($serendipity['POST']['ljmusic'], 'string');
            if ($serendipity['POST']['ljuserpic']) {
                $props['picture_keyword'] = new XML_RPC_Value($serendipity['POST']['ljuserpic'], 'string');
            }
            $props['opt_nocomments']  = new XML_RPC_Value($serendipity['POST']['ljcomment'], 'string');
            $params['props']          = new XML_RPC_Value($props,'struct');
        }


        $client = new XML_RPC_Client(
            '/interface/xmlrpc',
            $this->get_config('ljserver')
        );

        $data= new XML_RPC_Value($params,'struct');
        if ($itemid == 0 && $delete != 'delete') {
            $msg = new XML_RPC_Message('LJ.XMLRPC.postevent',array($data));
        } else {
            $msg = new XML_RPC_Message('LJ.XMLRPC.editevent',array($data));
        }
        $res = $client->send($msg,10);

        if ($res->faultCode() == 0) {
            $v = $res->value()->getval();
            $newitemid = (int)$v['itemid'];
        } else {
            echo htmlentities($res->faultString(), ENT_COMPAT, LANG_CHARSET).'<br />';
            $newitemid = 0;
        }

        if ($itemid != $newitemid && $newitemid != 0) {
            serendipity_db_update('lj_entries', 
                array('entry_id' => round($eventData['id'])),
                array('itemid' => $newitemid)
            );
        }

        echo "Updating finished.<br />\n";
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {

                case 'backend_publish':
                    if (defined('SERENDIPITY_IS_XMLRPC')) {
                        return false;
                    }

                    if (defined('S9Y_PEAR_PATH')) {
                        include_once(S9Y_PEAR_PATH . "XML/RPC.php");
                    }
                    $target = $this->get_config('target', 'lj');

                    // Form was posted, but mirroring not activated. If posting via Plugins (popfetcher) is done
                    // we can still execute this.
                    if ($serendipity['POST']['ljmirror_hidden'] && !$serendipity['POST']['ljmirror']) {
                        return true;
                    }

                    if ($target == 'lj') {
                        $this->lj_update($eventData);
                    } else {
                        if (!$serendipity['POST']['ljmirror_hidden']) {
                            $serendipity['POST']['ljcomment'] = 1;
                        }

                        $event = $eventData['body'];
                        if (empty($serendipity['POST']['ljsecurity'])) {
                            $serendipity['POST']['ljsecurity'] = 'public';
                        }

                        //Make LJ Entries not doublespaced
                        $event                    = str_replace("\n", "", $event);
                        //Replace relative with absolute URLs
                        $event = preg_replace('@(href|src)=("|\')(' . preg_quote($serendipity['serendipityHTTPPath']) . ')(.*)("|\')(.*)>@imsU', '\1=\2' . $serendipity['baseURL'] . '\4\2\6>', $event);
                    }

                    if ($target == 's9y') {
                        echo "Posting to Serendipity...<br />\n";

                        $categories = array('categoryId' => new XML_RPC_Value($this->get_config('category')), 'string');
                        $props = array(
                            'title'        => new XML_RPC_Value($eventData['title'] . '(XML-RPC)', 'string'),
                            'description'  => new XML_RPC_Value($eventData['body'], 'string'),
                            'mt_text_more' => new XML_RPC_Value($eventData['extended'], 'string'),
                            'categories'   => new XML_RPC_Value($categories, 'struct'),
                        );

                        $url = parse_url($this->get_config('ljserver'));
                        $client = new XML_RPC_Client(
                            $url['path'],
                            $url['host']
                        );

                        $msg  = new XML_RPC_Message('metaWeblog.newPost',
                            array(
                                new XML_RPC_Value(0, 'string'),
                                new XML_RPC_Value($this->get_config('ljusername'), 'string'),
                                new XML_RPC_Value($this->get_config('ljpass'), 'string'),
                                new XML_RPC_Value($props, 'struct')
                            )
                        );
                        $res  = $client->send($msg, 10);

                        if (!is_object($res)) {
                            echo 'ERROR ' . $client->errno . ': ' . $client->errstr . '<br />';
                            return false;
                        }

                        echo "Posting finished.<br />\n";
                    }

                    if ($target == 'myspace') {
                        if (!function_exists('curl_init')) {
                            echo 'Posting to MySpace requires PHP CURL Functionality! Please talk to your provider to enable CURL.';
                            return false;
                        }

                        echo "Posting to myspace.<br />\n";

                        // Code taken from: http://buzz.gotdns.org/lithboy/blog/index.php?p=380 -- thanks a lot!
                        $tmp_cookie_file = tempnam("/tmp", "msautoupdate_cookie");

                        $ms_userid = urlencode($this->get_config('ljusername'));
                        $ms_passwd = urlencode($this->get_config('ljpass'));
                        $real_blog_url = $serendipity['baseURL'];
                        $post_title = urlencode($eventData['title']);

                        $content = $event . '<br /><span class="myspace_note">Clone of <a href="' . $real_blog_url . '">Serendipity blog</a></span>';
                        $content = urlencode($content);
                        $year = date('Y', time());
                        $month = date('m', time());
                        $day = date('d', time());
                        $hour = date('H', time());
                        $minute = date('i', time());
                        $marker = date('A', time());

                        $login_url = 'http://blog.myspace.com/index.cfm?fuseaction=login.process';
                        $login_params = "email=$ms_userid&password=$ms_passwd&Remember=0";
                        echo "Opening URL $login_url with data " . (function_exists('serendipity_specialchars') ? serendipity_specialchars($login_params) : htmlspecialchars($login_params, ENT_COMPAT, LANG_CHARSET)) . "<br />\n";

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $login_url);
                        curl_setopt($ch, CURLOPT_POSTFIELDS,$login_params);
                        curl_setopt($ch, CURLOPT_POST,1);
                        curl_setopt($ch, CURLOPT_HEADER, 1);
                        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                        curl_setopt($ch, CURLOPT_COOKIEJAR, $tmp_cookie_file);
                        $result=curl_exec ($ch);
                        curl_close ($ch);

                        echo "URL open finished. Output:<br /><br /><hr />\n\n";
                        echo htmlentities($result, ENT_COMPAT, LANG_CHARSET) . "\n\n<hr /><br />\n\n";

                        $post_url = 'http://blog.myspace.com/index.cfm?fuseaction=blog.processCreate';
                        $post_params = "postMonth=$month&postDay=$day&postYear=$year&postHour=$hour&postMinute=$minute&postTimeMarker=$marker&subject=$subject&body=$content";

                        echo "Opening URL $post_url with data " . (function_exists('serendipity_specialchars') ? serendipity_specialchars($post_params) : htmlspecialchars($post_params, ENT_COMPAT, LANG_CHARSET)) . "<br />\n";

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $post_url);
                        curl_setopt($ch, CURLOPT_POSTFIELDS,$post_params);
                        curl_setopt($ch, CURLOPT_POST,1);
                        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                        curl_setopt($ch, CURLOPT_COOKIEFILE, $tmp_cookie_file);
                        curl_setopt($ch, CURLOPT_HEADER, 1);
                        $result=curl_exec ($ch);
                        curl_close ($ch);
                        echo "URL open finished. Output:<br /><br /><hr />\n\n";
                        echo htmlentities($result, ENT_COMPAT, LANG_CHARSET) . "\n\n<hr /><br />\n\n";

                        unlink($tmp_cookie_file);

                        echo "MySpace posting finished.<br />\n";
                    }

                    return true;
                    break;

                case 'backend_save':
                    if ($eventData['isdraft'] == 'true') {
                        return true;
                    }

                    if (defined('SERENDIPITY_IS_XMLRPC')) {
                        return false;
                    }

                    if (defined('S9Y_PEAR_PATH')) {
                        include_once(S9Y_PEAR_PATH . "XML/RPC.php");
                    }
                    $target = $this->get_config('target', 'lj');

                    // Form was posted, but mirroring not activated. If posting via Plugins (popfetcher) is done
                    // we can still execute this.
                    if ($serendipity['POST']['ljmirror_hidden'] && !$serendipity['POST']['ljmirror']) {
                        return true;
                    }

                    if ($target == 'lj') {
                        $this->lj_update($eventData);
                    }

                    return true;
                    break;

                case 'backend_delete_entry':
                    if (defined('SERENDIPITY_IS_XMLRPC')) {
                        return false;
                    }

                    if (defined('S9Y_PEAR_PATH')) {
                        include_once(S9Y_PEAR_PATH . "XML/RPC.php");
                    }
                    $target = $this->get_config('target', 'lj');

                    // Form was posted, but mirroring not activated. If posting via Plugins (popfetcher) is done
                    // we can still execute this.
                    if ($serendipity['POST']['ljmirror_hidden'] && !$serendipity['POST']['ljmirror']) {
                        return true;
                    }

                    if ($target == 'lj') {
                        $this->lj_update(array('id' => $eventData), 'delete');
                    }

                    return true;
                    break;

                case 'backend_display':
                    echo "<b>" . PLUGIN_LJUPDATE_UPDATE . "</b>\n";
                    if (defined('S9Y_PEAR_PATH')) {
                        include_once(S9Y_PEAR_PATH . "XML/RPC.php");
                    }

                    $target = $this->get_config('target', 'lj');

                    $mirror = 'checked';
                    $mood = '';
                    $music = '';
                    $security = '';
                    $userpic = '';
                    $nocomments = '';
                    if ($eventData['id'] > 0) $mirror = '';
                    if ($this->get_config('def_nocomments')) $nocomments='checked';

                    if ($target == 'lj') {
                        $itemid = 0;
                        $lj_entry = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}lj_entries where entry_id=" . (int)$eventData['id'] , true);
                        if (is_array($lj_entry)) {
                            $itemid     = $lj_entry['itemid'];
                            $mood       = $lj_entry['current_mood'];
                            $music      = $lj_entry['current_music'];
                            $security   = $lj_entry['security'];
                            $userpic    = $lj_entry['picture_keyword'];
                            $nocomments = $ljentry['opt_nocomments'] == 1 ? 'checked' : '';
                            $mirror     = 'checked';
                        }

                        $params['username']  = new XML_RPC_Value($this->get_config('ljusername'), 'string');
                        $params['hpassword'] = new XML_RPC_Value(md5($this->get_config('ljpass')), 'string');
                        $params['getpickws'] = new XML_RPC_Value(1, 'string');

                        $client = new XML_RPC_Client(
                            '/interface/xmlrpc',
                            $this->get_config('ljserver')
                        );

                        $data   = new XML_RPC_Value($params,'struct');
                        $msg    = new XML_RPC_Message('LJ.XMLRPC.login',array($data));
                        $res    = $client->send($msg,10);

                        if (!is_object($res)) {
                            echo 'ERROR ' . $client->errno . ': ' . $client->errstr . '<br />';
                            return false;
                        }
                        $pictmp = $res->value()->structmem('pickws');
                    }
?>
                    <input type="hidden" name="serendipity[ljmirror_hidden]" value="true" />
                    <table border="0">
                    <tr>
                        <td colspan="2">
                            <input class="input_checkbox" type="checkbox" name="serendipity[ljmirror]" value="1" <?php echo $mirror ?> /> <?php echo PLUGIN_LJUPDATE_MIRROR; ?>
                       </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                    <?php echo PLUGIN_LJUPDATE_USERPIC; ?>: <select name="serendipity[ljuserpic]">
<?php
                    if (is_object($pictmp)) {
                        echo "<option value=\"\">--</option>";
                        for($i=0; $i<$pictmp->arraysize(); $i++) {
                            $pictmp_item = $pictmp->arraymem($i)->scalarval();
                            echo "<option value=\"" . $pictmp_item . "\"";
                            if ($pictmp_item == $userpic) echo " selected";
                            echo ">" . $pictmp_item . "</option>";
                        }
                    }
?>
                             </select>
                        </td>
                    </tr>
<?php
                    if ($target == 'lj') {
?>
                    <tr>
                        <td colspan="2">
                                <?php echo PLUGIN_LJUPDATE_SECURITY; ?>: <select name="serendipity[ljsecurity]">
                                <option value="public"<?php if ($security=='public') echo " selected"?>><?php echo PLUGIN_LJUPDATE_SECURITY_PUBLIC; ?></option>
                                <option value="private"<?php if ($security=='private') echo " selected"?>><?php echo PLUGIN_LJUPDATE_SECURITY_PRIVATE; ?></option>
                                <option value="usemask"<?php if ($security=='usemask') echo " selected"?>><?php echo PLUGIN_LJUPDATE_SECURITY_FRIENDS; ?></option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input class="input_checkbox" type="checkbox" name="serendipity[ljcomment]" value="1" <?php echo $nocomments ?> /> <?php echo PLUGIN_LJUPDATE_COMMENTS; ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo PLUGIN_LJUPATE_CURRENTMUSIC; ?>: <input class="input_textbox" size="50" name="serendipity[ljmusic]" value="<?php echo $music ?>" /></td>
                        <td><?php echo PLUGIN_LJUPATE_CURRENTMOOD; ?>:  <input class="input_textbox" size="50" name="serendipity[ljmood]" value="<?php echo $mood ?>" /></td>
                    </tr>
<?php
                    }
?>
                    </table>
                <?php

                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
    }
}
