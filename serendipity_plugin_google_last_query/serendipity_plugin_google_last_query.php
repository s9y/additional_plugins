<?php # 

// Google Last Query Plugin for Serendipity
// 10/2004 by Thomas Nesges <thomas@tnt-computer.de>


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

include_once dirname(__FILE__) . '/engines_config.inc.php';

@define ('SERENDIPITY_PLUGIN_GOOGLE_LAST_QUERY_REF', "select scheme, host, path, query, day, count from {$serendipity['dbPrefix']}referrers where ");
@define ('SERENDIPITY_PLUGIN_GOOGLE_LAST_QUERY_VIS', "select day,time,ref from {$serendipity['dbPrefix']}visitors where ");

class serendipity_plugin_google_last_query extends serendipity_plugin {

    var $cache_prefix = null;
    var $iconpath = '';
    var $showicons = false;
    var $showtime = false;
    var $showentries = true;
    var $showstats = false;
    
    var $selected_engines = array();
    
    function introspect(&$propbag) {
        $propbag->add('name',           PLUGIN_GOOGLE_LAST_QUERY_TITLE);
        $propbag->add('description',    PLUGIN_GOOGLE_LAST_QUERY_DESC);
        $propbag->add('version',        '1.18.2');
        $propbag->add('stackable',      true);

        if ($this->isVisitorsTableFilled()) {
            $propbag->add('configuration',  array(
            'title', 
            'count',
            'googlelink_newwindow',
            'use_visitors', 
            'show_auth_only',
            'show_icons',
            'show_time',
            'show_entries',
            'show_stats',
            'stat_days',
            'cache_mins',
            'plugin_http_path',
            'engines'
            ));
        }
        else {
            $propbag->add('configuration',  array(
            'title', 
            'count',
            'googlelink_newwindow',
            'show_auth_only',
            'show_icons',
            'show_time',
            'show_entries',
            'show_stats',
            'stat_days',
            'cache_mins',
            'plugin_http_path',
            'engines'
            ));
        }
        $propbag->add('author', 'Garvin Hicking, Grischa Brockhaus');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'title':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_GOOGLE_LAST_QUERY_PROP_TITLE);
                $propbag->add('description',    PLUGIN_GOOGLE_LAST_QUERY_PROP_TITLE_DESC);
                $propbag->add('default',        PLUGIN_GOOGLE_LAST_QUERY_TITLE);
                break;

            case 'count':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_GOOGLE_LAST_QUERY_PROP_COUNT);
                $propbag->add('description',    PLUGIN_GOOGLE_LAST_QUERY_PROP_COUNT_DESC);
                $propbag->add('default',        '5');
                break;

            case 'use_visitors':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_GOOGLE_LAST_QUERY_PROP_VISITORTABLE);
                $propbag->add('description',    PLUGIN_GOOGLE_LAST_QUERY_PROP_VISITORTABLE_DESC);
                $propbag->add('default',        false);
                break;

            case 'googlelink_newwindow':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_GOOGLE_LAST_QUERY_PROP_NEWWINDOW);
                $propbag->add('description',    PLUGIN_GOOGLE_LAST_QUERY_PROP_NEWWINDOW_DESC);
                $propbag->add('default',        false);
                break;
                
            case 'show_time':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_TIME);
                $propbag->add('description',    PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_TIME_DESC);
                $propbag->add('default',        false);
                break;
                
            case 'show_icons':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_ICONS);
                $propbag->add('description',    PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_ICONS_DESC);
                $propbag->add('default',        false);
                break;

            case 'show_entries':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_ENTRIES);
                $propbag->add('description',    PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_ENTRIES_DESC);
                $propbag->add('default',        true);
                break;
            
            case 'show_stats':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_STATS);
                $propbag->add('description',    PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_STATS_DESC);
                $propbag->add('default',        false);
                break;
            
            case 'stat_days':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_GOOGLE_LAST_QUERY_PROP_STATDAYS);
                $propbag->add('description',    PLUGIN_GOOGLE_LAST_QUERY_PROP_STATDAYS_DESC);
                $propbag->add('default',        '7');
                break;

            case 'cache_mins':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_GOOGLE_LAST_QUERY_PROP_CACHEMINS);
                $propbag->add('description',    PLUGIN_GOOGLE_LAST_QUERY_PROP_CACHEMINS_DESC);
                $propbag->add('default',        '5');
                break;

            case 'show_auth_only':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_AUTHONLY);
                $propbag->add('description',    PLUGIN_GOOGLE_LAST_QUERY_PROP_SHOW_AUTHONLY_DESC);
                $propbag->add('default',        false);
                break;
            
            case 'plugin_http_path':
                $propbag->add('type', 'string');
                $propbag->add('name',           PLUGIN_GOOGLE_LAST_QUERY_PROP_HTTPREL);
                $propbag->add('description',    PLUGIN_GOOGLE_LAST_QUERY_PROP_HTTPREL_DESC);
                $propbag->add('default', '/plugins/serendipity_plugin_google_last_query');
                break;

            case 'engines':
                $propbag->add('type',           'multiselect');
                $propbag->add('name',           PLUGIN_GOOGLE_LAST_QUERY_PROP_ENGINES);
                $propbag->add('description',    PLUGIN_GOOGLE_LAST_QUERY_PROP_ENGINES_DESC);
                $propbag->add('select_values',  $this->selectEngines());
                $propbag->add('default',        'Google');
                break;


            default:
                return false;
        }
        return true;
    }

    function cleanup() {
        // clean up the cache after changing configuration
        $result = @unlink($this->get_cache_prefix() . "_ref_list");
        $result = @unlink($this->get_cache_prefix() . "_vis_list");
        $result = @unlink($this->get_cache_prefix() . "_ref_count");
        $result = @unlink($this->get_cache_prefix() . "_vis_count");
    } 

    function selectEngines(){
        global $serendipity_plugin_google_last_query_engines;
        
    	$result = array();
        foreach ($serendipity_plugin_google_last_query_engines as $name) {
        	$result[$name] = $name;
        }
        return $result;
    }
    
    /**
     * The visitors table is created and filled by the statistics plugin. This will test,
     * if this plugin is installed and not hidden. 
     */
    function isVisitorsTableFilled(){
        return class_exists('serendipity_event_statistics');
    }
    
    function generate_content(&$title) {

        // Display nothing, if not authentificated (and this option was enabled)
        if (serendipity_db_bool($this->get_config('show_auth_only')) && !$_SESSION['serendipityAuthedUser']) {
            return false;
        }
        
        // TODO: How do I clean get an multiselect option?!
        // Find selected engines.
        $this->selected_engines = explode('^',$this->get_config('engines'));
        
        $title = $this->get_config('title');
        $count = $this->get_config('count', 1);
        $newwindow = serendipity_db_bool($this->get_config('googlelink_newwindow'));
        $this->showicons = serendipity_db_bool($this->get_config('show_icons'));
        $this->showtime = serendipity_db_bool($this->get_config('show_time'));
        $this->showentries = serendipity_db_bool($this->get_config('show_entries'), true);
        $this->showstats = serendipity_db_bool($this->get_config('show_stats'));
        
        if(!is_numeric($count) || $count<1) {
            $count = 1;
        }

        $this->iconpath = $this->get_config('plugin_http_path','/plugins/serendipity_plugin_google_last_query') . '/icons/';
        
        if (serendipity_db_bool($this->get_config('use_visitors')) && $this->isVisitorsTableFilled()){
            $this->generate_content_by_vistors_table($count, $newwindow);
        }
        else {
            $this->generate_content_by_referrers_table($count, $newwindow);
        }

    }
    
    function query_references() {
        global $serendipity_plugin_google_last_query_ref_search;
        
        // Dynamically build query
        $whereclauses = array();
        foreach ($this->selected_engines as $engine) {
            $whereclauses[] = $serendipity_plugin_google_last_query_ref_search[$engine];
        }
        $query .= SERENDIPITY_PLUGIN_GOOGLE_LAST_QUERY_REF . " (" . implode(' OR ', $whereclauses) . ")";
        return $query;
    }

    function query_visitors() {
        global $serendipity_plugin_google_last_query_vis_search;
        
        // Dynamically build query
        $whereclauses = array();
        foreach ($this->selected_engines as $engine) {
            $whereclauses[] = $serendipity_plugin_google_last_query_vis_search[$engine];
        }
        $query .= SERENDIPITY_PLUGIN_GOOGLE_LAST_QUERY_VIS . " (" . implode(' OR ', $whereclauses) . ")";
    	return $query;
    }
    
    /*
     * Generates google searches by the referrers table. 
     * This is the old functionality, that only fetches
     * searches that where executed a couple of times
     * (whatever that means..)
     * 
     * @access private
     */
    function generate_content_by_referrers_table($count, $newwindow){
        global $serendipity;
        global $serendipity_plugin_google_last_query_engine_configuration;
        
        if ($this->showentries) {
            $cache_file = $this->get_cache_prefix() . "_ref_list";
            $rows = array();
            
            if ($this->get_cache_seconds()==0 || !file_exists($cache_file) || time() - filemtime($cache_file) > $this->get_cache_seconds()) {
                $query .= $this->query_references() . "order by day desc, count asc limit $count";
                $rows = serendipity_db_query($query);
                $this->save_cache($cache_file, $rows);
            }
            else {
            	$rows = $this->load_cache($cache_file);
            }
    
            if (!is_array($rows)) {
                return true;
            }
    
            $target = "";
            if ($newwindow) $target=' target="_blank"';
            
            foreach($rows as $row) {
    
                $time_title = '';
                if ($this->showtime) $time_title = ' title="' . $row[4] . ' (' . $row[5] . 'x)"'; 
                
                foreach ($this->selected_engines as $selected) {
                    $engine = $serendipity_plugin_google_last_query_engine_configuration[$selected];
                	if (preg_match("/.*?" . $engine[0] . ".*?/",$row[1]) && preg_match("/(" . $engine[1] . ")=(.*?)(&|$)/", $row[3], $matches)) {
                        $search_query = $matches[2];
                        $url_prot = $row[0];
                        $url_host = $row[1];
                        $url_dir = $row[2];
                        $url_qpar = $engine[2];
                        $this->echo_referrers($selected, $search_query, $url_prot, $url_host, $url_dir, $url_qpar, $target, $time_title);
                    }
                }
            }
        }
             
        $this->generate_stats_by_referrers_table();
    }
    
    /*
     * Generates google searches by the vistors table. 
     * The advantage in using the visitors table is that 
     * we get all google searches instead of these used 
     * a couple of times.
     * 
     * @access private
     */
    function generate_content_by_vistors_table($count, $newwindow){
        global $serendipity;
        global $serendipity_plugin_google_last_query_engine_configuration;

        if ($this->showentries) {
            $cache_file = $this->get_cache_prefix() . "_vis_list";
            $rows = array();
    
            if ($this->get_cache_seconds()==0 || !file_exists($cache_file) || time() - filemtime($cache_file) > $this->get_cache_seconds()) {
                $query .= $this->query_visitors() . "order by day desc,time desc limit $count";
                $rows = serendipity_db_query($query);
                $this->save_cache($cache_file, $rows);
            }
            else {
                $rows = $this->load_cache($cache_file);
            }
    
            if (!is_array($rows)) {
                // Fallback, if error on visitors table sql
                return $this->generate_content_by_referrers_table($count, $newwindow);
            }
            
            $target = "";
            if ($newwindow) $target=' target="_blank"';
            
            foreach($rows as $row) {
    
                $time_title = '';
                if ($this->showtime) $time_title = ' title="' . $row[0] . ' (' . $row[1] . ')"'; 
    
                foreach ($this->selected_engines as $selected) {
                    $engine = $serendipity_plugin_google_last_query_engine_configuration[$selected];
                    if (preg_match("/.*?" . $engine[0] . ".*?(\?|&)(" . $engine[1] . ")=(.*?)(&|$)/si", $row[2], $matches)) {
                        $search_query = $matches[3];
                        $url_path = $row[2];
                        $url_qpar = '?' . $engine[2] . '=';
                        $this->echo_visitors($selected, $search_query, $url_path, $url_qpar, $target, $time_title);
                    } 
                }
    
            }
        }
        
        $this->generate_stats_by_visitors_table();
    }

    function generate_stats_by_referrers_table(){
        global $serendipity;
        global $serendipity_plugin_google_last_query_engine_configuration;

        if (!$this->showstats) return;

        $cache_file = $this->get_cache_prefix() . "_ref_count";
        $rows = array();
        
        if ($this->get_cache_seconds()==0 || !file_exists($cache_file) || time() - filemtime($cache_file) > $this->get_cache_seconds()) {
            $statdays = $this->get_config('stat_days', 7);
            if(!is_numeric($statdays) || $statdays<1) {
                $statdays = 7;
            }
            
            $lastWeek = time() - ($statdays * 24 * 60 * 60);
            $comparator = date('Y-m-d', $lastWeek);
    
    
            $query .= $this->query_references() . "AND day >= '$comparator'";
    
            $rows = serendipity_db_query($query);
            $this->save_cache($cache_file, $rows);
        }
        else {
            $rows = $this->load_cache($cache_file);
        }
        
        foreach ($this->selected_engines as $selected) {
            $result[$selected] = 0;
        }
        
        if (is_array($rows)) {
        foreach($rows as $row) {
            foreach ($this->selected_engines as $selected) {
                $engine = $serendipity_plugin_google_last_query_engine_configuration[$selected];
                if (preg_match("/.*?" . $engine[0] . ".*?/",$row[1]) && preg_match("/(" . $engine[1] . ")=(.*?)(&|$)/", $row[3], $matches)) {
                    $result[$selected]+=$row[5];
                }
            }
        }
        }
        
        $this->echo_stats( $result );
    }
    
    function generate_stats_by_visitors_table(){
        global $serendipity;
        global $serendipity_plugin_google_last_query_engine_configuration;

        if (!$this->showstats) return;
        
        $cache_file = $this->get_cache_prefix() . "_vis_count";
        $rows = array();
        
        if ($this->get_cache_seconds()==0 || !file_exists($cache_file) || time() - filemtime($cache_file) > $this->get_cache_seconds()) {
            $statdays = $this->get_config('stat_days', 7);
            if(!is_numeric($statdays) || $statdays<1) {
                $statdays = 7;
            }
            
            $lastWeek = time() - ($statdays * 24 * 60 * 60);
            $comparator = date('Y-m-d', $lastWeek);
    
            $query .= $this->query_visitors() . "AND day >= '$comparator'";
    
            $rows = serendipity_db_query($query);
            $this->save_cache($cache_file, $rows);
        }
        else {
            $rows = $this->load_cache($cache_file);
        }
        
        foreach ($this->selected_engines as $selected) {
            $result[$selected] = 0;
        }
        
        if (is_array($rows)) {
            foreach($rows as $row) {
                foreach ($this->selected_engines as $selected) {
                    $engine = $serendipity_plugin_google_last_query_engine_configuration[$selected];
                    if (preg_match("/.*?" . $engine[0] . ".*?(\?|&)(" . $engine[1] . ")=(.*?)(&|$)/si", $row[2], $matches)) {
                        $result[$selected]++;
                    }
                }
            }
        }
        
        $this->echo_stats( $result );
    }

    function echo_stats( $result ) {
        
        if (!is_array($result)) return;
        
        arsort($result);
        
        echo '<div class="serendipity_plugin_google_last_query_stats">';
        foreach ($result as $key => $val) {
            if (!empty($result[$key]) && $val>0) {
            	$this->show_icon($key);
                echo " " . $val . '<br/>';
            }
        }
        echo '</div>';
    }
    
    function echo_referrers($search_engine, $search_query, $url_prot, $url_host, $url_dir, $url_qpar, $target, $time_title) {
        $this->show_icon($search_engine);
        if (LANG_CHARSET != 'UTF-8') {
            $out = utf8_decode(urldecode($search_query));
        } else {
            $out = urldecode($search_query);
        }
        echo "<a rel=\"nofollow\"$time_title href='". $url_prot . "://" . (function_exists('serendipity_specialchars') ? serendipity_specialchars($url_host . $url_dir) : htmlspecialchars($url_host . $url_dir, ENT_COMPAT, LANG_CHARSET)) . "?$url_qpar=" . urlencode((function_exists('serendipity_specialchars') ? serendipity_specialchars($out) : htmlspecialchars($out, ENT_COMPAT, LANG_CHARSET))) . "'" . $target . ">" . (function_exists('serendipity_specialchars') ? serendipity_specialchars($out) : htmlspecialchars($out, ENT_COMPAT, LANG_CHARSET)) ."</a><br />\n";
    }
    
    function echo_visitors($search_engine, $search_query, $url_path, $url_qpar, $target, $time_title) {
        $this->show_icon($search_engine);
        if (LANG_CHARSET != 'UTF-8') {
            $out = utf8_decode(urldecode($search_query));
        } else {
            $out = urldecode($search_query);
        }
        preg_match("/(http:.*?)\?/", $url_path, $hostmatches);
        $host = $hostmatches[1];
        
        $url = (function_exists('serendipity_specialchars') ? serendipity_specialchars($host . $url_qpar . $search_query) : htmlspecialchars($host . $url_qpar . $search_query, ENT_COMPAT, LANG_CHARSET));
        echo "<a rel=\"nofollow\" href='" . $url . "'" . $target . $time_title . ">" . (function_exists('serendipity_specialchars') ? serendipity_specialchars($out) : htmlspecialchars($out, ENT_COMPAT, LANG_CHARSET)) . "</a><br />\n";
    }
    
    function show_icon($search_engine) {
        if ($this->showicons) {
            $png_name = strtolower($search_engine) . '.png';
            echo '<img src="' . $this->iconpath . $png_name . '" alt="' . $search_engine . '" title="' . $search_engine . '" height="16" width="16"> ';
        }
    	
    }
    
    function get_cache_prefix(){
        global $serendipity;
        if (empty($this->cache_prefix)) {

            $instance_id = $this->instance;
            $idParts = explode(':', $instance_id);
            $id = $idParts[1];

            $this->cache_prefix = $serendipity['serendipityPath'] . PATH_SMARTY_COMPILE . '/serendipity_plugin_google_last_query_' . $id;
        }
        return $this->cache_prefix;        
    }
    
    function save_cache($cache_file, $what) {
        if ($fp = @fopen($cache_file, 'wb')) {
            fwrite($fp, serialize($what));
            fclose($fp);
        }
    }
    
    function load_cache($cache_file) {
        $result = null;
        if ($fp = fopen($cache_file, 'rb')) {
            $result = unserialize(fread($fp, filesize($cache_file)));
            fclose($fp);
        }
        return $result;
    }
    
    function get_cache_seconds() {
        $cache_mins = $this->get_config('cache_mins', 5);
        if(!is_numeric($cache_mins) || $cache_mins<1) {
            $cache_mins = 5;
        }
        return $cache_mins * 60;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>