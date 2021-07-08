<?php 

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

function escape($message) {
    return (function_exists('serendipity_specialchars') ? serendipity_specialchars($message, ENT_QUOTES) : htmlspecialchars($message, ENT_QUOTES | ENT_COMPAT, LANG_CHARSET));
}

class serendipity_common_openid {

    static function redir_openidserver($openid_url, $store_path, $wfFlag=1) {
        global $serendipity;

        $path_extra = dirname(__FILE__).DIRECTORY_SEPARATOR.'PHP-openid/';
        $path = ini_get('include_path');
        $path = $path_extra . PATH_SEPARATOR . $path;
        ini_set('include_path', $path);
        require_once "Auth/OpenID/Consumer.php";
        require_once "Auth/OpenID/FileStore.php";

        $store = new Auth_OpenID_FileStore($store_path);
        $consumer = new Auth_OpenID_Consumer($store);
        $trust_root = $serendipity['baseURL'];
        switch ($wfFlag) {
            case 1:
                $process_url = $trust_root . 'serendipity_admin.php?serendipity[openidflag]=1';
                break;
            case 3:
                $process_url = $trust_root . 'serendipity_admin.php?serendipity[openidflag]=3'.
                    '&serendipity[adminModule]=event_display&serendipity[adminAction]=profiles';
                break;
            default:
                $process_url = $trust_root . $serendipity['indexFile'] . '?serendipity[subpage]=addopenid&serendipity[openidflag]=2';
        }

        $auth_request = $consumer->begin($openid_url);

        if (!$auth_request) {
            return FALSE;
        }
        
        $auth_request->addExtensionArg('sreg', 'required', 'fullname');
        $auth_request->addExtensionArg('sreg', 'required', 'email');

        $redirect_url = $auth_request->redirectURL($trust_root,
                                                   $process_url);
        header('Status: 302 Found');
        header("Location: ".$redirect_url);
        exit;
    }

    static function reauth_openid() {
         global $serendipity;
         if (isset($_SESSION['serendipityOpenID']) && $_SESSION['serendipityOpenID']) {
              $serendipity['serendipityRealname']     = $_SESSION['serendipityRealname'];
              $serendipity['serendipityUser']         = $_SESSION['serendipityUser'];
              $serendipity['serendipityPassword']     = $_SESSION['serendipityPassword'];
              $serendipity['serendipityEmail']        = $_SESSION['serendipityEmail'];
              $serendipity['authorid']                = $_SESSION['serendipityAuthorid'];
              $serendipity['serendipityUserlevel']    = $_SESSION['serendipityUserlevel'];
              $serendipity['serendipityAuthedUser']   = $_SESSION['serendipityAuthedUser'];
              $serendipity['serendipityRightPublish'] = $_SESSION['serendipityRightPublish'];
              serendipity_load_configuration($serendipity['authorid']);
              return true;
         }
         return false;
    }
    
    static function authenticate_openid($getData, $store_path, $returnData = false) {
        global $serendipity;

        $trust_root = $serendipity['baseURL'] . 'serendipity_admin.php';
         
        $path_extra = dirname(__FILE__).DIRECTORY_SEPARATOR.'PHP-openid';
        $path = ini_get('include_path');
        $path = $path_extra . PATH_SEPARATOR . $path;
        ini_set('include_path', $path);
        require_once("Auth/OpenID/Consumer.php");
        require_once("Auth/OpenID/FileStore.php");
        require_once("Auth/OpenID/SReg.php");
        require_once("Auth/OpenID/PAPE.php");
        $store = new Auth_OpenID_FileStore($store_path);
        $consumer = new Auth_OpenID_Consumer($store);
        $response = $consumer->complete($trust_root); //, $getData);
        
        if ($response->status == Auth_OpenID_CANCEL) {
            $success = 'Verification cancelled.';
        } else if ($response->status == Auth_OpenID_FAILURE) {
            $success = "OpenID authentication failed: " . $response->message;
        } else if ($response->status == Auth_OpenID_SUCCESS) {
            // This means the authentication succeeded; extract the
            // identity URL and Simple Registration data (if it was
            // returned).
            $openid = $response->getDisplayIdentifier();
            $esc_identity = escape($openid);
    
            $success = sprintf('You have successfully verified ' .
                               '<a href="%s">%s</a> as your identity.',
                               $esc_identity, $esc_identity);
    
            if ($response->endpoint->canonicalID) {
                $escaped_canonicalID = escape($response->endpoint->canonicalID);
                $success .= '  (XRI CanonicalID: '.$escaped_canonicalID.') ';
            }
    
            $sreg_resp = Auth_OpenID_SRegResponse::fromSuccessResponse($response);
    
            $sreg = $sreg_resp->contents();
    
            if (@$sreg['email']) {
                escape($sreg['email']);
                $success .= "  You also returned '".escape($sreg['email']).
                    "' as your email.";
            }
    
            if (@$sreg['nickname']) {
                $success .= "  Your nickname is '".escape($sreg['nickname']).
                    "'.";
            }
    
            if (@$sreg['fullname']) {
                $success .= "  Your fullname is '".escape($sreg['fullname']).
                    "'.";
            }
        }
        
        if (! empty($openid)) {
            if ($returnData) {
                return array('realname'=>$realname, 'email'=>$email, 'openID'=>$openid);
            }
            $password = md5($openid);
            $query = "SELECT DISTINCT a.email, a.authorid, a.userlevel, a.right_publish, a.realname
                     FROM
                       {$serendipity['dbPrefix']}authors AS a, {$serendipity['dbPrefix']}openid_authors AS oa
                     WHERE
                       oa.openid_url = '".serendipity_db_escape_string($openid)."' and 
                       oa.authorid = a.authorid";
           $row = serendipity_db_query($query, true, 'assoc');
           if (is_array($row)) {
               serendipity_setCookie('old_session', session_id());
               serendipity_setAuthorToken();
               $_SESSION['serendipityUser']        = $serendipity['serendipityUser']         = $row['realname'];
               $_SESSION['serendipityPassword']    = $serendipity['serendipityPassword']     = $password;
               $_SESSION['serendipityEmail']       = $serendipity['serendipityEmail']        = $email;
               $_SESSION['serendipityAuthorid']    = $serendipity['authorid']                = $row['authorid'];
               $_SESSION['serendipityUserlevel']   = $serendipity['serendipityUserlevel']    = $row['userlevel'];
               $_SESSION['serendipityAuthedUser']  = $serendipity['serendipityAuthedUser']   = true;
               $_SESSION['serendipityRightPublish']= $serendipity['serendipityRightPublish'] = $row['right_publish'];
               $_SESSION['serendipityRealname']    = $serendipity['serendipityRealname']     = $row['realname'];
               $_SESSION['serendipityOpenID'] = true;
               serendipity_load_configuration($serendipity['authorid']);
               return true;
           } else {
               $_SESSION['serendipityAuthedUser'] = false;
               @session_destroy();
           }
        }
        return false;
   }

    static function getOpenID($userID, $checkExist=false) {
        global $serendipity;
        $q = "SELECT openid_url, authorid FROM {$serendipity['dbPrefix']}openid_authors WHERE authorid = " . (int)$userID;
        $author = serendipity_db_query($q, true);
        if (is_array($author)) {
            if ($checkExist) {
                return $author['authorid'];
            } elseif (! empty($author['openid_url'])) {
                return $author['openid_url'];
            }
        }
        return '';
    }

    static function updateOpenID($openid_url, $authorID) {
        global $serendipity;

        if (!is_array(serendipity_db_query("SELECT username FROM {$serendipity['dbPrefix']}openid_authors LIMIT 1", true, 'both', false, false, false, true))) {
            serendipity_db_schema_import("CREATE TABLE {$serendipity['dbPrefix']}openid_authors (
              openid_url varchar(255) default null,
              hash varchar(32) default null,
              authorid int(11) default '0'
            );");
        }

        $hash = md5($openid_url);
        if (serendipity_common_openid::getOpenID($authorID, true)) {
            $retVal = serendipity_db_update('openid_authors',
                                            array('authorid'=>$authorID),
                                            array('openid_url'=> $openid_url,
                                                  'hash'=> $hash));
        } else {
            $retVal = serendipity_db_insert('openid_authors',
                                            array('openid_url'=> $openid_url,
                                            'hash'=> $hash,
                                            'authorid'=>$authorID));
        }
        return ($retVal===true)?true:false;
    }

    static function load_account_selectbox() {
        global $serendipity;
        
        $query = "SELECT DISTINCT a.realname, a.username, oa.openid_url
                 FROM
                   {$serendipity['dbPrefix']}authors AS a, {$serendipity['dbPrefix']}openid_authors AS oa
                 WHERE
                   oa.authorid = a.authorid";
       $rows = serendipity_db_query($query);
       
       // Singnal no existing OpenID URL.
       if (!is_array($rows) || count($rows)==0) return false;
       
       $result = '<select name="serendipity[openid_url]">';
       foreach ($rows as $row) {
           $result .= '<option value="' . $row['openid_url'] . '">';
           if (!empty($row['realname'])) {
               $result .= $row['realname'];
           }
           else {
               $result .= $row['username'];
           }
           $result .= '</option>';
       }
       $result .= '</select> ';
       return $result;
    }
    
    static function loginform($url, $hidden = array(), $useAutorSelector = true) {
        global $serendipity;
        
        $imgopenid = $serendipity['baseURL'] . 'index.php?/plugin/openid.png';
        
        // Check, if we have any user with OpenID configured
        $select = serendipity_common_openid::load_account_selectbox();
        if ($select===false) { // No we don't. Say so
            $result  = '<div class="no_openid_user">';
            $result .= '<img src="' . $imgopenid . '" alt="OpenID">';
            $result .= '<p>' . PLUGIN_OPENID_LOGIN_NOOPENID . '</p></div>';
            return $result;
        }
        
        $imggoogle = $serendipity['baseURL'] . 'index.php?/plugin/oid_google.png';
        $imgyahoo = $serendipity['baseURL'] . 'index.php?/plugin/oid_yahoo.png';
        $imgaol = $serendipity['baseURL'] . 'index.php?/plugin/oid_aol.png';
        
        $form = '';
        
        // We need two forms in order to allow ENTER in the input line
        $form .= '<form name="openid" id="openid" method="post" action="' . $url . '">';
        $form .='<input type="hidden" name="serendipity[openidflag]" value="1" />';
        foreach($hidden AS $key => $val) {
            $form .= '<input type="hidden" name="serendipity[' . $key . ']" value="' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($val) : htmlspecialchars($val, ENT_COMPAT, LANG_CHARSET)) . '" />';
        }
        $form .= '<img src="' . $imgopenid . '" alt="OpenID"> ';
        
        if ($useAutorSelector) {
            $form .= $select;
            $form .= '<input type="submit" name="openIDLogin" value="Login with OpenID" />';
        }
        if (!$useAutorSelector) {
            $form .= '<input type="text" size="40" name="serendipity[openid_url]" value="" placeholder="' . PLUGIN_OPENID_LOGIN_INPUT . '"/>';
            $form .= '<input type="submit" name="openIDLogin" value="Login" />';
            $form .= '</form>';
            
            $form .= '<form name="openid" id="openid" method="post" action="' . $url . '">';
            $form .='<input type="hidden" name="serendipity[openidflag]" value="1" />';
            foreach($hidden AS $key => $val) {
                $form .= '<input type="hidden" name="serendipity[' . $key . ']" value="' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($val) : htmlspecialchars($val, ENT_COMPAT, LANG_CHARSET)) . '" />';
            }
            $form .= '<input name="openIDLoginGoogle" type="image" src="' . $imggoogle . '" alt="' . PLUGIN_OPENID_LOGIN_WITH_GOOGLE . '" title="' . PLUGIN_OPENID_LOGIN_WITH_GOOGLE .'"/> ';
            $form .= '<input name="openIDLoginYahoo" type="image" src="' . $imgyahoo . '" alt="' . PLUGIN_OPENID_LOGIN_WITH_YAHOO . '" title="' . PLUGIN_OPENID_LOGIN_WITH_YAHOO .'"/> ';
            $form .= '<input name="openIDLoginAol" type="image" src="' . $imgaol . '" alt="' . PLUGIN_OPENID_LOGIN_WITH_AOL . '" title="' . PLUGIN_OPENID_LOGIN_WITH_AOL .'"/> ';
        }
        $form .= '</form>';
        
        return $form;
    }
}
