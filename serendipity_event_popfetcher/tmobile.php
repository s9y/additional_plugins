<?php

// Tmobile library
// Author: Jason Levitt
// Email: fredb86@users.sourceforge.net

// Various strings used to identify parts of Tmobile messages
// Msg  body (not msg subject) identifies Tmobile photo/video msg
define('TMOBILE_IDENT_PICTURE', 't-mobile');
define('TMOBILE_MESSAGE_FOOTER', 'to view attachment');

function tmobile_photo($maildir, $body) {

    // For now, discard msg
    $msg='';

    // $pos=strpos($body, TMOBILE_MESSAGE_FOOTER);

    // If there's a msg, it's before the message footer
    // $msg=trim(substr($body, 0, $pos));

    // If there's some text, put some space around it
    // if ($msg != '') $msg='<br />'.$msg.'<br /><br />';

    return $msg;
}

?>