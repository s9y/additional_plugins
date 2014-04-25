<?php
require_once __DIR__ . '/../../buttons/SquotesButton.php';

/**
 * Class SquotesButtonTest
 */
class SquotesButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SquotesButton
     */
    protected $button;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->button = new SquotesButton('serendipity[body]');
    }

    /**
     * @test
     * @dataProvider getNamedEntities
     */
    public function render($type, $openTag, $closeTag, $namedEntity)
    {
        $this->button->setType($type);
        $html = sprintf(
            '<button class="wrap_selection" type="button" name="inssquote" data-tag-open="%s" data-tag-close="%s" data-tarea="serendipity[body]">%s</button>',
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
            array('type1', '&lsquo;', '&rsquo;', '&lsquo; &rsquo;'),
            array('type2', '&sbquo;', '&lsquo;', '&sbquo; &lsquo;'),
            array('type3', '&sbquo;', '&rsquo;', '&sbquo; &rsquo;'),
            array('type4', '&rsquo;', '&rsquo;', '&rsquo; &rsquo;'),
            array('type5', '&lsquo;', '&sbquo;', '&lsquo; &sbquo;'),
            array('type6', '&lsaquo;', '&rsaquo;', '&lsaquo; &rsaquo;'),
            array('type7', '&rsaquo;', '&lsaquo;', '&rsaquo; &lsaquo;'),
            array('type8', '&rsaquo;', '&rsaquo;', '&rsaquo; &rsaquo;'),
        );
    }

    /**
     * @test
     */
    public function renderInLegacyMode()
    {
        $this->button->setIsLegacyMode(true);
        $this->button->setType('type1');
        $expected = '            <input type="button" class="serendipityPrettyButton input_button" name="inssquote" value="&lsquo; &rsquo;" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[body]\'],\'\\&lsquo\\;\',\'\\&rsquo\\;\')" />' . PHP_EOL;
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
        $expected = '            <input type="button" class="serendipityPrettyButton input_button" name="inssquote" value="&lsquo; &rsquo;" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[body]\'],\'\\&\\#8216\\;\',\'\\&\\#8217\\;\')" />' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }
}
