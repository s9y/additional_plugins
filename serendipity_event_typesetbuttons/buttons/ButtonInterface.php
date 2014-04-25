<?php

/**
 * Interface ButtonInterface
 */
interface ButtonInterface
{
    /**
     * @param string $textarea
     */
    public function __construct($textarea);

    /**
     * @param boolean $isXhtml11
     */
    public function setIsXhtml11($isXhtml11);

    /**
     * @param boolean $useNamedEnts
     */
    public function setUseNamedEnts($useNamedEnts);

    /**
     * @param boolean $isLegacyMode
     */
    public function setIsLegacyMode($isLegacyMode);

    /**
     * @param string $openTag
     */
    public function setOpenTag($openTag);

    /**
     * @param string $closeTag
     */
    public function setCloseTag($closeTag);
    /**
     * @return string
     */
    public function render();
} 
