<?php

class menalto_sidebar extends subplug_sidebar {

    function introspect_custom()
    {
        return array('menalto_path', 'menalto_file', 'menalto_repeat', 'menalto_rotate_time', 'menalto_gversion','g2_type','itemId','g2_maxsize','g2_linkTarget','g2_show','menalto_next_update','menalto_cache_output');
    }

    function introspect_config_item_custom($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        TITLE);
                $propbag->add('description', TITLE);
                $propbag->add('default',     '');
                break;

            case 'itemId':
                if ($this->get_config('menalto_gversion',1) == 2) {
                    $propbag->add('type',        'string');
                    if ($this->get_config('g2_type',1) == 4) {
                        $propbag->add('name',        PLUGIN_GALLERYRANDOMBLOCK_SINGLE_ITEMID);
                        $propbag->add('description', PLUGIN_GALLERYRANDOMBLOCK_SINGLE_ITEMID_DESC);
                    } else {
                        $propbag->add('name',        PLUGIN_GALLERYRANDOMBLOCK_ITEMID);
                        $propbag->add('description', PLUGIN_GALLERYRANDOMBLOCK_ITEMID_DESC);
                    }
                    $propbag->add('default',     '');
                }
                break;

            case 'menalto_path':
                if ((int)$serendipity['serendipityUserlevel'] < (int)USERLEVEL_ADMIN) {
                    return false;
                }
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GALLERYRANDOMBLOCK_URL_NAME);
                $propbag->add('description', PLUGIN_GALLERYRANDOMBLOCK_URL_DESC);
                $propbag->add('default',     $serendipity['baseURL'] . '/gallery/');
                break;

            case 'menalto_file':
                if ((int)$serendipity['serendipityUserlevel'] < (int)USERLEVEL_ADMIN) {
                    return false;
                }
                if ($this->get_config('menalto_gversion',1) == 1) {
                    $propbag->add('type',        'string');
                    $propbag->add('name',        PLUGIN_GALLERYRANDOMBLOCK_FILE_NAME);
                    $propbag->add('description', '');
                    $propbag->add('default',     'block-random.php');
                }
                break;

            case 'menalto_repeat':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GALLERYRANDOMBLOCK_NUMREPEAT_NAME);
                $propbag->add('description', PLUGIN_GALLERYRANDOMBLOCK_NUMREPEAT_DESC);
                $propbag->add('default',     '1');
                break;

            case 'menalto_rotate_time':
                  $propbag->add('type',        'string');
                  $propbag->add('name',        PLUGIN_SIDEBAR_MEDIASIDEBAR_ROTATETIME_NAME);
                  $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_ROTATETIME_DESC);
                  $propbag->add('default',     '60');
            break;
                
            case 'menalto_gversion':
                $propbag->add('type',        'select');
                $propbag->add('name',        PLUGIN_GALLERYRANDOMBLOCK_VERSION);
                $propbag->add('description', '');
                $propbag->add('default',     1);
                $propbag->add('select_values', array(
                                                1  => '1.x',
                                                2  => '2.x'
                ));
                
                break;

            case 'g2_type':
                if ($this->get_config('menalto_gversion','1') == '2') {
                    $propbag->add('type',        'select');
                    $propbag->add('name',        PLUGIN_GALLERYRANDOMBLOCK_G2DISPLAYTYPE);
                    $propbag->add('description', '');
                    $propbag->add('default',     1);
                    $propbag->add('select_values', array(
                                                    1  => PLUGIN_GALLERYRANDOMBLOCK_G2DISPLAYTYPE_RAND,
                                                    2  => PLUGIN_GALLERYRANDOMBLOCK_G2DISPLAYTYPE_RENCENT,
                                                    3  => PLUGIN_GALLERYRANDOMBLOCK_G2DISPLAYTYPE_VIEWED,
                                                    4  => PLUGIN_GALLERYRANDOMBLOCK_G2DISPLAYTYPE_SPECIFIC
                    ));
                }
                break;


            case 'g2_maxsize':
                if ($this->get_config('menalto_gversion',1) == 2) {
                    $propbag->add('type',        'string');
                    $propbag->add('name',        PLUGIN_GALLERYRANDOMBLOCK_MAXSIZE);
                    $propbag->add('description', PLUGIN_GALLERYRANDOMBLOCK_MAXSIZE_DESC);
                    $propbag->add('default',     '');
                }
                break;

            case 'g2_linkTarget':
                if ($this->get_config('menalto_gversion',1) == 2) {
                    $propbag->add('type',        'string');
                    $propbag->add('name',        PLUGIN_GALLERYRANDOMBLOCK_LINKTARGET);
                    $propbag->add('description', PLUGIN_GALLERYRANDOMBLOCK_LINKTARGET_DESC);
                    $propbag->add('default',     '');
                }
                break;

            case 'g2_show':
                if ($this->get_config('menalto_gversion',1) == 2) {
                    $propbag->add('type',        'string');
                    $propbag->add('name',        PLUGIN_GALLERYRANDOMBLOCK_SHOWDETAIL);
                    $propbag->add('description', PLUGIN_GALLERYRANDOMBLOCK_SHOWDETAIL_DESC);
                    $propbag->add('default',     'title, date, views, owner, heading');
                }
                break;
            default:
                    return false;
        }
        return true;
    }

    function generate_content_custom(&$title) {
        global $serendipity;

        $update = true;
        $rotate_time = (int)$this->get_config('menalto_rotate_time');
        $next_update = $this->get_config('menalto_next_update');

        if (@include_once("Cache/Lite.php")) {
            $cache_obj = new Cache_Lite( array('cacheDir' => $serendipity['serendipityPath'].'templates_c/','automaticSerialization' => true));
            $cache_output = $cache_obj->get('menaltosidebar_cache');
        } else {
            $cache_output = $this->get_config('menalto_cache_output','');
        }
        if ($rotate_time !=0 ) {
            if ($next_update > time()) {
               $update = false;
            } else {
               $next_update = $this->calc_update_time($rotate_time,$next_update);
               $this->set_config('menalto_next_update',$next_update);
            }
        }
        $title = $this->get_config('title', $this->title);
        if ($update || $cache_output == '') {

            $path  = $this->get_config('menalto_path');
            $file  = $this->get_config('menalto_file');
            $repeat = $this->get_config('menalto_repeat');

            if (!is_numeric($repeat)) {
                $repeat = 1;
            }

            if (substr($path,-1) != '/') {
                $path .= '/';
            }

            if ((int)$this->get_config('menalto_gversion') === 2) {
                $file = 'main.php?g2_view=imageblock:External&g2_itemFrame=none';
                $gid  = $this->get_config('itemId');
                if ($gid > 0) {
                    $file .='&g2_itemId=' . $gid;
                }
                switch ((int)$this->get_config('g2_type')) {
                    case 4:
                        $file .='&g2_blocks=specificItem';
                    break;
                    case 3:
                        $file .='&g2_blocks=viewedImage';
                    break;
                    case 2:
                       $file .='&g2_blocks=recentImage';
                    break;
                    case 1:
                    default:
                        $file .='&g2_blocks=randomImage';
                    break;
                }
  
                $maxsize = (int)$this->get_config('g2_maxsize','');
                if ($maxsize > 0) {
                    $file .='&g2_maxSize=' . $maxsize;
                }

                $linktarget = $this->get_config('g2_linkTarget','');
                if ($linktarget != '') {
                    $file .='&g2_linkTarget=' . $linktarget;
                }

                $show_detail = $this->get_config('g2_show','');
                if ($show_detail != '') {
                    $details = explode(',',$show_detail);
                    foreach ($details as $detail) {
                        $details_string = $details_string . trim($detail) . '|';
                    }
                    $details_string = substr($details_string,0,strlen($details_string)-1);
                    $file .='&g2_show=' . $details_string;
                    if ($maxsize > 0) {
                        $file .='|fullSize';
                    }
                } else {
                    if ($maxsize > 0) {
                        $file .='&g2_show=fullSize';
                    }
                }
            }

            if (empty($file)) {
                $file = 'block-random.php';
            }

            $output_str = '';
            for ($i=1; $i <= $repeat; $i++) {
                 $options = array();
                 require_once S9Y_PEAR_PATH . 'HTTP/Request.php';
                 if (function_exists('serendipity_request_start')) {
                     serendipity_request_start();
                 }
                 $req = new HTTP_Request($path.$file,$options);
                 $req_result = $req->sendRequest();
                 if ( PEAR::isError( $req_result)) {
                     $output_str = $output_str. PLUGIN_GALLERYRANDOMBLOCK_ERROR_CONNECT . "<br />\n";
                 } else {
                     $res_code = $req->getResponseCode();
                     if ($res_code != "200") {
                         $output_str = $output_str. sprintf( PLUGIN_GALLERYRANDOMBLOCK_ERROR_HTTP . "<br />\n", $res_code);
                     } else {
                         $output_str = $output_str. $req->getResponseBody();
                     }
                 }
                 if ($i < $repeat) {
                     $output_str = $output_str. '<hr />';
                 }
            }
            if (class_exists('Cache_Lite') && is_object($cache_obj)) {
                $cache_obj->save($output_str,'menaltosidebar_cache');
            } else {
                $this->set_config('menalto_cache_output',$output_str);
            }
        } else {
            $output_str = $cache_output;
        }
        echo $output_str;
    }

    function calc_update_time ($rotate_time,$last_update) {
        $next_time = mktime(date("H"), date("i"), 0, date("m"), date("d"), date("Y"));
        if ($last_update == '') {
            $last_update = mktime(date("H"), 0, 0, date("m"), date("d"), date("Y"));
        }
        if ($rotate_time !=0 ) {
            if ($rotate_time > 1440) {
               $rotate_time = 1440;
            }
            $day = (int) ($rotate_time / 1440);
            $hours = (int) (($rotate_time % 1440)/ 60);
            $minutes = (int) ((($rotate_time % 1440) % 60)/1);
            while ($next_time < time()) {
                $next_time  = mktime(date("H",$last_update)+$hours, date("i",$last_update)+$minutes, 0, date("m",$last_update), date("d",$last_update)+ $day, date("Y",$last_update));
                $last_update = $next_time;
            }
        }
        return $next_time;

    }

}
?>