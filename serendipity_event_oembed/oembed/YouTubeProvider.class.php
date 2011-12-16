<?php
class YouTubeProvider extends EmbedProvider {
    public function match($url){
        return preg_match('/youtube.com\/watch\?v=([\w-]+)/',$url) || preg_match('/youtu.be\/([\w-]+)/',$url); // http://youtu.be/8UVNT4wvIGY
    }
    public function getEmbed($url){
        $urlArray=array();
        if(preg_match("/(www.)?youtube.com\/watch\?v=([\w-]+)/",$url,$matches)){
            $video_id=$matches[2];
        }
        else if(preg_match("/(www.)?youtu.be\/([\w-]+)/",$url,$matches)){
            $video_id=$matches[2];
        }

        $myEmbed = new VideoEmbed();
        $myEmbed->type='video';
        $myEmbed->version='1.0';
        $myEmbed->provider_name="Youtube";
        $myEmbed->provider_url="http://youtube.com";
        $myEmbed->resource_url=$url;
        $xml = new DOMDocument;
        if(@($xml->load('http://gdata.youtube.com/feeds/api/videos/'.$video_id))) {
            @$guid = $xml->getElementsByTagName("guid")->item(0)->nodeValue;
            $link = str_replace("http://www.youtube.com/watch?v=","http://bergengocia.net/indavideobombyoutubemashup/view.php?id=",$guid);
            $myEmbed->title =$xml->getElementsByTagName("title")->item(0)->nodeValue;
            $myEmbed->description =$xml->getElementsByTagNameNS("*","description")->item(0)->nodeValue;
            $myEmbed->author_name =$xml->getElementsByTagName("author")->item(0)->getElementsByTagName("name")->item(0)->nodeValue;
            $myEmbed->author_url =$xml->getElementsByTagName("author")->item(0)->getElementsByTagName("uri")->item(0)->nodeValue;
            $myEmbed->thumbnail_url =$xml->getElementsByTagNameNS("*","thumbnail")->item(0)->getAttribute("url");
            $myEmbed->thumbnail_width =$xml->getElementsByTagNameNS("*","thumbnail")->item(0)->getAttribute("width");
            $myEmbed->thumbnail_height =$xml->getElementsByTagNameNS("*","thumbnail")->item(0)->getAttribute("height");
            $med_content_url=$xml->getElementsByTagNameNS("http://search.yahoo.com/mrss/","content")->item(0)->getAttribute("url");
            $myEmbed->html=
                                  '<object width="425" height="350">'."\n".
                                  ' <param name="movie" value="'.$med_content_url.'"></param>'."\n".
                                  ' <embed src="'.$med_content_url.'"'. 
                                  '  type="application/x-shockwave-flash" width="425" height="350">'."\n".
                                  ' </embed>'."\n".
                                  '</object>'; // according to http://code.google.com/apis/youtube/developers_guide_protocol.html#Displaying_information_about_a_video
            $myEmbed->width="425";
            $myEmbed->height="350"; // same as in the html
            //$myEmbed->duration=$xml->getElementsByTagNameNS($xml->lookupNamespaceURI("*"),"content")->item(0)->getAttribute("duration");
            //$time = floor($duration / 60) . ":" . $duration % 60;
            return $myEmbed;
        } else throw new Exception404("xxx");
    }
    private function provideXML($url){
        $string="";
        foreach($this->getEmbed($url) as $key=>$value){
            if(isset($value)&& $value!="") $string.="  <".$key.">".$value."</".$key.">\n";
        }
        $string="<oembed>\n".$string."</oembed>";
        return $string;
    }
    private function provideObject($url){
        return $this->getEmbed($url);
    }
    private function provideJSON($url){
        return json_encode($this->getEmbed($url));
    }
    private function provideSerialized($url){
        return serialize($this->getEmbed($url));
    }
    public function provide($url,$format="json"){
        if($format=="xml"){
            return $this->provideXML($url);
        } else if ($format=="object"){
            return $this->provideObject($url);
        } else if ($format=="serialized"){
            return $this->provideSerialized($url);
        } else {
            return $this->provideJSON($url);;
        }
    }


    public function __construct($config,$maxwidth=null, $maxheight=null){
        parent::__construct("http://youtube.com","", $maxwidth, $maxheight);
    }
}
