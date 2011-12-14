<?php
abstract class OEmbed{// extends LazyTemplateEngine{
  public $type;
  public $version;
  public $title;
  public $author_name;
  public $author_url;
  public $provider_name;
  public $provider_url;
  public $cache_age;
  public $description; // added by me, not part of OEmbed
  public $resource_url; // added by me, not part of OEmbed
  public $thumbnail_url;
  public $thumbnail_width;
  public $thumbnail_height;
  
  public function cloneObj($object){
  foreach($object as $key=>$value){
    $this->$key=(string)$value;
  }
  }
}

