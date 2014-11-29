<?php # 

// TODO:
// Use parent category template for a child category, but allow child categories to override template of parent category.


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

@define('CATEGORYTEMPLATE_DB_VERSION', 4);

class serendipity_event_categorytemplates extends serendipity_event
{
    var $title = PLUGIN_CATEGORYTEMPLATES_NAME;
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_CATEGORYTEMPLATES_NAME);
        $propbag->add('description',   PLUGIN_CATEGORYTEMPLATES_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Judebert');
        $propbag->add('version',       '0.35.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',    array(
            'genpage'                   => true,
            'external_plugin'           => true,
            'backend_category_addNew'   => true,
            'backend_category_update'   => true,
            'backend_category_delete'   => true,
            'backend_category_showForm' => true,
            'frontend_fetchentries'     => true,
            'frontend_fetchentry'       => true,
            'backend_sidebar_entries_event_display_cattemplate' => true,
//            'frontend_configure'        => true
        ));

        $propbag->add('configuration', array('pass', 'sort_order', 'fixcat', 'cat_precedence'));
        $propbag->add('groups', array('FRONTEND_FULL_MODS', 'FRONTEND_VIEWS', 'BACKEND_TEMPLATES'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'pass':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_CATEGORYTEMPLATES_PASS);
                $propbag->add('description', PLUGIN_CATEGORYTEMPLATES_PASS_DESC);
                $propbag->add('default',     'false');
                break;

            case 'sort_order':
                $propbag->add('type',        'string');
                $propbag->add('name',        USE_DEFAULT . ': ' . SORT_ORDER);
                $propbag->add('description', '');
                $propbag->add('default',     'timestamp DESC');
                break;

            case 'fixcat':
                $propbag->add('type',           'radio');
                $propbag->add('name',           PLUGIN_CATEGORYTEMPLATES_FIXENTRY);
                $propbag->add('description',    PLUGIN_CATEGORYTEMPLATES_FIXENTRY_DESC);
                $propbag->add('radio',          array(
                                                    'value' => array('true', 'false', 'hard'),
                                                    'desc'  => array(YES, NO, FORCE)
                                                ));
                $propbag->add('default',        'false');
                break;

            case 'cat_precedence':
                $propbag->add('type',        'sequence');
                $propbag->add('name',        PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE);
                $propbag->add('description', PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE_DESC);
                $tcats = $this->getTemplatizedCats();
                $values = array();
                if (is_array($tcats)) {
                    foreach($tcats AS $cat) {
                        $values[$cat['categoryid']] = array('display' => $cat['category_name']);
                    }
                } else { 
                    $values = array(PLUGIN_CATEGORYTEMPLATES_NO_CUSTOMIZED_CATEGORIES); 
                }
                $propbag->add('values',      $values);

                // People who already had custom categories, but don't have 
                // the sequence widget, will not save this value.  So entries
                // won't ever use custom templates.  To duplicate the original
                // without-sequence-widget behavior, we'll have to do some
                // magic when the 'cat_precedence' is retrieved.

                // If you want to set a default here:
                // Note that get_config() will cause HTTP error 500 the first
                // time the plugin is installed, unless we provide a default
        }
        return true;
    }

    /**
     * Retrieves a list of IDs of all categories that have some customization enabled.
     * @return array A list of category IDs, or false if no categories are customized.
     */
    function getTemplatizedCats() {
        global $serendipity;
        // Find all the categories that have custom templates
        $query = "SELECT
                    c.categoryid,
                    c.category_name,
                    c.category_icon
                  FROM {$serendipity['dbPrefix']}category AS c
            INNER JOIN {$serendipity['dbPrefix']}categorytemplates AS t
                    ON t.categoryid = c.categoryid
                 WHERE t.template != ''
              ORDER BY c.category_name ASC";
        $dbcids = serendipity_db_query($query);
        if (!is_array($dbcids)) {
            // It's the value "1", for "success", or something
            $dbcids = false;
        } 
        return $dbcids;
        //--TODO: Maybe find all the ones with custom sort orders and other display alterations, too
    }

    /**
     * Updates database to version-appropriate schema
     * @param The current version number of the database (could be empty)
     * @return true
     */
    function checkScheme($ver) {
        global $serendipity;

        if ($ver == 3) {
            $q   = "ALTER TABLE {$serendipity['dbPrefix']}categorytemplates ADD COLUMN hide_rss varchar(4) default false";
            $sql = serendipity_db_schema_import($q);

            $this->set_config('dbversion', CATEGORYTEMPLATE_DB_VERSION);
        } elseif ($ver == 2) {
            $q   = "ALTER TABLE {$serendipity['dbPrefix']}categorytemplates ADD COLUMN hide_rss varchar(4) default false";
            $sql = serendipity_db_schema_import($q);

            $q   = "ALTER TABLE {$serendipity['dbPrefix']}categorytemplates ADD COLUMN sort_order varchar(255)";
            $sql = serendipity_db_schema_import($q);

            $this->set_config('dbversion', CATEGORYTEMPLATE_DB_VERSION);
        } elseif ($ver == 1) {
            $q   = "ALTER TABLE {$serendipity['dbPrefix']}categorytemplates ADD COLUMN hide_rss tinyint(1) default false";
            $sql = serendipity_db_schema_import($q);

            $q   = "ALTER TABLE {$serendipity['dbPrefix']}categorytemplates ADD COLUMN sort_order varchar(255)";
            $sql = serendipity_db_schema_import($q);

            $q   = "ALTER TABLE {$serendipity['dbPrefix']}categorytemplates ADD COLUMN pass varchar(255) default null";
            $sql = serendipity_db_schema_import($q);
            $this->set_config('dbversion', CATEGORYTEMPLATE_DB_VERSION);
        } elseif ($ver != CATEGORYTEMPLATE_DB_VERSION) {
            $q   = "CREATE TABLE {$serendipity['dbPrefix']}categorytemplates (
                        categoryid int(11) default null,
                        template varchar(255) default null,
                        fetchlimit int(4) default null,
                        futureentries int(4) default null,
                        lang varchar(255) default null,
                        pass varchar(255) default null,
                        sort_order varchar(255),
                        hide_rss varchar(4) default null
                    )";
            $sql = serendipity_db_schema_import($q);

            $q   = "CREATE INDEX ctcid ON {$serendipity['dbPrefix']}categorytemplates (categoryid);";
            $sql = serendipity_db_schema_import($q);

            $this->set_config('dbversion', CATEGORYTEMPLATE_DB_VERSION);
        }

        return true;
    }

    /**
     * Returns the most appropriate category ID for the current entry.  
     * Only called from genpage hook.
     * @global array $serendipity Determines the current entry from HTTP variables
     * @return int|string Category ID if custom template defined or category
     *    view, otherwise 'default'
     */
    function getID() {
    	global $serendipity;

        // If category view, just return the current category ID
        if ($serendipity['GET']['category'] && !isset($serendipity['GET']['id'])) {
            return (int)$serendipity['GET']['category'];
        }

        // If entry view, determine the best category ID for custom templating
        if ($serendipity['GET']['id']) {
            // Find all the category IDs that have custom templates
            $cidstr = $this->get_config('cat_precedence', false);
            if ($cidstr === false) {
                // No precedence set: default to old, alphabetical precedence.
                $tcats = $this->getTemplatizedCats();
                $cids = array();
                if (is_array($tcats)) {
                    foreach($tcats AS $cat) {
                        $cids[] = $cat['categoryid'];
                    }
                }
            } else {
                if ($cidstr) {
                    $cids = explode(',', $cidstr);
                } else {
                    // Possibly it's set, but no categories, therefore empty
                    $cids = array();
                }
            }

            // Get all the categories' IDs belonging to this entry
            $entrycats = serendipity_fetchEntryCategories($serendipity['GET']['id']);
            $entrycids = array();
            foreach ($entrycats AS $catdata) {
                $entrycids[] = $catdata['categoryid'];
            }

            // Return the first customized template in the entry's categories
            // Could try array_intersect(), but will it keep order?
            foreach ($cids AS $idx => $candidate) {
                if (in_array($candidate, $entrycids)) {
                    return $candidate;
                }
            }// End if we know of any customized categories
            
            // If set to force, ALWAYS set the category to a forced category.
            if ((string)$this->get_config('fixcat') === 'hard') {
                return $entrycids[0];
            }
        }// End if entry

        return 'default';
    }

    /** 
     * Wrapper for fetchProp() returning name of custom template for the
     * given category ID, if defined, with default.
     * @param int cid The category ID to lookup 
     * @param string fallback The default template name
     * @return string The name of the template to be used
     */
    function fetchTemplate($cid, $fallback) {
        $this->usesDefaultTemplate = true;

        if ($cid === false || $cid == 'default') {
            return $fallback;
        } else {
            $val = $this->fetchProp($cid, 'template');
            if (!empty($val)) {
            $this->usesDefaultTemplate = false;
                return $val;
            }
        }

        return $fallback;
    }

    /**
     * Wrapper for fetchProp() returning the limit of entries to fetch
     * for this category ID, with default.
     * @param int cid The category ID to lookup
     * @param int fallback The default number of entries to fetch
     * @return int The max number of entries to be fetched
     */
    function fetchLimit($cid, $fallback) {
        if ($cid == false || $cid == 'default' || $cid == 0) {
            return $fallback;
        } else {
            $val = $this->fetchProp($cid, 'fetchlimit');
            if (!empty($val)) {
                return $val;
            }
        }

        return $fallback;
    }

    /**
     * Wrapper for fetchProp() returning the language for the category ID,
     * with default.
     * @param int cid The category ID to lookup
     * @param string fallback The default language to use
     * @return string The language to be used
     */
    function fetchLang($cid, $fallback) {
        if ($cid === false || $cid == 'default') {
            return $fallback;
        } else {
            $val = $this->fetchProp($cid, 'lang');
            if (!empty($val)) {
                return $val;
            }
        }

        return $fallback;
    }

    /**
     * Wrapper for fetchProp() returning whether to display entries with
     * dates in the future for this category ID, with default.
     * @param int cid The category ID to lookup
     * @param bool fallback The default whether to display entries from the future
     * @return bool Whether to display entries from the future
     */
    function fetchFuture($cid, $fallback) {
        if ($cid === false || $cid == 'default' || $cid == 0) {
            return $fallback;
        } else {
            $val = $this->fetchProp($cid, 'futureentries');
            if ($val == 1) {
                return false;
            } elseif ($val == 2) {
                return true;
            }
        }

        return $fallback;
    }

    /**
     * Wrapper for fetchProp() returning the entry sort order for this
     * category ID, with default.
     * @param int cid The category ID to lookup
     * @param string fallback The default database ordering string
     * @return string The database ordering string to use (i.e, 'date ASC')
     */
    function fetchSortOrder($cid, $fallback) {
        if ($cid === false || $cid == 'default' || $cid == 0) {
            return $fallback;
        } else {
            $val = $this->fetchProp($cid, 'sort_order');
            if ($val == 'timestamp DESC' /*|| $fallback == 'timestamp DESC'*/) {
                return false;
            }
            if (!empty($val)) {
                return $val;
            }
        }

        return $fallback;
    }

    /**
     * Fetches the requested property of the given category ID, retrieving
     * from cache where possible, querying database and populating cache
     * with all properties otherwise.
     * @param int cide The category ID to be queried
     * @param string key optional The property to be fetched (default 'template')
     * @return mixed The value of the requested property
     */
    function fetchProp($cid, $key = 'template') {
        global $serendipity;

        static $cache = array();

        if (isset($cache[$cid][$key])) {
            return $cache[$cid][$key];
        }

        $props = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}categorytemplates WHERE categoryid = " . (int)$cid . " LIMIT 1");
        if (is_array($props)) {
            $cache[$cid] = $props[0];
            return $cache[$cid][$key];
        }

        return false;
    }

    /**
     * Sets or deletes properties for this category from the database.
     * @param int cid The category ID to use
     * @param array val optional An array associating SQL column names with
     *     their desired values (default false)
     * @param bool deleteOnly optional Whether to skip inserting new values (default false)
     * @return true
     */
    function setProps($cid, $val = false, $deleteOnly = false) {
        global $serendipity;

        serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}categorytemplates
                                    WHERE categoryid = " . (int)$cid);

        if ($deleteOnly === false) {
            $db = serendipity_db_insert('categorytemplates', $val, 'execute');
            return $db;
        }

        return true;
    }

    function template_options($template, $catid) {
        global $serendipity, $template_config;
        if (!serendipity_checkPermission('adminTemplates')) {
            return;
        }
        
        $template = str_replace('.', '', urldecode($template));
        $catid    = (int)$catid;
        $tpl_path = $serendipity['serendipityPath'] . $serendipity['templatePath'] . $template;
        
        if (!is_dir($tpl_path)) {
            return false;
        }

        $serendipity['GET']['adminModule'] == 'templates';
        $serendipity['smarty_vars']['template_option'] = $template . '_' . $catid;
        
        echo '<h3>' . STYLE_OPTIONS . '</h3>';
        if (file_exists($tpl_path . '/config.inc.php')) {
            serendipity_smarty_init();
            include_once $tpl_path . '/config.inc.php';
        }
        
        if (is_array($template_config)) {
            serendipity_plugin_api::hook_event('backend_templates_configuration_top', $template_config);
        
            if ($serendipity['POST']['adminSubAction'] == 'configure') {
                foreach($serendipity['POST']['template'] AS $option => $value) {
                    categorytemplate_option::set_config($option, $value, $serendipity['smarty_vars']['template_option']);
                }
                echo '<div class="serendipityAdminMsgSuccess"><img style="height: 22px; width: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_success.png') . '" alt="" />' . DONE .': '. sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%H:%M:%S')) . '</div>';
            }
        
            echo '<form method="post" action="serendipity_admin.php">';
            echo '<input type="hidden" name="serendipity[adminModule]" value="templates" />';
            echo '<input type="hidden" name="serendipity[adminSubAction]" value="configure" />';
            echo '<input type="hidden" name="serendipity[adminAction]" value="cattemplate" />';
            echo '<input type="hidden" name="serendipity[adminModule]" value="event_display" />';
            echo '<input type="hidden" name="serendipity[catid]" value="' . $catid . '" />';
            echo '<input type="hidden" name="serendipity[cat_template]" value="' . urlencode($template) . '" />';
        
            include S9Y_INCLUDE_PATH . 'include/functions_plugins_admin.inc.php';
            $template_vars =& serendipity_loadThemeOptions($template_config, $serendipity['smarty_vars']['template_option']);
        
            $template_options = new categorytemplate_option();
            $template_options->import($template_config);
            $template_options->values =& $template_vars;
        
            serendipity_plugin_config(
                $template_options,
                $template_vars,
                $serendipity['template'],
                $serendipity['template'],
                $template_options->keys,
                true,
                true,
                true,
                true,
                'template'
            );
            echo '</form><br />';
            serendipity_plugin_api::hook_event('backend_templates_configuration_bottom', $template_config);
        } else {
            echo '<p>' . STYLE_OPTIONS_NONE . '</p>';
            serendipity_plugin_api::hook_event('backend_templates_configuration_none', $template_config);
        }
    }

    /**
     * The meat of the plugin, called for each registered hook.  
     * @param string event The name of the hook being called
     * @param mixed bag An array of configuration options for this plugin
     * @param mixed eventData An array containing parameters for the hook
     * @param mixed addData Additional hook data, if any
     * @return true
     */
    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            // Update the database on first run if changed.
            $ver = $this->get_config('dbversion', 0);
            if ($ver != CATEGORYTEMPLATE_DB_VERSION) {
                $this->checkScheme($ver);
            }

            switch($event) {
                // When changing category options, display the new extended 
                // options, such as template, future entries, limit, and order
                case 'backend_category_showForm':
                    // The $eventData is the category ID
                    $clang      = $this->fetchLang($eventData, '');
                    $cfuture    = $this->fetchFuture($eventData, '');
                    $styles     = serendipity_fetchTemplates();
                    $template   = $this->fetchTemplate($eventData, '');
                    $hide_rss   = serendipity_db_query("SELECT hide_rss FROM {$serendipity['dbPrefix']}categorytemplates AS t WHERE t.categoryid = {$eventData}", true);
                    if ($hide_rss !== false) {
                        $hide_rss = serendipity_db_bool($hide_rss['hide_rss']);
                    }
?>
    <tr>
        <td valign="top"><label for="template"><?php echo SELECT_TEMPLATE; ?></label></td>
        <td><input class="input_textbox" id="template" type="text" name="serendipity[cat][template]" value="<?php echo $template; ?>" /><br />
            - <?php echo WORD_OR; ?> -<br />
            <select name="serendipity[cat][drop_template]">
                <option value=""><?php echo NONE; ?></option>
<?php
                    foreach ($styles AS $style => $path) {
                        $templateInfo = serendipity_fetchTemplateInfo($style);
?>
            <option value="<?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($style) : htmlspecialchars($style, ENT_COMPAT, LANG_CHARSET)); ?>" <?php echo ($style == $template? 'selected="selected"' : ''); ?>><?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($templateInfo['name']) : htmlspecialchars($templateInfo['name'], ENT_COMPAT, LANG_CHARSET)); ?></option>
<?php
                    }
?>
            </select>
            
            <?php if (!empty($template)) { ?>
            <br /><br /><a class="serendipityPrettyButton" href="serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=cattemplate&amp;serendipity[catid]=<?php echo $eventData; ?>&amp;serendipity[cat_template]=<?php echo urlencode($template);?>"><?php echo STYLE_OPTIONS; ?></a>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td colspan="2"><em><?php echo PLUGIN_CATEGORYTEMPLATES_SELECT; ?></em></td>
    </tr>

<!-- TODO: This does not work easily.
    <tr>
        <td><label for="language"><?php echo INSTALL_LANG; ?></label></td>
        <td><select id="language" name="serendipity[cat][lang]">
            <option value="default"><?php echo USE_DEFAULT; ?></option>
        <?php foreach($serendipity['languages'] AS $langkey => $lang) { ?>
            <option value="<?php echo $lang; ?>" <?php echo ($langkey == $clang ? 'selected="selected"' : ''); ?>><?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($lang) : htmlspecialchars($lang, ENT_COMPAT, LANG_CHARSET)); ?></option>
        <?php } ?>
        </select></td>
    </tr>
-->

    <tr>
        <td><?php echo INSTALL_SHOWFUTURE; ?></td>
        <td>
            <input class="input_radio" type="radio" id ="futureentries_default" name="serendipity[cat][futureentries]" value="0" <?php echo (empty($cfuture) || $cfuture == 0 ? 'checked="checked"' : ''); ?> /><label for="futureentries_default"><?php echo USE_DEFAULT; ?></label><br />
            <input class="input_radio" type="radio" id ="futureentries_no"      name="serendipity[cat][futureentries]" value="1" <?php echo ($cfuture == 1 ? 'checked="checked"' : ''); ?> /><label for="futureentries_no"><?php echo NO; ?></label><br />
            <input class="input_radio" type="radio" id ="futureentries_yes"     name="serendipity[cat][futureentries]" value="2" <?php echo ($cfuture == 2 ? 'checked="checked"' : ''); ?> /><label for="futureentries_yes"><?php echo YES; ?></label>
        </td>
    </tr>


    <tr>
        <td><label for="fetchlimit"><?php echo PLUGIN_CATEGORYTEMPLATES_FETCHLIMIT; ?></label></td>
        <td><input class="input_textbox" id="fetchlimit" type="text" name="serendipity[cat][fetchlimit]" value="<?php echo $this->fetchLimit($eventData, ''); ?>" /></td>
    </tr>

    <tr>
        <td><label for="sort_order"><?php echo SORT_ORDER; ?></label></td>
        <td><input class="input_textbox" id="sort_order" type="text" name="serendipity[cat][sort_order]" value="<?php echo $this->fetchSortOrder($eventData, $this->get_config('sort_order')); ?>" /></td>
    </tr>
    
    <tr>
        <td><label for="hide_rss"><?php echo PLUGIN_CATEGORYTEMPLATES_HIDERSS; ?></label></td>
        <td>
            <input class="input_radio" type="radio" id="hiderss_no"  name="serendipity[cat][hide_rss]" value="0" <?php echo ($hide_rss ? '' : 'checked="checked"'); ?> /><label for="hiderss_no"><?php echo NO; ?></label><br />
            <input class="input_radio" type="radio" id="hiderss_yes"  name="serendipity[cat][hide_rss]" value="1" <?php echo ($hide_rss ? 'checked="checked"' : ''); ?> /><label for="hiderss_yes"><?php echo YES; ?></label><br />
        </td>
    </tr>

<?php if (serendipity_db_bool($this->get_config('pass'))) { ?>
    <tr>
        <td><label for="pass"><?php echo PLUGIN_CATEGORYTEMPLATES_PASS; ?></label></td>
        <td><input class="input_textbox" id="pass" type="text" name="serendipity[cat][pass]" value="<?php echo $this->fetchProp($eventData, 'pass'); ?>" /></td>
    </tr>
<?php }
                    return true;
                    break;

                // When a category is deleted, delete its custom properties
                case 'backend_category_delete':
                    // $eventData is the category ID.  This just deletes.
                    $this->setProps($eventData, null, true);
                    // Remove it from the list of template categories, too.
                    $cidstr = $this->get_config('cat_precedence', false);
                    // No need to modify config if no config set, or if no
                    // templates are templatized
                    if ($cidstr) {
                        $cids = explode(',', $cidstr);
                        // Why doesn't PHP have an array_remove(item)?
                        if (in_array($eventData, $cids)) {
                            $newcids = array();
                            foreach ($cids AS $cid) {
                                if ($cid != $eventData) {
                                    $newcids[] = $cid;
                                }
                            }
                            $cidstr = implode(',', $newcids);
                            $this->set_config('cat_precedence', $cidstr);
                        }
                    }
                    break;

                // When a category is updated or added, modify its properties
                case 'backend_category_update':
                case 'backend_category_addNew':
                    $orig_tpl = $this->fetchTemplate($eventData, '');
                    $text_tpl = $serendipity['POST']['cat']['template']; 
                    $drop_tpl = $serendipity['POST']['cat']['drop_template'];
                    // Default no change to template
                    $set_tpl = $orig_tpl;
                    // If text template changed, it takes precedence 
                    if ($text_tpl != $orig_tpl) {
                        // (even when invalid; no checking)
                        $set_tpl = $text_tpl;
                    } 
                    // If it hasn't changed, drop-down template can override
                    else if ($drop_tpl != $orig_tpl) {
                        $set_tpl = $drop_tpl;
                    }
                    $val = array(
                        'fetchlimit'    => (int)$serendipity['POST']['cat']['fetchlimit'],
                        'template'      => $set_tpl,
                        'categoryid'    => (int)$eventData,
                        'lang'          => $serendipity['POST']['cat']['lang'],
                        'futureentries' => (int)$serendipity['POST']['cat']['futureentries'],
                        'pass'          => $serendipity['POST']['cat']['pass'],
                        'sort_order'    => serendipity_db_escape_string($serendipity['POST']['cat']['sort_order']),
                        'hide_rss'      => $serendipity['POST']['cat']['hide_rss'],
                    );
                    $this->setProps($eventData, $val);
                    // Update list of template categories, too.
                    //
                    // Get the list of customized category IDs, in precedence order
                    $cidstr = $this->get_config('cat_precedence', false);
                    // Only save the new precedence if we can actually
                    // manually change templatized categories precedence
                    if ($cidstr !== false) {
                        if ($cidstr) {
                            // If $cidstr is empty, this returns an array 
                            // with an empty string
                            $cids = explode(',', $cidstr);
                        } else {
                            // For instance, set but empty
                            $cids = array();
                        }
                        // If it had a custom template just added, append it 
                        // to the list (user can change precedence later)
                        if (!in_array($eventData, $cids) && !empty($set_tpl)) {
                            $cids[] = $eventData;
                            $cidstr = implode(',', $cids);
                            $this->set_config('cat_precedence', $cidstr);
                        }
                        // If it had a custom template just deleted, remove it
                        // from the list
                        if (in_array($eventData, $cids) && empty($set_tpl)) {
                            // Why doesn't PHP have an array_remove(item)?
                            $newcids = array();
                            foreach ($cids AS $cid) {
                                if ($cid != $eventData) {
                                    $newcids[] = $cid;
                                }
                            }
                            $cidstr = implode(',', $newcids);
                            $this->set_config('cat_precedence', $cidstr);
                        }
                    }
                    break;

                // When an entry or category is displayed, this changes the
                // CSS to the custom template
                case 'external_plugin':
                    $parts     = explode('_', $eventData);
                    if (!empty($parts[1])) {
                        $param     = (int) $parts[1];
                    } else {
                        $param     = null;
                    }

                    // Shouldn't this just be a string comparison?
                    $methods = array('categorytemplate');

                    if (!in_array($parts[0], $methods)) {
                        return;
                    }

                    $cid = (int)$parts[1];
                    $serendipity['template'] = $this->fetchTemplate($cid, $serendipity['template']);
				    $css_mode = 'serendipity.css';
				    include_once(S9Y_INCLUDE_PATH . 'serendipity.css.php');
				    exit;
				    break;

                // When Serendipity tries to get the entries, check for
                // passwords
                case 'frontend_fetchentries':
                case 'frontend_fetchentry':
                    // Override sort order
                    if (!empty($this->sort_order)) {
                        $eventData['orderby'] = $this->sort_order . (!empty($eventData['orderby']) ? ',' : '') . $eventData['orderby'] . '/*categorytemplate*/';
                    }

                    // Password not required on search or calendar, and we 
                    // don't do rss for them, either
                    if (!isset($addData['source']) ||
                            ($addData['source'] == 'search' || $addData['source'] == 'calendar')) {
                        return true;
                    }

                    // Password and RSS not required for installation
                    if (defined('IN_installer') && IN_installer === true && defined('IN_upgrader') && IN_upgrader === true) {
                        return true;
                    }

                    // Prepare to modify SQL
                    $joins = array();
                    $conds = array();
                    $addkeys = array();

                    // Password protection SQL
                    if (serendipity_db_bool($this->get_config('pass'))) {
                        $conds[] = "(ctpass.pass IS NULL OR ctpass.pass = '{$this->current_pw}' OR ctpass.pass = '')";
                        $joins[] = "LEFT OUTER JOIN {$serendipity['dbPrefix']}categorytemplates ctpass
                            ON (ec.categoryid = ctpass.categoryid)";
                    }

                    // RSS hiding SQL
                    if ($serendipity['view'] == 'feed') {
                        $conds[] = ("(e.id NOT IN (SELECT e.id FROM {$serendipity['dbPrefix']}entries AS e
                            LEFT JOIN {$serendipity['dbPrefix']}entrycat AS ec ON ec.entryid = e.id
                            JOIN {$serendipity['dbPrefix']}categorytemplates AS t ON ec.categoryid = t.categoryid AND hide_rss = '1'))");
                        /*
                        $q = serendipity_db_query("SELECT categoryid FROM {$serendipity['dbPrefix']}categorytemplates WHERE hide_rss = 1");
                        if (is_array($q)) {
                            $hidecats = array();
                            foreach($q as $hidden) {
                                $hidecats[] = $hidden['categoryid'];
                            }
                            $hidecats = implode(';', $hidecats);
                        }
                        if (!empty($hidecats)) {
                            $hide_sql = serendipity_getMultiCategoriesSQL($hidecats, true);
                            $conds[] = $hide_sql;
                        }
                        */
                        
                        /*
                        $addkeys[] = "SUM(ctpass.hide_rss) as cat_hide_rss, ";
                        // Reuse password join if possible
                        if (count($joins) == 0) {
                            $joins[] = "LEFT OUTER JOIN {$serendipity['dbPrefix']}categorytemplates AS ctpass
                                ON (ec.categoryid = ctpass.categoryid)\n";
                        }
                        //$conds[] = "(cat_hide_rss IS NULL OR cat_hide_rss < 1)";
                        //$conds[] = "(ctpass.hide_rss IS NULL OR ctpass.hide_rss = 0)";
                        //$conds[] = "(SUM(ctpass.hide_rss < 1))";
                        $havings[] = '(cat_hide_rss IS NULL OR cat_hide_rss < 1)';
                        */
                    }

                    // Apply query additions
                    // Select keys
                    if (count($addkeys) > 0) {
                        $cond = implode("\n", $addkeys);
                        if (empty($eventData['select'])) {
                            $eventData['addkey'] = $cond;
                        } else {
                            $eventData['addkey'] .= $cond;
                        }
                    }
                    // Conditions
                    if (count($conds) > 0) {
                        $cond = implode(' AND ', $conds);
                        if (empty($eventData['and'])) {
                            $eventData['and'] = " WHERE $cond ";
                        } else {
                            $eventData['and'] .= " AND $cond ";
                        }
                    }
                    // Joins
                    if (count($joins) > 0) {
                        $cond = implode("\n", $joins);
                        if (empty($eventData['joins'])) {
                            $eventData['joins'] = $cond;
                        } else {
                            $eventData['joins'] .= $cond;
                        }
                    }
                    // Havings
                    if (count($havings) > 0) {
                        $cond = implode(' AND ', $havings);
                        if (empty($eventData['having'])) {
                            $eventData['having'] =  "HAVING $cond ";
                        } else {
                            $eventData['having'] .= " AND $cond ";
                        }
                    }

                    return true;
                    break;

                // Experimental code: fetch language for entry
                case 'frontend_configure':
                    // TODO: This does not work. The ID is not present! :-()
                    // $cid = $this->getID(true);
                    // $serendipity['lang']              = $this->fetchLang($cid, $serendipity['lang']);
                    return true;
                    break;

                // When the HTML is generated, apply properties
                case 'genpage':
                    // Get the category in question
                    $cid = $this->getID();
                    $fc  = $this->get_config('fixcat');
                    if ((string)$fc === 'hard') {
                        $fc = 'true';
                    }
                    if ($cid != 'default' && serendipity_db_bool($fc)) {
                        // Need this for category_name to be set.  (?)
                        $serendipity['GET']['category'] = $cid;
                        header('X-FixEntry-Cat: true');
                    }

                    // Reset s9y to use the category's properties
                    $serendipity['fetchLimit']        = $this->fetchLimit($cid, $serendipity['fetchLimit']);
                    $serendipity['showFutureEntries'] = $this->fetchFuture($cid, $serendipity['showFutureEntries']);
                    $serendipity['template']          = $this->fetchTemplate($cid, $serendipity['template']);
                    $this->sort_order                 = $this->fetchSortOrder($cid, $this->get_config('sort_order'));

                    // Set the template options
                    if (!$this->usesDefaultTemplate) {
                        $serendipity['smarty_vars']['template_option'] = $serendipity['template'] . '_' . $cid;
                    }

                    // Check for password
                    if ($cid != 'default' &&
                          serendipity_db_bool($this->get_config('pass')) &&
                          $this->fetchProp($cid, 'pass') != '') {

                        if (!isset($_SERVER['PHP_AUTH_PW']) || $_SERVER['PHP_AUTH_PW'] != $this->fetchProp($cid, 'pass')) {
                            header('WWW-Authenticate: Basic realm="' . PLUGIN_CATEGORYTEMPLATES_PASS_USER . '"');
                            header("HTTP/1.0 401 Unauthorized");
                            header('Status: 401 Unauthorized');
                            echo PLUGIN_CATEGORYTEMPLATES_PASS_USER;
                            exit;
                        } else {
                            $this->current_pw = $_SERVER['PHP_AUTH_PW'];
                        }
                    }

                    // Set the template stylesheet
                    $serendipity['smarty_vars']['head_link_stylesheet'] = serendipity_rewriteURL('plugin/categorytemplate_' . $cid, 'baseURL', true);
                    return true;
                    break;

                // When the back end is displayed, use the custom template, too
                case 'backend_sidebar_entries_event_display_cattemplate':
                    if (empty($serendipity['GET']['cat_template'])) {
                        $serendipity['GET']['cat_template'] = $serendipity['POST']['cat_template'];
                    }

                    if (empty($serendipity['GET']['catid'])) {
                        $serendipity['GET']['catid'] = $serendipity['POST']['catid'];
                    }

                    $old = $serendipity['GET']['adminModule'];
                    $serendipity['GET']['adminModule'] = 'templates';
                    $this->template_options($serendipity['GET']['cat_template'], $serendipity['GET']['catid']);
                    $serendipity['GET']['adminModule'] = $old;
                    return true;
                    break;

                default:
                    return true;
                    break;
            }
        } else {
            return false;
        }
    }
}

class categorytemplate_option {
    var $config = null;
    var $values = null;
    var $keys   = null;

    function introspect_config_item($item, &$bag) {
        foreach($this->config[$item] AS $key => $val) {
            $bag->add($key, $val);
        }
    }

    function get_config($item) {
        return $this->values[$item];
    }

    function set_config($item, $value, $okey = '') {
        global $serendipity;
        serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}options
                               WHERE okey = 't_" . serendipity_db_escape_string($okey) . "'
                                 AND name = '" . serendipity_db_escape_string($item) . "'");
        serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}options (okey, name, value)
                                   VALUES ('t_" . serendipity_db_escape_string($okey) . "', '" . serendipity_db_escape_string($item) . "', '" . serendipity_db_escape_string($value) . "')");
        return true;
    }

    function import(&$config) {
        foreach($config AS $key => $item) {
            $this->config[$item['var']] = $item;
            $this->keys[$item['var']]   = $item['var'];
        }
    }
}
/* vim: set ts=4 sts=4 sw=4 expandtab: */
