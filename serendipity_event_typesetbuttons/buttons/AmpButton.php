<?php
require_once 'Button.php';

/**
 * Class AmpButton
 */
class AmpButton extends Button
{
    /**
     * Constructor
     *
     * @param string $textarea
     */
    public function __construct($textarea)
    {
        parent::__construct($textarea);
        $this->setName('insamp');
        $this->setValue(PLUGIN_EVENT_TYPESETBUTTONS_AMP_BUTTON);
    }

    /**
     * @return string
     */
    public function render()
    {
        if ($this->isLegacyMode()) {
            $this->addClass('serendipityPrettyButton');
            $this->addClass('input_button');
            $this->setOnClickEvent("wrapSelection(document.forms['serendipityEntry']['" . $this->getTextarea() . "'],'\\&\\#38\\;','')");
        } else {
            $this->addClass('wrap_selection');
            $this->setOpenTag('&');
        }
        return parent::render();
    }
}
