<?php
// This file scales images on the fly for mobile output
// requires GD (http://php.net/gd)
// by Pelle Boese (http://seo-mobile.de/) 2007

$img = basename(base64_decode($_GET['i']));

// add download folder for external images
if($_GET['e']==1)
  $img = 'plugin_mobile_output/' . $img;
  
$size = explode('|', base64_decode($_GET['s']));

$source = dirname(__FILE__).'/../../uploads/'.$img;

switch($size[4]) {
	case 'image/jpeg': $type = 'jpg'; $s = imagecreatefromjpeg($source) or die('Couldn\'t create image'); break;
	case 'image/pjpeg': $type = 'jpg'; $s = imagecreatefromjpeg($source) or die('Couldn\'t create image');  break;
	case 'image/gif': $type = 'gif'; $s = imagecreatefromgif($source) or die('Couldn\'t create image');  break;
	case 'image/png': $type = 'png'; $s = imagecreatefrompng($source) or die('Couldn\'t create image');  break;
	default: die('Image type not supported'); break;
}

$i = imagecreatetruecolor($size[2], $size[3]);

imagecopyresized($i, $s, 0, 0, 0, 0, $size[2], $size[3], $size[0], $size[1]);

header('Content-Type: image/'.$type);

switch($type) {
	case 'jpg': imagejpeg($i); break;
	case 'gif': imagegif($i); break;
	case 'png': imagepng($i); break;
}