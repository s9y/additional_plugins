<?php # 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}
include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_plugin_authors extends serendipity_plugin
{
    var $title = PLUGIN_AUTHORS_NAME;

    function introspect(&$propbag)
    {
        $propbag->add('name',          PLUGIN_AUTHORS_NAME);
        $propbag->add('description',   PLUGIN_AUTHORS_DESC);
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Victor Fusco');
        $propbag->add('version',       '0.11');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_VIEWS'));
        $propbag->add('configuration', array('title'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'title':
                $propbag->add('type',          'string');
                $propbag->add('name',          TITLE);
                $propbag->add('description',   TITLE);
                $propbag->add('default', PLUGIN_AUTHORS_NAME);
                break;
        }
        return true;
    }

    function generate_content(&$title) {
        global $serendipity;

    	$title = $this->get_config('title', $this->title);

        $authors_query = "SELECT realname, username, authorid FROM {$serendipity['dbPrefix']}authors";
        $row_authors = serendipity_db_query($authors_query);

        echo '<ul class="plainList">';

        foreach ($row_authors as $entry) {
            if (function_exists('serendipity_authorURL')) {
                $entryLink = serendipity_authorURL($entry);
            } else {
            	$entryLink = serendipity_rewriteURL(
                               PATH_AUTHORS . '/' .
                               serendipity_makePermalink(
                                 PERM_AUTHORS,
                                 array(
                                   'id'    => $entry['authorid'],
                                   'title' => $entry['realname']
                                 )
                               )
                             );
            }

            echo '<li><a href="' . $entryLink . '">' . $entry['realname'] . '</a></li>';
        }
        echo '</ul>';
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>
