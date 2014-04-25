<?php
require_once __DIR__ . '/../../buttons/StrikeButton.php';

/**
 * Class StrikeButtonTest
 */
class StrikeButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var StrikeButton
     */
    protected $button;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->button = new StrikeButton('serendipity[body]');
    }

    /**
     * @test
     */
    public function render()
    {
        $expected = '            <button class="wrap_selection lang-html" type="button" name="insstrike" data-tag-open="p style=\'text-decoration: line-through;\'" data-tag-close="p" data-tarea="serendipity[body]">Strike</button>' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

    /**
     * @test
     */
    public function renderInLegacyMode()
    {
        $this->button->setIsLegacyMode(true);
        $this->button->setIsXhtml11(false);
        $expected = "            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insstrike\" value=\"Strike\" onclick=\"wrapSelection(document.forms['serendipityEntry']['serendipity[body]'],'<s>','</s>')\" />" . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

    /**
     * @test
     */
    public function renderInLegacyModeAndXhtml11()
    {
        $this->button->setIsLegacyMode(true);
        $expected = "            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insstrike\" value=\"Strike\" onclick=\"wrapSelection(document.forms['serendipityEntry']['serendipity[body]'],'<del>','</del>')\" />" . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }
}
