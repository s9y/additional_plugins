<?php # $Id$
// ClickableURL preg replace markup
// turns urls into clickable links
//
$regexpArray = array(
    'SearchArray'=>array(
		"/([^]_a-z0-9-=\"'\/>])((https?|ftp|gopher|news|telnet):\/\/)([^ \r\n\(\)\^\$!`\"'\|\[\]\{\}<>]*)/si", 
		"/^((https?|ftp|gopher|news|telnet):\/\/)([^ \r\n\(\)\^\$!`\"'\|\[\]\{\}<>]*)/si",

		"/([^]_a-z0-9-=\"'\/>])((www\.))([^ \r\n\(\)\^\$!`\"'\|\[\]\{\}<>]*)/si", 
		"/^((www\.))([^ \r\n\(\)\^\$!`\"'\|\[\]\{\}<>]*)/si"
    ),
    'ReplaceArray'=>array(
		'\\1<a href="\\2\\4" target="_blank">\\2\\4</a>', 
		'<a href="\\1\\3" target="_blank">\\1\\3</a>', 

		'\\1<a href="http://\\2\\4" target="_blank">\\2\\4</a>', 
		'<a href="http://\\1\\3" target="_blank">\\1\\3</a>' 
    )
); 
?>
