<?php

# (c) by Rob Antonishen
# serendipity_event_wrapURL.php, v0.1 2005/05/04
# Very much copied from the static page event plugin by Marco Rinck, Garvin Hicking, David Rolston
#


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_wrapURL extends serendipity_event {
    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name', WRAPURL_TITLE . ': ' . $this->get_config('pagetitle', ''));
        $propbag->add('description', WRAPURL_TITLE_BLAHBLAH);
        $propbag->add('event_hooks',  array('entries_header' => true, 'entry_display' => true, 'genpage' => true, 'frontend_generate_plugins' => true, 'css' => true));
        $propbag->add('configuration', array('headline', 'permalink', 'pagetitle', 'wrapurl', 'height', 'wrapurl_append', 'hide_sidebar'));
        $propbag->add('author', 'Rob Antonishen, Ian (Timbalu)');
        $propbag->add('version', '0.10.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
        $propbag->add('stackable', true);

        $this->pagetitle = $this->get_config('pagetitle', 'pagetitle');
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'headline':
                $propbag->add('type',        'string');
                $propbag->add('name',        WRAPURL_HEADLINE);
                $propbag->add('description', WRAPURL_HEADLINE_BLAHBLAH);
                $propbag->add('default',     '');
                break;

            case 'wrapurl':
                $propbag->add('type',        'string');
                $propbag->add('name',        WRAPURL_URL);
                $propbag->add('description', WRAPURL_URL_BLAHBLAH);
                $propbag->add('default',     '');
                break;

            case 'wrapurl_append':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        WRAPURL_URL_APPEND);
                $propbag->add('description', WRAPURL_URL_APPEND_BLAHBLAH);
                $propbag->add('default',     false);
                break;

            case 'hide_sidebar':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        WRAPURL_HIDE_SIDEBAR);
                $propbag->add('description', '');
                $propbag->add('default',     false);
                break;

            case 'permalink':
                $propbag->add('type',        'string');
                $propbag->add('name',        WRAPURL_PERMALINK);
                $propbag->add('description', WRAPURL_PERMALINK_BLAHBLAH);
                $propbag->add('default',     $serendipity['rewrite'] != 'none'
                                             ? $serendipity['serendipityHTTPPath'] . 'wpages/pagetitle.html'
                                             : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/wpages/pagetitle.html');
                break;

            case 'pagetitle':
                $propbag->add('type',        'string');
                $propbag->add('name',        WRAPURL_PAGETITLE);
                $propbag->add('description', WRAPURL_PAGETITLE_BLAHBLAH);
                $propbag->add('default',     'pagetitle');
                break;

            case 'height':
                $propbag->add('type',        'string');
                $propbag->add('name',        WRAPURL_HIGHT);
                $propbag->add('description', WRAPURL_HIGHT_BLAHBLAH);
                $propbag->add('default',     '1000');
                break;


            default:
                return false;
        }
        return true;
    }

    function show() {
        global $serendipity;

        if ($this->selected()) {
            if (!headers_sent()) {
                header('HTTP/1.0 200');
                header('Status: 200 OK');
            }

            $url = $this->get_config('wrapurl');

            if (serendipity_db_bool($this->get_config('wrapurl_append'))) {
                if (stristr($url, '?') === false) {
                    $url .= '?';
                } else {
                    $url .= '&amp;';
                }

                foreach($_GET AS $key => $value) {
                    if (is_array($value)) {
                        // Arrays are skipped!
                        continue;
                    }

                    $url .= (function_exists('serendipity_specialchars') ? serendipity_specialchars($key) : htmlspecialchars($key, ENT_COMPAT, LANG_CHARSET)) . '=' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($value) : htmlspecialchars($value, ENT_COMPAT, LANG_CHARSET)) . '&amp;';
                }
            }
            
            $_ENV['staticpage_pagetitle'] = preg_replace('@[^a-z0-9]@i', '_',$this->get_config('pagetitle'));
            $serendipity['smarty']->assign('staticpage_pagetitle', $_ENV['staticpage_pagetitle']);
            echo '<h4 class="serendipity_title"><a href="#">' . $this->get_config('headline') . '</a></h4>';

            echo '<div id="plugin_wrapurl_'.$serendipity['wrapurl']['id_name'].'">';
            echo '<iframe src="' . $url . '" width="100%" height="100%" scrolling="auto" frameborder="0" style="height:100%;frameborder:0px" ></iframe>';
            echo '</div>';
        }
    }

    function selected() {
        global $serendipity;
        if ($serendipity['GET']['subpage'] == $this->get_config('pagetitle') ||
            preg_match('@^' . preg_quote($this->get_config('permalink')) . '@i', $serendipity['GET']['subpage'])) {
            return true;
        }

        return false;
    }

    function generate_content(&$title) {
        $title = WRAPURL_TITLE.' ('.$this->get_config('pagetitle').')';
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        
        $serendipity['wrapurl']['id_name'] = $this->get_config('pagetitle') ? $this->get_config('pagetitle') : 'none';
        
        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_generate_plugins':
                    if ($this->selected() && serendipity_db_bool($this->get_config('hide_sidebar'))) {
                        $serendipity['smarty']->assign('leftSidebarElements', 0);
                        $serendipity['smarty']->assign('rightSidebarElements', 0);
                        $eventData = array();
                    }
                    break;

                case 'genpage':
                    $args = implode('/', serendipity_getUriArguments($eventData, true));
                    if ($serendipity['rewrite'] != 'none') {
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

                    if (version_compare($serendipity['version'], '0.7.1', '<=')) {
                        $this->show();
                    }

                    return true;
                    break;

                case 'entries_header':
                    $this->show();

                    return true;
                    break;

                /* put here all your css stuff you need for the wrapurl plugin frontend output */
                case 'css':
                    
                    if (stristr($eventData, '#plugin_wrapurl')) { 
                        // class exists in CSS, so a user has customized it and we don't need default
                        return true;
                    }

echo '
#plugin_wrapurl_'.$serendipity['wrapurl']['id_name'].' { width: 100%; border: 0 none; border-collapse: collapse; border-spacing: 0; height:' . $this->get_config('height') . 'px; }
';

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
