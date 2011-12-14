<?php
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
class ProviderManager{
    private $providers;
    private static $_instance;
    private function __construct(){
        $this->providers=array();
        $xml = simplexml_load_file(PROVIDER_XML);// PROVIDER_XML comes from config.php
        foreach($xml->provider as $provider){
            if(!isset($provider->class) && isset($provider->endpoint)){
                $this->register(new OEmbedProvider($provider->url,$provider->endpoint));
            } else {
                $classname="".$provider->class; // force to be string :)
                $reflection = new ReflectionClass($classname);
                $this->register($reflection->newInstance($provider));//so we could pass config vars
            }
        }
    }
    static function getInstance(){
        if(!isset($_instance) || $_instance==null){
            $_instance = new ProviderManager();
        }
        return $_instance;
    }
    public function register($provider){
        $this->providers[]=$provider;
    }
    public function provide($url,$format){
        foreach ($this->providers as $provider){
            if ($provider->match($url)){
                return $provider->provide($url,$format);
            }
        }
        return null;
    }
}
