<?php 
// Thanks to Boris for his sitemap generator plugin 

/*
TODO:
  - Integrate static pages (e.g. contact) in footer navigation with accesskeys
  - Improve WURFL integration for image scaling
  - Pagination
  - Rewrite external links to squeezer or similar
  - Integrate comments
  - Testing, testing and some testing indeed!
*/

if (IN_serendipity !== true) {
    die ("Don't hack!");
}
@define('PLUGIN_EVENT_MOBILE_VERSION','1.04');
@define('PLUGIN_EVENT_MOBILE_AUTHORS','Pelle Boese, Grischa Brockhaus');

@define('PLUGIN_EVENT_MOBILE_TPL_IPHONE','iphone.app');
@define('PLUGIN_EVENT_MOBILE_TPL_ANDROID','android.app');
@define('PLUGIN_EVENT_MOBILE_TPL_XHTML','xhtml_mp');

// include mobile class
$mobile = dirname(__FILE__) . '/mobile.class.php';
$template = dirname(__FILE__) . '/template.class.php';
if(file_exists($mobile)) {
    require_once($mobile);
} else {
    die('Missing required file mobile.class.php');
}
if(file_exists($template)) {
    require_once($template);
} else {
    die('Missing required file template.class.php');
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_mobile_output extends serendipity_event
{
    var $title = PLUGIN_EVENT_MOBILE_OUTPUT_NAME;
    var $cleanup_tag, $cleanup_checkfor, $cleanup_val, $cleanup_parse;

    var $debugItems = array();
    
    function generate_content(&$title) {
        $title = $this->title;
    }

    function install() {
        $this->cleanup();
    }
    function cleanup() {
        global $serendipity;
    
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
        // create directory to store external images from articles
        $upload_dir = $serendipity['serendipityPath'] . $serendipity['uploadPath'] . 'plugin_mobile_output/';
        if(!file_exists($upload_dir)) {
          mkdir($upload_dir);
        }
        
        // Copy templates to template folder, if not existing
        $this->copyTemplate(PLUGIN_EVENT_MOBILE_TPL_IPHONE);
        $this->copyTemplate(PLUGIN_EVENT_MOBILE_TPL_ANDROID);
        $this->copyTemplate(PLUGIN_EVENT_MOBILE_TPL_XHTML);
    }
    
    private function copyTemplate( $localName ) {
        $src_template_meta = new serendipity_template_meta('plugins/serendipity_event_mobile_output/templates/' . $localName);
        $dst_template_meta = new serendipity_template_meta($localName);
        if (@file_exists($src_template_meta->getTemplateDir()) && !(@file_exists($dst_template_meta->getTemplateDir()))) {
            $this->recurse_dircopy($src_template_meta->getTemplateDir(), $dst_template_meta->getTemplateDir());
        }        
    } 

    function uninstall(&$propbag) {
        global $serendipity;
        serendipity_plugin_api::hook_event('backend_cache_purge', $this->title);
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
        // delete directory with external images from articles
        $upload_dir = $serendipity['serendipityPath'] . $serendipity['uploadPath'] . 'plugin_mobile_output/';
        if( is_dir($upload_dir) ) {
            // delete all files in the upload directory
            $files = glob($upload_dir.'*');
            if( is_array($files) && !empty($files) ) {
                foreach($files as $file) {
                    @unlink($file);
                }
            }
            @rmdir($upload_dir);
        }
    }

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_MOBILE_OUTPUT_NAME);
        $propbag->add('description',   PLUGIN_EVENT_MOBILE_OUTPUT_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        PLUGIN_EVENT_MOBILE_AUTHORS);
        $propbag->add('website',       'http://c.mobile-seo.de/');
        $propbag->add('version',       PLUGIN_EVENT_MOBILE_VERSION);
        $propbag->add('requirements',  array(
            'serendipity' => '1.0',
            'smarty'      => '2.6.7',
            'php'         => '5.0.0',
        ));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('groups', array('MARKUP'));
        $propbag->add('configuration', array(
          								'enable',
          								'mobile_template',
          								'iphone_template',
                                        'android_template',
          								'categories',
                                        'smallteaser',
          								'images',
          								'scale_image_width',
          								'wurfl',
          								'redirect',
          								'redirect_url',
          								'sticky_host',
          								'remove_tags',
          								'remove_attributes',
          								'rewrite_wikipedia',
          								'sitemap',
          								'sitemap_pingback',
          								'sitemap_pingback_urls',
          								'gzip_sitemap',
          								'debug_password',
          					));
        $propbag->add('event_hooks',   array(
            'backend_publish' => true,
            'backend_save' => true,
            'frontend_configure' => true,
            'entry_display' => true,
        ));

        return true;
    }
    
    function example() {
        $template = $this->get_config('iphone_template');
        $template_meta = new serendipity_template_meta($template);
        $s = '';
        if (!@file_exists($template_meta->getTemplateDir())) {
            $s .= "Template " . $template . " not installed. You will find one for each type in the plugin directory.";
            $s .= "<br/>";
        }
        $template = $this->get_config('android_template');
        $template_meta = new serendipity_template_meta($template);
        if (!@file_exists($template_meta->getTemplateDir())) {
            $s .= "Template " . $template . " not installed. You will find one for each type in the plugin directory.";
            $s .= "<br/>";
        }
        $template = $this->get_config('mobile_template');
        $template_meta = new serendipity_template_meta($template);
        if (!@file_exists($template_meta->getTemplateDir())) {
            $s .= "Template " . $template . " not installed. You will find one for each type in the plugin directory.";
            $s .= "<br/>";
        }
        
        return $s;
    }
    
    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;
        $hooks = &$bag->get('event_hooks');
      
  		if(isset($hooks[$event])) {
        switch($event) {
          ////////////////////////////////////////////////////////////////////
          // SITEMAP
          ////////////////////////////////////////////////////////////////////
          case 'backend_publish':
          case 'backend_save':
            if($this->get_config('sitemap'))
              $this->generateSitemap($bag);
            return true;
          break;            
        }
    }

    // plugin enabled?
    if(!$this->get_config('enable')) 
        return false;
   	  
    // get instance of serendipity_mobile class
    $this->m = serendipity_mobile::getInstance($this->debugItems);

    // mobile device?
    if(!$this->m->isMobileDevice && $_SERVER['HTTP_HOST']!=$this->get_config('sticky_host'))
        return false;
      
    if($this->m->isMobileDevice)
        $this->debugItems[] = 'Mobile device found';

    if ($this->m->isIPhone) {
        $this->debugItems[] = 'Apple IPhone or IPod Touch device found';
    }
    if ($this->m->isAndroid) {
        $this->debugItems[] = 'Android device found';
    }
	
	if($_SERVER['HTTP_HOST']==$this->get_config('sticky_host'))
	  $this->debugItems[] = 'Sticky host! Outputting mobile markup anyways';

	if(isset($hooks[$event])) {
   	switch($event) {
      ////////////////////////////////////////////////////////////////////
      // FRONTEND
      ////////////////////////////////////////////////////////////////////
      case 'frontend_configure':
        // redirect? don't loop and don't redirect admin backend
        if($this->get_config('redirect') &&  $this->get_config('redirect_url') != $_SERVER['HTTP_HOST'] && !strstr($_SERVER['REQUEST_URI'],'serendipity_admin.php')) {
          header('Status: 302 Found');
          header('Location: http://' . $this->get_config('redirect_url') . $_SERVER['REQUEST_URI']);
          exit;
        }

        // set template and css to the included style.css - requires the (normally included) xhtml_mp or iphone template from http://c.seo-mobile.de/
        $this->debugItems[] = 'Charset: '.LANG_CHARSET;
	    
	    if($this->m->isIPhone == true) {
            $template = $this->get_config('iphone_template');
        } elseif($this->m->isAndroid == true) {
            $template = $this->get_config('android_template');
	    } else {
            $template = $this->get_config('mobile_template');
	    }
        if (!empty($template)) {
            $eventData['template'] = $template;
            $eventData['template_engine'] = $template;
            $serendipity['smarty_vars']['head_link_stylesheet'] = $serendipity['baseURL'] . 'serendipity.css.php?switch=' . $template;
            $this->debugItems[] = 'Template changed to: '.$template;
        }
            
        return true;
        break;
              
        ////////////////////////////////////////////////////////////////////
        // ENTRIES
        ////////////////////////////////////////////////////////////////////
        case 'entry_display':
            // AJAX Request (IPhone)
            if($_SERVER['HTTP_X_XMLHTTPREQUEST']) {
                $serendipity['smarty']->assign(array('ajax'=>1));
            } else {
                $serendipity['smarty']->assign(array('ajax'=>0));
            }

            // send content-type xhtml header (not for iphones)
    	    if($this->m->isIPhone == true || $this->m->isAndroid == true) {
                header('Content-Type: text/html; charset='.LANG_CHARSET);
    	    } else {
                header('Content-Type: application/xhtml+xml; charset='.LANG_CHARSET);
    	    }

          	// add categories to footer navigation?
          	if($this->get_config('categories')) {
           		$this->debugItems[] = 'Adding categories to footer navigation';
           		$this->assignCategories($serendipity);
           	}
            
            $smallteaser = $this->get_config('smallteaser', true);
            
            $template_meta = new serendipity_template_meta($serendipity['template']);
            $template_supports_extended_articles = $template_meta->supports('ext_article'); 
            
            $article_overview = count($eventData)>1;
          	foreach($eventData AS $key=>$entry) {
                // get body and extended body
                $body = $this->cleanupMobileHtml($this->getFieldReference('body', $entry), $serendipity);
                $extended = $this->cleanupMobileHtml($this->getFieldReference('extended', $entry), $serendipity);
                if (!$article_overview && !$template_supports_extended_articles) {
                    $body .= $extended;
                }
                
                if ($article_overview && $smallteaser) {
                    if (preg_match('/^(.+?)<\/p>/', $body, $matches)) {
                        $body = $matches[1] . "</p>";
                    }
                }

                // debugging
                $this->debug($serendipity);
                
                // check for caching again
                if($eventData[$key]['properties']['ep_cache_body']) {
                    $eventData[$key]['properties']['ep_cache_body'] = $body;
                    $eventData[$key]['properties']['ep_cache_extended'] = $extended;
                } elseif($eventData[$key]['ep_cache_body']) {
                    $eventData[$key]['ep_cache_body'] = $body;
                    $eventData[$key]['ep_cache_extended'] = $extended;
                } else {
                    $eventData[$key]['body'] = $body;
                    $eventData[$key]['extended'] = $extended;
                }
                //return true; // do all entries!
            }
          break;
        }
      }
    }
    function cleanupMobileHtml( &$textpart, &$serendipity ) {
        // parse HTML, remove comments and other unneeded elements and attributes and return DOM
        $this->debugItems[] = 'Parsing DOM';
        $dom = $this->m->parseHTML($textpart, LANG_CHARSET, $this->get_config('remove_tags'), $this->get_config('remove_attributes'), $this->debugItems);
        
        // rewrite wikipedia links?
        if($this->get_config('rewrite_wikipedia')) {
            $this->debugItems[] = 'Rewriting wikipedia.org links to wikipedia.7val.com';
            $this->m->rewriteWikipediaLinks($dom, $this->debugItems);
        }
        
        // remove images?
        if(!$this->get_config('images')) {
            $this->debugItems[] = 'Removing all images from DOM';
            $dom = $this->m->removeImages($dom, $this->debugItems);
        }
        else {
            $this->debugItems[] = 'Removing all image dimensions from DOM';
            $dom = $this->m->removeImagesDimensions($dom, $this->debugItems);
        }
                
        // scale images?
        if($this->get_config('images') && ($this->get_config('scale_image_width')>0 || $this->get_config('wurfl'))) {
            $this->scaleImages($dom, $serendipity);
        }
                
        // save valid XML as entry body
        $textpart = $this->m->cleanUp($dom, LANG_CHARSET, $this->debugItems);
        return $textpart;
    }
    
    function scaleImages(&$dom,&$serendipity) {
      if($this->get_config('wurfl')) {
        $this->debugItems[] = 'Trying to scale images with WURFL';
        
        // already did a wurfl check for this device in our session?
        if($_SESSION['mobile_plugin']['ua']==$_SERVER['HTTP_USER_AGENT'] && $_SESSION['mobile_plugin']['wurfl']['width']) {
          // got the wurfl result stored in session
          $imageWidth = $_SESSION['mobile_plugin']['wurfl']['width'];
  			  $this->debugItems[] = 'We don\'t need to query WURFL again as the result was stored in our session';
        } else {
          // load wurfl php
          require_once(dirname(__FILE__).'/wurfl/wurfl_config.php');
  	 		  require_once(WURFL_CLASS_FILE);
  		  	// create wurfl object
  			  $W = new wurfl_class();
  			  $this->debugItems[] = 'WURFL object created';
  			  // query wurfl
  			  $W->GetDeviceCapabilitiesFromAgent($_SERVER['HTTP_USER_AGENT']);
  			  // get maximum image width from wurfl
  			  $imageWidth = (int)$W->getDeviceCapability('max_image_width')-20;
        }
        if($imageWidth<0) {
            // fallback
            $dom = $this->m->scaleImages($dom, $serendipity, $this->get_config('scale_image_width'), S9Y_PEAR_PATH, $this->debugItems);
            $this->debugItems[] = 'Device not found in WURFL or screen to small. Using maximum image width as fallback';
        } else {
            // found a device
            $_SESSION['mobile_plugin']['wurfl']['width'] = $imageWidth;
            $dom = $this->m->scaleImages($dom, $serendipity, $imageWidth, S9Y_PEAR_PATH, $this->debugItems);
            $this->debugItems[] = 'Device found in WURFL, images were scaled';
        }
      } else if(serendipity_db_bool($this->get_config('wurfl')) && $this->m->isIPhone === true) {
        // fix image width for iphone if not found in wurfl
        $this->debugItems[] = 'Scaling images for iPhone device';
        $dom = $this->m->scaleImages($dom, $serendipity, 300, S9Y_PEAR_PATH, $this->debugItems);
        $this->debugItems[] = 'Scaled all images';
      } else {
        // don't use wurfl
        $dom = $this->m->scaleImages($dom, $serendipity, $this->get_config('scale_image_width'), S9Y_PEAR_PATH, $this->debugItems);
        $this->debugItems[] = 'Scaled all images';
      }
      // store useragent in session to check if it has changed since the last request
      $_SESSION['mobile_plugin']['ua'] = $_SERVER['HTTP_USER_AGENT'];
    }
    
    function assignCategories(&$serendipity) {
   		// add accesskey ids (1-9)
  	  $categories = serendipity_fetchCategories('all');
  	  $plugin_categories_data = array();
  	  $i = 1;
    	foreach($categories AS $k=>$v) {
    		$plugin_categories_data[] = array('access_key'=>$i++, 'category_name'=>$v['category_name'], 'categoryURL'=>serendipity_categoryURL($v, 'serendipityHTTPPath'));
      }
       $serendipity['smarty']->assign(array('categories'=>$plugin_categories_data));
    }
    
    function debug(&$serendipity) {
      if($_GET['mpDebug'] == $this->get_config('debug_password'))
        $_SESSION['mobile_plugin']['debug'] = 1;
      if($_GET['mpDebug'] == 'off')
        unset($_SESSION['mobile_plugin']['debug']);
      if( $_SESSION['mobile_plugin']['debug']==1) {
        $debug = '<div id="debug" style="border:5px solid #ff0000; padding: 5px; font-size: 10px">DEBUG:<ul>';
        foreach($this->debugItems AS $v)
          $debug .= '<li class="debug">'.$v.'</li>';
        $debug .= '</ul><a href="?mpDebug=off">Disable debugging</a></div>';
        $serendipity['smarty']->assign(array('debug'=>$debug));
      }
    }
    
    function introspect_config_item($name, &$propbag)
    {
      switch($name) {
      	case 'enable':
      		$propbag->add('type', 'boolean');
      		$propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_ENABLE_PLUGIN_NAME);
      		$propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_ENABLE_PLUGIN_DESC);
            $propbag->add('default',     'true');
      	break;
      	case 'mobile_template':
      		$propbag->add('type', 'string');
      		$propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_MOBILE_TEMPLATE_NAME);
      		$propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_MOBILE_TEMPLATE_DESC);
            $propbag->add('default', PLUGIN_EVENT_MOBILE_TPL_XHTML);
            $propbag->add('validate', '#^[0-9a-z\_\.\-]*$#i');
      	break;
      	case 'iphone_template':
      		$propbag->add('type', 'string');
      		$propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_IPHONE_TEMPLATE_NAME);
      		$propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_IPHONE_TEMPLATE_DESC);
            $propbag->add('default', PLUGIN_EVENT_MOBILE_TPL_IPHONE);
            $propbag->add('validate', '#^[0-9a-z\_\.\-]*$#i');
      	break;
        case 'android_template':
            $propbag->add('type', 'string');
            $propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_ANDROID_TEMPLATE_NAME);
            $propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_ANDROID_TEMPLATE_DESC);
            $propbag->add('default', PLUGIN_EVENT_MOBILE_TPL_ANDROID);
            $propbag->add('validate', '#^[0-9a-z\_\.\-]*$#i');
        break;
      	case 'images':
      		$propbag->add('type', 'boolean');
      		$propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_IMAGES_NAME);
      		$propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_IMAGES_DESC);
            $propbag->add('default',     'false');
      	break;
        case 'smallteaser':
            $propbag->add('type', 'boolean');
            $propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_SMALLTEASER_NAME);
            $propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_SMALLTEASER_DESC);
            $propbag->add('default',     'true');
        break;
      	case 'scale_image_width':
            $propbag->add('type', 'string');
      		$propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_SCALE_IMAGE_WIDTH_NAME);
      		$propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_SCALE_IMAGE_WIDTH_DESC);
            $propbag->add('default', '60');
            $propbag->add('validate', 'number');
      	break;
      	case 'redirect':
      		$propbag->add('type', 'boolean');
      		$propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_NAME);
      		$propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_DESC);
            $propbag->add('default',     'false');
      	break;
      	case 'redirect_url':
      		$propbag->add('type', 'string');
      		$propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_URL_NAME);
      		$propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_URL_DESC);
            $propbag->add('default', 'm.yourblog.com');
            $propbag->add('validate', '#^[0-9a-z\.\-_]*$#i');
      	break;
      	case 'sticky_host':
      		$propbag->add('type', 'string');
      		$propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_STICKY_HOST_NAME);
      		$propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_STICKY_HOST_DESC);
            $propbag->add('default', '');
            $propbag->add('validate', '#^[0-9a-z\.\-_]*$#i');
      	break;
      	case 'wurfl':
      		$propbag->add('type', 'boolean');
      		$propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_WURFL_NAME);
      		$propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_WURFL_DESC);
            $propbag->add('default',     'false');
      	break;
      	case 'categories':
      		$propbag->add('type', 'boolean');
      		$propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_CATEGORIES_NAME);
      		$propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_CATEGORIES_DESC);
            $propbag->add('default',     'true');
      	break;
      	case 'remove_tags':
      		$propbag->add('type', 'string');
      		$propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_TAGS_NAME);
      		$propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_TAGS_DESC);
            $propbag->add('default', 'script,object,embed,iframe');
            $propbag->add('validate', '#^[0-9a-z,]+$#i');
      	break;
      	case 'remove_attributes':
      		$propbag->add('type', 'string');
      		$propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_ATTRIBUTES_NAME);
      		$propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_ATTRIBUTES_DESC);
            $propbag->add('default', 'style,onload,onunload,onchange,onsubmit,onreset,onselect,onblur,onfocus,onkeydown,onkeypress,onkeyup,onclick,ondblclick,onmousedown,onmousemove,onmouseover,onmouseout,onmouseup');
            $propbag->add('validate', '#^[0-9a-z,]+$#i');
      	break;
      	case 'rewrite_wikipedia':
      		$propbag->add('type', 'boolean');
      		$propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_REWRITE_WIKIPEDIA_NAME);
      		$propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_REWRITE_WIKIPEDIA_DESC);
            $propbag->add('default',     'true');
      	break;
      	case 'sitemap':
      		$propbag->add('type', 'boolean');
      		$propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_NAME);
      		$propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_DESC);
            $propbag->add('default',     'false');
      	break;
        case 'sitemap_pingback':
            $propbag->add('type', 'boolean');
            $propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_NAME);
            $propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_DESC);
            $propbag->add('default', false);
        break;
        case 'sitemap_pingback_urls':
            $propbag->add('type', 'string');
            $propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_URL_NAME);
            $propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_URL_DESC);
            $propbag->add('default', 'http://www.google.com/webmasters/tools/ping?sitemap=%s');
        break;
        case 'gzip_sitemap':
            $propbag->add('type', 'boolean');
            $propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_GZIP_NAME);
            $propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_GZIP_DESC);
            $propbag->add('default', true);
        break;
      	case 'debug_password':
            $propbag->add('type', 'string');
      		$propbag->add('name', PLUGIN_EVENT_MOBILE_OUTPUT_DEBUG_PASSWORD_NAME);
      		$propbag->add('description', PLUGIN_EVENT_MOBILE_OUTPUT_DEBUG_PASSWORD_DESC);
            $propbag->add('default', 'password');
      	break;
      }
      return true;
    }
    
    ////////////////////////////////////////////////////////////////////
    // SITEMAP - Code ripped off the sitemap plugin by boris. Thanks!
    ////////////////////////////////////////////////////////////////////
    
    // function to add an entry to the xml-string $str
    function addtoxml(&$str, $url, $lastmod = null, $priority = null, $changefreq = null) {
        /* Sitemap requires this.
         * I think that s9y does not include these specialchars, so this is just a precaution */
        $url = htmlspecialchars($url, ENT_QUOTES);

        $str .= "\t<url>\n";
        $str .= "\t\t<loc>$url</loc>\n";
        if ($lastmod!=null) {
            $str_lastmod = gmstrftime('%Y-%m-%dT%H:%M:%SZ', $lastmod); // 'Z' does mean UTC in W3C Date/Time
            $str .= "\t\t<lastmod>$str_lastmod</lastmod>\n";
        }
        if ($priority!==null) {
            $str .= "\t\t<priority>".sprintf("%1.1f",$priority)."</priority>\n";
        }
        if ($changefreq!=null) {
            $str .= "\t\t<changefreq>$changefreq</changefreq>\n";
        }
        $str .= "\t</url>\n";
    }

    function send_ping($loc) {
        global $serendipity;
        require_once (defined('S9Y_PEAR_PATH') ? S9Y_PEAR_PATH : S9Y_INCLUDE_PATH . 'bundled-libs/') . 'HTTP/Request.php';
        $req = new HTTP_Request($loc);

        if (PEAR::isError($req->sendRequest()) || $req->getResponseCode() != '200') {
            print_r($req);
            return false;
        } else {
            return true;
        }
    }
    
    function generateSitemap(&$bag) {
      global $serendipity;
                    
      // decide which NULL-function to use
      switch($serendipity['dbType']) {
        case 'postgres':
          $sqlnullfunction = 'COALESCE';
        break;
        case 'sqlite':
        case 'mysql':
        case 'mysqli':
          $sqlnullfunction = 'IFNULL';
        break;
        default:
          $sqlnullfunction='';
      }

      $hooks = &$bag->get('event_hooks');
      $do_pingback = serendipity_db_bool($this->get_config('sitemap_pingback', false));
      $pingback_url = $this->get_config('sitemap_pingback_urls', false);

      // start the xml
      $sitemap_xml  = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
      $sitemap_xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"\n";
      $sitemap_xml .= "\txmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n";
      $sitemap_xml .= "\txsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9\n";
      $sitemap_xml .= "\t\t\thttp://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
      // add link to the main page
      $this->addtoxml($sitemap_xml, $serendipity['baseURL'], time(), 0.6);

      // fetch all entries from the db (tested with: mysql, sqlite, postgres)
      $entries = serendipity_db_query(
                           'SELECT
                                entries.id AS id,
                                entries.title AS title,
                                '.$sqlnullfunction.'(entries.last_modified,0) AS timestamp_1,
                                '.$sqlnullfunction.'(MAX(comments.timestamp),0) AS timestamp_2
                            FROM '.$serendipity['dbPrefix'].'entries entries
                            LEFT JOIN '.$serendipity['dbPrefix'].'comments comments
                            ON entries.id = comments.entry_id
                            WHERE entries.isdraft = \'false\'
                            GROUP BY entries.id, entries.title, entries.last_modified
                            ORDER BY entries.id',
                        false, 'assoc');


                        
      if(is_array($entries)) {
        // add entries
        foreach($entries as $entry) {
          $max = max($entry['timestamp_1']+0, $entry['timestamp_2']+0);
          $url = serendipity_archiveURL($entry['id'], $entry['title']);
          $this->addtoxml($sitemap_xml, $url, $max, 0.7);
        }
      }

      // add possible perm links
      $permlink = serendipity_db_query(
                            'SELECT entryid, timestamp, value
                             FROM '.$serendipity['dbPrefix'].'entryproperties AS entryproperties,
                                  '.$serendipity['dbPrefix'].'entries AS entries
                             WHERE entryproperties.property = \'permalink\'
                                   AND entries.id=entryproperties.entryid',
                        false, 'assoc');

      if(is_array($permlink)) {
        foreach($permlink as $cur) {
          $path_quoted = preg_quote($serendipity['serendipityHTTPPath'], '#');
          $url = $serendipity['baseURL'] . preg_replace("#$path_quoted#", '', $cur['value'],1);
          $cur_time = ($cur['timestamp']==0)? null : (int)$cur['timestamp'];
          $this->addtoxml($sitemap_xml, $url, $cur_time, 0.8);
        }

        // check for the right order of plugins
        $order = serendipity_db_query(
                            'SELECT name, sort_order
                             FROM '.$serendipity['dbPrefix'].'plugins plugins
                             WHERE plugins.name LIKE \'%serendipity_event_mobile_output%\'
                                OR plugins.name LIKE \'%serendipity_event_custom_permalinks%\'
                             ORDER BY plugins.sort_order',
                        false, 'assoc');
                        
        if(is_array($order)) {
          if( strpos($order[0]['name'], 'serendipity_event_custom_permalinks')===FALSE) {
            echo '<br/>'.PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_PERMALINK_WARNING.'<br/>';
          }
        }
      }


      // fetch categories and their last entry date (tested with: mysql, sqlite, postgres)
      $q = 'SELECT
                                category.categoryid AS id,
                                category_name,
                                category_description,
                                MAX(entries.last_modified) AS last_mod
                            FROM
                                '.$serendipity['dbPrefix'].'category category,
                                '.$serendipity['dbPrefix'].'entrycat entrycat,
                                '.$serendipity['dbPrefix'].'entries entries
                            WHERE
                                category.categoryid = entrycat.categoryid
                                AND
                                entrycat.entryid = entries.id
                            GROUP BY
                                category.categoryid,
                                category.category_name,
                                category.category_description
                            ORDER BY category.categoryid';
      $categories = serendipity_db_query($q, false, 'assoc');

      // add categories
      if(is_array($categories)) {
        foreach($categories as $category) {
          $max = 0+$category['last_mod'];
          /* v0.9 */
          if(version_compare((float)$serendipity['version'], '0.9', '>=')) {
            $data = array(
                          'categoryid' => $category['id'],
                          'category_name' => $category['category_name'],
                          'category_description' => $category['category_description']);
            $url = serendipity_categoryURL($data);
          } else {
            $url = serendipity_rewriteURL(PATH_CATEGORIES . '/' . serendipity_makePermalink(PERM_CATEGORIES, array('id' => $category['id'], 'title' => $category['category_name'])));
          }
          $this->addtoxml($sitemap_xml, $url, $max, 0.4);
        }
      } else {
        $categories = array();
      }

      // finish the xml
      $sitemap_xml .= "</urlset>\n";

      $do_gzip = serendipity_db_bool($this->get_config('gzip_sitemap', true));

      // decide whether to use gzip-output or not
      if($do_gzip && function_exists('gzencode')) {
        $filename = '/mobile_sitemap.xml.gz';
        $temp = gzencode($sitemap_xml);

        // only use the compressed data and filename if no error occured
        if( !($temp === FALSE) ) {
          $sitemap_xml = $temp;
        } else {
          $filename = '/mobile_sitemap.xml';
        }
      } else {
        $filename = '/mobile_sitemap.xml';
      }

      // write result to file
      $outfile = fopen($serendipity['serendipityPath'] . $filename, 'w');
      if($outfile === false) {
        echo '<strong>'.PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_FAILEDOPEN.'</strong>';
        return false;
      }
      flock($outfile, LOCK_EX);
      fputs($outfile, $sitemap_xml);
      flock($outfile, LOCK_UN);
      fclose($outfile);

      // Walk through the list of pingback-URLs
      foreach(explode(';', $pingback_url) as $cur_pingback_url) {
        $pingback_name = PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_UNKNOWN_HOST;
        $cur_url = sprintf($cur_pingback_url, rawurlencode($serendipity['baseURL'].$filename));

        // extract domain-portion from URL
        if(preg_match('@^https?://([^/]+)@', $cur_pingback_url, $matches)>0) {
          $pingback_name = $matches[1];
        }

        if(!serendipity_db_bool($eventData['isdraft']) && $do_pingback && $cur_url) {
          $answer = $this->send_ping($cur_url);
          if($answer) {
            printf(PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_OK, $pingback_name);
          } else {
            printf(PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_ERROR, $pingback_name, $cur_url);
          }
        } else {
          printf(PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_MANUAL, $pingback_name, $cur_url);
        }
      }
      return true;
    }

    function recurse_dircopy($src,$dst) {
        $dir = opendir($src);
        if (!file_exists($dst)) {
            if (!@mkdir($dst)) return false; // Creating dir failed!
        }
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurse_dircopy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
        return true;
    }     
};

