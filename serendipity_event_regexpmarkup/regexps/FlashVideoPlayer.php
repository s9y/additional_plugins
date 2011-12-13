<?php
// Flash Player.
//
$regexpArray = array(
    'SearchArray'=>array(
		'/<flv:([^>]+)\/?>/U'
    ),
    'ReplaceArray'=>array(
		'<object type="application/x-shockwave-flash" width="320" height="240" data="http://yourdomain/flv.swf?file=\\1"><param name="movie" value="http://yourdomain/flv.swf?file=\\1" /></object>'
    )
);
