<?php

# serendipity_event_downloadmanager.php, v.0.26 - 2011-02-15 20:21 ian

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

#########################################################################################

@define( "PWD_ALLOW_NUM", ( 1 << 0 ));
@define( "PWD_ALLOW_LC",  ( 1 << 1 ));
@define( "PWD_ALLOW_UC",  ( 1 << 2 ));
@define( "PWD_ALLOW_DFLT", ( PWD_ALLOW_NUM | PWD_ALLOW_LC ));
@define( "PWD_ALLOW_ALL", ( PWD_ALLOW_NUM | PWD_ALLOW_LC  | PWD_ALLOW_UC ));

/***
 * Set global plugin path setting, to avoid different pluginpath '/plugins/' as plugins serendipity vars 
 **/
if(!isset($serendipity['dlm']['pluginpath'])) { 
    $pluginpath = pathinfo(dirname(__FILE__));
    $serendipity['dlm']['pluginpath'] = basename(rtrim($pluginpath['dirname'], '/')) . '/serendipity_event_downloadmanager/';
}


class serendipity_event_downloadmanager extends serendipity_event {

    var $debug;
    var $MIME;
    var $globs = array();

    function introspect(&$propbag) {
        global $serendipity; 

        $this->pluginglobs();

        $propbag->add('name',          PLUGIN_DOWNLOADMANAGER_TITLE);
        $propbag->add('description',   PLUGIN_DOWNLOADMANAGER_DESC);
        $propbag->add('requirements',  array(
            'serendipity' => '1.3',
            'smarty'      => '2.6.7',
            'php'         => '5.0.0'
        ));

        $propbag->add('version',       '0.29');
        $propbag->add('author',       'Alexander \'dma147\' Mieland, Grischa Brockhaus, Ian (Timbalu)');
        $propbag->add('stackable',     false);
        $propbag->add('event_hooks',   array(
                                            'entries_header'          => true,
                                            'entry_display'           => true,
                                            'external_plugin'         => true,
                                            'css'                     => true,
                                            'css_backend'             => true,
                                            'backend_sidebar_entries' => true,
                                            'backend_dlm_filecopy'    => true,
                                            'backend_sidebar_entries_event_display_downloadmanager' => true
                                        )
        );
        $propbag->add('configuration', array(
                                            'pagetitle',
                                            'headline',
                                            'intro',
                                            'pageurl',
                                            'permalink',
                                            'absincomingpath',
                                            'absdownloadspath',
                                            'httppath',
                                            'add_existing_file',
                                            'iconwidth',
                                            'iconheight',
                                            'dateformat',
                                            'showhidden_registered',
                                            'registered_only',
                                            'showfilename',
                                            'showdownloads',
                                            'showfilesize',
                                            'showdate',
                                            'showdesc_inlist',
                                            'directdl_inlist',
                                            'filename_field',
                                            'filesize_field',
                                            'filedate_field',
                                            'dls_field'
                                        )
        );
        $propbag->add('groups', array('FRONTEND_FULL_MODS'));
        $this->dependencies = array('serendipity_event_entryproperties' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
           case 'pagetitle' :
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_PAGETITLE);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_PAGETITLE_BLAHBLAH);
                $propbag->add('default', 'My downloads');

                break;

            case 'headline' :
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_HEADLINE);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_HEADLINE_BLAHBLAH);
                $propbag->add('default', 'Here you can find some useful downloads');

                break;

            case 'intro':
                $propbag->add('type', ($serendipity['wysiwyg'] === true ? 'html' : 'text'));
                $propbag->add('rows', 3);
                $propbag->add('name',        PLUGIN_DOWNLOADMANAGER_INTRO);
                $propbag->add('description', '');
                $propbag->add('default',     '');
                break;

            case 'pageurl' :
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_PAGEURL);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_PAGEURL_BLAHBLAH);
                $propbag->add('default', 'downloadmanager');

                break;

            case 'permalink':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_DOWNLOADMANAGER_PERMALINK);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_PERMALINK_BLAHBLAH);
                $propbag->add('default',     $serendipity['rewrite'] != 'none'
                                             ? $serendipity['serendipityHTTPPath'] . 'downloads.html'
                                             : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/downloads.html');
                break;

            case 'absincomingpath':
                $propbag->add('type', ( serendipity_db_bool($this->get_config('chg2archivespath')) ? 'hidden' : 'string'));
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_ABSINCOMINGPATH);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_ABSINCOMINGPATH_BLAHBLAH);
                $propbag->add('default', $serendipity['serendipityPath'] . 'archives/.dlm/ftpin');

                break;

            case 'absdownloadspath':
                $propbag->add('type', ( serendipity_db_bool($this->get_config('chg2archivespath')) ? 'hidden' : 'string'));
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_ABSDOWNLOADPATH);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_ABSDOWNLOADPATH_BLAHBLAH);
                $propbag->add('default', $serendipity['serendipityPath'] . 'archives/.dlm/files');

                break;

            case 'httppath':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_HTTPPATH);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_HTTPPATH_BLAHBLAH);
                $propbag->add('default', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_downloadmanager/');

                break;

            case 'iconwidth':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_ICONWIDTH);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_ICONWIDTHBLAH);
                $propbag->add('default',     '18');
                
                break;

            case 'iconheight':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_ICONHEIGHT);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_ICONHEIGHT_BLAHBLAH);
                $propbag->add('default',     '20');
                
                break;

            case 'dateformat':
                $propbag->add('type', 'string');
                $propbag->add('name', GENERAL_PLUGIN_DATEFORMAT);
                $propbag->add('description', sprintf(PLUGIN_DOWNLOADMANAGER_DATEFORMAT, 'Y/m/d, h:ia'));
                $propbag->add('default',     'Y/m/d, h:ia');
                
                break;

            case 'showhidden_registered':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_SHOWHIDDEN_REGISTERED);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_SHOWHIDDEN_REGISTERED_BLAHBLAH);
                $propbag->add('default', 'false');

                break;

            case 'registered_only':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY_BLAHBLAH);
                $propbag->add('default', 'false');

                break;

            case 'showfilename':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_SHOWFILENAME);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_SHOWFILENAME_BLAHBLAH);
                $propbag->add('default', 'true');

                break;

            case 'showdownloads':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_SHOWDOWNLOADS);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_SHOWDOWNLOADS_BLAHBLAH);
                $propbag->add('default', 'true');

                break;

            case 'showfilesize':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_SHOWFILESIZE);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_SHOWFILESIZE_BLAHBLAH);
                $propbag->add('default', 'true');

                break;

            case 'showdate':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_SHOWFILEDATE);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_SHOWFILEDATE_BLAHBLAH);
                $propbag->add('default', 'false');

                break;

            case 'showdesc_inlist':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_SHOWDESC_INLIST);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_SHOWDESC_INLIST_DESC);
                $propbag->add('default', 'false');

                break;

            case 'directdl_inlist':
                $listdl_types = array(
                    'no'    => PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_NO,
                    'icon'  => PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_ICON,
                    'name'  => PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_NAME,
                    'both'  => PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_BOTH,
                    );
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_DESC);
                $propbag->add('default', 'no');
                $propbag->add('select_values', $listdl_types);

                break;

            case 'add_existing_file':
                $existing_types = array(
                    'insert'    => PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_INSERT,
                    'update'    => PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_UPDATE,
                    );
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_ADD_EXISTING);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_DESC);
                $propbag->add('default', 'insert');
                $propbag->add('select_values', $existing_types);

                break;

             case 'filename_field' :
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_FILENAME_FIELD);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_FILENAME_FIELD_BLAHBLAH);
                $propbag->add('default', PLUGIN_DOWNLOADMANAGER_FILENAME);

                break;

             case 'filesize_field' :
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_FILESIZE_FIELD);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_FILESIZE_FIELD_BLAHBLAH);
                $propbag->add('default', PLUGIN_DOWNLOADMANAGER_FILESIZE);

                break;

             case 'filedate_field' :
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_FILEDATE_FIELD);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_FILEDATE_FIELD_BLAHBLAH);
                $propbag->add('default', PLUGIN_DOWNLOADMANAGER_FILEDATE);

                break;

             case 'dls_field' :
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_DOWNLOADMANAGER_DLS_FIELD);
                $propbag->add('description', PLUGIN_DOWNLOADMANAGER_DLS_FIELD_BLAHBLAH);
                $propbag->add('default', PLUGIN_DOWNLOADMANAGER_NUM_DOWNLOADS);

                break;

            default:
                return false;
        }
        return true;
    }


    function show() {
        global $serendipity;

        if ($this->selected()) {
            if (!headers_sent()) {
                header('HTTP/1.0 200');
                header('Status: 200 OK');
            }

            serendipity_smarty_init();
            $serendipity['smarty']->assign('staticpage_pagetitle', preg_replace('@[^a-z0-9]@i', '_',$this->get_config('pagetitle')));
            $this->showShoutPage();
        }
    }

    function selected() {
        global $serendipity;

        if ($serendipity['GET']['subpage'] == $this->get_config('pageurl') ||
            preg_match('@^' . preg_quote($this->get_config('permalink')) . '@i', $serendipity['GET']['subpage'])) {
            return true;
        }

        return false;
    }

    function setupDB() {
        global $serendipity;

        $built = $this->get_config('dl_db_built', null);
        if (empty($built) && !defined('DLMANAGER_UPGRADE_DONE')) {
            $q = "CREATE TABLE {$serendipity['dbPrefix']}dma_downloadmanager_files (
                    id                {AUTOINCREMENT} {PRIMARY},
                    catid          int(10) NOT NULL default '0',
                    timestamp        int(10) NOT NULL default '0',
                    systemfilename varchar(32),
                    realfilename   varchar(150),
                    description    text,
                    filesize       int(10) NOT NULL default '0',
                    dlcount        int(10) NOT NULL default '0'
                )";
            $sql = serendipity_db_schema_import($q);
            $q = "CREATE TABLE {$serendipity['dbPrefix']}dma_downloadmanager_categories (
                    node_id     {AUTOINCREMENT} {PRIMARY},
                    root_id     int(10) NOT NULL default '0',
                    payload     varchar(64),
                    lft         int(10) NOT NULL default '0',
                    rgt         int(10) NOT NULL default '0'
                )";
            $sql = serendipity_db_schema_import($q);


            $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_downloadmanager_categories WHERE payload = 'root'";
            $root = serendipity_db_query($sql);
            if(intval($root[0]['node_id']) != 1) {
                serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}dma_downloadmanager_categories (payload, lft, rgt )
                                        VALUES ('root', 1, 2 )");
                $last_insert_id = serendipity_db_insert_id('dma_downloadmanager_categories', 'node_id');
                serendipity_db_query("UPDATE {$serendipity['dbPrefix']}dma_downloadmanager_categories
                                       SET root_id = $last_insert_id
                                     WHERE node_id = $last_insert_id");
            }

            $this->set_config('dl_db_built', '1');
            @define('DLMANAGER_UPGRADE_DONE', true); // No further static pages may be called!
        }

        switch($built){
            case 1:
                $q = "CREATE TABLE {$serendipity['dbPrefix']}dma_downloadmanager_categories_tmp (
                        node_id     {AUTOINCREMENT} {PRIMARY},
                        root_id     int(10) NOT NULL default '0',
                        payload     varchar(64),
                        lft         int(10) NOT NULL default '0',
                        rgt         int(10) NOT NULL default '0'
                    )";
                $sql = serendipity_db_schema_import($q);
                $q = "INSERT INTO {$serendipity['dbPrefix']}dma_downloadmanager_categories_tmp
                             (node_id, root_id, payload, lft, rgt)
                      SELECT node_id, root_id, payload, lft, rgt FROM {$serendipity['dbPrefix']}dma_downloadmanager_categories;";
                $sql = serendipity_db_schema_import($q);
                $q = "DROP TABLE {$serendipity['dbPrefix']}dma_downloadmanager_categories;";
                $sql = serendipity_db_schema_import($q);
                $q = "CREATE TABLE {$serendipity['dbPrefix']}dma_downloadmanager_categories (
                        node_id     {AUTOINCREMENT} {PRIMARY},
                        root_id     int(10) NOT NULL default '0',
                        payload     varchar(64),
                        lft         int(10) NOT NULL default '0',
                        rgt         int(10) NOT NULL default '0',
                        hidden      int(2)  NOT NULL default '0'
                    )";
                $sql = serendipity_db_schema_import($q);
                $q = "INSERT INTO {$serendipity['dbPrefix']}dma_downloadmanager_categories
                             (node_id, root_id, payload, lft, rgt)
                      SELECT node_id, root_id, payload, lft, rgt FROM {$serendipity['dbPrefix']}dma_downloadmanager_categories_tmp;";
                $sql = serendipity_db_schema_import($q);
                $q = "DROP TABLE {$serendipity['dbPrefix']}dma_downloadmanager_categories_tmp;";
                $sql = serendipity_db_schema_import($q);
                $this->set_config('dl_db_built', '2');
                break;
        }

    }

    function uninstall(&$propbag) {
        global $serendipity;

        serendipity_db_query("DROP TABLE {$serendipity['dbPrefix']}dma_downloadmanager_files");
        serendipity_db_query("DROP TABLE {$serendipity['dbPrefix']}dma_downloadmanager_categories");

    }



    /** dlm sql db function set
      * @param  type string and db vars
      * @return result
      * 
      * serendipity_db_query [ sql, single(true, false), arrtype(both, assoc, num), dberror(true, false), string(array key name), string(array field name) ... ]
    **/    
    function dlm_sql_db($type=NULL, $whe=NULL) { 
        global $serendipity;
        
        switch($type) { 
            case 'DLM_BE_UPDATE':
                // approve events
                $sql = "UPDATE {$serendipity['dbPrefix']}dma_downloadmanager_files SET $whe";
                $result = serendipity_db_query($sql, true, 'both', true);
                break;
            case 'DLM_BE_DELETE_FILE':
                // delete events
                $sql = "DELETE FROM {$serendipity['dbPrefix']}dma_downloadmanager_files WHERE $whe";
                $result = serendipity_db_query($sql, true, 'both', true);
                break;
            case 'DLM_BE_DELETE_CAT':
                // delete events
                $sql = "DELETE FROM {$serendipity['dbPrefix']}dma_downloadmanager_categories WHERE $whe";
                $result = serendipity_db_query($sql, true, 'both', true);
                break;
            case 'DLM_SUBCATS':
                // mysql_fetch_array :: result is a single array select (TRUE)
                $sql = "SELECT node1.*, round((node1.rgt-node1.lft-1)/2,0) AS subcats
                        FROM {$serendipity['dbPrefix']}dma_downloadmanager_categories AS node1
                        WHERE $whe";
                $result = serendipity_db_query($sql, true, 'assoc', true);
                break;
            case 'DLM_COUNT':
                // count mysql_num_rows :: result is a single array select (TRUE)
                $sql = "SELECT COUNT(*) AS num FROM {$serendipity['dbPrefix']}dma_downloadmanager_files WHERE $whe";
                $result = serendipity_db_query($sql, true, 'assoc', false);
                break;
            case 'DLM_SELECT':
                // mysql_fetch_array :: result is a single array select (TRUE)
                $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_downloadmanager_files WHERE $whe";
                $result = serendipity_db_query($sql, true, 'assoc', true);
                break;
            case 'DLM_SELECT_ARRAY':
                // mysql_fetch_array :: result is a multiple array select (FALSE)
                $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_downloadmanager_files WHERE $whe";
                $result = serendipity_db_query($sql, false, 'assoc', true);
                break;
        }
      
        return $result;
       
    }

    /**
     * create plugins global array 
     * @access private
     */
    function pluginglobs() { 
        global $serendipity;

        $this->globs = array(
            'dateformat'    => ((!$dateformat || strlen($dateformat) < 1) ? 'Y/m/d, h:ia' : $this->get_config('dateformat')),
            'ftppath'       => (!$this->get_config('absincomingpath') 
                                        ? $serendipity['serendipityPath'] . 'archives/.dlm/ftpin'
                                        : $this->get_config('absincomingpath')),
            'dlmpath'       => (!$this->get_config('absdownloadspath') 
                                        ? $serendipity['serendipityPath'] . 'archives/.dlm/files'
                                        : $this->get_config('absdownloadspath')),
            'attention'     => '<img class="dlm_backend_attention" src="' . $serendipity['serendipityHTTPPath'] . 'templates/default/admin/img/admin_msg_note.png" alt="" />'
        );
    }

    function getRelPath() {
        global $serendipity;
        $c_path = dirname(__FILE__);
        $b_path = $serendipity['serendipityPath'];
        if ($b_path[(strlen($b_path)-1)] == "/")
            $b_path = substr($b_path, 0, strlen($b_path)-1);
        $r_path = ".".str_replace($b_path, "", $c_path);
        return $r_path;
    }


    function ERRMSG($msg, $type='error') {
        global $serendipity;
        
        if($type == 'error') { 
            // assign files of categeory to smarty
            $serendipity['smarty']->assign('dlmerr', array('thiserror' => true, 'errormsg' => $msg));
        } elseif( $type == 'status') {
            // assign files of categeory to smarty
            $serendipity['smarty']->assign('dlmerr', array('thiserror' => true, 'statusmsg' => $msg));
        }
    }

    
    /**
     * Fetch all Categories in Frontend and Backend inclusive root level
     * @param  Boolean  BackEndCall (default false)
     * @return array
     **/
    function GetAllCats($bec=false) {
        global $serendipity;
        $sql = "
            SELECT  node1.node_id AS node_id,
                    node1.root_id AS root_id,
                    node1.payload AS payload,
                    node1.lft AS lft,
                    node1.rgt AS rgt,
                    node1.hidden AS hidden,
                    round((node1.rgt-node1.lft-1)/2,0) AS subcats,
                    ((min(node2.rgt)-node1.rgt-(node1.lft>1))/2) > 0 AS lower,
                    (( (node1.lft-max(node2.lft)>1) )) AS upper,
                    COUNT(*) AS level
               FROM {$serendipity['dbPrefix']}dma_downloadmanager_categories AS node1,
                    {$serendipity['dbPrefix']}dma_downloadmanager_categories AS node2
              WHERE node1.lft BETWEEN node2.lft AND node2.rgt
                AND (node2.root_id = node1.root_id)
                AND (node2.node_id != node1.node_id OR node1.lft = 1)
                AND (node2.root_id = 1)";
        $sql .= ($bec === false) ? ((serendipity_db_bool($this->get_config('showhidden_registered')) && serendipity_userLoggedIn()) ? '' : " AND (node1.hidden != 1) AND (node2.hidden != 1) ") : '';
        $sql .= " GROUP BY node1.lft, node1.rgt, node1.node_id, node1.root_id, node1.payload";

        $cats = serendipity_db_query($sql, false, 'assoc', true);
        
        if (!is_array($cats)) {
            $cats = array();
        }
        
        return $cats;
    }



    function GetSubCats($node_id, $user=0) {
        global $serendipity;

        $node_id = intval($node_id);

        $sql = "SELECT     node1.node_id AS node_id,
                        node1.payload AS payload,
                        node1.lft AS lft,
                        node1.rgt AS rgt,
                        node1.hidden AS hidden,
                        round((node1.rgt-node1.lft-1)/2,0) AS subcats,
                        COUNT(*) AS level
                   FROM {$serendipity['dbPrefix']}dma_downloadmanager_categories AS node1,
                           {$serendipity['dbPrefix']}dma_downloadmanager_categories AS node2,
                           {$serendipity['dbPrefix']}dma_downloadmanager_categories AS node3
                  WHERE node1.lft BETWEEN node2.lft AND node2.rgt
                    AND node1.lft BETWEEN node3.lft AND node3.rgt
                    AND node2.root_id = 1
                    AND node3.node_id = $node_id";
        if ($user == 1) {
            if (serendipity_db_bool($this->get_config('showhidden_registered')) && serendipity_userLoggedIn())
                $sql .= "";
            else
                $sql .= " AND (node1.hidden != 1) ";
        }
        $sql .= " GROUP BY node1.lft, node1.rgt, node1.node_id, node1.root_id, node1.payload";

        $cats = serendipity_db_query($sql);
        return $cats;
    }


    function calcFilesize($filesize) {
       $array = array(
           'YB' => 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024,
           'ZB' => 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024,
           'EB' => 1024 * 1024 * 1024 * 1024 * 1024 * 1024,
           'PB' => 1024 * 1024 * 1024 * 1024 * 1024,
           'TB' => 1024 * 1024 * 1024 * 1024,
           'GB' => 1024 * 1024 * 1024,
           'MB' => 1024 * 1024,
           'KB' => 1024,
       );
       if($filesize <= 1024) {
           $filesize = $filesize . ' Bytes';
       }
       foreach($array AS $name => $size) {
           if($filesize > $size || $filesize == $size) {
               $filesize = round((round($filesize / $size * 100) / 100), 2) . ' ' . $name;
           }
       }
       return $filesize;
    }




    function getMime($filename) {
        static $mimetypes = array(
             "ez" => "application/andrew-inset",
             "hqx" => "application/mac-binhex40",
             "cpt" => "application/mac-compactpro",
             "doc" => "application/msword",
             "bin" => "application/octet-stream",
             "dms" => "application/octet-stream",
             "lha" => "application/octet-stream",
             "lzh" => "application/octet-stream",
             "exe" => "application/octet-stream",
             "class" => "application/octet-stream",
             "so" => "application/octet-stream",
             "dll" => "application/octet-stream",
             "oda" => "application/oda",
             "pdf" => "application/pdf",
             "ai" => "application/postscript",
             "eps" => "application/postscript",
             "ps" => "application/postscript",
             "smi" => "application/smil",
             "smil" => "application/smil",
             "wbxml" => "application/vnd.wap.wbxml",
             "wmlc" => "application/vnd.wap.wmlc",
             "wmlsc" => "application/vnd.wap.wmlscriptc",
             "bcpio" => "application/x-bcpio",
             "vcd" => "application/x-cdlink",
             "pgn" => "application/x-chess-pgn",
             "cpio" => "application/x-cpio",
             "csh" => "application/x-csh",
             "dcr" => "application/x-director",
             "dir" => "application/x-director",
             "dxr" => "application/x-director",
             "dvi" => "application/x-dvi",
             "spl" => "application/x-futuresplash",
             "gtar" => "application/x-gtar",
             "hdf" => "application/x-hdf",
             "js" => "application/x-javascript",
             "skp" => "application/x-koan",
             "skd" => "application/x-koan",
             "skt" => "application/x-koan",
             "skm" => "application/x-koan",
             "latex" => "application/x-latex",
             "nc" => "application/x-netcdf",
             "cdf" => "application/x-netcdf",
             "sh" => "application/x-sh",
             "shar" => "application/x-shar",
             "swf" => "application/x-shockwave-flash",
             "sit" => "application/x-stuffit",
             "sv4cpio" => "application/x-sv4cpio",
             "sv4crc" => "application/x-sv4crc",
             "tar" => "application/x-tar",
             "tcl" => "application/x-tcl",
             "tex" => "application/x-tex",
             "texinfo" => "application/x-texinfo",
             "texi" => "application/x-texinfo",
             "t" => "application/x-troff",
             "tr" => "application/x-troff",
             "roff" => "application/x-troff",
             "man" => "application/x-troff-man",
             "me" => "application/x-troff-me",
             "ms" => "application/x-troff-ms",
             "ustar" => "application/x-ustar",
             "src" => "application/x-wais-source",
             "xhtml" => "application/xhtml+xml",
             "xht" => "application/xhtml+xml",
             "zip" => "application/zip",
             "au" => "audio/basic",
             "snd" => "audio/basic",
             "mid" => "audio/midi",
             "midi" => "audio/midi",
             "kar" => "audio/midi",
             "mpga" => "audio/mpeg",
             "mp2" => "audio/mpeg",
             "mp3" => "audio/mpeg",
             "aif" => "audio/x-aiff",
             "aiff" => "audio/x-aiff",
             "aifc" => "audio/x-aiff",
             "m3u" => "audio/x-mpegurl",
             "ram" => "audio/x-pn-realaudio",
             "rm" => "audio/x-pn-realaudio",
             "rpm" => "audio/x-pn-realaudio-plugin",
             "ra" => "audio/x-realaudio",
             "wav" => "audio/x-wav",
             "pdb" => "chemical/x-pdb",
             "xyz" => "chemical/x-xyz",
             "bmp" => "image/bmp",
             "gif" => "image/gif",
             "ief" => "image/ief",
             "jpeg" => "image/jpeg",
             "jpg" => "image/jpeg",
             "jpe" => "image/jpeg",
             "png" => "image/png",
             "tiff" => "image/tiff",
             "tif" => "image/tif",
             "djvu" => "image/vnd.djvu",
             "djv" => "image/vnd.djvu",
             "wbmp" => "image/vnd.wap.wbmp",
             "ras" => "image/x-cmu-raster",
             "pnm" => "image/x-portable-anymap",
             "pbm" => "image/x-portable-bitmap",
             "pgm" => "image/x-portable-graymap",
             "ppm" => "image/x-portable-pixmap",
             "prc" => "application/x-pilot",
             "pdb" => " application/x-pilot-pdb",
             "rgb" => "image/x-rgb",
             "xbm" => "image/x-xbitmap",
             "xpm" => "image/x-xpixmap",
             "xwd" => "image/x-windowdump",
             "igs" => "model/iges",
             "iges" => "model/iges",
             "msh" => "model/mesh",
             "mesh" => "model/mesh",
             "silo" => "model/mesh",
             "wrl" => "model/vrml",
             "vrml" => "model/vrml",
             "css" => "text/css",
             "html" => "text/html",
             "htm" => "text/html",
             "asc" => "text/plain",
             "txt" => "text/plain",
             "rtx" => "text/richtext",
             "rtf" => "text/rtf",
             "sgml" => "text/sgml",
             "sgm" => "text/sgml",
             "tsv" => "text/tab-seperated-values",
             "wml" => "text/vnd.wap.wml",
             "wmls" => "text/vnd.wap.wmlscript",
             "etx" => "text/x-setext",
             "xml" => "text/xml",
             "xsl" => "text/xml",
             "mpeg" => "video/mpeg",
             "mpg" => "video/mpeg",
             "mpe" => "video/mpeg",
             "qt" => "video/quicktime",
             "mov" => "video/quicktime",
             "mxu" => "video/vnd.mpegurl",
             "avi" => "video/x-msvideo",
             "wmv" => "video/x-msvideo",
             "movie" => "video/x-sgi-movie",
             "ice" => "x-conference-xcooltalk",
             "ics" => "text/calendar"
        );

        $MIMETYPE = array();

        $filename = basename($filename);
        $fileparts = explode(".", $filename);
        $EXTENSION = $fileparts[(count($fileparts) - 1)];

        if (file_exists(dirname(__FILE__) . "/img/dlicons/".$EXTENSION.".png"))
            $MIMETYPE['ICON'] = $this->get_config('httppath')."img/dlicons/".$EXTENSION.".png";
        else
            $MIMETYPE['ICON'] = $this->get_config('httppath')."img/dlicons/unknown_small.png";

        if (!empty($mimetypes[$EXTENSION]) && trim($mimetypes[$EXTENSION]) != "")
            $MIMETYPE['TYPE'] = $mimetypes[$EXTENSION];
        else
            $MIMETYPE['TYPE'] = "application/octet-stream";

        return $MIMETYPE;
    }





    function showShoutPage() {
        global $serendipity;

        if (!headers_sent())
            header('HTTP/1.0 200');
            header('Status: 200 OK');

        if (!is_object($serendipity['smarty']))
            serendipity_smarty_init();

        if(!serendipity_db_bool($this->get_config('unhideroot'))) { 
            // with dlm version 0.25, we set payload.root to be unhidden.0 to get the expected results in frontend
            $result = $this->dlm_sql_db('DLM_UPDATE', "hidden = '0' WHERE payload = 'root' AND node_id = '1'");
            if($result) $this->set_config('unhideroot', true);
        }

        // assign to smarty and all 3 frontend pages 
        $serendipity['smarty']->assign(
            array(
                'httppath'          => $this->get_config('httppath'),
                'pagetitle'         => $this->get_config('pagetitle'),
                'headline'          => $this->get_config('headline'),
                'dlm_intro'         => $this->get_config('intro'),
                'dlm_is_registered' => serendipity_db_bool($this->get_config('registered_only'))
            )    
        );

        if (isset($_GET['file']) && intval($_GET['file']) >= 1) {

            // FRONTEND PAGE 3: FILEDETAILS SINGLE FILE
            if (empty($filename) || $filename == 'none.html') {
                $filename = 'dlmanager.filedetails.tpl';
            }
            $id    = intval($_GET['file']);
            $catid = intval($_GET['thiscat']);

            $sqlfe = (serendipity_db_bool($this->get_config('showhidden_registered')) && serendipity_userLoggedIn()) ? '' : " AND hidden != 1 ";

            $cat = $this->dlm_sql_db('DLM_SUBCATS', "node_id = $catid" . $sqlfe);
            
            if(is_array($cat) && !empty($cat)) {
                
                $serendipity['smarty']->assign('showfile', true);

                // get subcats of cat
                $ret1 = $this->dlm_sql_db('DLM_COUNT', "catid = $catid");
                
                $serendipity['smarty']->assign(
                    array(
                        'catname'            =>    $cat['payload'],
                        'pageurl'            =>    $this->get_config('pageurl'),
                        'catid'              =>    $catid,
                        'num_subcats'        =>    intval($cat['subcats']),
                        'num_files'          =>    intval($ret1['num']),
                        'basepage'           =>    $serendipity['serendipityHTTPPath'] . $serendipity['indexFile']
                    )
                );

                // get single file content as a simple linear array, smarty tpl needs no loop, but has no proper $var|print_r output
                // else take DLM_SELECT_ARRAY and add $file[0] here - remember smarty switches arrays back -1 level in templates!
                $file = $this->dlm_sql_db('DLM_SELECT', "id = $id");
                $mime = $this->getMime($file['realfilename']);
                
                if (is_array($file) && !empty($file)) {

                    $temp_array = array('comment' => stripslashes($file['description']));
                    serendipity_plugin_api::hook_event('frontend_display', $temp_array);

                    // push the file array to hold everything needed
                    $file['id']             = ''; // obfuscating - do not tell tpl to much
                    $file['systemfilename'] = ''; // obfuscating - do not tell tpl to much
                    $file['iconfile']       = $mime['ICON'];
                    $file['icontype']       = $mime['TYPE'];
                    $file['iconwidth']      = $this->get_config('iconwidth');
                    $file['iconheight']     = $this->get_config('iconheight');
                    $file['filesize_field'] = $this->get_config('filesize_field');
                    $file['filedate_field'] = $this->get_config('filedate_field');
                    $file['filename']       = stripslashes($file['realfilename']);
                    $file['dlcount']        = intval($file['dlcount']);
                    $file['filesize']       = $this->calcFilesize($file['filesize']);
                    $file['filedate']       = date($this->globs['dateformat'], $file['timestamp']);
                    $file['description']    = $temp_array['comment'];
                    $file['dlurl']          = $serendipity['baseURL'] . ($serendipity['rewrite'] == "none" ? $serendipity['indexFile'] . "?/" : "") . "plugin/dlfile_".$id;
                    
                    $serendipity['smarty']->assign('thisfile', $file);
                }
                unset($cat);
                unset($file);
            }
        }
        elseif (isset($_GET['thiscat']) && intval($_GET['thiscat']) > 0) {

            // FRONTEND PAGE 2: FILELIST OF CATEGORY
            if (empty($filename) || $filename == 'none.html')
                $filename = 'dlmanager.filelist.tpl';
            
            $id    = intval($_GET['thiscat']);
            $level = intval($_GET['level']);
            
            $sqlfe = (serendipity_db_bool($this->get_config('showhidden_registered')) && serendipity_userLoggedIn()) ? '' : " AND hidden != 1 ";

            $cat = $this->dlm_sql_db('DLM_SUBCATS', "node_id = $id" . $sqlfe);

            if(is_array($cat)) {

                $ret1 = $this->dlm_sql_db('DLM_COUNT', "catid = $id");
                
                $num_dls = intval($ret1['num']);

                $serendipity['smarty']->assign(
                    array(
                        'catname'       =>    $cat['payload'],
                        'numsubcats'    =>    $cat['subcats'],
                        'pageurl'       =>    $this->get_config('pageurl'),
                        'numdls'        =>    intval($num_dls),
                        'basepage'      =>    $serendipity['serendipityHTTPPath'] . $serendipity['indexFile']
                    )
                );

                $files = $this->dlm_sql_db('DLM_SELECT_ARRAY', "catid = $id ORDER BY timestamp DESC");

                $subcats = $this->GetSubCats($id, 1);
                if (is_array($subcats) && count($subcats) >= 2) {

                    $serendipity['smarty']->assign('has_subcats', true);
                    foreach($subcats as $subcat) {
                        if ($level == 1) { $sublvl = 2; } else { $sublvl = 2; }
                        if ($subcat['level'] == ($level + $sublvl)) {

                            $ret = $this->dlm_sql_db('DLM_COUNT', "catid = ".$subcat['node_id']);
                            
                            $num_dls = intval($ret['num']);
                            $nodetb = array('f' => $this->get_config('httppath').'img/f.gif', 
                                            'e' => $this->get_config('httppath').'img/e.gif', 
                                            'path' => $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . "?serendipity[subpage]=".$this->get_config('pageurl')."&amp;level=".($subcat['level']-1)."&amp;thiscat=".$subcat['node_id']
                                            );
                            // construct the smarty template array
                            $sctable[] = array('subcat' => $subcat, 'node' => $nodetb, 'num' => $num_dls);
                        }
                    }
                    // assign subcategeories to smarty
                    $serendipity['smarty']->assign('sclist', $sctable);
                }

                if (is_array($files)) {

                    if (serendipity_db_bool($this->get_config('showfilename')))
                        $serendipity['smarty']->assign('filename_field', $this->get_config('filename_field'));

                    if (serendipity_db_bool($this->get_config('showdownloads')))
                        $serendipity['smarty']->assign('dls_field', $this->get_config('dls_field'));

                    if (serendipity_db_bool($this->get_config('showfilesize')))
                        $serendipity['smarty']->assign('filesize_field', $this->get_config('filesize_field'));

                    if (serendipity_db_bool($this->get_config('showdate')))
                        $serendipity['smarty']->assign('filedate_field', $this->get_config('filedate_field'));
                        
                    $nis = array();
                    $colspan    = 0;
                    if (serendipity_db_bool($this->get_config('showfilename'))) {
                        ++$colspan;
                        $nis['showfilename'] = true;
                    }
                    if (serendipity_db_bool($this->get_config('showdownloads'))) {
                        ++$colspan;
                        $nis['showdownloads'] = true;
                    }
                    if (serendipity_db_bool($this->get_config('showfilesize'))) {
                        ++$colspan;
                        $nis['showfilesize'] = true;
                    }
                    if (serendipity_db_bool($this->get_config('showdate'))) {
                        ++$colspan;
                        $nis['showdate'] = true;
                    }
                    if (serendipity_db_bool($this->get_config('showdesc_inlist'))) {
                        $nis['showdesc_inlist'] = true;
                    }
                    foreach($files as $file) { 
                    
                        $infourl = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . "?serendipity[subpage]=".$this->get_config('pageurl')."&amp;thiscat=".$id."&amp;file=".$file['id'];
                        $dlurl   = $serendipity['baseURL'] . ($serendipity['rewrite'] == "none" ? $serendipity['indexFile'] . "?/" : "") . "plugin/dlfile_" . $file['id'];
                        $mime    = $this->getMime($file['realfilename']);
                        
                        $fileinfo = array('file_desc'  => str_replace(array("\r\n","\n","\r"),array("<br />","<br />","<br />"), $file['description']),
                                          'filedate'   => date($this->globs['dateformat'], $file['timestamp']),
                                          'filesize'   => $this->calcFilesize($file['filesize']),
                                          'iconfile'   => $mime['ICON'],
                                          'iconwidth'  => $this->get_config('iconwidth'),
                                          'iconheight' => $this->get_config('iconheight'),
                                          'icontype'   => $mime['TYPE'],
                                          'iconurl'    => ($this->get_config('directdl_inlist','no') == 'icon' || $this->get_config('directdl_inlist','no') == 'both') ? $dlurl : $infourl,
                                          'nameurl'    => ($this->get_config('directdl_inlist','no') == 'name' || $this->get_config('directdl_inlist','no') == 'both') ? $dlurl : $infourl
                                        );
                        // construct the smarty template array
                        $fltable[] = array('file' => $file, 'info' => $fileinfo, 'is' => $nis, 'col' => $colspan);
                    }
                    // assign files of categeory to smarty
                    $serendipity['smarty']->assign('fltable', $fltable);
                }

            }
            unset($cat);
            unset($files);

        } else {

            // FRONTEND PAGE 1: SUBCATLIST OF ROOT CATEGORY
            if (empty($filename) || $filename == 'none.html')
                $filename = 'dlmanager.catlist.tpl';
                
            // build the frontend category array list (in backend = false and as <select> call list = false)
            $catlist = array();
            $catlist = $this->buildCategoriesList();
                
            if (is_array($catlist) && sizeof($catlist) >= 1) {

                $serendipity['smarty']->assign(
                            array(
                                'categories_found' => true,
                                'catlist'          => $catlist
                            )
                );
                
            } else {
                $serendipity['smarty']->assign('categories_found', false);
            }
            unset($catlist);
            unset($cats);
        }

        /* get the frontend dlm template file */
        echo $this->parseTemplate($filename);
    }


    function genCryptString($pwdLen=32, $usables=PWD_ALLOW_ALL) {
        $pwdSource = "";
        $STRING = "";
        if ( $usables & ( 1 << 0 ))     $pwdSource .= "1234567890";
        if ( $usables & ( 1 << 1 ))     $pwdSource .= "abcdefghijklmnopqrstuvwxyz";
        if ( $usables & ( 1 << 2 ))     $pwdSource .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        srand ((double) microtime() * 1000000);
        while ( $pwdLen ) {
            srand ((double) microtime() * 1000000);
            $STRING .= substr( $pwdSource, rand( 0, strlen( $pwdSource )), 1);
            $pwdLen--;
        }
        return $STRING;
    }


    function addCat($node_id, $catname) {
        global $serendipity;
        $sql = "SELECT root_id, lft, rgt FROM {$serendipity['dbPrefix']}dma_downloadmanager_categories WHERE node_id = $node_id";
        $node = serendipity_db_query($sql);
        $root_id     = $node[0]['root_id'];
        $lft         = $node[0]['lft'];
        $rgt         = $node[0]['rgt'];

        @serendipity_db_query("LOCK TABLES {$serendipity['dbPrefix']}dma_downloadmanager_categories WRITE");
        serendipity_db_query("UPDATE {$serendipity['dbPrefix']}dma_downloadmanager_categories
                                   SET lft      =  lft + 2
                                 WHERE root_id  =  $root_id
                                   AND lft      >  $rgt
                                   AND rgt      >= $rgt");
        serendipity_db_query("UPDATE {$serendipity['dbPrefix']}dma_downloadmanager_categories
                                   SET rgt      =  rgt + 2
                                 WHERE root_id  =  $root_id
                                   AND rgt      >= $rgt");
        serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}dma_downloadmanager_categories
                                        ( root_id, payload, lft, rgt )
                                VALUES
                                        ( $root_id, '".serendipity_db_escape_string($catname)."', $rgt, $rgt + 1 )");
        @serendipity_db_query("UNLOCK TABLES");
        return true;
    }


    /** build the full categories list array
     * @param   boolean catlist call backend (default: false)
     * @param   boolean <select> call array  (default: false)
     * @return  array 
     **/
    function buildCategoriesList($admin=false, $seca=false) { 
        
        $cats = array();
        $cats = $this->GetAllCats($admin);
        
        foreach($cats as $cat) {
            if (($cat['level'] == 1)) {
                $parent = array();
            }

            if ( ($cat['level'] >= $last['level']))
                $parent[$last['level']] = $last;

            if($seca === false) { 
                // the frontend and backend category call
                if ($cat['payload'] != 'root') { 
                    $clt[] = $this->buildCat($cat, $parent);
                }
            } else {
                // the backend <select> call
                $clt[] = $this->buildCat($cat, $parent, true);
            }
            $last = $cat;
        }
        
        unset($last);
        unset($cat);
        unset($parent);
        unset($cats);
       
        return $clt;
    }
    
    
    
    /** build the category array
     * @param   array   A referenced array of this category
     * @param   array   A referenced array of the interating last cat array
     * @param   boolean is backend <select> call (default: false)
     * @return  array 
     **/
    function buildCat($cat, $parent, $seca=false) { 
        global $serendipity;
        
        if($seca === false) { 
            $ret  = $this->dlm_sql_db('DLM_COUNT', "catid = ".$cat['node_id']);
            $fnum = intval($ret['num']);
        } else $fnum = NULL; // backend <select> has no need of filenum in cat
        
        $tl = array(); // build tab list
        $cl = array(); // build cat list

        // build the category level (image/select) array
        for ($i=2; $i<$cat['level']; ++$i) { 
            if ($parent[$i]['lower']) { 
                $tl[] = 'l';
            } else { 
                $tl[] = 'e';
            }
        }
        if ( ($cat['level'] > 1) ) { 
            if ($cat['lower']) { 
                $tl[] = 'b';
            } else { 
                $tl[] = 'nb';
            }
        }
                
        $path = ($_GET['serendipity']['adminAction'] == 'downloadmanager') 
              ? '' 
              : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . "?serendipity[subpage]=".$this->get_config('pageurl')."&amp;level=".$cat['level']."&amp;thiscat=".$cat['node_id'];

        // construct the smarty template array (no need of catname, while sending full cat array, used here, as long as defined in other function)
        $cl = array( 'cat'     => $cat, 
                     'catname' => $cat['payload'], 
                     'imgname' => $tl, 
                     'filenum' => $fnum, 
                     'path'    => $path
                   );
                
        return $cl;
    }
    
    
    
    function delCat($node_id) {
        global $serendipity;

        $id = intval($node_id);
        $sql = "        SELECT
                                node1.root_id,
                                node1.lft,
                                node1.rgt,
                                round((node1.rgt-node1.lft-1)/2,0) AS subcats
                        FROM     {$serendipity['dbPrefix']}dma_downloadmanager_categories AS node1
                        WHERE     node_id = $id";
        $node = serendipity_db_query($sql);
        if(is_array($node)) {

            if($node[0]['subcats']>=1) {
                $this->ERRMSG(PLUGIN_DOWNLOADMANAGER_DELETE_NOT_ALLOWED);
            } else {
                $files_deleted = 0;
                $sql = "SELECT systemfilename FROM {$serendipity['dbPrefix']}dma_downloadmanager_files WHERE catid = ".$id;
                $files = serendipity_db_query($sql);
                
                if (is_array($files)) {
                    foreach($files as $file) {

                        if (file_exists($this->globs['dlmpath']."/".$file['systemfilename']) && !@unlink($this->globs['dlmpath']."/".$file['systemfilename'])) {
                            $this->ERRMSG(PLUGIN_DOWNLOADMANAGER_DELETE_IN_DOWNLOADDIR_NOT_ALLOWED);
                            $files_deleted = 0;
                        } else {
                            $files_deleted = 1;
                        }
                    }
                } else { $files_deleted = 1; }
                
                if ($files_deleted == 1) {
                    @serendipity_db_query("LOCK TABLES {$serendipity['dbPrefix']}dma_downloadmanager_categories WRITE");
                    serendipity_db_query("UPDATE     {$serendipity['dbPrefix']}dma_downloadmanager_categories
                                            SET      lft=lft-2
                                            WHERE    lft > ".$node[0]['lft']."
                                            AND      root_id = ".$node[0]['root_id']);
                    serendipity_db_query("UPDATE     {$serendipity['dbPrefix']}dma_downloadmanager_categories
                                            SET      rgt=rgt-2
                                            WHERE    rgt > ".$node[0]['rgt']."
                                            AND      root_id = ".$node[0]['root_id']);
                    serendipity_db_query("DELETE
                                            FROM      {$serendipity['dbPrefix']}dma_downloadmanager_categories
                                            WHERE     node_id = ".$id);
                    @serendipity_db_query("UNLOCK TABLES");
                }
            }
        }
        return true;
    }


    function hideCat($catid, $hide) {
        global $serendipity;

        $sql = "        SELECT
                                node1.root_id,
                                node1.lft,
                                node1.rgt,
                                round((node1.rgt-node1.lft-1)/2,0) AS subcats
                        FROM     {$serendipity['dbPrefix']}dma_downloadmanager_categories AS node1
                        WHERE     node_id = $catid";
        $node = serendipity_db_query($sql);
        if(is_array($node)) {
            @serendipity_db_query("LOCK TABLES {$serendipity['dbPrefix']}dma_downloadmanager_categories WRITE");
            serendipity_db_query("UPDATE     {$serendipity['dbPrefix']}dma_downloadmanager_categories
                                    SET      hidden = ".intval($hide)."
                                    WHERE    node_id = ".$catid);
            serendipity_db_query("UPDATE     {$serendipity['dbPrefix']}dma_downloadmanager_categories
                                    SET      hidden = ".intval($hide)."
                                    WHERE    lft BETWEEN ".$node[0]['lft']." AND ".$node[0]['rgt']);
            @serendipity_db_query("UNLOCK TABLES");
        }
    }


    function renameCats($catnames) {
        global $serendipity;
        
        if (!is_array($catnames)) {
            return false;
        }
        @serendipity_db_query("LOCK TABLES {$serendipity['dbPrefix']}dma_downloadmanager_categories WRITE");
        foreach ($catnames AS $id => $name) {
            serendipity_db_query("UPDATE     {$serendipity['dbPrefix']}dma_downloadmanager_categories
                                    SET      payload = '".serendipity_db_escape_string($name)."'
                                    WHERE    node_id = ".intval($id));
        }
        @serendipity_db_query("UNLOCK TABLES");
    }


    function delFile($file_id) {
        global $serendipity;

        $id = intval($file_id);
        $ret = serendipity_db_query("SELECT systemfilename FROM {$serendipity['dbPrefix']}dma_downloadmanager_files WHERE id = ".$id);
        if (file_exists($this->globs['dlmpath']."/".$ret[0]['systemfilename']) && !@unlink($this->globs['dlmpath']."/".$ret[0]['systemfilename'])) {
            $this->ERRMSG(PLUGIN_DOWNLOADMANAGER_DELETE_IN_DOWNLOADDIR_NOT_ALLOWED);
        } else {
            serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}dma_downloadmanager_files WHERE id = $id");
        }
        return true;
    }


    function delIncomingFile($file) {
        if (file_exists($this->globs['ftppath']."/".$file) && !@unlink($this->globs['ftppath']."/".$file)) {
            $this->ERRMSG(PLUGIN_DOWNLOADMANAGER_DELETE_IN_INCOMING_NOT_ALLOWED);
        } else { 
            return true;
        }
    }


    function importFile($file, $catid) {
        global $serendipity;

        $catid = intval($catid);
        $file = basename($file);
        
        // Check if file is already existing in category:
        $file_update = false;
        if ($this->get_config('add_existing_file','insert')=='update') {
            $sql = "SELECT systemfilename FROM  {$serendipity['dbPrefix']}dma_downloadmanager_files WHERE realfilename = '".serendipity_db_escape_string($file)."' AND catid = '".$catid."' ORDER BY timestamp DESC";   
            $dbfilelist = serendipity_db_query($sql);
            $file_update = is_array($dbfilelist); 
        }
        
        if ($file_update) {
            $sysfilename = $dbfilelist[0]['systemfilename'];
        }
        else {
            $sysfilename = $this->genCryptString();
        }

        if (@copy($this->globs['ftppath']."/".$file, $this->globs['dlmpath']."/".$sysfilename)) {

            $timestamp = filemtime($this->globs['dlmpath']."/".$sysfilename);
            $filesize  = filesize($this->globs['dlmpath']."/".$sysfilename);
            
            if ($file_update) {
                serendipity_db_query("UPDATE {$serendipity['dbPrefix']}dma_downloadmanager_files
                                       SET timestamp = '$timestamp',
                                           filesize = '$filesize'
                                       WHERE 
                                            catid = '$catid' AND
                                            realfilename = '".serendipity_db_escape_string($file)."'");
                
            } else {
                serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}dma_downloadmanager_files
                                        (
                                            catid,
                                            timestamp,
                                            systemfilename,
                                            realfilename,
                                            filesize
                                ) VALUES (
                                            '".$catid."',
                                            '".$timestamp."',
                                            '".$sysfilename."',
                                            '".serendipity_db_escape_string($file)."',
                                            '".$filesize."'
                                )");
            }
            @chmod($this->globs['dlmpath']."/".$sysfilename, 0666);
            if (file_exists($this->globs['ftppath']."/".$file) && !@unlink($this->globs['ftppath']."/".$file)) {
                $this->ERRMSG(PLUGIN_DOWNLOADMANAGER_DELETE_IN_INCOMING_NOT_ALLOWED);
            }
        } else {
            $this->ERRMSG(PLUGIN_DOWNLOADMANAGER_COPY_NOT_ALLOWED);
        }
    }


    function importMLFile($file, $path, $catid) {
        global $serendipity;
        
        $catid = intval($catid);
        $sysfilename = $this->genCryptString();

        if (isset($path) && trim($path) != "" && !preg_match("@\.\./@", $path)) {
            $extrapath = trim($path);
        } else {
            $extrapath = "";
        }

        $uploadPath = $serendipity['serendipityPath'].$serendipity['uploadPath'];
        if ($uploadPath[(strlen($uploadPath)-1)] == "/")
            $uploadPath = substr($uploadPath, 0, (strlen($uploadPath)-1));
        $uploadPath .= $extrapath;

        if (@copy($uploadPath."/".$file, $this->globs['dlmpath']."/".$sysfilename)) {

            $timestamp = filemtime($this->globs['dlmpath']."/".$sysfilename);
            $filesize  = filesize($this->globs['dlmpath']."/".$sysfilename);
            serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}dma_downloadmanager_files
                                        (
                                            catid,
                                            timestamp,
                                            systemfilename,
                                            realfilename,
                                            filesize
                                ) VALUES (
                                            '".$catid."',
                                            '".$timestamp."',
                                            '".$sysfilename."',
                                            '".serendipity_db_escape_string($file)."',
                                            '".$filesize."'
                                )");
            @chmod($this->globs['dlmpath']."/".$sysfilename, 0666);
        } else {
            $this->ERRMSG(PLUGIN_DOWNLOADMANAGER_COPY_NOT_ALLOWED);
        }
    }


    function editFile($fileid, $oldcatid, $newcatid, $rename, $description) {
        global $serendipity;

        serendipity_db_query("UPDATE {$serendipity['dbPrefix']}dma_downloadmanager_files SET
                                        catid='".$newcatid."',
                                        realfilename='".serendipity_db_escape_string($rename)."',
                                        description='".serendipity_db_escape_string($description)."'
                                WHERE   id = ".$fileid);

        $this->ERRMSG(PLUGIN_DOWNLOADMANAGER_FILE_EDITED, 'status');
        $_GET['thiscat'] = $newcatid;
        $_GET['editfile'] = $fileid;
    }

    function uploadFiles() {
        global $serendipity;

        $upload_max_filesize = ini_get('upload_max_filesize');
        $upload_max_filesize = preg_replace('/M/', '000000', $upload_max_filesize);
        $MAX_FILE_SIZE       = intval($upload_max_filesize);

        $SUCCESS   = 0;
        $countfile = 0;
        if (isset($serendipity['POST']['uploaded']) && intval($serendipity['POST']['uploaded']) >= 1) {
            $catid = intval($serendipity['POST']['catid']);
            for ($ulnum=0;$ulnum<count($_FILES['file']['tmp_name']);++$ulnum) {
                if (trim($_FILES['file']['tmp_name'][$ulnum]) != "none" AND $_FILES['file']['size'][$ulnum] >= 5 AND is_uploaded_file($_FILES['file']['tmp_name'][$ulnum])) {
                    $FILESIZE = $_FILES['file']['size'][$ulnum];
                    if ($FILESIZE > ($MAX_FILE_SIZE)) {
                        $TOOBIG[] = $_FILES['file']['name'][$ulnum];
                    } else {
                        $fname = serendipity_db_escape_string($_FILES['file']['name'][$ulnum]);

                        // Check, if file already exists in database
                        $file_update = false;
                        if ($this->get_config('add_existing_file','insert')=='update') {
                            $sql = "SELECT systemfilename FROM  {$serendipity['dbPrefix']}dma_downloadmanager_files WHERE realfilename = '".$fname."' AND catid = '".$catid."' ORDER BY timestamp DESC";   
                            $dbfilelist = serendipity_db_query($sql);
                            $file_update = is_array($dbfilelist); 
                        }

                        if ($file_update) {
                            $SERVERFILENAME = $dbfilelist[0]['systemfilename'];
                        } else { 
                            $SERVERFILENAME = $this->genCryptString();
                        }
                    
                        if (!move_uploaded_file($_FILES['file']['tmp_name'][$ulnum], $this->globs['dlmpath']."/".$SERVERFILENAME)) {
                            $NOTCOPIED[] = $_FILES['file']['name'][$ulnum];
                        } else {
                            $fdesc = serendipity_db_escape_string($serendipity['POST']['desc'][$ulnum]);
                            if ($file_update) {
                                serendipity_db_query("UPDATE {$serendipity['dbPrefix']}dma_downloadmanager_files
                                                    SET timestamp = '".time()."',
                                                        filesize = '$FILESIZE' ".
                                                        (!empty($fdesc)? ",description='$fdesc'":'').
                                                    " WHERE 
                                                        catid = '$catid' AND
                                                        realfilename = '".$fname."'");
                            } else {
                                serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}dma_downloadmanager_files
                                                    (
                                                        catid,
                                                        timestamp,
                                                        systemfilename,
                                                        realfilename,
                                                        description,
                                                        filesize
                                            ) VALUES (
                                                        '".$catid."',
                                                        '".time()."',
                                                        '".$SERVERFILENAME."',
                                                        '".$fname."',
                                                        '".$fdesc."',
                                                        '".$FILESIZE."'
                                            )");
                            }
                            @chmod($this->globs['dlmpath']."/".$SERVERFILENAME, 0666);

                            $SUCCESS = 1;
                            ++$countfile;
                        }
                    }
                    @unlink($_FILES['file']['tmp_name'][$ulnum]);
                }
            }
        }
        $this->UPLOAD_SUCCESS   =& $SUCCESS;
        $this->UPLOAD_COUNT     =& $countfile;
        $this->UPLOAD_TOOBIG    =& $TOOBIG;
        $this->UPLOAD_NOTCOPIED =& $NOTCOPIED;

        $_GET['thiscat'] = intval($serendipity['POST']['catid']);
    }


    function ADMIN_showDownloads() {
        global $serendipity;
        
        // forbid entry if not admin
        if(serendipity_userLoggedIn() && $_SESSION['serendipityAuthedUser'] === true && $_SESSION['serendipityUserlevel'] == '255') {
        $ddiv = false;
        
        // return GET value of 0.24 upgrade hook
        if (isset($_GET['cpdone'])) { 
            if( intval($_GET['cpdone']) == 1) { 
                $this->ERRMSG($this->globs['attention'] . ' ' . PLUGIN_DOWNLOADMANAGER_ALLFILES_COPIED_NEWDIR);
            } 
            if( intval($_GET['cpdone']) == 0) { 
                $this->ERRMSG($this->globs['attention'] . ' ' . PLUGIN_DOWNLOADMANAGER_ALLFILES_COPY_NEWDIR_REMEMBER);
            }
        }

        if (!is_dir($this->globs['ftppath'])) {
            @mkdir($this->globs['ftppath'], 0777, true);
        }
        
        if (!is_dir($this->globs['dlmpath'])) {
            @mkdir($this->globs['dlmpath'], 0777, true);
        }

        if (!empty($serendipity['POST']['dlmanAction']) && $serendipity['POST']['childof'] >= 1) {
            $this->addCat(intval($serendipity['POST']['childof']), $serendipity['POST']['catname']);
        }
        elseif (!empty($serendipity['POST']['dlmanAction']) && $serendipity['POST']['edited'] >= 1) {
            $this->editFile(intval($serendipity['POST']['fileid']), intval($serendipity['POST']['catid']), intval($serendipity['POST']['moveto']), $serendipity['POST']['realfilename'], $serendipity['POST']['description']);
        }
        elseif (!empty($serendipity['POST']['dlmanAction']) && $serendipity['POST']['uploaded'] >= 1) {
            $this->uploadFiles();
        }

        if (!empty($serendipity['POST']['catnamAction'])) {
            $this->renameCats($_POST['catname']);
        }

        if (!empty($_GET['delcat']) && intval($_GET['delcat']) != 1) {
            $this->delCat(intval($_GET['delcat']));
        }

        if (!empty($_GET['hidecat']) && intval($_GET['catid']) >= 1) {
            $this->hideCat(intval($_GET['catid']), intval($_GET['hide']));
        }

        if (!empty($_GET['delfile']) && intval($_GET['delfile']) != 0) {
            $this->delFile(intval($_GET['delfile']));
        }

        if (!empty($_GET['delifile']) && trim($_GET['delifile']) != "") {
            $this->delIncomingFile($_GET['delifile']);
        }

        if (!empty($_GET['importfile']) && trim($_GET['importfile']) != "") {
            $this->importFile($_GET['importfile'], intval($_GET['thiscat']));
        }

        if (!empty($_GET['ifile']) && intval($_GET['medialib']) == 1) {
            $this->importMLFile($_GET['ifile'], $_GET['smlpath'], intval($_GET['thiscat']));
        }

        $page   = 1;
        $divnum = 3;
        if($_GET['editfile']) { $page = 3; } 
        if($_GET['thiscat'])  { $page = 2; $divnum = 4; } 
        
        // assign some global backend vars as 'dlmgbl' array to smarty backend index template 
        // strip last character / in string 'thispath' is $string = substr($string, 0, -1); else in smarty as modifier $string|substr:0:-1
        $serendipity['smarty']->assign('dlmgbl', 
                array(  
                        'httppath'       => $this->get_config('httppath'),
                        'filename_field' => $this->get_config('filename_field'),
                        'filenums_field' => $this->get_config('dls_field'),
                        'filesize_field' => $this->get_config('filesize_field'),
                        'filedate_field' => $this->get_config('filedate_field'),
                        'thisversion'    => $serendipity['plugin_dlm_version'],
                        'thispath'       => $serendipity['serendipityPath'] . substr($serendipity['dlm']['pluginpath'], 0, -1),
                        'thiscat'        => intval($_GET['thiscat']) ? intval($_GET['thiscat']) : 1,
                        'thispage'       => $page
                    )
        );
        
        if (!empty($_GET['thiscat']) && intval($_GET['thiscat']) >= 1) { //!= 1, this didn't get root level files to move etc, but now the back button of page 3 (file details) returns two root levels, one like a sublevel and one as the dlm startpage which isn't too confusing
            
            /* BACKEND PAGE 2 SECTION 
                                    - edit (single file move and file description), 
                                    - upload form, 
                                    - files in selected category, 
                                    - ftp/trash folderfiles, 
                                    - Serendipities media library files with subcats, 
                                    - subcategories of root, 
                                    - the appendix (including the helptip and the clear trash button) */
            
            $id  = intval($_GET['thiscat']);
            $cat = $this->dlm_sql_db('DLM_SUBCATS', "node_id = $id");
            
            if(is_array($cat)) {

                $ret1 = $this->dlm_sql_db('DLM_COUNT', "catid = $id");
                
                $num_dls = intval($ret1['num']);
                $cat['num'] = $num_dls;

                // append to backend global array in index headers and page 2 subpages the selected cat array
                $serendipity['smarty']->append('dlmgbl', array('cat' => $cat));

                if (!empty($_GET['editfile']) && intval($_GET['editfile']) >= 1) {

                    // generate the single file edit page (id = catid)
                    $this->backend_dlm_edit_file($cat, intval($_GET['editfile']), $id);

                } else {
                    
                    if (!empty($_GET['upload']) && intval($_GET['upload']) >= 1) { 

                        // generate the upload form - PAGE 2
                        $this->backend_dlm_build_uploadform($id);
                        
                    } else {

                        if (count($this->UPLOAD_TOOBIG) >= 1 || count($this->UPLOAD_NOTCOPIED) >= 1) {
                            $ERRMSG = PLUGIN_DOWNLOADMANAGER_ERRORS_OCCOURED."<br />";
                            if (count($this->UPLOAD_TOOBIG) >= 1) {
                                $ERRMSG .= "<br />".PLUGIN_DOWNLOADMANAGER_ERRORS_TOOBIG."<br />";
                                for ($a=0;$a<count($this->UPLOAD_TOOBIG);++$a) {
                                    $ERRMSG .= $this->UPLOAD_TOOBIG[$a]."<br />";
                                }
                            }
                            if (count($this->UPLOAD_NOTCOPIED) >= 1) {
                                $ERRMSG .= "<br />".PLUGIN_DOWNLOADMANAGER_ERRORS_NOTCOPIED."<br />";
                                for ($a=0;$a<count($this->UPLOAD_NOTCOPIED);++$a) {
                                    $ERRMSG .= $this->UPLOAD_NOTCOPIED[$a]."<br />";
                                }
                            }
                            $this->ERRMSG($ERRMSG);
                        }

                        $ct = (isset($_GET['dlmftpdir']) && (intval($_GET['dlmftpdir']) == 1) ? true : false);
                        
                        $files = $this->dlm_sql_db('DLM_SELECT_ARRAY', "catid = ".$id." ORDER BY timestamp DESC");

                        $ddiv = ($_GET['thiscat'] && $num_dls > 0) ? true : false;
                        
                        // generate file table content here - DIV 1 @ PAGE 2
                        $this->backend_dlm_build_filetable($files, (($ct) ? false : $ddiv), $this->globs['ftppath'], $this->globs['dlmpath'], $this->globs['dateformat'], $num_dls, intval($_GET['thiscat']), 1, 2);
                        

                        // generate ftp/trash folder table content here - DIV 2 @ PAGE 2
                        $this->backend_dlm_build_ftptable($ct, $this->globs['ftppath'], intval($_GET['thiscat']), 2, 2);
                        

                        // generate media library folder table content here - DIV 3 @ PAGE 2 
                        $this->backend_dlm_build_s9ml_table($this->globs['dateformat'], $serendipity['serendipityPath'] . $serendipity['uploadPath'], 3, 2);
                        
                        if( !is_array($cats) ) { 
                            $cats = array();
                            $cats = $this->GetAllCats(true);
                            
                            if (is_array($cats) && sizeof($cats) >= 1) {
                                unset($cat);
                            }
                        }
                        // new: generate categories table - DIV 4 (permanently open = true) @ PAGE 2
                        $this->backend_dlm_build_categories($cats, (($ct) ? false : true), $this->globs['ftppath'], intval($_GET['thiscat']), 4, 2);
                        
                        // generate appendix trash & helptip
                        $this->backend_dlm_appendix($this->globs['ftppath'], intval($_GET['thiscat']), 5, 2);
                        
                    }
                }
            } else {
                $this->ERRMSG(PLUGIN_DOWNLOADMANAGER_CAT_NOT_FOUND);
            }
        } else {
            /* BACKEND PAGE 1 ROOT SECTION 
                                    - add subcategories to root or selected category
                                    - files in selected category, 
                                    - subcategories of root, 
                                    - the appendix (including the helptip and the clear trash button) */
            
            if(!$_GET['thiscat'] || empty($_GET['thiscat'])) $_GET['thiscat'] = 1;

            // generate categories add table - DIV 1 @PAGE 1 == startpage
            $this->backend_dlm_add_categories($cats, 1, 1);

            $files = $this->dlm_sql_db('DLM_SELECT_ARRAY', "catid = 1 ORDER BY timestamp DESC");
            
            $fnum = (is_array($files) ? count($files) : 0);
            
            // new: generate file table content here - DIV 2 @ PAGE 1 == startpage
            $this->backend_dlm_build_filetable($files, $ddiv, $this->globs['ftppath'], $this->globs['dlmpath'], $this->globs['dateformat'], $fnum, intval($_GET['thiscat']), 2, 1);

            if( !is_array($cats) ) { 
                $cats = array();
                $cats = $this->GetAllCats(true);
                
                if (is_array($cats) && sizeof($cats) >= 1) {
                    unset($files);
                }
            }
            
            // generate categories table - DIV 3 (permanently open = true) @ PAGE 1 == startpage
            $this->backend_dlm_build_categories($cats, true, $this->globs['ftppath'], intval($_GET['thiscat']), 3, 1);
            
            // generate appendix trash & helptip
            $this->backend_dlm_appendix($this->globs['ftppath'], intval($_GET['thiscat']), 4, 1);
            
        }
        
        /* get the backend dlm index template file */
        echo $this->parseTemplate('backend.dlm.index.tpl');
        
        } // logged-in end
    }


    function generate_content(&$title) {
        $title = PLUGIN_DOWNLOADMANAGER_TITLE.' ('.$this->get_config('pageurl').')';
    }

    function install() {
        $this->setupDB();
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        
        $serendipity['plugin_dlm_version'] = &$bag->get('version');
        
        if (isset($hooks[$event])) {
            switch($event) {
                case 'entry_display' :
                    if ($this->selected()) {
                        if (is_array($eventData)) {
                            $eventData['clean_page'] = true;
                        } else {
                            $eventData = array ('clean_page' => true);
                        }
                    }
                    return true;

                    break;

                case 'backend_sidebar_entries':
                    $this->setupDB();
                    // forbid entry if not admin
                    if(serendipity_userLoggedIn() && $_SESSION['serendipityAuthedUser'] === true && $_SESSION['serendipityUserlevel'] == '255') {
                    ?>
                    <li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager"><?php echo PLUGIN_DOWNLOADMANAGER_TITLE; ?></a></li>
                    <?php
                    }

                    break;

                case 'backend_dlm_filecopy': 
                
                    if( !serendipity_db_bool($this->get_config('chg2archivespath')) ) { 
                        
                        $oldfilepath = ($this->get_config('absdownloadspath') ? $this->get_config('absdownloadspath') : $serendipity['serendipityPath'] . 'templates_c/.dlmanager/files');
                        $newfilepath = $serendipity['serendipityPath'] . 'archives/.dlm/files';
                        
                        // upgrade the old encoded files to new dir
                        $updown = $this->backend_dlm_upgrade($oldfilepath, $newfilepath, 'absdownloadspath');
                        
                        $oldinpath = ($this->get_config('absincomingpath') ? $this->get_config('absincomingpath') : $serendipity['serendipityPath'] . $serendipity['uploadPath'] . '.dlmanager/incoming');
                        $newinpath = $serendipity['serendipityPath'] . 'archives/.dlm/ftpin';
                        
                        // upgrade the old incoming ftp/trash files to new dir
                        $upin = $this->backend_dlm_upgrade($oldinpath, $newinpath, 'absincomingpath');
                        
                        if(true === ($updown || $upin)) { 
                            $this->set_config('chg2archivespath', true);
                            $url = $_SERVER['PHP_SELF'] . '?serendipity[adminModule]=event_display&serendipity[adminAction]=downloadmanager&cpdone=1';
                            $this->backend_dlm_refresh($url);
                        }
                    }
                    
                    break;
                
                case 'backend_sidebar_entries_event_display_downloadmanager': 
                    
                    $serendipity['dlm']['stopadminprocess'] = false;

                    if (!is_object(isset($serendipity['smarty']))) { 
                        serendipity_smarty_init(); // if not set to avoid member function assign() on a non-object error, start Smarty templating
                    }

                    // load the 0.24 upgrade hook
                    if (version_compare($serendipity['plugin_dlm_version'], '0.24', '<=')) {
                        serendipity_plugin_api::hook_event('backend_dlm_filecopy', $addData);
                    } else {
                        if(!serendipity_db_bool($this->get_config('chg2archivespath'))) $this->set_config('chg2archivespath', true);
                    }
                    if(intval($_GET['cpdone']) == 0) $this->set_config('chg2archivespath', true);
                    
                    if( intval(isset($_GET['cpdone'])) || $serendipity['dlm']['stopadminprocess'] === false ) {
                    
                        $this->ADMIN_showDownloads();
                    
                    }
                    
                    break;

                case 'external_plugin':
                    $uri_parts = explode('?', str_replace('&amp;', '&', $eventData));

                    // Try to get request parameters from eventData name
                    if (!empty($uri_parts[1])) {
                        $reqs = explode('&', $uri_parts[1]);
                        foreach($reqs AS $id => $req) {
                            $val = explode('=', $req);
                            if (empty($_REQUEST[$val[0]])) {
                                $_REQUEST[$val[0]] = $val[1];
                            }
                        }
                    }


                    $parts     = explode('_', $uri_parts[0]);
                    if (!empty($parts[1])) {
                        $param     = (int) $parts[1];
                    } else {
                        $param     = null;
                    }

                    switch($parts[0]) {
                        case 'dlfile':

                            $fileid = intval($parts[1]);

                            serendipity_db_query("UPDATE {$serendipity['dbPrefix']}dma_downloadmanager_files SET dlcount = dlcount+1 WHERE id = " . $fileid);

                            $sql  = "SELECT * FROM {$serendipity['dbPrefix']}dma_downloadmanager_files WHERE id = ".$fileid;
                            $file = serendipity_db_query($sql);
                            $mime = $this->getMime($file[0]['realfilename']);
                            $contenttype = $mime['TYPE'];


                            $filename = $file[0]['realfilename'];
                            $filename = str_replace(' ', '_', $filename);
                            $path     = $this->globs['dlmpath'];
                            $sysname  = $file[0]['systemfilename'];
                            $filesize = $file[0]['filesize'];

                            if (function_exists("getallheaders")) {
                                $headers = getallheaders();
                            }

                            if (substr($headers["Range"], 0, 6) == "bytes=") {
                                header("HTTP/1.1 206 Partial Content");
                                header("Content-Type: $contenttype");
                                header("Content-Disposition: attachment; filename=".$filename);
                                header("Accept-Ranges: bytes");
                                header("Connection: close");
                                $bytes = explode("=",$headers["Range"]);
                                $bytes = $bytes[1];
                                if (preg_match("@^-([0-9]+)@", $bytes, $bytes_len)) {
                                    $bytes_len = $bytes_len[1];
                                    $bytes_start = $filesize - $bytes_len;
                                    $bytes_end = $filesize - 1;
                                    header("Content-Length: ".$bytes_len);
                                } elseif (preg_match("@([0-9]+)-$@", $bytes, $bytes_start)) {
                                    $bytes_start = $bytes_start[1];
                                    $bytes_end = $filesize - 1;
                                    $bytes_len = $filesize - $bytes_start;
                                    header("Content-Length: $bytes_len");
                                } elseif (preg_match("@^([0-9]+)-([0-9]+)$@", $bytes, $bytes_pos))
                                    {
                                    $bytes_start = $bytes_pos[0];
                                    $bytes_end = $bytes_pos[1];
                                    if ($bytes_start < 0 || $bytes_start > ($filesize - 1)) {
                                        $bytes_start = 0;
                                    }
                                    if ($bytes_end < $bytes_start || $bytes_end > ($filesize - 1)) {
                                        $bytes_end = $filesize - 1;
                                    }
                                    $bytes_len = $bytes_end - $bytes_start + 1;
                                    header("Content-Length: $bytes_len");
                                } else {
                                    $bytes_start = 0;
                                    $bytes_end = $filesize - 1;
                                    $bytes_len = $bytes_end - $bytes_start + 1;
                                    header("Content-Length: $bytes_len");
                                }
                                header("Content-Range: bytes $bytes_start-$bytes_end/".$filesize);
                                $fp = fopen($path."/".$sysname,"rb");
                                fseek($fp, $bytes_start);
                                $contents = fread ($fp, $bytes_len );
                                fclose($fp);
                                echo $contents;
                            } else {
                                $fp = fopen($path."/".$sysname,"rb");
                                $contents = fread ($fp, $filesize);
                                fclose($fp);
                                header("Content-Type: $contenttype");
                                header("Content-Disposition: attachment; filename=".$filename);
                                header("Accept-Ranges: bytes");
                                header("Content-Length: " . strlen($contents));
                                header("Connection: close");
                                echo $contents;
                            }

                            break;
                    }

                    return true;
                    break;

                /* put here all your css stuff you need for the downloadmanagers plugin frontend output */
                case 'css':
                    
                    if (stristr($eventData, '#downloadmanager')) { 
                        // class exists in CSS, so a user has customized it and we don't need default
                        return true;
                    }
                    
                    $tfile = serendipity_getTemplateFile('style_dlmanager_frontend.css', 'serendipityPath');
                    if($tfile) echo @file_get_contents($tfile);
                    
                    if (!$tfile || $tfile == 'style_dlmanager_frontend.css') { 
                        $tfile = dirname(__FILE__) . '/style_dlmanager_frontend.css';
                        echo @file_get_contents($tfile);
                    }
                    
                    return true;
                    break;
                
                /* put here all you css stuff you need for the backend of dlm */
                case 'css_backend':
                    if (stristr($eventData, '#backend_downloadmanager')) { 
                        // class exists in CSS, so a user has customized it and we don't need default
                        return true;
                    }
                    $tfile = serendipity_getTemplateFile('style_dlmanager_backend.css', 'serendipityPath');
                    if($tfile) { 
                        $tfilecontent = @file_get_contents($tfile);
                    }
                    if ( (!$tfile || $tfile == 'style_dlmanager_backend.css') && !$tfilecontent ) { 
                        $tfile = dirname(__FILE__) . '/style_dlmanager_backend.css';
                        $tfilecontent = @file_get_contents($tfile);
                    }
                    
                    // add replaced css content to the end of serendipity_admin.css
                    if(!empty($tfilecontent)) $this->backend_dlm_css($eventData, $tfilecontent);
                    
                    return true;
                    break;

                case 'entries_header' :
                    //this shows our page and not an empty one

                    $this->show();

                    return true;
                    break;

                default:
                    return false;
                    break;
                    
            } // switch end
        }

        return true;
    }

 /***************************************************
  * Backend administration functions
  **************************************************/

    /* add backend css to serendipity_admin.css */
    function backend_dlm_css(&$eventData, &$becss) {
        $eventData .= $becss;
    }

    /** helptip array 
     * HELPTIP_CF = (sub)category folder; 
     * HELPTIP_FF = file folder; 
     * HELPTIP_IF = incoming ftp/trash folder; 
     * HELPTIP_MF = s9y media library folder;
     */
    function backend_dlm_helptip() {
        return array(
                    'htp[1]'  => PLUGIN_DOWNLOADMANAGER_HELPTIP_CF_CHANGE,
                    'hlp[2]'  => PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_CHANGE,
                    'hlp[3]'  => PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_VIEW,
                    'hlp[4]'  => PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_ERASE,
                    'hlp[5]'  => PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_TRASH,
                    'hlp[6]'  => PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_MULTI,
                    'hlp[7]'  => PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_SINGLE,
                    'hlp[8]'  => PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_KEEP,
                    'hlp[9]'  => PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_MOVE,
                    'hlp[10]'  => PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_LFTP,
                    'hlp[11]'  => PLUGIN_DOWNLOADMANAGER_HELPTIP_DESC
                    /*
                    'htp[3]'  => PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_S9ML,
                    'hlp[]'  => PLUGIN_DOWNLOADMANAGER_HELPTIP_,
                    */
                    );
    }
    
    /**
     * refresh a page to show correct values directly after move, erase, clean etc (mostly done on page 2)
     * order by header(), Javascript, HTML (meta refresh)
     * 
     * @param   string request url
     
     * @return  false  exit page
     */
    function backend_dlm_refresh($url) { 
        if($url && !headers_sent()) { 
            if(header('Location: http://' . $_SERVER['HTTP_HOST'] . $url)) exit;
        } else { 
            echo '<script type="text/javascript">';
            echo '    window.location.href="' . $url . '&viajs=1"';
            echo '</script>';
            echo '<noscript>';
            echo '    <meta http-equiv="refresh" content="0;url=' . $url . '&viameta=1" />';
            echo '</noscript>';
            exit;
        }
    }
    
    
    /**
     * upgrade files with v.0,24 to /archives/.dlm/files and /archives/.dlm/ftpin folder
     * 
     * @param   string oldpath
     * @param   string newpath
     * @param   string config name set
     * 
     * @return  true or false
     */
    function backend_dlm_upgrade($old, $new, $coname) { 
        global $serendipity;
        
        if (!is_dir($new)) { 
            @mkdir($new, 0777, true);
        }
                        
        // fetch the files (encoded or normal) of old path as an array
        $files = $this->backend_dlm_fetch_pathfiles($old);
                        
        if(is_array($files['f_arr']) && !empty($files['f_arr']) ) {  
            
            foreach($files['f_arr'] as $k => $v) { 
                // This does not rename the files, as you might assume, instead, it moves them physically!
                if(!@rename ($old.'/'.$v, $new.'/'.$v)) { 
                    // void 
                } else { 
                    $result[] = array($v => true);
                }
            }
            
            if( is_array($result) && !empty($result) ){ 
                unset($files);
                unset($result);
                $this->set_config($coname, $new);
                return true;
            } else { 
                if($coname == 'absincomingpath') echo '<hr />';
                $url = $_SERVER['PHP_SELF'] . '?serendipity[adminModule]=event_display&serendipity[adminAction]=downloadmanager&cpdone=0';
                $this->ERRMSG($this->globs['attention'] . ' ' . sprintf(PLUGIN_DOWNLOADMANAGER_ERRORS_UPGRADE_NOTCOPIED, $old, $new, $url));
                $serendipity['dlm']['stopadminprocess'] = true;
                return false;
            }
        } else { 
            // nada in old path -  set config and return true to continue
            $this->set_config($coname, $new);
            return true;
        }
    }
    
    
    /***
     * fetch dlm backend pathfiles table content
     *
     * @param   string  The path to the s9y media library
     *
     * @return  array
     */
    function backend_dlm_fetch_pathfiles($path) { 
        
        $fa['d_arr'] = array(); $d = 0;
        $fa['f_arr'] = array(); $f = 0;

        if( is_dir( $path ) ) {
            if( $handle = opendir( $path ) ) {
                while( false !== ( $file = readdir( $handle ) ) ) {
                    if( $file != "." && $file != ".." && $file[0] != "." ) {
                        if( is_dir( $path . "/" . $file ) )
                            $fa['d_arr'][++$d] = $file;
                        else
                            $fa['f_arr'][++$f] = $file;
                    }
                }
            }
        }

        if( is_dir( $path ) ) closedir( $handle );

        return $fa;
    }
    
    
    /**
     * recursive str_replaces in files array, happens to special keys only, used by smarty files array to set filesize, mime array and filedate
     * 
     * @param array           the array data
     * @param string/boolean  use with date() replacement funktion too
     * @param string/boolean  search in specific key only = string (optional)
     * @param string/boolean  new keyname, use with different replacement funktion only (optional) 
     * 
     * @return array
     **/
    function backend_str_replace_recursive(&$data, $p=false, $skey=false, $nkey=false) { 
        if(is_array($data)) { 
            foreach($data as $key => $value) { 
                if (is_array($value) ) { 
                    $this->backend_str_replace_recursive($data[$key], $p, $skey, $nkey);
                } else {
                    if($key == $skey) { 
                        if(!$nkey) $data[$key] = ($p ? date($p, $value) : $this->calcFilesize($value));
                        elseif ($p === false) $data[$nkey] = $this->getMime($value);
                        else $data[$nkey] = ($p ? date($p, $value) : $this->calcFilesize($value));
                    }
                }
            }
        } 
        return isset($data) ? $data : false;
    }

    /* see function backend_str_replace_recursive() - this one is for categories only */
    function backend_str_replace_recursive_cat(&$data, $p=false, $skey=false, $nkey=false) { 
        if(is_array($data)) { 
            foreach($data as $key => $value) { 
                if (is_array($value) ) { 
                    $this->backend_str_replace_recursive_cat($data[$key], $p, $skey, $nkey);
                } else {
                    if($key === $skey) $data[$nkey] =  (550 - (20 * $value));
                }
            }
        } 
        return isset($data) ? $data : false;
    }


    /** generate backend appendix trash & helptip 
     *
     * @param   string  The configs absincomepath
     * @param   int     The category id number 
     * @param   int     The div number (standard=3)
     * @param   int     The page number
     *
     * @return string
    */
    function backend_dlm_appendix($absinth='', $cn=1, $dn=0, $pn=0) { 
        global $serendipity;
        
        $attention = $this->globs['attention'];

        // fetch all physically files in incoming ftp or trash table
        $ifiles = $this->backend_dlm_fetch_pathfiles($absinth);
        $ifn    = count($ifiles['f_arr']);
        unset($ifiles);

        // assign the backend appendix vars to smarty template page section 'appendix'
        $serendipity['smarty']->assign('dlmapx', 
            array(
                'appendix'  => true,
                'cleanme'   => ($ifn >= 1) ? true : false,
                'helplist'  => $this->backend_dlm_helptip()
            )
        );

        // view all smarty template vars
        #echo '<pre>';
        #print_r( $serendipity['smarty']->get_template_vars() );
        #echo '</pre>';
        
        return;
    }
    
    
    /***
     * build the dlm backend add categories table
     *
     * @param   array   A referenced array of categories
     * @param   int     The div number (standard=3)
     * @param   int     The page number
     *
     * @return string
     */
    function backend_dlm_add_categories($cats, $dn=0, $pn=0) { 
        global $serendipity;

        // build the category list in backend => true and as <select> call list => true
        $catlist = $this->buildCategoriesList(true, true);
        
        // assign the backend addcat vars to smarty template page section 'addcat'
        $serendipity['smarty']->assign('dlmact', 
            array(
                'addcat'      => true,
                'selcatlist'  => $catlist
            )
        );
        unset($catlist);
        return;
    }

    /***
     * build the dlm backend categories table content
     *
     * @param   array   A referenced array of categories
     * @param   boolean Default value foldable divs (permanently open = true) 
     * @param   string  The configs absincomepath
     * @param   int     The category id number 
     * @param   int     The div number (standard=3)
     * @param   int     The page number
     *
     * @return string
     */
    function backend_dlm_build_categories($cats, $ddiv=false, $absinth='', $cn=1, $dn=0, $pn=0) { 
        global $serendipity;
    
        if (is_array($cats) && sizeof($cats) >= 1) {

            $cc = is_array($cats) ? count($cats)-1 : 0; // else root level would be counted too

            // build the category list in backend => true and as <select> call list => false
            $catlist = $this->buildCategoriesList(true, false);
            
            // set value of key filesize to something readable
            $catlist = $this->backend_str_replace_recursive_cat($catlist, false, 'level', 'inputsize');
            
            // assign the backend category vars to smarty template page section 'hascats'
            $serendipity['smarty']->assign('dlmhcs', 
                array(
                    'hascats'        => true,
                    'ddiv'           => $ddiv,
                    'catlist'        => $catlist,
                    'catsinccat'     => $cc,
                    'cn'             => $cn
                )
            );
        } 
        unset($cats);
        unset($catlist);
        return;
    }
    
    /***
     * build dlm backend file table content
     *
     * @param   array   A referenced array of files
     * @param   boolean Default value foldable divs (permanently open = true) 
     * @param   string  The configs absincomepath
     * @param   string  The configs absdownloadspath
     * @param   string  The configs Dateformat
     * @param   int     This dirs total file count number 
     * @param   int     The category id number 
     * @param   int     The div number
     * @param   int     The page number
     *
     * @return string
     */
    function backend_dlm_build_filetable($files, $ddiv=false, $absinth='', $absdoth='', $dateformat='Y-m-d H:i', $fn=0, $catid=1, $dn=0, $pn=0) { 
        global $serendipity;
        
        $moved  = false;

        /* reject multiple files being marked to erase */
        if(isset($_POST['Reject_Selected']) || isset($_POST['Reject_Selected_x']) || isset($_POST['Reject_Selected_y'])) { 
            if(is_array($_POST['dlm']['files'])) { 
                
                // build new array - fetch file names by id
                $dfile  = array();
                foreach ($_POST['dlm']['files'] AS $k => $v) { 
                    foreach($files as $file) { 
                        if( $file['id'] == $v ) { 
                            // build the correct path from($this->globs['dlmpath']) -> where($this->globs['ftppath']) by new array
                            $dfile[] = array(    'id' => $file['id'], 
                                                'cat' => $file['catid'], 
                                                'sfn' => $absdoth.'/'.$file['systemfilename'], 
                                                'rfn' => $absinth.'/'.$file['realfilename']
                                            );
                        }
                    }
                }
                if ( is_array($dfile) && !empty($dfile) ) { 
                
                    $realcatid = $dfile[0]['cat'];
                    
                    foreach($dfile as $movit) { 
                        // This does not rename the file, as you might assume, instead, it moves the file physically!
                        if(!@rename ($movit['sfn'], $movit['rfn'])) { 
                            $this->ERRMSG(PLUGIN_DOWNLOADMANAGER_DELETE_IN_DOWNLOADDIR_NOT_ALLOWED);
                        } else { 
                            $result = $this->dlm_sql_db('DLM_BE_DELETE_FILE', "id = ".$movit['id']);
                        }
                    }
                    if($result) { 
                        unset($movit);
                        $moved = true;
                    }
                }
            }
        }
        
        if($moved === true) { 
            $url = $_SERVER['PHP_SELF'] . '?serendipity[adminModule]=event_display&serendipity[adminAction]=downloadmanager&thiscat=' . ($realcatid ? $realcatid : $catid) . '&dlmftpdir=1';
            if(is_array($dfile)) unset($dfile);
            if(is_array($_POST)) unset($_POST);
            $this->backend_dlm_refresh($url);
        }
        
        if (is_array($files) && !empty($files)) { 

            // set value of key filesize to something readable
            $files = $this->backend_str_replace_recursive($files, false, 'filesize');
            
            // set value of key timestamp as new key/value pair to something readable defined by our config setting $this->get_config('dateformat')
            $files = $this->backend_str_replace_recursive($files, $dateformat, 'timestamp', 'filedate');
            
            // set value of key realfilename as new key/value pair to collect mime values as array by file
            $files = $this->backend_str_replace_recursive($files, false, 'realfilename', 'mime');
                
        }

        // assign the backend filetable vars to smarty template page section 'catfiles'
        $serendipity['smarty']->assign('dlmcfs', 
            array(
                'catfiles'       => true,
                'ddiv'           => $ddiv,
                'filelist'       => $files,
                'downloadpath'   => $serendipity['baseURL'] . ($serendipity['rewrite'] == "none" ? $serendipity['indexFile'] . "?/" : "") . "plugin/dlfile_"
            )
        );
        return;
    }
    
    /***
     * build dlm backend s9y media gallery file table content
     *
     * @param   string  The configs Dateformat
     * @param   string  The path to the s9y media library
     * @param   int     The div number
     * @param   int     The page number
     *
     * @return string
     */
    function backend_dlm_build_s9ml_table($dateformat='Y-m-d H:i', $path='', $dn=0, $pn=0) { 
        global $serendipity;
        
        if (isset($_GET['smlpath']) && trim($_GET['smlpath']) != '' && !preg_match("@\.\./@", $_GET['smlpath'])) {
            $extrapath = trim($_GET['smlpath']);
        } else {
            $extrapath = '';
        }

        if ($path[(strlen($path)-1)] == "/")
            $path = substr($path, 0, (strlen($path)-1));
        $path .= $extrapath;

        // fetch all physically files in current category
        $files = $this->backend_dlm_fetch_pathfiles($path);
        
        // sort by name descending
        asort( $files['d_arr'] ); reset( $files['d_arr'] );
        asort( $files['f_arr'] ); reset( $files['f_arr'] );

        if (count($files['d_arr']) <= 0 && count($files['f_arr']) <= 0) {
            $sml_arr = false;
        } else {
            $sml_arr = true;

            if (!empty($extrapath)) {
                $backpath = preg_replace("`\/[^\/]*$`i", "", $extrapath);
            }

            foreach($files['d_arr'] as $key => $val) {

                $smldirs[] = array(
                                'filename' => $val,
                                'expath'   => $extrapath
                                );
            }

            foreach($files['f_arr'] as $key => $val) {
                if( ($files['f_arr'] != '.' && $files['f_arr'] != '..') && (false === (strpos($val, 'serendipityThumb'))) ) {
                    $mime = $this->getMime($val);
                    
                    $filedate = date($dateformat, filemtime($path."/".$val));
                    $filesize = filesize($path."/".$val);
                    $filesize = $this->calcFilesize($filesize);
                    
                    $smlfiles[] = array(
                                'filename' => $val,
                                'filesize' => $filesize,
                                'filedate' => $filedate,
                                'filemime' => $mime,
                                'expath'   => $extrapath
                                );
                }
            }
        }

        // assign as array('sml') the S9y media library files to smarty tpl page 2 'thissml' section
        $serendipity['smarty']->assign('dlmtsl',  
            array(
                'thissml'        => true,
                'ddiv'           => (isset($_GET['smlpath']) && !empty($_GET['smlpath'])) ? true : false,
                'smlpath'        => !empty($path) ? $path : $extrapath,
                'smlfiles'       => $smlfiles,
                'issmlarr'       => $sml_arr,
                'smldirs'        => $smldirs,
                'extrapath'      => $extrapath,
                'backpath'       => $backpath
            )
        );
        return;
    }
    
    
    /**
     * generate page 2 incoming folder table content here - DLM 2 @ PAGE 2
     *
     * @param  boolean Default value foldable divs (permanently open = true) 
     * @param  string  The full path incoming FTP folder
     * @param  int     The category id number
     * @param  int     The div number
     * @param  int     The page number
     *
     * @return string
     **/
    function backend_dlm_build_ftptable($ddiv=false, $absinth='', $catid=1, $dn=0, $pn=0) { 
        global $serendipity;

        // fetch all physically files in incoming ftp or trash table
        $files = $this->backend_dlm_fetch_pathfiles($absinth);
        $fn = count($files['f_arr']);
        $ct = ($fn >= 1) ? true : false;

        /* clean trash = incoming folder by blue trash box */
        if($ct && (intval($_GET['cleantrash']) == 1 && intval($_POST['dlm']['cleartrash']) == 1) 
               && !(isset($_POST['Move_Selected']) || isset($_POST['Move_Selected_x']) || isset($_POST['Move_Selected_y'])) ) { 
            foreach($files['f_arr'] as $file) { 
                $this->delIncomingFile($file);
                $deinfi = true;
            }
            if($deinfi === true) { 
                if(is_array($_POST)) unset($_POST);
                if(is_array($files)) unset($files);
                $url = $_SERVER['PHP_SELF'] . '?serendipity[adminModule]=event_display&serendipity[adminAction]=downloadmanager&thiscat=' . $catid;
                $this->backend_dlm_refresh($url);
            }
        }
        
        if(is_array($files)) unset($files);
        
        /* move multiple files being marked to move to a new directory */
        if( isset($_POST['Move_Selected']) || isset($_POST['Move_Selected_x']) || isset($_POST['Move_Selected_y']) ) { 
            if(is_array($_POST['dlm']['ifiles'])) { 
                foreach ($_POST['dlm']['ifiles'] AS $ifile) { 
                    $this->importFile($ifile, $catid);
                }
            }
            if(is_array($_POST)) unset($_POST);
            $url = $_SERVER['PHP_SELF'] . '?serendipity[adminModule]=event_display&serendipity[adminAction]=downloadmanager&thiscat=' . $catid;
            $this->backend_dlm_refresh($url);
        }

        $fp = opendir($absinth);
        $cf = 0;
        while ($file = readdir($fp)) {
            if ($file != "." && $file != "..") {

                $mime = $this->getMime($file);

                $filedate = date($this->globs['dateformat'], filemtime($absinth."/".$file));
                $filesize = filesize($absinth."/".$file);
                $filesize = $this->calcFilesize($filesize);
                
                $files[] = array(
                                'filename' => $file,
                                'filesize' => $filesize,
                                'filedate' => $filedate,
                                'filemime' => $mime
                                );
                                
                ++$cf;
            }
        }
        closedir($fp);
        
        // assign the backend ftp/trash vars to smarty template page section 'thisftp'
        $serendipity['smarty']->assign('dlmtfp', 
            array(
                'thisftp'        => true,
                'ddiv'           => $ddiv,
                'ftpfiles'       => $files,
                'ct'             => $ct,
                'movedtoftp'     => $ddiv,
                'ftppath'        => $absinth
            )
        );
        return;
    }
    
    /**
     * doc and need of id???
     **/
    function backend_dlm_build_uploadform($id) { 
        global $serendipity;
    
        $upload_max_filesize = ini_get('upload_max_filesize');
        $upload_max_filesize = preg_replace('/M/', '000000', $upload_max_filesize);
        $MAX_FILE_SIZE       = intval($upload_max_filesize);
        $MAX_SIZE_PER_FILE   = ($MAX_FILE_SIZE / 1000000)." MB";

        // assign the backend uploadform vars to smarty template page section 'uploadform'
        $serendipity['smarty']->assign('dlmulf', 
            array(
                'thistype'            =>    'uploadform',
                'file_uploads'        =>    ini_get('file_uploads'),
                'MAX_FILE_SIZE'       =>    $MAX_FILE_SIZE,
                'MAX_SIZE_PER_FILE'   =>    ($MAX_FILE_SIZE / 1000000)." MB"
           )
        );

        return;
    }
    
    /***
     * build dlm backend file table content
     *
     * @param   array   A referenced array of this category
     * @param   int     The single file id number
     * @param   int     The single file catid number
     *
     * @return string
     */
    function backend_dlm_edit_file($cat, $id, $catid) { 
        global $serendipity;
    
        // get all specific information about file
        $file = $this->dlm_sql_db('DLM_SELECT', "id = $id");
        $mime = $this->getMime($file['realfilename']);
        
        // build the category list in backend => true and as <select> call list => true
        $catlist = $this->buildCategoriesList(true, true);
        
        // assign the backend editfile vars to smarty template page section 'editfile'
        $serendipity['smarty']->assign('dlmefe', 
            array(
                'thistype'       =>    'editfile',
                'description'    =>    $file['description'],
                'realfilename'   =>    $file['realfilename'],
                'fileid'         =>    $id,
                'mime'           =>    $mime,
                'catid'          =>    $catid,
                'selcatlist'     =>    $catlist
            )
        );
        unset($catlist);
        return;
    }
    
}

/* vim: set sts=4 ts=4 expandtab : */