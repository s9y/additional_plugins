<?php
require_once 'ButtonInterface.php';

/**
 * Class button
 */
abstract class Button implements ButtonInterface
{
    /**
     * Textarea the button gets attached to
     *
     * @var string
     */
    protected $textarea;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $onClickEvent;

    /**
     * @var array
     */
    protected $classes = array();

    /**
     * @var bool
     */
    protected $isXhtml11 = true;

    /**
     * @var bool
     */
    protected $useNamedEnts = true;

    /**
     * @var bool
     */
    protected $isLegacyMode = false;

    /**
     * @var string
     */
    protected $openTag;

    /**
     * @var string
     */
    protected $closeTag;

    /**
     * @param string $textarea
     */
    public function __construct($textarea)
    {
        $this->setTextarea($textarea);
    }

    /**
     * @return string
     */
    public function getTextarea()
    {
        return $this->textarea;
    }

    /**
     * @param string $textarea
     */
    public function setTextarea($textarea)
    {
        $this->textarea = $textarea;
    }

    /**
     * @return array
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * @param array $classes
     */
    public function setClasses($classes)
    {
        $this->classes = $classes;
    }

    /**
     * @param string $class
     */
    public function addClass($class)
    {
        if (!in_array($class, $this->getClasses())) {
            $this->classes[] = $class;
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getOnClickEvent()
    {
        return $this->onClickEvent;
    }

    /**
     * @param string $onClickEvent
     */
    public function setOnClickEvent($onClickEvent)
    {
        $this->onClickEvent = $onClickEvent;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return boolean
     */
    public function isXhtml11()
    {
        return $this->isXhtml11;
    }

    /**
     * @param boolean $isXhtml11
     */
    public function setIsXhtml11($isXhtml11)
    {
        $this->isXhtml11 = $isXhtml11;
    }

    /**
     * @return boolean
     */
    public function isUseNamedEnts()
    {
        return $this->useNamedEnts;
    }

    /**
     * @param boolean $useNamedEnts
     */
    public function setUseNamedEnts($useNamedEnts)
    {
        $this->useNamedEnts = $useNamedEnts;
    }

    /**
     * @return boolean
     */
    public function isLegacyMode()
    {
        return $this->isLegacyMode;
    }

    /**
     * @param boolean $isLegayMode
     */
    public function setIsLegacyMode($isLegayMode)
    {
        $this->isLegacyMode = $isLegayMode;
    }

    /**
     * @return string
     */
    public function getCloseTag()
    {
        return $this->closeTag;
    }

    /**
     * @param string $closeTag
     */
    public function setCloseTag($closeTag)
    {
        $this->closeTag = $closeTag;
    }

    /**
     * @return string
     */
    public function getOpenTag()
    {
        return $this->openTag;
    }

    /**
     * @param string $openTag
     */
    public function setOpenTag($openTag)
    {
        $this->openTag = $openTag;
    }

    /**
     * @return string
     */
    public function render()
    {
        if ($this->isLegacyMode()) {
            $html = sprintf(
                '<input type="button" class="%s" name="%s" value="%s" onclick="%s" />',
                implode(' ', $this->getClasses()),
                $this->getName(),
                $this->getValue(),
                $this->getOnClickEvent()
            );
        } else {
            $html = sprintf(
                '<button class="%s" type="button" name="%s" data-tag-open="%s" data-tag-close="%s" data-tarea="%s">%s</button>',
                implode(' ', $this->getClasses()),
                $this->getName(),
                $this->getOpenTag(),
                $this->getCloseTag(),
                $this->getTextarea(),
                $this->getValue()
            );
        }
        return '            ' . $html . PHP_EOL;
    }
}
