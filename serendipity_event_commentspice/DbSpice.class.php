<?php
@define('PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG', 'spicedb');

class DbSpice {
    function table_created($table = 'tweetbackhistory')  {
        global $serendipity;

        $q = "select count(*) from {$serendipity['dbPrefix']}" . $table;
        $row = serendipity_db_query($q, true, 'num');

        if (!is_numeric($row[0])) {        // if the response we got back was an SQL error.. :P
            return false;
        } else {
            return true;
        }
    }
    
    function install(&$obj) {
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
    }
    
    function saveCommentSpice($commentid, $twittername) {
        global $serendipity;
        if (empty($commentid) || empty($twittername) || !is_numeric($commentid)) return true;
        
        $sql = "INSERT INTO {$serendipity['dbPrefix']}commentspice (commentid, twittername) ";
        $sql .= " VALUES ($commentid, '$twittername')";
        return serendipity_db_query($sql);
    }
    
    function loadCommentSpice($commentid) {
        global $serendipity;
        if (empty($commentid) || !is_numeric($commentid)) return false;
        
        $sql = "SELECT * FROM {$serendipity['dbPrefix']}commentspice WHERE commentid=$commentid";
        $row = serendipity_db_query($sql, true);
        if (!is_array($row)) return false;
        return $row;
    }
    function deleteCommentSpice($commentid) {
        global $serendipity;
        
        if (empty($commentid) || !is_numeric($commentid)) return;
        $sql = "DELETE FROM {$serendipity['dbPrefix']}commentspice WHERE commentid=$commentid";
        return serendipity_db_query($sql, true);
    }
}