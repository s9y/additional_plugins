<?php # $Id$

# serendipity_plugin_staticpage.php, v1.0 2005/06/01 (c) by Rob Antonishen

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_plugin_staticpage extends serendipity_plugin {

    var $staticpage_config = array();

    function introspect(&$propbag) {
        $propbag->add('name',        PLUGIN_STATICPAGELIST_NAME);
        $propbag->add('description', PLUGIN_STATICPAGELIST_NAME_DESC);
        $propbag->add('author',      "Rob Antonishen, Falk Doering, Ian (Timbalu)");
        $propbag->add('stackable',   true);
        $propbag->add('version',     '1.19');
        $propbag->add('configuration', array(
                'title',
                'limit',
                'parentsonly',
                'frontpage',
                'smartify',
                'showIcons',
                'useIcons',
                'imgdir'
        ));
        $propbag->add('requirements',  array(
            'serendipity' => '1.3',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_VIEWS'));
        $this->dependencies = array(
            'serendipity_event_staticpage' => 'keep',
            'serendipity_plugin_multilingual' => 'keep'
        );

    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;
        switch($name) {
            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_STATICPAGELIST_TITLE);
                $propbag->add('description', PLUGIN_STATICPAGELIST_TITLE_DESC);
                $propbag->add('default',     PLUGIN_STATICPAGELIST_TITLE_DEFAULT);
                break;

            case 'limit':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_STATICPAGELIST_LIMIT);
                $propbag->add('description', PLUGIN_STATICPAGELIST_LIMIT_DESC);
                $propbag->add('default',     0);
                break;

            case 'parentsonly':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_STATICPAGELIST_PARENTSONLY);
                $propbag->add('description', PLUGIN_STATICPAGELIST_PARENTSONLY_DESC);
                $propbag->add('default',     'false');
                break;

            case 'frontpage':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_STATICPAGELIST_FRONTPAGE_NAME);
                $propbag->add('description', PLUGIN_STATICPAGELIST_FRONTPAGE_DESC);
                $propbag->add('default',     'true');
                break;

            case 'smartify':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_STATICPAGELIST_SMARTIFY);
                $propbag->add('description', PLUGIN_STATICPAGELIST_SMARTIFY_BLAHBLAH);
                $propbag->add('default',     'false');
                break;

            case 'useIcons':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_STATICPAGELIST_IMG_NAME);
                $propbag->add('description', '');
                $propbag->add('default',     'true');
                break;

            case 'imgdir':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_LINKS_IMGDIR);
                $propbag->add('description', PLUGIN_LINKS_IMGDIR_BLAHBLAH);
                $propbag->add('default',     $serendipity['baseURL'] . 'plugins/' . basename(dirname(__FILE__)));
                break;

            case 'showIcons':
                $propbag->add('type',        'radio');
                $propbag->add('name',        PLUGIN_STATICPAGELIST_SHOWICONS_NAME);
                $propbag->add('description', PLUGIN_STATICPAGELIST_SHOWICONS_DESC);
                $propbag->add('radio',       array(
                                                'value' => array('true', 'false'),
                                                'desc'  => array(PLUGIN_STATICPAGELIST_ICON, PLUGIN_STATICPAGELIST_TEXT)
                                             ));
                $propbag->add('default',     'false');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) { 
        $title = $this->get_config('title');//STATICPAGE_TITLE;
        // do not load the tpl in backend
        if(!defined('IN_serendipity_admin')) {
            $this->show_content();
        }
    }

    function show_content() {
        global $serendipity;
        static $smartify = null;

        if ($smartify === null) {
            $smartify = serendipity_db_bool($this->get_config('smartify'));
        }        

        $title      = $this->get_config('title');
        $frontpage  = serendipity_db_bool($this->get_config('frontpage', true));
        $plugin_dir = basename(dirname(__FILE__));
        $smartcar   = array();
        $str        = '';

        if (!serendipity_db_bool($this->get_config('showIcons'))) {
            if ($frontpage) {
                if ($smartify) {
                    $serendipity['smarty']->assign('frontpage_path', $serendipity['serendipityHTTPPath'] . $serendipity['indexFile']);
                } else {
                    $str .= '<a href="' . $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'].'">'.PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME . '</a><br />';
                }
            }
            if ($smartify) {
                $smartcar = $this->displayPageList($this->get_config('limit'), serendipity_db_bool($this->get_config('parentsonly')), $smartify);
            } else {
                $str .= $this->displayPageList($this->get_config('limit'), serendipity_db_bool($this->get_config('parentsonly')));
            }
        } else {
            if (!isset($serendipity['staticpageplugin']['JS_init'])) {
                $str .= '<script src="' . $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/dtree.js" language="javascript" type="text/javascript"></script>';
                $serendipity['staticpageplugin']['JS_init'] = true;
            }

            $imgdir = $this->get_config('imgdir');
            if ($imgdir === "true") {
                $imgdir = $serendipity['baseURL'] . 'plugins/' . $plugin_dir;
            }
            $fdid = str_replace(':', '_', $this->instance);

            $str .= '<script type="text/javascript">
            <!--
            fd_' . $fdid . ' = new dTree("fd_' . $fdid . '","' . $imgdir . '");'."\n";

            /* configuration section*/
            if (!serendipity_db_bool($this->get_config('useIcons'))) {
                $str .= "fd_$fdid.config.useIcons  = false;\n";
            }
            $str .= "fd_$fdid.config.useSelection  = false;\n";
            $str .= "fd_$fdid.config.useCookies    = false;\n";
            $str .= "fd_$fdid.config.useLines      = false;\n";
            $str .= "fd_$fdid.config.useStatusText = true;\n";
            $str .= "fd_$fdid.config.closeSameLevel= true;\n";
            $str .= "fd_$fdid.config.target        = '_self'\n";

            $str .= 'fd_' . $fdid . '.add(0,-1,"' . PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME . '","' . $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '");'."\n";

            if ($struct = $this->getPageList(serendipity_db_bool($this->get_config('parentsonly')))) {
                $this->addJSTags($struct);
                foreach ($struct as $value) {
                    $str .= 'fd_' . $fdid . '.add('
                            . $value['id'] . ','
                            . $value['parent_id'] . ','
                            . '"' . htmlspecialchars((empty($value['headline']) ? $value['pagetitle'] : $value['headline'])) . '",'
                            . '"' . htmlspecialchars($value['permalink']) . '",'
                            . '"' . htmlspecialchars($value['pagetitle']) .'",'
                            . '"",'
                            . '"",'
                            . '"",'
                            . '"' . $value['type'] . '");'
                            . "\n";
                }
            }

            $str .= 'document.write(fd_' . $fdid . ');
            //-->
            </script>';
        }

        if ($smartify) {
            $serendipity['smarty']->assign(array(
                'staticpage_jsStr'       => $str,
                'staticpage_listContent' => $smartcar
            ));
            $filename = 'plugin_staticpage_sidebar.tpl';
            // use nativ API here - extends s9y version >= 1.3'
            $content = $this->parseTemplate($filename);
            echo $content;
        } else {
            echo $str;
        }
    }

    function getPageList($parentsonly = false) {
        global $serendipity;

        $q = 'SELECT id, headline, parent_id, permalink, pagetitle, is_startpage
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE showonnavi = 1
                 AND publishstatus = 1
                 AND (language = \''.$serendipity['lang'].'\'
                  OR  language = \'\'
                  OR  language = \'all\')';
        if($parentsonly) {
            $q .= ' AND parent_id = 0';
        }
        $q .= ' ORDER BY parent_id, pageorder';
        $pagelist = serendipity_db_query($q, false, 'assoc');
        if (is_array($pagelist)) {
            serendipity_plugin_staticpage::iteratePageList($pagelist);
            $pagelist = serendipity_walkRecursive($pagelist, 'id', 'parent_id', VIEWMODE_THREADED);
            return $pagelist;
        }
        return false;
    }

    function addJSTags(&$pagelist) {
        global $serendipity;

        $pc_count = count($pagelist);
        for ($i = 0; $i < $pc_count; $i++) {
            $p = array(
                'type' => 'open',
                'tag'  => ($pagelist[$i]['parent_id'] == 0) ? 'link' : 'dir'
            );
            $pagelist[$i] = array_merge($pagelist[$i], $p);
        }
    }

    function iteratePageList(&$pagelist) {
        global $serendipity;

        if (is_array($pagelist)) {
            foreach($pagelist AS $idx => $page) {
                if ($page['is_startpage'] > 0) {
                    $pagelist[$idx]['permalink'] = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'];
                }
            }
        }
        
        return true;
    }

    function displayPageList($limit, $parentsonly, $tpl=false) {
        global $serendipity;

        $q = 'SELECT id, headline, parent_id, permalink, pagetitle, is_startpage
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE showonnavi = 1
                 AND publishstatus = 1
                 AND (language = \''.$serendipity['lang'].'\'
                  OR  language = \'\'
                  OR  language = \'all\')';
        if($parentsonly) {
            $q .= ' AND parent_id = 0';
        }
        $q .= ' ORDER BY parent_id, pageorder';
        if($limit) {
            $q .= ' LIMIT '.$limit;
        }
        $pagelist = serendipity_db_query($q, false, 'assoc');
        if(is_array($pagelist)) {
            serendipity_plugin_staticpage::iteratePageList($pagelist);
            $pagelist = serendipity_walkRecursive($pagelist, 'id', 'parent_id', VIEWMODE_THREADED);
            $content = ($tpl ? array() : (string)'');

            foreach($pagelist as $page) {
                if(is_array($content)) { 
                    /* smartify the staticpage sidebar plugin */
                    $content[] = array(
                        'id'           => $page['id'],
                        'headline'     => (!empty($page['headline']) ? htmlspecialchars($page['headline']) : htmlspecialchars($page['pagetitle'])),
                        'parent_id'    => $page['parent_id'],
                        'permalink'    => (!empty($page['permalink']) ? $page['permalink'] : NULL),
                        'pagetitle'    => (!empty($page['permalink']) ? htmlspecialchars($page['pagetitle']) : NULL),
                        'is_startpage' => $page['is_startpage'],
                        'depth'        => $page['depth']*10
                    );
                } elseif(is_string($content)) { 
                    $content .= (!empty($page['permalink'])
                        ? sprintf(
                            "<a href=\"%s\" title=\"%s\" style=\"padding-left: %dpx;\">%s</a><br />\n",
                            $page['permalink'],
                            htmlspecialchars($page['pagetitle']),
                            $page['depth']*10,
                            (!empty($page['headline']) ? htmlspecialchars($page['headline']) : htmlspecialchars($page['pagetitle'])))
                        : sprintf(
                            "<div style=\"padding-left: %dpx;\">%s</div>",
                            $page['depth']*10,
                            (!empty($page['headline']) ? htmlspecialchars($page['headline']) : htmlspecialchars($page['pagetitle']))));
                }
            }
        } 
        
        return $content;
    }
}
