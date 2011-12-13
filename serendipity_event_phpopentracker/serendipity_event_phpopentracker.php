<?php // v1.2, (c) Rene Schmidt

// do NOT change these settings. if you have a suggestion, please drop me a line: http://log.reneschmidt.de
define("S9YPOT_EXCLPAT", "/^(.*)(serendipity\.css(.*)|serendipity_admin|captcha_|plugin\/captcha_)+(.*)$/");
define("S9YPOT_DEFAULT_PATH", "/not/existing/path/to/phpopentracker"); // do not change
define("S9YPOT_DEFAULT_CID", "888");
define("S9YPOT_DEFAULT_FNAME", "phpOpenTracker.php");
define("S9YPOT_ERR_START", "<p class=\"serendipityAdminMsgError\">");
define("S9YPOT_ERR_END", "</p>");

// ini_set("include_path", ini_get('include_path').":/www/reneschmidt.de/www.log.reneschmidt.de/serendipity-alpha/bundled-libs");
// require_once 'Benchmark-1.2.2/Timer.php';

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_phpopentracker extends serendipity_event {

    // check for valid config values
    function cleanup()
    {
      $err = false;
      $bugp= $this->get_config('bugpath');
      $path= $this->get_config('path');

      // allow numeric client ID only
      if($err = preg_match("/^[^0-9]+$/", $this->get_config('client_id')))
        printf("%s%s%s", S9YPOT_ERR_START, S9YPOT_CID_ERROR, S9YPOT_ERR_END);

      // webbug path must be absolute, no trailing slash
      if(!empty($bugp) && $err = !preg_match("/^http(.*)[^\/]$/", $bugp))
        printf("%s%s%s", S9YPOT_ERR_START, S9YPOT_BUGURL_ERROR, S9YPOT_ERR_END);

      // path must be absolute, no trailing slash
      if(!empty($path) && $err = !preg_match("/^[\/].*[^\/]$/", $path))
        printf("%s%s%s", S9YPOT_ERR_START, S9YPOT_PATH_ERROR, S9YPOT_ERR_END);

      // check for an existing POT installation
      $location = sprintf("%s/%s", $this->get_config('path'), $this->get_config('fname'));
      if(!empty($path) && $err = !file_exists($location))
        printf("%s%s%s", S9YPOT_ERR_START, S9YPOT_FNAME_ERROR, S9YPOT_ERR_END);

      // s9y plugin error messaging is quite sub-optimal, print explanation what happened
      // reset all config values so nothing gets logged using a wrong client ID (logging will fail due to wrong path)
      if($err || ( empty($bugp) && empty($path) ) ) {
        $this->set_config('client_id', S9YPOT_DEFAULT_CID);
        $this->set_config('path', S9YPOT_DEFAULT_PATH);
        $this->set_config('fname', S9YPOT_DEFAULT_FNAME);
        $this->set_config('bugpath', S9YPOT_BUGDEFAULT_FNAME);
        printf("%s%s%s", S9YPOT_ERR_START, S9YPOT_ERR_RESET, S9YPOT_ERR_END);
      }

      serendipity_plugin_api::remove_plugin_value($this->instance, array('path', 'fname', 'client_id', 'bugpath'));
    }

    function introspect(&$propbag)
    {
        $propbag->add('name',            S9YPOT_NAME);
        $propbag->add('description',     S9YPOT_DESC);
        $propbag->add('stackable',       false);
        $propbag->add('author',          'Rene Schmidt');
        $propbag->add('version',         '1.6');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('cachable_events', array('frontend_configure' => true));
        $propbag->add('event_hooks',     array('frontend_configure' => true));
        $propbag->add('configuration',   array('path', 'fname', 'client_id', 'bugpath'));
        $propbag->add('groups', array('STATISTICS'));
    }


    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'client_id':
                $propbag->add('type',          'string');
                $propbag->add('name',          S9YPOT_CID);
                $propbag->add('description',   S9YPOT_CID_DESC);
                $propbag->add('default',       S9YPOT_DEFAULT_CID);
                break;
            case 'path':
                $propbag->add('type',          'string');
                $propbag->add('name',          S9YPOT_PATH);
                $propbag->add('description',   S9YPOT_PATH_DESC);
                $propbag->add('default',       S9YPOT_DEFAULT_PATH);
                break;
            case 'fname':
                $propbag->add('type',          'string');
                $propbag->add('name',          S9YPOT_FNAME);
                $propbag->add('description',   S9YPOT_FNAME_DESC);
                $propbag->add('default',       S9YPOT_DEFAULT_FNAME);
                break;
            case 'bugpath':
                $propbag->add('type',          'string');
                $propbag->add('name',          S9YPOT_BUGFNAME);
                $propbag->add('description',   S9YPOT_BUGFNAME_DESC);
                $propbag->add('default',       S9YPOT_BUGDEFAULT_FNAME);
                break;
        }
        return true;
    }


    function event_hook($event, &$bag, &$eventData) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (!isset($hooks[$event]))
          return false;

        $curr = $_SERVER['REQUEST_URI'];

        switch($event) {
          case 'frontend_configure':

            // Quit if necessary
            if(preg_match(S9YPOT_EXCLPAT, $curr)) return false;

            // Now find out whether to use direct API call
            $path = $this->get_config('path');
            if(!empty($path))
            {
              ini_set("include_path", ini_get('include_path').":".$path);
              if(@include($this->get_config('fname')))
              {
                phpOpenTracker::log(array('client_id' => $this->get_config('client_id'), 'document' => $curr));
                #print("<!-- phpOpenTracker direct API call -->");
                return true;
              }
            }

            // Use web bug
            $bugp = $this->get_config('bugpath');
            if(!empty($bugp))
            {
              print("<!-- Using phpOpenTracker web bug -->");

              require_once S9Y_PEAR_PATH . 'Smarty/libs/' . 'Smarty.class.php';

              $tpl = new Smarty();
              $tpl->template_dir = dirname(__FILE__) . '/';
              $tpl->compile_dir = PATH_SMARTY_COMPILE;
              $tpl->assign( 'client_id', $this->get_config('client_id') );
              $tpl->assign( 'webbugimageurl', $bugp );
              print( $tpl->fetch( 'phpopentracker_webbug.js.tpl' ) );

              return true;
            }

            return false;
            break;

          default:
            return false;
        }
    }
}

?>
