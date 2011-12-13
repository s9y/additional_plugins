<?php # $Id: serendipity_plugin_communityrating.php,v 1.3 2010/03/29 07:38:14 garvinhicking Exp $


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

class serendipity_plugin_communityrating extends serendipity_plugin
{
    var $title = PLUGIN_EVENT_COMMUNITYRATING_AVGRATING;

    function introspect(&$propbag)
    {
        global $serendipity;

        $this->title = $this->get_config('title', $this->title);

        $propbag->add('name',          $this->title);
        $propbag->add('description',   PLUGIN_EVENT_COMMUNITYRATING_AVGRATING_DESC);
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Lewe Zipfel, Garvin Hicking');
        $propbag->add('version',       '1.2');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('STATISTICS'));
        $propbag->add('configuration', array('title',
                                             'timespan',
                                             'type',
        ));
        $this->dependencies = array('serendipity_event_communityrating' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'title':
                $propbag->add('type', 'string');
                $propbag->add('name', TITLE);
                $propbag->add('description', '');
                $propbag->add('default', $this->title);
            break;
            case 'timespan':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_COMMUNITYRATING_AVGRATING_TIMESPAN);
                $propbag->add('description', PLUGIN_EVENT_COMMUNITYRATING_AVGRATING_TIMESPAN_DESC);
                $propbag->add('default', 30);
            break;

            case 'type':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_COMMUNITYRATING_TYPES);
                $propbag->add('description', '');
                $propbag->add('default', 'IMDB');
            break;

            default:
                    return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        global $serendipity;
        $title       = $this->get_config('title', $this->title);
        $timespan    = $this->get_config('timespan', 30);
        $type        = $this->get_config('type', 'IMDB');

		$q = "SELECT ep.entryid AS id, e.title, e.timestamp, ep.value as rating

				  FROM {$serendipity['dbPrefix']}entryproperties AS ep
				  JOIN {$serendipity['dbPrefix']}entries AS e
				    ON e.id = ep.entryid

				 WHERE ep.property = 'cr_{$type}_rating'
				   AND e.timestamp > " . (time() - (86700 * (int)$timespan)) . "
				 ORDER BY ep.value DESC
				 LIMIT 5";

		$rows = serendipity_db_query($q);
		if (!is_array($rows)) {
		    echo "No movies during the last $timespan days! Maybe I dropped dead.";
		}

        echo '<ol class="movie {$type}">';

		foreach($rows AS $row) {
            $url = serendipity_archiveURL($row['id'],
                                          $row['title'],
                                          'serendipityHTTPPath',
                                          true,
                                          array('timestamp' => $row['timestamp']));
            echo '<li><a href="'. $url . '">' . htmlspecialchars($row['title']) . '</a> (' . ($row['rating']) . ')</li>';
		}
	    echo '</ol>';

    }
}

/* vim: set sts=4 ts=4 expandtab : */
