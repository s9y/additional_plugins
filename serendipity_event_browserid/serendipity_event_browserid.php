<?php # 

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
        $propbag->add('author',      'Grischa Brockhaus, Malte Paskuda');
        $propbag->add('version',     '2.0.1');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0',
            'php'         => '7.0'
        ));
        $propbag->add('groups', array('BACKEND_USERMANAGEMENT'));
        $propbag->add('event_hooks', array(
            'backend_login'             => true,
            'backend_login_page'        => true,
        	'external_plugin'			=> true,
        ));

        $propbag->add('configuration', array(
            'plugin_desc',
        ));

        $propbag->add('legal',    array(
            'services' => array(
                'browserid' => array(
                    'url'  => '#',
                    'desc' => '???'
                ),
            ),
            'frontend' => array(
                'Does something with browserID/portier',
            ),
            'backend' => array(
                'Does something with browserID/portier',
            ),
            'cookies' => array(
                'Does something with browserID/portier, might save cookies',
            ),
            // I do not know if any of this is true
            'stores_user_input'     => true,
            'stores_ip'             => true,
            'uses_ip'               => true,
            'transmits_user_input'  => true
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

        require __DIR__ . '/vendor/autoload.php';
        require_once 'S9yStore.php';
        $verify_url = $serendipity['baseURL'] . 'index.php?/plugin/serendipity_event_browserid_verify';

        $this->portier = new \Portier\Client\Client(
            new \Portier\Client\S9yStore($this),
            $verify_url
        );

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'external_plugin':
                    if ($eventData=="serendipity_event_browserid_auth") {
                        $this->auth($serendipity['POST']['persona_email']);
                    }
                    else if ($eventData=="serendipity_event_browserid_verify") {
                        $this->verify($_POST['id_token']);
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
                    
                default:
                    return false;
            }
        } else {
            return false;
        }
    }
    
    function verify($idToken) {
        global $serendipity;
        $email = $this->portier->verify($idToken);
        $this->login_user($email);
        header("Location: ${_SESSION['serendipity_event_browserid_loginurl']}", true, 303);
    }

    function auth($email) {
        global $serendipity;
        $authUrl = $this->portier->authenticate($email);
        header("Location: $authUrl", true, 303);
    }

    function login_user($email) {
        global $serendipity;
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
            $_SESSION['serendipityPassword']    = $serendipity['serendipityPassword']     = serendipity_hash($email);
            $_SESSION['serendipityEmail']       = $serendipity['serendipityEmail']        = $email;
            $_SESSION['serendipityAuthorid']    = $serendipity['authorid']                = $row['authorid'];
            $_SESSION['serendipityUserlevel']   = $serendipity['serendipityUserlevel']    = $row['userlevel'];
            $_SESSION['serendipityAuthedUser']  = $serendipity['serendipityAuthedUser']   = true;
            $_SESSION['serendipityRightPublish']= $serendipity['serendipityRightPublish'] = $row['right_publish'];
            serendipity_load_configuration($serendipity['authorid']);
        } else { // No user found for that email!
            echo "found no such user";
            $response->status = 's9yunknown';
            $response->message= "Sorry, we don't have a user for $email";
            $_SESSION['serendipityAuthedUser'] = false;
            @session_destroy();
        }
    }
    
    function reauth() {
        global $serendipity;
        // Reauth only, if valid session
        if ($_SESSION['serendipityAuthedUser']) {
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
    
    function print_loginpage(&$eventData) {
        global $serendipity;
        
        $_SESSION['serendipity_event_browserid_loginurl'] = $_SERVER['REDIRECT_SCRIPT_URI'] . '?' . $_SERVER['QUERY_STRING'];
        $auth_url = $serendipity['baseURL'] . 'index.php?/plugin/serendipity_event_browserid_auth';

        echo '<form method="post" action="' . $auth_url . '" style="margin: auto; max-width: 23em; border: 1px solid #aaa; margin-top: 4em; padding: 1em;">
            <fieldset>
            <span class="wrap_legend"><legend>Please enter your email</legend></span>  
            <input name="serendipity[persona_email]" type="email">
            <button type="submit">Login</button>
            </fieldset>
        </form>';
    }

}

/* vim: set sts=4 ts=4 expandtab : */
