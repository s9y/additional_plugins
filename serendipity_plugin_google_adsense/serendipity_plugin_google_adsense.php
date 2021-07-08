<?php


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_google_adsense extends serendipity_plugin
{
    var $title = PLUGIN_ADSENSE_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $this->title = $this->get_config('title', $this->title);

        $propbag->add('name',          PLUGIN_ADSENSE_NAME);
        $propbag->add('description',   PLUGIN_ADSENSE_DESC);
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Jim Dabell');
        $propbag->add('version',       '0.5');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('legal',    array(
            'services' => array(
                'Google AdSense' => array(
                    'url'  => 'https://www.google.com/',
                    'desc' => 'Shows Ads from Google, transmits user cookies to and from Google'
                ),
            ),
            'frontend' => array(
                'Embeds JavaScripts for Google AdSense to display customized Ads. Google sets and uses cookies to track the user. The IP address metadata is also submitted to Google.',
            ),
            'cookies' => array(
                'Google sets and uses cookies to track the user.'
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => true,
            'transmits_user_input'  => true
        ));


        $propbag->add('groups', array('FRONTEND_VIEWS'));
        $propbag->add('configuration', array('client',
                                             'slot',
                                             'format',
                                             'type',
                                             'channel',
                                             'number'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
           case 'client':
              $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_ADSENSE_CLIENT_NAME);
                $propbag->add('description', PLUGIN_ADSENSE_CLIENT_DESCRIPTION);
                $propbag->add('default', '');
           break;
           case 'slot':
              $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_ADSENSE_SLOT_NAME);
                $propbag->add('description', PLUGIN_ADSENSE_SLOT_DESCRIPTION);
                $propbag->add('default', '');
           break;
            case 'number':
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_ADSENSE_NUMBER_NAME);
                $propbag->add('description', PLUGIN_ADSENSE_NUMBER_DESCRIPTION);
                $propbag->add('default', '1');
                $propbag->add('select_values', array('1'=>1,
                                                '2'=>2,
                                                '3'=>3,
                                                '4'=>4,
                                                '5'=>5));
                break;
           case 'format':
              $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_ADSENSE_FORMAT_NAME);
                $propbag->add('description', PLUGIN_ADSENSE_FORMAT_DESCRIPTION);
                $propbag->add('default', '160x600_as');
                $propbag->add('select_values', array(
                   '728x90_as'=>PLUGIN_ADSENSE_FORMAT_LEADERBOARD,
                   '468x60_as'=>PLUGIN_ADSENSE_FORMAT_BANNER,
                   '300x250_as'=>PLUGIN_ADSENSE_FORMAT_MEDIUM_RECTANGLE,
                   '160x600_as'=>PLUGIN_ADSENSE_FORMAT_WIDE_SKYSCRAPER,
                   '120x600_as'=>PLUGIN_ADSENSE_FORMAT_SKYSCRAPER));
           break;
           case 'type':
              $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_ADSENSE_TYPE_NAME);
                $propbag->add('description', PLUGIN_ADSENSE_TYPE_DESCRIPTION);
                $propbag->add('default', 'text_image');
                $propbag->add('select_values', array(
                   'text_image'=>PLUGIN_ADSENSE_TYPE_TEXT_AND_IMAGES,
                   'text'=>PLUGIN_ADSENSE_TYPE_TEXT_ONLY,
                   'image'=>PLUGIN_ADSENSE_TYPE_IMAGES_ONLY));
           break;
           case 'channel':
              $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_ADSENSE_CHANNEL_NAME);
                $propbag->add('description', PLUGIN_ADSENSE_CHANNEL_DESCRIPTION);
                $propbag->add('default', '');
           break;
            default:
                    return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
     global $serendipity;
        $client      = $this->get_config('client');
        $slot        = $this->get_config('slot');
        $format      = $this->get_config('format');
        $width       = intval($format, 10);
        $height      = intval(substr(stristr($format, 'x'), 1), 10);
        $type        = $this->get_config('type');
        $channel     = $this->get_config('channel');
        $number      = $this->get_config('number');

        if ($slot == '')
        {
        for($i = 0; $i < $number ; $i++)
        {
          echo("<script type='text/javascript'><!--\n");
          echo("google_ad_client = '$client';\n");
          echo("google_ad_width = $width;\n");
          echo("google_ad_height = $height;\n");
          echo("google_ad_format = '$format';\n");
          echo("google_ad_type = '$type';\n");
          echo("google_ad_channel = '$channel';\n");
          echo("//--></script>\n");
          echo('<script type="text/javascript" src="https://pagead2.googlesyndication.com/pagead/show_ads.js">');
          echo('</script>');
            echo('<br />');
        }
        } else {
        for($i = 0; $i < $number ; $i++)
        {
          echo("<script type='text/javascript'><!--\n");
          echo("google_ad_client = '$client';\n");
          echo("google_ad_slot = '$slot';\n");
          echo("google_ad_width = $width;\n");
          echo("google_ad_height = $height;\n");
          echo("//--></script>\n");
          echo('<script type="text/javascript" src="https://pagead2.googlesyndication.com/pagead/show_ads.js">');
          echo('</script>');
            echo('<br />');
           }
     }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
