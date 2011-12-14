<?php # $Id: serendipity_event_xmlrpc.php,v 1.42 2009/08/03 14:24:46 garvinhicking Exp $


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_xmlrpc extends serendipity_event
{
    var $title = PLUGIN_EVENT_XMLRPC_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_XMLRPC_NAME);
        $propbag->add('description',   PLUGIN_EVENT_XMLRPC_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Serendipity Team');
        $propbag->add('version',       '1.45');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',    array(
            'frontend_xmlrpc'  => true,
            'frontend_header'  => true
        ));
        $propbag->add('configuration', array('category', 'gmt'));
        $propbag->add('groups', array('FRONTEND_FULL_MODS', 'FRONTEND_EXTERNAL_SERVICES'));
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function showXSD() {
        global $serendipity;

        echo '<?xml version="1.0" ?> 
        <rsd version="1.0" xmlns="http://archipelago.phrasewise.com/rsd" >
        <service>
            <engineName>Serendipity (s9y)</engineName> 
            <engineLink>http://www.s9y.org/</engineLink>
            <homePageLink>' . $serendipity['baseURL'] . '</homePageLink>
            <apis>
                <api name="MovableType" preferred="true"   apiLink="' . $serendipity['baseURL'] . 'serendipity_xmlrpc.php" blogID="1" />
                <api name="MetaWeblog"  preferred="false"  apiLink="' . $serendipity['baseURL'] . 'serendipity_xmlrpc.php" blogID="1" />
                <api name="Blogger"     preferred="false"  apiLink="' . $serendipity['baseURL'] . 'serendipity_xmlrpc.php" blogID="1" />
            </apis>
        </service>
        </rsd>';
    }
    // <api name="WordPress"   preferred="false"  apiLink="' . $serendipity['baseURL'] . 'serendipity_xmlrpc.php" blogID="1" />
    
    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'gmt':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_XMLRPC_GMT);
                $propbag->add('description', '');
                $propbag->add('default', false);
                break;

            case 'category':
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
                $select_cats[''] = '';
                foreach($tmp_select_cats as $cidx => $tmp_select_cat) {
                    $select_cat = explode('|||', $tmp_select_cat);
                    if (!empty($select_cat[0]) && !empty($select_cat[1])) {
                        $select_cats[$select_cat[0]] = $select_cat[1];
                    }
                }

                $propbag->add('type',          'select');
                $propbag->add('select_values', $select_cats);
                $propbag->add('name',          PLUGIN_EVENT_XMLRPC_DEFAULTCAT);
                $propbag->add('description',   PLUGIN_EVENT_XMLRPC_DEFAULTCAT_DESC);
                $propbag->add('default',       '');
                break;

            default:
                    return false;
        }
        return true;
    }


    function event_hook($event, &$bag, &$eventData) {
        global $serendipity, $HTTP_RAW_POST_DATA;

        $hooks = &$bag->get('event_hooks');
        $links = array();
        $article_show = false;

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_header':
                   echo '<link rel="pingback" href="' . $serendipity['baseURL'] . 'serendipity_xmlrpc.php" />' . "\n";
                   echo '<link rel="EditURI" type="application/rsd+xml" title="RSD" href="' . $serendipity['baseURL'] . 'serendipity_xmlrpc.php?xsd=true" />' . "\n";
                   break;

                case 'frontend_xmlrpc':
                    // Those variables should not be set by other plugins!
                    header('Content-Type: text/xml');
                    $eventData = array('XML-RPC' => true);
                    
                    if ($_REQUEST['xsd']) {
                        $this->showXSD();
                        return true;
                    }
                    unset($serendipity['GET']['category']);
                    unset($serendipity['GET']['hide_category']);
                    $serendipity['xmlrpc_default_category'] = $this->get_config('category');

                    @define('SERENDIPITY_IS_XMLRPC', true);
                    $serendipity['XMLRPC_GMT'] = serendipity_db_bool($this->get_config('gmt'));

                    if (!class_exists('XML_RPC_Base')) {
                        require_once dirname(__FILE__) . '/PEAR/XML/RPC.php';
                    }

                    if (!class_exists('XML_RPC_Server')) {
                        require_once dirname(__FILE__) . '/PEAR/XML/RPC/Server.php';
                    }

                    require_once dirname(__FILE__) . '/serendipity_xmlrpc.inc.php';

                    return true;

                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
