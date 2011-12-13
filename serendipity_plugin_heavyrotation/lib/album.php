<?php
/**
 * Simple album object
 *
 * @author Lars Strojny <lars@strojny.net>
 */
class serendipity_plugin_heavyrotation_album
{
    /**
     * Artist name
     *
     * @var string
     */
    public $artist;

    /**
     * Album name
     *
     * @var string
     */
    public $name;

    /**
     * Album image (binary data)
     *
     * @var string
     */
    public $image;

    /**
     * URL in last.fm (breaks solid OOP, I know)
     *
     * @var string
     */
    public $url;

    /**
     * Setup object. Provides convenience to pass all params in one line
     *
     * @return serendipity_plugin_heavyrotation_album
     */
    public function __construct($artist = null, $name = null, $image = null, $url = null)
    {
        $this->artist = $artist;
        $this->name = $name;
        $this->image = $image;
        $this->url = $url;
    }
}
