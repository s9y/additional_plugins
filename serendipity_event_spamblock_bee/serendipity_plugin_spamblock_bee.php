<?php
// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}
include dirname(__FILE__) . '/lang_en.inc.php';
include dirname(__FILE__) . '/version.inc.php';

class serendipity_plugin_spamblock_bee extends serendipity_plugin {
    var $title = PLUGIN_SPAMBLOCK_BEE_TITLE;
    var $cache_file                 = null;
    
    
    function introspect(&$propbag) {
        $this->title = $this->get_config('title', $this->title);

        $propbag->add('name',          PLUGIN_SPAMBLOCK_BEE_TITLE);
        $propbag->add('description',   PLUGIN_SPAMBLOCK_BEE_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Grischa Brockhaus');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
            ));

        $propbag->add('version',       PLUGIN_SPAMBLOCK_BEE_VERSION); // setup via version.inc.php
            
        $propbag->add('groups', array('STATISTICS'));

        $configuration = array('title', 'db_search_pattern', 'days', 'loggedin_only', 'cachemin');

        $propbag->add('configuration', $configuration );
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch($name) {
            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        TITLE);
                $propbag->add('description', TITLE_FOR_NUGGET);
                $propbag->add('default',     PLUGIN_SPAMBLOCK_BEE_TITLE);
                break;
            case 'days':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_SPAMBLOCK_BEE_DAYS);
                $propbag->add('description',    PLUGIN_SPAMBLOCK_BEE_DAYS_DESC);
                $propbag->add('default','1,7,30');
                break;        
            case 'db_search_pattern':
                $propbag->add('type',           'text');
                $propbag->add('name',           PLUGIN_SPAMBLOCK_BEE_DBSEARCHES);
                $propbag->add('description',    PLUGIN_SPAMBLOCK_BEE_DBSEARCHES_DESC);
                $propbag->add('rows', 4);
                $propbag->add('default',        
'Honepot:BEE Honeypot%
HiddenCaptcha:BEE HiddenCaptcha%
Bayes:%Bayes%'
                );
                break;
            case 'cachemin':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_SPAMBLOCK_BEE_CACHEMINS);
                $propbag->add('description',    PLUGIN_SPAMBLOCK_BEE_CACHEMINS_DESC);
                $propbag->add('default','10'); // 10min
                break;        
            case 'loggedin_only':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_SPAMBLOCK_BEE_LOGGEDIN);
                $propbag->add('description',    PLUGIN_SPAMBLOCK_BEE_LOGGEDIN_DESC);
                $propbag->add('default',		true);
                break;
            default:
                return false;
        }
        return TRUE;
    }
    
    function generate_content(&$title) {
        global $serendipity;
        
        if (serendipity_db_bool($this->get_config('loggedin_only', TRUE))) {
            // show content if logged on only
            if ($_SESSION['serendipityAuthedUser'] != true) return;
        }
        
        $title = $this->get_config('title', $this->title);
        
        $stats = $this->loadCachedStats();
        if (empty($stats)) {
            $stats = "";
            
            $sql = "SELECT COUNT(*) as total FROM {$serendipity['dbPrefix']}spamblocklog WHERE reason like '%s' and timestamp>%d;";
            $days = explode(',', $this->get_config('days'));
            $searches = explode("\n", $this->get_config('db_search_pattern'));
            
            $todayAtMidnight = mktime(0,0,0, date("n"), date("j"), date("Y"));
            //echo "today: $todayAtMidnight<br>";
            
            $timestampDay = 60 * 60 * 24;
            //echo "diffDay: $timestampDay<br>";
            foreach ($days as $day) {
                $timestamp = $todayAtMidnight - ($timestampDay * (trim($day) -1));
                if ($day==1) {
                    $stats .= "<b>Heute:</b> <br>";
                }   
                else { 
                    $stats .= "<b>Die letzen $day Tage:</b> <br>";
                }
                //echo "ts: $timestamp<br>";
                foreach ($searches as $search) {
                    $singleSearch = explode(':', $search,2);
                    $singleSql = sprintf($sql, trim($singleSearch[1]), $timestamp);
                    $result = serendipity_db_query($singleSql,TRUE);
                    if (!empty($result['total'])) {
                        $stats .= "{$singleSearch[0]}: {$result['total']}<br/>";
                    }
                }
            }
            $this->cacheStats($stats);
        }
        echo $stats;
    }
    
    function loadCachedStats() {
        $cacheFile = $this->getCacheFilename();
        $cachesecs = $this->get_config('cachemin', '10') * 60;
        if (file_exists($cacheFile)  && (time() - filemtime($cacheFile) < $cachesecs)) {
            $stats = "";
            $fh = fopen($cacheFile,'r');
            while (!feof($fh)){
              $stats .= fgets($fh);
            }
            fflush($fh);
            fclose($fh);
            return $stats;
        }
        return null;
    }
    function cacheStats($stats) {
        $cacheFile = $this->getCacheFilename();
        $fh = fopen($cacheFile, 'w');
        fputs($fh, $stats, strlen($stats));
        fclose($fh);
    }
    
    /**
     * Returns the cache file name
     */
    function getCacheFilename(){
        global $serendipity;
        if ($this->cache_file === null) {
            $this->cache_file = $serendipity['serendipityPath'] . PATH_SMARTY_COMPILE . '/serendipity_plugin_spamblog_bee';
        }
        return $this->cache_file;        
    }
    
    function cleanup() {
        $cacheFile = $this->getCacheFilename();
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }
    }
    
}