<?php # $Id: serendipity_event_email_bot_obfuscator.php,v 1.1 2009/12/10 12:45:38 garvinhicking Exp $

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_email_bot_obfuscator extends serendipity_event
{
    var $title = PLUGIN_EVENT_EMAIL_BOT_OBFUSCATOR_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_EMAIL_BOT_OBFUSCATOR_NAME);
        $propbag->add('description',   PLUGIN_EVENT_EMAIL_BOT_OBFUSCATOR_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Stephan Manske');
        $propbag->add('version',       '1.0');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

		$propbag->add('license', 'GPL');

        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',   array('frontend_display' => true, 'frontend_comment' => true));

        $this->markup_elements = array(
            array(
              'name'     => 'ENTRY_BODY',
              'element'  => 'body',
            ),
            array(
              'name'     => 'EXTENDED_BODY',
              'element'  => 'extended',
            ),

/*			array(
            	'name'     => 'COMMENT',
            	'element'  => 'comment',
            ),

*/            array(
              'name'     => 'HTML_NUGGET',
              'element'  => 'html_nugget',
            )

        );

        $propbag->add('groups', array('ANTISPAM','MARKUP'));

        $conf_array = array();

        foreach($this->markup_elements as $element) {
            $conf_array[] = $element['name'];
        }

        $conf_array[] = 'type';

        $propbag->add('configuration', $conf_array);

        return true;

    }

    function install() {
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function uninstall() {
        serendipity_plugin_api::hook_event('backend_cache_purge', $this->title);
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }


    function generate_content(&$title) {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'type':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_EMAIL_BOT_OBFUSCATOR_TYPE);
                $propbag->add('description',    '');
                $propbag->add('select_values',  array('entity' => PLUGIN_EVENT_EMAIL_BOT_OBFUSCATOR_TYPE_HTML, 'js' => PLUGIN_EVENT_EMAIL_BOT_OBFUSCATOR_TYPE_JS, 'none' => PLUGIN_EVENT_EMAIL_BOT_OBFUSCATOR_TYPE_NONE));
                $propbag->add('default',        'entity');
                break;

        default:
            $propbag->add('type',        'boolean');
            $propbag->add('name',        constant($name));
            $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
            $propbag->add('default', 'true');
        }
        return true;
    }



/* Converts email addresses characters to HTML entities to block spam bots.
*
* @since 0.71
*
* @param string $emailaddy Email address.
* @param int $mailto Optional. Range from 0 to 1. Used for encoding.
* @return string Converted email address.
*
* have a look at LICENSE text!
*/

function antispambot($emailaddy, $mailto=0) {
      $emailNOSPAMaddy = '';
      srand ((float) microtime() * 1000000);
      for ($i = 0; $i < strlen($emailaddy); $i = $i + 1) {
          $j = floor(rand(0, 1+$mailto));
          if ($j==0) {
              $emailNOSPAMaddy .= '&#'.ord(substr($emailaddy,$i,1)).';';
          } elseif ($j==1) {
              $emailNOSPAMaddy .= substr($emailaddy,$i,1);
          } elseif ($j==2) {
              $emailNOSPAMaddy .= '%'.zeroise(dechex(ord(substr($emailaddy, $i, 1))), 2);
          }
      }
      $emailNOSPAMaddy = str_replace('@','&#64;',$emailNOSPAMaddy);
      return $emailNOSPAMaddy;
  }






function anti_callback_none ($matches)
{
  $email = substr ($matches[0], 1);
  return $matches[1].'<a href="mailto:'.$email.'">'.$email.'</a>';
}


function anti_callback_entity ($matches)
{
  $email = substr ($matches[0], 1);
  return $matches[1].'<a href="mailto:'.$this->antispambot ($email).'">'.$this->antispambot ($email).'</a>';
}


function anti_callback_js ($matches)


{
  // Array[0] = email address
  $parts = explode ('@', substr ($matches[0], 1));
  $str = $matches[1].'<script type="text/javascript">';
  $str .= 'var username = "'.$parts[0].'"; var hostname = "'.$parts[1].'";';
  $str .= 'document.write("<a href=" + "mail" + "to:" + username + ';
  $str .= '"@" + hostname + ">" + username + "@" + hostname + "<\/a>")';
  $str .= '</script>';
  return $str;
}

function anti_email_spam ($text)
{

            $type      = $this->get_config('type');

			switch ($type) {
				case "none":
					$anti_callback = "anti_callback_none";
					break;
				case "js" :
					$anti_callback = "anti_callback_js";
					break;

				default:
				case "entity" :
					$anti_callback = "anti_callback_entity";
 					break;

			}

  return preg_replace_callback ('/([> ])[A-Z0-9._-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z.]{2,6}/i', array($this,$anti_callback), $text);

}


    function event_hook($event, &$bag, &$eventData) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_display':

                    foreach ($this->markup_elements as $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], true)) && isset($eventData[$temp['element']]) &&
                            !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                            !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = &$eventData[$temp['element']];

                            $element = $this->anti_email_spam($element);

                        }
                    }
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
?>