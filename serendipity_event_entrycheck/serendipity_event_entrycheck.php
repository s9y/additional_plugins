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

class serendipity_event_entrycheck extends serendipity_event
{
    var $title = PLUGIN_EVENT_ENTRYCHECK_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_ENTRYCHECK_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_ENTRYCHECK_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Gregor Voeltz');
        $propbag->add('version',       '1.16');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',    array(
            'backend_entry_updertEntry' => true,
            'backend_entry_checkSave'   => true,
            'backend_entryform'         => true,
            'css_backend'               => true
        ));
        $propbag->add('groups', array('BACKEND_EDITOR'));
        $propbag->add('configuration', array('emptyCategories', 'emptyTitle', 'emptyBody', 'emptyExtended', 'defaultCat', 'locking'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'locking':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_ENTRYCHECK_LOCKING);
                $propbag->add('description', '');
                $propbag->add('default',     false);
                break;

            case 'emptyCategories':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES);
                $propbag->add('description', PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_DESC);
                $propbag->add('default',     false);
                break;

            case 'emptyTitle':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE);
                $propbag->add('description', PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_DESC);
                $propbag->add('default',     false);
                break;

            case 'emptyBody':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY);
                $propbag->add('description', PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY_DESC);
                $propbag->add('default',     false);
                break;

            case 'emptyExtended':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED);
                $propbag->add('description', PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED_DESC);
                $propbag->add('default',     false);
                break;

            case 'defaultCat':
                $cats    = serendipity_fetchCategories($serendipity['authorid']);
                if (!is_array($cats)) {
                    return false;
                }

                $catlist = serendipity_generateCategoryList($cats, array(0), 4);
                $tmp_select_cats = explode('@@@', $catlist);

                if (!is_array($tmp_select_cats)) {
                    return false;
                }

                $select_cats = array();
                $select_cats['none'] = NONE;
                foreach($tmp_select_cats as $cidx => $tmp_select_cat) {
                    $select_cat = explode('|||', $tmp_select_cat);
                    if (!empty($select_cat[0]) && !empty($select_cat[1])) {
                        $select_cats[$select_cat[0]] = $select_cat[1];
                    }
                }

                $propbag->add('type',          'select');
                $propbag->add('select_values', $select_cats);
                $propbag->add('name',          PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT);
                $propbag->add('description',   PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT_DESC);
                $propbag->add('default',       'none');
                break;
        }
        return true;
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function checkLock(&$state, $id) {
        global $serendipity;

        $locked = serendipity_db_query("SELECT property, value FROM {$serendipity['dbPrefix']}entryproperties WHERE (property = 'locked' or property = 'lock_owner')AND entryid = " . (int)$id, false, 'assoc', false, 'property', 'value');
        if (is_array($locked) && $locked['locked'] > 0 ) {
            // Entry is locked

            // Check if it should timeout after one hour
            if ($locked['locked'] < (time() - 3600) || $serendipity['GET']['unlock'] == 'true') {
                serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE (property = 'locked' OR property = 'lock_owner') AND entryid = " . (int)$id);
            } else {
                $state = 'locked';
            }
        }

        if ($state == 'locked' && $locked['lock_owner'] != $serendipity['authorid']) {
            return false;
        } else {
            return true;
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;
        static $state, $locked;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {
                case 'css_backend':
                    echo ".entrylock { margin: 15px auto 15px auto; width: auto; text-align: center; padding: 5px; border: 1px solid yellow; }
                          .entrylock a.serendipityPrettyButton { margin: 15px} \n";
                    return true;
                    break;

                case 'backend_entryform':
                    if (!isset($eventData['id']) || $eventData['id'] < 1) {
                        return true;
                    }

                    $time   = time();
                    $state  = 'unlocked';
                    if (serendipity_db_bool($this->get_config('locking'))) {
                        $this->checkLock($state, $eventData['id']);

                        if ($state == 'unlocked') {
                            // Entry is not yet locked
                            serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}entryproperties (property, value, entryid) VALUES ('locked', '$time', {$eventData['id']})");
                            serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}entryproperties (property, value, entryid) VALUES ('lock_owner', '{$serendipity['authorid']}', {$eventData['id']})");
                            $locked = array('lock_owner' => $serendipity['authorid'], 'locked' => $time);
                        }

                        $owner = serendipity_fetchAuthor($locked['lock_owner']);
                        $link = '<a href="serendipity_admin.php?serendipity[action]=admin&amp;serendipity[adminModule]=entries&amp;serendipity[adminAction]=edit&amp;serendipity[id]=' . (int)$eventData['id'] . '&amp;serendipity[unlock]=true" class="serendipityPrettyButton">' . PLUGIN_EVENT_ENTRYCHECK_UNLOCK . '</a>';
                        printf('<div class="entrylock">' . PLUGIN_EVENT_ENTRYCHECK_LOCKED . ' ' . $link . '</div>', $owner[0]['realname'], serendipity_strftime(DATE_FORMAT_SHORT, $locked['locked']));
                    }

                    return true;
                    break;

                case 'backend_entry_updertEntry':
                    if (serendipity_db_bool($this->get_config('emptyCategories') == true) && count($addData['categories']) < 1 || $addData['categories'][0] == '0') {
                        $eventData[] = PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_WARNING;
                    }

                    if (serendipity_db_bool($this->get_config('emptyTitle') == true) && strlen($addData['title']) < 1) {
                        $eventData[] = PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_WARNING;
                    }

                    if (serendipity_db_bool($this->get_config('emptyBody') == true) && strlen($addData['body']) < 1) {
                        $eventData[] = PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY_WARNING;
                    }

                    if (serendipity_db_bool($this->get_config('emptyExtended') == true) && strlen($addData['extended']) < 1) {
                        $eventData[] = PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED_WARNING;
                    }

                    if ($addData['id'] > 0 && serendipity_db_bool($this->get_config('locking'))) {
                        $state = 'unlocked';
                        if (!$this->checkLock($state, $addData['id'])) {
                            $eventData[] = PLUGIN_EVENT_ENTRYCHECK_LOCK_WARNING;
                        }
                    }

                    return true;
                    break;

                case 'backend_entry_checkSave':
                    // Emit JavaScript
?>
                        if (document.getElementById) {
                            <?php if ($state == 'locked' && $locked['lock_owner'] != $serendipity['authorid']) { ?>
                            alert('<?php echo str_replace("'", "\\'", PLUGIN_EVENT_ENTRYCHECK_LOCK_WARNING); ?>');
                            error = true;
                            <?php } ?>

                            defaultcat = '<?php echo $this->get_config('defaultCat'); ?>';
                            el = document.getElementById('categoryselector');
                            if (el != null) {
                                empty_category = false;
                                if (el.options[0].selected) {
                                    empty_category = true;
                                }

                                for (i = 1; i < el.options.length; i++) {
                                    if (el.options[i].selected) {
                                        empty_category = false;
                                    }
                                }
                            }                            
                            if (typeof serendipity.hasNoCategoryEnabled === "function") {
                                empty_category = serendipity.hasNoCategoryEnabled();
                            }
                            
                            error = false;
                            if (empty_category) {
                                showerror = true;
                                if (defaultcat != 'none' && defaultcat != '') {
                                    if (el != null) {
                                        for (i = 1; i < el.options.length; i++) {
                                            if (el.options[i].value == defaultcat) {
                                                el.options[i].selected = true;
                                                showerror = false;
                                                el.selectedIndex = i;
                                            }
                                        }
                                    }
                                    if (typeof serendipity.enableCategory === "function") {
                                        serendipity.enableCategory(defaultcat);
                                        showerror = false;
                                    }
                                }

<?php if (serendipity_db_bool($this->get_config('emptyCategories'))) { ?>
                                if (showerror) {
                                    alert('<?php echo str_replace("'", "\\'", PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_WARNING); ?>');
                                    error = true;
                                }
<?php } ?>
                            }

                            <?php if (serendipity_db_bool($this->get_config('emptyTitle')) == true) { ?>
                            if (document.getElementById('entryTitle').value.length < 1) {
                                alert('<?php echo str_replace("'", "\\'", PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_WARNING); ?>');
                                error = true;
                            }
                            <?php } ?>

                            <?php if (serendipity_db_bool($this->get_config('emptyBody')) == true) { ?>
                            if (typeof(editorbody) != "undefined") {
                                editorbody.setMode('textmode');
                                var serendipitybody = document.getElementById('serendipity[body]').value.replace(/(<([^>]+)>)/ig,"");
                            } else {
                                var serendipitybody = document.getElementById('serendipity[body]').value;
                            }
                            if (serendipitybody.length < 1) {
                                alert('<?php echo str_replace("'", "\\'", PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY_WARNING); ?>');
                                error = true;
                            }
                            if (typeof(editorbody) != "undefined") {
                                editorbody.setMode('wysiwyg');
                            }
                            <?php } ?>

                            <?php if (serendipity_db_bool($this->get_config('emptyExtended')) == true) { ?>
                            if (typeof(editorextended) != "undefined") {
                                editorextended.setMode('textmode');
                                var serendipityextended = document.getElementById('serendipity[extended]').value.replace(/(<([^>]+)>)/ig,"");
                            } else {
                                var serendipityextended = document.getElementById('serendipity[extended]').value;
                            }
                            if (serendipityextended.length < 1) {
                                alert('<?php echo str_replace("'", "\\'", PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED_WARNING); ?>');
                                error = true;
                            }
                            if (typeof(editorextended) != "undefined") {
                                editorextended.setMode('wysiwyg');
                            }
                            <?php } ?>

                            if (error) {
                                return false;
                            }
                        }
<?php
                    return true;
                    break;
            }
        } else {
            return false;
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>
