<?php
require_once 'Button.php';

/**
 * Class SpaceButton
 */
class SpaceButton extends Button
{
    /**
     * Constructor
     *
     * @param string $textarea
     */
    public function __construct($textarea)
    {
        parent::__construct($textarea);
        $this->setName('insSpace');
        $this->setValue(PLUGIN_EVENT_TYPESETBUTTONS_SPACE_BUTTON);
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
                "wrapSelection(document.forms['serendipityEntry']['" . $this->getTextarea() . "'],'\\&\\#160\\;','')"
            );
        } else {
            $this->addClass('wrap_selection');
            $this->setOpenTag('&#160;');
        }
        return parent::render();
    }
}
