<?php # 

// TODO:
// Show existing references for insertion in 'Extended options' panel for 'edit entry' screen
// Test smarty output

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_wikilinks extends serendipity_event
{
    var $title = PLUGIN_EVENT_WIKILINKS_NAME;
    var $references = array();
    var $out_references = array();

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_WIKILINKS_NAME);
        $propbag->add('description',   PLUGIN_EVENT_WIKILINKS_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Grischa Brockhaus');
        $propbag->add('version',       '0.25');
        $propbag->add('requirements',  array(
            'serendipity' => '1.0',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('MARKUP'));
        $propbag->add('event_hooks',   array(
            'frontend_display' => true,
            'backend_entry_toolbar_extended' => true,
            'backend_entry_toolbar_body' => true,
            'external_plugin' => true,
            'backend_publish' => true,
            'backend_save' => true,
            'backend_sidebar_entries_event_display_wikireferences' => true,
            'backend_sidebar_entries' => true,
        ));

        $this->markup_elements = array(
            array(
              'name'     => 'ENTRY_BODY',
              'element'  => 'body',
            ),
            array(
              'name'     => 'EXTENDED_BODY',
              'element'  => 'extended',
            ),
            array(
              'name'     => 'COMMENT',
              'element'  => 'comment',
            ),
            array(
              'name'     => 'HTML_NUGGET',
              'element'  => 'html_nugget',
            )
        );

        $conf_array = array();
        foreach($this->markup_elements as $element) {
            $conf_array[] = $element['name'];
        }
        $conf_array[] = 'imgpath';
        $conf_array[] = 'generate_draft_links';
        $conf_array[] = 'generate_future_links';
        $conf_array[] = 'reference_match';
        $conf_array[] = 'reference_info';
        $conf_array[] = 'target_match';
        $conf_array[] = 'target_match2';
        $propbag->add('configuration', $conf_array);
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch($name) {
            case 'imgpath':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_WIKILINKS_IMGPATH);
                $propbag->add('description', PLUGIN_EVENT_WIKILINKS_IMGPATH_DESC);
                $propbag->add('default',     $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_wikilinks/');
                break;

            case 'generate_draft_links':
                $propbag->add('name',        PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_NAME);
                $propbag->add('description', PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_DESC);
                $propbag->add('type',        'boolean');
                $propbag->add('default', 'true');
                break;

            case 'generate_future_links':
                $propbag->add('name',        PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_NAME);
                $propbag->add('description', PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_DESK);
                $propbag->add('type',        'boolean');
                $propbag->add('default', 'true');
                break;

            case 'reference_match':
                $propbag->add('name',        PLUGIN_EVENT_WIKILINKS_REFMATCH_NAME);
                $propbag->add('description', PLUGIN_EVENT_WIKILINKS_REFMATCH_DESC);
                $propbag->add('type',        'string');
                $propbag->add('default', '<ref(?:\s*name=["\'](?P<refname>.+)["\'])?>(?P<ref>.*)</ref>');
                break;

            case 'target_match':
                $propbag->add('name',        PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET_NAME);
                $propbag->add('description', PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET_DESC);
                $propbag->add('type',        'string');
                $propbag->add('default', '<sup class="wikiref"><a href="#reference{count}" title="{text}">{count}</a></sup>');
                break;

            case 'target_match2':
                $propbag->add('name',        PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET2_NAME);
                $propbag->add('description', PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET2_DESC);
                $propbag->add('type',        'string');
                $propbag->add('default', '<li id="reference{count}" title="{refname}">{text}</li>');
                break;

            case 'reference_info':
                $propbag->add('name',        PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET2_NAME);
                $propbag->add('description', PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET2_DESC);
                $propbag->add('type',        'content');
                $propbag->add('default', PLUGIN_EVENT_WIKILINKS_REFDOC);
                break;

            case 'db_built':
                return false;

            default:
                $propbag->add('type',        'boolean');
                $propbag->add('name',        @constant($name));
                $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
                $propbag->add('default', 'true');
        }
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
            
                case 'backend_publish':
                case 'backend_save':
                    // Purge, so that the data within the entry takes precedence over other changes
                    serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}wikireferences WHERE entryid = " . (int)$eventData['id']);
                    break;

                case 'backend_sidebar_entries':
                    $this->setupDB();
                    echo '<li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=wikireferences">' . PLUGIN_EVENT_WIKILINKS_MAINT . '</a></li>';
                    break;

                case 'backend_sidebar_entries_event_display_wikireferences':
                    $entries = serendipity_db_query("SELECT id, refname FROM {$serendipity['dbPrefix']}wikireferences ORDER BY refname ASC");

                    echo '<p>' . PLUGIN_EVENT_WIKILINKS_MAINT_DESC . '</p>';

                    echo '<form action="serendipity_admin.php" method="post" name="serendipityEntry">';
                    echo '<input type="hidden" name="serendipity[adminModule]" value="event_display" />';
                    echo '<input type="hidden" name="serendipity[adminAction]" value="wikireferences" />';
                    echo '<select name="serendipity[wikireference]">';
                    echo '<option value="">...</option>';
                    foreach((array)$entries AS $idx => $row) {
                        echo '<option value="' . $row['id'] . '" ' . ($row['id'] == $serendipity['POST']['wikireference'] ? 'selected="selected"' : '') . '>' . $row['refname'] . '</option>' . "\n";
                    }
                    echo '</select>';
                    echo '<input type="submit" class="serendipityPrettyButton input_button" name="serendipity[typeSubmit]" value="' . GO . '" />';
                    echo '<br /><br />';

                    if ($serendipity['POST']['wikireference'] > 0) {

                        if ($serendipity['POST']['saveSubmit']) {
                            serendipity_db_update('wikireferences', array('id' => $serendipity['POST']['wikireference']), array('refname' => $serendipity['POST']['wikireference_refname'], 'ref' => $serendipity['POST']['wikireference_ref']));
                            echo '<div class="serendipityAdminMsgSuccess"><img style="height: 22px; width: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_success.png') . '" alt="" />' . DONE .': '. sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%H:%M:%S')) . '</div>';
                        }

                        $ref = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}wikireferences WHERE id = " . (int)$serendipity['POST']['wikireference'], true, 'assoc');
                        $entry = serendipity_fetchEntry('id', $ref['entryid']);

                        echo '<div>';
                        echo '<label>' . PLUGIN_EVENT_WIKILINKS_DB_REFNAME . '</label><br />';
                        echo '<input type="text" name="serendipity[wikireference_refname]" value="' . htmlspecialchars($ref['refname']) . '" />';
                        echo '<input type="submit" class="serendipityPrettyButton input_button" name="serendipity[saveSubmit]" value="' . SAVE . '" />';
                        echo '</div>';

                        echo '<div>';
                        echo '<label>' . PLUGIN_EVENT_WIKILINKS_DB_REF . '</label><br />';
                        echo '<textarea cols="80" rows="20" name="serendipity[wikireference_ref]">' . htmlspecialchars($ref['ref']) . '</textarea>';
                        echo '</div>';

                        echo '<div>';
                        echo '<label>' . PLUGIN_EVENT_WIKILINKS_DB_ENTRYDID . '</label>';
                        echo '<a href="' . serendipity_archiveUrl($ref['entryid'], $entry['title']) . '">' . $entry['title'] . '</a>';
                        echo '<p><a class="serendipityPrettyButton" href="?serendipity[action]=admin&amp;serendipity[adminModule]=entries&amp;serendipity[adminAction]=edit&amp;serendipity[id]=' . $entry['id'] . '">' . EDIT_ENTRY . '</a></p>';

                        echo '</div>';
                    }
                    echo '</form>';

                    break;

                case 'frontend_display':
                    $this->out_references = array();
                    foreach ($this->markup_elements as $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], true)) && isset($eventData[$temp['element']]) &&
                            !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                            !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];

                            $is_body = false;
                            if ($element == 'body' || $element == 'extended') {
                                $source =& $this->getFieldReference($element, $eventData);
                                if ($source === '') {
                                    // Prevent bug from serendipity 0.9
                                    $source =& $eventData[$element];
                                }
                                $is_body = true;
                            } else {
                                $source =& $eventData[$element];
                            }
                            
                            $this->references = $this->refcount = array();
                            $this->ref_entry = $eventData['id'];
                            $source = preg_replace_callback(
                                '^' . $this->get_config('reference_match') . '^imsU',
                                array($this, '_reference'),
                                $source
                            );

                            $source = preg_replace_callback(
                                "#(\[\[|\(\(|\{\{)(.+)(\]\]|\)\)|\}\})#isUm",
                                array($this, '_wikify'),
                                $source
                            );
                            
                            $source .= $this->reference_parse();
                            if ($is_body) {
                                if (!is_array($eventData['properties']['references'])) $eventData['properties']['references'] = array();
                                $eventData['properties']['references'] += $this->references;
                            }
                        }
                    }

                    return true;
                    break;

                case 'external_plugin':
                    $what = '';
                    if ($eventData == 'popup_choose_entry') {
                        $what = 'body';
                    } elseif ($eventData == 'popup_choose_entrybody') {
                        $what = 'body';
                    } elseif ($eventData == 'popup_choose_entryextended') {
                        $what = 'extended';
                    } elseif (preg_match('/^popup_choose_entry(.*)$/i', $eventData, $matches)) {
                        // get the custom thing that is to be selected, for example a nugget
                        $what = $matches[1];
                    }

                    if (empty($what)) {
                        return false;
                    }


?>
<html>
    <head>
        <title><?php echo PLUGIN_EVENT_WIKILINKS_LINKENTRY; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo LANG_CHARSET; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo 'serendipity.css.php?serendipity[css_mode]=serendipity_admin.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo serendipity_getTemplateFile('admin/pluginmanager.css'); ?>" />
    </head>

<body id="serendipity_admin_page">
<div id="serendipityAdminFrame">
    <div id="serendipityAdminBanner">
        <h1><?php echo SERENDIPITY_ADMIN_SUITE; ?></h1>
        <h2><?php echo PLUGIN_EVENT_WIKILINKS_LINKENTRY_DESC; ?></h2>
    </div>
    <div id="serendipityAdminContent">

        <ul>
<?php
    $sql = "SELECT *
              FROM {$serendipity['dbPrefix']}entries
          ORDER BY timestamp DESC";
    $e = serendipity_db_query($sql);
    if (is_array($e)) {
        foreach($e AS $entry) {
            $link = serendipity_archiveURL($entry['id'], $entry['title'], 'serendipityHTTPPath', true, array('timestamp' => $entry['timestamp']));
            $jslink = "'<a href=\'$link\'>" . htmlspecialchars($entry['title']) . "<' + '/a>'";
            echo '<li style="margin-bottom: 10px">'
               . '<a href="javascript:parent.self.opener.use_link_' . $what . '(' . $jslink . '); self.close();" title="' . htmlspecialchars($entry['title']) . '"><strong>' . htmlspecialchars($entry['title']) . '</strong></a> (<a href="' . $link . '" title="' . htmlspecialchars($entry['title']) . '">#' . $entry['id'] . '</a>)<br />'
               . POSTED_BY . ' ' . $entry['author'] . ' '
               . ON . ' ' . serendipity_formatTime(DATE_FORMAT_SHORT, $entry['timestamp']) .
               ($entry['isdraft'] != 'false' ? ' (' . DRAFT . ')' : '') . '</a></li>' . "\n";
        }
    }
?>
        </ul>
    </div>
</div>
</body>
</html>
<?php
                    return true;

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

                    // CKEDITOR needs this little switch
                    if (preg_match('@^nugget@i', $func)) {
                        $cke_txtarea = $func;
                    } else {
                        $cke_txtarea = $txtarea;
                    }

                    if (!isset($popcl)) {
                        $popcl = ' serendipityPrettyButton';
                    }

                    if (!isset($style)) {
                        $style = 'text-align: right; margin-top: 5px';
                    }
?>
<script type="text/javascript">
<!--
function use_link_<?php echo $func; ?>(txt) {

    // use the shared insert function instead of the wikilinks provided function
    // the shared JS function implements all the wikilinks functionality + NO WYSIWYG insertion
    serendipity_imageSelector_addToBody(txt, '<?php echo $func; ?>' );
    return;

    if(typeof(CKEDITOR) != 'undefined') {
        var oEditor = CKEDITOR.instances['<?php echo $cke_txtarea; ?>'];
        oEditor.insertHtml(txt);
    } else if(typeof(FCKeditorAPI) != 'undefined') {
        var oEditor = FCKeditorAPI.GetInstance('<?php echo $txtarea; ?>') ;
        oEditor.InsertHtml(txt);
    } else if(typeof(xinha_editors) != 'undefined') {
        if(typeof(xinha_editors['<?php echo $txtarea; ?>']) != 'undefined') {
            // this is good for the two default editors (body & extended)
            xinha_editors['<?php echo $txtarea; ?>'].insertHTML(txt);
        } else if(typeof(xinha_editors['<?php echo $func; ?>']) != 'undefined') {
            // this should work in any other cases than previous one
            xinha_editors['<?php echo $func; ?>'].insertHTML(txt);
        } else {
            // this is the last chance to retrieve the instance of the editor !
            // editor has not been registered by the name of it's textarea
            // so we must iterate over editors to find the good one
            for (var editorName in xinha_editors) {
                if('<?php echo $txtarea; ?>' == xinha_editors[editorName]._textArea.name) {
                    xinha_editors[editorName].insertHTML(txt);
                    return;
                }
            }
            // not found ?!?
        }
    } else if(typeof(HTMLArea) != 'undefined') {
        if(typeof(editor<?php echo $func; ?>) != 'undefined')
            editor<?php echo $func; ?>.insertHTML(txt);
        else if(typeof(htmlarea_editors) != 'undefined' && typeof(htmlarea_editors['<?php echo $func; ?>']) != 'undefined')
            htmlarea_editors['<?php echo $func; ?>'].insertHTML(txt);
    } else if(typeof(TinyMCE) != 'undefined') {
        //tinyMCE.execCommand('mceInsertContent', false, txt);
        tinyMCE.execInstanceCommand('<?php echo $txtarea; ?>', 'mceInsertContent', false, txt);
    } else  {
        // default case: no wysiwyg editor
        txtarea = document.getElementById('<?php echo $txtarea; ?>');
        if (txtarea.createTextRange && txtarea.caretPos) {
            caretPos = txtarea.caretPos;
            caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + ' ' + txt + ' ' : caretPos.text + ' ' + txt + ' ';
        } else {
            txtarea.value  += ' ' + txt + ' ';
        }

        // alert(obj);
        txtarea.focus();
    }
}
//-->
</script>
<?php
                    echo '<input type="button" class="serendipityPrettyButton input_button" onclick="entrypopup = window.open(\'' . $serendipity['baseURL'] . $serendipity['indexFile'] . '?/plugin/popup_choose_entry' . $func . '\', \'js_entrypopup\', \'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1\')" value="' . PLUGIN_EVENT_WIKILINKS_LINKENTRY . '" />';
                    return true;

                default:
                    return false;
            }

        } else {
            return false;
        }
    }

    function install() {
        $this->setupDB();
    }

    function setupDB() {
        global $serendipity;

        $built = $this->get_config('db_built', null);
        if (empty($built)) {
            serendipity_db_schema_import("CREATE TABLE {$serendipity['dbPrefix']}wikireferences (
                    id {AUTOINCREMENT} {PRIMARY},
                    entryid int(11) default '0',
                    refname text,
                    ref text)");
            serendipity_db_schema_import("CREATE INDEX wikiref_refname ON {$serendipity['dbPrefix']}wikireferences (refname(200));");
            serendipity_db_schema_import("CREATE INDEX wikiref_comb ON {$serendipity['dbPrefix']}wikireferences (entryid,refname(200));");
            serendipity_db_schema_import("CREATE INDEX wikiref_entry ON {$serendipity['dbPrefix']}wikireferences (entryid);");
            $this->set_config('db_built', 1);
        }
    }

    function _reference($buffer) {
        global $serendipity;
        static $count = 0;

        $count++;

        if (!empty($buffer['ref']) && !empty($buffer['refname']) && !empty($this->ref_entry)) {
            // New refname, needs to be stored in the database IF NOT CURRENTLY EXISTING
            $exists = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}wikireferences WHERE refname = '" . serendipity_db_escape_string($buffer['refname']) . "'", true, 'assoc');

            if ($exists['entryid'] == $this->ref_entry) {
                #serendipity_db_update('wikireferences', array('entryid' => $this->ref_entry, 'refname' => $buffer['refname']), array('ref' => $buffer['ref']));
            } elseif (empty($exists['entryid'])) {
                serendipity_db_insert('wikireferences', array('entryid' => $this->ref_entry, 'refname' => $buffer['refname'], 'ref' => $buffer['ref']));
            }
        }

        if (empty($buffer['ref']) && !empty($buffer['refname'])) {
            // We found a referenced pattern like <ref name="XXX" />, so let's fetch that from the database!
            $exists = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}wikireferences WHERE refname = '" . serendipity_db_escape_string($buffer['refname']) . "'", true, 'assoc');

            $buffer['ref'] = $exists['ref'];
        }

        if (empty($buffer['refname'])) {
            $buffer['refname'] = $count;
        }

        $refix = $count;
        if (isset($this->references[$buffer['refname']])) {
            if ($this->references[$buffer['refname']] == $buffer['ref']) {
                $refix = $this->refcount[$buffer['refname']];
            } else {
                $this->references[$buffer['refname'] . $count] = $buffer['ref'];
                $this->refcount[$buffer['refname'] . $count] = $count;
            }
        } else {
            $this->references[$buffer['refname']] = $buffer['ref'];
            $this->refcount[$buffer['refname']] = $count;
        }

        $result = $this->get_config('target_match');
        $result = str_replace(
            array(
                '{count}',
                '{text}',
                '{refname}'
            ),

            array(
                $refix,
                htmlspecialchars($buffer['ref']),
                htmlspecialchars($buffer['refname']),
            ),
            $result
        );

        return $result;
    }

    function reference_parse() {
        global $serendipity;
        static $count = 0;
        static $count2 = 0;

        $count++;

        $format =  $this->get_config('target_match2');

        if ($format == '-') return;
        if (count($this->references) == 0) return;

        $block = "\n\n" . '<ol class="serendipity_referencelist" id="serendipity_referencelist' . $count . '">' . "\n";

        foreach($this->references AS $key => $buffer) {
            $count2++;
            $result = str_replace(
                array(
                    '{count}',
                    '{text}',
                    '{refname}'
                ),

                array(
                    $count2,
                    htmlspecialchars($buffer),
                    $key
                ),
                $format
            );

            $block .= $result . "\n";
        }

        $block .= '</ol>' . "\n";

        return $block;
    }

    /**
    * Wikifies:
    * [[ENTRY|DESC]] is an internal link
    * ((ENTRY|DESC)) is a staticpage link.
    */
    function _wikify($buffer) {
        global $serendipity;
        $debug = true;

        $admin_url = false;
        
        $cidx = 2;

        if ($buffer[1] == '((') {
            $type = $otype = 'staticpage';
        } elseif ($buffer[1] == '{{') {
            $type = $otype = 'mixed';
        } else {
            $type = $otype = 'internal';
        }

        $parts = explode('|', $buffer[$cidx]);

        if (isset($parts[1])) {
            $desc   = $parts[1];
            $ltitle = $parts[0];
        } else {
            $desc = $ltitle = $buffer[$cidx];
        }
        // ltitle might contain entities, convert them:
        $ltitle = @html_entity_decode($ltitle, ENT_COMPAT, LANG_CHARSET);

        $sql = '';
        if ($type == 'staticpage') {
            $entry = serendipity_db_query("SELECT id, permalink FROM {$serendipity['dbPrefix']}staticpages WHERE headline = '" . serendipity_db_escape_string($ltitle) . "'" . " ORDER BY timestamp DESC LIMIT 1", true, 'assoc');
        } elseif ($type == 'mixed') {
            $entry = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}entries WHERE title = '" . serendipity_db_escape_string($ltitle) . "'" . " ORDER BY timestamp DESC LIMIT 1", true, 'assoc');
            $type = 'internal';
            if (!is_array($entry)) {
                $entry = serendipity_db_query("SELECT id, permalink FROM {$serendipity['dbPrefix']}staticpages WHERE headline = '" . serendipity_db_escape_string($ltitle) . "'" . " ORDER BY timestamp DESC LIMIT 1", true, 'assoc');
                $type = 'staticpage';
            }
        } else {
            $entry = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}entries WHERE title = '" . serendipity_db_escape_string($ltitle) . "'" . " ORDER BY timestamp DESC LIMIT 1", true, 'assoc');
        }

        if (is_array($entry)) { // The entry exists.
            
            // check, wether we don't want draft or future links:
            //if (serendipity_db_bool($this->get_config('generate_draft_links', false)) ||  !$entry['isdraft']){
            if (serendipity_db_bool($this->get_config('generate_future_links', false)) ||  $entry['timestamp']<=serendipity_db_time()){
                if ($type == 'staticpage') {
                    $entry_url = $entry['permalink'];
                } else {
                    $entry_url = serendipity_archiveURL($entry['id'], $entry['title'], 'serendipityHTTPPath', true, array('timestamp' => $entry['timestamp']));
                }               
            }
            if (serendipity_userLoggedIn()) {
                $mode = 'edit';
                if ($type == 'staticpage') {
                    $admin_url   = $serendipity['baseURL'] .'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticid]='. $entry['id'];
                    $admin_title = PLUGIN_EVENT_WIKILINKS_EDIT_STATICPAGE;
                } else {
                    $admin_url = $serendipity['baseURL'] .'serendipity_admin.php?serendipity[action]=admin&amp;serendipity[adminModule]=entries&amp;serendipity[adminAction]=edit&amp;serendipity[id]='. $entry['id'];
                    $admin_title = PLUGIN_EVENT_WIKILINKS_EDIT_INTERNAL;
                }
            }
        } else {
            // The entry does not yet exist.
            $entry_url = '';

            if (serendipity_userLoggedIn()) {
                $mode  = 'create';
                $title = urlencode($ltitle);
                $body  = '<h1>' . htmlspecialchars($ltitle) . '</h1>';

                $admin_url2 = $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[pre][headline]=' . $title . '&amp;serendipity[pre][content]=' . $body . '&amp;serendipity[pre][pagetitle]=' . $title;
                if ($otype == 'staticpage') {
                    $admin_url = $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pages&amp;serendipity[pre][headline]=' . $title . '&amp;serendipity[pre][content]=' . $body . '&amp;serendipity[pre][pagetitle]=' . $title;
                    $admin_title = PLUGIN_EVENT_WIKILINKS_CREATE_STATICPAGE;
                } elseif ($otype == 'mixed') {
                    $admin_url = $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=entries&amp;serendipity[adminAction]=new&amp;serendipity[title]=' . $title . '&amp;serendipity[body]=' . $body;
                    $admin_title = PLUGIN_EVENT_WIKILINKS_CREATE_INTERNAL;
                } else {
                    $admin_url = $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=entries&amp;serendipity[adminAction]=new&amp;serendipity[title]=' . $title . '&amp;serendipity[body]=' . $body;
                    $admin_title = PLUGIN_EVENT_WIKILINKS_CREATE_INTERNAL;
                }
            } else {
                $ltitle .= '?';
            }
        }

        $out = '<span class="serendipity_wikilink_' . $type . '">';
        if ($entry_url) {
            $out .= '<a class="serendipity_wikilink_visitor" href="' . $entry_url . '">';
        }
        $out .= $desc;
        if ($entry_url) {
            $out .= '</a>';
        }

        if ($admin_url) {
            if ($otype == 'mixed') {
                $imgurl = $this->get_config('imgpath') . $mode . '_internal.png';
                $img1   = '<img style="border: 0px" alt="?" src="' . $imgurl . '" width="16" height="16" />';
                $out .= '<a title="' . $admin_title . '" class="serendipity_wikilink_editor_internal" href="' . $admin_url . '">' . $img1 . '</a>';
                if ($admin_url2) {
                    $imgurl = $this->get_config('imgpath') . $mode . '_staticpage.png';
                    $img2 = '<img style="border: 0px" alt="?" src="' . $imgurl . '" width="16" height="16" />';
                    $out .= '<a title="' . PLUGIN_EVENT_WIKILINKS_CREATE_STATICPAGE . '" class="serendipity_wikilink_editor_staticpage" href="' . $admin_url2 . '">' . $img2 . '</a>';
                }
            } else {
                $imgurl = $this->get_config('imgpath') . $mode . '_' . $type . '.png';
                $img = '<img style="border: 0px" alt="?" src="' . $imgurl . '" width="16" height="16" />';
                $out .= '<a title="' . $admin_title . '" class="serendipity_wikilink_editor_' . $type . '" href="' . $admin_url . '">' . $img . '</a>';
            }
        }
        $out .= '</span>';

        return $out;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
