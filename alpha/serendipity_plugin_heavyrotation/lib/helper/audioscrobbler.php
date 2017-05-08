<?php
/** Loading abstract base class */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'abstract.php';

/**
 * Wrapping the audioscrobbler/last.fm API into an easy to use PHP class
 *
 * @author Lars Strojny <lars@strojny.net>
 */
class serendipity_plugin_heavyrotation_helper_audioscrobbler
    extends serendipity_plugin_heavyrotation_helper_abstract
{
    /**
     * Internally used array
     *
     * @var array
     */
    protected $_storage = array();

    /**
     * API endpoint
     *
     * @var string
     */
    protected $_api_url;

    /**
     * API version
     *
     * @var string
     */
    protected $_version;

    /**
     * Default username (covenience)
     *
     * @var string
     */
    protected $_default_username;

    /**
     * Creates the objects and sets some sensible defaults
     *
     * @return serendipity_plugin_heavyrotation_helper_audioscrobbler
     */
    public function __construct()
    {
        $this->setApiUrl("http://ws.audioscrobbler.com/");
        $this->setVersion("1.0");
    }

    /**
     * Get a list of top albums of the last week
     *
     * @param string $username
     * @todo Provide the possibility to select the week
     * @return SimpleXML
     */
    public function getTopAlbumsPerWeek($username = null)
    {
        if ($username === null)
            $username = $this->getDefaultUsername();
        if ($username === null)
            throw new Exception('No username given, no default username supplied');

        return $this->_handle("{$this->getApiUrl()}{$this->getVersion()}/user/{$username}/weeklyalbumchart.xml");
    }

    /**
     * Get the top album of the last week
     *
     * @param string $username
     * @todo Provide the possibility to select the week
     * @return SimpleXML
     */
    public function getTopAlbumPerWeek($username = null)
    {
        $albums = $this->getTopAlbumsPerWeek($username);
        return $albums->album;
    }

    /**
     * Set API url
     *
     * @param string $url
     * @return serendipity_plugin_heavyrotation_helper_audioscrobbler
     */
    public function setApiUrl($url)
    {
        $this->_api_url = $url;
        return $this;
    }

    /**
     * Get API URL
     *
     * @return string
     */
    public function getApiUrl()
    {
        return $this->_api_url;
    }

    /**
     * Set API version
     *
     * @param string $version
     * @return serendipity_plugin_heavyrotation_helper_audioscrobbler
     */
    public function setVersion($version)
    {
        $this->_version = $version;
        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->_version;
    }

    /**
     * Set default username to work with
     *
     * @param string $username
     * @return serendipity_plugin_heavyrotation_helper_audioscrobbler
     */
    public function setDefaultUsername($username)
    {
        $this->_default_username = $username;
        return $this;
    }

    /**
     * Get default username
     *
     * @return string
     */
    public function getDefaultUsername()
    {
        return $this->_default_username;
    }

    /**
     * Handle REST request and response
     *
     * @param string $url
     * @return SimpleXML
     */
    protected function _handle($url)
    {
        $storage_id = md5($url);
        if (!array_key_exists($storage_id, $this->_storage)) {
            $string = $this->_fetch($url);
            $this->_storage[$storage_id] = simplexml_load_string($string);
        }
        return $this->_storage[$storage_id];
    }
}
