<?php # 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_topreferers extends serendipity_plugin {

    function introspect(&$propbag) {
        $propbag->add('name',        PLUGIN_TOPREFERERS_TITLE);
        $propbag->add('description', SHOWS_TOP_SITES);
        $propbag->add('author',        'Serendipity Team');
        $propbag->add('configuration', array('title', 'limit', 'daylimit', 'use_links', 'filter_out'));
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('STATISTICS'));
        $propbag->add('version', '1.3.2');
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        TITLE);
                $propbag->add('description', TITLE);
                $propbag->add('default',     PLUGIN_TOPREFERERS_TITLE);
                break;

            case 'limit':
                $propbag->add('type',        'string');
                $propbag->add('name',        LIMIT_TO_NUMBER);
                $propbag->add('description', LIMIT_TO_NUMBER);
                $propbag->add('default',     10);
                break;

            case 'daylimit':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_TOPREFERERS_DAYLIMIT);
                $propbag->add('description', PLUGIN_TOPREFERERS_DAYLIMIT_DESC);
                $propbag->add('default',     7);
                break;

            case 'use_links':
                $propbag->add('type',        'tristate');
                $propbag->add('name',        INSTALL_TOP_AS_LINKS);
                $propbag->add('description', INSTALL_TOP_AS_LINKS_DESC);
                $propbag->add('default',     'default');
                break;

            case 'filter_out':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_TOPREFERERS_PROP_FILTER);
                $propbag->add('description', PLUGIN_TOPREFERERS_PROP_FILTER_DESC);
                $propbag->add('default',     '');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        global $serendipity;

        $title = $this->get_config('title');

        // get local configuration (default, true, false)
        $use_links = $this->get_config('use_links', 'default');
        // get global configuration (true, false)
        $global_use_link = serendipity_get_config_var('top_as_links', false, true);

        // if local configuration say to use global default, do so
        if ($use_links === 'default') {
            $use_links = serendipity_db_bool($global_use_link);
        } else {
            $use_links = serendipity_db_bool($use_links);
        }

        echo displayTopReferers($this->get_config('limit', 10), $use_links, $this->get_config('filter_out'), $this->get_config('daylimit'));
    }
}

function displayTopReferers($limit = 10, $use_links = true, $filter_out = "", $daylimit = 7) {
    displayTopUrlList('referrers', $limit, $use_links, $filter_out, $daylimit);
}

function displayTopUrlList($list, $limit, $use_links = true, $filter_out = "", $daylimit = 7) {
    global $serendipity;

    if ($limit){
        $limit = serendipity_db_limit_sql($limit);
    }

    $filter_out_sql = !$filter_out ? "" : "host NOT LIKE '".join("' AND host NOT LIKE '", explode(";", preg_replace('@^;|;$@', '', str_replace("*", "%", $filter_out))))."'";

    /* HACK */
    if (preg_match('/^mysqli?/', $serendipity['dbType'])) {
        if ($filter_out) {
            $filter_out_sql = "AND ".$filter_out_sql;
        }
        /* Nonportable SQL due to MySQL date functions,
         * but produces rolling 7 day totals, which is more
         * interesting
         */
        $query = "SELECT scheme, host, SUM(count) AS total
                  FROM {$serendipity['dbPrefix']}$list
                  WHERE " . ($daylimit > 0 ? "day > date_sub(current_date, interval " . (int)$daylimit . " day)" : "1 = 1") . "
                  $filter_out_sql
                  GROUP BY host
                  ORDER BY total DESC, host
                  $limit";
    } else {
        if ($filter_out) {
            $filter_out_sql = "WHERE ".$filter_out_sql;
        }
        /* Portable version of the same query */
        $query = "SELECT scheme, host, SUM(count) AS total
                  FROM {$serendipity['dbPrefix']}$list
                  $filter_out_sql
                  GROUP BY scheme, host
                  ORDER BY total DESC, host
                  $limit";
    }

    $rows = serendipity_db_query($query);
    echo "<span class='serendipityReferer'>";
    if (is_array($rows)) {
        foreach ($rows as $row) {
            if ($use_links) {
                printf(
                    '<a href="%1$s://%2$s" title="%2$s" >%2$s</a> (%3$s)<br />',
                    (function_exists('serendipity_specialchars') ? serendipity_specialchars($row['scheme']) : htmlspecialchars($row['scheme'], ENT_COMPAT, LANG_CHARSET)),
                    (function_exists('serendipity_specialchars') ? serendipity_specialchars($row['host']) : htmlspecialchars($row['host'], ENT_COMPAT, LANG_CHARSET)),
                    (function_exists('serendipity_specialchars') ? serendipity_specialchars($row['total']) : htmlspecialchars($row['total'], ENT_COMPAT, LANG_CHARSET))
                );
            } else {
                printf(
                    '%1$s (%2$s)<br />',
                    (function_exists('serendipity_specialchars') ? serendipity_specialchars($row['host']) : htmlspecialchars($row['host'], ENT_COMPAT, LANG_CHARSET)),
                    (function_exists('serendipity_specialchars') ? serendipity_specialchars($row['total']) : htmlspecialchars($row['total'], ENT_COMPAT, LANG_CHARSET))
                );
            }
        }
    }
    echo "</span>";
}

/* vim: set sts=4 ts=4 expandtab : */
?>
