<?php
/*
 * Created on 26.06.2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
class TwitterPluginDbAccess {

    static function save_highest_id($article_id, $highest_id, $last_info) {
        global $serendipity;
        
        $now = time();
        if ($last_info == null) { // fresh search
            $update = "INSERT INTO {$serendipity['dbPrefix']}tweetbackhistory (entryid, lasttweetid, lastcheck) ";
            $update .= " VALUES ($article_id, '$highest_id', $now)";
        }
        else {
            $update = "UPDATE {$serendipity['dbPrefix']}tweetbackhistory SET lasttweetid='$highest_id',  lastcheck=$now";
            $update .= " WHERE entryid=$article_id";
        }
        serendipity_db_query($update);
    }
    
    static function find_highest_twitterid() {
        global $serendipity;
        $query = "SELECT lasttweetid FROM {$serendipity['dbPrefix']}tweetbackhistory";
        $rows = serendipity_db_query($query);
        if (!is_array($rows)) return "0";
        $highest_id = "0";
        foreach($rows as $row) {
            $id = $row['lasttweetid'];
            if ("$id" > "$highest_id") $highest_id = "$id";
        } 
        return $highest_id;
    }

    static function load_tweetback_info($article_id, $obj = '') {
        global $serendipity;

        // Assure, all tables exist!
        TwitterPluginDbAccess::install($obj);
        
        $query = "SELECT lasttweetid, lastcheck FROM {$serendipity['dbPrefix']}tweetbackhistory WHERE entryid=$article_id";
        
        $row = serendipity_db_query($query, true);
        if (!is_array($row)) { // fresh search
            return null;
        }
        else {
            return $row;
        }
    }

    static function load_short_urls( $article_url, $selected_services ) {
        global $serendipity;
        
        $inservices = "'" . implode("','", $selected_services) . "'";
        $query = "select service, shorturl from {$serendipity['dbPrefix']}tweetbackshorturls where longurl like '$article_url'";
        $query .= " and service in ($inservices)";

        $rows = serendipity_db_query($query);
        if (!is_array($rows)) { // fresh search
            return array();
        }
        else {
            $shorturls = array();
            foreach ($rows as $row) {
                $shorturl = $row['shorturl'];
                if (preg_match('/^http/', $shorturl)) { // Ignore trash entries (old cli.gs for example or error messages)
                    $shorturls[$row['service']] = $row['shorturl'];
                }
            }
            // Add raw urls, as they are not saved anymore
            $shorturls['raw'] = $article_url;
            
            return $shorturls;
        }
    }
    
    static function save_short_urls( $article_url, $shorturls, $loaded_shorturls = array() ) {
        global $serendipity;

        // insert all new (not yet known) shorturls.
        foreach ($shorturls as $service => $shorturl) {
            if ('raw'==$service) continue; // don't save raw, table can't hold it.
            $shorturl = trim($shorturl);
            if (empty($shorturl)) continue; // something whent wrong while fetching shorturls
            if (empty($loaded_shorturls[$service])) {
                // Save only valid short urls!
                if (preg_match('/^http/', $shorturl)) {
                    $query = "insert into {$serendipity['dbPrefix']}tweetbackshorturls (service,longurl,shorturl) VALUES ('$service','$article_url','$shorturl')";
                }
                serendipity_db_query($query);
            }
        }
    }

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

        if ((int)$obj->get_config('tweetbackhistory_v') < 1) {
            $obj->set_config('tweetbackhistory_v', 2);
            serendipity_db_query("ALTER TABLE {$serendipity['dbPrefix']}tweetbackhistory CHANGE lasttweetid lasttweetid varchar(20) not null");
        }

        if (!TwitterPluginDbAccess::table_created('tweetbackhistory')) {
            $q = "create table {$serendipity['dbPrefix']}tweetbackhistory (" .
                    "entryid int(10) not null, " .
                    "lasttweetid varchar(20) not null, " .
                    "lastcheck int(10) not null, " .
                    "primary key (entryid)" .
                ")";

            $result = serendipity_db_schema_import($q);

            if ($result !== true) {
                return;
            }
        }
        
        if (!TwitterPluginDbAccess::table_created('tweetbackshorturls')) {
            $q = "create table {$serendipity['dbPrefix']}tweetbackshorturls (" .
                    "service varchar(15) not null, " .
                    "longurl varchar(255) not null, " .
                    "shorturl varchar(50) not null, " .
                    "primary key (service, longurl)" .
                ")";

            $result = serendipity_db_schema_import($q);

            if ($result !== true) {
                return;
            }

            serendipity_db_schema_import("CREATE INDEX idx_tweetbackshorturls_longurl ON {$serendipity['dbPrefix']}tweetbackshorturls (longurl(191))");
            serendipity_db_schema_import("CREATE INDEX idx_tweetbackshorturls_service ON {$serendipity['dbPrefix']}tweetbackshorturls (service)");

        }
        
        // Clear old wrong entries!
        $q = "delete from {$serendipity['dbPrefix']}tweetbackshorturls where shorturl LIKE 'Error'";
        $row = serendipity_db_query($q, true, 'num');
    }
    
    static function entry_deleted($entryid) {
        global $serendipity;
        $q = "delete from {$serendipity['dbPrefix']}tweetbackhistory where entryid=$entryid";
        serendipity_db_schema_import($q);
    }
}
?>
