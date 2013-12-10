<?php


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_linktoolbar extends serendipity_event {
    var $title = PLUGIN_LINKTOOLBAR_TITLE;

    function introspect(&$propbag)
    {
        $propbag->add('name',          PLUGIN_LINKTOOLBAR_TITLE);
        $propbag->add('description',   PLUGIN_LINKTOOLBAR_TITLE_DESC);
        $propbag->add('event_hooks', array('frontend_header' => true));
        $propbag->add('author', 'Garvin Hicking');
        $propbag->add('version', '1.4');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('stackable', false);
        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED'));
    }

    function backAndForth($link = null) {
        global $serendipity;

        if (!is_array($link)) {
            $link = array();

            if ($serendipity['GET']['page'] > 1) {
                $uriArguments = $serendipity['uriArguments'];
                $uriArguments[] = 'P'. ($serendipity['GET']['page'] - 1);
                $link['prev'] = array(
                    'link'  => serendipity_rewriteURL(implode('/', $uriArguments) .'.html'),
                    'title' => PREVIOUS_PAGE
                );
            }

            $uriArguments = $serendipity['uriArguments'];
            $uriArguments[] = 'P'. ($serendipity['GET']['page'] + 1);
            $link['next'] = array(
                'link'  => serendipity_rewriteURL(implode('/', $uriArguments) .'.html'),
                'title' => NEXT_PAGE
            );
        }

        if (is_array($link['prev'])) {
            echo '<link rel="prev" href="' . $link['prev']['link'] . '" title="' . $link['prev']['title'] . '" />' . "\n";
        }

        if (is_array($link['next'])) {
            echo '<link rel="next" href="' . $link['next']['link'] . '" title="' . $link['next']['title'] . '" />' . "\n";
        }

        return true;
    }

    function makeLink($resultset) {
        if (is_array($resultset) && is_numeric($resultset[0]['id'])) {
            return array(
                'link'  => serendipity_archiveURL($resultset[0]['id'], $resultset[0]['title'], 'baseURL', true, array('timestamp' => $resultset[0]['timestamp'])),
                'title' => htmlspecialchars($resultset[0]['title'])
            );
        }

        return false;
    }

    function showPaging($id = false) {
        global $serendipity;

        if (!$id) {
            return false;
        }

        $links = array();
        $cond  = array();
        $cond['and'] = " AND e.isdraft = 'false' AND e.timestamp <= " . serendipity_serverOffsetHour(time(), true);
        serendipity_plugin_api::hook_event('frontend_fetchentry', $cond);

        $querystring = "SELECT
                                e.id, e.title, e.timestamp
                          FROM
                                {$serendipity['dbPrefix']}entries e
                                {$cond['joins']}
                         WHERE
                                e.id [COMP] " . (int) $id . "
                                {$cond['and']}
                        ORDER BY e.id [ORDER]
                        LIMIT  1";

        $prevID = serendipity_db_query(str_replace(array('[COMP]', '[ORDER]'), array('<', 'DESC'), $querystring));
        $nextID = serendipity_db_query(str_replace(array('[COMP]', '[ORDER]'), array('>', 'ASC'), $querystring));

        if ($link = $this->makeLink($prevID)) {
            $links['prev'] = $link;
        }

        if ($link = $this->makeLink($nextID)) {
            $links['next'] = $link;
        }

        return $links;

    }

    function getCat($cat) {
        if (function_exists('serendipity_categoryURL')) {
            $link = serendipity_categoryURL($cat, 'serendipityHTTPPath');
        } else {
            $link = serendipity_rewriteURL(
                PATH_CATEGORIES . '/' . serendipity_makePermalink(
                    PERM_CATEGORIES,
                    array(
                        'id'    => $cat['categoryid'],
                        'title' => $cat['category_name'])
                ),
                'serendipityHTTPPath');
        }

        return array(
            'link' => $link,
            'title' => htmlspecialchars($cat['category_name'])
        );
    }

    function getUser($user) {
        if (function_exists('serendipity_authorURL')) {
            $link = serendipity_authorURL($user, 'serendipityHTTPPath');
        } else {
            $link = serendipity_rewriteURL(
                PATH_CATEGORIES . '/' . serendipity_makePermalink(
                    PERM_CATEGORIES,
                    array(
                        'id'    => $cat['categoryid'],
                        'title' => $cat['category_name'])
                ),
                'baseURL');
        }

        return array(
            'link' => $link,
            'title' => AUTHOR . ' ' . htmlspecialchars($user['realname'])
        );
    }
    
    function getEntry($id) {
        global $serendipity;

        $ret = serendipity_db_query("SELECT id, title, timestamp FROM {$serendipity['dbPrefix']}entries WHERE id = " . (int)$id);
        return serendipity_archiveURL($id, $ret[0]['title'], 'baseURL', true, array('timestamp' => $ret[0]['timestamp']));
    }
    
    function getArchiveParameters() {
        global $serendipity;

        $_args = $serendipity['uriArguments'];

        $prepend_params = $params = array();
        
        /* Attempt to locate hidden variables within the URI */
        foreach ($_args AS $k => $v){
            if ($v == PATH_ARCHIVES) {
                continue;
            }
            if ($v[0] == 'C') { /* category */
                $cat = substr($v, 1);
                if (is_numeric($cat)) {
                    $params['C' . $cat] = true;
                    unset($_args[$k]);
                }
            } elseif ($v[0] == 'A') { /* Author */
                $url_author = substr($v, 1);
                if (is_numeric($url_author)) {
                    $params['A'. (int)$url_author] = true;
                    unset($_args[$k]);
                }
            } elseif ($v[0] == 'W') { /* Week */
                if (is_numeric($week)) {
                    $params['W'. substr($v, 1)] = true;
                    unset($_args[$k]);
                }
            } elseif ($v == 'summary') { /* Summary */
                $params['summary'] = true;
                unset($_args[$k]);
            } elseif ($v[0] == 'P') { /* Page */
                $page = substr($v, 1);
                if (is_numeric($page)) {
                    $params['P' . $page] = true;
                    unset($_args[$k]);
                }
            }
        }

        list(,$year, $month, $day) = $_args;
        
        if (isset($year)) {
            $prepend_params[$year] = true;
        }
        
        if (isset($month)) {
            $prepend_params[$month] = true;
        }

        if (isset($day)) {
            $prepend_params[$day] = true;
        }
        
        $params = array_merge($prepend_params, $params);

        return serendipity_rewriteURL(PATH_ARCHIVES . '/' . implode('/', array_keys($params)) . '/', 'baseURL');
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;
        if ($event == 'frontend_header') {

            $start_url   = $serendipity['baseURL'];
            $start_title = $serendipity['blogTitle'];

            echo '<link rel="start" href="' . $start_url . '" title="' . htmlspecialchars($start_title) . '" />' . "\n";

            if ($serendipity['GET']['action'] == 'read' && !empty($serendipity['GET']['id'])) {

                // Article detail view
                echo '<link rel="up" href="' . $start_url . '" title="' . htmlspecialchars($start_title) . '" />' . "\n";
                $this->backAndForth(
                    $this->showPaging($serendipity['GET']['id'])
                );
                // END article detail view
                
                echo '<link rel="canonical" href="' . $this->getEntry($serendipity['GET']['id']) . '" />' . "\n";

            } elseif ($serendipity['GET']['action'] == 'read' && is_array($serendipity['range'])) {

                // Specific Date Archives view
                echo '<link rel="up" href="' . serendipity_rewriteURL(PATH_ARCHIVE) . '" title="' . ARCHIVES . '" />' . "\n";
                echo '<link rel="canonical" href="' . $this->getArchiveParameters() . '" />' . "\n";

                $links     = array();
                $add_query = '';

                $year  = date('Y', $serendipity['range'][0]);
                $month = date('m', $serendipity['range'][0]);
                $day   = date('d', $serendipity['range'][0]);

                $pageMonthNext = array(
                    'day'   => '1',
                    'month' => $month + 1,
                    'year'  => $year
                );
                $pageMonthPrev = array(
                    'day'   => '1',
                    'month' => $month - 1,
                    'year'  => $year
                );

                $pageDayNext   = array(
                    'day'   => $day + 1,
                    'month' => $month,
                    'year'  => $year
                );
                $pageDayPrev   = array(
                    'day'   => $day - 1,
                    'month' => $month,
                    'year'  => $year
                );

                $diff  = $serendipity['range'][1] - $serendipity['range'][0];

                if (isset($serendipity['GET']['category'])) {
                    $categoryid  = (int)serendipity_db_escape_string($serendipity['GET']['category']);
                    $add_query    = '/C' . $categoryid;
                }

                if ($diff < 86400) {
                    // Paging day by day
                    $ts = mktime(0, 0, 0, $pageDayPrev['month'], $pageDayPrev['day'], $pageDayPrev['year']);
                    $links['prev'] = array(
                        'link'  => serendipity_archiveDateUrl(sprintf('%4d/%02d/%02d', date('Y', $ts), date('m', $ts), date('d', $ts))),
                        'title' => sprintf(ENTRIES_FOR, serendipity_formatTime(DATE_FORMAT_ENTRY, $ts, false))
                    );

                    $ts = mktime(0, 0, 0, $pageDayNext['month'], $pageDayNext['day'], $pageDayNext['year']);
                    $links['next'] = array(
                        'link'  => serendipity_archiveDateUrl(sprintf('%4d/%02d/%02d', date('Y', $ts), date('m', $ts), date('d', $ts))),
                        'title' => sprintf(ENTRIES_FOR, serendipity_formatTime(DATE_FORMAT_ENTRY, $ts, false))
                    );
                } elseif ($diff < (86400*28)) {
                    // Paging by week

                    // TODO - Don't know :-)
                } else {
                    // Paging by month
                    $ts = mktime(0, 0, 0, $pageMonthPrev['month'], $pageMonthPrev['day'], $pageMonthPrev['year']);
                    $links['prev'] = array(
                        'link'  => serendipity_archiveDateUrl(sprintf('%4d/%02d', date('Y', $ts), date('m', $ts))),
                        'title' => sprintf(ENTRIES_FOR, serendipity_formatTime('%B %Y', $ts, false))
                    );

                    $ts = mktime(0, 0, 0, $pageMonthNext['month'], $pageMonthNext['day'], $pageMonthNext['year']);
                    $links['next'] = array(
                        'link'  => serendipity_archiveDateUrl(sprintf('%4d/%02d', date('Y', $ts), date('m', $ts))),
                        'title' => sprintf(ENTRIES_FOR, serendipity_formatTime('%B %Y', $ts, false))
                    );
                }

                $this->backAndForth($links);
                // END Specific Date Archives view

            } elseif ($serendipity['GET']['action'] == 'archives') {

                // Full month/year archives overview
                echo '<link rel="up" href="' . serendipity_rewriteURL(PATH_ARCHIVE) . '" title="' . ARCHIVES . '" />' . "\n";
                // END Full month/year archives overview

                echo '<link rel="canonical" href="' . $this->getArchiveParameters() . '" />' . "\n";

            } elseif (!empty($serendipity['GET']['category'])) {

                // Category based view
                $cInfo = serendipity_fetchCategoryInfo($serendipity['GET']['category']);
                if (function_exists('serendipity_categoryURL')) {
                    $categories_url = serendipity_categoryURL($cInfo, 'serendipityHTTPPath');
                } else {
                    $categories_url = serendipity_rewriteURL(
                        PATH_CATEGORIES . '/' . serendipity_makePermalink(
                            PERM_CATEGORIES,
                            array(
                                'id'    => $cInfo['categoryid'],
                                'title' => $cInfo['category_name'])
                        ),
                        'serendipityHTTPPath');
                }
                echo '<link rel="up" href="' . $categories_url . '" title="' . htmlspecialchars($cInfo['category_name']) . '" />' . "\n";
                echo '<link rel="canonical" href="' . $categories_url . '" />' . "\n";

                $categories = serendipity_fetchCategories('all');
                $links      = array();
                if (is_array($categories) && count($categories)) {
                    $categories   = serendipity_walkRecursive($categories, 'categoryid', 'parentid', VIEWMODE_THREADED);
                    $capture_next = false;
                    foreach ($categories as $cat) {
                        if ($capture_next) {
                            $links['next'] = $this->getCat($cat);
                            break;
                        }

                        if (is_array($prev_cat) && $cat['categoryid'] == $serendipity['GET']['category']) {
                            $links['prev'] = $this->getCat($prev_cat);
                            $capture_next  = true;
                        }

                        $prev_cat = $cat;
                    }
                }

                $this->backAndForth($links);
                // END Category based view

            } elseif (!empty($serendipity['GET']['viewAuthor'])) {

                // User view
                $uInfo = serendipity_fetchUsers();
                $links = array();

                if (is_array($uInfo)) {
                    $capture_next = false;
                    foreach($uInfo AS $user) {
                        if ($capture_next) {
                            $links['next'] = $this->getUser($user);
                            break;
                        }

                        if ($user['authorid'] == $serendipity['GET']['viewAuthor']) {
                            $authors_url = $this->getUser($user);
                            echo '<link rel="up" href="' . $authors_url['link'] . '" title="' . $authors_url['title'] . '" />' . "\n";
                            echo '<link rel="canonical" href="' . $authors_url['link'] . '" />' . "\n";

                            if (is_array($prev_user)) {
                                $links['prev'] = $this->getUser($prev_user);
                                $capture_next  = true;
                            }
                        }

                        $prev_user = $user;
                    }

                    $this->backAndForth($links);
                }
                // END User view


            } else {

                // Frontpage
                $this->backAndForth();
                // END Frontpage

                if ($serendipity['view'] == 'start') {
                    echo '<link rel="canonical" href="' . $serendipity['baseURL'] . '" />' . "\n";
                }

            }
        }
    }
}
?>