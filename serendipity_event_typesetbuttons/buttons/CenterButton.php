<?php
require_once 'Button.php';

/**
 * Class button
 */
class CenterButton extends Button
{
    /**
     * Constructor
     *
     * @param string $textarea
     */
    public function __construct($textarea)
    {
        parent::__construct($textarea);
        $this->setName('inscenter');
        $this->setValue(PLUGIN_EVENT_TYPESETBUTTONS_CENTER_BUTTON);
    }

    /**
     * @return string
     */
    public function render()
    {
        if ($this->isLegacyMode()) {
            $this->addClass('serendipityPrettyButton');
            $this->addClass('input_button');
            if ($this->isXhtml11()) {
                $this->setOnClickEvent("wrapSelection(document.forms['serendipityEntry']['" . $this->getTextarea() . "'],'<div class=\\'s9y_typeset s9y_typeset_center\\' style=\\'text-align: center; margin: 0px auto 0px auto\\'>','</div>')");
            } else {
                $this->setOnClickEvent("wrapSelection(document.forms['serendipityEntry']['" . $this->getTextarea() . "'],'<center>','</center>')");
            }
        } else {
            $this->addClass('wrap_selection');
            $this->addClass('lang-html');
            $this->setOpenTag('p style=\'text-align: center;\'');
            $this->setCloseTag('p');
        }
        return parent::render();
    }
}
