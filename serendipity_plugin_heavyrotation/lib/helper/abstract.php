<?php
/**
 * Abstract helper class for REST-based services
 *
 * @author Lars Strojny <lars@strojny.net>
 * @todo The HTTP-fetch stuff can be replaced with a decorator alike pattern
 */
abstract class serendipity_plugin_heavyrotation_helper_abstract
{
    /**
     * Helper function to fetch HTTP-URLs
     *
     * @param string $url
     * @return string
     * @todo Error handling is missing
     */
    protected function _fetch($url)
    {
        require_once S9Y_PEAR_PATH . 'HTTP/Request.php';
        $request = new HTTP_Request($url);
        $request->setMethod(HTTP_REQUEST_METHOD_GET);
        $request->sendRequest();
        return $request->getResponseBody();
    }
}
