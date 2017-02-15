<?php

namespace Portier\Client;

/**
 * A store implementation that uses Redis as the backend.
 */
class S9yStore extends AbstractStore
{
    public $plugin;
    
    /**
     * Constructor
     */
    public function __construct($plugin)
    {
        parent::__construct();
        
        $this->plugin = $plugin;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchCached($cacheId, $url)
    {
        $key = 'cache:' . $cacheId;

        $data = $this->get_config_ttl($key);
        if ($data) {
            return json_decode($data);
        }

        $res = $this->fetch($url);
        $this->set_config_ttl($key, json_encode($res->data), $res->ttl);

        return $res->data;
    }

    /**
     * {@inheritDoc}
     */
    public function createNonce($email)
    {
        $nonce = $this->generateNonce($email);
        $this->set_config_ttl("nonce_$email", $nonce, $this->nonceTtl);
        return $nonce;
    }

    /**
     * {@inheritDoc}
     */
    public function consumeNonce($nonce, $email)
    {
        $storedNonce = $this->get_config_ttl("nonce_$email");
        $this->plugin->set_config("nonce_$email", null);
        if ($storedNonce === null || $storedNonce !== $nonce) {
            throw new \Exception('Invalid or expired nonce');
        }
    }

    private function set_config_ttl($key, $value, $ttl) {
        $this->plugin->set_config($key, $value);
        $this->plugin->set_config("$key_valid_till", time() + $ttl);
    }

    private function get_config_ttl($key) {
        $value = $this->plugin->get_config($key);
        if (time() < $this->plugin->get_config("$key_valid_till")) {
            return $value;
        }
    }
}
