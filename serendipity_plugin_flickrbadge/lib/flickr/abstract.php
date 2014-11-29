<?php
/**
 * Abstract class for the Flickr API
 *
 * @author Lars Strojny <lars@strojny.net>
 */
abstract class serendipity_plugin_flickrbadge_flickr_abstract
{
	/**
	 * List of default request parameters
	 *
	 * @var array
	 */
	protected $_params = array(
		'api_key' => null,
		'format' => 'php_serial',
	);

	protected $_namespace;

	/**
	 * API endpoint
	 *
	 * @var string
	 */
	protected $_url = "http://api.flickr.com/services/rest/";

	/**
	 * List of valid namespaces
	 *
	 * @var array
	 */
	protected $_namespaces = array(
		'activity',
		'auth',
		'blogs',
		'contacs',
		'favorites',
		'groups',
		'groups.pools',
		'interestingness',
		'people',
		'photos',
		'photos.comments',
		'photos.geo',
		'photos.licenses',
		'photos.notes',
		'photos.transform',
		'photos.upload',
		'photosets',
		'photosets.comments',
		'reflection',
		'tags',
		'test',
		'urls',
	);

	/**
	 * Initialize the object
	 *
	 * @param string $api_key
	 * @return serendipity_plugin_flickrbadge_flickr_abstract
	 */
	public function __construct($api_key)
	{
		$this->setApiKey($api_key);
	}

	/**
	 * Get API key
	 *
	 * @return string
	 */
	public function getApiKey()
	{
		return $this->_params['api_key'];
	}

	/**
	 * Set API key
	 *
	 * @param string $api_key
	 * @return serendipity_plugin_flickrbadge_flickr_abstract
	 */
	public function setApiKey($api_key)
	{
		$this->_params['api_key'] = $api_key;
		return $this;
	}

	/**
	 * Set default namespace
	 *
	 * @param string $namespace
	 * @return serendipity_plugin_flickrbadge_flickr_abstract
	 */
	public function setNamespace($namespace)
	{
		if (!in_array($namespace, $this->_namespaces))
			throw new Exception("Invalid namespace {$namespace}");
		$this->_namespace = $namespace;
		return $this;
	}

	/**
	 * Get current namespace
	 *
	 * @return string
	 */
	public function getNamespace()
	{
		return $this->_namespace;
	}

	/**
	 * Implementation of API calls
	 *
	 * API calls are implemented via the virtual __call-method.
	 *
	 * @param string $method
	 * @param array $arguments
	 * @return array
	 */
	public function __call($method, $arguments)
	{
		if (array_key_exists(1, $arguments))
			$this->setNamespace($arguments[1]);

		$arguments = array_merge($this->_params, $arguments[0]);
		$arguments['method'] = "flickr.{$this->getNamespace()}.{$method}";

		return $this->sendRequest($arguments);
	}

	/**
	 * Abstract method which needs to be implemented to handle the request
	 *
	 * @param array $arguments
	 * @return array
	 */
	abstract public function sendRequest(array $arguments);

	/**
	 * Serialize data
	 *
	 * @param mixed $data
	 * @return string
	 */
	protected function _serialize($data)
	{
		return serialize($data);
	}

	/**
	 * Unserialize data
	 *
	 * @param string $string
	 * @return mixed
	 */
	protected function _unserialize($string)
	{
		return unserialize($string);
	}
}
