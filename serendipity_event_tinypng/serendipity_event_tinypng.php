<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_tinypng extends serendipity_event {
    var $title = PLUGIN_EVENT_TINYPNG_NAME;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_TINYPNG_NAME);
        $propbag->add('description',   PLUGIN_EVENT_TINYPNG_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'onli');
        $propbag->add('version',       '0.2');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0'
        ));
        $propbag->add('event_hooks',   array('backend_image_add' => true));
        $propbag->add('groups', array('IMAGES'));

        $propbag->add('configuration', array('tinypngkey'));
    }

    function generate_content(&$title) {
        $title = $this->title;
    }


    function introspect_config_item($name, &$propbag) {
        global $serendipity;
        switch($name) {
            case 'tinypngkey':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_TINYPNG_APIKEY);
                $propbag->add('description',    PLUGIN_EVENT_TINYPNG_APIKEY_DESC);
                $propbag->add('default',        'none');
                break;
            

        }
        return true;
    }


    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_image_add':
					require_once("tinify-php/lib/Tinify/Exception.php");
					require_once("tinify-php/lib/Tinify/ResultMeta.php");
					require_once("tinify-php/lib/Tinify/Result.php");
					require_once("tinify-php/lib/Tinify/Source.php");
					require_once("tinify-php/lib/Tinify/Client.php");
					require_once("tinify-php/lib/Tinify.php");

					Tinify\setKey($this->get_config("tinypngkey"));
					
                    $image = $eventData;
					if (substr($image, -4) == ".png" || substr($image, -4) == ".jpg") {
						$thumbnail = str_replace(".jpg", ".serendipityThumb.jpg", $image);
						$thumbnail = str_replace(".png", ".serendipityThumb.png", $thumbnail);
						Tinify\fromFile($image)->toFile($image);
						Tinify\fromFile($thumbnail)->toFile($thumbnail);
					}
                    break;
                default:
                    return false;
            }
        } else {
            return false;
        }
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>
