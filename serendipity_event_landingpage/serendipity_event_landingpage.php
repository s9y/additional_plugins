<?php # $Id: serendipity_event_statistics.php 2427 2009-01-15 15:31:53Z garvinhicking $

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';
   
class serendipity_event_landingpage extends serendipity_event
{
    var $title = PLUGIN_EVENT_LANDINGPAGE_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_LANDINGPAGE_NAME);
        $propbag->add('description',   PLUGIN_EVENT_LANDINGPAGE_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Grischa Brockhaus');
        $propbag->add('version',       '0.05');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
        $propbag->add('event_hooks',    array(
            'entries_header' => true
        ));

        //$propbag->add('configuration', array('max_items','ext_vis_stat','stat_all','banned_bots'));
    }

    function introspect_config_item($name, &$propbag)
    {
    }

    function event_hook($event, &$bag, &$eventData) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'entries_header':
                    $this->showLandingPage();
                    return true;
                    break;
            }
        }
        
        return true;
        
    }
    
    function showLandingPage(){
        global $serendipity;
        
        if ($_SERVER['HTTP_REFERER']) {

            $engineNames = $this->loadSearchEngines();
            
            $filename = 'landingpage.tpl';
            $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
            if (!$tfile || $tfile == $filename) {
                $tfile = dirname(__FILE__) . '/' . $filename;
            }

            $this->uri = $_SERVER['HTTP_REFERER'];
            $searchengine = $this->getSearchEngine();

            print("\n<!-- REF: {$this->uri} -->\n");
            print("<!-- SEN: " . $engineNames[$searchengine] . " -->\n");
            print("<!-- SEN: $searchengine -->\n");
            if ( ($queries = $this->getQuery()) !== false ) {
                foreach ($queries as $query) {
                    print("<!-- QER: $query -->\n");
                }
                $searchquery = implode(" ",$queries);
            }

        }
        else {
            print("\n<!-- REF: direct-->\n");
        }
        
        serendipity_smarty_init();
        $serendipity['smarty']->assign(array(
            'landingpage_referer'           => $this->uri,
            'landingpage_searchengine_nr'   => $searchengine,
            'landingpage_searchengine_name' => $engineNames[$searchengine],
            'landingpage_search_query'      => $searchquery,
        ));

        $inclusion = $serendipity['smarty']->security_settings[INCLUDE_ANY];
        $serendipity['smarty']->security_settings[INCLUDE_ANY] = true;
        $serendipity['smarty']->display($tfile);

    }

    function loadSearchEngines() {
        define('PLUGIN_EVENT_LANDINGPAGE_NONE', 0);
        define('PLUGIN_EVENT_LANDINGPAGE_GOOGLE', 1);
        define('PLUGIN_EVENT_LANDINGPAGE_YAHOO', 2);
        define('PLUGIN_EVENT_LANDINGPAGE_LYCOS', 3);
        define('PLUGIN_EVENT_LANDINGPAGE_MSN', 4);
        define('PLUGIN_EVENT_LANDINGPAGE_ALTAVISTA', 5);
        define('PLUGIN_EVENT_LANDINGPAGE_AOL_DE', 6);
        define('PLUGIN_EVENT_LANDINGPAGE_AOL_COM', 7);
        define('PLUGIN_EVENT_LANDINGPAGE_SCROOGLE', 8);

        return array(
            PLUGIN_EVENT_LANDINGPAGE_NONE       => "none",
            PLUGIN_EVENT_LANDINGPAGE_GOOGLE     => "google",
            PLUGIN_EVENT_LANDINGPAGE_YAHOO      => "yahoo",
            PLUGIN_EVENT_LANDINGPAGE_LYCOS      => "lycos",
            PLUGIN_EVENT_LANDINGPAGE_MSN        => "msn",
            PLUGIN_EVENT_LANDINGPAGE_ALTAVISTA  => "altavista",
            PLUGIN_EVENT_LANDINGPAGE_AOL_DE     => "aol.de",
            PLUGIN_EVENT_LANDINGPAGE_AOL_COM    => "aol.com",
            PLUGIN_EVENT_LANDINGPAGE_SCROOGLE   => "scroogle",
        );
    }

    function getSearchEngine() {
        $url = parse_url($this->uri);

        /* Patterns should be placed in the order in which they are most likely to occur */
        if ( preg_match('@^(www\.)?google\.@i', $url['host']) ) {
            return PLUGIN_EVENT_LANDINGPAGE_GOOGLE;
        }
        if ( preg_match('@^search\.yahoo\.@i', $url['host']) ) {
            return PLUGIN_EVENT_LANDINGPAGE_YAHOO;
        }
        if ( preg_match('@^search\.lycos\.@i', $url['host']) ) {
            return PLUGIN_EVENT_LANDINGPAGE_LYCOS;
        }
        if ( preg_match('@^search\.msn\.@i', $url['host']) ) {
            return PLUGIN_EVENT_LANDINGPAGE_MSN;
        }
        if ( preg_match('@^(www\.)?altavista\.@i', $url['host']) ) {
            return PLUGIN_EVENT_LANDINGPAGE_ALTAVISTA;
        }
        if ( preg_match('@^suche\.aol\.de@i', $url['host']) ) {
            return PLUGIN_EVENT_LANDINGPAGE_AOL_DE;
        }
        if ( preg_match('@^search\.aol\.com@i', $url['host']) ) {
            return PLUGIN_EVENT_LANDINGPAGE_AOL_COM;
        }
        if ( preg_match('@^(www\.)?google\.@i', $url['host']) ) {
            return PLUGIN_EVENT_LANDINGPAGE_GOOGLE;
        }
        if ( preg_match('@^(www\.)?scroogle\.@i', $url['host']) ) {
            return PLUGIN_EVENT_LANDINGPAGE_SCROOGLE;
        }
        
        /*
        if (!empty($_SESSION['search_referer']) && $this->uri != $_SESSION['search_referer']) {
            $this->uri = $_SESSION['search_referer'];
            return $this->getSearchEngine();
        }

        if ($url['host'] == $_SERVER['HTTP_HOST']) {
            return PLUGIN_EVENT_LANDINGPAGE_S9Y;
        }
        */

        return false;
    }
    
    function getQuery() {
        if ( empty($this->uri) ) {
            return false;
        }

        //$this->loadConstants();
        $url = parse_url($this->uri);
        
        parse_str($url['query'], $pStr);

        $s = $this->getSearchEngine();
        
        switch ( $s ) {
            case PLUGIN_EVENT_LANDINGPAGE_S9Y:
                $query = $pStr['serendipity']['searchTerm'];
                
                if (!empty($_REQUEST['serendipity']['searchTerm'])) {
                    $query = $_REQUEST['serendipity']['searchTerm'];
                }
                break;

            case PLUGIN_EVENT_LANDINGPAGE_GOOGLE :
                $query = $pStr['q'];
                break;

            case PLUGIN_EVENT_LANDINGPAGE_YAHOO :
                $query = $pStr['p'];
                break;

            case PLUGIN_EVENT_LANDINGPAGE_LYCOS :
                $query = $pStr['query'];
                break;

            case PLUGIN_EVENT_LANDINGPAGE_MSN :
                $query = $pStr['q'];
                break;

            case PLUGIN_EVENT_LANDINGPAGE_ALTAVISTA :
                $query = $pStr['q'];
                break;

            case PLUGIN_EVENT_LANDINGPAGE_AOL_DE :
                $query = $pStr['q'];
                break;

            case PLUGIN_EVENT_LANDINGPAGE_AOL_COM :
                $query = $pStr['query'];
                break;

            default:
                if ($_REQUEST['serendipity']['searchTerm'] != '') {
                    $query = $_REQUEST['serendipity']['searchTerm'];
                } else {
                    return false;
                }
        }

        /* Clean the query */
        $query = trim($query);
        if (empty($query)) return false;
        $query = preg_replace('/(\"|\')/i', '', $query);

        /* Split by search engine chars or spaces */
        $words = preg_split('/[\s\,\+\.\-\/\=]+/', $query);

        /* Strip search engine keywords or common words we don't bother to highlight */
        $words = array_diff($words, array('AND', 'OR', 'FROM', 'IN'));

        return $words;
    }


}