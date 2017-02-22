<?php

namespace Portier\Client;

/**
 * Interface for stores used by the client.
 */
interface StoreInterface
{
    /**
     * Fetch JSON from cache or using HTTP GET.
     * @param  string $cacheId  The cache ID to use for this request.
     * @param  string $url      The URL to fetch of the ID is not available.
     * @return object           The JSON object from the response body.
     */
    public function fetchCached($cacheId, $url);

    /**
     * Generate and store a nonce.
     * @param  string $email  Email address to associate with the nonce.
     * @return string         The generated nonce.
     */
    public function createNonce($email);

    /**
     * Consume a nonce, and check if it's valid for the given email address.
     * @param string $nonce  The nonce to resolve.
     * @param string $email  The email address that is being verified.
     */
    public function consumeNonce($nonce, $email);
}
