<?php
require_once 'Button.php';

/**
 * Class AposButton
 */
class AposButton extends Button
{
    /**
     * @var bool
     */
    protected $useRealApos = true;

    /**
     * Constructor
     *
     * @param string $textarea
     */
    public function __construct($textarea)
    {
        parent::__construct($textarea);
        $this->setName('insapos');
        $this->setValue(PLUGIN_EVENT_TYPESETBUTTONS_APOS_BUTTON);
    }

    /**
     * @return boolean
     */
    public function isUseRealApos()
    {
        return $this->useRealApos;
    }

    /**
     * @param boolean $useRealApos
     */
    public function setUseRealApos($useRealApos)
    {
        $this->useRealApos = $useRealApos;
    }

    /**
     * @return string
     */
    public function render()
    {
        if ($this->isLegacyMode()) {
            $this->addClass('serendipityPrettyButton');
            $this->addClass('input_button');
            if ($this->isUseRealApos() === false) {
                if ($this->isUseNamedEnts()) {
                    $this->setOnClickEvent(
                        "wrapSelection(document.forms['serendipityEntry']['" . $this->getTextarea(
                        ) . "'],'&rsquo;','')"
                    );
                } else {
                    $this->setOnClickEvent(
                        "wrapSelection(document.forms['serendipityEntry']['" . $this->getTextarea(
                        ) . "'],'&#8217;','')"
                    );
                }
            } else {
                $this->setOnClickEvent(
                    "wrapSelection(document.forms['serendipityEntry']['" . $this->getTextarea() . "'],'\\&\\#39\\;','')"
                );
            }
        } else {
            $this->addClass('wrap_selection');
            $this->setOpenTag('&apos;');
        }
        return parent::render();
    }
}
