<?php

/**
 * Abstract class for showForm methods
 * As of now we are able to include this only once (by form) outside the foreach config item loop
 * and run each inspectConfig item switch in a separate class
 */
abstract class inspectConfig extends serendipity_event_faq
{
    public function showFAQForm(){}
    public function showCategoryForm(){}
}

class icSeparator extends inspectConfig
{
    protected function icSeparator()
    {
        return;//void
    }
}

class icSelect extends inspectConfig
{
    protected function icSelect()
    {
        global $inspectConfig;

        $select = $inspectConfig['select_values'];
?>

        <div id="item_config_select" class="form_field clear">
            <label for="<?php echo $inspectConfig['cname']; ?><?php echo $inspectConfig['elcount']; ?>"><?php echo $inspectConfig['cname']; ?></label>

<?php
        if ($inspectConfig['cdesc'] != '') {
?>
            <span class="title_descriptor"><span style="color: #5E7A94; font-size: 8pt;">&nbsp;<?php echo $inspectConfig['cdesc']; ?></span></span>
<?php
        }
?>

            <div class="action_field">

                <select id="<?php echo $inspectConfig['cname']; ?><?php echo $inspectConfig['elcount']; ?>" class="direction_<?php echo $inspectConfig['lang_direction']; ?>" name="serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]">
<?php
        foreach($select AS $select_value => $select_desc) {
            $id = function_exists('serendipity_specialchars') ? serendipity_specialchars($inspectConfig['config_item'] . $select_value) : htmlspecialchars($inspectConfig['config_item'] . $select_value, ENT_COMPAT, LANG_CHARSET);
?>
                    <option value="<?php echo $select_value; ?>"<?php echo ($select_value == $inspectConfig['hvalue'] ? ' selected="selected"' : ''); ?> title="<?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($select_desc) : htmlspecialchars($select_desc, ENT_COMPAT, LANG_CHARSET)); ?>">
                        <?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($select_desc) : htmlspecialchars($select_desc, ENT_COMPAT, LANG_CHARSET))."\n"; ?>
                    </option>
<?php
        }
?>
                </select>

            </div>
        </div>

<?php
    }
}

class icTristate extends inspectConfig
{
    protected function icTristate()
    {
        global $inspectConfig;

        $inspectConfig['per_row'] = 3;
        $inspectConfig['radio']['value'][] = 'default';
        $inspectConfig['radio']['desc'][]  = USE_DEFAULT;
        // return fall through
    }
}

class icBoolean extends inspectConfig
{
    protected function icBoolean()
    {
        global $inspectConfig;

        $inspectConfig['radio']['value'][] = 'true';
        $inspectConfig['radio']['desc'][]  = YES;

        $inspectConfig['radio']['value'][] = 'false';
        $inspectConfig['radio']['desc'][]  = NO;
        // return fall through
    }
}

class icRadio extends inspectConfig
{
    /**
     * Radio form field generator. May have pre set dependencies in tristate and boolean.
     */
    protected function icRadio()
    {
        global $inspectConfig;

        if (!count($inspectConfig['radio']) > 0) {
            $radio = $inspectConfig['radio'];
        }

        if (empty($inspectConfig['per_row'])) {
            $per_row = $inspectConfig['radio_per_row'];
            if (empty($per_row)) {
                $per_row = 2;
            }
        }
?>

        <label for="<?php echo $inspectConfig['cname']; ?><?php echo $inspectConfig['elcount']; ?>"><?php echo $inspectConfig['cname']; ?></label>

<?php
        if ($inspectConfig['cdesc'] != '') {
?>
        <span class="title_descriptor"><span style="color: #5E7A94; font-size: 8pt;">&nbsp;<?php echo $inspectConfig['cdesc']; ?></span></span>
<?php
        }
?>

        <div id="item_config_radio" class="form_field clear action_field">

<?php
        $counter = 0;
        foreach($radio['value'] AS $radio_index => $radio_value) {
            $id = (function_exists('serendipity_specialchars') ? serendipity_specialchars($inspectConfig['config_item'] . $radio_value) : htmlspecialchars($inspectConfig['config_item'] . $radio_value, ENT_COMPAT, LANG_CHARSET));
            $counter++;
            $checked = "";

            if ($radio_value == 'true' && ($inspectConfig['hvalue'] === '1' || $inspectConfig['hvalue'] === 'true')) {
                $checked = " checked";
            } elseif ($radio_value == 'false' && ($inspectConfig['hvalue'] === '' || $inspectConfig['hvalue'] ==='0' || $inspectConfig['hvalue'] === 'false')) {
                $checked = " checked";
            } elseif ($radio_value == $inspectConfig['hvalue']) {
                $checked = " checked";
            }

            if ($counter == 1) {
?>
            <div class="radio_field">
<?php
            }
?>
                <input class="direction_<?php echo $inspectConfig['lang_direction']; ?> input_radio" type="radio" id="serendipity_plugin_<?php echo $id; ?>" name="serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]" value="<?php echo $radio_value; ?>" <?php echo $checked ?> title="<?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($radio['desc'][$radio_index]) : htmlspecialchars($radio['desc'][$radio_index], ENT_COMPAT, LANG_CHARSET)); ?>" />
                <label for="serendipity_plugin_<?php echo $id; ?>"><?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($radio['desc'][$radio_index]) : htmlspecialchars($radio['desc'][$radio_index], ENT_COMPAT, LANG_CHARSET)); ?></label>
<?php
            if ($counter == $per_row) {
                $counter = 0;
?>
            </div>
<?php
            }
        }
?>

        </div>

<?php
    }
}

class icString extends inspectConfig
{
    protected function icString()
    {
        global $inspectConfig;
?>

        <div class="form_field clear text_field">
            <label for="<?php echo $inspectConfig['cname']; ?><?php echo $inspectConfig['elcount']; ?>"><?php echo $inspectConfig['cname']; ?></label>
            <span class="title_descriptor"><span style="color: #5E7A94; font-size: 8pt;">&nbsp;<?php echo $inspectConfig['cdesc']; ?></span></span>
        </div>

        <div class="form_field clear action_field">
            <input id="<?php echo $inspectConfig['cname']; ?><?php echo $inspectConfig['elcount']; ?>" class="direction_<?php echo $inspectConfig['lang_direction']; ?> input_field" type="text" name="serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]" value="<?php echo $inspectConfig['hvalue']; ?>" size="30" />
        </div>

<?php
    }
}

class icText extends inspectConfig
{
    protected function icText()
    {
        global $inspectConfig;

        if (!$inspectConfig['s9y']['wysiwyg']) {
?>

        <div class="form_field clear text_field">
            <label for="<?php echo $inspectConfig['cname']; ?><?php echo $inspectConfig['elcount']; ?>"><?php echo $inspectConfig['cname']; ?></label>
            <span class="title_descriptor">&nbsp;<span style="color: #5E7A94; font-size: 8pt;">&nbsp;<?php echo $inspectConfig['cdesc']; ?></span></span>
        </div>

        <div class="form_editor">
<?php
            if ($inspectConfig['s9y']['version'] < 2) {
?>
            <div class="form_field clear plain_editor">

            <nobr><span id="tools_<?php echo $inspectConfig['config_item'] ?>" class="editor_toolbar" style="display: none">
            <?php if ( $inspectConfig['s9y']['nl2br']['iso2br'] ) { ?>
                <input type="button" class="serendipityPrettyButton input_button" name="insX" value="NoBR" accesskey="x" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" data-tag="nl" style="font-style: italic" onclick="wrapSelection(document.forms['serendipityEntry']['serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]'],'<nl>','</nl>')" />
            <?php } ?>
                <input type="button" class="serendipityPrettyButton input_button wrap_selection" name="insI" value="I" accesskey="i" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" data-tag="em" style="font-style: italic" onclick="wrapSelection(document.forms['serendipityEntry']['serendipity[plugin][<?php echo $inspectConfig['config_item'] ?>]'],'<em>','</em>')" />
                <input type="button" class="serendipityPrettyButton input_button wrap_selection" name="insB" value="B" accesskey="b" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" data-tag="strong" style="font-weight: bold" onclick="wrapSelection(document.forms['serendipityEntry']['serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]'],'<strong>','</strong>')" />
                <input type="button" class="serendipityPrettyButton input_button wrap_selection" name="insU" value="U" accesskey="u" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" data-tag="u" style="text-decoration: underline;" onclick="wrapSelection(document.forms['serendipityEntry']['serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]'],'<u>','</u>')" />
                <input type="button" class="serendipityPrettyButton input_button wrap_selection" name="insQ" value="<?php echo QUOTE ?>" accesskey="q" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" data-tag="blockquote" style="font-style: italic" onclick="wrapSelection(document.forms['serendipityEntry']['serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]'],'<blockquote>','</blockquote>')" />
                <input type="button" class="serendipityPrettyButton input_button wrap_insimg" name="insJ" value="img" accesskey="j" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" onclick="wrapInsImage(document.forms['serendipityEntry']['serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]'])" />
                <input type="button" class="serendipityPrettyButton input_button wrap_insmedia" name="insImage" value="<?php echo MEDIA; ?>" style="" onclick="window.open('serendipity_admin_image_selector.php?serendipity[textarea]=<?php echo urlencode('serendipity[plugin]['.$inspectConfig['config_item'].']'); ?>', 'ImageSel', 'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1');" />
                <input type="button" class="serendipityPrettyButton input_button wrap_insurl" name="insU" value="URL" accesskey="l" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" onclick="wrapSelectionWithLink(document.forms['serendipityEntry']['serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]'])" />
            </span></nobr>

            <script type="text/javascript" src="<?php echo $inspectConfig['s9y']['plugin_path']; ?>jquery.serendipity_old_plain_editor.js"></script>
<?php
                } else {
?>
            <div class="form_field clear plain_editor">

            <nobr><span id="tools_<?php echo $inspectConfig['config_item']; ?>" class="editor_toolbar" style="display: none">
            <?php if ( $inspectConfig['s9y']['nl2br']['iso2br'] ) { ?>
                <button class="wrap_selection lang-html" type="button" name="insX" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" data-tag-open="nl" data-tag-close="nl">NoBR</button>
            <?php } ?>
                <button class="hilite_i wrap_selection lang-html" type="button" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" data-tag-open="em" data-tag-close="em" name="insI">i</button>
                <button class="hilite_b wrap_selection lang-html" type="button" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" data-tag-open="strong" data-tag-close="strong" name="insB">b</button>
                <button class="wrap_selection lang-html" type="button" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" data-tag-open="blockquote" data-tag-close="blockquote" name="insQ"><?php echo QUOTE ?></button>
                <button class="wrap_insimg" type="button" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" name="insJ">img</button>
                <button class="wrap_insmedia" type="button" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" name="insImage"><?php echo MEDIA ?></button>
                <button class="wrap_insurl" type="button" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" name="insURL">URL</button>
            </span></nobr>
<?php
            }
?>

            <script type="text/javascript">
                var tb_<?php echo $inspectConfig['config_item']; ?> = document.getElementById('tools_<?php echo $inspectConfig['config_item']; ?>');
                    tb_<?php echo $inspectConfig['config_item']; ?>.style.display = '';
            </script>

<?php

            // add extra data into the entry's array so that the emoticonchooser plugin
            // behaves well with WYSIWYG-editors, then clean up ;-) (same applies below)
            $entry['backend_entry_toolbar_body:nugget'] = 'nuggets' . $inspectConfig['elcount'];
            $entry['backend_entry_toolbar_body:textarea'] = 'serendipity[plugin]['.$inspectConfig['config_item'].']';
            echo "            <div class=\"hook_buttons\">\n\n"; // append inlined

            serendipity_plugin_api::hook_event('backend_entry_toolbar_body', $entry); // add hooked buttons

            echo "\n            </div>\n\n";
            echo "        </div>\n"; // close the plain_editor box
?>

        </div><!-- form_editor end -->

<?php
            $tdimension = $inspectConfig['config_item'] == 'question' ? ' rows="5" cols="80"' : ' rows="20" cols="80"';
        } else { // case WYSIWYG EDITOR
            $tdimension = ' rows="10" cols="80"';
            if ($inspectConfig['s9y']['version'] > 1) {
                serendipity_emit_htmlarea_code("nuggets{$inspectConfig['elcount']}","");
            }
            $entry['backend_entry_toolbar_body:nugget'] = 'nuggets' . $inspectConfig['elcount'];
            $entry['backend_entry_toolbar_body:textarea'] = 'serendipity[plugin]['.$inspectConfig['config_item'].']';
?>

        <div class="form_field clear text_field">
            <label for="nuggets<?php echo $inspectConfig['elcount']; ?>"><?php echo $inspectConfig['cname']; ?></label>
            <span class="title_descriptor">&nbsp;<span style="color: #5E7A94; font-size: 8pt;">&nbsp;<?php echo $inspectConfig['cdesc']; ?></span></span>
        </div>

        <div class="form_field clear plain_editor">

<?php
            echo "            <div class=\"hook_buttons\">\n"; // append inlined

            serendipity_plugin_api::hook_event('backend_entry_toolbar_body', $entry);

            echo "            </div>\n\n";
            echo "        </div>\n"; // close the plain_editor box
        }
?>

        <div class="form_field clear">
            <textarea id="nuggets<?php echo $inspectConfig['elcount']; ?>" class="direction_<?php echo $inspectConfig['lang_direction']; ?>"<?php echo $tdimension; ?> name="serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]"><?php echo $inspectConfig['hvalue']; ?></textarea>
        </div>

<?php
    }
}

class icHtml extends inspectConfig
{
    protected function icHtml()
    {
        $icText::icText();
    }
}

class icContent extends inspectConfig
{
    protected function icContent()
    {
        global $inspectConfig;
?>

        <div class="default_faq_content"><?php echo $inspectConfig['default']; ?></div>

<?php
    }
}

class icHidden extends inspectConfig
{
    protected function icHidden()
    {
        global $inspectConfig;
?>

        <div class="form_field clear">
            <input class="direction_<?php echo $inspectConfig['lang_direction']; ?>" type="hidden" name="serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]" value="<?php echo $inspectConfig['value']; ?>" />
        </div>

<?php
    }
}

?>