<?php # $Id$

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

/**
 * Serendipity Flattr Plugin
 */
class serendipity_event_flattr extends serendipity_event {
    /**
     * @var string
     */
    var $title = PLUGIN_FLATTR_NAME;

    /**
     * @param string $str
     * @return string
     */
    function _addslashes($str) {
        $str = str_replace(array("\r", "\n"), array(' ', ' '), $str);
        return addslashes($str);
    }

    /**
     * @param serendipity_property_bag $propbag
     */
    function introspect(&$propbag) {
        $events = array(
            'backend_display'                     => true,
            'frontend_display'                    => true,
            'backend_publish'                     => true,
            'backend_save'                        => true,
            'frontend_header'                     => true,
        );
        $propbag->add('name',        PLUGIN_FLATTR_NAME);
        $propbag->add('description', PLUGIN_FLATTR_DESC);
        $propbag->add('stackable',   false);
        $propbag->add('event_hooks',     $events);
        $propbag->add('configuration',   array(
            'userid',
            'placement',
            'flattr_btn',
            'flattr_cat',
            'flattr_lng',
            'flattr_pop',
        ));
        $propbag->add('author',  'Garvin Hicking, Joachim Breitner', 'Matthias Gutjahr');
        $propbag->add('version', '1.9');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $this->flattr_cats = array(
            'text'      => 'text', 
            'images'    => 'images',
            'video'     => 'video',
            'audio'     => 'audio',
            'software'  => 'software',
            'rest'      => 'rest'
        );
        $this->flattr_langs = array(
            'sq_AL' => 'Albanian',
            'ar_DZ' => 'Arabic',
            'be_BY' => 'Belarusian',
            'bg_BG' => 'Bulgarian',
            'ca_ES' => 'Catalan',
            'zh_CN' => 'Chinese',
            'hr_HR' => 'Croatian',
            'cs_CZ' => 'Czech',
            'da_DK' => 'Danish',
            'nl_NL' => 'Dutch',
            'en_GB' => 'English',
            'et_EE' => 'Estonian',
            'fi_FI' => 'Finnish',
            'fr_FR' => 'French',
            'de_DE' => 'German',
            'el_GR' => 'Greek',
            'iw_IL' => 'Hebrew',
            'hi_IN' => 'Hindi',
            'hu_HU' => 'Hungarian',
            'is_IS' => 'Icelandic',
            'in_ID' => 'Indonesian',
            'ga_IE' => 'Irish',
            'it_IT' => 'Italian',
            'ja_JP' => 'Japanese',
            'ko_KR' => 'Korean',
            'lv_LV' => 'Latvian',
            'lt_LT' => 'Lithuanian',
            'mk_MK' => 'Macedonian',
            'ms_MY' => 'Malay',
            'mt_MT' => 'Maltese',
            'no_NO' => 'Norwegian',
            'pl_PL' => 'Polish',
            'pt_PT' => 'Portuguese',
            'ro_RO' => 'Romanian',
            'ru_RU' => 'Russian',
            'sr_RS' => 'Serbian',
            'sk_SK' => 'Slovak',
            'sl_SI' => 'Slovenian',
            'es_ES' => 'Spanish',
            'sv_SE' => 'Swedish',
            'th_TH' => 'Thai',
            'tr_TR' => 'Turkish',
            'uk_UA' => 'Ukrainian',
            'vi_VN' => 'Vietnamese',
        );
        $this->flattr_langs_alias = array(
            'en' => 'en_GB',
            'de' => 'de_DE',
            'es' => 'es_ES',
            'fr' => 'fr_FR',
            'fi' => 'fi_FI',
            'cs' => 'cs_CZ',
            'cz' => 'cs_CZ',
            'nl' => 'nl_NL',
            'is' => 'is_IS',
            'tr' => 'tr_TR',
            'se' => 'sv_SE',
            'pt' => 'pt_PT',
            'pt_PT' => 'pt_PT',
            'bg' => 'bg_BG',
            'hu' => 'hu_HU',
            'no' => 'no_NO',
            'pl' => 'pl_PL',
            'ro' => 'ro_RO',
            'it' => 'it_IT',
            'ru' => 'ru_RU',
            'tw' => 'zh_CN',
            'tn' => 'zh_CN',
            'zh' => 'zh_CN',
            'cn' => 'zh_CN',
            'ja' => 'ja_JP',
            'ko' => 'ko_KR',
            'sa' => 'ar_DZ'
        );
        $this->flattr_attrs = array(
            'flattr_active' => PLUGIN_FLATTR_ACTIVE,
            'flattr_dsc' => PLUGIN_FLATTR_DSC,
            'flattr_cat' => PLUGIN_FLATTR_CATS,
            'flattr_lng' => PLUGIN_FLATTR_LANG,
            'flattr_tag' => PLUGIN_FLATTR_TAG
        );
        $propbag->add('groups', array('FRONTEND_FEATURES'));
    }

    /**
     * @param string $name
     * @param serendipity_property_bag $propbag
     * @return bool
     */
    function introspect_config_item($name, &$propbag) {
        global $serendipity;
        switch($name) {
            case 'userid':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_FLATTR_USER);
                $propbag->add('description',    '');
                $propbag->add('default',        '');
                break;

            case 'flattr_btn':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_FLATTR_BUTTON);
                $propbag->add('description',    PLUGIN_FLATTR_BUTTON_DESC);
                $propbag->add('default',        'compact');
                break;

            case 'placement':
                $positions = array(
                    'add_footer'   => PLUGIN_FLATTR_PLACEMENT_FOOTER,
                    'body'         => ENTRY_BODY,
                    'extended'     => EXTENDED_BODY,
                    'flattr'       => PLUGIN_FLATTR_PLACEMENT_SMARTY,
                );
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_FLATTR_PLACEMENT);
                $propbag->add('description',    '');
                $propbag->add('select_values',  $positions);
                $propbag->add('default',        'add_footer');
                break;

            case 'flattr_cat':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_FLATTR_CATS);
                $propbag->add('description',    '');
                $propbag->add('select_values',  $this->flattr_cats);
                $propbag->add('default',        'text');
                break;

            case 'flattr_lng':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_FLATTR_LANG);
                $propbag->add('description',    '');
                $propbag->add('select_values',  $this->flattr_langs);
                $propbag->add('default',        $this->flatter_langs_alias[$serendipity['lang']]);
                break;

            case 'flattr_pop':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_FLATTR_POPOUT);
                $propbag->add('description',    '');
                $propbag->add('default',        false);
                break;
        }
        
        return true;
    }

    /**
     * @param string $event
     * @param serendipity_property_bag $bag
     * @param mixed $eventData
     * @param mixed $addData
     * @return bool
     */
    function event_hook($event, &$bag, &$eventData, &$addData) {
        global $serendipity;

        switch ($event) {
            case 'backend_publish':
            case 'backend_save':
                serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = '" . $eventData['id'] . "' AND property LIKE 'ep_flattr%'");

                foreach($this->flattr_attrs AS $attr => $attr_desc) {
                    serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, value, property) VALUES ('" . $eventData['id'] . "', '" . serendipity_db_escape_string($serendipity['POST']['properties']['ep_' . $attr]) . "', 'ep_" . $attr . "')");
                }

                return true;
                break;

            case 'backend_display':
?>
                    <fieldset style="margin: 5px">
                        <legend><?php echo PLUGIN_FLATTR_NAME; ?></legend>
<?php
                    foreach($this->flattr_attrs AS $attr => $attr_desc) {
                        if (isset($serendipity['POST']['properties']['ep_' . $attr])) {
                            $val = $serendipity['POST']['properties']['ep_' . $attr];
                        } elseif (isset($eventData['id'])) {
                            $val = $eventData['properties']['ep_' . $attr];
                        } else {
                            $val = '';
                        }
                        
                        echo '<label for="serendipity[properties][ep_' . $attr . ']" title="' . PLUGIN_FLATTR_NAME . '">
                            ' . $attr_desc . ':</label><br/>';

                        if ($attr == 'flattr_active' || $attr == 'flattr_lng' || $attr == 'flattr_cat') { 
                            echo '<select name="serendipity[properties][ep_' . $attr . ']" id="properties_' . $attr . '" class="input_select">';
                            if ($attr == 'flattr_lng') {
                                $opt = $this->flattr_langs;
                                echo '<option value=""></option>' . "\n";
                            } elseif ($attr == 'flattr_cat') {
                                $opt = $this->flattr_cats;
                                echo '<option value=""></option>' . "\n";
                            } elseif ($attr == 'flattr_active') {
                                $opt = array('1' => YES, '-1' => NO);
                            }
                            foreach($opt AS $key => $kval) {
                                echo '<option value="' . $key . '" ' . ((string)$val == (string)$key ? 'selected="selected"' : '') . '>' . htmlspecialchars($kval) . '</option>' . "\n";
                            }
                            echo '</select>';
                        } else {
                            echo '<input type="text" name="serendipity[properties][ep_' . $attr . ']" id="properties_' . $attr . '" class="input_textbox" value="' . htmlspecialchars($val) . '" style="width: 100%" />' . "\n";
                        }
                        echo '<br />';
                    }
?>
                    </fieldset>
<?php
                    return true;
                    break;

            case 'frontend_header':
                $flattr_uid = substr($this->_addslashes($this->get_config('userid')), 0, 500);
                $flattr_btn = $this->_addslashes($this->get_config('flattr_btn'));
                $flattr_lng = substr($this->get_config('flattr_lng'), 0, 255);
                $flattr_cat = substr($this->get_config('flattr_cat'), 0, 255);
?>
<script type="text/javascript">
/* <![CDATA[ */
(function() {
    var s = document.createElement('script');
    var t = document.getElementsByTagName('script')[0];
    s.type = 'text/javascript';
    s.async = true;
    s.src = 'http://api.flattr.com/js/0.6/load.js?mode=auto';
    s.src += '&popout=<?php echo (int)$this->get_config('flattr_pop'); ?>';
    s.src += '&uid=<?php echo $flattr_uid; ?>';
    s.src += '&language=<?php echo $flattr_lng; ?>';
    s.src += '&category=<?php echo $flattr_cat; ?>';
    <?php if (in_array($flattr_btn, array('default', 'compact'))): ?>
    s.src += '&button=<?php echo $flattr_btn; ?>';
    <?php endif; ?>
    t.parentNode.insertBefore(s, t);
 })();
/* ]]> */
</script>
<?php
                break;

            case 'frontend_display':
                if (empty($eventData['properties'])) {
                    $eventData['properties'] =& serendipity_fetchEntryProperties($eventData['id']);
                }
            
                if ($eventData['properties']['ep_flattr_active'] == '-1') {
                    return true;
                }

                if (empty($eventData['body']) && empty($eventData['extended'])) {
                    return true;
                }
                
                $flattr_uid = $this->_addslashes($this->get_config('userid'));
                $flattr_tle = $this->_addslashes($eventData['title']);
                $flattr_pop = (int) $this->get_config('flattr_pop');

                $flattr_dsc = $this->_addslashes($eventData['properties']['ep_flattr_dsc']);
                $flattr_cat = $this->_addslashes($eventData['properties']['ep_flattr_cat']);
                $flattr_lng = $this->_addslashes($eventData['properties']['ep_flattr_lng']);
                $flattr_tag = $this->_addslashes($eventData['properties']['ep_flattr_tag']);

                if (empty($flattr_dsc)) {
                    $flattr_dsc = $this->_addslashes($eventData['body']);
                }
                $flattr_dsc = strip_tags($flattr_dsc);
                
                if (empty($flattr_cat)) {
                    $flattr_cat = $this->get_config('flattr_cat');
                }
                
                if (empty($flattr_lng)) {
                    $flattr_lng = $this->get_config('flattr_lng');
                }
                
                if (empty($flattr_tag) && class_exists('serendipity_event_freetag')) {
                    $_tags = serendipity_event_freetag::getTagsForEntries(array($eventData['id']));
                    $tags = (is_array($_tags) ? array_pop($_tags) : array());
                    $flattr_tag = implode(',', $tags);
                }

                $flattr_url = $this->_addslashes(serendipity_archiveURL($eventData['id'], $eventData['title'], 'baseURL', true, array('timestamp' => $eventData['timestamp'])));
            
                $flattr_btn = $this->_addslashes($this->get_config('flattr_btn'));
                
                $flattr_uid = substr($flattr_uid, 0, 500);
                $flattr_tle = substr($flattr_tle, 0, 500);
                $flattr_dsc = substr($flattr_dsc, 0, 1000);
                $flattr_cat = substr($flattr_cat, 0, 255);
                $flattr_lng = substr($flattr_lng, 0, 255);
                $flattr_tag = substr($flattr_tag, 0, 255);
                $flattr_url = substr($flattr_url, 0, 2048);
                $flattr_btn = substr($flattr_btn, 0, 255);

                if ($flattr_btn != 'default' && $flattr_btn != 'compact') {
                    $flattr = "<a href=\"https://flattr.com/submit/auto?".
                             "user_id=".urlencode($flattr_uid)."&".
                             "url=".urlencode($flattr_url)."&".
                             "title=".urlencode($flattr_tle)."&".
                             "description=".urlencode($flattr_dsc)."&".
                             "category=".urlencode($flattr_cat)."&".
                             "popout=".urlencode($flattr_pop)."&".
                             "language=".urlencode($flattr_lng).
                             "\">" . $flattr_btn . "</a>";
                } else {
                    $flattr = "
<a class='FlattrButton' style='display:none;'
    title='" . $flattr_tle . "'
    data-flattr-uid='" . $flattr_uid . "'
    data-flattr-tags='" . $flattr_tag . "'
    data-flattr-category='" . $flattr_cat . "'
    data-flattr-language='" . $flattr_lng . "'
    href='" . $flattr_url . "'>

    " . $flattr_dsc . "
</a>
    ";
                }

                $field = $this->get_config('placement');
                
                if ($addData['from'] == 'functions_entries:updertEntry') {
                } elseif ($addData['from'] == 'functions_entries:printEntries_rss') {
                    $entryText =& $this->getFieldReference($field, $eventData);
                    $entryText .= htmlspecialchars($flattr);
                } else {
                    $entryText =& $this->getFieldReference($field, $eventData);
                    $entryText .= $flattr;
                }
                
                if ($field == 'extended') {
                    $eventData['is_extended'] = true;
                }

                break;
        }   
    }
}