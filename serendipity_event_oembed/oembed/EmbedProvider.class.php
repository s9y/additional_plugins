<?php
abstract class EmbedProvider {
  public $url;
  public $endpoint;
  public $maxwidth;
  public $maxheight;
  public $config;
  public abstract function match($url);
  public abstract function provide($url,$format="json");
//  public abstract function register();
  public function __construct($url,$endpoint, $maxwidth=null, $maxheight=null){
    $this->url = $url;
    $this->endpoint = $endpoint;
    $this->maxwidth = $maxwidth;
    $this->maxheight = $maxheight;
  }
  public function set_config($config) {
      $this->config = $config;
  }
}
