<?php
/** Include exception classes */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'albumhandler' . DIRECTORY_SEPARATOR . 'chickeneggproblem.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'albumhandler' . DIRECTORY_SEPARATOR . 'readerror.php';

/**
 * Album handler object
 *
 * Utilizes the singleton pattern and the factory pattern to provide an easy
 * to use interface for the album object. Without forcing the developer to
 * stuck into the defaults of conditional loading the data from remote, reading
 * them from a file or refreshing the data because they are incomplete.
 *
 * @author Lars Strojny <lars@strojny.net>
 */
class serendipity_plugin_heavyrotation_albumhandler
{
    /**
     * Instance of serendipity_plugin_heavyrotation_album
     *
     * @var serendipity_plugin_heavyrotation_album
     */
    protected $_instance = null;

    /**
     * Metadata directory
     *
     * @var string
     */
    protected $_directory;

    /**
     * Metadata filename
     *
     * @var string
     */
    protected $_filename;

    /**
     * Assembled path information for metadata
     *
     * @var string
     */
    protected $_path;

    /**
     * Path of the image directory
     *
     * @var string
     */
    protected $_image_directory;

    /**
     * Construct the object. Provides certain convenience parameters to set the
     * important parameters at once.
     *
     * @param serendipity_plugin_heavyrotation_album $instance
     * @param string $directory
     * @param string $filename
     * @param string image_directory
     * @return serendipity_plugin_heavyrotation_albumhandler
     */
    public function __construct(serendipity_plugin_heavyrotation_album $instance = null,
                               $directory = null, $filename = null, $image_directory = null)
    {
        if ($instance !== null) {
            $this->setInstance($instance);
        }

        if ($directory !== null) {
            $this->setDirectory($directory);
        }

        if ($filename !== null) {
            $this->setFilename($filename);
        }
    }

    /**
     * Set directory where the metadata should be stored in
     *
     * @param string $directory
     * @return serendipity_plugin_heavyrotation_albumhandler
     */
    public function setDirectory($directory)
    {
        if (!file_exists($directory) or !is_dir($directory) or !is_writable($directory))
            throw new serendipity_plugin_heavyrotation_albumhandler_readerror("Directory \"{$directory}\" is not writable");
        $this->_directory = $directory;
        /** Reset path since it is generated on self::getPath() */
        $this->_path = null;
        return $this;
    }

    /**
     * Get directory
     *
     * @return string
     */
    public function getDirectory()
    {
        return $this->_directory;
    }

    /**
     * Get completed path
     *
     * @return string
     */
    public function getPath()
    {
        if ($this->_path == null) {
            $path = $this->getDirectory() . DIRECTORY_SEPARATOR . $this->getFilename();
            $this->_path = $path;
        }
        return $this->_path;
    }

    /**
     * Set path including the filename (convenience function)
     *
     * @param string $path
     * @return serendipity_plugin_heavyrotation_albumhandler
     */
    public function setPath($path)
    {
        $this->setDirectory(dirname($path));
        $this->setFile(basename($path));
        return $this;
    }

    /**
     * Set image filename
     *
     * @return serendipity_plugin_heavyrotation_albumhandler
     */
    public function setFilename($filename)
    {
        $this->_filename = $filename;
        /** Reset path since it is generated on self::getPath() */
        $this->_path = null;
        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->_filename;
    }

    /**
     * Read data from the metadata
     *
     * @throws serendipity_plugin_heavyrotation_albumhandler_readerror
     * @return serendipity_plugin_heavyrotation_album
     */
    public function read()
    {
        $data = array();
        $path = $this->getPath();
        if (!file_exists($path) or !is_readable($path) or filesize($path) === 0)
            throw new serendipity_plugin_heavyrotation_albumhandler_readerror("File {$path} does not exists");

        foreach ((array)file($this->getPath()) as $value)
            $data[] = trim($value);

        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'album.php';
        $instance = new serendipity_plugin_heavyrotation_album;
        list($instance->artist, $instance->name, $instance->url) = $data;

        return $instance;
    }

    /**
     * Write metadata and propably the image
     *
     * @return serendipity_plugin_heavyrotation_albumhandler
     */
    public function write()
    {
        $instance = $this->getInstance();
        file_put_contents($this->getPath(), join(array($instance->artist, $instance->name, $instance->url), "\n"));
        if ($instance->image !== null) {
            $umask = umask(0133);
            file_put_contents($this->getImagePath(), $instance->image);
            umask($umask);
        }
        return $this;
    }

    /**
     * Get an serendipity_plugin_heavyrotation_album-instance
     *
     * @throws serendipity_plugin_heavyrotation_albumhandler_chickeneggproblem
     * @return serendipity_plugin_heavyrotation_album
     */
    public function getInstance()
    {
        if (!$this->hasInstance()) {
            try {
                $this->setInstance($this->read());
                if (!file_exists($this->getImagePath()) or filesize($this->getImagePath()) === 0)
                    throw new serendipity_plugin_heavyrotation_albumhandler_readerror(
                        'Metadata exists, but image is not fetched. So reread the whole stuff.');
            } catch (serendipity_plugin_heavyrotation_albumhandler_readerror $exception) {
                throw new serendipity_plugin_heavyrotation_albumhandler_chickeneggproblem(
                    "Could not read image from a file. Error was: {$exception->getMessage()}");
            }
        }
        return $this->_instance;
    }

    /**
     * The handler contains an instance or not?
     *
     * @return boolean
     */
    public function hasInstance()
    {
        return $this->_instance !== null;
    }

    /**
     * Set serendipity_plugin_heavyrotation_album instance
     *
     * @param serendipity_plugin_heavyrotation_album $instance
     * @return serendipity_plugin_heavyrotation_albumhandler
     */
    public function setInstance(serendipity_plugin_heavyrotation_album $instance)
    {
        $this->_instance = $instance;
        return $this;
    }

    /**
     * Get image filename
     *
     * @return string
     */
    public function getImageFilename()
    {
        $instance = $this->getInstance();
        return md5($instance->artist . $instance->name) . ".jpg";
    }

    /**
     * Set the image directory
     *
     * @param string $image_directory
     * @return serendipity_plugin_heavyrotation_albumhandler
     */
    public function setImageDirectory($image_directory)
    {
        if (!file_exists($image_directory) or !is_dir($image_directory) or !is_writable($image_directory))
            throw new serendipity_plugin_heavyrotation_albumhandler_readerror("\"{$image_directory}\" is not writable");
        $this->_image_directory = $image_directory;
        return $this;
    }

    /**
     * Get the image directory
     *
     * @return string
     */
    public function getImageDirectory()
    {
        return $this->_image_directory;
    }

    /**
     * Get path where the image file is located
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->getImageDirectory() . DIRECTORY_SEPARATOR . $this->getImageFilename();
    }
}
