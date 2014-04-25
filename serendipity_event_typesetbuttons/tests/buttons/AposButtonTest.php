<?php
require_once __DIR__ . '/../../buttons/AposButton.php';

/**
 * Class AposButtonTest
 */
class AposButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var AposButton
     */
    protected $button;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->button = new AposButton('serendipity[body]');
    }

    /**
     * @test
     */
    public function render()
    {
        $expected = '            <button class="wrap_selection" type="button" name="insapos" data-tag-open="&apos;" data-tag-close="" data-tarea="serendipity[body]">&apos;</button>' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

    /**
     * @test
     */
    public function renderInLegacyMode()
    {
        $this->button->setIsLegacyMode(true);
        $expected = '            <input type="button" class="serendipityPrettyButton input_button" name="insapos" value="&apos;" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[body]\'],\'\\&\\#39\\;\',\'\')" />' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

    /**
     * @test
     */
    public function renderInLegacyModeNoRealApos()
    {
        $this->button->setIsLegacyMode(true);
        $this->button->setUseRealApos(false);
        $expected = '            <input type="button" class="serendipityPrettyButton input_button" name="insapos" value="&apos;" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[body]\'],\'&rsquo;\',\'\')" />' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

    /**
     * @test
     */
    public function renderInLegacyModeNoRealAposAndNoNamedEnts()
    {
        $this->button->setIsLegacyMode(true);
        $this->button->setUseRealApos(false);
        $this->button->setUseNamedEnts(false);
        $expected = '            <input type="button" class="serendipityPrettyButton input_button" name="insapos" value="&apos;" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[body]\'],\'&#8217;\',\'\')" />' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }
}
