<?php
require_once __DIR__ . '/../../buttons/SpaceButton.php';

/**
 * Class SpaceButtonTest
 */
class SpaceButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SpaceButton
     */
    protected $button;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->button = new SpaceButton('serendipity[body]');
    }

    /**
     * @test
     */
    public function render()
    {
        $expected = '            <button class="wrap_selection" type="button" name="insSpace" data-tag-open="&#160;" data-tag-close="" data-tarea="serendipity[body]">Space</button>' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

    /**
     * @test
     */
    public function renderInLegacyMode()
    {
        $this->button->setIsLegacyMode(true);
        $expected = '            <input type="button" class="serendipityPrettyButton input_button" name="insSpace" value="Space" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[body]\'],\'\\&\\#160\\;\',\'\')" />' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }
}
