<?php
@define('PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG', 'spicedb');

class DbSpice {
    static function table_created($table = 'tweetbackhistory')  {
        global $serendipity;

        $q = "select count(*) from {$serendipity['dbPrefix']}" . $table;
        $row = serendipity_db_query($q, true, 'num');

        if (!is_numeric($row[0])) {        // if the response we got back was an SQL error.. :P
            return false;
        } else {
            return true;
        }
    }
    
    static function install(&$obj) {
        global $serendipity;
        $dbversion = $obj->get_config(PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG);
        if (empty($dbversion)) $dbversion=0;
        
        if (!DbSpice::table_created('commentspice')) {
            // twitternames cant be longer than 15 referring to API docs. 20 for safety. nvarchar because of unicode names
            $q = "create table {$serendipity['dbPrefix']}commentspice (" .
                    "commentid int(10) not null, " .
                    "twittername nvarchar(20), " .
                    "primary key (commentid)" .
                ")";

            $result = serendipity_db_schema_import($q);

            if ($result !== true) {
                return;
            }
            $obj->set_config(PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG, 1);
        }
        // Version 2 updates
        if ($obj->get_config((PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG)<2)) {
            $q = "alter table {$serendipity['dbPrefix']}commentspice" .
                " add column promo_name nvarchar(200),".
                " add column promo_url nvarchar(250);";
            serendipity_db_query($q);
            $obj->set_config(PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG, 2);
        }
        // Version 3 updates
        if ($obj->get_config((PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG)<3)) {
            $q = "CREATE INDEX IDX_COMMENTS_EMAIL" .
                  " on {$serendipity['dbPrefix']}comments (email);";
            serendipity_db_query($q); // if it already exists, it won't be created 
            $obj->set_config(PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG, 3);
        }
        // Version 4 updates
        if ($obj->get_config((PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG)<4)) {
            $q = "alter table {$serendipity['dbPrefix']}commentspice" .
                " add column boo nvarchar(250);";
            serendipity_db_query($q);
            $obj->set_config(PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG, 4);
        }
    }
    
    static function countComments($email) {
        global $serendipity;
        if (empty($email)) return 0;
        $db_email = serendipity_db_escape_string($email);
        $q = "SELECT COUNT(*) AS commentcount FROM {$serendipity['dbPrefix']}comments WHERE email='$db_email'";
        $row = serendipity_db_query($q, true);
        return $row['commentcount'];
    }
    
    static function saveCommentSpice($commentid, $twittername, $promo_name, $promo_url, $boo_url) {
        global $serendipity;
        if (empty($commentid) || !is_numeric($commentid) || (empty($twittername) && empty($promo_name) && empty($boo_url)) ) return true;
        
        $spice = array('commentid' => $commentid);
        if (!empty($twittername)) $spice['twittername'] = $twittername;
        if (!empty($promo_name)) $spice['promo_name'] = $promo_name;
        if (!empty($promo_url)) $spice['promo_url'] = $promo_url;
        if (!empty($boo_url)) $spice['boo'] = $boo_url;
        
        return serendipity_db_insert('commentspice', $spice);
    }
    
    static function loadCommentSpice($commentid) {
        global $serendipity;
        if (empty($commentid) || !is_numeric($commentid)) return false;
        
        $sql = "SELECT * FROM {$serendipity['dbPrefix']}commentspice WHERE commentid=$commentid";
        $row = serendipity_db_query($sql, true);
        if (!is_array($row)) return false;
        return $row;
    }
    static function deleteCommentSpice($commentid) {
        global $serendipity;
        
        if (empty($commentid) || !is_numeric($commentid)) return;
        $sql = "DELETE FROM {$serendipity['dbPrefix']}commentspice WHERE commentid=$commentid";
        return serendipity_db_query($sql, true);
    }
}