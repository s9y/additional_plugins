<?php
//xml.inc has everything we need to do the actual xml.amazon.com query.
include_once('soap.inc');


//Stole a lot of this code from serendipity_plugin_shoutbox. Thanks, helped me a lot!


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_currently extends serendipity_plugin
{
    var $title = PLUGIN_CURRENTLY_NAME;

    var $associates_tag = '';
    var $associates_id  = '';
    var $associates_key = '';

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_CURRENTLY_NAME);
        $propbag->add('description',   PLUGIN_CURRENTLY_DETAIL);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Dustin Hawkins');
        $propbag->add('version',       '2.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '5.0.1'
        ));
        $propbag->add('groups', array('FRONTEND_VIEWS'));

        $propbag->add('configuration', array(
                                             'reading','reading_locale',
                                             'listening_band',
                                             'listening_album',
                                             'listening_track','listening_locale',
                                             'playing','playing_locale',
                                             'watching','watching_locale',
					     'associates', 'associates_tag','associates_id','associates_key'));
    }

    function introspect_config_item($name, &$propbag) {

        global $serendipity;

        $select = array('US' => 'Amazon.com',
                        'DE' => 'Amazon.de',
                        'FR' => 'Amazon.fr',
                        'JP' => 'Amazon.co.jp',
                        'CA' => 'Amazon.ca',
                        'UK' => 'Amazon.co.uk');

        switch ($serendipity['lang']) {

            case 'de': $select_default = 'DE'; break;
            case 'fr': $select_default = 'FR'; break;
            case 'ja': $select_default = 'JP'; break;
            case 'en':
            default:   $select_default = 'US'; break;

        }//switch

        switch($name) {
            case 'reading':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_CURRENTLY_READING);
                $propbag->add('description', PLUGIN_CURRENTLY_READING_DETAILS);
                $propbag->add('default','');
                break;

            case 'reading_locale':
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_CURRENTLY_LOCALE);
                $propbag->add('description', PLUGIN_CURRENTLY_LOCALE_DETAILS);
                $propbag->add('select_values', $select);
                $propbag->add('default', $select_default);
                break;

            case 'listening_band':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_CURRENTLY_LISTENING_BAND);
                $propbag->add('description', PLUGIN_CURRENTLY_LISTENING_BAND_DETAILS);
                $propbag->add('default','');
                break;

            case 'listening_album':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_CURRENTLY_LISTENING_ALBUM);
                $propbag->add('description', PLUGIN_CURRENTLY_LISTENING_ALBUM_DETAILS);
                $propbag->add('default','');
                break;
            case 'listening_track':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_CURRENTLY_LISTENING_TRACK);
                $propbag->add('description', PLUGIN_CURRENTLY_LISTENING_TRACK_DETAILS);
                $propbag->add('default','');
                break;

            case 'listening_locale':
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_CURRENTLY_LOCALE);
                $propbag->add('description', PLUGIN_CURRENTLY_LOCALE_DETAILS);
                $propbag->add('select_values', $select);
                $propbag->add('default', $select_default);
                break;

            case 'playing':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_CURRENTLY_PLAYING);
                $propbag->add('description', PLUGIN_CURRENTLY_PLAYING_DETAILS);
                $propbag->add('default','');
                break;

            case 'playing_locale':
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_CURRENTLY_LOCALE);
                $propbag->add('description', PLUGIN_CURRENTLY_LOCALE_DETAILS);
                $propbag->add('select_values', $select);
                $propbag->add('default', $select_default);
                break;

            case 'watching':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_CURRENTLY_WATCHING);
                $propbag->add('description', PLUGIN_CURRENTLY_WATCHING_DETAILS);
                $propbag->add('default','');
                break;

            case 'watching_locale':
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_CURRENTLY_LOCALE);
                $propbag->add('description', PLUGIN_CURRENTLY_LOCALE_DETAILS);
                $propbag->add('select_values', $select);
                $propbag->add('default', $select_default);
                break;
            
	    case 'associates':
                $propbag->add('type', 'content');
                $propbag->add('default', PLUGIN_CURRENTLY_AMAZON_DETAILS);
                break;

            case 'associates_tag':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_CURRENTLY_AMAZON_TAG);
                $propbag->add('description', PLUGIN_CURRENTLY_AMAZON_TAG_DETAILS);
                $propbag->add('default','');
                break;

            case 'associates_id':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_CURRENTLY_AMAZON_ID);
                $propbag->add('description', PLUGIN_CURRENTLY_AMAZON_ID_DETAILS);
                $propbag->add('default','');
                break;

            case 'associates_key':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_CURRENTLY_AMAZON_KEY);
                $propbag->add('description', PLUGIN_CURRENTLY_AMAZON_KEY_DETAILS);
                $propbag->add('default','');
                break;


            default:
                    return false;
        }
        return true;
    }


    // Querying Amazon every time we want an image is very slow, so we created a
    // very very simple table to hold values and if the value has already been looked up, return it.
    // Otherwise, query amazon.

    function search_database($search,$section='Books',$locale='US') {


        global $serendipity;

        $search = serendipity_db_escape_string($search);
        $section = serendipity_db_escape_string($section);

        $sql = "SELECT c.url, c.detail FROM ".$serendipity['dbPrefix']."currently c WHERE c.search LIKE '$search' AND c.section='$section' LIMIT 1";
        #print ("<!--$sql-->");
        $results = serendipity_db_query($sql);

        if ($results[0]['url']!='') {

            return (array("Image"=>$results[0]['url'],"Detail"=>$results[0]['detail']));

        } elseif ($image_lookup = find_best_image($search,$section,$locale,$this->associates_tag,$this->associates_id,$this->associates_key)) {

            $this->add_database ($image_lookup,$search,$section);
            return ($image_lookup);

        }

        return (false);

    }//search database

    //This will add a recently looked up value to the database

    function add_database ($urls,$search,$section) {

        global $serendipity;
        $url_image = $urls[Image];
        $url_detail = $urls[Detail];

        $sql = "DELETE FROM ".$serendipity['dbPrefix']."currently WHERE search = '$search' AND section = '$section'";
        serendipity_db_query($sql);

        $sql = "INSERT INTO ".$serendipity['dbPrefix']."currently (url,search,section,detail) VALUES ('$url_image','$search','$section','$url_detail')";
     //   print ("\n<!--$sql-->\n");
        serendipity_db_query($sql);
    }

    function generate_content(&$title)
    {
        global $serendipity;

        $title              = $this->title;
        $reading            = $this->get_config('reading');
        $reading_locale     = $this->get_config('reading_locale');
        $listening_band     = $this->get_config('listening_band');
        $listening_album    = $this->get_config('listening_album');
        $listening_track    = $this->get_config('listening_track');
        $listening_locale     = $this->get_config('listening_locale');
        $playing            = $this->get_config('playing');
        $playing_locale     = $this->get_config('plaing_locale');
        $watching           = $this->get_config('watching');
        $this->associates_tag     = $this->get_config('associates_tag');
        $this->associates_id      = $this->get_config('associates_id');
        $this->associates_key     = $this->get_config('associates_key');

        // Create table, if its not there, or if we have a new version

        if ($this->get_config('version') != '1.01') {

           $q   = "CREATE TABLE {$serendipity['dbPrefix']}currently (
                        id {AUTOINCREMENT} {PRIMARY},
                        search varchar(255) default NULL,
                        section varchar(255) default NULL,
                        detail text,
                        url text
                    )";
            $sql = serendipity_db_schema_import($q);
            //$results = serendipity_db_query($sql);
            $this->set_config('version', '1.01');
        }

        echo '<dl>';

        if ($reading != '') {

            print ("<dt><strong>".PLUGIN_CURRENTLY_READING."</strong></dt><dd>$reading</dd>");

            $reading_image = $this->search_database($reading,'Books',$reading_locale);

            if ($reading_image) print ("<dd><a href='$reading_image[Detail]'><img src='$reading_image[Image]'></a></dd>");
        }//fi

        if ($listening_band != '') {

            print ("<dt><strong>".PLUGIN_CURRENTLY_LISTENING."</strong></dt><dd>$listening_band</dd>");

            if ($listening_album) print ("<dd>($listening_album)</dd>");
            if ($listening_track) print ("<dd><em>$listening_track</em></dd>");

            // The most reliable way to get the proper album cover off amazon is searching for "Artist - Album"
            // which is why I seperated everything out. Some people didnt mind putting everyting in one
            // text box, but some wanted the song title which messed up the query a lot, and some wanted just
            // the album and band displayed.

            $listen_search="$listening_band - $listening_album";
            $listening_image = $this->search_database($listen_search,'Music',$listening_locale);

            if ($listening_image) print ("<dd><a href='$listening_image[Detail]'><img src='$listening_image[Image]'></a></dd>");
        }//fi

        if ($playing != '') {

            print ("<dt><strong>".PLUGIN_CURRENTLY_PLAYING."</strong></dt>"); print ("<dd>$playing</dd>");

            $playing_image = $this->search_database($playing,'VideoGames',$playing_locale);

            if ($playing_image) print ("<dd><a href='$playing_image[Detail]'><img src='$playing_image[Image]'></a></dd>");
        }//fi


        if ($watching != '') {

            print ("<dt><strong>".PLUGIN_CURRENTLY_WATCHING."</strong></dt><dd>$watching</dd>");

            $watching_image = $this->search_database($watching,'Video',$watching_locale);

            if ($watching_image) print ("<dd><a href='$watching_image[Detail]'><img src='$watching_image[Image]'></a></dd>");
        }//fi

        echo '</dl>';
    }//generate_content

}//class

/* vim: set sts=4 ts=4 expandtab : */
?>
