<?php # $Id$

class media_sidebar extends subplug_sidebar {

    function introspect_custom()
    {
        return array('media_hotlinks_only','media_hotlink_base','media_base_directory','media_image_strict','media_rotate_time','media_number_images','media_fixed_width','media_linkbehavior','media_url','media_gal_permalink','media_intro','media_summery','media_next_update','media_cache_output');
    }

    function introspect_config_item_custom($name, &$propbag)
    {
        global $serendipity;
        switch($name) {
            case 'media_base_directory':
                if ($this->get_config('media_hotlinks_only','no')== 'no') {
                    $select['gallery'] = ALL_DIRECTORIES; 
                    $paths = serendipity_traversePath($serendipity['serendipityPath'] . $serendipity['uploadPath']);
                    foreach ( $paths as $folder ) {
                         $select[$folder['relpath']] = str_repeat('-', $folder['depth']) . ' '. $folder['name'];
                    } 
                    $propbag->add('type', 'select');
                    $propbag->add('name', PLUGIN_SIDEBAR_MEDIASIDEBAR_DIRECTORY_NAME);
                    $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_DIRECTORY_DESC);
                    $propbag->add('select_values', $select);
                }
                break;

            case 'media_image_strict':
                if ($this->get_config('media_hotlinks_only','no') == 'no') {
                    $propbag->add('type', 'radio');
                    $propbag->add('name', PLUGIN_SIDEBAR_MEDIASIDEBAR_IMAGESTRICT_NAME);
                    $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_IMAGESTRICT_DESC);
                    $propbag->add('radio',
                              array( 'value' => array('yes','no'),
                              'desc'  => array(YES,NO)
                          ));
                    $propbag->add('radio_per_row', '2');
                    $propbag->add('default', 'yes');
                }
               break;

            case 'media_number_images':
                  $propbag->add('type',        'string');
                  $propbag->add('name',        PLUGIN_SIDEBAR_MEDIASIDEBAR_NUMIMAGES_NAME);
                  $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_NUMIMAGES_DESC);
                  $propbag->add('default',     '1');
            break;

            case 'media_rotate_time':
                  $propbag->add('type',        'string');
                  $propbag->add('name',        PLUGIN_SIDEBAR_MEDIASIDEBAR_ROTATETIME_NAME);
                  $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_ROTATETIME_DESC);
                  $propbag->add('default',     '60');
            break;

            case 'media_linkbehavior':
                  $select["inpage"] = PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_INPAGE;
                  $select["popup"] = PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_POPUP;
                  $select["url"] = PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_URL;
                  $select["entry"] = PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_ENTRY;
                  if (class_exists('serendipity_event_usergallery')){
                      $select["gallery"] = PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_GALLERY;
                  }
                  $propbag->add('type', 'select');
                  $propbag->add('name', PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_NAME);
                  $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_DESC);
                  $propbag->add('select_values', $select);
                  $propbag->add('default', 'inpage');
               break;

            case 'media_fixed_width':
                  $propbag->add('type',        'string');
                  $propbag->add('name',        PLUGIN_SIDEBAR_MEDIASIDEBAR_WIDTH_NAME);
                  $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_WIDTH_DESC);
                  $propbag->add('default',     '162');
               break;


            case 'media_url':
               if ($this->get_config('media_linkbehavior') == 'url') {
                  $propbag->add('type',        'string');
                  $propbag->add('name',        PLUGIN_SIDEBAR_MEDIASIDEBAR_URL_NAME);
                  $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_URL_DESC);
                  $propbag->add('default',     $serendipity['baseURL']);
               }
               break;


            case 'media_gal_permalink':
               if ($this->get_config('media_linkbehavior') == 'gallery') {
                  $propbag->add('type',        'string');
                  $propbag->add('name',        PLUGIN_SIDEBAR_MEDIASIDEBAR_GALPERM_NAME);
                  $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_GALPERM_DESC);
                  $propbag->add('default',     $serendipity['rewrite'] != 'none' 
                                             ? $serendipity['serendipityHTTPPath'] . 'pages/gallery.html'
                                             : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?serendipity[subpage]=gallery');
               }
               break;

            case 'media_intro':
                  $propbag->add('type',        'html');
                  $propbag->add('name',        PLUGIN_SIDEBAR_MEDIASIDEBAR_INTRO);
                  $propbag->add('description', '');
                  $propbag->add('default',     '');
               break;

            case 'media_summery':
                  $propbag->add('type',        'html');
                  $propbag->add('name',        PLUGIN_SIDEBAR_MEDIASIDEBAR_SUMMERY);
                  $propbag->add('description', '');
                  $propbag->add('default',     '');
               break;

            case 'media_hotlinks_only':
                $propbag->add('type', 'radio');
                $propbag->add('name', PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKS_NAME);
                $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKS_DESC);
                $propbag->add('radio',
                          array( 'value' => array('yes','no'),
                          'desc'  => array(YES,NO)
                      ));
                $propbag->add('radio_per_row', '2');
                $propbag->add('default', 'no');
               break;

            case 'media_hotlink_base':
                if ($this->get_config('media_hotlinks_only','no')== 'yes') {
                  $propbag->add('type',        'string');
                  $propbag->add('name',        PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKBASE_NAME);
                  $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKBASE_DESC);
                  $propbag->add('default',     '');
                }
                break;

            default:
                return false;
            break;
            }
        return true;
    }

    function generate_content_custom(&$title) {
        global $serendipity;
        $update = true;
        $rotate_time = $this->get_config('media_rotate_time');
        $next_update = $this->get_config('media_next_update','');

        if (@include_once("Cache/Lite.php")) {
            $cache_obj = new Cache_Lite( array('cacheDir' => $serendipity['serendipityPath'].'templates_c/','automaticSerialization' => true));
            $cache_output = $cache_obj->get('mediasidebar_cache');
        } else {
            $cache_output = $this->get_config('media_cache_output','');
        }
        if ($rotate_time !=0 ) {
            if ($next_update > time()) {
               $update = false;
            } else {
               $next_update = $this->calc_update_time($rotate_time,$next_update);
               $this->set_config('media_next_update',$next_update);
            }
        }
        $title = $this->get_config('title', $this->title);
        if ($update || $cache_output == '') {
            $output_str = '';
            if ($this->get_config('media_image_strict') == 'yes') {
                $strict = true;
            } else {
                $strict = false;
            }


            if ($this->get_config('media_hotlinks_only','no')== 'yes') {
                $dir_extension = $this->get_config('media_hotlink_base','');
                if ($dir_extension != '' ) {
                    $dir_extension = $dir_extension . '%';                    
                }
                $directory = "http://%" . $dir_extension;
                $strict = false;
            } else {
                $directory = $this->get_config('media_base_directory');
            }

            if (version_compare((float)$serendipity['version'],'1.1','>=')) {
                if ($directory == 'gallery') {$directory = '';}
                $images_all = serendipity_fetchImagesFromDatabase(0, 0, $total, false, false, $directory,'','', array(), $strict);
            } else {
                $images_all = $this->mediasidebar_getimage($directory,$strict);
            }
            $number = $this->get_config('media_number_images');
            $total_count = count($images_all);
            if ($total_count < $number) {
                $number = $total_count;
            }

            $images = array();
            $random_check = array();
            for ( $counter = 0; $counter < $number; $counter += 1) {
                $checkit = rand(0, $total_count-1);
                while (in_array($checkit,$random_check)) {
                    $checkit = rand(0, $total_count);
                }
                $random_check[] = $checkit;
                $images[] = $images_all[$checkit];
            }

            $width_test = $this->get_config('media_fixed_width');
            if ($width_test > 0) {
                $width_str = 'width:'.$width_test.'px;';
            }

            if (is_array($images)) {
                $output_str .= $this->get_config('media_intro');
                foreach ($images as $image) {
                    if (isset($image['name'])) {
                        if ($image['hotlink'] == 1) {
                            $thumb_path = $image_path = $image['path'];
                        } else {
                            $image_path = $serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$image['path'].$image['name'].'.'.$image['extension'];
                            $thumb_path = $serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$image['path'].$image['name'].'.'.$image['thumbnail_name'].'.'.$image['extension'];
                            if (!serendipity_isImage($image)) {
                                $thumb_path = serendipity_getTemplateFile('admin/img/mime_unknown.png');
                                $width_str ='';
                            }
                        }

                        $output_str .= '<div style="padding-top: 5px;">';
                        switch ($this->get_config("media_linkbehavior")) {
                            case 'entry':
                                $e = $this->fetchLinkedEntries($image['id'], $image_path, $thumb_path, true);
                                if (is_array($e)) {
                                    $link = serendipity_archiveURL($e[0]['id'], $e[0]['title'], 'serendipityHTTPPath', true, array('timestamp' => $e[0]['timestamp']));
                                } else {
                                    $link = $image_path;
                                }
                                $output_str .= '<a href="' . $link . '" title="' . htmlspecialchars($e[0]['title']) . '"><img style="border: 0px; '.$width_str .'" src="'.$thumb_path.'" alt="" /></a>';
                            break;
                            case 'popup':
                                $output_str .= '<a href="'.$image_path.'" onclick="F1 = window.open(\''.$image_path.'\',\'Zoom\',\'height='.$image['dimensions_height'].',width='.$image['dimensions_width'].',top=298,left=354,toolbar=no,menubar=no,location=no,resize=1,resizable=1,scrollbars=yes\'); return false;"><img style="border: 0px; '.$width_str .'" src="'.$thumb_path.'" alt="" /></a>';
                            break;
                            case 'url':
                                $output_str .= '<a href="'.$this->get_config('media_url').'"><img style="border: 0px; '.$width_str .'" src="'.$thumb_path.'" alt="" /></a>';
                            break;
                            case 'gallery':
                                $gallery_str = $this->get_config('media_gal_permalink');
                                if (strstr($gallery_str,'?')) {
                                    $gallery_str = $gallery_str.'&serendipity[image]='.$image['id'];
                                } else {
                                    $gallery_str = $gallery_str.'?serendipity[image]='.$image['id'];
                                }
                                $output_str .= '<a href="'.$gallery_str.'"><img style="border: 0px; '.$width_str .'" src="'.$thumb_path.'" alt="" /></a>';
                            break;
                            case 'inpage':
                            default:
                                $output_str .= '<a href="'.$image_path.'"><img style="border: 0px; '.$width_str .'" src="'.$thumb_path.'" alt="" /></a>';
                            break;
                        }
                        $output_str .= '</div>';
                    }
                }
                $output_str .= $this->get_config('media_summery');
            } else {
                $output_str = 'Error accessing images.';
            }

            if (class_exists('Cache_Lite') && is_object($cache_obj)) {
                $cache_obj->save($output_str,'mediasidebar_cache');
            } else {
                $this->set_config('media_cache_output',$output_str);
            }
        } else {
            $output_str = $cache_output;
        }
        echo $output_str;

    }    

    function mediasidebar_getimage($directory,$strict = false) {
        global $serendipity;

        if ($directory == 'gallery') {$directory = '';}

        if (!$strict) {
            if ($directory == '') {
               $directorysql = '';
            } else {
               $directorysql = "WHERE path LIKE '".serendipity_db_escape_string($directory)."%'";
            }
        } else {
            $directorysql = "WHERE path = '".serendipity_db_escape_string($directory)."'";
        }
        $query = "SELECT * FROM {$serendipity['dbPrefix']}images $directorysql";
        $rs = serendipity_db_query($query, false, 'assoc');
        if (!is_array($rs)) return false;

        return $rs;
    }

    function cleanup_custom()  {
        $this->set_config('media_next_update','');
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

    // Fetches a list of referenced entries
    function fetchLinkedEntries($id, $big, $thumb, $single = false) {
        global $serendipity;

        if (strtolower($serendipity['dbType']) != 'mysql' && strtolower($serendipity['dbType']) != 'mysqli') {
            return false;
        }

        $q = "SELECT e.id, e.timestamp, e.title
                FROM {$serendipity['dbPrefix']}entries AS e
               WHERE (MATCH(e.title, e.body, e.extended) AGAINST ('" . serendipity_db_escape_string($big) . "')
                  OR MATCH(e.title, e.body, e.extended) AGAINST ('" . serendipity_db_escape_string($thumb) . "'))
                 AND (e.body    REGEXP '(" . preg_quote(serendipity_db_escape_String($thumb)) . "|" . preg_quote(serendipity_db_escape_string($big)) . ")'
                  OR e.extended REGEXP '(" . preg_quote(serendipity_db_escape_String($thumb)) . "|" . preg_quote(serendipity_db_escape_string($big)) . ")')
                 AND e.isdraft = 'false'
            ORDER BY e.timestamp DESC";
        $e = serendipity_db_query($q, false, 'assoc');

        if (is_array($e)) {
            $_e = $e;
            $e = array();
            foreach($_e AS $idx => $item) {
                $e[$item['id']] = $item;
            }
        }

        if ($single && is_array($e)) {
            reset($e);
            $return = array(
                0 => current($e)
            );
            return $return;
        }

        return $e;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
