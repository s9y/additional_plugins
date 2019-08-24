<?php
/** Loading abstract base class */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'flickr' . DIRECTORY_SEPARATOR . 'abstract.php';

/**
 * Accessing the Flickr-API in a convenient way
 *
 * @author Lars Strojny <lars@strojny.net>
 */
class serendipity_plugin_flickrbadge_flickr
	extends serendipity_plugin_flickrbadge_flickr_abstract
{

	/** Image size constant: squared thumbnail */
	const SQUARE = 's';

	/** Image size constant: thumbnail size */
	const THUMBNAIL = 't';

	/** Image size constant: medium size (used in embedded HTML view) */
	const SMALL = 'm';

	/** Image size constant: large size */
	const LARGE = 'l';

	/** Image size constant: original size */
	const ORIGINAL = 'o';

	/** Image format constant: jpg */
	const JPG = 'jpg';

	/** Image format constant: jpg */
	const JPEG = 'jpg';

	/** Image format constant: png */
	const PNG = 'png';

	/** Image format constant: gif */
	const GIF = 'gif';

	/**
	 * Helper function to build image
	 *
	 * @param array|integer|string $farm_id
	 * @param string $server
	 * @param string $id
	 * @param string $secret
	 * @param string $size
	 * @param string $format
	 */
	public static function buildImageUrl($farm_or_array, $server = null, $id = null,
									$secret = null, $size = self::SQUARE, $format = self::JPG)
	{
		if (is_array($farm_or_array))
			extract($farm_or_array);
		else
			$farm = $farm_or_array;
		return "http://farm{$farm}.static.flickr.com/{$server}/{$id}_{$secret}_{$size}.{$format}";
	}

	/**
	 * Helper function to create URLs to embedded images into the Flickr page
	 *
	 * @param string $msid Flickr user id
	 * @param string $photo_id Flickr photo id
	 * @return string
	 */
	public static function getImageUrl($msid, $photo_id)
	{
		return "http://flickr.com/photos/{$msid}/{$photo_id}";
	}

	/**
	 * Fire request via HTTP to the Flickr API
	 *
	 * @param array $arguments List of query string pairs
	 * @return array
	 */
	public function sendRequest(array $arguments)
	{
		$params = '';
		foreach ($arguments as $key => $argument) $params .= "{$key}=" . urlencode($argument) . "&";
		$url = $this->_url . "?" . $params;
		if (function_exists('serendipity_request_url')) {
			$response = unserialize(serendipity_request_url($url));
		} else {
			require_once S9Y_PEAR_PATH . 'HTTP/Request.php';
			serendipity_request_start();
			$request = new HTTP_Request($url);
			$request->setMethod(HTTP_REQUEST_METHOD_GET);
			$request->sendRequest();
			$response = unserialize($request->getResponseBody());
		}
		if ($response['stat'] != 'ok')
			throw new Exception($response['message'], $response['code']);
		return $response;
	}
}
