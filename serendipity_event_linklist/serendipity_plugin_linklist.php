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

class serendipity_plugin_linklist extends serendipity_plugin
{
    var $title = PLUGIN_LINKS_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_LINKS_NAME);
        $propbag->add('description',   PLUGIN_LINKS_BLAHBLAH);
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Matthew Groeninger, Omid Mottaghi Rad');
        $propbag->add('version',       '1.22');
        $propbag->add('stackable',     false);
        $propbag->add('configuration', array(
                                             'title',
                                             'prepend_text',
                                             'top_level',
                                             'directxml',
                                             'links',
                                             'display',
                                             'category',
                                             'cache',
                                             'style',
                                             'append_text',
                                             'openAllText',
                                             'closeAllText',
                                             'showOpenAndCloseLinks',
                                             'locationOfOpenAndClose',
                                             'useSelection',
                                             'useCookies',
                                             'useLines',
                                             'useIcons',
                                             'useSVG',
                                             'useStatusText',
                                             'closeSameLevel',
                                             'target',
                                             'category_default_open',
                                             'use_description',
                                             'call_markup',
                                             'imgdir'));
        $this->protected = TRUE; // If set to TRUE, only allows the owner of the plugin to modify its configuration
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $this->dependencies = array('serendipity_event_linklist' => 'non-remove');
        $propbag->add('groups', array('FRONTEND_FEATURES'));
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;
        switch($name) {
           case 'title':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_LINKS_TITLE);
                $propbag->add('description', PLUGIN_LINKS_TITLE_BLAHBLAH);
                $propbag->add('default', 'Bookmark');
                break;

           case 'prepend_text':
                $propbag->add('type', 'html');
                $propbag->add('name', PLUGIN_LINKS_PREPEND);
                $propbag->add('description', '');
                $propbag->add('default', '');
                break;

           case 'append_text':
                $propbag->add('type', 'html');
                $propbag->add('name', PLUGIN_LINKS_APPEND);
                $propbag->add('description', '');
                $propbag->add('default', '');
                 break;

           case 'top_level':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_LINKS_TOP_LEVEL);
                $propbag->add('description', PLUGIN_LINKS_TOP_LEVEL_BLAHBLAH);
                $propbag->add('default', '');
                break;


            case 'directxml':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_LINKS_DIRECTXML);
                $propbag->add('description', PLUGIN_LINKS_DIRECTXML_BLAHBLAH);
                $propbag->add('default', 'true');
                break;

            case 'links':
                if($this->get_config('directxml') == 'true')  {
                    $propbag->add('type', 'text');
                    $propbag->add('name', PLUGIN_LINKS_LINKS);
                    $propbag->add('description', PLUGIN_LINKS_LINKS_BLAHBLAH);
                    $propbag->add('default', '<dir name="PHP">'."\n".'  <dir name="Official PHP Sites">'."\n".'   <link name="PHP" link="http://php.net/" />'."\n".'   <link name="Zend" link="http://zend.com/" />'."\n".'  </dir>'."\n".' <link name="PHP Mirrors" link="http://us.php.net/mirrors.php" />'."\n".'</dir>'."\n\n".'<dir name="Friends">'."\n".'  <link name="Garvin Hicking" link="http://www.supergarv.de/" hcard="fn" rel="friend" descrip="Awesome Programmer" />'."\n".'  <link name="Matthew Groeninger" link="http://www.theledge.net/" hcard="fn" rel="friend" descrip="Nice Guy" />'."\n".'  <link name="OXYGEN Web Solutions" link="http://oxygenws.com/"  />'."\n".'</dir>'."\n\n".'<link name="Serendipity" link="http://s9y.org/" descrip="Best Blog Software Ever!"/>'."\n");
                    $propbag->add('lang_direction', 'ltr');
                }
                break;

            case 'display':
                if($this->get_config('directxml') != 'true')  {
                    $select = array();
                    $select["alpha"] = PLUGIN_LINKLIST_ORDER_ALPHA;
                    $select["category"] = PLUGIN_LINKLIST_ORDER_CATEGORY;
                    $select["order_num"] = PLUGIN_LINKLIST_ORDER_NUM_ORDER;
                    $select["datedesc"] = PLUGIN_LINKLIST_ORDER_DATE_DESC;
                    $select["dateacs"] = PLUGIN_LINKLIST_ORDER_DATE_ACS;
                    $propbag->add('type', 'select');
                    $propbag->add('name', PLUGIN_LINKLIST_ORDER);
                    $propbag->add('description', PLUGIN_LINKLIST_ORDER_DESC);
                    $propbag->add('select_values', $select);
                    $propbag->add('default', 'category');
                }
                break;

            case 'category':
                if($this->get_config('directxml') != 'true')  {
                    $propbag->add('type', 'radio');
                    $propbag->add('name', PLUGIN_LINKLIST_CATEGORY_NAME);
                    $propbag->add('description', PLUGIN_LINKLIST_CATEGORY_NAME_DESC);
                    $propbag->add('radio',
                        array( 'value' => array('custom','default'),
                               'desc'  => array(PLUGIN_LINKLIST_CATEGORY_NAME_CUSTOM,PLUGIN_LINKLIST_CATEGORY_NAME_DEFAULT)
                        ));
                    $propbag->add('radio_per_row', '2');
                    $propbag->add('default', 'custom');
                }
                break;

            case 'cache':
                 $propbag->add('type', 'radio');
                 $propbag->add('name', PLUGIN_LINKLIST_CACHE_NAME);
                 $propbag->add('description', PLUGIN_LINKLIST_CACHE_DESC);
                 $propbag->add('radio',
                   array( 'value' => array('yes', 'no'),
                          'desc'  => array(YES, NO)
                      ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'no');
                break;

            case 'openAllText':
                if($this->get_config('style') == "dtree")  {
                    $propbag->add('type', 'string');
                    $propbag->add('name', PLUGIN_LINKS_OPENALL);
                    $propbag->add('description', PLUGIN_LINKS_OPENALL_BLAHBLAH);
                    $propbag->add('default', PLUGIN_LINKS_OPENALL_DEFAULT);
                }
                break;

            case 'closeAllText':
                if($this->get_config('style') == "dtree")  {
                    $propbag->add('type', 'string');
                    $propbag->add('name', PLUGIN_LINKS_CLOSEALL);
                    $propbag->add('description', PLUGIN_LINKS_CLOSEALL_BLAHBLAH);
                    $propbag->add('default', PLUGIN_LINKS_CLOSEALL_DEFAULT);
                }
                break;

            case 'showOpenAndCloseLinks':
                if($this->get_config('style') == "dtree")  {
                    $propbag->add('type', 'boolean');
                    $propbag->add('name', PLUGIN_LINKS_SHOW);
                    $propbag->add('description', PLUGIN_LINKS_SHOW_BLAHBLAH);
                    $propbag->add('default', 'true');
                }
                break;

            case 'locationOfOpenAndClose':
                if($this->get_config('style') == "dtree")  {
                    $propbag->add('type', 'radio');
                    $propbag->add('name', PLUGIN_LINKS_LOCATION);
                    $propbag->add('description', PLUGIN_LINKS_LOCATION_BLAHBLAH);
                    $propbag->add('radio',  array(
                        'value' => array('top', 'bottom'),
                        'desc'  => array(PLUGIN_LINKS_LOCATION_TOP, PLUGIN_LINKS_LOCATION_BOTTOM)
                        ));
                    $propbag->add('default', 'top');
                }
                break;

            case 'useSelection':
                if($this->get_config('style') == "dtree")  {
                    $propbag->add('type', 'boolean');
                    $propbag->add('name', PLUGIN_LINKS_SELECTION);
                    $propbag->add('description', PLUGIN_LINKS_SELECTION_BLAHBLAH);
                    $propbag->add('default', 'false');
                }
                break;

            case 'useCookies':
                if($this->get_config('style') == "dtree")  {
                    $propbag->add('type', 'boolean');
                    $propbag->add('name', PLUGIN_LINKS_COOKIE);
                    $propbag->add('description', PLUGIN_LINKS_COOKIE_BLAHBLAH);
                    $propbag->add('default', 'false');
                }
                break;

            case 'useLines':
                if($this->get_config('style') != "simp_css")  {
                    $propbag->add('type', 'boolean');
                    $propbag->add('name', PLUGIN_LINKS_LINE);
                    $propbag->add('description', PLUGIN_LINKS_LINE_BLAHBLAH);
                    $propbag->add('default', 'true');
                }
                break;

            case 'useIcons':
                if($this->get_config('style') != "simp_css")  {
                    $propbag->add('type', 'boolean');
                    $propbag->add('name', PLUGIN_LINKS_ICON);
                    $propbag->add('description', PLUGIN_LINKS_ICON_BLAHBLAH);
                    $propbag->add('default', 'true');
                }
                break;

            case 'useSVG':
                if($this->get_config('style') == "css")  {
                    $propbag->add('type', 'boolean');
                    $propbag->add('name', PLUGIN_LINKS_SVGICON);
                    $propbag->add('description', '');
                    $propbag->add('default', 'true');
                }
                break;

            case 'useStatusText':
                if($this->get_config('style') == "dtree")  {
                    $propbag->add('type', 'boolean');
                    $propbag->add('name', PLUGIN_LINKS_STATUS);
                    $propbag->add('description', PLUGIN_LINKS_STATUS_BLAHBLAH);
                    $propbag->add('default', 'true');
                }
                break;

            case 'closeSameLevel':
                if($this->get_config('style') == "dtree")  {
                    $propbag->add('type', 'boolean');
                    $propbag->add('name', PLUGIN_LINKS_CLOSELEVEL);
                    $propbag->add('description', PLUGIN_LINKS_CLOSELEVEL_BLAHBLAH);
                    $propbag->add('default', 'false');
                }
                break;

            case 'use_description':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_LINKS_USEDESC);
                $propbag->add('description', PLUGIN_LINKS_USEDESC_BLAHBLAH);
                $propbag->add('default', 'false');
                break;

            case 'target':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_LINKS_TARGET);
                $propbag->add('description', PLUGIN_LINKS_TARGET_BLAHBLAH);
                $propbag->add('default', '_blank');
                $propbag->add('lang_direction', 'ltr');
                break;

            case 'style':
                $select = array();
                $select["dtree"] = PLUGIN_LINKLIST_OUTSTYLE_DTREE;
                $select["css"] = PLUGIN_LINKLIST_OUTSTYLE_CSS;
                $select["simp_css"] = PLUGIN_LINKLIST_ORDER_OUTSTYLE_SIMP_CSS;
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_LINKS_OUTSTYLE);
                $propbag->add('description', PLUGIN_LINKS_OUTSTYLE_BLAHBLAH);
                $propbag->add('select_values', $select);
                $propbag->add('default', 'dtree');
                break;

            case 'imgdir':
                if($this->get_config('style') != "simp_css")  {
                    $propbag->add('type', 'string');
                    $propbag->add('name', PLUGIN_LINKS_IMGDIR);
                    $propbag->add('description', PLUGIN_LINKS_IMGDIR_BLAHBLAH);
                    $propbag->add('default', $serendipity['baseURL'] . 'plugins/' . basename(dirname(__FILE__)));
                }
                break;

            case 'category_default_open':
                if($this->get_config('style') != "simp_css")  {
                    $propbag->add('type', 'radio');
                    $propbag->add('name', PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME);
                    $propbag->add('description', PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_DESC);
                    $propbag->add('radio',
                        array( 'value' => array('closed', 'open'),
                               'desc'  => array(PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_CLOSED, PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_OPEN)
                        ));
                    $propbag->add('radio_per_row', '2');
                    $propbag->add('default', 'closed');
                }
                break;

            case 'call_markup':
                if($this->get_config('style') != "dtree")  {
                    $propbag->add('type', 'boolean');
                    $propbag->add('name', PLUGIN_LINKS_CALLMARKUP);
                    $propbag->add('description', PLUGIN_LINKS_CALLMARKUP_BLAHBLAH);
                    $propbag->add('default', 'false');
                }
                break;

             default:
                    return false;
        }
        return true;
    }

    function decode($string) {
        if (LANG_CHARSET != 'UTF-8') {
            return utf8_decode($string);
        }

        return $string;
    }

    function generate_content(&$title)
    {
        global $serendipity;

        $title = $this->get_config('title');
        if(!$this->get_config('directxml')) {
            serendipity_plugin_api::hook_event('plugins_linklist_input', $linkcode);
            $this->set_config('links',$linkcode['links']);
        }
        $plugin_dir = basename(dirname(__FILE__));

        $links = $this->get_config('links');
        $style = $this->get_config('style');

        if ($this->get_config('cache') == 'yes') {
            if (@include_once("Cache/Lite.php")) {
                $xml_hash = md5($links.$style);
                $cache_obj = new Cache_Lite( array('cacheDir' => $serendipity['serendipityPath'].'templates_c/','automaticSerialization' => true));
                $old_hash = $cache_obj->get('linklist_xmlhash');
                if ($xml_hash == $old_hash) {
                    $output = $cache_obj->get('linklist_html');
                } else {
                    $output = $this->gen_output($links,$style);
                    $cache_obj->save($output,'linklist_html');
                    $cache_obj->save($xml_hash,'linklist_xmlhash');
                } 
            } else {
                $output = $this->gen_output($links,$style);
            }
         } else {
             $output = $this->gen_output($links,$style);
         }
        echo $output;

    }

    function gen_output($links, $style) {
        global $serendipity;
        $imgdir = $this->get_config('imgdir');
        $use_descrip = $this->get_config('use_description',false);


        /* XML definitaion */
        $xml = xml_parser_create('UTF-8');
        $linkxml = serendipity_utf8_encode($links);
        xml_parse_into_struct($xml, '<list>' . $linkxml . '</list>', $struct, $index);
        xml_parser_free($xml);

        if ($imgdir === 1 OR $imgdir === "true" OR $imgdir === true OR $imgdir === "") {
            $imgdir = $serendipity['baseURL'] . 'plugins/' . $plugin_dir;
        }

        $str  =  $this->get_config('prepend_text');
        $str .= "\n\n";
        if ($style == "dtree") {
            $str .= "\n".'<script src="' . $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/lldtree.js" type="text/javascript"></script>'."\n";

            if ($this->get_config('showOpenAndCloseLinks')=='true' && $this->get_config('locationOfOpenAndClose')=='top'){
                $str .= '<p><a href="javascript: d.openAll();">'.$this->get_config('openAllText').'</a> | <a href="javascript: d.closeAll();">'.$this->get_config('closeAllText').'</a></p>';
            }

            $str .= '<script type="text/javascript">
            <!--
            d = new dTree("d","'.$imgdir.'");'."\n";

            /* configuration section*/
            if ($this->get_config('useSelection') != true) $str.='d.config.useSelection=false;'."\n";
            if ($this->get_config('useCookies') != true) $str.='d.config.useCookies=false;'."\n";
            if ($this->get_config('useLines') != true) $str.='d.config.useLines=false;'."\n";
            if ($this->get_config('useIcons') != true) $str.='d.config.useIcons=false;'."\n";
            if ($this->get_config('useStatusText') == true) $str.='d.config.useStatusText=true;'."\n";
            if ($this->get_config('closeSameLevel') == true) $str.='d.config.closeSameLevel=true;'."\n";
            $my_target = $this->get_config('target');
            if (!empty($my_target)) {
                $str .= 'd.config.target="'.$my_target.'";'."\n";
            }

            /* Add Directory and Links */
            $str .= 'd.add(0,-1,"'.$this->get_config('top_level').'");'."\n";

            for($level[]=0, $i=1, $j=1; isset($struct[$i]); $i++, $j++){
                if(isset($struct[$i]['type'])){
                    if($struct[$i]['type'] == 'open' && strtolower($struct[$i]['tag']) == 'dir'){
                        $str .= 'd.add('.$j.','.$level[count($level)-1].',"'.$this->decode($struct[$i]['attributes']['NAME']).'");'."\n";
                        $level[] = $j;
                    }
                    else if($struct[$i]['type'] == 'close' && strtolower($struct[$i]['tag']) == 'dir'){
                        $dump=array_pop($level);
                    }
                    else if($struct[$i]['type']=='complete' && strtolower($struct[$i]['tag'])=='link'){
                        if ((isset($struct[$i]['attributes']['NAME'])) && ($struct[$i]['attributes']['NAME'] != "") && ($use_descrip)) {
                           $title_text = $this->decode($struct[$i]['attributes']['DESCRIP']);
                        } else {
                           $title_text = $struct[$i]['attributes']['NAME'];
                        } 
                        $str .= 'd.add('.$j.','.$level[count($level)-1].',"'.$this->decode($struct[$i]['attributes']['NAME']).'","'.$this->decode($struct[$i]['attributes']['LINK']).'","'.$title_text.'");'.$delimiter;
                    }
                }
            }

            $str .= 'document.write(d);
            //-->
            </script>';

            if($this->get_config('showOpenAndCloseLinks')=='true' && $this->get_config('locationOfOpenAndClose')=='bottom'){
                $str.='<p><a href="javascript: d.openAll();">'.$this->get_config('openAllText').'</a> | <a href="javascript: d.closeAll();">'.$this->get_config('closeAllText').'</a></p>';
            }
        } else {

            if($this->get_config('call_markup') != 'true') {
                $delimiter = "\n";
            } else {
                $delimiter = "";
            }
            if ($this->get_config('style') == "simp_css")  {
                $lessformatting = TRUE;
            } else {
                $lessformatting = FALSE;
            }
            //Parse it to a simple array
            $link_array = array();
            $dirname = array();
            $level = array();
            $dir_array[''] = array('dirname' => '','level' => 1,linkcount => 0,'links' => $link_array,'dircount' => 0,'directories' => $link_array);
            for($level[] = 0, $i=1, $j=1; isset($struct[$i]); $i++, $j++){
                if (isset($struct[$i]['type'])){
                    if($struct[$i]['type'] == 'open' && strtolower($struct[$i]['tag']) == 'dir'){
                        $dir_array[$dirname[0]]['directories'][] = $this->decode($struct[$i]['attributes']['NAME']);
                        $dir_array[$dirname[0]]['dircount']++;
                        array_unshift($dirname, $this->decode($struct[$i]['attributes']['NAME']));
                        array_unshift($level,$j);
                        $dir_array[$dirname[0]] = array('dirname' => $dirname[0],'level' => count($level),'linkcount' => 0,'links' => $link_array,'dircount' => 0,'directories' => $link_array);
                    } else if($struct[$i]['type'] == 'close' && strtolower($struct[$i]['tag']) == 'dir'){
                        $dump=array_shift($dirname);
                        $dump=array_shift($level);
                    } else if($struct[$i]['type'] == 'complete' && strtolower($struct[$i]['tag']) == 'link'){
                        $dir_array[$dirname[0]]['linkcount']++;
                        if (count($level) == 0) {
                            $level_pass = 1;
                        } else {
                            $level_pass = count($level)+1;
                        }
                        $basic_array = array('linkloc' => $this->decode($struct[$i]['attributes']['LINK']),'name' => $this->decode($struct[$i]['attributes']['NAME']),'descr' => $this->decode($struct[$i]['attributes']['DESCRIP']),'level' => $level_pass,'dirname' => $dirname,'hcard' => $this->decode($struct[$i]['attributes']['HCARD']),'rel' => $this->decode($struct[$i]['attributes']['REL']));
                        $dir_array[$dirname[0]]['links'][] = $basic_array;
                    }
                }
            }
            /* ???
            //Process array into output
            if ($this->get_config('useIcons')) {
            } else {
            }
            */
            $imagear['imgdir'] = $imgdir;
            $imagear['uselines'] = $this->get_config('useLines');
            $imagear['useicons'] = $this->get_config('useIcons');
            if ($imagear['useicons']) {
                $imagear['folder']      = '/img/folder.gif';
                $imagear['folderopen']  = '/img/folderopen.gif';
                $imagear['page']        = '/img/page.gif';
            }
            if ($this->get_config('useLines')) {
                $imagear['line']        = '/img/line.gif';
                $imagear['join']        = '/img/join.gif';
                $imagear['joinBottom']  = '/img/joinbottom.gif';
                $imagear['plus']        = '/img/plus.gif';
                $imagear['plusBottom']  = '/img/plusbottom.gif';
                $imagear['minus']       = '/img/minus.gif';
                $imagear['minusBottom'] = '/img/minusbottom.gif';
                $imagear['empty_image'] = '/img/empty.gif';
            } else {
                $imagear['line']        = '/img/empty.gif';
                $imagear['join']        = '/img/empty.gif';
                $imagear['joinBottom']  = '/img/empty.gif';
                $imagear['plus']        = '/img/nolines_plus.gif';
                $imagear['plusBottom']  = '/img/nolines_plus.gif';
                $imagear['minus']       = '/img/nolines_minus.gif';
                $imagear['minusBottom'] = '/img/nolines_minus.gif';
                $imagear['empty_image'] = '/img/empty.gif';
            }

            if (!$lessformatting) {
                $str .= '<script src="'.$serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '').'plugin/linklist.js" type="text/javascript"></script>'."\n";
            }
            $class = !$lessformatting ? 'csslist' : 'simple';
            $str .= '<div class="linklist"><ul class="'. $class .'">'.$delimiter;
            $more_track = array();
            $str .= $this->build_tree($dir_array, "", $imagear, $more_track, $strtemp, $lessformatting, $delimiter, $use_descrip);
            $str .= '</ul></div>';
        }

        $str .= $this->get_config('append_text');

        if ($this->get_config('call_markup') == 'true') {
            $entry = array('html_nugget' => $str);
            serendipity_plugin_api::hook_event('frontend_display', $entry);
            return $entry['html_nugget'];
        } else {
            return $str;
        }
    }


    function cleanup()  {

        $cache = $this->get_config('cache');
        if ($this->get_config('cache') == 'no') {
            if (@include_once("Cache/Lite.php")) {
                $cache_obj = new Cache_Lite( array('cacheDir' => $serendipity['serendipityPath'].'templates_c/','automaticSerialization' => true));
                @$cache_obj->remove('linklist_html');
                @$cache_obj->remove('linklist_xmlhash');
            }
        }
        $setdata = array('display'  => $this->get_config('display'),
                         'category' => $this->get_config('category'),
                         'style'    => $this->get_config('style'),
                         'cache'    => $cache);

        if($this->get_config('directxml') != 'true') {
           $blah = $this->get_config('display');
            if (!isset($blah)) {
                $this->set_config('display','category');
            }
            $setdata['enabled'] =  'true';
            $setdata['links']   =  $this->get_config('links');
        } else {
            $setdata['enabled'] = 'false';
        }
        serendipity_plugin_api::hook_event('plugins_linklist_conf',$setdata);
        if ($setdata['changed'] == 'true') {
            $this->set_config('links',$setdata['links']);
        }

    }

    function build_tree ($fullarray, $rootdir, $imagearray, $more_track, $strtemp = "", $lessformatting = NULL, $delimiter = "\n", $use_descrip = false) {
        $imgdir    = $imagearray['imgdir'];
        $uselines  = $imagearray['uselines'];
        $useicons  = $imagearray['useicons'];
        $directory = $fullarray[$rootdir];
        extract($directory);
        if (($this->get_config('category_default_open') != 'closed') || $lessformatting) {
            $link_block_style = 'style="display: block;"';
            $default_cat_img = $imagearray['minus'];
            $default_cat_img_bottom = $imagearray['minusBottom'];
        } else {
            $link_block_style = 'style="display: none;"';
            $default_cat_img = $imagearray['plus'];
            $default_cat_img_bottom = $imagearray['plusBottom'];
        }
        $tempcount = 0;
        foreach($directories as $sub) {
            $safename = preg_replace('@[^a-z0-9]@i', '_',$sub);
            if ($safename != "") {
                $tempcount++;
                $strtemp .= '<li id="submenu_'.$safename.'_start">';
                if (($tempcount != $dircount || $linkcount > 0) && ($fullarray[$sub]['linkcount'] > 0)) {
                    $start_image = $default_cat_img;
                    $more_track[$level] = true;
                } else {
                    $start_image = $default_cat_img_bottom ;
                    $more_track[$level] = false;
                }

                $base_image_string = '';
                if ($lessformatting) {
                    $strtemp .= '<span class="menu_title" id="submenu_'.$safename.'_parent">'.$folder_image.$sub.'</span><br /><ul id="submenu_'.$safename.'" class="simple" '.$link_block_style .'>'.$delimiter;
                } else {
                    for ($i = 1; $i < $level; $i++) {
                        if ($uselines && $more_track[$i]) {
                            $base_image_string .= '<img src="'.$imgdir.$imagearray['line'].'" alt="" />';
                        } else {
                            $base_image_string .= '<img src="'.$imgdir.$imagearray['empty_image'].'" alt="" />';
                        }
                    }
                    if ($imagearray['useicons']) {
                        $folder_image = '<img id="submenu_'.$safename.'_folder" src="'.$imgdir.$imagearray['folder'].'" alt="" />';
                    } else {
                        $folder_image = '';
                    }
                    $strtemp .= $base_image_string.'<a class="folder" href="javascript: hide_unhide(\'submenu_'.$safename.'\',\''.$imgdir.'\',\''.$uselines.'\',\''.$useicons.'\',\''.$more_track[$level].'\');"><img id="submenu_'.$safename.'_image" src="'.$imgdir.$start_image .'" alt="" /><span class="menu_title">'.$folder_image.$sub.'</span></a><ul id="submenu_'.$safename.'" class="csslist" '.$link_block_style .'>'.$delimiter;
                }
                $strtemp .= $this->build_tree($fullarray, $sub, $imagearray, $more_track, $str, $lessformatting, $delimiter, $use_descrip);
                $strtemp .= '</ul></li>';
            }
        }
        $my_target     = $this->get_config('target');
        $target_string = '';
        if (!empty($my_target)) {
            $target_string = ' target="'.$my_target.'"';
        }
        $base_image_string = '';
        $image_string = '';
        if ($lessformatting != 1) {
            for ($i = 1; $i < $level; $i++) {
                if ($uselines && $more_track[$i]) {
                    $base_image_string .= '<img src="'.$imgdir.$imagearray['line'].'" alt="" />';
                } else {
                    $base_image_string .= '<img src="'.$imgdir.$imagearray['empty_image'].'" alt="" />';
                }
            }
            if ($useicons) {
                if (serendipity_db_bool($this->get_config('useSVG', true))) {
                    $page_icon = '<img class="svg"/>';
                } else {
                    $page_icon = '<img src="'.$imgdir.$imagearray['page'].'" alt="" />';
                }
            } else {
                $page_icon = '';
            }
        }
        if (isset($links)){
            foreach ($links as $link){
                $linkcount--;
                if (!$lessformatting) {
                    if ($linkcount > 0) {
                        $image_string = $base_image_string.'<img src="'.$imgdir.$imagearray['join'].'" alt="" />';
                    } else {
                        $image_string = $base_image_string.'<img src="'.$imgdir.$imagearray['joinBottom'].'" alt="" />';
                    }
                }
                if ((isset($link['descr'])) && ($link['descr'] != "") && ($use_descrip)) {
                    $title_text = $link['descr'];
                } else {
                    $title_text = $link['name'];
                } 
                $strtemp .= '<li class="menuitem'.(($link['hcard'])?' vcard':'').'">';
                $strtemp .= $image_string.$page_icon.'<a class="link'.(($link['hcard'])?' url '.$link['hcard']:'').'" '.(($link['rel'])?'rel="'.$link['rel'].'"':'').' href="'.$link['linkloc'].'" '.$target_string.' title="'.$title_text.'">'.$link['name'].'</a></li>'.$delimiter;
            }
        }
        return $strtemp;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
