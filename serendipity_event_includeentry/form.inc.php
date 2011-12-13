<br /><hr />
    <table border="0" cellspacing="0" cellpadding="3" width="100%">
<?php
    $elcount = 0;
    $htmlnugget = array();
    foreach ($this->config as $config_item) {
        $elcount++;
        $config_value = $this->staticpage[$config_item];
        $cbag = new serendipity_property_bag;
        $this->introspect_item($config_item, $cbag);

        $cname      = htmlspecialchars($cbag->get('name'));
        $cdesc      = htmlspecialchars($cbag->get('description'));
        $value      = $this->get_static($config_item, 'unset');
        $lang_direction = htmlspecialchars($cbag->get('lang_direction'));
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
        $hvalue   = (!isset($_POST["serendipity"]["staticSubmit"]) && isset($_POST['serendipity']['plugin'][$config_item]) ? htmlspecialchars($_POST['serendipity']['plugin'][$config_item]) : htmlspecialchars($value));
        $radio    = array();
        $select   = array();
        $per_row  = null;

        switch ($cbag->get('type')) {
            case 'seperator':
?>
        <tr>
            <td colspan="2"><hr noshade="noshade" size="1" /></td>
        </tr>
<?php
                break;

            case 'select':
                $select = $cbag->get('select_values');
?>
        <tr>
            <td style="border-bottom: 1px solid #000000; vertical-align: top"><strong><?php echo $cname; ?></strong>
<?php
    if ($cdesc != '') {
?>
                <br><span  style="color: #5E7A94; font-size: 8pt;">&nbsp;<?php echo $cdesc; ?></span>
<?php } ?>
            </td>
            <td style="border-bottom: 1px solid #000000; vertical-align: middle" width="250">
                <div>
                    <select class="direction_<?php echo $lang_direction; ?>" name="serendipity[plugin][<?php echo $config_item; ?>]">
<?php
                foreach($select AS $select_value => $select_desc) {
                    $id = htmlspecialchars($config_item . $select_value);
?>
                        <option value="<?php echo $select_value; ?>" <?php echo ($select_value == $hvalue ? 'selected="selected"' : ''); ?> title="<?php echo htmlspecialchars($select_desc); ?>" />
                            <?php echo htmlspecialchars($select_desc); ?>
                        </option>
<?php
                }
?>
                    </select>
                </div>
            </td>
        </tr>
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
        <tr>
            <td style="border-bottom: 1px solid #000000; vertical-align: top"><strong><?php echo $cname; ?></strong>
<?php
                if ($cdesc != '') {
?>
                <br /><span  style="color: #5E7A94; font-size: 8pt;">&nbsp;<?php echo $cdesc; ?></span>
<?php
                }
?>
            </td>
            <td style="border-bottom: 1px solid #000000; vertical-align: middle;" width="250">
<?php
                $counter = 0;
                foreach($radio['value'] AS $radio_index => $radio_value) {
                    $id = htmlspecialchars($config_item . $radio_value);
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
                <div>
<?php
                    }
?>
                    <input class="direction_<?php echo $lang_direction; ?> input_radio" type="radio" id="serendipity_plugin_<?php echo $id; ?>" name="serendipity[plugin][<?php echo $config_item; ?>]" value="<?php echo $radio_value; ?>" <?php echo $checked ?> title="<?php echo htmlspecialchars($radio['desc'][$radio_index]); ?>" />
                        <label for="serendipity_plugin_<?php echo $id; ?>"><?php echo htmlspecialchars($radio['desc'][$radio_index]); ?></label>
<?php
                    if ($counter == $per_row) {
                        $counter = 0;
?>
                </div>
<?php
                    }
                }
?>
            </td>
        </tr>
<?php
                break;

            case 'string':
?>
        <tr>
            <td style="border-bottom: 1px solid #000000">
                    <strong><?php echo $cname; ?></strong>
                    <br><span style="color: #5E7A94; font-size: 8pt;">&nbsp;<?php echo $cdesc; ?></span>
            </td>
            <td style="border-bottom: 1px solid #000000" width="250">
                <div>
                    <input class="direction_<?php echo $lang_direction; ?> input_textbox" type="text" name="serendipity[plugin][<?php echo $config_item; ?>]" value="<?php echo $hvalue; ?>" size="30" />
                </div>
            </td>
        </tr>
<?php
                break;

            case 'html':
            case 'text':
?>
        <tr>
            <td colspan="2"><strong><?php echo $cname; ?></strong>
                &nbsp;<span style="color: #5E7A94; font-size: 8pt;">&nbsp;<?php echo $cdesc; ?></span>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <div>
                    <textarea class="direction_<?php echo $lang_direction; ?>" style="width: 100%" id="nuggets<?php echo $elcount; ?>" name="serendipity[plugin][<?php echo $config_item; ?>]" rows="20" cols="80"><?php echo $hvalue; ?></textarea>
                </div>
            </td>
        </tr>
<?php
                if ($cbag->get('type') == 'html') {
                    $htmlnugget[] = $elcount;
                    if (version_compare(preg_replace('@[^0-9\.]@', '', $serendipity['version']), '0.9', '<')) {
                        serendipity_emit_htmlarea_code('nuggets' . $elcount, 'nuggets' . $elcount);
                    } else {
                        serendipity_emit_htmlarea_code('nuggets', 'nuggets', true);
                    }
                }
                break;

            case 'content':
                ?><tr><td colspan="2"><?php echo $cbag->get('default'); ?></td></tr><?php
                break;

            case 'hidden':
                ?><tr><td colspan="2"><input class="direction_<?php echo $lang_direction; ?> input_textbox" type="hidden" name="serendipity[plugin][<?php echo $config_item; ?>]" value="<?php echo $cbag->get('value'); ?>" /></td></tr><?php
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
        <?php foreach($htmlnugget AS $htmlnuggetid) {
                if (version_compare(preg_replace('@[^0-9\.]@', '', $serendipity['version']), '0.9', '<')) { ?>
        Spawnnuggets<?php echo $htmlnuggetid; ?>();
                    <?php } else { ?>
        Spawnnuggets('<?php echo $htmlnuggetid; ?>');
                    <?php } ?>
        <?php } ?>
    }
    </script>
<?php
        }
    }
?>
    </table>
<br />
    <div style="padding-left: 20px">
        <input type="submit" name="serendipity[SAVECONF]" value="<?php echo SAVE; ?>" class="serendipityPrettyButton input_button" />
    </div>
