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

class serendipity_event_emoticonchooser extends serendipity_event
{
    var $title = PLUGIN_EVENT_EMOTICONCHOOSER_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_EMOTICONCHOOSER_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_EMOTICONCHOOSER_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Jay Bertrandt, Ian');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '2.8');
        $propbag->add('event_hooks',    array(
            'backend_entry_toolbar_extended' => true,
            'backend_entry_toolbar_body'     => true,
            'frontend_comment'               => true,
            'backend_header'                 => true,
            'frontend_header'                => true,
            'css_backend'                    => true
        ));
        $propbag->add('groups', array('BACKEND_EDITOR'));
        $propbag->add('configuration', array('frontend', 'popup', 'button', 'popuptext'));
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENT_EMOTICONCHOOSER_TITLE;
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'frontend':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_EMOTICONCHOOSER_FRONTEND);
                $propbag->add('description', '');
                $propbag->add('default',     false);
                return true;
                break;

            case 'popup':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_EMOTICONCHOOSER_POPUP);
                $propbag->add('description', '');
                $propbag->add('default',     false);
                return true;
                break;

            case 'button':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_EMOTICONCHOOSER_POPUP_BUTTON);
                $propbag->add('description', 'default: as link');
                $propbag->add('default',     false);
                return true;
                break;

            case 'popuptext':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_EMOTICONCHOOSER_POPUPTEXT);
                $propbag->add('description', '');
                $propbag->add('default',     PLUGIN_EVENT_EMOTICONCHOOSER_POPUPTEXT_DEFAULT);
                return true;
                break;
        }
        return false;
    }


    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        if (!class_exists('serendipity_event_emoticate')) {
            return false;
        }

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_comment':
                    if (serendipity_db_bool($this->get_config('frontend', false)) === false) {
                        break;
                    }
                    $txtarea = 'serendipity_commentform_comment';
                    $func    = 'comment';
                    $style   = '';
                    $popcl   = '';

                case 'backend_entry_toolbar_extended':
                    if (!isset($txtarea)) {
                        $txtarea = 'serendipity[extended]';
                        $func    = 'extended';
                    }

                case 'backend_entry_toolbar_body':
                    if (!isset($txtarea)) {
                        if (isset($eventData['backend_entry_toolbar_body:textarea'])) {
                            // event caller has given us the name of the textarea converted
                            // into a wysiwg editor(for example, the staticpages plugin)
                            $txtarea = $eventData['backend_entry_toolbar_body:textarea'];
                        } else {
                            // default value
                            $txtarea = 'serendipity[body]';
                        }
                        if (isset($eventData['backend_entry_toolbar_body:nugget'])) {
                            $func = $eventData['backend_entry_toolbar_body:nugget'];
                        } else{
                            $func    = 'body';
                        }
                    }

                    // CKEDITOR and plain editor need this little switch
                    if (preg_match('@^nugget@i', $func)) {
                        $cke_txtarea = $func;
                    } else {
                        $cke_txtarea = $txtarea;
                    }

                    if (!isset($popcl)) {
                        $popcl = ' serendipityPrettyButton';
                    }

                    if (!isset($style)) {
                        $style = 'margin-top: 5px; vertical-align: bottom';
                    }

                    $popupstyle = '';
                    $popuplink  = '';
                    if (serendipity_db_bool($this->get_config('popup', false))) {
                        $popupstyle = '; display: none';
                        $popuplink  = serendipity_db_bool($this->get_config('button', false)) 
                                    ? '<input type="button" onclick="toggle_emoticon_bar_' . $func . '(); return false" href="#" class="serendipity_toggle_emoticon_bar' . $popcl . '" value="' . $this->get_config('popuptext') . '">' 
                                    : '<a class="serendipity_toggle_emoticon_bar' . $popcl . '" href="#" onclick="toggle_emoticon_bar_' . $func . '(); return false">' . $this->get_config('popuptext') . '</a>';
                    }

                    $i = 1;

                    // This plugin wants to access serendipity_event_emoticate. Its methods are non-static
                    // and it's not properly working with PHP5 to call. So to perform properly, let's take
                    // the actual plugin:
                    $plugins = serendipity_plugin_api::get_event_plugins();
                    $emoticate_plugin = null;
                    while(list($plugin, $plugin_data) = each($plugins)) {
                        if (strpos($plugin, 'serendipity_event_emoticate') !== FALSE) {
                            $emoticate_plugin =& $plugin_data['p'];
                            break;
                        }
                    }

                    if ($emoticate_plugin === null) {
                        return;
                    }

                    $emoticons = $emoticate_plugin->getEmoticons();
                    $unique = array();
                    foreach($emoticons as $key => $value) {
                        if (is_callable(array($emoticate_plugin, 'humanReadableEmoticon'))) {
                            $key = $emoticate_plugin->humanReadableEmoticon($key);
                        }
                        $unique[$value] = $key;
                    }
?>
<div class="serendipity_emoticon_bar">
    <script type="text/javascript">
        emoticonchooser('<?php echo $func; ?>', '<?php echo $txtarea; ?>', '<?php echo $cke_txtarea; ?>');
    </script>

<?php
                    echo $popuplink."\n";
                    echo '    <div id="serendipity_emoticonchooser_' . $func . '" style="' . $style . $popupstyle . '">'."\n";
                    foreach($unique as $value => $key) {
                        echo '        <a href="javascript:use_emoticon_' . $func . '(\'' . addslashes($key) . '\')" title="' . $key . '"><img src="'. $value .'" style="border: 0px" alt="' . $key . '" /></a>&nbsp;'."\n";
                        if ($i++ % 10 == 0) {
                            echo "        <br />\n";
                        }
                    }
                    echo '    </div>'."\n";
                    echo '</div>'."\n";

                    return true;
                    break;

                case 'backend_header':
                case 'frontend_header':
?>
    <script language="javascript" type="text/javascript" src="<?php echo $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_emoticonchooser/emoticonchooser.js'; ?>"></script>
<?php
                    return true;
                    break;

                case 'css_backend':
?>
.serendipity_toggle_emoticon_bar.serendipityPrettyButton {
    display: inline-block;
    margin: 0 auto 1px;
}
.serendipity_emoticon_bar {
    margin: 3px auto 0;
    text-align: right;
}
<?php
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
?>
