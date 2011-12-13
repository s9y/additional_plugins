<?php

// Picasa Plugin for Serendipity
// 03/2005 by Thomas Nesges <thomas@tnt-computer.de>

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class xmlHandler
{
    var $inTagState;
    var $curTagState;
    var $itemCounter;
    var $startTag;
    var $elementNames;
    var $xmlReturnData;
    var $xmlParser;
    var $xmlData;
    var $error;


    function setElementNames($arrayNames) {

        $this->elementNames = $arrayNames;
    }
    
    function setStartTag($sTag) {

        $this->startTag = $sTag;
    }

    function startElementHandler($xmlParser, $elementName, $elementAttribs) {
    
        if($elementName == $this->startTag)
        {
            $this->inTagState = 1;
        }

        if($this->inTagState == 1)
        {
            $this->curTagState = $elementName;
        }
        else
        {
            $this->curTagState = '';
        }
    }

    function endElementHandler($xmlParser, $elementName) {

        $this->curTagState = '';
        if($elementName == $this->startTag)
        {
            $this->itemCounter++;
            $this->inTagState = 0;
        }
    }

    function characterDataHandler($xmlParser, $xmlData){

        if($this->curTagState == '' || $this->inTagState == 0)
        {
            return;
        }
        
        foreach($this->elementNames as $eNames)
        {
            if($this->curTagState == $eNames)
            {
                $strLoName = strtolower($eNames);

                // be sure to append character data, because the parser can call this function
                // multiple times in a tag, and all the calls should be appended together.
                $this->xmlReturnData[$this->itemCounter]["$strLoName"] .= $xmlData;
            }
        }
    }

    function xmlParse()
    {
        $this->inTagState     = 0;
        $this->curTagState    = '';
        $this->itemCounter    = 0;
        $this->xmlReturnData = array();
        $this->error = '';

        if(!($this->xmlParser = xml_parser_create("UTF-8")))
        {
            $this->error = "Couldn't create XML parser!";
        }
        xml_set_object($this->xmlParser, $this);
        xml_set_element_handler($this->xmlParser, "startElementHandler", "endElementHandler");
        xml_set_character_data_handler($this->xmlParser, "characterDataHandler");
        if(!xml_parse($this->xmlParser, $this->xmlData, true))
        {
            $this->error = xml_error_string(xml_get_error_code($this->xmlParser));
        }
        
        xml_parser_free($this->xmlParser);
        return $this->xmlReturnData;
    }

    function setXmlData($data) {

        $this->xmlData = $data;
    }

    function getXmlData() {

        return $this->xmlData;
    }
    
    function getErr() {

        return $this->error;
    }
}

class picasaXmlParser
{
    var $inImages;
    var $itemCounter;
    var $xmlReturnData;
    var $xmlParser;
    var $error;
    var $imagePathTags;
    var $charData;
    var $albumPathEscaped;

    function startElementHandler($xmlParser, $elementName, $elementAttribs)
    {
        if(0 == strcasecmp($elementName, 'images'))
        {
            $this->inImages = true;
        }
    }

    function endElementHandler($xmlParser, $elementName)
    {
        $lowerElementName = strtolower($elementName);
        if($lowerElementName == 'images')
        {
            $this->inImages = false;
        }
        else if($lowerElementName == 'image')
        {
            $this->itemCounter++;
        }
        else if($this->inImages)
        {
            $value = trim($this->charData);
            if(array_key_exists($lowerElementName, $this->imagePathTags))
            {
                $value = $this->albumPathEscaped . '/' . rawurlencode($value);
                $value = str_replace('%2F', '/', $value);
            }
            $this->xmlReturnData['images'][$this->itemCounter][$elementName] = $value;
        }
        else
        {
            $this->xmlReturnData[$elementName] = trim($this->charData);
        }
        $this->charData = '';
    }

    function characterDataHandler($xmlParser, $xmlData)
    {
        // be sure to append character data, because the parser can call this function
        // multiple times in a tag, and all the calls should be appended together.
        $this->charData .= $xmlData;
    }

    function xmlParse($albumPath)
    {
        $this->inImages       = false;
        $this->curTag         = '';
        $this->itemCounter    = 0;
        $this->xmlReturnData = array();
        $this->imagePathTags = array(
            'previmage'             => NULL,
            'firstimage'            => NULL,
            'itemlargeimage'        => NULL,
            'nextimage'             => NULL,
            'nextthumbnail'         => NULL,
            'previmage'             => NULL,
            'prevthumbnail'         => NULL,
            'lastimage'             => NULL,
            'lastthumbnail'         => NULL,
            'itemthumbnailimage'    => NULL
            );
        $this->charData = '';
        $splitPath = explode("/", $albumPath);
        $splitEncodedPath = array();
        foreach($splitPath as $elt) {
            $splitEncodedPath[] = rawurlencode($elt);
        }
        $this->albumPathEscaped = implode("/", $splitEncodedPath);

        $this->error = '';

        $xmlStr = file_get_contents($albumPath . '/index.xml');
        if(!$xmlStr || $xmlStr == '')
        {
            $this->error = PLUGIN_EVENT_PICASA_ERR_INDEXNOTFOUND." ($albumPath)";
            return;
        }

        if(! preg_match('@<\?xml@', $xmlStr)) {
            // repair broken xml generated by picasa..
            $xmlStr = '<?xml version="1.0" encoding="iso-8859-1"?>'.$xmlStr;
        }

        if(!($this->xmlParser = xml_parser_create("UTF-8")))
        {
            $this->error = "Couldn't create XML parser!";
            return;
        }
        xml_parser_set_option($this->xmlParser, XML_OPTION_CASE_FOLDING, 0);
        xml_set_object($this->xmlParser, $this);
        xml_set_element_handler($this->xmlParser, "startElementHandler", "endElementHandler");
        xml_set_character_data_handler($this->xmlParser, "characterDataHandler");
        if(!xml_parse($this->xmlParser, $xmlStr, true))
        {
            $this->error = xml_error_string(xml_get_error_code($this->xmlParser));
        }
        
        xml_parser_free($this->xmlParser);
        return $this->xmlReturnData;
    }

    function getErr() {

        return $this->error;
    }
}

class serendipity_event_picasa extends serendipity_event {
    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_PICASA_NAME);
        $propbag->add('description',   PLUGIN_EVENT_PICASA_DESC);
        $propbag->add('event_hooks',   array(
            'frontend_display'	=> true,
            'external_plugin'	=> true
        ));
        $propbag->add('stackable',       false);
        $propbag->add('author',          'Thomas Nesges, Greg Greenway');
        $propbag->add('version',         '1.13');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('IMAGES'));

        $this->markup_elements = array(
            array(
              'name'     => 'ENTRY_BODY',
              'element'  => 'body',
            ),
            array(
              'name'     => 'EXTENDED_BODY',
              'element'  => 'extended',
            ),
            array(
              'name'     => 'HTML_NUGGET',
              'element'  => 'html_nugget',
            )
        );

        $conf_array = array();
        foreach($this->markup_elements as $element) {
            $conf_array[] = $element['name'];
        }

        $conf_array[] = 'picasapath';
        $conf_array[] = 'showtitle';
        $conf_array[] = 'jswindow';
        $conf_array[] = 'smarty_template';
        $conf_array[] = 'upload_image_size';
        $conf_array[] = 'create_entry_after_upload';

        $propbag->add('configuration', $conf_array);
    }


    function generate_content(&$title) {
        $title = PLUGIN_EVENT_PICASA_NAME;
    }


    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'picasapath':
                $propbag->add('name',           PLUGIN_EVENT_PICASA_PROP_PATH);
                $propbag->add('description',    PLUGIN_EVENT_PICASA_PROP_PATH_DESC);
                $propbag->add('default',        '');
                $propbag->add('type',           'string');
                break;
            case 'showtitle':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_PICASA_PROP_SHOWTITLE);
                $propbag->add('description',    PLUGIN_EVENT_PICASA_PROP_SHOWTITLE_DESC);
                $propbag->add('default',        "true");
                break;
            case 'jswindow':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_PICASA_PROP_JSWINDOW);
                $propbag->add('description',    PLUGIN_EVENT_PICASA_PROP_JSWINDOW_DESC);
                $propbag->add('default',        "true");
                break;
            case 'smarty_template':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_PICASA_PROP_SMARTY);
                $propbag->add('description',    PLUGIN_EVENT_PICASA_PROP_SMARTY_DESC);

                $select_values['none'] = PLUGIN_EVENT_PICASA_PROP_SMARTY_NONE;
                $plugin_dir = dirname(__FILE__);
                if($handle = opendir($plugin_dir)) {
                    while (false !== ($file = readdir($handle))) {
                        if(preg_match('/\.tpl/i', $file)) {
                            $select_values[$plugin_dir.'/'.$file] = ucwords(str_replace(array('.tpl', '_'), array('', ' '), $file));
                        }
                    }
                    closedir($handle);
                }
                $propbag->add('select_values',  $select_values);
                $propbag->add('default',        'none');
                break;

            case 'upload_image_size':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_PICASA_PROP_UPLOAD_SIZE);
                $propbag->add('description',    PLUGIN_EVENT_PICASA_PROP_UPLOAD_SIZE_DESC);
                $propbag->add('default',        '640');
                break;

            case 'create_entry_after_upload':
                $propbag->add('type',            'boolean');
                $propbag->add('name',            PLUGIN_EVENT_PICASA_PROP_CREATE_ENTRY_AFTER_UPLOAD);
                $propbag->add('description',     PLUGIN_EVENT_PICASA_PROP_CREATE_ENTRY_AFTER_UPLOAD_DESC);
                $propbag->add('default',         "true");
                break;

            default:
                $propbag->add('name', $name);
                $propbag->add('description',    sprintf(APPLY_MARKUP_TO, $name));
                $propbag->add('type',           'boolean');
                break;
        }
        return true;
    }

    function event_hook($event, &$bag, &$eventData) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
              case 'frontend_display':
                $picasapath = $this->get_config('picasapath');

                foreach ($this->markup_elements as $temp) {
                    if (serendipity_db_bool($this->get_config($temp['name'], true)) && isset($eventData[$temp['element']]) &&
                            !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                            !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                        $element = $temp['element'];
                        if ($temp['name'] == 'ENTRY_BODY' || $temp['name'] == 'EXTENDED_BODY' || $temp['name'] == 'HTML_NUGGET') {
                            while(preg_match('@\[picasa\s*([^\]]*)\](.*?)\[/picasa\]@', $eventData[$element], $matches)) {
                                $attr = array();
                                $attributes = explode(' ', $matches[1]);
                                foreach($attributes as $a) {
                                    $kv = explode('=', $a);
                                    $attr[$kv[0]] = preg_replace('@[\'"]@', '', $kv[1]);
                                }
                                $album = $matches[2];
                                if ($attr['path'] != "") {
                                    $albumpath = $attr['path'].'/'.$album;
                                } else {
                                    $albumpath = $picasapath.'/'.$album;
                                }
                                $picasa = $this->picasa_album($albumpath, $attr['template']);
                                $eventData[$element] = preg_replace('@'.quotemeta($matches[0]).'@', $picasa, $eventData[$element], 1);
                            }
                        }
                    }
                }
                return true;
                break;

            case 'external_plugin':
                $param      = explode('/', $eventData);
                $plugincode = array_shift($param);
                if($plugincode == 'picasa_pre_upload')
                {
                    $this->picasa_pre_upload();
                    return true;
                }
                else if($plugincode == 'picasa_upload')
                {
                    $this->picasa_upload();
                    return true;
                }
                else if($plugincode == 'picasa_upload_report_status')
                {
                    $this->picasa_upload_report_error($param);
                    return true;
                }
                return false;
                break;

              default:
                return false;
            }

        } else {
            return false;
        }
    }

    function picasa_album($album, $template="") {
        global $serendipity;

        $plugin_dir = dirname(__FILE__);

        $jswindow           = $this->get_config('jswindow');
        $showtitle          = $this->get_config('showtitle');
        if($template) {
            $searchpathes = array(
                $template,
                $plugin_dir.'/'.$template,
                $plugin_dir.'/'.$template.'.tpl',
                $plugin_dir.'/'.strtolower($template),
                $plugin_dir.'/'.strtolower($template).'.tpl',
                $plugin_dir.'/'.strtolower(preg_replace('/\s/', '_', $template)).'.tpl'
            );
            foreach($searchpathes as $trytemplate) {
                if(file_exists($trytemplate)) {
                    $smarty_template = $trytemplate;
                    break;
                }
            }
        } else {
            $smarty_template    = $this->get_config('smarty_template');
        }

        $xh = new picasaXmlParser();
        $xmlData = $xh->xmlParse($album);
        $xmlError = $xh->getErr();
        if($xmlError != '')
            return $xmlError;

        $albumName      = $xmlData['albumName'];
        $albumCaption   = $xmlData['albumCaption'];
        $albumItemCount = $xmlData['albumItemCount'];

        foreach($xmlData['images'] as $ikey => $ivalue) {
             $xmlData['images'][$ikey]['itemCaption'] = htmlspecialchars($ivalue['itemCaption'], ENT_QUOTES, false);
        }
                            
        if($smarty_template == 'none') {
            $album_code = "<h4 class='".get_class($this)."'>$albumName</h4>";
            if($albumCaption) {
                $album_code .= "<h5 class='".get_class($this)."'>$albumCaption</h5>";
            }
            foreach($xmlData['images'] as $ii)  {
                $album_code .= '<a href="'.$ii[itemLargeImage].'"';
                if($jswindow==TRUE) {
                    $album_code .= 'onClick="window.open(\''.$ii[itemLargeImage].'\', \'picasa\', \'height='.($ii[itemHeight]+20).', width='.($ii[itemWidth]+20).', resizable=no, scrollbars=no, toolbar=no, status=no, menubar=no, location=no\');"';
                }
                $album_code .= 'target="picasa"><img border="0" src="'.$ii[itemThumbnailImage].'" height="'.$ii[itemThumbnailHeight].'" width="'.$ii[itemThumbnailWidth].'" alt="'.$ii[itemCaption].'"></a> ';
            }
        } else {
            $serendipity['smarty']->assign(get_class($this).'_albumName',      $albumName);
            $serendipity['smarty']->assign(get_class($this).'_albumCaption',   $albumCaption);
            $serendipity['smarty']->assign(get_class($this).'_albumItemCount', $albumItemCount);
            $serendipity['smarty']->assign(get_class($this).'_images',         $xmlData['images']);
            $serendipity['smarty']->assign(get_class($this).'_use_jswindow',   $jswindow);

            $serendipity['smarty']->security_settings['MODIFIER_FUNCS'][] = "rand"; // necessary tweak before 0.8 final
            $inclusion = $serendipity['smarty']->security_settings[INCLUDE_ANY];
            $serendipity['smarty']->security_settings[INCLUDE_ANY] = true;
            $album_code = $serendipity['smarty']->fetch($smarty_template);
            $serendipity['smarty']->security_settings[INCLUDE_ANY] = $inclusion;
        }
        return $album_code;
    }

    function picasa_pre_upload()
    {
        global $serendipity;

        if(!serendipity_userLoggedIn())
        {
            if(!serendipity_login())
            {
                // save off the rss data because it won't be posted again
                if($_POST['rss'])
                    $_SESSION['picasa_rss'] = $_POST['rss'];

                echo "<html>\n";
                echo "<head>\n";
                echo "<script language=javascript> function sf() { document.getElementById('serendipity[user]').focus(); }</script>\n";
                echo "</head>\n";
                echo "<body onload='javscript:sf()'>\n";
                echo "<form name='f' method='post' action='index.php?/plugin/picasa_pre_upload'>\n";
                echo "<h2>" . PLUGIN_EVENT_PICASA_UPLOAD_HEADER . $serendipity['baseURL'] . "</h2>\n";
                echo PLUGIN_EVENT_PICASA_UPLOAD_USERNAME . "<br />\n";
                echo "<input type='text' name='serendipity[user]' /><br />\n";
                echo PLUGIN_EVENT_PICASA_UPLOAD_PASSWORD . "<br />\n";
                echo "<input type='password' name='serendipity[pass]' /><br />\n";
                echo "<input id='autologin' type='checkbox' name='serendipity[auto]' /><label for='autologin'>" . PLUGIN_EVENT_PICASA_UPLOAD_REMEMBER_LOGIN . "</label><br />\n";
                echo "<input type='submit' name='submit' value='" . PLUGIN_EVENT_PICASA_UPLOAD_LOGIN . "' />";
                echo "<input type='button' value='" . PLUGIN_EVENT_PICASA_UPLOAD_DISCARD . "' onclick=\"location.href='minibrowser:close'\">\n";
                echo "</form>\n";
                echo "</body>\n";
                echo "</html>\n";

                return;
            }
        }

        if(!$_POST['rss'])
        {
            if(!$_SESSION['picasa_rss'])
            {
                echo PLUGIN_EVENT_PICASA_ERR_MISSING_RSS;
                return;
            }
            else
            {
                $rss = $_SESSION['picasa_rss'];
            }
        }
        else
        {
            $rss = $_POST['rss'];
        }

        $imgSize = $this->get_config('upload_image_size');
        $thumbSize = $serendipity['thumbSize'];

        $xh = new xmlHandler();
        $nodeNames = array("PHOTO:THUMBNAIL", "PHOTO:IMGSRC", "TITLE", "DESCRIPTION");
        $xh->setElementNames($nodeNames);
        $xh->setStartTag("ITEM");
        $xh->setXmlData($rss);
        $pData = $xh->xmlParse();

        // save this since we need to access the descriptions during upload
        $_SESSION['picasa_rss_parsed'] = $pData;

        echo "<html>\n";
        echo "<head>\n";
        echo "<script language=javascript> function sf() { document.getElementById('albumName').focus(); }</script>\n";
        echo "</head>\n";
        echo "<body onload='javscript:sf()'>\n";
        echo "<form name='f' method='post' action='index.php?/plugin/picasa_upload'>\n";
        echo "<h2>" . PLUGIN_EVENT_PICASA_UPLOAD_HEADER . $serendipity['baseURL'] . "</h2>\n";
        echo "<div>" . PLUGIN_EVENT_PICASA_UPLOAD_ALBUMNAME . "</div>\n";
        echo "<div><input type='text' name='albumName' tabindex='1'></div>\n";
        echo "<div>" . PLUGIN_EVENT_PICASA_UPLOAD_DESCRIPTION . "</div>\n";
        echo "<div><textarea name='albumDescription' rows='5' cols='50'></textarea></div>\n";
        echo "<div>" . PLUGIN_EVENT_PICASA_UPLOAD_PARENTDIR . "</div>\n";

        echo "<select name='parentDir' id='parentDir'>\n";
        echo "<option value=''>" . PLUGIN_EVENT_PICASA_UPLOAD_PARENTDIR_BASEDIR . "</option>\n";
        $picasapath = $this->get_config('picasapath');
        $paths = serendipity_traversePath($picasapath);
        $prunedPaths = array();
        foreach($paths as $path)
        {
            $name = $path['name'];
            $relpath = $path['relpath'];

            // check if this is a subdirectory of an already pruned directory
            $subdirOfPruned = false;
            foreach($prunedPaths as $prunedPath)
            {
                if(0 == strncmp($prunedPath, $relpath, strlen($prunedPath)))
                {
                    $subdirOfPruned = true;
                    break;
                }
            }

            // don't allow nesting of albums; if the album has any subdirectories, collisions could happen
            if(!file_exists($picasapath . '/' . $relpath . '/index.xml'))
            {
                if(!$subdirOfPruned)
                {
                    $splitPath = explode('/', $relpath);
                    $encodedRelpath = htmlentities($relpath, ENT_QUOTES);
                    $prefix = str_repeat('&nbsp;&nbsp;', count($splitPath));
                    echo "<option value='$encodedRelpath'>$prefix $name</option>\n";
                }
            }
            else
            {
                $prunedPaths[] = $relpath;
            }
        }
        echo "</select>\n";

        // Image request queue: add image requests for base image & clickthrough
        foreach($pData as $e)
        {
            // use a thumbnail if you don't want exif (saves space)
            // thumbnail requests are clamped at 144 pixels
            // (negative values give square-cropped images)
            $small = $e['photo:thumbnail']."?size=$thumbSize";
            $large = $e['photo:imgsrc']."?size=$imgSize";
            
            echo "<input type='hidden' name='$large'>\n";
            echo "<input type='hidden' name='$small'>\n";
        }

        echo "<br />\n";
        echo "<input type=submit value='" . PLUGIN_EVENT_PICASA_UPLOAD_UPLOAD . "'>\n";
        echo "<input type=button value='" . PLUGIN_EVENT_PICASA_UPLOAD_DISCARD . "' onclick=\"location.href='minibrowser:close'\">\n";
        echo "</form><br />\n";

        // Preview "tray": draw thumbnails of each image that will be uploaded
        foreach($pData as $e)
        {
            $thumb = $e['photo:thumbnail'];
            echo "<img src='$thumb?size=$thumbSize'>\n";
        }

        echo "</body>\n";
        echo "</html>\n";
    }

    function writeXMLTag($outputFile, $tagname, $tagval)
    {
        // undo encoding, including all quotes, then re-encode without encoding
        // the quotes because this the text of the xml tag, which doesn't need quotes
        $unescapedvalue = htmlentities(html_entity_decode($tagval, ENT_QUOTES), ENT_NOQUOTES);
        fputs($outputFile, "<$tagname>$unescapedvalue</$tagname>\n");
    }

    function writeXMLTagBool($outputFile, $tagname, $tagval)
    {
        $this->writeXMLTag($outputFile, $tagname, $tagval ? "true" : "false");
    }

    function mkdir_recursive($pathname, $mode)
    {
        is_dir(dirname($pathname)) || $this->mkdir_recursive(dirname($pathname), $mode);
        return is_dir($pathname) || @mkdir($pathname, $mode);
    }

    function picasa_upload()
    {
        global $serendipity;

        if(!serendipity_userLoggedIn())
        {
            $this->report_upload_result('You must be logged in to upload an album.');
        }
        if(!count($_FILES))
        {
            $this->report_upload_result('Missing files');
            return;
        }
        if(!isset($_POST['albumName']))
        {
            $this->report_upload_result('Missing album name');
            return;
        }
        if(!isset($_POST['parentDir']))
        {
            $this->report_upload_result('Missing parent directory');
            return;
        }
        if(!isset($_SESSION['picasa_rss_parsed']))
        {
            $this->report_upload_result('Missing parsed rss (needed for descriptions)');
            return;
        }

        $albumName = html_entity_decode($_POST['albumName'], ENT_QUOTES);

        $decodedParentDir = html_entity_decode($_POST['parentDir'], ENT_QUOTES);
        $albumDir = $decodedParentDir . $albumName;
        $dirname = $this->get_config('picasapath') . '/' . $albumDir;

        if(file_exists($dirname))
        {
            $this->report_upload_result(PLUGIN_EVENT_PICASA_ERR_UPLOAD_DIR_ALREADY_EXISTS);
            return;
        }

        $this->mkdir_recursive($dirname, 0755);
        if(!is_dir($dirname))
        {
            $this->report_upload_result(PLUGIN_EVENT_PICASA_ERR_DIR_CREATION_FAILED);
            return;
        }

        // first move all the files to their final destination and put their information
        // in a map.  Match up thumbs with their main image.
        foreach($_FILES as $key => $file)
        {
            if (!empty($file))
            {
                // obtain the original filename from Picasa
                $tmpfile  = $file['tmp_name'];
                $fname    = $file['name'];

                // If this is the thumbnail, change the path from name.ext to name.thumb.ext
                // The image and thumbnail keys look like:
                // http://localhost:3671/92c624539502989c5b1d84401a47f03d/image/1262eaef64f127c2_jpg?size=640
                // http://localhost:3671/92c624539502989c5b1d84401a47f03d/thumb/1262eaef64f127c2_jpg?size=90
                if(strpos($key, '/thumb/') != false)
                {
                    $periodPos = strrpos($fname, '.');
                    $destName = substr($fname, 0, $periodPos) . ".thumb" . substr($fname, $periodPos);
                    $imageType = 'thumb';
                }
                else
                {
                    $destName = $fname;
                    $imageType = 'image';
                }

                $destPath  = "$dirname/$destName";

                if (move_uploaded_file($tmpfile, $destPath))
                {
                    chmod($destPath, 0644);
                }

                $dims = serendipity_getimagesize($destPath);

                $entriesByName[$fname][$imageType] = $destName;
                $entriesByName[$fname][$imageType . 'width'] = $dims[0];
                $entriesByName[$fname][$imageType . 'height'] = $dims[1];
            }
        }

        // go through the captions and associate them with the correct image
        foreach($_SESSION['picasa_rss_parsed'] as $e)
        {
            if(array_key_exists('description', $e) && isset($e['title']) && array_key_exists($e['title'], $entriesByName))
            {
                $entriesByName[$e['title']]['caption'] = $e['description'];
            }
        }

        // put the map into an array
        $entries = array();
        foreach($entriesByName as $key => $value)
        {
            $value['name'] = $key;
            $entries[] = $value;
        }
        
        $imageCount = count($entries);
        $albumDesc = html_entity_decode($_POST['albumDescription'], ENT_QUOTES);
        
        $xmlPath = "$dirname/index.xml";
        $xmlFile = fopen($xmlPath, 'w+');

        fputs($xmlFile, "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n");
        fputs($xmlFile, "<album>\n");
        $this->writeXMLTag($xmlFile, "albumName", $albumName);
        $this->writeXMLTag($xmlFile, "albumItemCount", $imageCount);
        $this->writeXMLTag($xmlFile, "albumCaption", $albumDesc);
        fputs($xmlFile, "<images>\n");

        $emptyEntry = array('name' => '',
                            'image' => '',
                            'thumb' => '',
                            'caption' => '');

        $firstImage = $entries[0];
        $lastImage = $entries[count($entries) - 1];
        foreach($entries as $index => $data)
        {
            if(!array_key_exists('caption', $data))
                $data['caption'] = $data['image'];

            $prev = array_key_exists($index - 1, $entries) ? $entries[$index - 1] : $emptyEntry;
            $next = array_key_exists($index + 1, $entries) ? $entries[$index + 1] : $emptyEntry;

            fputs($xmlFile, "<image>\n");

            $this->writeXMLTagBool($xmlFile, "isFirstImage", $index == 0);
            $this->writeXMLTagBool($xmlFile, "isPrevImage", $index != 0);
            $this->writeXMLTagBool($xmlFile, "isLastImage", $index == ($imageCount - 1));
            $this->writeXMLTagBool($xmlFile, "isNextImage", $index != ($imageCount - 1));
            $this->writeXMLTag($xmlFile, "firstImage", $firstImage['image']);
            $this->writeXMLTag($xmlFile, "itemLargeImage", $data['image']);
            $this->writeXMLTag($xmlFile, "nextImage", $next['image']);
            $this->writeXMLTag($xmlFile, "nextThumbnail", $next['thumb']);
            $this->writeXMLTag($xmlFile, "prevImage", $prev['image']);
            $this->writeXMLTag($xmlFile, "prevThumbnail", $prev['thumb']);
            $this->writeXMLTag($xmlFile, "lastImage", $lastImage['image']);
            $this->writeXMLTag($xmlFile, "lastThumbnail", $lastImage['thumb']);
            $this->writeXMLTag($xmlFile, "itemWidth", $data['imagewidth']);
            $this->writeXMLTag($xmlFile, "itemHeight", $data['imageheight']);
            $this->writeXMLTag($xmlFile, "itemThumbnailImage", $data['thumb']);
            $this->writeXMLTag($xmlFile, "itemThumbnailWidth", $data['thumbwidth']);
            $this->writeXMLTag($xmlFile, "itemThumbnailHeight", $data['thumbheight']);
            $this->writeXMLTag($xmlFile, "itemName", $data['image']);
            $this->writeXMLTag($xmlFile, "itemNumber", $index);
            $this->writeXMLTag($xmlFile, "itemOriginalPath", "");
            $this->writeXMLTag($xmlFile, "itemNameOnly", "");
            $this->writeXMLTag($xmlFile, "itemCaption", $data['caption']);
            $this->writeXMLTag($xmlFile, "itemSize", "");

            fputs($xmlFile, "</image>\n");
        }

        fputs($xmlFile, "</images>\n");
        fputs($xmlFile, "</album>\n");

        fclose($xmlFile);

        if($this->get_config('create_entry_after_upload'))
        {
            // create a new entry using the newly uploaded album
            $entry                      = array();
            $entry['isdraft']           = 'true';
            $entry['title']             = $albumName;
            $entry['body']              = '<p>[picasa]' . $albumDir . '[/picasa]</p>';
            $entry['authorid']          = $serendipity['authorid'];
            $entry['exflag']            = false;
            $entry['allow_comments']    = 'true';
            $entry['moderate_comments'] = 'false';
            $id = serendipity_updertEntry($entry);
            $retUrl = $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[action]=admin&serendipity[adminModule]=entries&serendipity[adminAction]=edit&serendipity[id]=' . $id;
            echo $retUrl;
        }
        else
        {
            $this->report_upload_result(PLUGIN_EVENT_PICASA_UPLOAD_SUCCESS);
        }
    }

    function report_upload_result($text)
    {
        global $serendipity;

        $encodedText = urlencode($text);
        echo $serendipity['baseURL'] . "index.php?/plugin/picasa_upload_report_status/$encodedText";
    }

    function picasa_upload_report_error($text)
    {
        echo urldecode($text[0]);
    }

    function example()
    {
        $s  = "<p>Instructions for adding an upload button to Google Picasa:</p>\n";
        $s .= "<ol>\n";
        $s .= "<li>" . PLUGIN_EVENT_PICASA_EXAMPLE_STEP1 . "<a href='plugins/serendipity_event_picasa/s9yButton.pbz'>plugins/serendipity_event_picasa/s9yButton.pbz</a></li>\n";
        $s .= "<li>" . PLUGIN_EVENT_PICASA_EXAMPLE_STEP2 . "</li>\n";
        $s .= "<li>" . PLUGIN_EVENT_PICASA_EXAMPLE_STEP3 . "</li>\n";
        $s .= "<li>" . PLUGIN_EVENT_PICASA_EXAMPLE_STEP4 . "</li>\n";
        $s .= "<li>" . PLUGIN_EVENT_PICASA_EXAMPLE_STEP5 . "</li>\n";
        $s .= "<li>" . PLUGIN_EVENT_PICASA_EXAMPLE_STEP6 . "</li>\n";
        $s .= "<li>" . PLUGIN_EVENT_PICASA_EXAMPLE_STEP7 . "</li>\n";
        $s .= "<li>" . PLUGIN_EVENT_PICASA_EXAMPLE_STEP8 . "</li>\n";
        $s .= "</ol>\n";
        return $s;
    }
}
?>
