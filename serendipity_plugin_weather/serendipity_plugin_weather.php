<?php

/* $Id: serendipity_plugin_weather.php,v 1.27 2007/03/08 15:13:14 garvinhicking Exp $*/
// Spanish translation by Francisco Ortiz <frortiz@gmail.com>


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_plugin_weather extends serendipity_plugin {
    /**
    * serendipity_plugin_weather::introspect()
    *
    * @param  $propbag
    * @return
    */
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name', PLUGIN_SIDEBAR_WEATHER_NAME);
        $propbag->add('description', PLUGIN_SIDEBAR_WEATHER_DESC);
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',  '1.5');
        $propbag->add('configuration', array('title',
        				 'metar',
        				 'timezone',
        				 'caching',
                         'cache_directory',
                         'pixel_directory',
        				 'units'));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));

    } // function
    /**

     * serendipity_plugin_weather::introspect_config_item()
     *
     * @param  $name
     * @param  $propbag
     * @return
     */
  function introspect_config_item($name, &$propbag) {
    global $serendipity;

    switch ($name) {
    case 'title':
      $propbag->add('type', 'string');
      $propbag->add('name', PLUGIN_SIDEBAR_WEATHER_TITLE);
      $propbag->add('description', PLUGIN_SIDEBAR_WEATHER_TITLE_BLAHBLAH);
      break;
    case 'metar':
      $propbag->add('type', 'string');
      $propbag->add('name', PLUGIN_SIDEBAR_WEATHER_METAR);
      $propbag->add('description', PLUGIN_SIDEBAR_WEATHER_METAR_BLAHBLAH);
      break;
    case 'timezone':
      $propbag->add('type', 'string');
      $propbag->add('name', PLUGIN_SIDEBAR_WEATHER_TIMEZONE);
      $propbag->add('description', PLUGIN_SIDEBAR_WEATHER_TIMEZONE_BLAHBLAH);
      break;
    case 'units':
      $select = array();
      $select["metric"] = PLUGIN_SIDEBAR_WEATHER_UNITS_NAME_METRIC;
      $select["standard"] = PLUGIN_SIDEBAR_WEATHER_UNITS_NAME_IMPERIAL;

      $propbag->add('type', 'select');
      $propbag->add('name', PLUGIN_SIDEBAR_WEATHER_UNITS);
      $propbag->add('description', PLUGIN_SIDEBAR_WEATHER_UNITS_BLAHBLAH);
      $propbag->add('select_values', $select);
      break;

    case 'caching':
      $propbag->add('type', 'boolean');
      $propbag->add('name', PLUGIN_SIDEBAR_WEATHER_CACHE_ENTRIES);
      $propbag->add('description', PLUGIN_SIDEBAR_WEATHER_CACHE_ENTRIES_DESC);
      $propbag->add('default', false);
      break;

    case 'cache_directory':
      $propbag->add('type', 'string');
      $propbag->add('name', PLUGIN_SIDEBAR_WEATHER_CACHE_DIRECTORY);
      $propbag->add('description', PLUGIN_SIDEBAR_WEATHER_CACHE_DIRECTORY_DESC);
      $propbag->add('default', '/tmp');
      break;

    case 'pixel_directory':
      $propbag->add('type', 'string');
      $propbag->add('name', PLUGIN_SIDEBAR_WEATHER_PIXEL_DIRECTORY);
      $propbag->add('description', '');
      $propbag->add('default', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_plugin_weather/dot/pixel/icons/serendipity_weather_plugin');
      break;

    default:
      return false;
    } // switch
    return true;
  } // function
    /**
     * serendipity_plugin_weather::generate_content()
     *
     * @param  $title
     * @return
     */
  function generate_content(&$title)
  {
    global $serendipity;

    $title = $this->get_config('title');
    $metar_site = $this->get_config('metar','EDDK');
    $timezone = $this->get_config('timezone',0);
    $unitString = $this->get_config('units','metric');
    $caching = $this->get_config('caching',0);
    $directory = $this->get_config('cache_directory','/tmp');
    $pixdir = $this->get_config('pixel_directory');

    if(@include_once('Services/Weather.php')){

        $metar = &Services_Weather::service('METAR', array('debug' => 0));
        if (Services_Weather::isError($metar)) {
          echo ('Weather Error: ' . $metar->getMessage());
        }

        // Set the unit format for the data
        $metar->setUnitsFormat($unitString);

        // Set the time/date format
        // Do we have the date/time format set somewhere in s9y? then we should take this here
        // $metar->setDateTimeFormat('d.m.Y', 'H:i');
        //    $metar_data->setDateTimeFormat('j M Y', 'H:i');

        if($caching){
            if (@include_once("Cache.php")) {
                $status = $metar->setCache('file', array('cache_dir' => $serendipity['serendipityPath'].$directory));
            } else {
                echo 'Caching is enabled but PEAR:Cache does not seem to be installed.';
            }
        }

        if (Services_Weather::isError($status)) {
          echo 'Error: ' . $status->getMessage();
        }

        switch($unitString)
         {
          case "metric":
            $units = array('wind' => 'km/h',
	            'vis'  => 'km',
	            'height' => 'km',
	            'temp' => '&deg;C',
	            'pres' => 'mb',
	            'rain' => 'mm');
          break;
          case "standard":
              $units = array('wind' => 'mph',
	            'vis'  => 'mi',
	            'height' => 'mi',
	            'temp' => '&deg;F',
	            'pres' => 'in',
	            'rain' => 'in');
          break;
        }



        $weather_data = $metar->getWeather($metar_site);
        if (Services_Weather::isError($weather_data)) {
          echo 'Error: ' . $weather_data->getMessage();
        }

        $location_data = $metar->getLocation($metar_site);
        if (Services_Weather::isError($location_data)) {
          echo 'Error: ' . $location_data->getMessage();
        }

        $forecast_data = $metar->getForecast($metar_site);
        if (Services_Weather::isError($forecast_data)) {
          echo 'Error: ' . $forecast_data->getMessage();
        }

        // Do all that icon-stuff
        // FIXXME: URL-Prefix
        $windDir = $weather_data["windDirection"];
        switch ($windDir) {
        case 'S':
          $windDirIcon = $pixdir . '/sss.png';
          $windDir = PLUGIN_SIDEBAR_WEATHER_DATA_S;
          break;
        case 'SSW':
          $windDirIcon = $pixdir . '/ssw.png';
          $windDir = PLUGIN_SIDEBAR_WEATHER_DATA_SSW;
          break;
        case 'SSE':
          $windDirIcon = $pixdir . '/sse.png';
          $windDir = PLUGIN_SIDEBAR_WEATHER_DATA_SSE;
          break;
        case 'SW':
          $windDirIcon = $pixdir . '/sw.png';
          $windDir = PLUGIN_SIDEBAR_WEATHER_DATA_SW;
          break;
        case 'WSW':
          $windDirIcon = $pixdir . '/sww.png';
          $windDir = PLUGIN_SIDEBAR_WEATHER_DATA_WSW;
          break;
        case 'E':
          $windDirIcon = $pixdir . '/eee.png';
          $windDir = PLUGIN_SIDEBAR_WEATHER_DATA_E;
          break;
        case 'ESE':
          $windDirIcon = $pixdir . '/see.png';
          $windDir = PLUGIN_SIDEBAR_WEATHER_DATA_ESE;
          break;
        case 'ENE':
          $windDirIcon = $pixdir . '/nee.png';
          $windDir = PLUGIN_SIDEBAR_WEATHER_DATA_ENE;
          break;
        case 'N':
          $windDirIcon = $pixdir . '/nnn.png';
          $windDir = PLUGIN_SIDEBAR_WEATHER_DATA_N;
          break;
        case 'NNW':
          $windDirIcon = $pixdir . '/nnw.png';
          $windDir = PLUGIN_SIDEBAR_WEATHER_DATA_NNW;
          break;
        case 'NNE':
          $windDirIcon = $pixdir . '/nne.png';
          $windDir = PLUGIN_SIDEBAR_WEATHER_DATA_NNE;
          break;
        case 'NW':
          $windDirIcon = $pixdir . '/nw.png';
          $windDir = PLUGIN_SIDEBAR_WEATHER_DATA_NW;
          break;
        case 'NE':
          $windDirIcon = $pixdir . '/ne.png';
          $windDir = PLUGIN_SIDEBAR_WEATHER_DATA_NE;
          break;
        case 'SE':
          $windDirIcon = $pixdir . '/se.png';
          $windDir = PLUGIN_SIDEBAR_WEATHER_DATA_SE;
          break;
        case 'W':
          $windDirIcon = $pixdir . '/www.png';
          $windDir = PLUGIN_SIDEBAR_WEATHER_DATA_W;
          break;
        case 'WNW':
          $windDirIcon = $pixdir . '/nww.png';
          $windDir = PLUGIN_SIDEBAR_WEATHER_DATA_WNW;
          break;
        case 'Variable':
          $windDirIcon = $pixdir . '/vrb.gif';
          $windDir = PLUGIN_SIDEBAR_WEATHER_DATA_V;
          break;
        default :
          $windDirIcon = $pixdir . '/wind_nodata.png';
          $windDir = "No recorded data.";
        }

        // Turn the GMT time from the update into a local time
        $localTime = date('j M Y H:i', strtotime($weather_data['updateRaw']) + (3600*$timezone));

        // Get local hour to determing if it is night
        $hour = date('H' , strtotime($weather_data['updateRaw']) + (3600*$tz));
        if ($hour > 18 || $hour < 6) {
          $night = 'n_';
        } else {
          $night = '';
        }

        // Handle cloud data
        // We could be dealing with cloud at several levels, so find the heaviest
        // cover and go with that.
        $cloudData = $weather_data['clouds'];
        // See if we are dealing with an array of arrays or some information
        $cloudKeys = array_keys($cloudData);
        $testKey = $cloudKeys[0];
        if (!is_array($cloudData["$testKey"])) {
          // we have information
          $amount = $cloudData['amount'];
        } else {
          // we have information on several levels - get highest
          $key = count($cloudKeys)-1;
          $useArray = $cloudData[$key];
          $amount = $useArray['amount'];
        }

        switch ($amount) {
        case "Clear Below":
        case "clear sky":
        case "no significant cloud":
        case "clear below 12,000 ft":
        case "vertical visibility":
          $cloudLevel = "0cloud";
          break;
        case "few":
        case "scattered":
          $cloudLevel = "1cloud";
          break;
        case "Cumulonimbus":
          $cloudLevel = "2cloud";
          break;
        case "Towering Cumulus":
        case "broken":
          $cloudLevel = "3cloud";
          break;
        case "overcast":
          $cloudLevel = "4cloud";
          $night = "";
          break;
        default:
          $cloudLevel = "0cloud";
        }

        // Determine weather conditions (rain, snow etc);
        // We need some way to translate this
        $conditions = $weather_data["condition"];

        switch ($cloudLevel) {
        case "0cloud":
          if (strstr($conditions, "fog") !== FALSE) {
            $condUse = "_fog";
          } else {
            $condUse = "";
          }
          break;
        case "1cloud":
          if (strstr($conditions, "fog") !== FALSE) {
            $condUse = "_fog";
          } elseif (strstr($conditions, "rain") !== FALSE && strstr($conditions, "light") !== FALSE) {
	      $condUse = "_lightrain";
          } elseif (strstr($conditions, "rain") !== FALSE && strstr($conditions, "heavy") !== FALSE) {
	      $condUse = "_heavyrain";
          } elseif (strstr($conditions, "rain") !== FALSE) {
	      $condUse = "_modrain";
          } else {
	      $condUse = "_norain";
          }
          break;
        case "2cloud":
          if (strstr($conditions, "fog") !== FALSE) {
	      $condUse = "_fog";
          } elseif (strstr($conditions, "rain") !== FALSE && strstr($conditions, "light") !== FALSE) {
	      $condUse = "_lightrain";
          } elseif (strstr($conditions, "rain") !== FALSE && strstr($conditions, "heavy") !== FALSE) {
	      $condUse = "_heavyrain";
          } elseif (strstr($conditions, "rain") !== FALSE) {
	      $condUse = "_modrain";
          } elseif (strstr($conditions, "snow") !== FALSE) {
	      $condUse = "_snow";
          } elseif (strstr($conditions, "thunderstorm") !== FALSE) {
	      $condUse = "_thunders";
          } else {
	      $condUse = "_norain";
          }
          break;
        case "3cloud":
          if (strstr($conditions, "fog") !== FALSE) {
            $condUse = "_fog";
          } elseif (strstr($conditions, "rain") !== FALSE && strstr($conditions, "light") !== FALSE) {
            $condUse = "_lightrain";
          } elseif (strstr($conditions, "rain") !== FALSE && strstr($conditions, "heavy") !== FALSE) {
            $condUse = "_heavyrain";
          } elseif (strstr($conditions, "rain") !== FALSE) {
            $condUse = "_modrain";
          } elseif (strstr($conditions, "snow") !== FALSE) {
            $condUse = "_snow";
          } elseif (strstr($conditions, "thunderstorm") !== FALSE) {
            $condUse = "_thunders";
          } elseif (strstr($conditions, "hail") !== FALSE) {
            $condUse = "_hail";
          } else {
            $condUse = "_norain";
          }
          break;
        case "4cloud":
          if (strstr($conditions, "fog") !== FALSE) {
            $condUse = "_fog";
          } elseif (strstr($conditions, "rain") !== FALSE && strstr($conditions, "light") !== FALSE) {
            $condUse = "_lightrain";
          } elseif (strstr($conditions, "rain") !== FALSE && strstr($conditions, "heavy") !== FALSE) {
            $condUse = "_heavyrain";
          } elseif (strstr($conditions, "rain") !== FALSE) {
            $condUse = "_modrain";
          } elseif (strstr($conditions, "snow") !== FALSE && strstr($conditions, "light") !== FALSE) {
            $condUse = "_lightsnow";
          } elseif (strstr($conditions, "snow") !== FALSE && strstr($conditions, "heavy") !== FALSE) {
            $condUse = "_heavysnow";
          } elseif (strstr($conditions, "snow") !== FALSE) {
            $condUse = "_snow";
          } elseif (strstr($conditions, "thunderstorm") !== FALSE) {
            $condUse = "_thunders";
          } elseif (strstr($conditions, "hail") !== FALSE && strstr($conditions, "light") !== FALSE) {
            $condUse = "_lighthail";
          } elseif (strstr($conditions, "hail") !== FALSE && strstr($conditions, "heavy") !== FALSE) {
            $condUse = "_heavyhail";
          } elseif (strstr($conditions, "hail") !== FALSE) {
            $condUse = "_hail";
          } else {
            $condUse = "_norain";
          }
          break;
        default:
          $condUse = "_norain";
        }

        // Construct icon name
        $conditionIcon = $pixdir . '/' . $night . $cloudLevel . $condUse . '.png';

        $content = '';

        $content .= '<img src="' . $conditionIcon . '" alt="" /><br />'. $conditions . '<br />';
        // FIXXME: Translate the Winddirection
        $content .= '<dl><dt>'.PLUGIN_SIDEBAR_WEATHER_DATA_WINDDIRECTION.'</dt><dd><img src="' .
          $windDirIcon . '" alt="" /><dd>' .
          $windDir . ' at <dd>' . $weather_data["wind"] . ' ' .$units['wind'] . '</dd></dt>';

        $content .= '<dt>'.PLUGIN_SIDEBAR_WEATHER_DATA_TEMPERATURE.'</dt><dd>'.
          $weather_data["temperature"].' '. $units['temp'].'</dd>';
        $content .= '<dt>'.PLUGIN_SIDEBAR_WEATHER_DATA_FELT_TEMPERATURE.'</dt><dd>'.
          $weather_data["feltTemperature"].' '. $units['temp'] .'</dd>';
        $content .= '<dt>'.PLUGIN_SIDEBAR_WEATHER_DATA_HUMIDITY.'</dt><dd>' .
      $weather_data["humidity"] .' '. '%</dd>';
        $content .= '<dt>'.PLUGIN_SIDEBAR_WEATHER_DATA_PRESSURE.'</dt><dd>' .
          $weather_data['pressure'] .' '. $units['pres'].'</dd>';
        $content .= '<dt>'.PLUGIN_SIDEBAR_WEATHER_DATA_VISIBILITY.'</dt><dd>' .
          $weather_data["visibility"] .' '. $units['vis'] . '</dd>';
        $content .= '<dt>'.PLUGIN_SIDEBAR_WEATHER_DATA_UPDATE.'</dt><dd>' .
          $localTime . '</dd></dl>';

    } else {
      $content = 'Loading the  <a href=http://pear.php.net/package/Services_Weather/>PEAR Services/Weather module</a> failed.  Please insure that the module is installed.';
    }

    echo $content;
  } // function
} // class

?>
