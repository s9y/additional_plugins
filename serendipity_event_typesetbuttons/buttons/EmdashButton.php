<?php
require_once 'Button.php';

/**
 * Class EmdashButton
 */
class EmdashButton extends Button
{
    /**
     * Constructor
     *
     * @param string $textarea
     */
    public function __construct($textarea)
    {
        parent::__construct($textarea);
        $this->setName('insemd');
        $this->setValue(PLUGIN_EVENT_TYPESETBUTTONS_EMDASH_BUTTON);
    }

    /**
     * @return string
     */
    public function render()
    {
        if ($this->isLegacyMode()) {
            $this->addClass('serendipityPrettyButton');
            $this->addClass('input_button');
            if ($this->isUseNamedEnts()) {
                $this->setOnClickEvent("wrapSelection(document.forms['serendipityEntry']['" . $this->getTextarea() . "'],'\\&mdash\\;','')");
            } else {
                $this->setOnClickEvent("wrapSelection(document.forms['serendipityEntry']['" . $this->getTextarea() . "'],'\\&\\#8212\\;','')");
            }
        } else {
            $this->addClass('wrap_selection');
            $this->setOpenTag('&mdash;');
        }
        return parent::render();
    }
}
