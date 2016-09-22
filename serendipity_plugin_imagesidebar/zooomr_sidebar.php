<?php 

class zooomr_sidebar extends subplug_sidebar {

    function introspect_config_item_custom($name, &$propbag)
    {
        global $serendipity;

        switch ($name) {
            case 'feed':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_ZOOOMR_FEEDURL);
                $propbag->add('description', PLUGIN_ZOOOMR_FEEDDESC);
                $propbag->add('default', 'http://beta.zooomr.com/bluenote/feeds:rss/tags/bird');
                break;
            case 'imagecount':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_ZOOOMR_IMGCOUNT);
                $propbag->add('description', PLUGIN_ZOOOMR_IMGCOUNTDESC);
                $propbag->add('default', '4');
                break;
            case 'imagewidth':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_ZOOOMR_IMGWIDTH);
                $propbag->add('default', '65');
                break;
            case 'dlink':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_ZOOOMR_DLINK);
                $propbag->add('description', PLUGIN_ZOOOMR_DLINKDESC);
                $propbag->add('default', false);
                break;
            case 'logo':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_ZOOOMR_LOGO);
                $propbag->add('default', true);
                break;
        }
        return true;
    }
    

    function introspect_custom()
    {
//        $propbag->add('version',  '0.1');
//        $propbag->add('author',  'Stefan Lange-Hegermann');
        return array('title', 'feed','imagecount','imagewidth', 'dlink','logo');
    }
    
    /**
    * serendipity_plugin_zooomr::generate_content()
    *
    * @param  $title
    * @return
    */
    function generate_content_custom(&$title) {
        $feedurl    =     $this->get_config('feed');
        $count      =(int)$this->get_config('imagecount');
        $imgwidth   =(int)$this->get_config('imagewidth');
        $dlink      =     $this->get_config('dlink');
        $logo       =     $this->get_config('logo');
        $title      =     $this->get_config('title');;
        $buffer=$this->getURL($feedurl);
        
        $content = '<div class="serendipityPluginZooomr">';
        
        $allitems=preg_split ( "/<\/*item>/", $buffer);
        
        for ($a=1;$a<($count*2);$a+=2) {
            if ($allitems[$a]) {
                preg_match ( '/<media:thumbnail url="([^"]*)"/', $allitems[$a] , $thumbhits);
                preg_match ( '/<media:content url="([^"]*)"/', $allitems[$a] , $bighits);
                preg_match ( '/<link\>([^<]*)/', $allitems[$a] , $linkhits);
                
                if ($linkhits[1]) {
                    if ($dlink) {
                        $linkurl=$bighits[1];
                        $rellink=' rel="lightbox[sidebar]"';
                    } else {
                        $linkurl=$linkhits[1];
                        $rellink='';
                    }
                    $content .= "\n".'<a href="'.$linkurl.'"'.$rellink.'><img style="width:'.$imgwidth.'px" src="'.$thumbhits[1].'" /></a>';
                }
            }
        }
        
        if ($logo)
            $content.='Hosted on <strong>Zooom<span style="color:#9EAE15;">r</span></strong>';
        $content.='</div>';
        
        echo $content;
    }

    /**
    * downloads the content from an URL and returns it as a string
    *
    * @author Stefan Lange-Hegermann
    * @since 02.08.2006
    * @param string $url URL to get
    * @return string downloaded Data from "$url"
    */
    function getURL($url) {
        if (function_exists('serendipity_request_url')) {
            $store = serendipity_request_url($url);
        } else {
            $options = array();
            require_once S9Y_PEAR_PATH . 'HTTP/Request.php';
            if (function_exists('serendipity_request_start')) {
                serendipity_request_start();
            }
                                                                            
            $req = new HTTP_Request($url,$options);
            $req_result = $req->sendRequest();
            if ( PEAR::isError( $req_result)) {
                echo PLUGIN_GALLERYRANDOMBLOCK_ERROR_CONNECT . "<br />\n";
            } else {
                $res_code = $req->getResponseCode();
                if ($res_code != "200") {
                    printf( PLUGIN_GALLERYRANDOMBLOCK_ERROR_HTTP . "<br />\n", $res_code);
                } else {
                    $store = $req->getResponseBody();
                }
            }
        }
        return $store;
    }

}
?>