<?php # 

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_POPULARENTRIES extends serendipity_plugin {
    var $title = PLUGIN_POPULARENTRIES_TITLE;

    function introspect(&$propbag) {
        $this->title = $this->get_config('title', $this->title);

        $propbag->add('name',          PLUGIN_POPULARENTRIES_TITLE);
        $propbag->add('description',   PLUGIN_POPULARENTRIES_BLAHBLAH);
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Kaustubh Srikanth');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '1.10.2');
        $propbag->add('configuration', array('title', 'sortby', 'number', 'number_from', 'category', 'commentors_hide'));
        $propbag->add('groups', array('STATISTICS'));
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;
        
        switch($name) {
            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        TITLE);
                $propbag->add('description', TITLE_FOR_NUGGET);
                $propbag->add('default',     PLUGIN_POPULARENTRIES_TITLE);
                break;

            case 'number':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_POPULARENTRIES_NUMBER);
                $propbag->add('description', PLUGIN_POPULARENTRIES_NUMBER_BLAHBLAH);
                $propbag->add('default', 10);
                break;

            case 'number_from':
                $propbag->add('type', 'radio');
                $propbag->add('name', PLUGIN_POPULARENTRIES_NUMBER_FROM);
                $propbag->add('description', PLUGIN_POPULARENTRIES_NUMBER_FROM_DESC);
                $propbag->add('radio',  array(
                    'value' => array('all', 'skip'),
                    'desc'  => array(PLUGIN_POPULARENTRIES_NUMBER_FROM_RADIO_ALL, PLUGIN_POPULARENTRIES_NUMBER_FROM_RADIO_POPULAR)
                    ));
                $propbag->add('default', 'all');
                break;

            case 'sortby':
                $propbag->add('type', 'radio');
                $propbag->add('name', PLUGIN_POPULARENTRIES_SORTBY);
                $propbag->add('description', '');
                $propbag->add('radio_per_row', '1');
                $propbag->add('radio',  array(
                    'value' => array('comments', 'commentors', 'visits', 'lowvisits', 'exits', 'karma'),
                    'desc'  => array(PLUGIN_POPULARENTRIES_SORTBY_COMMENTS, PLUGIN_POPULARENTRIES_SORTBY_COMMENTORS, PLUGIN_POPULARENTRIES_SORTBY_VISITS,PLUGIN_POPULARENTRIES_SORTBY_LOWVISITS, PLUGIN_POPULARENTRIES_SORTBY_EXITS, PLUGIN_POPULARENTRIES_SORTBY_KARMAVOTES)
                    ));
                $propbag->add('default', 'comments');
                break;

            case 'commentors_hide':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_POPULARENTRIES_SORTBY_COMMENTORS_FILTER);
                $propbag->add('description', PLUGIN_POPULARENTRIES_SORTBY_COMMENTORS_FILTER_DESC);
                $propbag->add('default', $serendipity['realname']);
                break;

            case 'category':
                $cats    = serendipity_fetchCategories($serendipity['authorid']);
                if (!is_array($cats)) {
                    return false;
                }

                $catlist = serendipity_generateCategoryList($cats, array(0), 4);
                $tmp_select_cats = explode('@@@', $catlist);

                if (!is_array($tmp_select_cats)) {
                    return false;
                }

                $select_cats = array();
                $select_cats['none'] = ALL_CATEGORIES;
                $select_cats['_cur'] = PARENT_CATEGORY;
                foreach($tmp_select_cats as $cidx => $tmp_select_cat) {
                    $select_cat = explode('|||', $tmp_select_cat);
                    if (!empty($select_cat[0]) && !empty($select_cat[1])) {
                        $select_cats[$select_cat[0]] = $select_cat[1];
                    }
                }

                $propbag->add('type',          'select');
                $propbag->add('select_values', $select_cats);
                $propbag->add('name',          CATEGORY);
                $propbag->add('description',   CATEGORIES_TO_FETCH);
                $propbag->add('default',       'none');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        global $serendipity;

        $number         = $this->get_config('number');
        $category       = $this->get_config('category', 'none');
        $title          = $this->get_config('title', $this->title);
        $number_from_sw = $this->get_config('number_from');
        if ($category == '_cur') {
            $category = $serendipity['GET']['category'];
        }

        $sql_join   = '';
        $sql_where  = '';
        if ($category != 'none' && is_numeric($category)) {
            $sql_join = 'LEFT OUTER JOIN ' . $serendipity['dbPrefix'] . 'entrycat AS ec ON e.id = ec.entryid
                         LEFT OUTER JOIN ' . $serendipity['dbPrefix'] . 'category AS c  ON ec.categoryid = c.categoryid';
            $sql_where = ' AND (c.category_left BETWEEN ' . implode(' AND ', serendipity_fetchCategoryRange($category)) . ')';
        }

        if (!$number || !is_numeric($number) || $number < 1) {
            $number = 10;
        }

        $sql_number = $number;

        switch($number_from_sw) {
            case 'skip':
                $sql_number = serendipity_db_limit_sql(serendipity_db_limit($serendipity['fetchLimit'], $sql_number));
                break;
            default:
                $sql_number = serendipity_db_limit_sql(serendipity_db_limit(0, $sql_number));
                break;
        }

        $sortby = $this->get_config('sortby', 'comments');

        switch($sortby) {
            case 'comments':
                $entries_query = "SELECT e.id,
                                         e.title,
                                         e.comments AS points,
                                         e.timestamp
                                    FROM {$serendipity['dbPrefix']}entries AS e
                                         $sql_join
                                   WHERE e.isdraft = 'false' AND e.timestamp <= " . time() . "
                                         $sql_where
                                ORDER BY e.comments DESC
                                   $sql_number";
                break;

            case 'commentors':
                $entries_query = "SELECT c.author, count(c.id) AS points
                                    FROM {$serendipity['dbPrefix']}entries AS e
                                    JOIN {$serendipity['dbPrefix']}comments AS c
                                         ON c.entry_id = e.id
                                         $sql_join
                                   WHERE e.isdraft = 'false' AND e.timestamp <= " . time() . "
                                     AND c.status = 'approved'
                                         $sql_where
                                GROUP BY c.author
                                ORDER BY points DESC
                                   $sql_number";
                break;

            case 'karma':
                $entries_query = "SELECT e.id,
                                         e.title,
                                         e.comments,
                                         e.timestamp,
                                         k.points AS points
                                    FROM {$serendipity['dbPrefix']}entries AS e
                                         $sql_join
                         LEFT OUTER JOIN {$serendipity['dbPrefix']}karma AS k
                                      ON k.entryid = e.id
                                   WHERE e.isdraft = 'false' AND e.timestamp <= " . time() . "
                                         $sql_where
                                GROUP BY e.id, e.title, e.comments, e.timestamp, k.visits
                                ORDER BY k.points DESC
                                    $sql_number";
                break;

          case 'visits':
                $entries_query = "SELECT e.id,
                                         e.title,
                                         e.comments,
                                         e.timestamp,
                                         k.visits AS points
                                    FROM {$serendipity['dbPrefix']}entries AS e
                                         $sql_join
                         LEFT OUTER JOIN {$serendipity['dbPrefix']}karma AS k
                                      ON k.entryid = e.id
                                   WHERE e.isdraft = 'false' AND e.timestamp <= " . time() . "
                                         $sql_where
                                GROUP BY e.id, e.title, e.comments, e.timestamp, k.visits
                                ORDER BY k.visits DESC
                                    $sql_number";
                break;

            case 'lowvisits':
                $entries_query = "SELECT e.id,
                                         e.title,
                                         e.comments,
                                         e.timestamp,
                                         k.visits AS points
                                    FROM {$serendipity['dbPrefix']}entries AS e
                                         $sql_join
                         LEFT OUTER JOIN {$serendipity['dbPrefix']}karma AS k
                                      ON k.entryid = e.id
                                   WHERE e.isdraft = 'false' AND e.timestamp <= " . time() . "
                                         $sql_where
                                GROUP BY e.id, e.title, e.comments, e.timestamp, k.visits         
                                ORDER BY k.visits ASC
                    $sql_number";
                break;

            case 'exits':
                $entries_query = "SELECT e.id,
                                         e.title,
                                         e.comments,
                                         e.timestamp,
                                         SUM(ex.count) AS points
                                    FROM {$serendipity['dbPrefix']}entries AS e
                                         $sql_join
                         LEFT OUTER JOIN {$serendipity['dbPrefix']}exits AS ex
                                      ON ex.entry_id = e.id
                                   WHERE e.isdraft = 'false' AND e.timestamp <= " . time() . "
                                         $sql_where
                                GROUP BY ex.entry_id
                                ORDER BY points DESC
                                    $sql_number";
                break;
        }
        
        $entries = serendipity_db_query($entries_query);

        $hidden = explode(',', trim($this->get_config('commentors_hide')));

        echo '<ul class="plainList">';

        if (isset($entries) && is_array($entries)) {
            foreach ($entries as $k => $entry) {
                if ($sortby == 'commentors') {
                    if (in_array($entry['author'], $hidden)) {
                        continue;
                    }
                    $entryLink = $serendipity['serendipityHTTPPath'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . PATH_COMMENTS . '/' . urlencode($entry['author']);
                    echo '<li><a href="' . $entryLink . '" title="' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($entry['author']) : htmlspecialchars($entry['author'], ENT_COMPAT, LANG_CHARSET)) . '">' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($entry['author']) : htmlspecialchars($entry['author'], ENT_COMPAT, LANG_CHARSET)) . '</a>';
                    echo ' <span class="serendipitySideBarDate">(' . (!empty($entry['points']) ? (function_exists('serendipity_specialchars') ? serendipity_specialchars($entry['points']) : htmlspecialchars($entry['points'], ENT_COMPAT, LANG_CHARSET)) : 0) . ')</span></li>';
                } else {
                    $entryLink = serendipity_archiveURL(
                                   $entry['id'],
                                   $entry['title'],
                                   'serendipityHTTPPath',
                                   true,
                                   array('timestamp' => $entry['timestamp'])
                                );
    
                    echo '<li><a href="' . $entryLink . '" title="' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($entry['title']) : htmlspecialchars($entry['title'], ENT_COMPAT, LANG_CHARSET)) . '">' . $entry['title'] . '</a>';
                    echo ' <span class="serendipitySideBarDate">(' . (!empty($entry['points']) ? (function_exists('serendipity_specialchars') ? serendipity_specialchars($entry['points']) : htmlspecialchars($entry['points'], ENT_COMPAT, LANG_CHARSET)) : 0) . ')</span></li>';
                }
            }
        }

        echo '</ul>';
    }
}
