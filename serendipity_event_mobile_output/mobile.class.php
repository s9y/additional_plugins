<?php
// by Pelle Boese (http://seo-mobile.de/) 2007
// requires PEAR::HTTP_Request (comes with serendipity)

class serendipity_mobile 
{
  private static $instance = NULL;
  
  var $isMobileDevice = false;
  var $isIPhone = false;
  var $isAndroid = false;
    
  private function __construct(&$debug) {
  		// detect mobile code by Andy Moore (http://www.andymoore.info/)
      $mobile_browser = '0';
      $user_agent_tolower = strtolower($_SERVER['HTTP_USER_AGENT']);
      if(preg_match('/(up.browser|up.link|windows ce|iemobile|mmp|symbian|smartphone|midp|wap|phone|vodafone|o2|pocket|mobile|pda|psp)/i',$user_agent_tolower)){
       $mobile_browser++;
      }
      if(((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'text/vnd.wap.wml')>0) or (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0)) or ((((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']) or isset($_SERVER['X-OperaMini-Features']) or isset($_SERVER['UA-pixels'])))))){
       $mobile_browser++;
      }

      $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
      $mobile_agents = array('acs-','alav','alca','amoi','audi','aste','avan','benq','bird','blac','blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno','ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-','maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-','newt','noki','opwv','palm','pana','pant','pdxg','phil','play','pluc','port','prox','qtek','qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar','sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-','tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp','wapr','webc','winw','winw','xda','xda-');

      if(in_array($mobile_ua,$mobile_agents)){
       $mobile_browser++;
      }
      
      $debug[] = 'Mobile device check returned '.$mobile_browser.' out of 3';
       
      if($mobile_browser>0) {
        $this->isMobileDevice = true;
      }
      
      if(strpos($user_agent_tolower,'iphone') !== false) {
        $this->isIPhone = true;
      }
      if(strpos($user_agent_tolower,'android') !== false) {
        $this->isAndroid = true;
      }
		          
      return true;
  }
  
  public static function getInstance(&$debug) {
    if(self::$instance === NULL)
    {
      self::$instance = new serendipity_mobile($debug);
    }
    return self::$instance;    
  }
  
  private function __clone() {}
  
  function parseHTML($html, $encoding, $remove_tags, $remove_attributes, &$debug) {
  	$dom = new DOMDocument;

  	// add html meta-data to entry to fix encoding issues
  	$html = '<html><head><meta http-equiv="Content-Type" content="text/html; charset='.$encoding.'"/></head><body>'.$html.'</body></html>';
  	$debug[] = 'Added HTML META data with correct charset to entry string';

  	// load HTML into DOM a object 
  	if($dom->loadHTML($html))
  		$debug[] = 'DOM successfully parsed';
  	else
  		$debug[] = 'Couldn\'t parse DOM';
  	
  	// remove comments as they only consume bandwidth
  	$xpath = new DOMXPath($dom);
  	foreach($xpath->query('//comment()') as $comment) {
  		$comment->parentNode->removeChild($comment);
  	}
  	// remove other unwanted tags
  	$remove = explode(',', $remove_tags);
  	foreach($remove as $v) {
  		foreach($xpath->query('//'.$v) as $crap) {
  			$crap->parentNode->removeChild($crap);
  		}
  		$debug[] = 'All '.strtoupper($v).' tags removed';
  	}

  	// remove unwanted attributes
  	$remove = explode(',', $remove_attributes);
  	foreach($remove as $v) {
  		foreach($xpath->query('//node()[@'.$v.']') as $crap) {
  			$crap->removeAttribute($v);
  		}
  		$debug[] = 'All '.strtoupper($v).' attributes removed';
  	}

  	return $dom;
  }

  function rewriteWikipediaLinks(&$dom, &$debug) {
    // rewrite wikipedia.org links to the mobile version at wikipedia.7val.com
    $xpath = new DOMXPath($dom);
    foreach($xpath->query("//a[contains(@href,'wikipedia.org')]") as $node) {
      $src = $node->getAttribute('href');
      if(preg_match("#http://([a-z]{2})\.wikipedia\.org/(.+)#i", $src, $o)) {
        $newSrc = 'http://'.$o[1].'.wikipedia.7val.com/'.$o[2];
        $node->setAttribute('href', $newSrc);  
        $debug[] = 'Changed Wikipedia link '.$src.' to '.$newSrc;
      }
    }
  }
  
  function removeImages(&$dom, &$debug) {
  	$xpath = new DOMXPath($dom);

  	foreach($xpath->query('//img') as $img) {
  		$debug[] = 'Removing IMG: '.$img->getAttribute('src');
  		// save parent
  		$parent = $img->parentNode;
  		// remove image
  		$img->parentNode->removeChild($img);
  		// remove parent node if it has no children anymore 
  		// might be replaced by a recursive function call in later versions
  		if(!$parent->hasChildNodes()) {
  			$debug[] = 'Removing empty parent: '.$parent->nodeName;
  			$parent->parentNode->removeChild($parent);
  	  }
  	}
  	
  	return($dom);
  }
  
  function removeImagesDimensions(&$dom, &$debug) {
    $xpath = new DOMXPath($dom);

    foreach($xpath->query('//img') as $img) {
        $debug[] = 'Removing IMG Dimension: '.$img->getAttribute('src');
        // save parent
        $img->removeAttribute("width");
        $img->removeAttribute("height");
    }
    
    return($dom);
  }
  
  function scaleImages(&$dom, &$serendipity, $width, $pearPath, &$debug) {
    // external script which scales images on the fly
  	$imageScriptURL = $serendipity['baseURL'].'plugins/serendipity_event_mobile_output/i.php';
  	
    // we store external images here
    $uploadDir = $serendipity['serendipityPath'] . $serendipity['uploadPath'] . 'plugin_mobile_output/';

    $xpath = new DOMXPath($dom);

  	foreach($xpath->query('//img') as $img) {
  		$imgSrc = $img->getAttribute('src');

	    // get local image
      if(substr($imgSrc,0,1)=='/') {
	      $docRoot = $_SERVER['DOCUMENT_ROOT'];
	      $imgFile = $docRoot.$imgSrc;
	      $externalImage = false;
      }

      // get external image
      if(preg_match("#^(https?://|ftp://)#i",$imgSrc)) {
  	    require_once($pearPath . 'HTTP/Request.php');
  	    $imgFile = $uploadDir . base64_encode($imgSrc);
  	    // if we didn't download the external image yet, fetch it
  	    if(!file_exists($imgFile)) {
  	      $this->fetchImage($imgSrc, $imgFile);
  	      $debug[] = 'Downloading external image '.$imgSrc;
  	    } else {
  	      $debug[] = 'External image '.$imgSrc.' already downloaded. Using local version';
  	    }
  	    $externalImage = true;
      }

      if(!file_exists($imgFile) || !$size = getimagesize($imgFile)) {
        // not an image? remove it!
     		$parent = $img->parentNode;
   			$img->parentNode->removeChild($img);
   		  $debug[] = 'Error scaling IMG: '.$imgSrc.' - removing node from DOM';
    		if(!$parent->hasChildNodes()) {
    			$debug[] = 'Removing empty parent: '.$parent->nodeName;
  	 		  $parent->parentNode->removeChild($parent);
  	    }
      } else {
    		$height = round($size[1] / ($size[0]/$width));

  	 	  // to be fixed: remove style, fix width and height
  		  $img->removeAttribute('style');
  		
  		  if($size[0] > $width) {
    		  $img->setAttribute('width',$width);
    		  $img->setAttribute('height',$height);
    		  // add alt tag if it's not existant
    		  if(!$img->getAttribute('alt'))
    		    $img->setAttribute('alt','');
    		  // rewrite image src to i.php
    		  $imgUrl = $imageScriptURL.'?i='.base64_encode(basename($imgFile)).'&s='.base64_encode($size[0].'|'.$size[1].'|'.$width.'|'.$height.'|'.$size['mime']);
    		  // if we fetched an external image, tell the script to use the seperate folder
    		  if($externalImage)
    		    $imgUrl .= '&e=1';
    		  $img->setAttribute('src', $imgUrl);
    		  $debug[] = 'Scaling IMG: '.$imgSrc.' to '.$width.'px width and '.$height.'px height';
  		  } else {
    		  $img->setAttribute('width',$size[0]);
    		  $img->setAttribute('height',$size[1]);
    		  $debug[] = 'Not scaling IMG: '.$imgSrc.' as it is small enough';
  		  }
      }
  	}
  	
  	return $dom;
  }
  
  function cleanUp(&$dom, $encoding, &$debug) {
    $debug[] = 'Cleaning up DOM';
    $xpath = new DOMXPath($dom);

    // copy all child nodes of body in our entry DOM
 		foreach($xpath->query('/html/body/node()') as $node) {
 		    $body .= $dom->saveXML($node);
		}
		
		$body = iconv('UTF-8', $encoding, $body);
 		$debug[] = 'Content successfully prepared';
 		return $body;
  }

  // fetch a file using PEAR::HTTP_Request
  function fetchImage($url, $target) {
    $options = array('timeout'=>3.0, 'readTimeout'=>3.0);

    $req = new HTTP_Request($url, $options);

    if(PEAR::isError($req->sendRequest()) || $req->getResponseCode() != '200') {
    	return false;
    }
  
    if(file_exists($target) && filesize($target) > 0) {
      $data = file_get_contents($target);
    } else {
      // Fetch file
      $data = $req->getResponseBody();
      $tdir = dirname($target);
      if(!is_dir($tdir)) {
    	  return false;
      }
               
      $fp = @fopen($target, 'w');

      if(!$fp) {
    	  return false;
      }

      fwrite($fp, $data);
      fclose($fp);
    
      return true;
    }
  }
};
