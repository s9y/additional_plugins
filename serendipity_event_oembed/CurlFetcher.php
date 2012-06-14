<?php
class CurlFetcher {

    static public function file_get_contents($fileurl, $allow_curl =TRUE) {
        $max_redirects = 5;
        if (defined('OEMBED_USE_CURL') && OEMBED_USE_CURL && defined('CURLOPT_URL')) {
            $ch = curl_init();
            $timeout = 5; // 0 wenn kein Timeout
            curl_setopt($ch, CURLOPT_URL, $fileurl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

            //curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
            //curl_setopt($ch, CURLOPT_MAXREDIRS, $max_redirects );
            //$file_content = curl_exec($ch);
            $file_content = CurlFetcher::curl_exec_follow($ch, $max_redirects);

            curl_close($ch);
        }
        else {
            $context = array ( 'http' => array ( 'method' => 'GET', 'max_redirects' => $max_redirects, ),);
            $file_content = file_get_contents($fileurl, null, stream_context_create($context));
        }
        return $file_content;
    }
    
    /**
     * Handling redirections with curl if safe_mode or open_basedir is enabled. The function working transparent, no problem with header and returntransfer options. You can handle the max redirection with the optional second argument (the function is set the variable to zero if max redirection exceeded).
     * Second parameter values:
     * - maxredirect is null or not set: redirect maximum five time, after raise PHP warning
     * - maxredirect is greather then zero: no raiser error, but parameter variable set to zero
     * - maxredirect is less or equal zero: no follow redirections
     * (see: http://php.net/manual/en/function.curl-setopt.php)
     */
    static private function curl_exec_follow(/*resource*/ $ch, /*int*/ &$maxredirect = null) {
        $mr = $maxredirect === null ? 5 : intval($maxredirect);
        if (ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off')) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $mr > 0);
            curl_setopt($ch, CURLOPT_MAXREDIRS, $mr);
        } else {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            if ($mr > 0) {
                $newurl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

                $rch = curl_copy_handle($ch);
                curl_setopt($rch, CURLOPT_HEADER, true);
                curl_setopt($rch, CURLOPT_NOBODY, true);
                curl_setopt($rch, CURLOPT_FORBID_REUSE, false);
                curl_setopt($rch, CURLOPT_RETURNTRANSFER, true);
                do {
                    curl_setopt($rch, CURLOPT_URL, $newurl);
                    $header = curl_exec($rch);
                    if (curl_errno($rch)) {
                        $code = 0;
                    } else {
                        $code = curl_getinfo($rch, CURLINFO_HTTP_CODE);
                        if ($code == 301 || $code == 302) {
                            preg_match('/Location:(.*?)\n/', $header, $matches);
                            $newurl = trim(array_pop($matches));
                        } else {
                            $code = 0;
                        }
                    }
                } while ($code && --$mr);
                curl_close($rch);
                if (!$mr) {
                    if ($maxredirect === null) {
                        trigger_error('Too many redirects. When following redirects, libcurl hit the maximum amount.', E_USER_WARNING);
                    } else {
                        $maxredirect = 0;
                    }
                    return false;
                }
                curl_setopt($ch, CURLOPT_URL, $newurl);
            }
        }
        return curl_exec($ch);
    }
}