<?php
require_once __DIR__ . '/../../buttons/AccentButton.php';

/**
 * Class AccentButtonTest
 */
class AccentButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var AccentButton
     */
    protected $button;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->button = new AccentButton('serendipity[body]');
    }

    /**
     * @test
     */
    public function render()
    {
        $expected = '            <button class="wrap_selection" type="button" name="insaccent" data-tag-open="&#x0301;" data-tag-close="" data-tarea="serendipity[body]">&nbsp;&#x0301;</button>' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

    /**
     * @test
     */
    public function renderInLegacyMode()
    {
        $this->button->setIsLegacyMode(true);
        $expected = '            <input type="button" class="serendipityPrettyButton input_button" name="insaccent" value="&nbsp;&#x0301;" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[body]\'],\'\\&\\#x0301\\;\',\'\')" />' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }
}
