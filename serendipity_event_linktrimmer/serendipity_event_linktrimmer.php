<?php #

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_linktrimmer extends serendipity_event {
    var $debug;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_LINKTRIMMER_NAME);
        $propbag->add('description',   PLUGIN_LINKTRIMMER_DESC);
        $propbag->add('requirements',  array(
            'serendipity' => '1.3',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('version',       '1.6.2');
        $propbag->add('author',        'Garvin Hicking, Ian');
        $propbag->add('stackable',     false);
        $propbag->add('configuration', array('prefix', 'frontpage', 'domain'));
        $propbag->add('event_hooks',   array(
                                            'backend_frontpage_display'      => true,
                                            'css_backend'                    => true,
                                            'frontend_configure'             => true,
                                            'backend_dashboard'              => true,
                                            'backend_entry_toolbar_extended' => true,
                                            'backend_entry_toolbar_body'     => true,
                                            'backend_wysiwyg'                => true,
                                            'external_plugin'                => true,

                                        )
        );
        #$this->dependencies = array('serendipity_event_jquery' => 'keep');
        $propbag->add('groups', array('BACKEND_FEATURES'));
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch($name) {
            case 'prefix':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_LINKTRIMMER_LINKPREFIX);
                $propbag->add('description', PLUGIN_LINKTRIMMER_LINKPREFIX_DESC);
                $propbag->add('default',     'l');
                break;

            case 'frontpage':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_LINKTRIMMER_FRONTPAGE_OPTION);
                $propbag->add('description', '');
                $propbag->add('default', 'true');
                break;

            case 'domain':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_LINKTRIMMER_DOMAIN);
                $propbag->add('description', PLUGIN_LINKTRIMMER_DOMAIN_DESC);
                $propbag->add('default',     $serendipity['baseURL']);
                break;

            default:
                return false;
        }
        return true;
    }

    function setupDB() {
        global $serendipity;

        if (serendipity_db_bool($this->get_config('db_built_1', false))) {
            return true;
        }

        if (preg_match('@mysql@i', $serendipity['dbType'])) {
            $sql = "CREATE TABLE {$serendipity['dbPrefix']}linktrimmer (
                          id {AUTOINCREMENT} {PRIMARY},
                          hash varchar(32) collate latin1_general_cs,
                          url text
                        );";
        } else {
            $sql = "CREATE TABLE {$serendipity['dbPrefix']}linktrimmer (
                          id {AUTOINCREMENT} {PRIMARY},
                          hash varchar(32),
                          url text
                        );";
        }

        serendipity_db_schema_import($sql);

        $sql = "CREATE INDEX linkidx ON {$serendipity['dbPrefix']}linktrimmer (hash)";
        serendipity_db_schema_import($sql);

        $this->set_config('db_built_1', 'true');
    }

    function generate_content(&$title) {
        $title = PLUGIN_LINKTRIMMER_NAME;
    }

    static function base62($var) {
        static $base_characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        $stack = array();
        while (bccomp($var, 0) != 0) {
            $remainder = bcmod($var, 62);
            $var = bcdiv(bcsub($var, $remainder), 62);

            array_push($stack, $base_characters[$remainder]);
        }

        return implode('', array_reverse($stack));
    }

    static function lookup($url, $custom_hash = '', $pref = '') {
        global $serendipity;

        $custom_hash = trim($custom_hash);
        $url = trim($url);

        if (!preg_match('@https?://@i', $url)) {
            $url = 'http://' . $url;
        }

        $res = serendipity_db_query("SELECT hash FROM {$serendipity['dbPrefix']}linktrimmer WHERE url = '" . serendipity_db_escape_string($url) . "' LIMIT 1", true, 'assoc');
        if (!is_array($res) || empty($res['hash'])) {

            if (!empty($custom_hash)) {
                $res = serendipity_db_query("SELECT hash FROM {$serendipity['dbPrefix']}linktrimmer WHERE hash = '" . serendipity_db_escape_string($custom_hash) . "' LIMIT 1", true, 'assoc');
                if (is_array($res) && !empty($res['hash'])) {
                    return false;
                }
            }

            $hash = serendipity_event_linktrimmer::create($url, $custom_hash);
            if (empty($hash)) {
                return false;
            } else {
                return $pref . $hash;
            }
        }

        return $pref . $res['hash'];
    }

    static function create($url, $hash = '') {
        global $serendipity;

        serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}linktrimmer (url) VALUES ('" . serendipity_db_escape_string($url) . "')");
        $id = serendipity_db_insert_id();

        if (empty($id)) return false;

        if (empty($hash)) {
            $hash = serendipity_event_linktrimmer::base62($id);
        }

        serendipity_db_query("UPDATE {$serendipity['dbPrefix']}linktrimmer
                                 SET hash = '" . $hash . "'
                               WHERE id = " . (int)$id);

        return $hash;
    }

    function show($external = false) {
        global $serendipity;

        if (IN_serendipity !== true) {
            die ("Don't hack!");
        }

        if (!is_object($serendipity['smarty'])) {
            serendipity_smarty_init();
        }

        $this->setupDB();

        $pref = $this->get_config('domain') . $this->get_config('prefix') . '/';
        if ($this->get_config('domain') == $serendipity['baseURL'])  {
            $pref = $this->get_config('domain') . $this->get_config('prefix') . '/';
        } else {
            $pref = $this->get_config('domain');
        }

        if (isset($_REQUEST['submit']) && !empty($_REQUEST['linktrimmer_url'])) {
            $url = $this->lookup($_REQUEST['linktrimmer_url'], $_REQUEST['linktrimmer_hash'], $pref);
            if ($url == false) {
                $error = PLUGIN_LINKTRIMMER_ERROR;
            }
        }

        $serendipity['smarty']->assign(array(
            'linktrimmer_ispopup'     => $serendipity['enablePopup'],
            'linktrimmer_error'       => $error,
            'linktrimmer_url'         => $url,
            'linktrimmer_origurl'     => $_REQUEST['linktrimmer_url'],
            'linktrimmer_external'    => $external,
            'linktrimmer_txtarea'     => $_REQUEST['txtarea']
        ));

        if ($serendipity['version'][0] > '1') {
            echo $this->parseTemplate('plugin_linktrimmer.tpl');
        } else {
            echo $this->parseTemplate('plugin_linktrimmer_old.tpl');
        }
    }

    function generate_button ($txtarea) {
        global $serendipity;
        if (!isset($txtarea)) {
           $txtarea = 'body';
        }
        $link =  ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/linktrimmer' . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;') . 'txtarea=' . $txtarea;
        if ($serendipity['version'][0] > '1') {
?>
        <input type="button" class="input_button"  name="insLinktrimmer" value="<?php echo PLUGIN_LINKTRIMMER_NAME; ?>" style="" onclick="serendipity.openPopup('<?php echo $link; ?>', 'linktrimmerSel', 'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1');">
<?php
        } else {
?>
        <input type="button" class="serendipityPrettyButton input_button"  name="insLinktrimmer" value="<?php echo PLUGIN_LINKTRIMMER_NAME; ?>" style="" onclick="window.open('<?php echo $link; ?>', 'linktrimmerSel', 'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1');" />
<?php
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;
        static $has_jquery = null;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            if ($has_jquery === null) {
                $has_jquery = class_exists('serendipity_event_jquery');
                if ($serendipity['capabilities']['jquery']) {
                    $has_jquery = true;
                }
            }

            switch($event) {
                case 'backend_entry_toolbar_extended':
                    if (isset($eventData['backend_entry_toolbar_extended:textarea'])) {
                        $txtarea = $serendipity['version'][0] < '2' ?  $eventData['backend_entry_toolbar_extended:textarea'] : $eventData['backend_entry_toolbar_extended:nugget'];
                    } else {
                        $txtarea = 'extended';
                    }
                    if (!$serendipity['wysiwyg']) {
                        $this->generate_button($txtarea);
                        return true;
                    } else {
                        return false;
                    }
                    break;

                case 'backend_entry_toolbar_body':
                    if (isset($eventData['backend_entry_toolbar_body:textarea'])) {
                        $txtarea = $serendipity['version'][0] < '2' ?  $eventData['backend_entry_toolbar_body:textarea'] : $eventData['backend_entry_toolbar_body:nugget'];
                    } else {
                        $txtarea = 'body';
                    }
                    if (!$serendipity['wysiwyg']) {
                        $this->generate_button($txtarea);
                        return true;
                    } else {
                        return false;
                    }
                    break;

                case 'backend_wysiwyg':
                    $link = $serendipity['serendipityHTTPPath'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/linktrimmer' . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;') . 'txtarea=' . ($serendipity['version'][0] > '1' ? 'linktrimmer'.$eventData['item'] : $eventData['jsname']);
                    $open = $serendipity['version'][0] > '1' ? 'serendipity.openPopup' : 'window.open';
                    $eventData['buttons'][] = array(
                        'id'         => 'linktrimmer' . ($serendipity['version'][0] > '1' ? $eventData['item'] : $eventData['jsname']),
                        'name'       => PLUGIN_LINKTRIMMER_NAME,
                        'javascript' => 'function() { '.$open.'(\'' . $link . '\', \'LinkTrimmer\', \'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1\') }',
                        'img_url'    => $serendipity['serendipityHTTPPath'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/plugin_linktrimmer.gif',
                        'img_path'   => 'serendipity_event_linktrimmer/serendipity_event_linktrimmer.gif',
                        'toolbar'    => 'other'
                    );//'img_path' deprecated, used by ckeditor plugin <= 4.1.0
                    return true;
                    break;

                case 'frontend_configure':
                    if (preg_match('@' . $serendipity['serendipityHTTPPath'] . '/?(' . $serendipity['indexFile'] . ')?\??' . $this->get_config('prefix') . '/?(.+)$@imsU', $_SERVER['REQUEST_URI'], $m)) {
                        $hash = preg_replace('@[^a-z0-9]@imsU', '', $m[2]);
                        $res = serendipity_db_query("SELECT url
                                                       FROM {$serendipity['dbPrefix']}linktrimmer
                                                      WHERE hash = '" . serendipity_db_escape_string($hash) . "'
                                                      LIMIT 1", true, 'assoc');
                        if (is_array($res) && !empty($res['url'])) {
                            $url = str_replace(array("\n", "\r", "\0"), array('', '', ''), $res['url']);
                            header('HTTP/1.0 301 Moved Permanently');
                            header('Location: ' . $url);
                            exit;
                        }
                    }
                    break;

                case 'backend_dashboard':
                    if (serendipity_db_bool($this->get_config('frontpage', true)) ) $this->show();
                    break;

                case 'backend_frontpage_display':
                    if (serendipity_db_bool($this->get_config('frontpage', true) && $serendipity['version'][0] <= '1') ) $this->show();
                    break;

                case 'external_plugin':
                    if ($_SESSION['serendipityAuthedUser'] !== true)  {
                        return true;
                    }

                    $uri_parts = explode('?', str_replace('&amp;', '&', $eventData));
                    $parts     = explode('&', $uri_parts[0]);

                    $uri_part = $parts[0];
                    $parts = array_pop($parts);

                    if (count($parts) > 1) {
                       foreach($parts as $key => $value) {
                            $val = explode('=', $value);
                            $_REQUEST[$val[0]] = $val[1];
                       }
                    } else {
                       $val = explode('=', $parts[0]);
                       $_REQUEST[$val[0]] = $val[1];
                    }

                    if (!isset($_REQUEST['txtarea'])) {
                        $parts = explode('&', $uri_parts[1]);
                        if (count($parts) > 1) {
                            foreach($parts as $key => $value) {
                                 $val = explode('=', $value);
                                 $_REQUEST[$val[0]] = $val[1];
                            }
                        } else {
                            $val = explode('=', $parts[0]);
                            $_REQUEST[$val[0]] = $val[1];
                        }
                    }

                    switch($uri_part) {
                        case 'plugin_linktrimmer.gif':
                            header('Content-Type: image/gif');
                            echo file_get_contents(dirname(__FILE__) . '/serendipity_event_linktrimmer.gif');
                            break;

                        case 'linktrimmer':
                            $this->show(true);
                    }
                    break;

                case 'css_backend':
                    if (!strpos($eventData, '.linktrimmer')) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        echo file_get_contents(dirname(__FILE__) . '/linktrimmer.css');
                        if ($serendipity['version'][0] < '2') echo '#linktrimmer_url.input_textbox { width: inherit; }';
                    }
                    break;

            }
        }

        return true;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
