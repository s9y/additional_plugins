<?php
class OohEmbedProvider extends OEmbedProvider {
    public function match($url){
        // Embedly should match always
        return 1;
    }
    public function __construct($url, $maxwidth=null, $maxheight=null){
        $endpoint = "http://oohembed.com/oohembed/";
        parent::__construct($url,$endpoint,true, $maxwidth,$maxheight, true);
    }
}
