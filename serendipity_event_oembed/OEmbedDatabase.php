<?php
@define('PLUGIN_OEMBED_DATABASEVERSION_CONFIG', "oembed_version");
@define('PLUGIN_OEMBED_DATABASEVNAME', "oembeds");

class OEmbedDatabase {

    function save_oembed($url, $oembed) {
        if (empty($url) || !isset($oembed)) return false;
        if (isset($oembed->html)) {
            $oembed->html = OEmbedDatabase::cleanup_html($oembed->html);
        }
        $save = array();
        $save['urlmd5'] = md5($url);
        $save['url'] = $url;
        $save['oetype'] = $oembed->type;
        $save['oeobj'] = serialize($oembed);
        serendipity_db_insert( PLUGIN_OEMBED_DATABASEVNAME, $save );
        return $oembed;
    }
    
    function load_oembed($url) {
        global $serendipity;
        if (empty($url)) return null;
        
        $urlmd5 = md5($url);
        $query = "select oeobj from {$serendipity['dbPrefix']}" . PLUGIN_OEMBED_DATABASEVNAME . " where urlmd5='$urlmd5'";
        
        $rows = serendipity_db_query($query);
        if (!is_array($rows)) { // fresh search
            return null;
        }
        else {
            $oeobj = null;
            foreach ($rows as $row) {
                $oeobj = $row['oeobj'];
                if (!empty($oeobj)) break;
            }
            if (!empty($oeobj)) {
                return unserialize($oeobj);
            }
            
        }
        return null;
    }
    function clear_cache() {
        global $serendipity;
        $q = "delete from {$serendipity['dbPrefix']}" . PLUGIN_OEMBED_DATABASEVNAME;
        serendipity_db_schema_import($q);
    }
    
    function install(&$obj) {
        global $serendipity;

        if (!OEmbedDatabase::table_created(PLUGIN_OEMBED_DATABASEVNAME)) {
            $md5test = md5("test");
            $md5len = strlen($md5test);
            $q = "create table {$serendipity['dbPrefix']}" . PLUGIN_OEMBED_DATABASEVNAME. " (" .
                    "urlmd5 char($md5len) not null, " .
                    "url varchar(3000) not null, " .
            		"oetype varchar(20) not null, " .
            		"oeobj text not null, " .
                    "primary key (urlmd5)" .
                ")";

            $result = serendipity_db_schema_import($q);

            if ($result !== true) {
                return;
            }
        }
    }
    
    
    function table_created($table = PLUGIN_OEMBED_DATABASEVNAME)  {
        global $serendipity;

        $q = "select count(*) from {$serendipity['dbPrefix']}" . $table;
        $row = serendipity_db_query($q, true, 'num');

        if (!is_numeric($row[0])) {        // if the response we got back was an SQL error.. :P
            return false;
        } else {
            return true;
        }
    }
    
    function cleanup_html( $str ) {
        $str = trim($str);
        // Clear unicode stuff 
        $str=str_ireplace("\u003C","<",$str);
        $str=str_ireplace("\u003E",">",$str);
        // Clear CDATA Trash.
        $str = preg_replace("@^<!\[CDATA\[(.*)]]>$@", '$1', $str);
        $str = preg_replace("@^<!\[CDATA\[(.*)$@", '$1', $str);
        $str = preg_replace("@(.*)]]>$@", '$1', $str);
        return $str;
    }
    
}