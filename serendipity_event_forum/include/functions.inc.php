<?php

# (c) 2005 by Alexander 'dma147' Mieland, http://blog.linux-stats.org, <dma147@linux-stats.org>
# Contact me on IRC in #linux-stats, #archlinux, #archlinux.de, #s9y on irc.freenode.net





    function DMA_forum_array_remove($array, $remove) {
        if (is_array($array)) {
            foreach($array AS $key => $val) {
                if ($val == $remove) {
                    $key_index = $key;
                    break;
                }
            }
            unset($array[$key_index]);
            if(gettype($key_index) != "string") {
                $temparray = array();
                $i = 0;
                foreach($array as $value) {
                    $temparray[$i] = $value;
                    $i++;
                }
                $array = $temparray;
            }
            return $array;
        } else {
            return false;
        }
    }


    function DMA_forum_calcFilesize($filesize) {
       $array = array(
           'YB' => 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024,
           'ZB' => 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024,
           'EB' => 1024 * 1024 * 1024 * 1024 * 1024 * 1024,
           'PB' => 1024 * 1024 * 1024 * 1024 * 1024,
           'TB' => 1024 * 1024 * 1024 * 1024,
           'GB' => 1024 * 1024 * 1024,
           'MB' => 1024 * 1024,
           'KB' => 1024,
       );
       if($filesize <= 1024) {
           $filesize = $filesize . ' Bytes';
       }
       foreach($array AS $name => $size) {
           if($filesize > $size || $filesize == $size) {
               $filesize = round((round($filesize / $size * 100) / 100), 2) . ' ' . $name;
           }
       }
       return $filesize;
    }




    function DMA_forum_getMime($filename, $relpath="./") {
        static $mimetypes = array(
             "ez" => "application/andrew-inset",
             "hqx" => "application/mac-binhex40",
             "cpt" => "application/mac-compactpro",
             "doc" => "application/msword",
             "bin" => "application/octet-stream",
             "dms" => "application/octet-stream",
             "lha" => "application/octet-stream",
             "lzh" => "application/octet-stream",
             "exe" => "application/octet-stream",
             "class" => "application/octet-stream",
             "so" => "application/octet-stream",
             "dll" => "application/octet-stream",
             "oda" => "application/oda",
             "pdf" => "application/pdf",
             "ai" => "application/postscript",
             "eps" => "application/postscript",
             "ps" => "application/postscript",
             "smi" => "application/smil",
             "smil" => "application/smil",
             "wbxml" => "application/vnd.wap.wbxml",
             "wmlc" => "application/vnd.wap.wmlc",
             "wmlsc" => "application/vnd.wap.wmlscriptc",
             "bcpio" => "application/x-bcpio",
             "vcd" => "application/x-cdlink",
             "pgn" => "application/x-chess-pgn",
             "cpio" => "application/x-cpio",
             "csh" => "application/x-csh",
             "dcr" => "application/x-director",
             "dir" => "application/x-director",
             "dxr" => "application/x-director",
             "dvi" => "application/x-dvi",
             "spl" => "application/x-futuresplash",
             "gtar" => "application/x-gtar",
             "hdf" => "application/x-hdf",
             "js" => "application/x-javascript",
             "skp" => "application/x-koan",
             "skd" => "application/x-koan",
             "skt" => "application/x-koan",
             "skm" => "application/x-koan",
             "latex" => "application/x-latex",
             "nc" => "application/x-netcdf",
             "cdf" => "application/x-netcdf",
             "sh" => "application/x-sh",
             "shar" => "application/x-shar",
             "swf" => "application/x-shockwave-flash",
             "sit" => "application/x-stuffit",
             "sv4cpio" => "application/x-sv4cpio",
             "sv4crc" => "application/x-sv4crc",
             "tar" => "application/x-tar",
             "tcl" => "application/x-tcl",
             "tex" => "application/x-tex",
             "texinfo" => "application/x-texinfo",
             "texi" => "application/x-texinfo",
             "t" => "application/x-troff",
             "tr" => "application/x-troff",
             "roff" => "application/x-troff",
             "man" => "application/x-troff-man",
             "me" => "application/x-troff-me",
             "ms" => "application/x-troff-ms",
             "ustar" => "application/x-ustar",
             "src" => "application/x-wais-source",
             "xhtml" => "application/xhtml+xml",
             "xht" => "application/xhtml+xml",
             "zip" => "application/zip",
             "au" => "audio/basic",
             "snd" => "audio/basic",
             "mid" => "audio/midi",
             "midi" => "audio/midi",
             "kar" => "audio/midi",
             "mpga" => "audio/mpeg",
             "mp2" => "audio/mpeg",
             "mp3" => "audio/mpeg",
             "aif" => "audio/x-aiff",
             "aiff" => "audio/x-aiff",
             "aifc" => "audio/x-aiff",
             "m3u" => "audio/x-mpegurl",
             "ram" => "audio/x-pn-realaudio",
             "rm" => "audio/x-pn-realaudio",
             "rpm" => "audio/x-pn-realaudio-plugin",
             "ra" => "audio/x-realaudio",
             "wav" => "audio/x-wav",
             "pdb" => "chemical/x-pdb",
             "xyz" => "chemical/x-xyz",
             "bmp" => "image/bmp",
             "gif" => "image/gif",
             "ief" => "image/ief",
             "jpeg" => "image/jpeg",
             "jpg" => "image/jpeg",
             "jpe" => "image/jpeg",
             "png" => "image/png",
             "tiff" => "image/tiff",
             "tif" => "image/tif",
             "djvu" => "image/vnd.djvu",
             "djv" => "image/vnd.djvu",
             "wbmp" => "image/vnd.wap.wbmp",
             "ras" => "image/x-cmu-raster",
             "pnm" => "image/x-portable-anymap",
             "pbm" => "image/x-portable-bitmap",
             "pgm" => "image/x-portable-graymap",
             "ppm" => "image/x-portable-pixmap",
             "prc" => "application/x-pilot",
             "pdb" => " application/x-pilot-pdb",
             "rgb" => "image/x-rgb",
             "xbm" => "image/x-xbitmap",
             "xpm" => "image/x-xpixmap",
             "xwd" => "image/x-windowdump",
             "igs" => "model/iges",
             "iges" => "model/iges",
             "msh" => "model/mesh",
             "mesh" => "model/mesh",
             "silo" => "model/mesh",
             "wrl" => "model/vrml",
             "vrml" => "model/vrml",
             "css" => "text/css",
             "html" => "text/html",
             "htm" => "text/html",
             "asc" => "text/plain",
             "txt" => "text/plain",
             "htm" => "text/plain",
             "html" => "text/plain",
             "inc" => "text/plain",
             "tpl" => "text/plain",
             "php" => "text/plain",
             "php3" => "text/plain",
             "php4" => "text/plain",
             "php5" => "text/plain",
             "phtm" => "text/plain",
             "phtml" => "text/plain",
             "shtm" => "text/plain",
             "shtml" => "text/plain",
             "rtx" => "text/richtext",
             "rtf" => "text/rtf",
             "sgml" => "text/sgml",
             "sgm" => "text/sgml",
             "tsv" => "text/tab-seperated-values",
             "wml" => "text/vnd.wap.wml",
             "wmls" => "text/vnd.wap.wmlscript",
             "etx" => "text/x-setext",
             "xml" => "text/xml",
             "xsl" => "text/xml",
             "mpeg" => "video/mpeg",
             "mpg" => "video/mpeg",
             "mpe" => "video/mpeg",
             "qt" => "video/quicktime",
             "mov" => "video/quicktime",
             "mxu" => "video/vnd.mpegurl",
             "avi" => "video/x-msvideo",
             "wmv" => "video/x-msvideo",
             "movie" => "video/x-sgi-movie",
             "ice" => "x-conference-xcooltalk"
        );

        $MIMETYPE = array();

        $filename = basename($filename);
        $fileparts = explode(".", $filename);
        $EXTENSION = strtolower($fileparts[(count($fileparts) - 1)]);

        if (file_exists($relpath."img/dlicons/".$EXTENSION.".png"))
            $MIMETYPE['ICON'] = $relpath."img/dlicons/".$EXTENSION.".png";
        else
            $MIMETYPE['ICON'] = $relpath."img/dlicons/unknown.png";
	
        if (!empty($mimetypes[$EXTENSION]) && trim($mimetypes[$EXTENSION]) != "")
            $MIMETYPE['TYPE'] = $mimetypes[$EXTENSION];
        else
            $MIMETYPE['TYPE'] = "application/octet-stream";
        return $MIMETYPE;
    }

    function DMA_forum_genCryptString($pwdLen=32, $usables=PWD_ALLOW_ALL) {
        $pwdSource = "";
        $STRING = "";
        if ( $usables & ( 1 << 0 ))     $pwdSource .= "1234567890";
        if ( $usables & ( 1 << 1 ))     $pwdSource .= "abcdefghijklmnopqrstuvwxyz";
        if ( $usables & ( 1 << 2 ))     $pwdSource .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        srand ((double) microtime() * 1000000);
        while ( $pwdLen ) {
            srand ((double) microtime() * 1000000);
            $STRING .= substr( $pwdSource, rand( 0, strlen( $pwdSource )), 1);
            $pwdLen--;
        }
        return $STRING;
    }





    function DMA_forum_uploadFiles($postid, $uploaddir) {
        global $serendipity;
        $upload_max_filesize = ini_get('upload_max_filesize');
        $upload_max_filesize = preg_replace('/M/', '000000', $upload_max_filesize);
        $MAX_FILE_SIZE = intval($upload_max_filesize);

        $SUCCESS = 0;
        $countfile = 0;
        if (isset($serendipity['POST']['uploaded']) && intval($serendipity['POST']['uploaded']) >= 1) {
            for ($ulnum=0;$ulnum<count($_FILES['forum_upload']['tmp_name']);$ulnum++) {
                if (trim($_FILES['forum_upload']['tmp_name'][$ulnum]) != "none" && $_FILES['forum_upload']['size'][$ulnum] >= 5 && is_uploaded_file($_FILES['forum_upload']['tmp_name'][$ulnum])) {
                    $FILESIZE = $_FILES['forum_upload']['size'][$ulnum];
                    if ($FILESIZE >= ($MAX_FILE_SIZE+1)) {
                        $TOOBIG[] = $_FILES['forum_upload']['name'][$ulnum];
                    } else {
                        $SERVERFILENAME = DMA_forum_genCryptString();
                        if (!move_uploaded_file($_FILES['forum_upload']['tmp_name'][$ulnum], $uploaddir."/".$SERVERFILENAME)) {
                            $NOTCOPIED[] = $_FILES['forum_upload']['name'][$ulnum];
                        } else {
                            if (serendipity_userLoggedIn()) {
                                $authorid = intval($serendipity['authorid']);
                            } else {
                                $authorid = 0;
                            }
							if (isset($serendipity['POST']['upload_overwrite']) && intval($serendipity['POST']['upload_overwrite']) >= 1) {
								$sql = "SELECT uploadid, sysfilename FROM {$serendipity['dbPrefix']}dma_forum_uploads WHERE realfilename = '".serendipity_db_escape_string(basename($_FILES['forum_upload']['name'][$ulnum]))."' AND authorid='".intval($authorid)."'";
								$uploads = serendipity_db_query($sql);
								if (is_array($uploads) && count($uploads) >= 1) {
									for ($a=0;$a<count($uploads);$a++) {
										$query = "UPDATE {$serendipity['dbPrefix']}dma_forum_uploads SET uploaddate='".time()."', filesize='".$FILESIZE."', sysfilename='".$SERVERFILENAME."' WHERE uploadid='".intval($uploads[$a]['uploadid'])."'";
										@unlink($uploaddir."/".$uploads[$a]['sysfilename']);
										serendipity_db_query($query);
									}
								}
							}
                            serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}dma_forum_uploads
                                                        (
                                                            postid,
                                                            authorid,
                                                            uploaddate,
                                                            filesize,
                                                            sysfilename,
                                                            realfilename,
                                                            dlcount
                                                ) VALUES (
                                                            '".intval($postid)."',
                                                            '".intval($authorid)."',
                                                            '".time()."',
                                                            '".$FILESIZE."',
                                                            '".$SERVERFILENAME."',
                                                            '".serendipity_db_escape_string(basename($_FILES['forum_upload']['name'][$ulnum]))."',
                                                            '0'
                                                )");
                            @chmod($uploaddir."/".$SERVERFILENAME, 0666);
                            $SUCCESS = 1;
                            $countfile++;
                        }
                    }
                    @unlink($_FILES['forum_upload']['tmp_name'][$ulnum]);
                }
            }
        }
        $return['SUCCESS'] = $SUCCESS;
        $return['countfile'] = $countfile;
        $return['TOOBIG'] = $TOOBIG;
        $return['NOTCOPIED'] = $NOTCOPIED;
        return $return;
    }







    function DMA_forum_CheckLastProperties($boardid) {
        global $serendipity;
        $boardid = intval($boardid);
        $boardpostcount = 0;
        $lastpost['replies'] = 0;
        $lastpost['lastauthorid'] = 0;
        $lastpost['lastauthorname'] = '';
        $lastpost['lastpostid'] = 0;
        $lastpost['lastposttime'] = 0;
        $lastpost['lastthreadid'] = 0;
        $lastpost['postdate'] = 0;
        $sql = "SELECT threadid FROM {$serendipity['dbPrefix']}dma_forum_threads WHERE boardid = '".$boardid."'";
        $threads = serendipity_db_query($sql);
        if (is_array($threads) && count($threads) >= 1) {
            $threadcount = count($threads);
            foreach($threads AS $thread) {
                $threadid = intval($thread['threadid']);
                $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_posts WHERE threadid = '".$threadid."' ORDER BY postdate DESC";
                $posts = serendipity_db_query($sql);
                $postnum = count($posts);
                $postcount = $postnum;
                $postcount--;
                $boardpostcount += $postcount;
                if (isset($lastpost) && $posts[0]['postdate'] >= $lastpost['postdate']) {
                    $lastpost = $posts[0];
                }
                $sql = "UPDATE {$serendipity['dbPrefix']}dma_forum_threads SET
                                replies = '".$postcount."',
                                lastauthorid = '".intval($posts[0]['authorid'])."',
                                lastauthorname = '".serendipity_db_escape_string(trim(stripslashes($posts[0]['authorname'])))."',
                                lastpostid = '".$posts[0]['postid']."',
                                lastposttime = '".$posts[0]['postdate']."'
                          WHERE threadid = '".$threadid."'";
                serendipity_db_query($sql);
            }
        } else {
            $threadcount = 0;
        }
        $sql = "UPDATE {$serendipity['dbPrefix']}dma_forum_boards SET
                        threads = '".$threadcount."',
                        posts = '".$boardpostcount."',
                        lastauthorid = '".intval($lastpost['authorid'])."',
                        lastauthorname = '".serendipity_db_escape_string(trim(stripslashes($lastpost['authorname'])))."',
                        lastthreadid = '".$lastpost['threadid']."',
                        lastpostid = '".$lastpost['postid']."',
                        lastposttime = '".$lastpost['postdate']."'
                  WHERE boardid = '".$boardid."'";
        serendipity_db_query($sql);
    }



    function DMA_strip($string) {
    	$string = str_replace("\n", "", $string);
    	$string = str_replace("\r", "", $string);
    	$string = str_replace("\t", "", $string);
    	$string = str_replace("\0", "", $string);
    	$string = strip_tags($string);
    	$string = trim($string);
		return $string;
    }

    function DMA_forum_InsertReply($boardid, $threadid, $replyto, $authorname, $title, $message, $itemsperpage, $frommail, $fromname, $pageurl, $admin_notify=true) {
        global $serendipity;
        if (serendipity_userLoggedIn()) {
            $authorname = $serendipity['serendipityUser'];
            $KEXTRA = ", authorid";
            $VEXTRA = ", '".$serendipity['authorid']."'";
            $EEXTRA = " lastauthorid = '".$serendipity['authorid']."', ";
        } else {
            $KEXTRA = "";
            $VEXTRA = "";
            $EEXTRA = "";
        }
        $now = time();
        $q = "INSERT INTO {$serendipity['dbPrefix']}dma_forum_posts (
                    threadid,
                    postdate,
                    title,
                    message,
                    authorname".$KEXTRA."
        ) VALUES (
                    '".intval($threadid)."',
                    '".$now."',
                    '".serendipity_db_escape_string(trim($title))."',
                    '".serendipity_db_escape_string(trim($message))."',
                    '".serendipity_db_escape_string(trim($authorname))."'".$VEXTRA."
        )";
        $sql = serendipity_db_query($q);
        $lastpostid = serendipity_db_insert_id('dma_forum_posts', 'postid');
        DMA_forum_CheckLastProperties(intval($boardid));
        if (isset($_SESSION['forum_visited']) && intval($_SESSION['forum_visited']) >= 1) {
            $q = "UPDATE {$serendipity['dbPrefix']}dma_forum_users SET posts = posts+1, lastpost = '".$lastpostid."' WHERE authorid = '".intval($serendipity['authorid'])."'";
            serendipity_db_query($q);
        }
        $_SESSION['lastposttext'] = trim($message);
        $_SESSION['lastposttime'] = time();
        $sql = "SELECT COUNT(*) FROM {$serendipity['dbPrefix']}dma_forum_posts WHERE threadid='".intval($threadid)."'";
        $postnum = serendipity_db_query($sql);
        $page = ceil(intval($postnum[0][0]) / intval($itemsperpage));

        $sql = "SELECT title, notifymails FROM {$serendipity['dbPrefix']}dma_forum_threads WHERE threadid='".intval($threadid)."'";
        $notifylist = serendipity_db_query($sql);
        
        
        $fromname = DMA_strip($fromname);
        $frommail = DMA_strip($frommail);
        
        if (is_array($notifylist) && trim($notifylist[0]['title']) != "") {
            $NOTIFYARRAY = unserialize(stripslashes(trim($notifylist[0]['notifymails'])));
            $Bcc_headers = "";
            for($a=0,$b=count($NOTIFYARRAY);$a<$b;$a++) {
                $Bcc_headers .= "Bcc: ".DMA_strip(trim($NOTIFYARRAY[$a]))."\r\n";
            }
            $subject = str_replace("{postauthor}", trim($authorname), PLUGIN_FORUM_EMAIL_NOTIFY_SUBJECT);
            $subject = str_replace("{blogurl}", $serendipity['baseURL'], $subject);

            $body = PLUGIN_FORUM_EMAIL_NOTIFY_PART1 . PLUGIN_FORUM_EMAIL_NOTIFY_PART2 . PLUGIN_FORUM_EMAIL_NOTIFY_PART3;

            $body = str_replace("{postauthor}", trim($authorname), $body);
            $body = str_replace("{forumurl}", $serendipity['baseURL'] . "index.php?serendipity[subpage]=" . $pageurl, $body);
            $body = str_replace("{threadtitle}", (function_exists('serendipity_specialchars') ? serendipity_specialchars(trim($notifylist[0]['title'])) : htmlspecialchars(trim($notifylist[0]['title']), ENT_COMPAT, LANG_CHARSET)), $body);
            $body = str_replace("{replytext}", (function_exists('serendipity_specialchars') ? serendipity_specialchars(strip_tags(trim($message))) : htmlspecialchars(strip_tags(trim($message)), ENT_COMPAT, LANG_CHARSET)), $body);
            $body = str_replace("{posturl}", $serendipity['baseURL'] . "index.php?serendipity[subpage]=" . $pageurl . "&boardid=".intval($boardid)."&threadid=".intval($threadid)."&page=".$page."#".$lastpostid, $body);

            $from    = "$fromname <$frommail>";
            $to      = 'nobody@localhost';
            $headers  = "From: $from\r\n";
            $headers .= "Reply-To: $frommail\r\n";
            $headers .= $Bcc_headers;
            $headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n\r\n";
            mail($to, $subject, $body, $headers);
        }
		
		if ($admin_notify === true) {
            $subject = str_replace("{postauthor}", trim($authorname), PLUGIN_FORUM_EMAIL_NOTIFY_SUBJECT);
            $subject = str_replace("{blogurl}", $serendipity['baseURL'], $subject);

            $body = PLUGIN_FORUM_EMAIL_NOTIFY_PART1 . PLUGIN_FORUM_EMAIL_NOTIFY_PART2 . PLUGIN_FORUM_EMAIL_NOTIFY_PART3;

            $body = str_replace("{postauthor}", trim($authorname), $body);
            $body = str_replace("{forumurl}", $serendipity['baseURL'] . "index.php?serendipity[subpage]=" . $pageurl, $body);
            $body = str_replace("{threadtitle}", (function_exists('serendipity_specialchars') ? serendipity_specialchars(trim($notifylist[0]['title'])) : htmlspecialchars(trim($notifylist[0]['title']), ENT_COMPAT, LANG_CHARSET)), $body);
            $body = str_replace("{replytext}", (function_exists('serendipity_specialchars') ? serendipity_specialchars(strip_tags(trim($message))) : htmlspecialchars(strip_tags(trim($message)), ENT_COMPAT, LANG_CHARSET)), $body);
            $body = str_replace("{posturl}", $serendipity['baseURL'] . "index.php?serendipity[subpage]=" . $pageurl . "&boardid=".intval($boardid)."&threadid=".intval($threadid)."&page=".$page."#".$lastpostid, $body);

            $from    = "$fromname <$frommail>";
            $to      = "".$serendipity['blogMail']."";
            $headers  = "From: $from\r\n";
            $headers .= "Reply-To: $frommail\r\n";
            $headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n\r\n";
            mail($to, $subject, $body, $headers);
		}
		
        unset($_GET);
        $_GET['boardid'] = intval($boardid);
        $_GET['threadid'] = intval($threadid);
        $_GET['page'] = intval($page);
        return $lastpostid;
    }





    function DMA_forum_EditReply($boardid, $threadid, $edit, $authorname, $title, $message, $page=1, $announce=0) {
        global $serendipity;
        $now = time();
        $q = "UPDATE {$serendipity['dbPrefix']}dma_forum_posts SET
                    title = '".serendipity_db_escape_string(trim($title))."',
                    message = '".serendipity_db_escape_string(trim($message))."',
                    editcount = editcount+1
              WHERE postid = '".intval($edit)."'";
        $sql = serendipity_db_query($q);

        $q = "UPDATE {$serendipity['dbPrefix']}dma_forum_threads SET
                    announce = '".intval($announce)."'
              WHERE threadid = '".intval($threadid)."'";
        $sql = serendipity_db_query($q);


        unset($_GET);
        $_GET['boardid'] = intval($boardid);
        $_GET['threadid'] = intval($threadid);
        $_GET['page'] = intval($page);
        return $edit;
    }



    function DMA_forum_InsertThread($boardid, $authorname, $title, $message, $announce=0, $frommail, $fromname, $pageurl, $admin_notify=true) {
        global $serendipity;
        if (serendipity_userLoggedIn()) {
            $authorname = $serendipity['serendipityUser'];
            $KEXTRA = ", authorid";
            $VEXTRA = ", '".$serendipity['authorid']."'";
            $EEXTRA = " lastauthorid = '".$serendipity['authorid']."', ";
        } else {
            $KEXTRA = "";
            $VEXTRA = "";
            $EEXTRA = "";
        }
        $now = time();
        $q = "INSERT INTO {$serendipity['dbPrefix']}dma_forum_threads (
                        boardid,
                        title,
                        lastposttime,
                        announce
            ) VALUES (
                        '".intval($boardid)."',
                        '".serendipity_db_escape_string(trim($title))."',
                        '".$now."',
                        '".$announce."'
            )";
        $sql = serendipity_db_query($q);
        $threadid = serendipity_db_insert_id('dma_forum_threads', 'threadid');
        $q = "INSERT INTO {$serendipity['dbPrefix']}dma_forum_posts (
                    threadid,
                    postdate,
                    title,
                    message,
                    authorname".$KEXTRA."
        ) VALUES (
                    '".intval($threadid)."',
                    '".$now."',
                    '".serendipity_db_escape_string(trim($title))."',
                    '".serendipity_db_escape_string(trim($message))."',
                    '".serendipity_db_escape_string(trim($authorname))."'".$VEXTRA."
        )";
        $sql = serendipity_db_query($q);
        $postid = serendipity_db_insert_id('dma_forum_posts', 'postid');

        if (isset($_SESSION['forum_visited']) && intval($_SESSION['forum_visited']) >= 1) {
            $q = "UPDATE {$serendipity['dbPrefix']}dma_forum_users SET posts = posts+1, lastpost = '".$postid."' WHERE authorid = '".intval($serendipity['authorid'])."'";
            serendipity_db_query($q);
        }

        DMA_forum_CheckLastProperties(intval($boardid));
        $_SESSION['lastthreadtext'] = trim($message);
        $_SESSION['lastposttime'] = time();
		
        $fromname = DMA_strip($fromname);
        $frommail = DMA_strip($frommail);
        
		if ($admin_notify === true) {
            $subject = str_replace("{postauthor}", trim($authorname), PLUGIN_FORUM_EMAIL_NOTIFY_SUBJECT);
            $subject = str_replace("{blogurl}", $serendipity['baseURL'], $subject);

            $body = PLUGIN_FORUM_EMAIL_NOTIFY_PART1 . PLUGIN_FORUM_EMAIL_NOTIFY_PART2 . PLUGIN_FORUM_EMAIL_NOTIFY_PART3;

            $body = str_replace("{postauthor}", trim($authorname), $body);
            $body = str_replace("{forumurl}", $serendipity['baseURL'] . "index.php?serendipity[subpage]=" . $pageurl, $body);
            $body = str_replace("{threadtitle}", (function_exists('serendipity_specialchars') ? serendipity_specialchars(trim($title)) : htmlspecialchars(trim($title), ENT_COMPAT, LANG_CHARSET)), $body);
            $body = str_replace("{replytext}", (function_exists('serendipity_specialchars') ? serendipity_specialchars(strip_tags(trim($message))) : htmlspecialchars(strip_tags(trim($message)), ENT_COMPAT, LANG_CHARSET)), $body);
            $body = str_replace("{posturl}", $serendipity['baseURL'] . "index.php?serendipity[subpage]=" . $pageurl . "&boardid=".intval($boardid)."&threadid=".intval($threadid), $body);

            $from    = "$fromname <$frommail>";
            $to      = "".$serendipity['blogMail']."";
            $headers  = "From: $from\r\n";
            $headers .= "Reply-To: $frommail\r\n";
            $headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n\r\n";
            mail($to, $subject, $body, $headers);
		}
		
        unset($_GET);
        $_GET['boardid'] = intval($boardid);
        $_GET['threadid'] = intval($threadid);
        return $postid;
    }




    function DMA_forum_DeletePost($boardid, $threadid, $postid, $page=1, $uploaddir="./", $itemsperpage) {
        global $serendipity;
        $q = "DELETE FROM {$serendipity['dbPrefix']}dma_forum_posts
                WHERE postid = '".intval($postid)."'";
        $sql = serendipity_db_query($q);

        $q = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_uploads WHERE postid = '".intval($postid)."'";
        $uploads = serendipity_db_query($q);
        if (is_array($uploads) && count($uploads) >= 1) {
            foreach ($uploads AS $upload) {
                @unlink($uploaddir."/".$upload['sysfilename']);
            }
            $q = "DELETE FROM {$serendipity['dbPrefix']}dma_forum_uploads WHERE postid = '".intval($postid)."'";
            $sql = serendipity_db_query($q);
        }
        $q = "SELECT * {$serendipity['dbPrefix']}dma_forum_posts
                WHERE threadid = '".intval($threadid)."'";
        $posts = serendipity_db_query($q);
        $numposts = count($posts);
        if ($numposts <= 0) {
            $q = "DELETE FROM {$serendipity['dbPrefix']}dma_forum_threads
                    WHERE threadid = '".intval(threadid)."'";
            $sql = serendipity_db_query($q);
        }
        DMA_forum_CheckLastProperties(intval($boardid));
        $sql = "SELECT COUNT(*) FROM {$serendipity['dbPrefix']}dma_forum_posts WHERE threadid='".intval($threadid)."'";
        $postnum = serendipity_db_query($sql);
        $page = ceil(intval($postnum[0][0]) / intval($itemsperpage));
        unset($_GET);
        $_GET['boardid'] = intval($boardid);
        $_GET['threadid'] = intval($threadid);
        $_GET['page'] = intval($page);
    }







    function DMA_forum_DeleteBoards($delboardsarray, $movetoboardid='delete', $uploaddir="./") {
        global $serendipity;
        if ($movetoboardid == 'delete') {
            foreach($delboardsarray AS $delid) {
                $sql = "SELECT threadid FROM {$serendipity['dbPrefix']}dma_forum_threads WHERE boardid = '".$delid."'";
                $threads = serendipity_db_query($sql);
                if (is_array($threads) && count($threads) >= 1) {
                    foreach ($threads AS $threadid) {
                        $q = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_posts WHERE threadid = '".$threadid."'";
                        $posts = serendipity_db_query($q);
                        if (is_array($posts) && count($posts) >= 1) {
                            foreach ($posts AS $post) {
                                $q = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_uploads WHERE postid = '".intval($post['postid'])."'";
                                $uploads = serendipity_db_query($q);
                                if (is_array($uploads) && count($uploads) >= 1) {
                                    foreach ($uploads AS $upload) {
                                        @unlink($uploaddir."/".$upload['sysfilename']);
                                    }
                                    $q = "DELETE FROM {$serendipity['dbPrefix']}dma_forum_uploads WHERE postid = '".intval($post['postid'])."'";
                                    $sql = serendipity_db_query($q);
                                }
                            }
                            $sql = "DELETE FROM {$serendipity['dbPrefix']}dma_forum_posts WHERE threadid = '".$threadid."'";
                            serendipity_db_query($sql);
                        }
                        $sql = "DELETE FROM {$serendipity['dbPrefix']}dma_forum_threads WHERE threadid = '".$threadid."'";
                        serendipity_db_query($sql);
                    }
                }
                $sql = "DELETE FROM {$serendipity['dbPrefix']}dma_forum_boards WHERE boardid = '".$delid."'";
                serendipity_db_query($sql);
            }
        } else {
            $postcount = 0;
            $threadcount = 0;
            foreach($delboardsarray AS $delid) {
                $sql = "UPDATE {$serendipity['dbPrefix']}dma_forum_threads
                          SET boardid = '".intval($movetoboardid)."'
                        WHERE boardid = '".$delid."'";
                serendipity_db_query($sql);
            }
            $sql = "DELETE FROM {$serendipity['dbPrefix']}dma_forum_boards WHERE boardid = '".$delid."'";
            serendipity_db_query($sql);
            DMA_forum_CheckLastProperties(intval($movetoboardid));
        }
        $sql = "SELECT * FROM {$serendipity['dbPrefix']}dma_forum_boards ORDER BY sortorder";
        $boards = serendipity_db_query($sql);
        if (is_array($boards) && count($boards) >= 1) {
            for($idx = 0; $idx < count($boards); $idx++) {
                $boards[$idx]['sortorder'] = $idx;
            }
            foreach($boards as $board) {
                $key = intval($board['boardid']);
                serendipity_db_query("UPDATE {$serendipity['dbPrefix']}dma_forum_boards SET sortorder = {$board['sortorder']} WHERE boardid='$key'");
            }
        }
    }








?>
