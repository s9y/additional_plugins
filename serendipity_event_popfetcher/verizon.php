<?php

// Verizon library
// Author: Jason Levitt
// Email: fredb86@users.sourceforge.net

// Various strings used to identify parts of Verizon messages
define('VERIZON_IDENT_PICTURE', 'Verizon Wireless!'); // Msg  body identifies Verizon photo/video msg
define('VERIZON_MESSAGE_FOOTER', 'This message was sent');

function verizon_photo($maildir, $body) {

    $pos=strpos($body, VERIZON_MESSAGE_FOOTER);

    // If there's a msg, it's before the message footer
    $msg=trim(substr($body, 0, $pos));

    // If there's some text, put some space around it
    if ($msg != '') $msg='<br />'.$msg.'<br /><br />';

    return $msg;
}

?>