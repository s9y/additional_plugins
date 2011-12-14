<?php
$xml = simplexml_load_file(dirname(__FILE__) . '/../' . "providers.xml");

foreach($xml->provider as $provider){
    echo $provider->url;
    echo $provider->endpoint;
}

