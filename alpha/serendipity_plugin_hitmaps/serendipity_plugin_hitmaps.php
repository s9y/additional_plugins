<?php

// Hitmaps Block for Serendipity
// see http://kmi.open.ac.uk/projects/hitmaps/
// 11/2004 by Thomas Nesges <thomas@tnt-computer.de>


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_plugin_hitmaps extends serendipity_plugin {

    function introspect(&$propbag) {
        $propbag->add('name',          PLUGIN_HITMAPS_TITLE);
        $propbag->add('description',   PLUGIN_HITMAPS_DESC);
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',  '1.1');
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
    }

    function generate_content(&$title) {
        global $serendipity;

        $title   = PLUGIN_HITMAPS_TITLE;
        $siteurl = preg_replace("@http://(.*?)/?$@", "\\1", $serendipity['baseURL']);

        echo "<a href='http://valepark.open.ac.uk/cpdn/stats/".$siteurl."-/map-world.html' id='hitMapsLink'>
            <img src='http://jabber-dev.open.ac.uk/stats/index2.php?url=http://".$siteurl."/' border='0' alt='".PLUGIN_HITMAPS_MAPALTTEXT."' onError=\"this.onError=null; this.src='http://kmi.open.ac.uk/projects/hitmaps/imgs/begins-tomorrow.jpg'; document.getElementById('hitMapsLink').href='http://kmi.open.ac.uk/projects/hitmaps/'\"  /></a>";
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>