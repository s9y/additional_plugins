<?php

include dirname(__FILE__) . '/json.php4.include.php';
include dirname(__FILE__) . '/twitter_entry_defs.include.php';

class TwitterOAuthApi {
    var $oauthConnection = null;
    
    function TwitterOAuthApi(&$oauthConnection) {
        $this->oauthConnection = $oauthConnection;        
    }
    
    function update($update, $geo_lat = null, $geo_long = null) {
        $parameters = array('status' => $update);
        if (!empty($geo_lat) && !empty($geo_long)) {
            $parameters['lat'] = $geo_lat;
            $parameters['long'] = $geo_long;
            $parameters['display_coordinates'] = 'true'; 
        }
        $status = $this->oauthConnection->post('statuses/update', $parameters);
        return $status;
    }
    
    function search($search, $entries=null, $fetchall=true) {
        
        $search_twitter_api = 'https://api.twitter.com/1.1/search/tweets.json';
        
        $search_uri = $search_twitter_api  . '?q=' . $search;

        $paging = true;
        while ($paging) {
            $json = $this->oauthConnection->get($search_uri);
            
            if (!is_array($entries) || empty($entries)) $entries = array();
            foreach ($json->statuses as $item) {
                $entry = TwitterOAuthApi::parse_entry_json( $item );
                
                // Debug: remember the search executed
                $entry[TWITTER_SEARCHRESULT_URL_QUERY] = $search;
                
                // Watch out: If $item->id is interpreted as int, high values produce problems
                // So I force strings as array keys here.
                $entries[$entry[TWITTER_SEARCHRESULT_ID]] = $entry; // overwrite old entry, if already have one
            }
            $paging = !empty($json->next_page);
            if ($fetchall && $paging) {
                $search_uri = $search_twitter_api . $json->next_page; 
            }
        }
        
        return $entries;
    }
    
    /**
     * Searches for multiple keywords
     * @param array keywords The keywords to search for
     * @param string since_id Limit results to entries starting after since_id 
     * @param boolean search_or search using OR or AND
     */
    static function search_multiple(&$oauthConnection, $keyword, $since_id = null, $search_or = true) {
        $entries = array();
        $search_twitter_api = 'search/tweets.json';
        
        // Filter: tweeds containing links only. 
        // This Filter doesn't work at the moment, will produce an empty result!
        // It is not neccessary for us, only a hint for twitter.
        // rpp: results per page
        $filter = ''; // +filter:links
        if (!empty($since_id)) {
            $filter .= "&since_id=$since_id";
        }
        
        $query = $keyword; //urlencode($keyword);
        
        // Filter will be added to the query, so substract it.
        $max_query_len = 139 - strlen($filter);
        
        // Now execute the queries        
        $api = new TwitterOAuthApi($oauthConnection);
        $newentries = $api->search($query . $filter, $entries);
        if ($newentries===false) { // Error occured, mostly resultet in an twitter overload!
            echo "<b>Search qry</b>: ". $search_twitter_api.".?q={$query}{$filter}<br/>";
            if (!empty($api->error_response)) {
                $response = json_decode($api->error_response);
                if (!empty($response->error)) $errormsg=$response->error;
                else {
                    $errormsg=$api->error_response;
                }
                echo "<b>Error Resp</b>: {$errormsg}<br/>";
            }
            $newentries = array();
        }
        $entries = $newentries;
        return $entries;
    }
    
    /**
     * Base URL of service
     * @access   private
     */
    static function get_base_url() {
        return "https://twitter.com/";
    }
    
    static function parse_entry_json( $item ) {
        $entry = array();
        
        if (preg_match('/href="([^"]*)"/',html_entity_decode($item->source),$matches)) {
            $source_link = $matches[1][0];
        }
        //$link = str_replace('<a href="','',str_replace('"/a>','',html_entity_decode($item['source'])));
        $user = $item->user;
        
        $entry[TWITTER_SEARCHRESULT_LOGIN] = $user->screen_name;
        $entry[TWITTER_SEARCHRESULT_REALNAME] = $user->name;
        
        if( !function_exists('htmlspecialchars_decode') ) {
            $entry[TWITTER_SEARCHRESULT_TWEET] = $item->text; // PHP4 Version w/o html_specialcar decoding. 
        }
        else {
            $entry[TWITTER_SEARCHRESULT_TWEET] = htmlspecialchars_decode($item->text);
        }

        $uniq = (isset($item->id_str) ? $item->id_str : sprintf('%0.0f', $item->id));        
        $entry[TWITTER_SEARCHRESULT_ID] = $uniq;

        $entry[TWITTER_SEARCHRESULT_URL_AUTOR] = TwitterOAuthApi::get_base_url() . $entry[TWITTER_SEARCHRESULT_LOGIN];
        $entry[TWITTER_SEARCHRESULT_URL_IMG] = $user->profile_image_url;
        $entry[TWITTER_SEARCHRESULT_URL_TWEET] = TwitterOAuthApi::get_base_url() . $entry[TWITTER_SEARCHRESULT_LOGIN] . '/status/' . $entry[TWITTER_SEARCHRESULT_ID];

        if (!empty($source_link)) $entry[TWITTER_SEARCHRESULT_URL_SRC] = $source_link;
        $entry[TWITTER_SEARCHRESULT_PUBDATE] = $item->created_at;
        $entry[TWITTER_SEARCHRESULT_RETWEET] = preg_match('/^(rt|retweet|retweeting)[ :].*/i',$item->text);
        
        // get expanded urls
        if (!empty($item->entities)) {
            if (!empty($item->entities->urls)) {
                $urls = array();
                $urlsExpanded = array();
                $redirCheck = new RedirectCheck();
                foreach ($item->entities->urls as $url) {
                    if (!empty($url->expanded_url)) {
                        $urls[] =$url->expanded_url;
                    }
                }
                $entry[TWITTER_SEARCHRESULT_URL_ARRAY] = $urls;
            }
        }
        return $entry;
    }
}