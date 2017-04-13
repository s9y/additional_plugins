<?php
// subtract -N to accomidate lag hitting server if your is slow, where N is a measure of slowness
$filetime = time();

// grab out associate id and dev key from the plugin
global $motm_server_temp;
$associate_id = $motm_server_temp['amazon_assoc'];
$dev_key = $motm_server_temp['amazon_dev'];

$music['track'] = $_REQUEST['track'];
$music['artist'] = $_REQUEST['artist'];
$music['album'] = $_REQUEST['album'];
$music['genre'] = $_REQUEST['genre'];
$music['tracktime'] = $_REQUEST['tracktime'];

$song = $music['track'];
$artist = $music['artist'];
$album = $music['album'];
$genre = $music['genre'];
$tracktime = $music['tracktime'];

// weird bug where the song's special characters are converted into escape codes, wtf?
function htmldecode($encoded) {
   return strtr($encoded,array_flip(get_html_translation_table(HTML_ENTITIES)));
}
$song = urldecode($song);

if ($tracktime && $tracktime != "")
{
	$times = explode(":", $tracktime);
	if (count($times) == 3)
		$seconds = $times[0] * 3600 + $times[1] * 60 + $times[2];
	else
		$seconds = $times[0] * 60 + $times[1];
}

$artist = $artist = str_replace("\'","&#039;",$artist);
$song = $song = str_replace("\'","&#039;",$song);
$album = $album = str_replace("\'","&#039;",$album);

// make friendly
$artist_pre = $artist;
$artist_pre = str_replace(" ","+",$artist_pre);

$song_pre = $song;
$song_pre = str_replace(" ","+",$song_pre);

$artist_url = "http://www.audioscrobbler.com/music/$artist_pre";
$song_url = "$artist_url/_/$song_pre";

if ($genre == "Soundtrack")
	$term = $album;
else
	$term = "$artist $album";

// don't search on streams (which have no album or artist in iTunes)
if ($album || $artist)
{
	require_once(dirname(__FILE__) . '/amazon/amazonsearch.php');
	$res = amazon_search($term,$associate_id,$dev_key);
	// if no result on $album and $artist, then just search for $album (if not sound track, as we just searched for $album)
	if (!$res && $genre != "Soundtrack")
		$res = amazon_search($album,$associate_id,$dev_key);
	// if still no results, then just search for $artist, don't care if soundtrack, we need to find anything!
	if (!$res)
		$res = amazon_search($artist,$associate_id,$dev_key);
	
	// if we found something
	if ($res)
	{
		$amazon_image = $res->ImageUrlSmall;
		$amazon_url = $res->url;
		$image_size = hasImage($amazon_image);
		if (!$image_size)
			$amazon_image = NULL;
	}
	else
	{
		$amazon_image = NULL;
		$amazon_url = NULL;
	}
}

$amazon_url = str_replace("amazon.com","amazon.ca",$amazon_url);
$output['track'] 		= $song;
$output['artist'] 		= $artist;
$output['album'] 		= $album;
$output['genre'] 		= $genre;

$output['filetime'] 	= $filetime;
$output['tracktime'] 	= $tracktime;
$output['seconds'] 		= $seconds;

$output['amazon_image']	= $amazon_image;
$output['image_size']	= $image_size;
$output['amazon_url'] 	= $amazon_url;
$output['artist_url'] 	= $artist_url;
$output['song_url'] 	= $song_url;

$content = serialize($output);

echo $content;

function domxml_xmlarray($branch) {
   $object = array();
   $objptr = &$object;
   $branch = $branch->first_child();

   while ($branch) {
	   if (!($branch->is_blank_node())) {
		   switch ($branch->node_type()) {
			   case XML_TEXT_NODE: {
				   $objptr['cdata'] = $branch->node_value();

				   break;
			   }
			   case XML_ELEMENT_NODE: {
				   $objptr = &$object[$branch->node_name()][];

				   break;
			   }
		   }

		   if ($branch->has_child_nodes()) {
			   $objptr = array_merge($objptr, domxml_xmlarray($branch));
		   }
	   }

	   $branch = $branch->next_sibling();
   }

   return $object;
}


function node_content($node,$attribute="content")
{
	if (!$node)
		return;
	foreach($node->nodeset as $content)
	{
			$return[]    =    $content->{$attribute};
	}
	return $return;
}

function parse_Amazon_XML($xml)
{
	$dom    =domxml_open_file($xml);
	$calcX = &$dom->xpath_new_context();
	$xml_parsed["image"] = node_content($calcX->xpath_eval("//ProductInfo/Details/ImageUrlSmall/text()"));
	//$xml_parsed["image"] = node_content($calcX->xpath_eval("//ProductInfo/Details/ImageUrlMedium/text()"));
	$xml_parsed["url"]=node_content($calcX->xpath_eval("//ProductInfo/Details/attribute::url",$calcX),"value");
	return $xml_parsed;
}
function hasImage($URL_in) {
	$image = getimagesize($URL_in);
	if ($image[1] == 1)
		return false;
	else if ($image[1] > 60)
		return 60;
	else
		return $image[1];
}
?>
