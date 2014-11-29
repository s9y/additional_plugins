<?php

// SprintPCS library
// Author: Jason Levitt
// Email: fredb86@users.sourceforge.net

// Various strings used to identify parts of SprintPCS messages
define('SPRINTPCS_IDENT_ALBUM', 'An Album Share!'); // Subject header identifies SprintPCS albums
define('SPRINTPCS_IDENT_ALB_JUNK', 'You have an Album Share!'); // Identifies a junk msg part from SprintPCS
define('SPRINTPCS_IDENT_PICTURE', 'A Picture Share!'); // Subject header identifies SprintPCS photos
define('SPRINTPCS_IDENT_PIC_JUNK', 'You have a Picture Share!'); // Identifies a junk msg part from SprintPCS
define('SPRINTPCS_IDENT_VIDEO', 'A Video Share!'); // Subject header identifies SprintPCS videos
define('SPRINTPCS_IDENT_VID_JUNK', 'You have a Video Share!'); // Identifies a junk msg part from SprintPCS
define('SPRINTPCS_PHOTO', '>View');
define('SPRINTPCS_PICTURE', 'http://pictures.sprintpcs.com/shareImage'); // A sprintpcs picture or video URL
define('SPRINTPCS_PICTURE_ALT', 'http://pictures.sprintpcs.com//shareImage'); // Check for double slashes too
define('SPRINTPCS_MEMO', 'Play Memo'); // Find an embedded sound memo
define('SPRINTPCS_MEMO_START', 'http://pictures.sprintpcs.com'); // Start of memo URL
define('SPRINTPCS_MSG', 'Message:'); // Start of message added to picture share
define('SPRINTPCS_VID_MSG', 'You have received');
define('SPRINTPCS_PLAYER_DETECT', 'player detection');

// GLOBAL
$cookiedata='';

// This function works around Sprint's multimedia player detection page
function sprintpcs_getrealpicture($view_url) {
    global $cookiedata;

    $cookiedata='';
    $rawout=fetchurl($view_url, false);

    if (!$rawout) {
        return false;
    }

    if ( stristr($rawout, SPRINTPCS_PLAYER_DETECT) )  {
        $findurl=strstr($rawout, 'location.href=');
        $loc2=strpos($findurl, '"', 15);
        $newurl=substr($findurl, 15, $loc2-15);
        // May not have http and domain name
        if (!strstr($newurl, 'http')) {
            $newurl = 'http://pictures.sprintpcs.com'.$newurl;
        }
        $rawout=fetchurl($newurl, false);
        if (!$rawout) {
            return false;
        }
    }

    $pos1=strpos($rawout, '_468');
    $workstr=substr($rawout, $pos1-20);
    $workstr=strstr($workstr, 'src="');
    $pos2=strpos($workstr, '"', 6);
    $pictureurl=substr($workstr, 5, $pos2-5);
    $pictureurl=str_replace('_468', '_640', $pictureurl);
    $prefix= 'http://pictures.sprintpcs.com';
    $targeturl=$prefix.$pictureurl;

    return $targeturl;
}

// A routine to do an HTTP GET while masquerading as a user browser
function fetchurl($URL, $ispic)
{
    global $cookiedata;

    $rawxml = null;
    $UrlArr = parse_url($URL);
    $host = $UrlArr['host'];
    $port = (isset($UrlArr['port'])) ? $UrlArr['port'] : 80;
    $path = $UrlArr['path'] . '?' . $UrlArr['query'];
    $errno = null;
    $errstr = '';

    $fp = @fsockopen($host, $port, $errno, $errstr, 10);

    if (!is_resource($fp))
    {
        $datestr = date("F j Y h:i:s A");
        $err = "$datestr: FSOCKOPEN=$errstr ERRNO=$errno\n";
        echo $err;
        return false;
    }
    else
    {
        fputs($fp, 'GET '. $path .' HTTP/1.1' . "\r\n");
        fputs($fp, "Host: ".$host."\r\n");
        fputs($fp, "User-agent: Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 5.0)\r\n");
        fputs($fp, 'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5'."\r\n");
        fputs($fp, "Accept-Language: en-us,en;q=0.5\r\n");
        fputs($fp, 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7'."\r\n");
        fputs($fp, "Accept-Encoding: gzip,deflate\r\n");

        if ($ispic) {
            fputs($fp, "Keep-Alive: 300\r\n");
            fputs($fp, "Connection: keep-alive\r\n");
        } else {
            fputs($fp, "Connection: close\r\n\r\n");
        }

        if (!empty($cookiedata)) {
            $cookiedata .= ' lsMedia=QT:6.5&RP:Y&pt:ActiveX&WMP:10.0.0.3646';
            fputs($fp, "Cookie: ".$cookiedata."\r\n");
            $cookiedata='';
        }

        if ($ispic) {
            fputs($fp, "Cache-Control: max-age=0\r\n\r\n");
        }

        // Check the HTTP code returned
        $line = fgets($fp , 1024);

        // HTTP return code of 200 means success
        if (!(strstr($line, '200')))
        {
            $datestr = date("F j Y h:i:s A");
            $errstr = "$datestr: HTTP=$line URL=$URL\n";
            echo $errstr;
            fclose($fp);
            return false;
        }

        // Find blank line between header and data
        while (!feof($fp))
        {
            $line = fgets($fp , 1024);

            if (strstr($line, 'machineid') or strstr($line, 'imgsessionid')) {
                $pos1=strpos($line, 'Set-Cookie');
                $pos2=strpos($line, ';');
                $entry=substr($line, $pos1+12, $pos2-11);
                $cookiedata .= ' '.$entry;
            }

            if (strlen($line) < 3)
            {
                break;
            }
        }

        // Fetch the data
        while ($line = fgets($fp, 4096))
        {
            $rawxml .= $line;
        }

        fclose($fp);

    }
    return $rawxml;
}

function sprintpcs_pictureshare($maildir, $body, $authorid) {
    global $serendipity;

    // Could be string with nothing but spaces
    $body=trim($body);
    if (empty($body)) {
        return '';
    }

    if (strstr($body, SPRINTPCS_IDENT_PIC_JUNK)) {
        return '';
    }

    $path = $serendipity['serendipityPath'] . $serendipity['uploadPath'] . $maildir;

    // Find the picture URL -- Look in the "View" link....
    $pos1=strpos($body, SPRINTPCS_PHOTO);

    if (!$pos1) {
        return MF_ERROR10;  // Failed to find the picture URL
    }

    $picture=substr($body, 0, $pos1-1);
    $pos1=strrpos($picture, '"');
    $url=substr($picture, $pos1+1);
    $url=html_entity_decode($url, ENT_COMPAT, LANG_CHARSET);

    // Fetch the picture
    $targeturl=sprintpcs_getrealpicture($url);

    if (!$targeturl) {
        return MF_ERROR11;
    }

    // Strangeness: If we are using HTTPS on the launching page for
    // POPfetcher, Sprint hands us the
    // Generic image....we must use HTTP...why?
    $picture = fetchurl($targeturl, true);

    if (!$picture) {
        return MF_ERROR11;
    }

    // Build the filename
    $filename = time().'sprint'.'.jpg';
    $pos=strpos($filename,'jpg');
    $filename = substr($filename, 0, $pos+3);
    $fullname = $path.$filename;
    $ext=substr(strrchr($filename, "."), 0);
    $name=substr($filename, 0, strrpos($filename, "."));

    // Check for duplicate filename.
    if (is_file($fullname)) {
        echo '<br />'.MF_MSG14.$filename;
        $name=$name.time().'dup';
        $filename=$name.$ext;
        $fullname=$path.$filename;
    }

    // Write the picture
    $fp=fopen($fullname, 'w');
    if (!$fp) {
        return MF_ERROR13;
    }
    fwrite($fp, $picture);
    serendipity_makeThumbnail($filename, $maildir, false);
    serendipity_insertImageInDatabase($filename, $maildir, $authorid , NULL);

    // Create Thumbnail name
    $thumbname=$name.'.'.$serendipity['thumbSuffix'].$ext ;

    // Find the message text, if it exists
    $msg=stristr($body, SPRINTPCS_MSG);
    if ($msg) {
        $pos=strpos($msg, '</font>');
        $msg=html_entity_decode(substr($msg, 17, $pos-17), ENT_QUOTES, LANG_CHARSET).'<br /><br />';
        if (trim($msg) == '<br /><br />') $msg='';
    } else {
        $msg='';
    }

    // Find the sound memo, if it exists
    $memo=stristr($body, SPRINTPCS_MEMO);
    if ($memo) {
        $memo=stristr($memo, SPRINTPCS_MEMO_START);
        $pos=strpos($memo, '"');
        $memo=substr($memo, 0, $pos);
        $memo=html_entity_decode($memo, ENT_COMPAT, LANG_CHARSET);
        $memosound = @file_get_contents($memo);
        // Build the filename - I use this funky date name because the Sprint file path is too gnarly
        $memofilename = date("F_j_Y__H_i_s").'.wav';
        $memofullname = $path.$memofilename;
        $ext=substr(strrchr($memofilename, "."), 0);
        // Write the memo
        $fp=fopen($memofullname, 'w');
        if (!$fp) {
            return MF_ERROR14;
        }
        fwrite($fp, $memosound);
        serendipity_makeThumbnail($memofilename, $maildir, false);
        serendipity_insertImageInDatabase($memofilename, $maildir, $authorid , NULL);

        echo '<br />'.MF_MSG13.$memofilename;
        $memo='<a href="'.$serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$maildir.$memofilename.'" target="_blank">'.MF_MSG21.'</a><br /><br />';
    } else  {
        $memo='';
    }

    echo '<br />'.MF_MSG13.$filename;

    return $msg.$memo.'<a href="'.$serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$maildir.$filename.'" target="_blank"><img src="'.$serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$maildir.$thumbname.'" alt="'.MF_MSG18.'" /></a>';
}

function sprintpcs_videoshare($maildir, $body, $authorid) {
    global $serendipity;

    if (strstr($body, SPRINTPCS_IDENT_VID_JUNK)) {
        return '';
    }

    $body=trim($body);
    if (empty($body)) {
        return '';
    }

    $path = $serendipity['serendipityPath'] . $serendipity['uploadPath'] . $maildir;

    // Find the picture URL -- There should always be a picture???
    $video=stristr($body, SPRINTPCS_PICTURE);
    if (!$video) $video=stristr($body, SPRINTPCS_PICTURE_ALT);
    if (!$video) {
        return MF_ERROR10;  // Failed to find the picture URL
    }
    $pos=strpos($video, '"');
    $url=substr($video, 0, $pos);
    $url=html_entity_decode($url, ENT_COMPAT, LANG_CHARSET);

    // Fetch the picture
    $videostill = @file_get_contents($url);

    if (!$videostill) {
        return MF_ERROR11;
    }

    // Build the filename
    $filename = basename($url);
    $pos=strpos($filename,'?');
    $filename = substr($filename, 0, $pos).'.jpg';
    $fullname = $path.$filename;
    $ext=substr(strrchr($filename, "."), 0);
    $name=substr($filename, 0, strrpos($filename, "."));

    // Check for duplicate filename.
    if (is_file($fullname)) {
        echo '<br />'.MF_MSG14.$filename;
        $name=$name.time().'dup';
        $filename=$name.$ext;
        $fullname=$path.$filename;
    }

    // Write the video still
    $fp=fopen($fullname, 'w');
    if (!$fp) {
        return MF_ERROR13;
    }
    fwrite($fp, $videostill);
    serendipity_makeThumbnail($filename, $maildir, false);
    serendipity_insertImageInDatabase($filename, $maildir, $authorid , NULL);

    // Create Thumbnail name
    $thumbname=$name.'.'.$serendipity['thumbSuffix'].$ext ;

    // Get the actual video
    $url=str_replace('true', 'false', $url);

    // Fetch the picture
    $video = @file_get_contents($url);

    if (!$video) {
        return MF_ERROR11;
    }

    // Build the filename
    $mfilename = basename($url);
    $pos=strpos($mfilename,'?');
    $mfilename = substr($mfilename, 0, $pos).'.mov';
    $mfullname = $path.$mfilename;
    $mext=substr(strrchr($mfilename, "."), 0);
    $mname=substr($mfilename, 0, strrpos($mfilename, "."));

    // Check for duplicate filename.
    if (is_file($mfullname)) {
        echo '<br />'.MF_MSG14.$mfilename;
        $mname=$mname.time().'dup';
        $mfilename=$mname.$mext;
        $mfullname=$path.$mfilename;
    }

    // Write the video
    $fp=fopen($mfullname, 'w');
    if (!$fp) {
        return MF_ERROR13;
    }
    fwrite($fp, $video);
    echo '<br />'.MF_MSG13.$mfilename;
    serendipity_makeThumbnail($mfilename, $maildir, false);
    serendipity_insertImageInDatabase($mfilename, $maildir, $authorid , NULL);

    // Find the message text, if it exists
    $msg=strstr($body, SPRINTPCS_MSG);
    if ($msg) {
        $pos=strpos($msg, '</font>');
        $msg=html_entity_decode(substr($msg, 17, $pos-17), ENT_QUOTES, LANG_CHARSET).'<br /><br />';
        if (trim($msg) == '<br /><br />') $msg='';
    } elseif ($msg=stristr($body, SPRINTPCS_VID_MSG)) {
        $msg=strstr($msg, '"2">');
        $pos=strpos($msg, '</font');
        $msg=html_entity_decode(substr($msg, 4, $pos-4), ENT_QUOTES, LANG_CHARSET).'<br /><br />';
        if (trim($msg) == '<br /><br />') $msg='';
    } else {
        $msg='';
    }

    // Find the sound memo, if it exists
    $memo=stristr($body, SPRINTPCS_MEMO);
    if ($memo) {
        $memo=stristr($memo, SPRINTPCS_MEMO_START);
        $pos=strpos($memo, '"');
        $memo=substr($memo, 0, $pos);
        $memo=html_entity_decode($memo, ENT_COMPAT, LANG_CHARSET);
        $memosound = @file_get_contents($memo);
        // Build the filename - I use this funky date name because the Sprint file path is too gnarly
        $memofilename = date("F_j_Y__H_i_s").'.wav';
        $memofullname = $path.$memofilename;
        $ext=substr(strrchr($memofilename, "."), 0);
        // Write the memo
        $fp=fopen($memofullname, 'w');
        if (!$fp) {
            return MF_ERROR14;
        }
        fwrite($fp, $memosound);
        serendipity_makeThumbnail($memofilename, $maildir, false);
        serendipity_insertImageInDatabase($memofilename, $maildir, $authorid , NULL);

        echo '<br />'.MF_MSG13.$memofilename;
        $memo='<a href="'.$serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$maildir.$memofilename.'" target="_blank">'.MF_MSG21.'</a><br /><br />';
    } else {
        $memo='';
    }

    echo '<br />'.MF_MSG13.$filename;

    return $msg.$memo.'<a href="'.$serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$maildir.$mfilename.'" target="_blank"><img src="'.$serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$maildir.$thumbname.'" alt="'.MF_MSG22.'" /></a>';
}

function sprintpcs_albumshare($maildir, $body, $authorid) {
    global $serendipity;

    if (strstr($body, SPRINTPCS_IDENT_ALB_JUNK)) {
        return '';
    }

    $body=trim($body);
    if (empty($body)) {
        return '';
    }

    $path = $serendipity['serendipityPath'] . $serendipity['uploadPath'] . $maildir;

    // Find the picture URL -- There should always be a picture???
    $video=stristr($body, SPRINTPCS_PICTURE);
    if (!$video) $video=stristr($body, SPRINTPCS_PICTURE_ALT);
    if (!$video) {
        return MF_ERROR10;  // Failed to find the picture URL
    }
    $pos=strpos($video, '"');
    $url=substr($video, 0, $pos);
    $url=html_entity_decode($url, ENT_COMPAT, LANG_CHARSET);

    // Fetch the picture
    $videostill = @file_get_contents($url);

    if (!$videostill) {
        return MF_ERROR11;
    }

    // Build the filename
    $filename = basename($url);
    $pos=strpos($filename,'?');
    $filename = substr($filename, 0, $pos).'.jpg';
    $fullname = $path.$filename;
    $ext=substr(strrchr($filename, "."), 0);
    $name=substr($filename, 0, strrpos($filename, "."));

    // Check for duplicate filename.
    if (is_file($fullname)) {
        echo '<br />'.MF_MSG14.$filename;
        $name=$name.time().'dup';
        $filename=$name.$ext;
        $fullname=$path.$filename;
    }

    // Write the video still
    $fp=fopen($fullname, 'w');
    if (!$fp) {
        return MF_ERROR13;
    }
    fwrite($fp, $videostill);
    serendipity_makeThumbnail($filename, $maildir, false);
    serendipity_insertImageInDatabase($filename, $maildir, $authorid , NULL);

    // Create Thumbnail name
    $thumbname=$name.'.'.$serendipity['thumbSuffix'].$ext ;

    // Get the actual video
    $url=str_replace('true', 'false', $url);

    // Fetch the picture
    $video = @file_get_contents($url);

    if (!$video) {
        return MF_ERROR11;
    }

    // Build the filename
    $mfilename = basename($url);
    $pos=strpos($mfilename,'?');
    $mfilename = substr($mfilename, 0, $pos).'.mov';
    $mfullname = $path.$mfilename;
    $mext=substr(strrchr($mfilename, "."), 0);
    $mname=substr($mfilename, 0, strrpos($mfilename, "."));

    // Check for duplicate filename.
    if (is_file($mfullname)) {
        echo '<br />'.MF_MSG14.$mfilename;
        $mname=$mname.time().'dup';
        $mfilename=$mname.$mext;
        $mfullname=$path.$mfilename;
    }

    // Write the video
    $fp=fopen($mfullname, 'w');
    if (!$fp) {
        return MF_ERROR13;
    }
    fwrite($fp, $video);
    echo '<br />'.MF_MSG13.$mfilename;
    serendipity_makeThumbnail($mfilename, $maildir, false);
    serendipity_insertImageInDatabase($mfilename, $maildir, $authorid , NULL);

    // Find the message text, if it exists
    $msg=strstr($body, SPRINTPCS_MSG);
    if ($msg) {
        $pos=strpos($msg, '</font>');
        $msg=html_entity_decode(substr($msg, 17, $pos-17), ENT_QUOTES, LANG_CHARSET).'<br /><br />';
        if (trim($msg) == '<br /><br />') $msg='';
    } elseif ($msg=stristr($body, SPRINTPCS_VID_MSG)) {
        $msg=strstr($msg, '"2">');
        $pos=strpos($msg, '</font');
        $msg=html_entity_decode(substr($msg, 4, $pos-4), ENT_QUOTES, LANG_CHARSET).'<br /><br />';
        if (trim($msg) == '<br /><br />') $msg='';
    } else {
        $msg='';
    }

    // Find the sound memo, if it exists
    $memo=stristr($body, SPRINTPCS_MEMO);
    if ($memo) {
        $memo=stristr($memo, SPRINTPCS_MEMO_START);
        $pos=strpos($memo, '"');
        $memo=substr($memo, 0, $pos);
        $memo=html_entity_decode($memo, ENT_COMPAT, LANG_CHARSET);
        $memosound = @file_get_contents($memo);
        // Build the filename - I use this funky date name because the Sprint file path is too gnarly
        $memofilename = date("F_j_Y__H_i_s").'.wav';
        $memofullname = $path.$memofilename;
        $ext=substr(strrchr($memofilename, "."), 0);
        // Write the memo
        $fp=fopen($memofullname, 'w');
        if (!$fp) {
            return MF_ERROR14;
        }
        fwrite($fp, $memosound);
        serendipity_makeThumbnail($memofilename, $maildir, false);
        serendipity_insertImageInDatabase($memofilename, $maildir, $authorid , NULL);
        echo '<br />'.MF_MSG13.$memofilename;
        $memo='<a href="'.$serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$maildir.$memofilename.'" target="_blank">'.MF_MSG21.'</a><br /><br />';
    } else {
        $memo='';
    }

    echo '<br />'.MF_MSG13.$filename;

    return $msg.$memo.'<a href="'.$serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$maildir.$mfilename.'" target="_blank"><img src="'.$serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$maildir.$thumbname.'" alt="'.MF_MSG22.'" /></a>';
}

?>
