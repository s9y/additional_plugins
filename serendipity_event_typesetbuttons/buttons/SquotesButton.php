<?php
require_once 'Button.php';

/**
 * Class SquotesButton
 */
class SquotesButton extends Button
{
    /**
     * @var string
     */
    protected $type;

    /**
     * Constructor
     *
     * @param string $textarea
     */
    public function __construct($textarea)
    {
        parent::__construct($textarea);
        $this->setName('inssquote');
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->overwriteValue();
        if ($this->isLegacyMode()) {
            $this->addClass('serendipityPrettyButton');
            $this->addClass('input_button');
            if ($this->isUseNamedEnts()) {
                $this->setOnClickEvent("wrapSelection(document.forms['serendipityEntry']['" . $this->getTextarea() . "']," . $this->getSurroundingNamedEntitiesStringByType() . ")");
            } else {
                $this->setOnClickEvent("wrapSelection(document.forms['serendipityEntry']['" . $this->getTextarea() . "']," . $this->getSurroundingStringByType() . ")");
            }
        } else {
            $this->addClass('wrap_selection');
            $namedEntities = $this->getCleanSurroundingStringByType();
            $tags = explode(',', $namedEntities);
            $this->setOpenTag(trim($tags[0], '\''));
            $this->setCloseTag(trim($tags[1], '\''));
        }
        return parent::render();
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Overwrite the value property according to given type
     */
    private function overwriteValue()
    {
        $typeNumber = (int) preg_replace('$type$', '', $this->getType());
        $constName = 'PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES' . $typeNumber . '_BUTTON';
        parent::setValue(constant($constName));
    }

    /**
     * @return string
     */
    private function getSurroundingStringByType()
    {
        $surroundingStrings = array(
            'type1' => "'\\&\\#8216\\;','\\&\\#8217\\;'",
            'type2' => "'\\&\\#8218\\;','\\&\\#8216\\;'",
            'type3' => "'\\&\\#8218\\;','\\&\\#8217\\;'",
            'type4' => "'\\&\\#8217\\;','\\&\\#8217\\;'",
            'type5' => "'\\&\\#8216\\;','\\&\\#8218\\;'",
            'type6' => "'\\&\\#8249\\;','\\&\\#8250\\;'",
            'type7' => "'\\&\\#8250\\;','\\&\\#8249\\;'",
            'type8' => "'\\&\\#8250\\;','\\&\\#8250\\;'",
        );
        if (!array_key_exists($this->getType(), $surroundingStrings)) {
            return $surroundingStrings['type1'];
        }
        return $surroundingStrings[$this->getType()];
    }

    /**
     * @return string
     */
    private function getSurroundingNamedEntitiesStringByType()
    {
        $surroundingStrings = array(
            'type1' => "'\\&lsquo\\;','\\&rsquo\\;'",
            'type2' => "'\\&sbquo\\;','\\&lsquo\\;'",
            'type3' => "'\\&sbquo\\;','\\&rsquo\\;'",
            'type4' => "'\\&rsquo\\;','\\&rsquo\\;'",
            'type5' => "'\\&lsquo\\;','\\&sbquo\\;'",
            'type6' => "'\\&lsaquo\\;','\\&rsaquo\\;'",
            'type7' => "'\\&rsaquo\\;','\\&lsaquo\\;'",
            'type8' => "'\\&rsaquo\\;','\\&rsaquo\\;'",
        );
        if (!array_key_exists($this->getType(), $surroundingStrings)) {
            return $surroundingStrings['type1'];
        }
        return $surroundingStrings[$this->getType()];
    }

    /**
     * @return string
     */
    private function getCleanSurroundingStringByType()
    {
        $surroundingStrings = array(
            'type1' => "'&lsquo;','&rsquo;'",
            'type2' => "'&sbquo;','&lsquo;'",
            'type3' => "'&sbquo;','&rsquo;'",
            'type4' => "'&rsquo;','&rsquo;'",
            'type5' => "'&lsquo;','&sbquo;'",
            'type6' => "'&lsaquo;','&rsaquo;'",
            'type7' => "'&rsaquo;','&lsaquo;'",
            'type8' => "'&rsaquo;','&rsaquo;'",
        );
        if (!array_key_exists($this->getType(), $surroundingStrings)) {
            return $surroundingStrings['type1'];
        }
        return $surroundingStrings[$this->getType()];
    }
}
