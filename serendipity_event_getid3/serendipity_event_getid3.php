<?php # 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_getid3 extends serendipity_plugin
{
    var $title = PLUGIN_GETID3;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_GETID3);
        $propbag->add('description',   PLUGIN_GETID3_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Grischa Brockhaus');
        $propbag->add('version',       '1.4.1');
        $propbag->add('requirements',  array(
            'serendipity' => '1.1',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

		$propbag->add('event_hooks', array(
		    'media_getproperties'           => true,
		    'media_getproperties_cached'    => true,
		));
        $propbag->add('groups', array('IMAGES'));
        $propbag->add('configuration', array('installdescription','foundgetid3'));
    }

    /*
    function example() {
        echo '<p>' . PLUGIN_GETID3_INSTALL . '</p>';
    }
    */

    function generate_content(&$title) {
    }

    function parseSec($sec, $preZero = true)  {
        $out = '';

        $hours    = intval(intval($sec) / 3600);
        $minutes  = intval(($sec / 60) % 60);
        $seconds  = intval($sec % 60);
        $mseconds = intval((($sec - $seconds) * 100) % 100);

        $out .= ($preZero) ? str_pad($hours, 2, "0", STR_PAD_LEFT) . ':' : $hours. ':';
        $out .= str_pad($minutes, 2, '0', STR_PAD_LEFT). ':';
        $out .= str_pad($seconds, 2, '0', STR_PAD_LEFT) . '.';
        $out .= str_pad($mseconds, 2, '0', STR_PAD_LEFT);

        return $out;
    }
    function introspect_config_item($name, &$propbag)
    {
        if (file_exists(dirname(__FILE__) . '/../../bundled-libs/getid3/getid3.lib.php')) {
            $found_library = '<div class="serendipityAdminMsgSuccess">' . PLUGIN_GETID3_LIBFOUNDBUNDLED . '</div>';
        } else if (file_exists(dirname(__FILE__) . '/getid3/getid3.lib.php')) {
            $found_library = '<div class="serendipityAdminMsgSuccess">' . PLUGIN_GETID3_LIBFOUNDPLUGIN . '</div>';
        } else {
            $found_library = '<div class="serendipityAdminMsgError">'. PLUGIN_GETID3_LIBNOTFOUND . '</div>';
        }
        // $found_library = "<p><ul><li>" . $found_library . "</li></ul></p>";
        switch($name) {
            case 'installdescription':
                $propbag->add('type',        'content');
                $propbag->add('default',     PLUGIN_GETID3_INSTALL_DESC);
                break;
            case 'foundgetid3':
                $propbag->add('type',        'content');
                $propbag->add('default',     $found_library);
                break;
        }

        return true;
    }

	function event_hook($event, &$bag, &$eventData, $addData = null) {

		global $serendipity;
		static $i = null;
		static $keys = array(
		    'audio'      => array(
	                            'channels'          => 'AudioChannels',
	                            'channelmode'       => 'AudioChannelMode',
	                            'sample_rate'       => 'AudioSampleRate',
	                            'bitrate_mode'      => 'AudioBitrateMode',
	                            'codec'             => 'AudioCodec'
		                    ),
		    'video'      => array(
		                        'bitrate_mode'      => 'VideoBitrateMode',
		                        'resolution_x'      => 'VideoWidth',
		                        'resolution_y'      => 'VideoHeight',
		                        'frame_rate'        => 'VideoFrameRate',
		                        'codec'             => 'VideoCodec'
		                    ),
		    'main'       => array(
		                        'playtime_seconds'  => 'RunLength',
		                        'bitrate'           => 'Bitrate',
                                'mime_type'         => 'Mime-Type'
		                    )
		);

		$hooks = &$bag->get('event_hooks');

		if (isset($hooks[$event])) {
		    switch($event) {
                case 'media_getproperties_cached':
		        case 'media_getproperties':
		            if ($i === null) {
		                // Try to find the getid3 library in the bundled-libs first:
                        if (file_exists(dirname(__FILE__) . '/../../bundled-libs/getid3/getid3.lib.php')) {
		                    @define('GETID3_INCLUDEPATH', dirname(__FILE__) . '/../../bundled-libs/getid3/');
		                } else if (file_exists(dirname(__FILE__) . '/getid3/getid3.lib.php')) {
                            @define('GETID3_INCLUDEPATH', dirname(__FILE__) . '/getid3/');
                        } else {
                            $eventData['ID3']['ERROR'] = PLUGIN_GETID3_LIBNOTFOUND;
                            break;
                        }
		                require_once GETID3_INCLUDEPATH . 'getid3.php';
		                $i = new GetID3;
		                $i->encoding = LANG_CHARSET;
		            }

		            $id3 =& $i->analyze($addData);
                    getid3_lib::CopyTagsToComments($id3);

                    foreach($keys['audio'] AS $audiokey => $audiodesc) {
                        if (!empty($id3['audio'][$audiokey])) {
                            $eventData['ID3'][$audiodesc] = $id3['audio'][$audiokey];
                        }
                    }

                    foreach($keys['video'] AS $videokey => $videodesc) {
                        if (!empty($id3['video'][$videokey])) {
                            $eventData['ID3'][$videodesc] = $id3['video'][$videokey];
                        }
                    }

                    foreach($keys['main'] AS $mainkey => $maindesc) {
                        if (!empty($id3[$mainkey])) {
                            $eventData['ID3'][$maindesc] = $id3[$mainkey];
                        }
                    }

                    if (!empty($eventData['ID3']['RunLength'])) {
                        $eventData['ID3']['RunLength'] = $this->parseSec($eventData['ID3']['RunLength']);
                    }

                    if (!empty($eventData['ID3']['Bitrate'])) {
                        $eventData['ID3']['Bitrate']   = round($eventData['ID3']['Bitrate'] / 1000, 2) . ' kbit/sec';
                    }

		            break;
		    }
		}
	}
}

/* vim: set sts=4 ts=4 expandtab : */
