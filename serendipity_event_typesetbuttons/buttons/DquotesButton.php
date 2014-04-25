<?php
require_once 'Button.php';

/**
 * Class DquotesButton
 */
class DquotesButton extends Button
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
        $this->setName('insdquote');
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
        $constName = 'PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES' . $typeNumber . '_BUTTON';
        parent::setValue(constant($constName));
    }

    /**
     * @return string
     */
    private function getSurroundingStringByType()
    {
        $surroundingStrings = array(
            'type1' => "'\\&\\#8220\\;','\\&\\#8221\\;'",
            'type2' => "'\\&\\#8222\\;','\\&\\#8220\\;'",
            'type3' => "'\\&\\#8222\\;','\\&\\#8221\\;'",
            'type4' => "'\\&\\#8221\\;','\\&\\#8221\\;'",
            'type5' => "'\\&\\#8220\\;','\\&\\#8222\\;'",
            'type6' => "'\\&\\#171\\;\\&\\#160\\;','\\&\\#160\\;\\&\\#187\\;'",
            'type7' => "'\\&\\#187\\;','\\&\\#171\\;'",
            'type8' => "'\\&\\#187\\;','\\&\\#187\\;'",
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
            'type1' => "'\\&ldquo\\;','\\&rdquo\\;'",
            'type2' => "'\\&bdquo\\;','\\&ldquo\\;'",
            'type3' => "'\\&bdquo\\;','\\&rdquo\\;'",
            'type4' => "'\\&rdquo\\;','\\&rdquo\\;'",
            'type5' => "'\\&ldquo\\;','\\&bdquo\\;'",
            'type6' => "'\\&\\#171\\;\\&\\#160\\;','\\&\\#160\\;\\&\\#187\\;'",
            'type7' => "'\\&\\#187\\;','\\&\\#171\\;'",
            'type8' => "'\\&\\#187\\;','\\&\\#187\\;'",
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
            'type1' => "'&ldquo;','&rdquo;'",
            'type2' => "'&bdquo;','&ldquo;'",
            'type3' => "'&bdquo;','&rdquo;'",
            'type4' => "'&rdquo;','&rdquo;'",
            'type5' => "'&ldquo;','&bdquo;'",
            'type6' => "'&#171;&#160;','&#160;&#187;'",
            'type7' => "'&#187;','&#171;'",
            'type8' => "'&#187;','&#187;'",
        );
        if (!array_key_exists($this->getType(), $surroundingStrings)) {
            return $surroundingStrings['type1'];
        }
        return $surroundingStrings[$this->getType()];
    }
}
