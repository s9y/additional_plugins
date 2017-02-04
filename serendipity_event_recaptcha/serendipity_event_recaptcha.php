<?php # 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

require_once dirname(__FILE__) . '/recaptcha/recaptchalib.php';

class serendipity_event_recaptcha extends serendipity_event
{
var $error=null;

    function introspect(&$propbag)
    {
        global $serendipity;


        $this->title = PLUGIN_EVENT_RECAPTCHA_TITLE;

        $propbag->add('name',          PLUGIN_EVENT_RECAPTCHA_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_RECAPTCHA_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Christian Brabandt (based on work of Garvin Hicking, Sebastian Nohn)');
        $propbag->add('requirements',  array(
            'serendipity' => '1.0',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '0.20');
        $propbag->add('event_hooks',    array(
            'frontend_configure'   => true,
            'frontend_saveComment' => true,
            'frontend_comment'     => true
        ));
        $propbag->add('configuration', array(
            'info',
            'sep',
            'hide_for_authors',
            'recaptcha',
            'recaptcha_style',
            'recaptcha_pub',
            'recaptcha_priv',
            'captchas_ttl',
            'logtype',
            'logfile'));
        $propbag->add('groups', array('ANTISPAM'));

    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'recaptcha':
                $propbag->add('type', 'radio');
                $propbag->add('name', PLUGIN_EVENT_RECAPTCHA_RECAPTCHA);
                $propbag->add('description', PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_DESC);
                $propbag->add('default', 'no');
                $propbag->add('radio', array(
                    'value' => array('yes2', 'no', 'yes'),
                    'desc'  => array(YES . ' (v2)', NO, YES . ' (old v1, deprecated)')
                ));
                break;

            case 'recaptcha_pub':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PUB);
                $propbag->add('description', PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PUB_DESC);
                $propbag->add('default', '');
                break;

            case 'recaptcha_priv':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PRIV);
                $propbag->add('description', PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PRIV_DESC);
                $propbag->add('default', '');
                break;

            case 'recaptcha_style':
                $propbag->add('type', 'radio');
                $propbag->add('name', PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_STYLE);
                $propbag->add('description', PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_STYLE_DESC);
                $propbag->add('default', 'red');
                $propbag->add('radio', array(
                    'value' => array('red', 'white', 'blackglass'),
                    'desc'  => array('Red', 'White', 'Blackglass')
                ));
                break;

            case 'hide_for_authors':
                $_groups =& serendipity_getAllGroups();
                $groups = array(
                    'all'  => ALL_AUTHORS,
                    'none' => NONE
                );

                foreach($_groups AS $group) {
                    $groups[$group['confkey']] = $group['confvalue'];
                }

                $propbag->add('type', 'multiselect');
                $propbag->add('name', PLUGIN_EVENT_RECAPTCHA_HIDE);
                $propbag->add('description', PLUGIN_EVENT_RECAPTCHA_HIDE_DESC);
                $propbag->add('select_values', $groups);
                $propbag->add('select_size',   5);
                $propbag->add('default', 'all');
                break;

            case 'logfile':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_RECAPTCHA_LOGFILE);
                $propbag->add('description', PLUGIN_EVENT_RECAPTCHA_LOGFILE_DESC);
                $propbag->add('default', $serendipity['serendipityPath'] . 'spamblock.log');
                break;

            case 'logtype':
                $propbag->add('type', 'radio');
                $propbag->add('name', PLUGIN_EVENT_RECAPTCHA_LOGTYPE);
                $propbag->add('description', PLUGIN_EVENT_RECAPTCHA_LOGTYPE_DESC);
                $propbag->add('default', 'db');
                $propbag->add('radio',         array(
                    'value' => array('file', 'db', 'none'),
                    'desc'  => array(PLUGIN_EVENT_RECAPTCHA_LOGTYPE_FILE, PLUGIN_EVENT_RECAPTCHA_LOGTYPE_DB, PLUGIN_EVENT_RECAPTCHA_LOGTYPE_NONE)
                ));
                $propbag->add('radio_per_row', '1');

                break;

            case 'captchas_ttl':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_RECAPTCHA_CAPTCHAS_TTL);
                $propbag->add('description', PLUGIN_EVENT_RECAPTCHA_CAPTCHAS_TTL_DESC);
                $propbag->add('default', '7');
                break;
            
            case 'info':
                $suche='!http(?:s)?:\/\/(?:(?:[^.]*)\.)?([^.\/]*)!';
                $result=preg_match($suche,$serendipity['baseURL'],$domain);
                $propbag->add('type', 'content');
                $propbag->add('default', PLUGIN_EVENT_RECAPTCHA_INFO1.$domain[1]. PLUGIN_EVENT_RECAPTCHA_INFO2);
                break;

            case 'sep':
                $propbag->add('type', 'seperator');
                break;

            default:
                    return false;
        }

        return true;
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    // Checks whether the current author is contained in one of the groups that
    // need no spam checking
    function inGroup() {
        global $serendipity;

        $checkgroups = explode('^', $this->get_config('hide_for_authors'));

        if (!isset($serendipity['authorid']) || !is_array($checkgroups)) {
            return false;
        }

        $mygroups =& serendipity_getGroups($serendipity['authorid'], true);
        if (!is_array($mygroups)) {
            return false;
        }

        foreach($checkgroups AS $key => $groupid) {
            if ($groupid == 'all') {
                return true;
            } elseif (in_array($groupid, $mygroups)) {
                return true;
            }
        }

        return false;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            $captchas_ttl = $this->get_config('captchas_ttl', 7);
            $_recaptcha   = $this->get_config('recaptcha', 'no');
            $recaptcha    = ($_recaptcha === 'yes' || $_recaptcha === 'yes2' || $_recaptcha !== 'no'  || serendipity_db_bool($_recaptcha));

            // Check if the entry is older than the allowed amount of time.
            // Enforce captchas if that is true of if captchas are activated
            // for every entry

            $show_captcha = (($recaptcha) && isset($eventData['timestamp']) && ($captchas_ttl < 1 || ($eventData['timestamp'] < (time() - ($captchas_ttl*60*60*24)))) ? true : false);

            switch($event) {
                case 'frontend_configure':
                    // set a variable, so that the spamblock plugin can disable the captcha when recaptcha is found.
                    if ($_recaptcha) {
                        $serendipity['plugins']['disable_internal_captcha'] = true;
                    }

                    return true;
                    break;

                case 'frontend_saveComment':
                    if (!is_array($eventData) || serendipity_db_bool($eventData['allow_comments'])) {

                        //$serendipity['csuccess'] = 'true';
                        $logfile = $this->logfile = $this->get_config('logfile', $serendipity['serendipityPath'] . 'spamblock.log');

                        // Check whether to allow comments from registered authors
                        if (serendipity_userLoggedIn() && $this->inGroup()) {
                            return true;
                        }

                        // Captcha checking
                        if ($show_captcha && $addData['type'] == 'NORMAL') {
                            $privatekey = $this->get_config('recaptcha_priv');
                            
                            if ($_POST["recaptcha_response_field"] != 1) {
                                if ($_recaptcha === 'yes2') {
                                    $resp_valid = '';
                                    $resp_error = '';

                                    $url = 'https://www.google.com/recaptcha/api/siteverify';
                                    if (function_exists('serendipity_request_url')) {
                                        $data = serendipity_request_url(
                                            $url, 
                                            'POST', 
                                            null, 
                                            array(
                                                'secret' => $privatekey,
                                                'response' => $_POST["g-recaptcha-response"],
                                                'remoteip' => $_SERVER['REMOTE_ADDR']
                                            )
                                        );
                                    } else {
                                        require_once S9Y_PEAR_PATH . 'HTTP/Request.php';
                                        serendipity_request_start();
                                        $req = new HTTP_Request($url, array('method' => HTTP_REQUEST_METHOD_POST, 'allowRedirects' => true, 'timeout' => 20, 'readTimeout' => array(5,0), 'maxRedirects' => 3));
                                        $req->addPostData('secret', $privatekey);
                                        $req->addPostData('response', $_POST["g-recaptcha-response"]);
                                        $req->addPostData('remoteip', $_SERVER['REMOTE_ADDR']);
                                        $req->sendRequest();
                                        $data = $req->getResponseBody();
                                        serendipity_request_end();
                                    }

                                    if (empty($data)) {
                                        $resp_valid = false;
                                        $resp_error = 'Empty Request';
                                    } else {
                                        $json_data = json_decode($data);
                                        if (!is_object($json_data)) {
                                            $resp_valid = false;
                                            $resp_error = 'Invalid JSON return: ' . $data;
                                        } else {
                                            $resp_valid = $json_data->success;
                                            $resp_error = $json_data->{'error-codes'};
                                        }
                                    }
                                } else {
                                    $resp = recaptcha_check_answer($privatekey,
                                                                    $_SERVER["REMOTE_ADDR"],
                                                                    $_POST["recaptcha_challenge_field"],
                                                                    $_POST["recaptcha_response_field"]);
                                    $resp_valid = $resp->is_valid;
                                    $resp_error = $resp->error;
                                }

                                if (!$resp_valid) {
                                    # set the error code so that we can display it
                                    $this->error = $resp_error;
                                    $this->log($logfile, $eventData['id'], 'REJECTED', $this->error,  $addData);
                                    $eventData = array('allow_comments' => false);
                                    $serendipity['messagestack']['comments'][] = PLUGIN_EVENT_RECAPTCHA_ERROR_CAPTCHAS;
                                    return false;
                                }
                            } else {
                                return false;
                            }
                        }
                    }

                    return true;
                    break;

                case 'frontend_comment':
                    // Check whether to allow comments from registered authors
                    if (serendipity_userLoggedIn() && $this->inGroup()) {
                        return true;
                    }

                    if ($show_captcha) {
                        $pubkey  = $this->get_config('recaptcha_pub');
                        $privkey = $this->get_config('recaptcha_priv');
                        if ( $recaptcha && (($pubkey == null || $pubkey == '')  || ($privkey == null || $pubkey == '')) ) {
                            $recaptcha = false;
                            //$captchas  = true;
                            printf('<div class="serendipity_center serendipity_msg_important">%s</div>',PLUGIN_EVENT_RECAPTCHA_ERROR_RECAPTCHA);
                         }
                            
                        // The response from recaptcha.net
                        if ($_recaptcha === 'yes2') {
                            echo "<script src='https://www.google.com/recaptcha/api.js'></script>";
                            echo '<div class="g-recaptcha" data-sitekey="' . $pubkey . '"></div>';
                        } else {
                            $resp    = null;
                            $theme   = $this->get_config('recaptcha_style', 'red');
                            echo "\n<script type=\"text/javascript\">\n var RecaptchaOptions = { theme : '".$theme."', lang : '" . $serendipity['lang'] . "' };\n</script>";
                            $use_ssl = false;
                            if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
                                $use_ssl = true;
                            }
                            echo recaptcha_get_html($pubkey, $this->error, $use_ssl);
                        }
                    }

                    return true;
                    break;


                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
    }


    function log($logfile, $id, $switch, $reason, $comment) {
        global $serendipity;

        $method = $this->get_config('logtype');

        switch($method) {
            case 'file':
                if (empty($logfile)) {
                    return;
                }

                $fp = @fopen($logfile, 'a+');
                if (!is_resource($fp)) {
                    return;
                }

                fwrite($fp, sprintf(
                    '[%s] - [%s: %s] - [#%s, Name "%s", E-Mail "%s", URL "%s", User-Agent "%s", IP %s] - [%s]' . "\n",
                    date('Y-m-d H:i:s', serendipity_serverOffsetHour()),
                    $switch,
                    $reason,
                    $id,
                    str_replace("\n", ' ', $comment['name']),
                    str_replace("\n", ' ', $comment['email']),
                    str_replace("\n", ' ', $comment['url']),
                    str_replace("\n", ' ', $_SERVER['HTTP_USER_AGENT']),
                    $_SERVER['REMOTE_ADDR'],
                    str_replace("\n", ' ', $comment['comment'])
                ));

                fclose($fp);
                break;

            case 'none':
                return;
                break;

            case 'db':
            default:
                $q = sprintf("INSERT INTO {$serendipity['dbPrefix']}spamblocklog
                                          (timestamp, type, reason, entry_id, author, email, url,  useragent, ip,   referer, body)
                                   VALUES (%d,        '%s',  '%s',  '%s',     '%s',   '%s',  '%s', '%s',      '%s', '%s',    '%s')",

                           serendipity_serverOffsetHour(),
                           serendipity_db_escape_string($switch),
                           serendipity_db_escape_string($reason),
                           serendipity_db_escape_string($id),
                           serendipity_db_escape_string($comment['name']),
                           serendipity_db_escape_string($comment['email']),
                           serendipity_db_escape_string($comment['url']),
                           serendipity_db_escape_string($_SERVER['HTTP_USER_AGENT']),
                           serendipity_db_escape_string($_SERVER['REMOTE_ADDR']),
                           serendipity_db_escape_string(isset($_SESSION['HTTP_REFERER']) ? $_SESSION['HTTP_REFERER'] : $_SERVER['HTTP_REFERER']),
                           serendipity_db_escape_string($comment['comment'])
                );

                serendipity_db_query($q);
                break;
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
