<?php # $Id: serendipity_event_typesetbuttons.php,v 0.1 12/21/2004 18:08:24

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_typesetbuttons extends serendipity_event
{
    var $title = PLUGIN_EVENT_TYPESETBUTTONS_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_TYPESETBUTTONS_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_TYPESETBUTTONS_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Matthew Groeninger, Malte Diers');
        $propbag->add('version',       '0.11');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('configuration', array(
            'enable_center',
            'enable_strike',
            'enable_space',
            'enable_amp',
            'enable_emdash',
            'enable_endash',
            'enable_bullet',
            'enable_dquotes',
            'type_dquote_info',
            'type_dquotes',
            'enable_squotes',
            'type_squote_info',
            'type_squotes',
            'enable_apos',
            'real_apos',
            'enable_accent',
            'enable_gaccent',
            'use_xhtml11',
            'use_named_ents',
            'custom'
        ));
        $propbag->add('event_hooks',    array(
            'backend_entry_toolbar_extended' => true,
            'backend_entry_toolbar_body' => true
        ));
        $propbag->add('groups', array('BACKEND_EDITOR'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch ($name) {
            case 'custom':
                $propbag->add('type',        'text');
                $propbag->add('name',        PLUGIN_EVENT_TYPESETBUTTONS_CUSTOM);
                $propbag->add('description', PLUGIN_EVENT_TYPESETBUTTONS_CUSTOM_DESC);
                $propbag->add('default',     '');
                break;

            case 'use_xhtml11':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', INSTALL_XHTML11);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            case 'use_named_ents':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_USED_NAMED_ENTS);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            case 'enable_strike':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_STRIKE_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            case 'enable_center':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_CENTER_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            case 'enable_space':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_SPACE_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            case 'enable_amp':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_AMP_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;


            case 'enable_emdash':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_EMDASH_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;


            case 'enable_endash':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_ENDASH_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;


            case 'enable_bullet':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_BULLET_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;


            case 'enable_dquotes':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_DQUOTES_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            case 'type_dquotes':
                 if ($this->get_config('enable_dquotes') == 'yes') {
                     $propbag->add('type',          'radio');
                     $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_TYPE_DQUOTES_BUTTON);
                     $propbag->add('radio',
                         array( 'value' => array('type1','type2','type3','type4','type5','type6','type7','type8'),
                          'desc'  => array(PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES1,PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES2,PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES3,PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES4,PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES5,PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES6,PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES7,PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES8)
                         ));
                     $propbag->add('radio_per_row', '2');
                     $propbag->add('default', 'type1');
                 }
                break;

            case 'type_dquote_info':
                 if ($this->get_config('enable_dquotes') == 'yes') {
                    $propbag->add('type',        'content');
                    $propbag->add('default', PLUGIN_EVENT_TYPESETBUTTONS_TYPE_DQUOTES_NOTE);
                 }
                break;

            case 'enable_squotes':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_SQUOTES_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            case 'type_squotes':
                 if ($this->get_config('enable_squotes') == 'yes') {
                     $propbag->add('type',          'radio');
                     $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_TYPE_SQUOTES_BUTTON);
                     $propbag->add('radio',
                         array( 'value' => array('type1','type2','type3','type4','type5','type6','type7','type8'),
                          'desc'  => array(PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES1,PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES2,PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES3,PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES4,PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES5,PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES6,PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES7,PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES8)
                         ));
                     $propbag->add('radio_per_row', '2');
                     $propbag->add('default', 'type1');
                 }
                break;

            case 'type_squote_info':
                 if ($this->get_config('enable_squotes') == 'yes') {
                     $propbag->add('type',        'content');
                     $propbag->add('default', PLUGIN_EVENT_TYPESETBUTTONS_TYPE_SQUOTES_NOTE);
                 }
                break;


            case 'enable_apos':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_APOS_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            case 'real_apos':
                 if ($this->get_config('enable_apos') == 'yes') {
                     $propbag->add('type',          'radio');
                     $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_REAL_APOS);
                     $propbag->add('radio',
                         array( 'value' => array('yes','no'),
                          'desc'  => array(YES,NO)
                          ));
                     $propbag->add('radio_per_row', '2');
                     $propbag->add('default', 'yes');
                 }
                break;


            case 'enable_accent':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_ACCENT_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            case 'enable_gaccent':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_GACCENT_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            default:
               return false;
        }
        return true;
    }


    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_entry_toolbar_extended':
                    if (!$serendipity['wysiwyg']) {
                        if (isset($eventData['backend_entry_toolbar_extended:textarea'])) {
                            $txtarea = $eventData['backend_entry_toolbar_extended:textarea'];
                        } else {
                            $txtarea = "serendipity[extended]";
                        }
                        $this->generate_button($txtarea);
                        return true;
                    } else {
                        return false;
                    }
                    break;

                case 'backend_entry_toolbar_body':
                    if (!$serendipity['wysiwyg']) {
                        if (isset($eventData['backend_entry_toolbar_body:textarea'])) {
                            $txtarea = $eventData['backend_entry_toolbar_body:textarea'];
                        } else {
                            $txtarea = "serendipity[body]";
                        }
                        $this->generate_button($txtarea);
                        return true;
                    } else {
                        return false;
                    }
                    break;

                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
    }

    function generate_content(&$title) {
            $title = PLUGIN_EVENT_TYPESETBUTTONS_TITLE;
    }

    function generate_button($txtarea)  {
        global $serendipity;
            if (!isset($txtarea)) {
                $txtarea = 'body';
            }
            if ($this->get_config('enable_center') == 'yes') {
                if ($this->get_config('use_xhtml11','yes') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="inscenter" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_CENTER_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'<div class=\'s9y_typeset s9y_typeset_center\' style=\'text-align: center; margin: 0px auto 0px auto\'>','</div>')" />
<?php
                } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="inscenter" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_CENTER_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'<center>','</center>')" />
<?php
                }
            }
            if ($this->get_config('enable_strike') == 'yes') {
                if ($this->get_config('use_xhtml11','yes') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insstrike" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_STRIKE_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'<del>','</del>')" />
<?php
                } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insstrike" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_STRIKE_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'<s>','</s>')" />
<?php
                }
            }
            if ($this->get_config('enable_space') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insSpace" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_SPACE_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#160\;','')" />
<?php
            }
            if ($this->get_config('enable_amp') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insamp" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_AMP_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#38\;','')" />
<?php
            }
            if ($this->get_config('enable_emdash') == 'yes') {
                if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insemd" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_EMDASH_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&mdash\;','')" />
<?php
                } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insemd" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_EMDASH_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#8212\;','')" />
<?php
                }
            }
            if ($this->get_config('enable_endash') == 'yes') {
                if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insend" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_ENDASH_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&ndash\;','')" />
<?php
                } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insend" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_ENDASH_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#8211\;','')" />
<?php
                }
            }
            if ($this->get_config('enable_bullet') == 'yes') {
                if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insbull" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_BULLET_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&bull\;','')" />
<?php
                } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insbull" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_BULLET_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#8226\;','')" />
<?php
                }
            }
            if ($this->get_config('enable_dquotes') == 'yes') {
                switch($this->get_config('type_dquotes','type1')) {
                    case'type1':
                        if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insdquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES1_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&ldquo\;','\&rdquo\;')" />
<?php
                        } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insdquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES1_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#8220\;','\&\#8221\;')" />
<?php
                        }
                    break;
                    case'type2':
                        if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insdquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES2_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&bdquo\;','\&ldquo\;')" />
<?php
                        } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insdquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES2_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#8222\;','\&\#8220\;')" />
<?php
                        }
                    break;
                    case'type3':
                        if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insdquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES3_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&bdquo\;','\&rdquo\;')" />
<?php
                        } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insdquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES3_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#8222\;','\&\#8221\;')" />
<?php
                        }
                    break;
                    case'type4':
                        if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insdquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES4_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&rdquo\;','\&rdquo\;')" />
<?php
                        } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insdquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES4_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#8221\;','\&\#8221\;')" />
<?php
                        }
                    break;
                    case'type5':
                        if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insdquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES5_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&ldquo\;','\&bdquo\;')" />
<?php
                        } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insdquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES5_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#8220\;','\&\#8222\;')" />
<?php
                        }
                    break;
                    case'type6':
                        if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insdquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES6_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#171\;\&\#160\;','\&\#160\;\&\#187\;')" />
<?php
                        } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insdquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES6_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#171\;\&\#160\;','\&\#160\;\&\#187\;')" />
<?php
                        }
                    break;
                    case'type7':
                        if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insdquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES7_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#187\;','\&\#171\;')" />
<?php
                        } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insdquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES7_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#187\;','\&\#171\;')" />
<?php
                        }
                    break;
                    case'type8':
                        if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insdquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES8_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#187\;','\&\#187\;')" />
<?php
                        } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insdquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES8_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#187\;','\&\#187\;')" />
<?php
                        }
                    break;

                }
            }
            if ($this->get_config('enable_squotes') == 'yes') {
                switch($this->get_config('type_squotes','type1')) {
                    case'type1':
                        if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="inssquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES1_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&lsquo\;','\&rsquo\;')" />
<?php
                        } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="inssquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES1_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#8216\;','\&\#8217\;')" />
<?php
                        }
                    break;
                    case'type2':
                        if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="inssquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES2_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&sbquo\;','\&lsquo\;')" />
<?php
                        } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="inssquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES2_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#8218\;','\&\#8216\;')" />
<?php
                        }
                    break;
                    case'type3':
                        if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="inssquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES3_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&sbquo\;','\&rsquo\;')" />
<?php
                        } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="inssquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES3_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#8218\;','\&\#8217\;')" />
<?php
                        }
                    break;
                    case'type4':
                        if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="inssquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES4_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&rsquo\;','\&rsquo\;')" />
<?php
                        } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="inssquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES4_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#8217\;','\&\#8217\;')" />
<?php
                        }
                    break;
                    case'type5':
                        if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="inssquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES5_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&lsquo\;','\&sbquo\;')" />
<?php
                        } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="inssquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES5_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#8216\;','\&\#8218\;')" />
<?php
                        }
                    break;
                    case'type6':
                        if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="inssquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES6_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&lsaquo\;','\&rsaquo\;')" />
<?php
                        } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="inssquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES6_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#8249\;','\&\#8250\;')" />
<?php
                        }
                    break;
                    case'type7':
                        if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="inssquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES7_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&rsaquo\;','\&lsaquo\;')" />
<?php
                        } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="inssquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES7_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#8250\;','\&\#8249\;')" />
<?php
                        }
                    break;
                    case'type8':
                        if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="inssquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES8_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&rsaquo\;','\&rsaquo\;')" />
<?php
                        } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="inssquote" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES8_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#8250\;','\&\#8250\;')" />
<?php
                        }
                    break;

                }
            }
            if ($this->get_config('enable_apos') == 'yes') {
                 if ($this->get_config('real_apos','yes') == 'no') {
                        if ($this->get_config('use_named_ents') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insapos" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_APOS_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&rsquo\;','')" />
<?php
                        } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insapos" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_APOS_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#8217\;','')" />
<?php
                        }
                } else {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insapos" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_APOS_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#39\;','')" />
<?php
                }
            }
            if ($this->get_config('enable_accent') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insaccent" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_ACCENT_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#x0301\;','')" />
<?php
            }
            if ($this->get_config('enable_gaccent') == 'yes') {
?>
            <input type="button" class="serendipityPrettyButton input_button" name="insgaccent" value="<?php echo PLUGIN_EVENT_TYPESETBUTTONS_GACCENT_BUTTON ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'],'\&\#x0300\;','')" />
<?php
            }

            $custom = $this->get_config('custom');
            $custom = trim($custom);
            if (!empty($custom)) {
                echo '<br />';
                $parts = explode('|', $custom);
                foreach($parts AS $idx => $part) {
                    $part = trim($part);
                    if (empty($part)) continue;
                    
                    $buttons = explode('@', $part);
                    $b_name  = htmlspecialchars($buttons[0]);
                    $b_title = preg_replace('@[^a-z0-9]@i', '_', $buttons[0]);
                    $b_open  = str_replace(array('"', "'"), array('&quot;', "\\'"), $buttons[1]);
                    $b_close = str_replace(array('"', "'"), array('&quot;', "\\'"), $buttons[2]);
?>
            <input type="button" class="serendipityPrettyButton input_button" name="ins_custom_<?php echo $b_title; ?>" value="<?php echo $b_name; ?>" onclick="wrapSelection(document.forms['serendipityEntry']['<?php echo $txtarea ?>'], '<?php echo $b_open; ?>', '<?php echo $b_close; ?>')" />
<?php                    
                }
            }
    }
}

/* vim: set sts=4 ts=4 expandtab : */