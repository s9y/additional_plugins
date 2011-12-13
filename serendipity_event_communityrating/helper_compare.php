<?php

// Compares two voting URLs.

$url1  = 'http://blog1/index.php?/plugin/communityrating_IMDB_all';
$url2  = 'http://blog2/index.php?/plugin/communityrating_IMDB_all';
$name1 = 'User A';
$name2 = 'User B';

// Main actions.
$ratings = array();
$ids     = array();

$c1 = file_get_contents($url1);
preg_match_all('@<communityrating>(.*)</communityrating>@imsU', $c1, $matches1);
unset($c1);

$c2 = file_get_contents($url2);
preg_match_all('@<communityrating>(.*)</communityrating>@imsU', $c2, $matches2);
unset($c2);

foreach($matches1[1] AS $rating) {
    preg_match('@<id>(.+)</id>@imsU', $rating, $matchA);
    preg_match('@<rating>(.+)</rating>@imsU', $rating, $matchB);
    $ratings[$matchA[1]][$name1] = $matchB[1];
    if (preg_match('@<url>(.+)</url>@imsU', $rating, $urlmatch)) {
        $ids[$matchA[1]] = $urlmatch[1];
    }
}
unset($matches1);

foreach($matches2[1] AS $rating) {
    preg_match('@<id>(.+)</id>@imsU', $rating, $matchA);
    preg_match('@<rating>(.+)</rating>@imsU', $rating, $matchB);
    $ratings[$matchA[1]][$name2] = $matchB[1];
    if (preg_match('@<url>(.+)</url>@imsU', $rating, $urlmatch)) {
        $ids[$matchA[1]] = $urlmatch[1];
    }
}
unset($matches2);

$diff = array();
$only1 = array();
$only2 = array();
foreach($ratings AS $id => $rating) {
    $_diff = abs($rating[$name1] - $rating[$name2]);

    $out = '<a href="' . $ids[$id] . '">' . $id . ' (' . basename($ids[$id]) . ')</a><br />';
    if ($rating[$name1] >= $rating[$name2]) {
        $out .= '<b>' . $name1 . ': ' . $rating[$name1] . '</b><br />';
    } else {
        $out .= $name1 . ': ' . $rating[$name1] . '<br />';
    }

    if ($rating[$name1] <= $rating[$name2]) {
        $out .= '<b>' . $name2 . ': ' . $rating[$name2] . '</b><br />';
    } else {
        $out .= $name2 . ': ' . $rating[$name2] . '<br />';
    }

    if (empty($rating[$name1])) {
        $only2[] = $out;
    } elseif (empty($rating[$name2])) {
        $only1[] = $out;
    } else {
        $diff[$_diff][] = $out;
    }
}

echo '<h1>Differences</h1>';
krsort($diff);
foreach($diff AS $_diff => $outs) {
    echo '<h2>Difference of ' . $_diff . '</h2>';
    echo implode('<br />', $outs);
}

echo '<h1>Only rated by ' . $name1 . '</h1>';
echo implode('<br />', $only1);

echo '<h1>Only rated by ' . $name2 . '</h1>';
echo implode('<br />', $only2);
