
<div class="clearfix">

<?php
    $elcount = 0;
    $htmlnugget = array();
    foreach ($this->config as $config_item) {
        $elcount++;
        $config_value = $this->staticpage[$config_item];
        $cbag = new serendipity_property_bag;
        $this->introspect_item($config_item, $cbag);

        $cname      = (function_exists('serendipity_specialchars') ? serendipity_specialchars($cbag->get('name')) : htmlspecialchars($cbag->get('name'), ENT_COMPAT, LANG_CHARSET));
        $cdesc      = (function_exists('serendipity_specialchars') ? serendipity_specialchars($cbag->get('description')) : htmlspecialchars($cbag->get('description'), ENT_COMPAT, LANG_CHARSET));
        $value      = $this->get_static($config_item, 'unset');
        $lang_direction = (function_exists('serendipity_specialchars') ? serendipity_specialchars($cbag->get('lang_direction')) : htmlspecialchars($cbag->get('lang_direction'), ENT_COMPAT, LANG_CHARSET));
        $only_type  = $cbag->get('only_type');
        if (!empty($only_type) && $type != $only_type) {
            $elcount--;
            continue;
        }

        if (empty($lang_direction)) {
            $lang_direction = LANG_DIRECTION;
        }

        /* Apparently no value was set for this config item */
        if ($value === 'unset') {
            /* Try and the default value for the config item */
            $value = $cbag->get('default');
        }
        $hvalue   = (!isset($_POST["serendipity"]["staticSubmit"]) && isset($_POST['serendipity']['plugin'][$config_item]) ? (function_exists('serendipity_specialchars') ? serendipity_specialchars($_POST['serendipity']['plugin'][$config_item]) : htmlspecialchars($_POST['serendipity']['plugin'][$config_item], ENT_COMPAT, LANG_CHARSET)) : (function_exists('serendipity_specialchars') ? serendipity_specialchars($value) : htmlspecialchars($value, ENT_COMPAT, LANG_CHARSET)));
        $radio    = array();
        $select   = array();
        $per_row  = null;

        switch ($cbag->get('type')) {
            case 'seperator':
?>
    <hr>
<?php
                break;

            case 'select':
                $select = $cbag->get('select_values');
?>
    <div class="clearfix form_select<?php if ($cdesc != '') { ?> has_info<?php } ?>">
        <label for="serendipity_<?php echo $config_item; ?>"><?php echo $cname; ?><?php if ($cdesc != '') { ?> <button class="toggle_info button_link" type="button" data-href="#<?php echo $config_item; ?>_info"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"> <?php echo MORE; ?></span></button><?php } ?></label>
        <?php if ($cdesc != '') { ?><span id="<?php echo $config_item; ?>_info" class="field_info additional_info"><?php echo $cdesc; ?></span><?php } ?>
        <select id="serendipity_<?php echo $config_item; ?>" class="direction_<?php echo $lang_direction; ?>" name="serendipity[plugin][<?php echo $config_item; ?>]{($is_multi_select) ? '[]' : ''}" {($is_multi_select) ? 'multiple' : ''} {($is_multi_select && ($select_size > 0)) ? "size='{$select_size}'" : ''}>
<?php
                foreach($select AS $select_value => $select_desc) {
                    $id = (function_exists('serendipity_specialchars') ? serendipity_specialchars($config_item . $select_value) : htmlspecialchars($config_item . $select_value, ENT_COMPAT, LANG_CHARSET));
?>
            <option value="<?php echo $select_value; ?>" <?php echo ($select_value == $hvalue ? 'selected="selected"' : ''); ?> title="<?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($select_desc) : htmlspecialchars($select_desc, ENT_COMPAT, LANG_CHARSET)); ?>"><?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($select_desc) : htmlspecialchars($select_desc, ENT_COMPAT, LANG_CHARSET)); ?></option>
<?php
                }
?>
        </select>
    </div>
<?php
                break;

            case 'tristate':
                $per_row = 3;
                $radio['value'][] = 'default';
                $radio['desc'][]  = USE_DEFAULT;

            case 'boolean':
                $radio['value'][] = 'true';
                $radio['desc'][]  = YES;

                $radio['value'][] = 'false';
                $radio['desc'][]  = NO;

           case 'radio':
                if (!count($radio) > 0) {
                    $radio = $cbag->get('radio');
                }

                if (empty($per_row)) {
                    $per_row = $cbag->get('radio_per_row');
                    if (empty($per_row)) {
                        $per_row = 2;
                    }
                }
?>
    <fieldset<?php if ($cdesc != '') { ?> class="has_info"<?php } ?>>
        <span class="wrap_legend"><legend><?php echo $cname; ?><?php if ($cdesc != '') { ?> <button class="toggle_info button_link" type="button" data-href="#<?php echo $config_item; ?>_info"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"> <?php echo MORE; ?></span></button><?php } ?></legend></span>
        <?php if ($cdesc != '') { ?><span id="<?php echo $config_item; ?>_info" class="field_info additional_info"><?php echo $cdesc; ?></span><?php } ?>
        <div class="clearfix grouped">
<?php
                $counter = 0;
                foreach($radio['value'] AS $radio_index => $radio_value) {
                    $id = (function_exists('serendipity_specialchars') ? serendipity_specialchars($config_item . $radio_value) : htmlspecialchars($config_item . $radio_value, ENT_COMPAT, LANG_CHARSET));
                    $counter++;
                    $checked = "";

                    if ($radio_value == 'true' && ($hvalue === '1' || $hvalue === 'true')) {
                        $checked = " checked";
                    } elseif ($radio_value == 'false' && ($hvalue === '' || $hvalue ==='0' || $hvalue === 'false')) {
                        $checked = " checked";
                    } elseif ($radio_value == $hvalue) {
                        $checked = " checked";
                    }

                    if ($counter == 1) {
?>
            <div class="form_radio">
<?php
                    }
?>
                <input id="serendipity_plugin_<?php echo $id; ?>" class="direction_<?php echo $lang_direction; ?>" name="serendipity[plugin][<?php echo $config_item; ?>]" type="radio" value="<?php echo $radio_value; ?>" <?php echo $checked ?> title="<?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($radio['desc'][$radio_index]) : htmlspecialchars($radio['desc'][$radio_index], ENT_COMPAT, LANG_CHARSET)); ?>">
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
    </fieldset>

<?php
                break;

            case 'string':
?>
    <div class="clearfix configuration_group">
        <div class="clearfix form_field<?php if ($cdesc != '') { ?> has_info<?php } ?>">
            <label for="serendipity_<?php echo $config_item; ?>"><?php echo $cname; if ($cdesc != '') { ?> <button class="toggle_info button_link" type="button" data-href="#<?php echo $config_item; ?>_info"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"> <?php echo MORE; ?></span></button><?php } ?></label>
            <?php if ($cdesc != '') { ?><span id="<?php echo $config_item; ?>_info" class="field_info additional_info"><?php echo $cdesc; ?></span><?php } ?>
            <input id="serendipity_<?php echo $config_item; ?>" class="direction_<?php echo $lang_direction; ?>" name="serendipity[plugin][<?php echo $config_item; ?>]" type="text" value="<?php echo $hvalue; ?>">
        </div>
    </div>
<?php
                break;

            case 'html':
            case 'text':
?>

    <div class="clearfix form_area<?php if ($cdesc != '') { ?> has_info<?php } ?>">
        <label for="nuggets<?php echo $elcount; ?>"><?php echo $cname; if ($cdesc != '' && !$backend_wysiwyg) { ?> <button class="toggle_info button_link" type="button" data-href="#nuggets<?php echo $elcount; ?>_info"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"> <?php echo MORE; ?></span></button><?php } ?></label>
        <?php if ($cdesc != '') { ?><span id="nuggets<?php echo $elcount; ?>_info" class="field_info additional_info"><?php echo $cdesc; ?></span><?php } ?>
        <textarea id="nuggets<?php echo $elcount; ?>" class="direction_<?php echo $lang_direction; ?>" name="serendipity[plugin][<?php echo $config_item; ?>]" rows="10"><?php echo $hvalue; ?></textarea>
    </div>

<?php
                if ($cbag->get('type') == 'html') {
                    $htmlnugget[] = $elcount;
                    // SpawnMulti false per default (see multi nugget textareas, eg contactform) - where do we use jsname furthermore - or is that deprecated?
                    serendipity_emit_htmlarea_code("nuggets{$elcount}","nuggets{$elcount}");
                }
                break;

            case 'content':
?>
    <div class="clearfix">
        <?php echo $cbag->get('default'); ?>
    </div>
<?php
                break;

            case 'hidden':
?>
    <div class="clearfix">
        <input name="serendipity[plugin][<?php echo $config_item; ?>]" type="hidden" value="<?php echo $cbag->get('value'); ?>">
    </div>
<?php
                break;
        }
    }

    if (isset($serendipity['wysiwyg']) && $serendipity['wysiwyg'] && count($htmlnugget) > 0) {
        $ev = array('nuggets' => $htmlnugget, 'skip_nuggets' => false);
        serendipity_plugin_api::hook_event('backend_wysiwyg_nuggets', $ev);

        if ($ev['skip_nuggets'] === false) {
?>
    <script type="text/javascript">
    function Spawnnugget() {
        <?php foreach($htmlnugget AS $htmlnuggetid) { ?>
        if (window.Spawnnuggets) Spawnnuggets('<?php echo $htmlnuggetid; ?>');
        <?php } ?>
    }
    </script>
<?php
        }
    }
?>

    <div class="clearfix edit_actions">
        <input class="input_button state_submit" type="submit" value="<?php echo SAVE; ?>" name="serendipity[SAVECONF]">
    </div>

</div>