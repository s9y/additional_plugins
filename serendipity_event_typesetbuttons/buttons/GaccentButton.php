<?php
require_once 'Button.php';

/**
 * Class GaccentButton
 */
class GaccentButton extends Button
{
    /**
     * Constructor
     *
     * @param string $textarea
     */
    public function __construct($textarea)
    {
        parent::__construct($textarea);
        $this->setName('insgaccent');
        $this->setValue(PLUGIN_EVENT_TYPESETBUTTONS_GACCENT_BUTTON);
    }

    /**
     * @return string
     */
    public function render()
    {
        if ($this->isLegacyMode()) {
            $this->addClass('serendipityPrettyButton');
            $this->addClass('input_button');
            $this->setOnClickEvent(
                "wrapSelection(document.forms['serendipityEntry']['" . $this->getTextarea() . "'],'\\&\\#x0300\\;','')"
            );
        } else {
            $this->addClass('wrap_selection');
            $this->setOpenTag('&#x0300;');
        }
        return parent::render();
    }
}
