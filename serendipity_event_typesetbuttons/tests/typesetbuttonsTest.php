<?php

require_once S9Y_INCLUDE_PATH . 'tests/plugins/PluginTest.php';
require_once S9Y_INCLUDE_PATH . 'plugins/additional_plugins/serendipity_event_typesetbuttons/serendipity_event_typesetbuttons.php';

/**
 *
 */
class serendipity_event_typesetbuttonsTest extends PluginTest
{
    /**
     * @var serendipity_event_typesetbuttons
     */
    protected $object;

    /**
     * @var serendipity_property_bag
     */
    protected $propBag;

    /**
     * @var array
     */
    protected $eventData;

    /**
     * Set up
     */
    public function setUp()
    {
        parent::setUp();
        $this->object = new serendipity_event_typesetbuttons('test');
        $this->propBag = new serendipity_property_bag();
        $this->getEventData();
    }

    /**
     * Tear down
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Helper method
     */
    protected function getEventData()
    {
        $this->eventData = array(
            'id' => 1,
            'body' => 'Normal body.',
            'extended' => 'Extended body.',
        );
    }

    /**
     * Example 1
     * @test
     */
    public function introspect()
    {
        $this->object->introspect($this->propBag);
        $this->assertEquals('Typeset/Extended Buttons for non-WYSIWYG editors', $this->propBag->get('name'));
        $this->assertFalse($this->propBag->get('stackable'));
    }

    /**
     * @test
     */
    public function generateContent()
    {
        global $serendipity;
        $serendipity['version'] = '1.7.8';
        $title = 'foobar'; // we need to pass this by reference
        $this->object->generate_content($title);
        $this->assertEquals('Typeset/Extended Buttons for non-WYSIWYG editors', $title);
    }

    /**
     * @test
     */
    public function wrongEventShouldReturnFalse()
    {
        global $serendipity;
        $serendipity['version'] = '1.7.8';
        $this->object->introspect($this->propBag);
        $this->assertFalse($this->object->event_hook('frontend_comment', $this->propBag, $this->eventData));
    }

    /**
     * @test
     */
    public function extendedToolbarShouldNotBeAffectedIfWysiwygIsActive()
    {
        global $serendipity;
        $serendipity['version'] = '1.7.8';
        $serendipity['wysiwyg'] = true; // WYSIWYG editor is active
        $this->object->introspect($this->propBag);
        $result = $this->object->event_hook('backend_entry_toolbar_extended', $this->propBag, $this->eventData);
        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function extendedToolbarWithExtendedTextareaShouldOutputButtons()
    {
        global $serendipity;
        $serendipity['version'] = '1.7.8';
        $serendipity['wysiwyg'] = false; // WYSIWYG editor is inactive
        $this->object->introspect($this->propBag);
        $this->eventData['backend_entry_toolbar_extended:textarea'] = 'serendipity[extended]';
        $result = $this->object->event_hook('backend_entry_toolbar_extended', $this->propBag, $this->eventData);
        $this->expectOutputString($this->getNotXhtml11Output('serendipity[extended]'));
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function extendedToolbarWithExtendedTextareaShouldOutputCustomButtons()
    {
        global $serendipity;
        $serendipity['version'] = '1.7.8';
        $serendipity['wysiwyg'] = false; // WYSIWYG editor is inactive
        $this->object->introspect($this->propBag);
        $customButtons = <<<EOT
code@<code>@</code>|
pre@<pre>@</pre>|
bash@[geshi lang=bash]@[/geshi]|
perl@[geshi lang=perl]@[/geshi]|
sql@[geshi lang=sql]@[/geshi]|
li@<li>@</li>
EOT;
        $this->object->set_config('custom', $customButtons);
        $this->eventData['backend_entry_toolbar_extended:textarea'] = 'serendipity[extended]';
        $result = $this->object->event_hook('backend_entry_toolbar_extended', $this->propBag, $this->eventData);
        $this->expectOutputString($this->getNotXhtml11OutputWithCustomButtons('serendipity[extended]'));
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function extendedToolbarWithExtendedTextareaShouldOutputXhtml11Buttons()
    {
        global $serendipity;
        $serendipity['version'] = '1.7.8';
        $serendipity['wysiwyg'] = false; // WYSIWYG editor is inactive
        $this->object->introspect($this->propBag);
        $this->object->set_config('use_xhtml11', 'no');
        $this->eventData['backend_entry_toolbar_extended:textarea'] = 'serendipity[extended]';
        $result = $this->object->event_hook('backend_entry_toolbar_extended', $this->propBag, $this->eventData);
        $this->expectOutputString($this->getXhtml11Output('serendipity[extended]'));
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function extendedToolbarWithCustomTextareaShouldOutputButtons()
    {
        global $serendipity;
        $serendipity['version'] = '1.7.8';
        $serendipity['wysiwyg'] = false; // WYSIWYG editor is inactive
        $this->object->introspect($this->propBag);
        $this->eventData['backend_entry_toolbar_extended:textarea'] = 'foobar';
        $result = $this->object->event_hook('backend_entry_toolbar_extended', $this->propBag, $this->eventData);
        $this->expectOutputString($this->getNotXhtml11Output('foobar'));
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function extendedToolbarWithBodyTextareaShouldOutputButtons()
    {
        global $serendipity;
        $serendipity['version'] = '1.7.8';
        $serendipity['wysiwyg'] = false; // WYSIWYG editor is inactive
        $this->object->introspect($this->propBag);
        $this->eventData['backend_entry_toolbar_body:textarea'] = 'serendipity[body]';
        $result = $this->object->event_hook('backend_entry_toolbar_body', $this->propBag, $this->eventData);
        $this->expectOutputString($this->getNotXhtml11Output('serendipity[body]'));
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function disabledButtonsShouldNotBeDisplayed()
    {
        global $serendipity;
        $serendipity['version'] = '2.0.0';
        $serendipity['wysiwyg'] = false; // WYSIWYG editor is inactive
        $this->object->introspect($this->propBag);
        $this->object->set_config('enable_center', 'no');
        $this->object->set_config('enable_strike', 'no');
        $this->eventData['backend_entry_toolbar_body:textarea'] = 'serendipity[body]';
        $result = $this->object->event_hook('backend_entry_toolbar_body', $this->propBag, $this->eventData);
        $this->expectOutputString($this->getNotXhtml11OutputWithoutDisabledButtons('serendipity[body]'));
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function disabledButtonsShouldNotBeDisplayedInLegacyMode()
    {
        global $serendipity;
        $serendipity['version'] = '1.7.8';
        $serendipity['wysiwyg'] = false; // WYSIWYG editor is inactive
        $this->object->introspect($this->propBag);
        $this->object->set_config('enable_center', 'no');
        $this->object->set_config('enable_strike', 'no');
        $this->eventData['backend_entry_toolbar_body:textarea'] = 'serendipity[body]';
        $result = $this->object->event_hook('backend_entry_toolbar_body', $this->propBag, $this->eventData);
        $this->expectOutputString($this->getNotXhtml11OutputWithoutDisabledButtonsInLegacyMode('serendipity[body]'));
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function extendedToolbarWithCustomBodyTextareaShouldOutputButtons()
    {
        global $serendipity;
        $serendipity['version'] = '1.7.8';
        $serendipity['wysiwyg'] = false; // WYSIWYG editor is inactive
        $this->object->introspect($this->propBag);
        $this->eventData['backend_entry_toolbar_body:textarea'] = 'foobar';
        $result = $this->object->event_hook('backend_entry_toolbar_body', $this->propBag, $this->eventData);
        $this->expectOutputString($this->getNotXhtml11Output('foobar'));
        $this->assertTrue($result);
    }

    /**
     * @param string $textarea
     * @return string
     */
    private function getXhtml11Output($textarea = "serendipity[extended]")
    {
        $output = "            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"inscenter\" value=\"Center\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'<center>','</center>')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insstrike\" value=\"Strike\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'<s>','</s>')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insSpace\" value=\"Space\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#160\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insamp\" value=\"&\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#38\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insemd\" value=\"&mdash;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&mdash\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insend\" value=\"&ndash;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&ndash\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insbull\" value=\"&bull;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&bull\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insdquote\" value=\"&ldquo; &rdquo;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&ldquo\\;','\\&rdquo\\;')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"inssquote\" value=\"&lsquo; &rsquo;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&lsquo\\;','\\&rsquo\\;')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insapos\" value=\"&apos;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#39\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insaccent\" value=\"&nbsp;&#x0301;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#x0301\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insgaccent\" value=\"&nbsp;&#x0300;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#x0300\\;','')\" />
";
        return $output;
    }

    /**
     * @param string $textarea
     * @return string
     */
    private function getNotXhtml11Output($textarea = "serendipity[extended]")
    {
        $output = "            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"inscenter\" value=\"Center\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'<div class=\\'s9y_typeset s9y_typeset_center\\' style=\\'text-align: center; margin: 0px auto 0px auto\\'>','</div>')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insstrike\" value=\"Strike\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'<del>','</del>')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insSpace\" value=\"Space\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#160\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insamp\" value=\"&\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#38\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insemd\" value=\"&mdash;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&mdash\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insend\" value=\"&ndash;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&ndash\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insbull\" value=\"&bull;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&bull\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insdquote\" value=\"&ldquo; &rdquo;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&ldquo\\;','\\&rdquo\\;')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"inssquote\" value=\"&lsquo; &rsquo;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&lsquo\\;','\\&rsquo\\;')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insapos\" value=\"&apos;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#39\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insaccent\" value=\"&nbsp;&#x0301;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#x0301\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insgaccent\" value=\"&nbsp;&#x0300;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#x0300\\;','')\" />
";
        return $output;
    }

    /**
     * @param string $textarea
     * @return string
     */
    private function getNotXhtml11OutputWithoutDisabledButtons($textarea = "serendipity[extended]")
    {
        $output = "            <button class=\"wrap_selection\" type=\"button\" name=\"insSpace\" data-tag-open=\"&#160;\" data-tag-close=\"\" data-tarea=\"serendipity[body]\">Space</button>
            <button class=\"wrap_selection\" type=\"button\" name=\"insamp\" data-tag-open=\"&\" data-tag-close=\"\" data-tarea=\"serendipity[body]\">&</button>
            <button class=\"wrap_selection\" type=\"button\" name=\"insemd\" data-tag-open=\"&mdash;\" data-tag-close=\"\" data-tarea=\"serendipity[body]\">&mdash;</button>
            <button class=\"wrap_selection\" type=\"button\" name=\"insend\" data-tag-open=\"&ndash;\" data-tag-close=\"\" data-tarea=\"serendipity[body]\">&ndash;</button>
            <button class=\"wrap_selection\" type=\"button\" name=\"insbull\" data-tag-open=\"&bull;\" data-tag-close=\"\" data-tarea=\"serendipity[body]\">&bull;</button>
            <button class=\"wrap_selection\" type=\"button\" name=\"insdquote\" data-tag-open=\"&ldquo;\" data-tag-close=\"&rdquo;\" data-tarea=\"serendipity[body]\">&ldquo; &rdquo;</button>
            <button class=\"wrap_selection\" type=\"button\" name=\"inssquote\" data-tag-open=\"&lsquo;\" data-tag-close=\"&rsquo;\" data-tarea=\"serendipity[body]\">&lsquo; &rsquo;</button>
            <button class=\"wrap_selection\" type=\"button\" name=\"insapos\" data-tag-open=\"&apos;\" data-tag-close=\"\" data-tarea=\"serendipity[body]\">&apos;</button>
            <button class=\"wrap_selection\" type=\"button\" name=\"insaccent\" data-tag-open=\"&#x0301;\" data-tag-close=\"\" data-tarea=\"serendipity[body]\">&nbsp;&#x0301;</button>
            <button class=\"wrap_selection\" type=\"button\" name=\"insgaccent\" data-tag-open=\"&#x0300;\" data-tag-close=\"\" data-tarea=\"serendipity[body]\">&nbsp;&#x0300;</button>
";
        return $output;
    }

    /**
     * @param string $textarea
     * @return string
     */
    private function getNotXhtml11OutputWithoutDisabledButtonsInLegacyMode($textarea = "serendipity[extended]")
    {
        $output = "            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insSpace\" value=\"Space\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#160\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insamp\" value=\"&\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#38\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insemd\" value=\"&mdash;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&mdash\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insend\" value=\"&ndash;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&ndash\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insbull\" value=\"&bull;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&bull\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insdquote\" value=\"&ldquo; &rdquo;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&ldquo\\;','\\&rdquo\\;')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"inssquote\" value=\"&lsquo; &rsquo;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&lsquo\\;','\\&rsquo\\;')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insapos\" value=\"&apos;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#39\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insaccent\" value=\"&nbsp;&#x0301;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#x0301\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insgaccent\" value=\"&nbsp;&#x0300;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#x0300\\;','')\" />
";
        return $output;
    }

    /**
     * @param string $textarea
     * @return string
     */
    private function getNotXhtml11OutputWithCustomButtons($textarea = "serendipity[extended]")
    {
        $output = "            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"inscenter\" value=\"Center\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'<div class=\\'s9y_typeset s9y_typeset_center\\' style=\\'text-align: center; margin: 0px auto 0px auto\\'>','</div>')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insstrike\" value=\"Strike\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'<del>','</del>')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insSpace\" value=\"Space\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#160\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insamp\" value=\"&\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#38\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insemd\" value=\"&mdash;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&mdash\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insend\" value=\"&ndash;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&ndash\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insbull\" value=\"&bull;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&bull\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insdquote\" value=\"&ldquo; &rdquo;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&ldquo\\;','\\&rdquo\\;')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"inssquote\" value=\"&lsquo; &rsquo;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&lsquo\\;','\\&rsquo\\;')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insapos\" value=\"&apos;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#39\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insaccent\" value=\"&nbsp;&#x0301;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#x0301\\;','')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"insgaccent\" value=\"&nbsp;&#x0300;\" onclick=\"wrapSelection(document.forms['serendipityEntry']['" . $textarea . "'],'\\&\\#x0300\\;','')\" />
<br />            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"ins_custom_code\" value=\"code\" onclick=\"wrapSelection(document.forms['serendipityEntry']['serendipity[extended]'], '<code>', '</code>')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"ins_custom_pre\" value=\"pre\" onclick=\"wrapSelection(document.forms['serendipityEntry']['serendipity[extended]'], '<pre>', '</pre>')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"ins_custom_bash\" value=\"bash\" onclick=\"wrapSelection(document.forms['serendipityEntry']['serendipity[extended]'], '[geshi lang=bash]', '[/geshi]')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"ins_custom_perl\" value=\"perl\" onclick=\"wrapSelection(document.forms['serendipityEntry']['serendipity[extended]'], '[geshi lang=perl]', '[/geshi]')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"ins_custom_sql\" value=\"sql\" onclick=\"wrapSelection(document.forms['serendipityEntry']['serendipity[extended]'], '[geshi lang=sql]', '[/geshi]')\" />
            <input type=\"button\" class=\"serendipityPrettyButton input_button\" name=\"ins_custom_li\" value=\"li\" onclick=\"wrapSelection(document.forms['serendipityEntry']['serendipity[extended]'], '<li>', '</li>')\" />
";
        return $output;
    }
}
