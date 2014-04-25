<?php
require_once __DIR__ . '/../../buttons/AmpButton.php';

/**
 * Class AmpButtonTest
 */
class AmpButtonTest extends PHPUnit_Framework_TestCase
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
        $this->button = new AmpButton('serendipity[body]');
    }

    /**
     * @test
     */
    public function render()
    {
        $expected = '            <button class="wrap_selection" type="button" name="insamp" data-tag-open="&" data-tag-close="" data-tarea="serendipity[body]">&</button>' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

    /**
     * @test
     */
    public function renderInLegacyMode()
    {
        $this->button->setIsLegacyMode(true);
        $expected = '            <input type="button" class="serendipityPrettyButton input_button" name="insamp" value="&" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[body]\'],\'\\&\\#38\\;\',\'\')" />' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }
}
