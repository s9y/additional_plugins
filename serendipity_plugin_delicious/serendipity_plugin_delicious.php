<?php
/*
    A del.icio.us plug-in - v0.2.3 (feed edition) Notations
    -------------------------------------------------
        email: riscky@gmail.com
        download: http://riscky.info:8080/serendipity/archives/4-A-del.icio.us-plug-in-v0.2-feed-edition-notations.html
        forum announcement: http://s9y.info/forums/viewtopic.php?p=2880
    -------------------------------------------------
    About:
     A del.icio.us plug-in (feed edition) provides a basic dumbed down del.icio.us integration into Serendipity. Originally the plug-in entitled "Embed my Links" to reflect the main goal of the plug-in; to clone the popular "Remaindered Links" & "Blogmarks" systems, and uses the trendy del.icio.us for its back-end support. The 0.2.x development series will be the last series what supports Serendipity 0.7.x branch.

    Fixed:
     Fixed some error sniffing logic [v0.2.2]
     Removed Onyx Cacheing [v0.2.1]
     Better caching system [v0.2]     Added tag & tag intersection support [v0.2]     Handles feed errors in an elegant manner (not perfeect) [v0.2]
     Some little stuff too [v0.2]

    Known Issues:
     * update plug-ins config options don't take effect right away; i.e. if current cache time is 3 hours, you just change feed size from 30 to 10... and just grabed a new feed then you must wait 3 hours from last feed grab must occur before feed size changes -- no working theory's yet

    Post release plans:
    * 'Public' set up public SVN server to obtain latest version of the plug-in [v0.2.2 commited to serendipity CVS]
    * 'API' move to from RSS gets to api gets
    * 'Scope' Pair up Serendipity Categories with del.icio.us tags
    * 'Temporal' Display only del.icio.us tags in reference to current serendipity time view
    * 'Inline' Ability to display del.icio.us content in the main frame

     This plug-in should work; any comments etc can be directed towards riscky-\{\@\}-gmail-\[dot\]-com
*/

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_plugin_delicious extends serendipity_plugin {

    function introspect(&$propbag) {
        $propbag->add('name', PLUGIN_DELICIOUS_N);
        $propbag->add('description', PLUGIN_DELICIOUS_D);
        $propbag->add('author', 'Riscky');
        $propbag->add('version', '0.8.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('stackable', true);
        $propbag->add('configuration',
            array(  'sidebarTitle',
                    'deliciousID',
                    'displayNumber',
                    'cacheTime',
                    'moreLink',
                    'morelink_text'
        ));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'sidebarTitle':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_DELICIOUS_TITLE_N);
                $propbag->add('description', PLUGIN_DELICIOUS_TITLE_D);
                $propbag->add('default', 'My del.icio.us');
                break;

            case 'deliciousID':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_DELICIOUS_USERNAME_N);
                $propbag->add('description', PLUGIN_DELICIOUS_USERNAME_D);
                $propbag->add('default', 'riscky');
                break;

            case 'morelink_text':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_DELICIOUS_MORELINK_T);
                $propbag->add('description', '');
                $propbag->add('default', PLUGIN_DELICIOUS_MORELINK);
                break;

            case 'displayNumber':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_DELICIOUS_DISPLAYNUMBER_N);
                $propbag->add('description', PLUGIN_DELICIOUS_DISPLAYNUMBER_D);
                $propbag->add('default', '30');
                break;

            case 'cacheTime':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_DELICIOUS_CACHETIME_N);
                $propbag->add('description', PLUGIN_DELICIOUS_CACHETIME_D);
                $propbag->add('default', 1);
                break;

            case 'moreLink':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_DELICIOUS_MORELINK_N);
                $propbag->add('description', PLUGIN_DELICIOUS_MORELINK_D);
                $propbag->add('default', 'true');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {

        global $serendipity;
        $title = $this->get_config('sidebarTitle');
        $deliciousID = $this->get_config('deliciousID');
        $moreLink = $this->get_config('moreLink');

        if (empty($deliciousID)) {
            return false;
        }

        if ($this->get_config('displayNumber') < 30 && $this->get_config('displayNumber') >= 1) {
            $displayNumber = $this->get_config('displayNumber');
        } else {
            $displayNumber = 30;
        }

        if ($this->get_config('cacheTime') > 0) {
            $cacheTime = ($this->get_config('cacheTime') * 3600);
        } else {
            $cacheTime = 3600 + 1 ;
        }

        $gDeliciousURL = 'http://del.icio.us/';
        $gDeliciousCacheLoc = $serendipity['serendipityPath'] . '/templates_c/delicious_';

        // safe write location... need to have local abilit

        $parsedCache = $gDeliciousCacheLoc . md5($deliciousID) . '.cache';

        if(!is_file($parsedCache) || ((mktime() - filectime($parsedCache)) > $cacheTime)) {
            if (!is_dir($gDeliciousCacheLoc) && !mkdir($gDeliciousCacheLoc, 0775)) {
                print 'Try to chmod go+rwx - permissions are wrong.';
            }

            require_once 'Onyx/RSS.php';
            $deliciousFeed = new Onyx_RSS();
            //$deliciousFeed->setCachePath($gDeliciousCacheLoc);
            //$deliciousFeed->setExpiryTime($cacheTime);
            //$deliciousFeed->parse($gDeliciousURL .'rss/' . $deliciousID, md5($deliciousID) . '.dat');
            $deliciousFeed->parse($gDeliciousURL . 'rss/' . $deliciousID);

            if( $deliciousFeed->numItems() >= 1 ) {
                $fileHandle = @fopen($parsedCache, 'w');
                if ($fileHandle) {

                    $deliciousContent = '<ul class="plainList">';
                    for($i = 0; ($item = $deliciousFeed->getNextItem()) && ($i < $displayNumber); $i++) {
                        $deliciousContent .=
                            '<li>' .
                            '<a href="' . delicious_clean_htmlspecialchars($item['link']) .
                            '" title="' . $item['description'] . '" rel="external">' . delicious_clean_htmlspecialchars($item['title']) . '</a></li>';
                    }

                    $deliciousContent .= '</ul>';
                    fwrite($fileHandle, $deliciousContent);
                    fclose($fileHandle);
                    print $deliciousContent;
                } else {
                    print '<p>A del.icio.us error occured! <br />' . 'Error Message: unable to make a delicious cache file: ' . $parsedCache . '!</p>';
                }
            } elseif (is_file($parsedCache)) {
                print file_get_contents($parsedCache);
            } else {
                print '<p>A del.icio.us error occured! <br />' . 'Error Message: rss failed</p>';
            }
        } else {
            print file_get_contents($parsedCache);
        }

        if (serendipity_db_bool($moreLink)) {
            print '<p><a href="' . $gDeliciousURL . $deliciousID . '/">' . $this->get_config('morelink_text') . '</a></p>';
        }
    }
}

function delicious_clean_htmlspecialchars($given, $quote_style = ENT_QUOTES) {
    return htmlspecialchars(html_entity_decode($given, $quote_style), $quote_style);
}
?>