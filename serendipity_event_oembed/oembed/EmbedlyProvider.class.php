<?php
class EmbedlyProvider extends OEmbedProvider {
    public function match($url){
        // Embedly should match always
        return 1;
    }
    public function __construct($url, $apikey, $maxwidth=null, $maxheight=null){
        $endpoint = "http://api.embed.ly/1/oembed?key=$apikey";
        parent::__construct($url,$endpoint,false, $maxwidth,$maxheight, true);
    }
}
