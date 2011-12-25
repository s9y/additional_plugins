<?php

// Cingular library
// Author: Jason Levitt
// Email: fredb86@users.sourceforge.net

// Various strings used to identify parts of Cingular messages
define('CINGULAR_IDENT_PICTURE', 'Picture('); // Subject header identifies Cinuglar photo msg
define('CINGULAR_MESSAGE_FOOTER', '----');

function cingular_photo($maildir, $body) {

    $pos=strpos($body, CINGULAR_MESSAGE_FOOTER);

    // If there's a msg, it's before the message footer
    $msg=trim(substr($body, 0, $pos));

    // If there's some text, put some space around it
    if ($msg != '') $msg='<br />'.$msg.'<br /><br />';

    return $msg;
}

?>