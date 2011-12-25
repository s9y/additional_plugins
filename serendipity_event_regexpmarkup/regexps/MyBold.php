<?php # $Id$
// MyBold preg replace markup
// turns [mybold]xxx[/mybold] markup to a bold weighted span
//
$regexpArray = array(
    'SearchArray'=>array(
		'/(?<!\\\\)\[mybold(?::\w+)?\](.*?)\[\/mybold(?::\w+)?\]/si'    
	),
    'ReplaceArray'=>array(
    		"<span style=\"font-weight:bold\">\\1</span>"
    )
); 
?>
