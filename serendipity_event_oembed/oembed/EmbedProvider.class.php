<?php
abstract class EmbedProvider {
  public $url;
  public $endpoint;
  public abstract function match($url);
  public abstract function provide($url,$format="json");
//  public abstract function register();
  public function __construct($url,$endpoint){
    $this->url = $url;
    $this->endpoint = $endpoint;
  }
}
