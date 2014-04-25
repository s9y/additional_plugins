<?php
require_once __DIR__ . '/../../buttons/DquotesButton.php';

/**
 * Class DquotesButtonTest
 */
class DquotesButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DquotesButton
     */
    protected $button;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->button = new DquotesButton('serendipity[body]');
    }

    /**
     * @test
     * @dataProvider getNamedEntities
     */
    public function render($type, $openTag, $closeTag, $namedEntity)
    {
        $this->button->setType($type);
        $html = sprintf(
            '<button class="wrap_selection" type="button" name="insdquote" data-tag-open="%s" data-tag-close="%s" data-tarea="serendipity[body]">%s</button>',
            $openTag,
            $closeTag,
            $namedEntity
        );
        $expected = '            ' . $html . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

    /**
     * Data provider for named entities
     *
     * @return array
     */
    public function getNamedEntities()
    {
        return array(
            array('type1', '&ldquo;', '&rdquo;', '&ldquo; &rdquo;'),
            array('type2', '&bdquo;', '&ldquo;', '&bdquo; &ldquo;'),
            array('type3', '&bdquo;', '&rdquo;', '&bdquo; &rdquo;'),
            array('type4', '&rdquo;', '&rdquo;', '&rdquo; &rdquo;'),
            array('type5', '&ldquo;', '&bdquo;', '&ldquo; &bdquo;'),
            array('type6', '&#171;&#160;', '&#160;&#187;', '&laquo;&nbsp; &nbsp;&raquo;'),
            array('type7', '&#187;', '&#171;', '&raquo; &laquo;'),
            array('type8', '&#187;', '&#187;', '&raquo; &raquo;'),
        );
    }

    /**
     * @test
     */
    public function renderInLegacyMode()
    {
        $this->button->setIsLegacyMode(true);
        $this->button->setType('type1');
        $expected = '            <input type="button" class="serendipityPrettyButton input_button" name="insdquote" value="&ldquo; &rdquo;" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[body]\'],\'\\&ldquo\\;\',\'\\&rdquo\\;\')" />' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

    /**
     * @test
     */
    public function renderInLegacyModeNoNamedEnts()
    {
        $this->button->setIsLegacyMode(true);
        $this->button->setUseNamedEnts(false);
        $this->button->setType('type1');
        $expected = '            <input type="button" class="serendipityPrettyButton input_button" name="insdquote" value="&ldquo; &rdquo;" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[body]\'],\'\\&\\#8220\\;\',\'\\&\\#8221\\;\')" />' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

}
