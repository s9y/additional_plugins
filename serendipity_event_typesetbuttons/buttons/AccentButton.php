<?php
require_once 'Button.php';

/**
 * Class AccentButton
 */
class AccentButton extends Button
{
    /**
     * Constructor
     *
     * @param string $textarea
     */
    public function __construct($textarea)
    {
        parent::__construct($textarea);
        $this->setName('insaccent');
        $this->setValue(PLUGIN_EVENT_TYPESETBUTTONS_ACCENT_BUTTON);
    }

    /**
     * @return string
     */
    public function render()
    {
        if ($this->isLegacyMode()) {
            $this->addClass('serendipityPrettyButton');
            $this->addClass('input_button');
            $this->setOnClickEvent("wrapSelection(document.forms['serendipityEntry']['" . $this->getTextarea() . "'],'\\&\\#x0301\\;','')");
        } else {
            $this->addClass('wrap_selection');
            $this->setOpenTag('&#x0301;');
        }
        return parent::render();
    }
}
