<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

if (!function_exists("Amazon_country_code")) {
   include(dirname(__FILE__)."/Amazon_s9y_lib.php");
}


class serendipity_event_amazonchooser extends serendipity_event
{
    var $title = PLUGIN_EVENT_AMAZONCHOOSER_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_AMAZONCHOOSER_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_AMAZONCHOOSER_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Matthew Groeninger, Ian');
        $propbag->add('version',       '0.74.1');
        $propbag->add('requirements',  array(
            'serendipity' => '1.3',
            'smarty'      => '2.6.7',
            'php'         => '4.3.0'
        ));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',    array(
            'backend_entry_toolbar_extended'    => true,
            'backend_entry_toolbar_body'        => true,
            'external_plugin'                   => true,
            'css_backend'                       => true,
            'css'                               => true,
            'frontend_display'                  => true,
            'backend_wysiwyg'                   => true,
            'serendipity_event_amazonchooser_button' => true,
            'serendipity_event_amazonchooser_devinfo' => true
        ));
        $propbag->add('groups', array('BACKEND_EDITOR'));
        $propbag->add('configuration',  array(
            'dtoken',
            'secretKey',
            'aaid',
            'server'
          ));
        $this->markup_elements = array(
            array(
              'name'     => 'ENTRY_BODY',
              'element'  => 'body',
            ),
            array(
              'name'     => 'EXTENDED_BODY',
              'element'  => 'extended'
           )
        );
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'secretKey':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_AMAZONCHOOSER_DEV_SECRET);
                $propbag->add('description', PLUGIN_EVENT_AMAZONCHOOSER_DEV_SECRET_DESC);
                $propbag->add('default', '');
                break;
            case 'dtoken':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_AMAZONCHOOSER_DEV_TOKEN);
                $propbag->add('description', PLUGIN_EVENT_AMAZONCHOOSER_DEV_TOKEN_DESC);
                $propbag->add('default', '');
                break;
            case 'aaid':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_AMAZONCHOOSER_ASSOCIATE_ID);
                $propbag->add('description', PLUGIN_EVENT_AMAZONCHOOSER_ASSOCIATE_ID_DESC);
                break;
            case 'server':
                $propbag->add('type', 'radio');
                $propbag->add('name', PLUGIN_EVENT_AMAZONCHOOSER_SERVER);
                $propbag->add('description', PLUGIN_EVENT_AMAZONCHOOSER_SERVER_DESC);
                $propbag->add('radio', array(
                    'value' => array('ca', 'cn', 'de', 'es', 'fr', 'it', 'jp', 'uk', 'us'),
                    'desc'  => array(PLUGIN_EVENT_AMAZONCHOOSER_CA,PLUGIN_EVENT_AMAZONCHOOSER_CN,PLUGIN_EVENT_AMAZONCHOOSER_GERMANY,PLUGIN_EVENT_AMAZONCHOOSER_ES,PLUGIN_EVENT_AMAZONCHOOSER_FR,PLUGIN_EVENT_AMAZONCHOOSER_IT,PLUGIN_EVENT_AMAZONCHOOSER_JAPAN,PLUGIN_EVENT_AMAZONCHOOSER_UK,PLUGIN_EVENT_AMAZONCHOOSER_US)
                ));
                $propbag->add('radio_per_row', '1');
                $propbag->add('default', 'us');
                break;
        }
        return true;

    }


    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_entry_toolbar_extended':
                    if (isset($eventData['backend_entry_toolbar_extended:textarea'])) {
                        $txtarea = $serendipity['version'][0] < '2' ?  $eventData['backend_entry_toolbar_extended:textarea'] : $eventData['backend_entry_toolbar_extended:nugget'];
                    } else {
                        $txtarea = 'extended';
                    }
                    if (!$serendipity['wysiwyg']) {
                        $this->generate_button($txtarea,false);
                        return true;
                    } else {
                        return false;
                    }
                    break;

                case 'backend_entry_toolbar_body':
                    if (isset($eventData['backend_entry_toolbar_body:textarea'])) {
                        $txtarea = $serendipity['version'][0] < '2' ?  $eventData['backend_entry_toolbar_body:textarea'] : $eventData['backend_entry_toolbar_body:nugget'];
                    } else {
                        $txtarea = 'body';
                    }
                    if (!$serendipity['wysiwyg']) {
                        $this->generate_button($txtarea,false);
                        return true;
                    } else {
                        return false;
                    }
                    break;

                case 'frontend_display':
                    foreach ($this->markup_elements as $temp) {
                       if (isset($eventData[$temp['element']]) &&
                           !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                           !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];
                            $eventData[$element] = preg_replace_callback('/(?<!\\\\)\[amazon_chooser\](.*?),(.*?)\[\/amazon_chooser\]/', array(&$this,'get_amazon_item'), $eventData[$element]);
                       }
                    }
                    return true;
                    break;

                case 'backend_wysiwyg':
                    $link = serendipity_rewriteURL('plugin/amazonch') . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;') . 'txtarea=' . ($serendipity['version'][0] > '1' ? 'amazonchooser'.$eventData['item'] : $eventData['jsname']);
                    $open = $serendipity['version'][0] > '1' ? 'serendipity.openPopup' : 'window.open';
                    $eventData['buttons'][] = array(
                        'id'         => 'amazonchooser' . ($serendipity['version'][0] > '1' ? $eventData['item'] : $eventData['jsname']),
                        'name'       => PLUGIN_EVENT_AMAZONCHOOSER_MEDIA_BUTTON,
                        'javascript' => 'function() { '.$open.'(\'' . $link . '\', \'AmazonImageSel\', \'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1\') }',
                        'img_url'    => $serendipity['serendipityHTTPPath'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/plugin_amazonchooser.gif',
                        'img_path'   => 'serendipity_event_amazonchooser/serendipity_event_amazonchooser.gif',
                        'toolbar'    => 'other'
                    );//'img_path' deprecated, used by ckeditor plugin <= 4.1.0
                    return true;
                    break;

                case 'css_backend':
                case 'css':
                    $out = serendipity_getTemplateFile('serendipity_event_amazonchooser.css', 'serendipityPath');
                    if ($out && $out != 'serendipity_event_amazonchooser.css') {
                        $eventData .= file_get_contents($out);
                    } else {
                        $eventData .= file_get_contents(dirname(__FILE__) . '/serendipity_event_amazonchooser.css');
                    }
                    return true;
                    break;


                case 'serendipity_event_amazonchooser_button':
                    $eventData['button_out'] = $this->generate_button($eventData['textbox'],true);
                    return true;
                    break;

                case 'serendipity_event_amazonchooser_devinfo':
                    $eventData['dtoken']    = trim($this->get_config('dtoken'));
                    $eventData['secretKey'] = trim($this->get_config('secretKey'));
                    $eventData['aaid']      = trim($this->get_config('aaid'));
                    return true;
                    break;

                case 'external_plugin':
                    $uri_parts = explode('?', str_replace('&amp;', '&', $eventData));
                    $parts     = explode('&', $uri_parts[0]);

                    $uri_part = $parts[0];
                    $parts = array_pop($parts);

                    if (count($parts) > 1) {
                       foreach($parts as $key => $value) {
                            $val = explode('=', $value);
                            $_REQUEST[$val[0]] = $val[1];
                       }
                    } else {
                       $val = explode('=', $parts[0]);
                       $_REQUEST[$val[0]] = $val[1];
                    }

                    if (!isset($_REQUEST['txtarea'])) {
                        $parts = explode('&', $uri_parts[1]);
                        if (count($parts) > 1) {
                            foreach($parts as $key => $value) {
                                 $val = explode('=', $value);
                                 $_REQUEST[$val[0]] = $val[1];
                            }
                        } else {
                            $val = explode('=', $parts[0]);
                            $_REQUEST[$val[0]] = $val[1];
                        }
                    }
                    switch($uri_part) {
                        case 'amazonch-js':
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__) . '/serendipity_event_amazonchooser.js');
                            break;

                        case 'plugin_amazonchooser.gif':
                            header('Content-Type: image/gif');
                            echo file_get_contents(dirname(__FILE__) . '/serendipity_event_amazonchooser.gif');
                            break;

                        case 'amazonch':
                            session_start();
                            include('serendipity_config.inc.php');
                            if (IN_serendipity !== true) {
                                die ("Don't hack!");
                            }

                            if (!is_object($serendipity['smarty'])) {
                                serendipity_smarty_init();
                            }


                            if ($_SESSION['serendipityAuthedUser'] !== true)  {
                                die(HAVE_TO_BE_LOGGED_ON);
                            }

                            $country = trim($this->get_config('server'));
                            list($country_url,$mode) = Amazon_country_code($country);
                            $mode_names = Amazon_return_mode_array();

                            header('Content-Type: text/html; charset=' . LANG_CHARSET);


                            $tfile = serendipity_getTemplateFile('plugin_amazon_search.tpl', 'serendipityPath');
                            if (!$tfile || $tfile == 'plugin_amazon_search.tpl') {
                               $tfile = dirname(__FILE__) . '/plugin_amazon_search.tpl';
                            }


                            $tdisplayfile = serendipity_getTemplateFile('plugin_amazon_display.tpl', 'serendipityPath');
                            if (!$tdisplayfile || $tdisplayfile == 'plugin_amazon_display.tpl') {
                                $tdisplayfile = dirname(__FILE__) . '/plugin_amazon_display.tpl';
                            }

                            $serendipity['smarty']->assign(
                                 array(
                                      'plugin_amazonchooser_css'           => serendipity_rewriteURL('serendipity_admin.css'),
                                      'plugin_amazonchooser_js'            => serendipity_rewriteURL('plugin/amazonch-js')
                                 ));

                            switch ($_REQUEST['step']) {
                                case '1':
                                    $page = 1;
                                    if (isset($_REQUEST['page'])) {
                                       $page = (int)$_REQUEST['page'];
                                    }
                                    if (isset($_REQUEST['simple']) && ($_REQUEST['simple'])) {
                                       $simple = "&amp;simple=1";
                                    } else {
                                        $simple = "";
                                    }
                                    $request_mode = trim((function_exists('serendipity_specialchars') ? serendipity_specialchars(rawurlencode($_REQUEST['mode'])) : htmlspecialchars(rawurlencode($_REQUEST['mode']), ENT_COMPAT, LANG_CHARSET)));
                                    if (in_array($_REQUEST['mode'],$mode)) {
                                        $results = $this->Amazon_Call("search",$request_mode,trim((function_exists('serendipity_specialchars') ? serendipity_specialchars(rawurlencode($_REQUEST['keyword'])) : htmlspecialchars(rawurlencode($_REQUEST['keyword']), ENT_COMPAT, LANG_CHARSET))),$country_url,$page);
                                    } else {
                                        $results['return_count'] = 0;
                                        $results['count'] = 0;
                                        $results['error_message'] = PLUGIN_EVENT_AMAZONCHOOSER_INVALIDINDEX . ": " .trim((function_exists('serendipity_specialchars') ? serendipity_specialchars(rawurlencode($_REQUEST['mode'])) : htmlspecialchars(rawurlencode($_REQUEST['mode']), ENT_COMPAT, LANG_CHARSET)));
                                    }
                                    if ($page > 1) {
                                       $previous_page = $page - 1;
                                       $serendipity['smarty']->assign(array('plugin_amazonchooser_previouspage'=>$previous_page));
                                    }
                                    if (($page < 400) && ($results['return_count'] > 10)) {
                                       $next_page = $page + 1;
                                       $serendipity['smarty']->assign(array('plugin_amazonchooser_nextpage'=>$next_page));
                                    }
                                    $serendipity['smarty']->assign(
                                      array(
                                            'plugin_amazonchooser_page'             => "Search",
                                            'plugin_amazonchooser_displaytemplate'  => $tdisplayfile,
                                            'plugin_amazonchooser_currentpage'      => $page,
                                            'plugin_amazonchooser_totalpages'       => $results['totalpages'],
                                            'plugin_amazonchooser_item_count'       => $results['count'],
                                            'plugin_amazonchooser_return_count'     => $results['return_count'],
                                            'plugin_amazonchooser_error_message'    => $results['error_message'],
                                            'plugin_amazonchooser_error_result'     => $results['error_result'],
                                            'plugin_amazonchooser_cache_time'       => $results['return_date'],
                                            'plugin_amazonchooser_items'            => $results['items'],
                                            'plugin_amazonchooser_search_url'       => serendipity_rewriteURL('plugin/amazonch') . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;') . 'txtarea=' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($_REQUEST['txtarea']) : htmlspecialchars($_REQUEST['txtarea'], ENT_COMPAT, LANG_CHARSET)).$simple.'&amp;keyword='.trim((function_exists('serendipity_specialchars') ? serendipity_specialchars(rawurlencode($_REQUEST['keyword'])) : htmlspecialchars(rawurlencode($_REQUEST['keyword']), ENT_COMPAT, LANG_CHARSET))).'&amp;mode='.$request_mode,
                                            'plugin_amazonchooser_this_url'         => serendipity_rewriteURL('plugin/amazonch') . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;') . '&amp;mode='.trim((function_exists('serendipity_specialchars') ? serendipity_specialchars(rawurlencode($_REQUEST['mode'])) : htmlspecialchars(rawurlencode($_REQUEST['mode']), ENT_COMPAT, LANG_CHARSET))).'&amp;txtarea=' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($_REQUEST['txtarea']) : htmlspecialchars($_REQUEST['txtarea'], ENT_COMPAT, LANG_CHARSET)) .$simple. '&amp;step=1&amp;keyword='.trim((function_exists('serendipity_specialchars') ? serendipity_specialchars(rawurlencode($_REQUEST['keyword'])) : htmlspecialchars(rawurlencode($_REQUEST['keyword']), ENT_COMPAT, LANG_CHARSET))).'&amp;page=',
                                            'plugin_amazonchooser_select_url'       => serendipity_rewriteURL('plugin/amazonch') . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;') . '&amp;mode='.trim((function_exists('serendipity_specialchars') ? serendipity_specialchars(rawurlencode($_REQUEST['mode'])) : htmlspecialchars(rawurlencode($_REQUEST['mode']), ENT_COMPAT, LANG_CHARSET))).$simple.'&amp;txtarea=' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($_REQUEST['txtarea']) : htmlspecialchars($_REQUEST['txtarea'], ENT_COMPAT, LANG_CHARSET)) . '&amp;step=2&amp;asin='
                                      )
                                    );
                                    break;

                                case '2':
                                    if (isset($_REQUEST['asin'])) {
                                        $result = $this->Amazon_Call("lookup",trim((function_exists('serendipity_specialchars') ? serendipity_specialchars(rawurlencode($_REQUEST['mode'])) : htmlspecialchars(rawurlencode($_REQUEST['mode']), ENT_COMPAT, LANG_CHARSET))),trim((function_exists('serendipity_specialchars') ? serendipity_specialchars(rawurlencode($_REQUEST['asin'])) : htmlspecialchars(rawurlencode($_REQUEST['asin']), ENT_COMPAT, LANG_CHARSET))),$country_url,$page);
                                    } else {
                                        $result['count'] = 0;
                                        $result['error_message'] = PLUGIN_EVENT_AMAZONCHOOSER_NOASIN;
                                    }
                                    if (isset($_REQUEST['simple']) && ($_REQUEST['simple'])) {
                                       $simple = 1;
                                    } else {
                                        $simple = "";
                                    }
                                    $serendipity['smarty']->assign(
                                        array(
                                            'plugin_amazonchooser_page'             => "Lookup",
                                            'plugin_amazonchooser_displaytemplate'  => $tdisplayfile,
                                            'plugin_amazonchooser_txtarea'          => $_REQUEST['txtarea'],
                                            'plugin_amazonchooser_item_count'       => $result['count'],
                                            'plugin_amazonchooser_return_count'     => $result['return_count'],
                                            'plugin_amazonchooser_searchmode'       => trim((function_exists('serendipity_specialchars') ? serendipity_specialchars(rawurlencode($_REQUEST['mode'])) : htmlspecialchars(rawurlencode($_REQUEST['mode']), ENT_COMPAT, LANG_CHARSET))),
                                            'plugin_amazonchooser_simple'           => $simple,
                                            'plugin_amazonchooser_error_message'    => $result['error_message'],
                                            'plugin_amazonchooser_cache_time'       => $result['return_date'],
                                            'plugin_amazonchooser_error_result'     => $result['error_result'],
                                            'thingy'          => $result['items'][0]
                                        )
                                    );
                                    break;

                                default:
                                    $defaultmode = rawurlencode($_REQUEST['mode']);
                                    $link = serendipity_rewriteURL('plugin/amazonch') . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;');
                                    foreach($mode as $type) {
                                      $mode_out[$type]=$mode_names[$type];
                                    }
                                    if (isset($_REQUEST['simple']) && ($_REQUEST['simple'])) {
                                       $simple = "1";
                                    } else {
                                        $simple = "0";
                                    }
                                    asort($mode_out);
                                    $serendipity['smarty']->assign(
                                        array(
                                            'plugin_amazonchooser_page'          => "default",
                                            'plugin_amazonchooser_keyword'       => rawurldecode($_REQUEST['keyword']),
                                            'plugin_amazonchooser_link'          => $link,
                                            'plugin_amazonchooser_txtarea'       => trim((function_exists('serendipity_specialchars') ? serendipity_specialchars(rawurlencode($_REQUEST['txtarea'])) : htmlspecialchars(rawurlencode($_REQUEST['txtarea']), ENT_COMPAT, LANG_CHARSET))),
                                            'plugin_amazonchooser_simple'        => $simple,
                                            'plugin_amazonchooser_mode'          => $mode_out,
                                            'plugin_amazonchooser_defaultmode'   => $defaultmode
                                        )
                                    );
                                    break;
                            }
                            // use native API here - extends s9y version >= 1.3'
                            $content = $this->parseTemplate($tfile);
                            echo $content;
                        };

                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENT_AMAZONCHOOSER_TITLE;
    }

    function generate_button ($txtarea,$return_output) {
        global $serendipity;
        if (!isset($txtarea)) {
            $txtarea = 'body';
        }
        $link =  serendipity_rewriteURL('plugin/amazonch') . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;') . 'txtarea=' . $txtarea;
        $open = $serendipity['version'][0] > '1' ? 'serendipity.openPopup' : 'window.open';

        if ($return_output) {
            if ($serendipity['version'][0] > '1') {
                $button = '<input type="button" class="input_button" name="insAmazonImage" value="'.PLUGIN_EVENT_AMAZONCHOOSER_MEDIA_BUTTON.'" style="" onclick="'.$open.'(\''.$link."&amp;simple=1".'\', \'AmazonImageSel\', \'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1\');">';
            } else {
                $button = '<input type="button" class="serendipityPrettyButton input_button" name="insAmazonImage" value="'.PLUGIN_EVENT_AMAZONCHOOSER_MEDIA_BUTTON.'" style="" onclick="'.$open.'(\''.$link."&amp;simple=1".'\', \'AmazonImageSel\', \'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1\');" />';
            }
            return $button;
        } else {
            if ($serendipity['version'][0] > '1') {
                $button = '<input type="button" class="input_button" name="insAmazonImage" value="'.PLUGIN_EVENT_AMAZONCHOOSER_MEDIA_BUTTON.'" style="" onclick="'.$open.'(\''.$link.'\', \'AmazonImageSel\', \'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1\');">';
            } else {
                $button = '<input type="button" class="serendipityPrettyButton input_button"  name="insAmazonImage" value="'.PLUGIN_EVENT_AMAZONCHOOSER_MEDIA_BUTTON.'" style="" onclick="'.$open.'(\''.$link.'\', \'AmazonImageSel\', \'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1\');" />';
            }
            echo $button;
        }
    }

    function get_amazon_item($matches) {
        global $serendipity;

        if (!is_dir($serendipity['serendipityPath'].'templates_c/amazonchooser/')) {
            mkdir($serendipity['serendipityPath'].'templates_c/amazonchooser/');
        }
        $content = false;
        $asin = $matches[1];
        $Searchindex = $matches[2];
        $country = trim($this->get_config('server'));
        list($country_url,$mode) = Amazon_country_code($country);
        if (@include_once("Cache/Lite.php")) {
            $cache_obj = new Cache_Lite( array('cacheDir' => $serendipity['serendipityPath'].'templates_c/amazonchooser/','automaticSerialization' => true,'lifeTime' => 3600));
            $content = $cache_obj->get('amazonchooser'.$asin);
        }
        if (!$content) {
           if (!is_object($serendipity['smarty'])) {
              serendipity_smarty_init();
           }
           $tfile = serendipity_getTemplateFile('plugin_amazon_display.tpl', 'serendipityPath');
           if (!$tfile || $tfile == 'plugin_amazon_display.tpl') {
               $tfile = dirname(__FILE__) . '/plugin_amazon_display.tpl';
           }

           if (isset($asin)) {
               $method = "lookup";
               $result = $this->Amazon_Call($method,$Searchindex,$asin,$country_url,0);
           } else {
               $item_count = -1;
               $error_message = PLUGIN_EVENT_AMAZONCHOOSER_NOASIN;
           }
           $serendipity['smarty']->assign(
               array(
                'plugin_amazonchooser_item_count'    => $result['count'],
                'plugin_amazonchooser_return_count'  => $result['return_count'],
                'plugin_amazonchooser_error_message' => $result['error_message'],
                'plugin_amazonchooser_error_result'  => $result['error_result'],
                'plugin_amazonchooser_cache_time'    => $result['return_date'],
                'thingy'                             => $result['items'][0]
              )
           );

           // use native API here - extends s9y version >= 1.3'
           $content = $this->parseTemplate($tfile);

           $content = str_replace("\n",'',$content);
           if (class_exists('Cache_Lite') && is_object($cache_obj)) {
                $cache_obj->save($content,'amazonchooser'.$asin);
            }
        }
        return($content);
    }

    function Amazon_Call($method,$mode,$searchstring,$country_url,$page) {
        global $serendipity;

        if (!is_dir($serendipity['serendipityPath'].'templates_c/amazonget/')) {
            mkdir($serendipity['serendipityPath'].'templates_c/amazonget/');
        }

        $AWSAccessKey = trim($this->get_config('dtoken'));
        $AssociateTag = trim($this->get_config('aaid'));
        $secretKey = trim($this->get_config('secretKey'));
        if ($method == "search") {
            $results = Amazon_SearchItems($AWSAccessKey,$AssociateTag,$secretKey,$mode,$searchstring,$country_url,$page);
        } else {
            if (@include_once("Cache/Lite.php")) {
               $cache_obj = new Cache_Lite( array('cacheDir' => $serendipity['serendipityPath'].'templates_c/amazonget/','automaticSerialization' => true,'lifeTime' => 43200));
               $results = $cache_obj->get('amazonlookup'.$searchstring);
            }
            if (!$results['return_date']) {
                $results = Amazon_ItemLookup($AWSAccessKey,$AssociateTag,$secretKey,$mode,$searchstring,$country_url);
                if ($results['return_date'] && class_exists('Cache_Lite') && is_object($cache_obj)) {
                    $cache_obj->save($results,'amazonlookup'.$searchstring);
                }
            }
        }
        if ($results['count'] == 0 || $results['return_count'] == 0) {
            $results['items'] = "";
        }
        return $results;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
