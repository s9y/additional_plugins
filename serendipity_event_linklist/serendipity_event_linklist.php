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

class serendipity_event_linklist extends serendipity_event {

    var $title = PLUGIN_LINKLIST_TITLE;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name', PLUGIN_LINKLIST_TITLE);
        $propbag->add('description', PLUGIN_LINKLIST_DESC);
        $propbag->add('event_hooks',  array('backend_sidebar_entries_event_display_linklist'  => true,
                                            'backend_sidebar_entries'                         => true,
                                            'backend_sidebar_admin_appearance'                => true,
                                            'plugins_linklist_input'                          => true,
                                            'css'                                             => true,
                                            'plugins_linklist_conf'                           => true,
                                            'external_plugin'                                 => true
                                            ));
        $propbag->add('author',        'Matthew Groeninger, Omid Mottaghi Rad');
        $propbag->add('version',       '2.02');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('stackable',     false);
        $propbag->add('groups', array('FRONTEND_VIEWS', 'BACKEND_FEATURES'));
    }

    function decode($string) {
        if (LANG_CHARSET != 'UTF-8') {
            return utf8_decode($string);
        }

        return $string;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_sidebar_entries_event_display_linklist':
                    if ($this->get_config('active')!='true') {
                        return false;
                    }
                    if (isset($_POST['REMOVE'])) {
                        if (isset($_POST['serendipity']['link_to_remove'])) {
                            foreach ($_POST['serendipity']['link_to_remove'] as $key) {
                                $this->del_link($key);
                            }
                        } else {
                            if (isset($_POST['serendipity']['category_to_remove'])) {
                                foreach ($_POST['serendipity']['category_to_remove'] as $key) {
                                    $this->del_category($key);
                                }
                            }
                        }
                    }

                    if (isset($_POST['SAVE'])) {
                        foreach ($_POST['serendipity']['link_to_recat'] AS $key => $row) {
                            $this->update_cat($key,$row);
                        }
                    }

                    if (isset($_POST['ADD'])) {
                       if (isset($_POST['serendipity']['add_link']['title']) && isset($_POST['serendipity']['add_link']['link'])) {
                            $this->add_link($_POST['serendipity']['add_link']['link'],$_POST['serendipity']['add_link']['title'],$_POST['serendipity']['add_link']['desc'],$_POST['serendipity']['link_to_recat']['cat']);
                       } else {
                           if (isset($_POST['serendipity']['add_category']['title'])) {
                               $this->add_cat($_POST['serendipity']['add_category']['title'],$_POST['serendipity']['link_to_recat']['cat']);
                           }
                       }
                    }

                    if (isset($_POST['EDIT'])) {
                       if (isset($_POST['serendipity']['add_link']['title']) && isset($_POST['serendipity']['add_link']['link'])&& isset($_POST['serendipity']['add_link']['id'])) {
                            $this->update_link($_POST['serendipity']['add_link']['id'],$_POST['serendipity']['add_link']['link'],$_POST['serendipity']['add_link']['title'],$_POST['serendipity']['add_link']['desc'],$_POST['serendipity']['link_to_recat']['cat']);
                       }
                    }
                    switch ($_GET['submit']){
                        case 'move up':
                            $this->move_up($_GET['serendipity']['link_to_move']);
                        break;

                        case 'move down':
                            $this->move_down($_GET['serendipity']['link_to_move']);
                        break;
                    }

                    if ($this->get_config('cache') == 'yes') {
                        if (@include_once("Cache/Lite.php")) {
                            $cache_obj = new Cache_Lite( array('cacheDir' => $serendipity['serendipityPath'].'templates_c/','automaticSerialization' => true));
                            $output = $this->generate_output(true);
                            $cache_obj->save($output,'linklist_cache');
                        } else {
                            $output = $this->generate_output(true);
                            $this->set_config('cached_output',$output);
                        }
                    }
                    if (isset($_GET['serendipity']['edit_link'])) {
                        $this->output_add_edit_linkadmin(TRUE,$_GET['serendipity']['edit_link']);
                    } else {
                        if (isset($_GET['serendipity']['manage_category'])) {
                            $this->output_categoryadmin(TRUE,$_GET['serendipity']['edit_link']);
                        } else {
                            $this->output_add_edit_linkadmin(FALSE);
                            $this->output_linkadmin();
                        }
                    }
                    return true;
                    break;

                case 'backend_sidebar_entries':
                    if ($this->get_config('active')=='true' && $serendipity['version'][0] < 2) {
                        echo "\n".'<li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist">' . PLUGIN_LINKLIST_ADMINLINK . '</a></li>';
                    }
                    return true;
                    break;

                case 'backend_sidebar_admin_appearance':
                    if ($this->get_config('active')=='true' && $serendipity['version'][0] > 1) {
                        echo "\n".'<li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist">' . PLUGIN_LINKLIST_ADMINLINK . '</a></li>';
                    }

                    return true;
                    break;

                case 'css':
                    if ($this->get_config('style') == 'dtree') {
                        $searchstr = '.dtree';
                        $filename = 'serendipity_event_dtree.css';
                    } else {
                        $searchstr = '.linklist';
                        $filename = 'serendipity_event_linklist.css';
                    }
                    // class exists in CSS by another Plugin, or a User has customized it and we don't need default
                    $pos = strpos($eventData, $searchstr);
                    if ($pos === false) {

                        $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
                        if (!$tfile || $tfile == $filename) {
                            $tfile = dirname(__FILE__) . '/' . $filename;
                        }
                        $eventData .= file_get_contents($tfile);
                    }

                    return true;
                    break;


                case 'external_plugin':
                    $uri_parts = explode('?', str_replace('&amp;', '&', $eventData));
                    $parts     = explode('&', $uri_parts[0]);
                    $uri_part = $parts[0];
                    switch($uri_part) {
                        case 'lldtree.js': // name unique!
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__).'/dtree.js');
                        break;
                        case 'linklist.js':
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__).'/linklist.js');
                        break;
                    }
                    return true;
                    break;

                case 'plugins_linklist_input':
                    $eventData['links'] = $this->generate_output(false);

                    return true;
                    break;

                case 'plugins_linklist_conf':
                    $this->set_config('style', $eventData['style']);
                    $this->set_config('display', $eventData['display']);
                    $this->set_config('category', $eventData['category']);
                    $this->set_config('cache', $eventData['cache']);

                    $eventData['changed'] = 'false';
                    if ($eventData['enabled']=='true') {
                        if ($this->get_config('active')!='true') {
                            $eventData['changed'] = 'true';
                            $this->set_config('active','true');
                            $this->set_config('active','true');
                            $this->set_config('category','custom');
                            $q   = 'SELECT count(id) FROM '.$serendipity['dbPrefix'].'links';
                            $sql = serendipity_db_query($q);
                            if ($sql[0][0] == 0) {
                                $xml = xml_parser_create('UTF-8');
                                xml_parse_into_struct($xml, '<list>'.serendipity_utf8_encode($eventData['links']).'</list>', $struct, $index);
                                xml_parser_free($xml);
                                $depth = -1;
                                for($level[]=0, $i=1, $j=1; isset($struct[$i]); $i++, $j++){
                                    if (isset($struct[$i]['type'])){
                                        if ($struct[$i]['type']=='open' && strtolower($struct[$i]['tag'])=='dir'){
                                            $this->add_cat($this->decode($struct[$i]['attributes']['NAME']),$in_cat[0]);
                                            $q   = 'SELECT categoryid FROM '.$serendipity['dbPrefix'].'link_category where category_name = "'.serendipity_db_escape_string($this->decode($struct[$i]['attributes']['NAME'])).'"';
                                            $sql = serendipity_db_query($q);
                                            $in_cat[] = $sql[0][0];
                                            $depth++;
                                        } else if($struct[$i]['type']=='close' && strtolower($struct[$i]['tag'])=='dir'){
                                            $blah = array_pop($in_cat);
                                            $depth--;
                                        } else if($struct[$i]['type']=='complete' && strtolower($struct[$i]['tag'])=='link'){
                                            $this->add_link($this->decode($struct[$i]['attributes']['LINK']),$this->decode($struct[$i]['attributes']['NAME']),$this->decode($struct[$i]['attributes']['DESCRIP']),$in_cat[$depth]);
                                        }
                                    }
                                }
                            }
                            if ($eventData['cache'] == 'yes') {
                                if (@include_once("Cache/Lite.php")) {
                                    $cache_obj = new Cache_Lite( array('cacheDir' => $serendipity['serendipityPath'].'templates_c/','automaticSerialization' => true));
                                    $output = $this->generate_output(true);
                                    $eventData['links'] = $output;
                                    $cache_obj->save($output,'linklist_cache');
                                } else {
                                    $output = $this->generate_output(true);
                                    $eventData['links'] = $output;
                                    $this->set_config('cached_output',$output);
                                }
                            }
                        }
                    } else {
                        if ($this->get_config('active') == 'true') {
                            $this->set_config('active', 'false');
                            $this->set_config('cache', 'no');
                            $this->set_config('display', 'category');
                            $eventData['links'] = $this->generate_output(true);
                            if (@include_once("Cache/Lite.php")) {
                                $cache_obj = new Cache_Lite(array('cacheDir' => $serendipity['serendipityPath'].'templates_c/','automaticSerialization' => true));
                                @$cache_obj->remove('linklist_cache');
                            } else {
                                $this->set_config('cached_output','');
                            }
                            $eventData['changed'] = 'true';
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
        $title = $this->title;
    }

    function generate_output($ignorecache) {
        global $serendipity;
        $cache = $this->get_config('cache');
        if ($cache == 'yes' && $ignorecache == false) {
            if (@include_once("Cache/Lite.php")) {
                $cache_obj = new Cache_Lite(array('cacheDir' => $serendipity['serendipityPath'].'templates_c/','automaticSerialization' => true));
                $output = $cache_obj->get('linklist_cache');
            } else {
                $output = $this->get_config('cached_output');
            }
        }
        if (!$output || $output == '') {
            $display = $this->get_config('display');
            if ($display == 'category' || $display == '') {
                if ($this->get_config('category') == 'custom') {
                    $table = $serendipity['dbPrefix'].'link_category';
                } else {
                   $table  = $serendipity['dbPrefix'].'category';
                }
                $output = $this->category_output($table,0,0);
            } else {
                $q   = $this->set_query($display);
                $sql = serendipity_db_query($q);
                if ($sql && is_array($sql)) {
                    foreach($sql AS $key => $row) {
                        $name = $row['name'];
                        $link = $row['link'];
                        $id   = $row['id'];
                        $descrip = $row['descrip'];
                        $output .= '<link name="'.(function_exists('serendipity_specialchars') ? serendipity_specialchars($name) : htmlspecialchars($name, ENT_COMPAT, LANG_CHARSET)).'" link="http://'.$link.'" descrip="'.(function_exists('serendipity_specialchars') ? serendipity_specialchars($descrip) : htmlspecialchars($descrip, ENT_COMPAT, LANG_CHARSET)).'" />'."\n";
                    }
                }
            }
            if ($cache == 'yes') {
                if (is_object($cache_obj)) {
                    $cache_obj->save($output,'linklist_cache');
                } else {
                    $output = $this->set_config('cached_output',$output);
                }
            }
        }
        return $output;
    }

    function category_output($table,$catid,$level)
    {
        global $serendipity;
        $output = '';
        $indent_int = ($level-1)*5;
        for ($counter = 0; $counter < $indent_int; $counter++) {
            $indent = $indent.' ';
        }
        $indent_int = ($level)*5;
        for ($counter = 0; $counter < $indent_int; $counter++) {
            $indent_link = $indent_link.' ';
        }

        $open_category = $indent.'<dir name="_catname_">'."\n";
        $close_category = $indent.'</dir>'."\n";
        $link_style = $indent_link.'<link name="_name_" link="http://_link_" descrip="_descrip_" />'."\n";

        if ($level == 0) {
            $catid = $level;
        } else {
            $q = 'SELECT s.* FROM '.$table.' AS s WHERE categoryid='.(int)$catid.' ORDER BY s.category_name ASC';
            $sql = serendipity_db_query($q);
            if ($sql && is_array($sql)) {
                $replace_name = "_catname_";
                $cat_name = $sql[0]['category_name'];

                $cat_open = true;
                $open_category = str_replace($replace_name,(function_exists('serendipity_specialchars') ? serendipity_specialchars($cat_name) : htmlspecialchars($cat_name, ENT_COMPAT, LANG_CHARSET)),$open_category);
                $output .= $open_category;
            } else {
                $cat_open = false;
            }
        }

        $q = 'SELECT s.* FROM '.$table.' AS s WHERE parentid='.(int)$catid.' ORDER BY s.category_name ASC';
        $sql = serendipity_db_query($q);
        if ($sql && is_array($sql)) {
            foreach($sql AS $key => $row) {
                 $output .= $this->category_output($table,$row['categoryid'],$level+1,$tags);
            }
        }
        $q = 'SELECT     s.link              AS link,
                         s.title             AS name,
                         s.descrip           AS descrip,
                         s.category          AS cat_id,
                         s.id                AS id
                         FROM    '.$serendipity['dbPrefix'].'links AS s
                         WHERE    s.category='.(int)$catid.' ORDER BY s.title ASC';
        $sql = serendipity_db_query($q);
        if ($sql && is_array($sql)) {
            foreach($sql AS $key => $row) {
                $link_out = $link_style;
                $name = $row['name'];
                $link = $row['link'];
                $id = $row['id'];
                $descrip = $row['descrip'];


                $replace_linkname = "_name_";
                $replace_link = "_link_";
                $replace_descrip = "_descrip_";

                $link_out = str_replace($replace_linkname,(function_exists('serendipity_specialchars') ? serendipity_specialchars($name) : htmlspecialchars($name, ENT_COMPAT, LANG_CHARSET)),$link_out);
                $link_out = str_replace($replace_link,$link,$link_out);
                $link_out = str_replace($replace_descrip,(function_exists('serendipity_specialchars') ? serendipity_specialchars($descrip) : htmlspecialchars($descrip, ENT_COMPAT, LANG_CHARSET)),$link_out);
                $output .=  $link_out;
            }
        }
        if ($cat_open == true) {
            $output .= $close_category;
        }
        return $output;
    }



    function cleanup() {
        global $serendipity;
        if ($this->get_config('cache') == 'yes') {
            if (@include_once("Cache/Lite.php")) {
                $cache_obj = new Cache_Lite( array('cacheDir' => $serendipity['serendipityPath'].'templates_c/','automaticSerialization' => true));
                $output = $this->generate_output();
                $cache_obj->save($output,'linklist_cache');
            } else {
                $output = $this->generate_output();
                $this->set_config('cached_output',$output);
            }
        }
        return true;
    }

    function install() {
        global $serendipity;
        // Create table
        $q   = "CREATE TABLE ".$serendipity['dbPrefix']."links (
                    id {AUTOINCREMENT} {PRIMARY},
                    date_added int(10) {UNSIGNED} NULL,
                    link varchar(250) default NULL,
                    title varchar(250) default NULL,
                    descrip text,
                    order_num int(4),
                    category int(11),
                    last_result int(4),
                    last_result_time int(10) {UNSIGNED} NULL,
                    num_bad_results int(11)
                )";

        $sql = serendipity_db_schema_import($q);

        $q   = "CREATE INDEX dateind ON {$serendipity['dbPrefix']}links (date_added);";
        $sql = serendipity_db_schema_import($q);

        $q   = "CREATE INDEX titleind ON {$serendipity['dbPrefix']}links (title);";
        $sql = serendipity_db_schema_import($q);

        $q   = "CREATE INDEX catind ON {$serendipity['dbPrefix']}links (category);";
        $sql = serendipity_db_schema_import($q);

        $q   = "CREATE TABLE ".$serendipity['dbPrefix']."link_category (
                    categoryid {AUTOINCREMENT} {PRIMARY},
                    category_name varchar(255) default NULL,
                    parentid int(11) default 0
                )";
        $sql = serendipity_db_schema_import($q);

        $this->set_config('active','false');
        $this->set_config('style', 'no');
        $this->set_config('display', 'category');
        $this->set_config('category', 'custom');
        $this->set_config('cache', 'false');
        $this->set_config('category','custom');
    }

    function uninstall(&$propbag) {
        global $serendipity;
        // Drop table
        $q   = "DROP TABLE ".$serendipity['dbPrefix']."links";
        $sql = serendipity_db_schema_import($q);
        $q   = "DROP TABLE ".$serendipity['dbPrefix']."link_category";
        $sql = serendipity_db_schema_import($q);
    }

    function add_link($link,$name,$desc,$catid = 0) {
        global $serendipity;

        $link = $this->clean_link($link);

        $q   = 'SELECT count(id) FROM '.$serendipity['dbPrefix'].'links';
        $sql = serendipity_db_query($q);

        $values['date_added'] = time();
        $values['link'] = $link;
        $values['title'] = $name;
        $values['descrip'] = $desc;
        $values['order_num'] = count($sql);
        $values['category'] = $catid;
        $values['order_num'] = $sql[0][0];
        serendipity_db_insert('links', $values);
    }

    function update_link($id, $link, $title, $desc, $catid) {
        global $serendipity;

        $link = $this->clean_link($link);

        $values['link'] = $link;
        $values['title'] = $title;
        $values['descrip'] = $desc;
        $values['category'] = $catid;
        $key['id'] = $id;
        serendipity_db_update('links', $key, $values);
    }

    function del_link($id) {
        global $serendipity;

        $q   = 'SELECT order_num FROM '.$serendipity['dbPrefix'].'links where id='.(int)$id;
        $sql = serendipity_db_query($q);

        if ($sql && is_array($sql)) {
            $res = $sql[0];
            $order_num = $res['order_num'];
            $q   = 'DELETE FROM '.$serendipity['dbPrefix'].'links where id='.(int)$id;
            $sql = serendipity_db_query($q);

            $q   = 'UPDATE '.$serendipity['dbPrefix'].'links SET order_num=order_num-1 where order_num > '.(int)$order_num;
            $sql = serendipity_db_query($q);
        }
    }

    function add_cat($name,$parent) {
        global $serendipity;

        $values['category_name'] = $name;
        $values['parentid'] = (empty($parent) ? 0 : $parent);
        serendipity_db_insert('link_category', $values);
    }

    function del_category($id) {
        global $serendipity;
        $q   = 'DELETE FROM '.$serendipity['dbPrefix'].'link_category where categoryid='.(int)$id;
        $sql = serendipity_db_query($q);

        $values['category'] = 0;
        $key['category'] = $id;
        serendipity_db_update('links', $key, $values);
    }

    function update_cat($id,$cat) {
        global $serendipity;

        $q   = 'UPDATE '.$serendipity['dbPrefix'].'links SET category = '.serendipity_db_escape_string($cat).' where id = '.(int)$id;
        $sql = serendipity_db_query($q);
    }

    function move_up($id) {
        global $serendipity;
        $q   = 'SELECT order_num FROM '.$serendipity['dbPrefix'].'links where id='.(int)$id;
        $sql = serendipity_db_query($q);

        if ($sql && is_array($sql)) {
            $res = $sql[0];
            $order_num = $res['order_num']-1;
            if ($order_num >= 0)
            {
                $q   = 'UPDATE '.$serendipity['dbPrefix'].'links SET order_num=order_num-1 where id = '.(int)$id;
                $sql = serendipity_db_query($q);

                $q   = 'UPDATE '.$serendipity['dbPrefix'].'links SET order_num=order_num+1 where order_num = '.(int)$order_num.' AND id !='.$id;
                $sql = serendipity_db_query($q);
            }
        }
    }

    function move_down($id) {
        global $serendipity;

        $q   = 'SELECT count(id) AS countit FROM '.$serendipity['dbPrefix'].'links';
        $sql = serendipity_db_query($q);
        if ($sql && is_array($sql)) {
            $res = $sql[0];
            $count = $res['countit'];
        } else {
            $count = 0;
        }

        global $serendipity;
        $q   = 'SELECT order_num FROM '.$serendipity['dbPrefix'].'links where id='.(int)$id;
        $sql = serendipity_db_query($q);

        if ($sql && is_array($sql)) {
            $res = $sql[0];
            $order_num = $res['order_num']+1;
            if ($order_num <= $count)
            {
                $q   = 'UPDATE '.$serendipity['dbPrefix'].'links SET order_num=order_num+1 where id = '.(int)$id;
                $sql = serendipity_db_query($q);

                $q   = 'UPDATE '.$serendipity['dbPrefix'].'links SET order_num=order_num-1 where order_num = '.(int)$order_num.' AND id !='.$id;
                $sql = serendipity_db_query($q);
            }
        }
    }


    function output_linkadmin() {
        global $serendipity;
        $display = $this->get_config('display');
        $q = $this->set_query($display);
        $categories = $this->build_categories();

        echo '<h3>'.PLUGIN_LINKLIST_ADMINLINK.'</h3>'."\n\n";
?>
        <form action="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist" method="post">
        <table border="0" cellpadding="5" cellspacing="0" width="100%">
            <tr>
                <td>&nbsp;</td>
                <td><strong><?php echo PLUGIN_LINKLIST_LINK_NAME; ?></strong></td>
                <td><strong><?php echo PLUGIN_LINKLIST_LINK; ?></strong></td>
                <td><strong><?php echo CATEGORY; ?></strong></td>
                <?php echo $tdoutput; ?>
            </tr>
<?php


        $sql = serendipity_db_query($q);
        if ($sql && is_array($sql)) {
            $sort_idx = 0;
            foreach($sql AS $key => $row) {
                $name = $row['name'];
                $link = $row['link'];
                $current_category = $row['cat_id'];
                $id = $row['id'];
                if ($display == 'order_num') {
                    if ($sort_idx == 0) {
                        $moveup   = '<td style="border-bottom: 1px solid #000000">&nbsp;</td>';
                    } else {
                        $moveup   = '<td style="border-bottom: 1px solid #000000"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist&amp;submit=move+up&amp;serendipity[link_to_move]=' . $id . '" style="border: 0"><img src="' . serendipity_getTemplateFile('admin/img/uparrow.png') .'" border="0" alt="' . UP . '" /></a></td>';
                    }
                    if ($sort_idx == (count($sql)-1)) {
                        $movedown = '<td style="border-bottom: 1px solid #000000">&nbsp;</td>';
                    } else {
                        $movedown = '<td style="border-bottom: 1px solid #000000">'.($moveup != '' ? '&nbsp;' : '') . '<a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist&amp;submit=move+down&serendipity[link_to_move]=' . $id . '" style="border: 0"><img src="' . serendipity_getTemplateFile('admin/img/downarrow.png') . '" alt="'. DOWN .'" border="0" /></a></td>';
                    }
                }
?>
                <tr>
                    <td style="border-bottom: 1px solid #000000" align="right">
                        <div>
                           <input class="input_checkbox" type="checkbox" name="serendipity[link_to_remove][]" value="<?php echo $id; ?>" />
                         </div>
                    </td>
                    <td style="border-bottom: 1px solid #000000"><strong><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist&amp;serendipity[edit_link]=<?php echo $id; ?>"><?php echo $name; ?></a></strong></td>
                    <td style="border-bottom: 1px solid #000000" nowrap="nowrap">
                        <div><?php echo $link?></div>
                    </td>
                    <td style="border-bottom: 1px solid #000000">
                    <?php echo $this->category_box($id,$categories,$current_category); ?>

                    </td>
                    <?php echo $moveup ?>
                    <?php echo $movedown ?>
                </tr>
<?php
                $sort_idx++;
            }
            echo '
            </table>
        <div>
            <input type="submit" name="REMOVE" title="'.REMOVE.'"  value="'.DELETE.'" class="serendipityPrettyButton input_button state_cancel" />
            <span>&nbsp;</span>
            <input type="submit" name="SAVE" title="'.SAVE.'"  value="'.SAVE.'" class="serendipityPrettyButton input_button" />
        </div>
    </form>';
        }
    }

    function category_box($id,$categories,$current_category = 0)
    {
        $x = "\n<select name=\"serendipity[link_to_recat][".$id."]\">\n";
        foreach ($categories as $k => $v) {
            $x .= "    <option value=\"$k\"" . ($k == $current_category ? ' selected="selected"' : '') . ">$v</option>\n";
        }
        return $x . "</select>\n";
    }

    function output_add_edit_linkadmin($edit = FALSE,$id = -1) {
        global $serendipity;
        $display = $this->get_config('display');
        $categories = $this->build_categories();
        if ($edit) {
            $maintitle = PLUGIN_LINKLIST_EDITLINK;
            $q = 'SELECT link,title,category,descrip FROM '.$serendipity['dbPrefix'].'links WHERE id = '.(int)$id;
            $sql = serendipity_db_query($q);
            if ($sql && is_array($sql)) {
                $res = $sql[0];
                $link = $res['link'];
                $title = $res['title'];
                $cat = $res['category'];
                $desc = $res['descrip'];
            }
            $button = '<input type="submit" name="EDIT" title="'.EDIT.'"  value="'.EDIT.'" class="serendipityPrettyButton input_button" />';
        } else {
            $maintitle = PLUGIN_LINKLIST_ADDLINK;
            $button = '<input type="submit" name="ADD" title="'.ADD.'"  value="'.ADD.'" class="serendipityPrettyButton input_button" />';
        }

        if ($this->get_config('category') == 'custom') {
            $catlink = '(<a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist&amp;serendipity[manage_category]=1">'.PLUGIN_LINKLIST_ADD_CAT.'</a>)';
        }
        echo '<h3>'.$maintitle.'</h3>';
?>
        <form action="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist" method="post">
            <input type="hidden" name="serendipity[add_link][id]" value="<?php echo $id; ?>">
            <table border="0" cellpadding="5" cellspacing="0" width="100%">
                <tr><td><?php echo PLUGIN_LINKLIST_LINK.'<div style="font-size: smaller;">'.PLUGIN_LINKLIST_LINK_EXAMPLE.'</div>'; ?></td><td><input class="input_textbox" type="text" name="serendipity[add_link][link]" value="<?php echo $link; ?>" size="30" /></td></tr>
                <tr><td><?php echo PLUGIN_LINKLIST_LINK_NAME; ?></td><td><input class="input_textbox" type="text" name="serendipity[add_link][title]" value="<?php echo $title; ?>" size="30" /></td></tr>
                <tr><td><?php echo CATEGORY; ?> <?php echo $catlink;?></td><td><?php echo $this->category_box('cat',$categories,$cat); ?></td></tr>
                <tr><td valign="top"><?php echo PLUGIN_LINKLIST_LINKDESC; ?></td><td><textarea style="width: 100%" name="serendipity[add_link][desc]" id="serendipity[add_link][desc]" cols="80" rows="3"><?php echo $desc; ?></textarea></td></tr>

<?php
        echo '
            </table>
            <div>
                ' . $button . '
            </div>
        </form>';
    }

    function output_categoryadmin()  {
        global $serendipity;
        $display = $this->get_config('display');
        $categories = $this->build_categories();
        $maintitle = PLUGIN_LINKLIST_ADD_CAT;
        $button = '<input type="submit" name="ADD" title="' . ADD . '"  value="' . ADD . '" class="serendipityPrettyButton input_button" />';

        echo '<h3>'.$maintitle.'</h3>';
?>
        <form action="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist&amp;serendipity[manage_category]=1" method="post">
            <input type="hidden" name="serendipity[add_link][id]" value="<?php echo $id; ?>">
            <table border="0" cellpadding="5" cellspacing="0" width="100%">
                <tr>
                    <td><?php echo PLUGIN_LINKLIST_CAT_NAME; ?></td>
                    <td><input class="input_textbox" type="text" name="serendipity[add_category][title]" size="30" /></td>
                </tr>
                <tr>
                    <td><?php echo PLUGIN_LINKLIST_PARENT_CATEGORY; ?></td>
                    <td><?php echo $this->category_box('cat',$categories,$cat); ?></td>
                </tr>
<?php
        echo '
            </table>
            <div>
                ' . $button . '
            </div>
        </form>

        <h3>' . PLUGIN_LINKLIST_ADMINCAT . '</h3>
        <a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist">' . PLUGIN_LINKLIST_ADMINLINK . '</a>';

?>
        <form action="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist&amp;serendipity[manage_category]=1" method="post">
        <table border="0" cellpadding="1" cellspacing="0" width="100%">
            <tr>
                <td></td>
                <td><strong><?php echo CATEGORY; ?></strong></td>
            </tr>
<?php
        $q = 'SELECT s.* FROM '.$serendipity['dbPrefix'].'link_category AS s
            ORDER BY s.category_name DESC';

        $categories = serendipity_db_query($q);
        $categories = @serendipity_walkRecursive($categories, 'categoryid', 'parentid', VIEWMODE_THREADED);

        foreach ( $categories as $category ) {
?>
            <tr>
                <td width="16">
                    <input class="input_checkbox" type="checkbox" name="serendipity[category_to_remove][]" value="<?php echo $category['categoryid']; ?>" />
                </td>
                <td width="300" style="padding-left: <?php echo ($category['depth']*15)+20 ?>px">
                    <img src="<?php echo serendipity_getTemplateFile('admin/img/folder.png') ?>" style="vertical-align: bottom;"> <?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($category['category_name']) : htmlspecialchars($category['category_name'], ENT_COMPAT, LANG_CHARSET)) ?>
                </td>
            </tr>
<?php
        }
        echo '
            </table>
        <div>
            <input type="submit" name="REMOVE" title="' . REMOVE . '"  value="' . DELETE . '" class="serendipityPrettyButton input_button state_cancel" />
        </div>
        <div style="font-size: smaller;">' . PLUGIN_LINKLIST_DELETE_WARN . '</div>
    </form>';

    }


    function set_query($display) {
        global $serendipity;
               $q = 'SELECT s.link     AS link,
                            s.title    AS name,
                            s.descrip  AS descrip,
                            s.category AS cat_id,
                            s.id       AS id
                       FROM '.$serendipity['dbPrefix'].'links AS s ';
        switch($display) {
            case 'category':
                   $q .= 'ORDER BY s.category';
                break;
            case 'order_num':
                   $q .= 'ORDER BY s.order_num ASC';
                break;

            case 'dateacs':
                   $q .= 'ORDER BY date_added ASC';
                break;

            case 'datedesc':
                   $q .= 'ORDER BY date_added DESC';
                break;
            default:
                   $q .= 'ORDER BY s.title ASC';
                break;
        }
        return $q;
    }

    function build_categories() {
         global $serendipity;
         if ($this->get_config('category') == 'custom') {
             $table = $serendipity['dbPrefix'].'link_category';
         } else {
             $table = $serendipity['dbPrefix'].'category';
         }
         $q = 'SELECT s.categoryid AS id,
                      s.category_name AS name
                 FROM '.$table.' AS s
             ORDER BY s.category_name DESC';
         $sql = serendipity_db_query($q);
         $categories['0'] = '';
         if ($sql && is_array($sql)) {
             foreach($sql AS $key => $row) {
                 $categories[$row['id']] = $row['name'];
             }
         }
        return $categories;
    }

    function clean_link($link) {
        $parts_arr = parse_url($link);
        if (strcmp($parts_arr['pass'], '') != 0) {
            $ret_url .= $parts_arr['user'];
        }
        if (strcmp($parts_arr['pass'], '') != 0) {
         $ret_url .= ':' . $parts_arr['pass'];
        }
        if ((strcmp($parts_arr['user'], '') != 0) || (strcmp($parts_arr['pass'], '') != 0)) {
         $ret_url .= '@';
        }
        $ret_url .= $parts_arr['host'];
        if (strcmp($parts_arr['port'], '') != 0) {
           $ret_url .= ':' . $parts_arr['port'];
        }
        $ret_url .= $parts_arr['path'];
        if (strcmp($parts_arr['query'], '') != 0) {
            $ret_url .= '?' . $parts_arr['query'];
        }
        if (strcmp($parts_arr['fragment'], '') != 0) {
            $ret_url .= '#' . $parts_arr['fragment'];
        }
        return $ret_url;
    }
}
/* vim: set sts=4 ts=4 expandtab : */
