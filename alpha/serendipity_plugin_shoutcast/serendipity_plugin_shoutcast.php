<?php

/* */


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_plugin_shoutcast extends serendipity_plugin {
    /**
    * serendipity_plugin_shoutcast::introspect()
    *
    * @param  $propbag
    * @return
    */
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name', PLUGIN_SIDEBAR_SHOUTCAST_NAME);
        $propbag->add('description', PLUGIN_SIDEBAR_SHOUTCAST_DESC);
        $propbag->add('author',        'John Mann');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8.4',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',  '1.05');
        $propbag->add('configuration', array('title',
            'server',
            'port'));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
        $propbag->add('stackable',     true);

    } // function
    /**

     * serendipity_plugin_shoutcast::introspect_config_item()
     *
     * @param  $name
     * @param  $propbag
     * @return
     */
  function introspect_config_item($name, &$propbag)
  {
    switch ($name) {
    case 'title':
      $propbag->add('type', 'string');
      $propbag->add('name', PLUGIN_SIDEBAR_SHOUTCAST_TITLE);
      $propbag->add('description', PLUGIN_SIDEBAR_SHOUTCAST_TITLE_BLAHBLAH);
      break;
    case 'server':
      $propbag->add('type', 'string');
      $propbag->add('name', PLUGIN_SIDEBAR_SHOUTCAST_SERVER);
      $propbag->add('description', PLUGIN_SIDEBAR_SHOUTCAST_SERVER_BLAHBLAH);
      break;
    case 'port':
      $propbag->add('type', 'string');
      $propbag->add('name', PLUGIN_SIDEBAR_SHOUTCAST_PORT);
      $propbag->add('description', PLUGIN_SIDEBAR_SHOUTCAST_PORT_BLAHBLAH);
      break;
    default:
      return false;
    } // switch
    return true;
  } // function
    /**
     * serendipity_plugin_shoutcast::generate_content()
     *
     * @param  $title
     * @return
     */
  function generate_content(&$title)
  {
    global $serendipity;

    $title = $this->get_config('title');
    $host = $this->get_config('server','localhost');
    $port = $this->get_config('port','8000');
    // Connect to server
    $fp=@fsockopen($host,$port,$errno,$errstr,10);
    if (!$fp) {
        $content = PLUGIN_SIDEBAR_SHOUTCAST_UNABLE_TO_CONNECT;
        $content = $content.'<br/>(Error #'.$errno.': '.$errstr.' while making connection to '.$host.':'.$port.')';
    } else {
        // Get data from server
        fputs($fp,"GET /7 HTTP/1.1\nUser-Agent:Mozilla\n\n");
        // exit if connection broken
        for($i=0; $i<1; $i++) {
            if (feof($fp)) break;
            $fp_data=fread($fp,31337);
            usleep(500000);
        }

        // Strip useless junk from source data
        $fp_data=ereg_replace("^.*<body>","",$fp_data);
        $fp_data=ereg_replace("</body>.*","",$fp_data);
        // Place values from source into variable names
        list($current,$status,$peak,$max,$reported,$bit,$song) = explode(",", $fp_data, 7);
        $trackpattern = "/^[0-9][0-9] /";
        $trackreplace = "";
        $song = preg_replace($trackpattern, $trackreplace, $song);
        if ($status == "1") {
           // To use any of the outputs below just uncomment (remove the double forward slashes) that line.
           // Below is an example of all data available in the 7.html file made by the Shoutcast server
           // **ON BY DEFAULT - COMMENT OUT (put to forwards slashes in front of it) TO HIDE
           $content = "Current Listeners: $current<br />\nServer Status: $status<br />\nListener Peak: $peak<br />\nMaximum Listener: $max<br />\nReported Listeners: $reported<br />\nBroadcast Bitrate: $bit<br />\nCurrent Song: <a href=\"http://$host:$port/listen.pls\">$song</a>\n";
           // Below is a basic one line value of the current song, perfect for front pages of sites
           // echo "<html>\n<head>\n<title></title>\n</head>\n<body>\nCurrently Playing: <a href=\"http://$host:$port/listen.pls\">$song</a>\r\n</body>\n</html>";
        } else {
            $content = PLUGIN_SIDEBAR_SHOUTCAST_SERVER_DOWN;
        }
    }

    if (LANG_CHARSET == 'UTF-8') {
        echo mb_convert_encoding($content, 'UTF-8', 'ISO-8859-1');
    } else {
        echo $content;
    }
  } // function
} // class
