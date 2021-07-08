<?php # 

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_externalauth extends serendipity_event
{
    var $title = PLUGIN_EVENT_EXTERNALAUTH_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_EXTERNALAUTH_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_EXTERNALAUTH_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking/Justin Alcorn');
        $propbag->add('version',       '1.23');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',    array(
            'backend_auth'       => true,
            'frontend_configure' => true,
            'backend_configure'  => true,
            'backend_loginfail'  => true
        ));
        $propbag->add('configuration', array('enable_ldap', 'enable_logging', 'fail2ban',
					     'host', 'port', 'rdn', 'source', 'userlevel', 'ldap_userlevel_attr',
					     'ldap_tls', 'firstlogin', 'auth_query', 'bind_user', 'bind_password', 'user_wysiwyg'));
        $propbag->add('groups', array('BACKEND_USERMANAGEMENT'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'enable_ldap':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_EXTERNALAUTH_ENABLE_LDAP);
                $propbag->add('description', '');
                $propbag->add('default',     true);
                break;

            case 'enable_logging':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_EXTERNALAUTH_ENABLE_LOGGING);
                $propbag->add('description', '');
                $propbag->add('default',     true);
                break;

            case 'fail2ban':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_EXTERNALAUTH_FAIL2BAN);
                $propbag->add('description', PLUGIN_EVENT_EXTERNALAUTH_FAIL2BAN_DESC);
                $propbag->add('default',     '');
                break;


            case 'firstlogin':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_EXTERNALAUTH_FIRSTLOGIN);
                $propbag->add('description', PLUGIN_EVENT_EXTERNALAUTH_FIRSTLOGIN_DESC);
                $propbag->add('default',     true);
                break;

            case 'ldap_tls':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        'LDAP TLS');
                $propbag->add('description', '');
                $propbag->add('default',     false);
                break;

            case 'rdn':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_EXTERNALAUTH_RDN);
                $propbag->add('description', PLUGIN_EVENT_EXTERNALAUTH_RDN_DESC);
                $propbag->add('default',     'uid=%1,ou=people,dc=yourdomain,dc=com');
                break;

            case 'port':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_EXTERNALAUTH_PORT);
                $propbag->add('description', PLUGIN_EVENT_EXTERNALAUTH_PORT_DESC);
                $propbag->add('default',     '');
                break;

            case 'host':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_EXTERNALAUTH_HOST);
                $propbag->add('description', PLUGIN_EVENT_EXTERNALAUTH_HOST_DESC);
                $propbag->add('default',     'localhost');
                break;

            case 'source':
                $propbag->add('type',        'select');
                $propbag->add('name',        PLUGIN_EVENT_EXTERNALAUTH_SOURCE);
                $propbag->add('description', PLUGIN_EVENT_EXTERNALAUTH_SOURCE_DESC);
                $propbag->add('default',     'LDAP');
                $propbag->add('select_values', array('LDAP' => 'LDAP'));
                break;

            case 'userlevel':
                $propbag->add('type',        'select');
                $propbag->add('name',        PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL);
                $propbag->add('description', PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_DESC);
                $propbag->add('default',     USERLEVEL_EDITOR);
                $propbag->add('select_values', array(
                                                USERLEVEL_ADMIN => PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ADMIN,
                                                USERLEVEL_CHIEF => PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_CHIEF,
                                                USERLEVEL_EDITOR => PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_EDITOR,
                                                -1 => PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_DENY
                ));
                break;

            case 'ldap_userlevel_attr':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ATTR);
                $propbag->add('description', PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ATTR_DESC);
                $propbag->add('default',     'serendipity_userlevel');
                break;
  	    // This is for braindead LDAPs where users do not have a consistent naming scheme so that we cannot
	    // use the 'rdn' path but must do a full query to find them :-(
            // e.g. (&(objectcategory=person)(objectclass=user)(sAMAccountName=%1))
            case 'auth_query':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_EXTERNALAUTH_QUERY);
                $propbag->add('description', PLUGIN_EVENT_EXTERNALAUTH_QUERY_DESC);
                $propbag->add('default',     '');
                break;
            case 'bind_user':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_EXTERNALAUTH_BIND_USER);
                $propbag->add('description', PLUGIN_EVENT_EXTERNALAUTH_BIND_USER_DESC);
                $propbag->add('default',     '');
                break;
            case 'bind_password':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_EXTERNALAUTH_BIND_PASSWORD);
                $propbag->add('description', PLUGIN_EVENT_EXTERNALAUTH_BIND_PASSWORD_DESC);
                $propbag->add('default',     '');
                break;
            case 'user_wysiwyg':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_EXTERNALAUTH_USER_WYSIWYG);
                $propbag->add('description', PLUGIN_EVENT_EXTERNALAUTH_USER_WYSIWYG_DESC);
                $propbag->add('default',     true);
                break;

        }
        return true;
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENT_EXTERNALAUTH_TITLE;
    }

    function debugmsg($msg) {
        static $debug = false;

        if ($debug) {
            $fp = fopen('/tmp/s9yldap.log', 'a');
            fwrite($fp, '[' . date('d.m.Y H:i') . '] ' . $msg . "\n");
            fclose($fp);
        }
    }

    function setupDB() {
        global $serendipity;

        $built = $this->get_config('dbl_created', null);
        $fresh = false;
        if (empty($built)) {
            $i = serendipity_db_schema_import("CREATE TABLE {$serendipity['dbPrefix']}loginlog (
                    timestamp int(10) {UNSIGNED} default null,
                    authorid int(11) default '0',
                    action varchar(255) not null default '',
                    ip varchar(255) not null default '',
                    referer varchar(255) not null default '',
                    user_agent varchar(255) not null default '');");
            $this->set_config('dbl_created', 1);
        }
    }

    function set_wysiwyg($author) {
      global $serendipity;
      $result = serendipity_db_query("SELECT authorid FROM ". $serendipity['dbPrefix'] ."authors WHERE username = '". $author ."' LIMIT 1", true, 'assoc');
      if (!is_array($result)) {
	$this->debugmsg('Could not find author: ' . $author);
      } else {
	$authorid = $result['authorid'];
	$result = serendipity_db_query("SELECT value FROM ". $serendipity['dbPrefix'] ."config WHERE name='wysiwyg' AND authorid = '". $authorid ."' LIMIT 1", true, 'assoc');
	if (!is_array($result)) {
 	  serendipity_db_query(sprintf("INSERT INTO {$serendipity['dbPrefix']}config (name, value, authorid) VALUES ('wysiwyg', 'true', '%s')",
 				       $authorid));
	} else {
	  serendipity_db_query("UPDATE ". $serendipity['dbPrefix'] ."config SET value = 'true' WHERE name='wysiwyg' AND authorid = ". $authorid);
	}
      }
    }

    function logger($type = 'frontend_login', $eventData = array()) {
        global $serendipity;
        
        $f2b = $this->get_config('fail2ban');
        if ($f2b != '') {
            $fp = fopen($f2b, 'a');

            if ($type == 'fail') {
                if (empty($eventData['user'])) return false;
                if ($this->failtrack) return false;
                $this->failtrack = true;
                $msg = date('M d H:i:s ') . $_SERVER['HTTP_HOST'] . ' s9y[' . $_SERVER['REMOTE_PORT'] . $eventData['mode'] . ']: auth failure username: ' . $eventData['user'] . /*' password ' . $eventData['pass'] . */ ' from ' . $_SERVER['REMOTE_ADDR'] . ' / ' . $_SERVER['REQUEST_URI'] . " (" . serialize($eventData['ext']) . ")\n";
            } elseif (serendipity_userLoggedIn() && !$_SESSION['login_tracked_' . $type]) {
                $msg = date('M d H:i:s ') . $_SERVER['HTTP_HOST'] . ' s9y[' . $_SERVER['REMOTE_PORT'] . ']: auth okay: ' . $serendipity['serendipityUser'] . ' from ' . $_SERVER['REMOTE_ADDR'] . ' / ' . $_SERVER['REQUEST_URI'] . "\n";
            }
            fwrite($fp, $msg);
            fclose($fp);
        }
        
        if ($type == 'fail') return false;

        if (!serendipity_userLoggedIn()) {
            return false;
        }

        if ($_SESSION['login_tracked_' . $type]) {
           return false;
        }

        $timestamp = time();
        $authorid  = (int)$serendipity['authorid'];
        $referer   = serendipity_db_escape_string($_SERVER['HTTP_REFERER']);
        $ip        = serendipity_db_escape_string($_SERVER['REMOTE_ADDR']);
        $ua        = serendipity_db_escape_string($_SERVER['HTTP_USER_AGENT']);
        $i = serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}loginlog (timestamp, authorid, action, ip, referer, user_agent)
                                   VALUES ($timestamp, $authorid, '$type', '$ip', '$referer', '$ua')");
        $_SESSION['login_tracked_' . $type] = true;
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_configure':
                    if (!serendipity_db_bool($this->get_config('enable_logging'))) {
                        return true;
                    }

                    $this->setupDB();
                    $this->logger();
                    break;

                case 'backend_configure':
                    if (!serendipity_db_bool($this->get_config('enable_logging'))) {
                        return true;
                    }

                    $this->logger('backend_login');
                    break;

                case 'backend_loginfail':
                    $this->logger('fail', $eventData);
                    break;

                case 'backend_auth':
                    if (!serendipity_db_bool($this->get_config('enable_ldap'))) {
                        return true;
                    }

                    $this->debugmsg('Plugin authentication called.');

                    $is_md5 =& $eventData;
                    if ($is_md5) {
                        $md5_password = $addData['password'];
                    } else {
                        $md5_password = md5($addData['password']);
                    }

                    if ($_SESSION['serendipityAuthedUser'] == true && serendipity_db_bool($this->get_config('firstlogin'))) {
                        $this->debugmsg('Already authenticated, do not need to do that again');
                        return true;
                    }

                    switch($this->get_config('source')) {
                        case 'LDAP':
                        default:
                            $this->debugmsg('LDAP auth started.');

                            if (!function_exists('ldap_connect')) {
                                $this->debugmsg('No LDAP PHP support!');
                                return false;
                            }

                            $port = $this->get_config('port');
                            if (!empty($port)) {
                                $ds = ldap_connect($this->get_config('host'), $port);
                            } else {
                                $ds = ldap_connect($this->get_config('host'));
                            }

                            $this->debugmsg('LDAP connection to ' . $this->get_config('host') . ': ' . print_r($ds, true));

                            if ($ds) {
                                ldap_set_option($ds,LDAP_OPT_PROTOCOL_VERSION, 3);
				// The following line is needed for MSAD and do no harm elsewhere
                                ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
                                $this->debugmsg('LDAP connection successful.');
                                if (serendipity_db_bool($this->get_config('ldap_tls'))) {
                                    ldap_start_tls($ds);
                                }

				if ($this->get_config('auth_query') == '') { // Standard LDAP with anonymous access
				  $rdn = str_replace(array('%1', '%2', '%3'),
						     array($addData['username'], $addData['password'], $md5_password),
						     $this->get_config('rdn')
						     );
				  $this->debugmsg('LDAP bind call: ' . $rdn);
				  if ($valid = @ldap_bind($ds, $rdn, $addData['password'])) {
                                    $srch="(objectclass=*)";
                                    $attributes=array("objectclass","mail",$this->get_config('ldap_userlevel_attr'));
                                    if ($res = @ldap_read($ds,$rdn,$srch,$attributes)) {
				      $e = ldap_first_entry($ds,$res);
				      $attr = ldap_get_attributes($ds,$e);
				      $userlevel_attr = $this->get_config('ldap_userlevel_attr');
				      if ($attr[$userlevel_attr] > -1) {
					$valid_userlevel = $attr[$userlevel_attr][0];
				      } else {
					$valid_userlevel = $this->get_config('userlevel');
				      }
                                    }
				  }
				} else { // LDAP with protected access and messy schema
				  $password = $addData['password'];
				  //convert password from possible iso-8859 to utf8
				  //$password = utf8_encode($password);
				  if ($this->get_config('bind_user')
				      && ($valid = @ldap_bind($ds, $this->get_config('bind_user'), $this->get_config('bind_password')))) {
				    $auth_query = str_replace(array('%1', '%2', '%3'),
							      array($addData['username'], $password, $md5_password),
							      $this->get_config('auth_query'));
				    $this->debugmsg('$auth_query = ' . $auth_query);
				    if ($r = @ldap_search($ds, $this->get_config('rdn'), $auth_query)) {
				      $result = @ldap_get_entries( $ds, $r);
				      if ($result[0]) {
					$attr = $result[0];
					if (@ldap_bind( $ds, $attr['dn'],$password) ) { // OK
					  $userlevel_attr = $this->get_config('ldap_userlevel_attr');
					  if ($attr[$userlevel_attr] > -1) {
					    $valid_userlevel = $attr[$userlevel_attr][0];
					  } else {
					    $valid_userlevel = $this->get_config('userlevel');
					  }
					} else {
					  $this->debugmsg('Wrong Password');
					}
				      } else {
					$this->debugmsg('Invalid Username');
				      }
				    } else {
				      $this->debugmsg('LDAP Search failed');
				    }
				  } else {	
				    $this->debugmsg('Wrong LDAP Tool Account');
				  }
				}
				if ($valid) {
				  if ($valid_userlevel > -1) {
				    $this->debugmsg('Updating author! username='.$addData['username'].', email='.$attr["mail"][0].' realname='.$attr["name"][0]);
				    // If the ldap user exists and the password is correct, and the user has a valid userlevel OR the default userlevel is valid,
				    //    update the user's record or create it if it doesn't exist.
				    serendipity_db_query("UPDATE {$serendipity['dbPrefix']}authors
                                                 SET password = '" . serendipity_db_escape_string($md5_password) . "', userlevel = " . $valid_userlevel .
							 " WHERE username = '" . serendipity_db_escape_string($addData['username']) . "'");
				    if (serendipity_db_matched_rows() == 0 ) {
				      // create a new one
				      serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}authors (username, password, email, mail_comments, mail_trackbacks, userlevel, realname)
                                                           VALUES ('". serendipity_db_escape_string($addData['username']) ."', '". serendipity_db_escape_string($md5_password) . "', '" . serendipity_db_escape_string($attr["mail"][0]) . "', 1, 1, " . $valid_userlevel . ", '" . serendipity_db_escape_string($attr["name"][0]) . "')");
				      if ($this->get_config('user_wysiwyg')) {
					 $this->set_wysiwyg(serendipity_db_escape_string($addData['username']));
				      }				      
				    }
				  } else {
				    $this->debugmsg('Updating author, invalidating login.');
				    // If the username and password are correct in the ldap server, but the userlevel is set to DENY, invalidate the SQL user.
				    serendipity_db_query("UPDATE {$serendipity['dbPrefix']}authors
                                                 SET password = '" . serendipity_db_escape_string(md5(time())) . "'
                                               WHERE username = '" . serendipity_db_escape_string($addData['username']) . "'");
				  }
				  // if account does not exist in ldap server, or password is incorrect, return silently
				  // N.B. - this means that disabling a user in the LDAP server by changing the password will NOT disable the user in the SQL table.
                                } // end of if ($valid)
                                ldap_close($ds);
                            }
                            $this->debugmsg('LDAP connection close.');
                            break; // case source ldap (and default)
                    } // switch source

                    return true;
                    break; // case event backend_auth

                default:
                    return false;
                    break;
            } // switch event
        } else {
            return false;
        } // isset hooks 'event'
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>
