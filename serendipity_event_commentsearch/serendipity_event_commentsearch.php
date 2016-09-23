<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_commentsearch extends serendipity_event
{
    var $title = COMMENTSEARCH_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name', COMMENTSEARCH_TITLE);
        $propbag->add('description', COMMENTSEARCH_DESC);
        $propbag->add('event_hooks', array(
            'entries_footer'        => true,
            'frontend_fetchentries' => true
        ));

        $propbag->add('author', 'Garvin Hicking');
        $propbag->add('version', '1.6');
        $propbag->add('requirements',  array(
            'serendipity' => '1.7',
            'smarty'      => '3.1.0',
            'php'         => '5.1.0'
        ));
        $propbag->add('stackable', false);
        $propbag->add('groups',    array('FRONTEND_FEATURES'));
    }

    function setupDB()
    {
        global $serendipity;

        $built = $this->get_config('db_built', null);
        if (empty($built)) {
            $q = "@CREATE {FULLTEXT_MYSQL} INDEX commentbody_idx on {$serendipity['dbPrefix']}comments (title, body);";
            serendipity_db_schema_import($q);
            $this->set_config('db_built', 1);
        }
    }

    function showSearch()
    {
        global $serendipity;

        $this->setupDB();

        $term = serendipity_db_escape_string($serendipity['GET']['searchTerm']);
        if ($serendipity['dbType'] == 'postgres') {
            $group     = '';
            $distinct  = 'DISTINCT';
            $find_part = "(c.title ILIKE '%$term%' OR c.body ILIKE '%$term%')";
        } elseif (stristr($serendipity['dbType'], 'sqlite') !== FALSE) {
            $group     = 'GROUP BY id';
            $distinct  = '';
            $term      = serendipity_mb('strtolower', $term);
            $find_part = "(lower(c.title) LIKE '%$term%' OR lower(c.body) LIKE '%$term%')";
        } else { // MYSQL
            $group     = 'GROUP BY id';
            $distinct  = '';
            $term      = str_replace('&quot;', '"', $term);
            if (preg_match('@["\+\-\*~<>\(\)]+@', $term)) {
                $find_part = "MATCH(c.title,c.body) AGAINST('$term' IN BOOLEAN MODE)";
            } else {
                $find_part = "MATCH(c.title,c.body) AGAINST('$term')";
            }
        }

        $querystring = "SELECT c.title AS ctitle, c.body, c.author, c.entry_id, c.timestamp AS ctimestamp, c.url, c.type,
                               e.id, e.title, e.timestamp
                          FROM {$serendipity['dbPrefix']}comments AS c
               LEFT OUTER JOIN {$serendipity['dbPrefix']}entries AS e
                            ON e.id = c.entry_id
                         WHERE c.status = 'approved'
                           AND $find_part
                               $group
                      ORDER BY c.timestamp DESC";

        $results = serendipity_db_query($querystring, false, 'assoc');
        if (!is_array($results)) {
            if ($results !== 1 && $results !== true) {
                echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($results) : htmlspecialchars($results, ENT_COMPAT, LANG_CHARSET));
            }
            $results = array();
        }
        $myAddData = array("from" => "serendipity_plugin_commentsearch:generate_content");
        foreach($results AS $idx => $result) {
            $results[$idx]['permalink'] = serendipity_archiveURL($result['id'], $result['title'], 'baseURL', true, $result);
            $results[$idx]['comment']   = $result['body']; // escape it in the template (function_exists('serendipity_specialchars') ? serendipity_specialchars(strip_tags($result['body'])) : htmlspecialchars(strip_tags($result['body']), ENT_COMPAT, LANG_CHARSET));
            serendipity_plugin_api::hook_event('frontend_display', $results[$idx], $myAddData);
            // let the template decide, if we want to have tags or not
            $results[$idx]['commenthtml'] = $results[$idx]['comment'];
            $results[$idx]['comment']     = strip_tags($results[$idx]['comment']);
        }

        $serendipity['smarty']->assign(
            array(
                'comment_searchresults' => count($results),
                'comment_results'       => $results
            )
        );

        $filename = 'plugin_commentsearch_searchresults.tpl';
        $content = $this->parseTemplate($filename);
        echo $content;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch ($event) {
                case 'frontend_fetchentries':
                    if ($serendipity['GET']['action'] == 'search') {
                        serendipity_smarty_fetch('ENTRIES', 'entries.tpl', true);
                    }
                    break;

                case 'entries_footer':
                    if ($serendipity['GET']['action'] == 'search') {
                        $this->showSearch();
                    }
                    break;

                default:
                    return false;
            }
            return true;
        }
        return false;
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>