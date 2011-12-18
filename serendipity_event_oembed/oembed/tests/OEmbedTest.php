<?
/*
 * PHP OEmbed provider/proxy - for details, visit
 *
 * http://code.google.com/p/php-oembed/
 *
 * Copyright(C) by Adam Nemeth. Licensed under New BSD license.
 *
 * I would love to hear every feedback on aadaam at googlesmailservice
 *
 */
require_once(dirname(__FILE__) . '/../' . "config.php");
$xml = simplexml_load_file(dirname(__FILE__) . '/../' . "providers.xml");
foreach($xml->provider as $provider){
 // $x = new OEmbedProvider("http://*.flickr.com/*","http://www.flickr.com/services/oembed/");
 $x = new OEmbedProvider($provider->url,$provider->endpoint);
  echo $x->url.":\n";
  if ($x->match("http://www.flickr.com/photos/bees/2341623661/")){
    print_r($x->provide("http://www.flickr.com/photos/bees/2341623661/","object"));
  }
  echo " ".$x->getUrlRegExp()."\n";
  echo " ".$x->getJsonEndpoint()."\n";
  echo " ".$x->getXmlEndpoint()."\n";
}
