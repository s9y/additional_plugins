<?php # 
if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// NOTES:
//
//      If using MagpieRSS as RSS fetching tool, this plugin is licensed as GPL.
//      If using the Onyx parser, this plugin is licensed as BSD.
//
// *****************************************************************
//
// LAYOUT NOTE:
// For best "planet experience" you are advised to create your own template and
// disable s9y-specific options which do not make sense in a planet environment.
// A suggestion is to display the originating feed URL inside entries.tpl via:
//
// {$entry.properties.ep_aggregator_feedname}
// {$entry.properties.ep_aggregator_feedurl}
// {$entry.properties.ep_aggregator_htmlurl}
// {$entry.properties.ep_aggregator_articleurl}
// {$entry.properties.ep_aggregator_author}
//
// See, eg. suggestions in file:
//
// [serendipity]/plugins/serendipity_event_aggregator/theme-patch.diff
//
// *****************************************************************
//
// Smarty plugin API hook to fetch and display feeds in a static page or template:
//
// {serendipity_hookPlugin hook='aggregator_feedlist' hookAll=true data="category:9|cachetime:3600|template:feedlist.tpl"}
//
// Currently supported parameters are only "category" and "cachetime". The ID of a category
// corresponds with the ID of the category that the feeds are associated to in the aggregator configuration.
// You can see the categoryIDs in the backend of managing categories in the URL ("cid"). Multiple categories
// can be separated with a comma (,).
//
// Calling the update like that does NOT STORE THE ENTRIES in your usual blog database, but in a seperate
// one. So this does not really aggregate entries, but simply display them. The cachetime means how many
// seconds must pass until the feeds are refreshed when called.

// The template (by default: feedlist.tpl) can be stored either in the plugin directory or your custom
// template directory and is used to render the items.

// The icon of a feed can be either manually specified in the configuration of available feeds
// or it can be autodetected (only when using simplepie as parser).
// *****************************************************************


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_aggregator extends serendipity_event {

    var $debug;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_AGGREGATOR_TITLE);
        $propbag->add('description',   PLUGIN_AGGREGATOR_DESC);
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('version',       '0.30');
        $propbag->add('author',       'Evan Nemerson, Garvin Hicking, Kristian Koehntopp, Thomas Schulz, Claus Schmidt');
        $propbag->add('stackable',     false);
        $propbag->add('event_hooks',   array(
                                            'external_plugin'         => true,
                                            'backend_sidebar_entries' => true,
                                            'backend_sidebar_entries_event_display_aggregator' => true,
                                            'cronjob' => true,
                                            'aggregator_feedlist' => true
                                        )
        );
        $propbag->add('configuration', array('cronjob', 'engine', 'publishflag', 'expire', 'expire_md5', 'ignore_updates', 'delete_dependencies', 'allow_comments', 'markup', 'debug'));
        $propbag->add('groups', array('FRONTEND_FULL_MODS'));
        $propbag->add('license', 'GPL');
        $this->dependencies = array('serendipity_event_entryproperties' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'publishflag':
                $propbag->add('type',        'radio');
                $propbag->add('name',        PLUGIN_AGGREGATOR_PUBLISH);
                $propbag->add('description', '');
                $propbag->add('radio',       array(
                    'value' => array('true', 'false'),
                    'desc'  => array(PUBLISH, DRAFT)
                ));
                $propbag->add('default',     'true');
                break;

            case 'cronjob':
                if (class_exists('serendipity_event_cronjob')) {
                    $propbag->add('type',        'select');
                    $propbag->add('name',        PLUGIN_EVENT_CRONJOB_CHOOSE);
                    $propbag->add('description', '');
                    $propbag->add('default',     'daily');
                    $propbag->add('select_values', serendipity_event_cronjob::getValues());
                } else {
                    $propbag->add('type', 'content');
                    $propbag->add('default', PLUGIN_AGGREGATOR_CRONJOB);
                }
                break;

            case 'debug':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_AGGREGATOR_DEBUG);
                $propbag->add('description', PLUGIN_AGGREGATOR_DEBUG_BLAHBLAH);
                $propbag->add('default', false);

                break;

            case 'markup':
                $plugins = serendipity_plugin_api::get_event_plugins();
                $markups = array();

                if (is_array($plugins)) {
                    // foreach() operates on copies of values, but we want to operate on references, so we use while()
                    @reset($plugins);
                    while(list($plugin, $plugin_data) = each($plugins)) {
                        if (!is_array($plugin_data['p']->markup_elements)) {
                            continue;
                        }
                        $markups[$plugin_data['p']->instance] = htmlspecialchars($plugin_data['p']->title);
                    }
                }

                $propbag->add('type', 'multiselect');
                $propbag->add('name', PLUGIN_AGGREGATOR_MARKUP_DISABLE);
                $propbag->add('description', PLUGIN_AGGREGATOR_MARKUP_DISABLE_DESC);
                $propbag->add('select_values', $markups);
                $propbag->add('select_size', 6);
                $propbag->add('default', '');
                break;

            case 'engine':
                $propbag->add('type', 'radio');
                $propbag->add('radio', array('value' => array('onyx', 'magpierss','simplepie'),
                                             'desc'  => array('Onyx [BSD]', 'MagpieRSS [GPL]', 'SimplePie')));
                $propbag->add('name', PLUGIN_AGGREGATOR_CHOOSE_ENGINE);
                $propbag->add('description', PLUGIN_AGGREGATOR_CHOOSE_ENGINE_DESC);
                $propbag->add('default', 'onyx');

                break;

            case 'delete_dependencies':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_AGGREGATOR_DELETEDEPENDENCIES);
                $propbag->add('description', PLUGIN_AGGREGATOR_DELETEDEPENDENCIES_DESC);
                $propbag->add('default', true);

                break;

            case 'expire':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_AGGREGATOR_EXPIRE);
                $propbag->add('description', PLUGIN_AGGREGATOR_EXPIRE_BLAHBLAH);
                $propbag->add('default', 2);

                break;

            case 'expire_md5':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_AGGREGATOR_EXPIRE_MD5);
                $propbag->add('description', PLUGIN_AGGREGATOR_EXPIRE_MD5_BLAHBLAH);
                $propbag->add('default', 90);

                break;

            case 'ignore_updates':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_AGGREGATOR_IGNORE_UPDATES);
                $propbag->add('description', PLUGIN_AGGREGATOR_IGNORE_UPDATES_DESC);
                $propbag->add('default', false);

                break;

            case 'allow_comments':
                $propbag->add('type', 'boolean');
                $propbag->add('name', COMMENTS_ENABLE);
                $propbag->add('description', '');
                $propbag->add('default', false);

                break;

            default:
                    return false;
        }
        return true;
    }


    function setupDB() {
        global $serendipity;

        # Old Schema
        if (! serendipity_db_bool($this->get_config('db_built', false))) {
            $sql = "CREATE TABLE {$serendipity['dbPrefix']}aggregator_feeds (
                          feedid {AUTOINCREMENT} {PRIMARY},
                          feedname    varchar(255) NOT NULL default '',
                          feedurl     varchar(255) NOT NULL default '',
                          htmlurl     varchar(255) NOT NULL default '',
                          categoryid  int(11) default NULL,
                          last_update int(10) {UNSIGNED} default null,
                          charset     varchar(255) NOT NULL default ''
                        );";
            serendipity_db_schema_import($sql);
            $this->set_config('db_built', 'true');
        }

        # Schema extension (version 2)
        if ($this->get_config('db_version') < 2) {
            echo "*** setup DB version " . $this->get_config('db_version'). "<br />\n";
            $sql = "CREATE TABLE {$serendipity['dbPrefix']}aggregator_md5 (
                          entryid {AUTOINCREMENT} {PRIMARY},
                          md5         varchar(32) NOT NULL default '',
                          timestamp   int(10) {UNSIGNED} default null,
                          key md5_idx (md5),
                          key timestamp_idx (timestamp)
                        );";
            serendipity_db_schema_import($sql);

            $sql = "INSERT INTO {$serendipity['dbPrefix']}aggregator_md5
                        ( entryid, md5, timestamp )
                        SELECT entryid, value, " . time() .
                      " FROM {$serendipity['dbPrefix']}entryproperties
                        WHERE property = 'ep_aggregator_md5'";
            serendipity_db_query($sql);

            $sql = "DELETE FROM {$serendipity['dbPrefix']}entryproperties
                    WHERE property = 'ep_aggregator_md5'";
            serendipity_db_query($sql);

            $this->set_config('db_version', '2');
        }

        # Schema extension (version 3)
        if ($this->get_config('db_version') < 3) {
            echo "*** setup DB version " . $this->get_config('db_version'). "<br />\n";
            $sql = "CREATE TABLE {$serendipity['dbPrefix']}aggregator_feedcat (
                         feedid int(11) not null,
                         categoryid int(11) not null
                        );";
            serendipity_db_schema_import($sql);

            $sql = "CREATE UNIQUE INDEX feedid_idx
                        ON {$serendipity['dbPrefix']}aggregator_feedcat (feedid, categoryid);";
            serendipity_db_schema_import($sql);

            $sql = "INSERT INTO {$serendipity['dbPrefix']}aggregator_feedcat
                        ( feedid, categoryid  )
                        SELECT feedid, categoryid
                        FROM {$serendipity['dbPrefix']}aggregator_feeds";
            serendipity_db_query($sql);

            $sql = "DELETE FROM {$serendipity['dbPrefix']}entryproperties
                    WHERE property = 'ep_aggregator_md5'";
            serendipity_db_query($sql);

            $sql = "ALTER TABLE {$serendipity['dbPrefix']}aggregator_feeds
                          DROP categoryid;";
            serendipity_db_schema_import($sql);

            $this->set_config('db_version', '3');
        }

        # Schema extension (version 4)
        if ($this->get_config('db_version') < 4) {
            $sql = "ALTER TABLE {$serendipity['dbPrefix']}aggregator_feeds
                          ADD COLUMN charset varchar(255);";
            serendipity_db_schema_import($sql);

            $this->set_config('db_version', '4');
        }

        # Schema extension (version 5)
        if ($this->get_config('db_version') < 5) {
            $sql = "ALTER TABLE {$serendipity['dbPrefix']}aggregator_feeds
                          ADD COLUMN match_expression varchar(255);";
            serendipity_db_schema_import($sql);

            $this->set_config('db_version', '5');
        }

        # Schema extension (version 6)
        if ($this->get_config('db_version') < 6) {
            $sql = "CREATE TABLE {$serendipity['dbPrefix']}aggregator_feedlist (
                         id {AUTOINCREMENT} {PRIMARY},
                         feedid int(11) not null,
                         categoryid int(11) not null,
                         entrydate int(11) not null,
                         entrytitle text,
                         entrybody longtext,
                         entryurl text
                        );";
            serendipity_db_schema_import($sql);

            $sql = "ALTER TABLE {$serendipity['dbPrefix']}aggregator_feeds
                          ADD COLUMN feedicon text;";
            serendipity_db_schema_import($sql);

            $this->set_config('db_version', '6');
        }


        if ($this->get_config('db_version') < 7) {
            $sql = "CREATE INDEX fl_feedid ON {$serendipity['dbPrefix']}aggregator_feedlist (feedid)";
            serendipity_db_schema_import($sql);

            $sql = "CREATE INDEX fl_entrydate ON {$serendipity['dbPrefix']}aggregator_feedlist (entrydate)";
            serendipity_db_schema_import($sql);

            $sql = "CREATE INDEX fl_categoryid ON {$serendipity['dbPrefix']}aggregator_feedlist (categoryid)";
            serendipity_db_schema_import($sql);

            $sql = "CREATE INDEX fl_feedid_2 ON {$serendipity['dbPrefix']}aggregator_feedlist (feedid, entrydate)";
            serendipity_db_schema_import($sql);

            $sql = "CREATE INDEX fl_feedid_3 ON {$serendipity['dbPrefix']}aggregator_feedlist (feedid, entrydate, categoryid)";
            serendipity_db_schema_import($sql);

            $this->set_config('db_version', '7');
        }
    }

    function &getFeeds($opt = null) {
        global $serendipity;

        $this->setupDB();

        if ($opt['category'] > 0) {
            $where = "WHERE fc.categoryid IN (" . $opt['category'] . ")";
        }
        $sql = "SELECT f.feedid, f.feedname, f.feedurl, f.htmlurl, fc.categoryid, f.last_update, f.charset, f.feedicon, f.match_expression
                  FROM {$serendipity['dbPrefix']}aggregator_feeds AS f
       LEFT OUTER JOIN {$serendipity['dbPrefix']}aggregator_feedcat AS fc
                    ON f.feedid = fc.feedid
                    $where
                 ORDER BY feedname, f.feedid
                 ";

        $feeds = serendipity_db_query($sql, false, 'assoc');

        // prepare array
        $ret = array();
        if (is_array($feeds)) {
            foreach ($feeds as $feed) {
                $category = $feed['categoryid'];
                if (!isset($ret[$feed['feedid']])) {
                    unset($feed['categoryid']);
                    $ret[$feed['feedid']] = $feed;
                }
                $ret[$feed['feedid']]['categoryids'][] = $category;
            }
        }
        $feeds = array_values($ret);

        if (!is_array($feeds)) {
            return array();
        } else {
            return $feeds;
        }
    }

    function removeFeeds() {
        global $serendipity;

        if (!serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}aggregator_feedcat")) {
             return false;
        }
        return serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}aggregator_feeds");
    }

    function createFeeds() {
        global $serendipity;

        $this->setupDB();

        $feeds = $this->getFeeds();

        foreach($serendipity['POST']['feed'] AS $idx => $array) {
            if (empty($idx)) {
                if (empty($array['feedurl']) && empty($array['feedname']) && empty($array['htmlurl'])) {
                    continue;
                } elseif (empty($array['feedurl']) || empty($array['feedname'])) {
                    echo '<div class="serendipityAdminMsgError"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png') . '" alt="" />' . PLUGIN_AGGREGATOR_FEED_MISSINGDATA . '</div>';
                } else {
                    $this->insertFeed($array);
                }
            } elseif (is_numeric($idx)) {
                if (empty($array['feedurl']) || empty($array['feedname'])) {
                    $this->deleteFeed($idx, $array);
                } else {
                    $this->updateFeed($idx, $array);
                }
            }
        }
    }

    function purgeEntries($id_list) {
        global $serendipity;

        $a = serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entries         WHERE id       IN (" . implode(", ", $id_list) . ")");
        $b = serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entrycat        WHERE entryid  IN (" . implode(", ", $id_list) . ")");
        $c = serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid  IN (" . implode(", ", $id_list) . ")");
        $d = serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}references      WHERE entry_id IN (" . implode(", ", $id_list) . ")");
        $e = serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}exits           WHERE entry_id IN (" . implode(", ", $id_list) . ")");

        return true;
    }

    function expireFeedEntries($age) {
        global $serendipity;

        // CLSC: 86400 = number of seconds in 24 hours
        $t  = time() - 86400 * $age;
        if ($this->debug) printf("DEBUG: Expire cutoff %s\n", $t);

        $q = "SELECT e.id
                FROM {$serendipity['dbPrefix']}entries AS e
     LEFT OUTER JOIN {$serendipity['dbPrefix']}entryproperties AS ep
                  ON e.id = ep.entryid
     LEFT OUTER JOIN {$serendipity['dbPrefix']}aggregator_feeds AS af
                  ON ep.value = af.feedid
               WHERE ep.property = 'ep_aggregator_feed'
                 AND e.comments < 1
                 AND e.extended IS NULL
                 AND e.timestamp < " . (int)$t;
        $entries = serendipity_db_query($q);

        if (!is_array($entries)) {
            if ($this->debug) printf("DEBUG: Nothing to expire.\n");
            return false;
        }

        $id_list = array();
        foreach($entries AS $entry) {
            if ($this->debug) printf("Expire entry %s\n", $entry['id']);
            $id_list[] = $entry['id'];
        }

        $this->purgeEntries($id_list);

        return ;
    }

    function purgeMD5($id_list) {
        global $serendipity;

        $a = serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}aggregator_md5 WHERE entryid  IN (" . implode(", ", $id_list) . ")");

        return true;
    }

    function expireFeedMD5($age) {
        global $serendipity;

        // CLSC: 86400 = number of seconds in 24 hours
        $t  = time() - 86400 * $age;
        if ($this->debug) printf("DEBUG: MD5 Expire cutoff %s\n", $t);

        $q = "SELECT entryid FROM {$serendipity['dbPrefix']}aggregator_md5 WHERE timestamp < " . (int) $t;
        $entries = serendipity_db_query($q);

        if (!is_array($entries)) {
            if ($this->debug) printf("DEBUG: Nothing to expire.\n");
            return false;
        }

        $id_list = array();
        foreach($entries AS $entry) {
            if ($this->debug) printf("Expire MD5 %s\n", $entry['entryid']);
            $id_list[] = $entry['entryid'];
        }

        $this->purgeMD5($id_list);

        return ;
    }

    function expireFeeds() {
        $t  = &$this->get_config('expire');
        if ($t > 0) {
            $this->expireFeedEntries($t);
        }

        $t = &$this->get_config('expire_md5');
        if ($t > 0) {
            $this->expireFeedMD5($t);
        }


        return;
    }

    function updateFeed($idx, &$array) {
        global $serendipity;

        $q = "UPDATE {$serendipity['dbPrefix']}aggregator_feeds
                 SET feedname           = '" . serendipity_db_escape_string($array['feedname']) . "',
                     feedurl            = '" . serendipity_db_escape_string($array['feedurl']) . "',
                     match_expression   = '" . serendipity_db_escape_string($array['match_expression']) . "',
                     feedicon           = '" . serendipity_db_escape_string($array['feedicon']) . "',
                     htmlurl            = '" . serendipity_db_escape_string($array['htmlurl']) . "'
               WHERE feedid             = " . (int)$idx;

        if (!serendipity_db_query($q)) {
            return false;
        }
        // delete old categories
        if (!$this->deleteFeedCats($idx)) {
            return false;
        }
        // add changed categories
        return $this->insertFeedCats($idx, $array['categoryids']);
    }

    function deleteFeed($idx, &$array) {
        global $serendipity;

        if (serendipity_db_bool($this->get_config('delete_dependencies'))) {
            $q = "SELECT e.id
                    FROM {$serendipity['dbPrefix']}entries AS e
         LEFT OUTER JOIN {$serendipity['dbPrefix']}entryproperties AS ep
                      ON e.id = ep.entryid
                   WHERE ep.property = 'ep_aggregator_feed'
                     AND ep.value = " . (int)$idx;
            $entries = serendipity_db_query($q);

            if (is_array($entries)) {
                $id_list = array();
                foreach($entries AS $entry) {
                    $id_list[] = $entry['id'];
                }

                $this->purgeEntries($id_list);
            }
        }

        if (!$this->deleteFeedCats($idx)) {
            return false;
        }
        $q = "DELETE FROM {$serendipity['dbPrefix']}aggregator_feeds
                    WHERE feedid = " . (int)$idx;

        return serendipity_db_query($q);
    }

    function insertFeed(&$array) {
        global $serendipity;

        $query = "SELECT authorid
                    FROM {$serendipity['dbPrefix']}authors
                   WHERE realname='" . serendipity_db_escape_string($array['feedname']) . "'";
        if (!is_array($res = serendipity_db_query($query))) {
            serendipity_db_insert('authors', array('username'      => $array['feedname'],
                                                   'realname'      => $array['feedname'],
                                                   'password'      => md5(mt_rand()),
                                                   'email'         => $array['htmlurl'],
                                                   'userlevel'     => 0,
                                                   'right_publish' => 1));
            $res = serendipity_db_query($query);
        }

        $r = serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}aggregator_feeds
                                                 (feedname, feedurl, htmlurl, charset, match_expression, feedicon, last_update)
                                        VALUES ('" . serendipity_db_escape_string($array['feedname']) . "',
                                                '" . serendipity_db_escape_string($array['feedurl']) . "',
                                                '" . serendipity_db_escape_string($array['htmlurl']) . "',
                                                '" . serendipity_db_escape_string($array['charset']) . "',
                                                '" . serendipity_db_escape_string($array['match_expression']) . "',
                                                '" . serendipity_db_escape_string($array['feedicon']) . "',
                                                '" . time() . "')");
        if ($r == false) {
            return $r;
        }

        if (!is_array($array['categoryids'])) {
            $array['categoryids']   = array();
            $array['categoryids'][] = $array['categoryid'];
        }

        return $this->insertFeedCats(serendipity_db_insert_id(), $array['categoryids']);
    }

    function insertFeedCats($idx, $categories) {
        global $serendipity;
        if (!is_array($categories)) {
            return true;
        }

        foreach ($categories as $categoryid) {
            $r = serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}aggregator_feedcat
                                                   (feedid, categoryid)
                                            VALUES ('" . $idx . "',
                                                    '" . (int)$categoryid . "')");
            if ($r == false) {
                return false;
            }
        }
        return true;
    }

    function deleteFeedCats($idx) {
        global $serendipity;
        $q = "DELETE FROM {$serendipity['dbPrefix']}aggregator_feedcat
                    WHERE feedid = " . (int)$idx;
        return serendipity_db_query($q);
    }

    function &fetchCat($name, $selected = 0) {
        global $serendipity;

        $n = "\n";
        $cat_list = '<select name="' . $name . '" multiple="multiple" size="4">';
        $cat_list .= '    <option value="0"' . (empty($selected) ? ' selected="selected"' : '') . '>[' . NO_CATEGORY . ']</option>' . $n;
        if (is_array($cats = serendipity_fetchCategories())) {
            $cats = serendipity_walkRecursive($cats, 'categoryid', 'parentid', VIEWMODE_THREADED);
            foreach ($cats as $cat) {
                $cat_list .= '<option value="'. $cat['categoryid'] .'"'. (in_array($cat['categoryid'], $selected) ? ' selected="selected"' : '') .'>'. str_repeat('&nbsp;', $cat['depth']) . $cat['category_name'] .'</option>' . "\n";
            }
        }
        $cat_list .= '</select>';

        return $cat_list;
    }

    function showFeeds() {
        # Shows feeds in admin area
        global $serendipity;

        if (!empty($serendipity['POST']['aggregatorAction'])) {
            $this->createFeeds();
        } elseif (!empty($serendipity['POST']['aggregatorOPMLImport'])) {
            $this->importOPML();
        }

        $feeds = $this->getFeeds();
        $feeds[] = array(
            'feedid'            => 0,
            'feedname'          => '',
            'feedurl'           => '',
            'charset'           => '',
            'htmlurl'           => '',
            'match_expression'  => '',
            'feedicon'          => '',
            'categoryids'       => array(),
            'last_update'       => time()
        );

        echo '<h2>' . PLUGIN_AGGREGATOR_TITLE . '</h2>';
        echo PLUGIN_AGGREGATOR_DESC . '<br /><br />';
        echo PLUGIN_AGGREGATOR_FEEDLIST . '<br /><br />';

        echo '
            <form action="?" method="post">
            <div>
                <input type="hidden" name="serendipity[adminModule]" value="event_display" />
                <input type="hidden" name="serendipity[adminAction]" value="aggregator" />
            </div>
            <table align="center" width="100%" cellpadding="5" cellspacing="0" border=0>
                <tr>
                    <th>#</th>
                    <th>' . PLUGIN_AGGREGATOR_FEEDNAME . '</th>
                    <th width="100%">' . PLUGIN_AGGREGATOR_FEEDURI . ' / ' . PLUGIN_AGGREGATOR_HTMLURI . '</th>
                    <th>' . PLUGIN_AGGREGATOR_CATEGORIES . '</th>
                    <th>' . PLUGIN_AGGREGATOR_MATCH_EXPRESSION . '* / ' . PLUGIN_AGGREGATOR_FEEDICON . '</th>
                </tr>';

        $evenidx = 0;
        foreach($feeds AS $idx => $feed) {
            $cat = $this->fetchCat("serendipity[feed][{$feed['feedid']}][categoryids][]", $feed['categoryids']);
            $even = ($evenidx++ % 2 ? 'even' : 'uneven');
            echo '
            <tr style="padding: 10px;" class="serendipity_admin_list_item serendipity_admin_list_item_' . $even . '">
                <td valign="top"><em>' . $idx . '</em></td>
                <td valign="top">
                    <input class="input_textbox" type="text" name="serendipity[feed][' . $feed['feedid'] . '][feedname]" value="' . htmlspecialchars($feed['feedname']) . '" /> ' . htmlspecialchars($feed['charset']) . '
                </td>
                <td width="100%" valign="top">
                    <input class="input_textbox" style="width: 100%" type="text" name="serendipity[feed][' . $feed['feedid'] . '][feedurl]" value="' . htmlspecialchars($feed['feedurl']) . '" />
                    <input class="input_textbox" style="width: 65%; margin-top: 2px;" type="text" name="serendipity[feed][' . $feed['feedid'] . '][htmlurl]" value="' . htmlspecialchars($feed['htmlurl']) . '" />
                </td>
                <td valign="top" rowspan="2">' . $cat . '</td>
                <td valign="top" rowspan="2"><textarea rows=6 cols=25 name="serendipity[feed][' . $feed['feedid'] . '][match_expression]">' . htmlspecialchars($feed['match_expression']) . '</textarea><br />
                    <input class="input_textbox" style="width: 65%; margin-top: 2px;" type="text" name="serendipity[feed][' . $feed['feedid'] . '][feedicon]" value="' . htmlspecialchars($feed['feedicon']) . '" />

            </tr>
            <tr style="padding: 10px;" class="serendipity_admin_list_item serendipity_admin_list_item_' . $even . '">
                <td></td>
                <td colspan="2" valign="top">
                    <div style="font-size: 8pt;">' . PLUGIN_AGGREGATOR_FEEDUPDATE . ' ' . serendipity_formatTime(DATE_FORMAT_SHORT, $feed['last_update']) . '</div>
                </td>
            </tr>';
        }

        echo '
            <tr>
                <td colspan="4"><br />
                    <input type="submit" name="serendipity[aggregatorAction]" value="' . GO . '" class="serendipityPrettyButton input_button" />
                </td>
            </tr>
            </table>
            * ' . PLUGIN_AGGREGATOR_MATCH_EXPRESSION_DESC . '
            </form>';

        echo '
            <form action="?" method="post">
            <div>
                <input type="hidden" name="serendipity[adminModule]" value="event_display" />
                <input type="hidden" name="serendipity[adminAction]" value="aggregator" />
            </div>

            <div>
                <hr /><strong>
                ' . PLUGIN_AGGREGATOR_IMPORTFEEDLIST. '</strong><br /><br />
                ' . PLUGIN_AGGREGATOR_IMPORTFEEDLIST_DESC . '<br /><br />
                URL: <input class="input_textbox" type="text" name="serendipity[aggregatorOPML]" value="http://" /><br />
                <input class="input_checkbox" type="checkbox" id="import_categories" name="serendipity[aggregatorOPMLCategories]" value="true" /><label for="import_categories">' . PLUGIN_AGGREGATOR_IMPORTCATEGORIES . '</label>
                <input class="input_checkbox" type="checkbox" id="import_categories2" name="serendipity[aggregatorOPMLCategoriesNoNesting]" value="true" /><label for="import_categories2">' . PLUGIN_AGGREGATOR_IMPORTCATEGORIES2 . '</label>
                <br /><br />
                <input type="submit" name="serendipity[aggregatorOPMLImport]" value="' . PLUGIN_AGGREGATOR_IMPORTFEEDLIST_BUTTON . '" class="serendipityPrettyButton input_button" />
            </div>

            <div>
                <hr /><strong>
                ' . PLUGIN_AGGREGATOR_EXPORTFEEDLIST. '</strong><br /><br />
                <a href="' . serendipity_rewriteURL('plugin/opmlfeeds.xml') . '" class="serendipityPrettyButton">' . PLUGIN_AGGREGATOR_EXPORTFEEDLIST_BUTTON . '</a>
            </div>
            </form>';
    }

    function importOPML() {
        $tree = $this->importFeeds();
        if (!$tree) {
            return;
        }
        $this->removeFeeds();
        $this->cats = serendipity_fetchCategories();

        foreach($tree AS $xml_base) {
            if ($xml_base['tag'] != 'opml' || !is_array($xml_base['children'])) {
                continue;
            }

            foreach($xml_base['children'] AS $xml_body) {
                if ($xml_body['tag'] != 'body' || !is_array($xml_body['children'])) {
                    continue;
                }

                foreach($xml_body['children'] AS $xml_outline) {
                    $this->parseOutline($xml_outline);
                }
            }
        }

        serendipity_rebuildCategoryTree();
    }

    function serendipity_addCategory($name, $desc, $authorid, $icon, $parentid) {
        global $serendipity;
        $query = "INSERT INTO {$serendipity['dbPrefix']}category
                        (category_name, category_description, authorid, category_icon, parentid, category_left, category_right)
                      VALUES
                        ('". serendipity_db_escape_string($name) ."',
                         '". serendipity_db_escape_string($desc) ."',
                          ". (int)$authorid .",
                         '". serendipity_db_escape_string($icon) ."',
                          ". (int)$parentid .",
                           0,
                           0)";

        return serendipity_db_query($query);
    }

    function newCategory($parent, $last_parent_id) {
        global $serendipity;

        if (function_exists('serendipity_addCategory')) {
            $parent_id = serendipity_addCategory($parent, '', 0, '', $last_parent_id);
        } else {
            $this->serendipity_addCategory($parent, '', 0, '', $last_parent_id);
            $parent_id = serendipity_db_insert_id('category', 'categoryid');
        }

        return $parent_id;
    }

    function fetchCategoryParent($parentname) {
        if (!is_array($this->cats)) {
            return false;
        }

        foreach($this->cats AS $cat) {
            if ($cat['category_name'] == $parentname) {
                return $cat['categoryid'];
            }
        }

        return false;
    }

    function parseOutline(&$xml_outline, $last_parent_name = '', $last_parent_id = 0) {
        global $serendipity;

        if (!empty($xml_outline['attributes']['title'])) {
            $parent = $xml_outline['attributes']['title'];
        } elseif (!empty($xml_outline['attributes']['text'])) {
            $parent = $xml_outline['attributes']['text'];
        } elseif (!empty($xml_outline['attributes']['id'])) {
            $parent = $xml_outline['attributes']['id'];
        } else {
            $parent = time();
        }

        if ($xml_outline['tag'] == 'outline' && is_array($xml_outline['children'])) {
            if ($serendipity['POST']['aggregatorOPMLCategories'] && $parent_id = $this->fetchCategoryParent($parent)) {
                printf(PLUGIN_AGGREGATOR_CATEGORYSKIPPED, $parent);
                echo "<br />\n";
            } elseif ($serendipity['POST']['aggregatorOPMLCategories']) {
                $parent_id = $this->newCategory($parent, $last_parent_id);
            }

            foreach($xml_outline['children'] AS $xml_child) {
                $this->parseOutline($xml_child, $parent, $parent_id);
            }
        } else {
            if ($serendipity['POST']['aggregatorOPMLCategoriesNoNesting']) {
                $last_parent_id = $this->newCategory($parent, $last_parent_id);
            }

            $newfeed = array(
                'feedname'   => $parent,
                'feedurl'    => $xml_outline['attributes']['xmlUrl'],
                'htmlurl'    => $xml_outline['attributes']['htmlUrl'],
                'categoryid' => $last_parent_id,
                'charset'    => ''
            );

            $this->insertFeed($newfeed);
        }

        return true;
    }

    function &importFeeds() {
        // Used by ImportOPML routine

        global $serendipity;

        $file = $serendipity['POST']['aggregatorOPML'];
        require_once (defined('S9Y_PEAR_PATH') ? S9Y_PEAR_PATH : S9Y_INCLUDE_PATH . 'bundled-libs/') . 'HTTP/Request.php';
        if (function_exists('serendipity_request_start')) {
            serendipity_request_start();
        }
        $req = new HTTP_Request($file);

        if (PEAR::isError($req->sendRequest()) || $req->getResponseCode() != '200') {
            $data = file_get_contents($file);
            if (empty($data)) {
                return false;
            }
        } else {
            // Fetch file
            $data = $req->getResponseBody();
        }

        if (function_exists('serendipity_request_end')) {
            serendipity_request_end();
        }

        // XML functions
        $xml_string = '<?xml version="1.0" encoding="UTF-8" ?>';
        if (preg_match('@(<\?xml.+\?>)@imsU', $data, $xml_head)) {
            $xml_string = $xml_head[1];
        }

        $encoding = 'UTF-8';
        if (preg_match('@encoding="([^"]+)"@', $xml_string, $xml_encoding)) {
            $encoding = $xml_encoding[1];
        }

        // Global replacements
        // by: waldo@wh-e.com - trim space around tags not within
        $data = preg_replace('@>[[:space:]]+<@i', '><', $data);

        switch(strtolower($encoding)) {
            case 'iso-8859-1':
            case 'utf-8':
                $p = xml_parser_create($encoding);
                break;

            default:
                $p = xml_parser_create('');
        }

        // by: anony@mous.com - meets XML 1.0 specification
        xml_parser_set_option($p, XML_OPTION_CASE_FOLDING, 0);
        @xml_parser_set_option($p, XML_OPTION_TARGET_ENCODING, LANG_CHARSET);
        xml_parse_into_struct($p, $data, $vals, $index);
        xml_parser_free($p);

        $i = 0;
        $tree = array();
        $tree[] = array(
            'tag'        => $vals[$i]['tag'],
            'attributes' => $vals[$i]['attributes'],
            'value'      => $vals[$i]['value'],
            'children'   => $this->GetChildren($vals, $i)
        );

        return $tree;
    }

    function &GetChildren($vals, &$i) {
        $children = array();
        $cnt = sizeof($vals);
        while (++$i < $cnt) {
            // compare type
            switch ($vals[$i]['type']) {
                case 'cdata':
                    $children[] = $vals[$i]['value'];
                    break;

                case 'complete':
                    $children[] = array(
                        'tag'        => $vals[$i]['tag'],
                        'attributes' => $vals[$i]['attributes'],
                        'value'      => $vals[$i]['value']
                    );
                    break;

                case 'open':
                    $children[] = array(
                        'tag'        => $vals[$i]['tag'],
                        'attributes' => $vals[$i]['attributes'],
                        'value'      => $vals[$i]['value'],
                        'children'   => $this->GetChildren($vals, $i)
                    );
                    break;

                case 'close':
                    return $children;
            }
        }
    }

    function insertProperties($entryid, $feed, $md5hash = null) {
        global $serendipity;

        $sql = "SELECT * FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = $entryid AND property = 'ep_aggregator_feed'";
        $props = serendipity_db_query($sql, true);
        if (!is_array($props) || empty($props['entryid'])) {
            $sql = "INSERT INTO {$serendipity['dbPrefix']}entryproperties
                                (entryid, property, value)
                         VALUES ('$entryid', 'ep_aggregator_feed', '" . serendipity_db_escape_string($feed['feedid']) . "')";
            serendipity_db_query($sql);

            $sql = "INSERT INTO {$serendipity['dbPrefix']}entryproperties
                                (entryid, property, value)
                         VALUES ('$entryid', 'ep_aggregator_feedname', '" . serendipity_db_escape_string($feed['feedname']) . "')";
            serendipity_db_query($sql);

            $sql = "INSERT INTO {$serendipity['dbPrefix']}entryproperties
                                (entryid, property, value)
                         VALUES ('$entryid', 'ep_aggregator_feedurl', '" . serendipity_db_escape_string($feed['feedurl']) . "')";
            serendipity_db_query($sql);

            $sql = "INSERT INTO {$serendipity['dbPrefix']}entryproperties
                                (entryid, property, value)
                         VALUES ('$entryid', 'ep_aggregator_htmlurl', '" . serendipity_db_escape_string($feed['htmlurl']) . "')";
            serendipity_db_query($sql);

            $sql = "INSERT INTO {$serendipity['dbPrefix']}entryproperties
                                (entryid, property, value)
                         VALUES ('$entryid', 'ep_aggregator_categoryid', '" . serendipity_db_escape_string($feed['categoryid']) . "')";
            serendipity_db_query($sql);

            $sql = "INSERT INTO {$serendipity['dbPrefix']}entryproperties
                                (entryid, property, value)
                         VALUES ('$entryid', 'ep_aggregator_articleurl', '" . serendipity_db_escape_string($feed['articleurl']) . "')";
            serendipity_db_query($sql);

            $sql = "INSERT INTO {$serendipity['dbPrefix']}entryproperties
                                (entryid, property, value)
                         VALUES ('$entryid', 'ep_aggregator_author', '" . serendipity_db_escape_string($feed['author']) . "')";
            serendipity_db_query($sql);

            $sql = "INSERT INTO {$serendipity['dbPrefix']}entryproperties
                                (entryid, property, value)
                         VALUES ('$entryid', 'ep_flattr_active', '-1')";
                                serendipity_db_query($sql);
                                                                                 
            # We will be using this for duplicate detection
            # same articleurl and same md5 property -> dupe
            $t = time();
            $sql  = "INSERT INTO {$serendipity['dbPrefix']}aggregator_md5
                                 (entryid, md5, timestamp)
                          VALUES ('$entryid', '$md5hash', '$t')";
            serendipity_db_query($sql);
        }

        $this->feedupdate_finish($feed, $entryid);
     }
    
    function feedupdate_finish(&$feed, $entryid) {
        global $serendipity;
        
        $t = time();
        $sql = "UPDATE {$serendipity['dbPrefix']}aggregator_feeds SET last_update = " . time() . " WHERE feedid = " . (int)$feed['feedid'];
        serendipity_db_query($sql);

        if (empty($feed['feedicon']) && !empty($feed['new_feedicon'])) {
            $sql = "UPDATE {$serendipity['dbPrefix']}aggregator_feeds SET feedicon = '" . serendipity_db_escape_string($feed['new_feedicon']) . "' WHERE feedid = " . (int)$feed['feedid'];
            serendipity_db_query($sql);
        }
        
        # Always update the MD5 hash, to catch updates of an entry properly. Patch by jerwarren!
        $sql = "UPDATE {$serendipity['dbPrefix']}aggregator_md5   SET timestamp = '$t', md5='$md5hash' WHERE entryid = " . (int)$entryid;
        serendipity_db_query($sql);
    }

    function decode($charset, &$array)
    {
        if (LANG_CHARSET == 'ISO-8859-1' || LANG_CHARSET == 'UTF-8')
        {
        // Luckily PHP5 supports
        // xml_parser_set_option($this->parser, XML_OPTION_TARGET_ENCODING, LANG_CHARSET);
        // which means we need no transcoding here.
            return true;
        }
        if ($charset == LANG_CHARSET) {
            return true;
        } elseif ($charset == 'utf-8') {
            foreach($array AS $key => $val) {
                $array[$key] = utf8_decode($val);
            }
        } elseif ($charset == 'iso-8859-1') {
            foreach($array AS $key => $val) {
                if (function_exists('iconv')) {
                    $array[$key] = iconv('ISO-8859-1', LANG_CHARSET, $val);
                } elseif (function_exists('recode')) {
                    $array[$key] = recode('iso-8859-1..' . LANG_CHARSET, $val);
                }
            }
        }
        return true;
    }

    function parseDate($time) {
        if (empty($time)) {
            if ($this->debug) printf("DEBUG: parseDate(%s) is empty\n", $time);
            return -1;
        }

        $date = strtotime($time);

        if ($date > 0) {
            if ($this->debug) printf("DEBUG: parseDate(%s) as %s (strtotime)\n", $time, date('Y-m-d H:i:s', $date));
            return $date;
        }

        if (preg_match('@^([0-9]{4})\-([0-9]{2})\-([0-9]{2})T([0-9]{2}):([0-9]{2}):([0-9]{2})(?::\-([0-9]{2}):([0-9]{2}))?@', $time, $timematch)) {
            $date = mktime($timematch[4] - $timematch[7], $timematch[5] - $timematch[8], $timematch[6], $timematch[2], $timematch[3], $timematch[1]);
            if ($this->debug) printf("DEBUG: parseDate(%s) as %s (preg_match)\n", $time, date('Y-m-d H:i:s', $date));
            return $date;
        }

        if ($this->debug) printf("DEBUG: parseDate(%s) is unparseable\n", $time);
        return -1;
    }

    function checkCharset(&$feed)
    {
        global $serendipity;
        require_once (defined('S9Y_PEAR_PATH') ? S9Y_PEAR_PATH : S9Y_INCLUDE_PATH . 'bundled-libs/') . 'HTTP/Request.php';
        $req = new HTTP_Request($feed['feedurl']);
        if (PEAR::isError($req->sendRequest()) || $req->getResponseCode() != '200') {
            $data = file_get_contents($feed['feedurl']);
            if (empty($data)) {
                return false;
            }
        } else {
            # Fetch file
            $data = $req->getResponseBody();
        }
        #XML functions
        $xml_string = '<' . '?xml version="1.0" encoding="UTF-8"?' . '>';
        if (preg_match('@(\<\?xml.+\?\>)@imsU', $data, $xml_head)) {
            $xml_string = $xml_head[1];
        }
        $encoding = 'UTF-8';
        if (preg_match('@encoding="([^"]+)"@', $xml_string, $xml_encoding)) {
            # may return iso-8859-15 or windows-1252, which are not valid
            # for the XML parser in PHP
            $encoding = $xml_encoding[1];
        }
        if (preg_match('@utf@i', $encoding)) {
          $encoding = "UTF-8";
        } else {
          $encoding = "iso-8859-1";
        }
        serendipity_db_query("UPDATE {$serendipity['dbPrefix']}aggregator_feeds
                                 SET charset = '" . serendipity_db_escape_string($encoding) . "'
                               WHERE feedid  = " . (int)$feed['feedid']);
        $feed['charset'] = $encoding;
        return $encoding;
    }

    function fetchFeeds($opt = null)
    {
        global $serendipity;

        set_time_limit(360);
        ignore_user_abort(true);
        $_SESSION['serendipityRightPublish'] = true;
        $serendipity['noautodiscovery'] = true;

        $this->setupDB();
        $feeds = $this->getFeeds($opt);

        $engine = $this->get_config('engine', 'onyx');
        if ($engine == 'onyx') {
            require_once (defined('S9Y_PEAR_PATH') ? S9Y_PEAR_PATH : S9Y_INCLUDE_PATH . 'bundled-libs/') . 'Onyx/RSS.php';
        } elseif ($engine == 'magpierss') {
            // CLSC: NEW "MagpieRSS" include
            require_once dirname(__FILE__) . '/magpierss/rss_fetch.inc';
        } elseif ($engine == 'simplepie') {
            //hwa: NEW "SimplePie" include
            require_once dirname(__FILE__) . '/simplepie/simplepie.inc';
        }   

        $cache_authors = array();
        $cache_entries = array();
        $cache_md5     = array();

        $sql_cache_authors = serendipity_db_Query("SELECT authorid, realname
                                                 FROM {$serendipity['dbPrefix']}authors");
        if (is_array($sql_cache_authors)) {
            foreach($sql_cache_authors AS $idx => $author) {
                $cache_authors[$author['realname']] = $author['authorid'];
            }
        }
        if ($this->debug) printf("DEBUG: cache_authors['realname'] = authorid has %d entries\n", count($cache_authors));

        if ($opt['store_seperate']) {
            $sql_cache_entries = serendipity_db_query("SELECT e.feedid, e.id, e.entrydate, e.entrytitle
                                                         FROM {$serendipity['dbPrefix']}aggregator_feedlist AS e");
            if (is_array($sql_cache_entries)) {
                foreach($sql_cache_entries AS $idx => $entry) {
                    $cache_entries[$entry['entrytitle']][$entry['feedid']][$entry['entrydate']] = $entry['id'];
                }
            }
        } else {
            $sql_cache_entries = serendipity_db_query("SELECT e.id, e.timestamp, e.authorid, e.title, ep.value
                                                         FROM {$serendipity['dbPrefix']}entries AS e,
                                                              {$serendipity['dbPrefix']}entryproperties AS ep
                                                        WHERE e.id = ep.entryid
                                                          AND ep.property = 'ep_aggregator_feed'");
            if (is_array($sql_cache_entries)) {
                foreach($sql_cache_entries AS $idx => $entry) {
                    $cache_entries[$entry['title']][$entry['authorid']][$entry['timestamp']] = $entry['id'];
                }
            }
        }
        if ($this->debug) printf("DEBUG: cache_entries['title']['authorid']['timestamp'] = entryid has %d entries.\n", count($cache_entries));

        $sql_cache_md5 = serendipity_db_query("SELECT entryid, md5, timestamp
                                                     FROM {$serendipity['dbPrefix']}aggregator_md5");
        if (is_array($sql_cache_md5)) {
            foreach($sql_cache_md5 AS $idx => $entry) {
                $cache_md5[$entry['md5']]['entryid'] = $entry['entryid'];
                $cache_md5[$entry['md5']]['timestamp'] = $entry['timestamp'];
            }
        }
        if ($this->debug) printf("DEBUG: cache_md5['md5'] = entryid has %d entries.\n", count($cache_md5));

        foreach($feeds AS $feed) {
            if (!$opt['store_seperate']) printf("Read %s.\n", $feed['feedurl']);
            flush();
            $feed_authorid = $cache_authors[$feed['feedname']];
            if (empty($feed_authorid))
            {
                $feed_authorid = 0;
            }
            if ($this->debug) printf("DEBUG: Current authorid = %d\n", $feed_authorid);

            $stack = array();
            if ($engine == 'onyx') {
                if (empty($feed['charset'])) {
                    $this->checkCharset($feed);
                }

                # test multiple likely charsets
                $charsets = array( $feed['charset'], "ISO-8859-1", "utf-8");
                $retry = false;
                foreach ($charsets as $ch) {
                    if ($retry) printf("DEBUG: Retry with charset %s instead of %s\n", $ch, $feed['charset']);
                    $retry = true;
                    $c = new Onyx_RSS($ch);
                    # does it parse? if so, all is fine...
                    if ($c->parse($feed['feedurl']))
                    break;
                }

                while ($item = $c->getNextItem()) {
                    /* Okay this is where things get tricky. Everybody
                     * encodes their information differently. For now I'm going to focus on
                     * s9y weblogs. */
                    $fake_timestamp = false;
                    $date = $this->parseDate($item['pubdate']);
                    if ($this->debug) printf("DEBUG: pubDate %s = %s\n", $item['pubdate'], $date);
                    if ($date == -1) {
                        // Fallback to try for dc:date
                        $date = $this->parseDate($item['dc:date']);
                        if ($this->debug) printf("DEBUG: falling back to dc:date % s= %s\n", $item['dc:date'], $date);
                    }
                    if ($date == -1) {
                        // Couldn't figure out the date string. Set it to "now" and hope that the md5hash will get it.
                        $date           = time();
                        $fake_timestamp = true;
                        if ($this->debug) printf("DEBUG: falling back to time() = %s\n", $date);
                    }
                    if (empty($item['title'])) {
                        if ($this->debug) printf("DEBUG: skip item: title was empty for %s\n", print_r($item, true));
                        continue;
                    }
                    $this->decode($c->rss['encoding'], $item);
                    $item['date'] = $date;
                    $stack[] = $item;
                }

            } elseif ($engine == 'magpierss') {
                // ----------------------------------------------------------
                // CLSC: New MagpieRSS code start
                // ----------------------------------------------------------

                $rss = fetch_rss($feed['feedurl']);
                foreach ($rss->items as $item) {
                    $fake_timestamp = false;
                    $date = $item['pubdate'];
                    if ($this->debug) printf("DEBUG: pubdate = %s\n", $item['pubdate'], $date);

                    // ----------------------------------------------------------
                    // CLSC:        Try a few different types of timestamp fields
                    //                So that we might get lucky even with non-standard feeds
                    // ----------------------------------------------------------

                    if ($date == "") {
                        // CLSC: magpie syntax for nested fields
                        $date = $item['dc']['date'];
                        if ($this->debug) printf("DEBUG: falling back to [dc][date] = %s\n", $item['dc:date'], $date);
                    }

                    if ($date == "") {
                        $date = $item['modified'];
                        if ($this->debug) printf("DEBUG: falling back to modified = %s\n", $item['modified'], $date);
                    }

                    if ($date == "") {
                        $date = $item['PubDate'];
                        if ($this->debug) printf("DEBUG: falling back PubDate = %s\n", $item['PubDate'], $date);
                    }

                    if ($date == "") {
                        $date = $item['created'];
                        if ($this->debug) printf("DEBUG: falling back to created = %s\n", $item['created'], $date);
                    }

                    if ($date == "") {
                        // CLSC: not proper magpie syntax but still catches some
                        $date = $item['dc:date'];
                        if ($this->debug) printf("DEBUG: falling back to dc:date = %s\n", $item['dc:date'], $date);
                    }

                    if ($date == "") {
                        $date = $item['updated'];
                        if ($this->debug) printf("DEBUG: falling back to updated = %s\n", $item['updated'], $date);
                    }

                    if ($date == "") {
                        $date = $item['published'];
                        if ($this->debug) printf("DEBUG: falling back to published = %s\n", $item['published'], $date);
                    }

                    if ($date == "") {
                        // ----------------------------------------------------------
                        //    CLSC:        If none of the above managed to identify a date:
                        //                 Set date to "now" and hope that the md5hash will get it.
                        // ----------------------------------------------------------

                        $date = time();
                        $fake_timestamp = true;
                        if ($this->debug) printf("DEBUG: falling back to time() = %s\n", $date);
                    }

                    // CLSC: if date is set to "now" parseDate can't parse it.
                    if ($fake_timestamp != true) {
                        $date = $this->parseDate($date);
                    }

                    if ($item['title'] == "") {
                        if ($this->debug) printf("DEBUG: skip item: title was empty for %s\n", print_r($item, true));
                        continue;
                    }

                    $item['date'] = $date;
                    $stack[] = $item;
                    // ----------------------------------------------------------
                    //    CLSC: New MagpieRSS code end
                    // ----------------------------------------------------------
                }
            } elseif ($engine == 'simplepie') {

                // hwa: new SimplePie code  ; lifted from the SimplePie demo
                $simplefeed = new SimplePie();
                $simplefeed->cache=false;
                
                $simplefeed->set_feed_url($feed['feedurl']);
                
                // Initialize the whole SimplePie object.  Read the feed, process it, parse it, cache it, and 
                // all that other good stuff.  The feed's information will not be available to SimplePie before 
                // this is called.
                $success = $simplefeed->init();

                // We'll make sure that the right content type and character encoding gets set automatically.
                // This function will grab the proper character encoding, as well as set the content type to text/html.
                $simplefeed->set_output_encoding(LANG_CHARSET);
                $simplefeed->handle_content_type();
                $item['new_feedicon'] = $simplefeed->get_favicon();

                // error handling
                if ($simplefeed->error()) {
                    if (!$opt['store_seperate']) printf('<p><b>ERROR:</b> ' . htmlspecialchars($simplefeed->error()) . "</p>\r\n") ;
                }

                if ($success) {
                    foreach($simplefeed->get_items() as $simpleitem) {

                        // map SimplePie items to s9y items
                        $item['title']       = $simpleitem->get_title() ; 
                        $item['date']        = $simpleitem->get_date('U'); 
                        $item['pubdate']     = $simpleitem->get_date('U'); 
                        $item['description'] = $simpleitem->get_description();
                        $item['content']     = $simpleitem->get_content();
                        $item['link']        = $simpleitem->get_permalink(); 
                        $item['author']      = $simpleitem->get_author();
                        
                        //if ($this->debug) {
                        //  printf("DEBUG: SimplePie item: author: $item['author'], title: $item['title'], date: $item['date']\n");
                        //}
                        
                        $stack[] = $item;
                    }
                } else {
                    if (!$opt['store_seperate']) printf('<p><b>ERROR:</b> ' . print_r($success, true) . "</p>\r\n") ;
                }
           }

           while(list($key, $item) = each($stack)) {

                if ($opt['store_seperate']) {
                    $ep_id = $cache_entries[$item['title']][$feed['feedid']][$item['date']];
                    if ($this->debug) {
                            printf("DEBUG: lookup cache_entries[%s][%s][%s] finds %s.\n",
                                $item['title'],
                                $feed['feedid'],
                                $item['date'],
                                empty($ep_id)?"nothing":$ep_id
                            );
                    }
                } else {
                    $ep_id = $cache_entries[$item['title']][$feed_authorid][$item['date']];
                    if ($this->debug) {
                            printf("DEBUG: lookup cache_entries[%s][%s][%s] finds %s.\n",
                                $item['title'],
                                $feed_authorid,
                                $item['date'],
                                empty($ep_id)?"nothing":$ep_id
                            );
                    }
                }

                if (!empty($ep_id) and serendipity_db_bool($this->get_config('ignore_updates'))) {
                    if ($this->debug) printf("DEBUG: entry %s is known and ignore_updates is set.\n", $ep_id);
                    continue;
                }

                # NOTE: If $ep_id is NULL or EMPTY, it means that an entry with this title does not
                #       yet exist. Later on we check if a similar entry with the body exists and skip
                #       updates in this case. Else it means that the new entry needs to be inserted
                #       as a new one.

                # The entry is probably new?
                $entry = array('id'             => $ep_id,
                               'title'          => $item['title'],
                               'timestamp'      => $item['date'],
                               'extended'       => '',
                               'isdraft'        => serendipity_db_bool($this->get_config('publishflag')) ? 'false' : 'true',
                               'allow_comments' => serendipity_db_bool($this->get_config('allow_comments')) ? 'true' : 'false',
                               'categories'     => $feed['categoryids'],
                               'author'         => $feed['feedname'],
                               'authorid'       => $feed_authorid);

                // ----------------------------------------------------------
                //    CLSC: Added a few flavours
                if ($item['content:encoded']) {
                    $entry['body'] = $item['content:encoded'];
                } elseif ($item['description']) {
                    $entry['body'] = $item['description'];
                } elseif ($item['content']['encoded']) {
                    $entry['body'] = $item['content']['encoded'];
                } elseif ($item['atom_content']) {
                    $entry['body'] = $item['atom_content'];
                } elseif ($item['content']) {
                    $entry['body'] = $item['content'];
                }

                $md5hash = md5($feed_authorid . $item['title'] . $entry['body']);

                # Check 1: Have we seen this MD5?
                if ($this->debug) {
                    printf("DEBUG: lookup cache_md5[%s] finds %s.\n",
                        $md5hash,
                        empty($cache_md5[$md5hash]) ? "nothing" : $cache_md5[$md5hash]['entryid']
                    );
                }

                # If we have this md5, title and body for this article
                # are unchanged. We do not need to do anything.
                if (isset($cache_md5[$md5hash])) {
                    continue;
                }

                # Check 2 (conditional: expire enabled?):
                #         Is this article too old?
                if ($this->get_config('expire') > 0) {
                    $expire = time() - 86400 * $this->get_config('expire');

                    if ($item['date'] < $expire) {
                        if ($this->debug) printf("DEBUG: '%s' is too old (%s < %s).\n", $item['title'], $item['date'] , $expire);
                        continue;
                     }
                }

                # Check 3: Does this article match our expressions?
                if (!empty($feed['match_expression'])) {
                    $expressions = explode("~", $feed['match_expression']);
    
                    $match = 0;
                    foreach ($expressions as $expression) {
                        $expression = ltrim(rtrim($expression));
                        if (preg_match("~$expression~imsU", $entry['title'] . $entry['body'])) {
                            $match = 1;
                        }
                    }
    
                    if ($match == 0) {
                        continue;
                    }
                }

                $feed['articleurl'] = $item['link'];

                if ($item['author']) {
                    $feed['author'] = $item['author'];
                } elseif ($item['dc:creator']) {
                    $feed['author'] = $item['dc:creator'];
                }

                // Store as property

                // Plugins might need this.
                $serendipity['POST']['properties'] = array('fake' => 'fake');

                $markups = explode('^', $this->get_config('markup'));
                if (is_array($markups)) {
                    foreach($markups AS $markup) {
                        $serendipity['POST']['properties']['disable_markups'][] = $markup;
                    }
                }

                if ($opt['store_seperate']) {
                    if ($entry['id'] > 0) {
                        serendipity_db_query("UPDATE {$serendipity['dbPrefix']}aggregator_feedlist 
                        SET feedid      = '" . $feed['feedid'] . "',
                            categoryid  = '" . $feed['categoryids'][0] . "',
                            entrydate   = '" . serendipity_db_escape_string($entry['timestamp']) . "',
                            entrytitle  = '" . serendipity_db_escape_string($entry['title']) . "',
                            entrybody   = '" . serendipity_db_escape_string($entry['body']) . "',
                            entryurl    = '" . serendipity_db_escape_string($item['link']) . "'
                        WHERE id = " . $entry['id']);
                        $entryid = $entry['id'];
                    } else {
                        serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}aggregator_feedlist (
                            feedid,
                            categoryid,
                            entrydate,
                            entrytitle,
                            entrybody,
                            entryurl
                        ) VALUES (
                            '" . $feed['feedid'] . "',
                            '" . $feed['categoryids'][0] . "',
                            '" . serendipity_db_escape_string($entry['timestamp']) . "',
                            '" . serendipity_db_escape_string($entry['title']) . "',
                            '" . serendipity_db_escape_string($entry['body']) . "',
                            '" . serendipity_db_escape_string($item['link']) . "'
                        )");
                        $entryid = serendipity_db_insert_id();
                    }
                    $this->feedupdate_finish($feed, $entryid);
                } else {
                    $entryid = serendipity_updertEntry($entry);
                    $this->insertProperties($entryid, $feed, $md5hash);
                }
                if (!$opt['store_seperate']) printf(" Save '%s' as %s.\n", $item['title'], $entryid);
            }
            if (!$opt['store_seperate']) printf("Finish feed.\n");
        }
        if (!$opt['store_seperate']) printf("Finish planetarium.\n");
    }

    function generate_content(&$title) {
        $title = PLUGIN_AGGREGATOR_TITLE;
    }

    function showRecursive($ary, &$xml, $child_name = 'id', $parent_name = 'parent_id', $parentid = 0) {
        global $serendipity;

        if ( sizeof($ary) == 0 ) {
            return array();
        }

        if ($parentid === VIEWMODE_THREADED) {
            $parentid = 0;
        }

        foreach ($ary as $data) {
            if ($parentid === VIEWMODE_LINEAR || !isset($data[$parent_name]) || $data[$parent_name] == $parentid) {
                echo '<outline title="' . serendipity_utf8_encode($data['category_name']) . '">' . "\n";

                if (is_array($xml[$data['categoryid']])) {
                    foreach($xml[$data['categoryid']] AS $feed) {
                        if (empty($feed['feedurl'])) {
                            continue;
                        }

                        printf('    <outline title="%s" xmlUrl="%s" htmlUrl="%s" description="%s" />' . "\n",
                            serendipity_utf8_encode(htmlspecialchars($feed['feedname'])),
                            serendipity_utf8_encode(htmlspecialchars($feed['feedurl'])),
                            serendipity_utf8_encode(htmlspecialchars($feed['htmlurl'])),
                            serendipity_utf8_encode(htmlspecialchars($feed['feedname']))
                        );
                    }
                }

                if ($data[$child_name] && $parentid !== VIEWMODE_LINEAR ) {
                    $this->showRecursive($ary, $xml, $child_name, $parent_name, $data[$child_name]);
                }

                echo "</outline>\n";
            }
        }

        return true;
    }
    
    function parseShowFeed(&$eventData) {
        global $serendipity;

        $cmd = explode('|', $eventData);
        $opt = array();
        foreach($cmd AS $cmdpart) {
            $cmdpart = trim($cmdpart);
            $cmdpart2 = explode(':', $cmdpart);
            
            if (!empty($cmdpart) && !empty($cmdpart2[1])) {
                $opt[$cmdpart2[0]] = $cmdpart2[1];
            }
        }
        
        if (empty($opt['cachetime'])) {
            $opt['cachetime'] = 3600;
        }
        
        if (empty($opt['template'])) {
            $opt['template'] = 'feedlist.tpl';
        }

        $opt['store_seperate'] = true;
        
        $fkey = 'last_showfeed_' . md5(serialize($opt));
        if (time() - $this->get_config($fkey) > $opt['cachetime']) {
            $this->set_config($fkey, time());
            $this->fetchFeeds($opt);
        }


        $q = "SELECT fl.*,
                     f.feedname,
                     f.htmlurl,
                     f.feedicon
                 FROM {$serendipity['dbPrefix']}aggregator_feedlist AS fl
      LEFT OUTER JOIN {$serendipity['dbPrefix']}aggregator_feedlist AS fl2
                   ON (fl.feedid = fl2.feedid AND fl.entrydate < fl2.entrydate)
                 JOIN {$serendipity['dbPrefix']}aggregator_feeds AS f
                   ON fl.feedid = f.feedid
                WHERE fl2.feedid IS NULL
                      " . ($opt['category'] > 0 ? "AND fl.categoryid IN (" . $opt['category'] . ") " : "") . "
               GROUP BY fl.feedid
               ORDER BY fl.entrydate DESC
        ";
/*
        $q = "SELECT fl.*,
                                     f.feedname,
                                     f.htmlurl,
                                     f.feedicon
                                FROM {$serendipity['dbPrefix']}aggregator_feedlist AS fl
                                JOIN {$serendipity['dbPrefix']}aggregator_feeds AS f
                                  ON fl.feedid = f.feedid
                               " . ($opt['category'] > 0 ? "WHERE fl.categoryid IN (" . $opt['category'] . ") " : "") . "
                            GROUP BY fl.feedid
                            ORDER BY fl.entrydate DESC
                            ";
*/
        $show = serendipity_db_query($q);
        $serendipity['smarty']->assign('feedlist_entries', $show);
        echo $this->parse_template($opt['template']);
        // 
        // Feed Icon parsen und in feeds speichern
        return true;
    }
    
    function parse_template($filename) {
        global $serendipity;

        $filename = basename($filename);
        $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
        if (!$tfile || $tfile == $filename) {
            $tfile = dirname(__FILE__) . '/' . $filename;
        }
        $inclusion = $serendipity['smarty']->security_settings[INCLUDE_ANY];
        $serendipity['smarty']->security_settings[INCLUDE_ANY] = true;
        $content = $serendipity['smarty']->fetch('file:'. $tfile);
        $serendipity['smarty']->security_settings[INCLUDE_ANY] = $inclusion;

        return $content;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        $this->debug = serendipity_db_bool($this->get_config('debug'));

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_sidebar_entries':
                    if ($serendipity['serendipityUserlevel'] >= USERLEVEL_CHIEF) {
?>
                    <li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=aggregator"><?php echo PLUGIN_AGGREGATOR_TITLE; ?></a></li>
<?php
                    }
                    break;

                case 'backend_sidebar_entries_event_display_aggregator':
                    $this->showFeeds();
                    break;

                case 'cronjob':
                    if ($this->get_config('cronjob') == $eventData) {
                        serendipity_event_cronjob::log('Aggregator', 'plugin');
                        $this->fetchFeeds();
                        # Fetch first, expire later (some feeds offer old stuff)
                        $this->expireFeeds();
                    }
                    return true;
                    break;

                case 'aggregator_feedlist':
                    $this->parseShowFeed($eventData);
                    return true;
                    break;

                case 'external_plugin':
                    if ($eventData == 'opmlfeeds.xml') {
                        header('Content-Type: text/xml; charset=utf-8');
                        echo '<?xml version="1.0" encoding="utf-8" ?>' . "\n";
                        $modified = gmdate('D, d M Y H:i:s \G\M\T', serendipity_serverOffsetHour(time(), true));

                        print <<<EOF
<opml version="1.0">
<head>
    <title>{$serendipity['blogTitle']}</title>
    <dateModified>{$modified}</dateModified>
    <ownerName>Serendipity - http://www.s9y.org/</ownerName>
</head>
<body>
EOF;

                        $feeds = serendipity_db_Query("
                                    SELECT c.categoryid,
                                           f.feedname,
                                           f.feedurl,
                                           f.htmlurl
                                     FROM {$serendipity['dbPrefix']}category AS c
                                LEFT JOIN {$serendipity['dbPrefix']}aggregator_feedcat AS fc
                                       ON fc.categoryid = c.categoryid
                                LEFT JOIN {$serendipity['dbPrefix']}aggregator_feeds AS f
                                       ON fc.feedid = f.feedid", false, 'assoc');

                        $xml = array();
                        if (is_array($feeds)) {
                            foreach($feeds AS $feed) {
                                $xml[$feed['categoryid']][] = $feed;
                            }
                        }
                        if (is_array($cats = serendipity_fetchCategories())) {
                            $cats = $this->showRecursive($cats, $xml, 'categoryid', 'parentid', VIEWMODE_THREADED);
                        }

                        print "</body>\n</opml>";
                        return;
                    }

                    if ($eventData != 'aggregator') {
                        return;
                    }

                    $this->fetchFeeds();
                    # Fetch first, expire later (some feeds offer old stuff)
                    $this->expireFeeds();
                    break;
            }
        }

        return true;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
