<?php


@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_piwik extends serendipity_plugin
{
    public $title = PLUGIN_SIDEBAR_PIWIK_NAME;
    protected $token;
    protected $url;
    protected $live_show;
    protected $live_title;
    protected $live_minutes;
    protected $entries_show;
    protected $entries_title;
    protected $entries_days;
    protected $entries_max;
    protected $entries_remove;
    protected $debug;
    protected $dependencies;

    /**
     * @param serendipity_property_bag $propbag
     * @return void
     */
    public function introspect(&$propbag)
    {
        $this->title = $this->get_config('title', $this->title);
        $propbag->add('name',          PLUGIN_SIDEBAR_PIWIK_NAME);
        $propbag->add('description',   PLUGIN_SIDEBAR_PIWIK_DESC);
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Bernd Distler');
        $propbag->add('version',       '0.4.3');
        $propbag->add('requirements',  array(
            'serendipity' => '1.6',
            'smarty'      => '2.6.7',
            'php'         => '5.1.0'
        ));
        $propbag->add('configuration', array('title','token','site_id','url','live_show','live_title','live_minutes','entries_show','entries_title','entries_days','entries_max','entries_remove','debug'));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));

        $this->dependencies = array('serendipity_event_piwik' => 'remove');
    }

    /**
     * @param string $name
     * @param serendipity_property_bag $propbag
     * @return bool
     */
    public function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'title':
                $propbag->add('type',          'string');
                $propbag->add('name',          PLUGIN_SIDEBAR_PIWIK_TITLE_NAME);
                $propbag->add('description',   PLUGIN_SIDEBAR_PIWIK_TITLE_DESC);
                $propbag->add('default', '');
                break;
            case 'token':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_SIDEBAR_PIWIK_TOKEN_NAME);
                $propbag->add('description',    PLUGIN_SIDEBAR_PIWIK_TOKEN_DESC);
                $propbag->add('default',        '');
                break;
            case 'site_id':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_SIDEBAR_PIWIK_SITEID_NAME);
                $propbag->add('description',    PLUGIN_SIDEBAR_PIWIK_SITEID_DESC);
                $propbag->add('default',        '');
                break;
            case 'url':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_SIDEBAR_PIWIK_URL_NAME);
                $propbag->add('description',    PLUGIN_SIDEBAR_PIWIK_URL_DESC);
                $propbag->add('default',        'http://example.org/piwik/');
                break;
            case 'live_show':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_SIDEBAR_PIWIK_LIVE_SHOW_NAME);
                $propbag->add('description',    PLUGIN_SIDEBAR_PIWIK_LIVE_SHOW_DESC);
                $propbag->add('default',        'true');
                break;
            case 'live_title':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_SIDEBAR_PIWIK_LIVE_TITLE_NAME);
                $propbag->add('description',    PLUGIN_SIDEBAR_PIWIK_LIVE_TITLE_DESC);
                $propbag->add('default',        '');
                break;
            case 'live_minutes':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_SIDEBAR_PIWIK_LIVE_MINUTES_NAME);
                $propbag->add('description',    PLUGIN_SIDEBAR_PIWIK_LIVE_MINUTES_DESC);
                $propbag->add('default',        '30');
                break;
            case 'entries_show':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_SIDEBAR_PIWIK_ENTRIES_SHOW_NAME);
                $propbag->add('description',    PLUGIN_SIDEBAR_PIWIK_ENTRIES_SHOW_DESC);
                $propbag->add('default',        'true');
                break;
            case 'entries_title':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_SIDEBAR_PIWIK_ENTRIES_TITLE_NAME);
                $propbag->add('description',    PLUGIN_SIDEBAR_PIWIK_ENTRIES_TITLE_DESC);
                $propbag->add('default',        '');
                break;
            case 'entries_days':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_SIDEBAR_PIWIK_ENTRIES_DAYS_NAME);
                $propbag->add('description',    PLUGIN_SIDEBAR_PIWIK_ENTRIES_DAYS_DESC);
                $propbag->add('default',        '7');
                break;
            case 'entries_max':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_SIDEBAR_PIWIK_ENTRIES_MAX_NAME);
                $propbag->add('description',    PLUGIN_SIDEBAR_PIWIK_ENTRIES_MAX_DESC);
                $propbag->add('default',        '5');
                break;
            case 'entries_remove':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_SIDEBAR_PIWIK_ENTRIES_REMOVE_NAME);
                $propbag->add('description',    PLUGIN_SIDEBAR_PIWIK_ENTRIES_REMOVE_DESC);
                $propbag->add('default',        '');
                break;
             case 'debug':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_SIDEBAR_PIWIK_DEBUG_NAME);
                $propbag->add('description',    PLUGIN_SIDEBAR_PIWIK_DEBUG_DESC);
                $propbag->add('default',        'false');
                break;

        }
        return true;
    }

    /**
     * @param string $title
     * @return void
     */
    public function generate_content(&$title)
    {
        $title = $this->get_config('title', $title ? $title : $this->title);
        $token = $this->get_config('token', $this->token);
        $site_id = $this->get_config('site_id', $this->site_id);
        $url = $this->get_config('url', $this->url);
        $live_show = $this->get_config('live_show', $this->live_show);
        $live_title = $this->get_config('live_title', $this->live_title);
        $live_minutes = $this->get_config('live_minutes', $this->live_minutes);
        $entries_show = $this->get_config('entries_show', $this->entries_show);
        $entries_title = $this->get_config('entries_title', $this->entries_title);
        $entries_days = $this->get_config('entries_days', $this->entries_days);
        $entries_max = $this->get_config('entries_max', $this->entries_max);
        $entries_remove = $this->get_config('entries_remove', $this->entries_remove);
        $debug = $this->get_config('debug', $this->debug);
        $error = false;
        $piwik_array_pagesurls = array();
        $piwik_array_pagestitles = array();
        $piwik_array_live = array();

        /* live statistics from last xx minutes */
        if ($live_show) {

            $api_url = $url;
            $api_url .= "?module=API&method=Live.getCounters";
            $api_url .= "&idSite=" . $site_id . "&lastMinutes=" . $live_minutes;
            $api_url .= "&format=PHP";
            $api_url .= "&token_auth=$token";
            if ($debug) {$this->debug_append('Live.getCounters - API-URL: '.$api_url);}
            try {
                $piwik_array_live = unserialize($this->requestPiwikData($api_url));
            } catch (Exception $e) {
                $error = true;
            }
            if ($error) {
                return;
            }

            if ($live_title <> '') {echo "\n<h4>".$live_title."</h4>\n";}
            echo '<ul class="plainList" >';
            foreach ($piwik_array_live as $row) {
                $piwik_live_visits = htmlspecialchars(
                    html_entity_decode(urldecode($row['visits']), ENT_QUOTES),
                    ENT_QUOTES
                );
                $piwik_live_actions = htmlspecialchars(
                    html_entity_decode(urldecode($row['actions']), ENT_QUOTES),
                    ENT_QUOTES
                );
                $piwik_live_visitsConverted = htmlspecialchars(
                    html_entity_decode(urldecode($row['visitsConverted']), ENT_QUOTES),
                    ENT_QUOTES
                );
                $piwik_live_visitors = htmlspecialchars(
                    html_entity_decode(urldecode($row['visitors']), ENT_QUOTES),
                    ENT_QUOTES
                );

                echo '    <li>'. PLUGIN_SIDEBAR_PIWIK_LIVE_VISITORS .': '. $piwik_live_visitors."</li>\n";
                echo '    <li>'. PLUGIN_SIDEBAR_PIWIK_LIVE_VISITS .': '. $piwik_live_visits."</li>\n";
                echo '    <li>'. PLUGIN_SIDEBAR_PIWIK_LIVE_ACTIONS .': '. $piwik_live_actions."</li>\n";
            }
            echo "\n</ul>\n";

        }

        /* most viewed entries of current week */
        if ($entries_show) {
            // read Actions.getPageUrls from Piwik
            $api_url = $url.'index.php';
            $api_url .= "?module=API&method=Actions.getPageUrls";
            $api_url .= "&idSite=" . $site_id;
            if ($entries_days == '0') {
                $api_url .= "&period=week&date=today";
            } else {
                $api_url .= "&period=range&date=previous".$entries_days;
            }
            $api_url .= "&format=PHP&filter_limit=" . $entries_max;
            $api_url .= "&flat=1&disableLink=1";
            $api_url .= "&showColumns=label,url,nb_visits";
            $api_url .= "&token_auth=$token";
            if ($debug) {$this->debug_append('Actions.getPageUrls - API-URL: '.$api_url);}
            try {
                $piwik_array_pagesurls = unserialize($this->requestPiwikData($api_url));
            } catch (Exception $e) {
                $error = true;
            }

            // read Actions.getPageTitles from Piwik
            $api_url = $url.'index.php';
            $api_url .= "?module=API&method=Actions.getPageTitles";
            $api_url .= "&idSite=" . $site_id;
            if ($entries_days == '0') {
                $api_url .= "&period=week&date=today";
            } else {
                $api_url .= "&period=range&date=previous".$entries_days;
            }
            $api_url .= "&format=PHP&filter_limit=" . $entries_max;
            $api_url .= "&flat=1&disableLink=1";
            $api_url .= "&showColumns=label";
            $api_url .= "&token_auth=$token";
            if ($debug) {$this->debug_append('Actions.getPageTitles - API-URL: '.$api_url);}
            try {
                $piwik_array_pagestitles = unserialize($this->requestPiwikData($api_url));
            } catch (Exception $e) {
                $error = true;
            }
            if ($error) {
                return;
            }

            // take pagetitles from seconed array and write it into first one
            for ($i = 0; $i < count($piwik_array_pagesurls); $i++) {
                $piwik_array_pagesurls[$i]['label'] = $piwik_array_pagestitles[$i]['label'];
            }

            if ($entries_title <> '') {echo "\n<h4>".$entries_title."</h4>\n";}
            echo "\n<ol>\n";
            foreach ($piwik_array_pagesurls as $row) {
                $piwik_content_pageurl = htmlspecialchars(
                    html_entity_decode(urldecode($row['url']), ENT_QUOTES),
                    ENT_QUOTES
                );
                $piwik_content_pagelabel = htmlspecialchars(
                    html_entity_decode(urldecode($row['label']), ENT_QUOTES),
                    ENT_QUOTES
                );
                $piwik_content_pagelabel = str_replace($entries_remove, "", $piwik_content_pagelabel);
                $piwik_content_hits = $row['nb_visits'];
                echo '    <li><a href="' . $piwik_content_pageurl . '" title="' . $piwik_content_hits . ' ' . PLUGIN_SIDEBAR_PIWIK_ENTRIES_VIEWS . '">' . $piwik_content_pagelabel . "</a></li>\n";
            }
            echo "\n</ol>\n";
        }
    }

    /**
     * @param $api_url
     * @return bool|mixed|string
     */
    protected function requestPiwikData($api_url)
    {

        if (function_exists('serendipity_request_url')) {
            $piwik_fetched = serendipity_request_url($api_url);
        } else {
            require_once S9Y_PEAR_PATH . 'HTTP/Request.php';
            serendipity_request_start();
            $req = new HTTP_Request($api_url);
            if (PEAR::isError($req->sendRequest()) || $req->getResponseCode() != '200') {
                $piwik_fetched = file_get_contents($api_url);
            } else {
                $piwik_fetched = $req->getResponseBody();
            }
            serendipity_request_end();
        }
        return $piwik_fetched;
    }


    function debug_append ($debug_message)
    {
        $logfile = $serendipity['serendipityPath'] . 'templates_c/piwik_debug.log';
        $fp = @fopen($logfile, 'a+');
        fwrite($fp, "\n".date('Y-m-d H:i:s', serendipity_serverOffsetHour()).' '.$debug_message);
        fclose($fp);
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>