<?php # 
// Twitter preg replace markup
// turns usernames like @user to twitter-links
//
$regexpArray = array(
    'SearchArray' => array("/[^\w]@([\w]+)/i"),
    'ReplaceArray'=> array('<a href="http://www.twitter.com/\1">\1</a>')
); 
