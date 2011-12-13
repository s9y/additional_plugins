<?php # $Id: serendipity_event_filter_entries.php,v 1.9 2007/07/17 10:34:14 garvinhicking Exp $


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_filter_entries extends serendipity_event
{
    var $title = PLUGIN_EVENT_FILTER_ENTRIES_NAME;
    var $fetchLimit;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_FILTER_ENTRIES_NAME);
        $propbag->add('description',   PLUGIN_EVENT_FILTER_ENTRIES_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('version',       '1.4');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',    array(
            'external_plugin'    => true,
            'entries_footer'     => true,
            'frontend_configure' => true,
            'frontend_fetchentries' => true
        ));
        $propbag->add('groups', array('FRONTEND_VIEWS'));
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function event_hook($event, &$bag, &$eventData) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        $links = array();

        if (isset($hooks[$event])) {
            $sort_order = array('timestamp'     => DATE,
                                'isdraft'       => PUBLISH . '/' . DRAFT,
                                'a.realname'    => AUTHOR,
                                'category_name' => CATEGORY,
                                'last_modified' => LAST_UPDATED,
                                'title'         => TITLE);
            $per_page_max = 50;
            $per_page = array('12', '16', '25', $per_page_max);

            switch($event) {
                case 'frontend_fetchentries':
                    if ($this->fetchLimit > 0) {
                        $serendipity['fetchLimit'] = $this->fetchLimit;
                    }
                    break;

                case 'frontend_configure':
                    $_SERVER['REQUEST_URI'] = str_replace('%2Fplugin%2Ffilter%2F', '/plugin/filter/', $_SERVER['REQUEST_URI']);
                    break;

                case 'entries_footer':
                    $link = $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/filter/';
?>
<div id="filter_entries_container">
    <br />
    <hr />
    <form action="<?php echo $link; ?>" method="get">

    <?php if ($serendipity['rewrite'] == 'none') { ?>
    <input type="hidden" name="/plugin/filter/" value="" />
    <?php } ?>
    <table width="100%">
        <tr>
            <td colspan="6" style="text-align: left"><strong><?php echo FILTERS ?></strong> - <?php echo FIND_ENTRIES ?></td>
        </tr>
        <tr>
            <td width="80"><?php echo AUTHOR ?></td>
            <td>
                <select name="filter[author]">
                    <option value="">--</option>
<?php
                    $users = serendipity_fetchUsers();
                    if (is_array($users)) {
                        foreach ($users AS $user) {
                            echo '<option value="' . $user['authorid'] . '" ' . (isset($_SESSION['filter']['author']) && $_SESSION['filter']['author'] == $user['authorid'] ? 'selected="selected"' : '') . '>' . $user['realname'] . '</option>' . "\n";
                        }
                    }
?>              </select>
            </td>
            <td width="80"><?php echo CATEGORY ?></td>
            <td>
                <select name="filter[category]">
                    <option value="">--</option>
<?php
                    $categories = serendipity_fetchCategories();
                    $categories = serendipity_walkRecursive($categories, 'categoryid', 'parentid', VIEWMODE_THREADED);
                    foreach ( $categories as $cat ) {
                        echo '<option value="'. $cat['categoryid'] .'"'. ($_SESSION['filter']['category'] == $cat['categoryid'] ? ' selected="selected"' : '') .'>'. str_repeat('&nbsp;', $cat['depth']) . $cat['category_name'] .'</option>' . "\n";
                    }
?>              </select>
            </td>
            <td width="80"><?php echo CONTENT ?></td>
            <td><input size="10" type="text" name="filter[body]" value="<?php echo (isset($_SESSION['filter']['body']) ? htmlspecialchars($_SESSION['filter']['body']) : '') ?>" /></td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: left"><strong><?php echo SORT_ORDER ?></strong></td>
        </tr>
        <tr>
            <td><?php echo SORT_BY ?></td>
            <td>
                <select name="sort[order]">
<?php
    foreach($sort_order as $so_key => $so_val) {
        echo '<option value="' . $so_key . '" ' . (isset($_SESSION['sort']['order']) && $_SESSION['sort']['order'] == $so_key ? 'selected="selected"': '') . '>' . $so_val . '</option>' . "\n";
    }
?>              </select>
            </td>
            <td><?php echo SORT_ORDER ?></td>
            <td>
                <select name="sort[ordermode]">
                    <option value="DESC" <?php echo (isset($_SESSION['sort']['ordermode']) && $_SESSION['sort']['ordermode'] == 'DESC' ? 'selected="selected"' : '') ?>><?php echo SORT_ORDER_DESC ?></option>
                    <option value="ASC" <?php echo (isset($_SESSION['sort']['ordermode']) && $_SESSION['sort']['ordermode'] == 'ASC'  ? 'selected="selected"' : '') ?>><?php echo SORT_ORDER_ASC ?></option>
                </select>
            </td>
            <td><?php echo ENTRIES_PER_PAGE ?></td>
            <td>
                <select name="sort[perPage]">
<?php
    foreach($per_page AS $per_page_nr) {
       echo '<option value="' . $per_page_nr . '"   ' . (isset($_SESSION['sort']['perPage']) && $_SESSION['sort']['perPage'] == $per_page_nr ? 'selected="selected"' : '') . '>' . $per_page_nr . '</option>' . "\n";
    }

?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right" colspan="6"><input type="submit" name="go" value="<?php echo GO ?>" class="serendipityPrettyButton" /></td>
        </tr>
    </table>
</form>
</div>
<?php
                    return true;
                    break;

                case 'external_plugin':
                    $uri_parts  = explode('?', str_replace('&amp;', '&', $eventData));
                    $parts      = explode('/', $uri_parts[0]);
                    $plugincode = $parts[0];
                    unset($parts[0]);
                    $uri = $_SERVER['REQUEST_URI'];
                    $puri = parse_url($uri);

                    $queries = explode('&', str_replace(array('%5B', '%5D'), array('[', ']'), $puri['query']));
                    foreach($queries AS $query_part) {
                        $query = explode('=', $query_part);
                        switch($query[0]) {
                            case 'filter[author]':
                                $_GET['filter']['author']   = urldecode($query[1]);
                                break;

                            case 'filter[category]':
                                $_GET['filter']['category'] = urldecode($query[1]);
                                break;

                            case 'filter[body]':
                                $_GET['filter']['body']     = urldecode($query[1]);
                                break;

                            case 'sort[order]':
                                $_GET['sort']['order']      = urldecode($query[1]);
                                break;

                            case 'sort[ordermode]':
                                $_GET['sort']['ordermode']  = urldecode($query[1]);
                                break;

                            case 'sort[perPage]':
                                $_GET['sort']['perPage']    = urldecode($query[1]);
                                break;

                        }
                    }

                    if (is_array($_GET['filter'])) {
                        $_SESSION['filter'] = $_GET['filter'];
                    }

                    if (is_array($_GET['sort'])) {
                        $_SESSION['sort']   = $_GET['sort'];
                    }

                    /* Attempt to locate hidden variables within the URI */
                    foreach ($serendipity['uriArguments'] as $k => $v){
                        if ($v[0] == 'P') { /* Page */
                            $page = substr($v, 1);
                            if (is_numeric($page)) {
                                $serendipity['GET']['page'] = $page;
                                unset($serendipity['uriArguments'][$k]);
                            }
                        }
                    }

                    switch($plugincode) {
                        case 'filter':
                            $perPage = (int)(!empty($_SESSION['sort']['perPage']) ? $_SESSION['sort']['perPage'] : $per_page[0]);
                            if ($perPage > $per_page_max) {
                                $perPage = $per_page_max;
                            }
                            $serendipity['fetchLimit'] = $perPage;
                            $this->fetchLimit          = $perPage;

                            $page    = (int)$serendipity['GET']['page'];
                            $offSet  = $perPage*$page;

                            if (empty($_SESSION['sort']['ordermode']) || $_SESSION['sort']['ordermode'] != 'ASC') {
                                $_SESSION['sort']['ordermode'] = 'DESC';
                            }

                            if (!empty($_SESSION['sort']['order']) && !empty($sort_order[$_SESSION['sort']['order']])) {
                                $orderby = serendipity_db_escape_string($_SESSION['sort']['order'] . ' ' . $_SESSION['sort']['ordermode']);
                            } else {
                                $orderby = 'timestamp ' . serendipity_db_escape_string($_SESSION['sort']['ordermode']);
                            }

                            $filter = array();
                            if (!empty($_SESSION['filter']['author'])) {
                                $filter[] = "e.authorid = '" . serendipity_db_escape_string($_SESSION['filter']['author']) . "'";
                            }

                            if (!empty($_SESSION['filter']['category'])) {
                                $filter[] = "ec.categoryid = '" . serendipity_db_escape_string($_SESSION['filter']['category']) . "'";
                            }

                            if (!empty($_SESSION['filter']['body'])) {
                                if ($serendipity['dbType'] == 'mysql') {
                                    $filter[] = "MATCH (title,body,extended) AGAINST ('" . serendipity_db_escape_string($_SESSION['filter']['body']) . "')";
                                    $full     = true;
                                }
                            }

                            $filter_sql = implode(' AND ', $filter);

                            // Fetch the entries
                            $entries = serendipity_fetchEntries(
                                         false,
                                         false,
                                         serendipity_db_limit(
                                           $offSet,
                                           $perPage
                                         ),
                                         true,
                                         false,
                                         $orderby,
                                         $filter_sql
                                       );

                            $serendipity['smarty_raw_mode'] = true;
                            include_once(S9Y_INCLUDE_PATH . 'include/genpage.inc.php');
                            serendipity_printEntries($entries);
                            $raw_data = ob_get_contents();
                            ob_end_clean();
                            $serendipity['smarty']->assign('CONTENT', $raw_data);
                            $serendipity['smarty']->assign('is_raw_mode', false);
                            serendipity_gzCompression();
                            $serendipity['smarty']->display(serendipity_getTemplateFile($serendipity['smarty_file'], 'serendipityPath'));
                            break;
                    }

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
}

/* vim: set sts=4 ts=4 expandtab : */
