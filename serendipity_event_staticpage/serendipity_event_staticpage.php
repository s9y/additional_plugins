<?php
     #http://board.s9y.org/viewtopic.php?p=57348#57348

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

define ('debug_staticpage','false');

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_staticpage extends serendipity_event
{
    var $staticpage = array();
    var $pagetype = array();
    var $pluginstats = array();
    var $error_404 = FALSE;

    var $config = array(
            'headline',
            'permalink',
            'pagetitle',
            'articletype',
            'publishstatus',
            'language',
            'content',
            'markup',
            'articleformat',
            'articleformattitle',

            'authorid',
            'parent_id',
            'related_category_id',
            'show_childpages',
            'pre_content',

            'pass',
            'filename',
            'is_startpage',
            'is_404_page',
            'pageorder',
            'shownavi',
            'showonnavi',
            'showmeta',
            'timestamp',
            'show_breadcrumb',
            'title_element',
            'meta_description',
            'meta_keywords'
        );

    var $config_types = array(
            'description',
            'template',
            'image'
        );

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name', STATICPAGE_TITLE);
        $propbag->add('description', STATICPAGE_TITLE_BLAHBLAH);

        $propbag->add('event_hooks', array(
            'backend_category_addNew'                           => true,
            'backend_category_update'                           => true,
            'backend_category_delete'                           => true,
            'backend_category_showForm'                         => true,
            'backend_sidebar_entries_event_display_staticpages' => true,
            'backend_sidebar_entries'                           => true,
            'entries_header'                                    => true,
            'entries_footer'                                    => true,
            'external_plugin'                                   => true,
            'entry_display'                                     => true,
            'genpage'                                           => true,
            'css_backend'                                       => true,
            'frontend_fetchentries'                             => true,
            'backend_media_rename'                              => true,
            'frontend_rss'                                      => true,
            'frontend_header'                                   => true
        ));

        $propbag->add('page_configuration', $this->config);
        $propbag->add('type_configuration', $this->config_types);
        $propbag->add('author', 'Marco Rinck, Garvin Hicking, David Rolston, Falk Doering, Stephan Manske, Pascal Uhlmann, Ian, Don Chambers');
        $propbag->add('version', '4.15');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('stackable', false);
        $propbag->add('groups', array('BACKEND_EDITOR', 'BACKEND_FEATURES'));
        $propbag->add('configuration', array(
            'markup',
            'articleformat',
            'show_childpages',
            'pass',
            'is_startpage',
            'is_404_page',
            'shownavi',
            'show_breadcrumb',
            'showonnavi',
            'showtextorheadline',
            'showmeta',
            'use_quicksearch'
        ));
        $this->cachefile = $serendipity['serendipityPath'] . PATH_SMARTY_COMPILE . '/staticpage_pagelist.dat';
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch ($name) {
            case 'use_quicksearch':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           QUICKSEARCH);
                $propbag->add('description',    STATICPAGE_QUICKSEARCH_DESC);
                $propbag->add('default',        true);
                break;

            case 'shownavi':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_SHOWNAVI_DEFAULT);
                $propbag->add('description',    STATICPAGE_DEFAULT_DESC);
                $propbag->add('default',        '1');
                break;

            case 'showonnavi':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_SHOWONNAVI_DEFAULT);
                $propbag->add('description',    STATICPAGE_DEFAULT_DESC);
                $propbag->add('default',        '1');
                break;

            case 'showmeta':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_SHOWMETA_DEFAULT);
                $propbag->add('description',    STATICPAGE_DEFAULT_DESC);
                $propbag->add('default',        '1');
                break;

            case 'show_breadcrumb':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_SHOW_BREADCRUMB_DEFAULT);
                $propbag->add('description',    STATICPAGE_DEFAULT_DESC);
                $propbag->add('default',        '1');
                break;

            case 'markup':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_SHOWMARKUP_DEFAULT);
                $propbag->add('description',    STATICPAGE_DEFAULT_DESC);
                $propbag->add('default',        '1');
                break;

            case 'articleformat':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_SHOWARTICLEFORMAT_DEFAULT);
                $propbag->add('description',    STATICPAGE_DEFAULT_DESC);
                $propbag->add('default',        '1');
                break;

            case 'show_childpages':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_SHOWCHILDPAGES_DEFAULT);
                $propbag->add('description',    STATICPAGE_DEFAULT_DESC);
                $propbag->add('default',        '1');
                break;

            case 'showtextorheadline':
                $propbag->add('type',           'radio');
                $propbag->add('name',           STATICPAGE_SHOWTEXTORHEADLINE_NAME);
                $propbag->add('description',    '');
                $propbag->add('radio',          array(
                                                    'value' => array('true', 'false'),
                                                    'desc'  => array(STATICPAGE_SHOWTEXTORHEADLINE_TEXT, STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE)
                                                ));
                $propbag->add('default',        'false');
                break;

            default:
                return false;
        }
        return true;
    }

    function introspect_item($name, &$propbag)
    {
        global $serendipity;

        switch ($name) {
            case 'headline':
                $propbag->add('type',           'string');
                $propbag->add('name',           STATICPAGE_HEADLINE);
                $propbag->add('description',    STATICPAGE_HEADLINE_BLAHBLAH);
                $propbag->add('default',        '');
                break;

            case 'filename':
                $propbag->add('type',           'hidden');
                $propbag->add('name',           STATICPAGE_FILENAME_NAME);
                $propbag->add('description',    STATICPAGE_FILENAME_DESC);
                $propbag->add('default',        'plugin_staticpage.tpl');
                break;

            case 'title_element':
                $propbag->add('type',          'string');
                $propbag->add('name',           STATICPAGES_CUSTOM_META_TITLE);
                $propbag->add('description',    STATICPAGES_CUSTOM_META_TITLE_BLAH_BLAH);
                $propbag->add('default',        '');
                break;

            case 'meta_description':
                $propbag->add('type',          'string');
                $propbag->add('name',           STATICPAGES_CUSTOM_META_DESC);
                $propbag->add('description',    STATICPAGES_CUSTOM_META_DESC_BLAH_BLAH);
                $propbag->add('default',        '');
                break;

            case 'meta_keywords':
                 $propbag->add('type',          'string');
                $propbag->add('name',           STATICPAGES_CUSTOM_META_KEYS);
                $propbag->add('description',    STATICPAGES_CUSTOM_META_KEYS_BLAH_BLAH);
                $propbag->add('default',        '');
                break;

            case 'content':
                $propbag->add('type',           'html');
                $propbag->add('name',           CONTENT);
                $propbag->add('description',    CONTENT_BLAHBLAH);
                $propbag->add('default',        '');
                break;

            case 'permalink':
                $propbag->add('type',           'string');
                $propbag->add('name',           STATICPAGE_PERMALINK);
                $propbag->add('description',    STATICPAGE_PERMALINK_BLAHBLAH);
                $propbag->add('default',        $serendipity['rewrite'] != 'none'
                                                ? $serendipity['serendipityHTTPPath'] . 'pages/pagetitle.html'
                                                : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/pages/pagetitle.html');
                break;

            case 'pagetitle':
                $propbag->add('type',           'string');
                $propbag->add('name',           STATICPAGE_PAGETITLE);
                $propbag->add('description',    '');
                $propbag->add('default',        'pagetitle');
                break;

            case 'timestamp':
                $propbag->add('type',           'timestamp');
                $propbag->add('name',           DATE);
                $propbag->add('description',    GENERAL_PLUGIN_DATEFORMAT . ': ' . DATE_FORMAT_SHORT);
                $propbag->add('default',        '');
                break;

            case 'pass':
                $propbag->add('type',           'string');
                $propbag->add('name',           PASSWORD);
                $propbag->add('description',    STATICPAGE_PASSWORD_NOTICE);
                $propbag->add('default',        '');
                break;

            case 'markup':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           DO_MARKUP);
                $propbag->add('description',    DO_MARKUP_DESCRIPTION);
                $propbag->add('default',        $this->get_config('markup', true));
                break;

            case 'articleformat':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_ARTICLEFORMAT);
                $propbag->add('description',    STATICPAGE_ARTICLEFORMAT_BLAHBLAH);
                $propbag->add('default',        $this->get_config('articleformat', true));
                break;

            case 'articleformattitle':
                $propbag->add('type',           'string');
                $propbag->add('name',           STATICPAGE_ARTICLEFORMAT_PAGETITLE);
                $propbag->add('description',    STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH);
                $propbag->add('default',        $serendipity['blogTitle'] . ' :: ' . $this->pagetitle);
                break;

            case 'parent_id':
                $propbag->add('type',           'select');
                $propbag->add('name',           STATICPAGE_PARENTPAGES_NAME);
                $propbag->add('description',    STATICPAGE_PARENTPAGE_DESC);
                $propbag->add('select_values',  $this->selectPages());
                $propbag->add('default',        STATICPAGE_PARENTPAGE_PARENT);
                break;

            case 'authorid':
                $propbag->add('type',           'select');
                $propbag->add('name',           STATICPAGE_AUTHORS_NAME);
                $propbag->add('description',    STATICPAGE_AUTHORS_DESC);
                $propbag->add('select_values',  $this->selectAuthors());
                $propbag->add('default',        $serendipity['authorid']);
                break;

            case 'show_childpages':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_SHOWCHILDPAGES_NAME);
                $propbag->add('description',    STATICPAGE_SHOWCHILDPAGES_DESC);
                $propbag->add('default',        $this->get_config('show_childpages','false'));
                break;

            case 'pre_content':
                $propbag->add('type',           'html');
                $propbag->add('name',           STATICPAGE_PRECONTENT_NAME);
                $propbag->add('description',    STATICPAGE_PRECONTENT_DESC);
                $propbag->add('default',        '');
                break;

            case 'is_startpage':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_IS_STARTPAGE);
                $propbag->add('description',    STATICPAGE_IS_STARTPAGE_DESC);
                $propbag->add('default',        'false');
                break;

            case 'is_404_page':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_IS_404_PAGE);
                $propbag->add('description',    STATICPAGE_IS_404_PAGE_DESC);
                $propbag->add('default',        'false');
                break;

            case 'articletype':
                $propbag->add('type',           'select');
                $propbag->add('name',           STATICPAGE_ARTICLETYPE);
                $propbag->add('description',    STATICPAGE_ARTICLETYPE_DESC);
                $propbag->add('select_values',  $this->selectPageTypes());
                $propbag->add('default',        $serendipity['POST']['articletype']);
                break;

            case 'shownavi':
                $propbag->add('type',            'boolean');
                $propbag->add('name',            STATICPAGE_SHOWNAVI);
                $propbag->add('description',     STATICPAGE_SHOWNAVI_DESC);
                $propbag->add('default',         $this->get_config('shownavi'));
                break;

            case 'showonnavi':
                $propbag->add('type',            'boolean');
                $propbag->add('name',            STATICPAGE_SHOWONNAVI);
                $propbag->add('description',     STATICPAGE_SHOWONNAVI_DESC);
                $propbag->add('default',         $this->get_config('showonnavi'));
                break;

            case 'show_breadcrumb':
                $propbag->add('type',            'boolean');
                $propbag->add('name',            STATICPAGE_SHOW_BREADCRUMB);
                $propbag->add('description',     STATICPAGE_SHOW_BREADCRUMB_DESC);
                $propbag->add('default',         $this->get_config('show_breadcrumb'));
                break;

                case 'publishstatus':
                $propbag->add('type',           'select');
                $propbag->add('name',           STATICPAGE_PUBLISHSTATUS);
                $propbag->add('description',    STATICPAGE_PUBLISHSTATUS_DESC);
                $propbag->add('select_values',  array(DRAFT, PUBLISH));
                $propbag->add('default',        '');
                break;

            case 'language':
                $propbag->add('type',           'select');
                $propbag->add('name',           INSTALL_LANG);
                $propbag->add('description',    STATICPAGE_LANGUAGE_DESC);
                $propbag->add('select_values',  $this->getLanguages());
                $propbag->add('default',        $serendipity['lang']);
                break;

            case 'related_category_id':
                $propbag->add('type',           'select');
                $propbag->add('name',           STATICPAGE_RELATED_CATEGORY);
                $propbag->add('description',    STATICPAGE_RELATED_CATEGORY_DESCRIPTION);
                $propbag->add('select_values',  $this->getRelatedCategories());
                $propbag->add('default',        '');
                break;

            default:
                return false;
        }
        return true;
    }

    function introspect_item_type($name, &$propbag)
    {
        global $serendipity;

        switch ($name) {
            case 'description':
                $propbag->add('type',           'string');
                $propbag->add('name',           STATICPAGE_ARTICLETYPE_DESCRIPTION);
                $propbag->add('description',    STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC);
                $propbag->add('default',        '');
                break;

            case 'template':
                $propbag->add('type',           'string');
                $propbag->add('name',           STATICPAGE_ARTICLETYPE_TEMPLATE);
                $propbag->add('description',    STATICPAGE_ARTICLETYPE_TEMPLATE_DESC);
                $propbag->add('default',        '');
                break;

            case 'image':
                $propbag->add('type',           'string');
                $propbag->add('name',           STATICPAGE_ARTICLETYPE_IMAGE);
                $propbag->add('description',    STATICPAGE_ARTICLETYPE_IMAGE_DESC);
                $propbag->add('default',        '');
                break;
            default:
                return false;
        }
        return true;
    }

    /**
     *
     * get the realname form all authors
     *
     * @access private
     * @return array    key: userid, value: realname
     *
     */

    function selectAuthors()
    {
        global $serendipity;

        $users = (array)serendipity_fetchUsers();
        foreach ($users as $user) {
            if ($this->checkUser($user)) {
                $u[$user['authorid']] = $user['realname'];
            }
        }
        return $u;
    }

    function getLanguages()
    {
        global $serendipity;

        $lang['all'] = LANG_ALL;
        $lang = array_merge($lang, $serendipity['languages']);
        return $lang;
    }

    function getRelatedCategories()
    {
        global $serendipity;

        $res = serendipity_fetchCategories($serendipity['authorid']);
        $ret[0] = NONE;
        if (is_array($res)) {
            foreach ($res as $value) {
                $ret[$value['categoryid']] = $value['category_name'];
            }
        }
        return $ret;
    }

    /**
     *
     * get the realname from the author id
     *
     * @access private
     * @return mixed    realname if match, else false
     *
     */

    function selectAuthor($id)
    {
        global $serendipity;

        $users = (array)serendipity_fetchUsers();
        foreach ($users as $user) {
            if($user['authorid'] == $id) {
                return $user['realname'];
            }
        }
        return false;
    }

    /**
     *
     * check if the user have the needed rights to do something by user array
     *
     * @access private
     * @return boolean
     *
     */

    function checkUser(&$user)
    {
        global $serendipity;

        return (($user['userlevel'] < $serendipity['serendipityUserlevel']) || ($user['authorid'] == $serendipity['authorid']) || ($serendipity['serendipityUserlevel'] >= USERLEVEL_ADMIN));
    }

    /**
     *
     * check if the user have the needed rights to do something by userid
     *
     * @see    checkUser
     * @access private
     * @return boolean
     *
     */

    function checkPageUser($authorid)
    {
        global $serendipity;

        if ((empty($authorid)) || ((int)$authorid === 0)) {
            return true;
        }

        $user = (array)serendipity_fetchUsers($authorid);

        return $this->checkUser($user[0]);
    }

    /**
     *
     * get all created staticpages
     *
     * @access private
     * @return array    array of pages
     *
     */

    function selectPages()
    {
        global $serendipity;

        $p = array('0' => STATICPAGE_PARENTPAGE_PARENT);

        $q = 'SELECT id, authorid, pagetitle, parent_id
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE content != \'plugin\'
            ORDER BY parent_id, pageorder';
        $pages = serendipity_db_query($q, false, 'assoc');
        if (is_array($pages)) {
            $pages = serendipity_walkRecursive($pages);
            foreach ($pages as $page) {
                if ($this->checkPageUser($page['authorid']) && $serendipity['POST']['staticpage'] != $page['id']) {
                    $p[$page['id']] = str_repeat('', $page['depth']) . $page['pagetitle'];
                }
            }
        }
        return $p;
    }

    /**
     *
     * get a list of all pagetypes
     *
     * @access private
     * @return mixed    array if pagetypes, else false
     *
     */

    function selectPageTypes()
    {
        global $serendipity;

        $q = 'SELECT id, description
                FROM '.$serendipity['dbPrefix'].'staticpages_types';
        $types = serendipity_db_query($q, false, 'assoc');
        if (is_array($types)) {
            foreach ($types as $type) {
                $t[$type['id']] = $type['description'];
            }
            return $t;
        }
        return false;
    }

    /**
     * check if sidebar plugin is available for install
     */
    function sb_plugin_status() {
        $plugins = serendipity_plugin_api::enum_plugins('*', false, 'serendipity_plugin_staticpage');
        if(is_array($plugins) && !empty($plugins[0]['name'])) {
            return true;
        }
        return false;
    }

    /**
     *
     * are plugins installed, available or not
     *
     * @access private
     *
     */

    function pluginstatus()
    {
        global $serendipity;

        $uplugs = array(
            'serendipity_event_downloadmanager',
            'serendipity_event_guestbook',
            'serendipity_event_forum',
            'serendipity_event_contactform',
            'serendipity_event_thumbnails',
            'serendipity_event_usergallery',
            'serendipity_event_faq'
        );
        $plugins = serendipity_plugin_api::get_installed_plugins('event');
        $classes = serendipity_plugin_api::enum_plugin_classes('event');

        foreach ($uplugs as $plugin) {
            if (in_array($plugin, $plugins)) {
                $this->pluginstats[$plugin] = array(
                    'status' => STATICPAGE_PLUGINS_INSTALLED,
                    'color' => 'Green'
                );
            } elseif (isset($classes[$plugin])) {
                $this->pluginstats[$plugin] = array(
                    'status' => STATICPAGE_PLUGIN_AVAILABLE,
                    'color' => 'Yellow'
                );
            } else {
                $this->pluginstats[$plugin] = array(
                    'status' =>STATICPAGE_PLUGIN_NOTAVAILABLE,
                    'color' => 'Red'
                );
            }
        }
    }

    /**
     *
     * prepare an list with available plugins for use in staticpage
     *
     * @access private
     * @return array
     *
     */

    function selectPlugins()
    {
        global $serendipity;

        $plugins = serendipity_plugin_api::get_installed_plugins('event');

        foreach ($plugins as $plugin) {
            switch ($plugin) {

                case 'serendipity_event_downloadmanager':
                    if ($serendipity['rewrite'] == 'none') {
                        $q = 'SELECT value
                                FROM '.$serendipity['dbPrefix'].'config
                               WHERE name LIKE \'serendipity_event_downloadmanager%pageurl\'';
                    } else {
                        $q = 'SELECT value
                                FROM '.$serendipity['dbPrefix'].'config
                               WHERE name LIKE \'serendipity_event_downloadmanager%permalink\'';
                    }
                    $ret = serendipity_db_query($q, true, 'assoc');
                    if (is_array($ret)) {
                        if ($serendipity['rewrite'] == 'none') {
                            $page[$plugin]['link'] = $serendipity['serendipityHTTPPath'].$serendipity['indexFile'].'?serendipity[subpage]='.$ret['value'];
                        } else {
                            $page[$plugin]['link'] = $ret['value'];
                        }
                        $page[$plugin]['name'] = PLUGIN_DOWNLOADMANAGER_TITLE;
                    }
                    break;

                case 'serendipity_event_guestbook':
                    $q = 'SELECT value
                            FROM '.$serendipity['dbPrefix'].'config
                           WHERE name LIKE \'serendipity_event_guestbook%'.(($serendipity['rewrite'] != 'none') ? 'permalink' : 'pagetitle').'\'';
                    $ret = serendipity_db_query($q, true, 'assoc');
                    if (is_array($ret)) {
                        $page[$plugin]['name'] = (defined('GUESTBOOK_TITLE') ? GUESTBOOK_TITLE : PLUGIN_GUESTBOOK_TITLE);
                        if ($serendipity['rewrite'] != 'none') {
                            $page[$plugin]['link'] = $ret['value'];
                        } else {
                            $page[$plugin]['link'] = $serendipity['serendipityHTTPPath'].$serendipity['indexFile'].'?serendipity[subpage]='.$ret['value'];
                        }
                    }
                    break;

                case 'serendipity_event_forum':
                    $q = 'SELECT value
                            FROM '.$serendipity['dbPrefix'].'config
                           WHERE name LIKE \'serendipity_event_forum%pageurl\'';
                    $ret = serendipity_db_query($q, true, 'assoc');
                    if (is_array($ret)) {
                        $page[$plugin] = array(
                            'name' => PLUGIN_FORUM_TITLE,
                            'link' => $serendipity['serendipityHTTPPath'].$serendipity['indexFile'].'?serendipity[subpage]='.$ret['value']
                        );
                    }
                    break;

                case 'serendipity_event_contactform':
                    $q = 'SELECT value
                            FROM '.$serendipity['dbPrefix'].'config
                           WHERE name LIKE \'serendipity_event_contactform%'.(($serendipity['rewrite'] != 'none') ? 'permalink' : 'pagetitle').'\'';
                    $ret = serendipity_db_query($q, true, 'assoc');
                    if (is_array($ret)) {
                        if ($serendipity['rewrite'] != 'none') {
                            $page[$plugin]['link'] = $ret['value'];
                        } else {
                            $page[$plugin]['link'] = $serendipity['serendipityHTTPPath'].$serendipity['indexFile'].'?serendipity[subpage]='.$ret['value'];
                        }
                    }
                    $page[$plugin]['name'] = PLUGIN_CONTACTFORM_TITLE;
                    break;

                case 'serendipity_event_thumbnails':
                    $page[$plugin] = array(
                        'name' => THUMBPAGE_TITLE,
                        'link' => $serendipity['serendipityHTTPPath'].$serendipity['indexFile'].'?serendipity[page]=thumbs'
                    );
                    break;

                case 'serendipity_event_usergallery':
                    if ($serendipity['rewrite'] == 'none') {
                        $q = 'SELECT value
                                FROM '.$serendipity['dbPrefix'].'config
                               WHERE name LIKE \'serendipity_event_usergallery%subpage\'';
                    } else {
                        $q = 'SELECT value
                                FROM '.$serendipity['dbPrefix'].'config
                               WHERE name LIKE \'serendipity_event_usergallery%permalink\'';
                    }
                    $ret = serendipity_db_query($q, true, 'assoc');
                    if (is_array($ret)) {
                        if ($serendipity['rewrite'] == 'none') {
                            $page[$plugin]['link'] = $serendipity['serendipityHTTPPath'].$serendipity['indexFile'].'?serendipity[subpage]='.$ret['value'];
                        } else {
                            $page[$plugin]['link'] = $ret['value'];
                        }
                        $page[$plugin]['name'] = PLUGIN_EVENT_USERGALLERY_TITLE;
                    }
                    break;

                case 'serendipity_event_faq':
                    $q = 'SELECT value
                            FROM '.$serendipity['dbPrefix'].'config
                           WHERE name LIKE \'serendipity_event_faq%faqurl\'';
                    $ret = serendipity_db_query($q, true, 'assoc');
                    if (is_array($ret)) {
                        if ($serendipity['rewrite'] == 'none') {
                            $page[$plugin]['link'] = $serendipity['serendipityHTTPPath'].$serendipity['indexFile'].'?/'.$serendipity['permalinkPluginPath'].'/'.$ret['value'];
                        } else {
                            $page[$plugin]['link'] = $serendipity['serendipityHTTPPath'].$serendipity['permalinkPluginPath'].'/'.$ret['value'];
                        }
                        $page[$plugin]['name'] = FAQ_NAME;
                    }
                    break;

            }
        }
        return $page;
    }

    /**
     *
     * Manage the database tables for staticpage
     *
     * @access private
     * @return void
     *
     */

    function setupDB()
    {
        global $serendipity;

        $built = $this->get_config('db_built', null);
        $fresh = false;
        if ((empty($built)) && (!defined('STATICPAGE_UPGRADE_DONE'))) {
            serendipity_db_schema_import("CREATE TABLE {$serendipity['dbPrefix']}staticpages (
                    id {AUTOINCREMENT} {PRIMARY},
                    parent_id int(11) default '0',
                    articleformattitle varchar(255) not null default '',
                    articleformat int(1) default '1',
                    markup int(1) default '1',
                    pagetitle varchar(255) not null default '',
                    permalink varchar(255) not null default '',
                    is_startpage int(1) default '0',
                    is_404_page int(1) default '0',
                    show_childpages int(1) not null default '0',
                    content text,
                    pre_content text,
                    headline varchar(255) not null default '',
                    filename varchar(255) not null default '',
                    pass varchar(255) not null default '',
                    timestamp int(10) {UNSIGNED} default null,
                    last_modified int(10) {UNSIGNED} default null,
                    authorid int(11) default '0',
                    pageorder int(4) default '0',
                    articletype int(4) default '0',
                    related_category_id int(4) default 0,
                    shownavi int(4) default '1',
                    showonnavi int(4) default '1',
                    show_breadcrumb int(4) default '1',
                    publishstatus int(4) default '1',
                    language varchar(10) default '') {UTF_8}");

            $old_stuff = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}config WHERE name LIKE 'serendipity_event_staticpage:%'");

            $import = array();
            if (is_array($old_stuff)) {
                foreach ($old_stuff as $item) {
                    $names = explode('/', $item['name']);
                    if (!isset($import[$names[0]])) {
                        $import[$names[0]] = array('authorid' => $item['authorid']);
                    }

                    $import[$names[0]][$names[1]] = serendipity_get_bool($item['value']);
                }
            }

            foreach ($import AS $page) {
                if (is_array($page)) {
                    serendipity_db_insert('staticpages', $page);
                    @unlink($this->cachefile);
                }
            }

            serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}config  WHERE name LIKE 'serendipity_event_staticpage:%'");
            serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}plugins WHERE name LIKE 'serendipity_event_staticpage:%' AND name NOT LIKE '" . serendipity_db_escape_string($this->instance) . "'");
            $this->set_config('db_built', '7');
            $fresh = true;
            @define('STATICPAGE_UPGRADE_DONE', true); // No further static pages may be called!
        }

        switch ($built) {
            case 1: // password not included
                $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN pass varchar(255) not null default ''";
                serendipity_db_schema_import($q);
            case 2: // parent-id not included
                $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN parent_id int(11) default '0'";
                serendipity_db_schema_import($q);
            case 3:
                $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN show_childpages int(1) not null default '0'";
                serendipity_db_schema_import($q); // list of child-pages on parent-page
                $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN pre_content text";
                serendipity_db_schema_import($q); // content
            case 4:
                $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN is_startpage int(1) default '0'";
                serendipity_db_schema_import($q);
            case 5: // enum to re-order staticpages
                $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN pageorder int(4) default '0'";
                serendipity_db_schema_import($q);
            case 6:
                $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN articletype int(4) default '0'";
                serendipity_db_schema_import($q);
            case 7:
                $q = "CREATE TABLE {$serendipity['dbPrefix']}staticpages_types (
                        id {AUTOINCREMENT} {PRIMARY},
                        description varchar(100) not null default '',
                        template varchar(255) not null default '',
                        image varchar(255) not null default '') {UTF_8}";
                serendipity_db_schema_import($q);
                $existing = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}staticpages_types LIMIT 1");
                if (!is_array($existing) || !isset($existing[0]['template'])) {
                    $this->pagetype = array(
                        'description' => 'Article',
                        'template' => 'plugin_staticpage.tpl'
                    );
                    serendipity_db_insert('staticpages_types', $this->pagetype);
                    $this->pagetype = array(
                        'description' => 'Overview',
                        'template' => 'plugin_staticpage_aboutpage.tpl'
                    );
                    serendipity_db_insert('staticpages_types', $this->pagetype);
                    $set = array(
                        'articletype' => 1,
                        'pageorder' => 0
                    );
                    serendipity_db_update('staticpages', array(), $set);
                    @unlink($this->cachefile);
                }
            case 8:
            case 9:
            case 10:
                if (!$fresh) {
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN shownavi int(4) default '1';";
                    serendipity_db_schema_import($q);
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN showonnavi int(4) default '1'";
                    serendipity_db_schema_import($q);
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN publishstatus int(4) default '1';";
                    serendipity_db_schema_import($q);
                    $q = 'DROP TABLE '.$serendipity['dbPrefix'].'staticpages_plugins';
                    serendipity_db_schema_import($q);
                    $q = 'ALTER TABLE '.$serendipity['dbPrefix'].'staticpages ADD COLUMN language varchar(10) default \'\'';
                    serendipity_db_schema_import($q);
                }
            case 11:
                serendipity_db_update('staticpages_types', array('description' => 'Aboutpage'), array('description' => 'Overview'));
            case 12:
                $q = "CREATE {FULLTEXT_MYSQL} INDEX staticentry_idx on {$serendipity['dbPrefix']}staticpages (headline, content);";
                serendipity_db_schema_import($q);
            case 13:
            case 14:
                if (!$fresh) {
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN last_modified int(10)";
                    serendipity_db_schema_import($q);
                    serendipity_db_query("UPDATE {$serendipity['dbPrefix']}staticpages SET last_modified = timestamp");
                }
            case 15:
                if (!$fresh) {
                    $sql = 'ALTER TABLE '.$serendipity['dbPrefix'].'staticpages ADD COLUMN related_category_id int(4) default 0';
                    serendipity_db_schema_import($sql);
                }
            case 16:
                $this->pagetype = array(
                    'description' => 'Staticpage with related category',
                    'template'    => 'plugin_staticpage_related_category.tpl'
                );
                serendipity_db_insert('staticpages_types', $this->pagetype);

                $sql = 'CREATE TABLE '.$serendipity['dbPrefix'].'staticpage_categorypage (
                            categoryid int(4) default 0,
                            staticpage_categorypage int(4) default 0
                        ) {UTF_8}';
                serendipity_db_schema_import($sql);
            case 17:
                $sql = 'CREATE TABLE '.$serendipity['dbPrefix'].'staticpage_custom (
                            staticpage int(11),
                            name varchar(128),
                            value text
                        ) {UTF_8}';
                serendipity_db_schema_import($sql);
            case 18:
                    $sql = 'ALTER TABLE '.$serendipity['dbPrefix'].'staticpages ADD COLUMN is_404_page int(1) default 0';
                    if ($serendipity['dbType'] == 'mysql' || $serendipity['dbType'] == 'mysqli') {
                        $sql .= ' AFTER is_startpage';
                    }
                    serendipity_db_schema_import($sql);
            case 19:
                if (!$fresh) {
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN show_breadcrumb int(4) default '1'";
                    serendipity_db_schema_import($q);
                }
            case 20:
                if (!$fresh) {
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN title_element varchar(255) not null default ''";
                    serendipity_db_schema_import($q);
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN meta_description varchar(255) not null default ''";
                    serendipity_db_schema_import($q);
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN meta_keywords varchar(255) not null default ''";
                    serendipity_db_schema_import($q);
                }
                $this->set_config('db_built', 21);
                break;
        }
    }


    /**
     *
     * Walk throu the staticpage array and return the value by key
     *
     * @see    var staticpage
     * @access private
     * @return string
     *
     */

    function get_static($key, $default = null) /* no more & */
    {
        return (isset($this->staticpage[$key]) ? $this->staticpage[$key] : $default);
    }

    /**
     *
     * Walk throu the pagetype array and return the value by key
     *
     * @see    var pagetype
     * @access private
     * @return string
     *
     */

    function get_type($key, $default = null) /* no more & */
    {
        return (isset($this->pagetype[$key]) ? $this->pagetype[$key] : $default);
    }

    function getEditlinkData()
    {
        global $serendipity;

        $adminlink = array(
            'link_edit' => $serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[action]=admin&amp;serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticid]='.(int)$this->getPageID(),
            'link_name' => STATICPAGE_LINKNAME,
            'page_user' => $this->checkPageUser($this->staticpage['authorid'])
        );

        return $adminlink;
    }

    function getNavigationData()
    {
        global $serendipity;

        $target  = $this->cachefile;
        $timeout = 86400; // One day
        if (file_exists($target) && filemtime($target) > time()-$timeout) {
            $pages = unserialize(file_get_contents($target));
        } else {
            $pages = $this->fetchPublishedStaticPages();
            $pages = (is_array($pages) ? serendipity_walkRecursive($pages) : array());
            $fp = fopen($target, 'w');
            fwrite($fp, serialize($pages));
            fclose($fp);
        }

        $thispage = (int)$this->getPageID();

        for ($i = 0, $maxcount = count($pages); $i < $maxcount; $i++) {
            if ($pages[$i]['depth'] == 0) {
                $top['name']      = $pages[$i]['pagetitle'];
                $top['permalink'] = $pages[$i]['permalink'];
                $top['id']        = $pages[$i]['id'];
            }

            if ($pages[$i]['id'] == $thispage) {
                $nav = array(
                    'prev' => array(
                        'name' => $this->get_config('showtextorheadline') ? STATICPAGE_PREV : $pages[$i-1]['pagetitle'],
                        'link' => $pages[$i-1]['permalink']
                    ),
                    'next' => array(
                        'name' => $this->get_config('showtextorheadline') ? STATICPAGE_NEXT : $pages[$i+1]['pagetitle'],
                        'link' => $pages[$i+1]['permalink']
                    ),
                    'top' => array(
                        'name' => (($top['id'] == $pages[$i-1]['id']) || ($this->get_config('showtextorheadline'))) ? STATICPAGE_TOP : $top['name'],
                        'link' => ($top['id'] == $pages[$i-1]['id'] ? $serendipity['serendipityHTTPPath'] : $top['permalink'])
                    )
                );

                if(empty($nav['prev']['link'])){
                    $nav['prev']['name'] = '';
                }

                if(empty($nav['next']['link'])){
                    $nav['next']['name'] = '';
                }

                if(empty($nav['top']['link'])){
                    $nav['top']['name'] = '';
                }

                // Include breadcrumbs
                $crumbs = array();
                // Add the current page
                $j = $i;
                $pages[$j]['name'] = $pages[$j]['pagetitle'];
                $pages[$j]['link'] = $pages[$j]['permalink'];
                $crumbs[] = $pages[$j];
                $up = $pages[$j]['parent_id'];
                while (($j >= 0) && ($up != 0)) {
                    // Find the parent page index! (Backwards for efficiency)
                    for (; ($j >= 0) && ($pages[$j]['id'] != $up); $j--) {}
                    if (($j >= 0) && ($pages[$j]['id'] == $up)) {
                        // Add the current page
                        $pages[$j]['name'] = $pages[$j]['pagetitle'];
                        $pages[$j]['link'] = $pages[$j]['permalink'];
                        $crumbs[] = $pages[$j];
                        $up = $pages[$j]['parent_id'];
                    }
                }
                // Reverse the breadcrumb array
                $nav['crumbs'] = array_reverse($crumbs);

                return $nav;
            }
        }
        return false;
    }

    function getTemplate($id)
    {
        global $serendipity;

        $q = "SELECT template
                FROM {$serendipity['dbPrefix']}staticpages_types
               WHERE id = '{$id}'";
        $t = serendipity_db_query($q, true, 'assoc');
        return $t['template'];
    }

    function getImage($id)
    {
        global $serendipity;

        $q = "SELECT image
                FROM {$serendipity['dbPrefix']}staticpages_types
               WHERE id = '{$id}'";
        $t = serendipity_db_query($q, true, 'assoc');
        return $t['image'];
    }


    function smarty_init() {
        global $serendipity;
        if (!isset($this->smarty_init)) {
            @include_once dirname(__FILE__) . '/smarty.inc.php';
            if (isset($serendipity['smarty'])) {
                $staticpage_cat = $this->fetchCatProp($serendipity['GET']['category']);
                $serendipity['smarty']->assign('staticpage_categorypage', $this->fetchStaticPageForCat($staticpage_cat));
                $serendipity['smarty']->assign('serendipityArchiveURL', getArchiveURL());
                $serendipity['smarty']->register_function('getCategoryLinkByID', 'smarty_getCategoryLinkByID');
                $serendipity['smarty']->register_function('staticpage_display', 'staticpage_display');
                $serendipity['staticpage_plugin'] =& $this;
                $this->smarty_init = true;
            }
        }
    }

    function parseStaticPage($pagevar = 'staticpage_', $template = 'plugin_staticpage.tpl') { /* No more & */
        global $serendipity;

        $serendipity['content_message'] = ''; // Reset message for 404 error handling which is now overriden

        $filename = $this->get_static('filename');
        if (empty($filename) || $filename == 'none.html') {
            $filename = $template;
        }

        if ($template != 'plugin_staticpage.tpl') {
            $filename = $template;
        } else if ($this->get_static('articletype')) {
            $filename = $this->getTemplate($this->get_static('articletype'));
        }


        serendipity_smarty_init();

        foreach($this->config as $staticpage_config) {
            $cvar = $this->get_static($staticpage_config);
            $serendipity['smarty']->assign($pagevar . $staticpage_config, $cvar);
            // This is a global variable assignment, so that within entries.tpl you can acces $smarty.env.staticpage_pagetitle. Otherwise, $staticpage_pagetitle would only be available to index.tpl and content.tpl
            $_ENV[$pagevar . $staticpage_config] = $cvar;
        }

        if (serendipity_db_bool($this->get_static('markup'))) {
            $entry = array('body' => $this->get_static('content'));
            $entry['staticpage'] =& $entry['body'];
            serendipity_plugin_api::hook_event('frontend_display', $entry);
            if (isset($entry['markup_staticpage'])) {
                $staticpage_content = $entry['staticpage'];
            } else {
                $staticpage_content = $entry['body'];
            }

            $entry = array('body' => $this->get_static('pre_content'));
            $entry['staticpage'] =& $entry['body'];
            if (!empty($entry['body'])) {
                serendipity_plugin_api::hook_event('frontend_display', $entry);
            }
            if (isset($entry['markup_staticpage'])) {
                $staticpage_precontent = $entry['staticpage'];
            } else {
                $staticpage_precontent = $entry['body'];
            }
        } else {
            $staticpage_content    = $this->get_static('content'); // no more &
            $staticpage_precontent = $this->get_static('pre_content'); // no more &
        }



        if ($cpids = $this->getChildPagesID()) {

            foreach($cpids as $cpid) {
                $cpages[] = $this->getStaticPage($cpid);
            }

            foreach($cpages as $cpage) {
                if (strlen($cpage['pre_content'])) {
                    $precontent = $cpage['pre_content']; // no more &
                } else {
                    $precontent = $cpage['content']; // no more &
                }

                if (serendipity_db_bool($cpage['markup'])) {
                    $entry = array('body' => $precontent);
                    $entry['staticpage'] =& $entry['body'];
                    if (!empty($entry['body'])) {
                        serendipity_plugin_api::hook_event('frontend_display', $entry);
                    }
                    if (isset($entry['markup_staticpage'])) {
                        $precontent = $entry['staticpage'];
                    } else {
                        $precontent = $entry['body'];
                    }
                }
                $imgid = ($cpage['articletype'] ? $cpage['articletype'] : 1);
                $childpages[] = array(
                    'image'      => $this->getImage($imgid),
                    'precontent' => $precontent,
                    'permalink'  => $cpage['permalink'],
                    'pagetitle'  => $cpage['pagetitle'],
                    'headline'   => $cpage['headline']
                );

            }
        }


/* this is probably unneeded for the solution with serendipity_fetchPrintEntries - see plugin_staticpage_related_category.tpl - so we can save the costs of a sql-query

            $related_category_entries = null;
            if ($this->get_static('related_category_id') >= 0) {
                if ($this->get_static('related_category_id') > 0) {
                    $serendipity['GET']['category'] = $this->get_static('related_category_id');
                }
                $select_key = "ep_sticky.value AS orderkey, e.id, e.title, e.timestamp";

                $related_category_entries = serendipity_fetchEntries(null,
                                                        false,
                                                        '',
                                                        false,
                                                        false,
                                                        'timestamp DESC',
                                                        '',
                                                        false,
                                                        false,
                                                        $select_key,
                                                        null,
                                                        'array');

                unset($serendipity['GET']['category']);

                if (is_array($related_category_entries)) {
                    for ($i = 0, $ii = count($related_category_entries); $i < $ii; $i++) {
                        $related_category_entries[$i]['link'] = serendipity_archiveURL($related_category_entries[$i]['id'],
                                                                          $related_category_entries[$i]['title'],
                                                                          'baseURL',
                                                                          true);
                    }
                }
            }
*/

        $serendipity['smarty']->assign(
            array(
                $pagevar . 'articleformat'      => serendipity_db_bool($this->get_static('articleformat')),
                $pagevar . 'form_pass'          => isset($serendipity['POST']['pass']) ? $serendipity['POST']['pass'] : '',
                $pagevar . 'form_url'           => $serendipity['baseURL'] . $serendipity['indexFile'] . '?serendipity[subpage]=' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($this->get_static('pagetitle')) : htmlspecialchars($this->get_static('pagetitle'), ENT_COMPAT, LANG_CHARSET)),
                $pagevar . 'content'            => $staticpage_content,
                $pagevar . 'childpages'         => serendipity_db_bool($this->get_static('show_childpages')) ? $this->getChildPages() : false,
                $pagevar . 'extchildpages'      => $childpages,
                $pagevar . 'pid'                => $this->get_static('id'),
                $pagevar . 'precontent'         => $staticpage_precontent,
                $pagevar . 'adminlink'          => $this->getEditlinkData(),
                $pagevar . 'navigation'         => $this->getNavigationData(),
                $pagevar . 'author'             => $this->selectAuthor($this->staticpage['authorid']),
                $pagevar . 'created_on'         => $this->get_static('timestamp'),
                $pagevar . 'lastchange'         => $this->get_static('last_modified'),
                $pagevar . 'shownavi'           => $this->get_static('shownavi'),
                $pagevar . 'show_breadcrumb'    => $this->get_static('show_breadcrumb'),
                $pagevar . 'custom'             => $this->get_static('custom'),
                $pagevar . 'title_element'      => $this->get_static('title_element'),
                $pagevar . 'meta_description'   => $this->get_static('meta_description'),
                $pagevar . 'meta_keywords'      => $this->get_static('meta_keywords')
// same thing as above
//                    $pagevar . 'related_category_entries'           => $related_category_entries
            )
        );
        $filename = basename($filename);
        $tfile    = serendipity_getTemplateFile($filename, 'serendipityPath');
        if (!$tfile || $tfile == $filename) {
            $tfile = dirname(__FILE__) . '/' . $filename;
        }
        $inclusion = $serendipity['smarty']->security_settings[INCLUDE_ANY];
        $serendipity['smarty']->security_settings[INCLUDE_ANY] = true;
        $content = $serendipity['smarty']->fetch('file:'. $tfile);
        $serendipity['smarty']->security_settings[INCLUDE_ANY] = $inclusion;

        return $content;
    }

    function show() {
        global $serendipity;

        if ($this->selected()) {
            if ($this->error_404 === FALSE) {
                serendipity_header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
                serendipity_header('Status: 200 OK');
            }
            else {
                serendipity_header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
                serendipity_header('Status: 404 Not Found');
            }

            echo $this->parseStaticPage();
        }
    }

    function getPageID() {
        global $serendipity;

        if (isset($this->staticpage['id'])) {
            return $this->staticpage['id'];
        }

        $q = "SELECT id
                FROM {$serendipity['dbPrefix']}staticpages
               WHERE pagetitle = '" . serendipity_db_escape_string($serendipity['GET']['subpage']) . "'
                  OR permalink = '" . serendipity_db_escape_string($serendipity['GET']['subpage']) . "'";
        $page = serendipity_db_query($q, true, 'assoc');
        return isset($page['id']) ? $page['id'] : false;
    }

    function getChildPages() {
        global $serendipity;

        $id = (int)$this->getPageID();
        $q = 'SELECT pagetitle, permalink
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE parent_id = '.$id.'
                 AND publishstatus = 1
            ORDER BY pageorder';
        $pages = serendipity_db_query($q, false, 'assoc');
        return is_array($pages) ? $pages : false;

    }

    function getChildPagesID() {
        global $serendipity;

        $id = (int)$this->getPageID();
        $q = 'SELECT id
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE parent_id = '.$id.'
                 AND publishstatus = 1
            ORDER BY pageorder';
        $p = serendipity_db_query($q, false, 'assoc');
        if(is_array($p)) {
            foreach($p as $page) {
                $pages[] = $page['id'];
            }
            return $pages;
        }
        return false;
    }

    function getChildPage($id) // no more &
    {
        global $serendipity;

        $q = 'SELECT pagetitle, permalink
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE parent_id = '.(int)$id.'
                 AND publishstatus = 1';
        $page = serendipity_db_query($q, false, 'assoc');
        return is_array($page) ? $page : false;

    }

    function getSystersID($id) // no more &
    {
        global $serendipity;

        $q = 'SELECT parent_id
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE id = '.(int)$id;
        $parent_id = serendipity_db_query($q, true, 'assoc');

        $q = 'SELECT id, pageorder
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE parent_id = '.$parent_id['parent_id'].'
                 AND publishstatus = 1
            ORDER BY pageorder';
        $pages = serendipity_db_query($q, false, 'assoc');
        return is_array($pages) ? $pages : false;
    }

    function getStaticPage($id) // no more &
    {
        global $serendipity;

        $q = 'SELECT *
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE id = '.(int)$id.'
               LIMIT 1';
        $page = serendipity_db_query($q, true, 'assoc');
        return is_array($page) ? $page : false;
    }

    function selected()
    {
        global $serendipity;

        static $cached = false;

        if (empty($serendipity['GET']['subpage']) && empty($serendipity['GET']['staticid'])) {
            return false;
        }

        if ($cached) {
            return true;
        }

        $sql_where = '';
        if (serendipity_userLoggedIn()) {
            // User is authenticated; drafts and published pages are displayed as equals
            // Previews will thus only work when being logged in.
        } else {
            // User is not authenticated. Only published documents shall be revealed.
            $sql_where .= ' AND publishstatus = 1 ';
        }

        if ( empty($serendipity['GET']['staticid']) )
        {
            $q = "SELECT *
                    FROM {$serendipity['dbPrefix']}staticpages
                   WHERE (pagetitle = '" . serendipity_db_escape_string($serendipity['GET']['subpage']) . "'
                      OR permalink = '" . serendipity_db_escape_string($serendipity['GET']['subpage']) . "') $sql_where
                   LIMIT 1";
        }
        else
        {
            $q = "SELECT *
                    FROM {$serendipity['dbPrefix']}staticpages
                  WHERE (id = '" . serendipity_db_escape_string($serendipity['GET']['staticid']) . "') $sql_where
                  LIMIT 1";
        }
        $page = serendipity_db_query($q, true, 'assoc');
        if (is_array($page)) {
            $this->staticpage =& $page;
            $this->checkPage();
            $cached = true;
            $serendipity['is_staticpage'] = true;
            return true;
        }

        return false;
    }

    function fetchStaticPage($id) // no more &
    {
        global $serendipity;

        $q = 'SELECT *
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE id = '.(int)$id.'
               LIMIT 1';
        $page = serendipity_db_query($q, true, 'assoc');
        if (is_array($page)) {
            $this->staticpage =& $page;
            $this->checkPage();
        }
    }

    function fetchPageType($id) // no more &
    {
        global $serendipity;

        $q = 'SELECT *
                FROM '.$serendipity['dbPrefix'].'staticpages_types
               WHERE id = '.(int)$id.'
              LIMIT 1';
        $type = serendipity_db_query($q, true, 'assoc');
        if(is_array($type)) {
            $this->pagetype = $type; // no more &
        }
    }

    // This function checks the values of a staticpage entry, and maybe adjusts the right values to use.
    // Yeah. PostgreSQL is picky about this.
    function checkPage() {
        global $serendipity;

        if (empty($this->staticpage['filename'])) {
            $this->staticpage['filename'] = 'none.html';
        }
        if (empty($this->staticpage['timestamp'])) {
            $this->staticpage['timestamp'] = time();
        }

        // Try to auto-detect a timestamp
        if (preg_match('@[:\.]@i', $this->staticpage['timestamp'])) {
            if (function_exists('date_parse_from_format')) {
                // Need to convert strftime format (with %) to plain date format (without %)
                $d = DATE_FORMAT_SHORT;
                $d = str_replace('%M', 'i', $d); // Minute is %M in one and i in the other format
                $d = str_replace('%', '', $d); // All other modifiers (%d, %m, %Y %H) stay the same

                $t = date_parse_from_format($d, $this->staticpage['timestamp']);
                $this->staticpage['timestamp'] = mktime($t['hour'], $t['minute'], $t['second'], $t['month'], $t['day'], $t['year']);
            } elseif (function_exists('strptime')) {
                $t = strptime($this->staticpage['timestamp'], DATE_FORMAT_SHORT);
                $this->staticpage['timestamp'] = mktime($t['tm_hour'], $t['tm_min'], $t['tm_sec'], $t['tm_mon'], $t['tm_mday'], $t['tm_year']);
            } else {
                $this->staticpage['timestamp'] = strtotime($this->staticpage['timestamp']);
            }
        }

        if (empty($this->staticpage['last_modified'])) {
            $this->staticpage['last_modified'] = time();
        }

        if (empty($this->staticpage['show_childpages'])) {
            $this->staticpage['show_childpages'] = '0';
        }
        if (empty($this->staticpage['is_startpage'])) {
            $this->staticpage['is_startpage'] = '0';
        }
        if (empty($this->staticpage['is_404_page'])) {
            $this->staticpage['is_404_page'] = '0';
        }
        if (!isset($this->staticpage['markup'])) {
            $this->staticpage['markup'] = '1';
        }
        if (!isset($this->staticpage['publishstatus'])) {
            $this->staticpage['publishstatus'] = '1';
        }
        if (!isset($this->staticpage['shownavi'])) {
            $this->staticpage['shownavi'] = '1';
        }
        if (!isset($this->staticpage['showonnavi'])) {
            $this->staticpage['showonnavi'] = '1';
        }
        if (!isset($this->staticpage['show_breadcrumb'])) {
            $this->staticpage['show_breadcrumb'] = '1';
        }
        if (empty($this->staticpage['markup'])) {
            $this->staticpage['markup'] = '0';
        }
        if (empty($this->staticpage['publishstatus'])) {
            $this->staticpage['publishstatus'] = '0';
        }
        if (empty($this->staticpage['shownavi'])) {
            $this->staticpage['shownavi'] = '0';
        }
        if (empty($this->staticpage['showonnavi'])) {
            $this->staticpage['showonnavi'] = '0';
        }
        if (empty($this->staticpage['show_breadcrumb'])) {
            $this->staticpage['show_breadcrumb'] = '0';
        }
        if (empty($this->staticpage['articletype'])) {
            $this->staticpage['articletype'] = '0';
        }
        if (empty($this->staticpage['pageorder'])) {
            $this->staticpage['pageorder'] = '0';
        }
        if (empty($this->staticpage['authorid'])) {
            $this->staticpage['authorid'] = '0';
        }
        if (empty($this->staticpage['articleformat'])) {
            $this->staticpage['articleformat'] = '0';
        }
        if (empty($this->staticpage['parent_id'])) {
            $this->staticpage['parent_id'] = '0';
        }

        // Fetch Custom properties!
        $q = 'SELECT *
                FROM ' . $serendipity['dbPrefix'] . 'staticpage_custom
               WHERE staticpage = ' . (int)$this->staticpage['id'];
        $custom = serendipity_db_query($q, false, 'assoc');
        if (is_array($custom)) {
            foreach($custom AS $idx => $row) {
                $parts = explode('~', $row['value']);
                if (count($parts) > 1) {
                    $this->staticpage['custom'][$row['name']] = $parts;
                } else {
                    $this->staticpage['custom'][$row['name']] = $row['value'];
                }
            }
        }
    }

    function getStartpage()
    {
        global $serendipity;

        $q = 'SELECT pagetitle
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE is_startpage = 1
                 AND (language = \'' . $serendipity['lang'] . '\'
                  OR  language = \'all\'
                  OR  language = \'\')
            ORDER BY id DESC
               LIMIT 1';
        $page = serendipity_db_query($q, true, 'assoc');

        return (is_array($page) && isset($page['pagetitle'])) ? $page['pagetitle'] : false;
    }

    function get404Errorpage()
    {
        global $serendipity;

        $q = 'SELECT pagetitle
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE is_404_page = 1
                 AND (language = \'' . $serendipity['lang'] . '\'
                  OR  language = \'all\'
                  OR  language = \'\')
            ORDER BY last_modified DESC
               LIMIT 1';
        $page = serendipity_db_query($q, true, 'assoc');

        return (is_array($page) && isset($page['pagetitle'])) ? $page['pagetitle'] : false;
    }

    function updateStaticPage()
    {
        global $serendipity;

        $this->checkPage();
        $this->staticpage['last_modified'] = time();
        $insert_page = $this->staticpage;
        unset($insert_page['custom']);

        if (!isset($this->staticpage['id'])) {
            $cpo = $this->getChildPage($insert_page['parent_id']);
            if (is_bool($cpo)) {
                $this->staticpage['pageorder'] = 1;
            } else {
                $this->staticpage['pageorder'] = count($cpo)+1;
            }
            @unlink($this->cachefile);
            $result = serendipity_db_insert('staticpages', $insert_page);
            $serendipity['POST']['staticpage'] = $pid = serendipity_db_insert_id('staticpages', 'id');
            serendipity_plugin_api::hook_event('backend_staticpages_insert', $insert_page);
        } else {
            @unlink($this->cachefile);
            $pid = $insert_page['id'];
            $result = serendipity_db_update('staticpages', array('id' => $insert_page['id']), $insert_page);
            serendipity_plugin_api::hook_event('backend_staticpages_update', $insert_page);
        }

        // Store custom properties
        if (is_array($serendipity['POST']['plugin']['custom'])) {
            foreach($serendipity['POST']['plugin']['custom'] AS $custom_name => $custom_value) {
                if (is_array($custom_value)) {
                    $custom_value = implode('~', $custom_value);
                }

                // Delete first. Might not exist, but then we can safely issue an INSERT statement.
                serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}staticpage_custom
                                            WHERE staticpage = " . (int)$pid . "
                                              AND name = '" . serendipity_db_escape_string($custom_name) . "'");

                serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}staticpage_custom (staticpage, name, value)
                                           VALUES (" . (int)$pid . ", '" . serendipity_db_escape_string($custom_name) . "', '" . serendipity_db_escape_string($custom_value) . "')");
            }
            $this->staticpage['custom'] = $serendipity['POST']['plugin']['custom'];
        }

        return $result;
    }

    function updatePageType()
    {
        global $serendipity;

        if (!isset($this->pagetype['id'])) {
            $result = serendipity_db_insert('staticpages_types', $this->pagetype);
            if (is_string($result)) {
                echo '<span class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> ERROR: ' . $result . '</span>';
            }
            $serendipity["POST"]["pagetype"] = serendipity_db_insert_id('staticpages_types', 'id');
        } else {
            $result = serendipity_db_update('staticpages_types', array('id' => $this->pagetype['id']), $this->pagetype);
            if (is_string($result)) {
                echo '<span class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> ERROR: ' . $result . '</span>';
            }
        }
    }

    function fetchStaticPages($plugins = false, $match_permalink = '') // no more &
    {
        global $serendipity;

        $q = 'SELECT *
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE 1 = 1';
        if(!$plugins) {
            $q .= ' AND content != \'plugin\'';
        }

        if ($match_permalink != '') {
            $q .= " AND permalink = '" . serendipity_db_escape_string($match_permalink) . "' ";
        }
        $q .= ' ORDER BY parent_id, pageorder';
        return serendipity_db_query($q);
    }

    function fetchPublishedStaticPages() // no more &
    {
        global $serendipity;

        $pub = serendipity_db_query("SELECT id, pagetitle, parent_id, permalink FROM {$serendipity['dbPrefix']}staticpages WHERE publishstatus = 1 ORDER BY parent_id, pageorder");
        return is_array($pub) ? $pub : false;
    }

    function fetchPageTypes() // no more &
    {
        global $serendipity;

        return serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}staticpages_types", false, 'assoc');
    }

    function fetchPlugins() // no more &
    {
        global $serendipity;

        $q = "SELECT id, pagetitle, permalink, pre_content
                FROM ".$serendipity['dbPrefix']."staticpages
               WHERE content = 'plugin'
              ORDER BY pageorder";
        $res = (array)serendipity_db_query($q, false, 'assoc');
        foreach($res as $plugin){
            $ret[$plugin['pre_content']] = array(
                'pagetitle' => $plugin['pagetitle'],
                'permalink' => $plugin['permalink'],
                'id'        => $plugin['id']
            );
        }
        return $ret;
    }

    function showBackend()
    {
        global $serendipity;

        // check sidebar plugin availability
        $sbplav = (!$this->sb_plugin_status() ? true : false);

        if (isset($serendipity['GET']['staticid']) && !isset($serendipity['POST']['staticpage'])) {
             $serendipity['POST']['staticpage'] = (int)$serendipity['GET']['staticid'];
        }

        if (isset($serendipity['GET']['pre']) && is_array($serendipity['GET']['pre'])) {
            // Allow to create a new staticpage from a bookmark link
            $serendipity['POST']['plugin']       = $serendipity['GET']['pre'];
            $serendipity['POST']['staticpage']   = '__new';
            $serendipity['POST']['staticSubmit'] = true;
        }

        if ($serendipity['version'][0] < 2) {
            echo '<script src="' . $serendipity['serendipityHTTPPath'] . 'serendipity_define.js.php"></script>' . "\n";
            echo '<script src="' . $serendipity['serendipityHTTPPath'] . 'serendipity_editor.js"></script>';
        }

?>
<h2><?php echo STATICPAGE_TITLE ?></h2>
<ul id="serendipityStaticpagesNav" class="tabbed-nav">
<li><a class="button_link<?php echo ($serendipity['GET']['staticpagecategory'] == 'pageedit' ? ' active' : '') ?>" href="<?php echo $serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pageedit' ?>"><?php echo STATICPAGE_CATEGORY_PAGES ?></a></li>
<li><a class="button_link<?php echo ($serendipity['GET']['staticpagecategory'] == 'pageorder' ? ' active' : '') ?>" href="<?php echo $serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pageorder' ?>"><?php echo STATICPAGE_CATEGORY_PAGEORDER ?></a></li>
<li><a class="button_link<?php echo (($serendipity['GET']['staticpagecategory'] == 'pagetype' || $serendipity['POST']['staticpagecategory'] == 'pagetype') ? ' active' : '') ?>" href="<?php echo $serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pagetype' ?>"><?php echo STATICPAGE_CATEGORY_PAGETYPES ?></a></li>
<li><a class="button_link<?php echo ($serendipity['GET']['staticpagecategory'] == 'pageadd' ? ' active' : '') ?>" href="<?php echo $serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pageadd' ?>"><?php echo STATICPAGE_CATEGORY_PAGEADD ?></a></li>
</ul>
<?php
        $spcat = !empty($serendipity['GET']['staticpagecategory']) ? $serendipity['GET']['staticpagecategory'] : $serendipity['POST']['staticpagecategory'];
        switch($spcat) {
            case 'pageorder':

                echo '<h3>' . STATICPAGE_PAGEORDER_DESC . '</h3>';

                switch($serendipity['GET']['moveto']) {
                    case 'moveup':
                        $this->move_up($serendipity['GET']['pagetomove']);
                        break;
                    case 'movedown':
                        $this->move_down($serendipity['GET']['pagetomove']);
                        break;
                }

                $pages = $this->fetchStaticPages(true);
                if(is_array($pages)) {
                    $pages = serendipity_walkRecursive($pages);
                    $sort_idx = 0;
                    echo '<ul class="plainList option_list">'."\n";

                    foreach($pages as $page) {
                        $oddeven = ($sort_idx % 2 == 0) ? 'odd' : 'even';
                        echo '<li><div class="clearfix ' . $oddeven . '">'."\n";
                        echo '<span class="staticpage_title">';
                        echo str_repeat('&nbsp;', $page['depth']).$page['pagetitle'];
                        echo '</span>';
                        echo '<ul class="plainList clearfix edit_actions">';
                        echo '<li>';
                        if($sort_idx == 0) {
                            echo '<span class="button_placeholder">&nbsp;</span>';
                        } else {
                            echo '<a class="button_link" href="?serendipity[adminModule]=staticpages&amp;serendipity[moveto]=moveup&amp;serendipity[pagetomove]=' . $page['id'] . '&amp;serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pageorder"><span class="icon-up-dir" aria-hidden="true"></span><span class="visuallyhidden">' . UP . '</span></a>';
                        }
                        echo '</li>'."\n";
                        echo '<li>';
                        if ($sort_idx == (count($pages)-1)) {
                            echo '<span class="button_placeholder">&nbsp;</span>';
                        } else {
                            echo ($page['moveup']!= '' ? '&nbsp;' : '') . '<a class="button_link" href="?serendipity[adminModule]=staticpages&amp;serendipity[moveto]=movedown&serendipity[pagetomove]=' . $page['id'] . '&amp;serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pageorder"><span class="icon-down-dir" aria-hidden="true"></span><span class="visuallyhidden">'. DOWN .'</span></a>';
                        }
                        echo '</li>'."\n";
                        echo '</div></li>'."\n";
                        $sort_idx++;
                    }

                    echo '</ul>'."\n";


                }

                break;

            case 'pagetype':

                if($serendipity['POST']['pagetype'] != '__new') {
                    $this->fetchPageType($serendipity['POST']['pagetype']);
                }

                if($serendipity['POST']['typeSave'] == "true" && !empty($serendipity['POST']['SAVECONF'])) {
                    $serendipity['POST']['typeSubmit'] = true;
                    $bag = new serendipity_property_bag();
                    $this->introspect($bag);
                    $name = (function_exists('serendipity_specialchars') ? serendipity_specialchars($bag->get('name')) : htmlspecialchars($bag->get('name'), ENT_COMPAT, LANG_CHARSET));
                    $desc = (function_exists('serendipity_specialchars') ? serendipity_specialchars($bag->get('description')) : htmlspecialchars($bag->get('description'), ENT_COMPAT, LANG_CHARSET));
                    $config_t = $bag->get('type_configuration');

                    foreach($config_t as $config_item) {
                        $cbag = new serendipity_property_bag();
                        if($this->introspect_item_type($config_item, $cbag)) {
                            $this->pagetype[$config_item] = serendipity_get_bool($serendipity['POST']['plugin'][$config_item]);
                        }
                    }
                    echo '<span class="msg_success"><span class="icon-ok-circled" aria-hidden="true"></span>'. DONE .': '. sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%H:%M:%S')) .'</span>';
                    $this->updatePageType();
                }

                if (!empty($serendipity['POST']['typeDelete']) && $serendipity['POST']['pagetype'] != '__new') {
                    serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}staticpages_types WHERE id = " . (int)$serendipity['POST']['pagetype']);
                    echo '<span class="msg_success"><span class="icon-ok-circled" aria-hidden="true"></span>'. DONE .': '. sprintf(RIP_ENTRY, $this->pagetype['description']) . '</span>';
                }

                echo '<form action="serendipity_admin.php" method="post" name="serendipityEntry">';
                echo '<input type="hidden" name="serendipity[adminModule]" value="event_display" />';
                echo '<input type="hidden" name="serendipity[adminAction]" value="staticpages" />';
                echo '<input type="hidden" name="serendipity[staticpagecategory]" value="pagetype" />';

                echo '<h3>' . PAGETYPES_SELECT . '</h3>';
                echo '<div class="form_select sp_pagetype_select">';
                echo '<select name="serendipity[pagetype]">';
                echo '<option value="__new">' . NEW_ENTRY . '</option>';
                echo '<option value="__new">-----------------</option>';
                $types = $this->fetchPageTypes();
                if(is_array($types)) {
                    foreach($types as $type) {
                        echo '<option value="' . $type['id'] . '" ' . ($serendipity['POST']['pagetype'] == $type['id'] ? 'selected="selected"' : '') . '>' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($type['description']) : htmlspecialchars($type['description'], ENT_COMPAT, LANG_CHARSET)) . '</option>';
                    }
                }
                echo '</select></div>';
                echo '<div class="sp_buttons"><input type="submit" name="serendipity[typeSubmit]" value="' . GO . '">  <input type="submit" class="state_cancel" name="serendipity[typeDelete]" value="' . DELETE . '"></div>';
                if ($serendipity['POST']['typeSubmit']) {
                    echo '<input type="hidden" name="serendipity[typeSave]" value="true" />';
                    $this->showForm($this->config_types, $this->pagetype, 'introspect_item_type', 'get_type', 'typeSubmit');
                }
                echo '</form>';

                break;

            case 'pageadd':

                echo '<h3>' . STATICPAGE_PAGEADD_DESC . '</h3>';

                $plugins = $this->selectPlugins();
                $insplugins = $this->fetchPlugins();
                if (isset($serendipity['POST']['typeSubmit'])) {
                    foreach($insplugins as $key => $values) {
                        if (empty($serendipity['POST']['externalPlugins'][$key])) {
                            serendipity_db_query('DELETE FROM '.$serendipity['dbPrefix'].'staticpages WHERE id = '.(int)$values['id']);
                        }
                    }
                    if (count($serendipity['POST']['externalPlugins'])) {
                        foreach($serendipity['POST']['externalPlugins'] as $plugin) {
                            $this->staticpage =  array(
                                'permalink'   => $plugins[$plugin]['link'],
                                'content'     => 'plugin',
                                'pre_content' => $plugin,
                                'pagetitle'   => $plugins[$plugin]['name'],
                                'headline'    => $plugins[$plugin]['name']
                            );
                            $this->updateStaticPage();
                        }
                    }
                }
                $insplugins = $this->fetchPlugins();
                if (is_array($plugins)) {
                    echo '<form action="serendipity_admin.php" method="post" name="serendipityPlugins">';
                    echo '<input type="hidden" name="serendipity[adminModule]" value="event_display" />';
                    echo '<input type="hidden" name="serendipity[adminAction]" value="staticpages" />';
                    echo '<input type="hidden" name="serendipity[staticpagecategory]" value="pageadd" />';
                    foreach($plugins as $key => $plugin) {
                        if (isset($insplugins[$key])) {
                            $c = 'checked="checked"';
                        } else {
                            $c = '';
                        }
                        echo '<div class="form_check"><input id="' . $key . '" type="checkbox" name="serendipity[externalPlugins][]" value="' . $key . '" ' . $c . '><label for="' . $key . '">' . $plugin['name'] . '</label></div>';
                    }
                    echo '<input type="submit" name="serendipity[typeSubmit]" value="'.GO.'">';
                    echo '</form>';
                }

                echo '<h3>' . STATICPAGE_PAGEADD_PLUGINS . '</h3>';

                $this->pluginstatus();
                echo '<table id="serendipityStaticpagesTable">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>' . EVENT_PLUGIN . '</th>';
                echo '<th>' . STATICPAGE_STATUS . '</th>';
                echo '</tr>';
                echo '</thead>';

                $i = 0;
                foreach($this->pluginstats as $key => $value) {
                    $rows = ($i % 2 == 0) ? 'odd' : 'even';
                    echo '<tr class="' . $rows . '">';
                    echo '<td>' .$key . '</td>';
                    echo '<td class="serendipityStaticpages' . $value['color'] . '">' . $value['status'] . '</td>';
                    echo '</tr>';
                    $i++;
                }
                echo '</table>';
                break;

            case 'pages':
            default:

                if ($serendipity['POST']['staticpage'] != '__new') {
                    $this->fetchStaticPage($serendipity['POST']['staticpage']);
                }

                if ($serendipity['POST']['staticSave'] == "true" && !empty($serendipity['POST']['SAVECONF'])) {
                    $serendipity['POST']['staticSubmit'] = true;
                    $bag  = new serendipity_property_bag;
                    $this->introspect($bag);
                    $name = (function_exists('serendipity_specialchars') ? serendipity_specialchars($bag->get('name')) : htmlspecialchars($bag->get('name'), ENT_COMPAT, LANG_CHARSET));
                    $desc = (function_exists('serendipity_specialchars') ? serendipity_specialchars($bag->get('description')) : htmlspecialchars($bag->get('description'), ENT_COMPAT, LANG_CHARSET));
                    $config_names = $bag->get('page_configuration');

                    foreach ($config_names as $config_item) {
                        $cbag = new serendipity_property_bag;
                        if ($this->introspect_item($config_item, $cbag)) {
                            $this->staticpage[$config_item] = serendipity_get_bool($serendipity['POST']['plugin'][$config_item]);
                        }
                    }

                    $result = $this->updateStaticPage();
                    if (is_string($result)) {
                        echo '<span class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> ERROR: ' . $result . '</span>';
                    } else {
                        echo '<span class="msg_success"><span class="icon-ok-circled" aria-hidden="true"></span>' . DONE . ': ' . sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%H:%M:%S')). '</span>';
                    }

                }

                if (!empty($serendipity['POST']['staticDelete']) && $serendipity['POST']['staticpage'] != '__new') {
                    if (!$this->getChildPage($serendipity['POST']['staticpage'])) {
                        serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}staticpages WHERE id = " . (int)$serendipity['POST']['staticpage']);
                        echo '<span class="msg_success"><span class="icon-ok-circled" aria-hidden="true"></span>' . DONE . ': '. sprintf(RIP_ENTRY, $this->staticpage['pagetitle']) . '</span>';
                    } else {
                        echo '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span>' . IMPORT_NOTES . ': '. STATICPAGE_CANNOTDELETE_MSG . '</span>';
                    }
                }

                echo '<form action="serendipity_admin.php" method="post" name="serendipityEntry">';
                echo '<input type="hidden" name="serendipity[adminModule]" value="event_display">';
                echo '<input type="hidden" name="serendipity[adminAction]" value="staticpages">';
                echo '<input type="hidden" name="serendipity[staticpagecategory]" value="pages">';

                if (empty($serendipity['POST']['backend_template'])) {
                    if (!empty($serendipity['COOKIE']['backend_template'])) {
                        $serendipity['POST']['backend_template'] = $serendipity['COOKIE']['backend_template'];
                    }
                } else {
                    serendipity_JSsetCookie('backend_template', $serendipity['POST']['backend_template']);
                }

                echo '<h3>' . STATICPAGE_SELECT . '</h3>';

                echo '<div class="sp_pageselector clearfix">';
                echo '<div class="form_select">';
                echo '<select name="serendipity[staticpage]" id="staticpage_dropdown">';
                echo '<option value="__new">' . NEW_ENTRY . '</option>';
                echo '<option value="__new">-----------------</option>';
                $pages = $this->fetchStaticPages();
                if(is_array($pages)) {
                    $pages = serendipity_walkRecursive($pages);
                    foreach ($pages as $page) {
                        if ($this->checkPageUser($page['authorid'])) {
                            echo ' <option value="' . $page['id'] . '" ' . ($serendipity['POST']['staticpage'] == $page['id'] ? 'selected="selected"' : '') . '>';
                            echo str_repeat('&nbsp;&nbsp;', $page['depth']) . (function_exists('serendipity_specialchars') ? serendipity_specialchars($page['pagetitle']) : htmlspecialchars($page['pagetitle'], ENT_COMPAT, LANG_CHARSET)) . '</option>';
                        }
                    }
                }
                echo '</select></div>';
                echo '<div class="sp_buttons"><input type="submit" name="serendipity[staticSubmit]" value="' . GO . '"> <input class="state_cancel" type="submit" name="serendipity[staticDelete]" onclick="return confirm(\'' . sprintf(DELETE_SURE, '\' + document.getElementById(\'staticpage_dropdown\').options[document.getElementById(\'staticpage_dropdown\').selectedIndex].text + \'') . '\');" value="' . DELETE . '">';
                echo ' <input type="submit" name="serendipity[staticPreview]" value="' . PREVIEW . '"></div>';

                echo '<div class="sp_templateselector form_select">';
                echo '<label for="sp_templateselector">' . STATICPAGE_TEMPLATE . '</label> <select id="sp_templateselector" name="serendipity[backend_template]">';
                echo '<option ' . ($serendipity['POST']['backend_template'] == 'external' ? 'selected="selected"' : '') . ' value="external">' . STATICPAGE_TEMPLATE_EXTERNAL . '</option>';
                echo '<option ' . ($serendipity['POST']['backend_template'] == 'internal' ? 'selected="selected"' : '') . ' value="internal">' . STATICPAGE_TEMPLATE_INTERNAL . '</option>';
                $dh = @opendir(dirname(__FILE__) . '/backend_templates');
                if ($dh) {
                    while ($file = readdir($dh)) {
                        if ($file != 'default_staticpage_backend.tpl' && preg_match('@^(.*).tpl$@i', $file, $m)) {
                            echo '<option ' . ($file == $serendipity['POST']['backend_template'] ? 'selected="selected"' : '') . ' value="' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($file) : htmlspecialchars($file, ENT_COMPAT, LANG_CHARSET)) . '">' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($m[1]) : htmlspecialchars($m[1], ENT_COMPAT, LANG_CHARSET)) . '</option>' . "\n";
                        }
                    }
                }
                $dh = @opendir($serendipity['templatePath'] . $serendipity['template'] . '/backend_templates');
                if ($dh) {
                    while ($file = readdir($dh)) {
                        if ($file != 'default_staticpage_backend.tpl' && preg_match('@^(.*).tpl$@i', $file, $m)) {
                            echo '<option ' . ($file == $serendipity['POST']['backend_template'] ? 'selected="selected"' : '') . ' value="' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($file) : htmlspecialchars($file, ENT_COMPAT, LANG_CHARSET)) . '">' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($m[1]) : htmlspecialchars($m[1], ENT_COMPAT, LANG_CHARSET)) . '</option>' . "\n";
                        }
                    }
                }
                echo '</select>';
                echo '</div>';

                if ($sbplav) {
                    echo '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> ';
                    echo 'Staticpage Sidebar ' . STATICPAGE_PLUGIN_AVAILABLE;
                    echo '</span>';
                }
                echo '</div>';

                if (!empty($serendipity['POST']['staticPreview'])) {
                    $link = $serendipity['baseURL'] . $serendipity['indexFile'] . '?serendipity[staticid]=' . $this->staticpage['id'] . '&serendipity[staticPreview]=1';
                    echo '<script>';
                    echo 'var staticpage_preview = window.open("' . $link . '", "staticpage_preview");' . "\n";
                    echo 'staticpage_preview.focus();' . "\n";
                    echo '</script>';
                    $serendipity['POST']['staticSubmit'] = true;
                    echo '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> ' . sprintf(PLUGIN_STATICPAGE_PREVIEW, '<a href="' . $link . '">' . $this->staticpage['pagetitle'] . '</a>') . '</span>';
                }

                if ($serendipity['POST']['staticSubmit'] || isset($serendipity['GET']['staticid'])) {
                    $serendipity['POST']['plugin']['custom'] = $this->staticpage['custom'];
                    echo '<input type="hidden" name="serendipity[staticSave]" value="true">';
                    $this->showForm($this->config, $this->staticpage);
                    echo '</form>';
                } else {
                    echo '</form>';
                    $this->listStaticPages();
                }

                break;

        }
    }

    function move_up($id) // no more &
    {
        global $serendipity;

        $dospecial = false;

        $q = 'SELECT pageorder, parent_id
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE id='.$id;
        $thispage = serendipity_db_query($q, true, 'assoc');
        $q = 'SELECT id
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE parent_id = '.$thispage['parent_id'].'
                 AND pageorder = '.($thispage['pageorder'] -1);
        $childpage = serendipity_db_query($q, true, 'assoc');

        $sisters = $this->getSystersID($id);
        for ($i = 0, $ii = count($sisters); $i < $ii; $i++) {
            if (($sisters[$i]['id'] != $id) && ($sisters[$i]['pageorder'] == $thispage['pageorder'])) {
                $dospecial = true;
                break;
            }
        }

        if ($dospecial == true) {
            for ($i = 0, $ii = count($sisters); $i < $ii; $i++) {
                serendipity_db_update('staticpages', array('id' => $sisters[$i]['id']), array('pageorder' => ($i + 1)));
            }
        } else {
            serendipity_db_update('staticpages', array('id' => $id), array('pageorder' => ($thispage['pageorder'] - 1)));
            serendipity_db_update('staticpages', array('id' => $childpage['id']), array('pageorder' => $thispage['pageorder']));

        }
        @unlink($this->cachefile);
    }

    function move_down($id) { // no more &
        global $serendipity;

        $dospecial = false;

        $q = 'SELECT pageorder, parent_id
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE id='.$id;
        $thispage = serendipity_db_query($q, true, 'assoc');
        $q = 'SELECT id
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE parent_id = '.$thispage['parent_id'].'
                 AND pageorder = '.($thispage['pageorder'] + 1);
        $childpage = serendipity_db_query($q, true, 'assoc');

        $sisters = $this->getSystersID($id);

        for ($i = 0, $ii = count($sisters); $i < $ii; $i++) {
            if (($sisters[$i]['id'] != $id) && ($sisters[$i]['pageorder'] == $thispage['pageorder'])) {
                $dospecial = true;
                break;
            }
        }

        if ($dospecial) {

            for ($i = 0, $ii = count($sisters); $i < $ii; $i++) {
                serendipity_db_update('staticpages', array('id' => $sisters[$i]['id']), array('pageorder' => ($i+1)));
            }

        } else {
            serendipity_db_update('staticpages', array('id' => $id), array('pageorder' => ($thispage['pageorder'] + 1)));
            serendipity_db_update('staticpages', array('id' => $childpage['id']), array('pageorder' => $thispage['pageorder']));
        }

        @unlink($this->cachefile);
    }

    function inspectConfig($is_smarty, $what, $elcount, $config_item, $config_value, $type, $cname, $cdesc, $value, $default, $lang_direction, $hvalue, $radio, $radio2, $select, $per_row, $per_row2) {
        global $serendipity;

        if ($is_smarty && $what == 'desc') {
            echo $cdesc;
            return true;
        }

        if ($is_smarty && $what == 'name') {
            echo $cname;
            return true;
        }

        switch ($type) {
            case 'seperator':
?>
        <tr>
            <td colspan="2"><hr noshade="noshade" size="1" /></td>
        </tr>
<?php
                break;

            case 'select':
                if (!$is_smarty) {
?>
        <tr>
            <td><strong><?php echo $cname; ?></strong>
<?php
                if ($cdesc != '') {
?>
                <br><span  style="color: #5E7A94; font-size: 8pt;">&nbsp;<?php echo $cdesc; ?></span>
                <?php } ?>
            </td>
            <td width="40%">
                <div>
                <?php } ?>
<select class="direction_<?php echo $lang_direction; ?>" name="serendipity[plugin][<?php echo $config_item; ?>]">
<?php
foreach($select AS $select_value => $select_desc) {
    $id = (function_exists('serendipity_specialchars') ? serendipity_specialchars($config_item . $select_value) : htmlspecialchars($config_item . $select_value, ENT_COMPAT, LANG_CHARSET));
?>
                        <option title="<?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($select_desc) : htmlspecialchars($select_desc, ENT_COMPAT, LANG_CHARSET)); ?>"<?php echo ($select_value == $hvalue ? ' selected="selected"' : ''); ?> value="<?php echo $select_value; ?>"><?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($select_desc) : htmlspecialchars($select_desc, ENT_COMPAT, LANG_CHARSET)); ?></option>
<?php } ?>
                    </select>
<?php if (!$is_smarty) { ?>
                </div>
            </td>
        </tr>
<?php
                }
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
                    $radio = $radio2;
                }

                if (empty($per_row)) {
                    $per_row = $per_row2;
                    if (empty($per_row)) {
                        $per_row = 2;
                    }
                }

                if (!$is_smarty) {
?>
        <tr>
            <td><strong><?php echo $cname; ?></strong>
<?php
                if ($cdesc != '') {
?>
                <br /><span  style="color: #5E7A94; font-size: 8pt;">&nbsp;<?php echo $cdesc; ?></span>
<?php
                }
?>
            </td>
            <td width="40%">
<?php
            }
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
                    <input class="input_radio direction_<?php echo $lang_direction; ?>" type="radio" id="serendipity_plugin_<?php echo $id; ?>" name="serendipity[plugin][<?php echo $config_item; ?>]" value="<?php echo $radio_value; ?>" <?php echo $checked ?> title="<?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($radio['desc'][$radio_index]) : htmlspecialchars($radio['desc'][$radio_index], ENT_COMPAT, LANG_CHARSET)); ?>" />
                        <label for="serendipity_plugin_<?php echo $id; ?>"><?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($radio['desc'][$radio_index]) : htmlspecialchars($radio['desc'][$radio_index], ENT_COMPAT, LANG_CHARSET)); ?></label>
<?php
                    if ($counter == $per_row) {
                        $counter = 0;
?>
                </div>
<?php
                    }
                }
                if (!$is_smarty) {
?>
            </td>
        </tr>
<?php
                }
                break;

            case 'string':
                if (!$is_smarty) {
?>
        <tr>
            <td>
                    <strong><?php echo $cname; ?></strong>
                    <span><?php echo $cdesc; ?></span>
            </td>
            <td width="40%">
<?php           } ?>
                    <input type="text" name="serendipity[plugin][<?php echo $config_item; ?>]" value="<?php echo $hvalue; ?>">
<?php           if (!$is_smarty) { ?>
            </td>
        </tr>
<?php
                }
                break;

            case 'html':
            case 'text':
                if (!$is_smarty) {
                    echo '<tr>';
                }

                if (!$serendipity['wysiwyg']) {
                    if (!$is_smarty) {
?>
                <td><strong><?php echo $cname; ?></strong>
                <span><?php echo $cdesc; ?></span></td>
                <td>
<?php
                    }

                    if (!$serendipity['wysiwyg']) {
?>                  <nobr><span id="tools_<?php echo $config_item ?>" style="display: none">
                        <?php if( $serendipity['nl2br']['iso2br'] ) { ?>
                        <input type="button" class="serendipityPrettyButton input_button" name="insX" value="NoBR" accesskey="x" style="font-style: italic" onclick="wrapSelection(document.forms['serendipityEntry']['serendipity[plugin][<?php echo $config_item ?>]'],'<nl>','</nl>')" />
                        <?php } ?>
                        <input type="button" class="serendipityPrettyButton input_button wrap_selection" name="insI" value="I" accesskey="i" data-tarea="nuggets<?php echo $elcount; ?>" data-tag="em" style="font-style: italic" onclick="wrapSelection(document.forms['serendipityEntry']['serendipity[plugin][<?php echo $config_item ?>]'],'<em>','</em>')" />
                        <input type="button" class="serendipityPrettyButton input_button wrap_selection" name="insB" value="B" accesskey="b" data-tarea="nuggets<?php echo $elcount; ?>" data-tag="strong" style="font-weight: bold" onclick="wrapSelection(document.forms['serendipityEntry']['serendipity[plugin][<?php echo $config_item ?>]'],'<strong>','</strong>')" />
                        <input type="button" class="serendipityPrettyButton input_button wrap_selection" name="insU" value="U" accesskey="u" data-tarea="nuggets<?php echo $elcount; ?>" data-tag="u" style="text-decoration: underline;" onclick="wrapSelection(document.forms['serendipityEntry']['serendipity[plugin][<?php echo $config_item ?>]'],'<u>','</u>')" />
                        <input type="button" class="serendipityPrettyButton input_button wrap_selection" name="insQ" value="<?php echo QUOTE ?>" accesskey="q" data-tarea="nuggets<?php echo $elcount; ?>" data-tag="blockquote" style="font-style: italic" onclick="wrapSelection(document.forms['serendipityEntry']['serendipity[plugin][<?php echo $config_item ?>]'],'<blockquote>','</blockquote>')" />
                        <input type="button" class="serendipityPrettyButton input_button wrap_insimg" name="insJ" value="img" accesskey="j" data-tarea="nuggets<?php echo $elcount; ?>" onclick="wrapInsImage(document.forms['serendipityEntry']['serendipity[plugin][<?php echo $config_item ?>]'])" />
                        <?php
                        if (version_compare(serendipity_getCoreVersion($serendipity['version']), "2.0", ">=")) {
                            ?>
                            <button class="wrap_insmedia" type="button" name="insImage" data-tarea="nuggets<?php echo $elcount; ?>"><?php echo MEDIA; ?></button>
                            <?php
                        } else {
                            ?>
                            <input type="button" class="serendipityPrettyButton input_button wrap_insmedia" name="insImage" value="<?php echo MEDIA; ?>" style="" onclick="window.open('serendipity_admin_image_selector.php?serendipity[textarea]=<?php echo urlencode('serendipity[plugin]['.$config_item.']'); ?>', 'ImageSel', 'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1');" />
                            <?php
                        }
                        ?>
                        <input type="button" class="serendipityPrettyButton input_button wrap_insurl" name="insU" value="URL" accesskey="l" data-tarea="nuggets<?php echo $elcount; ?>" style="color: blue; text-decoration: underline;" onclick="wrapSelectionWithLink(document.forms['serendipityEntry']['serendipity[plugin][<?php echo $config_item ?>]'])" />
                    </span></nobr>
<?php               } ?>
                    <script type="text/javascript" language="JavaScript">
                        var tb_<?php echo $config_item ?> = document.getElementById('tools_<?php echo $config_item ?>');
                        tb_<?php echo $config_item ?>.style.display = '';
                    </script>
                    <?php
                    if (version_compare(serendipity_getCoreVersion($serendipity['version']), "2.0", ">=")) {
                        ?><script src="<?php echo serendipity_getTemplateFile('admin/js/jquery.magnific-popup.js') ?>"></script><?php
                    }
                    // add extra data in the entry's array so that emoticonchooser plugin
                    // behaves well with wysiwyg editors, then clean up ;-) (same apply below)
                    $entry['backend_entry_toolbar_body:nugget'] = 'nuggets' . $elcount;
                    $entry['backend_entry_toolbar_body:textarea'] = 'serendipity[plugin][' . $config_item . ']';
                    serendipity_plugin_api::hook_event('backend_entry_toolbar_body', $entry);
                    unset($entry['backend_entry_toolbar_body:textarea']);
                    unset($entry['backend_entry_toolbar_body:nugget']);
                } else {
                    if (!$is_smarty) {
?>
            <td colspan="2"><strong><?php echo $cname; ?></strong>
                <span><?php echo $cdesc; ?></span></td>
            <td>
<?php
                    }
                    if (version_compare(serendipity_getCoreVersion($serendipity['version']), "2.0", ">=")) {
                        serendipity_emit_htmlarea_code("nuggets{$elcount}","");
                        ?><script src="<?php echo serendipity_getTemplateFile('admin/js/jquery.magnific-popup.js') ?>"></script><?php
                    }
                    $entry['backend_entry_toolbar_body:nugget'] = 'nuggets' . $elcount;
                    $entry['backend_entry_toolbar_body:textarea'] = 'serendipity[plugin][' . $config_item . ']';
                    serendipity_plugin_api::hook_event('backend_entry_toolbar_body', $entry);
                    unset($entry['backend_entry_toolbar_body:textarea']);
                    unset($entry['backend_entry_toolbar_body:nugget']); ?>

<?php          }

               if (!$is_smarty) {
?>
                </td>
            </tr>

        <tr>
            <td colspan="2">
<?php           } ?>
                <div>
                    <textarea id="nuggets<?php echo $elcount; ?>" name="serendipity[plugin][<?php echo $config_item; ?>]" rows="20"><?php echo $hvalue; ?></textarea>
                </div>

<?php         if (!$is_smarty) { ?>

            </td>
        </tr>
<?php
                }

                if ($type == 'html') {
                    $this->htmlnugget[] = $elcount;
                    if (version_compare(preg_replace('@[^0-9\.]@', '', $serendipity['version']), '0.9', '<')) {
                        serendipity_emit_htmlarea_code('nuggets' . $elcount, 'nuggets' . $elcount);
                    } else {
                        serendipity_emit_htmlarea_code('nuggets', 'nuggets', true);
                    }
                }
                break;

            case 'content':
                if (!$is_smarty) {
                    ?><tr><td colspan="2"><?php echo $default; ?></td></tr><?php
                } else {
                    echo $default;
                }
                break;

            case 'hidden':
                if (!$is_smarty) {?><tr><td colspan="2"><?php }
                ?><input type="hidden" name="serendipity[plugin][<?php echo $config_item; ?>]" value="<?php echo $value; ?>"><?php
                if (!$is_smarty) {?></td></tr><?php }
                break;

            case 'timestamp':
                if (!$is_smarty) {
?>
        <tr>
            <td>
                    <strong><?php echo $cname; ?></strong>
                    <span><?php echo $cdesc; ?></span>
            </td>
            <td width="40%">
                <div>
<?php           } ?>
                    <input type="text" name="serendipity[plugin][<?php echo $config_item; ?>]" value="<?php echo serendipity_strftime(DATE_FORMAT_SHORT, $hvalue); ?>">
<?php           if (!$is_smarty) { ?>
                </div>
            </td>
        </tr>
<?php
                }
                break;
        }
    }

    function SmartyInspectConfig($params, &$smarty) {
        static $elcount = 0;
        global $serendipity;

        $config_item = $params['item'];
        $what = $params['what'];

        if (empty($what)) {
            $what = 'input';
        }

        $elcount++;
        $config_value = $this->staticpage[$config_item];
        $cbag = new serendipity_property_bag;
        $this->introspect_item($config_item, $cbag);

        $cname      = (function_exists('serendipity_specialchars') ? serendipity_specialchars($cbag->get('name')) : htmlspecialchars($cbag->get('name'), ENT_COMPAT, LANG_CHARSET));
        $cdesc      = (function_exists('serendipity_specialchars') ? serendipity_specialchars($cbag->get('description')) : htmlspecialchars($cbag->get('description'), ENT_COMPAT, LANG_CHARSET));
        $value      = $this->get_static($config_item, 'unset');

        $lang_direction = (function_exists('serendipity_specialchars') ? serendipity_specialchars($cbag->get('lang_direction')) : htmlspecialchars($cbag->get('lang_direction'), ENT_COMPAT, LANG_CHARSET));

        if (empty($lang_direction)) {
            $lang_direction = LANG_DIRECTION;
        }

        /* Apparently no value was set for this config item */
        if ($value === 'unset') {
            /* Try and the default value for the config item */
            $value = $cbag->get('default');
        }
        $hvalue   = ((!isset($serendipity['POST']['staticSubmit']) || is_array($serendipity['GET']['pre'])) && isset($serendipity['POST']['plugin'][$config_item]) ? (function_exists('serendipity_specialchars') ? serendipity_specialchars($serendipity['POST']['plugin'][$config_item]) : htmlspecialchars($serendipity['POST']['plugin'][$config_item], ENT_COMPAT, LANG_CHARSET)) : (function_exists('serendipity_specialchars') ? serendipity_specialchars($value) : htmlspecialchars($value, ENT_COMPAT, LANG_CHARSET)));
        $radio    = array();
        $select   = array();
        $per_row  = null;

        $type     = $cbag->get('type');
        $select   = $cbag->get('select_values');
        $radio2   = $cbag->get('radio');
        $per_row2 = $cbag->get('radio_per_row');
        $default  = $cbag->get('default');

        ob_start();
        $this->inspectConfig(true, $what, $elcount, $config_item, $config_value, $type, $cname, $cdesc, $value, $default, $lang_direction, $hvalue, $radio, $radio2, $select, $per_row, $per_row2);
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }

    function SmartyInspectConfigFinish($params, &$smarty) {
        global $serendipity;

        ob_start();

        if (isset($serendipity['wysiwyg']) && $serendipity['wysiwyg'] && count($this->htmlnugget) > 0) {
            $ev = array('nuggets' => $this->htmlnugget, 'skip_nuggets' => false);
            serendipity_plugin_api::hook_event('backend_wysiwyg_nuggets', $ev);

            if ($ev['skip_nuggets'] === false) {
    ?>
        <script type="text/javascript">
        function Spawnnugget() {
            <?php foreach($this->htmlnugget AS $htmlnuggetid) {
                    if (version_compare(preg_replace('@[^0-9\.]@', '', $serendipity['version']), '0.9', '<')) { ?>
            if (window.Spawnnuggets) Spawnnuggets<?php echo $htmlnuggetid; ?>();
                        <?php } else { ?>

            if (window.Spawnnuggets) Spawnnuggets('<?php echo $htmlnuggetid; ?>');
                        <?php } ?>
            <?php } ?>
        }
        </script>
    <?php
            }
        }

        serendipity_plugin_api::hook_event('backend_staticpages_showform', $this->staticpage);

        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }

    function showForm(&$form_values, &$form_container, $introspec_func = 'introspect_item', $value_func = 'get_static', $submit_name = 'staticSubmit') {
        global $serendipity;

        $this->htmlnugget = array();
        $GLOBALS['staticpage_htmlnugget'] = &$this->htmlnugget;

        $serendipity['EditorBrowsers'] = '@(IE|Mozilla|Safari)@i';

        if (file_exists(S9Y_INCLUDE_PATH . 'include/functions_entries_admin.inc.php')) {
            include_once(S9Y_INCLUDE_PATH . 'include/functions_entries_admin.inc.php');
        }

        // Code copied from include/admin/plugins.inc.php. Sue me. ;-)

        if ($value_func == 'get_static' && $serendipity['POST']['backend_template'] != 'internal') {
            serendipity_smarty_init();
            $serendipity['smarty']->register_modifier('in_array', 'in_array');
            $serendipity['smarty']->register_function('staticpage_input', array($this, 'SmartyInspectConfig'));
            $serendipity['smarty']->register_function('staticpage_input_finish', array($this, 'SmartyInspectConfigFinish'));
            if (isset($serendipity['wysiwyg'])) {
                $serendipity['smarty']->assign('is_wysiwyg', $serendipity['wysiwyg']);
            }

            $filename = preg_replace('@[^a-z0-9\._-]@i', '', $serendipity['POST']['backend_template']);
            if ($filename == 'external' || empty($filename)) {
                $filename = 'default_staticpage_backend.tpl';
            }

            if ($serendipity['version'][0] < 2) {
                $tfile = serendipity_getTemplateFile('backend_templates/' . $filename, 'serendipityPath'); // old API
            } else {
                $tfile = serendipity_getTemplateFile('backend_templates/' . $filename, 'serendipityPath', true); // force fallback
            }
            if (!$tfile || $tfile == 'backend_templates/' . $filename) {
                $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
                if (!$tfile || $tfile == $filename) {
                    $tfile = dirname(__FILE__) . '/backend_templates/' . $filename;
                }
            }
            $inclusion = $serendipity['smarty']->security_settings[INCLUDE_ANY];
            $serendipity['smarty']->security_settings[INCLUDE_ANY] = true;
            $serendipity['smarty']->assign(
                array(
                    'showmeta'       => serendipity_db_bool($this->get_config('showmeta')),
                    'form_keys'      => $form_values,
                    'form_container' => $this->staticpage,
                    'form_post'      => $serendipity['POST']['plugin'],
                    'form_values'    => (is_array($serendipity['POST']['plugin']) ? $serendipity['POST']['plugin'] : $this->staticpage)

                )
            );
            $content = $serendipity['smarty']->fetch('file:'. $tfile);
            $serendipity['smarty']->security_settings[INCLUDE_ANY] = $inclusion;

            echo $content;
            return true;
        }
?>
    <table class="sp_pagetype">
<?php
    $elcount = 0;
    $this->htmlnugget = array();
    foreach ($form_values as $config_item) {
        $elcount++;
        $config_value = $form_container[$config_item];
        $cbag = new serendipity_property_bag;
        $this->$introspec_func($config_item, $cbag);

        $cname      = (function_exists('serendipity_specialchars') ? serendipity_specialchars($cbag->get('name')) : htmlspecialchars($cbag->get('name'), ENT_COMPAT, LANG_CHARSET));
        $cdesc      = (function_exists('serendipity_specialchars') ? serendipity_specialchars($cbag->get('description')) : htmlspecialchars($cbag->get('description'), ENT_COMPAT, LANG_CHARSET));
        $value      = $this->$value_func($config_item, 'unset');

        $lang_direction = (function_exists('serendipity_specialchars') ? serendipity_specialchars($cbag->get('lang_direction')) : htmlspecialchars($cbag->get('lang_direction'), ENT_COMPAT, LANG_CHARSET));

        if (empty($lang_direction)) {
            $lang_direction = LANG_DIRECTION;
        }

        /* Apparently no value was set for this config item */
        if ($value === 'unset') {
            /* Try and the default value for the config item */
            $value = $cbag->get('default');
        }
        $hvalue   = ((!isset($serendipity['POST'][$submit_name]) || is_array($serendipity['GET']['pre'])) && isset($serendipity['POST']['plugin'][$config_item]) ? (function_exists('serendipity_specialchars') ? serendipity_specialchars($serendipity['POST']['plugin'][$config_item]) : htmlspecialchars($serendipity['POST']['plugin'][$config_item], ENT_COMPAT, LANG_CHARSET)) : (function_exists('serendipity_specialchars') ? serendipity_specialchars($value) : htmlspecialchars($value, ENT_COMPAT, LANG_CHARSET)));
        $radio    = array();
        $select   = array();
        $per_row  = null;

        $type     = $cbag->get('type');
        $select   = $cbag->get('select_values');
        $radio2   = $cbag->get('radio');
        $per_row2 = $cbag->get('radio_per_row');
        $default  = $cbag->get('default');

        $this->inspectConfig(false, 'input', $elcount, $config_item, $config_value, $type, $cname, $cdesc, $value, $default, $lang_direction, $hvalue, $radio, $radio2, $select, $per_row, $per_row2);
    }

    if (isset($serendipity['wysiwyg']) && $serendipity['wysiwyg'] && count($this->htmlnugget) > 0) {
        $ev = array('nuggets' => $this->htmlnugget, 'skip_nuggets' => false);
        serendipity_plugin_api::hook_event('backend_wysiwyg_nuggets', $ev);

        if ($ev['skip_nuggets'] === false) {
?>
    <script>
    function Spawnnugget() {
        <?php foreach($this->htmlnugget AS $htmlnuggetid) {
                if (version_compare(preg_replace('@[^0-9\.]@', '', $serendipity['version']), '0.9', '<')) { ?>
        if (window.Spawnnuggets) Spawnnuggets<?php echo $htmlnuggetid; ?>();
                    <?php } else { ?>

        if (window.Spawnnuggets) Spawnnuggets('<?php echo $htmlnuggetid; ?>');
                    <?php } ?>
        <?php } ?>
    }
    </script>
<?php
        }
    }

    serendipity_plugin_api::hook_event('backend_staticpages_showform', $this->staticpage);
?>
    </table>

    <input type="submit" name="serendipity[SAVECONF]" value="<?php echo SAVE; ?>">
<?php
    }

     /**
    * generate header for static page overview panel
    *
    * Show a introducing headline to the list.
    */
    function showListHeader()
    {
    ?>
        <h3><?php echo STATICPAGE_LIST_EXISTING_PAGES ?></h3>
    <?php
    }

     /**
    * generate entry row for static page overview panel
    *
    * Show a row for a given static page.
    * This row is similar to the one used for entries.
    * It contains the linked title, the author and quick access for preview, editing and deletion of the page.
    * The background color of the table produced differs for even rows and uneven rows.
    *
    * @param entry array with database information for the static page
    * @param is_even true for even rows and wrong for uneven rows.
    * @return null
    */
    function showListEntry($entry, $is_even)
    {
        global $serendipity;
        // Find out if the entry has been modified later than 30 minutes after creation
        if ( $entry['timestamp'] <= ($entry['last_modified'] - 60*30) )
        {
            $lm = '<span class="icon-info-circled" aria-hidden="true" title="' . LAST_UPDATED . ': ' . serendipity_formatTime(DATE_FORMAT_SHORT, $entry['last_modified']) . '"></span>';
        }
        else
        {
            $lm = '';
        }

        $entry_pre = '';
        if ( !serendipity_db_bool($entry['publishstatus']) )
        {
            $entry_pre .= ' ' . DRAFT . ': ';
        }

        ?>
            <li class="clearfix <?php echo ($is_even) ? 'odd' : 'even'; ?>">
                <h4><?php echo $entry_pre; ?><a href="?serendipity[action]=admin&amp;serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pages&amp;serendipity[staticid]=<?php echo $entry['id']; ?>" title="#<?php echo $entry['pagetitle']; ?>"><?php echo serendipity_truncateString((function_exists('serendipity_specialchars') ? serendipity_specialchars($entry['headline']) : htmlspecialchars($entry['headline'], ENT_COMPAT, LANG_CHARSET)),50) ?></a></h4>

                <?php
                    $link = $serendipity['baseURL'] . $serendipity['indexFile'];
                    $link .= '?serendipity[staticid]=' . $entry['id'] . '&serendipity[staticPreview]=1';
                ?>

                <form action="serendipity_admin.php" method="post" name="serendipityEntry">
                    <input type="hidden" name="serendipity[adminModule]" value="event_display">
                    <input type="hidden" name="serendipity[adminAction]" value="staticpages">
                    <input type="hidden" name="serendipity[staticpagecategory]" value="pages">
                    <input type="hidden" name="serendipity[staticpage]" value="<?php echo $entry['id']; ?>">

                    <ul class="plainList clearfix actions">
                        <li><a target="_blank" href="<?php echo $link ?>" title="<?php echo VIEW . ' #' . $entry['pagetitle']; ?>" class="button_link"><span class="icon-search" aria-hidden="true"></span><span class="visuallyhidden"> <?php echo VIEW . " #" . $entry['pagetitle']; ?></span></a></li>
                        <li><input type="submit" name="serendipity[staticSubmit]" title="<?php echo EDIT . "#" . $entry['pagetitle']; ?>" value="<?php echo EDIT; ?>"></li>
                        <li><input type="submit" name="serendipity[staticDelete]" class="state_cancel" onclick="return confirm('<?php echo sprintf(DELETE_SURE, $entry['pagetitle']); ?>');" title="<?php echo DELETE . "#" . $entry['pagetitle']; ?>" value="<?php echo DELETE; ?>"></li>
                    </ul>
                </form>

                <div class="entry_info clearfix">
                    <span class="status_timestamp"><?php echo serendipity_formatTime(DATE_FORMAT_SHORT, $entry['timestamp']) . ' ' .$lm; ?></span>
                    <span class="entry_meta"><?php echo POSTED_BY . ' ' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($this->selectAuthor($entry['authorid'])) : htmlspecialchars($this->selectAuthor($entry['authorid']), ENT_COMPAT, LANG_CHARSET)); ?></span>
                </div>
            </li>
            <?php
    }

     /**
    * generate footer for static page overview panel
    *
    * Show a footline with id-based access to static pages.
    * This footer is similar to the one used for entries.
    * The background color of the table produced differs for even rows and uneven rows.
    *
    * @param is_even true for even rows and wrong for uneven rows.
    * @return null
    */
    function showListFooter($is_even)
    {
    ?>
        <form action="serendipity_admin.php" method="post" name="serendipityEntry">
            <input type="hidden" name="serendipity[adminModule]" value="event_display">
            <input type="hidden" name="serendipity[adminAction]" value="staticpages">
            <input type="hidden" name="serendipity[staticpagecategory]" value="pages">
            <?php echo EDIT_ENTRY ?>: #<input type="text" size="3" name="serendipity[staticpage]">
            <input type="submit" name="serendipity[staticSubmit]" value="<?php echo GO; ?>">
        </form>
    <?php
    }

     /**
    * generate content for empty overview panel
    *
    * Show a message instead of static page list if no static pages exist.
    *
    * @return null
    */
   function showEmptyList()
    {
    ?>
        <div class="serendipity_admin_list">
            <span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> <?php echo NO_ENTRIES_TO_PRINT ?></span>
		</div>
    <?php
    }

    /**
    * Shows the static page panel overview
    *
    * Shows a list of all existing static pages.
    *
    * @access public
    * @return null
    */
    function listStaticPages()
    {
        // get and list static pages
        $pages = $this->fetchStaticPages();
        if(is_array($pages))
        {
            $this->showListHeader();

            $pages = serendipity_walkRecursive($pages);
            $rows = 1;	// start with uneven row
            echo '<ul id="staticpages_list" class="plainList zebra_list">';
            foreach ($pages as $page)
            {
                $this->showListEntry($page, $rows % 2);
                $rows++;
            }
            echo '</ul>';

            $this->showListFooter($is_even);
	}
	else
	{
	    $this->showEmptyList();
	}
    }

    function generate_content(&$title)
    {
        $title = STATICPAGE_TITLE;
    }

    function install()
    {
        $this->setupDB();
    }

    function isplugin()
    {
        global $serendipity;

        $id = $this->getPageID();
        if (is_numeric($id)) {
            $q = 'SELECT content
                    FROM '.$serendipity['dbPrefix'].'staticpages
                   WHERE id = '.$id;
            $res = serendipity_db_query($q, true, 'assoc');
            if ($res['content'] == 'plugin') {
                return true;
            }
        }
        return false;

    }

    function showSearch() {
        global $serendipity;

        $term = serendipity_db_escape_string($serendipity['GET']['searchTerm']);
        if ($serendipity['dbType'] == 'postgres') {
            $group     = '';
            $distinct  = 'DISTINCT';
            $find_part = "(headline ILIKE '%$term%' OR content ILIKE '%$term%')";
        } elseif ($serendipity['dbType'] == 'sqlite' || $serendipity['dbType'] == 'sqlite3' || $serendipity['dbType'] == 'pdo-sqlite') {
            $group     = 'GROUP BY id';
            $distinct  = '';
            $term      = serendipity_mb('strtolower', $term);
            $find_part = "(lower(headline) LIKE '%$term%' OR lower(content) LIKE '%$term%')";
        } else {
            $group     = 'GROUP BY id';
            $distinct  = '';
            $term      = str_replace('&quot;', '"', $term);
            if (preg_match('@["\+\-\*~<>\(\)]+@', $term)) {
                $find_part = "MATCH(headline,content) AGAINST('$term' IN BOOLEAN MODE)";
            } else {
                $find_part = "MATCH(headline,content) AGAINST('$term')";
            }
        }

        $querystring = "SELECT $distinct s.*, a.realname
                          FROM {$serendipity['dbPrefix']}staticpages AS s
               LEFT OUTER JOIN {$serendipity['dbPrefix']}authors AS a
                            ON a.authorid = s.authorid
                         WHERE $find_part
                           AND s.publishstatus = 1
                           AND s.pass = ''
                               $group
                      ORDER BY timestamp DESC";

        $results = serendipity_db_query($querystring);
        if (!is_array($results)) {
            if ($results !== 1 && $results !== true) {
                echo '<div style="margin: 1em 2em;">'.$results.'</div>';//htmlspecialchars($results); // htmlspecialchars already done by serendipity_db_query()
            }
            $results = array();
        }
        $serendipity['smarty']->assign(
            array(
                'staticpage_searchresults' => count($results),
                'staticpage_results'       => $results
            )
        );

        $filename = 'plugin_staticpage_searchresults.tpl';
        // use nativ API here - extends s9y version >= 1.3'
        $content = $this->parseTemplate($filename);
        echo $content;
    }


    /**
     * -stm:
     * get the id of the staticpage for a given category-id
     *
     * @return mixed    int if match, else false
     *
     */

    function fetchCatProp($cid, $key = 'staticpage_categorypage') {
        global $serendipity;

        static $cache = array();

        if (isset($cache[$cid][$key])) {
            return $cache[$cid][$key];
        }

        $props = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}staticpage_categorypage WHERE categoryid = " . (int)$cid . " LIMIT 1");
        if (is_array($props)) {
            $cache[$cid] = $props[0];
            return $cache[$cid][$key];
        }

        return false;
    }


    /**
     * -stm:
     * get some elements of a staticpage for a given staticpage-id
     *
     * @return array  or false
     *
     */

    function fetchStaticPageForCat($staticpage_id)
    {
        global $serendipity;

        $q = 'SELECT *
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE id = '.(int)$staticpage_id.'
               LIMIT 1';
        $cache =  serendipity_db_query($q, true, 'assoc');
         if (is_array($cache)) {
             return $cache;
         }
         return false;
    }


    /**
     * -stm:
     * set the pair (categoryid, staticpage) for a given categoryid
     *
     * @return true
     *
     */

    function setCatProps($cid, $val = false, $deleteOnly = false) {
        global $serendipity;

        if (debug_staticpage == 'true') {
            echo "category ";
            echo $cid;
            echo " staticpage ";
            echo $val['staticpage_categorypage'];
        }

        serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}staticpage_categorypage
                                    WHERE categoryid = " . (int)$cid);

        if ($deleteOnly === false) {
            return serendipity_db_insert('staticpage_categorypage', $val);
        }
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch ($event) {

                case 'backend_category_showForm':
                    $pages = $this->fetchStaticPages(true);
                    $categorypage = $this->fetchCatProp((int)$eventData);

                    if (debug_staticpage == 'true') {
                        echo "category ";
                        echo (int)$eventData . " ";
                        echo " staticpage ";
                        echo $this->fetchCatProp((int)$eventData);
                    }

?>
    <tr>
        <td valign="top"><label for="staticpage_categorypage"><?php echo STATICPAGE_CATEGORYPAGE; ?></label></td>
        <td>

          <select name="serendipity[cat][staticpage_categorypage]">
                <option value=""><?php echo NONE; ?></option>

<?php

                $pages = $this->fetchStaticPages();
                if(is_array($pages)) {
                    $pages = serendipity_walkRecursive($pages);
                    foreach ($pages as $page) {
                        if ($this->checkPageUser($page['authorid'])) {
                            echo ' <option value="' . $page['id'] . '" ' . ($page['id'] == $this->fetchCatProp((int)$eventData) ? 'selected="selected"' : '') . '>';
                            echo str_repeat('&nbsp;&nbsp;', $page['depth']) . (function_exists('serendipity_specialchars') ? serendipity_specialchars($page['pagetitle']) : htmlspecialchars($page['pagetitle'], ENT_COMPAT, LANG_CHARSET)) . '</option>';
                        }
                    }
                }

?>
            </select>


        </td>
    </tr>
<?php

                    return true;
                    break;

                case 'backend_category_delete':
                    $this->setCatProps($eventData, null, true);

/*
**  problem: different to backend_category_update and backend_category_addNew, here $eventData did not contain the id of the category, so
**  the entry in the table _staticpage_categorypage is not deleted :-( Every time I get "35 AND 36" in the debug-modus.
**  GARVIN: Yes, the ID contains a SQL statement for Category ID because the category children are contained as well!
*/
                    break;

                case 'backend_category_update':
                case 'backend_category_addNew':
                    $val = array(
                        'categoryid '               =>  (int)$eventData,
                        'staticpage_categorypage'   => $serendipity['POST']['cat']['staticpage_categorypage'],
                    );
                    $this->setCatProps($eventData, $val);
                    break;

                case 'frontend_fetchentries':
                case 'frontend_rss':
                    $this->smarty_init();
                    break;

                case 'genpage':
                    $this->setupDB();
                    $args = implode('/', serendipity_getUriArguments($eventData, true));
                    if ($serendipity['rewrite'] != 'none') {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $args;
                    } else {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/' . $args;
                    }

// Manko10 patch: http://board.s9y.org/viewtopic.php?f=3&t=17910&p=10426432#p10426432

                    // Check if static page exists or if this is an error 404
                    //
                    // NOTE: as soon as you set a static page to be a 404 handler
                    // from within the backend, you need to add a specific redirect rule
                    // to your .htaccess for each static page generated by other
                    // plugins such as serendipity_event_contactform
                    // This behavior might change in future releases.
                    $this->error_404 = ($_SERVER['REDIRECT_STATUS'] == '404');

                    $pages = $this->fetchStaticPages(true, $nice_url);
                    if (is_array($pages)) {
                    foreach ($pages as $page) {
                        if ($page['permalink'] == $nice_url) {
                            $this->error_404 = FALSE;
                            if ($pages['is_404_page']) {
                                $this->error_404 = TRUE;
                            }
                            break;
                        }
                    }
                    }

                    // Set static page to 404 error document if page not found
                    if ($this->error_404) {
                        $serendipity['GET']['subpage'] = $this->get404Errorpage();
                    }

                    // Set static page with is_startpage flag set as startpage
                    if ((empty($args) || preg_match('@' . $serendipity['indexFile'] . '\??$@', trim($args))) && empty($serendipity['GET']['subpage'])) {
                        $serendipity['GET']['subpage'] = $this->getStartpage();
                    }

                    // Set static page according to requested URL
                    if (empty($serendipity['GET']['subpage'])) {
                        $serendipity['GET']['subpage'] = $nice_url;
                    }

                    if ($this->selected()) {
                        $te = $this->get_static('title_element');
                        if (!empty($te)) {
                            $serendipity['head_title']    = (function_exists('serendipity_specialchars') ? serendipity_specialchars($te) : htmlspecialchars($te, ENT_COMPAT, LANG_CHARSET));
                            $serendipity['head_subtitle'] ='';
                        } else {
                        $serendipity['head_title']    = $this->get_static('headline');
                        $serendipity['head_subtitle'] = $serendipity['blogTitle'];
                        }
                    }
                    break;

                case 'frontend_header':
                    $md = (function_exists('serendipity_specialchars') ? serendipity_specialchars($this->get_static('meta_description')) : htmlspecialchars($this->get_static('meta_description'), ENT_COMPAT, LANG_CHARSET));
                    $mk = (function_exists('serendipity_specialchars') ? serendipity_specialchars($this->get_static('meta_keywords')) : htmlspecialchars($this->get_static('meta_keywords'), ENT_COMPAT, LANG_CHARSET));
                    if (!empty($md))
                    {
                        echo '        <meta name="description" content="' . $md . '" />' . "\n";
                    }

                    if (!empty($mk))
                    {
                        echo '        <meta name="keywords" content="' . $mk . '" />' . "\n";
                    }
                    break;

                case 'frontend_fetchentries':
                    if ($serendipity['GET']['action'] == 'search') {
                        serendipity_smarty_fetch('ENTRIES', 'entries.tpl', true);
                    }
                    break;

                case 'entry_display':

                    $this->smarty_init();

                    if ($this->selected()) {
                        if (is_array($eventData)) {
                            $eventData['clean_page'] = true; // This is important to not display an entry list!
                        } else {
                            $eventData = array('clean_page' => true);
                        }
                    }

                    break;

                case 'backend_sidebar_entries':
                    $this->setupDB();
                    echo '<li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages">' . STATICPAGE_TITLE . '</a></li>';
                    break;

                case 'backend_sidebar_entries_event_display_staticpages':
                    $this->showBackend();
                    break;


                case 'backend_media_rename':


                    // Only MySQL supported, since I don't know how to use REGEXPs differently.
                    if ($serendipity['dbType'] != 'mysql' && $serendipity['dbType'] != 'mysqli') {
                        echo STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRY . '<br />';
                        break;
                    }

                    if (!isset($eventData[0]['oldDir'])) {
                        return true;
                    }

                    if ($eventData[0]['type'] == 'dir'){

                    }

                    elseif ($eventData[0]['type'] == 'filedir'){

                         $eventData[0]['oldDir'] .= $eventData[0]['name'];
                         $eventData[0]['newDir'] .= $eventData[0]['name'];
                    }


                    $q = "SELECT id, content, pre_content
                            FROM {$serendipity['dbPrefix']}staticpages
                           WHERE content     REGEXP '(src=|href=|window.open.)(\'|\")(" . serendipity_db_escape_String($serendipity['baseURL'] . $serendipity['uploadHTTPPath'] . $eventData[0]['oldDir']) . "|" . serendipity_db_escape_string($serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $eventData[0]['oldDir']) . ")'
                              OR pre_content REGEXP '(src=|href=|window.open.)(\'|\")(" . serendipity_db_escape_String($serendipity['baseURL'] . $serendipity['uploadHTTPPath'] . $eventData[0]['oldDir']) . "|" . serendipity_db_escape_string($serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $eventData[0]['oldDir']) . ")'
                    ";

                    $dirs = serendipity_db_query($q);
                    if (is_array($dirs)) {
                        foreach($dirs AS $dir) {

                            $dir['content']     = preg_replace('@(src=|href=|window.open.)(\'|")(' . preg_quote($serendipity['baseURL'] . $serendipity['uploadHTTPPath'] . $eventData[0]['oldDir']) . '|' . preg_quote($serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $eventData[0]['oldDir']) . ')@', '\1\2' . $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $eventData[0]['newDir'], $dir['content']);
                            $dir['pre_content'] = preg_replace('@(src=|href=|window.open.)(\'|")(' . preg_quote($serendipity['baseURL'] . $serendipity['uploadHTTPPath'] . $eventData[0]['oldDir']) . '|' . preg_quote($serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $eventData[0]['oldDir']) . ')@', '\1\2' . $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $eventData[0]['newDir'], $dir['pre_content']);

                            $uq = "UPDATE {$serendipity['dbPrefix']}staticpages
                                                     SET content     = '" . serendipity_db_escape_string($dir['content']) . "' ,
                                                         pre_content = '" . serendipity_db_escape_string($dir['pre_content']) . "'
                                                   WHERE id       = " . serendipity_db_escape_string($dir['id']);
                            serendipity_db_query($uq);
                        }

                        printf(STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRIES . '<br />', count($dirs));
                    }



                    break;

                case 'external_plugin':
                    $parts = explode('_', $eventData);
                    if (!empty($parts[1])) {
                        $param = (int)$parts[1];
                    } else {
                        $param = null;
                    }

                    if ($parts[0] == 'dtree.js') {
                        header('Content-Type: text/javascript');
                        echo file_get_contents(dirname(__FILE__) . '/dtree.js');
                    }

                    break;

                case 'entries_header':
                    if (!$this->isplugin()) {
                        $this->show();
                    }

                    break;

                case 'entries_footer':
                    if ($serendipity['GET']['action'] == 'search' && serendipity_db_bool($this->get_config('use_quicksearch'))) {
                        $this->showSearch();
                    }
                    break;

                case 'css_backend':
                    if (!strpos($eventData, '#serendipityStaticpagesNav')) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        echo file_get_contents(dirname(__FILE__) . '/style_staticpage_backend.css');
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