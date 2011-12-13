<?php
/**
 * serendipity_plugin_heavyrotation - Displaying Heavy Rotation
 *
 * Serendipity plugin implementing a Last.fm/Audioscrobbler based Heavy Rotation
 * visualisation with the cover image fetched from Amazon.
 *
 * @author Lars Strojny <lars@strojny.net>
 */
class serendipity_plugin_heavyrotation extends serendipity_plugin
{
    /**
     * The title of the plugin
     *
     * @var string
     */
    public $title = SERENDIPITY_PLUGIN_HEAVYROTATION_TITLE;

    /**
     * Serendipity configuration array
     *
     * @var array
     */
    protected $_serendipity;

    /**
     * Album handler instance
     *
     * @var serendipity_plugin_heavyrotation_albumhandler
     */
    protected $_handler;

    /**
     * List of amazon country codes
     *
     * @var array
     */
    protected $_country_codes = array('com', 'de', 'uk', 'ca', 'fr');

    /**
     * Overwriting the constructor to prevent myself from using the serendipity
     * global in the class itself. Assigning a reference to a protected property
     * which is much saner and better to use.
     *
     * @param serendipity_plugin_heavyrotation $instance
     * @return serendipity_plugin_heavyrotation
     */
    public function __construct($instance)
    {
        global $serendipity;
        parent::__construct($instance);
        $this->_serendipity = &$serendipity;
    }

    /**
     * Plugin introspection
     *
     * Adding the root specification to the property bag of the plugin including
     * requirements, configuration options, etc.
     *
     * @param serendipity_property_bag $propbag Property bag for the plugin
     * @return null
     */
    public function introspect(&$propbag)
    {
        $propbag->add('name', SERENDIPITY_PLUGIN_HEAVYROTATION_TITLE);
        $propbag->add('description', SERENDIPITY_PLUGIN_HEAVYROTATION_DESCRIPTION);
        $propbag->add('configuration', array(
            'sidebar_title',
            'amazon_api_id',
            'amazon_country_code',
            'audioscrobbler_username',
            'cover_width',
            'cover_height',
        ));
        $propbag->add('stackable', true);
        $propbag->add('requirements', array('php' => '5.1', 'serendipity' => '0.9'));
        $propbag->add('groups', array(FRONTEND_EXTERNAL_SERVICES));
        $propbag->add('author', 'Lars Strojny');
        $propbag->add('version', SERENDIPITY_PLUGIN_HEAVYROTATION_VERSION);
    }

    /**
     * Config item introspection
     *
     * This method specifies the various configuration options who belongs to
     * this plugin.
     *
     * @param string $name Name of the configuration option
     * @param serendipity_property_ba $propbag Property bag to specify the configuration options
     * @return boolean
     */
    public function introspect_config_item($name, &$propbag)
    {
        switch ($name) {
            case 'sidebar_title':
                $propbag->add('name', SERENDIPITY_PLUGIN_HEAVYROTATION_CONFIG_SIDEBARTITLE_TITLE);
                $propbag->add('description', SERENDIPITY_PLUGIN_HEAVYROTATION_CONFIG_SIDEBARTITLE_DESCRIPTION);
                $propbag->add('type', 'string');
                $propbag->add('default', SERENDIPITY_PLUGIN_HEAVYROTATION_TITLE);
                break;

            case 'amazon_api_id':
                $propbag->add('name', SERENDIPITY_PLUGIN_HEAVYROTATION_CONFIG_AMAZONID_TITLE);
                $propbag->add('description', SERENDIPITY_PLUGIN_HEAVYROTATION_CONFIG_AMAZONID_DESCRIPTION);
                $propbag->add('type', 'string');
                $propbag->add('validate', 'string');
                break;

            case 'amazon_country_code':
                $propbag->add('name', SERENDIPITY_PLUGIN_HEAVYROTATION_CONFIG_AMAZONCC_TITLE);
                $propbag->add('description', SERENDIPITY_PLUGIN_HEAVYROTATION_CONFIG_AMAZONCC_DESCRIPTION);
                $propbag->add('type', 'select');
                $propbag->add('default', 'us');
                $propbag->add('select_values', $this->_country_codes);
                break;

            case 'audioscrobbler_username':
                $propbag->add('name', SERENDIPITY_PLUGIN_HEAVYROTATION_CONFIG_ASUSERNAME_TITLE);
                $propbag->add('description', SERENDIPITY_PLUGIN_HEAVYROTATION_CONFIG_ASUSERNAME_DESCRIPTION);
                $propbag->add('type', 'string');
                break;

            case 'cover_width':
                $propbag->add('name', SERENDIPITY_PLUGIN_HEAVYROTATION_CONFIG_COVER_WIDTH_TITLE);
                $propbag->add('description', SERENDIPITY_PLUGIN_HEAVYROTATION_CONFIG_COVER_WIDTH_DESCRIPTION);
                $propbag->add('type', 'string');
                $propbag->add('default', 400);
                break;

            case 'cover_height':
                $propbag->add('name', SERENDIPITY_PLUGIN_HEAVYROTATION_CONFIG_COVER_HEIGHT_TITLE);
                $propbag->add('description', SERENDIPITY_PLUGIN_HEAVYROTATION_CONFIG_COVER_HEIGHT_DESCRIPTION);
                $propbag->add('type', 'string');
                $propbag->add('default', 400);
                break;
        }
        return true;
    }

    /**
     * Generate the sidebar content
     *
     * @param string $title
     * @todo Make title configurable
     * @return null
     */
    public function generate_content(&$title)
    {
        $title = $this->get_config('sidebar_title');
        error_log($title);
        try {
            if (!$this->_albumIsUpToDate()) {
                $album = $this->_fetchAlbum();
                error_log('ALBUM:'.(int)$album);
                if ($album) $this->getAlbumHandler()->setInstance($album)->write();
                error_log('FOO');
            } else {
                $album = $this->getAlbumHandler()->getInstance();
            }
        } catch (serendipity_plugin_heavyrotation_albumhandler_chickeneggproblem $exception) {
        error_log($exception->getMessage());
            $album = $this->_fetchAlbum();
            if ($album) $this->getAlbumHandler()->setInstance($album)->write();
        }
        $album = $this->getAlbumHandler()->getInstance();

        if ($album) {
?>
    <a href="<?php echo $album->url ?>"><img style="width:<?php echo $this->get_config('cover_width') ?>px;height:<?php echo $this->get_config('cover_height') ?>px" src="<?php echo $this->_entify($this->_getImageUrl())?>" title="<?php echo $this->_entify($album->artist . ' - ' .  $album->name) ?>" alt="<?php echo $this->_entify($album->artist . ' - ' .  $album->name) ?>"/></a>
<?php
        }
    }

    /**
     * Encapsulating the process of fetching an album
     *
     * @return serendipity_plugin_heavyrotation_album|boolean
     */
    protected function _fetchAlbum()
    {
    error_log(__METHOD__);
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'coverfetcher.php';
        $fetcher = new serendipity_plugin_heavyrotation_coverfetcher;
        $fetcher->setAudioscrobblerUsername($this->get_config('audioscrobbler_username'));
        $fetcher->setAmazonId($this->get_config('amazon_api_id'));
        $fetcher->setAmazonAccessKey($this->get_config('amazon_access_key'));

        /** Workaround the changed plugin API */
        $country_code = $this->get_config('amazon_country_code');
        error_log($country_code);
        if (is_numeric($country_code)) {
            $country_code = $this->_country_codes[$country_code];
        }
        error_log($country_code);
        $fetcher->setAmazonCountryCode($country_code);
        return $fetcher->fetchAlbum();
    }

    /**
     * Returns an HTML-escaped string
     *
     * @param string $string
     * @return string
     */
    protected function _entify($string)
    {
        $charset = str_replace('/', '', $this->_serendipity['charset']);
        return htmlentities($string, ENT_QUOTES, $charset);
    }

    /**
     * Album information needs to be refetched?
     *
     * @return boolean
     */
    protected function _albumIsUpToDate()
    {
        $handler = $this->getAlbumHandler();
        if (file_exists($handler->getPath())) {
            $modification_time = filemtime($handler->getPath());
            if ((time() - $modification_time) <= 60*60*1)
                return true;
        }
        return false;
    }

    /**
     * Get URL to the current cover image
     *
     * @return string
     */
    protected function _getImageUrl()
    {
        return $this->_serendipity['serendipityHTTPPath'] . $this->_serendipity['uploadHTTPPath'] . $this->getAlbumHandler()->getImageFilename();
    }

    /**
     * Return an instance of serendipity_plugin_heavyrotation_albumhandler
     *
     * @param boolean $reload
     * @return serendipity_plugin_heavyrotation_albumhandler
     */
    public function getAlbumHandler($reload = false)
    {
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'albumhandler.php';
        if ($reload or $this->_handler === null) {
            $this->_handler = new serendipity_plugin_heavyrotation_albumhandler;
            $this->_handler->setDirectory($this->_serendipity['smarty']->compile_dir);
            $this->_handler->setFilename(__CLASS__ . ".txt");
            $this->_handler->setImageDirectory($this->_serendipity['serendipityPath']
                                          . $this->_serendipity['uploadPath']);
        }
        return $this->_handler;
    }
}
