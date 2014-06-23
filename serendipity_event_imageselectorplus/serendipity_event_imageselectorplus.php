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

if (!function_exists('ifRemember')) {
    // dummy stub function for older 0.9 versions

    function ifRemember($a = null, $b = null, $c = null, $d = null) {
        return true;
    }
}

class serendipity_event_imageselectorplus extends serendipity_event
{
    var $title = PLUGIN_EVENT_IMAGESELECTORPLUS_NAME;
    var $gotMilk = false;
    var $cache = array();

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_IMAGESELECTORPLUS_NAME);
        $propbag->add('description',   PLUGIN_EVENT_IMAGESELECTORPLUS_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Vladimir Ajgl, Adam Charnock, Ian');
        $propbag->add('version',       '0.38');
        $propbag->add('requirements',  array(
            'serendipity' => '1.3',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('IMAGES','MARKUP'));

        $propbag->add('event_hooks',   array(
            'entries_header' => true,
            'entry_display' => true,
            'backend_entry_presave' => true,
            'backend_publish' => true,
            'backend_save' => true,
            'frontend_image_add_unknown' => true,
            'frontend_image_add_filenameonly' => true,
            'frontend_image_selector_submit' => true,
            'frontend_image_selector_more' => true,
            'frontend_image_selector_imagecomment' => true,
            'frontend_image_selector_imagelink' => true,
            'frontend_image_selector_imagealign' => true,
            'frontend_image_selector_imagesize' => true,
            'frontend_image_selector_hiddenfields' => true,
            'frontend_image_selector' => true,
            'backend_image_add' => true,
            'backend_image_addHotlink' => true,
            'backend_image_addform' => true,
            'css_backend' => true,
            'frontend_display' => true
        ));

        $this->markup_elements = array(
            array(
              'name'     => 'ENTRY_BODY',
              'element'  => 'body',
            ),
            array(
              'name'     => 'EXTENDED_BODY',
              'element'  => 'extended',
            )
        );

        $conf_array = array('thumb_max_width', 'thumb_max_height','unzipping', 'autoresize', 'force_jhead');

        foreach($this->markup_elements as $element) {
            $conf_array[] = $element['name'];
        }
        $propbag->add('configuration', $conf_array);
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch ($name) {
            case 'force_jhead':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_IMAGESELECTORPLUS_JHEAD);
                $propbag->add('description', PLUGIN_EVENT_IMAGESELECTORPLUS_JHEAD_DESC);
                $propbag->add('default', 'false');
                break; 

            case 'thumb_max_width':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_IMAGESELECTORPLUS_MAXWIDTH);
                $propbag->add('description', '');
                $propbag->add('default', '0');
                break;

            case 'thumb_max_height':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_IMAGESELECTORPLUS_MAXHEIGHT);
                $propbag->add('description', '');
                $propbag->add('default', '0');
                break;

            case 'unzipping':
                if (class_exists('ZipArchive')) {
                    $propbag->add('type', 'boolean');
                    $propbag->add('name', PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES);
                    $propbag->add('description', PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_BLABLAH);
                    $propbag->add('default', 'true');
                }
                break;

            case 'autoresize':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_IMAGESELECTORPLUS_AUTORESIZE);
                $propbag->add('description', PLUGIN_EVENT_IMAGESELECTORPLUS_AUTORESIZE_DESC);
                $propbag->add('default', 'false');
                break;

            default:
                if (class_exists('SimpleXMLElement')) {
                    $propbag->add('type',        'boolean');
                    $propbag->add('name',        constant($name));
                    $propbag->add('description', sprintf(APPLY_MARKUP_TO," - ".constant($name)));
                    $propbag->add('default', 'true');
                }
                break;
        }

        return true;
    }

    // to recash all entries after installing the plugin
    function install() {
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    // to recash all entries after uninstalling the plugin
    function uninstall(&$propbag) {
        serendipity_plugin_api::hook_event('backend_cache_purge', $this->title);
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function httpize($path) {
        global $serendipity;

        if (preg_match('@' . $serendipity['uploadPath'] . '(.+)$@imsU', $path, $match)) {
            return $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $match[1];
        }

        return preg_replace('@^' . preg_quote($_SERVER['DOCUMENT_ROOT']) . '(.*)$@imsU', '\1', $path);
    }

    function selected() {
        global $serendipity;

        if ($serendipity['GET']['subpage'] == 's9yisp') {
            return true;
        }

        return false;
    }

    function resizeThumb($sizes, $target) {
        global $serendipity;

        // Thumbsize: 75
        // A: 100x300
        // B: 300x100

        // s9y A: 25x75
        // s9y B: 75x25

        // Max-Height: 0
        // Max-Width : 75
        // s9y A:
        // s9y B:

        // Max-Height: 0
        // Max-Height: 75
        // s9y A: 25x75
        // s9y B: 225x75

        $fdim     = @serendipity_getimagesize($target, '', '');

        if (!isset($serendipity['thumbConstraint'])) {
        // Original code, for older versions of s9y
        $s9ysizes = serendipity_calculate_aspect_size($fdim[0], $fdim[1], $serendipity['thumbSize']);
        if ($fdim[0] >= $fdim[1]) {
            $orientation = 'Landscape';
        } else {
            $orientation = 'Portrait';
        }

        if ($sizes['width'] == 0) {
            if ($orientation == 'Landscape') {
                $_newsizes = serendipity_calculate_aspect_size($fdim[0], $fdim[1], null, $sizes['height']);
            } else {
                $_newsizes = serendipity_calculate_aspect_size($fdim[0], $fdim[1], $sizes['height'], null);
            }
            $newsizes  = array('width' => $_newsizes[0], 'height' => $_newsizes[1]);
        } elseif ($sizes['height'] == 0) {
            if ($orientation == 'Landscape') {
                $_newsizes = serendipity_calculate_aspect_size($fdim[0], $fdim[1], $sizes['width'], null);
            } else {
                $_newsizes = serendipity_calculate_aspect_size($fdim[0], $fdim[1], null, $sizes['width']);
            }
            $newsizes  = array('width' => $_newsizes[0], 'height' => $_newsizes[1]);
        } else {
            $newsizes = $sizes;
            array(
                0 => $sizes['width'],
                1 => $sizes['height']
            );
        }
        } else {
            // Newer s9y version that understands how to constrain images properly
            $s9ysizes = serendipity_calculate_aspect_size($fdim[0], $fdim[1], $serendipity['thumbSize'], $serendipity['thumbConstraint']);
            $orientation = 'size';
            if ($sizes['width'] == 0) {
                $_newsizes = serendipity_calculate_aspect_size($fdim[0], $fdim[1], $sizes['height'], 'height');
            } elseif ($sizes['height'] == 0) {
                $_newsizes = serendipity_calculate_aspect_size($fdim[0], $fdim[1], $sizes['width'], 'width');
            } else {
                $_newsizes = $sizes;
            }
            $newsizes  = array('width' => $_newsizes[0], 'height' => $_newsizes[1]);
        }

        echo "Resizing thumb of " . $orientation . " " . $fdim[0] . "x" . $fdim[1] . " to " . $_newsizes[0] . "x" . $_newsizes[1] . " instead of " . $s9ysizes[0] . "x" . $s9ysizes[1] . "...<br />\n";
        $dirname = dirname($target) . '/';
        $dirname = str_replace($serendipity['serendipityPath'] . $serendipity['uploadPath'], '', $dirname);
        serendipity_makeThumbnail(basename($target), $dirname, $newsizes, $serendipity['thumbSuffix']);
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_image_addform':
                if ($serendipity['version'][0] < '2') {
                    if (class_exists('ZipArchive')) {
                        $checkedY = "";
                        $checkedN = "";
                        $this->get_config('unzipping') ? $checkedY = ' checked="checked"' : $checkedN = ' checked="checked"';
?>
            <br />
            <div>
                <strong><?php echo PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES;?></strong><br />
                <?php echo PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_DESC;?>
                <div>
                    <input type="radio" class="input_radio" id="unzip_yes" name="serendipity[unzip_archives]" value="<?php echo YES;?>"<?php echo $checkedY;?>><label for="unzip_yes"><?php echo YES;?></label>
                    <input type="radio" class="input_radio" id="unzip_no" name="serendipity[unzip_archives]" value="<?php echo NO;?>"<?php echo $checkedN;?>><label for="unzip_no"><?php echo NO;?></label>
                </div>
            </div>
<?php
                    }
?>
            <br />
            <strong><?php echo PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG; ?>:</strong><br />
            <em><?php echo PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG_DESC; ?></em>
            <table id="quickblog_table" style="width: 50%">
                <tr>
                    <td nowrap="nowrap"><?php echo TITLE; ?></td>
                    <td><input class="input_textbox" name="serendipity[quickblog][title]" type="text" style="width: 90%" /></td>
                </tr>

                <tr>
                    <td nowrap="nowrap"><?php echo ENTRY_BODY; ?></td>
                    <td><textarea name="serendipity[quickblog][body]" style="width: 90%; height: 200px"></textarea></td>
                </tr>

                <tr>
                    <td nowrap="nowrap"><?php echo CATEGORY; ?></td>
                    <td><select name="serendipity[quickblog][category]">
                        <option value=""><?php echo NO_CATEGORY; ?></option>
                    <?php
                    if (is_array($cats = serendipity_fetchCategories())) {
                        $cats = serendipity_walkRecursive($cats, 'categoryid', 'parentid', VIEWMODE_THREADED);
                        foreach ($cats as $cat) {
                            echo '<option value="'. $cat['categoryid'] .'">'. str_repeat('&nbsp;', $cat['depth']) . $cat['category_name'] .'</option>' . "\n";
                        }
                    }
                    ?>
                    </select></td>
                </tr>

                <tr>
                    <td nowrap="nowrap"><?php echo IMAGE_SIZE; ?></td>
                    <td><input class="input_textbox" name="serendipity[quickblog][size]" value="<?php echo $serendipity['thumbSize']; ?>" type="text" style="width: 50px" /></td>
                </tr>

                <tr>
                    <td align="center" colspan="2"><br /></td>
                </tr>
            </table>
            <div>
                <em><?php echo PLUGIN_EVENT_IMAGESELECTORPLUS_IMAGE_SIZE_DESC; ?></em>
            </div>
<?php
                } else {
                    if (class_exists('ZipArchive')) {
                        $checkedY = "";
                        $checkedN = "";
                        $this->get_config('unzipping') ? $checkedY = ' checked="checked"' : $checkedN = ' checked="checked"';
?>
            <div class="clearfix radio_field">
                <h4><?php echo PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES;?></h4>
                <?php echo PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_DESC;?>
                <div>
                    <input type="radio" class="input_radio" id="unzip_yes" name="serendipity[unzip_archives]" value="<?php echo YES;?>"<?php echo $checkedY;?>><label for="unzip_yes"><?php echo YES;?></label>
                    <input type="radio" class="input_radio" id="unzip_no" name="serendipity[unzip_archives]" value="<?php echo NO;?>"<?php echo $checkedN;?>><label for="unzip_no"><?php echo NO;?></label>
                </div>
            </div>
<?php
                    }
?>
            <h4><?php echo PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG; ?>:</h4>
            <em><?php echo PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG_DESC; ?></em>
            <div id="quickblog_tablefield" class="clearfix">
                <div class="quickblog_form_field">
                    <label for="quickblog_titel"><?php echo TITLE; ?></label>
                    <input id="quickblog_title" class="input_textbox" name="serendipity[quickblog][title]" type="text">
                </div>

                <div class="quickblog_textarea_field">
                    <label for="nuggets2"><?php echo ENTRY_BODY; ?></label>
                    <textarea id="nuggets2" class="quickblog_nugget" data-tarea="nuggets2" data-tarea-tbar="min" name="serendipity[quickblog][body]" rows="10" cols="80"></textarea>
<?php
                if ($serendipity['wysiwyg'] && (class_exists('serendipity_event_ckeditor') || $serendipity['wysiwyg'] && $serendipity['version'][0] > '1')) {
                    $plugins = serendipity_plugin_api::enum_plugins('*', false, 'serendipity_event_nl2br');
?>
                    <input name="serendipity[properties][disable_markups][]" type="hidden" value="<?php echo $plugins[0]['name']; ?>">
                    <script src="<?php echo $serendipity['serendipityHTTPPath']; ?>htmlarea/ckeditor/ckeditor/ckeditor.js"></script>
                    <script>
                    function Spawnnugget() {
                        CKEDITOR.replace( 'nuggets2',
                        {
                            toolbar : [['Bold','Italic','Underline','Superscript','-','NumberedList','BulletedList','Outdent','Blockquote','-','Format',],['JustifyLeft','JustifyCenter','JustifyRight',],['Link','Unlink','Source']],
                            toolbarGroups: null
                        });
                    }
                    if (window.Spawnnuggets) Spawnnuggets('2');
                    if ($('#nuggets2').attr('data-tarea-tbar') == 'min') {
                        //do something
                    }
                    </script>
<?php
                }
?>
                    </div>

                <div class="quickblog_form_field">
                    <label for="quickblog_select"><?php echo CATEGORY; ?></label>
                    <select id="quickblog_select" name="serendipity[quickblog][category]">
                        <option value=""><?php echo NO_CATEGORY; ?></option>
                    <?php
                    if (is_array($cats = serendipity_fetchCategories())) {
                        $cats = serendipity_walkRecursive($cats, 'categoryid', 'parentid', VIEWMODE_THREADED);
                        foreach ($cats as $cat) {
                            echo '<option value="'. $cat['categoryid'] .'">'. str_repeat('&nbsp;', $cat['depth']) . $cat['category_name'] .'</option>' . "\n";
                        }
                    }
                    ?>
                    </select>
                </div>

                <div class="quickblog_form_field">
                    <label for="quickblog_isize"><?php echo IMAGE_SIZE; ?></label>
                    <input id="quickblog_isize" class="input_textbox" name="serendipity[quickblog][size]" value="<?php echo $serendipity['thumbSize']; ?>" type="text">
                </div>
            </div>
            <em><?php echo PLUGIN_EVENT_IMAGESELECTORPLUS_IMAGE_SIZE_DESC; ?></em>
<?php
                }
                    break;

                case 'backend_image_add':
                    global $new_media;
                    // if file is zip archive and unzipping enabled
                    // unzip file and add all images to database
                    
                    // retrieve file type
                    $target_zip = $eventData;
                    preg_match('@(^.*/)+(.*)\.+(\w*)@',$target_zip,$matches);
                    $target_dir = $matches[1];
                    $basename   = $matches[2];
                    $extension  = $matches[3];
                    $authorid   = (isset($serendipity['POST']['all_authors']) && $serendipity['POST']['all_authors'] == 'true') ? '0' : $serendipity['authorid'];
                    
                    // only if unzipping function exists, we have archive file and unzipping set to yes
                    if ((class_exists('ZipArchive')) && ($extension == 'zip') && ($serendipity['POST']['unzip_archives'] == YES)) {
                        // now unzip
                        $zip = new ZipArchive;
                        $res = $zip->open($target_zip);
                        if ($res === TRUE) {
                            $files_to_unzip   = array();
                            $extracted_images = array();

                            for($i=0; $i < $zip->numFiles; $i++) {
                                $file_to_extract = $zip->getNameIndex($i);
                                if (file_exists($target_dir.$file_to_extract)) {
                                    echo '(' . $file_to_extract . ') ' . ERROR_FILE_EXISTS_ALREADY . '<br />';
                                } else {
                                    $files_to_unzip[] = $file_to_extract;
                                    $extracted_images[] = $target_dir.$file_to_extract;
                                }
                            }

                            $zip->extractTo($target_dir,$files_to_unzip);
                            $zip->close();
                            echo PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_OK;
                        } else {
                            echo PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FAILED;
                        }

                        // now proceed all unzipped images
                        foreach ($extracted_images as $target) {
                            preg_match('@(^.*/)+(.*)\.+(\w*)@',$target,$matches);
                            $real_dir   = $matches[1];
                            $basename   = $matches[2];
                            $extension  = $matches[3];
                            $tfile      = $basename.".".$extension;
                            preg_match('@'.$serendipity['uploadPath'].'(.*/)@',$target,$matches);
                            $image_directory = $matches[1];  

                            // make thumbnails for new images
                            $thumbs = array(array(
                                'thumbSize' => $serendipity['thumbSize'],
                                'thumb'     => $serendipity['thumbSuffix']
                            ));
                            serendipity_plugin_api::hook_event('backend_media_makethumb', $thumbs);

                            foreach($thumbs as $thumb) {
                                // Create thumbnail
                                if ( $created_thumbnail = serendipity_makeThumbnail($tfile, $image_directory, $thumb['thumbSize'], $thumb['thumb']) ) {
                                    echo PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_IMAGE_FROM_ARCHIVE . " - " . THUMB_CREATED_DONE . '<br />';
                                }
                            }

                            // Insert into database
                            $image_id = serendipity_insertImageInDatabase($tfile, $image_directory, $authorid, null, $realname);
                            echo PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_IMAGE_FROM_ARCHIVE." ($tfile) ".PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_ADD_TO_DB."<br />";
                            $new_media[] = array(
                                'image_id'          => $image_id,
                                'target'            => $target,
                                'created_thumbnail' => $created_thumbnail
                            );
                        }
                    }

                case 'backend_image_addHotlink':
                    // Re-Scale thumbnails?
                    $max_scale = array(
                        'width'  => (int)$this->get_config('thumb_max_width'),
                        'height' => (int)$this->get_config('thumb_max_height')
                    );

                    if ($max_scale['width'] > 0 || $max_scale['height'] > 0) {
                        $this->resizeThumb($max_scale, $eventData);
                    }

                    if (empty($serendipity['POST']['quickblog']['title'])) {
                        break;
                    }
                    $file      = basename($eventData);
                    $directory = str_replace($serendipity['serendipityPath'] . $serendipity['uploadPath'], '', dirname($eventData) . '/');
                    $size      = (int)$serendipity['POST']['quickblog']['size'];
                    // check default Serendipity thumbSize, to make this happen like standard image uploads, and to get one "full" image instance only, else create another "resized" image instance, to use as entries thumbnail image
                    if ($serendipity['thumbSize'] != $size) {
                        $oldSuffix = $serendipity['thumbSuffix'];
                        $serendipity['thumbSuffix'] = 'quickblog';
                        serendipity_makeThumbnail($file, $directory, $size);
                        $serendipity['thumbSuffix'] = $oldSuffix;
                    }

                    //New draft post
                    $entry             = array();
                    $entry['isdraft']  = 'false';
                    $entry['title']    = $serendipity['POST']['quickblog']['title'];
                    $entry['body']     = '<!--quickblog:' . $eventData .  '-->' . $serendipity['POST']['quickblog']['body'];
                    $entry['authorid'] = $serendipity['authorid'];
                    $entry['exflag']   = false;
                    $entry['categories'][0] = $serendipity['POST']['quickblog']['category'];
                    $entry['allow_comments']    = 'true';
                    $entry['moderate_comments'] = 'false';
                    $serendipity['POST']['properties']['fake'] = 'fake';
                    $id = serendipity_updertEntry($entry);

                    break;

                case 'frontend_display':

                    // auto resizing images based on width and/or height attributes in img tag
                    if (serendipity_db_bool($this->get_config('autoresize'))) {
                        if (!empty($eventData['body'])) {
                            $eventData['body'] = $this->substituteImages($eventData['body']);
                        }

                        if (!empty($eventData['extended'])) {
                            $eventData['extended'] = $this->substituteImages($eventData['extended']);
                        }
                    }

                    if (empty($eventData['body'])) {
                        return;
                    }

                    // displaying quickbox posts
                    if (is_object($serendipity['smarty']) && preg_match('@<!--quickblog:(.+)-->@imsU', $eventData['body'], $filematch)) {
                        $eventData['body'] = $this->parse_quickblog_post($filematch[1], $eventData['body']);
                    }

                    // displaying galleries introduced by markup
                    foreach ($this->markup_elements as $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], true)) && isset($eventData[$temp['element']]) &&
                            !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                            !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];
                            $eventData[$element] = $this->media_insert($eventData[$element], $eventData);
                        }
                    }

                    return true;

                    break;

                case 'backend_entry_presave':
                    if (is_numeric($eventData['id'])) {
                        $eventData['body']     = str_replace('{{s9yisp_entryid}}', $eventData['id'], $eventData['body']);
                        $eventData['extended'] = str_replace('{{s9yisp_entryid}}', $eventData['id'], $eventData['extended']);
                        $this->gotMilk = true;
                    } else {
                        $this->cache['body']     = $eventData['body'];
                        $this->cache['extended'] = $eventData['extended'];
                    }
                    break;

                case 'backend_publish':
                case 'backend_save':
                    if ($this->gotMilk === false) {
                        $old = md5($this->cache['body']) . md5($this->cache['extended']);
                        $this->cache['body']     = str_replace('{{s9yisp_entryid}}', $eventData['id'], $this->cache['body']);
                        $this->cache['extended'] = str_replace('{{s9yisp_entryid}}', $eventData['id'], $this->cache['extended']);
                        $new = md5($this->cache['body']) . md5($this->cache['extended']);

                        if ($old != $new) {
                            serendipity_db_query("UPDATE {$serendipity['dbPrefix']}entries
                                                     SET body     = '" . serendipity_db_escape_string($this->cache['body']) . "',
                                                         extended = '" . serendipity_db_escape_string($this->cache['extended']) . "'
                                                   WHERE       id = " . (int)$eventData['id']);
                        }
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
                    break;

                case 'entries_header':
                    if (!$this->selected()) {
                        return true;
                    }

                    if (!headers_sent()) {
                        header('HTTP/1.0 200');
                        header('Status: 200 OK');
                    }
                    $entry = serendipity_fetchEntry('id', $serendipity['GET']['id']);
                    $imageid = $serendipity['GET']['image'];
                    $imgsrc = '';
                    if (preg_match('@<a title="([^"]+)" id="s9yisp' . $imageid . '"></a>@imsU', $entry['body'], $imgmatch)) {
                        $imgsrc = $imgmatch[1];
                    } elseif (preg_match('@<a title="([^"]+)" id="s9yisp' . $imageid . '"></a>@imsU', $entry['extended'], $imgmatch)) {
                        $imgsrc = $imgmatch[1];
                    } else {
                        return;
                    }

                    $link = '<a href="' . serendipity_archiveURL($serendipity['GET']['id'], $entry['title'], 'baseURL', true, array('timestamp' => $entry['timestamp'])) . '#s9yisp' . $imageid . '">';

                    echo '<div class="serendipity_Entry_Date">
                             <h3 class="serendipity_date">' . serendipity_formatTime(DATE_FORMAT_ENTRY, $entry['timestamp']) . '</h3>';

                    echo '<h4 class="serendipity_title"><a href="#">' . htmlspecialchars($entry['title']) . '</a></h4>';

                    echo '<div class="serendipity_entry"><div class="serendipity_entry_body">';
                    echo '<div class="serendipity_center">' . $link . '<!-- s9ymdb:' . $entry['id'] . ' --><img src="' . $imgsrc . '" /></a></div>';
                    echo '<br />';
                    echo $link . '&lt;&lt; ' . BACK . '</a>';

                    echo '</div></div></div>';

                    return true;
                    break;

                case 'frontend_image_add_unknown':
                case 'frontend_image_add_filenameonly':
                case 'frontend_image_selector_submit':
                case 'frontend_image_selector_more':
                case 'frontend_image_selector_imagecomment':
                case 'frontend_image_selector_imagealign':
                case 'frontend_image_selector_imagesize':
                case 'frontend_image_selector_hiddenfields':
                    return true;
                    break;

                case 'frontend_image_selector_imagelink':
                    $this->display_target_selectbox();
                    return true;
                    break;

                case 'css_backend':
                    if ($serendipity['version'][0] > '1') {
?>
#quickblog_tablefield {
   display: table-cell;
}
#uploadform .quickblog_nugget {
    margin-left: 0;
    padding: 0;
}
#uploadform .quickblog_form_field {
    margin: .375em 0;
}
#uploadform .radio_field label {
    padding-left: .5em;
}
<?php
                    }
                    break;

                case 'frontend_image_selector':
                    $eventData['finishJSFunction'] = 'serendipity_imageSelectorPlus_done(\'' . $serendipity['GET']['textarea'] . '\')';
                    $this->display_script();
                return true;
                break;

              default:
                return false;
            }

        } else {
            return false;
        }
    }

    /*
     *  function parse_quickblog_post makes a quickblog post from the picture
     *  given by $path @string
     */
    function parse_quickblog_post($path, &$body) {
        global $serendipity;
        $file = basename($path);
        $dir  = dirname($path) . '/';

        $t       = serendipity_parseFileName($file);
        $f       = $t[0];
        $suf     = $t[1];

        $infile  = $dir . $file;
        $outfile = $dir . $f . '.quickblog.' . $suf;
        // check for existing image.quickblog thumb (see change in backend_image_addHotlink) else change to default thumbnail name
        if (!file_exists($outfile)) $outfile = $dir . $f . '.serendipityThumb.' . $suf;

        if (function_exists('exif_read_data') && file_exists($infile) && !serendipity_db_bool($this->get_config('force_jhead'))) {
            $exif      = @exif_read_data($infile);
            $exif_mode = 'internal';
        } elseif (file_exists($infile)) {
            $exif_mode = 'jhead';
            $exif_raw  = explode("\n", @`jhead $infile`);
            $exif      = array();

            foreach((array)$exif_raw AS $line) {
                preg_match('@^(.+):(.+)$@U', $line, $data);
                $key = preg_replace('@[^a-z0-9]@i', '_', trim($data[1]));
                if (empty($key)) {
                    continue;
                }
                $exif[$key] .= trim($data[2]) . "\n";
            }

            if (count($exif) < 1) {
                $exif = false;
            }
        } else {
            $exif = false;
            $exif_mode = 'none';
        }

        $http_infile  = $this->httpize($infile);
        $http_outfile = $this->httpize($outfile);

        $quickblog = array(
            'image'     => $http_outfile,
            'fullimage' => $http_infile,
            'body'      => preg_replace('@(<!--quickblog:.+-->)@imsU', '', $body),
            'exif'      => &$exif,
            'exif_mode' => $exif_mode
        );

        $tfile = serendipity_getTemplateFile('quickblog.tpl', 'serendipityPath');
        if (!$tfile || $tfile == 'quickblog.tpl') {
            $tfile = dirname(__FILE__) . '/quickblog.tpl';
        }

        $serendipity['smarty']->assign('quickblog', $quickblog);
        $content = $this->parseTemplate($tfile);

        return $content;
    }


    /*
     *  display_target_selectbox()
     *  displays select box for choosing target of image in the image selector
     *  depreceated, in new version >0.9 already in admin_image_selector.php     
     */          
    function display_target_selectbox() {
?>
<label for="select_image_target"><?php echo PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET; ?></label>
    <select name="serendipity[target]" id="select_image_target">
        <option value="none" <?php echo ifRemember('target', 'none', false, 'selected'); ?>><?php echo NONE; ?></option>
        <option value="js" <?php echo ifRemember('target', 'js', false, 'selected'); ?>><?php echo PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_JS; ?></option>
        <option value="plugin" <?php echo ifRemember('target', 'plugin', false, 'selected'); ?>><?php echo PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_ENTRY; ?></option>
        <option value="_blank" <?php echo ifRemember('target', '_blank', false, 'selected'); ?>><?php echo PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_BLANK; ?></option>
    </select>
<br />
<?php

    }

    /*
     *  display_sript()
     *  displays script necessary for inserting target for images chosen by
     *  image selector
     *  depreceated, in new version >0.9 already in admin_image_selector.php
     */          
    function display_script() {
?>
<script type="text/javascript">
function serendipity_imageSelectorPlus_done(textarea)
{
    var insert = '';
    var img = '';
    var src = '';
    var f = document.forms['serendipity[selForm]'].elements;

    if (f['serendipity[linkThumbnail]'][0].checked == true) {
        img       = f['thumbName'].value;
        imgWidth  = f['imgThumbWidth'].value;
        imgHeight = f['imgThumbHeight'].value;
    } else {
        img       = f['imgName'].value;
        imgWidth  = f['imgWidth'].value;
        imgHeight = f['imgHeight'].value;
    }

    if (f['serendipity[filename_only]'] && f['serendipity[filename_only]'].value == 'true') {
        self.opener.serendipity_imageSelector_addToElement(img, f['serendipity[htmltarget]'].value);
        self.close();
        return true;
    }

    if (document.getElementById('serendipity_imagecomment').value != '') {
        styled = false;
    } else {
        styled = true;
    }

    floating = 'center';
    if (f['serendipity[align]'][0].checked == true) {
        img = "<img width='" + imgWidth + "' height='" + imgHeight + "' " + (styled ? 'style="border: 0px; padding-left: 5px; padding-right: 5px;"' : '') + ' src="' + img + "\" alt=\"\" />";
    } else if (f['serendipity[align]'][1].checked == true) {
        img = "<img width='" + imgWidth + "' height='" + imgHeight + "' " + (styled ? 'style="float: left; border: 0px; padding-left: 5px; padding-right: 5px;"' : '') + ' src="' + img + "\" alt=\"\" />";
        floating = 'left';
    } else if (f['serendipity[align]'][2].checked == true) {
        img = "<img width='" + imgWidth + "' height='" + imgHeight + "' " + (styled ? 'style="float: right; border: 0px; padding-left: 5px; padding-right: 5px;"' : '') + ' src="' + img + "\" alt=\"\" />";
        floating = 'right';
    }

    if (f['serendipity[isLink]'][1].checked == true) {
        targetval = f['serendipity[target]'].options[f['serendipity[target]'].selectedIndex].value;
        prepend   = '';
        ilink     = f['serendipity[url]'].value;
        if (!targetval || targetval == 'none') {
            itarget = '';
        } else if (targetval == 'js') {
            itarget = ' onclick="F1 = window.open(\'' + f['serendipity[url]'].value + '\',\'Zoom\',\''
                    + 'height=' + (parseInt(f['imgHeight'].value) + 15) + ','
                    + 'width='  + (parseInt(f['imgWidth'].value)  + 15) + ','
                    + 'top='    + (screen.height - f['imgHeight'].value) /2 + ','
                    + 'left='   + (screen.width  - f['imgWidth'].value)  /2 + ','
                    + 'toolbar=no,menubar=no,location=no,resize=1,resizable=1,scrollbars=yes\'); return false;"';
        } else if (targetval == '_blank') {
            itarget = ' target="_blank"';
        } else if (targetval == 'plugin') {
            itarget = ' id="s9yisphref<?php echo $serendipity['GET']['image']; ?>"';
            prepend = '<a title="' + ilink + '" id="s9yisp<?php echo $serendipity['GET']['image']; ?>"></a>';
            ilink   = '<?php echo $serendipity['baseURL'] . $serendipity['indexFile'] . '?serendipity[subpage]=s9yisp&amp;serendipity[id]={{s9yisp_entryid}}&amp;serendipity[image]=' . $serendipity['GET']['image']; ?>';
        }

        insert = prepend + "<a class='serendipity_image_link' href='" + ilink + "'" + itarget + ">" + img + "</a>";
    } else {
        insert = img;
    }

    if (document.getElementById('serendipity_imagecomment').value != '') {
        comment = f['serendipity[imagecomment]'].value;
        block = '<div class="serendipity_imageComment_' + floating + '" style="width: ' + imgWidth + 'px">'
              +     '<div class="serendipity_imageComment_img">' + insert + '</div>'
              +     '<div class="serendipity_imageComment_txt">' + comment + '</div>'
              + '</div>';
    } else {
        block = insert;
    }

    if (self.opener.editorref) {
        self.opener.editorref.surroundHTML(block, '');
    } else {
        self.opener.serendipity_imageSelector_addToBody(block, textarea);
    }

    self.close();
}
</script>
<?php

    }


    /*
     * media_insert
     * this function replaces xml-like structure in the $text @string
     *  by images from media gallery
     */
    function media_insert($text, &$eventData) {
        global $serendipity;
        // find in text parts which are mediainsert

        $entry_parts = preg_split('@(<mediainsert>[\S\s]*?</mediainsert>)@', $text, -1, PREG_SPLIT_DELIM_CAPTURE);

        // parse mediainserts 
        // (if xml parser is present at php installation
        //         - SimpleXMLElement in PHP > 5.0, users of older version could have troubles )
        // text is splitted into parts
        if (class_exists('SimpleXMLElement')) {
            for ($i=0, $pcount = count($entry_parts); $i < $pcount; $i++) {
                if (!(strpos($entry_parts[$i],"<mediainsert>") === false)) {
                    // There was a problem with wysiwyg-ckeditor: which removes linebreaks and sometimes inserts ending tags
                    // To not error, we remove at least the ending tags and possibly single-tags missing trailing slashes
                    $epart   = str_replace(array('</media>','</gallery>','">'), array('','','" />'), $entry_parts[$i]);
                    $xml     = new SimpleXMLElement($epart);
                    $gallery = $xml->gallery['name'];

                    $medias        = array();
                    $whole_gallery = false;
                    foreach ($xml->media as $medium) {
                        switch((string) $medium['type']) { // Get attributes as element indices
                        case 'single':
                            $medias[] = serendipity_db_escape_string($medium['name']);
                            break;

                        case 'range':
                            for ($j=intval($medium['start']);$j<=intval($medium['stop']);$j++) {
                                $medias[] = serendipity_db_escape_string($medium['prefix']) . $j;
                            }
                            break;

                        case 'gallery':
                            $whole_gallery = true;
                            break;

                        default:
                            break;
                        }
                    }

                    // here we have desired gallery and desired pictures
                    // now read available ones from database

                    if ($whole_gallery) {
                        $q = "SELECT id,name,extension,thumbnail_name,realname,path,value as comment1,dimensions_width as width, dimensions_height as height
                              FROM {$serendipity['dbPrefix']}images as i 
                              LEFT JOIN {$serendipity['dbPrefix']}mediaproperties as p ON (p.mediaid = i.id AND p.property='COMMENT1') 
                              WHERE i.path = '" . serendipity_db_escape_string($gallery) . "' ";                        
                    } else {
                        $images_suggestions = "'".implode("','",$medias)."'";
                        $q = "SELECT id,name,extension,thumbnail_name,realname,path,value as comment1,dimensions_width as width, dimensions_height as height
                              FROM {$serendipity['dbPrefix']}images as i 
                              LEFT JOIN {$serendipity['dbPrefix']}mediaproperties as p ON (p.mediaid = i.id AND p.property='COMMENT1') 
                              WHERE i.path = '" . serendipity_db_escape_string($gallery) . "' AND i.name IN ($images_suggestions)";
                    }

                    $t = serendipity_db_query($q, false, 'assoc');

                    // here we have to order the results from database to respect
                    // the order of pictures in xml entry
                    // and at the same time we calculate thumbs size

                    $thumb_size = $serendipity['thumbSize'];
                    $order      = array();
                    if (is_array($t)) {
                        for ($j=0, $tcount = count($t) ; $j < $tcount ; $j++) {
                            $h = intval($t[$j]["height"]);
                            $w = intval($t[$j]["width"]);
                            $h = $h==0 ? 1 : $h; // avoid 'Division by zero' errors for height
                            $w = $w==0 ? 1 : $w; // dito for width
                            if ($w > $h) {
                                $t[$j]["thumbheight"] = round($thumb_size*$h/$w);
                                $t[$j]["thumbwidth"]  = round($thumb_size);
                            } else {
                                $t[$j]["thumbheight"] = round($thumb_size);
                                $t[$j]["thumbwidth"]  = round($thumb_size*$w/$h);
                            }

                            if (strlen($t[$j]["comment1"]) == 0) {
                                #$t[$j][6] = $t[$j]["name"];// add missing new num key if not using assoc select
                                $t[$j]["comment1"] = $t[$j]["name"];
                            }

                            $order[$j] = array_search($t[$j]["name"], $medias);
                            if (strlen($t[$j]["thumbnail_name"]) == 0) {
                                array_splice($t,$j,1);
                                $j--;
                                $tcount--;
                            }
                        }

                        array_multisort($order, SORT_ASC, SORT_NUMERIC, $t);

                        // now make an output using template

                        $tfile = serendipity_getTemplateFile('plugin_mediainsert.tpl', 'serendipityPath');
                        if (!$tfile || $tfile == 'plugin_mediainsert.tpl') {
                            $tfile = dirname(__FILE__) . '/plugin_mediainsert.tpl';
                        }

                        $serendipity['smarty']->assign('plugin_mediainsert_media', $t);
                        $serendipity['smarty']->assign('plugin_mediainsert_entry', $eventData);
                        $content = $this->parseTemplate($tfile);

                    } else {
                        // if there are no available images, do no output
                        $content= "";
                    }

                    // fetch the output
                    $entry_parts[$i] = $content;
                }
            }
        }

        return implode("", $entry_parts);
    }


    //////////////////////////////////////////////////////////////
    /// The following methods are used for the auto image resizing

    /**
     * Substitute img src attributes in $html with auto resize urls
     *
     * @author Adam Charnock (http://omniwiki.co.uk)
     * @param string $html
     * @return string The HTML with the transformed images
     */
    function substituteImages($html) {
        $imgTags = $this->getImageTags($html);
        //We need to make sure we substitute the last images first otherwise 
        //our char offsets will get messed up
        $imgTags = array_reverse($imgTags);

        foreach ($imgTags as $attrs) {
            $newTag = '<img';
            $attrPairs = array();
            foreach ($attrs as $k => $v) {
                if (strpos($k, '_') !== 0) {
                    if ($k == 'src') {
                        $v = $this->getTransformImg($attrs);
                    }
                    $quote = (strpos($v, '"') !== false) ? "'" : '"';
                    $attrPairs[] = "$k=$quote$v$quote";
                }
            }
            $newTag .= ' ' . implode(' ', $attrPairs) . ' />';

            //Now we need to splice the new tag into the HTML
            $firstHalf = substr($html, 0, $attrs['_offset']);
            $secondHalf = substr($html, $attrs['_offset'] + $attrs['_length']);

            $html = $firstHalf . $newTag . $secondHalf;
        }

        return $html;
    }

    /**
     * Gets an image ID based on the URL
     * 
     * The URL can be in the form:
     * 
     *     <maybe-something-here>/uploads/fireworks.jpg
     *   or
     *     <maybe-something-here>/templates_c/mediacache/cache_img1_300_300
     * 
     * The first example will cause the database to be queried. In the second 
     * example the image ID will be extracted directly from the URL
     * 
     * @param string The image URL
     * @return mixed An image ID if the URL could be matched, or false if the URL could not be matched
     */
    function getImageIdByUrl($url){
        global $serendipity;

        if (preg_match('#.*templates_c/mediacache/cache_img(\d+)_(\d*)_(\d*)#i', $url, $m)) {
            $imageId = $m[1];
        } else if (preg_match('#.*uploads(.*/)([^/]+)\.([a-z0-9]+)#i', $url, $m)) {
            $name = serendipity_db_escape_string($m[2]);
            $extension = serendipity_db_escape_string($m[3]);
            $path = serendipity_db_escape_string(ltrim($m[1], '/'));
            $sql = "SELECT id FROM {$serendipity['dbPrefix']}images WHERE name = '%s' AND extension = '%s' AND path = '%s'";
            $sql = sprintf($sql, $name, $extension, $path);
            $row = serendipity_db_query($sql, true);
            $imageId = $row['id'];
        } else {
            //We got an unrecognised url so return false
            $imageId = false;
        }

        return $imageId;
    }

    /**
     * Get the transformed src for an img tag
     *
     * @author Adam Charnock (http://omniwiki.co.uk)
     * @param array $attrs An associative array of the image's attributes. Must conatain src, and either width or height
     * @return unknown
     */
    function getTransformImg($attrs) {
        global $serendipity;

        /*
        Image URLs can be expected to look like either:
        <maybe-something-here>/uploads/fireworks.jpg
        or
        <maybe-something-here>/templates_c/mediacache/cache_img1_300_300
        */
        if (!isset($attrs['src']) || !$attrs['src']) {
            trigger_error('The $attrs parameter must contain a "src" key', E_USER_ERROR);
        }

        if ((!isset($attrs['height']) || !$attrs['height']) && (!isset($attrs['width']) || !$attrs['width'])) {
            //Without any height or width values we cannot do anything
            return $attrs['src'];
        }

        $url = $attrs['src'];
        $imageId = $this->getImageIdByUrl($url);
        if (!$imageId) {
            //We got an unrecognised url so don't do anything to it, just send it right back
            return $url;
        }

        //Create the new, transformed URL
        $newUrl = rtrim($serendipity['baseURL'], '/') . '/serendipity_admin_image_selector.php?serendipity[image]=%d&serendipity[disposition]=inline&serendipity[step]=showItem';
        if (isset($attrs['height']) && $attrs['height']) {
            $newUrl .= '&serendipity[resizeHeight]=' . (int)($attrs['height']);
        }
        if (isset($attrs['width']) && $attrs['width']) {
            $newUrl .= '&serendipity[resizeWidth]=' . (int)($attrs['width']);
        }

        $newUrl = sprintf($newUrl, $imageId);
        return $newUrl;

    }

    /**
     * Parses image tags out of a chunk of HTML
     * 
     * @author Adam Charnock (http://omniwiki.co.uk)
     * @param string $html
     * @return array An array of image tags. Each tag is an associative array of its attributes, plus _offset and _length
     */
    function getImageTags($html) {
        //Thanks to the following blog post for the inspiration for this regex:
        //http://kev.coolcavemen.com/2007/03/ultimate-regular-expression-for-html-tag-parsing-with-php/
        preg_match_all("/<\/?(\w+)((\s+\w+(\s*=\s*(?:\".*?\"|'.*?'|[^'\">\s]+))?)+\s*|\s*)\/?>/i", $html, $m, PREG_OFFSET_CAPTURE);
        $tags = array('types' => $m[1], 'attrs' => $m[2], 'wholetags' => $m[0]);

        //At this stage $tags['attrs'] is just an unparsed string

        $imgTags = array();
        for ($i=0; $i<count($tags['attrs']); $i++) {
            if ($tags['types'][$i][0] == 'img') {
                $parsedAttrs = $this->parseAttrs($tags['attrs'][$i][0]);
                if (isset($parsedAttrs['src'])) {
                    $parsedAttrs['_offset'] = $tags['wholetags'][$i][1];
                    $parsedAttrs['_length'] = strlen($tags['wholetags'][$i][0]);
                    $imgTags[] = $parsedAttrs;
                }
            }
        }

        return $imgTags;
    }

    /**
     * Parse the attribute portion of an HTML/XHTML/XML tag
     * 
     * The $atts param should (or rather, can) look something like:
     *     width="400" height="300" border=0 alt="This is an example!"
     * 
     * Which will produce an array as follows:
     * 
     * <pre>
     * array(4) {
     *   ["width"]=>
     *   string(3) "400"
     *   ["height"]=>
     *   string(5) "300"
     *   ["border"]=>
     *   string(1) "0"
     *   ["alt"]=>
     *   string(19) "This is an example!"
     * }
     * </pre>
     * 
     * @author Adam Charnock (http://omniwiki.co.uk)
     * @internal It may be possible to do this with a regex
     * @param string $attrs The tag string
     * @return array An associative array of attributes
     */
    function parseAttrs($attrs) {
        $parsedAttrs = array();
        $currentAttrName = '';
        $currentAttrValue = '';

        //We append an extra space to ensure the last attr gets processd
        $chars = str_split($attrs . ' ', 1);

        $state = 'read-name';
        $quote = '';
        foreach ($chars as $c) {
            switch ($state){
                case 'read-name':
                    if ($c == ' ' && !$currentAttrName){
                        break;
                    }
                    if ($c == '=' || $c == ' ') {
                        $state = 'read-value-start';
                    } else {
                        $currentAttrName .= $c;
                    }
                    break;
                case 'read-value-start':
                    if ($c == '"' || $c == "'") {
                        $quote = $c;
                    } else {
                        $quote = '';
                        $currentAttrValue .= $c;
                    }
                    $state = 'read-value';
                    break;
                case 'read-value':
                    if (in_array($c, array(' ', '/', '>')) && !$quote) {
                        $state = 'read-value-finished';
                    } else if($c == $quote) {
                        $state = 'read-value-finished';
                    } else {
                        $currentAttrValue .= $c;
                    }
                    break;
                case 'read-value-finished':
                    $parsedAttrs[$currentAttrName] = $currentAttrValue;
                    $currentAttrName = ($c == ' ') ? '' : $c;
                    $currentAttrValue = '';
                    $state = 'read-name';
                    break;
            }
        }

        return $parsedAttrs;
    }

}


/* vim: set sts=4 ts=4 expandtab : */
