<?php
require_once dirname(__FILE__) . '/../CurlFetcher.php';

class OEmbedProvider extends EmbedProvider{
    private $urlRegExp;
    private $jsonEndpoint;
    private $xmlEndpoint;
    private $dimensionsSupported = true;

    private $onlyJson = false;

    public function __construct($url,$endpoint, $onlyJson=false, $maxwidth=null, $maxheight=null, $dimensionsSupported=true){
        parent::__construct($url,$endpoint,$maxwidth,$maxheight);
        $this->onlyJson = $onlyJson;
        $this->dimensionsSupported = $dimensionsSupported;
        $this->urlRegExp=preg_replace(array("/\*/","/\//","/\.\*\./"),array(".*","\/",".*"),$url);
        $this->urlRegExp="/".$this->urlRegExp."/";
        if (preg_match("/\{format\}/",$endpoint)){
            $this->jsonEndpoint=preg_replace("/\{format\}/","json",$endpoint);
            $this->jsonEndpoint.="?url={url}";
            $this->xmlEndpoint=preg_replace("/\{format\}/","xml",$endpoint);
            $this->xmlEndpoint.="?url={url}";
        } else {
            if (strpos($endpoint, '?') === FALSE) {
                $this->jsonEndpoint=$endpoint."?url={url}&format=json";
                $this->xmlEndpoint=$endpoint."?url={url}&format=xml";
            } 
            else {
                $this->jsonEndpoint=$endpoint."&url={url}&format=json";
                $this->xmlEndpoint=$endpoint."&url={url}&format=xml";
            }
        }
        if ($this->dimensionsSupported) {
            if (!empty($this->maxwidth)) {
                $this->jsonEndpoint.= '&maxwidth=' . $this->maxwidth;
                $this->xmlEndpoint.= '&maxwidth=' . $this->maxwidth;
            }
            if (!empty($this->maxheight)) {
                $this->jsonEndpoint.= '&maxwidth=' . $this->maxheight;
                $this->xmlEndpoint.= '&maxwidth=' . $this->maxheight;
            }
        }
    }

    public function getUrlRegExp(){   return $this->urlRegExp; }
    public function getJsonEndpoint(){ return $this->jsonEndpoint; }
    public function getXmlEndpoint(){ return $this->xmlEndpoint; }

    public function match($url){
        return preg_match($this->urlRegExp,$url);
    }
    private function file_get_contents($fileurl) {
        $allow_curl = defined('OEMBED_USE_CURL') && OEMBED_USE_CURL && defined('CURLOPT_URL');
        return CurlFetcher::file_get_contents($fileurl, $allow_curl);
    }
    private function provideXML($url){
        return $this->file_get_contents(preg_replace("/\{url\}/",urlencode($url),$this->xmlEndpoint));
    }
    private function getTypeObj($type){
        switch($type){
            case "image":
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
        if (!$this->onlyJson) {
            $xml=simplexml_load_string($this->provideXML($url));
        }
        else {
            $data=$this->provide($url);
            if (!empty($data)) $xml = json_decode($data);
        }
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
            return $this->file_get_contents(preg_replace("/\{url\}/",urlencode($url),$this->jsonEndpoint));
        }
    }
    public function register(){}
}

