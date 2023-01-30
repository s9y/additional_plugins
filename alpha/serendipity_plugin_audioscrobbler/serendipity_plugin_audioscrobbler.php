<?php

// By Alphalogic (aka Flo Solcher) alpha@alphalogic.org


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class s9y_audioscrobbler_XMLParser {
    function parseXML($xml_content, $forced_encoding = null) {
        $xml_parser = xml_parser_create();
        xml_parser_set_option ($xml_parser, XML_OPTION_TARGET_ENCODING, 'UTF-8');
        xml_parser_set_option ($xml_parser, XML_OPTION_CASE_FOLDING, 1);
        xml_parser_set_option ($xml_parser, XML_OPTION_SKIP_WHITE, 0);
	$utf8_content = serendipity_utf8_encode($xml_content);
        xml_parse_into_struct($xml_parser, $utf8_content, $xml_array);
        xml_parser_free($xml_parser);
        return $xml_array;
    }

    function getXMLArray($file, $forced_encoding = null) {
        if (function_exists('serendipity_request_url')) {
            $data = serendipity_request_url($file);
            if (empty($data)) return false;
        } else {
            require_once (defined('S9Y_PEAR_PATH') ? S9Y_PEAR_PATH : S9Y_INCLUDE_PATH . 'bundled-libs/') . 'HTTP/Request.php';
            $req = new HTTP_Request($file);
            if (PEAR::isError($req->sendRequest()) || $req->getResponseCode() != '200') {
                if ( ini_get( "allow_url_fopen")) {
                    $data = file_get_contents($file);
                } else {
                    $data = "";
                }
            } else {
                $data = $req->getResponseBody();
            }
        }
        if (trim($data)== '') return false;
        return $this->parseXML($data, $forced_encoding);
    }
}

class serendipity_plugin_audioscrobbler extends serendipity_plugin {

    var $title              = PLUGIN_AUDIOSCROBBLER_TITLE;
    var $scrobbler_error    = array();
    var $songs              = array();
    var $scrobblercache;
    var $number;
    var $username;
    var $cachetime;
    var $utcdifference;
    var $read_scrobbler_feed = false;
    var $scrobblerlastupdate;

   function introspect(&$propbag) {
        $this->title = $this->get_config('sidebartitle', $this->title);

        $propbag->add('name',          PLUGIN_AUDIOSCROBBLER_TITLE);
        $propbag->add('description',   PLUGIN_AUDIOSCROBBLER_TITLE_BLAHBLAH);
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Flo Solcher');
        $propbag->add('version',       '1.25.2');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
        $propbag->add('configuration', array(   'number',
                                                'sidebartitle',
                                                'username',
                                                'songlink',
                                                'artistlink',
                                                'newwindow',
                                                'cachetime',
                                                'dateformat',
                                                'utcdifference',
                                                'spacer',
                                                'profiletitle',
                                                'formatstring',
                                                'formatstring_block',
                                                'lastupdate',
                                                'forced',
                                                'stack'
                                            ));
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {

            case 'lastupdate': case 'forced':
                $propbag->add('type', 'hidden');
                $propbag->add('default', 0);
                break;

            case 'number':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_AUDIOSCROBBLER_NUMBER);
                $propbag->add('description', PLUGIN_AUDIOSCROBBLER_NUMBER_BLAHBLAH);
                $propbag->add('default', '0');
                break;

            case 'sidebartitle':
                $propbag->add('type', 'string');
                $propbag->add('name', TITLE);
                $propbag->add('description', TITLE_FOR_NUGGET);
                $propbag->add('default', '');
                break;

            case 'username':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_AUDIOSCROBBLER_USERNAME);
                $propbag->add('description', PLUGIN_AUDIOSCROBBLER_USERNAME_BLAHBLAH);
                $propbag->add('default', '');
                break;

            case 'stack':
                 $propbag->add('type', 'boolean');
                $propbag->add('name',        PLUGIN_AUDIOSCROBBLER_STACK);
                $propbag->add('description', PLUGIN_AUDIOSCROBBLER_STACK_BLAHBLAH);
                $propbag->add('default', true);
                break;

            case 'songlink':
                 $propbag->add('type', 'boolean');
                $propbag->add('name',        PLUGIN_AUDIOSCROBBLER_SONGLINK);
                $propbag->add('description', PLUGIN_AUDIOSCROBBLER_SONGLINK_BLAHBLAH);
                $propbag->add('default', '1');
                break;

            case 'artistlink':
                 $propbag->add('type', 'select');
                $propbag->add('select_values', array('0'     => PLUGIN_AUDIOSCROBBLER_ARTISTLINK_NONE,
                                                     '1'     => PLUGIN_AUDIOSCROBBLER_ARTISTLINK_SCROBBLER,
                                                     '2'     => PLUGIN_AUDIOSCROBBLER_ARTISTLINK_MUSICBRAINZ_ELSE_NONE,
                                                     '3'     => PLUGIN_AUDIOSCROBBLER_ARTISTLINK_MUSICBRAINZ_ELSE_SCROBBLER
                                                     ));
                $propbag->add('name',        PLUGIN_AUDIOSCROBBLER_ARTISTLINK);
                $propbag->add('description', PLUGIN_AUDIOSCROBBLER_ARTISTLINK_BLAHBLAH);
                $propbag->add('default', '4');
                break;


            case 'newwindow':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_AUDIOSCROBBLER_NEWWINDOW);
                $propbag->add('description', PLUGIN_AUDIOSCROBBLER_NEWWINDOW_BLAHBLAH);
                $propbag->add('default', false);
                break;

            case 'cachetime':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_AUDIOSCROBBLER_CACHETIME);
                $propbag->add('description', PLUGIN_AUDIOSCROBBLER_CACHETIME_BLAHBLAH);
                $propbag->add('default', 30);
                break;

            case 'dateformat':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_AUDIOSCROBBLER_DATEFORMAT);
                $propbag->add('description', PLUGIN_AUDIOSCROBBLER_DATEFORMAT_BLAHBLAH);
                $propbag->add('default', "%e. %B %Y, %H:%M");
                break;

            case 'utcdifference':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_AUDIOSCROBBLER_UTCDIFFERENCE);
                $propbag->add('description', PLUGIN_AUDIOSCROBBLER_UTCDIFFERENCE_BLAHBLAH);
                $propbag->add('default', "0");
                break;

             case 'spacer':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_AUDIOSCROBBLER_SPACER);
                $propbag->add('description', PLUGIN_AUDIOSCROBBLER_SPACER_BLAHBLAH);
                $propbag->add('default', '<br />');
                break;

            case 'profiletitle':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_AUDIOSCROBBLER_PROFILETITLE);
                $propbag->add('description', PLUGIN_AUDIOSCROBBLER_PROFILETITLE_BLAHBLAH);
                $propbag->add('default', '%USER%');
                break;

             case 'formatstring':
                $propbag->add('type', 'text');
                $propbag->add('name', PLUGIN_AUDIOSCROBBLER_FORMATSTRING);
                $propbag->add('description', PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLAHBLAH);
                $propbag->add('default', 'Song: %SONG%<br />Artist: %ARTIST%<br /><div class="serendipitySideBarDate">%DATE%</div>');
                break;

              case 'formatstring_block':
                $propbag->add('type', 'text');
                $propbag->add('name', PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLOCK);
                $propbag->add('description', PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLOCK_BLAHBLAH);
                $propbag->add('default', '<div style="text-align: center;">%PROFILE%</div><br />%ENTRIES%<br /><div style="text-align: center;">%LASTUPDATE%</div>');
                break;

            default:
                return false;
        }
        return true;
    }

    //renders the date for output
    function renderScrobblerDate($date) {
        $stamp          = $date + intval($this->utcdifference) * 60 * 60;
        return (function_exists('serendipity_specialchars') ? serendipity_specialchars(serendipity_formatTime($this->get_config('dateformat'), $stamp, true)) : htmlspecialchars(serendipity_formatTime($this->get_config('dateformat'), $stamp, true), ENT_COMPAT, LANG_CHARSET));
    }

    //sets the timestamp of the last update try
    function setLastUpdateTry() {
        $stamp = time();
        $this->set_config('lastupdate', $stamp);
        $this->scrobblerlastupdate = $stamp;
    }

    //reads the songs from the audioscrobbler rdf feed
    function getSongsFromScrobbler($force = false) {
       if (!file_exists($this->scrobblercache) || filesize($this->scrobblercache) == 0 || $this->scrobblerlastupdate < (time() - $this->cachetime) || $force) {
            $this->read_scrobbler_feed = true;
            if ($this->get_config('forced') == 1 && $force) {
                echo '<!-- second force attempt -->'."\n";
                return false;
            } elseif ($this->get_config('forced') == 0 && $force) {
                $this->set_config('forced', 1);
                echo '<!-- setting force attempt -->'."\n";
            }
            $this->setLastUpdateTry();
            echo '<!-- fetching scrobbler feed -->'."\n";
            $objXml     = new s9y_audioscrobbler_XMLParser();
            $array      = $objXml->getXMLArray('http://ws.audioscrobbler.com/1.0/user/'.$this->username.'/recenttracks.xml');
            if ($array && is_array($array)) {
                $songs          = array();
                $counter        = 0;
                //$start          = false;
                $start = true;
                foreach ($array as $xml) {
                    if ($xml['tag'] == 'TRACK' && $xml['type'] == 'close') {
                        $counter++;
                    } elseif ($xml['tag'] == 'RECENTTRACKS' && $xml['type'] == 'close') {
                        $start = true;
                    }
                    if ($start) {
                        if ($xml['tag'] == 'LINK' && $xml['type'] == 'complete') {
                            $songs[$counter]['link'] = $this->reencode($xml['value']);
                        }
                        elseif ($xml['tag'] == 'NAME' && $xml['type'] == 'complete')
                        {
                            $songs[$counter]['songtitle'] = $this->reencode($xml['value']);
                        }
                        elseif ($xml['tag'] == 'DATE' && $xml['type'] == 'complete')
                        {
                            $songs[$counter]['date'] = $this->reencode($xml['attributes']['UTS']);
                        }
                        elseif ($xml['tag'] == 'URL' && $xml['type'] == 'complete')
                        {
                            $songs[$counter]['songlink'] = trim($this->reencode($xml['value']));

                        }
                        elseif ($xml['tag'] == 'ARTIST' && $xml['type'] == 'complete')
                        {
                            $songs[$counter]['artisttitle'] = $this->reencode($xml['value']);

                        }
                            /*
                        } elseif ($xml['tag'] == 'DESCRIPTION' && $xml['type'] == 'complete') {
                            $songs[$counter]['description'] = reencode($xml['value']);
                        } elseif ($xml['tag'] == 'DC:DATE' && $xml['type'] == 'complete') {
                            $songs[$counter]['date'] = reencode($xml['value']);
                        } elseif ($xml['tag'] == 'DC:TITLE' && $xml['type'] == 'complete' && $state == 0) {
                            $songs[$counter]['songtitle'] = reencode($xml['value']);
                            $state++;
                        } elseif ($xml['tag'] == 'MM:ARTIST' && $xml['type'] == 'open' && is_array($xml['attributes'])) {
                            $songs[$counter]['artistlink'] = reencode($xml['attributes']['RDF:ABOUT']);
                        } elseif ($xml['tag'] == 'DC:TITLE' && $xml['type'] == 'complete' && $state == 1) {
                            $songs[$counter]['artisttitle'] = reencode($xml['value']);
                            $state++;
                        } elseif ($xml['tag'] == 'DC:TITLE' && $xml['type'] == 'complete' && $state == 2) {
                            $songs[$counter]['albumtitle'] = reencode($xml['value']);
                            $state = 0;
                        }
                        */
                    }

                }
                if (is_array($songs) && count($songs) > 0) {
                    if (count($songs) < intval($this->get_config('number'))) {
                        $songs = $this->stackerScrobbler($songs);
                    } elseif (count($songs) > intval($this->get_config('number'))) {
                        $songs = $this->deStackerScrobbler($songs);
                    }
                    if (!$force) {
                        $this->set_config('forced', 0);
                    }
                    $this->writeScrobblerCache($songs);
                    return true;
                } elseif ($force) {
                   return false;
                } elseif (!file_exists($this->scrobblercache)) {
                    $this->scrobbler_error[] = PLUGIN_AUDIOSCROBBLER_FEED_OFFLINE;
                    return false;
                }
            }
        }
    }

    // Reencodes UTF-8 to blog encoding
    function reencode($string) {
        if (LANG_CHARSET != 'UTF-8') {
	         return mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
	     }
	     return $string;
    }

    //destacks the songs so that always the $this->number songs are in the songarray
    function deStackerScrobbler($songs) {
        while (count($songs) != $this->number) array_pop($songs);
        return $songs;
    }

    //stacks the songs so that always the $this->number songs are in the songarray
    function stackerScrobbler($songs) {
        if (!serendipity_db_bool($this->get_config('stack'))) {
            return $songs;
        }

        $this->readScrobblerCache(true);
        if ($oldsongs = $this->songs) {
            $diff       = $this->number - count($songs);
            $lastsongs  = array();
             foreach ($oldsongs as $oldsong) {
                $addsong = true;
                foreach ($songs as $song) {
                    if ($song['date'] == $oldsong['date']) {
                        $addsong = false;
                    }
                }
                if ($addsong) $lastsongs[] = $song;
            }
            $i = 0;
            foreach(array_reverse($lastsongs) as $lastsong) {
                $songs[] = $lastsong;
                $i++;
                if (($diff - $i) == 0) {
                    break;
                }
            }
            return $songs;
        } else {
            return $songs;
        }
    }

    //encodes a scrobbler song array
    function encodeScrobblerArray($song_array) {
        if (function_exists('gzcompress')) {
            return gzcompress(serialize($song_array));
        } else {
            return serialize($song_array);
        }
    }

    //decodes a scrobbler song array
    function decodeScrobblerArray($encoded_songs) {
        if (function_exists('gzcompress')) {
            return unserialize(gzuncompress($encoded_songs));
        } else {
            return unserialize($encoded_songs);
        }
    }

    //writes the s9y cache sets $this->scrobbler_error on failure
    function writeScrobblerCache($songs) {
        //check if the $this->songs and $songs are equal
        if (is_array ($this->songs)) {
            $equal = true;
            if (is_array($this->songs))
            foreach ($songs as $key => $song) {
                foreach ($song as $tag => $value) {
                    if ($this->songs[$key][$tag] != $value) $equal = false;
                }
            }
            if ($equal) {
                echo '<!-- cache is equal -->'."\n";
                return;
            }
        }
        $fp = @fopen($this->scrobblercache, 'w');
        if ($fp) {
            fwrite($fp, $this->encodeScrobblerArray($songs));
            fclose($fp);
            $this  ->songs = $songs;
            echo '<!-- cache written -->'."\n";
        } else {
           $this->scrobbler_error[] = PLUGIN_AUDIOSCROBBLER_COULD_NOT_WRITE;
        }
    }

    //reads from the s9y cache sets $this->songs on success , $this->scrobbler_error on failure
    function readScrobblerCache($no_error = false) {
        //don't do things twice ;)
        if (is_array($this->songs) && @count($this->songs) > 0) {
            return $this->songs;
        } else {
            $songs = @file_get_contents($this->scrobblercache);
            if (trim($songs) == '' || !@is_array($this->decodeScrobblerArray($songs))) {
                //create a new cache if possible
                //the scobbler feed was not read yet->read it
                if (!$this->read_scrobbler_feed) {
                    echo '<!-- bad cache trying to create a new one -->'."\n";
                    $this->getSongsFromScrobbler();
                    return;
                }
                //if the feed is not readable and this is no stack call add an error
                if (!$no_error) {
                    $this  ->scrobbler_error[] = PLUGIN_AUDIOSCROBBLER_COULD_NOT_READ;
                }
                $this  ->songs = false;
            } else {
                //if the cache doesnt match $this->number try to stack it with a force read
                if (!($this->read_scrobbler_feed) && count($this->decodeScrobblerArray($songs)) < $this->number) {
                    echo '<!-- force read for stack -->'."\n";
                    //if the songlist is offline or this is the second force attempt - return the cache
                    if (!$this->getSongsFromScrobbler(true)) {
                        $this->songs = $this->decodeScrobblerArray($songs);
                    }
                    return;
                }
                //destack the cache - *needed?*
                if (count($this->decodeScrobblerArray($songs)) > $this->number) {
                    echo '<!-- destacking cache -->'."\n";
                    $songs = $this->deStackerScrobbler($this->decodeScrobblerArray($songs));
                    $this->writeScrobblerCache($songs);
                    return;
                }
                //return an O.K. cache
                echo '<!-- cache read -->'."\n";
                $this  ->songs = $this->decodeScrobblerArray($songs);
            }
        }
    }

    //renders the output
    function renderScrobblerOutput() {
        $formatstring       =   $this->get_config('formatstring');
        $formatstring_block =   $this->get_config('formatstring_block');
        $artistlink         =   $this->get_config('artistlink');
        $songlink           =   $this->get_config('songlink');
        $spacer             =   $this->get_config('spacer');
        $profiletitle       =   $this->get_config('profiletitle');
        $this              -> getSongsFromScrobbler();
        $this              -> readScrobblerCache();

        if ($this->get_config('newwindow')) {
            $onlick = ' onclick="window.open(this.href);"';
        }

        if (!$this->songs) {
            echo '<span style="font-weight: bold;">'.PLUGIN_AUDIOSCROBBLER_ERROR.':</span><br /><ul><li>'.join('</li><li>', $this->scrobbler_error).'</li></ul>';
            return;
        }
        $content    = array();
        $i          = 0;
        foreach ($this->songs as $key => $value) {
            $value['artisttitle']   = mb_convert_encoding($value['artisttitle'], 'ISO-8859-1', 'UTF-8');
            $value['songtitle']     = mb_convert_encoding($value['songtitle'], 'ISO-8859-1', 'UTF-8');
            $add = '';
            if ($songlink) {
                if (is_string(strstr($value['link'], '&mode'))) {
                    //fix ampersand entity
                       $song    = '<a href="'.str_replace('&mode', '&amp;mode', $value['link']). '"'.$onclick.'>'.(function_exists('serendipity_specialchars') ? serendipity_specialchars($value['songtitle'], ENT_QUOTES) : htmlspecialchars($value['songtitle'], ENT_QUOTES| ENT_COMPAT, LANG_CHARSET)).'</a>'."\n";
                } elseif (is_string(strstr($value['link'], '&amp;mode'))) {
                    //link is ok
                    $song   = '<a href="'.$value['link']. '"'.$onclick.'>'.(function_exists('serendipity_specialchars') ? serendipity_specialchars($value['songtitle'], ENT_QUOTES) : htmlspecialchars($value['songtitle'], ENT_QUOTES| ENT_COMPAT, LANG_CHARSET)).'</a>'."\n";
                } else {
                    //encode it
                    $song   = '<a href="http://www.audioscrobbler.com/music/'.urlencode(utf8_encode($value['artisttitle'])). '/_/'.urlencode(utf8_encode($value['songtitle'])).'"'.$onclick.'>'.(function_exists('serendipity_specialchars') ? serendipity_specialchars($value['songtitle'], ENT_QUOTES) : htmlspecialchars($value['songtitle'], ENT_QUOTES| ENT_COMPAT, LANG_CHARSET)).'</a>'."\n";
                }
            } else {
                $song = (function_exists('serendipity_specialchars') ? serendipity_specialchars($value['songtitle'], ENT_QUOTES) : htmlspecialchars($value['songtitle'], ENT_QUOTES| ENT_COMPAT, LANG_CHARSET));
            }
            if ($artistlink == 0) {
                $artist = (function_exists('serendipity_specialchars') ? serendipity_specialchars($value['artisttitle'], ENT_QUOTES) : htmlspecialchars($value['artisttitle'], ENT_QUOTES| ENT_COMPAT, LANG_CHARSET));
            } elseif ($artistlink == 1) {
                $artist = '<a href="http://www.audioscrobbler.com/music/'.urlencode(utf8_encode($value['artisttitle'])).'"'.$onclick.'>'.(function_exists('serendipity_specialchars') ? serendipity_specialchars($value['artisttitle'], ENT_QUOTES) : htmlspecialchars($value['artisttitle'], ENT_QUOTES| ENT_COMPAT, LANG_CHARSET)).'</a>'."\n";
            } elseif ($artistlink == 2) {
                if ($value['artisttitle'] != '' || $value['artistlink'] != 'http://mm.musicbrainz.org/artist/') {
                    $artist = '<a href="' . $value['artistlink'] . '"'.$onclick.'>'.(function_exists('serendipity_specialchars') ? serendipity_specialchars($value['artisttitle'], ENT_QUOTES) : htmlspecialchars($value['artisttitle'], ENT_QUOTES| ENT_COMPAT, LANG_CHARSET)).'</a>'."\n";
                } else {
                    $artist = (function_exists('serendipity_specialchars') ? serendipity_specialchars($value['artisttitle'], ENT_QUOTES) : htmlspecialchars($value['artisttitle'], ENT_QUOTES| ENT_COMPAT, LANG_CHARSET));
                }
            } else {
                if (trim($value['artistlink']) != 'http://mm.musicbrainz.org/artist/' && trim($value['artistlink']) != '') {
                    $artist = '<a href="' . $value['artistlink'] . '"'.$onclick.'>'.(function_exists('serendipity_specialchars') ? serendipity_specialchars($value['artisttitle'], ENT_QUOTES) : htmlspecialchars($value['artisttitle'], ENT_QUOTES| ENT_COMPAT, LANG_CHARSET)).'</a>'."\n";
                } else {
                    $artist = '<a href="http://www.audioscrobbler.com/music/'.urlencode(utf8_encode($value['artisttitle'])).'"'.$onclick.'>'.(function_exists('serendipity_specialchars') ? serendipity_specialchars($value['artisttitle'], ENT_QUOTES) : htmlspecialchars($value['artisttitle'], ENT_QUOTES| ENT_COMPAT, LANG_CHARSET)).'</a>'."\n";
                }
            }
            $replacements   = array('%ARTIST%' => $artist, '%SONG%' => $song, '%DATE%' => $this->renderScrobblerDate($value['date'], $dateformat));
            $add            = str_replace(array_keys($replacements), array_values($replacements), $formatstring);
            $content[]      = $add;
            $i++;
            if ($i == $this->number) {
                break;
            }
        }
        $entries        = join($spacer, $content);
        $output         = str_replace('%ENTRIES%', $entries,  $formatstring_block);
        $profiletitle   = str_replace('%USER%', $this->username, $profiletitle);
        $output         = str_replace('%PROFILE%', '<a href="http://www.audioscrobbler.com/user/'.urlencode(utf8_encode($this->username)).'"'.$onclick.'>'.(function_exists('serendipity_specialchars') ? serendipity_specialchars($profiletitle, ENT_QUOTES) : htmlspecialchars($profiletitle, ENT_QUOTES| ENT_COMPAT, LANG_CHARSET)).'</a>',  $output);
        $lstime         = serendipity_formatTime($this->get_config('dateformat'), filemtime($this->scrobblercache), true);
        $output         = str_replace('%LASTUPDATE%', 
          (function_exists('serendipity_specialchars') 
           ? serendipity_specialchars($lstime)
           : htmlspecialchars($lstime, ENT_COMPAT, LANG_CHARSET)
          ), 
          $output
        );
        $output = str_replace('audioscrobbler.com', 'last.fm', $output);
        return $output;
    }

    //checks and formats the settings
    function doConfig() {
        global $serendipity;
        $this->number                   = (intval($this->get_config('number')) == 0) ? 1 : intval($this->get_config('number'));
        $this->username                 = trim($this->get_config('username'));
        $this->cachetime                = (intval($this->get_config('cachetime')) == 0) ? 300 : ($this->get_config('cachetime') * 60);
        $this->scrobblercache           = $serendipity['serendipityPath'] . 'templates_c/audioscrobbler_cache_' . preg_replace('@[^a-z0-9]*@i', '', $this->username) . '.dat';
        $this->utcdifference            = intval($this->get_config('utcdifference'));
        $this->scrobblerlastupdate      = intval($this->get_config('lastupdate'));
    }

    function generate_content(&$title) {
        $sidebartitle           =   $title = $this->get_config('sidebartitle', $this->title);
        $this->doConfig();
        echo "\n".$this->renderScrobblerOutput()."\n";
    }
}
?>
