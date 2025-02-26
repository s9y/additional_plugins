<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

define('D_FAQ_MOVEUP', 0);
define('D_FAQ_MOVEDOWN', 1);

class serendipity_event_faq extends serendipity_event
{

    /**
     *
     * Array for the FAQ data
     *
     * @var array
     * @see introspect_faq_item
     * @see getFaq
     * @see updateFAQ
     */
    var $faq = array();

    /**
     *
     * Array for the FAQ category data
     *
     * @var array
     * @see
     */
    var $category = array();

    /**
     *
     * Configuration array for faqs
     *
     */
    var $config_faq = array(
        'faqorder',
        'question',
        'answer',
        'cid',
        'id'
    );

    /**
     *
     * Configuration array for categories
     *
     */
    var $config_category = array(
        'id',
        'catorder',
        'parent_id',
        'language',
        'category',
        'introduction'
    );

    /**
     * The introspection function of this plugin, to setup properties
     *
     * Called by serendipity when it wants to display information
     * about this plugin.
     *
     * @access public
     * @param  object  A property bag object you can manipulate
     * @return true
     */
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',         FAQ_NAME);
        $propbag->add('description',  FAQ_NAME_DESC);
        $propbag->add('author',       'Falk Doering, Ian');
        $propbag->add('version',      '1.24.1');
        $propbag->add('copyright',    'LGPL');
        $propbag->add('stackable',    false);
        $propbag->add('requirements', array(
            'serendipity'   => '1.7',
            'smarty'        => '3.1.0',
            'php'           => '5.2.0'
        ));
        $propbag->add('groups',                 array('FRONTEND_FEATURES'));
        $propbag->add('configuration_faq',      $this->config_faq);
        $propbag->add('configuration_category', $this->config_category);
        $propbag->add('configuration',          array('markup', 'daysnew', 'daysupdate', 'faqurl' ));
        $propbag->add('event_hooks',            array(
            'backend_sidebar_entries_event_display_faq' => true,
            'backend_sidebar_entries'                   => true,
            'backend_sidebar_admin_appearance'          => true,
            'entries_footer'                            => true,
            'external_plugin'                           => true,
            'entry_display'                             => true,
            'genpage'                                   => true,
            'css_backend'                               => true,
            'css'                                       => true
        ));

        return true;
    }

    /**
     * Introspection of this plugin configuration item
     *
     * Called by serendipity when it wants to display the configuration
     * editor for your plugin.
     * $name is the name of a configuration item added in this
     * instrospect method.
     *
     * @access  public
     * @param   string      Name of the config item
     * @param   object      A property bag object to store the configuration in
     * @return  boolean
     */

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch ($name) {
            case 'daysnew':
                $propbag->add('type',        'string');
                $propbag->add('name',        FAQ_DAYSNEW);
                $propbag->add('description', FAQ_DAYSNEW_DESC);
                $propbag->add('default',     '15');
                break;

            case 'daysupdate':
                $propbag->add('type',        'string');
                $propbag->add('name',        FAQ_DAYSUPDATE);
                $propbag->add('description', FAQ_DAYSUPDATE_DESC);
                $propbag->add('default',     '15');
                break;

            case 'faqurl':
                $propbag->add('type',        'string');
                $propbag->add('name',        FAQ_FAQURL);
                $propbag->add('description', FAQ_FAQURL_DESC);
                $propbag->add('default',     'faqs');
                break;

            case 'markup':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        FAQ_MARKUP);
                $propbag->add('description', FAQ_MARKUP_DESC);
                $propbag->add('default',     'true');
                break;

            default:
                return false;
        }
        return true;

    }

    /**
     * Introspection of this plugin faq item
     *
     * Called by this plugin when it wants to display the configuration
     * editor for one faq.
     * $name is the name of a configuration item added in this
     * instrospect method.
     *
     * @access  public
     * @param   string      Name of the faq item
     * @param   object      A property bag object to store the configuration in
     * @return  boolean
     */

    function introspect_faq_item($name, &$propbag)
    {
        global $serendipity;

        switch ($name) {
            case 'question':
                $propbag->add('type',           'text');
                $propbag->add('name',           FAQ_QUESTION);
                $propbag->add('description',    FAQ_QUESTION_DESC);
                $propbag->add('default',        '');
                break;

            case 'answer':
                $propbag->add('type',           'text');
                $propbag->add('name',           FAQ_ANSWER);
                $propbag->add('description',    FAQ_ANSWER_DESC);
                $propbag->add('default',        '');
                break;

            case 'cid':
                $propbag->add('type',           'hidden');
                $propbag->add('value',          (empty($this->faq['cid'] ?? []) ? $serendipity['GET']['cid'] ?? null : $this->faq['cid']));
                break;

            case 'id':
                $propbag->add('type',           'hidden');
                $propbag->add('value',          $this->faq['id'] ?? null);
                break;

            default:
                return false;
        }
        return true;
    }

    /**
     * Introspection of this plugin category item
     *
     * Called by this plugin when it wants to display the configuration
     * editor for one category.
     * $name is the name of a configuration item added in this
     * instrospect method.
     *
     * @access  public
     * @param   string      Name of the category item
     * @param   object      A property bag object to store the configuration in
     * @return  boolean
     */

    function introspect_category_item($name, &$propbag)
    {
        global $serendipity;

        switch ($name) {
            case 'id':
                $propbag->add('type',           'hidden');
                $propbag->add('value',          $this->category['id'] ?? null);
                break;

            case 'parent_id':
                $propbag->add('type',           'select');
                $propbag->add('name',           FAQ_PID);
                $propbag->add('description',    FAQ_PID_PID);
                $propbag->add('select_values',  $this->getCategories($serendipity['GET']['cat_lang'] ?? null));
                $propbag->add('default',        '');
                break;

            case 'category':
                $propbag->add('type',           'string');
                $propbag->add('name',           FAQ_CATEGORY);
                $propbag->add('description',    FAQ_CATEGORY_DESC);
                $propbag->add('default',        '');
                break;

            case 'introduction':
                $propbag->add('type',           'text');
                $propbag->add('name',           FAQ_DESCRIPTION);
                $propbag->add('description',    FAQ_DESCRIPTION_DESC);
                $propbag->add('default',        '');
                break;

            case 'language':
                $propbag->add('type',           'hidden');
                $propbag->add('value',          $serendipity['GET']['cat_lang'] ?? null);
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        $title = FAQ_NAME;
    }

    function install()
    {
        $this->setupDB();
    }

    function setupDB()
    {
        global $serendipity;

        $db = $this->get_config('db_built', 0);
        switch ($db) {
            case 0:
                $q = "CREATE TABLE {$serendipity['dbPrefix']}faqs (
                        id {AUTOINCREMENT} {PRIMARY},
                        cid int(11) default 0,
                        faqorder int(11) default 0,
                        question text,
                        answer text
                ) {UTF_8}";
                serendipity_db_schema_import($q);
                $q = "CREATE TABLE {$serendipity['dbPrefix']}faq_categorys (
                        id {AUTOINCREMENT} {PRIMARY},
                        parent_id int(11) not null default 0,
                        catorder int(11) default 0,
                        category varchar(255) not null,
                        introduction text
                ) {UTF_8}";
                serendipity_db_schema_import($q);
            case 1:
                $q = "ALTER TABLE {$serendipity['dbPrefix']}faqs ADD COLUMN changedate int(11) default 0";
                serendipity_db_schema_import($q);
                $q = "ALTER TABLE {$serendipity['dbPrefix']}faqs ADD COLUMN changetype varchar(10)";
                serendipity_db_schema_import($q);
            case 2:
                $q = "CREATE {FULLTEXT_MYSQL} INDEX faqentry_idx ON {$serendipity['dbPrefix']}faqs (question, answer)";
                serendipity_db_schema_import($q);
            case 3:
                $q = "ALTER TABLE {$serendipity['dbPrefix']}faq_categorys ADD COLUMN language varchar(2)";
                serendipity_db_schema_import($q);
                serendipity_db_update('faq_categorys', array(), array('language' => $serendipity['language']));
                $this->set_config('db_built', 4);
                break;
        }

    }

    /**
     *
     * Get categories data
     *
     * Select all categories stored in the faq categories table.
     * If the parameter is true only parent categories will be
     * returned.
     *
     * @access public
     * @param  boolean
     * @return array
     */
    function getCategories($lang)
    {
        global $serendipity;
        $c = array('0' => FAQ_PARENT);

        $cats = $this->fetchCategories($lang);
        if (is_array($cats)) {
            $cats = serendipity_walkRecursive($cats);
            foreach ($cats AS $cat) {
                if (($this->category['id'] != $cat['id']) && ($this->category['id'] != $cat['parent_id'])) {
                    $c[$cat['id']] = $cat['category'];
                }
            }
        }
        return $c;
    }

    function fetchCategories($lang)
    {
        global $serendipity;

        $q = "SELECT id, parent_id, category, catorder, language
                FROM {$serendipity['dbPrefix']}faq_categorys
               WHERE language = '$lang'
            ORDER BY catorder";
        return serendipity_db_query($q, false, 'assoc');
    }

    function &getFaq($key, $default = null)
    {
        return (isset($this->faq[$key]) ? $this->faq[$key] : $default);
    }

    function &getCategory($key, $default = null)
    {
        return (isset($this->category[$key]) ? $this->category[$key] : $default);
    }

    function postgreFaqPrepare()
    {
        if (empty($this->faq['faqorder'])) {
            $this->faq['faqorder'] = '1';
        }
        if (empty($this->faq['id'])) {
            unset($this->faq['id']);
        }
    }

    function &updateFAQ()
    {
        global $serendipity;

        if (!is_numeric($this->faq['id'])) {
            $this->faq['changedate'] = time();
            $this->faq['changetype'] = 'new';
            if (!is_numeric($this->faq['cid'])) {
                trigger_error("The {$this->faq['cid']} (cid) parameter must contain a valid 'category id' key", E_USER_ERROR);
                return;
            }
            $q = "SELECT COUNT(id) AS counter
                    FROM {$serendipity['dbPrefix']}faqs
                   WHERE cid = ".$this->faq['cid'];
            $res = serendipity_db_query($q, true, 'assoc');
            $this->faq['faqorder'] = ($res['counter'] + 1);
            $this->postgreFaqPrepare();
            $result = serendipity_db_insert('faqs', $this->faq);
            $serendipity['POST']['id'] = serendipity_db_insert_id('faqs', 'id');
        } else {
            $this->faq['changedate'] = time();
            $this->faq['changetype'] = 'update';
            $result = serendipity_db_update('faqs', array('id' => $this->faq['id']), $this->faq);
        }
        return $result;
    }

    function deleteFAQ(&$id)
    {
        global $serendipity;

        $q = "SELECT cid, faqorder
                FROM {$serendipity['dbPrefix']}faqs
               WHERE id = $id";
        $res = serendipity_db_query($q, true, 'assoc');

        $q = "DELETE FROM {$serendipity['dbPrefix']}faqs
               WHERE id = $id";
        if (serendipity_db_query($q)) {
            $q = "UPDATE {$serendipity['dbPrefix']}faqs
                     SET faqorder = faqorder - 1
                   WHERE cid = {$res['cid']}
                     AND faqorder > {$res['faqorder']}";
            return serendipity_db_query($q);
        }
        return false;
    }

    function fetchFAQ(&$id)
    {
        global $serendipity;

        $q = "SELECT *
                FROM {$serendipity['dbPrefix']}faqs
               WHERE id = $id";
        $faq = serendipity_db_query($q, true, 'assoc');
        if (is_array($faq)) {
            $this->faq =& $faq;
            return true;
        }
        return false;
    }

    function fetchFaqByCid(&$cid)
    {
        global $serendipity;

        $q = "SELECT id, question
                FROM {$serendipity['dbPrefix']}faqs
               WHERE cid = $cid
            ORDER BY faqorder";
        return serendipity_db_query($q, false, 'assoc');
    }

    function fetchCategory(&$id)
    {
        global $serendipity;

        $q = "SELECT *
                FROM {$serendipity['dbPrefix']}faq_categorys
               WHERE id = $id";
        $cat = serendipity_db_query($q, true, 'assoc');
        if (is_array($cat)) {
            $this->category = &$cat;
            return true;
        }
        return false;
    }

    function postgreCategoryPrepare()
    {
        if (empty($this->category['parent_id'])) {
            $this->category['parent_id'] = '0';
        }
        if (empty($this->category['catorder'])) {
            $this->category['catorder'] = '1';
        }
    }

    function &updateCategory()
    {
        global $serendipity;

        if (!is_numeric($this->category['id'])) {
            $q = "SELECT COUNT(id) AS counter
                    FROM {$serendipity['dbPrefix']}faq_categorys
                   WHERE parent_id = ".$this->category['parent_id'];
            $res = serendipity_db_query($q, true, 'assoc');

            $this->category['catorder'] = ($res['counter'] + 1);
            $this->postgreCategoryPrepare();
            $result = serendipity_db_insert('faq_categorys', $this->category);
            $serendipity['POST']['cid'] = serendipity_db_insert_id('faq_categorys', 'id');
        } else {
            $result = serendipity_db_update('faq_categorys', array('id' => $this->category['id']), $this->category);
        }
        return $result;
    }

    function deleteCategory(&$id)
    {
        global $serendipity;

        $q = "SELECT catorder, parent_id
                FROM {$serendipity['dbPrefix']}faq_categorys
               WHERE id = $id";
        $res = serendipity_db_query($q, true, 'assoc');

        $q = "DELETE FROM {$serendipity['dbPrefix']}faq_categorys
               WHERE id = $id";
        if (serendipity_db_query($q)) {
            $q = "UPDATE {$serendipity['dbPrefix']}faq_categorys
                     SET catorder = catorder - 1
                   WHERE parent_id = {$res['parent_id']}
                     AND catorder > {$res['catorder']}";
            serendipity_db_query($q);
            $q = "UPDATE {$serendipity['dbPrefix']}faq_categorys
                     SET parent_id = 0
                   WHERE parent_id = $id";
            serendipity_db_query($q);
            return true;
        }
        return false;
    }

    function isFaq()
    {
        global $serendipity;

        return (($serendipity['uriArguments'][0] == $serendipity['permalinkPluginPath']) && ($serendipity['uriArguments'][1] == $this->get_config('faqurl', 'faqs')));
    }

    function countFAQbyCid(&$cid)
    {
        global $serendipity;

        $q = "SELECT COUNT(id) AS counter
                FROM {$serendipity['dbPrefix']}faqs
               WHERE cid = $cid";
        $res =  serendipity_db_query($q, true, 'assoc');
        return $res['counter'];
    }

    function prepareMove($array)
    {
        global $serendipity;

        if (is_array($array)) {
            for ($i = 0, $ii = count($array); $i < $ii; $i++) {
                $array[$i]['down'] = (isset($array[$i]['down']) ? $array[$i]['down'] : false);
                $array[$i]['up']   = (isset($array[$i]['up']) ? $array[$i]['up'] : false);
                for ($j = ($i + 1); $j < $ii; $j++) {
                    if ($array[$j]['parent_id'] == $array[$i]['parent_id']) {
                        $array[$i]['down'] = true;
                        $array[$j]['up'] = true;
                    }
                }
            }
            return $array;
        }
        return $array;
    }

    function categoryMove(&$id, $moveto)
    {
        global $serendipity;

        $q = "SELECT catorder, parent_id
                FROM {$serendipity['dbPrefix']}faq_categorys
               WHERE id = $id";
        $old = serendipity_db_query($q, true, 'assoc');

        switch ($moveto) {
            case D_FAQ_MOVEUP:
                serendipity_db_update('faq_categorys', array('parent_id' => $old['parent_id'], 'catorder' => ($old['catorder'] - 1)), array('catorder' => $old['catorder']));
                serendipity_db_update('faq_categorys', array('id' => $id), array('catorder' => ($old['catorder'] - 1)));
                break;

            case D_FAQ_MOVEDOWN:
                serendipity_db_update('faq_categorys', array('parent_id' => $old['parent_id'], 'catorder' => ($old['catorder'] + 1)), array('catorder' => $old['catorder']));
                serendipity_db_update('faq_categorys', array('id' => $id), array('catorder' => ($old['catorder'] + 1)));
                break;

            default:
                return false;
        }
        return true;

    }

    function faqMove(&$id, &$cid, $moveto)
    {
        global $serendipity;

        $q = "SELECT faqorder
                FROM {$serendipity['dbPrefix']}faqs
               WHERE id = $id
                 AND cid = $cid";
        $old = serendipity_db_query($q, true, 'assoc');
        switch ($moveto) {
            case D_FAQ_MOVEUP:
                serendipity_db_update('faqs', array('cid' => $cid, 'faqorder' => ($old['faqorder'] - 1)), array('faqorder' => $old['faqorder']));
                serendipity_db_update('faqs', array('id' => $id), array('faqorder' => ($old['faqorder'] - 1)));
                break;
            case D_FAQ_MOVEDOWN:
                serendipity_db_update('faqs', array('cid' => $cid, 'faqorder' => ($old['faqorder'] + 1)), array('faqorder' => $old['faqorder']));
                serendipity_db_update('faqs', array('id' => $id), array('faqorder' => ($old['faqorder'] + 1)));
                break;
            default:
                return false;
        }
        return true;
    }

    function showBackend()
    {
        global $serendipity;

        if (!empty($serendipity['POST']['action'])) {
            $serendipity['GET']['action'] = &$serendipity['POST']['action'];
        }
        // S9y 1.7 Series box sizing
        $bosi  = $serendipity['version'][0] > 1 ? '' : ' class="boxsizingBorder"';
        // notification switch
        $error = $serendipity['version'][0] > 1 ? '<div class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> ' : '<div class="serendipityAdminMsgError"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png') . '" alt="" />';
        $ok    = $serendipity['version'][0] > 1 ? '<div class="msg_success"><span class="icon-ok" aria-hidden="true"></span> ' : '<div class="serendipityAdminMsgSuccess"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_success.png') . '" alt="" />';
        // iconizr by version
        $editimg  = $serendipity['version'][0] > 1 ? '<span class="icon-edit" aria-hidden="true"></span>' : '<img src="' . serendipity_getTemplateFile('admin/img/edit.png') . '" width="16" height="16" alt="EDIT" />';
        $trashimg = $serendipity['version'][0] > 1 ? '<span class="icon-trash" aria-hidden="true"></span>' : '<img src="' . serendipity_getTemplateFile('admin/img/delete.png') . '" width="16" height="16" alt="DELETE" />';
        $moveupimg = $serendipity['version'][0] > 1 ? '<img src="' . $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_faq/img/move_up.png" data-file-width="128" data-file-height="128" width="24" height="24" alt="UP" />' : '<img src="'.serendipity_getTemplateFile('admin/img/uparrow.png').'" width="16" height="16" alt="UP" />';
        $movedownimg = $serendipity['version'][0] > 1 ? '<img src="' . $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_faq/img/move_down.png" data-file-width="128" data-file-height="128" width="24" height="24" alt="DOWN" />' : '<img src="'.serendipity_getTemplateFile('admin/img/downarrow.png').'" width="16" height="16" alt="DOWN" />';

        echo "<h2>FAQs</h2>\n\n";

        switch ($serendipity['GET']['action']) {
            case 'faqs':
                if ((($serendipity['POST']['typeSave'] ?? '') == "true") && (!empty($serendipity['POST']['SAVECONF']))) {
                    $serendipity['POST']['typeSubmit'] = true;
                    $bag = new serendipity_property_bag();
                    $this->introspect($bag);
                    $name = (function_exists('serendipity_specialchars') ? serendipity_specialchars($bag->get('name')) : htmlspecialchars($bag->get('name'), ENT_COMPAT, LANG_CHARSET));
                    $desc = (function_exists('serendipity_specialchars') ? serendipity_specialchars($bag->get('description')) : htmlspecialchars($bag->get('description'), ENT_COMPAT, LANG_CHARSET));
                    $config_faq = $bag->get('configuration_faq');

                    foreach ($config_faq AS $config_item) {
                        $cbag = new serendipity_property_bag();
                        if ($this->introspect_faq_item($config_item, $cbag)) {
                            $this->faq[$config_item] = serendipity_get_bool($serendipity['POST']['plugin'][$config_item]);
                        }
                    }
                    $result = $this->updateFAQ();
                    if (is_bool($result)) {
                        echo $ok . DONE .': '. sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%H:%M:%S')) .'</div>'."\n";
                    } else {
                        echo $error . ERROR. ': ' . $result . '</div>'."\n";
                    }

                }

                if (!empty($serendipity['POST']['id'])) {
                    $serendipity['GET']['id'] = &$serendipity['POST']['id'];
                }
                if (isset($serendipity['GET']['id']) && is_numeric($serendipity['GET']['id'])) {
                    $this->fetchFAQ($serendipity['GET']['id']);
                }
                if (isset($serendipity['GET']['cid']) && !is_numeric($serendipity['GET']['cid'])) {
                    $cid = &$this->faq['cid'];
                } else {
                    $cid = &$serendipity['GET']['cid'];
                }

                echo '<div class="faq_navigator">'."\n";
                echo '    <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=faq">' . FAQ_CATEGORIES . '</a> :: <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=faq&serendipity[action]=show_faqs&serendipity[cid]='.$cid.'">' . FAQS . "</a>\n";
                echo "</div>\n\n";

                echo '<div id="backend_faq_formpage"'.$bosi.'>'."\n";
                echo '<form action="serendipity_admin.php" method="post" name="serendipityEntry">'."\n";
                echo '    <input type="hidden" name="serendipity[adminModule]" value="event_display" />'."\n";
                echo '    <input type="hidden" name="serendipity[adminAction]" value="faq" />'."\n";
                echo '    <input type="hidden" name="serendipity[action]" value="faqs" />'."\n";
                echo '    <input type="hidden" name="serendipity[typeSave]" value="true" />'."\n";
                echo '    <div class="default_faq_faqforms">'."\n";

                $this->showFAQForm(); // gathers inspectConfig items

                echo "    </div><!-- faq_faqforms end -->\n";
                echo "</form>\n";
                echo "</div>\n\n";
                break;

            case 'categories':
                echo '<div class="faq_navigator">'."\n";
                echo '    <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=faq">' . FAQ_CATEGORIES . "</a>\n";
                echo "</div>\n\n";

                if (!empty($serendipity['GET']['id'])) {
                    $serendipity['POST']['id'] = &$serendipity['GET']['id'];
                }
                if (isset($serendipity['POST']['id']) && is_numeric($serendipity['POST']['id'])) {
                    $this->fetchCategory($serendipity['POST']['id']);
                }

                if ((isset($serendipity['POST']['categorySave']) && $serendipity['POST']['categorySave'] == "true") && (!empty($serendipity['POST']['SAVECONF']))) {
                    $serendipity['POST']['categorySubmit'] = true;
                    $bag = new serendipity_property_bag();
                    $this->introspect($bag);
                    $name = (function_exists('serendipity_specialchars') ? serendipity_specialchars($bag->get('name')) : htmlspecialchars($bag->get('name'), ENT_COMPAT, LANG_CHARSET));
                    $desc = (function_exists('serendipity_specialchars') ? serendipity_specialchars($bag->get('description')) : htmlspecialchars($bag->get('description'), ENT_COMPAT, LANG_CHARSET));
                    $config_faq = $bag->get('configuration_category');
                    foreach ($config_faq AS $config_item) {
                        $cbag = new serendipity_property_bag();
                        if ($this->introspect_category_item($config_item, $cbag)) {
                            $this->category[$config_item] = serendipity_get_bool($serendipity['POST']['plugin'][$config_item]);
                        }
                    }
                    $result = $this->updateCategory();

                    if (is_bool($result)) {
                        echo $ok . DONE .': '. sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%H:%M:%S')) .'</div>'."\n";
                    } else {
                        echo $error . ERROR .': ' . $result . '</div>'."\n";
                    }

                }

                echo '<div id="backend_faq_formpage"'.$bosi.'>'."\n";
                echo '<form action="serendipity_admin.php" method="post" name="serendipityEntry">'."\n";
                echo '    <input type="hidden" name="serendipity[adminModule]" value="event_display" />'."\n";
                echo '    <input type="hidden" name="serendipity[adminAction]" value="faq" />'."\n";
                echo '    <input type="hidden" name="serendipity[action]" value="categories" />'."\n";
                echo '    <input type="hidden" name="serendipity[categorySave]" value="true" />'."\n";
                echo '    <div class="default_faq_catform">'."\n";

                $this->showCategoryForm();

                echo "    </div><!-- faq_catform end -->\n";
                echo "</form>\n";
                echo "</div>\n\n";
                break;

            case 'show_faqs':
                echo '    <div class="faq_navigator">'."\n\n";
                echo '        <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=faq">' . FAQ_CATEGORIES.'</a> :: ' . FAQS . "\n";
                echo '    </div>'."\n\n";

                if ((!empty($serendipity['POST']['faqDelete'])) && (is_numeric($serendipity['POST']['id']))) {
                    $result = $this->deleteFAQ($serendipity['POST']['id']);
                    if (is_bool($result)) {
                        echo $ok . DONE .': '. sprintf(RIP_ENTRY, $serendipity['POST']['id']) . '</div>'."\n";
                    } else {
                        echo $error . ERROR .': ' . $result . '</div>'."\n";
                    }
                }

                if (($serendipity['GET']['actiondo'] ?? '') == 'faqMoveUp') {
                    $this->faqMove($serendipity['GET']['id'], $serendipity['GET']['cid'], D_FAQ_MOVEUP);
                } elseif (($serendipity['GET']['actiondo'] ?? '') == 'faqMoveDown') {
                    $this->faqMove($serendipity['GET']['id'], $serendipity['GET']['cid'], D_FAQ_MOVEDOWN);
                }

                if (!empty($serendipity['POST']['cid'])) {
                    $serendipity['GET']['cid'] = &$serendipity['POST']['cid'];
                }

                $faqs = $this->fetchFaqByCid($serendipity['GET']['cid']);
                $faqs = $this->prepareMove($faqs);

                echo '<div id="faqBackendPage" class="faq_show_faqs">'."\n";
                if (is_array($faqs)) {
                    foreach ($faqs AS $faq) {
                        echo '    <ul class="plainList">'."\n";
                        echo '        <li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=faqs&amp;serendipity[cid]='.$serendipity['GET']['cid'].'&amp;serendipity[id]='.$faq['id'].'" title="' . EDIT . '">'.$editimg.'</a></li>'."\n";
                        echo '        <li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=deleteFAQ&amp;serendipity[cid]='.$serendipity['GET']['cid'].'&amp;serendipity[id]='.$faq['id'].'" title="' . DELETE . '">'.$trashimg.'</a></li>'."\n";
                        echo '        <li class="fixed col"><img alt="question.svg" title="question title" src="' . $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_faq/img/question.svg.png" data-file-width="240" data-file-height="240" height="24" width="24">&nbsp;'.$faq['question'].'</li>'."\n";
                        echo '        <li'.(($faq['up'] == true) ? ('><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=show_faqs&amp;serendipity[actiondo]=faqMoveUp&amp;serendipity[cid]='.$serendipity['GET']['cid'].'&amp;serendipity[id]='.$faq['id'].'" title="'.MOVE_UP.'">'.$moveupimg.'</a>') : ' class="empty">&nbsp;').'</li>'."\n";
                        echo '        <li'.(($faq['down'] == true) ? ('><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=show_faqs&amp;serendipity[actiondo]=faqMoveDown&amp;serendipity[cid]='.$serendipity['GET']['cid'].'&amp;serendipity[id]='.$faq['id'].'" title="'.MOVE_DOWN.'">'.$movedownimg.'</a>') : ' class="empty">&nbsp;').'</li>'."\n";
                        echo "    </ul>\n";
                    }
                }
                echo '    <div class="clear action_field">'."\n";
                echo '        <a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=faqs&amp;serendipity[cid]='.$serendipity['GET']['cid'].'" class="serendipityPrettyButton button_link">'.FAQ_NEWFAQ.'</a>'."\n";
                echo "    </div>\n";
                echo "</div>\n";
                break;

            case 'deleteCategory':
                if (is_numeric($serendipity['GET']['id'])) {
                    echo '<form action="serendipity_admin.php" method="post" name="serendipityEntry">'."\n";
                    echo "    <div>";
                    echo '        <input type="hidden" name="serendipity[adminModule]" value="event_display" />'."\n";
                    echo '        <input type="hidden" name="serendipity[adminAction]" value="faq" />'."\n";
                    echo '        <input type="hidden" name="serendipity[id]" value="'.$serendipity['GET']['id'].'" />'."\n";
                    echo "    </div>";
                    echo '    <strong>'. FAQ_CATEGORIES. '</strong><br /><br />'."\n";
                    echo '    '.FAQ_REALYDELETECATEGORY."&nbsp;\n";
                    echo '    <input class="serendipityPrettyButton input_button" type="submit" name="serendipity[categoryDelete]" value="'.YES.'" /> &nbsp; <input class="serendipityPrettyButton input_button" type="submit" name="" value="'.NO.'" />'."\n";
                    echo "</form>\n\n";
                }
                break;

            case 'deleteFAQ':
                if (is_numeric($serendipity['GET']['id'])) {
                    echo '<form action="serendipity_admin.php" method="post" name="serendipityEntry">'."\n";
                    echo "    <div>";
                    echo '        <input type="hidden" name="serendipity[adminModule]" value="event_display" />'."\n";
                    echo '        <input type="hidden" name="serendipity[adminAction]" value="faq" />'."\n";
                    echo '        <input type="hidden" name="serendipity[action]" value="show_faqs" />'."\n";
                    echo '        <input type="hidden" name="serendipity[id]" value="'.$serendipity['GET']['id'].'" />'."\n";
                    echo '        <input type="hidden" name="serendipity[cid]" value="'.$serendipity['GET']['cid'].'" />'."\n";
                    echo "    </div>";
                    echo '    <strong>'. FAQ_CATEGORIES. '</strong><br /><br />';
                    echo '    '.FAQ_REALYDELETECATEGORY."&nbsp;\n";
                    echo '    <input class="serendipityPrettyButton input_button" type="submit" name="serendipity[faqDelete]" value="'.YES.'" /> &nbsp; <input class="serendipityPrettyButton input_button" type="submit" name="" value="'.NO.'" />'."\n";
                    echo "</form>\n\n";
                }
                break;

            default:
                if (isset($serendipity['GET']['cat_lang'])) {
                    $this_cat_lang = &$serendipity['GET']['cat_lang'];
                } else {
                    $this_cat_lang = &$serendipity['lang'];
                }

                if ($serendipity['GET']['action'] == 'category_moveup') {
                    $this->categoryMove($serendipity['GET']['id'], D_FAQ_MOVEUP);
                } elseif ($serendipity['GET']['action'] == 'category_movedown') {
                    $this->categoryMove($serendipity['GET']['id'], D_FAQ_MOVEDOWN);
                }

                echo '<h4>'.FAQ_CATEGORIES.' (<span>'.$serendipity['languages'][$this_cat_lang]."</span>)</h4>\n\n";

                if ((!empty($serendipity['POST']['categoryDelete'])) && (is_numeric($serendipity['POST']['id']))) {

                    $faqs = $this->fetchFaqByCid($serendipity['POST']['id']);
                    if (is_array($faqs)) {
                        foreach ($faqs AS $faq) {
                            $this->deleteFAQ($faq['id']);
                        }
                    }
                    $result = $this->deleteCategory($serendipity['POST']['id']);
                    if (is_bool($result)) {
                        echo $ok . DONE .': '. sprintf(RIP_ENTRY, $serendipity['POST']['id']) . '</div>'."\n";
                    } else {
                        echo $error . ERROR .': ' . $result . '</div>'."\n";
                    }

                }

                echo '<div id="faqBackendPage" class="faq_start_page">'."\n";

                // LANG NAVI
                $lang_links = '';
                foreach ($serendipity['languages'] AS $lang_key => $lang_value) {
                    if (strlen($lang_links)) {
                        $lang_links .= '&nbsp;';
                    }
                    if ($this_cat_lang == $lang_key) {
                        $lang_links .= '<span class="faq_lang">';
                    }
                    $lang_links .= '<a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[cat_lang]='.$lang_key.'">'.$lang_key.'</a>';
                    if ($this_cat_lang == $lang_key) {
                        $lang_links .= '</span>'."\n";
                    } else $lang_links .= "\n";

                }
                echo '    <div class="faq_lang_navigation">'."\n\n";
                echo $lang_links;
                echo '    </div>'."\n\n";

                $fcats = $this->fetchCategories($this_cat_lang);

                echo '    <div class="faq_catbylang">'."\n";
                // WALK CATEGORIES
                if (is_array($fcats)) {
                    $fcats = serendipity_walkRecursive($fcats);
                    $fcats = $this->prepareMove($fcats);
                    foreach ($fcats AS $category) {
                        echo '        <ul class="plainList">'."\n";
                        echo '            <li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=categories&amp;serendipity[id]='.$category['id'].'&amp;serendipity[cat_lang]='.$this_cat_lang.'" title="' . EDIT . '">'.$editimg.'</a></li>'."\n";
                        echo '            <li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=deleteCategory&amp;serendipity[id]='.$category['id'].'" title="' . DELETE . '">'.$trashimg.'</a></li>'."\n";
                        echo '            <li class="fixed" style="padding-left:'.(1.5 * $category['depth']).'em"><img alt="category" title="category depth" src="' . $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_faq/img/category.png" data-file-width="128" data-file-height="128" height="24" width="24">&nbsp;<a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=show_faqs&amp;serendipity[cid]='.$category['id'].'">'.$category['category'].'</a></li>'."\n";
                        echo '            <li class="fixed">'.$this->countFAQbyCid($category['id']).' '.FAQ_NAME.'</li>'."\n";
                        echo '            <li'.(($category['up'] == true) ? ('><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=category_moveup&amp;serendipity[id]='.$category['id'].'" title="'.MOVE_UP.'">'.$moveupimg.'</a>') : ' class="empty">&nbsp;').'</li>'."\n";
                        echo '            <li'.(($category['down'] == true) ? ('><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=category_movedown&amp;serendipity[id]='.$category['id'].'" title="'.MOVE_DOWN.'">'.$movedownimg.'</a>') : ' class="empty">&nbsp;').'</li>'."\n";
                        echo "        </ul>\n";
                    }
                }
                echo '    </div>'."\n\n";

                echo '    <div class="clear action_field">'."\n";
                echo '        <a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=categories&amp;serendipity[cat_lang]='.$this_cat_lang.'" class="serendipityPrettyButton button_link">'.FAQ_NEWCATEGORY.'</a>'."\n";
                echo "    </div>\n\n";

                echo "</div>\n";
                break;
        }
    }

    /**
     * This method is the external_plugin wrapper
     */
    function showFrontend()
    {
        global $serendipity;

        header('Content-Type: text/html; charset=' . LANG_CHARSET);
        include_once(S9Y_INCLUDE_PATH . 'include/genpage.inc.php');

        if (isset($serendipity['uriArguments'][2]) && is_string($serendipity['uriArguments'][2]) && isset($serendipity['languages'][$serendipity['uriArguments'][2]])) {
            $faq_language   = $serendipity['uriArguments'][2];
            $faq_categoryid = $serendipity['uriArguments'][3];
            $faq_faqid      = $serendipity['uriArguments'][4];
        } else {
            $faq_language   = $serendipity['lang'];
            $faq_categoryid = $serendipity['uriArguments'][2] ?? null;
            $faq_faqid      = $serendipity['uriArguments'][3] ?? null;
        }

        if (is_numeric($faq_categoryid)) {
            $res['parent_id'] = (int)$faq_categoryid;
            do {
                $q = "SELECT id, category, parent_id
                        FROM {$serendipity['dbPrefix']}faq_categorys
                       WHERE id = " . $res['parent_id'];
                $res = serendipity_db_query($q, true, 'assoc');
                $cat_tree[] = $res;
            } while ($res['parent_id'] != 0);

            krsort($cat_tree);
            $serendipity['smarty']->assign('cat_tree', $cat_tree);

            if (is_numeric($faq_faqid)) {
                $q = "SELECT question, answer, category, faqorder, catorder, parent_id
                        FROM {$serendipity['dbPrefix']}faqs, {$serendipity['dbPrefix']}faq_categorys
                       WHERE {$serendipity['dbPrefix']}faqs.id = $faq_faqid
                         AND {$serendipity['dbPrefix']}faqs.cid = {$serendipity['dbPrefix']}faq_categorys.id
                    ORDER BY faqorder";
                $faq = serendipity_db_query($q, true, 'assoc');

                if (is_array($faq) && !empty($faq)) {
                    $faqorder = ($faq['faqorder'] + 1);
                    $q = "SELECT {$serendipity['dbPrefix']}faqs.id, question, cid, category
                            FROM {$serendipity['dbPrefix']}faqs, {$serendipity['dbPrefix']}faq_categorys
                           WHERE {$serendipity['dbPrefix']}faqs.cid = $faq_categoryid
                             AND {$serendipity['dbPrefix']}faqs.faqorder = $faqorder
                             AND {$serendipity['dbPrefix']}faqs.cid = {$serendipity['dbPrefix']}faq_categorys.id";
                    $nfaq = serendipity_db_query($q, true, 'assoc');

                    if (!is_array($nfaq)) {
                        $catorder = ($faq['catorder'] + 1);
                        $q = "SELECT {$serendipity['dbPrefix']}faqs.id, question, cid, category
                                FROM {$serendipity['dbPrefix']}faqs, {$serendipity['dbPrefix']}faq_categorys
                               WHERE {$serendipity['dbPrefix']}faq_categorys.catorder = $catorder
                                 AND {$serendipity['dbPrefix']}faq_categorys.parent_id = {$faq['parent_id']}
                                 AND {$serendipity['dbPrefix']}faqs.faqorder = 1
                                 AND {$serendipity['dbPrefix']}faqs.cid = {$serendipity['dbPrefix']}faq_categorys.id";
                        $nfaq = serendipity_db_query($q, true, 'assoc');
                    }

                    $faqorder = ($faq['faqorder'] - 1);
                    $q = "SELECT {$serendipity['dbPrefix']}faqs.id, question, cid, category
                            FROM {$serendipity['dbPrefix']}faqs, {$serendipity['dbPrefix']}faq_categorys
                           WHERE {$serendipity['dbPrefix']}faqs.cid = $faq_categoryid
                             AND {$serendipity['dbPrefix']}faqs.faqorder = $faqorder
                             AND {$serendipity['dbPrefix']}faqs.cid = {$serendipity['dbPrefix']}faq_categorys.id";
                    $pfaq = serendipity_db_query($q, true, 'assoc');

                    if (!is_array($pfaq)) {
                        $catorder = ($faq['catorder'] - 1);
                        $q = "SELECT MAX(faqorder) AS fmax
                                FROM {$serendipity['dbPrefix']}faqs, {$serendipity['dbPrefix']}faq_categorys
                               WHERE {$serendipity['dbPrefix']}faq_categorys.catorder = $catorder
                                 AND {$serendipity['dbPrefix']}faq_categorys.parent_id = {$faq['parent_id']}
                                 AND {$serendipity['dbPrefix']}faqs.cid = {$serendipity['dbPrefix']}faq_categorys.id";
                        $max = serendipity_db_query($q, true, 'assoc');

                        $q = "SELECT {$serendipity['dbPrefix']}faqs.id, question, cid, category
                                FROM {$serendipity['dbPrefix']}faqs, {$serendipity['dbPrefix']}faq_categorys
                               WHERE {$serendipity['dbPrefix']}faq_categorys.catorder = $catorder
                                 AND {$serendipity['dbPrefix']}faqs.faqorder = ".($max['fmax'] ? $max['fmax'] : 0)."
                                 AND {$serendipity['dbPrefix']}faqs.cid = {$serendipity['dbPrefix']}faq_categorys.id";
                        $pfaq = serendipity_db_query($q, true, 'assoc');
                    }
                }

                if (serendipity_db_bool($this->get_config('markup', 'true'))) {
                    $entry['body'] = &$faq['question'];
                    serendipity_plugin_api::hook_event('frontend_display', $entry);
                    $entry['body'] = &$faq['answer'];
                    serendipity_plugin_api::hook_event('frontend_display', $entry);
                }

                $filename = 'plugin_faq_category_faq.tpl';

                $serendipity['smarty']->assign('faq_plugin', array(
                    'this_faq' => array(
                        'faqid'      => $faq_faqid,
                        'question'   => $faq['question'],
                        'answer'     => $faq['answer'],
                        'categoryid' => $faq_categoryid,
                        'category'   => $faq['category']
                    ),
                    'next_faq' => $nfaq ? array(
                        'faqid'      => $nfaq['id'],
                        'question'   => $nfaq['question'],
                        'categoryid' => $nfaq['cid'],
                        'category'   => $nfaq['category']
                    ) : array(),
                    'prev_faq' => $pfaq ? array(
                        'faqid'      => $pfaq['id'],
                        'question'   => $pfaq['question'],
                        'categoryid' => $pfaq['cid'],
                        'category'   => $pfaq['category']
                    ) : array()
                    
                ));

            } else {
                $q = "SELECT id, cid, question, changedate, changetype
                        FROM {$serendipity['dbPrefix']}faqs
                       WHERE cid = $faq_categoryid
                    ORDER BY faqorder";
                $faqs = serendipity_db_query($q, false, 'assoc');

                if (is_array($faqs)) {
                    $now = time();
                    $days_new = ($this->get_config('daysnew') * 86400);
                    $days_upd = ($this->get_config('daysupdate') * 86400);
                    for ($i = 0, $ii = count($faqs); $i < $ii; $i++) {
                        switch ($faqs[$i]['changetype']) {
                            case 'new':
                                if (($now - $faqs[$i]['changedate']) <= $days_new) {
                                    $faqs[$i]['status'] = FAQ_NEW;
                                } else {
                                    $faqs[$i]['status'] = '';
                                }
                                break;

                            case 'update':
                                if (($now - $faqs[$i]['changedate']) <= $days_upd) {
                                    $faqs[$i]['status'] = FAQ_UPDATE;
                                } else {
                                    $faqs[$i]['status'] = '';
                                }
                                break;

                            default:
                                $faqs[$i]['status'] = '';
                                break;
                        }
                    }
                }

                $q = "SELECT id, category
                        FROM {$serendipity['dbPrefix']}faq_categorys
                       WHERE parent_id = $faq_categoryid
                    ORDER BY catorder";
                $scat = serendipity_db_query($q, false, 'assoc');

                $q = "SELECT category, introduction
                        FROM {$serendipity['dbPrefix']}faq_categorys
                       WHERE id = " . $faq_categoryid;
                $cat = serendipity_db_query($q, true, 'assoc');

                $filename = 'plugin_faq_category_faqs.tpl';

                if (serendipity_db_bool($this->get_config('markup', 'true'))) {
                    $entry['body'] = &$cat['introduction'];
                    serendipity_plugin_api::hook_event('frontend_display', $entry);
                }

                $serendipity['smarty']->assign('faq_plugin', array(
                    'faqs'          => $faqs,
                    'subcategories' => $scat,
                    'category'      => $cat['category'],
                    'introduction'  => $cat['introduction'],
                    'catid'         => $faq_categoryid
                ));
            }
        } else {
            $q = "SELECT *
                    FROM {$serendipity['dbPrefix']}faq_categorys
                   WHERE language = '$faq_language'
                ORDER BY catorder";
            $cats = serendipity_db_query($q, false, 'assoc');

            if (is_array($cats)) {
                $cats = serendipity_walkRecursive($cats);
                if (serendipity_db_bool($this->get_config('markup', 'true'))) {
                    for ($i = 0, $ii = count($cats); $i < $ii; $i++) {
                        $entry['body'] = &$cats[$i]['introduction'];
                        serendipity_plugin_api::hook_event('frontend_display', $entry);
                    }
                }

                $serendipity['smarty']->assign('faq_plugin', array(
                    'categories' => $cats
                ));
            }
            $filename = 'plugin_faq_categories.tpl';
        }

        if ($serendipity['rewrite'] == 'none') {
            $pluginpath = $serendipity['indexFile'].'?/'.$serendipity['permalinkPluginPath'].'/'.$this->get_config('faqurl', 'faqs');
        } else {
            $pluginpath = $serendipity['permalinkPluginPath'].'/'.$this->get_config('faqurl', 'faqs');
        }

        $serendipity['smarty']->append('faq_plugin',
            array(
                'plugin_url' => trim($pluginpath)
            ), true);

        $content = $this->parseTemplate($filename);
        $serendipity['smarty']->assign('CONTENT', $content);
        // redirect out via index.tpl
        $serendipity['smarty']->display(serendipity_getTemplateFile($serendipity['smarty_file'], 'serendipityPath'));
    }

    function showSearch()
    {
        global $serendipity;

        $term = serendipity_db_escape_string($serendipity['GET']['searchTerm']);

        if ($serendipity['dbType'] == 'postgres') {
            $group     = '';
            $distinct  = 'DISTINCT';
            $find_part = "(question ILIKE '%$term%' OR answer ILIKE '%$term%')";
        } elseif (stristr($serendipity['dbType'], 'sqlite') !== FALSE) {
            $group     = 'GROUP BY id';
            $distinct  = '';
            $term      = serendipity_mb('strtolower', $term);
            $find_part = "(lower(question) LIKE '%$term%' OR lower(answer) LIKE '%$term%')";
        } else { // MYSQL
            $group     = 'GROUP BY id';
            $distinct  = '';
            $term      = str_replace('&quot;', '"', $term);
            if (preg_match('@["\+\-\*~<>\(\)]+@', $term)) {
                $find_part = "MATCH(question,answer) AGAINST('$term' IN BOOLEAN MODE)";
            } else {
                $find_part = "MATCH(question,answer) AGAINST('$term')";
            }
        }

        $querystring = "SELECT $distinct f.*
                          FROM {$serendipity['dbPrefix']}faqs AS f
                         WHERE $find_part
                               $group
                      ORDER BY changedate DESC";
        $results = serendipity_db_query($querystring);

        if (!is_array($results)) {
            if ($results !== 1 && $results !== true) {
                echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($results) : htmlspecialchars($results, ENT_COMPAT, LANG_CHARSET));
            }
            $results = array();
        }

        if ($serendipity['rewrite'] == 'none') {
            $pluginpath = $serendipity['indexFile'].'?/'.$serendipity['permalinkPluginPath'].'/'.$this->get_config('faqurl', 'faqs');
        } else {
            $pluginpath = $serendipity['permalinkPluginPath'].'/'.$this->get_config('faqurl', 'faqs');
        }

        $serendipity['smarty']->assign(
            array(
                'faq_searchresults' => count($results),
                'faq_results'       => $results,
                'faq_pluginpath'    => $pluginpath
            )
        );

        $filename = 'plugin_faq_searchresults.tpl';
        $content = $this->parseTemplate($filename);
        echo $content;
    }

    function showFAQForm()
    {
        global $serendipity, $inspectConfig;

        if (file_exists(S9Y_INCLUDE_PATH.'include/functions_entries_admin.inc.php')) {
            include_once(S9Y_INCLUDE_PATH.'include/functions_entries_admin.inc.php');
        }

        // call moduled abstract class
        if (!is_callable('inspectConfig')) {
            require_once dirname(__FILE__).'/class_inspectConfig.php';
        }
        $elcount = 0;
        $htmlnugget = array();
        $inspectConfig = array();
        // add some $serendipity items to check for
        $inspectConfig['s9y']['wysiwyg'] = $serendipity['wysiwyg'] ?? null;
        $inspectConfig['s9y']['version'] = $serendipity['version'][0];
        $inspectConfig['s9y']['nl2br']['iso2br'] = $serendipity['nl2br']['iso2br'];
        $inspectConfig['s9y']['plugin_path'] = $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_faq/';

        foreach ($this->config_faq AS $config_item) {
            $elcount++;
            #$inspectConfig['config_value'] = $config_value = $this->faq[$config_item]; // no use, why was it set?
            $cbag = new serendipity_property_bag();
            $this->introspect_faq_item($config_item, $cbag);

            $inspectConfig['cname'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($cbag->get('name')) : htmlspecialchars($cbag->get('name'), ENT_COMPAT, LANG_CHARSET));
            $inspectConfig['cdesc'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($cbag->get('description')) : htmlspecialchars($cbag->get('description'), ENT_COMPAT, LANG_CHARSET));
            $inspectConfig['value'] = $value = $this->getFaq($config_item, 'unset'); // case hidden
            $inspectConfig['lang_direction'] = $lang_direction = (function_exists('serendipity_specialchars') ? serendipity_specialchars($cbag->get('lang_direction')) : htmlspecialchars($cbag->get('lang_direction'), ENT_COMPAT, LANG_CHARSET));

            $type = $cbag->get('type');
            if (empty($lang_direction)) {
                $inspectConfig['lang_direction'] = LANG_DIRECTION;
            }
            if ($value === 'unset') {
                $inspectConfig['value'] = $value = $cbag->get('default'); // check prop type default for alles cases, except case hidden language and id and cid!
            }
            // check the special cases
            if (($config_item == 'language' || $config_item == 'id' || $config_item == 'cid')
                    && $type == 'hidden' && trim($value ?? '') == '') {
                $inspectConfig['value'] = $value = $cbag->get('value'); // case 'language' prop type hidden 'default' = 'value'!
            }

            $hvalue =   (!isset($serendipity['POST']['faqSubmit']) && isset($serendipity['POST']['plugin'][$config_item])
                            ? (function_exists('serendipity_specialchars')
                                    ? serendipity_specialchars($serendipity['POST']['plugin'][$config_item])
                                    : htmlspecialchars($serendipity['POST']['plugin'][$config_item], ENT_COMPAT, LANG_CHARSET)
                               )
                            : (function_exists('serendipity_specialchars')
                                ? serendipity_specialchars($value)
                                : htmlspecialchars($value, ENT_COMPAT, LANG_CHARSET))
                        );

            $inspectConfig['config_item']   = $config_item;
            $inspectConfig['elcount']       = $elcount;
            $inspectConfig['hvalue']        = $hvalue;
            $inspectConfig['radio']         = $radio    = array();
            $inspectConfig['select']        = $select   = array();
            $inspectConfig['per_row']       = $per_row  = null;
            $inspectConfig['type']          = $type;
            $inspectConfig['default']       = $default  = $cbag->get('default'); // case default
            $inspectConfig['radio']         = $radio    = $cbag->get('radio'); // case radio
            $inspectConfig['per_row']       = $per_row  = $cbag->get('radio_per_row'); // case radio
            $inspectConfig['select_values'] = $select_values   = $cbag->get('select_values'); // case select

            if ($type) {
                echo "<!-- modul-type::$type - class_inspectConfig.php -->\n"; // tag dynamic form items
                $ctype = 'ic'.ucfirst($type);
                ${$ctype} = new $ctype();
                if ($type == 'text' && ($serendipity['wysiwyg'] ?? false)) {
                    $htmlnugget[] = $elcount;
                    serendipity_emit_htmlarea_code('nuggets', 'nuggets', true);
                }
            }

        } //foreach config_faq AS config_item end

        if (isset($serendipity['wysiwyg']) && $serendipity['wysiwyg'] && count($htmlnugget) > 0) {
            $ev = array('nuggets' => $htmlnugget, 'skip_nuggets' => false);
            serendipity_plugin_api::hook_event('backend_wysiwyg_nuggets', $ev);

            if ($ev['skip_nuggets'] === false) {
?>
        <script type="text/javascript">
        function Spawnnugget() {
        <?php foreach($htmlnugget AS $htmlnuggetid) { ?>
            Spawnnuggets('<?php echo $htmlnuggetid; ?>');
        <?php } ?>
        }
        </script>

<?php
            }
        }

        if ($serendipity['version'][0] < 2) {
?>

        <div style="margin-top: 1em; padding-left: 20px">
            <input class="serendipityPrettyButton input_button" type="submit" name="serendipity[SAVECONF]" value="<?php echo SAVE; ?>" />
        </div>

<?php
        } else {
?>

        <div class="clear form_field submit_set">
            <input class="state_submit" type="submit" name="serendipity[SAVECONF]" value="<?php echo SAVE; ?>">
        </div>

<?php
        }
    } // showFAQForm() end

    function showCategoryForm()
    {
        global $serendipity, $inspectConfig;

        if (file_exists(S9Y_INCLUDE_PATH.'include/functions_entries_admin.inc.php')){
            include_once(S9Y_INCLUDE_PATH.'include/functions_entries_admin.inc.php');
        }

        // call moduled abstract class
        if (!is_callable('inspectConfig')) {
            require_once dirname(__FILE__).'/class_inspectConfig.php';
        }

        $elcount = 0;
        $htmlnugget = array();
        $inspectConfig = array();
        // add some $serendipity items to check for
        $inspectConfig['s9y']['wysiwyg'] = $serendipity['wysiwyg'] ?? null;
        $inspectConfig['s9y']['version'] = $serendipity['version'][0];
        $inspectConfig['s9y']['nl2br']['iso2br'] = $serendipity['nl2br']['iso2br'];
        $inspectConfig['s9y']['plugin_path'] = $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_faq/';

        foreach ($this->config_category AS $config_item) {
            $elcount++;
            #$inspectConfig['config_value'] = $config_value = $this->category[$config_item]; // no use, why was it set?
            $cbag = new serendipity_property_bag();
            $this->introspect_category_item($config_item, $cbag);

            $inspectConfig['cname'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($cbag->get('name')) : htmlspecialchars($cbag->get('name'), ENT_COMPAT, LANG_CHARSET));
            $inspectConfig['cdesc'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($cbag->get('description')) : htmlspecialchars($cbag->get('description'), ENT_COMPAT, LANG_CHARSET));
            $inspectConfig['value'] = $value = $this->getCategory($config_item, 'unset'); // case hidden
            $inspectConfig['lang_direction'] = $lang_direction = (function_exists('serendipity_specialchars') ? serendipity_specialchars($cbag->get('lang_direction')) : htmlspecialchars($cbag->get('lang_direction'), ENT_COMPAT, LANG_CHARSET));

            $type = $cbag->get('type');
            if (empty($lang_direction)) {
                $inspectConfig['lang_direction'] = LANG_DIRECTION;
            }
            if ($value === 'unset') {
                $inspectConfig['value'] = $value = $cbag->get('default'); // check prop type default for alles cases, except case hidden language and id and cid!
            }
            // check the special cases
            if (($config_item == 'language' || $config_item == 'id' || $config_item == 'cid')
                    && $type == 'hidden' && trim($value ?? '') == '') {
                $inspectConfig['value'] = $value = $cbag->get('value'); // case 'language' prop type hidden 'default' = 'value'!
            }

            $hvalue =   (!isset($serendipity['POST']['categorySubmit']) && isset($serendipity['POST']['plugin'][$config_item])
                            ? (function_exists('serendipity_specialchars')
                                    ? serendipity_specialchars($serendipity['POST']['plugin'][$config_item])
                                    : htmlspecialchars($serendipity['POST']['plugin'][$config_item], ENT_COMPAT, LANG_CHARSET)
                               )
                            : (function_exists('serendipity_specialchars')
                                ? serendipity_specialchars($value)
                                : htmlspecialchars($value, ENT_COMPAT, LANG_CHARSET))
                        );

            $inspectConfig['config_item']   = $config_item;
            $inspectConfig['elcount']       = $elcount;
            $inspectConfig['hvalue']        = $hvalue;
            $inspectConfig['radio']         = $radio    = array();
            $inspectConfig['select']        = $select   = array();
            $inspectConfig['per_row']       = $per_row  = null;
            $inspectConfig['type']          = $type;
            $inspectConfig['default']       = $default  = $cbag->get('default'); // case default
            $inspectConfig['radio']         = $radio    = $cbag->get('radio'); // case radio
            $inspectConfig['per_row']       = $per_row  = $cbag->get('radio_per_row'); // case radio
            $inspectConfig['select_values'] = $select_values   = $cbag->get('select_values'); // case select

            if ($type) {
                echo "<!-- modul-type::$type - class_inspectConfig.php -->\n"; // tag dynamic form items
                $ctype = 'ic'.ucfirst($type);
                
                ${$ctype} = new $ctype();
                if ($type == 'text' && ($serendipity['wysiwyg'] ?? false)) {
                    $htmlnugget[] = $elcount;
                    serendipity_emit_htmlarea_code('nuggets', 'nuggets', true);
                }
            }

        } //foreach config_category AS config_item end

        if (isset($serendipity['wysiwyg']) && $serendipity['wysiwyg'] && count($htmlnugget) > 0) {
            $ev = array('nuggets' => $htmlnugget, 'skip_nuggets' => false);
            serendipity_plugin_api::hook_event('backend_wysiwyg_nuggets', $ev);

            if ($ev['skip_nuggets'] === false) {
?>
        <script type="text/javascript">
        function Spawnnugget() {
        <?php foreach($htmlnugget AS $htmlnuggetid) { ?>
            Spawnnuggets('<?php echo $htmlnuggetid; ?>');
        <?php } ?>
        }
        </script>

<?php
            }
        }

        if ($serendipity['version'][0] < 2) {
?>

        <div style="margin-top: 1em; padding-left: 20px">
            <input class="serendipityPrettyButton input_button" type="submit" name="serendipity[SAVECONF]" value="<?php echo SAVE; ?>" />
        </div>

<?php
        } else {
?>
        <div class="clear form_field submit_set">
            <input class="state_submit" type="submit" name="serendipity[SAVECONF]" value="<?php echo SAVE; ?>">
        </div>

<?php
        }
    } // showCategoryForm() end

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks =& $bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch ($event) {
                case 'genpage':
                    break;

                case 'entry_display':
                    if ($this->isFaq()) {
                        if (is_array($eventData)) {
                            $eventData['clean_page'] = true; // This is important to not display an entry list!
                        } else {
                            $eventData = array('clean_page' => true);
                        }
                    }
                    break;

                case 'backend_sidebar_entries':
                    // forbid entry if not admin
                    #if (!serendipity_userLoggedIn() && $_SESSION['serendipityAuthedUser'] !== true && $_SESSION['serendipityUserlevel'] != '255') {
                    #    break;
                    #}
                    if ($serendipity['version'][0] < 2) {
                        $this->setupDB();
                        echo "\n".'                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq">' . FAQ_NAME . '</a></li>';
                    }
                    break;

                case 'backend_sidebar_admin_appearance':
                    // forbid entry if not admin
                    #if (!serendipity_userLoggedIn() && $_SESSION['serendipityAuthedUser'] !== true && $_SESSION['serendipityUserlevel'] != '255') {
                    #    break;
                    #}
                    if ($serendipity['version'][0] > 1) {
                        $this->setupDB();
                        echo "\n".'                        <li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq">' . FAQ_NAME . '</a></li>'."\n";
                    }
                    break;

                case 'backend_sidebar_entries_event_display_faq':
                    $this->showBackend();
                    break;

                case 'external_plugin':
                    if ($this->isFaq()) {
                        $this->showFrontend();
                    }
                    break;

                case 'css_backend':
                    if (strpos($eventData, '#serendipityFAQNav') === false) {
                        $filename = 'style_faq_backend.css';
                        $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
                        if (!$tfile || $tfile == $filename) {
                            $tfile = dirname(__FILE__) . '/' . $filename;
                        }
                        $eventData .= file_get_contents($tfile);
                    }
                    break;

                case 'css':
                    if (strpos($eventData, '#serendipityFAQNav') === false) {
                        $filename = 'style_faq_frontend.css';
                        $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
                        if (!$tfile || $tfile == $filename) {
                            $tfile = dirname(__FILE__) . '/' . $filename;
                        }
                        $eventData .= file_get_contents($tfile);
                    }
                    break;

                case 'entries_footer':
                    if ($serendipity['GET']['action'] == 'search') {
                        $this->showSearch();
                    }
                    break;

                default:
                    return false;
            }
            return true;
        }
        return false;
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>