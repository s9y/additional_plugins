<?php

require_once S9Y_INCLUDE_PATH . 'tests/plugins/PluginTest.php';
require_once S9Y_INCLUDE_PATH . 'plugins/additional_plugins/serendipity_event_lsrstopper/serendipity_event_lsrstopper.php';

/**
 * Class serendipity_event_lsrstopperTest
 *
 * @author Matthias Gutjahr <mattsches@gmail.com>
 */
class serendipity_event_lsrstopperTest extends PluginTest
{
    /**
     * @var serendipity_event_lsrstopper
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
        $this->object = new serendipity_event_lsrstopper('test');
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
            'body' => 'Normal body mit <a href="http://www.morgenpost.de/foo">Link</a>.',
            'extended' => 'Extended body.',
        );
    }

    /**
     * @test
     */
    public function testIntrospect()
    {
        $this->object->introspect($this->propBag);
        $this->assertEquals('0.3', $this->propBag->get('version'));
        $this->assertFalse($this->propBag->get('stackable'));
    }

    /**
     * @test
     */
    public function testGenerateContent()
    {
        $title = 'foobar'; // we need to pass this by reference
        $this->object->generate_content($title);
        $this->assertEquals('D64 LSR-Stopper', $title);
    }

    /**
     * @test
     */
    public function testFrontendDisplay()
    {
        $this->object->introspect($this->propBag);
        $this->object->set_config('blacklist_url', S9Y_INCLUDE_PATH . 'plugins/serendipity_event_lsrstopper/tests/fixtures/blacklist.txt');
        $this->object->event_hook('frontend_display', $this->propBag, $this->eventData);
        $expectedBody = 'Normal body mit <a href="http://leistungsschutzrecht-stoppen.d-64.org/blacklisted/?url=aHR0cDovL3d3dy5tb3JnZW5wb3N0LmRlL2Zvbw==">Link</a>.';
        $this->assertEquals($expectedBody, $this->eventData['body']);
    }
}
