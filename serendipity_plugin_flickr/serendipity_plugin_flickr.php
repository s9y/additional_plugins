<?php

if (IN_serendipity !== true) {
	die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
	include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';
include dirname(__FILE__) . '/phpFlickr/phpFlickr.php';

class serendipity_plugin_flickr extends serendipity_plugin {

	function introspect(&$propbag)
	{
		global $serendipity;

		$propbag->add('name', PLUGIN_SIDEBAR_FLICKR);
		$propbag->add('description', PLUGIN_SIDEBAR_FLICKR_DESC);
        $propbag->add('stackable',   true);
        $propbag->add('author',      'Michael Kaiser');
		$propbag->add('requirements',  array(
			'serendipity' => '0.8',
			'smarty'	  => '2.6.9',
			'php'		 => '4.3.0'
		));
		$propbag->add('version',  '1.07');
		$propbag->add('configuration', array(
						 'title',
						 'email',
						 'sourceimgtype',
						 'showdate',
						 'showtitle',
						 'lightbox',
						 'targetimgtype',
						 'targetlink',
						 'perpage',
		    				 'numberOfChoices',			//added 110730 by artodeto
		    				 'useChoices',			//added 110730 by artodeto
						 'showrss',
						 'showphotostream',
						 'apikey',
						 'apisecret',
						 'cachetimeout'
						 )
			  );
		$propbag->add('event_hooks',   array('frontend_display' => true, 'frontend_comment' => true, 'css' => true));
		$propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES', 'IMAGES'));
		
		$this->dependencies = array('serendipity_event_flickrcss' => 'remove');
		
	} // function
	


	function introspect_config_item($name, &$propbag)
	{
		switch ($name) {

		case 'title':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_SIDEBAR_FLICKR_TITLE_TITLE);
			$propbag->add('description', PLUGIN_SIDEBAR_FLICKR_TITLE_BLAHBLAH);
			break;

		case 'email':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_SIDEBAR_FLICKR_USER_TITLE);
			$propbag->add('description', PLUGIN_SIDEBAR_FLICKR_USER_TITLE_BLAHBLAH);
			break;

		case 'cachetimeout':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_SIDEBAR_FLICKR_CACHE_TITLE);
			$propbag->add('description', PLUGIN_SIDEBAR_FLICKR_CACHE_DESC);
			$propbag->add('default', 3600);
			break;

		case 'sourceimgtype':
			$propbag->add('type', 'select');
			$propbag->add('name', PLUGIN_SIDEBAR_FLICKR_SRCIMG_TITLE);
			$propbag->add('select_values',
				array(
					'0' => PLUGIN_SIDEBAR_FLICKR_IMG_SQUARE,
					'1' => PLUGIN_SIDEBAR_FLICKR_IMG_THUMBNAIL,
					'2' => PLUGIN_SIDEBAR_FLICKR_IMG_SMALL
				)
			);
			$propbag->add('default', '0');
			break;

		case 'targetimgtype':
			$propbag->add('type', 'select');
			$propbag->add('name', PLUGIN_SIDEBAR_FLICKR_TGTIMG_TITLE);
			$propbag->add('select_values',
				array(
					'2' => PLUGIN_SIDEBAR_FLICKR_IMG_SMALL,
					'3'  => PLUGIN_SIDEBAR_FLICKR_IMG_MEDIUM,
					'4'  => PLUGIN_SIDEBAR_FLICKR_IMG_LARGE,
					'5'  => PLUGIN_SIDEBAR_FLICKR_IMG_ORIGINAL
				)
			);
			$propbag->add('default', 4);
			break;
			
		case 'targetlink':
			$propbag->add('type', 'select');
			$propbag->add('name', PLUGIN_SIDEBAR_FLICKR_TGTLINK_TITLE);
			$propbag->add('select_values',
				array(
					'JPG' => PLUGIN_SIDEBAR_FLICKR_TGTLINK_JPG,
					'Flickr'  => PLUGIN_SIDEBAR_FLICKR_TGTLINK_FLICKR
				)
			);
			$propbag->add('default', Flickr);
			break;

		case 'perpage':
			$propbag->add('type', 'string');
			$propbag->add('default', 4);
			$propbag->add('name', PLUGIN_SIDEBAR_FLICKR_NUM_TITLE);
			$propbag->add('description', PLUGIN_SIDEBAR_FLICKR_NUM_BLAHBLAH);
			break;

		case 'lightbox':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_SIDEBAR_FLICKR_LIGHTBOX_TITLE);
			$propbag->add('description', PLUGIN_SIDEBAR_FLICKR_LIGHTBOX_BLAHBLAH);
			$propbag->add('default', 'lightbox[lightbox_group_entry_flickr]');
			break;

		case 'apikey':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_SIDEBAR_FLICKR_APIKEY_TITLE);
			$propbag->add('description', PLUGIN_SIDEBAR_FLICKR_APIKEY_BLAHBLAH);
			break;

		case 'apisecret':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_SIDEBAR_FLICKR_APISECRET_TITLE);
			$propbag->add('description', PLUGIN_SIDEBAR_FLICKR_APISECRET_DESC);
			break;
			
		case 'showdate':
			$propbag->add('type', 'boolean');
			$propbag->add('name', PLUGIN_SIDEBAR_FLICKR_SHOWDATE);
			$propbag->add('default','true');
			break;
			
		case 'showtitle':
			$propbag->add('type', 'boolean');
			$propbag->add('name', PLUGIN_SIDEBAR_FLICKR_SHOWTITLE);
			$propbag->add('default','false');
			break;

		case 'showrss':
			$propbag->add('type', 'boolean');
			$propbag->add('name', PLUGIN_SIDEBAR_FLICKR_SHOWRSS);
			$propbag->add('default','false');
			break;

		case 'showphotostream':
			$propbag->add('type', 'boolean');
			$propbag->add('name', PLUGIN_SIDEBAR_FLICKR_SHOWPHOTOSTREAM);
			$propbag->add('default','false');
			break;
		case 'numberOfChoices':						//added 110730 by artodeto
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_SIDEBAR_FLICKR_NUMBEROFCHOICES);
			$propbag->add('default', 4);
			break;
		case 'useChoices':
			$propbag->add('type', 'boolean');
			$propbag->add('name', PLUGIN_SIDEBAR_FLICKR_USECHOICES);
			$propbag->add('default', 'false');
			break;
		default:
			return false;
		} // switch

	return true;
	} // function

	function generate_content(&$title)
	{
		global $serendipity;

		$title = $this->get_config('title');
		$username = $this->get_config('email');
		$num = $this->get_config('perpage');
		$choices = $this->get_config('numberOfChoices');				//added 110730 by artodeto
		$useChoices = $this->get_config('useChoices');				//added 110730 by artodeto
		$apiKey = $this->get_config('apikey');
		$apiSecret = $this->get_config('apisecret');
		$sourceimgtype = $this->get_config('sourceimgtype');
		$targetimgtype = $this->get_config('targetimgtype');
		$errors=array();
		
/* 		Get image data from flickr */
		
		$f = new phpFlickr($apiKey,$apiSecret);
		
		$f->enableCache("fs", $serendipity['serendipityPath'].'templates_c/', $this->get_config('cachetimeout'));
		
		if (stristr($username,'@')) {
			$nsid = $f->people_findByEmail($username);
			}
		else {
			$nsid = $f->people_findByUsername($username);
		}
		if ($nsid===false) { $errors[]=PLUGIN_SIDEBAR_FLICKR_ERROR_WRONGUSER; } /* Can't find user */
		$photos_url = $f->urls_getUserPhotos($nsid['nsid']);
		if($useChoices === true) {
			$photos = $f->photos_search(array("user_id" => $nsid['nsid'], "per_page" => $choices, "sort" => "date-posted-desc", "extras" => "date_taken"));
		} else {
			$photos = $f->photos_search(array("user_id" => $nsid['nsid'], "per_page" => $num, "sort" => "date-posted-desc", "extras" => "date_taken"));
		}

		if($photos[total] > 0 && $f) {
			$sizelist = array("0"=>"Square", "1"=>"Thumbnail", "2"=>"Small", "3"=>"Medium", "4"=>"Large", "5"=>"Original");
			if($useChoices === true) {					//added 110730 by artodeto
				shuffle($photos['photo']);
				array_splice($photos['photo'], $num);
			}
			foreach($photos['photo'] as $photo) {
				if ($photo['ispublic'] !== 1) continue;
				$imgdate=strftime("%d.%m.%y %H:%M",strtotime($photo['datetaken']));
				$imgtitle=$photo['title'];
				
/* 				Choose available image size */
				$sizes_available = $f->photos_getSizes($photo[id]);
				
				$photosize = $sourceimgtype;
				$imgsrcdata = NULL;
				while ($imgsrcdata == NULL && $photosize >= 0){
					$imgsrcdata = getsizedata($sizes_available,$sizelist[$photosize]);
					$photosize--;
				}
				/* If updating from previous versions, $targetimgtype could be -1. So we set it to the next legal value 2. */
				$photosize = max($targetimgtype,2);
				$imgtrgdata = NULL;
				while ($imgtrgdata == NULL && $photosize >= 0){
					$imgtrgdata = getsizedata($sizes_available,$sizelist[$photosize]);
					$photosize--;
				}

				$img_width = $imgsrcdata['width'];
				$img_height = $imgsrcdata['height'];
				$img_url = $imgsrcdata['source'];
				
				if ( $this->get_config('targetlink')=="JPG" )
					$link_url = $imgtrgdata['source'];
				else 
					$link_url = $imgtrgdata['url'];
				
				if ($this->get_config('showdate') || $this->get_config('showtitle')) {
				
					unset($info);

					if ($this->get_config('showdate')) {
						$info .= '<span class="serendipity_plugin_flickr_date">'.$imgdate.'</span>';
						}
					if ($this->get_config('showtitle')) {
						$info .= '<span class="serendipity_plugin_flickr_title">'.$imgtitle.'</span>';
						}

					if ($this->get_config('lightbox')!='') {
						$lightbox = 'rel="'.$this->get_config('lightbox').'" ';
						}

					$images .= sprintf(
					'<dd style="width:%spx;"><a %shref="%s" ><img src="%s" width="%s" height="%s" title="%s" alt="%s"/></a></dd><dt style="width:%spx;margin-left:-%spx;">%s</dt>' . "\n",
						$img_width,
						$lightbox,
						$link_url,
						$img_url,
						$img_width,$img_height,
						$photo[title],
						$photo[title],
						$img_width,
						$img_width+5,
						$info
					);
				}
				else {
					$images .= sprintf(
					'<dd style="width:%spx;"><a href="%s"><img src="%s" width="%s" height="%s" alt="%s"/></a></dd>' . "\n",
						$img_width,
						$link_url,
						$img_url,
						$img_width,$img_height,
						$photo[title]
					);
		  		}
		  		$i++;
			}
		}
		else {
			$errors[]=PLUGIN_SIDEBAR_FLICKR_ERROR_NOIMG; /* No images available */
		}
		$content = '<dl class="serendipity_plugin_flickr">' . "\n";
			
		$content .= "\n".$images;
		$content .= '</dl>';
		
		$footer=array();
		if ($this->get_config('showrss')) {
			$rssicon  = serendipity_getTemplateFile('img/xml.gif');
			$footer[]='<a class="serendipity_xml_icon" href="http://api.flickr.com/services/feeds/photos_public.gne?id='.$nsid['nsid'].'&amp;format=rss_200"><img src="'.$rssicon.'" alt="XML" style="border: 0px" /></a>'."\n".'<a href="http://api.flickr.com/services/feeds/photos_public.gne?id='.$nsid['nsid'].'&amp;format=rss_200">'.PLUGIN_SIDEBAR_FLICKR_LINK_SHOWRSS.'</a>';
		}
		if ($this->get_config('showphotostream')) {
			$footer[]='<a href="http://www.flickr.com/photos/'.$username.'/">'.PLUGIN_SIDEBAR_FLICKR_LINK_PHOTOSTREAM.'</a>';
		}
		
		if (count($footer)>0) {
			$content .= '<p class="serendipity_plugin_flickr_links">';
			$content .= join("<br />\n",$footer)."\n";
			$content .= '</p>';
		}

		if (count($errors)>0) {
			$content .= '<p class="serendipity_plugin_flickr_errors">';
			$content .= join("<br />\n",$errors)."\n";
			$content .= '</p>';
		}
		
		echo $content;
	}
	


} // class

	function getsizedata($sizes_available,$size)
	{
		for($i=0;$i<count($sizes_available);$i++) { 
			if ($sizes_available[$i]['label'] == $size) {
				return $sizes_available[$i];
			}
		}
		return NULL;
	}
?>