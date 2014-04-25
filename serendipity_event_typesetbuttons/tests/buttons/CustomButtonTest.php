<?php
require_once __DIR__ . '/../../buttons/CustomButton.php';

/**
 * Class CustomButtonTest
 */
class CustomButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CustomButton
     */
    protected $button;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->button = new CustomButton('serendipity[body]');
    }

    /**
     * @test
     * @dataProvider getCustomData
     */
    public function render($name, $openTag, $closeTag)
    {
        $this->button->setName('ins_custom_' . $name);
        $this->button->setValue($name);
        $this->button->setOpen($openTag);
        $this->button->setClose($closeTag);
        $expected = '            <button class="wrap_selection" type="button" name="ins_custom_' . $name . '" data-tag-open="' . $openTag . '" data-tag-close="' . $closeTag . '" data-tarea="serendipity[body]">' . $name . '</button>' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

    /**
     * @test
     * @dataProvider getCustomData
     */
    public function renderInLegacyMode($name, $openTag, $closeTag)
    {
        $this->button->setIsLegacyMode(true);
        $this->button->setName('ins_custom_' . $name);
        $this->button->setValue($name);
        $this->button->setOpen($openTag);
        $this->button->setClose($closeTag);
        $expected = '            <input type="button" class="serendipityPrettyButton input_button" name="ins_custom_' . $name . '" value="' . $name . '" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[body]\'], \'' . $openTag . '\', \'' . $closeTag . '\')" />' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

    /**
     * Data provider for custom buttons
     *
     * @return array
     */
    public function getCustomData()
    {
        return array(
            array('code', '<code>', '</code>'),
            array('pre', '<pre>', '</pre>'),
            array('bash', '[geshi lang=bash]', '[/geshi]'),
            array('perl', '[geshi lang=perl]', '[/geshi]'),
            array('sql', '[geshi lang=sql]', '[/geshi]'),
            array('li', '<li>', '</li>'),
        );
    }
}
