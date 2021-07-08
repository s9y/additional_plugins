<?php # 

// Google Last Query Plugin for Serendipity
// 10/2004 by Thomas Nesges <thomas@tnt-computer.de>

@define('PLUGIN_KARMARANKING_TITLE',                "Karma Ranking");


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_karmaranking extends serendipity_plugin {

    function introspect(&$propbag) {
        $propbag->add('name',           PLUGIN_KARMARANKING_TITLE);
        $propbag->add('description',    PLUGIN_KARMARANKING_DESC);
        $propbag->add('configuration',  array('title', 'count'));
        $propbag->add('version',     '1.1');
   	    $propbag->add('author',	'Andreas Brandmaier');
        $propbag->add('groups', array('STATISTICS'));
   }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'title':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_KARMARANKING_PROP_TITLE);
                $propbag->add('description',    PLUGIN_KARMARANKING_PROP_TITLE_DESC);
                $propbag->add('default',        PLUGIN_KARMARANKING_TITLE);
                break;

            case 'count':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_KARMARANKING_PROP_COUNT);
                $propbag->add('description',    PLUGIN_KARMARANKING_PROP_COUNT_DESC);
                $propbag->add('default',        '1');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        global $serendipity;

        $title = $this->get_config('title');
        $count = $this->get_config('count');
        if($count<1) {
            $count = 1;
        }

	$rows = serendipity_db_query("select {$serendipity['dbPrefix']}authors.username,
SUM({$serendipity['dbPrefix']}karma.points) as score, SUM({$serendipity['dbPrefix']}karma.votes) as
votes,SUM({$serendipity['dbPrefix']}karma.points) / SUM({$serendipity['dbPrefix']}karma.votes) as overall FROM
{$serendipity['dbPrefix']}entries, {$serendipity['dbPrefix']}karma, {$serendipity['dbPrefix']}authors WHERE {$serendipity['dbPrefix']}entries.id = {$serendipity['dbPrefix']}karma.entryid
AND {$serendipity['dbPrefix']}authors.authorid = {$serendipity['dbPrefix']}entries.authorid ".
 "GROUP BY {$serendipity['dbPrefix']}authors.username ORDER BY score DESC; ");

	echo "<table>";

	echo "<tr><th style='background-color: #DDDDDD'>".PLUGIN_KARMARANKING_AUTHOR."</th>";
	echo "<th style='background-color: #DDDDDD'>".PLUGIN_KARMARANKING_TOTAL."</th></tr>";

#var_dump($rows);

        foreach($rows as $row) {
		echo "<tr><td>".$row[0]."</td><td style='text-align: center'>".$row[1]."</td></tr>";
        }

	echo "</table>";

    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>