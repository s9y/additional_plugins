<?php
/** Loading abstract base class */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'abstract.php';

/**
 * Filecache implementation for the Flickr API
 *
 * This class implements a way to access the Flickr API through a thin cache
 * fassade. The API is exact the same.
 *
 * @author Lars Strojny <lars@strojny.net>
 */
class serendipity_plugin_flickrbadge_flickr_filecache
	extends serendipity_plugin_flickrbadge_flickr_abstract
{
	/**
	 * Number of seconds to keep the item cached
	 *
	 * @var Integer
	 */
	protected $_cache_time = 60;

	/**
	 * Directory to put the cache file in
	 *
	 * @var string
	 */
	protected $_cache_dir;

	/**
	 * Prefix of the cache filename
	 *
	 * @var string
	 */
	protected $_cache_prefix = '';

	/**
	 * Instance of the serendipity_plugin_flickrbadge_flickr object
	 *
	 * @var serendipity_plugin_flickrbadge_flickr
	 */
	protected $_flickr_instance;

	/**
	 * Set cache time (seconds)
	 *
	 * @param integer $seconds
	 * @return serendipity_plugin_flickrbadge_flickr_filecache
	 */
	public function setCacheTime($seconds)
	{
		$this->_cache_time = $seconds;
		return $this;
	}

	/**
	 * Set directory where the cache files should be stored
	 *
	 * @param string $dir
	 * @return serendipity_plugin_flickrbadge_flickr_filecache
	 */
	public function setCacheDir($dir)
	{
		if (!is_dir($dir) or !is_writable($dir))
			throw new InvalidArgumentException(
				'Dir is not a directory or not writable');
		$this->_cache_dir = $dir;
		return $this;
	}

	/**
	 * Get cache directory
	 *
	 * @return string
	 */
	public function getCacheDir()
	{
		return $this->_cache_dir;
	}

	/**
	 * Get number of seconds to keep the cached item
	 *
	 * @return integer
	 */
	public function getCacheTime()
	{
		return $this->_cache_time;
	}

	/**
	 * Set cache file prefix
	 *
	 * @param string $prefix
	 * @return serendipity_plugin_flickrbadge_flickr_filecache
	 */
	public function setCachePrefix($prefix)
	{
		$this->_cache_prefix = $prefix;
		return $this;
	}

	/**
	 * Get cache prefix
	 *
	 * @return string
	 */
	public function getCachePrefix()
	{
		return $this->_cache_prefix;
	}

	/**
	 * Fire the request
	 *
	 * @param array $arguments Paired query string arguments
	 * @return array
	 */
	public function sendRequest(array $arguments)
	{
		$cache_key = $this->_buildCacheKey($arguments);
		$cache_file = $this->getCacheDir()
			. DIRECTORY_SEPARATOR
			. $this->getCachePrefix()
			. $cache_key . ".txt";
		if (file_exists($cache_file)
			and (time()-filemtime($cache_file)) < $this->getCacheTime()) {
			return $this->_unserialize(file_get_contents($cache_file));
		}
		$flickr = $this->_getFlickrInstance();
		$result = $flickr->sendRequest($arguments);
		file_put_contents($cache_file, $this->_serialize($result));
		return $result;
	}

	/**
	 * Internal helper: Build unique cache key for the arguments
	 *
	 * @param array $arguments
	 * @return string
	 */
	protected function _buildCacheKey(array $arguments)
	{
		$string = '';
		foreach ($arguments as $key => $argument)
			$string .= $key . $argument;
		return md5($string);
	}

	/**
	 * Get instance of the serendipity_plugin_flickrbadge_flickr object
	 *
	 * @return serendipity_plugin_flickrbadge_flickr
	 */
	protected function _getFlickrInstance()
	{
		if ($this->_flickr_instance == null) {
			require_once dirname(__FILE__) . '.php';
			$this->_flickr_instance = new serendipity_plugin_flickrbadge_flickr($this->_params['api_key']);
		}
		return $this->_flickr_instance;
	}
}
