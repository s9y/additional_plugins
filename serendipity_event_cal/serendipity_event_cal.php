<?php

##error_reporting(E_ALL);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

/*Probe for a language include with constants. Still include defines later on, if some constants were missing */
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

/* * Set some global vars as plugins serendipity vars * */

/* set global plugin path setting, to avoid different pluginpath '/plugins/' */
if (!isset($serendipity['eventcal']['pluginpath'])) {
    $pluginpath = pathinfo(dirname(__FILE__));
    $serendipity['eventcal']['pluginpath'] = basename(rtrim($pluginpath['dirname'], '/')) . '/serendipity_event_cal/';
}

/* allow browser popup if you use these two S9Y global serendipity['smarty']->debugging functions */
#$serendipity['smarty']->debugging           = true;
#$serendipity['smarty']->debugging_ctrl      = true;


/* set some GLOBAL vars and enable/disable internal plugin_eventcal debugging */
$serendipity['SERVER']['eventcal_debug']  = FALSE;
#$serendipity['SERVER']['eventcal_debug']  = TRUE;

class serendipity_event_cal extends serendipity_event {

    var $title = PLUGIN_EVENTCAL_TITLE;

    function cleanup() {
        // Cleanup. Remove all empty configs on SAVECONF-Submit.
        serendipity_plugin_api::remove_plugin_value($this->instance, array('version', ''));

        return true;
    }

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',           PLUGIN_EVENTCAL_TITLE);
        $propbag->add('description',    PLUGIN_EVENTCAL_TITLE_BLAHBLAH);
        $propbag->add('stackable',      false);
        $propbag->add('event_hooks',    array(
                                            'frontend_configure'        => true,
                                            'external_plugin'           => true,
                                            'genpage'                   => true,
                                            'entry_display'             => true,
                                            'entries_header'            => true,
                                            'css'                       => true,
                                            'backend_sidebar_entries'   => true,
                                            'backend_sidebar_admin_appearance' => true,
                                            'backend_sidebar_entries_event_display_eventcal'  => true,
                                            'css_backend'               => true
                                        )
                    );
        $propbag->add('configuration', array(
                                            'permalink',
                                            'pagetitle',
                                            'articleformat',
                                            'headline',
                                            'showintro',
                                            'eventwrapper',
                                            'showcaptcha',
                                            'showical',
                                            'ical_icsurl',
                                            'log_ical',
                                            'log_email'
                                        )
                    );
        $propbag->add('author',         'Ian (Timbalu)');
        $propbag->add('version',        '1.77');
        $propbag->add('groups',         array('FRONTEND_FEATURES', 'BACKEND_FEATURES'));
        $propbag->add('requirements',   array(
                                            'serendipity' => '1.4',
                                            'smarty'      => '2.6.7',
                                            'php'         => '5.1.0'
                                        )
                    );

        $propbag->add('legal',    array(
            'services' => array(
                'mail' => array(
                    'url'  => '#',
                    'desc' => 'Transmits IP address and ical data via e-mail'
                ),
            ),
            'frontend' => array(
                'Transmits IP address and ical data via e-mail'
            ),
            'backend' => array(
            ),
            'cookies' => array(
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => true,
            'transmits_user_input'  => true
        ));
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch ($name) {

            case 'permalink':
                $propbag->add('type',       'string');
                $propbag->add('name',       PLUGIN_EVENTCAL_PERMALINK);
                $propbag->add('description',PLUGIN_EVENTCAL_PERMALINK_BLAHBLAH);
                $propbag->add('default',    $serendipity['rewrite'] != 'none'
                                            ? $serendipity['serendipityHTTPPath'] . 'pages/eventcal.html'
                                            : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/pages/eventcal.html');
                break;

            case 'pagetitle':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENTCAL_PAGETITLE);
                $propbag->add('description', PLUGIN_EVENTCAL_PAGETITLE_BLAHBLAH);
                $propbag->add('default', 'eventcal');
                break;

            case 'articleformat':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENTCAL_ARTICLEFORMAT);
                $propbag->add('description', PLUGIN_EVENTCAL_ARTICLEFORMAT_BLAHBLAH);
                $propbag->add('default', '1');
                break;

            case 'headline':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENTCAL_HEADLINE);
                $propbag->add('description', PLUGIN_EVENTCAL_HEADLINE_BLAHBLAH);
                $propbag->add('default', '');
                break;

            case 'showintro':
                $propbag->add('type', ($serendipity['wysiwyg'] === true ? 'html' : 'text'));
                $propbag->add('rows', 3);
                $propbag->add('name', PLUGIN_EVENTCAL_SHOWINTRO);
                $propbag->add('description', PLUGIN_EVENTCAL_SHOWINTRO_BLAHBLAH);
                $propbag->add('default', '');
                break;

            case 'eventwrapper':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENTCAL_EVENTWRAPPER);
                $propbag->add('description', PLUGIN_EVENTCAL_EVENTWRAPPER_BLAHBLAH);
                $propbag->add('default', 'false');
                break;

            case 'showcaptcha':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENTCAL_SHOWCAPTCHA);
                $propbag->add('description', PLUGIN_EVENTCAL_SHOWCAPTCHA_BLAHBLAH);
                $propbag->add('default', 'false');
                break;

            case 'showical':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENTCAL_SHOWICAL);
                $propbag->add('description', PLUGIN_EVENTCAL_SHOWICAL_BLAHBLAH);
                $propbag->add('default', 'false');
                break;

            case 'ical_icsurl':
                $listdl_types = array(
                    'no'  => PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_NO,
                    'dl'  => PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_DL . ' ' . PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_EXPORT,
                    'wc'  => PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_WEBCAL . ' ' . PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_EXPORT,
                    'ml'  => PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_MAIL . ' ' . PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_INTERN,
                    'ud'  => PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_USER
                    );
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_EVENTCAL_ICAL_ICSURL);
                $propbag->add('description', PLUGIN_EVENTCAL_ICAL_ICSURL_BLAH . ' ' . PLUGIN_EVENTCAL_ICAL_ICSURL_BLAHBLAH . ' (Webcal-Push usage is still experimental!)');
                $propbag->add('default', 'no');
                $propbag->add('select_values', $listdl_types);
                break;

            case 'log_ical':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENTCAL_ICAL_LOG);
                $propbag->add('description', PLUGIN_EVENTCAL_ICAL_LOG_BLAHBLAH);
                $propbag->add('default', 'false');
                break;

            case 'log_email':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENTCAL_ICAL_LOG_EMAIL);
                $propbag->add('description', PLUGIN_EVENTCAL_ICAL_LOG_EMAIL_BLAHBLAH);
                $propbag->add('default', '');
                break;

            default:
                break;
        }
        return true;
    }

    /**
     * check cross-platform newlines and change them to unix style to insert into database
     *
     * @param  array *|* $value
     * @return array *|* $value
     */
    function check_newline($v) {
        $v = trim($v);
        $v = preg_replace("/(<br \/>\n|<br>\n|&#13;|\r\n|\n|\r)/", "\n", $v); // cross-platform newlines change to unix style
        // don't allow out-of-control blank lines
        $v = preg_replace("/\n{2,}/", "\n\n", $v); // take care of duplicates
        return $v;
    }

    /**
     * check newlines, magic_quotes_gpc, strip_tags and escape to prepare for database inserts
     *
     * @param  array *|* $_POST
     * @return array *|* $_POST
     */
    function check_global_input_values() {
        if (is_array($_POST)) {
            reset($_POST);
            foreach($_POST as $key=>$val) {
                if (is_array($val)) {
                    foreach($val as $akey=>$aval) {
                        $aval = $this->check_newline($aval);
                        $aval = ini_get('magic_quotes_gpc') ? serendipity_db_escape_string(stripslashes($aval)) : serendipity_db_escape_string($aval);
                        // be strict and do not allow any code
                        $_POST[$key][$akey] = strip_tags($aval);  // array e.g. $row['name']
                    }
                } else {
                    $val = $this->check_newline($val);
                    $val = ini_get('magic_quotes_gpc') ? serendipity_db_escape_string(stripslashes($val)) : serendipity_db_escape_string($val);
                    // be strict and do not allow any code
                    $_POST[$key] = strip_tags($val);  // array e.g. $row['name']
                }
            }
        }
        return $_POST;
    }

    /**
     * function multi_strip_array_values($row, $savearrayname=TRUE, $outputformfield=TRUE)
     *
     * Check SQL Query Result Set: check for stripslashes in database array values and make (\n)ewlines readable = <br />\n
     * since serendipity works with nl2br we do not need a double :: nl2br(stripslashes($aval)) || nl2br(stripslashes($val))
     *
     * @param  database array
     * @return single-array [$row]
     * @access public
     * @start function with: $val = multi_strip_array_values($row, $savearrayname=TRUE, $outputformfield=TRUE);
     */
    function multi_strip_array_values($row, $savearrayname=TRUE, $outputformfield=TRUE) {
        if (is_array($row)) {
            reset($row);
            foreach($row as $key => $val) {
                if (is_array($val)) {
                    foreach($val as $akey => $aval) {
                        if ($savearrayname == true)
                            $row[$key][$akey] = ($outputformfield == true) ? stripslashes((function_exists('serendipity_specialchars') ? serendipity_specialchars($aval) : htmlspecialchars($aval, ENT_COMPAT, LANG_CHARSET))) : stripslashes($aval); // array e.g. $row['name']
                        else
                            $$key[$akey]      = ($outputformfield == true) ? stripslashes((function_exists('serendipity_specialchars') ? serendipity_specialchars($aval) : htmlspecialchars($aval, ENT_COMPAT, LANG_CHARSET))) : stripslashes($aval); // $key-name e.g. $name
                    }
                } else {
                    if ($savearrayname == true)
                        $row[$key] = ($outputformfield == true) ? stripslashes((function_exists('serendipity_specialchars') ? serendipity_specialchars($val) : htmlspecialchars($val, ENT_COMPAT, LANG_CHARSET))) : stripslashes($val); // array e.g. $row['name']
                    else
                        $$key      = ($outputformfield == true) ? stripslashes((function_exists('serendipity_specialchars') ? serendipity_specialchars($val) : htmlspecialchars($val, ENT_COMPAT, LANG_CHARSET))) : stripslashes($val); // $key-name e.g. $name
                }
            }
        }
        return $row;
    }

    /* Independent email tester */
    function is_valid_email($postmail) {
        // Email needs to match this pattern to be a good email address
        if (!empty($postmail)) {
            return (preg_match(
                ":^([-!#\$%&'*+./0-9=?A-Z^_`a-z{|}~ ])+" .     // the user name
                "@" .                                         // the ubiquitous at-sign
                "([-!#\$%&'*+/0-9=?A-Z^_`a-z{|}~ ]+\\.)+" . // host, sub-, and domain names
                "[a-zA-Z]{2,6}\$:i",                         // top-level domain (TLD)
                trim($postmail)));                            // get rid of trailing whitespace
        } else
            return false;
    }

    /* BBCode replacements */
    function text_pattern_bbc($text) {
        $patterns = array(
            "/\[b\](.*?)\[\/b\]/",
            "/\[u\](.*?)\[\/u\]/",
            "/\[i\](.*?)\[\/i\]/",
            "/\[s\](.*?)\[\/s\]/"
        );
        $replacements = array(
            "<strong>\\1</strong>",
            "<u>\\1</u>",
            "<em>\\1</em>",
            "<del>\\1</del>"

        );
        return preg_replace($patterns,$replacements, $text);
    }

    function htmlPageHeader() {
        echo "<!-- htmlPageHeader start -->\n";
        echo "<!-- htmlPageHeader end -->\n\n";
    }

    function htmlPageFooter() {
        echo "<!-- htmlPageFooter start -->\n";
        echo "<!-- htmlPageFooter end -->\n";
    }

    /**
     * Serendipity_event_cal.php internal debugging function
     * @param  var array
     * @return single-string [$debug]
     */
    function show_debug(&$table, $name='unknown') {
        $debug = $name . '<br />';
        $debug .= '<table cellspacing="1" cellpadding="2"><tr class="error_table_main">';
        foreach ($table AS $k=>$v) {
            if ($v) $debug .= '<th><strong>'.$k.'</strong></th>';
        }
        $debug .= '</tr><tr>';
        foreach ($table AS $k2=>$v2) {
            if ($v2) $debug .= '<td class="error_value">'.$v2.'</td>';
        }
        $debug .= '</tr></table>'."\n";

        return $debug;
    }

    /**
     * Assign errors and messages to smarty
     * @param  type string and errtxt array
     * @return smarty assigned error messages
     */
    function smarty_assign_error($type, $errtext) {
        global $serendipity;

        switch($type) {
            case 'err':
                return $serendipity['smarty']->assign(
                    array(
                        'is_eventcal_error'     => true,
                        'plugin_eventcal_error' => '<span class="icon-attention-circled" aria-hidden="true"></span> ' . $errtext
                    )
                );
                break;

            case 'msg':
                return $serendipity['smarty']->assign(
                    array(
                        'is_eventcal_message'     => true,
                        'plugin_eventcal_message' => '<span class="icon-info-circled" aria-hidden="true"></span> ' . $errtext
                    )
                );
                break;
        }
    }

    /**
     * use permalink generally instead of subpage
     * @return permalink or subpage value
     */
    function fetchPluginUri() {
        global $serendipity;
        return ($serendipity['rewrite'] != 'errordocs') ? $this->get_config('permalink') : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?serendipity[subpage]=' . $this->get_config('pagetitle');
    }

    /**
     * mysql db function
     * @param  type string and db vars
     * @return result
     *
     * serendipity_db_query [ sql, single(true, false), arrtype(both, assoc, num), dberror(true, false), string(array key name), string(array field name) ... ]
     */
    function mysql_db_result_sets($type=NULL, $id=NULL, $sda=NULL, $eda=NULL, $rec=NULL, $sde=NULL, $url=NULL, $lde=NULL, $tip=0, $app=0, $aby=NULL, $tst=NULL, $whe=NULL) {
        global $serendipity;

        switch($type) {
            case 'INSERT':
                $sql = "INSERT INTO {$serendipity['dbPrefix']}eventcal VALUES ($id, '$sda', '$eda', '$rec', '$sde', '$url', '$lde', $tip, $app, '$aby', NOW(), NOW())";
                $result = serendipity_db_query($sql, true, 'both', true);
                break;
            case 'REPLACE':
                $sql = "REPLACE {$serendipity['dbPrefix']}eventcal SET id=$id, sdato='$sda', edato='$eda', recur='$rec', sdesc='$sde', url='$url', ldesc='$lde', tipo=$tip, approved=$app, app_by='$aby', tstamp='$tst'";
                $result = serendipity_db_query($sql, true, 'both', true);
                break;
            case 'SELECT-ARRAY-KEYS':
                $sql = "SELECT id, sdato, edato, recur, sdesc, url, ldesc, tipo, app_by, DATE_FORMAT(tstamp, '%Y%m%dT%H%i%s') AS tstamp, DATE_FORMAT(modified, '%Y%m%dT%H%i%s') AS modified, UUID() AS uid  FROM {$serendipity['dbPrefix']}eventcal WHERE $whe";
                // result is a mysql_fetch_array of multiple rows (FALSE)
                $result = serendipity_db_query($sql, false, 'assoc', true);
                break;
            case 'SELECT-ARRAY':
                $sql = "SELECT * FROM {$serendipity['dbPrefix']}eventcal WHERE $whe";
                // result is a mysql_fetch_array of multiple rows (FALSE)
                $result = serendipity_db_query($sql, false, 'assoc', true);
                break;
            case 'SELECT-KEY':
                $sql = "SELECT *, UUID() AS uid FROM {$serendipity['dbPrefix']}eventcal WHERE $whe";
                // show single event to edit one single unapproved event :: result is a single row array
                $result = serendipity_db_query($sql, true, 'assoc', true);
                break;
            case 'SELECT-NUM':
                $sql = "SELECT count(id) FROM {$serendipity['dbPrefix']}eventcal WHERE $whe";
                // count mysql_num_rows of unapproved events :: result is a single row array
                $result = serendipity_db_query($sql, true, 'num', true);
                break;
            case 'UPDATE':
                // approve events
                $sql = "UPDATE {$serendipity['dbPrefix']}eventcal SET $whe";
                $result = serendipity_db_query($sql, true, 'both', true);
                break;
            case 'DELETE':
                // delete events
                $sql = "DELETE FROM {$serendipity['dbPrefix']}eventcal WHERE $whe";
                $result = serendipity_db_query($sql, true, 'both', true);
                break;
        }
        if ($serendipity['dbType'] == 'mysql') {
            if (mysql_errno() > 0) {
                $serendipity['smarty']->assign(
                    array(
                        'is_eventcal_error'     => true,
                        'plugin_eventcal_error' => '<strong><big>' . CAL_EVENT_DB_ERROR_ONE . ' </big></strong><br />
                                                    <em>' . mysql_error() . '</em><br />
                                                    <em>' . $sql . '</em><br />' . CAL_EVENT_DB_ERROR_TWO
                    )
                );
                return false;
            } else {
                return $result;
            }
        }
        else if ($serendipity['dbType'] == 'mysqli') {
            if (mysqli_errno($serendipity['dbConn']) > 0) {
                $serendipity['smarty']->assign(
                    array(
                        'is_eventcal_error'     => true,
                        'plugin_eventcal_error' => '<strong><big>' . CAL_EVENT_DB_ERROR_ONE . ' </big></strong><br />
                                                    <em>' . mysqli_error($serendipity['dbConn']) . '</em><br />
                                                    <em>' . $sql . '</em><br />' . CAL_EVENT_DB_ERROR_TWO
                    )
                );
                return false;
            } else {
                return $result;
            }
        }
    }

    /* load_unapproved_events */
    function load_unapproved_events(&$re) {
        global $serendipity;

        $result = $this->mysql_db_result_sets('SELECT-ARRAY', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'approved=0 ORDER BY tstamp DESC');
        return is_array($result) ? $this->view_app_events($result, $re) : false;

    }

    /* depends on load_unapproved_events and backend functions */
    function view_app_events(&$evarr, &$re) {
        global $serendipity;

        $days = $this->days();
        if (is_array($evarr)) {
            foreach($evarr as $row) {
                switch($row['tipo']) {
                    // single
                    case 1:
                        $events[] = array('id' => $row['id'],'tipo' => $row['tipo'],'tipodate' => $row['sdato'],'sdesc' => $row['sdesc'],'ldesc' => $row['ldesc'],'url' => $row['url'],'app_by' => $row['app_by']);
                        break;
                    // multi
                    case 2:
                        $events[] = array('id' => $row['id'],'tipo' => $row['tipo'],'tipodate' => $row['sdato'].' '.PLUGIN_EVENTCAL_TEXT_TO.' '.$row['edato'],'sdesc' => $row['sdesc'],'ldesc' => $row['ldesc'],'url' => $row['url'],'app_by' => $row['app_by']);
                        break;
                    // recur monthly
                    case 3:
                        @list($which,$day) = explode(':',$row['recur']);
                        $events[] = array('id' => $row['id'],'tipo' => $row['tipo'],'tipodate' => $row['sdato'].' '. PLUGIN_EVENTCAL_TEXT_TO.' '.$row['edato'].' '. PLUGIN_EVENTCAL_TEXT_EACH .' '.strtolower($re[(int)$which]).' '.$days[$day],'sdesc' => $row['sdesc'],'ldesc' => $row['ldesc'],'url' => $row['url'],'app_by' => $row['app_by']);
                        break;
                    // recur weekly and biweekly
                    case 4:
                    case 5:
                        @list($which,$day) = explode(':',$row['recur']);
                        $events[] = array('id' => $row['id'],'tipo' => $row['tipo'],'tipodate' => $row['sdato'].' '. PLUGIN_EVENTCAL_TEXT_TO.' '.$row['edato'].' '.$re[(int)$which].' '.$days[$day],'sdesc' => $row['sdesc'],'ldesc' => $row['ldesc'],'url' => $row['url'],'app_by' => $row['app_by']);
                        break;
                    // recur yearly
                    case 6:
                        @list($which,$day) = explode(':',$row['recur']);
                        $events[] = array('id' => $row['id'],'tipo' => $row['tipo'],'tipodate' => $row['sdato'].' '.PLUGIN_EVENTCAL_TEXT_YEARLY,'sdesc' => $row['sdesc'],'ldesc' => $row['ldesc'],'url' => $row['url'],'app_by' => $row['app_by']);
                        break;
                }
            }
            return $events;
        }
        return false;
    }

    /**
     * build events array for monthly view as Calendar view
     *
     * @param int   $year
     * @param int   $month
     * @param bool  $asCalDays
     *
     * @return array for Calendar or as a monthly selection
     */
    function load_monthly_events($year, $month, $asCalDays=true) {
        global $serendipity;

        $last     = $this->last_day($year,$month);         // set last day of current month
        $month    = sprintf("%02d",$month);                // make sure month is a two digit number
        $events[] = 0;
        $sel_ym   = $year.$month;
        $sel_ms   = $month.'01';
        $sel_ml   = $month.$last;
        /* SQL WHERE STATMENT:  first     - recurring elements matching Year Month,
                                second    - recurring elements IN BETWEEN startdate and enddate,
                                third     - single events matching Year Month,
                                fourth    - yearly events matching Year Month, but alternating into future */
        // ToDO: ORDER BY HAVING tipo=2 3 4 5 1 6 which is difficult!
        $s = "
            (         ( ( ( DATE_FORMAT(sdato,'%Y%m') = '$sel_ym' ) OR ( DATE_FORMAT(edato,'%Y%m') = '$sel_ym') ) AND tipo BETWEEN 2 AND 5 )
                OR     ( '$sel_ym' BETWEEN DATE_FORMAT(sdato,'%Y%m') AND DATE_FORMAT(edato,'%Y%m') AND tipo BETWEEN 2 AND 5 )
                OR     ( sdato BETWEEN '$year-$month-01' AND '$year-$month-$last' AND tipo=1 )
                OR     ( DATE_FORMAT(sdato,'%m%d') BETWEEN '$sel_ms' AND '$sel_ml' AND tipo=6 AND DATE_FORMAT(sdato,'%Y') <= '$year' )
            )";
        $s .= $asCalDays ? "    ORDER BY tipo ASC" : "    ORDER BY tipo, sdato ASC";
        $result   = $this->mysql_db_result_sets('SELECT-ARRAY', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "approved=1 AND $s");
        // else return db error

        if (is_array($result) && $asCalDays) {
            for($i=1; $i<32; ++$i) { $events[$i][] = $i; } // this is for undefinied offsets in all non db result days
            $last = $this->last_day($year,$month);         // set last day of current month

            foreach($result as $row) {
               switch($row['tipo']) {

                    case 1: // case single events
                    case 6: // case yearly single events

                        list(,,$dd) = explode('-',$row['sdato']);
                        $events[(int)$dd][] = $row;
                        break;

                    case 2: // case multi events

                        list(,$mm,$dd) = explode('-',$row['sdato']);
                        list(,$m2,$d2) = explode('-',$row['edato']);

                        if ((int)$mm==(int)$m2) {
                            for($i=(int)$dd; $i<=(int)$d2; ++$i) {
                                $events[$i][] = $row;
                            }
                        } elseif ((int)$mm==$month) {
                            for($i=(int)$dd; $i<32; ++$i) {
                                $events[$i][] = $row;
                            }
                        } else {
                            for($i=1; $i<=(int)$d2; ++$i) {
                                $events[$i][] = $row;
                            }
                        }
                        break;

                    case 3: // case recurring monthly events
                        list($ey,$em,$ed) = explode('-',$row['edato']);
                        list($which,$day) = explode(':',$row['recur']);
                        $ts = $this->weekday($year,$month,$day,$which);
                        $nd = (int)strftime('%d',$ts);

                        /* check recurring data for year, day and month - draw event, if data is for sure inbetween sdato and edato */
                        // if current yearmonth is lower than endyearmonth OR ( current yearmonth is equal endyearmonth AND endday is higher than recurring weekday ) -> show
                        if ( ( (int)$year.(int)$month < (int)$ey.(int)$em ) || ( (int)$year.(int)$month == (int)$ey.(int)$em && (int)$ed >= $nd ) ) {
                            $events[$nd][] = $row;
                        }
                        break;

                    case 4: // case recurring weekly events
                    case 5: // case recurring biweekly events

                        list($wsy,$wsm,$wsd) = explode('-',$row['sdato']);
                        list($wey,$wem,$wed) = explode('-',$row['edato']);
                        list(,$day) = explode(':',$row['recur']);

                        for ( $i = 1; $i <= 5; ++$i ) {
                            $ts  = $this->weekday($year,$month,$day,$i); // eg. $day = Thuesday(3) and $which hast to be each 1 2 3 4 (5)
                            $wnd = (int)strftime('%d',$ts);              // weekly recurring day in month

                            if ($i > 4) {
                                if ($wnd < $last-6) {
                                    break; // break loop, if switching to next month beginning with lowest recurring daynum
                                }
                            }

                            if ($row['tipo'] == 5) {
                                $nWeeks = $this->calculate_weeks($row['sdato'], $year.'-'.sprintf("%02d",$month).'-'.sprintf("%02d",$wnd)); // weeks inbetween startdate and weekly recurday of current month
                            }

                            /* check recurring data for day and month - draw event, if data is for sure inbetween sdato and edato */
                            if (($wnd >= (int)$wsd && (int)$wsm >= (int)$month) || ($wnd <= (int)$wed && (int)$wsm != (int)$month) ||
                               ((int)$wsm != (int)$month && (int)$wem != (int)$month) || (int)$nWeeks ) {
                                // case bi-weekly events and fallback
                                if ( $row['tipo'] == 5 ) {
                                    // startmonth == currentmonth
                                    if ("$wsy$wsm" == "$year$month") {
                                        // If you want to be efficient, use bitwise operators (x & 1), but if you want to be readable use modulo 2 (x % 2)
                                        if ($wsd == $wnd || (isset($nWeeks) && !($nWeeks & 1)) ) $events[$wnd][] = $row; // Just check the last bit if it is even!
                                    } else {
                                        if (isset($nWeeks) && !($nWeeks & 1) ) $events[$wnd][] = $row; // Just check the last bit if it is even! also  % 2
                                    }
                                } else {
                                    $events[$wnd][] = $row;
                                }
                            }
                        }
                        break;
                }
            }
        } else {
            $events = $result;
        }

        return($events);
    } // load_monthly_events() end

    /**
     * build sd week events array for weekly view only
     */
    function load_weekly_events($cw, $y, &$sd) {
        /* check if array $sd has needle 'x' and return key */
        if ($wcw = $this->recur_array_search($cw, $sd, 'cwnm')) {
            /* build new sd_week array with selected key only */
            $sd_week[0] = $sd[$wcw];
            /* rebuild days head array - no need for unset($sd_week[0]['head']); */
            $sd_week[0]['head'] = $this->days();
        }
        return $sd_week;
    }

    /**
     * search 'cwnm' => $cw and return the array key for the selected calendar week number
     */
    function recur_array_search($needle,$haystack,$searchkey) {
        foreach($haystack as $key=>$value) {
            if ($key == $searchkey && $needle === $value || (is_array($value) && $this->recur_array_search($needle,$value,$searchkey) !== false)) {
                return $key;
            }
        }
        return false;
    }

    /**
     * calculate weeks between startdate and enddate to have proper even or odd in case of bi-weekly occurrences
     */
    function calculate_weeks($startDate, $endDate) {
        $start_ts    = strtotime($startDate);
        $end_ts      = strtotime($endDate);
        $elapsedSecs = $end_ts - $start_ts;

        // Now evaluate the elapsed secs to comeup with number of weeks, num of days, num of hours, etc..
        // WEEK contains 604800 seconds, intval(intval( is to strict, since strtotime sets the summertime
        // original gave back remainingSecs -3600 between begin of april and end of october - this is summertime! So I use round, which works
        if ($elapsedSecs >= 604800) {
            $numOfWeeks = round(intval($elapsedSecs) / 604800, 0); //intval(intval($elapsedSecs) / 604800);
            $remainingSecs = intval(intval($elapsedSecs) - ($numOfWeeks * 604800));
        } else {
            if (!$elapsedSecs) $numOfWeeks = 0;
            $remainingSecs = intval($elapsedSecs);
        }

        // DAY contains 86400 seconds
        if ($remainingSecs >= 86400) {
            $numOfDays = round(intval($remainingSecs) / 86400); // intval(intval($remainingSecs) / 86400); // see above, not verified
            $remainingSecs = intval(intval($remainingSecs) - ($numOfDays * 86400));
        }
        return intval($numOfWeeks); // inbetween
    }


    /**
     * check startday of recurring event is the same as posted startday
     */
    function calculate_recur_validday($sy, $sm, $sd, $rd, $wd) {
        // Any timestamp inside the month for which we want to calculate.
        $DateTS = mktime(12, 0, 0, sprintf("%02d",$sm), sprintf("%02d",$sd), $sy); #$DateTS = time();

        // The day of interest.  It can be 0=Sunday through 6=Saturday (Like 'w' from date()).
        $Day = $wd; //5;

        // The occurrence of this day in which we are interested.  It can be 1, 2, 3, 4, or -1, corresponding with first, second, third, fourth, and last.
        // Last will return either the fifth occurrence if there is one, otherwise the 4th. Might tell me in future to get rid of second- and thirdlast occurrences ;-)
        $Ord = $rd; //4;

        // We need the day name that corresponds with our day number.
        // We could just specify the string in the first place, but for date calcs, you are more likely to have the day number than the string itself.
        $Names = array( 0=>"Sun", 1=>"Mon", 2=>"Tue", 3=>"Wed", 4=>"Thu", 5=>"Fri", 6=>"Sat" );

        // This is the first of the month, relative to $DateTS.
        $ThisMonthTS = strtotime( date("Y-m-01", $DateTS ) );

        // This is the first of next month, relative to $DateTS.
        $NextMonthTS = strtotime( date("Y-m-01", strtotime("next month", $DateTS) ) );

        // We now calculate the date of the $Ord-th occurrence of $Day in the month in question.
        // We can work forward from the secondlast, thirdlast, first of this month, or backward from the last of next month.
        if (-2 == $Ord )     $DateOfInterest = strtotime( "-2 week".$Names[$Day], $NextMonthTS );
        elseif (-3 == $Ord ) $DateOfInterest = strtotime( "-3 week".$Names[$Day], $NextMonthTS );
        else                $DateOfInterest = (-1 == $Ord) ? strtotime( "last ".$Names[$Day], $NextMonthTS ) : strtotime( $Names[$Day]." + ".($Ord-1)." weeks", $ThisMonthTS );

        // return the real start date to compare to the selected startday
        return date("d", $DateOfInterest);
    }

    /**
     * Find the first (1), second (2), third (3), fourth (4), last (-1), second-last (-2), thirdlast (-3) weekday of a week
     * weekly (5) is out of scope and only used if tipo = 4/5 (weekly and biweekly events)
     */
    function weekday($year, $month, $day, $which) {
        $ts = mktime(12,0,0,$month+(($which>0)?0:1),($which>0)?1:0,(int)$year);
        $done = false;
        $match = 0;
        $inc = 3600*24;
        while(!$done) {
            if (strftime('%w',$ts)==$day-1) {
                $match++;
            }
            if ($match==abs($which)) $done=true; // abs to get rid of leading zero
            else $ts += (($which>0)?1:-1)*$inc;
        }
        return $ts;
    }

    function start_month($year, $month) {
        $ts = mktime(12,0,0,$month,1,(int)$year);
        return strftime('%w',$ts);
    }

    function last_day($year, $month) {
        $ts = mktime(12,0,0,($month+1),0,(int)$year);
        return strftime('%d',$ts);
    }

    function months() {
        static $months=NULL;
        // located in germany and you know about this nasty 'M?rz' Problem, if the default charset isn't utf-8 ?
        // use iconv for windows and better dpkg-reconfigure locales for linux OS
        for($i=1; $i<=12; ++$i) {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' && function_exists('iconv')) {
                $months[$i] = iconv('ISO-8859-1', 'UTF-8', strftime('%B', mktime(12, 0, 0, $i, 1)));
            } else {
                // fallback, it does not really matter under windows too
                $months[$i] = strftime('%B',mktime(12,0,0,$i,1));
            }
        }
        return $months;
    }

    /* returns array of Days starting with 1 = Sunday */
    function days() {
        static $days=NULL;
        for($i=1; $i<=7; ++$i) {
            $days[$i] = strftime('%A',mktime(12,0,0,4,$i,2001));
        }
        return $days;
    }

    /* returns array of days 1-31 */
    function optdays() {
        for($i=1; $i<=31; ++$i) {
            $days[$i] = strftime('%d',mktime(12,0,0,1,$i,2001));
        }
        return $days;
    }

    /* display calendar week number */
    function cwno($y, $m, $d) {
        $now = mktime (12, 0, 0, $m, $d, $y);
        $weekday = date ('w', $now);
        $week = date("W", $now);

        if ($weekday == 0 || $weekday >= 5) // Sunday or Friday/Saturday :: ISO8601 defines 1st week of year, is week with 1st thursday
            $week++;
        return $week-1;
    }

    /* a Bjoern Schotte function - get first calendar week number */
    function first_cw($year) {
        $first = mktime(12,0,0,1,1,$year);
        $wday = date('w',$first);
        if ($wday <= 4) {
            /* if thursday or less, get back to monday */
            $monday = mktime(12,0,0,1,1-($wday-1),$year);
        } else {
            /* count to monday forward */
            $monday = mktime(12,0,0,1,1+(7-$wday+1),$year);
        }
        $day = $monday-86400; // switch one day back to sunday, while this calendar works with Sunday as first week day

        return $day;
    }

    /* a Bjoern Schotte function - get first monday(sunday) in first week number */
    function startday_cw($cw, $y) {
        $fm = $this->first_cw($y);
        $mm = date('m',$fm);
        $my = date('Y',$fm);
        $md = date('d',$fm);
        $ds = ($cw-1)*7;

        $startday_cw = mktime(12,0,0,$mm,$md+$ds,$my);
        return $startday_cw;
    }

    /* display an option list with one selected */
    function display_options($options, $current) {
        foreach ($options as $k => $v) {
            $opt[] = '<option value="' . $k . '"' .
                    ($k == $current ? ' selected="selected"' : '') .
                    '>' . htmlentities($v, ENT_QUOTES, 'UTF-8') . "</option>
                    ";
        }
        return $opt;
    }


    /**
     * build the $sd events array for each day of month or week
     */
    function draw_eventdays($a, $ap, $m, $y, &$events, $cw) {
        global $serendipity;

        $sd = array();

        $days     = $this->days();                             // set days
        $start    = $this->start_month($y,$m);                 // set start counting range for monthly view $rows & items
        $last     = $this->last_day($y,$m);                    // set last day of current month
        $lcw      = date("W", $this->first_cw($y));            // set last cw of year
        $fcw      = $this->cwno($y, $m, 6);                    // set first cw in current month as int - uses 6 = Friday
        if ($cw == $lcw && $m == 1 && $fcw == 0) $fcw = 54;    // workaround the problem 52/53 > 0 for cwnm_prev with first cw at year start

        if (!isset($day)) $day = 0;
        if (($start==5 && $last>30) || ($start==6 && $last>29)) $rows=7; elseif ($start==0 && $last==28) $rows=5; else $rows=6;

        for($j=0; $j<$rows; ++$j) {
            for($i=1; $i<=7; ++$i) {
                if ($j==0) {
                    $sd[$i]['head'] = $days[$i];
                } else {
                    if ($j==1 && ($i-1)==$start) $day = 1;
                    $sd[$j]['cwnm'] = $this->cwno($y, $m, $day);                              // fetch the calendar week numbers as int
                    if (isset($cw) && $cw != NULL) {
                        $sd[$j]['cwnm_m']         = sprintf("%02d",$m);                       // set cw's current month
                        $sd[$j]['cwnm_y']         = $y;                                       // set cw's current year
                        $sd[$j]['cwnm_prev']      = sprintf("%02d",date("W", $this->startday_cw($cw, $y)));   // set prev cw to navigate in weekly view
                        $sd[$j]['cwnm_next']      = sprintf("%02d",date("W", $this->startday_cw($cw+2, $y))); // set next cw to navigate in weekly view
                        $sd[$j]['cwnm_first']     = $fcw;                                     // get range to navigate to previous cw in weekly view this month only
                        $sd[$j]['cwnm_days'][$i]  = ($day !== 0 && $day <= $last) ? $y.'-'.sprintf("%02d",$m).'-'.sprintf("%02d",$day) : 0; // get the range of qualified days
                        $sd[$j]['cwnm_lastday']   = $y.'-'.sprintf("%02d",$m).'-'.sprintf("%02d",$last);       // set last day of month to stop iteration in weekly view
                    }                                                                       // if isset cw and day range between 1 and last day end
                    if ($day && $day <= $last) {
                        if ($day==date("d") && $m==date("m") && $y==date("Y")) {
                            $sd[$j]['days'][$i]['col'] = 'today';                               // #D5BFC0 todays color - same as show single event day - see tpl plugin_eventcal_cal.tpl
                            $sd[$j]['days'][$i]['today'] = 'today';
                        } else {
                            $sd[$j]['days'][$i]['col'] = 'isday';                               // '#f0f0f0'; is valid day - color white - see tpl plugin_eventcal_cal.tpl
                            $sd[$j]['days'][$i]['today'] = 'blank';
                        }
                        $sd[$j]['days'][$i]['label'] = $day;
                        $sd[$j]['days'][$i]['bcol']  = $sd[$j]['days'][$i]['col'];                   // no days bgcolor

                        if (is_array($events[$day]) && !empty($events[$day])) {
                            foreach($events[$day] as $row) {
                                if ((int)$row['id']) {
                                    if (isset($cw) && $cw != NULL) {                        // set CW weeks array fullview for specified month
                                        $sd[$j]['days'][$i]['arrdata'][] = array(
                                                                    'a'      => $a,
                                                                    'ap'     => $ap,
                                                                    'm'      => $m,
                                                                    'y'      => $y,
                                                                    'id'     => $row['id'],
                                                                    'sdato'  => $row['sdato'],
                                                                    'edato'  => $row['edato'],
                                                                    'sdesc'  => $row['sdesc'],
                                                                    'ldesc'  => $this->text_pattern_bbc($row['ldesc']),
                                                                    'url'    => $row['url'],
                                                                    'app_by' => $row['app_by'],
                                                                    'tipo'   => $row['tipo']
                                                                );
                                    } else {                                               // set normal month array
                                        $sd[$j]['days'][$i]['arrdata'][] = array(
                                                                    'a'     => $a,
                                                                    'ap'    => $ap,
                                                                    'm'     => $m,
                                                                    'y'     => $y,
                                                                    'id'    => $row['id'],
                                                                    'sdesc' => $row['sdesc'],
                                                                    'tipo'  => $row['tipo']
                                                                );
                                    }
                                }
                            }
                        }
                    } else {
                        $sd[$j]['days'][$i]['label'] = false;                                   // is not valid day - do not show day number
                        $sd[$j]['days'][$i]['col']   = 'noday';                                 // '#d0d0d0'; is not valid day - color gray - see tpl plugin_eventcal_cal.tpl
                        $sd[$j]['days'][$i]['bcol']  = $sd[$j]['days'][$i]['col'];
                        $sd[$j]['days'][$i]['today'] = false;
                    }
                }
                if ($day) $day++;
            }
        }
        return $sd;
    } // draw_eventdays() end


    /* Various ways to creat a new, random GUID - as Microsoft format in curly brackets */
    function create_ical_guid() {
        $ical_uid = "{" . uniqid(mt_rand(), true) . "}";
        $ical_uid = "{" . date('Ymd').'T'.date('His')."-".rand()."@".$_SERVER['HTTP_HOST']."}";
        if (function_exists('com_create_guid')){
            $ical_uid = com_create_guid();
        }
        return isset($ical_uid) ? $ical_uid : false;
    }


    /* make sure there is no template output in our *.ics file */
    function strip_ical_data($string, $start_tag, $end_tag) {
        $position       = stripos($string, $start_tag);
        $str            = substr($string, $position);
        $str_second     = substr($str, strlen($start_tag));
        $second_positon = stripos($str_second, $end_tag);
        $str_third      = substr($str_second, 0, $second_positon);
        $fetch_data     = trim($str_third);

        return $fetch_data;
    }


    /**
     * recursive str_replaces in ical event array, happens to special keys only
     *
     * @param search                      = array
     * @param replace                     = string or array
     * @param dara                        = array
     * @param search in specific key only = string (optional)
     *
     * @return array
     */
    function str_replace_recursive($search, $replace, &$data, $skey=false) {
        if (is_array($data)) {
            foreach($data as $key => $value) {
                if (is_array($value) ) {
                    $this->str_replace_recursive($search, $replace, $data[$key], $skey);
                } else {
                    if ($key == $skey || !$skey) $data[$key] = str_replace($search, $replace, $value);
                }
            }
        } else {
            $data = str_replace($search, $replace, $arrdata);
        }
        return isset($data) ? $data : false;
    }


    /* method "example" creates the file upon configuration */
    function example() {
        global $serendipity;

        // remove an old lang file
        if (is_file(dirname(__FILE__) . '/UTF-8/lang_en.inc.php')) {
            @unlink(dirname(__FILE__) . '/UTF-8/lang_en.inc.php');
        }

        $file = $serendipity['serendipityPath'] . 'uploads/icalendar.ics';
        if (!file_exists($file)) {
            $fp = fopen($file, 'w');
            fwrite($fp, 'stuff');
            fclose($fp);
            return true;
        }
        return false; // file already exists
    }

    /* write fetched tpl ical string to file */
    function write_file($string_icl) {
        global $serendipity;

        // write to icalendar.ics file
        $fullpath   = $serendipity['serendipityPath'] . 'uploads/icalendar.ics';
        $filename   = 'icalendar.ics';
        $filepath   = 'uploads/';

        if (file_exists($fullpath) && !empty($string_icl) )
            return $this->backend_file_write($string_icl, $fullpath, $filename, $filepath, 'w');
        else
            return false; // file does not exist or error
    }


    /**
     * Write the iLog file and/or send an iCal request log notice to the admin via email
     *
     * @access
     * @param  string   Admins email address to send the mail to
     * @param  string   The name of the sender - unknown
     * @param  string   If REQUEST via email, email address to send the mail to
     * @param  int      The ID request that has been sent
     * @param  string   The year-month ARRAY request that has been sent
     * @param  string   The title which type of request the user ordered
     * @param  string   The request type which has been sent
     * @param  boolean  If true function is used to send email, else just log to file
     * @return boolean  Return success of sending the mails
     */
    function send_ical_log_email($to, $fromName, $fromEmail, $id, $monthdate, $title, $type, $smail=true) {
        global $serendipity;

        if (empty($fromName)) {
            $fromName = ANONYMOUS;
        }

        if ($monthdate > 0) {
            list($y,$m) = explode('-',$monthdate);
            $getid  = ( isset($id) && $id > 0 ) ? '&calendar[ev]='.$id : '';
            // frontend request - uri to frontend
            $entryURI   = 'http://' . $_SERVER['HTTP_HOST'] . $this->fetchPluginUri() . (($serendipity['rewrite'] == 'rewrite') ? '?' : '&') . 'calendar[cm]='.$m.'&calendar[cy]='.$y . $getid;
        } else {
            // admin panel request - uri to ical backend
            $entryURI   = 'http://' . $_SERVER['HTTP_HOST'] . $serendipity['serendipityHTTPPath'] . 'serendipity_admin.php?serendipity[adminModule]=event_display&serendipity[adminAction]=eventcal&serendipity[eventcalcategory]=adevplad&serendipity[eventcaldbclean]=dbicalall';
        }
        // set the log vars
        $info       = 'iCal REQUEST via '. $type;
        $sub        = date('Y-m-d H:i:s');
        $sub2       = 'serendipity_event_cal plugin // iCal request LOG';
        $sid        = ( isset($id) && $id > 0 ) ? $id : 'none';
        $monthdate  = $monthdate > 0 ? $monthdate : 'app-all';
        $fromEmail  = $fromEmail ? $fromEmail : 'none';

        // write to ical.log file
        $logstring  = "$sub, ID=$sid, MONTH=$monthdate, $info, IP=".$_SERVER['REMOTE_ADDR'].", EMAIL=$fromEmail, PATH=$entryURI\n";
        $fullpath   = $serendipity['serendipityPath'] . 'templates_c/eventcal/ical.log';
        $filename   = 'ical.log';
        $filepath   = 'templates_c/eventcal/';
        $directory  = "eventcal";
        if (!is_dir('templates_c/' . $directory)) {
            @mkdir('templates_c/' . $directory, 0777);
        }

        if ( false === ( $wicl = $this->backend_file_write($logstring, $fullpath, $filename, $filepath, 'a') ) ) $nolog = true;
        if ($nolog === true) $serendipity['eventcal']['ilogerror'] = true;

        $subject = ' // ' . $sub . ' // ' . $sub2 . ' // ' . $title;
        $text = "\n" . USER . ' ' . REQUEST_DATE   . ': ' . $sub.', '.$serendipity['blogTitle'].', '.$title
              . "\n"
              . "\n" . USER . ' ' . ARCHIVE_LINK   . ': ' . '<a href="'.$entryURI.'">link</a>'
              . "\n" . USER . ' ' . INFO           . ': ' . $info
              . "\n"
              . "\n" . USER . ' ' . IP_ADDRESS     . ': ' . $_SERVER['REMOTE_ADDR']
              . "\n" . USER . ' ' . TO_EMAIL       . ': ' . $fromEmail
              . "\n" . USER . ' ' . ICAL_ID        . ': ' . $sid
              . "\n" . USER . ' ' . YEAR_MONTH     . ': ' . $monthdate
              . "\n"
              . "\n" . REQUEST_DATE                . ': ' . $sub;
        $text = ($nolog === true) ? $text . "\n" . PLUGIN_EVENTCAL_ADMIN_LOG_ERROR : $text;
        $text = $text . "\n" . '----'
              . "\n" . 'brought to you by S9y.org serendipity_event_cal plugin v.' . $serendipity['plugin_eventcal_version'];


        if ($smail === true || $nolog === true) return serendipity_sendMail($to, $subject, $text, $fromEmail, null, $fromName);
        else return false;
    }

    /**
     * This should work in Outlook 2003/2007, on Exchange Server 2003 Mailboxes, Google Calendar, Google Mail, Hotmail. Tested with Thunderbird/Lightning.
     * while s9y serendipity_sendMail() function sets different headers this is a mix of origin and special eventcal needs
     */
    function sendIcalEmail($to, $ical, $headers = NULL, $fromName = NULL) {
        global $serendipity;

        $from_name    = $this->title;
        $from_address = 'eventcal_noreplay@' . $_SERVER['HTTP_HOST'];
        $subject      = 's9y@'.$_SERVER['HTTP_HOST'].' Event iCal Request'; //Doubles as email subject and meeting subject in calendar
        $env_from     = "-f ".trim($to);

        //Create Mime Boundry
        $mime_boundary = "----$subject----".md5(time());

        $message .= "This is a multi-part message in MIME format.\n\n";
        $message .= "--$mime_boundary\n";
        $message .= "Content-Type: text/plain; charset=UTF-8\n";
        $message .= "Content-Transfer-Encoding: 8bit\n\n";

        $message .= "Dear User\n\n";
        $message .= "Here is your requested iCal file / Used for Eventcal Description\n\n";
        $message .= "--$mime_boundary\n\n";

        $message .= "--$mime_boundary\n";
        $message .= "Content-Type: text/calendar; name=\"icalendar.ics\"; method=REQUEST; charset=UTF-8\n";
        $message .= "Content-Transfer-Encoding: 8bit\n\n";
        $message .= $ical."\n";
        $message .= "--$mime_boundary\n\n";

        $message .= "\n\n--{$mime_boundary}\n" .
         "Content-Type: text/calendar; method=REQUEST; name=\"icalendar.ics\"; charset=UTF-8\n" .
         "Content-Disposition: inline; filename=\"icalendar.ics\"\n" .
         "Content-Transfer-Encoding: base64\n\n" .
         chunk_split(base64_encode($ical)) . "\n\n" .
         "--{$mime_boundary}--\n";

        if (is_null($fromName) || empty($fromName)) {
            $fromName = $serendipity['blogTitle'];
        }

        if (is_null($fromMail) || empty($fromMail)) {
            $fromMail = $to;
        }

        if (is_null($headers)) {
            $headers = array();
        }

        // Fix special characters
        $fromName = str_replace(array('"', "\r", "\n"), array("'", '', ''), $from_name);
        $fromMail = str_replace(array("\r","\n"), array('', ''), $from_address);

        // Prefix all mail with weblog title
        $subject = '['. $serendipity['blogTitle'] . '] '.  $subject;

        $maildata = array(
            'to'       => &$to,
            'subject'  => &$subject,
            'fromName' => &$fromName,
            'fromMail' => &$fromMail,
            'blogMail' => $serendipity['blogMail'],
            'version'  => 'Serendipity' . ($serendipity['expose_s9y'] ? '/' . $serendipity['version'] : ''),
            'headers'  => &$headers,
            'message'  => &$message,
            'env_from' => &$env_from
        );

        // Check for mb_* function, and use it to encode headers etc. This is a s9y mail behaviour - see functions.inc.php mailfunction */
        if (function_exists('mb_encode_mimeheader')) {
            $maildata['subject'] = str_replace(array("\n", "\r"), array('', ''), mb_encode_mimeheader($maildata['subject'], LANG_CHARSET));
            $maildata['fromName'] = str_replace(array("\n", "\r"), array('', ''), mb_encode_mimeheader($maildata['fromName'], LANG_CHARSET));
        }

        // Always add these headers
        if (!empty($maildata['blogMail'])) {
            $maildata['headers'][] = 'From: "'. $maildata['fromName'] .'" <'. $maildata['blogMail'] .'>';
        }
        $maildata['headers'][] = 'Reply-To: "'. $maildata['fromName'] .'" <'. $maildata['fromMail'] .'>';
        if ($serendipity['expose_s9y']) {
            $maildata['headers'][] = 'X-Mailer: ' . $maildata['version'];
            $maildata['headers'][] = 'X-Engine: PHP/'. phpversion();
        }
        $maildata['headers'][] = 'Message-ID: <'. md5(microtime() . uniqid(time())) .'@'. $_SERVER['HTTP_HOST'] .'>';
        $maildata['headers'][] = 'MIME-Version: 1.0';
        // Precedence priority of bulk, junk, or list. These priorities will cause well-designed programs (such as the vacation reply program) to
        // skip automatically replying to such messages. Also, this prevents most email servers from returning the message if it cannot be delivered.
        $maildata['headers'][] = 'Precedence: bulk';
        $maildata['headers'][] = 'Content-Type: multipart/alternative; boundary="'.$mime_boundary.'"; charset=' . LANG_CHARSET;
        $maildata['headers'][] = 'Content-class: urn:content-classes:calendarmessage';
        // this one gave X-Amavis-Alert: BAD HEADER SECTION, Duplicate header field: "Content-Type"
        #$maildata['headers'][] = 'Content-type: text/calendar; method=REQUEST; charset=UTF-8';
        $maildata['headers'][] = 'Content-transfer-encoding: 8BIT';

        // send the email and return true / false
        if (!empty($maildata['to'])) {
            return mail($maildata['to'], $maildata['subject'], $maildata['message'], implode("\n", $maildata['headers']), $maildata['env_from']);
        }
    }

    /**
     * function draw_icalendar()
     *
     * @param the optional id of a single event
     * @param the month of ical request
     * @param the year of ical request
     * @param is adminpanel true/false
     * @return string ical data from tpl file
     */
    function draw_icalendar($id, $month, $year, $adminpanel=false) {
        global $serendipity;

        if (isset($id) && $id != 0) {

            /* build $ical_events array with one single event */
            $ical_events[0] = $this->mysql_db_result_sets('SELECT-KEY', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "id=$id"); // else return db error

        } elseif ($adminpanel === false) {

            /* build the events ical array, while this is different to the return array from function load_monthly_events() */
            $last   = $this->last_day($year,$month);         // set last day of current month
            $month  = sprintf("%02d",$month);                // make sure month is a two digit number
            $last   = $this->last_day($year,$month);         // set last day of current month
            $sel_ym = $year.$month;
            $sel_ms = $month.'01';
            $sel_ml = $month.$last;
            /* SQL WHERE STATMENT:  first     - recurring elements matching Year Month,
                                    second    - recurring elements IN BETWEEN startdate and enddate,
                                    third     - single events matching Year Month,
                                    fourth    - yearly events matching Year Month, but alternating into future */
            // better ToDO: ORDER BY HAVING tipo=2 3 4 5 1 6 which is quite difficult!
            $s = "
                (         ( ( ( DATE_FORMAT(sdato,'%Y%m') = '$sel_ym' ) OR ( DATE_FORMAT(edato,'%Y%m') = '$sel_ym') ) AND tipo BETWEEN 2 AND 5 )
                    OR     ( '$sel_ym' BETWEEN DATE_FORMAT(sdato,'%Y%m') AND DATE_FORMAT(edato,'%Y%m') AND tipo BETWEEN 2 AND 5 )
                    OR     ( sdato BETWEEN '$year-$month-01' AND '$year-$month-$last' AND tipo=1 )
                    OR     ( DATE_FORMAT(sdato,'%m%d') BETWEEN '$sel_ms' AND '$sel_ml' AND tipo=6 AND DATE_FORMAT(sdato,'%Y') <= '$year' )
                )     ORDER BY tipo ASC";
            $ical_events = $this->mysql_db_result_sets('SELECT-ARRAY-KEYS', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "approved=1 AND $s");
            // else return db error

        } else {

            $ical_events = $this->mysql_db_result_sets('SELECT-ARRAY-KEYS', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "approved=1");
            // else return db error
        }

        header("Content-Type: text/calendar; charset=UTF-8");
        #date_default_timezone_set('UTC'); // dont't use, while we have build-in default timezone override settings in ical tpl

        if (is_array($ical_events)) {
            // replace tipo with ical RFC 5545 conform BYDAY RRULE - param 4 = search in specific array key
            $mty = array('1:1', '1:2', '1:3', '1:4', '1:5', '1:6', '1:7', '2:1', '2:2', '2:3', '2:4', '2:5', '2:6', '2:7', '3:1', '3:2', '3:3', '3:4', '3:5', '3:6', '3:7', '4:1', '4:2', '4:3', '4:4', '4:5', '4:6', '4:7', '-1:1', '-1:2', '-1:3', '-1:4', '-1:5', '-1:6', '-1:7', '-2:1', '-2:2', '-2:3', '-2:4', '-2:5', '-2:6', '-2:7', '-3:1', '-3:2', '-3:3', '-3:4', '-3:5', '-3:6', '-3:7', '5:1', '5:2', '5:3', '5:4', '5:5', '5:6', '5:7');
            $ity = array('1SU', '1MO', '1TU', '1WE', '1TH', '1FR', '1SA', '2SU', '2MO', '2TU', '2WE', '2TH', '2FR', '2SA', '3SU', '3MO', '3TU', '3WE', '3TH', '3FR', '3SA', '4SU', '4MO', '4TU', '4WE', '4TH', '4FR', '4SA', '-1SU', '-1MO', '-1TU', '-1WE', '-1TH', '-1FR', '-1SA', '-2SU', '-2MO', '-2TU', '-2WE', '-2TH', '-2FR', '-2SA', '-3SU', '-3MO', '-3TU', '-3WE', '-3TH', '-3FR', '-3SA', 'SU',  'MO',  'TU',  'WE',  'TH',  'FR',  'SA' );
            $ical_events = $this->str_replace_recursive($mty, $ity, $ical_events, 'recur');

            // replace some special chars as: bbcode ---> LF '\n' to '\\n' is done in tpl with modifier replace - param 4 = search in specific array key
            $bbc = array('[b]', '[/b]', '[u]', '[/u]', '[i]', '[/i]', '[s]', '[/s]');
            $rep = array('', '', '', '', '', '', '', '');
            $ical_events = $this->str_replace_recursive($bbc, $rep, $ical_events, 'ldesc');
        }

        /**
         * generates Outlook compatible REQUEST for the ical METHOD field. The difference here is how the calendaring application will present the
         * opened file to the user. If you use REQUEST it will give them a button to Accept or Reject the event. If you use PUBLISH they will be asked
         * to save or cancel. These four ical statements seem to be required by MS Outlook:
         * CALSCALE:GREGORIAN
         * METHOD:REQUEST
         * UID: create_ical_guid() is only used, if mysql UUID() function is not available
         * DTSTAMP: YmdTHis
         */
        $ical_method =  ( $this->get_config('ical_icsurl') == 'ml' ||
                        ( $this->get_config('ical_icsurl') == 'ud' && isset($_POST['calendar']['icseptarget']) && isset($_POST['calendar']['icstomail']) )
                        ) ? 'REQUEST' : 'PUBLISH';

        $ical_mailfrom = ($mailfrom) ? $mailfrom : '';

        // Silence pedantic warnings about missing default TZ settings
        if ( function_exists("date_default_timezone_get") ) {
            $tz = @date_default_timezone_get();
            date_default_timezone_set($tz);
        }
        // ToDo: tzid server settings to get real and better timezone value in case of returning 'System/Localtime'
        if (!$tz || $tz == 'System/Localtime') {
            date_default_timezone_set('Europe/Berlin');
            $tz = 'Europe/Berlin';
        }
        $tzdaylight   = strftime('%Z');
        $tzoffsetfrom = date("O");
        // ToDo: give timezone and tzoffsetto the correct values in any cases
        $tzoffsetto   = "+0200"; //$serendipity['serverOffsetHours'] ? $serendipity['serverOffsetHours'] : "+0200";
        $tzname       = date("T");

        if (!is_object($serendipity['smarty'])) {
            serendipity_smarty_init();
        }

        $serendipity['smarty']->assign(
                array(
                        'ical_events'     => $ical_events,
                        'ical_title'      => $this->title . '@' . $_SERVER['HTTP_HOST'],
                        'ical_desc'       => 'S9y serendipity_eventcal_cal plugin v.' . $serendipity['plugin_eventcal_version'],
                        'ical_method'     => $ical_method,
                        'ical_mailf'      => $ical_mailfrom,
                        'ical_host'       => $_SERVER['HTTP_HOST'],
                        'ical_proid'      => '-//S9y@'.$_SERVER['HTTP_HOST'].'//NONSGML s9y.org '.date("Y-m-d H:i:s").' icalendar.ics//'.strtoupper($serendipity['COOKIE']['userDefLang']),
                        'ical_offset'     => $tzoffsetfrom,
                        'ical_offsetto'   => $tzoffsetto,
                        'ical_tzname'     => $tzname,
                        'ical_tzid'       => $tz,
                        'ical_dtstamp'    => date('Ymd').'T'.date('His'),
                        'ical_uid'        => $this->create_ical_guid()
                )
        );

        $icl = $this->parseTemplate('plugin_eventcal_ical.tpl');
        $icl = $this->strip_ical_data($icl, '##STARTICAL##', '##ENDICAL##'); // make sure we get rid of every serendipity html output around ical file

        return $icl;
    }

    /**
     * Draw the calendar table and switch between different views
     */
    function draw_cal(  $a, $ap, $app_by, $approved, $cd, $m, $cw, $cw_prev, $cw_next, $y, $day, $eday, $emonth, $ev, $eyear,
                        $id, $ldesc, $nm, $pcm, &$re, $recur, $recur_day, $sdato, $sday, $sdesc, $smonth,
                        $syear, $tipo, $tst, $type, $url, $which) {
        global $serendipity;

        if ($serendipity['SERVER']['eventcal_debug']) {
            $dtable = array('a'         => $a,        'ap'        => $ap,          'app_by'    => $app_by,   'approved'   => $approved,
                            'cd'        => $cd,       'm'         => $m,           'cw'        => $cw,       'cw_prev'    => $cw_prev,
                            'cw_next'   => $cw_next,  'y'         => $y,           'day'       => $day,      'eday'       => $eday,
                            'emonth'    => $emonth,   'ev'        => $ev,          'eyear'     => $eyear,    'id'         => $id,
                            'ldesc'     => $ldesc,    'nm'        => $nm,          'pcm'       => $pcm,      're'         => $re,
                            'recur'     => $recur,    'recur_day' => $recur_day,   'sdato'     => $sdato,    'sday'       => $sday,
                            'sdesc'     => $sdesc,    'smonth'    => $smonth,      'syear'     => $syear,    'tipo'       => $tipo,
                            'type'      => $type,     'url'       => $url,         'which'     => $which,    'tstamp'      => $tst);
            $serendipity['smarty']->assign('is_eventcal_cal_debug_fdc', $this->show_debug($dtable, PLUGIN_EVENTCAL_CAL));
        }

        // functions load_monthly(weekly)_events and return add form needs valid month & year values
        if ($y == 0 && $m == 0) {
            $y        = (int)date("Y");
            $m        = (int)date("m");
        } else {
            // function start_month & last_day - mktime needs (int) - be sure they are
            $m        = (int) $m;
            $y        = (int) $y;
        }

        if ($pcm == 0) $pcm = $m;

        $months       = $this->months();
        $month        = $months[$m];

        $events       = $this->load_monthly_events($y, $m);
        $pm           = $m-1;
        $nm           = $m+1;
        $py           = $ny = $y;

        if ($m == 1) {
            $pm       = 12;
            $py       = $y-1;
        } else {
            $pm       = $m-1;
        }
        if ($m == 12) {
            $nm       = 1;
            $ny       = $y+1;
        }

        if (isset($cw) && $cw != NULL) {
            $lcw = date("W", $this->first_cw($y));
            if ($cw == $lcw && $m == 1) $y = $y-1;

            // set new month and year for month end navigation in weekly view
            list($y,$m) = explode('-',date("Y-m", $this->startday_cw($cw+1, $y)));
            $y          = (int) $y;
            $m          = (int) $m;
        }

        $serendipity['smarty']->assign(
                array(
                    'plugin_eventcal_cal_preface'       => $this->get_config('showintro'),
                    'plugin_eventcal_cal_admin'         => sprintf(PLUGIN_EVENTCAL_HALLO_ADMIN, $serendipity['serendipityUser'], $serendipity['permissionLevels'][$serendipity['serendipityUserlevel']]),
                    'plugin_eventcal_cal_path'          => $this->fetchPluginUri(),
                    'plugin_eventcal_cal_imgpath'       => $serendipity['serendipityHTTPPath'] . $serendipity['eventcal']['pluginpath'],
                    'plugin_eventcal_cal_monthviewnav'  => true,
                    'plugin_eventcal_cal_a'             => $a,
                    'plugin_eventcal_cal_ap'            => $ap,
                    'plugin_eventcal_cal_pm'            => sprintf("%02d",$pm),
                    'plugin_eventcal_cal_py'            => $py,
                    'plugin_eventcal_cal_nm'            => sprintf("%02d",$nm),
                    'plugin_eventcal_cal_ny'            => $ny,
                    'plugin_eventcal_cal_m'             => sprintf("%02d",$m),
                    'plugin_eventcal_cal_y'             => $y,
                    'plugin_eventcal_cal_back'          => $months[$pm] . ' ' . $py . ' &laquo;',
                    'plugin_eventcal_cal_next'          => '&raquo; ' . $months[$nm] . ' ' . $ny,
                    'plugin_eventcal_cal_cmonth'        => $month . ' ' . $y,
                    'plugin_eventcal_cal_entry'         => array(
                                                                'timestamp' => 1 //, force captchas!
                                                            )
                )
        );

        // be sure this is not the weekly CW navigaton call, while this navigates through the existing monthly array only
        if ($cw_prev === false && $cw_next === false && $m === $pcm) {
            // void
        } else {
            if ($pcm !== $m) {
                if ($m === 1 && $pcm === 12) {
                    $m = 12;
                    $y = $y-1;
                } else
                    $m = $m-1;
            }
        }

        // by now, we have created cal debug entries and have set the navigation buttons in monthview
        // now we begin to build the calendar table as a monthly table array
        $sd = $this->draw_eventdays($a, $ap, $m, $y, $events, $cw);

        /* check for a given calendar week number */
        if (isset($cw) && $cw != NULL) {
            $sdw = $this->load_weekly_events($cw, $y, $sd);
        }

        /* if ical config setting showical is true, */
        if (serendipity_db_bool($this->get_config('showical', 'false')) && is_array($events)) {
            // set the ical buttons
            $serendipity['smarty']->assign('is_eventcal_ical', true);
            // give the chance to direct external_plugin calls in case of not ud (users decision) */
            $serendipity['smarty']->assign('plugin_eventcal_icsdl', $this->get_config('ical_icsurl'));
        }

        /* if user does not want the weekly view (sdw) - fall back to monthly view (sd) */
        if (!$sdw) {
            /* and assign the event calendar table monthview to smarty */
            $serendipity['smarty']->assign('plugin_eventcal_cal_sed', $sd);
        } else {
            /* and assign the event calendar table weekview to smarty */
            $serendipity['smarty']->assign('plugin_eventcal_cal_sedweek', $sdw);
            /* fetch the smarty weekly template file */
            $weekdata = $this->parseTemplate('plugin_eventcal_calweek.tpl');
            /* assign result to our main plugin_eventcal_cal.tpl file */
            $serendipity['smarty']->assign('plugin_eventcal_cal_buildweektable', $weekdata);
        }

        // show single event entry as choosen from event calendar underneath the event calendar table
        if ($ev) $sedata = $this->draw_event($ev,$re);
        /* get and assign the single entry data page template file */
        if (isset($sedata)) {
            $serendipity['smarty']->assign('plugin_eventcal_cal_buildsetable', $sedata);
        }

        // here we beginn to build the buttons for open form and see unapproved events
        $serendipity['smarty']->assign('is_eventcal_cal_buildbuttons', true);

        // here we beginn to build the buttons for open form and see unapproved events
        $serendipity['smarty']->assign('is_eventcal_cal_buildbuttonadd', true);

        /* if a user wants to open the event input form, call create form (draw_add) function */
        if ($a == 1) {
            $add_data = $this->draw_add( $a, $ap, $app_by, $approved, $cd, $day, $eday, $emonth, $ev, $eyear, $id, $ldesc,
                                        $m, $nm, $re, $sday, $sdesc, $smonth, $syear, $tipo, $tst, $type, $url, $which, $y );
        }

        /* assign count unapproved events to smarty */
        $count = $this->mysql_db_result_sets('SELECT-NUM', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "approved=0");
        $serendipity['smarty']->assign('plugin_eventcal_cal_crs', is_array($count) ? $count[0] : '?');
        // else return db error

        /* get and assign the add form page template file */
        if (isset($add_data)) {
            $serendipity['smarty']->assign('plugin_eventcal_cal_buildaddtable', $add_data);
        }
        // here we beginn to build the buttons for open form and see unapproved events
        $serendipity['smarty']->assign('is_eventcal_cal_buildbuttonapp', true);

        /* if user wants to see the unapproved event manager, call create app manager (draw_app) function */
        if ($ap == 1) {
            $appdata = $this->draw_app($a, $m, $y, $re, false);
        }

        /* get and assign the app page template file */
        if (isset($appdata)) {
            $serendipity['smarty']->assign('plugin_eventcal_cal_buildapptable', $appdata);
        }

        /* create administration links to logout and restructure the database */
        if (serendipity_userLoggedIn()) {
            // void;
        }

        if (is_array($months)) {
            echo $this->parseTemplate('plugin_eventcal_cal.tpl');
        }

    } /* end of draw_cal() function */


    /**
     * Draw a single event entry
     */
    function draw_event($ev, &$re, $noadmin=TRUE) {
        global $serendipity;

        if ($serendipity['SERVER']['eventcal_debug']) {
            $dtable = array('ev' => $ev, 're' => $re);
            $serendipity['smarty']->assign('is_eventcal_entry_debug_fdw', $this->show_debug($dtable, 'draw_event()'));
        }

        $event = $this->mysql_db_result_sets('SELECT-KEY', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "id=$ev"); // else return db error
        $days  = $this->days();

        /**
         * function strip array values: array, keep as name or key, show as form/preview or html page
         * @return array [$array]
         */
        $event = $this->multi_strip_array_values($event, TRUE, FALSE);

        /* here is view function of approved events entries */
        switch($event['tipo']) {
                    case 1:
                        $de_sdato = explode("-",$event['sdato']);
                        $de_sd_format = "$de_sdato[2].$de_sdato[1].$de_sdato[0]";
                        break;

                    case 2:
                        $de_sdato = explode("-",$event['sdato']);
                        $de_sd_format = "$de_sdato[2].$de_sdato[1].$de_sdato[0]";
                        $de_edato = explode("-",$event['edato']);
                        $de_ed_format = "$de_edato[2].$de_edato[1].$de_edato[0]";
                        $de_sd_format = $de_sd_format.' '.PLUGIN_EVENTCAL_TEXT_TO.' '.$de_ed_format;
                        break;

                    case 3:
                        $de_sdato = explode("-",$event['sdato']);
                        $de_sd_format = "$de_sdato[2].$de_sdato[1].$de_sdato[0]";
                        $de_edato = explode("-",$event['edato']);
                        $de_ed_format = "$de_edato[2].$de_edato[1].$de_edato[0]";
                        $de_sd_format = $de_sd_format.' '.PLUGIN_EVENTCAL_TEXT_TO.' '.$de_ed_format;
                        list($which,$day) = explode(':',$event['recur']);
                        $de_sd_format = $de_sd_format . '<br />' . PLUGIN_EVENTCAL_TEXT_EACH .' '.strtolower($re[(int)$which]).' '.$days[$day];
                        break;

                    case 4:
                        $de_sdato = explode("-",$event['sdato']);
                        $de_sd_format = "$de_sdato[2].$de_sdato[1].$de_sdato[0]";
                        $de_edato = explode("-",$event['edato']);
                        $de_ed_format = "$de_edato[2].$de_edato[1].$de_edato[0]";
                        $de_sd_format = $de_sd_format.' '.PLUGIN_EVENTCAL_TEXT_TO.' '.$de_ed_format;
                        list($which,$day) = explode(':',$event['recur']);
                        $de_sd_format = $de_sd_format . '<br />' . $re[(int)$which].' '.$days[$day];
                        break;

                    case 5:
                        $de_sdato = explode("-",$event['sdato']);
                        $de_sd_format = "$de_sdato[2].$de_sdato[1].$de_sdato[0]";
                        $de_edato = explode("-",$event['edato']);
                        $de_ed_format = "$de_edato[2].$de_edato[1].$de_edato[0]";
                        $de_sd_format = $de_sd_format.' '.PLUGIN_EVENTCAL_TEXT_TO.' '.$de_ed_format;
                        list($which,$day) = explode(':',$event['recur']);
                        $de_sd_format = $de_sd_format . '<br />' . $re[(int)$which].' '.$days[$day];
                        $de_sd_format = $de_sd_format . '<br />' . PLUGIN_EVENTCAL_TEXT_INTERVAL . ': ' . PLUGIN_EVENTCAL_TEXT_BIWEEK;
                       break;

                    case 6:
                        $de_sdato = explode("-",$event['sdato']);
                        $de_sd_format = "$de_sdato[2].$de_sdato[1].$de_sdato[0]";
                        $de_sd_format = $de_sd_format . '<br />' . PLUGIN_EVENTCAL_TEXT_INTERVAL . ': ' . PLUGIN_EVENTCAL_TEXT_YEARLY;
                        break;

        }

        // path settings frontend/backend
        if ($noadmin !== false) {
            $entry_path = $this->fetchPluginUri();
        } else $entry_path = $_SERVER['PHP_SELF'];

        /* assign single entry fulltext to smarty */
        /* long description needs to have replaced BBcode */
        $serendipity['smarty']->assign(
                array(
                    'plugin_eventcal_entry_event'    => $event,
                    'plugin_eventcal_entry_sformat'  => $de_sd_format,
                    'plugin_eventcal_entry_eformat'  => $de_ed_format,
                    'plugin_eventcal_entry_ldesc'    => ini_get('magic_quotes_gpc') ? stripslashes(nl2br($this->text_pattern_bbc($event['ldesc']))) : nl2br($this->text_pattern_bbc($event['ldesc'])),
                    'plugin_eventcal_entry_a'        => (int)$_GET['calendar']['a'],
                    'plugin_eventcal_entry_cm'       => (int)$_GET['calendar']['cm'],
                    'plugin_eventcal_entry_cy'       => (int)$_GET['calendar']['cy'],
                    'plugin_eventcal_entry_path'     => $entry_path,
                    'plugin_eventcal_entry_y'        => array('timestamp' => 1)
                )
        );

        /* get the show_single_event page template file */
        if (is_array($event) && count($event)) {
            $sedata = $this->parseTemplate('plugin_eventcal_entry.tpl');
        }
        return $sedata;

    } /* end of draw_event() function */


    /**
     * Draw the approve table view
     */
    function draw_app($a, $m, $y, &$re, $events=FALSE) {
        global $serendipity;

        // path settings frontend/backend
        if ($events === false) {
               $events  = $this->load_unapproved_events($re);
               $apppath = $this->fetchPluginUri();
        } else $apppath = $_SERVER['PHP_SELF'];

        if ($events) $events = $this->multi_strip_array_values($events, TRUE, TRUE);

        if (is_array($events) && count($events)) {
            /* long description needs to have replaced BBcode */
            $events[0]['ldesc'] = $this->text_pattern_bbc($events[0]['ldesc']);
        }

        if ($events) {
            /* assign app form array entries to smarty */
            $serendipity['smarty']->assign(
                array(
                    'plugin_eventcal_app_array_events'    => $events,
                    'plugin_eventcal_app_a'               => $a,
                    'plugin_eventcal_app_m'               => $m,
                    'plugin_eventcal_app_y'               => $y,
                    'plugin_eventcal_app_path'            => $apppath
                )
            );
        }

        /* get the add form page template file */
        if (is_array($events) && count($events)) {
            $appdata = $this->parseTemplate('plugin_eventcal_app.tpl');
        }

        return isset($appdata) ? $appdata : false;
    } /* end of draw_app() function */


    /* select field - iterate between startyear and endyear like current+3 */
    function iterate_years($sy, $ey) {
        for( $y = $sy; $y <= $ey; ++$y ) {
            $year[$y] = $y;
        }
        return $year;
    }


    /**
     * Draw the event form table view
     */
    function draw_add(  $a, $ap, $app_by, $approved, $cd, $day, $eday, $emonth, $ev, $eyear, $id, $ldesc,
                        $m, $nm, &$re, $sday, $sdesc, $smonth, $syear, $tipo, $tst, $type, $url, $which, $y, $noadmin=TRUE ) {
        global $serendipity;

        if (serendipity_db_bool($this->get_config('showcaptcha'))) {
            $serendipity['smarty']->assign('is_show_captcha', true);
        }

        /* build the select option values for month, year and recur options */
        // build startmonth
        $months = $this->months();
        $option1 = $this->display_options($months, $smonth);
        // authenticated user edits an old value, make sure start and endyear get build by old entry
        if (is_numeric($syear) && $syear > 0) { // avoid '0000'
            // build syear array -  set 1st index $syear and iterate the index via current year + 3
            $osyear = $this->iterate_years((int)$syear, (int)date("Y")+3);
        } else {
            // build year array -  set 1st index (current year) to iterate the index
            $osyear = $this->iterate_years((int)date("Y"), (int)date("Y")+2);
        }
        // build startyear
        $option2 = $this->display_options($osyear, $syear);
        // build endmonth
        $option3 = $this->display_options($months, $emonth);
        if (is_numeric($eyear) && $eyear > 0) { // avoid '0000'
            // build eyear array -  set 1st index $syear and iterate the index via current year + 3
            // give year array one more year - array_push($oyear, date("Y")+3); threw an error with last occurence 2014 => 2013
            $oeyear = $this->iterate_years((int)$eyear, (int)date("Y")+3);
        } else {
            // build year array -  set 1st index (current year) to iterate the index
            $oeyear = $this->iterate_years((int)date("Y"), (int)date("Y")+3);
        }
        // build endyear
        $option4 = $this->display_options($oeyear, $eyear);
        // build name recur
        $option5 = $this->display_options($re, $which);
        // build recurring recur_day of week
        $days = $this->days();
        $option6 = $this->display_options($days, $day);
        // build select field days for startdays and enddays - $ndays = range(0, 31); returning int
        $fdays = $this->optdays();
        $option7 = $this->display_options($fdays, $sday);
        $option8 = $this->display_options($fdays, $eday);


        // if event edit form submit throws exception, return correct tipo to form
        if (isset($type)) {
            switch ($type) {
                case 'single':   $tipo = 1; break;
                case 'multi':    $tipo = 2; break;
                case 'recur':    $tipo = 3; break;
                case 'weekly':   $tipo = 4; break;
                case 'biweekly': $tipo = 5; break;
                case 'yearly':   $tipo = 6; break;
            }
        }

        if ($serendipity['SERVER']['eventcal_debug']) {
            $dtable = array('a'         => $a,       'ap'        => $ap,          'app_by'    => $app_by,   'approved'    => $approved,
                            'cd'        => $cd,      'm'         => $m,           'cw'        => $cw,       'cw_prev'     => $cw_prev,
                            'cw_next'   => $cw_next, 'y'         => $y,           'day'       => $day,      'eday'        => $eday,
                            'emonth'    => $emonth,  'ev'        => $ev,          'eyear'     => $eyear,    'id'          => $id,
                            'ldesc'     => $ldesc,   'nm'        => $nm,          'pcm'       => $pcm,      're'          => $re,
                            'recur'     => $recur,   'recur_day' => $recur_day,   'sdato'     => $sdato,    'sday'        => $sday,
                            'sdesc'     => $sdesc,   'smonth'    => $smonth,      'syear'     => $syear,    'tipo'        => $tipo,
                            'type'      => $type,    'url'       => $url,         'which'     => $which,    'tstamp'      => $tst);
            $serendipity['smarty']->assign('is_eventcal_add_debug_fda', $this->show_debug($dtable, PLUGIN_EVENTCAL_ADD));
        }

        // path settings frontend/backend
        if ($noadmin !== false) {
               $formpath = $this->fetchPluginUri();
        } else $formpath = $_SERVER['PHP_SELF'];

        /* assign add form array entries to smarty */
        $serendipity['smarty']->assign(
                array(
                    'plugin_eventcal_add_array_opt1'    => $option1,
                    'plugin_eventcal_add_array_opt2'    => $option2,
                    'plugin_eventcal_add_array_opt3'    => $option3,
                    'plugin_eventcal_add_array_opt4'    => $option4,
                    'plugin_eventcal_add_array_opt5'    => $option5,
                    'plugin_eventcal_add_array_opt6'    => $option6,
                    'plugin_eventcal_add_array_opt7'    => $option7,
                    'plugin_eventcal_add_array_opt8'    => $option8,
                    'plugin_eventcal_add_ap'            => $ap,
                    'plugin_eventcal_add_app_by'        => $app_by,
                    'plugin_eventcal_add_cm'            => sprintf("%02d",$m),
                    'plugin_eventcal_add_cy'            => $y,
                    'plugin_eventcal_add_id'            => $id,
                    'plugin_eventcal_add_ts'            => $tst,
                    'plugin_eventcal_add_ldesc'         => ini_get('magic_quotes_gpc') ? stripslashes($ldesc) : $ldesc,
                    'plugin_eventcal_add_path'          => $formpath,
                    'plugin_eventcal_add_sdesc'         => ini_get('magic_quotes_gpc') ? stripslashes($sdesc) : $sdesc,
                    'plugin_eventcal_add_tipo1'         => (!$tipo || $tipo==1) ? 'checked="checked"' : '',
                    'plugin_eventcal_add_tipo2'         => ($tipo==2) ? 'checked="checked"' : '',
                    'plugin_eventcal_add_tipo3'         => ($tipo==3) ? 'checked="checked"' : '',
                    'plugin_eventcal_add_tipo4'         => ($tipo==4) ? 'checked="checked"' : '',
                    'plugin_eventcal_add_tipo5'         => ($tipo==5) ? 'checked="checked"' : '',
                    'plugin_eventcal_add_tipo6'         => ($tipo==6) ? 'checked="checked"' : '',
                    'plugin_eventcal_add_url'           => $url,
                    'plugin_eventcal_add_not20'         => (($serendipity['version'][0] < 2) ? true : false),
                    'S9y2'                              => (($serendipity['version'][0] < 2) ? false : true)
                )
        );


        /* get the add form page template file */
        if (is_array($months)) {
            $add_data = $this->parseTemplate('plugin_eventcal_add.tpl');
        }
        return $add_data;
    } /* end of draw_add() function */


    /**
     * $_POST validation and db INSERT / REPLACE issues
     */
    function cal_write_entries() {
        global $serendipity;

        $replace         = FALSE;
        $insert          = FALSE;
        $setopen         = FALSE;
        $showap          = FALSE;
        $validcaptcha    = FALSE;

        /**
         * function check_global_input_values()
         * change newlines to unix style, ini_get('magic_quotes_gpc') (FALSE) add addslashes, use strip_tags() and escape preps to insert into database
         * @param  array *|* $_POST
         * @return array *|* $_POST
         */
        if (is_array($_POST)) {
            $_POST = $this->check_global_input_values();
        }

        /**
         * Set global post values to specified key names
         * @param  array *|* $_POST
         * @return array *|* $$key
         */
        foreach($_POST['calendar'] as $k => $v) {
            $$k = trim($v); // do we need some more security here ????
        }

        // do some magic time voodoo for evaluating events in the past
        $tseev = @mktime(0, 0, 0, $smonth, $sday, $syear);
        $tdiff = ($_SERVER['REQUEST_TIME']-$tseev+1);
        $ddiff = $tdiff/86400; // how many days between those two dates?

        // check startday and endday is valid day of month
        $csdev = date("t", mktime(0, 0, 0, $smonth, 1, $syear));
        $cedev = date("t", mktime(0, 0, 0, $emonth, 1, $eyear));

        // do some error textfield checking
        if (isset($sdesc) && empty($sdesc) ) {
            $this->smarty_assign_error('err', CAL_EVENT_SHORTTITLE);
            $setopen    = true;
        }
        elseif (isset($ldesc) && empty($ldesc)) {
            $this->smarty_assign_error('err', CAL_EVENT_EVENTDESC);
            $setopen    = true;
        }
        elseif (isset($app_by) && empty($app_by) ) {
            $this->smarty_assign_error('err', CAL_EVENT_APPBY);
            $setopen    = true;
        }
        elseif (empty($sdesc) || empty($ldesc) || empty($app_by) ) {
            $this->smarty_assign_error('msg', CAL_EVENT_PLEASECORRECT);
            $setopen    = true;
        }
        // types are single, multi and recurring events - check startdate for all 3 of them
        elseif (!is_numeric($syear) || !is_numeric($smonth) || !is_numeric($sday)) {
            $this->smarty_assign_error('err', CAL_EVENT_START_DATE .' '. CAL_EVENT_PLEASECORRECT);
            $setopen    = true;
        }
        // do not allow events more than one month (31 days) in the past
        elseif ($ddiff > 31 && !$id) {
            $this->smarty_assign_error('err', CAL_EVENT_START_DATE_HISTORY .' '. CAL_EVENT_PLEASECORRECT);
            $setopen    = true;
        }
        elseif ($sday == '00' || $sday > 31) {
            $this->smarty_assign_error('err', sprintf(CAL_EVENT_REAL_END_DATE, $sday) .' '. CAL_EVENT_PLEASECORRECT);
            $setopen    = true;
        }
        // check if posted startmonth has number of posted startdays
        elseif ($sday > $csdev) {
            $this->smarty_assign_error('err',  sprintf(CAL_EVENT_REAL_START_DATE, $csdev) .' '. CAL_EVENT_PLEASECORRECT);
            $setopen    = true;
        }
        else { /* we don't want to cycle through $type, while there are errors */

            // did user post an url else isset NULL
            if ( (isset($url) && empty($url)) || !isset($url) ) $url = NULL;

            // did user post the timestamp value as creation date of entry
            if (isset($ts))   $tst = $ts; else $tst = NULL;

            // check multi and recur only errors
            if ($type == 'multi' || $type == 'recur' || $type == 'weekly' || $type == 'biweekly') {

                // make time for evaluation startdate > enddate
                $sd = mktime(0, 0, 1, $smonth, $sday, $syear);
                $ed = mktime(0, 0, 1, $emonth, $eday, $eyear);

                // check specific errors for multi and recurring events
                if (!is_numeric($eyear) || !is_numeric($emonth) || !is_numeric($eday)) {
                    $this->smarty_assign_error('err', sprintf(CAL_EVENT_REAL_END_DATE, $cedev) .' '. CAL_EVENT_PLEASECORRECT);
                    $setopen    = true;
                } elseif ($sd > $ed) {
                    $this->smarty_assign_error('err', sprintf(CAL_EVENT_REAL_END_DATE, $cedev) .' '. CAL_EVENT_PLEASECORRECT);
                    $setopen    = true;
                } elseif ($smonth==$emonth && $sday==$eday && $syear==$eyear) {
                    $this->smarty_assign_error('err', CAL_EVENT_IDENTICAL_DATE .' '. CAL_EVENT_PLEASECORRECT);
                    $setopen    = true;
                } elseif ($eday == '00' || $eday > 31) {
                    $this->smarty_assign_error('err', sprintf(CAL_EVENT_REAL_END_DATE, $cedev) .' '. CAL_EVENT_PLEASECORRECT);
                    $setopen    = true;
                } elseif ($eday > $cedev) {
                    // check if posted endmonth has number of posted enddays
                    $this->smarty_assign_error('err', sprintf(CAL_EVENT_REAL_END_DATE, $cedev) .' '. CAL_EVENT_PLEASECORRECT);
                    $setopen    = true;
                }

            }
            // check monthly recurring event for not allowed weekly setting
            if ($type == 'recur' && $recur == 5) {
                $this->smarty_assign_error('err', CAL_EVENT_REAL_MONTHLY_DATE .' '. CAL_EVENT_PLEASECORRECT);
                $setopen = true;
            }
            // check recur weekly only errors
            if ( ($type == 'weekly' || $type == 'biweekly') && ($recur != 5 && $recur_day != array(1,2,3,4,5,6,7))) {
                // check specific errors for recur options
                $this->smarty_assign_error('err', CAL_EVENT_WEEKLY_DATE .' '. CAL_EVENT_PLEASECORRECT);
                $setopen = true;
            }
            // check recurring errors if startday does not correspond to selected weekday - this only is necessary in ical export
            if ($type == 'recur' || $type == 'weekly' || $type == 'biweekly') {
                if (!isset($sday))      (int)$sday      = $_POST['calendar']['sday'];
                if (!isset($recur_day)) (int)$recur_day = $_POST['calendar']['recur_day'];
                $nday = strftime('%A',mktime(12,0,0,$smonth,$sday,$syear));
                $days = $this->days();
                $rday = $days[$recur_day];
                $iday = NULL;
                if ($recur == 5 && $nday == $rday) $iday = $sday;
                if (!$iday) $iday = $this->calculate_recur_validday($syear, $smonth, $sday, $recur, ($recur_day-1));
                $sday = sprintf("%02d", $sday);
                $iday = sprintf("%02d", $iday);

                if ($sday != $iday) {
                    $this->smarty_assign_error('err', CAL_EVENT_START_DATE . ' ' . sprintf(CAL_EVENT_START_RECUR, $rday, $iday) .' '. CAL_EVENT_PLEASECORRECT);
                    $setopen    = true;
                }
            }
            // is logged-in user, but validating found errors
            if ($setopen === true && serendipity_userLoggedIn()) {
                //do something to get back to the form data
                $serendipity['eventcal']['isadminid'] = true;
                $validcaptcha = true;
            }
            // last but not least captcha checking
            if (isset($eventcalform) && $validcaptcha === false) {

                if (isset($serendipity['POST']['captcha'])) {
                    if (strtolower($serendipity['POST']['captcha']) == strtolower($_SESSION['spamblock']['captcha'])) {
                        $validcaptcha = true;
                    } elseif (!serendipity_userLoggedIn()) {
                        $this->smarty_assign_error('err', CAL_EVENT_FALSECAPTCHA);
                        $setopen      = true;
                        $validcaptcha = false;
                    }
                }
                // Captcha checking - if set to FALSE in plugin_eventcal config and spamblock plugin catchas is set to no, follow db insert procedure
                if (!serendipity_db_bool($this->get_config('showcaptcha'))) {
                    if (!isset($_SESSION['spamblock']['captcha']) || !isset($serendipity['POST']['captcha']) || strtolower($serendipity['POST']['captcha']) != strtolower($_SESSION['spamblock']['captcha'])) {
                        $validcaptcha = true;
                    }
                }

                if (serendipity_userLoggedIn() && $_SESSION['serendipityAuthedUser'] === true) {
                    $validcaptcha = true;
                }
            }

            // no errors appeared - insert event data
            if ($setopen === false && $validcaptcha === true) {
                // switch tipo settings
                if ( $type == 'single' )   $tipo = 1;
                if ( $type == 'yearly' )   $tipo = 6;
                if ( $type == 'recur' )    $tipo = 3;
                if ( $type == 'weekly' )   $tipo = 4;
                if ( $type == 'biweekly' ) $tipo = 5;

                switch($type) {

                    case 'single':
                    case 'yearly':

                        if ($id) {
                            $result = $this->mysql_db_result_sets('REPLACE', $id, "$syear-$smonth-$sday", 'NULL', 'NULL', $sdesc, $url, $ldesc, $tipo, 1, $app_by, $tst, NULL);
                            if ($result) {
                                $replace = true;
                                $showap  = true;
                            }
                        } else {
                            $result = $this->mysql_db_result_sets('INSERT', 0, "$syear-$smonth-$sday", 'NULL', 'NULL', $sdesc, $url, $ldesc, $tipo, 0, $app_by, NULL, NULL);
                            if ($result) {
                                $insert  = true;
                            }
                        } // if ID end
                        break;

                    case 'multi':

                        if ($id) {
                            $result = $this->mysql_db_result_sets('REPLACE', $id, "$syear-$smonth-$sday", "$eyear-$emonth-$eday", 'NULL', $sdesc, $url, $ldesc, 2, 1, $app_by, $tst, NULL);
                            if ($result) {
                                $replace = true;
                                $showap  = true;
                            }
                        } else {
                            $result = $this->mysql_db_result_sets('INSERT', 0, "$syear-$smonth-$sday", "$eyear-$emonth-$eday", 'NULL', $sdesc, $url, $ldesc, 2, 0, $app_by, NULL, NULL);
                            if ($result) {
                                $insert  = true;
                                $showap  = true;
                            }
                        } // if ID end
                        break;

                    case 'recur':
                    case 'weekly':
                    case 'biweekly':

                        if ($id) {
                            $result = $this->mysql_db_result_sets('REPLACE', $id, "$syear-$smonth-$sday", "$eyear-$emonth-$eday", "$recur:$recur_day", $sdesc, $url, $ldesc, $tipo, 1, $app_by, $tst, NULL);
                            if ($result) {
                                $replace = true;
                                $showap  = true;
                            }
                        } else {
                            $result = $this->mysql_db_result_sets('INSERT', 0, "$syear-$smonth-$sday", "$eyear-$emonth-$eday", "$recur:$recur_day", $sdesc, $url, $ldesc, $tipo, 0, $app_by, NULL, NULL);
                            if ($result) {
                                $insert  = true;
                            }
                        } // if ID end
                        break;
                } // switch type end

                if ($replace === true && $id) {
                    $this->smarty_assign_error('msg', sprintf("REPLACE - ".PLUGIN_EVENTCAL_INSERT_DONE_BLAHBLAH, $id));
                    unset($_POST['calendar']);
                    $serendipity['eventcal']['showsev'] = array('id' => $id, 'sm' => $smonth, 'sy' => $syear);
                }

                if ($insert === true && serendipity_db_insert_id()) {
                    $this->smarty_assign_error('msg', sprintf("INSERT - ".PLUGIN_EVENTCAL_INSERT_DONE_BLAHBLAH."<br />".PLUGIN_EVENTCAL_INSERT_DONE_EVALUATE, serendipity_db_insert_id()));
                    unset($_POST['calendar']);
                }

            } // no errors end and check setopen === false
        } // else end

        // there was an error :: return back to form
        if ($setopen === true) {
            $a  = 1;
            $_POST['calendar']['a']  = 1;
            $_POST['calendar']['ldesc'] = str_replace('\n', chr(10), $ldesc); // form textarea needs changed LF
            #$_POST['calendar']['cm'] = $smonth; // should be $cm, which is already set
            #$_POST['calendar']['cy'] = $syear; // should be $cy, which is already set
            $serendipity['eventcal']['setopen'] = true;
        }
        if ($showap === true) {
            $ap  = 1;
            $_POST['calendar']['ap']  = 1;
        }

        if ($serendipity['SERVER']['eventcal_debug']) {
            $dtable = array('a'         => $a,       'ap'        => $ap,          'app_by'    => $app_by,      'approved'    => $approved,
                            'cd'        => $cd,      'cm'        => $cm,          'cy'        => $cy,          'day'         => $day,
                            'eday'      => $eday,    'emonth'    => $emonth,      'ev'        => $ev,          'eyear'       => $eyear,
                            'id'        => $id,      'isadminid' => $isadminid,   'ldesc'     => $ldesc,       'nm'          => $nm,
                            're'        => $re,      'recur'     => $recur,       'recur_day' => $recur_day,   'sdato'       => $sdato,
                            'sday'      => $sday,    'sdesc'     => $sdesc,       'smonth'    => $smonth,      'syear'       => $syear,
                            'tipo'      => $tipo,    'type'      => $type,        'url'       => $url,         'which'       => $which);
            $serendipity['smarty']->assign('is_eventcal_cal_debug_fcwe', $this->show_debug($dtable, 'cal_write_entries() - END'));
        } // debug end
    } // function cal_write_entries end


    /**
     * Administration issues and switch to validation function
     */
    function cal_admin_backend() {
        global $serendipity;

        /* calendar administration functions write content, but set approved = 0 if not re-edited by validated user */
        if (isset($_POST['calendar']['type'])) {

            // validate entries and do INSERT or REPLACE db issues
            $this->cal_write_entries();

            // authenticated, but REPLACE or INSERT error
            if (isset($serendipity['eventcal']['isadminid']) === true) {
                $isadminid = true;
                unset($serendipity['eventcal']['isadminid']);
            }
        }

        /* calendar administration functions - login, logout */
        if (isset($serendipity['GET']['adminModule']) && $serendipity['GET']['adminModule'] == 'logout') {
            serendipity_logout();
            $this->smarty_assign_error('msg', CAL_EVENT_USER_LOGGEDOFF);
        }

        // placeholder superusers old freetable validation

        /* calendar administration functions - approve and delete entries in app or single entry view */
        if (isset($_POST['calendar']['entries']) && is_array($_POST['calendar']['entries']) || isset($isadminid) === true) {

            if (!serendipity_userLoggedIn()) {
                $adminpost['ap'] = 1; // set event appform open
                $this->smarty_assign_error('err', CAL_EVENT_USER_LOGINFIRST);

            } else {
                /* authenticated user is logged-in - here we just do reject or approve an event, validate Change Submits or give back values */

                /* approve events */
                if (isset($_POST['Approve_Selected']) || isset($_POST['Approve_Selected_x']) || isset($_POST['Approve_Selected_y'])) {
                    if (is_array($_POST['calendar']['entries'])) {
                        $apid  = array();
                        foreach($_POST['calendar']['entries'] as $entry=>$val) {
                            $result = $this->mysql_db_result_sets('UPDATE', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "approved=1 WHERE id=$val");
                            $apid[] = $val;
                            $n_id  .= $val . ' ';
                        }
                        if ($result) {
                            // need help here - vsprintf does not take this array, even if used as string
                            // so I used a workaround string $n_id .= $val to assign at end
                            $this->smarty_assign_error('msg', vsprintf(PLUGIN_EVENTCAL_APPROVE_DONE_BLAHBLAH, $apid) . (count($apid) > 1 ? ' (Updated Multi-IDs: ' . $n_id . ')' : ''));
                        } // else return db error
                    }
                }

                /* reject events */
                if (isset($_POST['Reject_Selected']) || isset($_POST['Reject_Selected_x']) || isset($_POST['Reject_Selected_y'])) {
                    if (is_array($_POST['calendar']['entries'])) {
                        $idel  = array();
                        foreach($_POST['calendar']['entries'] as $entry => $val) {
                            $result = $this->mysql_db_result_sets('DELETE', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "id=$val");
                            $idel[] =  $val;
                            $n_id  .= $val . ' ';
                        }
                        if ($result) {
                            // need help here - vsprintf does not take this array, even if used as string - see above
                            $this->smarty_assign_error('msg', vsprintf(PLUGIN_EVENTCAL_REJECT_DONE_BLAHBLAH, $idel) . (count($idel) > 1 ? ' (Erased Multi-IDs: ' . $n_id . ')' : ''));
                        } // else return db error
                    }
                }

                /* an authenticated logged-in user tries to change and submit an unapproved event */
                if (isset($isadminid) === true && isset($id)) {
                    /* there was an error changing unapproved entries - get back the original entry */
                    $event = $this->mysql_db_result_sets('SELECT-KEY', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "id=$id"); // else return db error
                }
                /* an authenticated logged-in user tries to change an unapproved event via app form */
                elseif (isset($_POST['Change_Selected']) || isset($_POST['Change_Selected_x']) || isset($_POST['Change_Selected_y'])) {
                    // select a specific unapproved event - check if it is a single entry or has checked multiple checkboxes
                    if (is_array($_POST['calendar']['entries'])) {
                        $countentries = count($_POST['calendar']['entries']);
                        if ($countentries == 1) {
                            foreach($_POST['calendar']['entries'] as $entry=>$val) {
                                $event = $this->mysql_db_result_sets('SELECT-KEY', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "id=$val"); // else return db error
                            }
                            if (!is_array($event)) $adminpost['a'] = 0; // if db error close new event date form
                        } else {
                            $this->smarty_assign_error('err', CAL_EVENT_CHGSELECTED_ARRAY .' '. CAL_EVENT_PLEASECORRECT);
                            $adminpost['a']  = 0; // close new event date form
                            $adminpost['ap'] = 1; // open administrate unapproved event form
                        }
                    }
                }

                // assign edit single event entry to smarty add form - do not parse text_pattern_bbc function
                if (is_array($event)) {
                    $adminpost['a']            = 1; // open form to change single event
                    $adminpost['ap']           = 0; // close unapproved event table
                    $adminpost['id']           = $event['id'];
                    list($adminpost['syear'],
                        $adminpost['smonth'],
                        $adminpost['sday'])    = explode('-',$event['sdato']);
                    @list($adminpost['eyear'],
                        $adminpost['emonth'],
                        $adminpost['eday'])    = explode('-',$event['edato']);
                    @list($adminpost['which'],
                        $adminpost['day'])     = explode(':',$event['recur']);
                    $adminpost['sdesc']        = $event['sdesc'];
                    $adminpost['ldesc']        = $event['ldesc'];
                    $adminpost['url']          = $event['url'];
                    $adminpost['tipo']         = $event['tipo'];
                    $adminpost['approved']     = $event['approved'];
                    $adminpost['app_by']       = $event['app_by'];
                    $adminpost['tstamp']       = $event['tstamp'];

                    unset($event);
                }
            } // serendipity_userLoggedIn() = true end

        // isset calendar entries or isadminid end
        } elseif (isset($_POST) && !isset($_POST['calendar']['entries'])) {
            if ((int)isset($_POST['Approve_Selected_x']) && (int)isset($_POST['Approve_Selected_y']) ||
                (int)isset($_POST['Reject_Selected_x']) && (int)isset($_POST['Reject_Selected_y']) ||
                (int)isset($_POST['Change_Selected_x']) && (int)isset($_POST['Change_Selected_y'])) {
                $adminpost['ap'] = 1;
                if (serendipity_userLoggedIn())
                    $this->smarty_assign_error('msg', CAL_EVENT_CHECKBOXALERT);
                else
                    $this->smarty_assign_error('err', CAL_EVENT_CHECKBOXALERT);
            }
        } // elseif & isset $_POST edit, validate and delete entries end

        // do something to get back to the form data
        if (isset($adminpost) && is_array($adminpost)) {
            $serendipity['eventcal']['adminpost'] = $adminpost;
            unset($adminpost);
        }

    } //function cal_admin_backend() end


    /**
     * necessary eventcal checks and sendto the draw calendar function
     */
    function show() {
        global $serendipity;

        if ($this->selected()) {
            //if not set verify entries by Admin - show entries by default.
            #$this->set_config('issetverify', '1');

            // form the recurring event array names
            if (!isset($re) && !is_array($re)) {
                $re = array(     1    => CAL_EVENT_FORM_DAY_FIRST,
                                 2    => CAL_EVENT_FORM_DAY_SECOND,
                                 3    => CAL_EVENT_FORM_DAY_THIRD,
                                 4    => CAL_EVENT_FORM_DAY_FOURTH,
                                 5    => CAL_EVENT_FORM_DAY_EACH,
                                -1    => CAL_EVENT_FORM_DAY_LAST,
                                -2    => CAL_EVENT_FORM_DAY_SECONDLAST,
                                -3    => CAL_EVENT_FORM_DAY_THIRDLAST
                            );
            }
            if (isset($_REQUEST['calendar']['cm']))   $cm = (int)$_REQUEST['calendar']['cm'];
            if (isset($_REQUEST['calendar']['cy']))   $cy = (int)$_REQUEST['calendar']['cy'];
            if (isset($_REQUEST['calendar']['ev']))   $ev = (int)$_REQUEST['calendar']['ev'];
            if (isset($_REQUEST['calendar']['cw']))   $cw = (int)$_REQUEST['calendar']['cw'];

            if (isset($_POST['calendar']['cw_prev'])) $cw_prev = (boolean)$_POST['calendar']['cw_prev'];
            if (isset($_POST['calendar']['cw_next'])) $cw_next = (boolean)$_POST['calendar']['cw_next'];

            if ( ($cw_prev || $cw_next) == true && isset($_POST['calendar']['cm']) )
                $post_cm = (int)$_POST['calendar']['cm'];
            elseif (isset($cm)) $post_cm = (int)$cm;

            if (!isset($a)) {
               $a = !empty($_REQUEST['calendar']['a']) ? (int)$_REQUEST['calendar']['a'] : 0;
            }
            if (!isset($ap)) {
               $ap = !empty($_REQUEST['calendar']['ap']) ? (int)$_REQUEST['calendar']['ap'] : 0;
            }
            /* if a user wants to see a single entry via GET shortlink, make sure to close the add and app form tables */
            if (!empty($_GET['calendar']['a']) && !empty($_GET['calendar']['ev'])) {
                $a  = 0;
                $ap = 0;
            }

            if (!isset($_REQUEST['Submit'])) $_REQUEST['Submit'] = '';

            if ($serendipity['SERVER']['eventcal_debug']) {
                $dtable = array('a' => $a, 'ap' => $ap, 'cm' => $cm, 'cy' => $cy, 'ev' => $ev);
                $serendipity['smarty']->assign('is_eventcal_cal_debug_fs1', $this->show_debug($dtable, 'show() START'));
            }

            if (!headers_sent()) {
                header('HTTP/1.0 200');
                header('Status: 200 OK');
            }

            /* WHY Garvin should we need this here?
               templates detection that this is not a regular entry view and avoid processing entries.tpl,
               which will obviously contain serendipity_Entry_Date, etc.
            $pt = preg_replace('@[^a-z0-9]@i', '_', $this->get_config('pagetitle'));
            $serendipity['smarty']->assign('staticpage_pagetitle', $pt);
            $_ENV['staticpage_pagetitle'] = $pt; */

            if ($this->get_config('articleformat') == true) {
                $serendipity['smarty']->assign('is_eventcal_articleformat', true);
            }

            if ($this->get_config('headline') == true) {
                $serendipity['smarty']->assign(
                                            array(
                                                'is_eventcal_headline'      => true,
                                                'plugin_eventcal_permalink' => $this->fetchPluginUri(),
                                                'plugin_eventcal_headline'  => $this->get_config('headline')
                                            )
                                        );
            }
            // check rewrite status to add the right GET values :: /./eventcal.html? :: index.php?/./eventcal.html& :: index.php?serendipity[subpage]=eventcal&
            if ($serendipity['rewrite'] == 'rewrite') {
                $serendipity['smarty']->assign('eventcal_permalink_add', '?');
            } else {
                $serendipity['smarty']->assign('eventcal_permalink_add', '&amp;');
            }

            /* intercept iCal exports */
            if (serendipity_db_bool($this->get_config('showical', 'false')))  {
                /* case export ics file - set export call on "ud" (user decisions::config) and send to external_plugin hook */
                if ($this->get_config('ical_icsurl') == 'ud') {

                    $icaldl_types = array(
                        'dl'  => PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_DL,
                        'wc'  => PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_WEBCAL,
                        'ml'  => PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_MAIL
                    );

                    $serendipity['smarty']->assign(
                                            array(
                                                'is_eventcal_icalswitch'     => true,
                                                'plugin_eventcal_ical_types' => $icaldl_types,
                                                'plugin_eventcal_ical_id'    => $ev,
                                                'plugin_eventcal_ical_m'     => $cm,
                                                'plugin_eventcal_ical_y'     => $cy
                                            )
                                        );
                    #$typeofuser = true;
                }

                /* case export ics file - set the mail export call and send to external_plugin hook */
                if (!$typeofuser && isset($_POST['calendar']['icseptarget'])) {
                    if (isset($_POST['calendar']['icstomail'])) {
                        if ($this->is_valid_email($_POST['calendar']['icstomail'])) $to = $_POST['calendar']['icstomail'];
                        if (isset($to)) $url = $_POST['calendar']['icseptarget'] . $to;
                        if (isset($url)) header('Location: http://' . $_SERVER['HTTP_HOST'] . $url);
                    } else {
                        $url = $_POST['calendar']['icseptarget'];
                        if (!empty($url)) header('Location: http://' . $_SERVER['HTTP_HOST'] . $url);
                    }
                }

                /* return of mailfunction and external_plugin hook send iCal via email */
                if (!$typeofuser && isset($serendipity['GET']['mailData'])) {
                    if ($serendipity['GET']['mailData'] == 1)
                        $this->smarty_assign_error('msg', PLUGIN_EVENTCAL_SENDMAIL_BLAHBLAH);
                    else
                        $this->smarty_assign_error('err', PLUGIN_EVENTCAL_SENDMAIL_ERROR .' '. CAL_EVENT_PLEASECORRECT);
                }
            }

            /* set the serendipity_event_cal.php header - unused */
            ##$this->htmlPageHeader();

            /* check for backend administration, validating data and db input issues */
            if (isset($_POST['calendar']) || isset($serendipity['GET']['adminModule'])) {
                $this->cal_admin_backend();

                if (is_array($serendipity['eventcal']['adminpost'])) {
                    /* there is a returning admin event insert or replace error - give back the form vars of db select event array */
                    foreach($serendipity['eventcal']['adminpost'] as $k => $v) {
                        $$k = trim(stripslashes($v)); // old version without stripslashes worked with debian lenny, but not with Win/Php 5.3 - why?
                    }
                    unset($serendipity['eventcal']['adminpost']);
                }

                if (is_array($serendipity['eventcal']) && $serendipity['eventcal']['setopen'] === true) {
                    /* there is a returning admin/public event validation error - give back the form vars - backforming $type to $tipo is done in draw_app() function */
                    foreach($_POST['calendar'] as $calk => $calv) {
                        $$calk = trim(stripslashes($calv));
                    }
                    if (!isset($which)) $which = $_POST['calendar']['recur'];     // recur needs to be handled as list($which, ...) to return to form safely
                    if (!isset($day))   $day   = $_POST['calendar']['recur_day']; // recur_day needs to be handled as list(..., $day) to return to form safely
                    unset($serendipity['eventcal']['setopen']);
                }

                if (is_array($serendipity['eventcal']['showsev'])) {
                    /* event has been validated -> show newly approved single event */
                    $ev = $serendipity['eventcal']['showsev']['id'];
                    $cm = $serendipity['eventcal']['showsev']['sm'];
                    $cy = $serendipity['eventcal']['showsev']['sy'];
                    unset($serendipity['eventcal']['showsev']);
                    $a  = 0;
                    $ap = 0;
                }
            }
            /* set the single id timestamp to replace the created timestamp field with its old value */
            if (!empty($tstamp)) $tst = $tstamp;
            if (!empty($ts) && !isset($tst)) $tst = $ts;
            if (isset($_POST['calendar']['ts']) && !isset($tst)) $tst = $_POST['calendar']['ts'];

            /* Final check for date vars, to start calendar right now */
            if (!isset($cm)) $cm = (int)strftime('%m');
            if (!isset($cy)) $cy = (int)strftime('%Y');
            if (!isset($cd)) $cd = (int)strftime('%d');
            if (!isset($nm)) $nm = 1;
            if (!isset($cw)) $cw = NULL;
            if (!isset($cw_prev)) $cw_prev = false;
            if (!isset($cw_next)) $cw_next = false;

            // construct the event calendar
            $this->draw_cal($a, $ap, $app_by, $approved, $cd, $cm, $cw, $cw_prev, $cw_next, $cy, $day, $eday, $emonth, $ev, $eyear,
                            $id, $ldesc, $nm, $post_cm, $re, $recur, $recur_day, $sdato, $sday, $sdesc, $smonth,
                            $syear, $tipo, $tst, $type, $url, $which);

            /* set the serendipity_event_cal.php footer - unused */
            ##$this->htmlPageFooter();

        } // $this->selected() end
    } // show end


    /**
     * event hook:::eventcal dbtable install
     * S9y does not know about {KEY} and something like id int(8) when using id {AUTOINCREMENT} {PRIMARY} which is always int(11)
     * use hardcoded mysql for this like id int(8) NOT NULL AUTO_INCREMENT, KEY sdato (sdato),
     */
     # ALTER TABLE `s9y_eventcal` CHANGE `tstamp` `tstamp` TIMESTAMP DEFAULT 0
     # ALTER TABLE `s9y_eventcal` CHANGE `modified` `modified` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    function install() {
        global $serendipity;
        $q = "CREATE TABLE IF NOT EXISTS {$serendipity['dbPrefix']}eventcal (
                                        id {AUTOINCREMENT} {PRIMARY},
                                        sdato date,
                                        edato date,
                                        recur varchar(12),
                                        sdesc varchar(16),
                                        url varchar(128),
                                        ldesc text,
                                        tipo int(1),
                                        approved int(1),
                                        app_by varchar(16),
                                        tstamp timestamp DEFAULT 0,
                                        modified timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                        KEY sdato (sdato),
                                        KEY edato (edato)
                                    ) {UTF_8}";
        serendipity_db_schema_import($q);
    }

    function alter_db($db_config_version) {
        global $serendipity;
        if ($db_config_version == '1.0') {
                $q = "ALTER TABLE {$serendipity['dbPrefix']}eventcal ADD COLUMN tstamp TIMESTAMP DEFAULT 0";
                serendipity_db_schema_import($q);
                $q = "ALTER TABLE {$serendipity['dbPrefix']}eventcal ADD COLUMN modified TIMESTAMP ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
                serendipity_db_schema_import($q);
                return true;
        }
    }

    // dont call it uninstall(&$propbag) this is a different method! (was wrongly placed by automated replace during 2.0 dev)
    function droptable() {
        global $serendipity;

        if (isset($serendipity['eventcaldroptable']) === true) {
            $q   = "DROP TABLE IF EXISTS {$serendipity['dbPrefix']}eventcal";
            if (serendipity_db_schema_import($q)) return true;
        } else {
            $adminpath = $_SERVER['PHP_SELF'].'?serendipity[adminModule]=event_display&serendipity[adminAction]=eventcal&serendipity[eventcalcategory]=';
            echo $this->backend_eventcal_questionaire(PLUGIN_EVENTCAL_ADMIN_DROP_SURE . '<br />' . PLUGIN_EVENTCAL_ADMIN_DUMP_SELF, $adminpath, 'adevplad', 'droptable');
            return false;
        }
    }

    function selected() {
        global $serendipity;

        if (!empty($serendipity['POST']['subpage'])) {
            $serendipity['GET']['subpage'] = $serendipity['POST']['subpage'];
        }

        if ($serendipity['GET']['subpage'] == $this->get_config('pagetitle') ||
            preg_match('@^' . preg_quote($this->get_config('permalink')) . '@i', $serendipity['GET']['subpage'])) {
            return true;
        }

        return false;
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENTCAL_TITLE.' (' . $this->get_config('pagetitle') . ')';

        // fake sidebar plugin output with enabled serendipity_plugin_eventwrapper for eventcal
        if (serendipity_db_bool($this->get_config('eventwrapper', 'false'))) {

            global $serendipity;
            $y         = date("Y");
            $m         = date("m");
            $months    = $this->months();
            $monthName = $months[$m];
            $currmonth = $this->load_monthly_events($y, $m, false); // ORDERed BY tipo, sdato
            $entryURI  = '//' . $_SERVER['HTTP_HOST'] . $this->fetchPluginUri() . (($serendipity['rewrite'] == 'rewrite') ? '?' : '&') . 'calendar[cm]='.$month.'&calendar[cy]='.$year.'&amp;calendar[ev]=';

            // some content output for the eventwrapper faking sidebar plugin
            echo '
                <div class="eventcal_monthly_events">
                    <div class="eventcal_sidebar_month_title">Events '.$monthName.' '.$y.'</div>
                    <ul class="plainList">
            ';

            if (is_array($currmonth)) {
                foreach ($currmonth AS $event) {
                    echo '        <li><time>'.$event['sdato'].'</time> <a href="'. $entryURI . $event['id'].'">'.$event['sdesc']."</a></li>\n";
                }
            }
            echo "
                    </ul>
                </div>\n";
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        $serendipity['plugin_eventcal_version'] = &$bag->get('version');

        if (isset ($hooks[$event])) {
            switch ($event) {

                case 'frontend_configure':

                    /* checking if db tables exists, otherwise install them */
                    $cur = $this->get_config('version');
                    $cur = (!empty($cur) ? $cur : $this->get_config('dbversion'));
                    if ($cur == '1.0' && !$this->get_config('dbversion')) {
                        $this->alter_db($cur);
                        $this->set_config('dbversion', '1.1');
                        $this->set_config('version', ''); // unset value to cleanup
                        $this->cleanup(); // remove_plugin_value - removes empty vars only
                    } elseif ($cur == '1.1') {
                        //void
                    } else {
                        $this->install();
                        $this->set_config('dbversion', '1.1');
                    }
                    break;

                case 'external_plugin':

                    // [0]=ics_export/sql_export; [1]=id/filename; [2]=month(cm); [3]=year(cy); [4]=case: no, dl, wc, ml, ud; [5] to=email; (optional) [6] ics=all (admin string)
                    $evc['export'] = explode('/', $eventData);

                    if (is_array($evc['export']) && $evc['export'][0] == 'sql_export') {
                        $file = file_get_contents ($serendipity['serendipityPath'] . 'templates_c/eventcal/'.$evc['export'][1]);
                        echo $file;
                        header('Status: 302 Found');
                        header('Content-Type: application/octet-stream; charset=UTF-8'); // text/plain to see as file in browser
                        header('Content-Disposition: inline; filename='.$evc['export'][1]);
                    }

                    if (is_array($evc['export']) && $evc['export'][0] == 'ics_export') {
                        $adminrequest = isset($evc['export'][6]) ? true : false;
                        $icl = $this->draw_icalendar($evc['export'][1], $evc['export'][2], $evc['export'][3], $adminrequest);
                    }

                    if (isset($icl) && !empty($eventData) && $evc['export'][4] != 'no') {

                        /* set the ical url location target to s9y/uploads or reload page with sent result */
                        if ($evc['export'][4] == 'ml' && !$evc['export'][6]) {
                            $url = $_SERVER['HTTP_HOST'] . $this->fetchPluginUri() . (($serendipity['rewrite'] == 'rewrite') ? '?' : '&') . 'serendipity[mailData]=';
                        } elseif ($evc['export'][4] == 'ml' && $evc['export'][6] == 'all') {
                            $url = $_SERVER['HTTP_HOST'] . $serendipity['serendipityHTTPPath'] . 'serendipity_admin.php?serendipity[adminModule]=event_display&serendipity[adminAction]=eventcal&serendipity[eventcalcategory]=adevplad&serendipity[eventcaldbclean]=dbicalall&serendipity[mailData]=';
                        } else {
                            $url = $_SERVER['HTTP_HOST'] . $serendipity['serendipityHTTPPath'] . 'uploads/icalendar.ics';
                        }

                        /* write the ical string to ics file if not requested as download */
                        if ($evc['export'][4] != 'dl') $wcal = $this->write_file( $icl );

                        if (serendipity_db_bool($this->get_config('log_ical'))) {
                            $ym = $evc['export'][3] . '-' . sprintf("%02d", $evc['export'][2]);
                        }

                        $sendmail = $this->get_config('log_email') ? true : false;

                        switch($evc['export'][4]) {
                            /* download as file */
                            case 'dl':
                                    echo $icl;
                                    header('Status: 302 Found');
                                    header('Content-Type: text/calendar; charset=UTF-8');
                                    header("Content-Disposition: inline; filename=icalendar.ics");

                                    // Send mail to the admin if he has set log iCal requests in config to receive these mails
                                    if (serendipity_db_bool($this->get_config('log_ical'))) {
                                        $this->send_ical_log_email($this->get_config('log_email'), '', $evc['export'][5], $evc['export'][1], $ym, 'as ics download', $evc['export'][4], $sendmail);
                                    }
                                break;

                            /* send file via webcal */
                            case 'wc':
                                if (serendipity_isResponseClean($url) && $wcal === true) {

                                    // Send mail to the admin if he has set log iCal requests in config to receive these mails
                                    if (serendipity_db_bool($this->get_config('log_ical'))) {
                                        $this->send_ical_log_email($this->get_config('log_email'), '', $evc['export'][5], $evc['export'][1], $ym, 'via webcal', $evc['export'][4], $sendmail);
                                    }
                                    header('Status: 302 Found');
                                    header('Content-Type: text/calendar; charset=UTF-8');
                                    header('Location: webcal://' . $url);
                                }
                                break;

                            /* send via email and attachment */
                            case 'ml':
                                if (!empty($evc['export'][5]) && $evc['export'][5] != 'none') $to = $evc['export'][5];
                                else $to = ($this->get_config('log_email')) ? $this->get_config('log_email') : $serendipity['serendipityEmail'];

                                if (!empty($to) && $to != 'john@example.com') {
                                    //* @param   string  The validated recipient address of the mail, @param   string  The ical body part of the mail
                                    $result = $this->sendIcalEmail($to, $icl); //returns true or false

                                    // Send mail to the admin if he has set log iCal requests in config to receive these mails
                                    if (serendipity_db_bool($this->get_config('log_ical'))) {
                                        $this->send_ical_log_email($this->get_config('log_email'), '', $evc['export'][5], $evc['export'][1], $ym, 'as email', $evc['export'][4], $sendmail);
                                    }
                                }
                                if (serendipity_isResponseClean($url)) {
                                    header('Location: http://' . $url . ($result ? 1 : 2));
                                }
                                break;

                            default:
                                break;
                        }
                        exit;
                    }

                case 'genpage':

                    $args = implode('/', serendipity_getUriArguments($eventData, true));
                    if ($serendipity['rewrite'] == 'rewrite') {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $args;
                    } else {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/' . $args;
                    }

                    if (empty($serendipity['GET']['subpage'])) {
                        $serendipity['GET']['subpage'] = $nice_url;
                    }
                    break;

                case 'entry_display':

                    if ($this->selected()) {
                        if (is_array($eventData)) {
                            $eventData['clean_page'] = true; // This is important to not display an entry list!
                        } else {
                            $eventData = array('clean_page' => true);
                        }
                    }

                    // Silence pedantic warnings about missing default TZ settings
                    if ( function_exists("date_default_timezone_get") ) {
                        $tz = @date_default_timezone_get();
                        date_default_timezone_set($tz);
                    }

                    if (version_compare($serendipity['version'], '1.4', '<=')) {
                        $this->show();
                    }
                    break;

                case 'entries_header':

                    // this one really rolls up output
                    $this->show();

                    break;

                /* put here all you css stuff you need for the frontend of eventcal pages */
                case 'css':

                    if (stristr($eventData, '#eventcal_wrapper')) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        return true;
                    }

                    $tfile = serendipity_getTemplateFile('style_eventcal.css', 'serendipityPath');
                    if ($tfile) echo str_replace('{TEMPLATE_PATH}', 'templates/' . $serendipity['defaultTemplate'] . '/', @file_get_contents($tfile));

                    if (!$tfile || $tfile == 'style_eventcal.css') {
                        $tfile = dirname(__FILE__) . '/style_eventcal.css';
                        $frontend_css =  str_replace('{TEMPLATE_PATH}', $serendipity['eventcal']['pluginpath'], @file_get_contents($tfile));
                    }
                    if (!empty($frontend_css)) {
                        $this->backend_eventcal_css($eventData, $frontend_css); // append to stream
                    }
                    break;

                case 'backend_sidebar_entries':

                    // forbid entry if not admin
                    if (serendipity_userLoggedIn() && $_SESSION['serendipityAuthedUser'] === true && $_SESSION['serendipityUserlevel'] == '255') {
                        if ($serendipity['version'][0] < 2) {
                            echo "\n".'                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks">
                                    <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=eventcal">
                                    ' . PLUGIN_EVENTCAL_ADMIN_NAME .'
                                    </a>
                                  </li>'."\n";
                        }
                    }
                    break;

                case 'backend_sidebar_admin_appearance':
                    // forbid sidebar link if user is not in admin
                    if (serendipity_userLoggedIn() && $_SESSION['serendipityAuthedUser'] === true && $_SESSION['serendipityUserlevel'] == '255') {
                        if ($serendipity['version'][0] > 1) {
                            echo "\n".'                        <li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=eventcal">' . PLUGIN_EVENTCAL_ADMIN_NAME . '</a></li>'."\n";
                        }
                    }
                    break;

                case 'backend_sidebar_entries_event_display_eventcal':

                    // forbid entry if not admin
                    if (serendipity_userLoggedIn() && $_SESSION['serendipityAuthedUser'] === true && $_SESSION['serendipityUserlevel'] == '255') {
                        if (!is_object($serendipity['smarty'])) {
                            serendipity_smarty_init(); // if not set to avoid member function assign() on a non-object error, start Smarty templating
                        }

                        /* show backend administration menu */
                        $this->backend_eventcal_menu();
                    }
                    break;

                /* put here all you css stuff you need for the backend of eventcal pages */
                case 'css_backend':

                    if (stristr($eventData, '#backend_eventcal_wrapper')) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        return true;
                    }
                    $tfile = serendipity_getTemplateFile('style_eventcal_backend.css', 'serendipityPath');
                    if ($tfile) {
                        $tfilecontent = str_replace('{TEMPLATE_PATH}', 'templates/' . $serendipity['defaultTemplate'] . '/', @file_get_contents($tfile));
                    }

                    if ( (!$tfile || $tfile == 'style_eventcal_backend.css') && !$tfilecontent ) {
                        $tfile = dirname(__FILE__) . '/style_eventcal_backend.css';
                        $tfilecontent = str_replace('{TEMPLATE_PATH}', $serendipity['eventcal']['pluginpath'], @file_get_contents($tfile));
                    }

                    if ($serendipity['version'][0] > 1) {
                        $t2file = dirname(__FILE__) . '/backend_inherits.css';
                        // append eventcal Serendipity 2.0+ CSS
                        $css2 = @file_get_contents($t2file);
                    } else $css2 = '';

                    $tfilecontent = $tfilecontent . $css2;

                    // add replaced css content to the end of serendipity_admin.css
                    if (!empty($tfilecontent)) {
                        $this->backend_eventcal_css($eventData, $tfilecontent);
                    }
                    break;

                default:
                    break;

            } // switch end
        } else {
            return false;
        } // isset hooks end
    } // function event hook end


    /***************************************************
     * Backend administration functions
     **************************************************/

    /**
     * add (backend) css to serendipity(_admin).css
     */
    function backend_eventcal_css(&$eventData, &$becss) {
        $eventData .= $becss;
    }

    /**
     * function function backend_eventcal_menu()
     *
     * main admin backend function
     * switch to selected navigation parts of $serendipity['GET']['eventcalcategory']
     * parts: view, add, approve, admin panel
     *
     */
    function backend_eventcal_menu() {
        global $serendipity;

        echo "\n<div id=\"backend_eventcal_wrapper\">\n\n";

        echo '<div class="backend_eventcal_menu"><h3>'. sprintf(PLUGIN_EVENTCAL_ADMIN_NAME_MENU,  $serendipity['plugin_eventcal_version']) .'</h3></div>'."\n";

        if (!isset($serendipity['POST']['eventcaladmin'])) {
            echo '
<div class="backend_eventcal_nav">
<ul>
<li '.(@$serendipity['GET']['eventcalcategory'] == 'adevview' ? 'id="active"' : '').'><a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=eventcal&amp;serendipity[eventcalcategory]=adevview">' . (($serendipity['version'][0] < 2) ? PLUGIN_EVENTCAL_ADMIN_NAME .' - ' : '') . PLUGIN_EVENTCAL_ADMIN_VIEW.'</a></li>
<li '.(@$serendipity['GET']['eventcalcategory'] == 'adevapp' ? 'id="active"' : '').'><a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=eventcal&amp;serendipity[eventcalcategory]=adevapp">' . (($serendipity['version'][0] < 2) ? PLUGIN_EVENTCAL_ADMIN_NAME .' - ' : '') . PLUGIN_EVENTCAL_ADMIN_APP.'</a></li>
<li '.((@$serendipity['GET']['eventcalcategory'] == 'adevadd' || @$serendipity['POST']['eventcalcategory'] == 'adevadd') ? 'id="active"' : '').'><a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=eventcal&amp;serendipity[eventcalcategory]=adevadd">' . (($serendipity['version'][0] < 2) ? PLUGIN_EVENTCAL_ADMIN_NAME .' - ' : '') . PLUGIN_EVENTCAL_ADMIN_ADD.'</a></li>
<li '.(@$serendipity['GET']['eventcalcategory'] == 'adevplad' ? 'id="active"' : '').'><a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=eventcal&amp;serendipity[eventcalcategory]=adevplad">' . (($serendipity['version'][0] < 2) ? PLUGIN_EVENTCAL_ADMIN_NAME .' - ' : '') . PLUGIN_EVENTCAL_ADMIN_DBC.'</a></li>
</ul>
</div>
            '."\n";
        }

        $attention = ($serendipity['version'][0] < 2) ? '<img class="backend_attention" src="' . $serendipity['serendipityHTTPPath'] . 'templates/default/admin/img/admin_msg_note.png" alt="" /> ' : '<span class="icon icon-attention-circled" aria-hidden="true"></span> ';
        $evcat      = !empty($serendipity['GET']['eventcalcategory']) ? $serendipity['GET']['eventcalcategory'] : $serendipity['POST']['eventcalcategory'];

        /* check for REQUEST and DATE vars, validating data issues */
        $reqbuild = $this->backend_check_requests();

        switch($evcat) {

            case 'adevview':
            default:

                $url = $serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=eventcal&amp;serendipity[eventcalcategory]=adevview&serendipity[eventcalorderby]=';
                echo ($serendipity['version'][0] < 2) ?
                '<div class="backend_eventcal_head"><h2>' . PLUGIN_EVENTCAL_ADMIN_VIEW . '</h2> '
                . '<a href="'.$url.'asc">&nbsp;ASC &nbsp;&larr;</a> ' . PLUGIN_EVENTCAL_ADMIN_VIEW_DESC . '<br />'
                . '<a href="'.$url.'desc">DESC &larr;</a> ' . PLUGIN_EVENTCAL_ADMIN_ORDERBY_DESC . '</div><br />'."\n"
                :
                '<div class="backend_eventcal_head"><h2>' . PLUGIN_EVENTCAL_ADMIN_VIEW . '</h2>'
                . '  <ul>'
                . '    <li><a href="'.$url.'asc" title=" ' . PLUGIN_EVENTCAL_ADMIN_VIEW_DESC . '"><input class="input_button" name="ASC" value=" ASC &uarr; " type="button"></a></li>'
                . '    <li><a href="'.$url.'desc" title=" ' . PLUGIN_EVENTCAL_ADMIN_ORDERBY_DESC . '"><input class="input_button" name="DESC" value=" DESC &darr; " type="button"></a></li>'
                . '  </ul>'
                . '</div>'."\n";

                /* view all approved events in a table */
                $this->backend_eventcal_view($reqbuild);

                break;

            case 'adevapp':

                // catch entry form error
                if ($serendipity['eventcal']['setopen'] !== true) {
                    echo '<div class="backend_eventcal_head"><h2>' . PLUGIN_EVENTCAL_ADMIN_APP . '</h2></div><br />'."\n";
                    unset($serendipity['eventcal']['setopen']);
                } else {
                    echo '<div class="backend_eventcal_head"><h2>' . PLUGIN_EVENTCAL_ADMIN_APP . '</h2> <span class="headnote">' . PLUGIN_EVENTCAL_ADMIN_APP_DESC . '</span></div><br />'."\n";
                }

                /* view all approved events in a table */
                $this->backend_eventcal_app($reqbuild);

                break;

            case 'adevadd':

                echo '<div class="backend_eventcal_head"><h2>' . PLUGIN_EVENTCAL_ADMIN_ADD . '</h2></div><br />'."\n";

                /* check if table exists, so there is nothing to do except some insert stuff */
                if ( serendipity_db_query("SHOW TABLES LIKE '{$serendipity['dbPrefix']}eventcal'", true, 'num', false) === false ) {
                    echo '<div class="backend_eventcal_noresult backend_eventcal_dbclean_error"><p class="msg_error">' . $attention . PLUGIN_EVENTCAL_ADMIN_DBC_NIXDA_DESC . '!</p></div>';
                } else {
                    /* add event form */
                    $this->backend_eventcal_add($reqbuild);
                }
                break;

            case 'adevilog':

                echo '<div class="backend_eventcal_head"><h2>' . PLUGIN_EVENTCAL_ADMIN_LOG . '</h2></div><br />'."\n";

                $this->backend_eventcal_log();

                break;

            case 'adevplad':

                echo '<div class="backend_eventcal_head"><h2>' . PLUGIN_EVENTCAL_ADMIN_DBC . '</h2></div><br />'."\n";

                if (isset($serendipity['GET']['eventcaldbcleanfreeold']) == 1)
                    $serendipity['eventcalfreetable'] = true;
                else
                    $serendipity['eventcalfreetable'] = false;

                if (isset($serendipity['GET']['eventcaldbcleanfreeinc']) == 1)
                    $serendipity['eventcalinctable'] = true;
                else
                    $serendipity['eventcalinctable'] = false;

                if ($serendipity['dbType'] == 'mysql' || $serendipity['dbType'] == 'mysqli') {
                    $this->backend_eventcal_dbclean($reqbuild['month'], $reqbuild['year']);
                } else echo '<div class="backend_eventcal_noresult backend_eventcal_dbclean_error"><p class="msg_error">' . $attention . 'Not allowed - wrong DB type!</p></div>';

                echo "\n\n</div> <!-- // backend_eventcal_wrapper end -->\n\n";

                break;

            case 'droptable':

                $serendipity['eventcaldroptable'] = true;
                $this->droptable();

                $serendipity['GET']['eventcaldbclean'] = 'dberase';
                $this->backend_eventcal_dbclean($reqbuild['month'], $reqbuild['year']);

                break;
        }
        echo "\n\n</div> <!-- // backend_eventcal_wrapper end -->\n\n";
    }

    /**
     * function backend_eventcal_view($reqb, $add=TRUE)
     *
     * Main backend function navigation number 1
     * View approved events in database to re-edit or erase - ORDERED BY tipo
     *
     * @param  ARRAY given - request and date array
     */
    function backend_eventcal_view(&$reqb, $add=false) {
        global $serendipity;

        if (is_array($reqb)) {
            foreach($reqb as $k => $v) {
                if (!empty($v)) $$k = $v;
            }
        }

        if (isset($_POST['calendar'])) {
            $this->cal_admin_backend();
        }

        if (isset($serendipity['eventcal']['adminpost']) && is_array($serendipity['eventcal']['adminpost'])) {
            /* there is a returning admin event insert or replace error - give back the form vars of db select event array */
            foreach($serendipity['eventcal']['adminpost'] as $ak => $av) {
                $$ak = trim(stripslashes($av));
            }
            unset($serendipity['eventcal']['adminpost']);
        }

        if (is_array($serendipity['eventcal']) && $serendipity['eventcal']['setopen'] === true) {
            /* there is a returning admin/public event validation error - give back the form vars - backforming $type to $tipo is done in draw_add() function */
            foreach($_POST['calendar'] as $ck => $cv) {
                $$ck = trim(stripslashes($cv));
            }
            if (!isset($which)) $which = $_POST['calendar']['recur'];     // recur needs to be handled as list($which, ...) to return to form safely
            if (!isset($day))   $day   = $_POST['calendar']['recur_day']; // recur_day needs to be handled as list(..., $day) to return to form safely
            unset($serendipity['eventcal']['setopen']);
        }

        $count = $this->mysql_db_result_sets('SELECT-NUM', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "approved=1");

        if (is_array($count)) {
            $order  = ($serendipity['GET']['eventcalorderby'] == 'desc') ? 'tstamp DESC' : 'tipo ASC';
            $result = $this->backend_eventcal_paginator($count[0], 1, 'adevview', $order);
        }

        if (is_array($result)) {
            // replace some special chars as: bbcode ---> LF '\n' to '\\n' is done in tpl with modifier replace - param 4 = search in specific array key
            $bbc    = array('[b]', '[/b]', '[u]', '[/u]', '[i]', '[/i]', '[s]', '[/s]');
            $rep    = array('', '', '', '', '', '', '', '');
            $result = $this->str_replace_recursive($bbc, $rep, $result, 'ldesc');
        }

        $adminpath = '?serendipity[adminModule]=event_display&serendipity[adminAction]=eventcal&serendipity[eventcalcategory]=adevview';
        $attention = ($serendipity['version'][0] < 2) ? '<img class="backend_attention" src="' . $serendipity['serendipityHTTPPath'] . 'templates/default/admin/img/admin_msg_note.png" alt="" /> ' : '<span class="icon icon-attention-circled" aria-hidden="true"></span> ';

        /* assign app and add form and main tpl array entries to smarty */
        if (is_array($result)) {
            $serendipity['smarty']->assign(
                array(
                    'plugin_eventcal_cal_admin'           => sprintf(PLUGIN_EVENTCAL_HALLO_ADMIN, $serendipity['serendipityUser'], $serendipity['permissionLevels'][$serendipity['serendipityUserlevel']]),
                    'plugin_eventcal_cal_imgpath'         => $serendipity['serendipityHTTPPath'] . $serendipity['eventcal']['pluginpath'],
                    'plugin_eventcal_admin_add_path'      => $adminpath,
                    'plugin_eventcal_app_admin_tipocolor' => true,
                    'is_eventcal_cal_buildbuttons'        => true,
                    'is_eventcal_cal_buildbuttonadd'      => true,
                    'is_eventcal_cal_buildbuttonapp'      => true,
                    'is_eventcal_backend_admin_view'      => true,
                    'is_eventcal_cal_admin_clear'         => true,
                    'is_eventcal_cal_admin_noapp'         => true
                    )
            );
        }

        /* if a user wants to open the event input form, call create form (draw_add) function */
        if (!isset($ev) && isset($id)) {

            /* set the single id timestamp to replace the created timestamp field with its old value */
            if (!empty($tstamp)) $tst = $tstamp;
            if (!empty($ts) && !isset($tst)) $tst = $ts;
            if (isset($_POST['calendar']['ts']) && !isset($tst)) $tst = $_POST['calendar']['ts'];

            /* there is an id request - open form with data to re-edit an already approved event */
            $add_data = $this->draw_add( 1, 1, $app_by, $approved, $cd, $day, $eday, $emonth, $ev, $eyear, $id, $ldesc,
                                        $month, $nm, $re, $sday, $sdesc, $smonth, $syear, $tipo, $tst, $type, $url, $which, $year, false );
        }

        // show single event entry as choosen from event calendar underneath the event calendar table
        if (isset($ev)) $this->backend_eventcal_show_event($ev, $re);

        if (!isset($add_data)) {
            $add_data = '';
        }

        // placeholder old paginator action

        /* get and assign the add form page template file */
        if (isset($add_data)) {
            $serendipity['smarty']->assign('plugin_eventcal_cal_buildaddtable', $add_data);
        }

        if (is_array($result)) {
            $events  = $this->view_app_events($result, $re); // using the app form tpl for approved events
            $appdata = $this->draw_app(0, $month, $year, $re, $events);
        } else
            echo '<div class="backend_eventcal_noresult backend_eventcal_dbclean_error"><p class="msg_error">' . $attention . sprintf(PLUGIN_EVENTCAL_ADMIN_NORESULT, '') . '</p></div>';

        /* get and assign the app page template file */
        if (isset($appdata)) {
            $serendipity['smarty']->assign('plugin_eventcal_cal_buildapptable', $appdata);
        }

        if (is_array($events)) {
            echo $this->parseTemplate('plugin_eventcal_cal.tpl');
        }
    }

    /**
     * function backend_eventcal_app($reqb)
     *
     * Main backend function navigation number 2
     * Show non-approved events in database and give possibility to approve, re-edit or erase
     *
     * @param  ARRAY given - request and date array
     */
    function backend_eventcal_app(&$reqb) {
        global $serendipity;

        $showappdata = true;

        if (is_array($reqb)) {
            foreach($reqb as $k => $v) {
                if (!empty($v)) $$k = $v;
            }
        }

        if (isset($_POST['calendar']) ) {
            $this->cal_admin_backend();
        }

        if (isset($serendipity['eventcal']['adminpost']) && is_array($serendipity['eventcal']['adminpost'])) {
            /* there is a returning admin event insert or replace error - give back the form vars of db select event array */
            foreach($serendipity['eventcal']['adminpost'] as $ak => $av) {
                $$ak = trim(stripslashes($av));
            }
            unset($serendipity['eventcal']['adminpost']);
        }

        if (is_array($serendipity['eventcal']) && $serendipity['eventcal']['setopen'] === true) {
            /* there is a returning admin/public event validation error - give back the form vars - backforming $type to $tipo is done in draw_add() function */
            foreach($_POST['calendar'] as $ck => $cv) {
                $$ck = trim(stripslashes($cv));
            }
            if (!isset($which)) $which = $_POST['calendar']['recur'];     // recur needs to be handled as list($which, ...) to return to form safely
            if (!isset($day))   $day   = $_POST['calendar']['recur_day']; // recur_day needs to be handled as list(..., $day) to return to form safely
            #unset($serendipity['eventcal']['setopen']); // unset is now done in adevapp title catching entry form error
            $showappdata = false;
        }

        $count = $this->mysql_db_result_sets('SELECT-NUM', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "approved=0");

        if (is_array($count)) {
            $result = $showappdata ? $this->backend_eventcal_paginator($count[0], 0, 'adevapp', 'tstamp DESC') : array();
        }

        if (is_array($result) && !empty($result)) {
            // replace some special chars as: bbcode ---> LF '\n' to '\\n' is done in tpl with modifier replace - param 4 = search in specific array key
            $bbc    = array('[b]', '[/b]', '[u]', '[/u]', '[i]', '[/i]', '[s]', '[/s]');
            $rep    = array('', '', '', '', '', '', '', '');
            $result = $this->str_replace_recursive($bbc, $rep, $result, 'ldesc');
        }

        $adminpath  = '?serendipity[adminModule]=event_display&serendipity[adminAction]=eventcal&serendipity[eventcalcategory]=adevapp';
        $attention = ($serendipity['version'][0] < 2) ? '<img class="backend_attention" src="' . $serendipity['serendipityHTTPPath'] . 'templates/default/admin/img/admin_msg_note.png" alt="" /> ' : '<span class="icon icon-attention-circled" aria-hidden="true"></span> ';

        /* assign app and add form and main tpl array entries to smarty */
        if (is_array($result)) {
            $serendipity['smarty']->assign(
                array(
                    'plugin_eventcal_cal_admin'           => sprintf(PLUGIN_EVENTCAL_HALLO_ADMIN, $serendipity['serendipityUser'], $serendipity['permissionLevels'][$serendipity['serendipityUserlevel']]),
                    'plugin_eventcal_cal_imgpath'         => $serendipity['serendipityHTTPPath'] . $serendipity['eventcal']['pluginpath'],
                    'plugin_eventcal_admin_add_path'      => $adminpath,
                    'plugin_eventcal_app_admin_tipocolor' => true,
                    'is_eventcal_cal_buildbuttons'        => true,
                    'is_eventcal_cal_buildbuttonadd'      => true,
                    'is_eventcal_cal_buildbuttonapp'      => true,
                    'is_eventcal_backend_admin_view'      => true,
                    'is_eventcal_cal_admin_clear'         => true
                    )
            );
        }
        /* if a user wants to open the event input form, call create form (draw_add) function */
        if (!isset($ev) && isset($id)) {

            /* set the single id timestamp to replace the created timestamp field with its old value */
            if (!empty($tstamp)) $tst = $tstamp;
            if (!empty($ts) && !isset($tst)) $tst = $ts;
            if (isset($_POST['calendar']['ts']) && !isset($tst)) $tst = $_POST['calendar']['ts'];

            /* there is an id request - open form with data to re-edit an unapproved event - submit sets event to be approved */
            $add_data = $this->draw_add( 1, 1, $app_by, isset($approved), $cd, $day, $eday, $emonth, isset($ev), $eyear, $id, $ldesc,
                                        $month, isset($nm), $re, $sday, $sdesc, $smonth, $syear, $tipo, $tst, isset($type), $url, $which, $year, false );
        }

        /* get and assign the add form page template file */
        if (isset($add_data)) {
            $serendipity['smarty']->assign('plugin_eventcal_cal_buildaddtable', $add_data);
        }

        if (is_array($result)) {
            $events  = $showappdata ? $this->view_app_events($result, $re) : array();
            // if not back to form. get the approved events
            if ($showappdata) $appdata = $this->draw_app(0, $month, $year, $re, $events);
        } else
            echo '<div class="backend_eventcal_noresult backend_eventcal_dbclean_error"><p class="msg_error">' . $attention . sprintf(PLUGIN_EVENTCAL_ADMIN_NORESULT, PLUGIN_EVENTCAL_ADMIN_NORESULT_APP) . '</p></div>';

        /* get and assign the app page template file */
        if (isset($appdata)) {
            $serendipity['smarty']->assign('plugin_eventcal_cal_buildapptable', $appdata);
        }

        if (is_array($events)) {
            echo $this->parseTemplate('plugin_eventcal_cal.tpl');
        }

    }

    /**
     * function backend_eventcal_add($reqb, $add=TRUE)
     *
     * Main backend function navigation number 3
     * ADD events to database
     *
     * @param  ARRAY given - request and date array
     */
    function backend_eventcal_add(&$reqb, $add=TRUE) {
        global $serendipity;

        if (is_array($reqb)) {
            foreach($reqb as $k=>$v) {
                if (!empty($v)) $$k = $v;
            }
        }

        $adminpath  = '?serendipity[adminModule]=event_display&serendipity[adminAction]=eventcal&serendipity[eventcalcategory]=adevapp';

        if ($add) {
            /* assign add form and main tpl array entries to smarty */
            $serendipity['smarty']->assign(
                array(
                    'plugin_eventcal_cal_admin'           => sprintf(PLUGIN_EVENTCAL_HALLO_ADMIN, $serendipity['serendipityUser'], $serendipity['permissionLevels'][$serendipity['serendipityUserlevel']]),
                    'plugin_eventcal_cal_imgpath'         => $serendipity['serendipityHTTPPath'] . $serendipity['eventcal']['pluginpath'],
                    'plugin_eventcal_admin_add_path'      => $adminpath,
                    'plugin_eventcal_app_admin_tipocolor' => true,
                    'is_eventcal_cal_buildbuttons'        => true,
                    'is_eventcal_cal_buildbuttonadd'      => true,
                    'is_eventcal_cal_admin_clear'         => true
                    )
            );
        }

        $add_form = $this->draw_add( 1, 0, isset($app_by), isset($approved), $cd, isset($day), isset($eday), isset($emonth), isset($ev), isset($eyear), isset($id), isset($ldesc),
                                    $month, isset($nm), $re, isset($sday), isset($sdesc), isset($smonth), isset($syear), isset($tipo), isset($tst), isset($type), isset($url), isset($which), $year, false );

        /* get and assign the add form page template file */
        if (isset($add_form)) {
            $serendipity['smarty']->assign('plugin_eventcal_cal_buildaddtable', $add_form);
        }

        echo $this->parseTemplate('plugin_eventcal_cal.tpl');

    }

    /**
     * function backend_eventcal_log()
     *
     * view the iCal export log
     *
     */
    function backend_eventcal_log() {
        // void - see dbclean function
    }


    /**
     * read the sqldump backup directory - function scanDir() >= php5
     */
    function backend_read_backup_dir($dpath, $delpath) {
        global $serendipity;
        $dir = array_slice(scanDir($dpath), 2);
        $url = $serendipity['serendipityHTTPPath'] . 'plugin/sql_export/';
        echo '<table class="ec_export">';
        foreach ($dir as $e) {
            echo '<tr><td align="left"><a href="'.$url.$e.'">';//class="button_link state_cancel icon_link" ??
            echo $e.'</a></td> <td align="right"><a href="'.$delpath.$e.'"><input type="button" class="serendipityPrettyButton button_link state_cancel icon_link" name="erase file" value=" ' . DELETE . ' " /></a></td></tr>'."\n";
        }
        echo '</table>';
    }


    /**
     * function backend_eventcal_backup()
     * @return boolean backup true/false
     */
    function backend_eventcal_backup() {
        global $serendipity;

        set_time_limit(360);

        $date = date('Y-m-d_H-i-s');
        $directory = "eventcal";
        if (!is_dir('templates_c/' . $directory)) {
            @mkdir('templates_c/' . $directory, 0777);
        }
        $file = $serendipity['serendipityPath'] . 'templates_c/eventcal/'.$date.'_eventcal.sql';
        $fp   = fopen($file, 'w');
        if ($fp) {
            $create = serendipity_db_query("SHOW CREATE TABLE {$serendipity['dbPrefix']}eventcal", true, 'num', true);
            if (is_array($create)) {
                $create[1] .= ";";
                $tablesyntax = str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $create[1]);
                $line = str_replace("\n", "", $tablesyntax);
                fwrite($fp, $line."\n");
                if ($serendipity['dbType'] == 'mysql') {
                    $data = mysql_query("SELECT * FROM {$serendipity['dbPrefix']}eventcal");
                    $num  = mysql_num_fields($data);
                    while ($row = mysql_fetch_array($data)){
                        $line = "INSERT INTO {$serendipity['dbPrefix']}eventcal VALUES(";
                        for ($i=1; $i<=$num; $i++) {
                            $line .= "'".serendipity_db_escape_string($row[$i-1])."', ";
                        }
                        $line = substr($line,0,-2);
                        fwrite($fp, $line.");\n");
                    }
                }
                else if ($serendipity['dbType'] == 'mysqli') {
                    $data = mysqli_query($serendipity['dbConn'], "SELECT * FROM {$serendipity['dbPrefix']}eventcal");
                    $num  = mysqli_num_fields($data);
                    while ($row = mysqli_fetch_array($data, MYSQLI_NUM)){
                        $line = "INSERT INTO {$serendipity['dbPrefix']}eventcal VALUES(";
                        for ($i=1; $i<=$num; $i++) {
                            $line .= "'".serendipity_db_escape_string($row[$i-1])."', ";
                        }
                        $line = substr($line,0,-2);
                        fwrite($fp, $line.");\n");
                    }
                }
            }
            fclose($fp);
            return true;
        } else return false;
    }


    /**
     * function backend_eventcal_dbclean($cm, $cy)
     * @param current month and year
     * main backend function navigation number 4
     * plugins panel administration
     * switch into dump, insert, erase, delete, increment, ical, ilog
     *
     */
    function backend_eventcal_dbclean($cm, $cy) {
        global $serendipity;

        if (isset($serendipity['eventcaldroptable']) === true) {
            echo '<div class="backend_eventcal_head"><h2>' . PLUGIN_EVENTCAL_ADMIN_ERASE . '</h2></div><br />'."\n";
        }
        $adminpath = $_SERVER['PHP_SELF'] . '?serendipity[adminModule]=event_display&serendipity[adminAction]=eventcal&serendipity[eventcalcategory]=adevplad';
        $dbclean   = !empty($serendipity['GET']['eventcaldbclean']) ? $serendipity['GET']['eventcaldbclean'] : 'start';
        $attention = ($serendipity['version'][0] < 2) ? '<img class="backend_attention" src="' . $serendipity['serendipityHTTPPath'] . 'templates/default/admin/img/admin_msg_note.png" alt="" /> ' : '<span class="icon icon-attention-circled" aria-hidden="true"></span> ';

        echo '<div class="clearfix backend_eventcal_dbclean_title"><h4 class="backend_eventcal_inline">' . PLUGIN_EVENTCAL_ADMIN_DBC_TITLE . '</h4> <span class="backend_eventcal_right">[ <b class="eventcal_tab eventcal_tab_dim">' . PLUGIN_EVENTCAL_ADMIN_DBC_TITLE_DESC . '</b> ]</span></div>'."\n";
        echo '<div class="backend_eventcal_dbclean_menu">'."\n";
        echo '  <ul>'."\n";
        echo '    <li class="ec_dbclean" '.(@$serendipity['GET']['eventcaldbclean'] == 'dbdump' ? 'id="active"' : '').'><a href="'.$adminpath.'&serendipity[eventcaldbclean]=dbdump">'.PLUGIN_EVENTCAL_ADMIN_DBC_DUMP.'</a> <span class="backend_eventcal_right">[ <b class="eventcal_tab eventcal_tab_dim">'.PLUGIN_EVENTCAL_ADMIN_DBC_DUMP_DESC.'</b> ]</span></li>'."\n";
        echo '    <li class="ec_dbclean" '.(@$serendipity['GET']['eventcaldbclean'] == 'dbdownload' ? 'id="active"' : '').'><a href="'.$adminpath.'&serendipity[eventcaldbclean]=dbdownload">'.PLUGIN_EVENTCAL_ADMIN_DBC_DOWNLOAD.'</a> <span class="backend_eventcal_right">[ <b class="eventcal_tab eventcal_tab_dim">'.PLUGIN_EVENTCAL_ADMIN_DBC_DOWNLOAD_DESC.'</b> ]</span></li>'."\n";
        echo '    <li class="ec_dbclean" '.(@$serendipity['GET']['eventcaldbclean'] == 'dbinsert' ? 'id="active"' : '').'><a href="'.$adminpath.'&serendipity[eventcaldbclean]=dbinsert">'.PLUGIN_EVENTCAL_ADMIN_DBC_INSERT.'</a> <span class="backend_eventcal_right">[ <b class="eventcal_tab eventcal_tab_dim">'.PLUGIN_EVENTCAL_ADMIN_DBC_INSERT_DESC.'</b> ]</span></li>'."\n";
        echo '    <li class="ec_dbclean" '.(@$serendipity['GET']['eventcaldbclean'] == 'dberase' ? 'id="active"' : '').'><a href="'.$adminpath.'&serendipity[eventcaldbclean]=dberase">'.PLUGIN_EVENTCAL_ADMIN_DBC_ERASE.'</a> <span class="backend_eventcal_right">[ <b class="eventcal_tab eventcal_tab_dim">'.PLUGIN_EVENTCAL_ADMIN_DBC_ERASE_DESC.'</b> ]</span></li>'."\n";
        echo '    <li class="ec_dbclean" '.(@$serendipity['GET']['eventcaldbclean'] == 'dbdelold' ? 'id="active"' : '').'><a href="'.$adminpath.'&serendipity[eventcaldbclean]=dbdelold">'.PLUGIN_EVENTCAL_ADMIN_DBC_DELOLD.'</a> <span class="backend_eventcal_right">[ <b class="eventcal_tab eventcal_tab_dim">'.PLUGIN_EVENTCAL_ADMIN_DBC_DELOLD_DESC.'</b> ]</span></li>'."\n";
        echo '    <li class="ec_dbclean" '.(@$serendipity['GET']['eventcaldbclean'] == 'dbincrement' ? 'id="active"' : '').'><a href="'.$adminpath.'&serendipity[eventcaldbclean]=dbincrement">'.PLUGIN_EVENTCAL_ADMIN_DBC_INCREMENT.'</a> <span class="backend_eventcal_right">[ <b class="eventcal_tab eventcal_tab_dim">'.PLUGIN_EVENTCAL_ADMIN_DBC_INCREMENT_DESC.'</b> ]</span></li>'."\n";
        echo '    <li class="ec_dbclean" '.(@$serendipity['GET']['eventcaldbclean'] == 'dbicalall' ? 'id="active"' : '').'><a href="'.$adminpath.'&serendipity[eventcaldbclean]=dbicalall">'.PLUGIN_EVENTCAL_ADMIN_DBC_ICALALL.'</a> <span class="backend_eventcal_right">[ <b class="eventcal_tab eventcal_tab_dim">'.PLUGIN_EVENTCAL_ADMIN_DBC_ICALALL_DESC.'</b> ]</span></li>'."\n";
        echo '    <li class="ec_dbclean" '.(@$serendipity['GET']['eventcaldbclean'] == 'dbicallog' ? 'id="active"' : '').'><a href="'.$adminpath.'&serendipity[eventcaldbclean]=dbicallog">'.PLUGIN_EVENTCAL_ADMIN_DBC_ILOG.'</a> <span class="backend_eventcal_right">[ <b class="eventcal_tab eventcal_tab_dim">'.PLUGIN_EVENTCAL_ADMIN_DBC_ILOG_DESC.'</b> ]</span></li>'."\n";
        echo '  </ul>'."\n";
        echo '</div>'."\n";

        if (isset($serendipity['eventcal']['ilogerror']) === true) echo '<div class="backend_eventcal_noresult backend_eventcal_dbclean_error"><p class="msg_error">' . $attention . PLUGIN_EVENTCAL_ADMIN_LOG_ERROR . '</p></div>';

        /* check if table exists, so there is nothing to do except some insert stuff SHOW TABLE STATUS LIKE 'tabellenname' SHOW TABLES LIKE 'tabellenname'*/
        if ( (serendipity_db_query("SHOW TABLES LIKE '{$serendipity['dbPrefix']}eventcal'", true, 'num', false) === false) && $dbclean != 'dbinsert' && $dbclean != 'dbicallog' ) $dbclean = 'dbnixda';

        if (!empty($dbclean)) {
            switch($dbclean) {
                case 'dbdump':
                    if ($serendipity['dbType'] == 'mysql' || $serendipity['dbType'] == 'mysqli') {
                        if ($this->backend_eventcal_backup()) {
                            echo '<div class="backend_eventcal_dbclean_innercat ec_inner_title"><h3>' . strtoupper(PLUGIN_EVENTCAL_ADMIN_DBC_DUMP_TITLE) . '</h3></div>'."\n";
                            $url = $_SERVER['HTTP_HOST'] . $adminpath.'&serendipity[eventcaldbclean]=dbdownload&serendipity[eventcalshowdownloads]=dump';
                            if (serendipity_isResponseClean($url)) {
                                header('Location: http://' . $url);
                            }
                        } else {
                            echo $this->backend_eventcal_smsg() . PLUGIN_EVENTCAL_ADMIN_DBC_DUMP_MSG . $this->backend_eventcal_emsg();
                        }
                    } else {
                        echo '<div class="backend_eventcal_noresult backend_eventcal_dbclean_error"><p class="msg_error">' . $attention . 'Not allowed - wrong DB type!</p></div>';
                    }
                    break;

                case 'dbdownload':

                    echo '<div class="backend_eventcal_dbclean_innercat ec_inner_title"><h3>' . strtoupper(PLUGIN_EVENTCAL_ADMIN_DBC_DUMP_TITLE) . '</h3></div>'."\n";
                    if (@$serendipity['GET']['eventcalshowdownloads'] == 'dump')
                        echo '<div class="backend_eventcal_dbclean_error"><p class="msg_success">' . $attention . PLUGIN_EVENTCAL_ADMIN_DBC_DUMP_DONE . "</p></div>\n";

                    if (is_dir('templates_c/eventcal')) {
                        echo "<div class='backend_eventcal_dbclean_innertitle'>templates_c/eventcal/ <b><u>backup files</u></b></div>\n";
                        echo "<div class='backend_eventcal_dbclean_object'>\n";
                        $this->backend_read_backup_dir('templates_c/eventcal/', $adminpath.'&serendipity[eventcaldbclean]=dbdelfile&serendipity[eventcaldbcleanfilename]=');
                        echo "</div>\n";
                    } else {
                        echo '<div class="backend_eventcal_dbclean_error"><p class="msg_error">' . $attention . PLUGIN_EVENTCAL_ADMIN_DBC_DOWNLOAD_MSG . "</p></div>\n";
                    }
                    break;

                case 'dbinsert':
                    echo '<div class="backend_eventcal_dbclean_innercat ec_inner_title"><h3>' . strtoupper(PLUGIN_EVENTCAL_ADMIN_DBC_INSERT_TITLE) . '</h3></div>'."\n";
                    echo $this->backend_eventcal_smsg() . '<span class="msg_hint"><span class="icon-help-circled" aria-hidden="true"></span> ' . PLUGIN_EVENTCAL_ADMIN_DBC_INSERT_MSG . '</span>' . $this->backend_eventcal_emsg();

                    break;

                case 'dberase':

                    echo '<div class="backend_eventcal_dbclean_innercat ec_inner_title"><h3>' . strtoupper(PLUGIN_EVENTCAL_ADMIN_DBC_ERASE_TITLE) . '</h3></div>'."\n";

                    $isTable =  $this->droptable() ? true : false; // ok, questionaire

                    // give back ok
                    if (isset($serendipity['eventcaldroptable']) === true && $isTable) {
                        echo '<div class="serendipity_center eventcal_tpl_message">'."\n";
                        echo '    <div class="serendipity_center serendipity_msg_notice">'."\n";
                        echo '        <div class="eventcal_tpl_message_inner">'."\n";
                        echo sprintf(PLUGIN_EVENTCAL_ADMIN_DROP_OK, $serendipity['dbPrefix'].'eventcal');
                        echo '        </div>'."\n";
                        echo '    </div>'."\n";
                        echo '</div>'."\n";
                    }
                    break;

                case 'dbdelold':

                    echo '<div class="backend_eventcal_dbclean_innercat ec_inner_title"><h3>' . strtoupper(PLUGIN_EVENTCAL_ADMIN_DBC_DELOLD_TITLE) . '</h3></div>';

                    if ($serendipity['eventcalfreetable'] === false) {
                        echo $this->backend_eventcal_questionaire(PLUGIN_EVENTCAL_ADMIN_FREE_SURE, $adminpath, '', '&serendipity[eventcaldbclean]=dbdelold&serendipity[eventcaldbcleanfreeold]=1');
                    } else {
                        $dnum = $this->backend_eventcal_free_record();
                        // give back ok else noresult
                        if ($dnum) {
                            echo '<div class="serendipity_center eventcal_tpl_message">'."\n";
                            echo '    <div class="serendipity_center serendipity_msg_notice">'."\n";
                            echo '        <div class="eventcal_tpl_message_inner">'."\n";
                            echo sprintf(PLUGIN_EVENTCAL_ADMIN_DBC_DELOLD_MSG, $dnum);
                            echo '        </div>'."\n";
                            echo '    </div>'."\n";
                            echo '</div>'."\n";
                        } else {
                            echo '<div class="backend_eventcal_dbclean_error"><p class="msg_error">' . $attention . sprintf(PLUGIN_EVENTCAL_ADMIN_NORESULT, PLUGIN_EVENTCAL_ADMIN_NORESULT_FREE) . '</p></div>';
                        }
                    }
                    break;

                case 'dbincrement':

                    echo '<div class="backend_eventcal_dbclean_innercat ec_inner_title"><h3>' . strtoupper(PLUGIN_EVENTCAL_ADMIN_DBC_INCREMENT_TITLE) . '</h3></div>';

                    if ($serendipity['eventcalinctable'] === false) {
                        echo $this->backend_eventcal_questionaire(PLUGIN_EVENTCAL_ADMIN_CLEAN_SURE . '<br />' . PLUGIN_EVENTCAL_ADMIN_CLEAN_SURE_ADD, $adminpath, '', '&serendipity[eventcaldbclean]=dbincrement&serendipity[eventcaldbcleanfreeinc]=1');
                    } else {
                        $srec = $this->backend_eventcal_free_record();
                        // give back ok else noresult
                        if ($srec) {
                            echo '<div class="serendipity_center eventcal_tpl_message">'."\n";
                            echo '    <div class="serendipity_center serendipity_msg_notice">'."\n";
                            echo '        <div class="eventcal_tpl_message_inner">'."\n";
                            echo sprintf(PLUGIN_EVENTCAL_ADMIN_DBC_INCREMENT_MSG, $srec);
                            echo '        </div>'."\n";
                            echo '    </div>'."\n";
                            echo '</div>'."\n";
                        } else {
                            echo '<div class="backend_eventcal_dbclean_error ec_inner_title"><p class="msg_error">' . $attention . sprintf(PLUGIN_EVENTCAL_ADMIN_NORESULT, PLUGIN_EVENTCAL_ADMIN_NORESULT_FREE) . '</p></div>';
                        }
                    }
                    break;

                case 'dbicalall':

                    echo '<div class="backend_eventcal_dbclean_innercat ec_inner_title"><h3>' . strtoupper(PLUGIN_EVENTCAL_ADMIN_DBC_ICALALL_TITLE) . '</h3></div>';

                    /* return of mailfunction and external_plugin hook send iCal via email */
                    if (isset($serendipity['GET']['mailData'])) {
                        if ($serendipity['GET']['mailData'] == 1) {
                            echo $this->backend_eventcal_smsg() . PLUGIN_EVENTCAL_SENDMAIL_BLAHBLAH . $this->backend_eventcal_emsg();
                        } else {
                            echo $this->backend_eventcal_smsg() . PLUGIN_EVENTCAL_SENDMAIL_ERROR .' '. CAL_EVENT_PLEASECORRECT . $this->backend_eventcal_emsg();
                        }
                    }

                    // create external plugin does and donts
                    if (!isset($serendipity['GET']['mailData'])) {
                        if ($this->get_config('log_email')) {
                            //we use $serendipity['serendipityHTTPPath'] like /http_root better than $serendipity['baseURL'] like http://hostname/... while this gets done somewhere else and depends on differences where to sent
                            $url = $serendipity['serendipityHTTPPath'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/ics_export/0/0/0/ml/' . $this->get_config('log_email') . '/all';
                            echo $this->backend_eventcal_smsg() . PLUGIN_EVENTCAL_ADMIN_ICAL_EMAILLINK . '<br /><br /><a href="'.$url.'"><input type="button" class="serendipityPrettyButton input_button" name="ical email" value=" ' . CAL_EVENT_FORM_BUTTON_SUBMIT . ' " /></a>' . $this->backend_eventcal_emsg();
                        } else {
                            $url = $serendipity['serendipityHTTPPath'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/ics_export/0/0/0/dl/none/all';
                            echo $this->backend_eventcal_smsg();
                            echo '<p class="msg_hint"><span class="icon-help-circled" aria-hidden="true"></span> ' . PLUGIN_EVENTCAL_ADMIN_ICAL_DOWNLINK . "</p>\n";
                            echo '<form name="checkform" method="post" action="'.$this->fetchPluginUri().'">';
                            echo '<input type="hidden" name="calendar[icseptarget]" value="'.$url.'" />';
                            echo '<input type="submit" class="serendipityPrettyButton input_button" name="ical download" value=" ' . CAL_EVENT_FORM_BUTTON_SUBMIT . ' " />';
                            echo '</form>';
                            echo $this->backend_eventcal_emsg();
                        }
                    }
                    break;

                case 'dbicallog':

                    echo '<div class="backend_eventcal_dbclean_innercat ec_inner_title"><h3>' . strtoupper(PLUGIN_EVENTCAL_ADMIN_DBC_ILOG_TITLE) . '</h3></div>';

                    if (file_exists('templates_c/eventcal/ical.log')) {

                        echo '<div class="backend_eventcal_dbclean_innertitle">ical.log - ' . date('Y-m-d H:i:s') . '</div>';
                        echo '<div class="backend_eventcal_dbclean_object">';
                        $this->backend_eventcal_highlight_num('templates_c/eventcal/ical.log');
                        echo '</div>';

                    } else {
                        echo '<div class="backend_eventcal_dbclean_error"><p class="msg_error">' . $attention . PLUGIN_EVENTCAL_ADMIN_DBC_ILOG_MSG . '</p></div>';
                    }
                    break;

                case 'dbdelfile':

                    $delfile = false;
                    if (isset($serendipity['GET']['eventcaldbcleanfilename'])) {
                            $old = getcwd(); // Save the current directory
                            chdir('templates_c/eventcal/');
                            if (is_file($serendipity['GET']['eventcaldbcleanfilename'])) {
                                unlink($serendipity['GET']['eventcaldbcleanfilename']);
                            }
                            chdir($old); // Restore the old working directory
                            echo '<div class="backend_eventcal_dbclean_error"><p class="msg_success">' . $attention . sprintf(PLUGIN_EVENTCAL_ADMIN_DBC_DELFILE_MSG, $serendipity['GET']['eventcaldbcleanfilename']) . '!</p></div>';
                    }
                    break;

                case 'dbnixda':

                    echo '<div class="backend_eventcal_dbclean_innercat ec_inner_title"><h3>' . strtoupper(PLUGIN_EVENTCAL_ADMIN_DBC_NIXDA_TITLE) . '</h3></div>';
                    echo '<div class="backend_eventcal_dbclean_error"><p class="msg_error">' . $attention . PLUGIN_EVENTCAL_ADMIN_DBC_NIXDA_DESC . '!</p></div>';

                    break;

                default:
                    break;

            }
        }
    }


    /**
     *
     * @param string filename
     * @return string
     */
    function backend_eventcal_highlight_num($file) {
        $lines   = implode(range(1, count(file($file))), '<br />');
        $content = highlight_file($file, true);

        echo "<table width='100%' height='200px'>\n";
        echo "  <tr class='backend_eventcal_line'>\n";
        echo "    <td class='backend_eventcal_linenum'>\n$lines\n</td>\n";
        echo "    <td class='backend_eventcal_linetxt'>\n$content\n</td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
    }


    /**
     *
     * check REQUEST & current date vars
     *
     * @return array
     */
    function backend_check_requests() {
        global $serendipity;
        // form the recurring event array names
        if (!isset($re) && !is_array($re)) {
            $re = array(     1    => CAL_EVENT_FORM_DAY_FIRST,
                             2    => CAL_EVENT_FORM_DAY_SECOND,
                             3    => CAL_EVENT_FORM_DAY_THIRD,
                             4    => CAL_EVENT_FORM_DAY_FOURTH,
                             5    => CAL_EVENT_FORM_DAY_EACH,
                            -1    => CAL_EVENT_FORM_DAY_LAST,
                            -2    => CAL_EVENT_FORM_DAY_SECONDLAST,
                            -3    => CAL_EVENT_FORM_DAY_THIRDLAST
                    );
        }
        $year  = date('Y');
        $month = date('m');
        $month = sprintf("%02d",$month);                // make sure month is a two digit number

        /* check for backend administration, validating data and db input issues */
        if (isset($_REQUEST['calendar']['cm']))   $cm = (int)$_REQUEST['calendar']['cm'];
        if (isset($_REQUEST['calendar']['cy']))   $cy = (int)$_REQUEST['calendar']['cy'];
        if (isset($_REQUEST['calendar']['ev']))   $ev = (int)$_REQUEST['calendar']['ev'];
        if (!isset($_REQUEST['Submit'])) $_REQUEST['Submit'] = '';

        if (isset($serendipity['eventcal']['showsev']) && is_array($serendipity['eventcal']['showsev'])) {
            /* event has been validated -> show newly approved single event */
            $ev = $serendipity['eventcal']['showsev']['id'];
            $cm = $serendipity['eventcal']['showsev']['sm'];
            $cy = $serendipity['eventcal']['showsev']['sy'];
            unset($serendipity['eventcal']['showsev']);
        }

        /* Final check for date vars, to start calendar right now */
        if (!isset($cm)) $cm = (int)strftime('%m');
        if (!isset($cy)) $cy = (int)strftime('%Y');
        if (!isset($cd)) $cd = (int)strftime('%d');
        if (!isset($ev)) $ev = false;

        $req = array('re' => $re, 'year' => $year, 'month' => $month, 'cm' => $cm, 'cy' => $cy, 'ev' => $ev, 'cd' => $cd);
        return $req;
    }

    /**
     *
     * @param  string text   - the question text string
     * @param  string url    - the url string to pass
     * @param  string addno  - the add to url string in case of no proceed
     * @param  string addyes - the add to url string in case of YES
     * @return string
     */
    function backend_eventcal_questionaire($text, $url, $addno, $addyes) {
        global $serendipity;

        return $str = $this->backend_eventcal_smsg() . '<span class="msg_hint"><span class="icon-help-circled" aria-hidden="true"></span> ' . $text . '</span>
        <div class="form_buttons">
            <a href="'.$url.$addno.'" class="serendipityPrettyButton button_link state_cancel icon_link">' . NOT_REALLY . '</a>
            <a href="'.$url.$addyes.'" class="serendipityPrettyButton button_link state_submit icon_link">' . DUMP_IT . '</a>
        </div>' . $this->backend_eventcal_emsg();
    }

    /**
     *
     * @return string start html
     */
    function backend_eventcal_smsg() {
        return $str = "<div class='serendipity_center eventcal_tpl_message'>\n    <div class='eventcal_tpl_message_inner'>\n";
    }

    /**
     *
     * @return string end html
     */
    function backend_eventcal_emsg() {
        return $str = "   </div>\n</div>\n";
    }

    /**
     *
     * @param  boolean $ev = a return event id
     * @param  array   $re = recurring day array
     *
     * @return single event data array
     */
    function backend_eventcal_show_event($ev, &$re, $add=TRUE) {
        global $serendipity;

        $adminpath = '?serendipity[adminModule]=event_display&serendipity[adminAction]=eventcal&serendipity[eventcalcategory]=adevview';

        if ($add) {
            /* assign add form and main tpl array entries to smarty */
            $serendipity['smarty']->assign(
                array(
                    'plugin_eventcal_cal_admin'           => sprintf(PLUGIN_EVENTCAL_HALLO_ADMIN, $serendipity['serendipityUser'], $serendipity['permissionLevels'][$serendipity['serendipityUserlevel']]),
                    'plugin_eventcal_cal_path'            => $this->fetchPluginUri(),
                    'plugin_eventcal_cal_imgpath'         => $serendipity['serendipityHTTPPath'] . $serendipity['eventcal']['pluginpath'],
                    'plugin_eventcal_admin_add_path'      => $adminpath,
                    'is_eventcal_cal_admin_clear'         => true
                    )
            );
        }

        $sedata = $this->draw_event($ev,$re);

        /* get and assign the single entry data page template file */
        if (isset($sedata)) {
            $serendipity['smarty']->assign('plugin_eventcal_cal_buildsetable', $sedata);
            return $sedata;
        }

    }

    /**
     * @param string to write to log file
     * @param string file full path
     * @param string filename
     * @param string filepath from serendipity root
     * @param string mode fopen to write/create, attempt pointer to start 'w', pointer to end 'a' add + if including reading
     *
     * @return boolean
     */
    function backend_file_write($content, $ffpath, $fname, $fpath, $mode) {

        if (!is_writable($ffpath)) @chmod($ffpath, 0750);

        if (!$handle = fopen($ffpath, $mode) ) return false;
        #if (!$handle = fopen($fpath.$fname, $mode) ) return false;
        #if (false === ($handle = (fopen($ffpath, $mode) || fopen($fpath.$fname, $mode)))) return false;

        if (!fwrite($handle, $content)) { fclose($handle); return false; }

        fclose($handle);
        return true;
    }

    /**
     * @param  $c   = count entries
     * @param  $ap  = approved yes/no = 1/0
     * @param  $cat = serendipity[eventcalcategory]
     *
     * @return result array
     */
    function backend_eventcal_paginator($c, $ap, $cat, $orderby) {
        global $serendipity;

        if (isset($serendipity['GET']['eventcallimit'])) {
            $paginator = $serendipity['GET']['eventcallimit'];
        } else {
            $paginator = 1;
        }
        $rows_per_page = 15;
        $lastpage      = ceil($c/$rows_per_page);

        $paginator = (int)$paginator;
        if ($paginator > $lastpage) {
            $paginator = $lastpage;
        }
        if ($paginator < 1) {
            $paginator = 1;
        }
        $limit  = 'LIMIT ' .($paginator - 1) * $rows_per_page .',' .$rows_per_page;
        $result = $this->mysql_db_result_sets('SELECT-ARRAY', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "approved=$ap ORDER BY $orderby $limit");
        // else return db error
        $pagoby = ($serendipity['GET']['eventcalorderby'] == 'desc') ? '&amp;serendipity[eventcalorderby]=desc' : '';

        if (is_array($result)) {
            echo "\n";
            echo '<div class="backend_eventcal_paginator">';

            if ($paginator == 1) {
                echo '<span class="backend_eventcal_paginator_left"> FIRST | PREVIOUS </span>'."\n";
            } else {
                $prevpage = $paginator-1;
                echo '<span class="backend_eventcal_paginator_left">';
                echo ' <a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=eventcal&amp;serendipity[eventcalcategory]='.$cat.'&amp;serendipity[eventcallimit]=1'.$pagoby.'"><input type="button" class="serendipityPrettyButton input_button" name="FIRST" value=" &laquo;&laquo; FIRST " /></a> | '."\n";
                echo ' <a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=eventcal&amp;serendipity[eventcalcategory]='.$cat.'&amp;serendipity[eventcallimit]='.$prevpage.$pagoby.'"><input type="button" class="serendipityPrettyButton input_button" name="PREVIOUS" value=" &laquo; PREVIOUS " /></a> '."\n";
                echo '</span>';
            }

            echo '<span class="backend_eventcal_paginator_center">  ( Page '.$paginator.' of '.$lastpage.' ) </span>'."\n";

            if ($paginator == $lastpage) {
                echo '<span class="backend_eventcal_paginator_right"> NEXT | LAST </span>'."\n";
            } else {
                $nextpage = $paginator+1;
                echo '<span class="backend_eventcal_paginator_right">';
                echo ' <a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=eventcal&amp;serendipity[eventcalcategory]='.$cat.'&amp;serendipity[eventcallimit]='.$nextpage.$pagoby.'"><input type="button" class="serendipityPrettyButton input_button" name="NEXT" value=" NEXT &raquo; " /></a> | '."\n";
                echo ' <a href="'.$serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=eventcal&amp;serendipity[eventcalcategory]='.$cat.'&amp;serendipity[eventcallimit]='.$lastpage.$pagoby.'"><input type="button" class="serendipityPrettyButton input_button" name="LAST" value=" LAST &raquo;&raquo; " /></a> '."\n";
                echo '</span>';
            }

            echo '</div>';
            echo "\n";
        }
        if (is_array($result)) {
            return $result;
        }
    } // function backend paginator end

    /**
     * function backend_eventcal_free_record()
     *
     * SQL Query Result Set: free old eventcal record and set autoincrement id back
     * (you don't really need this...., but I like this little routine ;-))
     *
     * @param  global variable
     * @return array []
     * @access admin only
     */
    function backend_eventcal_free_record() {
        global $serendipity;

        // case free old data
        if ($serendipity['eventcalfreetable'] === true) {

            // LOCK the table - but you need LOCK privileges!
            @serendipity_db_query("LOCK TABLES {$serendipity['dbPrefix']}eventcal WRITE");

            $sql = "SELECT id, DATE_FORMAT(sdato, '%Y-%m-%d') AS sdate, DATE_FORMAT(edato, '%Y-%m-%d') AS edate FROM {$serendipity['dbPrefix']}eventcal";
            $id_date = serendipity_db_query($sql);

            $olddate = date("Y-m-d",time()-2592000); // 30 days = hours(3600) * 24 * 30 days

            if (is_array($id_date)) {
                foreach ($id_date AS $key => $val) {
                    if ($val['edate'] == NULL || $val['edate'] == '' || $val['edate'] == '0000-00-00') {
                        if ($val['sdate'] < $olddate) {
                        $result = $this->mysql_db_result_sets('DELETE', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "id={$val['id']}");
                            $counter[] = $id;
                        } else $result = array();
                    } else {
                        if ($val['edate'] < $olddate) {
                            $result = $this->mysql_db_result_sets('DELETE', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "id={$val['id']}");
                            $counter[] = $id;
                        } else $result = array();
                    }
                }
                $cdelnum = count($counter);
            }
            // unlock tables
            @serendipity_db_query('UNLOCK TABLES');

            return isset($cdelnum) ? $cdelnum : false;

        }

        // case set autoincrement values
        if ($serendipity['eventcalinctable'] === true) {

            // LOCK the table - but you need LOCK privileges!
            @serendipity_db_query("LOCK TABLES {$serendipity['dbPrefix']}eventcal WRITE");

            // cycle through data and rewrite auto_increment field 'ID'
            $sql = "SELECT id, sdato, tstamp FROM {$serendipity['dbPrefix']}eventcal ORDER BY id DESC";
            $res = serendipity_db_query($sql);

            if ($res[0]['id'] == count($res)) {
                // unlock tables
                @serendipity_db_query('UNLOCK TABLES');
                return false;
            }

            $c = 0;
            if ($res || is_array($res)) {
                $c = count($res);
                $i = 1;
                asort($res); // sort eventcal table reverse or try with ORDER BY id ASC
                foreach ($res AS $key => $val) {
                    /* we need to set date field, while the UPDATE function inserts a new timestamp */
                    $sql = "UPDATE LOW_PRIORITY {$serendipity['dbPrefix']}eventcal SET id='".$i."', sdato='".$val['sdato']."', tstamp='".$val['tstamp']."' WHERE id='".$val['id']."'";
                    $i = $i+1;
                    $usql[] = $sql;
                }
                for($k=0; $k<$i; $k++) {
                    if ($usql[$k] !== NULL) {
                        $result = serendipity_db_query($usql[$k]);
                    }
                }
                if ($result) $numresult = count($usql);
            }

            /* sets the old auto_increment value to the new value of count +1 - Do not use ALTER TABLE SET */
            if ($c > 0) {
                $num = $c+1;
                $sql = "ALTER TABLE {$serendipity['dbPrefix']}eventcal AUTO_INCREMENT={$num}";
                serendipity_db_query($sql);
            }

            // unlock tables
            @serendipity_db_query('UNLOCK TABLES');

            return isset($numresult) ? $numresult : false;

        }

        if (!$serendipity['eventcalfreetable'] && !$serendipity['eventcalinctable']) return false;

        return false;

    } // function free table end


} // class end
/* vim: set sts=4 ts=4 expandtab : */