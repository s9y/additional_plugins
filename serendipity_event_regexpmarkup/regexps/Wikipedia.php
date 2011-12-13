<?php
// Wiki-Reference.
//
$regexpArray = array(
    'SearchArray'=>array(
		"/\[\((.*)\)\]/U"
    ),
    'ReplaceArray'=>array(
		'<a href="http://de.wikipedia.org/wiki/\\1" target="_blank">\\1</a>'
    )
);
