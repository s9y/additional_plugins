<?php
/*
 * Created on 08.06.2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

include dirname(__FILE__) . '/json.php4.include.php';

class UrlShortener {

    // This login is a generic that fails in most cases because of exceeded ratio limits. 
    var $bitly_login = 'bitlyapidemo';
    var $bitly_apikey = 'R_0da49e0a9118ff35f52f629d2d71bf07';
    
    function setBitlyLogin($login, $apikey) {
        if (empty($login) || empty($apikey)) return;
        $this->bitly_login = $login;
        $this->bitly_apikey = $apikey;
    }
    
    /**
     * Fills up the shorturls hash with shorturls identified by service name. 
     */
    function put_shorturl($service, $url, &$shorturls) {
        global $serendipity;

        switch ($service) {
            case 'linktrimmer':
                if (class_exists('serendipity_event_linktrimmer')) {
                    $res = serendipity_db_query("SELECT value FROM `serendipity_config` WHERE name LIKE 'serendipity_event_linktrimmer:%/prefix';", true, 'assoc');
                    if (is_array($res) && !empty($res['value'])) {
                        $lt_prefix = "/" . trim($res['value']) . "/";
                    }
                    $res = serendipity_db_query("SELECT value FROM `serendipity_config` WHERE name LIKE 'serendipity_event_linktrimmer:%/domain';", true, 'assoc');
                    if (is_array($res) && !empty($res['value'])) {
                        $lt_domain = trim($res['value']);
                    }
                    if (empty($lt_domain)) $lt_domain = $serendipity['baseURL'];
                    if (empty($lt_prefix)) $lt_prefix = '/s/';

                    if ($lt_domain == $serendipity['baseURL'])  {
                        $shorturls['linktrimmer'] = $lt_domain. $lt_prefix .trim(serendipity_event_linktrimmer::lookup($url));
                    } else {
                        $shorturls['linktrimmer'] = $lt_domain . trim(serendipity_event_linktrimmer::lookup($url));
                    }
                }
                break;
            case 'raw':
                $shorturls['raw'] = $url;
                break;
            case 'tinyurl':
                UrlShortener::shorten_via_tinyurl( $url, $shorturls );
                break;
            case '7ax.de':
                UrlShortener::shorten_via_7ax( $url, $shorturls );
                break;
            case 'isgd':
                UrlShortener::shorten_via_isgd( $url, $shorturls );
                break;
            case 'bitly':
                UrlShortener::shorten_via_bitly( $url, $shorturls );
                break;
            case 'jmp':
                UrlShortener::shorten_via_jmp( $url, $shorturls );
                break;
            case 'delivr':
                UrlShortener::shorten_via_delivr( $url, $shorturls );
                break;
            case 'twurl':
                UrlShortener::shorten_via_twurl( $url, $shorturls );
                break;
            case 'piratly':
                UrlShortener::shorten_via_piratly( $url, $shorturls );
                break;
            // old removed service
            case 'snipr': 
            case 'tr.im':
            case 'cli.gs':
                UrlShortener::shorten_via_7ax( $url, $shorturls );
                break;
        }
    }
    
    /**
     * Shorten an URL via a simple HTTP Get returning the short url only
     * @param array shorturls List of processed short urls, where the new short url is added into
     * @param string servicename short name of the service.
     * @param string servicecall complete service URL to be called returning the short URL only
     * @access   private
     */
    function shorten_via_simple( &$shorturls, $servicename, $servicecall ) {
        require_once S9Y_PEAR_PATH . 'HTTP/Request.php';
        
        // if we already evaluated the shorturl, stop here
        if (!empty($shorturls[$servicename])) return;
        
        serendipity_request_start();
        $req = new HTTP_Request($servicecall, array('timeout' => 20, 'readTimeout' => array(5,0)));
        $req->sendRequest();
        $short_url = $req->getResponseBody();
        serendipity_request_end();
        if ($req->getResponseCode()==200) {
            $short_url = trim($short_url);
            if (strlen($short_url)<255) { // Should be an URL at least
                $shorturls[$servicename] = trim($short_url);
            }
        }
    }
    // Working!
    function shorten_via_tinyurl( $url, &$shorturls ) {
        $url = urlencode($url);
        UrlShortener::shorten_via_simple($shorturls, 'tinyurl', "http://tinyurl.com/api-create.php?url=$url");
    }
    
    function shorten_via_7ax( $url, &$shorturls ) {
        $url = urlencode($url);
        UrlShortener::shorten_via_simple($shorturls, '7ax.de', "http://7ax.de/api.php?url=$url");
    }
    
    function shorten_via_piratly( $url, &$shorturls ) {
        $url = urlencode($url);
        UrlShortener::shorten_via_simple($shorturls, 'piratly', "http://pirat.ly/shortener/createplain/0/?$url");
    }
    
    // is.gd returns different short urls for same URL! How to handle this?!
    // works *sometimes*
    function shorten_via_isgd( $url, &$shorturls ) {
        $url = urlencode($url);
        UrlShortener::shorten_via_simple($shorturls, 'isgd', "http://is.gd/api.php?longurl=$url");
    }
    
    // twurl.nl returns different short urls for same URL! How to handle this?!
    // works *sometimes*
    // tinyburner.com
    function shorten_via_twurl( $url, &$shorturls ) {
        require_once S9Y_PEAR_PATH . 'HTTP/Request.php';
        
        // if we already evaluated the shorturl, stop here
        if (!empty($shorturls['twurl'])) return;
        
        serendipity_request_start();
        $req_url = "http://tweetburner.com/links";
        $req = new HTTP_Request($req_url, array('method' => HTTP_REQUEST_METHOD_POST, 'timeout' => 20, 'readTimeout' => array(5,0)));
        $req->addPostData('link[url]',$url, true);
        $req->sendRequest();
        $short_url = trim($req->getResponseBody());
        serendipity_request_end();
        if ($req->getResponseCode()==200) {
            $shorturls['twurl'] = $short_url;
        }
    }

    function shorten_via_bitly( $url, &$shorturls ) {
        // if we already evaluated the shorturl, stop here
        if (!empty($shorturls['bitly'])) return;

        $short_url = trim(UrlShortener::_make_bitly_api_url($url,'xml'));
        if (!empty($short_url)) {
            $shorturls['bitly'] = $short_url;
        }
    }

    function shorten_via_jmp( $url, &$shorturls ) {
        // if we already evaluated the shorturl, stop here
        if (!empty($shorturls['jmp'])) return;

        $short_url = trim(UrlShortener::_make_bitly_api_url($url,'xml','j.mp'));
        if (!empty($short_url)) {
            $shorturls['jmp'] = $short_url;
        }
    }
    
    /* bit.ly called via api */
    function _make_bitly_api_url($url,$format = 'xml',$domain='bit.ly')
    {
        require_once S9Y_PEAR_PATH . 'HTTP/Request.php';
        
        //create the API Call URL
        $bitly = 'http://api.bit.ly/v3/shorten?longUrl='.urlencode($url).'&login='.$this->bitly_login.'&apiKey='.$this->bitly_apikey.'&format='.$format.'&domain='.$domain;
        
        //get the url
        serendipity_request_start();
        $req = new HTTP_Request($bitly, array('timeout' => 20, 'readTimeout' => array(5,0)));
        $req->sendRequest();
        $response = $req->getResponseBody();
        serendipity_request_end();
        if ($req->getResponseCode()!=200) {
            return false;
        }
        if (strlen($response) < 1) {
            return false;
        }
        
        //parse depending on desired format
        if(strtolower($format) == 'json')
        {
            $json = @json_decode($response);
            $results = get_object_vars($json->results);
            return $results[$url]->shortUrl;
        }
        else //xml
        {
            $vals = array();
            $index = array();
            $parser = xml_parser_create();
            xml_parse_into_struct($parser, $response, $vals, $index);
            xml_parser_free($parser);
            return $short_url = $vals[$index['URL'][0]][value];
        }
    }

    /*
     * Doesn't work realy and is ultra slow..
     */
    function shorten_via_delivr( $url, &$shorturls ) {
        require_once S9Y_PEAR_PATH . 'HTTP/Request.php';

        // if we already evaluated the shorturl, stop here
        if (!empty($shorturls['delivr'])) return;
        
        $login  = 'public';
        $apikey = '8bbce762-971e-45d6-a0e1-cbf5730252ea';
        
        $url = urlencode($url);
        $req_url = "http://api.delivr.com/shorten?username=$login&apiKey=$apikey&format=xml&url=" . $url;
        
        serendipity_request_start();
        $req = new HTTP_Request($req_url, array('timeout' => 20, 'readTimeout' => array(5,0)));
        $req->sendRequest();
        $xml = $req->getResponseBody();
        serendipity_request_end();
        
        if ($req->getResponseCode()==200) {
            $vals = array();
            $index = array();
            $parser = xml_parser_create();
            xml_parse_into_struct($parser, $xml, $vals, $index);
            xml_parser_free($parser);
            
            $short_url = 'http://delivr.com/' . $vals[$index['DELIVRID'][0]][value];
            $shorturls['delivr'] = trim($short_url);
        }
    }
    
    // Fills in "special" services, if one service produces more than one result.
    function fillup_extra_services( &$services ) {
        if (array_search('bitly',$services)) {
            $services[] = 'bitly_json';
        }
    }

}
?>
