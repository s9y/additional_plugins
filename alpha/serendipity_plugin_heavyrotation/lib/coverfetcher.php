<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR . 'aws_signed_request.php';
/**
 * Proxy class to combine the access to serendipity_plugin_heavyrotation_helper_audioscrobbler
 * and serendipity_plugin_heavyrotation_helper_amazon.
 *
 * @author Lars Strojny <lars@strojny.net>
 */
class serendipity_plugin_heavyrotation_coverfetcher
{
    /**
     * Audioscrobbler username
     *
     * @var string
     */
    protected $_audioscrobbler_username;

    /**
     * Amazon API id
     *
     * @var string
     */
    protected $_amazon_id;

    /**
     * Amazon access key
     *
     * @var string
     */
    protected $_amazon_access_key;

    /**
     * Amazon country code
     *
     * @var string
     */
    protected $_amazon_country_code;

    /**
     * Singleton'ed instance of serendipity_plugin_heavyrotation_helper_audioscrobbler
     *
     * @var serendipity_plugin_heavyrotation_helper_audioscrobbler
     */
    protected $_audioscrobbler_instance;

    /**
     * Set AudioScrobbler username
     *
     * @param string $username
     */
    public function setAudioscrobblerUsername($username)
    {
        $this->_audioscrobbler_username = $username;
        return $this;
    }

    /**
     * Get set AudioScrobbler username
     *
     * @return string
     */
    public function getAudioscrobblerUsername()
    {
        if ($this->_audioscrobbler_username === null)
            throw new Exception('No audioscrobbler username set');

        return $this->_audioscrobbler_username;
    }

    /**
     * Set Amazon API key ID
     *
     * @param string $amazon_id
     */
    public function setAmazonId($amazon_id)
    {
        $this->_amazon_id = $amazon_id;
        return $this;
    }

    /**
     * Return set amazon API id
     *
     * @return string
     */
    public function getAmazonId()
    {
        if ($this->_amazon_id === null)
            throw new Exception('No Amazon API id set');
        return $this->_amazon_id;
    }

    public function setAmazonAccessKey($access_key)
    {
        $this->_amazon_access_key = $access_key;
        return $this;
    }

    public function getAmazonAccessKey()
    {
        if ($this->_amazon_access_key === null)
            throw new Exception('No Amazon access key set');
        return $this->_amazon_access_key;
    }

    /**
     * Set Amazon country code
     *
     * @var string
     */
    public function setAmazonCountryCode($code)
    {
        $this->_amazon_country_code = $code;
        return true;
    }

    /**
     * Get set Amazon country code
     *
     * @return string
     */
    public function getAmazonCountryCode()
    {
        if ($this->_amazon_country_code === null)
            throw new Exception('No Amazon country code set');
        return $this->_amazon_country_code;
    }

    /**
     * Refresh singletons
     *
     * @return boolean
     */
    public function refresh()
    {
        $this->_audioscrobbler_instance = null;
        return true;
    }

    /**
     * Fetch album information (first audioscrobbler, than amazon)
     *
     * @return serendipity_plugin_heavyrotation_album|false
     */
    public function fetchAlbum()
    {
        /**
         * The strategy is, trying to fetch the best first. If we do not find a
         * cover on Amazon, we're iterating through all the next positions and
         * using the first complete combination.
         */
        $album = $this->_audioscrobbler->getTopAlbumPerWeek();
        try {
            $image = $this->_fetchAlbumImage($album->artist, $album->name);
            return $this->_createAlbum($album->artist, $album->name, $image, $album->url);
        } catch (Exception $exception) {
            foreach ($this->_audioscrobbler->getTopAlbumsPerWeek() as $album) {
                try {
                    $image = $this->_fetchAlbumImage($album->artist, $album->name);
                    return $this->_createAlbum($album->artist, $album->name, $image, $album->url);
                // Go to the next result
                } catch (Exception $exception) {
                    error_log($exception->getMessage());
                }
            }
            return false;
        }
    }

    /**
     * Helper method to create a album object
     *
     * @return serendipity_plugin_heavyrotation_album
     */
    protected function _createAlbum($artist, $name, $image, $url)
    {
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'album.php';
        return new serendipity_plugin_heavyrotation_album((string)$artist, (string)$name, (string)$image, (string)$url);
    }

    protected function _fetchAlbumImage($artist, $album)
    {
    error_log('ARTIST:'.$artist);
        $xml = aws_signed_request(
            $this->getAmazonCountryCode(),
            array(
                'Operation'     => 'ItemSearch',
                'Artist'        => $artist,
                'Title'         => $album,
                'SearchIndex'   => 'Music',
                'ResponseGroup' => 'Images',
            ),
            $this->getAmazonId(),
            $this->getAmazonAccessKey()
        );
        if (!$xml) {
            throw new Exception('Error while performing API request');
        }
        $xml->registerXpathNamespace('az', 'http://webservices.amazon.com/AWSECommerceService/2009-03-31');
        $imageUrl = (string)array_shift($xml->xpath('//az:LargeImage/az:URL'));
        if (!$imageUrl) {
        error_log('ERROR');
            throw new Exception('Could not find cover');
        }
        if (extension_loaded('curl')) {
            $curl = curl_init($imageUrl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $image = curl_exec($curl);
        } else {
            $image = file_get_contents($imageUrl);
        }
        return $image;
    }

    /**
     * Implementation of property based lazy loading and singleton
     * functionality.
     *
     * @throws Exception
     * @return serendipity_plugin_heavyrotation_helper_amazon|serendipity_plugin_heavyrotation_helper_audioscrobbler|null
     */
    public function __get($var)
    {
        switch ($var) {
            case "_audioscrobbler":
                if ($this->_audioscrobbler_instance === null) {
                    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR . 'audioscrobbler.php';
                    $this->_audioscrobbler_instance = new serendipity_plugin_heavyrotation_helper_audioscrobbler;
                    $this->_audioscrobbler_instance->setDefaultUsername($this->getAudioscrobblerUsername());
                }
                return $this->_audioscrobbler_instance;
            default:
                throw new Exception("Invalid var: \"{$var}\"");
        }
    }
}
