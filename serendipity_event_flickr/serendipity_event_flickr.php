<?php # 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_flickr extends serendipity_event
{
    // called just after installation, to display post install notes
    function example() {
        return PLUGIN_EVENT_FLICKR_INSTALL;
    }

    // should describe the plugin: author, version, requirements, ...
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_FLICKR_NAME);
        $propbag->add('description',   PLUGIN_EVENT_FLICKR_DESC);
        $propbag->add('groups',        array('IMAGES'));
        $propbag->add('stackable',     false);
        $propbag->add('license',       'GPL');
        $propbag->add('author',        'Jay Bertrand');
        $propbag->add('version',       '0.6');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',    array(
            'backend_sidebar_entries_images' => true,
            'backend_sidebar_entries_event_display_flickr' => true
        ));

        // variables for this plugin ...
        $propbag->add('configuration', array('api_key'));
        return true;
    }

    // called by the framework to configure variables
    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'api_key':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_FLICKR_APIKEY);
                $propbag->add('description', PLUGIN_EVENT_FLICKR_APIKEY_DESC);
                $propbag->add('validate', '/^[0-9a-fA-F]{32}$/');
                $propbag->add('validate_error', PLUGIN_EVENT_FLICKR_APIKEY_INVALID);
                $propbag->add('default', '');
                break;

            default:
                return false;
                break;
        }
        return true;
    }

    // used to "show" the plugin
    function generate_content(&$title) {
        $title = $this->title;
    }

    // do the hook job
    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {

                // called when admin sidebar is being "built"
                case 'backend_sidebar_entries_images':
                    ?><li class="serendipitySideBarMenuLink serendipitySideBarMenuMediaLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=flickr">
                        <?php echo PLUGIN_EVENT_FLICKR_NAME; ?></a></li><?php
                    break;

                // called when admin sidebar is been "drawn"
                case 'backend_sidebar_entries_event_display_flickr':

                    // he, is user allowed to import images ?!?
                    if (!serendipity_checkPermission('adminImagesAdd')) {
                        // TODO: add a message to the user ?!?
                        break;
                    }

                    // if method is POST, we must have a valid form token !
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !serendipity_checkFormToken()) {
                        // TODO: add a message to the user ?!?
                        break;
                    }
                ?>
                <?php echo PLUGIN_EVENT_FLICKR_IMPORT_BLAHBLAH; ?>
                <script type="text/javascript">
                function flickr_showPage(p) {
                    var f = document.getElementById('flickr_uploadform');
                    f.elements['serendipity[flickr_page]'].value = p;
                    f.submit();
                }
                function flickr_doImport(url) {
                    var f = document.getElementById('flickr_uploadform');
                    f.elements['serendipity[adminModule]'].value = 'images';
                    f.elements['serendipity[adminAction]'].value = 'add';
                    f.elements['serendipity[imageurl]'].value = url;
                    f.submit();
                }
                function flickr_toggleExtended() {
                    var d = document.getElementById('flickr_extendedCriteria');
                    d.style.display = (d.style.display != '') ? '' : 'none';
                }
                </script>
                <h3><? echo PLUGIN_EVENT_FLICKR_IMPORT; ?></h3>
                <form action="?" method="POST" id="flickr_uploadform" enctype="multipart/form-data" onsubmit="">
                    <?php echo serendipity_setFormToken(); ?>
                    <?php // these two fields will only be used when an image has been chosen for dl ?>
                    <input type="hidden" name="serendipity[imageurl]" value="" />
                    <input type="hidden" name="serendipity[imageimporttype]" value="image" />

                    <input type="hidden" name="serendipity[action]"      value="admin" />
                    <input type="hidden" name="serendipity[adminModule]" value="event_display" />
                    <input type="hidden" name="serendipity[adminAction]" value="flickr" />

                    <input type="hidden" name="serendipity[flickr_page]" value="1" />
                    Flickr username: <input class="input_textbox" name="serendipity[flickr_username]" value="<?php echo  (function_exists('serendipity_specialchars') ? serendipity_specialchars($serendipity['POST']['flickr_username']) : htmlspecialchars($serendipity['POST']['flickr_username'], ENT_COMPAT, LANG_CHARSET)) ?>" />
                    <input type="submit" value="<?php echo GO; ?>" class="serendipityPrettyButton input_button" /><br /><br />
                    <a style="border: 0pt none ; text-decoration: none;" href="#" onclick="flickr_toggleExtended(); return false"
                         title="<?php echo  TOGGLE_OPTION ?>">
                    <img border="0" src="<?php echo serendipity_getTemplateFile('img/plus.png') ?>" /> <?php echo  TOGGLE_ALL ?></a>
                    <div id="flickr_extendedCriteria" <?php echo  (strlen($serendipity['POST']['flickr_username']) ? '':'style="display:none;"') ?>>
                        <p><?php echo  PLUGIN_EVENT_FLICKR_TAGS ?> <input class="input_textbox" name="serendipity[flickr_tags]" value="<?php echo  (function_exists('serendipity_specialchars') ? serendipity_specialchars($serendipity['POST']['flickr_tags']) : htmlspecialchars($serendipity['POST']['flickr_tags'], ENT_COMPAT, LANG_CHARSET)) ?>" />
                        <?php echo  PLUGIN_EVENT_FLICKR_KEYWORDS ?> <input class="input_textbox" name="serendipity[flickr_keywords]" value="<?php echo  (function_exists('serendipity_specialchars') ? serendipity_specialchars($serendipity['POST']['flickr_keywords']) : htmlspecialchars($serendipity['POST']['flickr_keywords'], ENT_COMPAT, LANG_CHARSET)) ?>" size="30" /></p>
                        <?php echo  SORT_BY ?> <select id="flickr_sort" name="serendipity[flickr_sort]">
                        <option value=""></option>
                        <?
                            // See API for details (http://www.flickr.com/services/api/flickr.photos.search.html)
                            $flickr_goodSortOrders = array(
                                'date-posted-asc'=>'By date of post, ascending',
                                'date-posted-desc'=>'By date of post, descending',
                                'date-taken-asc'=>'By date of take, ascending',
                                'date-taken-desc'=>'By date of take, descending',
                                'interestingness-asc'=>'By interestingness, ascending',
                                'interestingness-desc'=>'By interestingness, ascending',
                                'relevance'=>'By revelance'
                            );

                            // compute sort order
                            $sortOrder = (isset($serendipity['POST']['flickr_keywords']) &&
                                array_key_exists($serendipity['POST']['flickr_keywords'], $flickr_goodSortOrders) ?
                                (function_exists('serendipity_specialchars') ? serendipity_specialchars($serendipity['POST']['flickr_keywords']) : htmlspecialchars($serendipity['POST']['flickr_keywords'], ENT_COMPAT, LANG_CHARSET)) : '');

                            // display possible options for sort order
                            foreach($flickr_goodSortOrders as $value => $description) {
                                echo '<option value="'.$value.'"';
                                if($sortOrder == $value) echo(' selected="true"');
                                echo '>'.$description.'</option>';
                            }
                        ?>
                        </select>
                    </div>
                </form>
                <?php
                    // in the second step, we show latest photos (thumbs) for given username
                    if ($serendipity['POST']['adminAction'] == 'flickr') {

                        // make use of phpFlikr lib (http://www.phpflickr.com/)
                        require_once(dirname(__FILE__).'/phpFlickr/phpFlickr.php');

                        $f = new phpFlickr($this->get_config('api_key'));

                        $i = 0;
                        if (!empty($serendipity['POST']['flickr_username'])) {
                            // Find the NSID of the username inputted via the form
                            $nsid = $f->people_findByUsername($serendipity['POST']['flickr_username']);

                            // Get the friendly URL of the user's photos
                            $photos_url = $f->urls_getUserPhotos($nsid);
                            echo '<h4 style="margin-bottom: 0; padding-bottom: 0;">Photos of <em>';
                            echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($serendipity['POST']['flickr_username']) : htmlspecialchars($serendipity['POST']['flickr_username'], ENT_COMPAT, LANG_CHARSET)).'</em> at ';
                            echo '<a href="'.$photos_url.'" target="_blank">'.$photos_url.'</a></h4>';

                            // default page is number one
                            if (empty($serendipity['POST']['flickr_page']) || !is_numeric($serendipity['POST']['flickr_page'])) {
                                $serendipity['POST']['flickr_page'] = 1;
                            }
                            // make sure page is a number between 1 and 500 (range allowed by flickr API)
                            $serendipity['POST']['flickr_page'] = min(500,max(1,(int)$serendipity['POST']['flickr_page']));
                            echo '<h5 style="margin-top: 0; padding-top: 0;">Displaying page '.(function_exists('serendipity_specialchars') ? serendipity_specialchars($serendipity['POST']['flickr_page']) : htmlspecialchars($serendipity['POST']['flickr_page'], ENT_COMPAT, LANG_CHARSET)).'</h5>';

                            // Search is made depending on selected criterias
                            $searchCriteria = array();

                            // make sure sort order is non empty AND valid
                            if(isset($serendipity['POST']['flickr_sort']) && strlen(trim($serendipity['POST']['flickr_sort'])) &&
                                array_key_exists($serendipity['POST']['flickr_keywords'], $flickr_goodSortOrders))
                                $searchCriteria['sort'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($serendipity['POST']['flickr_sort']) : htmlspecialchars($serendipity['POST']['flickr_sort'], ENT_COMPAT, LANG_CHARSET));

                            // TODO: clean up tags of unwanted characters (keep only [a-zA-Z0-9_-])
                            if(isset($serendipity['POST']['flickr_tags']) && strlen(trim($serendipity['POST']['flickr_tags'])))
                                $searchCriteria['tags'] = implode(',',explode(' ', (function_exists('serendipity_specialchars') ? serendipity_specialchars($serendipity['POST']['flickr_tags']) : htmlspecialchars($serendipity['POST']['flickr_tags'], ENT_COMPAT, LANG_CHARSET))));

                            // TODO: cleanup keywords
                            if(isset($serendipity['POST']['flickr_keywords']) && strlen(trim($serendipity['POST']['flickr_keywords'])))
                                $searchCriteria['text'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($serendipity['POST']['flickr_keywords']) : htmlspecialchars($serendipity['POST']['flickr_keywords'], ENT_COMPAT, LANG_CHARSET));

                            if(count($searchCriteria)) {
                                // It seems the user wants an advanced search
                                $searchCriteria['user_id'] = $nsid;
                                $photos = $f->photos_search($searchCriteria);
                            } else {
                                // No extra criteria, get the user's next 12 public photos (+1 to show > next or not !)
                                $photos = $f->people_getPublicPhotos($nsid, NULL, 13, $serendipity['POST']['flickr_page']);
                                // Get user's tags (if any)
                                /*$tags = $f->tags_getListUser($nsid);
                                if(is_array($tags['tags']['tag'])) {
                                    echo implode(',', $tags['tags']['tag']);
                                    echo "<br />\n";
                                }*/
                            }

                            // Loop through the photos and output the html
                            foreach ($photos['photo'] as $photo) {
                                echo '<a title="Add to library" href="javascript:flickr_doImport(\''.$f->buildPhotoURL($photo, 'Original').'\');" ';
                                echo 'onclick="return confirm(\'Import this photo into the media library ?\');">';
                                echo '<img border="0" alt="'.$photo['title'].'" src=' . $f->buildPhotoURL($photo, 'Square') . ' />';
                                echo '</a>';

                                // break before the 13th photo (if any)
                                if(++$i == 12) break;

                                // If it reaches the sixth photo, insert a line break
                                if ($i % 6 == 0) {
                                    echo "<br />\n";
                                }
                            } // end foreach
                            echo "<br />\n";

                            // navigate through pages of photos
                            if ($serendipity['POST']['flickr_page'] > 1) {
                                echo '<a href="javascript:flickr_showPage('.(int)($serendipity['POST']['flickr_page']-1).');">Previous</a>';
                            }
                            echo '&nbsp;&nbsp;';
                            if (count($photos['photo']) > 12) {
                                echo '<a href="javascript:flickr_showPage('.(int)($serendipity['POST']['flickr_page']+1).');">Next</a>';
                            }

                        } // end if
                    } // end if

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

} // end of class

/* vim: set sts=4 ts=4 expandtab : */
