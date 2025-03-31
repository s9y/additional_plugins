<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


/** This plugin builds a sitemap.xml according to sitemap.org's defintion of the
  * "Sitemap XML format" Version 0.9 after every save and publish.
  * See https://www.sitemaps.org/protocol.html for details
  * 
  */

@serendipity_plugin_api::load_language(dirname(__FILE__));

/* This plugin is named "_google_sitemap" for historical reasons:
 * The sitemap-protocol was originally created by Google, but was supported
 * by other crawlers (Ask, MSN and Yahoo) as of version 0.9.
 */
class serendipity_event_google_sitemap extends serendipity_event {
    var $title = PLUGIN_EVENT_SITEMAP_TITLE;

    function introspect(&$propbag) {
        $propbag->add('name', PLUGIN_EVENT_SITEMAP_TITLE);
        $propbag->add('description', PLUGIN_EVENT_SITEMAP_DESC);
        $propbag->add('author', 'Boris');
        $propbag->add('version', '0.61.4');
        $propbag->add('event_hooks',  array(
                'backend_publish' => true,
                'backend_save'    => true,
                'backend_staticpages_update' => true,
                'backend_staticpages_insert' => true
            ));
        $propbag->add('stackable', false);
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
        $propbag->add('configuration', array('report', 'url', 'gzip_sitemap', 'avoid_noindex', 'types_to_add', 'gnews', 'gnews_single', 'custom', 'custom2', 'gnews_name', 'gnews_subscription', 'gnews_genre'));
        $propbag->add('requirements',  array('serendipity' => '0.8'));
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;
        switch($name) {
            case 'report':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_SITEMAP_REPORT);
                $propbag->add('description', PLUGIN_EVENT_SITEMAP_REPORT_DESC);
                $propbag->add('default', false);
            break;
            case 'url':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_SITEMAP_URL);
                $propbag->add('description', PLUGIN_EVENT_SITEMAP_URL_DESC);
                $propbag->add('default', 'https://www.google.com/webmasters/tools/ping?sitemap=%s');
            break;
            case 'gzip_sitemap':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_SITEMAP_GZIP_SITEMAP);
                $propbag->add('description', PLUGIN_EVENT_SITEMAP_GZIP_SITEMAP_DESC);
                $propbag->add('default', true);
            break;
            case 'avoid_noindex':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_SITEMAP_AVOID_NOINDEX);
                $propbag->add('description', PLUGIN_EVENT_SITEMAP_AVOID_NOINDEX_DESC);
                $propbag->add('default', true);
            break;
            case 'types_to_add':
                $types = array(
                        'sm_feeds' => PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_FEEDS,
                        'sm_categories' => PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_CATEGORIES,
                        'sm_authors' => PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_AUTHORS,
                        'sm_permalinks' => PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_PERMALINKS,
                        'sm_archives' => PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_ARCHIVES,
                        'sm_static' => PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_STATIC,
                        'sm_tags'=> PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_TAGS
                    );
                $propbag->add('type', 'multiselect');
                $propbag->add('name', PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD);
                $propbag->add('description', PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_DESC);
                $propbag->add('select_values', $types);
                $propbag->add('select_size', 6);
                if (version_compare(PHP_VERSION, '8.0.0', '>=')) {
                    $propbag->add('default', implode('^', array_keys($types)));
                } else {
                    $propbag->add('default', implode(array_keys($types), '^'));
                }
                break;

            case 'gnews_subscription':
                $types = array(
                        'none' => PLUGIN_EVENT_SITEMAP_PUBLIC,
                        'subscription' => PLUGIN_EVENT_SITEMAP_SUBSCRIPTION,
                        'registration' => PLUGIN_EVENT_SITEMAP_REGISTRATION
                    );
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_EVENT_SITEMAP_GNEWS_SUBSCRIPTION);
                $propbag->add('description', PLUGIN_EVENT_SITEMAP_GNEWS_SUBSCRIPTION_DESC);
                $propbag->add('select_values', $types);
                $propbag->add('select_size', 6);
                $propbag->add('default', 'none');
                break;

            case 'gnews_genre':
                $types = array(
                        'none'  => PLUGIN_EVENT_SITEMAP_NONE,
                        'PressRelease' => PLUGIN_EVENT_SITEMAP_PRESS,
                        'Satire' => PLUGIN_EVENT_SITEMAP_SATIRE,
                        'Blog' => PLUGIN_EVENT_SITEMAP_BLOG,
                        'OpEd' => PLUGIN_EVENT_SITEMAP_OPED,
                        'Opinion' => PLUGIN_EVENT_SITEMAP_OPINION,
                        'UserGenerated' => PLUGIN_EVENT_SITEMAP_USERGENERATED
                    );
                $propbag->add('type', 'multiselect');
                $propbag->add('name', PLUGIN_EVENT_SITEMAP_GENRES);
                $propbag->add('description', PLUGIN_EVENT_SITEMAP_GENRES_DESC);
                $propbag->add('select_values', $types);
                $propbag->add('select_size', 6);
                $propbag->add('default', 'none');
                break;

            case 'gnews':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_SITEMAP_NEWS);
                $propbag->add('description', '');
                $propbag->add('default', false);
            break;

            case 'gnews_single':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_SITEMAP_NEWS_SINGLE);
                $propbag->add('description', PLUGIN_EVENT_SITEMAP_NEWS_SINGLE_DESC);
                $propbag->add('default', true);
            break;

            case 'custom':
                $propbag->add('type', 'text');
                $propbag->add('name', PLUGIN_EVENT_SITEMAP_CUSTOM);
                $propbag->add('description', PLUGIN_EVENT_SITEMAP_CUSTOM_DESC);
                $propbag->add('default', '');
            break;

            case 'custom2':
                $propbag->add('type', 'text');
                $propbag->add('name', PLUGIN_EVENT_SITEMAP_CUSTOM2);
                $propbag->add('description', PLUGIN_EVENT_SITEMAP_CUSTOM2_DESC);
                $propbag->add('default', '');
            break;

            case 'gnews_name':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_SITEMAP_GNEWS_NAME);
                $propbag->add('description', PLUGIN_EVENT_SITEMAP_GNEWS_NAME_DESC);
                $propbag->add('default', $serendipity['blogTitle']);
            break;

            default:
                return false;
        }
        return true;
    }

    /*! function to add an entry to the xml-string $str */
    function addtoxml(&$str, $url, $lastmod = null, $priority = null, $changefreq = null, $props = null) {
        /* Sitemap requires this.
         * I think that s9y does not include these specialchars, so this is just a precaution */
        $url = (function_exists('serendipity_specialchars') ? serendipity_specialchars($url, ENT_QUOTES) : htmlspecialchars($url, ENT_QUOTES| ENT_COMPAT, LANG_CHARSET));

        $str .= "\t<url>\n";
        $str .= "\t\t<loc>$url</loc>\n";
        if ($lastmod!=null) {
            $str_lastmod = gmstrftime('%Y-%m-%dT%H:%M:%SZ', $lastmod); // 'Z' does mean UTC in W3C Date/Time
            $str .= "\t\t<lastmod>$str_lastmod</lastmod>\n";
            if ($this->gnewsmode) {
                $str .= "\t\t<news:news>\n";

                $str .= "\t\t\t<news:publication>\n";
                $str .= "\t\t\t\t<news:name>" . (function_exists('serendipity_specialchars') ? serendipity_specialchars($this->get_config('gnews_name')) : htmlspecialchars($this->get_config('gnews_name'), ENT_COMPAT, LANG_CHARSET)) . '</news:name>' . "\n";
                $str .= "\t\t\t\t<news:language>" . (function_exists('serendipity_specialchars') ? serendipity_specialchars($GLOBALS['serendipity']['lang']) : htmlspecialchars($GLOBALS['serendipity']['lang'], ENT_COMPAT, LANG_CHARSET)) . '</news:language>' . "\n";
                $str .= "\t\t\t</news:publication>\n";

                $sub   = $this->get_config('gnews_subscription');
                $genre = $props['properties']['ep_gnews_genre'];
                if (empty($genre)) {
                    $genre = $props['properties']['gnews_genre'];
                }
                if (empty($genre)) {
                    $genre = $props['gnews_genre'];
                }
                if (empty($genre)) {
                    $genre = str_replace('^', ',', $this->get_config('gnews_genre'));
                }
                
                if (!empty($sub) && $sub != 'none') {
                    $str .= "\t\t\t<news:access>" . $sub . "</news:access>\n";
                }
                #http://www.google.com/support/news_pub/bin/answer.py?answer=93992

                if (!empty($genre) && $genre != 'none') {
                    $str .= "\t\t\t<news:genres>" . $genre . "</news:genres>\n";
                }
                $str .= "\t\t\t<news:title>" . (function_exists('serendipity_specialchars') ? serendipity_specialchars($props['title']) : htmlspecialchars($props['title'], ENT_COMPAT, LANG_CHARSET)) . "</news:title>\n";

                $str .= "\t\t\t<news:publication_date>$str_lastmod</news:publication_date>\n";
                if (is_array($props) && isset($props['meta_keywords'])) {
                    $str .= "\t\t\t<news:keywords>" . (function_exists('serendipity_specialchars') ? serendipity_specialchars($props['meta_keywords']) : htmlspecialchars($props['meta_keywords'], ENT_COMPAT, LANG_CHARSET)) . "</news:keywords>\n";
                }
                $str .= "\t\t</news:news>\n";
            }
        }
        if ($priority!==null) {
            $str .= "\t\t<priority>".sprintf("%1.1f",$priority)."</priority>\n";
        }
        if ($changefreq!=null) {
            $str .= "\t\t<changefreq>$changefreq</changefreq>\n";
        }
        $str .= "\t</url>\n";
    }

    /*! This functions returns whether a URL-type should be added or not */
    function should_add($type) {
        if (serendipity_db_bool($this->get_config('avoid_noindex', true))) {
            // modern themes set overview pages to noindex. We should follow, otherwise google will complain
            if ($type == 'sm_categories' || $type == 'sm_authors' || $type == 'sm_archives' || $type == 'sm_tags') {
                return false;
            }
        }
        if(!isset($this->types)) {
            $this->types = explode('^', $this->get_config('types_to_add'));
        }

        if(!is_array($this->types) || count($this->types)===0) {
            // default: add all
            return true;
        } else {
            return in_array($type, $this->types);
        }
    }


    /*! This functions returns the NULL-function for the current DB-specific SQL-dialect */
    function get_sqlnullfunction() {
        global $serendipity;
        // decide which NULL-function to use
        switch($serendipity['dbType']) {
            case 'postgres':
                $sqlnullfunction = 'COALESCE';
                break;
            case 'sqlite':
            case 'sqlite3':
            case 'pdo-sqlite':
            case 'pdo-sqliteoo':
            case 'mysql':
            case 'mysqli':
                $sqlnullfunction = 'IFNULL';
                break;
            default:
                $sqlnullfunction='';
        }
        return $sqlnullfunction;
    }

    /*! Get the real baseURL from the DB to get the primary URLs and
     *  prevent wrong URLs (e.g. with https or different hostnames)
     */
    function get_BaseURL() {
        global $serendipity;

        $url = serendipity_db_query(
                'SELECT value
                FROM '.$serendipity['dbPrefix'].'config AS config
                WHERE name = \'baseURL\'',
            false, 'assoc');

        return (is_array($url))? $url[0]['value'] : false;
    }

    function add_entries(&$sitemap_xml, $limit = 0) {
        global $serendipity;
        $sqlnullfunction = $this->get_sqlnullfunction();

        // fetch all entries from the db (tested with: mysql, sqlite, postgres)
        $entries = serendipity_db_query(
                'SELECT
                    entries.id AS id,
                    entries.title AS title,
                    '.$sqlnullfunction.'(entries.last_modified,0) AS timestamp_1,
                    '.$sqlnullfunction.'(MAX(comments.timestamp),0) AS timestamp_2
                FROM '.$serendipity['dbPrefix'].'entries entries
                LEFT JOIN '.$serendipity['dbPrefix'].'comments comments
                ON entries.id = comments.entry_id
                WHERE entries.isdraft = \'false\'
                AND entries.timestamp < ' . time() . '
                GROUP BY entries.id, entries.title, entries.last_modified
                ORDER BY entries.id DESC
                ' . ($limit > 0 ? ' LIMIT ' . $limit : '')
                ,
            false, 'assoc');

        if(is_array($entries)) {
        
            if ($this->should_add('sm_archives')) {
                // get the P*.html sites if there are more than fetchLimit entries
                for($i=2; $i<=ceil(sizeof($entries) / $serendipity['fetchLimit']); ++$i) {
                    $url = $url=serendipity_rewriteURL(PATH_ARCHIVES. "/P$i.html");
                    $this->addtoxml($sitemap_xml, $url, null, 0.5);
                }
            }    

            // add entries
            foreach($entries as $entry) {
                $max = max(intval($entry['timestamp_1']), intval($entry['timestamp_2']));
                $url = serendipity_archiveURL($entry['id'], $entry['title']);
                $props = serendipity_fetchEntryProperties($entry['id']);                
                $props['title'] = $entry['title'];
                $this->addtoxml($sitemap_xml, $url, $max, 0.7, null, $props);
            }
        }
    }

    function add_permalinks(&$sitemap_xml) {
        global $serendipity;

        $permlink = serendipity_db_query(
                'SELECT entryid, timestamp, value
                FROM '.$serendipity['dbPrefix'].'entryproperties AS entryproperties,
                    '.$serendipity['dbPrefix'].'entries AS entries
                WHERE entryproperties.property = \'permalink\'
                    AND timestamp < ' . time() . '
                    AND value NOT LIKE \'%/UNKNOWN%\'
                    AND entries.id=entryproperties.entryid',
            false, 'assoc');

        if (is_array($permlink)) {
            foreach($permlink as $cur) {
                $path_quoted = preg_quote($serendipity['serendipityHTTPPath'], '#');
                $url = $serendipity['baseURL'] . preg_replace("#$path_quoted#", '', $cur['value'],1);
                $cur_time = ($cur['timestamp']==0)? null : (int)$cur['timestamp'];
                $this->addtoxml($sitemap_xml, $url, $cur_time, 0.8);
            }

            // check for the right order of plugins
            $order = serendipity_db_query(
                'SELECT name, sort_order
                FROM '.$serendipity['dbPrefix'].'plugins AS plugins
                WHERE plugins.name LIKE \'%serendipity_event_google_sitemap%\'
                    OR plugins.name LIKE \'%serendipity_event_custom_permalinks%\'
                ORDER BY plugins.sort_order',
            false, 'assoc');
            if (is_array($order) && isset($order[0]) && isset($order[1])) {
                if( strpos($order[0]['name'], 'serendipity_event_custom_permalinks')===FALSE) {
                    echo '<br/>'.PLUGIN_EVENT_SITEMAP_PERMALINK_WARNING.'<br/>';
                }
            }
        }
    }

    function add_categories(&$sitemap_xml) {
        global $serendipity;

        // fetch categories and their last entry date (tested with: mysql, sqlite, postgres)
        $categories = serendipity_db_query(
                'SELECT
                    category.categoryid AS id,
                    category_name,
                    category_description,
                    MAX(entries.last_modified) AS last_mod
                FROM
                    '.$serendipity['dbPrefix'].'category category,
                    '.$serendipity['dbPrefix'].'entrycat entrycat,
                    '.$serendipity['dbPrefix'].'entries entries
                WHERE
                    category.categoryid = entrycat.categoryid
                    AND
                    entrycat.entryid = entries.id
                GROUP BY
                    category.categoryid,
                    category.category_name,
                    category.category_description
                ORDER BY category.categoryid',
            false, 'assoc');

        if(is_array($categories)) {
            foreach($categories as $category) {
                $max = 0+$category['last_mod'];
                /* v0.9 */
                if(version_compare((float)$serendipity['version'], '0.9', '>=')) {
                    $data = array(
                            'categoryid' => $category['id'],
                            'category_name' => $category['category_name'],
                            'category_description' => $category['category_description']);
                    $url = serendipity_categoryURL($data);
                } else {
                    $url = serendipity_rewriteURL(PATH_CATEGORIES . '/' . serendipity_makePermalink(PERM_CATEGORIES, array('id' => $category['id'], 'title' => $category['category_name'])));
                }
                $this->addtoxml($sitemap_xml, $url, $max, 0.4);
            }
        } else {
            $categories = array();
        }

        // remember for category-feeds and archives
        $this->categories = $categories;
    }

    function add_authors(&$sitemap_xml) {
        global $serendipity;

        // fetch authors and their last entry date (tested with: mysql, sqlite, postgres)
        $authors = serendipity_db_query(
                'SELECT
                    authors.authorid as id,
                    realname,
                    username,
                    email,
                    MAX(entries.last_modified) as time
                FROM
                    '.$serendipity['dbPrefix'].'authors authors,
                    '.$serendipity['dbPrefix'].'entries entries
                WHERE authors.authorid = entries.authorid
                GROUP BY
                    authors.authorid,
                    authors.realname,
                    authors.username,
                    authors.email
                ORDER BY authors.authorid',
            false, 'assoc');

        if(is_array($authors)) {
            // add authors
            foreach($authors as $author) {
                $max = 0+$author['time'];
                /* v0.9 */
                if(version_compare((float)$serendipity['version'], '0.9', '>=')) {
                        $data = array(
                            'authorid' => $author['id'],
                            'realname' => $author['realname'],
                            'username' => $author['username'],
                            'email'    => $author['email']);
                        $url = serendipity_authorURL($data);
                } else {
                    $url=serendipity_rewriteURL(PATH_AUTHORS .'/'. serendipity_makePermalink(PERM_AUTHORS, array('id' => $author['id'], 'title' => $author['realname'])));
                }
                $this->addtoxml($sitemap_xml, $url, $max, 0.2);
            }
        }
    }

    function add_archives(&$sitemap_xml) {
        global $serendipity;

        // fetch date of the oldest entry (tested with: mysql, sqlite, postgres)
        $min = serendipity_db_query(
                'SELECT
                    MIN(timestamp) AS min_time
                FROM '.$serendipity['dbPrefix'].'entries',
            true, 'num');
        $first_year  = 0+gmstrftime('%Y', $min[0]);
        $first_month = 0+gmstrftime('%m', $min[0]);
        $last_year   = 0+gmstrftime('%Y', time());
        $last_month  = 0+gmstrftime('%m', time());

        // add all the month-links
        if(is_array($min) && $first_year<=$last_year) {
            for($year=$first_year; $year<=$last_year; ++$year) {
                $from_month = ($year==$first_year)? $first_month : 1;
                $till_month = ($year==$last_year)? $last_month : 12;

                for($month=$from_month; $month<=$till_month; ++$month) {
                    $str_month = (($month<10)? '0' : '').$month;
                    $url=serendipity_rewriteURL(PATH_ARCHIVES. "/$year/$str_month.html");
                    $this->addtoxml($sitemap_xml, $url, $max, 0.3);
                    $url=serendipity_rewriteURL(PATH_ARCHIVES. "/$year/$str_month/summary.html");
                    $this->addtoxml($sitemap_xml, $url, $max, 0.1);

                    if($this->should_add('sm_categories')) {
                        foreach($this->categories as $category) {
                            $url=serendipity_rewriteURL(PATH_ARCHIVES. "/$year/$str_month/C{$category['id']}.html");
                            $this->addtoxml($sitemap_xml, $url, $max, 0.1);
                        }
                    }
                }
            }
        }
    }

    function add_feeds(&$sitemap_xml) {
        global $serendipity;

        // add the category-newsfeed URLs
        if($this->should_add('sm_categories')) {
            foreach($this->categories as $category) {
                $max = 0+$category['last_mod'];
                // v0.9
                if(version_compare((float)$serendipity['version'], '0.9', '>=')) {
                    $data = array(
                            'categoryid' => $category['id'],
                            'category_name' => $category['category_name'],
                            'category_description' => $category['category_description']);
                    $url = serendipity_feedCategoryURL($data);
                } else {
                    $url = serendipity_rewriteURL(PATH_FEEDS .'/'. PATH_CATEGORIES .'/'. serendipity_makePermalink(PERM_FEEDS_CATEGORIES, array('id' => $category['id'], 'title' => $category['category_name'])));
                }

                $this->addtoxml($sitemap_xml, $url, $max, 0.0);
            }
        }

        // add the global newsfeed URLs
        if($this->should_add('sm_feeds')) {
            $filelist = array('/index.rss', '/index.rss1', '/index.rss2', '/atom.xml');
            foreach($filelist as $curfile) {
                $url = serendipity_rewriteURL(PATH_FEEDS . $curfile);
                $this->addtoxml($sitemap_xml, $url, $max, 0.0);
            }
        }
    }

    function add_static(&$sitemap_xml) {
        global $serendipity;
        $sqlnullfunction = $this->get_sqlnullfunction();

        // add possible static pages
        $static_pages = serendipity_db_query(
                'SELECT permalink, '.$sqlnullfunction.'(timestamp, 0)
                FROM '.$serendipity['dbPrefix'].'staticpages
                WHERE pass = \'\'
                    AND publishstatus = 1',
            false, 'assoc');

        if (is_array($static_pages)) {
            foreach($static_pages as $cur) {
                $path_quoted = preg_quote($serendipity['serendipityHTTPPath'], '#');
                $url = $serendipity['baseURL'] . preg_replace("#$path_quoted#", '', $cur['permalink'],1);
                $cur_time = (($cur['timestamp'] ?? 0) == 0) ? null : (int)$cur['timestamp'];
                $this->addtoxml($sitemap_xml, $url, $cur_time, 0.7);
            }
        }
    }

    function add_tags(&$sitemap_xml) {
        global $serendipity;
        $sqlnullfunction = $this->get_sqlnullfunction();

        // add possible tags pages
        // query adapted from generate_content() in serendipity_plugin_freetag
        $query = "SELECT et.tag, count(et.tag) AS total
                    FROM {$serendipity['dbPrefix']}entrytags AS et
         LEFT OUTER JOIN {$serendipity['dbPrefix']}entries AS e
                      ON et.entryid = e.id
                   WHERE e.isdraft = 'false' "
                         . (!serendipity_db_bool($serendipity['showFutureEntries']) ? " AND e.timestamp <= " . time() : '') . "
                GROUP BY et.tag
                  HAVING count(et.tag) >= 1
                ORDER BY total DESC $limit";

        $tag_pages = serendipity_db_query($query, false, 'assoc');

        if (is_array($tag_pages)) {
            foreach($tag_pages as $cur) {
                $path_quoted = preg_quote($serendipity['serendipityHTTPPath'], '#');
                $url = $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/tag/'. preg_replace("#$path_quoted#", '', urlencode($cur['tag']),1);
                $cur_time = ($cur['timestamp']==0)? null : (int)$cur['timestamp'];
                $this->addtoxml($sitemap_xml, $url, $cur_time, 0.4);
            }
        }
    }
    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch ($event) {
                case 'backend_publish':
                case 'backend_save':
                case 'backend_staticpages_insert':
                case 'backend_staticpages_update':
                    /* Backup the baseURL.
                     * This is a nasty workaround the issues with $serendipity['baseURL'] not
                     * pointing to the primary url on hostname-autosensing. See this forum-thread
                     * for details and discussion: http://board.s9y.org/viewtopic.php?p=60164#60164
                     */
                     
                    if (!empty($serendipity['defaultBaseURL'])) {
                        $serendipity['baseURL'] = $old_url = $serendipity['defaultBaseURL'];
                    } else {    
                        $old_url = $serendipity['baseURL'];
                        $serendipity['baseURL'] = $this->get_BaseURL();
                    }    

                    $this->write_sitemap('sitemap.xml', $eventData);

                    if (serendipity_db_bool($this->get_config('gnews'))) {
                        $this->write_sitemap('news_sitemap.xml', $eventData, true);
                    }
                    
                    // restore baseURL (see above)
                    $serendipity['baseURL'] = $old_url;
                    return true;
                    break;
                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
    }

    function write_sitemap($basefilename = 'sitemap.xml', &$eventData = null, $gnewsmode = false) {
        global $serendipity;

        $this->gnewsmode = false;

        // If this variable is enabled, each XML article will get its gnews:... counterpart.
        // This is NOT desired in the usual sitemap!
        if ($gnewsmode) {
            $this->gnewsmode = true;
        } elseif (serendipity_db_bool($this->get_config('gnews_single')) && serendipity_db_bool($this->get_config('gnews'))) {
            $this->gnewsmode = true;
        }

        // start the xml
        $sitemap_xml  = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $sitemap_xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"\n";
        $sitemap_xml .= "\txmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n";
        if ($this->gnewsmode) {
            $sitemap_xml .= "\txmlns:news=\"http://www.google.com/schemas/sitemap-news/0.9\"\n";                    
        }
        $sitemap_xml .= "\txsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9\n";
        $sitemap_xml .= "\t\t\thttp://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\" ";
        $sitemap_xml .= $this->get_config('custom2');
        $sitemap_xml .= ">\n";



        // add link to the main page
        $this->addtoxml($sitemap_xml, $serendipity['baseURL'], time(), 0.6);


        if (!$gnewsmode) {
            $this->add_entries($sitemap_xml);

            if ($this->should_add('sm_permalinks')) {
                $this->add_permalinks($sitemap_xml);
            }
    
            if ($this->should_add('sm_categories')) {
                $this->add_categories($sitemap_xml);
            }
    
            if ($this->should_add('sm_authors')) {
                $this->add_authors($sitemap_xml);
            }
    
            if ($this->should_add('sm_archives')) {
                $this->add_archives($sitemap_xml);
                // add link to archive-mainpage
                $this->addtoxml($sitemap_xml, serendipity_rewriteURL(PATH_ARCHIVE), time(), 0.5);
            }
    
            if($this->should_add('sm_feeds')) {
                $this->add_feeds($sitemap_xml);
            }
    
            if($this->should_add('sm_static')) {
                $this->add_static($sitemap_xml);
            }
    
            if($this->should_add('sm_tags')) {                    
                $this->add_tags($sitemap_xml);
            }
        } else {
            $this->add_entries($sitemap_xml, 900);
        }        

        $sitemap_xml .= $this->get_config('custom');

        // finish the xml
        $sitemap_xml .= "</urlset>\n";

        $do_gzip = serendipity_db_bool($this->get_config('gzip_sitemap', true));

        // decide whether to use gzip-output or not
        if ($do_gzip && function_exists('gzencode')) {
            $filename = '/' . $basefilename . '.gz';
            $temp = gzencode($sitemap_xml);

            // only use the compressed data and filename if no error occured
            if ( !($temp === FALSE) ) {
                $sitemap_xml = $temp;
            } else {
                $filename = '/' . $basefilename;
            }
        } else {
            $filename = '/' . $basefilename;
        }

        // write result to file
        $outfile = fopen($serendipity['serendipityPath'] . $filename, 'w');
        if($outfile === false) {
            echo '<strong>'.PLUGIN_EVENT_SITEMAP_FAILEDOPEN.' (' . $serendipity['serendipityPath'] . $filename . ')</strong>';
            return false;
        }
        flock($outfile, LOCK_EX);
        fputs($outfile, $sitemap_xml);
        flock($outfile, LOCK_UN);
        fclose($outfile);


        $do_pingback = serendipity_db_bool($this->get_config('report', false));
        $pingback_url = $this->get_config('url', false);
        // Walk through the list of pingback-URLs
        echo $basefilename . ':<br />';
        foreach(explode(';', $pingback_url) as $cur_pingback_url) {
            $pingback_name = PLUGIN_EVENT_SITEMAP_UNKNOWN_SERVICE;
            $cur_url = sprintf($cur_pingback_url, rawurlencode($serendipity['baseURL'].$filename));

            // extract domain-portion from URL
            if(preg_match('@^https?://([^/]+)@', $cur_pingback_url, $matches)>0) {
                $pingback_name = $matches[1];
            }

            if(!serendipity_db_bool($eventData['isdraft']) && $do_pingback && $cur_url) {
                    $answer = $this->send_ping($cur_url);
                    if($answer) {
                        printf(PLUGIN_EVENT_SITEMAP_REPORT_OK, $pingback_name);
                    } else {
                        printf(PLUGIN_EVENT_SITEMAP_REPORT_ERROR, $pingback_name, $cur_url);
                    }
            } else {
                printf(PLUGIN_EVENT_SITEMAP_REPORT_MANUAL, $pingback_name, $cur_url);
            }
        }
        echo PLUGIN_EVENT_SITEMAP_ROBOTS_TXT;
    }
    
    function send_ping($loc) {
        global $serendipity;

        if (function_exists('serendipity_request_url')) {
            $data = serendipity_request_url($loc);
            if (empty($data)) return false;
            return true;
        } else {

            if (function_exists('serendipity_request_url')) {
                $data = serendipity_request_url($loc);
                if ($serendipity['last_http_request']['responseCode'] == '200') {
                    return true;
                }
                return false;
            } else {
                require_once (defined('S9Y_PEAR_PATH') ? S9Y_PEAR_PATH : S9Y_INCLUDE_PATH . 'bundled-libs/') . 'HTTP/Request.php';
                $req = new HTTP_Request($loc);

                if (PEAR::isError($req->sendRequest()) || $req->getResponseCode() != '200') {
                    print_r($req);
                    return false;
                } else {
                    return true;
                }
            }
        }
    }
}
// vim: set sts=4 ts=4 expandtab :
// kate: encoding us-ascii; indent-width 4; indent-mode normal; space-indent on; tab-width 4; mixedindent off;
