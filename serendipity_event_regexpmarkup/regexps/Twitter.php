<?php # $Id: Twitter.php,v 1.2 2009/12/17 16:22:36 garvinhicking Exp $
// Twitter preg replace markup
// turns usernames like @user to twitter-links
//
$regexpArray = array(
    'SearchArray' => array("/[^\w]@([\w]+)/i"),
    'ReplaceArray'=> array('<a href="http://www.twitter.com/\1">\1</a>')
); 
