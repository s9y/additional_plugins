<?php
require_once __DIR__ . '/../../buttons/CenterButton.php';

/**
 * Class CenterButtonTest
 */
class CenterButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CenterButton
     */
    protected $button;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->button = new CenterButton('serendipity[body]');
    }

    /**
     * @test
     */
    public function render()
    {
        $expected = '            <button class="wrap_selection lang-html" type="button" name="inscenter" data-tag-open="p style=\'text-align: center;\'" data-tag-close="p" data-tarea="serendipity[body]">Center</button>' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

    /**
     * @test
     */
    public function renderInLegacyMode()
    {
        $this->button->setIsLegacyMode(true);
        $this->button->setIsXhtml11(false);
        $expected = "            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"inscenter\" value=\"Center\" onclick=\"wrapSelection(document.forms['serendipityEntry']['serendipity[body]'],'<center>','</center>')\" />" . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

    /**
     * @test
     */
    public function renderInLegacyModeAndXhtml11()
    {
        $this->button->setIsLegacyMode(true);
        $expected = "            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"inscenter\" value=\"Center\" onclick=\"wrapSelection(document.forms['serendipityEntry']['serendipity[body]'],'<div class=\\'s9y_typeset s9y_typeset_center\\' style=\\'text-align: center; margin: 0px auto 0px auto\\'>','</div>')\" />" . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }
}
