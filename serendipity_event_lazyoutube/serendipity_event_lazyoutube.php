<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));


class serendipity_event_lazyoutube extends serendipity_event {

    var $markup_elements = [];

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_LAZYOUTUBE_NAME);
        $propbag->add('description',   PLUGIN_EVENT_LAZYOUTUBE_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Malte Paskuda');
        $propbag->add('version',       '1.1.1');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0',
        ));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',   array('frontend_display' => true,
                                            'frontend_comment' => true,
                                            'external_plugin' => true,
                                            ));
        $propbag->add('groups', array('MARKUP'));

        $this->markup_elements = array(
            array(
              'name'     => 'ENTRY_BODY',
              'element'  => 'body',
            ),
            array(
              'name'     => 'EXTENDED_BODY',
              'element'  => 'extended',
            ),
            array(
              'name'     => 'COMMENT',
              'element'  => 'comment',
            ),
            array(
              'name'     => 'HTML_NUGGET',
              'element'  => 'html_nugget',
            )
        );

        $conf_array = array();
        foreach($this->markup_elements as $element) {
            $conf_array[] = $element['name'];
        }
        $conf_array[] = 'proxy';
        $propbag->add('configuration', $conf_array);
    }

    function install() {
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
        $this->setupDB();
    }

    function uninstall(&$propbag) {
        serendipity_plugin_api::hook_event('backend_cache_purge', $this->title);
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENT_LAZYOUTUBE_NAME;
    }


    function introspect_config_item($name, &$propbag)
    {

        switch($name) {
            case 'proxy':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_LAZYOUTUBE_PROXY_NAME);
                $propbag->add('description', PLUGIN_EVENT_LAZYOUTUBE_PROXY_DESC);
                $propbag->add('default', 'true');
                return true;

            default:
                $propbag->add('type',        'boolean');
                $propbag->add('name',        constant($name));
                $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
                $propbag->add('default', 'true');
                return true;
        }
    }

    function setupDB() {
        global $serendipity;
        
        $sql = "CREATE TABLE IF NOT EXISTS
            {$serendipity['dbPrefix']}lazyoutube_whitelist
            (videoid VARCHAR(20) NOT NULL UNIQUE);";
        serendipity_db_schema_import($sql);
    }


    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_display':
                    foreach ($this->markup_elements as $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], true)) && isset($eventData[$temp['element']]) &&
                            !($eventData['properties']['ep_disable_markup_' . $this->instance] ?? false) &&
                            !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];
                            $eventData[$element] = $this->apply_markup($eventData[$element]);
                        }
                    }
                    return true;
                    break;
                case 'external_plugin':
                    $parts      = explode('_', $eventData);
                    if (count($parts) < 2) {
                        return false;
                    }
                    if ($parts[0] == 'lazyoutubefetch') {
                        $videoid =  str_replace('UNDERSCORE', '_', $parts[1]);
                        if (! $this->on_whitelist($videoid)) {
                            return false;
                        }
                        $cache_path = $this->get_cache_path($videoid);
                        # Check if the thumbnail is already cached.
                        if (! file_exists($cache_path)) {
                            # If not we have to fetch and store it
                            $thumbnail_url = 'https://img.youtube.com/vi/' . $videoid .'/hqdefault.jpg';
                            if (! file_exists(dirname($cache_path))) {
                                mkdir(dirname($cache_path));
                            }

                            # We will use a lock to limit the requests we send out concurrently.
                            # This might help avoid issues with the Youtube servers
                            $lockdir = dirname($cache_path) . "lock";
                            $tries = 0;
                            while (!@mkdir($lockdir)) {
                                # Some variation, for parallel waits to not end at the same time
                                usleep(rand(400, 800));
                                $tries = $tries + 1;
                                if ($tries > 3) {
                                    break;
                                }
                            }
                            $image_data = serendipity_request_url($thumbnail_url);
                            rmdir($lockdir);
                           
                            $fp = fopen($cache_path, 'wb');
                            fwrite($fp, $image_data);
                            fclose($fp);
                        }
                        # Now it exists, we can redirect to the stored thumbnail
                        header($_SERVER["SERVER_PROTOCOL"] ." 302 Found");
                        header('Location: '. $this->get_cache_url($videoid), true, 302);
                        exit();
                    }
                    
                    return true;
                    break;

                default:
                    return false;
            }
        } else {
            return false;
        }
    }

    # The path where thumbnails are to be stored on disk
    function get_cache_path($videoid) {
        global $serendipity;
        return $serendipity['serendipityPath'] . PATH_SMARTY_COMPILE . '/serendipity_event_lazytube/' . $videoid .'.jpg';
    }

    # The web url to the stored thumbnail
    function get_cache_url($videoid) {
        global $serendipity;
        return $serendipity['baseURL'] . PATH_SMARTY_COMPILE . '/serendipity_event_lazytube/' . $videoid .'.jpg';
    }

    # Pattern of plugin urls, used to trigger plugin events
    function getPermaPluginPath() {
        global $serendipity;

        // Get configured plugin path:
        $pluginPath = 'plugin';
        if (isset($serendipity['permalinkPluginPath'])){
            $pluginPath = $serendipity['permalinkPluginPath'];
        }

        return $pluginPath;
    }

    # Add a videoid to the whitelist. Used when parsing videos, only whitelisted
    # videoids are permitted for the thumbnail lookup. This will prevent potential abusers
    # from triggering repeated queries to the Youtube server (since requests are cached).
    function whitelist($videoid) {
        global $serendipity;
        $this->setupDB();

        switch ($serendipity['dbType']) {
            case 'mysql':
            case 'mysqli':
                $sql = "INSERT IGNORE INTO
                {$serendipity['dbPrefix']}lazyoutube_whitelist
                (videoid)
                VALUES
                (\"" . serendipity_db_escape_string($videoid) . "\");";
                break;
            case 'sqlite':
            case 'sqlite3':
            case 'pdo-sqlite':
            case 'pdo-sqliteoo':
                $sql = "INSERT OR IGNORE INTO
                    {$serendipity['dbPrefix']}lazyoutube_whitelist
                    (videoid)
                    VALUES
                    (\"" . serendipity_db_escape_string($videoid) . "\");";
                break;
            default:
                # Postgres
                 $sql = "INSERT INTO
                    {$serendipity['dbPrefix']}lazyoutube_whitelist
                    (videoid)
                    VALUES
                    (\"" . serendipity_db_escape_string($videoid) . "\") ON CONFLICT(videoid) DO NOTHING;";
        }
        serendipity_db_query($sql);
    }

    # Return true if the given videoid is on the whitelist, false otherwise
    function on_whitelist($videoid) {
        global $serendipity;

        $sql = "SELECT videoid FROM 
            {$serendipity['dbPrefix']}lazyoutube_whitelist
            WHERE videoid = \"" . serendipity_db_escape_string($videoid) . "\";";

        $found = serendipity_db_query($sql, true);
        return (count($found) > 0);
    }

    # Replaces the regular YouTube iframe with a simple thumbnail
    function apply_markup($text) {
        global $serendipity;
        //enable \ as escape-character:
        $text = str_replace('\[', chr(2), $text);
        $search = array(
                        // iframe embed                    optional privacy mode       #videoid     #start time etc
                        '/<iframe[^>]*https:\/\/www\.youtube(?:-nocookie)?\.com\/embed\/([^ \&"\?]+)([^"]*)[^>]*><\/iframe>/',
                       );
        $search_elements = count($search);
        $proxy = serendipity_db_bool($this->get_config('proxy', true));
        for($i = 0; $i < $search_elements; $i++) {
            $text = preg_replace_callback($search[$i], function ($matches) use ($serendipity, $proxy) {
                            $videoid = $matches[1];
                            if (isset($matches[2]) && ! empty($matches[2])) {
                                $params = $matches[2] . '&autoplay=1';
                            } else {
                                $params = '?autoplay=1';
                            }
                            # We need to whitelist the videoid first, otherwise the proxied lookup will not work                            
                            if ($proxy) {
                                # We whitelist only when the proxy option is enabled. Then we can
                                # leave the proxy function itself enabled even if the option is off,
                                # to solve the scenarios when old entries still have the proxies url
                                # in their cache
                                $this->whitelist($videoid);
                                $thumbnail_url = $serendipity['baseURL'] . $serendipity['indexFile'] . '?/' . $this->getPermaPluginPath() . '/lazyoutubefetch_' . str_replace('_', 'UNDERSCORE', $videoid);
                            } else {
                                $thumbnail_url = 'https://img.youtube.com/vi/' . $videoid .'/hqdefault.jpg';
                            }
                            return '<iframe
                                width="560"
                                height="315"
                                src="https://www.youtube-nocookie.com/embed/' . $videoid .'"
                                srcdoc="<style>*{padding:0;margin:0;overflow:hidden}html,body{height:100%}img,span{position:absolute;width:100%;height:auto;top:0;bottom:0;margin:auto}span{height:1.5em;text-align:center;font:48px/1.5 sans-serif;color:white;text-shadow:0 0 0.5em black}</style><a href=https://www.youtube-nocookie.com/embed/' . $videoid . $params . '><img width=560 height=420 loading=lazy src=' . $thumbnail_url .'><span>▶</span></a>"
                                frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                ></iframe>';
                        },
                        $text);
        }
        //reinsert escaped charachters:
        $text = str_replace(chr(2), '[', $text);
        return $text;
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>
