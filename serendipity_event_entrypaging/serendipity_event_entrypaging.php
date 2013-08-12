<?php # 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_entrypaging extends serendipity_event
{
    var $found_images = array();
    var $smartylinks = array();

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_ENTRYPAGING_NAME);
        $propbag->add('description',   PLUGIN_ENTRYPAGING_BLAHBLAH);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Wesley Hwang-Chung');
        $propbag->add('version',       '1.38');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED'));
        $propbag->add('event_hooks',   array('entry_display' => true, 'css' => true, 'entries_header' => true));
        $propbag->add('configuration', array('placement','showrandom', 'next', 'prev', 'use_category'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'placement':
                $select = array('top'    => PLUGIN_ENTRYPAGING_TOP,
                                'bottom' => PLUGIN_ENTRYPAGING_BOTTOM,
                                'smarty' => 'Smarty {$pagination_(next|prev|random)_(title|link)}');
                $propbag->add('type',        'select');
                $propbag->add('select_values', $select);
                $propbag->add('name',        PLUGIN_ENTRYPAGING_PLACE);
                $propbag->add('default',     'top');
                break;

            case 'showrandom':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_ENTRYPAGING_RANDOM);
                $propbag->add('description', PLUGIN_ENTRYPAGING_RANDOM_BLAHBLAH);
                $propbag->add('default',     'false');
                break;

            case 'use_category':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_ENTRYPAGING_USECATEGORY);
                $propbag->add('description', PLUGIN_ENTRYPAGING_USECATEGORY_BLAHBLAH);
                $propbag->add('default',     'false');
                break;

            case 'next':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_ENTRYPAGING_RANDOM_TEXT_NEXT);
                $propbag->add('description', PLUGIN_ENTRYPAGING_RANDOM_TEXT_NEXT_DESC);
                $propbag->add('default',     '');
                break;

            case 'prev':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_ENTRYPAGING_RANDOM_TEXT_PREV);
                $propbag->add('description', PLUGIN_ENTRYPAGING_RANDOM_TEXT_NEXT_DESC);
                $propbag->add('default',     '');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        $title       = PLUGIN_ENTRYPAGING_NAME;
    }

    function timeOffset($timestamp) {
        if (function_exists('serendipity_serverOffsetHour')) {
            return serendipity_serverOffsetHour($timestamp, true);
        }

        return $timestamp;
    }

    function makeLink($resultset, $type = 'next') {
        if (is_array($resultset) && is_numeric($resultset[0]['id'])) {
            // multilingual title support
            global $serendipity;
            
            if (class_exists('serendipity_event_multilingual')) {
                $localtitle = serendipity_db_query("SELECT value FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = {$resultset[0]['id']} AND property = 'multilingual_title_{$serendipity['lang']}'", true, "both", false, false, false, true);
            }
            if (!is_array($localtitle)) {
                $localtitle = array(0 => $resultset[0]['title']);
            }

            // what above does is to retrieve the multilingual title, if available
            $title = htmlspecialchars($localtitle[0]);
            if ($this->get_config($type) != '') {
                $title = htmlspecialchars($this->get_config($type));
            }
            if (empty($title)) {
                if ($type == 'next') {
                    $title = NEXT;
                } elseif ($type == 'prev') {
                    $title = PREVIOUS;
                }
            }
            $url = serendipity_archiveURL($resultset[0]['id'], $resultset[0]['title'], 'baseURL', true, array('timestamp' => $resultset[0]['timestamp']));

            $this->smartylinks['pagination_' . $type . '_link']  = $url;
            $this->smartylinks['pagination_' . $type . '_title'] = $title;

            $link = '<a href="' . $url . '">' . $title . '</a>';
            return $link;
        }

        return false;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        $placement = $this->get_config('placement', 'top');

        if ($event == 'css') {
            if (stristr($eventData, '.serendipity_entrypaging')) {
                // class exists in CSS, so a user has customized it and we don't need default
                return true;
            }
?>

.serendipity_entrypaging {
    text-align: center;
    margin-left: auto;
    margin-right: auto;
    border: 0px;
    display: block;
}
<?php
            return true;
        }

        if ($event == 'entry_display' || $event == 'entries_header') {
        if (isset($serendipity['GET']['id']) && is_numeric($serendipity['GET']['id'])) {
            // top placement: 'entries_header' available since 0.8; 'entries_display' for fallback
            if (($placement == 'top' || $placement == 'smarty') &&
                (($event == 'entry_display' && !version_compare($serendipity['version'], '0.7.1', '>')) ||
                 $event == 'entries_header')) {
                $disp = '1';
            }
            // bottom placement
            elseif ($placement == 'bottom' && $event == 'entry_display') {
                $disp = '2';
            } else {
                return false;
            }

            // showPaging function integrated here
            $id     = $serendipity['GET']['id'];
            $links  = array();
            $cond   = array();

            $currentTimeSQL = serendipity_db_query("SELECT e.timestamp , ec.categoryid
                                                      FROM {$serendipity['dbPrefix']}entries AS e
                                           LEFT OUTER JOIN {$serendipity['dbPrefix']}entrycat AS ec
                                                        ON ec.entryid = e.id
                                                     WHERE e.id = " . (int)$id . "
                                                  ORDER BY ec.categoryid
                                                     LIMIT 1", true);
            if (is_array($currentTimeSQL)) {
                $cond['compare'] = "e.timestamp [%1] " . $currentTimeSQL['timestamp'];
            } else {
                $cond['compare'] = "e.id [%1] " . (int) $id;
            }

            $cond['and'] = " AND e.isdraft = 'false' AND e.timestamp <= " . $this->timeOffset(time());
            serendipity_plugin_api::hook_event('frontend_fetchentry', $cond);
            if (serendipity_db_bool($this->get_config('use_category')) && !empty($currentTimeSQL['categoryid'])) {
                $cond['joins'] .= " JOIN {$serendipity['dbPrefix']}entrycat AS ec ON (ec.categoryid = " . (int)$currentTimeSQL['categoryid'] . " AND ec.entryid = e.id)";
            }

            $querystring = "SELECT
                                    e.id, e.title, e.timestamp
                            FROM
                                    {$serendipity['dbPrefix']}entries e
                                    {$cond['joins']}
                            WHERE
                                    {$cond['compare']}
                                    {$cond['and']}
                            ORDER BY e.timestamp [%2]
                            LIMIT  1";

            // We cannot use sprintf() for parametrizing, because "%" strings can occur in checks for "LIKE '%serendipity...%'" SQL parts!
            $prevID = serendipity_db_query(str_replace(array('[%1]', '[%2]'), array('<', 'DESC'), $querystring));
            $nextID = serendipity_db_query(str_replace(array('[%1]', '[%2]'), array('>', 'ASC'), $querystring));

            // display random link if selected
            $randomlink = "";
            if (serendipity_db_bool($this->get_config('showrandom', false))) {
                $cond['compare2'] = " e.id <> " . (int)$id ." AND e.isdraft = 'false' AND e.timestamp <= " . $this->timeOffset(time());

                if ($serendipity['dbType'] ==  'mysql' || $serendipity['dbType'] == 'mysqli') {
                    $sql_order = "ORDER BY RAND()";
                } else {
                    // SQLite and PostgreSQL support this, hooray.
                    $sql_order = "ORDER BY RANDOM()";
                }    

                $querystring = "SELECT
                                    e.id, e.title, e.timestamp
                                FROM
                                    {$serendipity['dbPrefix']}entries e
                                WHERE
                                    {$cond['compare2']}
                                $sql_order
                                LIMIT  1";
                $randID = serendipity_db_query($querystring);

                if ($link = $this->makeLink($randID, 'random')) {
                    $randomlink = '<span class="serendipity_entrypaging_random">' . PLUGIN_ENTRYPAGING_RANDOM_TEXT . $link . '<br /></span>';
                }
            }

            if ($link = $this->makeLink($prevID, 'prev')) {
                $links[] = '<span class="serendipity_entrypaging_left"><span class="epicon">&lt;</span> ' . $link . '</span>';
            }

            if ($link = $this->makeLink($nextID, 'next')) {
                $links[] = '<span class="serendipity_entrypaging_right">' . $link . ' <span class="epicon">&gt;</span></span>';
            }

            // choose method of display
            if ($placement == 'smarty' && is_object($serendipity['smarty'])) {
                $serendipity['smarty']->assign($this->smartylinks);
            } elseif ($disp == '1') {
                echo '<div class="serendipity_entrypaging">' . $randomlink . implode(' <span class="epicon">|</span> ', $links) . '</div>';
            } elseif ($disp == '2') {
                $eventData[0]['add_footer'] .= '<div class="serendipity_entrypaging">' . $randomlink . implode(' <span class="epicon">|</span> ', $links) . '</div>';
            } else {
                return false;
            }

            return true;
        }
        return false;
    }
    return false;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
