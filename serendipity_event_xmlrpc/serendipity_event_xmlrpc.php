<?php # 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

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
        $propbag->add('version',       '1.60.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',    array(
            'frontend_xmlrpc'  => true,
            'frontend_header'  => true
        ));
        $propbag->add('configuration', 
            array('doc_rpclink','category', 'gmt', 'uploaddir', 'htmlconvert', 'asureauthor', 'wpfakeversion', 'debuglog', 'spamevent_description', 'event_spam', 'event_approved','event_pending')
            );
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
                <api name="WordPress"   preferred="false"  apiLink="' . $serendipity['baseURL'] . 'serendipity_xmlrpc.php" blogID="1" />
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
        global $serendipity;
        
        switch($name) {
            case 'doc_rpclink':
                $propbag->add('type',           'content');
                $propbag->add('default',        sprintf(PLUGIN_EVENT_XMLRPC_DOC_RPCLINK, $serendipity['baseURL'] . 'serendipity_xmlrpc.php'));
                break;
            case 'debuglog':
                $debuglevels = array(
                    'none'     => PLUGIN_EVENT_XMLRPC_DEBUGLOG_NONE,
                    'normal'   => PLUGIN_EVENT_XMLRPC_DEBUGLOG_NORMAL,
                    //'verbose'  => PLUGIN_EVENT_XMLRPC_DEBUGLOG_VERBOSE
                );
                $propbag->add('type',          'select');
                $propbag->add('select_values', $debuglevels);
                $propbag->add('name', PLUGIN_EVENT_XMLRPC_DEBUGLOG);
                $propbag->add('description', PLUGIN_EVENT_XMLRPC_DEBUGLOG_DESC);
                $propbag->add('default', 'none');
                break;
            case 'gmt':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_XMLRPC_GMT);
                $propbag->add('description', '');
                $propbag->add('default', false);
                break;
            case 'uploaddir' :
                $propbag->add('type',          'select');
                $propbag->add('select_values', $this->scanUploadDir());
                $propbag->add('name', PLUGIN_EVENT_XMLRPC_UPLOADDIR);
                $propbag->add('description', PLUGIN_EVENT_XMLRPC_UPLOADDIR_DESC);
                $propbag->add('default', '');
                break;
            case 'htmlconvert':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_XMLRPC_HTMLCONVERT);
                $propbag->add('description', PLUGIN_EVENT_XMLRPC_HTMLCONVERT_DESC);
                $propbag->add('default', true);
                break;
            case 'asureauthor':
                $authoroptions = array(
                    'default'             => PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_DEFAULT,
                    'serendipityUser'     => PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_LOGIN,
                    'serendipityRealname' => PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_REALNAME,
                );
                $propbag->add('type',          'select');
                $propbag->add('select_values', $authoroptions);
                $propbag->add('name', PLUGIN_EVENT_XMLRPC_ASUREAUTHOR);
                $propbag->add('description', PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_DESC);
                $propbag->add('default', 'default');
                break;
            case 'wpfakeversion' :
                $propbag->add('type',          'string');
                $propbag->add('name',          PLUGIN_EVENT_XMLRPC_WPFAKEVERSION);
                $propbag->add('description',   PLUGIN_EVENT_XMLRPC_WPFAKEVERSION_DESC);
                $propbag->add('default',       '');
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
            case 'spamevent_description':
                $propbag->add('type',           'content');
                $propbag->add('default',        PLUGIN_EVENT_XMLRPC_EVENT_SPAM_HEADER);
                break;
            case 'event_spam':
            case 'event_approved':
            case 'event_pending':
                $events = array(
                    'none'     => PLUGIN_EVENT_XMLRPC_EVENTVALUE_NONE,
                    'spam'   => PLUGIN_EVENT_XMLRPC_EVENTVALUE_SPAM,
                    'ham'  => PLUGIN_EVENT_XMLRPC_EVENTVALUE_HAM
                );
                $propbag->add('type',          'select');
                $propbag->add('select_values', $events);
                if ($name=='event_spam') {
                    $propbag->add('name', PLUGIN_EVENT_XMLRPC_EVENT_SPAM);
                    $propbag->add('description', PLUGIN_EVENT_XMLRPC_EVENT_SPAM_DESC);
                    $propbag->add('default', 'spam');
                }
                elseif ($name=='event_approved') {
                    $propbag->add('name', PLUGIN_EVENT_XMLRPC_EVENT_APPROVED);
                    $propbag->add('description', PLUGIN_EVENT_XMLRPC_EVENT_APPROVED_DESC);
                    $propbag->add('default', 'ham');
                }
                elseif ($name=='event_pending') {
                    $propbag->add('name', PLUGIN_EVENT_XMLRPC_EVENT_PENDING);
                    $propbag->add('description', PLUGIN_EVENT_XMLRPC_EVENT_PENDING_DESC);
                    $propbag->add('default', 'none');
                }
                break;

            default:
                    return false;
        }
        return true;
    }


    function event_hook($event, &$bag, &$eventData, $addData = null) {
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
                    $serendipity['xmlrpc_debuglog'] = $this->get_config('debuglog','none');
                    $serendipity['xmlrpc_wpfakeversion'] = $this->get_config('wpfakeversion','');
                    $serendipity['xmlrpc_htmlconvert']  = $this->get_config('htmlconvert',true);
                    $serendipity['xmlrpc_uploadreldir']  = $this->get_config('uploaddir','');
                    $serendipity['xmlrpc_asureauthor'] = $this->get_config('asureauthor','default');
                    
                    $serendipity['xmlrpc_event_spam']  = $this->get_config('event_spam','spam');
                    $serendipity['xmlrpc_event_approved']  = $this->get_config('event_approved','ham');
                    $serendipity['xmlrpc_event_pending']  = $this->get_config('event_approved','none');
                    
                    @define('SERENDIPITY_IS_XMLRPC', true);
                    $serendipity['XMLRPC_GMT'] = serendipity_db_bool($this->get_config('gmt'));
                    
                    $this->setupPearPath();
                    if (!class_exists('XML_RPC_Base')) {
                        require_once PLUGIN_EVENT_XMLRPC_PEAR_PATH . 'XML/RPC.php';
                    }

                    if (!class_exists('XML_RPC_Server')) {
                        require_once PLUGIN_EVENT_XMLRPC_PEAR_PATH . 'XML/RPC/Server.php';
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
    
    function setupPearPath() {
        // use bundled PEAR modules instead of plugins, if found
        // The s9y bundled lib could be outdated. Upgrading it with the plugin is much more easy.
        /*
        @define('S9Y_PEAR_PATH', $serendipity['serendipityPath'] . 'bundled-libs/');
        if (file_exists(S9Y_PEAR_PATH . 'XML/RPC.php') && file_exists(S9Y_PEAR_PATH . 'XML/RPC/Server.php')) {
            @define('PLUGIN_EVENT_XMLRPC_PEAR_PATH', S9Y_PEAR_PATH);
        }
        else { */
            @define('PLUGIN_EVENT_XMLRPC_PEAR_PATH',dirname(__FILE__) . '/PEAR/');
//        }
    }
    
    function scanUploadDir(){
        global $serendipity;

        if (!serendipity_checkPermission('adminImagesDirectories')) {
            return;
        }
        $folders = serendipity_traversePath(
            $serendipity['serendipityPath'] . $serendipity['uploadPath'],
            '',
            true,
            NULL,
            1,
            NULL,
            'write'
        );
        usort($folders, 'serendipity_sortPath');
        $result = array('' => PARENT_DIRECTORY);
        foreach ($folders as $dirmeta) {
            $result[$dirmeta['relpath']] = $dirmeta['relpath'];
        }
        return $result;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
