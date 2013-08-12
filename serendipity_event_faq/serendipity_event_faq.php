<?php # 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include($probelang);
}

include(dirname(__FILE__)).'/lang_en.inc.php';

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
        $propbag->add('author',       'Falk Doering');
        $propbag->add('version',      '1.12');
        $propbag->add('copyright',    'LGPL');
        $propbag->add('stackable',    false);
        $propbag->add('requirements', array(
            'serendipity'   => '0.9',
            'smarty'        => '2.6.7',
            'php'           => '4.1.0'
        ));
        $propbag->add('groups',                 array('FRONTEND_FEATURES'));
        $propbag->add('configuration_faq',      $this->config_faq);
        $propbag->add('configuration_category', $this->config_category);
        $propbag->add('configuration',          array('markup', 'daysnew', 'daysupdate', 'faqurl' ));
        $propbag->add('event_hooks',            array(
            'backend_sidebar_entries_event_display_faq' => true,
            'backend_sidebar_entries'                   => true,
            'external_plugin'                           => true,
            'entry_display'                             => true,
            'genpage'                                   => true,
            'css_backend'                               => true,
            'css'                                       => true,
            'entries_footer'                            => true
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
                $propbag->add('default',     true);
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
                $propbag->add('value',          (empty($this->faq['cid']) ? $serendipity['GET']['cid'] : $this->faq['cid']));
                break;

            case 'id':
                $propbag->add('type',           'hidden');
                $propbag->add('value',          $this->faq['id']);
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
                $propbag->add('value',          $this->category['id']);
                break;

            case 'parent_id':
                $propbag->add('type',           'select');
                $propbag->add('name',           FAQ_PID);
                $propbag->add('description',    FAQ_PID_PID);
                $propbag->add('select_values',  $this->getCategories($serendipity['GET']['cat_lang']));
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
                $propbag->add('value',        $serendipity['GET']['cat_lang']);
                break;

            default:
                return false;
        }
        return true;
    }

    /**
     *
     * Get categories data
     *
     * Select all categories stroed in the faq categories table.
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
            foreach ($cats as $cat) {
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
                FROM ".$serendipity['dbPrefix']."faq_categorys
               WHERE language = '$lang'
            ORDER BY catorder";
        return serendipity_db_query($q, false, 'assoc');
    }


    function setupDB()
    {
        global $serendipity;

        $db = $this->get_config('db_built', 0);
        switch ($db) {
            case 0:
                $q = 'CREATE TABLE '.$serendipity['dbPrefix'].'faqs (
                        id {AUTOINCREMENT} {PRIMARY},
                        cid int(11) default 0,
                        faqorder int(11) default 0,
                        question text,
                        answer text
                ) {UTF_8}';
                serendipity_db_schema_import($q);
                $q = "CREATE TABLE ".$serendipity['dbPrefix']."faq_categorys (
                        id {AUTOINCREMENT} {PRIMARY},
                        parent_id int(11) not null default 0,
                        catorder int(11) default 0,
                        category varchar(255) not null,
                        introduction text
                ) {UTF_8}";
                serendipity_db_schema_import($q);
            case 1:
                $q = 'ALTER TABLE '.$serendipity['dbPrefix'].'faqs ADD COLUMN changedate int(11) default 0';
                serendipity_db_schema_import($q);
                $q = 'ALTER TABLE '.$serendipity['dbPrefix'].'faqs ADD COLUMN changetype varchar(10)';
                serendipity_db_schema_import($q);
            case 2:
                $q = 'CREATE {FULLTEXT_MYSQL} INDEX faqentry_idx on '.$serendipity['dbPrefix'].'faqs (question, answer)';
                serendipity_db_schema_import($q);
            case 3:
                $q = 'ALTER TABLE '.$serendipity['dbPrefix'].'faq_categorys ADD COLUMN language varchar(2)';
                serendipity_db_schema_import($q);
                serendipity_db_update('faq_categorys', array(), array('language' => $serendipity['language']));
                $this->set_config('db_built', 4);
                break;
        }

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
            $q = 'SELECT COUNT(id) AS counter
                    FROM '.$serendipity['dbPrefix'].'faqs
                   WHERE cid = '.$this->faq['cid'];
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

        $q = 'SELECT cid, faqorder
                FROM '.$serendipity['dbPrefix'].'faqs
               WHERE id = '.$id;
        $res = serendipity_db_query($q, true, 'assoc');
        $q = 'DELETE FROM '.$serendipity['dbPrefix'].'faqs
               WHERE id = '.$id;
        if (serendipity_db_query($q)) {
            $q = 'UPDATE '.$serendipity['dbPrefix'].'faqs
                     SET faqorder = faqorder - 1
                   WHERE cid = '.$res['cid'].'
                     AND faqorder > '.$res['faqorder'];
            return serendipity_db_query($q);
        }
        return false;
    }

    function fetchFAQ(&$id)
    {
        global $serendipity;

        $q = 'SELECT *
                FROM '.$serendipity['dbPrefix'].'faqs
               WHERE id = '.$id;
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

        $q = 'SELECT id, question
                FROM '.$serendipity['dbPrefix'].'faqs
               WHERE cid = '.$cid.'
            ORDER BY faqorder';
        return serendipity_db_query($q, false, 'assoc');
    }

    function fetchCategory(&$id)
    {
        global $serendipity;

        $q = 'SELECT *
                FROM '.$serendipity['dbPrefix'].'faq_categorys
               WHERE id = '.$id;
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
            $q = 'SELECT COUNT(id) AS counter
                    FROM '.$serendipity['dbPrefix'].'faq_categorys
                   WHERE parent_id = '.$this->category['parent_id'];
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

        $q = 'SELECT catorder, parent_id
                FROM '.$serendipity['dbPrefix'].'faq_categorys
               WHERE id = '.$id;
        $res = serendipity_db_query($q, true, 'assoc');
        $q = 'DELETE FROM '.$serendipity['dbPrefix'].'faq_categorys
               WHERE id = '.$id;
        if (serendipity_db_query($q)) {
            $q = 'UPDATE '.$serendipity['dbPrefix'].'faq_categorys
                     SET catorder = catorder - 1
                   WHERE parent_id = '.$res['parent_id'].'
                     AND catorder > '.$res['catorder'];
            serendipity_db_query($q);
            $q = 'UPDATE '.$serendipity['dbPrefix'].'faq_categorys
                     SET parent_id = 0
                   WHERE parent_id = '.$id;
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

        $q = 'SELECT COUNT(id) AS counter
                FROM '.$serendipity['dbPrefix'].'faqs
               WHERE cid = '.$cid;
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

        $q = 'SELECT catorder, parent_id
                FROM '.$serendipity['dbPrefix'].'faq_categorys
               WHERE id = '.$id;
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

        $q = 'SELECT faqorder
                FROM '.$serendipity['dbPrefix'].'faqs
               WHERE id = '.$id.'
                 AND cid = '.$cid;
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

        echo '<strong>'.FAQs.'</strong><hr />';

        switch ($serendipity['GET']['action']) {
            case 'faqs':

                if (($serendipity['POST']['typeSave'] == "true") && (!empty($serendipity['POST']['SAVECONF']))) {
                    $serendipity['POST']['typeSubmit'] = true;
                    $bag = new serendipity_property_bag();
                    $this->introspect($bag);
                    $name = htmlspecialchars($bag->get('name'));
                    $desc = htmlspecialchars($bag->get('description'));
                    $config_faq = $bag->get('configuration_faq');

                    foreach ($config_faq as $config_item) {
                        $cbag = new serendipity_property_bag();
                        if ($this->introspect_faq_item($config_item, $cbag)) {
                            $this->faq[$config_item] = serendipity_get_bool($serendipity['POST']['plugin'][$config_item]);
                        }
                    }
                    $result = $this->updateFAQ();
                    if (is_bool($result)) {
                        echo '<div class="serendipityAdminMsgSuccess"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_success.png') . '" alt="" />'. DONE .': '. sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%H:%M:%S')) .'</div>';
                    } else {
                        echo '<div class="serendipityAdminMsgError"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png') . '" alt="" />'. ERROR. ': ' . $result . '</div>';
                    }

                }

                if (!empty($serendipity['POST']['id'])) {
                    $serendipity['GET']['id'] = &$serendipity['POST']['id'];
                }
                if (is_numeric($serendipity['GET']['id'])) {
                    $this->fetchFAQ($serendipity['GET']['id']);
                }
                if (!is_numeric($serendipity['GET']['cid'])) {
                    $cid = &$this->faq['cid'];
                } else {
                    $cid = &$serendipity['GET']['cid'];
                }

                echo '<p><a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=faq">'.FAQ_CATEGORIES.'</a> <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=faq&serendipity[action]=show_faqs&serendipity[cid]='.$cid.'">'. FAQS . '</a></p>';

                echo '<form action="serendipity_admin.php" method="post" name="serendipityEntry">';
                echo '<input type="hidden" name="serendipity[adminModule]" value="event_display" />';
                echo '<input type="hidden" name="serendipity[adminAction]" value="faq" />';
                echo '<input type="hidden" name="serendipity[action]" value="faqs" />';
                echo '<div>';

                echo '<input type="hidden" name="serendipity[typeSave]" value="true" />';
                $this->showFAQForm();

                echo '</div>';
                echo '</form>';


                break;

            case 'categories':

                echo '<p><a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=faq">'.FAQ_CATEGORIES.'</a></p>';
                if (!empty($serendipity['GET']['id'])) {
                    $serendipity['POST']['id'] = &$serendipity['GET']['id'];
                }
                if (is_numeric($serendipity['POST']['id'])) {
                    $this->fetchCategory($serendipity['POST']['id']);
                }

                if (($serendipity['POST']['categorySave'] == "true") && (!empty($serendipity['POST']['SAVECONF']))) {
                    $serendipity['POST']['categorySubmit'] = true;
                    $bag = new serendipity_property_bag();
                    $this->introspect($bag);
                    $name = htmlspecialchars($bag->get('name'));
                    $desc = htmlspecialchars($bag->get('description'));
                    $config_faq = $bag->get('configuration_category');
                    foreach ($config_faq as $config_item) {
                        $cbag = new serendipity_property_bag();
                        if ($this->introspect_category_item($config_item, $cbag)) {
                            $this->category[$config_item] = serendipity_get_bool($serendipity['POST']['plugin'][$config_item]);
                        }
                    }
                    $result = $this->updateCategory();

                    if (is_bool($result)) {
                        echo '<div class="serendipityAdminMsgSuccess"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_success.png') . '" alt="" />'. DONE .': '. sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%H:%M:%S')) .'</div>';
                    } else {
                        echo '<div class="serendipityAdminMsgError"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png') . '" alt="" />ERROR: ' . $result . '</div>';
                    }

                }

                echo '<form action="serendipity_admin.php" method="post" name="serendipityEntry">';
                echo '<input type="hidden" name="serendipity[adminModule]" value="event_display" />';
                echo '<input type="hidden" name="serendipity[adminAction]" value="faq" />';
                echo '<input type="hidden" name="serendipity[action]" value="categories" />';
                echo '<div>';

                echo '<input type="hidden" name="serendipity[categorySave]" value="true" />';
                $this->showCategoryForm();
                echo '</div>';
                echo '</form>';

                break;

            case 'show_faqs':

                echo '<p><a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=faq">'.FAQ_CATEGORIES.'</a> '.FAQS.'</p>';

                if ((!empty($serendipity['POST']['faqDelete'])) && (is_numeric($serendipity['POST']['id']))) {
                    $result = $this->deleteFAQ($serendipity['POST']['id']);
                    if (is_bool($result)) {
                        echo '<div class="serendipityAdminMsgSuccess"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_success.png') . '" alt="" />'. DONE .': '. sprintf(RIP_ENTRY, $serendipity['POST']['id']) . '</div>';
                    } else {
                        echo '<div class="serendipityAdminMsgError"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png') . '" alt="" />ERROR: ' . $result . '</div>';
                    }
                }

                if ($serendipity['GET']['actiondo'] == 'faqMoveUp') {
                    $this->faqMove($serendipity['GET']['id'], $serendipity['GET']['cid'], D_FAQ_MOVEUP);
                } elseif ($serendipity['GET']['actiondo'] == 'faqMoveDown') {
                    $this->faqMove($serendipity['GET']['id'], $serendipity['GET']['cid'], D_FAQ_MOVEDOWN);
                }

                if (!empty($serendipity['POST']['cid'])) {
                    $serendipity['GET']['cid'] = &$serendipity['POST']['cid'];
                }

                $faqs = $this->fetchFaqByCid($serendipity['GET']['cid']);
                $faqs = $this->prepareMove($faqs);

                echo '<table cellspacing="0" cellpadding="3" width="100%" border="0">';
                if (is_array($faqs)) {
                    foreach ($faqs as $faq) {
                        echo '<tr>';
                        echo '<td width="16"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=faqs&amp;serendipity[cid]='.$serendipity['GET']['cid'].'&amp;serendipity[id]='.$faq['id'].'"><img src="'.serendipity_getTemplateFile('admin/img/edit.png').'" width="16" height="16" title="'.EDIT.'" /></a></td>';
                        echo '<td width="16"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=deleteFAQ&amp;serendipity[cid]='.$serendipity['GET']['cid'].'&amp;serendipity[id]='.$faq['id'].'"><img src="'.serendipity_getTemplateFile('admin/img/delete.png').'" width="16" height="16" title="'.DELETE.'" /></a></td>';
                        echo '<td width="16">&nbsp;</td>';
                        echo '<td width="300" style="padding-left:20px"><img src="'.serendipity_getTemplateFile('admin/img/folder.png').'" width="16" height="16" />&nbsp;'.$faq['question'].'</td>';
                        echo '<td width="16">'.(($faq['up'] == true) ? ('<a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=show_faqs&amp;serendipity[actiondo]=faqMoveUp&amp;serendipity[cid]='.$serendipity['GET']['cid'].'&amp;serendipity[id]='.$faq['id'].'"><img src="'.serendipity_getTemplateFile('admin/img/uparrow.png').'" width="16" height="16" alt="'.UP.'" /></a>') : '&nbsp;').'</td>';
                        echo '<td width="16">'.(($faq['down'] == true) ? ('<a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=show_faqs&amp;serendipity[actiondo]=faqMoveDown&amp;serendipity[cid]='.$serendipity['GET']['cid'].'&amp;serendipity[id]='.$faq['id'].'"><img src="'.serendipity_getTemplateFile('admin/img/downarrow.png').'" width="16" height="16" alt="'.DOWN.'" /></a>') : '&nbsp;').'</td>';
                        echo '</tr>';
                    }
                }
                echo '<tr>';
                echo '<td colspan="6" align="right"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=faqs&amp;serendipity[cid]='.$serendipity['GET']['cid'].'" class="serendipityPrettyButton">'.FAQ_NEWFAQ.'</a></td>';
                echo '</tr>';
                echo '</table>';
                break;

            case 'deleteCategory':
                if (is_numeric($serendipity['GET']['id'])) {
                    echo '<form action="serendipity_admin.php" method="post" name="serendipityEntry">';
                    echo '<input type="hidden" name="serendipity[adminModule]" value="event_display" />';
                    echo '<input type="hidden" name="serendipity[adminAction]" value="faq" />';
                    echo '<input type="hidden" name="serendipity[id]" value="'.$serendipity['GET']['id'].'" />';
                    echo '<strong>'. FAQ_CATEGORIES. '</strong><br /><br />';
                    echo FAQ_REALYDELETECATEGORY.'&nbsp;';
                    echo '<input class="serendipityPrettyButton input_button" type="submit" name="serendipity[categoryDelete]" value="'.YES.'" /> &nbsp; <input class="serendipityPrettyButton input_button" type="submit" name="" value="'.NO.'" />';
                    echo '</form>';
                }
                break;

            case 'deleteFAQ':
                if (is_numeric($serendipity['GET']['id'])) {
                    echo '<form action="serendipity_admin.php" method="post" name="serendipityEntry">';
                    echo '<input type="hidden" name="serendipity[adminModule]" value="event_display" />';
                    echo '<input type="hidden" name="serendipity[adminAction]" value="faq" />';
                    echo '<input type="hidden" name="serendipity[action]" value="show_faqs" />';
                    echo '<input type="hidden" name="serendipity[id]" value="'.$serendipity['GET']['id'].'" />';
                    echo '<input type="hidden" name="serendipity[cid]" value="'.$serendipity['GET']['cid'].'" />';
                    echo '<strong>'. FAQ_CATEGORIES. '</strong><br /><br />';
                    echo FAQ_REALYDELETECATEGORY.'&nbsp;';
                    echo '<input class="serendipityPrettyButton input_button" type="submit" name="serendipity[faqDelete]" value="'.YES.'" /> &nbsp; <input class="serendipityPrettyButton input_button" type="submit" name="" value="'.NO.'" />';
                    echo '</form>';
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

                echo '<strong>'.FAQ_CATEGORIES.'</strong> ('.$serendipity['languages'][$this_cat_lang].')<br /><br />';

                if ((!empty($serendipity['POST']['categoryDelete'])) && (is_numeric($serendipity['POST']['id']))) {

                    $faqs = $this->fetchFaqByCid($serendipity['POST']['id']);
                    if (is_array($faqs)) {
                        foreach ($faqs as $faq) {
                            $this->deleteFAQ($faq['id']);
                        }
                    }
                    $result = $this->deleteCategory($serendipity['POST']['id']);
                    if (is_bool($result)) {
                        echo '<div class="serendipityAdminMsgSuccess"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_success.png') . '" alt="" />'. DONE .': '. sprintf(RIP_ENTRY, $serendipity['POST']['id']) . '</div>';
                    } else {
                        echo '<div class="serendipityAdminMsgError"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png') . '" alt="" />ERROR: ' . $result . '</div>';
                    }

                }

                echo '<table cellspacing="0" cellpadding="3" width="100%" border="0">';
                echo '<tr><td colspan="7">';
                $lang_links = '';
                foreach ($serendipity['languages'] as $lang_key => $lang_value) {
                    if (strlen($lang_links)) {
                        $lang_links .= '&nbsp;';
                    }
                    if ($this_cat_lang == $lang_key) {
                        $lang_links .= '<span style="border:1px solid #000000">';
                    }
                    $lang_links .= '<a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[cat_lang]='.$lang_key.'">'.$lang_key.'</a>';
                    if ($this_cat_lang == $lang_key) {
                        $lang_links .= '</span>';
                    }

                }
                echo $lang_links;
                echo '</td></tr>';
                $fcats = $this->fetchCategories($this_cat_lang);

                if (is_array($fcats)) {
                    $fcats = serendipity_walkRecursive($fcats);
                    $fcats = $this->prepareMove($fcats);
                    foreach ($fcats as $category) {
                        echo '<tr>';
                        echo '<td width="16"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=categories&amp;serendipity[id]='.$category['id'].'&amp;serendipity[cat_lang]='.$this_cat_lang.'"><img src="'.serendipity_getTemplateFile('admin/img/edit.png').'" width="16" height="16" title="'.EDIT.'" /></a></td>';
                        echo '<td width="16"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=deleteCategory&amp;serendipity[id]='.$category['id'].'"><img src="'.serendipity_getTemplateFile('admin/img/delete.png').'" width="16" height="16" title="'.DELETE.'" /></a></td>';
                        echo '<td width="16">&nbsp;</td>';
                        echo '<td width="300" style="padding-left:'.(20 * $category['depth']).'px"><img src="'.serendipity_getTemplateFile('admin/img/folder.png').'" width="16" height="16" />&nbsp;<a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=show_faqs&amp;serendipity[cid]='.$category['id'].'">'.$category['category'].'</a></td>';
                        echo '<td>'.$this->countFAQbyCid($category['id']).' '.FAQ_NAME.'</td>';
                        echo '<td width="16">'.(($category['up'] == true) ? ('<a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=category_moveup&amp;serendipity[id]='.$category['id'].'"><img src="'.serendipity_getTemplateFile('admin/img/uparrow.png').'" width="16" height="16" alt="'.UP.'" /></a>') : '&nbsp;').'</td>';
                        echo '<td width="16">'.(($category['down'] == true) ? ('<a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=category_movedown&amp;serendipity[id]='.$category['id'].'"><img src="'.serendipity_getTemplateFile('admin/img/downarrow.png').'" width="16" height="16" alt="'.DOWN.'" /></a>') : '&nbsp;').'</td>';
                        echo '</tr>';
                    }
                }
                echo '<tr>';
                echo '<td colspan="7" align="right"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq&amp;serendipity[action]=categories&amp;serendipity[cat_lang]='.$this_cat_lang.'" class="serendipityPrettyButton">'.FAQ_NEWCATEGORY.'</a></td>';
                echo '</tr>';
                echo '</table>';
                break;

        }
    }

    function showFrontend()
    {
        global $serendipity;

        header('Content-Type: text/html; charset=' . LANG_CHARSET);
        include_once(S9Y_INCLUDE_PATH . 'include/genpage.inc.php');

        if (is_string($serendipity['uriArguments'][2]) && isset($serendipity['languages'][$serendipity['uriArguments'][2]])) {
            $faq_language   = $serendipity['uriArguments'][2];
            $faq_categoryid = $serendipity['uriArguments'][3];
            $faq_faqid      = $serendipity['uriArguments'][4];
        } else {
            $faq_language   = $serendipity['lang'];
            $faq_categoryid = $serendipity['uriArguments'][2];
            $faq_faqid      = $serendipity['uriArguments'][3];
        }
        if (is_numeric($faq_categoryid)) {

            $res['parent_id'] = $faq_categoryid;
            do {
                $q = 'SELECT id, category, parent_id
                        FROM '.$serendipity['dbPrefix'].'faq_categorys
                       WHERE id = '.$res['parent_id'];
                $res = serendipity_db_query($q, true, 'assoc');
                $cat_tree[] = $res;
            } while ($res['parent_id'] != 0);

            krsort($cat_tree);
            $serendipity['smarty']->assign('cat_tree', $cat_tree);

            if (is_numeric($faq_faqid)) {

                $q = 'SELECT question, answer, category, faqorder, catorder, parent_id
                        FROM '.$serendipity['dbPrefix'].'faqs, '.$serendipity['dbPrefix'].'faq_categorys
                       WHERE '.$serendipity['dbPrefix'].'faqs.id = '.$faq_faqid.'
                         AND '.$serendipity['dbPrefix'].'faqs.cid = '.$serendipity['dbPrefix'].'faq_categorys.id
                    ORDER BY faqorder';
                $faq = serendipity_db_query($q, true, 'assoc');

                if (is_array($faq)) {

                    $q = 'SELECT '.$serendipity['dbPrefix'].'faqs.id, question, cid, category
                            FROM '.$serendipity['dbPrefix'].'faqs, '.$serendipity['dbPrefix'].'faq_categorys
                           WHERE '.$serendipity['dbPrefix'].'faqs.cid = '.$faq_categoryid.'
                             AND '.$serendipity['dbPrefix'].'faqs.faqorder = '.($faq['faqorder'] + 1).'
                             AND '.$serendipity['dbPrefix'].'faqs.cid = '.$serendipity['dbPrefix'].'faq_categorys.id';
                    $nfaq = serendipity_db_query($q, true, 'assoc');

                    if (!is_array($nfaq)) {
                        $q = 'SELECT '.$serendipity['dbPrefix'].'faqs.id, question, cid, category
                                FROM '.$serendipity['dbPrefix'].'faqs, '.$serendipity['dbPrefix'].'faq_categorys
                               WHERE '.$serendipity['dbPrefix'].'faq_categorys.catorder = '.($faq['catorder'] + 1).'
                                 AND '.$serendipity['dbPrefix'].'faq_categorys.parent_id = '.$faq['parent_id'].'
                                 AND '.$serendipity['dbPrefix'].'faqs.faqorder = 1
                                 AND '.$serendipity['dbPrefix'].'faqs.cid = '.$serendipity['dbPrefix'].'faq_categorys.id';
                        $nfaq = serendipity_db_query($q, true, 'assoc');

                    }

                    $q = 'SELECT '.$serendipity['dbPrefix'].'faqs.id, question, cid, category
                            FROM '.$serendipity['dbPrefix'].'faqs, '.$serendipity['dbPrefix'].'faq_categorys
                           WHERE '.$serendipity['dbPrefix'].'faqs.cid = '.$faq_categoryid.'
                             AND '.$serendipity['dbPrefix'].'faqs.faqorder = '.($faq['faqorder'] - 1).'
                             AND '.$serendipity['dbPrefix'].'faqs.cid = '.$serendipity['dbPrefix'].'faq_categorys.id';
                    $pfaq = serendipity_db_query($q, true, 'assoc');

                    if (!is_array($pfaq)) {
                        $q = 'SELECT MAX(faqorder) AS fmax
                                FROM '.$serendipity['dbPrefix'].'faqs, '.$serendipity['dbPrefix'].'faq_categorys
                               WHERE '.$serendipity['dbPrefix'].'faq_categorys.catorder = '.($faq['catorder'] - 1).'
                                 AND '.$serendipity['dbPrefix'].'faq_categorys.parent_id = '.$faq['parent_id'].'
                                 AND '.$serendipity['dbPrefix'].'faqs.cid = '.$serendipity['dbPrefix'].'faq_categorys.id';
                        $max = serendipity_db_query($q, true, 'assoc');

                        $q = 'SELECT '.$serendipity['dbPrefix'].'faqs.id, question, cid, category
                                FROM '.$serendipity['dbPrefix'].'faqs, '.$serendipity['dbPrefix'].'faq_categorys
                               WHERE '.$serendipity['dbPrefix'].'faq_categorys.catorder = '.($faq['catorder'] - 1).'
                                 AND '.$serendipity['dbPrefix'].'faqs.faqorder = '.($max['fmax'] ? $max['fmax'] : 0).'
                                 AND '.$serendipity['dbPrefix'].'faqs.cid = '.$serendipity['dbPrefix'].'faq_categorys.id';
                        $pfaq = serendipity_db_query($q, true, 'assoc');
                    }

                }

                if(serendipity_db_bool($this->get_config('markup', true))) {
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
                    'next_faq' => array(
                        'faqid'      => $nfaq['id'],
                        'question'   => $nfaq['question'],
                        'categoryid' => $nfaq['cid'],
                        'category'   => $nfaq['category']
                    ),
                    'prev_faq' => array(
                        'faqid'      => $pfaq['id'],
                        'question'   => $pfaq['question'],
                        'categoryid' => $pfaq['cid'],
                        'category'   => $pfaq['category']
                    )
                ));

            } else {
                $q = 'SELECT id, cid, question, changedate, changetype
                        FROM '.$serendipity['dbPrefix'].'faqs
                       WHERE cid = '.$faq_categoryid.'
                    ORDER BY faqorder';
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
                $q = 'SELECT id, category
                        FROM '.$serendipity['dbPrefix'].'faq_categorys
                       WHERE parent_id = '.$faq_categoryid.'
                    ORDER BY catorder';
                $scat = serendipity_db_query($q, false, 'assoc');
                $q = 'SELECT category, introduction
                        FROM '.$serendipity['dbPrefix'].'faq_categorys
                       WHERE id = '.$faq_categoryid;
                $cat = serendipity_db_query($q, true, 'assoc');
                $filename = 'plugin_faq_category_faqs.tpl';

                if(serendipity_db_bool($this->get_config('markup', true))) {
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
                if(serendipity_db_bool($this->get_config('markup', true))) {
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

        $serendipity['smarty']->append('faq_plugin', array(
            'plugin_url' => trim($pluginpath)
        ), true);

        $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
        if (!$tfile || $tfile == $filename) {
            $tfile = dirname(__FILE__) . '/' . $filename;
        }
        $inclusion = $serendipity['smarty']->security_settings[INCLUDE_ANY];
        $serendipity['smarty']->security_settings[INCLUDE_ANY] = true;
        $content = $serendipity['smarty']->fetch('file:'. $tfile);
        $serendipity['smarty']->security_settings[INCLUDE_ANY] = $inclusion;
        $serendipity['smarty']->assign('CONTENT', $content);
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
        } elseif ($serendipity['dbType'] == 'sqlite') {
            $group     = 'GROUP BY id';
            $distinct  = '';
            $term      = serendipity_mb('strtolower', $term);
            $find_part = "(lower(question) LIKE '%$term%' OR lower(answer) LIKE '%$term%')";
        } else {
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
                echo htmlspecialchars($results);
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
        $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
        if (!$tfile) {
            $tfile = dirname(__FILE__) . '/' . $filename;
        }
        $inclusion = $serendipity['smarty']->security_settings[INCLUDE_ANY];
        $serendipity['smarty']->security_settings[INCLUDE_ANY] = true;
        $content = $serendipity['smarty']->fetch('file:'. $tfile);
        $serendipity['smarty']->security_settings[INCLUDE_ANY] = $inclusion;
        echo $content;

    }

    function showFAQForm()
    {
        global $serendipity;

        $serendipity['EditorBrowsers'] = '@(IE|Mozilla|Safari)@i';

        if (file_exists(S9Y_INCLUDE_PATH.'include/functions_entries_admin.inc.php')) {
            include_once(S9Y_INCLUDE_PATH.'include/functions_entries_admin.inc.php');
        }

?>
<br /><hr />
    <table border="0" cellspacing="0" cellpadding="3" width="100%">
<?php
    $elcount = 0;
    $htmlnugget = array();
    foreach ($this->config_faq as $config_item) {
        $elcount++;
        $config_value = $this->faq[$config_item];
        $cbag = new serendipity_property_bag();
        $this->introspect_faq_item($config_item, $cbag);

        $cname = htmlspecialchars($cbag->get('name'));
        $cdesc = htmlspecialchars($cbag->get('description'));
        $value = $this->getFaq($config_item, 'unset');
        $lang_direction = htmlspecialchars($cbag->get('lang_direction'));

        if (empty($lang_direction)) {
            $lang_direction = LANG_DIRECTION;
        }

        if ($value === 'unset') {
            $value = $cbag->get('default');
        }

        $hvalue   = (!isset($serendipity['POST']['faqSubmit']) && isset($serendipity['POST']['plugin'][$config_item]) ? htmlspecialchars($serendipity['POST']['plugin'][$config_item]) : htmlspecialchars($value));
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
                    <input class="direction_<?php echo $lang_direction; ?> input_radio" type="text" name="serendipity[plugin][<?php echo $config_item; ?>]" value="<?php echo $hvalue; ?>" size="30" />
                </div>
            </td>
        </tr>
<?php
                break;

            case 'html':
            case 'text':
?>

            <tr>
<?php
    if (!$serendipity['wysiwyg']) {
?>
                <td><strong><?php echo $cname; ?></strong>
                &nbsp;<span style="color: #5E7A94; font-size: 8pt;">&nbsp;<?php echo $cdesc; ?></span></td>
                <td align="right">
<?php
        /* Since the user has WYSIWYG editor disabled, we want to check if we should use the "better" non-WYSIWYG editor */
        if (!$serendipity['wysiwyg'] && preg_match($serendipity['EditorBrowsers'], $_SERVER['HTTP_USER_AGENT']) ) {
?><nobr>
                  <script type="text/javascript" language="JavaScript">
                        document.write('<input type="button" class="serendipityPrettyButton input_button" name="insI" value="I" accesskey="i" style="font-style: italic" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'],\'<i>\',\'</i>\')" />');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" name="insB" value="B" accesskey="b" style="font-weight: bold" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'],\'<b>\',\'</b>\')" />');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" name="insU" value="U" accesskey="u" style="text-decoration: underline;" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'],\'<u>\',\'</u>\')" />');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" name="insQ" value="<?php echo QUOTE ?>" accesskey="q" style="font-style: italic" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'],\'<blockquote>\',\'</blockquote>\')" />');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" name="insJ" value="img" accesskey="j" onclick="wrapInsImage(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'])" />');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" name="insImage" value="<?php echo MEDIA; ?>" style="" onclick="window.open(\'serendipity_admin_image_selector.php?serendipity[textarea]=<?php echo urlencode('serendipity[plugin]['.$config_item.']'); ?>\', \'ImageSel\', \'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1\');" />');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" name="insU" value="URL" accesskey="l" style="color: blue; text-decoration: underline;" onclick="wrapSelectionWithLink(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'])" />');
                  </script></nobr>
<?php
        /* Do the "old" non-WYSIWYG editor */
        } elseif (!$serendipity['wysiwyg']) { ?><nobr>
                  <script type="text/javascript" language="JavaScript">
                        document.write('<input type="button" class="serendipityPrettyButton input_button" value=" B " onclick="serendipity_insBasic(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'], \'b\')">');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" value=" U " onclick="serendipity_insBasic(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'], \'u\')">');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" value=" I " onclick="serendipity_insBasic(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'], \'i\')">');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" value="<img>" onclick="serendipity_insImage(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'])">');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" value="<?php echo MEDIA; ?>" onclick="window.open(\'serendipity_admin_image_selector.php?serendipity[filename_only]=<?php echo $config_item ?>\', \'ImageSel\', \'width=800,height=600,toolbar=no\');">');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" value="Link" onclick="serendipity_insLink(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'])">');
                </script></nobr>
<?php   }

        serendipity_plugin_api::hook_event('backend_entry_toolbar_body', $entry);
    } else {
?>
            <td colspan="2"><strong><?php echo $cname; ?></strong>
                &nbsp;<span style="color: #5E7A94; font-size: 8pt;">&nbsp;<?php echo $cdesc; ?></span></td>
            <td><?php serendipity_plugin_api::hook_event('backend_entry_toolbar_body', $entry); ?>

<?php } ?>
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
                ?><tr><td colspan="2"><input class="direction_<?php echo $lang_direction; ?>" type="hidden" name="serendipity[plugin][<?php echo $config_item; ?>]" value="<?php echo $cbag->get('value'); ?>" /></td></tr><?php
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
<?php
    }

    function showCategoryForm() {
        global $serendipity;

        $serendipity['EditorBrowsers'] = '@(IE|Mozilla|Safari)@i';

        if(file_exists(S9Y_INCLUDE_PATH.'include/functions_entries_admin.inc.php')){
            include_once(S9Y_INCLUDE_PATH.'include/functions_entries_admin.inc.php');
        }

?>
    <table border="0" cellspacing="0" cellpadding="3" width="100%">
<?php
    $elcount = 0;
    $htmlnugget = array();
    foreach ($this->config_category as $config_item) {
        $elcount++;
        $config_value = $this->category[$config_item];
        $cbag = new serendipity_property_bag();
        $this->introspect_category_item($config_item, $cbag);

        $cname = htmlspecialchars($cbag->get('name'));
        $cdesc = htmlspecialchars($cbag->get('description'));
        $value = $this->getCategory($config_item, 'unset');
        $lang_direction = htmlspecialchars($cbag->get('lang_direction'));

        if (empty($lang_direction)) {
            $lang_direction = LANG_DIRECTION;
        }

        if ($value === 'unset') {
            $value = $cbag->get('default');
        }

        $hvalue   = (!isset($serendipity['POST']['categorySubmit']) && isset($serendipity['POST']['plugin'][$config_item]) ? htmlspecialchars($serendipity['POST']['plugin'][$config_item]) : htmlspecialchars($value));
        $radio    = array();
        $select   = array();
        $per_row  = null;

        switch ($cbag->get('type')) {
            case 'seperator':
                echo '<tr><td colspan="2"><hr noshade="noshade" size="1" /></td></tr>';
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
                    echo '<option value="'.$select_value.'" '.($select_value == $hvalue ? 'selected="selected"' : '').' title="'.htmlspecialchars($select_desc).'" />'.htmlspecialchars($select_desc).'</option>';
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
<?php
    if (!$serendipity['wysiwyg']) {
?>
                <td><strong><?php echo $cname; ?></strong>
                &nbsp;<span style="color: #5E7A94; font-size: 8pt;">&nbsp;<?php echo $cdesc; ?></span></td>
                <td align="right">
<?php
        /* Since the user has WYSIWYG editor disabled, we want to check if we should use the "better" non-WYSIWYG editor */
        if (!$serendipity['wysiwyg'] && preg_match($serendipity['EditorBrowsers'], $_SERVER['HTTP_USER_AGENT']) ) {
?><nobr>
                  <script type="text/javascript" language="JavaScript">
                        document.write('<input type="button" class="serendipityPrettyButton input_button" name="insI" value="I" accesskey="i" style="font-style: italic" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'],\'<i>\',\'</i>\')" />');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" name="insB" value="B" accesskey="b" style="font-weight: bold" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'],\'<b>\',\'</b>\')" />');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" name="insU" value="U" accesskey="u" style="text-decoration: underline;" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'],\'<u>\',\'</u>\')" />');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" name="insQ" value="<?php echo QUOTE ?>" accesskey="q" style="font-style: italic" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'],\'<blockquote>\',\'</blockquote>\')" />');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" name="insJ" value="img" accesskey="j" onclick="wrapInsImage(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'])" />');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" name="insImage" value="<?php echo MEDIA; ?>" style="" onclick="window.open(\'serendipity_admin_image_selector.php?serendipity[textarea]=<?php echo urlencode('serendipity[plugin]['.$config_item.']'); ?>\', \'ImageSel\', \'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1\');" />');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" name="insU" value="URL" accesskey="l" style="color: blue; text-decoration: underline;" onclick="wrapSelectionWithLink(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'])" />');
                  </script></nobr>
<?php
        /* Do the "old" non-WYSIWYG editor */
        } elseif (!$serendipity['wysiwyg']) { ?><nobr>
                  <script type="text/javascript" language="JavaScript">
                        document.write('<input type="button" class="serendipityPrettyButton input_button" value=" B " onclick="serendipity_insBasic(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'], \'b\')">');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" value=" U " onclick="serendipity_insBasic(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'], \'u\')">');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" value=" I " onclick="serendipity_insBasic(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'], \'i\')">');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" value="<img>" onclick="serendipity_insImage(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'])">');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" value="<?php echo MEDIA; ?>" onclick="window.open(\'serendipity_admin_image_selector.php?serendipity[filename_only]=<?php echo $config_item ?>\', \'ImageSel\', \'width=800,height=600,toolbar=no\');">');
                        document.write('<input type="button" class="serendipityPrettyButton input_button" value="Link" onclick="serendipity_insLink(document.forms[\'serendipityEntry\'][\'serendipity[plugin][<?php echo $config_item ?>]\'])">');
                </script></nobr>
<?php   }

        serendipity_plugin_api::hook_event('backend_entry_toolbar_body', $entry);
    } else {
?>
            <td colspan="2"><strong><?php echo $cname; ?></strong>
                &nbsp;<span style="color: #5E7A94; font-size: 8pt;">&nbsp;<?php echo $cdesc; ?></span></td>
            <td><?php serendipity_plugin_api::hook_event('backend_entry_toolbar_body', $entry); ?>

<?php } ?>
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
                ?><tr><td colspan="2"><input class="direction_<?php echo $lang_direction; ?>" type="hidden" name="serendipity[plugin][<?php echo $config_item; ?>]" value="<?php echo $cbag->get('value'); ?>" /></td></tr><?php
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
<?php
    }


    function generate_content(&$title)
    {
        $title = FAQ_NAME;
    }

    function install()
    {
        $this->setupDB();
    }

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
                    $this->setupDB();
                    echo '<li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=faq">' . FAQ_NAME . '</a></li>';
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
                    if (!strpos($eventData, '#serendipityFAQNav')) {
                        echo file_get_contents(dirname(__FILE__).'/style_faq_backend.css');
                    }
                    break;

                case 'css':
                    if (!strpos($eventData, '#serendipityFAQNav')) {
                        echo file_get_contents(dirname(__FILE__).'/style_faq_frontend.css');
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