<?php

if (IN_serendipity !== true) {
  die("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_proxy_realip extends serendipity_event {

  var $title = PLUGIN_EVENT_PROXY_REALIP_NAME;

  function introspect(&$propbag) {
    global $serendipity;

    $propbag->add('name', PLUGIN_EVENT_PROXY_REALIP_NAME);
    $propbag->add('description', PLUGIN_EVENT_PROXY_REALIP_DESC);
    $propbag->add('stackable', false);
    $propbag->add('author', 'kleinerChemiker');
    $propbag->add('version', '1.0.3');
    $propbag->add('requirements', array('serendipity' => '1.6.2', 'smarty' => '2.6.7', 'php' => '5.3.0'));
    $propbag->add('groups', array('BACKEND_FEATURES'));
    $propbag->add('event_hooks', array('frontend_configure' => true));

    $conf_array = array();
    $conf_array[] = 'realip_var';

    $propbag->add('configuration', $conf_array);
  }

  function introspect_config_item($name, &$propbag) {
    switch ($name) {
      case 'realip_var' :
        $propbag->add('type', 'string');
        $propbag->add('name', PLUGIN_EVENT_PROXY_REALIP);
        $propbag->add('description', PLUGIN_EVENT_PROXY_REALIP_VAR_DESC);
        $propbag->add('validate', '/^\$[^;]+$/');
        $propbag->add('default', '$_SERVER[\'X-FORWARDED-FOR\']');
        break;
      default :
        $propbag->add('type', 'boolean');
        $propbag->add('name', constant($name));
        $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
        $propbag->add('default', 'true');
    }
    return true;
  }

  function event_hook($event, &$bag, &$eventData, $addData = null) {

    static $realip_var = NULL;

    $hooks = &$bag->get('event_hooks');

        if ($realip_var === null) {
            $realip_var = $this->get_config('realip_var', '$_SERVER[\'X-FORWARDED-FOR\']');
            $regex = '/^\$_(\w*) ?\[[\'"](\w*)[\'"]\]$/i';
            preg_match($regex, $realip_var, $matches);
            if (strtolower($matches[1]) == 'server') {
                $tmp = $matches[2];
                $realip_ip = filter_var($_SERVER[$tmp], FILTER_VALIDATE_IP);
            } elseif (strtolower($matches[1]) == 'env') {
                $tmp = $matches[2];
                $realip_ip = filter_var($_ENV[$tmp], FILTER_VALIDATE_IP);
            }
        }

    if (isset($hooks[$event])) {
      switch ($event) {
        case 'frontend_configure':
          if ($realip_ip != FALSE) {
            $_SERVER["REMOTE_ADDR"] = $realip_ip;
          }
          break;

        default:
          return false;
      }
    }
    return false;
  }

}

