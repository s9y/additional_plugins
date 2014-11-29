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

class serendipity_plugin_showentries extends serendipity_plugin {
    var $title = PLUGIN_SHOWENTRIES_TITLE;

    function introspect(&$propbag) {
        $this->title = $this->get_config('title', $this->title);

        $propbag->add('name',        PLUGIN_SHOWENTRIES_TITLE);
        $propbag->add('description', PLUGIN_SHOWENTRIES_BLAHBLAH);
        $propbag->add('configuration', array('title', 'number', 'skip', 'category', 'showtitle', 'showext'));
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('version',     '1.8.1');
        $propbag->add('stackable', true);
        $propbag->add('groups', array('FRONTEND_VIEWS'));
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch($name) {
            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        TITLE);
                $propbag->add('description', TITLE_FOR_NUGGET);
                $propbag->add('default',     PLUGIN_SHOWENTRIES_TITLE_DEFAULT);
                break;

            case 'number':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SHOWENTRIES_NUMBER);
                $propbag->add('description', '');
                $propbag->add('default',     $serendipity['fetchLimit']);
                break;

            case 'category':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SHOWENTRIES_CATEGORY);
                $propbag->add('description', '');
                $propbag->add('default',     '');
                break;

            case 'skip':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_SHOWENTRIES_SKIPNUMBER);
                $propbag->add('description', '');
                $propbag->add('default',     false);
                break;

            case 'showtitle':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_SHOWENTRIES_SHOWTITLE);
                $propbag->add('description', '');
                $propbag->add('default',     true);
                break;

            case 'showext':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_SHOWENTRIES_SHOWEXT);
                $propbag->add('description', '');
                $propbag->add('default',     false);
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        global $serendipity;

        $title          = $this->get_config('title', $this->title);

        $current_cat = $serendipity['GET']['category'];
        $current_page = $serendipity['GET']['page'];
        $current_auth = $serendipity['GET']['viewAuthor'];
        $current_rng  = $serendipity['range'];
        $serendipity['GET']['page'] = 0;
        unset($serendipity['GET']['viewAuthor']);
        unset($serendipity['range']);

        $c = $this->get_config('category');
        if ($c > 0) {
            $serendipity['GET']['category'] = (int)$c;
        }
        $showtitle = serendipity_db_bool($this->get_config('showtitle'));
        $showext   = serendipity_db_bool($this->get_config('showext'));

        if (serendipity_db_bool($this->get_config('skip'))) {
            $limit = serendipity_db_limit($serendipity['fetchLimit'], $this->get_config('number'));
        } else {
            $limit = serendipity_db_limit(0, $this->get_config('number'));
        }

        $entries     = serendipity_fetchEntries(null, true, $limit, false, false, 'timestamp DESC', '', false, true);
        if (is_array($entries)) {
            foreach($entries AS $i => $entry) {
                serendipity_plugin_api::hook_event('frontend_display', $entry);
                /* Pulled from serendipity_printEntries */
                $entry['link']      = serendipity_archiveURL($entry['id'], $entry['title'], 'serendipityHTTPPath', true, array('timestamp' => $entry['timestamp']));
                $entry['commURL']   = serendipity_archiveURL($entry['id'], $entry['title'], 'baseURL', false, array('timestamp' => $entry['timestamp']));
                $entry['rdf_ident'] = serendipity_archiveURL($entry['id'], $entry['title'], 'baseURL', true, array('timestamp' => $entry['timestamp']));
                $entry['title']     = (function_exists('serendipity_specialchars') ? serendipity_specialchars($entry['title']) : htmlspecialchars($entry['title'], ENT_COMPAT, LANG_CHARSET));

                $entry['link_allow_comments']    = $serendipity['baseURL'] . 'comment.php?serendipity[switch]=enable&amp;serendipity[entry]=' . $entry['id'];
                $entry['link_deny_comments']     = $serendipity['baseURL'] . 'comment.php?serendipity[switch]=disable&amp;serendipity[entry]=' . $entry['id'];
                $entry['allow_comments']         = serendipity_db_bool($entry['allow_comments']);
                $entry['moderate_comments']      = serendipity_db_bool($entry['moderate_comments']);
                $entry['link_popup_comments']    = $serendipity['serendipityHTTPPath'] .'comment.php?serendipity[entry_id]='. $entry['id'] .'&amp;serendipity[type]=comments';
                $entry['link_popup_trackbacks']  = $serendipity['serendipityHTTPPath'] .'comment.php?serendipity[entry_id]='. $entry['id'] .'&amp;serendipity[type]=trackbacks';
                $entry['link_edit']              = $serendipity['baseURL'] .'serendipity_admin.php?serendipity[action]=admin&amp;serendipity[adminModule]=entries&amp;serendipity[adminAction]=edit&amp;serendipity[id]='. $entry['id'];
                $entry['link_trackback']         = $serendipity['baseURL'] .'comment.php?type=trackback&amp;entry_id='. $entry['id'];
                $entry['link_rdf']               = serendipity_rewriteURL(PATH_FEEDS . '/ei_'. $entry['id'] .'.rdf');
                $entry['link_viewmode_threaded'] = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] .'?url='. $entry['commURL'] .'&amp;serendipity[cview]='. VIEWMODE_THREADED;
                $entry['link_viewmode_linear']   = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] .'?url='. $entry['commURL'] .'&amp;serendipity[cview]='. VIEWMODE_LINEAR;

                if ($_SESSION['serendipityAuthedUser'] === true && ($_SESSION['serendipityAuthorid'] == $entry['authorid'] || serendipity_checkPermission('adminEntriesMaintainOthers'))) {
                $entry['is_entry_owner']    = true;
            }

            if (is_array($entry['categories'])) {
                    foreach ($entry['categories'] as $k => $v) {
                        $entry['categories'][$k]['category_link'] =  serendipity_categoryURL($entry['categories'][$k]);
                    }
                }
                $entries[$i] = $entry;
            }
        }

        $serendipity['smarty']->assign(array(
            'showtitle' => $showtitle,
            'showext'   => $showext,
            'entries'   => $entries
        ));

        $tfile = serendipity_getTemplateFile('plugin_showentries.tpl', 'serendipityPath');
        if (!$tfile) {
            $tfile = dirname(__FILE__) . '/plugin_showentries.tpl';
        }
        $inclusion = $serendipity['smarty']->security_settings[INCLUDE_ANY];
        $serendipity['smarty']->security_settings[INCLUDE_ANY] = true;
        $content = $serendipity['smarty']->fetch('file:'. $tfile);
        $serendipity['smarty']->security_settings[INCLUDE_ANY] = $inclusion;

        echo $content;

        $serendipity['GET']['category'] = $current_cat;
        $serendipity['GET']['page'] = $current_page;
        $serendipity['GET']['viewAuthor'] = $current_auth;
        $serendipity['range'] = $current_rng;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
