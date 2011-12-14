<?
require_once(dirname(__FILE__) . '/../' . "config.php");

function testYoutubeProvider() {
	$x = new YouTubeProvider('');
	$obj = $x->provide("","object");
	//print_r($obj);
	print_r($obj->html);
}

testYoutubeProvider();

