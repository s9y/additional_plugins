<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_startcat extends serendipity_event
{
    var $title = PLUGIN_EVENT_STARTCAT_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_STARTCAT_NAME);
        $propbag->add('description',   PLUGIN_EVENT_STARTCAT_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Stefan Willoughby, Garvin Hicking');
        $propbag->add('version',       '1.10');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('event_hooks',    array(
            'frontend_configure' => true,
            'external_plugin'    => true,
            'frontend_rss'       => true,
            'genpage'            => true
        ));
        $propbag->add('groups', array('FRONTEND_VIEWS'));

        $propbag->add('configuration', array('base_category', 'hide_category', 'base_categories', 'hide_categories', 'remembercat'));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;
        switch ($name) {
            case 'base_category':
                if (version_compare($serendipity['version'], '0.8', '>=')) {
                    $base_cats = serendipity_fetchCategories();
                    $base_cats = serendipity_walkRecursive($base_cats, 'categoryid', 'parentid', VIEWMODE_THREADED);
                    $select['none'] = NONE;
                    foreach ( $base_cats as $cat ) {
                        $select[$cat['categoryid']] = str_repeat('-', $cat['depth']) . ' '. $cat['category_name'];
                    }


                    $propbag->add('type', 'select');
                    $propbag->add('name', PLUGIN_EVENT_STARTCAT_CATEGORY_NAME);
                    $propbag->add('description', PLUGIN_EVENT_STARTCAT_CATEGORY_DESC);
                    $propbag->add('select_values', $select);
                }
                break;

            case 'base_categories':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_STARTCAT_MULTICATEGORY_NAME);
                $propbag->add('description', PLUGIN_EVENT_STARTCAT_MULTICATEGORY_DESC);
                $propbag->add('default', '');
                break;

            case 'remembercat':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_STARTCAT_REMEMBERCAT_NAME);
                $propbag->add('description', PLUGIN_EVENT_STARTCAT_REMEMBERCAT_DESC);
                $propbag->add('default', false);
                break;

            case 'hide_category':
                if (version_compare($serendipity['version'], '0.8', '>=')) {
                    $base_cats = serendipity_fetchCategories();
                    $base_cats = serendipity_walkRecursive($base_cats, 'categoryid', 'parentid', VIEWMODE_THREADED);
                    $select['none'] = NONE;
                    foreach ( $base_cats as $cat ) {
                        $select[$cat['categoryid']] = str_repeat('-', $cat['depth']) . ' '. $cat['category_name'];
                    }


                    $propbag->add('type', 'select');
                    $propbag->add('name', PLUGIN_EVENT_STARTCAT_HIDECATEGORY_NAME);
                    $propbag->add('description', PLUGIN_EVENT_STARTCAT_HIDECATEGORY_DESC);
                    $propbag->add('select_values', $select);
                }
                break;

            case 'hide_categories':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_STARTCAT_MULTIHIDECATEGORY_NAME);
                $propbag->add('description', PLUGIN_EVENT_STARTCAT_MULTIHIDECATEGORY_DESC);
                $propbag->add('default', '');
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

                case 'external_plugin':
                case 'frontend_rss':
                    if (defined('STARTCAT_CATEGORY') && !isset($_GET['category']) && $serendipity['GET']['category'] == STARTCAT_CATEGORY) {
                        unset($serendipity['GET']['category']);
                    }
                    break;

                case 'genpage':
                    if (defined('STARTCAT_CATEGORY') && $serendipity['GET']['category'] == STARTCAT_CATEGORY && !empty($serendipity['GET']['viewAuthor'])) {
                        unset($serendipity['GET']['category']);
                    }
                    break;
                    
                case 'frontend_configure':
                    if (!empty($serendipity['GET']['adminModule'])) {
                        return true;
                    }


                    $bc = $this->get_config('base_categories');
                    if (empty($bc)) {
                        $bc = $this->get_config('base_category');
                    }
                    if (!isset($serendipity['GET']['id']) && !empty($bc) && $bc != 'none' && $serendipity['GET']['category'] != 'all') {
                        $serendipity['GET']['category'] = $bc;
                        define('STARTCAT_CATEGORY', $bc);
                    }

                    if ($serendipity['GET']['category'] == 'all') {
                        unset($serendipity['GET']['category']);
                    }

                    $hc = $this->get_config('hide_categories');
                    if (empty($hc)) {
                        $hc = $this->get_config('hide_category');
                    }
                    if (!empty($hc) && $hc != 'none' && !isset($serendipity['GET']['hide_category'])) {
                        $serendipity['GET']['hide_category'] = $hc;
                    }

                    if (serendipity_db_bool($this->get_config('remembercat'))) {
                        if ((empty($serendipity['GET']['category']) || defined('STARTCAT_CATEGORY')) && !empty($serendipity['COOKIE']['category']) && !isset($serendipity['GET']['id'])) {
                            $serendipity['GET']['category'] = $serendipity['COOKIE']['category'];
                        }

                        if (is_array($serendipity['POST']['multiCat'])) {
                            $serendipity['GET']['category'] = implode(';', $serendipity['POST']['multiCat']);
                        }

                        if (is_array($serendipity['GET']['multiCat'])) {
                            $serendipity['GET']['category'] = implode(';', $serendipity['GET']['multiCat']);
                        }

                        if (!empty($serendipity['GET']['category'])) {
                            serendipity_setCookie('category', $serendipity['GET']['category']);
                        }
                    }

                    break;
            }
        }

    }
}

