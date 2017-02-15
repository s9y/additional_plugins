<?php

namespace Portier\Client;

/**
 * A store implementation that uses Redis as the backend.
 */
class RedisStore extends AbstractStore
{
    public $redis;

    /**
     * Constructor
     * @param \Redis $redis  The Redis instance to use.
     */
    public function __construct(\Redis $redis)
    {
        parent::__construct();

        $this->redis = $redis;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchCached($cacheId, $url)
    {
        $key = 'cache:' . $cacheId;

        $data = $this->redis->get($key);
        if ($data) {
            return json_decode($data);
        }

        $res = $this->fetch($url);
        $this->redis->setEx($key, $res->ttl, json_encode($res->data));

        return $res->data;
    }

    /**
     * {@inheritDoc}
     */
    public function createNonce($email)
    {
        $nonce = $this->generateNonce($email);

        $key = 'nonce:' . $nonce;
        $this->redis->setEx($key, $this->nonceTtl, $email);

        return $nonce;
    }

    /**
     * {@inheritDoc}
     */
    public function consumeNonce($nonce, $email)
    {
        $key = 'nonce:' . $nonce;
        $res = $this->redis->multi()
            ->get($key)
            ->del($key)
            ->exec();
        if ($res[0] !== $email) {
            throw new \Exception('Invalid or expired nonce');
        }
    }
}
