<?php # $Id$

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}
include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_browserid extends serendipity_event
{
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',        PLUGIN_BROWSERID_NAME);
        $propbag->add('description', PLUGIN_BROWSERID_DESC);
        $propbag->add('stackable',   false);
        $propbag->add('author',      'Grischa Brockhaus');
        $propbag->add('version',     '1.1');
        $propbag->add('requirements',  array(
            'serendipity' => '1.6',
            'smarty'      => '2.6.7',
            'php'         => '5.1.3'
        ));
        $propbag->add('groups', array('BACKEND_USERMANAGEMENT'));
        $propbag->add('event_hooks', array(
            'backend_login'             => true,
            'backend_login_page'        => true,
            'backend_header'			=> true,
        	'external_plugin'			=> true,
        ));

        $propbag->add('configuration', array(
            'plugin_desc',
        ));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'plugin_desc':
                $propbag->add('type',        'content');
                $propbag->add('default',     PLUGIN_BROWSERID_DESCRIPTION);
                break;
            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        $title = PLUGIN_BROWSERID_NAME;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;
        static $login_url = null;

        if ($login_url === null) {
            $login_url = $serendipity['baseURL'] . $serendipity['indexFile'] . '?/plugin/loginbox';
        }

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'external_plugin':
                    if ($eventData=="serendipity_event_browserid.js") {
                        header('Content-Type: text/javascript');
                        echo file_get_contents(dirname(__FILE__). '/serendipity_event_browserid.js');
                    }
                    else if ($eventData=="browserid_signin.png") {
                        header('Content-Type: image/png');
                        echo file_get_contents(dirname(__FILE__). '/browserid_signin.png');
                    }
                    else if ($eventData=="serendipity_event_browserid_verify") {
                        $this->verify();
                    }
                    break;
                    
                case 'backend_login_page':
                    $this->print_loginpage($eventData);
                    break;

                case 'backend_login':
                    if ($eventData) {
                        return true;
                    }
                    if ($_SESSION['serendipityAuthedUser'] == true) {
                        $eventData = $this->reauth();
                    }
                    
                    return;
                case 'backend_header':
                    $this->print_backend_header();
                    return true;
                    
                default:
                    return false;
            }
        } else {
            return false;
        }
    }
    
    function verify() {
        global $serendipity;
        
        $url = 'https://browserid.org/verify';
        $assert = $_POST['assert'];
        $params = 'assertion='.$assert.'&audience=' .
                 urlencode($serendipity['baseURL']);
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST,2);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $params);
        $result = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($result);
        if (isset($response) && $response->status=='okay') {
            $email = $response->email;
            $audience = $response->audience;
            if ($audience!=$serendipity['baseURL']) { // The login has the wrong host!
                $response->status = 'errorhost';
                $response->message= "Internal error logging you in (wrong host: $audience)";
                $_SESSION['serendipityAuthedUser'] = false;
                @session_destroy();
            }
            else { // host ist correct, check what we have with this email
                $password = md5($email);
                $query = "SELECT DISTINCT a.email, a.authorid, a.userlevel, a.right_publish, a.realname
                     FROM
                       {$serendipity['dbPrefix']}authors AS a
                     WHERE
                       a.email = '{$email}'";
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
                    // Prevent session manupulation:
                    $_SESSION['serendipityBrowserID'] = $this->get_install_token();
                    serendipity_load_configuration($serendipity['authorid']);
                }
                else { // No user found for that email!
                    $response->status = 's9yunknown';
                    $response->message= "Sorry, we don't have a user for $email";
                    $_SESSION['serendipityAuthedUser'] = false;
                    @session_destroy();
                }
                       
                
            }
            $result = json_encode($response);
        }
        echo $result;
    }
    
    function reauth() {
         global $serendipity;
         // Reauth only, if valid session
         if (isset($_SESSION['serendipityBrowserID']) && $_SESSION['serendipityBrowserID']===$this->get_install_token()) {
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
    
    /**
     * Produces or loads a token unique to this installation.
     */
    function get_install_token() {
        $token = $this->get_config("installationtoken");
        if (empty($token)) {
            $token = md5(time());
            $this->set_config("installationtoken", $token);
        }
        return $token;
    }
    
    function print_backend_header() {
        echo '
<script src="https://browserid.org/include.js" type="text/javascript"></script>
';
    }
    
    function print_loginpage(&$eventData) {
        global $serendipity;
        
        $hidden = array('action'=>'admin');
        $bid_title = "Sign-in with BrowserID";
        $local_signin_img = $serendipity['baseURL'] . 'index.php?/plugin/browserid_signin.png';
        $local_js = $serendipity['baseURL'] . 'index.php?/plugin/serendipity_event_browserid.js';
        $verify_url = $serendipity['baseURL'] . 'index.php?/plugin/serendipity_event_browserid_verify';
        
        $eventData['header'] .= '
<!-- browserid start -->
<script type="text/javascript">var browserid_verify="'. $verify_url . '";</script>
<div align="center">
<section><button><img src="' . $local_signin_img . '" alt="' . $bid_title . '" title="' . $bid_title . '"></button></section>
</div>
<script src="' . $local_js . '" type="text/javascript"></script>
<!-- browserid end -->
';

    }
    
    function print_backend_footer() {
        global $serendipity;
        $local_js = $serendipity['baseURL'] . 'index.php?/plugin/serendipity_event_browserid.js';
        echo '
<!-- browserid start -->
<script src="' . $local_js . '" type="text/javascript"></script>
<!-- browserid end -->
';        
    }
}

/* vim: set sts=4 ts=4 expandtab : */
