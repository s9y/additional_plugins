<?php
class OEmbedProvider extends EmbedProvider{
    private $urlRegExp;
    private $jsonEndpoint;
    private $xmlEndpoint;
    public function __construct($url,$endpoint){
        parent::__construct($url,$endpoint);
        $this->urlRegExp=preg_replace(array("/\*/","/\//","/\.\*\./"),array(".*","\/",".*"),$url);
        $this->urlRegExp="/".$this->urlRegExp."/";
        if (preg_match("/\{format\}/",$endpoint)){
            $this->jsonEndpoint=preg_replace("/\{format\}/","json",$endpoint);
            $this->jsonEndpoint.="?url={url}";
            $this->xmlEndpoint=preg_replace("/\{format\}/","xml",$endpoint);
            $this->xmlEndpoint.="?url={url}";
        } else {
            $this->jsonEndpoint=$endpoint."?url={url}&format=json";
            $this->xmlEndpoint=$endpoint."?url={url}&format=xml";
        }
    }

    public function getUrlRegExp(){   return $this->urlRegExp; }
    public function getJsonEndpoint(){ return $this->jsonEndpoint; }
    public function getXmlEndpoint(){ return $this->xmlEndpoint; }

    public function match($url){
        return preg_match($this->urlRegExp,$url);
    }
    private function provideXML($url){
        return file_get_contents(preg_replace("/\{url\}/",urlencode($url),$this->xmlEndpoint));
    }
    private function getTypeObj($type){
        switch($type){
            case "photo":
                return new PhotoEmbed();
                break;
            case "video":
                return new VideoEmbed();
                break;
            case "link":
                return new LinkEmbed();
                break;
            case "rich":
                return new RichEmbed();
                break;
            default:
                return new OEmbed();
        }
    }
    private function provideObject($url){
        $xml=simplexml_load_string($this->provideXML($url));
        //TODO $xml->type alapjan assigner
        $obj = $this->getTypeObj((string)$xml->type);
        $obj->cloneObj($xml);
        $obj->resource_url=$url;
        return $obj;
    }
    private function provideSerialized($url){
        $serialized=serialize($this->provideObject($url));
        return $serialized;
    }
    public function provide($url,$format="json"){
        if($format=="xml"){
            return $this->provideXML($url);
        } else if ($format=="object"){
            return $this->provideObject($url);
        } else if ($format=="serialized"){
            return $this->provideSerialized($url);
        } else {
            return file_get_contents(preg_replace("/\{url\}/",urlencode($url),$this->jsonEndpoint));
        }
    }
    public function register(){}
}

