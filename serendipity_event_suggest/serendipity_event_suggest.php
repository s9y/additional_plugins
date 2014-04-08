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

class serendipity_event_suggest extends serendipity_event {
    var $title = PLUGIN_SUGGEST_TITLE;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',            PLUGIN_SUGGEST_TITLE);
        $propbag->add('description',     PLUGIN_SUGGEST_DESC);
        $propbag->add('event_hooks',     array(
                                            'entries_header'  => true,
                                            'entry_display'   => true,
                                            'genpage'         => true,
                                            'external_plugin' => true,
                                            'backend_display' => true,
                                            'backend_publish' => true
                                         ));
        $propbag->add('configuration',   array('permalink', 'pagetitle', 'authorid', 'email'));
        $propbag->add('author',          'Garvin Hicking');
        $propbag->add('version',         '0.11');
        $propbag->add('groups',          array('FRONTEND_FEATURES'));
        $propbag->add('requirements',    array(
                                            'serendipity' => '0.9',
                                            'smarty'      => '2.6.7',
                                            'php'         => '4.1.0'
                                         ));
        $propbag->add('stackable',       true);
        $propbag->add('license',         'Commercial');
    }

     function install() {
      global $serendipity;

      serendipity_db_schema_import("CREATE TABLE {$serendipity['dbPrefix']}suggestmails (
            id {AUTOINCREMENT} {PRIMARY},
            email varchar(255) NOT NULL,
            entry_id int(10) {UNSIGNED} not null default '0',
            copycop text NOT NULL,
            ip varchar(16),
            submitted int(11),
            name varchar(255),
            article text,
            title text,
            validation varchar(128)
            );");
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch($name) {
            case 'author':
                $propbag->add('type',        'select');
                $propbag->add('name',        AUTHOR);
                $propbag->add('description', PLUGIN_SUGGEST_AUTHOR);
                $propbag->add('default',     '');
                $users = serendipity_fetchUsers();
                $vals  = array();
                foreach($users AS $user) {
                    $vals[$user['authorid']] = $user['realname'];
                }
                $propbag->add('select_values', $vals);
                break;

            case 'permalink':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SUGGEST_PERMALINK);
                $propbag->add('description', PLUGIN_SUGGEST_PERMALINK_DESC);
                $propbag->add('default',     $serendipity['rewrite'] != 'none'
                                             ? $serendipity['serendipityHTTPPath'] . 'pages/suggest.html'
                                             : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/pages/suggest.html');
                break;

            case 'pagetitle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SUGGEST_PAGETITLE);
                $propbag->add('description', PLUGIN_SUGGEST_PAGETITLE_DESC);
                $propbag->add('default',     'suggest');
                break;

            case 'email':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SUGGEST_EMAIL);
                $propbag->add('description', '');
                $propbag->add('default',     $serendipity['blogMail']);
                break;

            default:
                return false;
        }
        return true;
    }

    function sendComment($to, $title, $fromName, $fromEmail, $fromUrl, $comment) {
        global $serendipity;

        if (empty($fromName)) {
            $fromName = ANONYMOUS;
        }

        $key     = md5(uniqid(rand(), true));

        //  CUSTOMIZE
        $subject = PLUGIN_SUGGEST_TITLE;
        $text    = sprintf(PLUGIN_SUGGEST_MAIL,
                   $serendipity['baseURL'] . '?suggestkey=' . $key);

        $db = array(
            'email'         => $fromEmail,
            'entry_id'      => 0,
            'copycop'       => '',
            'ip'            => $_SERVER['REMOTE_ADDR'],
            'submitted'     => time(),
            'name'          => $fromName,
            'article'       => $comment,
            'title'         => $title,
            'validation'    => $key
        );
        serendipity_db_insert('suggestmails', $db);

        return serendipity_sendMail($to, $subject, $text, $serendipity['blogMail'], null, $serendipity['blogTitle']);
    }

    function checkSubmit() {
        global $serendipity;

        if (empty($serendipity['POST']['suggestform'])) {
            return false;
        }

        if (empty($serendipity['POST']['name']) || empty($serendipity['POST']['email']) || empty($serendipity['POST']['comment'])) {
            $serendipity['smarty']->assign(
                array(
                    'is_suggest_error'     => true,
                    'plugin_suggest_error' => PLUGIN_SUGGEST_ERROR_DATA
                )
            );

            return false;
        }

        // Fake call to spamblock/captcha and other comment plugins.
        $ca = array(
            'id'                => 0,
            'allow_comments'    => 'true',
            'moderate_comments' => '0',
            'last_modified'     => 1,
            'timestamp'         => 1
        );

        // Strip everything except <a>, <b>, <strong>
        $serendipity['POST']['comment'] = strip_tags($serendipity['POST']['comment'], '<b><strong><a>');

        $commentInfo = array(
            'type'      => 'NORMAL',
            'source'    => 'suggestform',
            'name'      => $serendipity['POST']['name'],
            'url'       => $serendipity['POST']['url'],
            'comment'   => $serendipity['POST']['comment'],
            'email'     => $serendipity['POST']['email'],
            'timestamp' => true
        );
        serendipity_plugin_api::hook_event('frontend_saveComment', $ca, $commentInfo);

        if ($ca['allow_comments'] === false) {
            $serendipity['smarty']->assign(
                array(
                    'is_suggest_error'     => true,
                    'plugin_suggest_error' => PLUGIN_SUGGEST_ERROR_DATA
                )
            );

            return false;
        }
        // End of fake call.

        if ($this->sendComment(
                $serendipity['POST']['email'],
                $serendipity['POST']['entry_title'],
                $serendipity['POST']['name'],
                $serendipity['POST']['email'],
                $serendipity['POST']['url'],
                $serendipity['POST']['comment'])) {

            $serendipity['smarty']->assign('is_suggest_sent', true);
            return true;
        } else {
            // Unkown error occurred.
            $serendipity['smarty']->assign(
                array(
                    'is_suggest_error'     => true,
                    'plugin_suggest_error' => PLUGIN_SUGGEST_ERROR_HTML
                )
            );
        }

        return false;
    }

    function show() {
        global $serendipity;

        if ($this->selected()) {
            if (!headers_sent()) {
                header('HTTP/1.0 200');
                header('Status: 200 OK');
            }

            if (!is_object($serendipity['smarty'])) {
                serendipity_smarty_init();
            }

            $_ENV['staticpage_pagetitle'] = preg_replace('@[^a-z0-9]@i', '_',$this->get_config('pagetitle'));
            $serendipity['smarty']->assign('staticpage_pagetitle', $_ENV['staticpage_pagetitle']);

            $this->checkSubmit();

            $validation_error      = false;
            $validation_success    = false;
            $validation_error_code = 0;

            if (!empty($_REQUEST['suggestkey'])) {
                $res = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}suggestmails WHERE validation = '" . serendipity_db_escape_string($_REQUEST['suggestkey']) . "'", true, 'assoc');
                if (!is_array($res) || $res['validation'] != $_REQUEST['suggestkey']) {
                    $validation_error      = true;
                    $validation_error_code = htmlspecialchars($_REQUEST['suggestkey']);
                } else {
                    $validation_success = true;
                    $validation_error_code = htmlspecialchars($_REQUEST['suggestkey']);
                    serendipity_db_query("UPDATE {$serendipity['dbPrefix']}suggestmails SET validation = '' WHERE id = " . (int)$res['id']);

                    $entry = array(
                        'isdraft'           => true,
                        'allow_comments'    => true,
                        'moderate_comments' => '0',
                        'authorid'          => $this->get_config('authorid'),
                        'title'             => $res['title'],
                        'body'              => $res['article']
                    );
                    $serendipity['POST']['properties'] = array('fake' => 'fake');
                    ob_start();
                    $id = serendipity_updertEntry($entry);
                    serendipity_db_query("UPDATE {$serendipity['dbPrefix']}suggestmails SET entry_id = " . (int)$id . "  WHERE id = " . (int)$res['id']);
                    $metaout = ob_get_contents();
                    ob_end_clean();
                    serendipity_sendMail($this->get_config('email'), PLUGIN_SUGGEST_TITLE . ': ' . $res['title'], $res['article'], $serendipity['blogMail'], null, $serendipity['blog']);
                }
            }

            $serendipity['smarty']->assign(
                array(
                    'input'                         => $_REQUEST,
                    'plugin_suggest_articleformat'  => $this->get_config('articleformat'),
                    'plugin_suggest_name'           => PLUGIN_SUGGEST_TITLE,
                    'plugin_suggest_pagetitle'      => $this->get_config('pagetitle'),

                    'plugin_suggest_message'        => PLUGIN_SUGGEST_MESSAGE,
                    'suggest_backend'               => $metaout,
                    'suggest_action'                => $serendipity['baseURL'] . $serendipity['indexFile'],
                    'suggest_sname'                 => $serendipity['GET']['subpage'],
                    'suggest_name'                  => htmlspecialchars($serendipity['POST']['name']),
                    'suggest_url'                   => htmlspecialchars($serendipity['POST']['url']),
                    'suggest_email'                 => htmlspecialchars($serendipity['POST']['email']),
                    'suggest_entry_title'           => htmlspecialchars($serendipity['POST']['entry_title']),
                    'suggest_data'                  => htmlspecialchars($serendipity['POST']['comment']),
                    'comments_messagestack'         => $serendipity['messagestack']['comments'],
                    'suggest_validation_error'      => $validation_error,
                    'suggest_validation_success'    => $validation_success,
                    'suggest_validation_code'       => $validation_error_code,

                    'suggest_entry'                 => array(
                                                            'timestamp' => 1, // force captchas!
                                                        )
                )
            );

            $tfile = serendipity_getTemplateFile('plugin_suggest.tpl', 'serendipityPath');
            if (!$tfile) {
                $tfile = dirname(__FILE__) . '/plugin_suggest.tpl';
            }
            $inclusion = $serendipity['smarty']->security_settings[INCLUDE_ANY];
            $serendipity['smarty']->security_settings[INCLUDE_ANY] = true;
            $content = $serendipity['smarty']->fetch('file:'. $tfile);
            $serendipity['smarty']->security_settings[INCLUDE_ANY] = $inclusion;

            echo $content;
        }
    }

    function selected() {
        global $serendipity;

        if (!empty($_REQUEST['suggestkey'])) {
            $serendipity['GET']['subpage'] = $this->get_config('pagetitle');
        }

        if (!empty($serendipity['POST']['subpage'])) {
            $serendipity['GET']['subpage'] = $serendipity['POST']['subpage'];
        }

        if ($serendipity['GET']['subpage'] == $this->get_config('pagetitle') ||
            preg_match('@^' . preg_quote($this->get_config('permalink')) . '@i', $serendipity['GET']['subpage'])) {
            return true;
        }

        return false;
    }

    function generate_content(&$title) {
        $title = PLUGIN_SUGGEST_TITLE.' (' . $this->get_config('pagetitle') . ')';
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'external_plugin':
                    $events = explode('_', $eventData);
                    if ($events[0] != 'copycop') return false;

                    // TODO: Call CopyCop here somehow.
                    break;

                case 'genpage':
                    $args = implode('/', serendipity_getUriArguments($eventData, true));
                    if ($serendipity['rewrite'] != 'none') {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $args;
                    } else {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/' . $args;
                    }

                    if (empty($serendipity['GET']['subpage'])) {
                        $serendipity['GET']['subpage'] = $nice_url;
                    }
                    break;

                case 'entry_display':
                    if ($this->selected()) {
                        if (is_array($eventData)) {
                            $eventData['clean_page'] = true; // This is important to not display an entry list!
                        } else {
                            $eventData = array('clean_page' => true);
                        }
                    }

                    return true;
                    break;

                case 'entries_header':
                    $this->show();

                    return true;
                    break;

                case 'backend_publish':
                    if (!$eventData['id']) return false;
                    $res = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}suggestmails WHERE entry_id = " . (int)$eventData['id'], true, 'assoc');
                    if (!is_array($res)) {
                        $res = array();
                    }

                    if (!$res['id']) {
                        return false;
                    }

                    //  CUSTOMIZE
                    serendipity_sendMail($res['email'], PLUGIN_SUGGEST_TITLE, PLUGIN_SUGGEST_PUBLISHED, $serendipity['blogMail'], null, $serendipity['blog']);
                    echo PLUGIN_SUGGEST_INFORM . "<br />\n";

                    serendipity_db_query("REPLACE INTO {$serendipity['dbPrefix']}entryproperties
                                                       (entryid, property, value)
                                                VALUES (" . (int)$eventData['id'] . ", 'ep_suggest_name', '" . serendipity_db_escape_string($res['name']) . "')");
                    break;

                case 'backend_display':
                    if (!$eventData['id']) return false;
                    $res = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}suggestmails WHERE entry_id = " . (int)$eventData['id'], true, 'assoc');
                    if (!is_array($res)) {
                        $res = array();
?>
                    <fieldset style="margin: 5px">
                        <legend><?php echo PLUGIN_SUGGEST_TITLE; ?></legend>
                        <div><?php echo PLUGIN_SUGGEST_INTERNAL; ?></div>
                    </fieldset>

<?php
                    } else {
                        //  CUSTOMIZE
?>
                    <fieldset style="margin: 5px">
                        <legend><?php echo PLUGIN_SUGGEST_TITLE; ?></legend>
                        <div>
                            <?php printf(PLUGIN_SUGGEST_META, htmlspecialchars($res['name']), strftime('%d.%m.%Y %H:%M', $res['submitted']), htmlspecialchars($res['ip']), htmlspecialchars($res['email'])); ?>
                        </div>
                    </fieldset>
<?php
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
}

/* vim: set sts=4 ts=4 expandtab : */