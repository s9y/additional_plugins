<?php

// IMDB Parser. Use at your own risk
$s9y        = '/home/garvin/cvs/serendipity/trunk/';
$imdb_input = file_get_contents('/www/imdb.htm');

chdir($s9y);
include 'serendipity_config.inc.php';
preg_match_all('@<td bgcolor="#FFFFFF" valign="middle" align="center">[^<]*<input type="checkbox" name="e" value=".*" >[^<]*</td>[^<]*<td bgcolor="#FFFFFF" class="standard">&nbsp;<a href="/title/([^/]*)/">.*</a>.*</td>[^<]*<td align="center" bgcolor="#FFFFFF">([0-9]+)</td><td align="center" bgcolor="#FFFFFF">@imsU',$imdb_input, $matches);

foreach($matches[2] AS $idx => $points) {
    $id = $matches[1][$idx];

    $sql = "INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value) VALUES (0, 'cr_IMDB_rating:{$id}', '{$points}')";
    echo $sql . "<br />\n";
    serendipity_db_query($sql);
}