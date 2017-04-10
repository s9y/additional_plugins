<?php #  #

//
// Credit to Matthew Groeninger, whose linklist plugin was the basis for this
// plugin.  Most of the following code is actually his, and was only marginally
// modified by me.
//
// I also borrowed some ideas on GD manipulations in PHP from Garvin Hicking
// and Sebastian Nohn's SpamBlock plugin.
//
// Steve Tonnesen.
//

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

@define('PLUGIN_EVENT_TODOLIST_DBVERSION', '1.13');

class serendipity_event_todolist extends serendipity_event {

    var $title = PLUGIN_EVENT_TODOLIST_TITLE;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',        PLUGIN_EVENT_TODOLIST_TITLE);
        $propbag->add('description', PLUGIN_EVENT_TODOLIST_DESC);
        $propbag->add('event_hooks',  array('backend_sidebar_entries_event_display_percentagedone'  => true,
                                            'external_plugin'                                       => true,
                                            'backend_sidebar_entries'                               => true,
                                            'css_backend'                                           => true
                                            ));
        $propbag->add('author', 'Steven Tonnesen, Matthias Mees');
        $propbag->add('version', '1.25.1');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('configuration', array('note','title','display','category','cache','colorid','barlength','categorybarlength','barheight', 'font', 'fontsize','whitetextborder','outsidetext','backgroundcolor','cacheimages','numentries'));
        $propbag->add('stackable',     true);
        $propbag->add('groups', array('FRONTEND_FEATURES'));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;
        switch ($name) {
            case 'note':
                $propbag->add('type',   'content');
                $propbag->add('default', PLUGIN_EVENT_TODOLIST_DEFAULT_NOTE);
                break;

            case 'display':
                $select = array();
                $select["alpha"]        = PLUGIN_EVENT_TODOLIST_ORDER_ALPHA;
                $select["category"]     = PLUGIN_EVENT_TODOLIST_ORDER_CATEGORY;
                $select["js_category"]  = PLUGIN_EVENT_TODOLIST_ORDER_JSCATEGORY;
                $select["order_num"]    = PLUGIN_EVENT_TODOLIST_ORDER_NUM_ORDER;
                $select["progress"]     = PLUGIN_EVENT_TODOLIST_ORDER_PROGRESS_ASC;
                $select["progressdesc"] = PLUGIN_EVENT_TODOLIST_ORDER_PROGRESS_DESC;
                $select["datedesc"]     = PLUGIN_EVENT_TODOLIST_ORDER_DATE_DESC;
                $select["dateacs"]      = PLUGIN_EVENT_TODOLIST_ORDER_DATE_ACS;
                $propbag->add('type',          'select');
                $propbag->add('name',          PLUGIN_EVENT_TODOLIST_ORDER);
                $propbag->add('description',   PLUGIN_EVENT_TODOLIST_ORDER_DESC);
                $propbag->add('select_values', $select);
                break;

            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        TITLE);
                $propbag->add('description', PLUGIN_EVENT_TODOLIST_TITLEDESC);
                $propbag->add('default',     '');
                break;

            case 'colorid':
                $select = array();
                $q = "SELECT *
                        FROM {$serendipity['dbPrefix']}project_colors
                    ORDER BY color_name ASC";
                $colors = serendipity_db_query($q);

                foreach($colors as $color) {
                    $select[$color['colorid']] = $color['color_name'];
                }
                $propbag->add('type',          'select');
                $propbag->add('name',          PLUGIN_EVENT_TODOLIST_COLORCONFIG);
                $propbag->add('description',   PLUGIN_EVENT_TODOLIST_COLORCONFIGDESC);
                $propbag->add('select_values', $select);
                break;

            case 'cacheimages':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_TODOLIST_CACHEIMAGE);
                $propbag->add('description', PLUGIN_EVENT_TODOLIST_CACHEIMAGEDESC);
                $propbag->add('default',     'true');
                break;

            case 'barlength':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_TODOLIST_BARLENGTH);
                $propbag->add('description', PLUGIN_EVENT_TODOLIST_BARLENGTHDESC);
                $propbag->add('default', '160');
                break;

            case 'barheight':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_TODOLIST_BARHEIGHT);
                $propbag->add('description', PLUGIN_EVENT_TODOLIST_BARHEIGHTDESC);
                $propbag->add('default',     '20');
                break;

            case 'font':
                $select = array();
                $select["default"] = PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_DEFAULT;
                $this->pushFiles($select, dirname(__FILE__) . '/fonts/', '[^/\\\\]+\.ttf$');

                $propbag->add('type',          'select');
                $propbag->add('name',          PLUGIN_EVENT_TODOLIST_FONT);
                $propbag->add('description',   PLUGIN_EVENT_TODOLIST_FONTDESC);
                $propbag->add('select_values', $select);
                break;

            case 'fontsize':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_TODOLIST_FONTSIZE);
                $propbag->add('description', PLUGIN_EVENT_TODOLIST_FONTSIZEDESC);
                $propbag->add('default',     '12');
                break;

            case 'categorybarlength':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_TODOLIST_CATBARLENGTH);
                $propbag->add('description', PLUGIN_EVENT_TODOLIST_CATBARLENGTHDESC);
                $propbag->add('default',     '100');
                break;

            case 'whitetextborder':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_TODOLIST_WHITETEXTBORDER);
                $propbag->add('description', PLUGIN_EVENT_TODOLIST_WHITETEXTBORDERDESC);
                $propbag->add('default',     'false');
                break;

            case 'outsidetext':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_TODOLIST_OUTSIDETEXT);
                $propbag->add('description', PLUGIN_EVENT_TODOLIST_OUTSIDETEXTDESC);
                $propbag->add('default',     'false');
                break;

            case 'backgroundcolor':
                $propbag->add('type',          'string');
                $propbag->add('name',          PLUGIN_EVENT_TODOLIST_BACKGROUNDCOLOR);
                $propbag->add('description',   PLUGIN_EVENT_TODOLIST_BACKGROUNDCOLORDESC);
                $propbag->add('default', 'ffffff');
                break;

            case 'numentries':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_TODOLIST_NUMENTRIES);
                $propbag->add('description', PLUGIN_EVENT_TODOLIST_NUMENTRIESDESC);
                $propbag->add('default',     '30');
                break;

            case 'category':
                 $propbag->add('type',        'radio');
                 $propbag->add('name',        PLUGIN_EVENT_TODOLIST_CATEGORY_NAME);
                 $propbag->add('description', PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_DESC);
                 $propbag->add('radio',
                     array('value' => array('custom', 'default'),
                           'desc'  => array(PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_CUSTOM, PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_DEFAULT)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default',       'custom');
                break;

            case 'cache':
                 $propbag->add('type',        'radio');
                 $propbag->add('name',        PLUGIN_EVENT_TODOLIST_CACHE_NAME);
                 $propbag->add('description', PLUGIN_EVENT_TODOLIST_CACHE_DESC);
                 $propbag->add('radio',
                     array('value' => array('yes', 'no'),
                           'desc'  => array(YES, NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'no');
                break;

            default:
               return false;
        }
        return true;
    }

    function pushFiles(&$select, $dir = '', $pattern = '') {
        if (!is_dir($dir)) {
            return;
        }

        $dh = opendir($dir);

        if (!$dh) {
            return;
        }

        while(($file = readdir($dh)) !== false) {
            if (preg_match('#' . $pattern . '#i', $file, $matches)) {
                $select[$file] = $file;
            }
        }

        return true;
    }

    function purgeCache() {
        global $serendipity;

        // Delete old cached images if more than 60 images are cached.
        // Only call this every now and then.
        if (mt_rand(1,20) != 5) {
            return true;
        }

        $tdir   = $serendipity['serendipityPath'] . '/' . PATH_SMARTY_COMPILE;
        $files  = array();
        $atimes = array();
        $this->pushFiles($files, $tdir, 'cache_todolist_progressimage');
        foreach($files AS $_filename) {
            $filename = $tdir . '/' . $_filename;
            $atimes[$filename] = fileatime($filename);
        }

        arsort($atimes);
        reset($atimes);
        $cachedfilecounter = 0;
        while (list($key,$val) = each($atimes)) {
            if ($cachedfilecounter++ > 60) {
                @unlink($key);
            }
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            if ($this->check_gd()) {
                $max_char = 5;
                $min_char = 3;
                $use_gd   = true;
            } else {
                $max_char = $min_char = 5;
                $use_gd   = false;
            }

            switch($event) {
                case 'backend_sidebar_entries_event_display_percentagedone':
                    if ($this->get_config('category') == 'custom' && $this->get_config('catbd')!= 'done') {
                        echo '<a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=percentagedone&amp;submit=create_custom">' . PLUGIN_EVENT_TODOLIST_CATDB_WARNING . '</a>';
                    }

                    if (isset($_POST['REMOVE'])) {
                        if (isset($_POST['serendipity']['project_to_remove'])) {
                            foreach ($_POST['serendipity']['project_to_remove'] as $key) {
                                $this->del_project($key);
                            }

                        } elseif (isset($_POST['serendipity']['category_to_remove'])) {
                            foreach ($_POST['serendipity']['category_to_remove'] as $key) {
                                $this->del_category($key);
                            }
                        } elseif (isset($_POST['serendipity']['color_to_remove'])) {
                            foreach ($_POST['serendipity']['color_to_remove'] as $key) {
                                $this->del_color($key);
                            }
                        }
                    }

                    if (isset($_POST['SAVE'])) {
                        foreach ((array)$_POST['serendipity']['project_to_recat'] AS $key => $row) {
                            $this->update_cat($key,$row);
                        }

                        foreach ((array)$_POST['serendipity']['color_to_rename'] AS $key => $row) {
                            $this->update_colorname($key,$row);
                        }

                        foreach ((array)$_POST['serendipity']['color_to_recolor1'] AS $key => $row) {
                            $this->update_color1($key,$row);
                        }

                        foreach ((array)$_POST['serendipity']['color_to_recolor2'] AS $key => $row) {
                            $this->update_color2($key,$row);
                        }

                        foreach ((array)$_POST['serendipity']['project_to_repercent'] AS $key => $row) {
                            $this->update_percent($key,$row);
                            if ($_POST['serendipity']['project_to_hide'][$key] == 1) {
                                $this->update_hidden($key,1);
                            } else {
                                $this->update_hidden($key,0);
                            }
                        }

                        foreach ((array)$_POST['serendipity']['project_to_reassign'] AS $key => $row) {
                            $this->update_entry($key,$row);
                        }

                        foreach ((array)$_POST['serendipity']['project_to_recolor'] AS $key => $row) {
                            $this->update_color($key,$row);
                        }

                        foreach ((array)$_POST['serendipity']['category_to_recolor'] AS $key => $row) {
                            $this->update_category_color($key,$row);
                        }
                    }

                    if (isset($_POST['ADD'])) {
                       if (isset($_POST['serendipity']['add_project']['project']) && isset($_POST['serendipity']['add_project']['project'])) {
                            $this->add_project($_POST['serendipity']['add_project']['project'],$_POST['serendipity']['add_project']['percentagecomplete'],$_POST['serendipity']['add_project']['desc'],$_POST['serendipity']['project_to_recat']['cat'],$_POST['serendipity']['add_project']['entry'],$_POST['serendipity']['add_project']['colorid']);
                       } elseif (isset($_POST['serendipity']['add_category']['title'])) {
                           $this->add_cat($_POST['serendipity']['add_category']['title'],$_POST['serendipity']['project_to_recat']['cat'],$_POST['serendipity']['add_category']['colorid']);
                       } elseif (isset($_POST['serendipity']['add_color']['title'])) {
                           $this->add_color($_POST['serendipity']['add_color']['title'],$_POST['serendipity']['add_color']['color1'],$_POST['serendipity']['add_color']['color2']);
                       }
                    }

                    if (isset($_POST['EDIT'])) {
                       if (isset($_POST['serendipity']['add_project']['project']) && isset($_POST['serendipity']['add_project']['project'])&& isset($_POST['serendipity']['add_project']['id'])) {
                            $this->update_project($_POST['serendipity']['add_project']['id'],$_POST['serendipity']['add_project']['project'],$_POST['serendipity']['add_project']['percentagecomplete'],$_POST['serendipity']['add_project']['desc'],$_POST['serendipity']['project_to_recat']['cat'],$_POST['serendipity']['add_project']['entry'],$_POST['serendipity']['add_project']['colorid']);
                       }
                    }

                    switch ($_GET['submit']){
                        case 'move up':
                            $this->move_up($_GET['serendipity']['project_to_move']);
                            break;

                        case 'move down':
                            $this->move_down($_GET['serendipity']['project_to_move']);
                            break;

                        case 'create_custom':
                            $this->create_cattable();
                            break;
                    }

                    if ($this->get_config('cache') == 'yes') {
                        $output = $this->generate_output();
                        $this->set_config('cached_output',$output);
                    }

                    if (isset($_GET['serendipity']['edit_project'])) {
                        $this->output_add_edit_projectadmin(TRUE, $_GET['serendipity']['edit_project']);
                    } elseif (isset($_GET['serendipity']['manage_category'])) {
                        $this->output_categoryadmin(TRUE, $_GET['serendipity']['edit_project']);
                    } elseif (isset($_GET['serendipity']['manage_colors'])) {
                        $this->output_colorsadmin(TRUE, $_GET['serendipity']['edit_project']);
                    } else {
                        $this->output_add_edit_projectadmin(FALSE);
                        $this->output_projectadmin();
                    }
                    return true;
                    break;

                case 'backend_sidebar_entries':
                    echo '<li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=percentagedone">' . PLUGIN_EVENT_TODOLIST_ADMINPROJECT . '</a></li>';
                    return true;
                    break;

                case 'css_backend':
                    echo file_get_contents(dirname(__FILE__) . '/todolist_backend.css');

                    break;

                case 'external_plugin':
                    $parts     = explode('_', $eventData);
                    if (!empty($parts[1])) {
                        $param = (int)$parts[1];
                        $param = preg_replace('/[^0-9\.]/','',$param);
                        $param = preg_replace('/^0+/','',$param);
                        if ($param < 0) {
                            $param = 0;
                        } elseif ($param > 100) {
                            $param = 100;
                        }
                    } else {
                        $param = 0;
                    }

                    if (!empty($parts[2])) {
                        $width = (int)$parts[2];
                        $width = preg_replace('/[^0-9\.]/','',$width);
                        $width = preg_replace('/^0+/','',$width);
                        if ($width > 2000) {
                            $width = 2000;
                        } elseif ($width < 10) {
                            $width = 10;
                        }
                    } else {
                        $width = 160;
                    }

                    if (!empty($parts[3])) {
                        $height = (int)$parts[3];
                        $height = preg_replace('/[^0-9\.]/','',$height);
                        $height = preg_replace('/^0+/','',$height);
                        if ($height > 2000) {
                            $height = 2000;
                        } elseif ($height < 2) {
                            $height = 2;
                        }
                    } else {
                        $height = 20;
                    }

                    if (!empty($parts[4])) {
                        $startcolor = $parts[4];
                    }

                    if (!empty($parts[5])) {
                        $endcolor = $parts[5];
                    }

                    if (!empty($parts[6])) {
                        $whitetextborder = $parts[6];
                    }

                    if (!empty($parts[7])) {
                        $fontsize = $parts[7];
                    }

                    if (!empty($parts[8])) {
                        $fontname = $parts[8];
                    }

                    if (!empty($parts[9])) {
                        $nocache = $parts[9];
                    }

                    if (!empty($parts[10])) {
                        $outsidetext = $parts[10];
                    }
                    if (!empty($parts[11])) {
                        $backgroundcolor = $parts[11];
                    }

                    $methods = array('percentage', 'colorwheel', 'hsvwheel', 'blank');

                    if (!in_array($parts[0], $methods)) {
                        return;
                    }

                    if ($parts[0] == 'hsvwheel') {
                        header('Content-Type: image/png');
                        $cap = dirname(__FILE__) . '/wheel/hsvwheel.png';
                        if (file_exists($cap)) {
                            echo file_get_contents($cap);
                        }
                        exit;
                    } elseif ($parts[0] == 'colorwheel') {
                        header('Content-Type: text/html');
                        $cap = dirname(__FILE__) . '/wheel/wheel.html';
                        if (file_exists($cap)) {
                            $filecontents = file_get_contents($cap);
                            $filecontents = preg_replace('/PLUGIN_EVENT_TODOLIST_COLORWHEEL_INSTRUCTIONS/',PLUGIN_EVENT_TODOLIST_COLORWHEEL_INSTRUCTIONS,$filecontents);
                            $filecontents = preg_replace('/PLUGIN_EVENT_TODOLIST_COLORWHEEL/',PLUGIN_EVENT_TODOLIST_COLORWHEEL,$filecontents);
                            echo $filecontents;
                        } else {
                            echo "<html><body>Couldn't find 'wheel.html' html file.</body></html>";
                        }
                        exit;
                    }

                    list($musec, $msec) = explode(' ', microtime());
                    $srand = (float) $msec + ((float) $musec * 100000);
                    srand($srand);
                    mt_srand($srand);

                    if ($use_gd) {
                        header('Content-Type: image/png');

                        if (strlen($fontname) > 0) {
                            $filefontname = $fontname;
                            $fontname = "fonts/" . basename($fontname);
                            $fontname = preg_replace('/----/','_',$fontname);
                            $font     = dirname(__FILE__) . '/' . $fontname;
                            if (!file_exists($font)) {
                                $fontname = "VeraSe.ttf";
                                $font     = dirname(__FILE__) . '/' . $fontname;
                            }
                        } else {
                            $fontname     = "VeraSe.ttf";
                            $filefontname = $fontname;
                            $font         = dirname(__FILE__) . '/' . $fontname;
                        }

                        if (!file_exists($font)) {
                            die(PLUGIN_EVENT_SPAMBLOCK_ERROR_NOTTF);
                        }

                        $image  = imagecreate($width, $height);


                        $white=imagecolorallocate($image, 255,255,255);
                        $black=imagecolorallocate($image, 30,30,30);
                        if (empty($backgroundcolor)) {
                            $backgroundcolor="ffffff";
                        }
                        $backgroundcolor = preg_replace('/[^0-9a-fA-F]/','',$backgroundcolor);
                        $bgcolor1=hexdec(substr($backgroundcolor,0,2));
                        $bgcolor2=hexdec(substr($backgroundcolor,2,2));
                        $bgcolor3=hexdec(substr($backgroundcolor,4,2));
                        $bgcolor = imagecolorallocate($image, $bgcolor1, $bgcolor2, $bgcolor3);
                        imagefilledrectangle($image,0,0,$width,$height,$bgcolor);
                        $originalwidth=$width;
                        if ($outsidetext==1) {
                            $bbox=imageftbbox($fontsize, 0, $font, "100%", array("linespacing" => 1));
                            $textwidth=$bbox[4];
                            $width=$width-($textwidth+5);
                        }
                        if (strlen($startcolor)==0 or strlen($endcolor)==0) {
                            $colorid=$this->get_config('colorid');
                            $q = 'SELECT    s.* FROM '.$serendipity['dbPrefix'].'project_colors AS s where s.colorid='.$colorid;

                            $colors = serendipity_db_query($q);
                            $startcolor=$colors[0]['color1'];
                            $endcolor=$colors[0]['color2'];
                        }
                        if (strlen($startcolor)==0 or strlen($endcolor)==0) {
                            $startcolor="ccccff";
                            $endcolor="3333bb";
                        }
                        $startcolor = preg_replace('/[^0-9a-fA-F]/','',$startcolor);
                        $endcolor = preg_replace('/[^0-9a-fA-F]/','',$endcolor);
                        $startcolor=substr($startcolor,0,6);
                        $endcolor=substr($endcolor,0,6);
                        $startcolor1=hexdec(substr($startcolor,0,2));
                        $startcolor2=hexdec(substr($startcolor,2,2));
                        $startcolor3=hexdec(substr($startcolor,4,2));
                        $endcolor1=hexdec(substr($endcolor,0,2));
                        $endcolor2=hexdec(substr($endcolor,2,2));
                        $endcolor3=hexdec(substr($endcolor,4,2));
                        $start=20;
                        $start2=20;
                        $inc=3;
                        $inc2=3;
                        $numincrements=40;

                        $x=$param*($width-1)/100;

                        for ($i=0; $i<=$numincrements; $i++) {
                            $divisor=2+10*$param/100;
                            $xpos1=$x-$i*$x/$divisor/$numincrements;
                            $xpos2=$i*$x/$divisor/$numincrements;
                            //$xpos1=$x-20*sin($i/$height*3.1415927/2);
                            //$xpos2=20*sin($i/$height*3.1415927/2);
                            $ypos1=$height-$i*($height/2)/$numincrements;
                            $ypos2=$i*($height/2)/$numincrements;
                            $colorpos=sin($i/$numincrements*3.1415927/2);
                            $color1=$endcolor1+($startcolor1-$endcolor1)*$colorpos;
                            $color2=$endcolor2+($startcolor2-$endcolor2)*$colorpos;
                            $color3=$endcolor3+($startcolor3-$endcolor3)*$colorpos;
                            imagefilledrectangle($image,$xpos2,$ypos2,$xpos1,$ypos1,imagecolorallocate($image,$color1,$color2,$color3));
                        }
                        imagerectangle($image,0,0,$width-1,$height-1,imagecolorallocate($image,$endcolor1,$endcolor2,$endcolor3));
                        if ($fontsize==0) {
                            $fontsize=0;
                        }

                        if ($fontsize>300) {
                            $fontsize=300;
                        }

                        $leftshift=20;
                        if ($param<100) {
                            $leftshift-=4;
                        }
                        if ($param<10) {
                            $leftshift-=4;
                        }

                        if ($fontsize>0) {
                            $bbox=imageftbbox($fontsize, 0, $font, $param."%", array("linespacing" => 1));
                            if ($outsidetext==1) {
                                $xcoord=$width+5;
                            } else {
                                $xcoord=($width-$bbox[4])/2;
                            }
                            $ycoord=($height-$bbox[5])/2-2;
                            if ($whitetextborder) {
                                imagettftext($image, $fontsize, 0, $xcoord-1, $ycoord-1, $white, $font, $param."%");
                                imagettftext($image, $fontsize, 0, $xcoord-1, $ycoord+1, $white, $font, $param."%");
                                imagettftext($image, $fontsize, 0, $xcoord+1, $ycoord+1, $white, $font, $param."%");
                                imagettftext($image, $fontsize, 0, $xcoord+1, $ycoord-1, $white, $font, $param."%");
                                imagettftext($image, $fontsize, 0, $xcoord-1, $ycoord-2, $white, $font, $param."%");
                                imagettftext($image, $fontsize, 0, $xcoord-1, $ycoord+2, $white, $font, $param."%");
                                imagettftext($image, $fontsize, 0, $xcoord+1, $ycoord+2, $white, $font, $param."%");
                                imagettftext($image, $fontsize, 0, $xcoord+1, $ycoord-2, $white, $font, $param."%");
                                imagettftext($image, $fontsize, 0, $xcoord-2, $ycoord-1, $white, $font, $param."%");
                                imagettftext($image, $fontsize, 0, $xcoord-2, $ycoord+1, $white, $font, $param."%");
                                imagettftext($image, $fontsize, 0, $xcoord+2, $ycoord+1, $white, $font, $param."%");
                                imagettftext($image, $fontsize, 0, $xcoord+2, $ycoord-1, $white, $font, $param."%");
                                imagettftext($image, $fontsize, 0, $xcoord-2, $ycoord-2, $white, $font, $param."%");
                                imagettftext($image, $fontsize, 0, $xcoord-2, $ycoord+2, $white, $font, $param."%");
                                imagettftext($image, $fontsize, 0, $xcoord+2, $ycoord+2, $white, $font, $param."%");
                                imagettftext($image, $fontsize, 0, $xcoord+2, $ycoord-2, $white, $font, $param."%");
                            }
                            imagettftext($image, $fontsize, 0, $xcoord, $ycoord, $black, $font, $param."%");
                        }


                        if (serendipity_db_bool($this->get_config('cacheimages')) and !$nocache) {
                            $this->purgeCache();
                            // Save a copy of this image in the cache

                            $cap = $serendipity['serendipityPath'] . '/' . PATH_SMARTY_COMPILE . '/cache_todolist_progressimage-' . $param . '_'.$originalwidth.'_'.$height.'_'.$startcolor.'_'.$endcolor.'_'.$whitetextborder.'_'.$fontsize.'_'.$filefontname.'_'.$outsidetext.'_'.$backgroundcolor.'.png';
                            imagepng($image,$cap);
                        }
                        imagepng($image);
                        imagedestroy($image);
                    } else {
                        header('Content-Type: image/png');

                        $nearpercent= (int) ($param/5);
                        $nearpercent*=5;
                        if ($width == '160') {
                            $cap = dirname(__FILE__) . '/images/progress-' . $nearpercent . '.png';
                        } else {
                            $cap = dirname(__FILE__) . '/images/progress-' . $nearpercent . '-small.png';
                        }

                        if (file_exists($cap)) {
                            echo file_get_contents($cap);
                        }
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

    function generate_content(&$title) {
        $this->checkSchema();
        if ($this->get_config('cache') == 'yes') {
            $output = $this->get_config('cached_output');
            if (empty($output)) {
                $output = $this->generate_output();
                $this->set_config('cached_output', $output);
            }
           echo $output;
        } else {
            echo $this->generate_output();
        }
    }

    function generate_output() {
        global $serendipity;

        $t = $this->get_config('title');
        if (!empty($t)) {
            $output .= '<h3 class="serendipitySideBarTitle serendipity_event_percentagedone">'.$this->get_config('title').'</h3>';
        }
        $display = $this->get_config('display');

        if ($display == 'category' || $display == 'js_category') {
            if ($this->get_config('category') == 'custom') {
                $table = $serendipity['dbPrefix'].'project_category';
            } else {
                $table = $serendipity['dbPrefix'].'category';
            }

            if ($display == 'js_category') {
                 $output .= '<script type="text/javascript">
                     function show(el) {
                        if (document.getElementById(el).style.display == \'none\') {
                            document.getElementById(el).style.display = \'block\';
                        } else {
                            document.getElementById(el).style.display = \'none\';
                        }
                     }
                     </script>';
            }
            $output .= $this->category_output($table,0,0,$display);
        } else {
            $output .= '<div class="serendipity_center">';
            $q = $this->set_query($display);
            $sql = serendipity_db_query($q);

            if ($sql && is_array($sql)) {
                $barlength       = $this->get_config('barlength');
                $whitetextborder = serendipity_db_bool($this->get_config('whitetextborder'));
                $fontsize        = $this->get_config('fontsize');
                $font            = $this->get_config('font');
                $font            = preg_replace('/_/','----',$font);
                $backgroundcolor = $this->get_config('backgroundcolor');
                $backgroundcolor = preg_replace('/[^0-9a-fA-F]/','',$backgroundcolor);
                $height          = $this->get_config('barheight');
                $outsidetext     = $this->get_config('outsidetext');

                foreach($sql AS $key => $row) {
                    $entry     = $row['entry'];
                    $entryLink = '';
                    if (!empty($entry)) {
                        $entries_query = "SELECT id,
                                                    title,
                                                    timestamp
                                               FROM {$serendipity['dbPrefix']}entries
                                              WHERE isdraft = 'false' AND timestamp <= " . time() . " AND id = $entry";
                        $entries = serendipity_db_query($entries_query);

                        if (isset($entries) && is_array($entries)) {
                            foreach ($entries as $k => $entry) {
                                $entryLink = serendipity_archiveURL(
                                               $entry['id'],
                                               $entry['title'],
                                               'serendipityHTTPPath',
                                               true,
                                               array('timestamp' => $entry['timestamp'])
                                            );
                            }
                        }
                    }
                    $project            = $row['project'];
                    $percentagecomplete = $row['percentagecomplete'];
                    $id                 = $row['id'];
                    $hidden             = $row['hidden'];
                    $colorid            = $row['colorid'];

                    $colorvalues = $this->getColorByID($colorid, $row['cat_id']);
                    $startcolor  = $colorvalues['startcolor'];
                    $endcolor    = $colorvalues['endcolor'];

                    $startcolor = preg_replace('/[^0-9a-fA-F]/','',$startcolor);
                    $endcolor   = preg_replace('/[^0-9a-fA-F]/','',$endcolor);
                    $startcolor = substr($startcolor,0,6);
                    $endcolor   = substr($endcolor,0,6);

                    if ($this->check_gd()==false) {
                        $barlength=160;
                        $imgsrc=$serendipity['baseURL'].($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/percentage_'.$percentagecomplete.'_'.$barlength.'_'.$height.'_'.$startcolor.'_'.$endcolor.'_'.$whitetextborder.'_'.$fontsize.'_'.$font.'_0_'.$outsidetext.'_'.$backgroundcolor;
                    } else {
                        $imgsrc    = $serendipity['baseURL'].($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/percentage_'.$percentagecomplete.'_'.$barlength.'_'.$height.'_'.$startcolor.'_'.$endcolor.'_'.$whitetextborder.'_'.$fontsize.'_'.$font.'_0_'.$outsidetext.'_'.$backgroundcolor;
                        $cap       = $serendipity['baseURL'].'/'.PATH_SMARTY_COMPILE.'/cache_todolist_progressimage-' . $percentagecomplete . '_'.$barlength.'_'.$height.'_'.$startcolor.'_'.$endcolor.'_'.$whitetextborder.'_'.$fontsize.'_'.$font.'_'.$outsidetext.'_'.$backgroundcolor.'.png';
                        $filecheck = $serendipity['serendipityPath'].'/'.PATH_SMARTY_COMPILE.'/cache_todolist_progressimage-' . $percentagecomplete . '_'.$barlength.'_'.$height.'_'.$startcolor.'_'.$endcolor.'_'.$whitetextborder.'_'.$fontsize.'_'.$font.'_'.$outsidetext.'_'.$backgroundcolor.'.png';
                    }

                    if (file_exists($filecheck)) {
                        $imgsrc = $cap;
                    }

                    if ($hidden == 0) {
                        if (empty($entryLink)) {
                            $output .=  '<span style="font-size: x-small">'.$project.'</span><br /><img alt="' . $percentagecomplete . '" title="' . $project . ': ' . $percentagecomplete . '" src="'.$imgsrc.'"  height="'.$height.'" width="'.$barlength.'" /><br />';
                        } else {
                            $output .=  '<span style="font-size: x-small"><a href="'.$entryLink.'">'.$project.'</a></span><br /><img alt="' . $percentagecomplete . '" title="' . $project . ': ' . $percentagecomplete . '" src="'.$imgsrc.'"  height="'.$height.'" width="'.$barlength.'" /><br />';
                        }
                        $output.='<br />';
                    }
                }
            }
            $output.="</div>\n";  // serendipity_center
        }

        return $output;
    }

    function getColorById($colorid,$catid) {
        global $serendipity;

        $startcolor = '';
        $endcolor   = '';
        if ($colorid > 0) {
            $q = "SELECT *
                    FROM {$serendipity['dbPrefix']}project_colors
                   WHERE colorid=" . (int)$colorid;

            $colors     = serendipity_db_query($q);
            $startcolor = $colors[0]['color1'];
            $endcolor   = $colors[0]['color2'];
        }

        if (empty($startcolor) OR empty($endcolor)) {
            if ($catid) {
                $q = "SELECT ca.colorid, co.color1, co.color2
                        FROM {$serendipity['dbPrefix']}project_category AS ca
             LEFT OUTER JOIN {$serendipity['dbPrefix']}project_colors   AS co
                          ON ca.colorid = co.colorid
                       WHERE categoryid=" . (int)$catid;

                $sql = serendipity_db_query($q);
                if ($sql && is_array($sql)) {
                    $colorid    = $sql[0]['colorid'];
                    $startcolor = $sql[0]['color1'];
                    $endcolor   = $sql[0]['color2'];
                }
            }
        }

        if (empty($startcolor) OR empty($endcolor)) {
            $colorid = $this->get_config('colorid');
            $q = "SELECT *
                    FROM {$serendipity['dbPrefix']}project_colors
                   WHERE colorid=$colorid";

            $colors = serendipity_db_query($q);
            $startcolor = $colors[0]['color1'];
            $endcolor   = $colors[0]['color2'];
        }

        if (empty($startcolor) or empty($endcolor)) {
            $startcolor = "ccffff";
            $endcolor   = "bb33bb";
        }

        $colorvalues = array(
            'startcolor' => $startcolor,
            'endcolor'   => $endcolor,
        );

        return $colorvalues;
    }

    function category_output($table,$catid,$level,$tags)
    {
        global $serendipity;
        $output = '';
        $indent_int = $level*5+20;

        switch ($tags) {
            case 'js_category':
                $category = '<div><a href="#" onclick="show(\'_catname_\'); return false" style="text-decoration:none">_catname_</a></div>'."\n";
                $open_category = '<div style="margin-left:'.$indent_int.'px" id="_catid_" style="display: block">'."\n";
                $close_category ='</div>'."\n";
                $project_style = '_prelink__project__postlink_</a><br /><img src="_imgsrc_" alt="" title="" /><br />' . "\n";
                break;

            case 'category':
                $category = '<div>_catname_</div>'."\n";
                $open_category = '<div style="margin-left:'.$indent_int.'px" id="_catid_">'."\n";
                $close_category ='</div>'."\n";
                $project_style = '_prelink__project__postlink_<br /><img src="_imgsrc_" alt="" title="" /><br />' . "\n";
                break;

            case 'xml':
                $category = ''."\n";
                $open_category = '<dir name="_catname_">';
                $close_category ='</dir>'."\n";
                $project_style = '<project name="_project_" project="_link_" />'."\n";
                break;
        }

        $barlength=$this->get_config('categorybarlength');
        $height=$this->get_config('barheight');
        $fontsize=$this->get_config('fontsize');
        $font=$this->get_config('font');
        $font = preg_replace('/_/','----',$font);
        $backgroundcolor = $this->get_config('backgroundcolor');
        $backgroundcolor = preg_replace('/[^0-9a-fA-F]/','',$backgroundcolor);
        $outsidetext=$this->get_config('outsidetext');
        $whitetextborder = serendipity_db_bool($this->get_config('whitetextborder'));
        if ($this->check_gd()==false) {
            $barlength=100;
            $imgsrc=$serendipity['baseURL'].($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/percentage__percentagecomplete__'.$barlength.'_'.$height.'__startcolor___endcolor__'.$whitetextborder.'_'.$fontsize.'_'.$font.'_0_'.$outsidetext.'_'.$backgroundcolor;
        } else {
            $imgsrc=$serendipity['baseURL'].($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/percentage__percentagecomplete__'.$barlength.'_'.$height.'__startcolor___endcolor__'.$whitetextborder.'_'.$fontsize.'_'.$font.'_0_'.$outsidetext.'_'.$backgroundcolor;
            $capimgsrc=$serendipity['serendipityPath'].PATH_SMARTY_COMPILE.'/'. 'cache_todolist_progressimage-_percentagecomplete__'.$barlength.'_'.$height.'__startcolor___endcolor__'.$whitetextborder.'_'.$fontsize.'_'.$font.'_'.$outsidetext.'_'.$backgroundcolor.'.png';
            $cacheimgsrc=$serendipity['baseURL'].PATH_SMARTY_COMPILE.'/'. 'cache_todolist_progressimage-_percentagecomplete__'.$barlength.'_'.$height.'__startcolor___endcolor__'.$whitetextborder.'_'.$fontsize.'_'.$font.'_'.$outsidetext.'_'.$backgroundcolor.'.png';
        }

        if ($level == 0) {
            $catid = $level;
        }
        $need_endtag = false;
        $q = "SELECT *
                FROM $table
               WHERE categoryid=$catid
               LIMIT 1";
        $sql = serendipity_db_query($q, true);
        if ($sql && is_array($sql)) {
            $replace_name = "_catname_";
            $cat_name     = $sql['category_name'];
            $replace_id   = "_catid_";
            $cat_id       = str_replace(' ', '_', $cat_name);

            $category      = str_replace($replace_name, $cat_name, $category);
            $category      = str_replace($replace_id, $cat_id, $category);
            $open_category = str_replace($replace_name, $cat_name, $open_category);
            $open_category = str_replace($replace_id, $cat_id, $open_category);

            $need_endtag = true;
            $output .= $category;
            $output .= $open_category;
            //--JAM: Apparently some category doesn't return an array!  Maybe
            // it's category 0?  Anyway, that gives us an extra end tag!
        }

        $q = 'SELECT s.* FROM '.$table.' AS s WHERE parentid='.$catid.' ORDER BY s.category_name ASC';
        $sql = serendipity_db_query($q);
        if ($sql && is_array($sql)) {
            foreach($sql AS $key => $row) {
                 $output .= $this->category_output($table,$row['categoryid'],$level+1,$tags);
            }
        }
        $q = 'SELECT s.project            AS project,
                     s.title              AS name,
                     s.entry              AS entry,
                     s.category           AS cat_id,
                     s.percentagecomplete AS percentagecomplete,
                     s.colorid            AS colorid,
                     s.id                 AS id
                FROM '.$serendipity['dbPrefix'].'percentagedone AS s
               WHERE s.category = '.$catid.'
                 AND s.hidden   = 0
            ORDER BY s.title ASC';
        $sql = serendipity_db_query($q);
        if ($sql && is_array($sql)) {
            foreach($sql AS $key => $row) {
                $project_out = $project_style;
                $imgsrc_out=$imgsrc;
                $cacheimgsrc_out=$cacheimgsrc;
                $capimgsrc_out=$capimgsrc;
                $name = $row['name'];
                $percentagecomplete = $row['percentagecomplete'];
                $project = $row['project'];
                $id = $row['id'];
                $colorid = $row['colorid'];
                $entry = $row['entry'];
                $entries_query = "SELECT id,
                                            title,
                                            timestamp
                                       FROM {$serendipity['dbPrefix']}entries
                                      WHERE isdraft = 'false' AND timestamp <= " . time() . " AND id = $entry";
                $entries = serendipity_db_query($entries_query);

                $entryLink='test';

                if (isset($entries) && is_array($entries) && $entry>0) {
                    $entry=$entries[0];
                    $entryLink = serendipity_archiveURL(
                                   $entry['id'],
                                   $entry['title'],
                                   'serendipityHTTPPath',
                                   true,
                                   array('timestamp' => $entry['timestamp'])
                                );
                }

                $replace_link = "_link_";
                $replace_prelink = "_prelink_";
                $replace_postlink = "_postlink_";
                $replace_startcolor = "_startcolor_";
                $replace_endcolor = "_endcolor_";
                $replace_project = "_project_";
                $replace_imgsrc = "_imgsrc_";
                $replace_percentagecomplete = "_percentagecomplete_";
                $link='';
                $colorvalues = $this->getColorByID($colorid, $row['cat_id']);
                $startcolor  = $colorvalues['startcolor'];
                $endcolor    = $colorvalues['endcolor'];

                $startcolor = preg_replace('/[^0-9a-fA-F]/','',$startcolor);
                $endcolor = preg_replace('/[^0-9a-fA-F]/','',$endcolor);

                if ($entryLink == 'test') {
                    $project_out = str_replace($replace_link,'',$project_out);
                    $project_out = str_replace($replace_prelink,'',$project_out);
                    $project_out = str_replace($replace_postlink,'',$project_out);
                } else {
                    $project_out = str_replace($replace_link,$entryLink,$project_out);
                    $postlink="</a>";
                    $prelink='<a href="'.$entryLink.'">';
                    $project_out = str_replace($replace_prelink,$prelink,$project_out);
                    $project_out = str_replace($replace_postlink,$postlink,$project_out);
                }
                $project_out = str_replace($replace_project,$project,$project_out);

                $capimgsrc_out = str_replace($replace_startcolor,$startcolor,$capimgsrc_out);
                $capimgsrc_out = str_replace($replace_endcolor,$endcolor,$capimgsrc_out);
                $capimgsrc_out = str_replace($replace_percentagecomplete,$percentagecomplete,$capimgsrc_out);
                if (file_exists($capimgsrc_out)) {
                    $cacheimgsrc_out = str_replace($replace_startcolor,$startcolor,$cacheimgsrc_out);
                    $cacheimgsrc_out = str_replace($replace_endcolor,$endcolor,$cacheimgsrc_out);
                    $cacheimgsrc_out = str_replace($replace_percentagecomplete,$percentagecomplete,$cacheimgsrc_out);
                    $imgsrc_out=$cacheimgsrc_out;
                } else {
                    $imgsrc_out = str_replace($replace_startcolor,$startcolor,$imgsrc_out);
                    $imgsrc_out = str_replace($replace_endcolor,$endcolor,$imgsrc_out);
                    $imgsrc_out = str_replace($replace_percentagecomplete,$percentagecomplete,$imgsrc_out);
                }
                $project_out = str_replace($replace_imgsrc,$imgsrc_out,$project_out);
                $output .=  $project_out;
            }
        }
        if ($need_endtag === true)
        {
            $output .= $close_category;
        }
        return $output;
    }

    function cleanup() {
        if ($this->get_config('cache') == 'yes') {
            $output = $this->generate_output();
            $this->set_config('cached_output',$output);
        }
        return true;
    }

    function checkSchema() {
        global $serendipity;

        $version = $this->get_config('dbversion');

        if ($version != PLUGIN_EVENT_TODOLIST_DBVERSION) {
            if ($version == 0) {
                $version = 1.5;
            }

            if ($version == 1.5) {
                $q   = "ALTER TABLE {$serendipity['dbPrefix']}percentagedone ADD startcolor varchar(24) default NULL";
                $sql = serendipity_db_schema_import($q);
                $q   = "ALTER TABLE {$serendipity['dbPrefix']}percentagedone ADD endcolor varchar(24) default NULL";
                $sql = serendipity_db_schema_import($q);
                $q   = "ALTER TABLE {$serendipity['dbPrefix']}percentagedone ADD hidden int(1) default 0";
                $sql = serendipity_db_schema_import($q);
                $version = 1.6;
            }

            if ($version == 1.6) {
                $q   = "CREATE TABLE ".$serendipity['dbPrefix']."project_colors (
                            colorid {AUTOINCREMENT} {PRIMARY},
                            color_name varchar(255) default NULL,
                            color1 varchar(12) default NULL,
                            color2 varchar(12) default NULL
                            )";
                $sql = serendipity_db_schema_import($q);
                $q   = "ALTER TABLE {$serendipity['dbPrefix']}percentagedone ADD colorid int default 0";
                $sql = serendipity_db_schema_import($q);

                $version = 1.7;
            }

            if ($version == 1.7) {

                // Check for any color configurations using the old startcolor,endcolor percentagedone table fields
                // and convert them to new project_color table entries and percentagedone.colorid fields.

                $q = "select id,colorid,startcolor,endcolor from {$serendipity['dbPrefix']}percentagedone";
                $colors = serendipity_db_query($q);
                foreach($colors as $color) {
                    if (!empty($color['startcolor']) || !empty($color['endcolor'])) {
                        $q2 = "select colorid from {$serendipity['dbPrefix']}project_colors where color1='{$color['startcolor']}' and color2='{$color['endcolor']}'";
                        $sql = serendipity_db_query($q2);
                        if ($sql && is_array($sql)) {
                            $colorid=$sql[0]['colorid'];
                            $this->update_color($color['id'], $colorid);
                        } else {
                            $this->add_color($color['startcolor']."/".$color['endcolor'],$color['startcolor'],$color['endcolor']);
                            $q2 = "select colorid from {$serendipity['dbPrefix']}project_colors where color1='{$color['startcolor']}' and color2='{$color['endcolor']}'";
                            $sql = serendipity_db_query($q2);
                            $colorid=$sql[0]['colorid'];
                            $this->update_color($color['id'], $colorid);
                        }
                    }
                }

                // Check for old default color configuration and convert to new project_colors table configuration

                $startcolor=$this->get_config('startcolor');
                $endcolor=$this->get_config('endcolor');
                $q2 = "select colorid from {$serendipity['dbPrefix']}project_colors where color1='{$startcolor}' and color2='{$endcolor}'";
                $sql = serendipity_db_query($q2);
                $colorid=$sql[0]['colorid'];
                $this->set_config('colorid', $colorid);

                // Add some initial colours

                $this->add_color('Blue', 'ccccff', '3333bb');
                $this->add_color('Gold', 'ffffcc', '666633');
                $this->add_color('Green', 'aaffaa', '336633');
                $this->add_color('Orange', 'ffeecc', 'ff8811');
                $this->add_color('Purple', 'ffddff', '550066');
                $this->add_color('Red', 'ffdddd', 'dd4444');
                $this->add_color('Silver', 'eeeeee', '999999');

                $version=1.8;
            }
            if ($version == 1.8) {
                $q   = 'SELECT color_name FROM '.$serendipity['dbPrefix'].'project_colors';
                $sql = serendipity_db_query($q);

                if ($sql && is_array($sql)) {
                    // project_colors table exists.  Great.
                } else {
                    // Some new installs might not have had the project_colors
                    // table created.  Create it here if it doesn't exist.
                    $q   = "CREATE TABLE ".$serendipity['dbPrefix']."project_colors (
                            colorid {AUTOINCREMENT} {PRIMARY},
                            color_name varchar(255) default NULL,
                            color1 varchar(12) default NULL,
                            color2 varchar(12) default NULL
                            )";
                    $sql = serendipity_db_schema_import($q);
                    // Add some initial colours

                    $this->add_color('Blue', 'ccccff', '3333bb');
                    $this->add_color('Gold', 'ffffcc', '666633');
                    $this->add_color('Green', 'aaffaa', '336633');
                    $this->add_color('Orange', 'ffeecc', 'ff8811');
                    $this->add_color('Purple', 'ffddff', '550066');
                    $this->add_color('Red', 'ffdddd', 'dd4444');
                    $this->add_color('Silver', 'eeeeee', '999999');
                }
                $this->set_config('dbversion', 1.9);
                $version = 1.10;
            }

            if ($version == 1.9) {
                $version = 1.10;
            }

            if ($version == 1.10) {
                // Add colorid field to project_category table.
                $q   = "ALTER TABLE {$serendipity['dbPrefix']}project_category ADD colorid int(11) default 0";
                $sql = serendipity_db_schema_import($q);
                $this->set_config('dbversion', PLUGIN_EVENT_TODOLIST_DBVERSION);
            }
        }
    }

    function install() {
        global $serendipity;
        // Create table
        $q   = "CREATE TABLE ".$serendipity['dbPrefix']."percentagedone (
                    id {AUTOINCREMENT} {PRIMARY},
                    date_added int(10) {UNSIGNED} NULL,
                    project varchar(250) default NULL,
                    title varchar(250) default NULL,
                    percentagecomplete int(4) default 0,
                    descrip text,
                    order_num int(4),
                    category int(11),
                    last_result int(4),
                    last_result_time int(10) {UNSIGNED} NULL,
                    num_bad_results int(11),
                    colorid int(11) default 0,
                    entry int(11),
                    hidden int(1) default 0
                )";

        $sql = serendipity_db_schema_import($q);

        $this->set_config('dbversion', PLUGIN_EVENT_TODOLIST_DBVERSION);

        $q   = "CREATE INDEX percentage_dateind ON {$serendipity['dbPrefix']}percentagedone (date_added);";
        $sql = serendipity_db_schema_import($q);

        $q   = "CREATE INDEX percentage_titleind ON {$serendipity['dbPrefix']}percentagedone (title(191));";
        $sql = serendipity_db_schema_import($q);

        $q   = "CREATE INDEX percentage_catind ON {$serendipity['dbPrefix']}percentagedone (category);";
        $sql = serendipity_db_schema_import($q);

        $this->create_cattable();
        $this->create_colortable();
    }

    function create_colortable() {

        global $serendipity;
        $q   = "CREATE TABLE ".$serendipity['dbPrefix']."project_colors (
                            colorid {AUTOINCREMENT} {PRIMARY},
                            color_name varchar(255) default NULL,
                            color1 varchar(12) default NULL,
                            color2 varchar(12) default NULL
                            )";
        $sql = serendipity_db_schema_import($q);
        // Add some initial colours

        $this->add_color('Blue', 'ccccff', '3333bb');
        $this->add_color('Gold', 'ffffcc', '666633');
        $this->add_color('Green', 'aaffaa', '336633');
        $this->add_color('Orange', 'ffeecc', 'ff8811');
        $this->add_color('Purple', 'ffddff', '550066');
        $this->add_color('Red', 'ffdddd', 'dd4444');
        $this->add_color('Silver', 'eeeeee', '999999');

    }
    function create_cattable() {

        global $serendipity;
        $q   = "CREATE TABLE ".$serendipity['dbPrefix']."project_category (
                    categoryid {AUTOINCREMENT} {PRIMARY},
                    category_name varchar(255) default NULL,
                    colorid int(11) default 0,
                    parentid int(11) default 0
                )";
        $sql = serendipity_db_schema_import($q);
        $this->set_config('catbd','done');
    }

    function uninstall(&$propbag) {
        global $serendipity;
        // Don't Drop table to avoid losing data.
        // $q   = "DROP TABLE ".$serendipity['dbPrefix']."percentagedone";
        // $sql = serendipity_db_schema_import($q);
        // $q   = "DROP TABLE ".$serendipity['dbPrefix']."project_category";
        // $sql = serendipity_db_schema_import($q);
        // $q   = "DROP TABLE ".$serendipity['dbPrefix']."project_colors";
        // $sql = serendipity_db_schema_import($q);
    }

    function add_project($project, $percentagecomplete, $desc, $catid = 0, $entry, $colorid) {
        global $serendipity;


        $q   = "SELECT count(id) FROM {$serendipity['dbPrefix']}percentagedone";
        $sql = serendipity_db_query($q);

        $values['date_added']         = time();
        $values['project']            = $project;
        $values['entry']              = $entry;
        $values['percentagecomplete'] = $percentagecomplete;
        $values['descrip']            = $desc;
        $values['order_num']          = count($sql);
        $values['category']           = $catid;
        $values['colorid']            = $colorid;
        $values['order_num']          = $sql[0][0];
        serendipity_db_insert('percentagedone', $values);
    }


    function add_cat($name, $parent, $colorid) {
        global $serendipity;

        $values['category_name'] = $name;
        $values['parentid']      = $parent;
        $values['colorid']       = $colorid;
        serendipity_db_insert('project_category', $values);
    }

    function add_color($name, $color1, $color2) {
        global $serendipity;

        $values['color_name'] = $name;
        $values['color1']     = $color1;
        $values['color2']     = $color2;
        $q   = 'SELECT color_name FROM '.$serendipity['dbPrefix'].'project_colors where color1="'.$color1.'" and color2="'.$color2.'"';;
        $sql = serendipity_db_query($q);

        if ($sql && is_array($sql)) {
        } else {
            serendipity_db_insert('project_colors', $values);
        }
    }

    function getEntrytext($default = null) {
        global $serendipity;

        $limit = $this->get_config('numentries');
        if ($limit < 3) {
            $limit = 3;
        }
        $entries_query = "SELECT id,
                                        title,
                                        timestamp
                                   FROM {$serendipity['dbPrefix']}entries
                                  WHERE isdraft = 'false' AND timestamp <= " . time() . "
                               ORDER BY timestamp DESC
                                  LIMIT $limit";
        $entries = serendipity_db_query($entries_query);

        $entrytext='<option value="0"></option>' . "\n";
        if (isset($entries) && is_array($entries)) {
            foreach ($entries as $k => $entry) {
                $entryLink = serendipity_archiveURL(
                               $entry['id'],
                               $entry['title'],
                               'serendipityHTTPPath',
                               true,
                               array('timestamp' => $entry['timestamp'])
                            );

                $title = $entry['title'];
                if (strlen($title) > 45) {
                    $title = substr($title, 0, 42) . "...";
                }

                if ($entry['id'] == $default) {
                    $entrytext.= '<option value="' . $entry['id'] . '" selected="selected">' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($title) : htmlspecialchars($title, ENT_COMPAT, LANG_CHARSET)) . "</option>\n";
                } else {
                    $entrytext .= '<option value="' . $entry['id'] . '">' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($title) : htmlspecialchars($title, ENT_COMPAT, LANG_CHARSET)) . "</option>\n";
                }
            }
        }

        return $entrytext;
    }

    function update_project($id, $project, $percentagecomplete, $desc, $catid, $entry, $colorid) {
        global $serendipity;

        $values['project']            = $project;
        $values['entry']              = $entry;
        $values['percentagecomplete'] = $percentagecomplete;
        $values['descrip']            = $desc;
        $values['category']           = $catid;
        $values['colorid']              = $colorid;
        $key['id'] = $id;
        serendipity_db_update('percentagedone', $key, $values);
    }

    function del_project($id) {
        global $serendipity;

        $q   = 'SELECT order_num FROM '.$serendipity['dbPrefix'].'percentagedone where id='.$id;
        $sql = serendipity_db_query($q);

        if ($sql && is_array($sql)) {
            $res = $sql[0];
            $order_num = $res['order_num'];
            $q   = 'DELETE FROM '.$serendipity['dbPrefix'].'percentagedone where id='.$id;
            $sql = serendipity_db_query($q);

            $q   = 'UPDATE '.$serendipity['dbPrefix'].'percentagedone SET order_num=order_num-1 where order_num > '.$order_num;
            $sql = serendipity_db_query($q);
        }
    }


    function del_color($id) {
        global $serendipity;
        $q   = 'DELETE FROM '.$serendipity['dbPrefix'].'project_colors where colorid='.$id;
        $sql = serendipity_db_query($q);

        $values['colorid'] = 0;
        $key['category'] = $id;
        serendipity_db_update('percentagedone', $key, $values);
    }

    function del_category($id) {
        global $serendipity;
        $q   = 'DELETE FROM '.$serendipity['dbPrefix'].'project_category where categoryid='.$id;
        $sql = serendipity_db_query($q);

        $values['category'] = 0;
        $key['category'] = $id;
        serendipity_db_update('percentagedone', $key, $values);
    }

    function update_cat($id,$cat) {
        global $serendipity;

        $q   = 'UPDATE '.$serendipity['dbPrefix'].'percentagedone SET category = '.$cat.' where id = '.$id;
        $sql = serendipity_db_query($q);
    }

    function update_color($id,$color) {
        global $serendipity;

        $q   = 'UPDATE '.$serendipity['dbPrefix'].'percentagedone SET colorid = '.$color.' where id = '.$id;
        $sql = serendipity_db_query($q);
    }

    function update_category_color($id,$color) {
        global $serendipity;

        $q   = 'UPDATE '.$serendipity['dbPrefix'].'project_category SET colorid = '.$color.' where categoryid = '.$id;
        $sql = serendipity_db_query($q);
    }

    function update_colorname($id,$colorname) {
        global $serendipity;

        $q   = 'UPDATE '.$serendipity['dbPrefix'].'project_colors SET color_name = "'.$colorname.'" where colorid = '.$id;
        $sql = serendipity_db_query($q);
    }

    function update_color1($id,$color) {
        global $serendipity;

        $q   = 'UPDATE '.$serendipity['dbPrefix'].'project_colors SET color1 = "'.$color.'" where colorid = '.$id;
        $sql = serendipity_db_query($q);
    }

    function update_color2($id,$color) {
        global $serendipity;

        $q   = 'UPDATE '.$serendipity['dbPrefix'].'project_colors SET color2 = "'.$color.'" where colorid = '.$id;
        $sql = serendipity_db_query($q);
    }

    function update_percent($id,$percent) {
        global $serendipity;

        $q   = 'UPDATE '.$serendipity['dbPrefix'].'percentagedone SET percentagecomplete='.$percent.' where id = '.$id;
        $sql = serendipity_db_query($q);
    }

    function update_startcolor($id,$startcolor) {
        global $serendipity;

        $q   = 'UPDATE '.$serendipity['dbPrefix'].'percentagedone SET startcolor="'.$startcolor.'" where id = '.$id;
        $sql = serendipity_db_query($q);
    }

    function update_endcolor($id,$endcolor) {
        global $serendipity;

        $q   = 'UPDATE '.$serendipity['dbPrefix'].'percentagedone SET endcolor="'.$endcolor.'" where id = '.$id;
        $sql = serendipity_db_query($q);
    }

    function update_hidden($id,$hidden) {
        global $serendipity;

        $q   = 'UPDATE '.$serendipity['dbPrefix'].'percentagedone SET hidden='.$hidden.' where id = '.$id;
        $sql = serendipity_db_query($q);
    }

    function update_entry($id,$entry) {
        global $serendipity;

        $q   = 'UPDATE '.$serendipity['dbPrefix'].'percentagedone SET entry='.$entry.' where id = '.$id;
        $sql = serendipity_db_query($q);
    }

    function move_up($id) {
        global $serendipity;
        $q   = 'SELECT order_num FROM '.$serendipity['dbPrefix'].'percentagedone where id='.$id;
        $sql = serendipity_db_query($q);

        if ($sql && is_array($sql)) {
            $res = $sql[0];
            $order_num = $res['order_num']-1;
            if ($order_num >= 0) {
                $q   = 'UPDATE '.$serendipity['dbPrefix'].'percentagedone SET order_num=order_num-1 where id = '.$id;
                $sql = serendipity_db_query($q);

                $q   = 'UPDATE '.$serendipity['dbPrefix'].'percentagedone SET order_num=order_num+1 where order_num = '.$order_num.' AND id !='.$id;
                $sql = serendipity_db_query($q);
            }
        }
    }

    function move_down($id) {
        global $serendipity;

        $q   = 'SELECT count(id) AS countit FROM '.$serendipity['dbPrefix'].'percentagedone';
        $sql = serendipity_db_query($q);
        if ($sql && is_array($sql)) {
            $res = $sql[0];
            $count = $res['countit'];
        } else {
            $count = 0;
        }

        $q   = 'SELECT order_num FROM '.$serendipity['dbPrefix'].'percentagedone where id='.$id;
        $sql = serendipity_db_query($q);

        if ($sql && is_array($sql)) {
            $res = $sql[0];
            $order_num = $res['order_num']+1;
            if ($order_num <= $count)
            {
                $q   = 'UPDATE '.$serendipity['dbPrefix'].'percentagedone SET order_num=order_num+1 where id = '.$id;
                $sql = serendipity_db_query($q);

                $q   = 'UPDATE '.$serendipity['dbPrefix'].'percentagedone SET order_num=order_num-1 where order_num = '.$order_num.' AND id !='.$id;
                $sql = serendipity_db_query($q);
            }
        }
    }

    function output_projectadmin() {
        global $serendipity;
        $display = $this->get_config('display');
        $q = $this->set_query($display);
        $categories = $this->build_categories();

        echo '<h3>'.PLUGIN_EVENT_TODOLIST_ADMINPROJECT.'</h3>';
?>
        <form action="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=percentagedone" method="post">
            <div class="serendipity_todolist_wrap">
            <table>
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th><?php echo PLUGIN_EVENT_TODOLIST_PROJECT; ?></th>
                    <th id="todo_done"><?php echo PLUGIN_EVENT_TODOLIST_PERCENTDONE; ?></th>
                    <th id="todo_hide"><?php echo PLUGIN_EVENT_TODOLIST_HIDDEN; ?></th>
                    <th><?php echo CATEGORY; ?></th>
                    <th id="todo_assign"><?php echo PLUGIN_EVENT_TODOLIST_BLOGENTRY; ?></th>
                    <th id="todo_color"><?php echo PLUGIN_EVENT_TODOLIST_COLOR; ?></th>
                    <?php echo $this->tdoutput; ?>
                </tr>
            </thead>
            <tbody>
<?php
        $sql = serendipity_db_query($q);
        if ($sql && is_array($sql)) {
            $sort_idx = 0;
            foreach($sql AS $key => $row) {
                $name               = $row['name'];
                $percentagecomplete = $row['percentagecomplete'];
                $project            = $row['project'];
                $hidden             = $row['hidden'];
                $projectentry       = $row['entry'];
                $colorid            = $row['colorid'];
                $current_category   = $row['cat_id'];
                $id                 = $row['id'];
                if ($display == 'order_num') {
                    if ($sort_idx == 0) {
                        $moveup   = '<td>&nbsp;</td>';
                    } else {
                        $moveup   = '<td><a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=percentagedone&amp;submit=move+up&amp;serendipity[project_to_move]=' . $id . '"><span class="icon-up-dir" aria-hidden="true"></span><span class="visuallyhidden">' . UP . '</span></a></td>';
                    }
                    if ($sort_idx == (count($sql)-1)) {
                        $movedown = '<td>&nbsp;</td>';
                    } else {
                        $movedown = '<td><a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=percentagedone&amp;submit=move+down&serendipity[project_to_move]=' . $id . '"><span class="icon-down-dir" aria-hidden="true"></span><span class="visuallyhidden">'. DOWN .'</span></a></td>';
                    }
                }

                $entrytext = $this->getEntrytext($projectentry);

                $q = "SELECT *
                        FROM {$serendipity['dbPrefix']}project_colors
                    ORDER BY color_name ASC";
                $colors = serendipity_db_query($q);

                $colortext = '<option value="0">' . USE_DEFAULT . "</option>\n";
                foreach ($colors as $color) {
                    if ($color['colorid'] == $colorid) {
                        $colortext.= '<option value="' . $color['colorid'] . '" selected="selected">' . $color['color_name'] . "</option>\n";
                    } else {
                        $colortext.= '<option value="' . $color['colorid'] . '">' . $color['color_name'] . "</option>\n";
                    }
                }

                $hiddenchecked = '';
                $showchecked   = '';
                if ($hidden == 1) {
                    $hiddenchecked = 'checked="checked"';
                } else {
                    $showchecked   = 'checked="checked"';
                }
?>
                <tr>
                    <td class="form_check"><input type="checkbox" name="serendipity[project_to_remove][]" value="<?php echo $id; ?>"></td>
                    <td><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=percentagedone&amp;serendipity[edit_project]=<?php echo $id; ?>"><?php echo $project; ?></a></td>
                    <td class="form_field"><input type="text" aria-labelledby="todoproj_done" name="serendipity[project_to_repercent][<?php echo $id?>]" value="<?php echo $percentagecomplete?>" size="3"></td>
                    <td class="form_check"><input aria-labelledby="todo_hide" type="checkbox" name="serendipity[project_to_hide][<?php echo $id?>]" value="1" <?php echo $hiddenchecked?>></td>
                    <td class="form_select"><?php echo $this->category_box($id, $categories, $current_category); ?></td>
                    <td class="form_select"><select aria-labelledby="todo_assign" name="serendipity[project_to_reassign][<?php echo $id?>]"><?php echo $entrytext?></select></td>
                    <td class="form_select"><select aria-labelledby="todo_color" name="serendipity[project_to_recolor][<?php echo $id?>]"><?php echo $colortext?></select></td>
                    <?php echo $moveup ?>
                    <?php echo $movedown ?>
                </tr>
<?php
                $sort_idx++;
            }
        }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            if ($this->get_config('category') == 'custom') {
                $catproject = ' <a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=percentagedone&amp;serendipity[manage_category]=1">'.PLUGIN_EVENT_TODOLIST_ADD_CAT.'</a>';
            }
            $colorproject = ' <a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=percentagedone&amp;serendipity[manage_colors]=1">'.PLUGIN_EVENT_TODOLIST_MANAGE_COLORS.'</a>';
            echo '<div class="form_buttons">';
            echo '    <input type="submit" name="SAVE"   title="' . SAVE . '"    value="' . SAVE . '">' . "\n";
            echo '    <input class="state_cancel" type="submit" name="REMOVE" title="' . REMOVE . '"  value="' . DELETE . '">';
            echo $catproject;
            echo $colorproject;
            echo '</div>';
        echo '</form>';
    }

    function category_box($id,$categories,$current_category = 0) {
        $x = "\n<select id=\"serendipity_project_to_recat\" name=\"serendipity[project_to_recat][".$id."]\">\n";
        foreach ($categories as $k => $v) {
            $x .= "    <option value=\"$k\"" . ($k == $current_category ? ' selected="selected"' : '') . ">$v</option>\n";
        }
        return $x . "</select>\n";
    }

    function output_add_edit_projectadmin($edit = FALSE, $id = -1) {
        global $serendipity;
        $display = $this->get_config('display');
        $categories = $this->build_categories();
        if ($edit) {
            $maintitle = PLUGIN_EVENT_TODOLIST_EDITPROJECT;
            $q = 'SELECT * FROM '.$serendipity['dbPrefix'].'percentagedone WHERE id = '.$id;
            $sql = serendipity_db_query($q);
            if ($sql && is_array($sql)) {
                $res = &$sql[0];

                $project            = $res['project'];
                $title              = $res['title'];
                $percentagecomplete = $res['percentagecomplete'];
                $cat                = $res['category'];
                $projectentry       = $res['entry'];
                $desc               = $res['descrip'];
                $colorid               = $res['colorid'];
                $entry              = $res['entry'];
                $hidden             = $res['hidden'];
            }
            $button = '<input type="submit" name="EDIT" title="' . EDIT . '"  value="' . EDIT . '">';
        } else {
            $maintitle = PLUGIN_EVENT_TODOLIST_ADDPROJECT;
            $button = '<input type="submit" name="ADD" title="' . GO . '"  value="' . GO . '">';
        }

        if ($this->get_config('category') == 'custom') {
            $catproject = '<a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=percentagedone&amp;serendipity[manage_category]=1">'.PLUGIN_EVENT_TODOLIST_ADD_CAT.'</a>';
        }
        $colorproject = '<a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=percentagedone&amp;serendipity[manage_colors]=1">'.PLUGIN_EVENT_TODOLIST_MANAGE_COLORS.'</a>';
        echo '<h2>' . $maintitle . '</h2>';

        $entrytext = $this->getEntrytext($projectentry);

        if ($this->check_gd()) {
            $nogdwarning = '';
        } else {
            $nogdwarning = ' ' . PLUGIN_EVENT_TODOLIST_NOGDLIB;
        }

        $q = "SELECT *
                FROM {$serendipity['dbPrefix']}project_colors
            ORDER BY color_name ASC";

        $colors = serendipity_db_query($q);

        $colortext = '<option value="0" selected="selected">' . USE_DEFAULT . "</option>\n";
        foreach ($colors as $color) {
            if ($color['colorid'] == $colorid) {
                $colortext .= '<option value="'.$color['colorid'].'" selected="selected">'.$color['color_name']."</option>\n";
            } else {
                $colortext .= '<option value="'.$color['colorid'].'">'.$color['color_name']."</option>\n";
            }
        }
?>
        <form class="serendipity_todolist_form" action="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=percentagedone" method="post">
            <input type="hidden" name="serendipity[add_project][id]" value="<?php echo $id; ?>">

            <div class="form_field">
                <label for="serendipity_addproject_project"><?php echo PLUGIN_EVENT_TODOLIST_PROJECT; ?></label>
                <input id="serendipity_addproject_project" type="text" name="serendipity[add_project][project]" value="<?php echo $project; ?>" size="30">
            </div>

            <div class="form_select">
                <label for="serendipity_project_to_recat"><?php echo CATEGORY; ?></label>
                <?php echo $this->category_box('cat',$categories,$cat); ?>
                <?php echo $catproject;?>
            </div>

            <div class="form_select">
                <label for="serendipity_addproject_colorid"><?php echo PLUGIN_EVENT_TODOLIST_COLOR; ?></label>
                <select id="serendipity_addproject_colorid" name="serendipity[add_project][colorid]">
                    <?php echo $colortext?>
                </select>
                <?php echo $colorproject;?>
            </div>

            <div class="form_field">
                <label for="serendipity_addproject_percentagecomplete"><?php echo PLUGIN_EVENT_TODOLIST_PERCENTAGECOMPLETE; ?></label>
                <input id="serendipity_addproject_percentagecomplete" type="text" name="serendipity[add_project][percentagecomplete]" value="<?php echo $percentagecomplete; ?>" size="3"><?php echo $nogdwarning; ?>
            </div>

            <div class="form_select">
                <label for="serendipity_addproject_entry"><?php echo PLUGIN_EVENT_TODOLIST_BLOGENTRY; ?></label>
                <select id="serendipity_addproject_entry" name="serendipity[add_project][entry]">
                    <?php echo $entrytext?>
                </select>
            </div>

            <div class="form_area">
                <label for="serendipity[add_project][desc]"><?php echo PLUGIN_EVENT_TODOLIST_PROJECTDESC; ?></label>
                <textarea  name="serendipity[add_project][desc]" id="serendipity[add_project][desc]"  rows="3"><?php echo $desc; ?></textarea>
            </div>

            <div class="form_buttons">
                <?php echo $button; ?>
            </div>
        </form>
<?php
    }

    function output_colorsadmin()  {
        global $serendipity;
        $display = $this->get_config('display');
        $categories = $this->build_categories();
        $maintitle = PLUGIN_EVENT_TODOLIST_ADD_COLOR;
        $button = '<input type="submit" name="ADD" title="' . GO . '"  value="' . GO . '">';
        echo '<h2>'.$maintitle.'</h2>';
?>
        <form class="serendipity_todolist_form" action="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=percentagedone&amp;serendipity[manage_colors]=1" method="post">
            <input type="hidden" name="serendipity[add_project][id]" value="<?php echo $id; ?>">

            <div class="form_field">
                <label for="serendipity_addcolor_title"><?php echo PLUGIN_EVENT_TODOLIST_ADDCOLOR_NAME; ?></label>
                <input id="serendipity_addcolor_title" type="text" name="serendipity[add_color][title]" size="10">
            </div>

            <div class="form_field">
                <label for="serendipity_addcolor_color1"><?php echo PLUGIN_EVENT_TODOLIST_ADDCOLOR_COLOR1; ?></label>
                <input id="serendipity_addcolor_color1" type="text" name="serendipity[add_color][color1]" size="7">
            </div>

            <div class="form_field">
                <label for="serendipity_addcolor_color2"><?php echo PLUGIN_EVENT_TODOLIST_ADDCOLOR_COLOR2; ?></label>
                <input id="serendipity_addcolor_color2" type="text" name="serendipity[add_color][color2]" size="7">
            </div>

            <div class="form_buttons">
                <?php echo $button; ?>
            </div>
        </form>
<?php
        echo '<h3>'.PLUGIN_EVENT_TODOLIST_MANAGE_COLORS.'</h3>';
        echo "<a class='button_link' href=# onclick=\"F1 = window.open('index.php?/plugin/colorwheel','Zoom','height=600,width=950,top=0,left=0,toolbar=no,menubar=no,location=no,resize=1,resizable=1,statusbar=0');\">".PLUGIN_EVENT_TODOLIST_COLORWHEEL.'</a>';
?>
        <form action="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=percentagedone&amp;serendipity[manage_colors]=1" method="post">
            <div class="serendipity_todolist_wrap">
                <table>
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th><?php echo PLUGIN_EVENT_TODOLIST_COLOR; ?></th>
                        <th colspan="2"><?php echo PLUGIN_EVENT_TODOLIST_COLOR1; ?></th>
                        <th colspan="2"><?php echo PLUGIN_EVENT_TODOLIST_COLOR2; ?></th>
                        <th><?php echo PLUGIN_EVENT_TODOLIST_SAMPLE; ?></th>
                    </tr>
                </thead>
                <tbody>
<?php
        $q = "SELECT *
                FROM {$serendipity['dbPrefix']}project_colors
            ORDER BY color_name ASC";
        $colors = serendipity_db_query($q);

        list($musec, $msec) = explode(' ', microtime());
        $srand = (float) $msec + ((float) $musec * 100000);
        srand($srand);
        mt_srand($srand);

        $barlength       = 120;
        $height          = $this->get_config('barheight');
        $fontsize        = $this->get_config('fontsize');
        $font            = $this->get_config('font');
        $font            = preg_replace('/_/', '----', $font);
        $backgroundcolor = $this->get_config('backgroundcolor');
        $backgroundcolor = preg_replace('/[^0-9a-fA-F]/','',$backgroundcolor);
        $outsidetext     = $this->get_config('outsidetext');
        $whitetextborder = serendipity_db_bool($this->get_config('whitetextborder'));

        foreach ($colors as $color) {
            $colorid    = $color['colorid'];
            $startcolor = $color['color1'];
            $startcolor = preg_replace('/[^0-9a-fA-F]/', '', $startcolor);
            $endcolor   = $color['color2'];
            $endcolor   = preg_replace('/[^0-9a-fA-F]/', '', $endcolor);

            $percentagecomplete = (int)mt_rand(1,10)*10;
            $imgsrc=$serendipity['baseURL'].($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/percentage_'.$percentagecomplete.'_'.$barlength.'_'.$height.'_'.$startcolor.'_'.$endcolor.'_'.$whitetextborder.'_'.$fontsize.'_'.$font.'_nocache_'.$outsidetext.'_'.$backgroundcolor;

            $color1 = $color['color1'];
            $color2 = $color['color2'];
            $color1 = preg_replace('/[^0-9a-fA-F]/', '', $color1);
            $color2 = preg_replace('/[^0-9a-fA-F]/', '', $color2);
?>
                    <tr>
                        <td class="form_check"><input type="checkbox" name="serendipity[color_to_remove][]" value="<?php echo $color['colorid']; ?>"></td>
                <!--
                <td style="border-bottom: 1px solid #000000" nowrap="nowrap" align="center">
                    <div><input type="text" name="serendipity[project_to_repercent][<?php echo $id?>]" value="<?php echo $percentagecomplete?>" size="3" />%</div>
                </td>
                -->
                        <td class="form_field"><input type="text" name="serendipity[color_to_rename][<?php echo $colorid?>]" value="<?php echo $color['color_name'] ?>" size="16"></td>
                        <td width="10" bgcolor="#<?php echo $color1 ?>"> </td>
                        <td class="form_field"><input type="text" name="serendipity[color_to_recolor1][<?php echo $colorid?>]" value="<?php echo $color['color1'] ?>" size="7"></td>
                        <td width="10" bgcolor="#<?php echo $color2 ?>"> </td>
                        <td class="form_field"><input type="text" name="serendipity[color_to_recolor2][<?php echo $colorid?>]" value="<?php echo $color['color2'] ?>" size="7"></td>
                        <td><img src="<?php echo $imgsrc ?>" height="<?php echo $height?>" width="<?php echo $barlength?>" alt=""></td>
                    </tr>
<?php
        }
?>
                </table>
            </div>

            <div class="form_buttons">
<?php
            echo '    <input type="submit" name="SAVE"   title="'.SAVE.'"    value="'.SAVE.'">';
            echo '    <input class="state_cancel" type="submit" name="REMOVE" title="'.REMOVE.'"  value="'.DELETE.'">';
?>
            </div>
        </form>
<?php
    }

    function output_categoryadmin()  {
        global $serendipity;
        $display    = $this->get_config('display');
        $categories = $this->build_categories();
        $q = "SELECT *
                FROM {$serendipity['dbPrefix']}project_colors
            ORDER BY color_name ASC";

        $colors = serendipity_db_query($q);

        $colortext = '<option value="0" selected="selected">' . USE_DEFAULT . "</option>\n";
        foreach ( $colors as $color ) {
            $colortext .= '<option value="'.$color['colorid'].'">'.$color['color_name']."</option>\n";
        }
        $maintitle = PLUGIN_EVENT_TODOLIST_ADD_CAT;
        $button = '<input type="submit" name="ADD" title="'.GO.'"  value="'.GO.'">';
        echo '<h2>'.$maintitle.'</h2>';
?>
        <form class="serendipity_todolist_form" action="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=percentagedone&amp;serendipity[manage_category]=1" method="post">
            <input type="hidden" name="serendipity[add_project][id]" value="<?php echo $id; ?>">

            <div class="form_field">
                <label for="serendipity_addcategory_title"><?php echo PLUGIN_EVENT_TODOLIST_CAT_NAME; ?></label>
                <input id="serendipity_addcategory_title" type="text" name="serendipity[add_category][title]" size="30">
            </div>

            <div class="form_select">
                <label for="serendipity_project_to_recat"><?php echo PLUGIN_EVENT_TODOLIST_PARENT_CATEGORY; ?></label>
                <?php echo $this->category_box('cat',$categories,$cat); ?>
            </div>

            <div class="form_select">
                <label for="serendipity_addcategory_colorid"><?php echo PLUGIN_EVENT_TODOLIST_COLOR; ?></label>
                <select id="serendipity_addcategory_colorid" name="serendipity[add_category][colorid]"><?php echo $colortext?></select>
            </div>

            <div class="form_buttons">
                <?php echo $button; ?>
            </div>
        </form>
<?php
        echo '<h3>'.PLUGIN_EVENT_TODOLIST_ADMINCAT.'</h3>';
?>
        <form action="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=percentagedone&amp;serendipity[manage_category]=1" method="post">
            <div class="serendipity_todolist_wrap">
                <table>
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th><?php echo CATEGORY; ?></th>
                        <th><span id="todolist_category_label"><?php echo PLUGIN_EVENT_TODOLIST_COLOR; ?></span></th>
                    </tr>
                </thead>
                <tbody>
<?php
        $q = "SELECT *
                FROM {$serendipity['dbPrefix']}project_category
            ORDER BY category_name DESC";

        $categories = serendipity_db_query($q);
        $categories = @serendipity_walkRecursive($categories, 'categoryid', 'parentid', VIEWMODE_THREADED);

        foreach ($categories as $category) {
            $colortext = '<option value="0" selected="selected">' . USE_DEFAULT . "</option>\n";
            foreach ($colors as $color) {
                if ($color['colorid'] == $category['colorid']) {
                    $colortext .= '<option value="'.$color['colorid'].'" selected="selected">'.$color['color_name']."</option>\n";
                } else {
                    $colortext .= '<option value="'.$color['colorid'].'">'.$color['color_name']."</option>\n";
                }
            }
?>
                    <tr>
                        <td class="form_check"><input type="checkbox" name="serendipity[category_to_remove][]" value="<?php echo $category['categoryid']; ?>"></td>
                        <td class="category_level_<?php echo $category['depth'] ?>"><?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($category['category_name']) : htmlspecialchars($category['category_name'], ENT_COMPAT, LANG_CHARSET)) ?></td>
                        <td class="form_select"><select aria-labelledby="todolist_category_label" name="serendipity[category_to_recolor][<?php echo $category['categoryid']?>]"><?php echo $colortext?></select></td>
                    </tr>
<?php
        }
?>
                </tbody>
                </table>
            </div>
            <div class="form_buttons">
<?php
            echo '    <input type="submit" name="SAVE" title="'.SAVE.'"  value="'.SAVE.'">';
            echo '    <input class="state_cancel" type="submit" name="REMOVE" title="'.REMOVE.'"  value="'.DELETE.'">';
?>
            </div>
        </form>
<?php
    }

    function set_query($display) {
        global $serendipity;

        switch($display) {
            case 'js_category':
            case 'category':
                $q = 'SELECT    s.project           AS project,
                                s.title             AS name,
                                s.percentagecomplete AS percentagecomplete,
                                s.category          AS cat_id,
                                s.id                AS id,
                                s.entry             AS entry,
                                s.hidden            AS hidden,
                                s.colorid           AS colorid
                                FROM    '.$serendipity['dbPrefix'].'percentagedone AS s
                                ORDER BY    s.category';
                break;

            case 'order_num':
                $q = 'SELECT    s.project           AS project,
                                s.title             AS name,
                                s.percentagecomplete AS percentagecomplete,
                                s.category          AS cat_id,
                                s.id                AS id,
                                s.entry             AS entry,
                                s.hidden            AS hidden,
                                s.colorid           AS colorid,
                                s.order_num         AS order_num
                                FROM    '.$serendipity['dbPrefix'].'percentagedone AS s
                                ORDER BY    s.order_num ASC';
                $this->tdoutput = '<th colspan="2">&nbsp;</th>';
                break;

            case 'dateacs':
                $q = 'SELECT    s.project           AS project,
                                s.title             AS name,
                                s.percentagecomplete AS percentagecomplete,
                                s.category          AS cat_id,
                                s.id                AS id,
                                s.entry             AS entry,
                                s.hidden            AS hidden,
                                s.colorid           AS colorid
                                FROM    '.$serendipity['dbPrefix'].'percentagedone AS s
                                ORDER BY date_added ASC';
                break;

            case 'progress':
                $q = 'SELECT    s.project              AS project,
                                s.title             AS name,
                                s.percentagecomplete AS percentagecomplete,
                                s.category          AS cat_id,
                                s.id                AS id,
                                s.entry             AS entry,
                                s.hidden            AS hidden,
                                s.colorid           AS colorid
                                FROM    '.$serendipity['dbPrefix'].'percentagedone AS s
                                ORDER BY percentagecomplete ASC, project ASC';
                break;

            case 'progressdesc':
                $q = 'SELECT    s.project              AS project,
                                s.title             AS name,
                                s.percentagecomplete AS percentagecomplete,
                                s.category          AS cat_id,
                                s.id                AS id,
                                s.entry             AS entry,
                                s.hidden            AS hidden,
                                s.colorid           AS colorid
                                FROM    '.$serendipity['dbPrefix'].'percentagedone AS s
                                ORDER BY percentagecomplete DESC, project ASC';
                break;

            case 'datedesc':
                $q = 'SELECT    s.project              AS project,
                                s.title             AS name,
                                s.percentagecomplete AS percentagecomplete,
                                s.category          AS cat_id,
                                s.id                AS id,
                                s.entry             AS entry,
                                s.hidden            AS hidden,
                                s.colorid           AS colorid
                                FROM    '.$serendipity['dbPrefix'].'percentagedone AS s
                                ORDER BY date_added DESC';
                break;

            default:
                $q = 'SELECT    s.project              AS project,
                                s.title             AS name,
                                s.percentagecomplete AS percentagecomplete,
                                s.category          AS cat_id,
                                s.id                AS id,
                                s.entry             AS entry,
                                s.hidden            AS hidden,
                                s.colorid           AS colorid
                                FROM    '.$serendipity['dbPrefix'].'percentagedone AS s
                                ORDER BY    s.project ASC';
                break;
        }
        return $q;
    }

    function check_gd() {
        if (function_exists('imagettftext') && function_exists('imagepng')) {
            return true;
        } else {
            return false;
        }
    }

    function build_categories() {
         global $serendipity;
         if ($this->get_config('category') == 'custom') {
             $table = $serendipity['dbPrefix'].'project_category';
         } else {
             $table = $serendipity['dbPrefix'].'category';
         }
         $q = "SELECT categoryid AS id,
                      category_name AS name
                 FROM $table
             ORDER BY category_name DESC";
         $sql = serendipity_db_query($q);
         $categories['0'] = '';
         if ($sql && is_array($sql)) {
             foreach($sql AS $key => $row) {
                 $categories[$row['id']] = $row['name'];
             }
         }
        return $categories;
    }

}

/* vim: set sts=4 ts=4 expandtab : */

?>