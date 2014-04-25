<?php
require_once __DIR__ . '/../../buttons/EmdashButton.php';

/**
 * Class EmdashButtonTest
 */
class EmdashButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var EmdashButton
     */
    protected $button;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->button = new EmdashButton('serendipity[body]');
    }

    /**
     * @test
     */
    public function render()
    {
        $html = sprintf(
            '<button class="wrap_selection" type="button" name="insemd" data-tag-open="%s" data-tag-close="%s" data-tarea="serendipity[body]">%s</button>',
            '&mdash;',
            '',
            '&mdash;'
        );
        $expected = '            ' . $html . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

    /**
     * @test
     */
    public function renderInLegacyMode()
    {
        $this->button->setIsLegacyMode(true);
        $expected = '            <input type="button" class="serendipityPrettyButton input_button" name="insemd" value="&mdash;" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[body]\'],\'\\&mdash\\;\',\'\')" />' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

    /**
     * @test
     */
    public function renderInLegacyModeNoNamedEnts()
    {
        $this->button->setIsLegacyMode(true);
        $this->button->setUseNamedEnts(false);
        $expected = '            <input type="button" class="serendipityPrettyButton input_button" name="insemd" value="&mdash;" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[body]\'],\'\\&\\#8212\\;\',\'\')" />' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }
}
