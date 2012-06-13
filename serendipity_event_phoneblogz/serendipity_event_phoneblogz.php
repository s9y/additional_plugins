<?php # $Id$


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

@include dirname(__FILE__) . '/lang_en.inc.php';
include 'phoneblogz-api.php';

class serendipity_event_phoneblogz extends serendipity_event
{
    var $title = PLUGIN_EVENT_PHONEBLOGZ_NAME;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',        PLUGIN_EVENT_PHONEBLOGZ_NAME);
        $propbag->add('description', PLUGIN_EVENT_PHONEBLOGZ_DESC);
        $propbag->add('stackable',   false);
        $propbag->add('author',      'Garvin Hicking, phoneblogz.com');
        $propbag->add('version',     '0.8');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks', array(
            'external_plugin'                                  => true,
            'backend_sidebar_entries'                          => true,
            'backend_sidebar_entries_event_display_phoneblogz' => true,
            'backend_sidebar_admin'                            => true,
            'backend_sidebar_entries_event_display_users'      => true

        ));

        $propbag->add('groups', array('BACKEND_FEATURES'));
        $propbag->add('configuration', array('phoneblogz_accesscode', 'phoneblogz_password', 'categoryid',
                      'phoneblogz_subject', 'phoneblogz_text', 'phoneblogz_notifyurl'));
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'phoneblogz_notifyurl':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_PHONEBLOGZ_NOTIFYURL);
                $propbag->add('description', '');
                $propbag->add('default',     PLUGIN_EVENT_PHONEBLOGZ_NOTIFYURL_DEFAULT);
                break;

            case 'phoneblogz_accesscode':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_PHONEBLOGZ_ACCESSCODE);
                $propbag->add('description', '');
                $propbag->add('default',     '');
                break;

            case 'phoneblogz_password':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_PHONEBLOGZ_PASSWORD);
                $propbag->add('description', '');
                $propbag->add('default',     '');
                break;

            case 'phoneblogz_subject':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_PHONEBLOGZ_SUBJECT);
                $propbag->add('description', '');
                $propbag->add('default',     PLUGIN_EVENT_PHONEBLOGZ_SUBJECT_DEFAULT);
                break;

            case 'phoneblogz_text':
                $propbag->add('type',        'html');
                $propbag->add('name',        PLUGIN_EVENT_PHONEBLOGZ_TEXT);
                $propbag->add('description', '');
                $propbag->add('default',     PLUGIN_EVENT_PHONEBLOGZ_TEXT_DEFAULT);
                break;

            case 'categoryid':
                $base_cats = serendipity_fetchCategories();
                $base_cats = serendipity_walkRecursive($base_cats, 'categoryid', 'parentid', VIEWMODE_THREADED);
                $select['none'] = NONE;
                foreach ( $base_cats as $cat ) {
                    $select[$cat['categoryid']] = str_repeat('-', $cat['depth']) . ' '. $cat['category_name'];
                }

                $propbag->add('type', 'select');
                $propbag->add('name', CATEGORY);
                $propbag->add('description', '');
                $propbag->add('select_values', $select);
                break;


            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function phoneblogz_flash($url) {
          $flashhtml = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="141" height="15" id="player" align="middle">';
          $flashhtml .= '<param name="allowScriptAccess" value="sameDomain" />';
          $flashhtml .= '<param name="FlashVars" value="pb=' . urlencode($url) . '" />';
          $flashhtml .= '<param name="movie" value="http://www.phoneblogz.com/playerlocal2.swf?pb=' . urlencode($url) . '" />' .
                        '<param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />';
          $flashhtml .= '<embed src="http://www.phoneblogz.com/playerlocal2.swf" flashvars="pb=' . urlencode($url) . '" ' .
                        'quality="high" bgcolor="#ffffff" width="141" height="15" name="player" align="middle" ' .
                        'allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />';
          $flashhtml .= '</object>';

          return $flashhtml;
    }

    function phoneblogz_post($postid, $pbuserno) {

        // Firstly try and download the file
        $url = "http://www.phoneblogz.com/listen.php?user=" . $this->get_config("phoneblogz_accesscode") . "&id=$postid";
        $upload = $this->phoneblogz_upload_fromurl("pbpost.mp3", "", $url);

        if (!isset($upload["error"])) {

          // Deal with the local username
          $localuserid = $this->get_config("phoneblogz_usermap_$pbuserno");
          if ($localuserid === FALSE || $localuserid < 1)
            $localuserid = 1;  // Default to the admin user

          // Get the local username for this user
          $localuser = serendipity_fetchUsers($localuserid);
          $localusername = $localuser[0]["realname"];

          // Attempt to create a new post
          $post_content = $this->get_config("phoneblogz_text");
          $post_content = str_replace("[FLASH]", $this->phoneblogz_flash($upload["url"]), $post_content);
          $post_content = str_replace("[USER]", $localusername, $post_content);

          $first = strpos($post_content, "[");
          $second = strpos($post_content, "]");
          if ($first !== FALSE && $second !== FALSE && $second > $first) {
            $link = "<a href=\"" . $upload["url"] . "\">";
            $link .= substr($post_content, $first+1, ($second-$first-1));
            $link .= "</a>";
            $post_content = substr($post_content, 0, $first). $link . substr($post_content, $second+1);
          }

          $oldsess = $_SESSION['serendipityRightPublish'];

          $_SESSION['serendipityRightPublish'] = true;
          $entry = array(
              'body'           => $post_content, //serendipity_db_escape_string($post_content),
              'title'          => str_replace("[USER]", $localusername, $this->get_config('phoneblogz_subject')),
              'timestamp'      => time(),
              'isdraft'        => 'false',
              'allow_comments' => true,
              'authorid'       => $localuserid,
              'categories'     => array($this->get_config('categoryid'))
          );
          $GLOBALS['serendipity']['POST']['properties'] = array('fake' => 'fake');
          $post_ID = serendipity_updertEntry($entry);
          $_SESSION['serendipityRightPublish'] = $oldsess;

          $this->set_config("phoneblogz_status_$postid", $post_ID);
          return array("postid" => $post_ID);
      } else {
          return array("error" => "Failed to upload the file.  Exact error: " . $upload["error"]);
      }
    }

    function phoneblogz_upload_fromurl($name, $type, $url) {
        global $serendipity;

        if (empty($name)) {
            return array('error' => "Empty filename");
        }

        $upload = array(
            'path'  => $serendipity['uploadPath'],
            'url'   => $serendipity['uploadHTTPPath'],
            'error' => false
        );

        if (!is_writable($upload['path'])) {
            $upload['error'] = "Don't have write permission to " . $upload['path'];
            return $upload;
        }

        $number = '';
        $filename = $name;
        while (file_exists($upload['path'] . "/$filename")) {
            $filename = str_replace("$number.$ext", ++$number . ".$ext", $filename);
        }

        $new_file = $upload['path'] . "/$filename";

        $ifp = @fopen($new_file, 'wb');
        if (!$ifp) {
            return array('error' => "Could not write file $new_file.");
        }

        require_once S9Y_PEAR_PATH . 'HTTP/Request.php';
        $req = new HTTP_Request($url);

        if (PEAR::isError($req->sendRequest()) || $req->getResponseCode() != '200') {
            return array('error' => "Could not download file " . htmlspecialchars($url));
        }

        $fc = $req->getResponseBody();
        $success = @fwrite($ifp, $fc);
        fclose($ifp);
        // Set correct file permissions
        $stat = @ stat(dirname($new_file));
        $perms = $stat['mode'] & 0000777;
        @chmod($new_file, $perms);

        // Compute the URL
        $url = $upload['url'] . "/$filename";

        return array('file' => $new_file, 'url' => $url);
    }

    function showUsersInterface() {
      global $serendipity;

      if (isset($_POST[submitusersedit])) {
        foreach ($_POST as $key => $val) {
          // Pick out the "userchoose-" values
          if (strpos($key, "userchoose-") !== FALSE) {
            $pbuserid = substr($key, 11);
            $this->set_config("phoneblogz_usermap_$pbuserid", $val);
          }
        }
      }

      $arr = getUsersForAccount($this->get_config('phoneblogz_accesscode'), $this->get_config('phoneblogz_password'));
      if ( !empty($arr["error"]) ) {
        echo "ERROR: " . $arr["error"];
      } else {

        echo "<center>";
        echo '<h3 style="text-align:center;">' . PLUGIN_EVENT_PHONEBLOGZ_USERS_HEADING . '</h3>';
        echo "<form name='users' method='post' action=''>";
        echo "<table border='1'><tr><th>PhoneBlogz Name</th><th>PIN code</th><th>WordPress User</th></tr>";

        $users = serendipity_fetchUsers();
        $vals  = array();
        $vals['empty'] = MF_MYSELF;

        for ($i = 0; $i < count($arr); ++$i) {
          echo "<tr><td>" . $arr[$i]["name"] . "</td><td>" . $arr[$i]["pin"] . "</td>";
          echo "<td><select name='userchoose-" . $arr[$i]["id"] . "'>";
          echo "<option value='-1'>Please choose...</option>";

          foreach($users AS $user) {
            $selected = ($this->get_config("phoneblogz_usermap_" . $arr[$i]["id"]) == $user['authorid']) ? " SELECTED " : "";
            echo "<option $selected value='" . $user['authorid'] . "'>" . $user['realname'] . " (" . $user['realname'] . ")</option>";
          }

          echo "</select></td>";
          echo "</tr>";
        }

        echo "</table>";
        echo "<br/>";
        echo "<input class='serendipityPrettyButton input_button' type='submit' name='submitusersedit' value='Update Users' />";
        echo "</form>";
        echo "</center>";
      }
    }

    function showInterface() {
        global $serendipity;

        if (isset($_POST['submitdopost'])) {
            $postid = $_POST['id'];
            $pbuserno = $_POST[pbuserid];
            $postinfo = $this->phoneblogz_post($postid, $pbuserno);
            if ($postinfo['error'] != false) {
                echo "ERROR: " . $postinfo['error'];
            }
        }

        $arr = getPostsForAccount($this->get_config("phoneblogz_accesscode"), $this->get_config("phoneblogz_password"));
        if ( !empty($arr["error"]) ) {
          echo "ERROR: " . $arr["error"];
        } else {

            echo '<h3 style="text-align:center;">' . PLUGIN_EVENT_PHONEBLOGZ_SEEBELOW . '</h3>';
            echo "<table border='1'>";
            // TODO: i18n
            echo "<tr>\n";
            echo "<th>Date Posted</th>";
            echo "<th>Caller ID</th>";
            echo "<th>Left by</th>";
            echo "<th>Listen</th>";
            echo "<th>Download link</th>";
            echo "<th>Status</th>";
            echo "<th>Action</th>";
            echo "</tr>";

            for ($i = 0; $i < count($arr); ++$i) {
                $msg = $arr[$i];
                $status = "available";
                $action = "";

                $postid = $this->get_config("phoneblogz_status_" . $msg["messageid"]);
                if (!isset($postid)) {
                    $status = "not posted";
                    $action = "<form action='?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=phoneblogz' method='POST'>" .
                              "<input type='hidden' name='pbuserid' value='" . $msg["userno"] . "'>" .
                              "<input type='hidden' name='id' value='" . $msg["messageid"] . "'><input class='serendipityPrettyButton input_button' type='submit' name='submitdopost' value='post now'></form>";
                } else {
                    $status = "posted";
                    if ($postid > 0) {
                        $status .= " - <a href='" . serendipity_archiveURL($postid, 'preview') . "'>" . PREVIEW . "</a>";
                    }
                    $action = "<form action='?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=phoneblogz' method='POST'>" .
                              "<input type='hidden' name='pbuserid' value='" . $msg["userno"] . "'>" .
                              "<input type='hidden' name='id' value='" . $msg["messageid"] . "'><input class='serendipityPrettyButton input_button' type='submit' name='submitdopost' value='repost'></form>";
                }

                $posturl = "<a href='http://www.phoneblogz.com/listen.php?user=" . $this->get_config("phoneblogz_accesscode") . "&id=" . $msg["messageid"] . "'>Click here</a>";

                $flashhtml = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" ' .
                             'width="141" height="15" id="player" align="middle">';
                $flashhtml .= '<param name="allowScriptAccess" value="sameDomain" />';
                $flashhtml .= '<param name="FlashVars" value="msgid=' . $msg["messageid"] . '&amp;userid=' . $this->get_config("phoneblogz_accesscode") . '" />';
                $flashhtml .= '<param name="movie" value="http://www.phoneblogz.com/player2.swf?msgid=' . $msg["messageid"] . '&userid=' . $this->get_config("phoneblogz_accesscode") . '" />' .
                              '<param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />';
                $flashhtml .= '<embed src="http://www.phoneblogz.com/player2.swf" flashvars="msgid=' . $msg["messageid"] . '&amp;userid=' . $this->get_config("phoneblogz_accesscode") . '" ' .
                              'quality="high" bgcolor="#ffffff" width="141" height="15" name="player" align="middle" ' .
                              'allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />';
                $flashhtml .= '</object>';

                echo "<tr><td>" . $msg["timeleft"] . "</td><td>" . $msg["callerid"] . "</td><td>" . $msg["username"] . "</td><td>$flashhtml</td><td>$posturl</td><td>$status</td><td>$action</td></tr>";
            }

            echo "</table>";
        }
    }

    function cleanup() {
      if ($this->get_config('phoneblogz_accesscode') != "" && $this->get_config('phoneblogz_password') != "" && $this->get_config('phoneblogz_notifyurl') != "") {
        $arrRes = updateSerendipityOptions($this->get_config('phoneblogz_accesscode'), $this->get_config('phoneblogz_password'), $this->get_config('phoneblogz_notifyurl'));
        if ($arrRes != "SUCCESS")
          echo "Failed to save changes: " . $arrRes["error"];
      }
    }

    function publicInterface() {
        $arr = getPostsForAccount($this->get_config("phoneblogz_accesscode"), $this->get_config("phoneblogz_password"));
        if ( !empty($arr["error"]) ) {
            echo "Error: " . $arr["empty"];
            return false;
        } else {
            for ($i = 0; $i < count($arr); ++$i) {
                $status = $this->get_config("phoneblogz_status_" . $arr[$i]["messageid"]);
                if ($status == "" || (intval($status) == 0 && status != "posted")) {
                    // Found one to post
                    $res = $this->phoneblogz_post($arr[$i]["messageid"], $arr[$i]["userno"]);
                    if ($res["error"] != false) {
                        echo "Error  for message " . $arr[$i]["messageid"] . ": " . $res["error"] . "\r";
                    } else {
                        echo "Result for message " . $arr[$i]["messageid"] . ": " . $res["postid"] . "\r";
                    }
                }
            }
        }

        echo "\r\n\r\n";
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (!isset($hooks[$event])) {
            return false;
        }

        switch($event) {
            case 'backend_sidebar_entries':
                if ($serendipity['serendipityUserlevel'] >= USERLEVEL_CHIEF) {
?>
                <li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=phoneblogz"><?php echo PLUGIN_EVENT_PHONEBLOGZ_NAME; ?></a></li>
<?php
                }
                break;

            case 'backend_sidebar_admin':
                if ($serendipity['serendipityUserlevel'] >= USERLEVEL_CHIEF) {
?>
                <li class="serendipitySideBarMenuLink serendipitySideBarMenuUserManagementLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=users"><?php echo PLUGIN_EVENT_PHONEBLOGZ_USERS_NAME; ?></a></li>
<?php
                }
                break;

            case 'backend_sidebar_entries_event_display_users':
                $this->showUsersInterface();
                break;

            case 'backend_sidebar_entries_event_display_phoneblogz':
                $this->showInterface();
                break;

            case 'external_plugin':
                if ($eventData == 'phoneblogz') {
                    $this->publicInterface();
                }
                break;

            default:
                return false;
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
