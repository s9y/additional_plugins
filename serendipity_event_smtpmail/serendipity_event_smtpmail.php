<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_smtpmail extends serendipity_event
{
    var $title = PLUGIN_EVENT_SMTPMAIL_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_SMTPMAIL_NAME);
        $propbag->add('description',   PLUGIN_EVENT_SMTPMAIL_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'kleinerChemiker');
        $propbag->add('version',       '0.13.0');
        $propbag->add('license',       'GPL');
        $propbag->add('requirements',  array(
            'serendipity' => '1.3',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',    array(
            'backend_sendmail' => true
        ));
        $propbag->add('groups', array('BACKEND_FEATURES'));

		$conf_array = array();
		$conf_array[] = 'smtpmail_smtp_server';
		$conf_array[] = 'smtpmail_smtp_port';
		$conf_array[] = 'smtpmail_auth';
		$conf_array[] = 'smtpmail_secure';
		$conf_array[] = 'smtpmail_pop3_server';
		$conf_array[] = 'smtpmail_pop3_port';
		$conf_array[] = 'smtpmail_user';
		$conf_array[] = 'smtpmail_passwd';
		$propbag->add('configuration', $conf_array);

        $propbag->add('legal',    array(
            'services' => array(
                'SMTP proxy' => array(
                    'url'  => '#',
                    'desc' => 'The configured SMTP proxy will receive the content of all emails'
                ),
            ),
            'frontend' => array(
            ),
            'backend' => array(
                'All emails from this blog are send through a configured SMTP proxy and can possibly be logged there.'
            ),
            'cookies' => array(
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => false,
            'transmits_user_input'  => true
        ));

    }

	function introspect_config_item($name, &$propbag) {
		switch($name) {
			case 'smtpmail_smtp_server':
				$propbag->add('type', 'string');
				$propbag->add('name', PLUGIN_EVENT_SMTPMAIL_SMTP_SERVER);
				$propbag->add('description', PLUGIN_EVENT_SMTPMAIL_SMTP_SERVER_DESC);
			break;

			case 'smtpmail_smtp_port':
				$propbag->add('type', 'string');
				$propbag->add('name', PLUGIN_EVENT_SMTPMAIL_SMTP_PORT);
				$propbag->add('description', PLUGIN_EVENT_SMTPMAIL_SMTP_PORT_DESC);
				$propbag->add('validate', 'number');
				$propbag->add('default', 25);
			break;

			case 'smtpmail_auth':
				$propbag->add('type', 'select');
				$propbag->add('name', PLUGIN_EVENT_SMTPMAIL_AUTH);
				$propbag->add('description', PLUGIN_EVENT_SMTPMAIL_AUTH_DESC);
				$propbag->add('select_values', array(
					0 => 'none',
					1 => 'POP3 before SMTP',
					2 => 'SMTP AUTH',
				));
				$propbag->add('default', 0);
			break;

			case 'smtpmail_secure':
				$propbag->add('type', 'select');
				$propbag->add('name', PLUGIN_EVENT_SMTPMAIL_SECURE);
				$propbag->add('description', PLUGIN_EVENT_SMTPMAIL_SECURE_DESC);
				$propbag->add('select_values', array(
					0 => 'none',
					'ssl' => 'SSL',
					'tls' => 'TLS',
				));
				$propbag->add('default', 0);
			break;

			case 'smtpmail_pop3_server':
				$propbag->add('type', 'string');
				$propbag->add('name', PLUGIN_EVENT_SMTPMAIL_POP3_SERVER);
				$propbag->add('description', PLUGIN_EVENT_SMTPMAIL_POP3_SERVER_DESC);
			break;

			case 'smtpmail_pop3_port':
				$propbag->add('type', 'string');
				$propbag->add('name', PLUGIN_EVENT_SMTPMAIL_POP3_PORT);
				$propbag->add('description', PLUGIN_EVENT_SMTPMAIL_POP3_PORT_DESC);
				$propbag->add('validate', 'number');
				$propbag->add('default', 110);
			break;

			case 'smtpmail_user':
				$propbag->add('type', 'string');
				$propbag->add('name', PLUGIN_EVENT_SMTPMAIL_USER);
				$propbag->add('description', PLUGIN_EVENT_SMTPMAIL_USER_DESC);
			break;

			case 'smtpmail_passwd':
				$propbag->add('type', 'string');
				$propbag->add('name', PLUGIN_EVENT_SMTPMAIL_PASSWD);
				$propbag->add('description', PLUGIN_EVENT_SMTPMAIL_PASSWD_DESC);
			break;

			default:
				return false;
		}
	return true;
	}

	
    function generate_content(&$title) {
        $title = $this->title;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        if ($event == 'backend_sendmail') {
			# Load phpmailer
			require_once S9Y_INCLUDE_PATH . 'plugins/serendipity_event_smtpmail/vendor/autoload.php';

			# Login to POP3 Server if Auth is "POP3 before SMTP"
			if ($this->get_config('smtpmail_auth') == 1) {
				$pop = new PHPMailer\PHPMailer\POP3();
				$pop->Authorise($this->get_config('smtpmail_pop3_server'), $this->get_config('smtpmail_pop3_port'), false, $this->get_config('smtpmail_user'), $this->get_config('smtpmail_passwd'), 0);
			}
			
			$mail = new PHPMailer\PHPMailer\PHPMailer();
			$mail->IsSMTP();
			
			# Activate Auth if Auth is "SMTP AUTH"
			if ($this->get_config('smtpmail_auth') == 2) {
				$mail->SMTPAuth = true;
				if ($this->get_config('smtpmail_auth') != 0) {$mail->SMTPSecure = $this->get_config('smtpmail_secure');}
				$mail->Username   = $this->get_config('smtpmail_user');
				$mail->Password   = $this->get_config('smtpmail_passwd');
			}
			
			$mail->IsHTML(false);
			$mail->Host     = $this->get_config('smtpmail_smtp_server');
			$mail->Port     = $this->get_config('smtpmail_smtp_port');
			$mail->setFrom($eventData['fromMail'], $eventData['fromName']);
			$mail->Subject  = $eventData['subject'];
			$mail->Body     = $eventData['message'];
			$mail->CharSet  = LANG_CHARSET;
			if (strpos($eventData['to'], '<') === false ||  strpos($eventData['to'], '>') === false) {
				$mail->AddAddress($eventData['to']);
			}
			else {
				preg_match('/^(.)+ <(.)+>$/',$eventData['to'], $splited_mail);
				$mail->AddAddress($splited_mail[2], $splited_mail[1]);
			}
            $eventData['skip_native'] = true;
			return $mail->send();
        } else {
            return false;
        }
    }
}
