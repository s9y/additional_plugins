<?php # $Id: serendipity_plugin_pollbox.php,v 1.11 2007/02/22 10:41:24 garvinhicking Exp $

include_once dirname(__FILE__) . '/common.inc.php';

class serendipity_plugin_pollbox extends serendipity_plugin {
    var $title = PLUGIN_POLL_TITLE;
    
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name', PLUGIN_POLL_TITLE);
        $propbag->add('description', PLUGIN_POLL_TITLE_SIDEBAR);
        $propbag->add('configuration', array('title'));
        $propbag->add('author', 'Garvin Hicking, Evan Nemerson');
        $propbag->add('stackable', false);
        $propbag->add('version', '2.08');
        $propbag->add('groups', array('STATISTICS'));
        $this->dependencies = array('serendipity_event_pollbox' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        if ( $name == 'title' ) {
            $propbag->add('type',          'string');
            $propbag->add('name',          TITLE);
            $propbag->add('description',   TITLE);
            $propbag->add('default',       PLUGIN_POLL_TITLE);
        }

        return true;
    }

    function generate_content(&$title) {
        global $serendipity;

        $title = $this->get_config('title');
        serendipity_common_pollbox::poll();
        echo '<br /><a class="votearchive" href="' . $serendipity['baseURL'] . $serendipity['indexFile'] . '?serendipity[subpage]=votearchive">' . ARCHIVES . '</a>';
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>