<?php

/**
 * This is a kind of example class how to do a oembed provider for a service, that doesn't support oembed.
 * This provider reads the Posterous API to resolve post.ly links. If the result is an image or a video, the XML result
 * will be converted as an OEmbed
 * 
 * Converting is done in the getEmbed function. This is the main code. 
 * Everything else is only type converting that should be nearly the same in any custom provider
 * 
 * All *.class.php files found in the customs directory will be included automatically
 * 
 * After implementing the provider you have to add it to the providers.xml like this:
 * <provider>
 *  <name>Posterous post.ly</name>
 *  <url>http://post.ly/*</url>
 *  <class>PostlyProvider</class>
 * </provider>
* 
 * @author Grischa Brockhaus
 *
 */
class PostlyProvider extends EmbedProvider {

    /**
     * This is the main function calling the Posterous postly API and converting it into a OEmbed object
     * @param string $url post.ly url
     * @return OEmbed the embed object
     */
    public function getEmbed($url){
        if(preg_match("/post\.ly\/([\w-]+)/",$url,$matches)){
            $post_id=$matches[1];
        }
        if (empty($post_id)) return null;

        $api_fetch = "http://posterous.com/api/getpost?id=" . $post_id;
        $xml = simplexml_load_file($api_fetch);
        $rsp_attributes = $xml->attributes();
        if ($rsp_attributes['stat']!="ok") return null;
        
        $post = $xml->post;
        if (!empty($post->media)) {
            $mtype = (string)$post->media->type[0];
            //print_r($medium);
            if ($mtype=='video') {
                $medium = $post->media;
                $oembed = new VideoEmbed();
                $oembed->type='video';
                $oembed->url=(string)$medium->url;
                $oembed->html=(string)$post->body;
                $oembed->thumbnail_url=(string)$medium->thumb;
                if (!empty($medium->mp4)) $oembed->url = (string)$medium->mp4;
            }
            elseif ($mtype=='image') {
                $medium = $post->media->medium[0];
                $oembed = new PhotoEmbed();
                $oembed->type="photo";
                $oembed->url=(string)$medium->url;
                $oembed->width=(string)$medium->width;
                $oembed->height=(string)$medium->height;
            }
            else {
                $oembed = new LinkEmbed();
                $oembed->type="link";
                $oembed->html=(string)$post->body;
                $oembed->description=(string)$post->body;
                $oembed->url=(string)$post->link;
                $oembed->thumbnail_url=(string)$post->authorpic;
            }
        }
        else {
            $oembed = new LinkEmbed();
            $oembed->type="link";
            $oembed->html=(string)$post->body;
            $oembed->description=(string)$post->body;
            $oembed->url=(string)$post->link;
            $oembed->thumbnail_url=(string)$post->authorpic;
        }
        $oembed->version='1.0';
        $oembed->provider_name="Posterous";
        $oembed->provider_url="http://posterous.com";
        $oembed->resource_url=(string)$post->link;
        $oembed->title = (string)$post->title;
        //$oembed->html = $post->body;
        $oembed->author_name = (string)$post->author;
        $oembed->author_pic = (string)$post->authorpic; // normaly unsupported
        return $oembed;
    }
    
    // === here comes the regular stuff for providers, what is very similar in any custom provider =========
    private function provideXML($url){
        $string="";
        $oembed = $this->getEmbed($url);
        if (isset($oembed)) {
            foreach($this->getEmbed($url) as $key=>$value){
                if(isset($value)&& $value!="") $string.="  <".$key.">".$value."</".$key.">\n";
            }
            $string="<oembed>\n".$string."</oembed>";
        }
        return $string;
    }
    private function provideObject($url){
        return $this->getEmbed($url);
    }
    private function provideJSON($url){
        $oembed = $this->getEmbed($url);
        if (isset($oembed)) return json_encode($this->getEmbed($url));
        else return null;
    }
    private function provideSerialized($url){
        $oembed = $this->getEmbed($url);
        if (isset($oembed)) return serialize($this->getEmbed($url));
        else return null;
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

    public function match($url) {
        return preg_match('/post\.ly\/([\w-]+)/',$url);
    }

    /**
     * Constructor
     * Enter description here ...
     * @param simplexml $config holds the entry in the providers.xml for this Provider. You can add more parameters parsed here
     */
    public function __construct($config){
        parent::__construct("http://post.ly","");
    }
}