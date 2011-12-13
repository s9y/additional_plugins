<?php # $Id: serendipity_event_jquery.php,v 1.5 2010/12/31 17:23:47 garvinhicking Exp $


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_jquery extends serendipity_event {
    var $title = EVENT_JQUERY_TITLE;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          EVENT_JQUERY_TITLE);
        $propbag->add('description',   EVENT_JQUERY_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author', 'Malte Paskuda');
        $propbag->add('version', '1.10');
        $propbag->add('event_hooks', array('frontend_header' => true,
                                           'backend_header'  => true,
                                            'backend_plugins_new_instance'  => true
                     ));
        $propbag->add('groups', array('BACKEND_FEATURES'));
    }    

    function generate_content(&$title) {
        $title = $this->title;
    }

    function install() {
        $this->order_to_first();
    }
    

    function event_hook($event, &$bag, &$eventData) {
        global $serendipity;
        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_header':
                case 'backend_header':
                    // Serendipity 1.6 has jquery bundled.
                    if ($serendipity['capabilities']['jquery']) return '';
                    echo '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>' . "\n";
                    break;

                case 'backend_plugins_new_instance':
                    $this->order_to_first();
                    return true;
                    break;

            default:
                return false;
            }
        } else {
            return false;
        }
    }

    function order_to_first() {
        global $serendipity;
        // Fetch minimum sort_order value. This will be the new value of our current plugin.
        $q  = "SELECT MIN(sort_order) as sort_order_min FROM {$serendipity['dbPrefix']}plugins WHERE placement = '" . $addData['default_placement'] . "'";
        $rs  = serendipity_db_query($q, true, 'num');

        // Fetch current sort_order of current plugin.
        $q   = "SELECT sort_order FROM {$serendipity['dbPrefix']}plugins WHERE name = '" . $this->instance . "'";
        $cur = serendipity_db_query($q, true, 'num');
        
        // Increase sort_order of all plugins before current plugin by one.
        $q = "UPDATE {$serendipity['dbPrefix']}plugins SET sort_order = sort_order + 1 WHERE placement = '" . $addData['default_placement'] . "' AND sort_order < " . intval($cur[0]);
        serendipity_db_query($q);

        // Set current plugin as first plugin in queue.
        $q = "UPDATE {$serendipity['dbPrefix']}plugins SET sort_order = " . intval($rs[0]) . " WHERE name = '" . $this->instance . "'";
        serendipity_db_query($q);
    }

}

/* vim: set sts=4 ts=4 expandtab :
* Local variables:
* tab-width: 4
* c-basic-offset: 4
* indent-tabs-mode: nil
* End:
*/
