<?php # 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_httpauth extends serendipity_event
{
    var $debugmsg = false;
    var $skip     = false;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_HTTPAUTH_NAME);
        $propbag->add('description',   PLUGIN_HTTPAUTH_BLAHBLAH);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('version',       '1.6');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',   array(
            'frontend_configure' => true,
            'backend_configure'  => true
        ));
        $propbag->add('groups', array('BACKEND_USERMANAGEMENT'));
        $propbag->add('configuration', array('frontend_login', 'remoteuser', 'wildcard', 'authorid', 'userlevel'));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        // Potentially evil plugin. Can only be configured by real admins.
        if ($serendipity['serendipityUserlevel'] < USERLEVEL_ADMIN) {
            return false;
        }

        switch($name) {
            case 'remoteuser':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_HTTPAUTH_REMOTEUSER);
                $propbag->add('description', PLUGIN_HTTPAUTH_REMOTEUSER_DESC);
                $propbag->add('default',     false);
                break;

            case 'frontend_login':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_HTTPAUTH_FRONTEND);
                $propbag->add('description', PLUGIN_HTTPAUTH_FRONTEND_DESC);
                $propbag->add('default',     true);
                break;

            case 'wildcard':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_HTTPAUTH_REMOTEUSER_WILDCARD);
                $propbag->add('description', PLUGIN_HTTPAUTH_REMOTEUSER_WILDCARD_DESC);
                $propbag->add('default',     false);
                break;

            case 'authorid':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_HTTPAUTH_REMOTEUSER_AUTHORID);
                $propbag->add('description', PLUGIN_HTTPAUTH_REMOTEUSER_AUTHORID_DESC);
                $propbag->add('default',     '0');
                break;

            case 'userlevel':
                $propbag->add('type',        'select');
                $propbag->add('name',        PLUGIN_HTTPAUTH_REMOTEUSER_USERLEVEL);
                $propbag->add('description', PLUGIN_HTTPAUTH_REMOTEUSER_USERLEVEL_DESC);
                $propbag->add('default',     USERLEVEL_EDITOR);
                $propbag->add('select_values', array(
                                                USERLEVEL_ADMIN  => USERLEVEL_ADMIN_DESC,
                                                USERLEVEL_CHIEF  => USERLEVEL_CHIEF_DESC,
                                                USERLEVEL_EDITOR => USERLEVEL_EDITOR_DESC));
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        $title       = PLUGIN_HTTPAUTH_NAME;
    }

    function wildcard_auth($user, $authorid = null, $userlevel = null, $publish = 1) {
        global $serendipity;

        if ($authorid === null) {
            $authorid = (int)$this->get_config('authorid');
        }

        if ($userlevel === null) {
            $userlevel = (int)$this->get_config('userlevel');
        }

        $this->debug('Wildcard authenticating ' . $user);
        $_SESSION['serendipityUser']         = $serendipity['serendipityUser']         = $user;
        $_SESSION['serendipityPassword']     = $serendipity['serendipityPassword']     = '';
        $_SESSION['serendipityAuthedUser']   = $serendipity['serendipityAuthedUser']   = true;
        $_SESSION['serendipityUserlevel']    = $serendipity['serendipityUserlevel']    = $userlevel;
        $_SESSION['serendipityRightPublish'] = $serendipity['serendipityRightPublish'] = $publish;
        $_SESSION['serendipityAuthorid']     = $serendipity['authorid']                = $authorid;
        serendipity_load_configuration($serendipity['authorid']);
    }

    function getPassword($user) {
        global $serendipity;

        $this->debug('Checking password.');
        $pass = serendipity_db_query("SELECT password FROM {$serendipity['dbPrefix']}authors WHERE username = '" . serendipity_db_escape_string($user) . "'", true, 'assoc');

        if (!is_array($pass) || !isset($pass['password'])) {
            $this->debug('Password check returned wrong SQL result');
            return false;
        } else {
            $this->debug('Password successfully fetched');
            return $pass['password'];
        }
    }

    function debug($string) {
        static $i = 0;

        if (!$this->debugmsg) {
            return false;
        }

        $i++;
        header('X-HTTPAUTH-MSG-' . $i . ': ' . $string);
    }

    function performLogin($exit = true) {
        global $serendipity;

        $this->debug('PerformLogin called.');
        if ($this->skip) {
            return true;
        }

        $this->skip = true;
        if (serendipity_db_bool($this->get_config('remoteuser')) && !empty($_SERVER['REMOTE_USER'])) {
            $this->debug('Checking RemoteUser value: ' . $_SERVER['REMOTE_USER']);
            if ($pass = $this->getPassword($_SERVER['REMOTE_USER'])) {
                $this->debug('Retrieved password for user. Now authenticating.');
                serendipity_authenticate_author($_SERVER['REMOTE_USER'], $pass, true, true);
                return true;
            } elseif (serendipity_db_bool($this->get_config('wildcard'))) {
                $this->debug('Password retrieval failed. Using wildcard auth.');
                $this->wildcard_auth($_SERVER['REMOTE_USER']);
                return true;
            } else {
                $this->debug('Password retrieval failed, wildcard auth disabled.');
            }
        } else {
            $this->debug('RemoteUser not enabled or empty: ' . $_SERVER['REMOTE_USER']);
        }

        $this->debug('Authenticating ' . $_SERVER['PHP_AUTH_USER']);
        if (!isset($_SERVER['PHP_AUTH_USER']) || !serendipity_authenticate_author($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'], false, false)) {
            header('WWW-Authenticate: Basic realm="' . $serendipity['blogTitle'] . '"');
            header('HTTP/1.0 401 Unauthorized');
            header('Status: 401 Unauthorized');
            if ($exit) {
                $this->debug('Authentication failed. Exiting.');
                exit;
            }
        } else {
            header('X-Authentication: HTTP-AUTH@' . $_SERVER['PHP_AUTH_USER']);
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_configure':
                    if (serendipity_db_bool($this->get_config('frontend_login'))) {
                        $this->debug('Login already performed in frontend_configure. No need to call ' . $event);
                        // Login already performed in frontend_configure.
                        return true;
                    } else {
                        $this->debug('Login performing in ' . $event);
                    }

                    $this->performLogin(false);
                    return true;
                    break;

                case 'frontend_configure':

                    if (!serendipity_db_bool($this->get_config('frontend_login'))) {
                        $this->debug('Login only performed in backend_auth, not ' . $event);
                        // Login shall only be performed in backend_auth.
                        return true;
                    } else {
                        $this->debug('Login performing in ' . $event);
                    }

                    $this->performLogin();

                    return true;
                    break;

                default:
                    return false;
            }
        } else {
            return false;
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
